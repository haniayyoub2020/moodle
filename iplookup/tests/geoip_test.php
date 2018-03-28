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
 * GeoIP tests
 *
 * @package    core_iplookup
 * @category   phpunit
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once("{$CFG->libdir}/filelib.php");
require_once("{$CFG->dirroot}/iplookup/lib.php");


/**
 * GeoIp data file parsing test.
 */
class core_iplookup_geoip_testcase extends advanced_testcase {
    public function setUp() {
        if (!PHPUNIT_LONGTEST) {
            // These tests are intensive and required downloads.
            $this->markTestSkipped('PHPUNIT_LONGTEST is not defined');
        }

        $this->resetAfterTest();
    }

    /**
     * Test the format of data returned in the iplookup_find_location function.
     *
     * @dataProvider ip_provider
     * @param   string  $ip The IP to test
     */
    public function test_ip($ip) {
        // Note: The results we get from the iplookup tests are beyond our control.
        // We used to check a specific IP to a known location, but these have become less reliable and change too
        // frequently to be used for testing.

        $result = iplookup_find_location($ip);
        $this->assertDebuggingCalled('The iplookup_find_location function has been deprecated. ' .
                'Please update your code to use \core\iplookup instead.');

        $this->assertInternalType('array', $result);
        $this->assertInternalType('float', $result['latitude']);
        $this->assertInternalType('float', $result['longitude']);
        $this->assertInternalType('string', $result['city']);
        $this->assertInternalType('string', $result['country']);
        $this->assertInternalType('array', $result['title']);
        $this->assertInternalType('string', $result['title'][0]);
        $this->assertInternalType('string', $result['title'][1]);
        $this->assertNull($result['error']);
    }

    /**
     * Test the format of data returned in the iplookup_find_location function.
     *
     * @dataProvider ip_provider
     * @param   string  $ip The IP to test
     */
    public function test_remote_api($ip) {
        global $CFG;

        $CFG->geoipfile = '';

        // Note: The results we get from the iplookup tests are beyond our control.
        // We used to check a specific IP to a known location, but these have become less reliable and change too
        // frequently to be used for testing.

        $result = iplookup_find_location($ip);
        $this->assertDebuggingCalled('The iplookup_find_location function has been deprecated. ' .
                'Please update your code to use \core\iplookup instead.');

        $this->assertInternalType('array', $result);
        $this->assertInternalType('float', $result['latitude']);
        $this->assertInternalType('float', $result['longitude']);
        $this->assertInternalType('string', $result['city']);
        $this->assertInternalType('string', $result['country']);
        $this->assertInternalType('array', $result['title']);
        $this->assertInternalType('string', $result['title'][0]);
        $this->assertInternalType('string', $result['title'][1]);
        $this->assertNull($result['error']);
    }

    /**
     * Data provider for IP lookup test.
     *
     * @return array
     */
    public function ip_provider() {
        return [
            'IPv4: Sample suggested by maxmind themselves' => ['24.24.24.24'],
            'IPv4: github.com' =>  ['192.30.255.112'],
            'IPv6: UCLA' => ['2607:f010:3fe:fff1::ff:fe00:25'],
        ];
    }
}
