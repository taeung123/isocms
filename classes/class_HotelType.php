<?php
class HotelType extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hotel_type_id";
		$this->tbl = DB_PREFIX . "hotel_type";
	}
	function getTitle($cat_id = 0)
	{
		$one = $this->getOne($cat_id);
		return $one['title'];
	}
	function getSlug($cat_id = 0)
	{
		$one = $this->getOne($cat_id, 'slug');
		return $one['slug'];
	}
	function getImage($cat_id = 0)
	{
		$one = $this->getOne($cat_id, 'image');
		return $one['image'];
	}

	function getIntro($cat_id = 0)
	{
		$one = $this->getOne($cat_id, 'intro');
		return $one['intro'];
	}
	function counthotel($hotel_type_id = 0)
	{
		$clshotel = new hotel();
		$allhotel = $clshotel->getAll("is_trash=0 and hotel_type_id='$hotel_type_id'");
		return $allhotel[0][$this->pkey] != '' ? count($allhotel) : 0;
	}
}
