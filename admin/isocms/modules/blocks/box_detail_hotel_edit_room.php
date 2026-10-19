<?php
global $smarty, $core, $mod, $act, $_LANG_ID, $clsISO, $hotel_room_id, $pvalTable;

#

$clsPagination = new Pagination();
$clsCountry = new Country();
$clsHotel = new Hotel();
$smarty->assign('clsHotel', $clsHotel);
$clsHotelRoom = new HotelRoom();
$smarty->assign('clsHotelRoom', $clsHotelRoom);

$table_id = Input::post('table_id', 0);
$smarty->assign('table_id', $table_id);

$hotel_room_id = Input::post('hotel_room_id', 0);
$smarty->assign("hotel_room_id", $hotel_room_id);


if (!empty($hotel_room_id)) {
    $oneItem = $clsHotelRoom->getOne($hotel_room_id);
    $smarty->assign('oneItem', $oneItem);

    $number_adult = $oneItem['number_adult'];
    $smarty->assign('number_adult', $number_adult);
    $number_child = $oneItem['number_children'];
    $smarty->assign('number_child', $number_child);
    $bed_option = $oneItem['bed_option'];
    $bed_option = json_decode($bed_option ?? '', true);
    $smarty->assign('bed_option', $bed_option);
}

$clsProperty = new Property();
$smarty->assign('clsProperty', $clsProperty);

$listTypeBed = $clsProperty->getAll("is_trash=0 and type='TypeBed' order by order_no ASC", $clsProperty->pkey);
$smarty->assign('listTypeBed', $listTypeBed);

$listRoomFacilities = $clsProperty->getAll("is_trash=0 and is_favorite=1 and type='RoomFacilities' order by order_no ASC", $clsProperty->pkey);
$smarty->assign('listRoomFacilities', $listRoomFacilities);

$fill_bed_name_select_box = '';
foreach ($listTypeBed as $item) {
    $fill_bed_name_select_box .= '<option value="' . $item['property_id'] . '">' . $clsProperty->getTitle($item['property_id']) . '</option>';
}
$smarty->assign('fill_bed_name_select_box', $fill_bed_name_select_box);


$fill_bed_number_select_box = '';
for ($i = 0; $i < 5; $i++) {
    $fill_bed_number_select_box .= '<option value="' . $i . '">' . $i . '</option>';
}
$smarty->assign('fill_bed_number_select_box', $fill_bed_number_select_box);


$tp = Input::post('tp', '');
$smarty->assign('tp', $tp);
