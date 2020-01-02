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
 * Custom interaction with inplace editable elements.
 *
 * @package    core_form
 * @category   test
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_text.php');
require_once(__DIR__ . '/../classes/keys.php');

use core_behat\keys;

/**
 * Custom interaction with inplace editable elements.
 *
 * @package    core_form
 * @category   test
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_form_inplaceeditable extends behat_form_text {
    /**
     * Sets the value to a field.
     *
     * @param string $value
     * @return void
     */
    public function set_value($value) {
        if (!$this->running_javascript()) {
            throw new \coding_exception('Setting the value of an inplace editable field requires javascript.');
        }

        $initialvalue = $this->field->getValue();

        // Clear the existing value.
        for ($i = 0; $i < strlen($initialvalue); $i++) {
            $this->field->keyDown(keys::translate_key(keys::BACKSPACE));
            $this->field->keyUp(keys::translate_key(keys::BACKSPACE));
        }

        // Type in the new value.
        $keys = array_filter(str_split($value));
        foreach ($keys as $key) {
            $this->field->keyDown($key);
            $this->field->keyUp($key);
        }

        // Press enter key to save the value.
        // Note: Do not keyUp, because the field no longer exists.
        $this->field->keyDown(keys::translate_key(keys::ENTER));
    }
}
