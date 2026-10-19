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

//define('LICENSE_KEY', 'TourCMS-c2fa69c373bfd86a2096');
//define('LICENSE_KEY', 'TourCMS-c2fa69c373bfd86a2096');
define('LICENSE_KEY', 'def18ad1b70dc62d0a6bb047545a1404');

date_default_timezone_set('Asia/Ho_Chi_Minh');

/** ISOCMS check https available */
function isSecure()
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443;
}

/** ISOCMS check môi trường dev */
define('ENV_ENVIRONMENT', 'dev'); //Có 2 giá trị là dev và pro

/** ISOCMS check help admin */
define('CHECKHELP', '1');

/** ISOCMS version available */
define('CMSVER', '2');

/** ISOCMS license check from system */
define('LICENSE_CHECK', 1); // 1:handle 2: go

/** ISOCMS login to admin via clienterea */
define('ADMIN_LOGIN_CLIENTAREA', 0);

/** The name of the database for ISOCMS */
define('DB_NAME', 'isocms_dbis');

/** MySQL database username */
define('DB_USER', 'isocms_dbis');

/** MySQL database password */
define('DB_PASS', 'wMgLrAdkurAtQqP4RYUh');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** The type of the database*/
define('DB_TYPE', 'mysqli');

/** The type of the database*/
define('DB_PREFIX', 'default_');

/** The type of the copyright*/
define("_copyright", 'Copyright (c) VietISO. All Rights Reserved');

/** The type of protocol*/
define('_ISOCMS_PROTOCOL', !isSecure() ? 'http://' : 'https://');

/** The type of language load*/
define('LANG_LOAD', 1);

/** The name of DOMAIN_SESSION*/
define('DOMAIN_SESSION', 'isocms.com');

/** The type of DOMAIN NAME*/
define('DOMAIN_NAME', _ISOCMS_PROTOCOL . $_SERVER['HTTP_HOST']);

/** The name of DOMAIN URL*/
define('DOMAIN_URL', _ISOCMS_PROTOCOL . $_SERVER['HTTP_HOST']);

//package
define('PACKAGE_ID', 4);
//1: essentials, 2: professional, 3: premium

define('_IS_AGENT', 1);
define('_ISOCMS_CLIENT_LOGIN', 1);
define('_IS_TRAVEL_AGENT', 1);
define('ENCRYPTION_KEY', getenv('ISO_ENC_KEY'));
define("PAGE_NAME", 'isoCMS');    //1 yes - 0 no
define("DISPLAY_ERRORS", 1);    //1 yes - 0 no
define("SHOW_CHATTING", 0);
define("MULTIPLE_DOMAIN", 0);
define("MULTIPLE_LANG", 1);    //1 yes - 0 no
define("LANG_DEFAULT", 'en');
define("LANG_ADMIN_DEFAULT", 'en');
define("IS_COMPRESS_CSS", "1");
define("IS_COMPRESS_JS", "1");
define("SEO_GLOBAL", "1");
define("GZIP_GLOBAL", "1");
define("COMPRESS_GLOBAL", "0");
define("SUBFOLDER_GLOBAL", "0");
define("UNDERCONSTRUCTION_GLOBAL", "0");
/** The email of CONTACT GLOBE*/
define("EMAIL_CONTACT_GLOBAL", "support@vietiso.com");


define("ADMIN_PAGINATION", "20");

/** Google reCPATCHA */
define("_ISOCMS_CAPTCHA", "reCAPTCHA"); //IMG & reCAPTCHA
define("reCAPTCHA_KEY", "6LebFB8rAAAAAP6Csu9_fSPqntW0F65oDuOYDnZ3");
define("reCAPTCHA_SECRET", "6LebFB8rAAAAAGXfnYoKt1eF0pLQaS9qHQ-E4Ew6");
define("reCAPTCHA_APIURL", "https://www.google.com/recaptcha/api/siteverify");

/** The defined of cache page */
define('CACHING', 0);
define('ADODB_CACHED', 0);
define('ADODB_CACHED_DIR', 0);
define('ADODB_CACHED_TIME', 0);
define('cache_lifetime', 3600);

define('DOCS_CACHING', 1);
define("DIR_CACHE", ABSPATH . '/cache');
define("DIR_CACHE_BLOCKS", DIR_CACHE . '/blocks/');
define("DIR_CACHE_QUERY", DIR_CACHE . '/query/');
define("DIR_CACHE_DATABASE", DIR_CACHE . '/database/');

define("URL_EDITOR", DOMAIN_URL . "/inc/editor");
define("URL_TINYMCE", URL_EDITOR . "/tinymce");
define("URL_TINYMCE5", URL_EDITOR . "/tinymce5");
define("URL_ELFINDER", URL_EDITOR . "/elfinder");
define("_elfinder_dir", ABSPATH . "/uploads");
define("_elfinder_url", DOMAIN_URL . '/uploads');
define("_isoman_use", 1);
define("_isoman_ftp", 0);
define("_isoman_dir", ABSPATH . '/uploads/');
define("_isoman_domain", DOMAIN_URL);
define("_isoman_url", "/uploads/");
define("_isoman_abs_url", "/uploads/");

define("_isoman_ftp_host_info", $_SERVER['SERVER_ADDR']);
define("_isoman_ftp_usr_info", "uploads@isocms.com");
define("_isoman_ftp_pwd_info", "1CePwtMD");
define("_isoman_ftp_dir", '/uploads');
define("_isoman_ftp_url", '/uploads');

define('_ISOCMS_UPLOAD_FTP', 0);
define("DIR_FILE_UPLOAD", $_SERVER['DOCUMENT_ROOT'] . '/uploads');
define("ftp_host_info", $_SERVER['SERVER_ADDR']);
define("ftp_usr_info", "uploads@isocms.com");
define("ftp_pwd_info", "1CePwtMD");
define("ftp_abs_path_info", '/uploads');
define("ftp_abs_path_image", '/uploads');
define("ftp_temp_file_info", $_SERVER['DOCUMENT_ROOT'] . '/tmp/');

define('PHIEUTHU', 0);
define('CTV_POST', 0);
define('PHIEUCHI', 1);
define('PROMO_PERCENT', 'p');
define('PROMO_VALUE', 'v');

/** The type of defind socical */
//define('appID', '388782864900252');
define('appID', '1634376013777709');
//define('AppSecret', '4f5adcc93d29e0aba41d52fb7550529e');
define('AppSecret', '9cee7fa303677202338292c25df5def6');
define('homeUrl', DOMAIN_NAME . '/facebook2callback');
define('fbPermissions', 'email');
//google
define('GoogleID', '519255974073-pjg28cs3vqut8uq3n2ccnm7jusn5a3rq.apps.googleusercontent.com');
define('GoogleSecret', 'Udrlz1yZ4snutjlg65Fqtnw3');
define('GoogleRedirectUrl', DOMAIN_NAME);
define('GoogleHomeUrl', DOMAIN_NAME);

define('CONSUMER_KEY', 'tHEiDIBOPQgdYGnqDx6OQ');
define('CONSUMER_SECRET', 'TaYOI0hFAxmU9yQFzkx8qE3SBcAMB660nKBXldYeiI');
define('CONSUMER_ACCESS_TOKEN', '345111079-dmTCMTWWDqpnVibnTpdkRuPe4P0CwTyWeaXW0x2H');
define('CONSUMER_ACCESS_TOKEN_SECRET', 'eciobsgwyGuvcedPZvDKNS1zjDEJoi7PJvxgW6DrhCAYo');
define('OAUTH_CALLBACK', 'https://www.iso.vietiso.com/inc/oauth/twitter.php');
define('SERVICE_ACCOUNT_EMAIL', 'test@vietiso.com');
define('USER_TYPE_TA', '1');
define('USER_TYPE_GANNERAL', '0');

define('ADULT', '16');
define('CHILDREN', '17');
define('INFANT', '18');
define('CHOICE_ON', '1');
define('CHOICE_OFF', '0');
define("CREATED_INVOICE", 1);
define("NOT_CREATED_INVOICE", 0);
#
define("_VND_ID", 950);
define("_USD_ID", 951);
define("_EXCHANGE_RATE", 23255);

define("PAYMENT_GLOBAL", 1);
define("PAYMENT_ONLINE_GLOBAL", 1);
define("PAYMENT_CASH_ID", 1);
define("PAYMENT_TRANSFER_ID", 2);
define("PAYMENT_ONEPAY_ATM", 3);
define("PAYMENT_ONEPAY_VISA", 4);
define("PAYMENT_PAYPAL_GATEWAY", 5);
define("PAYMENT_ONEPAY_AE", 6);
define("PAYMENT_VTCPAY_GATEWAY", 7);
define("PAYMENT_VNPAY_GATEWAY", 8);
define("PAYMENT_9PAY_GATEWAY", 9);

# TMS sync
define("USD_ID", '1298');
define("VND_ID", '1299');
define("EUR_ID", '1278');

define("_JSON_CURRENCY", json_encode(array("VND", "USD", "AUD", "CAD", "CHF", "DKK", "EUR", "GBP", "HKD", "INR", "JPY", "KRW", "KWD", "MYR", "NOK", "RUB", "SAR", "SEK", "SGD", "THB", "NZD", "PHP", "IDR")));
define("_MULTI_CURRENCY", 1);
if (!defined('_ECB_CURRENCY')) define("_ECB_CURRENCY", 1);
if (!defined('_JSON_ECB_CURRENCY')) {
    define("_JSON_ECB_CURRENCY", json_encode(array(
        "BGN",
        "CZK",
        "HUF",
        "PLN",
        "RON",
        "ISK",
        "HRK",
        "TRY",
        "BRL",
        "IDR",
        "ILS",
        "MXN",
        "NZD",
        "PHP",
        "ZAR"
    )));
}

define("SHOW_CONFIG_TMS_CONNECT", 1);

define('_ISOCMS_VERSION', '3.0.0.0');
if (!defined('MULTIPLE_LANG')) {
    define("MULTIPLE_LANG", 0);
}
if (!defined('MULTIPLE_DOMAIN')) {
    define("MULTIPLE_DOMAIN", 0);
}
#enable gzip#
if (GZIP_GLOBAL) {
    if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
        ob_start("ob_gzhandler");
    } else {
        ob_start();
    }
}
#compress and encode#
if (COMPRESS_GLOBAL) {
    function compress($buffer)
    {
        $search = array(
            '/\n/',
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s'
        );
        $replace = array(
            ' ',
            '>',
            '<',
            '\\1'
        );
        $buffer = preg_replace($search, $replace, $buffer);
        $buffer = preg_replace('/\&nbsp;/', ' ', $buffer);
        return $buffer;
    }

    ob_start("compress");
} else {
    function compress($buffer)
    {
        $buffer = preg_replace('/\&nbsp;/', ' ', $buffer);
        return $buffer;
    }

    ob_start("compress");
}

#check SSL
if (!function_exists('is_ssl')) {
    function is_ssl()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }
}

#Definition constants global#
define("HANDLE_ERROR", 0);
if (!defined('LANG_DEFAULT')) {
    define("LANG_DEFAULT", 'vn');
}
if (!function_exists('_tripslash')) {
    function _tripslash($doc)
    {
        if (substr($doc, '-1') == '/') {
            return substr($doc, 0, strlen($doc) - 1);
        }
        return $doc;
    }
}
define("_DEV", 0);
define("DS", DIRECTORY_SEPARATOR);
define("PCMS_DIR", ABSPATH);
define("DIR_LOGS", ABSPATH . '/logs');
define("LOG_SYSTEM_FILE", DIR_LOGS . '/system.log');
define("DIR_INCLUDES", ABSPATH . "/inc");
define("WEB_URL", _ISOCMS_PROTOCOL . $_SERVER['HTTP_HOST']);
define("PCMS_URL", _ISOCMS_PROTOCOL . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
define("ISOCMS_URL", _tripslash(PCMS_URL) . "/isocms");

if (!defined('_SITE_ROOT') || _SITE_ROOT == 'FRONTPAGE') {
    if (!empty($_GET["templates"])) {
        define("URL_TEMPLATES", ISOCMS_URL . "/" . $_GET["templates"]);
        define("ISOCMS_DIR", ABSPATH . DS . "isocms");
        define("DIR_LANG", PCMS_DIR . DS . "lang");
        define("DIR_TEMPLATES", ISOCMS_DIR . "/" . $_GET["templates"]);
        define("DIR_CONF", PCMS_DIR . DS . "langs");
    } else {
        define("URL_TEMPLATES", ISOCMS_URL . "/templates");
        define("ISOCMS_DIR", ABSPATH . DS . "isocms");
        define("DIR_LANG", PCMS_DIR . DS . "lang");
        define("DIR_TEMPLATES", ISOCMS_DIR . "/templates");
        define("DIR_CONF", PCMS_DIR . DS . "langs");
    }
} else {
    define("URL_TEMPLATES", ISOCMS_URL . "/templates");
    define("ISOCMS_DIR", ABSPATH . DS . "admin/isocms");
    define("DIR_LANG", PCMS_DIR . DS . "admin/lang");
    define("DIR_ADMIN_CLASSES", PCMS_DIR . "/admin/classes");
    define("DIR_TEMPLATES", ISOCMS_DIR . "/templates");
    define("DIR_CONF", PCMS_DIR . DS . "admin/langs");
}

define("DIR_MODULES", ISOCMS_DIR . "/modules");
define("DIR_FRONT_MODULES", ABSPATH . DS . "isocms/modules");

define("DIR_COMMON", DIR_INCLUDES . "/iso");
define("DIR_ADODB", DIR_INCLUDES . "/adodb");

define("DIR_SMARTY", DIR_INCLUDES . "/smarty3138");

define("DIR_LIBRARYS", DIR_INCLUDES . "/libraries");
define("DIR_CLASSES", PCMS_DIR . "/classes");
define("DIR_JSON", PCMS_DIR . "/json");
define("DIR_JSON_PROPERTY", PCMS_DIR . "/json/property");
define("DIR_JSON_ORDER", PCMS_DIR . "/json/order");
define("DIR_JSON_TOUR", PCMS_DIR . "/json/tour");
define("OKRS_PROJECT_ID", 497); //isoCMS update 2020- V7.2
define("DIR_JSON_TICKET", ABSPATH . '/json/ticket/');

if ($_SERVER['REMOTE_ADDR'] == '124.158.4.43') {
    define("SHOW_DEBUG_SMARTY", true);
} else {
    define("SHOW_DEBUG_SMARTY", false);
}
