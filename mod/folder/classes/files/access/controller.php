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
 * Folder activity for Moodle.
 *
 * @package     mod_folder
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_folder\files\access;

use context;
use core_files\local\access\mod_controller;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends mod_controller {

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            'content' => self::ITEMID_PRESENT_BUT_DEFAULT,
        ]);
    }
}
