<?php 
	global $mod,$act,$smarty,$core,$extLang,$clsISO,$package_id;
	
	$clsCountry=new Country();$smarty->assign('clsCountry',$clsCountry);
	$clsCity=new City();$smarty->assign('clsCity',$clsCity);
	if($clsISO->getCheckActiveModulePackage($package_id,'hotel','price_range','default')){
		$clsHotelPriceRange=new HotelPriceRange();$smarty->assign('clsHotelPriceRange',$clsHotelPriceRange);
		$lstPriceRange=$clsHotelPriceRange->getAll("1=1 and is_trash=0 order by order_no asc",$clsHotelPriceRange->pkey.',title');
		$smarty->assign('lstPriceRange',$lstPriceRange);
	}
	#
	if(isset($_POST['hid']) && $_POST['hid']=='searchHotel'){
		$link=$clsISO->getLink('search_hotel');
		foreach($_POST as $key=>$val){
			$link.=($key=='hid')?'':'&'.$key.'='.addslashes($val);
		}
		header('location:'.$link);
	}
	
	unset($clsCountry);unset($clsCity);unset($lstPriceRange);
?>