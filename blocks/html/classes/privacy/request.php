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
 * Privacy Subsystem implementation for block_html.
 *
 * @package    block_html
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_html\privacy;

use \core_privacy\request\exporter;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy Subsystem implementation for block_html.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class request implements \core_privacy\metadata\provider, \core_privacy\request\plugin_provider {

    public static function get_metadata(\core_privacy\metadata\items $items) {
    }

    /**
     * @inheritdoc
     */
    public static function get_contexts_for_userid(int $userid) : \core_privacy\request\resultset {
        // This block doesn't know who information is stored against unless it
        // is at the user context.
        return new \core_privacy\request\resultset();
    }

    /**
     * @inheritdoc
     */
    public static function store_user_data(int $userid, array $contexts) {
        global $DB;

        $writer = \core_privacy\request\helper::get_writer();

        if (empty($contexts)) {
            return;
        }

        $contextids = array_map(function($context) {
            return $context->id;
        }, $contexts);

        list($contextsql, $contextparams) = $DB->get_in_or_equal($contextids, SQL_PARAMS_NAMED);

        $sql = "SELECT
                    c.id AS contextid,
                    bi.*
                  FROM {context} c
            INNER JOIN {block_instances} bi ON bi.id = c.instanceid AND c.contextlevel = :contextlevel
                 WHERE (
                    c.id {$contextsql}
                )
        ";

        $params = [
            'contextlevel' => CONTEXT_BLOCK,
        ];
        $params = $contextparams;

        $instances = $DB->get_recordset_sql($sql, $params);
        foreach ($instances as $instance) {
            $context = \context_block::instance($instance->contextid);
            $writer->set->context($context);

            // TODO Consider moving this to the manager.
            $block = block_instance('block_html', $instance);

            // Get data - use a Mustache template.
            $title = $block->config->title;
            $html = $block->config->text;

            $html = $writer->rewrite_pluginfile_urls([], 'block_html', 'content', null, $html);

            // Default to FORMAT_HTML which is what will have been used before the
            // editor was properly implemented for the block.
            $format = isset($block->config->format) ? $block->config->format : FORMAT_HTML;

            $filteropt = (object) [
                'overflowdiv' => true,
                'noclean' => true,
            ];
            $html = format_text($html, $format, $filteropt);

            // Store data.
            $writer->store_custom_file([], 'content.html', $html);

        }
        $instances->close();
    }
}
