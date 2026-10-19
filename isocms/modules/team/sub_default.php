<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$title_page,$description_page,$keyword_page,$oneCommon;
	global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;
	#
	$clsTeam = new Team();
	$assign_list['clsTeam'] = $clsTeam;
	#
	$listTeam = $clsTeam->getAll("is_trash=0 and is_online=1 and languages='$_LANG_ID' order by order_no asc",$clsTeam->pkey);
	$assign_list['listTeam'] = $listTeam;
	unset($listTeam);
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Our Team').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*========================================================*/
	unset($clsFeedback); unset($clsISO);
}
?>
