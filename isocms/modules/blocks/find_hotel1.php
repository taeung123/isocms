<?php 
	global $mod, $act, $core,$clsISO;
	
	$clsCountry=new Country();$smarty->assign('clsCountry',$clsCountry);
	$clsCity=new City();$smarty->assign('clsCity',$clsCity);
	$clsHotelPriceRange=new HotelPriceRange();$smarty->assign('clsHotelPriceRange',$clsHotelPriceRange);
	#
	$lstPriceRange=$clsHotelPriceRange->getAll("1=1 order by order_no asc");
	$smarty->assign('lstPriceRange',$lstPriceRange);
	
	$departure_in=(isset($_GET['checkin']) && $_GET['checkin']!='')?$_GET['checkin']:'';

	$departure_out=(isset($_GET['checkout']) && $_GET['checkout']!='')?$_GET['checkout']:'';
	
	
	$assign_list['departure_in'] = $departure_in;
	$assign_list['departure_out'] = $departure_out;
	//print_r($departure_out); die();
		
	#
	$checkin_to = date('m/d/Y',strtotime("+ 1 days"));
	$smarty->assign('checkin_to',$checkin_to);
	$checkout_to = date('m/d/Y',strtotime("+ 2 days"));
	$smarty->assign('checkout_to',$checkout_to);
	#
	if(isset($_POST['hid']) && $_POST['hid']=='searchHotel'){
		$link='/tim-kiem-khach-san/';
		foreach($_POST as $key=>$val){
			$link.=($key=='hid')?'':'&'.$key.'='.addslashes($val);
		}
		header('location:'.$link);
	}
	
	unset($clsCountry);unset($clsCity);unset($lstPriceRange);
?>