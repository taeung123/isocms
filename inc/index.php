<?php
// ini_set('display_errors', 1);
//     ini_set('display_startup_errors', '1');
//     error_reporting(E_ALL & ~E_STRICT);
/*Kernel of system*/
require_once(DIR_INCLUDES . "/core.php");
#Lấy danh sách package feature quyền
$clsPackage = new Package();
$clsConfiguration = new Configuration();
$clsISO = new ISO();
global $array_list_feature_package_id, $package_id;
if (strlen(strstr(DOMAIN_NAME, 'essentials.isocms.com')) > 0) {
	$package_id = 1;
} elseif (strlen(strstr(DOMAIN_NAME, 'professional.isocms.com')) > 0) {
	$package_id = 2;
} elseif (strlen(strstr(DOMAIN_NAME, 'premium.isocms.com')) > 0) {
	$package_id = 3;
} else {
	$package_id = PACKAGE_ID;
}
$list_feature_package_id = $clsPackage->getOneField('list_feature_package_id', $package_id);
$array_list_feature_package_id = !empty($list_feature_package_id) ? unserialize($list_feature_package_id) : [];
#
$lstConfig = $clsConfiguration->getAll("setting IN ('SiteHasTourPromotion', 'SiteHasTourDeparture', 'SiteHasTourLastHour')", 'setting, value');
$config = [];
if (is_array($lstConfig)) {
	foreach ($lstConfig as $item) {
		if (isset($item['setting'], $item['value'])) {
			$config[$item['setting']] = $item['value'];
		}
	}
}
define('_IS_PROMOTION', $config['SiteHasTourPromotion'] ?? 0);
define('_IS_DEPARTURE', $config['SiteHasTourDeparture'] ?? 0);
define('_IS_LASTHOUR', $config['SiteHasTourLastHour'] ?? 0);
function data_upload_image_word_textarea($match)
{
	global $clsISO;
	$year = date("Y");
	if (!is_dir(_isoman_dir . '/content/' . $year)) {
		$clsISO->rmkdir(_isoman_dir . '/content/' . $year, 0777);
	}
	$month = date("m");
	if (!is_dir(_isoman_dir . '/content/' . $year . '/' . $month . '-' . $year)) {
		$clsISO->rmkdir(_isoman_dir . '/content/' . $year . '/' . $month . '-' . $year, 0777);
	}
	list(, $img, $type, $base64, $end) = $match;
	$bin = base64_decode($base64);
	$md5 = md5($bin);   // generate a new temporary filename
	$fn = _isoman_dir . '/content/' . $year . '/' . $month . '-' . $year . '/' . $md5 . '.' . $type;
	$imageurl  = DOMAIN_NAME . '/uploads/content/' . $year . '/' . $month . '-' . $year . '/' . $md5 . '.' . $type;
	file_exists($fn) or file_put_contents($fn, $bin);
	return "$img$imageurl$end";  // new <img> tag
}
/** =====================================================================* 
	INITIATION SECTION  
 * =====================================================================*/
$mod = $stdio->GET("mod", "home");
$act = $stdio->GET("act", "default");
$core = new Core();
/** =====================================================================*
	CONTROL SECTION  
 * =====================================================================*/
// chạy server
if ($core->isAjax()) {
	$assign_list["mod"] = $mod;
	$assign_list["core"] = $core;
	$smarty->assign($assign_list);
	require_once(ISOCMS_DIR . "/_header_ajax.php");
	if (file_exists(DIR_MODULES . "/$mod/index.php")) {
		require_once(DIR_MODULES . "/$mod/index.php");
	} else {
		$html = "module does not exist: " . DIR_MODULES . "/$mod/index.php";
		echo ($html);
		die();
	}
} else {
	// 124.158.4.43
	if ($_SERVER['REMOTE_ADDR'] == '') {
		global $cache_id;
		// $clsISO->dd($_POST);
		$clsISO->rateLimitIP();

		/* ================= CACHE CONFIG ================= */

		$smarty->caching = Smarty::CACHING_LIFETIME_CURRENT;
		$smarty->cache_lifetime = cache_lifetime;

		/* ================= BUILD CACHE_ID ================= */

		$cache_params = $_GET;

		/* Sort để tránh cache sai thứ tự param */
		ksort($cache_params);

		/* Convert array → string */
		$cache_params = http_build_query($cache_params);

		$key_cache_id =
			$_SERVER['REQUEST_URI']
			. '|theme=' . ISOCMS_THEMES
			. '|' . $cache_params;

		/* Hash để filename ngắn */
		$cache_id = md5($key_cache_id);

		/* ================= CLEAR CACHE ================= */

		if (isset($_GET['clearCache'])) {

			$clearCache = md5($_GET['clearCache']);

			$smarty->clear_cache(
				DIR_THEMES . "/index.tpl",
				$clearCache
			);
		}

		if (isset($_GET['clearAllCache'])) {

			$smarty->clearAllCache();
		}

		/* ================= ONLY RUN MODULE IF NOT CACHED ================= */

		if (!$smarty->isCached(
			DIR_THEMES . "/index.tpl",
			$cache_id
		)) {

			require_once(ISOCMS_DIR . "/_header.php");

			if (file_exists(DIR_MODULES . "/$mod/index.php")) {

				require_once(DIR_MODULES . "/$mod/index.php");
			} else {

				echo "module does not exist: "
					. DIR_MODULES . "/$mod/index.php";

				die();
			}

			require_once(ISOCMS_DIR . "/_footer.php");

			/* Assign template */

			$assign_list["lstCssStylesheet"] = Asset::getCssStylesheet();
			$assign_list["lstCssPreload"]   = Asset::getCssPreload();
			$assign_list["lstJsDefer"]      = Asset::getJsDefer();
			$assign_list["lstJsAsync"]      = Asset::getJsAsync();

			$assign_list["mod"]  = $mod;
			$assign_list["core"] = $core;

			$smarty->assign($assign_list);
		}

		/* ================= DISPLAY ================= */

		$smarty->display(
			DIR_THEMES . "/index.tpl",
			$cache_id
		);
	} else {
		$clsISO->rateLimitIP();
		require_once(ISOCMS_DIR . "/_header.php");
		if (file_exists(DIR_MODULES . "/$mod/index.php")) {
			require_once(DIR_MODULES . "/$mod/index.php");
		} else {
			$html = "module does not exist: " . DIR_MODULES . "/$mod/index.php";
			echo ($html);
			die();
		}
		require_once(ISOCMS_DIR . "/_footer.php");
		/*Display template*/
		$assign_list["lstCssStylesheet"] = Asset::getCssStylesheet();
		$assign_list["lstCssPreload"] = Asset::getCssPreload();
		$assign_list["lstJsDefer"] = Asset::getJsDefer();
		$assign_list["lstJsAsync"] = Asset::getJsAsync();
		$assign_list["mod"] = $mod;
		$assign_list["core"] = $core;
		$smarty->assign($assign_list);
		$cache_id = md5($_SERVER['REQUEST_URI'] . ISOCMS_THEMES);
		if (isset($_GET['clearCache'])) {
			$clearCache = md5($_GET['clearCache']);
			$smarty->clear_cache(DIR_THEMES . "/index.tpl", $clearCache);
		}
		if (isset($_GET['clearAllCache'])) {
			$smarty->clearAllCache();
		}
		$smarty->cache_lifetime = cache_lifetime;
		$smarty->display(DIR_THEMES . "/index.tpl", $cache_id);
	}
}
session_write_close();
$clsISO->runDefers();
