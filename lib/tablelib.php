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
 * Trait to assist in the deprecation of table_sql and flexible_table.
 *
 * @package     core
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
trait deprecated_tablelib_class {
    /** @var string[] A list of properties which have been renamed as part of the class move procedure. */
    protected $renamedproperties = [
        'column_style' => 'columnstyle',
        'column_class' => 'columnclass',
        'column_suppress' => 'columnsuppress',
        'column_nosort' => 'columnnosort',
        'column_textsort' => 'columntextsort',
        'is_collapsible' => 'collapsible',
        'is_sortable' => 'sortable',
        'use_pages' => 'usepages',
        'use_initials' => 'useinitials',
        'sort_default_order' => 'defaultsortorder',
        'sort_default_column' => 'defaultsortcolumn',
        'started_output' => 'outputstarted',
    ];

    /** @var string[] A list of properties whose visibility has been reduced as part of the class move procedure. */
    protected $propertyvisibilitychanges = [
        'attributes',
        'baseurl',
        'column_class',
        'column_nosort',
        'column_style',
        'column_suppress',
        'column_textsort',
        'columns',
        'currentrow',
        'currpage',
        'download',
        'downloadable',
        'exportclass',
        'headers',
        'is_collapsible',
        'is_sortable',
        'maxsortkeys',
        'pagesize',
        'request',
        'setup',
        'showdownloadbuttonsat',
        'sort_default_column',
        'sort_default_order',
        'started_output',
        'totalrows',
        'uniqueid',
        'use_initials',
        'use_pages',
    ];

    /**
     * Set a property.
     *
     * Note: This is only called for inaccessible properties.
     * That is, properties which are either protected, private, or have not been defined on the class.
     *
     * @param string $name The name of the property being set
     * @param mixed $value The value to set
     */
    public function __set(string $name, $value): void {
        if (!property_exists($this, $name)) {
            // This property has not been defined on the object.
            // PHP just allows this to be set and it becomes an implicitly-defined public property.
            $this->{$name} = $value;
        } else if (array_key_exists($name, $this->propertyvisibilitychanges)) {
            // The property visibility was changed.
            // For now we allow the set of the property to preserve b/c.

            if (array_key_exists($name, $this->renamedproperties)) {
                // The property was also renamed.
                $name = $this->renamedproperties[$name];
            }

            $this->{$name} = $value;
        } else if (array_key_exists($name, $this->renamedproperties)) {
            // The property has not had its visibility changed, but it has been renamed.
            // Return the state of the new name.
            $name = $this->renamedproperties[$name];

            $this->{$name} = $value;
        } else {
            throw new \Error("Cannot access protected or private property for " . __CLASS__ . '::$' . $name, E_USER_ERROR);
        }
    }

    /**
     * Get the value of a property.
     *
     * Note: This is only called for inaccessible properties.
     * That is, properties which are either protected, private, or have not been defined on the class.
     *
     * @param string $name The name of the property being set
     * @return mixed
     */
    public function __get(string $name) {
        if (array_key_exists($name, $this->propertyvisibilitychanges)) {
            // The property visibility was changed.
            // For now we are fetching the property to preserve b/c.

            if (array_key_exists($name, $this->renamedproperties)) {
                // The property was also renamed.
                $name = $this->renamedproperties[$name];
            }

            return $this->{$name};
        } else if (array_key_exists($name, $this->renamedproperties)) {
            // The property has not had its visibility changed, but it has been renamed.
            // Return the state of the new name.
            $name = $this->renamedproperties[$name];

            return $this->{$name};
        }

        trigger_error('Undefined property: ' . __CLASS__ . '::$' . $name, E_USER_NOTICE);
    }

    /**
     * Check whether the property is set.
     *
     * Note: This is only called for inaccessible properties.
     * That is, properties which are either protected, private, or have not been defined on the class.
     *
     * @param string $name The name of the property being checked
     * @return bool
     */
    public function __isset(string $name): bool {
        // If the property visibility has changed, then set the property anyway for b/c.
        if (array_key_exists($name, $this->propertyvisibilitychanges)) {
            // The property visibility was changed.
            // For now we are updating the property to preserve b/c.

            if (array_key_exists($name, $this->renamedproperties)) {
                // The property was also renamed.
                $name = $this->renamedproperties[$name];
            }

            return isset($this->{$name});
        } else if (array_key_exists($name, $this->renamedproperties)) {
            // The property has not had its visibility changed, but it has been renamed.
            // Return the state of the new name.
            $name = $this->renamedproperties[$name];
            return isset($this->{$name});
        }

        // Fall back on default.
        return false;
    }

    /**
     * Unset the property.
     *
     * Note: This is only called for inaccessible properties.
     * That is, properties which are either protected, private, or have not been defined on the class.
     *
     * @param string $name The name of the property to unset
     */
    public function __unset(string $name): void {
        if (!property_exists($this, $name)) {
            // This property has not been defined on the object.
            // PHP just allows this to be unset.
            unset($this->{$name});
        } else if (array_key_exists($name, $this->propertyvisibilitychanges)) {
            // The property visibility was changed.
            // For now we allow the unset of the property to preserve b/c.

            if (array_key_exists($name, $this->renamedproperties)) {
                // The property was also renamed.
                $name = $this->renamedproperties[$name];
            }

            unset($this->{$name});
        } else if (array_key_exists($name, $this->renamedproperties)) {
            // The property has not had its visibility changed, but it has been renamed.
            $name = $this->renamedproperties[$name];

            unset($this->{$name});
        } else {
            // Mimic the default behaviour.
            throw new \Error("Cannot access protected or private property for " . __CLASS__ . '::$' . $name, E_USER_ERROR);
        }
    }
}

/**
 * A basic flexible table which uses static data, and supports sort, export, and basic column control.
 *
 * @package     core
 * @copyright   1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class flexible_table extends \core_table\flexible_table {
    use \deprecated_tablelib_class;

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
