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
        $CFG->dboptions['dbcollation'] = 'utf8mb4_unicode_ci';
        break;
    case 'mysqli':
        $CFG->dbtype = 'mysqli';
        $CFG->dbuser =   'travis';
        $CFG->dboptions['dbcollation'] = 'utf8mb4_bin';
        break;
}

define('TEST_EXTERNAL_FILES_HTTP_URL', 'http://127.0.0.1:8080');
define('TEST_EXTERNAL_FILES_HTTPS_URL', 'http://127.0.0.1:8080');

define('TEST_LDAPLIB_HOST_URL', getenv('LDAPTESTURL'));
define('TEST_LDAPLIB_BIND_DN', 'cn=admin,dc=openstack,dc=org');
define('TEST_LDAPLIB_BIND_PW', 'password');
define('TEST_LDAPLIB_DOMAIN', 'ou=Users,dc=openstack,dc=org');

define('TEST_AUTH_LDAP_HOST_URL', getenv('LDAPTESTURL'));
define('TEST_AUTH_LDAP_BIND_DN', 'cn=admin,dc=openstack,dc=org');
define('TEST_AUTH_LDAP_BIND_PW', 'password');
define('TEST_AUTH_LDAP_DOMAIN', 'ou=Users,dc=openstack,dc=org');

define('TEST_ENROL_LDAP_HOST_URL', getenv('LDAPTESTURL'));
define('TEST_ENROL_LDAP_BIND_DN', 'cn=admin,dc=openstack,dc=org');
define('TEST_ENROL_LDAP_BIND_PW', 'password');
define('TEST_ENROL_LDAP_DOMAIN', 'ou=Users,dc=openstack,dc=org');

if ($solrtestname = getenv('SOLRTESTNAME')) {
    define('TEST_SEARCH_SOLR_HOSTNAME', $solrtestname);
    define('TEST_SEARCH_SOLR_INDEXNAME', 'test');
    define('TEST_SEARCH_SOLR_PORT', 8983);
}

if ($redistestname = getenv('REDISTESTNAME')) {
    define('TEST_SESSION_REDIS_HOST', $redistestname);
    define('TEST_CACHESTORE_REDIS_TESTSERVERS', $redistestname);
}

if ($memcached1testurl = getenv('MEMCACHED1TESTURL')) {
    if ($memcached2testurl = getenv('MEMCACHED2TESTURL')) {
        define('TEST_CACHESTORE_MEMCACHED_TESTSERVERS', $memcached1testurl. "\n" . $memcached2testurl);
    } else {
        define('TEST_CACHESTORE_MEMCACHED_TESTSERVERS', $memcached1testurl);
    }
}

if ($mongodbtesturl = getenv('MONGODBTESTURL')) {
    define('TEST_CACHESTORE_MONGODB_TESTSERVER', $mongodbtesturl);
}

require_once(__DIR__ . '/lib/setup.php');
