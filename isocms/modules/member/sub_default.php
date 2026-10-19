<?php
function default_default()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #
    $profile_id_view = $profile_id;
    $assign_list["profile_id_view"] = $profile_id_view;
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
    $oneProfileView = $clsProfile->getOne($profile_id_view);
    $assign_list["oneProfileView"] = $oneProfileView;
    /*=============Title & Description Page==================*/
    $title_page = 'Trang thành viên';
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_success()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsConfiguration;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list["show"] = $show;

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Register member success') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function _parseName($name)
{
    $tmp = preg_split('/\s/', $name);
    $last_name = $tmp[count($tmp) - 1];
    unset($tmp[count($tmp) - 1]);
    $first_name = implode(' ', $tmp);
    return array(
        0 => $first_name,
        1 => $last_name
    );
}
if (!function_exists('getFacebookOAuthData')) {
    function getFacebookOAuthData($returnUrl = '')
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }

        if (empty($_SESSION['facebook_oauth_state'])) {
            try {
                $_SESSION['facebook_oauth_state'] =
                    bin2hex(random_bytes(24));
            } catch (Throwable $exception) {
                $_SESSION['facebook_oauth_state'] =
                    hash('sha256', uniqid('', true));
            }
        }

        $state = $_SESSION['facebook_oauth_state'];

        $_SESSION['facebook_return_url'] =
            is_scalar($returnUrl)
                ? trim((string)$returnUrl)
                : '';

        $loginUrl = '';

        if (
            defined('appID')
            && trim((string)appID) !== ''
        ) {
            /*
             * Không phụ thuộc homeUrl vì constant này có thể đang sai
             * hoặc chứa URL callback cũ.
             */
            $redirectUri =
                rtrim(DOMAIN_NAME, '/')
                . '/facebook2callback';

            $params = [
                'client_id' => trim((string)appID),
                'redirect_uri' => $redirectUri,
                'state' => $state,
                'scope' => 'email,public_profile',
                'response_type' => 'code'
            ];

            $loginUrl =
                'https://www.facebook.com/v20.0/dialog/oauth?'
                . http_build_query(
                    $params,
                    '',
                    '&',
                    PHP_QUERY_RFC3986
                );
        }

        return [
            'state' => $state,
            'redirect_uri' =>
                rtrim(DOMAIN_NAME, '/')
                . '/facebook2callback',
            'login_url' => $loginUrl
        ];
    }
}
function default_signup()
{
    global $assign_list, $extLang, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    $clsProfile = new Profile();
    $clsISO = new ISO();
    if ($clsProfile->isLoggedIn()) {
        header('Location:' . $clsProfile->getLink('my_profile'));
        exit();
    }
    $msgSubmitForm = '';
    $valid = true;
    if (isset($_POST['hid_reg']) && $_POST['hid_reg'] == 'hid_reg') {
        $fullname = trim($_POST['username']);
        $useremail = trim($_POST['useremail']);
        $userpass = trim($_POST['userpass']);
        $confirmpass = trim($_POST['confirmpass']);
        $security_code = trim($_POST['security_code']);
        $tccheck = $_POST['tccheck'];
        $agent = $_POST['agent'];

        if ($fullname == '') {
            $msgSubmitForm .= '&bull;' . $core->get_Lang("Username is request!") . '<br>';
            $valid = false;
        }
        if ($useremail == '') {
            $msgSubmitForm .= '&bull;' . $core->get_Lang("Email is request!") . '<br>';
            $valid = false;
        }
        if ($useremail != '' && !$clsProfile->checkValidEmail($useremail)) {
            $msgSubmitForm .= '&bull;' . $core->get_Lang("Email format is incorrect!") . '<br>';
            $valid = false;
        }
        if ($useremail != '' && $clsProfile->checkExitsEmail($_POST['useremail']) == 1) {
            $msgSubmitForm .= '&bull;' . $core->get_Lang("There is already a user with that email address!") . '<br>';
            $valid = false;
        }
        if ($userpass == '' || $confirmpass == '') {
            $msgSubmitForm .= '&bull;' . $core->get_Lang("Password or password confirmation is request!") . '<br>';
            $valid = false;
        }
        if ($userpass !== $confirmpass) {
            $msgSubmitForm .= '&bull;' . $core->get_Lang("Confirm password do not match!") . '<br>';
            $valid = false;
        }
        if ($security_code == '') {
            $msgSubmitForm .= '&bull;' . $core->get_Lang("Secure code is request!") . '<br>';
            $valid = false;
        }
        if ($security_code != '') {
            $security_code = strtoupper($security_code);
            if (!empty($security_code) && $security_code === vnSessionGetVar('skey')) {
                $msgSubmitForm .= '&bull;' . $core->get_Lang("5 characters entered incorrectly. Please re-enter!") . '<br>';
                $valid = false;
            }
        }

        foreach ($_POST as $key => $val) {
            $assign_list[$key] = $val;
        }
        //print_r($msgSubmitForm); die();
        if ($valid) {
            $f = "profile_id,full_name,full_name_slug,first_name,last_name,email,username,userpass,ip_register,reg_date,oauth_provider,is_agent";
            #
            $profile_id = $clsProfile->getMaxId();
            $encrypt_pass = $clsProfile->encrypt($userpass);
            $tmp = _parseName($fullname);
            $first_name = $tmp[0];
            $last_name = $tmp[1];

            $v = "'$profile_id'
			,'" . addslashes($fullname) . "'
			,'" . addslashes($core->replaceSpace($fullname)) . "'
			,'$first_name'
			,'$last_name'
			,'" . addslashes($useremail) . "'
			,'" . addslashes($useremail) . "'
			,'" . addslashes($encrypt_pass) . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . time() . "'
			,'_REGSITER'
			,'" . $agent . "'";
            if ($clsProfile->insertOne($f, $v)) {
                if ($agent == '2') {

                    vnSessionSetVar('profile_id', $profile_id);
                    vnSessionSetVar('userpass', trim($_POST['userpass']));
                    header('Location:' . DOMAIN_NAME . $extLang . '/account/agent-signup.html');
                    exit();
                } else {
                    $clsProfile->sendEmailRegisterMember($profile_id, $userpass);
                    $clsProfile->userLoggedIn($useremail, $userpass);
                    if ($tccheck && class_exists('Subscribe')) {
                        $clsSubscribe = new Subscribe();
                        if ($clsSubscribe->countItem("email='$useremail'") == 0) {
                            $f_1 = "subscribe_id,fullname,email,user_ip,reg_date,receive_newsletter";
                            $v_1 = "'" . $clsSubscribe->getMaxId() . "'
							,'" . addslashes($fullname) . "'
							,'" . addslashes($useremail) . "'
							,'" . $_SERVER['REMOTE_ADDR'] . "'
							,'" . time() . "'
							,'1'";
                            $clsSubscribe->insertOne($f_1, $v_1);
                            $clsSubscribe->sendMail($clsSubscribe->getMaxId());
                        }
                    }

                    header('Location:' . DOMAIN_NAME . $extLang . '/account/signup-success.html');
                    exit();
                }
            } else {
                $msgSubmitForm .= '&bull; Suspension of registration system to upgrade!<br>';
                $assign_list["msgSubmitForm"] = $msgSubmitForm;
            }
        }
    }

    //print_r($msgSubmitForm); die();
    /*=============Content Page==================*/
    $title_page = $core->get_Lang('Register member account') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}
function default_signup3_new()
{
    global $assign_list, $extLang, $_CONFIG, $core, $dbconn;
    global $mod, $act, $_LANG_ID, $clsISO;
    global $title_page, $description_page;
    global $keyword_page, $profile_id;
    header('Location: /');
    $clsProfile = new Profile();

    if ($clsProfile->isLoggedIn()) {
        header(
            'Location: '
            . $clsProfile->getLink('my_profile')
        );
        exit();
    }

    $returnUrl = isset($_GET['return_url'])
        && !is_array($_GET['return_url'])
            ? trim((string)$_GET['return_url'])
            : $extLang;

    /*
     * Chặn redirect ra domain ngoài.
     */
    if (
        $returnUrl !== ''
        && preg_match('#^https?://#i', $returnUrl)
    ) {
        $returnHost = parse_url(
            $returnUrl,
            PHP_URL_HOST
        );

        $siteHost = parse_url(
            DOMAIN_NAME,
            PHP_URL_HOST
        );

        if ($returnHost !== $siteHost) {
            $returnUrl = $extLang;
        }
    }

    $facebookOAuth = getFacebookOAuthData($returnUrl);

    $assign_list['facebookLoginUrl'] =
        $facebookOAuth['login_url'];

    /* Google */
    $googleLoginUrl = '';

    if (
        defined('GoogleID')
        && trim((string)GoogleID) !== ''
    ) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }

        if (empty($_SESSION['google_oauth_state'])) {
            try {
                $_SESSION['google_oauth_state'] =
                    bin2hex(random_bytes(24));
            } catch (Throwable $exception) {
                $_SESSION['google_oauth_state'] =
                    hash('sha256', uniqid('', true));
            }
        }

        $_SESSION['google_return_url'] = $returnUrl;

        $googleRedirectUri =
            rtrim(DOMAIN_NAME, '/')
            . '/oauth2callback';

        $googleLoginUrl =
            'https://accounts.google.com/o/oauth2/v2/auth?'
            . http_build_query(
                [
                    'client_id' => trim((string)GoogleID),
                    'redirect_uri' => $googleRedirectUri,
                    'response_type' => 'code',
                    'scope' => 'openid email profile',
                    'state' =>
                        $_SESSION['google_oauth_state'],
                    'access_type' => 'online',
                    'include_granted_scopes' => 'true',
                    'prompt' => 'select_account'
                ],
                '',
                '&',
                PHP_QUERY_RFC3986
            );
    }

    $assign_list['googleLoginUrl'] =
        $googleLoginUrl;

    /*
     * Chưa có backend Apple thì không hiển thị.
     */
    $assign_list['appleLoginUrl'] = '';

    $title_page =
        $core->get_Lang('Sign up')
        . ' | '
        . PAGE_NAME;

    $assign_list['title_page'] = $title_page;
    $assign_list['description_page'] = $title_page;
    $assign_list['keyword_page'] = $title_page;
}

function default_ajSignup_new()
{
    global $assign_list, $extLang, $_CONFIG, $core, $dbconn;
    global $mod, $act, $_LANG_ID, $clsISO;
    global $title_page, $description_page, $keyword_page, $profile_id;

    $clsProfile = new Profile();

    if ($clsProfile->isLoggedIn()) {
        echo '_ALREADY_LOGGED_IN';
        exit();
    }

    if (
        !isset($_POST['submit'])
        || $_POST['submit'] !== 'SignUp'
    ) {
        echo '_INVALID_REQUEST';
        exit();
    }

    $fullname = isset($_POST['full_name']) && !is_array($_POST['full_name'])
        ? trim(strip_tags((string)$_POST['full_name']))
        : '';

    /*
     * Tương thích form cũ dùng username.
     */
    if (
        $fullname === ''
        && isset($_POST['username'])
        && !is_array($_POST['username'])
    ) {
        $fullname = trim(strip_tags((string)$_POST['username']));
    }

    $useremail = isset($_POST['email']) && !is_array($_POST['email'])
        ? strtolower(trim((string)$_POST['email']))
        : '';

    $userpass = isset($_POST['userpass']) && !is_array($_POST['userpass'])
        ? (string)$_POST['userpass']
        : '';

    if ($fullname === '') {
        echo '_FULLNAME_EMPTY';
        exit();
    }

    if (
        $useremail === ''
        || !filter_var($useremail, FILTER_VALIDATE_EMAIL)
    ) {
        echo '_EMAIL_INVALID';
        exit();
    }

    if (strlen($userpass) < 8) {
        echo '_PASSWORD_INVALID';
        exit();
    }

    if (!$clsISO->checkGoogleReCAPTCHA()) {
        echo '_CAPTCHA_NOT_CHECK';
        exit();
    }

    if ($clsProfile->checkExitsEmail($useremail) == 1) {
        echo '_EMAIL_EXITS';
        exit();
    }

    $nameParts = _parseName($fullname);

    $firstName = isset($nameParts[0])
        ? trim((string)$nameParts[0])
        : '';

    $lastName = isset($nameParts[1])
        ? trim((string)$nameParts[1])
        : '';

    $profile_id = (int)$clsProfile->getMaxId();
    $encryptPass = $clsProfile->encrypt($userpass);
    $now = time();

    $remoteIp = isset($_SERVER['REMOTE_ADDR'])
        ? trim((string)$_SERVER['REMOTE_ADDR'])
        : '';

    $fields = implode(',', [
        'profile_id',
        'full_name',
        'full_name_slug',
        'first_name',
        'last_name',
        'email',
        'username',
        'userpass',
        'ip_register',
        'reg_date',
        'oauth_provider'
    ]);

    $values = "'{$profile_id}'"
        . ",'" . addslashes($fullname) . "'"
        . ",'" . addslashes($core->replaceSpace($fullname)) . "'"
        . ",'" . addslashes($firstName) . "'"
        . ",'" . addslashes($lastName) . "'"
        . ",'" . addslashes($useremail) . "'"
        . ",'" . addslashes($useremail) . "'"
        . ",'" . addslashes($encryptPass) . "'"
        . ",'" . addslashes($remoteIp) . "'"
        . ",'{$now}'"
        . ",'_REGSITER'";

    if (!$clsProfile->insertOne($fields, $values)) {
        echo '_SIGNUP_ERROR';
        exit();
    }

    $clsProfile->sendEmailRegisterMember(
        $profile_id,
        $userpass
    );

    $clsProfile->userLoggedIn(
        $useremail,
        $userpass
    );

    echo '_SIGNUP_SUCCESS';
    exit();
}

function default_signup2()
{
    global $assign_list, $extLang, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $clsISO, $title_page, $description_page, $keyword_page, $profile_id;

    $clsProfile = new Profile();
    if ($clsProfile->isLoggedIn()) {
        header('Location:' . $clsProfile->getLink('my_profile'));
        exit();
    }

    //print_r($msgSubmitForm); die();
    /*=============Content Page==================*/
    $title_page = $core->get_Lang('Sign up') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_ajSignup()
{
    global $assign_list, $extLang, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $clsISO, $title_page, $description_page, $keyword_page, $profile_id;

    $clsProfile = new Profile();
    if ($clsProfile->isLoggedIn()) {
        header('Location:' . $clsProfile->getLink('my_profile'));
        exit();
    }
    $msgSubmitForm = '';
    $valid = true;
    if (isset($_POST['submit']) && $_POST['submit'] == 'SignUp') {
        $fullname = trim($_POST['username']);
        $useremail = trim($_POST['useremail']);
        $userpass = trim($_POST['userpass']);

        if (!$clsISO->checkGoogleReCAPTCHA()) {
            echo '_CAPTCHA_NOT_CHECK';
            die();
        }

        if ($clsProfile->checkExitsEmail($_POST['useremail']) == 1) {
            echo '_EMAIL_EXITS';
            die();
        }

        foreach ($_POST as $key => $val) {
            $assign_list[$key] = $val;
        }
        if ($valid) {
            $f = "profile_id,full_name,full_name_slug,first_name,last_name,email,username,userpass,ip_register,reg_date,oauth_provider";
            #
            $profile_id = $clsProfile->getMaxId();
            $encrypt_pass = $clsProfile->encrypt($userpass);
            $tmp = _parseName($fullname);
            $first_name = $tmp[0];
            $last_name = $tmp[1];

            $v = "'$profile_id'
			,'" . addslashes($fullname) . "'
			,'" . addslashes($core->replaceSpace($fullname)) . "'
			,'$first_name'
			,'$last_name'
			,'" . addslashes($useremail) . "'
			,'" . addslashes($useremail) . "'
			,'" . addslashes($encrypt_pass) . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . time() . "'
			,'_REGSITER'";

            if ($clsProfile->insertOne($f, $v)) {
                $clsProfile->sendEmailRegisterMember($profile_id, $userpass);
                $clsProfile->userLoggedIn($useremail, $userpass);
                echo '_SIGNUP_SUCCESS';
                die();
            } else {
                echo '_SIGNUP_ERROR';
                die();
            }
        }
    }
}

function default_signup_agent()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    $clsProfile = new Profile();
    $clsISO = new ISO();
    #
    if ($profile_id == '') {
        $profile_id = vnSessionGetVar('profile_id');
    }

    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;

    if (!empty($profile_id)) {
        $oneProfile = $clsProfile->getOne($profile_id);
        $assign_list["oneProfile"] = $oneProfile;
    }

    if (isset($_POST['submitAgent']) && $_POST['submitAgent'] == 'submitAgent') {
        $value = '';
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        if ($clsProfile->updateOne($profile_id, $value)) {
            $assign_list["msg"] = 'You are update successfully!';
            $userpass = vnSessionGetVar('userpass');
            $clsProfile->sendEmailRegisterMember($profile_id, $userpass);
            header('location:' . $clsISO->getLink('setting_success'));
            vnSessionDelVar('userpass');
        } else {
            die('Error');
        }
    }
    //print_r($msgSubmitForm); die();
    /*=============Content Page==================*/
    $title_page = 'Register member account | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}


function default_register()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #
    $arrData = array('ok' => true, 'message' => '', 'error' => '', 'result' => '', 'urlLoad' => '');
    $clsProfile = new Profile();
    $assign_list["html_captcha"] = $clsProfile->generateHtmlSpam();
    $msgSubmitForm = '';

    if (isset($_POST['hid_reg']) && $_POST['hid_reg'] == 'hid_reg') {

        if ($clsProfile->checkValidEmail($_POST['useremail']) != 1) {
            $msgSubmitForm .= '&bull; Email format is incorrect!<br>';
        }
        if ($clsProfile->checkExitsEmail($_POST['useremail']) == 1) {
            $msgSubmitForm .= '&bull; There is already a user with that email address!<br>';
        }
        if ($_POST['username'] == '') {
            $msgSubmitForm .= '&bull; Username is request!<br>';
        }
        if ($_POST['userpass'] == '') {
            $msgSubmitForm .= '&bull; Password is request!<br>';
        }
        if ($_POST['confirmpass'] == '') {
            $msgSubmitForm .= '&bull; Unknown password confirmation!<br>';
        }
        if ($_POST['userpass'] != $_POST['confirmpass']) {
            $msgSubmitForm .= '&bull; Confirm password do not match!<br>';
        }
        if ($clsProfile->checkValidUsername($_POST['username']) == 1) {
            $msgSubmitForm .= '&bull; Username already exists. Please choose another name!<br>';
        }
        /*if ($_SESSION['skey']!=strtoupper(addslashes($_POST['security_code']))){
            $msgSubmitForm .= '&bull; 5 characters entered incorrectly. Please re-enter!<br>';
        }*/
        $email = $_POST['useremail'];
        $pass = $_POST['userpass'];
        $one = $clsProfile->getAll("is_trash=0 and email='$email' order by profile_id desc limit 0,1");
        if (isset($one[0])) {
            $arrData['ok'] = false;
            $arrData['error'] = 'Email exits';
        }
        if ($_POST['tccheck'] != '1') {
            $msgSubmitForm .= '&bull; Please read and accept the terms!<br>';
        }
        foreach ($_POST as $key => $val) {
            $assign_list[$key] = $val;
        }

        if ($msgSubmitForm == '') {
            $f = "email,username,userpass,ip_register,reg_date";
            $v = "'" . addslashes($_POST['useremail']) . "'";
            $v .= ",'" . addslashes($_POST['username']) . "'";
            $userpass = $clsProfile->encrypt($_POST['userpass']);
            $v .= ",'" . addslashes($userpass) . "'";
            $v .= ",'" . $_SERVER['REMOTE_ADDR'] . "'";
            $v .= ",'" . time() . "'";

            if ($clsProfile->insertOne($f, $v)) {
                $info = $clsProfile->userLoggedIn($_POST['useremail'], $_POST['userpass']);
                $email = addslashes($_POST['useremail']);
                $one = $clsProfile->getAll("is_trash=0 and email='$email' order by profile_id desc limit 0,1");
                $clsProfile->sendEmailRegisterMember($one[0]['profile_id'], $pass);
                $arrData['ok'] = true;
                $arrData['message'] = 'Success';

                //header('location: '.PCMS_URL.'account/register-success.html');
                ///exit();
            } else {
                $msgSubmitForm .= '&bull; Suspension of registration system to upgrade!<br>';
            }
        }
    }
    $assign_list["msgSubmitForm"] = $msgSubmitForm;
    echo json_encode($arrData);
    die();
    #
    $title_page = 'Register member account of Vietnamtourism.org.vn';
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_verify()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsUser, $_frontIsLoggedin_user_id, $profile_id;
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;


    $is_agent = isset($_GET["agent"]) ? $_GET["agent"] : 0;

    $hash = isset($_GET['hash']) && !empty($_GET['hash']) ? trim($_GET['hash']) : '';
    $utm_source = $_GET['utm_source'];

    if ($clsProfile->isLoggedIn()) {
        header('Location:' . $clsProfile->getLink('my_profile'));
        exit();
    }
    #

    $lstProfile = $clsProfile->getAll("is_trash=0", $clsProfile->pkey);
    if (!empty($lstProfile)) {
        for ($i = 0; $i < count($lstProfile); $i++) {
            if ($hash == md5($lstProfile[$i]['profile_id'] . '-VietISO')) {
                $profile_id = $lstProfile[$i]['profile_id'];
                break;
            }
        }
    }

    if (intval($profile_id) > 0 && $clsProfile->getOneField('verified_email', $profile_id) === $utm_source) {
        if (!$clsProfile->getOneField('is_verify', $profile_id)) {
            $clsProfile->updateOne($profile_id, "is_verify='1',is_active='1',upd_date='" . time() . "'");
            $username = $clsProfile->getOneField('username', $profile_id);
            $userpass = $clsProfile->getOneField('userpass', $profile_id);
            // Login
            $clsProfile->userLoggedIn($username, '_ENCRYPT', $userpass);
        }
        header('Location: ' . $clsProfile->getLink('my_profile'));
    } else {
        header('Location: ' . DOMAIN_NAME . $extLang . '#not-permission');
    }
}

function default_signin()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id, $extLang;
    $clsProfile = new Profile();
    #
    if ($clsProfile->isLoggedIn()) {
        header("location:" . $clsProfile->getLink('my_profile'));
        exit();
    }

    #
    $return_url = isset($_GET['return_url']) ? $_GET['return_url'] : '';
    $msgSubmitForm = '';
    if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
        $USER = $_POST['USER'];
        $PASSWORD = $_POST['PASSWORD'];
        if ($clsProfile->userLoggedIn($USER, $PASSWORD)) {
            header("location:" . DOMAIN_NAME . $return_url);
            exit();
        } else {
            $msgSubmitForm .= $core->get_Lang('Login failed!');
        }
        foreach ($_POST as $key => $val) {
            $assign_list[$key] = $val;
        }
    }
    $assign_list["msgSubmitForm"] = $msgSubmitForm;
    /*=============Content Page==================*/
    $title_page = $core->get_Lang('Sign in') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_ajSignin_new()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    $clsProfile = new Profile();

    $USER = isset($_POST['USER']) ? $_POST['USER'] : '';
    $PASSWORD = isset($_POST['PASSWORD']) ? $_POST['PASSWORD'] : '';
    $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '';
    if (isset($_POST['submit']) && $_POST['submit'] === 'Login') {
        if (!empty($USER) && !empty($PASSWORD)) {
            if ($clsProfile->userLoggedIn($USER, $PASSWORD)) {
                echo '_LOGIN_SUCCESS';
                die();
            } else {
                echo '_LOGIN_ERROR';
                die();
            }
        } else {
            echo '_LOGIN_ERROR';
            die();
        }
    } else {
        echo '_LOGIN_ERROR';
        die();
    }
}


function default_ajSignin()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    $clsProfile = new Profile();
    #
    $USER = isset($_POST['USER']) ? $_POST['USER'] : '';
    $PASSWORD = isset($_POST['PASSWORD']) ? $_POST['PASSWORD'] : '';
    $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '';

    if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
        if ($clsProfile->userLoggedIn($USER, $PASSWORD)) {
            echo '_LOGIN_SUCCESS';
            die();
        } else {
            echo '_LOGIN_ERROR';
            die();
        }
    } else {
        echo '_LOGIN_ERROR';
        die();
    }
}

function default_signinGoogle()
{
    global $core, $clsISO, $oneSetting, $_frontIsLoggedin_user_id;
    global $_lang, $extLang, $clsSetting;

    $clsProfile = new Profile();
    #
    $email = Input::post('email', "");
    $_id = (int)Input::post('id', 0);
    $full_name = Input::post('full_name');
    $avatar = Input::post('avatar');
    $family_name = Input::post('family_name');
    $given_name = Input::post('given_name');
    $gender = Input::post('gender');
    $verified_email = Input::post('verified_email');
    $hd = Input::post('hd');
    $link = Input::post('link');


    $result = array(
        'id' => $_id,
        'hd' => $hd,
        'link' => $link,
        'email' => $email,
        'avatar' => $avatar,
        'gender' => $gender,
        'full_name' => $full_name,
        'family_name' => $family_name,
        'given_name' => $given_name,
        'verified_email' => $verified_email
    );

    $clsVietISOSDK = new VietISOSDK2();
    $response = $clsVietISOSDK->doInApp('post', 'member/google_login', json_encode($result));
    $response = json_decode($response, true);
    $potential_id = $response['potential_id'];
    if ($response['result'] == 'success') {
        $_SESSION["logged_in"] = 1;
        $_SESSION["potential_id"] = $potential_id;
        $_SESSION["logged_id"] = isoencrypt($potential_id);
        $_SESSION[]["logged_key"] = md5($response["userpass"] . '-' . ENCRYPTION_KEY);
        echo 'success';
        die();
    } elseif ($response['result'] == 'google_insert_success') {
        $_SESSION["logged_in"] = 1;
        $_SESSION["potential_id"] = $potential_id;
        $_SESSION["logged_id"] = isoencrypt($potential_id);
        $_SESSION["logged_key"] = md5($response["userpass"] . '-' . ENCRYPTION_KEY);
        echo 'success';
        die();
    } elseif ($response['result'] == 'invalidAccount') {
        echo 'invalidAccount';
        die();
    } else {
        echo '_invalid';
        die();
    }
}

function default_signinFacebook()
{
    global $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $clsISO;
    $clsProfile = new Profile();
    #
    $fbAT = Input::post('fbAT', "");
    $fbUser = Input::post('fbUser', "");


    $result = array(
        'is_agent' => 0,
        'id' => $fbUser['id'],
        'first_name' => $fbUser['first_name'],
        'last_name' => $fbUser['last_name'],
        'email' => $fbUser['email'],
    );

    $clsVietISOSDK = new VietISOSDK2();
    $response = $clsVietISOSDK->doInApp('post', 'member/facebook_login', json_encode($result));
    $response = json_decode($response, true);
    //print_r($response); die();
    $profile_id = $response['profile_id'];
    if ($response['result'] == 'success') {
        $_SESSION["logged_in"] = 1;
        $_SESSION["profile_id"] = $profile_id;
        $_SESSION["logged_id"] = isoencrypt($profile_id);
        $_SESSION[]["logged_key"] = md5($response["userpass"] . '-' . ENCRYPTION_KEY);
        echo 'success';
        die();
    } elseif ($response['result'] == 'facebook_insert_success') {
        $_SESSION["logged_in"] = 1;
        $_SESSION["profile_id"] = $profile_id;
        $_SESSION["logged_id"] = isoencrypt($profile_id);
        $_SESSION["logged_key"] = md5($response["userpass"] . '-' . ENCRYPTION_KEY);
        echo 'success';
        die();
    } elseif ($response['result'] == 'invalidAccount') {
        echo 'invalidAccount';
        die();
    } else {
        echo '_invalid';
        die();
    }
}

function default_signin4_new()
{
    global $assign_list, $_CONFIG, $core, $dbconn;
    global $mod, $act, $_LANG_ID;
    global $title_page, $description_page;
    global $keyword_page, $profile_id, $extLang;
    header('Location: /');
    $clsProfile = new Profile();

    if ($clsProfile->isLoggedIn()) {
        header(
            'Location: '
            . $clsProfile->getLink('my_profile')
        );
        exit();
    }

    $returnUrl = isset($_GET['return_url'])
        && !is_array($_GET['return_url'])
            ? trim((string)$_GET['return_url'])
            : '';

    if (
        $returnUrl !== ''
        && preg_match('#^https?://#i', $returnUrl)
    ) {
        $returnHost = parse_url(
            $returnUrl,
            PHP_URL_HOST
        );

        $siteHost = parse_url(
            DOMAIN_NAME,
            PHP_URL_HOST
        );

        if ($returnHost !== $siteHost) {
            $returnUrl = '';
        }
    }

    $assign_list['return_url'] = $returnUrl;

    $facebookOAuth = getFacebookOAuthData($returnUrl);

    $assign_list['facebookLoginUrl'] =
        $facebookOAuth['login_url'];

    /* Google */
    $googleLoginUrl = '';

    if (
        defined('GoogleID')
        && trim((string)GoogleID) !== ''
    ) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }

        if (empty($_SESSION['google_oauth_state'])) {
            try {
                $_SESSION['google_oauth_state'] =
                    bin2hex(random_bytes(24));
            } catch (Throwable $exception) {
                $_SESSION['google_oauth_state'] =
                    hash('sha256', uniqid('', true));
            }
        }

        $_SESSION['google_return_url'] = $returnUrl;

        $googleRedirectUri =
            rtrim(DOMAIN_NAME, '/')
            . '/oauth2callback';

        $googleLoginUrl =
            'https://accounts.google.com/o/oauth2/v2/auth?'
            . http_build_query(
                [
                    'client_id' => trim((string)GoogleID),
                    'redirect_uri' => $googleRedirectUri,
                    'response_type' => 'code',
                    'scope' => 'openid email profile',
                    'state' =>
                        $_SESSION['google_oauth_state'],
                    'prompt' => 'select_account'
                ],
                '',
                '&',
                PHP_QUERY_RFC3986
            );
    }

    $assign_list['googleLoginUrl'] =
        $googleLoginUrl;

    $msgSubmitForm = '';

    if (
        isset($_POST['submit'])
        && $_POST['submit'] === 'Login'
    ) {
        $user = isset($_POST['USER'])
            && !is_array($_POST['USER'])
                ? trim((string)$_POST['USER'])
                : '';

        $password = isset($_POST['PASSWORD'])
            && !is_array($_POST['PASSWORD'])
                ? (string)$_POST['PASSWORD']
                : '';

        if ($clsProfile->userLoggedIn($user, $password)) {
            $redirectUrl = $returnUrl !== ''
                ? $returnUrl
                : DOMAIN_NAME . $extLang;

            header('Location: ' . $redirectUrl);
            exit();
        }

        $msgSubmitForm =
            $core->get_Lang('Login failed!');

        $assign_list['USER'] = $user;
    }

    $assign_list['msgSubmitForm'] =
        $msgSubmitForm;

    $title_page =
        $core->get_Lang('Sign in')
        . ' | '
        . PAGE_NAME;

    $assign_list['title_page'] = $title_page;
    $assign_list['description_page'] = $title_page;
    $assign_list['keyword_page'] = $title_page;
}


function default_signin3()
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_STRICT); //E_ALL
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    $clsProfile = new Profile();

    #
    if ($clsProfile->isLoggedIn()) {
        header("location:" . $clsProfile->getLink('my_profile'));
        exit();
    }
    #

    $return_url = isset($_GET['return_url']) ? $_GET['return_url'] : '';
    $msgSubmitForm = '';
    if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
        $USER = $_POST['USER'];
        $PASSWORD = $_POST['PASSWORD'];
        if ($clsProfile->userLoggedIn($USER, $PASSWORD)) {
            header("location:" . DOMAIN_NAME . $return_url);
            exit();
        } else {
            $msgSubmitForm .= $core->get_Lang('Login failed!') . '<br>';
        }
        foreach ($_POST as $key => $val) {
            $assign_list[$key] = $val;
        }
    }
    $assign_list["msgSubmitForm"] = $msgSubmitForm;
    /*=============Content Page==================*/
    $title_page = $core->get_Lang('Sign in') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_signin2()
{
    ini_set('display_errors', 0);
    error_reporting(E_ALL & ~E_STRICT); //E_ALL
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    $clsProfile = new Profile();
    #
    if ($clsProfile->isLoggedIn()) {
        header("location:" . $clsProfile->getLink('my_profile'));
        exit();
    }
    #

    $return_url = isset($_GET['return_url']) ? $_GET['return_url'] : '';
    $msgSubmitForm = '';
    if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
        $USER = $_POST['USER'];
        $PASSWORD = $_POST['PASSWORD'];
        if ($clsProfile->userLoggedIn($USER, $PASSWORD)) {
            header("location:" . DOMAIN_NAME . $return_url);
            exit();
        } else {
            $msgSubmitForm .= $core->get_Lang('Login failed!') . '<br>';
        }
        foreach ($_POST as $key => $val) {
            $assign_list[$key] = $val;
        }
    }
    $assign_list["msgSubmitForm"] = $msgSubmitForm;
    /*=============Content Page==================*/
    $title_page = $core->get_Lang('Sign in') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_signinBy()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #
    require_once(DIR_MODULES . '/member/classes/TwitterOAuth.php');
    require_once(DIR_MODULES . '/member/classes/facebook.php');
    require_once(DIR_MODULES . '/member/classes/fbconfig.php');
    $oauth_provider = $_GET['oauth_provider'];
    if ($oauth_provider == 'twitter') {
        header("location:https://twitter.com/oauth/authenticate?oauth_token=2L8NCMlPiivw4fkIfF2feWkj5EqH5UvZzvFfqK50Cc");
    } else if ($oauth_provider == 'facebook') {
        header("location: login-facebook.php");
    }
    #
}

function default_logout()
{
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    global $facebook;
    $clsProfile = new Profile();
    #
    $clsProfile->userDoLogout();
    if ($clsProfile->getOneField('oauth_provider', $profile_id) == '_FACEBOOK') {
        //session_destroy();
        unset($_SESSION['userdata']);
        vnSessionDelVar('userdata');
    } else if ($clsProfile->getOneField('oauth_provider', $profile_id) == '_GOOGLE') {
        unset($_SESSION['token']);
        unset($_SESSION['google_data']);
        //Google session data unset
        vnSessionDelVar('token');
        vnSessionDelVar('google_data');
    }
    #
    header('Location:' . DOMAIN_NAME . $extLang);
    exit();
}

function dmY2mdY($str)
{
    $arr = explode('/', $str);
    return $arr[1] . "/" . $arr['0'] . "/" . $arr[2];
}

function default_my_setting()
{
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id, $clsISO;
    #
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
    $profile_id = $clsProfile->getUserID();
    if ($profile_id == '0') {
        $profile_id = vnSessionGetVar('profile_id');
    }
    if (empty($profile_id) && isset($_SESSION["profile_id_db"])) {
        $profile_id = $_SESSION["profile_id_db"];
    }

    $message = $_GET['message'];
    $assign_list["message"] = $message;

    if ($profile_id == 0) {
        header('location:' . $clsProfile->getLink('signin'));
    }
    $oneProfile = $clsProfile->getOne($profile_id);
    $assign_list["oneProfile"] = $oneProfile;
    #
    if ($_POST['Update'] == 'Profile') {
        //$_POST['iso-_first_login'] = NOT_FIRST_LOGIN;
        $value = "";
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        /*   var_dump($profile_id);
           echo '<pre>';
           var_dump($value);die();*/
        if ($clsProfile->updateOne($profile_id, $value)) {
            $assign_list["msg"] = 'You are update successfully!';
            header('location:' . $clsISO->getLink('setting_success'));
        } else {
            die('Error');
        }

        vnSessionDelVar('profile_id');
    }
    //
    $title_page = $core->get_Lang('Setting profile') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_reset_pass()
{
    global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $clsISO, $extLang, $_lang;
    #
    $restorekey = $_GET['restorekey']; //print_r($restorekey);die();
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
    $lstMember = $clsProfile->getAll();
    for ($i = 0; $i < count($lstMember); $i++) {
        if ($restorekey == md5($lstMember[$i]['profile_id'] . 'VietISO')) {
            $profile_id = $lstMember[$i]['profile_id'];
            break;
        }
    }

    $oneMember = $clsProfile->getOne($profile_id);
    if ($profile_id == '' || $oneMember['reset_code'] == '' || $oneMember['reset_time'] < time() - 48 * 60 * 60) {
        header('location:' . $extLang . '/reset/failed/');
    }
    if ($_POST['val'] == 'val') {
        $login_password = $_POST['login_password'];
        $c_login_password = $_POST['c_login_password'];
        #
        if ($login_password == $c_login_password) {
            #
            $set = "userpass='" . $clsProfile->encrypt($login_password) . "',reset_code='',reset_time='0',upd_date='" . time() . "'";
            #
            if ($clsProfile->updateOne($profile_id, $set)) {
                $oneMember = $clsProfile->getOne($profile_id);
                $_SESSION['FRONT_LOGGEDIN'] = 1;
                $_SESSION['FRONT_USERNAME'] = $oneMember['user_name'];
                $_SESSION['FRONT_PASSWORD'] = $oneMember['user_pass'];
                $_frontIsLoggedin_user_id = $oneMember;
                $clsProfile->updateOne($_frontIsLoggedin_user_id, "last_connect='" . time() . "',is_online='1'");
                $clsProfile->sendEmailChangePassword($profile_id, $login_password);
            }
            #
            header('location: ' . PCMS_URL . $extLang . '/#password-changed');
        } else {
            $assign_list["invalid"] = 'invalid';
        }
    }

    $title_page = $core->get_Lang('Reset Password') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_forgot_passOld()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
    #

    $clsProfile = new Profile();
    $msgSubmitForm = '';

    if (isset($_POST['forgotVal']) && $_POST['forgotVal'] == 'forgotVal') {
        $email = $_POST['email_resetpass'];
        if ($clsProfile->checkExitsEmail($_POST['email_resetpass']) == 0) {
            $msgSubmitForm .= 'Email does not Exist!';
        }

        if ($msgSubmitForm == '') {
            $profile_id = $one[0]['profile_id'];
            $time = time();
            $set = "pass_reset_time='" . $time . "'";
            #
            if ($clsProfile->updateOne($profile_id, $set)) {
                $clsProfile->sendEMailResetPasswordSuccess($profile_id);
                header('location:' . $extLang . '/forgotpass/success.html');
                exit();
            }
        } else {
            foreach ($_POST as $k => $v) {
                $assign_list[$k] = $v;
            }
            $assign_list["msgSubmitForm"] = $msgSubmitForm;
        }
    }
}
function default_ajAjaxForgotGlobal()
{
    global $core, $clsISO, $clsEvent, $_lang, $_LANG_ID;

    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo 'invalid_request';
        exit();
    }

    $clsProfile = new Profile();

    $email = isset($_POST['user_email'])
        && !is_array($_POST['user_email'])
            ? strtolower(trim((string)$_POST['user_email']))
            : '';

    if ($email === '') {
        echo 'email_empty_error';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'email_not_correct';
        exit();
    }

    /*
     * Tương thích hệ thống có hoặc không có DOMAIN_EVENT_ID.
     */
    $domainEventId = defined('DOMAIN_EVENT_ID')
        ? (int)DOMAIN_EVENT_ID
        : 0;

    $emailExists = $domainEventId > 0
        ? $clsProfile->checkExitsEmail($email, $domainEventId)
        : $clsProfile->checkExitsEmail($email);

    if ((int)$emailExists !== 1) {
        echo 'email_not_correct';
        exit();
    }

    /*
     * Escape email trước khi dùng trong điều kiện SQL.
     * Nếu class DB có hàm escape riêng, ưu tiên dùng hàm đó.
     */
    $safeEmail = addslashes($email);

    $profileList = $clsProfile->getAll(
        "email='{$safeEmail}' LIMIT 0,1",
        "{$clsProfile->pkey},email,full_name"
    );

    if (
        !is_array($profileList)
        || empty($profileList)
        || empty($profileList[0][$clsProfile->pkey])
    ) {
        echo 'email_not_correct';
        exit();
    }

    $profileId = (int)$profileList[0][$clsProfile->pkey];

    if ($profileId <= 0) {
        echo 'email_not_correct';
        exit();
    }

    $resetTime = time();

    try {
        $resetCode = bin2hex(random_bytes(32));
    } catch (Throwable $exception) {
        $resetCode = hash(
            'sha256',
            $email
            . '|'
            . $resetTime
            . '|'
            . uniqid('', true)
        );
    }

    $updateValue = "reset_code='" . addslashes($resetCode) . "'";
    $updateValue .= ",reset_time='{$resetTime}'";

    if (!$clsProfile->updateOne($profileId, $updateValue)) {
        error_log(
            'Forgot password: cannot update reset token for profile '
            . $profileId
        );

        echo 'reset_error';
        exit();
    }

    /*
     * Hàm cũ tự lấy reset_code từ database để tạo link.
     */
    $mailResult = $clsProfile->sendEmailForgetPassword($profileId);

    /*
     * Một số phiên bản sendEmailForgetPassword() không return gì.
     * Chỉ xem false là lỗi rõ ràng.
     */
    if ($mailResult === false) {
        error_log(
            'Forgot password: cannot send reset email for profile '
            . $profileId
        );

        echo 'send_mail_error';
        exit();
    }

    echo 'reset_success';
    exit();
}

function default_forgot_pass()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
    #
    $title_page = $core->get_Lang('Password reset') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = '';
    $assign_list["description_page"] = $description_page;
    $keyword_page = '';
    $assign_list["keyword_page"] = $keyword_page;
}

function default_change_pass()
{
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    #
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
    $profile_id = $clsProfile->getUserID();
    if (empty($profile_id) && isset($_SESSION["profile_id_db"])) {
        $profile_id = $_SESSION["profile_id_db"];
    }
    $assign_list["profile_id"] = $profile_id;

    $oneProfile = $clsProfile->getOne($profile_id);
    $assign_list["oneProfile"] = $oneProfile;

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;


    $message = $_GET['message'];
    $assign_list["message"] = $message;

    if ($profile_id == 0) {
        header('location:' . $clsProfile->getLink('signin'));
    }
    $oneProfile = $clsProfile->getOne($profile_id);
    $assign_list["oneProfile"] = $oneProfile;
    #
    if ($_POST['Update'] == 'ChangePass') {

        $msg = '';
        $old_pass = $_POST['old_pass'];
        $pass2 = $_POST['pass2'];
        $pass3 = $_POST['pass3'];

        if (!$clsProfile->checkPass($old_pass, $oneProfile['userpass'])) {
            $msg .= '&bull;' . $core->get_Lang('Current password not match') . '  <br />';
        }
        if ($pass2 != $pass3) {
            $msg .= '&bull;' . $core->get_Lang('Password and Retype password not match') . '  <br />';
        }
        if (strlen($pass2) < 6) {
            $msg .= '&bull;' . $core->get_Lang('The passwords Minimum must have 6 characters') . '  <br />';
        }
        if ($old_pass == '' || $pass2 == '' || $pass3 == '') {
            $msg .= '&bull;' . $core->get_Lang('Required field not empty') . '  <br />';
        }

        if ($msg === '') {
            $value = "userpass='" . $clsProfile->encrypt(addslashes($_POST['pass2'])) . "'";

            //print_r($profile_id.'<br/>'.$value); die();
            if ($clsProfile->updateOne($profile_id, $value)) {
                $clsProfile->sendEmailChangePassword($profile_id, $pass2);
                header('location:' . $clsProfile->getLink('signin'));
            } else {
                header('location:' . $clsProfile->getLink('change_pass'));
            }
        }
    }
    $assign_list["msg"] = $msg;
    #
    $title_page = $core->get_Lang('Change Password') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_my_profile()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #

    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
    if (!$clsProfile->isLoggedIn()) {
        header('Location:' . $clsProfile->getLink('signin'));
        exit();
    }

    require_once(DIR_COMMON . '/class.upload.php');
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    #
    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #

    $profile_id = $clsProfile->getUserID();
    if (empty($profile_id) && isset($_SESSION["profile_id_db"])) {
        $profile_id = $_SESSION["profile_id_db"];
    }
    $message = $_GET['message'];
    $assign_list["message"] = $message;

    $oneProfile = $clsProfile->getOne($profile_id);
    $assign_list["oneProfile"] = $oneProfile;

    $msg_success = '';
    if ($message) {
        $msg_success .= $core->get_Lang('You are update successfully!');
    }
    $msg_error = '';
    #
    if ($_POST['Update'] == 'Profile') {
        $value = '';
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        //$value .= ",full_name='".$_POST['iso-first_name'].' '.$_POST['iso-last_name']."'";
        $value .= ",organisation='" . $_POST['organisation'] . "'";

        if ($clsProfile->updateOne($profile_id, $value)) {

            header('Location:' . $clsProfile->getLink('contact_info_success'));
            exit();
        } else {
            $msg_error .= $core->get_Lang('You are update no success!');
        }
    }
    $assign_list["msg_success"] = $msg_success;
    $assign_list["msg_error"] = $msg_error;
    #
    $title_page = $core->get_Lang('My Profile') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_my_booking()
{
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id, $clsISO;
    #
    require_once(DIR_COMMON . '/class.upload.php');
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;


    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsVoucher = new Voucher();
    $assign_list["clsVoucher"] = $clsVoucher;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsTourItinerary = new TourItinerary();
    $assign_list["clsTourItinerary"] = $clsTourItinerary;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsFAQ = new FAQ();
    $assign_list["clsFAQ"] = $clsFAQ;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $lstFAQ = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,4", $clsFAQ->pkey);
    $assign_list["lstFAQ"] = $lstFAQ;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;


    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #
    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;

    $lstBooking = $clsBooking->getAll("member_id='$profile_id' order by booking_id desc");

    $assign_list["lstBooking"] = $lstBooking;

    //print_r($lstBooking); die();

    $title_page = $core->get_Lang('My Booking') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_my_review()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #
    require_once(DIR_COMMON . '/class.upload.php');
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;

    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #
    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;

    $lstReviews = $clsReviews->getAll("profile_id='$profile_id' order by reviews_id desc");
    $assign_list["lstReviews"] = $lstReviews;
    if ($lstReviews > 0) {
        $totlalReviews = count($lstReviews);
    } else {
        $totlalReviews = 0;
    }

    $assign_list["totlalReviews"] = $totlalReviews;

    $lstReviewsHotel = $clsReviews->getAll("type='hotel' and profile_id='$profile_id' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
    $assign_list["lstReviewsHotel"] = $lstReviewsHotel;


    $lstReviewsTour = $clsReviews->getAll("type='tour' and profile_id='$profile_id' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
    $assign_list["lstReviewsTour"] = $lstReviewsTour;

    $lstReviewsCruise = $clsReviews->getAll("type='cruise' and profile_id='$profile_id' order by is_online desc", $clsReviews->pkey . ', reg_date,profile_id, table_id');
    $assign_list["lstReviewsCruise"] = $lstReviewsCruise;


    /*=============Content Page==================*/
    $title_page = $core->get_Lang('My Tour Reviews & Photos') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_my_offer()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #
    require_once(DIR_COMMON . '/class.upload.php');
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;

    $clsReviews = new Reviews();

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #

    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;

    $lstBooking = $clsBooking->getAll("member_id='$profile_id' order by booking_id desc");
    $assign_list["lstBooking"] = $lstBooking;
    if ($lstBooking > 0) {
        $totlalBooking = count($lstBooking);
    } else {
        $totlalBooking = 0;
    }

    $assign_list["totlalBooking"] = $totlalBooking;

    $lstBookingHotel = $clsBooking->getAll("clsTable='Hotel' and member_id='$profile_id' order by booking_id desc");
    $assign_list["lstBookingHotel"] = $lstBookingHotel;

    $lstBookingTour = $clsBooking->getAll("clsTable='Tour' and member_id='$profile_id' order by booking_id desc");
    $assign_list["lstBookingTour"] = $lstBookingTour;

    $lstBookingCruise = $clsBooking->getAll("clsTable='Cruise' and member_id='$profile_id' order by booking_id desc");
    $assign_list["lstBookingCruise"] = $lstBookingCruise;

    //print_r($lstBookingHotel); die();

    #
    //
    $title_page = $core->get_Lang('My Offer') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_my_booking_detail()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    #
    require_once(DIR_COMMON . '/class.upload.php');
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;

    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;

    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;

    $clsReviews = new Reviews();

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #

    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;


    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $assign_list['type'] = $type;

    if ($type == 'Tour') {
        $clsTable = new Tour();
    } else if ($type == 'Cruise') {
        $clsTable = new Cruise();
    } else {
        $clsTable = new Hotel();
    }
    $assign_list['clsTable'] = $clsTable;

    $target_id = isset($_GET['target_id']) ? $_GET['target_id'] : '';
    $assign_list['target_id'] = $target_id;

    $lstBooking = $clsBooking->getAll("member_id='$profile_id' and clsTable='$type' and target_id='$target_id' order by booking_id desc limit 0,1");
    $booking_id = $lstBooking[0][$clsBooking->pkey];
    $assign_list['booking_id'] = $booking_id;


    $oneItem = $clsBooking->getOne($booking_id);

    $booking_store = unserialize($oneItem['booking_store']);
    //print_r($booking_store); die();
    $number_of_guest = '';
    if ($type == 'Tour') {
        if (!empty($booking_store['adult'])) {
            $number_of_guest .= $booking_store['adult'] . ' ' . $core->get_Lang('adult(s)');
        }
        if (!empty($booking_store['child'])) {
            $number_of_guest .= ', ' . $booking_store['child'] . ' ' . $core->get_Lang('children(s)');
        }
        if (!empty($booking_store['baby'])) {
            $number_of_guest .= ', ' . $booking_store['baby'] . ' ' . $core->get_Lang('Infant');
        }
    } else if ($type == 'Hotel') {
        if (!empty($booking_store['adult'])) {
            $number_of_guest .= $booking_store['adult'] . ' ' . $core->get_Lang('adult(s)');
        }
        if (!empty($booking_store['children'])) {
            $number_of_guest .= ', ' . $booking_store['children'] . ' ' . $core->get_Lang('children(s)');
        }
    } else if ($type == 'Cruise') {
        if (!empty($booking_store['number_adult'])) {
            $number_of_guest .= $booking_store['number_adult'] . ' ' . $core->get_Lang('adult(s)');
        }
    }

    $assign_list['number_of_guest'] = $number_of_guest;

    $title_page = $core->get_Lang('My Booking Details') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_my_wishlist()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
    require_once(DIR_COMMON . '/class.upload.php');
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    #-Check member online
    $clsProfile = new Profile();
    if (!$clsProfile->isLoggedIn()) {
        header('Location:' . $clsProfile->getLink('signin'));
        exit();
    }
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;

    $clsReviews = new Reviews();
    $assign_list["clsReviews"] = $clsReviews;

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #
    $clsWishlist = new Wishlist();
    $assign_list["clsWishlist"] = $clsWishlist;

    $lstWishlist = $clsWishlist->getAll("member_id='$profile_id' order by wishlist_id desc");
    $assign_list["lstWishlist"] = $lstWishlist;
    if ($lstWishlist > 0) {
        $totlalWishlist = count($lstWishlist);
    } else {
        $totlalWishlist = 0;
    }
    $assign_list["totlalWishlist"] = $totlalWishlist;

    $lstWishlistHotel = $clsWishlist->getAll("clsTable='Hotel' and member_id='$profile_id' order by wishlist_id desc");
    $assign_list["lstWishlistHotel"] = $lstWishlistHotel;

    $lstWishlistTour = $clsWishlist->getAll("clsTable='Tour' and member_id='$profile_id' order by wishlist_id desc");
    $assign_list["lstWishlistTour"] = $lstWishlistTour;

    $lstWishlistCruise = $clsWishlist->getAll("clsTable='Cruise' and member_id='$profile_id' order by wishlist_id desc");
    $assign_list["lstWishlistCruise"] = $lstWishlistCruise;

    /*=============Content Page==================*/
    $title_page = $core->get_Lang('My Wishlist') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_contact_info()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id, $clsISO;
    #-Check member online
    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;
    if (!$clsProfile->isLoggedIn()) {
        header('Location:' . $clsProfile->getLink('signin'));
        exit();
    }
    #
    $cssShow = 'member';
    $assign_list["cssShow"] = $cssShow;
    #
    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;

    $lstCountry = $clsCountry->getAll("is_trash=0 order by order_no asc");
    $assign_list["lstCountry"] = $lstCountry;
    #
    $message = $_GET['message'];
    $assign_list["message"] = $message;

    $oneProfile = $clsProfile->getOne($profile_id);
    $assign_list["oneProfile"] = $oneProfile;

    $msg_success = '';
    if ($message) {
        $msg_success .= $core->get_Lang('You are update successfully!');
    }
    $msg_error = '';
    #
    if ($_POST['Update'] == 'Profile') {
        $value = '';
        $firstAdd = 0;
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                if ($firstAdd == 0) {
                    $value .= $tmp[1] . "='" . addslashes($val) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                }
            }
        }
        $value .= ",full_name='" . $_POST['iso-first_name'] . ' ' . $_POST['iso-last_name'] . "'";
        $value .= ",organisation='" . $_POST['organisation'] . "'";

        if ($clsProfile->updateOne($profile_id, $value)) {

            header('Location:' . $clsProfile->getLink('contact_info_success'));
            exit();
        } else {
            $msg_error .= $core->get_Lang('You are update no success!');
        }
    }
    $assign_list["msg_success"] = $msg_success;
    $assign_list["msg_error"] = $msg_error;
    /*=============Content Page==================*/
    $title_page = $core->get_Lang('Contact Information') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}

function default_checkAccountAJAX()
{
    global $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $clsISO;
    $clsProfile = new Profile();
    #
    $is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : 0;
    $fbAT = isset($_POST['fbAT']) ? $_POST['fbAT'] : '';
    $fbUser = isset($_POST['fbUser']) ? $_POST['fbUser'] : '';
    $_success = false;

    if ($fbUser) {
        if ($clsProfile->userLoggedInFacebook($fbUser, $is_agent) == 1) {
            $_success = true;
        } else {
            echo 'invalidAccount';
            die();
        }
    }
    #
    echo $_success;
    die();
}

function default_checkGoogleAccount()
{
    global $core, $clsISO, $oneSetting, $_frontIsLoggedin_user_id;
    global $_lang, $extLang, $clsSetting;
    $clsProfile = new Profile();
    #
    $is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $_id = isset($_POST['id']) ? $_POST['id'] : '';
    if ($email == '' || $_id == '') {
        echo '_invalid';
        die();
    }

    if ($clsProfile->checkExitsGoogle($email) == 0) {
        echo 'invalidAccount';
        die();
    }

    #
    $clsProfile = new Profile();
    $userProfile = array(
        'id' => $_POST['id'],
        'email' => $_POST['email'],
        'full_name' => $_POST['full_name'],
        'avatar' => $_POST['avatar'],
        'family_name' => $_POST['family_name'],
        'given_name' => $_POST['given_name'],
        'gender' => $_POST['gender'],
        'verified_email' => $_POST['verified_email'],
        'hd' => $_POST['hd'],
        'is_agent' => 0,
        'link' => $_POST['link']
    );
    #
    $_success = false;
    if ($clsProfile->userLoggedInGoogle($userProfile)) {
        $_SESSION['google_data'] = $userProfile;
        $_success = true;
    }
    #
    echo $_success;
    die();
}

function default_facebook2callback()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn;
}

function default_ajOpenChangeAvatar()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $profile_id;
    $clsProfile = new Profile();
    $upload_path = '/datastore/' . $core->replaceSpace($clsProfile->getUsername($profile_id));
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    #
    //	print_r($tp);die();
    if ($tp == 'F') {
        $html = '<div class="atlas_pop signin anarrow">
		<div class="headPop">
			<h3>' . $core->get_Lang("Upload a Profile Image") . '</h3>
			<a href="javascript:void(0);" class="closeEv close_pop" aria-hidden="true"></a>
		</div>
		<div class="body page-bg round-bottom pal">
			<p>' . $core->get_Lang("Upload a profile image for your account. It should be square, preferably 125x125 pixels, and in JPEG, GIF, or PNG format") . '.</p>
			<div id="fieldErrors" class="mhm"></div>
			<form id="useraccount_uploadImageForm" action="" method="POST" enctype="multipart/form-data">
				<p>
					<label for="profileImage">' . $core->get_Lang("Enter file path") . ':</label>
					<input type="file" id="profileImage" name="profileImage">
				</p>
				<div class="line">
					<button type="button" name="submit" title="' . $core->get_Lang("Submit") . '"><span>' . $core->get_Lang("Submit") . '</span></button>
					<div class="unitRight mts">
						<a href="javascript:location.reload(true)" class="xsmall closeEv">' . $core->get_Lang("Cancel") . '</a><br />
					</div>
				</div>
			</form>
		</div>';
        #
        echo $html;
        die();
    } else if ($tp == 'S') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_FILES['profileImage']['name'];
            $tmp_name = $_FILES['profileImage']['tmp_name'];
            $type = $_FILES['profileImage']['type'];
            $size = $_FILES['profileImage']['size'];
            #- Validate
            if (is_null($name)) {
                echo '_invalid_empty';
                die();
            }
            if ($size >= 2097152) {
                echo '_invalid_size';
                die();
            }
            if (!in_array($type, array('image/jpeg', 'image/png', 'image/gif'))) {
                echo '_invalid_type';
                die();
            }

            if (!class_exists('UploadFile')) {
                require_once(DIR_COMMON . '/class.upload.php');
            }
            $up = '';

            if (is_uploaded_file($_FILES['profileImage']['tmp_name'])) {
                $clsUploadFile = new UploadFile();
                $up = $clsUploadFile->uploadItem($_FILES["profileImage"], '/datastore/customer/customer_' . $profile_id, "jpg,gif,png");
                $clsProfile->updateOne($profile_id, "avatar='$up'");
            }
            echo '0|||' . $up;
            die();
        }
    }
}
