<?php

class Property extends dbBasic
{
    function __construct()
    {
        $this->pkey = "property_id";
        $this->tbl = DB_PREFIX . "property";
    }

    function getMaxOrder($type = '')
    {
        $res = $this->getAll("1=1 and type='$type' order by order_no desc");
        return intval($res[0]['order_no']) + 1;
    }

    function getTitle($pval = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['title'])) {
            return $this->getOneField('title', $pval);
        } else {
            return $one['title'];
        }
    }

    function getProperty_code($pval = 0)
    {
        global $_LANG_ID;
        return $this->getOneField('property_code', $pval);
    }

    function getOrder($pval = 0)
    {
        return $this->getOneField('order_no', $pval);
    }

    function getContent($pval = 0)
    {
        global $_LANG_ID;
        return $this->getOneField('content', $pval);
    }

    function getIntro($pval = 0)
    {
        global $_LANG_ID;
        return $this->getOneField('intro', $pval);
    }

    function getBySlug($slug = '', $type = '')
    {
        $res = $this->getAll("is_trash=0 and type='$type' and slug='" . $slug . "'");
        return $res[0]['property_id'];
    }

    function getListType()
    {
        global $_LANG_ID, $core;
        $listType = array();
        $listType['TypeHotel'] = $core->get_Lang('Hotel Type');
        $listType['TagsHotel'] = $core->get_Lang('Tag Hotel');
        $listType['HotelCategory'] = $core->get_Lang('Hotel Category');
        $listType['HotelFacilities'] = $core->get_Lang('Hotel Facilities');
        $listType['TypeRoom'] = $core->get_Lang('Room Type');
        $listType['RoomDirection'] = $core->get_Lang('Room Direction');
        $listType['StatusMeal'] = $core->get_Lang('Meal Status');
        $listType['StatusCancel'] = $core->get_Lang('Cancellation Status');
        $listType['StatusPayment'] = $core->get_Lang('Payment Status');
        $listType['Highlight'] = $core->get_Lang('Highlight Room');
        $listType['RoomFacilities'] = $core->get_Lang('Room Facilities');
        $listType['TypeBed'] = $core->get_Lang('Bed Type');

        return $listType;
    }

    function getTextByType($selected = '')
    {
        $lstType = $this->getListType();
        return $lstType[$selected] ?? '';
    }

    function getSelectByType($selected = '')
    {
        global $core, $core;
        #
        $lstType = $this->getListType();
        $html = '<option value="">Please select</option>';
        foreach ($lstType as $key => $val) {
            $selected_index = ($selected == $key) ? 'selected="selected"' : '';
            $html .= '<option value="' . $key . '" ' . ($key == '_S' ? 'disabled="disabled"' : '') . ' ' . $selected_index . '>' . $val . '</option>';
        }
        return $html;
    }

    function getImage($property_id = 0)
    {
        global $_LANG_ID, $clsISO;
        $one = $this->getOne($property_id, 'image');
        if ($one['image'] != '')
            return $clsISO->tripslashUrl($one['image']);
    }

    function getSelectByProperty($type = '', $selected = '')
    {
        global $core, $core;
        #
        if ($type == 'Unit') {
            $html = '<option value="">' . $core->get_Lang('Unit') . '</option>';
        } else {
            $html = '<option value="">' . $core->get_Lang('Select') . '</option>';
        }
        $all = $this->getAll("is_trash=0 and type='$type' order by order_no desc");

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
        global $core, $core;
        #
        $all = $this->getAll("is_trash=0 and type='star_number' order by order_no desc");
        $html = '<option value="">Lựa chọn</option>';
        if (!empty($all)) {
            $i = 0;
            foreach ($all as $item) {
                $selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>
							' . $this->getOneField('title_vn', $item[$this->pkey]) . '
						</option>';
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
                //$this->makeOption($v[$this->pkey], $type, $selectedid, $level+1, &$arrHtml);
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

    function countItemByType($parent_id = 0, $type = '')
    {
        $res = $this->getAll("parent_id='$parent_id' and type='$type'");
        return !empty($res) ? count($res) : 0;
    }

    function countItem_($cond = '')
    {
        $res = $this->getAll($cond);
        return !empty($res) ? count($res) : 0;
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
        #
        $image = $this->getOneField("image", $pvalTable);
        if (trim($image) != '') {
            if ($clsISO->checkContainer($image, DOMAIN_NAME)) {
                $image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
                $clsISO->deleteFile($image);
                $image = $_SERVER['DOCUMENT_ROOT'] . $clsISO->parseImageURL($image, false);
                $clsISO->deleteFile($image);
            }
        }
        #
        $this->deleteOne($pvalTable);
        return 1;
    }

    function getTitleByCatId($cat_id = 0, $hotel_id = 0, $type = "")
    {
        global $dbconn, $clsISO;
        #
        $clsHotel = new Hotel();
        #
        $content = '';
        $oneHotel = $clsHotel->getOne($hotel_id, "list_HotelAccommodation");
        $lst_comma_accommodation = $this->getArray($oneHotel['list_HotelAccommodation']);
        $sql = "SELECT * FROM `default_property` WHERE cat_id=$cat_id and type='HotelFacilities' and property_id IN (" . implode(",", $lst_comma_accommodation) . ")";
        $list_accommodation  = $dbconn->getAll($sql);
        if ($type == "FE") {
            foreach ($list_accommodation as $item) {
                $content .= ' <div class="item"><img src="' . $item['image'] . '" alt="" onerror="this.src=\'' . URL_IMAGES . '/hotel/detail/circle-check-regular.svg\'"> ' . $item['title'] . '</div>';
            }
            return $content;
        }
        #
        $listPropertyByCatId = $this->getAll("cat_id='$cat_id' and type='HotelFacilities'", "property_id,title,image");
        if ($type == 'FE_2024') {
            foreach ($listPropertyByCatId as $row) {
                if ($clsHotel->checkProperty('HotelAccommodation', $hotel_id, $row["property_id"])) {
                    $content .= '
                        <li class="hnv_hotel_detail_main_facilities_content_item_item">
                            <div class="hnv_hotel_detail_main_facilities_content_item_item_image">
                                <img src="' . $row['image'] . '" width="24" height="24" alt="Facilities image">
                            </div>
                            <span>' . $row['title'] . '</span>
                        </li>
                    ';
                }
            }
            return $content;
        }
        #
        foreach ($listPropertyByCatId as $item) {
            $check = $clsHotel->checkProperty('HotelAccommodation', $hotel_id, $item["property_id"]) ? "checked" : '';
            $content .= '<div class="facilities_item" style="padding-right: 20px"><input type="checkbox" name="list_HotelAccommodation[]" ' . $check . ' value="' . $item["property_id"] . '"> <span class="text">' . $item["title"] . '</span></div>';
        }
        return $content;
    }

    function getArray($string = '')
    {
        if ($string == '' || $string == '|') {
            return array();
        }
        $string = str_replace('||', '|', $string);
        $string = str_replace(',', '|', $string);
        $string = str_replace(':', '|', $string);
        $string = str_replace(';', '|', $string);
        $string = ltrim($string, '|');
        $string = rtrim($string, '|');
        return explode('|', $string);
    }

    function getChild($property_id = 0, $limit = 0, $trash = true)
    {
        $sql = "parent_id='$property_id'";
        if ($trash) {
            $sql .= " and is_trash=0";
        }
        $sql .= " order by order_no ASC";
        if ($limit > 0) {
            $sql .= " LIMIT 0,$limit";
        }
        $res = $this->getAll($sql, $this->pkey);
        return $res;
    }
    function getLstChild($property_id = 0, $level = '---')
    {
        global $core, $mod, $act, $PCMS_URL;
        $sql = "parent_id='$property_id'";
        $sql .= " order by order_no ASC";
        $allItem = $this->getAll($sql, $this->pkey . ',title,is_trash,type');
        $html = '';
        for ($i = 0; $i < count($allItem); $i++) {
            $title = $this->getTitle($allItem[$i]['property_id']);
            $property_id = $allItem[$i]['property_id'];
            $listChild = $this->getChild($property_id, 0, 0);
            $html .= '<tr style="cursor:move" id="order_' . $property_id . '" class="' . ($i % 2 == 0 ? "row1" : "row2") . '">
                <td class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="' . $allItem[$i]['property_id'] . '" /></td>
				<td class="index hiden767">' . ($i + 1) . '</td>
				<td class="name_service">
					<a style="text-decoration:none" title="' . $title . '"><strong style="font-size:14px;">' . $level . $title . '</strong></a>
					' . ($allItem[$i]['is_trash'] == '1' ? '<span class="fr" style="color:#CCC">' . $core->get_Lang("intrash") . '</span>' : "") . '
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
				</td>
				<td class="block_responsive" data-title="' . $core->get_Lang('status') . '">
					<strong>' . $this->getOneField('type', $allItem[$i]['property_id']) . '</strong>
				</td>
				<td class="block_responsive" data-title="' . $core->get_Lang('func') . '" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
						<ul class="dropdown-menu" style="right:0px !important">
							' . ($allItem[$i]['is_trash'] == 0 ? '
							<li><a title="Edit" class="clickToEditProperty" href="javascript:void()" data="' . ($allItem[$i]['property_id']) . '"><i class="icon-edit"></i><span>Edit</span></a></li>
							<li><a title="' . $core->get_Lang('trash') . '" href="' . $PCMS_URL . '/admin/?mod=' . $mod . '&type=' . $allItem[$i]['type'] . '&action=Trash&property_id=' . $core->encryptID($allItem[$i]['property_id']) . '"><i class="icon-trash"></i><span>' . $core->get_Lang('trash') . '</span></a></li>'
                :
                '<li><a title="' . $core->get_Lang('restore') . '" href="' . $PCMS_URL . '/admin/?mod=' . $mod . '&type=' . $allItem[$i]['type'] . '&action=Restore&property_id=' . $core->encryptID($allItem[$i]['property_id']) . '"><i class="icon-refresh"></i><span>' . $core->get_Lang('restore') . '</span></a></li>
							<li><a title="' . $core->get_Lang('delete') . '" class="confirm_delete" href="' . $PCMS_URL . '/admin/?mod=' . $mod . '&type=' . $allItem[$i]['type'] . '&action=Delete&property_id=' . $core->encryptID($allItem[$i]['property_id']) . '"><i class="icon-remove"></i><span>' . $core->get_Lang('delete') . '</span></a></li> ') . '
						</ul>
					</div>
				</td>
			</tr>';
            if (!empty($listChild)) {
                $levelChild = $level . '---';
                $html .= $this->getLstChild($property_id, $levelChild);
            }
        }
        return $html;
    }
}
