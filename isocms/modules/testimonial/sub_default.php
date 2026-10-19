<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,$extLang, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain,$clsPageInfo,$clsConfiguration;
	#Country
	$clsCountry = new _Country();$assign_list['clsCountry']=$clsCountry;
	$clsTestimonial = new Testimonial();$assign_list['clsTestimonial']=$clsTestimonial;
	$clsPagination = new Pagination();$assign_list['clsPagination']=$clsPagination;
	#

	$recordPerPage = 8;
	$currentPage = isset($_GET['page'])?intval($_GET['page']):1;
	
	$page_Seo = isset($_GET['page'])?intval($_GET['page']):'';
	$assign_list['page_Seo']=$page_Seo;
	
	$cond = "is_trash=0 and is_online=1";
	$order_by = " order by order_no ASC";
	$allItem = $clsTestimonial->getAll($cond,$clsTestimonial->pkey);
	$totalRecord = $allItem? count($allItem):0;
	
	$link_page = $extLang.'/testimonials/';
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
//	$page_view = $clsPagination->create_links_news(false);
	$page_view = $clsPagination->create_links(false);
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	#Testimonial
	
	$listItem = $clsTestimonial->getAll($cond.$order_by.$limit,$clsTestimonial->pkey.',title,slug,image,intro,name,country_id,rates');
	$assign_list['listItem'] = $listItem;unset($listItem);
	
	$assign_list['totalPage'] = $clsPagination->getTotalPage();
	$assign_list['page_view'] = $page_view; 
	unset($page_view);
	
	#
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('testimonials').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$clsConfiguration->getValue('site_testimonial_intro_'.$_LANG_ID);
	$assign_list["description_page"] = $description_page;
	/*=============Content Page==================*/
	unset($clsCountry);unset($clsTestimonial);
}
function default_detail(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page, $extLang,$clsISO,$clsConfiguration;
	#
	$clsTestimonial=new Testimonial();
	$assign_list['clsTestimonial']=$clsTestimonial;
	
	$testimonial_id = isset($_GET['testimonial_id'])?$_GET['testimonial_id']:0;
	$slug = isset($_GET['slug'])?$_GET['slug']:'';
	
	if(empty($clsTestimonial->checkOnlineBySlug($testimonial_id,$slug))){
		header('location:'.$clsISO->getLink('testimonial'));
		exit();
	}
	$assign_list['testimonial_id']=$testimonial_id;
	#
	$listItem=$clsTestimonial->getAll("is_trash=0 and is_online=1 and testimonial_id<>'$testimonial_id' order by rand() limit 0,3",$clsTestimonial->pkey);
	$assign_list['listItem']=$listItem;
	#
	/*=============Title & Description Page==================*/
	$title_page = $clsTestimonial->getTitle($testimonial_id).' | '.$core->get_Lang('testimonials').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsISO->getMetaDescription($testimonial_id,'Testimonial');
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsISO->getPageImageShare($testimonial_id,'Testimonial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
}
?>