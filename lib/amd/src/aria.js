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
 * Helpers to perform ARIA compliance changes to the DOM.
 *
 * @module     core/aria
 * @class      aria
 * @package    core
 * @copyright  2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Selectors from './local/aria/selectors';

// The map of MutationObserver objects for an object.
const observerMap = new Map();

/**
 * Disable element focusability, disabling the tabindex for child elements which are normally focusable.
 *
 * @param {HTMLElement} target
 */
const disableElementFocusability = target => {
    const updateFocus = element => {
        if (typeof element.dataset.ariaHiddenTabIndex !== 'undefined') {
            // This child already has a hidden attribute.
            // Do not modify it as the original value will be lost.
            return;
        }
        // Store the old tabindex in a data attribute.
        element.dataset.ariaHiddenTabIndex = element.getAttribute('tabindex');
        element.setAttribute('tabindex', -1);
    };

    if (target.matches(Selectors.elements.focusable)) {
        updateFocus(target);
    }

    target.querySelectorAll(Selectors.elements.focusable).forEach(updateFocus);
};

/**
 * Re-enable element focusability, restoring any tabindex.
 *
 * @param {HTMLElement} target
 */
const enableElementFocusability = target => {
    const updateFocus = element => {
        if (element.closest(Selectors.aria.hidden)) {
            // This item still has a hidden parent, or is hidden itself. Do not unhide it.
            return;
        }

        const oldTabIndex = element.dataset.ariaHiddenTabIndex;
        if (oldTabIndex !== null) {
            element.setAttribute('tabindex', oldTabIndex);
        }

        delete element.dataset.ariaHiddenTabIndex;
    };

    if (target.matches(Selectors.elements.focusableToUnhide)) {
        updateFocus(target);
    }

    target.querySelectorAll(Selectors.elements.focusableToUnhide).forEach(updateFocus);
};

/**
 * Update the supplied DOM Module to be hidden.
 *
 * @param {HTMLElement} target
 */
export const hide = target => {
    if (!(target instanceof HTMLElement)) {
        // This element is not an HTMLElement.
        // This can happen for Text Nodes.
        return;
    }

    if (target.closest(Selectors.aria.hidden)) {
        // This Element, or a parent Element, is already hidden.
        // Stop processing.
        return;
    }

    // Set the aria-hidden attribute to true.
    target.setAttribute('aria-hidden', true);

    // Ensure that the element itself is not focusable.
    target.dataset.ariaHiddenTabIndex = target.getAttribute('tabindex');
    target.setAttribute('tabindex', -1);

    // Based on advice from https://dequeuniversity.com/rules/axe/4.3/aria-hidden-focus, upon setting the aria-hidden
    // attribute, all focusable elements underneath that element should be modified such that they are not focusable.
    disableElementFocusability(target);

    const newNodeObserver = new MutationObserver(mutationList => {
        mutationList.forEach(mutation => {
            mutation.addedNodes.forEach(disableElementFocusability);
        });
    });

    newNodeObserver.observe(target, {childList: true, subtree: true});

    observerMap.set(target, newNodeObserver);
};

/**
 * Reverse the effect of the hide action.
 *
 * @param {HTMLElement} target
 */
export const unhide = target => {
    if (!(target instanceof HTMLElement)) {
        return;
    }

    // Note: The aria-hidden attribute should be removed, and not set to false.
    // The presence of the attribute is sufficient for some browsers to treat it as being true, regardless of its value.
    target.removeAttribute('aria-hidden');

    // Restore the tabindex across all child nodes of the target.
    enableElementFocusability(target);

    if (observerMap.has(target)) {
        observerMap.get(target).disconnect();
        observerMap.delete(target);
    }
};

/**
 * Correctly mark all siblings of the supplied target Element as hidden.
 *
 * @param {HTMLElement} target
 */
export const hideSiblings = target => {
    if (!(target instanceof HTMLElement)) {
        return;
    }

    if (!target.parentElement) {
        return;
    }

    target.parentElement.childNodes.forEach(node => {
        if (node === target) {
            // Skip self;
            return;
        }

        hide(node);
    });
};

/**
 * Correctly reverse the hide action of all children of the supplied target Element.
 *
 * @param {HTMLElement} target
 */
export const unhideSiblings = target => {
    if (!(target instanceof HTMLElement)) {
        return;
    }

    if (!target.parentElement) {
        return;
    }

    target.parentElement.childNodes.forEach(node => {
        if (node === target) {
            // Skip self;
            return;
        }

        unhide(node);
    });
};
