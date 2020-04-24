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
 * Some UI stuff for participants page.
 * This is also used by the report/participants/index.php because it has the same functionality.
 *
 * @module     core_user/participants
 * @package    core_user
 * @copyright  2017 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import * as DynamicTable from 'core_table/dynamic';
import * as Repository from './repository';
import * as Str from 'core/str';
import jQuery from 'jquery';
import CheckboxToggleAll from 'core/checkbox-toggleall';
import CustomEvents from 'core/custom_interaction_events';
import DynamicTableSelectors from 'core_table/local/dynamic/selectors';
import ModalEvents from 'core/modal_events';
import ModalFactory from 'core/modal_factory';
import Notification from 'core/notification';
import Templates from 'core/templates';
import {add as notifyUser} from 'core/toast';

const Selectors = {
    bulkActionSelect: "#formactionid",
    bulkUserSelectedCheckBoxes: "input[data-togglegroup='participants-table']:checked",
    checkCountButton: "#checkall",
    showCountText: '[data-region="participant-count"]',
    showCountToggle: '[data-action="showcount"]',
    stateHelpIcon: '[data-region="state-help-icon"]',
    tableForm: uniqueId => `form[data-table-unique-id="${uniqueId}"]`,
};

export const init = ({
    uniqueid,
    noteStateNames = {},
}) => {
    const root = document.querySelector(Selectors.tableForm(uniqueid));
    const getTableFromUniqueId = uniqueId => root.querySelector(DynamicTableSelectors.main.fromRegionId(uniqueId));

    /**
     * Private method.
     *
     * @method registerEventListeners
     * @private
     */
    const registerEventListeners = () => {
        CustomEvents.define(Selectors.bulkActionSelect, [CustomEvents.events.accessibleChange]);
        jQuery(Selectors.bulkActionSelect).on(CustomEvents.events.accessibleChange, e => {
            const action = e.target.value;
            const tableRoot = getTableFromUniqueId(uniqueid);
            const checkboxes = tableRoot.querySelectorAll(Selectors.bulkUserSelectedCheckBoxes);

            if (action.indexOf('#') !== -1) {
                e.preventDefault();

                const ids = [];
                checkboxes.forEach(checkbox => {
                    ids.push(checkbox.getAttribute('name').replace('user', ''));
                });

                if (action === '#messageselect') {
                    showSendMessage(ids).catch(Notification.exception);
                } else if (action === '#addgroupnote') {
                    showAddNote(ids).catch(Notification.exception);
                }
            } else if (action !== '' && checkboxes.length) {
                e.target.form().submit();
            }

            resetBulkAction(e.target);
        });

        root.addEventListener('click', e => {
            // Handle clicking of the "Show [all|count]" and "Select all" actions.
            const showCountLink = root.querySelector(Selectors.showCountToggle);
            const checkCountButton = root.querySelector(Selectors.checkCountButton);

            const showCountLinkClicked = showCountLink && showCountLink.contains(e.target);
            const checkCountButtonClicked = checkCountButton && checkCountButton.contains(e.target);

            if (showCountLinkClicked || checkCountButtonClicked) {
                e.preventDefault();

                const tableRoot = getTableFromUniqueId(uniqueid);

                DynamicTable.setPageSize(tableRoot, showCountLink.dataset.targetPageSize)
                .then(tableRoot => {
                    // Always update the toggle state.
                    // This ensures that the bulk actions are disabled after changing the page size.
                    CheckboxToggleAll.setGroupState(tableRoot, 'participants-table', checkCountButtonClicked);

                    return tableRoot;
                })
                .catch(Notification.exception);
            }
        });

        // When the content is refreshed, update the row counts in various places.
        root.addEventListener(DynamicTable.Events.tableContentRefreshed, e => {
            const showCountLink = root.querySelector(Selectors.showCountToggle);
            const checkCountButton = root.querySelector(Selectors.checkCountButton);

            const tableRoot = e.target;

            const defaultPageSize = parseInt(root.dataset.tableDefaultPerPage, 10);
            const currentPageSize = parseInt(tableRoot.dataset.tablePageSize, 10);
            const totalRowCount = parseInt(tableRoot.dataset.tableTotalRows, 10);

            CheckboxToggleAll.updateSlavesFromMasterState(tableRoot, 'participants-table');

            const pageCountStrings = [
                {
                    key: 'countparticipantsfound',
                    component: 'core_user',
                    param: totalRowCount,
                },
            ];


            if (totalRowCount <= defaultPageSize) {
                // There are fewer than the default page count numbers of rows.
                showCountLink.classList.add('hidden');
                checkCountButton.classList.add('hidden');
            } else if (totalRowCount <= currentPageSize) {
                // The are fewer than the current page size.
                pageCountStrings.push({
                    key: 'showperpage',
                    component: 'core',
                    param: defaultPageSize,
                });

                pageCountStrings.push({
                    key: 'selectalluserswithcount',
                    component: 'core',
                    param: defaultPageSize,
                });

                // Show the 'Show [x]' link.
                showCountLink.classList.remove('hidden');
                showCountLink.dataset.targetPageSize = defaultPageSize;

                // The 'Check all [x]' button is only visible when there are values to set.
                checkCountButton.classList.add('hidden');
            } else {
                pageCountStrings.push({
                    key: 'showall',
                    component: 'core',
                    param: totalRowCount,
                });

                pageCountStrings.push({
                    key: 'selectalluserswithcount',
                    component: 'core',
                    param: totalRowCount,
                });

                // Show both the 'Show [x]' link, and the 'Check all [x]' button.
                showCountLink.classList.remove('hidden');
                showCountLink.dataset.targetPageSize = totalRowCount;
                checkCountButton.classList.remove('hidden');
            }

            Str.get_strings(pageCountStrings)
            .then(([showingParticipantCountString, showCountString, selectCountString]) => {
                const showingParticipantCount = root.querySelector(Selectors.showCountText);
                showingParticipantCount.innerHTML = showingParticipantCountString;

                if (showCountString) {
                    showCountLink.innerHTML = showCountString;
                }

                if (selectCountString) {
                    checkCountButton.value = selectCountString;
                }

                return;
            })
            .catch(Notification.exception);
        });
    };

    const resetBulkAction = bulkActionSelect => {
        bulkActionSelect.value = '';
    };

    /**
     * Show the add note popup
     *
     * @param {int[]} users
     * @return {Promise}
     */
    const showAddNote = users => {
        if (!users.length) {
            // No users were selected.
            return Promise.resolve();
        }

        const states = [];
        for (let key in noteStateNames) {
            switch (key) {
                case 'draft':
                    states.push({value: 'personal', label: noteStateNames[key]});
                    break;
                case 'public':
                    states.push({value: 'course', label: noteStateNames[key], selected: 1});
                    break;
                case 'site':
                    states.push({value: key, label: noteStateNames[key]});
                    break;
            }
        }

        const context = {
            stateNames: states,
            stateHelpIcon: root.querySelector(Selectors.stateHelpIcon).innerHTML,
        };

        let titlePromise = null;
        if (users.length === 1) {
            titlePromise = Str.get_string('addbulknotesingle', 'core_notes');
        } else {
            titlePromise = Str.get_string('addbulknote', 'core_notes', users.length);
        }

        return ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            body: Templates.render('core_user/add_bulk_note', context),
            title: titlePromise,
            buttons: {
                save: titlePromise,
            },
        })
        .then(modal => {
            modal.getRoot().on(ModalEvents.hidden, () => {
                // Focus on the action select when the dialog is closed.
                const bulkActionSelector = root.querySelector(Selectors.bulkActionSelect);
                resetBulkAction(bulkActionSelector);
                bulkActionSelector.focus();
            });

            modal.getRoot().on(ModalEvents.save, () => {
                submitAddNote(modal, users);
            });

            modal.show();

            return modal;
        });
    };

    /**
     * Add a note to this list of users.
     *
     * @param {Modal} modal
     * @param {Number[]} users
     * @return {Promise}
     */
    const submitAddNote = (modal, users) => {
        const text = modal.getRoot().find('form textarea').val();
        const publishstate = modal.getRoot().find('form select').val();

        const notes = users.map(userid => {
            return {
                userid,
                text,
                courseid: root.dataset.courseId,
                publishstate,
            };
        });

        return Repository.createNotesForUsers(notes)
        .then(noteIds => {
            if (noteIds.length === 1) {
                return Str.get_string('addbulknotedonesingle', 'core_notes');
            } else {
                return Str.get_string('addbulknotedone', 'core_notes', noteIds.length);
            }
        })
        .then(msg => notifyUser(msg))
        .catch(Notification.exception);
    };

    /**
     * Show the send message popup.
     *
     * @param {Number[]} users
     * @return {Promise}
     */
    const showSendMessage = users => {
        if (!users.length) {
            // Nothing to do.
            return Promise.resolve();
        }

        let titlePromise;
        if (users.length === 1) {
            titlePromise = Str.get_string('sendbulkmessagesingle', 'core_message');
        } else {
            titlePromise = Str.get_string('sendbulkmessage', 'core_message', users.length);
        }

        return ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            body: Templates.render('core_user/send_bulk_message', {}),
            title: titlePromise,
            buttons: {
                save: titlePromise,
            },
        })
        .then(modal => {
            modal.getRoot().on(ModalEvents.hidden, () => {
                // Focus on the action select when the dialog is closed.
                const bulkActionSelector = root.querySelector(Selectors.bulkActionSelect);
                resetBulkAction(bulkActionSelector);
                bulkActionSelector.focus();
            });

            modal.getRoot().on(ModalEvents.save, () => {
                submitSendMessage(modal, users);
            });

            modal.show();

            return modal;
        });
    };

    /**
     * Send a message to these users.
     *
     * @param {Modal} modal
     * @param {Number[]} users
     * @return {Promise}
     */
    const submitSendMessage = (modal, users) => {
        const text = modal.getRoot().find('form textarea').val();

        const messages = users.map(touserid => {
            return {
                touserid,
                text,
            };
        });

        return Repository.sendMessagesToUsers(messages)
        .then(messageIds => {
            if (messageIds.length == 1) {
                return Str.get_string('sendbulkmessagesentsingle', 'core_message');
            } else {
                return Str.get_string('sendbulkmessagesent', 'core_message', messageIds.length);
            }
        })
        .then(msg => notifyUser(msg))
        .catch(Notification.exception);
    };

    registerEventListeners();
};
