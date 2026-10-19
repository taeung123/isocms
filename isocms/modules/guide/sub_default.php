<?php
function default_default()
{
    global $_LANG_ID, $assign_list, $extLang, $core, $dbconn, $mod, $act, $clsISO, $title_page, $description_page, $keyword_page, $city_id;
    #
    $clsConfiguration = new Configuration();
	$SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);
    $homeUrl = PCMS_URL;
    if($_LANG_ID != $SiteDefaultLanguage) {
        $homeUrl .= $_LANG_ID;
    }
    $assign_list["homeUrl"] = $homeUrl;
    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;

    #
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsGuideCatStore = new GuideCatStore();
    $assign_list["clsGuideCatStore"] = $clsGuideCatStore;
    $clsPagination = new Pagination();
    $lnk = $_SERVER['REQUEST_URI'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $country_id = $_POST['country_id'];
        $guide_cat = $_POST['guide_cat'];
        $link = !empty($country_id) ? "{$clsISO->getLink('destination2')}/{$clsCountry->getSlug($country_id)}/travel-guide" : $clsISO->getLink("travel-guide");

        $key_search = $_POST["keyword_search"] ?? "";
        $link .=  "?key=$key_search";
        if (!empty($guide_cat)) $link .=  "&cat={$clsISO->makeSlashListFromArrayComma($guide_cat)}";

        header('Location: ' . trim($link));
        exit();
    }
    
    #
    $listGuideCat = $clsGuideCat->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsGuideCat->pkey . ',slug,title,intro,image');
    $assign_list['listGuideCat'] = $listGuideCat;
    unset($listGuideCat);

    # Paginate
    if (isset($_GET['page'])) {
        $tmp = explode('&', $lnk);
        $n = count($tmp) - 1;
        $la_it = '&' . $tmp[$n];
        $str_len = -strlen($la_it);
        $link_page = substr($lnk, 0, $str_len);
    } else {
        $link_page = $lnk;
    }
    $cond = "is_trash=0 and is_online=1";
    $order_by = " order by order_no ASC";

    $slug_country = $_GET["slug_country"] ?? 0;
    $country_id = $clsCountry->getBySlug($slug_country);
    $keyword_search = $_GET["key"] ?? "";
    $guidecat_id = $_GET["cat"] ?? "";
    // Lọc theo quốc gia
    if (!empty($country_id)) {
        $cond .= " AND country_id = $country_id";
        $assign_list['country_id'] = $country_id;
    }
    if (!empty($guidecat_id)) {
        $guidecat_id_cond = array();
        foreach (explode(",", $guidecat_id) as $v) {
            $guidecat_id_cond[] = " list_cat_id LIKE '%|$v|%' ";
        }
        if (!empty($guidecat_id_cond)) {
            $cond .= " and (" . implode(" OR ", $guidecat_id_cond) . ")";
        }
        $assign_list["list_guidecat_id"] = $guidecat_id;
    }
    if (!empty($keyword_search)) {
        $cond .= " AND title LIKE '%$keyword_search%' OR slug LIKE '%$keyword_search%'";
        $assign_list["keyword_search"] = $keyword_search;
    }

    $recordPerPage = 9;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $totalItem = $clsGuide->getAll($cond, $clsGuide->pkey);
    $totalRecord = $totalItem ? count($totalItem) : 0;
    $assign_list['totalRecord'] = $totalRecord;

    $config = array(
        'total'	=> $totalRecord,
        'number_per_page'	=> $recordPerPage,
        'current_page'	=> $currentPage,
        'link'	=> str_replace('.html', '/', $link_page),
        'link_page'	=> $link_page
    );

    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links();
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    $listGuide = $clsGuide->getAll("$cond $order_by $limit", $clsGuide->pkey . ',slug,title,intro,image,country_id');
    $assign_list['listGuide'] = $listGuide;
    $assign_list['page_view'] = $page_view;
    unset($listGuide);

    $clsCountry = new Country();
    $assign_list['clscountry'] = $clsCountry;
    $lstCountry = $clsCountry->getAll('is_trash = 0 AND is_online=1', 'country_id, title');
    $assign_list['lstCountry'] = $lstCountry;

    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('Travel Guide') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /* =============Content Page================== */
}


function default_default2()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $city_id;
    global $clsISO;
    #
    $currentPage = false;
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list["show"] = $show;

    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsGuideCatStore = new GuideCatStore();
    $assign_list["clsGuideCatStore"] = $clsGuideCatStore;

    $clsPagination = new Pagination();
    #
    $slug_country = $_GET['slug_country'];
    $country_id = $clsCountryEx->getBySlug($slug_country);
    if (intval($country_id) == 0 && $clsCountryEx->checkExitsId($country_id) == '0') {
        header('location:' . PCMS_URL);
        exit();
    }
    $assign_list['country_id'] = $country_id;
    #
    if ($show == 'cat') {
        $slug = $_GET['slug'];
        $all = $clsGuideCat->getAll("is_trash=0 and is_online=1 and parent_id=0 and slug='$slug' LIMIT 0,1", $clsGuideCat->pkey);
        $guidecat_id = $all[0][$clsGuideCat->pkey];
        if (intval($guidecat_id) == 0) {
            header('location:' . PCMS_URL);
            exit();
        }
        $assign_list["guidecat_id"] = $guidecat_id;
        $nav = $clsGuideCat->getNAV($guidecat_id);
        $assign_list["nav"] = $nav;
        unset($nav);
    }
    #
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $assign_list['currentPage'] = $currentPage;
    $recordPerPage = 12;
    $assign_list['recordPerPage'] = $recordPerPage;

    $cond = "is_trash=0 and is_online=1 and country_id = '$country_id'";
    if ($guidecat_id > 0) {
        $cond .= " and (cat_id='$guidecat_id' or list_cat_id like '%|" . $guidecat_id . "|%')";
    }
    $order_by = " order by order_no ASC";
    $totalRecord = $clsGuide->getAll($cond) ? count($clsGuide->getAll($cond)) : 0;

    $link_page = $clsGuideCat->getLink($guidecat_id, $country_id, 0);
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

    $listGuide = $clsGuide->getAll($cond . $order_by . $limit, $clsGuide->pkey);
    $assign_list['listGuide'] = $listGuide;
    unset($listGuide);
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();

    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('travelguide') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /* =============Content Page================== */
    unset($clsCountryEx);
}

function default_cat()
{
    global $assign_list, $extLang, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $city_id;
    global $clsISO;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list["show"] = $show;

    $clsCountryEx = new Country();
    $assign_list['clsCountryEx'] = $clsCountryEx;
    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;
    $clsBlog = new Blog();
    $assign_list['clsBlog'] = $clsBlog;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuide2 = new Guide2();
    $assign_list["clsGuide2"] = $clsGuide2;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsGuideCatStore = new GuideCatStore();
    $assign_list["clsGuideCatStore"] = $clsGuideCatStore;
    $clsCityStore = new CityStore();
    $assign_list['clsCityStore'] = $clsCityStore;
    $clsPagination = new Pagination();
    #

    if ($show == 'Country') {
        $slug_country = $_GET['slug_country'];
        $country_id = $clsCountryEx->getBySlug($slug_country);
        if (intval($country_id) == 0) {
            header('location:' . PCMS_URL);
            exit();
        }
        $assign_list['country_id'] = $country_id;

        $title_page = $clsCountryEx->getTitle($country_id);
        $intro_page = $clsCountryEx->getStripIntro($country_id);
        $content_page = $clsCountryEx->getContent($country_id);
        $link_page = $clsCountryEx->getLink($country_id);

        $oneItem = $clsCountryEx->getOne($country_id);

        $slug_guidecat = $_GET['slug_guidecat'];
        $guidecat_id = $clsGuideCat->getBySlug($slug_guidecat);
        if (intval($guidecat_id) == 0) {
            header('location:' . DOMAIN_NAME . $extLang);
            exit();
        }
        $assign_list['guidecat_id'] = $guidecat_id;


        $lstGuide2 = $clsGuide2->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and cat_id='$guidecat_id' and region_id='0' and city_id='0' order by order_no ASC limit 0,1", $clsGuide2->pkey);
        $guide2_id = $lstGuide2[0]['guide2_id'];
        $assign_list['guide2_id'] = $guide2_id;

        $lstRegionByCountry = $clsRegion->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no ASC", $clsRegion->pkey . ",title");
        $assign_list['lstRegionByCountry'] = $lstRegionByCountry;
        unset($lstRegionByCountry);

        $lstCityRegionOther = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id='0' and  city_id IN (SELECT city_id FROM " . DB_PREFIX . "guide WHERE is_trash=0 and is_online=1) order by order_no ASC", $clsCity->pkey . ",title");

        $assign_list['lstCityRegionOther'] = $lstCityRegionOther;
        unset($lstCityRegionOther);
    }


    if ($show == 'Region') {
        $slug_country = $_GET['slug_country'];
        $country_id = $clsCountryEx->getBySlug($slug_country);
        if (intval($country_id) == 0 && $clsCountryEx->checkExitsId($country_id) == '0') {
            header('location:' . PCMS_URL);
            exit();
        }
        $assign_list['country_id'] = $country_id;


        $region_id = isset($_GET['region_id']) ? $_GET['region_id'] : '';
        if (intval($region_id) == 0) {
            header('Location:' . PCMS_URL . $extLang);
            exit();
        }
        $assign_list["region_id"] = $region_id;

        $title_page = $clsRegion->getTitle($region_id);
        $intro_page = $clsRegion->getStripIntro($region_id);
        $content_page = $clsRegion->getContent($region_id);
        $link_page = $clsRegion->getLink($region_id);

        $oneItem = $clsRegion->getOne($region_id);

        $slug_guidecat = $_GET['slug_guidecat'];
        $guidecat_id = $clsGuideCat->getBySlug($slug_guidecat);
        if (intval($guidecat_id) == 0 && $clsGuideCat->checkExitsId($guidecat_id) == '0') {
            header('location:' . PCMS_URL);
            exit();
        }
        $assign_list['guidecat_id'] = $guidecat_id;

        $lstGuide2 = $clsGuide2->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id='$region_id' and cat_id='$guidecat_id' and city_id='0' order by order_no ASC limit 0,1", $clsGuide2->pkey);
        $guide2_id = $lstGuide2[0]['guide2_id'];
        $assign_list['guide2_id'] = $guide2_id;
    }
    // Show Is City

    if ($show == 'City') {
        $slug_city = isset($_GET['slug_city']) ? $_GET['slug_city'] : '';
        $city_id = $clsCity->getBySlug($slug_city);
        if (intval($city_id) == 0) {
            header('Location:' . PCMS_URL . $extLang);
            exit();
        }
        $assign_list["city_id"] = $city_id;
        $title_page = $clsCity->getTitle($city_id);
        $intro_page = $clsCity->getIntro($city_id);
        $content_page = $clsCity->getContent($city_id);
        $link_page = $clsCity->getLink($city_id);

        $oneItem = $clsCity->getOne($city_id);

        $country_id = $clsCity->getOneField('country_id', $city_id);
        $assign_list['country_id'] = $country_id;

        $slug_guidecat = $_GET['slug_guidecat'];
        $guidecat_id = $clsGuideCat->getBySlug($slug_guidecat);
        if (intval($guidecat_id) == 0 && $clsGuideCat->checkExitsId($guidecat_id) == '0') {
            header('location:' . PCMS_URL);
            exit();
        }
        $assign_list['guidecat_id'] = $guidecat_id;

        $lstGuide2 = $clsGuide2->getAll("is_trash=0 and is_online=1 and city_id='$city_id' and cat_id='$guidecat_id' order by order_no ASC limit 0,1", $clsGuide2->pkey);
        $guide2_id = $lstGuide2[0]['guide2_id'];
        $assign_list['guide2_id'] = $guide2_id;
    }

    // Show Is Cat
    if ($show == 'GuideCat') {
        $slug_guidecat = $_GET['slug_guidecat'];
        $guidecat_id = $clsGuideCat->getBySlug($slug_guidecat);
        if (intval($guidecat_id) == 0 && $clsGuideCat->checkExitsId($guidecat_id) == '0') {
            header('location:' . PCMS_URL);
            exit();
        }
        $assign_list['guidecat_id'] = $guidecat_id;

        $title_page = $clsGuideCat->getTitle($guidecat_id);
        $intro_page = $clsGuideCat->getIntro($guidecat_id);
        $link_page = $clsGuideCat->getLink($guidecat_id);

    }

    $assign_list['TD'] = $title_page;
    $assign_list['ID'] = $intro_page;
    $assign_list['CD'] = $content_page;
    $assign_list['link_page'] = $link_page;
    #
    $cond = "is_trash=0 and is_online=1";
    $recordPerPage = 6;
    if ($show == 'Country' && intval($country_id) > 0) {
        $cond .= " and country_id='$country_id'";
    }
    if ($show == 'City' && intval($city_id) > 0) {
        $cond .= " and city_id='$city_id'";
    }
    if ($show == 'Region' && intval($region_id) > 0) {
        $cond .= " and city_id IN (SELECT city_id FROM " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1 and country_id='$country_id' and region_id='$region_id')";
    }
    if ($guidecat_id > 0) {
        $cond .= " and (cat_id='$guidecat_id' or list_cat_id like '%|$guidecat_id|%')";
    }
    //print_r($cond);die();
    $order_by = " order by order_no asc";
    $totalRecord = $clsGuide->getAll($cond) ? count($clsGuide->getAll($cond)) : 0;
    $link_page = $clsGuideCat->getLink($guidecat_id, $country_id, 0);

    $listGuide = $clsGuide->getAll($cond . $order_by);

    $assign_list['listGuide'] = $listGuide;
    unset($listGuide);
    $assign_list['totalPage'] = $clsPagination->getTotalPage();


    $listGuideCat = $clsGuideCat->getAll("is_trash=0 and is_online=1");
    $assign_list['listGuideCat'] = $listGuideCat;

    unset($listGuideCat);


    if ($show == 'Country') {
        $listHotelPlace = $clsHotel->getAll("is_trash=0 and is_online=1 and country_id='$country_id'", $clsHotel->pkey . ',star_id');
        $listBlogPlace = $clsBlog->getAll("is_trash=0 and is_online=1 and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id')", $clsBlog->pkey);
    } elseif ($show == 'City') {
        $listHotelPlace = $clsHotel->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and city_id='$city_id'", $clsHotel->pkey . ',star_id');
        $listBlogPlace = $clsBlog->getAll("is_trash=0 and is_online=1 and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id' and city_id='$city_id')", $clsBlog->pkey);
    } elseif ($show == 'GuideCat') {
    } else {
        $listHotelPlace = $clsHotel->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id='$region_id'", $clsHotel->pkey . ',star_id');
        $listBlogPlace = $clsBlog->getAll("is_trash=0 and is_online=1 and and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE region_id='$region_id')", $clsBlog->pkey);
    }


    $assign_list['listHotelPlace'] = $listHotelPlace;
    unset($listHotelPlace);

    $assign_list['listBlogPlace'] = $listBlogPlace;
    unset($listBlogPlace);

    $letter = array();
    foreach (range('a', 'z') as $i) {
        $lstCityAZ = $clsISO->getItemByAlphabetCityGuide($country_id, $region_id, 0, $guidecat_id, $i);
        if (!empty($lstCityAZ)) {
            $letter[] = $i;
        }
    }
    $assign_list['letter'] = $letter;
    /* =============Title & Description Page================== */
    if ($show != 'GuideCat') {
        $title_page = $clsGuideCat->getTitle($guidecat_id) . ' | ' . $title_page . ' | ' . PAGE_NAME;
    } else {
        $title_page = $title_page . ' | ' . PAGE_NAME;
    }

    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($guidecat_id, 'GuideCat');
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($guidecat_id, 'GuideCat');
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /* =============Content Page================== */
    unset($clsCountryEx);

}


function default_loadGuideItems()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
    global $clsISO;
    #
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsGuideCatStore = new GuideCatStore();
    $assign_list["clsGuideCatStore"] = $clsGuideCatStore;

    $guidecat_id = isset($_POST['guidecat_id']) ? $_POST['guidecat_id'] : 0;
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $recordPerPage = 9;

    $cond = "is_trash=0 and is_online=1 and country_id = '$country_id'";
    if ($guidecat_id > 0) {
        $cond .= " and (cat_id='$guidecat_id' or list_cat_id like '%|" . $guidecat_id . "|%')";
    }
    $order_by = " order by order_no DESC";

    $offset = ($page - 1) * $recordPerPage;
    $limit = " limit $offset,$recordPerPage";
    $Html = '';

    $listGuide = $clsGuide->getAll($cond . $order_by . $limit, $clsGuide->pkey);
    if (is_array($listGuide) && count($listGuide) > 0) {
        for ($i = 0; $i < count($listGuide); $i++) {
            $Html .= '
			<li class="list_Elems">
				<div class="row">
					<div class="col-md-4">
						<a class="photo" href="' . $clsGuide->getLink($listGuide[$i][$clsGuide->pkey]) . '" title="' . $clsGuide->getTitle($listGuide[$i][$clsGuide->pkey]) . '"><img class="img-responsive" src="' . $clsGuide->getImage($listGuide[$i][$clsGuide->pkey], 600, 400) . '" alt="' . $clsGuide->getTitle($listGuide[$i][$clsGuide->pkey]) . '" width="100%" /></a>
					</div>
					<div class="col-md-8">
						<h3 class="title"><a href="' . $clsGuide->getLink($listGuide[$i][$clsGuide->pkey]) . '" title="' . $clsGuide->getTitle($listGuide[$i][$clsGuide->pkey]) . '">' . $clsGuide->getTitle($listGuide[$i][$clsGuide->pkey]) . '</a></h3>
						<div class="text">' . $clsISO->myTruncate($clsGuide->getStripIntro($listGuide[$i][$clsGuide->pkey]), 250) . '</div>
					</div>
				</div>
			</li>';
        }
    } else {
        $Html .= 'NOT_RESULT';
    }
    echo $Html;
    die();
}

function default_detail()
{

    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $city_id, $country_id, $extLang, $clsISO;
    #
    $clsGuide = new Guide();
    $assign_list["clsGuide"] = $clsGuide;
    $clsGuideCat = new GuideCat();
    $assign_list["clsGuideCat"] = $clsGuideCat;
    $clsCountryEx = new Country();
    $assign_list["clsCountryEx"] = $clsCountryEx;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;

    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list["show"] = $show;

    #
    $guide_id = isset($_GET['guide_id']) ? $_GET['guide_id'] : 0;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    if (empty($clsGuide->checkOnlineBySlug($guide_id, $slug))) {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    }
    $assign_list['guide_id'] = $guide_id;


    $one = $clsGuide->getOne($guide_id);

    $city_id = $one['city_id'];
    $assign_list['city_id'] = $city_id;

    $country_id = $one['country_id'];
    $assign_list['country_id'] = $country_id;

    $guidecat_id = $one['cat_id'];
    $assign_list["guidecat_id"] = $guidecat_id;
    $listGuideCat = $clsGuideCat->getAll("is_trash=0 and is_online=1", $clsGuideCat->pkey);
    $assign_list['listGuideCat'] = $listGuideCat;
    unset($listGuideCat);

    #- Related

    $sql = "is_trash=0 and is_online=1 and (cat_id='$guidecat_id' or list_cat_id like '%|$guidecat_id|%')";
    if ($country_id > 0) {
        $sql .= " and country_id='$country_id'";
    }
    if ($city_id > 0) {
        $sql .= " and city_id='$city_id'";
    }
    $lstRelated = $clsGuide->getAll($sql . " and guide_id<>'$guide_id' order by rand() LIMIT 0,10", $clsGuide->pkey);
    $assign_list["lstRelated"] = $lstRelated;
    unset($lstRelated);

    /*=============Title & Description Page==================*/
    $title_page = $clsGuide->getTitle($guide_id) . ' | ' . $core->get_Lang('travelguide') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($guide_id, 'Guide');
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($guide_id, 'Guide');
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    unset($clsGuide);
}

?>