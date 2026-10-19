<?php

class TourCategory extends dbBasic
{
    function __construct()
    {
        global $_LANG_ID;
        $this->pkey = "tourcat_id";
        $this->tbl = DB_PREFIX . "tour_category";
    }

    function getTitle($pvalTable = 0, $one = null)
    {
        if (!isset($one['title'])) {
            $one = $this->getOne($pvalTable, 'title');
        }
        return $one['title'] ?? '';
    }
    function getListTitle($pvalTable = '', $one = null)
{
    if (empty($pvalTable)) {
        return '';
    }

    $ids = array_filter(explode('|', $pvalTable));

    $titles = [];

    foreach ($ids as $id) {
        if (!is_numeric($id)) {
            continue;
        }

        $one = $this->getOne($id, 'title');

        if (!empty($one['title'])) {
            $titles[] = $one['title'];
        }
    }

    return implode(', ', $titles);
}
    function getSlug($pvalTable = 0, $one = null)
    {
        if (!isset($one['slug'])) {
            $one = $this->getOne($pvalTable, 'slug');
        }
        return $one['slug'] ?? '';
    }

    function getBySlug($slug = '')
    {
        $res = $this->getAll("is_trash=0 and slug='$slug' LIMIT 0,1");
        return $res[0][$this->pkey];
    }

    function checkExitsId($tourcat_id = 0)
    {
        $res = $this->getAll("tourcat_id = '$tourcat_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }

    function getMetaDescription($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['intro'])) {
            $one = $this->getOne($pvalTable, 'intro');
        }
        return html_entity_decode($one['intro']);
    }

    function getIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro'] ?? '');
    }

    function getIntroMore($pvalTable = 0, $limit = 400, $truncate = true, $one = null)
    {
        global $dbconn, $core;
        if (!isset($one['intro'])) {
            $one = $this->getOne($pvalTable, 'intro');
        }
        $string = $one['intro'];
        if ($truncate == true) {
            if (strlen($string) < $limit) {
                return html_entity_decode($string);
            } else {
                $html = '<div class="clickSeemore"><div class="c_seemore More">';
                $html .= strip_tags(html_entity_decode($this->truncate($string, $limit)));
                $html .= '<a href="javascript:void(0);" class="semoreClick">' . $core->get_Lang('More') . '</a>';
                $html .= '</div>';
                $html .= '<div class="c_seemore Less" style="display:none">';
                $html .= html_entity_decode($string);
                $html .= '<a href="javascript:void(0);" class="LessClick">' . $core->get_Lang('Less') . '</a>';
                $html .= '</div></div>';
                return $html;
            }
        } else {
            return $string;
        }
    }

    function truncate($string = '', $width = 0, $etc = ' ..')
    {
        $wrapped = explode('$trun$', wordwrap($string, $width, '$trun$', false), 2);
        return $wrapped[0] . (isset($wrapped[1]) ? $etc : '');
    }

    function getIntroBanner($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'intro_banner');
        return html_entity_decode($one['intro_banner'] ?? '');
    }

    function getLinkBanner($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'link_banner');
        return html_entity_decode($one['link_banner'] ?? '');
    }

    function getLink($pvalTable = 0, $oneTable = null)
    {
        global $extLang, $_LANG_ID;
        if (!isset($oneTable['slug'])) {
            $oneTable = $this->getOne($pvalTable, 'slug');
        }
        $slug = $oneTable['slug'];
        if ($_LANG_ID == 'vn')
            return $extLang . '/loai-hinh-du-lich/' . $slug . '-c' . $pvalTable;
        return $extLang . "/tours/" . $slug . '-c' . $pvalTable;
    }

    function getLinkCatCountry($pvalTable = 0, $country_id = 0, $oneTable = null)
    {
        global $extLang, $_LANG_ID;
        $clsCountry = new Country();
        if (!isset($oneTable['slug'])) {
            $oneTable = $this->getOne($pvalTable, 'slug');
        }
        $slug = $oneTable['slug'] ?? '';
        if ($_LANG_ID == 'vn')
            //            return $extLang . '/loai-hinh-du-lich/' . $slug . '-c' . $pvalTable . '/' . $clsCountry->getSlug($country_id);
            return "$extLang/loai-hinh-du-lich/{$clsCountry->getSlug($country_id)}/$slug-c{$pvalTable}";
        //        return $extLang . "/tours/" . $slug . '-c' . $pvalTable . '/' . $clsCountry->getSlug($country_id);
        return "$extLang/destination/{$clsCountry->getSlug($country_id)}/$slug-c{$pvalTable}";
    }

    function getLinkCatTour($cat_id = 0, $country_id = 0, $is_sort = false, $one = null)
    {
        global $extLang;
        $clsCountry = new Country();
        if (intval($country_id) > 0)
            return $extLang . '/' . $clsCountry->getSlug($country_id) . '-tours/' . $this->getSlug($cat_id, $one) . ($is_sort ? '' : '/');
        return $extLang . '/tours/' . $this->getSlug($cat_id) . ($is_sort ? '' : '/');
    }

 
function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
{
    global $clsISO;

    // Lấy bản ghi nếu chưa được truyền vào.
    if (!is_array($oneTable) || !array_key_exists('image', $oneTable)) {
        $oneTable = $this->getOne($pvalTable);
    }

    // Kiểm tra dữ liệu ảnh.
    $image = '';
    if (is_array($oneTable) && !empty($oneTable['image'])) {
        $image = trim($oneTable['image']);
    }

    // Có ảnh: trả về URL thumbnail.
    if ($image !== '') {
        return $clsISO->tripslashImage($image, $w, $h);
    }

    // Không có ảnh: dùng ảnh mặc định với URL hợp lệ.
    $noimage = URL_IMAGES . '/noimage.png';

    return $clsISO->tripslashImage($noimage, $w, $h);
}


    function getImageRand($pvalTable = 0, $i = '')
    {
        global $clsISO;
        $image = $this->getOneField('image', $pvalTable);
        if ($image != '' && $image != '0') {
            if ($i == 1) {
                return $clsISO->tripslashImage($image, 458, 458);
                //return '/files/thumb/458/458/'.$clsISO->parseImageURL($image);
            } elseif ($i == 4) {
                return $clsISO->tripslashImage($image, 458, 224);
            } else {
                return $clsISO->tripslashImage($image, 224, 224);
            }
        }
        $noimage = URL_IMAGES . '/noimage.png';
        if ($i == 1) {
            return "/files/thumb?w=458&h=458&src={$clsISO->parseImageURL($noimage)}";
        } elseif ($i == 4) {
            return "/files/thumb?w=458&h=224&src={$clsISO->parseImageURL($noimage)}";
        } else {
            return "/files/thumb?w=224&h=224&src={$clsISO->parseImageURL($noimage)}";
        }
    }

    function getImageRand2019($pvalTable = 0, $i = '')
    {
        global $clsISO, $deviceType;
        $image = $this->getOneField('image', $pvalTable);
        if ($image != '' && $image != '0') {
            if ($i == 3 || $i == 4) {
                if ($deviceType == 'phone') {
                    return $clsISO->tripslashImage($image, 362, 178);
                } else {
                    return $clsISO->tripslashImage($image, 564, 278);
                }
            } else {
                if ($deviceType == 'phone') {
                    return $clsISO->tripslashImage($image, 362, 362);
                } else {
                    return $clsISO->tripslashImage($image, 278, 278);
                }
            }
        }
        $noimage = URL_IMAGES . '/noimage.png';
        if ($i == 3 || $i == 4) {
            return "/files/thumb?w=564&h=278&src={$clsISO->parseImageURL($noimage)}";
        } else {
            return "/files/thumb?w=278&h=278&src={$clsISO->parseImageURL($noimage)}";
        }
    }

    function getImageUrl($pval = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pval, "image");
        $url_image = $oneTable['image'];
        return $clsISO->tripslashUrl($url_image);
    }

    function getLinkVideoTeaser($pval = 0)
    {
        $oneTable = $this->getOne($pval, 'video_teaser');
        return $oneTable['video_teaser'];
    }

    function getBgTravelStyle()
    {
        global $clsISO;
        $image = URL_IMAGES . '/bg_travelStyle.png';
        return "/files/thumb?w=224&h=224&src={$clsISO->parseImageURL($image)}";
    }

    function getBanner($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image_banner");
        if ($oneTable['image_banner'] != '') {
            $image = $oneTable['image_banner'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getBannerUrl($pval = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pval, "image_banner");
        $url_image = $oneTable['image_banner'];
        return $clsISO->tripslashUrl($url_image);
    }

    function getArray($string = '')
    {
        if ($string == '' || $string == '|') {
            return array();
        }
        $string = str_replace('||', '|', $string);
        $string = str_replace(',', '|', $string);
        $string = str_replace(':', '|', $string);
        $string = str_replace(';', '|', $string);
        $string = ltrim($string, '|');
        $string = rtrim($string, '|');
        return explode('|', $string);
    }

    function makeSelectboxOption0($tourcat_id = 0, $selected = '', $is_multiple = false)
    {
        global $core, $clsConfiguration, $clsISO;
        $sql = "is_trash=0 and parent_id=0 and is_online=1";
        if ($tourcat_id > 0 && $clsConfiguration->getValue("SiteHasSubCat_Tours")) {
            $sql .= " and tourcat_id<>'$tourcat_id'";
        }
        #
        $lstCat = $this->getAll($sql . " order by order_no ASC");
        $html = '<option value="0">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
        if (is_array($lstCat) && count($lstCat) > 0) {
            foreach ($lstCat as $k => $v) {
                if (!$is_multiple) {
                    $html .= '<option value="' . $v[$this->pkey] . '" ' . ($selected == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
                    if ($clsConfiguration->getValue('SiteHasSubCat_Tours')) {
                        $lstChild = $this->getChild($v[$this->pkey]);
                        if (is_array($lstChild)) {
                            foreach ($lstChild as $n => $m) {
                                if ($tourcat_id != $m[$this->pkey]) {
                                    $html .= '<option value="' . $m[$this->pkey] . '" ' . ($selected == $m[$this->pkey] ? 'selected="selected"' : '') . '>|_' . $this->getTitle($m[$this->pkey]) . '</option>';
                                }
                            }
                            unset($lstChild);
                        }
                    }
                } else {
                    $_array = $this->getArray($selected);
                    $html .= '<option value="' . $v[$this->pkey] . '" ' . ($clsISO->checkItemInArray($v[$this->pkey], $_array) ? 'selected="selected"' : '') . '>-- ' . $this->getTitle($v[$this->pkey]) . '</option>';
                    if ($clsConfiguration->getValue('SiteHasSubCat_Tours')) {
                        $lstChild = $this->getChild($v[$this->pkey]);
                        if (is_array($lstChild)) {
                            foreach ($lstChild as $n => $m) {
                                if ($tourcat_id != $m[$this->pkey]) {
                                    $html .= '<option value="' . $m[$this->pkey] . '" ' . ($clsISO->checkItemInArray($m[$this->pkey], $_array) ? 'selected="selected"' : '') . '>|_' . $this->getTitle($m[$this->pkey]) . '</option>';
                                }
                            }
                            unset($lstChild);
                        }
                    }
                }
            }
            unset($lstCat);
        }
        return $html;
    }

    function makeSelectboxOption($tour_group_id = 0, $selected = '', $is_multiple = false, $has_exists = false, $is_prefix = true, $cat_not_select = 0)
    {
        global $core, $clsConfiguration, $clsISO, $package_id;
        if ($has_exists == true) {
            $clsTour = new Tour();
            $sql = "{$this->tbl}.is_trash=0 and {$this->tbl}.is_online=1 and {$clsTour->tbl}.is_trash=0 and {$clsTour->tbl}.is_online=1";
            if ($tour_group_id > 0 && $clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'group ', 'default')) {
                $sql .= " and {$this->tbl}.tour_group_id='{$tour_group_id}'";
            }
            $lstCat = $this->getAllOptimize("{$sql} order by {$this->tbl}.order_no ASC", "{$clsTour->tbl} ON {$clsTour->tbl}.list_cat_id LIKE CONCAT('%|',{$this->tbl}.tourcat_id, '|%')", "DISTINCT({$this->tbl}.{$this->pkey}),{$this->tbl}.title");
        } else {
            $sql = "is_trash=0 and parent_id=0 and is_online=1";
            if ($tour_group_id > 0 && $clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'group ', 'default')) {
                $sql .= " and tour_group_id='$tour_group_id'";
            }
            #
            $lstCat = $this->getAll($sql . " order by order_no ASC", $this->pkey);
        }
        $SiteHasSubCat_Tours = $clsConfiguration->getValue('SiteHasSubCat_Tours');
        $html = !$is_prefix ? '' : '<option value="0">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
        if (!empty($lstCat)) {
            if (!$is_multiple) {
                foreach ($lstCat as $k => $v) {
                    $html .= '<option ' . (($cat_not_select == $v[$this->pkey]) ? "disabled" : "") . ' value="' . $v[$this->pkey] . '" ' . ($selected == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
                    if ($SiteHasSubCat_Tours) {
                        $lstChild = $this->getChild($v[$this->pkey]);
                        if (is_array($lstChild)) {
                            foreach ($lstChild as $n => $m) {
                                $html .= '<option ' . (($cat_not_select == $m[$this->pkey]) ? "disabled" : "") . ' value="' . $m[$this->pkey] . '" ' . ($selected == $m[$this->pkey] ? 'selected="selected"' : '') . '>|_' . $this->getTitle($m[$this->pkey]) . '</option>';
                            }
                            unset($lstChild);
                        }
                    }
                }
            } else {
                $_array = $this->getArray($selected);
                //return $_array;
                foreach ($lstCat as $k => $v) {
                    $html .= '<option ' . (($cat_not_select == $v[$this->pkey]) ? "disabled" : "") . ' value="' . $v[$this->pkey] . '" ' . ($clsISO->checkItemInArray($v[$this->pkey], $_array) ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
                    if ($SiteHasSubCat_Tours) {
                        $lstChild = $this->getChild($v[$this->pkey]);
                        if (is_array($lstChild)) {
                            foreach ($lstChild as $n => $m) {
                                $html .= '<option ' . (($cat_not_select == $m[$this->pkey]) ? "disabled" : "") . ' value="' . $m[$this->pkey] . '" ' . ($clsISO->checkItemInArray($m[$this->pkey], $_array) ? 'selected="selected"' : '') . '>|_' . $this->getTitle($m[$this->pkey]) . '</option>';
                            }
                            unset($lstChild);
                        }
                    }
                }
            }
            unset($lstCat);
        }
        return $html;
    }

    function makeSelectboxOptionCountry($country_id = 0, $selected = '', $is_multiple = false)
    {
        global $core, $clsConfiguration, $clsISO, $dbconn, $_LANG_ID;
        if ($_LANG_ID != 'en') {
            $lang_sql = $_LANG_ID;
        } else {
            $lang_sql = '';
        }
        if ($country_id > 0) {
            $sql = "SELECT tourcat_id FROM " . DB_PREFIX . "tour_category WHERE lang_id='$lang_sql' and tourcat_id IN  (SELECT cat_id FROM " . DB_PREFIX . "tour WHERE tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id'))";
            $lstCat = $dbconn->getAll($sql . " order by order_no ASC");
        } else {
            $sql = "is_trash=0 and is_online=1";
            $lstCat = $this->getAll($sql . " order by order_no ASC");
        }
        #

        $html = '<option value="0">-- ' . $core->get_Lang('selectcategory') . ' --</option>';
        if (is_array($lstCat) && count($lstCat) > 0) {
            foreach ($lstCat as $k => $v) {
                if (!$is_multiple) {
                    $html .= '<option value="' . $v[$this->pkey] . '" ' . ($selected == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
                    if ($clsConfiguration->getValue('SiteHasSubCat_Tours')) {
                        $lstChild = $this->getChild($v[$this->pkey]);
                        if (is_array($lstChild)) {
                            foreach ($lstChild as $n => $m) {
                                $html .= '<option value="' . $m[$this->pkey] . '" ' . ($selected == $m[$this->pkey] ? 'selected="selected"' : '') . '>|_' . $this->getTitle($m[$this->pkey]) . '</option>';
                            }
                            unset($lstChild);
                        }
                    }
                } else {
                    $_array = $this->getArray($selected);
                    $html .= '<option value="' . $v[$this->pkey] . '" ' . ($clsISO->checkItemInArray($v[$this->pkey], $_array) ? 'selected="selected"' : '') . '>-- ' . $this->getTitle($v[$this->pkey]) . '</option>';
                    if ($clsConfiguration->getValue('SiteHasSubCat_Tours')) {
                        $lstChild = $this->getChild($v[$this->pkey]);
                        if (is_array($lstChild)) {
                            foreach ($lstChild as $n => $m) {
                                $html .= '<option value="' . $m[$this->pkey] . '" ' . ($clsISO->checkItemInArray($m[$this->pkey], $_array) ? 'selected="selected"' : '') . '>|_' . $this->getTitle($m[$this->pkey]) . '</option>';
                            }
                            unset($lstChild);
                        }
                    }
                }
            }
            unset($lstCat);
        }
        return $html;
    }

function makeSelectboxOptionCountryImage($country_id = 0, $selected = '', $is_multiple = false)
{
    global $core, $clsConfiguration, $clsISO, $dbconn, $_LANG_ID;

    if ($_LANG_ID != 'en') {
        $lang_sql = $_LANG_ID;
    } else {
        $lang_sql = '';
    }

    if ($country_id > 0) {
        $sql = "SELECT tourcat_id FROM " . DB_PREFIX . "tour_category
                WHERE lang_id='$lang_sql'
                AND tourcat_id IN (
                    SELECT cat_id FROM " . DB_PREFIX . "tour
                    WHERE tour_id IN (
                        SELECT tour_id FROM " . DB_PREFIX . "tour_destination
                        WHERE is_trash=0 AND country_id='$country_id'
                    )
                )";

        $lstCat = $dbconn->getAll($sql . " ORDER BY order_no ASC");
    } else {
        $sql = "is_trash=0 AND is_online=1";
        $lstCat = $this->getAll($sql . " ORDER BY order_no ASC");
    }

    // Tạo option có ảnh danh mục
    $renderOption = function ($catId, $isSelected, $titlePrefix = '') {
        $title = $this->getTitle($catId);
        $image = $this->getOneField('image', $catId);

        $image = htmlspecialchars((string)$image, ENT_QUOTES, 'UTF-8');
        $titleEscaped = htmlspecialchars(
            (string)$title,
            ENT_QUOTES,
            'UTF-8'
        );

        return '<option value="' . (int)$catId . '"
            data-image="' . $image . '"
            ' . ($isSelected ? 'selected="selected"' : '') . '>'
            . $titlePrefix . $titleEscaped .
            '</option>';
    };

   $html = '<option value="0">-- ' . $core->get_Lang('selectcategory') . ' --</option>';

if (is_array($lstCat) && count($lstCat) > 0) {
    foreach ($lstCat as $k => $v) {
        $catId = (int)$v[$this->pkey];
        $title = $this->getTitle($catId);
        $image = $this->getOneField('image', $catId);

        $html .= '<option
            value="' . $catId . '"
            data-image="' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . '"
            ' . ($selected == $catId ? 'selected="selected"' : '') . '
        >' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</option>';

        if ($clsConfiguration->getValue('SiteHasSubCat_Tours')) {
            $lstChild = $this->getChild($catId);

            if (is_array($lstChild)) {
                foreach ($lstChild as $m) {
                    $childId = (int)$m[$this->pkey];
                    $childTitle = $this->getTitle($childId);
                    $childImage = $this->getOneField('image', $childId);

                    $html .= '<option
                        value="' . $childId . '"
                        data-image="' . htmlspecialchars($childImage, ENT_QUOTES, 'UTF-8') . '"
                        ' . ($selected == $childId ? 'selected="selected"' : '') . '
                    >|_' . htmlspecialchars($childTitle, ENT_QUOTES, 'UTF-8') . '</option>';
                }
            }
        }
    }
}

    return $html;
}

    function countItemInCat($tourcat_id = 0)
    {
        $clsTour = new Tour();
        $cond = "is_trash=0 and is_online=1";

        $listTourCategory = $this->getAll("is_trash=0 and is_online=1 and parent_id='$tourcat_id'", $this->pkey);
        if ($listTourCategory != '') {
            $parent_id = $tourcat_id;

            $cond .= " and (cat_id IN (SELECT tourcat_id FROM " . DB_PREFIX . "tour_category WHERE is_trash=0 and is_online=1 and parent_id='$parent_id') or (cat_id='$tourcat_id' or list_cat_id like '%|$tourcat_id|%'))";
        } else {
            $cond .= " and (cat_id='$tourcat_id' or list_cat_id like '%|$tourcat_id|%')";
        }

        return $clsTour->getAll($cond, $clsTour->pkey) ? count($clsTour->getAll($cond, $clsTour->pkey)) : 0;
    }

    function getChild($tourcat_id = 0, $limit = 0, $trash = true)
    {
        $sql = "parent_id='$tourcat_id'";
        if ($trash) {
            $sql .= " and is_trash=0 and is_online=1";
        }
        $sql .= " order by order_no ASC";
        if ($limit > 0) {
            $sql .= " LIMIT 0,$limit";
        }
        $res = $this->getAll($sql);
        return $res;
    }

    function checkIsFirst($tourcat_id = 0, $parent_id = 0)
    {
        $allItem = $this->getAll("parent_id='$parent_id' order by order_no ASC");
        if (is_array($allItem) && count($allItem) > 0) {
            if ($allItem[0][$this->pkey] == $tourcat_id) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function checkIsLast($tourcat_id = 0, $parent_id = 0)
    {
        $allItem = $this->getAll("parent_id='$parent_id' order by order_no ASC");
        if (is_array($allItem) && count($allItem) > 0) {
            if ($allItem[count($allItem) - 1][$this->pkey] == $tourcat_id) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function checkMove($tourcat_id = 0, $type = 0)
    {
        $parent_id = $this->getOneField('parent_id', $tourcat_id);
        if ($type == 'UP') {
            return !$this->checkIsFirst($tourcat_id, $parent_id) ? 1 : 0;
        } else {
            return !$this->checkIsLast($tourcat_id, $parent_id) ? 1 : 0;
        }
    }

    function getListSubCatByCat($tourcat_id = 0)
    {
        $sql = "parent_id='$tourcat_id'";
        $sql .= " and is_trash=0 and is_online=1";
        $sql .= " order by order_no ASC";
        $res = $this->getAll($sql, $this->pkey);
        return $res;
    }

    function getMenuChild($tourcat_id = 0)
    {
        $sql = "is_trash=0 and is_online=1";
        $sql .= " and parent_id='$tourcat_id'";
        $sql .= " order by order_no ASC";
        $res = $this->getAll($sql, $this->pkey . ',title');
        $html = '';
        if (!empty($res)) {
            $html .= '<ul class="sub_dropdown-menu" role="menu">';
            foreach ($res as $item) {
                $link = $this->getLink($item['tourcat_id']);
                $html .= '<li><a href="' . $link . '" title="' . $item['title'] . '">' . $item['title'] . '' . ($this->getMenuChild($item['tourcat_id']) ? '<i class="fr fa fa-angle-right" aria-hidden="true"></i>' : '') . '</a>
					' . $this->getMenuChild($item['tourcat_id']) . '
				</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    function getMenuChildMobile($tourcat_id = 0)
    {
        $sql = "parent_id='$tourcat_id'";
        $sql .= " and is_trash=0 and is_online=1";
        $sql .= " order by order_no ASC";
        $res = $this->getAll($sql, $this->pkey . ',title');
        $html = '';
        if (!empty($res)) {
            $html .= '<ul class="submenu" role="menu">';
            foreach ($res as $item) {
                $link = $this->getLink($item['tourcat_id']);
                $html .= '<li><a href="' . $link . '" title="' . $item['title'] . '">' . $item['title'] . '' . ($this->getMenuChild($item['tourcat_id']) ? '<i class="fr fa fa-angle-right" aria-hidden="true"></i>' : '') . '</a>
				' . $this->getMenuChild($item['tourcat_id']) . '
				</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    function doDelete($tourcat_id = 0)
    {
        $clsISO = new ISO();
        #
        $image = $this->getOneField("image", $tourcat_id);
        if (trim($image) != '') {
            if ($clsISO->checkContainer($image, DOMAIN_NAME)) {
                $image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
                $clsISO->deleteFile($image);
                $image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
                $clsISO->deleteFile($image);
            }
        }
        #
        $this->deleteOne($tourcat_id);
        return 1;
    }
}
