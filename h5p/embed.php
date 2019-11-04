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
 * Render H5P content from an H5P file.
 *
 * @package    core_h5p
 * @copyright  2019 Sara Arjona <sara@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../config.php');

// The login check is done inside the player when getting the file from the url param.

$url = required_param('url', PARAM_LOCALURL);

$config = new stdClass();
$config->frame = optional_param('frame', 0, PARAM_INT);
$config->export = optional_param('export', 0, PARAM_INT);
$config->embed = optional_param('embed', 0, PARAM_INT);
$config->copyright = optional_param('copyright', 0, PARAM_INT);

$PAGE->set_url(new \moodle_url('/h5p/embed.php', array('url' => $url)));

$package = \core_h5p\content_type::load_from_url($url);
$context = $package->get_context();

if ($context->contextlevel == CONTEXT_USER && $USER->id !== $context->instanceid) {
    // For the user context, only the owner can acces.
    throw new \moodle_exception('h5pprivatefile', 'core_h5p');
}

[$context, $course, $cm] = get_context_info_array($context->id);
if ($context->contextlevel == CONTEXT_MODULE) {
    // Require login to the course first (without login to the module).
    require_course_login($course, true, null, false, true);

    // Now check if module is available OR it is restricted but the intro is shown on the course page.
    $cminfo = \cm_info::create($cm);
    if (!$cminfo->uservisible) {
        if (!$cm->showdescription || !$cminfo->is_visible_on_course_page()) {
            // Module intro is not visible on the course page and module is not available, show access error.
            require_course_login($course, true, $cminfo, false, true);
        }
    }
}
// TODO MDL-67082

$messages = [];
if (!$package->is_deployed()) {
    // The package is not yet deployed.
    // Attempt to deploy it as the user who owns it.
    require_capability('moodle/h5p:deploy', $package->get_context(), $package->get_owner());
    try {
        $package->deploy();
    } catch (\Exception $e) {
        $messages[] = (object) [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ];
    }
}

// The package is deployed. Display it.
$h5pplayer = $package->get_player();
$messages = array_merge($messages, $h5pplayer->get_errors());

if (empty($messages)) {
    if (has_capability('moodle/h5p:setdisplayoptions', $package->get_context())) {
        $package->update_display_options($config);
    }

    // Configure page.
    $PAGE->set_context($h5pplayer->get_context());
    $PAGE->set_title($h5pplayer->get_title());
    $PAGE->set_heading($h5pplayer->get_title());

    // Embed specific page setup.
    $PAGE->add_body_class('h5p-embed');
    $PAGE->set_pagelayout('embedded');

    // Load the embed.js to allow communication with the parent window.
    $PAGE->requires->js(new moodle_url('/h5p/js/embed.js'));

    // Add H5P assets to the page.
    $h5pplayer->add_assets_to_page($PAGE, $OUTPUT);

    // Check if there is some error when adding assets to the page.
    $messages = $h5pplayer->get_errors();
    if (empty($messages)) {
        // Print page HTML.
        echo $OUTPUT->header();
        echo $h5pplayer->output($OUTPUT);
    }
} else {
    // If there is any error or exception when creating the player, it should be displayed.
    $PAGE->set_context(context_system::instance());
    $title = get_string('h5p', 'core_h5p');
    $PAGE->set_title($title);
    $PAGE->set_heading($title);

    $PAGE->add_body_class('h5p-embed');
    $PAGE->set_pagelayout('embedded');

    // Errors can't be printed yet, because some more errors might been added while preparing the output
}

if (!empty($messages)) {
    // Print all the errors.
    echo $OUTPUT->header();
    $messages->h5picon = new \moodle_url('/h5p/pix/icon.svg');
    echo $OUTPUT->render_from_template('core_h5p/h5perror', (object) [
        'error' => $messages,
    ]);
}

echo $OUTPUT->footer();
