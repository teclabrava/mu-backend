#!/bin/bash

# turn on bash's job control
set -m

# Start the primary process and put it in the background


# Start the helper process
sls offline --stage local &
sls dynamodb install && sls dynamodb start --stage local &
php -S 0.0.0.0:80 -t /app/public
# the my_helper_process might need to know how to wait on the
# primary process to start before it does its work and returns


# now we bring the primary process back into the foreground
# and leave it there
fg %1
