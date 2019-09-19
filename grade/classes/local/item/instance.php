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
 * Grade item storage for core_grades.
 *
 * @package   core_grades
 * @copyright Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types = 1);

namespace core_grades\local\item;

use stdClass;
use core_grades\local\item\helper as grade_item_helper;
use gradingform_controller;
use gradingform_instance;
use context;

/**
 * Grade item storage for core_grades.
 *
 * @package   core_grades
 * @copyright Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class instance {
    /** @var array The scale data for the current grade item */
    protected $scale;

    /** @var string The component */
    protected $component;

    /** @var context The context for this activity */
    protected $context;

    /** @var string The item name */
    protected $itemname;

    /** @var int The grade itemnumber */
    protected $itemnumber;

    /**
     * Configure the grade item.
     *
     * @param string $component
     * @param string $itemname
     */
    public function __construct(string $component, context $context, string $itemname) {
        $this->context = $context;
        $this->component = $component;
        $this->itemname = $itemname;
        $this->itemnumber = grade_item_helper::get_itemnumber_from_itemname($component, $itemname);
    }

    /**
     * The table name used for grading.
     *
     * @return string
     */
    abstract protected function get_table_name(): string;

    /**
     * Get the grade value for this instance.
     * The itemname is translated to the relevant grade field for the activity.
     *
     * @param string $itemname
     * @return int
     */
    abstract protected function get_gradeitem_value(): ?int;

    /**
     * Get the scale if a scale is being used.
     *
     * @return stdClass
     */
    protected function get_scale(): ?stdClass {
        $gradetype = $this->get_gradeitem_value();
        if ($gradetype > 0) {
            return null;
        }

        // This is a scale.
        if (null === $this->scale) {
            $this->scale = $DB->get_record('scale', ['id' => -1 * $gradetype]);
        }

        return $this->scale;
    }

    /**
     * Check whether a scale is being used for this grade item.
     *
     * @return bool
     */
    protected function is_using_scale(): bool {
        $gradetype = $this->get_gradeitem_value();

        return $gradetype < 0;
    }

    /**
     * Whether decimals are allowed.
     *
     * @return bool
     */
    protected function allow_decimals(): bool {
        return $this->get_gradeitem_value() > 0;
    }

    /**
     * Get the advanced grading controller if advanced grading is enabled.
     *
     * @return gradingform_controller
     */
    protected function get_advanced_grading_controller(): ?gradingform_controller {
        require_once(__DIR__ . '/../../../grading/lib.php');
        $gradingmanager = get_grading_manager($this->context, $this->component, $this->itemname);

        $gradinginstance = null;
        if ($gradingmethod = $gradingmanager->get_active_method()) {
            return $gradingmanager->get_controller($gradingmethod);
        }

        return null;
    }

    /**
     * Get the advanced grading menu items.
     *
     * @return array
     */
    protected function get_advanced_grading_grade_menu(): array {
        return make_grades_menu($this->get_gradeitem_value());
    }

    /**
     * Check whether the supplied grade is valid.
     *
     * @param int $grade The value being checked
     * @return bool
     */
    protected function is_grade_valid(?int $grade): bool {
        if ($this->is_using_scale()) {
            // Fetch all options for this scale.
            $scaleoptions = make_menu_from_list($this->get_scale());
            if (!array_key_exists($grade, $scaleoptions)) {
                // The selected option did not exist.
                return false;
            }
        } else if ($grade) {
            $maxgrade = $this->get_gradeitem_value();
            if ($grade > $maxgrade) {
                // The grade is greater than the maximum possible value.
                return false;
            } else if ($grade < 0) {
                // Negative grades are not supported.
                return false;
            }
        }

        return true;
    }

    /**
     * Create an empty row in the grade for the specified user and grader.
     *
     * @param int $userid
     * @param int $grader
     * @return int The id of the newly created grade record
     */
    abstract public function create_empty_grade(int $userid, int $grader): int;

    /**
     * Get the grade record for the specified grade id.
     *
     * @param int $gradeid
     * @return stdClass
     */
    public function get_grade(int $gradeid): stdClass {
        global $DB;

        $grade = $DB->get_record($this->get_table_name(), ['id' => $gradeid]);

        return $grade ?: null;
    }

    /**
     * Get the grade for the specified user.
     *
     * @param int $itemnumber The specific grade item to fetch for the user
     * @param int $userid The user to fetch
     * @return stdClass The grade value
     */
    abstract public function get_grade_for_user(int $userid, int $grader = null): ?stdClass;

    /**
     * Get grades for all users for the specified gradeitem.
     *
     * @param int $itemnumber The specific grade item to fetch for the user
     * @return stdClass[] The grades
     */
    abstract public function get_all_grades(): array;

    /**
     * Create or update the grade.
     *
     * @param stdClass $grade
     * @return bool Success
     */
    abstract protected function store_grade(stdClass $grade): bool;

    /**
     * Create or update the grade.
     *
     * @param int $userid The user being graded
     * @param int $grader The user who is grading
     * @param array $formdata The data submitted
     * @return bool Success
     */
    public function store_grade_from_formdata(int $userid, int $grader, array $formdata): bool {
        $grade = $this->get_grade_for_user($userid, $grader);

        if ($gradinginstance = $this->get_advanced_grading_instance($grade)) {
            $grade->grade = $gradinginstance->submit_and_get_grade($formdata->advancedgrading, $grade->id);
        } else {
            // Handle the case when grade is set to No Grade.
            if (isset($formdata->grade)) {
                $grade->grade = grade_floatval(unformat_float($formdata->grade));
            }
        }

        return $this->store_grade($grade);
    }

    /**
     * Get the advanced grading instance for the specified grade entry.
     *
     * @param stdClass $grade The row from the grade table.
     * @return gradingform_instance
     */
    protected function get_advanced_grading_instance(stdClass $grade): ?gradingform_instance {
        $controller = $this->get_advanced_grading_controller($this->itemname);

        if (empty($controller)) {
            // Advanced grading not enabeld for this item.
            return null;
        }

        if ($controller->is_form_available()) {
            // The form is not available for this item.
            return null;
        }

        // Fetch the instance for the specified grader/itemid.
        $gradinginstance = $controller->fetch_instance(
            $grade->grader,
            $grade->id
        );

        // Set the allowed grade range.
        $gradinginstance->get_controller()->set_grade_range(
            $this->get_grading_grade_menu(),
            $this->allow_decimals()
        );

        return $gradinginstance;
    }
}
