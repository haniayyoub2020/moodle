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
 * Privacy Subsystem implementation for core_tags.
 *
 * @package    core_tags
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_tag\privacy\request;

use \core_privacy\request\exporter;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy Subsystem implementation for core_tags.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\request\subsystem_provider {
    public static function store_user_data(int $userid, \context $context, array $subcontext, exporter $exporter, string $component, string $tagarea, int $itemid, bool $onlyuser = true) {
        global $DB;

        $sql = "SELECT
                    r.*
                  FROM {tag} r
                 WHERE r.component = :component
                   AND r.tagarea = :tagarea
                   AND r.itemid = :itemid";

        $params = [
            'component'     => $component,
            'tagarea'    => $tagarea,
            'itemid'        => $itemid,
        ];

        if ($onlyuser) {
            $sql .= " AND r.userid = :userid";
            $params['userid'] = $userid;
        }


        $tags = $DB->get_records_sql($sql, $params);

        static::store_tags($userid, $context, $subcontext, $exporter, $tags);
    }

    public static function store_tags(int $userid, \context $context, array $subcontext, exporter $exporter, $tags) {
        foreach ($tags as $tag) {
            // Do tidyup work?
            \core_user\privacy\request\transformation::user($userid, $tag, ['userid']);
        }
        if ($tags) {
            $data = json_encode($tags);
            $exporter->store_custom_file($context, $subcontext, 'tag.json', $data);
        }
    }
}
