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
 * Trait to assist with prevention of phpunit coverage for a set of tests.
 *
 * @package   core
 * @author    Andrew Nicols <andrew@nicols.co.uk>
 * @copyright 2019 Andrew Nicols
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use SebastianBergmann\Environment\Runtime;

trait prevent_coverage_trait {

    /** @var string The debugging tool used for opcache logging */
    private $loggingops = null;

    /**
     * Helper to prevent opcache logging if it is currently enabled.
     */
    public function prevent_opcache_logging() {
        $runtime = new Runtime();

        if (!$runtime->canCollectCodeCoverage()) {
            return;
        }

        if ($runtime->isPHPDBG()) {
            set_error_handler(function() {});
            if (phpdbg_end_oplog()) {
                $this->loggingops = 'phpdbg';
            }
            restore_error_handler();

            return;
        }

        if ($runtime->hasXdebug() && xdebug_code_coverage_started()) {
            // Pause coverage generation. Passing the `false` argument means that data will not be destroyed and it can
            // be resumed.
            xdebug_stop_code_coverage(false);

            $this->loggingops = 'xdebug';

            return;
        }

        if ($runtime->hasPCOV() && !empty(pcov\waiting())) {
            pcov\stop();

            $this->loggingops = 'pcov';

            return;
        }

    }

    /**
     * Helper to restart opcache logging if it is currently enabled.
     *
     * @after
     */
    public function restart_opcache_logging() {
        if ($this->loggingops) {
            switch($this->loggingops) {
                case 'pcov':
                    pcov\start()();
                    break;
                case 'phpdbg':
                    phpdbg_start_oplog();
                    break;
                case 'xdebug':
                    xdebug_start_code_coverage();
                    break;
            }

            unset($this->loggingops);
        }
    }
}
