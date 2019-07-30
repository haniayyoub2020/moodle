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
 * @module     mod_forum/forum_grader
 * @package    mod_forum
 * @copyright  2019 Mathew May <mathew.solutions>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Notification from 'core/notification';
import Templates from 'core/templates';
import UnifiedGrader from './local/grading/unified_grader/index';

import Repository from './repository';

const templateNames = {
    contentRegion: 'mod_forum/forum_discussion_posts',
};

/**
 * UnifiedGrading class.
 *
 * @function getPostContextFunction
 * @param {Number} cmid The id of the forum we will be using
 * @return {Function}
 */
const getPostContextFunction = (cmid) => {
    return (userid) => {
        Repository.getDiscussionByUserID(userid, cmid)
            .then(function(context) {
                return Templates.render('mod_forum/forum_discussion_posts', context);
            })
            .then(function(html, js) {
                // When this whole chain is moved to plugin then we will call the unified grader here passing html & js
                UnifiedGrader.UnifiedGrading();
                return UnifiedGrader.UnifiedGradingRenderModuleContent(html, js);
            })
            .catch(Notification.exception);
    };
};

const getContentForUserIdFunction = (cmid, templateName) => {
    return Templates
        .render(templateName, getPostContextFunction(cmid))
        .catch(Notification.exception);
};

/**
 * UnifiedGrading class.
 *
 * @param {String} rootElementId The ID of the root node.
 */
export const ForumGrader = (rootElementId) => {
    const rootNode = document.querySelector(`#${rootElementId}`);
    const cmid = rootNode.dataset.cmid;

    UnifiedGrader.init({
        root: rootNode,
        cmid: cmid,
        initialUserId: rootNode.dataset.firstUserid,
        getContentForUserId: getContentForUserIdFunction(cmid, templateNames.contentRegion),

        // Example for future.
        // saveGradeForUser: getGradeFunction(cmid),
    });
};

return ForumGrader;
