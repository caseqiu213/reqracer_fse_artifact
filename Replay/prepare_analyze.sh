#!/bin/bash
bug_no=$1

sudo chmod 755 "${bug_no}"_record_0.log

cat /tmp/reqracer/php_log/php_query.log > ../Analyze/logs/"${bug_no}".log

if [ $bug_no -eq 11073 ]
then 
	cat /tmp/reqracer/php_log/wordpress_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 11437 ]
then 
	cat /tmp/reqracer/php_log/wordpress_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 24933 ]
then 
	cat /tmp/reqracer/php_log/wordpress_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 40594 ]
then 
	cat /tmp/reqracer/php_log/mediawiki_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 69815 ]
then 
	cat /tmp/reqracer/php_log/mediawiki_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 28949 ]
then 
	cat /tmp/reqracer/php_log/moodle_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 43421 ]
then 
	cat /tmp/reqracer/php_log/moodle_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 51707 ]
then 
	cat /tmp/reqracer/php_log/moodle_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 59854 ]
then 
	cat /tmp/reqracer/php_log/moodle_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

if [ $bug_no -eq 1484216 ]
then 
	cat /tmp/reqracer/php_log/drupal_token.log > ../Analyze/logs/"${bug_no}"_token.log
fi

rm -rf ./xx*
rm -rf ./replay1_logs/*.log
rm -rf ./replay2_logs/*.log
rm -rf ./"${bug_no}"/*.txt

./get_single_request.sh "${bug_no}"
