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
 * HTML Cleaner.
 *
 * @package     core
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\output;

use DOMDocument;

/**
 * An HTML Cleaner, and normaliser helper for Moodle.
 *
 * This class is typically called from within format_text and you should check whether format_text is a more appropriate
 * solution to your requirements.
 *
 * The html_cleaner uses libxml, and the PHP DOMDocument internally to parse HTML content, and return a normalised HTML
 * structure. Additional fixes for common mistakes and issues can also be applied.
 *
 * @package     core
 * @copyright   2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class html_cleaner {

    /** @var DOMDocument The Document to work with */
    protected $document = null;

    /** @var \LibXMLError[] array Errors retrieved when processing the document */
    protected $errors = [];

    /**
     * Constructor for the HTML cleaner.
     *
     * @param   string $html
     */
    public function __construct(string $html) {
        // Fetch previous libxml errors, and then disable standard libxml errors to enable user error handling.
        // When internal error handling is enabled, it is not possible to fetch users from the DOM Document.
        $previousinternalerrors = libxml_use_internal_errors(true);

        // Note: It is not possible to use LIBXML_HTML_NOIMPLIED as the content will be wrapped in the first element that is
        // found. For example, <h1>Welcome</h1><p>To Mars!</p> becomes <h1>Welcome<p>To Mars!</p></h1>, which would be
        // incorrect.
        $this->document = new DOMDocument();

        $header = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
        $footer = '</body></html>';
        $this->document->loadHTML($header . $html . $footer, LIBXML_HTML_NODEFDTD | LIBXML_BIGLINES);

        // Fetch any document processing errors.
        $this->errors = libxml_get_errors();

        // Clear the libxml error buffer and switch back to libxml internal errors.
        libxml_clear_errors();
        libxml_use_internal_errors($previousinternalerrors);
    }

    /**
     * Get the DOMDocument element.
     *
     * The `html_cleaner` uses a DOMDocument to allow normalisation, and specific fixes.
     *
     * In some situations you may want to perform additional fixes, in addition to those performed by the html_cleaner.
     * You can use the DOMDocument to perform these. For example, you may wish to modify all <a> elements to open in a
     * new window:
     *
     *      $cleaner = html_cleaner::create($html);
     *      $document = $cleaner->get_dom_document();
     *      $anchors = $document->getElementsByTagName('a');
     *      foreach ($anchors as $anchor) {
     *          $anchor->setAttribute('target', '_new');
     *      }
     *      $html = $document->get_clean_html();
     *
     * This can also be used to perform XPath selection:
     *
     *      $cleaner = html_cleaner::create($html);
     *      $document = $cleaner->get_dom_document();
     *      $finder = new DomXPath($document);
     *      // Find any element with a class 'nevershow'.
     *      $toremove = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' nevershow ')]");
     *      foreach ($toremove as $node) {
     *          $node->parentNode->removeChild($node);
     *      }
     *      $html = $document->get_clean_html();
     *
     * @return  DOMDocument
     */
    public function get_dom_document(): DOMDocument {
        return $this->document;
    }

    /**
     * Get the cleaned HTML content.
     *
     * @return  string
     */
    public function get_clean_html(): string {
        if (version_compare(PHP_VERSION, '7.3.0') >= 0) {
            // Grab just the body Node.
            $output = trim($this->document->saveHTML($this->document->getElementsByTagName('body')[0]));
        } else {
            // There is a bug in PHP Versions earlier than 7.3 whereby it is not possible to prevent formatting of output
            // when exporting a specific node.
            // See https://bugs.php.net/bug.php?id=76285 for further information.
            // TODO Remove as part of 3.11 release once PHP 7.2 is no longer supported.

            // Grab all of the content.
            $output = trim($this->document->saveHTML());
        }

        // Remove to the end of the <body> tag.
        $output = substr($output, strpos($output, '<body>') + strlen('<body>'));

        // Remove </body> to the end.
        $output = substr($output, 0, strpos($output, '</body>'));

        // Remove leading/trailing whitespace. DOMDocument adds \n chars around many tags.
        return trim($output);
    }

    /**
     * Get errors found during parsing of the document.
     *
     * @return  \LibXMLError[]
     */
    public function get_document_errors(): array {
        return $this->errors;
    }

    /**
     * Fix the supplied HTML, applying all fixing mechanisms.
     *
     * @param   string $html The HTML to sanitise
     * @return  string The sanitised and balanced HTML
     */
    public static function fix(string $html): string {
        $cleaner = self::create($html, true);

        return $cleaner->get_clean_html();
    }

    /**
     * Create a cleaneer for the supplied HTML, without applying any fixes.
     *
     * @param   string $html The HTML to sanitise
     * @param   bool $applydefaultfixes Whether to apply all default fix functions when instantiating
     * @return  self
     */
    public static function create(string $html, bool $applydefaultfixes = true): self {
        $cleaner = new self($html);

        return $cleaner;
    }

}
