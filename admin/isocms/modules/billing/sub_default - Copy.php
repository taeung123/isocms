<?php
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
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	$assign_list["status"] = $status;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		if(isset($_POST['status']) &&  $_POST['status']!=''){
			$link .= '&status='.$_POST['status'];
		}
		if($_POST['code']!=''&&$_POST['code']!=''){
			$link .= '&code='.$_POST['code'];
		}
		header('location: '.PCMS_URL.'/?mod='.$mod.$link);
	}
	if(isset($_POST['Export'])&&$_POST['Export']=='Export'){
		$link= '?mod=billing&act=export&type=excel_billing';
		if($status!=''){
			$link .= '&status='.$status.'';
		}
		vnSessionSetVar('from_date', $_POST['from_date']);
		vnSessionSetVar('to_date', $_POST['to_date']);
		header('location: '.PCMS_URL.'/'.$link);
	}
	/**/
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	#
	$classTable = "Billing";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;
	#
	$cond ='1=1';
	if($status != ''){
		$cond .= " and status='$status'";
	}
	#Filter By Keyword
	if(isset($_GET['code']) && !empty($_GET['code'])){
		$keyword = $core->replaceSpace($_GET['keyword']);
		$cond .= " and billing_code LIKE '%".$_GET['code']."%'";
		$assign_list["code"] = $_GET['code'];
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
function default_export() {
	error_reporting(E_ALL);
	ini_set('display_errors',1);
	
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting,$clsISO,$adult_type_id, $child_type_id, $infant_type_id;
	
	//print_r($adult_type_id.'x---x'.$child_type_id.'x---------x'.$infant_type_id); die();
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $t = isset($_GET['t']) ? $_GET['t'] : '';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$tid = isset($_GET['tid']) ? $_GET['tid'] : '';
	$f = isset($_GET['f'])?$_GET['f']:'';
	
	if($type=='excel_billing'){
		$clsBooking = new Booking();
		$clsBilling = new Billing();
		$clsTour = new Tour();
		$assign_list["clsTour"] = $clsTour;
		$clsCountry = new _Country();
		$clsTailorProperty = new TailorProperty();
		$cond = "1=1";
		
		if(isset($_GET['status']) && $_GET['status'] != '') {
			$cond.= " and status = '".$_GET['status']."'";
		}
		$from_date=vnSessionGetVar('from_date');
		$from_date=strtotime($from_date);
		$to_date=vnSessionGetVar('to_date');
		$to_date=strtotime($to_date);

		$cond.= " and reg_date >='".$from_date."' and reg_date <='".$to_date."'";

		#
		$lstBilling = $clsBilling->getAll($cond);
		if(is_array($lstBilling) && count($lstBilling) > 0){
				require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
				date_default_timezone_set('Asia/Ho_Chi_Minh');
				// Create new PHPExcel object
				$objPHPExcel = new PHPExcel();
				$creator = PAGE_NAME;	
				$titlePage = '# Billing';
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
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.(1), $core->get_Lang('ID'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), $core->get_Lang('Service Code'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), $core->get_Lang('Type'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), $core->get_Lang('Service/Subject name'));    
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), $core->get_Lang('Departure Date'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), $core->get_Lang('Number of guest')); 
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), $core->get_Lang('Pickup address')); 
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), $core->get_Lang('Billing method'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), $core->get_Lang('Total($)'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), $core->get_Lang('Total(đ)'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), $core->get_Lang('TotalPaid($)'));

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), $core->get_Lang('TotalPaid(đ)'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.(1), $core->get_Lang('UnPaid($)'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.(1), $core->get_Lang('UnPaid(đ)'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.(1), $core->get_Lang('Status'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.(1), $core->get_Lang('Date'));
				
				for($i=0;$i<count($lstBilling);$i++){
					#
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstBilling[$i][$clsBilling->pkey]);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $lstBilling[$i]['billing_code']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), 'Billing');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsBilling->getInfoService($lstBilling[$i][$clsBilling->pkey],'name'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $clsBilling->getInfoService($lstBilling[$i][$clsBilling->pkey],'departure'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $clsBilling->getInfoService($lstBilling[$i][$clsBilling->pkey],'number_guest'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $clsBilling->getInfoService($lstBilling[$i][$clsBilling->pkey],'pickup_address'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'billing_method'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'totalgrand'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'totalgrand_VND'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'deposit'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'deposit_VND'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'balance'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'balance_VND'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+2), $clsBilling->getFieldStatus($lstBilling[$i][$clsBilling->pkey],'status'));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+2), $clsBilling->getFieldValue($lstBilling[$i][$clsBilling->pkey],'reg_date'));
					
				}
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().' - Billing.xls');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			ob_end_clean();
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}
		else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}
}

?>