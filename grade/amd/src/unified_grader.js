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
 *
 * @module     core_grades/unified_grader
 * @package    core_grades
 * @copyright  2019 Mathew May <mathew.solutions>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import Templates from 'core/templates';
import Selectors from './selectors';
import $ from 'core/jquery';

const registerEventListeners = (rootNode) => {

    rootNode.addEventListener('click', (e) => {
        if (e.target.matches(Selectors.toggles.userNavigation)) {
            // TODO: Ideally kill jQuery here.
            $(rootNode).find(Selectors.regions.user).toggle();
        }

        if (e.target.matches(Selectors.toggles.moduleContent)) {
            // TODO: Ideally kill jQuery here.
            $(rootNode).find(Selectors.regions.moduleContent).toggle();
        }

        if (e.target.matches(Selectors.toggles.gradePane)) {
            // TODO: Ideally kill jQuery here.
            $(rootNode).find(Selectors.regions.gradePane).toggle();
        }

        if (e.target.matches(Selectors.navigation.gradingActions)) {
            // TODO: Ideally kill jQuery here.
            $(rootNode).find(Selectors.regions.gradingActions).toggle();
        }
    });
};

const getContentPublisher = (templateName) => {
    return (context) => {
        return Templates
            .render(templateName, context)
            .then((html, js) => {
                return Templates.replaceNode(Selectors.region.moduleContent, html, js);
            })
            .catch(Notification.exception);
    };
};

export const UnifiedGrader = (rootNode, config) => {
    const displayContentForUser = getContentPublisher(config.templateName);
    displayContentForUser(config.initialUserId);

    registerEventListeners(rootNode);

    // You might instantiate the user selector here, and pass it the function displayContentForUser as the thing to call
    // when it has selected a user.
};
