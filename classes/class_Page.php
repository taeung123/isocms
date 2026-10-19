<?php
class Page extends dbBasic
{
	function __construct()
	{
		$this->pkey = "page_id";
		$this->tbl = DB_PREFIX . "page";
	}
	function getTitle($pvalTable = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['title'])) {
			$one = $this->getOne($pvalTable, 'title');
		}
		return $one['title'];
	}
	function getSlug($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'slug');
		return $one['slug'];
	}
	function updateLink($pvalTable = 0)
	{
		global $core, $extLang;
		if (!$this->getOneField('is_plink', $pvalTable)) {
			$title = $this->getOneField('title', $pvalTable);
			$link = '/about/' . $core->replaceSpace($title) . '.html';
		} else {
			$link = $extLang . '/about/intro.html';
		}
		$this->updateOne($pvalTable, "link='" . addslashes($link) . "'");
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

	function getLink($pvalTable = 0, $oneTable = null)
	{
		global $_LANG_ID, $extLang, $about_us_id;
		if (!isset($oneTable)) {
			$oneTable = $this->getOne($pvalTable, 'slug');
		}
		$slug = $oneTable['slug'];
		if ($pvalTable == $about_us_id) {
			if ($_LANG_ID == 'vn')
				return $extLang . '/gioi-thieu.html';
			return $extLang . '/about-us.html';
		} else {
			if ($_LANG_ID == 'vn')
				return $extLang . '/thong-tin/' . $slug . '.html';
			return $extLang . '/about/' . $slug . '.html';
		}
	}
	function getUrl($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'url');
		return $one['url'];
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getStripIntro($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return strip_tags(html_entity_decode($one['intro']));
	}
	function getIntro($pvalTable = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['intro'])) {
			$one = $this->getOne($pvalTable, 'intro');
		}
		return html_entity_decode($one['intro']);
	}
	function checkContain($haystack = '', $needle = '')
	{
		if ($needle == '') {
			return 0;
		}
		if (strpos($haystack, $needle) === FALSE) {
			return 0;
		} else {
			return 1;
		}
	}
	function doDelete($pvalTable = 0)
	{
		$clsISO = new ISO();
		#
		$this->deleteOne($pvalTable);
		return 1;
	}
}
