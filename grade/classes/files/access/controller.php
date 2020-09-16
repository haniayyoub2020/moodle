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
 * Badges subsystem for Moodle.
 *
 * @package     core_grade
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_grade\files\access;

use core_files\local\access\controller_base;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends controller_base {

    /** @var The file area for the image associated with a grade outcome */
    const FILEAREA_OUTCOME = 'outcome';

    /** @var The file area associated with a scaled grade */
    const FILEAREA_SCALE = 'scale';

    /**
     * Constructor to ensure that required files are correclty loaded.
     *
     * @param   mixed ...$args
     */
    protected function __construct(...$args) {
        global $CFG;

        parent::__construct(...$args);

        require_once($CFG->libdir . '/grade/constants.php');
    }

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            // The itemid is the badge id in both cases.
            self::FILEAREA_OUTCOME => self::ITEMID_PRESENT_IN_USE,
            self::FILEAREA_SCALE => self::ITEMID_PRESENT_IN_USE,
            GRADE_FEEDBACK_FILEAREA => self::ITEMID_PRESENT_IN_USE,
            GRADE_HISTORY_FEEDBACK_FILEAREA => self::ITEMID_PRESENT_IN_USE,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|object $user
     * @return  bool
     */
    public static function can_access_storedfile(stored_file $file, ?object $user): bool {
        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to a shared filearea, and not this specific activity.
            return true;
        }

        $filearea = $file->get_filearea();
        $context = self::get_context_from_stored_file($file);

        if ($filearea == self::FILEAREA_OUTCOME || $filearea == self::FILEAREA_SCALE) {
            // Ensure that the outcome and scale areas are at the correct context.
            // No other checks required.
            return $context->contextlevel == CONTEXT_SYSTEM;
        }

        if ($filearea == GRADE_FEEDBACK_FILEAREA || $filearea == GRADE_HISTORY_FEEDBACK_FILEAREA) {
            if ($context->contextlevel != CONTEXT_MODULE) {
                // Feedback files always belong to an activity.
                return false;
            }

            if ($filearea == GRADE_HISTORY_FEEDBACK_FILEAREA) {
                $grade = $DB->get_record('grade_grades_history', ['id' => $file->get_itemid()]);
            } else {
                $grade = $DB->get_record('grade_grades', ['id' => $file->get_itemid()]);
            }

            if (!$grade) {
                // No accompanying grade found.
                return false;
            }

            $iscurrentuser = $user->id == $grade->userid;
            if (!$iscurrentuser) {
                $coursecontext = $context->get_course_context();
                if (!has_capability('moodle/grade:viewall', $coursecontext, $user)) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Whether login is required to access this item.
     *
     * @return  bool
     */
    public function requires_login(): bool {
        global $CFG;

        switch ($this->filearea) {
            case self::FILEAREA_OUTCOME:
            case self::FILEAREA_SCALE:
                return !empty($CFG->forcelogin);
            default:
                return true;
        }
    }
}
