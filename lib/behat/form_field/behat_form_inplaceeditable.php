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

        $this->execute('behat_general::i_click_on', [
            $this->field->find('css', 'a[data-action="edit"]'),
            'NodeElement',
        ]);

        // Use char 10 [Return] to save changes.
        $value .= chr(10);

        // We cannot use setValue because it explicitly sends a blur event, which does not work with inplace editable.
        $this->field->getSession()->getDriver()->getWebDriverSession()->activeElement()->postValue([
            'value' => str_split($value),
        ]);
    }

    /**
     * Normalise the value, removing any carriage return or line feeds.
     *
     * @param string $value
     * @return string
     */
    protected function normalise_value(string $value): string {
        if (substr($value, strlen(chr(10))) === chr(10)) {
            $value = substr($value, 0, 0 - strlen(chr(10)));
        }

        if (substr($value, strlen(chr(13))) === chr(13)) {
            $value = substr($value, 0, 0 - strlen(chr(13)));
        }

        return $value;
    }
}
