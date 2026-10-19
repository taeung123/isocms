<?php
class TourType extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_type_id";
		$this->tbl = DB_PREFIX . "tour_type";
	}
	function getTitle($cat_id = 0)
	{
		$one = $this->getOne($cat_id, 'title');
		return $one['title'];
	}
	function getSlug($cat_id = 0)
	{
		$one = $this->getOne($cat_id, 'slug');
		return $one['slug'];
	}
	function getImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getImageUrl($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getIntro($cat_id = 0)
	{
		$one = $this->getOne($cat_id, 'intro');
		return $one['intro'];
	}
	function countTour($tour_type_id = 0)
	{
		$clsTour = new Tour();
		$allTour = $clsTour->getAll("is_trash=0 and tour_type_id='$tour_type_id'");
		return $allTour[0][$this->pkey] != '' ? count($allTour) : 0;
	}
	function makeSelectboxOption($tour_type_id = 0)
	{
		global $core;

		$lstType = $this->getAll("is_trash=0 and is_online=1 order by order_no desc", $this->pkey);
		$html = '<option value="0">-- ' . $core->get_Lang('selecttype') . ' --</option>';
		if (is_array($lstType) && count($lstType) > 0) {
			foreach ($lstType as $k => $v) {
				$html .= '<option value="' . $v[$this->pkey] . '" ' . ($tour_type_id == $v[$this->pkey] ? 'selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
			}
			unset($lstType);
		}
		return $html;
	}
}
