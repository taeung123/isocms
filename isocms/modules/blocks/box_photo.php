<?php 
	function isocms_block_photo($_args = array()){
		global $assign_list,$mod, $act, $core, $oneConfiguration, $smarty;
		#		
		$lstImage = $clsTourImage->getAll("is_trash=0 and table_id='$tour_id' and image<>'' order by order_no desc");
	
		$smarty->assign("lstImage",$lstImage);
		//print_r($lstSlide); die();

	}
?>