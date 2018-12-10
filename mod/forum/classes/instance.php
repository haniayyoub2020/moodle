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
 * A forum instance.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_forum;

use html_writer;

/**
 * The base forum instance.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class instance {

    /**
     * @var \stdClass The database record relating to this forum.
     */
    protected $record = null;

    /**
     * @var \cm_info the course module for this user and forum.
     */
    protected $cm = null;

    /**
     * @var \context_module The context module for this forum.
     */
    protected $context = null;

    /**
     * @var \course_modinfo Thee course_modinfo for this user and forum.
     */
    protected $modinfo = null;

    /**
     * @var \stdClass The user viewing the forum.
     */
    protected $user = null;

    /**
     * @var \stdClass[] The list of all groups available in this forum.
     */
    protected $allgroups = null;

    /**
     * @var \stdClass[] The list of groups available to the current user in this forum.
     */
    protected $owngroups = null;

    /**
     * @var \stdClass The course that this forum is in.
     */
    protected $course = null;

    /**
     * @var int The current layout.
     */
    protected $layout = null;

    /**
     * @var array The list of posts in this discussion which have been read.
     */
    protected $readposts = null;

    /**
     * @var int User's digest preference for this forum.
     */
    protected $userdigest = null;

    /**
     * Constructor for a forum.
     *
     * @param   \stdClass   $record The record from the forum table.
     * @param   \stdClass   $user The user viewing the forum.
     */
    public function __construct(\stdClass $forum, \stdClass $user = null) {
        global $USER;

        $this->record = $forum;

        if (null === $user) {
            $user = $USER;
        }
        $this->user = $user;
    }

    /**
     * Most forums are learning forums, but some are intended for announcements.
     * Forums are not considered to be for learning if thy are in the site course, or are not in a section.
     *
     * @return  bool
     */
    public function is_learning_forum() : bool {
        if (SITEID == $this->get_course()->id) {
            return false;
        }

        if (empty($this->get_cm()->sectionnum)) {
            return false;
        }
        return true;
    }

    /**
     * Set the cm_info record for this forum.
     *
     * @param   \cm_info    $cm
     * @return  $this
     */
    public function set_cm_info(\cm_info $cm) : self {
        if ($cm->instance != $this->record->id) {
            throw new \coding_exception('Invalid CM passed');
        }

        if ($cm->modname != 'forum') {
            throw new \coding_exception('Invalid CM passed');
        }

        if ($cm->get_modinfo()->get_user_id() != $this->user->id) {
            throw new \coding_exception('Invalid CM passed');
        }

        $this->cm = $cm;

        return $this;
    }

    /**
     * Get the effective digest preference for the user.
     *
     * @return  int
     */
    public function get_digest_preference() : int {
        global $DB;
        if (null === $this->userdigest) {
            $this->userdigest = $DB->get_field('forum_digests', 'maildigest', [
                'userid' => $this->get_user_id(),
                'forum' => $this->get_forum_id(),
            ]);

            if (!$this->userdigest) {
                // Use the default per-forum value.
                $this->userdigest = -1;
            }
        }
        return $this->userdigest;
    }

    /**
     * Get the coursemodule for this forum.
     *
     * @return  \cm_info
     */
    public function get_cm() {
        if (null === $this->cm) {
            list(, $cm) = get_course_and_cm_from_instance($this->record->id, 'forum', $this->record->course, $this->user->id);
            $this->cm = $cm;
        }

        return $this->cm;
    }

    /**
     * Get the coursemodule for this forum.
     *
     * @return  \course_modinfo
     */
    public function get_course_modinfo() : \course_modinfo {
        if (null === $this->modinfo) {
            $this->modinfo = get_fast_modinfo($this->record->course);
        }

        return $this->modinfo;
    }

    /**
     * Get the context for this forum.
     *
     * @return  \context_module
     */
    public function get_context() : \context_module {
        if (null === $this->context) {
            $this->context = $this->get_cm()->context;
        }

        return $this->context;
    }

    /**
     * Get the context of the course that this forum is in.
     *
     * @return  \context_course
     */
    public function get_course_context() : \context_course {
        return $this->get_context()->get_course_context();
    }

    /**
     * Get the ID of this forum.
     *
     * @return  int
     */
    public function get_forum_id() : int {
        return $this->record->id;
    }

    /**
     * Get the name of this forum.
     *
     * @return  string
     */
    public function get_forum_name() : string {
        return $this->record->name;
    }

    /**
     * Get the course record.
     *
     * @return  \stdClass
     */
    public function get_course() : \stdClass {
        global $DB;

        if (null === $this->course) {
            $this->course = $DB->get_record('course', ['id' => $this->get_course_id()]);
        }

        return $this->course;
    }

    /**
     * Get the course record.
     *
     * @return  \stdClass
     */
    public function get_forum_record() : \stdClass {
        return (object) (array) $this->record;
    }

    /**
     * Get the user record of the user this instance is customised to.
     *
     * @return  \stdClass
     */
    public function get_user_record() : \stdClass {
        return $this->user;
    }

    /**
     * Get the user id of the user this instance is customised to.
     *
     * @return  int
     */
    public function get_user_id() : int {
        return $this->user->id;
    }

    /**
     * Get the ID of course that this forum is in.
     *
     * @return  int
     */
    public function get_course_id() : int {
        return $this->get_course_modinfo()->courseid;
    }

    /**
     * Get the current effective group mode.
     *
     * @return  int
     */
    public function get_activity_groupmode() : int {
        return $this->get_cm()->effectivegroupmode;
    }


    /**
     * Check whether the effective group mode is that of separate groups.
     *
     * @return  bool
     */
    protected function in_separate_groupmode() : bool {
        return $this->get_activity_groupmode() == SEPARATEGROUPS;
    }

    /**
     * Get the list of activity group IDs.
     *
     * @return  array
     */
    protected function get_activity_user_group_ids() : array {
        $modinfo = $this->get_course_modinfo();

        $mygroups = $modinfo->get_groups($this->get_cm()->groupingid);

        // Add all groups posts.
        $mygroups[-1] = -1;

        return $mygroups;
    }

    /**
     * Get the grouping ID of the grouping that this forum is using.
     */
    public function get_grouping_id() : int {
        return $this->get_cm()->groupingid;
    }

    /**
     * Get a list of all groups.
     *
     * @return  \stdClass[]
     */
    public function get_all_groups() : array {
        if (null === $this->allgroups) {
            $this->allgroups = groups_get_all_groups($this->get_course_id(), 0, $this->get_grouping_id());
        }

        return $this->allgroups;
    }

    /**
     * Get a list of groups the user can access.
     *
     * @return  \stdClass[]
     */
    public function get_own_groups() : array {
        if (null === $this->owngroups) {
            $this->owngroups = groups_get_all_groups($this->get_course_id(), $this->user->id, $this->get_grouping_id());
        }

        return $this->owngroups;
    }

    /**
     * Get the currently active group.
     *
     * @return  int
     */
    public function get_current_group() : int {
        return groups_get_activity_group($this->get_cm());
    }


    /**
     * Whether the user can view this forum.
     *
     * @return  bool
     */
    public function can_see_forum() : bool {
        return $this->get_cm()->uservisible;
    }

    /**
     * Whether the user can view this forum.
     *
     * @return  bool
     */
    public function is_visible_to_user() : bool {
        // Which should we use?
        return $this->can_see_forum();
    }

    /**
     * Whether it is possible to subscribe to this forum at all.
     *
     * @return  bool
     */
    public function can_subscribe() : bool {
        if (!isloggedin()) {
            // Need to be logged in to subscribe.
            return false;
        }

        if (is_guest($this->get_context(), $this->user)) {
            // Cannot subscribe as a guest.
            return false;
        }

        if (!$this->can_see_discussions()) {
            // You must be able to see discussions in order to subscribe to them.
            return false;
        }

        if (\mod_forum\subscriptions::is_subscribable($this->record)) {
            return true;
        }

        if (has_capability('mod/forum:managesubscriptions', $this->get_context(), $this->user)) {
            return true;
        }

        return false;
    }

    /**
     * Can track read posts.
     *
     * @return  bool
     */
    public function can_track_reads() : bool {
        return forum_tp_can_track_forums($this->record);
    }

    /**
     * Whether this user can rate posts in this forum.
     *
     * @return  bool
     */
    public function can_rate_posts() : bool {
        return has_capability('mod/forum:rate', $this->get_context(), $this->user);
    }

    /**
     * Whether the user can view all groups.
     *
     * @return  bool
     */
    protected function can_view_all_groups() : bool {
        if (!$this->in_separate_groupmode()) {
            return true;
        }

        if (has_capability('moodle/site:accessallgroups', $this->get_context(), $this->user)) {
            return true;
        }

        return false;
    }

    /**
     * Get the list of possible forum layouts of forum.
     *
     * @return  int[]
     */
    public function get_layout_modes() : array {
        return [
            FORUM_MODE_FLATOLDEST => get_string('modeflatoldestfirst', 'forum'),
            FORUM_MODE_FLATNEWEST => get_string('modeflatnewestfirst', 'forum'),
            FORUM_MODE_THREADED   => get_string('modethreaded', 'forum'),
            FORUM_MODE_NESTED     => get_string('modenested', 'forum'),
        ];
    }

    /**
     * Set the currently activated layout.
     *
     * @param   int     $layout The current layout
     * return   $this
     */
    public function set_current_layout(int $layout) : self {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the currently activated layout.
     *
     * @return  int
     */
    public function get_current_layout() : int {
        if (null !== $this->layout) {
            return $this->layout;
        }

        // Default to nested.
        return FORUM_MODE_NESTED;
    }

    // Functions relating to a forum.

    /**
     * Return grade for given user or all users.
     *
     * TODO
     * @param   int     $userid optional user id, 0 means all users
     * @return  array   array of grades, false if none
     */
    public function get_user_grades($userid = 0) {
        global $CFG;

        require_once($CFG->dirroot.'/rating/lib.php');

        $ratingoptions = new stdClass;
        $ratingoptions->component = 'mod_forum';
        $ratingoptions->ratingarea = 'post';

        // Need these to work backwards to get a context id.
        // Is there a better way to get contextid from a module instance?
        $ratingoptions->modulename = 'forum';
        $ratingoptions->moduleid   = $forum->id;
        $ratingoptions->userid = $userid;
        $ratingoptions->aggregationmethod = $forum->assessed;
        $ratingoptions->scaleid = $forum->scale;
        $ratingoptions->itemtable = 'forum_posts';
        $ratingoptions->itemtableusercolumn = 'userid';

        $rm = new \rating_manager();
        return $rm->get_user_grades($ratingoptions);
    }

    /**
     * Update activity grades.
     *
     * TODO
     *
     * @param int $userid specific user only, 0 means all
     * @param boolean $nullifnone return null if grade does not exist
     * @return void
     */
    function update_grades($userid = 0, $nullifnone = true) {
        global $CFG, $DB;
        require_once($CFG->libdir.'/gradelib.php');

        if (!$forum->assessed) {
            forum_grade_item_update($forum);
        } else if ($grades = forum_get_user_grades($forum, $userid)) {
            forum_grade_item_update($forum, $grades);
        } else if ($userid and $nullifnone) {
            $grade = new stdClass();
            $grade->userid   = $userid;
            $grade->rawgrade = NULL;
            forum_grade_item_update($forum, $grade);

        } else {
            forum_grade_item_update($forum);
        }
    }

    /**
     * Check if the user can create attachments in this forum.
     *
     * @param  stdClass $forum   forum object
     * @param  stdClass $context context object
     * @return bool
     */
    public function can_create_attachment() {
        if (empty($this->record->maxattachments)) {
            // No attachments allowed on this forum.
            return false;
        }

        if ($this->record->maxbytes == 1) {
            // If maxbytes == 1 it means no attachments at all.
            return false;
        }

        return has_capability('mod/forum:createattachment', $this->get_context(), $this->user);
    }

    /**
     * Whether the user can move discussions _out_ of this forum.
     *
     * @param   bool    $require    Require instead of has_cap
     * @return  bool
     */
    public function can_move_discussions($require = false) : bool {
        if ($require) {
            return require_capability('mod/forum:movediscussions', $this->get_context(), $this->user);
        } else {
            return has_capability('mod/forum:movediscussions', $this->get_context(), $this->user);
        }
    }

    /**
     * The list of forums that the user can move the discussion to.
     *
     * @return  array
     */
    public function get_move_discussion_targets(\stdClass $discussion) : array {
        global $DB;

        $targets = [];

        if (!$this->can_move_discussions()) {
            return $targets;
        }

        // Check forum types and eliminate simple discussions.
        $allforums = $DB->get_records('forum', ['course' => $this->get_course_id()]);
        foreach ($this->modinfo->instances['forum'] as $cm) {
            if ($cm->id == $this->get_cm()->id) {
                // Skip the current forum.
                continue;
            }

            $target = \mod_forum\factory::get_forum_by_cm_info_with_record($cm, $allforums[$cm->instance]);
            if (!$target->can_create_discussion($discussion->groupid)) {
                // This user cannot create discussions in this group in the target forum.
                continue;
            }

            $section = $target->get_cm()->sectionnum;
            $sectionname = get_section_name($this->get_course(), $section);
            if (empty($targets[$section])) {
                $targets[$section] = [$sectionname => []];
            }

            $targeturl = new \moodle_url('/mod/forum/discuss.php', [
                'd' => $discussion->id,
                'move' => $target->get_cm()->instance,
                'sesskey' => sesskey(),
            ]);
            $targets[$section][$sectionname][$targeturl->out()] = format_string($target->get_cm()->name);
        }

        return $targets;
    }

    /**
     * Move the discussion to the specified target forum.
     * TODO Fix this + test it.
     *
     * @param   \stdClass   $discussion
     * @param   self        $target
     * @return  bool
     */
    public function move_discussion_to_forum(\stdClass $discussion, self $target) : bool {
        global $DB, $CFG;

        $return = $target->get_discussion_view_url($discussion);

        if (!$target->is_visible_to_user()) {
            // The target forum must be visible to the user.
            \core\notification::add(
                get_string('cannotmovenotvisible', 'mod_forum'),
                \core\output\notification::NOTIFY_ERROR);

            return false;
        }

        if (!$target->can_create_discussion()) {
            // The user must be able to create a dicussion there.
            \core\notification::add(
                get_string('cannotcreatediscussion', 'mod_forum'),
                \core\output\notification::NOTIFY_ERROR);

            return false;
        }

        if (!$this->can_move_discussions()) {
            // The user must be able to move discussions from this forum.
            \core\notification::add(
                get_string('cannotcreatediscussion', 'mod_forum'),
                \core\output\notification::NOTIFY_ERROR);

            return false;
        }

        // TODO Update.
        // This isn't working.
        if (!forum_move_attachments($discussion, $this->get_forum_id(), $target->get_forum_id())) {
            // Note: This is a soft fail.
            \core\notification::add(
                get_string('errormovingattachments', 'mod_forum'),
                \core\output\notification::NOTIFY_ERROR);
        }

        // For each subscribed user in this forum and discussion, copy over per-discussion subscriptions if required.
        $discussiongroup = $discussion->groupid == -1 ? 0 : $discussion->groupid;
        $potentialsubscribers = \mod_forum\subscriptions::fetch_subscribed_users(
            $this->record,
            $discussiongroup,
            $this->get_context(),
            'u.id',
            true
        );

        // Pre-seed the subscribed_discussion caches.
        // Firstly for the forum being moved to.
        \mod_forum\subscriptions::fill_subscription_cache($target->get_forum_id());

        // And also for the discussion being moved.
        \mod_forum\subscriptions::fill_subscription_cache($this->get_forum_id());

        $subscriptionchanges = array();
        $subscriptiontime = time();
        $targetrecord = $target->get_forum_record();
        $targetcm = $target->get_cm();
        foreach ($potentialsubscribers as $subuser) {
            $userid = $subuser->id;
            $targetsubscription = \mod_forum\subscriptions::is_subscribed($userid, $targetrecord, null, $targetcm);
            $discussionsubscribed = \mod_forum\subscriptions::is_subscribed($userid, $targetrecord, $discussion->id);
            $forumsubscribed = \mod_forum\subscriptions::is_subscribed($userid, $this->record);

            if ($forumsubscribed && !$discussionsubscribed && $targetsubscription) {
                // The user has opted out of this discussion and the move would cause them to receive notifications again.
                // Ensure they are unsubscribed from the discussion still.
                $subscriptionchanges[$userid] = \mod_forum\subscriptions::FORUM_DISCUSSION_UNSUBSCRIBED;
            } else if (!$forumsubscribed && $discussionsubscribed && !$targetsubscription) {
                // The user has opted into this discussion and would otherwise not receive the subscription after the move.
                // Ensure they are subscribed to the discussion still.
                $subscriptionchanges[$userid] = $subscriptiontime;
            }
        }

        $DB->set_field('forum_discussions', 'forum', $target->get_forum_id(), ['id' => $discussion->id]);
        $DB->set_field('forum_read', 'forumid', $target->get_forum_id(), ['discussionid' => $discussion->id]);

        // Delete the existing per-discussion subscriptions and replace them with the newly calculated ones.
        $DB->delete_records('forum_discussion_subs', array('discussion' => $discussion->id));

        $newdiscussion = clone $discussion;
        $newdiscussion->forum = $target->get_forum_id();
        foreach ($subscriptionchanges as $userid => $preference) {
            if ($preference != \mod_forum\subscriptions::FORUM_DISCUSSION_UNSUBSCRIBED) {
                // Users must have viewdiscussion to a discussion.
                if (has_capability('mod/forum:viewdiscussion', $target->get_context(), $userid)) {
                    \mod_forum\subscriptions::subscribe_user_to_discussion($userid, $newdiscussion, $target->get_context());
                }
            } else {
                \mod_forum\subscriptions::unsubscribe_user_from_discussion($userid, $newdiscussion, $target->get_context());
            }
        }

        $params = array(
            'context' => $target->get_context(),
            'objectid' => $discussion->id,
            'other' => array(
                'fromforumid' => $this->get_forum_id(),
                'toforumid' => $target->get_forum_id(),
            )
        );
        $event = \mod_forum\event\discussion_moved::create($params);
        $event->add_record_snapshot('forum_discussions', $discussion);
        $event->add_record_snapshot('forum', $this->record);
        $event->add_record_snapshot('forum', $targetrecord);
        $event->trigger();

        // Delete the RSS files for the 2 forums to force regeneration of the feeds
        require_once($CFG->dirroot.'/mod/forum/rsslib.php');
        forum_rss_delete_file($this->record);
        forum_rss_delete_file($targetrecord);

        return true;
    }

    /**
     * Whether the user can split the supplied post.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @param   \stdClass $post The post to be tested
     * @return  bool
     */
    public function can_split_discussion(\stdClass $discussion, \stdClass $post) : bool {
        if (empty($post->parent)) {
            // The first post in a discussion cannot be split out.
            return false;
        }

        return has_capability('mod/forum:splitdiscussions', $this->get_context(), $this->user);
    }

    /**
     * Whether the user can edit this post.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @param   \stdClass $post The post to be edited
     * @return  bool
     */
    public function can_edit_post(\stdClass $discussion, \stdClass $post) : bool {
        global $CFG;

        if (has_capability('mod/forum:editanypost', $this->get_context(), $this->user)) {
            // This user can edit posts regardless of who wrote it or its age.
            return true;
        }

        if ($post->userid != $this->user->id) {
            // This user cannot edit posts belonging to other users.
            return false;
        }

        return $this->is_post_within_maxediting_time($post);
    }

    /**
     * Whether the post is within the maxediting time.
     *
     * @param   \stdClass $post The post to be edited
     * @return  bool
     */
    public function is_post_within_maxediting_time(\stdClass $post) : bool {
        $age = time() - $post->created;
        if ($age < $this->get_maxediting_time()) {
            // The post is within the max editing time.
            return true;
        }

        return false;
    }

    /**
     * Whether the user can delete this post.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @param   \stdClass $post The post to be delete
     * @return  bool
     */
    public function can_delete_post(\stdClass $discussion, \stdClass $post) : bool {
        global $CFG;

        if (has_capability('mod/forum:deleteanypost', $this->get_context(), $this->user)) {
            // This user can delete posts regardless of who wrote it or its age.
            return true;
        }

        if ($post->userid != $this->user->id) {
            // This user cannot delete posts belonging to other users.
            return false;
        }

        if (!has_capability('mod/forum:deleteownpost', $this->get_context(), $this->user)) {
            // This user does not have permission to delete their own posts.
            return false;
        }

        $age = time() - $post->created;
        if ($age < $this->get_maxediting_time()) {
            // The post is within the max editing time.
            return true;
        }

        return false;
    }

    /**
     * Whether the user can export this post.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @param   \stdClass $post The post to be delete
     * @return  bool
     */
    public function can_export_post(\stdClass $discussion, \stdClass $post) : bool {
        global $CFG;

        if (empty($CFG->enableportfolios)) {
            // Portfolios are disabled.
            return false;
        }

        if (has_capability('mod/forum:exportpost', $this->get_context(), $this->user)) {
            // This user can export posts regardless of who wrote it.
            return true;
        }

        if ($post->userid != $this->user->id) {
            // This user cannot export posts belonging to other users.
            return false;
        }

        if (has_capability('mod/forum:exportownpost', $this->get_context(), $this->user)) {
            return true;
        }

        return false;
    }

    /**
     * Return the max editing time in seconds for this forum.
     *
     * @return  int
     */
    public function get_maxediting_time() : int {
        global $CFG;

        return $CFG->maxeditingtime;
    }

    /**
     * Get the URL used to view this forum.
     *
     * @return  \moodle_url
     */
    public function get_forum_view_url() : \moodle_url {
        return new \moodle_url('/mod/forum/view.php', [
                'f' => $this->record->id,
            ]);
    }

    /**
     * Get the URL used to view the index for all forums in this course.
     *
     * @return  \moodle_url
     */
    public function get_forum_index_url() : \moodle_url {
        return new \moodle_url('/mod/forum/', [
                'id' => $this->record->course,
            ]);
    }

    /**
     * Fetch updates since the specified time and with an optional filter applied.
     *
     * @param   int         $from the time to check updates from
     * @param   array       $filter  if we need to check only specific updates
     * @return  stdClass    An object with the different type of areas indicating if they were updated or not
     */
    public function fetch_updates_since(int $from, array $filter = []) : \stdClass {
        if (!has_capability('mod/forum:viewdiscussion', $this->get_context(), $this->user)) {
            return (object) [];
        }

        $updates = course_check_module_updates_since($this->get_cm(), $from, [], $filter);

        // Check if there are new discussions in the forum.
        $updates->discussions = (object) [
            'updated' => false,
        ];

        // TODO CHange to use new API.
        $discussions = forum_get_discussions($this->cm, '', false, -1, -1, true, -1, 0, FORUM_POSTS_ALL_USER_GROUPS, $from);
        if (!empty($discussions)) {
            $updates->discussions->updated = true;
            $updates->discussions->itemids = array_keys($discussions);
        }

        return $updates;
    }

    // Functions relating to a discussion.

    /**
     * Check whether a user can see any discussion in the forum.
     *
     * @return  bool
     */
    public function can_see_discussions() : bool {
        if (!has_capability('mod/forum:viewdiscussion', $this->get_context(), $this->user)) {
            return false;
        }

        return true;
    }

    /**
     * Check whether a user can see the specified discussion.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @return  bool
     */
    public function can_see_discussion(\stdClass $discussion) : bool {
        if (!$this->can_see_discussions()) {
            return false;
        }

        if (!$this->can_see_timed_discussion($discussion)) {
            return false;
        }

        if (!$this->can_see_group_discussion($discussion)) {
            return false;
        }

        return true;
    }

    /**
     * Check whether a user can see the posts in the specified discussion.
     *
     * Note: This is different ot can_see_discussion as some forum types may want to display the post, but not the
     * content, until a user has posted.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @return  bool
     */
    public function can_see_posts_in_discussion(\stdClass $discussion) : bool {
        return $this->can_see_discussion($discussion);
    }

    /**
     * Check whether the user can create a new discussion in the specified group.
     *
     * @param   \stdClass   $currentgroup
     * @return  bool
     */
    public function can_create_discussion($currentgroup = null) : bool {
        if (isguestuser($this->user) or !isloggedin()) {
            return false;
        }

        if (!$this->is_visible_to_user()) {
            // The user cannot see this forum anyway.
            return false;
        }

        if ($currentgroup === null) {
            $currentgroup = groups_get_activity_group($this->get_cm());
        }

        if (!has_capability($this->get_capability_to_create_new_discussion(), $this->get_context(), $this->user)) {
            return false;
        }

        return $this->can_post_to_group($currentgroup);
    }

    /**
     * Check to ensure a user can view a timed discussion.
     * Note: Only the timing is checked, not general availability to this user.
     *
     * @param   \stdClass   $discussion
     * @return  boolean     Whether the user can see the discussion or not.
     */
    public function can_see_timed_discussion(\stdClass $discussion) : bool {
        global $CFG;

        if (empty($CFG->forum_enabletimedposts)) {
            // Timed posts are not enabled.
            return true;
        }

        if (has_capability('mod/forum:viewhiddentimedposts', $this->get_context(), $this->user)) {
            // The user has permission to view hidden posts.
            return true;
        }

        $time = time();
        if (!empty($discussion->timestart) && $discussion->timestart < $time) {
            // The discussion time is before the start time.
            return false;
        }

        if (!empty($discussion->timeend) && $discussion->timeend > $time) {
            // The discussion time is after the end time.
            return false;
        }

        return true;
    }

    /**
     * Check to ensure a user can view a group discussion.
     * Note: Only the group is checked, not general availability to this user.
     *
     * @param   \stdClass   $discussion
     * @return  boolean     Whether the user can see the discussion or not.
     */
    public function can_see_group_discussion(\stdClass $discussion) : bool {
        if ($discussion->groupid <= 0) {
            // This is not a group discussion, or it's a discussion to all groups.
            return true;
        }

        if (!$this->in_separate_groupmode()) {
            // This discussion is not in separate groups mode.
            return true;
        }

        if (has_capability('moodle/site:accessallgroups', $this->get_context(), $this->user)) {
            // This user has access to all groups.
            return true;
        }

        // This is a group discussion for a forum in separate groups mode.
        // Check if the user is a member.
        // This is the most expensive check.
        return groups_is_member($discussion->groupid, $this->user->id);
    }

    /**
     * Whether the discussion is locked.
     *
     * @param   \stdClass   $discussion
     * @return  boolean
     */
    public function is_discussion_locked($discussion) : bool {
        if (empty($this->record->lockdiscussionafter)) {
            return false;
        }

        if (($discussion->timemodified + $this->record->lockdiscussionafter) < time()) {
            return true;
        }

        return false;
    }

    /**
     * Whether this forum has been configured to support throttling.
     * Note: This does not mean that it actually is.
     *
     * @return  bool
     */
    public function is_throttled() : bool {
        if (empty($this->record->blockafter)) {
            return false;
        }

        if (empty($this->record->blockperiod)) {
            return false;
        }

        return true;
    }

    /**
     * Whether the current user tracks this forum.
     *
     * @return  bool
     */
    public function is_tracked() : bool {
        global $CFG;

        if (!isloggedin()) {
            return false;
        }

        if (!forum_tp_can_track_forums($this->get_forum_record(), $this->user)) {
            return false;
        }

        if (!forum_tp_is_tracked($this->get_forum_record(), $this->user)) {
            return false;
        }

        // TODO Make this a user preference.
        return $CFG->forum_usermarksread;
    }

    /**
     * Get the tracking type of this forum.
     *
     * @return  int
     */
    public function get_tracking_type() : int {
        return $this->record->trackingtype;
    }

    /**
     * Check to ensure a user can post in a group.
     * Note: Only the group component is checked, not general availability to this user.
     *
     * @param   int         $groupid
     * @return  boolean     Whether the user can see the discussion or not.
     */
    protected function can_post_to_group(int $groupid) : bool {
        $groupmode = $this->get_cm()->effectivegroupmode;
        if (empty($groupmode) || $groupmode === NOGROUPS) {
            // This discussion is not in a group mode.
            return true;
        }

        if (has_capability('moodle/site:accessallgroups', $this->get_context(), $this->user)) {
            // This user has access to all groups.
            return true;
        }

        // This is a group discussion for a forum in separate groups mode.
        // Check if the user is a member.
        // This is the most expensive check.
        return groups_is_member($groupid, $this->user->id);
    }

    /**
     * Check whether the user can post to this groupid.
     *
     * @return  bool
     */
    public function discussion_is_visible_to_group($groupid) : bool {
        if (!$this->in_separate_groupmode()) {
            // This forum is not in separate groups so all discussions are
            return true;
        }

        if ($groupid == -1) {
            // This discussion is allocated to all groups.
            return true;
        }

        if (isguestuser()) {
            // Separately posted discussions are not visible to guests.
            return false;
        }

        if (has_capability('moodle/site:accessallgroups', $this->get_context(), $this->user)) {
            // This user has accessallgroups.
            return true;
        }

        $cm = $this->get_cm();
        if (in_array($groupid, $cm->get_modinfo()->get_groups($cm->groupingid))) {
            return true;
        }

        return false;
    }

    /**
     * Whether this is user is subscribed to the forum as whole.
     *
     * @return  bool
     */
    public function is_subscribed() : bool {
        return \mod_forum\subscriptions::is_subscribed($this->user->id, $this->record);
    }

    /**
     * Whether this is user is subscribed to the specified discussion.
     *
     * @param   \stdClass   $discussion
     * @return  bool
     */
    public function is_subscribed_to_discussion(\stdClass $discussion) : bool {
        return \mod_forum\subscriptions::is_subscribed($this->user->id, $this->record, $discussion->id);
    }

    /**
     * Whether this is user is subscribed to the specified discussion.
     *
     * @param   \stdClass   $discussion
     * @return  $this
     */
    public function set_subscription_state(\stdClass $discussion, int $targetstate) : self {
        if (empty($targetstate)) {
            \mod_forum\subscriptions::unsubscribe_user_from_discussion($this->user->id, $discussion, $this->get_context());
        } else {
            \mod_forum\subscriptions::subscribe_user_to_discussion($this->user->id, $discussion, $this->get_context());
        }

        return $this;
    }

    /**
     * Get the URL used to view this discussion.
     *
     * @param   \stdClass   $discussion
     * @return  \moodle_url
     */
    public function get_discussion_view_url(\stdClass $discussion) : \moodle_url {
        return new \moodle_url('/mod/forum/discuss.php', [
                'd' => $discussion->id,
            ]);
    }

    /**
     * Get the URL used to create a new discussion.
     *
     * @param   \stdClass   $discussion
     * @return  \moodle_url
     */
    public function get_discussion_create_url() : \moodle_url {
        return new \moodle_url('/mod/forum/post.php', [
                'forum' => $this->get_forum_id(),
            ]);
    }

    /**
     * Get the URL used to split a post out of the current discussion.
     *
     * @param   \stdClass   $post
     * @return  \moodle_url
     */
    public function get_discussion_split_url(\stdClass $post) : \moodle_url {
        $url = $this->get_discussion_create_url();
        $url->param('prune', $post->id);

        return $url;
    }

    /**
     * Get the URL used to reply to a post.
     *
     * @param   \stdClass   $post The post to reply to
     * @return  \moodle_url
     */
    public function get_discussion_reply_url(\stdClass $post) : \moodle_url {
        $url = $this->get_discussion_create_url();
        $url->param('reply', $post->id);

        // Jump to the form.
        $url->set_anchor('mformforum');

        return $url;
    }

    /**
     * Get the URL used to toggle pinning of this discussion.
     *
     * @param   \stdClass   $discussion
     * @return  \moodle_url
     */
    public function get_discussion_pin_url(\stdClass $discussion) : \moodle_url {
        $url = $this->get_discussion_view_url($discussion);

        if ($discussion->pinned == FORUM_DISCUSSION_PINNED) {
            $url->param('pin', FORUM_DISCUSSION_UNPINNED);
        } else {
            $url->param('pin', FORUM_DISCUSSION_PINNED);
        }

        return $url;
    }

    /**
     * Get the URL used to view this post.
     *
     * @param   \stdClass   $discussion
     * @param   int         $postid
     * @return  \moodle_url
     */
    public function get_post_view_url(\stdClass $discussion, $postid) : \moodle_url {
        $url = $this->get_discussion_view_url($discussion);

        if (FORUM_MODE_THREADED == $this->get_current_layout()) {
            $url->param('parent', $postid);
        } else {
            $url->set_anchor("p{$postid}");
        }

        return $url;
    }

    /**
     * Get the URL used to edit this post.
     *
     * @param   \stdClass   $discussion
     * @param   \stdClass   $post
     * @return  \moodle_url
     */
    public function get_post_edit_url(\stdClass $discussion, \stdClass $post) : \moodle_url {
        $url = $this->get_discussion_create_url($discussion);
        $url->param('edit', $post->id);

        return $url;
    }

    /**
     * Get the URL used to delete this post.
     *
     * @param   \stdClass   $discussion
     * @param   \stdClass   $post
     * @return  \moodle_url
     */
    public function get_post_delete_url(\stdClass $discussion, \stdClass $post) : \moodle_url {
        $url = $this->get_discussion_create_url($discussion);
        $url->param('delete', $post->id);

        return $url;
    }

    /**
     * Check whether a user can pin any discussion in the forum.
     *
     * @return  bool
     */
    public function can_pin_discussions() : bool {
        if (!has_capability('mod/forum:pindiscussions', $this->get_context(), $this->user)) {
            return false;
        }

        return true;
    }

    /**
     * Whether the discussion is currently pinned or not.
     *
     * @param   \stdClass   $discussion
     * @return  bool
     */
    public function is_discussion_pinned(\stdClass $discussion) : bool {
        return ($discussion->pinned == FORUM_DISCUSSION_PINNED);
    }

    /**
     * Set the discussion pin for this discussion.
     *
     * @param   \stdClass   $discussion
     * @param   int         $pin
     * @reteurn self
     */
    public function set_discussion_pin(\stdClass $discussion, int $pin) : self {
        if (!$this->can_pin_discussions()) {
            \core\notification::add(
                get_string('permissiondenied:pin', 'mod_forum'),
                \core\output\notification::NOTIFY_ERROR);
            return $this;
        }

        switch ($pin) {
            case FORUM_DISCUSSION_PINNED:
                // Pin the discussion and trigger discussion pinned event.
                $this->pin_discussion($discussion);

                \core\notification::add(
                    get_string('pinchanged:pinned', 'mod_forum'),
                    \core\output\notification::NOTIFY_INFO);
                break;
            case FORUM_DISCUSSION_UNPINNED:
                // Unpin the discussion and trigger discussion unpinned event.
                $this->unpin_discussion($discussion);

                \core\notification::add(
                    get_string('pinchanged:unpinned', 'mod_forum'),
                    \core\output\notification::NOTIFY_INFO);
                break;
            default:
                \core\notification::add(
                    get_string('invalidpintype', 'mod_forum'),
                    \core\output\notification::NOTIFY_ERROR);
                break;
        }

        return $this;
    }

    /**
     * Set discussion to unpinned and trigger the discussion unpin event.
     *
     * @param   stdClass    $discussion discussion object
     * @return  $this
     */
    public function pin_discussion($discussion) : self {
        global $DB;

        $discussion->pinned = FORUM_DISCUSSION_PINNED;
        $DB->update_record('forum_discussions', $discussion);

        $params = [
            'context' => $this->get_context(),
            'objectid' => $discussion->id,
            'other' => [
                'forumid' => $this->get_forum_id(),
            ],
        ];

        $event = \mod_forum\event\discussion_unpinned::create($params);
        $event->add_record_snapshot('forum_discussions', $discussion);
        $event->trigger();

        return $this;
    }

    /**
     * Set discussion to unpinned and trigger the discussion unpin event.
     *
     * @param   stdClass    $discussion discussion object
     * @return  $this
     */
    public function unpin_discussion(\stdClass $discussion) : self {
        global $DB;

        $discussion->pinned = FORUM_DISCUSSION_UNPINNED;
        $DB->update_record('forum_discussions', $discussion);

        $params = [
            'context' => $this->get_context(),
            'objectid' => $discussion->id,
            'other' => [
                'forumid' => $this->get_forum_id(),
            ],
        ];

        $event = \mod_forum\event\discussion_pinned::create($params);
        $event->add_record_snapshot('forum_discussions', $discussion);
        $event->trigger();

        return $this;
    }

    /**
     * Returns an array of counts of replies to each discussion
     *
     * @param string $forumsort
     * @param int $limit
     * @param int $page
     * @param int $perpage
     * @return array
     */
    public function count_discussion_replies(
            int $page,
            int $perpage,
            string $forumsort = null,
            int $updatedsince = 0
    ) {
        global $CFG, $DB;

        $orderby = "ORDER BY $forumsort";
        $groupby = ", " . strtolower($forumsort);
        $groupby = str_replace('desc', '', $groupby);
        $groupby = str_replace('asc', '', $groupby);

        $params = [
            'forumid' => $this->get_forum_id(),
        ];

        if (null === $perpage && null === $page) {
            $sql = "SELECT p.discussion, COUNT(p.id) AS replies, MAX(p.id) AS lastpostid
                    FROM {forum_posts} p
                        JOIN {forum_discussions} d ON p.discussion = d.id
                    WHERE p.parent > 0 AND d.forum = ?
                GROUP BY p.discussion";
            return $DB->get_records_sql($sql, [$this->record->id]);

        } else {
            $sql = "SELECT p.discussion, (COUNT(p.id) - 1) AS replies, MAX(p.id) AS lastpostid
                    FROM {forum_posts} p
                        JOIN {forum_discussions} d ON p.discussion = d.id
                    WHERE d.forum = ?
                GROUP BY p.discussion $groupby $orderby";
            return $DB->get_records_sql($sql, [$this->record->id], $page * $perpage, $perpage);
        }
    }

    /**
     * Get the specified page of discussions in the forum.
     *
     * @param   int     $page The page number (0-indexed)
     * @param   int     $perpage The number of discussion to show per page
     * @param   string  $forumsort The sort to apply to the list
     * @param   int     $updatedsince The earliest discussion time
     * @return  discussion_list
     */
    public function get_discussions(int $page = 0, int $perpage = 0,
            string $forumsort = null, int $updatedsince = 0) : discussion_list {
        global $DB;

        if (!$this->can_see_discussions()) {
            return new discussion_list([], false);
        }

        // Sorting.
        if (null === $forumsort) {
            $forumsort = forum_get_default_sort_order();
        }

        list($sql, $params) = $this->get_discussions_sql($forumsort, $updatedsince);

        if (empty($perpage)) {
            $perpage = 50;
        }

        // Retrieve page + 1 - this will tell us if there are any extra discussions.
        $perpageextra = $perpage + 1;

        $discussions = $DB->get_records_sql($sql, $params, $page * $perpage, $perpageextra);

        if (empty($discussions)) {
            // There were no discussions - return early.
            return new discussion_list([], false);
        }

        if (count($discussions) > $perpage) {
            // If more discussions were returned than are expected on the page, then there is another page available.
            $hasmore = true;

            // Trim off any extra discussion.
            $discussions = array_slice($discussions, 0, $perpage);
        } else {
            $hasmore = false;
        }

        // Fetch details for all users who are either the author, or the most recent poster.
        $userids = array_reduce($discussions, function($carry, $discussion) {
            $carry[$discussion->userid] = true;
            $carry[$discussion->usermodified] = true;

            return $carry;
        }, []);
        $users = \core_user::get_users_for_display_in_context(array_keys($userids), $this->get_context(), $this->get_course());

        // TODO - tp_is_tracked and forum_get_discussions_unread need to move to instance functions.
        $unreads = [];
        if (forum_tp_is_tracked($this->record)) {
            // Feetch detail of unread counts for each discussion in the forum.
            $unreads = forum_get_discussions_unread($this->get_cm());
        }

        // Fetch reply information for rthese discussions.
        $replies = $this->count_discussion_replies($page, $perpage, $forumsort, $updatedsince);
        foreach ($discussions as $discussion) {
            $discussion->url = $this->get_discussion_view_url($discussion);
            $discussion->author = $users[$discussion->userid];
            $discussion->modifier = $users[$discussion->usermodified];
            $discussion->unread = empty($unreads[$discussion->id]) ? 0 : $unreads[$discussion->id];
            $discussion->replies = empty($replies[$discussion->id]) ? 0 : $replies[$discussion->id]->replies;
        }

        return new discussion_list($discussions, $hasmore);
    }

    /**
     * Get the SQL used to fetch discussions in this forum.
     *
     * @param   string  $forumsort The sort to apply to the list
     * @param   int     $updatedsince The earliest discussion time
     * @return  array
     */
    protected function get_discussions_sql(string $forumsort = null, int $updatedsince = null) : array {
        global $DB;

        // We use the start of the minute as a time period.
        // This improves SQL caching.
        $now = floor(time() / 60) * 60;

        $params = [
            'forumid' => $this->get_forum_id(),
        ];

        // Check timed discussions.
        $timelimitsql = '';
        if (!has_capability('mod/forum:viewhiddentimedposts', $this->get_context(), $this->user)) {
            $timelimitsql = "(d.timestart <= :timestart AND (d.timeend = 0 OR d.timeend > :timeend))";
            $timelimitsql = "AND (d.userid = :userid OR {$timelimitsql})";
            $params['timestart'] = $now;
            $params['timeend'] = $now;
            $params['userid'] = $this->user->id;
        }

        $groupfiltersql = '';
        if ($groupmode = $this->get_activity_groupmode()) {
            if ($currentgroup = $this->get_current_group()) {
                $groupfiltersql = "AND (d.groupid = :groupid OR d.groupid = -1)";
                $params['groupid'] = $currentgroup;
            } else if ($groupmode === SEPARATEGROUPS) {
                $owngroupsql = "";
                if ($owngroups = $this->get_own_groups()) {
                    list($ingroupssql, $ingroupsparams) = $DB->get_in_or_equal($owngroups, SQL_PARAMS_NAMED);
                    $owngroupsql = "OR d.groupid {$ingroupssql}";
                    $params = array_merge($params, $ingroupsparams);
                }
                $groupfiltersql = "and (d.groupid = -1 {$owngroupsql})";
            }
        }

        // Filter by a minimum timemodified.
        $updatedsincesql = '';
        if (null !== $updatedsince) {
            $updatedsincesql = 'AND d.timemodified > :updatedsince';
            $params['updatedsince'] = $updatedsince;
        }

        $sql = "
            SELECT d.*, p.subject
              FROM {forum_discussions} d
              JOIN {forum_posts} p ON p.id = d.firstpost
             WHERE
                d.forum = :forumid
                {$timelimitsql}
                {$groupfiltersql}
                {$updatedsincesql}
          ORDER BY {$forumsort}
            ";
        return [$sql, $params];
    }

    public function get_posts_in_discussion(\stdClass $discussion) : array {
        global $DB;
        // TODO Sorting?

        // TODO - Check:
        // - Visibility of posts
        // - Visibility of ratinsg
        // - Tags

        $sql = "
            SELECT p.*
              FROM {forum_posts} p
             WHERE p.discussion = :discussionid";

        $params = [
            'discussionid' => $discussion->id,
        ];

        $allposts = $DB->get_records_sql($sql, $params);

        return $allposts;
    }

    public function get_users_in_posts(array $posts) : array {
        $userids = array_reduce($posts, function($carry, $post) {
            $carry[$post->userid] = true;

            return $carry;
        }, []);


        $users = \core_user::get_users_for_display_in_context(array_keys($userids), $this->get_context(), $this->get_course());

        return $users;
    }

    /**
     * Count the number of discussions available to the current user in the discussion.
     * TODO Look at caching.
     * @return mixed
     */
    function count_discussions() {
        global $CFG, $DB;

        // DB Cache Friendly.
        $now = floor(time() / 60) * 60;

        $params = [
            'forumid' => $this->record->id,
        ];

        $timedsql = '';
        if (!empty($CFG->forum_enabletimedposts)) {
            $timedsql = "AND timestart < :timestart AND (timeend = 0 OR timeend > :timeend)";
            $params['timestart'] = $now;
            $params['timeend'] = $now;
        }

        if ($this->can_view_all_groups()) {
            $groupsql = '';
        } else {
            list($groupinsql, $groupparams) = $DB->get_in_or_equal($mygroups, SQL_PARAMS_NAMED);
            $groupsql = "AND groupid {$groupinsql}";
            $params = array_merge($params, $groupparams);
        }

        return $DB->count_records_select('forum_discussions', "forum = :forumid {$timedsql} {$groupsql}", $params);
    }

    /**
    * Gets the neighbours (previous and next) of a discussion.
    *
    * The calculation is based on the timemodified when time modified or time created is identical
    * It will revert to using the ID to sort consistently. This is better tha skipping a discussion.
    *
    * For blog-style forums, the calculation is based on the original creation time of the
    * blog post.
    *
    * Please note that this does not check whether or not the discussion passed is accessible
    * by the user, it simply uses it as a reference to find the neighbours. On the other hand,
    * the returned neighbours are checked and are accessible to the current user.
    *
    * @param object $cm The CM record.
    * @param object $discussion The discussion record.
    * @param object $forum The forum instance record.
    * @return array That always contains the keys 'prev' and 'next'. When there is a result
    *               they contain the record with minimal information such as 'id' and 'name'.
    *               When the neighbour is not found the value is false.
    */
    function forum_get_discussion_neighbours($cm, $discussion, $forum) {
        global $CFG, $DB, $USER;

        if ($cm->instance != $discussion->forum or $discussion->forum != $forum->id or $forum->id != $cm->instance) {
            throw new coding_exception('Discussion is not part of the same forum.');
        }

        $neighbours = array('prev' => false, 'next' => false);
        $now = floor(time() / 60) * 60;
        $params = array();

        $modcontext = context_module::instance($cm->id);
        $groupmode    = groups_get_activity_groupmode($cm);
        $currentgroup = groups_get_activity_group($cm);

        // Users must fulfill timed posts.
        $timelimit = '';
        if (!empty($CFG->forum_enabletimedposts)) {
            if (!has_capability('mod/forum:viewhiddentimedposts', $modcontext)) {
                $timelimit = ' AND ((d.timestart <= :tltimestart AND (d.timeend = 0 OR d.timeend > :tltimeend))';
                $params['tltimestart'] = $now;
                $params['tltimeend'] = $now;
                if (isloggedin()) {
                    $timelimit .= ' OR d.userid = :tluserid';
                    $params['tluserid'] = $USER->id;
                }
                $timelimit .= ')';
            }
        }

        // Limiting to posts accessible according to groups.
        $groupselect = '';
        if ($groupmode) {
            if ($groupmode == VISIBLEGROUPS || has_capability('moodle/site:accessallgroups', $modcontext)) {
                if ($currentgroup) {
                    $groupselect = 'AND (d.groupid = :groupid OR d.groupid = -1)';
                    $params['groupid'] = $currentgroup;
                }
            } else {
                if ($currentgroup) {
                    $groupselect = 'AND (d.groupid = :groupid OR d.groupid = -1)';
                    $params['groupid'] = $currentgroup;
                } else {
                    $groupselect = 'AND d.groupid = -1';
                }
            }
        }

        $params['forumid'] = $cm->instance;
        $params['discid1'] = $discussion->id;
        $params['discid2'] = $discussion->id;
        $params['discid3'] = $discussion->id;
        $params['discid4'] = $discussion->id;
        $params['disctimecompare1'] = $discussion->timemodified;
        $params['disctimecompare2'] = $discussion->timemodified;
        $params['pinnedstate1'] = (int) $discussion->pinned;
        $params['pinnedstate2'] = (int) $discussion->pinned;
        $params['pinnedstate3'] = (int) $discussion->pinned;
        $params['pinnedstate4'] = (int) $discussion->pinned;

        $sql = "SELECT d.id, d.name, d.timemodified, d.groupid, d.timestart, d.timeend
                FROM {forum_discussions} d
                JOIN {forum_posts} p ON d.firstpost = p.id
                WHERE d.forum = :forumid
                AND d.id <> :discid1
                    $timelimit
                    $groupselect";
        $comparefield = "d.timemodified";
        $comparevalue = ":disctimecompare1";
        $comparevalue2  = ":disctimecompare2";
        if (!empty($CFG->forum_enabletimedposts)) {
            // Here we need to take into account the release time (timestart)
            // if one is set, of the neighbouring posts and compare it to the
            // timestart or timemodified of *this* post depending on if the
            // release date of this post is in the future or not.
            // This stops discussions that appear later because of the
            // timestart value from being buried under discussions that were
            // made afterwards.
            $comparefield = "CASE WHEN d.timemodified < d.timestart
                                    THEN d.timestart ELSE d.timemodified END";
            if ($discussion->timemodified < $discussion->timestart) {
                // Normally we would just use the timemodified for sorting
                // discussion posts. However, when timed discussions are enabled,
                // then posts need to be sorted base on the later of timemodified
                // or the release date of the post (timestart).
                $params['disctimecompare1'] = $discussion->timestart;
                $params['disctimecompare2'] = $discussion->timestart;
            }
        }
        $orderbydesc = forum_get_default_sort_order(true, $comparefield, 'd', false);
        $orderbyasc = forum_get_default_sort_order(false, $comparefield, 'd', false);

        if ($forum->type === 'blog') {
            $subselect = "SELECT pp.created
                    FROM {forum_discussions} dd
                    JOIN {forum_posts} pp ON dd.firstpost = pp.id ";

            $subselectwhere1 = " WHERE dd.id = :discid3";
            $subselectwhere2 = " WHERE dd.id = :discid4";

            $comparefield = "p.created";

            $sub1 = $subselect.$subselectwhere1;
            $comparevalue = "($sub1)";

            $sub2 = $subselect.$subselectwhere2;
            $comparevalue2 = "($sub2)";

            $orderbydesc = "d.pinned, p.created DESC";
            $orderbyasc = "d.pinned, p.created ASC";
        }

        $prevsql = $sql . " AND ( (($comparefield < $comparevalue) AND :pinnedstate1 = d.pinned)
                            OR ($comparefield = $comparevalue2 AND (d.pinned = 0 OR d.pinned = :pinnedstate4) AND d.id < :discid2)
                            OR (d.pinned = 0 AND d.pinned <> :pinnedstate2))
                    ORDER BY CASE WHEN d.pinned = :pinnedstate3 THEN 1 ELSE 0 END DESC, $orderbydesc, d.id DESC";

        $nextsql = $sql . " AND ( (($comparefield > $comparevalue) AND :pinnedstate1 = d.pinned)
                            OR ($comparefield = $comparevalue2 AND (d.pinned = 1 OR d.pinned = :pinnedstate4) AND d.id > :discid2)
                            OR (d.pinned = 1 AND d.pinned <> :pinnedstate2))
                    ORDER BY CASE WHEN d.pinned = :pinnedstate3 THEN 1 ELSE 0 END DESC, $orderbyasc, d.id ASC";

        $neighbours['prev'] = $DB->get_record_sql($prevsql, $params, IGNORE_MULTIPLE);
        $neighbours['next'] = $DB->get_record_sql($nextsql, $params, IGNORE_MULTIPLE);
        return $neighbours;
    }

    // Functions relating to a post.

    /**
     * Check whether a user can see the specified post.
     *
     * @param   \stdClass $post The post in question
     * @param   \stdClass $discussion The discussion the post is in
     * @param   bool      $checkdeleted Whether to check the deleted flag on the post.
     * @return  bool
     */
    public function can_see_post(\stdClass $post, \stdClass $discussion, bool $checkdeleted = true) : bool {
        global $CFG, $DB;

        if ($checkdeleted && !empty($post->deleted)) {
            return false;
        }

        if (!has_capability('mod/forum:viewdiscussion', $this->get_context(), $this->user)) {
            // TODO - How to handle deleted users?
            // The context is deleted when the user is deleted
            // To see this move the context_user outside of this function and run the externallib tests.
            $usercontext = \context_user::instance($post->userid);

            if (!has_all_capabilities(['moodle/user:viewdetails', 'moodle/user:readuserposts'], $usercontext, $this->user)) {
                return false;
            }
        }

        if (!$this->get_cm()->uservisible) {
            return false;
        }

        if (!$this->can_see_timed_discussion($discussion)) {
            return false;
        }

        if (!$this->can_see_group_discussion($discussion)) {
            return false;
        }

        return true;
    }

    /**
     * Check whether the user can post in the specified discussion.
     *
     * @param   \stdClass   $discussion
     * @return  bool
     */
    public function can_post_to_discussion(\stdClass $discussion, $allowselfenrol = false) : bool {
        // Guest and not-logged-in users cannot post.
        if (isguestuser($this->user)) {
            return false;
        }

        if (forum_discussion_is_locked($this->record, $discussion)) {
            // This discussion is locked.
            // Only users with the canoverridediscussionlock capability can post.
            if (!has_capability('mod/forum:canoverridediscussionlock', $this->get_context(), $this->user)) {
                return false;
            }
        }

        if (!is_viewing($this->get_context(), $this->user) && !is_enrolled($this->get_context(), $this->user, '', true)) {
            if (!$allowselfenrol || !enrol_selfenrol_available($this->get_course_id())) {
                // Normal users with temporary guest access can not post, and nor can suspended users.
                // This user also cannot self-enrol in this course.
                return false;
            }
        }

        if (!has_capability($this->get_capability_to_post_to_discussion(), $this->get_context(), $this->user)) {
            return false;
        }

        if ($discussion->groupid <= 0) {
            // This is not a group discussion, or it's a discussion to all groups.
            return true;
        }

        return $this->can_post_to_group($discussion->groupid);
    }

    /**
     * Whether the author's name, picture, and related information should be hidden.
     *
     * @param   \stdClass   $post The post to check
     * @return  bool
     */
    public function is_author_hidden($post) : bool {
        return false;
    }

    /**
     * Whether this user can export a discussino to a portfolio.
     *
     * @return  bool
     */
    public function can_export_to_portfolio() : bool {
        global $CFG;

        if (empty($CFG->enableportfolios)) {
            return false;
        }

        if (!has_capability('mod/forum:exportdiscussion', $this->get_context(), $this->user)) {
            return false;
        }

        return true;
    }

    /**
     * Get the name of hte capability used to post in an existing discussion.
     *
     * @return  string
     */
    protected function get_capability_to_post_to_discussion() : string {
        return 'mod/forum:replypost';
    }

    /**
     * Get the name of the capability used to post in an existing discussion.
     *
     * @return  string
     */
    protected function get_capability_to_create_new_discussion() : string {
        return 'mod/forum:startdiscussion';
    }

    /**
     * Count all posts that this user can see, and the most recently modified post time.
     *
     * @return  \stdClass
     */
    public function count_user_posts() : \stdClass {
        global $CFG, $DB;

        $timedsql = "";
        $params = [
            'forumid' => $this->record->id,
            'userid' => $this->user->id,
        ];

        if (!empty($CFG->forum_enabletimedposts)) {
            if (!has_capability('mod/forum:viewhiddentimedposts', $this->get_context(), $this->user)) {
                $now = time();
                $timedsql = "AND (d.timestart < :timestart AND (d.timeend = 0 OR d.timeend > :timeend))";
                $params['timestart'] = $now;
                $params['timeend'] = $now;
            }
        }

        $sql = "SELECT COUNT(p.id) AS postcount, MAX(p.modified) AS lastpost
                  FROM {forum} f
                  JOIN {forum_discussions} d ON d.forum = f.id
                  JOIN {forum_posts} p       ON p.discussion = d.id
                  JOIN {user} u              ON u.id = p.userid
                 WHERE
                    f.id = :forumid
                   AND
                    p.userid = :userid
            ";

        return $DB->get_record_sql($sql, $params);
    }

    /**
     * Get the first post in the discussion, or the post specified.
     *
     * @param   \stdClass   $discussion
     * @param   int         $focusedpost The post to retrieve
     * @return  \stdClass
     */
    public function get_top_post_in_discussion_or_specified(\stdClass $discussion, int $focusedpost = null) : \stdClass {
        if (null === $focusedpost) {
            $focusedpost = $discussion->firstpost;
        }

        return forum_get_post_full($focusedpost);
    }

    /**
     * Get the name of the template used for displaying the discussion view.
     *
     * @return  string
     */
    public function get_template_for_discussion() : string {
        return 'mod_forum/discussion_view';
    }

    /**
     * Get the name of the template used for displaying the discussion list.
     *
     * @return  string
     */
    public function get_template_for_discussion_list() : string {
        return 'mod_forum/discussion_list';
    }

    /**
     * Trigger the event for a discussion being viewed.
     *
     * @param   \stdClass   $discussion
     * @return  $this
     */
    public function trigger_event_discussion_viewed(\stdClass $discussion) : self {
        $event = \mod_forum\event\discussion_viewed::create([
                'context' => $this->get_context(),
                'objectid' => $discussion->id,
            ]);
        $event->add_record_snapshot('forum_discussions', $discussion);
        $event->add_record_snapshot('forum', $this->record);
        $event->trigger();

        return $this;
    }

    /**
     * Trigger the event for the forum being viewed.
     *
     * @return  $this
     */
    public function trigger_course_module_viewed() : self {
        $cm = $this->get_cm()->get_course_module_record();

        // Completion.
        $completion = new \completion_info($this->get_course());
        $completion->set_module_viewed($cm);

        // Trigger the event.
        $event = \mod_forum\event\course_module_viewed::create([
                'context' => $this->get_context(),
                'objectid' => $this->get_forum_id(),
            ]);
        $event->add_record_snapshot('course_modules', $cm);
        $event->add_record_snapshot('course', $this->get_course());
        $event->add_record_snapshot('forum', $this->record);
        $event->trigger();

        return $this;
    }

    /**
     * Check whether the user has posted in the specified discussion at all.
     *
     * @param   \stdClass   $discussion
     * @return  bool
     */
    public function has_user_posted_in_discussion(\stdClass $discussion) : bool {
        global $DB;

        return $DB->record_exists('forum_posts', [
                'discussion' => $discussion->id,
                'userid' => $this->user->id,
            ]);
    }

    /**
     * Whether the post has been marked as read.
     *
     * @param   \stdClass   $post
     * @return  bool
     */
    public function is_post_read(\stdClass $post) : bool {
        global $DB;

        if (null === $this->readposts) {
            $this->readposts = $DB->get_records('forum_read', [
                    'forumid' => $this->get_forum_id(),
                    'userid' => $this->user->id,
                ], '', 'postid, lastread');
        }

        return ($this->readposts && isset($this->readposts->{$post->id}));
    }

    /**
     * Check whether the user has created any discussion in this forum.
     *
     * @param   int     $groupid
     * @return  bool
     */
    public function has_user_created_discussion(int $groupid = null) : bool {
        global $DB;

        $params = [
            'forum' => $this->get_forum_id(),
            'userid' => $this->get_user_id(),
        ];

        if (null !== $groupid) {
            $params['groupid'] = $groupid;
        }

        return $DB->record_exists('forum_discussions', $params);
    }

    /**
     * Add RSS headers for the forum.
     */
    public function add_rss_headers() {
        global $CFG;

        if (empty($CFG->enablerssfeeds)) {
            return;
        }

        if (empty($CFG->forum_enablerssfeeds)) {
            return;
        }

        if (empty($forum->rsstype)) {
            return;
        }

        if (empty($forum->rssarticles)) {
            return;
        }

        require_once("$CFG->libdir/rsslib.php");

        $course = $this->get_course();

        // TODO Move this to something better.
        // get_string().
        $rsstitle = format_string(
            $course->shortname,
            true,
            ['context' => $this->get_course_context()]
        ) . ': ' . format_string($this->record->name);

        rss_add_http_header($instance->get_context(), 'mod_forum', $this->record, $rsstitle);
    }

    /**
     * Get the string to display when there are no discussions to list.
     *
     * @return  string
     */
    public function get_no_discussions_string() : string {
        return get_string('nodiscussions', 'mod_forum');
    }

    /**
     * Get the string to use for the create discussion buttons.
     *
     * @return  string
     */
    public function get_create_discussion_string() : string {
        return get_string('addanewdiscussion', 'forum');
    }

    /**
     * Trigger the discussion list viewed event.
     */
    public function trigger_discussion_list_viewed() {
        // Mark viewed and trigger the course_module_viewed event.
        $this->trigger_course_module_viewed();
    }

    /**
     * Get any notifications to display on the discussion list page.
     *
     * @return  \core\output\notifications[]
     */
    public function get_discussion_list_notifications() {
        $notifications = [];

        if ($this->is_throttled()) {
            $notification = new \core\output\notification(get_string('thisforumisthrottled', 'mod_forum', (object) [
                'blockafter' => $this->get_forum_record()->blockafter,
                'blockperiod' => format_time($this->get_forum_record()->blockperiod),
            ]));
            $notification->set_show_closebutton();
            $notifications[] = $notification;
        }

        return $notifications;
    }

    /**
     * Get actions for the current post.
     *
     * @param   \stdClass $discussion The discussion the post is in
     * @param   \stdClass $post The post to be tested
     */
    public function get_post_actions(\stdClass $discussion, \stdClass $post) {
        $commands = [];

        // Add a permalink.
        $commands['permalink'] = [
            'url' => $this->get_post_view_url($discussion, $post->id),
            'text' => new \lang_string('permalink', 'forum'),
            'attributes' => [
                [
                    'key' => 'rel',
                    'value' => 'bookmark',
                ],
            ]
        ];

        // Mark as read/unread.
        // TODO Maybe move this to ajax.
        if ($this->is_tracked()) {
            $trackurl = $this->get_post_view_url($discussion, $post->id);
            $trackurl->param('postid', $post->id);
            if ($this->is_post_read($post)) {
                // Link to mark as unread.
                $trackurl->param('mark', 'unread');
                $trackstring = new \lang_string('markunread', 'forum');
            } else {
                // Link to mark as read.
                $trackurl->param('mark', 'read');
                $trackstring = new \lang_string('markread', 'forum');
            }

            $commands['track'] = [
                'url' => $trackurl,
                'text' => $trackstring,
                'attributes' => [
                    [
                        'key' => 'rel',
                        'value' => 'bookmark',
                    ],
                ]
            ];
        }

        // Link to the parent post.
        if ($post->parent) {
            $commands['parent'] = [
                'url' => $this->get_post_view_url($discussion, $post->parent),
                'text' => new \lang_string('parent', 'forum'),
                'attributes' => [
                    [
                        'key' => 'rel',
                        'value' => 'bookmark',
                    ],
                ]
            ];
        }

        if ($this->can_edit_post($discussion, $post)) {
            $commands['edit'] = [
                'url' => $this->get_post_edit_url($discussion, $post),
                'text' => new \lang_string('edit', 'forum'),
            ];
        }


        // Split the post into a new discussion.
        if ($this->can_split_discussion($discussion, $post)) {
            $commands['split'] = [
                'url' => $this->get_discussion_split_url($post),
                'text' => new \lang_string('prune', 'forum'),
            ];
        }

        // Delete
        if ($this->can_delete_post($discussion, $post)) {
            $commands['delete'] = [
                'url' => $this->get_post_delete_url($discussion, $post),
                'text' => new \lang_string('delete', 'forum'),
            ];
        }

        // Reply
        if ($this->can_post_to_discussion($discussion)) {
            $commands['reply'] = [
                'url' => $this->get_discussion_reply_url($post),
                'text' => new \lang_string('reply', 'forum'),
            ];
        }

        // Portfolios.
        if ($this->can_export_post($discussion, $post)) {
            require_once("{$CFG->libdir}/portfoliolib.php");

            $button = new \portfolio_add_button();
            $button->set_callback_options('forum_portfolio_caller', [
                    'postid' => $post->id,
                ], 'mod_forum');

            // TODO
            // $attachemnts used to come from the first field from forum_print_attachments
            if (empty($attachments)) {
                $button->set_formats(PORTFOLIO_FORMAT_PLAINHTML);
            } else {
                $button->set_formats(PORTFOLIO_FORMAT_RICHHTML);
            }

            if ($porfoliohtml = $button->to_html(PORTFOLIO_ADD_TEXT_LINK)) {
                $commands['export'] = [
                    'html' => $button,
                ];
            }
        }

        return $commands;
    }

    /**
     * Fullname function helper.
     *
     * @param   \stdClass       $user
     * @return  string
     */
    public function fullname(\stdClass $user) {
        return fullname($user);
    }

    /**
     * Get the profile URL.
     *
     * @param   \stdClass       $user
     * @return  string
     */
    public function get_profile_url(\stdClass $user) : \moodle_url {
        return new \moodle_url('/user/view.php', [
            'id' => $user->id,
            'course' => $this->get_course_id(),
        ]);
    }

    /**
     * Get the profile image URL.
     *
     * @param   \moodle_page    $page
     * @param   \stdClass       $user
     * @return  string
     */
    public function get_profile_image_url(\moodle_page $page, \stdClass $user) : \moodle_url {
        $userpicture = new \user_picture($user);

        return $userpicture->get_url($page);
    }
}
