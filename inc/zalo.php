<?php
	ini_set('display_errors',1);
error_reporting(E_ERROR & ~E_STRICT);//E_ALL
use Zalo\\Zalo;
$config = array(
        'app\_id' => '1234567890987654321',
        'app\_secret' => 'AbC123456XyZ'
    );
    $zalo = new Zalo($config);

$helper = $zalo -> getRedirectLoginHelper();
$callbackUrl = "https://www.callbackack.com";
$codeChallenge = "your code challenge";
$state = "your state";
$loginUrl = $helper->getLoginUrl($callBackUrl, $codeChallenge, $state);
    
     print_r($loginUrl);die();
?>