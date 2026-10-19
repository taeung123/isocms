<?php 
	global $smarty, $_LANG_ID, $mod, $act;
	
	$clsOnlineSupport = new OnlineSupport();
	$smarty->assign("clsOnlineSupport",$clsOnlineSupport);
	
	$listYahoo = $clsOnlineSupport->getAll("is_trash=0 and is_online=1 and type='_YAHOO' order by order_no ASC");
	$smarty->assign("listYahoo",$listYahoo);
	$lstSkype = $clsOnlineSupport->getAll("is_trash=0 and is_online=1 and type='_SKYPER' order by order_no ASC");
	$smarty->assign("lstSkype",$lstSkype);
	$lstPhone = $clsOnlineSupport->getAll("is_trash=0 and is_online=1 and type='_PHONE' order by order_no ASC");
	$smarty->assign("lstPhone",$lstPhone);
?>