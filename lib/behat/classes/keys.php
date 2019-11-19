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
 * Behat key translation.
 *
 * @package    core_behat
 * @category   test
 * @copyright  2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_behat;

use Facebook\WebDriver\WebDriverKeys;
use UnexpectedValueException;

/**
 * Behat key translation.
 *
 * @package    core_behat
 * @category   test
 * @copyright  2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class keys {
    const ARROW_DOWN = 'ARROW_DOWN';
    const ARROW_LEFT = 'ARROW_LEFT';
    const ARROW_RIGHT = 'ARROW_RIGHT';
    const ARROW_UP = 'ARROW_UP';
    const BACKSPACE = 'BACKSPACE';
    const ENTER = 'ENTER';
    const ESCAPE = 'ESCAPE';
    const RETURN_KEY = 'RETURN_KEY';
    const SHIFT = 'SHIFT';
    const SPACE = 'SPACE';
    const TAB = 'TAB';

    /**
     * Return the translated version of a key for use with a keyUp, keyDown, or keyPress.
     *
     * @param string $value The individual key descriptor
     * @return string the translated version of that key
     */
    public static function translate_key(string $value): string {
        $accessor = WebDriverKeys::class . "::{$value}";
        if (defined($accessor)) {
            return constant($accessor);
        }

        throw new UnexpectedValueException("Unknown key translation for {$value}");
    }
}
