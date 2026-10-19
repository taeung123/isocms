<?php
class Gallery extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "gallery_id";
		$this->tbl = DB_PREFIX . "gallery";
	}
	function getTitle($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'title');
		return $one['title'];
	}
	function getSlug($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'slug');
		return $one['slug'];
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getContent($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'content');
		return html_entity_decode($one['content']);
	}
	function getStripIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro', 'content');
		if (!empty($one['intro']))
			return strip_tags(html_entity_decode($one['intro']));
		return strip_tags(html_entity_decode($one['content']));
	}
	function getLink($pvalTable = 0, $allow_full_url = 1)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/gallery/' . $this->getSlug($pvalTable) . '.html';
	}
	function getListGallery($gallerycat_id = 0)
	{
		$lst = $this->getAll("is_trash=0 and gallerycat_id='$gallerycat_id' order by order_no desc");
		return $lst;
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
			$noimage = URL_IMAGES . '/noimage.png';
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
		}
		return URL_IMAGES . '/noimage.png';
	}
	function getImageRand1($pvalTable = 0, $i = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			if ($i == 4) {
				return "/files/thumb?w=482&h=400&src={$clsISO->parseImageURL($image)}";
			} else {
				return "/files/thumb?w=231&h=185&src={$clsISO->parseImageURL($image)}";
			}
		}
		return URL_IMAGES . '/noimage.png';
	}
	function getImageRand2($pvalTable = 0, $i = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return "/files/thumb?w=263&h=185&src={$clsISO->parseImageURL($image)}";
		}
		return URL_IMAGES . '/noimage.png';
	}
	function getLinkVideo($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable);
		return str_replace("https://www.youtube.com/watch?v=", "https://youtu.be/", $one['youtube_link']);
	}
	function getLinkVideoIframe($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable);
		return str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $one['youtube_link']);
	}
	function getIDVideo($video_id = 0)
	{
		$one = $this->getOne($video_id, "youtube_link");
		$url_video = $one['link'];
		$id_video = str_replace("https://vimeo.com/", "", $url_video);
		return $id_video;
	}
	function doDelete($pvalTable = 0)
	{
		// Delete News
		$this->deleteOne($pvalTable);
		return 1;
	}
}
