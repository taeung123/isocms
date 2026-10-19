<?php
function isSecure() {
  return
	(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
	|| $_SERVER['SERVER_PORT'] == 443;
}

define("PCMS_DIR", $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']));
define("PCMS_URL", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
#Common Directory
define("DIR_INCLUDES", 	PCMS_DIR."/inc");
define("DIR_LANG", 		PCMS_DIR."/lang");
define("DIR_LOGS", 		PCMS_DIR."/logs");
define("DIR_THEMES", 	PCMS_DIR."/themes");
define("DIR_TMP", 		PCMS_DIR."/tmp");
define("DIR_UPLOADS",	PCMS_DIR."/uploads");
define("DIR_CLASSES", 	PCMS_DIR."/classes");
define("DIR_COMMON", 	DIR_INCLUDES."/iso");
define("DIR_SMARTY", 	DIR_INCLUDES."/smarty");
define("DIR_ADODB", 	DIR_INCLUDES."/adodb");
define("DIR_PEAR", 		DIR_INCLUDES."/PEAR");
define("DIR_LIB", 		DIR_INCLUDES."/lib");
define("DIR_CONF", 		DIR_INCLUDES."/conf");

define("URL_THEMES", 	PCMS_URL."/isocms/templates/default/skin");
define("DIR_TEMPLATES", PCMS_DIR."/isocms/templates/default/");
define("URL_CSS", 		URL_THEMES."/css");
define("URL_JS", 		URL_THEMES."/js");

//require_once(DIR_INCLUDES.'/minifyJS.php');
$page= isset($_GET['sPage']) ? $_GET['sPage'] : '';

$minExpected = '';
$minExpected .= file_get_contents(URL_JS.'/jquery-1.10.2.min.js');
$minExpected .= file_get_contents(URL_JS.'/datepicker/jquery-ui.js');
$minExpected .= file_get_contents(URL_JS.'/owl/owl.carousel.js');
$minExpected .= file_get_contents(URL_JS.'/jquery-migrate-1.2.1.min.js');

$minExpected .= file_get_contents(URL_JS.'/jquery.validate.js');
$minExpected .= file_get_contents(URL_JS.'/jquery.form.js');
$minExpected .= file_get_contents(URL_JS.'/tipsy/tipsy.js');

$minExpected .= file_get_contents(URL_JS.'/venobox/venobox.min.js');
$minExpected .= file_get_contents(URL_JS.'/vietiso.js');
#
function compress( $minify ) {
	/* remove comments */
	$minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify );
	/* remove tabs, spaces, newlines, etc. */
	//$minify = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $minify );
	return $minify;
}
/*$minOutput = JSMin::minify($minExpected);*/
$minOutput = compress($minExpected);
@file_put_contents(DIR_TEMPLATES.'/skin/js/global.min.js',$minOutput);
#
$sLastModified = gmdate('D, d M Y H:i:s', time()).' GMT';
header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31356000).' GMT'); /*1 year from now*/
header('Content-Type: text/javascript');
header('Content-Length: '.strlen($minOutput));
header("Last-Modified: $sLastModified");
header('Cache-Control: max-age= 31356000');
echo $minOutput;
?>