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
 * Folder activity for Moodle.
 *
 * @package     mod_forum
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_forum\files\access;

use core_files\local\access\mod_controller;
use mod_forum\local\container;
use stdClass;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controller extends mod_controller {

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected static function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            'post' => self::ITEMID_PRESENT_IN_USE,
            'attachment' => self::ITEMID_PRESENT_IN_USE,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|stdClass $user
     * @return  bool
     */
    public static function can_access_storedfile(stored_file $file, ?object $user = null): bool {
        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to the the shared activity file areas, and not this specific activity.
            return true;
        }

        // For both the post and attachment file areas, the itemid of the file is the postid of a forum post.
        $vaultfactory = container::get_vault_factory();

        $postvault = $vaultfactory->get_post_vault();
        $post = $postvault->get_from_id($file->get_itemid());

        $discussionvault = $vaultfactory->get_discussion_vault();
        $discussion = $discussionvault->get_from_id($post->get_discussion_id());

        $forumvault = $vaultfactory->get_forum_vault();
        $forum = $forumvault->get_from_id($discussion->get_forum_id());

        $managerfactory = container::get_manager_factory();
        $capabilitymanager = $managerfactory->get_capability_manager($forum);

        $user = static::get_user($user);
        if (!$capabilitymanager->can_view_discussions($user)) {
            return false;
        }

        if (!$capabilitymanager->can_view_post($user, $discussion, $post)) {
            return false;
        }

        return true;
    }
}
