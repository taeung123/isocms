<?php
/*======================================================================*\
|| #################################################################### ||
|| # The Footer of the ISOCMS                                         # ||
|| # ISOCMS 6.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/

global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_page,
	$global_title_page, $global_description_page, $global_image_seo_page, $clsISO, $clsConfiguration, $package_id, $global_schema_markup;


$clsPage = new Page();
$smarty->assign('clsPage', $clsPage);

$tableName = $clsPage->tbl;
$pkeyName  = $clsPage->pkey;

/*
 * Chuẩn hóa ngôn ngữ hiện tại.
 *
 * Database đang quy ước:
 * English: lang_id = ''
 * Vietnamese: lang_id = 'vn'
 * Spanish: lang_id = 'es'
 * French: lang_id = 'fr'
 * Korean: lang_id = 'kr'
 * Chinese: lang_id = 'cn'
 */
$currentLang = isset($_LANG_ID)
    ? strtolower(trim($_LANG_ID))
    : '';

/*
 * Tiếng Anh trong database đang để lang_id rỗng.
 */

/*
    * Chỉ cho phép mã ngôn ngữ hợp lệ.
    */
$allowedLanguages = array(
    'vn',
    'es',
    'fr',
    'kr',
    'cn'
);


$currentLangSql = addslashes($currentLang);
$langCondition = "
    lang_id = '{$currentLangSql}'
";



$sql = "
    SELECT
        {$pkeyName} AS page_id,
        title,
        slug,
        link,
        lang_id
    FROM {$tableName}
    WHERE is_trash = 0
      AND is_online = 1
      AND title <> ''
      AND {$langCondition}
    ORDER BY order_no ASC, {$pkeyName} ASC
";

$listAllpage = $dbconn->GetAll($sql);

if (!is_array($listAllpage)) {
    $listAllpage = array();
}

/*
 * Chuẩn hóa dữ liệu để Smarty không in Array().
 */
$pageList = array();

foreach ($listAllpage as $item) {
    if (!is_array($item)) {
        continue;
    }

    $pageId = isset($item['page_id'])
        ? (int) $item['page_id']
        : 0;

    $title = isset($item['title']) && is_scalar($item['title'])
        ? trim((string) $item['title'])
        : '';

    $slug = isset($item['slug']) && is_scalar($item['slug'])
        ? trim((string) $item['slug'])
        : '';

    $link = isset($item['link']) && is_scalar($item['link'])
        ? trim((string) $item['link'])
        : '';

    if ($pageId <= 0 || $title === '') {
        continue;
    }

    /*
     * Nếu link rỗng thì tạo từ slug.
     */
    if ($link === '' && $slug !== '') {
        $link = '/about/' . ltrim($slug, '/');

        if (!preg_match('/\.html?$/i', $link)) {
            $link .= '.html';
        }
    }

    $pageList[] = array(
        'page_id' => $pageId,
        'title'   => html_entity_decode(
            $title,
            ENT_QUOTES,
            'UTF-8'
        ),
        'slug'    => $slug,
        'link'    => $link,
        'lang_id' => isset($item['lang_id'])
            ? (string) $item['lang_id']
            : ''
    );
}

$smarty->assign('listAllpage', $pageList);

/*
 * Kiểm tra query khi cần.
 */
// error_log('PAGE LANGUAGE: ' . $currentLang);
// error_log('PAGE QUERY: ' . preg_replace('/\s+/', ' ', trim($sql)));
// error_log('PAGE RESULT: ' . print_r($pageList, true));

#info
$current_year = date('Y', time());
$assign_list["current_year"] = $current_year;

#
$clsMeta = new Meta();
$original_uri = $REQUEST_URI = $_SERVER['REQUEST_URI'];
$REQUEST_URI = parse_url($REQUEST_URI, PHP_URL_PATH);
// Loại bỏ mọi phần từ ?page=... hoặc &page=... trở về sau
$REQUEST_URI = preg_replace('/[&?]page=\d+.*$/', '', $REQUEST_URI);
// Nếu còn dấu & treo ở cuối thì xóa nốt
$REQUEST_URI = rtrim($REQUEST_URI, '&');

$assign_list["REQUEST_URI"] = $REQUEST_URI;
$allMeta = $clsMeta->getAll("(config_link='$REQUEST_URI' or config_link='" . urldecode($REQUEST_URI) . "') limit 1", $clsMeta->pkey . ',config_value_title,config_value_intro,image,meta_index,meta_follow,image,schema_markup');
if ($allMeta) {
	$one = $allMeta[0];
	$global_title_page = $one['config_value_title'] != '' ? $one['config_value_title'] : $title_page;
	$global_description_page = $one['config_value_intro'] != '' ? strip_tags(html_entity_decode($one['config_value_intro'])) : $description_page;

    $global_schema_markup = $one['schema_markup'] != '' ? $one['schema_markup'] : '';
    $assign_list["global_schema_markup"] = $global_schema_markup;

	if ($global_image_seo_page != '') {
		$global_image_seo_page = $global_image_seo_page;
	} else {
		$global_image_seo_page = $clsConfiguration->getValue('ImageShareSocial');
	}
	$global_image_page = $one['image'] != '' ? $clsMeta->getMetaImage($one['meta_id'], 320, 350, $one) : $global_image_seo_page;
	$no_index = $one['meta_index'];
	$no_follow = $one['meta_follow'];
	if ($no_index == 1) {
		$index = 'noindex';
	} else {
		$index = 'index';
	}
	if ($no_follow == 1) {
		$follow = 'nofollow';
	} else {
		$follow = 'follow';
	}
} else {
	$global_title_page = $title_page;
	$global_description_page = $description_page;
	if ($global_image_seo_page != '') {
		$global_image_page = $global_image_seo_page;
	} else {
		$global_image_page = $clsConfiguration->getValue('ImageShareSocial');
	}
	$index = 'index';
	$follow = 'follow';
}

// Kiểm tra nếu URL chứa tham số (? hoặc &page=) thì thêm thẻ noindex
if (strpos($original_uri, '?') !== false || preg_match('/[&?]page=\d+/', $original_uri)) {
	$index = 'noindex';
	$follow = 'nofollow';
}

//    Our Partner
if ($clsISO->getCheckActiveModulePackage($package_id, 'partner', 'default', 'default')) {
	$clsPartner = new Partner();
	$smarty->assign('clsPartner', $clsPartner);
	#
	$lstPartner = $clsPartner->getAll("is_trash=0 and is_online=1 and image<>'' and type='' order by order_no asc", $clsPartner->pkey . ",title,image,url");
	$smarty->assign('lstPartner', $lstPartner);
	#
	$totalProgram = $lstPartner ? count($lstPartner) : 0;
	$TotalListPartner = ceil($totalProgram / 6);
	if ($clsISO->getBrowser() == 'phone') {
		$TotalListPartner = ceil($totalProgram / 3);
	}
	$smarty->assign('TotalListPartner', $TotalListPartner);
	#
	$totalPartner = $lstPartner ? count($lstPartner) : 0;
	//    $width_slide_panner = $totalPartner * 141;
	$width_slide_panner = $totalPartner * 156;
	$smarty->assign('width_slide_panner', $width_slide_panner);
	unset($lstPartner);
}

function _parse($string)
{
	$string = str_replace('VietISO', PAGE_NAME, $string);
	$string = str_replace('vietiso', PAGE_NAME, $string);
	return $string;
}
$assign_list["global_title_page"] = _parse($global_title_page);
$assign_list["global_description_page"] = _parse($global_description_page);
$assign_list["global_image_page"] = $global_image_page;

$assign_list["index"] = $index;
$assign_list["follow"] = $follow;
