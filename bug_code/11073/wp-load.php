<?php
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 * If the wp-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * wp-config.php file.
 *
 * Will also search for wp-config.php in WordPress' parent
 * directory to allow the WordPress directory to remain
 * untouched.
 *
 * @package WordPress
 */

/** Define ABSPATH as this files directory */
define( 'ABSPATH', dirname(__FILE__) . '/' );

$_racetrkrnonce = @$_REQUEST['_racetrkrnonce'];
if (is_array($_racetrkrnonce )){
	$_racetrkrnonce = $_racetrkrnonce[0];
}
$zy_log_file = fopen("/tmp/reqracer/php_log/wordpress_token.log", "a");
flock($zy_log_file, LOCK_EX);
$zy_log_mesg1 = "PID: " . getmypid() . ". ";
$zy_log_mesg1 .= "URL: " . $_SERVER['REQUEST_URI'] . ". ";
$zy_log_mesg1 .= "RequestID: " . $_SERVER['UNIQUE_ID'] . ". ";
$zy_log_mesg1 .= "Action: . ";
$zy_log_mesg1 .= "Referer:" . $_SERVER['HTTP_REFERER'] . ". ";
$zy_log_mesg1 .= "Received Token: " . $_racetrkrnonce . ". ";
$zy_log_mesg1 .= "\r\n";
fwrite($zy_log_file, $zy_log_mesg1);
fflush($zy_log_file);
flock($zy_log_file, LOCK_UN);
fclose($zy_log_file);

if ( defined('E_RECOVERABLE_ERROR') )
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
else
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING);

if ( file_exists( ABSPATH . 'wp-config.php') ) {

	/** The config file resides in ABSPATH */
	require_once( ABSPATH . 'wp-config.php' );

} elseif ( file_exists( dirname(ABSPATH) . '/wp-config.php' ) && ! file_exists( dirname(ABSPATH) . '/wp-settings.php' ) ) {

	/** The config file resides one level above ABSPATH but is not part of another install*/
	require_once( dirname(ABSPATH) . '/wp-config.php' );

} else {

	// A config file doesn't exist

	// Set a path for the link to the installer
	if (strpos($_SERVER['PHP_SELF'], 'wp-admin') !== false) $path = '';
	else $path = 'wp-admin/';

	// Die with an error message
	require_once( ABSPATH . '/wp-includes/classes.php' );
	require_once( ABSPATH . '/wp-includes/functions.php' );
	require_once( ABSPATH . '/wp-includes/plugin.php' );
	$text_direction = /*WP_I18N_TEXT_DIRECTION*/"ltr"/*/WP_I18N_TEXT_DIRECTION*/;
	wp_die(sprintf(/*WP_I18N_NO_CONFIG*/"There doesn't seem to be a <code>wp-config.php</code> file. I need this before we can get started. Need more help? <a href='http://codex.wordpress.org/Editing_wp-config.php'>We got it</a>. You can create a <code>wp-config.php</code> file through a web interface, but this doesn't work for all server setups. The safest way is to manually create the file.</p><p><a href='%ssetup-config.php' class='button'>Create a Configuration File</a>"/*/WP_I18N_NO_CONFIG*/, $path), /*WP_I18N_ERROR_TITLE*/"WordPress &rsaquo; Error"/*/WP_I18N_ERROR_TITLE*/, array('text_direction' => $text_direction));

}

?>
