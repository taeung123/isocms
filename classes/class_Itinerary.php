<?php
class Itinerary extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_itinerary_id";
		$this->tbl = DB_PREFIX . "tour_itinerary";
	}
	function getMaxDay($tour_id = 0)
	{
		$res = $this->getAll("1=1 and tour_id = '$tour_id' order by order_no desc");
		return intval($res[0]['day']) + 1;
	}
	function getMaxOrder()
	{
		$res = $this->getAll("1=1 order by order_no desc");
		return intval($res[0]['order_no']) + 1;
	}
	function countTotalItinerary($tour_id = 0)
	{
		$res = $this->getAll("is_trash=0 and tour_id='$tour_id'");
		return !empty($res) ? count($res) : 0;
	}
	function initItinerary_automatic($tour_id = 0, $action = '')
	{
		$clsTour = new Tour();
		$one = $clsTour->getOne($tour_id, 'duration_type,number_day');
		$duration_type = $one['duration_type'];
		$number_day = intval($one['number_day']);
		if ($duration_type) {
			$lstItinerary = $this->getAll("1=1 and tour_id='$tour_id' order by order_no asc");
			if (!empty($lstItinerary)) {
				$f = "day,tour_id,order_no,reg_date,upd_date,type";
				$v = "'$i','$tour_id','" . $this->getMaxOrder() . "','" . time() . "','" . time() . "','CUSTOM'";
			}
		} else {
			$total_itinerary = $this->countTotalItinerary($tour_id);
			#
			if ($number_day > 0 && $total_itinerary == 0 && $action == '') {
				for ($i = 1; $i <= $number_day; $i++) {
					$f = "day,tour_id,order_no,reg_date,upd_date";
					$v = "'$i','$tour_id','" . $this->getMaxOrder() . "','" . time() . "','" . time() . "'";
					$this->insertOne($f, $v);
				}
				unset($i);
			}
			if ($number_day > 0 && $total_itinerary > 0 && $number_day > $total_itinerary && $action == '') {
				$range = $number_day - $total_itinerary;
				for ($i = $total_itinerary + 1; $i <= $number_day; $i++) {
					$f = "day,tour_id,order_no,reg_date,upd_date";
					$v = "'$i','$tour_id','" . $this->getMaxOrder() . "','" . time() . "','" . time() . "'";
					$this->insertOne($f, $v);
				}
				unset($i);
				#
				$lstItinerary = $this->getAll("1=1 and tour_id='$tour_id' order by order_no asc");
				if (!empty($lstItinerary)) {
					for ($i = 1; $i <= count($lstItinerary); $i++) {
						$this->updateOne($lstItinerary[$i][$this->pkey], "day='$i'");
					};
				}
			}
			if (($total_itinerary < $number_day) && $action == 'update_total_itinerary') {
				$clsTour->updateOne($tour_id, "number_day='$total_itinerary'");
			}
		}
	}
	function checkExist($day = 0, $tour_id = 0)
	{
		$res = $this->getAll("day='$day' and tour_id='$tour_id' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getUrlImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getTitle($pval = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pval, 'title');
		$title = $one['title'];
		return $title;
	}
	function getMeal($id = 0)
	{
		$one = $this->getOne($id, 'meals');
		if ($one['meals'] == '') {
			return '';
		} else {
			return '(' . $one['meals'] . ')';
		}
	}
	function getRegDate($news_id = 0)
	{
		$one = $this->getOne($news_id, 'reg_date');
		return date('H:i d/m/Y', $one['reg_date']);
	}
	function getDay($news_id = 0)
	{
		global $_LANG_ID;

		$prefix = ($_LANG_ID == 'en') ? 'Day ' : 'Ngày ';
		$one = $this->getOne($news_id);
		return $prefix . $one['day'];
	}
	function getIntro($news_id = 0)
	{
		$one = $this->getOne($news_id, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getContent($news_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($news_id, 'content');
		return html_entity_decode($one['content']);
	}
	function getHotelRecommend($pval = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pval, 'hotel_recommend');
		return html_entity_decode($one['hotel_recommend']);
	}
	function checkContain($haystack = '', $needle = '')
	{
		$pos = strpos($haystack, $needle);

		if ($pos === false) {
			return 0;
		} else {
			return 1;
		}
	}
	function resizeImageFromUrl($file = '', $w = 0, $h = 0, $new_name = '', $dir = '')
	{
		$host = ftp_host_info_local;
		$usr = ftp_usr_info_local;
		$pwd = ftp_pwd_info_local;
		$abs_path = ftp_abs_path_info_local;
		/*Get File Extension*/
		$path_parts = pathinfo($file);
		$ext = $path_parts['extension'];
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif' && $ext != 'JPG' && $ext != 'PNG' && $ext != 'GIF') {
			$ext = 'jpg';
		}
		$f_name = substr(md5($path_parts['filename']), 0, 4);
		/*Connect FTP*/
		$conn_id = ftp_connect($host) or die("Cannot connect to host");
		ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
		/*File Name*/
		$name = '/thumbs' . $dir . '/' . $w . '-' . $h . '-' . $new_name . '-' . $f_name . '.' . $ext;
		$res = ftp_size($conn_id, $name);

		if ($res != -1) {
			//return 'available';
			return $abs_path . $name;
		} else {
			//return 'not available';
			if (ftp_chdir($conn_id, '/thumbs' . $dir)) {
				//return 2;//folder exist
			} else
				ftp_mkdir($conn_id, '/thumbs' . $dir);

			list($width_orig, $height_orig) = getimagesize($file);

			$temp_file = ftp_temp_file_info;
			if ($ext == "jpg") {
				$image_p = imagecreatetruecolor($w, $h);
				$image = imagecreatefromjpeg($file);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $width_orig, $height_orig);
				$temp_file .= $new_name . '.' . $ext;
				imagejpeg($image_p, $temp_file);
			} elseif ($ext == "png") {
				$image_p = imagecreatetruecolor($w, $h);
				$image = imagecreatefrompng($file);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $width_orig, $height_orig);
				$temp_file .= $new_name . '.' . $ext;
				imagepng($image_p, $temp_file);
			} elseif ($ext == "gif") {
				$image_p = imagecreatetruecolor($w, $h);
				$image = imagecreatefromgif($file);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $width_orig, $height_orig);
				$temp_file .= $new_name . '.' . $ext;
				imagegif($image_p, $temp_file);
			} else {
				return '';
			}

			//===================================================================
			$upload = ftp_put($conn_id, $name, $temp_file, FTP_ASCII);
			//===================================================================
			imagedestroy($image_p);
			unlink($temp_file);
		}
		ftp_close($conn_id);
		return $abs_path . $name;
	}
	function makeFolder($conn_id = 0, $dirname = '')
	{
		$lst = explode('/', $dirname);
		$str = '/' . $lst[0];
		for ($i = 1; $i < count($lst); $i++) {
			$str = $str . '/' . $lst[$i];
			if (!ftp_chdir($conn_id, $str)) {
				ftp_mkdir($conn_id, $str);
			}
		}
		return 1;
	}
	function updateContent($news_id = 0)
	{
		$one = $this->getOne($news_id);
		$content = ($one['content']);
		//$content = preg_replace('/style=\&quot;(.*?)\&quot;/si','', $content);
		$content = preg_replace('/face=\&quot;(.*?)\&quot;/si', '', $content);
		$content = preg_replace('/class=\&quot;(.*?)\&quot;/si', '', $content);
		//$content = preg_replace('/href=\&quot;(.*?)\&quot;/si','', $content);
		$content = preg_replace('/\&lt;!--(.*?)--\&gt;/si', '', $content);
		$content = preg_replace('/size=\&quot;(.*?)\&quot;/si', '', $content);
		$content = preg_replace('/\&lt;script(.*?)\&quot;\/script\&lt;/si', '', $content);

		$content = str_replace('&nbsp;', ' ', $content);

		//$content = preg_replace('/style="(.*?)"/si','', $content);
		$content = preg_replace('/<script(.*?)<\/script>/si', '', $content);
		$content = preg_replace('/class="(.*?)"/si', '', $content);
		$content = preg_replace('/face="(.*?)"/si', '', $content);
		//$content = preg_replace('/href="(.*?)"/si','', $content);
		$content = preg_replace('/<!--(.*?)-->/si', '', $content);
		$content = preg_replace('/size="(.*?)"/si', '', $content);
		#
		preg_match_all("/src=&quot;(.*?)&quot;/si", $content, $matches);
		if ($matches[1][0] == '') {
			preg_match_all("/src=\"(.*?)\"/si", $content, $matches);
		}
		$slug = $one['slug'];
		#
		//print($matches[1][0]);die();
		for ($i = 0; $i < count($matches[1]); $i++) {
			$tmp = $matches[1][$i];
			if ($tmp != '' && $this->checkContain($tmp, 'www.amthuc365.vn') == 0) {
				list($width, $height) = getimagesize($tmp);
				if ($width * $height != 0) {
					$img = $this->resizeImageFromUrl($tmp, $width, $height, $slug, '/food-thumb');
					//print($img);die();
					$content = str_replace($tmp, $img, $content);
				}
			}
		}
		//print($content);die();
		#
		$this->updateOne($news_id, "content='" . addslashes($content) . "'");
	}
}
