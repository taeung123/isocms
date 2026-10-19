<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Subscribe";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if($_POST['keyword']!='' && $_POST['keyword']!='Transport title, intro'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	if(isset($_POST['Export'])&&$_POST['Export']=='Export'){
		$link= '?mod=export&type=excel_subscribe';
		if($status!=''){
			$link .= '&status='.$status.'';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: '.PCMS_URL.'/'.$link);
	}
	
	$cond = "1='1'";
	#- Filter By Keyword
	if(isset($_GET['keyword']) && $_GET['keyword']!=''){
		$cond .= " and (fullname like '%".$_GET['keyword']."%' or email like '%".$_GET['keyword']."%')";
		$assign_list["keyword"] = $_GET['keyword'];
	}
	$cond2 = $cond;
	if($type_list=='Active'){
		$cond .= " and is_trash=0";
	}
	if($type_list=='Trash'){
		$cond .= " and is_trash=1";
	}
	$orderBy = " reg_date asc";
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
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit); //print_r($cond." order by ".$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;
	
	if(!empty($allItem)) {
		$htmlEmail = '';
		for($i=0;$i<count($allItem);$i++){
			$htmlEmail.= ($i==0 ? '' : ', ').$allItem[$i]['email'];
		}
		$assign_list["htmlEmail"] = $htmlEmail;
	}
	#
	$assign_list["number_all"] = $clsClassTable->getAll($cond2)?count($clsClassTable->getAll($cond2)):0;
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Subscribe";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
	$pvalTable = intval($core->decryptID($string));
	if($pvalTable == ""){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=notPermission');
	}
			
	if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=DeleteSuccess');
	}
}
function default_export(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	require_once DIR_CLASSES ."/class_Subscribe.php";
		
	$clsSubscribe = new Subscribe();

	$lstBooking = $clsSubscribe->getAll($cond);
	if(is_array($lstBooking) && count($lstBooking) > 0){
	require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
	date_default_timezone_set('Europe/London');
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	$creator = PAGE_NAME;	
	$titlePage = '# Subscribe';
	// Set document properties
	$objPHPExcel->getProperties()->setCreator($creator)
								 ->setLastModifiedBy("")
								 ->setTitle($titlePage)
								 ->setSubject($titlePage)
								 ->setDescription("")
								 ->setKeywords("email list")
								 ->setCategory($creator);
	
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.(1), 'ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), 'FullName');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), 'Email');
		
	for($i=0;$i<count($lstBooking);$i++){
		#
		$oneHotel = $clsSubscribe->getOne($lstBooking[$i]['subscribe_id']);
			
		#
		$HTML_STATUS = '';
		if($lstBooking[$i]['status'] == 1) {
			$HTML_STATUS.= 'Offered';
		} elseif($lstBooking[$i]['status'] == 2) {
			$HTML_STATUS.= 'Reviewed';
		} else {
			$HTML_STATUS.= 'Reminding';
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstBooking[$i][$clsSubscribe->pkey]);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $clsSubscribe->getEmail($lstBooking[$i][$clsSubscribe->pkey]));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $clsSubscribe->getEmail($lstBooking[$i][$clsSubscribe->pkey]));
	}
	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle($titlePage);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client's web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="#'.time().' - Subscribe.xls');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	ob_clean();
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}else{
	header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
}
}
?>