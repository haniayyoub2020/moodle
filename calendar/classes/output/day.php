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
 * Renderable for a calendar day with events.
 *
 * @package    calendar
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_calendar\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Renderable for a calendar day with events.
 *
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class day implements \renderable, \templatable {

    /**
     * @var int The unix timestamp for this day.
     */
    protected $date = null;

    /**
     * @var array The date data.
     */
    protected $daydata = null;

    /**
     * @var bool Whether this day represents the current day.
     */
    protected $istoday = false;

    /**
     * @var \moodle_url The link to the day view of the calendar.
     */
    protected $viewdaylink = null;

    /**
     * @var \moodle_url The link to create an event for this day.
     */
    protected $createeventlink = null;

    /**
     * @var event[] The list of events on this day.
     */
    protected $events = [];

    /**
     * @var array A summary of the different event types on this day.
     */
    protected $eventtypes = [];

    /**
     * @var array A summary of the different event types on this day.
     */
    protected $durationevents = [];

    /**
     * Constructor for the day object.
     *
     * @param   int     $timestamp The unix timestamp describing the day
     */
    public function __construct($timestamp, $dateinfo) {
        $this->date = $timestamp;
        $this->daydata = $dateinfo;
    }

    /**
     * Whether this today falls on today.
     *
     * @param   bool    $value
     * @return  $this
     */
    public function set_istoday($value) {
        $this->istoday = $value;

        return $this;
    }

    /**
     * Whether this day is actually today.
     *
     * @return  bool
     */
    public function get_istoday() {
        return $this->istoday;
    }

    /**
     * Whether this day falls on the configured weekend.
     *
     * @return  bool
     */
    public function get_isweekend() {
        global $CFG;

        $weekend = CALENDAR_DEFAULT_WEEKEND;
        if (isset($CFG->calendar_weekend)) {
            $weekend = intval($CFG->calendar_weekend);
        }

        return ($weekend & (1 << ($this->get_wday() % 7)));
    }

    /**
     * The link to this day in the day view.
     *
     * @param   \moodle_url   $value
     * @return  $this
     */
    public function set_viewdaylink(\moodle_url $value) {
        $this->viewdaylink = $value;

        return $this;
    }

    /**
     * Add details of an event to the current day.
     *
     * @param   event   $value The event to be added
     * @return  $this
     */
    public function add_event(event $value) {
        $this->events[] = $value;

        return $this;
    }

    /**
     * Get the day of the month.
     *
     * @return  int
     */
    public function get_mday() {
        return (int) $this->daydata['mday'];
    }

    /**
     * Get the day of the week.
     *
     * @return  int
     */
    public function get_wday() {
        return (int) $this->daydata['wday'];
    }

    /**
     * Set the list of event types for all events found on this day.
     *
     * @param   array   $durationevents
     * @return  $this
     */
    public function set_event_types($eventtypes) {
        $this->eventtypes = $eventtypes;

        return $this;
    }

    /**
     * Set the list of duration events for this day.
     *
     * Duration events include, start, finish, and duration, as well as the
     * event types.
     * These may be used in templates to add style for events spanning multiple days.
     *
     * @param   array   $durationevents
     * @return  $this
     */
    public function set_duration_events($durationevents) {
        $this->durationevents = $durationevents;

        return $this;
    }

    /**
     * Get the list of events for the current day.
     *
     * @param   renderer_base   $renderer
     * @return  array
     */
    public function get_events(\renderer_base $renderer) {
        $events = [];
        foreach ($this->events as $event) {
            $eventdata = $event->export_for_template($renderer);

            // TODO Is this handled better in an alternative way?
            if ($eventdata['timestart'] < $this->date) {
                $eventdata['underway'] = true;
            } else {
                $eventdata['underway'] = false;
            }
            $events[] = $eventdata;
        }

        return $events;
    }

    /**
     * Fetch the event title.
     *
     * @param   renderer_base   $renderer
     * @return  string
     */
    public function get_title(\renderer_base $renderer) {
        $eventcount = count($this->events);
        switch($eventcount) {
            case 0:
                return '';
            case 1:
                return get_string('oneevent', 'calendar');
            default:
                return get_string('manyevents', 'calendar', $eventcount);
        }
    }

    /**
     * Get the exported configuration for this templatable.
     *
     * @param   renderer_base   $renderer
     * @return  array
     */
    public function export_for_template(\renderer_base $renderer) {
        return [
            'date' => $this->date,
            'daytext' => $this->get_mday(),
            'istoday' => $this->get_istoday(),
            'isweekend' => $this->get_isweekend(),
            'viewdaylink' => $this->viewdaylink->out(false),
            'createeventlink' => $this->createeventlink,
            'viewdaylinktitle' => $this->get_title($renderer),
            'events' => $this->get_events($renderer),
            'hasevents' => !empty($this->events),
            'eventtypes' => array_unique($this->eventtypes),
            'eventcount' => count($this->events),
            'durationevents' => array_unique($this->durationevents),
        ];
    }
}
