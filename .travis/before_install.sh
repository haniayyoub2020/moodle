#!/usr/bin/env bash

# Exit immediately upon failure.
set -e

# Add Travis functions.
source "${TRAVIS_HOME}/.travis/functions"

########################################################################
# All Tests.
########################################################################

# Disable xdebug.
phpenv config-rm xdebug.ini

# Copy generic configuration in place.
cp .travis/config.php config.php

# Create a file to store any environment vars to persist between phases.
ENVVARFILE="${TRAVIS_HOME}/environment.sh"
touch "${ENVVARFILE}"

########################################################################
# PHPUNIT, and UPGRADE Tests.
########################################################################

if [ "$TASK" = 'PHPUNIT' -o "$TASK" = 'UPGRADE' ]
then
    # Create the moodledata directory.
    mkdir -p "$HOME"/roots/base

    # Create the test database.
    if [ "$DB" = 'pgsql' ]
    then
        # Move the postgres data directoryto ramdisk.
        sudo mkdir /mnt/ramdisk
        sudo mount -t tmpfs -o size=1024m tmpfs /mnt/ramdisk
        sudo service postgresql stop
        sudo mv /var/lib/postgresql /mnt/ramdisk
        sudo ln -s /mnt/ramdisk/postgresql /var/lib/postgresql
        sudo service postgresql start 9.6

        # Create the test database.
        psql -c 'CREATE DATABASE travis_ci_test;' -U postgres

    elif [ "$DB" = 'mysqli' ]
    then
        # Move the mysqli data directory to ramdisk.
        sudo mkdir /mnt/ramdisk
        sudo mount -t tmpfs -o size=1024m tmpfs /mnt/ramdisk
        sudo service mysql stop
        sudo mv /var/lib/mysql /mnt/ramdisk
        sudo ln -s /mnt/ramdisk/mysql /var/lib/mysql
        sudo service mysql restart

        # Create the test database.
        mysql -u root -e 'SET GLOBAL innodb_file_format=barracuda;'
        mysql -u root -e 'SET GLOBAL innodb_file_per_table=ON;'
        mysql -u root -e 'SET GLOBAL innodb_large_prefix=ON;'
        mysql -e 'CREATE DATABASE travis_ci_test DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_bin;'
    fi
fi

########################################################################
# PHPUNIT Tests.
########################################################################
if [ "$TASK" = 'PHPUNIT' ]
then
    # Start the external tests.
    docker run -d -p 127.0.0.1:8080:80 --name exttests moodlehq/moodle-exttests

    # Avoid IPv6 default binding as service (causes redis not to start).
    sudo service redis-server start --bind 127.0.0.1

		LDAPTESTNAME=ldap
		docker run \
			--detach \
			--name ${LDAPTESTNAME} \
			--network "${NETWORK}" \
			larrycai/openldap
		export LDAPTESTURL="ldap://${LDAPTESTNAME}"
		echo "LDAPTESTURL=\"{$LDAPTESTURL}\"" >> "${ENVVARFILE}"

		SOLRTESTNAME=solr
		docker run \
			--detach \
			--name ${SOLRTESTNAME} \
			--network "${NETWORK}" \
			solr:7 \
			solr-precreate test
		echo "SOLRTESTNAME=\"{$SOLRTESTNAME}\"" >> "${ENVVARFILE}"

		export REDISTESTNAME=redis
		docker run \
			--detach \
			--name ${REDISTESTNAME} \
			--network "${NETWORK}" \
			redis:3
		echo "REDISTESTNAME=\"{$REDISTESTNAME}\"" >> "${ENVVARFILE}"

		MEMCACHED1TESTNAME=memcached1
		docker run \
			--detach \
			--name ${MEMCACHED1TESTNAME} \
			--network "${NETWORK}" \
			memcached:1.4
		export MEMCACHED1TESTURL="${MEMCACHED1TESTNAME}:11211"
		echo "MEMCACHED1TESTURL=\"{$MEMCACHED1TESTURL}\"" >> "${ENVVARFILE}"

		MEMCACHED2TESTNAME=memcached2
		docker run \
			--detach \
			--name ${MEMCACHED2TESTNAME} \
			--network "${NETWORK}" \
			memcached:1.4
		export MEMCACHED2TESTURL="${MEMCACHED2TESTNAME}:11211"
		echo "MEMCACHED1TESTURL=\"{$MEMCACHED1TESTURL}\"" >> "${ENVVARFILE}"

		MONGODBTESTNAME=mongodb
		docker run \
			--detach \
			--name ${MONGODBTESTNAME} \
			--network "${NETWORK}" \
			mongo:4.0
		export MONGODBTESTURL="mongodb://${MONGODBTESTNAME}:27017"
		echo MONGODBTESTURL >> "${ENVVARFILE}"
		echo "MONGODBTESTURL=\"{$MONGODBTESTURL}\"" >> "${ENVVARFILE}"

		cat $ENVVARFILE
exit 1
fi


########################################################################
# Upgrade Tests.
########################################################################
if [ "$TASK" = 'UPGRADE' ];
then
    # We need the official upstream.
    git remote add upstream https://github.com/moodle/moodle.git

    # Checkout 35 STABLE branch (the first version compatible with PHP 7.x)
    git fetch upstream MOODLE_35_STABLE
    git checkout MOODLE_35_STABLE

    # Perform the upgrade
    php admin/cli/install_database.php --agree-license --adminpass=Password --adminemail=admin@example.com --fullname="Upgrade test" --shortname=Upgrade

    # Return to the previous commit
    git checkout -

    # Perform the upgrade
    php admin/cli/upgrade.php --non-interactive --allow-unstable

    # The local_ci repository can be used to check upgrade savepoints.
    git clone https://github.com/moodlehq/moodle-local_ci.git local/ci
fi


########################################################################
# CI Tests.
########################################################################
if [ "$TASK" = 'CITEST' ];
then
    # The following repositories are required.
    # The local_ci repository does the actual checking.
    git clone https://github.com/moodlehq/moodle-local_ci.git local/ci

    # We need the official upstream for comparison
    git remote add upstream https://github.com/moodle/moodle.git

    git fetch upstream master
fi
