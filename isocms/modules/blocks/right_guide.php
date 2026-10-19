<?php 
	global $show,$city_id,$country_id;
	$clsBlogCategory = new BlogCategory(); 
	$smarty->assign('clsBlogCategory',$clsBlogCategory);
	$clsGuideCat = new GuideCat(); 
	$smarty->assign('clsGuideCat',$clsGuideCat);
	$clsISO = new ISO(); 
	$smarty->assign('clsISO',$clsISO);
	$clsHotelRoom= new HotelRoom(); 
	$smarty->assign('clsHotelRoom',$clsHotelRoom);
	$clsBlog = new Blog(); $smarty->assign('clsBlog',$clsBlog);
	$clsGuide = new Guide(); $smarty->assign('clsGuide',$clsGuide);
	$clsTag = new Tag(); $smarty->assign('clsTag',$clsTag);
	$clsHotel= new Hotel(); $smarty->assign('clsHotel',$clsHotel);
	$clsTagModule = new TagModule(); $smarty->assign('clsTagModule',$clsTagModule);
	$clsTour = new Tour(); $smarty->assign('clsTour',$clsTour);
	$clsPromotion = new Promotion(); $smarty->assign('clsPromotion',$clsPromotion);
	
	$cond = "is_trash=0 and is_online=1";
	
	if($city_id >0){
		$cond.= " and tour_id in (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id' and city_id='$city_id')";
	}else{
		$cond.= " and tour_id in (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id')";
	}
	
	$order_by = " order by order_no ASC limit 0,5";
	
	$listTourPlace=$clsTour->getAll($cond.$order_by,$clsTour->pkey.",title,slug,duration_type,duration_custom,number_day,number_night,list_departure_point_id,image");


	$smarty->assign('listTourPlace',$listTourPlace);
	
	$lstCategory = $clsBlogCategory->getAll("is_trash=0 order by order_no asc");
	$smarty->assign('lstCategory',$lstCategory);

	$listTag = $clsTag->getAll("tag_id IN (SELECT tag_id FROM ".DB_PREFIX."tag_module WHERE 1=1 and type='GUIDE')");
	if(is_array($listTag) && count($listTag) > 0){
		$lstTag = array();
		foreach($listTag as $k => $v){
			$lstTag[] = array(
				'tag_id'	=> $v['tag_id'],
				'number'	=> $clsTagModule->countItem("type='GUIDE' and tag_id='".$v['tag_id']."'"),
				'class'		=>	random_tags()
			);
		}
	}
	$smarty->assign('lstTag',$lstTag);
	
	//print_r($lstTag); die();
	#
	function random_tags(){
		$_array = array('tag_11','tag_12','tag_13','tag_14','tag_16','tag_20','tag_21','tag_24','tag_36');
		return $_array[array_rand($_array)];
	}

?>