<?php

class AdsGroup extends dbBasic
{

    function __construct()
    {
        global $_LANG_ID;
        $this->pkey = "ads_group_id";
        $this->tbl = DB_PREFIX . "ads_group";
    }

    function getTitle($pval = 0)
    {
        $one = $this->getOne($pval, 'title');
        return $one['title'];
    }

    function getMetaDescription($pvalTable = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro']);
    }

    function getIntro($pval = 0)
    {
        $one = $this->getOne($pval, 'intro');
        return $one['intro'];
    }

    function getSize($pval = 0)
    {
        $one = $this->getOne($pval);
        return $one['_width'] . 'x' . $one['_height'];
    }

    function makeSelectOption($selected = "")
    {
        global $core;
        $lstItem = $this->getAll("is_trash=0 and parent_id='0' order by order_no ASC");
        $html = '<option value="0">-- ' . $core->get_Lang('select') . ' --</option>';
        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $html .= '<option value="' . $item[$this->pkey] . '" ' . ($item[$this->pkey] == $selected ? 'selected="selected"' : '') . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function getChild($ads_group_id = 0)
    {
        $res = $this->getAll("is_trash=0 and parent_id='$ads_group_id' order by order_no DESC");
        return $res;
    }

    function checkAds($ads_group_id = 0, $ads_id = 0)
    {
        $clsAds = new Ads();
        #
        $one = $clsAds->getOne($ads_id, 'list_id');
        $list_id = $one['list_id'];
        if ($ads_group_id == '' || $list_id == '') {
            return 0;
        }
        #
        $pos = strpos($list_id, '|' . $ads_group_id . '|');
        if ($pos === false) {
            return 0;
        } else {
            return 1;
        }
    }
}
