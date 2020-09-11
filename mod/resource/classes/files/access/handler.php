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
 * Folder activity for Moodle.
 *
 * @package     mod_resource
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_resource\files\access;

use context;
use core_course\files\access\mod_handler;
use core_files\local\access\file_proxy\stored_file_proxy;
use stdClass;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class handler extends mod_handler {

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
     * Convert pluginfile parameters into file params used by the file_storage API.
     *
     * @param   context $context The context that the file is in
     * @param   string $filearea The file area as reported to the pluginfile
     * @param   array $args The remaining args from the pluginfile
     * @return  null|stored_file A stored_file for the given pluginfile params, or null if none was found
     */
    protected function get_stored_file_from_pluginfile_params(context $context, string $filearea, array $args): ?stored_file {
        if (array_key_exists($filearea, parent::get_file_areas())) {
            return parent::get_stored_file_from_pluginfile_params($context, $filearea, $args);
        }

        if (!static::owns_filearea($filearea)) {
            // Invalid file area.
            return null;
        }

        // Most uses of the pluginfile URL have the itemid as the first argument.
        [
            'itemid' => $itemid,
            'args' => $args,
        ] = self::get_itemid_from_pluginfile_params($context, $filearea, $args);

        $filename = rtrim(array_pop($args), '/');
        $relativepath = implode('/', $args) . '/';

        $file = $this->get_stored_file_from_filepath($context, $filearea, $itemid, $relativepath, $filename);

        if (!$file) {
            // The file was not found.
            // This file could be stored in a legacy format, in which case there are three default filenames, and what
            // we thought was the filename is actually just a directory.
            $relativepath = implode('/', array_merge($args, [$filename]));
            $file = $file || $this->get_stored_file_from_filepath($context, $filearea, $itemid, $relativepath, 'index.htm');
            $file = $file || $this->get_stored_file_from_filepath($context, $filearea, $itemid, $relativepath, 'index.html');
            $file = $file || $this->get_stored_file_from_filepath($context, $filearea, $itemid, $relativepath, 'Default.htm');
            $file = $file || $this->find_legacy_file($context, $filearea, $relativepath);
        }

        if (!$file) {
            // File not found.
            return null;
        }

        return $file;
    }

    /**
     * Find legacy course files.
     *
     * @param   context $context
     * @param   string $filearea
     * @param   string $relativepath
     * @return  null|stored_file
     */
    protected function find_legacy_file(context $context, string $filearea, string $relativepath): ?stored_file {
        global $DB;

        $record = $this->get_resource_legacyfile_value($context);
        if ($record->legacyfiles != RESOURCELIB_LEGACYFILES_ACTIVE) {
            // This activity does not contain any legacy files.
            return null;
        }

        $file = resourcelib_try_file_migration("/{$relativepath}", $record->cmid, $record->course, 'mod_resource', 'content', 0);
        if (!$file) {
            // Legacy file migration failed.
            return null;
        }

        // File migration - update flag.
        $DB->set_field('resource', 'legacyfileslast', time(), ['id' => $record->id]);

        return $file;
    }

    /**
     * Get the legacy file details for the resource at the specified context.
     *
     * @param   context $context
     * @return  int
     */
    protected function get_resource_legacyfile_value(context $context): int {
        global $DB;

        $sql = <<<EOF
    SELECT
           r.id rid,
           cm.id AS cmid,
           cm.course,
           r.legacyfiles
      FROM {course_modules} cm
INNER JOIN {modules} m ON cm.module = m.id AND m.modules = :modname
INNER JOIN {resource} r ON r.id = cm.instance
     WHERE cm.id = :cmid
EOF;

        $params = [
            'modname' => 'resource',
            'cmid' => $context->instanceid,
        ];

        return $DB->get_record_sql($sql, $params, MUST_EXIST);
    }

    /**
     * Get the filter value for the resource at the specified context.
     *
     * @param   context $context
     * @return  int
     */
    protected function get_resource_filter_value(context $context): int {
        global $DB;

        $sql = <<<EOF
    SELECT
           r.filterfiles
      FROM {course_modules} cm
INNER JOIN {modules} m ON cm.module = m.id AND m.modules = :modname
INNER JOIN {resource} r ON r.id = cm.instance
     WHERE cm.id = :cmid
EOF;

        $params = [
            'modname' => 'resource',
            'cmid' => $context->instanceid,
        ];

        return $DB->get_field_sql($sql, $params, MUST_EXIST);
    }
}
