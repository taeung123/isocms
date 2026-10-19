<?php
global $smarty, $cat_id, $clsISO;

$clsTourCategory = new TourCategory();

$cond = "is_trash = 0 and is_online = 1 ";
$cat_id = $_GET["cat_id"] ?? 0;
$smarty->assign("cat_id", $cat_id);
$order_field = !empty($cat_id) ? "FIELD($clsTourCategory->pkey, $cat_id) DESC, " : "";

if (isset($_GET["show"]) && $_GET["show"] == 'CatCountry') {
    $clsCountry = new Country();
    $slug_country = $_GET["slug_country"];
    $country_id = $clsCountry->getBySlug($slug_country);
    $cond .= " and tourcat_id IN (select cat_id from default_category_country where country_id = $country_id)";
}

$lstTourCategory = $clsTourCategory->getAll("$cond order by $order_field order_no", "$clsTourCategory->pkey, title");
$smarty->assign("lstTourCategory", $lstTourCategory);
