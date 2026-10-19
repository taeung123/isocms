<?php 
	global $core, $smarty, $combo_id,$deviceType,$clsISO,$package_id;
	
	$clsCombo=new Combo(); $smarty->assign('clsCombo',$clsCombo);

	$list_combo_related_id=$clsCombo->getOneField('list_combo_related',$combo_id);

	$list_combo_related_id = !empty($list_combo_related_id) ? @json_decode($list_combo_related_id, true) : array();

	$smarty->assign('list_combo_related',$list_combo_related_id);
?>