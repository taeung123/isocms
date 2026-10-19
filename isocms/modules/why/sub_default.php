<?php
function default_why(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	#
	$clsWhy = new Why(); $assign_list["clsWhy"] = $clsWhy;
	#
	$lstWhy = $clsWhy->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsWhy->pkey);
	$assign_list["lstWhy"] = $lstWhy;
	unset($lstWhy);
	#
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Why travel with us').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
?>
