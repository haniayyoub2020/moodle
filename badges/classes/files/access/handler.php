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
 * Badges subsystem for Moodle.
 *
 * @package     core_badges
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_badges\files\access;

use core_files\local\access\handler_base;
use core_badges\local\container;
use stdClass;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class handler extends handler_base {

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            // The itemid is the badge id in both cases.
            'badgeimage' => self::ITEMID_PRESENT_IN_USE,
            'userbadge' => self::ITEMID_PRESENT_IN_USE,
        ]);
    }

    /**
     * Whether the user can access the stored file.
     *
     * @param   stored_file $file
     * @param   null|stdClass $user
     * @return  bool
     */
    public function can_access_storedfile(stored_file $file, ?object $user): bool {
        if (!parent::can_access_storedfile($file, $user)) {
            return false;
        }

        if (array_key_exists($file->get_filearea(), parent::get_file_areas())) {
            // This file belongs to a shared filearea, and not this specific activity.
            return true;
        }

        // If there is no badge, an error will be thrown here.
        $badge = new \core_badges\badge($file->get_itemid());

        if ($filearea === 'badgeimage') {
            if ($filename !== 'f1' && $filename !== 'f2' && $filename !== 'f3') {
                return false;
            }

            if ($badge->get_context()->id != $file->get_contextid()) {
                return false;
            }
        }

        if ($filearea === 'userbadge') {
            // Use badges are at the user context.
            if ($this->context->contextlevel != CONTEXT_USER) {
                return false;
            }

            // Note: It is not possible to check the userbadge context against the badge object, because a user badge is
            // a badge awarded to a user from a course or site. The context in the badge object is the awarding entity.
        }

        return true;
    }

    /**
     * Fetch a file proxy which can be served.
     *
     * @param   stdClass $user The user accessing the file
     * @param   context $context The context that the file is in
     * @param   string $filearea The file area as reported to the pluginfile
     * @param   array $args The remaining args from the pluginfile
     * @return  null|stored_file_proxy An object which knows how to fetch or serve the file content
     */
    public function get_file_proxy(): ?stored_file_proxy {
        $proxy = parent::get_file_proxy();

        if ($this->filearea === 'userbadge') {
            // User badges are forcibly downloaded.
            $proxy->set_force_download(true);
        }

        return $proxy;
    }
}
