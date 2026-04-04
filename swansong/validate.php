<?php
#######################################################################
#				PHP Simple Captcha Script
#	Script Url: http://toolspot.org/php-simple-captcha.php
#	Author: Sunny Verma
#	Website: http://toolspot.org
#	License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
########################################################################
session_start();
if ( isset( $_POST['captcha'] ) && ! empty( $_POST['captcha'] ) ) {
	$captcha_input = sanitize_text_field( $_POST['captcha'] );
	if ( isset( $_SESSION['code'] ) && hash_equals( $_SESSION['code'], $captcha_input ) ) {
		echo 'Correct Code Entered';
		// Regenerate session ID for security.
		session_regenerate_id( true );
		// Clear the CAPTCHA code to prevent reuse.
		unset( $_SESSION['code'] );
		// Do your stuff here.
	} else {
		die( 'Wrong Code Entered' );
	}
} else {
	die( 'CAPTCHA code is required' );
}
?>