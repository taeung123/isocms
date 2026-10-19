<?php
/* ini_set('display_errors',1);
	error_reporting(E_ALL);  */
#- Enable cache browser
header("Cache-Control: must-revalidate");

/* duration of cached content (1 hour) */
$offset = 60 * 60 * 24;
/* expiration header format */
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
/* send cache expiration header to broswer */
header($ExpStr);

global $smarty, $assign_list, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page,
	$global_title_page, $global_description_page, $global_keyword_page, $_LANG_ID, $_CONFIG, $clsConfiguration, $country_id, $agent_id, $profile_id, $lang_sql, $adult_type_id, $child_type_id, $infant_type_id, $age_type_id, $height_type_id, $deviceType, $lstCountryEx, $package_id;

global $email_template_book_tour_id, $email_template_book_cruise_id, $email_template_book_hotel_id, $email_template_contact_id, $email_template_book_service_id, $email_template_tailor_id, $email_template_reg_advisory, $email_template_subscribe_id, $email_template_payment_onepay_id, $email_template_payment_paypal_id, $email_template_signup_id, $email_template_change_pass_id, $email_template_reset_pass_id, $email_template_agent_id, $about_us_id;

global $agent_id, $email_template_signup_agent_id, $email_template_signup_ctv_id, $email_template_active_agent_id, $email_template_update_profile_agent_id, $email_template_block_agent_id, $email_template_change_pass_agent_id, $email_template_reset_pass_agent_id, $is_agent, $email_template_review_tour_id, $email_template_review_cruise_id, $clsISO, $hasAPI, $now_day;

global $clsISO, $now_day, $short_rate, $package_id;
global $is_mod_member, $is_tour_departure_point, $now_month;

$clsISO = new ISO();
$assign_list["clsISO"] = $clsISO;
$clsConfiguration = new Configuration();
$assign_list["clsConfiguration"] = $clsConfiguration;

$_LANG_ID = isset($_GET['lang']) ? $_GET['lang'] : $_LANG_ID;

if (empty($_LANG_ID)) {
	$_LANG_ID = LANG_DEFAULT;
}

$assign_list["_LANG_ID"] = $_LANG_ID;


$listLang = $clsISO->getListLang();
$assign_list["listLang"] = $listLang;

if ($_LANG_ID != LANG_DEFAULT) {
	$extLang = '/' . $_LANG_ID;
	$HOMEPAGE_URL = '/' . $_LANG_ID . '/';
} else {
	$extLang = '';
	$HOMEPAGE_URL = '/';
}
if ($_LANG_ID != 'en') {
	$lang_sql = $_LANG_ID;
} else {
	$lang_sql = '';
}

$assign_list['extLang'] = $extLang;
$assign_list['HOMEPAGE_URL'] = $HOMEPAGE_URL;
$assign_list["lang_sql"] = $lang_sql;
#
$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
$assign_list["isiPad"] = $isiPad;
#
require_once(DIR_INCLUDES . '/Mobile_Detect.php');
$detect = new Mobile_Detect();
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$assign_list["deviceType"] = $deviceType;
#
if (preg_match("/msie 6.0/i", $_SERVER['HTTP_USER_AGENT']))
	$use_browser = "InternetExplorer6";
elseif (preg_match("/msie 7.0/i", $_SERVER['HTTP_USER_AGENT']))
	$use_browser = "InternetExplorer7";
elseif (preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT']))
	$use_browser = "Firefox";
elseif (preg_match("/Chrome/i", $_SERVER['HTTP_USER_AGENT']))
	$use_browser = "Chrome";
else
	$use_browser = "Other";


$assign_list["upd_version"] = time();
$assign_list["smarty"] = $smarty;
$assign_list['sid'] = session_id();


$assign_list['now'] = time();
$assign_list['now_next'] = time() + (24 * 60 * 60);
$assign_list['now_next_2_day'] = time() + (2 * 24 * 60 * 60);
$current_date = date('m/d/Y');
$current_time = strtotime($current_date);
$now_day = $current_time;
$assign_list['now_day'] = $now_day;
$now_month = date('m', time());
$assign_list['now_month'] = $now_month;

$short_rate = $clsISO->getShortRate();
$assign_list["short_rate"] = $short_rate;


#- End Payment Gateway config
$clsWishlist = new Wishlist();
$assign_list["clsWishlist"] = $clsWishlist;

$assign_list["_ISOCMS_CLIENT_LOGIN"] = _ISOCMS_CLIENT_LOGIN;
if (_IS_TRAVEL_AGENT) {
	$clsAgent = new Agent();
	$assign_list["clsAgent"] = $clsAgent;
	$agentLoggedIn = $clsAgent->isLoggedIn();
	$assign_list["agentLoggedIn"] = $agentLoggedIn;
	if ($agentLoggedIn == 1) {
		$agent_id = $clsAgent->getUserID();
		$assign_list["agent_id"] = $agent_id;
		$oneAgent = $clsAgent->getOne($agent_id);
		$assign_list["oneAgent"] = $oneAgent;

		$is_agent = $oneAgent['type'];
		$assign_list['is_agent'] = $is_agent;
	}
}
if (_ISOCMS_CLIENT_LOGIN) {
	$clsProfile = new Profile();
	$assign_list["clsProfile"] = $clsProfile;

	$assign_list["appID"] = appID;
	$assign_list["AppSecret"] = AppSecret;

	$assign_list["GoogleID"] = GoogleID;
	$assign_list["GoogleSecret"] = GoogleSecret;

	$loggedIn = $clsProfile->isLoggedIn();
	$assign_list["loggedIn"] = $loggedIn;

	if ($loggedIn == 1) {
		$profile_id = $clsProfile->getUserID();
		$assign_list["profile_id"] = $profile_id;
		$oneProfile = $clsProfile->getOne($profile_id);
		$assign_list["oneProfile"] = $oneProfile;
		$folder_name = $oneProfile['username'] . '_' . $profile_id;
		if (!file_exists('/home/isocms/domains/isocms.com/private_html/uploads/datastore/' . $folder_name)) {
			mkdir('/home/isocms/domains/isocms.com/private_html/uploads/datastore/' . $folder_name);
			chmod('/home/isocms/domains/isocms.com/private_html/uploads/datastore/' . $folder_name, 0777);
		}
		#
		$is_agent = 0;
		if (isset($oneProfile['is_agent'])) {
			$is_agent = $oneProfile['is_agent'];
		}
		$assign_list["is_agent"] = $is_agent; //print_r($is_agent); die();
		#- Wishlist
		$numWishlist = $clsWishlist->getAll("member_id='$profile_id'");
		$numWishlist = $numWishlist ? count($numWishlist) : 0;
		$assign_list["numWishlist"] = $numWishlist;
	}
}

$return_url = '';
if (vnSessionExist('Link_login_book')) {
	$return_url = vnSessionGetVar('Link_login_book');
} else {
	$return_url = isset($_GET['return_url']) ? $_GET['return_url'] : '';
}
$assign_list['return_url'] = $return_url;

$clsTourProperty = new TourProperty();
$adult_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 0,1");
$adult_type_id = $adult_type_id[0]['tour_property_id'];
$child_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 1,1");
$child_type_id = $child_type_id[0]['tour_property_id'];
$infant_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 2,1");
$infant_type_id = $infant_type_id[0]['tour_property_id'];

$lstAgeType = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORAGETYPE' order by order_no ASC limit 0,1", $clsTourProperty->pkey);
$age_type_id = $lstAgeType[0][$clsTourProperty->pkey] ? $lstAgeType[0][$clsTourProperty->pkey] : 0;

$lstHeightType = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORHEIGHTTYPE' order by order_no ASC limit 0,1", $clsTourProperty->pkey);
$height_type_id = $lstHeightType[0][$clsTourProperty->pkey] ? $lstHeightType[0][$clsTourProperty->pkey] : 0;

$assign_list["adult_type_id"] = $adult_type_id;
$assign_list["child_type_id"] = $child_type_id;
$assign_list["infant_type_id"] = $infant_type_id;
$assign_list["age_type_id"] = $age_type_id;
$assign_list["height_type_id"] = $height_type_id;

/*/////Setting Email Template ID/////*/
$email_template_tailor_id = 1;
$email_template_subscribe_id = 3;
$email_template_book_tour_id = 4;
$email_template_book_hotel_id = 5;
$email_template_contact_id = 6;
$email_template_signup_id = 7;
$email_template_book_cruise_id = 14;
$email_template_reg_advisory = 97;
$email_template_book_service_id = 45;
$email_template_payment_onepay_id = 46;
$email_template_payment_paypal_id = 47;
$email_template_change_pass_id = 26;
$email_template_reset_pass_id = 15;
$email_template_review_tour_id = 128;
$email_template_review_cruise_id = 129;
//Agent
$email_template_signup_agent_id = 98;
$email_template_signup_ctv_id = 33;
$email_template_active_agent_id = 110;
$email_template_update_profile_agent_id = 116;
$email_template_block_agent_id = 122;
$email_template_change_pass_agent_id = 39;
$email_template_reset_pass_agent_id = 30;
$email_template_agent_id = 133;


if (strlen(strstr(DOMAIN_NAME, 'essentials.isocms.com')) > 0) {
	$package_id = 1;
} elseif (strlen(strstr(DOMAIN_NAME, 'professional.isocms.com')) > 0) {
	$package_id = 2;
} elseif (strlen(strstr(DOMAIN_NAME, 'premium.isocms.com')) > 0) {
	$package_id = 3;
} else {
	$package_id = PACKAGE_ID;
}
$assign_list["package_id"] = $package_id;
