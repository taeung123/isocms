<?php

global $clsISO, $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID, $_loged_id, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $age_type_id, $height_type_id, $about_us_id, $country_vn_id, $hasAPI, $package_id, $now_day, $clsProperty, $now_month;

global $email_template_book_tour_id, $email_template_book_cruise_id, $email_template_book_hotel_id, $email_template_contact_id, $email_template_book_service_id, $email_template_tailor_id, $email_template_reg_advisory, $email_template_subscribe_id, $email_template_payment_onepay_id, $email_template_payment_paypal_id, $email_template_signup_id, $email_template_change_pass_id, $email_template_reset_pass_id, $email_template_signup_agent_id, $email_template_signup_ctv_id, $email_template_active_agent_id, $email_template_update_profile_agent_id, $email_template_block_agent_id, $email_template_change_pass_agent_id, $email_template_reset_pass_agent_id, $email_template_agent_id;

$assign_list["_ADMINLANG"] = $_ADMINLANG;
$clsISO = new ISO();
$assign_list["clsISO"] = $clsISO;
$clsAdminButton = new AdminButton();
$assign_list["clsAdminButton"] = $clsAdminButton;
$clsConfiguration = new Configuration();
$assign_list["clsConfiguration"] = $clsConfiguration;
$clsProperty = new Property();
#

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
$assign_list["use_browser"] = $use_browser;

#
$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
$url = !empty($query) ? $protocol . "://$host$self?$query" : $protocol . "://$host$self?";
if (strstr($url, '&lang')) $url = substr($url, 0, -8);
$assign_list["url"] = $url;
$host = $_SERVER['HTTP_HOST'];
$assign_list["host"] = $host;
$assign_list["_isoman_use"] = _isoman_use;
$assign_list["_ISOCMS_VERSION"] = _ISOCMS_VERSION;
$assign_list["MULTIPLE_LANG"] = MULTIPLE_LANG;
$assign_list["SHOW_CHATTING"] = SHOW_CHATTING;
$assign_list['_LICENSE_VALUE'] = $core->_LICENSE_VALUE ?? '';
$assign_list["_DEV"] = _DEV ?? "";
#
$assign_list["PCMS"] = _ISOCMS_PROTOCOL . $_SERVER['HTTP_HOST'];
$assign_list["PCMS_DIR"] = PCMS_DIR;
$assign_list["PCMS_URL"] = PCMS_URL;
$assign_list["DIR_IMAGES"] = DIR_IMAGES;
$assign_list["URL_IMAGES"] = URL_IMAGES;
$assign_list["URL_CSS"] = URL_CSS;
$assign_list["URL_JS"] = URL_JS;
$assign_list["URL_LIBRARY"] = URL_LIBRARY;
$assign_list["ISOCMS_DIR"] = ISOCMS_DIR;
$assign_list["URL_THEMES"] = URL_THEMES;
$assign_list["DOMAIN_NAME"] = DOMAIN_NAME;
$assign_list["PAGE_NAME"] = PAGE_NAME;
$assign_list["URL_EDITOR"] = URL_EDITOR;
$assign_list["URL_TINYMCE"] = URL_TINYMCE;
$assign_list["URL_ELFINDER"] = URL_ELFINDER;
$assign_list["API_GOOGLE_MAPS"] = $clsConfiguration->getValue('API_GOOGLE_MAPS');

$assign_list["_LANG_ID"] = $_LANG_ID;
$assign_list["CTV_POST"] = $CTV_POST ?? '';

$SERVER_NAME = $_SERVER['SERVER_NAME'];
$assign_list["SERVER_NAME"] = $SERVER_NAME;
//print_r($_LANG_ID); die();
$assign_list["curl"] = $_SERVER['REQUEST_URI'];
$assign_list["REQUEST_URI"] = $_SERVER['REQUEST_URI'];
$assign_list["CHECKHELP"] = 0;

//print_r($_SERVER['REQUEST_URI']); die();
$assign_list["message"] = isset($_GET['message']) ? $_GET['message'] : '';
$assign_list["upd_version"] = time();
$assign_list["pUrl"] = '';
$assign_list["type"] = '';
$assign_list["keyword"] = '';
$assign_list["currentPage"] = 0;

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

#---Edit after here-----------------------------------------------------------------------------------------
$clsUser = new User();
$assign_list["clsUser"] = $clsUser;
$clsUserGroup = new UserGroup();
$assign_list["clsUserGroup"] = $clsUserGroup;

if (isset($_GET['login_via_okrs']) && $_GET['login_via_okrs'] == 1) {
    if (!empty($_GET['user_name']) && !empty($_GET['user_pass'])) {
        $user_name = $core->decryptID($_GET['user_name']);
        $user_pass = $core->decryptID($_GET['user_pass']);

        if ($core->_SESS->checkUser($user_name, $user_pass)) {
            $core->_SESS->doLogin($user_name, $user_pass);
            $_loged_id = $core->_SESS->user_id;
            redirect(PCMS_URL . "/index.php?admin&lang=" . LANG_DEFAULT);
        }
    }
}

$_loged_id = $core->_SESS->user_id;

$_user_group_id = $clsUser->getOneField('user_group_id', $_loged_id);
$assign_list["_loged_id"] = $_loged_id;
$oneUser = $clsUser->getOne($_loged_id);
$update_sitemap = 0;
if (!empty($_loged_id)) {
    $sessionKey = 'loged_' . $_loged_id;
    $sessionView = $_SESSION[$sessionKey] ?? 0;
    if (!$sessionView) { // nếu chưa có session
        $_SESSION[$sessionKey] = 1;
        $update_sitemap = 1;
    }
}


$assign_list["update_sitemap"] = $update_sitemap;

$assign_list["_user_group_id"] = $_user_group_id;

$listLang = $clsISO->getListLang();
$assign_list["listLang"] = $listLang;
if ($clsISO->checkInArray($listLang, $_LANG_ID) == 0) {
    header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
    exit();
}

vnSessionDelVar('BookingTourAdm_' . $_LANG_ID);
vnSessionDelVar('BookingVoucherAdm_' . $_LANG_ID);
vnSessionDelVar('BookingComboAdm_' . $_LANG_ID);
vnSessionDelVar('BookingHotelAdm_' . $_LANG_ID);
vnSessionDelVar('SessionChooseRoomAdm');
vnSessionDelVar('BookingCruiseAdm_' . $_LANG_ID);
vnSessionDelVar('SessionChooseCabinAdm');
#- Payment Gateway config
$assign_list['PAYMENT_GLOBAL'] = PAYMENT_GLOBAL;
$assign_list['PAYMENT_ONLINE_GLOBAL'] = PAYMENT_ONLINE_GLOBAL;
if (PAYMENT_GLOBAL) {
    $table_name = DB_PREFIX . 'booking';
    #- Add column payment_method to table booking
    if (!$clsISO->checkColumnInTable($table_name, "payment_method")) {
        $clsISO->addColumnIntoTable($table_name, 'payment_method', 'booking_id', 'INT(10)');
    }
    if (PAYMENT_ONLINE_GLOBAL) {
        $assign_list['PAYMENT_CASH_ID'] = PAYMENT_CASH_ID;
        $assign_list['PAYMENT_TRANSFER_ID'] = PAYMENT_TRANSFER_ID;
        $assign_list['PAYMENT_ONEPAY_ATM'] = PAYMENT_ONEPAY_ATM;
        $assign_list['PAYMENT_ONEPAY_VISA'] = PAYMENT_ONEPAY_VISA;
        $assign_list['PAYMENT_PAYPAL_GATEWAY'] = PAYMENT_PAYPAL_GATEWAY;
        $assign_list['PAYMENT_VTCPAY_GATEWAY'] = PAYMENT_VTCPAY_GATEWAY;
        $assign_list['PAYMENT_VNPAY_GATEWAY'] = PAYMENT_VNPAY_GATEWAY;
        #- Add column relation to booking
        if (!$clsISO->checkColumnInTable($table_name, "list_billing_id")) {
            $clsISO->addColumnIntoTable($table_name, 'list_billing_id', 'booking_id', 'INT(10)');
        }
        #- Init Object
        global $clsBilling;
        $clsBilling = new Billing();
        $assign_list['clsBilling'] = $clsBilling;
    }
}


#
$clsSetting = new Setting();
$assign_list["clsSetting"] = $clsSetting;
$oneSetting = $clsSetting->getOne(1);
$assign_list["oneSetting"] = $oneSetting;
unset($clsSetting);
#
require_once(DIR_INCLUDES . '/Mobile_Detect.php');
$detect = new Mobile_Detect();
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$assign_list["deviceType"] = $deviceType;
//Button Global
$assign_list["saveBtnSeo"] = '<button type="submit" name="button" id="submit_form" value="_EDIT" class="btn btn-primary start">
		<i class="icon-ok icon-white"></i>
		<span>' . $core->get_Lang('Save Meta') . '</span>
	</button>';

$assign_list["saveBtn"] = '<button type="submit" name="button" id="submit_form" value="_EDIT" class="btn btn-primary start">
		<i class="icon-ok icon-white"></i>
		<span>' . $core->get_Lang('save') . '</span>
	</button>';
$assign_list["saveNew"] = '<button type="submit" name="button" value="_NEW" class="btn btn-success start">
		<i class="icon-plus icon-white"></i>
		<span>' . $core->get_Lang('save &amp; add') . '</span>
	</button>';
$assign_list["createNew"] = '<button type="submit" name="button" value="_NEW" class="btn btn-success start">
		<i class="icon-plus icon-white"></i>
		<span>' . $core->get_Lang('Create New') . '</span>
	</button>';
$assign_list["saveList"] = '<button type="submit" name="button" value="_LIST" class="btn btn-danger start">
		<i class="icon-folder-open icon-white"></i>
		<span>' . $core->get_Lang('save &amp; back') . '</span>
	</button>';
$assign_list["resetBtn"] = '<button type="reset" class="btn btn-warning delete">
		<i class="icon-retweet icon-white"></i>
		<span>' . $core->get_Lang('reset') . '</span>
	</button>';
#
$assign_list['now'] = time();
$assign_list['now_next'] = time() + (24 * 60 * 60);
$current_date = date('m/d/Y');
$current_time = strtotime($current_date);
$now_day = $current_time;
$assign_list['now_day'] = $now_day;
$now_day_next = date('m/d/Y', strtotime("+ 1 days"));
$now_day_next = strtotime($now_day_next);
$assign_list['now_day_next'] = $now_day_next;
$now_month = date('m', time());
#
if ($_LANG_ID != LANG_DEFAULT) {
    $extLang = '/' . $_LANG_ID;
    $HOMEPAGE_URL = '/' . $_LANG_ID . '/';
} else {
    $extLang = '';
    $HOMEPAGE_URL = '/';
}
$assign_list['extLang'] = $extLang;
#
$clsTourProperty = new TourProperty();
$adult_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 0,1", $clsTourProperty->pkey);
$adult_type_id = $adult_type_id[0][$clsTourProperty->pkey];
$child_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 1,1", $clsTourProperty->pkey);
$child_type_id = $child_type_id[0][$clsTourProperty->pkey];
$infant_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 2,1", $clsTourProperty->pkey);
$infant_type_id = $infant_type_id[0][$clsTourProperty->pkey];

$age_type_id = $clsTourProperty->getAll("is_trash=0 and type='VISITORAGETYPE' and is_online=1 order by order_no asc limit 0,1");
$age_type_id = $age_type_id[0][$clsTourProperty->pkey];

$height_type_id = $clsTourProperty->getAll("is_trash=0 and type='VISITORHEIGHTTYPE' and is_online=1 order by order_no asc limit 0,1");
$height_type_id = $height_type_id[0][$clsTourProperty->pkey];

$assign_list["adult_type_id"] = $adult_type_id;
$assign_list["child_type_id"] = $child_type_id;
$assign_list["infant_type_id"] = $infant_type_id;
$assign_list["age_type_id"] = $age_type_id;
$assign_list["height_type_id"] = $height_type_id;
#
if ($_LANG_ID == 'en') {
    $about_us_id = 1;
    $country_vn_id = 1;
} elseif ($_LANG_ID == 'es') {
    $about_us_id = 11;
    $country_vn_id = 1;
} elseif ($_LANG_ID == 'fr') {
    $about_us_id = 3;
    $country_vn_id = 1;
} elseif ($_LANG_ID == 'kr') {
    $about_us_id = 21;
    $country_vn_id = 1;
} elseif ($_LANG_ID == 'tw') {
    $about_us_id = 22;
    $country_vn_id = 1;
} elseif ($_LANG_ID == 'cn') {
    $about_us_id = 22;
    $country_vn_id = 1;
} else {
    $about_us_id = 2;
    $country_vn_id = 4;
}
$assign_list["about_us_id"] = $about_us_id;
$assign_list["country_vn_id"] = $country_vn_id;
$hasAPI = $clsConfiguration->getValue('SiteTourAPI');
$assign_list["hasAPI"] = $hasAPI;
#
$assign_list["package_id"] = $package_id;
#
global $_ADMINLANG;
$langs = json_encode($_ADMINLANG);
$scriptlang = "<script>var __ = JSON.parse(`$langs`);</script>";
$assign_list["scriptlang"] = $scriptlang;
#

if ($_LANG_ID != 'en') {
    $lang_sql = $_LANG_ID;
} else {
    $lang_sql = '';
}
//Agent
$assign_list["is_agent"] = _IS_TRAVEL_AGENT;

$email_template_signup_agent_id = 98;
$email_template_signup_ctv_id = 33;
$email_template_active_agent_id = 110;
$email_template_update_profile_agent_id = 116;
$email_template_block_agent_id = 122;
$email_template_change_pass_agent_id = 39;
$email_template_reset_pass_agent_id = 30;
$email_template_agent_id = 133;
