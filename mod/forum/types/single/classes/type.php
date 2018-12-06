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
 * The single forum type.
 *
 * @package    mod_foruforumtype_single
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace forumtype_single;

class type extends \mod_forum\instance {

    /**
     * Check whether the user can create a new discussion in the specified group.
     *
     * @param   \stdClass   $currentgroup
     * @return  bool
     */
    function forum_user_can_post_discussion($currentgroup = null) : bool {
        return false;
    }

    /**
     * Whether the discussion is locked.
     *
     * @param   \stdClass   $discussion
     * @return  boolean
     */
    public function is_discussion_locked($discussion) : bool {
        // It does not make sense to lock single forum discussions.
        return false;
    }

    /**
     * Whether the author's name, picture, and related information should be hidden.
     *
     * @param   \stdClass   $post The post to check
     * @return  bool
     */
    public function is_author_hidden($post) : bool {
        if (empty($post->parent)) {
            return true;
        }

        return false;
    }

    /**
     * The discussion list is not relevant to a single discussion forum.
     *
     * Redirect to the discussion view for the first discussion in the forum.
     */
    public function handle_discussion_list_viewed() {
        global $DB;

        // There is only one discussion in the single view. No point showing the list with a single discussion.
        $discussion = $DB->get_record('forum_discussions', ['forum' => $this->get_forum_id()]);

        redirect($this->get_discussion_view_url($discussion));
    }

    /**
     * Discussions cannot be moved into, or out of, a Single Discussion.
     */
    public function can_move_discussions($require = false) : bool {
        return false;
    }

    /**
     * Discussions cannot be split in a single discussion.
     */
    public function can_split_discussion(\stdClass $discussion, \stdClass $post) : bool {
        return false;
    }

    /**
     * The first post in a single discussions is the activity description.
     */
    public function can_edit_post(\stdClass $discussion, \stdClass $post) : bool {
        if ($discussion->firstpost == $post->id) {
            return has_capability('moodle/course:manageactivities', $this->get_context(), $this->user);
        }

        return parent::can_edit_post($discussion, $post);
    }

    /**
     * The first post in a single discussions cannot be deleted.
     */
    public function can_delete_post(\stdClass $discussion, \stdClass $post) : bool {
        if ($discussion->firstpost == $post->id) {
            return false;
        }

        return parent::can_delete_post($discussion, $post);
    }

    /**
     * The first post in a single discussions is the activity description.
     */
    public function get_post_edit_url(\stdClass $discussion, \stdClass $post) : \moodle_url {
        if ($discussion->firstpost == $post->id) {
            return new \moodle_url('/course/modedit.php', [
                'update' => $this->get_cm()->id,
                'sesskey' => sesskey(),
                'return' => 1,
            ]);
        }

        return parent::get_post_edit_url($discussion, $post);
    }

}
