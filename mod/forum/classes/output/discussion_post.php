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
 * Forum discussion post collection templatable.
 *
 * @package    mod_forum
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\output;

defined('MOODLE_INTERNAL') || die();

/**
 * Templatable used to display a set of discussion posts.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class discussion_post implements \renderable, \templatable {

    use user_trait;

    /**
     * @var \mod_forum\instance
     */
    protected $forum;

    /**
     * @var \stdClass The discussion that this post is in.
     */
    protected $discussion;

    /**
     * @var \stdClass The post data.
     */
    protected $post;

    /**
     * @var \stdClass The detail of the author.
     */
    protected $author;

    /**
     * @var array The children of this post.
     */
    protected $children = [];

    /**
     * @var bool Whether post detail is visible.
     */
    protected $canseedetail = true;

    public function __construct(\mod_forum\instance $forum, \stdClass $discussion, \stdClass $post, \stdClass $author) {
        $this->forum = $forum;
        $this->discussion = $discussion;
        $this->post = $post;
        $this->author = $author;

        $this->canseedetail = $this->forum->can_see_post($post, $discussion);
    }

    /**
     * Add a single reply to this post.
     *
     * @param   self        $child
     * @return  $this
     */
    public function add_child(self $child) {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Add a set of replies to this post.
     *
     * @param   self[]      $children
     * @return  $this
     */
    public function add_children(array $children) {
        foreach ($children as $child) {
            $this->add_child($child);
        }

        return $this;
    }

    /**
     * Export all data required to generate the template.
     *
     * @param   \renderer_base  $renderer
     * @return  array
     */
    public function export_for_template(\renderer_base $renderer) {
        $children = [];
        // TODO Add sorting?
        foreach ($this->children as $child) {
            $children[] = $child->export_for_template($renderer);
        }


        $authorinfo = null;
        $commands = [];
        if ($this->canseedetail) {
            $commands = array_values($this->forum->get_post_actions($this->discussion, $this->post));
            $authorinfo = $this->get_user_info($renderer, $this->author);
        }

        return [
            'id'                            => $this->post->id,

            'subject'                       => $this->get_subject($renderer),
            'message'                       => $this->get_message_body($renderer),
            // TODO Replace.
            'attachments'                   => $this->get_attachment_html($renderer),
            'commands'                      => $commands,

            'can_see_post'                  => $this->canseedetail,
            'can_reply'                     => $this->forum->can_post_to_discussion($this->discussion),
            'author'                        => $authorinfo,
            'bynameondate'                  => $this->get_author_line($renderer),

            'haschildren'                   => !empty($children),
            'children'                      => $children,

            'firstpost'                     => $this->post->parent == 0,

            // TODO - determine if this is the last post.
            'lastpost'                      => false,

            // TODO.
            // groups
            'postdate'                      => $this->get_postdate(),
        ];
    }

    /**
     * Get the subject of the forum post.
     *
     * @param   \renderer_base  $renderer
     * @return  string
     */
    public function get_subject(\renderer_base $renderer) : string {
        if (!$this->canseedetail) {
            return new \lang_string('forumsubjecthidden', 'mod_forum');
        }

        return format_string($this->post->subject, true);
    }

    /**
     * Get the body of the forum post.
     *
     * @param   \renderer_base  $renderer
     * @return  string
     */
    public function get_message_body(\renderer_base $renderer) : string {
        if (!$this->canseedetail) {
            return new \lang_string('forumbodyhidden', 'mod_forum');
        }

        $message = file_rewrite_pluginfile_urls(
                $this->post->message,
                'pluginfile.php',
                $this->forum->get_context()->id,
                'mod_forum',
                'post',
                $this->post->id
            );

        return format_text($message, $this->post->messageformat, (object) [
                'para' => true,
                'context' => $this->forum->get_context(),
            ]);
    }

    /**
     * Get the attachment content of the forum post.
     *
     * @param   \renderer_base  $renderer
     * @return  string
     */
    public function get_attachment_html(\renderer_base $renderer) : string {
        if (!$this->canseedetail) {
            return '';
        }

        return forum_print_attachments($this->post, $this->forum->get_cm(), "html");
    }

    /**
     * Get the author description.
     *
     * @return  string
     */
    protected function get_author_line(\renderer_base $renderer) : string {
        if (!$this->canseedetail) {
            return new \lang_string('forumauthorhidden', 'mod_forum');
        }

        return get_string('bynameondate', 'forum', (object) [
            'date' => userdate_htmltime($this->get_postdate()),
            'name' => \html_writer::link(
                $this->forum->get_profile_url($this->author),
                $this->forum->fullname($this->author)
            ),
        ]);
    }

    /**
     * The date of the post.
     *
     * @return string.
     */
    public function get_postdate() {
        global $CFG;

        $postmodified = $this->post->modified;
        if (!empty($CFG->forum_enabletimedposts) && ($this->discussion->timestart > $postmodified)) {
            $postmodified = $this->discussion->timestart;
        }

        return $postmodified;
    }
}
