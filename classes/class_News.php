<?php
class News extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "news_id";
		$this->tbl = DB_PREFIX . "news";
	}
	function checkOnlineBySlug($news_id = 0, $slug = '')
	{
		$item = $this->getAll("is_trash=0 and is_online=1 and news_id='$news_id' and slug='$slug'", $this->pkey);
		if (empty($item))
			return 0;
		return 1;
	}
	function getTitle($pvalTable = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($pvalTable, 'title');
		}
		return $one['title'];
	}
	function getSlug($pvalTable = 0, $one = null)
	{
		if (!isset($one['slug'])) {
			$one = $this->getOne($pvalTable, 'slug');
		}
		return $one['slug'];
	}
	function getRegDate($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'reg_date');
		return date('d M, Y', $one['reg_date']);
	}
	function getMetaDescription($pvalTable = 0, $one = null)
	{
		global $_LANG_ID;
		if (!isset($one['intro'])) {
			$one = $this->getOne($pvalTable, 'intro');
		}
		return html_entity_decode($one['intro']);
	}
	function getIntro($pvalTable = 0, $one = null)
	{
		if (!isset($one['intro'])) {
			$one = $this->getOne($pvalTable, 'intro');
		}
		return html_entity_decode($one['intro']);
	}
	function getContent($pvalTable = 0, $one = null)
	{
		if (!isset($one['content'])) {
			$one = $this->getOne($pvalTable, 'content');
		}
		return html_entity_decode($one['content']);
	}
	function getStripIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro,content');
		if (!empty($one['intro']))
			return strip_tags(html_entity_decode($one['intro']));
		return strip_tags(html_entity_decode($one['content']));
	}
	function getLink($pvalTable = 0, $one = null)
	{
		global $extLang, $_LANG_ID;
		return $extLang . '/n' . $pvalTable . '-' . $this->getSlug($pvalTable, $one) . '.html';
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
	function getLogoNews($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "logo_news");
		$logo_news = $oneTable['logo_news'];
		return $clsISO->tripslashUrl($logo_news);
	}
	function getUrlImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getListNews($news_cat_id = 0)
	{
		$lst = $this->getAll("is_trash=0 and news_cat_id='$news_cat_id' order by order_no desc");
		return $lst;
	}
	function doDelete($news_id = 0)
	{
		// Delete News
		$this->deleteOne($news_id);
		return 1;
	}
}
