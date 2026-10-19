<?php
class Info extends dbBasic
{
	function __construct()
	{
		$this->pkey = "info_id";
		$this->tbl = DB_PREFIX . "info";
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
	function getTitle($pval = 0)
	{
		$one = $this->getOne($pval, 'title');
		return $one['title'];
	}
	function getSlug($pval = 0)
	{
		$one = $this->getOne($pval, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and (slug_vn='" . $slug . "' or slug_en='" . $slug . "')");
		return $res[0]['info_id'];
	}
	function getByAttraction($slug = '')
	{
		$res = $this->getAll("is_trash=0 and (slug_vn='" . $slug . "' or slug_en='" . $slug . "')");
		return $res[0]['pval'];
	}
	function getIntro($pval = 0)
	{
		$res = $this->getOne($pval, 'intro');
		return $res['intro'];
	}
	function getContent($pval = 0)
	{
		$res = $this->getOne($pval, 'content');
		return html_entity_decode($res['content']);
	}
	function getStripContent($pval = 0)
	{
		$res = $this->getOne($pval, 'content');
		return strip_tags(html_entity_decode($res['content']));
	}
	function getImage($pval = 0, $w = 0, $h = 0)
	{
		$one = $this->getOne($pval, 'image');
		return $one['image'];
	}
	function getLink($pval = 0)
	{
		$clsCountry = new Country();
		$oneItem = $this->getOne($pval, 'country_id');
		return '/destinations/' . $clsCountry->getSlug($oneItem['country_id']) . '-travel-tips/' . $this->getSlug($pval) . '.html';
	}
}
