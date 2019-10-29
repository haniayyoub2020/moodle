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
 * H5P content type class.
 *
 * @package    core_h5p
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_h5p;

use context;
use stdClass;
use stored_file;
use moodle_url;
use core\dml\table as dml_table;
use core_h5p\factory;

/**
 * H5P content type class.
 *
 * @package    core_h5p
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class content_type {
    /** @var stored_file */
    protected $file = null;

    /** @var moodel_url */
    protected $url = null;

    /** @var context */
    protected $context = null;

    /** @var int */
    protected $id = null;

    /** @var stdClass The decoded content of the `jsoncontent` field */
    protected $content = null;

    /** @var stdClass The main library content */
    protected $mainlibrary = null;

    /** @var stdClass the filter configuration */
    protected $filtered = null;

    /** @var int The display options */
    protected $displayoptions = null;

    /** @var string The pathname hash used within the files table */
    protected $pathnamehash = null;

    /** @var string The content hash of the package */
    protected $contenthash = null;

    /** @var factory The versioned H5P factory */
    protected $factory = null;

    /**
     * Load a content type using a URL.
     *
     * @param string $url
     * @return self
     */
    public static function load_from_url(string $url): self {
        $file = loader::get_stored_file_from_url($url);

        if (!$file) {
            throw new \moodle_exception(get_string('invalidh5purl', 'core_h5p'));
        }

        return static::load_from_stored_file($file);
    }

    /**
     * Load a content type using a stored file.
     *
     * @param stored_file $file The file record for the H5P package
     * @return self
     */
    public static function load_from_stored_file(stored_file $file): self {
        return new static($file);
    }

    public function is_deployed(): bool {
        return null !== $this->id;
    }

    /**
     * Load a content type using the content and pathname hashes.
     *
     * @param string $contenthash The contenthash of the H5P package
     * @param string $pathnamehash The pathname hash used to view this package
     */
    public function deploy(): void {
        global $DB;

        $contenthash = $this->file->get_contenthash();
        $pathnamehash = $this->file->get_pathnamehash();

        // Find all records which have a matching contenthash or pathname hash.
        // If the pathnamehash and contenthash both match then everything is up-to-date.
        // If the pathnamehash matches, but the contenthash does not, we remove the record.
        // If there is a matching contenthash without a matching pathnamehash, then we copy that to avoid unpacking an
        // already unpacked object.
        $records = $DB->get_records_select(
            'h5p',
            "contenthash = :contenthash or pathnamehash = :pathnamehash",
            [
                'contenthash' => $contenthash,
                'pathnamehash' => $pathnamehash,
            ],
            '', 'pathnamehash, contenthash, id', 0, 2
        );

        $config = null;
        if (array_key_exists($this->file->get_pathnamehash(), $records)) {
            // The pathname matches. Fetch this record.
            $config = $records[$pathnamehash];
            if ($contenthash !== $config->contenthash) {
                // Maybe an old copy. Delete it and regenerate.
                unset($records[$pathnamehash]);
                self::delete_record($config);
                $config = null;
            }
        }

        if (null === $config) {
            if (!empty($records)) {
                // There is another copy of the same file.
                // Copy it's configuration and load that.
                $copyfromconfig = reset($records);
                $config = $DB->get_record('h5p', ['id' => $copyfromconfig->id]);
                $config->id = null;
                $config->filtered = null;
                $config->displayoptions = null;
                $config->pathnamehash = $pathnamehash;
                $config->id = $DB->insert_record('h5p', $config);

            }
        }

        if (null === $config) {
            loader::deploy_package_from_stored_file($this->file);
        }

        $this->load_package_configuration();

        if (!$this->is_deployed()) {
            throw new \moodle_exception(get_string('invalidh5p', 'core_h5p'));
        }
    }

    /**
     * Constructor for the H5P Content Type.
     */
    protected function __construct(stored_file $file) {
        $this->file = $file;
        $this->context = \context::instance_by_id($file->get_contextid());

        $this->load_package_configuration();
    }

    protected function load_package_configuration(): void {
        global $DB;

        // Fetch the H5P record and main library record.
        $h5ptable = new dml_table('h5p', 'h', 'h_');
        $libtable = new dml_table('h5p_libraries', 'l', 'l_');

        $fields = implode(', ', [
            $h5ptable->get_field_select(),
            $libtable->get_field_select(),
        ]);

        $sql = "SELECT {$fields}
                  FROM " . $h5ptable->get_from_sql() . "
                  JOIN " . $libtable->get_from_sql() . " ON l.id = h.mainlibraryid
                 WHERE h.pathnamehash = :pathnamehash AND h.contenthash = :contenthash";
        $config = $DB->get_record_sql($sql, [
            'pathnamehash' => $this->file->get_pathnamehash(),
            'contenthash' => $this->file->get_contenthash(),
        ]);

        if (!$config) {
            return;
        }

        // Grab the main library from the combined result.
        $this->mainlibrary = $libtable->extract_from_result($config);
        $h5p = $h5ptable->extract_from_result($config);

        $this->id = $h5p->id;
        $this->context = \context::instance_by_id($this->file->get_contextid());

        // Special fields.
        $this->content = json_decode($h5p->jsoncontent);
        $this->filtered = json_decode($h5p->filtered);

        // Regular options which do not require processing.
        $this->displayoptions = $h5p->displayoptions;
        $this->pathnamehash = $h5p->pathnamehash;
        $this->contenthash = $h5p->contenthash;
    }

    /**
     * Get the factory for this content type.
     */
    public function get_factory(): factory {
        // TODO If coreapi > latest version... except.
        if (null === $this->factory) {
            $version = $this->mainlibrary->coreapi;

            if (empty($version) || !container::version_exists($version)) {
                $version = container::get_latest_version();
            }

            $this->factory = container::get_factory($version);
        }

        return $this->factory;
    }

    public function get_player_for_url(string $url, stdClass $buttonconfig): player {
        $factory = $this->get_factory();

        return $factory->get_player($factory, $this->context, $this->file, $url, (object) [
            'id' => $this->id,
        ], $buttonconfig);
    }

    /**
     * Set the URL associated with the viewing of this H5P content type.
     *
     * @param moodle_url $url
     * @return self
     */
    public function set_url(moodle_url $url): self {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the filtered configuration used when displaying this resource.
     *
     * @param moodle_url $url
     * @return self
     */
    public function set_filtered_configuration(): self {
        return $this;
    }

    /**
     * Get the stored file associated with this H5P content type.
     *
     * @return stored_file
     */
    public function get_stored_file(): stored_file {
        return $this->file;
    }

    /**
     * Return the URL associated with the viewing of this H5P content type.
     *
     * @return moodle_url
     */
    public function get_url(): moodle_url {
        return new moodle_url();
    }

    /**
     * Get the ID of the specified content type.
     *
     * @return int
     */
    public function get_id(): int {
        return $this->id;
    }

    /**
     * Get the filtered configuration.
     *
     * @return stdClass
     */
    public function get_filtered_configuration(): stdClass {
        return $this->filtered;
    }

    /**
     * Delete the record associated with the specified content type.
     *
     * @param stdClass $config The item to delete
     */
    protected static function delete_record(stdClass $config): void {
        global $DB;

        $DB->delete_record('h5p', [
            'id' => $config->id,
        ]);
    }

    /**
     * Save the H5P resource using current configuration.
     */
    public function save(): void {
        global $DB;

        $config = (object) [
            'id' => $this->id,
            // TODO UTF8 Encoding.
            'jsoncontent' => json_encode($this->content),
            'filtered' => json_encode($this->filtered),
            'displayoptions' => $this->displayoptions,
        ];

        $DB->update_record('h5p', $config);
    }

    /**
     * Get the context for this content type.
     *
     * @return context
     */
    public function get_context(): context {
        return $this->context;
    }

    public function get_owner(): int {
        return $this->file->get_userid();
    }

}
