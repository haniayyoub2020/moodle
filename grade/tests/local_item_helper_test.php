<?php declare(strict_types = 1);
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
 * Unit tests for core_grades\local\item\helper.
 *
 * @package   core_grades
 * @category  test
 * @copyright 2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

namespace tests\core_grades\local\item\item {
    use advanced_testcase;
    use core_grades\local\item\helper;
    use coding_exception;

    /**
     * Unit tests for core_grades\local\item\helper.
     *
     * @package   core_grades
     * @category  test
     * @copyright 2019 Andrew Nicols <andrew@nicols.co.uk>
     * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    class helper_test extends advanced_testcase {

        /**
         * Ensure that a component which does not implement the mapping class excepts.
         */
        public function test_get_mappings_for_component_does_not_exist() {
            $mappings = helper::get_mappings_for_component('invalid_component');
            $this->assertIsArray($mappings);
            $this->assertEmpty($mappings);
        }

        /**
         * Ensure that a component which does not implement the mapping class correctly excepts.
         */
        public function test_get_mappings_for_valid_component_invalid_mapping() {
            $this->expectException(coding_exception::class);
            helper::get_mappings_for_component('tests\core_grades\local\item\item\invalid');
        }

        /**
         * Ensure that a component which implements the mapping class correctly eets the correct set of mappings.
         */
        public function test_get_mappings_for_valid_component_valid_mapping() {
            $mapping = helper::get_mappings_for_component('tests\core_grades\local\item\item\valid');
            $this->assertIsArray($mapping);
            $this->assertEquals([
                0 => 'rating',
                1 => 'someother',
            ], $mapping);
        }

        /**
         * Data provider for get_field_name_for_itemnumber.
         *
         * @return array
         */
        public function get_field_name_for_itemnumber_provider(): array {
            return [
                'Valid itemnumber 0 case 1' => [
                    0,
                    'gradecat',
                    'gradecat',
                ],
                'Valid itemnumber 0 case 2' => [
                    0,
                    'melon',
                    'melon',
                ],
                'Valid itemnumber 1 case 1' => [
                    1,
                    'gradecat',
                    'gradecat_someother',
                ],
                'Valid itemnumber 1 case 2' => [
                    1,
                    'melon',
                    'melon_someother',
                ],
            ];
        }

        /**
         * Ensure that valid field names are correctly mapped for a valid component.
         *
         * @dataProvider get_field_name_for_itemnumber_provider
         */
        public function test_get_field_name_for_itemnumber(int $itemnumber, string $fieldname, string $expected): void {
            $component = 'tests\core_grades\local\item\item\valid';
            $this->assertEquals($expected, helper::get_field_name_for_itemnumber($component, $itemnumber, $fieldname));
        }

        /**
         * Ensure that an invalid itemnumber does not provide any field name.
         */
        public function test_get_field_name_for_itemnumber_invalid_itemnumber(): void {
            $component = 'tests\core_grades\local\item\item\valid';

            $this->expectException(coding_exception::class);
            helper::get_field_name_for_itemnumber($component, 100, 'gradecat');
        }

        /**
         * Ensure that a component which does not define a mapping can still get a mapping for itemnumber 0.
         */
        public function test_get_field_name_for_itemnumber_component_not_defining_mapping_itemnumber_zero(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->assertEquals('gradecat', helper::get_field_name_for_itemnumber($component, 0, 'gradecat'));
        }

        /**
         * Ensure that a component which does not define a mapping cannot get a mapping for itemnumber 1+.
         */
        public function test_get_field_name_for_itemnumber_component_not_defining_mapping_itemnumber_nonzero(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->expectException(coding_exception::class);
            helper::get_field_name_for_itemnumber($component, 100, 'gradecat');
        }

        /**
         * Ensure that a component which incorrectly defines a mapping cannot get a mapping for itemnumber 1+.
         */
        public function test_get_field_name_for_itemnumber_component_invalid_mapping_itemnumber_nonzero(): void {
            $component = 'tests\core_grades\local\item\item\invalid';

            $this->expectException(coding_exception::class);
            helper::get_field_name_for_itemnumber($component, 100, 'gradecat');
        }

        /**
         * Data provider for get_field_name_for_itemname.
         *
         * @return array
         */
        public function get_field_name_for_itemname_provider(): array {
            return [
                'Empty itemname empty case 1' => [
                    '',
                    'gradecat',
                    'gradecat',
                ],
                'Empty itemname empty case 2' => [
                    '',
                    'melon',
                    'melon',
                ],
                'First itemname empty case 1' => [
                    'rating',
                    'gradecat',
                    'gradecat',
                ],
                'First itemname empty case 2' => [
                    'rating',
                    'melon',
                    'melon',
                ],
                'Other itemname empty case 1' => [
                    'someother',
                    'gradecat',
                    'gradecat_someother',
                ],
                'Other itemname empty case 2' => [
                    'someother',
                    'melon',
                    'melon_someother',
                ],
            ];
        }

        /**
         * Ensure that valid field names are correctly mapped for a valid component.
         *
         * @dataProvider get_field_name_for_itemname_provider
         */
        public function test_get_field_name_for_itemname(string $itemname, string $fieldname, string $expected): void {
            $component = 'tests\core_grades\local\item\item\valid';
            $this->assertEquals($expected, helper::get_field_name_for_itemname($component, $fieldname, $itemname));
        }

        /**
         * Ensure that an invalid itemname does not provide any field name.
         */
        public function test_get_field_name_for_itemname_invalid_itemname(): void {
            $component = 'tests\core_grades\local\item\item\valid';

            $this->expectException(coding_exception::class);
            helper::get_field_name_for_itemname($component, 'gradecat', 'typo');
        }

        /**
         * Ensure that an empty itemname provides a matching fieldname regardless of whether the component exists or
         * not.
         */
        public function test_get_field_name_for_itemname_not_defining_mapping_empty_name(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->assertEquals('gradecat', helper::get_field_name_for_itemname($component, 'gradecat', ''));
        }

        /**
         * Ensure that an valid component with some itemname excepts.
         */
        public function test_get_field_name_for_itemname_not_defining_mapping_with_name(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->expectException(coding_exception::class);
            helper::get_field_name_for_itemname($component, 'gradecat', 'example');
        }

        /**
         * Ensure that an empty itemname provides a matching fieldname even if the mapping is invalid.
         */
        public function test_get_field_name_for_itemname_invalid_mapping_empty_name(): void {
            $component = 'tests\core_grades\local\item\item\invalid';

            $this->assertEquals('gradecat', helper::get_field_name_for_itemname($component, 'gradecat', ''));
        }

        /**
         * Ensure that an invalid mapping with some itemname excepts.
         */
        public function test_get_field_name_for_itemname_invalid_mapping_with_name(): void {
            $component = 'tests\core_grades\local\item\item\invalid';

            $this->expectException(coding_exception::class);
            helper::get_field_name_for_itemname($component, 'gradecat', 'example');
        }

        /**
         * Data provider for get_itemname_from_itemnumber.
         *
         * @return array
         */
        public function get_itemname_from_itemnumber_provider(): array {
            return [
                'Valid itemnumber 0' => [
                    0,
                    '',
                ],
                'Valid itemnumber 1' => [
                    1,
                    'someother',
                ],
            ];
        }

        /**
         * Ensure that item names are correctly mapped for a valid component.
         *
         * @dataProvider get_itemname_from_itemnumber_provider
         */
        public function test_get_itemname_from_itemnumber(int $itemnumber, string $expected): void {
            $component = 'tests\core_grades\local\item\item\valid';
            $this->assertEquals($expected, helper::get_itemname_from_itemnumber($component, $itemnumber));
        }

        /**
         * Ensure that an invalid itemnumber does not provide any field name.
         */
        public function test_get_itemname_from_itemnumber_invalid_itemnumber(): void {
            $component = 'tests\core_grades\local\item\item\valid';

            $this->expectException(coding_exception::class);
            helper::get_itemname_from_itemnumber($component, 100);
        }

        /**
         * Ensure that a component which does not define a mapping can still get a mapping for itemnumber 0.
         */
        public function test_get_itemname_from_itemnumber_component_not_defining_mapping_itemnumber_zero(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->assertEquals('', helper::get_itemname_from_itemnumber($component, 0));
        }

        /**
         * Ensure that a component which does not define a mapping cannot get a mapping for itemnumber 1+.
         */
        public function test_get_itemname_from_itemnumber_component_not_defining_mapping_itemnumber_nonzero(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->expectException(coding_exception::class);
            helper::get_itemname_from_itemnumber($component, 100);
        }

        /**
         * Ensure that a component which incorrectly defines a mapping cannot get a mapping for itemnumber 1+.
         */
        public function test_get_itemname_from_itemnumber_component_invalid_mapping_itemnumber_nonzero(): void {
            $component = 'tests\core_grades\local\item\item\invalid';

            $this->expectException(coding_exception::class);
            helper::get_itemname_from_itemnumber($component, 100);
        }

        /**
         * Data provider for get_itemname_from_itemnumber.
         *
         * @return array
         */
        public function get_itemnumber_from_itemname_provider(): array {
            return [
                'Empty itemname empty' => [
                    '',
                    0,
                ],
                'First itemname empty' => [
                    'rating',
                    0,
                ],
                'Other itemname empty' => [
                    'someother',
                    1,
                ],
            ];
        }

        /**
         * Ensure that valid item names are correctly mapped for a valid component.
         *
         * @dataProvider get_itemnumber_from_itemname_provider
         */
        public function test_get_itemnumber_from_itemname(string $itemname, int $expected): void {
            $component = 'tests\core_grades\local\item\item\valid';
            $this->assertEquals($expected, helper::get_itemnumber_from_itemname($component, $itemname));
        }

        /**
         * Ensure that an invalid itemname excepts.
         */
        public function test_get_itemnumber_from_itemname_invalid_itemname(): void {
            $component = 'tests\core_grades\local\item\item\valid';

            $this->expectException(coding_exception::class);
            helper::get_itemnumber_from_itemname($component, 'typo');
        }

        /**
         * Ensure that an empty itemname provides a correct itemnumber regardless of whether the component exists or
         * not.
         */
        public function test_get_itemnumber_from_itemname_not_defining_mapping_empty_name(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->assertEquals(0, helper::get_itemnumber_from_itemname($component, ''));
        }

        /**
         * Ensure that an valid component with some itemname excepts.
         */
        public function test_get_itemnumber_from_itemname_not_defining_mapping_with_name(): void {
            $component = 'tests\core_grades\local\item\item\othervalid';

            $this->expectException(coding_exception::class);
            helper::get_itemnumber_from_itemname($component, 'example');
        }

        /**
         * Ensure that an empty itemname provides a matching fieldname even if the mapping is invalid.
         */
        public function test_get_itemnumber_from_itemname_invalid_mapping_empty_name(): void {
            $component = 'tests\core_grades\local\item\item\invalid';

            $this->assertEquals(0, helper::get_itemnumber_from_itemname($component, ''));
        }

        /**
         * Ensure that an invalid mapping with some itemname excepts.
         */
        public function test_get_itemnumber_from_itemname_invalid_mapping_with_name(): void {
            $component = 'tests\core_grades\local\item\item\invalid';

            $this->expectException(coding_exception::class);
            helper::get_itemnumber_from_itemname($component, 'example');
        }
    }
}

namespace tests\core_grades\local\item\item\valid\grades {
    use core_grades\local\item\itemnumber_mapping;

    /**
     * Valid class for testing mappings.
     *
     * @package   core_grades
     * @category  test
     * @copyright 2019 Andrew Nicols <andrew@nicols.co.uk>
     * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    class gradeitems implements itemnumber_mapping {
        public static function get_mappings(): array {
            return [
                0 => 'rating',
                1 => 'someother',
            ];
        }
    }
}

namespace tests\core_grades\local\item\item\invalid\grades {
    use core_grades\local\item\itemnumber_mapping;

    /**
     * Invalid class for testing mappings.
     *
     * @package   core_grades
     * @category  test
     * @copyright 2019 Andrew Nicols <andrew@nicols.co.uk>
     * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    class gradeitems {
        public static function get_mappings(): array {
            return [
                0 => 'rating',
                1 => 'someother',
            ];
        }
    }
}
