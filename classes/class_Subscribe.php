<?php
/*======================================================================*\
|| #################################################################### ||
|| # The Class of the ISOCMS                                          # ||
|| # ISOCMS 6.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class Subscribe extends dbBasic
{
	function __construct()
	{
		$this->pkey = "subscribe_id";
		$this->tbl = DB_PREFIX . "subscribe";
	}
	function getIdByEmail($email = '')
	{
		$res = $this->getAll("email='$email'");
		return $res[0]['subscribe_id'];
	}
	function checkValidEmail($email = '')
	{
		$res = $this->getAll("1=1 and email='$email' order by subscribe_id desc limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getName($subscribe_id = 0)
	{
		$res = $this->getOne($subscribe_id, 'fullname');
		return $res['fullname'];
	}
	function getEmail($subscribe_id = 0)
	{
		$res = $this->getOne($subscribe_id, 'email');
		return $res['email'];
	}
	function sendMail($email = '')
	{
		global $core, $clsISO, $clsConfiguration, $_LANG_ID, $email_template_subscribe_id;
		#
		$clsEmailTemplate = new EmailTemplate();
		#
		$email_template_id = $email_template_subscribe_id;
		
		#
		header('Content-Type: text/html; charset=utf-8');
		$header_email = $clsEmailTemplate->getHeader($email_template_id);
		$body_email = $clsEmailTemplate->getContent($email_template_id);
		$footer_email = $clsEmailTemplate->getFooter($email_template_id);

		$message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
		$message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
		$message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
		$message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
		$message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
		$message .= '</div></div>';


		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
		$message = str_replace('[%CUSTOMER_EMAIL%]', $email, $message);
		$message = str_replace('[%CUSTOMER_FULLNAME%]', $email, $message);
		#
		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_HOTLINE%]', $clsConfiguration->getValue('CompanyHotLine'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
		$message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
		$message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
		$message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);
		$message = str_replace('[%BIRTHDAY%]', $birthday, $message);
		#
		$from = $clsEmailTemplate->getFromEmail($email_template_id);
		$owner = PAGE_NAME;
		$to = $email;
		$subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		return 1;
	}
	function sendMailQuickBooKing($email_id = 0)
	{
		global $core, $clsISO, $clsConfiguration;
		#
		$clsEmailTemplate = new EmailTemplate();
		$oneItem = $this->getOne($email_id);
		#
		header('Content-Type: text/html; charset=utf-8');
		$message = $clsEmailTemplate->getContent(7);
		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
		$message = str_replace('[%CUSTOMER_EMAIL%]', $oneItem['email'], $message);
		$message = str_replace('[%CUSTOMER_FULLNAME%]', $oneItem['fullname'], $message);
		$message = str_replace('[%CUSTOMER_REQUEST%]', $oneItem['intro_email'], $message);

		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
		$message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
		$message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
		$message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);
		$message = str_replace('[%BIRTHDAY%]', $birthday, $message);

		#
		$from = $clsConfiguration->getValue('SiteReplyEmail');
		$owner = PAGE_NAME;
		$to = trim($oneItem['email']);
		$subject = PAGE_NAME . ' ' . $clsEmailTemplate->getSubject(7) . ' ' . $oneItem['email'];
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		return 1;
	}
}
