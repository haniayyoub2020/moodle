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
 * This file is responsible for serving the one huge CSS of each theme.
 *
 * @package   core
 * @copyright 2009 Petr Skoda (skodak)  {@link http://skodak.org}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Disable moodle specific debug messages and any errors in output,
// comment out when debugging or better look into error log!
define('NO_DEBUG_DISPLAY', true);

define('ABORT_AFTER_CONFIG', true);
require('../config.php');
require_once($CFG->dirroot.'/lib/csslib.php');

if ($slashargument = min_get_slash_argument()) {
    $slashargument = ltrim($slashargument, '/');
    if (substr_count($slashargument, '/') < 2) {
        css_send_css_not_found();
    }

    if (strpos($slashargument, '_s/') === 0) {
        // Can't use SVG.
        $slashargument = substr($slashargument, 3);
        $usesvg = false;
    } else {
        $usesvg = true;
    }

    $chunk = null;
    if (preg_match('#/(chunk(\d+)(/|$))#', $slashargument, $matches)) {
        $chunk = (int)$matches[2];
        $slashargument = str_replace($matches[1], '', $slashargument);
    }

    list($themename, $rev, $type) = explode('/', $slashargument, 3);
    $themename = min_clean_param($themename, 'SAFEDIR');
    $rev       = min_clean_param($rev, 'INT');
    $type      = min_clean_param($type, 'SAFEDIR');

} else {
    $themename = min_optional_param('theme', 'standard', 'SAFEDIR');
    $rev       = min_optional_param('rev', 0, 'INT');
    $type      = min_optional_param('type', 'all', 'SAFEDIR');
    $chunk     = min_optional_param('chunk', null, 'INT');
    $usesvg    = (bool)min_optional_param('svg', '1', 'INT');
}

// Check that type fits into the expected values.
if ($type === 'editor') {
    // The editor CSS is never chunked.
    $chunk = null;
} else if ($type === 'all' || $type === 'all-rtl') {
    // We're fine.
} else if ($type === 'fallback' || $type === 'fallback-rtl') {
    // We're fine.
} else {
    css_send_css_not_found();
}

if (file_exists("$CFG->dirroot/theme/$themename/config.php")) {
    // The theme exists in standard location - ok.
} else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/$themename/config.php")) {
    // Alternative theme location contains this theme - ok.
} else {
    header('HTTP/1.0 404 not found');
    die('Theme was not found, sorry.');
}

$candidatedir = "$CFG->localcachedir/theme/$rev/$themename/css";
$etag = "$rev/$themename/$type";
$candidatesheet = "{$candidatedir}/{$type}";
if (!$usesvg) {
    // Add to the sheet name, one day we'll be able to just drop this.
    $candidatesheet .= "-nosvg";
    $etag .= '/nosvg';
}

if ($chunk !== null) {
    $etag .= "/chunk{$chunk}";
    $chunkedcandidatesheet = "{$candidatesheet}.{$chunk}.css";
    $candidatesheet = "{$candidatesheet}.css";
} else {
    $candidatesheet = $chunkedcandidatesheet = "{$candidatesheet}.css";
}
$etag = sha1($etag);

if (file_exists($chunkedcandidatesheet)) {
    if (!empty($_SERVER['HTTP_IF_NONE_MATCH']) || !empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        // We do not actually need to verify the etag value because our files
        // never change in cache because we increment the rev counter.
        css_send_unmodified(filemtime($chunkedcandidatesheet), $etag);
    }
    css_send_cached_css($chunkedcandidatesheet, $etag);
}

// Ok, now we need to start normal moodle script, we need to load all libs and $DB.
define('ABORT_AFTER_CONFIG_CANCEL', true);

define('NO_MOODLE_COOKIES', true); // Session not used here.
define('NO_UPGRADE_CHECK', true);  // Ignore upgrade check.

require("$CFG->dirroot/lib/setup.php");

$isrtl = strpos($type, '-rtl') !== false;
$theme = theme_config::load($themename);
$theme->force_svg_use($usesvg);
$theme->set_rtl_mode($isrtl);
$themerev = theme_get_revision();

if ($type === 'fallback' || $type === 'fallback-rtl') {
    if ($fallbacksheet = $theme->get_fallback_css_file($chunk)) {
        // The fallback is returned along with the Content-Length.
        // Do not end when the content is returned so that the new content can be written without causing the client to wait.
        $css = file_get_contents($fallbacksheet);
        header('Content-Length: ' . strlen($css));
        css_send_uncached_css($css, false);

        // Now that the fallback has been sent, generate the content.
        // Use a very low lock time because there's no point in waiting for the lock if another thread is generating it.
        if ($lock = theme_styles_get_lock($themename, 1)) {
            theme_styles_generate_and_store($theme, $themerev, $candidatedir);

            // Release the lock without printing the content.
            $lock->release();
        }

        // We must actively exit here because we prevented the die earlier.
        die;
    } else {
        // No valid fallback found - continue the script here as normal and generate the content.
        // Reset the $type to the target type and recalculate paths.
        $type = $isrtl ? 'all-rtl' : 'all';
        $rev = -1;
    }
}

$cache = true;
if ($themerev <= 0 or $themerev != $rev) {
    $rev = $themerev;
    $cache = false;

    $candidatedir = "$CFG->localcachedir/theme/$rev/$themename/css";
    $etag = "$rev/$themename/$type";
    $candidatesheet = "{$candidatedir}/{$type}";
    if (!$usesvg) {
        // Add to the sheet name, one day we'll be able to just drop this.
        $candidatesheet .= "-nosvg";
        $etag .= '/nosvg';
    }

    if ($chunk !== null) {
        $etag .= "/chunk{$chunk}";
        $chunkedcandidatesheet = "{$candidatesheet}.{$chunk}.css";
        $candidatesheet = "{$candidatesheet}.css";
    } else {
        $candidatesheet = $chunkedcandidatesheet = "{$candidatesheet}.css";
    }
    $etag = sha1($etag);
}

make_localcache_directory('theme', false);

if ($type === 'editor') {
    $csscontent = $theme->get_css_content_editor();
    css_store_css($theme, $candidatesheet, $csscontent, false);

} else {
    // Fetch a lock whilst the CSS is fetched as this can be slow and CPU intensive.
    // Each client should wait for one to finish the compilation before starting the compiler.
    $lock = theme_styles_get_lock($themename, rand(90, 120));

    if (file_exists($chunkedcandidatesheet)) {
        // The file was built while we waited for the lock, we release the lock and serve the file.
        if ($lock) {
            $lock->release();
        }

        if ($cache) {
            css_send_cached_css($chunkedcandidatesheet, $etag);
        } else {
            css_send_uncached_css(file_get_contents($chunkedcandidatesheet));
        }
    }

    // The lock is still held, and the sheet still does not exist.
    // Compile the CSS content.
    $candidatesheet = theme_styles_generate_and_store($theme, $rev, $candidatedir);

    if ($lock) {
        // Now that the CSS has been generated and/or stored, release the lock.
        // This will allow waiting clients to use the newly generated and stored CSS.
        $lock->release();
    }
}

if (!$cache) {
    // Do not pollute browser caches if invalid revision requested,
    // let's ignore legacy IE breakage here too.
    css_send_uncached_css(file_get_contents($candidatesheet));

} else if ($chunk !== null and file_exists($chunkedcandidatesheet)) {
    // Greetings stupid legacy IEs!
    css_send_cached_css($chunkedcandidatesheet, $etag);

} else {
    // Real browsers - this is the expected result!
    css_send_cached_css($candidatesheet, $etag);
}

/**
 * Get the lock for the theme build.
 *
 * @param   string  $themename The name of the theme
 * @param   int     $timeout The lock timeout
 * @return  lock|false The generated lock, or false if the fetch timed out
 */
function theme_styles_get_lock($themename, $timeout) {
    $lockfactory = \core\lock\lock_config::get_lock_factory('core_theme_get_css_content');
    return $lockfactory->get_lock($themename, $timeout);
}

/**
 * Generate the theme CSS and store it.
 *
 * @param   theme_config    $theme The theme to be generated
 * @param   int             $rev The theme revision
 * @param   string          $candidatedir The directory that it should be stored in
 * @return  string          The path that the primary (non-chunked) CSS was written to
 */
function theme_styles_generate_and_store($theme, $rev, $candidatedir) {
    global $CFG;

    // Generate the content first.
    if (!$csscontent = $theme->get_css_cached_content()) {
        $csscontent = $theme->get_css_content();
        $theme->set_css_content_cache($csscontent);
    }

    if ($theme->get_rtl_mode()) {
        $type = "all-rtl";
    } else {
        $type = "all";
    }

    // Determine the candidatesheet path.
    $candidatesheet = "{$candidatedir}/{$type}";
    if (!$theme->use_svg_icons()) {
        $candidatesheet .= '-nosvg';
    }
    $candidatesheet .= ".css";

    // Determine the chunking URL.
    // Note, this will be removed when support for IE9 is removed.
    $relroot = preg_replace('|^http.?://[^/]+|', '', $CFG->wwwroot);
    if (!empty(min_get_slash_argument())) {
        if ($theme->use_svg_icons()) {
            $chunkurl = "{$relroot}/theme/styles.php/{$theme->name}/{$rev}/$type";
        } else {
            $chunkurl = "{$relroot}/theme/styles.php/_s/{$theme->name}/{$rev}/$type";
        }
    } else {
        if ($theme->use_svg_icons()) {
            $chunkurl = "{$relroot}/theme/styles.php?theme={$theme->name}&rev={$rev}&type=$type";
        } else {
            $chunkurl = "{$relroot}/theme/styles.php?theme={$theme->name}&rev={$rev}&type=$type&svg=0";
        }
    }

    // Store the CSS.
    css_store_css($theme, $candidatesheet, $csscontent, true, $chunkurl);

    return $candidatesheet;
}
