#!/usr/bin/env bash

# Exit immediately upon failure.
set -e

# Add Travis functions.
source "${TRAVIS_HOME}/.travis/functions"

# Source our environment variables.
ENVVARFILE="${TRAVIS_HOME}/environment.sh"
source "${ENVVARFILE}"

########################################################################
# GRUNT Tests.
########################################################################
if [ "$TASK" = 'GRUNT' ];
then
    # Ensure that nvm functions are loaded.
    source ~/.nvm/nvm.sh

    # Install the NodeJS and NPM versions defined in the .nvmrc file.
    nvm install
    nvm use

    # Install grunt globally.
    npm install --no-spin -g grunt

    # Install NPM dependencies.
    npm install --no-spin
fi


########################################################################
# PHPUNIT Tests.
########################################################################
if [ "$TASK" = 'PHPUNIT' ]
then
    if [ -n "$GITHUB_APITOKEN" ]
    then
        composer config github-oauth.github.com $GITHUB_APITOKEN
        echo 'auth.json' >> .git/info/exclude
    fi

    echo 'extension="redis.so"' > /tmp/redis.ini
    phpenv config-add /tmp/redis.ini

    # Install composer dependencies.
    # We need --no-interaction in case we hit API limits for composer. This causes it to fall back to a standard clone.
    # Typically it should be able to use the Composer cache if any other job has already completed before we started here.
    travis_retry composer install --prefer-dist --no-interaction

    # Initialise PHPUnit for Moodle.
    php admin/tool/phpunit/cli/init.php
fi
