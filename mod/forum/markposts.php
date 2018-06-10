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
 * Set tracking option for the forum.
 *
 * @package   mod_forum
 * @copyright 2005 mchurch
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once("lib.php");

$f          = required_param('f', PARAM_INT); // The forum to mark.
$mark       = required_param('mark', PARAM_ALPHA); // Read or unread.
$d          = optional_param('d', 0, PARAM_INT); // Discussion to mark.
$returnpage = optional_param('returnpage', 'index.php', PARAM_FILE);    // Page to return to.

$url = new moodle_url('/mod/forum/markposts.php', array('f'=>$f, 'mark'=>$mark));
if ($d !== 0) {
    $url->param('d', $d);
}
if ($returnpage !== 'index.php') {
    $url->param('returnpage', $returnpage);
}
$PAGE->set_url($url);

$forum = \mod_forum\factory::get_forum_by_id($f);

$user = $USER;

require_login($forum->get_course(), false, $forum->get_cm());
require_sesskey();

if ($returnpage == 'index.php') {
    $returnto = $forum->get_forum_index_url();
} else {
    $returnto = new moodle_url("/mod/forum/$returnpage", ['f' => $forum->get_forum_id()]);
}

if (isguestuser()) {
    // Guests can't track reads.
    $PAGE->set_title($course->shortname);
    $PAGE->set_heading($course->fullname);
    echo $OUTPUT->header();
    echo $OUTPUT->confirm(get_string('noguesttracking', 'forum').'<br /><br />'.get_string('liketologin'), get_login_url(), $returnto);
    echo $OUTPUT->footer();
    exit;
}

if ($mark == 'read') {
    if (!empty($d)) {
        \mod_forum\tracking::mark_discussion_as_read($user, $d);
    } else {
        // Mark all messages read in current group
        $currentgroup = groups_get_activity_group($cm);

        if (empty($currentgroup)) {
            // The get_activity_group function can return 0 (All groups).
            // Normalise to false.
            $currentgroup = false;
        }

        \mod_forum\tracking::mark_forum_as_read($user, $forum->get_forum_id(), $currentgroup);
    }
}

redirect($returnto);
