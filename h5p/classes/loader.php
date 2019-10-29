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
 * H5P factory class.
 * This class is used to decouple the construction of H5P related objects.
 *
 * @package    core_h5p
 * @copyright  2019 Mihail Geshoski <mihail@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_h5p;

defined('MOODLE_INTERNAL') || die();

use context;
use stdClass;
use stored_file;
use moodle_url;
use \H5PStorage as storage;
use \H5PValidator as validator;
use \H5PContentValidator as content_validator;

/**
 * H5P player class.
 *
 * @package    core_h5p
 * @copyright  2019 Mihail Geshoski <mihail@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class loader {

    /**
     * Inits the H5P player for rendering the content.
     *
     * @param string $url Local URL of the H5P file to display.
     * @param stdClass $buttonconfig Configuration for H5P buttons.
     */
    public static function get_player(string $url, stdClass $buttonconfig) {
        if (empty($url)) {
            throw new \moodle_exception('h5pinvalidurl', 'core_h5p');
        }
        $url = new \moodle_url($url);

        // Get the H5P identifier linked to this URL.
        $file = self::get_h5p_storedfile($url);
        if (!$file) {
            throw new \moodle_exception(get_string('h5pfilenotfound', 'core_h5p'));
        }

        $context = \context::instance_by_id($file->get_contextid());

        $h5p = self::get_h5p_config_for_stored_file($file);
        if ($h5p && $h5p->contenthash != $file->get_contenthash()) {
            // The content exists and it is different from the one deployed previously. The existing one should be removed before
            // deploying the new version.
            // TODO
            self::delete_h5p($h5p);
            $h5p = null;
        }

        if (!$h5p) {
            // The H5P content hasn't been deployed previously.
            self::deploy_h5p($file);
            $h5p = self::get_h5p_config_for_stored_file($file);
        }

        if (!$h5p) {
            throw new \moodle_exception(get_string('invalidh5p', 'core_h5p'));
        }

        // Load the content for a pre-existing file.
        $factory = self::get_factory_for_stored_file($file);

        $context = \context::instance_by_id($file->get_contextid());
        return $factory->get_player($factory, $context, $file, $url, $h5p, $buttonconfig);
    }

    protected static function deploy_h5p(stored_file $file) {
        // Check if the user uploading the H5P content is "trustable". If the file hasn't been uploaded by a user with this
        // capability, the content won't be deployed and an error message will be displayed.
        $context = \context::instance_by_id($file->get_contextid());
        if (!has_capability('moodle/h5p:deploy', $context, $file->get_userid())) {
            throw new \moodle_exception(get_string('nopermissiontodeploy', 'core_h5p'));
        }

        // Validate and store the H5P content before displaying it.
        if (!self::save_h5p($file)) {
            throw new \moodle_exception('Unable to save h5p');
        }
    }

    /**
     * Get the H5P DB instance id for a H5P pluginfile URL. The H5P file will be saved if it doesn't exist previously or
     * if its content has changed. Besides, the displayoptions in the $config will be also updated when they have changed and
     * the user has the right permissions.
     *
     * @param string $url H5P pluginfile URL.
     * @param stdClass $config Configuration for H5P buttons.
     * @return int|null H5P DB identifier.
     */
    protected static function get_h5p_storedfile(string $url): ?stored_file {
        global $DB;

        $fs = get_file_storage();

        // Deconstruct the URL and get the pathname associated.
        $pathnamehash = self::get_pluginfile_hash($url);
        if (!$pathnamehash) {
            throw new \moodle_exception(get_string('h5pfilenotfound', 'core_h5p'));
        }

        // Get the file.
        $file = $fs->get_file_by_hash($pathnamehash);
        if (!$file) {
            return null;
        }

        return $file;
    }

    public static function get_h5p_config_for_stored_file(stored_file $file): ?stdClass {
        global $DB;

        if ($h5p = $DB->get_record('h5p', ['pathnamehash' => $file->get_pathnamehash()])) {
            return $h5p;
        }

        return null;
    }

    /**
     * Get the pathnamehash from an H5P internal URL.
     *
     * @param  string $url H5P pluginfile URL poiting to an H5P file.
     *
     * @return string|false pathnamehash for the file in the internal URL.
     */
    protected static function get_pluginfile_hash(string $url) {
        global $USER;

        // Decode the URL before start processing it.
        $url = new \moodle_url(urldecode($url));

        // Remove params from the URL (such as the 'forcedownload=1'), to avoid errors.
        $url->remove_params(array_keys($url->params()));
        $path = $url->out_as_local_url();

        $parts = explode('/', $path);
        $filename = array_pop($parts);
        // First is an empty row and then the pluginfile.php part. Both can be ignored.
        array_shift($parts);
        array_shift($parts);

        // Get the contextid, component and filearea.
        $contextid = array_shift($parts);
        $component = array_shift($parts);
        $filearea = array_shift($parts);

        // Ignore draft files, because they are considered temporary files, so shouldn't be displayed.
        if ($filearea == 'draft') {
            return false;
        }

        // Get the context.
        try {
            list($context, $course, $cm) = get_context_info_array($contextid);
        } catch (\moodle_exception $e) {
            throw new \moodle_exception('invalidcontextid', 'core_h5p');
        }

        // For CONTEXT_USER, such as the private files, raise an exception if the owner of the file is not the current user.
        if ($context->contextlevel == CONTEXT_USER && $USER->id !== $context->instanceid) {
            throw new \moodle_exception('h5pprivatefile', 'core_h5p');
        }

        // For CONTEXT_MODULE, check if the user is enrolled in the course and has permissions view this .h5p file.
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

        // Some components, such as mod_page or mod_resource, add the revision to the URL to prevent caching problems.
        // So the URL contains this revision number as itemid but a 0 is always stored in the files table.
        // In order to get the proper hash, a callback should be done (looking for those exceptions).
        $pathdata = component_callback($component, 'get_path_from_pluginfile', [$filearea, $parts], null);
        if (null === $pathdata) {
            // Look for the components and fileareas which have empty itemid defined in xxx_pluginfile.
            $hasnullitemid = false;
            $hasnullitemid = $hasnullitemid || ($component === 'user' && ($filearea === 'private' || $filearea === 'profile'));
            $hasnullitemid = $hasnullitemid || ($component === 'mod' && $filearea === 'intro');
            $hasnullitemid = $hasnullitemid || ($component === 'course' &&
                    ($filearea === 'summary' || $filearea === 'overviewfiles'));
            $hasnullitemid = $hasnullitemid || ($component === 'coursecat' && $filearea === 'description');
            $hasnullitemid = $hasnullitemid || ($component === 'backup' &&
                    ($filearea === 'course' || $filearea === 'activity' || $filearea === 'automated'));
            if ($hasnullitemid) {
                $itemid = 0;
            } else {
                $itemid = array_shift($parts);
            }

            if (empty($parts)) {
                $filepath = '/';
            } else {
                $filepath = '/' . implode('/', $parts) . '/';
            }
        } else {
            // The itemid and filepath have been returned by the component callback.
            [
                'itemid' => $itemid,
                'filepath' => $filepath,
            ] = $pathdata;
        }

        $fs = get_file_storage();
        return $fs->get_pathname_hash($contextid, $component, $filearea, $itemid, $filepath, $filename);
    }

    protected static function get_core_version_from_storedfile(stored_file $file): ?string {
        // Copy the H5P file to disk for examination.
        $h5pfile = make_request_directory() . "/h5p.h5p";
        // Copy the .h5p file to the temporary folder.
        $file->copy_content_to($h5pfile);

        // Extract the h5p.json from it.
        $za = new \ZipArchive();
        if (!$za->open($h5pfile)) {
            throw new \moodle_exception('Unable to examine the provided H5P file');
        }

        if (!$fileinfo = $za->statName('h5p.json')) {
            $za->close();
            throw new \moodle_exception('Unable to examine the provided H5P file. Missing configuration.');
        }

        if (!$fp = $za->getStream('h5p.json')) {
            $za->close();
            throw new \moodle_exception('Unable to examine the provided H5P file. Unable to extract h5p configuration.');
        }

        $h5pconfig = '';
        while (!feof($fp)) {
            $h5pconfig .= fread($fp, 1024);
        }

        if (!$config = json_decode($h5pconfig, true)) {
            $za->close();
            throw new \moodle_exception('Unable to examine the provided H5P file. H5P Configuration is corrupt.');
        }

        $mainlibraryconfigpath = self::get_main_library_from_config($config) . "/library.json";
        if (!$fileinfo = $za->statName($mainlibraryconfigpath)) {
            $za->close();
            throw new \moodle_exception('Unable to examine the provided H5P file. Missing configuration for main library.');
        }

        if (!$fp = $za->getStream($mainlibraryconfigpath)) {
            $za->close();
            throw new \moodle_exception('Unable to examine the provided H5P file. Unable to extract h5p configuration for main library.');
        }

        $libraryconfigjson = '';
        while (!feof($fp)) {
            $libraryconfigjson .= fread($fp, 1024);
        }
        $za->close();

        if (!$libraryconfig = json_decode($libraryconfigjson, true)) {
            throw new \moodle_exception('Unable to examine the provided H5P file. H5P library Configuration is corrupt.');
        }

        if (isset($library['coreAPI'])) {
            return "{$library['coreAPI']['majorVersion']}.{$library['coreAPI']['minorVersion']}";
        }

        return null;

        return $config;
    }

    protected static function get_factory_for_stored_file(stored_file $file): factory {
        $version = self::get_core_version_from_storedfile($file);

        if (empty($version) || !container::version_exists($version)) {
            $version = container::get_latest_version();
        }

        return \core_h5p\container::get_factory($version);
    }

    /**
     * Store an H5P file
     *
     * @param stored_file $file Moodle file instance
     * @param stdClass $config Button options config.
     *
     * @return int|false The H5P identifier or false if it's not a valid H5P package.
     */
    protected static function save_h5p(stored_file $file): int {
        // This may take a long time.
        \core_php_time_limit::raise();

        $factory = self::get_factory_for_stored_file($file);

        // Create \core_h5p\core instance.
        $core = $factory->get_core();

        $path = $core->fs->getTmpPath();
        $core->h5pF->getUploadedH5pFolderPath($path);
        // Add manually the extension to the file to avoid the validation fails.
        $path .= '.h5p';
        $core->h5pF->getUploadedH5pPath($path);

        // Copy the .h5p file to the temporary folder.
        $file->copy_content_to($path);

        // Check if the h5p file is valid before saving it.
        $h5pvalidator = $factory->get_validator();
        if ($h5pvalidator->isValidPackage(false, false)) {
            $h5pstorage = $factory->get_storage();

            $options = [];
            $content = [
                'pathnamehash' => $file->get_pathnamehash(),
                'contenthash' => $file->get_contenthash(),
            ];

            $h5pstorage->savePackage($content, null, false, $options);
            return $h5pstorage->contentId;
        }

        return false;
    }

    /**
     * Delete an H5P package.
     *
     * @param stdClass $content The H5P package to delete.
     */
    protected function delete_h5p(\stdClass $content) {
        $h5pstorage = $this->factory->get_storage();
        // Add an empty slug to the content if it's not defined, because the H5P library requires this field exists.
        // It's not used when deleting a package, so the real slug value is not required at this point.
        $content->slug = $content->slug ?? '';
        $h5pstorage->deletePackage( (array) $content);
    }

    protected static function get_main_library_from_config(array $config): ?string {
        $mainlibraryname = $config['mainLibrary'];
        foreach ($config['preloadedDependencies'] as $dep) {
            if ($dep['machineName'] === $mainlibraryname) {
                return "{$dep['machineName']}-{$dep['majorVersion']}.{$dep['minorVersion']}";
            }
        }

        return null;
    }
}
