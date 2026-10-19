<?php
	global $smarty,$core, $mod, $act, $_LANG_ID,$clsISO;
	$htmlBlog = file_get_contents('https://www.vietiso.com/blog_feed.php');
	$smarty->assign('htmlBlog',$htmlBlog);
?>