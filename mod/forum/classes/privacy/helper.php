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
 * Privacy Subsystem implementation for mod_forum.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\privacy;

use \core_privacy\request\approved_contextlist;
use \core_privacy\request\writer;
use \core_privacy\metadata\item_collection;

defined('MOODLE_INTERNAL') || die();

/**
 * Subcontext helper trait.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
trait helper {
    /**
     * Get the discussion part of the subcontext.
     *
     * @param   \stdClass   $discussion
     * @return  array
     */
    protected static function get_discussion_area(\stdClass $discussion) : Array {
        $parts = [
            $discussion->timemodified,
            $discussion->name,
            $discussion->id,
        ];

        $discussionname = implode('-', $parts);

        return [
            get_string('discussions', 'mod_forum'),
            $discussionname,
        ];
    }

    /**
     * Get the post part of the subcontext.
     *
     * @param   \stdClass   $post
     * @return  array
     */
    protected static function get_post_area(\stdClass $post, \stdClass $discussion = null) : Array {
        $area = static::get_discussion_area((object) [
            'timemodified'  => $post->discussionmodified,
            'name'          => $post->discussionname,
            'id'            => $post->discussion,
        ]);

        $area[] = get_string('posts', 'mod_forum');
        $parts = [
            $post->created,
            $post->subject,
            $post->id,
        ];
        $area[] = implode('-', $parts);

        return $area;
    }

    protected static function get_subcontext($forum, $discussion = null, $post = null) {
        if (null !== $discussion) {
            if (null !== $post) {
                return static::get_post_area((object) array_merge(
                    (array) $post, [
                        'discussionmodified'    => $discussion->timemodified,
                        'discussionname'        => $discussion->name,
                    ])
                );

            } else {
                return self::get_discussion_area($discussion);
            }
        }

        return [];
    }
}
