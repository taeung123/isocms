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
global $smarty, $dbconn, $now_day;
if (isset($_GET['search2024'])) {
    $clsTour = new Tour;

    $cond = "is_trash = 0 and is_online = 1";
    $cond_def = "is_trash = 0 and is_online = 1 ";
    $order_by = " order by order_no";

    $region = $_GET["region"] ?? '';
    $get_travel_style = $_GET["cat_id"] ?? 0;
    $duration = $_GET["duration_id"] ?? '';
    $rating = $_GET["rating"] ?? '';
    $sort = $_GET["sort"] ?? '';
    $departure_point = $_GET["departure_point_id"] ?? '';
    $country_id = $_GET["country_id"] ?? '';
    $city_id = $_GET["city_filter_id"] ?? '';
    $min_price_query = $_GET['min_price'] ?? '';
    $max_price_query = $_GET['max_price'] ?? '';
    $currentPage = $_GET["page"] ?? 1;
    $departure_date = $_GET["departure_date"] ?? 0;

    $recordPerPage = 10;
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";

    if (!empty($get_travel_style)) {
        $travel_style_cond = str_replace(',', ' ', $get_travel_style);
        $cond .= " and MATCH(list_cat_id) AGAINST('$travel_style_cond' IN NATURAL LANGUAGE MODE)";
    }

    if (!empty($departure_point)) {
        $departure_point_conditions = str_replace(',', ' ', $departure_point);
        $cond .= " and MATCH(list_departure_point_id) AGAINST('$departure_point_conditions' IN NATURAL LANGUAGE MODE)";
    }

    if (!empty($duration)) {
        $cond .= " and (";
        $conditions = array();

        foreach (explode(",", $duration) as $v) {
            $number = explode("-", $v);
            $number_day = $number[0] ?? 0;
            $number_night = $number[1] ?? 0;
            $conditions[] = "(number_day = '$number_day' AND number_night = '$number_night')";
            /*if ($v == 1) $conditions[] = "(duration_custom != '' OR duration_custom IS NOT NULL)";
            if ($v == 2) $conditions[] = "(number_day >= '1' AND number_day <= '3')";
            if ($v == 3) $conditions[] = "(number_day >= '4' AND number_day <= '7')";
            if ($v == 4) $conditions[] = "(number_day > '7')";
            if ($v == 5) $conditions[] = "(number_day > '14')";
            if ($v == 6) $conditions[] = "(number_day > '21')";*/
        }
        $cond .= implode(" OR ", $conditions) . ")";
    }

    if ($min_price_query > 0) {
        $cond .= " and min_price >= '$min_price_query'";
    }
    if ($max_price_query > 0) {
        $cond .= " and min_price <= '$max_price_query'";
    }

    if ($country_id) {
        $cond_city = "";
        if (!empty($city_id)) {
            $cond_city = "and city_id IN ($city_id)";
        }
        $cond .=  " and tour_id IN (select tour_id from default_tour_destination where country_id = $country_id $cond_city)";
    }
    // Cho phần sắp xếp
    if ($sort) {
        if ($sort == 1) {
            $cond .= " and is_best_price = 1";
        } else if ($sort == 2) {
            $cond .= " and is_recommended = 1";
        } else if ($sort == 3) {
            $order_by = " order by (SELECT AVG(rates) FROM default_reviews WHERE $cond_def and type = 'tour' AND table_id = default_tour.tour_id) DESC";
        } else if ($sort == 4) {
            $order_by = " order by (SELECT AVG(rates) FROM default_reviews WHERE $cond_def and type = 'tour' AND table_id = default_tour.tour_id) ASC";
        }
    }

    if ($rating == 5) {
        $cond .= " AND tour_id IN (SELECT table_id FROM " . DB_PREFIX . "reviews WHERE $cond_def GROUP BY table_id HAVING AVG(rates) = $rating)";
    } elseif ($rating == 2) {
        $cond .= " AND (tour_id NOT IN (SELECT table_id FROM " . DB_PREFIX . "reviews WHERE $cond_def) OR tour_id IN (SELECT table_id FROM " . DB_PREFIX . "reviews WHERE $cond_def GROUP BY table_id HAVING AVG(rates) < $rating))";
    } elseif ($rating > 0) {
        $cond .= " AND tour_id IN (SELECT table_id FROM " . DB_PREFIX . "reviews WHERE $cond_def GROUP BY table_id HAVING AVG(rates) > $rating)";
    }
    // Cho phần search từ trang home
    if ($departure_date) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = DateTime::createFromFormat('d/m/Y H:i:s', "$departure_date 00:00:00");
        $timestamp = $date->getTimestamp();
        $cond .=  " and tour_id NOT IN (select tour_id from " . DB_PREFIX . "tour_start_date where start_date != $timestamp and end_date > $now_day and is_active = 1)";
    }
    // var_dump($cond . $order_by . $limit);
    $listTour = $clsTour->getAll($cond . $order_by . $limit);
    $smarty->assign('listTour', $listTour);
    // var_dump($listTour);

    # Paginate
    $clsPagination = new Pagination();
    $totalRecord = $clsTour->getAll($cond, $clsTour->pkey);

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
    $smarty->assign("totalTour", $totalRecord);
    $totalPage = $clsPagination->getTotalPage();
    $smarty->assign("totalPage", $totalPage);
}
$url = strtok($_SERVER["REQUEST_URI"], '?');
$smarty->assign("reset_filter", $url);
