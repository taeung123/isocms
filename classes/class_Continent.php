<?php
class Continent extends dbBasic
{
    function __construct()
    {
        $this->pkey = "continent_id";
        $this->tbl = DB_PREFIX . "continent";
    }
    function getTitle($country_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($country_id, 'title');
        return $one['title'] ?? '';
    }
    function getSlug($country_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($country_id, 'slug');
        return $one['slug'] ?? '';
    }
    function getIntro($country_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($country_id, 'intro');
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
    function getLink($continent_id = 0)
    {
        global $extLang;
        return $extLang . '/' . $this->getSlug($continent_id) . '/';
    }
    function getListCountry($cat_id = 0, $limit = '')
    {
        $limit = !empty($limit) ? 'limit ' . $limit : '';
        $res = $this->getAll("is_trash=0 and is_online=1 and cat_id = '$cat_id' order by order_no asc " . $limit, $this->pkey);
        return !empty($res) ? $res : '';
    }
    function makeSelectboxOption($continent_id = 0)
    {
        global $core, $_LANG_ID, $dbconn;
        #
        $sql = "is_trash=0 and is_online=1";
        $res = $this->GetAll($sql . " ORDER BY order_no ASC");
        $html = '<option value="0"> -- ' . $core->get_Lang('Continent') . ' -- </option>';
        if (!empty($res)) {
            foreach ($res as $k => $v) {
                $html .= '<option value="' . $v[$this->pkey] . '" ' . ($v[$this->pkey] == $continent_id ? ' selected="selected"' : '') . '>' . $this->getTitle($v[$this->pkey]) . '</option>';
            }
            unset($res);
        }
        return $html;
    }
    function getOptCountryByContinent($continent_id = "", $country_id = 0)
    {
        global $core, $_LANG_ID, $dbconn;
        #
        $clsCountry = new Country();
        $cond = "is_trash=0 and is_online=1";
        if (intval($continent_id) > 0) {
            $cond .= " and continent_id='$continent_id'";
        }
        $order_by = " order by order_no ASC";
        $res = $clsCountry->getAll($cond . $order_by, $clsCountry->pkey);
        $html = '<option value="0">-- ' . $core->get_Lang('selectcountry') . ' --</option>';
        if (is_array($res) && count($res) > 0) {
            foreach ($res as $k => $v) {
                $html .= '<option value="' . $v[$clsCountry->pkey] . '" ' . ($country_id == $v[$clsCountry->pkey] ? 'selected="selected"' : '') . '>|---' . $clsCountry->getTitle($v[$clsCountry->pkey]) . '</option>';
            }
            unset($res);
        }
        return $html;
    }
    function getSelectByCountry($selected = '', $is_prefix = true)
    {
        global $core;
        #
        $all = $this->getAll("is_trash=0 and country_id<>'9' order by order_no asc", $this->pkey);
        $html = !$is_prefix ? '' : '<option value="0">-- ' . $core->get_Lang('select') . ' --</option>';
        if (!empty($all)) {
            foreach ($all as $item) {
                $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }
    function countCountryInCat($continent_id = 0)
    {
        $clsCountry = new Country();
        return $clsCountry->countItem("is_trash=0 and continent_id = '$continent_id'");
    }
    function doDelete($continent_id = 0)
    {
        // Delete
        $clsCountry = new Country();
        $lstCountry = $clsCountry->getAll("continent_id='$continent_id'");
        if (is_array($lstCountry) && count($lstCountry) > 0) {
            for ($i = 0; $i < count($lstCountry); $i++) {
                $clsCountry->doDelete($lstCountry[$i][$clsCountry->pkey]);
            }
        }
        // Delete
        $this->deleteOne($continent_id);
        return 1;
    }
}
