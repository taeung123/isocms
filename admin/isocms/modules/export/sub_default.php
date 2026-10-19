<?php
function default_default() {
	// error_reporting(E_ALL);
	// ini_set('display_errors', '1');
	// ini_set('display_startup_errors', '1');
	
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
	
	if($type=='excel_feedback'){
		$clsFeedback = new Feedback();
		$clsCountry = new _Country();
		$clsCity = new City();
		$from_date=vnSessionGetVar('from_date');
		$from_date=str_replace('/','-',$from_date);
		
		$from_date=strtotime($from_date);
		$to_date=vnSessionGetVar('to_date');
		$to_date=str_replace('/','-',$to_date);
		$to_date=strtotime($to_date);
		
		$cond = "1=1";
		if(isset($_GET['is_process']) && $_GET['is_process'] != '') {
			$is_process = $_GET['is_process'];
			$cond.= " and is_process = '$is_process'";
		}
        if (!empty($_GET["act"])) {
            $cond.= " and type = '$_GET[act]'";
        }
//		$cond.= " and reg_date >='".$from_date."' and reg_date <='".$to_date."'";
        $cond .= " ORDER BY feedback_id DESC";
		$lstFeedback = $clsFeedback->getAll($cond);
		if(is_array($lstFeedback) && count($lstFeedback) > 0){

			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			//date_default_timezone_set('Europe/London');
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			$creator = PAGE_NAME;	
			$titlePage = '# Feedback';
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), $core->get_Lang('Type'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), $core->get_Lang('Feedback code'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), $core->get_Lang('Title'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), $core->get_Lang('Full Name'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), $core->get_Lang('Phone number'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), $core->get_Lang('Special Requests'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), $core->get_Lang('Email'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), $core->get_Lang('City'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), $core->get_Lang('Contact date'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), $core->get_Lang('Status'));
			
			for($i=0;$i<count($lstFeedback);$i++){
				$oneItem = $clsFeedback->getOne($lstFeedback[$i][$clsFeedback->pkey]);
				$feedback_store = $clsFeedback->getFeedBackInfo($lstFeedback[$i][$clsFeedback->pkey]);
                $note = $clsFeedback->getNote($lstFeedback[$i][$clsFeedback->pkey]);
				#
				$HTML_STATUS = '';
				if($lstFeedback[$i]['is_process'] == 1) {
					$HTML_STATUS.= $core->get_Lang('Offered');
				} elseif($lstFeedback[$i]['is_process'] == 2) {
					$HTML_STATUS.= $core->get_Lang('Reviewed');
				} else {
					$HTML_STATUS.= $core->get_Lang('Reminding');
				}
				#
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstFeedback[$i][$clsFeedback->pkey]);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), 'Contact');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $lstFeedback[$i]['feedback_code']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsISO->getNameTitle($feedback_store['title']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $feedback_store['fullname']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $feedback_store['phone']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $note);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $feedback_store['email']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $clsCity->getTitle($feedback_store['city_id']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $clsISO->formatDate($lstFeedback[$i]['reg_date']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $HTML_STATUS);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().'-Feedback.xls');
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
			vnSessionDelVar('from_date');
			vnSessionDelVar('to_date');
			exit;
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}else if($type=='excel_service'){
		$clsBooking = new Booking();
		$clsService = new Service();
		$clsCountry = new _Country();
		$from_date=vnSessionGetVar('from_date');
		$from_date=str_replace('/','-',$from_date);
		
		$from_date=strtotime($from_date);
		$to_date=vnSessionGetVar('to_date');
		$to_date=str_replace('/','-',$to_date);
		$to_date=strtotime($to_date);
		
		$cond = "1=1 and clsTable='Service'";
		if(isset($_GET['is_process']) && $_GET['is_process'] != '') {
			$is_process = $_GET['is_process'];
			$cond.= " and is_process = '$is_process'";
		}
		$cond.= " and reg_date >='".$from_date."' and reg_date <='".$to_date."'";
		
		//print_r($cond); die();
		$lstBooking = $clsBooking->getAll($cond);
		if(is_array($lstBooking) && count($lstBooking) > 0){
			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			$creator = PAGE_NAME;	
			$titlePage = '# Service';
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), $core->get_Lang('Type'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), $core->get_Lang('Service code'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), $core->get_Lang('Full Name'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), $core->get_Lang('Phone number'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), $core->get_Lang('Special Requests'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), $core->get_Lang('Email'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), $core->get_Lang('Address'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), $core->get_Lang('Contact date'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), $core->get_Lang('Status'));
			
			for($i=0;$i<count($lstBooking);$i++){
				
				$BOOKINGVALUE = $clsBooking->getBookingValue($lstBooking[$i][$clsBooking->pkey]);
				$assign_list["BOOKINGVALUE"] = $BOOKINGVALUE;
				#
				$HTML_STATUS = '';
				if($lstService[$i]['is_process'] == 1) {
					$HTML_STATUS.= $core->get_Lang('Offered');
				} elseif($lstService[$i]['is_process'] == 2) {
					$HTML_STATUS.= $core->get_Lang('Reviewed');
				} else {
					$HTML_STATUS.= $core->get_Lang('Reminding');
				}
				#
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstBooking[$i][$clsBooking->pkey]);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), 'Service');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $lstBooking[$i]['booking_code']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsBooking->getContactName($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $clsBooking->getPhone($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2),$BOOKINGVALUE['message']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $clsBooking->getEmail($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $clsBooking->getAddress($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $clsISO->formatDate($lstBooking[$i]['reg_date']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $HTML_STATUS);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().'-BookingService.xls');
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
			vnSessionDelVar('from_date');
			vnSessionDelVar('to_date');
			exit;
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}
	else if($type=='excel_hotel'){
		$clsBooking = new Booking();
		$clsHotel = new Hotel();
		$clsCountry = new _Country();
		$clsTailorProperty = new TailorProperty();
		
		$cond = "1=1 and clsTable = 'Hotel'";
		if(isset($_GET['status']) && $_GET['status'] != '') {
			$cond.= " and status = '".$_GET['status']."'";
		}
		
		$from_date=vnSessionGetVar('from_date');
		$from_date=str_replace('/','-',$from_date);
		
		$from_date=strtotime($from_date);
		$to_date=vnSessionGetVar('to_date');
		$to_date=str_replace('/','-',$to_date);
		$to_date=strtotime($to_date);

		$cond.= " and reg_date >='".$from_date."' and reg_date <='".$to_date."'";
		#
		
		$lstBooking = $clsBooking->getAll($cond);
		if(is_array($lstBooking) && count($lstBooking) > 0){
			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			$creator = PAGE_NAME;	
			$titlePage = '# Booking Hotel';
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), $core->get_Lang('Booking code'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), $core->get_Lang('FullName'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), $core->get_Lang('Email'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), $core->get_Lang('Phone'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), $core->get_Lang('Nationality'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), $core->get_Lang('Special Requests'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), $core->get_Lang('Name of hotel')); 
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), $core->get_Lang('Address'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), $core->get_Lang('Check-in'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), $core->get_Lang('Check-out'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), $core->get_Lang('Number of guest'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.(1), $core->get_Lang('Total Booking'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.(1), $core->get_Lang('Status'));
				
			for($i=0;$i<count($lstBooking);$i++){
				#
				$oneHotel = $clsHotel->getOne($lstBooking[$i]['target_id']);
				
				$BOOKINGVALUE = $clsBooking->getBookingValue($lstBooking[$i][$clsBooking->pkey]);
				$assign_list["BOOKINGVALUE"] = $BOOKINGVALUE;
					
				#
				$HTML_STATUS = '';
				if($lstBooking[$i]['status'] == 1) {
					$HTML_STATUS.= $core->get_Lang('Offered');
				} elseif($lstBooking[$i]['status'] == 2) {
					$HTML_STATUS.= $core->get_Lang('Reviewed');
				} else {
					$HTML_STATUS.= $core->get_Lang('Reminding');
				}
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstBooking[$i][$clsBooking->pkey]);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $lstBooking[$i]['booking_code']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $clsBooking->getFullName($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsBooking->getEmail($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $clsBooking->getPhone($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $clsBooking->getCountry($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $clsBooking->getRequest($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $clsHotel->getTitle($lstBooking[$i]['target_id']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $clsHotel->getAddress($lstBooking[$i]['target_id']));
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $BOOKINGVALUE['checkin']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $BOOKINGVALUE['checkout']);
				
				//print_r(xxx); die();
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $clsBooking->getNumberGuest($lstBooking[$i][$clsBooking->pkey]));
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2), $clsHotel->getPriceExport($lstBooking[$i]['target_id']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+2), $HTML_STATUS);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().'-BookingHotel.xls');
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
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}
	else if($type=='excel_cruise'){
		$clsBooking = new Booking();
		$clsCruise = new Cruise();
		$clsCruiseCabin = new CruiseCabin();
		$clsCountry = new _Country();
		$clsTailorProperty = new TailorProperty();
		
		$cond = "1=1 and clsTable = 'Cruise'";
		if(isset($_GET['status']) && $_GET['status'] != '') {
			$cond.= " and status = '".$_GET['status']."'";
		}
		
		$from_date=vnSessionGetVar('from_date');
		$from_date=str_replace('/','-',$from_date);
		
		$from_date=strtotime($from_date);
		$to_date=vnSessionGetVar('to_date');
		$to_date=str_replace('/','-',$to_date);
		$to_date=strtotime($to_date);

		$cond.= " and reg_date >='".$from_date."' and reg_date <='".$to_date."'";
		#
		
		$lstBooking = $clsBooking->getAll($cond);
		if(is_array($lstBooking) && count($lstBooking) > 0){
			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			$creator = PAGE_NAME;	
			$titlePage = '# Booking Cruise';
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), $core->get_Lang('Booking code'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), $core->get_Lang('FullName'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), $core->get_Lang('Email'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), $core->get_Lang('Phone'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), $core->get_Lang('Nationality'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), $core->get_Lang('Special Requests'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), $core->get_Lang('Name of Cruise')); 
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), $core->get_Lang('Name of Cabin'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), $core->get_Lang('Check-in'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), $core->get_Lang('Number of guest'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), $core->get_Lang('Total Booking'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.(1), $core->get_Lang('Status'));
				
			for($i=0;$i<count($lstBooking);$i++){
				#
				$oneCruise = $clsCruise->getOne($lstBooking[$i]['target_id']);
				
				$BOOKINGVALUE = $clsBooking->getBookingValue($lstBooking[$i][$clsBooking->pkey]);
				$assign_list["BOOKINGVALUE"] = $BOOKINGVALUE;
				if($_LANG_ID=='vn'){
					$totalPrice=$BOOKINGVALUE['totalGrand'];
					$totalPrice=number_format($totalPrice,0,",",".").' '.$clsISO->getRate();
				}else{
					$totalPrice=$BOOKINGVALUE['totalGrand'];
					$totalPrice=$clsISO->getRate().' '.number_format($totalPrice,0,",",".");
				}
				#
				$HTML_STATUS = '';
				if($lstBooking[$i]['status'] == 1) {
					$HTML_STATUS.= $core->get_Lang('Offered');
				} elseif($lstBooking[$i]['status'] == 2) {
					$HTML_STATUS.= $core->get_Lang('Reviewed');
				} else {
					$HTML_STATUS.= $core->get_Lang('Reminding');
				}
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstBooking[$i][$clsBooking->pkey]);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $lstBooking[$i]['booking_code']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $clsBooking->getFullName($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsBooking->getEmail($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $clsBooking->getPhone($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $clsBooking->getCountry($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $BOOKINGVALUE['content']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $clsCruise->getTitle($lstBooking[$i]['target_id']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $clsCruiseCabin->getTitle($BOOKINGVALUE['cruise_cabin_id']));
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $BOOKINGVALUE['departure_date']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $clsBooking->getNumberGuest($lstBooking[$i][$clsBooking->pkey]));
				
				//print_r(xxx); die();
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $totalPrice);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2), $HTML_STATUS);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().'-BookingCruise.xls');
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
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}
    else if ($type == 'export_tour') {
        $clsTour = new Tour();
		$lstTour = $clsTour->getAll();
		if (!is_array($lstTour) || count($lstTour) === 0) {
			header('Location: ' . $_SERVER['HTTP_REFERER'] . '&message=invalid');
			exit;
		}

		require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/phpexcel/PHPExcel.php';
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$objPHPExcel = new PHPExcel();
		$creator = PAGE_NAME;
		$titlePage = 'List Tour';

		/**
		 * Document properties
		 */
		$objPHPExcel->getProperties()
			->setCreator($creator)
			->setLastModifiedBy($creator)
			->setTitle($titlePage)
			->setSubject($titlePage)
			->setDescription('Tour list')
			->setKeywords('tour, list, export')
			->setCategory($creator);

		/**
		 * Active sheet
		 */
		$sheet = $objPHPExcel->setActiveSheetIndex(0);

		$sheet->setCellValue('A1', $core->get_Lang('ID'));
		$sheet->setCellValue('B1', $core->get_Lang('Title'));
		$sheet->setCellValue('C1', $core->get_Lang('Overview'));
		$sheet->setCellValue('D1', $core->get_Lang('Trip Code'));
		$sheet->setCellValue('E1', $core->get_Lang('Number day'));
		$sheet->setCellValue('F1', $core->get_Lang('Number night'));
		$sheet->setCellValue('G1', $core->get_Lang('Min Price'));
		$sheet->setCellValue('H1', $core->get_Lang('Deposit'));

		/**
		 * Data
		 */
		$row = 2;

		foreach ($lstTour as $tour) {

			$tourId = $tour[$clsTour->pkey];

			$sheet->setCellValue('A' . $row, $tourId);
			$sheet->setCellValue(
				'B' . $row,
				$clsTour->getTitle($tourId)
			);
			$sheet->setCellValue(
				'C' . $row,
				strip_tags($clsTour->getTripOverview($tourId))
			);
			$sheet->setCellValue(
				'D' . $row,
				$clsTour->getTripCode($tourId)
			);
			$sheet->setCellValue(
				'E' . $row,
				$clsTour->getNumberDay($tourId)
			);
			$sheet->setCellValue(
				'F' . $row,
				$tour['number_night']
			);
			$sheet->setCellValue(
				'G' . $row,
				$clsTour->getTripMinPrice($tourId)
			);
			$sheet->setCellValue(
				'H' . $row,
				$clsTour->getDeposit($tourId)
			);

			$row++;
		}

		/**
		 * Worksheet
		 */
		$sheet->setTitle('List Tour');

		$objPHPExcel->setActiveSheetIndex(0);

		/**
		 * IMPORTANT:
		 * Remove all previous output before sending Excel headers.
		 */
		while (ob_get_level() > 0) {
			ob_end_clean();
		}

		/**
		 * Download headers
		 */
		$filename = 'ListTour-' . date('Ymd-His') . '.xls';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: public');

		/**
		 * Write Excel
		 */
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

		exit;
    }
	else if($type=='excel_tour'){

		$clsBooking = new Booking();
		$clsTour = new Tour();
		$assign_list["clsTour"] = $clsTour;
		$clsCountry = new _Country();
		$clsTailorProperty = new TailorProperty();
		$cond = "1=1 and clsTable = 'Tour'";
		
		if(isset($_GET['status']) && $_GET['status'] != '') {
			$cond.= " and status = '".$_GET['status']."'";
		}

		$from_date=vnSessionGetVar('from_date');
		$from_date=str_replace('/','-',$from_date);
		$from_date=strtotime($from_date);
        
		$to_date=vnSessionGetVar('to_date');
		$to_date=str_replace('/','-',$to_date);
		$to_date=strtotime($to_date);

		$cond.= " and reg_date >='".$from_date."' and reg_date <='".$to_date."'";
		
		#
		$lstBooking = $clsBooking->getAll($cond);
		if(is_array($lstBooking) && count($lstBooking) > 0){
				require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
				date_default_timezone_set('Asia/Ho_Chi_Minh');
				// Create new PHPExcel object
				$objPHPExcel = new PHPExcel();
				$creator = PAGE_NAME;	
				$titlePage = '# Booking Tour';
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
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), $core->get_Lang('Type'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), $core->get_Lang('Service Code'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), $core->get_Lang('Order Date'));    
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), $core->get_Lang('Total Grand'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), $core->get_Lang('Full Name'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), $core->get_Lang('Phone'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), $core->get_Lang('Address'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), $core->get_Lang('Special Requests'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), $core->get_Lang('Email'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), $core->get_Lang('Nationality'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), $core->get_Lang('Status'));
				
				for($i=0;$i<count($lstBooking);$i++){
					$oneTour = $clsTour->getOne($lstBooking[$i]['target_id']);
					$BOOKINGVALUE = $clsBooking->getBookingValue($lstBooking[$i][$clsBooking->pkey]);
					$assign_list["BOOKINGVALUE"] = $BOOKINGVALUE;

					#
					if($_LANG_ID=='vn'){
						$totalPrice=$lstBooking[$i]['totalgrand'];
						$totalPrice=number_format($totalPrice,0,",",".").' '.$clsISO->getRate();
					}else{
						$totalPrice=$lstBooking[$i]['totalgrand'];
						$totalPrice=$clsISO->getRate().' '.number_format($totalPrice,0,",",".");
					}
					#
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstBooking[$i][$clsBooking->pkey]);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), 'Tour Book');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $lstBooking[$i]['booking_code']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsISO->formatDate($lstBooking[$i]['reg_date']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $totalPrice);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $clsBooking->getContactName($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $clsBooking->getPhone($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $clsBooking->getAddressExcel($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $BOOKINGVALUE['note']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $clsBooking->getEmail($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $clsBooking->getCountry($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $clsBooking->getStatusPayment($lstBooking[$i][$clsBooking->pkey]));
					
				}
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().'-BookingTour.xls');
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
	}else if($type=='excel_subscribe'){
		$clsSubscribe = new Subscribe();
		$lstSubscribe = $clsSubscribe->getAll($cond);
		if(is_array($lstSubscribe) && count($lstSubscribe) > 0){
			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			date_default_timezone_set('Asia/Ho_Chi_Minh');
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.(1), $core->get_Lang('ID'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), $core->get_Lang('FullName'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), $core->get_Lang('Email'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), 'Subscribe Date');
				
			for($i=0;$i<count($lstSubscribe);$i++){
				#
				$oneHotel = $clsSubscribe->getOne($lstSubscribe[$i]['subscribe_id']);
					
				#
				$HTML_STATUS = '';
				if($lstSubscribe[$i]['status'] == 1) {
					$HTML_STATUS.= 'Offered';
				} elseif($lstSubscribe[$i]['status'] == 2) {
					$HTML_STATUS.= 'Reviewed';
				} else {
					$HTML_STATUS.= 'Reminding';
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstSubscribe[$i][$clsSubscribe->pkey]);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $clsSubscribe->getEmail($lstSubscribe[$i][$clsSubscribe->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $clsSubscribe->getEmail($lstSubscribe[$i][$clsSubscribe->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2),  $clsISO->formatDate($lstSubscribe[$i]['departure_date']));
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
			ob_end_clean();
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}else if($type=='excel_tailortour'){
		$clsTour = new Tour();
		$clsBooking = new Booking();
		$clsCountry = new _Country();
		$clsTailorProperty = new TailorProperty();
		
		$cond = "1=1 and clsTable = 'Tailor'";
		if(isset($_GET['status']) && $_GET['status'] != '') {
			$cond.= " and status = '".$_GET['status']."'";
		}
		#
		$lstBooking = $clsBooking->getAll($cond);
		if(is_array($lstBooking) && count($lstBooking) > 0){
			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			$creator = PAGE_NAME;	
			$titlePage = '# Tour Request';
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), 'Type');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), 'Service Code');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), 'Order Date');    
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), 'Departure Date');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), 'Service/Subject name');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), 'During'); 
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), 'Quality');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), 'No. of guest');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), 'Title');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), 'First Name');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), 'Last Name');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.(1), 'Phone');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.(1), 'Address');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.(1), 'Special Requests');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.(1), 'Email');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.(1), 'Take Care');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.(1), 'Nationality');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.(1), 'Status');
			for($i=0;$i<count($lstBooking);$i++){
				#
				$HTML_STATUS = '';
				if($lstBooking[$i]['status'] == 1) {
					$HTML_STATUS.= 'Offered';
				} elseif($lstBooking[$i]['status'] == 2) {
					$HTML_STATUS.= 'Reviewed';
				} else {
					$HTML_STATUS.= 'Reminding';
				}
				#
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstBooking[$i][$clsBooking->pkey]);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), 'Tour Request');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $lstBooking[$i]['booking_code']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsISO->formatDate($lstBooking[$i]['reg_date']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $clsBooking->getDepartureDate($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), 'Confirmation Tailor Made Tour');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $clsBooking->getDuration($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $clsBooking->getTotalGuest($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $clsBooking->getNumberGuest($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $clsBooking->getTitle($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $clsBooking->getFirstName($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $clsBooking->getLastName($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2), $clsBooking->getPhone($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+2), $clsBooking->getAddress($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+2), $clsBooking->getRequest($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+2), $clsBooking->getEmail($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($i+2), $clsBooking->getTakeCare($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($i+2), $clsBooking->getCountry($lstBooking[$i][$clsBooking->pkey]));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($i+2), $HTML_STATUS);
			}
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().' - Tour Request.xls');
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
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}
}
?>