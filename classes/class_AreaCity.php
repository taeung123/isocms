<?php
class AreaCity extends dbBasic
{

    function __construct()
    {
        $this->pkey = "area_city_id";
        $this->tbl = DB_PREFIX . "area_city";
    }

    function getId($area_city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($area_city_id);
        return $one['area_city_id'];
    }
    function checkExitsId($area_city_id = 0)
    {
        $res = $this->getAll("area_city_id = '$area_city_id' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }

    function getMapHTML($area_city_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($area_city_id);
        #
        $html = '<div class=\'infomap\'>';
        $html .= '<div class=\'wrap\'>';
        $html .= '<a class=\'photo\' href=' . $this->getLink($area_city_id) . ' title=' . $this->getTitle($area_city_id) . '>
					<img src=' . $this->getImage($area_city_id, 120, 80) . ' />
				</a>';
        $html .= '<div class=\'r\'>
					<h2 class=\'title_map\'>
						<a href=' . $this->getLink($area_city_id) . ' title=' . $this->getTitle($area_city_id) . '>' . $this->getTitle($area_city_id) . '</a>
					</h2>
					<div class=\'formatMap\'>' . $clsISO->myTruncate(strip_tags($this->getIntro($area_city_id)), 250) . ' <a href=' . $this->getLink($area_city_id) . ' tile=\'View more\'>View more</a></div>
					<div class=\'wrap\' style=\'margin-top:5px\'>
						<a href=' . $this->getLink($area_city_id, 'Hotel') . ' tile=\'View all hotels\'>View all hotels</a> | <a href=' . $this->getLink($area_city_id) . ' title=\'View all tours\'>View all tours</a>
					</div>
		        </div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    function getTitle($area_city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($area_city_id);
        return $one['title'];
    }

    function getAuthor($area_city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($area_city_id);
        return $one['author_photo'];
    }

    function getSlug($area_city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($area_city_id);
        return $one['slug'];
    }

    function getBySlug($slug = '')
    {
        $res = $this->getAll("is_trash=0 and slug like '%" . $slug . "%'");
        return $res[0]['area_city_id'];
    }

    function checkSlug($slug = '')
    {
        global $_LANG_ID;
        $res = $this->getAll("slug='" . $slug . "'");
        if (is_array($res) && count($res) > 0)
            return 0;
        return 1;
    }

    function getLatestTopAreaCity($country_id = 0, $limit = '')
    {
        $limit = !empty($limit) ? 'limit ' . $limit : '';
        $res = $this->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' and area_city_id IN (SELECT area_city_id FROM " . DB_PREFIX . "citystore WHERE type='TOP') order by order_no desc" . $limit, $this->pkey);
        return !empty($res) ? $res : '';
    }

    function getMetaDescription($pvalTable = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro']);
    }

    function getIntro($area_city_id = 0, $type = '', $is_sort = false)
    {
        global $extLang, $_LANG_ID;
        $one = $this->getOne($area_city_id);
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
            default:
                return html_entity_decode($one['intro']);
        }
    }

    function getStripIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        if (!empty($one['intro']))
            return html_entity_decode($one['intro']);
        return html_entity_decode($one['content']);
    }

    function getContent($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return html_entity_decode($one['content']);
    }

    function getLink($area_city_id = 0, $type = '', $is_sort = false)
    {
        global $extLang, $_LANG_ID;
        $clsCountry = new Country();
        $clsGuideCat = new GuideCat();
        $clsCity = new City();
        $one = $this->getOne($area_city_id);
        #
        switch ($type) {
            case 'Attraction':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '-destinations/' . $this->getSlug($area_city_id) . '-attractions';
                break;
            case 'Travel':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '-destinations/' . $this->getSlug($area_city_id) . '-travel-tips';
                break;
            case 'Tour':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '/' . $this->getSlug($area_city_id) . '/tours';
                break;
            case 'Map':
                return $extLang . '/' . $clsCountry->getSlug($one['country_id']) . '-destinations/' . $this->getSlug($area_city_id) . '-maps';
                break;
            case 'Hotel':
                return $extLang . '/hotels/' . $this->getSlug($area_city_id) . '-hotels';
                break;
            case 'Guide':
                return $extLang . '/travel-guide/' . $this->getSlug($area_city_id) . '/' . $clsGuideCat->getSlug($cat_id);
                break;
            case 'OldLink':
                return $extLang . '/vietnam-destinations/' . $this->getSlug($area_city_id);
                break;
            case 'Landtour':
                return $extLang . '/destinations/' . $this->getSlug($area_city_id) . '-land-tours';
                break;
            default:
                //return $extLang.'/'.$clsCountry->getSlug($one['country_id']).'-destinations/'.$this->getSlug($area_city_id);
                return $extLang . '/khach-san-' . $clsCity->getSlug($one['city_id']) . '/' . $this->getSlug($area_city_id);
        }
    }

    function getLinkGuide($cat_id = 0, $area_city_id = 0, $is_sort = false)
    {
        global $extLang, $_LANG_ID;
        $clsCountry = new Country();
        $clsGuideCat = new GuideCat();
        $one = $this->getOne($area_city_id);
        #
        return $extLang . '/destinations/' . $this->getSlug($area_city_id) . '/' . $clsGuideCat->getSlug($cat_id);
    }

    function getSelectAreaCity($country_id = 0, $region_id = 0, $area_city_id = '')
    {
        global $core;
        #
        $cond = "is_trash=0 and country_id='$country_id'";
        if (intval($region_id) != 0) {
            $cond .= " and region_id='$region_id'";
        }
        #
        $lstItem = $this->getAll($cond . " order by order_no asc");
        $html = '<option value="0">-- ' . $core->get_Lang('selectcity') . ' --</option>';
        if (is_array($lstItem) && count($lstItem) > 0) {
            foreach ($lstItem as $k => $v) {
                $html .= '<option value="' . $v[$this->pkey] . '" ' . ($area_city_id == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
            }
            unset($lstItem);
        }
        #
        return $html;
    }

    function getSelectDeparturePoint($tour_group_id = 0, $selected = '')
    {
        global $core;
        $clsAreaCityStore = new AreaCityStore();
        $cond = "is_trash=0 and type='DEPARTUREPOINT'";
        if (1 == 2 && intval($tour_group_id) > 0) {
        }
        $lstIAreaCity = $clsAreaCityStore->getAll($cond, "area_city_id");
        $html = '<option value="0">-- ' . $core->get_Lang('select') . ' --</option>';
        if (is_array($lstIAreaCity) && count($lstIAreaCity) > 0) {
            foreach ($lstIAreaCity as $k => $item) {
                $html .= '<option value="' . $item['area_city_id'] . '" ' . ($selected == $item[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($item['area_city_id']) . '</option>';
            }
            unset($lstIAreaCity);
        }
        return $html;
    }

    function getSelectAreaCityByDepartPoint($country_id = 0, $tour_type_id = 0, $selected = '')
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

    function getImage($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, "image");
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getImageHome($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "imagehome");
        if ($oneTable['imagehome'] != '') {
            $image = $oneTable['imagehome'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getMapLa($area_city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($area_city_id);
        return $one['map_la'];
    }

    function getMapLo($area_city_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($area_city_id);
        return $one['map_lo'];
    }

    function getFirstLocation($tour_id = 0)
    {
        $clsTourDestination = new TourDestination();
        $res = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc limit 0,1");
        $one = $res[0];
        return $this->getMapLa($one['destination_id']) . ',' . $this->getMapLo($one['destination_id']);
    }

    function getListAreaCity($area_id = 0, $limit = '')
    {
        $limit = !empty($limit) ? 'limit ' . $limit : '';
        $res = $this->getAll("is_trash=0 and is_online=1 and area_id = '$area_id' order by order_no asc " . $limit, $this->pkey);
        return !empty($res) ? $res : '';
    }

    function _makeSelectboxOption($area_city_id = '', $area_id = 0)
    {
        global $core;
        $lstItem = $this->getAll("is_trash=0 and area_id = '$area_id' order by order_no asc");
        $html = '<option value="">' . $core->get_Lang('AreaCity') . '</option>';
        if (count($lstItem) > 1) {
            foreach ($lstItem as $item) {
                $selected = ($area_city_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function makeSelectboxOption($area_city_id = '', $city_id = 0)
    {
        global $core;
        $city_id = ($city_id == 0) ? 1 : $city_id;
        $lstItem = $this->getAll("is_trash=0 and city_id = '$city_id' order by order_no asc");
        $html = '<option value="">' . $core->get_Lang('AreaCity') . '</option>';
        if (count($lstItem) > 1) {
            foreach ($lstItem as $item) {
                $selected = ($area_city_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
            unset($lstItem);
        }
        return $html;
    }

    function doDelete($area_city_id = 0)
    {
        // Delete
        $clsHotel = new Hotel();
        $lstHotel = $clsHotel->getAll("area_city_id='$area_city_id'");
        if (is_array($lstHotel) && count($lstHotel) > 0) {
            for ($i = 0; $i < count($lstHotel); $i++) {
                $clsHotel->doDelete($lstHotel[$i][$clsHotel->pkey]);
            }
        }
        // Delete 
        $clsGuide = new Guide();
        $clsGuide->deleteByCond("area_city_id='$area_city_id'");
        $lstGuide = $clsGuide->getAll("list_area_city_id like '%|" . $area_city_id . "|%'");
        if (is_array($lstGuide) && count($lstGuide) > 0) {
            for ($i = 0; $i < count($lstGuide); $i++) {
                $list_area_city_id = str_replace('|' . $area_city_id, '', $lstGuide[$i]['list_area_city_id']);
                $clsGuide->updateOne($lstGuide[$i][$clsGuide->pkey], "list_area_city_id = '" . $list_area_city_id . "'");
            }
        }
        // Delete 
        $clsAreaCityStore = new AreaCityStore();
        $clsAreaCityStore->deleteByCond("area_city_id='$area_city_id'");
        // Delete 
        $clsTourDestination = new TourDestination();
        $clsTourDestination->deleteByCond("area_city_id='$area_city_id'");
        // Delete
        $this->deleteOne($area_city_id);
        return 1;
    }

    function getListAreaCityByCountry($country_id = 0)
    {
        return $this->getAll("is_trash=0 and is_online=1 and country_id='$country_id' order by order_no ASC", $this->pkey);
    }

    function countHotel($country_id = 0, $area_city_id = 0)
    {
        $clsHotel = new Hotel();
        $sql = "is_trash=0 and is_online=1";
        if (intval($country_id) > 0) {
            $sql .= " and country_id='$country_id'";
        }
        if (intval($area_city_id) > 0) {
            $sql .= " and area_city_id='$area_city_id'";
        }
        return $clsHotel->countItem($sql);
    }

    function checkAvailable($haystack = 0, $needle = 0)
    {
        return 0;
    }
}
