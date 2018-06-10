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
 * @copyright 2014 Andrew Robert Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Deprecated a very long time ago.

/**
 * @deprecated since Moodle 1.1 - please do not use this function any more.
 */
function forum_count_unrated_posts() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}


// Since Moodle 1.5.

/**
 * @deprecated since Moodle 1.5 - please do not use this function any more.
 */
function forum_tp_count_discussion_read_records() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 1.5 - please do not use this function any more.
 */
function forum_get_user_discussions() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}


// Since Moodle 1.6.

/**
 * @deprecated since Moodle 1.6 - please do not use this function any more.
 */
function forum_tp_count_forum_posts() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 1.6 - please do not use this function any more.
 */
function forum_tp_count_forum_read_records() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}


// Since Moodle 1.7.

/**
 * @deprecated since Moodle 1.7 - please do not use this function any more.
 */
function forum_get_open_modes() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}


// Since Moodle 1.9.

/**
 * @deprecated since Moodle 1.9 MDL-13303 - please do not use this function any more.
 */
function forum_get_child_posts() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 1.9 MDL-13303 - please do not use this function any more.
 */
function forum_get_discussion_posts() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}


// Since Moodle 2.0.

/**
 * @deprecated since Moodle 2.0 MDL-21657 - please do not use this function any more.
 */
function forum_get_ratings() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 2.0 MDL-14632 - please do not use this function any more.
 */
function forum_get_tracking_link() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 2.0 MDL-14113 - please do not use this function any more.
 */
function forum_tp_count_discussion_unread_posts() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 2.0 MDL-23479 - please do not use this function any more.
 */
function forum_convert_to_roles() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 2.0 MDL-14113 - please do not use this function any more.
 */
function forum_tp_get_read_records() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 2.0 MDL-14113 - please do not use this function any more.
 */
function forum_tp_get_discussion_read_records() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

// Deprecated in 2.3.

/**
 * @deprecated since Moodle 2.3 MDL-33166 - please do not use this function any more.
 */
function forum_user_enrolled() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}


// Deprecated in 2.4.

/**
 * @deprecated since Moodle 2.4 use forum_user_can_see_post() instead
 */
function forum_user_can_view_post() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}


// Deprecated in 2.6.

/**
 * FORUM_TRACKING_ON - deprecated alias for FORUM_TRACKING_FORCED.
 * @deprecated since 2.6
 */
define('FORUM_TRACKING_ON', 2);

/**
 * @deprecated since Moodle 2.6
 * @see shorten_text()
 */
function forum_shorten_post($message) {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. '
        . 'Please use shorten_text($message, $CFG->forum_shortpost) instead.');
}

// Deprecated in 2.8.

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::is_subscribed() instead
 */
function forum_is_subscribed() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more.');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::subscribe_user() instead
 */
function forum_subscribe() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::subscribe_user() instead');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::unsubscribe_user() instead
 */
function forum_unsubscribe() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::unsubscribe_user() instead');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::fetch_subscribed_users() instead
  */
function forum_subscribed_users() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::fetch_subscribed_users() instead');
}

/**
 * Determine whether the forum is force subscribed.
 *
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::is_forcesubscribed() instead
 */
function forum_is_forcesubscribed($forum) {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::is_forcesubscribed() instead');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::set_subscription_mode() instead
 */
function forum_forcesubscribe($forumid, $value = 1) {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::set_subscription_mode() instead');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::get_subscription_mode() instead
 */
function forum_get_forcesubscribed($forum) {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::set_subscription_mode() instead');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::is_subscribed in combination wtih
 * \mod_forum\subscriptions::fill_subscription_cache_for_course instead.
 */
function forum_get_subscribed_forums() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::is_subscribed(), and '
        . \mod_forum\subscriptions::class . '::fill_subscription_cache_for_course() instead');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::get_unsubscribable_forums() instead
 */
function forum_get_optional_subscribed_forums() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::get_unsubscribable_forums() instead');
}

/**
 * @deprecated since Moodle 2.8 use \mod_forum\subscriptions::get_potential_subscribers() instead
 */
function forum_get_potential_subscribers() {
    throw new coding_exception(__FUNCTION__ . '() can not be used any more. Please use '
        . \mod_forum\subscriptions::class . '::get_potential_subscribers() instead');
}

/**
 * Builds and returns the body of the email notification in plain text.
 *
 * @uses CONTEXT_MODULE
 * @param object $course
 * @param object $cm
 * @param object $forum
 * @param object $discussion
 * @param object $post
 * @param object $userfrom
 * @param object $userto
 * @param boolean $bare
 * @param string $replyaddress The inbound address that a user can reply to the generated e-mail with. [Since 2.8].
 * @return string The email body in plain text format.
 * @deprecated since Moodle 3.0 use \mod_forum\output\forum_post_email instead
 */
function forum_make_mail_text($course, $cm, $forum, $discussion, $post, $userfrom, $userto, $bare = false, $replyaddress = null) {
    global $PAGE;
    $renderable = new \mod_forum\output\forum_post_email(
        $course,
        $cm,
        $forum,
        $discussion,
        $post,
        $userfrom,
        $userto,
        forum_user_can_post($forum, $discussion, $userto, $cm, $course)
        );

    $modcontext = context_module::instance($cm->id);
    $renderable->viewfullnames = has_capability('moodle/site:viewfullnames', $modcontext, $userto->id);

    if ($bare) {
        $renderer = $PAGE->get_renderer('mod_forum', 'emaildigestfull', 'textemail');
    } else {
        $renderer = $PAGE->get_renderer('mod_forum', 'email', 'textemail');
    }

    debugging("forum_make_mail_text() has been deprecated, please use the \mod_forum\output\forum_post_email renderable instead.",
            DEBUG_DEVELOPER);

    return $renderer->render($renderable);
}

/**
 * Builds and returns the body of the email notification in html format.
 *
 * @param object $course
 * @param object $cm
 * @param object $forum
 * @param object $discussion
 * @param object $post
 * @param object $userfrom
 * @param object $userto
 * @param string $replyaddress The inbound address that a user can reply to the generated e-mail with. [Since 2.8].
 * @return string The email text in HTML format
 * @deprecated since Moodle 3.0 use \mod_forum\output\forum_post_email instead
 */
function forum_make_mail_html($course, $cm, $forum, $discussion, $post, $userfrom, $userto, $replyaddress = null) {
    return forum_make_mail_post($course,
        $cm,
        $forum,
        $discussion,
        $post,
        $userfrom,
        $userto,
        forum_user_can_post($forum, $discussion, $userto, $cm, $course)
    );
}

/**
 * Given the data about a posting, builds up the HTML to display it and
 * returns the HTML in a string.  This is designed for sending via HTML email.
 *
 * @param object $course
 * @param object $cm
 * @param object $forum
 * @param object $discussion
 * @param object $post
 * @param object $userfrom
 * @param object $userto
 * @param bool $ownpost
 * @param bool $reply
 * @param bool $link
 * @param bool $rate
 * @param string $footer
 * @return string
 * @deprecated since Moodle 3.0 use \mod_forum\output\forum_post_email instead
 */
function forum_make_mail_post($course, $cm, $forum, $discussion, $post, $userfrom, $userto,
                              $ownpost=false, $reply=false, $link=false, $rate=false, $footer="") {
    global $PAGE;
    $renderable = new \mod_forum\output\forum_post_email(
        $course,
        $cm,
        $forum,
        $discussion,
        $post,
        $userfrom,
        $userto,
        $reply);

    $modcontext = context_module::instance($cm->id);
    $renderable->viewfullnames = has_capability('moodle/site:viewfullnames', $modcontext, $userto->id);

    // Assume that this is being used as a standard forum email.
    $renderer = $PAGE->get_renderer('mod_forum', 'email', 'htmlemail');

    debugging("forum_make_mail_post() has been deprecated, please use the \mod_forum\output\forum_post_email renderable instead.",
            DEBUG_DEVELOPER);

    return $renderer->render($renderable);
}

/**
 * Filters the forum discussions according to groups membership and config.
 *
 * @deprecated since 3.3
 * @todo The final deprecation of this function will take place in Moodle 3.7 - see MDL-57487.
 * @since  Moodle 2.8, 2.7.1, 2.6.4
 * @param  array $discussions Discussions with new posts array
 * @return array Forums with the number of new posts
 */
function forum_filter_user_groups_discussions($discussions) {

    debugging('The function forum_filter_user_groups_discussions() is now deprecated.', DEBUG_DEVELOPER);

    // Group the remaining discussions posts by their forumid.
    $filteredforums = array();

    // Discard not visible groups.
    foreach ($discussions as $discussion) {

        // Course data is already cached.
        $instances = get_fast_modinfo($discussion->course)->get_instances();
        $forum = $instances['forum'][$discussion->forum];

        // Continue if the user should not see this discussion.
        if (!forum_is_user_group_discussion($forum, $discussion->groupid)) {
            continue;
        }

        // Grouping results by forum.
        if (empty($filteredforums[$forum->instance])) {
            $filteredforums[$forum->instance] = new stdClass();
            $filteredforums[$forum->instance]->id = $forum->id;
            $filteredforums[$forum->instance]->count = 0;
        }
        $filteredforums[$forum->instance]->count += $discussion->count;

    }

    return $filteredforums;
}

/**
 * @deprecated since 3.3
 * @todo The final deprecation of this function will take place in Moodle 3.7 - see MDL-57487.
 * @global object
 * @global object
 * @global object
 * @param array $courses
 * @param array $htmlarray
 */
function forum_print_overview($courses,&$htmlarray) {
    global $USER, $CFG, $DB, $SESSION;

    debugging('The function forum_print_overview() is now deprecated.', DEBUG_DEVELOPER);

    if (empty($courses) || !is_array($courses) || count($courses) == 0) {
        return array();
    }

    if (!$forums = get_all_instances_in_courses('forum',$courses)) {
        return;
    }

    // Courses to search for new posts
    $coursessqls = array();
    $params = array();
    foreach ($courses as $course) {

        // If the user has never entered into the course all posts are pending
        if ($course->lastaccess == 0) {
            $coursessqls[] = '(d.course = ?)';
            $params[] = $course->id;

        // Only posts created after the course last access
        } else {
            $coursessqls[] = '(d.course = ? AND p.created > ?)';
            $params[] = $course->id;
            $params[] = $course->lastaccess;
        }
    }
    $params[] = $USER->id;
    $coursessql = implode(' OR ', $coursessqls);

    $sql = "SELECT d.id, d.forum, d.course, d.groupid, COUNT(*) as count "
                .'FROM {forum_discussions} d '
                .'JOIN {forum_posts} p ON p.discussion = d.id '
                ."WHERE ($coursessql) "
                .'AND p.deleted <> 1 '
                .'AND p.userid != ? '
                .'AND (d.timestart <= ? AND (d.timeend = 0 OR d.timeend > ?)) '
                .'GROUP BY d.id, d.forum, d.course, d.groupid '
                .'ORDER BY d.course, d.forum';
    $params[] = time();
    $params[] = time();

    // Avoid warnings.
    if (!$discussions = $DB->get_records_sql($sql, $params)) {
        $discussions = array();
    }

    $forumsnewposts = forum_filter_user_groups_discussions($discussions);

    // also get all forum tracking stuff ONCE.
    $trackingforums = array();
    foreach ($forums as $forum) {
        if (forum_tp_can_track_forums($forum)) {
            $trackingforums[$forum->id] = $forum;
        }
    }

    if (count($trackingforums) > 0) {
        $cutoffdate = isset($CFG->forum_oldpostdays) ? (time() - ($CFG->forum_oldpostdays*24*60*60)) : 0;
        $sql = 'SELECT d.forum,d.course,COUNT(p.id) AS count '.
            ' FROM {forum_posts} p '.
            ' JOIN {forum_discussions} d ON p.discussion = d.id '.
            ' LEFT JOIN {forum_read} r ON r.postid = p.id AND r.userid = ? WHERE p.deleted <> 1 AND (';
        $params = array($USER->id);

        foreach ($trackingforums as $track) {
            $sql .= '(d.forum = ? AND (d.groupid = -1 OR d.groupid = 0 OR d.groupid = ?)) OR ';
            $params[] = $track->id;
            if (isset($SESSION->currentgroup[$track->course])) {
                $groupid =  $SESSION->currentgroup[$track->course];
            } else {
                // get first groupid
                $groupids = groups_get_all_groups($track->course, $USER->id);
                if ($groupids) {
                    reset($groupids);
                    $groupid = key($groupids);
                    $SESSION->currentgroup[$track->course] = $groupid;
                } else {
                    $groupid = 0;
                }
                unset($groupids);
            }
            $params[] = $groupid;
        }
        $sql = substr($sql,0,-3); // take off the last OR
        $sql .= ') AND p.modified >= ? AND r.id is NULL ';
        $sql .= 'AND (d.timestart < ? AND (d.timeend = 0 OR d.timeend > ?)) ';
        $sql .= 'GROUP BY d.forum,d.course';
        $params[] = $cutoffdate;
        $params[] = time();
        $params[] = time();

        if (!$unread = $DB->get_records_sql($sql, $params)) {
            $unread = array();
        }
    } else {
        $unread = array();
    }

    if (empty($unread) and empty($forumsnewposts)) {
        return;
    }

    $strforum = get_string('modulename','forum');

    foreach ($forums as $forum) {
        $str = '';
        $count = 0;
        $thisunread = 0;
        $showunread = false;
        // either we have something from logs, or trackposts, or nothing.
        if (array_key_exists($forum->id, $forumsnewposts) && !empty($forumsnewposts[$forum->id])) {
            $count = $forumsnewposts[$forum->id]->count;
        }
        if (array_key_exists($forum->id,$unread)) {
            $thisunread = $unread[$forum->id]->count;
            $showunread = true;
        }
        if ($count > 0 || $thisunread > 0) {
            $str .= '<div class="overview forum"><div class="name">'.$strforum.': <a title="'.$strforum.'" href="'.$CFG->wwwroot.'/mod/forum/view.php?f='.$forum->id.'">'.
                $forum->name.'</a></div>';
            $str .= '<div class="info"><span class="postsincelogin">';
            $str .= get_string('overviewnumpostssince', 'forum', $count)."</span>";
            if (!empty($showunread)) {
                $str .= '<div class="unreadposts">'.get_string('overviewnumunread', 'forum', $thisunread).'</div>';
            }
            $str .= '</div></div>';
        }
        if (!empty($str)) {
            if (!array_key_exists($forum->course,$htmlarray)) {
                $htmlarray[$forum->course] = array();
            }
            if (!array_key_exists('forum',$htmlarray[$forum->course])) {
                $htmlarray[$forum->course]['forum'] = ''; // initialize, avoid warnings
            }
            $htmlarray[$forum->course]['forum'] .= $str;
        }
    }
}

// Deprecated in 3.6.

/**
 * Returns whether the discussion group is visible by the current user or not.
 *
 * @deprecated Since 3.6
 * @since Moodle 2.8, 2.7.1, 2.6.4
 * @param cm_info $cm The discussion course module
 * @param int $discussiongroupid The discussion groupid
 * @return bool
 */
function forum_is_user_group_discussion(cm_info $cm, $discussiongroupid) {
    $forum = \mod_forum\factory::get_forum_by_cm_info($cm);

    return $forum->discussion_is_visible_to_group($discussiongroupid);
}

/**
 * Get all the posts for a user in a forum suitable for forum_print_post
 *
 * TODO Deprecate.
 *
 * @global object
 * @global object
 * @param int $forumid
 * @param int $userid
 * @return array of counts or false
 */
function forum_count_user_posts($forumid, $userid) {
    $forum = \mod_forum\factory::get_forum_by_id($forumid);
    return $forum->count_user_posts($userid);
}

/**
 * Given a discussion id, return the first post from the discussion
 *
 * // TODO Deprecate
 *
 * @param int $dicsussionid
 * @return array
 */
function forum_get_firstpost_from_discussion($discussionid) {
    $forum = \mod_forum\factory::get_forum_by_discussionid($discussionid);
    return $forum->get_firstpost_from_discussion($discussionid);
}

/**
 * Count the number of discussions in the forum.
 *
 * TODO Deprecate
 *
 * @deprecated Since 3.6.0
 * @return int
 */
function forum_count_discussions($forum, $cm, $course) {
    $forum = \mod_forum\factory::get_forum_by_course_module($cm);
    return $forum->count_discussions();
}

/**
 * Returns creation time of the first user's post in given discussion
 *
 * // TODO
 * @deprecated Since 3.6
 * @global object $DB
 * @param int $did Discussion id
 * @param int $userid User id
 * @return int|bool post creation time stamp or return false
 */
function forum_get_user_posted_time($did, $userid) {
    //debugging('Deprecated');
    global $DB;

    $posttime = $DB->get_field('forum_posts', 'MIN(created)', array('userid'=>$userid, 'discussion'=>$did));
    if (empty($posttime)) {
        return false;
    }
    return $posttime;
}

/**
 * TODO Deprecate
 * @global object
 * @param object $forum
 * @param object $currentgroup
 * @param int $unused
 * @param object $cm
 * @param object $context
 * @return bool
 */
function forum_user_can_post_discussion($forum, $currentgroup=null, $unused=-1, $cm=NULL, $context=NULL) {
    if (is_a($cm, \cm_info::class)) {
        $forum = \mod_forum\factory::get_forum_by_cm_info($cm);
    } else {
        $forum = \mod_forum\factory::get_forum_by_record($forum);
    }

    return $forum->can_create_discussion($currentgroup);
}

/**
 * This function checks whether the user can reply to posts in a forum
 * discussion. Use forum_user_can_post_discussion() to check whether the user
 * can start discussions.
 *
 * TODO Deprecate
 * @param object $forum forum object
 * @param object $discussion
 * @param object $user
 * @param object $cm
 * @param object $course
 * @param object $context
 * @return bool
 */
function forum_user_can_post($forum, $discussion, $user = null, $cm = null, $course = null, $context = null) {
    if (is_a($cm, \cm_info::class)) {
        $forum = \mod_forum\factory::get_forum_by_cm_info($cm, $user);
    } else {
        $forum = \mod_forum\factory::get_forum_by_record($forum, $user);
    }

    return $forum->can_post_to_discussion($discussion);
}

/**
* Check to ensure a user can view a timed discussion.
*
* @deprecated since 3.6
* @param object $discussion
* @param object $user
* @return boolean returns true if they can view post, false otherwise
 * TODO deprecate
*/
function forum_user_can_see_timed_discussion($discussion, $user, $unused = null) {
    $forum = \mod_forum\factory::get_forum_by_discussionid($discussion->id, $user);

    return $forum->can_see_timed_discussion();
}

/**
* Check to ensure a user can view a group discussion.
*
* @param object $discussion
* @param object $cm
* @param object $context
* @return boolean returns true if they can view post, false otherwise
 * TODO deprecate
*/
function forum_user_can_see_group_discussion($discussion, $cm = null, $context = null) {
    $forum = \mod_forum\factory::get_forum_by_discussionid($discussion->id, $user);

    return $forum->can_see_group_discussion($discussion);
}

/**
 * Check whether a user can see the specified discussion.
 *
 * @param object $forum
 * @param object $discussion
 * @param object $context
 * @param object $user
 * @return bool
 * TODO deprecate
 */
function forum_user_can_see_discussion($forum, $discussion, $context, $user=NULL) {
    if (is_numeric($discussion)) {
        debugging('missing full discussion', DEBUG_DEVELOPER);
        if (!$discussion = $DB->get_record('forum_discussions',array('id'=>$discussion))) {
            return false;
        }
    }

    $forum = \mod_forum\factory::get_forum_by_discussionid($discussion->id, $user);

    return $forum->can_see_discussion($discussion);
}

/**
 * Check whether a user can see the specified post.
 *
 * @param   \stdClass $forum The forum to chcek
 * @param   \stdClass $discussion The discussion the post is in
 * @param   \stdClass $post The post in question
 * @param   \stdClass $user The user to test - if not specified, the current user is checked.
 * @param   \stdClass $cm The Course Module that the forum is in (required).
 * @param   bool      $checkdeleted Whether to check the deleted flag on the post.
 * @return  bool
 * TODO deprecate
 */
function forum_user_can_see_post($forum, $discussion, $post, $user = null, $cm = null, $checkdeleted = true) {
    if (null !== $cm && is_a($cm, \cm_info::class)) {
        $forum = \mod_forum\factory::get_forum_by_cm_info($cm, $user);
    } else {
        $forum = \mod_forum\factory::get_forum_by_record($forum, $user);
    }

    return $forum->can_see_post($post, $discussion, $checkdeleted);
}

/**
 * Marks a whole forum as read, for a given user
 *
 * @global object
 * @global object
 * @param object $user
 * @param int $forumid
 * @param int|bool $groupid
 * @return bool
 */
function forum_tp_mark_forum_read($user, $forumid, $groupid=false) {
    return \mod_forum\tracking::mark_forum_read($user, $forumid, $groupid);
}

/**
 * Marks a whole discussion as read, for a given user
 *
 * @global object
 * @global object
 * @param object $user
 * @param int $discussionid
 * @return bool
 * TODO Deprecate
 */
function forum_tp_mark_discussion_read($user, $discussionid) {
    return \mod_forum\tracking::mark_discussion_as_read($user, $discussionid);
}

/**
 * Set the discussion to pinned and trigger the discussion pinned event
 *
 * @param  stdClass $modcontext module context object
 * @param  stdClass $forum      forum object
 * @param  stdClass $discussion discussion object
 * @since Moodle 3.1
 * TODO deprecate
 */
function forum_discussion_pin($modcontext, $forum, $discussion) {
    $instance = \mod_forum\factory::get_forum_by_record($forum);

    $instance->pin_discussion($discussion);
}

/**
 * Set discussion to unpinned and trigger the discussion unpin event
 *
 * @param  stdClass $modcontext module context object
 * @param  stdClass $forum      forum object
 * @param  stdClass $discussion discussion object
 * @since Moodle 3.1
 * TODO deprecate
 */
function forum_discussion_unpin($modcontext, $forum, $discussion) {
    $instance = \mod_forum\factory::get_forum_by_record($forum);

    $instance->unpin_discussion($discussion);
}

/**
 * Checks whether the author's name and picture for a given post should be hidden or not.
 *
 * TODO Deprecate
 * @param object $post The forum post.
 * @param object $forum The forum object.
 * @return bool
 * @throws coding_exception
 */
function forum_is_author_hidden($post, $forum) {
    if (!isset($post->parent)) {
        throw new coding_exception('$post->parent must be set.');
    }
    if (!isset($forum->type)) {
        throw new coding_exception('$forum->type must be set.');
    }

    $instance = \mod_forum\factory::get_forum_by_record($forum);

    return $instance->is_author_hidden($post);
}

/**
 * Determine whether the specified discussion is time-locked.
 *
 * TODO Deprecate
 * @param   stdClass    $forum          The forum that the discussion belongs to
 * @param   stdClass    $discussion     The discussion to test
 * @return  bool
 */
function forum_discussion_is_locked($forum, $discussion) {
    $instance = \mod_forum\factory::get_forum_by_record($forum);

    return $instance->is_discussion_locked($discussion);
}

/**
 * Check if the module has any update that affects the current user since a given time.
 *
 * @param  cm_info $cm course module data
 * @param  int $from the time to check updates from
 * @param  array $filter  if we need to check only specific updates
 * @return stdClass an object with the different type of areas indicating if they were updated or not
 * @since Moodle 3.2
 */
function forum_check_updates_since(cm_info $cm, $from, $filter = array()) {
    $forum = \mod_forum\factory::get_forum_by_cm_info($cm);

    return $forum->fetch_updates_since($from, $filter);
}

/**
 * Check if the user can create attachments in a forum.
 * @param  stdClass $forum   forum object
 * @param  stdClass $context context object
 * @return bool true if the user can create attachments, false otherwise
 * @deprecated Since 3.6
 */
function forum_can_create_attachment($forum, $context) {
    debugging(__FUNCTION__ . " has been deprecated since Moodle 3.6. " .
            "It has been replaced by instance::get_forum_by_record()",
            DEBUG_DEVELOPER
        );
    $forum = \mod_forum\factory::get_forum_by_record($forum);

    return $forum->can_create_attachment();
}
