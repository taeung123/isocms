<?php

function default_cat2024()
{
    global $assign_list, $core, $dbconn, $mod, $act, $show, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $extLang, $cat_id, $country_id, $clsConfiguration, $clsISO, $deviceType;
    global $min_duration_value, $max_duration_value, $min_price_value, $max_price_value, $min_duration_search, $max_duration_search;
    #
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;
    Asset::css([
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$v_cache}",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
        "{$URL_CSS}/cat2024.css?v={$upd_version}",
    ]);

    Asset::js([
        "{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.js?v={$v_cache}",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
    ]);

    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list['clsTourStore'] = $clsTourStore;
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $assign_list['clsClassTable'] = $clsTourCategory;
    $clsPagination = new Pagination();
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsCategory_Country = new Category_Country();
    $assign_list['clsCategory_Country'] = $clsCategory_Country;
    $clsCityStore = new CityStore();
    $assign_list['clsCityStore'] = $clsCityStore;
    $clsReview = new Reviews();
    $assign_list["clsReview"] = $clsReview;
    $clsPromotion = new Promotion();
    $assign_list['clsPromotion'] = $clsPromotion;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $assign_list['action'] = $action;
    $sort = $_GET['sort'] ?? '';
    $assign_list['sort'] = $sort;
    #
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    //    $cat_id = $clsTourCategory->getBySlug($slug);
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
    if ($cat_id == '') {
        header('location:' . PCMS_URL);
    }
    $assign_list["cat_id"] = $cat_id;
    #
    $oneItem = $clsTourCategory->getOne($cat_id, $clsTourCategory->pkey . ',slug,title,intro');
    $assign_list["oneItem"] = $oneItem;

    # get method
    $duration = $_GET["duration"] ?? '';
    $assign_list['duration'] = $duration;

    #submit
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = $_POST;
        $link = $clsTourCategory->getLink($cat_id, null);
        if (count($data["cat_id"] ?? []) > 1) {
            $link = $clsISO->getLink("search_tour");
        }
        $first = true;
        foreach ($data as $key => $value) {
            $link .= ($first ? '?' : '&') . "$key=" . (is_array($value) ? $clsISO->makeSlashListFromArrayComma($value) : $value);
            $first = false;
        }
        header('location:' . trim($link));
        exit();
    }

    #
    if ($show == 'CatCountry') {
        $slug_country = $_GET['slug_country'];
        $country_id = $clsCountry->getBySlug($slug_country);
        $assign_list["country_id"] = $country_id;
    }
    #
    if ($deviceType == 'computer') {
        $recordPerPage = 10;
    } else {
        $recordPerPage = 6;
    }
    #
    $cond = "is_trash=0 and is_online=1";
    $cond2 = "is_trash=0 and is_online=1";
    $order_by = " order by order_no asc";
    #

    if ($cat_id > 0) {
        $listTourCategory = $clsTourCategory->getAll("$cond and parent_id='$cat_id'", $clsTourCategory->pkey);
        if ($listTourCategory != '') {
            $parent_id = $cat_id;
            $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%' or cat_id IN (SELECT tourcat_id FROM " . DB_PREFIX . "tour_category WHERE parent_id = '$parent_id'))";
        } else {
            $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
        }
    }
    if ($country_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id')";
    }
    #
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $city_filter_id = isset($_GET['city_filter_id']) ? intval($_GET['city_filter_id']) : 0;
    $country_filter_id = isset($_GET['country_filter_id']) ? intval($_GET['country_filter_id']) : 0;
    $departure_point_id = $_GET['departure_point_id'] ?? "";
    #
    $listTourMaxMin = $clsTour->getAll($cond, "max(number_day) as max,min(number_day) as min");
    $min_duration_value = $listTourMaxMin[0]['min'];
    $max_duration_value = $listTourMaxMin[0]['max'];
    #
    $listpriceMaxMin = $clsTour->getAll($cond, "max(min_price) as max,min(min_price) as min");
    $min_price_value = $listpriceMaxMin[0]['min'];
    $max_price_value = $listpriceMaxMin[0]['max'];
    #
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    #
    if (!empty($departure_point_id)) {
        $assign_list["departure_point_id"] = $departure_point_id;
        $departure_point_ID = explode(',', $departure_point_id);
        $cond .= " and (";
        for ($i = 0; $i < count($departure_point_ID); $i++) {
            if ($i == 0 && count($departure_point_ID) == 1) {
                $cond .= " (departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            } elseif (count($departure_point_ID) > 1 && $i < (count($departure_point_ID) - 1)) {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%') or ";
            } else {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
    }
    #
    $min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration_value;
    $max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration_value;
    #
    $min_duration_query = isset($_GET['min_duration']) ? $_GET['min_duration'] : '';
    $max_duration_query = isset($_GET['max_duration']) ? $_GET['max_duration'] : '';
    #
    $assign_list['min_duration_value'] = $min_duration_value ? $min_duration_value : 0;
    $assign_list['max_duration_value'] = $max_duration_value ? $max_duration_value : 0;
    $assign_list["min_duration_search"] = $min_duration_search ? $min_duration_search : 0;
    $assign_list["max_duration_search"] = $max_duration_search ? $max_duration_search : 0;
    #
    if ($min_duration_query > 0 && $max_duration_query > 0) {
        $cond .= " and number_day >='$min_duration_query' and number_day <='$max_duration_query'";
    } elseif ($min_duration_query == 0 && $max_duration_query > 0) {
        $cond .= " and number_day <='$max_duration_query'";
    } elseif ($min_duration_query > 0 && $max_duration_query == 0) {
        $cond .= " and number_day >='$min_duration_query'";
    }
    #
    $min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price_value;
    $max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price_value;
    #
    $min_price_query = isset($_GET['min_price']) ? $_GET['min_price'] : '';
    $max_price_query = isset($_GET['max_price']) ? $_GET['max_price'] : '';
    #
    $assign_list["min_price_value"] = $min_price_value ? $min_price_value : 0;
    $assign_list["max_price_value"] = $max_price_value ? $max_price_value : 0;
    $assign_list["min_price_search"] = $min_price_search ? $min_price_search : 0;
    $assign_list["max_price_search"] = $max_price_search ? $max_price_search : 0;
    #
    if ($min_price_query > 0 && $max_price_query > 0) {
        $cond .= " and min_price >='$min_price_query' and min_price <='max_price_query'";
    } elseif ($min_price_query == 0 && $max_price_query > 0) {
        $cond .= " and min_price <='$max_price_query'";
    } elseif ($min_price_query > 0 && $max_price_query == 0) {
        $cond .= " and min_price >='$min_price_query'";
    }
    #
    if (!empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_filter_id))";
        $assign_list["country_filter_id"] = $country_filter_id;
    }
    #
    if (!empty($city_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_filter_id))";
        $assign_list["city_filter_id"] = $city_filter_id;
    }
    #
    $totalRecord = $clsTour->getAll($cond, $clsTour->pkey);
    if ($totalRecord) {
        $totalRecord = count($totalRecord);
        $totalTour = $totalRecord;
    } else {
        $totalRecord = 0;
        $totalTour = 0;
    }
    if ($country_id) {
        $link_page = $clsTourCategory->getLinkCatCountry($cat_id, $country_id, $oneItem);
    } else {
        $link_page = $clsTourCategory->getLink($cat_id, $oneItem);
    }
    #
    $assign_list['linksort'] = $clsTourCategory->getLinkCatTour($cat_id, 0, true, $oneItem);
    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page_1' => $link_page
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links();
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    //print_r($cond.$order_by.$limit);die();
    $listTour = $clsTour->getAll($cond . $order_by . $limit, $clsTour->pkey . ",departure_point_id,slug,title,image,duration_type,duration_custom,number_day,number_night");
    if (!$listTour && $currentPage > 1) {
        header("Location: " . $link_page);
        exit();
    }
    #
    $assign_list['totalTour'] = $totalTour;
    $assign_list['listTour'] = $listTour;
    unset($listTour);
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();
    $assign_list['totalRecord'] = $totalRecord;
    #
    $lstclsCategory_Country = $clsCategory_Country->getAll("is_trash=0 and is_online=1 and cat_id='$cat_id' and country_id = '$country_id' limit 0,1", $clsCategory_Country->pkey . ',content');
    $assign_list['lstclsCategory_Country'] = $lstclsCategory_Country;
    #
    $category_country__id = $lstclsCategory_Country[0]['category_country_id'] ?? 0;
    $assign_list['category_country__id'] = $category_country__id;
    $assign_list['catCountryItem'] = $lstclsCategory_Country[0] ?? [];
    #
    $title_cat = $oneItem['title'];
    $assign_list['title_cat'] = $title_cat;
    #
    /* =============Title & Description Page================== */
    $title_page = $title_cat . ' | ' . $core->get_Lang('travelstyles') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($cat_id, 'TourCategory', $oneItem);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cat_id, 'TourCategory', $oneItem);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /* =============Content Page================== */
    unset($clsTourCategory);
    unset($clsTour);
}

function default_default()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
}

function default_tag()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $cat_id, $tag_id;
}

function default_place_inbound()
{
    global $assign_list, $extLang, $core, $dbconn, $mod, $act, $clsISO, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $deviceType, $country_id, $package_id, $country_vn_id, $city_id, $min_duration_value, $max_duration_value, $min_price_value, $max_price_value, $min_duration_search, $max_duration_search;

    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $assign_list["clsClassTable"] = $clsCity;
    $clsCityStore = new CityStore();
    $assign_list["clsCityStore"] = $clsCityStore;
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuide2 = new Guide2();
    $assign_list["clsGuide2"] = $clsGuide2;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsRegion = new Region();
    $assign_list["clsRegion"] = $clsRegion;
    $clsReview = new Reviews();
    $assign_list["clsReview"] = $clsReview;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;

    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    $slug_city = isset($_GET['slug_city']) ? $_GET['slug_city'] : '';

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $assign_list["action"] = $action;
    $city_filter_id = isset($_GET['city_filter_id']) ? $_GET['city_filter_id'] : 0;
    $country_filter_id = isset($_GET['country_filter_id']) ? $_GET['country_filter_id'] : 0;
    $departure_point_id = isset($_GET['departure_point_id']) ? $_GET['departure_point_id'] : 0;

    $res = $clsCity->getAll("is_trash=0 and is_online=1 and slug='$slug_city' LIMIT 0,1", $clsCity->pkey . ',title,banner,intro,content');
    $city_id = $res[0][$clsCity->pkey];
    if (intval($city_id) == 0) {
        header('Location:' . PCMS_URL . $extLang);
        exit();
    }
    $assign_list['itemCity'] = $assign_list['oneItem'] = $res[0];
    $assign_list['city_id'] = $city_id;

    $city_id = $clsCity->getBySlug($slug_city);
    $country_id = $clsCity->getCountryByCity($city_id);
    if (empty($country_id)) {
        $country_id = $country_vn_id;
    }

    $cond = "is_trash=0 and is_online=1";
    $orderby = " order by order_no asc";

    $lstGuideCat = $clsGuideCat->getAll($cond . $orderby, $clsGuideCat->pkey . 'intro,title,image');
    $guidecat_id1 = $lstGuideCat[0]['guidecat_id'] ?? 0;
    $lstGuide = $clsGuide->getAll($cond . " and cat_id='$guidecat_id1' and country_id='$country_id' and city_id='$city_id'" . $orderby, $clsGuide->pkey . ',slug,title,publish_date');
    $totalguide = $lstGuide;
    $totalguide = $totalguide ? count($totalguide) : '0';

    $lstRegion = $clsRegion->getAll($cond . " and country_id='$country_id'" . $orderby, $clsRegion->pkey . ",title");


    $lstTourCat = $clsTourCategory->getAll($cond . $orderby, $clsTourCategory->pkey . ",title");

    $cond = "is_trash=0 and is_online=1";


    if ($country_id > 0 && empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id')";
    }

    if ($city_id && empty($city_filter_id)) {
        $cond .= " and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id' and city_id='$city_id')";
    }


    //    $listTourMaxMin = $clsTour->getAll($cond,"max(number_day) as max,min(number_day) as min");
    $listTourMaxMin = $clsTour->getAll("is_trash=0 and is_online=1", "max(number_day) as max,min(number_day) as min");
    $min_duration_value = $listTourMaxMin[0]['min'];
    $max_duration_value = $listTourMaxMin[0]['max'];


    //	$listpriceMaxMin = $clsTour->getAll($cond,"max(min_price) as max,min(min_price) as min");
    $listpriceMaxMin = $clsTour->getAll("is_trash=0 and is_online=1", "max(min_price) as max,min(min_price) as min");
    //	var_dump($listpriceMaxMin);die;
    $min_price_value = $listpriceMaxMin[0]['min'];
    $max_price_value = $listpriceMaxMin[0]['max'];


    $orderBy = " order by order_no asc";
    if ($deviceType == 'tablet') {
        $recordPerPage = 14;
    } else {
        $recordPerPage = 15;
    }
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;


    $min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration_value;
    $max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration_value;

    $assign_list['min_duration_value'] = $min_duration_value ? $min_duration_value : 0;
    $assign_list['max_duration_value'] = $max_duration_value ? $max_duration_value : 0;

    $assign_list["min_duration_search"] = $min_duration_search ? $min_duration_search : 0;
    $assign_list["max_duration_search"] = $max_duration_search ? $max_duration_search : 0;

    if ($min_duration_search > 0 && $max_duration_search > 0) {
        $cond .= " and number_day >='$min_duration_search' and number_day <='$max_duration_search'";
    } elseif ($min_duration_search == 0 && $max_duration_search > 0) {
        $cond .= " and number_day <='$max_duration_search'";
    } elseif ($min_duration_search > 0 && $max_duration_search == 0) {
        $cond .= " and number_day >='$min_duration_search'";
    }


    $min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price_value;
    $max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price_value;

    $assign_list["min_price_value"] = $min_price_value ? $min_price_value : 0;
    $assign_list["max_price_value"] = $max_price_value ? $max_price_value : 0;

    $assign_list["min_price_search"] = $min_price_search ? $min_price_search : 0;
    $assign_list["max_price_search"] = $max_price_search ? $max_price_search : 0;

    if ($min_price_search > 0 && $max_price_search > 0) {
        $cond .= " and min_price >='$min_price_search' and min_price <='$max_price_search'";
    } elseif ($min_price_search == 0 && $max_price_search > 0) {
        $cond .= " and min_price <='$max_price_search'";
    } elseif ($min_price_search > 0 && $max_price_search == 0) {
        $cond .= " and min_price >='$min_price_search'";
    }

    if (!empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_filter_id))";
        $assign_list["country_filter_id"] = $country_filter_id;
    }

    if (!empty($city_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_filter_id))";
        $assign_list["city_filter_id"] = $city_filter_id;
    }

    if (!empty($departure_point_id)) {
        $departure_point_ID = explode(',', $departure_point_id);
        $cond .= " and (";
        for ($i = 0; $i < count($departure_point_ID); $i++) {
            if ($i == 0 && count($departure_point_ID) == 1) {
                $cond .= " (departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            } elseif (count($departure_point_ID) > 1 && $i < (count($departure_point_ID) - 1)) {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%') or ";
            } else {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
        $assign_list["departure_point_id"] = $departure_point_id;
    }


    $order_by = " order by order_no ASC";
    $listAllTour = $clsTour->getAll($cond, $clsTour->pkey);
    $totalTour = $listAllTour ? count($listAllTour) : 0;

    $link_page = $clsCity->getLink($city_id);
    $config = array(
        'total' => $totalTour,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page_1' => $link_page
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    $totalPage = $clsPagination->getTotalPage();
    //    $clsTour->setdebug();
    $lstTour = $clsTour->getAll($cond . $orderBy . $limit, $clsTour->pkey . ',departure_point_id,slug,title,image,duration_type,duration_custom,number_day,number_night');
    //    die;
    //print_r($cond.$orderBy.$limit); die();
    if (!$lstTour && $currentPage > 1) {
        header("Location: " . $link_page);
        exit();
    }

    $assign_list["totalTour"] = $totalTour;
    $assign_list["country_id"] = $country_id;
    $assign_list["lstGuideCat"] = $lstGuideCat;
    $assign_list["lstGuide"] = $lstGuide;
    $assign_list["lstTour"] = $assign_list["listTour"] = $lstTour;
    $assign_list["lstRegion"] = $lstRegion;
    $assign_list["lstTourCat"] = $lstTourCat;
    $assign_list['currentPage'] = $currentPage;
    $assign_list['totalguide'] = $totalguide;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['page_view'] = $page_view;


    /*=============Title & Description Page==================*/


    $title_page = $core->get_Lang('Domestic tours') . ' | ' . $res[0]['title'] . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_place_inbound2024()
{
    global $clsISO, $assign_list;
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;
    Asset::css([
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$v_cache}",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
        "{$URL_CSS}/cat2024.css?v={$upd_version}",
    ]);

    Asset::js([
        "{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.js?v={$v_cache}",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
    ]);

    $clsCity = new City();
    $slug_city = isset($_GET['slug_city']) ? $_GET['slug_city'] : '';
    $city_id = $clsCity->getBySlug($slug_city);
    $country_id = $clsCity->getCountryByCity($city_id);
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = $_POST;
        $link = $clsCity->getLinkInbound($city_id);

        if (count($data["city_filter_id"]) > 1 || ($data["country_id"] != $country_id)) {
            $link = $clsISO->getLink("search_tour");
        }
        $first = true;
        foreach ($data as $key => $value) {
            $link .= ($first ? '?' : '&') . "$key=" . (is_array($value) ? $clsISO->makeSlashListFromArrayComma($value) : $value);
            $first = false;
        }
        header('location:' . trim($link));
        exit();
    }
    $sort = $_GET['sort'] ?? '';
    $assign_list['sort'] = $sort;
    default_place_inbound();
}
function default_tour_start_date()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $clsISO, $clsConfiguration;
    #
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourGroup = new TourGroup();
    $assign_list['clsTourGroup'] = $clsTourGroup;
    $clsTourStartDate = new TourStartDate();
    $assign_list['clsTourStartDate'] = $clsTourStartDate;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsCityStore = new CityStore();
    $assign_list['clsCityStore'] = $clsCityStore;
    $clsTourDestination = new TourDestination;

    $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    if (intval($tour_group_id) == 0) {
        header('location:' . PCMS_URL);
        exit();
    }
    $assign_list['tour_group_id'] = $tour_group_id;
    $lstTourGroup = $clsTourGroup->getAll('is_trash=0 and is_online=1 order by order_no ASC', $clsTourGroup->pkey);
    $assign_list['lstTourGroup'] = $lstTourGroup;
    unset($lstTourGroup);

    $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '" . time() . "' and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_store) and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc", $clsTourStartDate->pkey . ',tour_id');
    $assign_list['lstTourStartDate'] = $lstTourStartDate;
    #departure
    $list_departure_points = array();
    foreach ($lstTourStartDate as $k => $v) {
        $list_departure_point_id = $clsTour->getOneField('list_departure_point_id', $v['tour_id']);
        $tmp = !empty($list_departure_point_id) ? $clsISO->getArrayByTextSlash($list_departure_point_id) : array();
        if (!empty($tmp)) {
            foreach ($tmp as $id) {
                if (!in_array($id, $list_departure_points)) {
                    $list_departure_points[] = $id;
                }
            }
        }
    }

    $list_departure_points = implode(",", $list_departure_points);
    $lstDeparturePoint = $clsCityStore->getAll("is_trash=0 and type='DEPARTUREPOINT' and city_id IN (
		SELECT city_id FROM " . $clsCity->tbl . " 
		WHERE is_trash=0 and is_online=1 and `city_id` in ({$list_departure_points})
	)  order by order_no ASC");
    //	print_r($lstDeparturePoint);die();
    $assign_list['lstDeparturePoint'] = $lstDeparturePoint;
    unset($lstDeparturePoint);

    #$DURATION_HTML
    $cond = "is_trash=0 and is_online=1";
    $LISTALL = $lstTourStartDate;
    $TMP = '';
    $DURATION_HTML = '<option value="0">' . $core->get_Lang('Tour length') . '</option>';
    if (is_array($LISTALL) && count($LISTALL) > 0) {
        for ($i = 0; $i < count($LISTALL); $i++) {
            $tour_id = $clsTourStartDate->getOneField('tour_id', $LISTALL[$i][$clsTourStartDate->pkey]);
            $TMP .= $clsTour->getSelectTripDuration($tour_id) . '|';
        }
        $TMP = array_unique(explode('|', $TMP));
        if (is_array($TMP) && count($TMP) > 0) {
            sort($TMP, SORT_NUMERIC);
            foreach ($TMP as $key => $val) {
                if ($val != '' && $val != 'n/a') {
                    $DURATION_HTML .= '<option value="' . $clsTour->convertDuration($val) . '">' . $val . '</option>';
                }
            }
        }
        unset($LISTALL);
    }
    $assign_list['DURATION_HTML'] = $DURATION_HTML;

    #CITY_HTML
    $LISTALL = $lstTourStartDate;
    $tmp = '';
    $TMP = '';
    $CITY_HTML = '<option value="0">' . $core->get_Lang('Điểm đến') . '</option>';
    if (is_array($LISTALL) && count($LISTALL) > 0) {
        $list_tour_id = array();
        foreach ($LISTALL as $k => $v) {
            $tour_id = $v['tour_id'];
            $tmp = !empty($tour_id) ? $clsISO->getArrayByTextSlash($tour_id) : array();
            if (!empty($tmp)) {
                foreach ($tmp as $id) {
                    if (!in_array($id, $list_tour_id)) {
                        $list_tour_id[] = $id;
                    }
                }
            }
        }
        $list_tour_id = implode(",", $list_tour_id);
        $lstItems = $clsTourDestination->getAll("is_trash=0 and tour_id IN ($list_tour_id) and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc", $clsTourDestination->pkey . ',city_id');
        if (is_array($lstItems) && count($lstItems) > 0) {
            $list_city_id = array();
            foreach ($lstItems as $k => $v) {
                $city_id = $clsTourDestination->getOneField('city_id', $v[$clsTourDestination->pkey]);
                $tmp = !empty($city_id) ? $clsISO->getArrayByTextSlash($city_id) : array();

                if (!empty($tmp)) {
                    foreach ($tmp as $id) {
                        if (!in_array($id, $list_city_id)) {
                            $list_city_id[] = $id;
                        }
                    }
                }
            }
            foreach ($list_city_id as $one_city) {
                $CITY_HTML .= '<option value="' . $one_city . '">' . $clsCity->getTitle($one_city) . '</option>';
            }
            unset($lstItems);
        }
        unset($LISTALL);
    }
    $assign_list['CITY_HTML'] = $CITY_HTML;

    #AVAILABLE_HTML
    $LISTALL = $lstTourStartDate;
    $TMP = '';
    $AVAILABLE_HTML = '<option value="0">' . $core->get_Lang('Ngày khởi hành') . '</option>';
    if (is_array($LISTALL) && count($LISTALL) > 0) {
        $list_start_date = array();
        foreach ($LISTALL as $k => $v) {
            $list_start_date_id = $clsTourStartDate->getOneField('start_date', $v['tour_start_date_id']);
            $tmp = !empty($list_start_date_id) ? $clsISO->getArrayByTextSlash($list_start_date_id) : array();
            if (!empty($tmp)) {
                foreach ($tmp as $id) {
                    if (!in_array($id, $list_start_date)) {
                        $list_start_date[] = $id;
                    }
                }
            }
        }
        for ($i = 0; $i < count($list_start_date); $i++) {
            $AVAILABLE_HTML .= '<option value="' . $clsISO->formatDate($list_start_date[$i], '') . '">' . $clsISO->formatDate($list_start_date[$i], '') . '</option>';
        }
        unset($list_start_date);
    }
    $assign_list['AVAILABLE_HTML'] = $AVAILABLE_HTML;
    /*=============Title & Description Page==================*/
    $title_page = PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsConfiguration->getValue('ImageShareSocial');
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
    unset($clsTour);
}

function default_ajload_list_tour_start_date()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
    #
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourGroup = new TourGroup();
    $assign_list['clsTourGroup'] = $clsTourGroup;
    $clsTourStartDate = new TourStartDate();
    $assign_list['clsTourStartDate'] = $clsTourStartDate;

    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
    $departure_point_id = isset($_POST['departure_point_id']) ? intval($_POST['departure_point_id']) : 0;
    $duration_id = isset($_POST['duration_id']) ? intval($_POST['duration_id']) : 0;
    $city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $start_date = strtotime(str_replace('/', '-', $start_date));


    $cond = "is_trash=0 and is_online=1 and start_date >= '" . time() . "' and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_store) and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id'";
    $order = " order by start_date asc";
    //	print_r($departure_point_id);die();
    $list_tour_id = array();
    foreach ($lstTourStartDate as $k => $v) {
        $tour_id = $v['tour_id'];
        //		print_r($tour_id);die();
        $tmp = !empty($tour_id) ? $clsISO->getArrayByTextSlash($tour_id) : array();
        //		print_r($tour_id);
        if (!empty($tmp)) {
            foreach ($tmp as $id) {
                if (!in_array($id, $list_tour_id)) {
                    $list_tour_id[] = $id;
                }
            }
        }
    }
    $list_tour_id = implode(",", $list_tour_id);
    if (intval($departure_point_id) > 0 && $duration_id == 0) {
        $cond .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%'))";
    } elseif (intval($departure_point_id) > 0 && !empty($duration_id)) {
        $cond .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
    } elseif (intval($departure_point_id) == 0 && $duration_id == 0 && $city_id == 0 && $start_date == 0) {
        $cond .= ")";
    }
    if (!empty($duration_id)) {
        $cond .= " and number_day IN($duration_id))";
    }
    if ($city_id > 0 && $departure_point_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE city_id='$city_id')";
    } elseif ($city_id > 0 && $departure_point_id == 0 && $duration_id == 0) {
        $cond .= ") and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE city_id='$city_id')";
    } elseif ($city_id == 0 && $departure_point_id == 0 && $duration_id == 0 && $start_date > 0) {
        $cond .= ")";
    } elseif (intval($departure_point_id) == 0 && $duration_id == 0 && $city_id == 0 && $start_date == 0) {
        $cond .= "";
    }
    if ($start_date != '' || $start_date > 0) {
        $cond .= " and start_date='$start_date'";
    }
    //	print_r($cond.$order);die();
    $lstTourStartDate = $clsTourStartDate->getAll($cond . $order, $clsTourStartDate->pkey . ',tour_id');
    $assign_list['lstTourStartDate'] = $lstTourStartDate;
    //	print_r($lstTourStartDate);die();
    #
    $assign_list['tour_group_id'] = $tour_group_id;

    $html = $core->build('load_list_tour_strat_date.tpl');
    echo $html;
    die();
}

function default_listGuide()
{
    global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,
        $title_page, $description_page, $keyword_page, $clsISO;

    $clsGuide = new Guide();
    $smarty->assign('clsGuide', $clsGuide);

    $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : 0;

    if ($city_id > 0) {
        $lstGuide = $clsGuide->getAll("is_trash=0 and is_online=1 and cat_id='$cat_id' and country_id='$country_id' and city_id='$city_id' order by order_no asc", $clsGuide->pkey);
    } else {
        $lstGuide = $clsGuide->getAll("is_trash=0 and is_online=1 and cat_id='$cat_id' and country_id='$country_id' order by order_no asc", $clsGuide->pkey);
    }

    $totalRecord = $lstGuide;
    $totalRecord = $totalRecord ? count($totalRecord) : '0';

    $smarty->assign('lstGuide', $lstGuide);
    $smarty->assign('totalRecord', $totalRecord);

    $html = $core->build('listGuide.tpl');
    echo $html;
    die();
}

function default_searchlocal()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $clsISO, $description_page, $keyword_page, $domain, $country_id, $country_vn_id, $cat_id, $deviceType;

    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsReview = new Reviews();
    $assign_list["clsReview"] = $clsReview;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsCityStore = new CityStore();
    $assign_list["clsCityStore"] = $clsCityStore;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;

    $listTourAsc = $clsTour->getAll("is_trash=0 and is_online=1 order by number_day asc", $clsTour->pkey . ",number_day");
    $listTourDesc = $clsTour->getAll("is_trash=0 and is_online=1 order by number_day desc", $clsTour->pkey . ",number_day");
    $listpriceAsc = $clsTour->getAll("is_trash=0 and is_online=1  order by min_price asc", $clsTour->pkey . ",min_price");
    $listpriceDesc = $clsTour->getAll("is_trash=0 and is_online=1  order by min_price desc", $clsTour->pkey . ",min_price");

    $min_duration = $listTourAsc[0]['number_day'];
    $max_duration = $listTourDesc[0]['number_day'];
    $min_price = $listpriceAsc[0]['min_price'];
    $max_price = $listpriceDesc[0]['min_price'];
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $tourcat_id = isset($_GET['tourcat_id']) ? $_GET['tourcat_id'] : '';

    $cond = "is_trash=0 and is_online=1";
    $orderBy = " order by order_no asc";

    if ($deviceType == 'tablet') {
        $recordPerPage = 14;
    } else {
        $recordPerPage = 15;
    }
    $pageNum = 15;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration;
    $max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration;
    $assign_list['min_duration'] = $min_duration;
    $assign_list['max_duration'] = $max_duration;

    $assign_list["min_duration_search"] = $min_duration_search;
    $assign_list["max_duration_search"] = $max_duration_search;

    if ($min_duration_search > 0 && $max_duration_search > 0) {
        $cond .= " and number_day >='$min_duration_search' and number_day <='$max_duration_search'";
    } elseif ($min_duration_search == 0 && $max_duration_search > 0) {
        $cond .= " and number_day <='$max_duration_search'";
    } elseif ($min_duration_search > 0 && $max_duration_search == 0) {
        $cond .= " and number_day >='$min_duration_search'";
    }

    //	print_r($cond);die();
    $assign_list['min_price'] = $min_price;
    $assign_list['max_price'] = $max_price;
    $min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price;
    $max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price;
    $assign_list["min_price_search"] = $min_price_search;
    $assign_list["max_price_search"] = $max_price_search;

    if ($min_price_search > 0 && $max_price_search > 0) {
        $cond .= " and min_price >='$min_price_search' and min_price <='$max_price_search'";
    } elseif ($min_price_search == 0 && $max_price_search > 0) {
        $cond .= " and min_price <='$max_price_search'";
    } elseif ($min_price_search > 0 && $max_price_search == 0) {
        $cond .= " and min_price >='$min_price_search'";
    }

    if ($city_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_vn_id' and city_id IN ($city_id))";
        $assign_list["city_id"] = $city_id;
    } else {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_vn_id')";
    }

    if (!empty($tourcat_id)) {
        $cat_ID = explode(',', $tourcat_id);
        $cond .= " and (";
        for ($i = 0; $i < count($cat_ID); $i++) {
            if ($i == 0 && count($cat_ID) == 1) {
                $cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            } elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
            } else {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
    }

    $assign_list["cat_id"] = $tourcat_id;
    $lstTourCat = $clsTourCategory->getAll("is_trash=0 and is_online=1" . $orderBy);

    $assign_list["lstTourCat"] = $lstTourCat;

    $lstTourResult = $clsTour->getAll($cond . $orderBy, $clsTour->pkey);

    $totalTour = count($lstTourResult);
    $link_page = $extLang . '/du-lich-trong-nuoc/';
    $config = array(
        'total' => $totalTour,
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

    $lstTourResult = $clsTour->getAll($cond . $orderBy . $limit, $clsTour->pkey);
    //	print_r($totalTour);die();
    $assign_list["lstTourResult"] = $lstTourResult;
    $assign_list['page_view'] = $page_view;
    unset($lstTourResult);
    unset($page_view);

    $assign_list['totalTour'] = $totalTour;
    $totalPage = $clsPagination->getTotalPage();
    //	print_r($totalPage);die();
    $assign_list['totalPage'] = $totalPage;

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Tour trong nước') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_place_outbound()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $clsISO, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $deviceType, $country_id, $package_id;
    global $min_duration_value, $max_duration_value, $min_price_value, $max_price_value, $min_duration_search, $max_duration_search;


    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsCityStore = new CityStore();
    $assign_list["clsCityStore"] = $clsCityStore;
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsRegion = new Region();
    $assign_list["clsRegion"] = $clsRegion;
    $clsReview = new Reviews();
    $assign_list["clsReview"] = $clsReview;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;

    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    $slug_country = isset($_GET['slug_country']) ? $_GET['slug_country'] : '';
    $slug_city = isset($_GET['slug_city']) ? $_GET['slug_city'] : '';

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $assign_list["action"] = $action;
    $city_filter_id = isset($_GET['city_filter_id']) ? $_GET['city_filter_id'] : 0;
    $country_filter_id = isset($_GET['country_filter_id']) ? $_GET['country_filter_id'] : 0;
    $departure_point_id = isset($_GET['departure_point_id']) ? $_GET['departure_point_id'] : 0;

    $res = $clsCountry->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1", $clsCountry->pkey . ',title,banner,intro,content');
    $country_id = $res[0][$clsCountry->pkey];
    $assign_list['countryItem'] = $res[0];
    $res1 = $clsCity->getAll("is_trash=0 and is_online=1 and slug='$slug_city' LIMIT 0,1", $clsCity->pkey . ',title,banner,intro,content');
    $city_id = $res1[0][$clsCity->pkey];
    $assign_list['cityItem'] = $res1[0];
    if (intval($country_id) == 0) {
        header('Location:' . PCMS_URL . $extLang);
        exit();
    }

    $assign_list['country_id'] = $country_id;
    $assign_list['city_id'] = $city_id;
    $cond = "is_trash=0 and is_online=1";

    $orderby = " order by order_no asc";

    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

    $lstGuideCat = $clsGuideCat->getAll($cond . $orderby, $clsGuideCat->pkey . ',title,intro');
    $guidecat2 = $lstGuideCat[0]['guidecat_id'];
    if ($city_id) {
        $lstGuide = $clsGuide->getAll($cond . " and cat_id='$guidecat2' and country_id='$country_id' and city_id='$city_id'" . $orderby, $clsGuide->pkey . ',title,slug,publish_date,intro');
    } else {
        $lstGuide = $clsGuide->getAll($cond . " and cat_id='$guidecat2' and country_id='$country_id'" . $orderby, $clsGuide->pkey . ',title,slug,publish_date,intro');
    }

    $totalguide = $lstGuide;
    $totalguide = $totalguide ? count($totalguide) : '0';
    $lstRegion = $clsRegion->getAll($cond . " and country_id='$country_id'" . $orderby, $clsRegion->pkey);

    $lstTourCat = $clsTourCategory->getAll($cond . $orderby, $clsTourCategory->pkey . ",title");


    $cond = "is_trash=0 and is_online=1";


    if ($country_id > 0 && empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id')";
    }

    if ($city_id && empty($city_filter_id)) {
        $cond .= " and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id' and city_id='$city_id')";
    }

    //    $listTourMaxMin = $clsTour->getAll($cond,"max(number_day) as max,min(number_day) as min");
    $listTourMaxMin = $clsTour->getAll("is_trash=0 and is_online=1", "max(number_day) as max,min(number_day) as min");
    $min_duration_value = $listTourMaxMin[0]['min'];
    $max_duration_value = $listTourMaxMin[0]['max'];


    //	$listpriceMaxMin = $clsTour->getAll($cond,"max(min_price) as max,min(min_price) as min");
    $listpriceMaxMin = $clsTour->getAll("is_trash=0 and is_online=1", "max(min_price) as max,min(min_price) as min");
    $min_price_value = $listpriceMaxMin[0]['min'];
    $max_price_value = $listpriceMaxMin[0]['max'];


    $orderBy = " order by order_no asc";
    if ($deviceType == 'tablet') {
        $recordPerPage = 14;
    } else {
        $recordPerPage = 15;
    }
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;


    $min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration_value;
    $max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration_value;

    $assign_list['min_duration_value'] = $min_duration_value ? $min_duration_value : 0;
    $assign_list['max_duration_value'] = $max_duration_value ? $max_duration_value : 0;

    $assign_list["min_duration_search"] = $min_duration_search ? $min_duration_search : 0;
    $assign_list["max_duration_search"] = $max_duration_search ? $max_duration_search : 0;

    if ($min_duration_search > 0 && $max_duration_search > 0) {
        $cond .= " and number_day >='$min_duration_search' and number_day <='$max_duration_search'";
    } elseif ($min_duration_search == 0 && $max_duration_search > 0) {
        $cond .= " and number_day <='$max_duration_search'";
    } elseif ($min_duration_search > 0 && $max_duration_search == 0) {
        $cond .= " and number_day >='$min_duration_search'";
    }


    $min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price_value;
    $max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price_value;

    $assign_list["min_price_value"] = $min_price_value ? $min_price_value : 0;
    $assign_list["max_price_value"] = $max_price_value ? $max_price_value : 0;

    $assign_list["min_price_search"] = $min_price_search ? $min_price_search : 0;
    $assign_list["max_price_search"] = $max_price_search ? $max_price_search : 0;


    if ($min_price_search > 0 && $max_price_search > 0) {
        $cond .= " and min_price >='$min_price_search' and min_price <='$max_price_search'";
    } elseif ($min_price_search == 0 && $max_price_search > 0) {
        $cond .= " and min_price <='$max_price_search'";
    } elseif ($min_price_search > 0 && $max_price_search == 0) {
        $cond .= " and min_price >='$min_price_search'";
    }

    if (!empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_filter_id))";
        $assign_list["country_filter_id"] = $country_filter_id;
    }

    if (!empty($city_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_filter_id))";
        $assign_list["city_filter_id"] = $city_filter_id;
    }

    if (!empty($departure_point_id)) {
        $departure_point_ID = explode(',', $departure_point_id);
        $cond .= " and (";
        for ($i = 0; $i < count($departure_point_ID); $i++) {
            if ($i == 0 && count($departure_point_ID) == 1) {
                $cond .= " (departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            } elseif (count($departure_point_ID) > 1 && $i < (count($departure_point_ID) - 1)) {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%') or ";
            } else {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
        $assign_list["departure_point_id"] = $departure_point_id;
    }


    $order_by = " order by order_no ASC";
    $listAllTour = $clsTour->getAll($cond, $clsTour->pkey);
    $totalTour = $listAllTour ? count($listAllTour) : 0;

    if ($slug_city) {
        $link_page = $clsISO->getLink('outbound') . $slug_country . "/" . $slug_city;
    } else {
        $link_page = $clsISO->getLink('outbound') . $slug_country;
    }
    $config = array(
        'total' => $totalTour,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page_1' => $link_page
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    $totalPage = $clsPagination->getTotalPage();

    //print_r($cond);die();

    $lstTour = $clsTour->getAll($cond . $orderBy . $limit, $clsTour->pkey . ',departure_point_id,slug,title,image,duration_type,duration_custom,number_day,number_night');
    if (!$lstTour && $currentPage > 1) {
        header("Location: " . $link_page);
        exit();
    }

    $assign_list["totalTour"] = $totalTour;
    $assign_list["country_id"] = $country_id;
    $assign_list["lstGuideCat"] = $lstGuideCat;
    $assign_list["lstGuide"] = $lstGuide;
    $assign_list["lstTour"] = $lstTour;
    $assign_list["lstRegion2"] = $lstRegion;
    $assign_list["lstTourCat"] = $lstTourCat;
    $assign_list['currentPage'] = $currentPage;
    $assign_list['totalTour'] = $totalTour;
    $assign_list['totalguide'] = $totalguide;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['page_view'] = $page_view;


    /*=============Title & Description Page==================*/
    $titleCity = '';
    if ($city_id) {
        $titleCity = ' | ' . $clsCity->getTitle($city_id, $cityItem);
    }
    if ($_LANG_ID == 'vn') {
        $title_page = $core->get_Lang('Du lịch nước ngoài') . ' | ' . $clsCountry->getTitle($country_id) . $titleCity . ' | ' . PAGE_NAME;
    } else {
        $title_page = $core->get_Lang('Destinations') . ' | ' . $clsCountry->getTitle($country_id) . $titleCity . ' | ' . PAGE_NAME;
    }

    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_place_outbound2024()
{
    default_place_outbound();
}
function default_searchtour()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $clsISO, $description_page, $keyword_page, $domain, $deviceType;
    global $min_duration_value, $max_duration_value, $min_price_value, $max_price_value, $min_duration_search, $max_duration_search;
    
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsReview = new Reviews();
    $assign_list["clsReview"] = $clsReview;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsCityStore = new CityStore();
    $assign_list["clsCityStore"] = $clsCityStore;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;

    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
    $tourcat_id = isset($_GET['tourcat_id']) ? $_GET['tourcat_id'] : 0;
    $keyword = (isset($_GET['key']) && !empty($_GET['key'])) ? $_GET['key'] : '';
    $departure_point_id = isset($_GET['departure_point_id']) ? $_GET['departure_point_id'] : 0;
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
    $duration_id = isset($_GET['duration_id']) ? $_GET['duration_id'] : 0;

    $departure_date = isset($_GET['departure_date']) ? $_GET['departure_date'] : '';

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $city_filter_id = isset($_GET['city_filter_id']) ? $_GET['city_filter_id'] : 0;
    $country_filter_id = isset($_GET['country_filter_id']) ? $_GET['country_filter_id'] : 0;

    $cond = "is_trash=0 and is_online=1";

    if (!empty($duration_id)) {
        $ex_duration = explode('-', $duration_id);
        $cond .= ' and number_day=' . $ex_duration[0] . ' and number_night=' . $ex_duration[1];
        $assign_list['duration_id'] = $duration_id;
    }
    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
        $assign_list["keyword"] = $keyword;
    }


    if (!empty($departure_point_id) && $action != 'search') {
        $cond .= " and (departure_point_id='" . $departure_point_id . "' or list_departure_point_id like '%|" . $departure_point_id . "|%')";
        $assign_list['departure_point_id'] = $departure_point_id;
    }

    $listTourMaxMin = $clsTour->getAll($cond, "max(number_day) as max,min(number_day) as min");
    $min_duration_value = $listTourMaxMin ? $listTourMaxMin[0]['min'] : 0;
    $max_duration_value = $listTourMaxMin ? $listTourMaxMin[0]['max'] : 0;

    $listpriceMaxMin = $clsTour->getAll($cond, "max(min_price) as max,min(min_price) as min");
    $min_price_value = $listpriceMaxMin ? $listpriceMaxMin[0]['min'] : 0;
    $max_price_value = $listpriceMaxMin ? $listpriceMaxMin[0]['max'] : 0;

    if ($deviceType == 'tablet') {
        $recordPerPage = 14;
    } else {
        $recordPerPage = 10;
    }
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

    if (!empty($departure_point_id) && $action == 'search') {
        $departure_point_ID = explode(',', $departure_point_id);
        $cond .= " and (";
        for ($i = 0; $i < count($departure_point_ID); $i++) {
            if ($i == 0 && count($departure_point_ID) == 1) {
                $cond .= " (departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            } elseif (count($departure_point_ID) > 1 && $i < (count($departure_point_ID) - 1)) {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%') or ";
            } else {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
        $assign_list["departure_point_id"] = $departure_point_id;
    }

    if (!empty($tourcat_id)) {
        $cat_ID = explode(',', $tourcat_id);
        $cond .= " and (";
        for ($i = 0; $i < count($cat_ID); $i++) {
            if ($i == 0 && count($cat_ID) == 1) {
                $cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            } elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
            } else {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
        $assign_list["cat_id"] = $tourcat_id;
    }

    $min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration_value;
    $max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration_value;

    $min_duration_query = isset($_GET['min_duration']) ? $_GET['min_duration'] : '';
    $max_duration_query = isset($_GET['max_duration']) ? $_GET['max_duration'] : '';

    $assign_list['min_duration_value'] = $min_duration_value ? $min_duration_value : 0;
    $assign_list['max_duration_value'] = $max_duration_value ? $max_duration_value : 0;

    $assign_list["min_duration_search"] = $min_duration_search ? $min_duration_search : 0;
    $assign_list["max_duration_search"] = $max_duration_search ? $max_duration_search : 0;

    if ($min_duration_query > 0 && $max_duration_query > 0) {
        $cond .= " and number_day >='$min_duration_query' and number_day <='$max_duration_query'";
    } elseif ($min_duration_query == 0 && $max_duration_query > 0) {
        $cond .= " and number_day <='$max_duration_query'";
    } elseif ($min_duration_query > 0 && $max_duration_query == 0) {
        $cond .= " and number_day >='$min_duration_query'";
    }

    $min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price_value;
    $max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price_value;

    $min_price_query = isset($_GET['min_price']) ? $_GET['min_price'] : '';
    $max_price_query = isset($_GET['max_price']) ? $_GET['max_price'] : '';

    $assign_list["min_price_value"] = $min_price_value ? $min_price_value : 0;
    $assign_list["max_price_value"] = $max_price_value ? $max_price_value : 0;

    $assign_list["min_price_search"] = $min_price_search ? $min_price_search : 0;
    $assign_list["max_price_search"] = $max_price_search ? $max_price_search : 0;

    if ($min_price_query > 0 && $max_price_query > 0) {
        $cond .= " and min_price >='$min_price_query' and min_price <='max_price_query'";
    } elseif ($min_price_query == 0 && $max_price_query > 0) {
        $cond .= " and min_price <='$max_price_query'";
    } elseif ($min_price_query > 0 && $max_price_query == 0) {
        $cond .= " and min_price >='$min_price_query'";
    }

    if (!empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_filter_id))";
        $assign_list["country_filter_id"] = $country_filter_id;
    }

    if (!empty($city_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_filter_id))";
        $assign_list["city_filter_id"] = $city_filter_id;
    }

    $order_by = " order by order_no DESC";

    $totalRecord = $clsTour->getAll($cond, $clsTour->pkey);
    
    if ($totalRecord) {
        $totalRecord = count($totalRecord);
        $totalTour = $totalRecord;
    } else {
        $totalRecord = 0;
        $totalTour = 0;
    }
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
    $assign_list["link_page"] = $link_page;
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

    $lstTourResult = $clsTour->getAll($cond . $order_by . $limit, $clsTour->pkey . ",departure_point_id,slug,title,image,duration_type,duration_custom,number_day,number_night");
    if (!$lstTourResult && $currentPage > 1) {
        header("Location: " . $link_page);
        exit();
    }
    // var_dump($cond . $order_by . $limit, $clsTour->pkey);
    // var_dump($totalTour);
    //var_dump($lstTourResult);

    $assign_list['totalTour'] = $totalTour;
    $assign_list["lstTourResult"] = $assign_list["listTour"] = $lstTourResult;
    unset($lstTourResult);
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();
    $assign_list['totalRecord'] = $totalRecord;


    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Search tours') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_searchtour2024()
{
    global $clsISO, $assign_list;
    global $URL_CSS, $URL_JS, $v_cache, $upd_version, $URL_LIBRARY;
    Asset::css([
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$v_cache}",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
        "{$URL_CSS}/cat2024.css?v={$upd_version}",
    ]);

    Asset::js([
        "{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.js?v={$v_cache}",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
    ]);

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = $_POST;
        $link = $clsISO->getLink("search_tour");
        $first = true;
        foreach ($data as $key => $value) {
            $link .= ($first ? '?' : '&') . "$key=" . (is_array($value) ? $clsISO->makeSlashListFromArrayComma($value) : $value);
            $first = false;
        }
        header('location:' . trim($link));
        exit();
    }
    $sort = $_GET['sort'] ?? '';
    $assign_list['sort'] = $sort;
    default_searchtour();
}

function default_travel_style_by_country()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $show, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $extLang, $cat_id, $country_id, $clsConfiguration, $clsISO, $deviceType;
    global $min_duration_value, $max_duration_value, $min_price_value, $max_price_value, $min_duration_search, $max_duration_search;
    #

    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list['clsTourStore'] = $clsTourStore;
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsPagination = new Pagination();
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsCategory_Country = new Category_Country();
    $assign_list['clsCategory_Country'] = $clsCategory_Country;
    $clsCityStore = new CityStore();
    $assign_list['clsCityStore'] = $clsCityStore;
    $clsReview = new Reviews();
    $assign_list["clsReview"] = $clsReview;

    $clsPromotion = new Promotion();
    $assign_list['clsPromotion'] = $clsPromotion;
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $assign_list['action'] = $action;
    #

    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
    if ($cat_id == '') {
        header('location:' . PCMS_URL);
    }
    $assign_list["cat_id"] = $cat_id;

    $oneItem = $clsTourCategory->getOne($cat_id, $clsTourCategory->pkey . ',slug,title,intro');
    $assign_list["oneItem"] = $oneItem;

    #submit
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = $_POST;
        $link = $clsTourCategory->getLink($cat_id, null);
        if (count($data["cat_id"]) > 1) {
            $link = $clsISO->getLink("search_tour");
        }
        $first = true;
        foreach ($data as $key => $value) {
            $link .= ($first ? '?' : '&') . "$key=" . (is_array($value) ? $clsISO->makeSlashListFromArrayComma($value) : $value);
            $first = false;
        }
        header('location:' . trim($link));
        exit();
    }

    #

    if ($show == 'CatCountry') {
        $slug_country = $_GET['slug_country'];
        $country_id = $clsCountry->getBySlug($slug_country);
        $assign_list["country_id"] = $country_id;
    }
    $cond = "is_trash=0 and is_online=1";

    if ($cat_id > 0) {
        $listTourCategory = $clsTourCategory->getAll("is_trash=0 and is_online=1 and parent_id='$cat_id'", $clsTourCategory->pkey);
        if ($listTourCategory != '') {
            $parent_id = $cat_id;
            $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%' or cat_id IN (SELECT tourcat_id FROM " . DB_PREFIX . "tour_category WHERE parent_id = '$parent_id'))";
        } else {
            $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
        }
    }
    if ($country_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id')";
    }
    $city_filter_id = isset($_GET['city_filter_id']) ? $_GET['city_filter_id'] : 0;
    $country_filter_id = isset($_GET['country_filter_id']) ? $_GET['country_filter_id'] : 0;
    $departure_point_id = isset($_GET['departure_point_id']) ? $_GET['departure_point_id'] : 0;

    $listTourMaxMin = $clsTour->getAll($cond, "max(number_day) as max,min(number_day) as min");
    $min_duration_value = $listTourMaxMin[0]['min'];
    $max_duration_value = $listTourMaxMin[0]['max'];

    $listpriceMaxMin = $clsTour->getAll($cond, "max(min_price) as max,min(min_price) as min");
    $min_price_value = $listpriceMaxMin[0]['min'];
    $max_price_value = $listpriceMaxMin[0]['max'];


    $recordPerPage = 10;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

    if (!empty($departure_point_id)) {
        $departure_point_ID = explode(',', $departure_point_id);
        $cond .= " and (";
        for ($i = 0; $i < count($departure_point_ID); $i++) {
            if ($i == 0 && count($departure_point_ID) == 1) {
                $cond .= " (departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            } elseif (count($departure_point_ID) > 1 && $i < (count($departure_point_ID) - 1)) {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%') or ";
            } else {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
        $assign_list["departure_point_id"] = $departure_point_id;
    }

    $min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration_value;
    $max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration_value;

    $min_duration_query = isset($_GET['min_duration']) ? $_GET['min_duration'] : '';
    $max_duration_query = isset($_GET['max_duration']) ? $_GET['max_duration'] : '';

    $assign_list['min_duration_value'] = $min_duration_value ? $min_duration_value : 0;
    $assign_list['max_duration_value'] = $max_duration_value ? $max_duration_value : 0;

    $assign_list["min_duration_search"] = $min_duration_search ? $min_duration_search : 0;
    $assign_list["max_duration_search"] = $max_duration_search ? $max_duration_search : 0;

    if ($min_duration_query > 0 && $max_duration_query > 0) {
        $cond .= " and number_day >='$min_duration_query' and number_day <='$max_duration_query'";
    } elseif ($min_duration_query == 0 && $max_duration_query > 0) {
        $cond .= " and number_day <='$max_duration_query'";
    } elseif ($min_duration_query > 0 && $max_duration_query == 0) {
        $cond .= " and number_day >='$min_duration_query'";
    }


    $min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price_value;
    $max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price_value;

    $min_price_query = isset($_GET['min_price']) ? $_GET['min_price'] : '';
    $max_price_query = isset($_GET['max_price']) ? $_GET['max_price'] : '';

    $assign_list["min_price_value"] = $min_price_value ? $min_price_value : 0;
    $assign_list["max_price_value"] = $max_price_value ? $max_price_value : 0;

    $assign_list["min_price_search"] = $min_price_search ? $min_price_search : 0;
    $assign_list["max_price_search"] = $max_price_search ? $max_price_search : 0;


    if ($min_price_query > 0 && $max_price_query > 0) {
        $cond .= " and min_price >='$min_price_query' and min_price <='max_price_query'";
    } elseif ($min_price_query == 0 && $max_price_query > 0) {
        $cond .= " and min_price <='$max_price_query'";
    } elseif ($min_price_query > 0 && $max_price_query == 0) {
        $cond .= " and min_price >='$min_price_query'";
    }

    if (!empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_filter_id))";
        $assign_list["country_filter_id"] = $country_filter_id;
    }

    if (!empty($city_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_filter_id))";
        $assign_list["city_filter_id"] = $city_filter_id;
    }

    $order_by = " order by order_no ASC";
    $totalRecord = $clsTour->getAll($cond, $clsTour->pkey);

    if ($totalRecord) {
        $totalRecord = count($totalRecord);
        $totalTour = $totalRecord;
    } else {
        $totalRecord = 0;
        $totalTour = 0;
    }
    if ($country_id) {
        $link_page = $clsTourCategory->getLinkCatCountry($cat_id, $country_id, $oneItem);
    } else {
        $link_page = $clsTourCategory->getLink($cat_id, $oneItem);
    }

    $assign_list['linksort'] = $clsTourCategory->getLinkCatTour($cat_id, 0, true, $oneItem);
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
    //print_r($cond.$order_by.$limit);die();
    $listTour = $clsTour->getAll($cond . $order_by . $limit, $clsTour->pkey . ",departure_point_id,slug,title,image,duration_type,duration_custom,number_day,number_night");
    if (!$listTour && $currentPage > 1) {
        header("Location: " . $link_page);
        exit();
    }

    $assign_list['totalTour'] = $totalTour;
    $assign_list['listTour'] = $listTour;
    unset($listTour);
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();
    $assign_list['totalRecord'] = $totalRecord;


    $lstclsCategory_Country = $clsCategory_Country->getAll("is_trash=0 and is_online=1 and cat_id='$cat_id' and country_id = '$country_id' limit 0,1", $clsCategory_Country->pkey . ',content');
    $assign_list['lstclsCategory_Country'] = $lstclsCategory_Country;

    $category_country__id = $lstclsCategory_Country[0]['category_country_id'];
    $assign_list['category_country__id'] = $category_country__id;
    $assign_list['catCountryItem'] = $lstclsCategory_Country[0];

    $title_cat = $oneItem['title'];
    $assign_list['title_cat'] = $title_cat;
    /* =============Title & Description Page================== */
    $title_page = $title_cat . ' | ' . $core->get_Lang('travelstyles') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($cat_id, 'TourCategory', $oneItem);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cat_id, 'TourCategory', $oneItem);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /* =============Content Page================== */
    unset($clsTourCategory);
    unset($clsTour);
}
function default_cat()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $show, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $extLang, $cat_id, $country_id, $clsConfiguration, $clsISO, $deviceType;
    global $min_duration_value, $max_duration_value, $min_price_value, $max_price_value, $min_duration_search, $max_duration_search;
    #

    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list['clsTourStore'] = $clsTourStore;
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsPagination = new Pagination();
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsCategory_Country = new Category_Country();
    $assign_list['clsCategory_Country'] = $clsCategory_Country;
    $clsCityStore = new CityStore();
    $assign_list['clsCityStore'] = $clsCityStore;
    $clsReview = new Reviews();
    $assign_list["clsReview"] = $clsReview;

    $clsPromotion = new Promotion();
    $assign_list['clsPromotion'] = $clsPromotion;
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $assign_list['action'] = $action;
    #
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    //    $cat_id = $clsTourCategory->getBySlug($slug);
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
    if ($cat_id == '') {
        header('location:' . PCMS_URL);
    }
    $assign_list["cat_id"] = $cat_id;

    $oneItem = $clsTourCategory->getOne($cat_id, $clsTourCategory->pkey . ',slug,title,intro');
    $assign_list["oneItem"] = $oneItem;

    if ($show == 'CatCountry') {
        $slug_country = $_GET['slug_country'];
        $country_id = $clsCountry->getBySlug($slug_country);
        $assign_list["country_id"] = $country_id;
    }

    if ($deviceType == 'tablet') {
        $recordPerPage = 14;
    } else {
        $recordPerPage = 15;
    }

    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $cond = "is_trash=0 and is_online=1";
    $cond2 = "is_trash=0 and is_online=1";

    if ($cat_id > 0) {
        $listTourCategory = $clsTourCategory->getAll("is_trash=0 and is_online=1 and parent_id='$cat_id'", $clsTourCategory->pkey);
        if ($listTourCategory != '') {
            $parent_id = $cat_id;
            $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%' or cat_id IN (SELECT tourcat_id FROM " . DB_PREFIX . "tour_category WHERE parent_id = '$parent_id'))";
        } else {
            $cond .= " and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
        }
    }
    if ($country_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id')";
    }

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $city_filter_id = isset($_GET['city_filter_id']) ? $_GET['city_filter_id'] : 0;
    $country_filter_id = isset($_GET['country_filter_id']) ? $_GET['country_filter_id'] : 0;
    $departure_point_id = isset($_GET['departure_point_id']) ? $_GET['departure_point_id'] : 0;


    $listTourMaxMin = $clsTour->getAll($cond, "max(number_day) as max,min(number_day) as min");
    $min_duration_value = $listTourMaxMin[0]['min'];
    $max_duration_value = $listTourMaxMin[0]['max'];


    $listpriceMaxMin = $clsTour->getAll($cond, "max(min_price) as max,min(min_price) as min");
    $min_price_value = $listpriceMaxMin[0]['min'];
    $max_price_value = $listpriceMaxMin[0]['max'];


    $orderBy = " order by order_no asc";
    if ($deviceType == 'tablet') {
        $recordPerPage = 14;
    } else {
        $recordPerPage = 15;
    }
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

    if (!empty($departure_point_id)) {
        $departure_point_ID = explode(',', $departure_point_id);
        $cond .= " and (";
        for ($i = 0; $i < count($departure_point_ID); $i++) {
            if ($i == 0 && count($departure_point_ID) == 1) {
                $cond .= " (departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            } elseif (count($departure_point_ID) > 1 && $i < (count($departure_point_ID) - 1)) {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%') or ";
            } else {
                $cond .= "(departure_point_id='" . $departure_point_ID[$i] . "' or list_departure_point_id like '%|" . $departure_point_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
        $assign_list["departure_point_id"] = $departure_point_id;
    }

    $min_duration_search = isset($_GET['min_duration']) ? $_GET['min_duration'] : $min_duration_value;
    $max_duration_search = isset($_GET['max_duration']) ? $_GET['max_duration'] : $max_duration_value;

    $min_duration_query = isset($_GET['min_duration']) ? $_GET['min_duration'] : '';
    $max_duration_query = isset($_GET['max_duration']) ? $_GET['max_duration'] : '';

    $assign_list['min_duration_value'] = $min_duration_value ? $min_duration_value : 0;
    $assign_list['max_duration_value'] = $max_duration_value ? $max_duration_value : 0;

    $assign_list["min_duration_search"] = $min_duration_search ? $min_duration_search : 0;
    $assign_list["max_duration_search"] = $max_duration_search ? $max_duration_search : 0;

    if ($min_duration_query > 0 && $max_duration_query > 0) {
        $cond .= " and number_day >='$min_duration_query' and number_day <='$max_duration_query'";
    } elseif ($min_duration_query == 0 && $max_duration_query > 0) {
        $cond .= " and number_day <='$max_duration_query'";
    } elseif ($min_duration_query > 0 && $max_duration_query == 0) {
        $cond .= " and number_day >='$min_duration_query'";
    }


    $min_price_search = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price_value;
    $max_price_search = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price_value;

    $min_price_query = isset($_GET['min_price']) ? $_GET['min_price'] : '';
    $max_price_query = isset($_GET['max_price']) ? $_GET['max_price'] : '';

    $assign_list["min_price_value"] = $min_price_value ? $min_price_value : 0;
    $assign_list["max_price_value"] = $max_price_value ? $max_price_value : 0;

    $assign_list["min_price_search"] = $min_price_search ? $min_price_search : 0;
    $assign_list["max_price_search"] = $max_price_search ? $max_price_search : 0;


    if ($min_price_query > 0 && $max_price_query > 0) {
        $cond .= " and min_price >='$min_price_query' and min_price <='max_price_query'";
    } elseif ($min_price_query == 0 && $max_price_query > 0) {
        $cond .= " and min_price <='$max_price_query'";
    } elseif ($min_price_query > 0 && $max_price_query == 0) {
        $cond .= " and min_price >='$min_price_query'";
    }

    if (!empty($country_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_filter_id))";
        $assign_list["country_filter_id"] = $country_filter_id;
    }

    if (!empty($city_filter_id)) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_filter_id))";
        $assign_list["city_filter_id"] = $city_filter_id;
    }

    $order_by = " order by order_no ASC";

    //	print_r($cond);die();
    $totalRecord = $clsTour->getAll($cond, $clsTour->pkey);

    if ($totalRecord) {
        $totalRecord = count($totalRecord);
        $totalTour = $totalRecord;
    } else {
        $totalRecord = 0;
        $totalTour = 0;
    }
    if ($country_id) {
        $link_page = $clsTourCategory->getLinkCatCountry($cat_id, $country_id, $oneItem);
    } else {
        $link_page = $clsTourCategory->getLink($cat_id, $oneItem);
    }

    $assign_list['linksort'] = $clsTourCategory->getLinkCatTour($cat_id, 0, true, $oneItem);
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
    //print_r($cond.$order_by.$limit);die();
    $listTour = $clsTour->getAll($cond . $order_by . $limit, $clsTour->pkey . ",departure_point_id,slug,title,image,duration_type,duration_custom,number_day,number_night");
    if (!$listTour && $currentPage > 1) {
        header("Location: " . $link_page);
        exit();
    }


    $assign_list['totalTour'] = $totalTour;
    $assign_list['listTour'] = $listTour;
    unset($listTour);
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();
    $assign_list['totalRecord'] = $totalRecord;


    $lstclsCategory_Country = $clsCategory_Country->getAll("is_trash=0 and is_online=1 and cat_id='$cat_id' and country_id = '$country_id' limit 0,1", $clsCategory_Country->pkey . ',content');
    $assign_list['lstclsCategory_Country'] = $lstclsCategory_Country;

    $category_country__id = $lstclsCategory_Country[0]['category_country_id'];
    $assign_list['category_country__id'] = $category_country__id;
    $assign_list['catCountryItem'] = $lstclsCategory_Country[0];

    $title_cat = $oneItem['title'];
    $assign_list['title_cat'] = $title_cat;
    /* =============Title & Description Page================== */
    $title_page = $title_cat . ' | ' . $core->get_Lang('travelstyles') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($cat_id, 'TourCategory', $oneItem);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cat_id, 'TourCategory', $oneItem);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /* =============Content Page================== */
    unset($clsTourCategory);
    unset($clsTour);
}

function default_detaildeparture()
{
    global $assign_list, $clsISO, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $tour_id;
    #
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsCategory = new Category();
    $assign_list["clsCategory"] = $clsCategory;
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsTourItinerary = new TourItinerary();
    $assign_list['clsTourItinerary'] = $clsTourItinerary;
    $clsTourImage = new TourImage();
    $assign_list["clsTourImage"] = $clsTourImage;
    $clsTourDestination = new TourDestination();
    $assign_list["clsTourDestination"] = $clsTourDestination;
    $clsTourStartDate = new TourStartDate();
    $assign_list['clsTourStartDate'] = $clsTourStartDate;

    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsTourExtension = new TourExtension();
    $assign_list["clsTourExtension"] = $clsTourExtension;
    $clsTransport = new Transport();
    $assign_list["clsTransport"] = $clsTransport;
    $clsWhy = new Why();
    $assign_list["clsWhy"] = $clsWhy;

    $clsTable = 'Tour';
    $assign_list["clsTable"] = $clsTable;
    #
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    $tour_slug_id = $clsTour->getBySlug($slug);
    $tour_id = $_GET['tour_id'] ? $_GET['tour_id'] : '0';
    //print_r($tour_slug_id.'xxx'.$tour_id); die();
    if ($tour_slug_id != $tour_id || $clsTour->checkExitsId($tour_id) == '0') {
        header('location:' . PCMS_URL);
        exit();
    }

    $assign_list["tour_id"] = $tour_id;

    $table_id = $tour_id;
    $assign_list["table_id"] = $table_id;

    $oneItem = $clsTour->getOne($tour_id);
    $assign_list["oneItem"] = $oneItem;
    $tourcat_id = $oneItem['cat_id'];

    if ($oneItem['is_online'] == 0) {
        header('location:' . PCMS_URL);
        exit();
    }

    $assign_list["tourcat_id"] = $tourcat_id;
    $departure_point_id = $oneItem['departure_point_id'];
    $assign_list["departure_point_id"] = $departure_point_id;

    # Why with us
    $lstWhyWUs = $clsWhy->getAll("is_trash=0 order by order_no desc");
    $assign_list["lstWhyWUs"] = $lstWhyWUs;

    #- Image Tours
    $lstImage = $clsTourImage->getAll("is_trash=0 and table_id='$tour_id' and image<>'' order by order_no ASC", $clsTourImage->pkey);
    $assign_list["lstImage"] = $lstImage;
    unset($lstImage);

    #- Itinerary
    $lstItineraryTour = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' and title_contingency='' order by order_no asc", $clsTourItinerary->pkey . ',image,content,tour_itinerary_id,transport,is_show_image,day,day2');
    $assign_list['lstItineraryTour'] = $lstItineraryTour;
    unset($lstItineraryTour);


    #- Custom Field
    $clsTourCustomField = new TourCustomField();
    $assign_list["clsTourCustomField"] = $clsTourCustomField;
    $listCustomField = $clsTourCustomField->getAll("tour_id='$tour_id' and fieldtype='CUSTOM' order by order_no ASC");
    $assign_list["listCustomField"] = $listCustomField;
    unset($listCustomField);

    #
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsTourHotel = new TourHotel();
    $assign_list['clsTourHotel'] = $clsTourHotel;

    #
    $lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
    $assign_list["lstNationality"] = $lstNationality;
    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");
    $assign_list["lstVisitorType"] = $lstVisitorType;

    #-- Tour Related
    $lstTourRelated = array();
    $lstTourExtension = $clsTourExtension->getAll("is_trash=0 and tour_1_id='$tour_id' and tour_2_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1) order by order_no asc", "tour_2_id");
    $lstTourRelated = array();
    if (!empty($lstTourExtension)) {
        foreach ($lstTourExtension as $item) {
            $oneTmp = $clsTour->getOne($item['tour_2_id']);
            if ($tour_id != $item['tour_2_id'])
                $lstTourRelated[] = $oneTmp;
        }
    }
    $assign_list['lstTourRelated'] = $lstTourRelated;

    //print_r($lstTourRelated); die();

    $clsTourStartDate = new TourStartDate();
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $lstCityTours = $clsCity->getAll("is_trash=0 and is_online=1 and city_id IN (SELECT city_id FROM " . DB_PREFIX . "tour_destination) order by order_no desc");
    $assign_list['lstCityTours'] = $lstCityTours;
    #print_r($lstCityTours);die();
    unset($lstCityTours);

    $lstDestination = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
    #
    if (!empty($lstDestination)) {
        $cond = "is_trash=0";
        $tmp = array();
        foreach ($lstDestination as $k => $v) {
            if (!in_array($v['city_id'], $tmp)) {
                $tmp[] = $v['city_id'];
            }
        }
        if (!empty($tmp)) {
            $query_in = implode(',', $tmp);
            $cond .= " and hotel_id IN (SELECT hotel_id FROM " . DB_PREFIX . "hotel WHERE city_id IN (" . $query_in . "))";
        }
        #
        $cond .= " order by order_no desc limit 0,6";

        $lstHotelRelated = $clsHotel->getAll($cond);
        $assign_list['lstHotelRelated'] = $lstHotelRelated;
        unset($lstGuideRelated);
    }


    if (isset($_POST['Hid']) && $_POST['Hid']) {
        $BOOK_VALUE = array();
        foreach ($_POST as $k => $v) {
            $BOOK_VALUE[$k] = $v;
        }
        vnSessionSetVar('BOOK_VALUE', $BOOK_VALUE);
        header('Location:' . $clsTour->getLinkBookExtra($tour_id));
        exit();
    }
    $listMonth = array();
    $now = time();
    $month = date('m', $now);
    $year = date('Y', $now);
    $year_next = ($year + 1);
    $month_next = 12;

    for ($i = intval($month); $i <= 12; $i++) {
        $listMonth[] = array(
            'month' => ($i < 10) ? '0' . $i : $i,
            'year' => $year
        );
    }
    for ($i = 1; $i < intval($month); $i++) {
        $listMonth[] = array(
            'month' => $i ? '0' . $i : $i,
            'year' => ($year + 1)
        );
    }
    for ($m = 1; $m < 3; $m++) {
        for ($i = intval($month); $i <= 12; $i++) {
            $listMonth[] = array(
                'month' => ($i < 10) ? '0' . $i : $i,
                'year' => $year + $m
            );
        }
        for ($i = 1; $i < intval($month); $i++) {
            $listMonth[] = array(
                'month' => $i ? '0' . $i : $i,
                'year' => ($year + $m + 1)
            );
        }
    }

    $check_tour_departure = $clsTourStore->checkExist($tour_id, "DEPARTURE");
    $assign_list["check_tour_departure"] = $check_tour_departure;
    $assign_list["listMonth"] = $listMonth;

    $start_date = '01/01/' . $year;
    $end_date = '12/31/' . $year;
    $start_date2 = '01/01/' . $year_next;
    $end_date2 = '12/31/' . $year_next;

    $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '" . time() . "' and tour_id ='$tour_id' and start_date >= '" . strtotime($start_date) . "' and start_date <= '" . strtotime($end_date) . "'" . " order by start_date ASC");
    $assign_list["lstTourStartDate"] = $lstTourStartDate;
    //print_r($lstTourStartDate); die();
    $lstTourStartDate2 = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '" . time() . "' and tour_id ='$tour_id' and start_date >= '" . strtotime($start_date2) . "' and start_date <= '" . strtotime($end_date2) . "'" . " order by start_date ASC");


    $assign_list["lstTourStartDate2"] = $lstTourStartDate2;
    if (isset($_POST['BookingTour']) && $_POST['BookingTour'] == 'BookingTour') {
        $link = $clsTour->getLinkBookEn($tour_id);
        foreach ($_POST as $key => $val) {
            $link .= ($key == 'BookingTour') ? '' : '&' . $key . '=' . ($val != '' ? addslashes($val) : '0');
            $link = str_replace('&amp;', '&', $link);
        }
        vnSessionSetVar('Link_login_book', $link);
        header('location:' . $link);
        exit();
    }
    //	$aaaa = $clsTour->getPromotionIdPro($tour_id,'Tour');
    //	var_dump($aaaa);die();
    /*=============Title & Description Page==================*/
    $title_page = $clsTour->getTitle($tour_id) . ' | ' . $core->get_Lang('tours') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($tour_id, 'Tour');
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($tour_id, 'Tour');
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    $clsTour->updateMinPriceTour($tour_id);
}

function default_loadReview()
{
    global $assign_list, $_CONFIG, $core, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO, $_lang, $extLang, $_LANG_ID, $clsISO;
    #
    $page = isset($_POST['page_Review']) ? $_POST['page_Review'] : 0;
    $tour_id = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;

    if ($page > 0 and $tour_id > 0) {
        $pageview = $page + 1;
        $limit_start = $page * 5;
        $limit_end = $pageview * 5 + 1;
        $cond = "is_trash=0 and is_online=1 and table_id = '$tour_id' order by order_no DESC limit $limit_start , $limit_end ";
        $clsTour_Review = new TourReview();
        $arraylstReview = $clsTour_Review->getAll($cond, $clsTour_Review->pkey . ' , review_date');

        if ($clsTour_Review->countItem($cond) < 5) {
            $pageview = 'NoNo';
        }
        $Html = '';
        if (!empty($arraylstReview)) {
            $stt = 0;
            foreach ($arraylstReview as $lstReview) {
                if ($stt++ < 6) {
                    $Html .= '<li class="item">
		  <div class="block-rate-num text-center">
			  <label class="rate-number text-normal">
			  ' . $clsTour_Review->getRates($lstReview[$clsTour_Review->pkey]) . '</label>
			  <p class="cus-rate">
				  <strong class="block z_12">
				  ' . $clsTour_Review->getFullName($lstReview[$clsTour_Review->pkey]) . '
				  ,</strong>
				  <span class="z_10 block c6">
				  ' . $clsTour_Review->getCountry($lstReview[$clsTour_Review->pkey]) . '
				 ,</span>
				  <span class="z_10 block c6">
				  ' . $clsISO->converTimeToText($lstReview['review_date']) . '
				  </span>
			  </p>
		  </div>
		  <div class="cus-desc">
			  <h5 class="z_14 text-bold text-uppercase c2a">
			  ' . $clsTour_Review->getTitle($lstReview[$clsTour_Review->pkey]) . '</h5>
			  <div class="review-content">				
				  ' . html_entity_decode($clsTour_Review->getContent($lstReview[$clsTour_Review->pkey])) . '
			  </div>			                     
		  </div>
		  </li>';
                }
            }
        }
        echo $Html . '$$$' . $pageview;
        die();
    }
}

function default_bookgroup_2020()
{
    vnSessionDelVar('rq_link');
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $adult, $child, $infant;
    global $clsISO, $clsConfiguration, $profile_id, $loggedIn, $agent_id, $adult_type_id, $child_type_id, $infant_type_id;
    #
    if (_ISOCMS_CLIENT_LOGIN == '2') {
        if (!$loggedIn) {
            $link = $extLang . '/account/signin/r=' . $_SERVER['REQUEST_URI'];
            header('Location:' . $link);
            exit();
        }
    }
    $cartSessionService = vnSessionGetVar('BookingTour');
    $cartSessionService = array_merge($cartSessionService);
    $assign_list['cartSessionService'] = $cartSessionService;

    $totalGrand = 0;
    $price_deposit = 0;
    $price_remaining = 0;
    $total_price = 0;

    if (!empty($cartSessionService)) {
        for ($i = 0; $i < count($cartSessionService); $i++) {
            $totalGrand += $cartSessionService[$i]['total_price_z'];
            $tour_id = $cartSessionService[$i]['tour_id_z'];
        }
    }
    $cartSessionPackage = array();
    $totalRemaining = $totalGrand - $price_deposit;

    $assign_list["cartSessionService"] = $cartSessionService;
    $assign_list["number_tour_id"] = $number_tour_id;

    $assign_list["totalRemaining"] = $totalRemaining;
    $assign_list["totalGrand"] = $totalGrand;
    $assign_list["departure_date"] = $departure_date;
    $assign_list["totalRoom"] = $totalRoom;
    $assign_list["price_remaining"] = $price_remaining;
    $assign_list["price_deposit"] = $price_deposit;

    //	print_r($cartSessionService);die();

    #
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourService = new TourService();
    $assign_list["clsTourService"] = $clsTourService;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsCountryBK = new _Country();
    $assign_list["clsCountryBK"] = $clsCountryBK;
    $lstCountry = $clsCountryBK->getAll("is_trash=0 order by order_no asc", $clsCountryBK->pkey);
    $assign_list["lstCountry"] = $lstCountry;
    unset($lstCountry);
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;
    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;
    $clsVoucher = new Voucher();
    $assign_list['clsVoucher'] = $clsVoucher;
    $clsPromotion = new Promotion();
    $assign_list['clsPromotionr'] = $clsPromotion;
    #
    $lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
    $assign_list["lstNationality"] = $lstNationality;
    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");
    $assign_list["lstVisitorType"] = $lstVisitorType;

    $listService = $clsTourService->getAll('is_trash=0 and is_online=1 order by order_no ASC');
    $assign_list["listService"] = $listService;

    #- Verify Captcha


    if (isset($_POST['booking']) && $_POST['booking'] == 'booking') {
        if (_ISOCMS_CAPTCHA == 'IMG') {
            $security_code = isset($_POST["security_code"]) ? trim($_POST["security_code"]) : '';
            $security_code = strtoupper($security_code);
            if ($security_code == '') {
                $err_msg .= '&bull; ' . $core->get_Lang('Please enter security code') . ' <br />';
            }
            if (!empty($security_code) && $security_code != $_SESSION['skey']) {
                $err_msg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        } else {
            if (!$clsISO->checkGoogleReCAPTCHA()) {
                $err_msg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        }
        $departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
        $num_day = $clsTour->getOneField('number_day', $tour_id);
        $end_date = date('m/d/Y', strtotime('+' . $num_day . ' day', strtotime($departure_date)));

        $first_name = $_POST['first_name'];
        if ($first_name == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your first name') . ' <br />';
        }
        $last_name = $_POST['last_name'];
        if ($last_name == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your last name') . ' <br />';
        }
        $email = $_POST['email'];
        if ($email == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your email') . ' <br />';
        }
        if ($email != '' && !$clsISO->is_valid_email($email)) {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your email valid') . ' <br />';
        }
        $telephone = $_POST['telephone'];
        if ($telephone == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your telephone') . ' <br />';
        }
        #
        if ($err_msg == '') {
            if (_ISOCMS_CLIENT_LOGIN == '2') {
                if (empty($profile_id)) {
                    $res = $clsProfile->getAll("email = '$email' limit 0,1", $clsProfile->pkey);
                    if (!empty($res)) {
                        $profile_id = $res[0]['profile_id'];
                        header('location: ' . DOMAIN_NAME . $extLang . '/account/signin.html');
                        exit();
                    } else {
                        $profile_id = $clsProfile->getMaxID();
                        $password = substr(strtoupper($clsProfile->encrypt('VietISO-' . time())), 0, 8);
                        $userpass = $clsProfile->encrypt($password);
                        #
                        $full_name = $first_name . ' ' . $last_name;
                        $fx = "$clsProfile->pkey,email,username,userpass,full_name,full_name_slug,ip_register,reg_date";
                        $vx = "'" . $profile_id . "','" . $email . "','" . $email . "','" . $userpass . "','" . $full_name . "','" . $core->replaceSpace($full_name) . "','" . $_SERVER['REMOTE_ADDR'] . "','" . time() . "'";
                        if ($clsProfile->insertOne($fx, $vx)) {
                            $clsProfile->sendEmailRegisterMember($profile_id, $password);
                        }
                    }
                }
            }
            $booking_id = $clsBooking->getMaxId();
            $booking_code = $clsBooking->generateBookingCode($booking_id, 'Tour');
            #
            $full_name = $first_name . ' ' . $last_name;
            $f = "booking_id,target_id,title,contact_name,full_name,country_id,phone,email,take_care";
            $f .= ",clsTable,booking_code,booking_store,booking_type,reg_date,ip_booking,check_in,check_out,departure_date,totalgrand,deposit,balance";
            $POST = array();
            foreach ($_POST as $k => $v) {
                $POST[$k] = $v;
            }
            $POST['BOOK_VALUE'] = serialize($BOOK_VALUE);
            $POST['BOOK_ADDON'] = serialize($BOOK_ADDON);
            #
            $v = "'$booking_id'
			,'" . $tour_id . "'
			,'" . $_POST['title'] . "'
			,'" . $full_name . "'
			,'" . $full_name . "'
			,'" . $_POST['country_id'] . "'
			,'" . $_POST['telephone'] . "'
			,'" . $email . "'
			,'" . $_POST['please'] . "'
			,'Tour'
			,'$booking_code'
			,'" . serialize($POST) . "'
			,'Tour','" . time() . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . $departure_date . "'
			,'" . $end_date . "'
			,'" . strtotime($departure_date) . "'
			,'" . $clsISO->processFloatNumber(str_replace('.00', '', $_POST['price_total_amount'])) . "'
			,'" . $_POST['price_deposit'] . "' 
			,'" . $clsISO->processFloatNumber(str_replace('.00', '', $_POST['price_remaining'])) . "'";
            #
            if (PAYMENT_GLOBAL) {
                $f .= ",payment_method";
                $v .= ",'" . intval($_POST['payment_method']) . "'";
            }
            if (_ISOCMS_CLIENT_LOGIN) {
                $f .= ",member_id";
                $v .= ",'$profile_id'";
            }
            if (_IS_TRAVEL_AGENT) {
                $f .= ",agent_id";
                $v .= ",'$agent_id'";
            }

            //			$clsISO->print_pre($_POST['voucher_code'],true);die();
            if ($clsBooking->insertOne($f, $v)) {
                $link_request = $_SERVER['REQUEST_URI'];
                vnSessionSetVar('rq_link', $link_request);
                if ($_POST['voucher_code']) {
                    $f1 = "first_name,last_name,promotion_code,`email`,`ip`,reg_date,is_trash";
                    $v1 = "'" . $first_name . "','" . $last_name . "','" . $_POST['voucher_code'] . "','" . $email . "','" . $_SERVER['REMOTE_ADDR'] . "'," . time() . ",0";
                    $clsVoucher->insertOne($f1, $v1);
                    $promotion_id = $clsPromotion->getByPromotionCode($_POST['voucher_code']);
                    $ticket = $clsPromotion->getDiscountValue($promotion_id, 2) - 1;
                    $discount_val_new = $clsPromotion->getUpdateDiscountValueTicket($promotion_id, $ticket);
                    $clsPromotion->updateOne($promotion_id, "discount_value='" . $discount_val_new . "'");
                }
                $clsBooking->sendEmailBookingTour2018($booking_id);
                if (PAYMENT_GLOBAL) {
                    $clsBilling = new Billing();
                    $clsBilling->initPay($booking_id);
                }
                header('location:' . $extLang . '/booking/tours/successful');
            } else {
                header('location:' . $extLang . '/booking/tours/error');
            }
        } else {
            $assign_list["err_msg"] = $err_msg;
            foreach ($_POST as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Booking Tour') . ' | ' . $oneItem['title'] . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_ajaxAddTourToCart()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $tour_id;


    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);

    if (empty($cartSessionService)) {
        $cartSessionService = array();
    }
    $assign_list["BookingTour"] = $cartSessionService;

    $tp = $_POST['tp'];
    $tour_id_z = $_POST['tour_id'];
    if ($tp == 'DEL_PACKAGE') {
        unset($cartSessionService[$_LANG_ID][$tour_id_z]);

        vnSessionSetVar('BookingTour_' . $_LANG_ID, $cartSessionService);
        $exist = '_REMOVE';
    } else {
        $cartSessionService[$_LANG_ID][$tour_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionService[$_LANG_ID][$tour_id][$k] = $v;
        }
        vnSessionSetVar('BookingTour_' . $_LANG_ID, $cartSessionService);
        $exist = '_SUCCESS';
    }


    echo $exist;
    die();
}

function default_customize()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang;
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $slug = $_GET['slug'];
    $tour_id = $clsTour->getBySlug($slug);
    if ($tour_id == '') {
        header('location:' . PCMS_URL . $extLang);
    }
    vnSessionSetVar('CUSTOMIZE_TOUR_ID', $tour_id);
    header('location:' . PCMS_URL . $extLang . '/tours/customize-tour/form.html');
}

function default_search()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $country_id, $city_id, $price_range_ID, $duration_ID, $cat_id;

    #
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list['clsTourStore'] = $clsTourStore;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsTransport = new Transport();
    $assign_list['clsTransport'] = $clsTransport;
    $clsReviews = new Reviews();
    $assign_list['clsReviews'] = $clsReviews;
    $clsPromotion = new Promotion();
    $assign_list['clsPromotion'] = $clsPromotion;
    $clsPriceRange = new PriceRange();
    $assign_list['clsPriceRange'] = $clsPriceRange;
    $clsPagination = new Pagination();
    #
    $destination_ID = isset($_GET['destination_ID']) ? $_GET['destination_ID'] : '';
    if (!empty($destination_ID)) {
        if (substr($destination_ID, 0, 1) == '0') {
            $country_id = (int)str_replace('0', '', $destination_ID);
        } else {
            $city_id = (int)$destination_ID;
        }
    }
    if ($destination_ID == '') {
        $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
        $city_id = isset($_GET['city__id']) ? $_GET['city__id'] : '';
    }
    //print_r($city_id); die();
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';

    $min_duration = isset($_GET['min_duration']) ? $_GET['min_duration'] : '';
    $max_duration = isset($_GET['max_duration']) ? $_GET['max_duration'] : '';
    $activities_id = isset($_GET['activities_id']) ? $_GET['activities_id'] : '';
    $price_range_id = isset($_GET['price_range_id']) ? $_GET['price_range_id'] : '';
    $destination_id = isset($_GET['destination_id']) ? $_GET['destination_id'] : '';
    $duration_id = isset($_GET['duration_id']) ? $_GET['duration_id'] : '';
    $departure_point_id = isset($_GET['departure_point_id']) ? $_GET['departure_point_id'] : '';

    $keyword = (isset($_GET['key']) && !empty($_GET['key'])) ? $_GET['key'] : '';

    $recordPerPage = 6;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    #
    $cond = "is_trash=0 and is_online=1";
    $order_by = " order by order_no asc";
    #pagevieew

    if (intval($departure_point_id) > 0) {
        $cond .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
        $assign_list["departure_point_id"] = $departure_point_id;
    }

    if ($country_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
        $assign_list["country_id"] = $country_id;
    }
    if ($destination_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id = '$destination_id')";
        $assign_list["destination_id"] = $destination_id;
    }

    if ($city_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_id))";
        $assign_list["city_id"] = $city_id;
    }
    if (!empty($cat_id)) {
        $cat_ID = explode(',', $cat_id);
        $cond .= " and (";
        for ($i = 0; $i < count($cat_ID); $i++) {
            if ($i == 0 && count($cat_ID) == 1) {
                $cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            } elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
            } else {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
    }

    $assign_list["cat_id"] = $cat_id;
    if (!empty($activities_id)) {
        $activities_ID = explode(',', $activities_id);
        $cond .= " and (";
        for ($i = 0; $i < count($activities_ID); $i++) {
            if ($i == 0 && count($activities_ID) == 1) {
                $cond .= " list_activities_id like '%" . $activities_ID[$i] . "%'";
            } elseif (count($activities_ID) > 1 && $i < (count($activities_ID) - 1)) {
                $cond .= " list_activities_id like '%|" . $activities_ID[$i] . "|%' or ";
            } else {
                $cond .= " list_activities_id like '%|" . $activities_ID[$i] . "|%'";
            }
        }
        $cond .= ")";
    }

    //print_r($cond);die();
    $assign_list["activities_id"] = $activities_id;

    if ($min_duration > 0 && $max_duration > 0) {
        $cond .= " and number_day >= '$min_duration' and number_day <= '$max_duration'";
    } elseif ($min_duration == 0 && $max_duration > 0) {
        $cond .= " and number_day <= '$max_duration'";
    } elseif ($min_duration > 0 && $max_duration == 0) {
        $cond .= " and number_day >= '$min_duration'";
    } else {
    }
    $assign_list['min_duration'] = $min_duration;
    $assign_list['max_duration'] = $max_duration;

    if (!empty($duration_id)) {
        $cond .= " and number_day='$duration_id'";
        $assign_list["duration_id"] = $duration_id;
    }
    //print_r($cond); die();

    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
        $assign_list["keyword"] = $keyword;
    }


    $totalRecord = $clsTour->getAll($cond);
    $totalRecord = $totalRecord ? count($totalRecord) : '0';
    //print_r($totalRecord);die();

    $assign_list['totalRecord'] = $totalRecord;

    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);

    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    $listTour = $clsTour->getAll($cond . $order_by . $limit, $clsTour->pkey);
    $assign_list['listTour'] = $listTour;
    unset($listTour);
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    $totalPage = $clsPagination->getTotalPage();
    $assign_list['totalPage'] = $totalPage;

    unset($clsPriceRange);
    unset($clsCity);
    unset($clsTour);

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Results search') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_ajLoadBookingSummary()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
    global $clsISO;
    #
    $clsTour = new Tour();
    $clsTourService = new TourService();
    $tour_id = intval($_POST['tour_id']);

    $BOOK_VALUE = vnSessionGetVar('BOOK_VALUE');

    $tourRate = $clsTour->getTripPriceOrgin($tour_id);
    $totalRate = 0;
    $totalRate += $tourRate * intval($BOOK_VALUE['adult']);
    $totalRate += $tourRate * intval($BOOK_VALUE['child']);
    $totalRate += $tourRate * intval($BOOK_VALUE['baby']);
    #
    $Html = '
	<div class="box">
		<div class="top"> <h2>Booking Details</h2> </div>
		<div class="mid">
			<ul>
				<li><strong>' . $clsTour->getTitle($tour_id) . ' | ' . $clsTour->getTripDuration($tour_id) . '</strong></li>
				<li><label class="col1">Depart time :</label>
					<span class="subli col2">' . $BOOK_VALUE['departure_date'] . '</span></li>
				<li><label class="col1">Adult(s) :</label>
					<span class="subli col2">x ' . $BOOK_VALUE['adult'] . '</span> <span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($tourRate) . '</span> </li>
				<li><label class="col1">Children(s) :</label>
					<span class="subli col2">x ' . $BOOK_VALUE['child'] . '</span> <span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($tourRate) . '</span></li>
				<li><label class="col1">Bady(s) :</label>
					<span class="subli col2">x ' . $BOOK_VALUE['baby'] . '</span> <span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($tourRate) . '</span></li>
			</ul>
		</div>
	</div>';
    $BOOK_ADDON = vnSessionGetVar('BOOK_ADDON');
    if (is_array($BOOK_ADDON) && count($BOOK_ADDON) > 0) {
        $Html .= '
		<div class="box">
			<div class="top"> <h2>Booking AddOns Services</h2> </div>
			<div class="mid">
				<ul>';
        foreach ($BOOK_ADDON as $k => $v) {
            $Html .= '
					<li>
						<span class="col1">' . $clsTourService->getTitle($k) . '</span> 
						<span class="subli col2">x ' . $v . '</span>
						<span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($clsTourService->getPriceOrgin($k) * $v) . '</span>
					</li>';
            #
            $totalRate += $clsTourService->getPriceOrgin($k) * $v;
        }
        $Html .= '</ul>
			</div>
		</div>';
    }
    $Html .= '
	<div class="box">
		<div class="top"> <h2>Price total</h2> </div>
		<div class="mid">
			<ul class="costing">
				<li class="full">Full Payment<span class="detail">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($totalRate) . '</span></li>
				<li class="discount">Discount<span class="detail">' . $clsISO->getRate() . '0</span></li>
				<li class="total">Total Price<span class="detail">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($totalRate) . '</span></li>
			</ul>
	   </div>
	</div>
	<input type="hidden" name="totalRate" value="' . $clsISO->processSmartNumber($totalRate) . '" />';
    #
    echo ($Html);
    die();
}

function default_loadPriceTableDepartureGroup()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $adult, $child, $infant, $adult_type_id, $child_type_id, $infant_type_id;
    global $clsISO;


    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $clsTourPriceGroup = new TourPriceGroup();
    $assign_list["clsTourPriceGroup"] = $clsTourPriceGroup;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $tour_id = intval($_POST['tour_id']);
    $assign_list["tour_id"] = $tour_id;


    $oneItem = $clsTour->getOne($tour_id);
    $assign_list['oneItem'] = $oneItem;

    $departure_in = isset($_POST['departure_date']) && !empty($_POST['departure_date']) ? $_POST['departure_date'] : '';
    $assign_list["departure_in"] = $departure_in;

    $departure_date = strtotime($departure_in);
    $assign_list['departure_date'] = $departure_date;

    $adult = isset($_POST['adult']) ? intval($_POST['adult']) : 1;
    $assign_list['adult'] = $adult;
    $child = isset($_POST['child']) ? intval($_POST['child']) : 0;
    $assign_list['child'] = $child;
    $infant = isset($_POST['infant']) ? intval($_POST['infant']) : 0;
    $assign_list['infant'] = $infant;


    $Available = $clsTourStartDate->getAllotmentTourGroup2($tour_id, $departure_date, $is_agent);

    $lstAdultSizeGroup = $clsTour->getOneField('adult_group_size', $tour_id);
    $lstAdultSize = array();
    if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
        $TMP = explode(',', $lstAdultSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstAdultSize)) {
                $lstAdultSize[] = $TMP[$i];
            }
        }
    }
    $lastAdultSize = end($lstAdultSize);

    $max_adult = $clsTourOption->getOneField('number_to', $lastAdultSize);
    $max_adult ? $max_adult : 1;
    $assign_list["max_adult"] = $max_adult;

    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = explode(',', $lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child = $clsTourOption->getOneField('number_to', $lastChildSize);
    $assign_list["max_child"] = $max_child;

    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = explode(',', $lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant = $clsTourOption->getOneField('number_to', $lastInfantSize);
    $assign_list["max_infant"] = $max_infant;

    $total_amount = ($price_adult * $adult) + ($price_child * $child) + ($price_infant * $infant);

    $Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$tour_id' and " . $departure_date . " between  start_date and end_date and is_online='1' order by start_date ASC limit 0,1";

    $promotion = $dbconn->GetOne($Sql_Promotion);
    $pricePromotion = ($total_amount * $promotion / 100);

    if ($clsTourStore->checkExist($tour_id, 'DEPARTURE')) {
        $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date='$departure_date' and tour_id='$tour_id' limit 0,1");
        $depositItem = $lstTourStartDate[0]['deposit'];
    } else {
        $lstTourDeposit = $clsTour->getAll("is_trash=0 and is_online=1 and tour_id='$tour_id'");
        $depositItem = $lstTourDeposit[0]['deposit'];
    }

    if ($depositItem > 0) {
        $deposit = $depositItem;
    } else {
        $deposit = 100;
    }
    $assign_list["promotion"] = $promotion;
    $assign_list["pricePromotion"] = $pricePromotion;
    $assign_list["deposit"] = $deposit;
    $assign_list["depositItem"] = $depositItem;
    $price_deposit = ($deposit / 100) * $total_amount;
    $price_deposit = number_format($price_deposit, 2, '.', '');

    $remaining_amount = $total_amount - $price_deposit - $pricePromotion;
    $remaining_amount = number_format($remaining_amount, 2, '.', '');


    $lstNationality = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='NATIONALITY' order by order_no asc");
    $assign_list["lstNationality"] = $lstNationality;

    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no asc");
    $assign_list["lstVisitorType"] = $lstVisitorType;


    $html = $core->build('load_Price_Table_Departure_Group.tpl');
    echo ($html);
    die();
}

function default_getTourPriceByNumberGroup()
{
    global $core, $mod, $act, $clsISO, $_LANG_ID, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id;

    $clsTour = new Tour();
    $clsTourPriceGroup = new TourPriceGroup();
    $clsTourStartDate = new TourStartDate();
    $clsTourProperty = new TourProperty();
    $clsTourOption = new TourOption();
    $clsProperty = new Property();
    $tour_id = $_POST['tour_id'];
    $type = $_POST['type'];
    $number_person = $_POST['number_person'];
    $tour_class_id = $_POST['tour_class_id'];

    $tour_visitor_type_id = $_POST['tour_visitor_type_id'];
    if ($type == 'NoDeparture') {
        $departure_in = 0;
        $departure_date = $departure_in;
    } else {
        $departure_in = $_POST['departure_date'];
        //$departure_date = str_replace('/', '-', $departure_in);
        $departure_date = strtotime($departure_in);
    }
    $assign_list['departure_date'] = $departure_date;

    $lstTourOption = $clsTour->getOneField('tour_option', $tour_id);
    $lstOption = array();
    if ($lstTourOption != '' && $lstTourOption != '0') {
        $TMP = explode(',', $lstTourOption);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstOption)) {
                $lstOption[] = $TMP[$i];
            }
        }
    }
    $tour_number_group_id = $clsTourPriceGroup->getTourNumberGroup($tour_visitor_type_id, $number_person, $tour_id);

    $price = $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_group_id, $tour_visitor_type_id, $departure_date);

    $Available = $clsTourStartDate->getAllotmentTourGroup2($tour_id, $departure_date, $is_agent_id);

    $getTripPrice = $clsTour->getTripMinPriceTourGroup($tour_id);
    if ($getTripPrice > 0) {
        $getTripPrice = '$' . '' . $getTripPrice;
    } else {
        $getTripPrice = '<a class="linkContact">' . $core->get_Lang('Contact us') . '</a>';
    }
    $sql = "tour_id='$tour_id' and price > 0 and tour_visitor_type_id='$adult_type_id' order by price asc limit 0,1";
    $listTourPriceGroup = $clsTourPriceGroup->getAll("tour_id='$tour_id' and price > 0 and tour_visitor_type_id='$adult_type_id' order by price asc limit 0,1");

    $tour_class_id_selected = $listTourPriceGroup[0]['tour_class_id'];

    echo '0|||' . $price . '|||' . $tour_number_group_id . '|||' . $Available . '|||' . $getTripPrice . '|||' . $tour_class_id;
    die();
}


function default_loadStartEndDate()
{
    global $core, $mod, $act, $clsISO, $_LANG_ID, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id;

    $clsTour = new Tour();

    $departure_date = isset($_POST['departure_date']) && !empty($_POST['departure_date']) ? $_POST['departure_date'] : '';
    $departure_date = strtotime($departure_date);

    //print_r($departure_date);die();

    $tour_id = isset($_POST['tour_id']) && !empty($_POST['tour_id']) ? $_POST['tour_id'] : '';

    $start_date_html = $clsISO->getDayOfWeek($departure_date) . ', ' . $clsISO->formatTimeDate($departure_date);

    $end_date = $clsTour->getEndDate($departure_date, $tour_id);
    $start_date_html = $clsISO->getDayOfWeek($departure_date) . ', ' . $clsISO->formatTimeDate($departure_date);
    $end_date_html = $clsISO->getDayOfWeek($end_date) . ', ' . $clsISO->formatTimeDate($end_date);


    $departure_check_promotion = $_POST['departure_date'];
    //$departure_check_promotion = str_replace('/', '-', $departure_check_promotion);
    $departure_check_promotion = strtotime($departure_check_promotion);


    $travel_date = $departure_check_promotion;

    $booking_date = date('m/d/Y');
    $booking_date = strtotime($booking_date);

    $promotion = $clsTour->getMinStartDatePromotionProChoseTime($tour_id, $booking_date, $travel_date);


    echo '0|||' . $start_date_html . '|||' . $end_date_html . '|||' . $promotion;
    die();
}

function default_loadPriceTableDeparture()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $adult, $child, $infant;
}

function default_ajLoadSelectMaxPeople()
{
    global $core, $mod, $act;
    #
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $clsSettingChildPolicy = new SettingChildPolicy();

    #
    $group_size_id = isset($_POST['group_size_id']) ? $_POST['group_size_id'] : 0;
    $number_adult = isset($_POST['number_adult']) ? $_POST['number_adult'] : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $tour_id = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;


    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = explode(',', $lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child = $clsTourOption->getOneField('number_to', $lastChildSize);

    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = explode(',', $lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant = $clsTourOption->getOneField('number_to', $lastInfantSize);

    $maxChild = $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) : 0;
    $maxInfant = $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) : 0;

    #
    $html = '<option value="">' . $core->get_Lang('Select') . '</option>';
    if ($type == 'Child') {
        for ($i = 0; $i <= intval($maxChild); $i++) {
            $html .= '<option value="' . $i . '">' . $i . '</option>';
        }
    } else {
        for ($i = 0; $i <= intval($maxInfant); $i++) {
            $html .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    #
    echo $html;
    die();
}

function default_ajLoadMaxPeople()
{
    global $core, $mod, $act;
    #
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $clsSettingChildPolicy = new SettingChildPolicy();

    #
    $group_size_id = isset($_POST['group_size_id']) ? $_POST['group_size_id'] : 0;
    $number_adult = isset($_POST['number_adult']) ? $_POST['number_adult'] : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $tour_id = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;


    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = explode(',', $lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child = $clsTourOption->getOneField('number_to', $lastChildSize);

    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = explode(',', $lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant = $clsTourOption->getOneField('number_to', $lastInfantSize);

    $maxChild = $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) : 0;
    $maxInfant = $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) : 0;


    echo '0|||' . $maxChild . '|||' . $maxInfant;
    die();
}

function default_ajOpenSrv()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;

    $tourservice_id = intval($_POST['tourservice_id']);
    $quantity = intval($_POST['quantity']);
    $tour_id = intval($_POST['tour_id']);

    $BOOK_ADDON = vnSessionGetVar('BOOK_ADDON');
    if (empty($BOOK_ADDON)) {
        $BOOK_ADDON = array();
    }
    if (is_array($BOOK_ADDON) && count($BOOK_ADDON) > 0) {
        $ok = false;
        foreach ($BOOK_ADDON as $k => $v) {
            if ($tourservice_id > 0 && $tourservice_id == $k) {
                if ($quantity > 0) {
                    $BOOK_ADDON[$tourservice_id] = $quantity;
                    $ok = true;
                    break;
                } else {
                    unset($BOOK_ADDON[$k]);
                }
            }
        }
        if (!$ok && $quantity > 0) {
            $BOOK_ADDON[$tourservice_id] = $quantity;
        }
        vnSessionSetVar('BOOK_ADDON', $BOOK_ADDON);
    } else {
        if ($quantity > 0) {
            $BOOK_ADDON[$tourservice_id] = $quantity;
        }
        vnSessionSetVar('BOOK_ADDON', $BOOK_ADDON);
    }
    echo (1);
    die();
}

function default_loadMonth()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO;
    global $clsConfiguration;
    #

    $clsTourStartDate = new TourStartDate();
    $now = time();
    $day = date('d', $now);

    $year = isset($_POST['year']) ? intval($_POST['year']) : 0;
    if ($year == 0) {
        $year = date('Y', $now);
    }
    $month = isset($_POST['month']) ? intval($_POST['month']) : 0;
    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : '0';

    $cond = "is_trash=0 and start_date >= '" . time() . "'";
    $cond .= " and tour_id ='$tour_id'";

    //$lstTourStartDate = $clsTourStartDate->getAll($cond." order by start_date ASC".$limit);

    #
    $html = '<option value="0"> -- ' . $core->get_Lang('select month') . ' --</option>';

    $year_loadMonth = date('Y', $now);
    $month_loadMonth = date('m', $now);
    if ($year == $year_loadMonth) {
        for ($i = intval($month_loadMonth); $i <= 12; $i++) {
            $html .= '<option value="' . $i . '" ' . ($i == $month ? 'selected="selected"' : '') . ' data="' . $year . '">' . $clsISO->getNameMonth($i) . '-' . $year . '</option>';
        }
    } else {
        for ($i = 1; $i < 13; $i++) {
            $cond .= " and start_date >= '" . strtotime($i . '/01' . $year) . "' and start_date <= '" . strtotime($i . '/31/' . $year) . "'";
            $lstTourStartDate = $clsTourStartDate->getAll($cond . " order by start_date ASC");
            //print_r(count($lstTourStartDate)); die();
            if ($lstTourStartDate > 0) {
                $html .= '<option value="' . $i . '" ' . ($i == $month ? 'selected="selected"' : '') . ' data="' . $year . '">' . $$clsISO->getNameMonth($i) . '-' . $year . '</option>';
            }
        }
    }
    echo $html;
    die();
}

function default_other()
{
    global $assign_list, $clsISO, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
    #
    $listMonth = array();
    $now = time();
    $month = date('m', $now);
    $year = date('Y', $now);
    #
    for ($i = intval($month); $i <= 12; $i++) {
        $listMonth[] = array(
            'month' => ($i < 10) ? '0' . $i : $i,
            'year' => $year
        );
    }
    for ($i = 1; $i < intval($month); $i++) {
        $listMonth[] = array(
            'month' => $i ? '0' . $i : $i,
            'year' => ($year + 1)
        );
    }
    $assign_list["listMonth"] = $listMonth;

    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    #
    $tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : '0';
    $assign_list["tour_id"] = $tour_id;
    $oneItem = $clsTour->getOne($tour_id);
    $assign_list["oneItem"] = $oneItem;
    $tour_type_id = !empty($oneItem['tour_type_id']) ? $oneItem['tour_type_id'] : '1';

    $lstCityPoint = $clsCity->getAll("is_trash=0 and is_online=1 and country_id =1 and is_start_point=1 order by order_start_point desc", $clsCity->pkey);
    $assign_list["lstCityPoint"] = $lstCityPoint;
    unset($lstCityPoint);

    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $lstTourStartDateIN = $clsTourStartDate->countItem("is_trash=0 and start_date >= '" . time() . "' and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour where tour_type_id = '1' )");
    $assign_list["lstTourStartDateIN"] = $lstTourStartDateIN;
    //print_r($lstTourStartDateIN); die();
    unset($lstTourStartDateIN);

    $lstTourStartDateOUT = $clsTourStartDate->countItem("is_trash=0 and start_date >= '" . time() . "' and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour where tour_type_id = '2' ) ");
    $assign_list["lstTourStartDateOUT"] = $lstTourStartDateOUT;
    //print_r($lstTourStartDateOUT); die();
    unset($lstTourStartDateOUT);


    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('schedules') . ' ' . $clsTour->getTitle($tour_id) . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $core->get_Lang('schedules') . ' ' . $clsTour->getTitle($tour_id) . ' | ' . PAGE_NAME;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $core->get_Lang('schedules') . ' ' . $clsTour->getTitle($tour_id) . ' | ' . PAGE_NAME;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_ajaxGetTourOpenning()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
    global $clsISO, $adult_type_id;


    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $clsPagination = new Pagination();
    $assign_list["clsPagination"] = $clsPagination;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsTourPriceGroup = new TourPriceGroup();
    $assign_list["clsTourPriceGroup"] = $clsTourPriceGroup;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;

    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;


    $now = time();
    $day = date('d', $now);
    $departure = isset($_POST['month']) ? $_POST['month'] : '';

    $array_departure = explode('/', $departure);
    $month = $array_departure['0'];

    if ($array_departure['1'] != '') {
        $year = $array_departure['1'];
    }


    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $departure_id = isset($_POST['departure_id']) ? intval($_POST['departure_id']) : '';
    $destination_id = isset($_POST['destination_id']) ? intval($_POST['destination_id']) : '';
    $cat_id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : '';
    $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
    $tour_type_id = isset($_POST['tour_type_id']) ? intval($_POST['tour_type_id']) : '0';
    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : '0';
    $assign_list["tour_id"] = $tour_id;


    $recordPerPage = 20;
    #
    $cond = "is_trash=0 and is_online=1 and start_date >= '" . time() . "'";
    $cond .= " and tour_id ='$tour_id'";
    if (!empty($month) && !empty($year)) {
        $start_date = $month . '/01/' . $year;
        $end_date = $month . '/31/' . $year;
        $cond .= " and start_date >= '" . strtotime($start_date) . "' and start_date <= '" . strtotime($end_date) . "'";
    }

    if (empty($month) && !empty($year)) {
        $start_date = '01/01/' . $year;
        $end_date = '12/31/' . $year;
        $cond .= " and start_date >= '" . strtotime($start_date) . "' and start_date <= '" . strtotime($end_date) . "'";
    }


    if (!empty($tour_id)) {
        $clsTourDestination = new TourDestination();
        $res = $clsTourDestination->getAll("is_trash=0 and tour_id = '$tour_id' order by order_no desc");
        if (!empty($res)) {
            $cond .= " and tour_id IN (SELECT tour_id FROM default_tour_destination WHERE ";
            if ($res[0]['city_id'] == '' || $res[0]['city_id'] == '0') {
                for ($i = 0; $i < count($res); $i++) {
                    if (!empty($res[$i]['country_id'])) {
                        $cond .= ($i == 0 ? '' : ' or ') . " country_id = '" . $res[$i]['country_id'] . "'";
                    }
                }
            } elseif (!empty($res[0]['city_id'])) {
                for ($i = 0; $i < count($res); $i++) {
                    if (!empty($res[$i]['city_id'])) {
                        $cond .= ($i == 0 ? '' : ' or ') . " city_id = '" . $res[$i]['city_id'] . "'";
                    }
                }
            }
            $cond .= ")";
        }
    }


    if (!empty($departure_id)) {
        $cond .= " and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour where depart_point_id = '" . $departure_id . "')";
    }
    if (!empty($destination_id)) {
        if ($tour_type_id == 1) {
            $cond .= " and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour_destination where city_id = '" . $destination_id . "')";
        } else {
            $cond .= " and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour_destination where country_id = '" . $destination_id . "')";
        }
    }
    if (!empty($cat_id)) {
        $cond .= " and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour where list_cat_id like '%|" . $cat_id . "|%')";
    }
    if ($duration != '' && $duration != '0') {
        $duration = explode("-", $duration);
        $number_day = $duration[0];
        $number_night = $duration[1];
        $cond .= " and tour_id in (SELECT tour_id FROM " . DB_PREFIX . "tour where number_day=" . $number_day . " and number_night=" . $number_night . ")";
    }


    $totalRecord = $clsTourStartDate->getAll($cond) ? count($clsTourStartDate->getAll($cond)) : 0;
    $page_view = $clsPagination->pagination_ajax($totalRecord, $recordPerPage, $page, '', '', false);

    $offset = ($page - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    #
    $lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
    $assign_list["lstNationality"] = $lstNationality;

    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");
    $assign_list["lstVisitorType"] = $lstVisitorType;

    $lstTourStartDate = $clsTourStartDate->getAll($cond . " order by start_date ASC" . $limit);
    $assign_list["lstTourStartDate"] = $lstTourStartDate;

    $lstTourOption = $clsTour->getOneField('tour_option', $tour_id);
    $lstOption = array();
    if ($lstTourOption != '' && $lstTourOption != '0') {
        $TMP = explode(',', $lstTourOption);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstOption)) {
                $lstOption[] = $TMP[$i];
            }
        }
    }
    $assign_list["lstOption"] = $lstOption;

    $Html = $core->build('table_departure_date.tpl');
    echo $Html;
    die();
}

function default_OpenAvailbility()
{
    global $clsISO, $core, $dbconn, $_LANG_ID;
    $clsTour = new Tour();
    $type = $_POST['type'];
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $tour_id = $_POST['tour_id'];
    // List action
}

function _getdataTourPrice($tour_id)
{
    global $dbconn, $_LANG_ID;
    $sql = "SELECT `tour_price_val_id`,`tour_id`,`price`,`departure_date` FROM " . DB_PREFIX . "tour_price_val 
	WHERE tour_id = '$tour_id' and tour_price_row_id='16'";
    $results = $dbconn->getAll($sql);
    return $results;
}

function default_map()
{
    global $dbconn, $_LANG_ID, $core, $smarty;
    $clsTour = new Tour();
    $smarty->assign('clsTour', $clsTour);

    $tour_id = intval($_POST['tour_id']);
    $smarty->assign('tour_id', $tour_id);

    $ret = $clsTour->getLocationMap($tour_id);
    $map_la = $ret['map_la'];
    $map_lo = $ret['map_lo'];
    $script_location = $ret['jscode'];
    $smarty->assign('map_la', $map_la);
    $smarty->assign('map_lo', $map_lo);
    $smarty->assign('script_location', $script_location);

    $html = $core->build('map.tpl');
    echo $html;
    die();
}

function default_ajLoadMoreTour()
{
    global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,
        $title_page, $description_page, $keyword_page, $clsISO;

    #
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsTourStore = new TourStore();
    $assign_list['clsTourStore'] = $clsTourStore;
    $clsPromotion = new Promotion();
    $assign_list['clsPromotion'] = $clsPromotion;
    #
    $numberPage = isset($_POST['page']) ? $_POST['page'] : 1;
    $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $itemOnPage = 6;
    $limit = " limit " . (($numberPage - 1) * $itemOnPage) . "," . ($itemOnPage);
    $sql = "is_trash=0 and is_online=1";
    if ($cat_id > 0) {
        $listTourCategory = $clsTourCategory->getAll("is_trash=0 and is_online=1 and parent_id='$cat_id'");
        if ($listTourCategory != '') {
            $parent_id = $cat_id;

            $sql .= " and cat_id IN (SELECT tourcat_id FROM " . DB_PREFIX . "tour_category WHERE is_trash=0 and is_online=1 and parent_id='$parent_id')";
        } else {
            $sql .= " and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
        }
    }
    if ($country_id > 0) {
        $sql .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id')";
    }
    //print_r($sql." order by order_no ASC ".$limit); die();
    $listTour = $clsTour->getAll($sql . " order by order_no ASC " . $limit, $clsTour->pkey);

    $assign_list["listTour"] = $listTour;
    $assign_list["numberPage"] = $numberPage;
    #
    $html = $core->build('load_more_tour.tpl');
    echo $html;
    die;
}

function default_ajLoadMoreTourSearch()
{
    global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page,
        $clsISO, $cat_id, $profile_id, $country_id, $cat_ID, $duration_ID, $price_range_ID;

    //$_LANG_ID=isset($_POST['_LANG_ID'])? $_POST['_LANG_ID']:'';

    $now_day = isset($_POST['now_day']) ? $_POST['now_day'] : '';
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : '';
    $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
    $cat_ID = isset($_POST['cat_ID']) ? $_POST['cat_ID'] : '';
    $duration_ID = isset($_POST['duration_id']) ? $_POST['duration_id'] : '';
    $price_range_ID = isset($_POST['price_range_id']) ? $_POST['price_range_id'] : '';
    $sortby = isset($_POST['sortby']) ? $_POST['sortby'] : '';
    $keyword = (isset($_POST['key']) && !empty($_POST['key'])) ? $_POST['key'] : '';
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsPromotion = new Promotion();
    $assign_list['clsPromotion'] = $clsPromotion;
    $clsReviews = new Reviews();
    $assign_list['clsReviews'] = $clsReviews;
    $clsTourStore = new TourStore();
    $assign_list['clsTourStore'] = $clsTourStore;
    $cond = "is_trash=0 and is_online=1";
    if ($country_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
    }
    if ($city_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_id))";
        $assign_list["city_id"] = $city_id;
    }
    if (!empty($cat_ID)) {
        $cat_ID = explode(',', $cat_ID);
        $cond .= " and (";
        for ($i = 0; $i < count($cat_ID); $i++) {
            if ($i == 0 && count($cat_ID) == 1) {
                $cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            } elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
            } else {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
    }
    /*print_r($cond);die();*/
    if (!empty($price_range_ID)) {
        $clsPriceRange = new PriceRange();
        $SQLMINRATE = "SELECT MIN(min_rate) FROM " . DB_PREFIX . "price_range WHERE price_range_id IN ($price_range_ID) and type='TOUR'";
        $SQLMAXRATE = "SELECT MAX(max_rate) FROM " . DB_PREFIX . "price_range WHERE price_range_id IN ($price_range_ID) and max_rate<>'0' and type='TOUR'";
        $SQLMINMAXRATE = "SELECT MIN(max_rate) FROM " . DB_PREFIX . "price_range WHERE price_range_id IN ($price_range_ID) and type='TOUR'";
        #
        $min_rate = $dbconn->GetOne($SQLMINRATE);
        $minmax_rate = $dbconn->GetOne($SQLMINMAXRATE);
        $assign_list['minmax_rate'] = $minmax_rate;
        if ($minmax_rate == '0') {
            $max_rate = 0;
        } else {
            $max_rate = $dbconn->GetOne($SQLMAXRATE);
        }
        $assign_list['min_rate'] = $min_rate;
        $assign_list['max_rate'] = $max_rate;
        #
        if ($min_rate > 0 && $max_rate > 0) {
            $cond .= " and trip_price > '$min_rate' and trip_price < '$max_rate'";
        } elseif ($min_rate == 0 && $max_rate > 0) {
            $cond .= " and trip_price < '$max_rate'";
        } elseif ($min_rate > 0 && $max_rate == 0) {
            $cond .= " and trip_price >= '$min_rate'";
        } elseif ($min_rate == 0 && $max_rate == 0) {
            $cond .= " and trip_price >= '$min_rate'";
        } else {
            $cond .= " and trip_price > '$min_rate'";
        }
    }

    if (!empty($duration_ID)) {
        $cond .= " and number_day IN($duration_ID)";
    }
    $order_by = " order by order_no asc";
    $numberPage = isset($_POST['page']) ? $_POST['page'] : 1;
    $assign_list["numberPage"] = $numberPage;
    $itemOnPage = 6;
    $limit = " limit " . (($numberPage - 1) * $itemOnPage) . "," . ($itemOnPage);
    #
    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
        $assign_list["keyword"] = $keyword;
    }
    $listTour = $clsTour->getAll($cond . $order_by . $limit, $clsTour->pkey);
    $assign_list["listTour"] = $listTour;
    $html = $core->build('load_more_tour.tpl');
    print_r($html);
    die();
    echo $html;
    die;
}
