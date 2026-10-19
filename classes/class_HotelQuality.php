<?php
class HotelQuality extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hotel_quality_id";
		$this->tbl = DB_PREFIX . "hotel_quality";
		#Create Table If Not Exist
		$sqlCreate =    $this->pkey . " INT(11) NOT NULL AUTO_INCREMENT, 
						title VARCHAR(255) NOT NULL, 
						intro TEXT(0) NOT NULL, 
						parent_id INT(10) NOT NULL,
						order_no INT(10) NOT NULL,
						image VARCHAR(255) NOT NULL, 
						is_trash TINYINT(1) NOT NULL";
		#
		$sqlInit_f = '';
		$sqlInit_v = '';
		$this->createTableDB($sqlCreate, $sqlInit_f, $sqlInit_v);
		#End Create
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
	function counthotel($hotel_quality_id = 0)
	{
		$clshotel = new hotel();
		$allhotel = $clshotel->getAll("is_trash=0 and hotel_quality_id='$hotel_quality_id'");
		return $allhotel[0][$this->pkey] != '' ? count($allhotel) : 0;
	}
}
