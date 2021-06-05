#!/bin/bash

bug_no=$1

mkdir -p /tmp/reqracer/db_snapshots
sudo /usr/local/mysql/bin/mysqldump --databases "${bug_no}" > /tmp/reqracer/db_snapshots/"${bug_no}".sql
