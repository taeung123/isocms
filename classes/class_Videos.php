<?php

class Video extends dbBasic
{
	function __construct()
	{
		$this->pkey = "video_id";
		$this->tbl = DB_PREFIX . "videos";
	}
	function getVideoInfo($video_url = '')
	{
		require_once(DIR_INCLUDES . '/media_embed.php');
		#
		$media_embed = new media_embed($video_url);
		$site = $media_embed->get_site();
		$_info = array();
		#
		if ($site != '') {
			$_info['title'] = html_entity_decode(trim($media_embed->get_title()));
			$_info['thumb'] = $media_embed->get_thumb();
			$_info['thumb_medium'] = $media_embed->get_thumb('medium');
			$_info['thumb_large'] = $media_embed->get_thumb('large');
			$_info['iframe'] = $media_embed->get_iframe();
			$_info['embed'] = $media_embed->get_embed();
			$_info['size'] = $media_embed->get_size();
			$_info['site'] = $media_embed->get_site();
		}
		return $_info;
	}
}
