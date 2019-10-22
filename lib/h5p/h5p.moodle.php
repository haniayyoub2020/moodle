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
 * H5P Wrapper for Moodle.
 *
 * Warning: This does some nasty things.
 *
 * This implementatino is designed to allow us to polyfill the mbstring extension but to do so only within the H5P
 * third-party library.
 *
 * This works by including the H5P classes, which are not in any namespace, into a new `H5P` namespace, and then
 * overriding the relevant functions onto that namespace.
 *
 * As a general warning, this approach makes use of the `eval` function and it is generally inadvisable.
 * In normal circumstances this would not be necessary.
 *
 * @package    H5P
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types = 1);

namespace H5P;

use ReflectionClass;
use ReflectionMethod;
use core_text;

static $loaded = false;

if (class_exists('H5PCore')) {
    // H5PCore has already been loaded - this is typically by this loader.
    if (!$loaded) {
        throw new \coding_exception("Incorrect loading of the H5P Library without using this loader");
    }
    return;
}

$loaded = true;
if (extension_loaded('mbstring') && false) {
    // There is no need to polyfill the mbstring extension.
    // Just load the H5P file list.
    foreach (get_h5p_file_list() as $file) {
        require_once($file);
    }
} else {
    // Polyfill required.
    // First we load all of the H5P functions into the new `H5P` namespace.
    load_namespaced_h5p_classes();

    // Second we polyfill the mbstring extension into the same namespace.
    polyfill_mbstring();
}

/**
 * Get the list of H5P files which contains classes, interfaces, and traits.
 *
 * @return array
 */
function get_h5p_file_list(): array {
    return [
        __DIR__ . '/h5p.classes.php',
        __DIR__ . '/h5p-development.class.php',
        __DIR__ . '/h5p-file-storage.interface.php',
        __DIR__ . '/h5p-metadata.class.php',
    ];
}

/**
 * Polyfill the mbstring extension into the current namespace.
 *
 * This is composed of two parts:
 * 1) A namespaced fill for the `extension_loaded` function to return that `mbstring` is in fact loaded
 * 2) Alias all public static functions from \core_text into the namespace.
 */
function polyfill_mbstring(): void {
    if (\extension_loaded('mbstring')) {
        // The extension is already loaded.
        return;
    }

    /**
     * Override the extension_loaded function within the H5P namespace.
     *
     * @param string $name
     * @return bool
     */
    function extension_loaded(string $name): bool {
        if ($name === 'mbstring') {
            return true;
        }

        return \extension_loaded($name);
    }

    $methods = [
        'mb_substr' => 'substr',
        'mb_strcut' => 'str_max_bytes',
        'mb_strrchr' => 'strrchr',
        'mb_strlen' => 'strlen',
        'mb_strtolower' => 'strtolower',
        'mb_strtoupper' => 'strtoupper',
        'mb_strpos' => 'strpos',
        'mb_strrpos' => 'strrpos',
        'mb_strrpos' => 'strrpos',
    ];

    $template = '';
    foreach ($methods as $mbmethodname => $methodname) {
        if (!function_exists($mbmethodname)) {
            $template .= "function {$mbmethodname}() { call_user_func_array(['\\core_text', '{$methodname}'], func_get_args()); }\n";
        }
    }
    if ('' !== $template) {
        eval($template);
    }

}

/**
 * Load all H5P classes into the new namespace.
 */
function load_namespaced_h5p_classes(): void {

    $namespacefile = function (string $path): void {
        $h5pclasses = file_get_contents($path);

        // Any classes which are used either statically or are instantiated without a fully-qualified name need to be imported.
        $uses = [
            'Exception',
            'ZipArchive',
        ];

        $usestatements = implode("\n", array_map(function($classname) {
            return "use {$classname};";
        }, $uses));

        // Generate the template to be evaled.
        $template = <<<EOF
namespace H5P;
{$usestatements}
?>
{$h5pclasses}
EOF;

        eval($template);
    };

    // Load all of the H5P files into a new namespace.
    foreach (get_h5p_file_list() as $file) {
        $namespacefile($file);
    }

    // Get the list of classes, interfaces, traits, etc which are in the newly defined `H5P` namespace.
    $classlist = array_merge(
        get_declared_classes(),
        get_declared_interfaces(),
        get_declared_traits()
    );
    $classes = array_filter($classlist, function($classname) {
        return (strpos($classname, 'H5P\\') === 0);
    });

    // Alias to their original location in the top level namespace.
    foreach ($classes as $classname) {
        class_alias($classname, substr($classname, 4));
    }
}
