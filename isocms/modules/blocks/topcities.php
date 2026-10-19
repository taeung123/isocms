<?php 
	global $core, $smarty;
	#
	$clsCity = new City();$smarty->assign('clsCity', $clsCity);
	$clsCountryEx = new Country();$smarty->assign('clsCountryEx', $clsCountryEx);
	#
	$cond = "is_trash=0 and is_online=1";
	if(isset($_GET['slug_country']) && !empty($_GET['slug_country'])) {
		$slug_country = $_GET['slug_country'];
		$country_id = $clsCountryEx->getBySlug($slug_country);
		$cond.= " and country_id = '$country_id'";
	}
	$cond.= " and city_id IN (SELECT city_id FROM ".DB_PREFIX."citystore WHERE type='TOP' order by order_no desc)";
	$cond.= " limit 0,10";
	$lstCityTop = $clsCity->getAll($cond, $clsCity->pkey);
	$smarty->assign('lstCityTop', $lstCityTop); unset($lstCityTop);
?>