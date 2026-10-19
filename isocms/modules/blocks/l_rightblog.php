<?php
global $smarty, $mod, $act, $country_id, $city_id, $cat_id, $dbconn, $_LANG_ID, $lang_sql, $blog_id, $blogItem, $clsISO, $now_month;


$clsBlogCategory = new BlogCategory();
$smarty->assign('clsBlogCategory', $clsBlogCategory);
$clsBlogDestination = new BlogDestination();
$smarty->assign('clsBlogDestination', $clsBlogDestination);
$clsBlogExtension = new BlogExtension();
$smarty->assign('clsBlogExtension', $clsBlogExtension);
$clsCity = new City();
$smarty->assign('clsCity', $clsCity);
$clsBlog = new Blog();
$smarty->assign('clsBlog', $clsBlog);
$clsTag = new Tag();
$smarty->assign('clsTag', $clsTag);
$clsTour = new Tour();
$smarty->assign('clsTour', $clsTour);
$clsHotel = new Hotel();
$smarty->assign('clsHotel', $clsHotel);
$clsCruise = new Cruise();
$smarty->assign('clsCruise', $clsCruise);
$clsTagModule = new TagModule();
$smarty->assign('clsTagModule', $clsTagModule);
$clsPromotion = new Promotion();
$smarty->assign('clsPromotion', $clsPromotion);

$lstCategory = $clsBlogCategory->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsBlogCategory->pkey . ", title,slug");

$smarty->assign('lstCategory', $lstCategory);

/*$lstLatestBlog = $clsBlog->getAll("is_trash=0 and is_approve=1 and is_online=1 order by order_no desc limit 0,20");
	$smarty->assign('lstLatestBlog',$lstLatestBlog);*/

$lstPopularBlog = $clsBlog->getAll("is_trash=0 and is_approve=1 and is_online=1 and num_view > 0 order by num_view desc limit 0,5", $clsBlog->pkey . ',slug,title');
$smarty->assign('lstPopularBlog', $lstPopularBlog);
/*
 * Category filter từ URL:
 * ?cat=5
 * ?cat=5,6,21
 */
$catRaw = isset($_GET['cat'])
    ? trim($_GET['cat'])
    : '';

$catRaw = rawurldecode($catRaw);

$list_cats = array();
$list_cats_map = array();

if ($catRaw !== '') {
    $catParts = preg_split(
        '/[,|]+/',
        $catRaw
    );

    if (is_array($catParts)) {
        foreach ($catParts as $catId) {
            $catId = (int) trim($catId);

            if ($catId <= 0) {
                continue;
            }

            if (!in_array($catId, $list_cats, true)) {
                $list_cats[] = $catId;
            }

            $list_cats_map[$catId] = 1;
        }
    }
}

$assign_list['list_cats'] = $list_cats;
$assign_list['list_cats_map'] = $list_cats_map;
// Tags
$listTag = $clsTag->getAll(
    "tag_id IN (
        SELECT tag_id
        FROM " . DB_PREFIX . "tag_module
        WHERE type='BLOG'
    )",
    $clsTag->pkey
);

$lstTag = array();

if (is_array($listTag) && count($listTag) > 0) {
    foreach ($listTag as $k => $v) {
        $tag_id = isset($v['tag_id']) ? intval($v['tag_id']) : 0;

        if ($tag_id <= 0) {
            continue;
        }

        $lstTag[] = array(
            'tag_id' => $tag_id,
            'number' => $clsTagModule->countItem(
                "type='BLOG' and tag_id='" . $tag_id . "'"
            ),
            'class' => random_tags()
        );
    }
}

$smarty->assign('lstTag', $lstTag);

#lst Country
$SQL01 = "SELECT country_id FROM " . DB_PREFIX . "blog_destination WHERE blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog WHERE 1=1 and lang_id = '$lang_sql') group by country_id";


$lstDestinationsBlog = $dbconn->GetAll($SQL01);
$smarty->assign('lstDestinationsBlog', $lstDestinationsBlog);

$lstTourExtension = $clsBlogExtension->getAll("blog_id = '$blog_id' and table_name='tour' and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1) order by order_no ASC", $clsBlogExtension->pkey . ',tour_id');
$smarty->assign('lstTourExtension', $lstTourExtension);
$lstCruiseExtension = $clsBlogExtension->getAll("blog_id = '$blog_id' and table_name='cruise' and cruise_id IN (SELECT cruise_id FROM ".DB_PREFIX."cruise WHERE is_trash=0 and is_online=1) order by order_no desc",'cruise_id');
$smarty->assign('lstCruiseExtension', $lstCruiseExtension);
$lstHotelExtension = $clsBlogExtension->getAll("blog_id = '$blog_id' and table_name='hotel' and hotel_id IN (SELECT hotel_id FROM " . DB_PREFIX . "hotel WHERE is_trash=0 and is_online=1) order by order_no ASC", 'hotel_id');
$smarty->assign('lstHotelExtension', $lstHotelExtension);

#
function random_tags()
{
	$_array = array('tag_11', 'tag_12', 'tag_13', 'tag_14', 'tag_16', 'tag_20', 'tag_21', 'tag_24');
	return $_array[array_rand($_array)];
}

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL & ~E_STRICT);

if (!empty($_POST['form_search']) && $_POST['form_search'] = 'form_search') {
	$clsCountry = new Country();
	$country_id = $_POST['country_id'];
	$cat_id = $_POST['cat_id'];
	$link = !empty($country_id) ? $clsCountry->getLink($country_id, "Blog") : $clsISO->getLink("blog");

	$key_blog = $_POST["key_blog"] ?? "";
	$link .=  "?key=$key_blog";
	if (!empty($cat_id)) $link .=  "&cat={$clsISO->makeSlashListFromArrayComma($cat_id)}";

	header('Location: ' . trim($link));
	exit();
}
