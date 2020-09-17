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
 * Unit tests for \core\outputi\html_cleaner.
 *
 * @package     core
 * @category    test
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\output;

use advanced_testcase;
use DOMDocument;
use DOMText;

/**
 * Unit tests for format_text defined in weblib.php.
 *
 * @copyright 2015 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 */
class html_cleaner_testcase extends advanced_testcase {
    /**
     * Ensure that `create` fixes incorrect HTML content without applying additional fixse.
     *
     * @dataProvider clean_provider
     * @param   string $input
     * @param   bool $defaultfixes
     * @param   string $expected
     */
    public function test_clean(string $input, bool $defaultfixes, string $expected): void {
        $cleaner = html_cleaner::create($input, $defaultfixes);
        $this->assertEquals($expected, $cleaner->get_clean_html());
    }

    /**
     * Ensure that `fix` fixes incorrect HTML content.
     *
     * @dataProvider fix_default_options_provider
     * @param   string $input
     * @param   string $expected
     */
    public function test_fix(string $input, string $expected): void {
        // Note: All other options are disabled as they change the output in some way.
        $this->assertEquals($expected, html_cleaner::fix($input));
    }

    /**
     * Data provider for format_html() to ensure that all generated HTML is correctly balanced.
     *
     * @return  array
     */
    public function clean_provider(): array {
        return $this->all_fixes_provider();
    }

    /**
     * Data provider for the data providers.
     *
     * @return  array
     */
    protected function all_fixes_provider(): array {
        return [
            "Default applied: Good html doesn't change." => [
                '<div>Hello world</div><script type="text/javascript">alert("Hello");</script><!-- this comment is OK -->',
                true,
                '<div>Hello world</div><script type="text/javascript">alert("Hello");</script><!-- this comment is OK -->',
            ],
            "Default NOT applied: Good html doesn't change." => [
                '<div>Hello world</div><script type="text/javascript">alert("Hello");</script><!-- this comment is OK -->',
                false,
                '<div>Hello world</div><script type="text/javascript">alert("Hello");</script><!-- this comment is OK -->',
            ],
            'Default applied: Excess closing tags are removed' => [
                '<div>Hello world</div></div><div>OK</div></div></li></ul></ol></section>',
                true,
                '<div>Hello world</div><div>OK</div>',
            ],
            'Default NOT applied: Excess closing tags are removed' => [
                '<div>Hello world</div></div><div>OK</div></div></li></ul></ol></section>',
                false,
                '<div>Hello world</div><div>OK</div>',
            ],
            'Default applied: Unclosed comment tags are removed 1' => [
                "<div>Hello world</div><!-- style-junk:pasted; from:word;",
                true,
                "<div>Hello world</div>",
            ],
            'Default NOT applied: Unclosed comment tags are removed 1' => [
                "<div>Hello world</div><!-- style-junk:pasted; from:word;",
                false,
                "<div>Hello world</div>",
            ],
            'Default applied: Unclosed comment tags are removed 2' => [
                "<div><!-- bad comment </div><div>this will be removed</div>",
                true,
                "<div></div>",
            ],
            'Default NOT applied: Unclosed comment tags are removed 2' => [
                "<div><!-- bad comment </div><div>this will be removed</div>",
                false,
                "<div></div>",
            ],
            'Default applied: Unclosed script tags are balanced 1' => [
                '<div>Hello world</div><script type="text/javascript">alert("Hello");',
                true,
                '<div>Hello world</div><script type="text/javascript">alert("Hello");</script>',
            ],
            'Default NOT applied: Unclosed script tags are balanced 1' => [
                '<div>Hello world</div><script type="text/javascript">alert("Hello");',
                false,
                '<div>Hello world</div><script type="text/javascript">alert("Hello");</script>',
            ],
            'Default applied: Unclosed script tags are balanced 2' => [
                "<div>Hello world</div><script>alert('Hello');",
                true,
                "<div>Hello world</div><script>alert('Hello');</script>",
            ],
            'Default NOT applied: Unclosed script tags are balanced 2' => [
                "<div>Hello world</div><script>alert('Hello');",
                false,
                "<div>Hello world</div><script>alert('Hello');</script>",
            ],
            'Default applied: Tag attributes using single quotes are replaced with double quotes' => [
                "<div>Hello world</div><script type='text/javascript'>alert('Hello'),g",
                true,
                "<div>Hello world</div><script type=\"text/javascript\">alert('Hello'),g</script>",
            ],
            'Default NOT applied: Tag attributes using single quotes are replaced with double quotes' => [
                "<div>Hello world</div><script type='text/javascript'>alert('Hello'),g",
                false,
                "<div>Hello world</div><script type=\"text/javascript\">alert('Hello'),g</script>",
            ],
            'Default applied: Unclosed html gets balanced' => [
                "<ul><li><div>Hello world",
                true,
                "<ul><li><div>Hello world</div></li></ul>",
            ],
            'Default NOT applied: Unclosed html gets balanced' => [
                "<ul><li><div>Hello world",
                false,
                "<ul><li><div>Hello world</div></li></ul>",
            ],
            "Default applied: Prepared tags aren't confused with our placeholder prepared tags used in make_well_formed_html()." => [
                "<prepared>for anything</prepared><div>Hello world</div>",
                true,
                "<prepared>for anything</prepared><div>Hello world</div>",
            ],
            "Default NOT applied: Prepared tags aren't confused with our placeholder prepared tags used in make_well_formed_html()." => [
                "<prepared>for anything</prepared><div>Hello world</div>",
                false,
                "<prepared>for anything</prepared><div>Hello world</div>",
            ],
            'Default applied: List items are already in a list element #1' => [
                '<div><ul><li>Foo</li></ul><ol><li>Foo</li></ol><menu><li>Foo</li></menu><dir><li>Foo</li></dir></div>',
                true,
                '<div><ul><li>Foo</li></ul><ol><li>Foo</li></ol><menu><li>Foo</li></menu><dir><li>Foo</li></dir></div>',
            ],
            'Default NOT applied: List items are already in a list element #1' => [
                '<div><ul><li>Foo</li></ul><ol><li>Foo</li></ol><menu><li>Foo</li></menu><dir><li>Foo</li></dir></div>',
                false,
                '<div><ul><li>Foo</li></ul><ol><li>Foo</li></ol><menu><li>Foo</li></menu><dir><li>Foo</li></dir></div>',
            ],
        ];
    }

    /**
     * Data provider for the html_cleaner::fix() function to ensure that all generated HTML is correctly balanced, and
     * any standard fixes are applied.
     *
     * @return  array
     */
    public function fix_default_options_provider(): array {
        $cases = [];
        foreach ($this->all_fixes_provider() as $key => $value) {
            if ($value[1]) {
                $cases[$key] = [$value[0], $value[2]];
            }
        }

        return $cases;
    }

    /**
     * Ensure that the callback option can be used to manipulate the content.
     *
     * @dataProvider fix_callback_provider
     * @param   string $input
     * @param   callable $callback
     * @param   string $expected
     */
    public function test_apply_dom_document(string $input, callable $callback, string $expected): void {
        $cleaner = html_cleaner::create($input);
        $callback($cleaner->get_dom_document());
        $this->assertEquals($expected, $cleaner->get_clean_html());
    }

    /**
     * Data provider for the `fix` function which makes use of callbacks to further modify the the conte.
     *
     * @return  array
     */
    public function fix_callback_provider(): array {
        return [
            'Remove all IDs' => [
                '<div id="one"><h1 id="h1">Hello,</h1><h2 id="world">World!</h2></div>',
                function(DOMDocument $doc): void {
                    foreach ($doc->getElementsByTagName('*') as $tag) {
                        $tag->removeAttribute('id');
                    }
                },
                '<div><h1>Hello,</h1><h2>World!</h2></div>',
            ],
            'Convert aria-label to aria-labelledby' => [
                '<h1>Tiddlywinks</h1>' .
                        '<p>All about the game of Tiddlywinks' .
                        '<img src="/tiddlywinks.jpg" ' .
                        'aria-label="A game of Tiddlywinks being played by members of the Moodle Community"></p>',
                function(DOMDocument $doc): void {
                    foreach ($doc->getElementsByTagName('*') as $tag) {
                        if ($tag->hasAttribute('aria-label')) {
                            $label = $doc->createElement('span');
                            $label->setAttribute('class', 'sr-only');

                            // Note: In reality we would use something like uniqid for this.
                            $label->setAttribute('id', 'tiddles');

                            $label->appendChild(new DOMText($tag->getAttribute('aria-label')));
                            $label = $tag->parentNode->insertBefore($label, $tag);

                            $tag->removeAttribute('aria-label');
                            $tag->setAttribute('aria-labelledby', $label->getAttribute('id'));
                        }
                    }
                },
                '<h1>Tiddlywinks</h1>' .
                        '<p>All about the game of Tiddlywinks' .
                        '<span class="sr-only" id="tiddles">A game of Tiddlywinks being played by members of the Moodle Community</span>' .
                        '<img src="/tiddlywinks.jpg" aria-labelledby="tiddles">' .
                        '</p>',
            ],
        ];
    }
}
