<?php
class Guide2 extends dbBasic
{
	function __construct()
	{
		$this->pkey = "guide2_id";
		$this->tbl = DB_PREFIX . "guide2";
	}
	function getSlug($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$all = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
		return $all[0][$this->pkey];
	}
	function checkExitsId($guide2_id = 0)
	{
		$res = $this->getAll("guide2_id = '$guide2_id' LIMIT 0,1");
		return !empty($res) ? 1 : 0;
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getBannerLink($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'link_banner');
		return $one['link_banner'];
	}
	function getContent($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'content');
		return html_entity_decode($one['content']);
	}
	function getIntroMore($place_id = 0, $guidecat_id = 0, $limit = 400, $show = '', $truncate = true)
	{
		global $dbconn, $core;
		if ($show == 'City') {
			$one = $this->getAll("is_trash=0 and is_online=1 and city_id='$place_id' and cat_id='$guidecat_id' limit 0,1", $this->pkey . ",intro");
		} else {
			$one = $this->getAll("is_trash=0 and is_online=1 and country_id='$place_id' and city_id=0 and cat_id='$guidecat_id' limit 0,1", $this->pkey . ",intro");
		}

		$string = $one[0]['intro'];

		if ($truncate == true) {
			if (strlen($string) < $limit) {
				return html_entity_decode($string);
			} else {
				$html = '<div class="clicSeemore"><div class="c_seemore More">';
				$html .= strip_tags(html_entity_decode($this->truncate($string, $limit)));
				$html .= '<a href="javascript:void(0);" class="semoreClick color_e4622a">' . $core->get_Lang('More') . '</a>';
				$html .= '</div>';
				$html .= '<div class="c_seemore Less" style="display:none">';
				$html .= html_entity_decode($string);
				$html .= '<a href="javascript:void(0);" class="LessClick color_e4622a">' . $core->get_Lang('Less') . '</a>';
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
	function getStripIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'content');
		return html_entity_decode($one['content']);
	}
	function getRegDate($pvalTable = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($pvalTable, 'reg_date');
		if (!empty($one['reg_date']))
			return date('D, d/m/Y', $one['reg_date']);
		return '';
	}
	function getLinkGuide($pvalTable = 0, $country_id = '', $city_id = '', $guidecat_id = 0)
	{
		global $extLang, $_LANG_ID;
		#
		$clsCountry = new Country();
		$clsCity = new City();
		$clsGuideCat = new GuideCat();

		if ($country_id > 0 && $city_id > 0) {
			if ($_LANG_ID == 'vn') {
				$link = $extLang . '/diem-den/' . $clsCountry->getSlug($country_id) . '/' . $clsCity->getSlug($city_id) . '/' . $clsGuideCat->getSlug($guidecat_id) . '.html';
			} else {
				$link = $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $clsCity->getSlug($city_id) . '/' . $clsGuideCat->getSlug($guidecat_id) . '.html';
			}
		} elseif ($country_id > 0) {
			if ($_LANG_ID == 'vn') {
				$link = $extLang . '/diem-den/' . $clsCountry->getSlug($country_id) . '/' . $clsGuideCat->getSlug($guidecat_id) . '.html';
			} else {
				$link = $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $clsGuideCat->getSlug($guidecat_id) . '.html';
			}
		} else {
			if ($_LANG_ID == 'vn') {
				$link = $extLang . '/diem-den/' . $clsGuideCat->getSlug($guidecat_id) . '.html';
			} else {
				$link = $extLang . '/destinations/' . $clsGuideCat->getSlug($guidecat_id) . '.html';
			}
		}

		return $link;
	}
	function getLink($pvalTable = 0)
	{
		global $extLang, $_LANG_ID;
		#
		$clsCountry = new Country();
		$clsCity = new City();
		$clsGuideCat = new GuideCat();

		$oneTable = $this->getOne($pvalTable, 'country_id');
		$country_id = $oneTable['country_id'];
		$city_id = $oneTable['city_id'];
		$info_type = 'TEXT';

		if ($info_type == 'TEXT') {
			$link = '/destinations';
			$link .= '/' . $this->getSlug($pvalTable) . '.html';
			return $link;
		} else {
			switch ($internal_link) {
				case 'HOTEL_LIST':
					return $clsCountry->getLinkHotel($country_id);
					break;
				case 'TOUR_LIST':
					return $clsCountry->getLinkTour($country_id);
					break;
				case 'USEFUL_INFO':
					if ($type == 'country')
						return $clsCountry->getLinkDestinationTravel($country_id);
					return '/';
					break;
				case 'PLACES_VISIT':
					return $clsCountry->getLinkPointTravel($country_id);
					break;
				case 'CITY_TOP':
					return $clsCountry->getLinkDestinationCity($country_id);
					break;
				default:
					return '/';
					break;
			}
		}
	}
	function getNAV($guide2_id = 0)
	{
		global $dbconn;
		$oneTable = $this->getOne($guide2_id, "getNAV");
		if ($oneTable['getNAV'] == '') {
			$i = 1;
			$j = 0;
			$res = array();
			$res[0] = $guide2_id;
			#
			while ($i == 1) {
				$oneCurrent = $this->getOne($res[$j], "parent_id");
				$oneParent = $oneCurrent["parent_id"];
				if ($oneParent != 0 and $i == 1) {
					$j++;
					$res[$j] = $oneParent;
				} else {
					$i = 0;
				}
			}
			$this->updateOne($guide2_id, "getNAV='" . serialize(array_reverse($res)) . "'");
			return array_reverse($res);
		} else {
			return unserialize($oneTable['getNAV']);
		}
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
	{
		global $clsISO;
		if (!isset($oneTable['image'])) {
			$oneTable = $this->getOne($pvalTable, "image");
		}
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getImageUrl($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getBannerImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$clsGuideCat = new GuideCat();
		$oneTable = $this->getOne($pvalTable, 'cat_id,banner');
		$guidecat_id = $oneTable['cat_id'];
		if ($oneTable['banner'] != '') {
			$banner = $oneTable['banner'];
			return $clsISO->tripslashImage($banner, $w, $h);
		}
		$banner2 = $clsGuideCat->getBannerImage($guidecat_id, $w, $h);
		return $banner2;
	}
	function getChild($guide2_id = 0)
	{
		$ret = $this->getAll("is_trash=0 and parent_id='$guide2_id' order by order_no asc");
		return $ret;
	}
	function countChild($guide2_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getAll("is_trash=0 and parent_id='$guide2_id'");
		if ($one[0]['guide2_id'] != '')
			return count($one);
		return 0;
	}
	function makeOption($cat_id = 0, $country_id = 0, $city_id = 0, $level = 0, $type = '', $arrHtml = array())
	{
		global $dbconn, $_LANG_ID;
		if (!$arrHtml) {
			$arrHtml = array();
		}
		$where = "is_trash=0 and country_id='$country_id' and parent_id='$cat_id'";
		if (intval($city_id) > 0) {
			$where .= " and city_id='$city_id'";
		}
		if (!empty($type)) {
			$where .= " and type='$type'";
		}
		$where .= " order by order_no desc";
		$arrListCat = $dbconn->GetAll("SELECT " . $this->pkey . " FROM " . $this->tbl . " WHERE " . $where);
		if (is_array($arrListCat) && count($arrListCat) > 0) {
			foreach ($arrListCat as $k => $v) {
				$value = $v[$this->pkey];
				$option = str_repeat("|__", $level) . $this->getTitle($v[$this->pkey]);
				$arrHtml[$value] = $option;
				$arrHtml = $this->makeOption($v[$this->pkey], $country_id, $city_id, $level + 1, $type, $arrHtml);
			}
		}
		unset($arrListCat);
		return $arrHtml;
	}
	function getListOption($parent_id = 0, $country_id = 0, $city_id = 0, $selected = '0', $type = '')
	{
		$clsCountry = new Country();
		$clsCity = new City();

		$html = '<option value="0">-- Danh mục gốc </option>';
		if (intval($country_id) > 0) {
			$html = '<option value="' . $parent_id . '">-- ' . $clsCountry->getTitle($country_id) . ' </option>';
		}
		if (intval($city_id) > 0) {
			$html = '<option value="' . $parent_id . '">-- ' . $clsCity->getTitle($city_id) . ' </option>';
		}
		#
		$arrOptionsCategory = array();
		$arrOptionsCategory = $this->makeOption($parent_id, $country_id, $city_id, 0, $type);
		if (is_array($arrOptionsCategory) && count($arrOptionsCategory) > 0) {
			foreach ($arrOptionsCategory as $k => $v) {
				$html .= '<option value="' . $k . '" ' . ($k == $selected ? 'selected="selected"' : '') . '>|__' . $v . '</option>';
			}
		}
		unset($arrOptionsCategory);
		return $html;
	}
	function getRootId($guide2_id = 0)
	{
		$one = $this->getOne($guide2_id, "parent_id");
		$parent_id = $one['parent_id'];
		if ($parent_id == 0) {
			return $guide2_id;
		} else {
			return $this->getRootId($parent_id);
		}
	}
	function getNavChild($guide2_id = 0, $country_id = 0, $city_id = 0, $type = 'country', $m = '')
	{
		global $core;
		$temp = $this->getNAV($guide2_id);
		$link = '<a>&raquo;</a><a href="' . PCMS_URL . '/?admin&mod=' . $m . '&country_id=' . $country_id . ($city_id > 0 ? '&city_id=' . $city_id : '') . '&type=' . $core->encryptID($type) . '&parent_id=0">Thông tin điểm đến</a>';
		for ($i = 0; $i < count($temp); $i++) {
			$tmp = $this->getTitle($temp[$i]);
			$link .= ($i == count($temp)) ? '' : '<a>&raquo;</a>';
			$link .= ' <a href="' . PCMS_URL . '/?mod=' . $m . '&country_id=' . $country_id . ($city_id > 0 ? '&city_id=' . $city_id : '') . '&type=' . $core->encryptID($type) . '&parent_id=' . $temp[$i] . '">' . $tmp . ' </a>';
		}
		if ($guide2_id == 0)
			return '<a>&raquo;</a><a href="' . PCMS_URL . '/?admin&mod=' . $m . '&country_id=' . $country_id . ($city_id > 0 ? '&city_id=' . $city_id : '') . '&type=' . $core->encryptID($type) . '&parent_id=0">Thông tin điểm đến</a>';
		return $link;
	}
	function getListItem($parent_id = 0, $country_id = 0, $limit = '')
	{
		$limit = !empty($limit) ? 'limit ' . $limit : '';
		$res = $this->getAll("is_trash=0 and parent_id = '$parent_id' and country_id = '$country_id' order by order_no desc " . $limit, $this->pkey);
		return !empty($res) ? $res : '';
	}
	function countGuideGlobal($parent_id = 0, $city_id = 0, $country_id = 0)
	{
		$where = "is_trash=0 and is_online=1";
		if (intval($parent_id) != 0) {
			$where .= " and (parent_id = '" . $parent_id . "' or list_parent_id like '%|" . $parent_id . "|%')";
		}
		if (intval($city_id) != 0) {
			$where .= " and (city_id = '" . $city_id . "' or list_city_id like '%|" . $city_id . "|%')";
		}
		if (intval($country_id) != 0) {
			$where .= " and country_id='$country_id'";
		}
		return $this->countItem($where);
	}
	function doDelete($pvalTable = 0)
	{
		$clsISO = new ISO();
		#
		$image = $this->getOneField("image", $pvalTable);
		if (trim($image) != '') {
			if ($clsISO->checkContainer($image, DOMAIN_NAME)) {
				$image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
				$clsISO->deleteFile($image);
				$image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
				$clsISO->deleteFile($image);
			}
		}
		#
		$this->deleteOne($pvalTable);
		return 1;
	}
}
