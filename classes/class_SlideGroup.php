<?php

class SlideGroup extends dbBasic
{
	function __construct()
	{
		$this->pkey = "slide_group_id";
		$this->tbl = DB_PREFIX . "slide_group";
	}
	function getTitle($pval = 0)
	{
		$one = $this->getOne($pval, 'title');
		return $one['title'];
	}
	function getSize($pval = 0)
	{
		$one = $this->getOne($pval);
		return $one['_width'] . 'x' . $one['_height'];
	}
}
