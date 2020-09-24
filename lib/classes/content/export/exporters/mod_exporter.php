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
 * Activity module exporter for shared activity content for the content API.
 *
 * @package     core
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\content\export\exporters;

use core\content\export\exported_item;

/**
 * Activity module exporter for shared activity content for the content API.
 *
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class mod_exporter extends mod_instance_exporter {

    /**
     * Export the list of exportable items.
     *
     * @param   exportable_item[] $export_exportables
     */
    public function export_exportables(array $exportables): void {
        global $PAGE;

        $templatedata = (object) [
            'link' => $this->cm->url,
            'name' => $this->cm->get_formatted_name(),
            'intro' => null,
            'sections' => [],
        ];

        if (plugin_supports('mod', $this->cm->modname, FEATURE_MOD_INTRO, true)) {
            $templatedata->intro = $this->get_intro_data($this->context, $this->cm);
        }

        $exporteditems = [];
        foreach ($exportables as $exportable) {
            $exporteditem = $exportable->add_to_archive($this->get_archive());
            $templatedata->sections[] = $exporteditem->get_template_data();
        }

        // Add the index to the archive.
        $this->archive->add_file_from_template(
            $this->context,
            'index.html',
            'core/content/export/module_index',
            $templatedata
        );
    }

    /**
     * Get the course introduction data.
     *
     * @return  null|string The content of the intro area
     */
    protected function get_intro_data(): ?string {
        global $DB;

        $record = $DB->get_record($this->cm->modname, ['id' => $this->cm->instance], 'intro');

        $exporteditem = $this->get_archive()->add_pluginfiles_for_content(
            $this->context,
            '',
            $record->intro,
            "mod_{$this->cm->modname}",
            'intro',
            0,
            null
        );

        if ($exporteditem->has_any_data()) {
            return $exporteditem->get_content();
        }

        return null;
    }
}
