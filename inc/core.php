<?php
#Debugging
define("SMARTY_DEBUG", 	false); //debug or not
define("COMPILE_CHECK", true); //compile check
define("ADODB_DEBUG", 	false); //debug or not
define("STOP_APP_IF_ERROR", 1); //stop if error happen 0: no, 1: yes

#Core Requirement
require_once DIR_COMMON . "/clsDbBasic.php";
require_once DIR_COMMON . "/clsCore.php";
require_once DIR_COMMON . "/clsModule.php";
require_once DIR_COMMON . "/clsCache.php";
require_once DIR_COMMON . "/class.upload.php";
require_once DIR_COMMON . "/Common.php";
require_once DIR_COMMON . "/class.response.php";
require_once DIR_INCLUDES . '/curl/vendor/autoload.php';
require_once DIR_INCLUDES . '/Webp/vendor/autoload.php';

#ClassRequirement
spl_autoload_register(function ($class) {
	if (file_exists(DIR_CLASSES . '/class_' . $class . '.php')) {
		require_once(DIR_CLASSES . '/class_' . $class . '.php');
	} elseif (IS_ADMIN_PAGE == 1 && file_exists(DIR_ADMIN_CLASSES . '/class_' . $class . '.php')) {
		require_once(DIR_ADMIN_CLASSES . '/class_' . $class . '.php');
	}
});

#End ClassRequirement
if (IS_ADMIN_PAGE) {
	require_once DIR_COMMON . "/clsPaging.php";
	require_once DIR_COMMON . "/clsDataSource.php";
	require_once DIR_COMMON . "/clsDataGrid.php";
}

#DriverDatabase
require_once(DIR_ADODB . "/adodb.inc.php");
$dbconn = ADONewConnection(DB_TYPE);
if (isset($dbinfo) && is_array($dbinfo)) {
	$dbconn->connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
} else {
	$dbconn->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
$dbconn->debug = defined('ADODB_DEBUG') ? ADODB_DEBUG : false;

#Private Directory
if (!defined('ISOCMS_THEMES')) {
	$ISOCMS_THEMES = 'default';

	if (!IS_ADMIN_PAGE) {
		// Lấy cấu hình template trong admin
		$result = $dbconn->GetRow("SELECT value FROM default_configuration WHERE setting='SiteTemplate' LIMIT 1");
		if (!empty($result['value'])) {
			$ISOCMS_THEMES = $result['value'];
		}

		// Xử lý systpl từ GET hoặc SESSION
		$systpl = $_GET['systpl'] ?? vnSessionGetVar('systpl') ?? $ISOCMS_THEMES;
		vnSessionSetVar('systpl', $systpl);
		$ISOCMS_THEMES = $systpl;

		// Kiểm tra file template tồn tại
		$dir = dirname(__FILE__) . '/../isocms/templates';
		if (!file_exists("$dir/$systpl/index.tpl")) {
			$ISOCMS_THEMES = 'default';
		}
	}

	define('ISOCMS_THEMES', $ISOCMS_THEMES);
}

define("DIR_THEMES",	DIR_TEMPLATES . "/" . ISOCMS_THEMES . "");
define("URL_THEMES",	URL_TEMPLATES . "/" . ISOCMS_THEMES . "");
#Private Dir
define("DIR_TEMPLATES_C", PCMS_DIR . "/tmp");
define("DIR_IMAGES",	DIR_THEMES . "/skin/images");
define("DIR_CSS", DIR_THEMES . "/skin/css");
define("DIR_JS",	DIR_THEMES . "/skin/js");
#Private Url
define("URL_IMAGES",	URL_THEMES . "/skin/images");
define("URL_CSS", URL_THEMES . "/skin/css");
define("URL_JS",	URL_THEMES . "/skin/js");
define("URL_LIBRARY", URL_THEMES . "/skin/library");

#Smarty TemplateRequirement
require_once(DIR_SMARTY . "/Smarty.class.php");
$smarty = new Smarty();
$smarty->debugging = SMARTY_DEBUG;
$smarty->config_overwrite = true;
$smarty->compile_check = COMPILE_CHECK;

require_once(DIR_SMARTY . "/SmartyBC.class.php");
$smarty = new SmartyBC();
function smarty_block_dynamic($param, $content, &$smarty)
{
	return $content;
}
$smarty->registerPlugin("block", "dynamic", "smarty_block_dynamic");
//$smartyBC->register_block('dynamic', 'smarty_block_dynamic', false);
if (!SHOW_DEBUG_SMARTY) {
	$smarty->loadFilter('output', 'trimwhitespace'); //v3	
}

$smarty->setTemplateDir(DIR_TEMPLATES);
$smarty->setCompileDir(DIR_TEMPLATES_C);
$smarty->setConfigDir(DIR_CONF);

if (IS_ADMIN_PAGE == 1) {
	$smarty->caching = CACHING;
	//Load Language
	$_LANG_ID = LANG_ADMIN_DEFAULT;
	if (isset($_GET['lang']) && !empty($_GET['lang'])) {
		$_LANG_ID = trim($_GET['lang']);
		vnSessionSetVar("ADMINPAGE_LANG", $_LANG_ID);
	} elseif (vnSessionExist("ADMINPAGE_LANG")) {
		$_LANG_ID = vnSessionGetVar("ADMINPAGE_LANG");
	}
} else {
	$smarty->caching = 0;
	$_LANG_ID = LANG_DEFAULT;
	if (isset($_GET['lang']) && !empty($_GET['lang'])) {
		$_LANG_ID = trim($_GET['lang']);
		vnSessionSetVar("_LANG_ID", $_LANG_ID);
	} elseif (vnSessionExist("_LANG_ID")) {
		$_LANG_ID = vnSessionGetVar("_LANG_ID");
	}
}
$smarty->assign("_LANG_ID", $_LANG_ID);
if (LANG_LOAD == 1 && file_exists(DIR_LANG . "/" . $_LANG_ID . ".php")) {
	require_once(DIR_LANG . "/" . $_LANG_ID . ".php");
}

if (file_exists(DIR_CONF . "/" . $_LANG_ID . ".conf")) {
	$smarty->config_load($_LANG_ID . ".conf");
}
#
if (!function_exists('redirect')) {
	function redirect($url)
	{
		header('Location :' . $url);
		exit();
	}
}
