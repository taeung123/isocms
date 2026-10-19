<?php
global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $package_id, $smarty;
global $clsConfiguration, $lang_sql;
#
$clsTestimonial = new Testimonial();
$smarty->assign('clsTestimonial',$clsTestimonial);
#
$cond = "is_trash=0 and is_online=1";
$order_by = " ORDER BY order_no ASC";
$limit = " LIMIT 20";
#
$arr_country_testimonial = $clsTestimonial->getAll("$cond $order_by $limit", "$clsTestimonial->pkey");
$smarty->assign('arr_country_testimonial',$arr_country_testimonial);

?>