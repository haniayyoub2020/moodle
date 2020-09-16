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
 * File access controller for activity modules.
 *
 * @package     mod_folder
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_files\local\access;

use context;
use core_component;
use core_files\local\access\controller_base;
use stored_file;
use cm_info;

/**
 * File access controller for activity modules.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_controller extends controller_base {

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  string[]
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            // All activities have an 'intro' file section.
            // The pluginfile URL for this item does not include any space for an itemid.
            'intro' => self::ITEMID_NOT_PRESENT,
        ]);
    }

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
        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to the the shared activity file areas, and not this specific activity.
            return true;
        }

        $cm = static::get_cm_from_stored_file($file);
        $modname = self::get_modname_from_component($file->get_component());
        if ($cm->modname !== $modname) {
            // The context does not relate to the correct activity type.
            return false;
        }

        if ($file->get_filearea() === 'intro') {
            if (!$cm->uservisible) {
                // The activity is not visible.
                if (!$cm->showdescription || !$cminfo->is_visible_on_course_page()) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the cm_info from the stored file record.
     *
     * @param   stored_file $file
     * @return  cm_info
     */
    protected static function get_cm_from_stored_file(stored_file $file): cm_info {
        return self::get_cm_from_context(context::instance_by_id($file->get_contextid()));
    }

    /**
     * Get the cm_info from a context.
     *
     * @param   context $modcontext
     * @return  cm_info
     */
    protected static function get_cm_from_context(context $modcontext): cm_info {
        $coursecontext = $modcontext->get_course_context();

        return get_fast_modinfo($coursecontext->instanceid)->get_cm($modcontext->instanceid);
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
     * @param   bool $forcedownload
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

        [$type, $plugin] = core_component::normalize_component($component);

        $libfilepath = "{$CFG->dirroot}/mod/{$plugin}/lib.php";
        if (!file_exists($libfilepath)) {
            send_file_not_found();
        }
        require_once($libfilepath);

        [, $course, $cm] = get_context_info_array($context->id);

        $filefunction = "{$component}_pluginfile";
        self::call_legacy_pluginfile_function(
            $filefunction,
            $component,
            $course,
            $cm,
            $context,
            $filearea,
            $args,
            $forcedownload,
            $sendfileoptions
        );

        $filefunction = "{$plugin}_pluginfile";
        self::call_legacy_pluginfile_function(
            $filefunction,
            $component,
            $course,
            $cm,
            $context,
            $filearea,
            $args,
            $forcedownload,
            $sendfileoptions
        );

        // We should never get to this position.
        // Either this case should have been handled in the `access::handle_pluginfile()` function, or the above legacy
        // functions.
        throw new \coding_exception("The {$component} plugin has an improperly implemented pluginfile implementation.");
    }

    /**
     * Call a legacy pluginfile function
     *
     * @param   string $filefuction The function to call
     * @param   string $component The owning component
     * @param   array $args The args to pass to the function
     */
    protected static function call_legacy_pluginfile_function(string $filefunction, string $component, ...$args) {
        if (function_exists($filefunction)) {
            debugging(
                "The [plugin]_pluginfile function has been deprecated in favour of the file access API. " .
                "Please update the {$component} component to utilise this.",
                DEBUG_DEVELOPER
            );

            // If the function exists, it must send the file and terminate>
            $filefunction(...$args);

            // Poorly behaved function.
            // If the function exists, is called, and does not terminate, then we fall back to sending a 404.
            send_file_not_found();
        }
    }
}
