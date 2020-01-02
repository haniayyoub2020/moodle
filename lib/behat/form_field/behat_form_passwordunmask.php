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
 * Silly behat_form_select extension.
 *
 * @package    core_form
 * @category   test
 * @copyright  2013 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_text.php');
require_once(__DIR__ . '/../classes/keys.php');

use core_behat\keys;

/**
 * Allows interaction with passwordunmask form fields.
 *
 * Plain behat_form_select extension as it is the same
 * kind of field.
 *
 * @package    core_form
 * @category   test
 * @copyright  2013 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_form_passwordunmask extends behat_form_text {
    /**
     * Sets the value to a field.
     *
     * @param string $value
     * @return void
     */
    public function set_value($value) {
        if ($this->running_javascript()) {
            $id = $this->field->getAttribute('id');
            $js = <<<JS
require(["jquery"], function($) {
    var wrapper = $(document.getElementById("{$id}")).closest('[data-passwordunmask="wrapper"]');
        wrapper.find('[data-passwordunmask="edit"]').trigger("click");
});
JS;
            $this->session->executeScript($js);
        }
        $this->wait_for_pending_js();

        $this->field->setValue($value);

        // Ensure all pending JS is finished.
        if ($this->running_javascript()) {
            // Press enter key after setting password, so we have a stable page.
            $this->field->keyDown(keys::translate_key(keys::ENTER));
            $this->wait_for_pending_js();
            try {
                $this->field->keyUp(keys::translate_key(keys::ENTER));
            } catch (\Exception $e) {
                // Some elements are removed when the enter/escape/blur happens so keyUp is optional.
            }
        }
    }
}
