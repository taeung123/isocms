
<?php 
global $mod,$act,$assign_list, $act,$dbconn,$show,$smarty, $core,$extLang,$_lang,$clsISO,$clsConfiguration;
	#
	if(isset($_POST['search_des']) &&  $_POST['search_des']=='search_des'){
		$link= $clsISO->getLink('search_combo');
		if(!empty($_POST['all'])) {
			$link.=(!empty($_POST['all']))?'&all='.$_POST['all']:'';
		}else{
	
			$link.=(!empty($_POST['city_id']))?'&city_id='.$clsISO->makeSlashListFromArrayComma($_POST['city_id']):'';
			
			$link.=(!empty($_POST['voucher_cat_id']))?'&voucher_cat_id='.$clsISO->makeSlashListFromArrayComma($_POST['voucher_cat_id']):'';
			
			$link.=(!empty($_POST['min_price']))?'&min_price='.$_POST['min_price']:'&min_price=0';
			
			$link.=(!empty($_POST['max_price']))?'&max_price='.$_POST['max_price']:'&max_price=0';
		}
		header('location:'.trim($link));
		exit();
	}
?>