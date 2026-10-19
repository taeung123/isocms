<?php
class Testimonial extends dbBasic
{
	function __construct()
	{
		$this->pkey = "testimonial_id";
		$this->tbl = DB_PREFIX . "testimonial";
	}
	function checkOnlineBySlug($testimonial_id = 0, $slug = '')
	{
		$item = $this->getAll("is_trash=0 and is_online=1 and testimonial_id='$testimonial_id' and slug='$slug'");
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
	function getSlug($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'slug');
		return $one['slug'];
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($pvalTable = 0, $one = null)
	{
		if (!isset($one['intro'])) {
			$one = $this->getOne($pvalTable, 'intro');
		}
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
	function getRegDate($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'reg_date');
		return date('m/d/Y', $one['reg_date']);
	}
	function getLink($pvalTable = 0, $oneTable = null)
	{
		global $extLang, $_LANG_ID;
		if (!isset($oneTable['slug'])) {
			$oneTable = $this->getOne($pvalTable, 'slug');
		}
		return $extLang . '/te' . $pvalTable . '-' . $oneTable['slug'] . '.html';
	}
	function getName($pvalTable = 0, $one = null)
	{
		if (!isset($one['name'])) {
			$one = $this->getOne($pvalTable, 'name');
		}
		return $one['name'];
	}
	function getCountry($pvalTable = 0, $one = null)
	{
		global $_LANG_ID;
		$clsCountry = new _Country();
		if (!isset($one['country_id'])) {
			$one = $this->getOne($pvalTable, 'country_id');
		}
		return $clsCountry->getTitle($one['country_id']);
	}
	function getRatesStar($pvalTable = 0, $oneTable = null)
	{
		if (!isset($oneTable['rates'])) {
			$oneTable = $this->getOne($pvalTable, 'rates');
		}
		$rates = $oneTable['rates'];
		return '<span style="width: ' . ($rates * 20) . '%;"></span>';
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
	function getUrlImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function doDelete($pvalTable = 0)
	{
		// Delete
		$this->deleteOne($pvalTable);
		return 1;
	}

	function getRatesTextNumber($pvalTable = 0, $oneTable = null, $act = '')
	{
		global $dbconn, $core;
		$cond = "is_trash = 0 AND is_online = 1";

		$txtReview = [
			$core->get_Lang('Bad'),
			$core->get_Lang('Average'),
			$core->get_Lang('Good'),
			$core->get_Lang('Excellent'),
			$core->get_Lang('Wonderful')
		];

		if (!isset($oneTable['rates'])) {
			$oneTable = $this->getOne($pvalTable, 'rates', $cond);
		}
		$rates = $oneTable['rates'];

		$index = max(0, min(round($rates) - 1, 5));

		switch ($act) {
			case 'txt_review':
				$rec = $txtReview[$index] ?? $core->get_Lang('No reviews');
				break;

			case 'avg_point':
				$rec = number_format($rates, 1);
				break;

			default:
				$rec = '<span class="rates_score">' . number_format($rates, 1) . '</span>'  . ' - ' . '<span class="rates_text">' . ($txtReview[$index] ?? $core->get_Lang('No reviews')) . '</span>';
				break;
		}
		return $rec;
	}
}
