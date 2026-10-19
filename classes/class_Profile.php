<?php

class Profile extends dbBasic
{
    function __construct()
    {
        $this->pkey = "profile_id";
        $this->tbl = DB_PREFIX . "profile";
    }

    function getUsername($profile_id = 0)
    {
        if ($profile_id == 0) $profile_id = 1;
        $one = $this->getOne($profile_id);
        return $one['username'];
    }

    function getUserByLoginCode($_code = 0, $_time = 0)
    {
        global $clsISO;
        $all = $this->getAll("is_trash=0 and is_active=1", $this->pkey);
        for ($i = 0; $i < count($all); $i++) {
            $profile_id = $all[$i]['profile_id'];
            if ($_code == md5('VietISO-' . $profile_id . $_time)) {
                return $profile_id;
            }
        }
        return 0;
    }

    function getEmail($profile_id = 0)
    {
        return $this->getOneField('email', $profile_id);
    }

    function getOauthProvider($profile_id = 0)
    {
        return $this->getOneField('oauth_provider', $profile_id);
    }

    function getPhone($profile_id = 0, $replace = false)
    {
        global $core;
        $phone = $this->getOneField('phone', $profile_id);
        if ($phone != '' && $phone != '0') return $phone;
        return ($replace ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : '');
    }

    function getCountry($profile_id = 0)
    {
        global $core;
        $clsCountry = new _Country();
        $country_id = $this->getOneField('country_id', $profile_id);
        $country_name = $clsCountry->getTitle($country_id);

        if ($country_name != '' && $country_name != '0') return $country_name;
        return $core->get_Lang('Unknown');
    }

    function getAddress($profile_id = 0, $replace = false)
    {
        global $core;
        $address = $this->getOneField('address', $profile_id);
        if ($address != '' && $address != '0') return $address;
        return ($replace ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : '');
    }

    function getFullname($profile_id = 0, $one = null)
    {
        if ($profile_id == 0) $profile_id = 1;
        if (!isset($one['first_name']) || !isset($one['last_name']) || !isset($one['full_name']) || !isset($one['username'])) {
            $one = $this->getOne($profile_id, 'first_name,last_name,full_name,username');
        }
        if (empty($one['first_name']) && empty($one['last_name']) && empty($one['full_name'])) {
            return $one['username'];
        } elseif (empty($one['first_name']) && empty($one['last_name'])) {
            return $one['full_name'];
        } else {
            return $one['first_name'] . ' ' . $one['last_name'];
        }
    }

    function getSlug($profile_id = 0)
    {
        global $_LANG_ID, $core;
        $one = $this->getOne($profile_id, 'slug,fullname');
        return $one['slug'] == '' ? $core->replaceSpace($one['fullname']) : $one['slug'];
    }

    function getFirstName($profile_id = 0)
    {
        if ($profile_id == 0) $profile_id = 1;
        $one = $this->getOne($profile_id, 'first_name');
        return $one['first_name'];
    }

    function getLastName($profile_id = 0)
    {
        if ($profile_id == 0) $profile_id = 1;
        $one = $this->getOne($profile_id, 'last_name');
        return $one['last_name'];
    }

    function getAvatar($pval = 0, $w = 0, $h = 0)
    {
        global $_LANG_ID, $clsISO;
        $avatar = $this->getOneField('avatar', $pval);

        $facebook_email = $this->getOneField('facebook_email', $pval);
        $google_email = $this->getOneField('google_email', $pval);

        if ($facebook_email == '' && $google_email == '') {
            return $clsISO->tripslashImage($avatar, $w, $h);
        } else {
            return $clsISO->tripslashUrl($avatar);
        }
    }

    function getImageAvatar($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        if (!isset($oneTable['avatar'])) {
            $oneTable = $this->getOne($pvalTable, "avatar");
        }
        $image = $oneTable['avatar'];
        if (isset($oneTable['facebook_email']) && $oneTable['facebook_email'] != '' && isset($oneTable['google_email']) && $oneTable['google_email'] != '' && isset($oneTable['avatar']) && $oneTable['avatar'] != '') {
            return $clsISO->tripslashImage($image, $w, $h);
        }
        return $image;
    }

    function isHaveEmail($email = '')
    {
        $all = $this->getAll("email='" . $email . "'");
        if ($all[0]['profile_id'] == '') return false;
        else return true;
    }

    function getIDByEmail($email = '')
    {
        $all = $this->getAll("email='" . $email . "'");
        if ($all[0]['profile_id'] == '') return 0;
        else return $all[0]['profile_id'];
    }

    function getLink($str = '')
    {
        global $clsConfiguration, $_LANG_ID, $extLang, $oneConfiguration;
        switch ($str) {
            case 'signin':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/dang-nhap.html';
                return $extLang . '/account/signin.html';
                break;
            case 'signin_r':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/dang-nhap/';
                return $extLang . '/account/signin/';
                break;
            case 'signup':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/dang-ky.html';
                return $extLang . '/account/signup.html';
                break;
            case 'forgot_pass':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/quen-mat-khau.html';
                return $extLang . '/account/forgot-password.html';
                break;
            case 'change_pass':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/thay-doi-mat-khau.html';
                return $extLang . '/account/change-password.html';
                break;
            case 'reset_pass':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/dat-lai-mat-khau.html';
                return $extLang . '/account/reset-password.html';
                break;
            case 'my_profile':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/thong-tin-tai-khoan.html';
                return $extLang . '/account/profile.html';
                break;
            case 'my_booking':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/booking-cua-toi.html';
                return $extLang . '/account/booking.html';
                break;
            case 'my_wishlist':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/danh-sach-yeu-thich.html';
                return $extLang . '/account/wishlist.html';
                break;
            case 'my_review':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/danh-gia-va-anh.html';
                return $extLang . '/account/reviews-photo.html';
                break;
            case 'my_offer':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/khuyen-mai-cua-toi.html';
                return $extLang . '/account/offers.html';
                break;
            case 'contact_info':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/thong-tin-tai-khoan/thong-tin-lien-he.html';
                return $extLang . '/account/contact-information.html';
                break;
            case 'logout':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/dang-xuat.html';
                return $extLang . '/account/logout.html';
                break;
            case 'contact_info_success':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/tai-khoan/chinh-sua-thong-tin/thanh-cong.html';
                return $extLang . '/account/setting-profile/success.html';
                break;
            default:
                return $clsConfiguration->getValue('site_' . $str . '_link_' . $_LANG_ID);
        }
    }

    function getLinkProfile($profile_id = 0, $type = '')
    {
        if ($profile_id == 0) $profile_id = 1;
        switch ($type) {
            case 'setting':
                return '/setting-profile.html';
                break;
            default:
                return '/profile/' . $profile_id . '.html';
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

    function checkExitsPhone($phone = '')
    {
        return $this->countItem("phone='$phone'") > 0 ? 1 : 0;
    }

    function checkExitsEmail($useremail = '')
    {
        return $this->countItem("email='$useremail'") > 0 ? 1 : 0;
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
        //print_r($_SESSION); die();
        if (isset($_SESSION["logged_id"]) and $_SESSION["logged_id"] != '' && $_SESSION["logged_key"] != '') {
            $all = $this->getAll("is_trash=0 and is_active=1", $this->pkey);
            for ($i = 0; $i < count($all); $i++) {
                $reg = md5($all[$i]["profile_id"] . '-' . ENCRYPTION_KEY);
                if ($_SESSION["logged_id"] === $reg) {
                    $profile_id = $all[$i]['profile_id'];
                    break;
                }
            }
            #
            $userpass = $this->getOneField('userpass', $profile_id);
            if ($_SESSION["logged_key"] == md5($userpass . '-' . ENCRYPTION_KEY))
                return true;
            return false;
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
                $reg = md5($all[$i]["profile_id"] . '-' . ENCRYPTION_KEY);
                //return $reg;
                if ($temp === $reg) {
                    $profile_id = $all[$i]['profile_id'];
                    break;
                }
            }
            return $profile_id;
        } else return 0;
    }

    function userLoggedIn($user_name = '', $user_pass = '_ENCRYPT', $user_pass_encrypt = NULL)
    {
        global $clsISO;
        #
        if (!$this->isLoggedIn()) {
            $encrypt_password = $user_pass_encrypt;
            if ($user_pass != '_ENCRYPT') {
                $encrypt_password = $this->encrypt($user_pass);
            }
            
            $arrProfile = $this->getAll("(username='$user_name' or email='$user_name') and userpass='$encrypt_password' and is_active=1");
            var_dump($user_name);
            var_dump($user_pass);
            var_dump($encrypt_password);
            print_r($arrProfile);
            if (!empty($arrProfile)) {
                $_SESSION["profile_id"] = $arrProfile[0]['profile_id'];
                $_SESSION["logged_id"] = md5($arrProfile[0]["profile_id"] . '-' . ENCRYPTION_KEY);
                $_SESSION["logged_key"] = md5($arrProfile[0]["userpass"] . '-' . ENCRYPTION_KEY);
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
        $profile_id = $_SESSION["logged_id"];
        $all = $this->getAll("is_active='1' and is_verify='1'", $this->pkey);
        if (!empty($all)) {
            for ($i = 0; $i < count($all); $i++) {
                $temp = md5($all[$i]["profile_id"] . '-VIETISO');
                if ($temp == $profile_id) {
                    $profile_id = $all[$i]["profile_id"];
                    break;
                }
            }
        }
        unset($_SESSION["profile_id"]);
        unset($_SESSION["logged_id"]);
        unset($_SESSION["logged_key"]);
        return true;
    }

    function userLoggedInFacebook($args = array(), $is_agent = 0)
    {
        global $_testVersion, $core, $clsISO;
        #
        $email = $args['email'];
        $arrProfile = $this->getAll("facebook_email='$email' and oauth_provider='_FACEBOOK' limit 0,1");
        if ($arrProfile[0]["profile_id"] != '') {
            $profile_id = $arrProfile[0]["profile_id"];
            $_SESSION["profile_id"] = $profile_id;
            $_SESSION["logged_id"] = md5($arrProfile[0]["profile_id"] . '-' . ENCRYPTION_KEY);
            $_SESSION["logged_key"] = md5($arrProfile[0]["userpass"] . '-' . ENCRYPTION_KEY);
            return true;
        } else {
            if ($this->countItem("email='$email' and oauth_provider='_REGSITER'") > 0) {
                return false;
            } elseif ($this->countItem("email='$email' and oauth_provider='_GOOGLE'") > 0) {
                return false;
            } else {
                $tmpInfo = explode('@', $email);
                $username = $tmpInfo[0];
                $lstProfile = $this->getAll("username='$username' limit 0,1");
                if ($lstProfile[0]['profile_id'] != '') {
                    $username = $username . rand(0, 9);
                }
                $avatar = 'http://graph.facebook.com/' . $args['id'] . '/picture';
                $full_name = $args['first_name'] . ' ' . $args['last_name'];
                $full_name_slug = $core->replaceSpace($full_name);
                $password = substr(strtoupper(md5(time() . '-' . ENCRYPTION_KEY)), 0, 8);
                $userpass = $this->encrypt($password);

                #
                $f = "profile_id
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
                $profile_id = $this->getMaxId();
                $v = "
				'" . $profile_id . "',
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
                    $_SESSION["profile_id"] = $profile_id;
                    $_SESSION["logged_id"] = md5($profile_id . '-' . ENCRYPTION_KEY);
                    $_SESSION["logged_key"] = md5($userpass . '-' . ENCRYPTION_KEY);
                    // Send email success
                    if ($is_agent == '2') {
                    } else {
                        $this->sendEmailRegisterMember($profile_id, $userpass);
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
        $arrProfile = $this->getAll("is_active=1 and oauth_provider='_GOOGLE' and google_email='$email' limit 0,1");
        if ($arrProfile[0]["profile_id"] != '') {
            $_SESSION["profile_id"] = $arrProfile['profile_id'];
            $_SESSION["logged_id"] = md5($arrProfile[0]["profile_id"] . '-' . ENCRYPTION_KEY);
            $_SESSION["logged_key"] = md5($arrProfile[0]["userpass"] . '-' . ENCRYPTION_KEY);
            return true;
        } else {
            if ($this->countItem("google_email='$email' and oauth_provider='_FACEBOOK'") > 0) {
                echo 'invalidAccount';
                die();
            }
            $tmpInfo = explode('@', $email);
            $username = $tmpInfo[0];
            $lstProfile = $this->getAll("username='$username' limit 0,1");
            if ($lstProfile[0]['profile_id'] != '') {
                $username = $username . rand(0, 9);
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
            $f = "profile_id
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
            $profile_id = $this->getMaxId();
            $v = "
			'" . $profile_id . "',
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
                $_SESSION["profile_id"] = $profile_id;
                $_SESSION["logged_id"] = md5($profile_id . '-' . ENCRYPTION_KEY);
                $_SESSION["logged_key"] = md5($userpass . '-' . ENCRYPTION_KEY);
                // Send email success
                if ($is_agent == '2') {
                } else {
                    $this->sendEmailRegisterMember($profile_id, $userpass);
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
        $arrProfile = $this->getAll("is_active=1 and username='$username' and oauth_provider='$oauth_provider' limit 0,1");
        if ($arrProfile[0]["profile_id"] != '') {
            $_SESSION["logged_id"] = md5($arrProfile[0]["profile_id"] . '-' . ENCRYPTION_KEY);
            $_SESSION["logged_key"] = md5($arrProfile[0]["userpass"] . '-' . ENCRYPTION_KEY);
            return true;
        } else {
            $lstProfile = $this->getAll("username='$username' limit 0,1");
            if ($lstProfile[0]['profile_id'] != '') {
                $username = $username . rand(0, 9);
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
            $f = "profile_id
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
            $profile_id = $this->getMaxId();
            $v = "
			'" . $profile_id . "',
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
                $_SESSION["logged_id"] = md5($profile_id . '-' . ENCRYPTION_KEY);
                $_SESSION["logged_key"] = md5($userpass . '-' . ENCRYPTION_KEY);
                // Send email success
                $this->sendEMailRegisterSuccess($profile_id);
                return true;
            } else {
                return false;
            }
        }
    }

    function sendEmailRegisterMember($profile_id = 0, $userpass = NULL)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $clsISO, $_LANG_ID, $email_template_signup_id;
        $clsISO = new ISO();
        $clsEmailTemplate = new EmailTemplate();
        header('Content-Type: text/html; charset=utf-8');

        $email_template_id = $email_template_signup_id;

        $oneTable = $this->getOne($profile_id);
        $verification_code = md5($profile_id . '-VietISO');


        $HTML_RGISTER_INFO = '';
        if ($oneTable['oauth_provider'] == '_REGSITER') {
            $HTML_RGISTER_INFO .= '<p>' . $core->get_Lang('Your ID') . ': [%USER_EMAIL%]</p>';
            $HTML_RGISTER_INFO .= '<p>' . $core->get_Lang('Your Password') . ': [%USER_PASS%]</p>';

            $HTML_RGISTER_INFO .= '<p>' . $core->get_Lang('To complete the sign-up process and verify your email address, please click on the following link') . ': [%LINK_VERIFY%] ' . $core->get_Lang('If this link does not work, please copy and paste the URL into your browser window') . '.</p>';
        }

        # Parse Template
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
        $message = str_replace('[%HTML_RGISTER_INFO%]', $HTML_RGISTER_INFO, $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $oneTable['full_name'], $message);
        $message = str_replace('[%USER_EMAIL%]', $oneTable['email'], $message);
        $message = str_replace('[%USER_PASS%]', $userpass, $message);
        if ($_LANG_ID == 'vn') {
            $message = str_replace('[%LINK_VERIFY%]', '<a href="' . PCMS_URL . 'tai-khoan/verify/' . $verification_code . '?utm_source=' . $oneTable['email'] . '">' . PCMS_URL . 'tai-khoan/verify/' . $verification_code . '?utm_source=' . $oneTable['email'] . '</a>', $message);
        } else {
            $message = str_replace('[%LINK_VERIFY%]', '<a href="' . PCMS_URL . 'account/verify/' . $verification_code . '?utm_source=' . $oneTable['email'] . '">' . PCMS_URL . 'account/verify/' . $verification_code . '?utm_source=' . $oneTable['email'] . '</a>', $message);
        }
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

        #Send email to customer
        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        $to = trim($oneTable['email']);
        $owner = PAGE_NAME;
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
        $this->updateOne($profile_id, "verified_email='$to'");
        return 1;
    }

    function sendEMailRegisterSuccess($profile_id = 0)
    {
        global $clsISO;
        $clsISO = new ISO();

        $oneItem = $this->getOne($profile_id);
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

    function sendEMailForgotPasswordSuccess($profile_id = 0)
    {
        global $clsISO;
        $clsISO = new ISO();
        $clsDistrict = new District();

        $oneItem = $this->getOne($profile_id);
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

    function sendEMailResetPasswordSuccess($profile_id = 0)
    {
        global $clsISO;
        $clsISO = new ISO();

        $oneItem = $this->getOne($profile_id);

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

    function sendEmailChangePassword($profile_id = 0, $password = '')
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $_LANG_ID, $email_template_change_pass_id;
        #
        $clsEmailTemplate = new EmailTemplate();
        $oneItem = $this->getOne($profile_id);

        $email_template_id = $email_template_change_pass_id;

        # Parse Template
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
        $message = str_replace('[%CUSTOMER_NAME%]', $this->getFullname($profile_id), $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $this->getFullname($profile_id), $message);
        $message = str_replace('[%ACCOUNT%]', $this->getEmail($profile_id), $message);
        $message = str_replace('[%NEW_PASSWORD%]', '<b>' . $password . '</b>', $message);

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

        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        #Send email to customer
        $to = trim($this->getEmail($profile_id));
        $owner = PAGE_NAME;
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $clsISO->sendEmail($from, $to, $subject, $message, $owner);
        return 1;
    }


    function sendEmailForgetPassword($profile_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_lang, $_LANG_ID, $email_template_reset_pass_id;
        #
        $clsEmailTemplate = new EmailTemplate();
        $oneItem = $this->getOne($profile_id);

        $email_template_id = $email_template_reset_pass_id;
        # Parse Template
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
        $message = str_replace('[%CUSTOMER_NAME%]', $this->getUsername($profile_id), $message);
        $message = str_replace('[%CUSTOMER_FULL_NAME%]', $this->getFullname($profile_id), $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $this->getFullname($profile_id), $message);
        if ($_LANG_ID == 'vn') {
            $message = str_replace('[%LINK_RESET%]', PCMS_URL . $extLang . 'tai-khoan/dat-lai-mat-khau/' . md5($profile_id . 'VietISO'), $message);
        } else {
            $message = str_replace('[%LINK_RESET%]', PCMS_URL . $extLang . 'account/reset-password/' . md5($profile_id . 'VietISO'), $message);
        }


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

        //print_r($message);die();
        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        #Send email to customer
        $to = trim($oneItem['email']);
        $owner = PAGE_NAME;
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $clsISO->sendEmail($from, $to, $subject, $message, $owner);
        return 1;
    }

    function doDelete($pvalTable = 0)
    {
        $clsISO = new ISO();
        $clsCityStore = new CityStore();
        #
        $image = $this->getOneField("image", $pvalTable);
        if (trim($image) != '') {
            if ($clsISO->checkContainer($image, DOMAIN_NAME)) {
                $image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
                $clsISO->deleteFile($image);
                $image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
                $clsISO->deleteFile($image);
            }
        }
        #
        $this->deleteOne($pvalTable);
        $clsCityStore->deleteByCond("region_id='$pvalTable' and type='REGION'");
        return 1;
    }
}
