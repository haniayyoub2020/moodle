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
 * Functions relating to forum read tracking.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_forum;

/**
 * The forum tracking class.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tracking {

    const UNREAD = 0;

    const READ = 1;

    /**
     * Marks a whole forum as read, for a given user
     *
     * @global object
     * @global object
     * @param object $user
     * @param int $forumid
     * @param int|bool $groupid
     * @return bool
     */
    function mark_forum_as_read(\stdClass $user, int $forumid, $groupid = false) {
        global $CFG, $DB;

        $cutoffdate = time() - ($CFG->forum_oldpostdays * DAYSECS);

        $groupsel = "";
        $params = array($user->id, $forumid, $cutoffdate);

        if ($groupid !== false) {
            $groupsel = " AND (d.groupid = ? OR d.groupid = -1)";
            $params[] = $groupid;
        }

        $sql = "SELECT p.id
                FROM {forum_posts} p
                    LEFT JOIN {forum_discussions} d ON d.id = p.discussion
                    LEFT JOIN {forum_read} r        ON (r.postid = p.id AND r.userid = ?)
                WHERE d.forum = ?
                    AND p.modified >= ? AND r.id is NULL
                    $groupsel";

        if ($posts = $DB->get_records_sql($sql, $params)) {
            $postids = array_keys($posts);
            return forum_tp_mark_posts_read($user, $postids);
        }

        return true;
    }

    /**
     * Marks a whole discussion as read, for a given user.
     *
     * @param   \stdClass   $user
     * @param   int         $discussionid
     * @return  bool
     */
    public static function mark_discussion_as_read(\stdClass $user, int $discussionid) : bool {
        global $CFG, $DB;

        $cutoffdate = time() - ($CFG->forum_oldpostdays * DAYSECS);

        $sql = "SELECT p.id
                FROM {forum_posts} p
           LEFT JOIN {forum_read} r ON (r.postid = p.id AND r.userid = ?)
               WHERE
                    p.discussion = ?
                 AND
                    p.modified >= ?
                 AND
                    r.id is NULL";

        if ($posts = $DB->get_records_sql($sql, [$user->id, $discussionid, $cutoffdate])) {
            $postids = array_keys($posts);
            return forum_tp_mark_posts_read($user, $postids);
        }

        return true;
    }

    public static function mark_post_as_read(instance $forum, int $postid) {
        if (!static::is_read_tracking_enabled_for_forum($forum)) {
            return false;
        }

        // TODO
        forum_tp_add_read_record($instance->get_user_record(), $postid);
    }

    public static function mark_post_as_unread(instance $forum, int $postid) {
        if (!static::is_read_tracking_enabled_for_forum($forum)) {
            return false;
        }

        // TODO
        forum_tp_delete_read_records($forum->get_user_id(), $postid);
    }

    public static function mark_post(instance $forum, int $postid, int $markas) {
        if ($markas === static::READ) {
            return static::mark_post_as_read($forum, $postid);
        } else if ($markas === static::UNREAD) {
            return static::mark_post_as_unread($forum, $postid);
        }
    }

    public static function is_read_tracking_enabled() {
        global $CFG;

        return !empty($CFG->forum_usermarksread);
    }

    public static function is_read_tracking_enabled_for_forum(instance $forum) {
        if (!static::is_read_tracking_enabled()) {
            return false;
        }

        if (!forum_tp_can_track_forums($forum->get_forum_record())) {
            return false;
        }

        if (!forum_tp_is_tracked($forum->get_forum_record())) {
            return false;
        }

        return true;
    }
}
