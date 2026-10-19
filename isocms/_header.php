<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL); 
header("Cache-Control: must-revalidate");
/* duration of cached content (1 hour) */
$offset = 60 * 60 * 24;
/* expiration header format */
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
/* send cache expiration header to broswer */
header($ExpStr);
global $smarty, $assign_list, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $global_title_page, $global_description_page, $global_keyword_page, $_LANG_ID, $_CONFIG, $clsConfiguration, $country_id, $agent_id, $profile_id, $lang_sql, $adult_type_id, $child_type_id, $infant_type_id, $age_type_id, $height_type_id, $deviceType, $lstCountryEx, $global_schema_markup;
global $email_template_book_tour_id, $email_template_book_cruise_id, $email_template_book_hotel_id, $email_template_contact_id, $email_template_book_service_id, $email_template_tailor_id, $email_template_reg_advisory, $email_template_subscribe_id, $email_template_payment_onepay_id, $email_template_payment_paypal_id, $email_template_signup_id, $email_template_change_pass_id, $email_template_reset_pass_id, $about_us_id, $country_vn_id;
global $agent_id, $email_template_signup_agent_id, $email_template_signup_ctv_id, $email_template_active_agent_id, $email_template_update_profile_agent_id, $email_template_block_agent_id, $email_template_change_pass_agent_id, $email_template_reset_pass_agent_id, $is_agent, $email_template_review_tour_id, $email_template_review_cruise_id, $email_template_agent_id, $hasAPI;
global $clsISO, $now_day, $short_rate, $package_id, $agentLoggedIn;
global $is_mod_member, $is_tour_departure_point, $now_month, $iso_countCart;
global $URL_CSS, $URL_JS, $URL_LIBRARY, $upd_version;
$clsAntiSpam = new AntiSpam();
$clsAntiSpam->init();
$spam_csrf = $clsAntiSpam->getCSRF();
$from_time = time();
$signature = $clsAntiSpam->getSignature($from_time);
$js_token = $clsAntiSpam->createJSToken();
$assign_list["spam_csrf"] = $spam_csrf;
$assign_list["from_time"] = $from_time;
$assign_list["signature"] = $signature;
$assign_list["js_token"] = $js_token;
$smarty->assign('spam_csrf', $spam_csrf);
$smarty->assign('from_time', $from_time);
$smarty->assign('signature', $signature);
$smarty->assign('js_token', $js_token);
$assign_list['ANTI_SPAM_HTML'] = AntiSpamGetHiddenFields();
$smarty->assign('ANTI_SPAM_HTML', $assign_list['ANTI_SPAM_HTML']);

#Khi trong __construct() có xử lý logic phức tạp hoặc kết nối database thì k nên khai báo ở đây
$lstClassName = [
    "ISO",
    "Configuration",
    "Page",
    "Reviews",
    "CountryEx" => "Country",
    "City",
    "CruiseCat",
    "Tour",
    "TourCategory",
    "Category_Country",
    "HotelProperty",
    "Region",
    "Hotel",
    "Service",
    "Billing",
    "Wishlist",
    "Agent",
    "TourProperty",
    "Profile",
];

foreach ($lstClassName as $key => $className) {
    // Cho phép alias, ví dụ 'CountryEx' => 'Country'
    if (is_string($key)) {
        $varSuffix = $key;
        $realClass = $className;
    } else {
        $varSuffix = $className;
        $realClass = $className;
    }
    $varName = 'cls' . $varSuffix;
    // Khởi tạo biến động: $clsCity, $clsTour, v.v.
    $$varName = new $realClass();
    // Gán vào assign_list
    $assign_list[$varName] = $$varName;
}

// luu ý khi cài mới
$assign_list["package_id"] = $package_id;
$CurrencyCode = vnSessionGetVar('CurrencyCode');
$assign_list["CurrencyCode"] = $CurrencyCode;
#
$vietiso = isset($_GET['vietiso']) ? $_GET['vietiso'] : '';
$assign_list["vietiso"] = $vietiso;
$show = isset($_GET['show']) ? $_GET['show'] : '';
$assign_list["show"] = $show;
$cookie = isset($_GET['cookie']) ? $_GET['cookie'] : '';
$assign_list["cookie"] = $cookie;
$_LANG_ID = isset($_GET['lang']) ? $_GET['lang'] : LANG_DEFAULT;
$assign_list["_LANG_ID"] = $_LANG_ID;

$listLang = $clsISO->getListLang();
$assign_list["listLang"] = $listLang;
if ($clsISO->checkInArray($listLang, $_LANG_ID) == 0) {
    header('Location:' . DOMAIN_NAME);
    exit();
}

#
if ($_LANG_ID != LANG_DEFAULT) {
    $extLang = '/' . $_LANG_ID;
    $HOMEPAGE_URL = '/' . $_LANG_ID . '/';
} else {
    $extLang = '';
    $HOMEPAGE_URL = '/';
}
$SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);
if ($_LANG_ID != $SiteDefaultLanguage) {
    $lang_sql = $_LANG_ID;
} 
else {
    $lang_sql = $SiteDefaultLanguage;
}

// luu ý khi cài mới
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$ipConfig = $clsConfiguration->getValue('IP_ONLINE');
// Danh sách IP cho phép
$allowIps = [
    '124.158.4.43',
    '117.6.56.122',
    '116.111.122.138',
    '117.6.59.160',
    '192.168.1.59',
    '117.6.62.75',
    '116.96.87.123',
    '117.6.52.178',
    '171.224.29.102',
	'125.235.185.54',
	'1.54.8.42',
	'171.234.235.254',
	'116.111.113.229',
	'116.96.81.43',
	'171.224.25.203',
	'27.76.183.41',
	'171.234.233.94',
	'118.70.84.24',
	'171.234.237.68',
	'183.91.7.168',
	'116.96.91.48',
	'171.234.237.176',
	'116.96.92.22',
	'27.76.181.215',
	'116.96.90.74'
];

// Lấy cookie demo
$demoCookies = [
    $_COOKIE['customer_demo_isocms'] ?? '',
    $_COOKIE['get_demo'] ?? '',
    $_COOKIE['get_demo_1'] ?? '',
    $_COOKIE['get_demo_2'] ?? '',
    $_COOKIE['get_demo_3'] ?? '',
];

// Check cookie demo
$isDemoUser =
    in_array('demo', $demoCookies, true)
    || in_array('demo_isocms', $demoCookies, true);

// Check IP hợp lệ
$isAllowIp =
    in_array($ip, $allowIps, true)
    || $clsISO->checkInArray($ipConfig, $ip);


// Check tổng hợp
$isAllowed =
    $mod === 'api'
    || ($mod === 'home' && in_array($act, ['set_cookie', 'set_cookie2'], true))
    || $cookie == 1
    || $isAllowIp
    || $isDemoUser;

// $isAllowed = 1;
// Nếu KHÔNG hợp lệ → redirect
//var_dump($isAllowed); die;
if (!$isAllowed) {
    header('Location: http://isocms.net');
    exit();
}
#

$twitter_site = explode('.', $_SERVER['HTTP_HOST']);
$twitter_site = $twitter_site[0];

$assign_list["twitter_site"] = $twitter_site;
$assign_list['extLang'] = $extLang;
$assign_list['HOMEPAGE_URL'] = $HOMEPAGE_URL;
$assign_list["lang_sql"] = $lang_sql;
#
$isiPad = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
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

//$assign_list["_isoman_use"] = _isoman_use;	
$assign_list["PCMS_DIR"] = PCMS_DIR;
$assign_list["PCMS_URL"] = PCMS_URL;
$assign_list["PAGE_NAME"] = PAGE_NAME;
$assign_list["DOMAIN_NAME"] = DOMAIN_NAME;
#
$assign_list["DIR_IMAGES"] = DIR_IMAGES;
$assign_list["URL_IMAGES"] = preg_replace('/(http|https|ftp):\/\/[\w]{0,}\.isocms.com\/\//', '/', URL_IMAGES);
$assign_list["URL_CSS"] = URL_CSS;
$assign_list["URL_JS"] = URL_JS;
$assign_list["URL_LIBRARY"] = URL_LIBRARY;
$assign_list["URL_TINYMCE"] = URL_TINYMCE;
$assign_list["URL_TINYMCE5"] = URL_TINYMCE5;
#
$assign_list["ISOCMS_DIR"] = ISOCMS_DIR;
$assign_list["URL_THEMES"] = URL_THEMES;
$assign_list['tpl'] = ISOCMS_THEMES;
$assign_list['appID'] = appID;
$assign_list['LANG_DEFAULT'] = LANG_DEFAULT;
$assign_list["_LANG_ID"] = $_LANG_ID;
$assign_list["API_GOOGLE_MAPS"] = $clsConfiguration->getValue('API_GOOGLE_MAPS');
#
$assign_list["curl"] = $_SERVER['REQUEST_URI'];
$assign_list["REQUEST_URI"] = $_SERVER['REQUEST_URI'];
$assign_list["upd_version"] = 1;
$assign_list["smarty"] = $smarty;
$assign_list['sid'] = session_id();

if (strlen(strstr($_SERVER['REQUEST_URI'], '//')) > 0) {
    $Rewrite_Url = str_replace('//', '/', $_SERVER['REQUEST_URI']);
    header('location:' . DOMAIN_NAME . $Rewrite_Url);
}
if (strlen(strstr($_SERVER['REQUEST_URI'], '?mod=')) > 0) {
    header('location:' . DOMAIN_NAME);
}

$sqlCountryDestination = "
    SELECT
        c.country_id,
        c.slug,
        c.title,
        c.banner,
        c.intro,
        c.order_no AS country_order_no,

        ci.city_id,
        ci.title AS city_title,
        ci.slug AS city_slug,
        ci.order_no AS city_order_no

    FROM default_country AS c

    LEFT JOIN default_city AS ci
        ON c.country_id = ci.country_id
        AND ci.is_trash = 0
        AND ci.is_online = 1

    WHERE c.is_trash = 0
        AND c.is_online = 1
        AND c.lang_id = '{$lang_sql}'

    ORDER BY
        c.order_no DESC,
        c.country_id ASC,
        ci.order_no DESC,
        ci.city_id ASC
";

$dataCountryDestination = $dbconn->getAll($sqlCountryDestination);

$listCountryDestination = [];

if (is_array($dataCountryDestination)) {
    foreach ($dataCountryDestination as $item) {
        $countryDestinationId = isset($item['country_id'])
            ? (int)$item['country_id']
            : 0;

        if ($countryDestinationId <= 0) {
            continue;
        }

        /*
         * Quốc gia được tạo lần đầu theo đúng thứ tự SQL:
         * Vietnam → Japan → Korea → China → Thailand
         */
        if (!isset($listCountryDestination[$countryDestinationId])) {
            $listCountryDestination[$countryDestinationId] = [
                'country_id' => $countryDestinationId,
                'slug'       => $item['slug'] ?? '',
                'title'      => $item['title'] ?? '',
                'banner'     => $item['banner'] ?? '',
                'intro'      => $item['intro'] ?? '',
                'order_no'   => isset($item['country_order_no'])
                    ? (int)$item['country_order_no']
                    : 0,
                'cities'     => []
            ];
        }

        $cityDestinationId = isset($item['city_id'])
            ? (int)$item['city_id']
            : 0;

        if ($cityDestinationId > 0) {
            $listCountryDestination[$countryDestinationId]['cities'][] = [
                'city_id'  => $cityDestinationId,
                'title'    => $item['city_title'] ?? '',
                'slug'     => $item['city_slug'] ?? '',
                'order_no' => isset($item['city_order_no'])
                    ? (int)$item['city_order_no']
                    : 0
            ];
        }
    }
}

/*
 * Chuyển associative array về indexed array
 * để Smarty dùng $key eq 0 chính xác.
 */
$listCountryDestination = array_values($listCountryDestination);

$assign_list['listCountryDestination'] = $listCountryDestination;
//var_dump($listCountryDestination);
$sqlLstCountryHotel = "SELECT country_id,title,slug 
FROM default_country AS c 
WHERE c.lang_id='{$lang_sql}' AND c.is_trash=0 and c.is_online=1 
AND EXISTS (
    SELECT 1 
    FROM default_hotel as h 
    WHERE c.country_id=h.country_id AND h.is_trash=0 and h.is_online=1
) 
order by order_no asc";
$lstCountryHotel = $dbconn->getAll($sqlLstCountryHotel);
$assign_list['lstCountryHotel'] = $lstCountryHotel;
unset($lstCountryHotel);

#
$lstCatTour = $clsTourCategory->getAll("is_trash=0 and is_online=1 and parent_id=0 order by order_no asc", $clsTourCategory->pkey . ",title,slug,image");
$assign_list["lstCatTour"] = $lstCatTour;
unset($lstCatTour);
//print_r(date('d/m/Y H:i')); die();
#
$assign_list['now'] = time();
$assign_list['now_next'] = time() + (24 * 60 * 60);
$assign_list['now_next_2_day'] = time() + (2 * 24 * 60 * 60);
$current_date = date('m/d/Y');
$current_time = strtotime($current_date);
$now_day = $current_time;

$assign_list['now_day'] = $now_day;
$now_month = date('m', time());
$assign_list['now_month'] = $now_month;

$cruiseModuleActive = $clsISO->getCheckActiveModulePackage($package_id, 'cruise', 'default', 'default');
$hotelModuleActive = $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default');
$voucherModuleActive = $clsISO->getCheckActiveModulePackage($package_id, 'voucher', 'default', 'default');
$assign_list['cruiseModuleActive'] = $cruiseModuleActive;
$assign_list['hotelModuleActive'] = $hotelModuleActive;
$assign_list['voucherModuleActive'] = $voucherModuleActive;

$lstCruiseCat = [];
if ($clsISO->getCheckActiveModulePackage($package_id, 'cruise', 'cat', 'default')) {
    $lstCruiseCat = $clsCruiseCat->getAll("is_trash=0 and is_online=1 and parent_id=0 order by order_no asc", $clsCruiseCat->pkey . ",title,slug,image_banner");
}
$assign_list["lstCruiseCat"] = $lstCruiseCat;
unset($lstCruiseCat);

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
    }
}

#- End Payment Gateway config
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
    }
    $assign_list['is_agent'] = !empty($is_agent) ? $is_agent : 0;
    # Check agent login
    $clsISO->checkAgentLogin();
}

if (_ISOCMS_CLIENT_LOGIN) {
    $assign_list["clsProfile"] = $clsProfile;
    $assign_list["appID"] = appID;
    $assign_list["AppSecret"] = AppSecret;
    $assign_list["GoogleID"] = GoogleID;
    $assign_list["GoogleSecret"] = GoogleSecret;
    $loggedIn = $clsProfile->isLoggedIn();
    $assign_list["loggedIn"] = $loggedIn;
    if ($loggedIn == 1) {
        $profile_id = $clsProfile->getUserID();
        $oneProfile = $clsProfile->getOne($profile_id);
        $assign_list["oneProfile"] = $oneProfile;
        $folder_name = $oneProfile['username'] . '_' . $profile_id;
        if (!file_exists('/home/isocms/domains/isocms.com/private_html/uploads/datastore/' . $folder_name)) {
            mkdir('/home/isocms/domains/isocms.com/private_html/uploads/datastore/' . $folder_name);
            chmod('/home/isocms/domains/isocms.com/private_html/uploads/datastore/' . $folder_name, 0777);
        }
        #- Wishlist
        $numWishlist = $clsWishlist->getAll("member_id='$profile_id'");
        $numWishlist = $numWishlist ? count($numWishlist) : 0;
        $assign_list["numWishlist"] = $numWishlist;
    }
    $assign_list["profile_id"] = $profile_id ? $profile_id : 0;
}

$return_url = '';
if (vnSessionExist('Link_login_book')) {
    $return_url = vnSessionGetVar('Link_login_book');
} else {
    $return_url = isset($_GET['return_url']) ? $_GET['return_url'] : '';
}
$assign_list['return_url'] = $return_url;

$field = "{$clsTourProperty->pkey}";
$tmp = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 0,3", $field);
if (!empty($tmp)) {
    $adult_type_id = $tmp[0][$clsTourProperty->pkey] ?? 0;
    $child_type_id = $tmp[1][$clsTourProperty->pkey] ?? 0;
    $infant_type_id = $tmp[2][$clsTourProperty->pkey] ?? 0;
}

$lstAgeType = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORAGETYPE' order by order_no ASC limit 0,1", $clsTourProperty->pkey);
$age_type_id = $lstAgeType[0][$clsTourProperty->pkey] ?? 0;

$lstHeightType = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORHEIGHTTYPE' order by order_no ASC limit 0,1", $clsTourProperty->pkey);
$height_type_id = $lstHeightType[0][$clsTourProperty->pkey] ?? 0;

$assign_list["adult_type_id"] = $adult_type_id;
$assign_list["child_type_id"] = $child_type_id;
$assign_list["infant_type_id"] = $infant_type_id;
$assign_list["age_type_id"] = $age_type_id;
$assign_list["height_type_id"] = $height_type_id;
$short_rate = $clsISO->getShortRate();
$assign_list["short_rate"] = $short_rate;
$is_mod_member = $clsISO->getCheckActiveModulePackage($package_id, 'member', 'default', 'default');
$assign_list["is_mod_member"] = $is_mod_member;
$is_tour_departure_point = $clsISO->getCheckActiveModulePackage($package_id, 'tour', 'tour_departure_point', 'customize');
$assign_list["is_tour_departure_point"] = $is_tour_departure_point;

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

if ($_LANG_ID == 'en') {
    $country_vn_id = 1;
    $about_us_id = 1;
    $facebook_plugin_lang = 'en_US';
    ///recaptcha_google_lang
    $recaptcha_google_lang = 'en';
} elseif ($_LANG_ID == 'es') {
    $country_vn_id = 1;
    $about_us_id = 11;
    ///facebook_plugin_lang
    $facebook_plugin_lang = 'es_ES';
    ///recaptcha_google_lang
    $recaptcha_google_lang = 'es';
} elseif ($_LANG_ID == 'fr') {
    $country_vn_id = 1;
    $about_us_id = 3;
    ///facebook_plugin_lang
    $facebook_plugin_lang = 'fr_FR';
    ///recaptcha_google_lang
    $recaptcha_google_lang = 'fr';
} elseif ($_LANG_ID == 'kr') {
    $country_vn_id = 1;
    $about_us_id = 21;
    ///facebook_plugin_lang
    $facebook_plugin_lang = 'ko_KR';
    ///recaptcha_google_lang
    $recaptcha_google_lang = 'ko';
} elseif ($_LANG_ID == 'tw') {
    $country_vn_id = 1;
    $about_us_id = 22;
    ///facebook_plugin_lang
    $facebook_plugin_lang = 'en_US';
    ///recaptcha_google_lang
    $recaptcha_google_lang = 'zh-CN';
} elseif ($_LANG_ID == 'cn') {
    $country_vn_id = 1;
    $about_us_id = 22;
    ///facebook_plugin_lang
    $facebook_plugin_lang = 'zh_CN';
    ///recaptcha_google_lang
    $recaptcha_google_lang = 'zh-CN';
} else {
    $country_vn_id = 4;
    $about_us_id = 2;
    ///facebook_plugin_lang
    $facebook_plugin_lang = 'vi_VN';
    ///recaptcha_google_lang
    $recaptcha_google_lang = 'vi';
}

$assign_list["facebook_plugin_lang"] = $facebook_plugin_lang;
$assign_list["recaptcha_google_lang"] = $recaptcha_google_lang;
$assign_list["country_vn_id"] = $country_vn_id;
$assign_list["about_us_id"] = $about_us_id;

$DISCOUNT_AGENT = $clsISO->processFloatNumber($clsConfiguration->getValue('DiscountAgent'));
$DISCOUNT_CTV = $clsISO->processFloatNumber($clsConfiguration->getValue('DiscountCTV'));

define("DISCOUNT_AGENT", $DISCOUNT_AGENT);
define("DISCOUNT_CTV", $DISCOUNT_CTV);

$assign_list["DISCOUNT_AGENT"] = DISCOUNT_AGENT;
$assign_list["DISCOUNT_CTV"] = DISCOUNT_CTV;
$hasAPI = $clsConfiguration->getValue('SiteTourAPI');
$assign_list["hasAPI"] = $hasAPI;
if ($hasAPI) {
    $clsISO->updateInfoRateVCB();
    $clsISO->updateInfoRateECB();
}

//Đếm số lượng sản phầm trong giỏ hàng
$cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
$cartSessionService = !empty($cartSessionService[$_LANG_ID]) ? $cartSessionService[$_LANG_ID] : [];
$count_CartTour = !empty($cartSessionService) ? count($cartSessionService) : 0;
$cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
$cartSessionVoucher = !empty($cartSessionVoucher[$_LANG_ID]) ? $cartSessionVoucher[$_LANG_ID] : [];
$count_CartVoucher = !empty($cartSessionVoucher) ? count($cartSessionVoucher) : 0;
$cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
$cartSessionCruise = !empty($cartSessionCruise[$_LANG_ID]) ? $cartSessionCruise[$_LANG_ID] : [];
$count_CartCruise = !empty($cartSessionCruise) ? count($cartSessionCruise) : 0;
$cartSessionHotel = vnSessionGetVar("BookingHotel_" . $_LANG_ID);
$cartSessionHotel = !empty($cartSessionHotel[$_LANG_ID]) ? $cartSessionHotel[$_LANG_ID] : [];
$count_CartHotel = !empty($cartSessionHotel) ? count($cartSessionHotel) : 0;
$iso_countCart = $count_CartTour + $count_CartVoucher + $count_CartCruise + $count_CartHotel;
$assign_list["iso_countCart"] = $iso_countCart;

#Lấy thông tin package client
$packageClient = $clsPackage->getPackageClient($package_id);

$assign_list["packageClient"] = $packageClient;

#
$URL_CSS = URL_CSS;
$URL_JS = URL_JS;
$URL_LIBRARY = URL_LIBRARY;
$upd_version = time();
$v_cache = 1;

Asset::css([
    "{$URL_LIBRARY}/bootstrap5/bootstrap.min.css?v={$upd_version}",
    "{$URL_LIBRARY}/_css/jquery-ui.css?ver={$upd_version}",
    "{$URL_CSS}/compress/owl.carousel.min.css?v={$upd_version}",
    "{$URL_CSS}/jquery-confirm.min.css?ver={$upd_version}",
    "{$URL_LIBRARY}/fontawesome-pro-6.7.2/css/fontawesome.min.css?v={$upd_version}",
    "{$URL_CSS}/vietisocms.css?v={$upd_version}",
    "{$URL_CSS}/isotourcms.css?v={$upd_version}",
    "{$URL_JS}/select_custom/select.min.css?v={$upd_version}",
    "{$URL_CSS}/{$packageClient['header_file']}.css?v={$upd_version}"
]);

Asset::cssPreload([
    "{$URL_CSS}/footer.css?v={$upd_version}",
    "{$URL_CSS}/jquery-confirm.min.css?ver={$upd_version}"
]);

$fileModCss = __DIR__ . "/templates/default/skin/css/{$mod}.css";

if (file_exists($fileModCss)) {
    $file_mod_css = "{$URL_CSS}/{$mod}.css?v={$upd_version}";
    Asset::cssPreload($file_mod_css);
}

//File danh danh sách JS
Asset::js([
    "{$URL_LIBRARY}/_js/jquery-3.7.1.min.js?v={$upd_version}",
    "{$URL_LIBRARY}/_js/jquery-migrate-1.4.1.min.js?v={$upd_version}",
    "{$URL_LIBRARY}/_js/jquery-ui.min.js?v={$upd_version}",
    "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$upd_version}",
    "{$URL_LIBRARY}/bootstrap5/bootstrap.bundle.min.js?v={$upd_version}",
    "{$URL_JS}/select_custom/select.min.js?v={$upd_version}",
    "{$URL_JS}/sweetalert.js?v={$upd_version}",
    "{$URL_LIBRARY}/core.js?v={$upd_version}",
    "{$URL_JS}/jquery.ui.touch-punch.min.js?v={$upd_version}",
    "{$URL_JS}/compress/backTop.js?v={$upd_version}",
    "{$URL_JS}/vietiso.js?v={$upd_version}",
    "{$URL_JS}/_header.js?v={$upd_version}",
    "{$URL_JS}/jquery.partner.js?v={$upd_version}"
]);

Asset::jsAsync([
    "https://www.google.com/recaptcha/api.js?hl={$recaptcha_google_lang}&ver={$upd_version}",
]);