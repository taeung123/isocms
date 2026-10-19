<?php
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn,$mod,$act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
	// End Global.
	$clsImage=new Image();
	$assign_list['clsImage']=$clsImage;
	
	$clsGallery= new Gallery();
	$assign_list['clsGallery']=$clsGallery;
	
	$assign_list['catGallery']=$clsGallery->getAll('is_trash=0 order by order_no desc');
	
	$lnk=$_SERVER['REQUEST_URI'];
	if(isset($_GET['page'])){
		$tmp = explode('&',$lnk);
		$n = count($tmp)-1;
		$la_it = '&'.$tmp[$n];
		$str_len = -strlen($la_it);
		$linkpage = substr($lnk, 0, $str_len);
	}
	else{
		$linkpage = $lnk;
	}
	$assign_list["linkpage"] = $linkpage;
	
	$recordPerPage = 9;
	$pageNum = 5;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	#
	$start_limit = ($currentPage-1)*$recordPerPage; 
	$limit = " limit $start_limit,$recordPerPage"; 
	
	$cond = "is_trash=0 and image<>''";
	$cond.=" order by order_no desc";
	
	$assign_list['listGallery']=$clsGallery->getAll($cond.$limit);
	
	$allItem=$clsGallery->getAll($cond);
	$totalRecord 	= $clsGallery->getAll($cond)?count($allItem):0;		
	$totalPage	 	= ceil($totalRecord / $recordPerPage);
	#
	$first = intval($currentPage/$pageNum)*$pageNum;
	$pageView = "";
	for ($i=0; $i<$pageNum; $i++)
		if ($first+$i<$totalPage){
			$link = $linkpage."&page=".($first+$i+1);
			$page = ($first+$i+1 == $currentPage)? '<a class="current" href="'.$link.'" title="Trang .'.($first+$i+1).'">'.($first+$i+1).'</a>' : '<a href="'.$link.'" title="Trang .'.($first+$i+1).'">'.($first+$i+1).'</a>';
			$pageView .=$page;
		}
	#
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['pageNum'] = $pageNum;
	$assign_list['pageView'] = $pageView;
	#
    /*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Gallery').' - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $core->get_Lang('Gallery').' - '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $core->get_Lang('Gallery').' - '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsCruise);
}
function default_cat(){
	global $assign_list,$_CONFIG,$core,$dbconn,$mod, $act,$_LANG_ID,$title_page,$description_page,$keyword_page,$domain;   
	// End Global.
	
	#Images
	$clsGallery= new Gallery();
	$assign_list['clsGallery']=$clsGallery;
	$assign_list['listGallery']=$clsGallery->getAll('is_trash=0 order by order_no desc');
	
	$slug=$_GET['slug'];
	$all=$clsGallery->getAll("is_trash=0 and slug='$slug' limit 0,1");
	$gallery_id=$all[0][$clsGallery->pkey];
	$assign_list["slug"] = $slug;
	$assign_list["gallery_id"] = $gallery_id;
	if($gallery_id == '')
	{
		header('location:'.PCMS_URL.'/gallery/');
	}
	
	$clsImage= new Image();
	$assign_list['clsImage']=$clsImage;
	$lnk=$_SERVER['REQUEST_URI'];
	if(isset($_GET['page'])){
		$tmp = explode('&',$lnk);
		$n = count($tmp)-1;
		$la_it = '&'.$tmp[$n];
		$str_len = -strlen($la_it);
		$linkpage = substr($lnk, 0, $str_len);
	}
	else{
		$linkpage = $lnk;
	}
	$assign_list["linkpage"] = $linkpage;
	
	$recordPerPage = 9;
	$pageNum = 5;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	#
	$start_limit = ($currentPage-1)*$recordPerPage; 
	$limit = " limit $start_limit,$recordPerPage"; 
	
	$cond = "is_trash=0 and table_id='$gallery_id' and image<>''";
	$cond.=" order by order_no desc";
	
	$assign_list['listImage']=$clsImage->getAll($cond.$limit);
	
	$allItem=$clsImage->getAll($cond);
	$totalRecord 	= count($allItem);	
	$totalPage	 	= ceil($totalRecord / $recordPerPage);
	#
	$first = intval($currentPage/$pageNum)*$pageNum;
	$pageView = "";
	for ($i=0; $i<$pageNum; $i++)
		if ($first+$i<$totalPage){
			$link = $linkpage."&page=".($first+$i+1);
			$page = ($first+$i+1 == $currentPage)? '<a class="current" href="'.$link.'" title="Trang .'.($first+$i+1).'">'.($first+$i+1).'</a>' : '<a href="'.$link.'" title="Trang .'.($first+$i+1).'">'.($first+$i+1).'</a>';
			$pageView .=$page;
		}
	#
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['pageNum'] = $pageNum;
	$assign_list['pageView'] = $pageView;
	
    /*=============Title & Description Page==================*/
	$title_page = $clsGallery->getTitle($gallery_id).' - '.$core->get_Lang('Gallery').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsGallery->getTitle($gallery_id).' - '.$core->get_Lang('Gallery').' | '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $clsGallery->getTitle($gallery_id).' - '.$core->get_Lang('Gallery').' | '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsCruise);
}
?>
