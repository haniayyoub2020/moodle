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
 * Provides rendering functionality for the forum summary report subplugin.
 *
 * @package   forumreport_summary
 * @copyright 2019 Michael Hawkins <michaelh@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Render the bulk action menu for the forum summary report
 */
class forumreport_summary_renderer extends plugin_renderer_base {
    public function render_bulk_action_menu() {
        $data = new stdClass();
        $data->id = 'formactionid';
        $data->attributes = [
            [
                'name' => 'data-action',
                'value' => 'toggle'
            ],
            [
                'name' => 'data-togglegroup',
                'value' => 'summaryreport-table'
            ],
            [
                'name' => 'data-toggle',
                'value' => 'action'
            ],
            [
                'name' => 'disabled',
                'value' => true
            ]
        ];
        $data->actions = [
            [
                'value' => '#messageselect',
                'name' => get_string('messageselectadd')
            ]
        ];

        echo $this->render_from_template('forumreport_summary/bulk_action_menu', $data);
    }
}