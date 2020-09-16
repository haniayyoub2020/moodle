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
 * Calendar subsystem for Moodle.
 *
 * @package     core_calendar
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_calendar\files\access;

use core_calendar\local\container;
use core_files\local\access\controller_base;
use core_files\local\access\servable_content;
use stdClass;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends controller_base {

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            'event_description' => self::ITEMID_PRESENT_IN_USE,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|stdClass $user
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

        $event = $DB->get_record('event', ['id' => $file->get_itemid()]);
        $context = self::get_context_from_stored_file($file);

        if ($context->contextlevel == CONTEXT_SYSTEM) {
            // Ensure that the event type is correct.
            return $event->eventtype === 'site';
        }

        if ($context->contextlevel == CONTEXT_COURSE) {
            $courseid = $context->instanceid;
            if ($courseid != SITEID) {
               if (!is_enrolled($context) && !is_viewing($context, $user)) {
                   // Must be able to at least view the course.
                   // This does not apply to the front page.
                   //TODO: hmm, do we really want to block guests here?
                   return false;
               }
            }

            switch ($event->eventtype) {
                case 'course':
                    return true;
                case 'site':
                    return true;
                case 'group':
                    // Group events require either:
                    // - membership of the group; or
                    // - the 'accessallgroups' capability.
                    if (has_capability('moodle/site:accessallgroups', $context, $user)) {
                        return true;
                    }

                    if (groups_is_member($event->groupid, $user->id)) {
                        return true;
                    }

                    return false;
                default:
                    return false;
            }
        }

        if ($context->contextlevel == CONTEXT_USER) {
            if (isguestuser()) {
                // No guest access to user events.
                return false;
            }

            return ($event->eventtype === 'user' && $event->userid = $user->id);
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

        $context = $this->get_context();
        switch ($context->contextlevel) {
            case CONTEXT_SYSTEM:
                // Login is required if forcelogin is set.
                return !empty($CFG->forcelogin);
            case CONTEXT_COURSE:
                if ($context->instanceid == SITEID) {
                    // Login not required for the site course.
                    return false;
                }

                // Login is required if forcelogin is set.
                return !empty($CFG->forcelogin);
            case CONTEXT_USER:
                // Login is always required for user events.
                return true;
        }

        return true;
    }

    /**
     * Force download of files in a user file area.
     *
     * @return  null|bool
     */
    protected function should_force_download(): ?bool {
        if ($this->get_context()->contextlevel == CONTEXT_USER) {
            return true;
        }

        return parent::should_force_download();;
    }
}
