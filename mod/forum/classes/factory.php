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
 * The forum factory.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_forum;

use \mod_forum\instance;

defined('MOODLE_INTERNAL') || die();

/**
 * The forum instance factory.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class factory {

    /**
     * Get the forum instance using the database record for a forum.
     *
     * @param   \stdClass   $record The record from the forum table.
     * @param   \stdClass   $user The user to use.
     * @return  instance
     */
    public static function get_forum_by_record(\stdClass $record, \stdClass $user = null) : instance {
        $typeclass = static::get_type_classname($record->type);

        return new $typeclass($record, $user);
    }

    /**
     * Get the forum instance using a cm_info object.
     *
     * @param   \cm_info    $cm The course module instance
     * @param   \stdClass   $user The user to use.
     * @return  instance
     */
    public static function get_forum_by_cm_info(\cm_info $cm, \stdClass $user = null) : instance {
        $instance = static::get_forum_by_id($cm->instance, $user);
        $instance->set_cm_info($cm);

        return $instance;
    }

    /**
     * Get the forum instance using a cm_info object.
     *
     * @param   \cm_info    $cm The course module instance
     * @param   \stdClass   $record The record from the forum table.
     * @param   \stdClass   $user The user to use.
     * @return  instance
     */
    public static function get_forum_by_cm_info_with_record(\cm_info $cm, \stdClass $record, \stdClass $user = null) : instance {
        $instance = static::get_forum_by_record($record, $user);
        $instance->set_cm_info($cm);

        return $instance;
    }

    /**
     * Get the forum instance using a database record from the coures_module table.
     *
     * @param   \cm_info    $cm The course module instance
     * @param   \stdClass   $user The user to use.
     * @return  instance
     */
    public static function get_forum_by_course_module(\stdClass $cm, \stdClass $user = null) : instance {
        $instance = static::get_forum_by_id($cm->instance, $user);

        return $instance;
    }

    /**
     * Get the forum instance using a database record from the coures_module table.
     *
     * @param   \context_module $context The context_module
     * @param   \stdClass   $user The user to use.
     * @return  instance
     */
    public static function get_forum_by_context(\context_module $context, \stdClass $user = null) : instance {
        $userid = null === $user ? 0 : $user->id;
        $coursecontext = $context->get_course_context();
        list(, $cm) = get_course_and_cm_from_cmid($context->instanceid, 'forum', $coursecontext->instanceid, $userid);

        $instance = static::get_forum_by_id($cm->instance, $user);

        return $instance;
    }

    /**
     * Get the forum instance using the ID of the forum.
     *
     * @param   int         $id The instance ID of the forum instance
     * @param   \stdClass   $user The user to use.
     * @return  instance
     */
    public static function get_forum_by_id(int $id, \stdClass $user = null) : instance {
        global $DB;

        $record = $DB->get_record('forum', [
                'id' => $id,
            ], '*', MUST_EXIST);

        return static::get_forum_by_record($record, $user);
    }

    /**
     * Get the forum instance using the ID of the course module.
     *
     * @param   int         $id The ID of the course module.
     * @param   \stdClass   $user The user to use.
     * @return  instance
     */
    public static function get_forum_by_cmid(int $id, \stdClass $user = null) : instance {
        return static::get_forum_by_course_module(get_coursemodule_from_id('forum', $id), $user);
    }

    /**
     * Get the forum instance using the ID of a discussion within the forum.
     *
     * @param   int         $postid The id of the forum discussion.
     * @return  instance
     * @return  instance
     */
    public static function get_forum_by_discussionid(int $discussionid, \stdClass $user = null) : instance {
        global $DB;

        $sql = "SELECT f.*
                  FROM {forum} f
                  JOIN {forum_discussions} d ON f.id = d.forum
                 WHERE d.id = :discussionid
            ";
        $record = $DB->get_record_sql($sql, ['discussionid' => $discussionid], MUST_EXIST);

        return static::get_forum_by_record($record, $user);
    }

    /**
     * Get the forum instance using the ID of a post within the forum.
     *
     * @param   int         $postid The id of the forum post.
     * @return  instance
     */
    public static function get_forum_by_postid(int $postid, \stdClass $user = null) : instance {
        global $DB;

        $sql = "SELECT f.*
                  FROM {forum} f
                  JOIN {forum_discussions} d ON f.id = d.forum
                  JOIN {forum_posts} p ON d.id = p.discussion
                 WHERE p.id = :postid
            ";
        $record = $DB->get_record_sql($sql, ['postid' => $postid], MUST_EXIST);

        return static::get_forum_by_record($record, $user);
    }

    /**
     * Get the forum instance, discussion record, and post record using the ID of a post within the forum.
     *
     * @param   int         $discussionid The id of the forum discussion.
     * @return  \stdClass
     */
    public static function get_data_by_discussionid(int $discussionid, \stdClass $user = null) : \stdClass {
        global $DB;

        $discussionfields = $DB->get_preload_columns('forum_discussions', 'd');
        $forumfields = $DB->get_preload_columns('forum', 'f');
        $coursefields = $DB->get_preload_columns('course', 'c');

        $discussionfieldsql = $DB->get_preload_columns_sql($discussionfields, 'd');
        $forumfieldsql = $DB->get_preload_columns_sql($forumfields, 'f');
        $coursefieldsql = $DB->get_preload_columns_sql($coursefields, 'c');

        $sql = "SELECT {$discussionfieldsql}, {$forumfieldsql}, {$coursefieldsql}
                  FROM {forum_discussions} d
                  JOIN {forum} f ON f.id = d.forum
                  JOIN {course} c ON c.id = f.course
                 WHERE d.id = :discussionid
            ";
        $record = $DB->get_record_sql($sql, ['discussionid' => $discussionid], MUST_EXIST);

        $forum = $DB->extract_fields_from_object($forumfields, $record);
        $discussion = $DB->extract_fields_from_object($discussionfields, $record);

        $instance = static::get_forum_by_record($forum, $user);
        $instance->set_course($DB->extract_fields_from_object($coursefields, $record));

        return (object) [
            'instance' => $instance,
            'discussion' => $discussion,
        ];
    }

    /**
     * Get the forum instance, discussion record, and post record using the ID of a post within the forum.
     *
     * @param   int         $id The id of the forum post.
     * @return  \stdClass
     */
    public static function get_data_by_postid(int $postid, \stdClass $user = null) : \stdClass {
        global $DB;

        $postfields = $DB->get_preload_columns('forum_posts', 'p');
        $discussionfields = $DB->get_preload_columns('forum_discussions', 'd');
        $forumfields = $DB->get_preload_columns('forum', 'f');
        $coursefields = $DB->get_preload_columns('course', 'c');

        $discussionfieldsql = $DB->get_preload_columns_sql($discussionfields, 'd');
        $postfieldsql = $DB->get_preload_columns_sql($postfields, 'p');
        $forumfieldsql = $DB->get_preload_columns_sql($forumfields, 'f');
        $coursefieldsql = $DB->get_preload_columns_sql($coursefields, 'c');

        $sql = "SELECT {$coursefieldsql}, {$forumfieldsql}, {$discussionfieldsql}, {$postfieldsql}
                  FROM {forum_posts} p
                  JOIN {forum_discussions} d ON d.id = p.discussion
                  JOIN {forum} f ON f.id = d.forum
                  JOIN {course} c ON c.id = f.course
                 WHERE p.id = :postid
            ";
        $record = $DB->get_record_sql($sql, ['postid' => $postid], MUST_EXIST);

        $post = $DB->extract_fields_from_object($postfields, $record);
        $discussion = $DB->extract_fields_from_object($discussionfields, $record);
        $forum = $DB->extract_fields_from_object($forumfields, $record);

        $instance = static::get_forum_by_record($forum, $user);
        $instance->set_course($DB->extract_fields_from_object($coursefields, $record));


        return (object) [
            'instance' => $instance,
            'discussion' => $discussion,
            'post' => $post,
        ];
    }

    /**
     * Get the name of the class for the specified type.
     *
     * @param   string      $type The type of forum
     * @return  string
     */
    protected static function get_type_classname(string $type) : string {
        return "\\forumtype_{$type}\\type";
    }
}
