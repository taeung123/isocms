<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	
	#
	$clsFAQ = new FAQ();$assign_list["clsFAQ"] = $clsFAQ;
	$clsFAQCategory = new FAQCategory(); $assign_list["clsFAQCategory"] = $clsFAQCategory;
	#
	$lstFAQCat = $clsFAQCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsFAQCategory->pkey.',title');
	$assign_list["lstFAQCat"] = $lstFAQCat;
	unset($lstFAQCat);
	#
	$listFAQs = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsFAQ->pkey.',title,content');
	$assign_list["listFAQs"] = $listFAQs; unset($listFAQs);
	
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('faqs').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
?>
