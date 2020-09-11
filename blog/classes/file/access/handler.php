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
 * Blog subsystem for Moodle.
 *
 * @package     core_blog
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_blog\files\access;

use core_files\local\access\handler_base;
use core_blog\local\container;
use stdClass;
use stored_file;

/**
 * File access control.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class handler extends handler_base {

    /** @var object A cached copy of the blog post */
    protected $entry = null;

    /**
     * Get a list of the file areas in use for this plugin.
     *
     * @return  array
     */
    protected function get_file_areas(): array {
        return array_merge(parent::get_file_areas(), [
            'attachment' => self::ITEMID_PRESENT_IN_USE,
            'post' => self::ITEMID_PRESENT_IN_USE,
        ]);
    }

    /**
     * Get the blog post record.
     *
     * @return  object
     */
    protected function get_blog_post(): ?object {
        if ($this->entry === null) {
            $this->entry = $DB->get_record('post', [
                'module' => 'blog',
                'id' => $this->get_stored_file()->get_itemid(),
            ]);
        }

        return $this->entry;
    }

    /**
     * Whether the user can access the file.
     *
     * @param   null|stdClass $user
     * @return  bool
     */
    public function can_access(?object $user = null): bool {
        global $CFG;

        $entry = $this->get_blog_post();
        if ($entry === null) {
            // No blog post associate with the file.
            return false;
        }

        if (isguestuser()) {
            // Guest access is not possible for a global blog entry.
            return false;
        }

        $user = $this->get_user($user);

        if ($CFG->bloglevel == BLOG_USER_LEVEL) {
            if ($user->id != $entry->userid) {
                return false;
            }
        }

        if ($entry->publishstate === 'draft') {
            if ($user->id != $entry->userid) {
                return false;
            }
        }

        return true;
    }

    /**
     * Whether login is required to access this item.
     *
     * @return  bool
     */
    public function requires_login(): bool {
        global $CFG;

        if ($CFG->bloglevel < BLOG_GLOBAL_LEVEL) {
            return true;
        }

        if ($CFG->forcelogin) {
            return true;
        }

        $entry = $this->get_blog_post();

        if ($entry->publishstate === 'site') {
            return true;
        }

        if ($entry->publishstate === 'draft') {
            return true;
        }

        return false;
    }
}
