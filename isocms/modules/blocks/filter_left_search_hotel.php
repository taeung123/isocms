<?php

global $mod,$act,$assign_list, $act,$dbconn,$show,$smarty, $core,$extLang,$clsISO,$clsConfiguration,$clsCountryEx,$_LANG_ID;

$clsProperty = new Property();$smarty->assign('clsProperty',$clsProperty);
$clsCity = new City();$smarty->assign('clsCity',$clsCity);
$listTypeHotel = $clsProperty->getAll("is_trash=0 and type='TypeHotel' order by order_no asc",$clsProperty->pkey.",title");
$smarty->assign('listTypeHotel',$listTypeHotel);

$slug_country=Input::get('slug_country','');
$res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1",$clsCountryEx->pkey);
$country_id = $res[0][$clsCountryEx->pkey];
if($country_id){
	$lstCity = $clsCity->getAll("is_trash=0 AND is_online=1 and country_id='".$country_id."' and city_id IN (SELECT city_id FROM default_hotel WHERE is_trash=0 AND is_online=1)",$clsCity->pkey.',title');
	$smarty->assign('lstCity',$lstCity);
}

$clsHotelPriceRange=new HotelPriceRange();$smarty->assign('clsHotelPriceRange',$clsHotelPriceRange);
#
$lstPriceRange=$clsHotelPriceRange->getAll("1=1 order by order_no asc",$clsHotelPriceRange->pkey.',title');
$smarty->assign('lstPriceRange',$lstPriceRange);
	

if(isset($_POST['search_hotel_left']) &&  $_POST['search_hotel_left']=='search_hotel_left'){
    if($mod=='hotel' && $act=='place'){
        if($show =='Country'){
            if($_LANG_ID=='vn'){
                global $clsCountryEx;
                $link = $clsCountryEx->getLinkDetail($country_id,'khach-san');
            }else{
                $link = $clsCountryEx->getLinkDetail($country_id,'hotel');
            }
        }	
    }else{
		$link = $clsISO->getLink('hotel');
	}

    $city = isset($_POST['city']) ? $_POST['city'] : null;
    $price_range = isset($_POST['price_range']) ? $_POST['price_range'] : null;
    $star_id = isset($_POST['star_id']) ? $_POST['star_id'] : null;
    $type_hotel = isset($_POST['type_hotel']) ? $_POST['type_hotel'] : null;
	
	$key = Input::get('key','');
	$check_in_date = Input::get('check_in_date','');
	$check_out_date = Input::get('check_out_date','');
	$number_adults = Input::get('number_adults','');
	$number_child = Input::get('number_child','');
	

    $hasCond = false;
    if(!empty($key)) {
        $link .= ($hasCond?'&':'?').'key='.str_replace(" ","+",$key);
        $hasCond = true;
    }
    if(!empty($check_in_date)) {
        $link .= ($hasCond?'&':'?').'check_in_date='.$check_in_date;
        $hasCond = true;
    }
    if(!empty($check_out_date)) {
        $link .= ($hasCond?'&':'?').'check_out_date='.$check_out_date;
        $hasCond = true;
    }
    if(!empty($number_adults)) {
        $link .= ($hasCond?'&':'?').'number_adults='.$number_adults;
        $hasCond = true;
    }
    if(!empty($number_child)) {
        $link .= ($hasCond?'&':'?').'number_child='.$number_child;
        $hasCond = true;
    }
	
    if(!empty($city)) {
        $link .= ($hasCond?'&':'?').'city='.$clsISO->makeSlashListFromArrayComma($city);
        $hasCond = true;
    }
    if(!empty($price_range)) {
        $link .= ($hasCond?'&':'?').'price_range='.$clsISO->makeSlashListFromArrayComma($price_range);
        $hasCond = true;
    }
    if(!empty($star_id)) {
        $link .= ($hasCond?'&':'?').'star_id='.$clsISO->makeSlashListFromArrayComma($star_id);
        $hasCond = true;
    }

    if(!empty($type_hotel)) {
        $link .= ($hasCond?'&':'?').'type_hotel='.$clsISO->makeSlashListFromArrayComma($type_hotel);
        $hasCond = true;
    }

    header('location:'.trim($link));
    exit();
} else {
    $star_id = isset($_GET['star_id']) ? $_GET['star_id'] : array();
    $smarty->assign('star_id', !empty($star_id) ? @explode(',', $star_id) : array());
    $type_hotel = isset($_GET['type_hotel']) ? $_GET['type_hotel'] : array();	
    $smarty->assign('type_hotel', !empty($type_hotel) ? @explode(',', $type_hotel) : array());
    $price_range = isset($_GET['price_range']) ? $_GET['price_range'] : array();
    $smarty->assign('price_range', !empty($price_range) ? @explode(',', $price_range) : array());
    $city = isset($_GET['city']) ? $_GET['city'] : array();
    $smarty->assign('city', !empty($city) ? @explode(',', $city) : array());
	$key = Input::get('key','');
    $smarty->assign('key', $key);
	$check_in_date = Input::get('check_in_date','');
	$smarty->assign('check_in_date', $check_in_date);
	$check_out_date = Input::get('check_out_date','');
	$smarty->assign('check_out_date', $check_out_date);
	$number_adults = Input::get('number_adults','');
	$smarty->assign('number_adults', $number_adults);
	$number_child = Input::get('number_child','');
	$smarty->assign('number_child', $number_child);
}
?>