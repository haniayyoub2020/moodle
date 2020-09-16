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
 * File access controller for blocks.
 *
 * @package     block_folder
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_files\local\access;

use context;
use core_component;
use core_files\local\access\controller_base;
use stored_file;

/**
 * File access controller for blocks.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_controller extends controller_base {

    /**
     * Whether the user can access the stored file.
     *
     * This function should typically be extended by any activity, with that activity adding any capability checks and
     * other requirements.
     *
     * There are three possible return values:
     *   - false: The user does not have any access to this file;
     *   - true: The file is owned by the current class, and the user does have access; and
     *   - null: The file is not owned by the current class, and the calling code must make a determination on access.
     *
     * @param   stored_file $file
     * @param   null|stdClass $user
     * @return  bool
     */
    public static function can_access_storedfile(stored_file $file, ?object $user = null): bool {
        global $DB;

        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to the the shared activity file areas, and not this specific activity.
            return true;
        }

        $context = self::get_context_from_stored_file($file);
        $blockname = substr($file->get_component(), 6);

        if ($context->level == CONTEXT_BLOCK) {
            $instance = $DB->get_record('block_instances', [
                'id' => $context->instanceid,
                'blockname' => $blockname,
            ]);

            if (!$instance) {
                // Could not find a block instane.
                return false;
            }

            $position = $DB->get_record('block_positions', [
                'contextid' => $context->id,
                'blockinstanceid' => $context->instanceid,
            ]);

            if ($position && !$position->visible) {
                // Could not find a block position.
                return false;
            }

            if (!has_capability('moodle/block:view', $context, $user)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the modname from the component name.
     *
     * @param   string $component
     * @return  null|string
     */
    protected static function get_modname_from_component(string $component): ?string {
        if (substr($component, 0, 4) !== 'mod_') {
            return null;
        }

        return substr($component, 4);
    }

    /**
     * Handle fallback to the legacy pluginfile functions for this plugin type.
     *
     * @param   object $user
     * @param   string $component
     * @param   context $context
     * @param   string $filearea
     * @param   array $args
     * @param   array $sendfileoptions
     */
    public static function handle_legacy_pluginfile_functions(
        object $user,
        string $component,
        context $context,
        string $filearea,
        array $args,
        array $sendfileoptions,
        bool $forcedownload
    ): void {
        // Note: All of the below globals are required as files required in a function inherit the scope of that
        // function.
        global $CFG, $DB, $USER;

        $blockname = substr($component, 6);

        $libfilepath = "{$CFG->dirroot}/blocks/$blockname/lib.php";
        if (!file_exists($libfilepath)) {
            send_file_not_found();
        }
        require_once($libfilepath);

        $filefunction = "{$component}_pluginfile";
        if (!function_exists($filefunction)) {
            send_file_not_found();
        }

        [, $course, $cm] = get_context_info_array($context->id);

        if ($context->contextlevel == CONTEXT_BLOCK) {
            $instance = $DB->get_record('block_instances', [
                'id' => $context->instanceid,
                'blockname' => $blockname,
            ]);

            if (!$instance) {
                // Could not find a block instane.
                send_file_not_found();
            }

            $position = $DB->get_record('block_positions', [
                'contextid' => $context->id,
                'blockinstanceid' => $context->instanceid,
            ]);

            if ($position && !$position->visible) {
                send_file_not_found();
            }

            if (!has_capability('moodle/block:view', $context, $user)) {
                send_file_not_found();
            }
        } else {
            $instance = null;
        }


        // If the function exists, it must send the file and terminate.
        $filefunction($course, $instance, $context, $filearea, $args, $forcedownload, $sendfileoptions);

        // Poorly behaved function.
        // If the function exists, is called, and does not terminate, then we fall back to sending a 404.
        send_file_not_found();
    }
}
