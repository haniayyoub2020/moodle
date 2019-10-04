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
 * This module will tie together all of the different calls the gradable module will make.
 *
 * @module     gradingform_rubric/rubric
 * @package    core_grades
 * @copyright  2019 Mathew May <mathew.solutions>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

export const init = (root) => {
    const domElement = document.getElementById(root);
    registerActionListeners(domElement);
    setInitialFocus(domElement);
};

const setInitialFocus = domElement => {
    domElement.querySelectorAll('.criterion').forEach(criterion => {
        if (!criterion.querySelector('[tabindex="0"]')) {
            criterion.querySelector('.level').setAttribute('tabindex', 0);
        }
    });
};

const registerActionListeners = (domElement) => {
    domElement.addEventListener('click', (e) => {
        const button = e.target.closest('.level');
        if (button) {
            levelClick(button);
        }
    });

    domElement.addEventListener('keydown', e => {
        const target = e.target;
        if (!target.matches('.level')) {
            return;
        }

        const targetLevel = target.closest('.level');
        const allLevels = target.closest('.criterion').querySelectorAll('.level');
        const currentIndex = Array.from(allLevels).indexOf(targetLevel);
        const maxIndex = allLevels.length - 1;
        let newIndex = currentIndex;
        if (e.keyCode === 38) {
            // Go to previous.
            newIndex--;
            e.preventDefault();
        } else if (e.keyCode === 40) {
            // Go to next.
            newIndex++;
            e.preventDefault();
        }

        if (newIndex < 0) {
            newIndex = maxIndex;
        } else if (newIndex > maxIndex) {
            newIndex = 0;
        }

        levelClick(allLevels[newIndex]);
    });
};

const levelClick = (target) => {
    const clickedLevel = target.closest('.level');
    target.closest('.criterion').querySelectorAll('.level').forEach(level => {
        const radio = level.querySelector('input[type=radio]');
        if (level.isEqualNode(clickedLevel)) {
            level.classList.add('checked');
            level.setAttribute('aria-checked', 'true');
            level.setAttribute('tabindex', 0);
            radio.setAttribute('checked', 'true');
            level.focus();
        } else {
            level.classList.remove('checked');
            level.setAttribute('aria-checked', 'false');
            level.setAttribute('tabindex', -1);
            radio.removeAttribute("checked");
        }
    });
};
