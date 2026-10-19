<?php
class Service extends dbBasic
{
	function __construct()
	{
		$this->pkey = "service_id";
		$this->tbl = DB_PREFIX . "service";
	}
	function checkOnlineBySlug($service_id = 0, $slug = '')
	{
		$item = $this->getAll("is_trash=0 and is_online=1 and service_id='$service_id' and slug='$slug'");
		if (empty($item))
			return 0;
		return 1;
	}
	function getSlash($level = 0)
	{
		return str_repeat("------", $level + 1);
	}
	function getTitle($service_id = 0)
	{
		$one = $this->getOne($service_id, 'title');
		return $one['title'];
	}
	function getSlug($service_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($service_id, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$all = $this->getAll("is_trash=0 and slug='$slug' order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
	function checkExitsId($service_id = 0)
	{
		$res = $this->getAll("service_id = '$service_id' LIMIT 0,1");
		return !empty($res) ? 1 : 0;
	}
	function getByPermalink($permalink = '')
	{
		$all = $this->getAll("is_trash=0 and (permalink_en='$permalink' or permalink_vn='$permalink') order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
	function getLink($service_id = 0, $type = '', $is_sort = false)
	{
		global $extLang, $_LANG_ID;
		$oneService = $this->getOne($service_id);
		$cat_id = $oneService['cat_id'];
		switch ($type) {
			case 'Book':
				if ($_LANG_ID == 'vn')
					return $extLang . '/dat-dich-vu/' . $service_id . '/';
				return $extLang . '/book-service/' . $service_id . '/';
				break;
			default:
				return $extLang . '/s' . $service_id . '-' . $this->getSlug($service_id) . '.html';
		}
	}
	function getPermalink($service_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($service_id, 'permalink,slug');
		if ($one['permalink'] == '')
			return $one['slug'];
		return $one['permalink'];
	}
	function getLinkPermalink($permalinkPost = '')
	{
		global $extLang, $_LANG_ID;
		return $extLang . '/travel-services/' . $permalinkPost . '.html';
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
	function getImageChild($service_id = 0)
	{
		global $_LANG_ID, $clsISO;
		$one = $this->getOne($service_id, 'image_child');
		return $clsISO->tripslashUrl($one['image_child']);
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($service_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($service_id, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getStripIntro($service_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($service_id, 'intro');
		return $one['intro'];
	}
	function getContent($service_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($service_id, 'content');
		return html_entity_decode($one['content']);
	}
	function doDelete($service_id = 0)
	{
		$this->deleteOne($service_id);
		return 1;
	}
}
