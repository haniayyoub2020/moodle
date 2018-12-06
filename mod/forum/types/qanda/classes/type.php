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
 * The Q&A forum type.
 *
 * @package    forumtype_qanda
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace forumtype_qanda;

class type extends \mod_forum\instance {

    /**
     * Check whether a user can see the specified post.
     *
     * @param   \stdClass $post The post in question
     * @param   \stdClass $discussion The discussion the post is in
     * @param   bool      $checkdeleted Whether to check the deleted flag on the post.
     * @return  bool
     */
    public function can_see_post(\stdClass $post, \stdClass $discussion, bool $checkdeleted = true) : bool {
        global $USER;

        if (!parent::can_see_post($post, $discussion, $checkdeleted)) {
            return false;
        }

        if ($post->userid === $this->user->id) {
            // This user created this post.
            return true;
        }

        if ($post->id === $discussion->firstpost) {
            // This is the first post.
            // The user must see this post in order to reply to it.
            return true;
        }

        if (has_capability('mod/forum:viewqandawithoutposting', $this->get_context(), $this->user)) {
            // This user has permissions to view posts without posting first.
            return true;
        }

        $firstpost = $this->get_firstpost_from_discussion($discussion->id);
        if ($firstpost->userid == $this->user->id) {
            // The user posted the discussion.
            return true;
        }

        if ($this->user_has_post_exceeding_maxediting($discussion->id)) {
            return true;
        }

        return false;
    }

    /**
     * Check whether a user can see the posts in the specified discussion.
     *
     * Note: This is different ot can_see_discussion as some forum types may want to display the post, but not the
     * content, until a user has posted.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @return  bool
     */
    public function acan_see_posts_in_discussion(\stdClass $discussion) : bool {
        if (!$this->can_see_discussion($discussion)) {
            return false;
        }

        if (has_capability('mod/forum:viewqandawithoutposting', $this->get_context(), $this->user)) {
            // Shortcut to avoid DB lookups.
            // A user with permission to see the discussion, and who can view without posting, can always see all posts.
            return true;
        }

        return $this->has_user_posted_in_discussion($discussion);
    }

    /**
     * Given a discussion id, return the first post from the discussion.
     *
     * @param   int     $discussionid
     * @return  \stdClass
     */
    public function get_firstpost_from_discussion(int $discussionid) : \stdClass {
        global $DB;

        $sql = "SELECT p.*
                  FROM {forum_discussions} d
                  JOIN {forum_posts} p ON p.id = d.firstpost
                 WHERE
                    d.id = :discussionid
            ";

        $params = [
            'discussionid' => $discussionid,
        ];

        return $DB->get_record_sql($sql, $params);
    }

    /**
     * Check whether a post has been made and the maxediting time passed.
     *
     * @param   int     $discussionid
     * @return  bool
     */
    function user_has_post_exceeding_maxediting($discussionid) {
        global $DB, $CFG, $USER;

        return $DB->record_exists_select('forum_posts', 'discussion = :discussionid AND userid = :userid AND created < :mintime', [
                'userid' => $this->user->id,
                'discussionid' => $discussionid,
                'mintime' => time() - $this->get_maxediting_time(),
            ]);
    }

    /**
     * Get the name of hte capability used to post in an existing discussion.
     *
     * @return  string
     */
    protected function get_capability_to_create_new_discussion() : string {
        return 'mod/forum:addquestion';
    }

    /**
     * Get the string to display when there are no discussions to list.
     *
     * @return  string
     */
    public function get_no_discussions_string() : string {
        return get_string('noquestions', 'mod_forum');
    }

    /**
     * Get the string to use for the create discussion buttons.
     *
     * @return  string
     */
    public function get_create_discussion_string() : string {
        // TODO Move this to the subplugin.
        return get_string('addanewquestion', 'forum');
    }

    /**
     * Get any notifications to display on the discussion list page.
     *
     * @return  \core\output\notifications[]
     */
    public function get_discussion_list_notifications() : array {
        $notifications = parent::get_discussion_list_notifications();
        if (!has_capability('moodle/course:manageactivities', $this->get_context(), $this->user)) {
            $notifications[] = (new \core\output\notification(
                get_string('qandanotify', 'mod_forum'),
                \core\output\notification::NOTIFY_INFO
            ))->set_show_closebutton();
        }

        return $notifications;
    }
}
