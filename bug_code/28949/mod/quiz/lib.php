<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Library of functions for the quiz module.
 *
 * This contains functions that are called also from outside the quiz module
 * Functions that are only called by the quiz module itself are in {@link locallib.php}
 *
 * @package mod-quiz
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/** Require {@link eventslib.php} */
require_once($CFG->libdir . '/eventslib.php');
/** Require {@link calendar/lib.php} */
require_once($CFG->dirroot . '/calendar/lib.php');

/// CONSTANTS ///////////////////////////////////////////////////////////////////

/**#@+
 * Options determining how the grades from individual attempts are combined to give
 * the overall grade for a user
 */
define('QUIZ_GRADEHIGHEST', 1);
define('QUIZ_GRADEAVERAGE', 2);
define('QUIZ_ATTEMPTFIRST', 3);
define('QUIZ_ATTEMPTLAST', 4);
/**#@-*/

define('QUIZ_MAX_ATTEMPT_OPTION', 10);
define('QUIZ_MAX_QPP_OPTION', 50);
define('QUIZ_MAX_DECIMAL_OPTION', 5);
define('QUIZ_MAX_Q_DECIMAL_OPTION', 7);

/**#@+
 * The different review options are stored in the bits of $quiz->review
 * These constants help to extract the options
 *
 * This is more of a mess than you might think necessary, because originally
 * it was though that 3x6 bits were enough, but then they ran out. PHP integers
 * are only reliably 32 bits signed, so the simplest solution was then to
 * add 4x3 more bits.
 */
/**
 * The first 6 + 4 bits refer to the time immediately after the attempt
 */
define('QUIZ_REVIEW_IMMEDIATELY', 0x3c003f);
/**
 * the next 6 + 4 bits refer to the time after the attempt but while the quiz is open
 */
define('QUIZ_REVIEW_OPEN',       0x3c00fc0);
/**
 * the final 6 + 4 bits refer to the time after the quiz closes
 */
define('QUIZ_REVIEW_CLOSED',    0x3c03f000);

// within each group of 6 bits we determine what should be shown
define('QUIZ_REVIEW_RESPONSES',       1*0x1041); // Show responses
define('QUIZ_REVIEW_SCORES',          2*0x1041); // Show scores
define('QUIZ_REVIEW_FEEDBACK',        4*0x1041); // Show question feedback
define('QUIZ_REVIEW_ANSWERS',         8*0x1041); // Show correct answers
// Some handling of worked solutions is already in the code but not yet fully supported
// and not switched on in the user interface.
define('QUIZ_REVIEW_SOLUTIONS',      16*0x1041); // Show solutions
define('QUIZ_REVIEW_GENERALFEEDBACK',32*0x1041); // Show question general feedback
define('QUIZ_REVIEW_OVERALLFEEDBACK', 1*0x4440000); // Show quiz overall feedback
// Multipliers 2*0x4440000, 4*0x4440000 and 8*0x4440000 are still available
/**#@-*/

/**
 * If start and end date for the quiz are more than this many seconds apart
 * they will be represented by two separate events in the calendar
 */
define("QUIZ_MAX_EVENT_LENGTH", 5*24*60*60);   // 5 days maximum

/// FUNCTIONS ///////////////////////////////////////////////////////////////////

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @global object
 * @param object $quiz the data that came from the form.
 * @return mixed the id of the new instance on success,
 *          false or a string error message on failure.
 */
function quiz_add_instance($quiz) {
    global $DB;
    $cmid = $quiz->coursemodule;

    // Process the options from the form.
    $quiz->created = time();
    $quiz->questions = '';
    $result = quiz_process_options($quiz);
    if ($result && is_string($result)) {
        return $result;
    }

    // Try to store it in the database.
    $quiz->id = $DB->insert_record('quiz', $quiz);

    // Do the processing required after an add or an update.
    quiz_after_add_or_update($quiz);

    return $quiz->id;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global stdClass
 * @global object
 * @param object $quiz the data that came from the form.
 * @return mixed true on success, false or a string error message on failure.
 */
function quiz_update_instance($quiz, $mform) {
    global $CFG, $DB;

    // Process the options from the form.
    $result = quiz_process_options($quiz);
    if ($result && is_string($result)) {
        return $result;
    }

    // Repaginate, if asked to.
    if (!$quiz->shufflequestions && !empty($quiz->repaginatenow)) {
        require_once($CFG->dirroot . '/mod/quiz/locallib.php');
        $quiz->questions = $DB->get_field('quiz', 'questions', array('id' => $quiz->instance));
        $quiz->questions = quiz_repaginate($quiz->questions, $quiz->questionsperpage);
    }
    unset($quiz->repaginatenow);

    // Update the database.
    $quiz->id = $quiz->instance;
    $DB->update_record('quiz', $quiz);

    // Do the processing required after an add or an update.
    quiz_after_add_or_update($quiz);

    // Delete any previous preview attempts
    quiz_delete_previews($quiz);

    return true;
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @global object
 * @param int $id
 * @return bool
 */
function quiz_delete_instance($id) {
    global $DB;

    if (!$quiz = $DB->get_record('quiz', array('id' => $id))) {
        return false;
    }

    quiz_delete_all_attempts($quiz);
    quiz_delete_all_overrides($quiz);

    $DB->delete_records('quiz_question_instances', array('quiz' => $quiz->id));
    $DB->delete_records('quiz_feedback', array('quizid' => $quiz->id));

    $events = $DB->get_records('event', array('modulename' => 'quiz', 'instance' => $quiz->id));
    foreach($events as $event) {
        $event = calendar_event::load($event);
        $event->delete();
    }

    quiz_grade_item_delete($quiz);
    $DB->delete_records('quiz', array('id' => $quiz->id));

    return true;
}

/**
 * Deletes a quiz override from the database and clears any corresponding calendar events
 *
 * @param object $quiz The quiz object.
 * @param integer $overrideid The id of the override being deleted
 * @return bool true on success
 */
function quiz_delete_override($quiz, $overrideid) {
    global $DB;

    if (!$override = $DB->get_record('quiz_overrides', array('id' => $overrideid))) {
        return false;
    }
    $groupid   = empty($override->groupid)?   0 : $override->groupid;
    $userid    = empty($override->userid)?    0 : $override->userid;

    // Delete the events
    $events = $DB->get_records('event', array('modulename'=>'quiz', 'instance'=>$quiz->id, 'groupid'=>$groupid, 'userid'=>$userid));
    foreach($events as $event) {
        $eventold = calendar_event::load($event);
        $eventold->delete();
    }

    $DB->delete_records('quiz_overrides', array('id' => $overrideid));
    return true;
}

/**
 * Deletes all quiz overrides from the database and clears any corresponding calendar events
 *
 * @param object $quiz The quiz object.
 */
function quiz_delete_all_overrides($quiz) {
    global $DB;

    $overrides = $DB->get_records('quiz_overrides', array('quiz' => $quiz->id), 'id');
    foreach ($overrides as $override) {
        quiz_delete_override($quiz, $override->id);
    }
}

/**
 * Updates a quiz object with override information for a user.
 *
 * Algorithm:  For each quiz setting, if there is a matching user-specific override,
 *   then use that otherwise, if there are group-specific overrides, return the most
 *   lenient combination of them.  If neither applies, leave the quiz setting unchanged.
 *
 *   Special case: if there is more than one password that applies to the user, then
 *   quiz->extrapasswords will contain an array of strings giving the remaining
 *   passwords.
 *
 * @param object $quiz The quiz object.
 * @param integer $userid The userid.
 * @return object $quiz The updated quiz object.
 */
function quiz_update_effective_access($quiz, $userid) {
    global $DB;

    // check for user override
    $override = $DB->get_record('quiz_overrides', array('quiz' => $quiz->id, 'userid' => $userid));

    if (!$override) {
        $override = new stdClass();
        $override->timeopen = null;
        $override->timeclose = null;
        $override->timelimit = null;
        $override->attempts = null;
        $override->password = null;
    }

    // check for group overrides
    $groupings = groups_get_user_groups($quiz->course, $userid);

    if (!empty($groupings[0])) {
        // Select all overrides that apply to the User's groups
        list($extra, $params) = $DB->get_in_or_equal(array_values($groupings[0]));
        $sql = "SELECT * FROM {quiz_overrides}
                WHERE groupid $extra AND quiz = ?";
        $params[] = $quiz->id;
        $records = $DB->get_records_sql($sql, $params);

        // Combine the overrides
        $opens = array();
        $closes = array();
        $limits = array();
        $attempts = array();
        $passwords = array();

        foreach ($records as $gpoverride) {
            if (isset($gpoverride->timeopen)) {
                $opens[] = $gpoverride->timeopen;
            }
            if (isset($gpoverride->timeclose)) {
                $closes[] = $gpoverride->timeclose;
            }
            if (isset($gpoverride->timelimit)) {
                $limits[] = $gpoverride->timelimit;
            }
            if (isset($gpoverride->attempts)) {
                $attempts[] = $gpoverride->attempts;
            }
            if (isset($gpoverride->password)) {
                $passwords[] = $gpoverride->password;
            }
        }
        // If there is a user override for a setting, ignore the group override
        if (is_null($override->timeopen) && count($opens)) {
            $override->timeopen  = min($opens);
        }
        if (is_null($override->timeclose) && count($closes)) {
            $override->timeclose  = max($closes);
        }
        if (is_null($override->timelimit) && count($limits)) {
            $override->timelimit  = max($limits);
        }
        if (is_null($override->attempts) && count($attempts)) {
            $override->attempts  = max($attempts);
        }
        if (is_null($override->password) && count($passwords)) {
            $override->password  = array_shift($passwords);
            if (count($passwords)) {
                $override->extrapasswords  = $passwords;
            }
        }

    }

    // merge with quiz defaults
    $keys = array('timeopen','timeclose', 'timelimit', 'attempts', 'password', 'extrapasswords');
    foreach ($keys as $key) {
        if (isset($override->{$key})) {
            $quiz->{$key} = $override->{$key};
        }
    }

    return $quiz;
}

/**
 * Delete all the attempts belonging to a quiz.
 *
 * @global stdClass
 * @global object
 * @param object $quiz The quiz object.
 */
function quiz_delete_all_attempts($quiz) {
    global $CFG, $DB;
    require_once($CFG->libdir . '/questionlib.php');
    $attempts = $DB->get_records('quiz_attempts', array('quiz' => $quiz->id));
    foreach ($attempts as $attempt) {
        delete_attempt($attempt->uniqueid);
    }
    $DB->delete_records('quiz_attempts', array('quiz' => $quiz->id));
    $DB->delete_records('quiz_grades', array('quiz' => $quiz->id));
}

/**
 * Return a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @global object
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $quiz
 * @return object|null
 */
function quiz_user_outline($course, $user, $mod, $quiz) {
    global $DB, $CFG;
    require_once("$CFG->libdir/gradelib.php");
    $grades = grade_get_grades($course->id, 'mod', 'quiz', $quiz->id, $user->id);

    if (empty($grades->items[0]->grades)) {
        return null;
    } else {
        $grade = reset($grades->items[0]->grades);
    }

    $result = new stdClass;
    $result->info = get_string('grade') . ': ' . $grade->str_long_grade;

    //datesubmitted == time created. dategraded == time modified or time overridden
    //if grade was last modified by the user themselves use date graded. Otherwise use date submitted
    //TODO: move this copied & pasted code somewhere in the grades API. See MDL-26704
    if ($grade->usermodified == $user->id || empty($grade->datesubmitted)) {
        $result->time = $grade->dategraded;
    } else {
        $result->time = $grade->datesubmitted;
    }

    return $result;
}

/**
 * Is this a graded quiz? If this method returns true, you can assume that
 * $quiz->grade and $quiz->sumgrades are non-zero (for example, if you want to
 * divide by them).
 *
 * @param object $quiz a row from the quiz table.
 * @return boolean whether this is a graded quiz.
 */
function quiz_has_grades($quiz) {
    return $quiz->grade != 0 && $quiz->sumgrades != 0;
}

/**
 * Get the best current grade for a particular user in a quiz.
 *
 * @param object $quiz the quiz settings.
 * @param integer $userid the id of the user.
 * @return float the user's current grade for this quiz, or NULL if this user does
 * not have a grade on this quiz.
 */
function quiz_get_best_grade($quiz, $userid) {
    global $DB;
    $grade = $DB->get_field('quiz_grades', 'grade', array('quiz' => $quiz->id, 'userid' => $userid));

    // Need to detect errors/no result, without catching 0 scores.
    if ($grade === false) {
        return null;
    }

    return $grade + 0; // Convert to number.
}

/**
 * Print a detailed representation of what a  user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @global object
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $quiz
 * @return bool
 */
function quiz_user_complete($course, $user, $mod, $quiz) {
    global $DB, $CFG, $OUTPUT;
    require_once("$CFG->libdir/gradelib.php");
    $grades = grade_get_grades($course->id, 'mod', 'quiz', $quiz->id, $user->id);
    if (!empty($grades->items[0]->grades)) {
        $grade = reset($grades->items[0]->grades);
        echo $OUTPUT->container(get_string('grade').': '.$grade->str_long_grade);
        if ($grade->str_feedback) {
            echo $OUTPUT->container(get_string('feedback').': '.$grade->str_feedback);
        }
    }

    if ($attempts = $DB->get_records('quiz_attempts', array('userid' => $user->id, 'quiz' => $quiz->id), 'attempt')) {
        foreach ($attempts as $attempt) {
            echo get_string('attempt', 'quiz').' '.$attempt->attempt.': ';
            if ($attempt->timefinish == 0) {
                print_string('unfinished');
            } else {
                echo quiz_format_grade($quiz, $attempt->sumgrades) . '/' . quiz_format_grade($quiz, $quiz->sumgrades);
            }
            echo ' - '.userdate($attempt->timemodified).'<br />';
        }
    } else {
       print_string('noattempts', 'quiz');
    }

    return true;
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @global stdClass
 * @return bool true
 */
function quiz_cron() {
    global $CFG;

    return true;
}

/**
 * @global object
 * @param integer $quizid the quiz id.
 * @param integer $userid the userid.
 * @param string $status 'all', 'finished' or 'unfinished' to control
 * @param bool $includepreviews
 * @return an array of all the user's attempts at this quiz. Returns an empty array if there are none.
 */
function quiz_get_user_attempts($quizid, $userid=0, $status = 'finished', $includepreviews = false) {
    global $DB;
    $status_condition = array(
        'all' => '',
        'finished' => ' AND timefinish > 0',
        'unfinished' => ' AND timefinish = 0'
    );
    $previewclause = '';
    if (!$includepreviews) {
        $previewclause = ' AND preview = 0';
    }
    $params=array($quizid);
    if ($userid){
        $userclause = ' AND userid = ?';
        $params[]=$userid;
    } else {
        $userclause = '';
    }
    if ($attempts = $DB->get_records_select('quiz_attempts',
            "quiz = ?" .$userclause. $previewclause . $status_condition[$status], $params,
            'attempt ASC')) {
        return $attempts;
    } else {
        return array();
    }
}

/**
 * Return grade for given user or all users.
 *
 * @global stdClass
 * @global object
 * @param int $quizid id of quiz
 * @param int $userid optional user id, 0 means all users
 * @return array array of grades, false if none. These are raw grades. They should
 * be processed with quiz_format_grade for display.
 */
function quiz_get_user_grades($quiz, $userid=0) {
    global $CFG, $DB;

    $params = array($quiz->id);
    $wheresql = '';
    if ($userid) {
        $params[] = $userid;
        $wheresql = "AND u.id = ?";
    }
    $sql = "SELECT u.id, u.id AS userid, g.grade AS rawgrade, g.timemodified AS dategraded, MAX(a.timefinish) AS datesubmitted
            FROM {user} u, {quiz_grades} g, {quiz_attempts} a
            WHERE u.id = g.userid AND g.quiz = ? AND a.quiz = g.quiz AND u.id = a.userid $wheresql
            GROUP BY u.id, g.grade, g.timemodified";

    return $DB->get_records_sql($sql, $params);
}

/**
 * Round a grade to to the correct number of decimal places, and format it for display.
 *
 * @param object $quiz The quiz table row, only $quiz->decimalpoints is used.
 * @param float $grade The grade to round.
 * @return float
 */
function quiz_format_grade($quiz, $grade) {
    return format_float($grade, $quiz->decimalpoints);
}

/**
 * Round a grade to to the correct number of decimal places, and format it for display.
 *
 * @param object $quiz The quiz table row, only $quiz->decimalpoints is used.
 * @param float $grade The grade to round.
 * @return float
 */
function quiz_format_question_grade($quiz, $grade) {
    if ($quiz->questiondecimalpoints == -1) {
        return format_float($grade, $quiz->decimalpoints);
    } else {
        return format_float($grade, $quiz->questiondecimalpoints);
    }
}

/**
 * Update grades in central gradebook
 *
 * @global stdClass
 * @global object
 * @param object $quiz
 * @param int $userid specific user only, 0 means all
 */
function quiz_update_grades($quiz, $userid=0, $nullifnone=true) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/gradelib.php');

    if ($quiz->grade == 0) {
        quiz_grade_item_update($quiz);

    } else if ($grades = quiz_get_user_grades($quiz, $userid)) {
        quiz_grade_item_update($quiz, $grades);

    } else if ($userid and $nullifnone) {
        $grade = new stdClass();
        $grade->userid   = $userid;
        $grade->rawgrade = NULL;
        quiz_grade_item_update($quiz, $grade);

    } else {
        quiz_grade_item_update($quiz);
    }
}

/**
 * Update all grades in gradebook.
 *
 * @global object
 */
function quiz_upgrade_grades() {
    global $DB;

    $sql = "SELECT COUNT('x')
              FROM {quiz} a, {course_modules} cm, {modules} m
             WHERE m.name='quiz' AND m.id=cm.module AND cm.instance=a.id";
    $count = $DB->count_records_sql($sql);

    $sql = "SELECT a.*, cm.idnumber AS cmidnumber, a.course AS courseid
              FROM {quiz} a, {course_modules} cm, {modules} m
             WHERE m.name='quiz' AND m.id=cm.module AND cm.instance=a.id";
    $rs = $DB->get_recordset_sql($sql);
    if ($rs->valid()) {
        $pbar = new progress_bar('quizupgradegrades', 500, true);
        $i=0;
        foreach ($rs as $quiz) {
            $i++;
            upgrade_set_timeout(60*5); // set up timeout, may also abort execution
            quiz_update_grades($quiz, 0, false);
            $pbar->update($i, $count, "Updating Quiz grades ($i/$count).");
        }
    }
    $rs->close();
}

/**
 * Create grade item for given quiz
 *
 * @global stdClass
 * @uses GRADE_TYPE_VALUE
 * @uses GRADE_TYPE_NONE
 * @uses QUIZ_REVIEW_SCORES
 * @uses QUIZ_REVIEW_CLOSED
 * @uses QUIZ_REVIEW_OPEN
 * @uses PARAM_INT
 * @uses GRADE_UPDATE_ITEM_LOCKED
 * @param object $quiz object with extra cmidnumber
 * @param mixed $grades optional array/object of grade(s); 'reset' means reset grades in gradebook
 * @return int 0 if ok, error code otherwise
 */
function quiz_grade_item_update($quiz, $grades=NULL) {
    global $CFG, $OUTPUT;
    if (!function_exists('grade_update')) { //workaround for buggy PHP versions
        require_once($CFG->libdir.'/gradelib.php');
    }

    if (array_key_exists('cmidnumber', $quiz)) { //it may not be always present
        $params = array('itemname'=>$quiz->name, 'idnumber'=>$quiz->cmidnumber);
    } else {
        $params = array('itemname'=>$quiz->name);
    }

    if ($quiz->grade > 0) {
        $params['gradetype'] = GRADE_TYPE_VALUE;
        $params['grademax']  = $quiz->grade;
        $params['grademin']  = 0;

    } else {
        $params['gradetype'] = GRADE_TYPE_NONE;
    }

/* description by TJ:
1/ If the quiz is set to not show scores while the quiz is still open, and is set to show scores after
   the quiz is closed, then create the grade_item with a show-after date that is the quiz close date.
2/ If the quiz is set to not show scores at either of those times, create the grade_item as hidden.
3/ If the quiz is set to show scores, create the grade_item visible.
*/
    if (!($quiz->review & QUIZ_REVIEW_SCORES & QUIZ_REVIEW_CLOSED)
    and !($quiz->review & QUIZ_REVIEW_SCORES & QUIZ_REVIEW_OPEN)) {
        $params['hidden'] = 1;

    } else if ( ($quiz->review & QUIZ_REVIEW_SCORES & QUIZ_REVIEW_CLOSED)
           and !($quiz->review & QUIZ_REVIEW_SCORES & QUIZ_REVIEW_OPEN)) {
        if ($quiz->timeclose) {
            $params['hidden'] = $quiz->timeclose;
        } else {
            $params['hidden'] = 1;
        }

    } else {
        // a) both open and closed enabled
        // b) open enabled, closed disabled - we can not "hide after", grades are kept visible even after closing
        $params['hidden'] = 0;
    }

    if ($grades  === 'reset') {
        $params['reset'] = true;
        $grades = NULL;
    }

    $gradebook_grades = grade_get_grades($quiz->course, 'mod', 'quiz', $quiz->id);
    if (!empty($gradebook_grades->items)) {
        $grade_item = $gradebook_grades->items[0];
        if ($grade_item->locked) {
            $confirm_regrade = optional_param('confirm_regrade', 0, PARAM_INT);
            if (!$confirm_regrade) {
                $message = get_string('gradeitemislocked', 'grades');
                $back_link = $CFG->wwwroot . '/mod/quiz/report.php?q=' . $quiz->id . '&amp;mode=overview';
                $regrade_link = qualified_me() . '&amp;confirm_regrade=1';
                echo $OUTPUT->box_start('generalbox', 'notice');
                echo '<p>'. $message .'</p>';
                echo $OUTPUT->container_start('buttons');
                echo $OUTPUT->single_button($regrade_link, get_string('regradeanyway', 'grades'));
                echo $OUTPUT->single_button($back_link,  get_string('cancel'));
                echo $OUTPUT->container_end();
                echo $OUTPUT->box_end();

                return GRADE_UPDATE_ITEM_LOCKED;
            }
        }
    }

    return grade_update('mod/quiz', $quiz->course, 'mod', 'quiz', $quiz->id, 0, $grades, $params);
}

/**
 * Delete grade item for given quiz
 *
 * @global stdClass
 * @param object $quiz object
 * @return object quiz
 */
function quiz_grade_item_delete($quiz) {
    global $CFG;
    require_once($CFG->libdir . '/gradelib.php');

    return grade_update('mod/quiz', $quiz->course, 'mod', 'quiz', $quiz->id, 0, NULL, array('deleted' => 1));
}

/**
 * @return the options for calculating the quiz grade from the individual attempt grades.
 */
function quiz_get_grading_options() {
    return array (
            QUIZ_GRADEHIGHEST => get_string('gradehighest', 'quiz'),
            QUIZ_GRADEAVERAGE => get_string('gradeaverage', 'quiz'),
            QUIZ_ATTEMPTFIRST => get_string('attemptfirst', 'quiz'),
            QUIZ_ATTEMPTLAST  => get_string('attemptlast', 'quiz'));
}

/**
 * Returns an array of users who have data in a given quiz
 *
 * @global stdClass
 * @global object
 * @param int $quizid
 * @return array
 */
function quiz_get_participants($quizid) {
    global $CFG, $DB;

    //Get users from attempts
    $us_attempts = $DB->get_records_sql("SELECT DISTINCT u.id, u.id
                                    FROM {user} u,
                                         {quiz_attempts} a
                                    WHERE a.quiz = ? and
                                          u.id = a.userid", array($quizid));

    //Return us_attempts array (it contains an array of unique users)
    return $us_attempts;

}

/**
 * This standard function will check all instances of this module
 * and make sure there are up-to-date events created for each of them.
 * If courseid = 0, then every quiz event in the site is checked, else
 * only quiz events belonging to the course specified are checked.
 * This function is used, in its new format, by restore_refresh_events()
 *
 * @global object
 * @uses QUIZ_MAX_EVENT_LENGTH
 * @param int $courseid
 * @return bool
 */
function quiz_refresh_events($courseid = 0) {
    global $DB;

    if ($courseid == 0) {
        if (! $quizzes = $DB->get_records('quiz')) {
            return true;
        }
    } else {
        if (! $quizzes = $DB->get_records('quiz', array('course' => $courseid))) {
            return true;
        }
    }

    foreach ($quizzes as $quiz) {
        quiz_update_events($quiz);
    }

    return true;
}

/**
 * Returns all quiz graded users since a given time for specified quiz
 */
function quiz_get_recent_mod_activity(&$activities, &$index, $timestart,
        $courseid, $cmid, $userid = 0, $groupid = 0) {
    global $CFG, $COURSE, $USER, $DB;
    require_once('locallib.php');

    if ($COURSE->id == $courseid) {
        $course = $COURSE;
    } else {
        $course = $DB->get_record('course', array('id' => $courseid));
    }

    $modinfo =& get_fast_modinfo($course);

    $cm = $modinfo->cms[$cmid];
    $quiz = $DB->get_record('quiz', array('id' => $cm->instance));

    if ($userid) {
        $userselect = "AND u.id = :userid";
        $params['userid'] = $userid;
    } else {
        $userselect = '';
    }

    if ($groupid) {
        $groupselect = 'AND gm.groupid = :groupid';
        $groupjoin   = 'JOIN {groups_members} gm ON  gm.userid=u.id';
        $params['groupid'] = $groupid;
    } else {
        $groupselect = '';
        $groupjoin   = '';
    }

    $params['timestart'] = $timestart;
    $params['quizid'] = $quiz->id;

    if (!$attempts = $DB->get_records_sql("
              SELECT qa.*,
                     u.firstname, u.lastname, u.email, u.picture, u.imagealt
                FROM {quiz_attempts} qa
                     JOIN {user} u ON u.id = qa.userid
                     $groupjoin
               WHERE qa.timefinish > :timestart
                 AND qa.quiz = :quizid
                 AND qa.preview = 0
                     $userselect
                     $groupselect
            ORDER BY qa.timefinish ASC", $params)) {
        return;
    }

    $context         = get_context_instance(CONTEXT_MODULE, $cm->id);
    $accessallgroups = has_capability('moodle/site:accessallgroups', $context);
    $viewfullnames   = has_capability('moodle/site:viewfullnames', $context);
    $grader          = has_capability('mod/quiz:viewreports', $context);
    $groupmode       = groups_get_activity_groupmode($cm, $course);

    if (is_null($modinfo->groups)) {
        $modinfo->groups = groups_get_user_groups($course->id); // load all my groups and cache it in modinfo
    }

    $usersgroups = null;
    $aname = format_string($cm->name,true);
    foreach ($attempts as $attempt) {
        if ($attempt->userid != $USER->id) {
            if (!$grader) {
                // Grade permission required
                continue;
            }

            if ($groupmode == SEPARATEGROUPS and !$accessallgroups) {
                if (is_null($usersgroups)) {
                    $usersgroups = groups_get_all_groups($course->id,
                            $attempt->userid, $cm->groupingid);
                    if (is_array($usersgroups)) {
                        $usersgroups = array_keys($usersgroups);
                    } else {
                        $usersgroups = array();
                    }
                }
                if (!array_intersect($usersgroups, $modinfo->groups[$cm->id])) {
                    continue;
                }
            }
        }

        $options = quiz_get_reviewoptions($quiz, $attempt, $context);

        $tmpactivity = new stdClass;

        $tmpactivity->type       = 'quiz';
        $tmpactivity->cmid       = $cm->id;
        $tmpactivity->name       = $aname;
        $tmpactivity->sectionnum = $cm->sectionnum;
        $tmpactivity->timestamp  = $attempt->timefinish;

        $tmpactivity->content->attemptid = $attempt->id;
        $tmpactivity->content->attempt   = $attempt->attempt;
        if (quiz_has_grades($quiz) && $options->scores) {
            $tmpactivity->content->sumgrades = quiz_format_grade($quiz, $attempt->sumgrades);
            $tmpactivity->content->maxgrade  = quiz_format_grade($quiz, $quiz->sumgrades);
        } else {
            $tmpactivity->content->sumgrades = null;
            $tmpactivity->content->maxgrade  = null;
        }

        $tmpactivity->user->id        = $attempt->userid;
        $tmpactivity->user->firstname = $attempt->firstname;
        $tmpactivity->user->lastname = $attempt->lastname;
        $tmpactivity->user->fullname = fullname($attempt, $viewfullnames);
        $tmpactivity->user->picture  = $attempt->picture;
        $tmpactivity->user->imagealt = $attempt->imagealt;
        $tmpactivity->user->email = $attempt->email;

        $activities[$index++] = $tmpactivity;
    }

  return;
}

function quiz_print_recent_mod_activity($activity, $courseid, $detail, $modnames) {
    global $CFG, $OUTPUT;

    echo '<table border="0" cellpadding="3" cellspacing="0" class="forum-recent">';

    echo '<tr><td class="userpicture" valign="top">';
    echo $OUTPUT->user_picture($activity->user, array('courseid' => $courseid));
    echo '</td><td>';

    if ($detail) {
        $modname = $modnames[$activity->type];
        echo '<div class="title">';
        echo '<img src="' . $OUTPUT->pix_url('icon', $activity->type) . '" ' .
                'class="icon" alt="' . $modname . '" />';
        echo '<a href="' . $CFG->wwwroot . '/mod/quiz/view.php?id=' .
                $activity->cmid . '">' . $activity->name . '</a>';
        echo '</div>';
    }

    echo '<div class="grade">';
    echo  get_string('attempt', 'quiz', $activity->content->attempt);
    if (isset($activity->content->maxgrade)) {
        $grades = $activity->content->sumgrades . ' / ' . $activity->content->maxgrade;
        echo ': (<a href="' . $CFG->wwwroot . '/mod/quiz/review.php?attempt=' .
                $activity->content->attemptid . '">' . $grades . '</a>)';
    }
    echo '</div>';

    echo '<div class="user">';
    echo '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $activity->user->id .
            '&amp;course=' . $courseid . '">' . $activity->user->fullname .
            '</a> - ' . userdate($activity->timestamp);
    echo '</div>';

    echo '</td></tr></table>';

    return;
}

/**
 * Pre-process the quiz options form data, making any necessary adjustments.
 * Called by add/update instance in this file.
 *
 * @uses QUIZ_REVIEW_OVERALLFEEDBACK
 * @uses QUIZ_REVIEW_CLOSED
 * @uses QUIZ_REVIEW_OPEN
 * @uses QUIZ_REVIEW_IMMEDIATELY
 * @uses QUIZ_REVIEW_GENERALFEEDBACK
 * @uses QUIZ_REVIEW_SOLUTIONS
 * @uses QUIZ_REVIEW_ANSWERS
 * @uses QUIZ_REVIEW_FEEDBACK
 * @uses QUIZ_REVIEW_SCORES
 * @uses QUIZ_REVIEW_RESPONSES
 * @uses QUESTION_ADAPTIVE
 * @param object $quiz The variables set on the form.
 * @return string
 */
function quiz_process_options(&$quiz) {
    $quiz->timemodified = time();

    // Quiz name.
    if (!empty($quiz->name)) {
        $quiz->name = trim($quiz->name);
    }

    // Password field - different in form to stop browsers that remember passwords
    // getting confused.
    $quiz->password = $quiz->quizpassword;
    unset($quiz->quizpassword);

    // Quiz feedback
    if (isset($quiz->feedbacktext)) {
        // Clean up the boundary text.
        for ($i = 0; $i < count($quiz->feedbacktext); $i += 1) {
            if (empty($quiz->feedbacktext[$i]['text'])) {
                $quiz->feedbacktext[$i]['text'] = '';
            } else {
                $quiz->feedbacktext[$i]['text'] = trim($quiz->feedbacktext[$i]['text']);
            }
        }

        // Check the boundary value is a number or a percentage, and in range.
        $i = 0;
        while (!empty($quiz->feedbackboundaries[$i])) {
            $boundary = trim($quiz->feedbackboundaries[$i]);
            if (!is_numeric($boundary)) {
                if (strlen($boundary) > 0 && $boundary[strlen($boundary) - 1] == '%') {
                    $boundary = trim(substr($boundary, 0, -1));
                    if (is_numeric($boundary)) {
                        $boundary = $boundary * $quiz->grade / 100.0;
                    } else {
                        return get_string('feedbackerrorboundaryformat', 'quiz', $i + 1);
                    }
                }
            }
            if ($boundary <= 0 || $boundary >= $quiz->grade) {
                return get_string('feedbackerrorboundaryoutofrange', 'quiz', $i + 1);
            }
            if ($i > 0 && $boundary >= $quiz->feedbackboundaries[$i - 1]) {
                return get_string('feedbackerrororder', 'quiz', $i + 1);
            }
            $quiz->feedbackboundaries[$i] = $boundary;
            $i += 1;
        }
        $numboundaries = $i;

        // Check there is nothing in the remaining unused fields.
        if (!empty($quiz->feedbackboundaries)) {
            for ($i = $numboundaries; $i < count($quiz->feedbackboundaries); $i += 1) {
                if (!empty($quiz->feedbackboundaries[$i]) && trim($quiz->feedbackboundaries[$i]) != '') {
                    return get_string('feedbackerrorjunkinboundary', 'quiz', $i + 1);
                }
            }
        }
        for ($i = $numboundaries + 1; $i < count($quiz->feedbacktext); $i += 1) {
            if (!empty($quiz->feedbacktext[$i]['text']) && trim($quiz->feedbacktext[$i]['text']) != '') {
                return get_string('feedbackerrorjunkinfeedback', 'quiz', $i + 1);
            }
        }
        $quiz->feedbackboundaries[-1] = $quiz->grade + 1; // Needs to be bigger than $quiz->grade because of '<' test in quiz_feedback_for_grade().
        $quiz->feedbackboundaries[$numboundaries] = 0;
        $quiz->feedbackboundarycount = $numboundaries;
    }

    // Settings that get combined to go into the optionflags column.
    $quiz->optionflags = 0;
    if (!empty($quiz->adaptive)) {
        $quiz->optionflags |= QUESTION_ADAPTIVE;
    }

    // Settings that get combined to go into the review column.
    $review = 0;
    if (isset($quiz->responsesimmediately)) {
        $review += (QUIZ_REVIEW_RESPONSES & QUIZ_REVIEW_IMMEDIATELY);
        unset($quiz->responsesimmediately);
    }
    if (isset($quiz->responsesopen)) {
        $review += (QUIZ_REVIEW_RESPONSES & QUIZ_REVIEW_OPEN);
        unset($quiz->responsesopen);
    }
    if (isset($quiz->responsesclosed)) {
        $review += (QUIZ_REVIEW_RESPONSES & QUIZ_REVIEW_CLOSED);
        unset($quiz->responsesclosed);
    }

    if (isset($quiz->scoreimmediately)) {
        $review += (QUIZ_REVIEW_SCORES & QUIZ_REVIEW_IMMEDIATELY);
        unset($quiz->scoreimmediately);
    }
    if (isset($quiz->scoreopen)) {
        $review += (QUIZ_REVIEW_SCORES & QUIZ_REVIEW_OPEN);
        unset($quiz->scoreopen);
    }
    if (isset($quiz->scoreclosed)) {
        $review += (QUIZ_REVIEW_SCORES & QUIZ_REVIEW_CLOSED);
        unset($quiz->scoreclosed);
    }

    if (isset($quiz->feedbackimmediately)) {
        $review += (QUIZ_REVIEW_FEEDBACK & QUIZ_REVIEW_IMMEDIATELY);
        unset($quiz->feedbackimmediately);
    }
    if (isset($quiz->feedbackopen)) {
        $review += (QUIZ_REVIEW_FEEDBACK & QUIZ_REVIEW_OPEN);
        unset($quiz->feedbackopen);
    }
    if (isset($quiz->feedbackclosed)) {
        $review += (QUIZ_REVIEW_FEEDBACK & QUIZ_REVIEW_CLOSED);
        unset($quiz->feedbackclosed);
    }

    if (isset($quiz->answersimmediately)) {
        $review += (QUIZ_REVIEW_ANSWERS & QUIZ_REVIEW_IMMEDIATELY);
        unset($quiz->answersimmediately);
    }
    if (isset($quiz->answersopen)) {
        $review += (QUIZ_REVIEW_ANSWERS & QUIZ_REVIEW_OPEN);
        unset($quiz->answersopen);
    }
    if (isset($quiz->answersclosed)) {
        $review += (QUIZ_REVIEW_ANSWERS & QUIZ_REVIEW_CLOSED);
        unset($quiz->answersclosed);
    }

    if (isset($quiz->solutionsimmediately)) {
        $review += (QUIZ_REVIEW_SOLUTIONS & QUIZ_REVIEW_IMMEDIATELY);
        unset($quiz->solutionsimmediately);
    }
    if (isset($quiz->solutionsopen)) {
        $review += (QUIZ_REVIEW_SOLUTIONS & QUIZ_REVIEW_OPEN);
        unset($quiz->solutionsopen);
    }
    if (isset($quiz->solutionsclosed)) {
        $review += (QUIZ_REVIEW_SOLUTIONS & QUIZ_REVIEW_CLOSED);
        unset($quiz->solutionsclosed);
    }

    if (isset($quiz->generalfeedbackimmediately)) {
        $review += (QUIZ_REVIEW_GENERALFEEDBACK & QUIZ_REVIEW_IMMEDIATELY);
        unset($quiz->generalfeedbackimmediately);
    }
    if (isset($quiz->generalfeedbackopen)) {
        $review += (QUIZ_REVIEW_GENERALFEEDBACK & QUIZ_REVIEW_OPEN);
        unset($quiz->generalfeedbackopen);
    }
    if (isset($quiz->generalfeedbackclosed)) {
        $review += (QUIZ_REVIEW_GENERALFEEDBACK & QUIZ_REVIEW_CLOSED);
        unset($quiz->generalfeedbackclosed);
    }

    if (isset($quiz->overallfeedbackimmediately)) {
        $review += (QUIZ_REVIEW_OVERALLFEEDBACK & QUIZ_REVIEW_IMMEDIATELY);
        unset($quiz->overallfeedbackimmediately);
    }
    if (isset($quiz->overallfeedbackopen)) {
        $review += (QUIZ_REVIEW_OVERALLFEEDBACK & QUIZ_REVIEW_OPEN);
        unset($quiz->overallfeedbackopen);
    }
    if (isset($quiz->overallfeedbackclosed)) {
        $review += (QUIZ_REVIEW_OVERALLFEEDBACK & QUIZ_REVIEW_CLOSED);
        unset($quiz->overallfeedbackclosed);
    }

    $quiz->review = $review;
}

/**
 * This function is called at the end of quiz_add_instance
 * and quiz_update_instance, to do the common processing.
 *
 * @global object
 * @uses QUIZ_MAX_EVENT_LENGTH
 * @param object $quiz the quiz object.
 * @return void|string Void or error message
 */
function quiz_after_add_or_update($quiz) {
    global $DB;
    $cmid = $quiz->coursemodule;

    // we need to use context now, so we need to make sure all needed info is already in db
    $DB->set_field('course_modules', 'instance', $quiz->id, array('id'=>$cmid));
    $context = get_context_instance(CONTEXT_MODULE, $cmid);

    // Save the feedback
    $DB->delete_records('quiz_feedback', array('quizid' => $quiz->id));

    for ($i = 0; $i <= $quiz->feedbackboundarycount; $i++) {
        $feedback = new stdClass;
        $feedback->quizid = $quiz->id;
        $feedback->feedbacktext = $quiz->feedbacktext[$i]['text'];
        $feedback->feedbacktextformat = $quiz->feedbacktext[$i]['format'];
        $feedback->mingrade = $quiz->feedbackboundaries[$i];
        $feedback->maxgrade = $quiz->feedbackboundaries[$i - 1];
        $feedback->id = $DB->insert_record('quiz_feedback', $feedback);
        $feedbacktext = file_save_draft_area_files((int)$quiz->feedbacktext[$i]['itemid'], $context->id, 'mod_quiz', 'feedback', $feedback->id, array('subdirs'=>false, 'maxfiles'=>-1, 'maxbytes'=>0), $quiz->feedbacktext[$i]['text']);
        $DB->set_field('quiz_feedback', 'feedbacktext', $feedbacktext, array('id'=>$feedback->id));
    }

    // Update the events relating to this quiz.
    quiz_update_events($quiz);

    //update related grade item
    quiz_grade_item_update($quiz);

}

/**
 * This function updates the events associated to the quiz.
 * If $override is non-zero, then it updates only the events
 * associated with the specified override.
 *
 * @uses QUIZ_MAX_EVENT_LENGTH
 * @param object $quiz the quiz object.
 * @param object optional $override limit to a specific override
 */
function quiz_update_events($quiz, $override = null) {
    global $DB;

    // Load the old events relating to this quiz.
    $conds = array('modulename'=>'quiz',
                   'instance'=>$quiz->id);
    if (!empty($override)) {
        // only load events for this override
        $conds['groupid'] = isset($override->groupid)?  $override->groupid : 0;
        $conds['userid'] = isset($override->userid)?  $override->userid : 0;
    }
    $oldevents = $DB->get_records('event', $conds);

    // Now make a todo list of all that needs to be updated
    if (empty($override)) {
        // We are updating the primary settings for the quiz, so we
        // need to add all the overrides
        $overrides = $DB->get_records('quiz_overrides', array('quiz' => $quiz->id));
        // as well as the original quiz (empty override)
        $overrides[] = new stdClass;
    }
    else {
        // Just do the one override
        $overrides = array($override);
    }

    foreach ($overrides as $current) {
        $groupid   = isset($current->groupid)?  $current->groupid : 0;
        $userid    = isset($current->userid)? $current->userid : 0;
        $timeopen  = isset($current->timeopen)?  $current->timeopen : $quiz->timeopen;
        $timeclose = isset($current->timeclose)? $current->timeclose : $quiz->timeclose;

        // only add open/close events for an override if they differ from the quiz default
        $addopen  = empty($current->id) || !empty($current->timeopen);
        $addclose = empty($current->id) || !empty($current->timeclose);

        $event = new stdClass;
        $event->description = $quiz->intro;
        $event->courseid    = ($userid) ? 0 : $quiz->course; // Events module won't show user events when the courseid is nonzero
        $event->groupid     = $groupid;
        $event->userid      = $userid;
        $event->modulename  = 'quiz';
        $event->instance    = $quiz->id;
        $event->timestart   = $timeopen;
        $event->timeduration = max($timeclose - $timeopen, 0);
        $event->visible     = instance_is_visible('quiz', $quiz);
        $event->eventtype   = 'open';

        // Determine the event name
        if ($groupid) {
            $params = new stdClass;
            $params->quiz = $quiz->name;
            $params->group = groups_get_group_name($groupid);
            if ($params->group === false) {
                // group doesn't exist, just skip it
                continue;
            }
            $eventname = get_string('overridegroupeventname', 'quiz', $params);
        }
        else if ($userid) {
            $params = new stdClass;
            $params->quiz = $quiz->name;
            $eventname = get_string('overrideusereventname', 'quiz', $params);
        } else {
            $eventname = $quiz->name;
        }
        if ($addopen or $addclose) {
            if ($timeclose and $timeopen and $event->timeduration <= QUIZ_MAX_EVENT_LENGTH) {
                // Single event for the whole quiz.
                if ($oldevent = array_shift($oldevents)) {
                    $event->id = $oldevent->id;
                }
                else {
                    unset($event->id);
                }
                $event->name = $eventname;
                // calendar_event::create will reuse a db record if the id field is set
                calendar_event::create($event);
            } else {
                // Separate start and end events.
                $event->timeduration  = 0;
                if ($timeopen && $addopen) {
                    if ($oldevent = array_shift($oldevents)) {
                        $event->id = $oldevent->id;
                    }
                    else {
                        unset($event->id);
                    }
                    $event->name = $eventname.' ('.get_string('quizopens', 'quiz').')';
                    // calendar_event::create will reuse a db record if the id field is set
                    calendar_event::create($event);
                }
                if ($timeclose && $addclose) {
                    if ($oldevent = array_shift($oldevents)) {
                        $event->id = $oldevent->id;
                    }
                    else {
                        unset($event->id);
                    }
                    $event->name      = $eventname.' ('.get_string('quizcloses', 'quiz').')';
                    $event->timestart = $timeclose;
                    $event->eventtype = 'close';
                    calendar_event::create($event);
                }
            }
        }
    }

    // Delete any leftover events
    foreach ($oldevents as $badevent) {
        $badevent = calendar_event::load($badevent);
        $badevent->delete();
    }
}

/**
 * @return array
 */
function quiz_get_view_actions() {
    return array('view', 'view all', 'report', 'review');
}

/**
 * @return array
 */
function quiz_get_post_actions() {
    return array('attempt', 'close attempt', 'preview', 'editquestions', 'delete attempt', 'manualgrade');
}

/**
 * Returns an array of names of quizzes that use this question
 *
 * @param integer $questionid
 * @return array of strings
 */
function quiz_question_list_instances($questionid) {
    global $CFG, $DB;

    // TODO MDL-5780: we should also consider other questions that are used by
    // random questions in this quiz, but that is very hard.

    $sql = "SELECT q.id, q.name
            FROM {quiz} q
            JOIN {quiz_question_instances} qqi ON q.id = qqi.quiz
            WHERE qqi.question = ?";

    if ($instances = $DB->get_records_sql_menu($sql, array($questionid))) {
        return $instances;
    }
    return array();
}

/**
 * Implementation of the function for printing the form elements that control
 * whether the course reset functionality affects the quiz.
 *
 * @param $mform form passed by reference
 */
function quiz_reset_course_form_definition(&$mform) {
    $mform->addElement('header', 'quizheader', get_string('modulenameplural', 'quiz'));
    $mform->addElement('advcheckbox', 'reset_quiz_attempts', get_string('removeallquizattempts','quiz'));
}

/**
 * Course reset form defaults.
 * @return array
 */
function quiz_reset_course_form_defaults($course) {
    return array('reset_quiz_attempts'=>1);
}

/**
 * Removes all grades from gradebook
 *
 * @global stdClass
 * @global object
 * @param int $courseid
 * @param string optional type
 */
function quiz_reset_gradebook($courseid, $type='') {
    global $CFG, $DB;

    $sql = "SELECT q.*, cm.idnumber as cmidnumber, q.course as courseid
              FROM {quiz} q, {course_modules} cm, {modules} m
             WHERE m.name='quiz' AND m.id=cm.module AND cm.instance=q.id AND q.course=?";

    if ($quizs = $DB->get_records_sql($sql, array($courseid))) {
        foreach ($quizs as $quiz) {
            quiz_grade_item_update($quiz, 'reset');
        }
    }
}

/**
 * Actual implementation of the reset course functionality, delete all the
 * quiz attempts for course $data->courseid, if $data->reset_quiz_attempts is
 * set and true.
 *
 * Also, move the quiz open and close dates, if the course start date is changing.
 *
 * @global stdClass
 * @global object
 * @param object $data the data submitted from the reset course.
 * @return array status array
 */
function quiz_reset_userdata($data) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/questionlib.php');

    $componentstr = get_string('modulenameplural', 'quiz');
    $status = array();

    /// Delete attempts.
    if (!empty($data->reset_quiz_attempts)) {
        $quizzes = $DB->get_records('quiz', array('course' => $data->courseid));
        foreach ($quizzes as $quiz) {
            quiz_delete_all_attempts($quiz);
        }

        // remove all grades from gradebook
        if (empty($data->reset_gradebook_grades)) {
            quiz_reset_gradebook($data->courseid);
        }
        $status[] = array('component' => $componentstr, 'item' => get_string('attemptsdeleted', 'quiz'), 'error' => false);
    }

    /// updating dates - shift may be negative too
    if ($data->timeshift) {
        shift_course_mod_dates('quiz', array('timeopen', 'timeclose'), $data->timeshift, $data->courseid);
        $status[] = array('component' => $componentstr, 'item' => get_string('openclosedatesupdated', 'quiz'), 'error' => false);
    }

    return $status;
}

/**
 * Checks whether the current user is allowed to view a file uploaded in a quiz.
 * Teachers can view any from their courses, students can only view their own.
 *
 * @global object
 * @global object
 * @uses CONTEXT_COURSE
 * @param int $attemptuniqueid int attempt id
 * @param int $questionid int question id
 * @return boolean to indicate access granted or denied
 */
function quiz_check_file_access($attemptuniqueid, $questionid, $context = null) {
    global $USER, $DB, $CFG;
    require_once(dirname(__FILE__).'/attemptlib.php');
    require_once(dirname(__FILE__).'/locallib.php');

    $attempt = $DB->get_record('quiz_attempts', array('uniqueid' => $attemptuniqueid));
    $attemptobj = quiz_attempt::create($attempt->id);

    // does question exist?
    if (!$question = $DB->get_record('question', array('id' => $questionid))) {
        return false;
    }

    if ($context === null) {
        $quiz = $DB->get_record('quiz', array('id' => $attempt->quiz));
        $cm = get_coursemodule_from_id('quiz', $quiz->id);
        $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    }

    // Load those questions and the associated states.
    $attemptobj->load_questions(array($questionid));
    $attemptobj->load_question_states(array($questionid));

    // obtain state
    $state = $attemptobj->get_question_state($questionid);
    // obtain questoin
    $question = $attemptobj->get_question($questionid);

    // access granted if the current user submitted this file
    if ($attempt->userid != $USER->id) {
        return false;
    // access granted if the current user has permission to grade quizzes in this course
    }
    if (!(has_capability('mod/quiz:viewreports', $context) || has_capability('mod/quiz:grade', $context))) {
        return false;
    }

    return array($question, $state, array());
}

/**
 * Prints quiz summaries on MyMoodle Page
 *
 * @global object
 * @global object
 * @param arry $courses
 * @param array $htmlarray
 */
function quiz_print_overview($courses, &$htmlarray) {
    global $USER, $CFG;
/// These next 6 Lines are constant in all modules (just change module name)
    if (empty($courses) || !is_array($courses) || count($courses) == 0) {
        return array();
    }

    if (!$quizzes = get_all_instances_in_courses('quiz', $courses)) {
        return;
    }

/// Fetch some language strings outside the main loop.
    $strquiz = get_string('modulename', 'quiz');
    $strnoattempts = get_string('noattempts', 'quiz');

/// We want to list quizzes that are currently available, and which have a close date.
/// This is the same as what the lesson does, and the dabate is in MDL-10568.
    $now = time();
    foreach ($quizzes as $quiz) {
        if ($quiz->timeclose >= $now && $quiz->timeopen < $now) {
        /// Give a link to the quiz, and the deadline.
            $str = '<div class="quiz overview">' .
                    '<div class="name">' . $strquiz . ': <a ' . ($quiz->visible ? '' : ' class="dimmed"') .
                    ' href="' . $CFG->wwwroot . '/mod/quiz/view.php?id=' . $quiz->coursemodule . '">' .
                    $quiz->name . '</a></div>';
            $str .= '<div class="info">' . get_string('quizcloseson', 'quiz', userdate($quiz->timeclose)) . '</div>';

        /// Now provide more information depending on the uers's role.
            $context = get_context_instance(CONTEXT_MODULE, $quiz->coursemodule);
            if (has_capability('mod/quiz:viewreports', $context)) {
            /// For teacher-like people, show a summary of the number of student attempts.
                // The $quiz objects returned by get_all_instances_in_course have the necessary $cm
                // fields set to make the following call work.
                $str .= '<div class="info">' . quiz_num_attempt_summary($quiz, $quiz, true) . '</div>';
            } else if (has_any_capability(array('mod/quiz:reviewmyattempts', 'mod/quiz:attempt'), $context)) { // Student
            /// For student-like people, tell them how many attempts they have made.
                if (isset($USER->id) && ($attempts = quiz_get_user_attempts($quiz->id, $USER->id))) {
                    $numattempts = count($attempts);
                    $str .= '<div class="info">' . get_string('numattemptsmade', 'quiz', $numattempts) . '</div>';
                } else {
                    $str .= '<div class="info">' . $strnoattempts . '</div>';
                }
            } else {
            /// For ayone else, there is no point listing this quiz, so stop processing.
                continue;
            }

        /// Add the output for this quiz to the rest.
            $str .= '</div>';
            if (empty($htmlarray[$quiz->course]['quiz'])) {
                $htmlarray[$quiz->course]['quiz'] = $str;
            } else {
                $htmlarray[$quiz->course]['quiz'] .= $str;
            }
        }
    }
}

/**
 * Return a textual summary of the number of attemtps that have been made at a particular quiz,
 * returns '' if no attemtps have been made yet, unless $returnzero is passed as true.
 *
 * @param object $quiz the quiz object. Only $quiz->id is used at the moment.
 * @param object $cm the cm object. Only $cm->course, $cm->groupmode and $cm->groupingid fields are used at the moment.
 * @param boolean $returnzero if false (default), when no attempts have been made '' is returned instead of 'Attempts: 0'.
 * @param int $currentgroup if there is a concept of current group where this method is being called
 *         (e.g. a report) pass it in here. Default 0 which means no current group.
 * @return string a string like "Attempts: 123", "Attemtps 123 (45 from your groups)" or
 *          "Attemtps 123 (45 from this group)".
 */
function quiz_num_attempt_summary($quiz, $cm, $returnzero = false, $currentgroup = 0) {
    global $DB, $USER;
    $numattempts = $DB->count_records('quiz_attempts', array('quiz'=> $quiz->id, 'preview'=>0));
    if ($numattempts || $returnzero) {
        if (groups_get_activity_groupmode($cm)) {
            $a->total = $numattempts;
            if ($currentgroup) {
                $a->group = $DB->count_records_sql('SELECT COUNT(DISTINCT qa.id) FROM ' .
                        '{quiz_attempts} qa JOIN ' .
                        '{groups_members} gm ON qa.userid = gm.userid ' .
                        'WHERE quiz = ? AND preview = 0 AND groupid = ?', array($quiz->id, $currentgroup));
                return get_string('attemptsnumthisgroup', 'quiz', $a);
            } else if ($groups = groups_get_all_groups($cm->course, $USER->id, $cm->groupingid)) {
                list($usql, $params) = $DB->get_in_or_equal(array_keys($groups));
                $a->group = $DB->count_records_sql('SELECT COUNT(DISTINCT qa.id) FROM ' .
                        '{quiz_attempts} qa JOIN ' .
                        '{groups_members} gm ON qa.userid = gm.userid ' .
                        'WHERE quiz = ? AND preview = 0 AND ' .
                        "groupid $usql", array_merge(array($quiz->id), $params));
                return get_string('attemptsnumyourgroups', 'quiz', $a);
            }
        }
        return get_string('attemptsnum', 'quiz', $numattempts);
    }
    return '';
}

/**
 * Returns the same as {@link quiz_num_attempt_summary()} but wrapped in a link
 * to the quiz reports.
 *
 * @param object $quiz the quiz object. Only $quiz->id is used at the moment.
 * @param object $cm the cm object. Only $cm->course, $cm->groupmode and $cm->groupingid fields are used at the moment.
 * @param object $context the quiz context.
 * @param boolean $returnzero if false (default), when no attempts have been made '' is returned instead of 'Attempts: 0'.
 * @param int $currentgroup if there is a concept of current group where this method is being called
 *         (e.g. a report) pass it in here. Default 0 which means no current group.
 * @return string HTML fragment for the link.
 */
function quiz_attempt_summary_link_to_reports($quiz, $cm, $context, $returnzero = false, $currentgroup = 0) {
    global $CFG;
    $summary = quiz_num_attempt_summary($quiz, $cm, $returnzero, $currentgroup);
    if (!$summary) {
        return '';
    }

    require_once($CFG->dirroot . '/mod/quiz/report/reportlib.php');
    $url = new moodle_url('/mod/quiz/report.php', array(
            'id' => $cm->id, 'mode' => quiz_report_default_report($context)));
    return html_writer::link($url, $summary);
}

/**
 * @param string $feature FEATURE_xx constant for requested feature
 * @return bool True if quiz supports feature
 */
function quiz_supports($feature) {
    switch($feature) {
        case FEATURE_GROUPS:                  return true;
        case FEATURE_GROUPINGS:               return true;
        case FEATURE_GROUPMEMBERSONLY:        return true;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_GRADE_HAS_GRADE:         return true;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_BACKUP_MOODLE2:          return true;

        default: return null;
    }
}

/**
 * @global object
 * @global stdClass
 * @return array all other caps used in module
 */
function quiz_get_extra_capabilities() {
    global $CFG;
    require_once($CFG->libdir.'/questionlib.php');
    $caps = question_get_all_capabilities();
    $caps[] = 'moodle/site:accessallgroups';
    return $caps;
}

/**
 * This fucntion extends the global navigation for the site.
 * It is important to note that you should not rely on PAGE objects within this
 * body of code as there is no guarantee that during an AJAX request they are
 * available
 *
 * @param navigation_node $quiznode The quiz node within the global navigation
 * @param stdClass $course The course object returned from the DB
 * @param stdClass $module The module object returned from the DB
 * @param stdClass $cm The course module instance returned from the DB
 */
function quiz_extend_navigation($quiznode, $course, $module, $cm) {
    global $CFG;

    $context = get_context_instance(CONTEXT_MODULE, $cm->id);

    if (has_capability('mod/quiz:view', $context)) {
        $url = new moodle_url('/mod/quiz/view.php', array('id'=>$cm->id));
        $quiznode->add(get_string('info', 'quiz'), $url, navigation_node::TYPE_SETTING,
                null, null, new pix_icon('i/info', ''));
    }

    if (has_capability('mod/quiz:viewreports', $context)) {
        require_once($CFG->dirroot.'/mod/quiz/report/reportlib.php');
        $reportlist = quiz_report_list($context);

        $url = new moodle_url('/mod/quiz/report.php', array('id' => $cm->id, 'mode' => reset($reportlist)));
        $reportnode = $quiznode->add(get_string('results', 'quiz'), $url, navigation_node::TYPE_SETTING,
                null, null, new pix_icon('i/report', ''));

        foreach ($reportlist as $report) {
            $url = new moodle_url('/mod/quiz/report.php', array('id' => $cm->id, 'mode' => $report));
            $reportnode->add(get_string($report, 'quiz_'.$report), $url, navigation_node::TYPE_SETTING,
                    null, 'quiz_report_' . $report, new pix_icon('i/item', ''));
        }
    }
}

/**
 * This function extends the settings navigation block for the site.
 *
 * It is safe to rely on PAGE here as we will only ever be within the module
 * context when this is called
 *
 * @param settings_navigation $settings
 * @param navigation_node $quiznode
 */
function quiz_extend_settings_navigation($settings, $quiznode) {
    global $PAGE, $CFG;

    /**
     * Require {@link questionlib.php}
     * Included here as we only ever want to include this file if we really need to.
     */
    require_once($CFG->libdir . '/questionlib.php');

    if (has_capability('mod/quiz:manageoverrides', $PAGE->cm->context)) {
        $url = new moodle_url('/mod/quiz/overrides.php', array('cmid'=>$PAGE->cm->id));
        $quiznode->add(get_string('groupoverrides', 'quiz'), new moodle_url($url, array('mode'=>'group')),
                navigation_node::TYPE_SETTING, null, 'groupoverrides');
        $quiznode->add(get_string('useroverrides', 'quiz'), new moodle_url($url, array('mode'=>'user')),
                navigation_node::TYPE_SETTING, null, 'useroverrides');
    }

    if (has_capability('mod/quiz:manage', $PAGE->cm->context)) {
        $url = new moodle_url('/mod/quiz/edit.php', array('cmid'=>$PAGE->cm->id));
        $text = get_string('editquiz', 'quiz');
        $quiznode->add($text, $url, navigation_node::TYPE_SETTING, null,
                'mod_quiz_edit', new pix_icon('t/edit', ''));
    }

    if (has_capability('mod/quiz:preview', $PAGE->cm->context)) {
        $url = new moodle_url('/mod/quiz/startattempt.php', array('cmid'=>$PAGE->cm->id, 'sesskey'=>sesskey()));
        $quiznode->add(get_string('preview', 'quiz'), $url, navigation_node::TYPE_SETTING,
                null, 'mod_quiz_preview', new pix_icon('t/preview', ''));
    }

    question_extend_settings_navigation($quiznode, $PAGE->cm->context)->trim_if_empty();
}

/**
 * Serves the quiz files.
 *
 * @param object $course
 * @param object $cm
 * @param object $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @return bool false if file not found, does not return if found - justsend the file
 */
function quiz_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload) {
    global $CFG, $DB;

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_login($course, false, $cm);

    if (!$quiz = $DB->get_record('quiz', array('id'=>$cm->instance))) {
        return false;
    }

    // 'intro' area is served by pluginfile.php
    $fileareas = array('feedback');
    if (!in_array($filearea, $fileareas)) {
        return false;
    }

    $feedbackid = (int)array_shift($args);
    if (!$feedback = $DB->get_record('quiz_feedback', array('id'=>$feedbackid))) {
        return false;
    }

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/mod_quiz/$filearea/$feedbackid/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }
    send_stored_file($file, 0, 0, true);
}

/**
 * Called via pluginfile.php -> question_pluginfile to serve files belonging to
 * a question in a question_attempt when that attempt is a quiz attempt.
 *
 * @param object $course course settings object
 * @param object $context context object
 * @param string $component the name of the component we are serving files for.
 * @param string $filearea the name of the file area.
 * @param array $args the remaining bits of the file path.
 * @param bool $forcedownload whether the user must be forced to download the file.
 * @return bool false if file not found, does not return if found - justsend the file
 */
function quiz_question_pluginfile($course, $context, $component,
        $filearea, $uniqueid, $questionid, $args, $forcedownload) {
    global $USER, $CFG;
    require_once($CFG->dirroot . '/mod/quiz/locallib.php');

    $attemptobj = quiz_attempt::create_from_unique_id($uniqueid);
    require_login($attemptobj->get_courseid(), false, $attemptobj->get_cm());
    $questionids = array($questionid);
    $attemptobj->load_questions($questionids);
    $attemptobj->load_question_states($questionids);

    if ($attemptobj->is_own_attempt() && !$attemptobj->is_finished()) {
        // In the middle of an attempt.
        if (!$attemptobj->is_preview_user()) {
            $attemptobj->require_capability('mod/quiz:attempt');
        }
        $isreviewing = false;

    } else {
        // Reviewing an attempt.
        $attemptobj->check_review_capability();
        $isreviewing = true;
    }

    if (!$attemptobj->check_file_access($questionid, $isreviewing, $context->id,
            $component, $filearea, $args, $forcedownload)) {
        send_file_not_found();
    }

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/$component/$filearea/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        send_file_not_found();
    }

    send_stored_file($file, 0, 0, $forcedownload);
}
