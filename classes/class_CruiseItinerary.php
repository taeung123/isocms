<?php

class CruiseItinerary extends dbBasic
{
    function __construct()
    {
        $this->pkey = "cruise_itinerary_id";
        $this->tbl = DB_PREFIX . "cruise_itinerary";
    }

    function getItinerary($cruise_id = 0)
    {
        $all = $this->getAll("is_trash=0 and cruise_id='$cruise_id' order by order_no asc");
        return $all;
    }

    function getHighlight($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro']);
    }

    function getWhat_include($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'what_include');
        return html_entity_decode($one['what_include']);
    }

    function getTitle($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'title');
        return $one['title'];
    }

    function getTitleSearch($pvalTable = 0)
    {
        $clsCruise = new Cruise();
        $one = $this->getOne($pvalTable, 'cruise_id');
        return $clsCruise->getTitle($one['cruise_id']);
    }

    function getSlug($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'slug');
        return $one['slug'];
    }

    function getMetaDescription($pvalTable = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($pvalTable, 'content');
        return html_entity_decode($one['content']);
    }

    function getContent($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'content');
        return $one['content'];
    }

    function getCancellation($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'cancellation');
        return html_entity_decode($one['cancellation']);
    }

    function getNumberNight($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'number_night');
        return html_entity_decode($one['number_night']);
    }

    function getWhatInclude($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'what_include');
        return html_entity_decode($one['what_include']);
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

    function getUrlImage($pvalTable = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image");
        $url_image = $oneTable['image'];
        return $clsISO->tripslashUrl($url_image);
    }

    function getLink($cruise_itinerary_id = 0)
    {
        $clsCruise = new Cruise();
        #
        $one = $this->getOne($cruise_itinerary_id, 'cruise_id');
        $cruise_id = $one['cruise_id'];
        return '/' . $clsCruise->getSlug($cruise_id) . '/itinerary/' . $this->getSlug($cruise_itinerary_id) . '.html';
    }

    function getLinkPromotion($pvalTable = 0)
    {
        global $_LANG_ID, $extLang;
        $clsCruise = new Cruise();
        $one = $this->getOne($pvalTable, 'cruise_id,number_day');
        $cruise_id = $one['cruise_id'];
        $number_day = $one['number_day'];
        return $extLang . '/cruise/' . $clsCruise->getSlug($cruise_id) . '/' . $number_day . '-day.html';
    }

    function getSelectTripDuration($selected = '')
    {
        global $core;
        $lstItinerary = $this->getAll("is_trash=0 and cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise WHERE is_trash=0 and is_online=1) order by number_day asc", $this->pkey);
        if (!empty($lstItinerary)) {
            for ($i = 0; $i < count($lstItinerary); $i++) {
                $tmp .= $this->makeSelectTripDuration($lstItinerary[$i][$this->pkey]) . '|';
            }
        }
        $tmp = array_merge(array_unique(explode('|', $tmp)));
        if (!empty($tmp)) {
            foreach ($tmp as $key => $val) {
                if (!empty($val) && $val != 'n/a') {
                    $selected_index = ($selected == $this->convertDurationSearch($val)) ? 'selected="selected"' : '';
                    $html .= '<option value="' . $this->convertDurationSearch($val) . '" ' . $selected_index . '>' . $val . '</option>';
                }
            }
        }
        return $html;
    }

    function getTitleItinerary($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'title_itinerary');
        if (!empty($one['title_itinerary'])) {
            return $one['title_itinerary'];
        }
        return $this->getDuration($pvalTable);
    }

    function getDuration($pvalTable = 0)
    {
        global $core;
        #
        $one = $this->getOne($pvalTable, 'number_day,number_night');
        $number_day = $one['number_day'];
        $number_night = $one['number_night'];
        if (intval($number_day) == 1 && intval($number_night) == 0) {
            return 'Full day';
        }
        if (intval($number_day) == 0 && intval($number_night) == 0) {
            return '';
        }

        $day = $number_day . (intval($number_day) > 1 ? ' ' . $core->get_Lang('days') : ' ' . $core->get_Lang('day'));
        $night = $number_night . (intval($number_night) > 1 ? ' ' . $core->get_Lang('nights') : ' ' . $core->get_Lang('night'));
        return $day . ' / ' . $night;
    }

    function getListDuration($duration = 0, $cruise_itinerary_id = 0, $check_multi = 0, $cruise_id = 0)
    {
        global $core, $_LANG_ID, $dbconn, $clsISO;
        #
        if ($cruise_id > 0) {
            $sql_cruise = " cruise_id = '" . $cruise_id . "'";
        } else {
            $sql_cruise = " cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise WHERE is_trash=0 and is_online=1)";
        }
        $sql = "SELECT number_day,cruise_itinerary_id,title_itinerary, duration_type FROM " . DB_PREFIX . "cruise_itinerary WHERE is_trash=0 and is_online=1 and " . $sql_cruise;
        if ($cruise_itinerary_id > 0) {
            $sql .= " and cruise_itinerary_id = '" . $cruise_itinerary_id . "'";
        }
        $sql .= " order by order_no ASC";

        //print_r($sql);die();
        $lstItinerary = $dbconn->getAll($sql);
        $html = "";
        foreach ($lstItinerary as $key => $value) {
            $number_day = $value['number_day'];
            $number_night = ($number_day > 1) ? $number_day - 1 : 0;
            $val = $number_day;
            $check = $clsISO->checkInArray($duration, $val) ? "checked" : "";
            if ($check_multi == 0) {
                if (intval($number_day) == 1 && intval($number_night) == 0) {
                    $title = $core->get_Lang('Day cruise');
                    $html .= '<li><input id="' . $clsISO->getUniqid() . '" class="typeSearch" name="duration[]" value="' . $val . '" type="checkbox" ' . $check . '>
							<label class="twoFilter" for="' . $clsISO->getUniqid() . '">' . $title . '</label></li>';
                } else if (intval($number_day) == 0 && intval($number_night) == 0) {
                } else {
                    $day = $number_day . (intval($number_day) > 1 ? (' ' . $core->get_Lang('days')) : (' ' . $core->get_Lang('day')));
                    $night = $number_night . (intval($number_night) > 1 ? (' ' . $core->get_Lang('nights')) : (' ' . $core->get_Lang('nights')));
                    $title = $day . ' ' . $night;
                    $html .= '<li><input id="' . $clsISO->getUniqid() . '" class="typeSearch" name="duration[]" value="' . $val . '" type="checkbox" ' . $check . '>
							<label class="twoFilter" for="' . $clsISO->getUniqid() . '">' . $title . '</label></li>';
                }
            } else {
                $check = ($key == 0) ? 'checked' : '';
                //				$check = '';
                if (intval($number_day) == 1 && intval($number_night) == 0) {
                    $title =  !empty($value["title_itinerary"]) ? $value["title_itinerary"] : "1 " . $core->get_Lang('Day');

                    $html .= '<li class="inputLanguage">
								<div class="language">
									<input type="radio" name="cruise_itinerary_id" id="cruise_itinerary_id' . $value['cruise_itinerary_id'] . '" value="' . $value['cruise_itinerary_id'] . '" data-title="' . $title . '" ' . $check . ' data-duration_type=' . $value["duration_type"] . '>
									<label for="cruise_itinerary_id' . $value['cruise_itinerary_id'] . '" class="lbl_langguage">' . $title . '</label>
								</div>
							</li>';
                } else if (intval($number_day) == 0 && intval($number_night) == 0) {
                } else {
                    $day = $number_day . (intval($number_day) > 1 ? (' ' . $core->get_Lang('Days')) : (' ' . $core->get_Lang('Day')));
                    $night = $number_night . (intval($number_night) > 1 ? (' ' . $core->get_Lang('Nights')) : (' ' . $core->get_Lang('Night')));
                    $title = !empty($value["title_itinerary"]) ? $value["title_itinerary"] : $day . ' ' . $night;

                    $html .= '<li class="inputLanguage">
								<div class="language">
									<input type="radio" name="cruise_itinerary_id" id="cruise_itinerary_id' . $value['cruise_itinerary_id'] . '" value="' . $value['cruise_itinerary_id'] . '" data-title="' . $title . '" ' . $check . ' data-duration_type=' . $value["duration_type"] . '>
									<label for="cruise_itinerary_id' . $value['cruise_itinerary_id'] . '" class="lbl_langguage">' . $title . '</label>
								</div>
							</li>';
                }
            }
        }
        return $html;
    }

    function getTitleDay($pvalTable = 0, $one = null)
    {
        global $core;
        #
        $clsCruise = new Cruise();
        if (!isset($one['number_day']) || !isset($one['cruise_id'])) {
            $one = $this->getOne($pvalTable, 'number_day,cruise_id');
        }
        $number_day = $one['number_day'];
        $cruise_id = $one['cruise_id'];
        $day = $number_day . ' ' . (intval($number_day) > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
        return $clsCruise->getTitle($cruise_id) . ' ' . $day;
    }

    function getNumberDay($pvalTable = 0)
    {
        global $core;
        #
        $one = $this->getOne($pvalTable, 'number_day');
        $number_day = $one['number_day'];
        $day = $number_day . ' ' . (intval($number_day) > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
        return $day;
    }

    function getDayNumber($pvalTable = 0)
    {
        global $core;
        #
        $one = $this->getOne($pvalTable, 'number_day');
        $number_day = $one['number_day'];
        $day = $number_day;
        return $day;
    }

    function getTextEndDate($start_date = 0, $pvalTable = 0)
    {
        global $core, $clsISO;
        $one = $this->getOne($pvalTable, 'number_day');
        $num_day = $one['number_day'];
        $end_date = strtotime('+' . ($num_day - 1) . ' day', $start_date);
        return $end_date;
    }

    function checkTransportExist($transport = '', $cruise_itinerary_id = 0)
    {
        $transports = $this->getOneField('transport', $cruise_itinerary_id);
        if ($transports == '' || $transport == '') {
            return 0;
        }
        $tmp = explode(',', $transports);
        if (!in_array($transport, $tmp))
            return 0;
        return 1;
    }

    function makeSelectTripDuration($pvalTable = 0)
    {
        global $_LANG_ID, $core;
        #
        $number_day = intval($this->getOneField('number_day', $pvalTable));
        $number_night = intval($this->getOneField('number_night', $pvalTable));
        if ($number_day == 0 && $number_night == 0)
            return '';
        if ($number_day == 1)
            return $core->get_Lang('Full day');
        #
        $day = $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
        $night = $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
        return $day . ' / ' . $night;
    }

    function makeSelectTripDurationNew($pvalTable = 0)
    {
        global $_LANG_ID, $core;
        #
        $number_day = intval($this->getOneField('number_day', $pvalTable));
        $number_night = intval($this->getOneField('number_night', $pvalTable));
        if ($number_day == 0 && $number_night == 0)
            return '';
        if ($number_day == 1)
            return $core->get_Lang('Full day');
        #
        $day = $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
        $night = $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
        return $day;
    }

    function convertDuration($duration = '')
    {
        global $core;
        if ($duration == $core->get_Lang('Full day')) {
            return '1-0';
        }
        $temp = str_replace(' ', '', $duration);
        $temp = explode('/', $temp);
        $day = intval($temp[0]);
        $night = intval($temp[1]);
        return $day . '-' . $night;
    }

    function convertDurationSearch($duration = '')
    {
        global $core;
        if ($duration == $core->get_Lang('Full day')) {
            return '1';
        }
        $temp = str_replace(' ', '', $duration);
        $temp = explode('/', $temp);
        $day = intval($temp[0]);
        $night = intval($temp[1]);
        return $day;
    }

    function convertTitleDurationSearch($duration = '')
    {
        global $core;
        if ($duration == $core->get_Lang('Full day')) {
            return $core->get_Lang('Full day');
        }
        $temp = str_replace(' ', '', $duration);
        $temp = explode('/', $temp);
        $day = intval($temp[0]);
        $night = intval($temp[1]);
        if ($day == 1) {
            return $day . ' ' . $core->get_Lang('Day');
        } else {
            return $day . ' ' . $core->get_Lang('Days');
        }
    }

    function getAllCityAround($cruise_itinerary_id = 0, $is_image = false, $format = " - ")
    {
        global $_LANG_ID;

        $clsCity = new City;
        $clsGuide = new Guide();
        $clsCruiseDestination = new CruiseDestination;
        $html = '';
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
        //print_r($rsllist);die();
        if (is_array($rsllist) && count($rsllist) > 0) {
            if ($is_image) {
                for ($i = 0; $i < count($rsllist); $i++) {
                    if ($rsllist[$i]['placetogo_id'] > 0) {
                        $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id']) . '" title="' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '">' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '</a>';
                    } else {
                        $html .= ($i == 0 ? '' : ' → ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                    }
                }
                unset($rsllist);
            } else {
                for ($i = 0; $i < count($rsllist); $i++) {
                    if ($rsllist[$i]['placetogo_id'] > 0) {
                        $html .= ($i == 0 ? '' : $format) . $clsGuide->getTitle($rsllist[$i]['placetogo_id']);
                    } else {
                        $html .= ($i == 0 ? '' : $format) . $clsCity->getTitle($rsllist[$i]['city_id']);
                    }
                }

                unset($rsllist);
            }
        }
        return $html;
    }

    function getSelectTripAround($selected = '')
    {
        $clsCity = new City();
        $clsCruiseDestination = new CruiseDestination();
        #
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise WHERE is_trash=0 and is_online=1) order by order_no asc");
        if (!empty($rsllist)) {
            for ($i = 0; $i < count($rsllist); $i++) {
                $tmp .= $rsllist[$i]['city_id'] . '|';
            }
        }
        $tmp = array_merge(array_unique(explode('|', $tmp)));
        if (!empty($tmp)) {
            foreach ($tmp as $key => $val) {
                if (!empty($val) && $val != 'n/a') {
                    $selected_index = ($selected == $val) ? 'selected="selected"' : '';
                    $html .= '<option value="' . $val . '" ' . $selected_index . '>' . $clsCity->getTitle($val) . '</option>';
                }
            }
        }
        return $html;
    }

    function getRadioTripAround($selected = '')
    {
        $clsCity = new City();
        $clsCruiseDestination = new CruiseDestination();
        $html = ''; // Khởi tạo biến $html để lưu mã HTML
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise WHERE is_trash=0 and is_online=1) order by order_no asc");

        if (!empty($rsllist)) {
            $tmp = ''; // Khởi tạo biến tạm
            for ($i = 0; $i < count($rsllist); $i++) {
                $tmp .= $rsllist[$i]['city_id'] . '|';
            }
        }

        $tmp = array_merge(array_unique(explode('|', $tmp)));

        // Lấy giá trị đã chọn từ URL nếu có
        $selectedPlaces = isset($_GET['place']) ? explode(',', $_GET['place']) : [];

        if (!empty($tmp)) {
            foreach ($tmp as $key => $val) {
                if (!empty($val) && $val != 'n/a') {
                    // Kiểm tra xem giá trị hiện tại có nằm trong danh sách $selected không
                    $checked = (in_array($val, $selectedPlaces)) ? 'checked="checked"' : '';
                    $title = $clsCity->getTitle($val);

                    // Tạo đường dẫn với tất cả các giá trị đã chọn
                    $newPlaceArray = $selectedPlaces;
                    if (in_array($val, $newPlaceArray)) {
                        // Nếu đã chọn thì bỏ ra
                        $newPlaceArray = array_diff($newPlaceArray, [$val]);
                    } else {
                        // Nếu chưa chọn thì thêm vào
                        $newPlaceArray[] = $val;
                    }
                    $datalink = "/du-thuyen/du-thuyen-dac-biet/?place=" . implode(',', $newPlaceArray); // Sử dụng implode để tạo URL

                    $html .= '<label>';
                    $html .= '<input type="checkbox" name="place[]" value="' . $val . '" ' . $checked . ' data-link="' . $datalink . '" style="margin-right:16px">';
                    $html .= ' ' . $title;
                    $html .= '</label>';
                }
            }
        }
        return $html;
    }


    function doDelete($cruise_itinerary_id = 0)
    {
        $clsCruiseItineraryDay = new CruiseItineraryDay();
        $clsCruiseSeasonPrice = new CruiseSeasonPrice();
        $clsCruiseDestination = new CruiseDestination();

        $clsCruiseItineraryDay->deleteByCond("cruise_itinerary_id='$cruise_itinerary_id'");
        $clsCruiseSeasonPrice->deleteByCond("cruise_itinerary_id='$cruise_itinerary_id'");
        $clsCruiseDestination->deleteByCond("cruise_itinerary_id='$cruise_itinerary_id'");
        $this->deleteOne($cruise_itinerary_id);
        #
        return 1;
    }

    function checkRoomTypeAvailable($cruise_itinerary_id = 0, $room_type_id = 0, $sesion = '')
    {
        $list_TypeRoom = $this->getOneField($sesion . '_TypeRoom', $cruise_itinerary_id);
        if (trim($list_TypeRoom) != '' && $list_TypeRoom != '0') {
            $tmp = explode('|', $list_TypeRoom);
            if (!in_array($room_type_id, $tmp))
                return 0;
            return 1;
        } else {
            return 0;
        }
    }

    function getTripPrice($pvalTable = 0)
    {
        global $core, $clsISO;
        #
        $one = $this->getOne($pvalTable, 'trip_price');
        $price = $one['trip_price'];
        return $clsISO->formatPrice($price);
    }

    function getDurationCustom($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'duration_custom');
        return $one['duration_custom'];
    }

    function getDurationType($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'duration_type');
        return $one['duration_type'];
    }

    function getLTripPriceItinerary($pvalTable = 0, $now_month = 0, $type = "Default")
    {
        global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID;
        //return $num_day;
        $clsPromotion = new Promotion();
        $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
        if (!empty($lstSeason)) {
            $season = 'high';
        } else {
            $season = 'low';
        }
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_itinerary_id='$pvalTable' and season ='$season'";


        //return $SQL;
        #
        $price = $dbconn->GetOne($SQL);
        $Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Cruise' and cruise_itinerary_id='$pvalTable' and " . time() . " between  start_date and end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);

        if ($type == 'Value') {
            return $price;
        } else {
            if ($price > 0) {
                if ($type == 'Detail') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        if ($_LANG_ID == 'vn') {
                            return '<del> ' . number_format($price, 0, ",", ".") . $clsISO->getShortRate() . '</del> <span>' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</span>';
                        } else {
                            return '<del> ' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</del> <span>' . $clsISO->getShortRate() . number_format($pricePromotion, 0, ",", ".") . '</span>';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return '<span> ' . number_format($price, 0, ",", ".") . $clsISO->getShortRate() . '</span>';
                        } else {
                            return '<span> ' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</span>';
                        }
                    }
                } else {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        if ($_LANG_ID == 'vn') {
                            return '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  ' . number_format($price, 0, ",", ".") . $clsISO->getShortRate() . '</span> <label class="color_fb1111"> ' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</label></span>';
                        } else {
                            return '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  ' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</span> <label class="color_fb1111"> ' . $clsISO->getShortRate() . number_format($pricePromotion, 0, ",", ".") . '</label></span>';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return '<span>' . $core->get_Lang('From') . ' <label class="color_fb1111"> ' . number_format($price, 0, ",", ".") . $clsISO->getShortRate() . '</label></span>';
                        } else {
                            return '<span>' . $core->get_Lang('From') . ' <label class="color_fb1111"> ' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</label></span>';
                        }
                    }
                }
            } else {
                if ($type == 'Detail') {
                    vnSessionSetVar('cruise_itinerary_contact_id', $pvalTable);
                    return '<a class="linkContact" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
                } else {
                }
            }
        }
    }

    function getPricePeopleDepartureDate($cruise_itinerary_id = 0, $cruise_cabin_id = 0, $check_in = 0, $number_adult = 0, $number_child = 0)
    {
        global $core, $clsISO, $clsConfiguration;

        $clsAvailbility = new Availbility();
        $clsProperty = new Property();
        $cond = "type='_CABIN'";
        if (intval($cruise_itinerary_id) > 0) {
            $cond .= " and target_id = '$cruise_itinerary_id'";
        }
        if (intval($cruise_cabin_id) > 0) {
            $cond .= " and cruise_cabin_id = '$cruise_cabin_id'";
        }
        if (intval($check_in) > 0) {
            $cond .= " and check_in = '$check_in'";
        }
        if (intval($number_adult) > 0) {
            $cond .= " and number_adult = '$number_adult'";
        }
        if (intval($number_child) >= 0) {
            $cond .= " and number_child = '$number_child'";
        }
        #
        $res = $clsAvailbility->getAll($cond);
        if (!empty($res) && intval($res[0]['price']) > 0) {
            $price = $res[0]['price'];
            $price = $price;
            if (intval($price) > 0) {
                return $clsISO->formatPrice($price);
            }
        }
        return '';
    }

    function getLocationMap($cruise_itinerary_id = 0)
    {
        global $dbconn;
        $clsCountry = new Country();
        $clsRegion = new Region();
        $clsCity = new City();
        $clsGuide = new Guide();
        $clsCruiseDestination = new CruiseDestination();
        #
        $listCountry = $clsCruiseDestination->getAll("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' order by order_no asc", $clsCruiseDestination->pkey . ',placetogo_id,city_id,region_id,country_id');

        $map_la = '';
        $map_lo = '';
        $jscode = '';
        $location = '';
        if (!empty($listCountry)) {
            foreach ($listCountry as $k => $v) {
                if ($v['placetogo_id'] > 0) {
                    $location .= '["' . ($k + 1) . ' - ' . trim($clsGuide->getTitle($v['placetogo_id'])) . '",' . trim($clsGuide->getMapLa($v['placetogo_id'])) . ',' . trim($clsGuide->getMapLo($v['placetogo_id'])) . ',' . $v['placetogo_id'] . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                    if ($map_la == '' || $map_lo == '') {
                        $map_la = trim($clsGuide->getMapLa($v['placetogo_id']));
                        $map_lo = trim($clsGuide->getMapLo($v['placetogo_id']));
                    }
                } elseif ($v['city_id'] > 0) {
                    $location .= '["' . ($k + 1) . ' - ' . trim($clsCity->getTitle($v['city_id'])) . '",' . trim($clsCity->getMapLa($v['city_id'])) . ',' . trim($clsCity->getMapLo($v['city_id'])) . ',' . $v['city_id'] . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                    if ($map_la == '' || $map_lo == '') {
                        $map_la = trim($clsCity->getMapLa($v['city_id']));
                        $map_lo = trim($clsCity->getMapLo($v['city_id']));
                    }
                } elseif ($v['region_id'] > 0) {
                    $location .= '["' . ($k + 1) . ' - ' . trim($clsRegion->getTitle($v['region_id'])) . '",' . trim($clsRegion->getMapLa($v['region_id'])) . ',' . trim($clsRegion->getMapLo($v['region_id'])) . ',' . $v['region_id'] . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                    if ($map_la == '' || $map_lo == '') {
                        $map_la = trim($clsRegion->getMapLa($v['region_id']));
                        $map_lo = trim($clsRegion->getMapLo($v['region_id']));
                    }
                } else {
                    $location .= '["' . ($k + 1) . ' - ' . trim($clsCountry->getTitle($v['country_id'])) . '",' . trim($clsCountry->getMapLa($v['country_id'])) . ',' . trim($clsCountry->getMapLo($v['country_id'])) . ',' . $v['country_id'] . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                    if ($map_la == '' || $map_lo == '') {
                        $map_la = trim($clsCountry->getMapLa($v['country_id']));
                        $map_lo = trim($clsCountry->getMapLo($v['country_id']));
                    }
                }
            }
            unset($listCountry);
        }


        $jscode = '<script type="text/javascript">
				var locations=[' . $location . '];
			</script>';
        $ret['map_la'] = $map_la;
        $ret['map_lo'] = $map_lo;
        $ret['jscode'] = $jscode;
        return $ret;
    }

    function getListMealItineraryDay($cruise_itinerary_id = 0, $is_symbol = 0)
    {
        global $core, $clsISO, $clsConfiguration;
        $clsCruiseProperty = new CruiseProperty();
        $clsCruiseItineraryDay = new CruiseItineraryDay();
        $lstCruiseItineraryDay = $clsCruiseItineraryDay->getAll("is_trash=0 and cruise_itinerary_id='" . $cruise_itinerary_id . "'", $clsCruiseItineraryDay->pkey . ',meals');
        $arr_meal = [];
        $txt_meal = '';
        foreach ($lstCruiseItineraryDay as $key => $value) {
            if ($value['meals'] != '') {
                $arr_meal = array_merge($arr_meal, explode(",", $value['meals']));
            }
        }
        $arr_meal = array_unique($arr_meal);
        if (count($arr_meal) > 0) {
            $lst_meal = $clsCruiseProperty->getAll("is_trash=0 and type='MEAL' and cruise_property_id IN (" . implode(",", $arr_meal) . ")", $clsCruiseProperty->pkey . ',title, symbol');
            $title = ($is_symbol) ? "symbol" : "title";
            foreach ($lst_meal as $key => $value) {
                $txt_meal .= (($key > 0) ? ", " : "") .  $value[$title];
            }
        }
        return $txt_meal;
    }
}
