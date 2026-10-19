<?php
global $smarty,$core, $mod, $act, $_LANG_ID,$clsISO;

$clsHotel = new Hotel(); $smarty->assign('clsHotel',$clsHotel);
$listAllHotel=$clsHotel->getAll("is_trash=0 and is_online=1 order by order_no ASC",$clsHotel->pkey);
$smarty->assign('listAllHotel',$listAllHotel);
?>