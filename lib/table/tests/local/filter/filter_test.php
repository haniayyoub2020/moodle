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
 * Unit tests for core_table\local\filter\filter.
 *
 * @package   core_table
 * @category  test
 * @copyright 2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

declare(strict_types = 1);

namespace core_table\local\filter;

use advanced_testcase;
use InvalidArgumentException;

/**
 * Unit tests for core_table\local\filter\filter.
 *
 * @package   core_table
 * @category  test
 * @copyright 2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_test extends advanced_testcase {
    /**
     * Test that the constructor correctly handles a number of conditions.
     *
     * @dataProvider constructor_provider
     */
    public function test_constructor(array $args, int $jointype, array $values): void {
        $filter = new filter(...$args);

        // We should always get a filter.
        $this->assertInstanceOf(filter::class, $filter);

        // We should always get the correct join type.
        $this->assertEquals($jointype, $filter->get_join_type());

        // The values should be the expected ones.
        $this->assertSame($values, $filter->get_filter_values());
    }

    /**
     * Data provider for the constructor providing a range of valid constructor arguments.
     *
     * @return array
     */
    public function constructor_provider(): array {
        return [
            'Name without values' => [['keyword'], filter::JOINTYPE_DEFAULT, []],
            'Name with valid join type ANY' => [[
                'keyword',
                filter::JOINTYPE_ANY,
            ], filter::JOINTYPE_ANY, []],
            'Name with valid join type ALL' => [[
                'keyword',
                filter::JOINTYPE_ALL,
            ], filter::JOINTYPE_ALL, []],
            'Name with valid join type NONE' => [[
                'keyword',
                filter::JOINTYPE_NONE,
            ], filter::JOINTYPE_NONE, []],
            'Name, no join type, with set of values' => [
                [
                    'keyword',
                    null,
                    [
                        's1',
                        'janine',
                    ],
                ],
                filter::JOINTYPE_DEFAULT,
                [
                    'janine',
                    's1',
                ],
            ],
            'Name, and ANY, with set of values' => [
                [
                    'keyword',
                    filter::JOINTYPE_ANY,
                    [
                        's1',
                        'kevin',
                        'james',
                        'janine',
                    ],
                ],
                filter::JOINTYPE_ANY,
                [
                    'james',
                    'janine',
                    'kevin',
                    's1',
                ],
            ],
            'Name, and ANY, with set of values which contains duplicates' => [
                [
                    'keyword',
                    filter::JOINTYPE_ANY,
                    [
                        's1',
                        'kevin',
                        'james',
                        'janine',
                        'kevin',
                    ],
                ],
                filter::JOINTYPE_ANY,
                [
                    'james',
                    'janine',
                    'kevin',
                    's1',
                ],
            ],
        ];
    }

    /**
     * Test that the constructor throws a relevant exception when passed an invalid join.
     *
     * @dataProvider constructor_invalid_join_provider
     */
    public function test_constructor_invalid_joins($jointype): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid join type specified');

        new filter('invalid', $jointype);
    }

    /**
     * Data provider for the constructor providing a range of invalid join types to the constructor.
     *
     * @return array
     */
    public function constructor_invalid_join_provider(): array {
        return [
            'Too low' => [-1],
            'Too high' => [4],
        ];
    }

    /**
     * Enusre that adding filter values works as expected.
     */
    public function test_add_filter_value(): void {
        $filter = new filter('example');

        // Initially an empty list.
        $this->assertEmpty($filter->get_filter_values());

        // Adding null should do nothing.
        $filter->add_filter_value(null);
        $this->assertEmpty($filter->get_filter_values());

        // Adding empty string should do nothing.
        $filter->add_filter_value('');
        $this->assertEmpty($filter->get_filter_values());

        // Adding a value should return that value.
        $filter->add_filter_value('rosie');
        $this->assertSame([
            'rosie',
        ], $filter->get_filter_values());

        // Adding a second value should add that value.
        // The values should sorted.
        $filter->add_filter_value('arthur');
        $this->assertSame([
            'arthur',
            'rosie',
        ], $filter->get_filter_values());

        // Adding a duplicate value should not lead to that value being added again.
        $filter->add_filter_value('arthur');
        $this->assertSame([
            'arthur',
            'rosie',
        ], $filter->get_filter_values());
    }

    /**
     * Ensure that it is possibly to set the join type.
     */
    public function test_set_join_type(): void {
        $filter = new filter('example');

        // Initial set with the default type should just work.
        // The setter should be chainable.
        $this->assertEquals($filter, $filter->set_join_type(filter::JOINTYPE_DEFAULT));
        $this->assertEquals(filter::JOINTYPE_DEFAULT, $filter->get_join_type());

        // It should be possible to update the join type later.
        $this->assertEquals($filter, $filter->set_join_type(filter::JOINTYPE_NONE));
        $this->assertEquals(filter::JOINTYPE_NONE, $filter->get_join_type());

        $this->assertEquals($filter, $filter->set_join_type(filter::JOINTYPE_ANY));
        $this->assertEquals(filter::JOINTYPE_ANY, $filter->get_join_type());

        $this->assertEquals($filter, $filter->set_join_type(filter::JOINTYPE_ALL));
        $this->assertEquals(filter::JOINTYPE_ALL, $filter->get_join_type());
    }

    /**
     * Ensure that it is not possible to provide a value out of bounds when setting the join type.
     */
    public function test_set_join_type_invalid_low(): void {
        $filter = new filter('example');

        // Valid join types are current 0, 1, or 2.
        // A value too low should be rejected.
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid join type specified");
        $filter->set_join_type(-1);
    }

    /**
     * Ensure that it is not possible to provide a value out of bounds when setting the join type.
     */
    public function test_set_join_type_invalid_high(): void {
        $filter = new filter('example');

        // Valid join types are current 0, 1, or 2.
        // A value too low should be rejected.
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid join type specified");
        $filter->set_join_type(4);
    }

    /**
     * Ensure that the name getter is callable.
     */
    public function test_get_name(): void {
        $filter = new filter('examplename');

        $this->assertEquals('examplename', $filter->get_name());
    }
}
