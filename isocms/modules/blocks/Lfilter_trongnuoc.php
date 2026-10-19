
<?php 
global $mod,$act,$assign_list, $act,$dbconn,$show,$smarty, $core,$extLang,$_lang, $clsISO,$cat_id,$cat_ID,$city_id,$country_id,$clsConfiguration,$duration_ID,$price_range_ID;
	
if(isset($_POST['search_des']) &&  $_POST['search_des']=='search_des'){

	$link= '/tim-kiem-tours';

	if(!empty($_POST['all'])) {

		$link.=(!empty($_POST['all']))?'?all='.$_POST['all']:'';
	} else {
		$prefix = '?';
		if (!empty($_POST['country_id'])) {
			$link .= "{$prefix}country_id={$clsISO->makeSlashListFromArrayComma($_POST['country_id'])}";
			$prefix = '&';
		}

		if (!empty($_POST['city_id'])) {
			$link .= "{$prefix}city_id={$clsISO->makeSlashListFromArrayComma($_POST['city_id'])}";
			$prefix = '&';
		}

		if (!empty($_POST['tourcat_id'])) {
			$link .= "{$prefix}tourcat_id={$clsISO->makeSlashListFromArrayComma($_POST['tourcat_id'])}";
			$prefix = '&';
		}

		if (!empty($_POST['min_duration'])) {
			$link .= "{$prefix}min_duration={$_POST['min_duration']}";
			$prefix = '&';
		} else {
			$link .= "{$prefix}min_duration=0";
			$prefix = '&';
		}

		if (!empty($_POST['max_duration'])) {
			$link .= "{$prefix}max_duration={$_POST['max_duration']}";
			$prefix = '&';
		} else {
			$link .= "{$prefix}max_duration=0";
			$prefix = '&';
		}

		if (!empty($_POST['min_price'])) {
			$link .= "{$prefix}min_price={$_POST['min_price']}";
			$prefix = '&';
		} else {
			$link .= "{$prefix}min_price=0";
			$prefix = '&';
		}

		if (!empty($_POST['max_price'])) {
			$link .= "{$prefix}max_price={$_POST['max_price']}";
		} else {
			$link .= "{$prefix}max_price=0";
		}

	}
	header('location:'.trim($link));
	exit();
}
