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

use html_writer;
require_once($CFG->dirroot . '/mod/forum/lib.php');

/**
 * Adhoc task to send moodle forum digests for the specified user.
 *
 * @package    mod_forum
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class send_user_digests extends \core\task\adhoc_task {

    /**
     * A shortcut to $USER.
     */
    protected $recipient;

    /**
     * Whether the user can view fullnames for each forum.
     */
    protected $viewfullnames = [];

    /**
     * Whether the user can post in each forum.
     */
    protected $canpost = [];

    protected $courses = [];

    protected $forums = [];

    protected $discussions = [];

    protected $posts = [];

    protected $users = [];

    protected $forumdigesttypes = [];

    /**
     * Whether the user has requested HTML or not.
     */
    protected $allowhtml = true;

    /**
     * The subject of the message.
     */
    protected $postsubject = '';

    /**
     * The plaintext content of the whole message.
     */
    protected $notificationtext = '';

    /**
     * The HTML content of the whole message.
     */
    protected $notificationhtml = '';

    /**
     * The plaintext content for this discussion.
     */
    protected $discussiontext = '';

    /**
     * The HTML content for this discussion.
     */
    protected $discussionhtml = '';

    /**
     * The number of messages in the current discussion.
     */
    protected $discussionpostcount = 0;

    /**
     * The number of messages sent in this digest.
     */
    protected $sentcount = 0;

    /**
     * The renderers.
     */
    protected $renderers = [
        'html' => [],
        'text' => [],
    ];

    /**
     * A list of post IDs to be marked as read for this user.
     */
    protected $markpostsasread = [];

    /**
     * Send out messages.
     */
    public function execute() {
        global $USER;

        // Terminate if not able to fetch all digests in 5 minutes.
        \core_php_time_limit::raise(300);

        $this->recipient = $USER;
        mtrace("Sending forum digests for {$this->recipient->id}");

        if (empty($this->recipient->mailformat) || $this->recipient->mailformat != 1) {
            // This user does not want to receive HTML
            $this->allowhtml = false;
        }

        // Fetch all of the data we need to mail these posts.
        $this->prepare_data();

        // Add the message headers.
        $this->add_message_header();

        // TODO: Consider changing the ordering around.
        foreach ($this->discussions as $discussion) {
            // Raise the time limit for each discussion.
            \core_php_time_limit::raise(120);

            // Grab the data pertaining to this discussion.
            $forum = $this->forums[$discussion->forum];
            $course = $this->courses[$forum->course];
            $cm = get_fast_modinfo($course)->instances['forum'][$forum->id];
            $modcontext = \context_module::instance($cm->id);

            // Fetch additional values relating to this forum.
            if (!isset($this->canpost[$discussion->id])) {
                $this->canpost[$discussion->id] = forum_user_can_post($forum, $discussion, $this->recipient, $cm, $course, $modcontext);
            }

            if (!isset($this->viewfullnames[$forum->id])) {
                $this->viewfullnames = has_capability('moodle/site:viewfullnames', $modcontext, $this->recipient->id);
            }

            // Add the header for this discussion.
            $this->add_discussion_header($discussion, $forum, $course);

            // Add all posts in this forum.
            foreach ($this->posts[$discussion->id] as $post) {
                $author = $this->get_post_author($post->userid);
                if (empty($author)) {
                    // Unable to find the author. Skip to avoid errors.
                    continue;
                }

                if (!forum_user_can_see_post($forum, $discussion, $post, $this->recipient, $cm)) {
                    // User cannot see this post.
                    // Permissions may have changed since it was queued.
                    continue;
                }

                if (!isset($author->groups[$forum->id])) {
                    // Fill the list of groups for this author.
                    $author->groups[$forum->id] = groups_get_all_groups($course->id, $author->id, $cm->groupingid);
                }


                $this->add_post_body($author, $post, $discussion, $forum, $cm, $course);
                $this->discussionpostcount++;
            }

            // Add the forum footer.
            $this->add_discussion_footer($discussion, $forum, $course);
            $this->add_discussion_to_notification();
        }

        if ($this->sentcount) {
            // This digest has at least one post and should therefore be sent.
            $this->send_mail();
        }

        // We have finishied all digest emails, update $CFG->digestmailtimelast
        //set_config('digestmailtimelast', $timenow);
    }

    /**
     * Prepare the data for this run.
     * Note: This will also remove posts from the queue.
     */
    protected function prepare_data() {
        global $USER, $DB;

        $timenow = time();

        $sql = "SELECT p.*, f.id AS forum, f.course
                  FROM {forum_queue} q
            INNER JOIN {forum_posts} p ON p.id = q.postid
            INNER JOIN {forum_discussions} d ON d.id = p.discussion
            INNER JOIN {forum} f ON f.id = d.forum
                 WHERE q.userid = :userid
                   AND q.timemodified < :timemodified
              ORDER BY d.id, q.timemodified ASC";

        $params = [
                'userid' => $USER->id,
                'timemodified' => $timenow,
            ];

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

        $this->fill_digest_cache();

        // TODO: Uncomment
        //$DB->delete_records_select('forum_queue', "userid = :userid AND timemodified < :timemodified", $params);
    }

    protected function fill_digest_cache() {
        global $DB;
        $this->forumdigesttypes = $DB->get_record('forum_digests', [
                'userid' => $this->recipient->id,
            ], 'forum, maildigest');
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
     * Add the header to this message.
     */
    protected function add_message_header() {
        global $USER;

        $site = get_site();

        // Set the subject of the message.
        $this->postsubject = get_string('digestmailsubject', 'forum', format_string($site->shortname, true));

        // And the content of the header in body.
        $headerdata = (object) [
            'sitename' => format_string($site->fullname, true),
            'userprefs' => (new \moodle_url('/user/forum.php', [
                    'id' => $USER->id,
                    'course' => $site->id,
                ]))->out(false),
            ];

        $this->notificationtext .= get_string('digestmailheader', 'forum', $headerdata) . "\n";

        if ($this->allowhtml) {
            $headerdata->userprefs = html_writer::link($headerdata->userprefs, get_string('digestmailprefs', 'forum'), [
                    'target' => '_blank',
                ]);

            $this->notificationhtml .= html_writer::tag('p', get_string('digestmailheader', 'forum', $headerdata));
            $this->notificationhtml .= html_writer::empty_tag('br');
            $this->notificationhtml .= html_writer::empty_tag('hr', [
                    'size' => 1,
                    'noshade' => 'noshade',
                ]);
        }
    }

    /**
     * Add the header for this discussion.
     *
     * @param   \stdClass   $discussion The discussion to add the footer for
     * @param   \stdClass   $forum The forum that the discussion belongs to
     * @param   \stdClass   $course The course that the forum belongs to
     */
    protected function add_discussion_header($discussion, $forum, $course) {
        global $CFG;

        $shortname = format_string($course->shortname, true, [
                'context' => \context_course::instance($course->id),
            ]);

        $strforums = get_string('forums', 'forum');

        $this->discussiontext .= "\n=====================================================================\n\n";
        $this->discussiontext .= "$shortname -> $strforums -> " . format_string($forum->name, true);
        if ($discussion->name != $forum->name) {
            $this->discussiontext  .= " -> " . format_string($discussion->name, true);
        }
        $this->discussiontext .= "\n";
        $this->discussiontext .= new \moodle_url('/mod/forum/discuss.php', [
                'd' => $discussion->id,
            ]);
        $this->discussiontext .= "\n";

        if ($this->allowhtml) {
            $this->discussionhtml .= "<p><font face=\"sans-serif\">".
                "<a target=\"_blank\" href=\"$CFG->wwwroot/course/view.php?id=$course->id\">$shortname</a> -> ".
                "<a target=\"_blank\" href=\"$CFG->wwwroot/mod/forum/index.php?id=$course->id\">$strforums</a> -> ".
                "<a target=\"_blank\" href=\"$CFG->wwwroot/mod/forum/view.php?f=$forum->id\">".format_string($forum->name, true)."</a>";
            if ($discussion->name == $forum->name) {
                $this->discussionhtml .= "</font></p>";
            } else {
                $this->discussionhtml .= " -> <a target=\"_blank\" href=\"$CFG->wwwroot/mod/forum/discuss.php?d=$discussion->id\">".format_string($discussion->name, true)."</a></font></p>";
            }
            $this->discussionhtml .= '<p>';
        }

    }

    /**
     * Add the body of this post.
     *
     * @param   \stdClass   $author The author of the post
     * @param   \stdClass   $post The post being sent
     * @param   \stdClass   $discussion The discussion that the post is in
     * @param   \stdClass   $forum The forum that the discussion belongs to
     * @param   \cminfo     $cminfo The cminfo object for the forum
     * @param   \stdClass   $course The course that the forum belongs to
     */
    protected function add_post_body($author, $post, $discussion, $forum, $cm, $course) {
        global $CFG;

        $canreply = $this->canpost[$discussion->id];

        $data = new \mod_forum\output\forum_post_email(
            $course,
            $cm,
            $forum,
            $discussion,
            $post,
            $author,
            $this->recipient,
            $canreply
        );

        // Override the viewfullnames value.
        $data->viewfullnames = $this->viewfullnames[$forum->id];

        // Determine the type of digest being sent.
        $maildigest = forum_get_user_maildigest_bulk($this->forumdigesttypes, $this->recipient, $forum->id);

        $textrenderer = $this->get_renderer($maildigest);
        $this->discussiontext .= $textrenderer->render($data);
        $this->discussiontext .= "\n";
        if ($this->allowhtml) {
            $htmlrenderer = $this->get_renderer($maildigest, true);
            $this->discussionhtml .= $htmlrenderer->render($data);
        }

        if ($maildigest == 1 && $CFG->forum_usermarksread) {
            // Create an array of postid's for this user to mark as read.
            $this->markpostsasread[] = $post->id;
        }
    }

    /**
     * Add the footer for this discussion.
     *
     * @param   \stdClass   $discussion The discussion to add the footer for
     */
    protected function add_discussion_footer($discussion) {
        global $CFG;

        if ($this->allowhtml) {
            $footerlinks = [];

            $forum = $this->forums[$discussion->forum];
            if (\mod_forum\subscriptions::is_forcesubscribed($forum)) {
                // This forum is force subscribed. The user cannot unsubscribe.
                $footerlinks[] = get_string("everyoneissubscribed", "forum");
            } else {
                $footerlinks[] = "<a href=\"$CFG->wwwroot/mod/forum/subscribe.php?id=$forum->id\">" . get_string("unsubscribe", "forum") . "</a>";
            }
            $footerlinks[] = "<a href='{$CFG->wwwroot}/mod/forum/index.php?id={$forum->course}'>" . get_string("digestmailpost", "forum") . '</a>';

            $this->discussionhtml .= "\n<div class='mdl-right'><font size=\"1\">" . implode('&nbsp;', $footerlinks) . '</font></div>';
            $this->discussionhtml .= '<hr size="1" noshade="noshade" /></p>';
        }
    }

    protected function add_discussion_to_notification() {
        if ($this->discussionpostcount) {
            $this->sentcount += $this->discussionpostcount;
            $this->discussionpostcount = 0;

            $this->notificationtext .= $this->discussiontext;
            $this->discussiontext = '';

            $this->notificationhtml .= $this->discussionhtml;
            $this->discussionhtml = '';
        }
    }

    /**
     * Send the composed message to the user.
     */
    protected function send_mail() {
        global $USER;

        $recipient = $USER;

        // Headers to help prevent auto-responders.
        $userfrom = \core_user::get_noreply_user();
        $userfrom->customheaders = array(
            "Precedence: Bulk",
            'X-Auto-Response-Suppress: All',
            'Auto-Submitted: auto-generated',
        );

        $eventdata = new \core\message\message();
        $eventdata->courseid = SITEID;
        $eventdata->component = 'mod_forum';
        $eventdata->name = 'digests';
        $eventdata->userfrom = $userfrom;
        $eventdata->userto = $this->recipient;
        $eventdata->subject = $this->postsubject;
        $eventdata->fullmessage = $this->notificationtext;
        $eventdata->fullmessageformat = FORMAT_PLAIN;
        $eventdata->fullmessagehtml = $this->notificationhtml;
        $eventdata->notification = 1;
        $eventdata->smallmessage = get_string('smallmessagedigest', 'forum', $this->sentcount);
        $mailresult = message_send($eventdata);

        if (!$mailresult) {
            // The digest failed, but we do _not_ want to try and send it again.
            // TODO Improve this.
            mtrace("ERROR: mod/forum/cron.php: Could not send out digest mail to user {$this->recipient->id} ".
                "({$this->recipient->email})... not trying again.");
        } else {
            // Mark post as read if forum_usermarksread is set off
            if (get_user_preferences('forum_markasreadonnotification', 1, $this->recipient->id) == 1) {
                // TODO Uncomment
                //forum_tp_mark_posts_read($this->recipient, $this->markposts);
            }
        }
    }

    /**
     * Helper to fetch the required renderer, instantiating as required.
     *
     * @param   int     $maildigest The type of mail digest being sent
     * @param   bool    $html Whether to fetch the HTML renderer
     * @return  \core_renderer
     */
    protected function get_renderer($maildigest, $html = false) {
        global $PAGE;

        $type = $maildigest == 2 ? 'emaildigestbasic' : 'emaildigestfull';
        $target = $html ? 'htmlemail' : 'textemail';

        if (!isset($this->renderers[$target][$type])) {
            $this->renderers[$target][$type] = $PAGE->get_renderer('mod_forum', $type, $target);
        }

        return $this->renderers[$target][$type];
    }

}
