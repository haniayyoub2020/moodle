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
 * A list of discussions.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_forum;

/**
 * A list of discussions.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class discussion_list {
    /**
     * @var \stdClass[] The list of discussions.
     */
    protected $discussions;

    /**
     * @var bool Whether there are more entries.
     */
    protected $hasmore;

    /**
     */
    public function __construct(array $discussions, bool $hasmore) {
        $this->discussions = $discussions;
        $this->hasmore = $hasmore;
    }

    /**
     * Get the list of discussions.
     *
     * @return \stdClass[]
     */
    public function get_discussions() : array {
        return $this->discussions;
    }

    /**
     * Whether there are more discussions to show.
     *
     * @return  bool
     */
    public function has_more_entries() : bool {
        return $this->hasmore;
    }

    /**
     * Whether there are discussions to show.
     *
     * @return  bool
     */
    public function has_any() : bool {
        return !empty($this->discussions);
    }
}
