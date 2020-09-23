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
 * Content API File Area definition.
 *
 * @package     core_files
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core;

use context;
use core_component;
use core\content\servable_item;
use moodle_url;
use stdClass;
use stored_file;
use core\content\controllers\component_file_controller;
use core\content\controllers\plugintype_file_controller;


/**
 * The Content API allows all parts of Moodle to determine details about content within a component, or plugintype.
 *
 * This includes the description of files.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class content {

    /**
     * Get the servable content from the parameters from a pluginfile URL.
     *
     * @param   string $component The component in the URL
     * @param   context $context The context of the contextid in the URL
     * @param   string $filearea The filearea in the URL
     * @param   array $args The array of arguments in the pluginfile URL after the component, context, and filearea have
     *          been removed
     * @param   stdClass $user The user accessing the content
     * @return  null|servable_item
     */
    public static function get_servable_item_from_pluginfile_params(
        string $component,
        context $context,
        string $filearea,
        array $args,
        stdClass $user
    ): ?servable_item {
        $args = func_get_args();

        return self::call_file_controller_function_for_component(
            $component,
            'get_servable_item_from_pluginfile_params',
            $args
        );
    }

    /**
     * Check whether the specified use can access the supplied stored_file in the supplied context.
     *
     * @param   stored_file $file
     * @param   stdClass $user
     * @param   context $context
     * @return  bool
     */
    public static function can_access_stored_file_from_context(stored_file $file, stdClass $user, context $context): bool {
        $args = func_get_args();

        $result =  self::call_file_controller_function_for_component(
            $component,
            'can_access_stored_file_from_context',
            $args
        );

        if ($result === null) {
            return false;
        }

        return $result;
    }

    /**
     * Serve some servable content given the sendfile options.
     *
     * @param   null|servable_item $servable
     * @param   array $sendfileoptions
     * @param   bool $forcedownload
     */
    public static function serve_servable_item(?servable_item $content, array $sendfileoptions, bool $forcedownload): void {
        if (!$content) {
            send_file_not_found();
        }

        // Close the session to prevent it blocking during large file transmission.
        \core\session\manager::write_close();

        // Serve the file.
        $content->send_file($sendfileoptions, $forcedownload);
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
    public static function serve_file_from_pluginfile_params(
        string $component,
        context $context,
        string $filearea,
        array $args,
        object $user,
        array $sendfileoptions,
        bool $forcedownload
    ): void {
        // Fetch the servable file.
        $servable = self::get_servable_item_from_pluginfile_params($component, $context, $filearea, $args, $user);
        if ($servable) {
            $servable->call_require_login_if_needed();

            if ($servable->can_access_content($user, $context)) {
                self::serve_servable_item($servable, $sendfileoptions, $forcedownload);
            } else {
                send_file_not_found();
            }
        }

        // The supplied component did not return a file.
        // In the future this will return a file not found, but for now it will return void to allow the legacy
        // `file_pluginfile` system to serve legacy content.
    }

    /**
     * Get a moodle_url which represents a stored_file.
     *
     * The viewcontext is required where the file is viewed from a different context. For example the course context is
     * used for the course variant of a user profile, but the file sits in a user context.
     *
     * @param   stored_file $file The file to create a pluginfile URL for
     * @param   bool $forcedownload Request a URL which will cause the file to be forcible downloaded
     * @param   bool $tokenurl Request a URL which includes an authentication token so that an existing login session
     *          is not required for the user to view the file
     * @param   null|context $viewcontext The alternate context to use in the URL. If none is provided then the file's
     *          context is used
     * @return  moodle_url
     */
    public static function get_pluginfile_url_for_stored_file(
        stored_file $file,
        bool $forcedownload = false,
        bool $tokenurl = false,
        ?context $viewcontext
    ): moodle_url {
        $args = func_get_args();

        return self::call_file_controller_function_for_component(
            $component,
            'get_pluginfile_url_for_stored_file',
            $args
        );

    }

    /**
     * Call the supplied function on the file controller for the specified component, checking any relevant parent plugintype.
     *
     * @param   string $component
     * @param   string $function
     * @param   array $args The array of arguments to provide
     * @return  mixed
     */
    protected static function call_file_controller_functions_for_component(string $component, string $functionname, array $args) {
        $functionargs = func_get_args();
        $result = self::call_file_controller_function_for_component(...$functionargs);
        if ($result !== null) {
            return $result;
        }

        $result = self::call_file_controller_function_for_component_plugintype(...$functionargs);
        if ($result !== null) {
            return $result;
        }

        $result = self::call_file_controller_functions_for_legacy_invaid_component(...$functionargs);
        if ($result !== null) {
            return $result;
        }

        return null;
    }

    /**
     * Call the supplied function on the file controller specified component.
     *
     * @param   string $component
     * @param   string $function
     * @param   array $args The array of arguments to provide
     * @return  mixed
     */
    protected static function call_file_controller_function_for_component(string $component, string $functionname, array $args) {
        // Attempt to fetch the servable content from the component.
        $componentclass = self::get_contentarea_classname_for_component($component);
        if (class_exists($componentclass)) {
            return $componentclass::$functionname(...$args);
        }

        return null;
    }

    /**
     * Call the supplied function on the file controller for the plugintype of the specified component.
     *
     * @param   string $component
     * @param   string $function
     * @param   array $args The array of arguments to provide
     * @return  mixed
     */
    protected static function call_file_controller_function_for_component_plugintype(string $component, string $functionname, array $args) {
        // Check whether the plugin type knows this filearea.
        $componentclass = self::get_contentarea_classname_for_component_plugintype($component);
        if (class_exists($componentclass)) {
            return $componentclass::$functionname(...$args);
        }

        return null;
    }

    /**
     * Call the supplied function for the legacy invalid component list.
     *
     * @param   string $component
     * @param   string $function
     * @param   array $args The array of arguments to provide
     * @return  mixed
     */
    protected static function call_file_controller_functions_for_legacy_invaid_component(string $component, string $functionname, array $args) {

        // TODO fallback for legacy values which use an incorrect component name.
        if ($component === 'grouping') {
        }

        return null;

    }

    /**
     * Get the contentarea classname for a plugintype.
     *
     * @param   string $plugintype The plugin type, for example 'block', 'mod', etc.
     * @return  string The classname
     */
    protected static function get_contentarea_classname_for_component_plugintype(string $component): string {
        return plugintype_file_controller::get_contentarea_classname_for_component($component);
    }

    /**
     * Get the contentarea classname for a component.
     *
     * @param   string $component The component name
     * @return  string The classname
     */
    protected static function get_contentarea_classname_for_component(string $component): string {
        return component_file_controller::get_contentarea_classname_for_component($component);
    }

    /**
     * Get a list of stored_file instances in the current component and context combination.o
     *
     * @param   context $context
     * @param   string $component
     * @return  stored_file[]
     */
    public static function get_all_files_in_context(context $context, string $component): array {
        $functionargs = func_get_args();

        return self::call_file_controller_functions_for_component(
            $component,
            'get_all_files_in_context',
            $functionargs
        );
    }
}
