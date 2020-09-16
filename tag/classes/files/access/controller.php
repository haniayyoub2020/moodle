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
 Tag Blog subsystem for Moodle.
 *
 * @package     core_tag
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_tag\files\access;

use core_files\local\access\controller_base;
use core_tag\local\container;
use stdClass;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends controller_base {

    /** @var string The file area for tag descriptions */
    const FILEAREA_DESCRIPTION = 'description';

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            self::FILEAREA_DESCRIPTION => self::ITEMID_NOT_PRESENT,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|stdClass $user
     * @return  bool
     */
    public function can_access_storedfile(stored_file $file, ?object $user): bool {
        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to a shared filearea, and not this specific activity.
            return true;
        }

        $context = self::get_context_from_stored_file($file);
        if ($file->get_filearea() === self::FILEAREA_DESCRIPTION && $context->contextlevel == CONTEXT_SYSTEM) {
            return false;
        }

        return true;
    }

    /**
     * Whether login is required to access this item.
     *
     * @return  bool
     */
    public function requires_login(): bool {
        global $CFG;

        return !empty($CFG->forcelogin);
    }

    /**
     * Force download of all files.
     *
     * @return  null|bool
     */
    protected function should_force_download(): ?bool {
        return true;
    }
}
