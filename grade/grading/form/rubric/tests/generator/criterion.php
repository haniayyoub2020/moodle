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
 * @copyright  2018 Adrian Greeve <adriangreeve.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Convenience class to create rubric criterion.
 *
 * @copyright  2018 Adrian Greeve <adriangreeve.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gradingform_rubric_generator_criterion {
    /** @var string $description A description of the criterion. */
    public $description;

    /** @var integer $sortorder sort order of the criterion. */
    public $sortorder = 0;

    /** @var integer $levelid The current level id  for this level*/
    public $levelid = 0;

    /** @var array $levels The levels for this criterion. */
    public $levels = [];

    /**
     * Constructor for this test_criterion object
     *
     * @param string $description A description of this criterion.
     */
    public function __construct(string $description, array $levels = []) {
        $this->description = $description;
        foreach ($levels as $definition => $score) {
            $this->add_level($definition, $score);
        }
    }

    /**
     * Adds levels to the criterion.
     *
     * @param string $definition The definition for this level.
     * @param int $score The score received if this level is selected.
     * @return self
     */
    public function add_level(string $definition, int $score): self {
        $this->levelid++;
        $this->levels['NEWID' . $this->levelid] = [
            'definition' => $definition,
            'score' => $score
        ];

        return $this;
    }

    /**
     * Get the description for this criterion.
     *
     * @return string
     */
    public function get_description(): string {
        return $this->description;
    }

    /**
     * Get the levels for this criterion.
     *
     * @return array
     */
    public function get_levels(): array {
        return $this->levels;
    }
}
