<?php
function default_config()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $clsISO;
}

function default_default()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $clsISO, $hasAPI;
    #
    $clsVietISOSDK = new VietISOSDK();
    $listAppLanguage = $dbconn->getAll("select * from default_app_language where is_online=1");
    $assign_list["listAppLanguage"] = $listAppLanguage;
    #
    $listAppTemplate = array();
    $dir = dirname(__FILE__) . '/../../../../isocms/templates/';
    $list = scandir($dir);
    for ($i = 0; $i < count($list); $i++) {
        $temp = $list[$i];
        if ($temp != '.' && $temp != '..') {
            $listAppTemplate[] = $temp;
        }
    }
    $assign_list["listAppTemplate"] = $listAppTemplate;
    if ($hasAPI) {
        /*$response = $clsVietISOSDK->doInApp('GET','/api/get_property',json_encode(array('property_type'=>'_CRM_CURRENCY')));
        $response = json_decode($response, true);
        $lstCurrency = $response['data']['lstProperty'];*/
        $lstCurrency = $clsVietISOSDK->getProperty('_CRM_CURRENCY');
        //$clsISO->pre($lstCurrency);die;
        $assign_list["lstCurrency"] = $lstCurrency;
    }
    //$getInfoRateDefault = $clsISO->getInfoRateDefault();
    //$clsISO->pre($getInfoRateDefault);die;
    #process language table
    /*$lstTbl = $dbconn->GetAll("SHOW TABLES FROM ".DB_NAME."");
    $listTable = array();
    for($i=0;$i<count($lstTbl);$i++){
        $is_system_table =str_replace('default_','',$lstTbl[$i]['Tables_in_'.DB_NAME.''])==$lstTbl[$i]['Tables_in_'.DB_NAME.'']?0:1;
        if($is_system_table){
            $listTable[] = $lstTbl[$i]['Tables_in_'.DB_NAME.''];
        }
    }
    for($i=0;$i<count($listTable);$i++){
        $sql = "ALTER TABLE ".$listTable[$i]." ADD lang_id VARCHAR(2) NOT NULL";
        //$sql = "ALTER TABLE ".$listTable[$i]." drop column lang_id";
        $dbconn->Execute($sql);
    }*/
    #end process language table

    #tab htaccess
    $htaccess = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/.htaccess');
    $htaccess = str_replace('
', '<br>', $htaccess);
    $assign_list["htaccess"] = $htaccess;
    $assign_list["htaccess_permission"] = substr(sprintf('%o', fileperms($_SERVER['DOCUMENT_ROOT'] . '/.htaccess')), -4);
    # =
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        #
        $CompanyLogo = isset($_POST['isoman_url_image']) && !empty($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
        if ($CompanyLogo != '') {
            $clsConfiguration->updateValue("CompanyLogo", addslashes($CompanyLogo));
        }
        if ($clsISO->getVar('ONLINE_PAYMENT_ENABLE')) {
            $clsConfiguration->updateValue('ExchangeRate', $clsISO->processSmartNumber($_POST['ExchangeRate']));
        }
        #
        $extUrl = '';
        if ($_POST['submit'] == 'UpdateConfiguration') {
            $clsConfiguration->updateValue('SiteEnableRefresh', $_POST['SiteEnableRefresh']);
            $extUrl = '#isotab0';
        }
        if ($_POST['submit'] == 'Updatehtaccess') {
            $htaccess = $_SERVER['DOCUMENT_ROOT'] . '/.htaccess';
            $fp = fopen($htaccess, 'w');
            if ($fp) {
                $htaccess_content = $_POST['htaccess'];
                $htaccess_content = str_replace('<br>', '
', $htaccess_content);
                $htaccess_content = str_replace('&#036;', '$', $htaccess_content);
                $htaccess_content = str_replace('&amp;', '&', $htaccess_content);
                fwrite($fp, $htaccess_content);
            }
            fclose($fp);
            $extUrl = '#isotab1';
        }
        if ($_POST['submit'] == 'UpdateConfigurationGeneral') {
            $extUrl = '#isotab2';
        }
        redirect(PCMS_URL . '?mod=setting&message=updateSuccess' . $extUrl);
    }
}

function default_mailconfig()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $clsISO;
    #
    if (isset($_POST['submit']) && $_POST['submit'] = 'UpdateConfiguration') {

        //$abc=$clsISO->isoencrypt($_POST['iso-SiteSmtpPassword']);
        //print_r($abc); die();
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        $clsConfiguration->updateValue('SiteSmtpSSL', $_POST['SiteSmtpSSL']);
        header('location:' . PCMS_URL . '?mod=setting&act=mailconfig&message=updateSuccess');
    }
}

function default_configmail()
{
    global $assign_list, $clsISO, $core, $clsConfiguration, $dbconn;
    if (isset($_POST['submit']) && $_POST['submit'] = 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        $mail_type = Input::post('mail_type', 'smtp');
        if ($mail_type == 'sendgrid') {
            $mail_sendgrid_api_enable = Input::post('mail_sendgrid_api_enable', 0);
            $mail_sendgrid_api_enable = $clsISO->toInt($mail_sendgrid_api_enable);
            $clsConfiguration->updateValue('mail_sendgrid_api_enable', $mail_sendgrid_api_enable);
            /** Update pass Sendgrid */
            $mail_sengrid_password = Input::post('mail_sengrid_password');
            if (!empty($mail_sengrid_password)) {
                $clsConfiguration->updateValue('mail_sengrid_password', $mail_sengrid_password);
            }
        } else {
            $mail_smtp_authentication = Input::post('mail_smtp_authentication', 0);
            $mail_smtp_authentication = $clsISO->toInt($mail_smtp_authentication);
            $clsConfiguration->updateValue('mail_smtp_authentication', $mail_smtp_authentication);
            /** Update pass SMTP */
            $mail_smtp_password = Input::post('mail_smtp_password');
            if (!empty($mail_smtp_password)) {
                $clsConfiguration->updateValue('mail_smtp_password', $mail_smtp_password);
            }
        }
        header('location:' . PCMS_URL . '?mod=setting&act=mailconfig&message=updateSuccess');
        exit();
    }
}

function default_mailconfig_active()
{
    global $assign_list, $core, $clsConfiguration, $dbconn;
    $mail_type = Input::post('mail_type', 'sendgrid');
    $clsConfiguration->updateValue('mail_type', $mail_type);
    echo(1);
    die();
}

function default_sendmail_test()
{
    global $smarty, $assign_list, $_frontIsLoggedin_user_id, $core, $clsISO, $clsConfiguration, $clsUser;
    /** Info E-mail */
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_STRICT); //E_ALL
    $mail_type = Input::post('mail_type', 'smtp');
    $fromname = $clsConfiguration->getValue('mail_' . $mail_type . '_fromname');
    $fromemail = $clsConfiguration->getValue('mail_' . $mail_type . '_fromemail');
    /** Config E-mail */
    $toemail = $clsUser->getOneField('email', $core->_USER['user_id']);
    $toname = $clsUser->getOneField('first_name', $core->_USER['user_id']) . ' ' . $clsUser->getOneField('last_name', $core->_USER['user_id']);
    $subject = 'Test Connection';
    $message = 'Test Connection';


    // print_r($fromemail.'xxx'.$toemail.'xxx'.$subject.'xxx'.$message.'xxx'.$fromname.'xxxx'.$mail_type);die();


    /* End */
    if ($mail_type == 'smtp') {
        $msg = ''; // message after send email
        $mail_smtp_username = trim($clsConfiguration->getValue('mail_smtp_username'));
        $mail_smtp_password = trim($clsConfiguration->getValue('mail_smtp_password'));
        $mail_smtp_secure = trim($clsConfiguration->getValue('mail_smtp_secure'));
        $mail_smtp_host = trim($clsConfiguration->getValue('mail_smtp_host'));
        $mail_smtp_port = trim($clsConfiguration->getValue('mail_smtp_port'));
        $mail_smtp_authentication = $clsConfiguration->getValue('mail_smtp_authentication', 0);
        require_once(DIR_INCLUDES . '/mailer/class.phpmailer.php');
        //require_once(DIR_INCLUDES.'/mailer/smtp/class.phpmailer.php');
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'utf-8';
            $mail->XMailer = $clsConfiguration->getValue("company_name");
            $mail->From = $fromemail;
            $mail->FromName = html_entity_decode($fromname, ENT_QUOTES);
            $mail->AddAddress(trim($toemail));
            // SMTP
            $mail->IsSMTP();
            $mail->Hostname = $_SERVER['SERVER_NAME'];
            if (!empty($mail_smtp_host)) $mail->Host = $mail_smtp_host;
            if (!empty($mail_smtp_port)) $mail->Port = $mail_smtp_port;
            if ($mail_smtp_secure != 'none') $mail->SMTPSecure = $mail_smtp_secure;
            // Authenticate
            $mail->SMTPAuth = true;
            $mail->Username = $mail_smtp_username;
            $mail->Password = $mail_smtp_password;

            $mail->Sender = $mail->From;
            // Content
            $mail->isHTML(true);
            $mail->Subject = html_entity_decode($subject, ENT_QUOTES);
            $mail->Body = $message;
            // Send
            if ($mail->Send()) {
                $status = 'success';
                $msg = $core->get_Lang('Send test email success');
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
                                    'email' => $toemail,
                                    'name' => $toname,
                                ),
                            ),
                        )
                    ),
                    'from' => array(
                        "name" => $fromname,
                        "email" => $fromemail
                    ),
                    'reply_to' => array(
                        "name" => $fromname,
                        "email" => $fromemail
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
                // Tell curl not to return headers,but do return the response
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
                $msg = $core->get_Lang('Send test email error');
                if ($err) {
                    $status = 'success';
                    $msg = $core->get_Lang('Send test email successfully');
                }
            } else {
                //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
                $params = array(
                    'api_user' => $mail_sendgrid_username,
                    'api_key' => $mail_sendgrid_password,
                    'to' => $toemail,
                    'replyto' => $toemail,
                    'subject' => $subject,
                    'html' => $message,
                    'from' => $fromemail,
                    'fromname' => $fromname
                );
                // Generate curl request
                $ch = curl_init($mail_sendgrid_api_url);
                // Tell curl to use HTTP POST
                curl_setopt($ch, CURLOPT_POST, true);
                // Tell curl that this is the body of the POST
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                // Tell curl not to return headers,but do return the response
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                // obtain response
                $response = curl_exec($ch);
                curl_close($ch);
                // print everything out
                $status = 'error';
                $msg = $core->get_Lang('Send test email error');
                if (strpos($response, 'success') == true) {
                    $status = 'success';
                    $msg = $core->get_Lang('Send test email successfully');
                }
            }
        } else {
            if (!empty($mail_sendgrid_api_key)) {
                require_once(DIR_INCLUDES . '/mailer/SendGrid3.0/vendor/autoload.php');
                $email = new \SendGrid\Mail\Mail();
                $email->setFrom($fromemail, $fromname);
                $email->setSubject($subject);
                $email->addTo($toemail, "");
                $email->addContent("text/html", $message);
                $sendgrid = new \SendGrid($mail_sendgrid_api_key);
                try {
                    $response = $sendgrid->send($email);
                    if ($response->statusCode() == '200' || $response->statusCode() == '202') {
                        $status = 'success';
                        $msg = $core->get_Lang('Send test email successfully');
                    }
                } catch (Exception $e) {
                    $status = 'error';
                    $msg = $e->getMessage();
                }
            } else {
                require_once(DIR_INCLUDES . '/mailer/SendGrid/vendor/autoload.php');
                $sendgrid = new SendGrid(
                    $mail_sendgrid_username,
                    $mail_sendgrid_password,
                    array("turn_off_ssl_verification" => false)
                );
                // Create object
                $mail = new \SendGrid\Email();
                // Param send email
                $mail->addTo($toemail)
                    ->setFrom($fromemail)
                    ->setFromName($fromname)
                    ->setReplyTo($toemail)
                    ->setSubject($subject)
                    ->setHtml($message)
                    ->addHeader('X-Sent-Using', 'SendGrid-API')
                    ->addHeader('X-Transport', 'web');
                // obtain response
                $response = $sendgrid->send($mail);
                // Return
                $status = 'error';
                $msg = $core->get_Lang('Send test email error');
                if (
                    isset($response->body['message'])
                    && $response->body['message'] == 'success'
                ) {
                    $status = 'success';
                    $msg = $core->get_Lang('Send test email successfully');
                }
            }
        }
        /** End Sendgrid */
    }
    unset($oneMailbox);
    unset($more_information);
    // output
    echo $status . '|||' . $msg;
    die();
}

function default_profile()
{
    global $assign_list, $core, $clsConfiguration, $dbconn;
    if (isset($_POST['submit']) && $_POST['submit'] = 'CompanyProfile') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location:' . PCMS_URL . '?mod=setting&act=profile&message=updateSuccess');
    } else {
        $clsProperty = new Property();
        $allUnitProperty = $clsProperty->getAll("is_trash=0 and type='_CRM_CURRENCY' order by order_no DESC");
        $assign_list["allUnitProperty"] = $allUnitProperty;
        #
        $tms_domain = $clsConfiguration->getValue('tms_domain');
        $tms_token = $clsConfiguration->getValue('tms_token');
        $tms_conn = 0;
        if (empty($tms_domain) || empty($tms_token)) {
            $tms_conn = 0;
        } else {
            $clsVietISOSDK = new VietISOSDK(array("api_url" => rtrim($tms_domain, "/") . "/api", "api_key" => $tms_token));
            $res = $clsVietISOSDK->post("/isocms_connect");
            //var_dump($res);
            if ($res['result'] == 'success') {
                $tms_conn = 1;
            }
        }
        $assign_list["tms_conn"] = $tms_conn;
    }
}

function default_zalo_oa()
{
    global $assign_list, $core, $clsConfiguration, $dbconn;
    #


    if (isset($_POST['submit']) && $_POST['submit'] = 'CompanyProfile') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location:' . PCMS_URL . '?mod=setting&act=zalo_oa&message=updateSuccess');
    }
}

function default_livechat()
{
    global $assign_list, $core, $clsConfiguration, $dbconn;
    #
    if (isset($_POST['submit']) && $_POST['submit'] = 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location:' . PCMS_URL . '?mod=setting&act=livechat&message=updateSuccess');
    }
}

function default_pre_order()
{
    global $assign_list, $core, $clsConfiguration, $dbconn;
    #
    if (isset($_POST['submit']) && $_POST['submit'] = 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location:' . PCMS_URL . '?mod=setting&act=pre_order&message=updateSuccess');
    }
}

function default_tailor()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $_LANG_ID;
    global $clsISO;
    #- Create message payment online
    if (isset($_POST['submit']) && $_POST['submit'] = 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location:' . PCMS_URL . '?mod=setting&act=tailor&message=updateSuccess');
    }
}

function default_message()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $_LANG_ID;
    global $clsISO;
    #- Create message payment online
    if ($clsISO->getVar('PAYMENT_GLOBAL')) {
        #- Create successful message paypal
        if ($clsConfiguration->getValue('Paypal_Status_Mode') && $clsConfiguration->countItem("setting='SiteMsg_SuccessPaypal'") == 0) {
            $clsConfiguration->updateValue('SiteMsg_SuccessPaypal', '<div>Dear Customers,</div>
<div>Thank for your payment us, please visit our client system for details about your payment:</div>
<div>&nbsp;</div>
<div>Your Transaction&nbsp;as follows</div>
<div>---</div>
<div>Card Holder: [%number_card%]</div>
<div>Card Type: [%type_card%]</div>
<div>Order Info: [%vpc_orderInfo%]</div>
<div>Amount: [%amount%]</div>
<div>Date: [%datetime%]</div>
<div>Status: [%status%]</div>
<div>---</div>
<div>
<div>Brgds</div>
</div>');
        } else if (!$clsConfiguration->getValue('Paypal_Status_Mode') && $clsConfiguration->countItem("setting='SiteMsg_SuccessPaypal'") > 0) {
            $clsConfiguration->deleteByCond("setting='SiteMsg_SuccessPaypal'");
        }
        #- Create successful message ONEPAY
        if (($clsConfiguration->getValue('ONEPAY_Status_Mode') || $clsConfiguration->getValue('ONEPAY_Visa_Status_Mode'))
            && $clsConfiguration->countItem("setting='SiteMsg_SuccessOnePay'") == 0
        ) {
            $clsConfiguration->updateValue('SiteMsg_SuccessOnePay', '<p>Dear Customers,&nbsp;</p>
<p>Thank for your payment us, please visit our client system for details about your payment:</p>
<p>Your Transaction&nbsp;as follows</p>
<p>---</p>
<p>Card Number: {$cardnumber}&nbsp;</p>
<p>Card Type: {$cardtype}&nbsp;</p>
<p>Transaction ID: {$transId}</p>
<p>Booking ID: {$bookingId}</p>
<p>Transaction Reference: {$transRef}</p>
<p>Amount: {$amount}</p>
<p>Date: {$datetime}</p>
<p>Status: <strong>{$status}</strong></p>
<p>Thank you for using our&nbsp;Product/Service. We look forward to serving you in the trip.&nbsp;</p>
<p>Yours faithfully,&nbsp;</p>');
        } else if (
            !$clsConfiguration->getValue('ONEPAY_Status_Mode') && !$clsConfiguration->getValue('ONEPAY_Visa_Status_Mode')
            && $clsConfiguration->countItem("setting='SiteMsg_SuccessOnePay'") > 0
        ) {
            $clsConfiguration->deleteByCond("setting='SiteMsg_SuccessPaypal'");
        }
    }
    #- End Create message payment online
    //$listMessage = $clsConfiguration->getAll("setting like 'SiteMsg_%'");
    $listMessage = $clsConfiguration->getAll("setting like 'SiteMsg_%_" . $_LANG_ID . "'");
    $assign_list["listMessage"] = $listMessage;
    //print_r($_LANG_ID); die();
    #
    if (isset($_POST['submit']) && $_POST['submit'] = 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location:' . PCMS_URL . '?mod=setting&act=message&message=updateSuccess');
    }
}

function default_msg()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $mod, $act;
    // Update Configuration
    $listMessage = $clsConfiguration->getAll("setting like 'SiteInfo_%'");
    $assign_list["listMessage"] = $listMessage;

    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=msg&message=UpdateSuccess');
    }
}

function default_exchangerates()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $mod, $act, $clsISO;
}

function default_social()
{
    global $assign_list, $core, $clsConfiguration, $dbconn, $mod, $act;

    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=social&message=UpdateSuccess');
    }
}

function default_ajSubmitSaveSetting()
{
    global $core;
    $clsClassTable = new Common();
    $common_id = isset($_POST['common_id']) ? $_POST['common_id'] : 1;
    #
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
    if ($clsClassTable->updateOne($common_id, $value)) {
        setcookie('systpl', $_POST['iso-SiteTemplate'], time() + (86400 * 30), "/");;
        echo '_SUCCESS';
        die();
    } else {
        echo '_ERROR';
        die();
    }
}

function default_ajOpenSetting()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsConfiguration = new Configuration();
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $setting = isset($_POST['setting']) ? $_POST['setting'] : '';
    $prefix = isset($_POST['prefix']) ? $_POST['prefix'] : 'SiteMsg_';

    if ($tp == 'F') {
        $html = '';
        $html .= '<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('createmessage') . '</h3>
		</div>';
        $html .= '<table width="100%" cellspacing="2" cellpadding="5" border="0" class="form">
			<tbody>
				<tr>
					<td class="fieldlabel span25">Setting key<font color="#c00000">*</font></td>
					<td class="fieldarea">
						<span>' . $prefix . '</span>
						<input style="width:78%" name="setting" value="" type="text" class="text full required ">
					</td>
				</tr>
			</tbody>
		</table>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary btnSubmitMessage" _prefix="' . $prefix . '">
				<i class="icon-ok icon-white"></i> <span>Cập nhật</span>
			</button>
		</div>';
        echo $html;
        die();
    } else if ($tp == 'S') {
        $setting = $_POST['setting'];
        $setting = $prefix . $setting;
        $clsConfiguration->updateValue($setting, "");
        echo(1);
        die();
    }
}

/* IP Manager */
function default_ip()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    /*if($user_id!=1){
        header('location:'.PCMS_URL.'?message=notPermission');
        exit();
    }*/
}

function default_ajaxLoadListIP()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
    #
    $clsIP = new IP();
    $clsPagination = new Pagination();
    #
    $cond = "is_trash=0";
    $number_per_page = isset($_POST['number_per_page']) ? $_POST['number_per_page'] : 10;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    #
    $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
    if ($keyword != '') {
        $cond .= " and value like '%$keyword%'";
    }
    $totalRecord = $clsIP->countItem($cond);
    $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page);
    $offset = ($page - 1) * $number_per_page;
    $order_by = " ORDER BY ip_id DESC";
    $limit = " LIMIT $offset,$number_per_page";

    $html = '';
    $listItem = $clsIP->getAll($cond . $order_by . $limit, $clsIP->pkey . ',upd_date');
    if (!empty($listItem)) {
        $i = 0;
        foreach ($listItem as $k => $v) {
            $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html .= '<td class="index">' . ($i + 1) . '</td>';
            $html .= '<td><a href="javascript:void();" class="btn_edit_ip" data="' . $v[$clsIP->pkey] . '">
						<strong style="font-size:14px;">' . $clsIP->getOneField("value", $v[$clsIP->pkey]) . '</strong></a>
					</td>';
            $html .= '<td class="color_r text-right">' . date('d-m-Y h:i', $v['upd_date']) . '</td>
					<td align="center" style="text-align:center;">
						<a class="btn_edit_ip" data="' . $v[$clsIP->pkey] . '" href="javascript:void();">
							<i class="icon-pencil"></i>
						</a>
						<a class="btn_delete_ip" data="' . $v[$clsIP->pkey] . '" href="javascript:void();">
							<i class="icon-remove"></i>
						</a>
					</td>';
            $html .= '</tr>';
            ++$i;
        }
    } else {
        $html = '<tr>
			<td colspan="6">
				<div class="infobox"> 
					<strong>Waring.</strong>
					<br> Không có dữ liệu phù hợp. 
				</div>
			</td>
	  </tr>';
    }
    echo $html . '$$' . $pageview;
    die();
}

function default_ajaxFrmIP()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
    #
    $clsIP = new IP();
    $ip_id = isset($_POST['ip_id']) ? $_POST['ip_id'] : '0';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';

    $html = '';
    $html .= '<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="Đóng"></a>
		<h3>' . (intval($ip_id) == 0 ? 'Thêm mới' : 'Cập nhật') . ' IP</h3>
	</div>';
    $html .= '<table width="100%" cellspacing="2" cellpadding="5" border="0" class="form">
		<tbody>
			<tr>
				<td style="width:20%; padding:10px 10px 0 0;vertical-align:top" class="fieldlabel">IP<font color="#c00000">*</font></td>
				<td class="fieldarea">
					<input tabindex="1" name="ip_address" value="' . (intval($ip_id) == 0 ? $tp : $clsIP->getOneField('value', $ip_id)) . '" type="text" class="text full fontLarge required span95">
					<div class="clearfix mt5"></div>
					<span class="notice-full" style="padding-left:0;">Ex:192.168.1.1</span>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="modal-footer">
		<button type="button" ip_id="' . $ip_id . '" class="btn btn-primary" id="ajSaveIP">
			<i class="icon-ok icon-white"></i> <span>Cập nhật</span>
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>Đóng lại</span>
		</button>
	</div>';
    echo $html;
    die();
}

function default_ajaxSaveIP()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $clsISO;
    $user_id = $core->_USER['user_id'];
    #
    $clsIP = new IP();
    $ip_address = $_POST['ip_address'];
    $ip_id = $_POST['ip_id'];
    #
    if (intval($ip_id) == 0) {
        $allItem = $clsIP->getAll("is_trash=0 and value='$ip_address' limit 0,1");
        if (!empty($allItem)) {
            echo 'IP_EXIST';
            die();
        } else {
            $f = "value,reg_date,upd_date,is_online";
            $v = "'" . addslashes($ip_address) . "','" . time() . "','" . time() . "','1'";
            if ($clsIP->insertOne($f, $v)) {
                echo 'INSERT_SUCCESS';
                die();
            } else {
                echo 'ERROR';
                die();
            }
        }
    } else {
        $v = "value='" . addslashes($ip_address) . "',upd_date='" . time() . "'";
        if ($clsIP->updateOne($ip_id, $v)) {
            echo 'UPDATE_SUCCESS';
            die();
        } else {
            echo 'ERROR';
            die();
        }
    }
    echo $message;
    die();
}

function default_ajaxdeleteOneIP()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
    #
    $clsIP = new IP();
    $ip_id = $_POST['ip_id'];
    $clsIP->deleteOne($ip_id);
    echo(1);
    die();
}

function default_ajaxFrmCfgIPMode()
{
    global $core;
    #
    $clsSetting = new Setting();
    $oneTable = $clsSetting->getOne(1);
    $html = '
	<div class="headPop"> 
		<a id="clickToCloseConfigBooking" href="javascript:void();" class="closeEv close_pop">&nbsp;</a> 
		<h3>Cài đặt IP Mode</h3>
	</div> 
	<div class="formatTextStandard" style="margin-bottom:10px">Chức năng tùy chọn có hay không kiểm tra IP người truy cập.</div> 
	<form method="post" class="frmform" enctype="multipart/form-data" id="frmSettingInfo">
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldlabel" width="20%">Chế độ</td>
				<td class="fieldarea">
					<label class="fl">Cho phép <input type="radio" ' . ($oneTable['config_public_mode'] == 1 ? 'checked="checked"' : '') . ' name="config_public_mode" value="1" /></label>
					<label class="fl">Không cho phép <input type="radio" ' . ($oneTable['config_public_mode'] == 0 ? 'checked="checked"' : '') . ' name="config_public_mode" value="0" /></label>
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-success ajSaveCfgIPMode">' . $core->get_Lang('Save') . '</button> 
			<button class="btn btn-warning clickToClose close_pop" data-dismiss="modal" aria-hidden="true">' . $core->get_Lang('Close') . '</button>
		</div>
	</form>';
    echo $html;
    die();
}

function default_ajaxSaveCfgIPMode()
{
    $clsSetting = new Setting();
    $oneTable = $clsSetting->getOne(1);
    #
    $clsSetting->updateOne(1, "config_public_mode='" . $_POST['config_public_mode'] . "'");
    echo(1);
    die();
}

function default_ajaxSendMailTest()
{
    global $core, $clsConfiguration, $clsISO;
    #
    $from = $clsConfiguration->getValue('SiteReplyEmail');
    $owner = PAGE_NAME;
    $to = trim($_POST['email_test']);
    $subject = $core->get_Lang('Test Email From') . ' ' . PAGE_NAME;
    $sendMail = $clsISO->sendEmail($from, $to, $subject, "111111111", $owner);
    echo json_encode($sendMail);
    die;
}

function default_pay()
{
    global $assign_list, $core, $clsConfiguration, $clsISO;
    $clsConfiguration = new Configuration();
    $assign_list['clsConfiguration'] = $clsConfiguration;
    #
    if (isset($_POST['Hid_Pay1']) && $_POST['Hid_Pay1'] = 'Hid_Pay1') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }

        if (isset($_POST['SitePay_CashStatus_Mode'])) {
            $clsConfiguration->updateValue('SitePay_CashStatus_Mode', $_POST['SitePay_CashStatus_Mode']);
        } else {
            $clsConfiguration->updateValue('SitePay_CashStatus_Mode', 0);
        }
        #-update hash onepay
        redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
    }
    if (isset($_POST['Hid_Pay2']) && $_POST['Hid_Pay2'] = 'Hid_Pay2') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        if (isset($_POST['SitePay_Bank_Mode'])) {
            $clsConfiguration->updateValue('SitePay_Bank_Mode', $_POST['SitePay_Bank_Mode']);
        } else {
            $clsConfiguration->updateValue('SitePay_Bank_Mode', 0);
        }
        #-update hash onepay
        redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
    }
    if (isset($_POST['Hid_Pay3']) && $_POST['Hid_Pay3'] = 'Hid_Pay3') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        #Paypal Mode

        if (isset($_POST['Paypal_Status_Mode'])) {
            $clsConfiguration->updateValue('Paypal_Status_Mode', $_POST['Paypal_Status_Mode']);
        } else {
            $clsConfiguration->updateValue('Paypal_Status_Mode', 0);
        }

        if (isset($_POST['Paypal_Test_Mode'])) {
            $clsConfiguration->updateValue('Paypal_Test_Mode', $_POST['Paypal_Test_Mode']);
        } else {
            $clsConfiguration->updateValue('Paypal_Test_Mode', 0);
        }
        #-update hash onepay
        redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
    }
    if (isset($_POST['Hid_Pay4']) && $_POST['Hid_Pay4'] = 'Hid_Pay4') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        #ONEPAY Status Mode

        if (isset($_POST['ONEPAY_Status_Mode'])) {
            $clsConfiguration->updateValue('ONEPAY_Status_Mode', $_POST['ONEPAY_Status_Mode']);
        } else {
            $clsConfiguration->updateValue('ONEPAY_Status_Mode', 0);
        }

        if (isset($_POST['ONEPAY_Test_Mode'])) {
            $clsConfiguration->updateValue('ONEPAY_Test_Mode', $_POST['ONEPAY_Test_Mode']);
        } else {
            $clsConfiguration->updateValue('ONEPAY_Test_Mode', 0);
        }

        #-update hash onepay
        redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
    }
    if (isset($_POST['Hid_Pay5']) && $_POST['Hid_Pay5'] = 'Hid_Pay5') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }

        if (isset($_POST['ONEPAY_Visa_Status_Mode'])) {
            $clsConfiguration->updateValue('ONEPAY_Visa_Status_Mode', $_POST['ONEPAY_Visa_Status_Mode']);
        } else {
            $clsConfiguration->updateValue('ONEPAY_Visa_Status_Mode', 0);
        }
        #ONEPAY Mode
        if (isset($_POST['ONEPAY_Visa_Test_Mode'])) {
            $clsConfiguration->updateValue('ONEPAY_Visa_Test_Mode', $_POST['ONEPAY_Visa_Test_Mode']);
        } else {
            $clsConfiguration->updateValue('ONEPAY_Visa_Test_Mode', 0);
        }
        #-update hash onepay
        redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
    }
    if (isset($_POST['Hid_Pay7']) && $_POST['Hid_Pay7'] = 'Hid_Pay7') {

        ///print_r($_POST);die('xxxxx');

        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                //print_r($tmp[1].'xxxx'.$val);
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        #Paypal Mode

        if (isset($_POST['VTCPay_Status_Mode'])) {
            $clsConfiguration->updateValue('VTCPay_Status_Mode', $_POST['VTCPay_Status_Mode']);
        } else {
            $clsConfiguration->updateValue('VTCPay_Status_Mode', 0);
        }

        if (isset($_POST['VTCPay_Test_Mode'])) {
            $clsConfiguration->updateValue('VTCPay_Test_Mode', $_POST['VTCPay_Test_Mode']);
        } else {
            $clsConfiguration->updateValue('VTCPay_Test_Mode', 0);
        }
        #-update hash onepay
        redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
    }
    if (isset($_POST['Hid_Pay8']) && $_POST['Hid_Pay8'] = 'Hid_Pay8') {

        ///print_r($_POST);die('xxxxx');

        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                //print_r($tmp[1].'xxxx'.$val);
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        #Paypal Mode

        if (isset($_POST['VNPay_Status_Mode'])) {
            $clsConfiguration->updateValue('VNPay_Status_Mode', $_POST['VNPay_Status_Mode']);
        } else {
            $clsConfiguration->updateValue('VNPay_Status_Mode', 0);
        }

        if (isset($_POST['VNPay_Test_Mode'])) {
            $clsConfiguration->updateValue('VNPay_Test_Mode', $_POST['VNPay_Test_Mode']);
        } else {
            $clsConfiguration->updateValue('VNPay_Test_Mode', 0);
        }
        #-update hash onepay
        redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
    }
}

function default_home()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting;
    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }

        $site_about_logo_home = $_POST['isoman_url_site_about_logo_home'];
        if ($site_about_logo_home != '' && $site_about_logo_home != '0') {
            $clsConfiguration->updateValue('site_about_logo_home', $site_about_logo_home);
        }

        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
    }
}
