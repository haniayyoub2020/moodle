YUI.add('moodle-core-notification-confirm', function (Y, NAME) {

/* eslint-disable no-unused-vars, no-unused-expressions */
var DIALOGUE_PREFIX,
    BASE,
    CONFIRMYES,
    CONFIRMNO,
    TITLE,
    QUESTION,
    CSS;

DIALOGUE_PREFIX = 'moodle-dialogue',
BASE = 'notificationBase',
CONFIRMYES = 'yesLabel',
CONFIRMNO = 'noLabel',
TITLE = 'title',
QUESTION = 'question',
CSS = {
    BASE: 'moodle-dialogue-base',
    WRAP: 'moodle-dialogue-wrap',
    HEADER: 'moodle-dialogue-hd',
    BODY: 'moodle-dialogue-bd',
    CONTENT: 'moodle-dialogue-content',
    FOOTER: 'moodle-dialogue-ft',
    HIDDEN: 'hidden',
    LIGHTBOX: 'moodle-dialogue-lightbox'
};

// Set up the namespace once.
M.core = M.core || {};
/* global CONFIRMYES, CONFIRMNO, QUESTION, BASE, TITLE, DIALOGUE_PREFIX */

/**
 * A dialogue type designed to display a confirmation to the user.
 *
 * @module moodle-core-notification
 * @submodule moodle-core-notification-confirm
 */

/**
 * Extends core Dialogue to show the confirmation dialogue.
 *
 * @param {Object} config Object literal specifying the dialogue configuration properties.
 * @constructor
 * @class M.core.confirm
 * @extends M.core.dialogue
 */
function Confirm(config) {
    M.util.js_pending('M.core.confirm');
    window.console.log("The M.core.confirm YUI Module has been deprecated. Please replace with appropriate AMD code");

    require(['core/modal_factory', 'core/modal_events'], function(ModalFactory, ModalEvents) {
        var modalConfig = {
            type: ModalFactory.types.SAVE_CANCEL,
            buttons: {},
        };

        if (config.title) {
            modalConfig.title = config.title;
        }

        if (config.message) {
            modalConfig.body = config.message;
        }

        if (config.yesLabel) {
            modalConfig.buttons.save = config.yesLabel;
        }


        this.publish('complete');
        this.publish('complete-yes');
        this.publish('complete-no');

        return ModalFactory.create(modalConfig)
        .then(function(modal) {
            modal.getRoot().on(ModalEvents.save, function(e) {
                this.fire('complete', true);
                this.fire('complete-yes');
            }.bind(this));
            modal.getRoot().on(ModalEvents.cancel, function(e) {
                this.fire('complete', false);
                this.fire('complete-no');
            }.bind(this));

            return modal;
        }.bind(this))
        .then(function(modal) {
            modal.show();

            M.util.js_complete('M.core.confirm');
            return modal;
        });

    }.bind(this));
}

Y.augment(Confirm, Y.EventTarget);
M.core.confirm = Confirm;


}, '@VERSION@', {"requires": ["moodle-core-notification-dialogue"]});
