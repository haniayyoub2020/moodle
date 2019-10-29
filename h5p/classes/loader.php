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
use ZipArchive;

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
     * TODO REmove.
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
            self::deploy_package_from_stored_file($file);
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

    /**
     * Deploy a new h5p package from the specified stored file.
     *
     * @param stored_file $file The file to deploy.
     * @return int The id of the new H5P package
     */
    public static function deploy_package_from_stored_file(stored_file $file): int {
        // Check if the user uploading the H5P content is "trustable". If the file hasn't been uploaded by a user with this
        // capability, the content won't be deployed and an error message will be displayed.
        $context = \context::instance_by_id($file->get_contextid());
        if (!has_capability('moodle/h5p:deploy', $context, $file->get_userid())) {
            throw new \moodle_exception(get_string('nopermissiontodeploy', 'core_h5p'));
        }

        // Validate and store the H5P content before displaying it.
        $h5pid = !self::save_h5p($file);

        if (null === $h5pid) {
            throw new \moodle_exception('Unable to save h5p');
        }

        return $h5pid;
    }

    /**
     * Get the pathnamehash from an H5P internal URL.
     *
     * @param  string $url H5P pluginfile URL poiting to an H5P file.
     *
     * @return string|false pathnamehash for the file in the internal URL.
     */
    public static function get_stored_file_from_url(string $url): ?stored_file {
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
            return null;
        }

        // Some components, such as mod_page or mod_resource, add the revision to the URL to prevent caching problems.
        // So the URL contains this revision number as itemid but a 0 is always stored in the files table.
        // In order to get the proper hash, a callback should be done (looking for those exceptions).
        $pathdata = component_callback($component, 'get_path_from_pluginfile', [$filearea, $parts], null);

        if (null === $pathdata) {
            // Look for the components and fileareas which have empty itemid defined in xxx_pluginfile.
            // Note: This list should match the same configuration in lib/filelib.php.
            $hasnullitemid = false;
            $hasnullitemid = $hasnullitemid || ($component === 'user' && ($filearea === 'private' || $filearea === 'profile'));
            $hasnullitemid = $hasnullitemid || ($component === 'mod' && $filearea === 'intro');
            $hasnullitemid = $hasnullitemid || ($component === 'course' && $filearea === 'summary');
            $hasnullitemid = $hasnullitemid || ($component === 'course' && $filearea === 'overviewfiles');
            $hasnullitemid = $hasnullitemid || ($component === 'coursecat' && $filearea === 'description');
            $hasnullitemid = $hasnullitemid || ($component === 'backup' && $filearea === 'course');
            $hasnullitemid = $hasnullitemid || ($component === 'backup' && $filearea === 'activity');
            $hasnullitemid = $hasnullitemid || ($component === 'backup' && $filearea === 'automated');

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
        return $fs->get_file($contextid, $component, $filearea, $itemid, $filepath, $filename) ?? null;
    }

    /**
     * Attempt to identify the minimum required core API version for the specified H5P Package.
     *
     * @param stored_file $file The stored_file record fro the H5P Package.
     * @return null|string If a version is required, then the version is returned.
     */
    protected static function get_core_version_from_storedfile(stored_file $file): ?string {
        // Copy the H5P file to disk for examination.
        $h5pfile = make_request_directory() . "/h5p.h5p";
        $file->copy_content_to($h5pfile);

        // An H5P package has an h5p.json metadata file which identifies the list of libraries it contains, and which of
        // those is considered to be its 'main' library.
        // The main library may optionally specify which is the minimum 'core' library required.

        $za = new \ZipArchive();
        if (!$za->open($h5pfile)) {
            throw new \moodle_exception('Unable to examine the provided H5P file');
        }

        // Attempt to extract the h5p.json.
        $h5pconfig = static::extract_file_from_zip($za, 'h5p.json');
        if (!$config = json_decode($h5pconfig, true)) {
            $za->close();
            throw new \moodle_exception('Unable to examine the provided H5P file. H5P Configuration is corrupt.');
        }

        $mainlibraryconfigpath = self::get_main_library_from_config($config) . "/library.json";
        $libraryconfigjson = static::extract_file_from_zip($za, $mainlibraryconfigpath);

        // Finished dealing with the ZipArchive. Close it.
        $za->close();

        if (!$libraryconfig = json_decode($libraryconfigjson, true)) {
            throw new \moodle_exception('Unable to examine the provided H5P file. H5P library Configuration is corrupt.');
        }

        if (array_key_exists('coreAPI', $libraryconfig)) {
            // There is a core API version associated with this library.
            return "{$libraryconfig['coreAPI']['majorVersion']}.{$libraryconfig['coreAPI']['minorVersion']}";
        }

        // No core API version requirement defined.
        return null;
    }

    /**
     * Extract a specific file from the zip archive.
     *
     * @param ZipArchive $zip The zip archive in which the file is found
     * @param string $path The path to the file within the archive
     * @return string The extracted file contents
     */
    protected static function extract_file_from_zip(ZipArchive $zip, string $path): string {
        // Attempt to extract the h5p.json.
        if (!$fileinfo = $zip->statName($path)) {
            $zip->close();
            throw new \moodle_exception("The '{$path}' file was not found within the H5P package.");
        }

        if (!$fp = $zip->getStream($path)) {
            $zip->close();
            throw new \moodle_exception("Unable to unpack '{$path}' file from within the H5P package.");
        }

        $content = '';
        while (!feof($fp)) {
            $content .= fread($fp, 1024);
        }

        return $content;
    }

    /**
     * Get the H5P Factory required for the specified stored file.
     *
     * @param stored_file $file The file to fetch a factory for
     * @return factory
     */
    protected static function get_factory_for_stored_file(stored_file $file): factory {
        $version = self::get_core_version_from_storedfile($file);

        if (empty($version) || !container::version_exists($version)) {
            $version = container::get_latest_version();
        }

        return \core_h5p\container::get_factory($version);
    }

    /**
     * Store an H5P file.
     *
     * @param stored_file $file Moodle file instance
     * @param stdClass $config Button options config.
     *
     * @return int|false The H5P identifier or false if it's not a valid H5P package.
     */
    protected static function save_h5p(stored_file $file): ?int {
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

        return null;
    }

    /**
     * Find the formatted dependency name of the main library from the specified configuration.
     *
     * @param array $config The configuraiton
     * @return null|string The name of the dependnecy
     */
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
