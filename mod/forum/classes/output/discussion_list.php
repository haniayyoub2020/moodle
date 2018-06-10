<?php
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
 * Forum discussion list templatable.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Templatable used to display the list of forum discussions.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class discussion_list implements \renderable, \templatable {

    /**
     * @var \mod_forum\instance The forum whose discussions are to be listed.
     */
    protected $forum;

    /**
     * @var int The current page number.
     */
    protected $pageno;

    /**
     * @var \moodle_url The URL of the current page.
     */
    protected $currenturl;

    /**
     * @var \mod_forum\discussion_list The current list of discussions
     */
    protected $discussionlist;

    /**
     * Create a new instance of the renderable.
     *
     * @param   \mod_forum\instance $forum
     */
    public function __construct(\mod_forum\instance $forum) {
        $this->forum = $forum;
    }

    /**
     * Set the current page number.
     *
     * @param   int     $pageno
     * @return  $this
     */
    public function set_current_page(int $pageno) : self {
        $this->pageno = $pageno;

        return $this;
    }

    /**
     * Set the URL of the current page.
     *
     * @param   \moodle_url
     * @return  $this
     */
    public function set_current_url(\moodle_url $url) : self {
        $this->currenturl = new \moodle_url($url);

        return $this;
    }

    /**
     * Set the discussion list for the current forum.
     *
     * @param   \mod_forum\discussion_list
     * @return  $this
     */
    public function set_discussion_list(\mod_forum\discussion_list $discussionlist) {
        $this->discussionlist = $discussionlist;

        return $this;
    }

    /**
     * Export all data required to generate the template.
     *
     * @param   \renderer_base  $renderer
     * @return  array
     */
    public function export_for_template(\renderer_base $renderer) {
        $this->discussionlist = $this->forum->get_discussions($this->pageno);

        return (object) [
            'notifications' => $this->get_page_notifications($renderer),

            // TODO Allow template instead of string var?
            // No... Difficult because the wording changes depending on the type of forum.
            'nodiscussionstring' => $this->forum->get_no_discussions_string(),
            'can_create_discussion' => $this->forum->can_create_discussion(),
            'create_discussion_link' => $this->forum->get_discussion_create_url(),
            'create_discussion_link_text' => $this->forum->get_create_discussion_string(),
            'can_see_discussions' => $this->forum->can_see_discussions(),

            // The activity is in a group mode.
            'has_any_group' => $this->forum->get_activity_groupmode() > 0,

            'can_track_reads' => $this->forum->can_track_reads(),
            'can_subscribe' => $this->forum->can_subscribe(),

            'has_any_discussions' => $this->discussionlist->has_any(),
            'discussions' => $this->get_discussion_list($renderer),
            'pageno' => $this->pageno,
            'more_pages' => $this->discussionlist->has_more_entries(),

            'prev_page_link' => $this->get_prev_page()->out(),
            'next_page_link' => $this->get_next_page()->out(),
        ];
    }

    /**
     * Prepare the page notifications for display.
     *
     * @param   \renderer_base  $renderer
     * @return  array
     */
    public function get_page_notifications(\renderer_base $renderer) : array {
        $notifications = [];

        if ($this->forum->is_throttled()) {
            $notification = new \core\output\notification(get_string('thisforumisthrottled', 'mod_forum', (object) [
                'blockafter' => $this->forum->get_forum_record()->blockafter,
                'blockperiod' => get_string('secondstotime' . $this->forum->get_forum_record()->blockperiod),
            ]));
            $notification->set_show_closebutton();
            $notifications[] = $notification->export_for_template($renderer);
        }

        foreach ($this->forum->get_discussion_list_notifications() as $notification) {
            $notifications[] = $notification->export_for_template($renderer);
        }

        return $notifications;
    }

    /**
     * Get the formatted list of discussions from the discussion list.
     *
     * @param   \renderer_base  $renderer The renderer used to format this information
     * @return  array
     */
    public function get_discussion_list(\renderer_base $renderer) : array {
        // TODO These should be in a renderable.
        $discussions = $this->discussionlist->get_discussions();

        $groups = $this->forum->get_all_groups();
        foreach ($discussions as $discussion) {
            $form = new discussion_subscription_toggle($this->forum, $discussion, false);
            $discussion->subscription_toggle_form = $form->export_for_template($renderer);

            if ($discussion->groupid > 0) {
                // TODO Move to a new templatable/renderable?
                // TODO Display something when there is no picture.
                if ($url = get_group_picture_url($groups[$discussion->groupid], $this->forum->get_course_id())) {
                    $discussion->group = (object) [
                        'picture' => $url->out(),
                    ];
                }
            }

            $discussion->author = $this->get_user_info($renderer, $discussion->author);
            $discussion->modifier = $this->get_user_info($renderer, $discussion->modifier);
        }

        return array_values($discussions);
    }

    /**
     * Get the URL for the next page.
     * Note: There may not be any extra page, but the URL is generated anyway.
     *
     * @return  \moodle_url
     */
    public function get_next_page() : \moodle_url {
        $next = new \moodle_url($this->currenturl);

        if ($curpage = $next->get_param('page')) {
            $next->param('page', ++$curpage);
        } else {
            $next->param('page', 1);
        }

        return $next;
    }

    /**
     * Get the URL for the previous page.
     *
     * @return  \moodle_url
     */
    public function get_prev_page() : \moodle_url {
        $prev = new \moodle_url($this->currenturl);

        if ($curpage = $prev->get_param('page')) {
            $prev->param('page', --$curpage);
        } else {
            $prev->param('page', 0);
        }

        return $prev;
    }

    /**
     * Get the information about this author.
     *
     * @param   \renderer_base  $renderer The renderer used to format this information.
     * @param   \stdClass       $user The user being formatted.
     * @return  array
     */
    public function get_user_info(\renderer_base $renderer, $user) : array {
        global $PAGE;

        $userpicture = new \user_picture($user);

        return [
            'fullname' => fullname($user),
            'profileimageurl' => $userpicture->get_url($PAGE),
            'profileurl' => $userpicture->get_url($PAGE),
        ];
    }
}
