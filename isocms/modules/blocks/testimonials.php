<?php 
	global $core, $smarty, $_LANG_ID;
	#
	$clsTestimonial=new Testimonial();$smarty->assign('clsTestimonial',$clsTestimonial);
	$lstTestimonial = $clsTestimonial->getAll("is_trash=0 and is_online=1 and image<>'' order by order_no asc limit 0,4",$clsTestimonial->pkey.",reg_date");
	$smarty->assign('lstTestimonial',$lstTestimonial); unset($lstTestimonial);
?>