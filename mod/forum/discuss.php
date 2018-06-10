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
 * Displays a post, and all the posts below it.
 * If no post is given, displays all posts in a discussion
 *
 * @package   mod_forum
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$d      = required_param('d', PARAM_INT);                // Discussion ID
$parent = optional_param('parent', null, PARAM_INT);     // If set, then display this post and all children.
$mode   = optional_param('mode', 0, PARAM_INT);          // If set, changes the layout of the thread
$move   = optional_param('move', 0, PARAM_INT);          // If set, moves this discussion to another forum

$mark   = optional_param('mark', null, PARAM_INT);       // Used for tracking read posts if user initiated.
$postid = optional_param('postid', 0, PARAM_INT);        // Used for tracking read posts if user initiated.

$discussion = $DB->get_record('forum_discussions', array('id' => $d), '*', MUST_EXIST);
$forum = $DB->get_record('forum', array('id' => $discussion->forum), '*', MUST_EXIST);
$instance = \mod_forum\factory::get_forum_by_record($forum);
$cm = $instance->get_cm()->get_course_module_record();
$course = $instance->get_course();

$url = $instance->get_discussion_view_url($discussion);
$pageurl = new \moodle_url($url);
if ($parent !== null) {
    $pageurl->param('parent', $parent);
}
$PAGE->set_url($pageurl);

require_course_login($course, true, $cm);

// move this down fix for MDL-6926
require_once($CFG->dirroot.'/mod/forum/lib.php');

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

$instance->add_rss_headers();

if ($move > 0 and confirm_sesskey()) {
    // Move discussion if requested.
    $target = \mod_forum\factory::get_forum_by_id($move);
    $instance->move_discussion_to_forum($discussion, $target);
}

if ($mode) {
    // User requested a change of mode.
    set_user_preference('forum_displaymode', $mode);
}
$mode = get_user_preferences('forum_displaymode', $CFG->forum_displaymode);

$post = $instance->get_top_post_in_discussion_or_specified($discussion, $parent);

if (!$instance->can_see_post($post, $discussion, false)) {
    // User cannot see this post.
    // Redirect to the forum URL with an error message.
    redirect(
        $instance->get_forum_view_url(),
        get_string('noviewdiscussionspermission', 'forum'),
        \core\output\notification::NOTIFY_ERROR
    );
}

// Trigger discussion viewed event.
$instance->trigger_event_discussion_viewed($discussion);

unset($SESSION->fromdiscussion);

$PAGE->set_title("$course->shortname: ".format_string($discussion->name));
$PAGE->set_heading($course->fullname);
$PAGE->set_button(forum_search_form($course));

$renderer = $PAGE->get_renderer('mod_forum');

$forumnode = $PAGE->navigation->find($cm->id, navigation_node::TYPE_ACTIVITY);
if (empty($forumnode)) {
    $forumnode = $PAGE->navbar;
} else {
    $forumnode->make_active();
}

$node = $forumnode->add(format_string($discussion->name), $url);
$node->display = false;
if ($node && $post->id != $discussion->firstpost) {
    $node->add(format_string($post->subject), $pageurl);
}

// TODO: Find out where $mark is set and update it to use constants.
// TODO: Can we remove this to an AJAX call to mark as read from the discussion list instead?
// Probably not, because this is a byproduct only?
if (null !== $mark) {
    \mod_forum\tracking::mark_post($instance, $postid, $mark);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($forum->name), 2);
echo $OUTPUT->heading(format_string($discussion->name), 3, 'discussionname');

$templatable = new \mod_forum\output\discussion_view($instance, $discussion);
$templatable->set_top_post($post);
$templatable->set_display_mode($mode);

$data = $templatable->export_for_template($renderer);
echo $renderer->render_from_template($instance->get_template_for_discussion(), $data);

echo $OUTPUT->footer();
