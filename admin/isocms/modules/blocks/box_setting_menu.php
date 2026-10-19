<?php

global $action, $core, $smarty, $clsISO;
#
$smarty->assign('action', $action);
$clsAdminButton = new AdminButton();
#
$link_page = '/admin/homenew2024/setting/' . $action;

$oneButtonItem = $clsAdminButton->getByCond("_type='_SETTING' AND is_trash=0 and is_active=1 and url_page='" . $link_page . "' order by order_no asc", $clsAdminButton->pkey . ', title_page, mod_page, act_page, url_page, parent_id');

$parent_active = $oneButtonItem['parent_id'];
$button_active = $oneButtonItem[$clsAdminButton->pkey];
#

#Danh sach menu
$lstMenu = $clsAdminButton->getAll("_type='_SETTING' AND is_trash=0 and is_active=1 and parent_id=0 order by order_no asc", $clsAdminButton->pkey . ', title_page, mod_page, act_page, url_page');

foreach ($lstMenu as $key => $item) {
    if (!empty($action)) {
        if ($parent_active == $item[$clsAdminButton->pkey]) {
            $lstMenu[$key]['parent_active'] = 1;
        }
    } else {
        if ($key == 0) {
            $lstMenu[$key]['parent_active'] = 1;
        }
    }

    $menuItem = $clsAdminButton->getAll("_type='_SETTING' AND is_trash=0 and is_active=1 and parent_id='" . $item['adminbutton_id'] . "' order by order_no asc", $clsAdminButton->pkey . ', title_page, mod_page, act_page, url_page');
    $lstMenu[$key]['menuItem'] = $menuItem;
}

$smarty->assign('lstMenu', $lstMenu);
$smarty->assign('button_active', $button_active);
