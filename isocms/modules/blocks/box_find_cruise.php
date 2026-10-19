<?php 
	global $mod,$act,$assign_list, $act,$dbconn,$show,$smarty, $core,$extLang,$_lang,$clsISO,$clsConfiguration,$country_id,$cat_id,$duration,$cabin_range_id,$cruise_price_range_id,$cat_id;

	$clsCruiseCat = new CruiseCat();$assign_list["clsCruiseCat"] = $clsCruiseCat;
	$clsCruiseItinerary = new CruiseItinerary();$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCruisePriceRange = new CruisePriceRange();$assign_list["clsCruisePriceRange"] = $clsCruisePriceRange;

	$lstCruiseCatSearch = $clsCruiseCat->getAll("is_trash=0 AND is_online=1",$clsCruiseCat->pkey.',title'); 
	$smarty->assign("lstCruiseCatSearch",$lstCruiseCatSearch);
	

	if(isset($_POST['filter_cruise']) && $_POST['filter_cruise'] = 'filter_cruise'){
		if(!empty($cat_id)){
			$link = $clsCruiseCat->getLink($cat_id);
		}else{
			$link = $clsISO->getLink('cruise');
		}		
		
		$place = Input::post('place',''); $assign_list['place'] = $place;
		$star_number = Input::post('star',''); $assign_list['star_number'] = $star_number;
		$price_range_ID = Input::post('price_range',''); $assign_list['price_range_ID'] = $price_range_ID;
		$cat_ID = Input::post('cruise_cat_id',''); $assign_list['cat_ID'] = $cat_ID;
		$hasCond = false;
		if($place != '') {
			$link .= ($hasCond?'&':'?').'place='.$clsISO->makeSlashListFromArrayComma($place);
			$hasCond = true;
		}
		if(!empty($star_number)) {
			$link .= ($hasCond?'&':'?').'star_number='.$clsISO->makeSlashListFromArrayComma($star_number);
			$hasCond = true;
		}
		if(!empty($price_range_ID)) {
			$link .= ($hasCond?'&':'?').'price_range_ID='.$clsISO->makeSlashListFromArrayComma($price_range_ID);
			$hasCond = true;
		}
		if(!empty($cat_ID)) {
			$link .= ($hasCond?'&':'?').'cat_ID='.$cat_ID;
			$hasCond = true;
		}
		header('location:'.trim($link));
		exit();
	}else{
		$place = Input::get('place',''); $assign_list['place'] = $place;
		$star_number = Input::get('star_number',''); $assign_list['star_number'] = $star_number;
		$price_range_ID = Input::get('price_range_ID',''); $assign_list['price_range_ID'] = $price_range_ID;
	}
?>