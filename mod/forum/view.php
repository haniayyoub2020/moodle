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
 * @package   mod_forum
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$id          = optional_param('id', 0, PARAM_INT);       // Course Module ID
$f           = optional_param('f', 0, PARAM_INT);        // Forum ID
$mode        = optional_param('mode', 0, PARAM_INT);     // Display mode (for single forum)
$page        = optional_param('page', 0, PARAM_INT);     // which page to show
$search      = optional_param('search', '', PARAM_CLEAN);// search string

$pageurl = new \moodle_url('/mod/forum/view.php');
if ($id) {
    $pageurl->param('id', $id);
} else {
    $pageurl->param('f', $f);
}

if ($page) {
    $pageurl->param('page', $page);
}

if ($search) {
    $pageurl->param('search', $search);
}

$PAGE->set_url($pageurl);

if ($id) {
    $instance = \mod_forum\factory::get_forum_by_cmid($id);
} else if ($f) {
    $instance = \mod_forum\factory::get_forum_by_id($f);
} else {
    redirect(
        new \moodle_url('/'),
        get_string('missingparameter', 'error'),
        \core\output\notification::NOTIFY_ERROR
    );
}

$course = $instance->get_course();
$forum = $instance->get_forum_record();
$cm = $instance->get_cm()->get_course_module_record();

// Move require_course_login here to use forced language for course.
// Fix for MDL-6926.
require_course_login($course, true, $cm);
$strforums = get_string("modulenameplural", "forum");
$strforum = get_string("modulename", "forum");

if (!$PAGE->button) {
    $PAGE->set_button(forum_search_form($course, $search));
}

$context = $instance->get_context();
$PAGE->set_context($context);

$instance->add_rss_headers();

// Print header.
$PAGE->set_title($forum->name);
$PAGE->add_body_class('forumtype-' . $forum->type);
$PAGE->set_heading($course->fullname);

if (!$instance->can_see_forum()) {
    // The user cannot view this forum.
    // Redirect back to the course.
    redirect(
        $instance->get_course_context()->get_url(),
        get_string('noviewdiscussionspermission', 'forum'),
        \core\output\notification::NOTIFY_ERROR
    );
}

if (!$instance->can_see_discussions()) {
    // The user cannot see discussions in this forum.
    // Redirect back to the forum.
    redirect(
        $instance->get_forum_view_url(),
        get_string('noviewdiscussionspermission', 'forum'),
        \core\output\notification::NOTIFY_ERROR
    );
}

$instance->handle_discussion_list_viewed();

// Some capability checks.
$courselink = new moodle_url('/course/view.php', ['id' => $cm->course]);

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($forum->name), 2);

echo $OUTPUT->box(format_module_intro('forum', $forum, $cm->id), 'generalbox', 'intro');

// Group mode selection.
groups_print_activity_menu($cm, $instance->get_forum_view_url());

// Return here if we post or set subscription etc
$SESSION->fromdiscussion = qualified_me();

$templatable = new \mod_forum\output\discussion_list($instance);
$templatable->set_current_page($page);
$templatable->set_current_url($PAGE->url);

$renderer = $PAGE->get_renderer('mod_forum');
echo $renderer->render_from_template(
    $instance->get_template_for_discussion_list(),
    $templatable->export_for_template($renderer)
);
echo $OUTPUT->footer($course);
