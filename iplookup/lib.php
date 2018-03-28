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
 * IP Lookup utility functions
 *
 * @package    core
 * @subpackage iplookup
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns location information
 * @param string $ip
 * @return array
 * @deprecated Moodle 3.5.
 */
function iplookup_find_location($ip) {
    debugging('The iplookup_find_location function has been deprecated. Please update your code to use \core\iplookup instead.', DEBUG_DEVELOPER);

    $info = [
        'city' => null,
        'country' => null,
        'latitude' => null,
        'longitude' => null,
        'error' => null,
        'note' => '',
        'title' => [
        ]
    ];

    try {
        $data = \core\iplookup::lookup($ip);

        $info['city'] = $data->get_city();
        $info['title'][] = $info['city'];
        $info['country'] = $data->get_country();
        $info['title'][] = $info['country'];
        $info['latitude'] = $data->get_latitude();
        $info['longitude'] = $data->get_longitude();

    } catch (\moodle_exception $e) {
        $info->error = $e->getMessage();
    }

    return $info;
}
