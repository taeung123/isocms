<?php
class PriceTable extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "price_table_id";
		$this->tbl = DB_PREFIX . "price_table";
	}
	function getValue($price_table_id = 0, $type = '')
	{
		return $this->getAll("is_trash=0 and type='$type' and obj_id='$price_table_id'");
	}
}
