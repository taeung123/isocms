<?php
class BlogExtension extends dbBasic
{
	function __construct()
	{
		$this->pkey = "blog_extension_id";
		$this->tbl = DB_PREFIX . "blog_extension";
	}
	function checkExist($blog_id = 0, $table_id = 0, $table_name = '')
	{
		$res = $this->getAll("is_trash=0 and blog_id='$blog_id' and " . $table_name . "_id='$table_id' and table_name='$table_name' limit 0,1");
		return !empty($res) ? 1 : 0;
	}
}
