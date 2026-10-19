<?php 
	global $smarty,$core;
	
	global $smarty;
	
	$clsVoucher=new Voucher();$smarty->assign('clsVoucher',$clsVoucher);
	$voucher_id = isset($_GET['voucher_id']) ? ($_GET['voucher_id']) : '';
    $voucher_id = intval($core->decryptID($voucher_id));
	$map_zoom=$clsVoucher->getOneField('map_zoom',$voucher_id);
	$smarty->assign('map_zoom',$map_zoom);
	$ret = $clsVoucher->getLocationMap($voucher_id);
	$map_la = $ret['map_la']?$ret['map_la']:'20.9954822';
	$map_lo = $ret['map_lo']?$ret['map_lo']:'105.86207179999997';
	$script_location = $ret['jscode'];
	$smarty->assign('map_la',$map_la);
	$smarty->assign('map_lo',$map_lo);
	$smarty->assign('script_location',$script_location);
?>