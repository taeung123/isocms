<?php
class DiscountItem extends dbBasic
{
	function __construct()
	{
		$this->pkey = "discount_item_id";
		$this->tbl = DB_PREFIX . "discount_item";
	}
}
