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
 * Forum cron runner.
 *
 * @package    mod_forum
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/forum/lib.php');

/**
 * Forum cron runner.
 *
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cron {

    protected $courses = [];

    protected $forums = [];

    protected $discussions = [];

    protected $posts = [];

    protected $users = [];

    protected $subscribedusers = [];

    protected $digestusers = [];

    /**
     * @var \progress_trace
     */
    protected $trace = null;

    /**
     * Execute the scheduled task.
     */
    public function execute() {
        global $CFG;

        $trace = $this->get_tracer();
        $timenow = time();

        // Delete any really old posts in the digest queue.
        $weekago = $timenow - (7 * 24 * 3600);
        $tracer->output("Removing old digest records from 7 days ago.");

        // TODO Uncomment
        //$DB->delete_records_select('forum_queue', "timemodified < ?", array($weekago));
        $tracer->output("Removed all old digest records.");

        $endtime   = $timenow - $CFG->maxeditingtime;
        $starttime = $endtime - (2 * DAYSECS);
        $starttime = $endtime - (14 * WEEKSECS);
        $tracer->output("Fetching unmailed posts.");
        $start = microtime(true);
        if (!$posts = $this->get_unmailed_posts($starttime, $endtime, $timenow)) {
            $tracer->output("No posts found.", 1);
            echo "No posts found\n";
            return false;
        }
        $tracer->output(sprintf("done (%01.4fs)\n", microtime(true) - $start), 1);
        printf("done (%01.4fs)\n", microtime(true) - $start);

        // Process post data and turn into adhoc tasks.
        $this->process_post_data($posts);
    }

    protected function get_tracer() {
        if (null === $this->trace) {
            $this->trace = new \text_progress_trace();
        }

        return $this->trace;
    }

    /**
     * Process all posts and convert to appropriated hoc tasks.
     *
     * @param   \stdClass[] $posts
     */
    protected function process_post_data($posts) {
        $discussionids = [];
        $forumids = [];
        $courseids = [];
        echo "Processing post information... ";
        $start = microtime(true);
        foreach ($posts as $id => $post) {
            $discussionids[$post->discussion] = true;
            $forumids[$post->forum] = true;
            $courseids[$post->course] = true;
            $this->add_data_for_post($post);
            $this->posts[$id] = $post;
        }
        printf("done (%01.4fs)\n", microtime(true) - $start);

        // Please note, this order is intentional.
        // The forum cache makes use of the course.
        echo "Filling caches";
        $start = microtime(true);
        $this->fill_course_cache(array_keys($courseids));
        echo ".";
        $this->fill_forum_cache(array_keys($forumids));
        echo ".";
        $this->fill_discussion_cache(array_keys($discussionids));
        echo ".";
        $this->fill_user_subscription_cache();
        echo ".";
        $this->fill_digest_cache();
        echo ".";
        $this->fetch_user_has_posted();
        echo ".";
        printf("done (%01.4fs)\n", microtime(true) - $start);

        $this->queue_user_tasks();
    }

    protected function fill_course_cache($courseids) {
        global $DB;

        list($in, $params) = $DB->get_in_or_equal($courseids);
        $this->courses = $DB->get_records_select('course', "id $in", $params);
    }

    protected function fill_forum_cache($forumids) {
        global $DB;

        $requiredfields = [
                'id',
                'course',
                'forcesubscribe',
                'type',
            ];
        list($in, $params) = $DB->get_in_or_equal($forumids);
        $this->forums = $DB->get_records_select('forum', "id $in", $params, '', implode(', ', $requiredfields));
        foreach ($this->forums as $id => $forum) {
            \mod_forum\subscriptions::fill_subscription_cache($id);
            \mod_forum\subscriptions::fill_discussion_subscription_cache($id);
        }
    }

    protected function fill_discussion_cache($discussionids) {
        global $DB;

        if (empty($discussionids)) {
            $this->discussion = [];
        } else {

            $requiredfields = [
                    'id',
                    'groupid',
                    'firstpost',
                    'timestart',
                    'timeend',
                ];

            list($in, $params) = $DB->get_in_or_equal($discussionids);
            $this->discussions = $DB->get_records_select('forum_discussions', "id $in", $params, '', implode(', ', $requiredfields));
        }
    }

    protected function fill_digest_cache() {
        global $DB;

        // Get the list of forum subscriptions for per-user per-forum maildigest settings.
        list($in, $params) = $DB->get_in_or_equal(array_keys($this->users));
        $digestspreferences = $DB->get_recordset_select('forum_digests', "userid $in", $params, '', 'id, userid, forum, maildigest');
        foreach ($digestspreferences as $digestpreference) {
            if (!isset($this->digestusers[$digestpreference->forum])) {
                $this->digestusers[$digestpreference->forum] = [];
            }
            $this->digestusers[$digestpreference->forum][$digestpreference->userid] = $digestpreference->maildigest;
        }
        $digestspreferences->close();
    }

    protected function add_data_for_post($post) {
        if (!isset($this->adhocdata[$post->course])) {
            $this->adhocdata[$post->course] = [];
        }

        if (!isset($this->adhocdata[$post->course][$post->forum])) {
            $this->adhocdata[$post->course][$post->forum] = [];
        }

        if (!isset($this->adhocdata[$post->course][$post->forum][$post->discussion])) {
            $this->adhocdata[$post->course][$post->forum][$post->discussion] = [];
        }

        $this->adhocdata[$post->course][$post->forum][$post->discussion][$post->id] = $post->id;
    }

    protected function fill_user_subscription_cache() {
        $queuedusers = [];
        foreach ($this->forums as $forum) {
            $cm = get_fast_modinfo($this->courses[$forum->course])->instances['forum'][$forum->id];
            $modcontext = \context_module::instance($cm->id);

            $this->subscribedusers[$forum->id] = [];
            if ($users = \mod_forum\subscriptions::fetch_subscribed_users($forum, 0, $modcontext, 'u.id, u.maildigest', true)) {
                foreach ($users as $user) {
                    // this user is subscribed to this forum
                    $this->subscribedusers[$forum->id][$user->id] = $user->id;
                    if (!isset($this->users[$user->id])) {
                        // Store minimal user info.
                        $this->users[$user->id] = $user;
                    }
                }
                // Release memory.
                unset($users);
            }
        }
    }

    protected function fetch_user_has_posted() {
        global $DB;

        $forums = array_filter($this->forums, function($forum) {
            return $forum->type === 'qanda';
        });

        if (empty($forums)) {
            return;
        }

        list($in, $params) = $DB->get_in_or_equal($forums);

        $sql = "SELECT d.forum, d.firstpost, p.userid
                 FROM {forum} f
           INNER JOIN {forum_discussions} d ON d.id = p.discussion
            LEFT JOIN {forum_posts} p ON p.discussion = d.id
                WHERE f.type = 'qanda'
                  AND f.id {$in}
             GROUP BY p.userid, d.forum, d.firstpost";

        $rs = $DB->get_recordset_sql($sql, $params);
        foreach ($rs as $row) {
            if (empty($this->qandametadata[$row['forum']])) {
                $this->qandametadata[$row['forum']] = (object) [
                        'firstpost' => [$row['firstpost']],
                    ];
            }
            $this->qandametadata[$row['forum']]->users[$row['userid']] = true;
        }
        $rs->close();

    }

    /**
     * Queue the user tasks.
     */
    protected function queue_user_tasks() {
        global $CFG, $DB;

        $timenow = time();
        $sitetimezone = \core_date::get_server_timezone();
        echo "Queueing user tasks:\n";
        $counts = [
            'digests' => 0,
            'individuals' => 0,
            'users' => 0,
            'ignored' => 0,
            'messages' => 0,
        ];
        $start = microtime(true);
        foreach ($this->users as $user) {
            $send = false;
            // Setup this user so that the capabilities are cached, and environment matches receiving user.
            cron_setup_user($user);

            list($individualpostdata, $digestpostdata) = $this->fetch_posts_for_user($user);

            if (!empty($digestpostdata)) {
                // Insert all of the records for the digest.
                $DB->insert_records('forum_queue', $digestpostdata);
                $digesttime = usergetmidnight($timenow, $sitetimezone) + ($CFG->digestmailtime * 3600);

                $task = new \mod_forum\task\send_user_digests();
                $task->set_userid($user->id);
                $task->set_component('mod_forum');
                $task->set_next_run_time($digesttime);
                \core\task\manager::queue_adhoc_task($task, true);
                $counts['digests']++;
                $send = true;
            }

            if (!empty($individualpostdata['postids'])) {
                $counts['messages'] += count($individualpostdata['postids']);

                $task = new \mod_forum\task\send_user_notifications();
                $task->set_userid($user->id);
                $task->set_custom_data($individualpostdata);
                $task->set_component('mod_forum');
                \core\task\manager::queue_adhoc_task($task);
                $counts['individuals']++;
                $send = true;
            }

            if ($send) {
                $counts['users']++;
            } else {
                $counts['ignored']++;
            }

        }
        echo "\n";
        printf(
            "Queued %d digests, and %d individual tasks for %d post mails in %01.4f seconds. " .
            "Unique users: %d (%d ignored)\n",
            $counts['digests'],
            $counts['individuals'],
            $counts['messages'],
            microtime(true) - $start,
            $counts['users'],
            $counts['ignored']
        );
    }

    /**
     */
    protected function fetch_posts_for_user($user) {
        // We maintain a mapping of user groups for each forum.
        $usergroups = [];
        $digeststructure = [];

        $poststructure = $this->adhocdata;
        $postids = [];
        foreach ($poststructure as $courseid => $forumids) {
            $course = $this->courses[$courseid];
            foreach ($forumids as $forumid => $discussionids) {
                $forum = $this->forums[$forumid];
                $maildigest = forum_get_user_maildigest_bulk($this->digestusers, $user, $forumid);

                if (!isset($this->subscribedusers[$forumid][$user->id])) {
                    // This user has no subscription of any kind to this forum.
                    // Do not send them any posts at all.
                    unset($poststructure[$courseid][$forumid]);
                    continue;
                }

                $subscriptiontime = \mod_forum\subscriptions::fetch_discussion_subscription($forum->id, $user->id);

                $cm = get_fast_modinfo($course)->instances['forum'][$forumid];
                foreach ($discussionids as $discussionid => $postids) {
                    $discussion = $this->discussions[$discussionid];
                    if (!\mod_forum\subscriptions::is_subscribed($user->id, $forum, $discussionid, $cm)) {
                        // The user does not subscribe to this forum as a whole, or to this specific discussion.
                        unset($poststructure[$courseid][$forumid][$discussionid]);
                        continue;
                    }

                    if ($discussion->groupid > 0 and $groupmode = groups_get_activity_groupmode($cm, $course)) {
                        // This discussion has a groupmode set.
                        // Check whether the user can view it based on their groups.
                        if (!isset($usergroups[$forum->id])) {
                            $usergroups[$forum->id] = groups_get_all_groups($courseid, $user->id, $cm->groupingid);
                        }

                        if (!isset($usergroups[$forum->id][$discussion->groupid])) {
                            // This user is not a member of this group.
                            $modcontext = \context_module::instance($cm->id);
                            if (!has_capability('moodle/site:accessallgroups', $modcontext)) {
                                // This user does not have access to groups that they are not a member of.
                                // TODO Check what this relates to:
                                // Do not send posts from other groups when in SEPARATEGROUPS or VISIBLEGROUPS.
                                unset($poststructure[$courseid][$forumid][$discussionid]);
                                continue;
                            }
                        }
                    }

                    foreach ($postids as $postid) {
                        $post = $this->posts[$postid];
                        if ($subscriptiontime) {
                            // Skip posts if the user subscribed to the discussion after it was created.
                            if (isset($subscriptiontime[$post->discussion]) && ($subscriptiontime[$post->discussion] > $post->created)) {
                                // The user subscribed to the discussion/forum after this post was created.
                                unset($poststructure[$courseid][$forumid][$discussionid]);
                                continue;
                            }
                        }

                        if ($forum->type === 'qanda' && $postid != $discussion->firstpost) {
                            if (isset($this->qandametadata[$forumid]) && isset($this->qandametadata[$userid][$forumid])) {
                                // The user has not posted to this qanda forum.
                                unset($poststructure[$courseid][$forumid][$discussionid]);
                                continue;
                            }
                        }

                        if (!forum_user_can_see_post($forum, $discussion, $post, null, $cm)) {
                            // The user is not allowed to see the post for some other reason.
                            unset($poststructure[$courseid][$forumid][$discussionid][$postid]);
                            continue;
                        }

                        if ($maildigest > 0) {
                            // This user wants the mails to be in digest form.
                            $queue = new \stdClass();
                            $queue->userid = $user->id;
                            $queue->discussionid = $discussion->id;
                            $queue->postid       = $post->id;
                            $queue->timemodified = $post->created;
                            $digeststructure[] = $queue;
                            unset($poststructure[$courseid][$forumid][$discussionid][$postid]);
                            continue;
                        } else {
                            // Add this post to the list of postids.
                            $postids[] = $postid;
                        }
                    }
                }

                if (empty($poststructure[$courseid][$forumid])) {
                    // This user is not subscribed to any discussions in this forum at all.
                    unset($poststructure[$courseid][$forumid]);
                    continue;
                }
            }
            if (empty($poststructure[$courseid])) {
                // This user is not subscribed to any forums in this course.
                unset($poststructure[$courseid]);
            }
        }

        $individualpostdata = [
            'postids' => $postids,
            'structure' => $poststructure,
        ];

        return [$individualpostdata, $digeststructure];;
    }

    /**
     * Returns a list of all new posts that have not been mailed yet
     *
     * @param int $starttime posts created after this time
     * @param int $endtime posts created before this
     * @param int $now used for timed discussions only
     * @return array
     */
    protected function get_unmailed_posts($starttime, $endtime, $now = null) {
        global $CFG, $DB;

        $params = array();
        $params['mailed'] = FORUM_MAILED_PENDING;
        $params['ptimestart'] = $starttime;
        $params['ptimeend'] = $endtime;
        $params['mailnow'] = 1;

        if (!empty($CFG->forum_enabletimedposts)) {
            if (empty($now)) {
                $now = time();
            }
            $selectsql = "AND (p.created >= :ptimestart OR d.timestart >= :pptimestart)";
            $params['pptimestart'] = $starttime;
            $timedsql = "AND (d.timestart < :dtimestart AND (d.timeend = 0 OR d.timeend > :dtimeend))";
            $params['dtimestart'] = $now;
            $params['dtimeend'] = $now;
        } else {
            $timedsql = "";
            $selectsql = "AND p.created >= :ptimestart";
        }

        return $DB->get_records_sql(
               "SELECT
                    p.id,
                    p.discussion,
                    d.forum,
                    d.course,
                    p.created,
                    p.parent,
                    p.userid
                  FROM {forum_posts} p
                  JOIN {forum_discussions} d ON d.id = p.discussion
                 WHERE p.mailed = :mailed
                $selectsql
                   AND (p.created < :ptimeend OR p.mailnow = :mailnow)
                $timedsql
                 ORDER BY p.modified ASC",
             $params);
    }

}
