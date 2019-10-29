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
 * H5P Autoloader.
 *
 * @package    hvp_v124
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types = 1);

namespace hvp_v124;

use moodle_url;

/**
 * H5P Autoloader.
 *
 * @package    hvp_v124
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class autoloader extends \core_h5p\autoloader {
    /**
     * Get the current version of the H5P core library.
     *
     * @return string
     */
    final public static function get_h5p_version(): string {
        return '124';
    }

    /**
     * Return the list of classes with their location within the joubel directory.
     *
     * @return array
     */
    protected static function get_class_list(): array {
        return [
            'H5PCore' => 'h5p.classes.php',
            'H5PFrameworkInterface' => 'h5p.classes.php',
            'H5PContentValidator' => 'h5p.classes.php',
            'H5PValidator' => 'h5p.classes.php',
            'H5PStorage' => 'h5p.classes.php',
            'H5PDevelopment' => 'h5p-development.class.php',
            'H5PFileStorage' => 'h5p-file-storage.interface.php',
            'H5PMetadata' => 'h5p-metadata.class.php',
        ];
    }
}
