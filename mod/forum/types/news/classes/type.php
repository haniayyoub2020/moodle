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
 * The Announcements forum type.
 *
 * @package    forumtype_news
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace forumtype_news;

class type extends \mod_forum\instance {

    /**
     * Get the name of the capability used to post in an existing discussion.
     *
     * @return  string
     */
    protected function get_capability_to_post_to_discussion() : string {
        // TODO Move to new plugin
        return 'mod/forum:replynews';
    }

    /**
     * Get the name of the capability used to post in an existing discussion.
     *
     * @return  string
     */
    protected function get_capability_to_create_new_discussion() : string {
        // TODO Move.
        return 'mod/forum:addnews';
    }

    /**
     * Get the string to display when there are no discussions to list.
     *
     * @return  string
     */
    public function get_no_discussions_string() : string {
        // TODO move
        return get_string('nonews', 'mod_forum');
    }

    /**
     * News forums should respect the timestart if present.
     */
    public function can_edit_post(\stdClass $discussion, \stdClass $post) : bool {
        if (parent::can_edit_post($discussion, $post)) {
            return true;
        }

        // Where a news post is the programmed for the future, it should be editable.
        // TODO ... shouldn't it be editable until 30 minutes after the programmed time?
        if ($post->userid == $this->user->id) {
            if ($discussion->timestart > time()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check age against timestart.
     */
    public function can_delete_post(\stdClass $discussion, \stdClass $post) : bool {
        if (parent::can_delete_post($discussion, $post)) {
            return true;
        }

        // Where a news post is the programmed for the future, it should be deleteable.
        // TODO ... shouldn't it be deleteable until 30 minutes after the programmed time?
        if ($post->userid == $this->user->id) {
            if ($discussion->timestart > time()) {
                return true;
            }
        }

        return false;
    }
}
