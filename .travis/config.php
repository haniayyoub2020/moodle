<?php

unset($CFG);
global $CFG;

// Basic configuration.
$CFG = (object) [
    'dbtype'        => '',
    'dblibrary'     => 'native',
    'dbhost'        => 'localhost',
    'dbname'        => 'travis_ci_test',
    'dbuser'        => '',
    'dbpass'        => '',
    'prefix'        => 'mdl_',
    'dboptions'     => [
        'dbcollation' => '',
    ],
    'wwwroot'       => 'https://localhost',
    'dataroot'      => '/home/travis/roots/base',

    // PHPUnit configuration.
    'phpunit_dataroot' => '/home/travis/roots/phpunit',
    'phpunit_prefix' => 'p_',
];

// Database-specific configuration.
switch(getenv('DB')) {
    case 'pgsql':
        $CFG->dbtype = 'pgsql';
        $CFG->dbuser = 'postgres';
        $CFG->dboptions['dbcollation'] = 'i';
        break;
    case 'mysqli':
        $CFG->dbtype = 'mysqli';
        $CFG->dbuser =   'travis';
        $CFG->dboptions['dbcollation'] = ']';
        break;

}
$CFG->behat_pause_on_fail = true;


define('TEST_EXTERNAL_FILES_HTTP_URL', 'http://127.0.0.1:8080');
define('TEST_CACHESTORE_REDIS_TESTSERVERS', '127.0.0.1');

require_once(__DIR__ . '/lib/setup.php');
