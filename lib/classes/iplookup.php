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
 * IP Lookup functionality.
 *
 * @package    core
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core;

defined('MOODLE_INTERNAL') || die();

/**
 * IP Lookup functionality.
 *
 * @package    core
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class iplookup {
    /** @var $ip The IP That was looked up. */
    protected $ip = null;

    /** @var $latitude The Latitude detected for the IP */
    protected $latitude = null;

    /** @var $longitude The Longitude detected for the IP */
    protected $longitude = null;

    /** @var $city The City detected for the IP */
    protected $city = null;

    /** @var $country The Country detected for the IP */
    protected $country = null;

    /**
     * Constructor for the iplookup class.
     *
     * @param   string $ip The ip which was looked up.
     */
    protected function __construct($ip) {
        $this->ip = $ip;
    }

    /**
     * Perform a lookup.
     *
     * @param   string  $ip The IP to lookup
     * @return  iplookup
     */
    public static function lookup($ip) {
        global $CFG;

        if (!empty($CFG->geoip2file) and file_exists($CFG->geoip2file)) {
            $data = self::lookup_from_geoip2file($ip);
        } else {
            $data = self::lookup_from_remote($ip);
        }

        return $data;
    }

    /**
     * Perform a lookup using the GeoIP2 File.
     *
     * @param   string  $ip The IP to lookup
     * @return  iplookup
     */
    protected static function lookup_from_geoip2file($ip) {
        global $CFG;

        $reader = new \GeoIp2\Database\Reader($CFG->geoip2file);
        $record = $reader->city($ip);

        if (empty($record)) {
            throw new \moodle_exception('iplookupfailed', 'error', $ip);
        }

        $result = new static($ip);
        $result->set_location((float) $record->location->latitude, (float) $record->location->longitude);
        $result->set_city(\core_text::convert($record->city->name, 'iso-8859-1', 'utf-8'));
        $result->set_country($record->country->isoCode, $record->country->names['en']);

        return $result;
    }

    /**
     * Perform a lookup using the remote API.
     *
     * @param   string  $ip The IP to lookup
     * @return  iplookup
     */
    protected static function lookup_from_remote($ip) {
        global $CFG;

        $lookupurlbase = $CFG->geoipremote;
        $lookupurl = "{$lookupurlbase}/{$ip}";

        // Remove double-slashes. These are not handled by freegeoip.net well.
        $ipdata = @download_file_content($lookupurl);

        if ($ipdata) {
            $ipdata = @json_decode($ipdata, true);
        }

        if (!is_array($ipdata)) {
            throw new \moodle_exception('cannotcontactgeoipserver', '', '', $lookupurlbase);
        }

        $result = new static($ip);
        $result->set_location((float) $ipdata['latitude'], (float) $ipdata['longitude']);
        $result->set_city(s($ipdata['city']));
        $result->set_country($ipdata['country_code'], s($ipdata['country_name']));

        return $result;
    }

    /**
     * Set the detected location of the IP.
     *
     * @param   float   $latitude The determined latitude.
     * @param   float   $longitude The determined longitude.
     * @return  $this
     */
    public function set_location(float $latitude, float $longitude) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Set the detected city of the IP.
     *
     * @param   string  $city The city determined for the IP.
     * @return  $this
     */
    public function set_city(string $city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Set the detected country of the IP.
     *
     * This is based on the ISO-8859-1 Country code.
     * A fallback can be provided if the country code was not found in the known list.
     *
     * @param   string  $countrycode The ISO-8859-1 Country Code.
     * @param   string  $fallback A fallback to use if a translation could not be found for the country code.
     * @return  $this
     */
    public function set_country(string $countrycode, string $fallback = null) {
        $countries = get_string_manager()->get_list_of_countries(true);
        if (isset($countries[$countrycode])) {
            // prefer our localized country names
            $this->country = $countries[$countrycode];
        } else if ($fallback) {
            $this->country = $fallback;
        }

        return $this;
    }

    /**
     * Get the IP that was used for this request.
     *
     * @return  string
     */
    public function get_ip() {
        return $this->ip;
    }

    /**
     * Get the name of the city.
     *
     * @return  string
     */
    public function get_city() {
        return $this->city;
    }

    /**
     * Get the name of the country.
     *
     * @return  string
     */
    public function get_country() {
        return $this->country;
    }

    /**
     * Get the name of the latitude.
     *
     * @return  string
     */
    public function get_latitude() {
        return $this->latitude;
    }

    /**
     * Get the name of the longitude.
     *
     * @return  string
     */
    public function get_longitude() {
        return $this->longitude;
    }
}
