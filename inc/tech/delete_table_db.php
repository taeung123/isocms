<?php
/*======================================================================*\
|| #################################################################### ||
|| # The database configurations of the ISOCMS                        # ||
|| # ISOCMS By VietISO (support@vietiso.com)        			      # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2025 VietISO JSC.             # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/

define("PCMS_DIR", $_SERVER['DOCUMENT_ROOT']);
#Common Directory
define("DIR_INCLUDES", PCMS_DIR . "/inc");
define("DIR_LANG", PCMS_DIR . "/lang");
define("DIR_LOGS", PCMS_DIR . "/logs");
define("DIR_THEMES", PCMS_DIR . "/themes");
define("DIR_TMP", PCMS_DIR . "/tmp");
define("DIR_UPLOADS", PCMS_DIR . "/uploads");
define("DIR_CLASSES", PCMS_DIR . "/classes");
define("DIR_COMMON", DIR_INCLUDES . "/iso");
define("DIR_SMARTY", DIR_INCLUDES . "/smarty");
define("DIR_ADODB", DIR_INCLUDES . "/adodb");
define("DIR_PEAR", DIR_INCLUDES . "/PEAR");
define("DIR_LIB", DIR_INCLUDES . "/lib");
define("DIR_CONF", DIR_INCLUDES . "/conf");
//=================================================================================
//Include needle file
//=================================================================================
require_once(PCMS_DIR . "/config.php");
require_once DIR_ADODB . '/adodb.inc.php';
require_once DIR_COMMON . '/clsDbBasic.php';
require_once DIR_CLASSES . "/class_ISO.php";
#
define("PCMS_URL", (isSecure() ? 'https' : 'http') . "://" . $_SERVER['HTTP_HOST']);

#
$dbconn = &ADONewConnection(DB_TYPE);
if (isset($dbinfo) && is_array($dbinfo)) {
    $dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
} else {
    $dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

die('xxx');
$tables = array("default_billing", "default_booking", "default_feedback", "default_reviews", "default_subscribe", "default_tour_price_group", "default_tour_season_price", "default_tour_customfield", "default_cruise_customfield", "default_hotel_customfield", "default_tour_start_date");
//foreach($tables as $table) {
//  $query = "DELETE FROM $table";
//  $dbconn->Execute($query);
//}


?>
