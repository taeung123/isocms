<?php

class TagBlog extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tag_blog_id";
		$this->tbl = DB_PREFIX . "tag_blog";
	}

	function geAllTagBlog()
	{
		global $dbconn;
		global $_LANG_ID;
		return $arrListCat =  $dbconn->GetAll("SELECT DISTINCT tag_id FROM " . $this->tbl . " order by tag_blog_id asc");
	}
}
