<?php
class Travel extends dbBasic
{
	function __construct()
	{
		$this->pkey = "travel_id";
		$this->tbl = DB_PREFIX . "travel";
	}
	function getFeedBackInfo($travel_id = 0)
	{
		$one = $this->getOne($travel_id);
		$travel_store = unserialize($one['feedback_store']);
		return $travel_store;
	}
	function getMaxOrder()
	{
		$res = $this->getAll("1=1 order by order_no desc");
		return intval($res[0]['order_no']) + 1;
	}
	function generateTravel($travel_id = 0)
	{
		global $clsConfiguration;
		return $clsConfiguration->getValue('SitePrefixTravel') . $travel_id;
	}
	function countTotalAllTravel($clsTable = '')
	{
		$cond = "1=1";
		return $this->countItem($cond);
	}
	function countTotalTravel($is_process = '')
	{
		$cond = "1=1 and is_process = '$is_process'";
		return $this->countItem($cond);
	}
	function newBooking($travel_id = 0)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration;
		#
		$clsTravel = new Travel();
		$clsEmailTemplate = new EmailTemplate();
		$clsCountry = new _Country();
		$message = $clsEmailTemplate->getContent(2);
		header('Content-Type: text/html; charset=utf-8');

		$oneItem = $this->getOne($travel_id);
		$travel_store = unserialize($oneItem['travel_store']);
		$travel_code = $oneItem['travel_code'];
		$company_logo = $clsConfiguration->getValue('CompanyLogo');

		if ($clsTravel->getOneField('type', $travel_id) == 'HOME') {
			$HTML_INFO_CONTACT .= 'Full Name: [%CUSTOMER_FULL_NAME%] <br />';
			$HTML_INFO_CONTACT .= 'Email: [%CUSTOMER_EMAIL%] <br />';
			$HTML_INFO_CONTACT .= 'Message: [%CUSTOMER_MESSAGE%] <br />';
		} else {
			$HTML_INFO_CONTACT .= 'Full Name: [%CUSTOMER_FIRST_NAME%] [%CUSTOMER_LAST_NAME%] <br />';
			$HTML_INFO_CONTACT .= 'Email: [%CUSTOMER_EMAIL%] <br />';
			$HTML_INFO_CONTACT .= 'Phone: [%CUSTOMER_PHONE%] <br />';
			$HTML_INFO_CONTACT .= 'Country: [%CUSTOMER_COUNTRY%] <br />';
			$HTML_INFO_CONTACT .= 'Address: [%CUSTOMER_ADDRESS%] <br />';
			$HTML_INFO_CONTACT .= 'Subject: [%CUSTOMER_SUBJECT%]<br />';
			$HTML_INFO_CONTACT .= 'Message: [%CUSTOMER_MESSAGE%]';
		}
		#---
		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%HTML_INFO_CONTACT%]', $HTML_INFO_CONTACT, $message);
		$message = str_replace('[%FEEDBACK_CODE%]', $travel_code, $message);
		$message = str_replace('[%CUSTOMER_EMAIL%]', $travel_store['email'], $message);
		$message = str_replace('[%CUSTOMER_TITLE%]', $clsISO->getNameTitle($travel_store['title']), $message);
		$message = str_replace('[%CUSTOMER_FIRST_NAME%]', $travel_store['first_name'], $message);
		$message = str_replace('[%CUSTOMER_LAST_NAME%]', $travel_store['last_name'], $message);
		$message = str_replace('[%CUSTOMER_FULL_NAME%]', $travel_store['full_name'], $message);
		$message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($travel_store['country_id']), $message);
		$message = str_replace('[%CUSTOMER_PHONE%]', $travel_store['phone'], $message);
		$message = str_replace('[%CUSTOMER_ADDRESS%]', $travel_store['address'], $message);
		$message = str_replace('[%CUSTOMER_MESSAGE%]', $travel_store['message'], $message);
		$message = str_replace('[%CUSTOMER_SUBJECT%]', $travel_store['subject'], $message);
		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress'), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);
		$this->updateOne($travel_id, "feedback_html='" . addslashes($message) . "'");

		$from = $clsEmailTemplate->getFromEmail(2);

		#-- Send email to customer
		$owner = $clsEmailTemplate->getFromName(2);
		$to = trim($oneItem['email']);
		$subject = $clsEmailTemplate->getSubject(2);
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

		#-- Send email to administrator
		$owner = $clsEmailTemplate->getFromName(2);
		$to = $clsEmailTemplate->getCopyTo(2);
		$subject = $clsEmailTemplate->getSubject(2);
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		return 1;
	}
}
