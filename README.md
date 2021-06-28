# ReqRacer: dynamic framework for detecting and exposing server-side request races in database-backed web applications
ReqRacer is a dynamic framework designed for detecting races between different request handlers and instances of the same request handler. The detected race effect could be a database error, the error message of which will be embedded in the returned response. The race effect could also be inconsistency on the webpage, which requires checkers to determine if the race happens. 

This artifact includes ReqRacer source code to generate request logs, query logs, and token logs during recording phase, off-line analysis scripts to detect potential request races, and scripts to replay racing requests and check the race effects.

We also include the bug characteristic study results, which was made available during paper submission at https://figshare.com/s/a164aa6d482788f326c3

## Getting Started
ReqRacer is built and tested on **Ubuntu18.04**. Please make sure that the correct version is used for a virtual machine image. If you are using other versions of Ubuntu, errors unknown to the authors may happen.

For more details, check the [REQUIREMENTS](./REQUIREMENTS).
```
git clone https://github.com/caseqiu213/reqracer_fse_artifact
```
### Installing Software
```
cd reqracer_fse_artifact
./prepare_log_files.sh
```
Before running the build script, make sure `/tmp/reqracer` is created by `prepare_log_files.sh`.
```
sudo ./build.sh
```
For more details, check the [INSTALL](./INSTALL).

Apache is installed at `reqracer_fse_artifact/build/apache`. 

You can start the server by:
```
sudo reqracer_fse_artifact/build/apache/bin/apachectl -k start
```
and stop the server by:
```
sudo reqracer_fse_artifact/build/apache/bin/apachectl -k stop
```

Web application bug code should be put into `reqracer_fse_artifact/build/apache/htdocs`.

PHP is installed at `reqracer_fse_artifact/build/PHP`.

MySQL is installed at `/usr/local/bin/mysql`.

---

### Installing Application

- In the browser, type in `localhost:8080/phpMyAdmin/index.php`, and log in using MySQL credentials. (If you did not set the credentials, the `build.sh` set the username as `root` and password as `reqracer-mysql`.
- On the left bar of the webpage, click New.
- In 'Database name', enter bug number or a name you prefer, choose utf8_unicode_ci, and click create.

- WordPress(11073, 11437, 24933)
  - Edit htdocs/bug_number/wp-config-sample.php, enter DB_NAME(the database name), DB_USER(your mysql account name), DB_PASSWOR(your mysql password), and save as wp-config.php.
  - In the brwoser, type in localhost:8080/bug_number/index.php, and follow the pop-up instructions to finish setting up the application.

- MediaWiki(40594, 69815)
  - In the browser, type in localhost:8080/bug_number/mw-config/index.php
  - Follow the pop-up instructions to finish setting up the application. Set the Database name as bug_number. Database username and password are MySQL credentials. Also choose InnoDB and UTF-8.
  - Choose 'ask me more questions. In 'Extensions', check Translate for 40594, and GlobalBlocking for 69815. The bugs do not require Memcached so choose object cache as we installed xcache.
  - Download the LocalSettings.php file after installation and put it into ./build/apache/htdocs/bug_number
  - Click 'enter your wiki' and login.
  - Config for 40594
    - In phpmyadmin page, make sure table translate_groupstats does not have a record.
  - Config for 69815:
    - On sidebar, click Special pages, and then click User rights management.
    - Enter your username, check steward, and click save user groups.

- Moodle(28949, 43421, 51707, 59854)
  - In the browser, type in localhost/bug_number
  - Follow the pop-up instructions to finish setting up the application. You need to create a writable directory for moodledata.
  - Config for 28949
    - On side bar under 'Settings' -> 'Site administration' -> 'Users' -> 'Accounts' -> 'Add a new user'.
    - Enter info to create a student account.
    - Click 'Settings' -> 'Advanced features', check 'Enable completion tracking' and click 'Save changes' button.
    - Click 'Home' and enter info to create a new course.
    - If a course is created, click 'Settings' -> 'Course administration' -> 'Edit settings'.
    - In 'Student progress', enable 'Completion tracking', and click 'Save changes' button.
    - Click 'Settings' -> 'Course administration' -> 'Completion tracking'.
    - In 'Manual self completion' check 'Enable'.
    - In 'Manual competion by' check all boxes, and click 'Save changes' button.
    - If a course is created, click 'Navigation' -> 'Courses' -> 'Name' -> 'Participants'.
    - Click the icon next to 'All participants', click 'Enrol users' button.
    - Click the 'Enroll' button next to the created student account and the admin account, and click 'Finish enrolling users' button.
    - Click 'Settings' -> 'Course administration' -> 'Users' -> 'Enrolled users'.
    - Assign the admin user as 'Teacher' and 'Non-editing teacher.
    - Verify: you should be able to see 'Course completion' under 'Navigation' -> 'Courses' -> 'Name' -> 'Reports'.
    - Verify: you should be able to see a box under 'Non-editing teacher' after clicking 'Course completion'.

  - Config for 43421
    - On side bar under 'Settings' -> 'Site administration' -> 'Users' -> 'Accounts' -> 'Add a new user'.
    - Enter info to create a student account.
    - Click 'Home' and enter info to create a new course.
    - If a course is created, click 'Navigation' -> 'Courses' -> 'Name' -> 'Participants'.
    - Click the icon next to 'All participants', click 'Enrol users' button.
    - Click the 'Enroll' button next to the created student account.
    - In phpmyadmin page, make sure table mdl_user_last_accesses does not have a record.

  - Config for 51707
    - Click 'ADMINISTRATION' -> 'Site administration' -> 'Server' -> 'Scheduled tasks'.
    - Click the gear icon under 'Edit' and disable all tasks.
    - Only 'enable mod_forum\task\cron_task' and '\core\task\blog_cron_task'.

  - Config for 59854
    - On side bar under 'Site administration' -> 'Users' -> 'Accounts' -> 'Add a new user'.
    - Enter info to create a student account.
    - Click 'Site home' and enter info to create a new course.
    - If a course is created, click 'Name' -> 'Participants'.
    - Click the gear icon, and click 'Enrolled users'.
    - Enrol the created student account to the course.
    - Click 'Name', click the gear icon on the page, and click 'Turn editing on'.
    - Click 'Add an activity or resource', choose 'Forum', click 'Add' button and enter info.

   ```
   Note: For Gor to be able to capture requests, need to specify the port number. 
   Add 8080 after localhost in $CFG->wwwroot in config.php.
   ```

- Drupal(1484216)
   ```
   $ cd $REQRACER_ROOT
   $ cp -r ./bug_code/1484216/ $APACHE_ROOT/htdocs/
   $ cd $APACHE_ROOT/htdocs/1484216/
   $ mkdir sites/default/files
   $ chmod a+w sites/default/files
   $ cp sites/default/default.settings.php sites/default/settings.php
   $ chmod a+w sites/default/settings.php
   ```
  - In the browser, type in localhost/1484216.
  - Follow the pop-up instructions to finish setting up the application.
    - Enable automatic update in the last step.
   ```
   Note: For Gor to be able to capture requests, need to specify the port number. 
   Drupal uses 8080 by default and requires no changes.
   ```

## Run the Framework
Make sure the user account of the web application is logged in before invoking the record script.

### Demo
We offer a demo of ReqRacer of three different bugs at https://www.youtube.com/playlist?list=PL2jhpkScX9vTqyQny7h5X8TJsaI-j5RnD

This demo shows that ReqRacer can detect races between different request handlers and instances of the same request handler. 

11073_different is a race between the add comment request and trash post request. When the race happens, if a trashed post is restored, there are comments having a status of post-trashed in the database. On the webpage, inconsistency happens that the post appears to have two comments but when accessing the post content page, only one comment shows.

11073_same is a race between instances of add comment requests. Note that this race is inferred from the trace of 11073_different. When the race happens, comments with the same content exist in the database. This is a bug because we inspect the source code of WordPress, and it has a logic to prevent duplicated content comments from happening.

69815 is a race between instances of blocking the same IP address. When this race happens, a database error is triggered and the error message is embedded in the returned response. Therefore we can check the response to determine if the race happens. 

### File Location
The query logs are located at /tmp/reqracer/php_log/php_query.log

The token logs are located at /tmp/reqracer/php_log/app_name_token.log

The files read and written by MySQL are located at /tmp/reqracer/php_log/mysql_files/

The database snapshots are located at /tmp/reqracer/php_log/db_snapshots/

### Invoke the Record Scripts
```
sudo ./patch_php.sh
cd ./Record
./record.sh bug_number
```
patch_php.sh modifies PHP source code to enable query logging.
record.sh creates a database snapshot, clears all log files, and starts GoReplay(Gor) to record requests.

Follow the steps for a specific bug to invoke necessary steps to trigger a race. Once you finish recording, hit ctrl+c to terminate the record process.

### Steps for Each Bug
- WordPress-11073
  - Access the homepage and click Site Admin.
  - On wp-admin page, click 'Posts' -> 'Add New'.
  - Enter title and content of a post, and click 'Publish'.
  - After the publish finishes, click 'Visit site'.
  - Click the newly-added post, enter a comment and click 'Submit Comment'.
  - Go to wp-admin/edit.php, click 'Edit'.
  - Hover the mouse to the newly-added post and click 'Trash', this will hit the sleep.
  - In a new browser, access the post page and add a new comment.
  - After post-trashing finishes, click 'Trash' to see trashed posts.
  - Hover the mouse to the trashed post and click 'Restore'.
  - When the race happens, there is a comment with post-trashed status in the database.

- WordPress-11437
  - Access the homepage and click Site Admin.
  - On wp-admin page, click 'Posts' -> 'Add New'.
  - Enter title and content of a post, and click 'Publish'.
  - When the race happens, an error message saying 'WordPress database error' is returned in the response.

- WordPress-24933
  - Access the homepage and click Site Admin.
  - On wp-admin page, click 'Media' -> 'Add New'
  - Click 'Choose File'. Select a file to upload, and click 'Upload'.
  - Hover the mouse to the image and click 'Edit'
  - Click 'Edit Image' then on the new page click 'Scale Image'
  - On wp-admin page, click 'Media'
  - Hover the mouse to the image and click 'Delete permanently'
  - When the race happens, the preview thumbnail is missing.

- MediaWiki-40954
  - On sidebar click 'Special pages'.
  - Click 'Language statistics'.
  - When the race happens, the response header has a 500 error code.

- MediaWiki-69815
  - On side bar click 'Special pages'.
  - Click 'Globally block an IP address'.
  - Enter the IP you want to block, choose an expiry time and reason, and click 'Block this IP address globally'.
  - When the race happens, the response header has a 500 error code.

- Moodle-28949
  - Log in the student account and mark the assignment as completed
  - In a terminal, run command ./build/php/bin/php ./build/apache/htdoc/28949/admin/cli/cron.php
  - Log in the admin account.
  - On 'Course completion' page, click the check box to mark that the student completed the course.
  - When the race happens, an error message saying 'Found more than one record in fetch()' is returned in the response.

- Moodle-43421
  - Log in the student account.
  - When the race happens, an error message saying 'Error writing to database' is returned in the response.

- Moodle-51707
  - In the terminal run command ./build/php/bin/php ./build/apache/htdocs/51707/admin/cli/cron.php.
  - In the browser, go to 'Scheduled tasks' page.
  - Click the gear icon for 'mod_forum\task\cron_taks' and disable it.
  - When the race happens, the disabled task is still scheduled.

- Moodle-59854
  - Click the forum, then click the gear icon on the page. 
  - Click 'Show/edit current subscribers' and then click 'Turn editing on' button.
  - Select the student account to be enrolled to the forum and click 'Add'.
  - When the race happens, in the database, the user is subscribed twice for the same forum.

- Drupal-1484216
    - Click 'Modules' on the top bar.
    - When the race happens, a database error saying 'Duplicate entry' is returned in the response.

---

### Run the Offline Analyzer
```
cd ./Replay
./prepare_analyze.sh bug_number
cd ../Analyze/V2/
python3 ./generate_queries.py
```
prepare_analyze.sh copies log files to the Analyze directory and splits a request trace having multiple requests into files of individual request.
generate_queries.py finds potential racing requests, prunes races using RRR and SPK dependencies, and generates replay logs and queries in unserializable patterns.

### Invoke the Replay Script
The replay log filenames are in the format of replay<session_num>_dup_req_<racing_request_num1>_req_<racing_request_num2>. For each pair of racing requests, do the following steps.
1. Run ```python3 ./calc_time.py``` with one replay log, change the sleep time in line24 in replay.sh with the output.
2. In the bug_number folder, you will find the query log files with names in the format of dup_req_<racing_request_num1>_req_<racing_request_num2>_replay_queries_<sequence_num>. For each query log associated with the same request pair, copy and paste the content to /tmp/reqracer/php_log/mysql_files/zy_race_queries.txt. Truncate the query string if it has time related information. 
3. For Mediawiki and Moodle, you may need to open a new browser to get session values from cookies and token values associated with the session from the page source code. The session id in cookies for MediaWiki has a name of bug_numberSession, and Moodle has a name of MoodleSession. The token in MediaWiki has a name of 'EditToken' and Moodle has a name of 'sesskey'.
4. Append a dummy GET request at the end of both log files from replay1_logs and replay2_logs. Usually, the first request in a recorded request trace is a GET request, and we can run the following command to get the new replay logs:
```
cat replay1_logs/filename xx00 > replay1_logs/new_filename
cat replay2_logs/filename xx00 > replay2_logs/new_filename
```
5. Replace the new session id and token value in the logs in replay1_logs folder. Note that you need to use vim to replace the session id and token value. Using a text editor messes up the replay log format and Gor will not be able to read the logs.
6. Change the timestamp of the last request in the log to make it happen 20 seconds after the previous one. The timestamp is in nano seconds.
7. Run ```./replay.sh bug_number replay1_log_new_filename replay2_log_new_filename```

### Reason for Manual Work Required by ReqRacer
1. Copy and paste session id and token value into replay logs.

Since requests with the same session id will be serialized on the server-side, we cannot use the same session id while replaying two racing requests. In the recording phase of ReqRacer, all requests are recorded in one browser. The session id is stored in the browser cookies so requests sent from the same browser have the same session id. Therefore, in the replay phase, to get a different session id in the second replay session, we manually open a new browser, log in to the user account, inspect the web page, and copy and paste the session id. The token value is associated with the session id, and it is embedded in the HTML. We also copy and paste the new token value to replay logs. To automate this step, we need a more advanced replay tool which can extract data from previous response and embed the data into subsequent requests. However, Gor does not support such feature. 

2. Append a dummy request at the end of replay logs.

This is another limitaion of Gor. We add delays in MySQL to enforce a specific query sequence to check if the race happens. When Gor replays the last request in the replay log and MySQL delay is triggered, Gor could terminate before the corresponding response is returned, and the response is not captured. To avoid this problem, we add a dummy request, which is often a GET request, at the end of the replay log, and change the timestamp of the dummy request to be sent 20 seconds after the time the previous request is sent. By doing this, we can capture the response of the last request in the replay log even if MySQL delays are triggered.

3. Change query strings to be enforced.

In our implementation, we check if an incoming query string matches a query in the unserializable pattern. However, the incoming query string may contain information related to time, such as a timestamp when adding a comment. Such time information changes from run to run, and usually does not relate to trigging the race. Therefore, we manually inspect the pattern query, truncate data that are related to time, and remain data that does not change from run to run.

4. Change the sleep time before starting the second replay session.

We want to start the second replay session when the first session reaches one request in the racing request pair. We currently calculate the timestamp difference between the racing request and the first request in its replay log and change the sleep time before starting the second replay session accordingly. For example, if the timestamp difference is 5 seconds between the first request and the racing request in the session1 replay log, we use sleep 5 before starting the second replay session in replay.sh. 
