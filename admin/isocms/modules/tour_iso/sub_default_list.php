<?php
/**
 * ISOCMS Tour ISO - List Action Controller
 * Dedicated list controller to isolate list operations and prevent merge conflicts.
 */

function tour_iso_sub_default_list()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $extLang, $clsISO, $package_id, $dbconn;

    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $assign_list["clsUser"] = $clsUser;
    $user_id = $core->_USER['user_id'] ?? 0;
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    if (!is_object($clsConfiguration)) {
        $clsConfiguration = new Configuration();
    }
    $assign_list["clsConfiguration"] = $clsConfiguration;
    $hasAPI = $clsConfiguration->getValue('SiteTourAPI');
    $assign_list["hasAPI"] = $hasAPI;

    $is_set = isset($_GET['is_set']) ? $_GET['is_set'] : 0;
    $assign_list['is_set'] = $is_set;
    $now_day = time();
    $assign_list['now_day'] = $now_day;

    if (isset($_GET['is_set']) && $_GET['is_set'] == 'free') {
        if (!$clsConfiguration->getValue('SiteHasFreeEasy_Tours')) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
            exit();
        }
    }
    if (!empty($_POST["export_tour"]) && $_POST["export_tour"] == "export_tour") {
        header('location:' . PCMS_URL . '/?mod=export&type=export_tour');
        exit();
    }

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;

    $classTable = "Tour";
    $clsClassTable = new $classTable();
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;

    $clsTourGroup = new TourGroup();
    $assign_list["clsTourGroup"] = $clsTourGroup;
    $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    $assign_list["tour_group_id"] = $tour_group_id;

    $clsTourCat = new TourCategory();
    $assign_list["clsTourCat"] = $clsTourCat;
    $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    $assign_list["cat_id"] = $cat_id;

    $clsPriceRange = new PriceRange();
    $assign_list["clsPriceRange"] = $clsPriceRange;
    $price_range_id = isset($_GET['price_range_id']) ? intval($_GET['price_range_id']) : 0;
    $assign_list["price_range_id"] = $price_range_id;

    $lstCountry = $clsCountry->getAll("is_trash=0 and is_online=1 and country_id IN (SELECT country_id FROM " . DB_PREFIX . "tour_destination) order by order_no asc", $clsCountry->pkey);
    $assign_list["lstCountry"] = $lstCountry;

    $country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
    $assign_list["country_id"] = $country_id;
    $tour_type_id = isset($_GET['tour_type_id']) ? intval($_GET['tour_type_id']) : 0;
    $assign_list["tour_type_id"] = $tour_type_id;
    $check = isset($_GET['check']) ? intval($_GET['check']) : 0;
    $assign_list["check"] = $check;
    $departure_point_id = isset($_GET['departure_point_id']) ? intval($_GET['departure_point_id']) : 0;
    $assign_list["departure_point_id"] = $departure_point_id;
    $number_day = isset($_GET['number_day']) ? intval($_GET['number_day']) : 0;
    $assign_list["number_day"] = $number_day;

    // Filter Form Submission
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if (isset($_POST['tour_group_id']) && intval($_POST['tour_group_id']) != 0) {
            $link .= '&tour_group_id=' . intval($_POST['tour_group_id']);
        }
        if (isset($_POST['country_id']) && intval($_POST['country_id']) != 0) {
            $link .= '&country_id=' . intval($_POST['country_id']);
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) != 0) {
            $link .= '&cat_id=' . intval($_POST['cat_id']);
        }
        if (isset($_POST['tour_type_id']) && intval($_POST['tour_type_id']) != 0) {
            $link .= '&tour_type_id=' . intval($_POST['tour_type_id']);
        }
        if (isset($_POST['departure_point_id']) && intval($_POST['departure_point_id']) != 0) {
            $link .= '&departure_point_id=' . intval($_POST['departure_point_id']);
        }
        if (isset($_POST['number_day']) && intval($_POST['number_day']) != 0) {
            $link .= '&number_day=' . intval($_POST['number_day']);
        }
        if (isset($_POST['price_range_id']) && intval($_POST['price_range_id']) != 0) {
            $link .= '&price_range_id=' . intval($_POST['price_range_id']);
        }
        if (!empty($_POST['type_list'])) {
            $link .= '&type_list=' . urlencode($_POST['type_list']);
        }
        if (!empty($_POST['keyword']) && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . urlencode($_POST['keyword']);
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
        exit();
    }

    $pUrl = '';
    $cond = "1=1";

    if ($tour_group_id > 0) {
        $cond .= " and tour_group_id=" . $tour_group_id;
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    if (intval($tour_type_id) > 0) {
        $cond .= " and tour_type_id=" . $tour_type_id;
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (intval($country_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id')";
        $pUrl .= '&country_id=' . $country_id;
    }
    if (intval($cat_id) > 0) {
        $cond .= " and (cat_id = '$cat_id' or list_cat_id like '%|$cat_id|%')";
        $pUrl .= '&cat_id=' . $cat_id;
    }
    if (intval($departure_point_id) > 0) {
        $cond .= " and departure_point_id = '" . $departure_point_id . "'";
        $pUrl .= '&departure_point_id=' . $departure_point_id;
    }
    if (isset($number_day) && intval($number_day) != 0) {
        $cond .= " and number_day = '" . $number_day . "'";
        $pUrl .= '&number_day=' . $number_day;
    }
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $keyword = trim($_GET['keyword']);
        $slug = $core->replaceSpace($keyword);
        
        $search_clauses = [
            "trip_code like '%" . addslashes($keyword) . "%'",
            "slug like '%" . addslashes($slug) . "%'",
            "title like '%" . addslashes($keyword) . "%'"
        ];

        // Search by ID if keyword contains numeric ID (e.g. 1059, #1059, #1059-...)
        $clean_id = ltrim($keyword, '#');
        if (is_numeric($clean_id) && intval($clean_id) > 0) {
            $search_clauses[] = "tour_id = '" . intval($clean_id) . "'";
        } elseif (preg_match('/^#?(\d+)/', $keyword, $matches) && intval($matches[1]) > 0) {
            $search_clauses[] = "tour_id = '" . intval($matches[1]) . "'";
        }

        // Search by destination (city or country name)
        $search_clauses[] = "tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE city_id IN (SELECT city_id FROM " . DB_PREFIX . "city WHERE title LIKE '%" . addslashes($keyword) . "%' OR slug LIKE '%" . addslashes($slug) . "%') OR country_id IN (SELECT country_id FROM " . DB_PREFIX . "country WHERE title LIKE '%" . addslashes($keyword) . "%' OR slug LIKE '%" . addslashes($slug) . "%'))";

        $cond .= " and (" . implode(" or ", $search_clauses) . ")";
        $pUrl .= '&keyword=' . urlencode($keyword);
        $assign_list["keyword"] = $keyword;
    }
    if (isset($_GET['tour_id']) && $_GET['tour_id'] != '') {
        $cond .= " and tour_id ='" . intval($_GET['tour_id']) . "' ";
        $pUrl .= '&tour_id=' . intval($_GET['tour_id']);
        $assign_list["tour_id"] = $_GET['tour_id'];
    }
    if ($user_group_id == 2) {
        $cond .= " and user_id='$user_id'";
    }
    if ($clsClassTable->checkColumnInTable('parent_id')) {
        $cond .= " and parent_id=0";
    }

    $cond2 = $cond;
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    } elseif ($type_list == 'Publish') {
        $cond .= " and is_trash=0 and is_online=1";
    } elseif ($type_list == 'Private') {
        $cond .= " and is_trash=0 and is_online=0";
    } else {
        $cond .= " and is_trash=0";
    }

    $orderBy = " upd_date DESC, order_no DESC";

    // Page Divide
    $recordPerPage = isset($_GET["recordperpage"]) ? intval($_GET["recordperpage"]) : (defined('ADMIN_PAGINATION') ? ADMIN_PAGINATION : 20);
    if ($recordPerPage <= 0) $recordPerPage = 20;
    $currentPage = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->getAll($cond, $clsClassTable->pkey);
    $totalRecord = $totalRecord ? count($totalRecord) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
    $showingStart = ($totalRecord > 0) ? ($start_limit + 1) : 0;
    $showingEnd = min($totalRecord, $currentPage * $recordPerPage);
    $assign_list['showingStart'] = $showingStart;
    $assign_list['showingEnd'] = $showingEnd;
    $assign_list['previousPage'] = max(1, $currentPage - 1);
    $assign_list['nextPage'] = min($totalPage, $currentPage + 1);

    $listPageNumber = array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $assign_list['listPageNumber'] = $listPageNumber;

    $query_string = $_SERVER['QUERY_STRING'] ?? '';
    $lst_query_string = explode('&', $query_string);
    $link_page_current = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && !empty($tmp[0])) {
            $link_page_current .= ($link_page_current == '') ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
        }
    }
    $assign_list['link_page_current'] = $link_page_current;

    $link_page_current_2 = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != 'page' && $tmp[0] != 'type_list' && !empty($tmp[0])) {
            $link_page_current_2 .= ($link_page_current_2 == '') ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
        }
    }
    $assign_list['link_page_current_2'] = $link_page_current_2;

    $field = $clsClassTable->pkey . ",is_trash,is_online,user_id,user_id_update,reg_date,upd_date,is_for_agent";
    if ($clsISO->checkConnTMS()) {
        $field .= ",yield_id,tms_code";
    }
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $field);
    $assign_list["allItem"] = $allItem;

    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_trash"] = is_array($allTrash) ? count($allTrash) : 0;

    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_item"] = is_array($allUnTrash) ? count($allUnTrash) : 0;

    $allAll = $clsClassTable->getAll("is_trash=0 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_all"] = is_array($allAll) ? count($allAll) : 0;

    $allPublish = $clsClassTable->getAll("is_trash=0 and is_online=1 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_publish"] = is_array($allPublish) ? count($allPublish) : 0;

    $allPrivate = $clsClassTable->getAll("is_trash=0 and is_online=0 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_private"] = is_array($allPrivate) ? count($allPrivate) : 0;
    $assign_list["number_draft"] = $assign_list["number_private"];

    $assign_list['pUrl'] = $pUrl;

    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateToursIntro') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
        exit();
    }
}
