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
 * The eachuser forum type.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_forum\local\type;

class eachuser extends \mod_forum\instance {

    /**
     * Check whether the user can create a new discussion in the specified group.
     *
     * @param   \stdClass   $currentgroup
     * @return  bool
     */
    public function can_create_discussion($currentgroup = null) : bool {
        if ($currentgroup === null) {
            $currentgroup = groups_get_activity_group($this->get_cm());
        }

        // TODO Update this.
        if (forum_user_has_posted_discussion($this->record->id, $this->user->id, $currentgroup)) {
            return false;
        }

        return parent::can_create_discussion($currentgroup);
    }
}
