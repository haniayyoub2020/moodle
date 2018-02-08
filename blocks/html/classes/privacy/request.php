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

    public static function get_metadata() : \core_privacy\metadata\items {
        return new \core_privacy\metadata\items();
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
    public static function store_user_data(int $userid, array $contexts, exporter $exporter) {
        global $DB;

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
            $context = \context_block::instance($forum->cmid);

            // Store relevant metadata about this forum instance.
            static::store_digest_data($userid, $context, $exporter, $forum);
            static::store_subscription_data($userid, $context, $exporter, $forum);
            static::store_tracking_data($userid, $context, $exporter, $forum);

            $mappings[$forum->id] = $forum->contextid;
        }
        $forums->close();

        if (!empty($mappings)) {
            // Store all discussion data for this forum.
            static::store_discussion_data($userid, $mappings, $exporter);

            // Store all post data for this forum.
            static::store_post_data($userid, $mappings, $exporter);
        }
    }
}
