<?php
/*======================================================================*\
|| #################################################################### ||
|| # The init configurations of the ISOCMS                            # ||
|| # Travel Master 6.0.0 By VietISO Company JSC (support@vietiso.com) # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
///usr/local/bin/php /home/okrsvita/domains/okrs.vita.vn/public_html/cronjobs/Event.php
/*
|-----------------------------------
| Default timezone for Vietnam
|-----------------------------------
*/
//ini_set('display_errors',1);
//error_reporting(E_ALL & ~E_STRICT);//E_ALL

date_default_timezone_set('Asia/Ho_Chi_Minh');
header('Content-Type: text/html; charset=utf-8');
if (!function_exists('vsprint_r')) {
	function vsprint_r($doc)
	{
		print('<pre>' . print_r($doc, true) . '</pre>');
		die();
	}
}
/*
|--------------------------------------------
| Is HTTPS?
| Determines if the application is accessed via an encrypted
| (HTTPS) connection.
| @return	bool
|---------------------------------------------
|
*/
function is_https()
{
	if (! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
		return TRUE;
	} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
		return TRUE;
	} elseif (! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
		return TRUE;
	}
	return FALSE;
}
define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);
define('SITE_PROTOCOL', is_https() ? 'https://' : 'http://');
define('SITE_URL', SITE_PROTOCOL . $_SERVER['HTTP_HOST']);

require_once(ABSPATH . '/init.php');
require_once(DIR_ADODB . '/adodb.inc.php');
require_once(DIR_COMMON . '/clsDbBasic.php');

#- Database handle
$dbconn = ADONewConnection(DB_TYPE);
if (isset($dbinfo) && is_array($dbinfo)) {
	$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
	$dbconn->EXECUTE("set names 'utf8'");
} else {
	$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$dbconn->EXECUTE("set names 'utf8'");
}
#- Loader class/model
function autoload($class)
{
	if (file_exists(DIR_CLASSES . '/class_' . $class . '.php')) {
		require_once(DIR_CLASSES . '/class_' . $class . '.php');
	} else if (file_exists(DIR_CLASSES . '/class.' . $class . '.php')) {
		require_once(DIR_CLASSES . '/class.' . $class . '.php');
	}
}
spl_autoload_register('autoload');
#
$clsISO = new ISO();
$CFG = new Configuration();
$CFG->updateValue('cronjobs', '1');
die('Crontabs run success !!');
exit();
