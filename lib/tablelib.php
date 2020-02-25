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
 * @package    core
 * @subpackage lib
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

// Note: These contants will be deprecated in Moodle 4.0.
// Please use the new constants on core_table\flexible_table by the same name.
define('TABLE_VAR_SORT',   1);
define('TABLE_VAR_HIDE',   2);
define('TABLE_VAR_SHOW',   3);
define('TABLE_VAR_IFIRST', 4);
define('TABLE_VAR_ILAST',  5);
define('TABLE_VAR_PAGE',   6);
define('TABLE_VAR_RESET',  7);
define('TABLE_VAR_DIR',    8);
define('TABLE_P_TOP',    1);
define('TABLE_P_BOTTOM', 2);

/**
 * A basic flexible table which uses static data, and supports sort, export, and basic column control.
 *
 * @package     core
 * @copyright   1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class flexible_table extends \core_table\flexible_table {
    /**
     * Constructor for the flexible_table class.
     */
    public function __construct() {
        call_user_func_array([parent, '__construct'], func_get_args());

        if (!is_a($this, table_sql::class)) {
            debugging(
                'The flexible_table class has been deprecated in favour of \core_table\flexible_table. ' .
                'Please update your code to use the new class. ' .
                'Please note that many of the properties have been renamed.',
                DEBUG_DEVELOPER
            );
        }
    }
}

/**
 * @package   moodlecore
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class table_sql extends flexible_table {

    public $countsql = NULL;
    public $countparams = NULL;
    /**
     * @var object sql for querying db. Has fields 'fields', 'from', 'where', 'params'.
     */
    public $sql = NULL;
    /**
     * @var array|\Traversable Data fetched from the db.
     */
    public $rawdata = NULL;

    /**
     * @var bool Overriding default for this.
     */
    public $is_sortable    = true;
    /**
     * @var bool Overriding default for this.
     */
    public $is_collapsible = true;

    /**
     * @param string $uniqueid a string identifying this table.Used as a key in
     *                          session  vars.
     */
    function __construct($uniqueid) {
        parent::__construct($uniqueid);
        // some sensible defaults
        $this->set_attribute('cellspacing', '0');
        $this->set_attribute('class', 'generaltable generalbox');
    }

    /**
     * Take the data returned from the db_query and go through all the rows
     * processing each col using either col_{columnname} method or other_cols
     * method or if other_cols returns NULL then put the data straight into the
     * table.
     *
     * After calling this function, don't forget to call close_recordset.
     */
    public function build_table() {

        if ($this->rawdata instanceof \Traversable && !$this->rawdata->valid()) {
            return;
        }
        if (!$this->rawdata) {
            return;
        }

        foreach ($this->rawdata as $row) {
            $formattedrow = $this->format_row($row);
            $this->add_data_keyed($formattedrow,
                $this->get_row_class($row));
        }
    }

    /**
     * Closes recordset (for use after building the table).
     */
    public function close_recordset() {
        if ($this->rawdata && ($this->rawdata instanceof \core\dml\recordset_walk ||
                $this->rawdata instanceof moodle_recordset)) {
            $this->rawdata->close();
            $this->rawdata = null;
        }
    }

    /**
     * Get any extra classes names to add to this row in the HTML.
     * @param $row array the data for this row.
     * @return string added to the class="" attribute of the tr.
     */
    function get_row_class($row) {
        return '';
    }

    /**
     * This is only needed if you want to use different sql to count rows.
     * Used for example when perhaps all db JOINS are not needed when counting
     * records. You don't need to call this function the count_sql
     * will be generated automatically.
     *
     * We need to count rows returned by the db seperately to the query itself
     * as we need to know how many pages of data we have to display.
     */
    function set_count_sql($sql, array $params = NULL) {
        $this->countsql = $sql;
        $this->countparams = $params;
    }

    /**
     * Set the sql to query the db. Query will be :
     *      SELECT $fields FROM $from WHERE $where
     * Of course you can use sub-queries, JOINS etc. by putting them in the
     * appropriate clause of the query.
     */
    function set_sql($fields, $from, $where, array $params = array()) {
        $this->sql = new stdClass();
        $this->sql->fields = $fields;
        $this->sql->from = $from;
        $this->sql->where = $where;
        $this->sql->params = $params;
    }

    /**
     * Query the db. Store results in the table object for use by build_table.
     *
     * @param int $pagesize size of page for paginated displayed table.
     * @param bool $useinitialsbar do you want to use the initials bar. Bar
     * will only be used if there is a fullname column defined for the table.
     */
    function query_db($pagesize, $useinitialsbar=true) {
        global $DB;
        if (!$this->is_downloading()) {
            if ($this->countsql === NULL) {
                $this->countsql = 'SELECT COUNT(1) FROM '.$this->sql->from.' WHERE '.$this->sql->where;
                $this->countparams = $this->sql->params;
            }
            $grandtotal = $DB->count_records_sql($this->countsql, $this->countparams);
            if ($useinitialsbar && !$this->is_downloading()) {
                $this->initialbars(true);
            }

            list($wsql, $wparams) = $this->get_sql_where();
            if ($wsql) {
                $this->countsql .= ' AND '.$wsql;
                $this->countparams = array_merge($this->countparams, $wparams);

                $this->sql->where .= ' AND '.$wsql;
                $this->sql->params = array_merge($this->sql->params, $wparams);

                $total  = $DB->count_records_sql($this->countsql, $this->countparams);
            } else {
                $total = $grandtotal;
            }

            $this->pagesize($pagesize, $total);
        }

        // Fetch the attempts
        $sort = $this->get_sql_sort();
        if ($sort) {
            $sort = "ORDER BY $sort";
        }
        $sql = "SELECT
                {$this->sql->fields}
                FROM {$this->sql->from}
                WHERE {$this->sql->where}
                {$sort}";

        if (!$this->is_downloading()) {
            $this->rawdata = $DB->get_records_sql($sql, $this->sql->params, $this->get_page_start(), $this->get_page_size());
        } else {
            $this->rawdata = $DB->get_records_sql($sql, $this->sql->params);
        }
    }

    /**
     * Convenience method to call a number of methods for you to display the
     * table.
     */
    function out($pagesize, $useinitialsbar, $downloadhelpbutton='') {
        global $DB;
        if (!$this->columns) {
            $onerow = $DB->get_record_sql("SELECT {$this->sql->fields} FROM {$this->sql->from} WHERE {$this->sql->where}",
                $this->sql->params, IGNORE_MULTIPLE);
            //if columns is not set then define columns as the keys of the rows returned
            //from the db.
            $this->define_columns(array_keys((array)$onerow));
            $this->define_headers(array_keys((array)$onerow));
        }
        $this->setup();
        $this->query_db($pagesize, $useinitialsbar);
        $this->build_table();
        $this->close_recordset();
        $this->finish_output();
    }
}

/**
 * @package   moodlecore
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class table_default_export_format_parent {
    /**
     * @var flexible_table or child class reference pointing to table class
     * object from which to export data.
     */
    var $table;

    /**
     * @var bool output started. Keeps track of whether any output has been
     * started yet.
     */
    var $documentstarted = false;

    /**
     * Constructor
     *
     * @param flexible_table $table
     */
    public function __construct(&$table) {
        $this->table =& $table;
    }

    /**
     * Old syntax of class constructor. Deprecated in PHP7.
     *
     * @deprecated since Moodle 3.1
     */
    public function table_default_export_format_parent(&$table) {
        debugging('Use of class name as constructor is deprecated', DEBUG_DEVELOPER);
        self::__construct($table);
    }

    function set_table(&$table) {
        $this->table =& $table;
    }

    function add_data($row) {
        return false;
    }

    function add_seperator() {
        return false;
    }

    function document_started() {
        return $this->documentstarted;
    }
    /**
     * Given text in a variety of format codings, this function returns
     * the text as safe HTML or as plain text dependent on what is appropriate
     * for the download format. The default removes all tags.
     */
    function format_text($text, $format=FORMAT_MOODLE, $options=NULL, $courseid=NULL) {
        //use some whitespace to indicate where there was some line spacing.
        $text = str_replace(array('</p>', "\n", "\r"), '   ', $text);
        return strip_tags($text);
    }
}

/**
 * Dataformat exporter
 *
 * @package    core
 * @subpackage tablelib
 * @copyright  2016 Brendan Heywood (brendan@catalyst-au.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class table_dataformat_export_format extends table_default_export_format_parent {

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
            throw new coding_exception("Output can not be buffered before instantiating table_dataformat_export_format");
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
