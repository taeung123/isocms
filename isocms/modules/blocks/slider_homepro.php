<?php
global $assign_list,$mod, $act, $core, $oneConfiguration, $smarty;

$clsSlide=new Slide(); $smarty->assign("clsSlide",$clsSlide);

$listSlide = $clsSlide->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsSlide->pkey.",title,text,link");
$smarty->assign('listSlide',$listSlide);
?>