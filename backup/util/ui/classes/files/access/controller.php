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
 * The Moodle backup subsystem.
 *
 * @package     core_backup
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_backup\files\access;

use core_files\local\access\controller_base;
use core_files\local\access\servable_content;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends controller_base {

    /** @var The file area for a course backup */
    const FILEAREA_COURSE = 'course';

    /** @var The file area for a course section backup */
    const FILEAREA_SECTION = 'section';

    /** @var The file area for an activity backup */
    const FILEAREA_ACTIVITY = 'activity';

    /** @var The file area for an automated backup */
    const FILEAREA_AUTOMATED = 'automated';

    /**
     * Get a list of the file areas in use for this component.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            // No itemid present for the course filearea.
            self::FILEAREA_COURSE => self::ITEMID_NOT_PRESENT,

            // The itemid in the section file area is the sectionid.
            self::FILEAREA_SECTION => self::ITEMID_PRESENT_IN_USE,

            // No itemid in the activity file area.
            self::FILEAREA_ACTIVITY => self::ITEMID_NOT_PRESENT,

            // No itemid in the automated file area.
            self::FILEAREA_AUTOMATED => self::ITEMID_NOT_PRESENT,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|object $user
     * @return  bool
     */
    public static function can_access_storedfile(stored_file $file, ?object $user = null): bool {
        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to a shared filearea, and not this specific activity.
            return true;
        }

        $context = self::get_context_from_stored_file($file);

        if (!has_capability('moodle/backup:downloadfile', $context, $user)) {
            // All file areas require the downloadfile capability.
            return false;
        }

        switch ($file->get_filearea()) {
            case 'course':
            case 'section':
                if ($context->contextlevel !== CONTEXT_COURSE) {
                    return false;
                }
                break;
            case 'activity':
                if ($context->contextlevel !== CONTEXT_MODULE) {
                    return false;
                }
                break;
            case 'automated':
                if ($context->contextlevel !== CONTEXT_COURSE) {
                    return false;
                }

                if (!has_capability('moodle/restore:userinfo', $context, $user)) {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }

        return true;
    }

    /**
     * Login is always required to access backups.
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
        [, $course, $cm] = get_context_info_array($this->context->id);

        if ($this->context->contextlevel == CONTEXT_COURSE) {
            return [$course];
        }

        if ($this->context->contextlevel == CONTEXT_MODULE) {
            return [$course, false, $cm];
        }
    }

    /**
     * Set the servable content options for the specified servable_content item.
     *
     * @param   servable_content $servable
     */
    protected function set_servable_content_options(servable_content $servable): void {
        // The parent options still apply.
        parent::set_servable_content_options($servable);

        switch ($this->filearea) {
            case self::FILEAREA_COURSE:
            case self::FILEAREA_AUTOMATED:
                // Disable any caching.
                $servable->set_cache_time(0);
                break;
        }
    }
}
