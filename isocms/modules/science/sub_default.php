<?php
function default_default(){
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO,$clsConfiguration,$extLang;
	#
	$clsScienceCategory  = new ScienceCategory ();$assign_list["clsScienceCategory"] = $clsScienceCategory;
	$clsScience = new Science();$assign_list["clsScience"] = $clsScience;
	$clsPagination = new Pagination();$assign_list["clsPagination"] = $clsPagination;
	
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;
	
	$sciencecat_id = 0;
	if($show=='cat'){
		$slug = $_GET['slug'];
		$res = $clsScienceCategory->getAll("is_trash=0 and is_online=1 and slug='$slug' LIMIT 0,1",$clsScienceCategory->pkey);
		$sciencecat_id = $res[0][$clsScienceCategory->pkey];
	}
	$assign_list["sciencecat_id"] = $sciencecat_id;
	
	
	$recordPerPage =7;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	
	$page_Seo = isset($_GET['page'])?intval($_GET['page']):'';
	$assign_list['page_Seo']=$page_Seo;
	
	$cond ="is_trash=0 and is_online=1";
	if(intval($sciencecat_id) > 0){
		$cond .= " and (sciencecat_id='$sciencecat_id' or list_cat_id like '%|$sciencecat_id|%')";
	}
	$totalRecord 	=$clsScience->getAll($cond)?count($clsScience->getAll($cond)):0;		
	#
	
	if( $sciencecat_id > 0){
		$link_page = $slug;
	}
	else{
		$link_page = $clsISO->getLink('science');
	}
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links_science(false);
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	
	#
	
	$order_by =" order by order_no asc";
	
	$lstScience = $clsScience->getAll($cond.$order_by.$limit, $clsScience->pkey.',reg_date,sciencecat_id'); 
	$assign_list['lstScience']=$lstScience;
		
	
	$totalPage = $clsPagination->getTotalPage();
	#
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;
	
	/*=============Title & Description Page==================*/
	if($show=='cat'){
		$title_page = $clsScienceCategory->getTitle($sciencecat_id).' | '. $core->get_Lang('travelscience').' | '.PAGE_NAME;
	}else{
		$title_page = $core->get_Lang('travelscience').' | '.PAGE_NAME;
	}
	$title_page = $title_page;
	$assign_list["title_page"] = $title_page;
	if($show=='cat'){
		$description_page = $clsISO->getMetaDescription($sciencecat_id,'ScienceCategory');
	}else{
		$description_page =$clsConfiguration->getValue('site_science_intro_'.$_LANG_ID);
	}
	
	$assign_list["description_page"] = $description_page;
}
function default_detail(){	
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$clsConfiguration;
	global $extLang,$clsISO;
	#
	$clsScienceCategory  = new ScienceCategory ();$assign_list["clsScienceCategory"] = $clsScienceCategory;
	$clsScience = new Science();$assign_list["clsScience"] = $clsScience;
	
	$seo = isset($_GET['seo']) ? $_GET['seo'] : '';
	
	$science_id = isset($_GET['science_id']) ? intval($_GET['science_id']) : 0;
	if(empty($clsScience->checkOnline($science_id))){
		header('Location:/404/');
		exit();
	}
	if($science_id==0){
		header('Location:/404/');
		exit();
	}
	$assign_list["science_id"] = $science_id;
	$assign_list["seo"] = $seo;
	
	#
	$sciencecat_id = $clsScience->getOneField('sciencecat_id',$science_id);
	$assign_list["sciencecat_id"] = $sciencecat_id;

	$lstRelated = $clsScience->getAll("is_trash=0 and is_online=1 and science_id<>'$science_id' order by order_no limit 0,10",$clsScience->pkey);
	$assign_list["lstRelated"] = $lstRelated;
	
	/*=============Title & Description Page==================*/
	$title_page = $clsScience->getTitle($science_id).' | '.$core->get_Lang('travelscience').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsISO->getMetaDescription($science_id,'Science');
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsISO->getPageImageShare($science_id,'Science');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}

function default_load_more_detail(){
	global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	$clsScienceCategory  = new ScienceCategory ();
	$assign_list['clsScienceCategory'] = $clsScienceCategory;
	$clsScience = new Science();
	$assign_list['clsScience'] = $clsScience;
	
	$html = '_empty';
	$order_no = $_POST['order_no'];
	$sciencecat_id = intval($_POST['sciencecat_id']);
	$assign_list['sciencecat_id'] = $sciencecat_id;
	$oneTableCat = $clsScienceCategory->getOne($sciencecat_id);
	$assign_list["oneTableCat"] = $oneTableCat;
	
	$sql = "is_trash=0 and is_online=1 and (cat_id='$sciencecat_id' or list_cat_id like '%|$sciencecat_id|%')";
	$lstAll = $clsScience->getAll($sql.=" and order_no >'$order_no' order by order_no ASC limit 0,1",$clsScience->pkey.",cat_id");
	
	if(!empty($lstAll)){
		$science_id = $lstAll[0][$clsScience->pkey];
		$url=$clsScience->getLink($science_id);
		$cat_id = $lstAll[0]['cat_id'];
		$oneTable = $clsScience->getOne($science_id);
		
		$assign_list['science_id'] = $science_id;
		$assign_list['url'] = $url;
		$assign_list['cat_id'] = $cat_id;
		$assign_list['oneTable'] = $oneTable;
		$assign_list["comment_config"] = array('science_id'=>$science_id);
		#- Related
		$sql = "is_trash=0 and is_online=1 and science_id<>'$science_id' and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
		$lstRelated = $clsScience->getAll($sql." order by reg_date DESC limit 0,4","science_id,permalink,title,intro,reg_date,upd_date,profile_id,type,number_comment,cat_id,end_date,link_target");
		$assign_list['lstRelated'] = $lstRelated;
		$html = $core->build('load_more_detail.tpl');
	}
	echo $html.'$$$'.$url;
	
	die();	
}
?>
