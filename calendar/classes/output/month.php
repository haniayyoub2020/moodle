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
 * Renderable for a calendar month with days.
 *
 * @package    calendar
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_calendar\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Renderable for a calendar month with days
 *
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class month implements \renderable, \templatable {
    /**
     * @var day[] The list of days in the month
     */
    protected $days = [];

    /**
     * @var stdClass[] Configuration of day names containing fullname, and shortname.
     */
    protected $daynames = [];

    /**
     * @var int The first day in the week in calendar view.
     */
    protected $firstday = 1;

    public function __construct(\core_calendar\type_base $type) {
        $this->set_first_day($type->get_starting_weekday());
        foreach ($type->get_weekdays() as $dayno => $names) {
            $this->add_day_name($dayno, $names['shortname'], $names['fullname']);
        }
    }

    /**
     * Add a day to the calendar month.
     *
     * @param   day     $day The day to be added
     * @return  $this
     */
    public function add_day(day $day) {
        $this->days[] = $day;

        return $this;
    }

    /**
     * Set the name of the specified day.
     *
     * @param   int     $dayno The number of the day to be set
     * @param   string  $shortname The short name to be used when the calendar is displayed
     * @param   string  $fullname The full name of the calendar day
     * @return  $this
     */
    public function add_day_name($dayno, $shortname, $fullname) {
        $this->daynames[$dayno] = (object) [
            'shortname' => $shortname,
            'fullname' => $fullname,
        ];

        return $this;
    }

    /**
     * Configure the first day of the week.
     *
     * @param   int     $firstdayofweek The first day of the week.
     * @return  $this
     */
    public function set_first_day($firstdayofweek) {
        $this->firstday = $firstdayofweek;

        return $this;
    }

    /**
     * Get the list of day names for display, re-ordered from the first day
     * of the week.
     *
     * @return  stdClass[]
     */
    public function get_day_names() {
        $daynames = [];
        $daycount = count($this->daynames);
        for ($i = 0; $i < $daycount; $i++) {
            // Bump the currentdayno and ensure it loops.
            $currentdayno = ($i + $this->firstday + $daycount) % $daycount;
            $daynames[] = $this->daynames[$currentdayno];
        }

        return $daynames;
    }

    /**
     * Get the list of week days, ordered into weeks and padded according
     * to the value of the first day of the week.
     *
     * @param   renderer_base   $renderer
     * @return  array
     */
    protected function get_week_days(\renderer_base $renderer) {
        $weeks = [];
        $week = [
            'days' => [],
        ];

        $daycount = count($this->daynames);

        // Get the first day.
        $firstday = reset($this->days);
        $lastdayno = ($this->firstday + $daycount - 1) % $daycount;

        // This represents the current day being iterated over.
        $currentdayno = $this->firstday;

        // Add padding before the first day.
        $firstdayno = $firstday->get_wday();
        while($currentdayno < $firstdayno) {
            // Add padding.
            $week['days'][] = (object)['ispadding' => true];

            // Bump the currentdayno and ensure it loops.
            $currentdayno = ($currentdayno + 1 + $daycount) % $daycount;
        }

        // Add the days to each week.
        foreach ($this->days as $day) {
            $week['days'][] = $day->export_for_template($renderer);

            if ($currentdayno == $lastdayno) {
                $weeks[] = $week;
                $week = ['days' => []];
            }

            $currentdayno = ($currentdayno + 1 + $daycount) % $daycount;
        }

        if ($currentdayno != $this->firstday) {
            // Add padding after the last day.
            while($currentdayno != $this->firstday) {
                // Add padding.
                $week['days'][] = (object)['ispadding' => true];

                // Bump the currentdayno and ensure it loops.
                $currentdayno = ($currentdayno + 1 + $daycount) % $daycount;
            }

            $weeks[] = $week;
        }

        return $weeks;
    }

    /**
     * Get the exported configuration for this templatable.
     *
     * @param   renderer_base   $renderer
     * @return  array
     */
    public function export_for_template(\renderer_base $renderer) {
        return [
            'daynames' => $this->get_day_names($renderer),
            'weeks' => $this->get_week_days($renderer),
        ];
    }
}
