<?php
if ($_SERVER['REMOTE_ADDR'] == '124.158.4.43') {
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
}

global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $package_id, $smarty;
global $clsConfiguration, $lang_sql;

$clsTourStore = new TourStore();
$smarty->assign('clsTourStore', $clsTourStore);

$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);

$clsReviews = new Reviews();
$smarty->assign('clsReviews', $clsReviews);
if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'store', 'store', 'VE9QVE9VUi1WaWV0SVNP')) {
    $sql_travel_favorite_choice = "SELECT 
        t.tour_id,
        t.title,
        t.slug,
        t.image,
        t.duration_type,
        t.duration_custom,
        t.number_day,
        t.number_night,
        t.dra_hours,
        t.dra_min,
        t.list_departure_point_id,

        -- TRUNG BÌNH ĐÁNH GIÁ
        AVG(r.rates) AS avg_rates,

        -- TỔNG SỐ ĐÁNH GIÁ
        COUNT(r.reviews_id) AS total_reviews

    FROM default_tour AS t
    INNER JOIN default_tour_store AS ts 
            ON t.tour_id = ts.tour_id
    LEFT JOIN default_reviews AS r 
            ON r.table_id = t.tour_id 
        AND r.type = 'tour'
        AND r.is_online = 1
        AND r.is_trash = 0

    WHERE ts.is_trash = 0
    AND ts._type = 'TOPTOUR'
    AND t.lang_id = '$lang_sql'
    AND t.is_trash = 0
    AND t.is_online = 1
    AND t.parent_id = 0

    GROUP BY t.tour_id
    ORDER BY t.order_no DESC
    LIMIT 6;
    ";

    $listTopTour = $dbconn->getAll($sql_travel_favorite_choice);
} else {
    //$listTopTour = $clsTour->getAll("is_trash=0 AND is_online=1 ORDER BY order_no DESC LIMIT 6", "tour_id,title,slug,image,duration_type,duration_custom,number_day,number_night,dra_hours,dra_min,list_departure_point_id");
	$sql_travel_favorite_choice = "SELECT 
        t.tour_id,
        t.title,
        t.slug,
        t.image,
        t.duration_type,
        t.duration_custom,
        t.number_day,
        t.number_night,
        t.dra_hours,
        t.dra_min,
        t.list_departure_point_id,

        -- TRUNG BÌNH ĐÁNH GIÁ
        AVG(r.rates) AS avg_rates,

        -- TỔNG SỐ ĐÁNH GIÁ
        COUNT(r.reviews_id) AS total_reviews

    FROM default_tour AS t
    LEFT JOIN default_reviews AS r 
            ON r.table_id = t.tour_id 
        AND r.type = 'tour'
        AND r.is_online = 1
        AND r.is_trash = 0

    WHERE t.lang_id = '$lang_sql'
    AND t.is_trash = 0
    AND t.is_online = 1
    AND t.parent_id = 0

    GROUP BY t.tour_id
    ORDER BY t.order_no DESC
    LIMIT 6;
    ";

    $listTopTour = $dbconn->getAll($sql_travel_favorite_choice);
}

if (!empty($listTopTour)) {
    foreach ($listTopTour as $key => $tour) {
        $avg_rates = (float) $tour['avg_rates'] ?? 0;
        $avg_rates =  round($avg_rates, 1);
        $rate_star = ($avg_rates / 5) * 100;
        $listTopTour[$key]['avg_rates'] =  $avg_rates;
        $listTopTour[$key]['rate_star'] =  $rate_star;
    }
}

$smarty->assign('listTopTour', $listTopTour);
unset($listTopTour);
