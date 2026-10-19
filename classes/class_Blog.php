<?php

class Blog extends dbBasic
{
    function __construct()
    {
        $this->pkey = "blog_id";
        $this->tbl = DB_PREFIX . "blog";
    }

    function checkOnlineBySlug($blog_id = 0, $slug = '')
    {
        $item = $this->getAll("is_trash=0 and is_online=1 and blog_id='$blog_id' and slug='$slug'", $this->pkey);
        if (empty($item))
            return 0;
        return 1;
    }

    function getSlash($level = 0)
    {
        return str_repeat("------", $level + 1);
    }

    function countByCountry($country_id = 0)
    {
        $sql = "is_trash=0 and is_online=1 and country_id='$country_id'";
        return $this->getAll($sql) ? count($this->getAll($sql)) : 0;
    }

    function countByCity($city_id = 0)
    {
        $sql = "is_trash=0 and is_online=1 and city_id='$city_id'";
        return $this->getAll($sql) ? count($this->getAll($sql)) : 0;
    }

    function getTitle($blog_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['title'])) {
            $one = $this->getOne($blog_id, 'title');
        }
        return $one['title'];
    }

    function getAuthor($blog_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['author'])) {
            $one = $this->getOne($blog_id, 'author');
        }
        return $one['author'];
    }

    function getSlug($blog_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($blog_id, 'slug');
        return $one['slug'];
    }

    function checkSlug($slug = '')
    {
        global $_LANG_ID;
        $one = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
        return $one ? 'blog' : 'news';
    }

    function getRegDate($blog_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($blog_id, 'reg_date');
        return date('F, d Y', $one['reg_date']);
    }

    function getPublicDate($blog_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($blog_id, 'publish_date');
        return date('F jS, Y', $one['publish_date']);
    }

    function getBySlug($slug = '')
    {
        $all = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
        return $all[0][$this->pkey];
    }

    function getLink($pvalTable = 0, $oneTable = null)
    {
        global $extLang, $_LANG_ID;
        if (!isset($oneTable['slug'])) {
            $oneTable = $this->getOne($pvalTable, 'slug');
        }
        return $extLang . '/b' . $pvalTable . '-' . $oneTable['slug'] . '.html';
    }

    function getPermalink($blog_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($blog_id, 'permalink');
        return $one['permalink'];
    }

    function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        #
        if (!isset($oneTable['image'])) {
            $oneTable = $this->getOne($pvalTable, 'image');
        }
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            return $clsISO->tripslashImage($image, $w, $h);
        }
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
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
        $noimage = URL_IMAGES . '/noimage.png';
        return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
    }

    function getMetaDescription($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['intro'])) {
            $one = $this->getOne($pvalTable, 'intro');
        }
        return html_entity_decode($one['intro']);
    }

    function getIntro($blog_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['intro'])) {
            $one = $this->getOne($blog_id, 'intro');
        }
        return html_entity_decode($one['intro']);
    }

    function getContent($blog_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['content'])) {
            $one = $this->getOne($blog_id, 'content');
        }
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

    function getLCountryAround($blog_id = 0, $type = '')
    {
        global $_LANG_ID, $dbconn;
        $clsCountry = new Country;
        $clsBlogDestination = new BlogDestination;
        #
        $html = '';

        $SQL01 = "SELECT country_id FROM " . DB_PREFIX . "blog_destination WHERE blog_id='$blog_id' group by country_id";

        $listCountry = $dbconn->GetAll($SQL01);
        if (is_array($listCountry) && count($listCountry) > 0) {
            for ($i = 0; $i < count($listCountry); $i++) {
                $html .= ($i == 0 ? '' : ', ') . '<a class="linkcountry" target="_parent" href="' . $clsCountry->getLink($listCountry[$i]['country_id'], 'Blog') . '" title="' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '">' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '</a>';
            }
            unset($listCountry);
        }
        return $html;
    }

    function countBlogGolobal($country_id = 0, $city_id = 0, $cat_id = 0)
    {
        $where = "is_trash=0 and is_online=1";
        if (intval($country_id) > 0) {
            $where .= " and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id')";
        }
        if (intval($city_id) > 0) {
            $where .= " and blog_id IN (SELECT blog_id FROM " . DB_PREFIX . "blog_destination WHERE city_id='$city_id')";
        }
        if (intval($cat_id) > 0) {
            $where .= " and (cat_id = '" . $cat_id . "' or list_cat_id like '%|" . $cat_id . "|%')";
        }
        $res = $this->getAll($where, $this->pkey);
        return $res ? count($res) : 0;
    }

    function getListTag($blog_id = 0, $one = null)
    {
        global $_LANG_ID;
        #
        $clsTag = new Tag;
        #
        if (!isset($one['list_tag_id'])) {
            $list_tag_id = $this->getOneField('list_tag_id', $blog_id);
        } else {
            $list_tag_id = $one['list_tag_id'];
        }
        if ($list_tag_id != '') {
            $list_tag_id = ltrim($list_tag_id, '|');
            $list_tag_id = rtrim($list_tag_id, '|');
            $list_tag_id = explode('|', $list_tag_id);
            #
            $html = '';
            if (count($list_tag_id) > 0) {
                for ($i = 0; $i < count($list_tag_id); $i++) {
                    $itemTag = $clsTag->getOne($list_tag_id[$i], 'title,slug');
                    if (!empty($list_tag_id[$i])) {
                        $html .= ($i == 1 ? '' : '  ') . '<li class="tag-link"><a target="_parent" href="' . $clsTag->getLinkTagBlog($list_tag_id[$i], $itemTag) . '" title="' . $clsTag->getTitle($list_tag_id[$i], $itemTag) . '">' . $clsTag->getTitle($list_tag_id[$i], $itemTag) . '</a></li>';
                    }
                }
                return $html;
            }
        }
    }

    function getArrayTag($blog_id = 0, $one = null)
    {
        global $_LANG_ID;
        #
        $clsTag = new Tag;
        #
        if (!isset($one['list_tag_id'])) {
            $list_tag_id = $this->getOneField('list_tag_id', $blog_id);
        } else {
            $list_tag_id = $one['list_tag_id'];
        }
        if ($list_tag_id != '') {
            $list_tag_id = ltrim($list_tag_id, '|');
            $list_tag_id = rtrim($list_tag_id, '|');
            $list_tag_id = explode('|', $list_tag_id);
            #
            $array = [];
            if (count($list_tag_id) > 0) {
                for ($i = 0; $i < count($list_tag_id); $i++) {
                    if (!empty($list_tag_id[$i])) {
                        $array[] = $clsTag->getTitle($list_tag_id[$i]);
                    }
                }
                return $array;
            }
        }
    }

    function getImageFromUrl($file = '', $news_id = 0)
    {
        #
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

    function updateImage($blog_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($blog_id, 'updateImage,content');
        if ($one['updateImage'] == 1) {
            return 0;
        }
        $content = $one['content'];
        preg_match_all("/src=&quot;(.*?)&quot;/si", $content, $matches);
        if ($matches[1][0] == '') {
            preg_match_all("/src=\"(.*?)\"/si", $content, $matches);
        }
        $slug = $this->getSlug($blog_id);
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
        $this->updateOne($blog_id, 'content' . "='" . addslashes($content) . "',updateImage='1'");
    }

    function getTag($blog_id = 0)
    {
        $clsTagModule = new TagModule();
        return $clsTagModule->getTag($blog_id, 'BLOG');
    }

    function getStripIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'intro,content');
        if (!empty($one['intro']))
            return strip_tags(html_entity_decode($one['intro']));
        return strip_tags(html_entity_decode($one['content']));
    }

    function getStarRating($blog_id = 0, $one = null)
    {
        global $_LANG_ID, $core;

        if (!isset($one['rate_avg'])) {
            $one = $this->getOne($blog_id, 'rate_avg,rate');
        }
        $total_rate = $one['rate'];
        $rateAVG = $one['rate_avg'];
        $percentRateAVG = ($rateAVG / 5) * 100;

        $html = '
        <div class="star_flex star_blog">
        <div class="star_icon">
            <span class="rating"> 
                <i class="fa fa-star-o star_no_yellow" aria-hidden="true"></i>
                <i class="fa fa-star-o star_no_yellow" aria-hidden="true"></i>
                <i class="fa fa-star-o star_no_yellow" aria-hidden="true"></i>
                <i class="fa fa-star-o star_no_yellow" aria-hidden="true"></i>
                <i class="fa fa-star-o star_no_yellow" aria-hidden="true"></i>
            </span>
            <span class="rating rating_yellow" style="width:' . $percentRateAVG . '%"> 
                <i class="fa fa-star star_yellow" aria-hidden="true"></i>
                <i class="fa fa-star star_yellow" aria-hidden="true"></i>
                <i class="fa fa-star star_yellow" aria-hidden="true"></i>
                <i class="fa fa-star star_yellow" aria-hidden="true"></i>
                <i class="fa fa-star star_yellow" aria-hidden="true"></i>
            </span>
	    </div>';
        if ($total_rate > 0) {
            $html .= '<div class="star_text">| ' . $total_rate . ' ' . $core->get_Lang('voted') . '</div>';
        }
        $html .= '</div>';
        return $html;
    }
  function getCategory($blog_id = 0, $one = null)
    {
        global $_LANG_ID;
        #
        $clsCat = new BlogCategory;
        #
        if (!isset($one['cat_id'])) {
            $cat_id = $this->getOneField('cat_id', $blog_id);
        } else {
            $cat_id = $one['cat_id'];
        }
        $title = '';
        if (!empty($cat_id)) {
            $title = $clsCat->getTitle($cat_id);
        }
        return $title;
    }
    function doDelete($blog_id = 0)
    {

        $clsBlogDestination = new BlogDestination();
        $clsBlogDestination->deleteByCond("blog_id='$blog_id'");

        $clsBlogExtension = new BlogExtension();
        $clsBlogExtension->deleteByCond("blog_id='$blog_id'");
        $this->deleteOne($blog_id);
        return 1;
    }
}
