<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class EmailSMTP{
	public $debug = 2;//Client commands and server responses
	public $host = 'smtp.gmail.com';
	public $secure = 'tls';
	public $post = 587;
	public $auth = true;
	public $content_type = 'text/html';
	public $username = 'support@vietiso.com';
	public $password = 'vietiso127@@';
	public $fromemail = '';
	public $fromname = '';
	public $toemail = '';
	public $toname = '';
	public $replyemail = '';
	public $lstcc = '';
	public $lstbcc = '';
	public $attachments = '';
	public $subject = '';
	public $message = '';
	function __construct($config=''){
		if(is_array($config)){
			foreach($config as $k=>$v){
				$this->{$k} = $v;
			}
		}
	}
	// Get configuration
	function _getConfig($config_key){
		return $this->{$config_key};
	}
	// Set configuration
	function _setConfig($config_key, $config_value){
		$this->{$config_key} = $config_value;
	}
	function senMail(){
		global $clsISO;
		//Load Composer's autoloader
		//require DIR_INCLUDES.'vendor/autoload.php';
		//require_once(DIR_INCLUDES.'/addons/phpmailer6.5/vendor/autoload.php');
		require_once(DIR_INCLUDES.'/mailer/phpmailer6.6.3/vendor/autoload.php');
		//Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);
		try {
			// Empty out the values that may be set
			$mail->clearAllRecipients();
			$mail->clearAttachments();
			$mail->clearCustomHeaders();
			$mail->clearReplyTos();
			$mail->ClearAddresses();
			//Server settings
			$mail->SMTPDebug = $this->debug;                    //Enable verbose debug output
			$mail->isSMTP();                                    //Send using SMTP
			$mail->Host       = $this->host;                    //Set the SMTP server to send through
			$mail->SMTPAuth   = $this->auth;                    //Enable SMTP authentication
			$mail->Username   = $this->username;                //SMTP username
			$mail->Password   = $this->password;                //SMTP password
			$mail->SMTPSecure = $this->secure; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = $this->post;                            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
																//465: SSL, 	587: TLS
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			$mail->Priority  = 3;								//null (default), 1 = High, 3 = Normal, 5 = low.
			$mail->CharSet = 'utf-8';
			$mail->Encoding  = '8bit';
			//Recipients
			$mail->setFrom($this->fromemail, $this->fromname);
			$mail->addAddress($this->toemail, $this->toname);     //Add a recipient
			//$mail->addAddress('ellen@example.com');               //Name is optional
			$mail->addReplyTo($this->replyemail);
			//$mail->addCC('cc@example.com');
			if(!empty($this->lstcc)){
				if(is_array($this->lstcc)){
					foreach($this->lstcc as $value) {
						$ccaddress = trim($value);
						if($ccaddress) {
							$mail->addCC($ccaddress);
						}
					}
				}else{
					$cc = explode(",", $this->lstbcc);
					foreach($cc as $value) {
						$ccaddress = trim($value);
						if($ccaddress) {
							$mail->addCC($ccaddress);
						}
					}
				}
			}
			//$mail->addBCC('bcc@example.com');
			if(!empty($this->lstbcc)){
				if(is_array($this->lstbcc)){
					foreach($this->lstbcc as $value) {
						$ccaddress = trim($value);
						if($ccaddress) {
							$mail->addBCC($ccaddress);
						}
					}
				}else{
					$bcc = explode(",", $this->lstbcc);
					foreach($bcc as $value) {
						$ccaddress = trim($value);
						if($ccaddress) {
							$mail->AddBCC($ccaddress);
						}
					}
				}
			}
			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
			if (!empty($this->attachments)){
				if(is_array($this->attachments)){
					foreach ($this->attachments as $filename) {
						$mail->AddAttachment($filename);
					}
				}else{
					$mail->AddAttachment($this->attachments);
				}	
			}
			//Content
			$mail->ContentType = $this->content_type;
			if('text/html' == $this->content_type){
				$mail->IsHTML(true);
			}
			//$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $this->subject;
			if('text/html' == $this->content_type){
				$mail->Body = $this->message;
				$message_text = str_replace("<p>", "", $this->message);
				$message_text = str_replace("</p>", "\r\n\r\n", $message_text);
				$message_text = str_replace("<br>", "\r\n", $message_text);
				$message_text = str_replace("<br />", "\r\n", $message_text);
				$message_text = strip_tags($message_text);
				$mail->AltBody = html_entity_decode($message_text, ENT_QUOTES);
			}else{
				$message_text = html_entity_decode($this->message, ENT_QUOTES);
				$mail->Body = strip_tags($message_text);
			}
			/*$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';*/
				
			//var_dump( $mail->From);die;
			//$mail->send();
			$is_send_mail = $mail->send();
			
			//echo 'Message has been sent';
		} catch (Exception $e) {
			$is_send_mail = false;
			if($this->debug){
				return $mail->ErrorInfo;
			}
			//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
		/*if($this->debug){
			var_dump($this->lstcc);
		}*/
		return $is_send_mail;
	}
}
?>