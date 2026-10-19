<?php

global $mod, $act, $smarty, $core, $extLang, $clsISO, $package_id, $show, $_LANG_ID, $clsCountryEx;


$clsCountry = new Country();
$smarty->assign('clsCountry', $clsCountry);

$clsCity = new City();
$smarty->assign('clsCity', $clsCity);

$format_time_now = date('d/m/Y');
$smarty->assign('format_time_now', $format_time_now);
$format_time_tomorrow = date('d/m/Y', strtotime("+1 day"));
$smarty->assign('format_time_tomorrow', $format_time_tomorrow);
if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'price_range', 'default')) {
    $clsHotelPriceRange = new HotelPriceRange();
    $smarty->assign('clsHotelPriceRange', $clsHotelPriceRange);
    $lstPriceRange = $clsHotelPriceRange->getAll("1=1 and is_trash=0 order by order_no asc", $clsHotelPriceRange->pkey . ',title');
    $smarty->assign('lstPriceRange', $lstPriceRange);
}
#
$slug_country = Input::get('slug_country', '');
$res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1", $clsCountryEx->pkey);
$country_id = $res[0][$clsCountryEx->pkey];

if (isset($_POST['hid']) && $_POST['hid'] == 'searchHotel') {
    if ($mod == 'hotel' && $act == 'place') {
        if ($show == 'Country') {
            if ($_LANG_ID == 'vn') {
                global $clsCountryEx;
                $link = $clsCountryEx->getLinkDetail($country_id, 'khach-san');
            } else {
                $link = $clsCountryEx->getLinkDetail($country_id, 'hotel');
            }
        }
    } else {
        $link = $clsISO->getLink('hotel');
    }

    vnSessionDelVar('ContactHotel');
    vnSessionDelVar('hotels');
    $cartSessionHotel = array();
    foreach ($_POST as $k => $v) {
        $cartSessionHotel[$k] = $v;
    }
    vnSessionSetVar('hotels', $cartSessionHotel);
    $check_first = 1;
    foreach ($_POST as $key => $val) {
        if ($key != 'hid') {
            if ($key == 'key') {
                $link .= (($check_first == 1) ? '?' : '&') . $key . '=' . str_replace(" ", "+", addslashes($val));
            } else {
                $link .= (($check_first == 1) ? '?' : '&') . $key . '=' . addslashes($val);
            }

            $check_first = 0;
        }

    }
//	echo $link;die;
    header('location:' . $link);
}
unset($clsCountry);
unset($clsCity);
unset($lstPriceRange);
?>