<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	
	$sql_tour="INSERT INTO default_tour(tour_id, user_id, user_id_update, cat_id, list_cat_id, title, slug, intro, image, number_day, number_night, duration_type, duration_custom, trip_code, departure_point_id, highlight, inclusion, exclusion, information, overview, key_information, stay, meal, thing_to_carry, cancellation_policy, refund_policy, confirmation_policy, activity, advisory, map_zoom, file_programme, reg_date, upd_date, order_no)
	SELECT tour_id, user_id, user_id_update, cat_id, list_cat_id, title, slug, intro, image, number_day, number_night, duration_type, duration_custom, trip_code, departure_point_id, highlight, inclusion, exclusion, information, overview, key_information, stay, meal, thing_to_carry, cancellation_policy, refund_policy, confirmation_policy, activity, advisory, map_zoom, file_programme, reg_date, upd_date, order_no
	FROM default_tour_old";	
	
	$sql="INSERT INTO default_videos(video_id, user_id, image, video_url, order_no, reg_date, upd_date)
	SELECT video_id, user_id, image, link, order_no, reg_date, upd_date
	FROM default_video";	
}

?>