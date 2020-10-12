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
 * Form Content change detection.
 *
 * @module     core/form/changechecker
 * @package    core
 * @copyright  2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/** @var {Array} The list of watched forms */
let watchedForms = [];

/** @var {Bool} Whether the form change checker has been actively disabled */
let formChangeCheckerDisabled = false;

/**
 * Watch the specified form for changes.
 *
 * @param   {HTMLElement} formNode
 */
export const watchForm = formNode => {
    // Normalise the formNode.
    formNode = formNode.closest('form');

    if (isWatchingForm(formNode)) {
        // This form is already watched.
        return;
    }

    watchedForms.push(formNode);
};

/**
 * Stop watching the specified form for changes.
 *
 * @param   {HTMLElement} formNode
 */
export const unWatchForm = formNode => {
    // Normalise the formNode.
    formNode = formNode.closest('form');

    watchedForms = watchedForms.filter(watchedForm => !!watchedForm.contains(formNode));
};

/**
 * Reset all form dirty states.
 */
export const resetAllFormDirtyStates = () => {
    watchedForms.map(watchedForm => {
        watchedForm.dataset.formSubmitted = false;
        watchedForm.dataset.formDirty = false;
    });
};

/**
 * Mark all forms as dirty.
 *
 * This function is only for backwards-compliance with the old YUI module and should not beused in any other situation.
 * It will be removed in Moodle 4.3.
 */
export const markAllFormsAsDirty = () => {
    watchedForms.map(watchedForm => {
        watchedForm.dataset.formDirty = true;
    });
};

/**
 * Ignore all form dirty states.
 */
export const disableAllChecks = () => {
    formChangeCheckerDisabled = true;
};

/**
 * Check whether any watched from is dirty.
 *
 * @returns {Bool}
 */
const isAnyWatchedFormDirty = () => {
    if (formChangeCheckerDisabled) {
        // The form change checker is disabled.
        return false;
    }

    const hasSubmittedForm = watchedForms.some(watchedForm => !!watchedForm.dataset.formSubmitted);
    if (hasSubmittedForm) {
        // Do not warn about submitted forms, ever.
        return false;
    }

    const hasDirtyForm = watchedForms.some(watchedForm => {
        if (watchedForm.dataset.formDirty) {
            // The form has been marked as dirty.
            return true;
        }

        // Elements currently holding focus will not have triggered change detection.
        // Check whether the value matches the original value upon form load.
        if (document.activeElement && document.activeElement.dataset.propertyIsEnumerable('initialValue')) {
            if (document.activeElement.dataset.initialValue !== document.activeElement.value) {
                return true;
            }
        }
    });

    if (hasDirtyForm) {
        // At least one form is dirty.
        return true;
    }

    // Handle TinyMCE editor instances.
    // TinyMCE forms may not have been initialised at the time that startWatching is called.
    // Check whether any tinyMCE editor is dirty.
    if (typeof window.tinyMCE !== 'undefined') {
        if (window.tinyMCE.editors.some(editor => editor.isDirty())) {
            return true;
        }
    }

    // No dirty forms detected.
    return false;
};

/**
 * Get the watched form for the specified target.
 *
 * @param   {HTMLNode} target
 * @returns {HTMLFormElement}
 */
const getFormForNode = target => watchedForms.find(watchedForm => watchedForm.contains(target));

/**
 * Whether the specified target is a watched form.
 *
 * @param   {HTMLNode} target
 * @returns {Bool}
 */
const isWatchingForm = target => watchedForms.some(watchedForm => watchedForm.contains(target));

/**
 * Whether the specified target should ignore changes or not.
 *
 * @param   {HTMLNode} target
 * @returns {Bool}
 */
const shouldIgnoreChangesForNode = target => !!target.closest('.ignoredirty');

export const markFormChangedFromNode = changedNode => {
    if (!isWatchingForm(changedNode)) {
        // This form has not been watched.
        return;
    }

    if (shouldIgnoreChangesForNode(changedNode)) {
        // This node ignores changes.
        return;
    }

    const formNode = getFormForNode(changedNode);

    // Mark the form as dirty.
    formNode.dataset.formDirty = true;
};

export const markFormSubmitted = formNode => {
    // Normalise the formNode.
    formNode = formNode.closest('form');

    formNode.dataset.formSubmitted = true;
};

const beforeUnloadHandler = e => {
    let warnBeforeUnload = isAnyWatchedFormDirty() && !M.cfg.behatsiterunning;
    if (warnBeforeUnload) {
        // According to the specification, to show the confirmation dialog an event handler should call preventDefault()
        // on the event.
        e.preventDefault();

        // However note that not all browsers support this method, and some instead require the event handler to
        // implement one of two legacy methods:
        // * assigning a string to the event's returnValue property; and
        // * returning a string from the event handler.

        // Assigning a string to the event's returnValue property.
        e.returnValue = M.util.get_string('changesmadereallygoaway', 'moodle');

        // Returning a string from the event handler.
        return e.returnValue;
    }

    // Attaching an event handler/listener to window or document's beforeunload event prevents browsers from using
    // in-memory page navigation caches, like Firefox's Back-Forward cache or WebKit's Page Cache.
    // Remove the handler.
    window.removeEventListener('beforeunload', beforeUnloadHandler);
};

const startWatching = () => {
    document.addEventListener('change', e => {
        if (!isWatchingForm(e.target)) {
            return;
        }

        markFormChangedFromNode(e.target);
    });

    document.addEventListener('click', e => {
        const ignoredButton = e.target.closest('[data-formchangechecker-ignore-submit]');
        if (!ignoredButton) {
            return;
        }

        const ownerForm = e.target.closest('form');
        if (ownerForm) {
            ownerForm.dataset.ignoreSubmission = true;
        }
    });

    document.addEventListener('focusin', e => {
        if (e.target.matches('input, textarea, select')) {
            if (e.target.dataset.propertyIsEnumerable('initialValue')) {
                // The initial value has already been set.
                return;
            }
            e.target.dataset.initialValue = e.target.value;
        }
    });

    document.addEventListener('submit', e => {
        const formNode = e.closest('form');
        if (!formNode) {
            // Weird, but watch for this anyway.
            return;
        }

        if (formNode.dataset.ignoreSubmission) {
            // This form was submitted by a button which requested that the form checked should not mark it as submitted.
            formNode.dataset.ignoreSubmission = false;
            return;
        }

        markFormSubmitted(formNode);
    });

    window.addEventListener('beforeunload', beforeUnloadHandler);
};

startWatching();
