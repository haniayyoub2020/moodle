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

namespace core_table;

defined('MOODLE_INTERNAL') || die();

use Traversable;
use stdClass;
use core\dml\recordset_walk;
use moodle_recordset;

/**
 * A table offering the same functionality as the flexible_table but which uses data retrieved via SQL.
 *
 * @package     core_table
 * @copyright   1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class sql_table extends flexible_table {
    /** @var string|null The SQL query used to obtain a count of all records (for pagination) */
    protected $countsql = null;

    /** @var mixed[] The SQL parameters used by the countsql query */
    protected $countparams = null;

    /** @var stdClass|null The SQL for querying the db. Has fields 'fields', 'from', 'where', 'params' */
    protected $sql = null;

    /** @var array|Traversable Data fetched from the db */
    public $rawdata = null;

    /** @var bool Overriding default for this */
    protected $sortable = true;

    /** @var bool Overriding default for this */
    protected $collapsible = true;

    /**
     * Constructor.
     *
     * @param string $uniqueid The unique id for the table.
     */
    public function __construct($uniqueid) {
        parent::__construct($uniqueid);

        // Sensible defaults for an sql table.
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
        if ($this->rawdata instanceof Traversable && !$this->rawdata->valid()) {
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
        if ($this->rawdata && ($this->rawdata instanceof recordset_walk ||
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
    public function get_row_class($row) {
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
    public function set_count_sql($sql, array $params = null) {
        $this->countsql = $sql;
        $this->countparams = $params;
    }

    /**
     * Set the sql to query the db. Query will be :
     *      SELECT $fields FROM $from WHERE $where
     * Of course you can use sub-queries, JOINS etc. by putting them in the
     * appropriate clause of the query.
     */
    public function set_sql($fields, $from, $where, array $params = array()) {
        $this->sql = (object) [
            'fields' => $fields,
            'from' => $from,
            'where' => $where,
            'params' => $params,
        ];
    }

    /**
     * Get the SQL configuration for this table.
     *
     * @return stdClass|null
     */
    public function get_sql(): ?stdClass {
        return $this->sql;
    }

    /**
     * Query the db. Store results in the table object for use by build_table.
     *
     * @param int $pagesize size of page for paginated displayed table.
     * @param bool $useinitialsbar do you want to use the initials bar. Bar
     * will only be used if there is a fullname column defined for the table.
     */
    public function query_db($pagesize, $useinitialsbar=true) {
        global $DB;

        if (!$this->is_downloading()) {
            if ($this->countsql === null) {
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

                $total = $DB->count_records_sql($this->countsql, $this->countparams);
            } else {
                $total = $grandtotal;
            }

            $this->pagesize($pagesize, $total);
        }

        // Fetch the attempts.
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
    public function out($pagesize, $useinitialsbar, $downloadhelpbutton='') {
        global $DB;

        if (!$this->columns) {
            $onerow = $DB->get_record_sql(
                "SELECT {$this->sql->fields} FROM {$this->sql->from} WHERE {$this->sql->where}",
                $this->sql->params,
                IGNORE_MULTIPLE
            );
            // If columns is not set then define columns as the keys of the rows returned from the db.
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
