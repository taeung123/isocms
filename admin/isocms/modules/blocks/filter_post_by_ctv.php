<?php
	global $smarty,$assign_list,$core, $mod, $act, $_LANG_ID,$clsISO;
	$clsUser = new User();
	$smarty->assign('clsUser', $clsUser);
	$listCTV=$clsUser->getAll("is_trash=0 and is_active=1 and user_group_id=5 order by user_id ASC");
	$smarty->assign('listCTV', $listCTV);
?>