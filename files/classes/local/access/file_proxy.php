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
 * Course content exporter implementation for mod_folder.
 *
 * @package     core_files
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_files\local\access;

/**
 * Metadata used to locate a file of any kind.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class file_proxy {

    /** @var bool|null Whether to force the download */
    protected $forcedownload = null;

    /** @var array Options to pass to send_file */
    protected $sendfileoptions = [];

    /** @var int The amount of time to request that the browser caches the file */
    protected $cachetime = 10 * MINSECS;

    /** @var int The filter value to pass to send_file */
    protected $filterfile = 0;

    /**
     * Send the file proxy.
     *
     * @param   array $sendfileoptions
     * @param   bool $forcedownload
     */
    abstract public function send_file(array $sendfileoptions, bool $forcedownload): void;

    /**
     * Override the forcedownload option with the specified value.
     *
     * @param   bool $forcedownload
     */
    public function set_force_download(bool $forcedownload): void {
        $this->forcedownload = $forcedownload;
    }

    /**
     * Get the final configuration of whether to force a download.
     *
     * The configuration received via the @see{set_force_download} function overrides the value provided here.
     *
     * The usecase anticipated is that a component will call set_force_download if it has a need to override the value requested
     * by the user.
     *
     * @param   bool $forcedownloadrequested
     * @return  bool
     */
    public function get_force_download_value(bool $forcedownloadrequested): bool {
        if ($this->forcedownload === null) {
            return $forcedownloadrequested;
        }

        return $this->forcedownload;
    }

    /**
     * Override the standard options with the specified option.
     *
     * @param   string $key
     * @param   mixed $value
     */
    public function set_sendfile_option(string $key, $value): void {
        $this->sendfileoptions[$key] = $value;
    }

    /**
     * Get the final option configuration.
     *
     * The configuration received via the @see{set_sendfile_option} function overrides the value provided here.
     *
     * The usecase anticipated is that a component may set any specific options required, and may override any values
     * requested by the user.
     *
     * @param   array $userrequestedoptions
     * @return  array
     */
    public function get_sendfile_options(array $userrequestedoptions): array {
        return array_merge(
            $userrequestedoptions,
            $this->sendfileoptions
        );
    }

    /**
     * Set the component-requested cache time.
     *
     * @param   int $cachetime
     */
    public function set_cache_time(int $cachetime): void {
        $this->cachetime = $cachetime;
    }

    /**
     * Get the cache time to pass to send_file().
     *
     * @return int
     */
    public function get_cache_time(): int {
        return $this->cachetime;
    }

    /**
     * How to filter the filter during send_file.
     *
     * Permitted values are:
     *      * 0 -  Do not filter
     *      * 1 -  All filters
     *      * 2 -  Only filter HTML files
     *
     * @param   int $filtervalue
     */
    public function set_filter_value(int $filtervalue): void {
        $this->filterfile = $filtervalue;
    }

    /**
     * Get the filter setting to pass to send_file().
     *
     * @return  int
     */
    public function get_filter_value(): int {
        return $this->filterfile;
    }
}
