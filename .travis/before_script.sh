#!/usr/bin/env bash

# Exit immediately upon failure.
set -e

# Add Travis functions.
source "${TRAVIS_HOME}/.travis/functions"

# Source our environment variables.
ENVVARFILE="${TRAVIS_HOME}/environment.sh"
source "${ENVVARFILE}"
