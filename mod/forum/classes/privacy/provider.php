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
 * Privacy Subsystem implementation for mod_forum.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\privacy;

use \core_privacy\request\approved_contextlist;
use \core_privacy\request\writer;
use \core_privacy\metadata\item_collection;

defined('MOODLE_INTERNAL') || die();

/**
 * Implementation of the privacy subsystem plugin provider for the forum activity module.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    // This plugin has data.
    \core_privacy\metadata\provider,

    // This plugin currently implements the original plugin\provider interface.
    \core_privacy\request\plugin\provider,

    // This plugin has some sitewide user preferences to store.
    \core_privacy\request\preference_provider
{

    use helper;

    /**
     * @inheritdoc
     */
    public static function get_metadata(item_collection $items) : item_collection {
        $items->add_database_table('forum_discussions', [
            'name' => 'privacy:metadata:forum_discussions:name',
            'userid' => 'privacy:metadata:forum_discussions:userid',
            'assessed' => 'privacy:metadata:forum_discussions:assessed',
            'timemodified' => 'privacy:metadata:forum_discussions:timemodified',
            'usermodified' => 'privacy:metadata:forum_discussions:usermodified',
        ], 'privacy:metadata:forum_discussions');

        $items->add_database_table('forum_discussion_subs', [
            'userid' => 'privacy:metadata:forum_discussion_subs:userid',
            'discussionid' => 'privacy:metadata:forum_discussion_subs:discussionid',
            'preference' => 'privacy:metadata:forum_discussion_subs:preference',
        ], 'privacy:metadata:forum_discussion_subs');

        // TODO
        // * forum_posts
        // * forum_digests
        // * forum_queue ??
        // * forum_read
        // * forum_subscriptions
        // * forum_track_prefs

        // Forum posts can be tagged and rated.
        $items->link_subsystem('core_tag', 'privacy:metadata:core_tag');
        $items->link_subsystem('core_rating', 'privacy:metadata:core_rating');

        $items->add_user_preference('maildigest', 'privacy:metadata:preference:maildigest');
        $items->add_user_preference('autosubscribe', 'privacy:metadata:preference:autosubscribe');
        $items->add_user_preference('trackforums', 'privacy:metadata:preference:trackforums');
        $items->add_user_preference('markasreadnotificatio', 'privacy:metadata:preference:markasreadnotificatio');

        return $items;
    }

    /**
     * @inheritdoc
     */
    public static function get_contexts_for_userid(int $userid) : \core_privacy\request\contextlist {
        $ratingsql = \core_rating\privacy\provider::get_sql_join('rat', 'mod_forum', 'post', 'p.id', $userid);
        // Fetch all forum discussions, and forum posts.
        $sql = "SELECT c.id
                  FROM {context} c
            INNER JOIN {course_modules} cm ON cm.id = c.instanceid AND c.contextlevel = :contextlevel
            INNER JOIN {modules} m ON m.id = cm.module AND m.name = :modname
            INNER JOIN {forum} f ON f.id = cm.instance
             LEFT JOIN {forum_discussions} d ON d.forum = f.id
             LEFT JOIN {forum_posts} p ON p.discussion = d.id
             LEFT JOIN {forum_digests} dig ON dig.forum = f.id
             LEFT JOIN {forum_subscriptions} sub ON sub.forum = f.id
             LEFT JOIN {forum_track_prefs} pref ON pref.forumid = f.id
             LEFT JOIN {forum_read} hasread ON hasread.forumid = f.id
             LEFT JOIN {forum_discussion_subs} dsub ON dsub.forum = f.id
             {$ratingsql->join}
                 WHERE (
                    p.userid        = :postuserid OR
                    d.userid        = :discussionuserid OR
                    dig.userid      = :digestuserid OR
                    sub.userid      = :subuserid OR
                    pref.userid     = :prefuserid OR
                    hasread.userid  = :hasreaduserid OR
                    dsub.userid     = :dsubuserid OR
                    {$ratingsql->userwhere}
                )
        ";
        // TODO add:
        // * Check uses of subsystems:
        // ** ratings (done)
        // ** tags?? (tag are on a postid and added by the author)
        // ** files (done)
        // ** comments (not used)
        // ** grades (should be covered by Course)
        // ** plagiarism (based on author of content so no new contexts)

        $params = [
            'modname'           => 'forum',
            'contextlevel'      => CONTEXT_MODULE,
            'postuserid'        => $userid,
            'discussionuserid'  => $userid,
            'digestuserid'      => $userid,
            'subuserid'         => $userid,
            'prefuserid'        => $userid,
            'hasreaduserid'     => $userid,
            'dsubuserid'        => $userid,
        ];
        $params += $ratingsql->params;

        $contextlist = new \core_privacy\request\contextlist();
        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Store all user preferences for the plugin.
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     */
    public static function store_user_preferences(int $userid) {
        $user = \core_user::get_user($userid);

        switch ($user->maildigest) {
            case 1:
                $digestdescription = get_string('emaildigestcomplete');
                break;
            case 2:
                $digestdescription = get_string('emaildigestsubjects');
                break;
            case 0:
            default:
                $digestdescription = get_string('emaildigestoff');
                break;
        }
        writer::store_user_preference('mod_forum', 'maildigest', $user->maildigest, $digestdescription);

        switch ($user->autosubscribe) {
            case 0:
                $subscribedescription = get_string('autosubscribeno');
                break;
            case 1:
            default:
                $subscribedescription = get_string('autosubscribeyes');
                break;
        }
        writer::store_user_preference('mod_forum', 'autosubscribe', $user->autosubscribe, $subscribedescription);

        switch ($user->trackforums) {
            case 0:
                $trackforumdescription = get_string('trackforumsno');
                break;
            case 1:
            default:
                $trackforumdescription = get_string('trackforumsyes');
                break;
        }
        writer::store_user_preference('mod_forum', 'trackforums', $user->trackforums, $trackforumdescription);

        $markasreadonnotification = get_user_preference('markasreadonnotification', null, $user->id);
        if (null !== $markasreadonnotification) {
            switch ($markasreadonnotification) {
                case 0:
                    $markasreadonnotificationdescription = get_string('markasreadonnotificationno', 'mod_forum');
                    break;
                case 1:
                default:
                    $markasreadonnotificationdescription = get_string('markasreadonnotificationyes', 'mod_forum');
                    break;
            }
            writer::store_user_preference('mod_forum', 'markasreadonnotification', $markasreadonnotification, $markasreadonnotificationdescription);
        }
   }

    /**
     * @inheritdoc
     */
    public static function store_user_data(approved_contextlist $contextlist) {
        global $DB;

        if (empty($contextlist)) {
            return;
        }

        $userid = $contextlist->get_user()->id;

        list($contextsql, $contextparams) = $DB->get_in_or_equal($contextlist->get_contextids(), SQL_PARAMS_NAMED);

        $sql = "SELECT
                    c.id AS contextid,
                    f.*,
                    cm.id AS cmid,
                    dig.maildigest,
                    sub.userid AS subscribed,
                    pref.userid AS tracked
                  FROM {context} c
            INNER JOIN {course_modules} cm ON cm.id = c.instanceid
            INNER JOIN {forum} f ON f.id = cm.instance
             LEFT JOIN {forum_digests} dig ON dig.forum = f.id AND dig.userid = :digestuserid
             LEFT JOIN {forum_subscriptions} sub ON sub.forum = f.id AND sub.userid = :subuserid
             LEFT JOIN {forum_track_prefs} pref ON pref.forumid = f.id AND pref.userid = :prefuserid
                 WHERE (
                    c.id {$contextsql}
                )
        ";

        $params = [
            'digestuserid'  => $userid,
            'subuserid'     => $userid,
            'prefuserid'    => $userid,
        ];
        $params += $contextparams;

        // Keep a mapping of forumid to contextid.
        $mappings = [];

        $forums = $DB->get_recordset_sql($sql, $params);
        foreach ($forums as $forum) {
            // Store relevant metadata about this forum instance.
            static::store_digest_data($userid, $forum);
            static::store_subscription_data($userid, $forum);
            static::store_tracking_data($userid, $forum);

            $mappings[$forum->id] = $forum->contextid;
        }
        $forums->close();

        if (!empty($mappings)) {
            // Store all discussion data for this forum.
            static::store_discussion_data($userid, $mappings);

            // Store all post data for this forum.
            static::store_post_data($userid, $mappings);
        }
    }

    /**
     * Store all information about all discussions that we have detected this user to have access to.
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     * @param   array       $mappings A list of mappings from forumid => contextid.
     */
    protected static function store_discussion_data(int $userid, array $mappings) {
        global $DB;


        // Find all of the discussions, and discussion subscriptions for this forum.
        list($foruminsql, $forumparams) = $DB->get_in_or_equal(array_keys($mappings), SQL_PARAMS_NAMED);
        $sql = "SELECT
                    d.*,
                    dsub.preference
                  FROM {forum} f
            INNER JOIN {forum_discussions} d ON d.forum = f.id
             LEFT JOIN {forum_discussion_subs} dsub ON dsub.discussion = d.id
             LEFT JOIN {forum_posts} p ON p.discussion = d.id
                 WHERE f.id ${foruminsql}
                   AND (
                        d.userid    = :discussionuserid OR
                        p.userid    = :postuserid OR
                        dsub.userid = :dsubuserid
                   )
        ";

        $params = [
            'postuserid'        => $userid,
            'discussionuserid'  => $userid,
            'dsubuserid'        => $userid,
        ];
        $params += $forumparams;

        $discussions = $DB->get_recordset_sql($sql, $params);

        foreach ($discussions as $discussion) {
            $context = \context::instance_by_id($mappings[$discussion->forum]);

            // Store related metadata for this discussion.
            static::store_discussion_subscription_data($userid, $context, $discussion);

            // Store the discussion content.
            writer::with_context($context)
                ->store_data(static::get_discussion_area($discussion), $discussion);

            // Forum discussions do not have any files associately directly with them.
        }

        $discussions->close();
    }

    /**
     * Store all information about all posts that we have detected this user to have access to.
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     * @param   array       $mappings A list of mappings from forumid => contextid.
     */
    protected static function store_post_data(int $userid, array $mappings) {
        global $DB;

        // Find all of the posts, and post subscriptions for this forum.
        list($foruminsql, $forumparams) = $DB->get_in_or_equal(array_keys($mappings), SQL_PARAMS_NAMED);
        $ratingsql = \core_rating\privacy\provider::get_sql_join('rat', 'mod_forum', 'post', 'p.id', $userid);
        $sql = "SELECT
                    f.id AS forumid,
                    p.*,
                    d.name AS discussionname,
                    d.timemodified AS discussionmodified,
                    fr.firstread,
                    fr.lastread
                  FROM {forum} f
            INNER JOIN {forum_discussions} d ON d.forum = f.id
            INNER JOIN {forum_posts} p ON p.discussion = d.id
             LEFT JOIN {forum_read} fr ON fr.postid = p.id
            {$ratingsql->join}
                 WHERE f.id ${foruminsql} AND
                (
                    p.userid = :postuserid OR
                    fr.userid = :readuserid OR
                    {$ratingsql->userwhere}
                )
        ";

        $params = [
            'postuserid'    => $userid,
            'readuserid'    => $userid,
        ];
        $params += $forumparams;
        $params += $ratingsql->params;

        $posts = $DB->get_recordset_sql($sql, $params);

        foreach ($posts as $post) {
            $context = \context::instance_by_id($mappings[$post->forumid]);
            $postarea = static::get_post_area($post);

            // Store related metadata.
            static::store_read_data($userid, $context,  $post);

            // Store the post content.
            if ($post->userid == $userid) {
                $post->message = writer::with_context($context)->rewrite_pluginfile_urls($postarea, 'mod_forum', 'post', $post->id, $post->message);

                writer::with_context($context)
                    // Store the post.
                    ->store_data($postarea, $post)

                    // Store the associated files.
                    ->store_area_files($postarea, 'mod_forum', 'post', $post->id)
                    ;

                // Store all ratings against this post as the post belongs to the user. All ratings on it are ratings of their content.
                \core_rating\privacy\provider::store_area_ratings($userid, $context, $postarea, 'mod_forum', 'post', $post->id, false);

                // Store all tags against this post as the tag belongs to the user.
                \core_tag\privacy\provider::store_item_tags($userid, $context, $postarea, 'mod_forum', 'forum_posts', $post->id);
            }

            // Check for any ratings that the user has made on this post.
            \core_rating\privacy\provider::store_area_ratings($userid, $context, $postarea, 'mod_forum', 'post', $post->id, $userid, true);
        }
        $posts->close();
    }

    /**
     * Store data about daily digest preferences
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     * @param   \stdClass   $forum The forum whose data is being stored.
     */
    protected static function store_digest_data(int $userid, \stdClass $forum) {
        if (null !== $forum->maildigest) {
            // The user has a specific maildigest preference for this forum.
            $a = (object) [
                'forum' => format_string($forum->name, true),
            ];

            switch ($forum->maildigest) {
            case 0:
                $a->type = new \lang_string('emaildigestoffshort', 'mod_forum');
                break;
            case 1:
                $a->type = new \lang_string('emaildigestcompleteshort', 'mod_forum');
                break;
            case 2:
                $a->type = new \lang_string('emaildigestsubjectsshort', 'mod_forum');
                break;
            }

            writer::with_context(\context_module::instance($forum->cmid))
                ->store_metadata([], 'digestpreference', $forum->maildigest, new \lang_string('privacy:digesttypepreference', 'mod_forum', $a));
        }
    }

    /**
     * Store data about whether the user subscribes to forum.
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     * @param   \stdClass   $forum The forum whose data is being stored.
     */
    protected static function store_subscription_data(int $userid, \stdClass $forum) {
        if (null !== $forum->subscribed) {
            // The user is subscribed to this forum.
            writer::with_context(\context_module::instance($forum->cmid))
                ->store_metadata([], 'subscriptionpreference', 1, new \lang_string('privacy:subscribedtoforum', 'mod_forum'));
        }
    }

    /**
     * Store data about whether the user subscribes to this particular discussion.
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     * @param   \context_module The instance of the forum context.
     * @param   \stdClass   $discussion The discussion whose data is being stored.
     */
    protected static function store_discussion_subscription_data(int $userid, \context_module $context, \stdClass $discussion) {
        $area = static::get_discussion_area($discussion);
        if (null !== $discussion->preference) {
            // The user has a specific subscription preference for this discussion.
            $a = (object) [];

            switch ($discussion->preference) {
            case \mod_forum\subscriptions::FORUM_DISCUSSION_UNSUBSCRIBED:
                $a->preference = new \lang_string('unsubscribed', 'mod_forum');
                break;
            default:
                $a->preference = new \lang_string('subscribed', 'mod_forum');
                break;
            }

            writer::with_context($context)
                ->store_metadata(
                    $area,
                    'subscriptionpreference',
                    $discussion->preference,
                    new \lang_string('privacy:discussionsubscriptionpreference', 'mod_forum', $a)
                );
        }
    }

    /**
     * Store forum read-tracking data about a particular forum.
     *
     * This is whether a forum has read-tracking enabled or not.
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     * @param   \stdClass   $forum The forum whose data is being stored.
     */
    protected static function store_tracking_data(int $userid, \stdClass $forum) {
        if (null !== $forum->tracked) {
            // The user has a main preference to track all forums, but has opted out of this one.
            writer::with_context(\context_module::instance($forum->cmid))
                ->store_metadata([], 'trackreadpreference', 0, new \lang_string('privacy:readtrackingdisabled', 'mod_forum'));
        }
    }

    /**
     * Store read-tracking information about a particular forum post.
     *
     * @param   int         $userid The userid of the user whose data is to be stored.
     * @param   \context_module The instance of the forum context.
     * @param   \stdClass   $post The post whose data is being stored.
     */
    protected static function store_read_data(int $userid, \context_module $context, \stdClass $post) {
        if (null !== $post->firstread) {
            $a = (object) [
                'firstread' => $post->firstread,
                'lastread'  => $post->lastread,
            ];

            writer::with_context($context)
                ->store_metadata(
                    static::get_post_area($post),
                    'postread',
                    (object) [
                        'firstread' => $post->firstread,
                        'lastread' => $post->lastread,
                    ],
                    new \lang_string('privacy:postwasread', 'mod_forum', $a)
                );
        }
    }
}
