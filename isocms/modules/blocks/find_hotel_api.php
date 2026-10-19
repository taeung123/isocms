<?php
	global $mod, $act, $core,$extLang,$clsISO;

	$clsCountry=new Country();$smarty->assign('clsCountry',$clsCountry);
	$clsCity=new City();$smarty->assign('clsCity',$clsCity);
	$clsHotel=new Hotel();$smarty->assign('clsHotel',$clsHotel);
	
	#

	if(isset($_POST['hid_search']) && $_POST['hid_search']=='Search_Hotel_API'){
		$link=$extLang.'/combo/search?t='.time();
		foreach($_POST as $key=>$val){
			$link.=($key=='hid')?'':'&'.$key.'='.addslashes($val);
			$VALUE_HOTEL_SEARCH[$key] = $val;
		}
		vnSessionSetVar('VALUE_HOTEL_SEARCH',$VALUE_HOTEL_SEARCH);
		header('location:'.$link);
	}
	
	unset($clsHotel);unset($clsCity);
?>