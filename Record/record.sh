#!/bin/bash
# usage: pass in bug number as the first argument

bug_no=$1
echo "preparing recording: "
./prepare_record.sh "${bug_no}"
sleep 1
echo "finish preparing."

echo "start recording(remember to ctrl+c to kill gor when finish recording): "

sudo /usr/local/bin/gor --input-raw localhost:8080 \
--output-stdout \
--output-file ../Replay/"${bug_no}"_record.log \
--verbose
# after recording, ctrl+c to kill gor
