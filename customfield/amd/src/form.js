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
 * Custom Field interaction management for Moodle.
 *
 * @module     core_customfield/form
 * @package    core_customfield
 * @copyright  2018 Toni Barbera
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {call as fetchMany} from 'core/ajax';
import {
    get_string as getString,
    get_strings as getStrings,
} from 'core/str';
import InplaceEditable from 'core/inplace_editable';
import Notification from 'core/notification';
import Pending from 'core/pending';
import SortableList from 'core/sortable_list';
import Templates from 'core/templates';
import jQuery from 'jquery';

/**
 * Display confirmation dialogue
 *
 * @param {Number} id
 * @param {String} type
 * @param {String} component
 * @param {String} area
 * @param {Number} itemid
 */
const confirmDelete = (id, type, component, area, itemid) => {
    const pendingPromise = new Pending('core_customfield/form:confirmDelete');

    getStrings([
        {'key': 'confirm'},
        {'key': 'confirmdelete' + type, component: 'core_customfield'},
        {'key': 'yes'},
        {'key': 'no'},
    ])
    .then(strings => {
        return Notification.confirm(strings[0], strings[1], strings[2], strings[3], function() {
            const pendingDeletePromise = new Pending('core_customfield/form:confirmDelete');
            fetchMany([
                {
                    methodname: (type === 'field') ? 'core_customfield_delete_field' : 'core_customfield_delete_category',
                    args: {id},
                },
                {methodname: 'core_customfield_reload_template', args: {component, area, itemid}}
            ])[1]
            .then(response => Templates.render('core_customfield/list', response))
            .then((html, js) => Templates.replaceNode(jQuery('[data-region="list-page"]'), html, js))
            .then(pendingDeletePromise.resolve)
            .catch(Notification.exception);
        });
    })
    .then(pendingPromise.resolve)
    .catch(Notification.exception);
};


/**
 * Creates a new custom fields category with default name and updates the list
 *
 * @param {String} component
 * @param {String} area
 * @param {Number} itemid
 */
const createNewCategory = (component, area, itemid) => {
    const pendingPromise = new Pending('core_customfield/form:confirmDelete');
    const promises = fetchMany([
        {methodname: 'core_customfield_create_category', args: {component: component, area: area, itemid: itemid}},
        {methodname: 'core_customfield_reload_template', args: {component: component, area: area, itemid: itemid}}
    ]);

    promises[1].then(response => Templates.render('core_customfield/list', response))
    .then((html, js) => Templates.replaceNode(jQuery('[data-region="list-page"]'), html, js))
    .catch(Notification.exception);

    Promise.all(promises)
    .then(categoryId => {
        window.location.href = `#category-${categoryId}`;
        return pendingPromise.resolve();
    })
    .catch();
};

/**
 * Fetch the category name from an inplace editable, given a child node of that field.
 *
 * @param {NodeElement} nodeElement
 * @returns {String}
 */
const getCategoryNameFor = nodeElement => nodeElement
    .closest('[data-category-id]')
    .find('[data-inplaceeditable][data-itemtype=category][data-component=core_customfield]')
    .attr('data-value');

const setupSortableLists = rootNode => {
    // Sort category.
    const sortCat = new SortableList(
        '#customfield_catlist .categorieslist',
        {
            moveHandlerSelector: '.movecategory [data-drag-type=move]',
        }
    );
    sortCat.getElementName = nodeElement => Promise.resolve(getCategoryNameFor(nodeElement));

    // Note: The sortable list currently uses jQuery events.
    jQuery('[data-category-id]').on(SortableList.EVENTS.DROP, (evt, info) => {
        if (info.positionChanged) {
            var pendingPromise = new Pending('core_customfield/form:categoryid:on:sortablelist-drop');
            fetchMany([
                {
                    methodname: 'core_customfield_move_category',
                    args: {
                        id: info.element.data('category-id'),
                        beforeid: info.targetNextElement.data('category-id')
                    }

                },
            ])[0]
            .then(pendingPromise.resolve)
            .catch(Notification.exception);
        }
        evt.stopPropagation(); // Important for nested lists to prevent multiple targets.
    });

    // Sort fields.
    var sort = new SortableList(
        '#customfield_catlist .fieldslist tbody',
        {
            moveHandlerSelector: '.movefield [data-drag-type=move]',
        }
    );

    sort.getDestinationName = (parentElement, afterElement) => {
        if (!afterElement.length) {
            return getString('totopofcategory', 'customfield', getCategoryNameFor(parentElement));
        } else if (afterElement.attr('data-field-name')) {
            return getString('afterfield', 'customfield', afterElement.attr('data-field-name'));
        } else {
            return Promise.resolve('');
        }
    };

    jQuery('[data-field-name]').on(SortableList.EVENTS.DROP, (evt, info) => {
        evt.stopPropagation(); // Important for nested lists to prevent multiple targets.
        if (info.positionChanged) {
            const pendingPromise = new Pending('core_customfield/form:fieldname:on:sortablelist-drop');
            fetchMany([
                {
                    methodname: 'core_customfield_move_field',
                    args: {
                        id: info.element.data('field-id'),
                        beforeid: info.targetNextElement.data('field-id'),
                        categoryid: Number(info.targetList.closest('[data-category-id]').attr('data-category-id'))
                    },
                },
            ])[0]
            .then(pendingPromise.resolve)
            .catch(Notification.exception);
        }
    });

    jQuery('[data-field-name]').on(SortableList.EVENTS.DRAG, evt => {
        var pendingPromise = new Pending('core_customfield/form:fieldname:on:sortablelist-drag');

        evt.stopPropagation(); // Important for nested lists to prevent multiple targets.

        // Refreshing fields tables.
        Templates.render('core_customfield/nofields', {})
        .then(html => {
            rootNode.querySelectorAll('.categorieslist > *')
            .forEach(category => {
                const fields = category.querySelectorAll('.field:not(.sortable-list-is-dragged)');
                const noFields = category.querySelector('.nofields');

                if (!fields.length && !noFields) {
                    category.querySelector('tbody').innerHTML = html;
                } else if (fields.length && noFields) {
                    noFields.remove();
                }
            });
            return;
        })
        .then(pendingPromise.resolve)
        .catch(Notification.exception);
    });

    jQuery('[data-category-id], [data-field-name]').on(SortableList.EVENTS.DRAGSTART, (evt, info) => {
        setTimeout(() => {
            jQuery('.sortable-list-is-dragged').width(info.element.width());
        }, 501);
    });

};

/**
 * Initialise the custom fields manager.
 */
export const init = () => {
    const rootNode = document.querySelector('#customfield_catlist');

    const component = rootNode.dataset.component;
    const area = rootNode.dataset.area;
    const itemid = rootNode.dataset.itemid;

    rootNode.addEventListener('click', e => {
        const roleHolder = e.target.closest('[data-role]');
        if (!roleHolder) {
            return;
        }

        if (roleHolder.dataset.role === 'deletefield') {
            e.preventDefault();

            confirmDelete(roleHolder.dataset.id, 'field', component, area, itemid);
            return;
        }

        if (roleHolder.dataset.role === 'deletecategory') {
            e.preventDefault();

            confirmDelete(roleHolder.dataset.id, 'category', component, area, itemid);
            return;
        }

        if (roleHolder.dataset.role === 'addnewcategory') {
            e.preventDefault();
            createNewCategory(component, area, itemid);

            return;
        }

    });

    setupSortableLists(rootNode, component, area, itemid);
    InplaceEditable.init();
};
