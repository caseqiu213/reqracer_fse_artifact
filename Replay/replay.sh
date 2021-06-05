#!/bin/bash

bug_no=$1

echo "preparing replaying: "
./prepare_replay.sh "${bug_no}"
echo "finish preparing."

sleep 1

echo "start replaying: "
dir2="./replay1_logs/"
# need to change filename accordingly
filename2="$2"
echo "${dir2}${filename2}"

sudo /usr/local/bin/gor --input-file "${dir2}${filename2}" \
--output-http localhost:8080 \
--output-http-track-response --output-http-timeout 120s \
--output-file "${bug_no}"_response1.log \
--prettify-http --verbose &

# run calc_time.py and change this value
sleep 7

echo "start replaying: "
dir1="./replay2_logs/"
# need to change filename accordingly
filename1="$3"
echo "${dir1}${filename1}"

sudo /usr/local/bin/gor --input-file "${dir1}${filename1}" \
--output-http localhost:8080 \
--output-http-track-response --output-http-timeout 120s \
--output-file "${bug_no}"_response2.log \
--prettify-http --verbose &


sleep 20
