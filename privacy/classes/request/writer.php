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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains the interface required to implmeent a content writer.
 *
 * @package core_privacy
 * @copyright 2018 Andrew Nicols <andrew@nicols.co.uk>
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_privacy\request;

/**
 * The writer factory class.
 *
 * @package core_privacy
 * @copyright 2018 Andrew Nicols <andrew@nicols.co.uk>
 */
class writer {

    protected static $instance = null;

    protected static $realwriter = null;

    /**
     * Constructor for the content writer.
     *
     * Protected to prevent direct instantiation.
     */
    protected function __construct() {}

    protected static function get_writer_instance() {
        if (null === static::$realwriter) {
            if (PHPUNIT_TEST) {
                // TODO Make a writer for unit tests.
                static::$realwriter = new moodle_content_writer(static::instance());
            } else {
                static::$realwriter = new moodle_content_writer(static::instance());
            }
        }

        return static::$realwriter;
    }

    public static final function instance() {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static final function reset() {
        self::$realwrite = null;
        self::$factory = null;
    }

    public function with_context(\context $context) {
        return writer::get_writer_instance()
            ->set_context($context)
            ;
    }
}
