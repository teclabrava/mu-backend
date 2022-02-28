#!/bin/bash

#Job control is enabled.
set -m
# Copy the configuration file
cp .env.example.local .env

# Install dependencies
npm install
composer install

# Run Local S3
sls offline --stage local >&2 &
# Run Local dynamodb
sls dynamodb install && sls dynamodb start --stage local --verbose >&2 &
# Run Local web server
php -S 0.0.0.0:8080 -t public >&2 &

# Wait all jobs complete
wait

# Exit with status of process that exited first
exit $?
