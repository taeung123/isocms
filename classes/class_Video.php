<?php
class Video extends dbBasic
{
	function __construct()
	{
		$this->pkey = "video_id";
		$this->tbl = DB_PREFIX . "video";
	}
	function getTitle($video_id = 0)
	{
		$one = $this->getOne($video_id, "title");
		return $one['title'];
	}
	function getSlug($video_id = 0)
	{
		$one = $this->getOne($video_id, "slug");
		return $one['slug'];
	}
	function getText($video_id = 0)
	{
		$one = $this->getOne($video_id, "text");
		return html_entity_decode($one['text']);
	}
	function getType($video_id = 0)
	{
		$one = $this->getOne($video_id, "type");
		return $one['type'];
	}
	function getAuthor($video_id = 0)
	{
		$one = $this->getOne($video_id, "author_photo");
		return $one['author_photo'];
	}
	function getLargeText($video_id = 0)
	{
		$one = $this->getOne($video_id, "large_text");
		return html_entity_decode($one['large_text']);
	}
	function getSmallText($video_id = 0)
	{
		$one = $this->getOne($video_id, "small_text");
		return html_entity_decode($one['small_text']);
	}
	function getIntro($video_id = 0)
	{
		$one = $this->getOne($video_id, "text");
		return html_entity_decode($one['text']);
	}
	function getUrl($video_id = 0)
	{
		$one = $this->getOne($video_id, "link");
		return $one['link'];
	}
	function getLink($video_id = 0)
	{
		$one = $this->getOne($video_id, "link");
		return $one['link'];
	}
	function getLinkVideo($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable);
		return str_replace("https://www.youtube.com/watch?v=", "https://youtu.be/", $one['link']);
	}
	function getLinkVideoIframe($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable);
		return str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $one['link']);
	}
	function getIDVideoYoutube($video_id = 0)
	{
		$one = $this->getOne($video_id, "link");
		$url_video = $one['link'];
		$id_video = str_replace("https://www.youtube.com/watch?v=", "", $url_video);
		return $id_video;
	}
	function getIDVideo($video_id = 0)
	{
		$one = $this->getOne($video_id, "link");
		$url_video = $one['link'];
		$id_video = str_replace("https://vimeo.com/", "", $url_video);
		return $id_video;
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
		}
		return 'https://img.youtube.com/vi/' . $this->getIDVideoYoutube($pvalTable) . '/maxresdefault.jpg';
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getBackgroundVideo($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getImageOld($video_id = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$image = $this->getOneField('image', $video_id);
		$noimage = URL_IMAGES . '/noimage.png';
		if ($image != '' && $image != '0')
			return $clsISO->parseImageURL($image);
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getListModPage()
	{
		global $core;
		$lstModule = array();
		$lstModule['home'] = $core->get_Lang('Home');
		$lstModule['tour'] = $core->get_Lang('Tour');
		$lstModule['hotel'] = $core->get_Lang('Hotel');
		$lstModule['country'] = $core->get_Lang('Country');
		$lstModule['city'] = $core->get_Lang('City');
		$lstModule['promotion'] = $core->get_Lang('Promotion');
		$lstModule['page'] = $core->get_Lang('Page');
		return $lstModule;
	}
	function makeSelectModPage($selected = "")
	{
		global $core;
		$lstModule = $this->getListModPage();
		$html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';
		if (!empty($lstModule)) {
			foreach ($lstModule as $k => $v) {
				$html .= '<option value="' . $k . '" ' . ($selected == $k ? 'selected="selected"' : '') . '>-- ' . $v . ' --</option>';
			}
		}
		return $html;
		die();
	}
	function checkModuleExist($pvalTable = 0, $module = '')
	{
		$oneItem = $this->getOne($pvalTable);
		$str = $oneItem['mod_page'];
		$str = str_replace('||', '|', $str);
		$str = ltrim($str, '|');
		$str = rtrim($str, '|');
		$str_array = explode('|', $str);
		for ($i = 0; $i < count($str_array); $i++) {
			if ($str_array[$i] == $module) {
				return 1;
			}
		}
		return 0;
	}
	function doDelete($pvalTable = 0)
	{
		// Delete
		$this->deleteOne($pvalTable);
		return 1;
	}
}
