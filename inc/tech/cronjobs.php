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

phpinfo();
die('xxx');
ini_set('display_errors', 1);
error_reporting(E_ALL);
$from = "loivietiso@gmail.com";
$to = "loi@vietiso.com";
$subject = "Checking PHP mail";
$message = "PHP mail works just fine";
$headers = "From:" . $from;
@mail($to, $subject, $message, $headers);

print_r('xxxx');
die('xxxx');


ini_set('display_errors', 1);
error_reporting(E_ERROR & ~E_STRICT);//E_ALL
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
require_once DIR_CLASSES . "/class_Sitemap.php";
require_once DIR_CLASSES . "/class_Configuration.php";
require_once DIR_CLASSES . "/class_Country.php";
require_once DIR_CLASSES . "/class_City.php";
require_once DIR_CLASSES . "/class_Package.php";
require_once DIR_CLASSES . "/class_FeaturePackage.php";
#
define("PCMS_URL", (isSecure() ? 'https' : 'http') . "://" . $_SERVER['HTTP_HOST']);

#
$dbconn = &ADONewConnection(DB_TYPE);
if (isset($dbinfo) && is_array($dbinfo)) {
    $dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
} else {
    $dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
$clsConfiguration = new Configuration();
$clsISO = new ISO();

# - Init Domain
$protocol = 'https';
$domain_name = $protocol . '://' . $_SERVER['HTTP_HOST'];


$_LANG_ID = isset($_GET['lang']) ? $_GET['lang'] : LANG_DEFAULT;

if ($_LANG_ID != LANG_DEFAULT) {
    $extLang = '/' . $_LANG_ID;

} else {
    $extLang = '';
}


require_once DIR_CLASSES . "/class_Configuration.php";
$clsConfiguration = new Configuration();

$clsConfiguration->updateValue('cronjobs', '3');

die('xxxx');

?>