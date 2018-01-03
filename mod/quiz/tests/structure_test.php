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
 * Quiz events tests.
 *
 * @package   mod_quiz
 * @category  test
 * @copyright 2013 Adrian Greeve
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/quiz/attemptlib.php');

/**
 * Unit tests for quiz events.
 *
 * @copyright  2013 Adrian Greeve
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_quiz_structure_testcase extends advanced_testcase {

    /**
     * Create a course with an empty quiz.
     * @return array with three elements quiz, cm and course.
     */
    protected function prepare_quiz_data() {

        $this->resetAfterTest(true);

        // Create a course.
        $course = $this->getDataGenerator()->create_course();

        // Make a quiz.
        $quizgenerator = $this->getDataGenerator()->get_plugin_generator('mod_quiz');

        $quiz = $quizgenerator->create_instance(array('course' => $course->id, 'questionsperpage' => 0,
            'grade' => 100.0, 'sumgrades' => 2, 'preferredbehaviour' => 'immediatefeedback'));

        $cm = get_coursemodule_from_instance('quiz', $quiz->id, $course->id);

        return array($quiz, $cm, $course);
    }

    /**
     * Creat a test quiz.
     *
     * $layout looks like this:
     * $layout = array(
     *     'Heading 1'
     *     array('TF1', 1, 'truefalse'),
     *     'Heading 2*'
     *     array('TF2', 2, 'truefalse'),
     * );
     * That is, either a string, which represents a section heading,
     * or an array that represents a question.
     *
     * If the section heading ends with *, that section is shuffled.
     *
     * The elements in the question array are name, page number, and question type.
     *
     * @param array $layout as above.
     * @return quiz the created quiz.
     */
    protected function create_test_quiz($layout) {
        list($quiz, $cm, $course) = $this->prepare_quiz_data();
        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();

        $headings = array();
        $slot = 1;
        $lastpage = 0;
        foreach ($layout as $item) {
            if (is_string($item)) {
                if (isset($headings[$lastpage + 1])) {
                    throw new coding_exception('Sections cannot be empty.');
                }
                $headings[$lastpage + 1] = $item;

            } else {
                list($name, $page, $qtype) = $item;
                if ($page < 1 || !($page == $lastpage + 1 ||
                        (!isset($headings[$lastpage + 1]) && $page == $lastpage))) {
                    throw new coding_exception('Page numbers wrong.');
                }
                $q = $questiongenerator->create_question($qtype, null,
                        array('name' => $name, 'category' => $cat->id));

                quiz_add_quiz_question($q->id, $quiz, $page);
                $lastpage = $page;
            }
        }

        $quizobj = new quiz($quiz, $cm, $course);
        $structure = $quizobj->get_structure();
        if (isset($headings[1])) {
            list($heading, $shuffle) = $this->parse_section_name($headings[1]);
            $sections = $structure->get_sections();
            $firstsection = reset($sections);
            $structure->set_section_heading($firstsection->id, $heading);
            $structure->set_section_shuffle($firstsection->id, $shuffle);
            unset($headings[1]);
        }

        foreach ($headings as $startpage => $heading) {
            list($heading, $shuffle) = $this->parse_section_name($heading);
            $id = $structure->add_section_heading($startpage, $heading);
            $structure->set_section_shuffle($id, $shuffle);
        }

        return $quizobj;
    }

    /**
     * Verify that the given layout matches that expected.
     * @param array $expectedlayout as for $layout in {@link create_test_quiz()}.
     * @param \mod_quiz\local\structure\structure $structure the structure to test.
     */
    protected function assert_quiz_layout($expectedlayout, \mod_quiz\local\structure\structure $structure) {
        $sections = $structure->get_sections();

        $slot = 1;
        foreach ($expectedlayout as $item) {
            if (is_string($item)) {
                list($heading, $shuffle) = $this->parse_section_name($item);
                $section = array_shift($sections);

                if ($slot > 1 && $section->heading == '' && $section->firstslot == 1) {
                    // The array $expectedlayout did not contain default first quiz section, so skip over it.
                    $section = array_shift($sections);
                }

                $this->assertEquals($slot, $section->firstslot);
                $this->assertEquals($heading, $section->heading);
                $this->assertEquals($shuffle, $section->shufflequestions);

            } else {
                list($name, $page, $qtype) = $item;
                $question = $structure->get_question_in_slot($slot);
                $this->assertEquals($name,  $question->name);
                $this->assertEquals($slot,  $question->slot,  'Slot number wrong for question ' . $name);
                $this->assertEquals($qtype, $question->qtype, 'Question type wrong for question ' . $name);
                $this->assertEquals($page,  $question->page,  'Page number wrong for question ' . $name);

                $slot += 1;
            }
        }

        if ($slot - 1 != count($structure->get_slots())) {
            $this->fail('The quiz contains more slots than expected.');
        }

        if (!empty($sections)) {
            $section = array_shift($sections);
            if ($section->heading != '' || $section->firstslot != 1) {
                $this->fail('Unexpected section (' . $section->heading .') found in the quiz.');
            }
        }
    }

    /**
     * Parse the section name, optionally followed by a * to mean shuffle, as
     * used by create_test_quiz as assert_quiz_layout.
     * @param string $heading the heading.
     * @return array with two elements, the heading and the shuffle setting.
     */
    protected function parse_section_name($heading) {
        if (substr($heading, -1) == '*') {
            return array(substr($heading, 0, -1), 1);
        } else {
            return array($heading, 0);
        }
    }

    public function test_get_quiz_slots() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        // Are the correct slots returned?
        $slots = $structure->get_slots();
        $this->assertCount(2, $structure->get_slots());
    }

    public function test_quiz_has_one_section_by_default() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $sections = $structure->get_sections();
        $this->assertCount(1, $sections);

        $section = array_shift($sections);
        $this->assertEquals(1, $section->firstslot);
        $this->assertEquals('', $section->heading);
        $this->assertEquals(0, $section->shufflequestions);
    }

    public function test_get_sections() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1*',
                array('TF1', 1, 'truefalse'),
                'Heading 2*',
                array('TF2', 2, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $sections = $structure->get_sections();
        $this->assertCount(2, $sections);

        $section = array_shift($sections);
        $this->assertEquals(1, $section->firstslot);
        $this->assertEquals('Heading 1', $section->heading);
        $this->assertEquals(1, $section->shufflequestions);

        $section = array_shift($sections);
        $this->assertEquals(2, $section->firstslot);
        $this->assertEquals('Heading 2', $section->heading);
        $this->assertEquals(1, $section->shufflequestions);
    }

    public function test_remove_section_heading() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $sections = $structure->get_sections();
        $section = end($sections);
        $structure->remove_section_heading($section->id);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ), $structure);
    }

    /**
     * @expectedException coding_exception
     */
    public function test_cannot_remove_first_section() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $sections = $structure->get_sections();
        $section = reset($sections);

        $structure->remove_section_heading($section->id);
    }

    public function test_move_slot_to_the_same_place_does_nothing() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_slot_end_of_one_page_to_start_of_next() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(2)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '2');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_last_slot_to_previous_page_emptying_the_last_page() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
            ), $structure);
    }

    public function test_end_of_one_section_to_start_of_next() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                'Heading',
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(2)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '2');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                'Heading',
                array('TF2', 2, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ), $structure);
    }

    public function test_start_of_one_section_to_end_of_previous() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                'Heading',
                array('TF2', 2, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                'Heading',
                array('TF3', 2, 'truefalse'),
            ), $structure);
    }
    public function test_move_slot_on_same_page() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                array('TF3', 1, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(3)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF3', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
        ), $structure);
    }

    public function test_move_slot_up_onto_previous_page() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
                array('TF3', 2, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(3)->slotid;
        $idmoveafter = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF3', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
        ), $structure);
    }

    public function test_move_slot_emptying_a_page_renumbers_pages() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
                array('TF3', 3, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(3)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '3');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF3', 2, 'truefalse'),
                array('TF2', 2, 'truefalse'),
        ), $structure);
    }

    /**
     * @expectedException coding_exception
     */
    public function test_move_slot_too_small_page_number_detected() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
                array('TF3', 3, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(3)->slotid;
        $idmoveafter = $structure->get_question_in_slot(2)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '1');
    }

    /**
     * @expectedException coding_exception
     */
    public function test_move_slot_too_large_page_number_detected() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
                array('TF3', 3, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(1)->slotid;
        $idmoveafter = $structure->get_question_in_slot(2)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '4');
    }

    public function test_move_slot_within_section() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(1)->slotid;
        $idmoveafter = $structure->get_question_in_slot(2)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF2', 1, 'truefalse'),
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_slot_to_new_section() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(3)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '2');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_slot_to_start() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(3)->slotid;
        $structure->move_slot($idtomove, 0, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF3', 1, 'truefalse'),
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_slot_down_to_start_of_second_section() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(2)->slotid;
        $idmoveafter = $structure->get_question_in_slot(2)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '2');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                array('TF3', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_first_slot_down_to_start_of_page_2() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, 0, '2');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
            ), $structure);
    }

    public function test_move_first_slot_to_same_place_on_page_1() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, 0, '1');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_first_slot_to_before_page_1() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, 0, '');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ), $structure);
    }

    public function test_move_slot_up_to_start_of_second_section() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                'Heading 3',
                array('TF3', 3, 'truefalse'),
                array('TF4', 3, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(3)->slotid;
        $idmoveafter = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, '2');

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
                array('TF2', 2, 'truefalse'),
                'Heading 3',
                array('TF4', 3, 'truefalse'),
            ), $structure);
    }

    public function test_move_slot_does_not_violate_heading_unique_key() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                'Heading 3',
                array('TF3', 3, 'truefalse'),
                array('TF4', 3, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $idtomove = $structure->get_question_in_slot(4)->slotid;
        $idmoveafter = $structure->get_question_in_slot(1)->slotid;
        $structure->move_slot($idtomove, $idmoveafter, 1);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF4', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                'Heading 3',
                array('TF3', 3, 'truefalse'),
        ), $structure);
    }

    public function test_quiz_remove_slot() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $structure->remove_slot(2);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
            ), $structure);
    }

    public function test_quiz_removing_a_random_question_deletes_the_question() {
        global $DB;

        $this->resetAfterTest(true);
        $this->setAdminUser();

        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
            ));

        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        quiz_add_random_questions($quizobj->get_quiz(), 1, $cat->id, 1, false);
        $structure = $quizobj->get_structure();
        $randomq = $DB->get_record('question', array('qtype' => 'random'));

        $structure->remove_slot(2);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
            ), $structure);
        $this->assertFalse($DB->record_exists('question', array('id' => $randomq->id)));
    }

    /**
     * @expectedException coding_exception
     */
    public function test_cannot_remove_last_slot_in_a_section() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
                'Heading 2',
                array('TF3', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $structure->remove_slot(3);
    }

    public function test_can_remove_last_question_in_a_quiz() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $structure->remove_slot(1);

        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $q = $questiongenerator->create_question('truefalse', null,
                array('name' => 'TF2', 'category' => $cat->id));

        quiz_add_quiz_question($q->id, $quizobj->get_quiz(), 0);
        $structure = $quizobj->get_structure();

        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF2', 1, 'truefalse'),
        ), $structure);
    }

    public function test_add_question_updates_headings() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
        ));

        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $q = $questiongenerator->create_question('truefalse', null,
                array('name' => 'TF3', 'category' => $cat->id));

        quiz_add_quiz_question($q->id, $quizobj->get_quiz(), 1);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF3', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
        ), $structure);
    }

    public function test_add_question_updates_headings_even_with_one_question_sections() {
        $quizobj = $this->create_test_quiz(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                'Heading 3',
                array('TF3', 3, 'truefalse'),
        ));

        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $q = $questiongenerator->create_question('truefalse', null,
                array('name' => 'TF4', 'category' => $cat->id));

        quiz_add_quiz_question($q->id, $quizobj->get_quiz(), 1);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                'Heading 1',
                array('TF1', 1, 'truefalse'),
                array('TF4', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                'Heading 3',
                array('TF3', 3, 'truefalse'),
        ), $structure);
    }

    public function test_add_question_at_end_does_not_update_headings() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
        ));

        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $q = $questiongenerator->create_question('truefalse', null,
                array('name' => 'TF3', 'category' => $cat->id));

        quiz_add_quiz_question($q->id, $quizobj->get_quiz(), 0);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                'Heading 2',
                array('TF2', 2, 'truefalse'),
                array('TF3', 2, 'truefalse'),
        ), $structure);
    }

    public function test_remove_page_break() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
            ));
        $structure = $quizobj->get_structure();

        $slotid = $structure->get_question_in_slot(2)->slotid;
        $slots = $structure->update_page_break($slotid, \mod_quiz\local\structure\structure::LINK_PAGES);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
            ), $structure);
    }

    public function test_add_page_break() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        $slotid = $structure->get_question_in_slot(2)->slotid;
        $slots = $structure->update_page_break($slotid, \mod_quiz\local\structure\structure::UNLINK_PAGES);

        $structure = $quizobj->get_structure();
        $this->assert_quiz_layout(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 2, 'truefalse'),
        ), $structure);
    }

    public function test_update_question_dependency() {
        $quizobj = $this->create_test_quiz(array(
                array('TF1', 1, 'truefalse'),
                array('TF2', 1, 'truefalse'),
        ));
        $structure = $quizobj->get_structure();

        // Test adding a dependency.
        $slotid = $structure->get_slot_id_for_slot(2);
        $structure->update_question_dependency($slotid, true);

        // Having called update page break, we need to reload $structure.
        $structure = $quizobj->get_structure();
        $this->assertEquals(1, $structure->is_question_dependent_on_previous_slot(2));

        // Test removing a dependency.
        $structure->update_question_dependency($slotid, false);

        // Having called update page break, we need to reload $structure.
        $structure = $quizobj->get_structure();
        $this->assertEquals(0, $structure->is_question_dependent_on_previous_slot(2));
    }

    /**
     * Create a quiz, add five questions to the quiz which are all on one page and return the quiz object.
     *
     * @return \mod_quiz\local\structure\structure
     */
    private function get_quiz_object() {
        global $SITE;
        $this->resetAfterTest(true);

        // Make a quiz.
        $quizgenerator = $this->getDataGenerator()->get_plugin_generator('mod_quiz');

        $quiz = $quizgenerator->create_instance(array(
                'course' => $SITE->id, 'questionsperpage' => 0, 'grade' => 100.0, 'sumgrades' => 2));
        $cm = get_coursemodule_from_instance('quiz', $quiz->id, $SITE->id);

        // Create five questions.
        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();

        $shortanswer = $questiongenerator->create_question('shortanswer', null, array('category' => $cat->id));
        $numerical = $questiongenerator->create_question('numerical', null, array('category' => $cat->id));
        $essay = $questiongenerator->create_question('essay', null, array('category' => $cat->id));
        $truefalse = $questiongenerator->create_question('truefalse', null, array('category' => $cat->id));
        $match = $questiongenerator->create_question('match', null, array('category' => $cat->id));

        // Add them to the quiz.
        quiz_add_quiz_question($shortanswer->id, $quiz);
        quiz_add_quiz_question($numerical->id, $quiz);
        quiz_add_quiz_question($essay->id, $quiz);
        quiz_add_quiz_question($truefalse->id, $quiz);
        quiz_add_quiz_question($match->id, $quiz);

        // Return the quiz object.
        $quizobj = new quiz($quiz, $cm, $SITE);
        return $quizobj->get_structure();
    }

    /**
     * Test the get_slots_by_slot_number() method with no slots specified.
     */
    public function test_get_slots_by_slot_number_unspecified() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        $expected = [];
        $actual = phpunit_util::call_internal_method($quiz, 'get_slots_by_slot_number', [null], \mod_quiz\local\structure\structure::class);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the get_slots_by_slot_number() method.
     */
    public function test_get_slots_by_slotnumber_as_array() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        foreach ($slots as $slot) {
            $expected[$slot->slot] = $slot;
        }
        $actual = phpunit_util::call_internal_method($quiz, 'get_slots_by_slot_number', [$slots], \mod_quiz\local\structure\structure::class);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the get_slots_by_slot_number() method with no slots specified.
     */
    public function test_get_this_slot() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        $slotsbyno = phpunit_util::call_internal_method($quiz, 'get_slots_by_slot_number', [$slots], \mod_quiz\local\structure\structure::class);

        for ($slotno = 1; $slotno < count($slotsbyno) + 1; $slotno++) {
            $thisslot = phpunit_util::call_internal_method($quiz, 'get_this_slot', [$slots, $slotno], \mod_quiz\local\structure\structure::class);
            $this->assertEquals($slotsbyno[$slotno], $thisslot);
        }
    }

    /**
     * Test the get_slots_by_slotid() method when no slot is specified.
     */
    public function test_get_slots_by_slotid_null() {
        $quiz = $this->get_quiz_object();

        $expected = [];
        $actual = phpunit_util::call_internal_method($quiz, 'get_slots_by_slotid', [null], \mod_quiz\local\structure\structure::class);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the get_slots_by_slotid() method when a set of slots is specified
     */
    public function test_get_slots_by_slotid() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        $slotsbyno = phpunit_util::call_internal_method($quiz, 'get_slots_by_slot_number', [$slots], \mod_quiz\local\structure\structure::class);

        $actual = phpunit_util::call_internal_method($quiz, 'get_slots_by_slotid', [$slotsbyno], \mod_quiz\local\structure\structure::class);
        $this->assertEquals($slots, $actual);
    }

    /**
     * Test the repaginate_n_question_per_page() method.
     */
    public function test_repaginate_n_questions_per_page() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        // Expect 2 questions per page.
        $expected = array();
        foreach ($slots as $slot) {
            // Page 1 contains Slots 1 and 2.
            if ($slot->slot >= 1 && $slot->slot <= 2) {
                $slot->page = 1;
            }
            // Page 2 contains slots 3 and 4.
            if ($slot->slot >= 3 && $slot->slot <= 4) {
                $slot->page = 2;
            }
            // Page 3 contains slots 5.
            if ($slot->slot >= 5 && $slot->slot <= 6) {
                $slot->page = 3;
            }
            $expected[$slot->id] = $slot;
        }
        $actual = $quiz->repaginate_n_question_per_page($slots, 2);
        $this->assertEquals($expected, $actual);

        // Expect 3 questions per page.
        $expected = array();
        foreach ($slots as $slot) {
            // Page 1 contains Slots 1, 2 and 3.
            if ($slot->slot >= 1 && $slot->slot <= 3) {
                $slot->page = 1;
            }
            // Page 2 contains slots 4 and 5.
            if ($slot->slot >= 4 && $slot->slot <= 6) {
                $slot->page = 2;
            }
            $expected[$slot->id] = $slot;
        }
        $actual = $quiz->repaginate_n_question_per_page($slots, 3);
        $this->assertEquals($expected, $actual);

        // Expect 5 questions per page.
        $expected = array();
        foreach ($slots as $slot) {
            // Page 1 contains Slots 1, 2, 3, 4 and 5.
            if ($slot->slot > 0 && $slot->slot < 6) {
                $slot->page = 1;
            }
            // Page 2 contains slots 6, 7, 8, 9 and 10.
            if ($slot->slot > 5 && $slot->slot < 11) {
                $slot->page = 2;
            }
            $expected[$slot->id] = $slot;
        }
        $actual = $quiz->repaginate_n_question_per_page($slots, 5);
        $this->assertEquals($expected, $actual);

        // Expect 10 questions per page.
        $expected = array();
        foreach ($slots as $slot) {
            // Page 1 contains Slots 1 to 10.
            if ($slot->slot >= 1 && $slot->slot <= 10) {
                $slot->page = 1;
            }
            // Page 2 contains slots 11 to 20.
            if ($slot->slot >= 11 && $slot->slot <= 20) {
                $slot->page = 2;
            }
            $expected[$slot->id] = $slot;
        }
        $actual = $quiz->repaginate_n_question_per_page($slots, 10);
        $this->assertEquals($expected, $actual);

        // Expect 1 questions per page.
        $expected = array();
        $page = 1;
        foreach ($slots as $slot) {
            $slot->page = $page++;
            $expected[$slot->id] = $slot;
        }
        $actual = $quiz->repaginate_n_question_per_page($slots, 1);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the repaginate_this_slot() method..
     */
    public function test_repaginate_this_slot() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        $slotsbyslotno = phpunit_util::call_internal_method($quiz, 'get_slots_by_slot_number', [$slots], \mod_quiz\local\structure\structure::class);
        $slotnumber = 3;
        $newpagenumber = 2;
        $thisslot = $slotsbyslotno[3];
        $thisslot->page = $newpagenumber;
        $expected = $thisslot;
        $actual = phpunit_util::call_internal_method($quiz, 'repaginate_this_slot', [$slotsbyslotno[3], $newpagenumber], \mod_quiz\local\structure\structure::class);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the repaginate_the_rest() method when linking pages.
     */
    public function test_repaginate_the_rest_link() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        $slotfrom = 1;
        $type = \mod_quiz\local\structure\structure::LINK_PAGES;
        $expected = array();
        foreach ($slots as $slot) {
            if ($slot->slot > $slotfrom) {
                $slot->page = $slot->page - 1;
                $expected[$slot->id] = $slot;
            }
        }
        $actual = $quiz->repaginate_the_rest($slots, $slotfrom, $type, false);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the repaginate_the_rest() method when unlinking pages.
     */
    public function test_repaginate_the_rest_unlink() {
        $quiz = $this->get_quiz_object();
        $slots = $quiz->get_slots();

        $slotfrom = 2;
        $newslots = array();
        foreach ($slots as $s) {
            if ($s->slot === $slotfrom) {
                $s->page = $s->page - 1;
            }
            $newslots[$s->id] = $s;
        }

        $type = \mod_quiz\local\structure\structure::UNLINK_PAGES;
        $expected = array();
        foreach ($slots as $slot) {
            if ($slot->slot > ($slotfrom - 1)) {
                $slot->page = $slot->page - 1;
                $expected[$slot->id] = $slot;
            }
        }
        $actual = $quiz->repaginate_the_rest($newslots, $slotfrom, $type, false);
        $this->assertEquals($expected, $actual);
    }

}
