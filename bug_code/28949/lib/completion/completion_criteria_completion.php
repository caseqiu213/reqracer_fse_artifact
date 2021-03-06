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
 * Completion data for a specific user, course and critieria
 *
 * @package   moodlecore
 * @copyright 2009 Catalyst IT Ltd
 * @author    Aaron Barnes <aaronb@catalyst.net.nz>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir.'/completion/data_object.php');


/**
 * Completion data for a specific user, course and critieria
 */
class completion_criteria_completion extends data_object {

    /**
     * DB Table
     * @var string $table
     */
    public $table = 'course_completion_crit_compl';

    /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */
    public $required_fields = array('id', 'userid', 'course', 'criteriaid', 'gradefinal', 'rpl', 'deleted', 'unenroled', 'timecompleted');

    /**
     * User ID
     * @access  public
     * @var     int
     */
    public $userid;

    /**
     * Course ID
     * @access  public
     * @var     int
     */
    public $course;

    /**
     * The id of the course completion criteria this completion references
     * @access  public
     * @var     int
     */
    public $criteriaid;

    /**
     * The final grade for the user in the course (if completing a grade criteria)
     * @access  public
     * @var     float
     */
    public $gradefinal;

    /**
     * Record of prior learning, leave blank if none
     * @access  public
     * @var     string
     */
    public $rpl;

    /**
     * Course deleted flag
     * @access  public
     * @var     boolean
     */
    public $deleted;

    /**
     * Timestamp of user unenrolment (if completing a unenrol criteria)
     * @access  public
     * @var     int     (timestamp)
     */
    public $unenroled;

    /**
     * Timestamp of course criteria completion
     * @see     completion_criteria_completion::mark_complete()
     * @access  public
     * @var     int     (timestamp)
     */
    public $timecompleted;

    /**
     * Associated criteria object
     * @access  private
     * @var object  completion_criteria
     */
    private $_criteria;

    /**
     * Finds and returns a data_object instance based on params.
     * @static abstract
     *
     * @param array $params associative arrays varname=>value
     * @return object data_object instance or false if none found.
     */
    public static function fetch($params) {
        $params['deleted'] = null;
        return self::fetch_helper('course_completion_crit_compl', __CLASS__, $params);
    }

    /**
     * Finds and returns all data_object instances based on params.
     * @static abstract
     *
     * @param array $params associative arrays varname=>value
     * @return array array of data_object insatnces or false if none found.
     */
    public static function fetch_all($params) {}

    /**
     * Return status of this criteria completion
     * @access  public
     * @return  boolean
     */
    public function is_complete() {
        return (bool) $this->timecompleted;
    }

    /**
     * Mark this criteria complete for the associated user
     *
     * This method creates a course_completion_crit_compl record
     * @access  public
     * @return  void
     */
    public function mark_complete() {
        // Create record
        $this->timecompleted = time();

        // Save record
        if ($this->id) {
            $this->update();
        } else {
            // error_log("completion criteria completion insert\n", 3, "/tmp/moodle.log");
            $this->insert();
        }

        // Mark course completion record as started (if not already)
        $cc = array(
            'course'    => $this->course,
            'userid'    => $this->userid
        );
        $ccompletion = new completion_completion($cc);
        $ccompletion->mark_inprogress($this->timecompleted);
    }

    /**
     * Attach a preloaded criteria object to this object
     * @access  public
     * @param   $criteria   object  completion_criteria
     * @return  void
     */
    public function attach_criteria(completion_criteria $criteria) {
        $this->_criteria = $criteria;
    }

    /**
     * Return the associated criteria with this completion
     * If nothing attached, load from the db
     * @access  public
     * @return  object completion_criteria
     */
    public function get_criteria() {

        if (!$this->_criteria)
        {
            global $DB;

            $params = array(
                'id'    => $this->criteriaid
            );

            $record = $DB->get_record('course_completion_criteria', $params);

            $this->attach_criteria(completion_criteria::factory($record));
        }

        return $this->_criteria;
    }

    /**
     * Return criteria status text for display in reports
     * @see     completion_criteria::get_status()
     * @access  public
     * @return  string
     */
    public function get_status() {
        return $this->_criteria->get_status($this);
    }
}
