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
 * Enhancements to Bootstrap components for accessibility.
 *
 * @module     theme_boost/aria
 * @copyright  2018 Damyon Wiese <damyon@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/pending'], function($) {
    return {
        init: function() {
            // Drop downs from bootstrap don't support keyboard accessibility by default.
            var focusEnd = false,
                setFocusEnd = function() {
                    focusEnd = true;
                },
                getFocusEnd = function() {
                    var result = focusEnd;
                    focusEnd = false;
                    return result;
                };

            // Special handling for "up" keyboard control.
            $('[data-toggle="dropdown"]').keydown(function(e) {
                var trigger = e.which || e.keyCode,
                    expanded;

                // Up key opens the menu at the end.
                if (trigger == 38) {
                    // Focus the end of the menu, not the beginning.
                    setFocusEnd();
                }

                // Escape key only closes the menu, it doesn't open it.
                if (trigger == 27) {
                    expanded = $(e.target).attr('aria-expanded');
                    e.preventDefault();
                    if (expanded == "false") {
                        $(e.target).click();
                    }
                }

                // Space key or Enter key opens the menu.
                if (trigger == 32 || trigger == 13) {
                    // Cancel random scroll.
                    e.preventDefault();
                    // Open the menu instead.
                    $(e.target).click();
                }
            });

            $('.dropdown').on('shown.bs.dropdown', function(e) {
                // We need to focus on the first menuitem.
                var menu = $(e.target).find('[role="menu"]'),
                    menuItems = false,
                    foundMenuItem = false;

                if (menu) {
                    menuItems = $(menu).find('[role="menuitem"]');
                }
                if (menuItems && menuItems.length > 0) {
                    if (getFocusEnd()) {
                        foundMenuItem = menuItems[menuItems.length - 1];
                    } else {
                        // The first menu entry, pretty reasonable.
                        foundMenuItem = menuItems[0];
                    }
                }
                if (foundMenuItem) {
                    foundMenuItem.focus();
                }
            });
            // Search for menu items by finding the first item that has
            // text starting with the typed character (case insensitive).
            $('.dropdown [role="menu"] [role="menuitem"]').keypress(function(e) {
                var trigger = String.fromCharCode(e.which || e.keyCode),
                    menu = $(e.target).closest('[role="menu"]'),
                    i = 0,
                    menuItems = false,
                    item,
                    itemText;

                if (!menu) {
                    return;
                }
                menuItems = $(menu).find('[role="menuitem"]');
                if (!menuItems) {
                    return;
                }

                trigger = trigger.toLowerCase();
                for (i = 0; i < menuItems.length; i++) {
                    item = $(menuItems[i]);
                    itemText = item.text().trim().toLowerCase();
                    if (itemText.indexOf(trigger) == 0) {
                        item.focus();
                        break;
                    }
                }
            });

            // Keyboard navigation for arrow keys, home and end keys.
            $('.dropdown [role="menu"] [role="menuitem"]').keydown(function(e) {
                var trigger = e.which || e.keyCode,
                    menu = $(e.target).closest('[role="menu"]'),
                    menuItems = false;
                if (!menu) {
                    return;
                }
                menuItems = $(menu).find('[role="menuitem"]').filter(':visible');
                if (!menuItems) {
                    return;
                }

                var currentIndex = menuItems.index(e.target);
                var sortedMenuItems = menuItems.toArray();
                var searchList = $.merge(sortedMenuItems.slice(currentIndex + 1), sortedMenuItems.slice(0, currentIndex));

                // Down key.
                if (trigger == 40) {
                    if (searchList.length > 1) {
                        e.preventDefault();
                        searchList[0].focus();
                    }
                } else if (trigger == 38) {
                    // Up key.
                    searchList = searchList.reverse();
                    if (searchList.length > 1) {
                        e.preventDefault();
                        searchList[0].focus();
                    }

                } else if (trigger == 36) {
                    // Home key.
                    e.preventDefault();
                    menuItems[0].focus();

                } else if (trigger == 35) {
                    // End key.
                    e.preventDefault();
                    menuItems[menuItems.length - 1].focus();
                }
                return;
            });
            $('.dropdown').on('hidden.bs.dropdown', function(e) {
                // We need to focus on the menu trigger.
                var trigger = $(e.target).find('[data-toggle="dropdown"]');
                if (trigger) {
                    trigger.focus();
                }
            });

            // After page load, focus on any element with special autofocus attribute.
            window.addEventListener("load", () => {
                const alerts = document.querySelectorAll('[data-aria-autofocus="true"][role="alert"]');
                Array.prototype.forEach.call(alerts, autofocusElement => {
                    // According to the specification an role="alert" region is only read out on change to the content
                    // of that region.
                    autofocusElement.innerHTML += ' ';
                    autofocusElement.removeAttribute('data-aria-autofocus');
                });
            });
        }
    };
});
