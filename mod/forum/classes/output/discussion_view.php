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
 * Forum discussion templatable.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Templatable used to display a forum discussion.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @property boolean $viewfullnames Whether to override fullname()
 */
class discussion_view implements \renderable, \templatable {
    /**
     * @var \mod_forum\instance The forum whose discussion is to be printed.
     */
    protected $forum;

    /**
     * @var \stdClass The discussion to be printed.
     */
    protected $discussion;

    /**
     * @var \stdClass The top post to be shown.
     */
    protected $toppost;

    /**
     * Create a new instance of the forum_discussion renderable.
     *
     * @param   \mod_forum\instance $forum
     * @param   \stdClass           $discussion
     */
    public function __construct(\mod_forum\instance $forum, \stdClass $discussion) {
        $this->forum = $forum;
        $this->discussion = $discussion;
    }

    /**
     * Get the current displaymode.
     *
     * @return  int
     */
    protected function get_display_mode() : int {
        global $CFG;

        $displaymode = $this->forum->get_current_layout();

        $post = $this->get_top_post();
        if ($post->id != $this->discussion->firstpost) {
            // Not viewing the whole discussion.
            // If the current displaymode is flat, then switch to nested but do not update any preference.
            if ($displaymode == FORUM_MODE_FLATOLDEST || $displaymode == FORUM_MODE_FLATNEWEST) {
                $displaymode = FORUM_MODE_NESTED;
            }
        }

        return $displaymode;
    }

    /**
     * Set the top post to display.
     *
     * @param   \stdClass   $post
     * @return  $this
     */
    public function set_top_post(\stdClass $post) : self {
        $this->toppost = $post;

        return $this;
    }

    /**
     * Get the top post for this discussion.
     *
     * @return  \stdClass
     */
    protected function get_top_post() : \stdClass {
        if (null === $this->toppost) {
            // TODO: This should not be a part of the renderable.
            $this->toppost = forum_get_post_full($this->discussion->firstpost);
        }

        return $this->toppost;
    }

    /**
     * Export all data required to generate the template.
     *
     * @param   \renderer_base  $renderer
     * @return  array
     */
    public function export_for_template(\renderer_base $renderer) {
        $neighbours = forum_get_discussion_neighbours($this->forum->get_cm(), $this->discussion, $this->forum->get_forum_record());

        $discussionviewurl = $this->forum->get_discussion_view_url($this->discussion);

        $movetargets = $this->forum->get_move_discussion_targets($this->discussion);
        $moveselect = new \url_select(
            $movetargets,
            '',
            [
                $discussionviewurl->out() => get_string('movethisdiscussionto', 'forum'),
            ],
            'movetarget',
            get_string('move')
        );

        $return = [
            // The discussion.
            // TODO Change to renderable.
            'discussion' => $this->discussion,

            // URLs.
            'forum_view_url' => $this->forum->get_forum_view_url(),
            'discussion_view_url' => $discussionviewurl,

            // General information.
            'is_discussion_locked' => $this->forum->is_discussion_locked($this->discussion),
            'is_throttled' => $this->forum->is_throttled(),
            'can_see_posts_structure' => $this->forum->can_see_posts_structure($this->discussion),

            // Subscription handling.
            'can_subscribe' => $this->forum->can_subscribe(),
            'subscription_toggle_form' => (new discussion_subscription_toggle($this->forum, $this->discussion))->export_for_template($renderer),
            'pin_toggle_form' => (new discussion_pin_toggle($this->forum, $this->discussion))->export_for_template($renderer),

            // TODO Move to template
            'neighbour_links' => $renderer->neighbouring_discussion_navigation($neighbours['prev'], $neighbours['next']),

            // Portfolio handling
            'can_export_to_portfolio' => $this->forum->can_export_to_portfolio(),
            'portfolio_link' => $this->get_portfolio_button($renderer),

            // Display mode.
            'has_display_modes' => count($this->forum->get_layout_modes()),
            'display_mode_selector' => $this->get_display_mode_select($renderer),

            // Move forums.
            'has_available_move_destinations' => count($movetargets),
            'move_target_selector' => $moveselect->export_for_template($renderer),

            // Actual post content.
            //'posts' => $this->get_old_posts_in_discussion($renderer),
            'post_structure' => $this->get_posts_in_discussion($renderer),

            // TODO Decide how to handle displayig the Q&A Notification.
        ];

        return $return;
    }

    /**
     * Get the rendered HTML to export to a renderer.
     *
     * @param   \renderer_base  $renderer
     * @return  string
     */
    protected function get_portfolio_button(\renderer_base $renderer) : string {
        global $CFG;
        if (!$this->forum->can_export_to_portfolio()) {
            return '';
        }

        require_once($CFG->libdir.'/portfoliolib.php');

        $button = new \portfolio_add_button();
        $button->set_callback_options('forum_portfolio_caller', [
                'discussionid' => $this->discussion->id,
            ], 'mod_forum');

        return $button->to_html(PORTFOLIO_ADD_FULL_FORM, get_string('exportdiscussion', 'mod_forum'));
    }

    protected function get_old_posts_in_discussion(\renderer_base $renderer) : string {
        ob_start();
        forum_print_discussion(
            $this->forum->get_course(),
            $this->forum->get_cm()->get_course_module_record(),
            $this->forum->get_forum_record(),
            $this->discussion,
            $this->get_top_post(),
            $this->get_display_mode(),
            $this->forum->can_post_to_discussion($this->discussion, true),
            $this->forum->can_rate_posts()
        );
        return ob_get_clean();
    }

    /**
     * Get all posts in the discussion.
     *
     * @param   \renderer_base  $renderer
     * @return  array
     */
    protected function get_posts_in_discussion(\renderer_base $renderer) : array {
        // TODO Sorting.
        $discussionposts = $this->get_posts_in_structure();

        return $discussionposts->export_for_template($renderer);
    }

    /**
     * Get the full set of posts in their nested structure.
     * Note, the template may ignore this nesting.
     *
     * @return  discussion_post
     */
    public function get_posts_in_structure() : discussion_post {
        // Get all posts and authors.
        // This is a performance optimisation to save DB queries later.
        $posts = $this->forum->get_posts_in_discussion($this->discussion);
        $authors = $this->forum->get_users_in_posts($posts);

        // Get the root post.
        $post = $this->get_top_post();
        $author = $authors[$post->userid];
        $firstpost = new discussion_post($this->forum, $this->discussion, $post, $authors[$post->userid]);

        if ($this->forum->can_see_posts_structure($this->discussion)) {
            // Note: $posts is passed by reference.
            $this->get_post_children($posts, $authors, $post, $firstpost);
        }

        return $firstpost;
    }

    /**
     * Fetch the children of the specified post.
     *
     * @param   array           $posts A prefetched list of all posts records.
     * @param   \stdClass       $postobj The record for the parent post.
     * @param   discussion_post $post The renderable for the parent post.
     */
    protected function get_post_children(array &$posts, array $authors, \stdClass $postobj, discussion_post $post) {
        $children = array_filter($posts, function($child) use ($postobj) {
            return ($child->parent == $postobj->id);
        });

        foreach ($children as $childobj) {
            if (!$this->forum->can_see_posts_structure($this->discussion)) {
                // The structure of posts cannot be viewed.
                continue;
            }

            $author = $authors[$childobj->userid];
            $child = new discussion_post($this->forum, $this->discussion, $childobj, $author);
            $post->add_child($child);
            unset($posts[$postobj->id]);

            $this->get_post_children($posts, $authors, $childobj, $child);
        }
    }

    /**
     * Get the subscription toggle form.
     * TODO This should be converted to a renderer and template.
     *
     * @return  string
     */
    protected function get_subscription_toggle_form(\renderer_base $renderer) : string {
        if (!$this->forum->can_subscribe()) {
            return '';
        }

        $content = forum_get_discussion_subscription_icon($this->forum->get_forum_record(), $this->discussion->id, null, true);
        $content .=  forum_get_discussion_subscription_icon_preloaders();

        return $content;

    }

    /**
     * Get the single_select used to toggle the displaymode.
     *
     * @return  \stdClass
     */
    protected function get_display_mode_select(\renderer_base $renderer) : \stdClass {
        $displaymode = new \single_select(
            $this->forum->get_discussion_view_url($this->discussion),
            'mode',
            $this->forum->get_layout_modes(),
            $this->get_display_mode(),
            []
        );

        $displaymode->set_label(get_string('displaymode', 'forum'), [
            'class' => 'accesshide',
        ]);

        return $displaymode->export_for_template($renderer);
    }
}
