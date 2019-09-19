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
 * Tests for the the Forum gradeitem.
 *
 * @package    mod_forum
 * @copyright Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tests\mod_forum\grades;

use mod_forum\grades\gradeitem;
use mod_forum\local\entities\forum as forum_entity;
use gradingform_controller;
use gradingform_rubric_generator_rubric;

require_once(__DIR__ . '/generator_trait.php');


/**
 * Tests for the the Forum gradeitem.
 *
 * @package    mod_forum
 * @copyright Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gradeitem_test extends \advanced_testcase {
    use \mod_forum_tests_generator_trait;

    /**
     * Test that it is possible to instantiate for a valid gradeitem item name.
     */
    public function test_instantiate_valid_gradeitem(): void {
        $forum = $this->get_forum_instance_mock();

        $gradeitem = new gradeitem($forum, 'forum');
        $this->assertInstanceOf(gradeitem::class, $gradeitem);
    }

    /**
     * Test that it is not possible to instantiate for a invalid gradeitem item name.
     */
    public function test_instantiate_invalid_gradeitem(): void {
        $forum = $this->get_forum_instance_mock();

        $this->expectException(\coding_exception::class);
        new gradeitem($forum, 'somethingelse');
    }

    /**
     * Test fetching of a grade for a user when the grade has not yet been created.
     */
    public function test_get_grade_for_user_grade_not_created(): void {
        $forum = $this->get_forum_instance([
            'grade_forum' => 0,
        ]);
        $course = $forum->get_course_record();

        $gradeitem = new gradeitem($forum, 'forum');

        // Fetch the grade record.
        [$student] = $this->helper_create_users($course, 1);
        [$grader] = $this->helper_create_users($course, 1, 'editingteacher');
        $grade = $gradeitem->get_grade_for_user($student->id, $grader->id);
        $this->assertNull($grade);
    }

    /**
     * Test fetching of a grade for a user when the grade has been created.
     */
    public function test_get_grade_for_user_exists(): void {
        $forum = $this->get_forum_instance([
            'grade_forum' => 0,
        ]);
        $course = $forum->get_course_record();
        [$student] = $this->helper_create_users($course, 1);
        [$grader] = $this->helper_create_users($course, 1, 'editingteacher');

        $gradeitem = new gradeitem($forum, 'forum');

        // Create the grade record.
        $gradeid = $gradeitem->create_empty_grade($student->id, $grader->id);

        // Fetch the grade back.
        $grade = $gradeitem->get_grade_for_user($student->id, $grader->id);

        $this->assertIsObject($grade);
        $this->assertEquals($gradeid, $grade->id);
        $this->assertEquals($student->id, $grade->userid);
        $this->assertEquals($grader->id, $grade->graderid);
    }

    /**
     * Ensure that it is possible to get, and update, a grade for a user when simple direct grading is in use.
     */
    public function test_get_and_store_grade_for_user_with_simple_direct_grade(): void {
        $forum = $this->get_forum_instance([
            'grade_forum' => 0,
        ]);
        $course = $forum->get_course_record();
        [$student] = $this->helper_create_users($course, 1);
        [$grader] = $this->helper_create_users($course, 1, 'editingteacher');

        $gradeitem = new gradeitem($forum, 'forum');

        // Create the grade record.
        $gradeid = $gradeitem->create_empty_grade($student->id, $grader->id);

        // Fetch the grade back.
        $grade = $gradeitem->get_grade_for_user($student->id, $grader->id);

        $this->assertIsObject($grade);
        $this->assertEquals($gradeid, $grade->id);
        $this->assertEquals($student->id, $grade->userid);
        $this->assertEquals($grader->id, $grade->graderid);

        // Store a new value.
        $gradeitem->store_grade_from_formdata($student->id, $grader->id, ['grade' => 97]);
    }

    /**
     * Ensure that it is possibel to get, and update, a grade for a user when a rubric is in use.
     */
    public function test_get_and_store_grade_for_user_with_rubric(): void {
        $this->resetAfterTest();

        $forum = $this->get_forum_instance([
            'grade_forum' => 0,
        ]);
        $course = $forum->get_course_record();
        [$student] = $this->helper_create_users($course, 1);
        [$grader] = $this->helper_create_users($course, 1, 'editingteacher');
        [$editor] = $this->helper_create_users($course, 1, 'editingteacher');

        $generator = \testing_util::get_data_generator();
        $gradinggenerator = $generator->get_plugin_generator('core_grading');
        $controller = $gradinggenerator->create_instance($forum->get_context(), 'mod_forum', 'forum', 'rubric');

        // Note: This must be run as a user because it messes with file uploads and drafts.
        $this->setUser($editor);
        $rubric = $this->generate_rubric_definition();
        $controller->update_definition($rubric->get_definition(), $editor->id);

        // Create the grade record.
        $gradeitem = new gradeitem($forum, 'forum');
        $gradeid = $gradeitem->create_empty_grade($student->id, $grader->id);

        // Fetch the grade back.
        $grade = $gradeitem->get_grade_for_user($student->id, $grader->id);

        $this->assertIsObject($grade);
        $this->assertEquals($gradeid, $grade->id);
        $this->assertEquals($student->id, $grade->userid);
        $this->assertEquals($grader->id, $grade->graderid);
        $this->assertEquals($forum->get_id(), $grade->forum);

        $rubricgenerator = $generator->get_plugin_generator('gradingform_rubric');
        $data = $rubricgenerator->get_submitted_form_data($controller, $grade->id, [
            'Species' => [
                'score' => 4,
                'remark' => 'It was a cat, not a dog',
            ],
            'Traits' => [
                'score' => 8,
                'remark' => 'You successfully identified the traits of a dog',
            ],
        ]);

        // Store a new value.
        $gradeitem->store_grade_from_formdata($student->id, $grader->id, $data);
    }

    /**
     * Get a mocked forum_entity.
     *
     * @param array $mockedfunctions Set of mocked methods with return values
     * @return forum_entity
     */
    protected function get_forum_instance_mock(array $mockedfunctions = []): forum_entity {
        $context = $this->getMockBuilder(\context_module::class)
            ->disableOriginalConstructor()
            ->getMock();
        $forum = $this->getMockBuilder(\mod_forum\local\entities\forum::class)
            ->disableOriginalConstructor()
            ->setMethods(array_merge([
                'get_context',
            ], array_keys($mockedfunctions)))
            ->getMock();
        $forum->method('get_context')->willReturn($context);
        foreach ($mockedfunctions as $functionname => $returnvalue) {
            $forum->method($fuctionname)->willReturn($returnvalue);
        }

        return $forum;
    }

    /**
     * Get a real forum instance
     */
    protected function get_forum_instance(array $config = []): forum_entity {
        $this->resetAfterTest();

        $datagenerator = $this->getDataGenerator();
        $course = $datagenerator->create_course();
        $forum = $datagenerator->create_module('forum', array_merge($config, ['course' => $course->id]));

        $vaultfactory = \mod_forum\local\container::get_vault_factory();
        $vault = $vaultfactory->get_forum_vault();

        return $vault->get_from_id((int) $forum->id);
    }

    /**
     * Generate a definition to use with a rubric.
     *
     * @return gradingform_rubric_generator_rubric
     */
    protected function generate_rubric_definition(): gradingform_rubric_generator_rubric {
        $generator = \testing_util::get_data_generator();
        $rubricgenerator = $generator->get_plugin_generator('gradingform_rubric');

        $rubric = $rubricgenerator->get_rubric('Animal classification', 'Classification of an animal');
        $rubric->add_criteria($rubricgenerator->get_criterion('Species', [
            'Not specified' => 0,
            'Specified but wrong class' => 1,
            'Specified a mammal but wrong animal' => 2,
            'Correct without latin name' => 4,
            'Correct including latin name (incorrect spelling allowed)' => 8,
        ]));
        $rubric->add_criteria($rubricgenerator->get_criterion('Traits', [
            'Not specified' => 0,
            'Specified incorrectly' => 1,
            'Some specified correctly' => 2,
            '80% specified correctly' => 4,
            '100% specified correctly' => 8,
        ]));

        return $rubric;
    }
}
