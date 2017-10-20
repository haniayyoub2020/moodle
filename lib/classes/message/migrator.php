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
 * Message migrator.
 *
 * @package   core_message
 * @since     Moodle 3.5
 * @copyright 2017 Andrew Robert Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\message;

defined('MOODLE_INTERNAL') || die();

/**
 * Message migrator.
 *
 * @package   core_message
 * @since     Moodle 3.5
 * @copyright 2017 Andrew Robert Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class migrator {
    public static function migrate_user_messages(\stdClass $sourceuser) {
        global $DB;
        $lockfactory = \core\lock\lock_config::get_lock_factory('messagemigrator');

        if (!$sourcelock = $lockfactory->get_lock($sourceuser->id, 5)) {
            // Could not get the lock.
            // Return early.
            return false;
        }
        // TODO remove.
        $sourcelock->release();

        // TODO
        // Remove the user preference that this user is to be converted.

        $unreadfromto= $DB->sql_concat_join("'_'", ["'unread'", 'useridfrom', 'useridto']);
        $unreadtofrom= $DB->sql_concat_join("'_'", ["'unread'", 'useridto', 'useridfrom']);
        $readfromto= $DB->sql_concat_join("'_'", ["'read'", 'useridfrom', 'useridto']);
        $readtofrom= $DB->sql_concat_join("'_'", ["'read'", 'useridto', 'useridfrom']);
        $targetusers  = $DB->get_records_sql("
            SELECT {$unreadfromto}, useridto AS id FROM {message} WHERE useridfrom = ? AND notification = 0
                UNION ALL
            SELECT {$unreadtofrom}, useridfrom AS id FROM {message} WHERE useridto = ? AND notification = 0
                UNION ALL
            SELECT {$readfromto}, useridto AS id FROM {message_read} WHERE useridfrom = ? AND notification = 0
                UNION ALL
            SELECT {$readtofrom}, useridfrom AS id FROM {message_read} WHERE useridto = ? AND notification = 0
        ", [
            $sourceuser->id,
            $sourceuser->id,
            $sourceuser->id,
            $sourceuser->id,
        ]);

        // Get a list of all users this user has interacted with from the old tables.
        foreach ($targetusers as $targetuser) {
            // Get a lock for the target user.
            $userids = [$sourceuser->id, $targetuser->id];
            sort($userids);
            $lockname = implode('-', $userids);
            if (!$targetlock = $lockfactory->get_lock($lockname, 1)) {
                // Unable not get the lock immediately.
                // This user may also be running the same conversion.
                // Skip this user.
                // Any messages between these two users will be missing, but will be picked up by the cleanup task.
                continue;
            }

            // TODO remove.
            $targetlock->release();

            // Get/create the discussion.
            $discussionid = manager::get_discussion_with_users([
                    $sourceuser->id,
                    $targetuser->id,
                ]);

            // Track the old messages to be removed.
            $removals = (object) [
                'r' => [],
                'u' => [],
            ];

            // Track the maxread timestamp.
            $maxread = [
                $sourceuser->id => 0,
                $targetuser->id => 0,
            ];

            // Track the messages marked as deleted by either user.
            $deleted = [];

            // Fetch all messages between these two users.
            $messages = static::get_messages_between_users($sourceuser->id, $targetuser->id);

            foreach ($messages as $message) {
                $newmessage = (object) [
                        'discussionid' => $discussionid,
                        'sender' => $message->sender,
                        'subject' => $message->subject,
                        'fullmessage' => $message->fullmessage,
                        'fullmessageformat' => $message->fullmessageformat,
                        'fullmessagehtml' => $message->fullmessagehtml,
                        'smallmessage' => $message->smallmessage,
                        'timecreated' => $message->timecreated,
                    ];

                if (empty($messages->timeread)) {
                    $removals->u[] = $message->originalid;
                } else {
                    $removals->r[] = $message->originalid;
                    $maxread[$message->useridto] = max($message->timeread, $maxread[$message->useridto]);
                }

                $newmessage->id = $DB->insert_record('messages', $newmessage);

                if (!empty($message->timeuserfromdeleted)) {
                    $deleted[] = (object) [
                        'messageid' => $newmessage->id,
                        'userid' => $message->sender,
                        'deleted' => $message->timeuserfromdeleted,
                    ];
                }

                if (!empty($message->timeusertodeleted)) {
                    $deleted[] = (object) [
                        'messageid' => $newmessage->id,
                        'userid' => $message->recipient,
                        'deleted' => $message->timetofromdeleted,
                    ];
                }

                unset($message);
            }
            $messages->close();

            // Delete the old messages.
            if (!empty($removals->u)) {
                list($delsql, $delparams) = $DB->get_in_or_equal($removals->u);
                $DB->delete_records_select('message', "id {$delsql}", $delparams);
            }

            if (!empty($removals->r)) {
                list($delsql, $delparams) = $DB->get_in_or_equal($removals->r);
                $DB->delete_records_select('message_read', "id {$delsql}", $delparams);
            }

            // Update the participants to set the seento flag.
            if (!empty($maxread[$sourceuser->id])) {
                manager::mark_discussion_seen($discussionid, $sourceuser, $maxread[$sourceuser->id]);
            }
            if (!empty($maxread[$targetuser->id])) {
                manager::mark_discussion_seen($discussionid, $targetuser, $maxread[$targetuser->id]);
            }

            // Mark some messages as deleted.
            if (!empty($deleted)) {
                $DB->insert_records('message_deleted', $deleted);
            }

            //$targetlock->release();
        }

        //$sourcelock->release();
    }

    public static function get_messages_between_users($user1, $user2) {
        global $DB;

        $readid = $DB->sql_concat("'read_'", 'id');
        $unreadid = $DB->sql_concat("'unread_'", 'id');
        $sql = "
            SELECT
                    {$unreadid},
                    id AS originalid,
                    useridfrom AS sender,
                    useridto AS recipient,
                    subject,
                    fullmessage,
                    fullmessageformat,
                    fullmessagehtml,
                    smallmessage,
                    timecreated,
                    0 AS timeread,
                    timeuserfromdeleted,
                    timeusertodeleted
              FROM {message}
             WHERE
                (
                    (useridfrom = :unreaduser1from AND useridto = :unreaduser2to)
                        OR
                    (useridfrom = :unreaduser2from AND useridto = :unreaduser1to)
                ) AND notification = 0
         UNION ALL
            SELECT
                    {$readid},
                    id AS originalid,
                    useridfrom AS sender,
                    useridto AS recipient,
                    subject,
                    fullmessage,
                    fullmessageformat,
                    fullmessagehtml,
                    smallmessage,
                    timecreated,
                    timeread,
                    timeuserfromdeleted,
                    timeusertodeleted
              FROM {message_read}
             WHERE
                (
                    (useridfrom = :readuser1from AND useridto = :readuser2to)
                        OR
                    (useridfrom = :readuser2from AND useridto = :readuser1to)
                ) AND notification = 0
        ";

        return $DB->get_recordset_sql($sql, [
            'unreaduser1from' => $user1,
            'unreaduser2from' => $user2,
            'unreaduser1to' => $user1,
            'unreaduser2to' => $user2,
            'readuser1from' => $user1,
            'readuser2from' => $user2,
            'readuser1to' => $user1,
            'readuser2to' => $user2,
        ]);
    }
}
