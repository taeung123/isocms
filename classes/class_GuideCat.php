<?php
class GuideCat extends dbBasic
{
	function __construct()
	{
		$this->pkey = "guidecat_id";
		$this->tbl = DB_PREFIX . "guidecat";
	}
	function getSlash($level = 0)
	{
		return str_repeat("------", $level + 1);
	}
	function getTitle($guidecat_id = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($guidecat_id, 'title');
		}
		if (!empty($one)) {
			return $one['title'];
		}
	}
	function getGuideCatId($guidecat_id = 0, $_args = array())
	{
		if (is_array($_args) && $_args[$this->pkey] > 0) {
			return $_args['guidecat_id'];
		} else {
			$one = $this->getOne($guidecat_id, 'guidecat_id');
			return $one['guidecat_id'];
		}
	}
	function getGuideCityId($guidecat_id = 0, $_args = array())
	{
		if (is_array($_args) && $_args[$this->pkey] > 0) {
			return $_args['city_id'];
		} else {
			$one = $this->getOne($guidecat_id, 'city_id');
			return $one['city_id'];
		}
	}
	function getSlug($guidecat_id = '', $one = null)
	{
		if ($guidecat_id != '') {
			if (!isset($one['slug'])) {
				$one = $this->getOne($guidecat_id, 'slug');
			}
			return $one['slug'];
		}
		return false;
	}
	function getBySlug($slug = '')
	{
		$all = $this->getAll("is_trash=0 and is_online=1 and slug='$slug' limit 0,1");
		return $all[0][$this->pkey];
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($pvalTable = 0, $type = '', $is_sort = false, $one = null)
	{
		global $extLang, $_LANG_ID;
		switch ($type) {
			case 'Banner':
				if (!isset($one['intro_banner'])) {
					$one = $this->getOne($pvalTable, 'intro_banner');
				}
				return html_entity_decode($one['intro_banner']);
				break;
			default:
				if (!isset($one['intro'])) {
					$one = $this->getOne($pvalTable, 'intro');
				}
				return html_entity_decode($one['intro']);
		}
	}
	function countNumberGuide($guidecat_id = 0, $country_id = 0)
	{
		$clsGuide = new Guide();
		$lstItem = $clsGuide->getAll("is_trash=0 and is_online=1 and country_id='$country_id' cat_id = '$guidecat_id'");
		return !empty($lstItem) ? count($lstItem) : 0;
	}
	function countNumberGuide2($guidecat_id = 0, $country_id = 0, $city_id = 0)
	{
		$clsGuide = new Guide();
		if ($city_id != '') {
			$lstItem = $clsGuide->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and cat_id = '$guidecat_id' and city_id='$city_id'");
		} else {
			$lstItem = $clsGuide->getAll("is_trash=0 and is_online=1 and country_id='$country_id' and cat_id = '$guidecat_id'");
		}
		return !empty($lstItem) ? count($lstItem) : 0;
	}
	function getLinkRegion($country_id = 0, $region_id = 0, $cat_id = 0, $one = null)
	{
		global $_LANG_ID, $extLang, $clsISO;
		$clsCountry = new Country();
		$clsRegion = new Region();
		#
		if (intval($region_id) == 0 && intval($country_id) == 0) {
			$link = $extLang . '/destinations/' . $this->getSlug($cat_id, $one) . '-c' . $cat_id . '.html';
		} elseif (intval($region_id) == 0) {
			$link = $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($cat_id, $one) . '.html';
		} else {
			$link = $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $clsRegion->getSlug($region_id) . '-rg' . $region_id . '/' . $this->getSlug($cat_id, $one) . '.html';
		}
		return $link;
	}
	function getLink($country_id = 0, $city_id = 0, $cat_id = 0, $_args = null)
	{
		global $_LANG_ID, $extLang, $clsISO;
		$clsCountry = new Country();
		$clsCity = new City();
		#
		$link = $clsISO->getLink('destination2');

		if (intval($city_id) == 0 && intval($country_id) == 0) {
			$link .= '/' . $this->getSlug($cat_id) . '-c' . $cat_id . '.html';
		} elseif (intval($city_id) == 0) {
			$link .= '/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($cat_id, $_args) . '.html';
		} else {
			$link .= '/' . $clsCountry->getSlug($country_id) . '/' . $clsCity->getSlug($city_id) . '/' . $this->getSlug($cat_id) . '.html';
		}
		return $link;
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
	function getUrlImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
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
	function getBannerLink($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'link_banner');
		return $one['link_banner'];
	}
	function getNAV($cat_id = 0)
	{
		global $dbconn;
		$i = 1;
		$j = 0;
		$res = array();
		$res[0] = $cat_id;
		#
		while ($i == 1) {
			$oneCurrent = $this->getOne($res[$j]);
			$oneParent = $oneCurrent["parent_id"];
			if ($oneParent != 0 and $i == 1) {
				$j++;
				$res[$j] = $oneParent;
			} else {
				$j++;
				$res[$j] = $oneParent;
				$i = 0;
			}
		}
		$this->updateOne($cat_id, "nav='" . addslashes(serialize(array_reverse($res))) . "'");
		return array_reverse($res);
	}
	function countChild($cat_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getAll("is_trash=0 and parent_id='$cat_id'");
		if ($one[0]['cat_id'] != '')
			return count($one);
		return 0;
	}
	function getChild($cat_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getAll("parent_id='$cat_id' and is_trash=0");
		return $one;
	}

	function makeOption2($catid = 0, $country_id = 0, $selectedid = "", $level = 0, &$arrHtml = [])
	{
		global $dbconn, $_LANG_ID;
		$cond = "is_trash=0 and guidecat_id<>'1' and parent_id='$catid'";
		if (intval($country_id) != 0) {
			$cond .= "and list_country_id like '%|" . $country_id . "|%'";
		}
		$arrListCat = $this->getAll($cond . " order by order_no asc");
		if (is_array($arrListCat)) {
			foreach ($arrListCat as $k => $v) {
				$selected = ($v["guidecat_id"] == $selectedid) ? "selected" : "";
				$value = $v["guidecat_id"];
				$option = str_repeat("|----", $level) . $this->getTitle($v[$this->pkey]);
				$arrHtml[$value] = $option;
				$this->makeOption($v["guidecat_id"], $country_id, $selectedid, $level + 1, $arrHtml);
			}
			return "";
		} else {
			return "";
		}
	}
	function checkProperty($type = '', $pvalTable = 0, $property_id = 0)
	{
		$oneItem = $this->getOne($pvalTable);
		$str = $oneItem['list_' . $type];
		$str_array = explode('|', $str);
		for ($i = 0; $i < count($str_array); $i++) {
			if ($str_array[$i] == $property_id) {
				return 1;
			}
		}
		return 0;
	}
	function makeSelectboxOption($catid = 0, $selected = '')
	{
		return $this->getListOption($catid, $selected);
	}
	function makeSelectboxOptionNew($catid = 0, $selected = '', $country_id = 0, $city_id = 0)
	{
		return $this->getListOptionNew($catid, $selected, $country_id = 0, $city_id = 0);
	}
	function getListOption($parent_id = 0, $selected = '0')
	{
		global $core;

		#
		if (intval($parent_id) == 0) {
			$html = '<option value="">' . $core->get_Lang('Select Category') . '</option>';
		} else {
			$html = '<option value="' . $parent_id . '"> ' . $this->getTitle($parent_id) . ' </option>';
		}
		#
		$arrOptionsCategory = array();
		$this->makeOption($parent_id, "", 0, $arrOptionsCategory);
		foreach ($arrOptionsCategory as $k => $v) {
			$oneItem = $this->getOne($k);
			$html .= '<option value="' . $k . '" ' . ($k == $selected ? 'selected="selected"' : '') . '>|----' . $v . '</option>';
		}
		return $html;
	}
	function getListOptionNew($cat_id = 0, $selected = '0', $country_id = 0, $city_id = 0)
	{
		global $core;

		#
		if (intval($cat_id) == 0) {
			$html = '<option value="0">' . $core->get_Lang('Select Category') . '</option>';
		} else {
			$html = '<option value="' . $cat_id . '"> ' . $this->getTitle($cat_id) . ' </option>';
		}
		#
		$arrOptionsCategory = array();
		$this->makeOptionNew($cat_id, 0, 0, $country_id, $city_id, $arrOptionsCategory);
		foreach ($arrOptionsCategory as $k => $v) {
			$oneItem = $this->getOne($k);
			$html .= '<option value="' . $k . '" ' . ($k == $selected ? 'selected="selected"' : '') . '>|----' . $v . '</option>';
		}
		return $html;
	}
	function makeOption($catid = 0, $selectedid = "", $level = 0, &$arrHtml = [])
	{
		global $dbconn, $_LANG_ID;
		$arrListCat = $this->GetAll("parent_id='$catid' and is_trash=0 and is_online=1 order by order_no ASC");
		if (is_array($arrListCat)) {
			foreach ($arrListCat as $k => $v) {
				$selected = ($v["guide_cat_id"] == $selectedid) ? "selected" : "";
				$value = $v["guidecat_id"];
				$option = str_repeat("|----", $level) . $this->getTitle($v[$this->pkey]);
				$arrHtml[$value] = $option;
				$this->makeOption($v["guidecat_id"], $selectedid, $level, $arrHtml);
			}
			return "";
		} else {
			return "";
		}
	}
	function makeOptionNew($catid = 0, $selectedid = "", $level = 0, $country_id = 0, $city_id = 0, &$arrHtml = [])
	{
		global $dbconn, $_LANG_ID;
		$clsGuide = new Guide();
		if ($country_id == 0 && $city_id == 0) {
			$arrListCat = $this->GetAll("is_trash=0 and is_online=1 order by order_no ASC");
		} else {
			if ($country_id == 0) {
				$arrListCat = $clsGuide->GetAll("city_id='$city_id' and is_trash=0 and is_online=1 order by order_no ASC");
			}
			if ($city_id == 0) {
				$arrListCat = $clsGuide->GetAll("country_id='$country_id' and is_trash=0 and is_online=1 order by order_no ASC");
			}
		}


		if (is_array($arrListCat)) {
			foreach ($arrListCat as $k => $v) {
				$selected = ($v["cat_id"] == $selectedid) ? "selected" : "";
				$value = $v["cat_id"];
				$option = str_repeat("|----", $level) . $this->getTitle($v['cat_id']);
				$arrHtml[$value] = $option;
				$this->makeOption($v["cat_id"], $selectedid, $level, $arrHtml);
			}
			return "";
		} else {
			return "";
		}
	}
	function getListOption2($parent_id = 0, $country_id = 0, $selected = '0', $guidecat_id = 0)
	{
		global $core;
		$country_id = 1;
		#
		if (intval($parent_id) == 0) {
			$html = '<option value="">' . $core->get_Lang('selectcategory') . '</option>';
		} else {
			$html = '<option value="' . $parent_id . '"> ' . $this->getTitle($parent_id) . ' </option>';
		}
		#
		$arrOptionsCategory = array();
		$this->makeOption2($parent_id, $country_id, "", 0, $arrOptionsCategory, $guidecat_id);
		foreach ($arrOptionsCategory as $k => $v) {
			$oneItem = $this->getOne($k);
			$sl = ($selected == $k) ? 'selected="selected"' : '';
			$disabled = ($guidecat_id == $k) ? 'disabled="disabled"' : '';
			$html .= '<option value="' . $k . '" ' . $sl . ' ' . $disabled . '>|----' . $v . '</option>';
		}
		return $html;
	}
	function makeList($catid = 0, $level = 0, &$arrHtml = [])
	{
		global $dbconn;
		#
		$arrListCat = $dbconn->GetAll("SELECT * FROM " . $this->tbl . " WHERE parent_id='$catid' order by order_no asc");
		if (is_array($arrListCat)) {
			foreach ($arrListCat as $k => $v) {
				$value = $v[$this->pkey];
				$v['level'] = str_repeat("----", $level);
				$arrHtml[$value] = $v;
				$this->makeList($v[$this->pkey], $level + 1, $arrHtml);
			}
			return "";
		} else {
			return "";
		}
	}
	function makeSelectboxOption2($catid = 0, $country_id = 0, $selected = '', $guidecat_id = 0)
	{
		$country_id = 1;
		return $this->getListOption2($catid, $country_id, $selected, $guidecat_id);
	}
	function getListParent($cat_id = 0)
	{
		$listChild = array();
		$allChild = $this->getAll();
		if ($allChild[0][$this->pkey] != '') {
			for ($i = 0; $i < count($allChild); $i++) {
				if ($this->checkIsParent($cat_id, $allChild[$i]['guidecat_id'])) {
					$listChild[] = $allChild[$i]['guidecat_id'];
				}
			}
		}
		#
		$cond = "|";
		if (is_array($listChild) && count($listChild) > 0) {
			for ($i = 0; $i < count($listChild); $i++) {
				$cond .= $listChild[$i] . "|";
			}
		}
		$cond .= $cat_id . "|";
		return $cond;
	}
	function checkIsParent($cat_id = 0, $parent_id_check = 0)
	{
		$one = $this->getOne($cat_id, 'parent_id');
		$parent_id = $one['parent_id'];
		if ($parent_id == $parent_id_check) {
			return 1;
		}
		if ($parent_id == 0) {
			return 0;
		}
		return $this->checkIsParent($parent_id, $parent_id_check);
	}
	function getListGuideCat($country_id = 0)
	{
		$sql = "is_trash=0 and parent_id=0 and list_country_id like '%|" . $country_id . "|%'";
		$res = $this->getAll($sql . " order by order_no desc", $this->pkey);
		$tmp = array();
		if (!empty($res)) {
			$clsGuide = new Guide();
			foreach ($res as $item) {
				if ($clsGuide->countGuideGlobal($item[$this->pkey], 0, $country_id) > 0) {
					$tmp[] = $item[$this->pkey];
				}
			}
		}
		return !empty($tmp) ? $tmp : '';
	}
	function getCatInCountry($country_id = 0)
	{
		$sql = "is_trash=0 and parent_id=0";
		$res = $this->getAll($sql . " and list_country_id like '%|" . $country_id . "|%' order by order_no desc", $this->pkey);
		return $res;
	}
	function doDelete($cat_id = 0)
	{
		$lstItem = $this->getAll("1=1 and parent_id='$cat_id'");
		if (!empty($lstItem)) {
			foreach ($lstItem as $item) {
				$pval = $item[$this->pkey];
				$this->doDelete($pval);
			}
			unset($lstItem);
		}
		$this->deleteOne($cat_id);
	}
	function getItems($country_id = 0)
	{
		$sql = "is_trash=0 and parent_id=0";
		$listItemsDb = $this->getAll($sql . " and list_country_id like '%|" . $country_id . "|%' order by order_no desc");
		$listItems = array();
		if (is_array($listItemsDb) && count($listItemsDb) > 0) {
			for ($i = 0; $i < count($listItemsDb); $i++) {
				$listItems[] = array(
					'guidecat_id'	=> $listItemsDb[$i][$this->pkey],
					'title'	=> $this->getTitle($listItemsDb[$i][$this->pkey], $listItemsDb[$i]),
					'link'	=> $this->getLink($listItemsDb[$i][$this->pkey], $country_id, 0, $listItemsDb[$i])
				);
			}
		}
		return $listItems;
	}
	function getLinkGuideCountry($guidecat_id = 0, $type = "", $country_id = 0)
	{
		global $clsISO;

		if (!$country_id) return "";

		$slug_country = (new Country())->getSlug($country_id);
		$base_link = "{$clsISO->getLink("destination2")}/$slug_country/travel-guide";

		return ($type === "cat" && !empty($guidecat_id)) ? "$base_link?cat=$guidecat_id" : $base_link;
	}
}
