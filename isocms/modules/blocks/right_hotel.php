<?php 
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$city_id;
	global $clsISO;
#area_city
	$clsAreaCity = new AreaCity(); 
	$smarty->assign('clsAreaCity',$clsAreaCity);
	$lstCityAreaHotel=$clsAreaCity->getAll("is_trash=0 and is_online=1 and city_id='$city_id'");
	$smarty->assign('lstCityAreaHotel',$lstCityAreaHotel);
	//print_r($city_id); die();
	unset($lstCityAreaHotel);
	
	#price_range
	/*$clsPriceRange = new PriceRange(); 
	$smarty->assign('clsPriceRange',$clsPriceRange);
	$lstPriceRangeSearch=$clsPriceRange->getAll("is_trash=0 order by order_no");
	$smarty->assign('lstPriceRangeSearch',$lstPriceRangeSearch);
	unset($lstPriceRangeSearch);*/
	
	$clsHotelPriceRange = new HotelPriceRange(); 
	$smarty->assign('clsHotelPriceRange',$clsHotelPriceRange);
	$lstPriceRangeSearch=$clsHotelPriceRange->getAll("is_trash=0 order by order_no");
	$smarty->assign('lstPriceRangeSearch',$lstPriceRangeSearch);
	unset($lstPriceRangeSearch);
	
	#star
	$star=array();
	for($i=1;$i<6;$i++){
		if($i<6){
			$star[]=$i;
		}
	}
	$smarty->assign('star',$star);
	
	#hotel_pacility
	$clsProperty = new Property(); 
	$smarty->assign('clsProperty',$clsProperty);
	$listHotelFacility = $clsProperty->getAll("is_trash=0 and type='HotelFacilities'");
	$smarty->assign('listHotelFacility',$listHotelFacility);
	unset($listHotelFacility);
?>