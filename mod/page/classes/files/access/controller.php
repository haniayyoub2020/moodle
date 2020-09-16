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
 * Page activity for Moodle.
 *
 * @package     mod_page
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_page\files\access;

use context;
use core_files\local\access\mod_controller;
use core_files\local\access\servable_content;
use core_files\local\access\servable_content\servable_stored_file_content;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends mod_controller {

    /** @var object The page record */
    protected $page = null;

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            'content' => self::ITEMID_PRESENT_BUT_DEFAULT,
        ]);
    }

    /**
     * Fetch a file proxy which can be served.
     *
     * @param   stdClass $user The user accessing the file
     * @param   context $context The context that the file is in
     * @param   string $filearea The file area as reported to the pluginfile
     * @param   array $args The remaining args from the pluginfile
     * @return  null|servable_stored_file_content An object which knows how to fetch or serve the file content
     */
    public function get_servable_content(): ?servable_content {
        if (array_key_exists($this->filearea, parent::get_file_areas())) {
            return parent::get_servable_content();
        }

        // All files in mod_page have a URL of either:
        // - /[context]/[component]/[filearea]/index.html; or
        // - /[context]/[component]/[filearea]/index.htm; or
        // - /[context]/[component]/[filearea]/[revision]/path/to/file.png .

        // Most uses of the pluginfile URL have the itemid as the first argument.
        [
            'itemid' => $itemid,
            'args' => $args,
        ] = $this->get_itemid_from_pluginfile_params($this->context, $this->filearea, $this->pluginfileargs);

        if ($itemid === 'index.html' || $itemid === 'index.html') {
            $page = $this->get_page();

            if (!$page) {
                // No page found.
                return null;
            }

            $filename = $itemid;
            $context = $this->context;
            $servable = servable_callback_content::create(function() use ($filename, $context, $page) {
                // Rewrite the pluginfile URLs so the media filters can work.
                $content = file_rewrite_pluginfile_urls(
                    $page->content,
                    'webservice/pluginfile.php',
                    $context->id,
                    'mod_page',
                    'content',
                    $page->revision
                );
                $content = format_text($content, $page->contentformat, (object) [
                    'noclean' => true,
                    'overflowdiv' => true,
                    'context' => $context,
                ]);

                // Remove @@PLUGINFILE@@/.
                $content = file_rewrite_pluginfile_urls(
                    $content,
                    'webservice/pluginfile.php',
                    $context->id,
                    'mod_page',
                    'content',
                    $page->revision,
                    ['reverse' => true]
                );
                $content = str_replace('@@PLUGINFILE@@/', '', $content);

                return $content;
            });

            $servable->set_force_download(true);
            return $servable;
        }

        // Just a regular file.
        if ($file = $this->get_stored_file()) {
            return servable_stored_file_content::create($file);
        }

        return null;
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
        global $DB;

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

        $file = static::get_stored_file_from_filepath($context, $this->get_component(), $filearea, $itemid, $filepath, $filename);

        if ($file) {
            return $file;
        }

        // The file was not found. Check the legacy variant.
        $page = $this->get_page();
        if ($page->legacyfiles != RESOURCELIB_DISPLAY_POPUP) {
            return null;
        }

        $cm = self::get_cm_from_context($context);
        $file = resourcelib_try_file_migration("/{$filepath}", $cm->id, $cm->course, 'mod_page', 'content', 0);

        if ($file) {
            // File migrate - update flag.
            $page->legacyfileslast = time();
            $DB->update_record('page', $page);

            return $file;
        } else {
            // Legacy variant not found.
            return null;
        }
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

        $context = context::instance_by_id($file->get_contextid());
        if (!has_capability("mod/page:view", $context, $user)) {
            return false;
        }

        return true;
    }

    /**
     * Get the page object.
     *
     * @return  object
     */
    protected function get_page(): ?object {
        if ($this->page === null) {
            $cm = self::get_cm_from_context($context);
            $this->page = $DB->get_record('page', ['id' => $cm->instance]);
        }

        return $this->page;
    }
}
