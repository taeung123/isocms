<?php
global $mod, $act, $smarty, $core, $extLang, $_lang, $clsISO, $duration;
#
$clsTour = new Tour();
$assign_list['clsTour'] = $clsTour;
$clsCategory_Country = new Category_Country();
$assign_list['clsCategory_Country'] = $clsCategory_Country;
$cond = "is_trash=0 and is_online=1";
$LISTALL = $clsTour->getAll($cond);
$TMP = '';
$DURATION_HTML = '<option value="0">' . $core->get_Lang('Tour length') . '</option>';
if (is_array($LISTALL) && count($LISTALL) > 0) {
    for ($i = 0; $i < count($LISTALL); $i++) {
        $TMP .= $clsTour->getSelectTripDuration($LISTALL[$i][$clsTour->pkey]) . '|';
    }
    $TMP = array_unique(explode('|', $TMP));
    if (is_array($TMP) && count($TMP) > 0) {
        sort($TMP, SORT_NUMERIC);
        foreach ($TMP as $key => $val) {
            if ($val != '' && $val != 'n/a') {
                $DURATION_HTML .= '<option value="' . $clsTour->convertDuration($val) . '" ' . (isset($duration) && $duration == $clsTour->convertDuration($val) ? 'selected="selected"' : '') . '>' . $val . '</option>';
            }
        }
    }
    unset($LISTALL);
}

$smarty->assign("DURATION_HTML", $DURATION_HTML);

$link_more = "";
if (isset($_POST['search_tour']) && $_POST['search_tour'] == 'search_tour') {
    $link = $clsISO->getLink('search_tour');
    $str = $_POST["departure_point_id"];
    $parts = explode("-", $str);
    for ($i = 0; $i < count($parts); $i += 2) {
        $_POST[$parts[$i]] = $parts[$i + 1];
    }

    unset($_POST['search_tour']);
    unset($_POST['departure_point_id']);
    $post = $_POST;
    foreach ($post as $key => $item) {
        if (!empty($item)) {
            $link_more .= '&' . $key . '=' . $item;
        }
    }

    if ($link_more != '') {
        $link_more = ltrim($link_more, '&');
        $link .= '?search2024&' . $link_more;
    }

    header('location:' . $link);
    exit();
}

if (isset($_POST['search_cruise']) && $_POST['search_cruise'] == 'search_cruise') {
    $link = $clsISO->getLink('search_cruise');
    unset($_POST['search_cruise']);
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
    $link .= "&search2024";
    header('location:' . $link);
    exit();
}


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
