<?php
class Billing extends dbBasic
{
	function __construct()
	{
		$this->pkey = "billing_id";
		$this->tbl = DB_PREFIX . "billing";
	}

	function initPay($booking_id = 0)
	{
		global $core, $dbconn, $clsISO, $_LANG_ID, $extLang;
		$clsBooking = new Booking();
		$booking_data = $clsBooking->getOne($booking_id);
		$booking_store = $clsBooking->getBookingValue($booking_id);
		#
		$booking_code = $booking_data['booking_code'];
		$booking_type = $booking_data['booking_type'];
		$billing_method = $booking_data['payment_method'];
		$totalgrand = $booking_data['totalgrand'];
		$deposit = $booking_data['deposit'];
		$balance = $booking_data['balance'];

		if ($deposit == 0) {
			$deposit = $booking_data['balance'];
		} else {
			$deposit = $deposit;
		}
		// $charges = $booking_store['surcharge_value_post'] ? $booking_store['surcharge_value_post'] : 0;
		// $exchange_rate = $booking_store['exchange_rate'] ? $booking_store['exchange_rate'] : 0;

		// Thay đổi mặc định nếu k có giá trị thì = 1 để k bị lỗi tính toán
		$charges = $booking_store['surcharge_value_post'] ? $booking_store['surcharge_value_post'] : 1;
		$exchange_rate = $booking_store['exchange_rate'] ? $booking_store['exchange_rate'] : 1;

		if ($_LANG_ID == 'vn') {
			$totalgrandVND = $totalgrand;
			$depositVND = $deposit;
			$balanceVND = $balance;
			$chargesVND = $charges;
			$totalgrandUSD = round($totalgrand / $exchange_rate, 2);
			$depositUSD = round($deposit / $exchange_rate, 2);
			$balanceUSD = round($balance / $exchange_rate, 2);
			$chargesUSD = round($charges / $exchange_rate, 2);
		} else {
			$totalgrandVND = $totalgrand * $exchange_rate;
			$depositVND = $deposit * $exchange_rate;
			$balanceVND = $balance * $exchange_rate;
			$chargesVND = $charges * $exchange_rate;

			$totalgrandUSD = $totalgrand;
			$depositUSD = $deposit;
			$balanceUSD = $balance;
			$chargesUSD = $charges;
		}
		#
		$is_deposit = 0;
		if (
			intval($booking_store['pay_deposit']) > 0
			&& intval($booking_store['pay_deposit']) < 100
		) {
			$is_deposit = 1;
		}
		#
		$billing_id = $this->getMaxId();
		$insert = array(
			'billing_id'	 => $billing_id,
			'billing_type'	=> $booking_type,
			'billing_method' => $billing_method,
			'billing_code'	=> $booking_code,
			'booking_id'	=> $booking_id,
			'totalgrand'	=> $clsISO->processSmartNumber($totalgrand),
			'totalgrand_USD' => $totalgrandUSD,
			'totalgrand_VND' => $clsISO->processSmartNumber($totalgrandVND),
			'charges'		=> $charges,
			'charges_USD'	=> $chargesUSD,
			'charges_VND'	=> round($chargesVND),
			'deposit'		=> $deposit,
			'deposit_USD'	=> $depositUSD,
			'deposit_VND'	=> $clsISO->processSmartNumber($depositVND),
			'balance'		=> $clsISO->processSmartNumber($balance),
			'balance_USD'	=> $balanceUSD,
			'balance_VND'	=> $clsISO->processSmartNumber($balanceVND),
			'is_deposit'	=> $is_deposit,
			'reg_date'		=> time(),
			'ip_billing'	=> $_SERVER['REMOTE_ADDR'],
			'vnp_TxnRef'	=> $billing_id
		);
		//print_r($insert);die('xxx');    
		if ($this->insert($insert)) {
			#- Update column relationship to booking
			$clsBooking->updateOne($booking_id, "billing_id='$billing_id'");
			if ($billing_method == PAYMENT_ONEPAY_ATM || $billing_method == PAYMENT_ONEPAY_VISA || $billing_method == PAYMENT_ONEPAY_AE || $billing_method == PAYMENT_VTCPAY_GATEWAY) {
				redirect(PCMS_URL . $extLang . '/redirect-gateway/' . $core->encryptID($billing_id) . '.html');
			} elseif ($billing_method == PAYMENT_VNPAY_GATEWAY) {
				redirect(PCMS_URL . $extLang . '/payment/vnpay/' . $core->encryptID($billing_id) . '.html');
			} elseif ($billing_method == PAYMENT_PAYPAL_GATEWAY) {
				redirect(PCMS_URL . $extLang .  '/payment/paypal/' . $core->encryptID($billing_id) . '.html');
			} else {
				return 1;
			}
		}
	}
	function getFormOnePayCredit($VPC_PAYMENT_ID = 0, $VPC_URLPAYMENT = '', $VPC_MERCHANT = '', $VPC_ACCESSCODE = '', $vpc_MerchTxnRef = '', $vpc_OrderInfo = '', $vpc_Amount = 0, $vpc_TicketNo = 0)
	{
		$html = '
		<form style="display:none;" name="frmBooking" id="frmBooking0" method="post" action="' . PCMS_URL . '/inc/onepaycredit/quocte_php/do.php">  
			<input type="hidden" name="virtualPaymentClientURL" value="' . $VPC_URLPAYMENT . '" />
			<input type="hidden" name="Title" value="VPC 3-Party" />
			<input type="hidden" name="vpc_Merchant" value="' . $VPC_MERCHANT . '" />  
			<input type="hidden" name="vpc_AccessCode" value="' . $VPC_ACCESSCODE . '" />
			<input type="hidden" name="vpc_MerchTxnRef" id="vpc_MerchTxnRef" value="' . $vpc_MerchTxnRef . '" />
			<input type="hidden" name="vpc_OrderInfo" id="vpc_OrderInfo" value="' . $vpc_OrderInfo . '" />
			<input type="hidden" name="vpc_Amount" id="vpc_Amount" value="' . $vpc_Amount . '" />
			<input type="hidden" name="vpc_ReturnURL" value="' . PCMS_URL . '/inc/onepaycredit/quocte_php/dr.php" />
			<input type="hidden" name="vpc_Version" value="2" />
			<input type="hidden" name="vpc_Command" value="pay" />
			<input type="hidden" name="vpc_Locale" value="en" />
			<input type="hidden" name="vpc_TicketNo" id="vpc_TicketNo" value="' . $vpc_TicketNo . '" />
			<input type="hidden" name="vpc_SHIP_Street01" value="39A Ngo Quyen" />
			<input type="hidden" name="vpc_SHIP_Provice" value="Hoan Kiem" />
			<input type="hidden" name="vpc_SHIP_City" value="Ha Noi" />
			<input type="hidden" name="vpc_SHIP_Country" value="Viet Nam" />
			<input type="hidden" name="vpc_Customer_Phone" value="840904280949" />
			<input type="hidden" name="vpc_Customer_Email" value="support@onepay.vn" />
			<input type="hidden" name="vpc_Customer_Id" value="thanhvt" />                                     
		</form>';
		return $html;
	}
	function getFieldStatus($billing_id = 0, $field = '', $title = null)
	{
		global $core, $clsISO, $dbconn;
		if (is_null($title)) $title = $core->get_Lang('Unkhnow');
		$value = $this->getOneField($field, $billing_id);

		if ($value == 0) return $core->get_Lang('Failed');
		if ($value == 1) return $core->get_Lang('Completed');
		if ($value == 2) return $core->get_Lang('Pending');
		if ($value == 4) return $core->get_Lang('Canceled');
	}
	function getFieldValue($billing_id = 0, $field = '', $title = null)
	{
		global $core, $clsISO, $dbconn;
		if (is_null($title)) $title = $core->get_Lang('Unkhnow');
		$value = $this->getOneField($field, $billing_id);
		if ($field == 'billing_method') {
			if ($value == PAYMENT_CASH_ID) return $core->get_Lang('Cash payments');
			if ($value == PAYMENT_TRANSFER_ID) return $core->get_Lang('Bank Transfer');
			if ($value == PAYMENT_ONEPAY_ATM) return $core->get_Lang('ONEPAY Inbound');
			if ($value == PAYMENT_ONEPAY_VISA) return $core->get_Lang('ONEPAY Outbound');
			if ($value == PAYMENT_ONEPAY_AE) return $core->get_Lang('ONEPAY Outbound');
			if ($value == PAYMENT_PAYPAL_GATEWAY) return $core->get_Lang('Paypal');
			return sprintf('<em>%s</em>', $title);
		} else if (
			$field == 'totalgrand' || $field == 'totalgrand_VND' || $field == 'deposit'
			|| $field == 'deposit_VND' || $field == 'balance' || $field == 'balance_VND'
		) {
			return $clsISO->formatPrice($value);
		} else if ($field == 'status') {
			if ($value == 0) return sprintf('<font color="#FF0000">%s</font>', $core->get_Lang('Failed'));
			if ($value == 1) return sprintf('<font color="#006600">%s</font>', $core->get_Lang('Completed'));
			if ($value == 2) return sprintf('<font color="#0000FF">%s</font>', $core->get_Lang('Pending'));
			if ($value == 4) return sprintf('<font color="#000">%s</font>', $core->get_Lang('Canceled'));
		} else if ($field == 'reg_date') {
			return date('d-m-Y H:i', $value);
		}
		if ($value != '' && $value != '0')
			return $value;
		return sprintf('<em>%s</em>', $title);
	}
	function getInfoService($billing_id = 0, $type = '')
	{
		global $core;
		$clsBooking = new Booking();
		$clsTour = new Tour();
		$clsCruise = new Cruise();
		$clsHotel = new Hotel();
		$booking_id = $this->getOneField('booking_id', $billing_id);
		$booking_type = $clsBooking->getOneField('booking_type', $booking_id);
		$target_id = $clsBooking->getOneField('target_id', $booking_id);
		$departure_date = $clsBooking->getOneField('departure_date', $booking_id);
		$pickup_address = $clsBooking->getOneField('pickup_address', $booking_id);
		$check_in = $clsBooking->getOneField('check_in', $booking_id);

		$oneItem = $clsBooking->getOne($booking_id);
		$booking_store = unserialize($oneItem['booking_store']);
		$number_of_guest = '';
		if (!empty($booking_store['adult'])) {
			$number_of_guest .= $booking_store['adult'] . ' ' . $core->get_Lang('adult(s)');
		}
		if (!empty($booking_store['child'])) {
			$number_of_guest .= ', ' . $booking_store['child'] . ' ' . $core->get_Lang('child');
		}
		if (!empty($booking_store['baby'])) {
			$number_of_guest .= ', ' . $booking_store['baby'] . ' ' . $core->get_Lang('Infant');
		}

		$number_of_guest2 = '';
		if (!empty($booking_store['number_adult'])) {
			$number_of_guest2 .= $booking_store['number_adult'] . ' ' . $core->get_Lang('adults');
		}

		if (!empty($booking_store['number_child'])) {
			$number_of_guest2 .= ', ' . $booking_store['number_child'] . ' ' . $core->get_Lang('child');
		}

		if ($booking_type == 'Tour') {
			if ($type == 'name') {
				return $clsTour->getTitle($target_id);
			} elseif ($type == 'departure') {
				return $check_in;
			} elseif ($type == 'number_guest') {
				return $number_of_guest;
			} else {
				return $pickup_address;
			}
		} elseif ($booking_type == 'Cruise') {
			if ($type == 'name') {
				return $clsCruise->getTitle($target_id);
			} elseif ($type == 'departure') {
				return $check_in;
			} elseif ($type == 'number_guest') {
				return $number_of_guest2;
			} else {
				return $pickup_address;
			}
		} else {
		}
	}
	function getCreditCard($billing_id = 0)
	{
		global $clsISO, $core, $dbconn;
		$billing_method = $this->getOneField('billing_method', $billing_id);
		if ($billing_method == PAYMENT_ONEPAY_ATM) {
			$vpc_AdditionData  = $this->getOneField('vpc_AdditionData', $billing_id);
			$bank = array(
				'970436'		=>	'VCB',
				'970415'		=>	'Vietinbank',
				'970405'		=>	'Agribank',
				'970418'		=>	'BIDV',
				'970423'		=>	'Tien Phong Bank',
				'970403'		=>	'SACOMBANK',
				'970429'		=>	'SCB',
				'970422'		=>	'MB',
				'970432'		=>	'VPBank',
				'970425'		=>	'ABB',
				'970409'		=>	'Bac A Bank',
				'970437'		=>	'Hdbank',
				'970419'		=>	'NCB',
				'970440'		=>	'SEABANK',
				'970443'		=>	'SHB',
				'970414'		=>	'OCEANBANK',
				'970428'		=>	'NAM A Bank',
				'970427'		=>	'Viet A Bank',
				'970426'		=>	'MSB Bank',
				'970431'		=>	'EXIM Bank',
				'970431'		=>	'VRB',
				'970412'		=>	'PVCOMBANK',
				'970406'		=>	'DongA(Internet banking)',
				'970441'		=>	'VIB(Internet banking)',
				'970407'		=>	'TCB(Internet banking)',
				'970433'		=>	'VietBank'
			);
			return $bank[$vpc_AdditionData];
		} else if ($billing_method == PAYMENT_ONEPAY_VISA || $billing_method == PAYMENT_ONEPAY_AE) {
			$card = array(
				'VC'	=>	'Visa',
				'MC'	=>	'Master',
				'JC'	=>	'JCB',
				'AE'	=>	'Amex'
			);
			$vpc_Card = $this->getOneField('vpc_Card', $billing_id);
			return $card[$vpc_Card];
		} else if ($billing_method == PAYMENT_PAYPAL) {
			return 'Paypal';
		} else if ($billing_method == PAYMENT_TRANSFER_ID) {
			return 'Bank Transfer';
		} else {
			return 'Cash payments';
		}
		return '';
	}
	function sendMailPaymentVNPayCard($billing_id = 0)
	{
		global $core, $dbconn, $clsISO, $_LANG_ID, $email_template_payment_vnpay_id;
		$clsISO = new ISO();
		$clsBooking = new Booking();
		$clsProfile = new Profile();
		$clsEmailTemplate = new EmailTemplate();
		#
		$email_id = $$email_template_payment_vnpay_id;

		$subject = $clsEmailTemplate->getSubject($email_id);
		$subject = str_replace('[%PAGE_NAME%]', PAGE_NAME, $subject);
		$message = $clsEmailTemplate->getContent($email_id);
		$fromName = $clsEmailTemplate->getFromName($email_id);
		$fromEmail = $clsEmailTemplate->getFromEmail($email_id);
		#
		$billing = $this->getOne($billing_id);
		$booking_id = $billing['booking_id'];
		if (_ISOCMS_CLIENT_LOGIN) {
			$member_id = $clsBooking->getOneField('member_id', $booking_id);
			$email = $clsProfile->getEmail($member_id);
		} else {
			$email = $clsBooking->getOneField('email', $booking_id);
		}
		#
		$deposit = $this->getFieldValue($billing_id, 'deposit');
		$deposit_VND = $this->getFieldValue($billing_id, 'deposit_VND');
		if ($billing['vnp_ResponseCode'] == '00') {
			$status = sprintf('<font color="#006600">%s</font>', $core->get_Lang('Completed'));
		} else {
			$status = sprintf('<font color="#FF0000">%s</font>', $core->get_Lang('Failed'));
		}
		#
		$message = str_replace('[%bank_code%]', $billing['vnp_BankCode'], $message);
		$message = str_replace('[%type_card%]', $billing['vnp_CardType'], $message);
		$message = str_replace('[%tranId%]', $billing['vnp_TransactionNo'], $message);
		$message = str_replace('[%$bookingId%]', $billing['billing_code'], $message);
		$message = str_replace('[%vpc_orderReference%]', $billing['billing_code'], $message);
		$message = str_replace('[%vpc_orderInfo%]', $billing['billing_code'], $message);
		$message = str_replace('[%vpc_transaction%]', $billing['vpc_MerchTxnRef'], $message);
		$message = str_replace('[%vpc_amount%]', $deposit . '($)~' . $deposit_VND . '(₫)', $message);
		$message = str_replace('[%datetime%]', date('d-m-Y H:i:s', $billing['reg_date']), $message);
		$message = str_replace('[%status%]', $status, $message);
		#- Send email to customer
		$clsISO->sendEmail($fromEmail, $email, $subject, $message, PAGE_NAME);
		return 1;
	}
	function sendMailPaymentCard($billing_id = 0)
	{
		global $core, $dbconn, $clsISO, $_LANG_ID, $email_template_payment_onepay_id, $clsConfiguration;
		$clsISO = new ISO();
		$clsBooking = new Booking();
		$clsProfile = new Profile();
		$clsEmailTemplate = new EmailTemplate();
		#
		$email_id = $email_template_payment_onepay_id;

		$header_email = $clsEmailTemplate->getHeader($email_id);
		$body_email = $clsEmailTemplate->getContent($email_id);
		$footer_email = $clsEmailTemplate->getFooter($email_id);

		$message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
		$message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
		$message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
		$message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
		$message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
		$message .= '</div></div>';

		$fromName = $clsEmailTemplate->getFromName($email_id);
		$fromEmail = $clsEmailTemplate->getFromEmail($email_id);
		#
		$billing = $this->getOne($billing_id);
		$booking_id = $billing['booking_id'];
		$email = $clsBooking->getOneField('email', $booking_id);
		#
		$deposit = $this->getFieldValue($billing_id, 'deposit');
		$deposit_VND = $this->getFieldValue($billing_id, 'deposit_VND');
		#
		$message = str_replace('[%number_card%]', $billing['vpc_CardNum'], $message);
		$message = str_replace('[%type_card%]', $this->getCreditCard($billing_id), $message);
		$message = str_replace('[%tranId%]', $billing['vpc_TransactionNo'], $message);
		$message = str_replace('[%vpc_orderReference%]', $billing['billing_code'], $message);
		$message = str_replace('[%vpc_orderInfo%]', $billing['billing_code'], $message);
		$message = str_replace('[%vpc_transaction%]', $billing['vpc_MerchTxnRef'], $message);
		if ($_LANG_ID == 'vn') {
			$message = str_replace('[%vpc_amount%]', $deposit_VND . '(₫)', $message);
		} else {
			$message = str_replace('[%vpc_amount%]', $deposit . '($)~' . $deposit_VND . '(₫)', $message);
		}

		$message = str_replace('[%datetime%]', date('d-m-Y H:i:s', $billing['reg_date']), $message);
		$message = str_replace('[%status%]', $this->getFieldValue($billing_id, 'status'), $message);
		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress'), $message);
		$message = str_replace('[%CUSTOMER_EMAIL%]', $email, $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
		$message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
		$message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
		$message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);
		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		#- Send email to customer
		$subject = $clsEmailTemplate->getSubject($email_id) . ' ' . PAGE_NAME;
		$subject = str_replace('[%PAGE_NAME%]', '', $subject);
		$clsISO->sendEmail($fromEmail, $email, $subject, $message, PAGE_NAME);
		$this->updateOne($billing_id, "is_sent_email=1");
		return 1;
	}
	function getHTMLPaymentCard($billing_id = 0)
	{
		global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID;
		$clsISO = new ISO();
		$clsBooking = new Booking();
		$clsProfile = new Profile();
		$clsConfiguration = new Configuration();
		#
		$billing = $this->getOne($billing_id);
		if ($billing['billing_method'] == PAYMENT_ONEPAY_ATM || $billing['billing_method'] == PAYMENT_ONEPAY_VISA || $billing['billing_method'] == PAYMENT_ONEPAY_AE) {
			$message = $clsConfiguration->getValue('SiteMsg_SuccessOnePay');
			$message = html_entity_decode($message);
		} else if ($billing['billing_method'] == PAYMENT_PAYPAL_GATEWAY) {
			$message = $clsConfiguration->getValue('SiteMsg_SuccessPaypal');
			$message = html_entity_decode($message);
			$message = str_replace('{$payment_method}', 'PayPal', $message);
		}
		#
		$booking_id = $billing['booking_id'];
		if (_ISOCMS_CLIENT_LOGIN) {
			$member_id = $clsBooking->getOneField('member_id', $booking_id);
			$email = $clsProfile->getEmail($member_id);
		} else {
			$email = $clsBooking->getOneField('email', $booking_id);
		}
		#
		$deposit = $this->getFieldValue($billing_id, 'deposit');
		$deposit_VND = $this->getFieldValue($billing_id, 'deposit_VND');
		$message = str_replace('{$cardnumber}', $billing['vpc_CardNum'], $message);
		$message = str_replace('{$cardtype}', $this->getCreditCard($billing_id), $message);
		$message = str_replace('{$transId}', $billing['vpc_TransactionNo'], $message);
		$message = str_replace('{$bookingId}', $billing['billing_code'], $message);
		$message = str_replace('{$transRef}', $billing['vpc_MerchTxnRef'], $message);
		if ($_LANG_ID == 'vn') {
			$message = str_replace('{$amount}', $deposit_VND . '(₫)', $message);
		} else {
			$message = str_replace('{$amount}', $deposit . '($)~' . $deposit_VND . '(₫)', $message);
		}

		$message = str_replace('{$datetime}', date('d-m-Y H:i:s', $billing['reg_date']), $message);
		$message = str_replace('{$status}', $this->getFieldValue($billing_id, 'status'), $message);
		return $message;
	}
	function getHTMLPaymentVNPayCard($billing_id = 0)
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration;
		$clsISO = new ISO();
		$clsBooking = new Booking();
		$clsProfile = new Profile();
		$clsConfiguration = new Configuration();
		#
		$billing = $this->getOne($billing_id);

		$message = $clsConfiguration->getValue('SiteMsg_SuccessVNPay_' . $_LANG_ID);
		$message = html_entity_decode($message);
		$message = str_replace('{$payment_method}', 'VNPay', $message);

		#
		$booking_id = $billing['booking_id'];
		if (_ISOCMS_CLIENT_LOGIN) {
			$member_id = $clsBooking->getOneField('member_id', $booking_id);
			$email = $clsProfile->getEmail($member_id);
		} else {
			$email = $clsBooking->getOneField('email', $booking_id);
		}

		if ($billing['vnp_ResponseCode'] == '00') {
			$status = sprintf('<font color="#006600">%s</font>', $core->get_Lang('Completed'));
		} else {
			$status = sprintf('<font color="#FF0000">%s</font>', $core->get_Lang('Failed'));
		}
		if (1 == 2) {
			return sprintf('<font color="#FF0000">%s</font>', $core->get_Lang('Failed'));
			if ($value == 1) return sprintf('<font color="#006600">%s</font>', $core->get_Lang('Completed'));
			if ($value == 2) return sprintf('<font color="#0000FF">%s</font>', $core->get_Lang('Pending'));
			if ($value == 4) return sprintf('<font color="#000">%s</font>', $core->get_Lang('Canceled'));
		}


		#
		$deposit = $this->getFieldValue($billing_id, 'deposit');
		$deposit_VND = $this->getFieldValue($billing_id, 'deposit_VND');
		$message = str_replace('{$bank_code}', $billing['vnp_BankCode'], $message);
		$message = str_replace('{$cardtype}', $billing['vnp_CardType'], $message);
		$message = str_replace('{$transId}', $billing['vnp_TransactionNo'], $message);
		$message = str_replace('{$bookingId}', $billing['billing_code'], $message);
		$message = str_replace('{$transRef}', $billing['vpc_MerchTxnRef'], $message);
		$message = str_replace('{$amount}', $deposit . '($)~' . $deposit_VND . '(₫)', $message);
		$message = str_replace('{$datetime}', date('d-m-Y H:i:s', $billing['reg_date']), $message);
		$message = str_replace('{$status}', $status, $message);
		return $message;
	}
}
