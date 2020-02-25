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
 * Table functionality in Moodle.
 *
 * @package     core_table
 * @copyright   1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_table\local\dataformat;

use coding_exception;
use core_table\local\dataformat;

/**
 * A data format for use in exporting table data.
 *
 * @package     core_table
 * @copyright   1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class export extends dataformat {
    /** @var $dataformat */
    protected $dataformat;

    /** @var $rownum */
    protected $rownum = 0;

    /** @var $columns */
    protected $columns;

    /**
     * Constructor
     *
     * @param string $table An sql table
     * @param string $dataformat type of dataformat for export
     */
    public function __construct(&$table, $dataformat) {
        parent::__construct($table);

        if (ob_get_length()) {
            throw new coding_exception("Output can not be buffered before instantiating an export format");
        }

        $classname = 'dataformat_' . $dataformat . '\writer';
        if (!class_exists($classname)) {
            throw new coding_exception("Unable to locate dataformat/$dataformat/classes/writer.php");
        }
        $this->dataformat = new $classname;

        // The dataformat export time to first byte could take a while to generate...
        set_time_limit(0);

        // Close the session so that the users other tabs in the same session are not blocked.
        \core\session\manager::write_close();
    }

    /**
     * Start document
     *
     * @param string $filename
     * @param string $sheettitle
     */
    public function start_document($filename, $sheettitle) {
        $this->documentstarted = true;
        $this->dataformat->set_filename($filename);
        $this->dataformat->send_http_headers();
        $this->dataformat->set_sheettitle($sheettitle);
        $this->dataformat->start_output();
    }

    /**
     * Start export
     *
     * @param string $sheettitle optional spreadsheet worksheet title
     */
    public function start_table($sheettitle) {
        $this->dataformat->set_sheettitle($sheettitle);
    }

    /**
     * Output headers
     *
     * @param array $headers
     */
    public function output_headers($headers) {
        $this->columns = $headers;
        if (method_exists($this->dataformat, 'write_header')) {
            error_log('The function write_header() does not support multiple sheets. In order to support multiple sheets you ' .
                'must implement start_output() and start_sheet() and remove write_header() in your dataformat.');
            $this->dataformat->write_header($headers);
        } else {
            $this->dataformat->start_sheet($headers);
        }
    }

    /**
     * Add a row of data
     *
     * @param array $row One record of data
     */
    public function add_data($row) {
        $this->dataformat->write_record($row, $this->rownum++);
        return true;
    }

    /**
     * Finish export
     */
    public function finish_table() {
        if (method_exists($this->dataformat, 'write_footer')) {
            error_log('The function write_footer() does not support multiple sheets. In order to support multiple sheets you ' .
                'must implement close_sheet() and close_output() and remove write_footer() in your dataformat.');
            $this->dataformat->write_footer($this->columns);
        } else {
            $this->dataformat->close_sheet($this->columns);
        }
    }

    /**
     * Finish download
     */
    public function finish_document() {
        $this->dataformat->close_output();
        exit();
    }
}
