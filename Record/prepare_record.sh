#!/bin/bash

bug_no=$1

# create db snapshot
mkdir -p /tmp/reqracer/db_snapshots
sudo /usr/local/mysql/bin/mysqldump --databases "${bug_no}" > /tmp/reqracer/db_snapshots/"${bug_no}".sql

echo "clearing log files."

> /tmp/reqracer/php_log/php_query.log
> /tmp/reqracer/php_log/wordpress_token.log
> /tmp/reqracer/php_log/mediawiki_token.log
> /tmp/reqracer/php_log/drupal_token.log
sleep 1

echo "log files are cleared."

echo "DONE"
