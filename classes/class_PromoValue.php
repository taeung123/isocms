<?php
class PromoValue extends dbBasic
{
    function __construct()
    {
        $this->pkey = "promo_value_id";
        $this->tbl = "ta_promo_value";
    }
    function getSlash($level = 0)
    {
        return str_repeat("------", $level + 1);
    }
    function countByCountry($country_id = 0)
    {
        $sql = "is_trash=0 and country_id='$country_id'";
        return $this->countItem($sql);
    }
    function countByCity($city_id = 0)
    {
        $sql = "is_trash=0 and city_id='$city_id'";
        return $this->countItem($sql);
    }
    function getTitle($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id, 'title');
        return $one['title'];
    }
    function getTypePromo($promo_value_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($promo_value_id);
        return $one['type_promo'];
    }
    function getAuthor($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        return $one['author_photo'];
    }
    function getSlug($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        return $one['slug'];
    }
    function getRegDate($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        return date('F, d Y', $one['reg_date']);
    }
    function getBySlug($slug = '')
    {
        $all = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
        return $all[0][$this->pkey];
    }
    function getLink($about_id = 0)
    {
        global $extLang, $_LANG_ID;
        $clsAboutCategory = new AboutCategory();
        #
        $aboutcat_id = $this->getOneField('cat_id', $about_id);
        return $extLang . $clsAboutCategory->getLink($aboutcat_id) . '/' . $this->getSlug($about_id);
    }
    function getPermalink($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        return $one['permalink'];
    }
    function getImage($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, "image");
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
        }
        return URL_IMAGES . '/noimage.png';
    }
    function getImageHome($pvalTable = 0, $w = 0, $h = 0)
    {
        global $clsISO;
        #
        $oneTable = $this->getOne($pvalTable, "imagehome");
        if ($oneTable['imagehome'] != '') {
            $image = $oneTable['imagehome'];
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
        }
        return URL_IMAGES . '/noimage.png';
    }
    function getIntro($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        return html_entity_decode($one['intro']);
    }
    function getContent($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        return html_entity_decode($one['content']);
    }
    function makeFolder($conn_id = 0, $dirname = '')
    {
        $lst = explode('/', $dirname);
        $str = '/' . $lst[0];
        for ($i = 1; $i < count($lst); $i++) {
            $str = $str . '/' . $lst[$i];
            if (!ftp_chdir($conn_id, $str)) {
                ftp_mkdir($conn_id, $str);
                error_reporting(0);
            }
        }
        return 1;
    }
    function getImageFromUrl($file = '', $news_id = 0)
    {
        $slug = $this->getSlug($news_id);
        $oneNews = $this->getOne($news_id);
        $reg_date = $oneNews['reg_date'];
        #
        $host = ftp_host_info;
        $usr = ftp_usr_info;
        $pwd = ftp_pwd_info;
        $abs_path = ftp_abs_path_info;
        /* Get File Extension */
        $path_parts = pathinfo($file);
        $ext = $path_parts['extension'];
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
            $ext = 'jpg';
        }
        /* Connect FTP */
        $conn_id = ftp_connect($host) or die("Cannot connect to host");
        ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
        /* File Name */
        $day = date('d', $reg_date);
        $month = date('m', $reg_date);
        $year = date('Y', $reg_date);
        $dirname = 'content/' . $year . '/' . $month . '/' . $day;
        #
        $nMn = md5($file);
        $nMn = substr($nMn, 0, 4);
        #
        $name = '/' . $dirname . '/' . $slug . '-' . $nMn . '.' . $ext;
        $res = ftp_size($conn_id, $name);
        //print_r($abs_path.$name);die();
        if ($res != -1) {
            //return 'available';
            return $abs_path . $name;
        } else {
            $this->makeFolder($conn_id, $dirname);
            list($width_orig, $height_orig) = getimagesize($file);
            //print_r($width_orig.'/'.$height_orig);die();
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
            $upload = ftp_put($conn_id, $name, $temp_file, FTP_ASCII);
            //===================================================================			
            imagedestroy($image_p);
            unlink($temp_file);
        }
        ftp_close($conn_id);
        return $abs_path . $name;
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
    function updateImage($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        if ($one['updateImage'] == 1) {
            return 0;
        }
        $content = $one['content'];
        preg_match_all("/src=&quot;(.*?)&quot;/si", $content, $matches);
        if ($matches[1][0] == '') {
            preg_match_all("/src=\"(.*?)\"/si", $content, $matches);
        }
        $slug = $this->getSlug($about_id);
        #

        for ($i = 0; $i < count($matches[1]); $i++) {
            $tmp = $matches[1][$i];
            if ($tmp != '' && $this->checkContain($tmp, 'aprotravel') == 0) {
                list($width, $height) = getimagesize($tmp);
                if ($width * $height != 0) {
                    $clsUploadFile = new UploadFile();
                    $img = $clsUploadFile->uploadImageFromUrl($tmp, $slug);
                    $content = str_replace($tmp, $img, $content);
                }
            }
        }
        $this->updateOne($about_id, 'content' . "='" . addslashes($content) . "',updateImage='1'");
    }
    function getTag($about_id = 0)
    {
        $clsTagModule = new TagModule();
        return $clsTagModule->getTag($about_id, 'ABOUT');
    }
    function getStripIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        if (!empty($one['intro']))
            return strip_tags(html_entity_decode($one['intro']));
        return strip_tags(html_entity_decode($one['content']));
    }
    function doDelete($about_id = 0)
    {
        $this->deleteOne($about_id);
        return 1;
    }
}
