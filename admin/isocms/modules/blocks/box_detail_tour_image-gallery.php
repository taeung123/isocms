<?php 
	global $smarty,$core;
	
	global $smarty;
	
	$clsTour=new Tour();$smarty->assign('clsTour',$clsTour);
	$smarty->assign('_isoman_use',_isoman_use);
?>