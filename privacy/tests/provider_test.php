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
 * Privacy manager unit tests.
 *
 * @package     core_privacy
 * @copyright   2018 Jake Dallimore <jrhdallimore@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use \core_privacy\manager;

/**
 * Privacy manager unit tests.
 *
 * @copyright   2018 Jake Dallimore <jrhdallimore@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider_testcase extends advanced_testcase {
    /**
     * Returns a list of frankenstyle names of core components (plugins and subsystems).
     *
     * @return array the array of frankenstyle component names with the relevant class name.
     */
    public function get_component_list() {
        $components = [];
        // Get all plugins.
        $plugintypes = \core_component::get_plugin_types();
        foreach ($plugintypes as $plugintype => $typedir) {
            $plugins = \core_component::get_plugin_list($plugintype);
            foreach ($plugins as $pluginname => $plugindir) {
                $frankenstyle = $plugintype . '_' . $pluginname;
                $components[$frankenstyle] = [
                    'component' => $frankenstyle,
                    'classname' => manager::get_provider_classname_for_component($frankenstyle),
                ];

            }
        }
        // Get all subsystems.
        foreach (\core_component::get_core_subsystems() as $name => $path) {
            if (isset($path)) {
                $frankenstyle = 'core_' . $name;
                $components[$frankenstyle] = [
                    'component' => $frankenstyle,
                    'classname' => manager::get_provider_classname_for_component($frankenstyle),
                ];
            }
        }
        return $components;
    }

    /**
     * Test that the specified null_provider works as expected.
     *
     * @dataProvider null_provider_provider
     * @param   string  $component The name of the component.
     * @param   string  $classname The name of the class for privacy
     */
    public function test_null_provider($component, $classname) {
        $reason = $classname::get_reason();
        $this->assertInternalType('string', $reason);

        $this->assertInternalType('string', get_string($reason, $component));
        $this->assertDebuggingNotCalled();
    }

    /**
     * Data provider for the null_provider tests.
     *
     * @return array
     */
    public function null_provider_provider() {
        return array_filter($this->get_component_list(), function($component) {
                return static::component_implements(
                    $component['classname'],
                    \core_privacy\local\metadata\null_provider::class);
            });
    }

    /**
     * Checks whether the component's provider class implements the specified interface, either directly or as a grandchild.
     *
     * @param   string  $providerclass The name of the class to test.
     * @param   string  $interface the name of the interface we want to check.
     * @return  bool    Whether the class implements the interface.
     */
    protected static function component_implements($providerclass, $interface) {
        if (class_exists($providerclass)) {
            $rc = new \ReflectionClass($providerclass);
            return $rc->implementsInterface($interface);
        }

        return false;
    }

}
