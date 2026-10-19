<?php
class VideoStore extends dbBasic
{
	function __construct()
	{
		$this->pkey = "video_store_id";
		$this->tbl = DB_PREFIX . "video_store";
	}

	function getListType()
	{
		global $core;
		$lstType = array();
		$lstType['TOPVIDEO'] = $core->get_Lang('Top Videos');
		return $lstType;
	}
	function getTitle($type = '')
	{
		$lstType = $this->getListType();
		return $lstType[$type];
	}
	function checkExist($video_id = 0, $type = '')
	{
		$res = $this->getAll("video_id='$video_id' and _type='$type' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
}
