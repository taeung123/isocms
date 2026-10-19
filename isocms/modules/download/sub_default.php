<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$_lang;
	
	#
	$clsDownload=new Download();
	$assign_list["clsDownload"] = $clsDownload;

	$listDownload=$clsDownload->getAll("is_trash=0 and is_online=1 and attachment_file<>'' order by order_no asc",$clsDownload->pkey.",attachment_file,title,intro");
	$assign_list["listDownload"] = $listDownload;
	 unset($listDownload);
	 
    /*=============Title & Description Page==================*/
	$title_page =$core->get_Lang('Trade Brochures').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
?>
