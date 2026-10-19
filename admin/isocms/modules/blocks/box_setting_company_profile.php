<?php

global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $sub, $action, $clsISO;
global $core, $clsModule, $clsButtonNav, $clsISO, $clsConfiguration;

#
$smarty->assign('clsConfiguration', $clsConfiguration);
$clsProperty = new Property();
#
$allUnitProperty = $clsProperty->getAll("is_trash=0 and type='_CRM_CURRENCY' order by order_no DESC");
$smarty->assign('allUnitProperty', $allUnitProperty);

$openTime = $_POST['hours_open']; // Ví dụ: "08:00"
$closeTime = $_POST['hours_closing']; // Ví dụ: "17:30"

// Giả sử giá trị giờ mở và đóng cửa từ Cấu hình
$openingHours = $clsConfiguration->getValue('CompanyOpeningHours');  // Lấy giá trị từ database ví dụ: "8h00 - 17h30"

// Tách dữ liệu thành 2 phần: giờ mở cửa và giờ đóng cửa
list($openTime, $closeTime) = explode(' - ', $openingHours);

// Chuyển đổi giờ mở và giờ đóng cửa từ "8h00" thành "08:00"
$openTime = str_pad(explode('h', $openTime)[0], 2, '0', STR_PAD_LEFT) . ':' . explode('h', $openTime)[1];
$closeTime = str_pad(explode('h', $closeTime)[0], 2, '0', STR_PAD_LEFT) . ':' . explode('h', $closeTime)[1];


// Gán giờ mở cửa và đóng cửa vào biến Smarty
$smarty->assign('openTime', $openTime);
$smarty->assign('closeTime', $closeTime);

