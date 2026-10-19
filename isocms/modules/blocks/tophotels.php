<?php 
	global $core, $smarty;
	#
	$clsHotel = new Hotel(); $smarty->assign('clsHotel',$clsHotel);
	$lstHotelTop = $clsHotel->getAll("is_trash=0 and is_online=1 and hotel_id IN (SELECT hotel_id FROM default_hoteltop order by order_no desc) limit 0,4",$clsHotel->pkey.',star_id');
	$smarty->assign('lstHotelTop',$lstHotelTop); unset($lstHotelTop);
?>