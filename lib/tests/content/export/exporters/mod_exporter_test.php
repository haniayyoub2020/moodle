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
 * Unit tests for core\content\export\exporters\mod_exporter.
 *
 * @package     core
 * @category    test
 * @copyright   2020 Simey Lameze <simey@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

declare(strict_types=1);

namespace core\content\export\exporters;

use advanced_testcase;
use context_course;
use context_module;
use ZipArchive;
use core\content\export\zipwriter;

/**
 * Unit tests for activity exporter.
 *
 * @coversDefaultClass \core\content\export\exporters\mod_exporter
 */
class mod_exporter_test extends advanced_testcase {

    /**
     * The mod_exporter should not include any exportables.
     */
    public function test_no_exportables(): void {
        $this->resetAfterTest(true);

        $generator = $this->getDataGenerator();

        $course = $generator->create_course();
        $modname = 'page';
        $module = $generator->create_module($modname, ['course' => $course->id]);
        $context = context_module::instance($module->cmid);
        $user = $generator->create_user();
        $generator->enrol_user($user->id, $course->id);
        $this->setUser($user);

        $archive = $this->get_mocked_zipwriter(['add_file_from_string', 'add_file_from_stored_file']);
        $archive->expects($this->never())->method('add_file_from_string');
        $archive->expects($this->never())->method('add_file_from_stored_file');

        $activitycontroller = new mod_exporter($context, "mod_{$modname}", $user, $archive);
        $this->assertEmpty($activitycontroller->get_exportables());
    }

    /**
     * The mod_exporter should still export a module intro when no exportables are passed.
     */
    public function test_no_exportables_exported(): void {
        $this->resetAfterTest(true);

        $generator = $this->getDataGenerator();

        $course = $generator->create_course();
        $coursecontext = context_course::instance($course->id);

        $intro = 'XX Some introduction should go here XX';
        $content = 'YY Some content should go here YY';
        $module = $generator->create_module('page', [
            'course' => $course->id,
            'intro' => $intro,
            'content' => $content,
        ]);
        $modcontext = context_module::instance($module->cmid);

        $user = $generator->create_user();
        $generator->enrol_user($user->id, $course->id);

        // Only the module index should be added.
        $archive = $this->get_mocked_zipwriter(['add_file_from_string']);
        $archive->expects($this->once())
            ->method('add_file_from_string')
            ->with(
                $modcontext,
                'index.html',
                $this->callback(function($html) use ($intro, $content): bool {
                    if (strpos($html, $intro) === false) {
                        return false;
                    }

                    if (strpos($html, $content) !== false) {
                        // The content as not exported.
                        return false;
                    }

                    return true;
                })
            );
        $archive->set_root_context($coursecontext);

        $activitycontroller = new mod_exporter($modcontext, "mod_page", $user, $archive);
        $activitycontroller->export_exportables([]);
    }

    /**
     * The mod_exporter should still export exportables as well as module intro.
     */
    public function test_exportables_exported(): void {
        $this->resetAfterTest(true);

        $generator = $this->getDataGenerator();

        $course = $generator->create_course();
        $coursecontext = context_course::instance($course->id);

        $intro = 'XX Some introduction should go here XX';
        $content = 'YY Some content should go here YY';
        $module = $generator->create_module('page', [
            'course' => $course->id,
            'intro' => $intro,
            'content' => $content,
        ]);
        $modcontext = context_module::instance($module->cmid);

        $user = $generator->create_user();
        $generator->enrol_user($user->id, $course->id);

        // Only the module index should be added.
        $archive = $this->get_mocked_zipwriter(['add_file_from_string']);
        $archive->expects($this->once())
            ->method('add_file_from_string')
            ->with(
                $modcontext,
                'index.html',
                $this->callback(function($html) use ($intro, $content): bool {
                    if (strpos($html, $intro) === false) {
                        return false;
                    }

                    if (strpos($html, $content) === false) {
                        // Content was exported.
                        return false;
                    }

                    return true;
                })
            );
        $archive->set_root_context($coursecontext);

        $pagecontroller = new \mod_page\content\exporter($modcontext, "mod_page", $user, $archive);

        $activitycontroller = new mod_exporter($modcontext, "mod_page", $user, $archive);
        $activitycontroller->export_exportables($pagecontroller->get_exportables());
    }

    /**
     * Get a mocked zipwriter instance, stubbing the supplieid classes.
     *
     * @param   string[] $methods
     * @return  zipwriter
     */
    protected function get_mocked_zipwriter(?array $methods = []): zipwriter {
        return $this->getMockBuilder(zipwriter::class)
            ->setConstructorArgs([$this->getMockBuilder(\ZipStream\ZipStream::class)->getmock()])
            ->setMethods($methods)
            ->getMock();
    }
}
