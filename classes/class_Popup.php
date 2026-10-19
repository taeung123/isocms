<?php
class Popup extends dbBasic
{
	function __construct()
	{
		$this->pkey = "popup_id";
		$this->tbl = DB_PREFIX . "popup";
	}
	function getTitle($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, "title");
		return $one['title'];
	}
	function getNameButton($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, "name_button");
		return $one['name_button'];
	}
	function getShowOnePoup($link_show = '')
	{
		global $_LANG_ID;
		$all = $this->getAll("is_trash =0 and  is_online = 1 and link_show='$link_show' limit 0,1");
		return 	 $all[0];
	}
	function getSlug($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		if (is_array($_args) && $_args['slug'] != '') {
			return $_args['slug'];
		} else {
			$one = $this->getOne($pvalTable, "slug");
			return $one['slug'];
		}
	}
	function getListModPage()
	{
		global $core;
		$lstModule = array();
		$lstModule['home'] = $core->get_Lang('HomePage');
		$lstModule['child'] = $core->get_Lang('ChildPage');
		return $lstModule;
	}
	function getIntro($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, "intro");
		return html_entity_decode($one['intro']);
	}
	function getLinkPopup($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable);
		//var_dump($one);
		if ($one['type_link'] == 'LINK') {
			return $one['link_another'];
		} else {
			return DOMAIN_NAME . $extLang . '/' . $one['link_internal'];
		}
	}
	function getUrl($pvalTable = 0, $_args = array())
	{
		global $_LANG_ID;
		if (is_array($_args) && $_args['link'] != '') {
			return $_args['link'];
		} else {
			$one = $this->getOne($pvalTable, "link");
			return $one['link'];
		}
	}
	function getOrderNo($slide_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($slide_id, "order_no");
		return $one['order_no'];
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
	function getImageUrl($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}

	function checkModuleExist($pvalTable = 0, $module = '')
	{
		$oneItem = $this->getOne($pvalTable);
		$str = $oneItem['mod_page'];
		$str = str_replace('||', '|', $str);
		$str = ltrim($str, '|');
		$str = rtrim($str, '|');
		$str_array = explode('|', $str);
		for ($i = 0; $i < count($str_array); $i++) {
			if ($str_array[$i] == $module) {
				return 1;
			}
		}
		return 0;
	}
	function doDelete($pvalTable = 0)
	{
		// Delete
		$this->deleteOne($pvalTable);
		return 1;
	}
}
