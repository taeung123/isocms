<?php
/*======================================================================*\
|| #################################################################### ||
|| # The database configurations of the ISOCMS                        # ||
|| # ISOCMS By VietISO (support@vietiso.com)        			      # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2024 VietISO JSC.             # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
function default_defaultOld()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $_lang;
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsCruiseStartDate = new CruiseStartDate();
    $assign_list["clsCruiseStartDate"] = $clsCruiseStartDate;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsCityStore = new CityStore();
    $assign_list["clsCityStore"] = $clsCityStore;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsBlog = new Blog();
    $assign_list["clsBlog"] = $clsBlog;
    $clsBlogCategory = new BlogCategory();
    $assign_list["clsBlogCategory"] = $clsBlogCategory;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;

    #
    $lnk = $_SERVER['REQUEST_URI'];
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $linkpage = substr($lnk, 0, $str_len);
    } else {
        $linkpage = $lnk;
    }
    $assign_list["linkpage"] = $linkpage;
    #
    $lstCruiseTopBest = $clsPromotion->getAll("is_online=1 and clsTable='Cruise' and target_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1) and " . time() . " between  start_date and end_date ORDER BY promotion_id DESC", $clsPromotion->pkey . ",target_id,cruise_itinerary_id,price_text");
    $assign_list["lstCruiseTopBest"] = $lstCruiseTopBest;

    #
    $lstCruiseTopPromotion = $clsCruiseStore->getAll("cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1) and _type='RECOMMED' ORDER BY order_no  asc limit 0,6", 'cruise_id');
    $assign_list["lstCruiseTopPromotion"] = $lstCruiseTopPromotion;
    $RecordPageCruisePromotion = count($clsCruiseStore->getAll("cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1) and _type='RECOMMED' ORDER BY order_no  asc", 'cruise_id'));
    $TotalPageCruisePromotion = ceil($RecordPageCruisePromotion / 6);
    $assign_list['TotalPageCruisePromotion'] = $TotalPageCruisePromotion;
    $assign_list['currentPage'] = 1;
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Cruises') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_default()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $domain, $clsConfiguration, $cat_id, $clsISO, $now_month, $now_day;
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsCruiseStartDate = new CruiseStartDate();
    $assign_list["clsCruiseStartDate"] = $clsCruiseStartDate;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruisePriceRange = new CruisePriceRange();
    $assign_list["clsCruisePriceRange"] = $clsCruisePriceRange;
    $clsBlog = new Blog();
    $assign_list["clsBlog"] = $clsBlog;
    $clsBlogCategory = new BlogCategory();
    $assign_list["clsBlogCategory"] = $clsBlogCategory;
    #
    $sortby = isset($_GET['sortby']) ? $_GET['sortby'] : '0';
    $assign_list["sortby"] = $sortby;

    $lnk = $_SERVER['REQUEST_URI'];
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $linkpage = substr($lnk, 0, $str_len);
    } else {
        $linkpage = $lnk;
    }
    $assign_list["linkpage"] = $linkpage;
    #

    $cond = "is_trash=0 and is_online=1";
    #
    $pageNum = 5;
    $recordPerPage = 10;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    #

    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    #
    $checkFilter = $clsCruise->getAll($cond, $clsCruise->pkey);
    $assign_list['checkFilter'] = $checkFilter;
    #filter
    $place = Input::get('place', 0);
    $assign_list['place'] = $place;
    $star_number = Input::get('star_number', 0);
    $assign_list['star_number'] = $star_number;
    $price_range_ID = Input::get('price_range_ID', 0);
    $assign_list['price_range_ID'] = $price_range_ID;
    $cat_ID = Input::get('cat_ID', 0);
    $assign_list['cat_ID'] = $cat_ID;

    if ($cat_ID > 0) {
        $cond .= " and (cruise_cat_id='$cat_ID' or list_cat_id like '%|" . $cat_ID . "|%')";
    }
    if ($place > 0) {
        $cond .= " and cruise_id IN (SELECT cruise_id FROM default_cruise_destination WHERE is_trash=0 and city_id='" . $place . "') ";
    }
    if ($star_number > 0) {
        $cond .= " and star_number='" . $star_number . "'";
    }
    if ($price_range_ID > 0) {
        #filter price
        $sql_price = '';
        if (!empty($price_range_ID)) {
            $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
            if (!empty($lstSeason)) {
                $season = 'high';
            } else {
                $season = 'low';
            }
            $lstAllCruise = $clsCruise->getAll("is_trash=0 and is_online=1", $clsCruise->pkey);
            foreach ($lstAllCruise as $key => $value) {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_id='" . $value['cruise_id'] . "' and season ='$season'";
                $price = $dbconn->GetOne($SQL);
                $discount = $clsISO->getPromotion($value['cruise_id'], 'Cruise', $now_day, $now_day, 'info_promotion');
                $promotion = 0;
                $min_price = (!empty($price)) ? $price : 0;
                if (!empty($discount)) {
                    $promotion = $discount['discount_value'];
                    if ($discount['discount_type'] == 2) {
                        $min_price = $price - ($promotion * $price / 100);
                    } else {
                        $min_price = $price - $discount['discount_value'];
                    }
                }
            }

            $clsCruisePriceRange = new CruisePriceRange();

            $sql_price = ' and (';
            $onePriceRange = $clsCruisePriceRange->getOne($price_range_ID, 'min_rate,max_rate');
            $min_rate = $onePriceRange['min_rate'];
            $max_rate = $onePriceRange['max_rate'];
            if ($min_rate == 0 && $max_rate > 0) {
                $sql_price .= "min_price <= " . $max_rate . " ";
            } else if ($min_rate > 0 && $max_rate == 0) {
                $sql_price .= "min_price >= " . $min_rate . " ";
            } else {
                $sql_price .= "min_price BETWEEN " . $min_rate . " AND " . $max_rate . "  ";
            }
            $sql_price .= ")";
        }
        $cond .= $sql_price;
    }
    //	echo $cond;die;
    if ($sortby == '0') {
        $order_by = " order by order_no asc";
    } elseif ($sortby == 'popular') {
        $order_by = " order by view_num desc";
    } else {
        $order_by = " order by cruise_id desc";
    }
    #
    //	$clsCruise->setDeBug(1);
    $listCruise = $clsCruise->getAll($cond . $order_by . $limit, $clsCruise->pkey . ',title,slug,star_number,about,image,departure_port');
    //	die;

    if ($sortby == 'toprate') {
        foreach ($listCruise as $k => $v) {
            $listCruise[$k]['hrate'] = $clsReviews->getRateAvg($v[$clsCruise->pkey]);
        }
        uasort($listCruise, "compare_rate");
    }
    $assign_list['listCruise'] = $listCruise;
    unset($listCruise);
    /*$cond2=" and cruise_id NOT IN (SELECT cruise_id From default_cruise_store where ( _type='BEST' or _type='RECOMMED'))";

    $lstCruiseTopBest = $clsPromotion->getAll("is_online=1 and clsTable='Cruise'  and ".time()." between  start_date and end_date and target_id IN (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')) ORDER BY promotion_id  DESC",$clsPromotion->pkey.",target_id,cruise_itinerary_id,price_text");
    $assign_list["lstCruiseTopBest"] = $lstCruiseTopBest;
    unset($lstCruiseTopBest);
    #
    $lstCruiseTopPromotion = $clsCruiseStore->getAll("cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')) and _type='RECOMMED' ORDER BY order_no asc limit 0,6",$clsCruiseStore->pkey.',cruise_id');
    $assign_list["lstCruiseTopPromotion"] = $lstCruiseTopPromotion;
    $RecordPageCruisePromotion = $lstCruiseTopPromotion?count($clsCruiseStore->getAll("cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')) and _type='RECOMMED' ORDER BY order_no  asc",'cruise_id')):0;
    unset($lstCruiseTopPromotion);
    $TotalPageCruisePromotion = ceil($RecordPageCruisePromotion/6);
    $assign_list['TotalPageCruisePromotion']=$TotalPageCruisePromotion;
    $assign_list['currentPagePromo']=1;
    #
    $listCruiseOtherFull=$clsCruise->getAll("cruise_id NOT IN (SELECT default_cruise_store.cruise_id FROM default_cruise_store WHERE is_trash = 0 and _type='RECOMMED') and is_trash=0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%') ORDER BY order_no asc",$clsCruise->pkey);
    //echo $cond.$cond2.$order_by;die('xxxx');
    $RecordPageCruiseOrther = $listCruiseOtherFull?count($listCruiseOtherFull):0;
    $TotalPageCruiseOrther = ceil($RecordPageCruiseOrther/6);
    $assign_list['TotalPageCruiseOrther']=$TotalPageCruiseOrther;
    $assign_list['currentPageOther']=1;
    $listCruiseOther=$clsCruise->getAll("cruise_id NOT IN (SELECT default_cruise_store.cruise_id FROM default_cruise_store WHERE is_trash = 0 and _type='RECOMMED') and is_trash=0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%') ORDER BY order_no asc limit 0,6",$clsCruise->pkey.',title,slug');
    $assign_list["listCruiseOther"] = $listCruiseOther;
    unset($listCruiseOther);


    $lstBlogHaLong = $clsBlog->getAll("is_trash=0 and is_online=1 and blog_id IN (select blog_id FROM ".DB_PREFIX."blog_destination WHERE city_id ='417') order by reg_date desc",$clsBlog->pkey);
    $assign_list["lstBlogHaLong"] = $lstBlogHaLong;*/

    #

    $allCruise = $clsCruise->getAll($cond, $clsCruise->pkey);
    $totalRecord = $allCruise ? count($allCruise) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    #
    $first = intval($currentPage / $pageNum) * $pageNum;
    $pageView = "";
    for ($i = 0; $i < $pageNum; $i++)
        if ($first + $i < $totalPage) {
            $link = $linkpage . "&page=" . ($first + $i + 1);
            $page = ($first + $i + 1 == $currentPage) ? '<a class="current" href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>' : '<a href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>';
            $pageView .= $page;
        }
    #
    $assign_list['currentPage'] = $currentPage;
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['pageNum'] = $pageNum;
    $assign_list['pageView'] = $assign_list['page_view'] = $pageView;


    #
    $oneCat = $clsCruiseCat->getOne($cat_id, $clsCruiseCat->pkey . ',title,image,image_banner,slug,intro');
    $assign_list['oneCat'] = $oneCat;
    $title_cat = $clsCruiseCat->getTitle($cat_id, $oneCat);
    $assign_list['title_cat'] = $title_cat;
    $link_cat = $clsCruiseCat->getLink($cat_id, $oneCat);
    $assign_list['link_cat'] = $link_cat;
    $intro_More = $clsCruiseCat->getIntro($cat_id, $oneCat);
    $assign_list['intro_More'] = $intro_More;

    /*=============Title & Description Page==================*/
    $title_page = $title_cat . ' | ' . $core->get_Lang('Cruise') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsCruiseCat->getMetaDescription($cat_id, $oneCat);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cat_id, 'CruiseCat', $oneCat);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
}
function default_search2024()
{

    global $clsISO, $assign_list;
    #submit
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $first = true;
        $link = $clsISO->getLink("cruise");
        foreach ($_POST as $key => $value) {
            $link .= ($first ? '?' : '&') . "$key=" . (is_array($value) ? $clsISO->makeSlashListFromArrayComma($value) : $value);
            $first = false;
        }
        header('location:' . trim($link));
        exit();
    }
    default_default();
    $clsCruise = new Cruise;
    $cond = $cond_def = "is_trash=0 and is_online=1 ";
    $order_by = " order by order_no";
    $recordPerPage = 10;
    $currentPage = $_GET["page"] ?? 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $filter =  [
        'page' => $currentPage,
        'sort' => $_GET["sort"],
        'price_id' => $_GET["price_id"],
        'itineraries' => $_GET["itineraries"],
        'rank_cruise' => $_GET["rank_cruise"],
        'cabins' => $_GET["cabins"],
        
    ];

    $listCruise = filter_cruise($filter);
    $clsCruise = new Cruise;
    $cond = "is_trash = 0 and is_online = 1 ";
    $clsPagination = new Pagination();
    $totalRecord = filter_cruise($filter, true);

    if ($totalRecord) {
        $totalRecord = count($totalRecord);
    } else {
        $totalRecord = 0;
    }
    $currentPage = $_GET["page"] ?? 1;


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
        'link_page_1' => $link_page
    );

    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links();
    $totalPage = $clsPagination->getTotalPage();
    $assign_list["totalPage"] = $totalPage;
    $assign_list["page_view"] = $page_view;
    $assign_list["totalRecord"] = $totalRecord;
    $assign_list["listCruise"] = $listCruise;
}
function default_bookservices()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $extLang, $oneCommon, $cruise_id, $show;
    global $extLang, $clsConfiguration, $clsISO, $package_id, $now_month;

    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;
    $clsCruiseCat = new CruiseCat();
    $assign_list['clsCruiseCat'] = $clsCruiseCat;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list['$clsCruiseProperty'] = $clsCruiseProperty;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list['clsCruiseCabin'] = $clsCruiseCabin;
    $clsCruiseService = new CruiseService();
    $assign_list['clsCruiseService'] = $clsCruiseService;

    $ContactCruise = vnSessionGetVar('ContactCruise');
    $assign_list['ContactCruise'] = $ContactCruise;

    $array_bed = json_decode(json_encode($ContactCruise['compare_price']), true);
    $assign_list['array_bed'] = $array_bed;

    if (empty($ContactCruise)) {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    }
    $slug_key = Input::get('slug_key', "");
    if ($slug_key != '') {
        $cruise_id = $core->decryptID($slug_key);
        $assign_list['cruise_id'] = $cruise_id;
        if ($cruise_id == 0 || $cruise_id != $ContactCruise['cruise_id']) {
            header('location:/404');
            exit();
        }
        $oneCruise = $clsCruise->getOne($cruise_id);
        $assign_list['oneCruise'] = $oneCruise;

        $oneCruiseItinerary = $clsCruiseItinerary->getOne($ContactCruise['cruise_itinerary_id'], 'listService');
        if ($oneCruiseItinerary['listService'] != "") {
            $listService_id = str_replace("|", ",", trim($oneCruiseItinerary['listService'], "|"));
            $lstService = $clsCruiseService->getAll("is_trash=0 and is_online=1 and cruise_service_id IN (" . $listService_id . ") order by order_no desc", $clsCruiseService->pkey . ',title,price');
            $assign_list['lstService'] = $lstService;
        }

        $cond_faci = "";
        if ($listCruiseFacilities != '' || $listCruiseFaActivities != '' || $listCruiseServices != '') {
            $cond_faci .= " AND ( ";
            $check_first = 1;
            if ($listCruiseFacilities != '') {
                $cond_faci .= (($check_first == 1) ? "" : " OR ") . "cruise_property_id IN (" . $listCruiseFacilities . ")";
                $check_first = 0;
            }
            if ($listCruiseFaActivities != '') {
                $cond_faci .= (($check_first == 1) ? "" : " OR ") . "cruise_property_id IN (" . $listCruiseFaActivities . ")";
                $check_first = 0;
            }
            if ($listCruiseServices != '') {
                $cond_faci .= (($check_first == 1) ? "" : " OR ") . "cruise_property_id IN (" . $listCruiseServices . ")";
                $check_first = 0;
            }
            $cond_faci .= " ) ";
        }

        $list_Facilities = $clsCruiseProperty->getAll("is_trash=0 " . $cond_faci . " order by order_no asc", $clsCruiseProperty->pkey . ',image,title');
        $assign_list['list_Facilities'] = $list_Facilities;

        $txt_number_people = "";
        if ($ContactCruise['number_adult'] == 1) {
            $txt_number_people .= $ContactCruise['number_adult'] . " x " . $core->get_Lang("Adult");
        } else {
            $txt_number_people .= $ContactCruise['number_adult'] . " x " . $core->get_Lang("Adults");
        }
        if ($ContactCruise['number_child'] > 0) {
            if ($ContactCruise['number_child'] == 1) {
                $txt_number_people .= ", " . $ContactCruise['number_child'] . " x " . $core->get_Lang("Children");
            } else {
                $txt_number_people .= ", " . $ContactCruise['number_child'] . " x " . $core->get_Lang("Childrens");
            }
            $str_children = implode(",", $ContactCruise['children']);
            $txt_number_people .= " (" . $str_children . " " . $core->get_Lang('year old') . ")";
        }
        $assign_list['txt_number_people'] = $txt_number_people;
    } else {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    }

    /*=============Title & Description Page==================*/

    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($cruise_id, 'Cruise', $oneTable);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cruise_id, 'Cruise', $oneTable);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
}
function default_detail()
{
    global $assign_list, $lang_sql, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $extLang, $oneCommon, $cruise_id, $show;
    global $extLang, $clsConfiguration, $clsISO, $package_id, $now_month;
    #
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;

    #Danh sách file css xử dụng cho trang home
    Asset::css([
        "{$URL_JS}/fancybox4/fancybox.css?v={$upd_version}",
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$upd_version}",
        "{$URL_CSS}/cruise_detail2024.css?v={$upd_version}"
    ]);

    Asset::js([
        "{$URL_JS}/fancybox4/fancybox.umd.js?v={$upd_version}",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}",
        "{$URL_JS}/jquery.countdown.min.js?v={$upd_version}",
        "{$URL_JS}/jquery-confirm.min.js?v={$upd_version}",
        "{$URL_JS}/jquery.sharer.js?v={$upd_version}",
        "{$URL_JS}/reviewstar/starwarsjs.js?v={$upd_version}",
        "{$URL_JS}/review/review.js?v={$upd_version}",
        "{$URL_JS}/jquerycruise.js?v={$upd_version}"
    ]);
    #
    $clsTransport = new Transport();
    $assign_list["clsTransport"] = $clsTransport;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsImage = new Image();
    $assign_list["clsImage"] = $clsImage;
    $clsCruiseImage = new CruiseImage();
    $assign_list["clsCruiseImage"] = $clsCruiseImage;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsCruiseDestination = new CruiseDestination();
    $assign_list["clsCruiseDestination"] = $clsCruiseDestination;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCruisePriceTable = new CruisePriceTable();
    $assign_list["clsCruisePriceTable"] = $clsCruisePriceTable;
    $clsCruiseSeasonPrice = new CruiseSeasonPrice();
    $assign_list["clsCruiseSeasonPrice"] = $clsCruiseSeasonPrice;
    $clsCruiseMapImage = new CruiseMapImage();
    $assign_list["clsCruiseMapImage"] = $clsCruiseMapImage;
    $clsCruiseItineraryDay = new CruiseItineraryDay();
    $assign_list["clsCruiseItineraryDay"] = $clsCruiseItineraryDay;
    $clsCountryEx = new Country();
    $assign_list["clsCountry"] = $clsCountryEx;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsReviewsCruise = new ReviewsCruise();
    $assign_list["clsReviewsCruise"] = $clsReviewsCruise;
    $clsCabinImage = new CabinImage();
    $assign_list["clsCabinImage"] = $clsCabinImage;
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    #
    $cruise_id = isset($_GET['cruise_id']) ? $_GET['cruise_id'] : 0;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    if (empty($clsCruise->checkOnlineBySlug($cruise_id, $slug))) {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    }
    #
    $post_id = intval($cruise_id);
    if (isset($_COOKIE['recent_view_cruise'])) {
        $recent_view_cruise = json_decode($_COOKIE['recent_view_cruise'], true);
    } else {
        $recent_view_cruise = array();
    }
    if (!in_array($post_id, $recent_view_cruise)) {
        $recent_view_cruise[] = $post_id;
    }

    setcookie('recent_view_cruise', json_encode($recent_view_cruise), time() + (86400), "/");
    #

    /*viewed_cruise*/
    $sessionName = md5('VIEWDEDCRUISE');
    $VIEWDED_CRUISE = vnsessionGetVar($sessionName);
    if (empty($VIEWDED_CRUISE)) {
        $VIEWDED_CRUISE = $cruise_id;
    } else {
        $tmp = explode('|', $VIEWDED_CRUISE);
        if (!in_array($cruise_id, $tmp)) {
            $VIEWDED_CRUISE .= '|' . $cruise_id;
        }
        unset($tmp);
    }
    vnSessionSetVar($sessionName, $VIEWDED_CRUISE);

    $assign_list["cruise_id"] = $cruise_id;

    $table_id = $cruise_id;
    $assign_list["table_id"] = $table_id;

    $oneTable = $clsCruise->getOne($cruise_id, 'title,slug,about,inclusion,exclusion,cruise_policy,booking_policy,child_policy,departure_port,star_number,image,important_notes,listThingAbout,listCruiseBudget,listTravelAs,listRestFa,listCruiseFacilities,listCruiseFaActivities,listCruiseServices,cruise_cat_id,price_3day,price,build,total_cabin,material,cruise_code,file_programme,cruise_type');
    $assign_list["oneTable"] = $oneTable;

    $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1", $clsConfiguration->pkey);
    if (!empty($lstSeason)) {
        $season = 'high';
    } else {
        $season = 'low';
    }
    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_id='$cruise_id' and season ='$season'";


    #
    $price_check = $dbconn->GetOne($SQL);

    $sql_cabin = "SELECT cruise_itinerary_id,cruise_cabin_id,group_size_id FROM " . DB_PREFIX . "cruise_season_price WHERE price = '$price_check' and cruise_id='$cruise_id' and season ='$season'";

    $cabin = $dbconn->GetAll($sql_cabin);
    $cruise_itinerary_check_id = $cabin[0]['cruise_itinerary_id'] ?? 0;
    $cruise_cabin_check_id = $cabin[0]['cruise_cabin_id'] ?? 0;
    $group_size_check_id = $cabin[0]['group_size_id'] ?? 0;
    $number_adult_check = $clsCruiseProperty->getNumberAdult($group_size_check_id);

    $assign_list['cruise_itinerary_check_id'] = $cruise_itinerary_check_id;
    $assign_list['cruise_cabin_check_id'] = $cruise_cabin_check_id;
    $assign_list['number_adult_check'] = $number_adult_check ? $number_adult_check : 2;

    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'ThingAbout')) {
        $listThingAbout_id = $oneTable['listThingAbout'];

        $listThingAbout = $clsCruiseProperty->getAll("is_trash=0 and cruise_property_id IN ($listThingAbout_id)", $clsCruiseProperty->pkey);
        $assign_list['listThingAbout'] = $listThingAbout;
    }

    $number_day = isset($_GET['day']) ? $_GET['day'] : '0';
    $assign_list['number_day'] = $number_day;
    if ($show == 'Itinerary') {
        $lstCruiseItinerary = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' and number_day='$number_day' order by order_no asc limit 0,1", $clsCruiseItinerary->pkey);
        $cruise_itinerary_id = $lstCruiseItinerary[0]['cruise_itinerary_id'];
        $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;

        $lstPromotion = $clsPromotion->getAll("is_online=1 and clsTable='Cruise' and cruise_itinerary_id='$cruise_itinerary_id' and " . time() . " BETWEEN start_date and end_date order by order_no asc limit 0,1", $clsPromotion->pkey . ",target_id");
        $promotion_id = ($lstPromotion) ? $lstPromotion[0]['promotion_id'] : 0;
        $assign_list['promotion_id'] = $promotion_id;
    } else {
        $lstItinerary_cruise = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' order by order_no asc", $clsCruiseItinerary->pkey);

        $cruise_itinerary_id = $lstItinerary_cruise[0][$clsCruiseItinerary->pkey];
        $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;

        $lstPromotion = $clsPromotion->getAll("is_online=1 and clsTable='Cruise' and cruise_itinerary_id='$cruise_itinerary_id' order by order_no asc limit 0,1", $clsPromotion->pkey . ",target_id");
        $promotion_id = ($lstPromotion) ? $lstPromotion[0]['promotion_id'] : 0;
        $assign_list['promotion_id'] = $promotion_id;
    }

    #
    $listCruiseBudget = explode('|', rtrim(ltrim($oneTable['listCruiseBudget'], '|'), '|'));
    $assign_list["listCruiseBudget"] = $listCruiseBudget;
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'property', 'default', 'TravelAs')) {
        $listTravelAs = $clsCruiseProperty->getAll("is_trash=0 and type='TravelAs' and cruise_property_id IN (" . $oneTable['listTravelAs'] . ") order by order_no ASC", $clsCruiseProperty->pkey);
        $assign_list["listTravelAs"] = $listTravelAs;
    }

    #
    $cruise_cat_id = $oneTable['cruise_cat_id'];
    $assign_list["cruise_cat_id"] = $oneTable['cruise_cat_id'];
    $assign_list["link_cat"] = $clsCruiseCat->getLink($cruise_cat_id);
    $assign_list["title_cat"] = $clsCruiseCat->getTitle($cruise_cat_id);

    #-- Cruise Images Maps
    $resMapImage = $clsCruiseMapImage->getAll("is_trash=0 and table_id='$cruise_id' and image <> '' order by order_no desc", $clsCruiseMapImage->pkey);
    $assign_list['resMapImage'] = $resMapImage;
    unset($resMapImage);

    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'cruise_photo_gallery', 'customize')) {
        #-- Cruise Images
        $lstImage = $clsCruiseImage->getAll("is_trash=0 and table_id='$cruise_id' and image <> '' order by order_no desc", $clsCruiseImage->pkey . ',image,title');
        $assign_list['lstImage'] = $lstImage;
        unset($lstImage);
        unset($lstImage);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'itinerary', 'default')) {
        // List Cruise Itinerary
        $clsCruiseItinerary = new CruiseItinerary();
        $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
        $lstItineraryCruise = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' order by order_no ASC", $clsCruiseItinerary->pkey . ',title,title_itinerary,number_day');
        $assign_list["lstItineraryCruise"] = $lstItineraryCruise;
        unset($lstItineraryCruise);
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'edit_cabin', 'default')) {
        #-- Cruise Rooms
        $lstCruiseCabin = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id = '$cruise_id' order by order_no asc", $clsCruiseCabin->pkey);
        $assign_list['lstCruiseCabin'] = $lstCruiseCabin;
        unset($lstCruiseCabin);
    }


    $clsCruiseProperty = new CruiseProperty();
    $assign_list['clsCruiseProperty'] = $clsCruiseProperty;
    $listTypeRoom = $clsCruiseProperty->getAll("is_trash=0 and type='TypeRoom' order by order_no desc", $clsCruiseProperty->pkey);

    $assign_list['listTypeRoom'] = $listTypeRoom;
    unset($listTypeRoom);

    // List Cruise Other
    $lstCruiseOther = $clsCruise->getAll("is_trash=0 and is_online=1 and cruise_cat_id ='$cruise_cat_id' and cruise_id<>'$cruise_id' order by order_no ASC limit 0,6", $clsCruise->pkey . ',title,image,star_number,about,departure_port');
    $assign_list["lstCruiseOther"] = $lstCruiseOther;
    unset($lstCruiseOther);


    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'cruise_video', 'customize')) {
        // List Video Cruise
        $lstVideoCruise = $clsCruiseVideo->getAll("is_trash=0 and table_id = '$cruise_id' order by order_no desc", $clsCruiseVideo->pkey . ',url');
        $assign_list["lstVideoCruise"] = $lstVideoCruise;
        unset($lstVideo);
    }
    if (vnSessionExist('duration_0')) {
        $num_day_price = vnSessionGetVar('duration_0');
    } else {
        //$num_day_price = 2;
        $num_day_price = '';
    }
    $assign_list["num_day_price"] = $num_day_price;

    #- Custom Field
    $clsCruiseCustomField = new CruiseCustomField();
    $assign_list["clsCruiseCustomField"] = $clsCruiseCustomField;
    $listCustomField = $clsCruiseCustomField->getAll("cruise_id='$cruise_id' and fieldtype='CUSTOM' order by order_no ASC", $clsCruiseCustomField->pkey . ',fieldname,fieldvalue');
    $assign_list["listCustomField"] = $listCustomField;
    unset($listCustomField);


    $ret = $clsCruiseItinerary->getLocationMap($cruise_itinerary_id);
    $map_la = $ret['map_la'];
    $map_lo = $ret['map_lo'];
    $assign_list["map_la"] = $map_la;
    $assign_list["map_lo"] = $map_lo;
    $script_location = $ret['jscode'];
    $assign_list["script_location"] = $script_location;

    #-- Review
    //ini_set("display_errors",1);
    $clsPagination = new Pagination();
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $number_per_page = 3;
    #
    $cond = "is_trash=0 and is_online=1 and type='cruise' and table_id = '$cruise_id'";

    $allItem = $clsReviews->getAll($cond, $clsReviews->pkey);
    $totalRecord = $allItem ? count($allItem) : 0;
    $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);

    #
    $clsCruiseReview = new CruiseReview();
    $assign_list['clsCruiseReview'] = $clsCruiseReview;
    $lstReviewCruise = $clsCruiseReview->getAll("lang_id = '$lang_sql' and cruise_id = '" . $cruise_id . "' limit 0,1", $clsReviewsCruise->pkey . ',cruise_quality,food_drink,cabin_quality,staff_quality,entertainment,worth_the_money');
    $assign_list['lstReviewCruise'] = $lstReviewCruise[0];
    #

    $offset = ($page - 1) * $number_per_page;
    $LIMIT = " LIMIT $offset,$number_per_page";
    $lstReview = $clsReviews->getAll($cond . " order by order_no asc" . $LIMIT, $clsReviews->pkey . ',review_date,fullname,content,title,rates,reg_date,fullname,country_id');
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
    $assign_list["jsonReview"] = json_encode($jsonReview);
    //print_r(json_encode($jsonReview));die;
    unset($jsonReview);
    $assign_list["lstReview"] = $lstReview;
    unset($lstReview);
    $assign_list["pageview"] = $pageview;
    $assign_list["currentPage"] = 1;
    $assign_list["totalRecord"] = $totalRecord;
    $assign_list["totalPage"] = ceil($totalRecord / $number_per_page);

    if (isset($_POST['BookingCabin']) && $_POST['BookingCabin'] == 'BookingCabin') {
        $link = $clsCruise->getLinkBook($cruise_id, $oneTable);

        $arraybookCabin = $_POST;
        vnSessionSetVar('arraybookCabin', $arraybookCabin);

        header('location:' . $link);
        exit();
    }


    if (isset($_POST['ContactCruise']) && $_POST['ContactCruise'] == 'ContactCruise') {
        vnSessionDelVar('ContactCruise');
        vnSessionDelVar('ContactTour');
        vnSessionDelVar('ContactHotel');
        vnSessionDelVar('ContactVoucher');
        $cartSessionCruise = vnSessionGetVar('ContactCruise');
        if (empty($cartSessionCruise)) {
            $cartSessionCruise = array();
        }
        $assign_list["cartSessionCruise"] = $cartSessionCruise;

        $link = $clsCruise->getLinkContact();
        $cartSessionCruise['CRUISE'][$cruise_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionCruise['CRUISE'][$cruise_id][$k] = $v;
        }
        vnSessionSetVar('ContactCruise', $cartSessionCruise);
        header('location:' . $link);
        exit();
    }

    /*=============Title & Description Page==================*/
    if ($show == 'Itinerary') {
        $title_page = $clsCruiseItinerary->getTitleDay($cruise_itinerary_id) . ' | ' . $core->get_Lang('Cruise') . ' | ' . PAGE_NAME;
    } else {
        $title_page = $clsCruise->getTitle($cruise_id, $oneTable) . ' | ' . $core->get_Lang('Cruise') . ' | ' . PAGE_NAME;
    }

    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($cruise_id, 'Cruise', $oneTable);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cruise_id, 'Cruise', $oneTable);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
}
function default_detail2024()
{
    default_detail();
}
function default_loadReview()
{
    global $assign_list, $_CONFIG, $core, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO, $_lang, $extLang, $_LANG_ID, $clsISO;
    #
    $page = isset($_POST['page_Review']) ? $_POST['page_Review'] : 0;
    $tour_id = isset($_POST['cruise_id']) ? $_POST['cruise_id'] : 0;

    if ($page > 0 and $tour_id > 0) {
        $pageview = $page + 1;
        $limit_start = $page * 5;
        $limit_end = $pageview * 5 + 1;
        $cond = "is_trash=0 and is_online=1 and table_id = '$cruise_id' order by order_no DESC limit $limit_start , $limit_end ";
        $clsCruise_Review = new TourReview();
        $arraylstReview = $clsCruise_Review->getAll($cond, $clsCruise_Review->pkey . ' , review_date');

        if ($clsCruise_Review->countItem($cond) < 5) {
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
			  ' . $clsTour_Review->getRates($lstReview[$clsCruise_Review->pkey]) . '</label>
			  <p class="cus-rate">
				  <strong class="block z_12">
				  ' . $clsTour_Review->getFullName($lstReview[$clsCruise_Review->pkey]) . '
				  ,</strong>
				  <span class="z_10 block c6">
				  ' . $clsTour_Review->getCountry($lstReview[$clsCruise_Review->pkey]) . '
				 ,</span>
				  <span class="z_10 block c6">
				  ' . $clsISO->converTimeToText($lstReview['review_date']) . '
				  </span>
			  </p>
		  </div>
		  <div class="cus-desc">
			  <h5 class="z_14 text-bold text-uppercase c2a">
			  ' . $clsTour_Review->getTitle($lstReview[$clsCruise_Review->pkey]) . '</h5>
			  <div class="review-content">				
				  ' . html_entity_decode($clsCruise_Review->getContent($lstReview[$clsCruise_Review->pkey])) . '
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

function default_search()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $clsConfiguration;
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseStartDate = new CruiseStartDate();
    $assign_list["clsCruiseStartDate"] = $clsCruiseStartDate;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    #

    $duration = (isset($_GET['duration']) && $_GET['duration'] != '') ? $_GET['duration'] : '';
    $cruise_cat_id = (isset($_GET['cruise_cat_id']) && $_GET['cruise_cat_id'] != '') ? $_GET['cruise_cat_id'] : '0';
    $price_range_ID = (isset($_GET['price_range_ID']) && $_GET['price_range_ID'] != '') ? $_GET['price_range_ID'] : '';
    #
    $assign_list['linksort'] = $linksort;
    $sort = $_GET['sort'];
    $assign_list["sort"] = $sort;
    #
    $lnk = $_SERVER['REQUEST_URI'];
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $linkpage = substr($lnk, 0, $str_len);
    } else {
        $linkpage = $lnk;
    }
    $assign_list["linkpage"] = $linkpage;

    $recordPerPage = 8;
    $pageNum = 5;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    #
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    #
    $cond = "is_trash=0 and is_online=1";
    if (isset($cruise_cat_id) && intval($cruise_cat_id) != 0) {
        $cond .= " and cruise_id IN (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cruise_cat_id' or list_cat_id like '%|" . $cruise_cat_id . "|%'))";
    }
    if (isset($duration) && intval($duration) != 0) {
        $cond .= " and number_day = '$duration'";
        $assign_list["duration"] = $duration;
    }
    if (!empty($price_range_ID)) {
        $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
        if (!empty($lstSeason)) {
            $season = 'high';
        } else {
            $season = 'low';
        }

        $clsCruisePriceRange = new CruisePriceRange();

        $SQLMINRATE = "SELECT MIN(min_rate) FROM " . DB_PREFIX . "cruise_price_range WHERE cruise_price_range_id IN ($price_range_ID)";

        $SQLMAXRATE = "SELECT MAX(max_rate) FROM " . DB_PREFIX . "cruise_price_range WHERE cruise_price_range_id IN ($price_range_ID) and max_rate<>'0'";

        $SQLMINMAXRATE = "SELECT MIN(max_rate) FROM " . DB_PREFIX . "cruise_price_range WHERE cruise_price_range_id IN ($price_range_ID)";

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

        if ($min_rate > 0 && $max_rate > 0) {
            $cond .= " and min_" . $season . "_price > '$min_rate' and min_" . $season . "_price < '$max_rate'";
        } elseif ($min_rate == 0 && $max_rate > 0) {
            $cond .= " and min_" . $season . "_price < '$max_rate'";
        } elseif ($min_rate > 0 && $max_rate == 0) {
            $cond .= " and min_" . $season . "_price >= '$min_rate'";
        } elseif ($min_rate == 0 && $max_rate == 0) {
            $cond .= " and min_" . $season . "_price >= '$min_rate'";
        } else {
            $cond .= " and min_" . $season . "_price > '$min_rate'";
        }
        $assign_list["price_range_ID"] = $price_range_ID;
    }
    #
    $cond .= " order by min_" . $season . "_price asc";
    #
    $lstCruiseSearch = $clsCruiseItinerary->getAll($cond, $clsCruiseItinerary->pkey . ",cruise_id,cruise_itinerary_id");
    //print_r($lstCruiseSearch);die();
    $assign_list["lstCruiseSearch"] = $lstCruiseSearch;

    $totalRecord = !empty($lstCruiseSearch) ? count($lstCruiseSearch) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    #
    $first = intval($currentPage / $pageNum) * $pageNum;
    $pageView = "";
    for ($i = 0; $i < $pageNum; $i++)
        if ($first + $i < $totalPage) {
            $link = $linkpage . "&page=" . ($first + $i + 1);
            $page = ($first + $i + 1 == $currentPage) ? '<a class="current" href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>' : '<a href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>';
            $pageView .= $page;
        }
    #
    $assign_list['currentPage'] = $currentPage;
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['pageNum'] = $pageNum;
    $assign_list['pageView'] = $pageView;


    vnSessionSetVar('duration_0', $duration);

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Find your cruise') . ' - ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_cat()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $domain, $clsConfiguration, $cat_id, $clsISO, $now_month, $now_day, $extLang;
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsCruiseStartDate = new CruiseStartDate();
    $assign_list["clsCruiseStartDate"] = $clsCruiseStartDate;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruisePriceRange = new CruisePriceRange();
    $assign_list["clsCruisePriceRange"] = $clsCruisePriceRange;
    $clsBlog = new Blog();
    $assign_list["clsBlog"] = $clsBlog;
    $clsBlogCategory = new BlogCategory();
    $assign_list["clsBlogCategory"] = $clsBlogCategory;
    #
    $sortby = isset($_GET['sortby']) ? $_GET['sortby'] : '0';
    $assign_list["sortby"] = $sortby;

    $lnk = $_SERVER['REQUEST_URI'];
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $linkpage = substr($lnk, 0, $str_len);
    } else {
        $linkpage = $lnk;
    }
    $assign_list["linkpage"] = $linkpage;
    #
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    $cat_id = $clsCruiseCat->getBySlug($slug);
    if (intval($cat_id) == 0) {
        header('Location:' . PCMS_URL . $extLang);
        exit();
    }

    $assign_list['cat_ID'] = $cat_id;

    #
    $pageNum = 5;
    $recordPerPage = 6;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    #
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    #
    $cond = "is_trash=0 and is_online=1";
    if ($cat_id > 0) {
        $cond .= " and (cruise_cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%')";
        $assign_list["cruise_cat_id"] = $cat_id;
    }
    $checkFilter = $clsCruise->getAll($cond, $clsCruise->pkey);
    $assign_list['checkFilter'] = $checkFilter;
    #filter
    $place = Input::get('place', 0);
    $assign_list['place'] = $place;
    $star_number = Input::get('star_number', 0);
    $assign_list['star_number'] = explode(",", $star_number);
    $price_range_ID = Input::get('price_range_ID', 0);
    $assign_list['price_range_ID'] = explode(",", $price_range_ID);
    if ($place > 0) {
        $cond .= " and cruise_id IN (SELECT cruise_id FROM default_cruise_destination WHERE is_trash=0 and city_id='" . $place . "') ";
    }
    if ($star_number > 0) {
        $cond .= " and star_number='" . $star_number . "'";
    }
    if ($price_range_ID > 0) {
        #filter price
        $sql_price = '';
        if (!empty($price_range_ID)) {
            $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
            if (!empty($lstSeason)) {
                $season = 'high';
            } else {
                $season = 'low';
            }
            $lstAllCruise = $clsCruise->getAll("is_trash=0 and is_online=1", $clsCruise->pkey);
            foreach ($lstAllCruise as $key => $value) {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_id='" . $value['cruise_id'] . "' and season ='$season'";
                $price = $dbconn->GetOne($SQL);
                $discount = $clsISO->getPromotion($value['cruise_id'], 'Cruise', $now_day, $now_day, 'info_promotion');
                $promotion = 0;
                $min_price = (!empty($price)) ? $price : 0;
                if (!empty($discount)) {
                    $promotion = $discount['discount_value'];
                    if ($discount['discount_type'] == 2) {
                        $min_price = $price - ($promotion * $price / 100);
                    } else {
                        $min_price = $price - $discount['discount_value'];
                    }
                }
                //					$clsCruise->updateOne($value['cruise_id'],"min_price='".$min_price."'");
            }

            $clsCruisePriceRange = new CruisePriceRange();

            $sql_price = ' and (';
            $onePriceRange = $clsCruisePriceRange->getOne($price_range_ID, 'min_rate,max_rate');
            $min_rate = $onePriceRange['min_rate'];
            $max_rate = $onePriceRange['max_rate'];
            if ($min_rate == 0 && $max_rate > 0) {
                $sql_price .= "min_price <= " . $max_rate . " ";
            } else if ($min_rate > 0 && $max_rate == 0) {
                $sql_price .= "min_price >= " . $min_rate . " ";
            } else {
                $sql_price .= "min_price BETWEEN " . $min_rate . " AND " . $max_rate . "  ";
            }
            $sql_price .= ")";
        }
        $cond .= $sql_price;
    }
    //	echo $cond;die;
    if ($sortby == '0') {
        $order_by = " order by order_no asc";
    } elseif ($sortby == 'popular') {
        $order_by = " order by view_num desc";
    } else {
        $order_by = " order by cruise_id desc";
    }
    #
    //	$clsCruise->setDeBug(1);
    $listCruise = $clsCruise->getAll($cond . $order_by, $clsCruise->pkey . ',title,slug,star_number,about,image,departure_port,highlight');
    //	die;

    if ($sortby == 'toprate') {
        foreach ($listCruise as $k => $v) {
            $listCruise[$k]['hrate'] = $clsReviews->getRateAvg($v[$clsCruise->pkey]);
        }
        uasort($listCruise, "compare_rate");
    }
    $assign_list['listCruise'] = $listCruise;
    unset($listCruise);
    /*$cond2=" and cruise_id NOT IN (SELECT cruise_id From default_cruise_store where ( _type='BEST' or _type='RECOMMED'))";

    $lstCruiseTopBest = $clsPromotion->getAll("is_online=1 and clsTable='Cruise'  and ".time()." between  start_date and end_date and target_id IN (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')) ORDER BY promotion_id  DESC",$clsPromotion->pkey.",target_id,cruise_itinerary_id,price_text");
    $assign_list["lstCruiseTopBest"] = $lstCruiseTopBest;
    unset($lstCruiseTopBest);
    #
    $lstCruiseTopPromotion = $clsCruiseStore->getAll("cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')) and _type='RECOMMED' ORDER BY order_no asc limit 0,6",$clsCruiseStore->pkey.',cruise_id');
    $assign_list["lstCruiseTopPromotion"] = $lstCruiseTopPromotion;
    $RecordPageCruisePromotion = $lstCruiseTopPromotion?count($clsCruiseStore->getAll("cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')) and _type='RECOMMED' ORDER BY order_no  asc",'cruise_id')):0;
    unset($lstCruiseTopPromotion);
    $TotalPageCruisePromotion = ceil($RecordPageCruisePromotion/6);
    $assign_list['TotalPageCruisePromotion']=$TotalPageCruisePromotion;
    $assign_list['currentPagePromo']=1;
    #
    $listCruiseOtherFull=$clsCruise->getAll("cruise_id NOT IN (SELECT default_cruise_store.cruise_id FROM default_cruise_store WHERE is_trash = 0 and _type='RECOMMED') and is_trash=0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%') ORDER BY order_no asc",$clsCruise->pkey);
    //echo $cond.$cond2.$order_by;die('xxxx');
    $RecordPageCruiseOrther = $listCruiseOtherFull?count($listCruiseOtherFull):0;
    $TotalPageCruiseOrther = ceil($RecordPageCruiseOrther/6);
    $assign_list['TotalPageCruiseOrther']=$TotalPageCruiseOrther;
    $assign_list['currentPageOther']=1;
    $listCruiseOther=$clsCruise->getAll("cruise_id NOT IN (SELECT default_cruise_store.cruise_id FROM default_cruise_store WHERE is_trash = 0 and _type='RECOMMED') and is_trash=0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%') ORDER BY order_no asc limit 0,6",$clsCruise->pkey.',title,slug');
    $assign_list["listCruiseOther"] = $listCruiseOther;
    unset($listCruiseOther);


    $lstBlogHaLong = $clsBlog->getAll("is_trash=0 and is_online=1 and blog_id IN (select blog_id FROM ".DB_PREFIX."blog_destination WHERE city_id ='417') order by reg_date desc",$clsBlog->pkey);
    $assign_list["lstBlogHaLong"] = $lstBlogHaLong;*/

    #
    $allCruise = $clsCruise->getAll($cond, $clsCruise->pkey);
    $totalRecord = $allCruise ? count($allCruise) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    #
    $first = intval($currentPage / $pageNum) * $pageNum;
    $pageView = "";
    for ($i = 0; $i < $pageNum; $i++)
        if ($first + $i < $totalPage) {
            $link = $linkpage . "&page=" . ($first + $i + 1);
            $page = ($first + $i + 1 == $currentPage) ? '<a class="current" href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>' : '<a href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>';
            $pageView .= $page;
        }
    #
    $assign_list['currentPage'] = $currentPage;
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['pageNum'] = $pageNum;
    $assign_list['pageView'] = $pageView;

    #
    $oneCat = $clsCruiseCat->getOne($cat_id, $clsCruiseCat->pkey . ',title,image,image_banner,slug,intro');
    $assign_list['oneCat'] = $oneCat;
    $title_cat = $clsCruiseCat->getTitle($cat_id, $oneCat);
    $assign_list['title_cat'] = $title_cat;
    $link_cat = $clsCruiseCat->getLink($cat_id, $oneCat);
    $assign_list['link_cat'] = $link_cat;
    $intro_More = $clsCruiseCat->getIntro($cat_id, $oneCat);
    $assign_list['intro_More'] = $intro_More;

    /*=============Title & Description Page==================*/
    $title_page = $title_cat . ' | ' . $core->get_Lang('Cruise') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsCruiseCat->getMetaDescription($cat_id, $oneCat);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cat_id, 'CruiseCat', $oneCat);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
}

function default_cat2024()
{
    global $now_month, $smarty, $dbconn, $lang_sql, $assign_list, $core,  $title_page, $description_page, $global_image_seo_page, $cat_id, $clsISO, $extLang;
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;
    #
    #Danh sách file css sử dụng cho trang home
    Asset::css([
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$upd_version}",
        "{$URL_CSS}/cruise_cat2024.css?v={$upd_version}"
    ]);

    Asset::js([
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$upd_version}",
    ]);
    #
    $clsCruiseCat = new CruiseCat();
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsCruiseStartDate = new CruiseStartDate();
    $assign_list["clsCruiseStartDate"] = $clsCruiseStartDate;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruisePriceRange = new CruisePriceRange();
    $assign_list["clsCruisePriceRange"] = $clsCruisePriceRange;
    $clsBlog = new Blog();
    $assign_list["clsBlog"] = $clsBlog;
    $clsBlogCategory = new BlogCategory();
    $assign_list["clsBlogCategory"] = $clsBlogCategory;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    $cat_id = $clsCruiseCat->getBySlug($slug);
    if (empty($cat_id)) {
        header('Location:' . PCMS_URL . $extLang);
        exit();
    }
    $assign_list['cat_ID'] = $cat_id;
    #submit
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = $_POST;
        $link = $clsCruiseCat->getLink($cat_id);
        $first = true;
        foreach ($data as $key => $value) {
            $link .= ($first ? '?' : '&') . "$key=" . (is_array($value) ? $clsISO->makeSlashListFromArrayComma($value) : $value);
            $first = false;
        }
        header('location:' . trim($link));
        exit();
    }

    #
    $currentPage = $_GET["page"] ?? 1;
    $recordPerPage = 10;
    
    $filter =  [
        'page' => $currentPage,
        'cat_id' => $cat_id,
        'sort' => $_GET["sort"],
        'price_id' => $_GET["price_id"],
        'itineraries' => $_GET["itineraries"],
        'rank_cruise' => $_GET["rank_cruise"],
        'cabins' => $_GET["cabins"],
        
    ];

    $listCruise = filter_cruise($filter);

    $assign_list['listCruise'] = $listCruise;
    unset($listCruise);

    # Paginate
    $clsPagination = new Pagination();
    $totalRecord = filter_cruise($filter, true);

    if ($totalRecord) {
        $totalRecord = count($totalRecord);
    } else {
        $totalRecord = 0;
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

    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
        'link' => str_replace('.html', '/', $link_page),
        'link_page_1' => $link_page
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links();

    $assign_list["page_view"] = $page_view;
    $assign_list["totalRecord"] = $totalRecord;
    $assign_list["totalPage"] = $clsPagination->getTotalPage();

    #
    $oneCat = $clsCruiseCat->getOne($cat_id, $clsCruiseCat->pkey . ',title,image,image_banner,slug,intro');
    $assign_list['oneCat'] = $oneCat;
    $title_cat = $clsCruiseCat->getTitle($cat_id, $oneCat);
    $assign_list['title_cat'] = $title_cat;
    $link_cat = $clsCruiseCat->getLink($cat_id, $oneCat);
    $assign_list['link_cat'] = $link_cat;
    $intro_More = $clsCruiseCat->getIntro($cat_id, $oneCat);
    $assign_list['intro_More'] = $intro_More;

    /*=============Title & Description Page==================*/
    $title_page = $title_cat . ' | ' . $core->get_Lang('Cruise') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsCruiseCat->getMetaDescription($cat_id, $oneCat);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cat_id, 'CruiseCat', $oneCat);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
}

function default_catchild()
{
    global $assign_list, $core,  $title_page, $description_page, $global_image_seo_page, $cat_id, $clsISO, $extLang;
    #
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;
    #
    #Danh sách file css xử dụng cho trang home
    Asset::css([
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
        "{$URL_CSS}/compress/owl.carousel.min.css?v={$upd_version}",
        "{$URL_CSS}/cruise_cat2024.css?v={$upd_version}"
    ]);

    Asset::js([
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$upd_version}",
    ]);
    #
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $slug_parent = $_GET["slug_parent"] ?? "";
    $cat_id_parent = $clsCruiseCat->getBySlug($slug_parent);
    $assign_list["cat_id_parent"] = $cat_id_parent;
    $slug_child = $_GET['slug_child'] ?? '';
    $cat_id = $clsCruiseCat->getBySlug($slug_child);
    if (empty($cat_id)) {
        header('Location:' . PCMS_URL . $extLang);
        exit();
    }
    $cond = "is_trash=0 and is_online=1 ";
    $order_by = " order by cruise_id desc";
    if ($cat_id > 0) {
        $cond .= " and (cruise_cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%')";
        $assign_list["cat_id"] = $cat_id;
    }

    #submit
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = $_POST;
        $link = $clsCruiseCat->getLinkCatChild($cat_id);
        $first = true;
        foreach ($data as $key => $value) {
            $link .= ($first ? '?' : '&') . "$key=" . (is_array($value) ? $clsISO->makeSlashListFromArrayComma($value) : $value);
            $first = false;
        }
        header('location:' . trim($link));
        exit();
    }

    $listCruise = $clsCruise->getAll($cond . $order_by, $clsCruise->pkey . ',title,slug,star_number,about,image,departure_port,highlight');
    $totalRecord = $listCruise ? count($listCruise) : 0;

    $assign_list["listCruise"] = $listCruise;
    $assign_list['totalRecord'] = $totalRecord;
    #
    $oneCat = $clsCruiseCat->getOne($cat_id, $clsCruiseCat->pkey . ',title,image,image_banner,slug,intro');
    $assign_list['oneCat'] = $oneCat;
    $title_cat = $clsCruiseCat->getTitle($cat_id, $oneCat);
    $assign_list['title_cat'] = $title_cat;
    $link_cat = $clsCruiseCat->getLink($cat_id, $oneCat);
    $assign_list['link_cat'] = $link_cat;
    $intro_More = $clsCruiseCat->getIntro($cat_id, $oneCat);
    $assign_list['intro_More'] = $intro_More;

    /*=============Title & Description Page==================*/
    $title_page = $title_cat . ' | ' . $core->get_Lang('Cruise') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsCruiseCat->getMetaDescription($cat_id, $oneCat);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($cat_id, 'CruiseCat', $oneCat);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
}

function compare_rate($hrate1, $hrate2)
{
    if ($hrate1["hrate"] > $hrate2["hrate"]) {
        return -1;
    } else if ($hrate1["hrate"] == $hrate2["hrate"]) {
        return 0;
    } else {
        return 1;
    }
}

function default_tag()
{

    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang;
    global $clsISO;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;

    //print_r($show); die();

    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    $clsCruiseStartDate = new CruiseStartDate();
    $assign_list["clsCruiseStartDate"] = $clsCruiseStartDate;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseVideo = new CruiseVideo();
    $assign_list["clsCruiseVideo"] = $clsCruiseVideo;
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;
    #
    $sortby = isset($_GET['sortby']) ? $_GET['sortby'] : 0;
    $assign_list["sortby"] = $sortby;

    $lnk = $_SERVER['REQUEST_URI'];
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $linkpage = substr($lnk, 0, $str_len);
    } else {
        $linkpage = $lnk;
    }
    $assign_list["linkpage"] = $linkpage;

    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    $tag_id = $clsTag->getBySlug($slug);

    if (intval($tag_id) == 0) {
        header('Location:' . PCMS_URL . $extLang);
        exit();
    }

    $assign_list['tag_id'] = $tag_id;

    #
    $oneItem = $clsTag->getOne($tag_id);
    #
    $title_page = $clsTag->getTitle($tag_id);

    $cond = "is_trash=0 and is_online=1";

    $cond .= " and (list_tag_id like '%|$tag_id|%')";

    if ($sortby == '0') {
        $order_by = " order by order_no desc";
    } elseif ($sortby == 'popular') {
        $order_by = " order by view_num desc";
    } elseif ($sortby == 'toprate') {
        $order_by = " order by total_rate desc";
    } else {
        $order_by = " order by cruise_id desc";
    }
    //print_r($order_by); die();
    #
    $listCruise = $clsCruise->getAll($cond . $order_by);
    $assign_list['listCruise'] = $listCruise;
    unset($listCruise);
    #
    $totalRecord = $clsCruise->getAll($cond) ? count($clsCruise->getAll($cond)) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    #
    $first = intval($currentPage / $pageNum) * $pageNum;
    $pageView = "";
    for ($i = 0; $i < $pageNum; $i++)
        if ($first + $i < $totalPage) {
            $link = $linkpage . "&page=" . ($first + $i + 1);
            $page = ($first + $i + 1 == $currentPage) ? '<a class="current" href="' . $link . '" title="' . $core->get_Lang('page') . ' .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>' : '<a href="' . $link . '" title="' . $core->get_Lang('page') . ' .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>';
            $pageView .= $page;
        }
    #
    $assign_list['currentPage'] = $currentPage;
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['pageNum'] = $pageNum;
    $assign_list['pageView'] = $pageView;

    /*=============Title & Description Page==================*/
    $title_page = $clsCruiseCat->getTitle($cat_id) . ' | Cruise | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_book()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO, $clsConfiguration;
    global $_lang, $extLang, $_LANG_ID;

    print_r(xxx);
    die();

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Booking') . ' ' . $clsCruise->getTitle($cruise_id) . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $core->get_Lang('Booking') . ' ' . $clsCruise->getTitle($cruise_id) . ' | ' . PAGE_NAME;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $core->get_Lang('Booking') . ' ' . $clsCruise->getTitle($cruise_id) . ' | ' . PAGE_NAME;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_bookcabin()
{
    global $assign_list, $extLang, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO, $profile_id, $loggedIn;
    global $extLang, $_LANG_ID;
    # - Check Login
    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;
    if (_ISOCMS_CLIENT_LOGIN == 222) {
        if (!$loggedIn) {
            $link = $extLang . '/account/signin/r=' . $_SERVER['REQUEST_URI'];
            header('Location:' . $link);
            exit();
        }
    }
    $arraycheckrateCabin = vnSessionGetVar('arraycheckrateCabin');
    $arraybookCabin = vnSessionGetVar('arraybookCabin');
    $clsProperty = new Property();
    $assign_list['clsProperty'] = $clsProperty;
    $clsReviews = new Reviews();
    $assign_list['clsReviews'] = $clsReviews;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseCat = new CruiseCat();
    $assign_list["clsCruiseCat"] = $clsCruiseCat;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruiseImage = new CruiseImage();
    $assign_list["clsCruiseImage"] = $clsCruiseImage;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruiseService = new CruiseService();
    $assign_list["clsCruiseService"] = $clsCruiseService;
    $clsCountry = new _Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsBooking = new Booking();
    #
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    $cruise_id = $clsCruise->getBySlug($slug);
    if ($cruise_id == '') {
        header('location:' . PCMS_URL);
        exit();
    }
    $assign_list['cruise_id'] = $cruise_id;
    $oneItem = $clsCruise->getOne($cruise_id);
    $assign_list['one'] = $oneItem;
    $assign_list['oneItem'] = $oneItem;
    $cruise_cat_id = $oneItem['cruise_cat_id'];
    $assign_list['cruise_cat_id'] = $cruise_cat_id;
    #
    $cruise_cabin_id = isset($arraybookCabin['cruise_cabin_id']) ? $arraybookCabin['cruise_cabin_id'] : 0;
    $assign_list["cruise_cabin_id"] = $cruise_cabin_id;
    #
    $cruise_itinerary_id = isset($arraybookCabin['cruise_itinerary_id']) ? $arraybookCabin['cruise_itinerary_id'] : 0;
    $assign_list["cruise_itinerary_id"] = $cruise_itinerary_id;

    $number_adult = isset($arraybookCabin['number_adult']) ? $arraybookCabin['number_adult'] : 0;
    $assign_list["number_adult"] = $number_adult;

    $number_child = isset($arraybookCabin['number_child']) ? $arraybookCabin['number_child'] : 0;
    $assign_list["number_child"] = $number_child;

    $number_cabin = isset($arraybookCabin['number_cabin']) ? $arraybookCabin['number_cabin'] : 0;
    $assign_list["number_cabin"] = $number_cabin;

    $max_adult = isset($arraybookCabin['max_adult']) ? $arraybookCabin['max_adult'] : 0;
    $assign_list["max_adult"] = $max_adult;
    $assign_list["arraycheckrateCabin"] = $arraycheckrateCabin;

    $departure_date = isset($arraybookCabin['departure_date']) ? $arraybookCabin['departure_date'] : 0;
    $assign_list["departure_date"] = $departure_date;


    $oneItinerary = $clsCruiseItinerary->getOne($cruise_itinerary_id);
    $assign_list["oneItinerary"] = $oneItinerary;
    #
    $totalPrice = isset($arraybookCabin['totalPrice']) ? $arraybookCabin['totalPrice'] : 0;
    $totalPrice_format = number_format($totalPrice, 0, ",", ".");
    $assign_list["totalPrice"] = $totalPrice;
    $assign_list["totalPrice_format"] = $totalPrice_format;
    #
    $listService = $clsCruiseService->getAll('is_trash=0 and is_online=1 order by order_no ASC', $clsCruiseService->pkey . ",extra");
    $assign_list["listService"] = $listService;
    unset($listService);
    #- Get Member Information
    if (_ISOCMS_CLIENT_LOGIN) {
        $name = $clsProfile->getFullname($profile_id);
        $assign_list['name'] = $name;
        $email = $clsProfile->getEmail($profile_id);
        $assign_list['email'] = $email;
        $phone = $clsProfile->getPhone($profile_id);
        $assign_list['phone'] = $phone;
        $address = $clsProfile->getAddress($profile_id);
        $assign_list['address'] = $address;
        $country_id = $clsProfile->getOneField('country_id', $profile_id);
        $assign_list['country_id'] = $country_id;
    }
    #
    $errMsg = '';
    if (isset($_POST['HidBookNow']) && $_POST['HidBookNow'] == 'HidBookNow') {
        $departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
        $departure_date_post = strtotime($departure_date);
        $num_day = isset($_POST['num_day']) ? intval($_POST['num_day']) : 0;
        $end_date = date('m/d/Y', strtotime('+' . $num_day . ' day', strtotime($departure_date)));
        #
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $name = $first_name . ' ' . $last_name;
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        #- Verify Captcha
        if (_ISOCMS_CAPTCHA == 'IMG') {
            $security_code = isset($_POST["security_code"]) ? trim($_POST["security_code"]) : '';
            $security_code = strtoupper($security_code);
            if (!empty($security_code) && $security_code != $_SESSION['skey']) {
                $errMsg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        } else if (_ISOCMS_CAPTCHA == 'reCAPTCHA') {
            if (!$clsISO->checkGoogleReCAPTCHA()) {
                $errMsg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        }
        $assign_list["errMsg"] = $errMsg;
        if (trim($errMsg) == '') {
            $booking_id = $clsBooking->getMaxId();
            $booking_code = $clsBooking->generateBookingCode($booking_id, 'Cruise');
            #
            $fx = "booking_id,
			target_id,
			full_name,
			email,
			phone,
			address,
			country_id,
			clsTable,
			booking_type,
			booking_code,
			booking_store,
			reg_date,
			ip_booking,
			status,
			totalgrand,
			deposit,
			balance,
			departure_date,
			check_in,
			check_out";
            #
            $vx = "'$booking_id'
			,'$cruise_id'
			,'$name'
			,'$email'
			,'$phone'
			,'$address'
			,'$country'
			,'Cruise'
			,'Cruise'
			,'$booking_code'
			,'" . serialize($_POST) . "'
			,'" . time() . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'0'
			,'" . $clsISO->processSmartNumber(str_replace('.00', '', $_POST['totalGrand'])) . "'
			,'" . $clsISO->processSmartNumber(str_replace('.00', '', $_POST['totalGrand'])) . "'
			,'0'
			,'" . $departure_date_post . "'
			,'" . $departure_date . "'
			,'" . $end_date . "'";
            if (_ISOCMS_CLIENT_LOGIN) {
                $fx .= ",member_id";
                $vx .= ",'$profile_id'";
            }
            if (PAYMENT_GLOBAL) {
                $fx .= ",payment_method";
                $vx .= ",'" . intval($_POST['payment_method']) . "'";
            }
            if ($clsBooking->insertOne($fx, $vx)) {
                $clsBooking->sendEmailBookingCruise($booking_id);
                if (PAYMENT_GLOBAL) {
                    $clsBilling = new Billing();
                    $clsBilling->initPay($booking_id);
                }
                vnSessionDelVar('arraycheckrateCabin');
                header('Location:' . $extLang . '/booking/cruise/successful');
                exit();
            }
        } else {
            foreach ($_POST as $k => $v) {
                $assign_list[$k] = $v;
            }
            $assign_list["errMsg"] = $errMsg;
        }
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Booking Cruise') . ' | ' . $clsCruise->getTitle($cruise_id) . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_ajchangeToRateServices()
{
    global $core, $clsISO, $_LANG_ID;
    $clsCruiseService = new CruiseService();
    #
    $_LANG_ID = isset($_GET['lang']) ? $_GET['lang'] : '';
    $cruise_service_id = isset($_POST['cruise_service_id']) ? intval($_POST['cruise_service_id']) : '';
    $number = isset($_POST['number']) ? intval($_POST['number']) : 0;
    $extra = isset($_POST['extra']) ? intval($_POST['extra']) : 0;
    #
    if ($extra == 1) {
        $totalRate = $clsCruiseService->getPriceValue($cruise_service_id);
    } else if ($extra == 2) {
        $totalRate = $clsCruiseService->getPriceNumber($cruise_service_id) * $number;
    }
    echo $clsISO->formatPrice($totalRate) . '$$$' . $totalRate;
    die();
}

function default_getTotalRateAddOnService()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
    global $extLang, $_LANG_ID;
    #
    $_LANG_ID = isset($_GET['lang']) ? $_GET['lang'] : '';
    $clsCruiseService = new CruiseService();
    $BOOK_VAL = vnSessionGetVar('BOOK_VAL');
    $totalRate = $BOOK_VAL['totalGrand'];

    $listAddOnServiceID = $_POST['listAddOnServiceID'];
    if ($listAddOnServiceID != '' && $listAddOnServiceID != '0' && $listAddOnServiceID != '|') {
        $tmp = explode('|', $listAddOnServiceID);
        if (is_array($tmp)) {
            for ($i = 0; $i < count($tmp); $i++) {
                $totalRate += $clsCruiseService->getPrice($tmp[$i]);
            }
        }
    }
    echo $clsISO->formatPrice($totalRate) . '$$$' . $clsISO->formatPrice($totalRate);
    die();
}

function default_ajLoadSelectCabin()
{
    global $core, $clsISO, $_lang;
    #
    $clsCruise = new Cruise();
    $clsCruiseCabin = new CruiseCabin();
    $clsCruisePriceTable = new CruisePriceTable();

    $cruise_id = $_POST['cruise_id'];
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
    $cruise_cabin_id = $_POST['cruise_cabin_id'];

    $lstCruiseCabin = $clsCruisePriceTable->getAll("cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' order by price ASC");
    $Html = '<option value=""> -- ' . $core->get_Lang('Select cabin') . ' --</option>';
    if ($lstCruiseCabin[0][$clsCruiseCabin->pkey] != '') {
        $cabin = array();
        for ($i = 0; $i < count($lstCruiseCabin); $i++) {
            if (!in_array($lstCruiseCabin[$i][$clsCruiseCabin->pkey], $cabin)) {
                $cabin[] = $lstCruiseCabin[$i][$clsCruiseCabin->pkey];
            }
        }
        #
        for ($i = 0; $i < count($cabin); $i++) {
            $selected_index = ($cruise_cabin_id == $cabin[$i]) ? 'selected="selected"' : '';
            $Html .= '<option value="' . $cabin[$i] . '" ' . $selected_index . '> -- ' . $clsCruiseCabin->getTitle($cabin[$i]) . ' -- </option>';
        }
        unset($lstCruiseCabin);
    }
    echo $Html;
    die();
}

function default_ajLoadSelectTypeOfRoom()
{
    global $core, $clsISO, $_lang, $oneCommon, $clsConfiguration;
    $clsCruise = new Cruise();
    $clsCruiseCabin = new CruiseCabin();
    $clsCruiseItinerary = new CruiseItinerary();
    $clsCruisePriceTable = new CruisePriceTable();
    $clsCruiseSeasonPrice = new CruiseSeasonPrice();
    $clsCruiseProperty = new CruiseProperty();
    $clsProperty = new Property();
    #
    $Html = '';
    $cruise_id = intval($_POST['cruise_id']);
    $cruise_itinerary_id = intval($_POST['cruise_itinerary_id']);
    $cruise_cabin_id = intval($_POST['cruise_cabin_id']);
    if ($cruise_itinerary_id == 0) {
        echo '_invalid';
        die();
    }
    $departure_date = $_POST['departure_date'];
    $tmp = explode("/", $departure_date);
    $month = $tmp[0];

    $oneItinerary = $clsCruiseItinerary->getOne($cruise_itinerary_id);
    $_hight_season_month = $oneItinerary['high_season_month'];
    $sesson = 'low';
    if (strpos($_hight_season_month, "|$month|")) {
        $sesson = 'high';
    }
    $cond = "cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' 
	and cruise_cabin_id='$cruise_cabin_id' and season='$sesson' order by price asc";
    $lstCruiseSeason = $clsCruiseSeasonPrice->getAll($cond);

    if (1 == 2) {
        $cruise_itinerary_id = $_POST['cruise_itinerary_id'];
        $cruise_cabin_id = $_POST['cruise_cabin_id'];
        $arr_month_hight_season = explode(',', $clsConfiguration->getValue('hightseason'));
        $season = 1;
        #
        if (in_array($month_departure_date, $arr_month_hight_season)) {
            $season = 2;
        }
        $lstBed = $clsCruisePriceTable->getAll("cruise_id='$cruise_id' and cruise_itinerary_id='$cruise_itinerary_id' and cruise_cabin_id='$cruise_cabin_id' and season='$season'", 'price,' . $clsProperty->pkey);
        $Html = '';
        if (is_array($lstBed) && count($lstBed) > 0) {
            for ($i = 0; $i < count($lstBed); $i++) {
                $Html .= '<label class="radio-lg"><input value="' . $lstBed[$i][$clsProperty->pkey] . '" class="rdo_typeofroom" name="typeofroom" data-price="' . $lstBed[$i]['price'] . '" type="radio"> ' . $clsProperty->getTitle($lstBed[$i][$clsProperty->pkey]) . '</label>';
            }
            unset($lstBed);
        }
    } else {
        if (!empty($lstCruiseSeason)) {
            foreach ($lstCruiseSeason as $k => $v) {
                $Html .= '
				<label class="radio-lg" style="margin-bottom:5px;">
					<input value="' . $v[$clsCruiseSeasonPrice->pkey] . '" class="rdo_typeofroom" name="typeofroom" data-price="' . $v['price'] . '" type="radio"> ' . $clsCruiseProperty->getTitle($v['cabin_type_id']) . ' (US$ ' . $clsISO->formatPrice($v['price']) . ')
				</label>';
            }
        } else {
            $Html = '_empty';
        }
    }
    echo $Html;
    die();
}

function default_ajLoadListServicePrivate()
{
    global $core, $clsISO, $_lang;
    $clsCruise = new Cruise();
    $clsCruiseItinerary = new CruiseItinerary();
    $clsCruiseService = new CruiseService();

    $cruise_id = intval($_POST['cruise_id']);
    $cruise_itinerary_id = intval($_POST['cruise_itinerary_id']);

    $oneItinerary = $clsCruiseItinerary->getOne($cruise_itinerary_id);
    $_list_service_private = $oneItinerary['listService'];
    $_list_service_private = ltrim($_list_service_private, '|');
    $_list_service_private = rtrim($_list_service_private, '|');
    $_list_service_private = str_replace('||', '|', $_list_service_private);
    $_temp_array = array();
    if (!empty($_list_service_private)) {
        $_temp_array = explode('|', $_list_service_private);
    }
    #
    if (empty($_temp_array)) {
        $oneCruise = $clsCruise->getOne($cruise_id);
        $list_cruise_service = $oneCruise['list_cruise_service'];
        if ($list_cruise_service != '' && $list_cruise_service != '0') {
            $list_cruise_service = ltrim($list_cruise_service, '|');
            $list_cruise_service = rtrim($list_cruise_service, '|');
            $list_cruise_service = str_replace('||', '|', $list_cruise_service);
            $_temp_root = explode('|', $list_cruise_service);
            for ($i = 0; $i < count($_temp_root); $i++) {
                if (!in_array($_temp_root[$i], $_temp_array)) {
                    $_temp_array[] = $_temp_root[$i];
                }
            }
        }
    }
    if (!empty($_temp_array)) {
        $html = '
		<table cellpadding="0" cellspacing="0" class="book_service_table">';
        foreach ($_temp_array as $k => $v) {
            $html .= '
				<tr>
					<td width="88%" class="padding_left_20">    
						<label style="width:auto; cursor:pointer; text-align:left"><input data-price="' . $clsCruiseService->getPrice($v, 0) . '" class="rdo_serviceID" type="checkbox" name="optional_services[]" value="' . $v . '" /> ' . $clsCruiseService->getTitle($v) . '</label>
					</td>
					<td align="right">
						<div class="price-inc">' . $clsCruiseService->getPrice($v) . '</div>
					</td>
				</tr>
				';
        }
        $html .= '
		</table>';
    }
    echo $html;
    die();
}

function default_ajGetRateChooice()
{
    global $core, $clsISO, $_lang;
    #
    $clsCruise = new Cruise();
    $clsCruiseCabin = new CruiseCabin();
    $clsCruiseService = new CruiseService();
    $clsCruiseStartDate = new CruiseStartDate();
    #
    $cruise_id = isset($_POST['cruise_id']) ? intval($_POST['cruise_id']) : 0;
    $depature_date_select = isset($_POST['depature_date_select']) ? $_POST['depature_date_select'] : '';
    $departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
    $cruise_cabin_id = isset($_POST['cruise_cabin_id']) ? intval($_POST['cruise_cabin_id']) : 0;
    #
    $list_service_id = trim($_POST['list_service_id']);
    $list_service_id = str_replace(',,', ',', $list_service_id);
    $tmp = explode(',', $list_service_id);
    #
    $totalPrice = 0;
    #
    if (!empty($depature_date_select) || !empty($departure_date)) {
        $start_date = '';
        if (!empty($depature_date_select)) {
            $start_date = $depature_date_select;
        }
        if (!empty($departure_date)) {
            $start_date = strtotime($departure_date);
        }
        $res = $clsCruiseStartDate->getAll("is_trash=0 and cruise_id = '$cruise_id' and start_date = '$start_date' limit 0,1");
        $priceStartDate = !empty($res[0]['price']) ? intval($res[0]['price']) : 0;
        $totalPrice += $priceStartDate;
    } elseif (intval($cruise_id)) {
        $priceCruise = $clsCruise->getOneField('cruise_price', $cruise_id);
        $totalPrice += $priceCruise;
    }
    if (is_array($tmp) && !empty($tmp)) {
        foreach ($tmp as $i) {
            $totalPrice += $clsCruiseService->getOneField('price', $i);
        }
    }
    if (intval($cruise_cabin_id) != 0) {
        $priceCabin = $clsCruiseCabin->getOneField('price', $cruise_cabin_id);
        $totalPrice += $priceCabin;
    }
    echo $totalPrice;
    die();
}

function default_ajLoadCruiseItinerary()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
    global $_lang, $extLang, $_LANG_ID;
    #
    $clsCruise = new Cruise();
    $clsCruiseItinerary = new CruiseItinerary();

    $cruise_id = $_POST['cruise_id'];
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];

    $html = '';
    if ($clsCruiseItinerary->getOneField('highlight', $cruise_itinerary_id) != '') {
        $html .= '<h3 class="h3bold">' . $core->get_Lang('Trip highlight') . '</h3>';
        $html .= '<div class="formatTextStandard mbmm">
			' . html_entity_decode($clsCruiseItinerary->getOneField('highlight', $cruise_itinerary_id)) . '
		</div>';
    }
    #
    $clsCruiseItineraryDay = new CruiseItineraryDay();
    $lstDay = $clsCruiseItineraryDay->getAll("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' order by order_no ASC");
    if (is_array($lstDay) && count($lstDay) > 0) {
        $html .= '
		<div class="itinerary_Container">';
        for ($i = 0; $i < count($lstDay); $i++) {
            $html .= '
			<div class="elem-accordion-box">
            	<dt class="elem-accordion_Items">
					<span>' . $clsCruiseItineraryDay->getDay($lstDay[$i][$clsCruiseItineraryDay->pkey]) . ':</span> ' . $clsCruiseItineraryDay->getTitle($lstDay[$i][$clsCruiseItineraryDay->pkey]) . '
                     <a class="arrow_icr" href="javascript:void(0);" rel="nofollow"></a>
				</dt>
				<dd style="display:none">
					<div class="formatTextStandard">
						' . $clsCruiseItineraryDay->getContent($lstDay[$i][$clsCruiseItineraryDay->pkey]) . '
					</div>
				</dd>
			</div>';
        }
        $html .= '</div>';
    }
    echo $html;
    die();
}

// function default_ajChooseCabinCruise()
// {
//     global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
//     global $_lang, $extLang, $_LANG_ID, $now_day, $package_id;

//     $clsCruise = new Cruise();
//     $assign_list['clsCruise'] = $clsCruise;
//     $clsCruiseCabin = new CruiseCabin();
//     $assign_list['clsCruiseCabin'] = $clsCruiseCabin;
//     $clsCruiseItinerary = new CruiseItinerary();
//     $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;
//     $clsCruiseService = new CruiseService();
//     $assign_list['clsCruiseService'] = $clsCruiseService;

//     $cruise_id = (int)Input::post('cruise_id', 0);
//     $cruise_itinerary_id = (int)Input::post('cruise_itinerary_id', 0);
//     $departure_date = Input::post('departure_date', '');
//     $discount_value = (int)Input::post('discount_value', 0);
//     $discount_type = (int)Input::post('discount_type', 0);
//     $cruise_cabin_id = (int)Input::post('cruise_cabin_id', 0);
//     $is_extra_bed = (int)Input::post('is_extra_bed', 0);
//     $bed_type = Input::post('bed_type', '');
//     $type = Input::post('type', '');
//     $number_adult = (int)Input::post('number_adult', 0);
//     $number_child = (int)Input::post('number_child', 0);
//     $number_cabin = (int)Input::post('number_cabin', 0);
//     $check_contact_total = (int)Input::post('check_contact_total', 0);
//     $children = Input::post('children', '');
//     $arr_children = json_decode($children);
//     $str_total_price = Input::post('str_total_price', '');
//     $arr_total_price = json_decode($str_total_price);
//     $str_compare_price = Input::post('str_compare_price', '');
//     $arr_compare_price = json_decode($str_compare_price);
//     $totalprice = Input::post('totalprice', 0);
//     $totalprice = $totalprice * $number_cabin;
//     $max_adult = Input::post('max_adult', 0);
//     $assign_list['max_adult'] = $max_adult;
//     $departure_date = Input::post('departure_date', '');
//     $assign_list['departure_date'] = $departure_date;
//     $str_departure_date = ($departure_date != '') ? strtotime(str_replace("/", "-", $departure_date)) : '';

//     if ($type == 'BOOKSERVICES') {
//         $ContactCruise['BookingCruise'] = 'BookingCruise';
//         $ContactCruise['cruise_id'] = $cruise_id;
//         $ContactCruise['discount_value'] = $discount_value;
//         $ContactCruise['discount_type'] = $discount_type;
//         $ContactCruise['cruise_itinerary_id'] = $cruise_itinerary_id;
//         $ContactCruise['departure_date'] = $str_departure_date;
//         $ContactCruise['cruise_cabin_id'] = $cruise_cabin_id;
//         $ContactCruise['number_adult'] = $number_adult;
//         $ContactCruise['number_child'] = $number_child;
//         $ContactCruise['number_cabin'] = $number_cabin;
//         $ContactCruise['is_extra_bed'] = $is_extra_bed;
//         $ContactCruise['bed_type'] = $bed_type;
//         $ContactCruise['total_price'] = $arr_total_price->total_price;
//         $ContactCruise['total_price_promotion'] = $arr_total_price->total_price_promotion;
//         $ContactCruise['is_promotion'] = $arr_total_price->promotion;
//         $ContactCruise['compare_price'] = $arr_compare_price;
//         $ContactCruise['check_contact_total'] = $check_contact_total;
//         $ContactCruise['children'] = $arr_children;

//         vnSessionDelVar('ContactTour');
//         vnSessionDelVar('ContactCruise');
//         vnSessionDelVar('ContactHotel');
//         vnSessionSetVar('ContactCruise', $ContactCruise);
//         $link = $clsCruise->getLinkBookServices($cruise_id);
//         $html = $link;
//     } else {
//         $number_service = Input::post('number_service', '');
//         $total_number_service = Input::post('total_number_service', '');
//         $total_price_service = (int)Input::post('total_price_service', 0);
//         $ContactCruise = vnSessionGetVar('ContactCruise');

//         if (!empty($ContactCruise)) {
//             $arr_service = [];
//             foreach ($number_service as $k => $v) {
//                 $arr_service[$k] = [
//                     'price' => $clsCruiseService->getPriceValue($k),
//                     'cruise_service_id' => $k,
//                     'number' => $v,
//                 ];
//             }
//             $ContactCruise['cruise_service'] = $arr_service;
//             $ContactCruise['total_price_service'] = $total_price_service;
//             $ContactCruise['total_number_service'] = $total_number_service;
//             vnSessionSetVar('ContactCruise', $ContactCruise);
//             $link = $clsISO->getLink('contact');
//             // $link = $clsISO->getLink('cart');
//             $html = $link;
//         } else {
//             $html = "";
//         }
//     }

//     echo $html;
//     die();
// }

function default_ajChooseCabinCruise()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO, $package_id;
    global $_lang, $extLang, $_LANG_ID, $now_day;

    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list['clsCruiseCabin'] = $clsCruiseCabin;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;

    $cruise_id = Input::post('cruise_id', 0);
    $cruise_itinerary_id = Input::post('cruise_itinerary_id', 0);
    $cruise_cabin_id = Input::post('cruise_cabin_id', 0);
    $type = Input::post('type', '');
    $number_adult = Input::post('number_adult', 0);
    $number_child = Input::post('number_child', 0);
    $number_cabin = Input::post('number_cabin', 0);
    $assign_list['number_cabin'] = $number_cabin;
    /*$totalprice = Input::post('totalprice', 0);
    $totalprice = $totalprice * $number_cabin;*/
    $str_total_price = Input::post('str_total_price', '');
    $arr_total_price = json_decode($str_total_price);
    $cabin_total_price = !empty($arr_total_price->total_price) ? $arr_total_price->total_price : $arr_total_price;

    $max_adult = Input::post('max_adult', 0);
    $assign_list['max_adult'] = $max_adult;
    $departure_date = Input::post('departure_date', '');
    $departure_date = preg_replace('/^\D+,\s*/', '', $departure_date);
    // Chuyển đổi chuỗi ngày thành đối tượng DateTime
    //    $departure_date = DateTime::createFromFormat('l, d/m/Y', $departure_date);
    $departure_date = DateTime::createFromFormat('d/m/Y', $departure_date);

    $departure_date = $departure_date->format('d-m-Y');

    $assign_list['departure_date'] = $departure_date;
    $str_departure_date = ($departure_date != '') ? strtotime($departure_date) : '';

    $discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $str_departure_date, 'info_promotion');
    $promotion = $discount['discount_value'] ?? 0;
    $discount_type = $discount['discount_type'] ?? '';
    $SessionChooseCabin = vnSessionGetVar('SessionChooseCabin');

    if (empty($SessionChooseCabin)) {
        $SessionChooseCabin = array();
    }

    //Đặt cọc cruise
    $oneItem = $clsCruise->getOne($cruise_id, 'deposit');
    $deposit = !empty($oneItem['deposit']) ? $oneItem['deposit'] : 0;
    $deposit_price = $cabin_total_price * $deposit / 100;
    if ($type == 'D') {
        unset($SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]);
    } else {
        if (!empty($cruise_cabin_id)) {
            $SessionChooseCabin[$cruise_itinerary_id]['BookingCruise'] = 'BookingCruise';
            $SessionChooseCabin[$cruise_itinerary_id]['cruise_id'] = $cruise_id;
            $SessionChooseCabin[$cruise_itinerary_id]['promotion'] = $promotion;
            $SessionChooseCabin[$cruise_itinerary_id]['discount_type'] = $discount_type;
            $SessionChooseCabin[$cruise_itinerary_id]['deposit'] = $oneItem['deposit'];
            $SessionChooseCabin[$cruise_itinerary_id]['cruise_itinerary_id'] = $cruise_itinerary_id;
            $SessionChooseCabin[$cruise_itinerary_id]['departure_date'] = $str_departure_date;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['cruise_id'] = $cruise_id;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['cruise_itinerary_id'] = $cruise_itinerary_id;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['cruise_cabin_id'] = $cruise_cabin_id;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['number_adult'] = $number_adult;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['number_child'] = $number_child;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['number_cabin'] = $number_cabin;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['max_adult'] = $max_adult;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['totalprice'] = $cabin_total_price;
            $SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['deposit_price'] = $deposit_price;
        }
    }

    vnSessionSetVar('SessionChooseCabin', $SessionChooseCabin);

    $arrayCabin = vnSessionGetVar('SessionChooseCabin');

    $listCabin = $arrayCabin[$cruise_itinerary_id]['cabin'];
    $assign_list['listCabin'] = $listCabin;
    $assign_list['cruise_id'] = $cruise_id;
    $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;
    $assign_list['str_departure_date'] = $str_departure_date;
    $promotion = $arrayCabin[$cruise_itinerary_id]['promotion'];

    $assign_list['promotion'] = $promotion;

    $totalpricecabin = 0;
    foreach ($listCabin as $item) {
        $totalpricecabin += $item['totalprice'];
    }

    $totalprice_promotion = 0;
    if ($promotion > 0) {
        $totalprice_promotion = $promotion * $totalpricecabin / 100;
        $totalprice_new = $totalpricecabin - $totalprice_promotion;
    } else {
        $totalprice_new = $totalpricecabin;
    }
    $assign_list['totalprice_promotion'] = $totalprice_promotion;
    $assign_list['totalprice_new'] = $totalprice_new;


    if ($type != 'BOOKNOW') {
        if ($clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_cruise', 'default')) {
            $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
            if (empty($cartSessionCruise)) {
                $cartSessionCruise = array();
            }
            $SessionChooseCabin = vnSessionGetVar('SessionChooseCabin');

            $cartSessionCruise[$_LANG_ID][$cruise_itinerary_id] = $SessionChooseCabin[$cruise_itinerary_id];

            vnSessionSetVar('BookingCruise_' . $_LANG_ID, $cartSessionCruise);

            $link = $clsISO->getLink('cart');
        } else {
            vnSessionDelVar('ContactTour');
            vnSessionDelVar('ContactCruise');
            vnSessionDelVar('ContactHotel');

            $SessionChooseCabin = vnSessionGetVar('SessionChooseCabin');
            vnSessionSetVar('ContactCruise', $SessionChooseCabin[$cruise_itinerary_id]);
            $link = $clsISO->getLink('contact');
        }

        $html = $link;
    } else {
        $html = $core->build('loadCabinChooseBook.tpl');
    }

    echo $html;
    die();
}

function default_ajLoadCabinCruise()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
    global $_lang, $extLang, $_LANG_ID, $now_day;

    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list['clsCruiseCabin'] = $clsCruiseCabin;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;


    $cruise_id = Input::post('cruise_id', 0);
    $assign_list['cruise_id'] = $cruise_id;
    $cruise_itinerary_id = Input::post('cruise_itinerary_id', 0);
    $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;
    $cruise_cabin_id = Input::post('cruise_cabin_id', 0);
    $assign_list['cruise_cabin_id'] = $cruise_cabin_id;
    $type = Input::post('type', '');
    $number_adult = Input::post('number_adult', 0);
    $assign_list['number_adult'] = $number_adult;
    $number_child = Input::post('number_child', 0);
    $assign_list['number_child'] = $number_child;
    $number_cabin = Input::post('number_cabin', 0);
    $assign_list['number_cabin'] = $number_cabin;
    $totalprice = Input::post('totalprice', 0);
    $assign_list['price_cabin'] = $totalprice;
    $totalprice = $totalprice * $number_cabin;

    $choose_index = Input::post('choose_index', '');
    $assign_list['choose_index'] = $choose_index;

    $max_adult = Input::post('max_adult', 0);
    $assign_list['max_adult'] = $max_adult;
    $promotion_price = Input::post('promotion_price', 0);
    $assign_list['promotion_price'] = $promotion_price;
    $departure_date = Input::post('departure_date', '');
    $assign_list['departure_date'] = $departure_date;
    $str_departure_date = ($departure_date != '') ? strtotime($departure_date) : '';

    $oneCruise = $clsCruise->getOne($cruise_id, 'total_cabin');
    $assign_list['max_cabin'] = $oneCruise['total_cabin'];

    $discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $str_departure_date, 'info_promotion');
    $promotion = $discount['discount_value'];


    $assign_list['str_departure_date'] = $str_departure_date;
    $promotion = $arrayCabin[$cruise_itinerary_id]['promotion'];

    $assign_list['promotion'] = $promotion;

    $totalpricecabin = 0;
    foreach ($listCabin as $item) {
        $totalpricecabin += $item['totalprice'];
    }

    if ($promotion > 0) {
        $totalprice_promotion = $promotion;
        $totalprice_new = $totalpricecabin - $totalprice_promotion;
    } else {
        $totalprice_new = $totalpricecabin;
    }
    $assign_list['totalprice_promotion'] = $totalprice_promotion;
    $assign_list['totalprice_new'] = $totalprice_new;

    $html = $clsISO->build('loadCabin.tpl');
    $data = [
        'html_cabin' => $html,
        'promotion_price' => $promotion_price,
    ];
    echo json_encode($data);
    die();
}

function default_ajViewDetailCruiseCabin()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
    global $_lang, $extLang, $_LANG_ID;
    #
    $clsCruise = new Cruise();
    $clsCruiseItinerary = new CruiseItinerary();

    $cruise_id = $_POST['cruise_id'];
    $cruise_itinerary_id = $_POST['cruise_itinerary_id'];

    $html = '';

    $html = '<div class="modal-dialog modal-lg" role="document">    	
        <div class="modal-content" id="container-room-detail"><div class="modal-header">
	<button type="button" class="close c6" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
	<h4 class="modal-title text-uppercase c2a z_18" id="roomModalLabel">Paradise Luxury Cruise</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-6">
			<div class="modal-owl">
				<div id="sync-modal-lg" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
																									<div class="owl-wrapper-outer"><div class="owl-wrapper" style="width: 2454px; left: 0px; display: block;"><div class="owl-item" style="width: 409px;"><div class="item"><img src="https://d1qzw4aof2monx.cloudfront.net/upload/room/admin/2016/06/Paradise luxury deluxe double.jpg" alt=""></div></div><div class="owl-item" style="width: 409px;"><div class="item"><img src="https://d1qzw4aof2monx.cloudfront.net/upload/room/admin/2016/06/Paradise luxury deluxe twin.jpg" alt=""></div></div><div class="owl-item" style="width: 409px;"><div class="item"><img src="https://d1qzw4aof2monx.cloudfront.net/upload/room/admin/2016/06/Luxury_Bathroom.jpg" alt=""></div></div></div></div>
										
										
																	
				<div class="owl-controls clickable"><div class="owl-buttons"><div class="owl-prev"><i class="fa fa-chevron-left"></i></div><div class="owl-next"><i class="fa fa-chevron-right"></i></div></div></div></div>
				<div class="sync-modal-xs-wrap">
					<div id="sync-modal-xs" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
																								<div class="owl-wrapper-outer"><div class="owl-wrapper" style="width: 420px; left: 0px; display: block;"><div class="owl-item synced" style="width: 70px;"><div class="item"><img src="https://d1qzw4aof2monx.cloudfront.net/upload/room/admin/2016/06/Paradise luxury deluxe double.jpg" alt=""></div></div><div class="owl-item" style="width: 70px;"><div class="item"><img src="https://d1qzw4aof2monx.cloudfront.net/upload/room/admin/2016/06/Paradise luxury deluxe twin.jpg" alt=""></div></div><div class="owl-item" style="width: 70px;"><div class="item"><img src="https://d1qzw4aof2monx.cloudfront.net/upload/room/admin/2016/06/Luxury_Bathroom.jpg" alt=""></div></div></div></div>
												
												
																							</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="m-item">
				<h5><span>DESCRIPTION</span></h5>
								<div class="m-content">
                	<p>
	Deluxe cabins are located on the first deck with Big window and Sea view.</p>
                    <p>
                		<strong>Cabin size:</strong> 16.0 m2 <br>
                        <strong>Bed size:</strong> Double Bed or 2 Twin Beds <br>
                        <strong>Max People:</strong>  2 Adults,1 Children,1 Infant                    </p>
                </div>
			</div>
			<div class="m-item">
								<h5><span>AMENITIES</span></h5>
				<div class="m-content">
					<ul class="list-col-2">
																		<li>
		Queen size bed/ 2 twin beds</li>
												<li>
		Hot water</li>
												<li>
		Hair-dryer</li>
												<li>
		Individual controller air-conditioning</li>
												<li>
		Shower</li>
												<li>
		Toilet</li>
												<li>
		In-house Telephone</li>
												<li>
		Complimentary Drinking Water</li>
												<li>
		Slippers</li>
												<li>
		Wardrobe</li>
												<li>
		Safety Equipment and Life Vests</li>
												<li>
		Safety box</li>
												<li>
		Bathrobe</li>
												<li>
		En-suite Bathroom</li>
												<li>
		Beauty mirror</li>
																	</ul>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
    </div>';
    echo $html;
    die();
}

function default_ajUpdateNumViewCruise()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $city_id, $extLang, $clsISO;
    #
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    #
    $cruise_id = $_POST['cruise_id'];
    $assign_list['cruise_id'] = $cruise_id;
    $oneItem = $clsCruise->getOne($cruise_id);

    $view_num = $oneItem['view_num'];
    $view_num = $view_num + 1;
    $assign_list["view_num"] = $view_num;

    $clsCruise->updateOne($cruise_id, "view_num=$view_num");
    echo (1);
    die();
}

function default_load_more_cruise_halong()
{
    global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseStore = new CruiseStore();
    $assign_list["clsCruiseStore"] = $clsCruiseStore;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    #
    $currentPage = intval($_POST['page']);
    $assign_list["currentPage"] = $currentPage;
    #
    $_type = $_POST['_type'];
    $cruise_cat_id = $_POST['cruise_cat_id'];
    $recordPerPage = 6;
    if ($cruise_cat_id > 0) {
        if ($_type == 'RECOMMED') {
            $cond = "cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 and (cruise_cat_id='$cat_id' or list_cat_id like '%|" . $cruise_cat_id . "|%')) and _type='RECOMMED'";
        } else {
            $cond = "is_trash=0 and is_online=1 and (cruise_cat_id='" . $cruise_cat_id . "' or list_cat_id like '%|" . $cruise_cat_id . "|%') and cruise_id NOT IN (SELECT cruise_id From default_cruise_store where ( _type='BEST' or _type='RECOMMED'))";
        }
    } else {
        $cond = "cruise_id in (SELECT default_cruise.cruise_id FROM default_cruise WHERE is_trash = 0 and is_online = 1 ) and _type='RECOMMED'";
    }

    $order_by = "order by order_no asc";
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    if ($_type == 'RECOMMED') {
        $lstCruiseTopPromotion = $clsCruiseStore->getAll($cond . $order_by . $limit, 'cruise_id');
    } else {
        $lstCruiseTopPromotion = $clsCruise->getAll($cond . $order_by . $limit, $clsCruise->pkey);
    }
    $assign_list['lstCruiseTopPromotion'] = $lstCruiseTopPromotion;
    unset($lstCruiseTopPromotion);
    $assign_list['recordPerPage'] = $recordPerPage;
    #
    $html = $core->build('load_more_cruise_promo.tpl');
    echo $html;
    die();
}

function default_load_more_cruise_reviews()
{
    global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;
    #
    $currentPage = intval($_POST['page']);
    $assign_list["currentPage"] = $currentPage;
    $_type = $_POST['_type'];
    $table_id = $_POST['table_id'];
    #
    $recordPerPage = 3;
    $order_by = "order by order_no asc";
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    $cond = "is_trash=0 and is_online=1 and type='$_type' and table_id = '$table_id'";
    #
    $lstReview = $clsReviews->getAll($cond . $order_by . $limit);
    //echo $cond.$order_by.$limit; print_r($lstReview);die('xxx');
    $assign_list['lstReview'] = $lstReview;
    unset($lstReview);
    $assign_list['recordPerPage'] = $recordPerPage;
    #
    $html = $core->build('load_more_cruise_reviews.tpl');
    echo $html;
    die();
}

function default_loadPriceCabin()
{
    //	ini_set('display_errors', '1');
    //	ini_set('display_startup_errors', '1');
    //	error_reporting(E_ALL);
    global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,
        $title_page, $description_page, $keyword_page, $clsISO, $clsConfiguration, $departure_date, $now_day;
    #
    $clsCountry = new Country();
    $clsCity = new City();
    $clsTour = new Tour();
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruise = new Cruise();
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruiseSeasonPrice = new CruiseSeasonPrice();
    $assign_list["clsCruiseSeasonPrice"] = $clsCruiseSeasonPrice;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list["clsCruiseProperty"] = $clsCruiseProperty;
    $clsCruisePriceChild = new CruisePriceChild();
    $assign_list["clsCruisePriceChild "] = $clsCruisePriceChild;
    vnSessionDelVar('SessionChooseCabin');

    $arraycheckrateCabin = $_POST;
    $assign_list['arraycheckrateCabin'] = $arraycheckrateCabin;

    $cruise_id = (int)Input::post("cruise_id", 0);
    $assign_list['cruise_id'] = $cruise_id;

    $number_adult = (int)Input::post("number_adult", 0);
    $assign_list['number_adult'] = $number_adult;

    $number_child = (int)Input::post("number_child", 0);
    $assign_list['number_child'] = $number_child;
    $is_extra_bed = (int)Input::post("is_extra_bed", 0);
    $assign_list['is_extra_bed'] = $is_extra_bed;

    $cruise_itinerary_id = (int)Input::post("cruise_itinerary_id", 0);
    $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;

    $duration_type = $clsCruiseItinerary->getOneField("duration_type", $cruise_itinerary_id);
    $assign_list["duration_type"] = $duration_type;

    $number_cabin = (int)Input::post("number_cabin", 1);
    $assign_list['number_cabin'] = $number_cabin;
    $str_number_adult = Input::post("str_number_adult", "");
    $arr_number_adult = json_decode($str_number_adult);
    $str_number_child = Input::post("str_number_child", "");
    $arr_number_child = json_decode($str_number_child);
    $str_bed_type = Input::post("str_bed_type", "");
    $arr_bed_type = json_decode($str_bed_type);
    $str_children = Input::post("str_children", "");
    $assign_list['str_children'] = $str_children;
    $arr_children = json_decode($str_children);

    $str_is_extra_bed = Input::post("str_is_extra_bed", "");
    $arr_is_extra_bed = json_decode($str_is_extra_bed);

    $departure_date = Input::post("departure_date", "");
    $assign_list['departure_date'] = $departure_date;
    $departure_date = str_replace('/', '-', $departure_date);
    $departure_date_month = date('m', strtotime($departure_date));
    if (empty(strtotime($departure_date))) {
        preg_match('/\d{2}-(\d{2})-\d{4}/', $departure_date, $matches);
        $departure_date_month = $matches[1];
    }
    $assign_list['departure_date_month'] = $departure_date_month;
    $promotion_date = strtotime($departure_date);
    $assign_list['promotion_date'] = $promotion_date;
    $discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $promotion_date, 'info_promotion');
    $promotion = $discount['discount_value'] ?? 0;
    $assign_list['promotion'] = $promotion;

    $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $departure_date_month . "%' limit 0,1");
    if (!empty($lstSeason)) {
        $season = 'high';
    } else {
        $season = 'low';
    }
    $assign_list['season'] = $season;

    #-- Cruise Rooms
    $cond_bed_type = "";
    if (count($arr_bed_type) > 0) {
        $cond_bed_type .= " AND (";
        for ($i = 0; $i < count($arr_bed_type); $i++) {
            $cond_bed_type .= (($i > 0) ? " OR " : "") . "list_group_size LIKE '%|" . $arr_bed_type[$i] . "|%'";
        }
        $cond_bed_type .= ")";
    }
    $order_by = " ORDER BY order_no ASC";
    $cruise = $clsCruise->getOne($cruise_id);
    $assign_list['cruise'] = $cruise;
    $limit = '';
    if ($cruise['cruise_type'] == 0) {
        $limit = "LIMIT 0,1";
    }
    if ($cruise['cruise_type'] == 2 || ($cruise['cruise_type'] == 1 && $duration_type == 1)) $cond_bed_type = "";
    $lstCruiseCabinID = $clsCruiseCabin->getAll(
        "is_trash=0 and is_online=1 and cruise_id='$cruise_id' $cond_bed_type $order_by $limit",
        "{$clsCruiseCabin->pkey},list_group_size,extra_bed,floor, number_cabin"
    );

    if ($cruise['cruise_type'] == 2 || ($cruise['cruise_type'] == 1 && $duration_type == 1)) {
        echo getListCabinOvernight($lstCruiseCabinID, $cruise);
        die;
    }
    if ($lstCruiseCabinID != '') {
        $arr_list_cabin_check = [];
        $arr_total_price_cabin = [];
        foreach ($lstCruiseCabinID as $k => $v) {
            $total_price = 0;
            $check_contact_total = 0;
            $lstCruiseCabinID[$k]['compare_price'] = $clsCruiseCabin->getLCheckRatePriceCabin(
                $v[$clsCruiseCabin->pkey],
                $arraycheckrateCabin,
                'value',
                $departure_date,
                $cruise_id
            );

            for ($i = 0; $i < $number_cabin; $i++) {
                $oneItinerary = $clsCruiseItinerary->getOne($cruise_itinerary_id, "price_by_high,price_by_low");
                if ($season == 'high') {
                    $price_by = $oneItinerary['price_by_high'];
                } else {
                    $price_by = $oneItinerary['price_by_low'];
                }
                $assign_list["price_by"] = $price_by;
                $numberAdult = $arr_number_adult[$i];
                $price_adult = $clsCruiseSeasonPrice->getPriceFor1Adult($cruise_itinerary_id, $v['cruise_cabin_id'], $arr_bed_type[$i], $season, $numberAdult);

                $total_price += ($price_adult > 0) ? $price_adult * $numberAdult : 0;

                $arr_group_child_cabin = explode(",", $arr_children[$i]);
                $arr_group_child = [];
                for ($j = 0; $j < count($arr_group_child_cabin); $j++) {
                    $oneGroupChild = $clsCruisePriceChild->getAll("cruise_id='" . $cruise_id . "' AND " . $arr_group_child_cabin[$j] . " BETWEEN min AND max LIMIT 0,1", $clsCruisePriceChild->pkey . ',price,price_type');
                    $cruisePriceChildID = $oneGroupChild[0][$clsCruisePriceChild->pkey];
                    if ($oneGroupChild[0]['price_type'] == 0) { //0: tiền cụ thể; 1: theo % giá người lớn
                        $price_child = $oneGroupChild[0]['price'];
                        if ($_LANG_ID == 'vn') {
                            $txt_price_child = $clsISO->formatPriceText($price_child);
                            $txt_price_child .= " " . $clsISO->getRate();
                        } else {
                            $txt_price_child = $clsISO->formatPrice($price_child, 2);
                            $txt_price_child = $clsISO->getRate() . " " . $txt_price_child;
                        }
                    } else {
                        if ($price_adult > 0) {
                            $price_child = ($oneGroupChild[0]['price']) * $price_adult / 100;
                            if ($_LANG_ID == 'vn') {
                                $txt_price_child = $clsISO->formatPriceText($price_child);
                                $txt_price_child .= " " . $clsISO->getRate();
                            } else {
                                $txt_price_child = $clsISO->formatPrice($price_child, 2);
                                $txt_price_child = $clsISO->getRate() . " " . $txt_price_child;
                            }
                        } else {
                            $price_child = 0;
                            $txt_price_child = $core->get_Lang('contact');
                            $check_contact_total = 1;
                        }
                    }

                    if (isset($arr_group_child[$cruisePriceChildID])) {
                        $arr_group_child[$cruisePriceChildID]['number_child'] = $arr_group_child[$cruisePriceChildID]['number_child'] + 1;
                        $arr_group_child[$cruisePriceChildID]['str_age'] = ($arr_group_child[$cruisePriceChildID]['str_age']) . $core->get_Lang("year old") . " - " . $arr_group_child_cabin[$j] . $core->get_Lang("year old");
                    } else {
                        $arr_group_child[$cruisePriceChildID] = [
                            'price_child' => $price_child,
                            'txt_price_child' => $txt_price_child,
                            'number_child' => 1,
                            'str_age' => $arr_group_child_cabin[$j]
                        ];
                    }
                    $total_price += $price_child;
                    unset($oneGroupChild, $cruisePriceChildID, $txt_price_child);
                }

                $is_extra_bed = $arr_is_extra_bed[$i];
                $price_extra_bed = 0;
                if ($is_extra_bed == 1) {
                    $price_extra_bed = $clsCruiseSeasonPrice->getPriceExtraBed($cruise_itinerary_id, $v['cruise_cabin_id'], $arr_bed_type[$i], $season);

                    $total_price += $price_extra_bed;
                    if ($price_extra_bed > 0) {
                        if ($_LANG_ID == 'vn') {
                            $txt_price_extra_bed = $clsISO->formatPriceText($price_extra_bed);
                            $txt_price_extra_bed .= " " . $clsISO->getRate();
                        } else {
                            $txt_price_extra_bed = $clsISO->formatPrice($price_extra_bed, 2);
                            $txt_price_extra_bed = $clsISO->getRate() . " " . $txt_price_extra_bed;
                        }
                    } else {
                        $txt_price_extra_bed = $core->get_Lang('contact');
                        $check_contact_total = 1;
                    }
                }

                if ($price_adult > 0) {
                    if ($_LANG_ID == 'vn') {
                        $txt_price_adult = $clsISO->formatPriceText($price_adult);
                        $txt_price_adult .= " " . $clsISO->getRate();
                    } else {
                        $txt_price_adult = $clsISO->formatPrice($price_adult, 2);
                        $txt_price_adult = $clsISO->getRate() . " " . $txt_price_adult;
                    }
                } else {
                    $txt_price_adult = $core->get_Lang('contact');
                    $check_contact_total = 1;
                }


                $arr_list_cabin_check[$k][] = [
                    "bed_type_id" => $arr_bed_type[$i],
                    "bed_type" => $clsCruiseProperty->getTitle($arr_bed_type[$i]),
                    "number_adult" => $arr_number_adult[$i],
                    "price_adult" => $price_adult,
                    "txt_price_adult" => $txt_price_adult,
                    "is_extra_bed" => $is_extra_bed,
                    "txt_price_extra_bed" => $txt_price_extra_bed,
                    "number_child" => $arr_number_child[$i],
                    "lst_child" => $arr_group_child,
                ];

                unset($oneItinerary, $price_by, $numberAdult, $txt_price_adult, $price_adult);
            }
            $lstCruiseCabinID[$k]['check_contact_total'] = $check_contact_total;
            $lstCruiseCabinID[$k]['compare_price'] = $arr_list_cabin_check[$k];
            $lstCruiseCabinID[$k]['bed_type'] = $arr_list_cabin_check[$k][0]['bed_type'];


            if (!empty($discount)) {
                $assign_list['discount_type'] = $discount['discount_type'];
                $assign_list['discount_value'] = $discount['discount_value'];
                if ($discount['discount_type'] == 2) {
                    $total_price_promotion = $total_price * (1 - ((int)$discount['discount_value'] / 100));
                } else {
                    $total_price_promotion = $total_price - (int)$discount['discount_value'];
                }
                $promotion = 1;
            } else {
                $total_price_promotion = $total_price;
                $promotion = 0;
            }

            $lstCruiseCabinID[$k]['total_price'] = [
                "total_price" => $total_price,
                "total_price_promotion" => $total_price_promotion,
                "promotion" => $promotion
            ];
            $lstCruiseCabinID[$k]['str_total_price'] = json_encode($lstCruiseCabinID[$k]['total_price']);
            $lstCruiseCabinID[$k]['str_compare_price'] = json_encode($lstCruiseCabinID[$k]['compare_price']);
        }
    }

    $numberlstCruiseCabinID = $lstCruiseCabinID ? count($lstCruiseCabinID) : 0;
    // Soft price min to max
    usort($lstCruiseCabinID, function ($a, $b) {
        return $a['total_price']['total_price_promotion'] <=> $b['total_price']['total_price_promotion'];
    });
    $assign_list['lstCruiseCabinID'] = $lstCruiseCabinID;

    $assign_list['numberlstCruiseCabinID'] = $numberlstCruiseCabinID;
    $lstCruiseCabin = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' and cruise_cabin_id NOT IN (select cruise_cabin_id FROM default_cruise_season_price WHERE cruise_id='$cruise_id' GROUP BY cruise_cabin_id) order by order_no ASC");
    $assign_list['lstCruiseCabin'] = $lstCruiseCabin;
    $clsCabinImage = new CabinImage();
    $assign_list['clsCabinImage'] = $clsCabinImage;
    $html = $core->build('loadCabinPriceCheckrate.tpl');
    die();
}

function getListCabinOvernight($cabins, $cruise)
{
    global $assign_list, $core, $_LANG_ID, $clsISO;

    $clsCruiseProperty = new CruiseProperty();
    $clsConfiguration = new Configuration();
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCabinImage'] = new CabinImage();
    $config_price_overnight = !empty($cruise['config_price_overnight'])
        ? json_decode($cruise['config_price_overnight'], true) : [];

    $cruise_itinerary_id = (int)Input::post('cruise_itinerary_id', 0);

    $number_adult = (int)Input::post('number_adult', 0);
    $assign_list['number_adult'] = $number_adult;

    $number_child = (int)Input::post('number_child', 0);
    $assign_list['number_child'] = $number_child;
    $is_extra_bed = (int)Input::post('is_extra_bed', 0);
    $assign_list['is_extra_bed'] = $is_extra_bed;

    $cruise_itinerary_id = (int)Input::post('cruise_itinerary_id', 0);
    $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;

    $number_cabin = (int)Input::post('number_cabin', 1);
    $str_number_adult = Input::post('str_number_adult', '');
    $arr_number_adult = json_decode($str_number_adult);

    $str_number_child = Input::post('str_number_child', '');
    $arr_number_child = json_decode($str_number_child);

    $str_bed_type = Input::post('str_bed_type', '');
    $arr_bed_type = json_decode($str_bed_type);

    $str_children = Input::post('str_children', '');

    $arr_children = json_decode($str_children);
    $tmp_child = $arr_children;
    $arr_children = [];
    if (!empty($tmp_child)) {
        foreach ($tmp_child as $childAge) {
            $arr_children = array_merge($arr_children, explode(',', $childAge));
        }
    }

    $assign_list['str_children'] = $str_children;
    $assign_list['number_cabin'] = $number_cabin;

    $departure_date = Input::post("departure_date", "");
    $departure_date = str_replace('/', '-', $departure_date);
    $departure_date_month = date('m', strtotime($departure_date));
    if (empty(strtotime($departure_date))) {
        preg_match('/\d{2}-(\d{2})-\d{4}/', $departure_date, $matches);
        $departure_date_month = $matches[1];
    }

    $lstSeason = $clsConfiguration->getAll(
        "setting='high_season_month' and value like '%$departure_date_month%' limit 0,1"
    );
    if (!empty($lstSeason)) {
        $season = 'high';
    } else {
        $season = 'low';
    }

    $cruise_itinerary = $clsCruiseItinerary->getOne($cruise_itinerary_id);
    if ($season == 'high') {
        $price_by = $cruise_itinerary['price_by_high'];
    } else {
        $price_by = $cruise_itinerary['price_by_low'];
    }

    if (!empty($config_price_overnight['prices'][$cruise_itinerary_id])) {
        $listGroupSize = array_keys($config_price_overnight['prices'][$cruise_itinerary_id]);
        if (($key = array_search('price_by', $listGroupSize)) !== false) {
            unset($listGroupSize[$key]);
        }
        $listGroupSize = join(',', $listGroupSize);

        $lstcruiseProperty = $clsCruiseProperty->getAll("
			type = 'GroupSize'
			and is_trash = 0
			and {$clsCruiseProperty->pkey} in ($listGroupSize)
			and number_adult >= $number_adult
			order by order_no asc
		");

        $bed_type = 0;
        if (!empty($lstcruiseProperty)) {
            $bed_type = $lstcruiseProperty[0][$clsCruiseProperty->pkey];
        }
        if (!empty($config_price_overnight['prices'][$cruise_itinerary_id][$bed_type])) {
            if ($price_by == 0) {
                $person = $config_price_overnight['prices'][$cruise_itinerary_id][$bed_type][$season]['person'];
                if (!empty($person[$number_adult])) {
                    $price_adult = $person[$number_adult];
                }
            } else {
                $price_adult = $config_price_overnight['prices'][$cruise_itinerary_id][$bed_type][$season]['carbin'];
            }
        }
    }

    $assign_list['cabins'] = $cabins;

    $list_child = [];
    if ($price_adult > 0) {
        if (!empty($arr_children)) {
            $clsCruisePriceChild = new CruisePriceChild();
            foreach ($arr_children as $childAge) {
                if (!empty($list_child[$childAge])) {
                    $list_child[$childAge]['quantity'] += 1;
                } else {
                    $cruisePriceChild = $clsCruisePriceChild->getByCond("
						is_trash = 0 and cruise_id = {$cruise['cruise_id']} and $childAge between min and max
					");
                    if ((int)$cruisePriceChild['price_type'] === 0) {
                        $list_child[$childAge] = [
                            'price' => $cruisePriceChild['price'],
                            'quantity' => 1
                        ];
                        if (empty($cruisePriceChild['price'])) {
                            // Nếu không set riêng cho cruise thì giá lấy trong child policy (setting cruise)
                            if (
                                $clsConfiguration->getValue("InfantMinAgePolicy") <= $childAge &&
                                $childAge <= $clsConfiguration->getValue("InfantMaxAgePolicy")
                            ) {
                                $cruisePriceChild['price'] = $clsConfiguration->getValue("InfantFaresPolicy");
                            } else if (
                                $clsConfiguration->getValue("ChildMinAgePolicy") <= $childAge &&
                                $childAge <= $clsConfiguration->getValue("ChildMaxAgePolicy")
                            ) {
                                $cruisePriceChild['price'] = $clsConfiguration->getValue("ChildFaresPolicy");
                            } else {
                                $cruisePriceChild['price'] = 100;
                            }
                            $list_child[$childAge] = [
                                'price' => $price_adult * $cruisePriceChild['price'] / 100,
                                'quantity' => 1
                            ];
                        }
                    } else {
                        if (empty($cruisePriceChild['price'])) {
                            // Nếu không set riêng cho cruise thì giá lấy trong child policy (setting cruise)
                            if (
                                $clsConfiguration->getValue("InfantMinAgePolicy") <= $childAge &&
                                $childAge <= $clsConfiguration->getValue("InfantMaxAgePolicy")
                            ) {
                                $cruisePriceChild['price'] = $clsConfiguration->getValue("InfantFaresPolicy");
                            } else if (
                                $clsConfiguration->getValue("ChildMinAgePolicy") <= $childAge &&
                                $childAge <= $clsConfiguration->getValue("ChildMaxAgePolicy")
                            ) {
                                $cruisePriceChild['price'] = $clsConfiguration->getValue("ChildFaresPolicy");
                            } else {
                                $cruisePriceChild['price'] = 100;
                            }
                        }
                        $list_child[$childAge] = [
                            'price' => $price_adult * $cruisePriceChild['price'] / 100,
                            'quantity' => 1
                        ];
                    }
                }
            }
        }
        if ($_LANG_ID == 'vn') {
            $txt_price_adult = $clsISO->formatPriceText($price_adult);
            $txt_price_adult .= " {$clsISO->getRate()}";
        } else {
            $txt_price_adult = $clsISO->formatPrice($price_adult, 2);
            $txt_price_adult = "{$clsISO->getRate()} $txt_price_adult";
        }
        $check_contact_total = 0;
    } else {
        $txt_price_adult = $core->get_Lang('contact');
        $check_contact_total = 1;
    }
    $total_price = $number_adult * $price_adult;

    if (!empty($list_child)) {
        foreach ($list_child as $age => $child) {
            $total_price += $child['quantity'] * $child['price'];

            if ($_LANG_ID == 'vn') {
                //                $txt_price_child = $clsISO->formatPriceText($child['quantity'] * $child['price']);
                $txt_price_child = $clsISO->formatPriceText($child['price']);
                $txt_price_child .= " {$clsISO->getRate()}";
            } else {
                //                $txt_price_child = $clsISO->formatPrice($child['quantity'] * $child['price'], 2);
                $txt_price_child = $clsISO->formatPrice($child['price'], 2);
                $txt_price_child = "{$clsISO->getRate()} $txt_price_child";
            }

            $list_child[$age]['txt_price_child'] = $txt_price_child;
        }
    }

    if ($price_by == 1) {
        $total_price = $config_price_overnight['prices'][$cruise_itinerary_id][$bed_type][$season]['carbin'];
    }

    $assign_list['list_child'] = $list_child;
    $assign_list['number_adult'] = $number_adult;
    $assign_list['price_adult'] = $price_adult;
    $assign_list['total_price'] = $total_price;
    $assign_list['txt_price_adult'] = $txt_price_adult;
    $assign_list['check_contact_total'] = $check_contact_total;
    $assign_list['price_by'] = $price_by;
    // return 1;
    return $core->build('loadCabinPriceCheckrate.tpl');
}

function compare_price_asc($compare_price1, $compare_price2)
{
    if ($compare_price1["compare_price"] < $compare_price2["compare_price"]) {
        return -1;
    } else if ($compare_price1["compare_price"] == $compare_price2["compare_price"]) {
        return 0;
    } else {
        return 1;
    }
}

function default_map()
{
    global $dbconn, $_LANG_ID, $core, $smarty, $assign_list;
    $clsCruise = new Cruise();
    $clsCruiseItinerary = new CruiseItinerary();

    $table_map_id = intval($_POST['table_map_id']);
    $smarty->assign('table_map_id', $table_map_id);


    $type_show_map = intval($_POST['type_show_map']);
    $ret = $clsCruiseItinerary->getLocationMap($table_map_id);
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

function default_ajaxLoadCabinCheck()
{
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);
    global $core, $assign_list, $clsISO, $_LANG_ID;
    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list['clsCruiseCabin'] = $clsCruiseCabin;
    $clsCruiseProperty = new CruiseProperty();
    $assign_list['clsCruiseProperty'] = $clsCruiseProperty;
    $clsCruisePriceChild = new CruisePriceChild();
    $assign_list['clsCruisePriceChild'] = $clsCruisePriceChild;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;

    $cruise_id = (int)Input::post('cruise_id', 0);
    $assign_list['cruise_id'] = $cruise_id;

    $cruise_itinerary_id = (int)Input::post('cruise_itinerary_id', 0);
    $assign_list['cruise_itinerary_id'] = $cruise_itinerary_id;

    $duration_type = $clsCruiseItinerary->getOneField("duration_type", $cruise_itinerary_id);
    $assign_list["duration_type"] = $duration_type;


    $oneItem = $clsCruise->getOne($cruise_id,'cruise_type, config_price_overnight');
    $cruise_type = $oneItem['cruise_type'] ?? '';
    $config = json_decode($oneItem['config_price_overnight'] ?? '', true);
    /**
     * Nếu JSON không hợp lệ hoặc null
     */
    if (!is_array($config)) {
        $config = [];
    }

    $groups = $config['groups'] ?? [];

    /**
     * Chuẩn hóa groups
     */
    if (empty($groups)) {
        $groups = [];
    } elseif (!is_array($groups)) {
        $groups = [$groups];
    }

    $listCapacity = array_values($groups);

    /**
     * Chuỗi dạng |383|402|
     */
    $oneItem['list_capacity'] = !empty($listCapacity)
        ? '|' . implode('|', $listCapacity) . '|'
        : '';

    $oneItem['config_price_overnight'] = $config;


    // $oneItem = $clsCruise->getOne($cruise_id, 'cruise_type, config_price_overnight');
    // $cruise_type = $oneItem['cruise_type'];
    // $oneItem['config_price_overnight'] = !empty($oneItem['config_price_overnight'])
    //     ? json_decode($oneItem['config_price_overnight'], true) : [];
    // $oneItem['list_capacity'] = '|' . join('|', $oneItem['config_price_overnight']['groups']) . '|';

    $listCapcity = explode("|", trim($oneItem['list_capacity'], '|'));

    $assign_list['cruise_type'] = $cruise_type;

    $index_cabin = (int)Input::post('index_cabin', 1);
    $assign_list['index_cabin'] = $index_cabin;

    $lstCabinCruise = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id='" . $cruise_id . "'", $clsCruiseCabin->pkey . ',list_group_size,title');

    $number_cabin = (!empty($lstCabinCruise)) ? count($lstCabinCruise) : 0;
    $assign_list['number_cabin'] = $number_cabin;

    $arrGroupSize = [];
    foreach ($lstCabinCruise as $key => $value) {
        $lstSizeGroup = str_replace('||', '|', $value['list_group_size']);
        $lstSizeGroup = trim($lstSizeGroup, '|');
        $arrSizeGroup = explode("|", $lstSizeGroup);
        $arrGroupSize = array_merge($arrGroupSize, $arrSizeGroup);
    }
    $arrGroupSize = array_unique($arrGroupSize);
    if (empty($arrSizeGroup[0])) $arrGroupSize = $listCapcity;

    $lstGroupSize = $clsCruiseProperty->getAll("cruise_property_id IN (" . implode(",", $arrGroupSize) . ") AND type='GroupSize'", $clsCruiseProperty->pkey . ',title,number_adult,number_child,is_extra_bed');

    if ($duration_type == 1 || $cruise_type == 2) {
        /*$lstGroupSize[0] = [
            "number_adult" => INF,
            "number_child" => INF
        ];*/
        $lstGroupSize[0]['number_child'] = INF;
    }

    $assign_list['lstGroupSize'] = $lstGroupSize;

    $CheckCruisePriceChild = $clsCruisePriceChild->getAll("cruise_id='" . $cruise_id . "'", $clsCruisePriceChild->pkey);
    $assign_list['CheckCruisePriceChild'] = $CheckCruisePriceChild;
    if (!empty($CheckCruisePriceChild)) {
        $lstCruisePriceChild = $clsCruisePriceChild->getAll("cruise_id='" . $cruise_id . "'", "MAX(max) as max_age, MIN(min) as min_age");
        $max_age = $lstCruisePriceChild[0]['max_age'];
        $assign_list['max_age'] = $max_age;
        $min_age = $lstCruisePriceChild[0]['min_age'];
        $assign_list['min_age'] = $min_age;
    }
    $html = $clsISO->build("ajaxLoadCabinCheck.tpl");
    echo ($html);
    die();
}

function default_ajBookCabinCruise()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO;
    global $_lang, $extLang, $_LANG_ID, $now_day, $now_month;
    if (Input::exists('lang_id', 'GET')) {
        $_LANG_ID = Input::get('lang_id');
        vnSessionSetVar("_LANG_ID", $_LANG_ID);
    } else if (vnSessionExist("_LANG_ID")) {
        $_LANG_ID = vnSessionGetVar("_LANG_ID");
    }

    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list['clsCruiseCabin'] = $clsCruiseCabin;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;


    $cruise_id = Input::post('cruise_id', 0);
    $cruise_itinerary_id = Input::post('cruise_itinerary_id', 0);
    $cruise_cabin_id = Input::post('cruise_cabin_id', 0);
    $type = Input::post('type', '');
    $number_adult = Input::post('number_adult', 0);
    $number_child = Input::post('number_child', 0);
    $number_cabin = Input::post('number_cabin', 0);
    $totalprice = Input::post('totalprice', 0);
    $max_adult = Input::post('max_adult', 0);
    $departure_date = Input::post('departure_date', 0);
    $children = Input::post('children', '');
    $str_departure_date = $departure_date ? strtotime($departure_date) : '';


    $discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $str_departure_date, 'info_promotion');
    $promotion = $discount['discount_value'];

    $SessionChooseCabin = array();
    if (!empty($cruise_cabin_id)) {
        $SessionChooseCabin['BookingCruise'] = 'BookingCruise';
        $SessionChooseCabin['cruise_id'] = $cruise_id;
        $SessionChooseCabin['promotion'] = $promotion;
        $SessionChooseCabin['cruise_itinerary_id'] = $cruise_itinerary_id;
        $SessionChooseCabin['departure_date'] = $str_departure_date;
        $SessionChooseCabin['cabin']['cruise_id'] = $cruise_id;
        $SessionChooseCabin['cabin']['cruise_itinerary_id'] = $cruise_itinerary_id;
        $SessionChooseCabin['cabin']['cruise_cabin_id'] = $cruise_cabin_id;
        $SessionChooseCabin['cabin']['number_adult'] = $number_adult;
        $SessionChooseCabin['cabin']['number_child'] = $number_child;
        $SessionChooseCabin['cabin']['children'] = $children;
        $SessionChooseCabin['cabin']['number_cabin'] = $number_cabin;
        $SessionChooseCabin['cabin']['max_adult'] = $max_adult;
        $SessionChooseCabin['cabin']['totalprice'] = $totalprice;
    }
    //  var_dump($SessionChooseCabin);die;
    vnSessionSetVar('BookingCruise_' . $_LANG_ID, $SessionChooseCabin);
    $link = $clsCruise->getLinkBook($cruise_id);

    echo $link;
    die();
}



// Filter sort for cruise
function filter_cruise($filter = [], $count = false) {
    global $now_month, $smarty, $dbconn, $lang_sql, $assign_list, $core, $cat_id, $clsISO, $extLang;

    $clsCruisePriceRange = new CruisePriceRange();
    $assign_list["clsCruisePriceRange"] = $clsCruisePriceRange;
    $currentPage = $filter["page"] ?? 1;
    $recordPerPage = 10;
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    
    #
    $cond = $cond_def = "is_trash = 0 and is_online = 1";
    $order_by = " order by c.cruise_id";

    $query = "SELECT c.* FROM default_cruise c ";
    $where = " where c.lang_id = '$lang_sql' and c.is_trash = 0 and c.is_online = 1 ";
    $group_by = " group by c.cruise_id ";
    $inner_join = $having = "";

    // Danh mục
    $cat_id = $filter['cat_id'];
    if ($cat_id > 0) {
        $cond .= " and (cruise_cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%')";
        $assign_list["cruise_cat_id"] = $cat_id;
    }
    
    // sắp xếp 
    $sort = $filter['sort'] ?? '';
    $smarty->assign("sort", $sort);
    if ($sort == 1 || $sort == 2) {
        $order_by = " ORDER BY c.min_price " . (($sort == 2) ? "DESC" : "ASC");
    }
    if ($sort == 3 || $sort == 4) {
        $inner_join .= " LEFT JOIN default_reviews r ON c.cruise_id = r.table_id and r.type = 'cruise'";
        $order_by = " ORDER BY AVG(r.rates) " . (($sort == 3) ? "DESC" : "ASC");
    }
    

    // Filter theo khoảng giá
    $lstSeason = (new Configuration())->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
    $season = !empty($lstSeason) ? 'high' : 'low';

    $price_id = $filter['price_id'] ?? '';
    $smarty->assign('price_id', explode(",", $price_id));
    if (!empty($price_id) || $sort) {
        $onePriceRange = $clsCruisePriceRange->getAll("$clsCruisePriceRange->pkey IN ($price_id)", 'MIN(min_rate) as min_rate, MAX(max_rate) as max_rate');
        $min_rate = $onePriceRange[0]['min_rate'];
        $max_rate = $onePriceRange[0]['max_rate'];
        $add_cond = "";
        $inner_join .= " LEFT JOIN default_cruise_season_price csp ON c.cruise_id = csp.cruise_id $add_cond";
        if (!empty($price_id)) {
            $where .= " and csp.price > 0 AND csp.season = '$season' ";
            $having = "HAVING $min_rate <= MIN(csp.price) 
                              AND $max_rate >= MIN(csp.price) ";
        }
    }

    // Filter theo hành trình
    $itineraries = $filter['itineraries'] ?? '';
    $smarty->assign("itineraries", $itineraries);
    if (!empty($itineraries)) {
        $conditions = array();
        $inner_join .= " INNER JOIN default_cruise_itinerary ci USING (cruise_id) ";

        foreach (explode(",", $itineraries) as $v) {
            if ($v == 1) $conditions[] = "(ci.number_day < '1')";
            if ($v == 2) $conditions[] = "(ci.number_day >= '1' AND ci.number_day <= '3')";
            if ($v == 3) $conditions[] = "(ci.number_day >= '4' AND ci.number_day <= '7')";
            if ($v == 4) $conditions[] = "(ci.number_day >= '7')";
        }
        $where .= " and (" . implode(" OR ", $conditions) . ")";
    }

    // filter theo hạng tàu
    $rank_cruise = $filter['rank_cruise'] ?? '';
    $smarty->assign("rank_cruise", $rank_cruise);
    if (!empty($rank_cruise)) {
        $rank_cruise = str_replace("2", "0", $rank_cruise);
        $where .= " and c.star_number IN ($rank_cruise)";
    }

    // Filter theo số lượng cabin
    $cabins = $filter['cabins'] ?? '';
    $smarty->assign('cabins', $cabins);
    if (!empty($cabins)) {
        $conditions = array();
        $cabins = explode(",", $cabins);
        $cabin_arr = $clsISO->makeCheckboxDuration("cabins");

        foreach ($cabins as $v) {
            $conditions[] = "(c.total_cabin >= '{$cabin_arr[$v - 1]['min']}' AND c.total_cabin <= '{$cabin_arr[$v - 1]['max']}')";
        }

        $where .= " and (" . implode(" OR ", $conditions) . ")";
    }

    
    $sql = $query . $inner_join . $where . $group_by . $having . $order_by . $limit;
    if ($count == true) {
        $sql = $query . $inner_join . $where . $group_by . $having;
    }
    //var_dump($sql);
    return $dbconn->getAll($sql);
}