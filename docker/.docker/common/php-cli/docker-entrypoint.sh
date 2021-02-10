#!/bin/sh

/wait-for-it.sh redis:6379 -t 30

sleep 5s;

# run supervisor as standalone (not like service) to be able to pass all environments to sub processes
supervisord -c /etc/supervisor/supervisord.conf

printenv  >> /etc/environment
service cron start

exec docker-php-entrypoint php -a
