<?php
/**
 * This is the main web entry point for MediaWiki.
 *
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * See the README, INSTALL, and UPGRADE files for basic setup instructions
 * and pointers to the online documentation.
 *
 * https://www.mediawiki.org/
 *
 * ----------
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

# Bail on old versions of PHP.  Pretty much every other file in the codebase
# has structures (try/catch, foo()->bar(), etc etc) which throw parse errors in
# PHP 4. Setup.php and ObjectCache.php have structures invalid in PHP 5.0 and
# 5.1, respectively.
if ( !function_exists( 'version_compare' ) || version_compare( phpversion(), '5.3.2' ) < 0 ) {
	// We need to use dirname( __FILE__ ) here cause __DIR__ is PHP5.3+
	require dirname( __FILE__ ) . '/includes/PHPVersionError.php';
	wfPHPVersionError( 'index.php' );
}

require __DIR__ . '/includes/WebStart.php';
$_racetrkrnonce =  @$_REQUEST['wpEditToken'];
if (is_array($_racetrkrnonce )){
	$_racetrkrnonce = $_racetrkrnonce[0];
}
$zy_log_file = fopen("/tmp/reqracer/php_log/mediawiki_token.log", "a");
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
$mediaWiki = new MediaWiki();
$mediaWiki->run();
