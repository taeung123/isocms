<?php
global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $package_id, $smarty;
global $clsConfiguration, $lang_sql;

//    List Testimonial
$clsTestimonial = new Testimonial();
$smarty->assign('clsTestimonial', $clsTestimonial);

$lstTestimonial = $clsTestimonial->getAll("is_trash=0 and is_online = 1 and image<>'' order by order_no ASC limit 0,9", $clsTestimonial->pkey . ",title,reg_date,slug,intro,name,rates");
$smarty->assign('lstTestimonial', $lstTestimonial);
unset($lstTestimonial);
