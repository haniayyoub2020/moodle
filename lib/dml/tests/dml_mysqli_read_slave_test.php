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
 * DML read/read-write database handle tests for mysqli_native_moodle_database
 *
 * @package    core
 * @category   dml
 * @copyright  2018 Srdjan Janković, Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/../mysqli_native_moodle_database.php');
require_once(__DIR__.'/fixtures/test_moodle_read_slave_trait.php');

/**
 * Database driver mock test class that exposes some methods
 *
 * @package    core
 * @category   dml
 * @copyright  2018 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class read_slave_moodle_database_mock_mysqli extends mysqli_native_moodle_database {
    use test_moodle_read_slave_trait;

    /**
     * Return tables in database WITHOUT current prefix
     * @param bool $usecache if true, returns list of cached tables.
     * @return array of table names in lowercase and without prefix
     */
    public function get_tables($usecache = true) {
        if ($this->tables === null) {
            $this->tables = [];
        }
        return $this->tables;
    }

    /**
     * To be used by database_manager
     * @param string|array $sql query
     * @param array|null $tablenames an array of xmldb table names affected by this request.
     * @return bool true
     * @throws ddl_change_structure_exception A DDL specific exception is thrown for any errors.
     */
    public function change_database_structure($sql, $tablenames = null) {
        return true;
    }
}

/**
 * DML mysqli_native_moodle_database read slave specific tests
 *
 * @package    core
 * @category   dml
 * @copyright  2018 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_dml_mysqli_read_slave_testcase extends base_testcase {
    /**
     * Constructs a test case with the given name.
     *
     * @param string $name
     * @param array  $data
     * @param string $dataname
     */
    final public function __construct($name = null, array $data = array(), $dataname = '') {
        parent::__construct($name, $data, $dataname);

        $this->setBackupGlobals(false);
        $this->setBackupStaticAttributes(false);
        $this->setRunTestInSeparateProcess(false);
    }

    /**
     * Test readonly handle is not used for reading from special pg_*() call queries,
     * pg_try_advisory_lock and pg_advisory_unlock.
     *
     * @return void
     */
    public function test_lock() {
        $DB = new read_slave_moodle_database_mock_mysqli();

        $this->assertEquals(0, $DB->perf_get_reads_slave());

        $DB->query_start("SELECT GET_LOCK('lock',1)", null, SQL_QUERY_SELECT);
        $this->assertEquals('test_rw', $DB->get_db_handle());
        $DB->query_end(null);
        $this->assertEquals(0, $DB->perf_get_reads_slave());

        $DB->query_start("SELECT RELEASE_LOCK('lock',1)", null, SQL_QUERY_SELECT);
        $this->assertEquals('test_rw', $DB->get_db_handle());
        $DB->query_end(null);
        $this->assertEquals(0, $DB->perf_get_reads_slave());
    }
}
