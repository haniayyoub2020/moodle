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
 * Renderable for a calendar event.
 *
 * @package    calendar
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_calendar\output;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

/**
 * Renderable for a calendar event.
 *
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class event implements \renderable, \templatable {

    protected $id;
    protected $name;
    protected $description;
    protected $descriptionformat;
    protected $courseid;
    protected $groupid;
    protected $repeatid;
    protected $modulename;
    protected $instance;
    protected $eventtype;
    protected $timestart;
    protected $timeduration;
    protected $timesort;
    protected $visible;
    protected $timemodified;
    protected $subscriptionid;
    protected $actionname;
    protected $actionurl;
    protected $actionnum;
    protected $actionactionable;
    protected $sequence;
    protected $eventrepeats;
    protected $context;

    protected $viewlink;
    public function __construct($eventdata) {
        $properties = [
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'descriptionformat' => 'format',
            'courseid' => 'courseid',
            'groupid' => 'groupid',
            'repeatid' => 'repeatid',
            'modulename' => 'modulename',
            'instance' => 'instance',
            'eventtype' => 'eventtype',
            'timestart' => 'timestart',
            'timeduration' => 'timeduration',
            'timesort' => 'timesort',
            'visible' => 'visible',
            'timemodified' => 'timemodified',
            'subscriptionid' => 'subscriptionid',
            'actionname' => 'actionname',
            'actionurl' => 'actionurl',
            'actionnum' => 'actionnum',
            'actionactionable' => 'actionactionable',
            'sequence' => 'sequence',
            'eventrepeats' => 'eventrepeats',
            'context' => 'context',
        ];

        foreach ($properties as $property => $source) {
            $this->$property = $eventdata->$source;
        }
    }

    /**
     * Set the information link for this event.
     *
     * @param   moodle_url      $url
     * @return  $this
     */
    public function set_link(\moodle_url $url) {
        $this->viewlink = $url;

        return $this;
    }

    /**
     * Get the title of this event.
     *
     * @param   renderer_base   $renderer
     * @return  string
     */
    public function get_title(\renderer_base $renderer) {
        // Get event name.
        $eventname = external_format_string($this->name, $this->context->id, true);

        // Include course's shortname into the event name, if applicable.
        if (!empty($this->courseid) && $this->courseid !== SITEID) {
            $course = get_course($this->courseid);
            $eventnameparams = (object)[
                'name' => $eventname,
                'course' => external_format_string($course->shortname, $this->context->id, true)
            ];
            $eventname = get_string('eventnameandcourse', 'calendar', $eventnameparams);
        }

        return $eventname;
    }

    /**
     * Get the exported configuration for this templatable.
     *
     * @param   renderer_base   $renderer
     * @return  array
     */
    public function export_for_template(\renderer_base $renderer) {
        return [
            'id' => $this->id,
            'name' => $this->get_title($renderer),
            // TODO - add component, filearea, and itemid
            'description' => external_format_text($this->description, $this->descriptionformat, $this->context->id),
            'courseid' => $this->courseid,
            'groupid' => $this->groupid,
            'repeatid' => $this->repeatid,
            //'modulename',
            //'instance',
            'eventtype' => $this->eventtype,
            'timestart' => $this->timestart,
            'timeduration' => $this->timeduration,
            'timesort' => $this->timesort,
            'visible' => $this->visible,
            //'subscriptionid',
            //'actionname',
            //'actionurl',
            //'actionnum',
            //'actionactionable',
            'sequence' => $this->sequence,
            'eventrepeats' => $this->eventrepeats,
            'viewlink' => $this->viewlink->out(false),
            //'editlink' => $this->editlink->out(false),
        ];
    }
}
