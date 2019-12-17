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
 * Module to enable inline editing of a comptency grade.
 *
 * @package    report_competency
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/notification', 'core/str', 'core/ajax', 'core/log', 'core/templates', 'tool_lp/dialogue', 'core/pending'],
       function($, notification, str, ajax, log, templates, Dialogue, Pending) {

    /**
     * GradingPopup
     *
     * @param {String} regionSelector The regionSelector
     * @param {String} userCompetencySelector The userCompetencySelector
     */
    var GradingPopup = function(regionSelector, userCompetencySelector) {
        this._regionSelector = regionSelector;
        this._userCompetencySelector = userCompetencySelector;

        $(this._regionSelector).on('click', this._userCompetencySelector, this._handleClick.bind(this));
    };

    /**
     * Get the data from the clicked cell and open the popup.
     *
     * @method _handleClick
     * @param {Event} e The event
     */
    GradingPopup.prototype._handleClick = function(e) {
        var pendingPromise = new Pending('report_competency/grading_popup:_handleClick');

        var cell = $(e.target).closest(this._userCompetencySelector);
        var competencyId = $(cell).data('competencyid');
        var courseId = $(cell).data('courseid');
        var userId = $(cell).data('userid');

        log.debug('Clicked on cell: competencyId=' + competencyId + ', courseId=' + courseId + ', userId=' + userId);

        var requests = ajax.call([
            {
                methodname: 'tool_lp_data_for_user_competency_summary_in_course',
                args: {userid: userId, competencyid: competencyId, courseid: courseId},
            },
            {
                methodname: 'core_competency_user_competency_viewed_in_course',
                args: {userid: userId, competencyid: competencyId, courseid: courseId},
            }
        ]);

        $.when(requests[0], requests[1])
        .then(this._contextLoaded.bind(this))
        .always(pendingPromise.resolve)
        .catch(notification.exception);
    };

    /**
     * We loaded the context, now render the template.
     *
     * @method _contextLoaded
     * @param {Object} context
     */
    GradingPopup.prototype._contextLoaded = function(context) {
        var pendingPromise = new Pending('report_competency/grading_popup:_contextLoaded');

        // We have to display user info in popup.
        context.displayuser = true;
        $.when(
            templates.render('tool_lp/user_competency_summary_in_course', context),
            str.get_string('usercompetencysummary', 'report_competency')
        )
        .then(function(htmljs, title) {
            return new Dialogue(
                title,
                htmljs[0],
                templates.runTemplateJS.bind(templates, htmljs[1]),
                this._refresh.bind(this),
                true
            );
        }.bind(this))
        .always(pendingPromise.resolve)
        .catch(notification.exception);
    };

    /**
     * Refresh the page.
     *
     * @method _refresh
     */
    GradingPopup.prototype._refresh = function() {
        var pendingPromise = new Pending('report_competency/grading_popup:_refresh');

        var region = $(this._regionSelector);
        var courseId = region.data('courseid');
        var moduleId = region.data('moduleid');
        var userId = region.data('userid');

        // The module id is expected to be an integer, so don't pass empty string.
        if (moduleId === '') {
            moduleId = 0;
        }

        ajax.call([{
            methodname: 'report_competency_data_for_report',
            args: {
                courseid: courseId,
                userid: userId,
                moduleid: moduleId,
            },
        }])[0]
        .then(this._pageContextLoaded.bind(this))
        .always(pendingPromise.resolve)
        .catch(notification.exception);
    };

    /**
     * We loaded the context, now render the template.
     *
     * @method _pageContextLoaded
     * @param {Object} context
     */
    GradingPopup.prototype._pageContextLoaded = function(context) {
        var pendingPromise = new Pending('report_competency/grading_popup:_pageContextLoaded');

        templates.render('report_competency/report', context)
        .then(function(html, js) {
            templates.replaceNode(this._regionSelector, html, js);

            return;
        }.bind(this))
        .always(pendingPromise.resolve)
        .catch(notification.exception);
    };

    /** @type {String} The selector for the region with the user competencies */
    GradingPopup.prototype._regionSelector = null;
    /** @type {String} The selector for the region with a single user competencies */
    GradingPopup.prototype._userCompetencySelector = null;

    return /** @alias module:report_competency/grading_popup */ GradingPopup;

});
