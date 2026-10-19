<?php 
	function isocms_block_banner($_args = array()){
		global $assign_list,$mod, $act, $core, $oneConfiguration, $smarty;
		#
		extract($_args);
		$clsSlide=new Slide(); $smarty->assign("clsSlide",$clsSlide);
		$clsCountryEx=new Country();$smarty->assign('clsCountryEx',$clsCountryEx);
		$clsCity=new City();$smarty->assign('clsCity',$clsCity);
		$clsTourCategory=new TourCategory();$smarty->assign('clsTourCategory',$clsTourCategory);
		#
		$curl = PCMS_URL.$_SERVER['REQUEST_URI'];
		$curl = str_replace(PCMS_URL."/",PCMS_URL,$curl);
		$cond = "is_trash=0 and is_online=1 and type = '_CHILD_SLIDE' and link = '$curl' order by order_no desc limit 0,1";
		#
		$lstSlide = $clsSlide->getAll($cond);
		$smarty->assign("lstSlide",$lstSlide); unset($lstSlide);
	}
	#
	global $smarty, $mod, $act;
	$site_tour_banner = 'site_'.$mod.'_banner';
	$smarty->assign("site_tour_banner",$site_tour_banner); unset($site_tour_banner);
?>