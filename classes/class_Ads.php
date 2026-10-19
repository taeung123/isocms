<?php

class Ads extends dbBasic
{

    function __construct()
    {
        $this->pkey = "ads_id";
        $this->tbl = DB_PREFIX . "ads";
    }

    function checkSlug($slug = '')
    {
        $res = $this->getAll("slug='" . $slug . "'");
        if (is_array($res) && count($res) > 0)
            return 0;
        return 1;
    }

    function getBySlug($slug = '')
    {
        $res = $this->getAll("slug='" . $slug . "'");
        return $res[0]['ads_id'];
    }

    function getTitle($ads_id = 0)
    {
        $one = $this->getOne($ads_id, 'title');
        return $one['title'];
    }
    function getMetaDescription($pvalTable = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro']);
    }
    function getIntro($ads_id = 0)
    {
        $one = $this->getOne($ads_id, 'intro');
        return $one['intro'];
    }

    function getSlug($ads_id = 0)
    {
        $one = $this->getOne($ads_id, 'slug');
        return $one['slug'];
    }

    function getLink($ads_id = 0)
    {
        $one = $this->getOne($ads_id, 'url');
        return $one['url'];
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

    function getListGroup($ads_group_id = 0)
    {
        $ads_group_id = '|' . $ads_group_id . '|';
        $listAds = $this->getAll("is_trash=0 and list_id like '%$ads_group_id%'");
        return $listAds;
    }

    function getListGroupLimit($ads_group_id = 0, $limit = '')
    {
        $ads_group_id = '|' . $ads_group_id . '|';
        $listAds = $this->getAll("is_trash=0 and end_date>" . time() . " and list_id like '%$ads_group_id%' limit 0,$limit");
        return $listAds;
    }

    function getListGroupLimitFlash($ads_group_id = 0, $limit = '')
    {
        $ads_group_id = '|' . $ads_group_id . '|';
        $listAds = $this->getAll("is_trash=0 and end_date>" . time() . " and list_id like '%$ads_group_id%' and image like '%.swf%' limit 0,$limit");
        return $listAds;
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

    function checkFlash($ads_id = 0)
    {
        $one = $this->getOne($ads_id);
        if ($this->checkContain($one['image'], '.swf'))
            return 1;
        return 0;
    }

    function checkFlashGroup($ads_group_id = 0)
    {
        $ads_group_id = '|' . $ads_group_id . '|';
        $listAds = $this->getAll("is_trash=0 and list_id like '%$ads_group_id%'");
        if ($listAds[0]['ads_id'] != '') {
            for ($i = 0; $i < count($listAds); $i++) {
                if ($this->checkFlash($listAds[$i]['ads_id']))
                    return 1;
            }
        }
        return 0;
    }

    function checkFlashGroupCat($ads_group_id = 0, $cat_id = 0)
    {
        $ads_group_cat_id = '|c' . $cat_id . 'g' . $ads_group_id . '|';
        $listAds = $this->getAll("is_trash=0 and list_id like '%$ads_group_cat_id%'");
        if ($listAds[0]['ads_id'] != '') {
            for ($i = 0; $i < count($listAds); $i++) {
                if ($this->checkFlash($listAds[$i]['ads_id']))
                    return 1;
            }
        }
        return 0;
    }

    function getListGroupCatLimit($ads_group_id = 0, $cat_id = 0, $limit = '')
    {
        $ads_group_cat_id = '|c' . $cat_id . 'g' . $ads_group_id . '|';
        $listAds = $this->getAll("is_trash=0 and end_date>" . time() . " and list_id like '%$ads_group_cat_id%' limit 0,$limit");
        return $listAds;
    }

    function getListGroupCatLimitFlash($ads_group_id = 0, $cat_id = 0, $limit = '')
    {
        $ads_group_cat_id = '|c' . $cat_id . 'g' . $ads_group_id . '|';
        $listAds = $this->getAll("is_trash=0 and end_date>" . time() . " and list_id like '%$ads_group_cat_id%' and image like '%.swf%' limit 0,$limit");
        return $listAds;
    }

    function doDelete($pvalTable = 0)
    {
        // Delete
        $this->deleteOne($pvalTable);
        return 1;
    }
}
