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
 * Module to handle dynamic table features.
 *
 * @module     core_table/dynamic
 * @package    core_table
 * @copyright  2020 Simey Lameze <simey@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import * as Repository from 'core_table/local/dynamic/repository';
import * as Selectors from 'core_table/local/dynamic/selectors';

export const fetch = (handler, uniqueid, sortby, sortorder) => {
    Repository.fetch(handler, uniqueid, sortby, sortorder, {
        courseid: {
            name: 'courseid',
            jointype: 2,
            values: [5]
        }
    })
    .then(data => {
        const participantsList = document.querySelector('.userlist');
        participantsList.innerHTML = data.html;
    })
    .catch(window.console.log);
};

export const init = (handler, uniqueid) => {
    const root = document.querySelector('#userlist');

    root.addEventListener('click', (e) => {
        if (e.target.matches(Selectors.sortablelink)) {
            e.preventDefault();

            var sortableLink = e.target.closest(Selectors.sortablelink),
                sortby = sortableLink.getAttribute('data-sortby'),
                sortorder = sortableLink.getAttribute('data-sortorder');

            fetch(handler, uniqueid, sortby, sortorder);
            window.console.log(sortorder);
        }
    });
};
