<?php
class Combo extends dbBasic
{
	function __construct()
	{
		$this->pkey = "combo_id";
		$this->tbl = DB_PREFIX . "combo";
	}
	function getTitle($combo_id = 0)
	{
		$one = $this->getOne($combo_id, 'title');
		return $one['title'];
	}
	function getCode($combo_id = 0)
	{
		$one = $this->getOne($combo_id, 'code');
		return $one['code'];
	}
	function checkOnlineBySlug($combo_id = 0, $slug = '')
	{
		$item = $this->getAll("is_trash=0 and is_online=1 and combo_id='$combo_id' and slug='$slug'");
		if (empty($item))
			return 0;
		return 1;
	}
	function getSlug($combo_id = 0)
	{
		$one = $this->getOne($combo_id, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$all = $this->getAll("is_trash=0 and is_online=1 and slug='$slug' limit 0,1", $this->pkey);
		return $all[0][$this->pkey];
	}
	function checkExitsId($combo_id = 0)
	{
		$res = $this->getAll("combo_id = '$combo_id' LIMIT 0,1");
		return !empty($res) ? 1 : 0;
	}
	function getLink($pvalTable = 0)
	{
		global $extLang, $_LANG_ID;
		return $extLang . '/co' . $pvalTable . '-' . $this->getSlug($pvalTable) . '.html';
	}
	function getLinkPro($combo_id = 0, $type = '')
	{
		#new way
		return $this->getLink($combo_id, $type);
		#old way
		global $extLang, $_LANG_ID;
		switch ($type) {
			case 'Photo':
				return ($_LANG_ID == 'vn') ? '/khach-san-pro/' : $extLang . '/hotelpro/' . $this->getSlug($combo_id) . '-h' . $combo_id . '/photos/#galleryID';
				break;
			default:
				return ($_LANG_ID == 'vn') ? '/khach-san-pro/' : $extLang . '/hotelpro/' . $this->getSlug($combo_id) . '-h' . $combo_id . '.html';
		}
	}
	function getLinkBook($combo_id = 0)
	{
		global $_LANG_ID, $extLang;
		if ($_LANG_ID == 'vn')
			return $extLang . '/khach-san/' . $this->getSlug($combo_id) . '/booking.html';
		return $extLang . '/hotels/' . $this->getSlug($combo_id) . '/booking.html';
	}
	function getMapLink($pvalTable = 0)
	{
		$oneItem = $this->getOne($pvalTable, 'map_la,map_lo');
		if ($oneItem['map_la'] != '') {
			return 'http://maps.google.com/maps?q=' . $this->getTitle($pvalTable) . ' ' . strip_tags($this->getAddress($pvalTable)) . '&spn=' . $oneItem['map_lo'] . ',' . $oneItem['map_la'] . '&hl=vi';
		}
		return 'http://maps.google.com/maps?q=' . $this->getTitle($pvalTable) . ' ' . strip_tags($this->getAddress($pvalTable)) . '&spn=' . $oneItem['map_lo'] . ',' . $oneItem['map_la'] . '&hl=en';
		return $this->getLink($pvalTable) . '#map';
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'highlight');
		return html_entity_decode($one['highlight']);
	}
	function getIntro($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getHighlight($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'highlight');
		return html_entity_decode($one['highlight']);
	}
	function getContent($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'content');
		return html_entity_decode($one['content']);
	}
	function getTtinerary($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'itinerary');
		return html_entity_decode($one['itinerary']);
	}
	function getInclusion($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'inclusion');
		return html_entity_decode($one['inclusion']);
	}
	function getStripIntro($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'highlight,itinerary');
		if (!empty($one['highlight']))
			return strip_tags(html_entity_decode($one['highlight']));
		return strip_tags(html_entity_decode($one['itinerary']));
	}
	function getCountryHotel($combo_id = 0)
	{
		$clsCountryEx = new Country();
		$one = $this->getOne($combo_id, 'country_id');
		return $clsCountryEx->getTitle($one['country_id']);
	}
	function getCityHotel($combo_id = 0)
	{
		$clsCity = new City();
		$one = $this->getOne($combo_id, 'city_id');
		return $clsCity->getTitle($one['city_id']);
	}
	function getHotelStyles($combo_id = 0)
	{
		$clsHotelProperty = new HotelProperty();
		$one = $this->getOne($combo_id, 'hotel_rating');
		return $clsHotelProperty->getTitle($one['hotel_rating']);
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
	function getImageStar($star_id = 0)
	{
		if ($star_id == 0)
			return '';
		return URL_IMAGES . '/star/find-00' . $star_id . '-star.png';
	}
	function getHotelStar($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'star_id');
		$star_id = $one['star_id'];
		if (!empty($star_id)) {
			return URL_IMAGES . '/star/find-00' . $star_id . '-star.png';
		}
	}
	function getStar($combo_id = 0)
	{
		$one = $this->getOne($combo_id, 'star_id');
		return $one['star_id'];
	}
	function getTripDuration2019($tour_id = 0, $paid = '/')
	{
		global $_LANG_ID, $core, $_lang;
		$one = $this->getOne($tour_id, 'number_day,number_night');
		$number_day = intval($one['number_day']);
		$number_night = intval($one['number_night']);
		if ($number_day == 1 && $number_night == 0) {
			return $core->get_Lang('Full day');
		} else {
			if ($number_night == 0) {
				$number_night = $number_day - 1;
			}
			#
			$str = '';
			$str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
			if ($paid != '') {
				$str .= ' ' . $paid . ' ';
			} else {
				$str .= ' ';
			}
			$str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
			return $str;
		}
	}
	function getLCityAround2($combo_id = 0, $type = '')
	{
		global $_LANG_ID;
		$clsCity = new City;
		$clsCountry = new Country;
		$clsComboDestination = new ComboDestination;
		#
		$html = '';
		$rsllist = $clsComboDestination->getAll("is_trash=0 and combo_id='$combo_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
		if (is_array($rsllist) && count($rsllist) > 0) {
			for ($i = 0; $i < count($rsllist); $i++) {
				if ($rsllist[$i]['city_id'] > 0) {
					$html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
				} else {
					$html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsCountry->getLink($rsllist[$i]['country_id']) . '" title="' . $clsCountry->getTitle($rsllist[$i]['country_id']) . '">' . $clsCountry->getTitle($rsllist[$i]['country_id']) . '</a>';
				}
			}
			unset($rsllist);
		}
		return $html;
	}
	function getLocationMap($combo_id = 0)
	{
		global $dbconn;
		$clsHotel = new Hotel();

		#
		$list_hotel = $this->getOneField('list_hotel', $combo_id);
		$list_hotel = !empty($list_hotel) ? json_decode($list_hotel, true) : array();
		//print_r($listCountry); die();
		$map_la = '';
		$map_lo = '';
		$jscode = '';
		$location = '';
		if (!empty($list_hotel)) {
			$i = 0;
			foreach ($list_hotel as $k => $v) {
				$location .= '["' . ($k + 1) . ' - ' . trim($clsHotel->getTitle($k)) . '",' . trim($clsHotel->getMapLa($k)) . ',' . trim($clsHotel->getMapLo($k)) . ',' . ($i + 1) . ']';
				$location .= ($k == count($list_hotel) - 1) ? '' : ',';
				if ($map_la == '' || $map_lo == '') {
					$map_la = trim($clsHotel->getMapLa($k));
					$map_lo = trim($clsHotel->getMapLo($k));
				}
				$i++;
			}
			unset($list_hotel);
		}
		$jscode = '<script type="text/javascript">
			var locations=[' . $location . '];
		</script>';
		//print_r($jscode); die();
		$ret['map_la'] = $map_la;
		$ret['map_lo'] = $map_lo;
		$ret['jscode'] = $jscode;
		//print_r($ret); die();
		return $ret;
	}
	function getNote($combo_id = 0)
	{
		$one = $this->getOne($combo_id, "note");
		return html_entity_decode($one['note']);
	}
	function getApplyConditions($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'condition_apply');
		return html_entity_decode($one['condition_apply']);
	}
	function getHotelBookingPolicy($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'hotel_booking_policy');
		return html_entity_decode($one['hotel_booking_policy']);
	}
	function getPrice($combo_id = 0, $addition = '', $is_has = false)
	{
		global $core, $extLang, $_LANG_ID;
		#
		$clsISO = new ISO();
		$one = $this->getOne($combo_id, 'price_avg');
		$price = $one['price_avg'];
		#
		if (!empty($price) && $price > 0) {
			if ($is_has) {
				if (!empty($addition)) {
					switch ($addition) {
						case '/night':
							return '<strong>' . $clsISO->getRate() . ' ' . $clsISO->formatNumberToEasyRead($one['price_avg']) . '</strong> / night';
							break;
						default:
							return '';
					}
				}
			} else {
				if ($_LANG_ID == 'vn')
					return $clsISO->formatNumberToEasyRead($one['price_avg']) . ' ' . $clsISO->getRate();
				return $clsISO->getRate() . ' ' . $clsISO->formatNumberToEasyRead($one['price_avg']);
			}
		} else {
			$link = '<a class="contactLink size16" title="' . $core->get_Lang('Contact us') . '" href="' . $clsISO->getLink('contact') . '" target="_blank">' . $core->get_Lang('Contact us') . '</a>';
			return $link;
		}
		return $price;
	}
	function getPriceExport($combo_id = 0, $addition = '', $is_has = false)
	{
		global $core, $extLang;
		#
		$clsISO = new ISO();
		$one = $this->getOne($combo_id, 'price_avg');
		$price = $one['price_avg'];
		#
		if (!empty($price) && $price > 0) {
			if ($is_has) {
				if (!empty($addition)) {
					switch ($addition) {
						case '/night':
							return 'USD ' . $clsISO->formatNumberToEasyRead($one['price_avg']) . ' / night';
							break;
						default:
							return '';
					}
				}
			} else {
				return 'USD ' . $clsISO->formatNumberToEasyRead($one['price_avg']);
			}
		} else {
			$link = 'Contact us';
			return $link;
		}
		return $price;
	}
	function getPriceAvg($combo_id = 0)
	{
		global $core, $_LANG_ID;
		$one = $this->getOne($combo_id, 'price_avg');
		return $one['price_avg'];
	}
	function getPriceAvg1($combo_id = 0)
	{
		global $core, $_LANG_ID, $clsISO, $clsConfiguration;
		$clsProperty = new Property();
		$assign_list['clsProperty'] = $clsProperty;
		$one = $this->getOne($combo_id, 'price_avg');
		$price = $one['price_avg'];
		if (intval($price) > 0) {
			return $clsISO->formatPrice($price, 3);
		}
	}
	function getPriceAvg2($combo_id = 0)
	{
		global $core, $_LANG_ID, $clsISO, $clsConfiguration;
		$clsProperty = new Property();
		$assign_list['clsProperty'] = $clsProperty;
		$one = $this->getOne($combo_id, 'price_avg');
		$price = $one['price_avg'];
		if (intval($price) > 0) {
			return $clsISO->formatPrice($price, 3) . '<p>' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' / ' . $core->get_Lang('nights') . '</p>';
		}
	}
	function getTripPrice($pvalTable = 0)
	{
		global $core, $clsISO, $clsConfiguration;
		$clsProperty = new Property();
		$assign_list['clsProperty'] = $clsProperty;
		#
		$one = $this->getOne($pvalTable, 'price,is_booking,is_sendrequest,is_getprice');
		$price = $one['price'];
		$is_booking = $one['is_booking'];
		$is_sendrequest = $one['is_sendrequest'];
		$is_getprice = $one['is_getprice'];
		if (intval($price) > 0 && $is_booking == 1) {
			return $clsISO->formatPrice($price, 3) . '<p>' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' / ' . $core->get_Lang('nights') . '</p>';
		} elseif (intval($price) >= 0 && $is_sendrequest == 1) {
			return '<a class="contactLink" href="' . $clsISO->getLink('feedback') . '">' . $core->get_Lang('Gửi yêu cầu') . '</a>';
		} elseif (intval($price) >= 0 && $is_getprice == 1) {
			return '<a class="contactLink" href="' . $clsISO->getLink('feedback') . '">' . $core->get_Lang('Click để lấy giá') . '</a>';
		} else {
			return '<a class="contactLink" href="' . $clsISO->getLink('feedback') . '">' . $core->get_Lang('Liên hệ để lấy giá tốt') . '</a>';
		}
	}
	function getPriceAvgAdmin($combo_id = 0)
	{
		global $core, $_LANG_ID, $clsConfiguration;
		$clsProperty = new Property();
		$one = $this->getOne($combo_id, 'price_avg');
		$price = $one['price_avg'];
		if ($price > 0) {
			if ($_LANG_ID == 'vn') {
				return $one['price_avg'] . ' ' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency'));
			} else {
				return $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $one['price_avg'];
			}
		} else {
			return '<a class="contactLink" title="' . $core->get_Lang('Contact us') . '" href="' . DOMAIN_NAME . $extLang . '/lien-he.html" target="_blank">' . $core->get_Lang('Contact us') . '</a>';
		}
	}
	function getPriceHotelRoom($combo_id = 0, $hotel_id = 0, $hotel_room_id = 0)
	{
		global $core, $_LANG_ID;
		$info_price_table = $this->getOneField('info_price_table', $combo_id);
		$info_price_table = !empty($info_price_table) ? json_decode($info_price_table, true) : array();
		$price = $info_price_table[$hotel_id][$hotel_room_id]['price'];
		return $price ? $price : 0;
	}
	function getListRoomCheck($combo_id = 0, $hotel_id = 0)
	{
		global $core, $_LANG_ID;
		$info_price_table = $this->getOneField('info_price_table', $combo_id);
		$info_price_table = !empty($info_price_table) ? json_decode($info_price_table, true) : array();
		$list_hotel_room = $info_price_table[$hotel_id];
		$list_hotel_room_id = array_keys($list_hotel_room);
		return $list_hotel_room_id;
	}
	function checkListHotelRoomCheck($combo_id = 0, $hotel_id = 0)
	{
		global $core, $_LANG_ID;
		$clsHotelRoom = new HotelRoom();
		$listRoom = $clsHotelRoom->getAll("is_trash=0 and hotel_id='$hotel_id' order by order_no asc", $clsHotelRoom->pkey);
		$info_price_table = $this->getOneField('info_price_table', $combo_id);
		$info_price_table = !empty($info_price_table) ? json_decode($info_price_table, true) : array();
		$list_hotel_room = $info_price_table[$hotel_id];
		$total_room_check = count($list_hotel_room);
		$total_room = $listRoom ? count($listRoom) : 0;
		if ($total_room_check == $total_room) {
			return 1;
		}
		return 0;
	}
	function getAddress($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'address');
		return $one['address'];
	}
	function getPhone($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'phone');
		return $one['phone'];
	}
	function getWebsite($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'website');
		return $one['website'];
	}
	function getMaxAdult($pvalTable = 0)
	{
		global $core, $_LANG_ID;
		$clsHotelRoom = new HotelRoom();
		$lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and combo_id='$pvalTable' order by number_adult desc");
		return $lstHotelRoom[0]['number_adult'];
	}
	function getMaxChild($pvalTable = 0)
	{
		global $core, $_LANG_ID;
		$clsHotelRoom = new HotelRoom();
		$lstHotelRoom = $clsHotelRoom->getAll("is_trash=0 and combo_id='$pvalTable' order by number_child desc");
		return $lstHotelRoom[0]['number_child'];
	}
	function checkProperty($type = '', $pvalTable = 0, $property_id = 0)
	{
		$oneItem = $this->getOne($pvalTable);
		$str = $oneItem['list_' . $type];
		$str_array = explode('|', $str);
		for ($i = 0; $i < count($str_array); $i++) {
			if ($str_array[$i] == $property_id) {
				return 1;
			}
		}
		return 0;
	}
	function checkAttraction($pvalTable = 0, $hotel_attraction_id = 0)
	{
		$oneItem = $this->getOne($pvalTable, 'list_attraction');
		$str = $oneItem['list_attraction'];
		$str_array = explode('|', $str);
		for ($i = 0; $i < count($str_array); $i++) {
			if ($str_array[$i] == $hotel_attraction_id) {
				return 1;
			}
		}
		return 0;
	}
	function getHotelById($combo_id = 0, $limit = '')
	{
		$clsHotel = new Hotel();
		$all = $clsHotel->getAll('is_trash=0 limit 0,' . $limit);
		return $all;
	}
	function getHotelFaci($combo_id = 0)
	{
		$clsHotel = new Hotel();
		$one = $clsHotel->getOne($combo_id, 'list_HotelFacilities');
		return $one['list_HotelFacilities'];
	}
	function getListHotelFacility($combo_id = 0)
	{
		$one = $this->getOne($combo_id, 'list_HotelFacilities');
		$list_HotelFacilities = $one['list_HotelFacilities'];
		if ($list_HotelFacilities != '') {
			$list_HotelFacilities = ltrim($list_HotelFacilities, '|');
			$_array = explode('|', $list_HotelFacilities);
			return $_array;
		}
		return '';
	}
	function getLocation($combo_id = 0)
	{
		$clsCountry =  new Country();
		$clsCity =  new City();
		$one = $this->getOne($combo_id);
		return  $html = $clsCity->getTitle($one['city_id'])  . ", " .  $clsCountry->getTitle($one['country_id']);
	}
	function getRoomFaci($combo_id = 0)
	{
		$clsHotel = new Hotel();
		$one = $clsHotel->getOne($combo_id, 'list_RoomFacilities');
		return $one['list_RoomFacilities'];
	}
	function getRuler($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'check_in_out_rule');
		return html_entity_decode($one['check_in_out_rule']);
	}
	function getUrlVideo($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'video_url');
		return html_entity_decode($one['video_url']);
	}
	function getDiscount($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'discount_text');
		return html_entity_decode($one['discount_text']);
	}
	function getPermalink($combo_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($combo_id, 'permalink,slug');
		if ($one['permalink'] == '')
			return $one['slug'];
		return $one['permalink'];
	}
	function getListTypeAddInformation()
	{
		$_array = array();
		$_array['_NEAR'] = 'Hotel Near by';
		$_array['_ROOM'] = 'Hotel Room Types';
		$_array['_BUSINESS'] = 'Business funtions Meeting Rooms';
		$_array['_FOOD'] = 'Food, Beaverage & Entertaiment';
		$_array['_POLICIES'] = 'Hotel Policies';
		return $_array;
	}
	function makeSelectTypeAddInformation($combo_id = 0, $seleted = '')
	{
		$clsHotelCustomField = new HotelCustomField();
		$lstCustomField = $clsHotelCustomField->getAll("combo_id='$combo_id'", $clsHotelCustomField->pkey);
		$html = '<option value=""><< Select type >></option>';
		$lstType = $this->getListTypeAddInformation();
		foreach ($lstType as $k => $v) {
			if (!$clsHotelCustomField->checkExist($combo_id, $k)) {
				$html .= '<option' . $disabled . ' value="' . $k . '">__' . strtoupper($v) . '</option>';
			}
		}
		return $html;
		die();
	}
	function getListByItinerary($tour_id = 0, $tour_itinerary_id = 0)
	{
		global $core, $dbconn, $lang_sql;
		$clsTourHotel = new TourHotel();
		$SQL = "SELECT t1.combo_id FROM " . $this->tbl . " t1 INNER JOIN " . $clsTourHotel->tbl . " t2 WHERE t1.combo_id=t2.combo_id and t1.is_trash=0 and t1.is_online=1 and t2.tour_id='$tour_id' and t2.tour_itinerary_id='$tour_itinerary_id' and t1.lang_id='$lang_sql' order by t2.order_no ASC";
		return $dbconn->GetAll($SQL);
	}
	function doDelete($combo_id = 0)
	{
		$clsISO = new ISO();
		// Delete
		$this->deleteOne($combo_id);
		return 1;
	}
	function getListService($combo_id = 0, $one = null)
	{
		if (!isset($one['list_service'])) {
			$one = $this->getOne($combo_id, 'list_service');
		}
		$list_service = $one['list_service'];
		$list_service = str_replace('[', '', $list_service);
		$list_service = str_replace(']', '', $list_service);
		$list_service = str_replace('"', '', $list_service);
		return $list_service;
	}
}
