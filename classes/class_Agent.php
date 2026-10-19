<?php
class Agent extends dbBasic
{
	function __construct()
	{
		$this->pkey = "agent_id";
		$this->tbl = DB_PREFIX . "agent";
	}
	function getUsername($agent_id = 0)
	{
		if ($agent_id == 0) $agent_id = 1;
		$one = $this->getOne($agent_id);
		return $one['username'];
	}
	function getUserByLoginCode($_code = '', $_time = 0)
	{
		global $clsISO;
		$all = $this->getAll("is_trash=0 and is_active=1", $this->pkey);
		for ($i = 0; $i < count($all); $i++) {
			$agent_id = $all[$i]['agent_id'];
			if ($_code == md5('VietISO-' . $agent_id . $_time)) {
				return $agent_id;
			}
		}
		return 0;
	}
	function getEmail($agent_id = 0)
	{
		return $this->getOneField('email', $agent_id);
	}
	function getOauthProvider($agent_id = 0)
	{
		return $this->getOneField('oauth_provider', $agent_id);
	}
	function getPhone($agent_id = 0, $replace = false)
	{
		global $core;
		$phone =  $this->getOneField('phone', $agent_id);
		if ($phone != '' && $phone != '0') return $phone;
		return ($replace ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : '');
	}
	function getCountry($agent_id = 0)
	{
		global $core;
		$clsCountry = new _Country();
		$country_id = $this->getOneField('country_id', $agent_id);
		$country_name = $clsCountry->getTitle($country_id);

		if ($country_name != '' && $country_name != '0') return $country_name;
		return $core->get_Lang('Unknown');
	}
	function getAddress($agent_id = 0, $replace = false)
	{
		global $core;
		$address = $this->getOneField('address', $agent_id);
		if ($address != '' && $address != '0') return $address;
		return ($replace ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : '');
	}

	function getFullName($agent_id = 0)
	{
		$one = $this->getOne($agent_id, 'full_name');
		return $one['full_name'];
	}
	function getFirstName($agent_id = 0)
	{
		if ($agent_id == 0) $agent_id = 1;
		$one = $this->getOne($agent_id, 'first_name');
		return $one['first_name'];
	}
	function getLastName($agent_id = 0)
	{
		if ($agent_id == 0) $agent_id = 1;
		$one = $this->getOne($agent_id, 'last_name');
		return $one['last_name'];
	}
	function getAvatar($pval = 0, $w = 0, $h = 0)
	{
		global $_LANG_ID, $clsISO;
		$avatar = $this->getOneField('avatar', $pval);

		$facebook_email = $this->getOneField('facebook_email', $pval);
		$google_email = $this->getOneField('google_email', $pval);

		if ($facebook_email == '' && $google_email == '') {
			return "/files/thumbnail?w=$w&h=$h&src={$clsISO->parseImageURL($avatar)}";
		} else {
			return $avatar;
		}
	}
	function getImageAvatar($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "avatar");
		$image = $oneTable['avatar'];
		if ($image != '') {
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
		}
		$noimage = URL_IMAGES . '/img/default-no-image.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function isHaveEmail($email = '')
	{
		$all = $this->getAll("email='" . $email . "'");
		if ($all[0]['agent_id'] == '') return false;
		else return true;
	}
	function getIDByEmail($email = '')
	{
		$all = $this->getAll("email='" . $email . "'");
		if ($all[0]['agent_id'] == '') return 0;
		else return $all[0]['agent_id'];
	}
	function getLinkAgent($agent_id = 0, $type = '')
	{
		if ($agent_id == 0) $agent_id = 1;
		switch ($type) {
			case 'setting':
				return '/setting-profile.html';
				break;
			default:
				return '/profile/' . $agent_id . '.html';
		}
	}
	function generateHtmlSpam()
	{
		$isocaptcha_time_field = time();
		$html = '<style> 
					#isocaptcha{width: 318px !important; display:inline-block; border:1px solid #ccc; background:#F2F2F2; padding:5px; -moz-border-radius: 8px; border-radius: 8px;}
					#isocaptcha_imgsecure{float:left; width: 120px !important; height:35px !important; display:inline-block; border:1px solid #ccc; background:#fff; margin-left:2px; margin-top:2px;}
					#isocaptcha_response_field{float:left; font-family:Arial; font-size:40px; width: 120px !important; height:39px !important; display:inline-block; border:1px solid #ccc; margin:2px; float:left;}
					#isocaptcha_label{text-align:left !important; margin-top:2px; margin-bottom:2px; font-size:11px; font-family:Tahoma; width:100%; display:block; margin-left:2px;}
					#isocaptcha_copyright{line-height:18px; display:inline-block; float:right; padding-right:4px; width:60px; height:36px; font-size:12px; font-family:"Trebuchet MS"; color:#ccc; text-align:right; margin-right:2px;border:1px solid #ccc; margin-top:2px;}
				</style>
				<div id="isocaptcha">
					<span id="isocaptcha_label">Vui lòng nhập vào 5 ký tự dưới hình:</span>
					<div id="isocaptcha_imgsecure">
						<img src="/isocaptcha/' . $isocaptcha_time_field . '.jpg" alt="ISO CAPTCHA by VietISO" width="120" height="35" />
					</div>
					<input type="text" name="isocaptcha_response_field" maxlength="5" id="isocaptcha_response_field" value="" />
					<input type="hidden" name="isocaptcha_time_field" value="' . $isocaptcha_time_field . '" />
					<div id="isocaptcha_copyright">ISO <br />Stop Spam</div>
				</div>';
		return $html;
	}
	function getSpamCode($isocaptcha_time_field = '')
	{
		$string = md5($isocaptcha_time_field . 'VIETISO');
		$text = substr($string, 0, 5);
		return $text;
	}
	function encrypt($str = '')
	{
		return md5(md5($str . '-VIETISO'));
	}
	function checkPass($str_input = '', $str_pass = '')
	{
		$pass = $this->encrypt($str_input);
		if ($str_pass == $pass)
			return 1;
		return 0;
	}
	function checkValidEmail($email = '')
	{
		// First, we check that there's one @ symbol, and that the lengths are right
		if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
			// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			return false;
		}
		// Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
				return false;
			}
		}
		if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
					return false;
				}
			}
		}
		return true;
	}
	function checkValidUsername($username = '')
	{
		$all = $this->getAll("username='$username' order by username desc limit 0,1");
		if ($all[0][$this->pkey] != '')
			return 1;
		return 0;
	}
	function checkExitsEmail($useremail = '')
	{
		return $this->getAll("email='$useremail'") > 0 ? 1 : 0;
	}
	function checkExitsGoogle($useremail = '')
	{
		if ($this->countItem("facebook_email='$useremail' and oauth_provider='_FACEBOOK'") > 0) {
			return false;
		} elseif ($this->countItem("email='$useremail' and oauth_provider='_REGSITER'") > 0) {
			return false;
		} else {
			return 1;
		}
	}
	function isLoggedIn()
	{
		if (isset($_SESSION["logged_id"]) and  $_SESSION["logged_id"] != '' && $_SESSION["logged_key"] != '') {
			$all = $this->getAll("is_trash=0 and is_active=1", $this->pkey);
			if ($all != '') {
				for ($i = 0; $i < count($all); $i++) {
					$reg = md5($all[$i]["agent_id"] . '-' . ENCRYPTION_KEY);
					if ($_SESSION["logged_id"] === $reg) {
						$agent_id = $all[$i]['agent_id'];
						break;
					}
				}
				$userpass = $this->getOneField('userpass', $agent_id);
				if ($_SESSION["logged_key"] == md5($userpass . '-' . ENCRYPTION_KEY)) {
					return true;
				} else {
					return false;
				}
			}
		}
		return false;
	}
	function getUserID()
	{
		if ($this->isLoggedIn()) {

			$temp = $_SESSION["logged_id"];
			#
			$all = $this->getAll();

			for ($i = 0; $i < count($all); $i++) {
				$reg = md5($all[$i]["agent_id"] . '-' . ENCRYPTION_KEY);
				//return $reg;
				if ($temp === $reg) {
					$agent_id = $all[$i]['agent_id'];
					break;
				}
			}
			return $agent_id;
		} else return 0;
	}
	function agentLoggedIn($email = '', $user_pass = '')
	{
		if (!$this->isLoggedIn()) {
			$encrypt_password = $this->encrypt($user_pass);
			$arrAgent = $this->getAll("email='$email' and userpass='$encrypt_password' and is_active=1 and is_lock=0");
			if (!empty($arrAgent)) {
				$_SESSION["agent_id"] = $arrAgent[0]['agent_id'];
				$_SESSION["logged_id"] = md5($arrAgent[0]["agent_id"] . '-' . ENCRYPTION_KEY);
				$_SESSION["logged_key"] = md5($arrAgent[0]["userpass"] . '-' . ENCRYPTION_KEY);
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function userLoggedIn($user_name = '', $user_pass = '_ENCRYPT', $user_pass_encrypt = NULL)
	{
		if (!$this->isLoggedIn()) {
			$encrypt_password = $user_pass_encrypt;
			if ($user_pass != '_ENCRYPT') {
				$encrypt_password = $this->encrypt($user_pass);
			}
			$arrAgent = $this->getAll("(username='$user_name' or email='$user_name') and userpass='$encrypt_password'");
			if (!empty($arrAgent)) {
				$_SESSION["agent_id"] = $arrAgent[0]['agent_id'];
				$_SESSION["logged_id"] = md5($arrAgent[0]["agent_id"] . '-' . ENCRYPTION_KEY);
				$_SESSION["logged_key"] = md5($arrAgent[0]["userpass"] . '-' . ENCRYPTION_KEY);
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function userDoLogout()
	{
		$agent_id = $_SESSION["logged_id"];
		$all = $this->getAll("is_active='1' and is_verify='1'", $this->pkey);
		if (!empty($all)) {
			for ($i = 0; $i < count($all); $i++) {
				$temp = md5($all[$i]["agent_id"] . '-VIETISO');
				if ($temp == $agent_id) {
					$agent_id = $all[$i]["agent_id"];
					break;
				}
			}
		}
		unset($_SESSION["agent_id"]);
		unset($_SESSION["logged_id"]);
		unset($_SESSION["logged_key"]);
		return true;
	}
	function userLoggedInFacebook($args = array(), $is_agent = 0)
	{
		global $_testVersion, $core, $clsISO;
		#
		$email = $args['email'];
		$arrAgent = $this->getAll("facebook_email='$email' and oauth_provider='_FACEBOOK' limit 0,1");
		if ($arrAgent[0]["agent_id"] != '') {
			$agent_id = $arrAgent[0]["agent_id"];
			$_SESSION["agent_id"] = $agent_id;
			$_SESSION["logged_id"] = md5($arrAgent[0]["agent_id"] . '-' . ENCRYPTION_KEY);
			$_SESSION["logged_key"] = md5($arrAgent[0]["userpass"] . '-' . ENCRYPTION_KEY);
			return true;
		} else {
			if ($this->countItem("facebook_email='$email' and oauth_provider='_REGSITER'") > 0) {
				return false;
			} elseif ($this->countItem("email='$email' and oauth_provider='_GOOGLE'") > 0) {
				return false;
			} else {
				$tmpInfo = explode('@', $email);
				$username = $tmpInfo[0];
				$lstAgent = $this->getAll("username='$username' limit 0,1");
				if ($lstAgent[0]['agent_id'] != '') {
					$username =  $username . rand(0, 9);
				}
				$avatar = 'http://graph.facebook.com/' . $args['id'] . '/picture';
				$full_name = $args['first_name'] . ' ' . $args['last_name'];
				$full_name_slug = $core->replaceSpace($full_name);
				$password = substr(strtoupper(md5(time() . '-' . ENCRYPTION_KEY)), 0, 8);
				$userpass = $this->encrypt($password);

				#
				$f = "agent_id
				,email
				,facebook_email
				,username
				,userpass
				,full_name
				,full_name_slug
				,first_name
				,last_name
				,gender
				,avatar
				,oauth_provider
				,oauth_username
				,oauth_email
				,ip_register
				,reg_date
				,is_agent
				,is_active";
				#
				$agent_id = $this->getMaxId();
				$v = "
				'" . $agent_id . "',
				'" . addslashes($email) . "',
				'" . addslashes($email) . "',
				'" . addslashes($username) . "',
				'" . addslashes($userpass) . "',
				'" . addslashes($full_name) . "',
				'" . addslashes($full_name_slug) . "',
				'" . addslashes($user_profile['first_name']) . "',
				'" . addslashes($user_profile['last_name']) . "',
				'" . (strtolower($user_profile['gender']) == 'male' ? 1 : 0) . "',
				'" . addslashes($avatar) . "',
				'_FACEBOOK',
				'" . addslashes($user_name) . "',
				'" . addslashes($email) . "',
				'" . $_SERVER['REMOTE_ADDR'] . "',
				'" . time() . "',
				'" . $is_agent . "',
				'1'";
				if ($this->insertOne($f, $v)) {
					$_SESSION["agent_id"] = $agent_id;
					$_SESSION["logged_id"] = md5($agent_id . '-' . ENCRYPTION_KEY);
					$_SESSION["logged_key"] = md5($userpass . '-' . ENCRYPTION_KEY);
					// Send email success
					if ($is_agent == '2') {
					} else {
						$this->sendEmailRegisterAgent($agent_id, $userpass);
					}
					return true;
				} else {
					return false;
				}
			}
		}
	}
	function userLoggedInGoogle($args = array())
	{
		global $_testVersion, $core, $clsISO;
		$email = $args['email'];
		$arrAgent = $this->getAll("is_active=1 and oauth_provider='_GOOGLE' and google_email='$email' limit 0,1");
		if ($arrAgent[0]["agent_id"] != '') {
			$_SESSION["agent_id"] = $arrAgent['agent_id'];
			$_SESSION["logged_id"] = md5($arrAgent[0]["agent_id"] . '-' . ENCRYPTION_KEY);
			$_SESSION["logged_key"] = md5($arrAgent[0]["userpass"] . '-' . ENCRYPTION_KEY);
			return true;
		} else {
			if ($this->countItem("google_email='$email' and oauth_provider='_FACEBOOK'") > 0) {
				echo 'invalidAccount';
				die();
			}
			$tmpInfo = explode('@', $email);
			$username = $tmpInfo[0];
			$lstAgent = $this->getAll("username='$username' limit 0,1");
			if ($lstAgent[0]['agent_id'] != '') {
				$username =  $username . rand(0, 9);
			}
			$password = substr(strtoupper(md5(time() . '-' . ENCRYPTION_KEY)), 0, 8);
			$userpass = $this->encrypt($password);
			$oauth_id = $args['id'];
			$full_name = $args['full_name'];
			$full_name_slug = $core->replaceSpace($full_name);
			$first_name = $args['given_name'];
			$last_name = $args['family_name'];
			$avatar = $args['avatar'];
			$gender = $args['gender'];
			$locale = $args['locale'];
			$hd = $args['hd'];
			$is_agent = $args['is_agent'];
			$link = $args['link'];
			$verified_email = $args['verified_email'];
			#
			$f = "agent_id
			,email
			,google_email
			,google_link
			,username
			,userpass
			,full_name
			,full_name_slug
			,first_name
			,last_name
			,gender
			,avatar
			,locale
			,hd
			,verified_email
			,oauth_id
			,oauth_provider
			,oauth_username
			,oauth_email
			,ip_register
			,reg_date
			,is_agent
			,is_active";
			#
			$agent_id = $this->getMaxId();
			$v = "
			'" . $agent_id . "',
			'" . addslashes($email) . "',
			'" . addslashes($email) . "',
			'" . addslashes($link) . "',
			'" . addslashes($username) . "',
			'" . addslashes($userpass) . "',
			'" . addslashes($full_name) . "',
			'" . addslashes($full_name_slug) . "',
			'" . addslashes($first_name) . "',
			'" . addslashes($last_name) . "',
			'" . (strtolower($gender) == 'male' ? 1 : 0) . "',
			'" . addslashes($avatar) . "',
			'" . addslashes($locale) . "',
			'" . addslashes($hd) . "',
			'" . ($verified_email ? 1 : 0) . "',
			'" . addslashes($oauth_id) . "',
			'_GOOGLE',
			'" . addslashes($user_name) . "',
			'" . addslashes($email) . "',
			'" . $_SERVER['REMOTE_ADDR'] . "',
			'" . time() . "',
			'" . $is_agent . "',
			'1'";
			//print_r($f.'<br />'.$v); die();
			if ($this->insertOne($f, $v)) {
				$_SESSION["agent_id"] = $agent_id;
				$_SESSION["logged_id"] = md5($agent_id . '-' . ENCRYPTION_KEY);
				$_SESSION["logged_key"] = md5($userpass . '-' . ENCRYPTION_KEY);
				// Send email success
				if ($is_agent == '2') {
				} else {
					$this->sendEmailRegisterAgent($agent_id, $userpass);
				}
				return true;
			} else {
				return false;
			}
		}
	}
	function userLoggedInTwitter($args = array())
	{
		global $_testVersion, $clsISO;
		$oauth_provider = '_TWITTER';
		#
		$username = $args->screen_name;
		$arrAgent = $this->getAll("is_active=1 and username='$username' and oauth_provider='$oauth_provider' limit 0,1");
		if ($arrAgent[0]["agent_id"] != '') {
			$_SESSION["logged_id"] = md5($arrAgent[0]["agent_id"] . '-' . ENCRYPTION_KEY);
			$_SESSION["logged_key"] = md5($arrAgent[0]["userpass"] . '-' . ENCRYPTION_KEY);
			return true;
		} else {
			$lstAgent = $this->getAll("username='$username' limit 0,1");
			if ($lstAgent[0]['agent_id'] != '') {
				$username =  $username . rand(0, 9);
			}
			$full_name = $args->name;
			$full_name_slug = $full_name;
			$tmp = explode(" ", $args->name);
			$first_name = isset($tmp[0]) ? $tmp[0] : '';
			$last_name = isset($tmp[1]) ? $tmp[1] : '';
			$password = substr(strtoupper(md5(time() . '-' . ENCRYPTION_KEY)), 0, 8);
			$userpass = $this->encrypt($password);
			$oauth_id = $args->id;
			$avatar = $args->profile_image_url;
			$locale = $args->lang;
			#
			$f = "agent_id
			,username
			,userpass
			,full_name
			,full_name_slug
			,first_name
			,last_name
			,avatar
			,oauth_id
			,oauth_provider
			,oauth_username
			,locale
			,ip_register
			,reg_date
			,is_active
			,_first_login";
			#
			$agent_id = $this->getMaxId();
			$v = "
			'" . $agent_id . "',
			'" . addslashes($username) . "',
			'" . addslashes($userpass) . "',
			'" . addslashes($full_name) . "',
			'" . addslashes($full_name_slug) . "',
			'" . addslashes($first_name) . "',
			'" . addslashes($last_name) . "',
			'" . addslashes($avatar) . "',
			'" . addslashes($oauth_id) . "',
			'$oauth_provider',
			'" . addslashes($user_name) . "',
			'" . addslashes($locale) . "',
			'" . $_SERVER['REMOTE_ADDR'] . "',
			'" . time() . "',
			'1','1'";
			//print_r($f.'<br />'.$v); die();
			if ($this->insertOne($f, $v)) {
				$_SESSION["logged_id"] = md5($agent_id . '-' . ENCRYPTION_KEY);
				$_SESSION["logged_key"] = md5($userpass . '-' . ENCRYPTION_KEY);
				// Send email success
				$this->sendEMailRegisterSuccess($agent_id);
				return true;
			} else {
				return false;
			}
		}
	}
	function sendEmailRegisterAgent($agent_id = 0, $userpass = NULL)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $clsISO, $_LANG_ID, $email_template_signup_agent_id;
		$clsISO = new ISO();
		$clsEmailTemplate = new EmailTemplate();
		header('Content-Type: text/html; charset=utf-8');

		$email_template_id = $email_template_signup_agent_id;

		$oneTable = $this->getOne($agent_id);
		$verification_code = md5($agent_id . '-VietISO');
		# Parse Template
		$message = $clsEmailTemplate->getHeader($email_template_id);
		$message .= $clsEmailTemplate->getContent($email_template_id);
		$message .= $clsEmailTemplate->getFooter($email_template_id);

		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%CUSTOMER_NAME%]', $oneTable['full_name'], $message);
		$message = str_replace('[%USER_EMAIL%]', $oneTable['email'], $message);

		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);
		//print_r($_LANG_ID.''.$message); die();
		#Send email to customer
		$from = $clsEmailTemplate->getFromEmail($email_template_id);

		$to = trim($oneTable['email']);
		$owner = PAGE_NAME;
		$subject = $clsEmailTemplate->getSubject($email_template_id);
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		$this->updateOne($agent_id, "verified_email='$to'");
		return 1;
	}
	function sendEmailRegisterCTV($agent_id = 0, $userpass = NULL)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $clsISO, $_LANG_ID, $email_template_signup_ctv_id;
		$clsISO = new ISO();
		$clsEmailTemplate = new EmailTemplate();
		header('Content-Type: text/html; charset=utf-8');

		$email_template_id = $email_template_signup_ctv_id;

		$oneTable = $this->getOne($agent_id);
		$verification_code = md5($agent_id . '-VietISO');
		# Parse Template
		$message .= $clsEmailTemplate->getContent($email_template_id);
		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%CUSTOMER_NAME%]', $oneTable['full_name'], $message);
		$message = str_replace('[%USER_EMAIL%]', $oneTable['email'], $message);
		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);

		#Send email to customer
		$from = $clsEmailTemplate->getFromEmail($email_template_id);
		$to = trim($oneTable['email']);
		$owner = PAGE_NAME;
		$subject = $clsEmailTemplate->getSubject($email_template_id);
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		$this->updateOne($agent_id, "verified_email='$to'");
		return 1;
	}
	function sendEmailUpdateProfileAgent($agent_id = 0)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $clsISO, $_LANG_ID, $email_template_update_profile_agent_id;
		$clsISO = new ISO();
		$clsEmailTemplate = new EmailTemplate();
		header('Content-Type: text/html; charset=utf-8');

		$email_template_id = $email_template_update_profile_agent_id;

		$oneTable = $this->getOne($agent_id);
		$verification_code = md5($agent_id . '-VietISO');
		# Parse Template
		$message .= $clsEmailTemplate->getContent($email_template_id);
		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%CUSTOMER_NAME%]', $oneTable['full_name'], $message);
		$message = str_replace('[%USER_EMAIL%]', $oneTable['email'], $message);

		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);

		#Send email to customer
		$from = $clsEmailTemplate->getFromEmail($email_template_id);
		$to = trim($oneTable['email']);
		$owner = PAGE_NAME;
		$subject = $clsEmailTemplate->getSubject($email_template_id);
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		$this->updateOne($agent_id, "verified_email='$to'");
		return 1;
	}
	function sendEmailActiveAgent($agent_id = 0)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $clsISO, $_LANG_ID, $email_template_active_agent_id;
		$clsISO = new ISO();
		$clsEmailTemplate = new EmailTemplate();
		header('Content-Type: text/html; charset=utf-8');

		$email_template_id = $email_template_active_agent_id;

		$oneTable = $this->getOne($agent_id);
		$login_link = DOMAIN_NAME . $clsISO->getLink("agent_signin");
		$verification_code = md5($agent_id . '-VietISO');
		$random_pass = $clsISO->getRandomString(8);
		# Parse Template
		$message = $clsEmailTemplate->getHeader($email_template_id);
		$message .= $clsEmailTemplate->getContent($email_template_id);
		$message .= $clsEmailTemplate->getFooter($email_template_id);

		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%CUSTOMER_NAME%]', $oneTable['full_name'], $message);
		$message = str_replace('[%USER_EMAIL%]', $oneTable['email'], $message);

		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);
		$message = str_replace('[%LINK_RESET%]', DOMAIN_URL . $extLang . '/travel-agent/reset-pass/' . $oneTable['reset_code'], $message);
		$message = str_replace('[%LINK_SIGNIN%]', DOMAIN_URL . $clsISO->getLink("agent_signin"), $message);
		$message = str_replace('[%PASSWORD%]', $random_pass, $message);
		// print_r($message); die();
		#Send email to customer
		$from = $clsEmailTemplate->getFromEmail($email_template_id);
		$to = trim($oneTable['email']);
		$owner = PAGE_NAME;
		$subject = $clsEmailTemplate->getSubject($email_template_id);
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		$this->updateOne($agent_id, "userpass='{$this->encrypt($random_pass)}'");
		return 1;
	}
	function sendEmailBlockAgent($agent_id = 0)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $clsISO, $_LANG_ID, $email_template_block_agent_id;
		$clsISO = new ISO();
		$clsEmailTemplate = new EmailTemplate();
		header('Content-Type: text/html; charset=utf-8');

		$email_template_id = $email_template_block_agent_id;

		$oneTable = $this->getOne($agent_id);
		$verification_code = md5($agent_id . '-VietISO');
		# Parse Template

		$message = $clsEmailTemplate->getHeader($email_template_id);
		$message .= $clsEmailTemplate->getContent($email_template_id);
		$message .= $clsEmailTemplate->getFooter($email_template_id);

		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%CUSTOMER_NAME%]', $oneTable['full_name'], $message);
		$message = str_replace('[%USER_EMAIL%]', $oneTable['email'], $message);

		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);

		#Send email to customer
		$from = $clsEmailTemplate->getFromEmail($email_template_id);
		$to = trim($oneTable['email']);
		$owner = PAGE_NAME;
		$subject = $clsEmailTemplate->getSubject($email_template_id);
		$is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
		$this->updateOne($agent_id, "verified_email='$to'");
		return 1;
	}
	function sendEMailRegisterSuccess($agent_id = 0)
	{
		global $clsISO;
		$clsISO = new ISO();

		$oneItem = $this->getOne($agent_id);
		$email = $oneItem['email'];
		$dateSent = date_create(date());
		$dateSent = date_format($date, 'jS F Y');
		$message = '<table style="border-collapse:collapse;font:normal 11px Arial, Helvetica, sans-serif;color:#777" width="678" align="center" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr><td style="padding:8px 10px 5px;font:normal 9px Verdana, Arial, Helvetica, sans-serif;color:#444" align="left"><a href="' . PCMS_URL . '" target="_blank" style="text-decoration:none;color:#A82229">Trouble viewing this e-mail</a></td></tr>

  <tr><td style="padding:1px" bgcolor="#eeeeee">
          <table style="border-collapse:collapse;font:normal 11px Arial, Helvetica, sans-serif;color:#A82229" width="676" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr bgcolor="#eeeeee">
              <td style="padding:15px 10px 12px" align="left">
              	<strong style="font-size:16px;">Dear "' . $oneItem['email'] . '"</strong>
              </td>
              <td style="padding:15px 10px 12px;font-size:22px" align="right"><a style="color:#A82229; text-decoration:none;" href="' . PCMS_URL . '"></a></td>
            </tr>
            <tr>
              <td style="padding:5px 10px 3px" align="left">
                <a href="' . PCMS_URL . '/attractions/" style="text-decoration:none;color:#A82229" target="_blank">Attractions</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/travel-guide/destination-in-vietnam/" style="text-decoration:none;color:#A82229" target="_blank">Destinations</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/accommodations/" style="text-decoration:none;color:#A82229" target="_blank">Accommodations</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/travel-guide/" style="text-decoration:none;color:#A82229" target="_blank">Travel Guide</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/news/" style="text-decoration:none;color:#A82229" target="_blank">News</a>
              </td>
              <td style="padding:5px 10px 2px" align="right">' . $dateSent . '</td>
            </tr>
          </tbody></table>
</td></tr></tbody></table>
<table style="border-collapse:seperate" width="678" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="padding:12px 10px 8px; background:#eeeeee;">
        	<span style="color:#141313; font-family:Trebuchet MS; font-size:13px;">
			Thank you for registering for Travel Agent with us. Your submitted travel agent has been
approved for the following information: <br><br>
			</span>
            <table style="border-collapse:collapse; width:100%;">
			<tr>
				<td style="border:1px solid #ccc; padding:5px;">Your ID</td>
				<td style="border:1px solid #ccc; padding:5px;"><strong>' . $oneItem['email'] . '</strong></td>
			</tr>			
			<tr>
				<td style="border:1px solid #ccc;padding:5px;">Your Password:</td>
				<td style="border:1px solid #ccc;padding:5px;">' . $oneItem['email'] . '</td>
			</tr>
		</table>

            <div style="clear:both; margin-top:10px;"></div>
            <p style="font-size:11px; color:#000; font-family:Trebuchet MS;">
                You can use your user account to log in to our online system and make any changes on
your request with following suggestions:
                <br />
                <br />
				If this link does not work, please copy and paste the URL into your browser window.
				<br />
                Should you have any questions or comments, please contact us.
				<br />
                Many thanks and best regards,
        	</p>
        </td>
    </tr>
</table>';
		$subject = 'Confirmation of successful registration ' . PAGE_NAME;
		$from = SERVICE_ACCOUNT_EMAIL;
		$to = $email;
		$clsISO->sendEmail($from, $to, $subject, $message, PAGE_NAME);
	}

	function sendEMailForgotPasswordSuccess($agent_id = 0)
	{
		global $clsISO;
		$clsISO = new ISO();
		$clsDistrict = new District();

		$oneItem = $this->getOne($agent_id);
		$email = $oneItem['email'];
		$dateSent = date_create(date());
		$dateSent = date_format($date, 'jS F Y');
		$message = '<table style="border-collapse:collapse;font:normal 11px Arial, Helvetica, sans-serif;color:#777" width="678" align="center" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr><td style="padding:8px 10px 5px;font:normal 9px Verdana, Arial, Helvetica, sans-serif;color:#444" align="left"><a href="' . PCMS_URL . '" target="_blank" style="text-decoration:none;color:#A82229">Trouble viewing this e-mail</a></td></tr>

  <tr><td style="padding:1px" bgcolor="#eeeeee">
          <table style="border-collapse:collapse;font:normal 11px Arial, Helvetica, sans-serif;color:#A82229" width="676" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr bgcolor="#eeeeee">
              <td style="padding:15px 10px 12px" align="left">
              	<strong style="font-size:16px;">Dear "' . $oneItem['first_name'] . ' ' . $oneItem['last_name'] . '"</strong>
              </td>
              <td style="padding:15px 10px 12px;font-size:22px" align="right"><a style="color:#A82229; text-decoration:none;" href="' . PCMS_URL . '"></a></td>
            </tr>
            <tr>
              <td style="padding:5px 10px 3px" align="left">
                <a href="' . PCMS_URL . '/attractions/" style="text-decoration:none;color:#A82229" target="_blank">Attractions</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/travel-guide/destination-in-vietnam/" style="text-decoration:none;color:#A82229" target="_blank">Destinations</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/accommodations/" style="text-decoration:none;color:#A82229" target="_blank">Accommodations</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/travel-guide/" style="text-decoration:none;color:#A82229" target="_blank">Travel Guide</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/news/" style="text-decoration:none;color:#A82229" target="_blank">News</a>
              </td>
              <td style="padding:5px 10px 2px" align="right">' . $dateSent . '</td>
            </tr>
          </tbody></table>
</td></tr></tbody></table>
<table style="border-collapse:seperate" width="678" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="padding:12px 10px 8px; background:#eeeeee;">
        	<span style="color:#141313; font-family:Trebuchet MS; font-size:13px;">
			An account password reset has been requested for this email account. To complete the process, please

click the link below or copy it to your web browser. This link will expire in 5 hours: <a href="#"><span style="color:red">Here</span></a><br><br>
			</span>           
		</table>

            <div style="clear:both; margin-top:10px;"></div>
            <p style="font-size:11px; color:#000; font-family:Trebuchet MS;">
               Should you have any questions or comments, please contact us.
                <br />
                <br />
				Best regards,
				<br />               
        	</p>
        </td>
    </tr>
</table>';
		$subject = 'Password Forgotten Notification ' . PAGE_NAME;
		$from = SERVICE_ACCOUNT_EMAIL;
		$to = $email;
		$clsISO->sendEmail($from, $to, $subject, $message, PAGE_NAME);
	}

	function sendEMailResetPasswordSuccess($agent_id = 0)
	{
		global $clsISO;
		$clsISO = new ISO();

		$oneItem = $this->getOne($agent_id);

		$email = $oneItem['email'];
		$dateSent = date_create(date());
		$dateSent = date_format($date, 'jS F Y');
		$message = '<table style="border-collapse:collapse;font:normal 11px Arial, Helvetica, sans-serif;color:#777" width="678" align="center" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr><td style="padding:8px 10px 5px;font:normal 9px Verdana, Arial, Helvetica, sans-serif;color:#444" align="left"><a href="' . PCMS_URL . '" target="_blank" style="text-decoration:none;color:#A82229"></a></td></tr>

  <tr><td style="padding:1px" bgcolor="#eeeeee">
          <table style="border-collapse:collapse;font:normal 11px Arial, Helvetica, sans-serif;color:#A82229" width="676" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr bgcolor="#eeeeee">
              <td style="padding:15px 10px 12px" align="left">
              	<strong style="font-size:16px;">Dear "' . $oneItem['first_name'] . ' ' . $oneItem['last_name'] . '"</strong>
              </td>
              <td style="padding:15px 10px 12px;font-size:22px" align="right"><a style="color:#A82229; text-decoration:none;" href="' . PCMS_URL . '"></a></td>
            </tr>
            <tr>
              <td style="padding:5px 10px 3px" align="left">
                <a href="' . PCMS_URL . '/attractions/" style="text-decoration:none;color:#A82229" target="_blank">Attractions</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/travel-guide/destination-in-vietnam/" style="text-decoration:none;color:#A82229" target="_blank">Destinations</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/accommodations/" style="text-decoration:none;color:#A82229" target="_blank">Accommodations</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/travel-guide/" style="text-decoration:none;color:#A82229" target="_blank">Travel Guide</a>  &nbsp;|&nbsp;
                <a href="' . PCMS_URL . '/news/" style="text-decoration:none;color:#A82229" target="_blank">News</a>
              </td>
              <td style="padding:5px 10px 2px" align="right">' . $dateSent . '</td>
            </tr>
          </tbody></table>
</td></tr></tbody></table>
<table style="border-collapse:seperate" width="678" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="padding:12px 10px 8px; background:#eeeeee;">
        	<span style="color:#141313; font-family:Trebuchet MS; font-size:13px;">
			An account password reset has been requested for this email account. To complete the process, please

log-in your account with following details:<br><br>
			</span>           
		</table>

            <div style="clear:both; margin-top:10px;"></div>
            <p style="font-size:11px; color:#000; font-family:Trebuchet MS;">
               After logging in, please update your password to complete the process.
                <br />
                <br />
				Should you have any questions or comments, please contact us.
				  <br />
                <br />
				Best regards,
				<br />               
        	</p>
        </td>
    </tr>
</table>';
		$subject = 'Password Reset Notification ' . PAGE_NAME;
		$from = SERVICE_ACCOUNT_EMAIL;
		$to = $email;
		$clsISO->sendEmail($from, $to, $subject, $message, PAGE_NAME);
	}

	function sendEmailChangePassword($agent_id = 0, $password = '')
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $_LANG_ID, $email_template_change_pass_agent_id;
		#
		$clsEmailTemplate = new EmailTemplate();
		$oneItem = $this->getOne($agent_id);

		$email_template_id = $email_template_change_pass_agent_id;

		# Parse Template
		header('Content-Type: text/html; charset=utf-8');

		$message = $clsEmailTemplate->getHeader($email_template_id);
		$message .= $clsEmailTemplate->getContent($email_template_id);
		$message .= $clsEmailTemplate->getFooter($email_template_id);

		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%CUSTOMER_NAME%]', $this->getFullname($agent_id), $message);
		$message = str_replace('[%EMAIL_ACCOUNT%]', $this->getEmail($agent_id), $message);
		$message = str_replace('[%NEW_PASSWORD%]', '<b>' . $password . '</b>', $message);

		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);

		$from = $clsEmailTemplate->getFromEmail($email_template_id);

		#Send email to customer
		$to = trim($this->getEmail($agent_id));
		$owner = PAGE_NAME;
		$subject = $clsEmailTemplate->getSubject($email_template_id);
		$clsISO->sendEmail($from, $to, $subject, $message, $owner);
		return 1;
	}

	function sendEmailForgetPassword($agent_id = 0)
	{
		global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $_LANG_ID, $email_template_reset_pass_agent_id;
		#
		$clsEmailTemplate = new EmailTemplate();
		$oneItem = $this->getOne($agent_id);

		$email_template_id = $email_template_reset_pass_agent_id;
		# Parse Template
		header('Content-Type: text/html; charset=utf-8');

		$message = $clsEmailTemplate->getHeader($email_template_id);
		$message .= $clsEmailTemplate->getContent($email_template_id);
		$message .= $clsEmailTemplate->getFooter($email_template_id);

		$message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
		$message = str_replace('[%CUSTOMER_NAME%]', $this->getUsername($agent_id), $message);
		$message = str_replace('[%CUSTOMER_FULL_NAME%]', $this->getFullname($agent_id), $message);
		$message = str_replace('[%LINK_RESET%]', PCMS_URL . $extLang . 'travel-agent/reset-pass/' . $oneItem['reset_code'], $message);

		$message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
		$message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
		$message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
		$message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
		$message = str_replace('[%DATETIME%]', date('Y', time()), $message);

		//print_r($message);die();
		$from = $clsEmailTemplate->getFromEmail($email_template_id);

		#Send email to customer
		$to = trim($oneItem['email']);
		$owner = PAGE_NAME;
		$subject = $clsEmailTemplate->getSubject($email_template_id);
		$subject = str_replace('[%PAGE_NAME%]', PAGE_NAME, $subject);
		$clsISO->sendEmail($from, $to, $subject, $message, $owner);
		return 1;
	}
}
