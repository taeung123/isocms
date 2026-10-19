<?php 
	global $smarty;
	
	$clsCountry = new Country();$smarty->assign('clsCountry',$clsCountry);
	$smarty->assign('lstCountry',$clsCountry->getAll("is_trash=0 order by order_no asc"));
	$slug_country = $_GET['slug_country'];
	if(!empty($slug_country)) {
		$country_id = $clsCountry->getBySlug($slug_country);
		$smarty->assign('country_id',$country_id);
	}
	
	$clsCity = new City();$smarty->assign('clsCity',$clsCity);
	$slug_city=$_GET['slug_city'];
	$all = $clsCity->getAll("is_trash=0 and is_online=1 and slug='$slug_city' LIMIT 0,1");
	$city_id = $all[0][$clsCity->pkey];
?>