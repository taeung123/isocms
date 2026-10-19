<?php if(!defined('ABSPATH')) exit('No direct script access allowed');

/*======================================================================//

|| # The Classes configurations of the ISOCMS                         # ||

|| # ISOCMS 6.0.0 VietISO Team (support@vietiso.com)                  # ||

|| # ---------------------------------------------------------------- # ||

|| # All PHP code in this file is ©2007-2023 VietISO JSC.             # ||

|| # This file may not be redistributed in whole or significant part. # ||

|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||

|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||

//======================================================================*/

function ticket_add_ticket(){
	global $smarty,$core,$dbconn,$_LANG_ID,$deviceType,$clsISO,$clsConfiguration;
	
	/** Valid method request*/
	//Api::getInstance()->valid_method(array('POST'));
	$raws_input = file_get_contents('php://input');
    $raws_input = html_entity_decode($raws_input);
    $params = @json_decode($raws_input, true);
	//$clsISO->pre($params);die;
	//$ym = Api::getInstance()->getParam($params, 'ym', 0);
	//$ticket_id = Api::getInstance()->getParam($params, 'ticket_id', 0);
	//$oneTicket = Api::getInstance()->getParam($params, 'oneTicket', 0);
	$ym = isset($params['ym']) ? $params['ym'] : 0;
	$ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : 0;
	$oneTicket = isset($params['oneTicket']) ? $params['oneTicket'] : 0;
	
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	if(@file_exists(DIR_INCLUDES.'/json_master/autoload.php')){
		require_once(DIR_INCLUDES.'/json_master/autoload.php');
	}
	$isocms_ticket[$ticket_id] = $oneTicket;
	#
	$file_cached = DIR_JSON_TICKET.'isocms_ticket_'.$ym.'.json';
	$encoder = new Webmozart\Json\JsonEncoder();
	$encoder->encodeFile($isocms_ticket, $file_cached);
	#
	/*$clsNotification = new Notification();
	$content = 'VietISO tạo ticket mới <a href="'.$oneTicket['domain_name'].'admin/detail_ticket/'.$ticket_id.'" target="_blank">#'.$oneTicket['code'].'</a>';
	
	$notification_id = $clsNotification->getMaxId();
	$clsNotification->insert(array(
		'notification_id'	=> $notification_id,
		'user_id'	=> 0,
		'tp'	=> 'ticket',
		'ticket_id'	=> $ticket_id,
		'title'	=> '[VietISO] tạo Ticket mới #'.$oneTicket['code'],
		'content'	=> $content,
		'list_user_id'	=> 1,
		'list_user_id_slash'	=> '|1|',
		'reg_date'	=> time()
	));*/
	$apiresults = array(
		'result' => 'success',
		'ticket_id' => $ticket_id,
		'message' => __('success')
	);
	//Api::getInstance()->echoResponse(200, $apiresults);
	Response::echoResponse(200, $apiresults, 'application/json');
}
function ticket_reply_ticket(){
	global $smarty,$core,$dbconn,$_LANG_ID,$deviceType,$clsISO,$clsConfiguration;
	
	/** Valid method request*/
	//Api::getInstance()->valid_method(array('POST'));
	$raws_input = file_get_contents('php://input');
    $raws_input = html_entity_decode($raws_input);
    $params = @json_decode($raws_input, true);
	//$clsISO->pre($params);die;
	//$ym = Api::getInstance()->getParam($params, 'ym', 0);
	//$ticket_id = Api::getInstance()->getParam($params, 'ticket_id', 0);
	//$reply_id = Api::getInstance()->getParam($params, 'reply_id', 0);
	//$oneReply = Api::getInstance()->getParam($params, 'oneReply', 0);
	$ym = isset($params['ym']) ? $params['ym'] : 0;
	$ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : 0;
	$reply_id = isset($params['reply_id']) ? $params['reply_id'] : 0;
	$oneReply = isset($params['oneReply']) ? $params['oneReply'] : 0;
	
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	if(@file_exists(DIR_INCLUDES.'/json_master/autoload.php')){
		require_once(DIR_INCLUDES.'/json_master/autoload.php');
	}
	$oneTicket = $isocms_ticket[$ticket_id];	
	$oneTicket['status'] = '2answered';
	$oneTicket['upd_date'] = time();
	$oneTicket['user_read'] = array();
	$isocms_ticket[$ticket_id] = $oneTicket;
	#
	$isocms_ticket[$reply_id] = $oneReply;
	#
	$file_cached = DIR_JSON_TICKET.'isocms_ticket_'.$ym.'.json';
	$encoder = new Webmozart\Json\JsonEncoder();
	$encoder->encodeFile($isocms_ticket, $file_cached);
	#
	/*$clsEmail = new Email();
	$clsNotification = new Notification();
	$content = 'VietISO đã trả lời ticket <a href="'.$oneTicket['domain_name'].'admin/detail_ticket/'.$ticket_id.'" target="_blank">#'.$oneTicket['code'].'</a>';
	
	$notification_id = $clsNotification->getMaxId();
	$clsNotification->insert(array(
		'notification_id'	=> $notification_id,
		'user_id'	=> 0,
		'tp'	=> 'ticket',
		'ticket_id'	=> $ticket_id,
		'title'	=> '[VietISO] Trả lời Ticket #'.$oneTicket['code'],
		'content'	=> $content,
		'list_user_id'	=> $oneTicket['user_id'],
		'list_user_id_slash'	=> '|'.$oneTicket['user_id'].'|',
		'reg_date'	=> time()
	));*/
	#send mail
	/*$oneBrand = $clsISO->getOneBrandUser(null,$oneTicket['user_id']);
	$oneBrand = $oneBrand['oneBrand'];
	$email = $clsUser->getEmail($oneUser['user_id'],$oneUser);
	$to = $email;
	$name = $clsUser->getFullName($oneUser['user_id'],$oneUser);
	$subject = '[VietISO] Trả lời Ticket #'.$oneTicket['code'];
	#
	$footer_email = $clsISO->parseImageInContent($oneBrand['footer_email']);
	$info_social = $clsEmail->getInfoSocial($oneBrand);
	$info_license = $clsEmail->getInfoLicense($oneBrand);
	$link_web_version = '';
	$merge_fields = array(
		'[%info_social%]' => $info_social,
		'[%recipient_email%]' => $to,
		'[%company_address%]' => $oneBrand['CompanyAddress'],
		'[%info_license%]' => $info_license,
		'[%link_web_version%]' => $link_web_version,
		'[%company_website%]' => $oneBrand['website'],
		'[%company_name%]' 	=> $oneBrand['CompanyName'],
		'[%company_phone%]' => $oneBrand['phone'],
		'[%company_email%]' => $oneBrand['email'],
	);
	foreach($merge_fields as $key => $val){
		$footer_email = str_replace($key, $val, $footer_email);
	}
	$message = $clsEmail->getMessageGolbal();
	$merge_fields = array(
		'[%brand_header_email%]' => $clsISO->parseImageInContent($oneBrand['header_email']),
		'[%tem_msg%]' => $content,
		'[%brand_footer_email%]' => $footer_email,
		'[%link_reg%]' => '',
	);
	foreach($merge_fields as $key => $val){
		$message = str_replace($key, $val, $message);
	}
	$message = html_entity_decode($message);
	$from = $clsConfiguration->getValue('SystemEmailsFromEmail');
	$owner = $clsConfiguration->getValue('SystemEmailsFromName');
	$is_send_email = $clsEmail->sendEmailSystem($from,$to,'['.DOMAIN_SESSION.']'.$subject,$message,$owner, $name);*/
	$apiresults = array(
		'result' => 'success',
		'ticket_id' => $ticket_id,
		'is_send_email' => $is_send_email,
		'message' => __('success')
	);
	//Api::getInstance()->echoResponse(200, $apiresults);
	Response::echoResponse(200, $apiresults, 'application/json');
}
function ticket_change_status_ticket(){
	global $smarty,$core,$dbconn,$_LANG_ID,$deviceType,$clsISO,$clsConfiguration;
	
	/** Valid method request*/
	//Api::getInstance()->valid_method(array('POST'));
	$raws_input = file_get_contents('php://input');
    $raws_input = html_entity_decode($raws_input);
    $params = @json_decode($raws_input, true);
	//$clsISO->pre($params);die;
	//$ym = Api::getInstance()->getParam($params, 'ym', 0);
	//$ticket_id = Api::getInstance()->getParam($params, 'ticket_id', 0);
	//$status = Api::getInstance()->getParam($params, 'status', 0);
	$ym = isset($params['ym']) ? $params['ym'] : 0;
	$ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : 0;
	$status = isset($params['status']) ? $params['status'] : 0;
	#
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	if(@file_exists(DIR_INCLUDES.'/json_master/autoload.php')){
		require_once(DIR_INCLUDES.'/json_master/autoload.php');
	}
	$oneTicket = $isocms_ticket[$ticket_id];	
	$oneTicket['status'] = $status;
	$oneTicket['upd_date'] = time();
	$oneTicket['user_read'] = array();
	$isocms_ticket[$ticket_id] = $oneTicket;
	#
	$file_cached = DIR_JSON_TICKET.'isocms_ticket_'.$ym.'.json';
	$encoder = new Webmozart\Json\JsonEncoder();
	$encoder->encodeFile($isocms_ticket, $file_cached);
	#
	$apiresults = array(
		'result' => 'success',
		'ticket_id' => $ticket_id,
		'message' => __('success')
	);
	//Api::getInstance()->echoResponse(200, $apiresults);
	Response::echoResponse(200, $apiresults, 'application/json');
}
?>