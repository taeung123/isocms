<?php
class BlogDestination extends dbBasic
{
	function __construct()
	{
		$this->pkey = "blog_destination_id";
		$this->tbl = DB_PREFIX . "blog_destination";
	}
	function getMaxOrderNoByTable($blog_id = 0)
	{
		$res = $this->getAll("blog_id='$blog_id' order by order_no DESC limit 0,1");
		return intval($res[0]['order_no']) + 1;
	}
	function checkExist($blog_id = 0, $destination_id = 0)
	{
		$res = $this->getAll("blog_id='$blog_id' and destination_id='$destination_id' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getByDestination($blog_id = 0, $destination_id = 0)
	{
		$all = $this->getAll("is_trash=0 and blog_id='$blog_id' and destination_id='$destination_id' order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
}
