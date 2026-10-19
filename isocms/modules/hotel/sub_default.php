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

function default_default()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $clsISO;
    #
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsHotelPriceRange = new HotelPriceRange();
    $assign_list["clsHotelPriceRange"] = $clsHotelPriceRange;
    $clsPagination = new Pagination();

    #
    $recordPerPage = 9;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $cond = "is_trash=0 and is_online=1";


    $star_id = isset($_GET['star_id']) ? $_GET['star_id'] : '';
    $type_hotel = isset($_GET['type_hotel']) ? $_GET['type_hotel'] : '';
    $price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
    $assign_list["price_range"] = $price_range;
    $priceRange = ($price_range != '') ? explode(",", $price_range) : array();
    if (count($priceRange) > 0) {
        $condPrice = " AND (";
        $check_price_contact = 0;
        for ($i = 0; $i < count($priceRange); $i++) {
            $oneTmp = $clsHotelPriceRange->getOne($priceRange[$i]);
            $min_rate = intval($oneTmp['min_rate']);
            $max_rate = ($oneTmp['max_rate']);

            if ($min_rate == 0 && $max_rate > 0) {
                $check_price_contact = 1;
                $condPrice .= (($i > 0) ? ' OR (' : '(') . " price < $max_rate";
            } elseif ($min_rate > 0 && $max_rate == 0) {
                $condPrice .= (($i > 0) ? ' OR (' : '(') . " price > " . $min_rate;
            } else {
                $condPrice .= (($i > 0) ? ' OR (' : '(') . " price BETWEEN $min_rate AND $max_rate";
            }
            unset($min_rate, $max_rate, $oneTmp);
            $condPrice .= " )";
        }
        $condPrice .= " )";
        $cond_price_contact = "";
        if ($check_price_contact == 1) {
            $cond_price_contact = " OR hotel_id NOT IN (SELECT hotel_id FROM default_hotel_room) ";
        }
        $cond .= " AND (hotel_id IN (SELECT hotel_id FROM default_hotel_room WHERE 1=1 " . $condPrice . ") " . $cond_price_contact . ") ";
    }

    if (!empty($star_id)) {
        $cond .= " and star_id IN ({$star_id})";
    }
    if (!empty($type_hotel)) {
        $cond .= " and list_TypeHotel IN (
			SELECT property_id FROM " . $clsProperty->tbl . " 
			WHERE is_trash=0 and property_id IN ({$type_hotel})
		)";
    }
    $keyword = (isset($_GET['key']) && !empty($_GET['key'])) ? $_GET['key'] : '';
    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
        $assign_list["keyword"] = $keyword;
    }

    $number_adults = (isset($_GET['number_adults']) && !empty($_GET['number_adults'])) ? $_GET['number_adults'] : 1;
    $assign_list["number_adults"] = $number_adults;
    $number_child = (isset($_GET['number_child']) && !empty($_GET['number_child'])) ? $_GET['number_child'] : 0;
    $assign_list["number_child"] = $number_child;

    $check_in_date = (isset($_GET['check_in_date']) && !empty($_GET['check_in_date'])) ? $_GET['check_in_date'] : '';
    $check_out_date = (isset($_GET['check_out_date']) && !empty($_GET['check_out_date'])) ? $_GET['check_out_date'] : '';
    $assign_list["check_out_date"] = $check_out_date;
    $assign_list["check_in_date"] = $check_in_date;

    $order_by = " order by order_no ASC";
    $totalItem = $clsHotel->getAll($cond, $clsHotel->pkey);
    $totalRecord = $totalItem ? count($totalItem) : 0;
    $assign_list['totalRecord'] = $totalRecord;
    #
    $lnk = $_SERVER['REQUEST_URI'];
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $link_page = substr($lnk, 0, $str_len);
    } else {
        $link_page = $lnk;
    }
    $order_by = " ORDER BY order_no ASC";
    #
    $link_page = $clsISO->getLink('hotel');
    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page_1' => $link_page
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);
    #
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    $listHotel = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ',star_id');
    $assign_list['listHotel'] = $listHotel;
    unset($listHotel);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();
    #
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('Hotel') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_place()
{
    //	ini_set('display_errors', '1');
    //ini_set('display_startup_errors', '1');
    //error_reporting(E_ALL);
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $country_id, $city_id, $extLang;
    global $clsISO, $package_id;
    #
    $clsCountryEx = new Country();
    $assign_list["clsCountryEx"] = $clsCountryEx;
    $clsRegion = new Region();
    $assign_list["clsRegion"] = $clsRegion;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsBlog = new Blog();
    $assign_list['clsBlog'] = $clsBlog;
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsGuideCatStore = new GuideCatStore();
    $assign_list["clsGuideCatStore"] = $clsGuideCatStore;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsHotelPriceRange = new HotelPriceRange();
    $assign_list["clsHotelPriceRange"] = $clsHotelPriceRange;

    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    if ($clsISO->getCheckActiveModulePackage($package_id, 'guide', 'cat', 'default')) {
        $listGuideCat = $clsGuideCat->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsGuideCat->pkey . ',title,slug');
        $assign_list['listGuideCat'] = $listGuideCat;
        unset($listGuideCat);
    }
    if ($show == 'Country') {
        $slug_country = isset($_GET['slug_country']) ? $_GET['slug_country'] : '';
        $res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1", $clsCountryEx->pkey . ',slug,title,intro,content,intro_hotel,image_hotel');
        $country_id = $res[0][$clsCountryEx->pkey];
        if (intval($country_id) == 0) {
            header('Location:'  . $extLang);
            exit();
        }
        $assign_list["countryItem"] = $res[0];
        $assign_list['country_id'] = $country_id;
        $place_id = $country_id;
        $clsClassTable = 'Country';
        #
        $oneItem = $res[0];
        $title_page = $clsCountryEx->getTitle($country_id, $oneItem);
        $intro_page = $clsCountryEx->getStripIntro($country_id, $oneItem);
        $intro_hotel = $clsCountryEx->getIntro($country_id, 'Hotel', false, $oneItem);
        $content_page = $clsCountryEx->getContent($country_id, $oneItem);
        $link_page = $clsCountryEx->getLink($country_id, $oneItem);

        $clsCityStore = new CityStore();
        $assign_list['clsCityStore'] = $clsCityStore;
        //		$listTopCity = $clsCityStore->getAll("country_id='$country_id' and type='TOP' order by order_no ASC");
        //		$assign_list['listTopCity'] = $listTopCity; unset($listTopCity);
        #

    }

    if ($show == 'City') {
        $slug_city = isset($_GET['slug_city']) ? $_GET['slug_city'] : '';
        $city_id = $clsCity->getBySlug($slug_city);
        if (intval($city_id) == 0) {
            header('Location:' . PCMS_URL . $extLang);
            exit();
        }
        $assign_list["city_id"] = $city_id;
        $place_id = $city_id;
        $clsClassTable = 'City';

        $oneItem = $clsCity->getOne($city_id, 'title,slug,intro,content,intro_hotel,image_hotel');
        $title_page = $clsCity->getTitle($city_id, $oneItem);
        $intro_page = $clsCity->getIntro($city_id, '', false, $oneItem);
        $intro_hotel = $clsCity->getIntro($city_id, 'Hotel', false, $oneItem);
        $content_page = $clsCity->getContent($city_id, $oneItem);
        $link_page = $clsCity->getLink($city_id, '', false, $oneItem);
        $country_id = $oneItem['country_id'];
        $assign_list['country_id'] = $country_id;
    }
    if ($show == 'Region') {
        $slug_country = isset($_GET['slug_country']) ? $_GET['slug_country'] : '';
        $res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1", $clsCountryEx->pkey . ",title,slug,intro,content,intro_hotel,image_hotel");
        $country_id = $res[0][$clsCountryEx->pkey];
        $region_id = isset($_GET['region_id']) ? $_GET['region_id'] : '';

        if (intval($region_id) == 0) {
            header('Location:' . PCMS_URL . $extLang);
            exit();
        }
        $assign_list["country_id"] = $country_id;
        $assign_list["region_id"] = $region_id;
        $place_id = $region_id;
        $clsClassTable = 'Region';
        $oneItem = $res[0];
        $title_page = $clsRegion->getTitle($region_id, $oneItem);
        $intro_page = $clsRegion->getIntro($region_id, '', false, $oneItem);
        $intro_hotel = $clsRegion->getIntro($region_id, 'Hotel', $oneItem);
        $content_page = $clsRegion->getContent($region_id, $oneItem);
        $link_page = $clsRegion->getLink($region_id, '', false, $oneItem);
    }

    $assign_list['oneItem'] = $oneItem;
    $assign_list['TD'] = $title_page;
    $assign_list['ID'] = $intro_page;
    $assign_list['HOTEL_INTRO'] = $intro_hotel;
    $assign_list['CD'] = $content_page;
    $assign_list['link_page'] = $link_page;

    if ($clsISO->getCheckActiveModulePackage($package_id, 'region', 'default', 'default')) {
        $lstRegionByCountry = $clsRegion->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no ASC", $clsRegion->pkey . ',title');
        $assign_list['lstRegionByCountry'] = $lstRegionByCountry;
        unset($lstRegionByCountry);

        $lstCityRegionOther = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id=0 and  city_id IN (SELECT city_id FROM " . DB_PREFIX . "hotel WHERE is_trash=0 and is_online=1) order by order_no ASC", $clsCity->pkey . ',title');
        $assign_list['lstCityRegionOther'] = $lstCityRegionOther;
        unset($lstCityRegionOther);
    }


    $recordPerPage = 9;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $cond = "is_trash=0 and is_online=1";

    if ($show == 'Country') {
        $cond .= " and country_id='$country_id'";
    } elseif ($show == 'City') {
        $cond .= " and city_id='$city_id'";
    } elseif ($show == 'Region') {
        $cond .= " and city_id IN (SELECT city_id FROM " . DB_PREFIX . "city WHERE country_id='$country_id' and region_id='$region_id')";
    } else {
        $cond .= "";
    }
    $star_id = isset($_GET['star_id']) ? $_GET['star_id'] : array();
    $type_hotel = isset($_GET['type_hotel']) ? $_GET['type_hotel'] : array();
    $city = isset($_GET['city']) ? $_GET['city'] : "";

    $price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
    $assign_list["price_range"] = $price_range;
    $priceRange = ($price_range != '') ? explode(",", $price_range) : array();
    if (count($priceRange) > 0) {
        $condPrice = " AND (";
        $check_price_contact = 0;
        for ($i = 0; $i < count($priceRange); $i++) {
            $oneTmp = $clsHotelPriceRange->getOne($priceRange[$i]);
            $min_rate = intval($oneTmp['min_rate']);
            $max_rate = ($oneTmp['max_rate']);

            if ($min_rate == 0 && $max_rate > 0) {
                $check_price_contact = 1;
                $condPrice .= (($i > 0) ? ' OR (' : '(') . " price < $max_rate";
            } elseif ($min_rate > 0 && $max_rate == 0) {
                $condPrice .= (($i > 0) ? ' OR (' : '(') . " price > " . $min_rate;
            } else {
                $condPrice .= (($i > 0) ? ' OR (' : '(') . " price BETWEEN $min_rate AND $max_rate";
            }
            unset($min_rate, $max_rate, $oneTmp);
            $condPrice .= " )";
        }
        $condPrice .= " )";
        $cond_price_contact = "";
        if ($check_price_contact == 1) {
            $cond_price_contact = " OR hotel_id NOT IN (SELECT hotel_id FROM default_hotel_room) ";
        }
        $cond .= " AND (hotel_id IN (SELECT hotel_id FROM default_hotel_room WHERE 1=1 " . $condPrice . ") " . $cond_price_contact . ") ";
    }
    if (!empty($star_id)) {
        $cond .= " and star_id IN ({$star_id})";
    }
    if (!empty($type_hotel)) {
        $cond .= " and list_TypeHotel IN (
			SELECT property_id FROM " . $clsProperty->tbl . " 
			WHERE is_trash=0 and property_id IN ({$type_hotel})
		)";
    }
    if (!empty($city)) {
        $cond .= " and city_id IN (" . $city . ")";
    }
    $keyword = (isset($_GET['key']) && !empty($_GET['key'])) ? $_GET['key'] : '';
    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
        $assign_list["keyword"] = $keyword;
    }

    $number_adults = (isset($_GET['number_adults']) && !empty($_GET['number_adults'])) ? $_GET['number_adults'] : 1;
    $assign_list["number_adults"] = $number_adults;
    $number_child = (isset($_GET['number_child']) && !empty($_GET['number_child'])) ? $_GET['number_child'] : 0;
    $assign_list["number_child"] = $number_child;
    $check_in_date = (isset($_GET['check_in_date']) && !empty($_GET['check_in_date'])) ? $_GET['check_in_date'] : '';
    $assign_list["check_in_date"] = $check_in_date;
    $check_out_date = (isset($_GET['check_out_date']) && !empty($_GET['check_out_date'])) ? $_GET['check_out_date'] : '';
    $assign_list["check_out_date"] = $check_out_date;

    $order_by = " order by order_no ASC";
    $totalItem = $clsHotel->getAll($cond, $clsHotel->pkey);
    $totalRecord = $totalItem ? count($totalItem) : 0;
    $assign_list['totalRecord'] = $totalRecord;

    $lnk = $_SERVER['REQUEST_URI'];
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $link_page = substr($lnk, 0, $str_len);
    } else {
        $link_page = $lnk;
    }

    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page' => $link_page
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);
    #
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    #
    $listHotelPlace = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ',star_id,slug,title,address,intro,image');

    $assign_list['listHotelPlace'] = $listHotelPlace;
    $assign_list['page_view'] = $page_view;
    unset($listHotelPlace);
    unset($page_view);
    #
    $totalPage = $clsPagination->getTotalPage();
    $assign_list['totalPage'] = $totalPage;
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, 'blog', 'blog_destination', 'customize')) {
        $sql = "is_trash=0 and is_online=1";
        if ($show == 'Country') {
            $listBlogPlace = $clsBlog->getAll($sql . " and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id')", $clsBlog->pkey);
        } elseif ($show == 'City') {
            $listBlogPlace = $clsBlog->getAll($sql . " and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id' and city_id='$city_id')", $clsBlog->pkey);
        } else {
            $listBlogPlace = $clsBlog->getAll($sql . " and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE is_trash=0 and country_id='$country_id' and region_id='$region_id' and type='REGION'))", $clsBlog->pkey);
        }
        $assign_list['listBlogPlace'] = $listBlogPlace;
        unset($listBlogPlace);
    }
    if (empty($lstRegionByCountry)) {
        $letter = array();
        foreach (range('a', 'z') as $i) {
            $lstCityAZ = $clsISO->getItemByAlphabetCityHotel($country_id, $city_id, $i);
            if ($lstCityAZ) {
                $letter[] = $i;
            }
        }
        $assign_list['letter'] = $letter;
        //print_r($letter); die();
    }


    vnSessionSetVar('linkBack', $_SERVER['REQUEST_URI']);
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('Hotels in') . ' ' . $title_page . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($place_id, $clsClassTable, $oneItem);
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_ajLoadMoreHotel()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $country_id, $city_id;
    global $clsISO;
    #

    $clsCountryEx = new Country();
    $assign_list["clsCountryEx"] = $clsCountryEx;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;

    #
    $show = isset($_POST['show']) ? $_POST['show'] : '';

    $recordPerPage = 12;
    $keyword = isset($_POST['keyword']) ? intval($_POST['keyword']) : '';
    $currentPage = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : '0';


    if ($show == 'Search') {
        $city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : '';
        $star_id = isset($_POST['star_id']) ? intval($_POST['star_id']) : '';
        $price_range = isset($_POST['price_range']) ? intval($_POST['price_range']) : '';
    }

    $cond = "is_trash=0 and is_online=1";

    if ($show == 'Search') {
        if (intval($country_id) > 0) {
            $cond .= " and country_id='$country_id'";
            $assign_list["country_id"] = $country_id;
        }
        if (intval($city_id) > 0) {
            $cond .= " and city_id='$city_id'";
            $assign_list["city_id"] = $city_id;
        }
        if (intval($star_id) > 0) {
            $cond .= " and star_id='$star_id'";
            $assign_list["star_id"] = $star_id;
        }
        if (intval($price_range) > 0) {
            $clsPriceRange = new HotelPriceRange();
            $oneTmp = $clsPriceRange->getOne($price_range);
            $min_rate = intval($oneTmp['min_rate']);
            $max_rate = ($oneTmp['max_rate']);

            if ($min_rate == 0 && $max_rate > 0) {
                $cond .= " and price_avg < '$max_rate'";
            } elseif ($min_rate > 0 && $max_rate == 0) {
                $cond .= " and price_avg > " . $min_rate;
            } else {
                $cond .= " and price_avg > '$min_rate' and price_avg < '$max_rate'";
            }
            $assign_list["price_range"] = $price_range;
        }
        if ($keyword != '') {
            $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
            $assign_list["keyword"] = $keyword;
        }
    } else {
        if ($show == 'Country') {
            $cond .= " and country_id='$country_id'";
        } elseif ($show == 'City') {
            $cond .= " and city_id='$city_id'";
        } elseif ($show == 'Region') {
            $cond .= " and city_id IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE country_id='$country_id' and region_id='$region_id')";
        } else {
            $cond .= "";
        }
    }
    $order_by = " order by order_no ASC";
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    $listHotelPlace = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ',star_id');
    $assign_list['listHotelPlace'] = $listHotelPlace;
    $html = $core->build('load_more_hotel.tpl');
    echo $html;
    die;
}

function default_ajLoadMoreHotelSearch()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $country_id, $city_id;
    global $clsISO;
    #

    $clsCountryEx = new Country();
    $assign_list["clsCountryEx"] = $clsCountryEx;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;

    #
    $show = isset($_POST['show']) ? $_POST['show'] : '';

    $recordPerPage = 12;
    $keyword = isset($_POST['keyword']) ? intval($_POST['keyword']) : '';
    $currentPage = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : '0';


    $city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : '';
    $star_id = isset($_POST['star_id']) ? intval($_POST['star_id']) : '';
    $price_range = isset($_POST['price_range']) ? intval($_POST['price_range']) : '';

    $cond = "is_trash=0 and is_online=1";

    if (intval($country_id) > 0) {
        $cond .= " and country_id='$country_id'";
        $assign_list["country_id"] = $country_id;
    }
    if (intval($city_id) > 0) {
        $cond .= " and city_id='$city_id'";
        $assign_list["city_id"] = $city_id;
    }
    if (intval($star_id) > 0) {
        $cond .= " and star_id='$star_id'";
        $assign_list["star_id"] = $star_id;
    }
    if (intval($price_range) > 0) {
        $clsPriceRange = new HotelPriceRange();
        $oneTmp = $clsPriceRange->getOne($price_range);
        $min_rate = intval($oneTmp['min_rate']);
        $max_rate = ($oneTmp['max_rate']);

        if ($min_rate == 0 && $max_rate > 0) {
            $cond .= " and price_avg < '$max_rate'";
        } elseif ($min_rate > 0 && $max_rate == 0) {
            $cond .= " and price_avg > " . $min_rate;
        } else {
            $cond .= " and price_avg > '$min_rate' and price_avg < '$max_rate'";
        }
        $assign_list["price_range"] = $price_range;
    }
    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
        $assign_list["keyword"] = $keyword;
    }
    $order_by = " order by order_no ASC";
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    $listHotelPlace = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ',star_id');
    $assign_list['listHotelPlace'] = $listHotelPlace;
    $html = $core->build('load_more_hotel_search.tpl');
    echo $html;
    die;
}

function default_search()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;

    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list["show"] = $show;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $assign_list["sort"] = $sort;
    $mode = vnSessionGetVar('_VIEWMODE_' . $mod . '_' . $act) != '' ? vnSessionGetVar('_VIEWMODE_' . $mod . '_' . $act) : 'list';
    $assign_list["mode"] = $mode;
    $sortType = vnSessionGetVar('_SORT_TYPE') != '' ? vnSessionGetVar('_SORT_TYPE') : '';
    $assign_list["sortType"] = $sortType;
    $sortVal = vnSessionGetVar('_SORT_VAL') != '' ? vnSessionGetVar('_SORT_VAL') : '';
    $assign_list["sortVal"] = $sortVal;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsPriceRange = new PriceRange();
    $assign_list['clsPriceRange'] = $clsPriceRange;
    $country_id = (isset($_GET['country_id']) && $_GET['country_id'] != '') ? $_GET['country_id'] : '';
    $city_id = (isset($_GET['city_id']) && $_GET['city_id'] != '') ? $_GET['city_id'] : '';
    $star_id = (isset($_GET['star_id']) && $_GET['star_id'] != '') ? $_GET['star_id'] : '';
    $price_range = (isset($_GET['price_range']) && $_GET['price_range'] != '') ? $_GET['price_range'] : '';
    $keyword = (isset($_GET['key']) && !empty($_GET['key'])) ? $_GET['key'] : '';

    $sql = "SELECT DISTINCT t1.city_id FROM " . DB_PREFIX . "city t1 INNER JOIN " . DB_PREFIX . "hotel t2 WHERE t1.city_id = t2.city_id AND t2.country_id = '$country_id' AND t2.is_trash=0 AND t2.is_online=1 ORDER BY t1.slug ASC";

    $rslCity = $dbconn->GetAll($sql);
    $assign_list['rslCity'] = $rslCity;
    unset($rslCity);
    $cond = "is_trash=0 and is_online=1";
    if (intval($country_id) > 0) {
        $cond .= " and country_id='$country_id'";
        $assign_list["country_id"] = $country_id;
    }
    if (intval($city_id) > 0) {
        $cond .= " and city_id='$city_id'";
        $assign_list["city_id"] = $city_id;
    }
    if (intval($star_id) > 0) {
        $cond .= " and star_id='$star_id'";
        $assign_list["star_id"] = $star_id;
    }
    if (intval($price_range) > 0) {
        $clsPriceRange = new HotelPriceRange();
        $oneTmp = $clsPriceRange->getOne($price_range);
        $min_rate = intval($oneTmp['min_rate']);
        $max_rate = ($oneTmp['max_rate']);


        if ($min_rate == 0 && $max_rate > 0) {
            $cond .= " and price_avg < '$max_rate'";
        } elseif ($min_rate > 0 && $max_rate == 0) {
            $cond .= " and price_avg > " . $min_rate;
        } else {
            $cond .= " and price_avg > '$min_rate' and price_avg < '$max_rate'";
        }
        $assign_list["price_range"] = $price_range;
    }
    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";

        $assign_list["keyword"] = $keyword;
    }
    #
    $order_by = " order by order_no ASC";
    if (isset($sort) && !empty($sort)) {
        switch ($sort) {
            case 'a-z':
                $order_by = "order by slug asc";
                break;
            case 'name':
                $order_by = "order by slug asc";
                break;
            case 'price':
                $order_by = "order by price asc";
                break;
            case 'star':
                $order_by = "order by star_id asc";
                break;
            default:
                $order_by = "order by order_no desc";
        }
    }
    #
    if (isset($sortType) && !empty($sortType)) {
        if ($sortType == 'DEFAULT') {
            if (isset($sortVal) && !empty($sortVal)) {
                switch ($sortVal) {
                    case 'NAME':
                        $order_by = "order by slug asc";
                        break;
                    case 'PRICE':
                        $order_by = "order by price_avg asc";
                        break;
                    case 'RANK':
                        $order_by = "order by star_id asc";
                        break;
                    default:
                        $order_by = "order by order_no desc";
                }
            }
        }
        if ($sortType == 'CITY') {
            if (isset($sortVal) && !empty($sortVal)) {
                $cond .= " and city_id = '$sortVal'";
            }
        }
    }
    #
    $recordPerPage = 12;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    $totalRecord = $clsHotel->getAll($cond) ? count($clsHotel->getAll($cond)) : 0;

    $assign_list['totalRecord'] = $totalRecord;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalPage'] = $totalPage;

    $listHotel = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ',star_id');
    $assign_list['listHotel'] = $listHotel;
    unset($listHotel);

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('resultsearch') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
    unset($clsHotel);
}

function default_detail()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $curl;
    global $country_id, $clsISO, $package_id, $hotel_id, $extLang;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    #
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsHotelProperty = new HotelProperty();
    $assign_list['clsHotelProperty'] = $clsHotelProperty;
    $clsProperty = new Property();
    $assign_list['clsProperty'] = $clsProperty;
    $clsHotelAttraction = new HotelAttraction();
    $assign_list['$clsHotelAttraction'] = $clsHotelAttraction;
    $clsAttraction = new Attraction();
    $assign_list['clsAttraction'] = $clsAttraction;
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsCountry = new _Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsHotelImage = new HotelImage();
    $assign_list['clsHotelImage'] = $clsHotelImage;
    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;
    $clsHotelPriceCol = new HotelPriceCol();
    $assign_list['clsHotelPriceCol'] = $clsHotelPriceCol;
    $clsHotelPriceVal = new HotelPriceVal();
    $assign_list['clsHotelPriceVal'] = $clsHotelPriceVal;

    $linkBack = vnSessionGetVar('linkBack');
    $assign_list['linkBack'] = $linkBack;

    $hotel_id = isset($_GET['hotel_id']) ? $_GET['hotel_id'] : 0;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    if (empty($clsHotel->checkOnlineBySlug($hotel_id, $slug))) {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    }

    $assign_list['hotel_id'] = $hotel_id;
    $assign_list["table_id"] = $hotel_id;

    ////$abc= $clsHotel->getImageMapStatic($hotel_id,400,400);print_r($abc);die();


    $oneItem = $clsHotel->getOne($hotel_id);

    $assign_list['oneItem'] = $oneItem;
    if ($oneItem['is_online'] == 0) {
        header('location:' . PCMS_URL . $extLang);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_gallery', 'customize')) {
        #-- Hotel Images
        $listImage = $clsHotelImage->getAll("is_trash=0 and table_id='$hotel_id' and image <> '' order by order_no ASC", $clsHotelImage->pkey . ',image,title');
        $assign_list['listImage'] = $listImage;
        unset($listImage);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_room', 'customize')) {
        #-- Hotel Rooms
        $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no ASC", $clsHotelRoom->pkey . ',room_type_id');
        $assign_list['lstHotelRoom'] = $lstHotelRoom;
        unset($lstHotelRoom);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'property', 'default', 'HotelFacilities')) {
        #list all Room and hotel Facilities
        $list_HotelFacilities = $oneItem['list_HotelFacilities'];


        $lstHotelFacility = array();
        if ($list_HotelFacilities != '' && $list_HotelFacilities != '0') {
            $list_HotelFacilities = str_replace('||', '|', $list_HotelFacilities);
            $list_HotelFacilities = ltrim($list_HotelFacilities, '|');
            $list_HotelFacilities = rtrim($list_HotelFacilities, '|');
            $TMP = explode('|', $list_HotelFacilities);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstHotelFacility)) {
                    $lstHotelFacility[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstHotelFacility'] = $lstHotelFacility;
        unset($lstHotelFacility);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_related', 'customize')) {
        #-- Hotel Related
        $lstHotelRelated = $clsHotel->getAll("is_trash=0 and is_online=1 and hotel_id <> '$hotel_id' and city_id ='" . $oneItem['city_id'] . "' order by order_no desc limit 0,10", $clsHotel->pkey . ',star_id,slug,title,image,intro,address');

        $assign_list['lstHotelRelated'] = $lstHotelRelated;
        unset($lstHotelRelated);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_custom_field', 'customize')) {
        #- Custom Field
        $clsHotelCustomField = new HotelCustomField();
        $assign_list["clsHotelCustomField"] = $clsHotelCustomField;

        $listCustomField = $clsHotelCustomField->getAll("hotel_id='$hotel_id' and fieldtype='CUSTOM' order by order_no ASC", $clsHotelCustomField->pkey . ',fieldvalue,fieldname');
        $assign_list["listCustomField"] = $listCustomField;
        unset($listCustomField);
    }

    $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and price >0 order by price ASC", $clsHotelRoom->pkey . ",price,number_adult");
    $min_price = $lstHotelRoom[0]['price'];

    if ($min_price) {
        $number_adult = $lstHotelRoom[0]['number_adult'] ? $lstHotelRoom[0]['number_adult'] : 2;
    }
    $assign_list["min_price"] = $min_price;
    $assign_list["number_adult"] = $number_adult;

    #Review
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsReviewsHotel = new ReviewsHotel();
    $assign_list['clsReviewsHotel'] = $clsReviewsHotel;
    $lstReviewHotel = $clsReviewsHotel->getAll(" hotel_id = '" . $hotel_id . "' limit 0,1", $clsReviewsHotel->pkey . ',staff,amenities,clean,place,food_drink,worthy');
    $assign_list['lstReviewHotel'] = $lstReviewHotel[0];
    //	$clsReviews->setDeBug(1);
    $lstReview = $clsReviews->getAll("is_trash=0 and is_online=1 and type='hotel' and table_id = '" . $hotel_id . "' order by order_no asc", $clsReviews->pkey . ',review_date,fullname,content,title,rates,reg_date,fullname,country_id');
    //echo $totalRecord;die('xxxx');
    $jsonReview = array();
    if (!empty($lstReview)) {
        foreach ($lstReview as $k => $v) {
            $jsonReview[] = array(
                "@type" => "Review",
                "author" => $v["fullname"],
                "datePublished" => $clsISO->converTimeToText($v['review_date']),
                "description" => addslashes($v["content"]),
                "name" => $v["title"],
                "reviewRating" => array(
                    "@type" => "Rating",
                    "bestRating" => "5",
                    "ratingValue" => $v["rates"],
                    "worstRating" => "1",
                ),
            );
        }
    }
    //	var_dump($lstReview);die;
    $assign_list["jsonReview"] = json_encode($jsonReview);
    unset($jsonReview);
    $assign_list["lstReview"] = $lstReview;
    unset($lstReview);
    $assign_list['btn_view_more'] = '<a data-bs-toggle="modal" data-bs-target="#mdReview" class="read_more read_more_review">' . $core->get_Lang('Read more') . '</a>';

    if (isset($_POST['ContactHotel']) && $_POST['ContactHotel'] == 'ContactHotel') {
        vnSessionDelVar('ContactCruise');
        vnSessionDelVar('ContactTour');
        vnSessionDelVar('ContactHotel');
        vnSessionDelVar('ContactVoucher');
        $cartSessionHotel = vnSessionGetVar('ContactHotel');
        if (empty($cartSessionHotel)) {
            $cartSessionHotel = array();
        }
        $assign_list["cartSessionHotel"] = $cartSessionHotel;

        $link = $clsHotel->getLinkContact();
        $cartSessionHotel['HOTEL'][$hotel_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionHotel['HOTEL'][$hotel_id][$k] = $v;
        }
        $hotels = vnSessionGetVar('hotels');
        $check_in_date = str_replace('/', '-', $hotels['check_in_date']);
        $check_in_date = strtotime($check_in_date);
        $check_out_date = str_replace('/', '-', $hotels['check_out_date']);
        $check_out_date = strtotime($check_out_date);
        foreach ($hotels as $k => $v) {
            $cartSessionHotel['HOTEL'][$hotel_id]['check_in_date'] = $check_in_date;
            $cartSessionHotel['HOTEL'][$hotel_id]['check_out_date'] = $check_out_date;
            $cartSessionHotel['HOTEL'][$hotel_id]['number_adults'] = $hotels['number_adults'];
            $cartSessionHotel['HOTEL'][$hotel_id]['number_child'] = $hotels['number_child'];
        }
        vnSessionSetVar('ContactHotel', $cartSessionHotel);
        header('location:' . $link);
        exit();
    }

    /*=============Title & Description Page==================*/
    $title_page = $clsHotel->getTitle($hotel_id, $oneItem) . ' | ' . $core->get_Lang('hotels') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $description_page = $clsISO->getMetaDescription($hotel_id, 'Hotel', $oneItem);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($hotel_id, 'Hotel', $oneItem);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;

    vnSessionDelVar('linkBack');
    vnSessionSetVar('linkBack', $_SERVER['REQUEST_URI']);
}

function default_detail2()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $curl;
    global $country_id, $clsISO, $package_id;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    #
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsHotelProperty = new HotelProperty();
    $assign_list['clsHotelProperty'] = $clsHotelProperty;
    $clsProperty = new Property();
    $assign_list['clsProperty'] = $clsProperty;
    $clsHotelAttraction = new HotelAttraction();
    $assign_list['$clsHotelAttraction'] = $clsHotelAttraction;
    $clsAttraction = new Attraction();
    $assign_list['clsAttraction'] = $clsAttraction;
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsHotelImage = new HotelImage();
    $assign_list['clsHotelImage'] = $clsHotelImage;
    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;
    $clsHotelPriceCol = new HotelPriceCol();
    $assign_list['clsHotelPriceCol'] = $clsHotelPriceCol;
    $clsHotelPriceVal = new HotelPriceVal();
    $assign_list['clsHotelPriceVal'] = $clsHotelPriceVal;

    $linkBack = vnSessionGetVar('linkBack');
    $assign_list['linkBack'] = $linkBack;

    $hotel_id = isset($_GET['hotel_id']) ? $_GET['hotel_id'] : 0;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    if (empty($clsHotel->checkOnlineBySlug($hotel_id, $slug))) {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    }

    $assign_list['hotel_id'] = $hotel_id;
    $oneItem = $clsHotel->getOne($hotel_id);
    $assign_list['oneItem'] = $oneItem;
    if ($oneItem['is_online'] == 0) {
        header('location:' . PCMS_URL . $extLang);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_gallery', 'customize')) {
        #-- Hotel Images
        $listImage = $clsHotelImage->getAll("is_trash=0 and table_id='$hotel_id' and image <> '' order by order_no ASC", $clsHotelImage->pkey . ',image');
        $assign_list['listImage'] = $listImage;
        unset($listImage);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_room', 'customize')) {
        #-- Hotel Rooms
        $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no ASC", $clsHotelRoom->pkey . ',room_type_id');
        $assign_list['lstHotelRoom'] = $lstHotelRoom;
        unset($lstHotelRoom);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'property', 'default', 'default', 'HotelFacilities')) {
        #list all Room and hotel Facilities
        $list_HotelFacilities = $oneItem['list_HotelFacilities'];
        $lstHotelFacility = array();
        if ($list_HotelFacilities != '' && $list_HotelFacilities != '0') {
            $list_HotelFacilities = str_replace('||', '|', $list_HotelFacilities);
            $list_HotelFacilities = ltrim($list_HotelFacilities, '|');
            $list_HotelFacilities = rtrim($list_HotelFacilities, '|');
            $TMP = explode('|', $list_HotelFacilities);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstHotelFacility)) {
                    $lstHotelFacility[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstHotelFacility'] = $lstHotelFacility;
        unset($lstHotelFacility);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_related', 'customize')) {
        #-- Hotel Related
        $lstHotelRelated = $clsHotel->getAll("is_trash=0 and is_online=1 and hotel_id <> '$hotel_id' order by order_no desc limit 0,10", $clsHotel->pkey . ',star_id');

        $assign_list['lstHotelRelated'] = $lstHotelRelated;
        unset($lstHotelRelated);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_custom_field', 'customize')) {
        #- Custom Field
        $clsHotelCustomField = new HotelCustomField();
        $assign_list["clsHotelCustomField"] = $clsHotelCustomField;

        $listCustomField = $clsHotelCustomField->getAll("hotel_id='$hotel_id' and fieldtype='CUSTOM' order by order_no ASC");
        $assign_list["listCustomField"] = $listCustomField;
        unset($listCustomField);
    }

    /*=============Title & Description Page==================*/
    $title_page = $clsHotel->getTitle($hotel_id) . ' | ' . $core->get_Lang('hotels') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $description_page = $clsISO->getMetaDescription($hotel_id, 'Hotel');
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($hotel_id, 'Hotel');
    $assign_list["global_image_seo_page"] = $global_image_seo_page;

    vnSessionDelVar('linkBack');
    vnSessionSetVar('linkBack', $_SERVER['REQUEST_URI']);
}

function default_place2024()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act;
    global $extLang, $_LANG_ID, $title_page, $description_page;
    global $keyword_page, $country_id, $city_id, $key_search;
    global $clsISO, $package_id, $deviceType;
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;

    /* =========================================================
     * Assets
     * ========================================================= */
    Asset::css([
        "{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.css",
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$v_cache}",
        "{$URL_CSS}/2024_hotel.css?v={$upd_version}"
    ]);

    Asset::js([
        "{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.js",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}"
    ]);

    /* =========================================================
     * Khởi tạo class
     * ========================================================= */
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;

    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;

    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;

    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;

    $clsPagination = new Pagination();
    $assign_list['clsPagination'] = $clsPagination;

    $clsProperty = new Property();
    $assign_list['clsProperty'] = $clsProperty;

    /*
     * Chuẩn hóa dữ liệu filter.
     *
     * Hỗ trợ:
     * hotel_star=1,2,3
     * hotel_star[]=1&hotel_star[]=2
     * hotel_star=1/2/3
     */
    $normalizeFilterIds = static function ($value) {
        $result = [];

        if (is_array($value)) {
            $rawValues = $value;
        } elseif (is_string($value) || is_numeric($value)) {
            $value = trim((string)$value);

            if ($value === '') {
                return [];
            }

            $rawValues = preg_split('/[,|\/]+/', $value);
        } else {
            return [];
        }

        foreach ($rawValues as $rawValue) {
            /*
             * Trường hợp phần tử bên trong array vẫn chứa dấu phẩy.
             */
            if (is_string($rawValue) && preg_match('/[,|\/]/', $rawValue)) {
                $subValues = preg_split('/[,|\/]+/', $rawValue);
            } else {
                $subValues = [$rawValue];
            }

            foreach ($subValues as $item) {
                if (is_array($item) || is_object($item)) {
                    continue;
                }

                $item = trim((string)$item);

                if ($item === '' || !ctype_digit($item)) {
                    continue;
                }

                $item = (int)$item;

                if ($item > 0) {
                    $result[] = $item;
                }
            }
        }

        return array_values(array_unique($result));
    };

    /*
     * Escape chuỗi dùng trong câu SQL.
     */
    $escapeSql = static function ($value) use ($dbconn) {
        $value = trim((string)$value);

        if ($value === '') {
            return '';
        }

        if (is_object($dbconn) && method_exists($dbconn, 'escape')) {
            return $dbconn->escape($value);
        }

        if (is_object($dbconn) && method_exists($dbconn, 'escapeString')) {
            return $dbconn->escapeString($value);
        }

        return addslashes($value);
    };

    /* =========================================================
     * Biến đầu vào
     * ========================================================= */
    $key_search = isset($_GET['key']) && !is_array($_GET['key'])
        ? trim((string)$_GET['key'])
        : '';

    $show = isset($_GET['show']) && !is_array($_GET['show'])
        ? trim((string)$_GET['show'])
        : '';

    $assign_list['key_search'] = $key_search;
    $assign_list['keyword'] = $key_search;
    $assign_list['show'] = $show;

    $country_id = 0;
    $place_id = 0;
    $clsClassTable = '';
    $oneItem = [];
    $intro_hotel = '';
    $link_page = '';

    /* =========================================================
     * Trang quốc gia
     * ========================================================= */
    if ($show === 'Country') {
        $slug_country = isset($_GET['slug_country'])
            && !is_array($_GET['slug_country'])
            ? trim((string)$_GET['slug_country'])
            : '';

        $slug_country_sql = $escapeSql($slug_country);

        $res = $clsCountryEx->getAll(
            "is_trash=0
            AND is_online=1
            AND slug='{$slug_country_sql}'
            LIMIT 0,1",
            $clsCountryEx->pkey
            . ',slug,title,intro,content,intro_hotel,image_hotel'
        );

        if (empty($res) || empty($res[0][$clsCountryEx->pkey])) {
            header('Location: ' . $extLang);
            exit();
        }

        $oneItem = $res[0];
        $country_id = (int)$oneItem[$clsCountryEx->pkey];

        if ($country_id <= 0) {
            header('Location: ' . $extLang);
            exit();
        }

        $place_id = $country_id;
        $clsClassTable = 'Country';

        $assign_list['countryItem'] = $oneItem;
        $assign_list['country_id'] = $country_id;
        $assign_list['oneItem'] = $oneItem;

        $title_page = $clsCountryEx->getTitle($country_id, $oneItem);
        $intro_page = $clsCountryEx->getStripIntro(
            $country_id,
            $oneItem
        );
        $intro_hotel = $clsCountryEx->getIntro(
            $country_id,
            'Hotel',
            false,
            $oneItem
        );
        $content_page = $clsCountryEx->getContent(
            $country_id,
            $oneItem
        );
        $link_page_country = $clsCountryEx->getLink(
            $country_id,
            $oneItem
        );

        $assign_list['title_page'] = $title_page;
        $assign_list['intro_page'] = $intro_page;
        $assign_list['intro_hotel'] = $intro_hotel;
        $assign_list['content_page'] = $content_page;
        $assign_list['link_page_country'] = $link_page_country;
    }

    /* =========================================================
     * Phân trang
     * ========================================================= */
    $recordPerPage = $deviceType === 'computer' ? 10 : 6;

    $currentPage = isset($_GET['page'])
        && !is_array($_GET['page'])
        ? (int)$_GET['page']
        : 1;

    if ($currentPage < 1) {
        $currentPage = 1;
    }

    /* =========================================================
     * Điều kiện cơ bản
     * ========================================================= */
    $cond = 'is_trash=0 AND is_online=1';

    if ($show === 'Country' && $country_id > 0) {
        $cond .= " AND country_id={$country_id}";
    }

    /* =========================================================
     * Chuẩn hóa các filter
     * ========================================================= */
    $hotel_type_ids = $normalizeFilterIds(
        $_GET['hotel_type'] ?? []
    );

    $hotel_star_ids = $normalizeFilterIds(
        $_GET['hotel_star'] ?? []
    );

    $hotel_city_ids = $normalizeFilterIds(
        $_GET['hotel_city'] ?? []
    );

    $hotel_facility_ids = $normalizeFilterIds(
        $_GET['hotel_facilities'] ?? []
    );

    $hotel_min_price = isset($_GET['min_price'])
        && !is_array($_GET['min_price'])
        ? (float)$_GET['min_price']
        : 0;

    $hotel_max_price = isset($_GET['max_price'])
        && !is_array($_GET['max_price'])
        ? (float)$_GET['max_price']
        : 0;

    if ($hotel_min_price < 0) {
        $hotel_min_price = 0;
    }

    if ($hotel_max_price < 0) {
        $hotel_max_price = 0;
    }

    /*
     * Gán lại cho template dạng array để check checkbox.
     */
    $assign_list['hotel_type'] = $hotel_type_ids;
    $assign_list['hotel_star'] = $hotel_star_ids;
    $assign_list['hotel_city'] = $hotel_city_ids;
    $assign_list['hotel_facilities'] = $hotel_facility_ids;
    $assign_list['min_price'] = $hotel_min_price;
    $assign_list['max_price'] = $hotel_max_price;

    /* =========================================================
     * Filter Property Types
     * ========================================================= */
    if (!empty($hotel_type_ids)) {
        $hotel_type_sql = implode(',', $hotel_type_ids);
        $typeConditions = [];

        foreach ($hotel_type_ids as $property_id) {
            $property_id = (int)$property_id;

            /*
             * Hỗ trợ cả dữ liệu lưu:
             * 1
             * |1|
             * |1|2|
             * 1,2
             */
            $typeConditions[] = "
                (
                    list_TypeHotel='{$property_id}'
                    OR list_TypeHotel LIKE '%|{$property_id}|%'
                    OR FIND_IN_SET(
                        '{$property_id}',
                        REPLACE(list_TypeHotel, '|', ',')
                    )
                )
            ";
        }

        if (!empty($typeConditions)) {
            $cond .= ' AND (' . implode(' OR ', $typeConditions) . ')';
        }
    }

    /* =========================================================
     * Filter Your budget per night
     * ========================================================= */
    if ($hotel_min_price > 0 || $hotel_max_price > 0) {
        $roomPriceCondition = '';

        if ($hotel_min_price <= 0 && $hotel_max_price > 0) {
            $roomPriceCondition = 'price <= '
                . (float)$hotel_max_price;
        } elseif (
            $hotel_min_price > 0
            && $hotel_max_price <= 0
        ) {
            $roomPriceCondition = 'price >= '
                . (float)$hotel_min_price;
        } else {
            /*
             * Nếu min lớn hơn max thì đảo lại.
             */
            if ($hotel_min_price > $hotel_max_price) {
                $tmpPrice = $hotel_min_price;
                $hotel_min_price = $hotel_max_price;
                $hotel_max_price = $tmpPrice;
            }

            $roomPriceCondition = 'price BETWEEN '
                . (float)$hotel_min_price
                . ' AND '
                . (float)$hotel_max_price;
        }

        if ($roomPriceCondition !== '') {
            $cond .= "
                AND hotel_id IN (
                    SELECT hotel_id
                    FROM default_hotel_room
                    WHERE is_trash=0
                    AND {$roomPriceCondition}
                )
            ";
        }
    }

    /* =========================================================
     * Filter Hotel Star Level
     * ========================================================= */
    if (!empty($hotel_star_ids)) {
        $hotel_star_sql = implode(',', $hotel_star_ids);
        $cond .= " AND star_id IN ({$hotel_star_sql})";
    }

    /* =========================================================
     * Filter Location
     * ========================================================= */
    if (!empty($hotel_city_ids)) {
        $hotel_city_sql = implode(',', $hotel_city_ids);
        $cond .= " AND city_id IN ({$hotel_city_sql})";
    }

    /* =========================================================
     * Filter Property Facilities
     * ========================================================= */
    if (!empty($hotel_facility_ids)) {
        $facilityConditions = [];

        foreach ($hotel_facility_ids as $facility_id) {
            $facility_id = (int)$facility_id;

            $facilityConditions[] = "
                (
                    list_HotelFacilities='{$facility_id}'
                    OR list_HotelFacilities LIKE '%|{$facility_id}|%'
                    OR FIND_IN_SET(
                        '{$facility_id}',
                        REPLACE(list_HotelFacilities, '|', ',')
                    )
                )
            ";
        }

        if (!empty($facilityConditions)) {
            $cond .= ' AND ('
                . implode(' OR ', $facilityConditions)
                . ')';
        }
    }

    /* =========================================================
     * Filter từ khóa
     * ========================================================= */
    if ($key_search !== '') {
        $keyword_sql = $escapeSql($key_search);
        $keyword_slug = $escapeSql(
            $core->replaceSpace($key_search)
        );

        $cond .= "
            AND (
                title LIKE '%{$keyword_sql}%'
                OR slug LIKE '%{$keyword_slug}%'
            )
        ";
    }

    /* =========================================================
     * Sắp xếp
     * ========================================================= */
    $hotel_sort = isset($_GET['hotel_sort'])
        && !is_array($_GET['hotel_sort'])
        ? (int)$_GET['hotel_sort']
        : 0;

    $assign_list['hotel_sort'] = $hotel_sort;

    switch ($hotel_sort) {
        case 1:
            $order_by = "
                ORDER BY (
                    SELECT MIN(default_hotel_room.price)
                    FROM default_hotel_room
                    WHERE default_hotel_room.is_trash=0
                    AND default_hotel_room.hotel_id=
                        default_hotel.hotel_id
                ) ASC
            ";
            break;

        case 2:
            $order_by = "
                ORDER BY (
                    SELECT MIN(default_hotel_room.price)
                    FROM default_hotel_room
                    WHERE default_hotel_room.is_trash=0
                    AND default_hotel_room.hotel_id=
                        default_hotel.hotel_id
                ) DESC
            ";
            break;

        case 3:
            $order_by = "
                ORDER BY (
                    SELECT AVG(default_reviews.rates)
                    FROM default_reviews
                    WHERE default_reviews.is_trash=0
                    AND default_reviews.is_online=1
                    AND default_reviews.type='hotel'
                    AND default_reviews.table_id=
                        default_hotel.hotel_id
                ) DESC
            ";
            break;

        case 4:
            $order_by = "
                ORDER BY (
                    SELECT AVG(default_reviews.rates)
                    FROM default_reviews
                    WHERE default_reviews.is_trash=0
                    AND default_reviews.is_online=1
                    AND default_reviews.type='hotel'
                    AND default_reviews.table_id=
                        default_hotel.hotel_id
                ) ASC
            ";
            break;

        default:
            $order_by = ' ORDER BY order_no ASC';
            break;
    }

    /* =========================================================
     * Đếm tổng số bản ghi
     * ========================================================= */
    $totalItem = $clsHotel->getAll(
        $cond,
        $clsHotel->pkey
    );

    $totalRecord = is_array($totalItem)
        ? count($totalItem)
        : 0;

    $assign_list['totalRecord'] = $totalRecord;

    /* =========================================================
     * Tạo link phân trang
     * ========================================================= */
    $requestPath = parse_url(
        $_SERVER['REQUEST_URI'] ?? '',
        PHP_URL_PATH
    );

    if (!$requestPath) {
        $requestPath = $extLang
            . $clsISO->getLink('hotel');
    }

    $queryParams = $_GET;

    /*
     * page phải được Pagination tự thêm,
     * không giữ page hiện tại trong link gốc.
     */
    unset($queryParams['page']);

    $queryString = http_build_query($queryParams);

    $link_page = $requestPath;

    if ($queryString !== '') {
        $link_page .= '?' . $queryString;
    }

    $config = [
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page' => $link_page
    ];

    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links();

    /* =========================================================
     * Lấy danh sách khách sạn
     * ========================================================= */
    $offset = ($currentPage - 1) * $recordPerPage;

    if ($offset < 0) {
        $offset = 0;
    }

    $limit = " LIMIT {$offset},{$recordPerPage}";

    $listHotelPlace = $clsHotel->getAll(
        $cond . $order_by . $limit,
        $clsHotel->pkey
        . ',star_id,slug,title,address,intro,image'
    );

    if (!is_array($listHotelPlace)) {
        $listHotelPlace = [];
    }

    $assign_list['listHotelPlace'] = $listHotelPlace;
    $assign_list['page_view'] = $page_view;

    $totalPage = $clsPagination->getTotalPage();
    $assign_list['totalPage'] = $totalPage;

    /* =========================================================
     * Danh sách khách sạn đã xem
     * ========================================================= */
    $arr_recent_hotel = $clsISO->getRecentView('hotel', 10);

    if (!is_array($arr_recent_hotel)) {
        $arr_recent_hotel = [];
    }

    $assign_list['arr_recent_hotel'] = $arr_recent_hotel;

    /* =========================================================
     * Link xóa toàn bộ filter
     * ========================================================= */
    $baseUrl = strtok(
        $_SERVER['REQUEST_URI'] ?? '',
        '?'
    );

    $assign_list['reset_filter'] = $baseUrl;

    /* =========================================================
     * SEO Title, Description, Keyword
     * ========================================================= */
    if ($show === '') {
        $title_page = $core->get_Lang('Hotel')
            . ' | '
            . PAGE_NAME;

        $description_page = $title_page;
        $keyword_page = $title_page;
    } else {
        $countryTitle = isset($title_page)
            ? $title_page
            : '';

        $title_page = $core->get_Lang('Hotels in')
            . ' '
            . $countryTitle
            . ' | '
            . PAGE_NAME;

        if (
            $place_id > 0
            && $clsClassTable !== ''
            && !empty($oneItem)
        ) {
            $description_page = $clsISO->getMetaDescription(
                $place_id,
                $clsClassTable,
                $oneItem
            );
        } else {
            $description_page = $title_page;
        }

        $keyword_page = $title_page;
    }

    $assign_list['title_page'] = $title_page;
    $assign_list['description_page'] = $description_page;
    $assign_list['keyword_page'] = $keyword_page;
}

function default_detail2024()
{
    //     ini_set('display_errors', 1);
    //     ini_set('display_startup_errors', '1');
    //     error_reporting(E_ALL & ~E_STRICT);
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $country_id, $curl;
    global $country_id, $clsISO, $package_id, $hotel_id, $extLang;
    #
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;

    #Danh sách file css xử dụng cho trang home
    Asset::css([
        "{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.css?v={$v_cache}",
        "{$URL_JS}/fotorama-4.6.4/fotorama.css?v={$v_cache}",
        "{$URL_JS}/swiper-11.1.15/swiper-bundle.min.css?v={$v_cache}",
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$upd_version}",
        "{$URL_JS}/reviewstar/style.css?v={$upd_version}",
        "{$URL_CSS}/2024_hotel_detail.css?v={$upd_version}"
    ]);

    Asset::js([
        "{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.js?v={$v_cache}",
        "{$URL_JS}/fotorama-4.6.4/fotorama.js?v={$v_cache}",
        "{$URL_JS}/swiper-11.1.15/swiper-bundle.min.js?v={$v_cache}",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}",
        "{$URL_JS}/jquery.sharer.js?v={$upd_version}",
        "{$URL_JS}/jquery.form.js?ver={$upd_version}",
        "{$URL_JS}/reviewstar/starwarsjs.js?v={$upd_version}",
        "{$URL_JS}/review/review.js?v={$upd_version}",
        "{$URL_JS}/jquery.countdown.min.js?v={$upd_version}",
        "{$URL_JS}/jquery-confirm.min.js?v={$upd_version}",
        "{$URL_JS}/hotel/iso_hotel_detail.js?v={$upd_version}"
    ]);
    #
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsCountry = new _Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourDestination = new TourDestination();
    $assign_list["clsTourDestination"] = $clsTourDestination;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsHotelProperty = new HotelProperty();
    $assign_list['clsHotelProperty'] = $clsHotelProperty;
    $clsProperty = new Property();
    $assign_list['clsProperty'] = $clsProperty;
    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;
    $clsHotelRoomImage = new HotelRoomImage();
    $assign_list['clsHotelRoomImage'] = $clsHotelRoomImage;
    #
    $clsHotelAttraction = new HotelAttraction();
    $assign_list['$clsHotelAttraction'] = $clsHotelAttraction;
    $clsAttraction = new Attraction();
    $assign_list['clsAttraction'] = $clsAttraction;
    $clsHotelImage = new HotelImage();
    $assign_list['clsHotelImage'] = $clsHotelImage;

    $clsHotelPriceCol = new HotelPriceCol();
    $assign_list['clsHotelPriceCol'] = $clsHotelPriceCol;
    $clsHotelPriceVal = new HotelPriceVal();
    $assign_list['clsHotelPriceVal'] = $clsHotelPriceVal;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    #
    //    $linkBack = vnSessionGetVar('linkBack');
    //    $assign_list['linkBack'] = $linkBack;
    $hotel_id = isset($_GET['hotel_id']) ? $_GET['hotel_id'] : 0;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    #
    if (empty($clsHotel->checkOnlineBySlug($hotel_id, $slug))) {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    }
    $assign_list['hotel_id'] = $hotel_id;
    $assign_list["table_id"] = $hotel_id;
    #
    $oneItem = $clsHotel->getOne($hotel_id);
    $assign_list['oneItem'] = $oneItem;
    #
    if ($oneItem['is_online'] == 0) {
        header('location:' . PCMS_URL . $extLang);
    }
    $hotel_city = $clsCity->getTitle($oneItem['city_id']);
    $assign_list["hotel_city"] = $hotel_city;
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_gallery', 'customize')) {
        #-- Hotel Images
        $listImage = $clsHotelImage->getAll("is_trash=0 and table_id='$hotel_id' and image <> '' order by order_no ASC", $clsHotelImage->pkey . ',image,title');
        $assign_list['listImage'] = $listImage;
        unset($listImage);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_room', 'customize')) {
        #-- Hotel Rooms
        $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no ASC");

        foreach ($lstHotelRoom as $index => $row) {
            $arr_room_image = $clsHotelRoomImage->getImageOriginal($row['hotel_room_id']);
            $lstHotelRoom[$index]['room_image'] = $arr_room_image;
        }

        $assign_list['lstHotelRoom'] = $lstHotelRoom;
        unset($lstHotelRoom);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'property', 'default', 'HotelFacilities')) {
        #list all Room and hotel Facilities
        $list_HotelFacilities = $oneItem['list_HotelFacilities'];
        $lstHotelFacility = array();
        if ($list_HotelFacilities != '' && $list_HotelFacilities != '0') {
            $list_HotelFacilities = str_replace('||', '|', $list_HotelFacilities);
            $list_HotelFacilities = ltrim($list_HotelFacilities, '|');
            $list_HotelFacilities = rtrim($list_HotelFacilities, '|');
            $TMP = explode('|', $list_HotelFacilities);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstHotelFacility)) {
                    $lstHotelFacility[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstHotelFacility'] = $lstHotelFacility;
        unset($lstHotelFacility);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_related', 'customize')) {
        #-- Hotel Related
        $lstHotelRelated = $clsHotel->getAll("is_trash=0 and is_online=1 and hotel_id <> '$hotel_id' and city_id ='" . $oneItem['city_id'] . "' order by order_no desc limit 0,10", $clsHotel->pkey . ',star_id,slug,title,image,intro,address');
        $assign_list['lstHotelRelated'] = $lstHotelRelated;
        unset($lstHotelRelated);
    }
    if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_custom_field', 'customize')) {
        #- Custom Field
        $clsHotelCustomField = new HotelCustomField();
        $assign_list["clsHotelCustomField"] = $clsHotelCustomField;

        $listCustomField = $clsHotelCustomField->getAll("hotel_id='$hotel_id' and fieldtype='CUSTOM' order by order_no ASC", $clsHotelCustomField->pkey . ',fieldvalue,fieldname');
        $assign_list["listCustomField"] = $listCustomField;
        unset($listCustomField);
    }
    #
    $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and price >0 order by price ASC", $clsHotelRoom->pkey . ",price,number_adult");
    $min_price = $lstHotelRoom[0]['price'];
    if ($min_price) {
        $number_adult = $lstHotelRoom[0]['number_adult'] ? $lstHotelRoom[0]['number_adult'] : 2;
    }
    $assign_list["min_price"] = $min_price;
    $assign_list["number_adult"] = $number_adult;
    #-- Review
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsReviewsHotel = new ReviewsHotel();
    $assign_list['clsReviewsHotel'] = $clsReviewsHotel;
    $lstReviewHotel = $clsReviewsHotel->getAll(" hotel_id = '" . $hotel_id . "' limit 0,1", $clsReviewsHotel->pkey . ',staff,amenities,clean,place,food_drink,worthy');
    $assign_list['lstReviewHotel'] = $lstReviewHotel[0];
    #
    $lstReview = $clsReviews->getAll("is_trash=0 and is_online=1 and type='hotel' and table_id = '" . $hotel_id . "' order by order_no asc", $clsReviews->pkey . ',review_date,fullname,content,title,rates,reg_date,country_id');
    $jsonReview = array();
    if (!empty($lstReview)) {
        foreach ($lstReview as $k => $v) {
            $jsonReview[] = array(
                "@type" => "Review",
                "author" => $v["fullname"],
                "datePublished" => $clsISO->converTimeToText($v['review_date']),
                "description" => addslashes($v["content"]),
                "name" => $v["title"],
                "reviewRating" => array(
                    "@type" => "Rating",
                    "bestRating" => "5",
                    "ratingValue" => $v["rates"],
                    "worstRating" => "1",
                ),
            );
        }
    }
    $assign_list["jsonReview"] = json_encode($jsonReview);
    unset($jsonReview);
    $assign_list["lstReview"] = $lstReview;
    unset($lstReview);
    $assign_list['btn_view_more'] = '<a data-bs-toggle="modal" data-bs-target="#mdReview" class="read_more read_more_review">' . $core->get_Lang('Read more') . '</a>';
    #
    if (isset($_POST['ContactHotel']) && $_POST['ContactHotel'] == 'ContactHotel') {
        vnSessionDelVar('ContactCruise');
        vnSessionDelVar('ContactTour');
        vnSessionDelVar('ContactHotel');
        vnSessionDelVar('ContactVoucher');
        $cartSessionHotel = vnSessionGetVar('ContactHotel');
        if (empty($cartSessionHotel)) {
            $cartSessionHotel = array();
        }
        $assign_list["cartSessionHotel"] = $cartSessionHotel;
        #
        $link = $clsHotel->getLinkContact();
        $cartSessionHotel['HOTEL'][$hotel_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionHotel['HOTEL'][$hotel_id][$k] = $v;
        }
        $hotels = vnSessionGetVar('hotels');
        $check_in_date = str_replace('/', '-', $hotels['check_in_date']);
        $check_in_date = strtotime($check_in_date);
        $check_out_date = str_replace('/', '-', $hotels['check_out_date']);
        $check_out_date = strtotime($check_out_date);
        foreach ($hotels as $k => $v) {
            $cartSessionHotel['HOTEL'][$hotel_id]['check_in_date'] = $check_in_date;
            $cartSessionHotel['HOTEL'][$hotel_id]['check_out_date'] = $check_out_date;
            $cartSessionHotel['HOTEL'][$hotel_id]['number_adults'] = $hotels['number_adults'];
            $cartSessionHotel['HOTEL'][$hotel_id]['number_child'] = $hotels['number_child'];
            $cartSessionHotel['HOTEL'][$hotel_id]['number_night'] = $hotels['number_night'];
        }
        vnSessionSetVar('ContactHotel', $cartSessionHotel);
        header('location:' . $link);
        exit();
    }
    #-- Link hotel cùng city
    $arr_link_by_city = [
        'country_id' => $oneItem['country_id'],
        'city_id' => $oneItem['city_id'],
    ];
    $link_by_city = $clsHotel->getLinkByCity($arr_link_by_city);
    $assign_list['link_by_city'] = $link_by_city;

    #-- Facilities Favorite
    $arr_hotel_facilities_favorite = $clsProperty->getAll("is_trash=0 AND is_favorite=1 AND type='HotelFacilities' ORDER BY order_no ASC", $clsProperty->pkey);
    $assign_list['arr_hotel_facilities_favorite'] = $arr_hotel_facilities_favorite;

    #-- Facilities Favorite của từng Hotel
    $listProterty_id = $clsHotel->getOne($hotel_id, 'list_HotelFacilities')[0];
    $string = trim($listProterty_id, '|');
    $array = explode('|', $string);
    $result = implode(',', $array);
    $listHotelFacilitiesFavorite = $clsProperty->getAll("is_trash=0 and type='HotelFacilities' and is_favorite=1 and property_id IN ($result) order by order_no ASC");
    $assign_list["listHotelFacilitiesFavorite"] = $listHotelFacilitiesFavorite;


    #-- List tour theo city của hotel\
    //$arr_tour_by_city = $clsTourDestination->getAll("is_trash=0 AND is_online=1 AND city_id=" . $oneItem['city_id'] . " ORDER BY order_no ASC LIMIT 0,10", "$clsTour->pkey, city_id");

    #-- Check điều kiện city_id khác 0
    $arr_tour_by_city = $clsTourDestination->getAll("is_trash=0 AND is_online=1 AND city_id <> 0 AND city_id=" . $oneItem['city_id'] . " ORDER BY order_no ASC LIMIT 0,10", "$clsTour->pkey, city_id");

    $assign_list["arr_tour_by_city"] = $arr_tour_by_city;
    #-- List country hiển thị cờ
    $arr_country = $clsCountry->getAll("is_trash=0 AND is_lock=0");
    $assign_list["arr_country"] = $arr_country;
    #-- Setcookie cho hotel
    $clsISO->setRecentView('hotel', $hotel_id);
    #-- List hotel đã xem
    $arr_recent_hotel = $clsISO->getRecentView('hotel', 10);
    $assign_list['arr_recent_hotel'] = $arr_recent_hotel;
    #-- Hotel tags
    $arr_hotel_tags_id = $clsProperty->getArray($oneItem['tags_hotel']);
    $assign_list['arr_hotel_tags_id'] = $arr_hotel_tags_id;
    #-- Hotel Facilities
    $arr_hotel_category = $clsHotelProperty->getAll("is_trash=0 AND is_online=1 AND type='HotelCategory' ORDER BY order_no ASC", "$clsHotelProperty->pkey, title");
    $assign_list['arr_hotel_category'] = $arr_hotel_category;
    // $arr_hotel_facilities = $clsProperty->getArray($oneItem['list_HotelAccommodation']);
    // $clsISO::dump($arr_hotel_category);
    #
    $iso_search_hotel_dates = vnSessionGetVar("iso_search_hotel_dates");
    if (!empty($iso_search_hotel_dates)) {
        $array_date = explode(" - ", $iso_search_hotel_dates);
        $iso_check_in = $array_date['0'];
        $iso_check_out = $array_date['1'];
    } else {
        $iso_check_in = date('d/m/Y');
        $iso_check_out = date('d/m/Y', strtotime('+1 day'));
    }
    #
    $iso_number_rooms = vnSessionGetVar("iso_search_hotel_number_rooms");
    $iso_number_adults = vnSessionGetVar("iso_search_hotel_number_adults");
    $iso_number_child = vnSessionGetVar("iso_search_hotel_number_child");
    $assign_list["iso_number_rooms"] = !empty($iso_number_rooms) ? $iso_number_rooms : 1;
    $assign_list["iso_number_adults"] = !empty($iso_number_adults) ? $iso_number_adults : 1;
    $assign_list["iso_number_child"] = !empty($iso_number_child) ? $iso_number_child : 0;
    $assign_list["iso_check_in"] = $iso_check_in;
    $assign_list["iso_check_out"] = $iso_check_out;
    /*=============Title & Description Page==================*/
    $title_page = $clsHotel->getTitle($hotel_id, $oneItem) . ' | ' . $core->get_Lang('hotels') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $description_page = $clsISO->getMetaDescription($hotel_id, 'Hotel', $oneItem);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($hotel_id, 'Hotel', $oneItem);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    #
    //    vnSessionDelVar('linkBack');
    //    vnSessionSetVar('linkBack', $_SERVER['REQUEST_URI']);
}

function default_book()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
    global $_lang, $extLang, $_LANG_ID, $profile_id, $loggedIn;


    #
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;
    $clsCountryLt = new _Country();
    $assign_list['clsCountryLt'] = $clsCountryLt;
    $assign_list['lstCountry'] = $clsCountryLt->getAll("1=1 order by order_no asc");
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;

    #Get By Slug
    $slug = $_GET['slug'];
    $hotel_id = $clsHotel->getBySlug($slug);
    if ($hotel_id == '') {
        header('location:' . PCMS_URL);
    }
    $assign_list['hotel_id'] = $hotel_id;
    #
    $hotel_room_id = isset($_COOKIE['Session_HotelRoomID']) ? intval($_COOKIE['Session_HotelRoomID']) : 0;
    $assign_list['hotel_room'] = $hotel_room_id;

    $allHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id = '$hotel_id' order by order_no ASC", $clsHotelRoom->pkey);
    $assign_list['allHotelRoom'] = $allHotelRoom;
    $departure_date = isset($_POST['checkin']) ? $_POST['checkin'] : '';
    $departure_date = strtotime($departure_date);
    #
    if (!empty($profile_id)) {
        $clsProfile = new Profile();
        $assign_list['clsProfile'] = $clsProfile;
        $name = $clsProfile->getFullname($profile_id);
        $assign_list['name'] = $name;
        $email = $clsProfile->getEmail($profile_id);
        $assign_list['email'] = $email;
        $phone = $clsProfile->getPhone($profile_id);
        $assign_list['phone'] = $phone;
        $country_id = $clsProfile->getOneField('country_id', $profile_id);
        $assign_list['country_id'] = $country_id;
    }
    $err_msg = '';
    if (isset($_POST['book']) && $_POST['book'] == 'book') {
        $name = $_POST['name'];
        if ($name == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your fullname') . ' <br />';
        }
        $email = $_POST['email'];
        if ($email == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your email') . ' <br />';
        }
        $phone = $_POST['phone'];
        if ($phone == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your phone') . ' <br />';
        }
        $country_id = $_POST['country_id'];
        if ($country_id == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please select your country') . ' <br />';
        }
        $request = $_POST['request'];
        if ($request == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter request') . ' <br />';
        }
        $checkin = $_POST['checkin'];
        if ($checkin == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please select check in date') . ' <br />';
        }
        $checkout = $_POST['checkout'];
        if ($checkout == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please select check out date') . ' <br />';
        }
        #- Verify Captcha
        if (_ISOCMS_CAPTCHA == 'IMG') {
            $security_code = isset($_POST["security_code"]) ? trim($_POST["security_code"]) : '';
            $security_code = strtoupper($security_code);
            if (!empty($security_code) && $security_code != $_SESSION['skey']) {
                $err_msg .= '&bull; ' . $core->get_Lang('Secure code not match') . ' <br />';
            }
        } else if (_ISOCMS_CAPTCHA == 'reCAPTCHA') {
            if (!$clsISO->checkGoogleReCAPTCHA()) {
                $err_msg .= '&bull; ' . $core->get_Lang('Secure code not match') . ' <br />';
            }
        }
        #
        if ($err_msg == '') {
            $clsBooking = new Booking();
            $booking_id = $clsBooking->getMaxId();
            $booking_code = $clsBooking->generateBookingCode($booking_id);
            #
            $f = "booking_id,target_id,full_name,email,phone,country_id,clsTable,booking_code,booking_store,booking_type,reg_date,departure_date,ip_booking";
            $v = "'$booking_id'
				,'$hotel_id'
				,'$name'
				,'$email'
				,'$phone'
				,'$country_id'
				,'Hotel'
				,'$booking_code'
				,'" . serialize($_POST) . "'
				,'Hotel'
				,'" . $departure_date . "'
				,'" . time() . "'
				,'" . $_SERVER['REMOTE_ADDR'] . "'";
            #
            if (_ISOCMS_CLIENT_LOGIN) {
                $f .= ",member_id";
                $v .= ",'$profile_id'";
            }
            //print_r($f.'<br />'.$v); die();
            if ($clsBooking->insertOne($f, $v)) {
                $clsBooking->sendEmailBookingHotel($booking_id, 0);
                header('location: ' . $extLang . '/booking/hotel/successful');
            } else {
                header('location: ' . $extLang . '/booking/hotel/error');
            }
            unset($clsBooking);
        } else {
            $assign_list["err_msg"] = $err_msg;
            foreach ($_POST as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Booking Hotels') . ' | ' . $clsHotel->getTitle($hotel_id) . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
    unset($clsHotel);
    unset($clsHotelRoom);
    unset($clsBookingHotel);
    unset($clsCountry);
    unset($clsImage);
    unset($clsISO);
}

function default_loadCity()
{
    global $core, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    #
    $clsCity = new City();
    $country_id = $_POST['country_id'];
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
    $Html = '<option value="0"> -- ' . $core->get_Lang('selectdestination') . ' -- </option>';
    $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no asc", $clsCity->pkey);
    if (is_array($lstCity) && count($lstCity) > 0) {
        foreach ($lstCity as $k => $v) {
            $selected = $city_id == $v[$clsCity->pkey] ? 'selected="selected"' : '';
            if ($clsCity->countHotel($country_id, $v[$clsCity->pkey])) {
                $Html .= '<option value="' . $v[$clsCity->pkey] . '" ' . $selected . '>-- ' . $clsCity->getTitle($v[$clsCity->pkey]) . ' --</option>';
            }
        }
    }
    echo $Html;
    die();
}

function default_ajLoadBedType()
{
    global $core, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    #
    $clsHotelPriceCol = new HotelPriceCol();
    $clsHotelPriceVal = new HotelPriceVal();
    $hotel_id = $_POST['hotel_id'];
    $hotel_room_id = $_POST['hotel_room_id'];

    $html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';
    $lst = $clsHotelPriceCol->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no asc");
    if (!empty($lst)) {
        $i = 0;
        foreach ($lst as $item) {
            $selected = $city_id == $item[$clsHotelPriceCol->pkey] ? 'selected="selected"' : '';
            $html .= '<option value="' . $item[$clsHotelPriceCol->pkey] . '" ' . $selected . '>
				-- ' . $clsHotelPriceCol->getTitle($item[$clsHotelPriceCol->pkey]) . ' (' . $clsHotelPriceVal->getPrice($hotel_room_id, $item[$clsHotelPriceCol->pkey]) . ')
			</option>';
            ++$i;
        }
    }
    echo $html;
    die();
}

function default_ajSetBookHotelRoom()
{
    global $core, $dbconn, $clsISO;
    #
    $hotel_id = isset($_POST['hotel_id']) ? intval($_POST['hotel_id']) : 0;
    $hotel_room_id = isset($_POST['hotel_room_id']) ? intval($_POST['hotel_room_id']) : 0;
    #
    if (!empty($hotel_room_id) && !empty($hotel_id)) {
        setcookie('Session_HotelRoomID', $hotel_room_id, time() + (86400 * 30), "/");
        setcookie('Session_HotelID', $hotel_id, time() + (86400 * 30), "/");
    } else {
        $hotel_room_id = isset($_COOKIE['Session_HotelRoomID']) ? intval($_COOKIE['Session_HotelRoomID']) : '0';
        $hotel_id = isset($_COOKIE['Session_HotelID']) ? intval($_COOKIE['Session_HotelID']) : '0';
        setcookie('Session_HotelRoomID', $hotel_room_id, time() + (86400 * 30), "/");
        setcookie('Session_HotelID', $hotel_id, time() + (86400 * 30), "/");
    }
    echo ($hotel_id);
    die();
}

function default_ajMakeSelectHotelRoom()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    #
    $clsHotelRoom = new HotelRoom();
    $clsISO = new ISO();

    #
    $hotel_room_id = isset($_POST['hotel_room_id']) ? intval($_POST['hotel_room_id']) : 0;
    $number_room = isset($_POST['number_room']) ? intval($_POST['number_room']) : 0;
    #
    $html = '';
    if (intval($hotel_room_id) > 0) {
        $number_room_hotel = $clsHotelRoom->getOneField('number_room', $hotel_room_id);
        $html .= $clsISO->getSelect(1, $number_room_hotel, $number_room);
    } else {
        $html .= $clsISO->getSelect(1, 10, $number_room);
    }
    echo $html;
    die();
}

function default_loadRoomHotel()
{
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
    global $core, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsISO;
    #
    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;
    $clsHotelRoomImage = new HotelRoomImage();
    $assign_list['clsHotelRoomImage'] = $clsHotelRoomImage;
    $clsProperty = new Property();
    $assign_list['clsProperty'] = $clsProperty;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    #
    $hotel_id = isset($_POST['hotel_id']) ? intval($_POST['hotel_id']) : 0;
    $number_adults = isset($_POST['number_adults']) ? intval($_POST['number_adults']) : 1;
    $number_rooms = isset($_POST['number_rooms']) ? intval($_POST['number_rooms']) : 1;
    $number_child = isset($_POST['number_child']) ? intval($_POST['number_child']) : 0;
    $check_in = isset($_POST['check_in']) ? $_POST['check_in'] : date('d-m-Y');
    $check_out = isset($_POST['checkout']) ? $_POST['checkout'] : date('d-m-Y', strtotime('+1 day'));
    #
    $str_check_in = $check_in ? strtotime($check_in) : '';
    $str_check_out = $check_out ? strtotime($check_out) : '';
    $string_number_night = $str_check_out - $str_check_in;
    $number_night = $string_number_night / 86400;
    if ($number_night == 0) {
        $number_night = 1;
    }
    $count_people = (int)$number_adults + (int)$number_child;
    #-- Hotel Rooms
    $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by price ASC, order_no DESC");
    foreach ($lstHotelRoom as $index => $row) {
        $count_people_room = (int)$row['number_adult'] + (int)$row['number_children'];
        //Tinh so luong phong cho $count_people nguoi  
        $ceil_number_rooms = ceil($count_people / $count_people_room);
        $key_number_room = $number_rooms;
        if ($ceil_number_rooms > $number_rooms) {
            $key_number_room = $ceil_number_rooms;
        }

        $lstHotelRoom[$index]['number_rooms'] = $key_number_room;
        $lstHotelRoom[$index]['count_people_room'] = $count_people_room;
        #
        $totalPrice = $number_rooms * $number_night * intval($row['price']);
        $lstHotelRoom[$index]['totalPrice'] = $totalPrice;
        $arr_room_image = $clsHotelRoomImage->getImageOriginal($row['hotel_room_id']);
        $lstHotelRoom[$index]['room_image'] = $arr_room_image;
    }
    $assign_list['hotel_id'] = $hotel_id;
    $assign_list['number_adults'] = $number_adults;
    $assign_list['number_child'] = $number_child;
    $assign_list['number_night'] = $number_night;
    $assign_list['check_in'] = $check_in;
    $assign_list['check_out'] = $check_out;
    $assign_list['lstHotelRoom'] = $lstHotelRoom;
    $assign_list['number_rooms'] = $number_rooms;
    #
    $html = $core->build('loadRoomHotel.tpl');
    echo $html;
    die;
}

function default_BookingHotel()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO, $now_day, $_LANG_ID, $package_id;
    #
    $clsHotel = new Hotel();
    $clsHotelRoom = new HotelRoom();
    # $hotel_id = Input::post('hotel_id', 0);
    $hotel_room_id = Input::post('hotel_room_id', 0);
    $hotel_id = Input::post('hotel_id', 0);
    $type = Input::post('type', '');
    $number_adult = Input::post('number_adult', 0);
    $number_child = Input::post('number_child', 0);
    $number_room = Input::post('number_rooms', 0);
    $number_night = Input::post('number_night', 1);
    $room_price = Input::post('room_price', 0);
    $totalprice = Input::post('totalprice', 0);
    $max_adult = Input::post('max_adult', 0);
    $check_in = Input::post('check_in', 0);
    $check_out = Input::post('check_out', 0);
    $str_check_in = $check_in ? strtotime($check_in) : '';
    $str_check_out = $check_out ? strtotime($check_out) : '';
    #
    $discount = $clsISO->getPromotion($hotel_id, 'Hotel', $now_day, $str_check_in, 'info_promotion');
    $promotion = $discount['discount_value'];
    $promotion = str_replace('.', '', $promotion);
    $discount_type = $discount['discount_type'];

    //Tinh tien dat coc

    $payment_down = $clsHotelRoom->getPaymentDown($hotel_room_id);

    $payment_down_money = $totalprice * $payment_down / 100;

    $SessionChooseRoom = vnSessionGetVar('SessionChooseRoom');

    if (empty($SessionChooseRoom)) {
        $SessionChooseRoom = array();
    }
    if (!empty($hotel_room_id)) {
        if (!empty($number_room)) {
            $SessionChooseRoom[$hotel_id]['BookingHotel'] = 'BookingHotel';
            $SessionChooseRoom[$hotel_id]['hotel_id'] = $hotel_id;
            $SessionChooseRoom[$hotel_id]['check_in'] = $str_check_in;
            $SessionChooseRoom[$hotel_id]['check_out'] = $str_check_out;
            $SessionChooseRoom[$hotel_id]['number_adult'] = $number_adult;
            $SessionChooseRoom[$hotel_id]['number_child'] = $number_child;
            $SessionChooseRoom[$hotel_id]['number_night'] = $number_night;
            $SessionChooseRoom[$hotel_id]['promotion'] = $promotion;
            $SessionChooseRoom[$hotel_id]['discount_type'] = $discount_type;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['hotel_id'] = $hotel_id;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['hotel_room_id'] = $hotel_room_id;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['number_room'] = $number_room;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['max_adult'] = $max_adult;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['payment_down'] = $payment_down;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['room_price'] = $room_price;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['totalprice'] = $totalprice;
            $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['payment_down_money'] = $payment_down_money;
        } else {
            unset($SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]);
        }
    }
    vnSessionSetVar('SessionChooseRoom', $SessionChooseRoom);

    if ($clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_hotel', 'default')) {
        $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
        if (empty($cartSessionHotel)) {
            $cartSessionHotel = array();
        }
        $SessionChooseRoom = vnSessionGetVar('SessionChooseRoom');

        $cartSessionHotel[$_LANG_ID][$hotel_id] = array();
        $cartSessionHotel[$_LANG_ID][$hotel_id] = $SessionChooseRoom[$hotel_id];

        vnSessionSetVar('BookingHotel_' . $_LANG_ID, $cartSessionHotel);
        $link = $clsISO->getLink('cart');
    } else {

        vnSessionDelVar('ContactTour');
        vnSessionDelVar('ContactCruise');
        vnSessionDelVar('ContactHotel');

        $SessionChooseRoom = vnSessionGetVar('SessionChooseRoom');
        vnSessionSetVar('ContactHotel', $SessionChooseRoom[$hotel_id]);
        $link = $clsISO->getLink('contact');
    }

    echo $link;
    die;
}
