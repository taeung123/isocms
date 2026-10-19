<?php 
	global $mod, $act, $core,$extLang;
	
	$clsCountry=new Country();$smarty->assign('clsCountry',$clsCountry);
	$clsCity=new City();$smarty->assign('clsCity',$clsCity);
	$clsHotelPriceRange=new HotelPriceRange();$smarty->assign('clsHotelPriceRange',$clsHotelPriceRange);
	#
	$lstPriceRange=$clsHotelPriceRange->getAll("1=1 order by order_no asc");
	$smarty->assign('lstPriceRange',$lstPriceRange);
	#
	if(isset($_POST['hid']) && $_POST['hid']=='searchHotel'){
		$link=$extLang.'/search-hotels/';
		foreach($_POST as $key=>$val){
			$link.=($key=='hid')?'':'&'.$key.'='.addslashes($val);
		}
		header('location:'.$link);
	}
	
	unset($clsCountry);unset($clsCity);unset($lstPriceRange);
?>