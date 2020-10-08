/**
 * User tour control library.
 *
 * @module     tool_usertours/usertours
 * @class      usertours
 * @package    tool_usertours
 * @copyright  2016 Andrew Nicols <andrew@nicols.co.uk>
 */

import Ajax from 'core/ajax';
import BootstrapTour from 'tool_usertours/tour';
import Templates from 'core/templates';
import Log from 'core/log';
import Notification from 'core/notification';

/**
 * The tourId.
 */
let tourId = null;

/**
 * The current tour details.
 */
let currentTour = null;

/**
 * Initialise the user tour for the current page.
 *
 * @param   {Array}    tourDetails      The matching tours for this page.
 * @param   {Array}    filters          The names of all client side filters.
 * @returns {Promise}
 */
export const init = (tourDetails, filters) => {
    const requiredModules = filters.map(filter => import(`tool_usertours/filter_${filter}`));
    return Promise.all(requiredModules)
    .then(([...allFilters]) => {
        // Run the client side filters to find the first matching tour.
        return tourDetails.find(tourDetail => {
            return allFilters.find(filter => filter.filterMatches(tourDetail));
        }, tourDetails);
    })
    .then(tourDetail => startTour(tourDetail));
};

/**
 * Start the tour given the provided tour configuration.
 *
 * @param   {Object} tourDetail
 */
const startTour = tourDetail => {
    if (!tourDetail) {
        return;
    }

    // Only one tour per page is allowed.
    tourId = tourDetail.tourId;

    let startTour = tourDetail.startTour;
    if (typeof startTour === 'undefined') {
        startTour = true;
    }

    if (startTour) {
        // Fetch the tour configuration.
        fetchTour(tourId);
    }

    addResetLink();

    // Watch for the reset link.
    document.addEventListener('click', e => {
        if (e.target.closest('[data-action="tool_usertours/resetpagetour"]')) {
            e.preventDefault();
            resetTourState(tourId);
        }
    });
};

/**
 * Fetch the configuration specified tour, and start the tour when it has been fetched.
 *
 * @param   {Number}    tourId      The ID of the tour to start.
 * @returns {Promise}
 */
const fetchTour = (tourId) => {
    M.util.js_pending('admin_usertour_fetchTour' + tourId);

    return Promise.all([
        Ajax.call([{
            methodname: 'tool_usertours_fetch_and_start_tour',
            args: {
                tourid:     tourId,
                context:    M.cfg.contextid,
                pageurl:    window.location.href,
            }
        }])[0],
        Templates.renderForPromise('tool_usertours/tourstep', {})
    ])
    .then(([tourData, {html}]) => {
        // If we don't have any tour config (because it doesn't need showing for the current user), return early.
        if (tourData && tourData.tourconfig) {
            startBootstrapTour(tourId, html, tourData.tourconfig);
        }

        return;
    })
    .then(M.util.js_complete('admin_usertour_fetchTour' + tourId))
    .catch(Notification.exception);
};

/**
 * Add a reset link to the page.
 *
 * @returns {Promise}
 */
const addResetLink = () => {
    M.util.js_pending('admin_usertour_addResetLink');

    return Templates.renderForPromise('tool_usertours/resettour', {})
    .then(({html, js}) => Templates.appendNodeContents(getResetContainer(), html, js))
    .then(M.util.js_complete('admin_usertour_addResetLink'))
    .catch();
};

/**
 * Get the container used for the reset link.
 *
 * @returns {HTMLElement}
 */
const getResetContainer = () => {
    // Find the most suitable place on the page with fallback to legacy selectors and finally the body if there is no better place.
    let container = document.querySelector('.tool_usertours-resettourcontainer');
    if (container) {
        return container;
    }

    container = document.querySelector('.logininfo');
    if (container) {
        return container;
    }

    container = document.querySelector('footer');
    if (container) {
        return container;
    }

    return document.querySelector('body');
};

/**
 * Get the BootstrapTour instance.
 *
 * @param   {Number}    tourId      The ID of the tour to start.
 * @param   {String}    template    The template to use.
 * @param   {Object}    tourConfig  The tour configuration.
 * @return  {BootstrapTour}
 */
const getBootstrapTour = (tourId, template, tourConfig) => {
    if (currentTour) {
        // End the current tour, but disable end tour handler.
        tourConfig.onEnd = null;
        currentTour.endTour();
        currentTour = null;
    }

    // Normalize for the new library.
    tourConfig.eventHandlers = {
        afterEnd: [markTourComplete],
        afterRender: [markStepShown],
    };

    // Sort out the tour name.
    tourConfig.tourName = tourConfig.name;
    delete tourConfig.name;

    // Add the template to the configuration.
    // This enables translations of the buttons.
    tourConfig.template = template;

    tourConfig.steps = tourConfig.steps.map(step => {
        if (typeof step.element !== 'undefined') {
            step.target = step.element;
            delete step.element;
        }

        if (typeof step.reflex !== 'undefined') {
            step.moveOnClick = !!step.reflex;
            delete step.reflex;
        }

        if (typeof step.content !== 'undefined') {
            step.body = step.content;
            delete step.content;
        }

        return step;
    });

    return new BootstrapTour(tourConfig);
};

/**
 * Start the specified tour.
 *
 * @param   {Number}    tourId      The ID of the tour to start.
 * @param   {String}    template    The template to use.
 * @param   {Object}    tourConfig  The tour configuration.
 * @return  {Object}
 */
const startBootstrapTour = (tourId, template, tourConfig) => {
    currentTour = getBootstrapTour(tourId, template, tourConfig);
    return currentTour.startTour();
};

/**
 * Mark the specified step as being shownd by the user.
 *
 * @param   {BootstrapTour} tour
 * @returns {Promise}
 */
const markStepShown = tour => {
    const stepConfig = tour.getStepConfig(tour.getCurrentStepNumber());
    return Ajax.call([{
        methodname: 'tool_usertours_step_shown',
        args: {
            tourid:     tourId,
            context:    M.cfg.contextid,
            pageurl:    window.location.href,
            stepid:     stepConfig.stepid,
            stepindex:  tour.getCurrentStepNumber(),
        }
    }])[0]
    .catch(Log.error);
};

/**
 * Mark the specified tour as being completed by the user.
 *
 * @param   {BootstrapTour} tour
 * @returns {Promise}
 */
const markTourComplete = tour => {
    const stepConfig = tour.getStepConfig(tour.getCurrentStepNumber());
    return Ajax.call([{
        methodname: 'tool_usertours_complete_tour',
        args: {
            tourid:     tourId,
            context:    M.cfg.contextid,
            pageurl:    window.location.href,
            stepid:     stepConfig.stepid,
            stepindex:  tour.getCurrentStepNumber(),
        }
    }])[0]
    .catch(Log.error);
};

/**
 * Reset the state, and restart the the tour on the current page.
 *
 * @param   {Number}    tourId      The ID of the tour to start.
 * @returns {Promise}
 */
export const resetTourState = tourId => {
    return Ajax.call([
        {
            methodname: 'tool_usertours_reset_tour',
            args: {
                tourid: tourId,
                context: M.cfg.contextid,
                pageurl: window.location.href,
            }
        }
    ])[0]
    .then(response => {
        if (response.startTour) {
            fetchTour(response.startTour);
        }
        return;
    })
    .catch(Notification.exception);
};
