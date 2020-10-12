YUI.add('moodle-core-formchangechecker', function (Y, NAME) {

/**
 * A utility to check for form changes before navigating away from a page.
 *
 * @module moodle-core-formchangechecker
 */

/**
 * A utility to check for form changes before navigating away from a page.
 *
 * To initialise, call M.core_formchangechecker.init({formid: 'myform'}); or perhaps
 *
 * Y.use('moodle-core-formchangechecker', function() {
 *     M.core_formchangechecker.init({formid: 'myform'});
 * });
 *
 * If you have some fields in your form that you don't want to have tracked, then add
 * a data-formchangechecker-ignore-dirty to the field, or any parent element, and it
 * will be ignored.
 *
 * If you have a submit button in your form that does not actually save the data,
 * then add a data-formchangechecker-ignore-submit attribute to it.
 *
 * @class M.core.formchangechecker
 * @constructor
 */

M.core_formchangechecker = M.core_formchangechecker || {};

M.core_formchangechecker.init = function(config) {
    var formNode = document.querySelector('form#' + config.formid);
    if (!formNode) {
       return;
    }
    require(['core/form/changechecker'], function(ChangeChecker) {
        ChangeChecker.watchForm(formNode);
    });
};

/**
 * Set the form changed state to true
 */
M.core_formchangechecker.set_form_changed = function() {
    require(['core/form/changechecker'], function(ChangeChecker) {
       ChangeChecker.markAllFormsAsDirty();
    });
};

/**
 * Set the form submitted state to true
 */
M.core_formchangechecker.set_form_submitted = function() {
    require(['core/form/changechecker'], function(ChangeChecker) {
       ChangeChecker.markFormSubmitted();
    });
};

/**
 * Reset the form state
 */
M.core_formchangechecker.reset_form_dirty_state = function() {
    require(['core/form/changechecker'], function(ChangeChecker) {
       ChangeChecker.resetAllFormDirtyStates();
    });
};


}, '@VERSION@', {"requires": ["base", "event-focus", "moodle-core-event"]});
