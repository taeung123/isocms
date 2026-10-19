<?php
class HotelProperty extends dbBasic
{
    function __construct()
    {
        $this->pkey = "hotel_property_id";
        $this->tbl = DB_PREFIX . "hotel_property";
    }
    function getItem($type = '')
    {
        $res = $this->getAll("is_trash=0 and type='$type' order by order_no ASC");
        return $res;
    }
    function getTitle($pval = 0)
    {
        global $_LANG_ID;
        return $this->getOneField('title', $pval);
    }
    function getIntro($pval = 0)
    {
        global $_LANG_ID;
        return $this->getOneField('intro', $pval);
    }
    function getBySlug($slug = '', $type = '')
    {
        $res = $this->getAll("is_trash=0 and type='$type' and (slug='" . $slug . "')");
        return $res[0]['property_id'];
    }
    function getListType()
    {
        global $core;
        $listType = array();
        $listType['TypeRoom'] = $core->get_Lang('roomtype');
        $listType['RoomFacilities'] = $core->get_Lang('roomfacilities');
        $listType['HotelFacilities'] = $core->get_Lang('hotelfacilities');
        $listType['FreeService'] = $core->get_Lang('roomservice');
        return $listType;
    }
    function getTextByType($selected = '')
    {
        $lstType = $this->getListType();
        return $lstType[$selected];
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

    function getSelectByHotelCat($selected = '')
    {
        global $core;
        #
        $lstType = $this->getAll("type = 'HotelCategory'");
        $html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';

        foreach ($lstType as $key => $val) {
            $selected_index = ($selected == $val["hotel_property_id"]) ? 'selected="selected"' : '';
            $html .= '<option value="' . $val["hotel_property_id"] . '" ' . $selected_index . '>' . $val["title"] . '</option>';
        }
        return $html;
    }

    function getImage($hotel_property_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($hotel_property_id, 'image');
        if ($one['image'] != '')
            return $one['image'];
    }
    function getSelectByProperty($type = '', $selected = '')
    {
        global $core;
        #
        $all = $this->getAll("is_trash=0 and type='$type' order by order_no desc");
        $html = '<option value="">|--- ' . $core->get_Lang('select') . '</option>';
        if (!empty($all)) {
            $i = 0;
            foreach ($all as $item) {
                $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
                ++$i;
            }
        }
        return $html;
    }
    function getSelectStarByProperty($selected = '')
    {
        global $core;
        #
        $all = $this->getAll("is_trash=0 and type='star_number' order by order_no desc");
        $html = '<option value="">' . $core->get_Lang('select') . '</option>';
        if (!empty($all)) {
            $i = 0;
            foreach ($all as $item) {
                $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>
							' . $this->getOneField('title', $item[$this->pkey]) . '
						</option>';
                ++$i;
            }
        }
        return $html;
    }
    function getHotelStarImage($hotel_property_id = 0)
    {
        return $this->getOneField('image', $hotel_property_id);
    }
    function makeOption($cat_id = 0, $type = '', $selectedid = "", $level = 0, &$arrHtml)
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
        $html = '<option value=""> << ' . $core->get_Lang('Select') . ' >> </option>';
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
    function checkPropertyAround($pvalTable = 0, $hotel_property_id = 0)
    {
        $clsHotelRoom = new HotelRoom();
        $oneItem = $clsHotelRoom->getOne($pvalTable);
        $str = $oneItem['list_RoomFacilities'];
        $str_array = explode('|', $str);
        for ($i = 0; $i < count($str_array); $i++) {
            if ($str_array[$i] == $hotel_property_id) {
                return 1;
            }
        }
        return 0;
    }
}
