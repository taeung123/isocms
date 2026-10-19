<?php
global $smarty,$_CONFIG,$core,$dbconn,$mod,$act,$_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO,$package_id;
global $clsConfiguration, $lang_sql;

$clsCountryEx = new Country();
$smarty->assign('clsCountryEx', $clsCountryEx);
$cond = "is_trash=0 and is_online=1";

//List Top Destination
$clsCityStore = new CityStore();
$smarty->assign('clsCityStore', $clsCityStore);
$cond_top = "is_trash=0 and type='TOP'";
if(isset($_GET['slug_country']) && !empty($_GET['slug_country'])) {
    $slug_country = $_GET['slug_country'];
    $country_id = $clsCountryEx->getBySlug($slug_country);
    $cond.= " and country_id = '$country_id'";
}

$sql_top_city="SELECT ".DB_PREFIX."city.city_id,".DB_PREFIX."city.title,".DB_PREFIX."city.slug,".DB_PREFIX."city.image,".DB_PREFIX."city.country_id FROM ".DB_PREFIX."city INNER JOIN ".DB_PREFIX."citystore ON ".DB_PREFIX."city.city_id = ".DB_PREFIX."citystore.city_id AND ".DB_PREFIX."citystore.type='TOP' AND ".DB_PREFIX."citystore.lang_id='$lang_sql' AND ".DB_PREFIX."city.lang_id='$lang_sql' AND ".DB_PREFIX."city.is_online = 1 AND ".DB_PREFIX."city.is_trash = 0 ORDER BY ".DB_PREFIX."city.title ASC";

$listTopDestination=$dbconn->getAll($sql_top_city);
$smarty->assign('listTopDestination', $listTopDestination);
unset($listTopDestination);