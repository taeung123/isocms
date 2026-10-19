<?php 
	global $mod, $act, $core, $extLang,$hotel_id,$clsISO;
	#
	$clsCity=new City();$smarty->assign('clsCity',$clsCity);
	$clsHotel=new Hotel();$smarty->assign('clsHotel',$clsHotel);
	$clsHotelRoom=new HotelRoom();$smarty->assign('clsHotelRoom',$clsHotelRoom);
	#
	
	$max_adult=$clsHotel->getMaxAdult($hotel_id);
	$smarty->assign('max_adult',$max_adult);
	$smarty->assign('hotel_id',$hotel_id);

	$max_child=$clsHotel->getMaxChild($hotel_id);
	$smarty->assign('max_child',$max_child);
	#
	
?>