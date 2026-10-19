<?php
class Region extends dbBasic
{
	function __construct()
	{
		$this->pkey = "region_id";
		$this->tbl = DB_PREFIX . "region";
	}
	function getTitle($pvalTable = 0, $oDataTable = array())
	{
		if (!isset($oDataTable['title'])) {
			$oDataTable = $this->getOne($pvalTable, 'title');
		}
		return $oDataTable['title'] ?? '';
	}
	function getSlug($pvalTable = 0, $one = null)
	{
		if (!isset($one['slug'])) {
			$one = $this->getOne($pvalTable, 'slug');
		}
		return $one['slug'] ?? '';
	}
	function checkAvailble($country_id = 0)
	{
		$res = $this->getAll("is_trash=0 and is_online=1 and country_id='$country_id'", $this->pkey);
		return $res ? 1 : 0;
	}
	function getBannerUrl($pval = 0)
	{
		$oneTable = $this->getOne($pval, "link_banner");
		return $oneTable['link_banner'] ?? '';
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and slug = '" . $slug . "' limit 0,1");
		return $res[0]['area_id'] ?? 0;
	}
	function getIntro($region_id = 0, $type = '', $is_sort = false, $one = null)
	{
		global $extLang, $_LANG_ID;

		switch ($type) {
			case 'Hotel':
				if (!isset($one['intro_hotel'])) {
					$one = $this->getOne($region_id, 'intro_hotel');
				}
				return html_entity_decode($one['intro_hotel']);
				break;
			case 'Guide':
				if (!isset($one['intro_guide'])) {
					$one = $this->getOne($region_id, 'intro_guide');
				}
				return html_entity_decode($one['intro_guide']);
				break;
			case 'Banner':
				if (!isset($one['intro_banner'])) {
					$one = $this->getOne($region_id, 'intro_banner');
				}
				return html_entity_decode($one['intro_banner']);
				break;
			case 'FunFact':
				if (!isset($one['intro_fastfact'])) {
					$one = $this->getOne($region_id, 'intro_fastfact');
				}
				return html_entity_decode($one['intro_fastfact']);
				break;
			default:
				if (!isset($one['intro'])) {
					$one = $this->getOne($region_id, 'intro');
				}
				return html_entity_decode($one['intro']);
		}
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getContent($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'content');
		return html_entity_decode($one['content']);
	}
	function getStripIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro,content');
		if (!empty($one['intro']))
			return strip_tags(html_entity_decode($one['intro']));
		return strip_tags(html_entity_decode($one['content']));
	}
	function getByCountryLimit($country_id = 0, $limit = 0)
	{
		return $this->getAll("is_trash=0 and country_id='$country_id' order by order_no asc limit 0,$limit", $this->pkey);
	}
	function checkSlug($slug = '')
	{
		global $_LANG_ID;
		$res = $this->getAll("slug='" . $slug . "'");
		if (is_array($res) && count($res) > 0)
			return 0;
		return 1;
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		#
		$oneTable = $this->getOne($pvalTable, 'image');
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
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
	function getLinkVideoTeaser($pval = 0)
	{
		$oneTable = $this->getOne($pval, 'video_teaser');
		return $oneTable['video_teaser'];
	}
	function getLink($region_id = 0, $type = '', $is_sort = false, $one = null)
	{
		global $extLang, $_LANG_ID;
		$clsCountry = new Country();
		switch ($type) {
			case 'Attraction':
				return $extLang . '/' . $this->getSlug($region_id, $one) . '-attractions';
				break;
			case 'Travel':
				return $extLang . '/' . $this->getSlug($region_id, $one) . '-travel-tips';
				break;
			case 'Hotel':
				if (!isset($one['country_id'])) {
					$country_id = $this->getOneField('country_id', $region_id);
				} else {
					$country_id = $one['country_id'];
				}
				if ($_LANG_ID == 'vn')
					return $extLang . '/khach-san/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($region_id, $one) . '-rg' . $region_id;
				return $extLang . '/hotels/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($region_id, $one) . '-rg' . $region_id;
				break;
			case 'Blog':
				if (!isset($one['country_id'])) {
					$country_id = $this->getOneField('country_id', $region_id);
				} else {
					$country_id = $one['country_id'];
				}
				return $extLang . '/blog/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($region_id, $one) . '-rg' . $region_id;
				break;
			case 'Map':
				return $extLang . '/' . $this->getSlug($region_id, $one) . '-maps';
				break;
			case 'tour':
				return $extLang . '/tours/' . $this->getSlug($region_id, $one);
				break;
			case 'City':
				return $extLang . '/' . $this->getSlug($region_id) . '-destinations/cities';
				break;
			case 'Guide':
				return $extLang . '/' . $this->getSlug($region_id) . '-travel-guide';
				break;
			default:
				$country_id = $this->getOneField('country_id', $region_id);
				if ($_LANG_ID == 'vn')
					return $extLang . '/diem-den/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($region_id, $one) . '-rg' . $region_id;
				return $extLang . '/destinations/' . $clsCountry->getSlug($country_id) . '/' . $this->getSlug($region_id, $one) . '-rg' . $region_id;
		}
	}
	function countNumberCity($region_id = 0)
	{
		$clsCity = new City();
		$res = $clsCity->getAll("is_trash=0 and region_id='$region_id'", $clsCity->pkey);
		return $res ? count($res) : 0;
	}
	function countNumberCityRegion($region_id = 0)
	{
		$clsCity = new City();
		$listCity = $clsCity->getAll("is_trash=0 and is_online=1 and region_id='$region_id'", $clsCity->pkey);
		return $listCity ? count($listCity) : 0;
	}
	function checkExits($country_id = 0, $continent_id = 0, $region_id = 0)
	{
		global $core, $dbconn;
		#
		$cond = "is_trash=0";
		if (intval($continent_id) != 0) {
			$cond .= " and continent_id = '$continent_id'";
		}
		if (intval($country_id) != 0) {
			$cond .= " and country_id = '$country_id'";
		}
		if (intval($region_id) != 0) {
			$cond .= " and region_id = '$region_id'";
		}
		#
		$sql = "SELECT region_id FROM " . DB_PREFIX . "region WHERE " . $cond . " limit 0,1";
		$res = $dbconn->GetAll($sql);
		return !empty($res) ? 1 : 0;
	}
	function makeSelectboxOption($country_id = 0, $region_id = 0)
	{
		global $core;

		#
		$cond = "is_trash=0 and is_online=1";
		if ((int) $country_id > 0) $cond .= " and country_id = '{$country_id}'";
		$lstItem = $this->getAll($cond . " order by order_no asc", "{$this->pkey},title");
		#
		$html = '<option value="0"> -- ' . $core->get_Lang('selectregion') . ' -- </option>';
		if (!empty($lstItem)) {
			//			$html.= '<option value="0"> -- ' . $core->get_Lang('selectregion') . ' -- </option>';
			foreach ($lstItem as $k => $v) {
				$sltc = ($region_id == $v[$this->pkey]) ? ' selected' : '';
				$html .= '<option value="' . $v[$this->pkey] . '"' . $sltc . '>' . $this->getTitle($v[$this->pkey], $v) . '</option>';
			}
			unset($lstItem);
		}
		return $html;
	}
	function getMapLa($region_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($region_id, 'map_la');
		return $one['map_la'];
	}

	function getMapLo($region_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($region_id, 'map_lo');
		return $one['map_lo'];
	}
	function doDelete($pvalTable = 0)
	{
		$clsISO = new ISO();
		$clsCityStore = new CityStore();
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
		$clsCityStore->deleteByCond("region_id='$pvalTable' and type='REGION'");
		return 1;
	}
}
