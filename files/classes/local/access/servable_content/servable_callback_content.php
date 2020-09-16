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
namespace core_files\local\access\servable_content;

use core_files\local\access\servable_content as abstract_servable_content;

/**
 * An object used to represent content which can be served via a callable.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class servable_callback_content extends abstract_servable_content {

    /** @var callable The file to be proxied */
    protected $callback;

    /**
     * Create a new instance of the stored_file proxy.
     *
     * @param   stored_file $file
     * @return  servable_callback_content
     */
    public static function create(callable $callback): self {
        return new self($callback);
    }

    /**
     * Constructor for the stored_file proxy.
     *
     * @param   stored_file $file
     */
    protected function __construct(callable $callback) {
        $this->callback = $callback;
    }

    /**
     * Send the file proxy.
     *
     * @param   array $sendfileoptions he user-requested send_file options.
     *          Note: These may be overridden by the component as required.
     * @param   bool $forcedownload Whether the user-requested the file be downloaded.
     *          Note: The component may override this value as required.
     */
    public function send_file(array $sendfileoptions, bool $forcedownload): void {
        $this->send_headers();

        send_file(
            $this->callback(),
            $this->get_cache_time(),
            $this->get_filter_value(),
            $this->get_force_download_value($forcedownload),
            $this->get_sendfile_options($sendfileoptions)
        );
    }
}
