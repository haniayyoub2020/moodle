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
 * Grade item storage for mod_forum.
 *
 * @package   mod_forum
 * @copyright Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types = 1);

namespace mod_forum\grades;

use stdClass;
use coding_exception;
use mod_forum\local\entities\forum as forum_entity;
use code_grades\local\item\itemnumber_mapping\helper as grade_item_helper;
use core_grades\local\item\instance as abstract_gradeitem;
use gradingform_instance;

/**
 * Grade item storage for mod_forum.
 *
 * @package   mod_forum
 * @copyright Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gradeitem extends abstract_gradeitem {
    /** @var forum_entity The forum entity being graded */
    protected $forum;

    /**
     * Configure the grade item.
     *
     * @param forum_entity $forum The forum being graded
     * @param string $itemname
     */
    public function __construct(forum_entity $forum, string $itemname) {
        $this->forum = $forum;

        parent::__construct('mod_forum', $forum->get_context(), $itemname);
    }

    /**
     * The table name used for grading.
     *
     * @return string
     */
    protected function get_table_name(): string {
        return 'forum_grades';
    }

    /**
     * Get the grade value for this instance.
     * The itemname is translated to the relevant grade field on the forum entity.
     *
     * @param string $itemname
     * @return int
     */
    protected function get_gradeitem_value(): int {
        $getter = "get_grade_for_{$this->itemname}";

        return $this->forum->{$getter}();
    }

    /**
     * Create an empty forum_grade for the specified user and grader.
     *
     * @param int $userid
     * @param int $grader
     * @return int The id of the newly created forum_grade
     */
    public function create_empty_grade(int $userid, int $grader): int {
        global $DB;

        $grade = (object) [
            'forum' => $this->forum->get_id(),
            'itemnumber' => $this->itemnumber,
            'userid' => $userid,
            'graderid' => $grader,
            'timemodified' => time(),
        ];
        $grade->timecreated = $grade->timemodified;

        return $DB->insert_record('forum_grades', $grade);
    }

    /**
     * Get the grade for the specified user.
     *
     * @param int $itemnumber The specific grade item to fetch for the user
     * @param int $userid The user to fetch
     * @return stdClass The grade value
     */
    public function get_grade_for_user(int $userid, int $grader = null): ?stdClass {
        global $DB;

        $params = [
            'forum' => $this->forum->get_id(),
            'itemnumber' => $this->itemnumber,
            'userid' => $userid,
        ];

        if ($grader) {
            $params['graderid'] = $grader;
        }

        $grade = $DB->get_record('forum_grades', $params);

        return $grade ?: null;
    }

    /**
     * Get grades for all users for the specified gradeitem.
     *
     * @param int $itemnumber The specific grade item to fetch for the user
     * @return stdClass[] The grades
     */
    public function get_all_grades(): array {
        global $DB;

        return $DB->get_records('forum_grades', [
            'forum' => $this->forum->get_id(),
            'itemnumber' => $this->itemnumber,
        ]);
    }

    /**
     * Create or update the grade.
     *
     * @param stdClass $grade
     * @return bool Success
     */
    protected function store_grade(stdClass $grade): bool {
        global $DB;

        if ($grade->forum != $this->forum->get_id()) {
            throw new coding_exception('Incorrect forum provided for this grade');
        }

        if ($grade->itemnumber != $this->itemnumber) {
            throw new coding_exception('Incorrect itemnumber provided for this grade');
        }

        if (!$this->is_grade_valid($grade->grade)) {
            return false;
        }

        $grade->forum = $this->forum->get_id();
        $grade->timemodified = time();

        $DB->update_record('forum_grades', $grade);

        return true;
    }
}
