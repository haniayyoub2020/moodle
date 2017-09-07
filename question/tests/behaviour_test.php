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
 * Behaviour tests.
 *
 * @package core_question
 * @copyright 2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/question/behaviour/behaviourbase.php');
require_once($CFG->dirroot . '/question/engine/questionattempt.php');
require_once($CFG->dirroot . '/question/engine/questionattemptstep.php');

class core_question_behaviour_testcase extends advanced_testcase {

    /**
     * Test the question_behaviour::is_same_comment function with a range of properties.
     *
     * @dataProvider is_same_comment_provider
     * @param   string  $ldcomment
     * @param   int     $oldcommentformat
     * @param   float   $oldmark
     * @param   string  $newcomment
     * @param   int     $newcommentformat
     * @param   float   $newmark
     * @param   float   $maxmark
     * @param   bool    $expected
     */
    public function test_is_same_comment($oldcomment, $oldcommentformat, $oldmark, $newcomment, $newcommentformat, $newmark, $maxmark, $expected) {
        // We are testing an abstract class and mocking properties on a class instance within it.
        // Stub the abstract class, and mock the question_attempt which contains the previous attempt.
        $stub = $this->getMockBuilder('question_behaviour')
            ->disableOriginalConstructor()
            ->getMock();
        $qamock = $this->createMock('question_attempt');
        phpunit_util::set_internal_property('question_behaviour', 'qa', $stub, $qamock);

        // Mock the provided data.
        $qamock->method('get_last_behaviour_var')
            ->will($this->returnValueMap([
                ['comment', null, $oldcomment],
                ['commentformat', null, $oldcommentformat],
            ]));
        $qamock->method('get_fraction')
            ->willReturn($oldmark);

        // Now mock the pending step which contains the new data.
        $pendingstepmock = $this->createMock('question_attempt_step');
        $pendingstepmock->method('get_behaviour_var')
            ->will($this->returnValueMap([
                ['comment', $newcomment],
                ['commentformat', $newcommentformat],
                ['mark', $newmark],
                ['maxmark', $maxmark],
            ]));

        // Execute the is_same_comment with the new data, and check the result.
        $result = phpunit_util::call_internal_method($stub, 'is_same_comment', [$pendingstepmock], 'question_behaviour');
        $this->assertEquals($expected, $result);
    }

    /**
     * Test provider for the is_same_comment tests.
     *
     * @return array
     */
    public function is_same_comment_provider() {
        return [
            'no grade + null comment => No change' => [
                null,
                FORMAT_MOODLE,
                null,
                null,
                FORMAT_MOODLE,
                null,
                100,
                true,
            ],
            'no grade + empty comment =>  No change' => [
                '',
                FORMAT_MOODLE,
                null,
                '',
                FORMAT_MOODLE,
                null,
                100,
                true,
            ],
            'no grade + null to empty comment =>  No change' => [
                null,
                FORMAT_MOODLE,
                null,
                '',
                FORMAT_MOODLE,
                null,
                100,
                true,
            ],
            'no grade + null comment + format change =>  No change' => [
                null,
                FORMAT_MOODLE,
                null,
                null,
                FORMAT_HTML,
                null,
                100,
                true,
            ],
            'no grade + null to empty comment + format change =>  No change' => [
                null,
                FORMAT_MOODLE,
                null,
                '',
                FORMAT_HTML,
                null,
                100,
                true,
            ],
            'no grade + empty comment + format change =>  No change' => [
                '',
                FORMAT_MOODLE,
                null,
                '',
                FORMAT_HTML,
                null,
                100,
                true,
            ],
            'no grade + null comment to value => Change' => [
                '',
                FORMAT_MOODLE,
                null,
                'example',
                FORMAT_MOODLE,
                null,
                100,
                false,
            ],
            'no grade + comment present unchanged + format change => Change' => [
                'example',
                FORMAT_MOODLE,
                null,
                'example',
                FORMAT_HTML,
                null,
                (float) 100,
                false,
            ],
            'empty comment + null grade to grade => Change' => [
                '',
                FORMAT_MOODLE,
                null,
                '',
                FORMAT_MOODLE,
                (float) 50,
                (float) 100,
                false,
            ],
            'empty comment + grade change => Change' => [
                '',
                FORMAT_MOODLE,
                (float) 25,
                '',
                FORMAT_MOODLE,
                (float) 50,
                (float) 100,
                false,
            ],
            'empty comment + same grade + maxmark change => Change' => [
                '',
                FORMAT_MOODLE,
                (float) 25,
                '',
                FORMAT_MOODLE,
                (float) 25,
                (float) 50,
                false,
            ],
        ];
    }
}
