<?php 
	function defaultblock_sliderhomepage($params){
		global $assign_list,$mod, $act, $core, $oneConfiguration, $smarty;
		#assign variables
		extract($params);
		$clsSlide= new Slide();$smarty->assign('clsSlide',$clsSlide); 
		$listSlide = $clsSlide->getAll("is_trash=0 and is_online=1 and mod_page='home' order by order_no asc", $clsSlide->pkey);
		$smarty->assign('listSlide',$listSlide);
	}
?>