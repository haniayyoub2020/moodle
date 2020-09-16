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
 * The Moodle grading subsystem.
 *
 * @package     core_grading
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_grading\files\access;

use core_files\local\access\controller_base;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends controller_base {

    /** @var The file area for the image associated with a grading outcome */
    const FILEAREA_DESCRIPTION = 'description';

    /**
     * Get a list of the file areas in use for this component.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            // The itemid is the badge id in both cases.
            self::FILEAREA_DESCRIPTION => self::ITEMID_PRESENT_IN_USE,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|object $user
     * @return  bool
     */
    public static function can_access_storedfile(stored_file $file, ?object $user): bool {
        global $DB;

        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to a shared filearea, and not this specific activity.
            return true;
        }

        $filearea = $file->get_filearea();
        $context = self::get_context_from_stored_file($file);

        $sql = "SELECT ga.id
            FROM {grading_areas} ga
            JOIN {grading_definitions} gd ON (gd.areaid = ga.id)
            WHERE gd.id = :itemid AND ga.contextid = :contextid";
        return $DB->record_exists_sql($sql, [
            'itemid' => $file->get_itemid(),
            'contextid' => $file->get_contextid(),
        ]);
    }

    /**
     * Whether login is required to access this item.
     *
     * @return  bool
     */
    public function requires_login(): bool {
        return true;
    }

    /**
     * Get arguments to pass to require_login().
     *
     * @return  array
     */
    public function get_require_login_params(): array {
        if ($this->context->contextlevel == CONTEXT_SYSTEM) {
            return [];
        }

        if ($this->context->contextlevel == CONTEXT_COURSE) {
            [, $course, $cm] = get_context_info_array($context->id);
            return [$course, false, $cm];
        }
    }
}
