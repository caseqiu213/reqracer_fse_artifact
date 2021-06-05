#!/bin/bash
bug_no=$1

echo "restoring database snapshot."

sudo /usr/local/mysql/bin/mysql  < /tmp/reqracer/db_snapshots/"${bug_no}".sql

sleep 2

echo "clearing flag files."

cd /tmp/reqracer/php_log/mysql_files
> zy_req1_loop.txt
> zy_req1_start.txt
> zy_req2_loop.txt
> zy_req2_start.txt
> zy_request_dict.txt
> zy_start_second_replay.txt
> flag.txt
> zy_stop_loop.txt
> testing.txt

echo "DONE"
