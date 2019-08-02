import Selectors from './selectors.js';
import Templates from 'core/templates';

import Grader from 'mod_forum/grades/local/grader/index';
import Repository from 'mod_forum/repository';

const getUserListFetcher = (cmid) => {
    return () => {
        return Repository.getUserList(cmid);
    };
};

const getContentFetcher = (cmid) => {
    return (userid) => {
        Repository.getDiscussionByUserID(userid, cmid)
        .then(function(context) {
            return Templates.render('mod_forum/forum_discussion_posts', context);
        })
        .then(function(html, js) {
            // When this whole chain is moved to plugin then we will call the unified grader here passing html & js
            Grader.UnifiedGrading();
            return Grader.UnifiedGradingRenderModuleContent(html, js);
        })
        .catch(Notification.exception);
    };
};

const launchForumGrader = (rootNode) => {
    Grader.launch({
        cmid: rootNode.dataset.cmid,
        initialUserId: rootNode.dataset.initialUserId || null,
        userListFetcher: getUserListFetcher(rootNode.dataset.cmid),
        userContentfetcher: getContentFetcher(rootNode.dataset.cmid),
    });
};

const registerEventListeners = (rootNode) => {
    // Note: We listen to the entire body here because you can launch it from anywhere on the page.
    document.addEventListener('click', (e) => {
        if (e.target.matches(Selectors.grader.forum.Launch)) {
            launchForumGrader(rootNode);
        }
    });
};

/**
 * @param {string} rootNodeId The root node
 */
export default function(rootNodeId) {
    registerEventListeners(document.querySelector(rootNodeId));
}
