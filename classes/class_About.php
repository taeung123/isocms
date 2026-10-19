<?php

class About extends dbBasic
{

    function __construct()
    {
        $this->pkey = "about_id";
        $this->tbl = DB_PREFIX . "about";
    }

    function getSlash($level = 0)
    {
        return str_repeat("------", $level + 1);
    }

    function countByCountry($country_id = 0)
    {
        $sql = "is_trash=0 and country_id='$country_id'";
        return $this->getAll($sql) ? count($this->getAll($sql)) : 0;
    }

    function countByCity($city_id = 0)
    {
        $sql = "is_trash=0 and city_id='$city_id'";
        return $this->getAll($sql) ? count($this->getAll($sql)) : 0;
    }

    function getTitle($about_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($about_id);
        return $one['title'];
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
            return $clsISO->tripslashImage($image, $w, $h);
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
            return $clsISO->tripslashImage($image, $w, $h);
        }
        return URL_IMAGES . '/noimage.png';
    }
    function getMetaDescription($pvalTable = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro']);
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

    function makeFolder($conn_id = '', $dirname = '')
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
        $reg_date = $oneNews['reg_date'] ?? time();

        // --- FTP constants check ---
        if (!defined('ftp_host_info') || !defined('ftp_usr_info') || !defined('ftp_pwd_info') || !defined('ftp_abs_path_info') || !defined('ftp_temp_file_info')) {
            trigger_error('Missing FTP configuration constants', E_USER_WARNING);
            return '';
        }

        $host = ftp_host_info;
        $usr = ftp_usr_info;
        $pwd = ftp_pwd_info;
        $abs_path = ftp_abs_path_info;

        // --- Get file extension ---
        $path_parts = pathinfo($file);
        $ext = strtolower($path_parts['extension'] ?? 'jpg');
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $ext = 'jpg';
        }

        // --- Connect FTP safely ---
        $conn_id = @ftp_connect($host);
        if (!$conn_id) {
            trigger_error("Cannot connect to FTP host: $host", E_USER_WARNING);
            return '';
        }

        $login = @ftp_login($conn_id, $usr, $pwd);
        if (!$login) {
            ftp_close($conn_id);
            trigger_error("Cannot login to FTP server as $usr", E_USER_WARNING);
            return '';
        }

        // --- Build file paths ---
        $day = date('d', $reg_date);
        $month = date('m', $reg_date);
        $year = date('Y', $reg_date);
        $dirname = "content/$year/$month/$day";

        $nMn = substr(md5($file), 0, 4);
        $new_name = $slug . '-' . $nMn;
        $name = '/' . $dirname . '/' . $new_name . '.' . $ext;

        // --- Check if file already exists on FTP ---
        $res = @ftp_size($conn_id, $name);
        if ($res !== -1 && $res > 0) {
            ftp_close($conn_id);
            return $abs_path . $name;
        }

        // --- Make folder if missing ---
        $this->makeFolder($conn_id, $dirname);

        // --- Get image size ---
        $image_info = @getimagesize($file);
        if ($image_info === false) {
            ftp_close($conn_id);
            trigger_error("Invalid image file: $file", E_USER_WARNING);
            return '';
        }

        [$width_orig, $height_orig] = $image_info;
        $temp_file = rtrim(ftp_temp_file_info, '/\\') . '/' . $new_name . '.' . $ext;

        // --- Create image resource safely ---
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $image = @imagecreatefromjpeg($file);
                break;
            case 'png':
                $image = @imagecreatefrompng($file);
                break;
            case 'gif':
                $image = @imagecreatefromgif($file);
                break;
            default:
                ftp_close($conn_id);
                return '';
        }

        if (!$image) {
            ftp_close($conn_id);
            trigger_error("Failed to create image from source: $file", E_USER_WARNING);
            return '';
        }

        $image_p = imagecreatetruecolor($width_orig, $height_orig);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_orig, $height_orig, $width_orig, $height_orig);

        // --- Save to temp file ---
        $save_success = match ($ext) {
            'jpg', 'jpeg' => imagejpeg($image_p, $temp_file),
            'png' => imagepng($image_p, $temp_file),
            'gif' => imagegif($image_p, $temp_file),
            default => false,
        };

        if (!$save_success) {
            imagedestroy($image_p);
            ftp_close($conn_id);
            trigger_error("Failed to save temporary image file", E_USER_WARNING);
            return '';
        }

        // --- Upload to FTP (binary mode) ---
        $upload = @ftp_put($conn_id, $name, $temp_file, FTP_BINARY);

        // --- Cleanup ---
        imagedestroy($image_p);
        if (file_exists($temp_file)) unlink($temp_file);
        ftp_close($conn_id);

        return $upload ? $abs_path . $name : '';
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
