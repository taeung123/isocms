<?php
function default_default()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsCommon, $oneCommon, $clsConfiguration, $clsISO;
}
function default_redirect()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsCommon, $oneCommon, $clsConfiguration, $clsISO, $extLang;
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;
	#
	$billing_id = isset($_GET['billing_id']) ? $core->decryptID($_GET['billing_id']) : "";
	if ($billing_id == 0) {
		redirect('/');
	}
	$assign_list["billing_id"] = $billing_id;
	$booking_id = $clsBilling->getOneField('booking_id', $billing_id);
	$billing_type = $clsBilling->getOneField('billing_type', $billing_id);
	$billing_method = $clsBilling->getOneField('billing_method', $billing_id);
	$billing_code = $clsBilling->getOneField('billing_code', $billing_id);
	$assign_list["booking_id"] = $booking_id;
	$assign_list["billing_code"] = $billing_code;
	$assign_list["billing_type"] = $billing_type;
	$assign_list["billing_method"] = $billing_method;

	#- ONEPAY 
	if ($billing_method == PAYMENT_ONEPAY_VISA || $billing_method == PAYMENT_ONEPAY_AE || $billing_method == PAYMENT_ONEPAY_ATM) {
		$onepaycredit = 'quocte_php';
		if ($billing_method == PAYMENT_ONEPAY_ATM) {
			$onepaycredit = 'noidia_php';
		}
		$assign_list["onepaycredit"] = $onepaycredit;
		#
		$vpc_MerchTxnRef = date('YmdHis') . rand();
		$clsBilling->updateOne($billing_id, "vpc_MerchTxnRef='$vpc_MerchTxnRef',vpc_MerchTxnRef_reg_date='" . time() . "'");
		$assign_list["vpc_MerchTxnRef"] = $vpc_MerchTxnRef;
		#
		$vpc_TicketNo = $_SERVER['REMOTE_ADDR'];
		$assign_list["vpc_TicketNo"] = $vpc_TicketNo;
		if ($billing_method == PAYMENT_ONEPAY_VISA) {
			$VPC_MERCHANT = trim($clsConfiguration->getValue('ONEPAY_Visa_Merchant_ID'));
			$VPC_URLPAYMENT = trim($clsConfiguration->getValue('ONEPAY_Visa_URL_PAYMENT'));
			$VPC_ACCESSCODE = trim($clsConfiguration->getValue('ONEPAY_Visa_Access_Code'));
			$VPC_SECUREHASH = trim($clsConfiguration->getValue('ONEPAY_Visa_Secure_Hash'));
			$ONEPAY_Test_Mode = $clsConfiguration->getValue('ONEPAY_Visa_Test_Mode');
			$ONEPAY_Surcharge = $clsConfiguration->getValue('ONEPAY_Visa_Surcharge');
		} else if ($billing_method == PAYMENT_ONEPAY_AE) {
			$VPC_MERCHANT = trim($clsConfiguration->getValue('ONEPAY_Visa_Merchant_ID'));
			$VPC_URLPAYMENT = trim($clsConfiguration->getValue('ONEPAY_Visa_URL_PAYMENT'));
			$VPC_ACCESSCODE = trim($clsConfiguration->getValue('ONEPAY_Visa_Access_Code'));
			$VPC_SECUREHASH = trim($clsConfiguration->getValue('ONEPAY_Visa_Secure_Hash'));
			$ONEPAY_Test_Mode = $clsConfiguration->getValue('ONEPAY_Visa_Test_Mode');
			$ONEPAY_Surcharge = $clsConfiguration->getValue('ONEPAY_American_Express_Surcharge');
		} else {
			$VPC_MERCHANT = trim($clsConfiguration->getValue('ONEPAY_Merchant_ID'));
			$VPC_URLPAYMENT = trim($clsConfiguration->getValue('ONEPAY_URL_PAYMENT'));
			$VPC_ACCESSCODE = trim($clsConfiguration->getValue('ONEPAY_Access_Code'));
			$VPC_SECUREHASH = trim($clsConfiguration->getValue('ONEPAY_Secure_Hash'));
			$ONEPAY_Test_Mode = $clsConfiguration->getValue('ONEPAY_Test_Mode');
			$ONEPAY_Surcharge = $clsConfiguration->getValue('ONEPAY_Surcharge');
		}

		$assign_list["VPC_MERCHANT"] = $VPC_MERCHANT;
		$assign_list["VPC_URLPAYMENT"] = $VPC_URLPAYMENT;
		$assign_list["VPC_ACCESSCODE"] = $VPC_ACCESSCODE;
		$assign_list["VPC_SECUREHASH"] = $VPC_SECUREHASH;
		$assign_list["ONEPAY_Test_Mode"] = $ONEPAY_Test_Mode;

		#
		if ($_LANG_ID == 'vn') {
			$text_deposit = 'deposit_VND';
			$text_charges = 'charges_VND';
		} else {
			$text_deposit = 'deposit_USD';
			$text_charges = 'charges_USD';
		}

		$deposit = $clsBilling->getOneField($text_deposit, $billing_id);
		$charges = $clsBilling->getOneField($text_charges, $billing_id);

		// Test Mode
		if ($ONEPAY_Test_Mode) {
			$vpc_Amount = $deposit;
		} else {
			$_EXCHANGE_RATE = $clsISO->getRateVCB('USD');
			$vpc_Amount = $deposit + $charges;
			if ($_LANG_ID != 'vn') {
				$vpc_Amount = $vpc_Amount * $_EXCHANGE_RATE;
			}
		}

		$assign_list["booking_id"] = $booking_id;
		$assign_list["vpc_Amount"] = $vpc_Amount * 100;
		$assign_list["vpc_OrderInfo"] = $clsBilling->getOneField('billing_code', $billing_id);
	}

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Pay Order Status') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
}
function default_paypal()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsCommon, $oneCommon, $clsConfiguration, $clsISO, $extLang;
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;
	#
	$billing_id = isset($_GET['billing_id']) ? $core->decryptID($_GET['billing_id']) : "";
	if ($billing_id == 0) {
		redirect('/');
	}
	$assign_list["billing_id"] = $billing_id;
	$booking_id = $clsBilling->getOneField('booking_id', $billing_id);
	$billing_type = $clsBilling->getOneField('billing_type', $billing_id);
	$billing_method = $clsBilling->getOneField('billing_method', $billing_id);
	$billing_code = $clsBilling->getOneField('billing_code', $billing_id);
	$assign_list["booking_id"] = $booking_id;
	$assign_list["billing_code"] = $billing_code;
	$assign_list["billing_type"] = $billing_type;
	$assign_list["billing_method"] = $billing_method;

	#- Paypal

	#- Customer Information
	$first_name = $clsBooking->getFirstName($booking_id);
	$last_name = $clsBooking->getLastName($booking_id);
	$address = $clsBooking->getAddress($booking_id);
	$phone = $clsBooking->getPhone($booking_id);
	$email = $clsBooking->getEmail($booking_id);
	$country = $clsBooking->getCountry($booking_id);

	$assign_list["first_name"] = $first_name;
	$assign_list["last_name"] = $last_name;
	$assign_list["address"] = $address;
	$assign_list["phone"] = $phone;
	$assign_list["email"] = $email;
	$assign_list["country"] = $country;

	$deposit = $clsBilling->getOneField('deposit_USD', $billing_id);
	$charges = $clsBilling->getOneField('charges_USD', $billing_id);
	$totalRate = $deposit + $charges;

	//$assign_list["totalRate"] = $clsISO->parsePrice($totalRate,0);
	$assign_list["totalRate"] = $totalRate;
	//echo $totalRate;die('xxx');  


	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Pay Order Status') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
}
function default_vnpay()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsCommon, $oneCommon, $clsConfiguration, $clsISO, $extLang;
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;
	#
	$billing_id = isset($_GET['billing_id']) ? $core->decryptID($_GET['billing_id']) : "";
	if ($billing_id == 0) {
		redirect('/');
	}
	$assign_list["billing_id"] = $billing_id;
	$booking_id = $clsBilling->getOneField('booking_id', $billing_id);
	$billing_type = $clsBilling->getOneField('billing_type', $billing_id);
	$billing_method = $clsBilling->getOneField('billing_method', $billing_id);
	$billing_code = $clsBilling->getOneField('billing_code', $billing_id);
	$assign_list["booking_id"] = $booking_id;
	$assign_list["billing_code"] = $billing_code;
	$assign_list["billing_type"] = $billing_type;
	$assign_list["billing_method"] = $billing_method;

	$deposit = $clsBilling->getOneField('deposit_VND', $billing_id);
	$charges = $clsBilling->getOneField('charges_VND', $billing_id);

	if ($clsConfiguration->getValue('VNPay_Test_Mode')) {
		$vpc_Amount = $deposit;
	} else {
		$vpc_Amount = $deposit + $charges;
	}
	$assign_list['vpc_Amount'] = $vpc_Amount;

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Pay Order Status') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
}

function default_9pay()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsCommon, $oneCommon, $clsConfiguration, $clsISO, $extLang;
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;
	#
	$billing_id = isset($_GET['billing_id']) ? $core->decryptID($_GET['billing_id']) : "";
	if ($billing_id == 0) {
		redirect('/');
	}
	$assign_list["billing_id"] = $billing_id;
	$oneBilling = $clsBilling->getOne($billing_id);


	$booking_id = $oneBilling['booking_id'];
	$billing_type = $oneBilling['billing_type'];
	$billing_method = $oneBilling['billing_method'];
	$billing_code = $oneBilling['billing_code'];
	$deposit = $oneBilling['deposit_VND'];
	$charges = $oneBilling['charges_VND'];


	$amount = $deposit + $charges;
	$assign_list["amount"] = $amount;

	$assign_list["booking_id"] = $booking_id;
	$assign_list["billing_code"] = $billing_code;
	$assign_list["billing_type"] = $billing_type;
	$assign_list["billing_method"] = $billing_method;


	require_once(DIR_INCLUDES . '/payment/9pay/lib/HMACSignature.php');
	require_once(DIR_INCLUDES . '/payment/9pay/lib/MessageBuilder.php');
	$MERCHANT_KEY = 'y1C0Nm'; // thông tin key của merchant wallet
	$MERCHANT_SECRET_KEY = '7mebyCRGt0lKM1vHuEhdveDX8wkiGkJ5D3W';  // thông tin secret key của merchant
	$END_POINT = 'https://sand-payment.9pay.vn';

	$invoiceNo = $billing_id;
	$description = "Thanh Toán Cho Booking " . $billing_code;
	$time = time();
	$assign_list["MERCHANT_KEY"] = $MERCHANT_KEY;
	$assign_list["invoiceNo"] = $invoiceNo;
	$assign_list["amount"] = $amount;
	$assign_list["description"] = $description;
	$assign_list["time"] = $time;


	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
		$backUrl = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$returnUrl = str_replace('index.php', '', $backUrl);

		$data = array(
			'merchantKey' => $MERCHANT_KEY,
			'time' => $time,
			'invoice_no' => $_POST['invoice_no'],
			'amount' => $_POST['amount'],
			'description' => $_POST['description'],

			'back_url' => $backUrl,
			'return_url' => DOMAIN_NAME . '/payment/9pay/success.html',
		);

		$message = MessageBuilder::instance()
			->with($time, $END_POINT . '/payments/create', 'POST')
			->withParams($data)
			->build();


		$hmacs = new HMACSignature();
		$signature = $hmacs->sign($message, $MERCHANT_SECRET_KEY);

		$httpData = [
			'baseEncode' => base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE)),
			'signature' => $signature,
		];
		$redirectUrl = $END_POINT . '/portal?' . http_build_query($httpData);
		echo '<pre>';
		print_r($data);
		echo '<br/>';
		echo '<hr/>';
		print_r($message);
		echo '<br/>';
		echo '<hr/>';
		var_dump($httpData);
		echo '<br/>';
		echo '<hr/>';
		print_r($redirectUrl);
		//exit();
		return header('Location: ' . $redirectUrl);
	}

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Pay Order Status') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
}
function default_vtcpay()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsCommon, $oneCommon, $clsConfiguration, $clsISO, $extLang;
	$clsBooking = new Booking();
	$assign_list["clsBooking"] = $clsBooking;
	$clsBilling = new Billing();
	$assign_list["clsBilling"] = $clsBilling;
	#
	$billing_id = isset($_GET['billing_id']) ? $core->decryptID($_GET['billing_id']) : "";
	if ($billing_id == 0) {
		redirect('/');
	}
	$assign_list["billing_id"] = $billing_id;
	$oneBilling = $clsBilling->getOne($billing_id);
	$booking_id = $oneBilling['booking_id'];
	$billing_type = $oneBilling['billing_type'];
	$billing_method = $oneBilling['billing_method'];
	$billing_code = $oneBilling['billing_code'];
	$deposit = $oneBilling['deposit_VND'];
	$charges = $oneBilling['charges_VND'];


	$totalRate = $deposit + $charges;


	$assign_list["booking_id"] = $booking_id;
	$assign_list["billing_code"] = $billing_code;
	$assign_list["billing_type"] = $billing_type;
	$assign_list["billing_method"] = $billing_method;
	$assign_list["totalRate"] = $totalRate;

	$invoiceid = $billing_id;
	$description = "Thanh Toán Cho Booking " . $billing_code;
	$amount = $totalRate; # Format: ##.##
	$currency = 'VND'; # Currency Code

	/**KHACH HANG SUA THONG TIN SAU**************************************************************/
	$index 					= DOMAIN_NAME; // dia chi website cua ban
	$business				= $clsConfiguration->getValue('VTCPay_BUSINESS'); //tai khoan VTC Pay nhan tien dang ky tai pay.vtc.vn
	$merchant_id			=  $clsConfiguration->getValue('VTCPay_ID_Website'); // Ma websiteid duoc gen tren pay.vtc.vn
	$secure_pass			= html_entity_decode($clsConfiguration->getValue('VTCPay_SecretKey')); // ma bao mat duoc dien tren pay.vtc.vn
	if ($clsConfiguration->getValue('VTCPay_Test_Mode')) {
		$pay_url = 'http://alpha1.vtcpay.vn/portalgateway/checkout.html'; //url thanh toan 
	} else {
		$pay_url = 'https://pay.vtc.vn/cong-thanh-toan/checkout.html'; //url thanh toan 
	}

	$return_url = DOMAIN_NAME . "/checkout/"; // Đưa link VTCPay_Listener vào đây

	/**HET PHAN SUA******************************************************************************************/

	$order_id				=  $invoiceid;
	$total_amount			=	intval($amount);
	$order_description	    =	$description;
	$url_success			=	$index;
	$url_cancel				=	$index . '/clientarea.php';
	$url_detail				=	$index . '/viewinvoice.php?id=' . $order_id;

	$transaction_info = "thanhtoantaiwebsite";
	$customer_mobile = "";
	$param_extend = "";

	$url = createRequestUrl($return_url, $business, $transaction_info, $order_id, $total_amount, $customer_mobile, $merchant_id, $secure_pass, $pay_url, $param_extend);

	header('Location:' . $url);
	exit();

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Pay Order Status') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
}


function default_success()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsConfiguration, $_lang;
	#
	/*=============Title & Description Page==================*/
	$title_page = $_lang->get_Lang('Success') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}
function default_dr()
{
	global $clsISO, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsUser,
		$_frontIsLoggedin, $_frontIsLoggedin_user_id, $event_id, $clsConfiguration, $_lang, $stdio, $extLang, $iso_countCart;
	$clsBilling = new Billing();
	$assign_list['clsBilling'] = $clsBilling;
	$clsBooking = new Booking();
	$assign_list['clsBooking'] = $clsBooking;
	#- Get Transaction
	$type_act = isset($_GET['type_act']) ? $_GET['type_act'] : "";
	$assign_list['type_act'] = $type_act;
	if ($type_act == 'Cancel') {
		$link_request = vnSessionGetVar('rq_link');
		header('location:' . $extLang . $link_request);
	}

	#- Get Bill ID
	$billing_id = 0;
	$method = $stdio->GET("method", "ONEPAY");

	if ($method == 'ONEPAY') {
		//Cap nhat so tien da thanh toan cua booking

		$transStatus = intval($_GET['val']);
		$ret_url = $_SERVER['REQUEST_URI'];
		$vpc_Card = isset($_GET['vpc_Card']) ? $_GET['vpc_Card'] : '';
		$vpc_CardNum = isset($_GET['vpc_CardNum']) ? $_GET['vpc_CardNum'] : '';
		$vpc_AdditionData = isset($_GET['vpc_AdditionData']) ? $_GET['vpc_AdditionData'] : '';
		$vpc_MerchTxnRef = isset($_GET['vpc_MerchTxnRef']) ? $_GET['vpc_MerchTxnRef'] : '';
		$vpc_TransactionNo = isset($_GET['vpc_TransactionNo']) ? $_GET['vpc_TransactionNo'] : '';
		$vpc_CardLevelIndicator = isset($_GET['vpc_CardLevelIndicator']) ? $_GET['vpc_CardLevelIndicator'] : '';

		$oneBilling = $clsBilling->getByCond("vpc_MerchTxnRef='$vpc_MerchTxnRef'");

		$billing_id = $oneBilling['billing_id'];
		if (intval($billing_id) == 0) {
			header('Location: /');
			exit();
		}
		$assign_list["billing_id"] = $billing_id;
		$assign_list["transStatus"] = $transStatus;
		#- End Get Bill ID

		#- Check if is_sent not first
		if ($clsBilling->getOneField('is_sent_success', $billing_id)) {
			$ret_url = $clsBilling->getOneField('ret_url', $billing_id);
			if ($ret_url == '') {
				$ret_url = '/';
			}
			if ($clsBilling->getOneField('status', $billing_id) != $transStatus) {
				redirect($ret_url);
			}
		}
		#- Update is_sent_success
		if (!$clsBilling->getOneField('is_sent_success', $billing_id)) {
			$set = "is_sent_success='1'
			,status='$transStatus'
			,ret_url='" . addslashes($_SERVER['REQUEST_URI']) . "'
			,status_date='" . time() . "'
			,return_date='" . time() . "'
			,is_paid_complete='" . ($transStatus == 1 ? 1 : 0) . "'
			,vpc_AdditionData='" . addslashes($vpc_AdditionData) . "'
			,vpc_Card='" . addslashes($vpc_Card) . "'
			,vpc_CardNum='" . addslashes($vpc_CardNum) . "'
			,vpc_TransactionNo='" . addslashes($vpc_TransactionNo) . "'
			,vpc_CardLevelIndicator='" . addslashes($vpc_CardLevelIndicator) . "'";
			$clsBilling->updateOne($billing_id, $set);
		}

		#- Send EMail
		if (!$clsBilling->getOneField('is_sent_email', $billing_id)) {
			$is_sent_email = $clsBilling->sendMailPaymentCard($billing_id, $transStatus);
		}
	} else if ($method == 'Paypal') {
		$transStatus = $stdio->GET('vl');
		$assign_list["transStatus"] = $transStatus;
		$billing_id = $stdio->GET('orderInfo');
		$assign_list["billing_id"] = $billing_id;

		if (intval($billing_id) == 0) {
			redirect('/');
		}

		#- Check if is_sent not first
		if ($clsBilling->getOneField('is_sent_success', $billing_id)) {
			$ret_url = $clsBilling->getOneField('ret_url', $billing_id);
			if ($ret_url == '') {
				$ret_url = '/';
			}
			if ($clsBilling->getOneField('status', $billing_id) != $transStatus) {
				redirect($ret_url);
			}
		}
		#- Update is_sent_success
		if (!$clsBilling->getOneField('is_sent_success', $billing_id)) {
			$set = "is_sent_success='1'
			,status='$transStatus'
			,ret_url='" . addslashes($ret_url) . "'
			,status_date='" . time() . "'
			,return_date='" . time() . "'
			,is_paid_complete='" . ($transStatus == 1 ? 1 : 0) . "'";
			$clsBilling->updateOne($billing_id, $set);
		}
		#- Send EMail
		if (!$clsBilling->getOneField('is_sent_email', $billing_id)) {
			$is_sent_email = $clsBilling->sendMailPaymentCard($billing_id);
			$clsBilling->updateOne($billing_id, "is_sent_email='1'");
		}
	}
	if ($transStatus != 0) {
		vnSessionDelVar('BookingTour_' . $_LANG_ID);
		vnSessionDelVar('BookingVoucher_' . $_LANG_ID);
		vnSessionDelVar('BookingCruise_' . $_LANG_ID);
		vnSessionDelVar('BookingHotel_' . $_LANG_ID);

		$iso_countCart = 0;
		$assign_list["iso_countCart"] = $iso_countCart;
	}

	//Them thong tin billing history
	$clsBillingHistory = new BillingHistory();
	$billing = $clsBilling->getOne($billing_id);
	$booking = $clsBooking->getOne($billing['booking_id']);
	$max_id = $clsBillingHistory->getMaxId();
	$bill_code = rand(100000000, 900000000) . $max_id;

	$dataInsert = array(
		'billing_history_id' => $max_id,
		'booking_id' => $billing['booking_id'],
		'bill_money' => $billing['deposit'],
		'payment_method' => $booking['payment_method'],
		'reg_date' => time(),
		'payment_term' => time(),
		'customer_name' => $booking['full_name'],
		'customer_email' => $booking['email'],
		'customer_phone' => $booking['phone'],
		'bill_code' => $bill_code,
		'bill_type' => 'PAYMENT',
		'status' => 1,
	);
	$clsBillingHistory->insert($dataInsert);

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Pay Order Status') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}

function default_payment_success()
{
	global $clsISO, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsUser,
		$_frontIsLoggedin, $_frontIsLoggedin_user_id, $event_id, $clsConfiguration, $_lang, $stdio;
	$clsBilling = new Billing();
	$assign_list['clsBilling'] = $clsBilling;
	$clsBooking = new Booking();
	$assign_list['clsBooking'] = $clsBooking;
	#- Get Transaction

	$clsConfiguration = new Configuration();

	$vnp_HashSecret = trim($clsConfiguration->getValue('VNPay_SecretKey')); //Secret key
	$vnp_SecureHash = $_GET['vnp_SecureHash'];
	$inputData = array();
	foreach ($_GET as $key => $value) {
		if (substr($key, 0, 4) == "vnp_") {
			$inputData[$key] = $value;
		}
	}

	unset($inputData['vnp_SecureHash']);
	ksort($inputData);
	$i = 0;
	$hashData = "";
	foreach ($inputData as $key => $value) {
		if ($i == 1) {
			$hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
		} else {
			$hashData = $hashData . urlencode($key) . "=" . urlencode($value);
			$i = 1;
		}
	}

	$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

	if ($secureHash == $vnp_SecureHash) {
		$transStatus = $_GET['vnp_ResponseCode'];
		$vnp_OrderInfo = $_GET['vnp_OrderInfo'];
		$vnp_CardType = isset($_GET['vnp_CardType']) ? $_GET['vnp_CardType'] : '';
		$vnp_PayDate = isset($_GET['vnp_PayDate']) ? $_GET['vnp_PayDate'] : '';
		$vnp_TxnRef = isset($_GET['vnp_TxnRef']) ? $_GET['vnp_TxnRef'] : '';
		$vnp_BankCode = isset($_GET['vnp_BankCode']) ? $_GET['vnp_BankCode'] : '';
		$vnp_BankTranNo = isset($_GET['vnp_BankTranNo']) ? $_GET['vnp_BankTranNo'] : '';
		$vnp_MerchTxnRef = isset($_GET['vpc_MerchTxnRef']) ? $_GET['vpc_MerchTxnRef'] : '';
		$vnp_TransactionNo = isset($_GET['vnp_TransactionNo']) ? $_GET['vnp_TransactionNo'] : '';
		$vnp_TransactionStatus = isset($_GET['vnp_TransactionStatus']) ? $_GET['vnp_TransactionStatus'] : '';
		$vnp_ResponseCode = isset($_GET['vnp_ResponseCode']) ? $_GET['vnp_ResponseCode'] : '';
		$vnp_Amount = isset($_GET['vnp_Amount']) ? $_GET['vnp_Amount'] : 0;
		$vnp_Amount = $vnp_Amount / 100;


		$order = $clsBilling->getByCond("vnp_TxnRef='$vnp_TxnRef'");
		if (!empty($order)) {
			if ($order["deposit_VND"] == $vnp_Amount) {
				$assign_list["vnp_ResponseCode"] = $vnp_ResponseCode;
				$assign_list["vnp_TransactionStatus"] = $vnp_TransactionStatus;
			} else {
				echo ('Invalid amount');
				die();
			}
		} else {
			echo ('Order Not Found');
			die();
		}
	} else {
		echo ('Invalid Signature');
		die();
	}

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Pay Order Status') . ' - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '';
	$assign_list["keyword_page"] = $keyword_page;
}

function createRequestUrl($return_url, $receiver, $transaction_info, $order_code, $amount, $customer_mobile, $websiteid, $secret_key, $vtcpay_url, $param_extend)
{
	// M?ng các tham s? chuy?n t?i VTC Pay

	$arr_param = array(
		'return_url'		=>	strtolower(urlencode($return_url)),
		'receiver'			=>	strval($receiver),
		'transaction_info'	=>	strval($transaction_info),
		'order_code'		=>	strval($order_code),
		'amount'			=>	strval($amount)
	);
	$currency = 'VND';


	$plaintext = $arr_param['amount'] . "|" . $currency . "|" . $param_extend . "|" . $arr_param['receiver'] . "|" . $arr_param['order_code'] . "|" . $return_url . "|" . $websiteid . "|" . $secret_key;

	$sign = strtoupper(hash('sha256', $plaintext));

	$data = "?website_id=" . $websiteid  . "&currency=" . $currency . "&reference_number=" . $arr_param['order_code'] . "&amount=" . $arr_param['amount'] . "&receiver_account=" .  $arr_param['receiver'] . "&url_return=" .  urlencode($return_url) . "&signature=" . $sign . "&payment_type=" . $param_extend;


	$destinationUrl = $vtcpay_url . $data;
	$destinationUrl = str_replace("%3a", ":", $destinationUrl);
	$destinationUrl = str_replace("%2f", "/", $destinationUrl);
	return $destinationUrl;
}
