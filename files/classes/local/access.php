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
 * Course content exporter implementation for mod_folder.
 *
 * @package     core_files
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_files\local;

use context;
use core_component;
use stdClass;
use stored_file;
use core_files\local\access\controller_base;
use core_files\local\access\servable_content;

/**
 * File access.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class access {
    /**
     * Get the controller classname from the frankenstyle component.
     *
     * @param   string $component
     * @return  string
     */
    protected static function get_file_access_classname_for_component(string $component): string {
        return "{$component}\\files\\access\\controller";
    }

    /**
     * Whether the component implements the File Handler API.
     *
     * @param   string $component
     * @return  bool
     */
    protected static function component_implements_file_access_api(string $component): bool {
        $classname = self::get_file_access_classname_for_component($component);

        if (!class_exists($classname)) {
            return false;
        }

        if (!is_subclass_of($classname, controller_base::class)) {
            return false;
        }

        return true;
    }

    /**
     * Handle fetching, and serving, of a file fro a pluginfile.
     *
     * @param   object $user
     * @param   string $component
     * @param   context $context
     * @param   string $filearea
     * @param   array $args
     * @return  null|servable_content
     */
    public static function fetch_servable_content_from_pluginfile_params(
        object $user,
        string $component,
        context $context,
        string $filearea,
        array $args
    ): ?servable_content {
        if (!self::component_implements_file_access_api($component)) {
            // This component does not implement the new API.
            // Note: Not all components handle files, so no debugging notice should be added here.
            return null;
        }

        $classname = self::get_file_access_classname_for_component($component);
        $controller = $classname::create_from_pluginfile_params($user, $context, $filearea, $args);

        // Attempt to get the servable content.
        $servable = $controller->get_servable_content();

        if (!$servable) {
            return null;
        }

        $controller->require_login();

        if (!$controller->can_access($user)) {
            return null;
        }

        return $servable;
    }

    /**
     * Serve a file from the file proxy, given the sendfile options.
     *
     * @param   null|servable_content $servable
     * @param   array $sendfileoptions
     * @param   bool $forcedownload
     */
    public static function serve_servable_content(?servable_content $servable, array $sendfileoptions, bool $forcedownload): void {
        if ($servable === null) {
            send_file_not_found();
        }

        // Close the session to prevent it blocking during large file transmission.
        \core\session\manager::write_close();
        $servable->send_file($sendfileoptions, $forcedownload);
    }

    /**
     * Handle fetching, and serving, of a file fro a pluginfile.
     *
     * @param   object $user
     * @param   string $component
     * @param   context $context
     * @param   string $filearea
     * @param   array $args
     * @param   array $sendfileoptions
     */
    public static function handle_pluginfile(
        object $user,
        string $component,
        context $context,
        string $filearea,
        array $args,
        array $sendfileoptions,
        bool $forcedownload
    ): void {
        if (!self::component_implements_file_access_api($component)) {
            // This component does not implement the new API.
            // Note: Not all components handle files, so no debugging notice should be added here.

            // Check for a plugintype default.
            // Some plugin types have a shared filearea, like 'mod_'.
            // Note: Shared file areas can only be added to _new_ plugin types, not existing ones to avoid filearea name
            // collision.
            [$type, $plugin] = core_component::normalize_component($component);
            $classname = "core_files\\local\\access\\{$type}_controller";
            if (class_exists($classname)) {
                $controller = $classname::create_from_pluginfile_params($user, $context, $filearea, $args, $component);

                // Attempt to get a metafile.
                $servable = $controller->get_servable_content();

                if ($servable) {
                    $controller->require_login();

                    if (!$controller->can_access($user)) {
                        send_file_not_found();
                    }

                    self::serve_servable_content($servable, $sendfileoptions, $forcedownload);
                }
            }

            // If there is a legacy _pluginfile function, this must be attempted first.
            // Note: The legacy functions guarantee an exit.
            self::attempt_deprecated_pluginfile($user, $component, $context, $filearea, $args, $sendfileoptions, $forcedownload);

            // No legacy function found. Return here for now until all legacy code in file_pluginfile() is rewritten.
            // TODO Rewrite to send_file_not_found().
            return;
        }

        // Fetch the servable file.
        $servable = self::fetch_servable_content_from_pluginfile_params($user, $component, $context, $filearea, $args);

        self::serve_servable_content($servable, $sendfileoptions, $forcedownload);
    }

    /**
     * Attempt to call deprecated pluginfile functions.
     *
     * @param   array $args
     */
    protected static function attempt_deprecated_pluginfile(
        object $user,
        string $component,
        context $context,
        string $filearea,
        array $args,
        array $sendfileoptions,
        bool $forcedownload
    ): void {
        // Note: This global $CFG is required because the included file is included in the context of the function
        // including it.
        // The legacy file_pluginfile() function defines the following globals so these must therefore be maintained.
        global $CFG, $DB, $USER;

        $dir = core_component::get_component_directory($component);
        if (!file_exists("{$dir}/lib.php")) {
            return;
        }

        require_once("{$dir}/lib.php");

        [, $course, $cm] = get_context_info_array($context->id);
        // The old format is component_pluginfile.
        self::attempt_deprecated_pluginfile_oldfunction(
            $component,
            $course,
            $cm,
            $context,
            $filearea,
            $args,
            $forcedownload,
            $sendfileoptions
        );

        [$type, $plugin] = core_component::normalize_component($component);
        if ($type === 'mod') {
            // For activities there was an even older format of mod_pluginfile.
            self::attempt_deprecated_pluginfile_oldfunction(
                $plugin,
                $course,
                $cm,
                $context,
                $filearea,
                $args,
                $forcedownload,
                $sendfileoptions
            );
        }
    }

    /**
     * Attempt to call a deprecated pluginfile function if it exists.
     *
     * @param   string $prefix The preefix to place before _pluginfile
     * @param   array $args
     */
    private static function attempt_deprecated_pluginfile_oldfunction(string $prefix, ...$args): void {
        $filefunction = "{$prefix}_pluginfile"; 

        if (function_exists($filefunction)) {
            debugging(
                "The [component]_pluginfile function has been deprecated in favour of the file access API. " .
                "Please update the {$component} component to utilise this.",
                DEBUG_DEVELOPER
            );

            // If the function exists, it must send the file and terminate
            $filefunction(...$args);

            // Poorly behaved function.
            // If the function exists, is called, and does not terminate, then we fall back to sending a 404.
            send_file_not_found();
        }
    }

}
