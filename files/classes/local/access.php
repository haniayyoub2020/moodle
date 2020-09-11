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
use core_files\local\access\handler_base;
use core_files\local\access\file_proxy;

/**
 * File access.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class access {
    /**
     * Get the handler classname from the frankenstyle component.
     *
     * @param   string $component
     * @return  string
     */
    protected static function get_file_handler_classname_for_component(string $component): string {
        return "{$component}\\files\\access\\handler";
    }

    /**
     * Whether the component implements the File Handler API.
     *
     * @param   string $component
     * @return  bool
     */
    protected static function component_implements_file_handler_api(string $component): bool {
        $classname = self::get_file_handler_classname_for_component($component);

        if (!class_exists($classname)) {
            return false;
        }

        if (!is_subclass_of($classname, handler_base::class)) {
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
     * @return  null|file_proxy
     */
    public static function fetch_file_proxy_from_pluginfile_params(
        object $user,
        string $component,
        context $context,
        string $filearea,
        array $args
    ): ?file_proxy {
        if (!self::component_implements_file_handler_api($component)) {
            // This component does not implement the new API.
            // Note: Not all components handle files, so no debugging notice should be added here.
            return null;
        }

        $classname = self::get_file_handler_classname_for_component($component);
        $handler = $classname::create_from_pluginfile_params($user, $context, $filearea, $args);

        // Attempt to get a metafile.
        $file = $handler->get_file_proxy();

        if (!$file) {
            return null;
        }

        if ($handler->requires_login()) {
            // This item requires login of some kind.
            if ($courseloginargs = $handler->get_required_course_login_args()) {
                require_course_login(...$courseloginargs);
            } else {
                require_login();
            }
        }

        if (!$handler->can_access($user)) {
            return null;
        }

        return $file;
    }

    /**
     * Serve a file from the file proxy, given the sendfile options.
     *
     * @param   file_proxy $file
     * @param   array $sendfileoptions
     * @param   bool $forcedownload
     */
    public static function serve_file_proxy(file_proxy $file, array $sendfileoptions, bool $forcedownload): void {
        $file->send_file($sendfileoptions, $forcedownload);
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
    public static function handle_pluginfile(object $user, string $component, context $context, string $filearea, array $args, array $sendfileoptions, bool $forcedownload): void {
        if (!self::component_implements_file_handler_api($component)) {
            // This component does not implement the new API.
            // Note: Not all components handle files, so no debugging notice should be added here.

            $dir = core_component::get_component_directory($component);
            if (!file_exists("$dir/lib.php")) {
                send_file_not_found();
            }
            include_once("$dir/lib.php");

            $filefunction = $component.'_pluginfile';
            if (function_exists($filefunction)) {
                // if the function exists, it must send the file and terminate. Whatever it returns leads to "not found"
                $filefunction($course, $cm, $context, $filearea, $args, $forcedownload, $sendfileoptions);
            }

            [$type, $plugin] = core_component::normalize_component($component);

            $classname = "core_files\\local\\access\\{$type}_handler";
            error_log($classname);
            if (class_exists($classname)) {
                $handler = $classname::create_from_pluginfile_params($user, $context, $filearea, $args);

                // Attempt to get a metafile.
                $file = $handler->get_file_proxy();

                if (!$file) {
                    send_file_not_found();
                }

                if ($handler->requires_login()) {
                    // This item requires login of some kind.
                    if ($courseloginargs = $handler->get_required_course_login_args()) {
                        require_course_login(...$courseloginargs);
                    } else {
                        require_login();
                    }
                }

                if (!$handler->can_access($user)) {
                    send_file_not_found();
                }

                self::serve_file_proxy($file, $sendfileoptions, $forcedownload);
            }

            return;
        }

        // Fetch the file proxy
        $file = self::fetch_file_proxy_from_pluginfile_params($user, $component, $context, $filearea, $args);

        if (!$file) {
            send_file_not_found();
        }

        self::serve_file_proxy($file, $sendfileoptions, $forcedownload);
    }
}
