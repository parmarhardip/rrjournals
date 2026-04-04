<?php
/**
 * Security: Prevent direct access
 */
defined( 'ABSPATH' ) || exit;

// Security: Start session with secure settings
if ( ! session_id() ) {
	if ( ini_get( 'session.use_only_cookies' ) != 1 ) {
		ini_set( 'session.use_only_cookies', 1 );
	}
	if ( ini_get( 'session.cookie_httponly' ) != 1 ) {
		ini_set( 'session.cookie_httponly', 1 );
	}
	session_start();
}

// Security: Generate stronger CAPTCHA code
$chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ23456789'; // Removed confusing chars
$code = substr( str_shuffle( $chars ), 0, 5 );
$_SESSION["code"] = $code;
$im = imagecreatetruecolor(50, 24);
$bg = imagecolorallocate($im, 22, 86, 165);
$fg = imagecolorallocate($im, 255, 255, 255);
imagefill($im, 0, 0, $bg);
imagestring($im, 5, 5, 5,  $code, $fg);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>
