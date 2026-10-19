<?php
class TailorProperty extends dbBasic
{
    function __construct()
    {
        $this->pkey = "tailor_property_id";
        $this->tbl = DB_PREFIX . "tailor_property";
    }
    function getTitle($pvalTable = 0, $one = null)
    {
        if (!isset($one['title'])) {
            $one = $this->getOne($pvalTable);
        }
        return $one['title'] ?? '';
    }
    function getListType()
    {
        global $core;
        #
        $listType = array();
        $listType['_TRANSPORT'] = $core->get_Lang('Transport');
        $listType['_LANGUAGE'] = $core->get_Lang('Language');
        $listType['_BREAKFAST'] = $core->get_Lang('Breakfast');
        $listType['_LUNCH'] = $core->get_Lang('Lunch');
        $listType['_DINNER'] = $core->get_Lang('Dinner');
        $listType['_HOTEL_CLASS'] = $core->get_Lang('Hotel Class');
        //$listType['_ROOM_CLASS'] = $core->get_Lang('Room Class');
        //$listType['_DURATION'] = $core->get_Lang('Duration');
        return $listType;
    }
    function getTextByType($selected = '')
    {
        $lstType = $this->getListType();
        return $lstType[$selected] ?? '';
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
    function getSelectByProperty($type = '', $selected = '')
    {
        global $core;
        #
        $all = $this->getAll("is_trash=0 and type='$type' order by order_no ASC", $this->pkey . ',title');

        if ($type == '_BREAKFAST') {
            $html = '<option value="">-- ' . $core->get_Lang('Breakfast') . ' --</option>';
        } else if ($type == '_LUNCH') {
            $html = '<option value="">-- ' . $core->get_Lang('Lunch') . ' --</option>';
        } else if ($type == '_DINNER') {
            $html = '<option value="">-- ' . $core->get_Lang('Dinner') . ' --</option>';
        } else {
            $html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';
        }
        if (!empty($all)) {
            $i = 0;
            foreach ($all as $item) {
                $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($item[$this->pkey], $item) . '</option>';
                ++$i;
            }
        }
        return $html;
    }
    function getListByProperty($type = '')
    {
        global $core;
        #
        $res = $this->getAll("is_trash=0 and type='$type' order by order_no ASC", $this->pkey . ',title');
        return !empty($res) ? $res : '';
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
    function checkPropertyAround($pvalTable = 0, $property_id = 0)
    {
        $clsHotelRoom = new HotelRoom();
        $oneItem = $clsHotelRoom->getOne($pvalTable);
        $str = $oneItem['list_RoomFacilities'];
        $str_array = explode('|', $str);
        for ($i = 0; $i < count($str_array); $i++) {
            if ($str_array[$i] == $property_id) {
                return 1;
            }
        }
        return 0;
    }
}
