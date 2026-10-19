<?php 
	function isocms_block_signin($_args = array()){
		global $assign_list,$mod, $act, $core, $oneConfiguration, $smarty;
		#
		$clsProfile = new Profile();
		$profile_id = '';	
		if( isset( $_SESSION['profile_id'] ) ){
			$profile_id = $_SESSION['profile_id'];
		}		
		$smarty->assign("clsProfile",$clsProfile);
		$smarty->assign("profile_id",$profile_id);
		$smarty->assign("IMG_LOGIN_FACEBOOK",IMG_LOGIN_FACEBOOK);
		$smarty->assign("IMG_LOGIN_GOOGLE",IMG_LOGIN_GOOGLE);
		$smarty->assign("IMG_LOGIN_YAHOO",IMG_LOGIN_YAHOO);
		$smarty->assign("IMG_LOGIN_TWITTER",IMG_LOGIN_TWITTER);
		//print_r($lstSlide); die();

	}
?>