<?php
class Destination extends dbBasic
{

    function __construct()
    {
        $this->pkey = "destination_id";
        $this->tbl = DB_PREFIX . "destination";
    }

    function getId($destination_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($destination_id, 'destination_id');
        return $one['destination_id'];
    }
    function checkExitsId($destination_id = 0)
    {
        $res = $this->getAll("destination_id = '$destination_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }

    function getMapHTML($destination_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($destination_id);
        $html = '';
        #
        $html .= '<div class=\'infomap\'>';
        $html .= '<div class=\'wrap\'>';
        $html .= '<a class=\'photo\' href=' . $this->getLink($destination_id) . ' title=' . $this->getTitle($destination_id) . '>
					<img src=' . $this->getImage($destination_id, 120, 80) . ' />
				</a>';
        $html .= '<div class=\'r\'>
					<h2 class=\'title_map\'>
						<a href=' . $this->getLink($destination_id) . ' title=' . $this->getTitle($destination_id) . '>' . $this->getTitle($destination_id) . '</a>
					</h2>
					<div class=\'formatMap\'>' . $clsISO->myTruncate(strip_tags($this->getIntro($destination_id)), 250) . ' <a href=' . $this->getLink($destination_id) . ' tile=\'View more\'>View more</a></div>
					<div class=\'wrap\' style=\'margin-top:5px\'>
						<a href=' . $this->getLink($destination_id, 'Hotel') . ' tile=\'View all hotels\'>View all hotels</a> | <a href=' . $this->getLink($destination_id) . ' title=\'View all tours\'>View all tours</a>
					</div>
		        </div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    function getMapHTMLTOUR($destination_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($destination_id);
        #
        $html = '<div class=\'infomap\'>';
        $html .= '<div class=\'wrap\'>';
        $html .= '<a class=\'photo\' href=' . $this->getLink($destination_id) . ' title=' . $this->getTitle($destination_id) . '>
					
				</a>';

        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    function getTitle($destination_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($destination_id, 'title');
        return $one['title'];
    }

    function countNumberAreaCity($destination_id = 0)
    {
        $clsAreaCity = new AreaCity();
        $res = $clsAreaCity->getAll("is_trash='0' and destination_id='$destination_id'");
        if ($res[0]['area_destination_id'] != '')
            return count($res);
        return 0;
    }

    function getAuthor($destination_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($destination_id, 'author_photo');
        return $one['author_photo'];
    }

    function getSlug($destination_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($destination_id, 'slug');
        return $one['slug'];
    }

    function getBySlug($slug = '')
    {
        global $_LANG_ID;
        $res = $this->getAll("is_trash=0 and slug = '" . $slug . "' limit 0,1");
        return $res[0]['destination_id'];
    }

    function checkSlug($slug = '')
    {
        global $_LANG_ID;
        $res = $this->getAll("slug='" . $slug . "'");
        if (is_array($res) && count($res) > 0)
            return 0;
        return 1;
    }

    function getLatestTopCity($country_id = 0, $limit = '')
    {
        $limit = !empty($limit) ? 'limit ' . $limit : '';
        $res = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' and destination_id IN (SELECT destination_id FROM " . DB_PREFIX . "citystore WHERE type='TOP') order by order_no desc" . $limit, $this->pkey);
        return !empty($res) ? $res : '';
    }

    function getIntro($destination_id = 0, $type = '', $is_sort = false)
    {
        global $extLang, $_LANG_ID;
        $one = $this->getOne($destination_id);
        switch ($type) {
            case 'Attraction':
                return html_entity_decode($one['intro_attraction']);
                break;
            case 'Travel':
                return html_entity_decode($one['intro_travel']);
                break;
            case 'Hotel':
                return html_entity_decode($one['intro_hotel']);
                break;
            case 'Tour':
                return html_entity_decode($one['intro_tour']);
                break;
            case 'Banner':
                return html_entity_decode($one['intro_banner']);
                break;
            case 'FunFact':
                return html_entity_decode($one['intro_fastfact']);
                break;
            default:
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

    function getContent($pvalTable = 0)
    {
        if ($pvalTable != '') {
            $one = $this->getOne($pvalTable, 'content');
            return html_entity_decode($one['content']);
        }
        return false;
    }

    function getLink($destination_id = 0, $type = '', $is_sort = false)
    {
        global $extLang, $_LANG_ID;
        $clsCountry = new Country();
        $clsGuideCat = new GuideCat();
        $clsTourCategory = new TourCategory();
        $one = $this->getOne($destination_id, 'country_id');
        #
        switch ($type) {
            case 'Attraction':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '-destinations/' . $this->getSlug($destination_id) . '-attractions';
                break;
            case 'Travel':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '-destinations/' . $this->getSlug($destination_id) . '-travel-tips';
                break;
            case 'Blog':
                return $extLang . '/blog/' . $clsCountry->getSlug($one['country_id']) . '/' . $this->getSlug($destination_id);
                break;
            case 'Tour':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '/' . $this->getSlug($destination_id) . '/tours';
                break;
            case 'Map':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '-destinations/' . $this->getSlug($destination_id) . '-maps';
                break;
            case 'Hotel':
                return $extLang . '/hotels/' . $clsCountry->getSlug($one['country_id']) . '/' . $this->getSlug($destination_id);
                break;
            case 'hotel':
                return $extLang . '/khach-san/' . 'khach-san-' . $this->getSlug($destination_id);
                break;
            case 'freeEasy':
                return $extLang . '/tours/du-lich-free-easy-c1/' . $this->getSlug($destination_id);
                break;
            case 'Guide':
                return $extLang . '/travel-guide/' . $this->getSlug($destination_id) . '/' . $clsGuideCat->getSlug($cat_id);
                break;
            case 'OldLink':
                return $extLang . '/vietnam-destinations/' . $this->getSlug($destination_id);
                break;
            case 'Landtour':
                return $extLang . '/destinations/' . $this->getSlug($destination_id) . '-land-tours';
                break;
            default:
                return $extLang . '/destinations/' . $clsCountry->getSlug($one['country_id']) . '/' . $this->getSlug($destination_id);
        }
    }

    function getLinkGuide($cat_id = 0, $destination_id = '', $Country = '')
    {
        global $extLang, $_LANG_ID;
        $clsCountry = new Country();
        $clsGuideCat = new GuideCat();
        $slugCity = $this->getSlug($destination_id);
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

    function getSelectCity($country_id = 0, $region_id = 0, $destination_id = '', $order_by = '')
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
        $lstItem = $this->getAll($cond . $order);
        $html = '<option value="0">-- ' . $core->get_Lang('selectcity') . ' --</option>';
        if (is_array($lstItem) && count($lstItem) > 0) {
            foreach ($lstItem as $k => $v) {
                $html .= '<option value="' . $v[$this->pkey] . '" ' . ($destination_id == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
            }
            unset($lstItem);
        }
        #
        return $html;
    }

    function getSelectDeparturePoint($tour_group_id = 0, $selected = '')
    {
        global $core;
        $clsCityStore = new CityStore();
        $cond = "is_trash=0 and type='DEPARTUREPOINT' order by order_no ASC";
        if (1 == 2 && intval($tour_group_id) > 0) {
        }
        $lstICity = $clsCityStore->getAll($cond, "destination_id");
        $html = '<option value="0">-- ' . $core->get_Lang('select') . ' --</option>';
        if (is_array($lstICity) && count($lstICity) > 0) {
            foreach ($lstICity as $k => $item) {
                $html .= '<option value="' . $item['destination_id'] . '" ' . ($selected == $item[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($item['destination_id']) . '</option>';
            }
            unset($lstICity);
        }
        return $html;
    }

    function getSelectMultiDeparturePoint($tour_group_id = 0, $selected = '')
    {
        global $core, $clsISO;
        $clsCityStore = new CityStore();
        $cond = "is_trash=0 and type='DEPARTUREPOINT' order by order_no ASC";
        $lstICity = $clsCityStore->getAll($cond, "destination_id");
        $html = '<option value="0">-- ' . $core->get_Lang('select') . ' --</option>';
        if (is_array($lstICity) && count($lstICity) > 0) {
            foreach ($lstICity as $k => $item) {
                $_array = $this->getArray($selected);
                $html .= '<option value="' . $item['destination_id'] . '" ' . ($clsISO->checkItemInArray($item['destination_id'], $_array) ? 'selected="selected"' : '') . '>' . $this->getTitle($item['destination_id']) . '</option>';
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
    function getRegion($destination_id = 0)
    {
        $clsCityStore = new CityStore();
        $lstCity = $clsCityStore->getAll("is_trash=0 and destination_id='$destination_id' and type='REGION' order by order_no Desc");
        return $lstCity['0']['region_id'];
    }
    function getListCityByRegion($region_id = 0, $destination_id = '')
    {
        $clsCity = new City();
        $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and region_id='$region_id' and destination_id<>'$destination_id' order by order_no ASC");
        return $lstCity;
    }
    function getListCityHotelByRegion($region_id = 0)
    {
        $clsCity = new City();
        $sql = "is_trash=0 and is_online=1 and region_id='$region_id' and destination_id IN (SELECT destination_id FROM " . DB_PREFIX . "hotel WHERE is_trash=0 and is_online=1) order by order_no ASC";

        $lstCity = $clsCity->getAll($sql);
        return $lstCity;
    }
    function getListCityGuideCatByRegion($region_id = 0, $guidecat_id)
    {
        $clsCity = new City();
        $sql = "is_trash=0 and is_online=1 and region_id='$region_id' and destination_id IN (SELECT destination_id FROM " . DB_PREFIX . "guide WHERE is_trash=0 and is_online=1 and (cat_id='$guidecat_id' or list_cat_id like '%|$guidecat_id|%')) order by order_no ASC";

        $lstCity = $clsCity->getAll($sql);
        return $lstCity;
    }

    function getImage($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image");
        if ($oneTable['image'] != '') {
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
    function getImageBannerHotel($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, 'image_hotel');
        if ($oneTable['image_hotel'] != '') {
            $image = $oneTable['image_hotel'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }
    function getBanner($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, 'banner');
        if ($oneTable['banner'] != '') {
            $image = $oneTable['banner'];
            return $clsISO->tripslashImage($image, $w, $h);
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
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }
    function getLinkVideoTeaser($pval = 0)
    {
        $oneTable = $this->getOne($pval, 'video_teaser');
        return $oneTable['video_teaser'];
    }
    function getMapLa($destination_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($destination_id);
        return $one['map_la'];
    }

    function getMapLo($destination_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($destination_id);
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

    function _makeSelectboxOption($destination_id = '', $country_id = 0)
    {
        global $core, $_LANG_ID;
        $lstItem = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc");
        $html = '<option value="">' . $core->get_Lang('City') . '</option>';
        if (count($lstItem) > 1) {
            foreach ($lstItem as $item) {
                $selected = ($destination_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function makeSelectboxOption($destination_id = '', $country_id = 0)
    {
        global $core, $_LANG_ID;
        $country_id = ($country_id == 0) ? 1 : $country_id;
        $lstItem = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc");
        $html = '<option value="">' . $core->get_Lang('City') . '</option>';
        if (count($lstItem) > 0) {
            foreach ($lstItem as $item) {
                $selected = ($destination_id == $item[$this->pkey]) ? 'selected="selected"' : '';
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

    function doDelete($destination_id = 0)
    {
        // Delete
        $clsHotel = new Hotel();
        $lstHotel = $clsHotel->getAll("destination_id='$destination_id'");
        if (is_array($lstHotel) && count($lstHotel) > 0) {
            for ($i = 0; $i < count($lstHotel); $i++) {
                $clsHotel->doDelete($lstHotel[$i][$clsHotel->pkey]);
            }
        }
        // Delete 
        $clsGuide = new Guide();
        $clsGuide->deleteByCond("destination_id='$destination_id'");
        $lstGuide = $clsGuide->getAll("list_destination_id like '%|" . $destination_id . "|%'");
        if (is_array($lstGuide) && count($lstGuide) > 0) {
            for ($i = 0; $i < count($lstGuide); $i++) {
                $list_destination_id = str_replace('|' . $destination_id, '', $lstGuide[$i]['list_destination_id']);
                $clsGuide->updateOne($lstGuide[$i][$clsGuide->pkey], "list_destination_id = '" . $list_destination_id . "'");
            }
        }
        // Delete 
        $clsCityStore = new CityStore();
        $clsCityStore->deleteByCond("destination_id='$destination_id'");
        // Delete 
        $clsTourDestination = new TourDestination();
        $clsTourDestination->deleteByCond("destination_id='$destination_id'");
        // Delete
        $this->deleteOne($destination_id);
        return 1;
    }

    function getListCityByCountry($country_id = 0)
    {
        return $this->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and destination_id IN (SELECT destination_id FROM " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no ASC", $this->pkey);
    }

    function countHotel($country_id = 0, $destination_id = 0, $area_destination_id = 0)
    {
        $clsHotel = new Hotel();
        $sql = "is_trash=0 and is_online=1";
        if (intval($country_id) > 0) {
            $sql .= " and country_id='$country_id'";
        }
        if (intval($destination_id) > 0) {
            $sql .= " and destination_id='$destination_id'";
        }
        if (intval($area_destination_id) > 0) {
            $sql .= " and area_destination_id='$area_destination_id'";
        }
        return $clsHotel->countItem($sql);
    }

    function getNumberHotel($destination_id = 0)
    {
        $clsHotel = new Hotel();
        $all = $clsHotel->getAll("is_trash=0 and destination_id='$destination_id'");
        return (is_array($all) && count($all) > 0) ? count($all) : 0;
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
    function checkExitsDesID($DesID = 0)
    {
        $res = $this->getAll("des_id = '$DesID' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }
}
