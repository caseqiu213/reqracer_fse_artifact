#!/bin/bash
# this script separate a gor log having multiple requests
# into logs having a single request 
bug_no=$1
csplit -z "${bug_no}"_record_0.log '/🐵🙈🙉/+1' '{*}' --quiet
