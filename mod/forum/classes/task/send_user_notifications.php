<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file defines an adhoc task to send notifications.
 *
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\task;

defined('MOODLE_INTERNAL') || die();

/**
 * Adhoc task to send user forum notifications.
 *
 * @package    mod_forum
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class send_user_notifications extends \core\task\adhoc_task {

    /**
     * A shortcut to $USER.
     */
    protected $recipient;

    /**
     * List of courses the messages are in, indexed by courseid.
     */
    protected $courses = [];

    /**
     * List of forums the messages are in, indexed by courseid.
     */
    protected $forums = [];

    /**
     * List of discussions the messages are in, indexed by forumid.
     */
    protected $discussions = [];

    /**
     * List of posts the messages are in, indexed by discussionid.
     */
    protected $posts = [];

    /**
     * Whether the user can view fullnames for each forum.
     */
    protected $viewfullnames = [];

    /**
     * Whether the user can post in each discussion.
     */
    protected $canpost = [];

    /**
     * Whether the user has requested HTML or not.
     */
    protected $allowhtml = true;

    /**
     * The renderers.
     */
    protected $renderers = [];

    /**
     * The inbound message address manager.
     */
    protected $inboundmanager;

    /**
     * Send out messages.
     */
    public function execute() {
        global $USER;

        $this->recipient = $USER;

        // Create the generic messageinboundgenerator.
        $this->inboundmanager = new \core\message\inbound\address_manager();
        $this->inboundmanager->set_handler('\mod_forum\message\inbound\reply_handler');

        $data = $this->get_custom_data();

        $this->prepare_data((array) $data->postids);

        if (empty($this->recipient->mailformat) || $this->recipient->mailformat != 1) {
            // This user does not want to receive HTML
            $this->allowhtml = false;
        }

        foreach ((array) $data->poststructure as $courseid => $forumids) {
            $course = $this->courses[$courseid];
            foreach ($forumids as $forumid => $discussionids) {
                $forum = $this->forums[$forumid];
                $cm = get_fast_modinfo($course)->instances['forum'][$forumid];
                $modcontext = \context_module::instance($cm->id);
                foreach ($discussionids as $discussionid => $postids) {
                    $discussion = $this->discussions[$discussionid];
                    if (!\mod_forum\subscriptions::is_subscribed($user->id, $forum, $discussionid, $cm)) {
                        // The user does not subscribe to this forum as a whole, or to this specific discussion.
                        continue;
                    }

                    foreach ($postids as $postid) {
                        if (!forum_user_can_see_post($forum, $discussion, $post, $this->recipient, $cm)) {
                            // User cannot see this post.
                            // Permissions may have changed since it was queued.
                            continue;
                        }

                        $this->send_post($post, $discussion, $forum, $cm, $course);
                        $post = $this->posts[$postid];
                        $author = $this->get_post_author($post->userid);



                        // Prepare to actually send the post now, and build up the content.
                        $cleanforumname = str_replace('"', "'", strip_tags(format_string($forum->name)));

                        $author->customheaders = array (
                            // Headers to make emails easier to track.
                            'List-Id: "'        . $cleanforumname . '" ' . generate_email_messageid('moodleforum' . $forum->id),
                            'List-Help: '       . $CFG->wwwroot . '/mod/forum/view.php?f=' . $forum->id,
                            'Message-ID: '      . forum_get_email_message_id($post->id, $userto->id),
                            'X-Course-Id: '     . $course->id,
                            'X-Course-Name: '   . format_string($course->fullname, true),

                            // Headers to help prevent auto-responders.
                            'Precedence: Bulk',
                            'X-Auto-Response-Suppress: All',
                            'Auto-Submitted: auto-generated',
                        );

                        $shortname = format_string($course->shortname, true, array('context' => context_course::instance($course->id)));

                        // Generate a reply-to address from using the Inbound Message handler.
                        $replyaddress = null;
                        if ($userto->canpost[$discussion->id] && array_key_exists($post->id, $messageinboundhandlers)) {
                            $messageinboundgenerator->set_data($post->id, $messageinboundhandlers[$post->id]);
                            $replyaddress = $messageinboundgenerator->generate($userto->id);
                        }

                        if (!isset($userto->canpost[$discussion->id])) {
                            $canreply = forum_user_can_post($forum, $discussion, $userto, $cm, $course, $modcontext);
                        } else {
                            $canreply = $userto->canpost[$discussion->id];
                        }

                        $data = new \mod_forum\output\forum_post_email(
                            $course,
                            $cm,
                            $forum,
                            $discussion,
                            $post,
                            $userfrom,
                            $userto,
                            $canreply
                        );

                        $userfrom->customheaders[] = sprintf('List-Unsubscribe: <%s>',
                            $data->get_unsubscribediscussionlink());

                        if (!isset($userto->viewfullnames[$forum->id])) {
                            $data->viewfullnames = has_capability('moodle/site:viewfullnames', $modcontext, $userto->id);
                        } else {
                            $data->viewfullnames = $userto->viewfullnames[$forum->id];
                        }

                        // Not all of these variables are used in the default language
                        // string but are made available to support custom subjects.
                        $a = new stdClass();
                        $a->subject = $data->get_subject();
                        $a->forumname = $cleanforumname;
                        $a->sitefullname = format_string($site->fullname);
                        $a->siteshortname = format_string($site->shortname);
                        $a->courseidnumber = $data->get_courseidnumber();
                        $a->coursefullname = $data->get_coursefullname();
                        $a->courseshortname = $data->get_coursename();
                        $postsubject = html_to_text(get_string('postmailsubject', 'forum', $a), 0);

                        $rootid = forum_get_email_message_id($discussion->firstpost, $userto->id);

                        if ($post->parent) {
                            // This post is a reply, so add reply header (RFC 2822).
                            $parentid = forum_get_email_message_id($post->parent, $userto->id);
                            $userfrom->customheaders[] = "In-Reply-To: $parentid";

                            // If the post is deeply nested we also reference the parent message id and
                            // the root message id (if different) to aid threading when parts of the email
                            // conversation have been deleted (RFC1036).
                            if ($post->parent != $discussion->firstpost) {
                                $userfrom->customheaders[] = "References: $rootid $parentid";
                            } else {
                                $userfrom->customheaders[] = "References: $parentid";
                            }
                        }

                        // MS Outlook / Office uses poorly documented and non standard headers, including
                        // Thread-Topic which overrides the Subject and shouldn't contain Re: or Fwd: etc.
                        $a->subject = $discussion->name;
                        $threadtopic = html_to_text(get_string('postmailsubject', 'forum', $a), 0);
                        $userfrom->customheaders[] = "Thread-Topic: $threadtopic";
                        $userfrom->customheaders[] = "Thread-Index: " . substr($rootid, 1, 28);

                        // Send the post now!
                        mtrace('Sending ', '');

                        $eventdata = new \core\message\message();
                        $eventdata->courseid            = $course->id;
                        $eventdata->component           = 'mod_forum';
                        $eventdata->name                = 'posts';
                        $eventdata->userfrom            = $userfrom;
                        $eventdata->userto              = $userto;
                        $eventdata->subject             = $postsubject;
                        $eventdata->fullmessage         = $textout->render($data);
                        $eventdata->fullmessageformat   = FORMAT_PLAIN;
                        $eventdata->fullmessagehtml     = $htmlout->render($data);
                        $eventdata->notification        = 1;
                        $eventdata->replyto             = $replyaddress;
                        if (!empty($replyaddress)) {
                            // Add extra text to email messages if they can reply back.
                            $textfooter = "\n\n" . get_string('replytopostbyemail', 'mod_forum');
                            $htmlfooter = html_writer::tag('p', get_string('replytopostbyemail', 'mod_forum'));
                            $additionalcontent = array('fullmessage' => array('footer' => $textfooter),
                                'fullmessagehtml' => array('footer' => $htmlfooter));
                            $eventdata->set_additional_content('email', $additionalcontent);
                        }

                        $smallmessagestrings = new stdClass();
                        $smallmessagestrings->user          = fullname($userfrom);
                        $smallmessagestrings->forumname     = "$shortname: " . format_string($forum->name, true) . ": " . $discussion->name;
                        $smallmessagestrings->message       = $post->message;

                        // Make sure strings are in message recipients language.
                        $eventdata->smallmessage = get_string_manager()->get_string('smallmessage', 'forum', $smallmessagestrings, $userto->lang);

                        $contexturl = new moodle_url('/mod/forum/discuss.php', array('d' => $discussion->id), 'p' . $post->id);
                        $eventdata->contexturl = $contexturl->out();
                        $eventdata->contexturlname = $discussion->name;

                        $mailresult = message_send($eventdata);
                        if (!$mailresult) {
                            mtrace("Error: mod/forum/lib.php forum_cron(): Could not send out mail for id $post->id to user $userto->id".
                                " ($userto->email) .. not trying again.");
                            $errorcount[$post->id]++;
                        } else {
                            $mailcount[$post->id]++;

                            // Mark post as read if forum_usermarksread is set off.
                            if (!$CFG->forum_usermarksread) {
                                $userto->markposts[$post->id] = $post->id;
                            }
                        }

                        //mtrace('post ' . $post->id . ': ' . $post->subject . " to {$userto->id}");
                        mtrace("post {$post->id}: to {$userto->id}");
                    }
                }
            }
        }
    }

    /**
     * Prepare the data for this run.
     * Note: This will also remove posts from the queue.
     */
    protected function prepare_data($postids) {
        global $USER, $DB;

        list($in, $params) = $DB->get_in_or_equal(array_values($postids));
        $sql = "SELECT p.*, f.id AS forum, f.course
                  FROM {forum_posts} p
            INNER JOIN {forum_discussions} d ON d.id = p.discussion
            INNER JOIN {forum} f ON f.id = d.forum
                 WHERE p.id {$in}";

        $posts = $DB->get_recordset_sql($sql, $params);
        $discussionids = [];
        $forumids = [];
        $courseids = [];
        $userids = [];
        foreach ($posts as $post) {
            $discussionids[] = $post->discussion;
            $forumids[] = $post->forum;
            $courseids[] = $post->course;
            $userids[] = $post->userid;
            unset($post->forum);
            if (!isset($this->posts[$post->discussion])) {
                $this->posts[$post->discussion] = [];
            }
            $this->posts[$post->discussion][$post->id] = $post;
        }
        $posts->close();

        list($in, $params) = $DB->get_in_or_equal(array_values($discussionids));
        $this->discussions = $DB->get_records_select('forum_discussions', "id {$in}", $params);

        list($in, $params) = $DB->get_in_or_equal(array_values($forumids));
        $this->forums = $DB->get_records_select('forum', "id {$in}", $params);

        list($in, $params) = $DB->get_in_or_equal(array_values($courseids));
        $this->courses = $DB->get_records_select('course', "id $in", $params);

        list($in, $params) = $DB->get_in_or_equal(array_values($userids));
        $this->users = $DB->get_records_select('user', "id $in", $params);

        foreach (array_values($forumids) as $id) {
            \mod_forum\subscriptions::fill_subscription_cache($id);
            \mod_forum\subscriptions::fill_discussion_subscription_cache($id);
        }

        // TODO: Uncomment
        //$DB->delete_records_select('forum_queue', "userid = :userid AND timemodified < :timemodified", $params);
    }

    protected function send_post($post, $discussion, $forum, $cm, $course) {
        global $CFG;
        $post = $this->posts[$postid];
        $author = $this->get_post_author($post->userid);

        // Prepare to actually send the post now, and build up the content.
        $cleanforumname = str_replace('"', "'", strip_tags(format_string($forum->name)));

        $author->customheaders = array (
            // Headers to make emails easier to track.
            'List-Id: "' . $cleanforumname . '" ' . generate_email_messageid('moodleforum' . $forum->id),
            'List-Help: ' . $CFG->wwwroot . '/mod/forum/view.php?f=' . $forum->id,
            'Message-ID: ' . forum_get_email_message_id($post->id, $userto->id),
            'X-Course-Id: ' . $course->id,
            'X-Course-Name: '. format_string($course->fullname, true),

            // Headers to help prevent auto-responders.
            'Precedence: Bulk',
            'X-Auto-Response-Suppress: All',
            'Auto-Submitted: auto-generated',
        );

        $shortname = format_string($course->shortname, true, array('context' => context_course::instance($course->id)));

        // Generate a reply-to address from using the Inbound Message handler.
        $replyaddress = null;
        if ($userto->canpost[$discussion->id] && array_key_exists($post->id, $messageinboundhandlers)) {
            $messageinboundgenerator->set_data($post->id, $messageinboundhandlers[$post->id]);
            $replyaddress = $messageinboundgenerator->generate($userto->id);
        }

        if (!isset($userto->canpost[$discussion->id])) {
            $canreply = forum_user_can_post($forum, $discussion, $userto, $cm, $course, $modcontext);
        } else {
            $canreply = $userto->canpost[$discussion->id];
        }

        $data = new \mod_forum\output\forum_post_email(
            $course,
            $cm,
            $forum,
            $discussion,
            $post,
            $userfrom,
            $userto,
            $canreply
        );

        $userfrom->customheaders[] = sprintf('List-Unsubscribe: <%s>',
            $data->get_unsubscribediscussionlink());

        if (!isset($userto->viewfullnames[$forum->id])) {
            $data->viewfullnames = has_capability('moodle/site:viewfullnames', $modcontext, $userto->id);
        } else {
            $data->viewfullnames = $userto->viewfullnames[$forum->id];
        }

        // Not all of these variables are used in the default language
        // string but are made available to support custom subjects.
        $a = new stdClass();
        $a->subject = $data->get_subject();
        $a->forumname = $cleanforumname;
        $a->sitefullname = format_string($site->fullname);
        $a->siteshortname = format_string($site->shortname);
        $a->courseidnumber = $data->get_courseidnumber();
        $a->coursefullname = $data->get_coursefullname();
        $a->courseshortname = $data->get_coursename();
        $postsubject = html_to_text(get_string('postmailsubject', 'forum', $a), 0);

        $rootid = forum_get_email_message_id($discussion->firstpost, $userto->id);

        if ($post->parent) {
            // This post is a reply, so add reply header (RFC 2822).
            $parentid = forum_get_email_message_id($post->parent, $userto->id);
            $userfrom->customheaders[] = "In-Reply-To: $parentid";

            // If the post is deeply nested we also reference the parent message id and
            // the root message id (if different) to aid threading when parts of the email
            // conversation have been deleted (RFC1036).
            if ($post->parent != $discussion->firstpost) {
                $userfrom->customheaders[] = "References: $rootid $parentid";
            } else {
                $userfrom->customheaders[] = "References: $parentid";
            }
        }

        // MS Outlook / Office uses poorly documented and non standard headers, including
        // Thread-Topic which overrides the Subject and shouldn't contain Re: or Fwd: etc.
        $a->subject = $discussion->name;
        $threadtopic = html_to_text(get_string('postmailsubject', 'forum', $a), 0);
        $userfrom->customheaders[] = "Thread-Topic: $threadtopic";
        $userfrom->customheaders[] = "Thread-Index: " . substr($rootid, 1, 28);

        // Send the post now!
        mtrace('Sending ', '');

        $eventdata = new \core\message\message();
        $eventdata->courseid            = $course->id;
        $eventdata->component           = 'mod_forum';
        $eventdata->name                = 'posts';
        $eventdata->userfrom            = $userfrom;
        $eventdata->userto              = $userto;
        $eventdata->subject             = $postsubject;
        $eventdata->fullmessage         = $textout->render($data);
        $eventdata->fullmessageformat   = FORMAT_PLAIN;
        $eventdata->fullmessagehtml     = $htmlout->render($data);
        $eventdata->notification        = 1;
        $eventdata->replyto             = $replyaddress;
        if (!empty($replyaddress)) {
            // Add extra text to email messages if they can reply back.
            $textfooter = "\n\n" . get_string('replytopostbyemail', 'mod_forum');
            $htmlfooter = html_writer::tag('p', get_string('replytopostbyemail', 'mod_forum'));
            $additionalcontent = array('fullmessage' => array('footer' => $textfooter),
                'fullmessagehtml' => array('footer' => $htmlfooter));
            $eventdata->set_additional_content('email', $additionalcontent);
        }

        $smallmessagestrings = new stdClass();
        $smallmessagestrings->user          = fullname($userfrom);
        $smallmessagestrings->forumname     = "$shortname: " . format_string($forum->name, true) . ": " . $discussion->name;
        $smallmessagestrings->message       = $post->message;

        // Make sure strings are in message recipients language.
        $eventdata->smallmessage = get_string_manager()->get_string('smallmessage', 'forum', $smallmessagestrings, $userto->lang);

        $contexturl = new moodle_url('/mod/forum/discuss.php', array('d' => $discussion->id), 'p' . $post->id);
        $eventdata->contexturl = $contexturl->out();
        $eventdata->contexturlname = $discussion->name;

        $mailresult = message_send($eventdata);
        if (!$mailresult) {
            mtrace("Error: mod/forum/lib.php forum_cron(): Could not send out mail for id $post->id to user $userto->id".
                " ($userto->email) .. not trying again.");
            $errorcount[$post->id]++;
        } else {
            $mailcount[$post->id]++;

            // Mark post as read if forum_usermarksread is set off.
            if (!$CFG->forum_usermarksread) {
                $userto->markposts[$post->id] = $post->id;
            }
        }

        //mtrace('post ' . $post->id . ': ' . $post->subject . " to {$userto->id}");
        mtrace("post {$post->id}: to {$userto->id}");
    }

    protected function old() {
        // Terminate if processing of any account takes longer than 2 minutes.
        core_php_time_limit::raise(120);

        mtrace('Processing user ' . $userto->id);

        // Init user caches - we keep the cache for one cycle only, otherwise it could consume too much memory.
        if (isset($userto->username)) {
            $userto = clone($userto);
        } else {
            $userto = $DB->get_record('user', array('id' => $userto->id));
            forum_cron_minimise_user_record($userto);
        }
        $userto->viewfullnames = array();
        $userto->canpost       = array();
        $userto->markposts     = array();

        // Setup this user so that the capabilities are cached, and environment matches receiving user.
        cron_setup_user($userto);

        // Reset the caches.
        foreach ($coursemodules as $forumid => $unused) {
            $coursemodules[$forumid]->cache       = new stdClass();
            $coursemodules[$forumid]->cache->caps = array();
            unset($coursemodules[$forumid]->uservisible);
        }

        foreach ($posts as $pid => $post) {
            $discussion = $discussions[$post->discussion];
            $forum      = $forums[$discussion->forum];
            $course     = $courses[$forum->course];
            $cm         =& $coursemodules[$forum->id];

            // Do some checks to see if we can bail out now.

            // Only active enrolled users are in the list of subscribers.
            // This does not necessarily mean that the user is subscribed to the forum or to the discussion though.
            if (!isset($subscribedusers[$forum->id][$userto->id])) {
                // The user does not subscribe to this forum.
                continue;
            }

            if (!\mod_forum\subscriptions::is_subscribed($userto->id, $forum, $post->discussion, $coursemodules[$forum->id])) {
                // The user does not subscribe to this forum, or to this specific discussion.
                continue;
            }

            if ($subscriptiontime = \mod_forum\subscriptions::fetch_discussion_subscription($forum->id, $userto->id)) {
                // Skip posts if the user subscribed to the discussion after it was created.
                if (isset($subscriptiontime[$post->discussion]) && ($subscriptiontime[$post->discussion] > $post->created)) {
                    continue;
                }
            }

            // Don't send email if the forum is Q&A and the user has not posted.
            // Initial topics are still mailed.
            if ($forum->type == 'qanda' && !forum_get_user_posted_time($discussion->id, $userto->id) && $pid != $discussion->firstpost) {
                mtrace('Did not email ' . $userto->id.' because user has not posted in discussion');
                continue;
            }

            // Get info about the sending user.
            if (array_key_exists($post->userid, $users)) {
                // We might know the user already.
                $userfrom = $users[$post->userid];
                if (!isset($userfrom->idnumber)) {
                    // Minimalised user info, fetch full record.
                    $userfrom = $DB->get_record('user', array('id' => $userfrom->id));
                    forum_cron_minimise_user_record($userfrom);
                }

            } else if ($userfrom = $DB->get_record('user', array('id' => $post->userid))) {
                forum_cron_minimise_user_record($userfrom);
                // Fetch only once if possible, we can add it to user list, it will be skipped anyway.
                if ($userscount <= FORUM_CRON_USER_CACHE) {
                    $userscount++;
                    $users[$userfrom->id] = $userfrom;
                }
            } else {
                mtrace('Could not find user ' . $post->userid . ', author of post ' . $post->id . '. Unable to send message.');
                continue;
            }

            // Note: If we want to check that userto and userfrom are not the same person this is probably the spot to do it.

            // Setup global $COURSE properly - needed for roles and languages.
            cron_setup_user($userto, $course);

            // Fill caches.
            if (!isset($userto->viewfullnames[$forum->id])) {
                $modcontext = context_module::instance($cm->id);
                $userto->viewfullnames[$forum->id] = has_capability('moodle/site:viewfullnames', $modcontext);
            }
            if (!isset($userto->canpost[$discussion->id])) {
                $modcontext = context_module::instance($cm->id);
                $userto->canpost[$discussion->id] = forum_user_can_post($forum, $discussion, $userto, $cm, $course, $modcontext);
            }
            if (!isset($userfrom->groups[$forum->id])) {
                if (!isset($userfrom->groups)) {
                    $userfrom->groups = array();
                    if (isset($users[$userfrom->id])) {
                        $users[$userfrom->id]->groups = array();
                    }
                }
                $userfrom->groups[$forum->id] = groups_get_all_groups($course->id, $userfrom->id, $cm->groupingid);
                if (isset($users[$userfrom->id])) {
                    $users[$userfrom->id]->groups[$forum->id] = $userfrom->groups[$forum->id];
                }
            }

            // Make sure groups allow this user to see this email.
            if ($discussion->groupid > 0 and $groupmode = groups_get_activity_groupmode($cm, $course)) {
                // Groups are being used.
                if (!groups_group_exists($discussion->groupid)) {
                    // Can't find group - be safe and don't this message.
                    continue;
                }

                if (!groups_is_member($discussion->groupid) and !has_capability('moodle/site:accessallgroups', $modcontext)) {
                    // Do not send posts from other groups when in SEPARATEGROUPS or VISIBLEGROUPS.
                    continue;
                }
            }

            // Make sure we're allowed to see the post.
            if (!forum_user_can_see_post($forum, $discussion, $post, null, $cm)) {
                mtrace('User ' . $userto->id .' can not see ' . $post->id . '. Not sending message.');
                continue;
            }

            // Prepare to actually send the post now, and build up the content.
            $cleanforumname = str_replace('"', "'", strip_tags(format_string($forum->name)));

            $userfrom->customheaders = array (
                // Headers to make emails easier to track.
                'List-Id: "'        . $cleanforumname . '" ' . generate_email_messageid('moodleforum' . $forum->id),
                'List-Help: '       . $CFG->wwwroot . '/mod/forum/view.php?f=' . $forum->id,
                'Message-ID: '      . forum_get_email_message_id($post->id, $userto->id),
                'X-Course-Id: '     . $course->id,
                'X-Course-Name: '   . format_string($course->fullname, true),

                // Headers to help prevent auto-responders.
                'Precedence: Bulk',
                'X-Auto-Response-Suppress: All',
                'Auto-Submitted: auto-generated',
            );

            $shortname = format_string($course->shortname, true, array('context' => context_course::instance($course->id)));

            // Generate a reply-to address from using the Inbound Message handler.
            $replyaddress = null;
            if ($userto->canpost[$discussion->id] && array_key_exists($post->id, $messageinboundhandlers)) {
                $messageinboundgenerator->set_data($post->id, $messageinboundhandlers[$post->id]);
                $replyaddress = $messageinboundgenerator->generate($userto->id);
            }

            if (!isset($userto->canpost[$discussion->id])) {
                $canreply = forum_user_can_post($forum, $discussion, $userto, $cm, $course, $modcontext);
            } else {
                $canreply = $userto->canpost[$discussion->id];
            }

            $data = new \mod_forum\output\forum_post_email(
                $course,
                $cm,
                $forum,
                $discussion,
                $post,
                $userfrom,
                $userto,
                $canreply
            );

            $userfrom->customheaders[] = sprintf('List-Unsubscribe: <%s>',
                $data->get_unsubscribediscussionlink());

            if (!isset($userto->viewfullnames[$forum->id])) {
                $data->viewfullnames = has_capability('moodle/site:viewfullnames', $modcontext, $userto->id);
            } else {
                $data->viewfullnames = $userto->viewfullnames[$forum->id];
            }

            // Not all of these variables are used in the default language
            // string but are made available to support custom subjects.
            $a = new stdClass();
            $a->subject = $data->get_subject();
            $a->forumname = $cleanforumname;
            $a->sitefullname = format_string($site->fullname);
            $a->siteshortname = format_string($site->shortname);
            $a->courseidnumber = $data->get_courseidnumber();
            $a->coursefullname = $data->get_coursefullname();
            $a->courseshortname = $data->get_coursename();
            $postsubject = html_to_text(get_string('postmailsubject', 'forum', $a), 0);

            $rootid = forum_get_email_message_id($discussion->firstpost, $userto->id);

            if ($post->parent) {
                // This post is a reply, so add reply header (RFC 2822).
                $parentid = forum_get_email_message_id($post->parent, $userto->id);
                $userfrom->customheaders[] = "In-Reply-To: $parentid";

                // If the post is deeply nested we also reference the parent message id and
                // the root message id (if different) to aid threading when parts of the email
                // conversation have been deleted (RFC1036).
                if ($post->parent != $discussion->firstpost) {
                    $userfrom->customheaders[] = "References: $rootid $parentid";
                } else {
                    $userfrom->customheaders[] = "References: $parentid";
                }
            }

            // MS Outlook / Office uses poorly documented and non standard headers, including
            // Thread-Topic which overrides the Subject and shouldn't contain Re: or Fwd: etc.
            $a->subject = $discussion->name;
            $threadtopic = html_to_text(get_string('postmailsubject', 'forum', $a), 0);
            $userfrom->customheaders[] = "Thread-Topic: $threadtopic";
            $userfrom->customheaders[] = "Thread-Index: " . substr($rootid, 1, 28);

            // Send the post now!
            mtrace('Sending ', '');

            $eventdata = new \core\message\message();
            $eventdata->courseid            = $course->id;
            $eventdata->component           = 'mod_forum';
            $eventdata->name                = 'posts';
            $eventdata->userfrom            = $userfrom;
            $eventdata->userto              = $userto;
            $eventdata->subject             = $postsubject;
            $eventdata->fullmessage         = $textout->render($data);
            $eventdata->fullmessageformat   = FORMAT_PLAIN;
            $eventdata->fullmessagehtml     = $htmlout->render($data);
            $eventdata->notification        = 1;
            $eventdata->replyto             = $replyaddress;
            if (!empty($replyaddress)) {
                // Add extra text to email messages if they can reply back.
                $textfooter = "\n\n" . get_string('replytopostbyemail', 'mod_forum');
                $htmlfooter = html_writer::tag('p', get_string('replytopostbyemail', 'mod_forum'));
                $additionalcontent = array('fullmessage' => array('footer' => $textfooter),
                    'fullmessagehtml' => array('footer' => $htmlfooter));
                $eventdata->set_additional_content('email', $additionalcontent);
            }

            $smallmessagestrings = new stdClass();
            $smallmessagestrings->user          = fullname($userfrom);
            $smallmessagestrings->forumname     = "$shortname: " . format_string($forum->name, true) . ": " . $discussion->name;
            $smallmessagestrings->message       = $post->message;

            // Make sure strings are in message recipients language.
            $eventdata->smallmessage = get_string_manager()->get_string('smallmessage', 'forum', $smallmessagestrings, $userto->lang);

            $contexturl = new moodle_url('/mod/forum/discuss.php', array('d' => $discussion->id), 'p' . $post->id);
            $eventdata->contexturl = $contexturl->out();
            $eventdata->contexturlname = $discussion->name;

            $mailresult = message_send($eventdata);
            if (!$mailresult) {
                mtrace("Error: mod/forum/lib.php forum_cron(): Could not send out mail for id $post->id to user $userto->id".
                    " ($userto->email) .. not trying again.");
                $errorcount[$post->id]++;
            } else {
                $mailcount[$post->id]++;

                // Mark post as read if forum_usermarksread is set off.
                if (!$CFG->forum_usermarksread) {
                    $userto->markposts[$post->id] = $post->id;
                }
            }

            //mtrace('post ' . $post->id . ': ' . $post->subject . " to {$userto->id}");
            mtrace("post {$post->id}: to {$userto->id}");
        }

        // Mark processed posts as read.
        //if (get_user_preferences('forum_markasreadonnotification', 1, $userto->id) == 1) {
        //forum_tp_mark_posts_read($userto, $userto->markposts);
        //}
    }

    /**
     * Fetch and initialise the post author.
     *
     * @param   int     $userid The id of the user to fetch
     * @return  \stdClass
     */
    protected function get_post_author($userid) {
        if (!isset($this->users[$userid])) {
            return false;
        }

        $user = $this->users[$userid];

        if (!isset($user->groups)) {
            // Initialise the groups list.
            $user->groups = [];
        }

        return $user;
    }

    /**
     * Helper to fetch the required renderer, instantiating as required.
     *
     * @param   bool    $html Whether to fetch the HTML renderer
     * @return  \core_renderer
     */
    protected function get_renderer($html = false) {
        global $PAGE;

        $target = $html ? 'htmlemail' : 'textemail';

        if (!isset($this->renderers[$target])) {
            $this->renderers[$target] = $PAGE->get_renderer('mod_forum', 'email', $target);
        }

        return $this->renderers[$target];
    }
}
