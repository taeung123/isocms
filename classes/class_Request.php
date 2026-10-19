<?php
class Request extends dbBasic
{
	function __construct()
	{
		$this->pkey = "request_id";
		$this->tbl = DB_PREFIX . "request";
	}
	function generateCode($request_id = 0)
	{
		global $clsConfiguration;
		return 'YC' . $request_id;
	}
	function getValue($request_id = 0, $field = '')
	{
		global $clsConfiguration;
		$oneItem = $this->getOne($request_id);
		return $oneItem[$field];
	}
	function getFormatDate($request_id = 0, $field = '')
	{
		$clsISO = new ISO();
		$one = $this->getOne($request_id);
		if (!empty($one[$field])) {
			return date('d/m/Y', $one[$field]);
		}
	}
	function getBookingValue($request_id = 0)
	{
		$request_store = $this->getOneField('request_store', $request_id);
		$request_store = (trim($request_store) != '' && $request_store != '0') ? unserialize($request_store) : '';
		return $request_store;
	}
	function checkContain($haystack = '', $needle = '')
	{
		$pos = strpos($haystack, $needle);
		if ($pos === false) {
			return 0;
		} else {
			return 1;
		}
	}
	// Send Email Request
	function sendEmailRequest($request_id = 0)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration;
		#
		$clsRequestProperty = new RequestProperty();
		$clsEmailTemplate = new EmailTemplate();
		#
		header('Content-Type: text/html; charset=utf-8');
		#
		$oneItem = $this->getOne($request_id);
		$request_store = unserialize($oneItem['request_store']);
		$request_code = $oneItem['request_code'];

		# Parse Template
		$message = $clsEmailTemplate->getContent(1);

		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%URL_IMAGES%]', URL_IMAGES, $message);
		$message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
		$message = str_replace('[%LOGO_EMAILTMP%]', '<img src="' . $clsConfiguration->getValue('CompanyLogo') . '" alt="' . PAGE_NAME . '" />', $message);
		$message = str_replace('[%BOOKING_CODE%]', $request_code, $message);

		$message = str_replace('[%CUSTOMER_FULLNAME%]', $oneItem['fullname'], $message);
		$message = str_replace('[%CUSTOMER_EMAIL%]', $oneItem['email'], $message);
		$message = str_replace('[%CUSTOMER_PHONE%]', $request_store['phone'], $message);
		$message = str_replace('[%ERROR_TYPE%]', $clsRequestProperty->getTitle($oneItem['error_id']), $message);
		$message = str_replace('[%MESSAGE%]', html_entity_decode($oneItem['content']), $message);
		$message = str_replace('[%WEBSITE%]', $oneItem['websitename'], $message);
		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress'), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);

		#-- Update Html Booking
		$this->updateOne($request_id, "request_html='" . addslashes($message) . "'");

		$from = $clsConfiguration->getValue('SiteReplyEmail');

		#Send email to customer
		$to = trim($booking_store['email']);
		$owner = PAGE_NAME;
		$subject = '[' . $booking_code . '] ' . $core->get_Lang('Booking Hotel Confirmation From') . ' ' . PAGE_NAME;
		$clsISO->sendEmail($from, $to, $subject, $message, $owner);

		#Send email to admin
		$from = 'no-reply@vietiso.com';
		$to = 'support@vietiso.com';
		$owner = PAGE_NAME;
		$suject = '✪✪✪ New request from ' . PAGE_NAME;
		$clsISO->sendEmail($from, $to, $suject, $message, $owner);
		return 1;
	}
	function getBookingHTML($booking_id = 0)
	{
		$bookingHTML = $this->getOneField('booking_html', $booking_id);
		return $bookingHTML;
	}
}
