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
 * RequireJS helper functions.
 *
 * @package    core
 * @copyright  2015 Damyon Wiese <damyon@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Collection of requirejs related methods.
 *
 * @copyright  2015 Damyon Wiese <damyon@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_requirejs {

    /**
     * Check a single module exists and return the full path to it.
     *
     * The expected location for amd modules is:
     *  <componentdir>/amd/src/modulename.js
     *
     * @param string $component The component determines the folder the js file should be in.
     * @param string $jsfilename The filename for the module (with the js extension).
     * @param boolean $debug If true, returns the paths to the original (unminified) source files.
     * @return array $files An array of mappings from module names to file paths.
     *                      Empty array if the file does not exist.
     */
    public static function find_one_amd_module($component, $jsfilename, $debug = false) : array {
        $moduleconfig = self::find_one_module($component, $jsfilename);

        if (null === $moduleconfig) {
            // Nothing found.
            return [];
        }

        $modname = $moduleconfig->modname;
        if ($moduleconfig->legacy && $debug) {
            return [
                $modname => $moduleconfig->src,
            ];
        } else {
            return [
                $modname => $moduleconfig->build,
            ];
        }
    }

    /**
     * Scan the source for AMD modules and return them all.
     *
     * The expected location for amd modules is:
     *  <componentdir>/amd/src/modulename.js
     *
     * @param boolean $unused.
     * @param boolean $includelazy If true, includes modules with the -lazy suffix.
     * @return array $files An array of mappings from module names to file paths.
     */
    public static function find_all_amd_modules($debug = false, $includelazy = false) : array {
        return array_filter(array_map(function($module) use ($debug, $includelazy) {
            if ($module->lazy && !$includelazy) {
                return false;
            }
            if ($module->legacy && $debug) {
                return $module->src;
            } else {
                return $module->build;
            }
        }, self::find_all_modules()));
    }


    /**
     * Check a single module exists and return the full path to it.
     *
     * The expected location for amd modules is:
     *  <componentdir>/amd/src/modulename.js
     *
     * @param string $component The component determines the folder the js file should be in.
     * @param string $jsfilename The filename for the module (with the js extension).
     * @return array $files An array of mappings from module names to file paths.
     *                      Empty array if the file does not exist.
     */
    public static function find_one_module($component, $jsfilename) :? \stdClass {
        $jsfileroot = core_component::get_component_directory($component);
        if (!$jsfileroot) {
            return [];
        }

        $modname = str_replace('.min.js', '', $jsfilename);
        $modname = str_replace('.js', '', $modname);

        $legacy = false;
        $es6 = "{$jsfileroot}/amd/build/{$modname}.es6.js";
        $pre6 = "{$jsfileroot}/amd/build/{$modname}.min.js";
        if (file_exists($es6)) {
            $build = $es6;
        } else if (file_exists($pre6)) {
            $build = $pre6;
            $legacy = true;
        } else {
            return null;
        }

        $srcfile = "{$jsfileroot}/amd/src/{$modname}.js";
        return (object) [
            'modname' => "{$component}/{$modname}",
            'src' => $srcfile,
            'build' => $build,
            'legacy' => $legacy,
            'lazy' => (substr($srcfile, -8) !== '-lazy.js'),
        ];
    }

    /**
     * Scan the source for AMD modules and return them all.
     *
     * The expected location for amd modules is:
     *  <componentdir>/amd/src/modulename.js
     *
     * @return array $files An array of mappings from module names to file paths.
     */
    public static function find_all_modules() : array {
        global $CFG;

        $jsdirs = array();
        $jsfiles = array();

        $dir = $CFG->libdir . '/amd';
        if (!empty($dir) && is_dir($dir)) {
            $jsdirs['core'] = $dir;
        }
        $subsystems = core_component::get_core_subsystems();
        foreach ($subsystems as $subsystem => $dir) {
            if (!empty($dir) && is_dir($dir . '/amd')) {
                $jsdirs['core_' . $subsystem] = $dir . '/amd';
            }
        }
        $plugintypes = core_component::get_plugin_types();
        foreach ($plugintypes as $type => $dir) {
            $plugins = core_component::get_plugin_list_with_file($type, 'amd', false);
            foreach ($plugins as $plugin => $dir) {
                if (!empty($dir) && is_dir($dir)) {
                    $jsdirs[$type . '_' . $plugin] = $dir;
                }
            }
        }

        foreach ($jsdirs as $component => $dir) {
            $src = self::find_all_src_js_in_dir($component, "{$dir}/src");
            $build = self::find_all_built_js_in_dir($component, "{$dir}/build");
            foreach ($build as $module => $file) {
                $jsfiles[$module] = (object) [
                    'modname' => $module,
                    'src' => $src[$module],
                    'build' => $file,
                    'legacy' => ('.es6.js' !== substr($file, 0 - strlen('.es6.js'))),
                    'lazy' => ('-lazy.js' === substr($src[$module], 0 - strlen('-lazy.js'))),
                ];
            }
        }

        return $jsfiles;
    }

    /**
     * Find all JS files in the specified directory.
     *
     * @param   string  $component
     * @param   string  $dir
     * @return  array
     */
    protected static function find_all_built_js_in_dir(string $component, string $dir) : array {
        $jsfiles = [];

        if (!is_dir($dir) || !is_readable($dir)) {
            // This is probably an empty amd directory without a build directory.
            // Skip it - RecursiveDirectoryIterator fatals if the directory is not readable as an iterator.
            return $jsfiles;
        }

        $items = new RecursiveDirectoryIterator($dir);
        $es6extension = '.es6';
        foreach ($items as $item) {
            $extension = $item->getExtension();
            if ($extension !== 'js') {
                // Not a JS file.
                continue;
            }

            $basename = $item->getBaseName('.js');
            $legacy = false;
            if ('.es6' === substr($basename, -4)) {
                $modulename = str_replace('.es6', '', $basename);
            } else {
                $modulename = str_replace('.min', '', $basename);
                $legacy = true;
            }

            // The fully qualified module name is prefixed with the component.
            $fqmodulename = "{$component}/{$modulename}";
            if ($legacy && array_key_exists($fqmodulename, $jsfiles)) {
                // This is a 'legacy' version of the built file and a non-legacy version exists.
                // The non-legacy version is used in preference.
                continue;
            }

            $jsfiles[$fqmodulename] = $item->getRealPath();
            unset($item);
        }

        return $jsfiles;
    }

    /**
     * Find all JS files in the specified directory.
     *
     * @param   string  $component
     * @param   string  $srcdir
     * @return  array
     */
    protected static function find_all_src_js_in_dir(string $component, string $srcdir) : array {
        $jsfiles = [];

        if (!is_dir($srcdir) || !is_readable($srcdir)) {
            // This is probably an empty amd directory without a src directory.
            // Skip it - RecursiveDirectoryIterator fatals if the directory is not readable as an iterator.
            return $jsfiles;
        }

        $items = new RecursiveDirectoryIterator($srcdir);
        foreach ($items as $item) {
            $extension = $item->getExtension();
            if ($extension !== 'js') {
                continue;
            }

            $modulename = $component . '/' . $item->getBaseName('.js');
            $jsfiles[$modulename] = $item->getRealPath();
            unset($item);
        }

        return $jsfiles;
    }

}
