<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * The routines here dispatch control to the appropriate handler, which then
 * prints the appropriate page.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 */

/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());

if(!$_REQUEST['form_token']){
	$_racetrkrnonce = $_REQUEST['_racetrkrnonce'];
}
else{
	$_racetrkrnonce = $_REQUEST['form_token'];
}

if (is_array($_racetrkrnonce )){
    $_racetrkrnonce = $_racetrkrnonce[0];
}
$_racetrkrnonce = substr($_racetrkrnonce, 0, 10);
$zy_log_file = fopen("/tmp/reqracer/php_log/drupal_token.log", "a");
flock($zy_log_file, LOCK_EX);
$zy_log_mesg1 = "PID: " . getmypid() . ". ";
$zy_log_mesg1 .= "URL: " . $_SERVER['REQUEST_URI'] . ". ";
$zy_log_mesg1 .= "RequestID: " . $_SERVER['UNIQUE_ID'] . ". ";
$zy_log_mesg1 .= "Action: . ";
$zy_log_mesg1 .= "Referer: " . $_SERVER['HTTP_REFERER'] . ". ";
$zy_log_mesg1 .= "Received Token: " . $_racetrkrnonce . ". ";
$zy_log_mesg1 .= "\r\n";
fwrite($zy_log_file, $zy_log_mesg1);
fflush($zy_log_file);
flock($zy_log_file, LOCK_UN);
fclose($zy_log_file);

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
menu_execute_active_handler();
