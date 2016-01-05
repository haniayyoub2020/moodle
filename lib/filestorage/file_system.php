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
 * Core file system class definition.
 *
 * @package   core_files
 * @copyright 2015 Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * File system class used for low level access to real files in filedir.
 *
 * @package   core_files
 * @category  files
 * @copyright 2015 Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since     Moodle 2.9
 */
abstract class file_system {

    /**
     * @var file_storage The reference to the file storage instance.
     */
    protected $fs = null;

    /**
     * Constructor for the file_system.
     *
     * @param file_storage $fs The instance of file_storage to instantiate the class with.
     */
    final public function __construct(file_storage $fs = null) {
        $this->fs = $fs;

        $this->setup_instance();
    }

    /**
     * Perform any custom setup for this type of file_system.
     */
    abstract protected function setup_instance();

    /**
     * Private clone method to prevent cloning of the instance.
     */
    final protected function __clone() {
        return;
    }

    /**
     * Private wakeup method to prevent unserialising of the instance.
     */
    final protected function __wakeup() {
        return;
    }

    /**
     * Output the content of the specified stored file.
     *
     * Note, this is different to get_content() as it uses the built-in php
     * readfile function which is more efficient.
     *
     * @param stored_file $file The file to serve.
     * @return void
     */
    public function readfile(stored_file $file) {
        $path = $this->get_remote_path_from_storedfile($file);
        readfile_allow_large($path, $file->get_filesize());
    }

    /**
     * Get the full path on disk for the specified stored file.
     *
     * @param stored_file $file The file to serve.
     * @param bool $fetchifnotfound Whether to attempt to fetch from the UNC path if not found.
     * @return string full path to pool file with file content
     */
    protected function get_local_path_from_storedfile(stored_file $file, $fetchifnotfound = false) {
        // This does not check that the file is present on disk.
        return $this->get_local_path_from_hash($file->get_contenthash(), $fetchifnotfound);
    }

    /**
     * Get a UNC filepath for the specified stored file.
     *
     * @param stored_file $file The file to serve.
     * @return string full path to pool file with file content
     */
    protected function get_remote_path_from_storedfile(stored_file $file) {
        return $this->get_local_path_from_storedfile($file, false);
    }

    /**
     * Get the full path for the specified hash, including the path to the filedir.
     *
     * @param string $contenthash The content hash
     * @param bool $fetchifnotfound Whether to attempt to fetch from the UNC path if not found.
     * @return string The full path to the content file
     */
    abstract protected function get_local_path_from_hash($contenthash, $fetchifnotfound = false);

    /**
     * Get the full path for the specified hash, including the path to the filedir.
     *
     * @param string $contenthash The content hash
     * @return string The full path to the content file
     */
    protected function get_remote_path_from_hash($contenthash) {
        return $this->get_local_path_from_hash($contenthash, false);
    }

    /**
     * Determine whether the file is present on the file system somewhere.
     *
     * @param stored_file $file The file to ensure is available.
     * @param bool $fetchifnotfound Whether to attempt to fetch from the UNC path if not found.
     * @return bool
     */
    public function is_readable_locally_by_storedfile(stored_file $file, $fetchifnotfound = false) {
        // Check to see if the file is currently readable.
        $path = $this->get_local_path_from_storedfile($file, $fetchifnotfound);
        if (is_readable($path)) {
            return true;
        }

        // Try content recovery.
        if ($this->try_content_recovery($file)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the file is present on the local file system somewhere.
     *
     * @param stored_file $file The file to ensure is available.
     * @return bool
     */
    public function is_readable_by_storedfile(stored_file $file) {
        return $this->is_readable_locally_by_storedfile($file, false);
    }

    /**
     * Determine whether the file is present on the file system somewhere given
     * the contenthash.
     *
     * @param string $contenthash The contenthash of the file to check.
     * @param bool $fetchifnotfound Whether to attempt to fetch from the UNC path if not found.
     * @return bool
     */
    public function is_readable_locally_by_hash($contenthash, $fetchifnotfound = false) {
        // This is called by file_storage::content_exists(), and in turn by the repository system.
        $path = $this->get_local_path_from_hash($contenthash, $fetchifnotfound);

        // Note - it is not possible to perform a content recovery safely from a hash alone.
        return is_readable($path);
    }

    /**
     * Determine whether the file is present locally on the file system somewhere given
     * the contenthash.
     *
     * @param string $contenthash The contenthash of the file to check.
     * @return bool
     */
    public function is_readable_by_hash($contenthash) {
        return $this->is_readable_locally_by_hash($contenthash, false);
    }

    /**
     * Copy content of file to given pathname.
     *
     * @param string $target real path to the new file
     * @return bool success
     */
    abstract public function copy_content_from_storedfile(stored_file $file, $target);

    /**
     * Tries to recover missing content of file from trash.
     *
     * @param stored_file $file stored_file instance
     * @return bool success
     */
    abstract protected function try_content_recovery(stored_file $file);

    /**
     * Marks pool file as candidate for deleting.
     *
     * DO NOT call directly - reserved for core!!
     *
     * @param string $contenthash
     * @private
     */
    public function deleted_file_cleanup($contenthash) {
        global $DB;

        if ($contenthash === sha1('')) {
            // No need to delete empty content file with sha1('') content hash.
            return;
        }

        //Note: this section is critical - in theory file could be reused at the same
        //      time, if this happens we can still recover the file from trash
        if ($DB->record_exists('files', array('contenthash' => $contenthash))) {
            // file content is still used
            return;
        }

        // Actually process the file removal.
        return $this->remove_file($contenthash);
    }

    /**
     * Marks pool file as candidate for deleting.
     *
     * DO NOT call directly - reserved for core!!
     *
     * @param string $contenthash
     */
    abstract protected function remove_file($contenthash);

    /**
     * Cleanup the trash directory.
     */
    abstract public function cleanup_trash();

    /**
     * Get the content of the specified stored file.
     *
     * Generally you will probably want to use readfile() to serve content,
     * and where possible you should see if you can use
     * get_content_file_handle and work with the file stream instead.
     *
     * @param stored_file $file The file to retrieve
     * @return string The full file content
     */
    public function get_content(stored_file $file) {
        $source = $this->get_remote_path_from_storedfile($file);
        return file_get_contents($source);
    }

    /**
     * List contents of archive.
     *
     * @param stored_file $file The archive to inspect
     * @param file_packer $packer file packer instance
     * @return array of file infos
     */
    public function list_files($file, file_packer $packer) {
        $archivefile = $this->get_local_path_from_storedfile($file, true);
        return $packer->list_files($archivefile);
    }

    /**
     * Extract file to given file path (real OS filesystem), existing files are overwritten.
     *
     * @param stored_file $file The archive to inspect
     * @param file_packer $packer File packer instance
     * @param string $pathname Target directory
     * @param file_progress $progress progress indicator callback or null if not required
     * @return array|bool List of processed files; false if error
     */
    public function extract_to_pathname(stored_file $file, file_packer $packer, $pathname, file_progress $progress = null) {
        $archivefile = $this->get_local_path_from_storedfile($file, true);
        return $packer->extract_to_pathname($archivefile, $pathname, null, $progress);
    }

    /**
     * Extract file to given file path (real OS filesystem), existing files are overwritten.
     *
     * @param stored_file $file The archive to inspect
     * @param file_packer $packer file packer instance
     * @param int $contextid context ID
     * @param string $component component
     * @param string $filearea file area
     * @param int $itemid item ID
     * @param string $pathbase path base
     * @param int $userid user ID
     * @param file_progress $progress Progress indicator callback or null if not required
     * @return array|bool list of processed files; false if error
     */
    public function extract_to_storage(stored_file $file, file_packer $packer, $contextid,
            $component, $filearea, $itemid, $pathbase, $userid = null, file_progress $progress = null) {

        // Since we do not know which extractor we have, and whether it supports UNC paths, use a local path here.
        $archivefile = $this->get_local_path_from_storedfile($file, true);
        return $packer->extract_to_storage($archivefile, $contextid,
                $component, $filearea, $itemid, $pathbase, $userid, $progress);
    }

    /**
     * Add file/directory into archive.
     *
     * @param stored_file $file The file to archive
     * @param file_archive $filearch file archive instance
     * @param string $archivepath pathname in archive
     * @return bool success
     */
    public function add_storedfile_to_archive(stored_file $file, file_archive $filearch, $archivepath) {
        if ($file->is_directory()) {
            return $filearch->add_directory($archivepath);
        } else {
            // Since we do not know which extractor we have, and whether it supports UNC paths, use a local path here.
            return $filearch->add_file_from_pathname($archivepath, $this->get_local_path_from_storedfile($file, true));
        }
    }

    /**
     * Adds this file path to a curl request (POST only).
     *
     * @param stored_file $file The file to add to the curl request
     * @param curl $curlrequest The curl request object
     * @param string $key What key to use in the POST request
     * @return void
     * This needs the fullpath for the storedfile :/
     * Can this be achieved in some other fashion?
     */
    public function add_to_curl_request(stored_file $file, &$curlrequest, $key) {
        // Note: curl_file_create does not work with UNC paths.
        $path = $this->get_local_path_from_storedfile($file, true);
        $curlrequest->_tmp_file_post_params[$key] = curl_file_create($path);
    }

    /**
     * Returns information about image.
     * Information is determined from the file content
     *
     * @param stored_file $file The file to inspect
     * @return mixed array with width, height and mimetype; false if not an image
     */
    public function get_imageinfo(stored_file $file) {
        if (!$this->is_image_from_storedfile($file)) {
            return false;
        }

        // Whilst get_imageinfo_from_path can use UNC paths, it must download the entire file first.
        // It is more efficient to use a local file when possible.
        return $this->get_imageinfo_from_path($this->get_local_path_from_storedfile($file, true));
    }

    /**
     * Attempt to determine whether the specified file is likely to be an
     * image.
     * Since this relies upon the mimetype stored in the files table, there
     * may be times when this information is not 100% accurate.
     *
     * @param stored_file $file The file to check
     * @return bool
     */
    public function is_image_from_storedfile(stored_file $file) {
        if (!$file->get_filesize()) {
            // An empty file cannot be an image.
            return false;
        }

        $mimetype = $file->get_mimetype();
        if (!preg_match('|^image/|', $mimetype)) {
            // The mimetype does not include image.
            return false;
        }

        // If it looks like an image, and it smells like an image, perhaps it's an image!
        return true;
    }

    /**
     * Returns image information relating to the specified path or URL.
     *
     * @param string $path The path to pass to getimagesize.
     * @return array Containing width, height, and mimetype.
     */
    protected function get_imageinfo_from_path($path) {
        $imageinfo = getimagesize($path);

        $image = array(
                'width'     => $imageinfo[0],
                'height'    => $imageinfo[1],
                'mimetype'  => image_type_to_mime_type($imageinfo[2]),
            );
        if (empty($image['width']) or empty($image['height']) or empty($image['mimetype'])) {
            // GD can not parse it, sorry.
            return false;
        }
        return $image;
    }

    /**
     * Serve file content using X-Sendfile header.
     * Please make sure that all headers are already sent and the all
     * access control checks passed.
     *
     * @param string $contenthash The content hash of the file to be served
     * @return bool success
     */
    public function xsendfile($contenthash) {
        global $CFG;
        require_once($CFG->libdir . "/xsendfilelib.php");

        return xsendfile($this->get_remote_path_from_hash($contenthash));
    }

    /**
     * Add file content to sha1 pool.
     *
     * @param string $pathname Path to file currently on disk
     * @param string $contenthash SHA1 hash of content if known (performance only)
     * @return array (contenthash, filesize, newfile)
     */
    abstract public function add_file_to_pool($pathname, $contenthash = NULL);

    /**
     * Add string content to sha1 pool.
     *
     * @param string $content file content - binary string
     * @return array (contenthash, filesize, newfile)
     */
    abstract public function add_string_to_pool($content);

    /**
     * Returns file handle - read only mode, no writing allowed into pool files!
     *
     * When you want to modify a file, create a new file and delete the old one.
     *
     * @param stored_file $file The file to retrieve a handle for
     * @param int $type Type of file handle (FILE_HANDLE_xx constant)
     * @return resource file handle
     */
    public function get_content_file_handle(stored_file $file, $type = stored_file::FILE_HANDLE_FOPEN) {
        if (!$this->is_readable_by_storedfile($file)) {
            $this->try_content_recovery($file);
        }

        $path = $this->get_remote_path_from_storedfile($file);

        return self::get_file_handle_for_path($path, $type);
    }

    /**
     * Return a file handle for the specified path.
     *
     * This abstraction should be used when overriding get_content_file_handle in a new file system.
     *
     * @param string $path The path to the file. This shoudl be any type of path that fopen and gzopen accept.
     * @param int $type Type of file handle (FILE_HANDLE_xx constant)
     * @return resource
     * @throws coding_exception When an unexpected type of file handle is requested
     */
    protected static function get_file_handle_for_path($path, $type = stored_file::FILE_HANDLE_FOPEN) {
        switch ($type) {
            case stored_file::FILE_HANDLE_FOPEN:
                // Binary reading.
                return fopen($path, 'rb');
            case stored_file::FILE_HANDLE_GZOPEN:
                // Binary reading of file in gz format.
                return gzopen($path, 'rb');
            default:
                throw new coding_exception('Unexpected file handle type');
        }
    }

    /**
     * Return mimetype by given file pathname.
     *
     * If file has a known extension, we return the mimetype based on extension.
     * Otherwise (when possible) we try to get the mimetype from file contents.
     *
     * @param string $pathname Full path to the file on disk
     * @param string $filename Correct file name with extension, if omitted will be taken from $path
     * @return string
     */
    public static function mimetype($fullpath, $filename = null) {
        if (empty($filename)) {
            $filename = $fullpath;
        }

        // The mimeinfo function determines the mimetype purely based on the file extension.
        $type = mimeinfo('type', $filename);

        if ($type === 'document/unknown') {
            // The type is unknown. Inspect the file now.
            $type = self::mimetype_from_file($fullpath);
        }
        return $type;
    }

    /**
     * Inspect a file on disk for it's mimetype.
     *
     * @param string $fullpath Path to file on disk
     * @return string The mimetype
     */
    public static function mimetype_from_file($fullpath) {
        if (file_exists($fullpath)) {
            // The type is unknown. Attempt to look up the file type now.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            return mimeinfo_from_type('type', $finfo->file($fullpath));
        }

        return 'document/unknown';
    }

    /**
     * Retrieve the mime information for the specified stored file.
     *
     * @param string $contenthash
     * @param string $filename
     * @return string The MIME type.
     */
    public function mimetype_from_hash($contenthash, $filename) {
        $pathname = $this->get_remote_path_from_hash($contenthash);
        $mimetype = self::mimetype($pathname, $filename);

        if (!$this->is_readable_locally_by_hash($contenthash, false) && $mimetype === 'document/unknown') {
            // The type is unknown, but the full checks weren't completed because the file isn't locally available.
            // Ensure we have a local copy and try again.
            $pathname = $this->get_local_path_from_hash($contenthash, true);

            $mimetype = self::mimetype_from_file($pathname);
        }

        return $mimetype;
    }

    /**
     * Retrieve the mime information for the specified stored file.
     *
     * @param stored_file $file The stored file to retrieve mime information for
     * @return string The MIME type.
     */
    public function mimetype_from_storedfile($file) {
        $pathname = $this->get_remote_path_from_storedfile($file);
        $mimetype = self::mimetype($pathname, $file->get_filename());

        if (!$this->is_readable_locally_by_storedfile($file) && $mimetype === 'document/unknown') {
            // The type is unknown, but the full checks weren't completed because the file isn't locally available.
            // Ensure we have a local copy and try again.
            $pathname = $this->get_local_path_from_storedfile($file, true);

            $mimetype = self::mimetype_from_file($pathname);
        }

        return $mimetype;
    }
}
