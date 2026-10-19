<?php
//use Dompdf\Adapter\CPDF;
//use Dompdf\Dompdf;
//use Dompdf\Exception;
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	#
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$clsTable = isset($_GET['clsTable']) ? $_GET['clsTable'] : '';
	$assign_list["clsTable"] = $clsTable;
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsTour = new Tour(); $assign_list["clsTour"] = $clsTour;
	$clsHotel = new Hotel(); $assign_list["clsHotel"] = $clsHotel;
	$clsFeedback = new Feedback(); $assign_list["clsFeedback"] = $clsFeedback;
	$clsCountry = new _Country(); $assign_list["clsCountry"] = $clsCountry;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if(isset($_POST['clsTable']) &&  $_POST['clsTable']!=''){
			$link .= '&clsTable='.$_POST['clsTable'];
		}
		if(isset($_POST['status']) &&  $_POST['status']!=''){
			$link .= '&status='.$_POST['status'];
		}
		if($_POST['keyword']!=''&&$_POST['keyword']!='testimonial title, intro'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	#
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ='1=1';
	if($clsTable != ''){
		$cond .= " and clsTable='$clsTable'";
	}
	if($status != ''){
		if($status == 'Offered') {$cond .= " and status=1";}
		if($status == 'Reviewed') {$cond .= " and status=2";}
		if($status == 'Reminding') {$cond .= " and status=0";}
	}
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (
			target_id IN (SELECT hotel_id FROM ".DB_PREFIX."hotel WHERE title like '%".$_GET['keyword']."%')
			or target_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE title like '%".$_GET['keyword']."%')
			or booking_store LIKE '%".$_GET['keyword']."%'
		)";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
	
}

function default_list_booking(){
		ini_set('display_errors',1);
error_reporting(E_ERROR & ~E_STRICT);//E_ALL
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	$clsCountry = new Country(); $assign_list["clsCountry"] = $clsCountry;
	$clsTourCat = new TourCategory(); $assign_list["clsTourCat"] = $clsTourCat; 
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	
	$booking_time = isset($_GET['booking_time']) ? $_GET['booking_time'] :0;
	$assign_list["booking_time"] = $booking_time;
	#
	$clsTour = new Tour(); $assign_list["clsTour"] = $clsTour;
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = "&act=$act";
		if(isset($_POST['clsTable']) &&  $_POST['clsTable']!=''){
			$link .= '&clsTable='.$_POST['clsTable'];
		}
		if(!empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		if(!empty($_POST['booking_time'])){
			$link .= '&booking_time='.$_POST['booking_time'];
		}
		if(!empty($_POST['status'])){
			$link .= '&status='.$_POST['status'];
		}
		
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	if(isset($_POST['Export'])&&$_POST['Export']=='Export'){
		$link= '?mod=export&type=excel_tour';
		if($status!=''){
			$link .= '&status='.$status.'';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: '.PCMS_URL.'/'.$link);
	}
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ="1=1 and clsTable = 'Tour'";
	
	$list_booking = $clsClassTable->getAll($cond,$clsClassTable->pkey.',reg_date');
	$list_booking_time=array();
	foreach($list_booking as $item){
		$list_booking_time[]=$clsISO->formatDate($item['reg_date'],'/');
	}
	$list_booking_time=array_unique($list_booking_time); 
	sort($list_booking_time); 
	$assign_list["list_booking_time"] = $list_booking_time;
	
	if($status != '') {$cond.= " and status = '$status'";}
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (
			target_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE title like '%".$_GET['keyword']."%')
			or booking_store LIKE '%".$_GET['keyword']."%'
		)";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	if(!empty($booking_time)){
		$booking_time = str_replace('/', '-', $booking_time);
		$booking_time = strtotime($booking_time);
		$booking_time_next_day = $booking_time+86400;
		$cond.= " and reg_date > '$booking_time' and reg_date < '$booking_time_next_day'";
	}
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	
	
	$lstAllItem = $clsClassTable->getAll($cond,$clsClassTable->pkey.',reg_date');
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	
	//print_r($cond." ".$orderBy.$limit); die();
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	
	
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Tour'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Tour'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Tour'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Tour'");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
}

function default_booking_tour(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsTour = new Tour(); $assign_list["clsTour"] = $clsTour;
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = "&act=$act";
		if(isset($_POST['clsTable']) &&  $_POST['clsTable']!=''){
			$link .= '&clsTable='.$_POST['clsTable'];
		}
		if(isset($_POST['status']) &&  $_POST['status']!=''){
			$link .= '&status='.$_POST['status'];
		}
		if(!empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	if(isset($_POST['Export'])&&$_POST['Export']=='Export'){
		$link= '?mod=export&type=excel_tour';
		if($status!=''){
			$link .= '&status='.$status.'';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: '.PCMS_URL.'/'.$link);
	}
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ="1=1 and clsTable = 'Tour'";
	if($status != '') {$cond.= " and status = '$status'";}
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (
			target_id IN (SELECT tour_id FROM ".DB_PREFIX."tour WHERE title like '%".$_GET['keyword']."%')
			or booking_store LIKE '%".$_GET['keyword']."%'
		)";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	
	//print_r($cond." ".$orderBy.$limit); die();
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Tour'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Tour'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Tour'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Tour'");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->doDelete($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
}
function default_booking_cruise(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsCruise = new Cruise(); $assign_list["clsCruise"] = $clsCruise;
	$clsCruiseCabin = new CruiseCabin(); $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	
	if(isset($_POST['Export'])&&$_POST['Export']=='Export'){
		$link= '?mod=export&type=excel_cruise';
		if($status!=''){
			$link .= '&status='.$status.'';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: '.PCMS_URL.'/'.$link);
	}
	
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ="1=1 and clsTable = 'Cruise'";
	if($status != '') {$cond.= " and status = '$status'";}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Tour'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Tour'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Tour'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Tour'");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
}
function default_booking_tailor(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	#
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = "&act=$act";
		if(!empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	
	#
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsTour = new Tour(); $assign_list["clsTour"] = $clsTour;
	$clsCountry = new Country(); $assign_list["clsCountry"] = $clsCountry;
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ="1=1 and clsTable = 'Tailor'";
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and booking_store LIKE '%".$_GET['keyword']."%' ";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	
	if($status != '') {$cond.= " and status = '$status'";}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Tailor'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Tailor'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Tailor'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Tailor'");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
	
}
function default_booking_hotel(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsHotel = new Hotel(); $assign_list["clsHotel"] = $clsHotel;
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = "&act=$act";
		if(isset($_POST['clsTable']) &&  $_POST['clsTable']!=''){
			$link .= '&clsTable='.$_POST['clsTable'];
		}
		if(isset($_POST['status']) &&  $_POST['status']!=''){
			$link .= '&status='.$_POST['status'];
		}
		if(!empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	if(isset($_POST['Export'])&&$_POST['Export']=='Export'){
		$link= '?mod=export&type=excel_hotel';
		if($status!=''){
			$link .= '&status='.$status.'';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: '.PCMS_URL.'/'.$link);
	}
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ="1=1 and clsTable = 'Hotel'";
	if($status != '') {$cond.= " and status = '$status'";}
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (
			target_id IN (SELECT hotel_id FROM ".DB_PREFIX."hotel WHERE title like '%".$_GET['keyword']."%')
			or booking_store LIKE '%".$_GET['keyword']."%'
		)";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	$orderBy = "order by booking_id desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit);
//	print_r($cond." ".$orderBy.$limit); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Hotel'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Hotel'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Hotel'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Hotel'");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
	
}
function default_booking_service(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsService = new Service(); $assign_list["clsService"] = $clsService;
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = "&act=$act";
		if(isset($_POST['clsTable']) &&  $_POST['clsTable']!=''){
			$link .= '&clsTable='.$_POST['clsTable'];
		}
		if(isset($_POST['status']) &&  $_POST['status']!=''){
			$link .= '&status='.$_POST['status'];
		}
		if(!empty($_POST['keyword'])){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	if(isset($_POST['Export'])&&$_POST['Export']=='Export'){
		$link= '?mod=export&type=excel_service';
		if($status!=''){
			$link .= '&status='.$status.'';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: '.PCMS_URL.'/'.$link);
	}
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ="1=1 and clsTable = 'Service'";
	if($status != '') {$cond.= " and status = '$status'";}
	#Filter By Keyword
	if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and (
			target_id IN (SELECT hotel_id FROM ".DB_PREFIX."hotel WHERE title like '%".$_GET['keyword']."%')
			or booking_store LIKE '%".$_GET['keyword']."%'
		)";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem;
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Service'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Service'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Service'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Service'");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
	
}
/*====================================================================================================*/

function default_booking_room(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}
	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsHotel = new Hotel(); $assign_list["clsHotel"] = $clsHotel;
	$clsHotelRoom = new HotelRoom(); $assign_list["clsHotelRoom"] = $clsHotelRoom;
	
	/**/
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	
	#
	$cond ="1=1 and clsTable = 'Room'";
	if($status != '') {$cond.= " and status = '$status'";}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	unset($listItem);
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Hotel'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Hotel'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Hotel'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Hotel'");
	
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
}



function default_quick_booking(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$clsConfiguration;
	global $clsISO,$package_id;
	if(!$clsISO->getCheckActiveModulePackage($package_id,$mod,$act,'default')){
		header('Location:/admin/index.php?lang='.LANG_DEFAULT);
		exit();
	}

	
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;

	#
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	$clsHotel = new Hotel(); $assign_list["clsHotel"] = $clsHotel;
	$clsHotelRoom = new HotelRoom(); $assign_list["clsHotelRoom"] = $clsHotelRoom;
	
	/**/
	$classTable = "BookingRoom";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ="1=1 and type = '$type'";
	if($status != '') {$cond.= " and status = '$status'";}
	#
	if($type_list=='Reminding'){
		$cond.=" and status=0";
	}elseif($type_list=='Offered'){
		$cond.=" and status=1";
	}elseif($type_list=='Reviewed'){
		$cond.=" and status=2";
	}
	
	$orderBy = "order by reg_date desc";
	
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 20;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page'&&$tmp[0]!='type_list')
			$link_page_current_2 .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$listItem = $clsClassTable->getAll($cond." ".$orderBy.$limit); //print_r($cond); die();
	$assign_list["listItem"] = $listItem; //print_r($listItem); die();
	#
	$assign_list["totalItem"] = $clsClassTable->countItem("1=1 and clsTable = 'Hotel'");
	$assign_list["number_process"] = $clsClassTable->countItem("status=1 and clsTable = 'Hotel'");
	$assign_list["number_unprocess"] = $clsClassTable->countItem("status=0 and clsTable = 'Hotel'");
	$assign_list["number_reviewed"] = $clsClassTable->countItem("status=2 and clsTable = 'Hotel'");
	
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$act;
		$string = isset($_GET['booking_id'])?$_GET['booking_id']:"";
		$pvalTable =intval($core->decryptID($string));
		$assign_list["pvalTable"] = $pvalTable;
		if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
		}
	} 
}

function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$oneCommon,$dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	$clsUser = new User(); $assign_list['clsUser'] = $clsUser;
	#
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	$assign_list["action"] = $action;
	
	$message = isset($_GET['message']) ? $_GET['message'] : '';
	$assign_list["message"] = $message;
	
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$assign_list["type"] = $type;
	
	if($action=='quick_booking'){
		$classTable = "BookingRoom";
	}else{
		$classTable = "Booking";
	}
	
	$clsClassTable = new $classTable;
	
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	
	#
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	$pvalTable =intval($core->decryptID($string));
	if($string != '' && $pvalTable==0){
		 header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		 exit();
	}
	$assign_list["pvalTable"] = $pvalTable;

	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;
	
	$clsTour = new Tour();	$assign_list["clsTour"] = $clsTour;	
	$clsHotel = new Hotel();	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise = new Cruise();	$assign_list["clsCruise"] = $clsCruise;
	$clsVoucher = new Voucher();	$assign_list["clsVoucher"] = $clsVoucher;
	$clsHotelRoom = new HotelRoom();	$assign_list["clsHotelRoom"] = $clsHotelRoom;
	$clsCruiseItinerary = new CruiseItinerary();	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCruiseCabin = new CruiseCabin();	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	
	$clsTourOption = new TourOption();	$assign_list["clsTourOption"] = $clsTourOption;	
	$clsAddOnService = new AddOnService();$assign_list["clsAddOnService"] = $clsAddOnService;
	
	$clsCountry = new Country();
	$assign_list["clsCountry"] = $clsCountry;
	
	$booking_store = unserialize($oneItem['booking_store']);
	$booking_store['birthday'] = date("d/m/Y",strtotime(str_replace('/','-',$booking_store['birthday'])));
	$assign_list["booking_store"] = $booking_store;
	
	$cart_store = unserialize($oneItem['cart_store']);
	$assign_list["tour_cart_store"] = (isset($cart_store['TOUR']))?$cart_store['TOUR']:'';
	$assign_list["hotel_cart_store"] = (isset($cart_store['HOTEL']))?$cart_store['HOTEL']:'';
	$assign_list["cruise_cart_store"] = (isset($cart_store['CRUISE']))?$cart_store['CRUISE']:'';
	$assign_list["voucher_cart_store"] = (isset($cart_store['VOUCHER']))?$cart_store['VOUCHER']:'';
	#
	$status = $oneItem['status'];
	if($status == 0 && intval($pvalTable) > 0) {
		$clsClassTable->updateOne($pvalTable,"status = 2");
	}
	
	/*money min max*/
	$clsBillingHistory = new BillingHistory();
	
	$sql = "SELECT SUM(bill_money) as deposit FROM ".DB_PREFIX."billing_history WHERE booking_id = '$pvalTable'";
	$deposit_bill = $dbconn->getOne($sql);
//	var_dump($oneItem);die;
	
	$balance = $oneItem['totalgrand'] - $deposit_bill;
	$money_min = $balance*0.1;
	
	if($money_min > $balance){
		$money_min = $balance;
	}
	$money_max = $balance;
	$assign_list["money_min"] = $money_min;
	$assign_list["money_max"] = $money_max;
	/*end money min max*/
	
	$lstBillingHistory = $clsBillingHistory->getAll("booking_id='".$pvalTable."' ORDER BY reg_date DESC",$clsBillingHistory->pkey.',bill_money,status,payment_term,payment_method,user_id,reg_date');
	$assign_list['lstBillingHistory'] = $lstBillingHistory;
	
	#check history payment
	$checkBillingHistory = $clsBillingHistory->getAll("booking_id='".$pvalTable."' and (status = '0' OR status = '2') LIMIT 0,1",$clsBillingHistory->pkey.',reg_date,payment_term,payment_method,bill_money,note');
	$assign_list["checkBillingHistory"] = $checkBillingHistory[0];
	#
	$clsTable = $oneItem['clsTable'];
	$assign_list["clsTable"] = $clsTable;
	#
	require_once DIR_COMMON."/clsForm.php";
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$assign_list["clsForm"] = $clsForm;
	#-------------Update Config Meta 
	$clsForm->addInputTextArea("full","note", "", "note", 255, 25, 2, 1,  "style='width:100%' class='full'");
	#------------------------
	if(isset($_POST['submit']) && $_POST['submit'] =='Update'){
		$value = "status='".$_POST['status']."'";
		$value .= ",note='".addslashes($_POST['iso-note'])."'";
		#
		$pUrl = '';
		if(!empty($action)) {$pUrl.= "&act=".$action."";}
		if(!empty($type)) {$pUrl.= "&type=".$type."";}
		#
		if($clsClassTable->updateOne($pvalTable,$value)){
			header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=UpdateSuccess');			
		}
	}
}
function default_downloadPDF(){
	global $assign_list, $_CONFIG, $clsISO, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	#
	$billing_id = Input::get('billing_id',0);
	if($billing_id > 0){
		if(file_exists(DIR_INCLUDES.'/phpword/autoload.php')){
			require_once(DIR_INCLUDES.'/phpword/autoload.php');
		}
		$options = new \Dompdf\Options();
		$options->set('defaultFont', 'opensans');
		$dompdf = new \Dompdf\Dompdf($options);
		$dompdf->set_option("isPhpEnabled", true);//page
		$dompdf->set_option("isRemoteEnabled", true);
		$dompdf->set_option("isHtml5ParserEnabled", true);
		
		$clsBillingHistory = new BillingHistory();
		$oneItemBilling = $clsBillingHistory->getOne($billing_id,'html_bill,bill_code');
		$html_bill.= html_entity_decode($oneItemBilling['html_bill']);
		
//		echo $html_bill;die;
		$html = '<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
		</head>
		<body>	
		'.$html_bill.'
		</body>
		</html>';

		// Load HTML content 
		$dompdf->loadHtml($html); 		
		// (Optional) Setup the paper size and orientation 
		$dompdf->setPaper('A4', 'portrait'); 
		// Render the HTML as PDF 
		$dompdf->render(); 
		// Output the generated PDF to Browser 
		$dompdf->stream("bill#".$oneItemBilling['bill_code'],array("Attachment" => false));
		exit; die();
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	$pvalTable =intval($core->decryptID($string));
	if($string != '' && $pvalTable==0){
		 header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		 exit();
	}
	$assign_list["pvalTable"] = $pvalTable;
	$clsTable = $clsClassTable->getOneField('clsTable',$pvalTable);
	$action = isset($_GET['action'])?$_GET['action']:"";
	#
	$pUrl = '';
	if(!empty($action)) {
		$pUrl.= '&act='.$action;
	} else {
		$pUrl.= '&clsTable='.$core->encryptID($clsTable);
	}
	#
	if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?admin&mod='.$mod.$pUrl.'&message=DeleteSuccess');
	}
}
function default_print(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Booking";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	
	$string = isset($_GET[$pkeyTable])?$_GET[$pkeyTable]:"";
	$pvalTable =intval($core->decryptID($string));
	$assign_list["pvalTable"] = $pvalTable;
	
	if($string != '' && $pvalTable==0){
		 header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
		 exit();
	}
	$assign_list["booking_id"] = $pvalTable;
}

function default_ajUpdateContactBooking(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page;
	global $core, $clsModule, $clsButtonNav,$oneCommon;
	$clsBooking = new Booking();
	$result = false;
	if(isset($_POST['booking_id']) && $_POST['booking_id'] != ''){
		$value = '';
		$oneItem = $clsBooking->getOne($_POST['booking_id']);
		if(isset($_POST['submit']) && $_POST['submit'] == 'contact'){
			$value = " full_name = '".$_POST['full_name']."', email = '".$_POST['email']."', phone = '".$_POST['phone']."' ";
			$arr_booking_store = unserialize($oneItem['booking_store']);
//			var_dump($booking_store);die;
			$arr_booking_store['birthday'] = $_POST['birthday'];
			$arr_booking_store['birthday_'] = [
				'day'	=>	date('d',strtotime($_POST['birthday'])),
				'month'	=>	date('m',strtotime($_POST['birthday'])),
				'year'	=>	date('Y',strtotime($_POST['birthday'])),
			];
			$arr_booking_store['telephone'] = $_POST['phone'];
			$arr_booking_store['fullname'] = $_POST['full_name'];
			$arr_booking_store['email'] = $_POST['email'];
			$booking_store = serialize($arr_booking_store);
			$value .= ",booking_store='".$booking_store."'";
			
			
		}else if(isset($_POST['submit']) && $_POST['submit'] == 'note'){
			$value = " note='".$_POST['note']."' ";
		}
		
		if ($value != '' && $clsBooking->updateOne($_POST['booking_id'], $value)) {
			$result = true;
		}
	}
	return $result;die();
	
}

function default_ajPaymentsBooking(){
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $core,$clsISO,$dbconn;
	$result = false;
	$clsBooking = new Booking(); $assign_list["clsBooking"] = $clsBooking;	
	$clsTour = new Tour();	$assign_list["clsTour"] = $clsTour;	
	$clsHotel = new Hotel();	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise = new Cruise();	$assign_list["clsCruise"] = $clsCruise;
	$clsVoucher = new Voucher();	$assign_list["clsVoucher"] = $clsVoucher;
	$clsHotelRoom = new HotelRoom();	$assign_list["clsHotelRoom"] = $clsHotelRoom;
	$clsCruiseItinerary = new CruiseItinerary();	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCruiseCabin = new CruiseCabin();	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;	
	$clsBillingHistory = new BillingHistory();

	$clsTourOption = new TourOption();	$assign_list["clsTourOption"] = $clsTourOption;	
	$clsAddOnService = new AddOnService();$assign_list["clsAddOnService"] = $clsAddOnService;
	$booking_id = (int)Input::post('booking_id',0);
	
	$data = [
				'result'	=>	false,
			];
	if($booking_id > 0){
		
		$oneBooking = $clsBooking->getOne($booking_id); $assign_list["oneBooking"] = $oneBooking;
//var_dump($oneBooking);
		$booking_store = unserialize($oneBooking['booking_store']);
		$cart_store = unserialize($oneBooking['cart_store']);
//		var_dump($cart_store);die;
		$assign_list["tour_cart_store"] = (isset($cart_store['TOUR']))?$cart_store['TOUR']:'';
		$assign_list["hotel_cart_store"] = (isset($cart_store['HOTEL']))?$cart_store['HOTEL']:'';
		$assign_list["cruise_cart_store"] = (isset($cart_store['CRUISE']))?$cart_store['CRUISE']:'';
		$assign_list["voucher_cart_store"] = (isset($cart_store['VOUCHER']))?$cart_store['VOUCHER']:'';
		$max_id = $clsBillingHistory->getMaxId(); $assign_list['max_id'] = $max_id;
		
		
		$money = (int)Input::post('money',0); $assign_list['money'] = $money;
		$payment_method = (int)Input::post('payment_method',0);
		$note = Input::post('note','');
		$type = Input::post('type','');
		$payment_term = Input::post('payment_term','');
		$payment_term = ($payment_term !='')?strtotime(str_replace('/','-',$payment_term)):0; $assign_list['payment_term'] = $payment_term;
		
		$sql = "SELECT SUM(bill_money) as deposit FROM ".DB_PREFIX."billing_history WHERE booking_id = '$booking_id'";
		$deposit_bill = $dbconn->getOne($sql); $assign_list['deposit_bill'] = $deposit_bill;

		$balance = $oneBooking['totalgrand'] - $deposit_bill - $money; $assign_list['balance'] = $balance;
		$totalgrand = $oneBooking['totalgrand']; $assign_list['totalgrand'] = $totalgrand;
		
		$max_id = $clsBillingHistory->getMaxId();
		$user_id       = $core->_USER['user_id'];
		if ($type == "PREVIEW"){		
			$assign_list['customer_name'] = $oneBooking['full_name'];
			$assign_list['customer_email'] = $oneBooking['email'];
			$assign_list['customer_phone'] = $oneBooking['phone'];
			$assign_list['checkEdit'] = 1;
			$html_bill = $clsISO->build('bill.tpl');
			$data = [
				'result'	=>	true,
				"html"		=>	$html_bill,
				"billing_id"	=>	$max_id
			];
		}else{
			$bill_code = time();
			$customer_name = Input::post("customer_name",''); $assign_list['customer_name'] = $customer_name;
			$customer_email = Input::post("customer_email",''); $assign_list['customer_email'] = $customer_email;
			$customer_phone = Input::post("customer_phone",''); $assign_list['customer_phone'] = $customer_phone;
			
			$html_bill = $clsISO->build('bill.tpl');
			$field = $clsBillingHistory->pkey.",booking_id,bill_money,payment_method,note,reg_date,payment_term,html_bill,user_id,customer_name,customer_email,customer_phone,bill_code";
			$value = "'".$max_id."','".$_POST['booking_id']."','".$_POST['money']."','".$_POST['payment_method']."','".$_POST['note']."','".time()."','".$payment_term."','".addslashes(trim($html_bill))."','".$user_id."','".$customer_name."','".$customer_email."','".$customer_phone."','".$bill_code."'";
			if($clsBillingHistory->insertOne($field,$value)){
				$data = [
					'result'	=>	true,
					"html"		=>	$html_bill,
					"billing_id"	=>	$max_id
				];
			}
		}
	}
	echo json_encode($data);
}

function default_ajPaymentsBookingDetail(){
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $core,$clsISO,$dbconn;
	$result = false;
	$clsBooking = new Booking(); $assign_list["clsBooking"] = $clsBooking;	
	$clsTour = new Tour();	$assign_list["clsTour"] = $clsTour;	
	$clsHotel = new Hotel();	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise = new Cruise();	$assign_list["clsCruise"] = $clsCruise;
	$clsVoucher = new Voucher();	$assign_list["clsVoucher"] = $clsVoucher;
	$clsHotelRoom = new HotelRoom();	$assign_list["clsHotelRoom"] = $clsHotelRoom;
	$clsCruiseItinerary = new CruiseItinerary();	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCruiseCabin = new CruiseCabin();	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;	
	$clsBillingHistory = new BillingHistory();

	$clsTourOption = new TourOption();	$assign_list["clsTourOption"] = $clsTourOption;	
	$clsAddOnService = new AddOnService();$assign_list["clsAddOnService"] = $clsAddOnService;
	$billing_history_id = (int)Input::post('billing_id',0);
	$data = [
				'result'	=>	false,
			];
	if($billing_history_id > 0){
		$oneItemBilling = $clsBillingHistory->getOne($billing_history_id,'html_bill');
		$data = [
					'result'	=>	true,
					"html"		=>	html_entity_decode($oneItemBilling['html_bill']),
					"billing_id"	=>	$billing_history_id
				];
	}
	
	echo json_encode($data);
}
function default_ajupdateComfirmBilling(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $core,$clsISO,$dbconn;
	$billing_history_id = (int)Input::post('billing_id',0);
	$status = (int)Input::post('status',0);
	$result = false;
	$clsBillingHistory = new BillingHistory();
	if($billing_history_id > 0){
		$oneBillingHistory = $clsBillingHistory->getOne($billing_history_id,"status");
		if($oneBillingHistory && $oneBillingHistory['status'] == 0){
			$clsBillingHistory->updateOne($billing_history_id,"status='".$status."'");
			$result = true;
		}
	}
	return $result;
	
}
function default_addBooking()
{
	global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
	global $clsConfiguration,$clsISO;
    #
	$clsCountry = new _Country();
	$clsTour = new Tour(); 
	$clsTourCat = new TourCategory();
	$clsBlog       = new Blog();
	$clsClassTable = new BlogCategory();
    #
	$user_id       = $core->_USER['user_id'];
	$blogcat_id    = isset($_POST['blogcat_id']) ? intval($_POST['blogcat_id']) : 0;
	$tp            = isset($_POST['tp']) ? $_POST['tp'] : '';
    #
	if ($tp == 'F') {
		$html = '
		<link rel="stylesheet" href="'.URL_JS.'/jquery-easyui/themes/gray/easyui.css?v='.$upd_version.'" type="text/css" media="screen">
		<script type="text/javascript" src="'.URL_JS.'/jquery-easyui/jquery.easyui.min.js?v='.$upd_version.'"></script>
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($blogcat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('booking') . '</h3>
		</div>';
		$html .= '
		<div class="box_content">
			<div class="container-fluid">
				<form method="post" id="frmForm" class="frmform" enctype="multipart/form-data">
					<div class="box_section box_contact">
						<a class="btn btn-primary btn_title" type="button" data-toggle="collapse" data-target="#collapseContact" aria-expanded="true" aria-controls="collapseExample">'.$core->get_Lang('Customer').' ('.$core->get_Lang('contact').') <i class="fa fa-angle-up pull-right"></i></a>
						<div class="box_form collapse in" id="collapseContact" aria-expanded="true">
							<div class="row">
								<div class="col-lg-3">
									<input class="text full required" name="full_name" value="" type="text" placeholder="'.$core->get_Lang('Fullname').'" />
									<label for="">'.$core->get_Lang('Enter 3 letters to search').'</label>
								</div>
								<div class="col-lg-3">
									<input class="text full birthday" name="birthday" value="" type="text" placeholder="'.$core->get_Lang('Birthday').'" />
								</div>
								<div class="col-lg-3">
									<input class="text full required" name="email" value="" type="text" placeholder="'.$core->get_Lang('Email').'" />
									<label for="">'.$core->get_Lang('Must be unique when adding new customers').'</label>
								</div>
								<div class="col-lg-3">
									<input class="text full required" name="phone" value="" type="text" placeholder="'.$core->get_Lang('Phone').'" />
								</div>
								<div class="col-lg-3">
									<select name="country_id" class="iso-selectbox" id="">
										'.$clsCountry->getSelectByCountry().'
									</select>
								</div>					
								<div class="col-lg-6">
									<input class="text full" name="address" value="" type="text" placeholder="'.$core->get_Lang('Address').'" />
								</div>
							</div>
						</div>
					</div>
					<div class="box_section box_product_service">
						<span class="text_error" hidden>'.$core->get_Lang('You have not selected a product/service').'</span>
						<a class="btn btn-primary btn_title" type="button" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseExample">'.$core->get_Lang('Inventory').'<i class="fa fa-angle-up pull-right"></i></a>
						<div class="collapse in" id="collapseProduct" aria-expanded="true">
							<div class="box_total_price">'.$core->get_Lang('Total').': <span class="total_price"><span id="total_price">0</span> '.$clsISO->getShortRateText().'</span><input id="inp_total_price" type="hidden" value="0"/></div>
							<div class="box_form">
								<div class="row">
									<div class="col-lg-3">
										<select class="form-control iso-selectbox" onchange="show_option_product(this)" name="product_group">
											<option value="tour">'.$core->get_Lang('Tour').'</option>
											<option value="hotel">'.$core->get_Lang('Hotel').'</option>
											<option value="cruise">'.$core->get_Lang('Cruise').'</option>
											<option value="combo">'.$core->get_Lang('Combo').'</option>
											<option value="voucher">'.$core->get_Lang('Voucher').'</option>
										</select>
									</div>							
									<div id="box_option_product">

									</div>
								</div>
								<div id="box_booking">

								</div>
							</div>
						</div>						
					</div>
					<div class="box_section box_note_booking">
						<a class="btn btn-primary btn_title" type="button" data-toggle="collapse" data-target="#collapseNoteBooking" aria-expanded="true" aria-controls="collapseExample">'.$core->get_Lang('Special Requests').'<i class="fa fa-angle-up pull-right"></i></a>
						<div class="box_form collapse in" id="collapseNoteBooking" aria-expanded="true">
							<div class="row">
								<div class="col-lg-12">
									<textarea class="txt_note" name="note" id="" cols="30" rows="10" placeholder="'.$core->get_Lang('Special Requests').'"></textarea>
								</div>	
							</div>
						</div>
					</div>
					<div class="box_section box_info_price_booking">
						<a class="btn btn-primary btn_title" type="button" data-toggle="collapse" data-target="#collapseInfoPriceBooking" aria-expanded="true" aria-controls="collapseExample">'.$core->get_Lang('Billing Information').'<i class="fa fa-angle-up pull-right"></i></a>
						<div class="collapse in" id="collapseInfoPriceBooking" aria-expanded="true">
							<div class="box_form box_form_price">
								<div class="row">
									<div class="col-lg-12">
										<div class="box_billing">
											<label class="lbl_billing">'.$core->get_Lang('Total').'</label>
											<span class="price"><span id="price_total">0</span> '.$clsISO->getShortRateText().'</span>
											<input type="hidden" id="inp_price_total" name="price_total" value="0" />
										</div>
									</div>	
									<div class="col-lg-12">
										<div class="box_billing price_deposit">
											<label class="lbl_billing">'.$core->get_Lang('Deposit').'</label>
											<span class="price"><span id="price_deposit">0</span> '.$clsISO->getShortRateText().'</span>
											<input type="hidden" id="inp_price_deposit" name="price_deposit" value="0" />
										</div>									
									</div>	
									<div class="col-lg-12">
										<div class="box_billing">
											<label class="lbl_billing">'.$core->get_Lang('Final Payment').'</label>
											<span class="price"><span id="price_final_payment">0</span> '.$clsISO->getShortRateText().'</span>
											<input type="hidden" id="inp_price_final_payment" name="price_final_payment" value="0" />
										</div>									
									</div>
									<div class="col-lg-12">
										<div class="box_billing mb0">
											<label class="lbl_billing lbl_total_payment">'.$core->get_Lang('Total payment').'</label>
											<span class="price"><span id="price_total_payment">0</span> '.$clsISO->getShortRateText().'</span>
											<input type="hidden" id="inp_price_total_payment" name="price_total_payment" value="0" />
										</div>									
									</div>	
								</div>
							</div>							
							<div class="payment_tab">
								<div class="payment-choice">
									<input type="radio" class="chkPayment" name="payment_method" checked="checked" value="1">
									<span class="lbl_pay">'.$core->get_Lang('Direct payment').'</span>
								</div>
								<div class="payment-choice">
									<input type="radio" class="chkPayment" name="payment_method" checked="checked" value="2">
									<span class="lbl_pay">'.$core->get_Lang('Transfer payments / ATM').'</span>
								</div>
								<div class="payment-choice">
									<input type="radio" class="chkPayment" name="payment_method" checked="checked" value="3">
									<span class="lbl_pay">'.$core->get_Lang('Payment by card / VNPAY').'</span>
								</div>
								<div class="payment-choice">
									<input type="radio" class="chkPayment" name="payment_method" checked="checked" value="4">
									<span class="lbl_pay">'.$core->get_Lang('Pay with OnePAY').'</span>
								</div>
							</div>
						</div>
						
					</div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" blogcat_id="' . $blogcat_id . '" class="btn btn-primary btnClickToSubmitBooking">
				<i class="icon-ok icon-white"></i><span>' . $core->get_Lang('update') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>Đóng lại</span> </button>		
		</div>';
		echo ($html);
		die();
	} elseif ($tp == 'S') {
		$titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
		$slugPost  = $clsISO->replaceSpace2($titlePost);
		$introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
		$contentPost = isset($_POST['content'])?addslashes($_POST['content']):'';
		$image_banner = isset($_POST['image_banner'])?addslashes($_POST['image_banner']):'';
        #
		if (intval($blogcat_id) == 0) {
			if ($clsClassTable->getAll("slug='$slugPost'")!='') {
				echo '_EXIST';
				die();
			} else {
				$listTable=$clsClassTable->getAll("1=1", $clsClassTable->pkey.",order_no");
				for ($i = 0; $i <= count($listTable); $i++) {
					$order_no=$listTable[$i]['order_no'] + 1;
					$clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey],"order_no='".$order_no."'");
				}
				$fx = "$clsClassTable->pkey,user_id,user_id_update,title,slug,intro,content,image,order_no,reg_date,upd_date";
				$vx = "'" . $clsClassTable->getMaxID() . "','$user_id','$user_id','$titlePost','$slugPost','" . addslashes($introPost) . "','".addslashes($contentPost)."','" . addslashes($image_banner) . "'";
				$vx .= ",'1','" . time() . "','" . time() . "'";
                #
				if ($clsClassTable->insertOne($fx, $vx)) {
					echo '_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		} else {
			if ($clsClassTable->getAll("slug='$slugPost' and blogcat_id <> '$blogcat_id'")!='') {
				echo '_EXIST';
				die();
			} else {
				$set = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='" . addslashes($introPost) . "',content='".addslashes($contentPost)."',image='".addslashes($image_banner)."',upd_date='" . time() . "',user_id_update='" . $user_id . "'";
				if ($clsClassTable->updateOne($blogcat_id, $set)) {
					echo '_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		}
	}
}
function default_handler_filter_objects(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsTour = new Tour(); 
	$clsTourCat = new TourCategory();
	#
	$product_type = Input::post('product_type');
	#
	$html = '';
	if($product_type=='tour'){
		$html = '<div class="col-lg-3">
					<select name="cat_id" class="iso-selectbox" id="option_cat">
						<option value="0">'.$core->get_Lang('Product Type').'</option>
						'.$clsTourCat->makeSelectboxOption(0,0,false,false,false).'
					</select>
				</div>						
				<div class="col-lg-3">
					<div class="box_search_product">
						<input id="searchtour" placeholder="'.$core->get_Lang('Name product').'" type="text" class="text" autocomplete="off" />
						<div class="autosugget" id="autosugget">
							<ul class="HTML_sugget" style="max-height: 90px"></ul>
							<div class="clearfix"></div>
							<a class="close_Div">'.$core->get_Lang('close').'</a>
						</div>
					</div>
					<label for="">'.$core->get_Lang('Enter 3 letters to search').'</label>
				</div>';
	} else if($product_type=='hotel'){
		$clsCountry = new Country();
		$html = '<div class="col-lg-3">
					<select class="form-control slb_Country_Id iso-selectbox filter_item_search" column="country_id" onChange="get_select_city(this)" data-width="100%" data-placeholder="'.$core->get_Lang('Country').'"  id="option_country">
						'.$clsCountry->makeSelectHotelOption(0).'
					</select>
				</div>
				<div class="col-lg-3">
					<select class="form-control iso-selectbox slb_City_Id filter_item_search" id="option_city" column="city_id" data-width="100%" data-placeholder="'.$core->get_Lang('City').'"></select>
				</div>						
				<div class="col-lg-3">
					<div class="box_search_product">
						<input id="searchhotel" placeholder="'.$core->get_Lang('Name product').'" type="text" class="text" autocomplete="off" />
						<div class="autosugget" id="autosugget" style="width:100%">
							<ul class="HTML_sugget" style="max-height: 90px"></ul>
							<div class="clearfix"></div>
							<a class="close_Div" style="background-position: 41.6% center">'.$core->get_Lang('close').'</a>
						</div>
					</div>
					<label for="">'.$core->get_Lang('Enter 3 letters to search').'</label>
				</div>';
	} else if($product_type=='cruise'){
		$clsCruiseCat = new CruiseCat();
		$html = '<div class="col-lg-3">
					<select name="cruise_cat_id" class="iso-selectbox" id="cruise_cat">
						'.$clsCruiseCat->makeSelectboxOption(0,0).'
					</select>
				</div>						
				<div class="col-lg-3">
					<div class="box_search_product">
						<input id="searchcruise" placeholder="'.$core->get_Lang('Name product').'" type="text" class="text" autocomplete="off" />
						<div class="autosugget" id="autosugget">
							<ul class="HTML_sugget" style="max-height: 90px"></ul>
							<div class="clearfix"></div>
							<a class="close_Div">'.$core->get_Lang('close').'</a>
						</div>
					</div>
					<label for="">'.$core->get_Lang('Enter 3 letters to search').'</label>
				</div>';
	} else if($product_type=='combo'){
		$html = '<div class="col-lg-3">
					<div class="box_search_product">
						<input id="searchcombo" placeholder="'.$core->get_Lang('Name product').'" type="text" class="text" autocomplete="off" />
						<div class="autosugget" id="autosugget">
							<ul class="HTML_sugget" style="max-height: 90px"></ul>
							<div class="clearfix"></div>
							<a class="close_Div">'.$core->get_Lang('close').'</a>
						</div>
					</div>
					<label for="">'.$core->get_Lang('Enter 3 letters to search').'</label>
				</div>';
	} else if($product_type=='voucher'){
		$clsVoucherCat = new VoucherCat();
		$html = '<div class="col-lg-3">
					<select name="voucher_cat_id" class="iso-selectbox" id="voucher_cat">
						'.$clsVoucherCat->makeSelectboxOption(0,0).'
					</select>
				</div>						
				<div class="col-lg-3">
					<div class="box_search_product">
						<input id="searchvoucher" placeholder="'.$core->get_Lang('Name product').'" type="text" class="text" autocomplete="off" />
						<div class="autosugget" id="autosugget">
							<ul class="HTML_sugget" style="max-height: 90px"></ul>
							<div class="clearfix"></div>
							<a class="close_Div">'.$core->get_Lang('close').'</a>
						</div>
					</div>
					<label for="">'.$core->get_Lang('Enter 3 letters to search').'</label>
				</div>';
	}
	// Return
	echo @json_encode(array(
		'html' => $html
	)); die();
}
function default_load_customer(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsProfile = new Profile(); 
	#
	$results = array();
	$keyword = Input::post('q','');
	$page = Input::post('page',1);
	$perpage = Input::post("rows",10);
	$start = ($page - 1)*$perpage;
	$cond = "is_trash=0";
	if(!empty($keyword)){
		$cond .= " and (first_name like '%".$keyword."%' or last_name like '%".$keyword."%' or full_name like '%".$keyword."%')";
	}
	$limit = " LIMIT $start,$perpage";
	$orderBy = " reg_date desc";
	$list_items = $clsProfile->getAll($cond . " order by " . $orderBy.$limit,$clsProfile->pkey.',full_name,first_name,last_name,email,phone,birthday,country_id,address' );
	$html = '';
	$results['total'] = $clsProfile->countItem($cond);
	if(!empty($list_items)){
		foreach($list_items as $key=>$val){
			$birthday = '';
			if($val['birthday'] > 0){
				$birthday = date('d/m/Y',$val['birthday']);
			}
			$full_name = $clsProfile->getFullname($val['profile_id']);
			$results['rows'][] = [
				'add' 		=> '<button type="button" class="btn btn-xxs btn-success" onclick="addCustomer(this)" data-profile_id="'.$val['profile_id'].'" data-full_name="'.$full_name.'" data-phone="'.$val['phone'].'" data-address="'.$val['address'].'" data-birthday="'.$birthday.'" data-email="'.$val['email'].'" data-country_id="'.$val['country_id'].'">+</button>',
				'id' 		=> $val['profile_id'],
				'name' 		=> $clsProfile->getFullname($val['profile_id']),
				'email' 	=> $val['email'],
				'address' 	=> $val['address'],
				'phone' 	=> $val['phone'],
			];
		}
	}
	// Return
	echo json_encode($results); die();
	
	
}
function default_load_customer2(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsProfile = new Profile(); 
	#
	$results = array();
	$keyword = Input::post('keyword');
	$cond = "is_trash=0";
	if(!empty($keyword)){
		$cond .= " and (first_name like '%".$keyword."%' or last_name like '%".$keyword."%' or full_name like '%".$keyword."%')";
	}
	$orderBy = " reg_date desc";
	$list_items = $clsProfile->getAll($cond . " order by " . $orderBy,$clsProfile->pkey.',full_name,first_name,last_name,email,phone,birthday,country_id,address' );
	$html = '';
	$results['total'] = $clsProfile->countItem($cond);
//	var_dump($list_items);die;
	if(!empty($list_items)){
		foreach($list_items as $key=>$val){
			$birthday = '';
			if($val['birthday'] > 0){
				$birthday = date('d/m/Y',$val['birthday']);
			}
			/*$html.='
			<li onclick="addCustomer(this)" data-full_name="'.$clsProfile->getFullname($val['profile_id'], $val).'" tp="'.$tp.'" data-email="'.$val['email'].'" data-birthday="'.$birthday.'" data-country_id="'.$val['country_id'].'" data-address="'.$val['address'].'" data-phone="'.$val['phone'].'">
				<a href="javascript:void(0);" title="Click để chọn khách hàng này">'.$clsProfile->getFullname($val['profile_id'], $val).'</a>	
			</li>';*/
			$results['rows'][] = [
				'id' 		=> $val['profile_id'],
				'name' 		=> $clsProfile->getFullname($val['profile_id']),
				'address' 	=> $val['address'],
				'phone' 	=> $val['phone'],
				'email' 	=> $val['email']
			];
		}
	}
	// Return
	echo json_encode($results); die();
	
	
}
function default_load_search_product(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$clsTour = new Tour(); 
	$clsHotel = new Hotel(); 
	$clsTourCat = new TourCategory();
	$clsCruise = new Cruise();
	$clsCombo = new Combo();
	$clsVoucher = new Voucher();
	#
	$results = array();
	$keyword = Input::post('keyword');
	$cat_id = (int) Input::post('cat_id', 0);
	$country_id = (int) Input::post('country_id', 0);
	$city_id = (int) Input::post('city_id', 0);
	$cruise_cat = (int) Input::post('cruise_cat', 0);
	$voucher_cat = (int) Input::post('voucher_cat', 0);
	$tour_select = Input::post('tour_select', '');
	$hotel_select = Input::post('hotel_select', '');
	$cruise_select = Input::post('cruise_select', '');
	$combo_select = Input::post('combo_select', '');
	$voucher_select = Input::post('voucher_select', '');
	$product_type = Input::post('product_type', '');
	#
	if($product_type == 'tour'){
		$cond = "is_trash=0 and is_online=1";
		if($cat_id > 0) {
			$cond .= " and (cat_id='{$cat_id}' or list_cat_id like '%|{$cat_id}|%')";
		}
		$tour_select = implode(',',$tour_select);
		if($tour_select != ''){
			$cond .= " and tour_id NOT IN (".$tour_select.")";
		}
		if(!empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond .= " and (slug like '%{$slug}%' or trip_code like '%{$keyword}%')";
		}
		$field = "{$clsTour->pkey},trip_code,title";
		$list_items = $clsTour->getAll($cond." order by reg_date DESC", $field);
		$html = '';
		if(!empty($list_items)){
			foreach($list_items as $key=>$val){
				$tour_id = $val[$clsTour->pkey];
				$html.='
				<li onclick="addBookingTour(this)" data-title="'.$clsTour->getTitle($tour_id, $val).'" tp="'.$tp.'" data-tour_id="'.$tour_id.'" type="add">
					<a href="javascript:void(0);" title="Click để chọn tour này">'.$clsTour->getTitle($tour_id, $val).'</a>	
				</li>';
			}
		}else{
			$html = "_EMPTY";
		}
		// Return
		echo $html; die();
	}
	if($product_type == 'hotel'){
		$cond = "is_trash=0 and is_online=1";
		if($country_id > 0){
			$cond .= " and country_id = '".$country_id."'";
		}
		if($city_id > 0){
			$cond .= " and city_id = '".$city_id."'";
		}
		$hotel_select = implode(',',$hotel_select);
		if($hotel_select != ''){
			$cond .= " and hotel_id NOT IN (".$hotel_select.")";
		}
		if(!empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond .= " and (slug like '%{$slug}%' or title like '%{$keyword}%')";
		}
		$cond .= " AND hotel_id IN (SELECT hotel_id FROM default_hotel_room WHERE is_trash=0) ";
		$field = "{$clsHotel->pkey},title";
		$list_items = $clsHotel->getAll($cond." order by reg_date DESC", $field);
		$html = '';
		if(!empty($list_items)){
			foreach($list_items as $key=>$val){
				$hotel_id = $val[$clsHotel->pkey];
				$html.='
				<li onclick="addBookingHotel(this)" data-title="'.$clsHotel->getTitle($hotel_id, $val).'" tp="'.$tp.'" data-hotel_id="'.$hotel_id.'" type="add">
					<a href="javascript:void(0);" title="Click để chọn hotel này">'.$clsHotel->getTitle($hotel_id, $val).'</a>	
				</li>';
			}
		}else{
			$html = "_EMPTY";
		}
		echo $html; die();
	}
	if($product_type == 'cruise'){
		$cond = "is_trash=0 and is_online=1";
		if($cruise_cat > 0){
			$cond .= " and cruise_cat_id = '".$cruise_cat."'";
		}
		$cruise_select = implode(',',$cruise_select);
		if($cruise_select != ''){
			$cond .= " and cruise_id NOT IN (".$cruise_select.")";
		}
		if(!empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond .= " and (slug like '%{$slug}%' or title like '%{$keyword}%')";
		}
		$field = "{$clsCruise->pkey},title";
		$list_items = $clsCruise->getAll($cond." order by reg_date DESC", $field);
		$html = '';
		if(!empty($list_items)){
			foreach($list_items as $key=>$val){
				$cruise_id = $val[$clsCruise->pkey];
				$html.='
				<li onclick="addBookingCruise(this)" data-title="'.$clsCruise->getTitle($cruise_id, $val).'" tp="'.$tp.'" data-cruise_id="'.$cruise_id.'" type="add">
					<a href="javascript:void(0);" title="Click để chọn cruise này">'.$clsCruise->getTitle($cruise_id, $val).'</a>	
				</li>';
			}
		}else{
			$html = "_EMPTY";
		}
		echo $html; die();
	}
	if($product_type == 'combo'){
		$cond = "`is_trash`=0 and `is_online`=1";
		$combo_select = implode(',',$combo_select);
		if($combo_select != ''){
			$cond .= " and combo_id NOT IN (".$combo_select.")";
		}
		if(!empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond .= " and (slug like '%{$slug}%' or title like '%{$keyword}%')";
		}
		$field = "{$clsCombo->pkey},title,booking_date_from,booking_date_to,travel_date_from,travel_date_to";
		$list_items = $clsCombo->getAll($cond." order by reg_date DESC", $field);
		$html = '';
		if(!empty($list_items)){
			foreach($list_items as $key=>$val){
				$combo_id = $val[$clsCombo->pkey];
				$html.='
				<li onclick="addBookingCombo(this)" data-title="'.$clsCombo->getTitle($combo_id, $val).'" tp="'.$tp.'" data-combo_id="'.$combo_id.'" type="add">
					<a href="javascript:void(0);" title="Click để chọn combo này">'.$clsCombo->getTitle($combo_id, $val).'</a>	
				</li>';
			}
		}else{
			$html = "_EMPTY";
		}
		echo $html; die();
	}
	if($product_type == 'voucher'){
		$cond = "`is_trash`=0 and `is_online`=1";
		$voucher_select = implode(',',$voucher_select);
		if($voucher_select != ''){
			$cond .= " and voucher_id NOT IN (".$voucher_select.")";
		}
		if($voucher_cat > 0) {
			$cond .= " and (cat_id='{$voucher_cat}' or list_cat_id like '%|{$voucher_cat}|%')";
		}
		if(!empty($keyword)){
			$slug = $core->replaceSpace($keyword);
			$cond .= " and (slug like '%{$slug}%' or title like '%{$keyword}%')";
		}
		$field = "{$clsVoucher->pkey},title,cat_id";
		$list_items = $clsVoucher->getAll($cond." order by reg_date DESC", $field);
		$html = '';
		if(!empty($list_items)){
			foreach($list_items as $key=>$val){
				$voucher_id = $val[$clsVoucher->pkey];
				$html.='
				<li onclick="addBookingVoucher(this)" data-title="'.$clsVoucher->getTitle($voucher_id, $val).'" tp="'.$tp.'" data-voucher_id="'.$voucher_id.'" type="add">
					<a href="javascript:void(0);" title="Click để chọn voucher này">'.$clsVoucher->getTitle($voucher_id, $val).'</a>	
				</li>';
			}
		}else{
			$html = "_EMPTY";
		}
		echo $html; die();
	}
	
}
//add html tour
function default_addBookingTour(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id;
	$clsTour = new Tour(); 
	$clsTourOption = new TourOption();
    $clsAddOnService = new AddOnService();
	$tour_id = (int) Input::post('tour_id', 0);
	$oneTour = $clsTour->getOne($tour_id,'tour_option,title,deposit');
	
	
	#
	$lstServiceID=$clsTour->getListService($tour_id);
    $lstService = $clsAddOnService->getAll("is_trash=0 and is_online=1 and addonservice_id IN($lstServiceID) order by order_no asc",$clsAddOnService->pkey.',title');
	$html_serviceOption = '';
	if($lstService){
		$html_serviceOption .= '<div class="collapseServiceTour box_services_tour collapse" id="collapseServiceTour'.$tour_id.'">';
		foreach($lstService as $key => $value){
//			$html_serviceOption .= '<option value="'.$value['addonservice_id'].'">'.$value['title'].'</option>';
			$html_serviceOption .= '
			<div class="item_service"> <input type="checkbox" name="service_id" value="'.$value['addonservice_id'].'" data-tour_id="'.$tour_id.'" data-type="tour" onclick="addServicesBooking(this)" /> <span class="title_service">'.$value['title'].'</span></div>';
		}
		$html_serviceOption .= '</div>';
	}
	
	#
	$lstTourOption = $oneTour['tour_option'];
    $lstOption = array();	
	$html_tourOption = '<option value="0">'.$core->get_Lang('Select option').'</option>';
    if($lstTourOption != '' && $lstTourOption != '0'){
        $TMP = explode(',',$lstTourOption);
        for($i=0; $i<count($TMP); $i++){
            if(!in_array($TMP[$i],$lstOption)){
                $lstOption[] = $TMP[$i];
				$html_tourOption .= '<option value="'.$TMP[$i].'">'.$clsTourOption->getTitle($TMP[$i]).'</option>';
            }
        }
    }	
	
	#
	$str_check_in_book = time()+(24*60*60);
	$promotion= 0 ;
	$now_day = strtotime(date('m/d/Y'));
	$duration = $clsTour->getTripDuration($tour_id);

	if(_IS_PROMOTION==1){		
		$promotion=$clsISO->getPromotion($tour_id,'Tour',$now_day,$str_check_in_book,$type_check='get_more_info');
		$promotion=$promotion['discount_value'];
		$promotion = !empty($promotion)?$promotion:0; 
	}
	
	$html = '<div class="box_info_booking" data-type="tour" id="tour_'.$tour_id.'">
				<input type="hidden" class="promotion" value="'.$promotion.'"/>
				<input type="hidden" class="tour_select" value="'.$tour_id.'"/>
				<input type="hidden" class="deposit" value="'.$oneTour['deposit'].'"/>
				<input type="hidden" name="price_booking" value=""/>
				<div class="box_head_book">
					<p class="title_tour">'.'<span class="lbl_title">['.$core->get_lang('Travel tour').']</span> '.$oneTour['title'].'</p>
					<div class="box_button">
						<p class="price_box">'.$core->get_Lang('Temporary').': <span class="price_tmp">0</span> '.$clsISO->getShortRateText().'</p>
						<button class="btn_del" onclick="del_product_booking(this,\'tour\','.$tour_id.')" type="button"></button>
					</div>
				</div>
				<div class="row box_content_book">
					<div class="col-lg-3 box_content_left">
						<div class="form-item">
							<label for="">'.$core->get_Lang('Departure').'</label>
							<input class="datepicker required form-control" name="departure" type="text" value="" placeholder="dd/mm/yyyy" autocomplete="off"/>	
							<span class="text_duration">'.$duration.'</span>
						</div>
						<div class="form-item box_select2">
							<label for="">'.$core->get_Lang('Tour option').'</label>
							<select class="required iso-selectbox" name="tour_option" onchange="addPriceByOption(this)" data-tour_id="'.$tour_id.'">
								'.$html_tourOption.'
							</select>
						</div>
						<div class="box_price_by_option"></div>';
	if($html_serviceOption != ''){
		$html .= '	</div>
						<div class="col-lg-9 box_content_right">
							<label for="">'.$core->get_Lang('Services bonus').'</label>
							<!--<select name="ServicesBonus" class="changeServicesBonus" data-type="tour" data-tour_id="'.$tour_id.'">
								<option value="">'.$core->get_Lang('Select Services').'</option>
								'.$html_serviceOption.'
							</select>-->
							<div class="services_bonus" data-toggle="collapse" data-target="#collapseServiceTour'.$tour_id.'" aria-expanded="false" aria-controls="collapseExample">'.$core->get_Lang('Select Services').'<i class="fa fa-angle-down pull-right"></i></div>
							'.$html_serviceOption.'
							<div class="lst_service_bonus" id="lst_service_bonus_'.$tour_id.'">

							</div>
						</div>
					</div>';
	}	
	$html .= '</div>';
	echo $html; die();
}
//add html hotel
function default_addBookingHotel(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id;
	$clsHotel = new Hotel(); 
	$hotel_id = (int) Input::post('hotel_id', 0);
	$oneHotel = $clsHotel->getOne($hotel_id,'title');
	$clsHotelRoom = new HotelRoom();
	#
	$max_adult=$clsHotel->getMaxAdult($hotel_id);
	$max_child=$clsHotel->getMaxChild($hotel_id);
	$html_hotelRoom = '';
	$lstHotelRoomAll=array();
	$lstHotelRoom=$clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and price >0 order by price ASC",$clsHotelRoom->pkey.',title,image,bed_option,footage,number_adult');
	
	foreach($lstHotelRoom as $key => $value){
		$html_hotelRoom .='<option value="'.$value['hotel_room_id'].'">'.$value['title'].'</option>';
	}
	
	$lstHotelRoom2=$clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' and price=0 order by hotel_room_id ASC",$clsHotelRoom->pkey);
	foreach($lstHotelRoom2 as $key => $value){
		$html_hotelRoom .='<option value="'.$value['hotel_room_id'].'">'.$value['title'].'</option>';
	}
		
	
	$html = '<div class="box_info_booking" data-type="hotel" id="hotel_'.$hotel_id.'">
				<input type="hidden" class="hotel_select" value="'.$hotel_id.'"/>
				<input type="hidden" name="price_booking" value=""/>
				<div class="box_head_book">
					<p class="title_tour">'.'<span class="lbl_title">['.$core->get_lang('Hotel').']</span> '.$oneHotel['title'].'</p>
					<div class="box_button">
						<p class="price_box">'.$core->get_Lang('Temporary').': <span class="price_tmp">0</span> '.$clsISO->getShortRateText().'</p>
						<button class="btn_del" onclick="del_product_booking(this,\'hotel\','.$hotel_id.')" type="button"></button>
					</div>
				</div>
				<div class="row box_content_book">
					<div class="col-lg-3 box_content_left">
						<div class="form-item">
							<label for="">'.$core->get_Lang('Check in').'</label>
							<input class="datepicker required form-control" onchange="loadTotalPrice(this,\'hotel\','.$hotel_id.')" name="check_in" type="text" value="" placeholder="dd/mm/yyyy" autocomplete="off"/>										
						</div>
						<div class="form-item">
							<label for="">'.$core->get_Lang('Check out').'</label>
							<input class="datepicker required form-control" onchange="loadTotalPrice(this,\'hotel\','.$hotel_id.')" name="check_out" type="text" value="" placeholder="dd/mm/yyyy" autocomplete="off"/>										
						</div>
						<div class="box_price_by_option">';
					if($max_adult && $max_adult > 0){
						$html .= '<div class="form-item adult-child">
									<label for="">'.$core->get_Lang('Adult').'</label>
									<input class="text full required" name="number_adult" value="" min="1" max="'.$max_adult.'" type="number" placeholder="" />			
								</div>';
					}
					if($max_child && $max_child > 0){
						$html .= '<div class="form-item adult-child">
								<label for="">'.$core->get_Lang('Child').'</label>
								<input class="text full required" name="number_child" value="" min="1" max="'.$max_child.'" type="number" placeholder="" />			
							</div>';
					}					
				$html .= '</div>';
	if($html_hotelRoom != ''){
		$html .= '	</div>
						<div class="col-lg-9 box_content_right">
							<label for="">'.$core->get_Lang('Room types').'</label>
							<select name="HotelRoom" class="changeServicesBonus required iso-selectbox" data-hotel_id="'.$hotel_id.'">
								<option value="">'.$core->get_Lang('Select Service').'</option>
								'.$html_hotelRoom.'
							</select>
							<div class="lst_service_bonus" id="lst_hotel_room_'.$hotel_id.'">

							</div>
						</div>
					</div>';
	}	
	$html .= '</div>';
	echo $html; die();
}
//add html cruise
function default_addBookingCruise(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$clsConfiguration,$dbconn;
	$clsCruise = new Cruise(); 
	$clsCruiseCabin = new CruiseCabin();
	$clsCruiseItinerary = new CruiseItinerary();
	$cruise_id = (int) Input::post('cruise_id', 0);
	$oneCruise = $clsCruise->getOne($cruise_id,'title');
	#
	$max_adult=$clsCruise->getMaxAdult($cruise_id);
	$max_child = 2;
	#
	$departure_date_month = date('m',strtotime("+1 day"));
	$assign_list['departure_date_month']=$departure_date_month; 
	$lstSeason=$clsConfiguration->getAll("setting='high_season_month' and value like '%".$departure_date_month."%' limit 0,1");
	if(!empty($lstSeason)){
		$season='high';
	}else{
		$season='low';
	}
	
	/*$lstItinerary_cruise = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' order by order_no asc limit 0,1",$clsCruiseItinerary->pkey);
	$cruise_itinerary_id=$lstItinerary_cruise[0][$clsCruiseItinerary->pkey];*/
	#
	$SQL = "SELECT MIN(price) FROM ".DB_PREFIX."cruise_season_price WHERE price > 0 and cruise_id='$cruise_id' and season ='$season'";
	$price_check= $dbconn->GetOne($SQL);
	#
	$sql_cabin="SELECT cruise_itinerary_id,cruise_cabin_id,group_size_id FROM ".DB_PREFIX."cruise_season_price WHERE price = '$price_check' and cruise_id='$cruise_id' and season ='$season'";
	$cabin=$dbconn->GetAll($sql_cabin);
	$cruise_itinerary_id=$cabin[0]['cruise_itinerary_id'];
	#
	$html_cruiseCabin = '';
	$lstCruiseCabinID=$clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' and cruise_cabin_id IN (SELECT cruise_cabin_id FROM ".DB_PREFIX."cruise_season_price WHERE cruise_itinerary_id='$cruise_itinerary_id' and season='$season')",$clsCruiseCabin->pkey.',price,title');
	
	foreach($lstCruiseCabinID as $key => $value){
		$html_cruiseCabin .= '<option value="'.$value['cruise_cabin_id'].'">'.$value['title'].'</option>';
	}
	
	$lstItinerary_search = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' order by order_no asc",$clsCruiseItinerary->pkey.',cruise_id,number_day');
	$htmlItinerary = '';
	foreach($lstItinerary_search as $key=> $value){
		$htmlItinerary = '<option value="'.$value['cruise_itinerary_id'].'">'.$clsCruiseItinerary->getTitleDay($value['cruise_itinerary_id'],$value).'</option>';
	}
	$duration = $clsCruiseItinerary->makeSelectTripDurationNew($lstItinerary_search[0]['cruise_itinerary_id']);
	$html_duration = '';
	if($duration != ''){
		$html_duration = '<span class="text_duration">'.$duration.'</span>';
	}
		
	#
	$html = '<div class="box_info_booking" data-type="cruise" id="cruise_'.$cruise_id.'">
				<input type="hidden" class="cruise_select" value="'.$cruise_id.'"/>
				<input type="hidden" name="price_booking" value=""/>
				<div class="box_head_book">
					<p class="title_tour">'.'<span class="lbl_title">['.$core->get_lang('Cruise').']</span> '.$oneCruise['title'].'</p>
					<div class="box_button">
						<p class="price_box">'.$core->get_Lang('Temporary').': <span class="price_tmp">0</span> '.$clsISO->getShortRateText().'</p>
						<button class="btn_del" onclick="del_product_booking(this,\'cruise\','.$cruise_id.')" type="button"></button>
					</div>
				</div>
				<div class="row box_content_book">
					<div class="col-lg-3 box_content_left">';
	if($htmlItinerary != ''){
		$html .= '<div class="form-item">
					<label for="">'.$core->get_Lang('Itinerary').'</label>
					<select class="form-control cruise_itinerary required iso-selectbox" name="cruise_itinerary_id" id="seclect_cruise_itinerary_id" style="padding-right:25px">'.$htmlItinerary.'</select>	
				</div>';
	}
	
	$html .= '<div class="form-item">
					<label for="">'.$core->get_Lang('Departure').'</label>
					<input class="datepicker required form-control" name="departure_date" type="text" value="" placeholder="dd/mm/yyyy" autocomplete="off"/>	
					'.$html_duration.'									
				</div>';
	if($html_cruiseCabin != ''){
		$html .= '	</div>
						<div class="col-lg-9 box_content_right">
							<label for="">'.$core->get_Lang('Cruise cabin').'</label>
							<select name="CruiseCabin" class="changeServicesBonus required iso-selectbox" data-cruise_id="'.$cruise_id.'">
								<option value="">'.$core->get_Lang('Select Cabin').'</option>
								'.$html_cruiseCabin.'
							</select>
							<div class="lst_service_bonus" id="lst_cruise_cabin_'.$cruise_id.'">

							</div>
						</div>
					</div>';
	}	
	$html .= '</div>';
	echo $html; die();
}
//add html combo
function default_addBookingCombo(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$clsConfiguration;
	$clsCombo = new Combo(); 
	$clsAddOnService = new AddOnService();
	$combo_id = (int) Input::post('combo_id', 0);
	$oneCombo = $clsCombo->getOne($combo_id,'title,list_service');
	#
	#
	$lstServiceID=$clsCombo->getListService($combo_id,$oneCombo);
    $lstService = $clsAddOnService->getAll("is_trash=0 and is_online=1 and addonservice_id IN($lstServiceID) order by order_no asc",$clsAddOnService->pkey.',title');
	/*$html_serviceOption = '';
	if($lstService){
		foreach($lstService as $key => $value){
			$html_serviceOption .= '<option value="'.$value['addonservice_id'].'">'.$value['title'].'</option>';
		}
	}*/	
	$html_serviceOption = '';
	if($lstService){
		$html_serviceOption .= '<div class="collapseServiceTour box_services_tour collapse" id="collapseServiceCombo'.$combo_id.'">';
		foreach($lstService as $key => $value){
//			$html_serviceOption .= '<option value="'.$value['addonservice_id'].'">'.$value['title'].'</option>';
			$html_serviceOption .= '
			<div class="item_service"> <input type="checkbox" name="service_id" value="'.$value['addonservice_id'].'" data-combo_id="'.$combo_id.'" data-type="combo" onclick="addServicesBooking(this)" /> <span class="title_service">'.$value['title'].'</span></div>';
		}
		$html_serviceOption .= '</div>';
	}
	
	$html = '<div class="box_info_booking" data-type="combo" id="combo_'.$combo_id.'">
				<input type="hidden" class="combo_select" value="'.$combo_id.'"/>
				<input type="hidden" name="price_booking" value=""/>
				<div class="box_head_book">
					<p class="title_tour">'.'<span class="lbl_title">['.$core->get_lang('Combo').']</span> '.$oneCombo['title'].'</p>
					<div class="box_button">
						<p class="price_box">'.$core->get_Lang('Temporary').': <span class="price_tmp">0</span> '.$clsISO->getShortRateText().'</p>
						<button class="btn_del" onclick="del_product_booking(this,\'combo\','.$combo_id.')" type="button"></button>
					</div>
				</div>
				<div class="row box_content_book">
					<div class="col-lg-3 box_content_left">
						<div class="form-item">
							<label for="">'.$core->get_Lang('Departure').'</label>
							<input class="datepicker required form-control" name="departure_date" type="text" value="" placeholder="dd/mm/yyyy" autocomplete="off"/>										
						</div>
						<div class="box_price_by_option"></div>
					</div>';
		if($html_serviceOption != ''){
		$html .= '	<div class="col-lg-9 box_content_right">
							<label for="">'.$core->get_Lang('Services bonus').'</label>
							<!--<select name="ServicesBonus" class="changeServicesBonus" data-type="combo" data-combo_id="'.$combo_id.'">
								<option value="">'.$core->get_Lang('Select Service').'</option>
								'.$html_serviceOption.'
							</select>-->
							<div class="services_bonus" data-toggle="collapse" data-target="#collapseServiceCombo'.$combo_id.'" aria-expanded="false" aria-controls="collapseExample">'.$core->get_Lang('Select Services').'<i class="fa fa-angle-down pull-right"></i></div>
								'.$html_serviceOption.'
							<div class="lst_service_bonus" id="lst_service_bonus_combo_'.$combo_id.'">

							</div>
						</div>
					</div>';
	}	
	$html .= '</div>';
	echo $html; die();
}
//add html voucher
function default_addBookingVoucher(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$clsConfiguration;
	$clsVoucher = new Voucher(); 
	$clsAddOnService = new AddOnService();
	$clsStock = new Stock();
	$voucher_id = (int) Input::post('voucher_id', 0);
	$oneVoucher = $clsVoucher->getOne($voucher_id,'title,price');
	$TotalStock = $clsStock->getTotal($voucher_id);
	$_discountInfo = $clsVoucher->checkIsPromotion($voucher_id,1);
	$discount_id = $_discountInfo.discount_info.discount_id;
	$is_discount = $_discountInfo.is_discount;
	$ticket = $core->get_Lang('ticket');
	
	$price = $clsISO->parsePriceDecimal($oneVoucher['price']);
	$result = $clsVoucher->checkIsPromotion($voucher_id, true);
	if($result['is_discount']){
		$discount_type = $result['discount_info']['discount_type'];
		$discount_value = $result['discount_info']['discount_value'];
		if($discount_type=='amount'){
			$price -= $clsISO->parsePriceDecimal($discount_value);
		} else if($discount_type=='percentage') {
			$price -= ($price*$clsISO->parsePriceDecimal($discount_value))/100;
		}
	}
	
	if($TotalStock > 50){
		$html_stock = $clsISO->makeSelectNumber2(51,$voucherGroup_id,"$ticket,$ticket");
	}else{
		$html_stock = $clsISO->makeSelectNumber2($TotalStock+1,$voucherGroup_id,"$ticket,$ticket");
	}
	if($clsVoucher->getTaxable($voucher_id,$oneTable) == 1){
		$text_VAT = $core->get_Lang('Prices include VAT');
	}else{
		$text_VAT = $core->get_Lang('Price does not include VAT');
	}
	#	
	
	$html = '<div class="box_info_booking" data-type="voucher" id="voucher_'.$voucher_id.'">
				<input type="hidden" class="voucher_select" value="'.$voucher_id.'"/>
				<input type="hidden" name="price_booking" value=""/>
				<div class="box_head_book">
					<p class="title_tour">'.'<span class="lbl_title">['.$core->get_lang('Voucher').']</span> '.$oneVoucher['title'].'<span> ('.$core->get_Lang('Còn').' '.$TotalStock. ' ' . $core->get_Lang('Voucher').')</span></p>
					<div class="box_button">
						<p class="price_box">'.$core->get_Lang('Temporary').': <span class="price_tmp">'.number_format($price,0,'.',' ').'</span> '.$clsISO->getShortRateText().'</p>
						<button class="btn_del" onclick="del_product_booking(this,\'voucher\','.$voucher_id.')" type="button"></button>
					</div>
				</div>
				<div class="row box_content_book">
					<div class="col-lg-12 box_content_left" style="width:100%">
						<div class="form-item adult-child box_select2">
							<label for="">'.$core->get_Lang('Voucher').'</label>
							<select name="voucherGroup_id" class="changeServicesBonus voucher_ticket inp_price iso-selectbox" onchange="loadTotalPrice(this,\'voucher\','.$voucher_id.')" data-price="'.$price.'" data-voucher_id="'.$voucher_id.'">
								'.$html_stock.'
							</select>
							<span class="price">( x '.number_format($price,0,'.',' ').$clsISO->getShortRateText().' '.$text_VAT.')</span>
						</div>
						
					</div>
				</div>
			</div>';
	echo $html; die();
}
//add html price adult children infants
function default_addPriceByOption(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$package_id;
	$clsTour = new Tour(); 
	$clsTourOption = new TourOption();
	$clsProperty = new Property();
    $clsAddOnService = new AddOnService();
    $clsTourProperty = new TourProperty();
    $clsTourService = new TourService();
    $clsTourStore = new TourStore();
    $clsTourStartDate = new TourStartDate();
    $clsBooking = new Booking();
    $clsProfile = new Profile();
    $clsVoucher = new Voucher();
    $clsPromotion = new Promotion();
    $clsTourPriceGroup = new TourPriceGroup();
	$tour_id = (int) Input::post('tour_id', 0);
	$tour_class_id = (int) Input::post('tour_option', 0);
	$oneTour = $clsTour->getOne($tour_id);
	
	if ($clsISO->getCheckActiveModulePackage($package_id,'tour','store','default','REVQQVJUVVJFLVZpZXRJU08=')){
		 $checkExistTourStartDate= $clsTourStore->checkExist($tour_id,'DEPARTURE');
   		if(!empty($checkExistTourStartDate)){
		   $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and start_date >= '".time()."' and close_sale_date >= '".time()."' and tour_id ='$tour_id' and is_last_hour=1  order by start_date ASC",$clsTourStartDate->pkey);
			$is_last_hour= !empty($lstTourStartDate)?1:0;
			$date_coutdown = array();
			foreach ($lstTourStartDate as $k => $v){
				$getStrCloseSellDateCountDown = $clsTourStartDate->getStrCloseSellDateCountDown($v[$clsTourStartDate->pkey]);
				$getCloseSellDateCountDown = $clsTourStartDate->getCloseSellDateCountDown($v[$clsTourStartDate->pkey],'date_coutdown');
				if($getStrCloseSellDateCountDown > time()){
					$date_coutdown[]= $getCloseSellDateCountDown;
				}
			}
			$date_coutdown =array_shift($date_coutdown);
			$lstTourStartDate1 = $clsTourStartDate->getAll("is_trash=0 and start_date >= '".time()."' and tour_id ='$tour_id' order by start_date ASC",$clsTourStartDate->pkey);
			$tour_start_date= !empty($lstTourStartDate1)?1:0;
			$list_start_date= array();
			foreach ($lstTourStartDate1 as $key => $value){
				$list_start_date[] = $clsTourStartDate->getStartDateTour($value[$clsTourStartDate->pkey]);
			}
	   }
        
    }
	$first_start_date =reset($list_start_date);
    $str_first_start_date= $first_start_date;
   // var_dump($first_start_date);die();
    $first_start_date1=$first_start_date?$first_start_date:date('m/d/Y', time()+(24*60*60));
    $first_start_date = str_replace('-','/',$first_start_date);

    $str_first_start_date =strtotime($str_first_start_date);
   // var_dump($first_start_date);die();
    $str_first_start_date = !empty($first_start_date)?$str_first_start_date:time()+(24*60*60);
	#
	$str_check_in_book = $str_first_start_date;
	$promotion= 0 ;
	$now_day = strtotime(date('m/d/Y'));

	if(_IS_PROMOTION==1){
		
		$promotion=$clsISO->getPromotion($tour_id,'Tour',$now_day,$str_check_in_book,$type_check='get_more_info');
		$promotion=$promotion['discount_value'];
		$promotion = !empty($promotion)?$promotion:0; 
	}
	
	if(_IS_DEPARTURE==1){
        $str_check_in_book=$str_first_start_date;
        $checkExistTourStartDate= $clsTourStore->checkExist($tour_id,'DEPARTURE');
        $str_check_in_book = !empty($checkExistTourStartDate)?$str_check_in_book:0;
		
		$listTourStartDateClose=$clsTourStartDate->getAll("is_trash=0 and tour_id='$tour_id' and start_date='$str_check_in_book' and open_sale_date <= '$now_day' and close_sale_date <'$now_day' and is_last_hour=1 order by start_date ASC");
			
		foreach ($listTourStartDateClose as $key => $value) {
			$list_tour_start_date_id[]=$value['tour_start_date_id'];
		}
		$list_tour_start_date_id = implode(',', $list_tour_start_date_id);

		$condd="is_trash=0 ";
		if(!empty($list_tour_start_date_id)){
		$condd.=" and tour_start_date_id NOT IN ($list_tour_start_date_id)";
		}
		$condd.=" and start_date='$str_check_in_book' and tour_id ='$tour_id' order by start_date ASC limit 0,1";
		
		
        if (!empty($checkExistTourStartDate) && !empty($tour_start_date)){
            $lstTourStartDate = $clsTourStartDate->getAll($condd);
        }
		if($lstTourStartDate[0]['price_type']==1){
			$seat_available=$lstTourStartDate[0]['allotment'];
			$deposit_start_date=$lstTourStartDate[0]['deposit'];
			if($number_pick_travellers > $seat_available) {
				$exceeded_seat = 1;
			}else{
				$exceeded_seat = 0;
			}
			if ($seat_available == 1) {
				$seat = $core->get_Lang('seat');
			}else{
				$seat = $core->get_Lang('seats');
			}
			if(!empty($seat_available)) {
				$title_seat = $core->get_Lang('Empty') . ' ' . $seat_available . ' ' . $seat;
			}else{
				$title_seat = $seat = $core->get_Lang('Full');
			}
		}else{
			$deposit = $clsTour->getDeposit($tour_id);
			$title_seat = '';
		}
    }
	$lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc",$clsTourProperty->pkey);
	foreach($lstVisitorType as $key => $value){
		if($value['tour_property_id'] != $adult_type_id && $value['tour_property_id'] != $child_type_id){
			$tour_visitor_infant_id = $value['tour_property_id'];
		}
	}
	$tour_number_adults_id=$clsTourPriceGroup->getTourNumberGroup($adult_type_id,$number_adults,$tour_id);
    $tour_number_child_id=$clsTourPriceGroup->getTourNumberGroup($child_type_id,$number_child,$tour_id);
    $tour_number_infants_id=$clsTourPriceGroup->getTourNumberGroup($tour_visitor_infant_id,$number_infants,$tour_id);
	$price_adults_simple = $price_child_simple = $price_infants_simple = 0;
	if(!empty($checkExistTourStartDate)){
		if(!empty($lstTourStartDate)){
			if($lstTourStartDate[0]['price_type']==1){
				$price = $lstTourStartDate[0]['price'];
				$price= json_decode($price,'true');
				

				$price_adults = $price_adults_simple = $price[$adult_type_id][$tour_class_id][$tour_number_adults_id];
				$price_child = $price_child_simple = $price_adults>0?$price[$child_type_id][$tour_class_id][$tour_number_child_id]:0;
				$price_infants = $price_infants_simple = $price_adults>0?$price[$tour_visitor_infant_id][$tour_class_id][$tour_number_infants_id]:0;
				
				$price_adults = $price_adults - $price_adults*$promotion/100;
				$price_child = $price_child - $price_child*$promotion/100;
				$price_infants = $price_infants - $price_infants*$promotion/100;
			}elseif($lstTourStartDate[0]['price_type']==0){
				$price_adults = $price_adults_simple = $clsTourPriceGroup->getPriceBooking($tour_id,$tour_class_id,$tour_number_adults_id,$adult_type_id,0);
				$price_child = $price_child_simple = $price_adults>0?$clsTourPriceGroup->getPriceBooking($tour_id,$tour_class_id,$tour_number_child_id,$child_type_id,0):0;
				$price_infants = $price_infants_simple = $price_adults?$clsTourPriceGroup->getPriceBooking($tour_id,$tour_class_id,$tour_number_infants_id,$tour_visitor_infant_id,0):0;
				
				$price_adults = $price_adults - $price_adults*$promotion/100;
				$price_child = $price_child - $price_child*$promotion/100;
				$price_infants = $price_infants - $price_infants*$promotion/100;
			}
		}else{
			$price_adults = 0;
			$price_child = 0;
			$price_infants = 0;
		}
	}else{
		$price_adults = $clsTourPriceGroup->getPriceBooking($tour_id,$tour_class_id,$tour_number_adults_id,$adult_type_id,0);
		$price_adults_simple = $price_adults;
		$price_child = $price_adults>0?$clsTourPriceGroup->getPriceBooking($tour_id,$tour_class_id,$tour_number_child_id,$child_type_id,0):0;
		$price_child_simple = $price_child;
		$price_infants = $price_adults>0?$clsTourPriceGroup->getPriceBooking($tour_id,$tour_class_id,$tour_number_infants_id,$tour_visitor_infant_id,0):0;
		$price_infants_simple = $price_infants;
		
		$price_adults = $price_adults - $price_adults*$promotion/100;
		$price_child = $price_child - $price_child*$promotion/100;
		$price_infants = $price_infants - $price_infants*$promotion/100;
	}
	$html = '';
	if($tour_class_id > 0){
		$html .= 	'<div class="form-item adult-child">
					<label for="">'.$core->get_Lang('Adult').'</label>
					<input class="text full inp_price" name="adult_simple" onkeyup="loadTotalPrice(this,\'tour\','.$tour_id.')" data-price="'.$price_adults.'" data-price_adults_simple="'.$price_adults_simple.'" value="1" type="number" placeholder="" /> x
					<div class="box_price">
						<input type="text" class="price_tour price_input_booking" name="price_adult" value="'.$price_adults.'" />
						<span class="txt_rate">'.$clsISO->getShortRateText().'</span>
					</div>					
				</div>';
	
		$html .= 	'<div class="form-item adult-child">
					<label for="">'.$core->get_Lang('Child').'</label>
					<input class="text full inp_price" onkeyup="loadTotalPrice(this,\'tour\','.$tour_id.')" name="children_simple" data-price="'.$price_child.'" data-price_child_simple="'.$price_child_simple.'" value="0" type="number" placeholder="" /> x
					<div class="box_price">
						<input type="text" class="price_tour price_input_booking" name="price_child" value="'.$price_child.'" />
						<span class="txt_rate">'.$clsISO->getShortRateText().'</span>
					</div>				
				</div>';
		$html .= 	'<div class="form-item adult-child">
					<label for="">'.$core->get_Lang('Infants').'</label>
					<input class="text full inp_price" onkeyup="loadTotalPrice(this,\'tour\','.$tour_id.')" name="infants_simple" data-price="'.$price_infants.'" data-price_infants_simple="'.$price_infants_simple.'" value="0" type="number" placeholder="" /> x
					<div class="box_price">
						<input type="text" class="price_tour price_input_booking" name="price_infants" value="'.$price_infants.'" />
						<span class="txt_rate">'.$clsISO->getShortRateText().'</span>
					</div>
				</div>';
	}
	
	echo $html;die;
}
//add html service bonus
function default_addServiceBooking(){	
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id;
	$clsAddOnService = new AddOnService();
	$service_id = (int) Input::post('service_id', 0);
	$table_id = (int) Input::post('table_id', 0);
	$type = Input::post('type', '');
	$oneItem = $clsAddOnService->getOne($service_id,'title,price');
	$html = '';
	if($oneItem){
		$html .= '<div class="form-item">
					<input class="text full inp_price service_'.$type.' service_'.$service_id.'" onkeyup="loadTotalPrice(this,\''.$type.'\','.$table_id.')" name="number_addon_'.$type.'['.$service_id.']" data-service="'.$service_id.'" value="1" data-price="'.$oneItem['price'].'" type="number" placeholder="" min="1" />
					<label for="">'.$oneItem['title'].' ('.number_format($oneItem['price'],0,'.',' ').$clsISO->getShortRateText().')</label>	
					<button class="btn_delete_bonus" onclick="del_bonus(this,\''.$type.'\','.$table_id.')" type="button">x</button>		
				</div>';
	}
	echo $html;die;
}
//add html hotel
function default_addHotelRoomBooking(){	
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id;
	$clsHotelRoom = new HotelRoom();
	$room_id = (int) Input::post('room_id', 0);
	$check_in = Input::post('check_in', '');
	$check_out = Input::post('check_out', '');
	if($check_in != ''){
		$first_start_date = str_replace('/','-',$check_in);
		$str_check_in = strtotime($first_start_date);
	}else{
		$str_check_in = time();
	}
	if($check_out != ''){
		$first_end_date = str_replace('/','-',$check_out);
		$str_check_out = strtotime($first_end_date);
	}else{
		$str_check_out = time();
	}
	
	$string_number_night=$str_check_out-$str_check_in;
	$number_night=$string_number_night/86400;
	if($number_night >0){
		$number_night=$number_night;
	}else{
		$number_night=1;
	}
	
	$now_day = strtotime(date('m/d/Y'));
	$oneItem = $clsHotelRoom->getOne($room_id,'title,price,number_adult,number_children,hotel_id');
	$discount=$clsISO->getPromotion($oneItem['hotel_id'],'Hotel',$now_day,$str_check_in,'info_promotion');
	$promotion=$discount['discount_value'];
	$html = '';
	if($oneItem){
		if($promotion > 0){
			$price = $oneItem['price'] - ($oneItem['price'] * $promotion)/100;
		}else{
			$price = $oneItem['price'];
		}
		$price_simple = $oneItem['price'] * $number_night;
		$price = $price * $number_night;		
		$html .= '<div class="form-item">
					<input class="text full required inp_price room_hotel room_'.$room_id.'" onkeyup="loadTotalPrice(this,\'hotel\','.$oneItem['hotel_id'].')" name="number_room['.$room_id.']" value="1" data-hotel_room_id="'.$room_id.'" data-max_adult="'.$oneItem['number_adult'].'" data-price_simple="'.$price_simple.'" data-number_nights="'.$number_night.'" data-promotion="'.$promotion.'" data-max_child="'.$oneItem['number_children'].'" data-price="'.$price.'" type="number" placeholder="" min="1" />
					<label for="">'.$oneItem['title'].' ('.number_format($price,0,'.',' ').$clsISO->getShortRateText().')</label>	
					<div class="box_price">
						<input type="text" class="price_tour price_input_booking" name="price_room" value="'.$price.'" />
						<span class="txt_rate">'.$clsISO->getShortRateText().'</span>
					</div>
					<button class="btn_delete_bonus" onclick="del_bonus(this,\'hotel\','.$oneItem['hotel_id'].')" type="button">x</button>		
				</div>';
	}
	echo $html;die;
}
//add html cruise
function default_addCruiseCabinBooking(){	
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$dbconn,$clsConfiguration;
	$clsCruiseCabin = new CruiseCabin();
	$clsCruise = new Cruise();
	$clsCruiseItinerary = new CruiseItinerary();
	$cruise_id = (int) Input::post('cruise_id', 0);
	$cruise_cabin_id = (int) Input::post('cruise_cabin_id', 0);
	$number_adult = (int) Input::post('number_adult', 0);
	$number_child = (int) Input::post('number_child', 0);
	$infants = Input::post('infants', '');
	$arraycheckrateCabin["number_adult"] = $number_adult;
	$arraycheckrateCabin["number_child"] = $number_child;
	if($infants != '' && count($infants) > 0){
		for($i=0; $i< count($infants); $i++){
			$infant = "infant1s_".($i+1);
			$arraycheckrateCabin[$infant] = $infants[$i];
			
		}
	}
//	$arraycheckrateCabin["infants"] = $infants;
	$departure_date = Input::post('departure_date', '');
	$arraycheckrateCabin["departure_date"] = $departure_date;
	if($departure_date != ''){
		$first_start_date = str_replace('-','/',$departure_date);
		$promotion_date = strtotime($first_start_date);
	}else{
		$promotion_date = time();
	}
	$departure_date_month = date('m',strtotime("+1 day"));
	$assign_list['departure_date_month']=$departure_date_month; 
	$lstSeason=$clsConfiguration->getAll("setting='high_season_month' and value like '%".$departure_date_month."%' limit 0,1");
	if(!empty($lstSeason)){
		$season='high';
	}else{
		$season='low';
	}
	/*$lstItinerary_cruise = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' order by order_no asc limit 0,1",$clsCruiseItinerary->pkey);
	$cruise_itinerary_id=$lstItinerary_cruise[0][$clsCruiseItinerary->pkey];*/
	
	
	$SQL = "SELECT MIN(price) FROM ".DB_PREFIX."cruise_season_price WHERE price > 0 and cruise_id='$cruise_id' and season ='$season'";
	$price_check= $dbconn->GetOne($SQL);
	#
	$sql_cabin="SELECT cruise_itinerary_id,cruise_cabin_id,group_size_id FROM ".DB_PREFIX."cruise_season_price WHERE price = '$price_check' and cruise_id='$cruise_id' and season ='$season'";
	$cabin=$dbconn->GetAll($sql_cabin);
	$cruise_itinerary_id=$cabin[0]['cruise_itinerary_id'];
	
	$arraycheckrateCabin["cruise_itinerary_id"] = $cruise_itinerary_id;
	
	$oneItem = $clsCruiseCabin->getOne($cruise_cabin_id,'title,price');
	$html = '';
	$now_day = strtotime(date('m/d/Y'));
	
	$discount=$clsISO->getPromotion($cruise_id,'Cruise',$now_day,$promotion_date,'info_promotion');
	$promotion=$discount['discount_value'];
	$price = $oneItem['price'] - ($oneItem['price'] * $promotion)/100;
	
	
	$price = ($price > 0)?(number_format($price,0,'.',' ').$clsISO->getShortRateText()):0;
	if($oneItem){
		/*$html .= $clsCruiseCabin->getLCheckRatePriceCabinCruise2($cruise_cabin_id,$arraycheckrateCabin,$promotion_date,$cruise_id);*/
		$max_adult=$clsCruise->getMaxAdult($cruise_id);
		$max_child = 2;
		$html .= '<div class="box_price_by_option">
					<div class="form-item">
						<input class="text full inp_price cruise_cabin cabin_'.$cruise_cabin_id.'" name="number_cabin['.$cruise_cabin_id.']" value="1" data-cruise_cabin_id="'.$cruise_cabin_id.'" data-max_adult="'.$max_adult.'" data-price="'.$price.'" type="number" placeholder="" min="1" onkeyup="show_cabin_book(this)">
						<label for="">'.$oneItem['title'].'</label>	
						<button class="btn_delete_bonus" onclick="del_bonus(this,\'cruise\','.$cruise_id.')" type="button">x</button>		
					</div>
					<div class="box_cabin_book">
						<div class="cabin_book">
							<label for="">Phòng 1</label>';
		
		if($max_adult && $max_adult > 0){
			$html .= '<div class="form-item adult-child">
						<label for="">'.$core->get_Lang('Adult').'</label>
						<input class="text full required" name="number_adult" value="1" onkeyup="refresh_cruise_cabin(this)" min="1" max="'.$max_adult.'" type="number" placeholder="" />			
					</div>';
		}
		
		if($max_child && $max_child > 0){
			$html .= '<div class="form-item adult-child">
						<label for="">'.$core->get_Lang('Child').'</label>
						<input class="text full" name="number_child" value="0" onkeyup="show_child(this)" min="1" max="'.$max_child.'" type="number" placeholder="" />			
					</div>';
			for($i=1; $i<=$max_child; $i++){
				$html .= '<div class="form-item adult-child conchild1s_'.$i.'" style="display:none">
							<label for="">'.$core->get_Lang('Child').' '.$i.'</label>
							<select class="form-control child_age iso-selectbox" onchange="refresh_cruise_cabin(this)" name="infant1s_'.$i.'" id="infant1s_'.$i.'"> 
								'.$clsISO->makeSelectNumberAgeChild($clsConfiguration->getValue('ChildMaxAgePolicy')).'
							</select>		
						</div>';
			}

		}
		$html .= '</div>
				</div>

			</div>';
	}
	echo $html;die;
}

function default_show_cabin_book(){
	ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$dbconn,$clsConfiguration;
	$number_room = (int)Input::post('number_room','0');
	$cruise_id = (int)Input::post('cruise_id','0');
	$clsCruise = new Cruise();
	$html = '';
	if($number_room >0){
		$max_adult=$clsCruise->getMaxAdult($cruise_id);
		$max_child = 2;
		for($i=0; $i<$number_room; $i++){
			$html .= '<div class="cabin_book">
							<label for="">'.$core->get_Lang('Room').' '.($i+1).'</label>';
		
			if($max_adult && $max_adult > 0){
				$html .= '<div class="form-item adult-child">
							<label for="">'.$core->get_Lang('Adult').'</label>
							<input class="text full required" name="number_adult" value="1" onkeyup="refresh_cruise_cabin(this)" min="1" max="'.$max_adult.'" type="number" placeholder="" />			
						</div>';
			}

			if($max_child && $max_child > 0){
				$html .= '<div class="form-item adult-child">
							<label for="">'.$core->get_Lang('Child').'</label>
							<input class="text full" name="number_child" value="0" onkeyup="show_child(this)" min="1" max="'.$max_child.'" type="number" placeholder="" />			
						</div>';
				for($j=1; $j<=$max_child; $j++){
					$html .= '<div class="form-item adult-child conchild1s_'.$j.'" style="display:none">
								<label for="">'.$core->get_Lang('Child').' '.$j.'</label>
								<select class="form-control child_age iso-selectbox" onchange="refresh_cruise_cabin(this)" name="infant'.($i+1).'s_'.$j.'" id="infant'.($i+1).'s_'.$j.'"> 
									'.$clsISO->makeSelectNumberAgeChild($clsConfiguration->getValue('ChildMaxAgePolicy')).'
								</select>		
							</div>';
				}

			}
			$html .= '</div>';
		}
	}
	echo $html;die;
}
//add html city
function default_get_select_city(){
	global $dbconn,$assign_list,$_CONFIG,$_SITE_ROOT,$mod,$_LANG_ID,$act,$core,$clsModule,$clsConfiguration,$clsISO;
	$clsCity = new City();
	$clsHotel = new Hotel();
	#
	$country_id = (int) Input::post('country_id', 0);
	$region_id = (int) Input::post('region_id', 0);
	$city_id = (int) Input::post('city_id', 0);
	#
	$cond = "{$clsCity->tbl}.is_trash=0 and {$clsCity->tbl}.is_online=1 and {$clsHotel->tbl}.is_trash=0 and {$clsHotel->tbl}.is_online=1";
	if($country_id > 0){$cond .= " and {$clsCity->tbl}.country_id='{$country_id}'";}
	if($region_id > 0){$cond .= " and {$clsCity->tbl}.region_id='{$region_id}'";}
	$html = '<option value="0">'.$core->get_Lang('selectcity').'</option>';
	$lstCity = $clsCity->getAllOptimize("{$cond} order by {$clsCity->tbl}.order_no asc", "{$clsHotel->tbl} on {$clsCity->tbl}.city_id={$clsHotel->tbl}.city_id", "DISTINCT({$clsCity->tbl}.city_id),{$clsCity->tbl}.title");
	if(!empty($lstCity)){
		foreach($lstCity as $k => $v){
			$html .= '<option value="'.$v[$clsCity->pkey].'"'.($city_id==$v[$clsCity->pkey]?' selected':'').'>
				'.$clsCity->getTitle($v[$clsCity->pkey]).'
			</option>';
		}
		unset($lstCity);
	} else {
		$html = 'EMPTY';
	}
	// Return
	echo $html; die();
}

function default_updateSession(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id;
		$type = Input::post('type','');
		if($type == 'delete_session'){
			vnSessionDelVar('BookingTourAdm_'.$_LANG_ID);
			vnSessionDelVar('BookingVoucherAdm_'.$_LANG_ID);
			vnSessionDelVar('BookingComboAdm_'.$_LANG_ID);
			vnSessionDelVar('BookingHotelAdm_'.$_LANG_ID);
			vnSessionDelVar('SessionChooseRoomAdm');
			vnSessionDelVar('BookingCruiseAdm_'.$_LANG_ID);
			vnSessionDelVar('SessionChooseCabinAdm');
			return '';
		}
		$act = Input::post('act','');
		if($type == 'tour'){
			$tour_id = Input::post('table_id','0');
			if($tour_id > 0){
				$cartSessionService= vnSessionGetVar('BookingTourAdm_'.$_LANG_ID);
				if(empty($cartSessionService)){
					$cartSessionService = array();
				}
				if($act == 'delete'){
					unset($cartSessionService[$_LANG_ID][$tour_id]);
				}else{
					unset($cartSessionService[$_LANG_ID][$tour_id]);
					$link=$clsISO->getLink('cart');
					$cartSessionService[$_LANG_ID][$tour_id] = array();
					foreach($_POST['data'] as $k=>$v){
						if(!empty($v)){
							if($k=='number_addon'){
								foreach($v as $k_addon=>$v_addon){
									if(!empty($v_addon)){
										$cartSessionService[$_LANG_ID][$tour_id][$k][$k_addon] = $v_addon;
									}
								}
							}else{
								if($k == 'check_in_book_z'){
									$v = str_replace('/','-',$v);
								}
								$cartSessionService[$_LANG_ID][$tour_id][$k] = $v;
							}
						}
					}
				}			
				///$clsISO->print_pre($cartSessionService);die();
				vnSessionSetVar('BookingTourAdm_'.$_LANG_ID,$cartSessionService);
				var_dump(vnSessionGetVar('BookingTourAdm_'.$_LANG_ID));die;
			}
			
		}
		if($type == 'voucher'){
			$voucher_id_z = (int)Input::post('table_id','0');
			if($voucher_id_z > 0){
				$cartSessionVoucher= vnSessionGetVar('BookingVoucherAdm_'.$_LANG_ID);
				if(empty($cartSessionVoucher)){
					$cartSessionVoucher = array();
				}
				if($act == 'delete'){
					unset($cartSessionVoucher[$_LANG_ID][$voucher_id_z]);
				}else{
					unset($cartSessionVoucher[$_LANG_ID][$voucher_id_z]);
					$assign_list["cartSessionVoucher"] = $cartSessionVoucher;
					$cartSessionVoucher[$_LANG_ID][$voucher_id_z] = array();
					foreach($_POST['data'] as $k=>$v){
						$cartSessionVoucher[$_LANG_ID][$voucher_id_z][$k] = $v;
					}
				}
				///$clsISO->print_pre($cartSessionService);die();
				vnSessionSetVar('BookingVoucherAdm_'.$_LANG_ID,$cartSessionVoucher);
				var_dump(vnSessionGetVar('BookingVoucherAdm_'.$_LANG_ID));die;
			}		
			
		}
		if($type == 'combo'){
			$combo_id = (int)Input::post('table_id','0');
			if($combo_id > 0){
				$cartSessionCombo= vnSessionGetVar('BookingComboAdm_'.$_LANG_ID);
				if(empty($cartSessionCombo)){
					$cartSessionCombo = array();
				}
				if($act == 'delete'){
					unset($cartSessionCombo[$_LANG_ID][$combo_id]);
				}else{
					unset($cartSessionCombo[$_LANG_ID][$combo_id]);
					$assign_list["cartSessionCombo"] = $cartSessionCombo;
					$cartSessionCombo[$_LANG_ID][$combo_id] = array();
					foreach($_POST['data'] as $k=>$v){
						$cartSessionCombo[$_LANG_ID][$combo_id][$k] = $v;
					}
				}
				///$clsISO->print_pre($cartSessionService);die();
				vnSessionSetVar('BookingComboAdm_'.$_LANG_ID,$cartSessionCombo);
				var_dump(vnSessionGetVar('BookingComboAdm_'.$_LANG_ID));die;
			}			
			
		}
		if($type == 'hotel'){
			$data		= Input::post('data','');
			$room = json_decode(htmlspecialchars_decode($data['room']),true);
			
			$discount=$clsISO->getPromotion($hotel_id,'Hotel',$now_day,$str_check_in,'info_promotion');
			$promotion=($discount['discount_value'] > 0)?$discount['discount_value']:0;
			
			$hotel_id 		= (int)Input::post('table_id','0');
			if($hotel_id > 0){
				$check_in 		= $data['check_in'];
				$check_in 		= ($check_in != '')?strtotime(str_replace('/','-',$check_in)):0;
				$check_out 		= $data['check_out'];
				$check_out 		= ($check_out != '')?strtotime(str_replace('/','-',$check_out)):0;

				$SessionChooseRoom= vnSessionGetVar('SessionChooseRoomAdm');
				if(empty($SessionChooseRoom)){
					$SessionChooseRoom = array();
				}
				if($act == 'delete'){
					unset($SessionChooseRoom[$hotel_id]);
				}else{
					unset($SessionChooseRoom[$hotel_id]);
					$SessionChooseRoom[$hotel_id]['BookingHotel'] = 'BookingHotel';
					$SessionChooseRoom[$hotel_id]['hotel_id'] = $hotel_id;
					$SessionChooseRoom[$hotel_id]['check_in'] = $check_in;
					$SessionChooseRoom[$hotel_id]['check_out'] = $check_out;
					$SessionChooseRoom[$hotel_id]['promotion'] = $promotion;


					unset($SessionChooseRoom[$hotel_id]['room']);


					foreach($room as $key => $value){
						$hotel_room_id = $value['hotel_room_id'];
						if($value['number_room'] > 0){
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['hotel_id'] = $hotel_id;
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['hotel_room_id'] = $hotel_room_id;
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['number_adult'] = $value['number_adult'];
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['number_child'] = $value['number_child'];
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['number_room'] = $value['number_room'];
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['number_night'] = $value['number_nights'];
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['max_adult'] = $value['max_adult'];
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['max_child'] = $value['max_child'];
							$SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]['totalprice'] = $value['totalprice'];
						}else{
							unset($SessionChooseRoom[$hotel_id]['room'][$hotel_room_id]);
						}

					}
				}
				vnSessionSetVar('SessionChooseRoomAdm',$SessionChooseRoom);
				
				$cartSessionHotel= vnSessionGetVar('BookingHotelAdm_'.$_LANG_ID);
				if(empty($cartSessionHotel)){
					$cartSessionHotel = array();
				}

				$cartSessionVoucher[$_LANG_ID][$hotel_id] = array();
				$cartSessionHotel[$_LANG_ID][$hotel_id]=$SessionChooseRoom[$hotel_id];

				vnSessionSetVar('BookingHotelAdm_'.$_LANG_ID,$cartSessionHotel);
				var_dump(vnSessionGetVar('BookingHotelAdm_'.$_LANG_ID));die;
			}
			
		}
		if($type == 'cruise'){
			$data		= Input::post('data','');
			$cabin = json_decode(htmlspecialchars_decode($data['cabin']),true);		
			
			if(type_id == 0){
				$cruise_id 		= (int)Input::post('table_id',0);
			}else{
				$cruise_id = type_id;
			}
			
			$departure_date = $data['departure_date'];
			$cruise_itinerary_id = $data['cruise_itinerary_id'];
			
			if($departure_date != ''){
				$first_start_date = str_replace('/','-',$departure_date);
				$departure_date = strtotime($first_start_date);
			}else{
				$departure_date = time();
			}
			$now_day = strtotime(date('m/d/Y'));	
			$discount=$clsISO->getPromotion($cruise_id,'Cruise',$now_day,$departure_date,'info_promotion');
			$promotion=$discount['discount_value'];
			$promotion = ($promotion > 0)?$promotion:0;
			
			$SessionChooseCabin= vnSessionGetVar('SessionChooseCabinAdm');
			if(empty($SessionChooseCabin)){
				$SessionChooseCabin = array();
			}
			unset($SessionChooseCabin[$cruise_itinerary_id]);
			
			$SessionChooseCabin[$cruise_itinerary_id]['BookingCruise'] = 'BookingCruise';
			$SessionChooseCabin[$cruise_itinerary_id]['cruise_id'] = $cruise_id;
			$SessionChooseCabin[$cruise_itinerary_id]['promotion'] = $promotion;
			$SessionChooseCabin[$cruise_itinerary_id]['cruise_itinerary_id'] = $cruise_itinerary_id;
			$SessionChooseCabin[$cruise_itinerary_id]['departure_date'] = $departure_date;			
				
			foreach($cabin as $key => $value){
				$cruise_cabin_id = $value['cruise_cabin_id'];
				if($value['number_cabin'] > 0){
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['cruise_id'] = $cruise_id;
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['cruise_itinerary_id'] = $cruise_itinerary_id;
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['cruise_cabin_id'] = $cruise_cabin_id;
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['number_adult'] = $value['number_adult'];
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['number_child'] = $value['number_child'];
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['number_cabin'] = $value['number_cabin'];
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['max_adult'] = $value['max_adult'];
					$SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]['totalprice'] = $value['totalprice'];
				}else{
					unset($SessionChooseCabin[$cruise_itinerary_id]['cabin'][$cruise_cabin_id]);
				}
				
			}
			vnSessionSetVar('SessionChooseCabinAdm',$SessionChooseCabin);
			
			$cartSessionCruise= vnSessionGetVar('BookingCruiseAdm_'.$_LANG_ID);
			if(empty($cartSessionCruise)){
				$cartSessionCruise = array();
			}
			$cartSessionCruise[$_LANG_ID][$cruise_itinerary_id]=$SessionChooseCabin[$cruise_itinerary_id];

			vnSessionSetVar('BookingCruiseAdm_'.$_LANG_ID,$cartSessionCruise);
			var_dump(vnSessionGetVar('BookingCruiseAdm_'.$_LANG_ID));die;
		}
		
}

function default_updatePriceCabin(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id;
	$clsCruiseCabin = new CruiseCabin();
	$cabin = Input::post('cabin','');
	$cabin = json_decode(htmlspecialchars_decode($cabin),true);
	$cruise_id = (int)Input::post('cruise_id','0');
	$cruise_itinerary_id = (int)Input::post('cruise_itinerary_id','0');
	$departure_date = Input::post('departure_date','');
	if($departure_date == ''){
		$departure_date = date('d/m/Y',strtotime("+1 day"));
	}
	$number_cabin = (int)Input::post('number_cabin','0');
	$number_adult = (int)Input::post('number_adult','0');
	$number_child = (int)Input::post('number_child','0');
	
	$arraycheckrateCabin = [
		"cruise_id"			=>	$cruise_id,
		"cruise_itinerary_id"	=>	$cruise_itinerary_id,
		"departure_date"		=>	$departure_date,
		"number_cabin"			=>	$number_cabin,
		"number_adult"			=>	$number_adult,
		"number_child"			=>	$number_child,
	];
	$array = [];
	foreach($cabin as $key=>$value){
		$cruise_cabin_id = $value['cruise_cabin_id'];
		$lst_adult = $value['array_adult'];
		$lst_child = $value['array_child'];
		$lst_infant = $value['array_infant'];
		for($i=0; $i< count($lst_child);$i++){
			$array["number_adult_".($i+1)] = $lst_adult[$i];
			$array["number_child_".($i+1)] = $lst_child[$i];
			$array_infant = $lst_infant[$i];
			$array["infant".($i+1)."s_1"] = isset($array_infant[0])?$array_infant[0]:"";
			$array["infant".($i+1)."s_2"] = isset($array_infant[1])?$array_infant[1]:"";
		}
		
	}
	$arraycheckrateCabin = array_merge($arraycheckrateCabin,$array);
	
	$promotion_date = strtotime(str_replace('/','-',$departure_date));
	
	$lstCruiseCabinID = $clsCruiseCabin->getLCheckRatePriceCabinCruise3($cruise_cabin_id,$arraycheckrateCabin,$promotion_date,$cruise_id,"value");
	echo $lstCruiseCabinID;die;
}

function default_ajAddCustomer(){
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$assign_list;
	$clsProfile = new Profile();
	$clsBooking = new Booking(); $assign_list["clsBooking"] = $clsBooking;	
	$email = Input::post('email_new', '');
	$full_name = Input::post('full_name_new', '');
	$birthday = Input::post('birthday_new', '');
	$phone = Input::post('phone_new', '');
	$address = Input::post('address_new', '');
	$country_id = (int)Input::post('country_id_new', 0);
	$profile_id = $clsProfile->getIDByEmail($email);
	if($profile_id == 0){
		$profile_id = $clsProfile->getMaxId();
		if($birthday != ''){
			$birthday = str_replace('/','-',$birthday);
			$birthday = strtotime($birthday);
		}
		$field = $clsProfile->pkey.",full_name,email,verified_email,birthday,phone,country_id,address,is_trash,is_active";
		$value = "'".$profile_id."','".$full_name."','".$email."','".$email."','".$birthday."','".$phone."','".$country_id."','".$address."','0','1'";
		if($clsProfile->insertOne($field,$value)){
			$data = [
				'result'	=>	true,
				'message'	=>	"Success"
			];
		}else{
			$data = [
				'result'	=>	false,
				'message'	=>	"Failed"
			];
		} 
		
			
	}else{
		$data = [
			'result'	=>	false,
			'message'	=>	"Email exist"
		];
	}
	echo json_encode($data);
}

function default_addNewBooking(){
//	ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
	global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO,$adult_type_id,$child_type_id,$assign_list;
	$clsProfile = new Profile();
	$clsBooking = new Booking(); $assign_list["clsBooking"] = $clsBooking;	
	$email = Input::post('email', '');
	$full_name = Input::post('full_name', '');
	$birthday = Input::post('birthday', '');
	$phone = Input::post('phone', '');
	$address = Input::post('address', '');
	$country_id = (int)Input::post('country_id', 0);
	$payment_method = (int)Input::post('payment_method', 0);
	$profile_id = $clsProfile->getIDByEmail($email);
	
	$cartSessionService= vnSessionGetVar('BookingTourAdm_'.$_LANG_ID);
	$cartSessionService = ($cartSessionService)?$cartSessionService[$_LANG_ID]:'';

	$cartSessionVoucher= vnSessionGetVar('BookingVoucherAdm_'.$_LANG_ID);
	$cartSessionVoucher = ($cartSessionVoucher)?$cartSessionVoucher[$_LANG_ID]:'';
	
	$cartSessionCruise= vnSessionGetVar('BookingCruiseAdm_'.$_LANG_ID);
	$cartSessionCruise = ($cartSessionCruise)?$cartSessionCruise[$_LANG_ID]:'';
	
	$cartSessionHotel= vnSessionGetVar('BookingHotelAdm_'.$_LANG_ID);
	$cartSessionHotel = ($cartSessionHotel)?$cartSessionHotel[$_LANG_ID]:'';
	
	$clsTour = new Tour();	$assign_list["clsTour"] = $clsTour;	
	$clsHotel = new Hotel();	$assign_list["clsHotel"] = $clsHotel;
	$clsCruise = new Cruise();	$assign_list["clsCruise"] = $clsCruise;
	$clsVoucher = new Voucher();	$assign_list["clsVoucher"] = $clsVoucher;
	$clsHotelRoom = new HotelRoom();	$assign_list["clsHotelRoom"] = $clsHotelRoom;
	$clsCruiseItinerary = new CruiseItinerary();	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCruiseCabin = new CruiseCabin();	$assign_list["clsCruiseCabin"] = $clsCruiseCabin;	

	$clsTourOption = new TourOption();	$assign_list["clsTourOption"] = $clsTourOption;	
	$clsAddOnService = new AddOnService();$assign_list["clsAddOnService"] = $clsAddOnService;
	
	/*$cartSessionCombo= vnSessionGetVar('BookingComboAdm_'.$_LANG_ID);
	$cartSessionCombo = $cartSessionCombo[$_LANG_ID];*/
//	var_dump($cartSessionService,$cartSessionVoucher,$cartSessionCruise,$cartSessionHotel);die;
	
	$cartStore=array();

	$totalGrand = 0;
	
	
	$totalPriceDeposit = 0;
	$totalPricePromotion = 0;
	$price_remaining = 0;
	$total_price = 0;
	
	
	$totalPriceTour = 0;
	if(!empty($cartSessionService)){
		foreach($cartSessionService as $key=>$value){
			$totalGrand += $value['total_price_z'];
			$totalPriceTour += $value['total_price_z'];
			$totalPriceDeposit += $value['price_deposit'];
			$totalPricePromotion += $value['price_promotion'];
			$tour_id = $value['tour_id_z'];
		}
		$cartStore['TOUR']=$cartSessionService;
	}
	
	$totalPriceVoucher = 0;
	if(!empty($cartSessionVoucher)){
		foreach($cartSessionVoucher as $key=>$value){
			$numberVoucher = $value['voucherGroup_id'];
			$voucher_id = $value['voucher_id_z'];
			$priceO_package =$clsVoucher->getPriceOrigin($voucher_id);
			$TotalPriceVoucher = $numberVoucher * $priceO_package;
			$totalGrand += $TotalPriceVoucher;
			$totalPriceVoucher += $TotalPriceVoucher;
		}
		$cartStore['VOUCHER']=$cartSessionVoucher;
	}
	/*$totalPriceCombo = 0;
	if(!empty($cartSessionCombo)){
		foreach($cartSessionCombo as $key=>$value){
			$combo_id = $value['combo_id'];
			$totalPriceCombo =$value['price_booking'];
			$totalGrand += $totalPriceCombo;
			$totalPriceCombo += $totalPriceCombo;
		}
		$cartStore['COMBO']=$cartSessionCombo;
	}*/

	
	$totalPriceCruise=0;
	if(!empty($cartSessionCruise)){
		foreach($cartSessionCruise as $key=>$value){
			$totalpriceCabin=0;
			foreach($value['cabin'] as $key2=>$value2){
				$totalpriceCabin+= $value2['totalprice'];
				$totalPricePromotionCruise=$value['promotion']*$totalpriceCabin/100;
			}
			
			$totalpriceCabin= $totalPricePromotionCruise?$totalpriceCabin-$totalPricePromotionCruise:$totalpriceCabin;
			$cartSessionCruise[$key]['totalPricePromotionCruise']=$totalPricePromotionCruise;
			$cartSessionCruise[$key]['totalpriceCabin']=$totalpriceCabin;
			$totalGrand += $totalpriceCabin;
			$totalPriceCruise += $totalpriceCabin;
			
			
		}
		$cartStore['CRUISE']=$cartSessionCruise;
	}
	
	$totalPriceHotel=0;
	if(!empty($cartSessionHotel)){
		foreach($cartSessionHotel as $key=>$value){
			$totalpriceRoom=0;
			foreach($value['room'] as $key2=>$value2){
				$totalpriceRoom += $value2['number_room']*$value2['totalprice'];
				$totalPricePromotionHotel=$value['promotion']*$totalpriceRoom/100;
			}
			
			$totalpriceRoom= $totalPricePromotionHotel?$totalpriceRoom-$totalPricePromotionHotel:$totalpriceRoom;
			$cartSessionHotel[$key]['totalPricePromotionHotel']=$totalPricePromotionHotel;
			$cartSessionHotel[$key]['totalpriceRoom']=$totalpriceRoom;
			$totalGrand += $totalpriceRoom;
			$totalPriceHotel += $totalpriceRoom;
		}
		$cartStore['HOTEL']=$cartSessionHotel;
	}
//	var_dump($cartStore);die;
	
	$cartSessionPackage = array();
	if($totalPriceDeposit>0){
		$totalPricePaymentNow=$totalPriceDeposit;
		$totalRemaining = $totalGrand-$totalPriceDeposit;
	}else{
		$totalPricePaymentNow=$totalGrand;
		$totalRemaining = $totalGrand;
	}
	//	var_dump($cartSessionService,$cartSessionVoucher,$cartSessionCruise,$cartSessionHotel);die;
//	var_dump($_POST);die;
//	echo $profile_id;die;
	if(!$profile_id){
		$profile_id = $clsProfile->getMaxId();
		if($birthday != ''){
			$birthday = str_replace('/','-',$birthday);
			$birthday = strtotime($birthday);
		}
		$field = $clsProfile->pkey.",full_name,email,verified_email,birthday,phone,country_id,address,is_trash,is_active";
		$value = "'".$profile_id."','".$full_name."','".$email."','".$email."','".$birthday."','".$phone."','".$country_id."','".$address."','0','1'";
		$clsProfile->insertOne($field,$value);
			
	}
	
	
	$cartSessionContactInfo=array();
	foreach($_POST as $k=>$v){
		$cartSessionContactInfo[$k] = $v;
	}
	vnSessionSetVar('ContactInfoBooking',$cartSessionContactInfo);

	$booking_id = $clsBooking->getMaxId();
	$booking_code = $clsBooking->generateBookingCode($booking_id,'Tour');
	#
	$f="booking_id,contact_name,full_name,country_id,phone,email";
	$f.= ",clsTable,booking_code,cart_store,booking_store,booking_type,reg_date,ip_booking,totalgrand,deposit,balance,price_promotion";

	$cart_store=serialize($cartStore);

	$cartSessionContactInfo= vnSessionGetVar('ContactInfoBooking');
	$booking_store = serialize($cartSessionContactInfo);
	var_dump($_POST);die;

	$v="'$booking_id'
	,'".$full_name."'
	,'".$full_name."'
	,'".$country_id."'
	,'".$phone."'
	,'".$email."'
	,'Tour'
	,'$booking_code'
	,'".$cart_store."'
	,'".$booking_store."'
	,'Tour','".time()."'
	,'".$_SERVER['REMOTE_ADDR']."'
	,'".$totalGrand."'
	,'".$totalPriceDeposit."' 
	,'".$totalRemaining."'
	,'".$totalPricePromotion."'";
	
	if(PAYMENT_GLOBAL){
		$f .= ",payment_method";
		$v .= ",'".intval($_POST['payment_method'])."'";
	}
	if($profile_id){
		$f.= ",member_id";
		$v.= ",'$profile_id'";
	}
	if($clsBooking->insertOne($f,$v)){
		$clsTourStartDate = new TourStartDate();
		foreach($cartSessionService as $item){
			$number_adult=$item['number_adults_z'];
			$number_child=$item['number_child_z'];
			$total_number = $number_adult + $number_child;
			$start_date = strtotime($item['check_in_book_z']);
			$tour_start_date_id = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id='".$item['tour_id_z']."' and start_date='".$start_date."'");
			$tour_start_date_id=$tour_start_date_id[0]['tour_start_date_id'];
			$available = $clsTourStartDate->getSeatAvailable($tour_start_date_id) - $total_number;
//					print_r($available);die();
			$clsTourStartDate->updateOne($tour_start_date_id,"seat_available='".$available."'");
		}
		
		if($totalPriceDeposit > 0){
			$clsBillingHistory = new BillingHistory();
			$cart_store = unserialize($cart_store);
			$assign_list["tour_cart_store"] = (isset($cart_store['TOUR']))?$cart_store['TOUR']:'';
			$assign_list["hotel_cart_store"] = (isset($cart_store['HOTEL']))?$cart_store['HOTEL']:'';
			$assign_list["cruise_cart_store"] = (isset($cart_store['CRUISE']))?$cart_store['CRUISE']:'';
			$assign_list["voucher_cart_store"] = (isset($cart_store['VOUCHER']))?$cart_store['VOUCHER']:'';			

			$max_id = $clsBillingHistory->getMaxId(); $assign_list['max_id'] = $max_id;
			$user_id       = $core->_USER['user_id'];
			$assign_list['customer_name'] = $full_name;
			$assign_list['customer_email'] = $email;
			$assign_list['customer_phone'] = $phone;
			$assign_list['deposit_bill'] = $totalPriceDeposit;  $assign_list['money'] = $totalPriceDeposit;
			$assign_list['balance'] = $totalRemaining;
			$assign_list['payment_term'] = 0;
			$assign_list['totalgrand'] = $totalGrand;
			$html_bill = $clsISO->build('bill.tpl');
			$bill_code = time();
			$field = $clsBillingHistory->pkey.",booking_id,bill_money,payment_method,note,reg_date,payment_term,html_bill,user_id,customer_name,customer_email,customer_phone,bill_code";
			$value = "'".$max_id."','".$booking_id."','".$totalPriceDeposit."','".intval($_POST['payment_method'])."','".$_POST['customer_note']."','".time()."','0','".addslashes(trim($html_bill))."','".$user_id."','".$full_name."','".$email."','".$phone."','".$bill_code."'";
			$clsBillingHistory->insertOne($field,$value);
		}
		
		vnSessionDelVar('BookingTourAdm_'.$_LANG_ID);
		vnSessionDelVar('BookingVoucherAdm_'.$_LANG_ID);
		vnSessionDelVar('BookingComboAdm_'.$_LANG_ID);
		vnSessionDelVar('BookingHotelAdm_'.$_LANG_ID);
		vnSessionDelVar('SessionChooseRoomAdm');
		vnSessionDelVar('BookingCruiseAdm_'.$_LANG_ID);
		vnSessionDelVar('SessionChooseCabinAdm');
		if(PAYMENT_GLOBAL){
			$clsBilling = new Billing();
			$clsBilling->initPay($booking_id);
		}
		
		
		echo PCMS_URL . '/?mod=' . $mod . '&act=list_booking' . '&message=UpdateSuccess';die;
	}else{		
		echo PCMS_URL . '/?mod=' . $mod . '&act=list_booking' . '&message=UpdateFailed';die;
	}

}
?>