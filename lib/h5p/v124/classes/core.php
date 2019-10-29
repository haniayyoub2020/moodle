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
 * H5P player class.
 *
 * @package    hvp_v124
 * @copyright  2019 Sara Arjona <sara@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace hvp_v124;

use H5PCore;
use stdClass;
use moodle_url;

defined('MOODLE_INTERNAL') || die();

/**
 * H5P player class, for displaying any local H5P content.
 *
 * @package    hvp_v124
 * @copyright  2019 Sara Arjona <sara@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core extends \H5PCore implements \core_h5p\core {

    /* @var array The list of libraries installed */
    protected $libraries;

    /**
     * Get the URL subpath of the dependency.
     *
     * @param array $dependency The details of the dependency to find
     * @return string The URL subpath
     */
    protected function getDependencyPath(array $dependency): string {
        $library = $this->find_library($dependency);

        return "libraries/{$library->id}/{$library->machinename}-{$library->majorversion}.{$library->minorversion}";
    }

    /**
     * Find the specified dependency.
     *
     * @param array $dependency The details of the dependency to find
     * @return stdClass The row in the h5p_libraries table
     */
    protected function find_library(array $dependency): ?stdClass {
        global $DB;
        if (null === $this->libraries) {
            $this->libraries = $DB->get_records('h5p_libraries');
        }

        $major = $dependency['majorVersion'];
        $minor = $dependency['minorVersion'];
        $patch = $dependency['patchVersion'];

        foreach ($this->libraries as $library) {
            if ($library->machinename !== $dependency['machineName']) {
                continue;
            }

            if ($library->majorversion != $major) {
                continue;
            }
            if ($library->minorversion != $minor) {
                continue;
            }
            if ($library->patchversion != $patch) {
                continue;
            }

            return $library;
        }

        return null;
    }

    /**
     * Get the list of JS scripts to include on the page.
     */
    public static function get_scripts(): array {
        global $PAGE;

        $jsrev = $PAGE->requires->get_jsrev();
        $urls = [];
        foreach (self::$scripts as $script) {
            $urls[] = autoloader::get_h5p_core_library_url($script, [
                'ver' => $jsrev,
            ]);
        }
        $urls[] = new moodle_url("/h5p/js/h5p_overrides.js", [
            'ver' => $jsrev,
        ]);

        return $urls;
    }

    public function get_dependency_roots(int $id): array {
        $roots = [];
        $dependencies = $this->h5pF->loadContentDependencies($id);
        $context = \context_system::instance();
        foreach ($dependencies as $dependency) {
            $library = $this->find_library($dependency);
            $roots[self::libraryToString($dependency, true)] = (moodle_url::make_pluginfile_url(
                $context->id,
                'core_h5p',
                'libraries',
                $library->id,
                "/" . self::libraryToString($dependency, true),
                ''
            ))->out(false);
        }

        return $roots;
    }
}
