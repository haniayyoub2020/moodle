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
 * Web service functions relating to forum grades and grading.
 *
 * @package    mod_forum
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types = 1);

namespace mod_forum\grades;

use external_api;
use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;
use mod_forum\local\container;
use mod_forum\grades\gradeitem;
use core_grades\local\item\helper as gradeitem_helper;

/**
 * External forum API
 *
 * @package    mod_forum
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external extends external_api {
    /**
     * Describes the parameters for saving a grade within a forum.
     *
     * @return external_function_parameters
     * @since Moodle 3.8
     */
    public static function save_grade_parameters(): external_function_parameters {
        return new external_function_parameters ([
            'forumid' => new external_value(
                PARAM_INT,
                'The ID of the forum',
                VALUE_REQUIRED
            ),
            'itemname' => new external_value(
                PARAM_ALPHANUM,
                'The grade item itemname being saved',
                VALUE_REQUIRED
            ),
            'gradeduser' => new external_value(
                PARAM_INT,
                'The ID of the user whow as graded',
                VALUE_REQUIRED
            ),
            'formdata' => new external_value(
                PARAM_RAW,
                'The serialised form data representing the grade',
                VALUE_REQUIRED
            ),
        ]);
    }

    /**
     * Save the grade data from the form to the forum specified.
     *
     * @param int $forumid
     * @param string $itemname
     * @param string $formdata
     * @return array
     * @since Moodle 3.8
     */
    public static function save_grade(int $forumid, string $itemname, int $gradeduser, string $formdata): array {
        global $USER;

        [
            'forumid' => $forumid,
            'itemname' => $itemname,
            'gradeduser' => $gradeduser,
            'formdata' => $formdata,
        ] = self::validate_parameters(self::get_forums_by_courses_parameters(), [
            'forumid' => $forumid,
            'itemname' => $itemname,
            'gradeduser' => $gradeduser,
            'formdata' => $formdata,
        ]);

        // Validate that the supplied itemname is a gradable item.

        // Get all the factories that are required.
        $vaultfactory = forum_container::get_vault_factory();
        $forumvault = $vaultfactory->get_forum_vault();
        $forum = $forumvault->get_from_id($forumid);

        // Validate the context.
        self::validate_context($forum->get_context());

        // Validate the required capabilities.
        $managerfactory = forum_container::get_manager_factory();
        $capabilitymanager = $managerfactory->get_capability_manager($forum);
        if (!$capabilitymanager->can_grade($itemname)) {
            // throw new exception for access denied.
        }

        // Validate that this forum actually has the supplied gradeitem as a gradable thing.

        // Fetch the gradeitem instance.
        $gradeitem = new gradeitem($forum, $itemname);

        // Parse the serialised string into an object.
        $data = [];
        parse_str($formdata, $data);

        // Grade.
        $success = $gradeitem->store_grade_from_formdata($gradeduser, $USER->id, $data);

        if (!$success) {
            // TODO
            // If it failed, we want to know why.
        }

        return [
            'success' => $success,
            'warnings' => [],
        ];
    }

    /**
     * Describes the data returned from the save_grade function.
     *
     * @return external_multiple_structure
     * @since Moodle 3.8
     */
    public static function save_data_returns(): external_single_structure {
        return new external_single_structure([
            'warnings' => new external_warnings(),
        ]);
    }
}
