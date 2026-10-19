<?php
function default_default()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
    #
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;

    $clsPagination = new Pagination();
    $country_id = $clsCountryEx->getBySlug($slug_country);
    if (intval($country_id) == 0) {
        header('location:' . PCMS_URL . $extLang);
        exit();
    }
    $assign_list['country_id'] = $country_id;
    #
    $recordPerPage = 12;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $cond = "is_trash=0 and is_online=1";
    $order_by = " ORDER BY order_no DESC";

    $totalRecord = $clsHotel->getAll($cond) ? count($clsHotel->getAll($cond)) : 0;

    #
    $link_page = $clsCountryEx->getLink($country_id, 'Hotel');
    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page_1' => $link_page
    );

    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);

    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    $listHotel = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ',star_id');
    $assign_list['listHotel'] = $listHotel;
    unset($listHotel);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();

    $assign_list['page_view'] = $page_view;
    unset($page_view);

    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('hotelsresorts') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_place()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $country_id, $city_id;
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

    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    if ($clsISO->getCheckActiveModulePackage($package_id, 'guide', 'cat', 'default')) {
        $listGuideCat = $clsGuideCat->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsGuideCat->pkey);
        $assign_list['listGuideCat'] = $listGuideCat;
        unset($listGuideCat);
    }


    if ($show == 'Country') {
        $slug_country = isset($_GET['slug_country']) ? $_GET['slug_country'] : '';
        $res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1", $clsCountryEx->pkey);
        $country_id = $res[0][$clsCountryEx->pkey];
        if (intval($country_id) == 0) {
            header('Location:' . PCMS_URL . $extLang);
            exit();
        }
        $assign_list['country_id'] = $country_id;
        $place_id = $country_id;
        $clsClassTable = 'Country';
        #
        $title_page = $clsCountryEx->getTitle($country_id);
        $intro_page = $clsCountryEx->getStripIntro($country_id);
        $intro_hotel = $clsCountryEx->getIntro($country_id, 'Hotel');
        $content_page = $clsCountryEx->getContent($country_id);
        $link_page = $clsCountryEx->getLink($country_id);
        $oneItem = $clsCountryEx->getOne($country_id);

        $clsCityStore = new CityStore();
        $assign_list['clsCityStore'] = $clsCityStore;
        $listTopCity = $clsCityStore->getAll("country_id='$country_id' and type='TOP' order by order_no ASC");
        $assign_list['listTopCity'] = $listTopCity;
        unset($listTopCity);
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

        $title_page = $clsCity->getTitle($city_id);
        $intro_page = $clsCity->getIntro($city_id);
        $intro_hotel = $clsCity->getIntro($city_id, 'Hotel');
        $content_page = $clsCity->getContent($city_id);
        $link_page = $clsCity->getLink($city_id);
        $oneItem = $clsCity->getOne($city_id);
        $country_id = $oneItem['country_id'];
        $assign_list['country_id'] = $country_id;
    }
    if ($show == 'Region') {
        $slug_country = isset($_GET['slug_country']) ? $_GET['slug_country'] : '';
        $res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1");
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
        $title_page = $clsRegion->getTitle($region_id);
        $intro_page = $clsRegion->getIntro($region_id);
        $intro_hotel = $clsRegion->getIntro($region_id, 'Hotel');
        $content_page = $clsRegion->getContent($region_id);
        $link_page = $clsRegion->getLink($region_id);
    }

    $assign_list['TD'] = $title_page;
    $assign_list['ID'] = $intro_page;
    $assign_list['HOTEL_INTRO'] = $intro_hotel;
    $assign_list['CD'] = $content_page;
    $assign_list['link_page'] = $link_page;

    if ($clsISO->getCheckActiveModulePackage($package_id, 'region', 'default', 'default')) {
        $lstRegionByCountry = $clsRegion->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no ASC", $clsRegion->pkey . ',title');
        $assign_list['lstRegionByCountry'] = $lstRegionByCountry;
        unset($lstRegionByCountry);

        $lstCityRegionOther = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id=0 and  city_id IN (SELECT city_id FROM " . DB_PREFIX . "hotel WHERE is_trash=0 and is_online=1) order by order_no ASC", $clsCity->pkey);
        $assign_list['lstCityRegionOther'] = $lstCityRegionOther;
        unset($lstCityRegionOther);
    }


    $recordPerPage = 12;
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
    $order_by = " order by order_no ASC";
    $totalRecord = $clsHotel->getAll($cond) ? count($clsHotel->getAll($cond)) : 0;
    $assign_list['totalRecord'] = $totalRecord;
    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);
    #
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    #
    $listHotelPlace = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ',star_id');
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
    $description_page = $clsISO->getMetaDescription($place_id, $clsClassTable);
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
    global $country_id, $clsISO, $package_id, $hotel_id;
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
        $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no ASC", $clsHotelRoom->pkey . ',room_stype_id');
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

    $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and price >0 order by price ASC", $clsHotelRoom->pkey . ",price,number_adult");
    $min_price = $lstHotelRoom[0]['price'];

    if ($min_price) {
        $number_adult = $lstHotelRoom[0]['number_adult'] ? $lstHotelRoom[0]['number_adult'] : 2;
    }
    $assign_list["min_price"] = $min_price;
    $assign_list["number_adult"] = $number_adult;

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

function default_detail2()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $curl;
    global $country_id, $clsISO, $package_id, $hotel_id;
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


    ////$abc= $clsHotel->getImageMapStatic($hotel_id,400,400);print_r($abc);die();


    $oneItem = $clsHotel->getOne($hotel_id, 'title,slug,intro,star_id,address,image,checkin,booking_policy,child_policy,cancellation_policy,other_policy,is_online,list_HotelFacilities,city_id');

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
        $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no ASC", $clsHotelRoom->pkey . ',room_stype_id');
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


    if (isset($_POST['ContactHotel']) && $_POST['ContactHotel'] == 'ContactHotel') {
        vnSessionDelVar('ContactCruise');
        vnSessionDelVar('ContactTour');
        vnSessionDelVar('ContactHotel');
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
        vnSessionSetVar('ContactHotel', $cartSessionHotel);
        header('location:' . $link);
        exit();
    }
    #-- setRecentView
    $clsISO->setRecentView('hotel', $hotel_id);
    #
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

function default_loadPriceRoom()
{
    global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,
        $title_page, $description_page, $keyword_page, $clsISO, $clsConfiguration, $departure_date;
    #
    $clsCountry = new Country();
    $clsCity = new City();
    $clsTour = new Tour();
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;

    vnSessionDelVar('SessionChooseRoom');


    $arraycheckrateRoom = $_POST;
    $assign_list['arraycheckrateRoom'] = $arraycheckrateRoom;


    $hotel_id = $_POST['hotel_id'];
    $assign_list['hotel_id'] = $_POST['hotel_id'];


    $oneItem = $clsHotel->getOne($hotel_id);
    if ($_LANG_ID == 'vn') {
        $check_in = $arraycheckrateRoom['check_in'];
        $check_in = str_replace('/', '-', $check_in);
        $assign_list['check_in'] = $check_in;

        $check_out = $arraycheckrateRoom['check_out'];
        $check_out = str_replace('/', '-', $check_out);
        $assign_list['check_out'] = $check_out;
    } else {
        $check_in = $arraycheckrateRoom['check_in'];
        $assign_list['check_in'] = $check_in;

        $check_out = $arraycheckrateRoom['check_out'];
        $assign_list['check_out'] = $check_out;
    }


    $str_check_in = strtotime($check_in);
    $str_check_out = strtotime($check_out);

    $string_number_night = $str_check_out - $str_check_in;

    $number_night = $string_number_night / 86400;
    if ($number_night > 0) {
        $number_night = $number_night;
    } else {
        $number_night = 1;
    }
    $number_adult = isset($arraycheckrateRoom['number_adult']) ? intval($arraycheckrateRoom['number_adult']) : 0;
    $number_room = isset($arraycheckrateRoom['number_room']) ? intval($arraycheckrateRoom['number_room']) : 0;

    $assign_list['number_adult'] = $number_adult;
    $assign_list['number_room'] = $number_room;

    #-- Cruise Rooms


    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;

    $lstHotelRoomAll = array();
    $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and price >0 order by price ASC", $clsHotelRoom->pkey . ',title,image,bed_option,footage,number_adult');


    foreach ($lstHotelRoom as $item) {
        $lstHotelRoomAll[] = $item;
    }

    $lstHotelRoom2 = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and price=0 order by hotel_room_id ASC", $clsHotelRoom->pkey);
    foreach ($lstHotelRoom2 as $item2) {
        $lstHotelRoomAll[] = $item2;
    }

    $assign_list['lstHotelRoomAll'] = $lstHotelRoomAll;

    $assign_list['number_night'] = $number_night;

    $html = $core->build('loadRoomPriceCheckrate.tpl');
    echo $html;
    die();
}

function default_ajChooseHotelRoom()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
    global $_lang, $extLang, $_LANG_ID, $now_day, $package_id;

    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;


    $hotel_id = Input::post('hotel_id', 0);
    $hotel_room_id = Input::post('hotel_room_id', 0);
    $type = Input::post('type', '');
    $number_adult = Input::post('number_adult', 0);
    $number_child = Input::post('number_child', 0);
    $number_room = Input::post('number_room', 0);
    $totalprice = Input::post('totalprice', 0);
    $max_adult = Input::post('max_adult', 0);
    $check_in = Input::post('check_in', 0);
    $check_out = Input::post('check_out', 0);
    $str_check_in = $check_in ? strtotime($check_in) : '';
    $str_check_out = $check_out ? strtotime($check_out) : '';

    $string_number_night = $str_check_out - $str_check_in;

    $number_night = $string_number_night / 86400;
    if ($number_night > 0) {
        $number_night = $number_night;
    } else {
        $number_night = 1;
    }

    //Tổng tiền đặt phòng
    $total_money = $number_room * $totalprice;

    $discount = $clsISO->getPromotion($hotel_id, 'Hotel', $now_day, $str_check_in, 'info_promotion');
    $promotion = $discount['discount_value'];
    $promotion = str_replace('.', '', $promotion);
    $discount_type = $discount['discount_type'];
    $payment_down = $clsHotelRoom->getPaymentDown($hotel_room_id);

    $payment_down_money = $total_money;
    if ($payment_down > 0) {
        $payment_down_money = $total_money * $payment_down / 100;
    }

    $SessionChooseRoom = vnSessionGetVar('SessionChooseRoom');

    if (empty($SessionChooseRoom)) {
        $SessionChooseRoom = array();
    }
    if ($type == 'D') {
        unset($SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]);
    } else {
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
                $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['room_price'] = $totalprice;
                $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['totalprice'] = $total_money;
                $SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['payment_down_money'] = $payment_down_money;
            } else {
                unset($SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]);
            }
        }
    }


    vnSessionSetVar('SessionChooseRoom', $SessionChooseRoom);

    $arrayRoom = vnSessionGetVar('SessionChooseRoom');

    $listRoom = $arrayRoom[$hotel_id]['room'];
    $assign_list['listRoom'] = $listRoom;
    $assign_list['hotel_id'] = $hotel_id;
    $assign_list['number_adult'] = $number_adult;
    $assign_list['number_child'] = $number_child;
    $assign_list['number_night'] = $number_night;
    $assign_list['str_check_in'] = $str_check_in;
    $assign_list['str_check_out'] = $str_check_out;
    $assign_list['check_in'] = $check_in;
    $assign_list['check_out'] = $check_out;
    $promotion = $arrayRoom[$hotel_id]['promotion'];
    $discount_type = $arrayRoom[$hotel_id]['discount_type'];
    $assign_list['promotion'] = $promotion;

    $oneHotelRoom = $clsHotelRoom->getOne($hotel_room_id, 'number_adult');
    $number_adult_room = $oneHotelRoom['number_adult'];
    $max_room = ceil($number_adult / $number_adult_room) + 1;
    $assign_list['max_room'] = $max_room;
    $assign_list['totalprice'] = $totalprice;

    $totalpriceroom = 0;
    foreach ($listRoom as $item) {
        $totalpriceroom += $item['number_room'] * $item['totalprice'];
    }


    if ($promotion > 0) {
        if ($discount_type == 2) {
            $totalprice_promotion = $promotion * $totalpriceroom / 100;
        } else {
            $totalprice_promotion = $promotion;
        }

        $totalprice_new = $totalpriceroom - $totalprice_promotion;
    } else {
        $totalprice_new = $totalpriceroom;
    }
    $assign_list['totalprice_promotion'] = $totalprice_promotion;
    $assign_list['totalprice_new'] = $totalprice_new;

    if ($type == 'BOOKNOW') {
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
            $html = $link;
        } else {

            vnSessionDelVar('ContactTour');
            vnSessionDelVar('ContactCruise');
            vnSessionDelVar('ContactHotel');

            $SessionChooseRoom = vnSessionGetVar('SessionChooseRoom');
            vnSessionSetVar('ContactHotel', $SessionChooseRoom[$hotel_id]);
            $link = $clsISO->getLink('contact');
            $html = $link;
        }
    } else {
        $html = $core->build('loadRoomChooseBook.tpl');
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

    $str_check_in = $check_in ? strtotime($check_in) : '';
    $str_check_out = $check_out ? strtotime($check_out) : '';

    $string_number_night = $str_check_out - $str_check_in;

    $number_night = $string_number_night / 86400;
    if ($number_night == 0) {
        $number_night = 1;
    }

    $count_people = (int) $number_adults + (int) $number_child;
    #   
    #-- Hotel Rooms
    $lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no ASC");
    // $clsISO->dd($lstHotelRoom);
    foreach ($lstHotelRoom as $index => $row) {
        $count_people_room = (int) $row['number_adult'] + (int) $row['number_children'];
        //Tinh so luong phong cho $count_people nguoi        
        $number_rooms = ceil($count_people / $count_people_room);
        $lstHotelRoom[$index]['number_rooms'] = $number_rooms;
        $lstHotelRoom[$index]['count_people_room'] = $count_people_room;
        $arr_room_highlight = $clsHotelRoom->getArrayTitleHotelRoom($row['view_highlight_status_id']);
        $lstHotelRoom[$index]['room_highlight'] = $arr_room_highlight;
        #
        $totalPrice = $number_night * intval($row['price']);
        $lstHotelRoom[$index]['totalPrice'] = $totalPrice;
        $arr_room_image = $clsHotelRoomImage->getImageOriginal($row['hotel_room_id']);
        $lstHotelRoom[$index]['room_image'] = $arr_room_image;
    }

    $assign_list['hotel_id'] = $hotel_id;
    $assign_list['number_adults'] = $number_adults;
    $assign_list['number_rooms'] = $number_rooms;
    $assign_list['number_child'] = $number_child;
    $assign_list['number_night'] = $number_night;
    $assign_list['check_in'] = $check_in;
    $assign_list['check_out'] = $check_out;
    $assign_list['lstHotelRoom'] = $lstHotelRoom;

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

    $payment_down = $clsHotelRoom->getPaymentDown($hotel_room_id);

    $payment_down_money = $totalprice;
    if ($payment_down > 0) {
        $payment_down_money = $totalprice * $payment_down / 100;
    }

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
