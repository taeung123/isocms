<?php
class UploadFile
{
	function __construct()
	{
		// Some code
	}
	function uploadItem($file, $dirname, $allowExt)
	{
		$host = ftp_host_info;
		$usr = ftp_usr_info;
		$pwd = ftp_pwd_info;
		$abs_path = ftp_abs_path_info;
		//
		if ($this->checkValidFile($file, "", $allowExt)) {
			if (_ISOCMS_UPLOAD_FTP == 1) {
				$conn_id = ftp_connect($host) or die("Cannot connect to host");
				ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
				if (ftp_chdir($conn_id, $dirname)) {
					//return 2;//folder exist
				} else
					ftp_mkdir($conn_id, $dirname);
				$time = date('Y-m-d-h-i-s');
				$name = $dirname . '/' . $this->replaceSpace($file['name']);
				$upload = ftp_put($conn_id, $name, $file['tmp_name'], FTP_BINARY);
				ftp_close($conn_id);
				return $abs_path . $name;
			} else {
				$time = date('Y-m-d-h-i-s');
				if ($file['error'] > 0) {
					echo 'File Upload Bị Lỗi';
					die();
				} else {
					$target_dir = DIR_FILE_UPLOAD . $dirname . '/';
					$path_file = $abs_path . $dirname . "/";
					$file_ext = $this->replaceSpace($file["name"]);
					$target_file = $target_dir . $time . '-' . $file_ext;
					$url_file = $path_file . $time . '-' . $file_ext;
					if (!file_exists($path_file)) {
						mkdir($target_dir, 0777, true);
					}
					if (move_uploaded_file($file['tmp_name'], $target_file)) {
						return $url_file;
					} else {
						return false;
					}
				}
			}
		} else
			return 0;
	}
	function makeFolder($conn_id, $dirname)
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
	function uploadImageFromUrl($file, $slug)
	{
		$reg_date = time();
		#
		$host = ftp_host_info;
		$usr = ftp_usr_info;
		$pwd = ftp_pwd_info;
		$abs_path = ftp_abs_path_info;
		/*Get File Extension*/
		$path_parts = pathinfo($file);
		$ext = $path_parts['extension'];
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
			$ext = 'jpg';
		}
		/*Connect FTP*/
		$conn_id = ftp_connect($host) or die("Cannot connect to host");
		ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
		/*File Name*/
		$day = date('d', $reg_date);
		$month = date('m', $reg_date);
		$year = date('Y', $reg_date);
		$dirname = 'content/' . $year . '/' . $month . '/' . $day . '/' . $slug;
		#
		$nMn = md5($file);
		$nMn = substr($nMn, 0, 4);
		#
		$name = '/' . $dirname . '/' . $nMn . '.' . $ext;
		$res = ftp_size($conn_id, $name);
		//print_r($abs_path.$name);die();
		if ($res != -1) {
			//return 'available';
			return $abs_path . $name;
		} else {
			$this->makeFolder($conn_id, $dirname);
			list($width_orig, $height_orig) = getimagesize($file);
			#
			$temp_file = ftp_temp_file_info;
			if ($ext == "jpg") {
				$image_p = imagecreatetruecolor($width_orig, $height_orig);
				$image = imagecreatefromjpeg($file);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_orig, $height_orig, $width_orig, $height_orig);
				$temp_file .= $new_name . '.' . $ext;
				imagejpeg($image_p, $temp_file);
			} elseif ($ext == "png") {
				$image_p = imagecreatetruecolor($width_orig, $height_orig);
				$image = imagecreatefrompng($file);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_orig, $height_orig, $width_orig, $height_orig);
				$temp_file .= $new_name . '.' . $ext;
				imagepng($image_p, $temp_file);
			} elseif ($ext == "gif") {
				$image_p = imagecreatetruecolor($width_orig, $height_orig);
				$image = imagecreatefromgif($file);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_orig, $height_orig, $width_orig, $height_orig);
				$temp_file .= $new_name . '.' . $ext;
				imagegif($image_p, $temp_file);
			} else {
				return '';
			}
			//===================================================================
			$upload = ftp_put($conn_id, $name, $temp_file, FTP_BINARY);
			//===================================================================			
			imagedestroy($image_p);
			unlink($temp_file);
		}
		ftp_close($conn_id);
		return $abs_path . $name;
	}
	function uploadImageResize($file, $dirname, $allowExt, $w, $h, $new_name)
	{
		$host = ftp_host_info;
		$usr = ftp_usr_info;
		$pwd = ftp_pwd_info;
		$abs_path = ftp_abs_path_info;
		if ($this->checkValidFile($file, "", $allowExt)) {
			$conn_id = ftp_connect($host) or die("Cannot connect to host");
			ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
			if (ftp_chdir($conn_id, $dirname)) {
				//return 2;//folder exist
			} else
				ftp_mkdir($conn_id, $dirname);
			$time = date('Y-m-d.h.i.s');
			//===================================================================
			list($width_orig, $height_orig) = getimagesize($file['tmp_name']);
			$file_type = $file['type'];
			$temp_file = ftp_temp_file_info;
			if ($file_type == "image/pjpeg" || $file_type == "image/jpeg") {
				$ext = '.jpg';
				$image_p = imagecreatetruecolor($w, $h);
				$image = imagecreatefromjpeg($file['tmp_name']);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $width_orig, $height_orig);
				$temp_file .= $new_name . $ext;
				imagejpeg($image_p, $temp_file);
			} elseif ($file_type == "image/x-png" || $file_type == "image/png") {
				$ext = '.png';
				$image_p = imagecreatetruecolor($w, $h);
				$image = imagecreatefrompng($file['tmp_name']);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $width_orig, $height_orig);
				$temp_file .= $new_name . $ext;
				imagepng($image_p, $temp_file);
			} elseif ($file_type == "image/gif") {
				$ext = '.gif';
				$image_p = imagecreatetruecolor($w, $h);
				$image = imagecreatefromgif($file['tmp_name']);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $width_orig, $height_orig);
				$temp_file .= $new_name . $ext;
				imagegif($image_p, $temp_file);
			} else {
				return '';
			}
			$name = $dirname . '/' . $w . '-' . $h . '-' . $new_name . $ext;
			//===================================================================
			$upload = ftp_put($conn_id, $name, $temp_file, FTP_BINARY);
			//===================================================================
			ftp_close($conn_id);
			imagedestroy($image_p);
			return $abs_path . $name;
		}
		return '';
	}
	function base642imagejpeg($data, $filename, $dirname)
	{
		global $dbconn, $core, $clsISO, $_LANG_ID;
		$abs_path = ftp_abs_path_info;
		$dirname = $abs_path . $dirname;
		$dirname = str_replace('//', '/', $dirname);
		if (!is_dir(ABSPATH . $dirname)) {
			$clsISO->rmkdir(ABSPATH . $dirname, 0777);
		}
		$time = date('Y-m-d-h-i-s');
		$filename = $dirname . '/' . $time . '-' . $this->replaceSpace($filename);
		//$tmp = @explode(";base64,", $data);
		$data = @base64_decode($data);
		//header('Content-Type: image/jpeg');
		@write_file(ABSPATH . $filename, $data);
		// Return
		return $filename;
	}
	function replaceSpace($str)
	{
		$count = 1;
		while ($count)
			$str = str_replace(' ', '', $str, $count);
		return strtolower($str);
	}
	function checkValidFile($imgfile, $max_file_size = "", $allowExt = "")
	{
		if ($max_file_size == "") {
			$max_file_size = 10485760;
		}
		if ($allowExt == "") {
			$allowExt = "jpeg, jpg, gif";
		}
		$file_tmp = $imgfile['tmp_name'];
		$file_name = $imgfile["name"];
		$arrListExpExtension = explode("\.", $file_name);
		if (is_array($arrListExpExtension))
			foreach ($arrListExpExtension as $k => $v)
				if (preg_match("/php/", $v)) die();
		#		
		$extension = strtolower(substr(strrchr($file_name, "."), 1));
		//check extension
		if (strpos($allowExt, $extension) === false) {
			$errNo = 1; //extension is not allow
			return 0;
		}
		//check size
		$size = @filesize($file_tmp);
		if ($size > $max_file_size) {
			$errNo = 2; //size is not allow
			return 0;
		}
		//else
		return 1;
	}
}
