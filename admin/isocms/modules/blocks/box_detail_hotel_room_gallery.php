<?php
global $smarty,$core, $clsISO;

$clsHotelRoomImage = new HotelRoomImage();
$smarty->assign('HotelRoomImage', $clsHotelRoomImage);

$clsTable = 'HotelRoomImage';
$smarty->assign([
    "classTable" => $clsTable,
    "clsTable" => $clsTable
]);


?>