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
define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);
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
require_once DIR_CLASSES . "/class_Sitemap.php";
require_once PCMS_DIR . "/config.php";
require_once DIR_ADODB . '/adodb.inc.php';
require_once DIR_COMMON . '/clsDbBasic.php';
require_once DIR_CLASSES . "/class_ISO.php";
require_once DIR_CLASSES . "/class_Configuration.php";
require_once DIR_CLASSES . "/class_Country.php";
require_once DIR_CLASSES . "/class_City.php";
require_once DIR_CLASSES . "/class_Package.php";
require_once DIR_CLASSES . "/class_FeaturePackage.php";
#
define("$domain_name", (isSecure() ? 'https' : 'http') . "://" . $_SERVER['HTTP_HOST']);

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
if (strlen(strstr(DOMAIN_NAME, 'essentials.isocms.com')) > 0) {
    $package_id = 1;
} elseif (strlen(strstr(DOMAIN_NAME, 'professional.isocms.com')) > 0) {
    $package_id = 2;
} elseif (strlen(strstr(DOMAIN_NAME, 'premium.isocms.com')) > 0) {
    $package_id = 3;
} else {
    $package_id = 4;
}

# - Init sitemap
$clsSitemap = new Sitemap($domain_name, $_SERVER['DOCUMENT_ROOT']);
$sitemap_urls = array();
# - Sitemap Max

# - Sitemap Second
$customClsArray = array();
if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/lang')) {
    if ($dh = opendir($_SERVER['DOCUMENT_ROOT'] . '/lang')) {
        while (($file = readdir($dh)) !== false) {
            if (substr($file, -3) == 'php') {
                $abc = str_replace('.php', '', $file);
                if ($abc != LANG_DEFAULT) {
                    array_push($customClsArray, $abc);
                }
            }
        }
        array_unshift($customClsArray, LANG_DEFAULT);
        closedir($dh);
    }
}

foreach ($customClsArray as $item) {

    global $_LANG_ID, $extLang;
    $_LANG_ID = $item;
    if ($_LANG_ID != LANG_DEFAULT) {
        $extLang = '/' . $_LANG_ID;
    } else {
        $extLang = '';
    }

    $sitemap_urls[] = $domain_name . $extLang;
    if (!empty($sitemap_urls)) {
        foreach ($sitemap_urls as $k => $v) {
            $clsSitemap->addUrl($v, date('c'), 'daily', '1.0');
        }
        unset($sitemap_urls);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'blog', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('blog');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'download', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('download');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'why', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('why');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'page', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('about');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'service', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('service');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'news', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('news');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'testimonial', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('testimonial');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'voucher', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('voucher');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'feedback', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('contact');
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'faqs', 'default', 'default')) {
        $sitemap_urls[] = $domain_name . $clsISO->getLink('faqs');
    }

    if (!empty($sitemap_urls)) {
        foreach ($sitemap_urls as $k => $v) {
            $clsSitemap->addUrl($v, date('c'), 'daily', '0.8');
        }
        unset($sitemap_urls);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'page', 'default', 'default')) {
        # - Page
        require_once DIR_CLASSES . "/class_Page.php";
        $clsPage = new Page();
        $lstItem = $clsPage->getAll("is_trash=0 and is_online=1 and page_id<>1 order by order_no ASC", $clsPage->pkey);

        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $sitemap_urls[] = $domain_name . $clsPage->getLink($item[$clsPage->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }

            unset($sitemap_urls);
        }
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'service', 'default', 'default')) {
        # - Services
        if ($clsISO->getCheckActiveModulePackage($package_id, 'service', 'category', 'default')) {
            require_once DIR_CLASSES . "/class_ServiceCategory.php";
            $clsServiceCategory = new ServiceCategory();
            $lstItem = $clsServiceCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsServiceCategory->pkey);

            if (!empty($lstItem)) {
                foreach ($lstItem as $item) {
                    $sitemap_urls[] = $domain_name . $clsServiceCategory->getLink($item[$clsServiceCategory->pkey]);
                }
                unset($lstItem);
            }
            if (!empty($sitemap_urls)) {
                foreach ($sitemap_urls as $k => $v) {
                    $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
                }
                unset($sitemap_urls);
            }
        }


        require_once DIR_CLASSES . "/class_Service.php";
        $clsService = new Service();
        $lstItem = $clsService->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsService->pkey);

        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $sitemap_urls[] = $domain_name . $clsService->getLink($item[$clsService->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
            unset($sitemap_urls);
        }
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'blog', 'default', 'default')) {
        # - Blog

        require_once DIR_CLASSES . "/class_Blog.php";
        require_once DIR_CLASSES . "/class_BlogCategory.php";
        $clsBlog = new Blog();
        $clsBlogCategory = new BlogCategory();
        if ($clsISO->getCheckActiveModulePackage($package_id, 'blog', 'category', 'default')) {
            $lstItem = $clsBlogCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsBlogCategory->pkey);

            if (!empty($lstItem)) {
                foreach ($lstItem as $item) {
                    $sitemap_urls[] = $domain_name . $clsBlogCategory->getLink($item[$clsBlogCategory->pkey]);
                }
                unset($lstItem);
            }
            if (!empty($sitemap_urls)) {
                foreach ($sitemap_urls as $k => $v) {
                    $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
                }
                unset($sitemap_urls);
            }
        }

        $lstItem = $clsBlog->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsBlog->pkey);
        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $sitemap_urls[] = $domain_name . $clsBlog->getLink($item[$clsBlog->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
            unset($sitemap_urls);
        }
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'news', 'default', 'default')) {

        # - NewsCat
        require_once DIR_CLASSES . "/class_NewsCategory.php";
        $clsNewsCategory = new NewsCategory();
        if ($clsISO->getCheckActiveModulePackage($package_id, 'news', 'category', 'default')) {
            $lstItem = $clsNewsCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsNewsCategory->pkey);
            if (!empty($lstItem)) {
                foreach ($lstItem as $item) {
                    $sitemap_urls[] = $domain_name . $clsNewsCategory->getLink($item[$clsNewsCategory->pkey]);
                }
                unset($lstItem);
            }
            if (!empty($sitemap_urls)) {
                foreach ($sitemap_urls as $k => $v) {
                    $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
                }
                unset($sitemap_urls);
            }
        }

        # - News
        require_once DIR_CLASSES . "/class_News.php";
        $clsNews = new News();
        $lstItem = $clsNews->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsNews->pkey);
        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $sitemap_urls[] = $domain_name . $clsNews->getLink($item[$clsNews->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
            unset($sitemap_urls);
        }
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'testimonial', 'default', 'default')) {
        require_once DIR_CLASSES . "/class_Testimonial.php";
        $clsTestimonial = new Testimonial();
        $lstItem = $clsTestimonial->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsTestimonial->pkey);
        if (!empty($lstItem)) {
            foreach ($lstItem as $k => $v) {
                $sitemap_urls[] = $domain_name . $clsTestimonial->getLink($v[$clsTestimonial->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
        }
        unset($clsTestimonial);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default')) {
        # - Hotel Country
        require_once DIR_CLASSES . "/class_TourCategory.php";
        require_once DIR_CLASSES . "/class_GuideCat.php";
        require_once DIR_CLASSES . "/class_Hotel.php";
        $clsHotel = new Hotel();
        $clsCity = new City();
        $clsCountry = new Country();
        if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default')) {
            $lstCountryHotel = $clsCountry->getAll("is_trash=0 and country_id IN (SELECT country_id FROM default_hotel WHERE is_trash=0 and is_online=1) order by order_no ASC", $clsCountry->pkey);
            if (!empty($lstCountryHotel)) {
                foreach ($lstCountryHotel as $k => $v) {
                    $sitemap_urls[] = $domain_name . $clsCountry->getLink($v[$clsCountry->pkey], 'Hotel');
                }
                unset($lstCountryHotel);
            }
            if (!empty($sitemap_urls)) {
                foreach ($sitemap_urls as $k => $v) {
                    $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
                }
                unset($sitemap_urls);
            }
            unset($clsCountry);

            # - Hotel City
            $lstCityHotel = $clsCity->getAll("is_trash=0 and city_id IN (SELECT city_id FROM default_hotel WHERE is_trash=0 and is_online=1) order by order_no ASC", $clsCity->pkey);
            if (!empty($lstCityHotel)) {
                foreach ($lstCityHotel as $k => $v) {
                    $sitemap_urls[] = $domain_name . $clsCity->getLink($v[$clsCity->pkey], 'Hotel');
                }
                unset($lstCityHotel);
            }
            if (!empty($sitemap_urls)) {
                foreach ($sitemap_urls as $k => $v) {
                    $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
                }
                unset($sitemap_urls);
            }
            unset($clsCity);

            # Hotel
            $lstItem = $clsHotel->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsHotel->pkey);
            if (!empty($lstItem)) {
                foreach ($lstItem as $k => $v) {
                    $sitemap_urls[] = $domain_name . $clsHotel->getLink($v[$clsHotel->pkey]);
                }
                unset($lstItem);
            }
            if (!empty($sitemap_urls)) {
                foreach ($sitemap_urls as $k => $v) {
                    $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
                }
                //unset($sitemap_urls);
            }
            unset($clsHotel);
        }
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'default', 'default')) {
        if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'category', 'default')) {
            # - Cat Tour
            require_once DIR_CLASSES . "/class_TourCategory.php";
            $clsTourCategory = new TourCategory();
            $lstItem = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsTourCategory->pkey);
            if (!empty($lstItem)) {
                foreach ($lstItem as $item) {
                    $sitemap_urls[] = $domain_name . $clsTourCategory->getLink($item[$clsTourCategory->pkey]);
                }
                unset($lstItem);
            }
            if (!empty($sitemap_urls)) {
                foreach ($sitemap_urls as $k => $v) {
                    $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
                }
                unset($sitemap_urls);
            }
        }

        # - Tour
        require_once DIR_CLASSES . "/class_Tour.php";
        $clsTour = new Tour();
        $lstItem = $clsTour->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsTour->pkey);

        if (!empty($lstItem)) {
            foreach ($lstItem as $k => $v) {
                $sitemap_urls[] = $domain_name . $clsTour->getLink($v[$clsTour->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
            unset($sitemap_urls);
        }
        unset($clsTour);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'voucher', 'default', 'default')) {
        require_once DIR_CLASSES . "/class_Voucher.php";
        $clsVoucher = new Voucher();
        $lstItem = $clsVoucher->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsVoucher->pkey);

        if (!empty($lstItem)) {
            foreach ($lstItem as $k => $v) {
                $sitemap_urls[] = $domain_name . $clsVoucher->getLink($v[$clsVoucher->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
            unset($sitemap_urls);
        }
        unset($clsVoucher);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'city', 'default', 'default')) {
        # - City destination
        require_once DIR_CLASSES . "/class_City.php";
        $clsCity = new City();
        $lstItem = $clsCity->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsCity->pkey);
        if (!empty($lstItem)) {
            foreach ($lstItem as $k => $v) {
                $sitemap_urls[] = $domain_name . $clsCity->getLink($v[$clsCity->pkey]);
            }
            unset($lstItem);
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
            unset($sitemap_urls);
        }
        unset($clsCity);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'guide', 'default', 'default')) {
        # - Guide
        require_once DIR_CLASSES . "/class_Guide.php";

        $clsGuide = new Guide();
        $clsGuideCat = new GuideCat();
        $lstItem = $clsGuide->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsGuide->pkey);
        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $sitemap_urls[] = $domain_name . $clsGuide->getLink($item[$clsGuide->pkey]);
                unset($lstItem);
            }
        }
        if (!empty($sitemap_urls)) {
            foreach ($sitemap_urls as $k => $v) {
                $clsSitemap->addUrl($v, date('c'), 'daily', '0.5');
            }
            unset($sitemap_urls);
        }
        unset($clsGuide);
    }
}

$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

# - Write Sitemap
$clsSitemap->createSitemap();
$clsSitemap->writeSitemap();

header("Content-type:text/xml;charset=utf-8");
echo (file_get_contents($domain_name . '/sitemap.xml', false, stream_context_create($arrContextOptions)));
die();
