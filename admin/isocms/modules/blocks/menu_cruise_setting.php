<?php
	global $smarty,$core, $mod, $act, $_LANG_ID,$clsISO;
	$clsProperty= new Property(); $smarty->assign('clsProperty',$clsProperty);
	$clsCruiseProperty= new CruiseProperty(); $smarty->assign('clsCruiseProperty',$clsCruiseProperty);
?>