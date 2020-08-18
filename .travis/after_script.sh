#!/usr/bin/env bash

# Exit immediately upon failure.
set -e

# Add Travis functions.
source "${TRAVIS_HOME}/.travis/functions"

########################################################################
# PHPUNIT Tests.
########################################################################
if [ "$TASK" = 'PHPUNIT' ]
then
    EXTTESTS_HITS=$(docker logs exttests 2>&1 | grep -Fv -e 'AH00558' -e '[pid 1]' | wc -l)
    echo -e "\nTest local resources number of hits: ${EXTTESTS_HITS}.\n"
fi
