<?php
global $core, $smarty,$clsISO,$package_id;
#
if($clsISO->getCheckActiveModulePackage($package_id,'testimonial','default','default')){
	$clsTestimonial=new Testimonial();$smarty->assign('clsTestimonial',$clsTestimonial);
	$lstTestimonial = $clsTestimonial->getAll("is_trash=0 and is_online = 1 and image<>'' order by order_no ASC limit 0,9",$clsTestimonial->pkey.",title,reg_date,slug,intro,name,rates");
	$smarty->assign('lstTestimonial',$lstTestimonial); unset($lstTestimonial);
}
?>