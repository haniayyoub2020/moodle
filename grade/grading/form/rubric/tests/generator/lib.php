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
 * Generator for the gradingforum_rubric plugin.
 *
 * @package    core_grades
 * @category   test
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/rubric.php');
require_once(__DIR__ . '/criterion.php');

/**
 * Generator for the gradingforum_rubric plugintype.
 *
 * @package    core_grades
 * @category   test
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gradingform_rubric_generator extends component_generator_base {

    /**
     * Get a new rubric for use with the rubric controller.
     *
     * Note: This is just a helper class used to build a new definition. It does not persist the data.
     *
     * @param string $name
     * @param string $description
     * @return gradingform_rubric_generator_rubric
     */
    public function get_rubric(string $name, string $description): gradingform_rubric_generator_rubric {
        return new gradingform_rubric_generator_rubric($name, $description);
    }

    /**
     * Get a new rubric for use with a gradingform_rubric_generator_rubric.
     *
     * Note: This is just a helper class used to build a new definition. It does not persist the data.
     *
     * @param string $description
     * @param array $levels Set of levels in the form definition => score
     * @return gradingform_rubric_generator_criterion
     */
    public function get_criterion(string $description, array $levels = []): gradingform_rubric_generator_criterion {
        return new gradingform_rubric_generator_criterion($description, $levels);
    }
}
