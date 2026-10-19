<?php
class TourDomainStore extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_domain_store_id";
		$this->tbl = DB_PREFIX . "tour_domain_store";
	}
	function getListCatID($tour_id = 0, $domain_id = 0)
	{
		$res = $this->getAll("tour_id = '$tour_id' and domain_id = '$domain_id' and val='1'");
		return !empty($res) ? $res[0]['list_cat_id'] : 0;
	}
}
