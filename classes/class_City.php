<?php

class City extends dbBasic
{
    function __construct()
    {
        $this->pkey = "city_id";
        $this->tbl = DB_PREFIX . "city";
    }

    function getId($city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($city_id, 'city_id');
        return $one['city_id'] ?? 0;
    }

    function checkExitsId($city_id = 0)
    {
        $res = $this->getAll("city_id = '$city_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }

    function getMapHTML($city_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($city_id);
        $html = '';
        #
        $html .= '<div class=\'infomap\'>';
        $html .= '<div class=\'wrap\'>';
        $html .= '<a class=\'photo\' href=' . $this->getLink($city_id) . ' title=' . $this->getTitle($city_id) . '>
					<img src=' . $this->getImage($city_id, 120, 80) . ' />
				</a>';
        $html .= '<div class=\'r\'>
					<h2 class=\'title_map\'>
						<a href=' . $this->getLink($city_id) . ' title=' . $this->getTitle($city_id) . '>' . $this->getTitle($city_id) . '</a>
					</h2>
					<div class=\'formatMap\'>' . $clsISO->myTruncate(strip_tags($this->getIntro($city_id)), 250) . ' <a href=' . $this->getLink($city_id) . ' tile=\'View more\'>View more</a></div>
					<div class=\'wrap\' style=\'margin-top:5px\'>
						<a href=' . $this->getLink($city_id, 'Hotel') . ' tile=\'View all hotels\'>View all hotels</a> | <a href=' . $this->getLink($city_id) . ' title=\'View all tours\'>View all tours</a>
					</div>
		        </div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    function getMapHTMLTOUR($city_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($city_id);
        #
        $html = '<div class=\'infomap\'>';
        $html .= '<div class=\'wrap\'>';
        $html .= '<a class=\'photo\' href=' . $this->getLink($city_id) . ' title=' . $this->getTitle($city_id) . '>
				</a>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    function getTitle($city_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['title'])) {
            $one = $this->getOne($city_id, 'title');
        }
        return $one['title'] ?? '';
    }

    function countNumberAreaCity($city_id = 0)
    {
        $clsAreaCity = new AreaCity();
        $res = $clsAreaCity->getAll("is_trash='0' and city_id='$city_id'", $clsAreaCity->pkey);
        return $res ? count($res) : 0;
    }

    function getCategoriesChart()
    {
        $arr = '';
        $lstCity = $this->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,10");
        if (!empty($lstCity)) {
            foreach ($lstCity as $k => $v) {
                $arr .= '\'';
                $arr .= $this->getTitle($v['city_id']);
                $arr .= '\'';
                $arr .= ($k == count($lstCity) - 1) ? '' : ',';
            }
        }
        return $arr;
    }

    function getAuthor($city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($city_id, 'author_photo');
        return $one['author_photo'];
    }

    function getSlug($city_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['slug'])) {
            $one = $this->getOne($city_id, 'slug');
        }
        return $one['slug'] ?? '';
    }

    function getBySlug($slug = '')
    {
        global $_LANG_ID;
        $res = $this->getAll("is_trash=0 and slug = '" . $slug . "' limit 0,1", $this->pkey);
        return $res[0]['city_id'];
    }

    function checkSlug($slug = '')
    {
        global $_LANG_ID;
        $res = $this->getAll("slug='" . $slug . "' limit 0,1");
        if (is_array($res) && count($res) > 0)
            return 0;
        return 1;
    }

    function getLatestTopCity($country_id = 0, $limit = '')
    {
        $limit = !empty($limit) ? 'limit ' . $limit : '';
        $res = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE type='TOP') order by order_no desc" . $limit, $this->pkey);
        return !empty($res) ? $res : '';
    }

    function getMetaDescription($pvalTable = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro']);
    }

    function getIntro($city_id = 0, $type = '', $is_sort = false, $one = null)
    {
        global $extLang, $_LANG_ID;

        switch ($type) {
            case 'Attraction':
                if (!isset($one['intro_attraction'])) {
                    $one = $this->getOne($city_id);
                }
                return html_entity_decode($one['intro_attraction']);
                break;
            case 'Travel':
                if (!isset($one['intro_travel'])) {
                    $one = $this->getOne($city_id);
                }
                return html_entity_decode($one['intro_travel']);
                break;
            case 'Hotel':
                if (!isset($one['intro_hotel'])) {
                    $one = $this->getOne($city_id);
                }
                return html_entity_decode($one['intro_hotel']);
                break;
            case 'Tour':
                if (!isset($one['intro_tour'])) {
                    $one = $this->getOne($city_id);
                }
                return html_entity_decode($one['intro_tour']);
                break;
            case 'Banner':
                if (!isset($one['intro_banner'])) {
                    $one = $this->getOne($city_id);
                }
                return html_entity_decode($one['intro_banner']);
                break;
            case 'FunFact':
                if (!isset($one['intro_fastfact'])) {
                    $one = $this->getOne($city_id);
                }
                return html_entity_decode($one['intro_fastfact']);
                break;
            default:
                if (!isset($one['intro'])) {
                    $one = $this->getOne($city_id);
                }
                return html_entity_decode($one['intro']);
        }
    }

    function getStripIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'intro,content');
        if (!empty($one['intro']))
            return html_entity_decode($one['intro']);
        return html_entity_decode($one['content']);
    }

    function getContent($pvalTable = '', $one = null)
    {
        if ($pvalTable != '') {
            if (!isset($one['content'])) {
                $one = $this->getOne($pvalTable, 'content');
            }
            return html_entity_decode($one['content']);
        }
        return false;
    }

    function getLink($city_id = 0, $type = '', $is_sort = false, $one = null)
    {
        global $extLang, $_LANG_ID;
        $clsCountry = new Country();
        $clsGuideCat = new GuideCat();

        if (!isset($one['country_id'])) {
            $country_id = $this->getOneField('country_id', $city_id);
        } else {
            $country_id = $one['country_id'];
        }

        #
        switch ($type) {
            case 'Attraction':
                return $extLang . '/' . $clsCountry->getSlug($country_id) . '-destinations/' . $this->getSlug($city_id, $one) . '-attractions';
                break;
            case 'Travel':
                return $extLang . '/' . $clsCountry->getSlug($country_id) . '-destinations/' . $this->getSlug($city_id, $one) . '-travel-tips';
                break;
            case 'Blog':
                return $extLang . '/blog/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($city_id, $one);
                break;
            case 'Tour':
                return $extLang . '/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($city_id, $one) . '/tours';
                break;
            case 'Map':
                return $extLang . '/' . $clsCountry->getSlug($country_id) . '-destinations/' . $this->getSlug($city_id, $one) . '-maps';
                break;
            case 'Hotel':
                if ($_LANG_ID == 'vn')
                    return $extLang . '/khach-san/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($city_id, $one);
                return $extLang . '/hotels/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($city_id, $one);
                break;
            case 'hotel':
                return $extLang . '/khach-san/' . 'khach-san-' . $this->getSlug($city_id, $one);
                break;
            case 'freeEasy':
                return $extLang . '/tours/du-lich-free-easy-c1/' . $this->getSlug($city_id, $one);
                break;
            case 'Guide':
                return $extLang . '/travel-guide/' . $this->getSlug($city_id, $one) . '/' . $clsGuideCat->getSlug($cat_id);
                break;
            case 'OldLink':
                return $extLang . '/vietnam-destinations/' . $this->getSlug($city_id, $one);
                break;
            case 'Landtour':
                return $extLang . '/destinations/' . $this->getSlug($city_id, $one) . '-land-tours';
                break;
            case 'Outbound':
                return $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($city_id, $one);
                break;
            default:
                return $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($city_id, $one);
                break;
        }
    }

    function getLinkTour($city_id = 0, $oneCity = null)
    {
        global $extLang, $_LANG_ID, $clsISO;
        if (!isset($oneCity['country_id'])) {
            $oneCity = $this->getOne($city_id, 'country_id');
        }
        $country_id = $oneCity['country_id'] ?? 0;
        if ($clsISO->checkInArray('1,4', $country_id)) {
            return $this->getLinkInbound($city_id, $oneCity);
        } else {
            return $this->getLinkOutbound($city_id, $oneCity);
        }
    }

    function getLinkInbound($pvalTable = 0, $oneCity = null, $is_new = "")
    {
        global $core, $_LANG_ID, $extLang;
        if (!isset($oneCity['slug'])) {
            $slug = $this->getSlug($pvalTable);
        } else {
            $slug = $oneCity['slug'];
        }
        if ($_LANG_ID == 'vn') {
            return $extLang . '/du-lich-trong-nuoc/du-lich-' . $slug;
        }
        return $extLang . "/{$is_new}inbound-tours/" . $slug;
    }

    function getLinkInboundBySlug($slug = '')
    {
        global $core, $_LANG_ID, $extLang;
        if ($_LANG_ID == 'vn') {
            return $extLang . '/du-lich-trong-nuoc/du-lich-' . $slug;
        }
        return $extLang . '/inbound-tours/' . $slug;
    }

    function getLinkOutbound($pvalTable = 0, $oneCity = null)
    {
        global $core, $_LANG_ID, $extLang;
        $clsCountry = new Country();
        if (!isset($oneCity['country_id'])) {
            $country_id = $this->getOneField('country_id', $pvalTable);
        } else {
            $country_id = $oneCity['country_id'];
        }

        if (!isset($oneCity['slug'])) {
            $slug = $this->getSlug($pvalTable);
        } else {
            $slug = $oneCity['slug'];
        }
        if ($_LANG_ID == 'vn') {
            return $extLang . '/du-lich-nuoc-ngoai/du-lich-' . $clsCountry->getSlug($country_id) . '/' . $slug;
        } else {
            return $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $slug;
        }
    }

    function getLinkGuide($cat_id = 0, $city_id = '', $Country = '')
    {
        global $extLang, $_LANG_ID;
        $clsCountry = new Country();
        $clsGuideCat = new GuideCat();
        $slugCity = $this->getSlug($city_id);
        $slugCountry = $clsCountry->getSlug($Country);
        $slugCate = $clsGuideCat->getSlug($cat_id);
        if (!empty($slugCity) && !empty($slugCountry) && !empty($slugCate)) {
            return $extLang . '/destinations/' . $slugCountry . '/' . $slugCity . '/' . $slugCate . ".html";
        } else if (!empty($slugCountry) && empty($slugCity) && !empty($slugCate)) {
            return $extLang . '/destinations/' . $slugCountry . '/' . $slugCate . ".html";
        } else if (!empty($slugCountry) && !empty($slugCity) && empty($slugCate)) {
            return $extLang . '/destinations/' . $slugCountry . '/' . $slugCity;
        } else if (!empty($slugCountry) && empty($slugCity) && empty($slugCate)) {
            return $extLang . '/destinations/' . $slugCountry;
        }
        return false;
    }

    function getSelectCity($country_id = 0, $region_id = 0, $city_id = '', $order_by = '')
    {
        global $core;
        #
        $cond = "is_trash=0";
        if (intval($country_id) != 0) {
            $cond .= " and country_id='$country_id'";
        }
        if (intval($region_id) != 0) {
            $cond .= " and region_id='$region_id'";
        }
        $order = " order by order_no asc";
        if (!empty($order_by))
            $order = " order by {$order_by} asc";
        #
        $lstItem = $this->getAll($cond . $order, $this->pkey);
        $html = '<option value="0">-- ' . $core->get_Lang('selectcity') . ' --</option>';
        if (is_array($lstItem) && count($lstItem) > 0) {
            foreach ($lstItem as $k => $v) {
                $html .= '<option value="' . $v[$this->pkey] . '" ' . ($city_id == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
            }
            unset($lstItem);
        }
        #
        return $html;
    }

    function getSelectCityHotel($country_id = 0, $region_id = 0, $city_id = '', $order_by = '')
    {
        global $core;
        $clsHotel = new Hotel();
        $cond = "is_trash=0 and is_online=1 and city_id IN (SELECT city_id FROM " . $clsHotel->tbl . " WHERE is_trash=0 and city_id > 0)";
        if (intval($country_id) > 0) {
            $cond .= " and country_id='$country_id'";
        }
        if (intval($region_id) > 0) {
            $cond .= " and region_id='$region_id'";
        }
        $order = " order by order_no asc";
        if (!empty($order_by))
            $order = " order by {$order_by} asc";

        $lstItem = $this->getAll($cond . $order, $this->pkey . ",title");
        $html = '';
        if (is_array($lstItem) && count($lstItem) > 0) {
            foreach ($lstItem as $k => $v) {
                $html .= '<option value="' . $v[$this->pkey] . '" ' . ($city_id == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey], $v) . '</option>';
            }
            unset($lstItem);
        }
        return $html;
    }

    function getSelectDeparturePoint($tour_group_id = 0, $selected = '')
    {
        global $core;
        $clsCityStore = new CityStore();
        $cond = "is_trash=0 and type='DEPARTUREPOINT' order by order_no ASC";
        $lstICity = $clsCityStore->getAll($cond, "city_id");
        $html = '<option value="0">-- ' . $core->get_Lang('select') . ' --</option>';
        if (is_array($lstICity) && count($lstICity) > 0) {
            foreach ($lstICity as $k => $item) {
                $html .= '<option value="' . $item['city_id'] . '" ' . ($selected == $item[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($item['city_id']) . '</option>';
            }
            unset($lstICity);
        }
        return $html;
    }

    function getSelectMultiDeparturePoint($tour_group_id = 0, $selected = '', $is_prefix = true)
    {
        global $core, $clsISO;
        $clsCityStore = new CityStore();
        $cond = "is_trash=0 and type='DEPARTUREPOINT' order by order_no ASC";
        $lstICity = $clsCityStore->getAll($cond, "city_id");
        $html = !$is_prefix ? '' : '<option value="0">-- ' . $core->get_Lang('select') . ' --</option>';
        if (is_array($lstICity) && count($lstICity) > 0) {
            foreach ($lstICity as $k => $item) {
                $_array = $this->getArray($selected);
                $html .= '<option value="' . $item['city_id'] . '" ' . ($clsISO->checkItemInArray($item['city_id'], $_array) ? 'selected="selected"' : '') . '>' . $this->getTitle($item['city_id']) . '</option>';
            }
            unset($lstICity);
        }
        return $html;
    }

    function makeSelectboxOption___($selected = '')
    {
        global $core, $clsConfiguration, $clsISO;
        $sql = "is_trash=0";
        #
        $lstTag = $this->getAll($sql . " order by tag_id DESC");
        $html = '<option value="0">-- ' . $core->get_Lang('selecttags') . ' --</option>';
        if (is_array($lstTag) && count($lstTag) > 0) {
            foreach ($lstTag as $k => $v) {
                $_array = $this->getArray($selected);
                $html .= '<option value="' . $v[$this->pkey] . '" ' . ($clsISO->checkItemInArray($v[$this->pkey], $_array) ? 'selected="selected"' : '') . '>-- ' . $this->getTitle($v[$this->pkey]) . '</option>';
            }
            unset($lstTag);
        }
        return $html;
    }

    function getSelectCityByDepartPoint($country_id = 0, $tour_type_id = 0, $selected = '')
    {
        global $core;
        $clsTour = new Tour();
        $cond = 'is_trash=0';
        if (isset($country_id) && intval($country_id) != 0) {
            $cond .= ' and country_id = ' . $country_id;
        }
        $lstItem = $this->getAll($cond . " order by order_no desc", $this->pkey);
        $html = '<option value="">-- ' . $core->get_Lang('selectcity') . ' --</option>';
        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                $all = $clsTour->getAll("is_trash=0 and depart_point_id = '" . $item[$this->pkey] . "' and tour_type_id = '$tour_type_id' limit 0,1");
                if (!empty($all)) {
                    $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>-- ' . $this->getTitle($item[$this->pkey]) . ' --</option>';
                }
            }
        }
        return $html;
    }

    function getRegion($city_id = 0)
    {
        $clsCityStore = new CityStore();
        $lstCity = $clsCityStore->getAll("is_trash=0 and city_id='$city_id' and type='REGION' order by order_no Desc");
        return $lstCity['0']['region_id'];
    }

    function getListCityByRegion($region_id = 0, $city_id = '')
    {
        $clsCity = new City();
        $clsRegion = new Region();
        $country_id = $clsRegion->getOneField('country_id', $region_id);
        $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id='$region_id' and city_id<>'$city_id' order by order_no ASC", $clsCity->pkey . ',title,slug,country_id');
        return $lstCity;
    }

    function getListCityTourByCountry($country_id = 0)
    {
        $clsCity = new City();
        $clsRegion = new Region();
        $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0) order by order_no ASC", $clsCity->pkey . ",title,slug");
        return $lstCity;
    }

    function getListCityTourByRegion($region_id = 0, $city_id = '', $country_id = '')
    {
        $clsCity = new City();
        $clsRegion = new Region();
        if ($country_id != '') {
            $country_id = $clsRegion->getOneField('country_id', $region_id);
        }
        $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and region_id='$region_id' and city_id<>'$city_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0) order by order_no ASC", $clsCity->pkey . ",title,slug");
        return $lstCity;
    }

    function getListCityHotelByRegion($region_id = 0, $city_id = '')
    {
        $clsCity = new City();
        $clsRegion = new Region();
        $country_id = $clsRegion->getOneField('country_id', $region_id);
        $sql = "is_trash=0 and is_online=1 and country_id='$country_id' and region_id='$region_id' and city_id <>'$city_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "hotel WHERE is_trash=0 and is_online=1) order by order_no ASC";
        $lstCity = $clsCity->getAll($sql, $clsCity->pkey . ',title,slug,country_id');
        return $lstCity;
    }

    function getListCityGuideCatByRegion($region_id = 0, $guidecat_id = 0)
    {
        $clsCity = new City();
        $sql = "is_trash=0 and is_online=1 and region_id='$region_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "guide WHERE is_trash=0 and is_online=1 and (cat_id='$guidecat_id' or list_cat_id like '%|$guidecat_id|%')) order by order_no ASC";
        $lstCity = $clsCity->getAll($sql, $clsCity->pkey);
        return $lstCity;
    }

    function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        if (!isset($oneTable['image'])) {
            $oneTable = $this->getOne($pvalTable, "image");
        }
        if ($oneTable['image'] != '' && $clsISO->checkFileExists($oneTable['image'])) {
            $image = $oneTable['image'];
            return $clsISO->tripslashImage($image, $w, $h);
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
            $noimage = URL_IMAGES . '/noimage.png';
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getBanner($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        #
        if (!isset($oneTable['banner'])) {
            $oneTable = $this->getOne($pvalTable, 'banner');
        }
        if ($oneTable['banner'] != '') {
            $image = $oneTable['banner'];
            return $clsISO->tripslashImage($image, $w, $h);
            $noimage = URL_IMAGES . '/noimage.png';
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getBannerUrl($pval = 0)
    {
        $oneTable = $this->getOne($pval, 'link_banner');
        return $oneTable['link_banner'];
    }

    function getBannerImage($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, 'banner');
        if ($oneTable['banner'] != '') {
            $banner = $oneTable['banner'];
            return $clsISO->tripslashImage($banner, $w, $h);
            $noimage = URL_IMAGES . '/noimage.png';
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getImageHome($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, 'imagehome');
        if ($oneTable['imagehome'] != '') {
            $image = $oneTable['imagehome'];
            return $clsISO->tripslashImage($image, $w, $h);
            $noimage = URL_IMAGES . '/noimage.png';
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getLinkVideoTeaser($pval = 0)
    {
        $oneTable = $this->getOne($pval, 'video_teaser');
        return $oneTable['video_teaser'];
    }

    function getMapLa($city_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['map_la'])) {
            $one = $this->getOne($city_id, 'map_la');
        }
        return $one['map_la'];
    }

    function getMapLo($city_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['map_lo'])) {
            $one = $this->getOne($city_id, 'map_lo');
        }
        return $one['map_lo'];
    }

    function getFirstLocation($tour_id = 0)
    {
        $clsTourDestination = new TourDestination();
        $res = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc limit 0,1");
        $one = $res[0];
        return $this->getMapLa($one['destination_id']) . ',' . $this->getMapLo($one['destination_id']);
    }

    function getListCity($area_id = 0, $limit = '')
    {
        $limit = !empty($limit) ? 'limit ' . $limit : '';
        $res = $this->getAll("is_trash=0 and is_online=1 and area_id = '$area_id' order by order_no asc " . $limit, $this->pkey);
        return !empty($res) ? $res : '';
    }

    function _makeSelectboxOption($city_id = '', $country_id = 0)
    {
        global $core, $_LANG_ID;
        $lstItem = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc");
        $html = '<option value="">' . $core->get_Lang('City') . '</option>';
        if (count($lstItem) > 1) {
            foreach ($lstItem as $item) {
                $selected = ($city_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function makeSelectboxOption($city_id = '', $country_id = 0)
    {
        global $core, $_LANG_ID;
        $country_id = ($country_id == 0) ? 1 : $country_id;
        $lstItem = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc", $this->pkey);
        $html = '<option value="0">' . $core->get_Lang('City') . '</option>';
        if (count($lstItem) > 0) {
            foreach ($lstItem as $item) {
                $selected = ($city_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function makeSelectboxOptionnew($city_id = '', $country_id = 0, $region_id = 0)
    {
        global $core, $_LANG_ID;
        $country_id = ($country_id == 0) ? 1 : $country_id;
        if ($region_id == 0) {
            $lstItem = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc");
        } else {
            $lstItem = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' and region_id = '$region_id' order by title asc");
        }
        //      $lstItem = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc");
        $html = '<option value="">' . $core->get_Lang('City') . '</option>';
        if (count($lstItem) > 0) {
            foreach ($lstItem as $item) {
                $selected = ($city_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function getChild($tourcat_id = 0, $limit = 0, $trash = true)
    {
        $sql = "parent_id='$tourcat_id'";
        if ($trash) {
            $sql .= " and is_trash=0";
        }
        $sql .= " order by order_no ASC";
        if ($limit > 0) {
            $sql .= " LIMIT 0,$limit";
        }
        $res = $this->getAll($sql);
        return $res;
    }

    function getListCityByCountry($country_id = 0)
    {
        return $this->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no ASC", "$this->pkey, title");
    }

    function countHotel($country_id = 0, $city_id = 0, $area_city_id = 0)
    {
        $clsHotel = new Hotel();
        $sql = "is_trash=0 and is_online=1";
        if (intval($country_id) > 0) {
            $sql .= " and country_id='$country_id'";
        }
        if (intval($city_id) > 0) {
            $sql .= " and city_id='$city_id'";
        }
        if (intval($area_city_id) > 0) {
            $sql .= " and area_city_id='$area_city_id'";
        }
        $res = $clsHotel->getAll($sql, $clsHotel->pkey);
        return $res ? count($res) : 0;
    }

    function getNumberHotel($city_id = 0)
    {
        $clsHotel = new Hotel();
        $all = $clsHotel->getAll("is_trash=0 and city_id='$city_id'", $clsHotel->pkey);
        return $all ? count($all) : 0;
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

    function doDelete($city_id = 0)
    {
        // Delete
        $clsHotel = new Hotel();
        $lstHotel = $clsHotel->getAll("city_id='$city_id'");
        if (is_array($lstHotel) && count($lstHotel) > 0) {
            for ($i = 0; $i < count($lstHotel); $i++) {
                $clsHotel->updateOne($lstHotel[$i][$clsHotel->pkey], "country_id=0,city_id=0,region_id=0");
            }
        }
        // Delete 
        $clsCityStore = new CityStore();
        $clsCityStore->deleteByCond("city_id='$city_id'");
        // Delete 
        $clsTourDestination = new TourDestination();
        $clsTourDestination->deleteByCond("city_id='$city_id'");
        // Delete
        $this->deleteOne($city_id);
        return 1;
    }
    function getCountryByCity($city_id = 0)
    {
        $one = $this->getOne($city_id, 'country_id');
        return $one['country_id'];
    }
}
