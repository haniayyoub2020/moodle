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
 * Assignment activity for Moodle.
 *
 * @package     mod_assign
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_assign\files\access;

use assign;
use context;
use core_files\local\access\mod_controller;
use core_files\local\access\file_proxy\stored_file_proxy;
use stdClass;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends mod_controller {

    /**
     * Constructor to ensure that the mod/assign libraries are correctly loaded before functions are called.
     *
     * @param   mixed ...$args
     */
    protected function __construct(...$args) {
        global $CFG;

        parent::__construct(...$args);

        require_once($CFG->dirroot . '/mod/assign/lib.php');
        require_once($CFG->dirroot . '/mod/assign/locallib.php');
    }

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            ASSIGN_INTROATTACHMENT_FILEAREA => self::ITEMID_PRESENT_BUT_DEFAULT,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @return  bool
     */
    public static function can_access_storedfile(stored_file $file, ?object $user = null): bool {
        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to the the shared activity file areas, and not this specific activity.
            return true;
        }

        // Note: The only file area supported for mod_assign is the intro attachment file area.
        // If any additional filearea is added in future, then these checks may need to be refactored.
        $cm = static::get_cm_from_stored_file($file);
        $course = $cm->get_modinfo()->get_course();
        $context = $cm->context;

        $assign = new assign($context, $cm, $course);
        if (!$assign->show_intro()) {
            return false;
        }

        return true;
    }
}
