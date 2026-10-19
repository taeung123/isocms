<?php

class WhyChooseCountry extends dbBasic
{
    function __construct()
    {
        $this->pkey = "why_choose_country_id";
        $this->tbl = DB_PREFIX . "why_choose_country";
    }

    function getTitle($pvalTable = 0, $one = null)
    {
        if (!isset($one['title'])) {
            $one = $this->getOne($pvalTable, 'title');
        }
        return $one['title'] ?? '';
    }

    function getIntro($pvalTable = 0, $one = null)
    {
        if (!isset($one['intro'])) {
            $one = $this->getOne($pvalTable, 'intro');
        }
        return html_entity_decode($one['intro'] ?? '');
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

    function checkExistWhyCountry($country_id = 0)
    {
        $res = $this->getAll("country_id='$country_id' limit 0,1");
        return (!empty($res)) ? 1 : 0;
    }

    function doDelete($pvalTable = 0)
    {
        $this->deleteOne($pvalTable);
        return 1;
    }
}
