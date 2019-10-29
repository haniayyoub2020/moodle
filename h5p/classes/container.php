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
 * H5P container class.
 *
 * @package    core_h5p
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_h5p;

defined('MOODLE_INTERNAL') || die();

/**
 * H5P container class.
 *
 * @package    core_h5p
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class container {
    /**
     * Get a versioned factory for loading H5P pieces.
     *
     * @return factory
     */
    public static function get_factory(?string $version = null): factory {
        $classname = self::get_version_factory_classname($version);
        if (class_exists($classname)) {
            return new $classname();
        }

        throw new \coding_exception("Unable to find version {$version} of h5p");
    }

    public static function version_exists(?string $version = null): bool {
        $classname = self::get_version_factory_classname($version);
        return class_exists($classname);
    }

    protected static function get_version_factory_classname(?string $version = null): string {
        if (null === $version) {
            $version = static::get_latest_version_plugin_name();
        }

        $version = self::normalise_version_string($version);
        return "\\hvp_v{$version}\\factory";
    }

    protected  static function normalise_version_string(string $version): string {
        return str_replace('.', '', $version);
    }

    /**
     * Get the latest supported version of h5p.
     *
     * @return strign The version string.
     */
    public static function get_latest_version(): string {
        // TODO
        return "1.24";
    }

    /**
     * Get the latest supported version of h5p.
     *
     * @return strign The version string.
     */
    public static function get_latest_version_plugin_name(): string {
        // TODO
        return "124";
    }
}
