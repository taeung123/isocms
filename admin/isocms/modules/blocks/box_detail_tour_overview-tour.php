<?php
global $smarty, $core, $clsISO;
#
$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);
#

// Mô phỏng danh sách ngôn ngữ (thay thế bằng API thực tế nếu cần)
$languages = [
    'auto' => 'Phát hiện ngôn ngữ',
    'en' => 'Tiếng Anh',
    'vi' => 'Tiếng Việt',
    'fr' => 'Tiếng Pháp',
    'es' => 'Tiếng Tây Ban Nha',
    'zh' => 'Tiếng Trung',
    'de' => 'Tiếng Đức',
    'ja' => 'Tiếng Nhật',
    'ko' => 'Tiếng Hàn',
    'ru' => 'Tiếng Nga',
    'it' => 'Tiếng Ý',
    'pt' => 'Tiếng Bồ Đào Nha',
    'ar' => 'Tiếng Ả Rập',
    'th' => 'Tiếng Thái',
    'id' => 'Tiếng Indonesia',
    'nl' => 'Tiếng Hà Lan',
];
//$assign_list["languages"] = $languages;
$smarty->assign('languages', $languages);

//$clsISO::dump($languages);



?>