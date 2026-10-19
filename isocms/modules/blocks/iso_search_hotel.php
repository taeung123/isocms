<?php
global $clsISO, $core, $smarty, $mod, $act;
$txt_search_hotel_dates = !empty(vnSessionGetVar("iso_search_hotel_dates")) ? vnSessionGetVar("iso_search_hotel_dates") : '';
$txt_search_hotel_number_rooms = !empty(vnSessionGetVar("iso_search_hotel_number_rooms")) ? vnSessionGetVar("iso_search_hotel_number_rooms") : 1;
$txt_search_hotel_number_adults = !empty(vnSessionGetVar("iso_search_hotel_number_adults")) ? vnSessionGetVar("iso_search_hotel_number_adults") : 1;
$txt_search_hotel_number_child = !empty(vnSessionGetVar("iso_search_hotel_number_child")) ? vnSessionGetVar("iso_search_hotel_number_child") : 0;

vnSessionSetVar("iso_search_hotel_dates", $txt_search_hotel_dates);
vnSessionSetVar("iso_search_hotel_number_rooms", $txt_search_hotel_number_rooms);
vnSessionSetVar("iso_search_hotel_number_adults", $txt_search_hotel_number_adults);
vnSessionSetVar("iso_search_hotel_number_child", $txt_search_hotel_number_child);

$smarty->assign('txt_search_hotel_dates', $txt_search_hotel_dates);
$smarty->assign('txt_search_hotel_number_rooms', $txt_search_hotel_number_rooms);
$smarty->assign('txt_search_hotel_number_adults', $txt_search_hotel_number_adults);
$smarty->assign('txt_search_hotel_number_child', $txt_search_hotel_number_child);

if (isset($_POST['search_hotel']) && $_POST['search_hotel'] == 'search_hotel') {
    unset($_POST['search_hotel']);
    $link = $clsISO->getLink('search_hotel');

    $search_hotel_dates = $_POST['search_hotel_dates'];
    unset($_POST['search_hotel_dates']);
    $search_hotel_number_rooms = $_POST['number_rooms'];
    $search_hotel_number_adults = $_POST['number_adults'];
    $search_hotel_number_child = $_POST['number_child'];
    unset($_POST['number_rooms']);
    unset($_POST['number_adults']);
    unset($_POST['number_child']);
    vnSessionSetVar("iso_search_hotel_dates", $search_hotel_dates);
    vnSessionSetVar("iso_search_hotel_number_rooms", $search_hotel_number_rooms);
    vnSessionSetVar("iso_search_hotel_number_adults", $search_hotel_number_adults);
    vnSessionSetVar("iso_search_hotel_number_child", $search_hotel_number_child);
    if ($act != 'detail' && $act != 'hnv_detail2024') {
        $post = $_POST;
        foreach ($post as $key => $item) {
            if (!empty($item)) {
                $link_more .= '&' . $key . '=' . $item;
            }
        }

        if ($link_more != '') {
            $link_more = ltrim($link_more, '&');
            $link .= '?' . $link_more;
        }

        header('location:' . $link);
        exit();
    }
}
