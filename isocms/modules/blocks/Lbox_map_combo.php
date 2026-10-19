<?php 
	global $smarty,$combo_id;
	$clsCombo=new Combo();$smarty->assign('clsCombo',$clsCombo);

	$ret = $clsCombo->getLocationMap($combo_id);
	$map_la = $ret['map_la'];
	$map_lo = $ret['map_lo'];
	$script_location = $ret['jscode'];
	$smarty->assign('map_la',$map_la);
	$smarty->assign('map_lo',$map_lo);
	$smarty->assign('script_location',$script_location);

?>