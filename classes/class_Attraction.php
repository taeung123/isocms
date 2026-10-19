<?php
class Attraction extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "attraction_id";
		$this->tbl = DB_PREFIX . "attraction";
	}
	function getMaxOrder()
	{
		$res = $this->getAll("1=1 order by order_no desc");
		return intval($res[0]['order_no']) + 1;
	}
	function countByCountry($country_id = 0)
	{
		$sql = "is_trash=0 and country_id='$country_id'";
		return $this->countItem($sql);
	}
	function countByCity($city_id = 0)
	{
		$sql = "is_trash=0 and city_id='$city_id'";
		return $this->countItem($sql);
	}
	function getTitle($attraction_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($attraction_id);
		return $one['title'];
	}
	function getSlug($attraction_id = 0)
	{
		$one = $this->getOne($attraction_id);
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and is_online=1 and slug='" . $slug . "' LIMIT 0,1");
		return $res[0][$this->pkey];
	}
	function getByAttraction($slug = '')
	{
		global $_LANG_ID;
		$slug_lang = 'slug_' . $_LANG_ID;
		$res = $this->getAll("is_trash=0 and $slug_lang='" . $slug . "'");
		return $res[0]['attraction_id'];
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($attraction_id = 0)
	{
		global $_LANG_ID;
		$res = $this->getOne($attraction_id);
		return html_entity_decode($res['intro']);
	}
	function getStripIntro($attraction_id = 0)
	{
		global $_LANG_ID;
		$res = $this->getOne($attraction_id);
		return strip_tags(html_entity_decode($res['intro']));
	}
	function getContent($attraction_id = 0)
	{
		global $_LANG_ID;
		$res = $this->getOne($attraction_id);
		return html_entity_decode($res['content']);
	}
	function getStripContent($attraction_id = 0)
	{
		global $_LANG_ID;
		$res = $this->getOne($attraction_id);
		return strip_tags(html_entity_decode($res['content']));
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
	function getByPermalink($permalink = '')
	{
		$all = $this->getAll("1=1 and (permalink_en='$permalink' or permalink_vn='$permalink') order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
	function getLink($attraction_id = 0)
	{
		global $extLang, $_LANG_ID;
		$clsCountry = new Country();
		$oneItem = $this->getOne($attraction_id);
		return $extLang . '/dia-danh/' . $this->getSlug($attraction_id) . '.html';
	}
	function getPermalink($attraction_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($attraction_id);
		if ($one['permalink_' . $_LANG_ID] == '')
			return $one['slug_' . $_LANG_ID];
		return $one['permalink_' . $_LANG_ID];
	}
	function doDelete($attraction_id = 0)
	{
		// Delete
		$this->deleteOne($attraction_id);
		return 1;
	}
}
