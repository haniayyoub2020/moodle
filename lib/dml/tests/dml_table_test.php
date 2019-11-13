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
 * DML Table tests.
 *
 * @package    core_dml
 * @category   phpunit
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use \core\dml\table;

/**
 * DML Table tests.
 *
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \core\dml\table
 */
class core_dml_table_testcase extends database_driver_testcase {

    /**
     * Data provider for various \core\dml\table method tests.
     *
     * @return  array
     */
    public function get_field_select_provider() : array {
        return [
            'single field' => [
                'tablename' => 'test_table_single',
                'fieldlist' => [
                    'id' => ['id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null],
                ],
                'primarykey' => 'id',
                'fieldprefix' => 'ban',
                'tablealias' => 'banana',
                'banana.id AS banid',
            ],
            'multiple fields' => [
                'tablename' => 'test_table_multiple',
                'fieldlist' => [
                    'id' => ['id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null],
                    'course' => ['course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0'],
                    'name' => ['name', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                ],
                'primarykey' => 'id',
                'fieldprefix' => 'ban',
                'tablealias' => 'banana',
                'banana.id AS banid, banana.course AS bancourse, banana.name AS banname',
            ],
            'long field name test' => [
                'tablename' => 'test_table_long',
                'fieldlist' => [
                    'id' => ['id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null],
                    'thisisareallylongnamewithchars' => ['thisisareallylongnamewithchars', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                ],
                'primarykey' => 'id',
                'fieldprefix' => 'ban',
                'tablealias' => 'banana',
                'banana.id AS banid, banana.thisisareallylongnamewithchars AS banthisisareallylongnamewithcha',
            ],
            'long field name test similar names' => [
                'tablename' => 'test_table_long',
                'fieldlist' => [
                    'id' => ['id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null],
                    'thisisareallylongnamewithchara' => ['thisisareallylongnamewithchara', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharb' => ['thisisareallylongnamewithcharb', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharc' => ['thisisareallylongnamewithcharc', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchard' => ['thisisareallylongnamewithchard', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchare' => ['thisisareallylongnamewithchare', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharf' => ['thisisareallylongnamewithcharf', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharg' => ['thisisareallylongnamewithcharg', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharh' => ['thisisareallylongnamewithcharh', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchari' => ['thisisareallylongnamewithchari', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharj' => ['thisisareallylongnamewithcharj', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchark' => ['thisisareallylongnamewithchark', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharl' => ['thisisareallylongnamewithcharl', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                ],
                'primarykey' => 'id',
                'fieldprefix' => 'ban',
                'tablealias' => 'banana',
                'banana.id AS banid, ' .
                'banana.thisisareallylongnamewithchara AS banthisisareallylongnamewithcha, ' .
                'banana.thisisareallylongnamewithcharb AS banthisisareallylongnamewithch0, ' .
                'banana.thisisareallylongnamewithcharc AS banthisisareallylongnamewithch1, ' .
                'banana.thisisareallylongnamewithchard AS banthisisareallylongnamewithch2, ' .
                'banana.thisisareallylongnamewithchare AS banthisisareallylongnamewithch3, ' .
                'banana.thisisareallylongnamewithcharf AS banthisisareallylongnamewithch4, ' .
                'banana.thisisareallylongnamewithcharg AS banthisisareallylongnamewithch5, ' .
                'banana.thisisareallylongnamewithcharh AS banthisisareallylongnamewithch6, ' .
                'banana.thisisareallylongnamewithchari AS banthisisareallylongnamewithch7, ' .
                'banana.thisisareallylongnamewithcharj AS banthisisareallylongnamewithch8, ' .
                'banana.thisisareallylongnamewithchark AS banthisisareallylongnamewithch9, ' .
                'banana.thisisareallylongnamewithcharl AS banthisisareallylongnamewithc10' .
                '',
            ],
        ];
    }

    /**
     * Ensure that \core\dml\table::get_field_select() works as expected.
     *
     * @dataProvider get_field_select_provider
     * @covers ::get_field_select
     * @param   string      $tablename The name of the table
     * @param   array       $fieldlist The list of fields
     * @param   string      $primarykey The name of the primary key
     * @param   string      $fieldprefix The prefix to use for each field
     * @param   string      $tablealias The table AS alias name
     * @param   string      $expected The expected SQL
     */
    public function test_get_field_select(
        string $tablename,
        array $fieldlist,
        string $primarykey,
        string $fieldprefix,
        string $tablealias,
        string $expected
    ) {
        $dbman = $this->tdb->get_manager();

        $xmldbtable = new xmldb_table($tablename);
        $xmldbtable->setComment("This is a test'n drop table. You can drop it safely");

        foreach ($fieldlist as $args) {
            call_user_func_array([$xmldbtable, 'add_field'], $args);
        }
        $xmldbtable->add_key('primary', XMLDB_KEY_PRIMARY, [$primarykey]);
        $dbman->create_table($xmldbtable);

        $table = new table($tablename, $tablealias, $fieldprefix);
        $this->assertEquals($expected, $table->get_field_select());
    }

    /**
     * Data provider for \core\dml\table::extract_from_result() tests.
     *
     * @return  array
     */
    public function extract_from_result_provider() : array {
        return [
            'single table' => [
                'fieldlist' => [
                    'id' => ['id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null],
                    'course' => ['course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0'],
                    'flag' => ['flag', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                ],
                'primarykey' => 'id',
                'prefix' => 's',
                'result' => (object) [
                    'sid' => 1,
                    'scourse' => 42,
                    'sflag' => 'foo',
                ],
                'expectedrecord' => (object) [
                    'id' => 1,
                    'course' => 42,
                    'flag' => 'foo',
                ],
            ],
            'single table amongst others' => [
                'fieldlist' => [
                    'id' => ['id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null],
                    'course' => ['course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0'],
                    'flag' => ['flag', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                ],
                'primarykey' => 'id',
                'prefix' => 's',
                'result' => (object) [
                    'sid' => 1,
                    'scourse' => 42,
                    'sflag' => 'foo',
                    'oid' => 'id',
                    'ocourse' => 'course',
                    'oflag' => 'flag',
                ],
                'expectedrecord' => (object) [
                    'id' => 1,
                    'course' => 42,
                    'flag' => 'foo',
                ],
            ],
            'long field name test similar names' => [
                'fieldlist' => [
                    'id' => ['id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null],
                    'thisisareallylongnamewithchara' => ['thisisareallylongnamewithchara', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharb' => ['thisisareallylongnamewithcharb', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharc' => ['thisisareallylongnamewithcharc', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchard' => ['thisisareallylongnamewithchard', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchare' => ['thisisareallylongnamewithchare', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharf' => ['thisisareallylongnamewithcharf', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharg' => ['thisisareallylongnamewithcharg', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharh' => ['thisisareallylongnamewithcharh', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchari' => ['thisisareallylongnamewithchari', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharj' => ['thisisareallylongnamewithcharj', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithchark' => ['thisisareallylongnamewithchark', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                    'thisisareallylongnamewithcharl' => ['thisisareallylongnamewithcharl', XMLDB_TYPE_CHAR, '255', null, null, null, 'lala'],
                ],
                'primarykey' => 'id',
                'prefix' => 'ban',
                'result' => (object) [
                    'banid' => 19,
                    'banthisisareallylongnamewithcha' => 'a',
                    'banthisisareallylongnamewithch0' => 'b',
                    'banthisisareallylongnamewithch1' => 'c',
                    'banthisisareallylongnamewithch2' => 'd',
                    'banthisisareallylongnamewithch3' => 'e',
                    'banthisisareallylongnamewithch4' => 'f',
                    'banthisisareallylongnamewithch5' => 'g',
                    'banthisisareallylongnamewithch6' => 'h',
                    'banthisisareallylongnamewithch7' => 'i',
                    'banthisisareallylongnamewithch8' => 'j',
                    'banthisisareallylongnamewithch9' => 'k',
                    'banthisisareallylongnamewithc10' => 'l',
                ],
                'expectedrecord' => (object) [
                    'id' => 19,
                    'thisisareallylongnamewithchara' => 'a',
                    'thisisareallylongnamewithcharb' => 'b',
                    'thisisareallylongnamewithcharc' => 'c',
                    'thisisareallylongnamewithchard' => 'd',
                    'thisisareallylongnamewithchare' => 'e',
                    'thisisareallylongnamewithcharf' => 'f',
                    'thisisareallylongnamewithcharg' => 'g',
                    'thisisareallylongnamewithcharh' => 'h',
                    'thisisareallylongnamewithchari' => 'i',
                    'thisisareallylongnamewithcharj' => 'j',
                    'thisisareallylongnamewithchark' => 'k',
                    'thisisareallylongnamewithcharl' => 'l',
                ],
            ],
        ];
    }

    /**
     * Ensure that \core\dml\table::extract_from_result() works as expected.
     *
     * @dataProvider        extract_from_result_provider
     * @covers ::extract_from_result
     * @param   array       $fieldlist The list of fields
     * @param   string      $primarykey The name of the primary key
     * @param   string      $fieldprefix The prefix to use for each field
     * @param   stdClass    $result The result of the get_records_sql
     * @param   stdClass    $expected The expected output
     */
    public function test_extract_fields_from_result(
        array $fieldlist,
        string $primarykey,
        string $fieldprefix,
        stdClass $result,
        stdClass $expected
    ) {
        $dbman = $this->tdb->get_manager();

        $tablename = 'test_table_extraction';
        $xmldbtable = new xmldb_table($tablename);
        $xmldbtable->setComment("This is a test'n drop table. You can drop it safely");

        foreach ($fieldlist as $args) {
            call_user_func_array([$xmldbtable, 'add_field'], $args);
        }
        $xmldbtable->add_key('primary', XMLDB_KEY_PRIMARY, [$primarykey]);
        $dbman->create_table($xmldbtable);

        $table = new table($tablename, 'footable', $fieldprefix);
        $this->assertEquals($expected, $table->extract_from_result($result));
    }

    /**
     * Ensure that \core\dml\table::get_from_sql() works as expected.
     *
     * @dataProvider get_field_select_provider
     * @covers ::get_from_sql
     * @param   string      $tablename The name of the table
     * @param   array       $fieldlist The list of fields
     * @param   string      $primarykey The name of the primary key
     * @param   string      $fieldprefix The prefix to use for each field
     * @param   string      $tablealias The table AS alias name
     * @param   string      $expected The expected SQL
     */
    public function test_get_from_sql(
        string $tablename,
        array $fieldlist,
        string $primarykey,
        string $fieldprefix,
        string $tablealias,
        string $expected
    ) {
        $dbman = $this->tdb->get_manager();

        $tablename = 'test_table_extraction';
        $xmldbtable = new xmldb_table($tablename);
        $xmldbtable->setComment("This is a test'n drop table. You can drop it safely");

        foreach ($fieldlist as $args) {
            call_user_func_array([$xmldbtable, 'add_field'], $args);
        }
        $xmldbtable->add_key('primary', XMLDB_KEY_PRIMARY, [$primarykey]);
        $dbman->create_table($xmldbtable);

        $table = new table($tablename, $tablealias, $fieldprefix);

        $this->assertEquals("{{$tablename}} {$tablealias}", $table->get_from_sql());
    }
}
