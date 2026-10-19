<?php if (!defined('ABSPATH')) exit('No direct script access allowed');
/*======================================================================*\
|| #################################################################### ||
|| # CRM Private By VietISO (support@vietiso.com)                     # ||
|| # ---------------------------------------------------------------- # ||
|| # All Script code in this file is ©2007-2013 VietISO JSC.          # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class EmailPro extends dbBasic
{
	var $debug		= false;
	var $fromemail	= '';
	var $fromname	= '';
	function __construct()
	{
		//some code
	}

	function getFileName($path = '')
	{
		if ($path == '') return '';
		$tmp = explode('/', $path);
		return $tmp[count($tmp) - 1];
	}
	function sendEmailToClient($fromemail = '', $fromname = '', $email = '', $toname = '', $subject = '', $message = '', $attachments = "", $plaintext = 0, $userid = 0)
	{
		global $clsISO, $_frontIsLoggedin_user_id;
		$CFG = new Configuration();
		$clsCompany = new Company();
		if ($email != '') {
			$f = "userid,subject,message,_date,_to,cc,bcc,user_action_id";
			$v = "'$userid','" . addslashes($subject) . "','" . addslashes($message) . "','" . time() . "','" . addslashes($email) . "'
			,'" . addslashes($copyto) . "','" . addslashes($CFG->getValue('SiteReplyEmail')) . "','$_frontIsLoggedin_user_id'";
			$this->insertOne($f, $v);
			#-Logs
			$crm_system_log_title = 'Email Sent to ' . $toname . ' (' . $subject . ') - User ID: ' . $userid;
			$clsISO->logs($clsCompany->tbl, $clsCompany->pkey, $userid, $crm_system_log_title);
			#-End Logs
			$this->sendMessage($fromemail, $fromname, $email, $toname, $subject, $message, $attachments = "", $plaintext = 0);
		}
	}
	function sendEmailToAdmin($fromemail = '', $fromname = '', $email = '', $toname = '', $subject = '', $message = '', $attachments = "", $plaintext = 0, $adminid = 0)
	{
		global $clsISO, $_frontIsLoggedin_user_id;
		$clsUser = new User();
		$CFG = new Configuration();
		if ($email != '') {
			$f = "adminid,subject,message,_date,_to,cc,bcc,user_action_id";
			$v = "'$adminid','" . addslashes($subject) . "','" . addslashes($message) . "','" . time() . "','" . addslashes($email) . "'
			,'" . addslashes($copyto) . "','" . addslashes($CFG->getValue('SiteReplyEmail')) . "','$_frontIsLoggedin_user_id'";
			$this->insertOne($f, $v);
			#-Logs
			$crm_system_log_title = 'Email Sent to ' . $toname . ' (' . $subject . ') - Admin ID: ' . $adminid;
			$clsISO->logs($clsUser->tbl, $clsUser->pkey, $adminid, $crm_system_log_title);
			#-Logs
			$this->sendMessage($fromemail, $fromname, $email, $toname, $subject, $message, $attachments = "", $plaintext = 0);
		}
	}
	function sendMessage($fromemail = '', $fromname = '', $email = '', $toname = '', $subject = '', $message = '', $attachments = "", $plaintext = 0, $cc = null)
	{
		global $clsISO, $_frontIsLoggedin_user_id;
		$CFG = new Configuration();
		// From email and name
		if (!isset($fromname))
			$fromname = 'isoCMS';

		if (!isset($fromemail)) {
			// Get the site domain and get rid of www.
			$sitename = strtolower($_SERVER['SERVER_NAME']);
			if (substr($sitename, 0, 4) == 'www.') {
				$sitename = substr($sitename, 4);
			}
			$fromemail = 'isocms@' . $sitename;
		}
		if ($message == '' || $email == '' || $fromemail == '' || $subject == '')
			return 0;
		// Merge Branding VietISO
		$message .= $clsISO->getBrandingFooter();
		// Mail Type
		$MailType = $CFG->getValue('SiteMailType');
		if (empty($MailType)) $MailType = 'sendgrid';
		if ($MailType == 'mail') {
			$headers = array(
				"MIME-Version: 1.0",
				"Content-type:text/html;charset=UTF-8",
				"From: {$fromname}<{$fromemail}>",
				"Reply-To: {$fromemail}",
				"X-Mailer: PHP/" . PHP_VERSION
			);
			$headers = @implode("\r\n", $headers);
			return @mail(trim($email), $subject, $message, $headers, "-f" . $fromemail);
		} else if ($MailType == 'sendgrid') {
			$usr = $CFG->getValue('SiteSendGridUsername'); //vietiso
			$pwd = $CFG->getValue('SiteSendGridPassword'); //vietiso128@vietiso128
			$pwd = $clsISO->isodecrypt($pwd);
			if (empty($usr) || empty($pwd)) {
				//$usr = 'vietiso';
				//$pwd = 'vietiso128@vietiso128';
				$url = 'https://go.vietiso.com/modules/servers/sendgrid/password.txt';
				if (function_exists('curl_init')) {
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HEADER, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					$content = curl_exec($curl);
					curl_close($curl);
				} else {
					$content = file_get_contents($url);
				}
				list($username, $password) = explode('|', $content);
				$usr = base64_decode($username);
				$pwd = base64_decode($password);
			}
			if ($CFG->getValue('SendGridCurlActive')) {
				$params = array(
					'api_user' => $usr,
					'api_key' => $pwd,
					'to' => $email,
					'replyto' => $email,
					'subject' => $subject,
					'html' => $message,
					'text' => strip_tags($message),
					'from' => $fromemail,
					'fromname' => $fromname
				);
				if (!is_null($cc) && is_array($cc)) {
					$params['cc'] = $cc;
				}
				if (!empty($attachments)) {
					if (is_array($attachments)) {
						foreach ($attachments as $k => $v) {
							$params['files[' . $k . ']'] = "@" . realpath($v);
						}
					} else {
						$params['files[' . $this->getFileName($attachments) . ']'] = "@" . realpath($attachments);
					}
				}
				$request = 'https://api.sendgrid.com/api/mail.send.json';
				// Generate curl request
				$ch = curl_init($request);
				// Tell curl to use HTTP POST
				curl_setopt($ch, CURLOPT_POST, true);
				// Tell curl that this is the body of the POST
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
				// Tell curl not to return headers, but do return the response
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// obtain response
				$response = @curl_exec($ch);
				@curl_close($ch);
				// print everything out
				$is_send_mail = 0;
				if (strpos($response, 'success') != false) {
					$is_send_mail = 1;
				} else {
					if ($this->debug) {
						return $response;
					}
				}
			} else {
				require_once(DIR_INCLUDES . '/SendGrid/vendor/autoload.php');
				$sengrid = new SendGrid($usr, $pwd, array("turn_off_ssl_verification" => true));
				// Create object
				$mail = new SendGrid\Email();
				// Param send email
				$mail->addTo($email)
					->setFrom($fromemail)
					->setFromName($fromname)
					->setReplyTo($email)
					->setSubject($subject)
					->setHtml($message)
					->addHeader('X-Sent-Using', 'SendGrid-API')
					->addHeader('X-Transport', 'web');
				if (!empty($attachments)) {
					if (is_array($attachments)) {
						foreach ($attachments as $k => $v) {
							$mail->addAttachment($v);
						}
					} else {
						$mail->addAttachment($attachments);
					}
				}
				if (!is_null($cc) && !empty($cc) && is_array($cc)) {
					$mail->setCcs($cc);
				}
				// obtain response
				$response = $sengrid->send($mail);
				// Return
				$is_send_mail = 0;
				if (isset($response->body['message']) && $response->body['message'] == 'success') {
					$is_send_mail = 1;
				} else {
					if ($this->debug) {
						return $response;
					}
				}
			}
			return $is_send_mail;
		} else {
			// (Re)create it, if it's gone missing
			require_once(DIR_INCLUDES . '/mailer/class.phpmailer.php');
			require_once(DIR_INCLUDES . '/mailer/class.smtp.php');
			require_once(DIR_INCLUDES . '/mailer/class.pop3.php');
			$mail = new PHPMailer();
			try {
				// Empty out the values that may be set
				$mail->clearAllRecipients();
				$mail->clearAttachments();
				$mail->clearCustomHeaders();
				$mail->clearReplyTos();
				$mail->ClearAddresses();

				$mail->isMail();
				$mail->From = trim($fromemail);
				$mail->FromName = trim($fromname);
				// Set Content-Type and charset
				$content_type = 'text/html';
				if ($plaintext) {
					$content_type = 'text/plain';
				}
				$mail->ContentType = $content_type;
				$mail->CharSet = 'utf-8';
				$mail->XMailer = $CFG->getValue("CompanyName");
				$mail->AddAddress(trim($email), $toname);
				if ($MailType == "mail") {
					$mail->Mailer = "mail";
				} else {
					if ($MailType == "smtp") {
						//$mail->Mailer = 'smtp';
						//Enable SMTP debugging.  1 or 2 on 
						$mail->SMTPDebug = 0; //off
						$mail->Priority  = 3;
						$mail->Encoding  = '8bit';
						//$mail->SMTPAutoTLS  = 1;
						//Set PHPMailer to use SMTP.
						$mail->IsSMTP();
						if ('text/html' == $content_type) {
							$mail->IsHTML(true);
						}
						//Set SMTP host name    
						$mail->Host = $CFG->getValue('SiteSmtpHost');
						$mail->Port = $CFG->getValue('SiteSmtpPort');
						if ($CFG->getValue('SiteSmtpSSL') !== 'none') {
							$mail->SMTPSecure = $CFG->getValue('SiteSmtpSSL');
						}
						$mail->SMTPOptions = array(
							'ssl' => array(
								'verify_peer' => false,
								'verify_peer_name' => false,
								'allow_self_signed' => true
							)
						);
						//Provide username and password
						if ($CFG->getValue('SiteSmtpUsername') != '') {
							$mail->SMTPAuth = true;
							$mail->Username = trim($CFG->getValue('SiteSmtpUsername'));
							$mail->Password = trim($clsISO->isodecrypt($CFG->getValue('SiteSmtpPassword')));
						}
						$mail->Sender = $mail->From;
						if ($fromemail != $CFG->getValue('SiteSmtpUsername')) {
							$mail->AddReplyTo($fromemail, html_entity_decode($fromname, ENT_QUOTES));
						}
					}
				}
				if (is_array($cc) && !empty($cc)) {
					foreach ($cc as $value) {
						$ccaddress = trim($value);
						if ($ccaddress) {
							$mail->AddCC($ccaddress);
						}
					}
				}
				if ($CFG->getValue('SiteReplyEmail')) {
					$bcc = $CFG->getValue('SiteReplyEmail');
					$bcc = explode(",", $bcc);
					foreach ($bcc as $value) {
						$ccaddress = trim($value);
						if ($ccaddress) {
							$mail->AddBCC($ccaddress);
						}
					}
				}
				$mail->Subject = html_entity_decode($subject, ENT_QUOTES);
				if ($plaintext) {
					$message = html_entity_decode($message, ENT_QUOTES);
					$mail->Body = strip_tags($message);
				} else {
					$mail->Body = $message;
					$message_text = str_replace("<p>", "", $message);
					$message_text = str_replace("</p>", "\r\n\r\n", $message_text);
					$message_text = str_replace("<br>", "\r\n", $message_text);
					$message_text = str_replace("<br />", "\r\n", $message_text);
					$message_text = strip_tags($message_text);
					$mail->AltBody = html_entity_decode($message_text, ENT_QUOTES);
				}
				if (!empty($attachments)) {
					if (is_array($attachments)) {
						foreach ($attachments as $filename) {
							$mail->AddAttachment($filename);
						}
					} else {
						$mail->AddAttachment($attachments);
					}
				}
				// Send
				try {
					$is_send_mail = $mail->send();
				} catch (phpmailerException $e) {
					$is_send_mail = false;
					if ($this->debug) {
						return $e->getMessage();
					}
				}
			} catch (Exception $e) {
				$is_send_mail =  false;
				if ($this->debug) {
					return $e->getMessage();
				}
			}
			return $is_send_mail;
		}
	}

	function sendEmailAPI($from = '', $to = '', $subject = '', $message = '', $owner = '')
	{
		global $core, $dbconn, $clsISO, $clsConfiguration;
		/** Info E-mail */
		$mail_type = $clsConfiguration->getValue('mail_type', 'mail_type');
		/* End */
		$status = 'error';
		$msg = "";
		if ($mail_type == 'smtp') {
			$mail_smtp_username = trim($clsConfiguration->getValue('mail_smtp_username'));
			$mail_smtp_password = trim($clsConfiguration->getValue('mail_smtp_password'));
			$mail_smtp_secure = trim($clsConfiguration->getValue('mail_smtp_secure'));
			$mail_smtp_host = trim($clsConfiguration->getValue('mail_smtp_host'));
			$mail_smtp_port = trim($clsConfiguration->getValue('mail_smtp_port'));
			$mail_smtp_authentication = $clsConfiguration->getValue('mail_smtp_authentication', 0);
			require_once(DIR_INCLUDES . '/mailer/class.phpmailer.php');
			$mail = new PHPMailer(true);
			try {
				$mail->CharSet = 'utf-8';
				$mail->XMailer = $clsConfiguration->getValue("company_name");
				$mail->From = $from;
				$mail->FromName = html_entity_decode($owner, ENT_QUOTES);
				$mail->AddAddress(trim($to));
				// SMTP
				$mail->IsSMTP();
				$mail->Hostname = $_SERVER['SERVER_NAME'];
				if (!empty($mail_smtp_host)) $mail->Host = $mail_smtp_host;
				if (!empty($mail_smtp_port)) $mail->Port = $mail_smtp_port;
				if ($mail_smtp_secure != 'none') $mail->SMTPSecure = $mail_smtp_secure;
				// Authenticate
				if ($mail_smtp_authentication) {
					$mail->SMTPAuth = true;
					$mail->Username = $mail_smtp_username;
					$mail->Password = $mail_smtp_password;
				}
				$mail->Sender = $mail->From;
				// Content
				$mail->isHTML(true);
				$mail->Subject = html_entity_decode($subject, ENT_QUOTES);
				$mail->Body = $message;
				// Send
				if ($mail->Send()) {
					$status = 'success';
					$msg = $core->get_Lang('Send email successfully');
				}
				$mail->ClearAddresses();
			} catch (Exception $e) {
				$status = 'error';
				$msg = $mail->ErrorInfo;
			}
		} else if ($mail_type == 'sendgrid') {
			$mail_sendgrid_api = $clsISO->toInt(trim($clsConfiguration->getValue('mail_sendgrid_api_enable')));
			$mail_sendgrid_api_key = trim($clsConfiguration->getValue('mail_sendgrid_api_key'));
			$mail_sendgrid_api_url = trim($clsConfiguration->getValue('mail_sendgrid_api_url'));
			$mail_sendgrid_username = trim($clsConfiguration->getValue('mail_sendgrid_username'));
			$mail_sendgrid_password = trim($clsConfiguration->getValue('mail_sendgrid_password'));
			if ($mail_sendgrid_api) {
				if (!empty($mail_sendgrid_api_key)) {
					$params = array(
						'personalizations' => array(
							array(
								'subject' => $subject,
								'to' => array(
									array(
										'email'	=> $to,
										'name' => $owner,
									),
								),
							)
						),
						'from' => array(
							"name" => $owner,
							"email" => $from
						),
						'reply_to' => array(
							"name" => $owner,
							"email" => $from
						),
						'content' => array(
							array(
								"type" => 'text/html',
								"value" => html_entity_decode($message)
							),
						)
					);
					// Generate curl request
					$ch = @curl_init($mail_sendgrid_api_url);
					// Tell curl to use HTTP TimeOut
					curl_setopt($ch, CURLOPT_ENCODING, "utf-8");
					curl_setopt($ch, CURLOPT_MAXREDIRS, 30);
					curl_setopt($ch, CURLOPT_TIMEOUT, 60);
					// Tell curl to use HTTP Version
					curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
					// Tell curl not to return headers, but do return the response
					curl_setopt($ch, CURLOPT_HEADER, false);
					// Tell curl to 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					// Tell curl to use HTTP POST
					curl_setopt($ch, CURLOPT_POST, true);
					// Tell curl that this is the body of the POST
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, @json_encode($params));
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Authorization: Bearer ' . $mail_sendgrid_api_key
					));
					// obtain response
					$response = curl_exec($ch);
					$err = curl_error($ch);
					@curl_close($ch);
					// print everything out
					$status = 'error';
					$msg =  $core->get_Lang('Send email error');
					if ($err) {
						$status = 'success';
						$msg = $core->get_Lang('Send email successfully');
					}
				} else {
					//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
					$params = array(
						'api_user' => $mail_sendgrid_username,
						'api_key' => $mail_sendgrid_password,
						'to' => $to,
						'replyto' => $to,
						'subject' => $subject,
						'html' => $message,
						'from' => $from,
						'fromname' => $owner
					);
					// Generate curl request
					$ch = curl_init($mail_sendgrid_api_url);
					// Tell curl to use HTTP POST
					curl_setopt($ch, CURLOPT_POST, true);
					// Tell curl that this is the body of the POST
					curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
					// Tell curl not to return headers, but do return the response
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					// obtain response
					$response = curl_exec($ch);
					curl_close($ch);
					// print everything out
					$status = 'error';
					$msg =  $core->get_Lang('Send email error');
					if (strpos($response, 'success') == true) {
						$status = 'success';
						$msg = $core->get_Lang('Send email successfully');
					}
				}
			} else {
				if (!empty($mail_sendgrid_api_key)) {
					require_once(DIR_INCLUDES . '/SendGrid/vendor/autoload.php');
					$email = new \SendGrid\Mail\Mail();
					$email->setFrom($from, $owner);
					$email->setSubject($subject);
					$email->addTo($to, "");
					$email->addContent("text/html", $message);
					$sendgrid = new \SendGrid($mail_sendgrid_api_key);
					try {
						$response = $sendgrid->send($email);
						if ($response->statusCode() == '200' || $response->statusCode() == '202') {
							$status = 'success';
							$msg =  $core->get_Lang('Send email successfully');
						}
					} catch (Exception $e) {
						$status = 'error';
						$msg = $e->getMessage();
					}
				} else {
					require_once(DIR_INCLUDES . '/SendGrid/vendor/autoload.php');
					$sendgrid = new SendGrid(
						$mail_sendgrid_username,
						$mail_sendgrid_password,
						array("turn_off_ssl_verification" => false)
					);
					// Create object
					$mail = new \SendGrid\Email();
					// Param send email
					$mail->addTo($to)
						->setFrom($from)
						->setFromName($owner)
						->setReplyTo($to)
						->setSubject($subject)
						->setHtml($message)
						->addHeader('X-Sent-Using', 'SendGrid-API')
						->addHeader('X-Transport', 'web');
					// obtain response
					$response = $sendgrid->send($mail);
					// Return
					$status = 'error';
					$msg =  $core->get_Lang('Send email error');
					if (
						isset($response->body['message'])
						&& $response->body['message'] == 'success'
					) {
						$status = 'success';
						$msg =  $core->get_Lang('Send email successfully');
					}
				}
			}
			/** End Sendgrid */
		}
		return array(
			'status' => $status,
			'msg'	=> $msg
		);
	}


	function sendEmailDefault($from = '', $to = '', $subject = '', $message = '', $owner = '')
	{
		return $this->sendMessage($from, $owner, $to, $toname, $subject, $message, "", 0);
	}
	function sendEmail($from = '', $to = '', $subject = '', $message = '', $owner = '', $attachments = "", $cc = null)
	{
		return $this->sendMessage($from, $owner, $to, "", $subject, $message, $attachments, 0, $cc);
	}
	function sentByGmail($from = '', $to_email = '', $subject = '', $message = '', $from_name = '')
	{
		return false;
	}
	function sendEmailVietISO($from = '', $to = '', $subject = '', $message = '', $owner = '')
	{
		return $this->sendMessage($from, $owner, $to, $toname, $subject, $message, "", 0);
	}
	function sendEmailSystem($from = '', $to = '', $subject = '', $message = '', $owner = '', $toName = '')
	{
		return $this->sendMessage($from, $owner, $to, $toName, $subject, $message, "", 0);
	}
}
