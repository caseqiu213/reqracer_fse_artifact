export LOG_PATH=/tmp/reqracer

mkdir -p $LOG_PATH/php_log/mysql_files
cd $LOG_PATH/php_log/mysql_files
touch testing.txt
touch zy_request_dict.txt
touch zy_stop_loop.txt
touch zy_req1_loop.txt
touch zy_req1_start.txt
touch zy_req2_loop.txt
touch zy_req2_start.txt
touch flag.txt
touch zy_start_second_replay.txt
cat > zy_race_queries.txt <<EOL
1
2
3
4
5
6
EOL

mkdir -p $LOG_PATH/phpsessions

cd $LOG_PATH/php_log
touch php_query.log
touch drupal_token.log
touch mediawiki_token.log
touch wordpress_token.log
touch moodle_token.log

chmod -R 777 /tmp/reqracer/
