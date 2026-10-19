<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$about_us_id;
	// End config.
	$clsPage = new Page();
	$assign_list["clsPage"] = $clsPage;
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;

    $number = isset($_GET['number'])? $_GET['number']:'';
    $assign_list["number"] = $number;
    /*=============Title & Description Page==================*/
	$title_page = $clsPage->getTitle($page_id).' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsPage->getTitle($page_id).' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $clsPage->getTitle($page_id).' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsPage);
}
?>
