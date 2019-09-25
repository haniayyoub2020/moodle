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
 * Send bulk message to the given user ids.
 *
 * @module     core_message/message_send_bulk
 * @copyright  2019 Shamim Rezaie <shamim@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import $ from 'jquery';
import * as Str from 'core/str';
import ModalFactory from 'core/modal_factory';
import Templates from 'core/templates';
import ModalEvents from 'core/modal_events';
import Ajax from 'core/ajax';
import Notification from 'core/notification';

/**
 * Show the send message popup.
 *
 * @method showModal
 * @param {int[]} users
 * @param {Function} callback A callback to apply after the form is closed.
 * @returns {Promise}
 */
export const showModal = (users, callback = null) => {
    if (users.length == 0) {
        // Nothing to do.
        return $.Deferred().resolve().promise();
    }
    let titlePromise = null;
    if (users.length == 1) {
        titlePromise = Str.get_string('sendbulkmessagesingle', 'core_message');
    } else {
        titlePromise = Str.get_string('sendbulkmessage', 'core_message', users.length);
    }

    return $.when(
        ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            body: Templates.render('core_user/send_bulk_message', {})
        }),
        titlePromise
    ).then(function(modal, title) {
        modal.setTitle(title);
        modal.setSaveButtonText(title);

        // We want to focus on the action select when the dialog is closed.
        modal.getRoot().on(ModalEvents.hidden, function() {
            if (callback) {
                callback();
            }
            modal.getRoot().remove();
        });

        modal.getRoot().on(ModalEvents.save, function() {
            let messageText = modal.getRoot().find('form textarea').val();
            sendMessage(messageText, users);
        });

        modal.show();

        return modal;
    });
};

/**
 * Send a message to these users.
 *
 * @method sendMessage
 * @param {String} messageText
 * @param {int[]} users
 * @returns {*}
 */
export const sendMessage = (messageText, users) => {
    let messages = [],
        i = 0;

    for (i = 0; i < users.length; i++) {
        messages.push({touserid: users[i], text: messageText});
    }

    return Ajax.call([{
        methodname: 'core_message_send_instant_messages',
        args: {messages: messages}
    }])[0].then(function(messageIds) {
        if (messageIds.length == 1) {
            return Str.get_string('sendbulkmessagesentsingle', 'core_message');
        } else {
            return Str.get_string('sendbulkmessagesent', 'core_message', messageIds.length);
        }
    }).then(function(msg) {
        Notification.addNotification({
            message: msg,
            type: "success"
        });
        return true;
    }).catch(Notification.exception);
};
