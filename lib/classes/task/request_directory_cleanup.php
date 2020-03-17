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
 * Simple task to clear older request directories.
 *
 * @package    core
 * @copyright  2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\task;

/**
 * Simple task to clear older request directories.
 *
 * @copyright  2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class request_directory_cleanup extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('requestdirectorycleanup', 'admin');
    }

    /**
     * Remove stale request directories.
     */
    public function execute() {
        $requestroot = make_localcache_directory('request');
        $comparisontime = time() - (6 * HOURSECS);

        // Remove old request storage directories.
        $requestdirs = glob("{$requestroot}/*", GLOB_ONLYDIR);
        foreach ($requestdirs as $requestdir) {
            $timestampfile = "{$requestdir}/.created";
            if (filemtime($timestampfile) < $comparisontime) {
                fulldelete($requesdir);
            }
        }
    }
}
