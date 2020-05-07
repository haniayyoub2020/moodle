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
 * DML read/read-write database handle use tests
 *
 * @package    core
 * @category   dml
 * @copyright  2018 Srdjan Janković, Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/fixtures/read_slave_moodle_database.php');

/**
 * Database driver test class that exposes table_names()
 *
 * @package    core
 * @category   dml
 * @copyright  2018 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class read_slave_moodle_database_table_names extends read_slave_moodle_database {
    /**
     * @var string
     */
    protected $prefix = 't_';

    /**
     * Upgrade to public
     * @param string $sql
     * @return array
     */
    public function table_names(string $sql) : array {
        return parent::table_names($sql);
    }
}

/**
 * DML read/read-write database handle use tests
 *
 * @package    core
 * @category   dml
 * @copyright  2018 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_dml_read_slave_testcase extends base_testcase {

    /** @var float */
    static private $dbreadonlylatency = 0.8;

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
     * Instantiates a test database interface object.
     *
     * @param bool $wantlatency
     * @param mixed $readonly
     * @return read_slave_moodle_database $db
     */
    public function new_db(
        $wantlatency=false,
        $readonly=[
            ['dbhost' => 'test_ro1', 'dbport' => 1, 'dbuser' => 'test1', 'dbpass' => 'test1'],
            ['dbhost' => 'test_ro2', 'dbport' => 2, 'dbuser' => 'test2', 'dbpass' => 'test2'],
            ['dbhost' => 'test_ro3', 'dbport' => 3, 'dbuser' => 'test3', 'dbpass' => 'test3'],
        ]
    ) {
        $dbhost = 'test_rw';
        $dbname = 'test';
        $dbuser = 'test';
        $dbpass = 'test';
        $prefix = 'test_';
        $dboptions = ['readonly' => ['instance' => $readonly, 'exclude_tables' => ['exclude']]];
        if ($wantlatency) {
            $dboptions['readonly']['latency'] = self::$dbreadonlylatency;
        }

        $db = new read_slave_moodle_database();
        $db->connect($dbhost, $dbuser, $dbpass, $dbname, $prefix, $dboptions);
        return $db;
    }

    /**
     * Asert that the mock handle returned from read_slave_moodle_database methods
     * is a readonly slave handle.
     *
     * @param string $handle
     * @return void
     */
    private function assert_readonly_handle($handle) {
        $this->assertRegExp('/^test_ro\d:\d:test\d:test\d$/', $handle);
    }

    /**
     * Test moodle_read_slave_trait::table_names() query parser.
     *
     * @return void
     */
    public function test_table_names() {
        $t = [
            "SELECT *
             FROM {user} u
             JOIN (
                 SELECT DISTINCT u.id FROM {user} u
                 JOIN {user_enrolments} ue1 ON ue1.userid = u.id
                 JOIN {enrol} e ON e.id = ue1.enrolid
                 WHERE u.id NOT IN (
                     SELECT DISTINCT ue.userid FROM {user_enrolments} ue
                     JOIN {enrol} e ON (e.id = ue.enrolid AND e.courseid = 1)
                     WHERE ue.status = 'active'
                       AND e.status = 'enabled'
                       AND ue.timestart < now()
                       AND (ue.timeend = 0 OR ue.timeend > now())
                 )
             ) je ON je.id = u.id
             JOIN (
                 SELECT DISTINCT ra.userid
                   FROM {role_assignments} ra
                  WHERE ra.roleid IN (1, 2, 3)
                    AND ra.contextid = 'ctx'
              ) rainner ON rainner.userid = u.id
              WHERE u.deleted = 0" => [
                'user',
                'user',
                'user_enrolments',
                'enrol',
                'user_enrolments',
                'enrol',
                'role_assignments',
            ],
        ];

        $db = new read_slave_moodle_database_table_names();
        foreach ($t as $sql => $tables) {
            $this->assertEquals($tables, $db->table_names($db->fix_sql_params($sql)[0]));
        }
    }

    /**
     * Test correct database handles are used in a read-read-write-read scenario.
     * Test lazy creation of the write handle.
     *
     * @return void
     */
    public function test_read_read_write_read() {
        $DB = $this->new_db(true);

        $this->assertEquals(0, $DB->perf_get_reads_slave());
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->get_records('table');
        $this->assert_readonly_handle($handle);
        $readsslave = $DB->perf_get_reads_slave();
        $this->assertGreaterThan(0, $readsslave);
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->get_records('table2');
        $this->assert_readonly_handle($handle);
        $readsslave = $DB->perf_get_reads_slave();
        $this->assertGreaterThan(1, $readsslave);
        $this->assertNull($DB->get_dbhwrite());

        $now = microtime(true);
        $handle = $DB->insert_record_raw('table', array('name' => 'blah'));
        $this->assertEquals('test_rw::test:test', $handle);

        if (microtime(true) - $now < self::$dbreadonlylatency) {
            $handle = $DB->get_records('table');
            $this->assertEquals('test_rw::test:test', $handle);
            $this->assertEquals($readsslave, $DB->perf_get_reads_slave());

            sleep(1);
        }

        $handle = $DB->get_records('table');
        $this->assert_readonly_handle($handle);
        $this->assertEquals($readsslave + 1, $DB->perf_get_reads_slave());
    }

    /**
     * Test correct database handles are used in a read-write-write scenario.
     *
     * @return void
     */
    public function test_read_write_write() {
        $DB = $this->new_db();

        $this->assertEquals(0, $DB->perf_get_reads_slave());
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->get_records('table');
        $this->assert_readonly_handle($handle);
        $readsslave = $DB->perf_get_reads_slave();
        $this->assertGreaterThan(0, $readsslave);
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->insert_record_raw('table', array('name' => 'blah'));
        $this->assertEquals('test_rw::test:test', $handle);

        $handle = $DB->update_record_raw('table', array('id' => 1, 'name' => 'blah2'));
        $this->assertEquals('test_rw::test:test', $handle);
        $this->assertEquals($readsslave, $DB->perf_get_reads_slave());
    }

    /**
     * Test correct database handles are used in a write-read-read scenario.
     *
     * @return void
     */
    public function test_write_read_read() {
        $DB = $this->new_db();

        $this->assertEquals(0, $DB->perf_get_reads_slave());
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->insert_record_raw('table', array('name' => 'blah'));
        $this->assertEquals('test_rw::test:test', $handle);
        $this->assertEquals(0, $DB->perf_get_reads_slave());

        sleep(1);
        $handle = $DB->get_records('table');
        $this->assertEquals('test_rw::test:test', $handle);
        $this->assertEquals(0, $DB->perf_get_reads_slave());

        $handle = $DB->get_records('table2');
        $this->assert_readonly_handle($handle);
        $this->assertEquals(1, $DB->perf_get_reads_slave());

        $handle = $DB->get_records_sql("SELECT * FROM {table2} JOIN {table}");
        $this->assertEquals('test_rw::test:test', $handle);
        $this->assertEquals(1, $DB->perf_get_reads_slave());
    }

    /**
     * Test readonly handle is not used for reading from temptables.
     *
     * @return void
     */
    public function test_read_temptable() {
        $DB = $this->new_db();
        $DB->add_temptable('temptable1');

        $this->assertEquals(0, $DB->perf_get_reads_slave());
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->get_records('temptable1');
        $this->assertEquals('test_rw::test:test', $handle);
        $this->assertEquals(0, $DB->perf_get_reads_slave());

        $DB->delete_temptable('temptable1');
    }

    /**
     * Test readonly handle is not used for reading from excluded tables.
     *
     * @return void
     */
    public function test_read_excluded_tables() {
        $DB = $this->new_db();

        $this->assertEquals(0, $DB->perf_get_reads_slave());
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->get_records('exclude');
        $this->assertEquals('test_rw::test:test', $handle);
        $this->assertEquals(0, $DB->perf_get_reads_slave());
    }

    /**
     * Test readonly handle is not used during transactions.
     * Test last written time is adjusted post-transaction,
     * so the latency parameter is applied properly.
     *
     * @return void
     */
    public function test_transaction() {
        $DB = $this->new_db(true);

        $this->assertNull($DB->get_dbhwrite());

        $transaction = $DB->start_delegated_transaction();
        $now = microtime(true);
        $handle = $DB->get_records_sql("SELECT * FROM {table}");
        // Use rw handle during transaction.
        $this->assertEquals('test_rw::test:test', $handle);

        $handle = $DB->insert_record_raw('table', array('name' => 'blah'));
        // Introduce delay so we can check that table write timestamps
        // are adjusted properly.
        sleep(1);
        $transaction->allow_commit();
        // This condition should always evaluate true, however we need to
        // safeguard from an unaccounted delay that can break this test.
        if (microtime(true) - $now < 1 + self::$dbreadonlylatency) {
            // Not enough time passed, use rw handle.
            $handle = $DB->get_records_sql("SELECT * FROM {table}");
            $this->assertEquals('test_rw::test:test', $handle);

            // Make sure enough time passes.
            sleep(1);
        }

        // Exceeded latency time, use ro handle.
        $handle = $DB->get_records_sql("SELECT * FROM {table}");
        $this->assert_readonly_handle($handle);
    }

    /**
     * Test failed readonly connection falls back to write connection.
     *
     * @return void
     */
    public function test_read_only_conn_fail() {
        $DB = $this->new_db(false, 'test_ro_fail');

        $this->assertEquals(0, $DB->perf_get_reads_slave());
        $this->assertNotNull($DB->get_dbhwrite());

        $handle = $DB->get_records('table');
        $this->assertEquals('test_rw::test:test', $handle);
        $readsslave = $DB->perf_get_reads_slave();
        $this->assertEquals(0, $readsslave);
    }

    /**
     * In multiple slaves scenario, test failed readonly connection falls back to
     * another readonly connection.
     *
     * @return void
     */
    public function test_read_only_conn_first_fail() {
        $DB = $this->new_db(false, ['test_ro_fail', 'test_ro_ok']);

        $this->assertEquals(0, $DB->perf_get_reads_slave());
        $this->assertNull($DB->get_dbhwrite());

        $handle = $DB->get_records('table');
        $this->assertEquals('test_ro_ok::test:test', $handle);
        $readsslave = $DB->perf_get_reads_slave();
        $this->assertEquals(1, $readsslave);
    }
}
