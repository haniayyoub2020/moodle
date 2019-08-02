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
 * Define all of the selectors we will be using on the grading interface.
 *
 * @module     core_grades/unified_grader
 * @package    core_grades
 * @copyright  2019 Mathew May <mathew.solutions>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

export const selectors = () => {
    const regions = [
        ["user", ".grader-user-navigation"],
        ["moduleContent", ".grader-module-content"],
        ["gradePane", ".grader-grading-panel"],
        ["gradingActions", ".grader-grading-actions"]
    ];
    const mapping = [
        ["userNavigation", ".user-nav-toggle"],
        ["moduleContent", ".module-content-toggle"],
        ["gradePane", ".grading-panel-toggle"],
        ["gradingActions", ".grading-actions-toggle"],
        [regions, regions]

    ];
    return mapping;
};
