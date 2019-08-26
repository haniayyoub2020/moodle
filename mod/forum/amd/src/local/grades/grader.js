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
 * This module will tie together all of the different calls the gradable module will make.
 *
 * @module     core_grades/unified_grader
 * @package    core_grades
 * @copyright  2019 Mathew May <mathew.solutions>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import Templates from 'core/templates';
import Selectors from './local/grader/selectors';
import {createLayout as createFullScreenWindow} from 'mod_forum/local/layout/fullscreen';
import createUserPicker from './local/grader/userpicker';

const templateNames = {
    grader: {
        app: 'mod_forum/local/grades/grader',
    },
};

const getFetchAndShowUserCallback = (container, getContentForUser) => {
    return async(userObject) => {
    debugger; // eslint-disable-line
        const contentForUser = await getContentForUser(userObject);
        container.querySelector(Selectors.regions.content).innerHTML = contentForUser;
    };
};

const displayUserPicker = (container, content) => { // eslint-disable-line
    container.querySelector(Selectors.regions.userPicker).innerHTML = content;
};

const displayGrader = (container, content) => {
    Templates.replaceNodeContents(container, content, '');
};

const registerEventListeners = (graderLayout, container) => {
    container.addEventListener('click', (e) => {
        if (e.target.matches(Selectors.buttons.toggleFullscreen)) {
            e.stopImmediatePropagation();
            e.preventDefault();

            graderLayout.toggleFullscreen();
        } else if (e.target.matches(Selectors.buttons.closeGrader)) {
            e.stopImmediatePropagation();
            e.preventDefault();

            graderLayout.close();
        }
    });
};

export const launch = async(
    getListOfUsers,
    getContentForUser, {
        initialUserId = null,
    } = {}
) => {
    // Fetch the layout (fetch + render template), and list of users in parallel synchronously.
    const [
        graderLayout,
        graderHTMLLayout,
        userList,
    ] = await Promise.all([
        createFullScreenWindow({fullscreen: false}),
        Templates.render(templateNames.grader.app, {}),
        getListOfUsers(),
    ]);

    const graderContainer = graderLayout.getContainer();
    let currentUser = 0;

    // TODO: Does userList give us an object of userid => userdata; or an array of index => useridata
    // Assuming an Object of userid => userdata for now.
    if (initialUserId) {
        currentUser = userList[initialUserId];
    } else {
        currentUser = userList[0];
    }

    // Create the set user callback
    const showUser = getFetchAndShowUserCallback(graderContainer, getContentForUser);

    // Add the grader to the main layout.
    displayGrader(graderContainer, graderHTMLLayout);

    // Add event listeners
    registerEventListeners(graderLayout, graderContainer);
    debugger; // eslint-disable-line

    // Create the user picker and get the content forthe first user.
    const [userPicker] = await Promise.all([
        createUserPicker(userList, currentUser, showUser),
        showUser(currentUser), // eslint-disable-line
    ]);
    window.console.log(userPicker);
    debugger; // eslint-disable-line

    // Display the picker
    displayUserPicker(graderContainer, userPicker);
};
