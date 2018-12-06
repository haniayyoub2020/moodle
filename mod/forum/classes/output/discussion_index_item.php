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
 * Forum discussion list templatable.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Templatable used to display a discussion in the discussions index.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class discussion_index_item implements \renderable, \templatable {

    use user_trait;

    /**
     * @var \mod_forum\instance The forum whose discussions are to be listed.
     */
    protected $forum;

    /**
     * @var \stdClass The discussion to display
     */
    protected $discussion;

    /**
     * Create a new instance of the renderable.
     *
     * @param   \mod_forum\instance $forum
     * @param   \stdClass           $discussion
     */
    public function __construct(\mod_forum\instance $forum, \stdClass $discussion) {
        $this->forum = $forum;
        $this->discussion = $discussion;
    }

    /**
     * Export all data required to generate the template.
     *
     * @param   \renderer_base  $renderer
     * @return  \stdClass
     */
    public function export_for_template(\renderer_base $renderer) : \stdClass {
        $discussion = (object) $this->discussion;
        if ($discussion->groupid > 0) {
            $groups = $this->forum->get_all_groups();
            // TODO Move to a new templatable/renderable?
            // TODO Display something when there is no picture.
            if ($url = get_group_picture_url($groups[$discussion->groupid], $this->forum->get_course_id())) {
                $discussion->group = (object) [
                    'picture' => $url->out(),
                ];
            }
        }

        $discussion->author = $this->get_user_info($renderer, $discussion->author);
        $discussion->modifier = $this->get_user_info($renderer, $discussion->modifier);

        $form = new discussion_subscription_toggle($this->forum, $discussion, false);
        $discussion->subscription_toggle_form = $form->export_for_template($renderer);

        return $discussion;
    }
}
