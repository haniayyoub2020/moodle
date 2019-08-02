/**
 * This is the grader index.
 * Note: This will likely be moved to core_grades/local/grader after 3.8, which is why it is currently located in
 * mod_forum/grades/local/grader.
 *
 * Please use relative module names for module imports for modules in the child directories.
 */

// Note: The following function does not exist. It's just an example of what we want to do.
import {getFullScreenWindow} from 'core/windowing/fullscreen';

import Selectors from './selectors';

const getHelpers = (configuration, gradingWindow) => {
    const contentPane = gradingWindow.querySelector(Selectors.regions.content);

    const updateUserContentRegionForUser = (userid) => {
        const userContent = configuration.userContentFetcher(userid);
        contentPane.innerHTML = userContent;
    };

    const updateForUser = (userid) => {
        // Update all regions for the user.
        updateUserContentRegionForUser(userid);
        // For example updateGradeRegionForUser(userid); .
    };

    const getCurrentUserId = () => {
        const currentUserNode = contentPane.querySelector(Selectors.content.userSelector.currentUser);

        return currentUserNode.dataset.userId;
    };

    const registerEventListeners = () => {
        contentPane.addEventListener('click', (e) => {
            if (e.target.matches(Selectors.grader.forum.Launch)) {
                updateForUser(getCurrentUserId());
            }
        });
    };

    const showUser = (userid) => {
        // Do something here to update the current display - i.e. set the user selector to show this user.
        updateForUser(userid);
    };

    return {
        registerEventListeners,
        showUser,
    };
};

export const launch = (configuration) => {
    // Note: This is a fictitious windowing layout manager. It doesn't exist (yet).
    // TODO We can initially create this, but just have it create a full-screen modal if we want to do something really
    // simple/basic for now.
    const gradingWindow = getFullScreenWindow({
        // There will likely be some arguments here.
    });

    const {
        registerEventListeners,
        showUser,
    } = getHelpers(configuration, gradingWindow);

    registerEventListeners();

    if (configuration.initialUserId) {
        // We were provided with an initial user. Load that user.
        showUser(configuration.initialUserId);
    }
};
