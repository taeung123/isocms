<?php
// modules/blocks/2024_filter_hotel.php

global $mod, $act, $assign_list, $dbconn, $show, $smarty, $core;
global $extLang, $_LANG_ID, $clsISO, $clsConfiguration;
global $cat_id, $country_id;

/* =========================================================
 * Khởi tạo class
 * ========================================================= */
$clsProperty = new Property();
$smarty->assign('clsProperty', $clsProperty);

$clsHotelRoom = new HotelRoom();
$smarty->assign('clsHotelRoom', $clsHotelRoom);

$clsHotel = new Hotel();
$smarty->assign('clsHotel', $clsHotel);

$clsCountry = new Country();
$smarty->assign('clsCountry', $clsCountry);

$clsCity = new City();
$smarty->assign('clsCity', $clsCity);

/* =========================================================
 * Helper chuẩn hóa filter ID
 * Hỗ trợ cả:
 * hotel_star=1,2
 * hotel_star[]=1&hotel_star[]=2
 * ========================================================= */
if (!function_exists('normalizeHotelFilterIds')) {
    function normalizeHotelFilterIds($value): array
    {
        if ($value === null || $value === '' || $value === false) {
            return [];
        }

        if (!is_array($value)) {
            $value = preg_split(
                '/[,\/|]+/',
                (string)$value,
                -1,
                PREG_SPLIT_NO_EMPTY
            );
        }

        $result = [];

        array_walk_recursive($value, static function ($item) use (&$result) {
            if (!is_scalar($item)) {
                return;
            }

            $item = trim((string)$item);

            if ($item === '' || !ctype_digit($item)) {
                return;
            }

            $id = (int)$item;

            if ($id > 0) {
                $result[$id] = $id;
            }
        });

        return array_values($result);
    }
}

/* =========================================================
 * Quốc gia và danh sách thành phố
 * ========================================================= */
$slug_country = isset($_GET['slug_country']) && !is_array($_GET['slug_country'])
    ? trim((string)$_GET['slug_country'])
    : '';

$country_id = 0;
$lstCity = [];

/*
 * QUAN TRỌNG:
 * Phải khai báo $cond trước tất cả các đoạn $cond .= ...
 */
$cond = "is_online=1 AND is_trash=0";

if ($slug_country !== '') {
    $country_id = (int)$clsCountry->getBySlug($slug_country);
}

if ($country_id > 0) {
    $lstCity = $clsCity->getAll(
        "is_trash=0
        AND is_online=1
        AND country_id='{$country_id}'
        AND city_id IN (
            SELECT city_id
            FROM default_hotel
            WHERE is_trash=0
            AND is_online=1
        )",
        $clsCity->pkey . ',title'
    );

    $cond .= " AND country_id='{$country_id}'";
}

if (!is_array($lstCity)) {
    $lstCity = [];
}

$smarty->assign('lstCity', $lstCity);
$smarty->assign('country_id', $country_id);

/* =========================================================
 * Danh sách loại khách sạn
 * ========================================================= */
$condProperty = "is_trash=0";
$orderByProperty = " ORDER BY order_no ASC";

$arr_hotel_types = $clsProperty->getAll(
    "{$condProperty} AND type='TypeHotel' {$orderByProperty}",
    $clsProperty->pkey
);

if (!is_array($arr_hotel_types)) {
    $arr_hotel_types = [];
}

foreach ($arr_hotel_types as $key => $item) {
    $property_id = isset($item['property_id'])
        ? (int)$item['property_id']
        : 0;

    $hotelCount = 0;

    if ($property_id > 0) {
        $countResult = $clsHotel->getAll(
            "is_online=1
            AND is_trash=0
            AND (
                list_TypeHotel='{$property_id}'
                OR list_TypeHotel LIKE '%|{$property_id}|%'
                OR FIND_IN_SET(
                    '{$property_id}',
                    REPLACE(list_TypeHotel, '|', ',')
                )
            )",
            "COUNT(hotel_id) AS count"
        );

        if (
            is_array($countResult)
            && isset($countResult[0]['count'])
        ) {
            $hotelCount = (int)$countResult[0]['count'];
        }
    }

    $arr_hotel_types[$key]['hotel_counts'] = [
        ['count' => $hotelCount]
    ];
}

$smarty->assign('arr_hotel_types', $arr_hotel_types);

/* =========================================================
 * Danh sách tiện nghi
 * ========================================================= */
$arr_hotel_facilities = $clsProperty->getAll(
    "{$condProperty}
    AND type='HotelFacilities'
    AND is_favorite=1
    {$orderByProperty}",
    $clsProperty->pkey
);

if (!is_array($arr_hotel_facilities)) {
    $arr_hotel_facilities = [];
}

$smarty->assign('arr_hotel_facilities', $arr_hotel_facilities);

/* =========================================================
 * Khoảng giá lớn nhất
 * ========================================================= */
$hotel_min_price_value = 0;
$hotel_max_price_value = 0;

$maxPriceResult = $clsHotel->getAll(
    "{$cond}
    ORDER BY max_price DESC
    LIMIT 0,1",
    $clsHotel->pkey . ",
    (
        SELECT MAX(price)
        FROM default_hotel_room
        WHERE is_trash=0
        AND hotel_id=default_hotel.hotel_id
    ) AS max_price"
);

if (
    is_array($maxPriceResult)
    && isset($maxPriceResult[0]['max_price'])
    && is_numeric($maxPriceResult[0]['max_price'])
) {
    $hotel_max_price_value = (int)$maxPriceResult[0]['max_price'];
}

if ($hotel_max_price_value < 0) {
    $hotel_max_price_value = 0;
}

$smarty->assign('hotel_min_price_value', $hotel_min_price_value);
$smarty->assign('hotel_max_price_value', $hotel_max_price_value);

/* =========================================================
 * Giá đang tìm kiếm
 * ========================================================= */
$hotel_min_price_search = isset($_GET['min_price'])
    && !is_array($_GET['min_price'])
    && is_numeric($_GET['min_price'])
        ? max(0, (int)$_GET['min_price'])
        : $hotel_min_price_value;

$hotel_max_price_search = isset($_GET['max_price'])
    && !is_array($_GET['max_price'])
    && is_numeric($_GET['max_price'])
        ? max(0, (int)$_GET['max_price'])
        : $hotel_max_price_value;

if (
    $hotel_max_price_value > 0
    && $hotel_max_price_search > $hotel_max_price_value
) {
    $hotel_max_price_search = $hotel_max_price_value;
}

$smarty->assign('hotel_min_price_search', $hotel_min_price_search);
$smarty->assign('hotel_max_price_search', $hotel_max_price_search);

/* =========================================================
 * Submit form filter
 * ========================================================= */
if (
    isset($_POST['hnv_filter_form_hotel'])
    && $_POST['hnv_filter_form_hotel'] === 'hnv_filter_form_hotel'
) {
    $link = '';

    if ($mod === 'hotel' && $act === 'place2024' && $show === 'Country') {
        if ($_LANG_ID === 'vn') {
            $link = $clsCountry->getLinkDetail(
                $country_id,
                '2024-khach-san'
            );
        } else {
            $link = $clsCountry->getLinkDetail(
                $country_id,
                '2024-hotel'
            );
        }
    }

    if ($link === '') {
        $link = $clsISO->getLink('hotel');
    }

    $hotel_city_ids = normalizeHotelFilterIds(
        $_POST['hotel_city'] ?? []
    );

    $hotel_star_ids = normalizeHotelFilterIds(
        $_POST['hotel_star'] ?? []
    );

    $hotel_type_ids = normalizeHotelFilterIds(
        $_POST['hotel_type'] ?? []
    );

    $hotel_facility_ids = normalizeHotelFilterIds(
        $_POST['hotel_facilities'] ?? []
    );

    $query = [];

    $key = Input::get('key', '');

    if (is_scalar($key) && trim((string)$key) !== '') {
        $query['key'] = trim((string)$key);
    }

    if ($hotel_city_ids) {
        $query['hotel_city'] = implode(',', $hotel_city_ids);
    }

    if ($hotel_star_ids) {
        $query['hotel_star'] = implode(',', $hotel_star_ids);
    }

    if ($hotel_type_ids) {
        $query['hotel_type'] = implode(',', $hotel_type_ids);
    }

    if ($hotel_facility_ids) {
        $query['hotel_facilities'] = implode(',', $hotel_facility_ids);
    }

    if (
        isset($_POST['min_price'])
        && !is_array($_POST['min_price'])
        && is_numeric($_POST['min_price'])
    ) {
        $query['min_price'] = max(0, (int)$_POST['min_price']);
    }

    if (
        isset($_POST['max_price'])
        && !is_array($_POST['max_price'])
        && is_numeric($_POST['max_price'])
    ) {
        $query['max_price'] = max(0, (int)$_POST['max_price']);
    }

    if (
        isset($_POST['hotel_sort'])
        && !is_array($_POST['hotel_sort'])
        && (int)$_POST['hotel_sort'] > 0
    ) {
        $query['hotel_sort'] = (int)$_POST['hotel_sort'];
    }

    $queryString = http_build_query($query);

    if ($queryString !== '') {
        $link .= (
            strpos($link, '?') === false
                ? '?'
                : '&'
        ) . $queryString;
    }

    header('Location: ' . $link);
    exit();
}

/* =========================================================
 * Nhận dữ liệu filter từ URL
 * Gán cho Smarty dưới dạng array để checkInArray hoạt động
 * ========================================================= */
$hotel_star_ids = normalizeHotelFilterIds(
    $_GET['hotel_star'] ?? []
);

$hotel_type_ids = normalizeHotelFilterIds(
    $_GET['hotel_type'] ?? []
);

$hotel_facility_ids = normalizeHotelFilterIds(
    $_GET['hotel_facilities'] ?? []
);

$hotel_city_ids = normalizeHotelFilterIds(
    $_GET['hotel_city'] ?? []
);

$smarty->assign('hotel_star', $hotel_star_ids);
$smarty->assign('hotel_type', $hotel_type_ids);
$smarty->assign('hotel_facilities', $hotel_facility_ids);
$smarty->assign('hotel_city', $hotel_city_ids);

$min_price = isset($_GET['min_price'])
    && !is_array($_GET['min_price'])
    && is_numeric($_GET['min_price'])
        ? max(0, (int)$_GET['min_price'])
        : 0;

$max_price = isset($_GET['max_price'])
    && !is_array($_GET['max_price'])
    && is_numeric($_GET['max_price'])
        ? max(0, (int)$_GET['max_price'])
        : 0;

$smarty->assign('min_price', $min_price);
$smarty->assign('max_price', $max_price);

$key = Input::get('key', '');

if (!is_scalar($key)) {
    $key = '';
}

$smarty->assign('key', trim((string)$key));
?>
