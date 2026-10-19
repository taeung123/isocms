<?php 
	error_reporting(E_ALL);
	ini_set('display_errors',1);
	
	define("PCMS_DIR", $_SERVER['DOCUMENT_ROOT']);
	define("PCMS_URL", "http://".$_SERVER['HTTP_HOST']);
	#Common Directory
	define("DIR_INCLUDES", 	PCMS_DIR."/inc");
	define("DIR_LANG", 		PCMS_DIR."/lang");
	define("DIR_LOGS", 		PCMS_DIR."/logs");
	define("DIR_THEMES", 	PCMS_DIR."/themes");
	define("DIR_TMP", 		PCMS_DIR."/tmp");
	define("DIR_UPLOADS",	PCMS_DIR."/uploads");
	define("DIR_CLASSES", 	PCMS_DIR."/classes");
	define("DIR_COMMON", 	DIR_INCLUDES."/iso");
	define("DIR_SMARTY", 	DIR_INCLUDES."/smarty");
	define("DIR_ADODB", 	DIR_INCLUDES."/adodb");
	define("DIR_PEAR", 		DIR_INCLUDES."/PEAR");
	define("DIR_LIB", 		DIR_INCLUDES."/lib");
	define("DIR_CONF", 		DIR_INCLUDES."/conf");
	//=================================================================================
	//Include needle file
	//=================================================================================
	require_once(PCMS_DIR."/config.php");
	require_once DIR_ADODB. '/adodb.inc.php';
	require_once DIR_COMMON .'/clsDbBasic.php';
	require_once DIR_CLASSES ."/class_Configuration.php";
	require_once DIR_CLASSES ."/class_ISO.php";
	require_once DIR_CLASSES ."/class_Country.php";
	require_once DIR_CLASSES ."/class__Country.php";
	#
	$dbconn = &ADONewConnection(DB_TYPE);
	if (isset($dbinfo) && is_array($dbinfo)){
		$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
	}else{
		$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}
	
	

/*	function isSecure() {
	  return
		(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
		|| $_SERVER['SERVER_PORT'] == 443;
	}*/
	$clsISO = new ISO();
	$clsConfiguration = new Configuration();
	
	$t = isset($_GET['t']) ? $_GET['t'] : '';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$tid = isset($_GET['tid']) ? $_GET['tid'] : '';
	$f = isset($_GET['f'])?$_GET['f']:'';
	
	
	if($type=='excel_feedback'){
		require_once(DIR_INCLUDES.'/core.php');
		require_once DIR_COMMON."/clsCore.php";
		require_once DIR_CLASSES ."/class_Feedback.php";
		require_once DIR_CLASSES ."/class__Country.php";
		$clsFeedback = new Feedback();
		$clsCountry = new _Country();
		
		$cond = "1=1";
		if(isset($_GET['is_process']) && $_GET['is_process'] != '') {
			$is_process = $_GET['is_process'];
			$cond.= " and is_process = '$is_process'";
		}

		$lstFeedback = $clsFeedback->getAll($cond);
		if(is_array($lstFeedback) && count($lstFeedback) > 0){
			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			date_default_timezone_set('Europe/London');
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.(1), 'ID');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), 'Type');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), 'Feedback code');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), 'Title');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), 'First Name');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), 'Last Name');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), 'Phone number');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), 'Address');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), 'Special Requests');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), 'Email');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), 'Nationality');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), 'Status');
			
			for($i=0;$i<count($lstFeedback);$i++){
				$oneItem = $clsFeedback->getOne($lstFeedback[$i][$clsFeedback->pkey]);
				$feedback_store = $clsFeedback->getFeedBackInfo($lstFeedback[$i][$clsFeedback->pkey]);
				#
				$HTML_STATUS = '';
				if($lstFeedback[$i]['is_process'] == 1) {
					$HTML_STATUS.= 'Offered';
				} elseif($lstFeedback[$i]['is_process'] == 2) {
					$HTML_STATUS.= 'Reviewed';
				} else {
					$HTML_STATUS.= 'Reminding';
				}
				#
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $lstFeedback[$i][$clsFeedback->pkey]);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), 'Contact');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $lstFeedback[$i]['feedback_code']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsISO->getNameTitle($feedback_store['title']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $feedback_store['firstname']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $feedback_store['lastname']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $feedback_store['phone']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $feedback_store['address']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $feedback_store['message']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $feedback_store['email']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $clsCountry->getTitle($feedback_store['countryex_id']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $HTML_STATUS);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().' - Feedback.xls');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}else if($type=='excel_hotel'){
		require_once DIR_CLASSES ."/class_Booking.php";
		require_once DIR_CLASSES ."/class_Hotel.php";
		require_once DIR_CLASSES ."/class_TailorProperty.php";
		require_once DIR_CLASSES ."/class_Profile.php";
		
		$clsBooking = new Booking();
		$clsHotel = new Hotel();
		$clsCountry = new _Country();
		$clsTailorProperty = new TailorProperty();
		
		$cond = "1=1 and clsTable = 'Hotel'";
		if(isset($_GET['status']) && $_GET['status'] != '') {
			$cond.= " and status = '".$_GET['status']."'";
		}
		
		#
		
		$lstBooking = $clsBooking->getAll($cond);
		if(is_array($lstBooking) && count($lstBooking) > 0){
			require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
			date_default_timezone_set('Europe/London');
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
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.(1), 'ID');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), 'Booking code');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), 'FullName');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), 'Email');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), 'Phone');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), 'Nationality');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), 'Special Requests');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), 'Name of hotel'); 
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), 'Address');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), 'Check-in');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), 'Check-out');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), 'Trip price');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.(1), 'Quality');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.(1), 'Total Booking');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.(1), 'Status');
				
			for($i=0;$i<count($lstBooking);$i++){
				#
				$oneHotel = $clsHotel->getOne($lstBooking[$i]['target_id']);
				
				$BOOKINGVALUE = $clsBooking->getBookingValue($lstBooking[$i][$clsBooking->pkey]);
				$assign_list["BOOKINGVALUE"] = $BOOKINGVALUE;
					
				#
				$HTML_STATUS = '';
				if($lstBooking[$i]['status'] == 1) {
					$HTML_STATUS.= 'Offered';
				} elseif($lstBooking[$i]['status'] == 2) {
					$HTML_STATUS.= 'Reviewed';
				} else {
					$HTML_STATUS.= 'Reminding';
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
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $clsHotel->getPriceExport($lstBooking[$i]['target_id']));
				//print_r(xxx); die();
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2), $clsBooking->getNumberGuest($lstBooking[$i][$clsBooking->pkey]));
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+2), $clsHotel->getPriceExport($lstBooking[$i]['target_id']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+2), $HTML_STATUS);
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($titlePage);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			// Redirect output to a client's web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="#'.time().' - Booking Hotel.xls');
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
	else if($type=='excel_tour'){

		require_once DIR_CLASSES ."/class_Booking.php";
		require_once DIR_CLASSES ."/class_Tour.php";
		require_once DIR_CLASSES ."/class_TailorProperty.php";
		
		$clsBooking = new Booking();
		$clsTour = new Tour();
		$assign_list["clsTour"] = $clsTour;
		$clsCountry = new _Country();
		$clsTailorProperty = new TailorProperty();
		
		$cond = "1=1 and clsTable = 'Tour'";
		if(isset($_GET['status']) && $_GET['status'] != '') {
			$cond.= " and status = '".$_GET['status']."'";
		}
		#
		
		$lstBooking = $clsBooking->getAll($cond);
		if(is_array($lstBooking) && count($lstBooking) > 0){
			
				require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
				date_default_timezone_set('Europe/London');
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
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.(1), 'ID');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), 'Type');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), 'Service Code');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), 'Order Date');    
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), 'Departure Date');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), 'Service/Subject name'); 
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), 'Duration'); 
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.(1), 'Quality');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.(1), 'Total Booking');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.(1), 'Full Name');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.(1), 'Phone');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.(1), 'Address');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.(1), 'Special Requests');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.(1), 'Email');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.(1), 'Nationality');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.(1), 'Status');
				
				for($i=0;$i<count($lstBooking);$i++){
					$oneTour = $clsTour->getOne($lstBooking[$i]['target_id']);
					$BOOKINGVALUE = $clsBooking->getBookingValue($lstBooking[$i][$clsBooking->pkey]);
					$assign_list["BOOKINGVALUE"] = $BOOKINGVALUE;
					if($BOOKINGVALUE['a']> 0 && $BOOKINGVALUE['b'] > 0 && $BOOKINGVALUE['c']> 0){
						$totalGuest=$BOOKINGVALUE['a']. 'adult, ' .$BOOKINGVALUE['b']. 'child, ' .$BOOKINGVALUE['c']. 'baby' ;
					}elseif($BOOKINGVALUE['b']> 0 && $BOOKINGVALUE['c']= 0){
						$totalGuest=$BOOKINGVALUE['a']. 'adult, ' .$BOOKINGVALUE['b']. 'child' ;
					}elseif($BOOKINGVALUE['b']= 0 && $BOOKINGVALUE['c']> 0){
						$totalGuest=$BOOKINGVALUE['a']. 'adult, ' .$BOOKINGVALUE['c']. 'baby' ;
					}else{
						$totalGuest=$BOOKINGVALUE['a']. 'adult' ;
					}
				
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
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), 'Tour Book');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $lstBooking[$i]['booking_code']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $clsISO->formatDate($lstBooking[$i]['reg_date']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $BOOKINGVALUE['departure_date']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $clsTour->getTitle($lstBooking[$i]['target_id']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), $clsTour->getTripDuration($lstBooking[$i]['target_id']));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2), $totalGuest);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2), $BOOKINGVALUE['tien1']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2), $clsBooking->getContactName($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2), $clsBooking->getPhone($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2), $clsBooking->getAddress($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2), $BOOKINGVALUE['note']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+2), $clsBooking->getEmail($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+2), $clsBooking->getCountry($lstBooking[$i][$clsBooking->pkey]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+2), $HTML_STATUS);
					
						
				// Rename worksheet
				$objPHPExcel->getActiveSheet()->setTitle($titlePage);
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);
				// Redirect output to a client's web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="#'.time().' - Booking Tour.xls');
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
			}
		}
		else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}else if($type=='excel_subscribe'){
		require_once DIR_CLASSES ."/class_Subscribe.php";
		
		$clsSubscribe = new Subscribe();
		
		$lstSubscribe = $clsSubscribe->getAll($cond);
		if(is_array($lstSubscribe) && count($lstSubscribe) > 0){
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
	}else if($type=='excel_subscribe'){
		require_once DIR_CLASSES ."/class_Subscribe.php";
		
		$clsSubscribe = new Subscribe();
		
		$lstSubscribe = $clsSubscribe->getAll($cond);
		if(is_array($lstSubscribe) && count($lstSubscribe) > 0){
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
	else if($type=='excel_tailortour'){
		require_once DIR_CLASSES ."/class_Booking.php";
		require_once DIR_CLASSES ."/class_Tour.php";
		require_once DIR_CLASSES ."/class_TailorProperty.php";
		
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
			if($f == 'excel') {
				require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
				date_default_timezone_set('Europe/London');
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
				ob_clean();
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
			}
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER'].'&message=invalid');
		}
	}elseif($type=='invoices'){
		require_once DIR_CLASSES ."/class_TaInvoices.php";
		require_once DIR_CLASSES ."/class_TaInvoiceType.php";
		require_once DIR_CLASSES ."/class_TaInvoiceMethod.php";
		require_once DIR_CLASSES ."/class_TaBank.php";
		require_once DIR_CLASSES ."/class_TaInvoiceDependentcy.php";
		require_once DIR_CLASSES ."/class_Profile.php";
		require_once DIR_CLASSES ."/class_Profile.php";
		require_once DIR_CLASSES ."/class_ISO.php";
		require_once $_SERVER['DOCUMENT_ROOT']."/inc/phpexcel/PHPExcel.php";
		date_default_timezone_set('Europe/London');
		#
		$clsTaInvoices = new TaInvoices();
		$clsTaInvoiceType = new TaInvoiceType();
		$clsTaInvoiceMethod = new TaInvoiceMethod();
		$clsTaBank = new TaBank();
		$clsProfile = new Profile();
		$clsTaInvoiceDependentcy = new TaInvoiceDependentcy();
		$clsISO = new ISO();
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$creator = PAGE_NAME;	
		$titlePage = '# Invoices';
		// Set document properties
		$objPHPExcel->getProperties()->setCreator($creator)
									 ->setLastModifiedBy("")
									 ->setTitle($titlePage)
									 ->setSubject($titlePage)
									 ->setDescription("")
									 ->setKeywords("invoice list")
									 ->setCategory($creator);
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.(1), 'ID');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.(1), 'Số hóa đơn');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.(1), 'Lý do thu');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.(1), 'Loại phiếu thu');    
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.(1), 'Khách hàng');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.(1), 'Amount'); 
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.(1), 'Ngày tạo');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(20);
		if( !isset($_GET['year']) ){			
			$_GET['year'] = date("Y");
		}
		if( !isset($_GET['month']) ){			
			$_GET['month'] = date("m");
		}	
		$getData = $_GET;
		$typeExport = $getData['type_ex'];
		$year = intval($_GET['year']);
		$quarter = isset($_GET['quarter']) ? intval($_GET['quarter']) : '';
		$cond = " is_trash=0 and cancel=0 ";
		if( $typeExport =='CONGNO' ){
			$cond .= " and owed <> 0 ";
		}
		
		switch( $getData['act'] ){
			case 'default':
				if( !isset($getData['week']) ){
					$ddate = date("Y-m-d");
					$date = new DateTime($ddate);		
					$_GET['week'] = trim($date->format("W"));
				}
				$assign_list["getUrl"] = $_GET;
				$week_start = date('d/m/Y');	
				$lstWeeks = $clsISO->getWeeksInYear($week_start,false);	
				
				$start_date = str_replace('/','-',reset($lstWeeks[$_GET['week']]));
				$end_date =  str_replace('/','-',end($lstWeeks[$_GET['week']]));
				$cond .= " and reg_date>='".strtotime($start_date.' 00:00:00')."' and reg_date<='".strtotime($end_date.' 23:59:59')."'";
				$cond .=" ORDER BY reg_date DESC";
				$lstItem = $dbconn->getAll("SELECT *,FROM_UNIXTIME(reg_date,'%d/%m/%Y') as date FROM default_ta_invoices WHERE ".$cond);
				if( !empty( $lstItem ) ){
					foreach( $lstItem as $key=>$value ){
						$i = $key;
						$oneUser = $dbconn->getAll("SELECT * FROM default_user WHERE user_id='".$value['user_id']."' limit 0,1 ");						
						$username="";
						if( !empty( $oneUser ) ){
							$username = $oneUser[0]['user_name'];
						}
						$type = $clsTaInvoiceType->getTitle($value['type_id']);
						$profileEmail = $clsProfile->getEmail($value['profile_id']);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $value[$clsTaInvoices->pkey]);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $value['number_bill'] );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $value['reason']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $type );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $profileEmail );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $value['amount']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), date('d/m/Y',$value['reg_date']) );
					}
				}								
			//week
			break;
			case 'month':
				$week_start = date('d').'/'.$_GET['month'].'/'.$year;
				$arrData = $clsISO->getWeeksInYear($week_start);
				$start_date = str_replace('/','-',reset(reset($arrData)));
				$end_date =  str_replace('/','-',end(end($arrData)));
									
				$cond .= " and reg_date>='".strtotime($start_date.' 00:00:00')."'";
				$cond .= " and reg_date<='".strtotime($end_date.' 23:59:59')."'";
				$cond .=" ORDER BY reg_date DESC";					
				$lstItem = $dbconn->getAll("SELECT *,FROM_UNIXTIME(reg_date,'%d/%m/%Y') as date FROM default_ta_invoices WHERE ".$cond);								
				if( !empty( $lstItem ) ){
					foreach( $lstItem as $key=>$value ){
						$i = $key;
						$oneUser = $dbconn->getAll("SELECT * FROM default_user WHERE user_id='".$value['user_id']."' limit 0,1 ");						
						$username="";
						if( !empty( $oneUser ) ){
							$username = $oneUser[0]['user_name'];
						}
						$type = $clsTaInvoiceType->getTitle($value['type_id']);
						$profileEmail = $clsProfile->getEmail($value['profile_id']);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $value[$clsTaInvoices->pkey]);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $value['number_bill'] );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $value['reason']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $type );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $profileEmail );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $value['amount']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), date('d/m/Y',$value['reg_date']) );
					}
				}
			//month
			break;
			case 'quarter':
				$quarter = "quarter_".$quarter;
				$arrMonth = $clsISO->getMonthsOfQuarter($quarter);	
				$arrMonthList = array();	
				#
				$arrData = $clsISO->get_dates_of_quarter($quarter, $year,'d-m-Y');
				
				$start_date = reset($arrData);
				$end_date =  end($arrData);
				$cond .= " and reg_date>='".strtotime($start_date.' 00:00:00')."'";
				$cond .= " and reg_date<='".strtotime($end_date.' 23:59:59')."'";
				$cond .= " ORDER BY reg_date DESC";						
				$lstItem = $dbconn->getAll("SELECT *,FROM_UNIXTIME(reg_date,'%d/%m/%Y') as date FROM default_ta_invoices WHERE ".$cond);								
				if( !empty( $lstItem ) ){
					foreach( $lstItem as $key=>$value ){
						$i = $key;
						$oneUser = $dbconn->getAll("SELECT * FROM default_user WHERE user_id='".$value['user_id']."' limit 0,1 ");						
						$username="";
						if( !empty( $oneUser ) ){
							$username = $oneUser[0]['user_name'];
						}
						$type = $clsTaInvoiceType->getTitle($value['type_id']);
						$profileEmail = $clsProfile->getEmail($value['profile_id']);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $value[$clsTaInvoices->pkey]);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $value['number_bill'] );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $value['reason']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $type );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $profileEmail );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $value['amount']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), date('d/m/Y',$value['reg_date']) );
					}
				}
			//quarter
			break;
			case 'year':	
				//year																		
				if( $year !='' ){
					$cond .= " AND FROM_UNIXTIME(reg_date,'%Y') =$year";
				}
				$cond .= " ORDER BY reg_date DESC";	
				$lstItem = $dbconn->getAll( "SELECT * FROM default_ta_invoices WHERE ".$cond );							
				if( !empty( $lstItem ) ){
					foreach( $lstItem as $key=>$value ){
						$i = $key;
						$oneUser = $dbconn->getAll("SELECT * FROM default_user WHERE user_id='".$value['user_id']."' limit 0,1 ");						
						$username="";
						if( !empty( $oneUser ) ){
							$username = $oneUser[0]['user_name'];
						}
						$type = $clsTaInvoiceType->getTitle($value['type_id']);
						$profileEmail = $clsProfile->getEmail($value['profile_id']);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2), $value[$clsTaInvoices->pkey]);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2), $value['number_bill'] );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2), $value['reason']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2), $type );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2), $profileEmail );
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2), $value['amount']);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2), date('d/m/Y',$value['reg_date']) );
					}
				}			
			break;
			default:
			break;
		}
		
		
		$objPHPExcel->getActiveSheet()->setTitle($titlePage);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client's web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="#'.time().' - "'.$typeExport.'".xls');
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
	}
	else{
		die('Not found request');
	}
	
?>