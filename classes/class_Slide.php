<?php
class Slide extends dbBasic
{
	function __construct()
	{
		$this->pkey = "slide_id";
		$this->tbl = DB_PREFIX . "slide";
	}
	function getTitle($slide_id = 0, $one = null)
	{
		if (!isset($one['title'])) {
			$one = $this->getOne($slide_id, "title");
		}
		return $one['title'];
	}
	function getSlug($slide_id = 0)
	{
		$one = $this->getOne($slide_id, "slug");
		return $one['slug'];
	}
	function getText($slide_id = 0)
	{
		$one = $this->getOne($slide_id, "text");
		return html_entity_decode($one['text']);
	}
	function getType($slide_id = 0)
	{
		$one = $this->getOne($slide_id, "type");
		return $one['type'];
	}
	function getAuthor($slide_id = 0)
	{
		$one = $this->getOne($slide_id, "author_photo");
		return $one['author_photo'];
	}
	function getLargeText($slide_id = 0)
	{
		$one = $this->getOne($slide_id, "large_text");
		return html_entity_decode($one['large_text']);
	}
	function getSmallText($slide_id = 0)
	{
		$one = $this->getOne($slide_id, "small_text");
		return html_entity_decode($one['small_text']);
	}
	function getIntro($slide_id = 0, $one = null)
	{
		if (!isset($one['text'])) {
			$one = $this->getOne($slide_id, "text");
		}
		return html_entity_decode($one['text']);
	}
	function getUrl($slide_id = 0, $one = null)
	{
		if (!isset($one['link'])) {
			$one = $this->getOne($slide_id, "link");
		}
		return $one['link'] ? $one['link'] : 'javascript:void(0);';
	}
	function getLink($slide_id = 0)
	{
		$one = $this->getOne($slide_id, "link");
		return $one['link'];
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
	{
		global $clsISO;
		#
		if (!isset($oneTable['image'])) {
			$oneTable = $this->getOne($pvalTable, 'image');
		}
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}

	function getListModPage()
	{
		global $core;
		$lstModule = array();
		$lstModule['home'] = $core->get_Lang('Home');
		$lstModule['tour'] = $core->get_Lang('Tour');
		$lstModule['hotel'] = $core->get_Lang('Hotel');
		$lstModule['country'] = $core->get_Lang('Country');
		$lstModule['city'] = $core->get_Lang('City');
		$lstModule['promotion'] = $core->get_Lang('Promotion');
		$lstModule['page'] = $core->get_Lang('Page');
		return $lstModule;
	}
	function makeSelectModPage($selected = "")
	{
		global $core;
		$lstModule = $this->getListModPage();
		$html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';
		if (!empty($lstModule)) {
			foreach ($lstModule as $k => $v) {
				$html .= '<option value="' . $k . '" ' . ($selected == $k ? 'selected="selected"' : '') . '>-- ' . $v . ' --</option>';
			}
		}
		return $html;
		die();
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
