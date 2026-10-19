<?php

/**
 *  Defautl action
 *  @author		: Technical Group (technical@aboutpro.com)
  @modifier    : Luong Tien Dung (info@vietiso.com)
 *  @date		: 2009/10/01
  @date-modify : 2009/01/06
 *  @version		: 3.0.0
 */
function default_place() {
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$country_id,$city_id;
	global $clsISO;
    #
	$clsCountryEx=new Country(); $assign_list["clsCountryEx"] = $clsCountryEx;
	$clsVideo=new Video();$assign_list['clsVideo']=$clsVideo;
	
    #
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list['show'] = $show;

	$slug_country = isset($_GET['slug_country'])?$_GET['slug_country']:'';
	$res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1",$clsCountryEx->pkey);
	$country_id = $res[0][$clsCountryEx->pkey];
	if(intval($country_id)==0) {
		header('Location:'.PCMS_URL.$extLang);
		exit();
	}
	$assign_list['country_id'] = $country_id;
	$cond="is_trash=0 and is_online=1 and country_id='$country_id'";
	#
	$lstVideoClip = $clsVideo->getAll($cond." order by order_no ASC limit 0,6",$clsVideo->pkey.',title');
	$assign_list['lstVideoClip'] = $lstVideoClip; 
	unset($lstVideoClip);
	
	$totalVideo=$clsVideo->getAll($cond)?count($clsVideo->getAll($cond)):0;
	$assign_list['totalVideo']=$totalVideo;
	
	
    /* =============Title & Description Page================== */
    $title_page = $core->get_Lang('Videos in').' '.$title_page.' | '.PAGE_NAME;
    $assign_list["title_page"] = $title_page;
	$description_page =$title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_ajLoadMoreVideo(){
	global $smarty, $assign_list, $_CONFIG,$core, $dbconn, $mod, $act, $_LANG_ID,
	$title_page, $description_page, $keyword_page,$clsISO;
	
	#
	$clsVideo = new Video(); $assign_list['clsVideo']=$clsVideo;

	$numberPage = isset( $_POST['page'] )? $_POST['page']:1;
	$country_id = isset( $_POST['country_id'] )? $_POST['country_id']:'0';
	
	$itemOnPage = 6;
	$limit = " limit ".(($numberPage-1)*$itemOnPage).",".($itemOnPage);
	$sql = "is_trash=0 and is_online=1 and country_id='$country_id'";
	$lstVideoClip = $clsVideo->getAll($sql." order by order_no ASC".$limit,$clsVideo->pkey);
	$assign_list["lstVideoClip"] = $lstVideoClip; 
	#
	$html = $core->build('loadMoreVideoClip.tpl');
	echo $html; die;
} 
?>
