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
 * H5P factory class.
 * This class is used to decouple the construction of H5P related objects.
 *
 * @package    h5p_v124
 * @copyright  2019 Mihail Geshoski <mihail@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_h5p;

defined('MOODLE_INTERNAL') || die();

use \H5PStorage as storage;
use \H5PValidator as validator;
use \H5PContentValidator as content_validator;
use stored_file;
use moodle_url;
use moodle_page;
use context;

/**
 * H5P factory class.
 * This class is used to decouple the construction of H5P related objects.
 *
 * @package    h5p_v124
 * @copyright  2019 Mihail Geshoski <mihail@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class player {

    /**
     * @var string The local H5P URL containing the .h5p file to display.
     */
    protected $url = null;

    /**
     * @var core The H5PCore object.
     */
    protected $core = null;

    /**
     * @var int H5P DB id.
     */
    protected $h5pid = null;

    /**
     * @var array JavaScript requirements for this H5P.
     */
    protected $jsrequires = [];

    /**
     * @var array CSS requirements for this H5P.
     */
    protected $cssrequires = [];

    /**
     * @var array H5P content to display.
     */
    protected $content = null;

    /**
     * @var string Type of embed object, div or iframe.
     */
    protected $embedtype = null;

    /**
     * Inits the H5P player for rendering the content.
     *
     * @param string $url Local URL of the H5P file to display.
     * @param stdClass $config Configuration for H5P buttons.
     */
    final public function __construct(\core_h5p\content_type $package) {
        $this->package = $package;

        if (!$this->package->is_deployed()) {
            throw new \moodle_exception('Not set up');
        }

        $factory = $package->get_factory();
        $this->url = $package->get_url();
        $this->h5pid = $package->get_id();
        $this->buttonconfig = $package->get_display_options();

        // Fetch \core_h5p\core instance.
        $this->core = $factory->get_core();
        $this->coreclassname = $factory->get_core_classname();
        $this->autoloaderclassname = $factory->get_autoloader_classname();

        // Load the content of the H5P content associated to this $url.
        // Sadly we have to do this, even though we already have it.
        $this->content = $this->core->loadContent($package->get_id());

        // Get the embedtype to use for displaying the H5P content.
        $this->embedtype = $this->coreclassname::determineEmbedType($this->content['embedType'], $this->content['library']['embedTypes']);

    }

    /**
     * Get the error messages stored in our H5P framework.
     *
     * @return array List of errors
     */
    public function get_errors(): array {
        return $this->core->h5pF->getMessages('error');
    }

    /**
     * Create the H5PIntegration variable that will be included in the page. This variable is used as the
     * main H5P config variable.
     *
     * @param moodle_page $page
     * @param renderer_base $output
     */
    public function add_assets_to_page(moodle_page $page, $output): void {
        $cid = $this->get_cid();
        $systemcontext = \context_system::instance();

        if (array_key_exists('disable', $this->content)) {
            $disable = $this->content['disable'];
        } else {
            $disable = $this->coreclassname::DISABLE_NONE;
        }

        $displayoptions = $this->core->getDisplayOptionsForView($disable, $this->h5pid);

        $contenturl = \moodle_url::make_pluginfile_url($systemcontext->id, \core_h5p\file_storage::COMPONENT,
            \core_h5p\file_storage::CONTENT_FILEAREA, $this->h5pid, null, null);

        $contentsettings = [
            'library'         => $this->coreclassname::libraryToString($this->content['library']),
            'fullScreen'      => $this->content['library']['fullscreen'],
            'exportUrl'       => $this->get_export_settings($displayoptions[$this->coreclassname::DISPLAY_OPTION_DOWNLOAD]),
            'embedCode'       => $this->get_embed_code($output, $displayoptions[$this->coreclassname::DISPLAY_OPTION_EMBED]),
            'resizeCode'      => $this->get_resize_code($output),
            'title'           => $this->content['slug'],
            'displayOptions'  => $displayoptions,
            'url'             => $this->get_embed_url()->out(),
            'contentUrl'      => $contenturl->out(),
            'metadata'        => $this->content['metadata'],
            'contentUserData' => [
                0 => [
                    'state' => '{}',
                ],
            ]
        ];

        // Get the core H5P assets, needed by the H5P classes to render the H5P content.
        $settings = $this->get_assets();
        $settings['contents'][$cid] = array_merge($settings['contents'][$cid], $contentsettings);

        foreach ($this->jsrequires as $script) {
            $page->requires->js($script, true);
        }

        foreach ($this->cssrequires as $css) {
            $page->requires->css($css);
        }

        // Print JavaScript settings to page.
        $page->requires->data_for_js('H5PIntegration', $settings, true);
    }

    /**
     * Outputs H5P wrapper HTML.
     *
     * @param renderer_base $output
     * @return string The HTML code to display this H5P content.
     */
    public function output($output): string {
        $params = (object) [
            'h5pid' => $this->h5pid,
        ];

        if ($this->embedtype === 'div') {
            return $output->render_from_template('core_h5p/h5pdiv', $params);
        } else {
            return $output->render_from_template('core_h5p/h5piframe', $params);
        }
    }

    /**
     * Get the title of the H5P content to display.
     *
     * @return string the title
     */
    public function get_title(): string {
        return $this->content['title'];
    }

    /**
     * Export path for settings
     *
     * @param bool $downloadenabled Whether the option to export the H5P content is enabled.
     *
     * @return string The URL of the exported file.
     */
    protected function get_export_settings(bool $downloadenabled): string {

        if (!$downloadenabled) {
            return '';
        }

        $systemcontext = \context_system::instance();
        $slug = $this->content['slug'] ? $this->content['slug'] . '-' : '';
        $url  = \moodle_url::make_pluginfile_url(
            $systemcontext->id,
            \core_h5p\file_storage::COMPONENT,
            \core_h5p\file_storage::EXPORT_FILEAREA,
            '',
            '',
            "{$slug}{$this->content['id']}.h5p"
        );

        return $url->out();
    }

    /**
     * Get a query string with the theme revision number to include at the end
     * of URLs. This is used to force the browser to reload the asset when the
     * theme caches are cleared.
     *
     * @return string
     */
    protected function get_cache_buster(): string {
        global $CFG;
        return '?ver=' . $CFG->themerev;
    }

    /**
     * Get the identifier for the H5P content, to be used in the arrays as index.
     *
     * @return string The identifier.
     */
    protected function get_cid(): string {
        return 'cid-' . $this->h5pid;
    }

    /**
     * Get the core H5P assets, including all core H5P JavaScript and CSS.
     *
     * @return Array core H5P assets.
     */
    protected function get_assets(): array {
        global $CFG;

        // Get core settings.
        $settings = $this->get_core_settings();
        $settings['core'] = [
          'styles' => [],
          'scripts' => []
        ];
        $settings['loadedJs'] = [];
        $settings['loadedCss'] = [];

        // Make sure files are reloaded for each plugin update.
        $cachebuster = $this->get_cache_buster();

        // Use relative URL to support both http and https.
        $liburl = $CFG->wwwroot . '/lib/h5p/';
        $relpath = '/' . preg_replace('/^[^:]+:\/\/[^\/]+\//', '', $liburl);

        // Add core stylesheets.
        foreach ($this->coreclassname::$styles as $style) {
            $settings['core']['styles'][] = $relpath . $style . $cachebuster;
            $this->cssrequires[] = new \moodle_url($liburl . $style . $cachebuster);
        }
        // Add core JavaScript.
        foreach ($this->coreclassname::get_scripts() as $script) {
            $settings['core']['scripts'][] = $script->out(false);
            $this->jsrequires[] = $script;
        }

        $cid = $this->get_cid();
        // The filterParameters function should be called before getting the dependencyfiles because it rebuild content
        // dependency cache and export file.
        $settings['contents'][$cid]['jsonContent'] = $this->core->filterParameters($this->content);

        $files = $this->get_dependency_files();
        if ($this->embedtype === 'div') {
            $systemcontext = \context_system::instance();
            $h5ppath = "/pluginfile.php/{$systemcontext->id}/core_h5p";

            // Schedule JavaScripts for loading through Moodle.
            foreach ($files['scripts'] as $script) {
                $url = $script->path . $script->version;

                // Add URL prefix if not external.
                $isexternal = strpos($script->path, '://');
                if ($isexternal === false) {
                    $url = $h5ppath . $url;
                }
                $settings['loadedJs'][] = $url;
                $this->jsrequires[] = new \moodle_url($isexternal ? $url : $CFG->wwwroot . $url);
            }

            // Schedule stylesheets for loading through Moodle.
            foreach ($files['styles'] as $style) {
                $url = $style->path . $style->version;

                // Add URL prefix if not external.
                $isexternal = strpos($style->path, '://');
                if ($isexternal === false) {
                    $url = $h5ppath . $url;
                }
                $settings['loadedCss'][] = $url;
                $this->cssrequires[] = new \moodle_url($isexternal ? $url : $CFG->wwwroot . $url);
            }

        } else {
            // JavaScripts and stylesheets will be loaded through h5p.js.
            $settings['contents'][$cid]['scripts'] = $this->core->getAssetsUrls($files['scripts']);
            $settings['contents'][$cid]['styles']  = $this->core->getAssetsUrls($files['styles']);
        }
        return $settings;
    }

    /**
     * Get the settings needed by the H5P library.
     *
     * @return array The settings.
     */
    protected function get_core_settings(): array {
        global $CFG;

        $systemcontext = \context_system::instance();

        // Generate AJAX paths.
        $ajaxpaths = [];
        $ajaxpaths['xAPIResult'] = '';
        $ajaxpaths['contentUserData'] = '';

        $settings = array(
            'baseUrl' => (new moodle_url('/'))->out(),
            'url' => (new moodle_url("/pluginfile.php/{$systemcontext->instanceid}/core_h5p"))->out(),
            'urlLibraries' => (new moodle_url("/pluginfile.php/{$systemcontext->instanceid}/core_h5p/libraries"))->out(),
            'postUserStatistics' => false,
            'ajax' => $ajaxpaths,
            'saveFreq' => false,
            'siteUrl' => $CFG->wwwroot,
            'l10n' => array('H5P' => $this->core->getLocalization()),
            'user' => [],
            'hubIsEnabled' => false,
            'reportingIsEnabled' => false,
            'crossorigin' => null,
            'libraryConfig' => $this->core->h5pF->getLibraryConfig(),
            'pluginCacheBuster' => $this->get_cache_buster(),
            'libraryUrl' => $this->autoloaderclassname::get_h5p_core_library_url("js"),
            'moodleLibraryPaths' => $this->core->get_dependency_roots($this->h5pid),
        );

        return $settings;
    }

    /**
     * Finds library dependencies of view
     *
     * @return array Files that the view has dependencies to
     */
    protected function get_dependency_files(): array {
        $preloadeddeps = $this->core->loadContentDependencies($this->h5pid, 'preloaded');
        $files = $this->core->getDependenciesFiles($preloadeddeps);

        return $files;
    }

    /**
     * Resizing script for settings
     *
     * @param renderer_base $output
     * @return string The HTML code with the resize script.
     */
    protected function get_resize_code($output): string {
        return $output->render_from_template('core_h5p/h5presize', (object) [
            'resizeurl' => $this->autoloaderclassname::get_h5p_core_library_url('js/h5p-resizer.js'),
        ]);
    }

    /**
     * Embed code for settings
     *
     * @param renderer_base $output
     * @param bool $embedenabled Whether the option to embed the H5P content is enabled.
     * @return string The HTML code to reuse this H5P content in a different place.
     */
    protected function get_embed_code($output, bool $embedenabled): string {
        if (!$embedenabled) {
            return '';
        }

        return $output->render_from_template('core_h5p/h5pembed', (object) [
            'embedurl' => $this->get_embed_url()->out(),
        ]);
    }

    /**
     * Get the encoded URL for embeding this H5P content.
     *
     * @return moodle_url The embed URL.
     */
    protected function get_embed_url(): moodle_url {
        return new \moodle_url('/h5p/embed.php', ['url' => $this->url]);
    }

}
