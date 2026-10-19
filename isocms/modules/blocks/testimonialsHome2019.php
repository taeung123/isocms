<?php 
	global $core, $smarty;
	#
	$clsTestimonial=new Testimonial();$smarty->assign('clsTestimonial',$clsTestimonial);
	$lstTestimonial = $clsTestimonial->getAll("is_trash=0 and is_online = 1 and image<>'' order by order_no ASC limit 0,5",$clsTestimonial->pkey.",title,reg_date");
	$smarty->assign('lstTestimonial',$lstTestimonial); unset($lstTestimonial);
?>