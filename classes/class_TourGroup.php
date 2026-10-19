<?php
class TourGroup extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "tour_group_id";
		$this->tbl = DB_PREFIX . "tour_group";
	}
	function getTitle($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'title');
		return $one['title'] ?? '';
	}
	function getSlug($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'slug');
		return $one['slug'] ?? '';
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and is_online=1 and slug='$slug' LIMIT 0,1");
		return $res[0][$this->pkey] ?? 0;
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro'] ?? '');
	}
	function getLink($pvalTable = 0, $allow_full_url = 1)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/travel-styles/' . $this->getSlug($pvalTable) . '/';
	}
	function getLinkByGroup($pvalTable = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/lich-khoi-hanh/' . $this->getSlug($pvalTable) . '-c' . $pvalTable;
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
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
		$oneTable = $this->getOne($pvalTable, "image_banner");
		if ($oneTable['image_banner'] != '') {
			$image = $oneTable['image_banner'];
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getUrlImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$image = $oneTable['image'];
		return $image;
	}
	function makeSelectboxOption($tour_group_id = 0)
	{
		global $core;
		$lstGroup = $this->getAll("is_trash=0 and is_online=1 order by order_no desc", $this->pkey);
		$html = '<option value="0">-- ' . $core->get_Lang('tourgroup') . ' --</option>';
		if (is_array($lstGroup) && count($lstGroup) > 0) {
			foreach ($lstGroup as $k => $v) {
				$html .= '<option value="' . $v[$this->pkey] . '" ' . ($tour_group_id == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
			}
			unset($lstGroup);
		}
		return $html;
	}
}
