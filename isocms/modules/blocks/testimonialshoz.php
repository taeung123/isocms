<?php 
	global $core, $smarty;
	#
	$clsTestimonial=new Testimonial();$smarty->assign('clsTestimonial',$clsTestimonial);
	$lstTestimonial = $clsTestimonial->getAll("is_trash=0 and image<>'' order by reg_date desc limit 0,4",$clsTestimonial->pkey.",reg_date");
	$smarty->assign('lstTestimonial',$lstTestimonial); unset($lstTestimonial);
?>