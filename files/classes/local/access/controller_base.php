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
namespace core_files\local\access;

use context;
use core_component;
use core_files\local\access as parent_access;
use core_files\local\access\servable_content;
use core_files\local\access\servable_content\servable_stored_file_content;
use stdClass;
use stored_file;

/**
 * File access.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class controller_base {

    /** @var servable_content */
    protected $servablecontent = null;

    /** @var stored_file */
    private $storedfile = null;

    /** @var context The context of the file */
    protected $context = null;

    /** @var string The current component */
    protected $component = null;

    /**
     * @var int The itemid is not present at all in the URL and defaults to zero
     *
     * The URL is in the form:
     *     /pluginfile.php/[contextid]/[component]/[filearea]/[file/path]/[filename.extension]
     *
     * An example of this would be
     *     /pluginfile.php/29/mod_assign/intro/instructions/image_of_cat.png
     *
     *     contextid:   29
     *     component:   mod_assign
     *     filearea:    intro
     *     filepath:    instructions
     *     filename:    image_of_cat.png
     *     itemid:      0
     */
    const ITEMID_NOT_PRESENT = 0;

    /**
     * @var int The itemid is present in the URL but has no meaning and should always be zero
     *
     * The URL is in the form:
     *     /pluginfile.php/[contextid]/[component]/[filearea]/[itemid]/[file/path]/[filename.extension]
     *
     * An example of this would be
     *     /pluginfile.php/29/mod_assign/content/0/workbooks/template.docx
     *
     *     contextid:   29
     *     component:   mod_assign
     *     filearea:    content
     *     itemid:      0
     *     filepath:    workbooks
     *     filename:    template.docx
     */
    const ITEMID_PRESENT_BUT_DEFAULT = 1;

    /**
     *  @var int The itemid is present in the URL and is in use
     *
     * The URL is in the form:
     *     /pluginfile.php/[contextid]/[component]/[filearea]/[itemid]/[file/path]/[filename.extension]
     *
     * An example of this would be
     *     /pluginfile.php/32/mod_forum/attachment/950/cat.png
     *
     *     contextid:   32
     *     component:   mod_forum
     *     filearea:    attachment
     *     itemid:      950
     *     filepath:    [none]
     *     filename:    cat.png
     */
    const ITEMID_PRESENT_IN_USE = 2;

    /**
     * Constructor for a new controller.
     */
    protected function __construct() {
        // Left intentionally empty to allow for later extension.
    }

    /**
     * Create a new instance of the file access controller from a set of pluginfile parameters.
     *
     * @param   stdClass $user The user accessing the file
     * @param   context $context The context that the file is in
     * @param   string $filearea The file area as reported to the pluginfile
     * @param   array $args The remaining args from the pluginfile
     * @param   null|string $component An optional component to provide. If none is provided then the component is
     *          guessed from the namespace
     * @return  controller_base
     */
    public static function create_from_pluginfile_params(
        stdClass $user,
        context $context,
        string $filearea,
        array $args,
        ?string $component = null

    ): self {
        $instance = new static();
        $instance->set_pluginfile_params($context, $filearea, $args);
        $instance->set_component($component);

        return $instance;
    }

    /**
     * Get a list of the file areas in use for this plugin with a mapping containing how the itemid is mapped.
     *
     * For more complex mappings than ITEMID_NOT_PRESENT, ITEMID_PRESENT_BUT_DEFAULT, ITEMID_PRESENT_IN_USE, you will
     * need to extend the @see{get_itemid_from_pluginfile_params} function.
     *
     * @return  string[]
     */
    protected static function get_file_areas(): array {
        return [];
    }

    /**
     * Set the pluginfile parameters.
     *
     * @param   context $context
     * @param   string $filearea
     */
    protected function set_pluginfile_params(context $context, string $filearea, array $args): void {
        $this->context = $context;
        $this->filearea = $filearea;
        $this->pluginfileargs = $args;
    }

    /**
     * Get a list of the itemids for the specified context, and filearea.
     *
     * @param   context $context
     * @param   string $filearea
     * @return  int[]
     */
    protected static function get_itemids_for_context_and_filearea(context $context, string $filearea): array {
        $itemidtype = static::get_itemid_usage_for_filearea($filearea);
        if ($itemidtype === self::ITEMID_NOT_PRESENT || $itemitype === self::ITEMID_PRESENT_BUT_DEFAULT) {
            return [0];
        }

        return [];
    }

    /**
     * Set the name of the component to use.
     *
     * If none is specified then this is guessed from the namespace.
     *
     * @param   null|string $component
     */
    protected function set_component(?string $component = null): void {
        $this->component = $component;
    }

    /**
     * Get the name of the component.
     *
     * @return  string
     */
    protected function get_component(): string {
        if ($this->component === null) {
            $parts = explode('\\', static::class);

            // Return the first level of the namespace.
            $this->component = $parts[0];

            [$type, $plugin] = core_component::normalize_component($this->component);
            if ($type === 'core') {
                $this->component = $plugin;
            }
        }

        return $this->component;
    }

    /**
     * Get a list of the stored files in the context.
     *
     * @param   context $context
     * @return  stored_file[]
     */
    public function get_file_list(context $context, string $component): array {
        $fs = get_file_storage();

        $files = [];
        foreach (self::get_file_areas() as $filearea) {
            foreach (static::get_itemids_for_context_and_filearea($context, $filearea) as $itemid) {
                $files = array_merge(
                    $files,
                    $fs->get_area_files(
                        $context->id,
                        $component,
                        $filearea,
                        $itemid
                    )
                );
            }
        }

        return $files;
    }

    /**
     * Get the itemid usage given the specified file area.
     *
     * @param   string $filearea
     * @return  int
     */
    protected static function get_itemid_usage_for_filearea(string $filearea): ?int {
        if (!static::owns_filearea($filearea)) {
            return null;
        }

        $areas = static::get_file_areas();
        return $areas[$filearea];
    }

    /**
     * Whether this class owns the specified filearea.
     *
     * @param   string $filearea
     * @return  bool
     */
    protected static function owns_filearea(string $filearea): bool {
        return array_key_exists($filearea, static::get_file_areas());
    }

    /**
     * Get the itemid from the pluginfile_params.
     *
     * @param   context $context The context that the file is in
     * @param   string $filearea The file area as reported to the pluginfile
     * @param   array $args The remaining args from the pluginfile
     * @return  array An array containing the args after any changes, and the itemid
     */
    protected function get_itemid_from_pluginfile_params(context $context, string $filearea, array $args): array {
        $itemidtype = $this->get_itemid_usage_for_filearea($filearea);

        if ($itemidtype === self::ITEMID_NOT_PRESENT) {
            // Some component file areas do not include the itemid at all.
            // This is the case in the generic activity 'intro' section, for example.
            $itemid = 0;
        }

        if ($itemidtype === self::ITEMID_PRESENT_BUT_DEFAULT) {
            // Many components have a space in the URL where an itemid would be, but only ever expect an itemid of 0.
            $itemid = 0;
            array_shift($args);
        }

        if ($itemidtype === self::ITEMID_PRESENT_IN_USE) {
            // Most uses of the pluginfile URL have the itemid as the first argument.
            $itemid = array_shift($args);
        }

        return [
            'args' => $args,
            'itemid' => $itemid,
        ];
    }

    /**
     * Convert pluginfile parameters into file params used by the file_storage API.
     *
     * @param   stdClass $user The user accessing the file
     * @param   context $context The context that the file is in
     * @param   string $filearea The file area as reported to the pluginfile
     * @param   array $args The remaining args from the pluginfile
     * @return  null|stored_file A stored_file for the given pluginfile params, or null if none was found
     */
    protected function get_stored_file_from_pluginfile_params(context $context, string $filearea, array $args): ?stored_file {
        if (!static::owns_filearea($filearea)) {
            return null;
        }

        // Most uses of the pluginfile URL have the itemid as the first argument.
        [
            'itemid' => $itemid,
            'args' => $args,
        ] = $this->get_itemid_from_pluginfile_params($context, $filearea, $args);

        $filename = array_pop($args);

        // Get the remaining filepath.
        if (empty($args)) {
            $filepath = '/';
        } else {
            $filepath = '/' . implode('/', $args) . '/';
        }

        return static::get_stored_file_from_filepath($context, $this->get_component(), $filearea, $itemid, $filepath, $filename);
    }

    /**
     * Get the stored file at the specified location.
     *
     * @return  null|stored_file A stored_file for the given params, or null if none was found
     */
    protected static function get_stored_file_from_filepath(context $context, string $component, string $filearea, int $itemid, string $filepath, string $filename): ?stored_file {
        $fs = get_file_storage();
        $file = $fs->get_file(
            $context->id,
            $component,
            $filearea,
            $itemid,
            $filepath,
            $filename
        );

        if (!$file) {
            // File not found.
            return null;
        }

        return $file;
    }

    /**
     * Return the stored file.
     *
     * @return  null|stored_file
     */
    protected function get_stored_file(): ?stored_file {
        if ($this->storedfile === null) {
            $file = $this->get_stored_file_from_pluginfile_params(
                $this->context,
                $this->filearea,
                $this->pluginfileargs
            );

            if ($file) {
                $this->set_stored_file($file);
            }
        }

        return $this->storedfile;
    }

    /**
     * Set the stored file.
     *
     * @param   stored_file $file
     */
    protected function set_stored_file(stored_file $file): void {
        $this->storedfile = $file;
    }

    /**
     * Fetch a servable_content object which can be served.
     *
     * @return  null|servable_content An object which knows how to fetch or serve the file content
     */
    public function get_servable_content(): ?servable_content {
        if ($this->servablecontent === null) {
            if ($file = $this->get_stored_file()) {
                $servablecontent = servable_stored_file_content::create($file);
                $this->set_servable_content_options($servablecontent);

                $this->servablecontent = $servablecontent;
            }
        }

        return $this->servablecontent;
    }

    /**
     * Set the servable content options for the specified servable_content item.
     *
     * @param   servable_content $servable
     */
    protected function set_servable_content_options(servable_content $servable): void {
        $forcedownload = $this->should_force_download();
        if ($forcedownload !== null) {
            $this->servablecontent->set_force_download($forcedownload);
        }

        $sendfileoptions = $this->get_sendfile_option_overrides();
        if (!empty($sendfileoptions)) {
            $this->servablecontent->set_sendfile_options($sendfileoptions);
        }

        $headers = $this->get_pre_sendfile_headers();
        if (!empty($headers)) {
            $this->servablecontent->add_headers($headers);
        }
    }

    /**
     * Set whether the content should be forcibly downloaded.
     *
     * If a null value is returned, then the user-requested value is used, otherwise download is either forcibly set, or
     * forcibly unset.
     *
     * @return  null|bool
     */
    protected function should_force_download(): ?bool {
        return null;
    }

    /**
     * Return a list of options to send_file() and send_stored_file() to forcibly set.
     *
     * @return  array
     */
    protected function get_sendfile_option_overrides(): array {
        return [];
    }

    /**
     * Return a list of headers to add before calling send_file() or send_stored_file().
     *
     * @return  array
     */
    protected function get_pre_sendfile_headers(): array {
        return [];
    }

    /**
     * Whether the user can access the file.
     *
     * @param   null|stdClass $user
     * @return  bool
     */
    public function can_access(?object $user = null): bool {
        if ($file = $this->get_stored_file()) {
            return static::can_access_storedfile($this->get_stored_file());
        }

        return true;
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|stdClass $user
     * @return  bool
     */
    public static function can_access_storedfile(stored_file $file, ?object $user = null): bool {
        return true;
    }

    /**
     * Whether login is required to access this item.
     *
     * @return  bool
     */
    public function requires_login(): bool {
        return false;
    }

    /**
     * Whether login to a specific course required to access this item.
     *
     * @return  bool
     */
    public function requires_course_login(): bool {
        return $this->get_require_course_login_params() !== null;
    }

    /**
     * Get arguments to pass to require_login().
     *
     * @return  array
     */
    public function get_require_login_params(): array {
        return [];
    }

    /**
     * Get arguments to pass to require_course_login(), or null if course login is not required.
     *
     * @return  null|array
     */
    public function get_require_course_login_params(): ?array {
        return null;
    }

    /**
     * Ensure that the user is logged in as required.
     */
    public function require_login(): void {
        if ($this->requires_course_login()) {
            $courseloginparams = $this->get_require_course_login_params();
            require_course_login(...$courseloginparams);
        } else if ($this->requires_login()) {
            $loginparams = $this->get_require_login_params();
            require_login(...$loginparams);
        }
    }

    /**
     * Get the user object to use for testing capabilities and other related areas.
     *
     * @param   object $user
     * @return  object
     */
    protected static function get_user(?object $user = null): object {
        global $USER;

        if ($user) {
            return $user;
        }

        return $USER;
    }

    /**
     * Return the context.
     *
     * @return  context
     */
    protected function get_context(): context {
        return $this->context;
    }

    /**
     * Get the context for the supplied stored_file.
     *
     * @param   stored_file $file
     * @return  context
     */
    protected function get_context_from_stored_file(stored_file $file): context {
        return context::instance_by_id($file->get_contextid());
    }

    /**
     * Attempt to call deprecated pluginfile functions.
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

        $filefunction = "{$component}_pluginfile";

        if (function_exists($filefunction)) {
            debugging(
                "The [component]_pluginfile function has been deprecated in favour of the file access API. " .
                "Please update the {$component} component to utilise this.",
                DEBUG_DEVELOPER
            );

            // If the function exists, it must send the file and terminate>
            $filefunction($course, $cm, $context, $filearea, $args, $forcedownload, $sendfileoptions);

            // Poorly behaved function.
            // If the function exists, is called, and does not terminate, then we fall back to sending a 404.
            send_file_not_found();
        }
    }
}
