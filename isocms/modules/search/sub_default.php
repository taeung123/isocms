<?php
/**
*  Defautl action
*  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (info@vietiso.com)		
*  @date		: 2009/10/01
   @date-modify : 2009/01/06	
*  @version		: 3.0.0
*/
function _parsemicrotime($microtime){
	if($microtime!=''){
		$tmp=explode(' ',$microtime);
		return $tmp[0]+$tmp[1];
	}
	return 0;
}
function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn,$mod,$act,$_LANG_ID,$title_page,$description_page,$keyword_page;
	
	#
	$keyword = $_GET['keyword'];$assign_list['keyword'] = $keyword;
	$key_slug = $core->replaceSpace($keyword);
	$title = 'title_'.$_LANG_ID;
	$slug = 'slug_'.$_LANG_ID;
	$listResult = array();
	$starttime=_parsemicrotime(microtime());
	#
	$clsCountry = new Country();$assign_list['clsCountry'] = $clsCountry;
	
	#---- Khách sạn
	$number_hotel= 0;
	$clsHotel = new Hotel(); $assign_list['clsHotel'] = $clsHotel;
	$lst = $clsHotel->getAll("is_trash=0 and ($title like '%$keyword%' or $slug like '%$key_slug%')");
	if(is_array($lst)&&count($lst)>0){
		$listResult = array_merge($listResult, $lst); 
		$number_hotel = count($lst);
	}
	$assign_list['number_hotel'] = $number_hotel;
	unset($lst);
	
	#---- Tour
	$number_tour = 0;
	$clsTour = new Tour(); $assign_list['clsTour'] = $clsTour;
	$lst = $clsTour->getAll("is_trash=0 and ($title like '%$keyword%' or $slug like '%$key_slug%')");
	if(is_array($lst)&&count($lst)>0){
		$listResult = array_merge($listResult, $lst);
		$number_tour = count($lst);
	}
	$assign_list['number_tour'] = $number_tour;
	unset($lst);
	
	#---- Services
	$number_service = 0;
	$clsService = new Service(); $assign_list['clsService'] = $clsService;
	$lst = $clsService->getAll("is_trash=0 and ($title like '%$keyword%' or $slug like '%$key_slug%')");
	if(is_array($lst)&&count($lst)>0){
		$listResult = array_merge($listResult, $lst);
		$number_service = count($lst);
	}
	$assign_list['number_service'] = $number_service;
	unset($lst);
	
	#---- Promotion
	$number_promotion = 0;
	$clsPromotion = new Promotion(); $assign_list['clsPromotion'] = $clsPromotion;
	$lst = $clsPromotion->getAll("is_trash=0 and ($title like '%$keyword%' or $slug like '%$key_slug%')");
	if(is_array($lst)&&count($lst)>0){
		$listResult = array_merge($listResult, $lst);
		$number_service = count($lst);
	}
	$assign_list['number_promotion'] = $number_promotion;
	unset($lst);
	
	$endtime=_parsemicrotime(microtime());
	$time_generate=($endtime-$starttime)*1000;
	$assign_list['time_generate'] = number_format($time_generate,4);
	#------------------------
	shuffle($listResult);
	$assign_list['listResult'] = $listResult;
	$assign_list['total_result']=!empty($listResult)?count($listResult):0;
	#
	$recordPerPage 	= ($num_per_page=='')?50:$num_per_page;
	$pageNum = 10;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	#####################
	$intStart = ($currentPage*$recordPerPage);
	$intLimit = $recordPerPage;
	#
	$totalRecord 	= count($listResult);		
	$totalPage	 	= ceil($totalRecord / $recordPerPage);
	#
	$first = intval($currentPage/$pageNum)*$pageNum;
	$pageView = "";
	for ($i=0; $i<$pageNum; $i++)
		if ($first+$i<$totalPage){
			$link = $ISOCMS_URL."/search/q=".$key."&page=".($first+$i+1);
			$page = ($first+$i+1 == $currentPage)? '<a class="current" href="'.$link.'" title="Page .'.($first+$i+1).'">'.($first+$i+1).'</a>' : '<a href="'.$link.'" title="Page .'.($first+$i+1).'">'.($first+$i+1).'</a>';
			$pageView .=$page;
		}
	$start = (intval($currentPage)-1)*$recordPerPage-1;
	$assign_list['start'] = $start;
	$end = $start + intval($recordPerPage)+1;
	$assign_list['end'] = $end;
	$assign_list['first'] = $first;
	$assign_list['finish'] = ($end>$totalRecord)?$totalRecord:$end;
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['pageNum'] = $pageNum;
	$assign_list['pageView'] = $pageView;
	/*=============Title & Description Page==================*/
	if(isset($_POST['keyword'])){
		$key=$_POST['keyword'];
		if($key!='' && $key!='Search...' && strlen($key)>0){
			header('location:'.$PCMS_URL.'/search/q='.$key);
		}
	}
	if($key!='')
		$title_page = $key.' - Kết quả tìm kiếm - '.PAGE_NAME;
	else
	$title_page =  'Kết quả tìm kiếm - '.PAGE_NAME;
	
	$assign_list["title_page"] = $title_page;
	$description_page = 'Search results - '.PAGE_NAME;
	$assign_list["description_page"] = $description_page;
	$keyword_page = 'Search results - '.PAGE_NAME;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_detail(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain_id;

	#
	$clsNews = new News();$assign_list["clsNews"] = $clsNews;
	$news_id = $_GET['news_id'];
	$assign_list["news_id"] = $news_id;
	#
	$oneItem = $clsNews->getOne($news_id);
	$assign_list["oneItem"] = $oneItem;
	$news_cat_id = $oneItem['news_cat_id'];
	$assign_list["news_cat_id"] = $news_cat_id;
	#
	$clsNewsCat = new NewsCat();$assign_list["clsNewsCat"] = $clsNewsCat;
	#
	$listCat = $clsNewsCat->getAll("is_trash=0 and domain_id = '$domain_id' order by order_no desc");
	$assign_list["listCat"] = $listCat;
	$listOther = $clsNews->getAll("is_trash=0 and news_cat_id = '$news_cat_id' order by order_no desc limit 0,4");
	$assign_list["listOther"] = $listOther;
	#
	
	/*=============Title & Description Page==================*/
	$title_page ='Góc báo chí - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsNewsCat);unset($clsNews);
}
function default_search(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$_lang,$clsPageInfo;
	global $core, $clsISO;
	#
	
	$clsTour = new Tour(); $assign_list['clsTour']=$clsTour;
	$clsCruise = new Cruise(); $assign_list['clsCruise']=$clsCruise;
	$clsBlog = new Blog(); $assign_list['clsBlog']=$clsBlog;
	$clsService = new Service(); $assign_list['clsService']=$clsService;
	$clsNews = new News(); $assign_list['clsNews']=$clsNews;
	$clsGuide = new Guide(); $assign_list['clsGuide']=$clsGuide;
	
	$q = $_GET['q'];
	$slug_q = $core->replaceSpace($q);
	$assign_list['q']= $q;
	
	$listItem = array();
	$totalItem = 0;
	# Find Tour
	$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
	$result = $clsTour->getAll($sql, $clsTour->pkey.',reg_date,order_no');
	if(is_array($result) && count($result)>0){
		$totalItem += count($result);
		for($i=0; $i<count($result); $i++){
			$listItem[] = array(
				'type'		=> 'TOUR',
				'pvalTable' => $result[$i][$clsTour->pkey],
				'title'		=> $clsTour->getTitle($result[$i][$clsTour->pkey]),
				'link'		=> $clsTour->getLink($result[$i][$clsTour->pkey]),
				'intro'		=> $clsTour->getIntro($result[$i][$clsTour->pkey]),
				'image'		=> $clsTour->getImage($result[$i][$clsTour->pkey],90,60),
				'reg_date' => $result[$i]['reg_date'],
				'order_no' => $result[$i]['order_no']
			);
		}
		unset($result);
	}
	
	# Find Cruise
	$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
	$result = $clsCruise->getAll($sql, $clsCruise->pkey.',reg_date,order_no');
	if(is_array($result) && count($result)>0){
		$totalItem += count($result);
		for($i=0; $i<count($result); $i++){
			$listItem[] = array(
				'type'		=> 'CRUISE',
				'pvalTable' => $result[$i][$clsCruise->pkey],
				'title'		=> $clsCruise->getTitle($result[$i][$clsCruise->pkey]),
				'link'		=> $clsCruise->getLink($result[$i][$clsCruise->pkey]),
				'intro'		=> $clsCruise->getAbout($result[$i][$clsCruise->pkey]),
				'image'		=> $clsCruise->getImage($result[$i][$clsCruise->pkey],90,60),
				'reg_date' => $result[$i]['reg_date'],
				'order_no' => $result[$i]['order_no']
			);
		}
		unset($result);
	}
	# Find Blog
	$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
	$result = $clsBlog->getAll($sql, $clsBlog->pkey.',reg_date,order_no');
	if(is_array($result) && count($result)>0){
		$totalItem += count($result);
		for($i=0; $i<count($result); $i++){
			$listItem[] = array(
				'type'		=> 'BLOG',
				'pvalTable' => $result[$i][$clsBlog->pkey],
				'title'		=> $clsBlog->getTitle($result[$i][$clsBlog->pkey]),
				'link'		=> $clsBlog->getLink($result[$i][$clsBlog->pkey]),
				'intro'		=> $clsBlog->getIntro($result[$i][$clsBlog->pkey]),
				'image'		=> $clsBlog->getImage($result[$i][$clsBlog->pkey],90,60),
				'reg_date' => $result[$i]['reg_date'],
				'order_no' => $result[$i]['order_no']
			);
		}
		unset($result);
	}
	# Find News
	$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
	$result = $clsNews->getAll($sql, $clsNews->pkey.',reg_date,order_no');
	if(is_array($result) && count($result)>0){
		$totalItem += count($result);
		for($i=0; $i<count($result); $i++){
			$listItem[] = array(
				'type'		=> 'NEWS',
				'pvalTable' => $result[$i][$clsNews->pkey],
				'title'		=> $clsNews->getTitle($result[$i][$clsNews->pkey]),
				'link'		=> $clsNews->getLink($result[$i][$clsNews->pkey]),
				'intro'		=> $clsNews->getIntro($result[$i][$clsNews->pkey]),
				'image'		=> $clsNews->getImage($result[$i][$clsNews->pkey],90,60),
				'reg_date' => $result[$i]['reg_date'],
				'order_no' => $result[$i]['order_no']
			);
		}
		unset($result);
	}
	# Find Service
	$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
	$result = $clsService->getAll($sql, $clsService->pkey.',reg_date,order_no');
	if(is_array($result) && count($result)>0){
		$totalItem += count($result);
		for($i=0; $i<count($result); $i++){
			$listItem[] = array(
				'type'		=> 'SERVICE',
				'pvalTable' => $result[$i][$clsGuide->pkey],
				'title'		=> $clsService->getTitle($result[$i][$clsService->pkey]),
				'link'		=> $clsService->getLink($result[$i][$clsService->pkey]),
				'intro'		=> $clsService->getIntro($result[$i][$clsService->pkey]),
				'image'		=> $clsService->getImage($result[$i][$clsService->pkey],90,60),
				'reg_date' => $result[$i]['reg_date'],
				'order_no' => $result[$i]['order_no']
			);
		}
		unset($result);
	}
	# Find Guide
	$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
	$result = $clsGuide->getAll($sql, $clsGuide->pkey.',reg_date,order_no');
	if(is_array($result) && count($result)>0){
		$totalItem += count($result);
		for($i=0; $i<count($result); $i++){
			$listItem[] = array(
				'type'		=> 'GUIDE',
				'pvalTable' => $result[$i][$clsGuide->pkey],
				'title'		=> $clsGuide->getTitle($result[$i][$clsGuide->pkey]),
				'link'		=> $clsGuide->getLink($result[$i][$clsGuide->pkey]),
				'intro'		=> $clsGuide->getIntro($result[$i][$clsGuide->pkey]),
				'image'		=> $clsGuide->getImage($result[$i][$clsGuide->pkey],90,60),
				'reg_date' => $result[$i]['reg_date'],
				'order_no' => $result[$i]['order_no']
			);
		}
		unset($result);
	}
	
	if(1==2){
		# Find Hotel
		$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
		$result = $clsHotel->getAll($sql, $clsHotel->pkey.',star,reg_date,order_no');
		if(is_array($result) && count($result)>0){
			$totalItem += count($result);
			for($i=0; $i<count($result); $i++){
				$listItem[] = array(
					'type'		=> 'HOTEL',
					'pvalTable' => $result[$i][$clsHotel->pkey],
					'star' 		=> $result[$i]['star'],
					'title'		=> $clsHotel->getTitle($result[$i][$clsHotel->pkey]),
					'link'		=> $clsHotel->getLink($result[$i][$clsHotel->pkey]),
					'intro'		=> $clsHotel->getIntro($result[$i][$clsHotel->pkey]),
					'image'		=> $clsHotel->getImage($result[$i][$clsHotel->pkey],90,60),
					'reg_date' => $result[$i]['reg_date'],
					'order_no' => $result[$i]['order_no']
				);
			}
			unset($result);
		}
		$clsCountryEx = new Country();
		$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
		$result = $clsCountryEx->getAll($sql, $clsCountryEx->pkey.',reg_date,order_no');
		if(is_array($result) && count($result)>0){
			$totalItem += count($result);
			for($i=0; $i<count($result); $i++){
				$listItem[] = array(
					'type'		=> 'COUNTRY',
					'pvalTable' => $result[$i][$clsCountryEx->pkey],
					'title'		=> $clsCountryEx->getTitle($result[$i][$clsCountryEx->pkey]),
					'link'		=> $clsCountryEx->getLinkDestination($result[$i][$clsCountryEx->pkey]),
					'intro'		=> $clsCountryEx->getIntro($result[$i][$clsCountryEx->pkey]),
					'image'		=> $clsCountryEx->getImage($result[$i][$clsCountryEx->pkey],90,60),
					'reg_date' => $result[$i]['reg_date'],
					'order_no' => $result[$i]['order_no']
				);
			}
			unset($result);
		}
		# Find City
		$clsCity = new City();
		$sql = "is_trash=0 and is_online=1 and (title like '%$q%' or slug like '%$slug_q%') order by order_no ASC";
		$result = $clsCity->getAll($sql, $clsCity->pkey.',country_id,reg_date,order_no');
		if(is_array($result) && count($result)>0){
			$totalItem += count($result);
			for($i=0; $i<count($result); $i++){
				$listItem[] = array(
					'type'		=> 'CITY',
					'pvalTable' => $result[$i][$clsCity->pkey],
					'title'		=> $clsCity->getTitle($result[$i][$clsCity->pkey]),
					'link'		=> $clsCity->getLink($result[$i][$clsCity->pkey]),
					'intro'		=> $clsCity->getIntro($result[$i][$clsCity->pkey]),
					'image'		=> $clsCity->getImage($result[$i][$clsCity->pkey],90,60),
					'reg_date' => $result[$i]['reg_date'],
					'order_no' => $result[$i]['order_no']
				);
			}
			unset($result);
		}
	}
	#
	function sortOrder($a, $b, $pos='reg_date') {
		if($pos=='reg_date')
			return $b['reg_date'] - $a['reg_date'];
		else
			return $b['order_no'] - $a['order_no'];
	}
	if(is_array($listItem) && count($listItem) > 0){
		usort($listItem, 'sortOrder');
	}
	#
	$link_page = '/search/q='.$q;
	$currentPage = isset($_GET['page'])?$_GET['page']:1;
	$recordPerPage = 10;
	$totalRecord = $totalItem;
	
	$start = ($currentPage-1)*$recordPerPage;
	$assign_list["start"] = ($start < 1)?1:$start;
	$end = (($currentPage-1)*$recordPerPage)+$recordPerPage;
	$assign_list["end"] = ($totalItem<$recordPerPage)?$totalItem:$end;
	#
	if($totalItem > $recordPerPage){
		require_once($_SERVER['DOCUMENT_ROOT'].'/inc/pagination.class.php');
		
		$pagination = new paginationArray($listItem, $currentPage, $recordPerPage);
		
		$pagination->setShowFirstAndLast(false);
		// You can overwrite the default seperator
		$pagination->setMainSeperator('');
		// Parse through the pagination class
		$data = $pagination->getResults();
		
		$assign_list["listItem"] = $data;
		$pageview = $pagination->getLinks($link_page);
		$assign_list["pageview"] = $pageview;
		
	}else{
		$assign_list["listItem"] = $listItem;
		$assign_list["pageview"] = '';
	}
	$assign_list["totalItem"] = $totalItem;
	
    /*=============Title & Description Page==================*/
	$title_page =$core->get_Lang('Search').' '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}
?>
