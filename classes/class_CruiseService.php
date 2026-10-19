<?php
class CruiseService extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_service_id";
		$this->tbl = DB_PREFIX . "cruise_service";
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
	function getPrice($pvalTable = 0)
	{
		global $clsISO;
		$one = $this->getOne($pvalTable, 'price');
		return $clsISO->formatPrice($one['price'] ?? 0);
	}
	function getPriceNumber($pvalTable = 0)
	{
		global $clsISO;
		$one = $this->getOne($pvalTable, 'price');
		return $one['price'];
	}
	function getPriceValue($pvalTable = 0)
	{
		global $clsISO;
		$one = $this->getOne($pvalTable, 'price');
		return $one['price'] ?? 0;
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro'] ?? '');
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
	function doDelete($pvalTable = 0)
	{
		$this->deleteOne($pvalTable);
	}
}
