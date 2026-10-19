<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$about_us_id;
	// End config.
	$clsPage = new Page();
	$assign_list["clsPage"] = $clsPage;
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;
	$clsCity=new City(); $assign_list['clsCity']=$clsCity;

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
function default_default2(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$about_us_id;
	// End config.
	$clsPage = new Page();
	$assign_list["clsPage"] = $clsPage;
	$clsTour=new Tour(); $assign_list['clsTour']=$clsTour;
	$clsCity=new City(); $assign_list['clsCity']=$clsCity;

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
function default_chart_data(){
	global $core;
	$clsISO = new ISO();
	$clsAreaCity = new AreaCity();
	$clsCity = new City();
	
	$arr = array();
	$arr1 = array();
	$result = array();


	$lstCity = $clsCity->getAll("is_trash=0 and is_online=1 limit 0,4");
	if(!empty($lstCity)){
		foreach($lstCity as $city){
			$arr['name'] = $city['title'];
			$arr['data'] = [(int)$city['country_id'], (int)$city['order_no'], (int)$city['city_id']];
			array_push($result, $arr);
		}
	}
	echo json_encode($result); die();
}
?>
