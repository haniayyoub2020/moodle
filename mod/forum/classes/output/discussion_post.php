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
 *
 * @property boolean $viewfullnames Whether to override fullname()
 */
class discussion_post implements \renderable, \templatable {

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

    public function __construct(\mod_forum\instance $forum, \stdClass $discussion, \stdClass $post, \stdClass $author) {
        $this->forum = $forum;
        $this->discussion = $discussion;
        $this->post = $post;
        $this->author = $author;
    }

    public function add_child($child) {
        $this->children[] = $child;

        return $this;
    }

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

        return [
            'id'                            => $this->post->id,

            'subject'                       => $this->get_subject($renderer),
            'message'                       => $this->get_message_body($renderer),
            // TODO Replace.
            'attachments'                   => $this->get_attachment_html($renderer),
            'commands'                      => $this->get_commands($renderer),

            'can_see_post'                  => $this->forum->can_see_post($this->post, $this->discussion),
            'can_reply'                     => $this->forum->can_post_to_discussion($this->discussion),
            'author'                        => $this->get_author($renderer),
            'bynameondate'                  => $this->get_author_line($renderer),

            'haschildren'                   => !empty($children),
            'children'                      => $children,

            // TODO.
            // author
            // groups
            // post date
            'postdate'                      => $this->get_postdate(),
            // permalink
            // edit
            // delete
            // reply
            // split
            // show parent?? (or can we use {{../post.id}}
            // isread
            // canedit
            // candelete
            // cansplit
        ];

        $foo = [
            'coursename'                    => $this->get_coursename(),
            'courselink'                    => $this->get_courselink(),
            'forumname'                     => $this->get_forumname(),
            'showdiscussionname'            => $this->get_showdiscussionname(),
            'discussionname'                => $this->get_discussionname(),
            'subject'                       => $this->get_subject(),
            'authorfullname'                => $this->get_author_fullname(),
            'postdate'                      => $this->get_postdate(),

            // Format some components according to the renderer.
            'message'                       => $renderer->format_message_text($this->cm, $this->post),
            'attachments'                   => $renderer->format_message_attachments($this->cm, $this->post),

            'canreply'                      => $this->canreply,
            'permalink'                     => $this->get_permalink(),
            'firstpost'                     => $this->get_is_firstpost(),
            'replylink'                     => $this->get_replylink(),
            'unsubscribediscussionlink'     => $this->get_unsubscribediscussionlink(),
            'unsubscribeforumlink'          => $this->get_unsubscribeforumlink(),
            'parentpostlink'                => $this->get_parentpostlink(),

            'forumindexlink'                => $this->get_forumindexlink(),
            'forumviewlink'                 => $this->get_forumviewlink(),
            'discussionlink'                => $this->get_discussionlink(),

            'authorlink'                    => $this->get_authorlink(),
            'authorpicture'                 => $this->get_author_picture(),

            'grouppicture'                  => $this->get_group_picture(),

        ];
    }

    /**
     * Get the subject of the forum post.
     *
     * @param   \renderer_base  $renderer
     * @return  string
     */
    public function get_subject(\renderer_base $renderer) : string {
        return format_string($this->post->subject, true);
    }

    /**
     * Get the body of the forum post.
     *
     * @param   \renderer_base  $renderer
     * @return  string
     */
    public function get_message_body(\renderer_base $renderer) : string {
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
        return forum_print_attachments($this->post, $this->forum->get_cm(), "html");
    }

    public function get_author(\renderer_base $renderer) : array {
        global $PAGE;

        $userpicture = new \user_picture($this->author);
        return [
            'fullname' => fullname($this->author),
            'profileimageurl' => $userpicture->get_url($PAGE),
            'profileurl' => $userpicture->get_url($PAGE),
        ];
    }

    protected function get_author_line(\renderer_base $renderer) : string {
        return get_string('bynameondate', 'forum', (object) [
            'date' => userdate_htmltime($this->get_postdate()),
            'name' => \html_writer::link($this->author->profilelink, fullname($this->author)),
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

    public function get_commands(\renderer_base $renderer) : array {
        return [];
    }
}
