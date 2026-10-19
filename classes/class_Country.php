<?php

class Country extends dbBasic
{
    function __construct()
    {
        $this->pkey = "country_id";
        $this->tbl = DB_PREFIX . "country";
    }

    function getSelectCountryCitySearch($selected = '')
    {
        global $core, $core;
        $clsTour = new Tour();
        $clsCity = new City();
        $where = "is_trash=0 and is_online=1";
        $limit = " order by order_no ASC";
        $html = '<option value="0">' . $core->get_Lang('Destination length') . '</option>';;
        $lstCountry = $this->getAll($where . $limit, $this->pkey . ",title,slug");

        if (is_array($lstCountry) && count($lstCountry) > 0) {
            $i = 0;
            foreach ($lstCountry as $k => $v) {
                $total_tour_country = $clsTour->countTourGolobal($v[$this->pkey]);
                if ($total_tour_country > 0) {
                    $selected_index = ($selected == $v[$this->pkey]) ? 'selected="selected"' : '';
                    $html .= '<option data-label="Country" data-number_tour="' . $total_tour_country . '" data-slug="' . strtolower($v['slug']) . '" data-strtolower_title="' . strtolower($v['title']) . '" value="country_id-' . $v[$this->pkey] . '">' . $v['title'] . '</option>';
                }
                ++$i;
            }
        }
        $lstCity = $clsCity->getAll($where . $limit, $clsCity->pkey . ",title,slug,country_id");
        if (is_array($lstCity) && count($lstCity) > 0) {
            $j = 0;
            foreach ($lstCity as $k => $v) {
                $total_tour_city = $clsTour->countTourGolobal($v['country_id'], $v[$clsCity->pkey]);
                if ($total_tour_city > 0) {
                    $selected_index = ($selected == $v[$clsCity->pkey]) ? 'selected="selected"' : '';
                    $html .= '<option data-label="City" data-number_tour="' . $total_tour_city . '" data-slug="' . strtolower($v['slug']) . '" data-strtolower_title="' . strtolower($v['title']) . '" value="country_id-' . $v['country_id'] . '-city_filter_id-' . $v[$clsCity->pkey] . '" data-country="' . $this->getTitle($v['country_id']) . '" >' . $v['title'] . '</option>';
                }
                ++$j;
            }
        }
        if (empty($lstCountry) && empty($lstCity)) {
            $html .= '_EMPTY';
        }
        return $html;
    }

    function getMaxOrder()
    {
        $res = $this->getAll("1=1 order by order_no desc", $this->pkey . ",order_no");
        return intval($res[0]['order_no']) + 1;
    }

    function getId($country_id = 0)
    {
        $one = $this->getOne($country_id, 'country_id');
        return $one['country_id'];
    }

    function getTitle($country_id = 0, $oDataTable = null)
    {
        if (!isset($oDataTable['title'])) {
            $oDataTable = $this->getOne($country_id, 'title');
        }
        return $oDataTable['title'] ?? '';
    }

    function getSlug($country_id = 0, $one = null)
    {
        if (!isset($one['slug'])) {
            $one = $this->getOne($country_id, 'slug');
        }
        return $one['slug'] ?? '';
    }

    function getBySlug($slug = '')
    {
        $res = $this->getAll("is_trash=0 and slug = '" . $slug . "'", $this->pkey);
        return $res[0]['country_id'];
    }

    function checkSlug($slug = '')
    {
        $res = $this->getAll("slug = '%" . $slug . "%'", $this->pkey);
        if (is_array($res) && count($res) > 0)
            return 0;
        return 1;
    }

    function checkExitsId($country_id = 0)
    {
        $res = $this->getAll("country_id = '$country_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }

    function getListCity($country_id = 0)
    {
        global $_LANG_ID;
        $clsCity = new City();
        $res = $clsCity->getAll("is_trash=0 and country_id = '$country_id' order by order_no desc limit 0,6", $clsCity->pkey);
        return $res;
    }

    function getCities($country_id = 0)
    {
        global $_LANG_ID, $clsISO;
        $clsCity = new City();

        $res = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by order_no desc", $clsCity->pkey . ", title");

        return $res ?? [];
    }

    function getMetaDescription($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['intro'])) {
            $one = $this->getOne($pvalTable, 'intro');
        }
        return html_entity_decode($one['intro']);
    }

    function getIntro($country_id = 0, $type = '', $is_sort = false, $one = null)
    {
        global $extLang, $_LANG_ID;

        switch ($type) {
            case 'Hotel':
                if (!isset($one['intro_hotel'])) {
                    $one = $this->getOne($country_id, 'intro_hotel');
                }
                return html_entity_decode($one['intro_hotel']);
                break;
            case 'Guide':
                if (!isset($one['intro_guide'])) {
                    $one = $this->getOne($country_id, 'intro_guide');
                }
                return html_entity_decode($one['intro_guide']);
                break;
            case 'Banner':
                if (!isset($one['intro_banner'])) {
                    $one = $this->getOne($country_id, 'intro_banner');
                }
                return html_entity_decode($one['intro_banner']);
                break;
            default:
                if (!isset($one['intro'])) {
                    $one = $this->getOne($country_id, 'intro');
                }
                return html_entity_decode($one['intro']);
        }
    }

    function getContent($country_id = 0, $one = null)
    {
        if (!isset($one['content'])) {
            $one = $this->getOne($country_id, 'content');
        }
        return html_entity_decode($one['content']);
    }

    function getStripIntro($country_id = 0, $one = null)
    {
        if (!isset($one['intro']) && !isset($one['content'])) {
            $one = $this->getOne($country_id, 'intro,content');
        }
        if (!empty($one['intro']))
            return strip_tags(html_entity_decode($one['intro']));
        return strip_tags(html_entity_decode($one['content']));
    }

    function getImage($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image");
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            return $clsISO->tripslashImage($image, $w, $h);
            $noimage = URL_IMAGES . '/noimage.png';
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getUrlImage($pvalTable = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image");
        $url_image = $oneTable['image'];
        return $clsISO->tripslashUrl($url_image);
    }

    function getImageBannerHotel($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        #
        if (!isset($oneTable['image_hotel'])) {
            $oneTable = $this->getOne($pvalTable, 'image_hotel');
        }
        if ($oneTable['image_hotel'] != '') {
            $image = $oneTable['image_hotel'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return $clsISO->tripslashImage($noimage, $w, $h);
    }

    function getImage2($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, 'image');
        if ($oneTable['image2'] != '') {
            $image = $oneTable['image2'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return $clsISO->tripslashImage($noimage, $w, $h);
    }

    function getImageHome($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, 'imagehome');
        if ($oneTable['imagehome'] != '') {
            $image = $oneTable['imagehome'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return $clsISO->tripslashImage($noimage, $w, $h);
    }

    function getImageUrl($pval = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pval, 'image');
        $url_image = $oneTable['image'];
        return $clsISO->tripslashUrl($url_image);
    }

    function getBannerUrl($pval = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pval, 'link_banner');
        $url_image = $oneTable['link_banner'];
        return $clsISO->tripslashUrl($url_image);
    }

    function getBanner($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        if (!isset($oneTable['banner'])) {
            $oneTable = $this->getOne($pvalTable, 'banner');
        }
        if ($oneTable['banner'] != '') {
            $image = $oneTable['banner'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return $clsISO->tripslashImage($noimage, $w, $h);
    }

    function getBannerImage($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, 'banner');
        if ($oneTable['banner'] != '') {
            $banner = $oneTable['banner'];
            return $clsISO->tripslashImage($banner, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return $clsISO->tripslashImage($noimage, $w, $h);
    }

    function getLinkVideoTeaser($pval = 0)
    {
        $oneTable = $this->getOne($pval, 'video_teaser');
        return $oneTable['video_teaser'];
    }

    // Get Link Site
    function getLink($country_id = 0, $type = '', $oneTable = null)
    {
        global $extLang, $_LANG_ID, $clsISO;

        if (!isset($oneTable['slug'])) {
            $oneTable = $this->getOne($country_id, 'slug');
        }
        $slug = $oneTable['slug'];
        switch ($type) {
            case 'Attraction':
                return $extLang . '/' . $slug . '-attractions';
                break;
            case 'Travel':
                return $extLang . '/' . $slug . '-travel-tips';
                break;
            case 'Hotel':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/khach-san/' . $slug;
                return $extLang . '/hotels/' . $slug;
                break;
            case '2024-Hotel':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/2024-khach-san/' . $slug;
                return $extLang . '/2024-hotels/' . $slug;
                break;
            case 'Blog':
                return $extLang . '/blog/' . $slug;
                break;
            case 'Map':
                return $extLang . '/' . $slug . '-maps';
                break;
            case 'tour':
                return $extLang . '/tour/' . $slug;
                break;
            case 'City':
                return $extLang . '/' . $slug . '-destinations/cities';
                break;
            case 'Guide':
                return $extLang . '/' . $slug . '-travel-guide';
                break;
            case 'Destination_new':
                return $extLang . '/destination/' . $slug;
                break;
            case 'travel-guide':
                return $extLang . '/travel-guide/' . $slug;
            case 'tour_new':
                return "{$clsISO->getLink('search_tour')}?search2024=&country_id=$country_id";
            case 'sale_tool':
                return "{$clsISO->getLink('sale_tool')}/$slug";
            default:
                if ($_LANG_ID == 'vn')
                    return $this->getLinkOutbound($country_id, $oneTable);
                return $extLang . '/destination/' . $slug;
        }
    }

    function getLinkOutbound($pvalTable = 0, $oneTable = null)
    {
        global $core, $_LANG_ID, $extLang;
        if (!isset($oneTable['slug'])) {
            $oneTable = $this->getOne($pvalTable, 'slug');
        }
        $slug = $oneTable['slug'];
        if ($pvalTable == 4) return $extLang . '/destination/' . $slug;
        if ($_LANG_ID == 'vn')
            return $extLang . '/du-lich-nuoc-ngoai/du-lich-' . $slug;
        return $extLang . '/destinations/' . $slug;
    }

    function countNumberCity($country_id = 0)
    {
        $clsCity = new City();
        $continent_id = $this->getOneField('continent_id', $country_id);
        $cond = $continent_id ? " and continent_id = $continent_id" : "";
        $res = $clsCity->getAll("is_trash='0' and country_id='$country_id' $cond", $clsCity->pkey);
        return $res ? count($res) : 0;
    }

    function countNumberRegion($country_id = 0)
    {
        $clsRegion = new Region();
        $res = $clsRegion->getAll("is_trash='0' and is_online=1 and country_id='$country_id'", $clsRegion->pkey);
        return $res ? count($res) : 0;
    }

    function countNumberTour($country_id = 0)
    {
        $clsTour = new Tour();
        $lstItem = $clsTour->getAll("is_trash=0 and is_online=1 and tour_id IN (SELECT tour_id FROM default_tour_destination WHERE country_id = '" . $country_id . "')", $clsTour->pkey);
        return $lstItem ? count($lstItem) : 0;
    }

    function getCountryHaveTour($arrCountryId = [], $isCountry = false)
    {
        global $dbconn, $_LANG_ID, $lang_sql;
        $clsTour = new Tour();
        $strCountryId = implode(',', $arrCountryId);
        if (!$isCountry) {
            $cond = " NOT IN (" . $strCountryId . ")";
        } else {
            $cond = " IN (" . $strCountryId . ")";
        }
        $sql = "SELECT tbl_country.country_id,tbl_country.title,tbl_country.slug 
			FROM " . DB_PREFIX . "tour as tbl_tour 
			INNER JOIN " . DB_PREFIX . "tour_destination as tbl_tour_des ON tbl_tour.tour_id = tbl_tour_des.tour_id 
			INNER JOIN " . DB_PREFIX . "country as tbl_country ON tbl_tour_des.country_id = tbl_country.country_id 
			WHERE tbl_tour.lang_id='" . $lang_sql . "' and tbl_tour.is_trash=0 and tbl_tour.is_online=1 and tbl_country.is_trash=0 and tbl_country.is_online=1 and tbl_tour_des.country_id " . $cond . " 
			GROUP BY tbl_tour_des.country_id 
			ORDER BY tbl_country.order_no ASC";
        $lstItem = $dbconn->getAll($sql);
        return $lstItem;
    }

    function countNumberHotel($country_id = 0)
    {
        global $clsISO, $package_id;

        if ($clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default')) {
            $clsHotel = new Hotel();
            $lstItem = $clsHotel->getAll("is_trash=0 and is_online=1 and country_id = '" . $country_id . "'", $clsHotel->pkey);
            return $lstItem ? count($lstItem) : 0;
        }
        return 0;
    }

    function countNumberPlaceToGo($country_id = 0)
    {
        global $_LANG_ID;

        if ($_LANG_ID == 'en') {
            $place_to_go_id = 15;
        } elseif ($_LANG_ID == 'fr') {
            $place_to_go_id = 5;
        } elseif ($_LANG_ID == 'es') {
            $place_to_go_id = 20;
        } else {
            $place_to_go_id = 3;
        }

        $clsGuide = new Guide();

        $lstItem = $clsGuide->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and cat_id='$place_to_go_id'", $clsGuide->pkey);
        return $lstItem ? count($lstItem) : 0;
    }

    function countNumberArea($country_id = 0)
    {
        $clsGuideArea2 = new GuideArea2();
        $lstGuideArea2 = $clsGuideArea2->getAll("country_id = '$country_id' order by order_no desc", $clsGuideArea2->pkey . ',area_id');
        $tmp = array();
        foreach ($lstGuideArea2 as $key => $value) {
            if ($value['area_id'])
                $tmp[] = $value['area_id'];
        }
        return count(array_unique($tmp));
    }

    function countNumberDraftTour($country_id = 0)
    {
        $clsDraftTour = new DraftTour();
        $lstItem = $clsDraftTour->getAll("list_country_id like '%|" . $country_id . "|%'", $clsDraftTour->pkey);
        return $lstItem ? count($lstItem) : 0;
    }

    function countNumberTour2($cat_id = 0, $country_id = 0)
    {
        $clsTour = new Tour();
        $lstItem = $clsTour->getAll("is_trash=0 and list_cat_id like '%" . $cat_id . "%' and tour_id in (SELECT tour_id from default_tour_destination where country_id = '" . $country_id . "')", $clsTour->pkey);
        return $lstItem ? count($lstItem) : 0;
    }

    function countTopByTour($country_id = 0)
    {
        $clsCity = new City();
        $all = $clsCity->getAll("is_trash=0 and country_id = '$country_id' and is_top=1", $clsCity->pkey);
        return $all ? count($all) : 0;
    }

    function getCity($country_id = 0)
    {
        $clsCity = new City();
        $res = $clsCity->getAll("is_trash=0 and country_id='$country_id'", $clsCity->pkey);
        return $res;
    }

    function makeSelectboxOption($country_id = 0, $continent_id = 0)
    {
        global $core, $dbconn;
        #
        $cond = "is_trash=0 and is_online=1";
        if (intval($continent_id) != 0) {
            $cond .= " AND continent_id=" . $continent_id;
        }
        $cond .= " ORDER BY order_no ASC";
        #
        $res = $this->getAll($cond, "{$this->pkey},title");
        $html = '<option value="0">' . $core->get_Lang('All Country') . '</option>';
        if (!empty($res)) {
            foreach ($res as $item) {
                $title = $this->getTitle($item[$this->pkey], $item);
                $selected = ($country_id == $item[$this->pkey]) ? ' selected="selected"' : '';
                $html .= '<option title="' . $title . '" value="' . $item[$this->pkey] . '"' . $selected . '>' . $title . '</option>';
            }
        }
        return $html;
    }

    function makeSelectboxOptionImage($country_id = 0, $continent_id = 0)
{
    global $core, $dbconn;

    $cond = "is_trash=0 and is_online=1";

    if (intval($continent_id) != 0) {
        $cond .= " AND continent_id=" . intval($continent_id);
    }

    $cond .= " ORDER BY order_no ASC";

    // Lấy thêm trường image
    $res = $this->getAll(
        $cond,
        "{$this->pkey},title,image"
    );

    $html = '<option value="0" data-image="">'
        . $core->get_Lang('All Country')
        . '</option>';

    if (!empty($res)) {
        foreach ($res as $item) {
            $id = $item[$this->pkey];
            $title = $this->getTitle($id, $item);
            $image = isset($item['image']) ? trim($item['image']) : '';

            $selected = (intval($country_id) === intval($id))
                ? ' selected="selected"'
                : '';

            $html .= '<option'
                . ' value="' . intval($id) . '"'
                . ' data-image="' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . '"'
                . ' title="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '"'
                . $selected
                . '>'
                . htmlspecialchars($title, ENT_QUOTES, 'UTF-8')
                . '</option>';
        }
    }

    return $html;
}

    function makeSelectHotelOption($country_id = 0, $continent_id = 0)
    {
        global $core, $dbconn;
        $clsHotel = new Hotel();
        $cond = "is_trash=0 and is_online=1 and country_id IN (SELECT country_id FROM " . $clsHotel->tbl . " WHERE is_trash=0 and country_id > 0)";
        if ((int)$continent_id > 0) {
            $cond .= " AND continent_id='{$continent_id}'";
        }
        $cond .= " ORDER BY order_no ASC";
        $res = $this->getAll($cond, "{$this->pkey},title");
        $html = '<option value="0">' . $core->get_Lang('All Country') . '</option>';
        if (!empty($res)) {
            foreach ($res as $item) {
                $title = $this->getTitle($item[$this->pkey], $item);
                $selected = ($country_id == $item[$this->pkey]) ? ' selected="selected"' : '';
                $html .= '<option title="' . $title . '" value="' . $item[$this->pkey] . '"' . $selected . '>' . $title . '</option>';
            }
        }
        return $html;
    }

    function getSelectByCountry($selected = '', $is_prefix = true)
    {
        global $core;
        #
        $res = $this->getAll("is_trash=0 and is_online=1 order by order_no asc", $this->pkey . ',title');
        $html = !$is_prefix ? '' : '<option value="">-- ' . $core->get_Lang('Select destination') . ' --</option>';
        if (is_array($res) && count($res) > 0) {
            foreach ($res as $k => $v) {
                $selected_index = ($selected == $v[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $v[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($v[$this->pkey], $v) . '</option>';
            }
        }
        unset($res);
        return $html;
    }

    function getLinkDetail($country_id = 0, $type = '', $oneTable = null)
    {
        global $extLang, $_LANG_ID, $clsISO;

        if (!isset($oneTable['slug'])) {
            $oneTable = $this->getOne($country_id, 'slug');
        }
        $slug = $oneTable['slug'];
        switch ($type) {
            case 'hotel':
                return $extLang . '/hotels/' . $slug;
                break;
            case 'khach-san':
                return $extLang . '/khach-san/' . $slug;
                break;
            case '2024-hotel':
                return $extLang . '/2024-hotels/' . $slug;
                break;
            case '2024-khach-san':
                return $extLang . '/2024-khach-san/' . $slug;
                break;
            case 'city':
                return $extLang . '/' . $slug . '/cities';
                break;
            case 'guide':
                return $extLang . '/' . $slug . '/guides';
                break;
            case 'faq':
                return $extLang . '/' . $slug . '/faqs';
                break;
            default:
                return $extLang . '/' . $slug . '/overview';
        }
    }

    function getMapHTML2($country_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($country_id);
        $html .= '<div class="infomap">';
        $html .= '<h2 class="title_map">
					<a href=' . $this->getLinkDestination($country_id) . ' title=' . $this->getTitle($country_id) . '>' . $this->getTitle($country_id) . '</a>
				</h2>';
        $html .= '</div>';
        return $html;
    }

    function getMapLa($country_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($country_id, 'map_la');
        return $one['map_la'];
    }

    function getMapLo($country_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($country_id, 'map_lo');
        return $one['map_lo'];
    }

    function getLocationMap($country_id = 0)
    {
        $clsCountry = new Country();
        $clsCity = new City();
        #
        $listCity = $clsCity->getAll("is_trash=0 and map_lo<>'' and map_la<>'' and country_id='$country_id' order by order_no ASC");
        $location = '';
        if (!empty($listCity)) {
            for ($i = 0; $i < count($listCity); $i++) {
                $location .= '["' . $clsCity->getMapHTML($listCity[$i][$clsCity->pkey]) . '",' . $listCity[$i]['map_la'] . ',' . $listCity[$i]['map_lo'] . ',' . $listCity[$i][$clsCity->pkey] . ']';
                $location .= ($i == count($listCity) - 1) ? '' : ',';
            }
        }
        $script_js = '<script type="text/javascript">
			var locations=[' . $location . '];
		</script>';
        return $script_js;
    }

    function getListDestCatTours($country_id = 0)
    {
        $clsCategory = new Category();
        $res = $clsCategory->getAll("is_trash=0 and _type = 'TOUR' and cat_id in (select cat_id from default_tour WHERE (tour_id in (SELECT tour_id from default_tour_destination where country_id='" . $country_id . "' )))", $clsCategory->pkey);
        return !empty($res) ? $res : '';
    }

    function getHotelByCountry($country_id = 0, $limit = 0)
    {
        $clsHotel = new Hotel();
        $res = $clsHotel->getAll("is_trash=0 and country_id='$country_id' order by order_no DESC limit 0,$limit", $clsHotel->pkey);
        return $res;
    }

    function getHotCityByCountry($country_id = 0, $limit = 0)
    {
        $clsCity = new City();
        $sql = "is_trash=0 and country_id='$country_id' and city_id IN (SELECT target_id FROM " . DB_PREFIX . "hoteltop WHERE fromid = 'CITY') order by order_no DESC LIMIT 0,$limit";
        return $clsCity->getAll($sql);
    }

    function getCityTourByCountry($country_id = 0)
    {
        $clsCity = new City();
        $sql = "is_trash=0 and country_id='$country_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0) order by order_no DESC";
        return $clsCity->getAll($sql, $clsCity->pkey);
    }

    #- Count Number In Country

    function countNumberCityStore($country_id = 0, $type = '')
    {
        $clsCityStore = new CityStore();
        return $clsCityStore->countItem("is_trash='0' and country_id='$country_id' and type='$type'");
    }

    function countChildGuide($guide_id = 0)
    {
        global $_LANG_ID;
        $clsGuide = new Guide();
        $one = $clsGuide->getAll("is_trash=0 and parent_id='$guide_id'");
        if ($one[0]['guide_id'] != '')
            return count($one);
        return 0;
    }

    function getLinkDestination($is_sort = false)
    {
        global $extLang, $_LANG_ID;
        if ($is_sort)
            return $extLang . '/destinations';
        return $extLang . '/destinations/';
    }

    function getLinkTourSort($cat_id = '', $is_sort = false)
    {
        global $extLang;
        if ($is_sort)
            return $extLang . '/destinations/c' . $cat_id;
        return $extLang . '/destinations/c' . $cat_id . '/';
    }

    function checkExits($continent_id = 0, $country_id = 0)
    {
        $cond = "is_trash=0";
        if (intval($continent_id) != 0) {
            $cond .= " and continent_id = '$continent_id'";
        }
        if (intval($country_id) != 0) {
            $cond .= " and country_id = '$country_id'";
        }
        $res = $this->getAll($cond . " limit 0,1");
        return !empty($res) ? 1 : 0;
    }

    function doDelete($country_id = 0)
    {
        $clsISO = new ISO();

        // Delete City
        $clsCity = new City();
        $lstCity = $clsCity->getAll("country_id='$country_id'", $clsCity->pkey);
        if (is_array($lstCity) && count($lstCity) > 0) {
            for ($i = 0; $i < count($lstCity); $i++) {
                $clsCity->updateOne($lstCity[$i]['city_id'], "country_id=0");
            }
        }
        $clsHotel = new Hotel();
        $lstHotel = $clsHotel->getAll("country_id='$country_id'");
        if (is_array($lstHotel) && count($lstHotel) > 0) {
            for ($i = 0; $i < count($lstHotel); $i++) {
                $clsHotel->updateOne($lstHotel[$i][$clsHotel->pkey], "country_id=0,city_id=0,region_id=0");
            }
        }

        // Delete 
        $clsCityStore = new CityStore();
        $clsCityStore->deleteByCond("country_id='$country_id'");
        // Delete
        $clsTourDestination = new TourDestination();
        $clsTourDestination->deleteByCond("country_id='$country_id'");
        // Delete
        $this->deleteOne($country_id);
        return 1;
    }
}
