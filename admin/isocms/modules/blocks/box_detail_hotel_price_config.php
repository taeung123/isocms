<?php
global $clsISO, $core, $mod, $act, $smarty, $package_id;
#
$table_id = !empty($_POST['table_id']) ? $_POST['table_id'] : 0;
$step_id = !empty($_POST['step_id']) ? $_POST['step_id'] : 0;
#
$clsHotel = new Hotel();
$clsHotelRoom = new HotelRoom();
$clsHotelPackage = new HotelPackage();

#Danh sach phong khach san
$lstHotelRooms = $clsHotelRoom->getAll("hotel_id=$table_id AND is_trash=0 ORDER BY order_no DESC", $clsHotelRoom->pkey . ',title');

#Danh sach package
if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'hotel_packages', 'customize')) {
    $lstPackages = $clsHotelPackage->getAll("is_trash=0 AND is_online=1 ORDER BY order_no DESC", $clsHotelPackage->pkey . ',title');
    $smarty->assign('lstPackages', $lstPackages);
}
