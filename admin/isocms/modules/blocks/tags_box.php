<?php
global $smarty, $core, $mod, $_LANG_ID;
# 
$clsTagBlog = new TagBlog();
$smarty->assign('clsTagBlog', $clsTagBlog);
$blog_id =(isset($_GET['blog_id']))?$_GET['blog_id']:0;
$smarty->assign('blog_id', $blog_id);

$listTag = $clsTagBlog->getAll("blog_id=".$blog_id."");
$smarty->assign('listTag', $listTag);
#
$clsTag = new Tag();
$smarty->assign('clsTag', $clsTag);
$listAllTag = $clsTag->getAll("is_trash=0 order by title asc limit 0,50");
$listAvailableTag = '<script type="text/javascript">var availableTags = [';
for ($i = 0; $i < count($listAllTag); $i++) {
      $listAvailableTag .= '{ name: "' . $listAllTag[$i]['title'] . '", val: "' . $listAllTag[$i]['title'] . '" },';
}
$listAvailableTag .= '];</script>';
$smarty->assign('listAvailableTag', $listAvailableTag);    
?>
