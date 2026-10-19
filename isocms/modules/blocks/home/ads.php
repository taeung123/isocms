<?php
global $smarty, $clsISO, $package_id;
$listAdsHome = [];
if ($clsISO->getCheckActiveModulePackage($package_id, 'ads', 'default', 'default')) {
    $clsAds = new Ads();
    $smarty->assign('clsAds', $clsAds);
    $listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey . ',image');
}

$smarty->assign('listAdsHome', $listAdsHome);
