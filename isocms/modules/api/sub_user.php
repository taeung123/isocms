<?php
function user_login(){
	global $smarty,$core,$dbconn,$_LANG_ID,$deviceType,$clsISO,$clsConfiguration;
	$raws_input = file_get_contents('php://input');
	$raws_input = stripslashes(html_entity_decode($raws_input));
	$params = @json_decode($raws_input, true);
    
	$username = isset($params['username']) ? $params['username'] : "";
	$password = isset($params['password']) ? $params['password'] : "";
	$first_name = isset($params['first_name']) ? $params['first_name'] : "";
	$last_name = isset($params['last_name']) ? $params['last_name'] : "";
    $check='';
   
    $clsUser=new User();

    $allUser=$clsUser->getAll("user_name='$username' and type=''");
    if(!empty($allUser)){
        $link_admin=DOMAIN_NAME."/admin/index.php?mod=login";
        Response::echoResponse(200, array(
			'result' => 'exist_user',
			'link_admin' => $link_admin,
		), 'application/json'); die();
    }
    
    $allUser=$clsUser->getAll("user_name='$username'");
    if(empty($allUser)  && !empty($username)){
        $f = "user_id,user_name,email,first_name,last_name,user_group_id,is_active,user_pass,is_super,reg_date,upd_date,type";
        $v = "'".$clsUser->getMaxId()."','".addslashes($username)."','".addslashes($username)."','".addslashes($first_name)."','".addslashes($last_name)."','1','1','".$clsUser->encrypt($password)."','0','".time()."','".time()."','OKRS'";
        $clsUser->insertOne($f,$v);
        $check='insert';
    }
    
    $allUser=$clsUser->getAll("user_name='$username' and user_pass <> '".$clsUser->encrypt($password)."' and type='OKRS'");
    
    if(!empty($allUser)){
        $user_id=$allUser[0]['user_id'];
        $set = "user_pass='".$clsUser->encrypt($password)."',upd_date='".time()."'";
        $clsUser->updateOne($user_id,$set);
    }
    
	#
	$btnLogin = 1;
	$txtUsername = $username? $username : "";
	$txtPassword = $password? $password : "";
	$isValid = 1;
	if (!empty($btnLogin)){
		$isValid = ($txtUsername!="" && $txtPassword!="");
		if ($isValid){ 
			if ($core->_SESS->checkUser($txtUsername, $txtPassword)){
				$isValid = 1;
                $link_admin=DOMAIN_NAME."/admin/index.php?mod=login&login_via_okrs=1&user_name=".$core->encryptID($txtUsername)."&user_pass=".$core->encryptID($txtPassword)."";
			}else{
				$isValid = 0;
			}
		}
	}
    
    if(!empty($isValid)){
		Response::echoResponse(200, array(
			'result' => 'success',
			'username' => $username,
			'password' => $password,
			'link_admin' => $link_admin,
			'check' => $check,
		), 'application/json'); die();
	} else {
		Response::echoResponse(200, array(
			'result' => 'error',
			'message' => $core->get_Lang('Login Error')
		), 'application/json'); die();
	}  
	
}

function user_delete(){
	global $smarty,$core,$dbconn,$_LANG_ID,$deviceType,$clsISO,$clsConfiguration;
	#
	$raws_input = file_get_contents('php://input');
	$raws_input = stripslashes(html_entity_decode($raws_input));
	$params = @json_decode($raws_input, true);
    
    
	$username = isset($params['username']) ? $params['username'] : "";
    $clsUser=new User();
    
    $allUser=$clsUser->getAll("user_name='$username' and type='OKRS'");
    if(!empty($allUser)){
        $user_id=$allUser[0]['user_id'];
        $clsUser->deleteOne($user_id);
        return 1;
    }
    return 0; 	
}

?>
