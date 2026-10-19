<?php
class CruiseProperty extends dbBasic
{
    function __construct()
    {
        $this->pkey = "cruise_property_id";
        $this->tbl = DB_PREFIX . "cruise_property";
        $this->checkColumnIsOnline();
    }

    function checkColumnIsOnline()
    {
        global $dbconn;
        static $is_checked = false;
        if ($is_checked) {
            return;
        }
        $is_checked = true;
        try {
            if (!$this->checkColumnInTable('is_online')) {
                $dbconn->Execute("ALTER TABLE `{$this->tbl}` ADD COLUMN `is_online` tinyint(1) NOT NULL DEFAULT 1");
                $dbconn->Execute("UPDATE `{$this->tbl}` SET `is_online` = 1");
            } else {
                $dbconn->Execute("UPDATE `{$this->tbl}` SET `is_online` = 1 WHERE `is_online` IS NULL");
            }
        } catch (\Throwable $e) {}
    }

    function getIsOnline($pval = 0)
    {
        return $this->getOneField('is_online', $pval);
    }
    function getTitle($pval = 0)
    {
        return $this->getOneField('title', $pval);
    }
    function getOrder($pval = 0)
    {
        return $this->getOneField('order_no', $pval);
    }
    function getContent($pval = 0)
    {
        return $this->getOneField('content', $pval);
    }
    function getIntro($pval = 0)
    {
        return $this->getOneField('intro', $pval);
    }
    function getClassIcon($pval = 0)
    {
        return $this->getOneField('class_icon', $pval);
    }
    function getNumberAdult($pval = 0)
    {
        return $this->getOneField('number_adult', $pval);
    }
    function getNumberChild($pval = 0)
    {
        return $this->getOneField('number_child', $pval);
    }
    function getBySlug($slug = '', $type = '')
    {
        $res = $this->getAll("is_trash=0 and type='$type' and slug='$slug'");
        return $res[0]['cruise_property_id'];
    }
    function getSymbol($tour_property_id = 0)
    {
        $one = $this->getOne($tour_property_id, 'symbol');
        return $one['symbol'];
    }
    function getListType()
    {
        global $core;
        $listType = array();
        $listType['CruiseFacilities'] = $core->get_Lang('Cruise Facilities');
        $listType['CabinFacilities'] = $core->get_Lang('Cabin Facilities');
        $listType['CruiseServices'] = $core->get_Lang('Cruise Services');
        $listType['CruiseFaActivities'] = $core->get_Lang('Activities on Board');
        $listType['TravelAs'] = $core->get_Lang('Great for groups');
        $listType['GroupSize'] = $core->get_Lang('Group size');
        $listType['HighLow'] = $core->get_Lang('High/Low season');
        $listType['CruiseMaterial'] = $core->get_Lang('Cruise Material');
        $listType['MEAL'] = $core->get_Lang('Meal');
        return $listType;
    }
    function getTextByType($selected = '')
    {
        $lstType = $this->getListType();
        if (isset($lstType[$selected])) {
            return $lstType[$selected];
        }
        global $core;
        return $core->get_Lang($selected);
    }
    function getSelectByType($selected = '')
    {
        global $core;
        #
        $lstType = $this->getListType();
        $html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';
        foreach ($lstType as $key => $val) {
            $selected_index = ($selected == $key) ? 'selected="selected"' : '';
            $html .= '<option value="' . $key . '" ' . $selected_index . '>' . $val . '</option>';
        }
        return $html;
    }
    function getImage($pval = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pval, 'image');
        if ($one['image'] != '')
            return $one['image'];
    }
    function getSelectByProperty($type = '', $selected = '', $is_multi = 0)
    {
        global $core, $clsISO;
        #
        $all = $this->getAll("is_trash=0 and type='$type' order by order_no asc");

        if (!empty($all)) {
            $i = 0;
            foreach ($all as $item) {
                if (!empty($is_multi)) {
                    $selected_index = ($clsISO->checkContainer($selected, $item[$this->pkey])) ? 'selected="selected"' : '';
                } else {
                    $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                }
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
                ++$i;
            }
        }
        return $html;
    }
    function getSelectByProperty2($type = '', $selected = '', $is_multi = 0, $cruise_type = 0)
    {
        global $core, $clsISO;
        #
        $all = $this->getAll("is_trash=0 and type='$type' order by order_no asc");
        $html = '';
        if (!empty($all)) {
            $i = 0;
            foreach ($all as $item) {
                if (!empty($is_multi)) {
                    $selected_index = ($clsISO->checkContainer($selected, $item[$this->pkey])) ? 'selected="selected"' : '';
                } else {
                    $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                }
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
                ++$i;
            }
        }
        return $html;
    }
    function makeOption($cat_id = 0, $type = '', $selectedid = "", $level = 0, &$arrHtml = [])
    {
        global $dbconn;
        $cond = "is_trash=0 and parent_id='" . $cat_id . "'";
        if ($type != '') {
            $cond .= " and type='$type'";
        }
        $arrListCat = $this->getAll($cond);
        if (is_array($arrListCat)) {
            foreach ($arrListCat as $k => $v) {
                $selected = ($v[$this->pkey] == $selectedid) ? "selected" : "";
                $value = $v[$this->pkey];
                $option = str_repeat("|---- ", $level) . $this->getTitle($v[$this->pkey]);
                $arrHtml[$value] = $option;
                $this->makeOption($v[$this->pkey], $type, $selectedid, $level + 1, $arrHtml);
            }
            return "";
        } else {
            return "";
        }
    }
    function getListOption($selected = '')
    {
        global $core;
        #
        $arrOptionsCategory = array();
        $this->makeOption(0, "", "", 0, $arrOptionsCategory);
        $html = '<option value=""> << ' . $core->get_Lang('select') . ' >> </option>';
        foreach ($arrOptionsCategory as $k => $v) {
            $selected_index = ($k == $selected) ? 'selected="selected"' : '';
            $oneItem = $this->getOne($k);
            $html .= '<option value="' . $k . '" ' . $selected_index . '>' . $v . '</option>';
        }
        return $html;
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
    function doDelete($pvalTable = 0)
    {
        $clsISO = new ISO();
        $type = $this->getOneField('type', $pvalTable);
        if ($type == 'GroupSize') {
            $clsCruiseSeasonPrice = new CruiseSeasonPrice();
            $clsCruiseSeasonPrice->deleteByCond("group_size_id='$pvalTable'");
        }

        #
        $this->deleteOne($pvalTable);
        return 1;
    }
}
