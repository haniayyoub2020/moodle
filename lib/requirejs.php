<?php
$start = microtime(true);
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
 * This file is serving optimised JS for RequireJS.
 *
 * @package    core
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));

// Disable moodle specific debug messages and any errors in output,
// comment out when debugging or better look into error log!
define('NO_DEBUG_DISPLAY', true);
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));

// We need just the values from config.php and minlib.php.
define('ABORT_AFTER_CONFIG', true);
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));
require('../config.php'); // This stops immediately at the beginning of lib/setup.php.
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));
require_once("$CFG->dirroot/lib/jslib.php");
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));
require_once("$CFG->dirroot/lib/classes/requirejs.php");
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));

$slashargument = min_get_slash_argument();
if (!$slashargument) {
    // The above call to min_get_slash_argument should always work.
    die('Invalid request');
}
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));

$slashargument = ltrim($slashargument, '/');
if (substr_count($slashargument, '/') < 1) {
    header('HTTP/1.0 404 not found');
    die('Slash argument must contain both a revision and a file path');
}
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));
// Split into revision and module name.
list($rev, $file) = explode('/', $slashargument, 2);
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));
$rev  = min_clean_param($rev, 'INT');
$file = '/' . min_clean_param($file, 'SAFEPATH');
error_log(__FILE__ . ':' . __LINE__ . " " . ((microtime(true) - $start) * 1000));

// Only load js files from the js modules folder from the components.
$jsfiles = array();
list($unused, $component, $module) = explode('/', $file, 3);
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));

// No subdirs allowed - only flat module structure please.
if (strpos('/', $module) !== false) {
    die('Invalid module');
}

error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
// We are lazy loading a single file - so include the component/filename pair in the etag.
$etag = sha1($rev . '/' . $component . '/' . $module);
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));

// Use the caching only for meaningful revision numbers which prevents future cache poisoning.
$cachejs = false;
$candidate = "{$CFG->localcachedir}/requirejs/{$etag}";
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
if ($rev > 0 and $rev < (time() + 60 * 60)) {
    $cachejs = true;

error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
    if (file_exists($candidate)) {
        if (!empty($_SERVER['HTTP_IF_NONE_MATCH']) || !empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            // We do not actually need to verify the etag value because our files
            // never change in cache because we increment the rev parameter.
            js_send_unmodified(filemtime($candidate), $etag);
        }

        js_send_cached($candidate, $etag, 'requirejs.php');
        exit(0);
    }
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
}
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));

$jsfile = core_requirejs::get_amd_module($component, $module);
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
$js = file_get_contents($jsfile);
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
if ($js === false) {
    $message = "Failed to load content for {$component}/{$module}: {$jsfile}";
    error_log($message);
    $js = "/* {$message} */";
    js_send_uncached($js, 'requirejs.php');
    header('HTTP/1.0 404 not found');
    exit(1);
}
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));

// Remove source map link and replace it.
if (strpos($js, 'sourceMappingURL') !== false) {
    $js = preg_replace('~//# sourceMappingURL.*$~s', '', $js);
    $js = rtrim($js);
    $js .= "\n";
}

if (strpos($js, "define( [") !== false) {
    // If the JavaScript module has been defined without specifying a name then we'll
    // add the Moodle module name now.
    // This allows for legacy modules in plugins.
    $replace = 'define(\'' . $modulename . '\', ';
    $search = 'define(';
    // Replace only the first occurrence.
    $js = implode($replace, explode($search, $js, 2));
}

error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
$hash = sha1_file($jsfile);
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
$js .= "//# sourceMappingURL={$CFG->wwwroot}/lib/jssourcemap.php/{$hash}{$file}";

if ($cachejs) {
    js_write_cache_file_content($candidate, $js);
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
    // Verify nothing failed in cache file creation.
    clearstatcache();
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
    if (file_exists($candidate)) {
error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
        js_send_cached($candidate, $etag, 'requirejs.php');
        exit(0);
    }
}

error_log(__FILE__ . ':' . __LINE__ . " {$component}/{$module}" . ((microtime(true) - $start) * 1000));
js_send_uncached($js, 'requirejs.php');
