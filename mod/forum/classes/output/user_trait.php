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
 * User helper trait.
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

trait user_trait {

    /**
     * Get the information about this author.
     *
     * @param   \renderer_base  $renderer The renderer used to format this information.
     * @param   \stdClass       $user The user being formatted.
     * @return  array
     */
    protected function get_user_info(\renderer_base $renderer, $user) : array {
        global $PAGE;

        return [
            'fullname' => $this->forum->fullname($user),
            'profileimageurl' => $this->forum->get_profile_image_url($PAGE, $user),
            'profileurl' => $this->forum->get_profile_url($user)->out(false),
        ];
    }
}
