#!/usr/bin/env bash

# Exit immediately upon failure.
set -e

# Add Travis functions.
source "${TRAVIS_HOME}/.travis/functions"

# Source our environment variables.
ENVVARFILE="${TRAVIS_HOME}/environment.sh"

########################################################################
# PHPUNIT Tests.
########################################################################
if [ "$TASK" = 'PHPUNIT' ]
then
    vendor/bin/phpunit --fail-on-risky --disallow-test-output --verbose
fi

########################################################################
# CITEST Tests.
########################################################################
if [ "$TASK" = 'CITEST' ]
then
    export GIT_PREVIOUS_COMMIT="`git merge-base FETCH_HEAD $TRAVIS_COMMIT`"
    export GIT_COMMIT="$TRAVIS_COMMIT"
    export UPSTREAM_FETCH_HEAD=`git rev-parse FETCH_HEAD`

    # Variables required by our linter.
    export gitcmd=`which git`
    export gitdir="$TRAVIS_BUILD_DIR"
    export phpcmd=`which php`

    bash local/ci/php_lint/php_lint.sh
fi

########################################################################
# GRUNT Tests.
########################################################################
if [ "$TASK" = 'GRUNT' ]
then
    # Ensure that nvm functions are loaded.
    source ~/.nvm/nvm.sh

    # Use the correct version of node.
    nvm use

    # Run a full `grunt`
    grunt

    # Also run `grunt ignorefiles` which is not included in a standard run.
    grunt ignorefiles

    # Add all files to the git index and then run diff --cached to see all changes.
    # This ensures that we get the status of all files, including new files.
    # We ignore npm-shrinkwrap.json to make the tasks immune to npm changes.
    git add .
    git reset -- npm-shrinkwrap.json
    git diff --cached --exit-code
fi

########################################################################
# Upgrade test
########################################################################
if [ "$TASK" = 'UPGRADE' ]
then
    cp local/ci/check_upgrade_savepoints/check_upgrade_savepoints.php ./check_upgrade_savepoints.php
    result=`php check_upgrade_savepoints.php`

    # Check if there are problems
    count=`echo "$result" | grep -P "ERROR|WARN" | wc -l`
    if [ $count -gt 0 ]
    then
        echo "$result"
        exit 1
    fi
fi
