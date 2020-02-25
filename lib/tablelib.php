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
 * @package    core
 * @subpackage lib
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

// Note: These contants will be deprecated in Moodle 4.0.
// Please use the new constants on core_table\flexible_table by the same name.
define('TABLE_VAR_SORT',   1);
define('TABLE_VAR_HIDE',   2);
define('TABLE_VAR_SHOW',   3);
define('TABLE_VAR_IFIRST', 4);
define('TABLE_VAR_ILAST',  5);
define('TABLE_VAR_PAGE',   6);
define('TABLE_VAR_RESET',  7);
define('TABLE_VAR_DIR',    8);
define('TABLE_P_TOP',    1);
define('TABLE_P_BOTTOM', 2);

/**
 * A basic flexible table which uses static data, and supports sort, export, and basic column control.
 *
 * @package     core
 * @copyright   1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class flexible_table extends \core_table\flexible_table {
    /**
     * Constructor for the flexible_table class.
     */
    public function __construct() {
        call_user_func_array([parent, '__construct'], func_get_args());

        if (!is_a($this, table_sql::class)) {
            debugging(
                'The flexible_table class has been deprecated in favour of \core_table\flexible_table. ' .
                'Please update your code to use the new class. ' .
                'Please note that many of the properties have been renamed.',
                DEBUG_DEVELOPER
            );
        }
    }
}

/**
 * A table offering the same functionality as the flexible_table but which uses data retrieved via SQL.
 *
 * @package     core_table
 * @copyright   1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class table_sql extends \core_table\sql_table {
    /**
     * Constructor for table_sql.
     */
    public function __construct() {
        call_user_func_array(['parent', '__construct'], func_get_args());

        debugging(
            'The table_sql class has been deprecated in favour of \core_table\sql_table. ' .
            'Please update your code to use the new class. ' .
            'Please note that many of the properties have been renamed.',
            DEBUG_DEVELOPER
        );
    }
}

/**
 * A data format for use in formatting of table data.
 *
 * @package   moodlecore
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class table_default_export_format_parent extends \core_table\local\dataformat {
    /**
     * Constructor for the table_default_export_format_parent class.
     */
    public function __construct() {
        call_user_func_array(['parent', '__construct'], func_get_args());

        if (!is_a($this, table_default_export_format_parent::class)) {
            debugging(
                'The table_default_export_format_parent class has been deprecated in favour of ' .
                '\core_table\local\dataformat. ' .
                'Please update your code to use the new class. ' .
                'Please note that many of the properties have been renamed.',
                DEBUG_DEVELOPER
            );
        }
    }
}

/**
 * Dataformat exporter
 *
 * @package    core
 * @subpackage tablelib
 * @copyright  2016 Brendan Heywood (brendan@catalyst-au.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class table_dataformat_export_format extends \core_table\local\dataformat {
    /**
     * Constructor for the table_default_export_format class.
     */
    public function __construct() {
        call_user_func_array([parent, '__construct'], func_get_args());

        if (!is_a($this, table_default_export_format::class)) {
            debugging(
                'The table_default_export_format class has been deprecated in favour of ' .
                '\core_table\local\dataformat\export. ' .
                'Please update your code to use the new class. ' .
                'Please note that many of the properties have been renamed.',
                DEBUG_DEVELOPER
            );
        }
    }
}
