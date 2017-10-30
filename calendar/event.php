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
 * @package   calendar
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
$PAGE->set_url('/calendar/event.php');

$eventid = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('course', null, PARAM_INT);
$categoryid = optional_param('category', null, PARAM_INT);
$time = optional_param('time', 0, PARAM_INT);

$target = new moodle_url('/calendar/view.php', [
        'view' => 'month',
    ]);

if (!empty($time)) {
    $target->param('time', $time);
}

if ($courseid != null && $courseid != SITEID) {
    $target->param('courseid', $courseid);
}

if ($categoryid != null) {
    $target->param('categoryid', $categoryid);
}

if ($eventid != null) {
    $target->param('eventid', $eventid);
}

redirect($target);
