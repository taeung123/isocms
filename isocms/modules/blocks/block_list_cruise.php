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
global $smarty, $dbconn, $now_day, $mod, $now_month, $clsISO, $cat_id, $act, $lang_sql;

$clsCruiseCat = new CruiseCat();
$clsCruise = new Cruise;
$clsCruiseSeasonPrice = new CruiseSeasonPrice;
$clsCruisePriceRange = new CruisePriceRange();
$clsCruiseItinerary = new CruiseItinerary();

$cond = $cond_def = "is_trash = 0 and is_online = 1";
$order_by = " order by c.order_no";

$query = "SELECT c.* FROM default_cruise c ";
$where = " where c.lang_id = '$lang_sql' and c.is_trash = 0 and c.is_online = 1 ";
$group_by = " group by c.cruise_id ";
$inner_join = $having = "";

$smarty->assign("clsCruiseCat", $clsCruiseCat);
$order_field = !empty($cat_id) ? "FIELD($clsCruiseCat->pkey, $cat_id) DESC, " : "";
$lstCruiseCatSearch = $clsCruiseCat->getAll("$cond_def and parent_id=$cat_id order by $order_field order_no", $clsCruiseCat->pkey . ',title');
$smarty->assign("lstCruiseCatSearch", $lstCruiseCatSearch);

$listCruiseRangePrice = $clsCruisePriceRange->getAll("is_trash=0 order by order_no asc", "$clsCruisePriceRange->pkey, title");
$smarty->assign("listCruiseRangePrice", $listCruiseRangePrice);

$price_id = $_GET["price_id"] ?? '';
$smarty->assign('price_id', explode(",", $price_id));
$cabins = $_GET["cabins"] ?? '';
$smarty->assign('cabins', $cabins);
$itineraries = $_GET["itineraries"] ?? '';
$smarty->assign("itineraries", $itineraries);
$rank_cruise = $_GET["rank_cruise"] ?? '';
$smarty->assign("rank_cruise", $rank_cruise);
$sort = $_GET["sort"] ?? '';
$smarty->assign("sort", $sort);
$key = $_GET["key"] ?? '';
$smarty->assign("key", $key);
$cruise_cat_id = $_GET["cruise_cat_id"] ?? '';
$smarty->assign('list_cat_id', $cruise_cat_id);
$departure_date = $_GET["departure_date"] ?? 0;
$smarty->assign('departure_date', $departure_date);

if (isset($_GET['search2024'])) {
    $currentPage = $_GET["page"] ?? 1;
    $recordPerPage = 10;
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    if (!empty($key)) {
        $where .= " and slug LIKE '%{$clsISO->replaceSpace($key)}%' ";
    }

    if (empty($cruise_cat_id) && !empty($cat_id)) $cruise_cat_id = $cat_id;

    if (!empty($cruise_cat_id)) {
        foreach (explode(",", $cruise_cat_id) as $v) {
            $conditions[] = " list_cat_id LIKE '%|$v|%' ";
        }
        if (!empty($conditions)) {
            $where .= " and (" . implode(" OR ", $conditions) . ")";
        }
    }
    $lstSeason = (new Configuration())->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
    $season = !empty($lstSeason) ? 'high' : 'low';
    if (!empty($price_id) || $sort) {
        $onePriceRange = $clsCruisePriceRange->getAll("$clsCruisePriceRange->pkey IN ($price_id)", 'MIN(min_rate) as min_rate, MAX(max_rate) as max_rate');
        $min_rate = $onePriceRange[0]['min_rate'];
        $max_rate = $onePriceRange[0]['max_rate'];
        $add_cond = "";
        $inner_join = " LEFT JOIN default_cruise_season_price csp ON c.cruise_id = csp.cruise_id $add_cond";
        if (!empty($price_id)) {
            $where .= " and csp.price > 0 AND csp.season = '$season' ";
            $having = "HAVING $min_rate <= MIN(csp.price) 
                              AND $max_rate >= MIN(csp.price) ";
        }
    }
    // Cho phần sắp xếp
    if ($sort == 1 || $sort == 2) {
        $order_by = " ORDER BY c.min_price " . (($sort == 2) ? "DESC" : "ASC");
    }
    if ($sort == 3 || $sort == 4) {
        $inner_join .= " LEFT JOIN default_reviews r ON c.cruise_id = r.table_id and r.type = 'cruise'";
        $order_by = " ORDER BY AVG(r.rates) " . (($sort == 3) ? "DESC" : "ASC");
    }

    if (isset($rank_cruise)) {
        $rank_cruise = str_replace("2", "0", $rank_cruise);
        $where .= " and c.star_number IN ($rank_cruise)";
    }

    if (!empty($cabins)) {
        $conditions = array();
        $cabins = explode(",", $cabins);
        $cabin_arr = $clsISO->makeCheckboxDuration("cabins");

        foreach ($cabins as $v) {
            $conditions[] = "(c.total_cabin >= '{$cabin_arr[$v - 1]['min']}' AND c.total_cabin <= '{$cabin_arr[$v - 1]['max']}')";
        }

        $where .= " and (" . implode(" OR ", $conditions) . ")";
    }

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

    //    var_dump($query.$inner_join.$where.$group_by.$having. $order_by . $limit);
    $listCruise = $dbconn->getAll($query . $inner_join . $where . $group_by . $having . $order_by . $limit);
    $smarty->assign('listCruise', $listCruise);

    # Paginate
    $clsPagination = new Pagination();
    $totalRecord = $dbconn->getAll($query . $inner_join . $where . $group_by . $having);

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

    $smarty->assign("page_view", $page_view);
    $smarty->assign("totalRecord", $totalRecord);
    $totalPage = $clsPagination->getTotalPage();
    $smarty->assign("totalPage", $totalPage);
}
$url = strtok($_SERVER["REQUEST_URI"], '?');
$smarty->assign("reset_filter", $url);
