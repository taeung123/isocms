<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class TourStartDate extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_start_date_id";
		$this->tbl = DB_PREFIX . "tour_start_date";
	}
	function getId($start_date = 0, $tour_id = 0)
	{
		$all = $this->getAll("start_date='$start_date' and tour_id='$tour_id' LIMIT 0,1");
		return $all[0][$this->pkey] != '' ? $all[0][$this->pkey] : 0;
	}
	function getTitle($tour_price_col_id = 0)
	{
		$one = $this->getOne($tour_price_col_id, 'title');
		return $one['title'];
	}
	function checkIsActive($start_date = 0, $tour_id = 0)
	{
		$tour_start_date_id = $this->getId($start_date, $tour_id);
		if ($tour_start_date_id)
			return $this->getOneField('is_active', $tour_start_date_id);
		else
			return 0;
	}
	function getValue($start_date = 0, $tour_id = 0, $field = '')
	{
		global $clsISO;
		$tour_start_date_id = $this->getId($start_date, $tour_id);
		if ($tour_start_date_id)
			return $clsISO->formatPrice($this->getOneField($field, $tour_start_date_id));
		else
			return 0;
	}
	function getTripCode($tour_start_date_id = 0)
	{
		$start_date = $this->getOneField('start_date', $tour_start_date_id);
		$date =  date('d', $start_date) . date('m', $start_date) . date('y', $start_date);
		$clsTour = new Tour();
		return $clsTour->getTripCode($this->getOneField('tour_id', $tour_start_date_id)) . '-' . $date;
	}
	function getLink($tour_start_date_id = 0, $tour_id = 0)
	{
		$clsTour = new Tour();
		global $_LANG_ID, $extLang;
		return $extLang . '/tour/' . $clsTour->getSlug($tour_id) . '-ct' . $tour_id . '-sd' . $tour_start_date_id . '.html';
	}
	function getTripPrice($pvalTable = 0)
	{
		global $clsISO;
		$one = $this->getOne($pvalTable);
		return $clsISO->formatPrice($one['price']) . ' ' . $clsISO->getRate();
	}
	function getStartDateTour($pvalTable = 0, $type = '')
	{
		global $clsISO;
		$one = $this->getOne($pvalTable);
		return $clsISO->formatDate($one['start_date'], $type);
	}
	function getListStartDateTour($tour_id = 0, $type = '')
	{
		global $clsISO;

		$lstTourStartDate = $this->getAll("is_trash=0 and (start_date >= '" . time() . "' or (ruler_type = '1' and (('" . time() . "' BETWEEN start_date AND end_date) or (end_date >='" . time() . "')))) and tour_id ='$tour_id' AND is_active=1 order by start_date ASC", $this->pkey . ',start_date,end_date,ruler_type,weekdays');

		$arr_date = [];
		if (!empty($lstTourStartDate)) {
			foreach ($lstTourStartDate as $key => $value) {
				if ($value['ruler_type'] == 1) {
					$start_date = $value['start_date'];
					$end_date = $value['end_date'];
					$weekdays = $value['weekdays'];
					$weekdays_arr = !empty($weekdays) ? @json_decode($weekdays, true) : array();
					for ($i = $start_date; $i <= $end_date; $i += 86400) {
						if (in_array(date('D', $i), $weekdays_arr) && !in_array($clsISO->formatDate($i, $type), $arr_date)) {
							$arr_date[] = $clsISO->formatDate($i, $type);
						}
					}
				} else {
					$arr_date[] = $clsISO->formatDate($value['start_date'], $type);
				}
			}
		}

		return $arr_date;
	}
	function getStartDate($pvalTable = 0)
	{
		global $clsISO;
		$one = $this->getOne($pvalTable, 'start_date');
		return $one['start_date'];
	}
	function getEndDateDefault($tour_start_date_id = 0)
	{
		$clsTour = new Tour();
		$start_date = $this->getOneField('start_date', $tour_start_date_id);
		$tour_id = $this->getOneField('tour_id', $tour_start_date_id);
		return $start_date + 24 * 60 * 60 * ($clsTour->getOneField('number_day', $tour_id) - 1);
	}
	function checkTourStartDate($tour_id = 0, $start_date = 0)
	{
		$res = $this->getAll("tour_id = '$tour_id' and start_date = '$start_date' limit 0,1");
		return intval($res[0]['seat_available']) > 0 ? 1 : 0;
	}
	function checkTourLastHour($tour_start_date_id = 0, $now_day = 0)
	{
		$listTopTourLastHours = $this->getAll("is_trash=0 and is_online=1 and tour_start_date_id ='$tour_start_date_id' and is_last_hour = 1 and close_sell_date >= '$now_day' and open_sell_date <= '$now_day' and start_date > '$now_day'", $this->pkey . ",start_date");

		return intval($listTopTourLastHours[0]['tour_start_date_id']) > 0 ? 1 : 0;
	}
	function getSeatAvailableTour($pvalTable = 0)
	{
		global $clsISO;
		$one = $this->getOne($pvalTable, 'allotment');
		return $one['allotment'];
	}
	function getAllotmentTourGroup($tour_id = 0, $start_date = 0, $is_agent = 0)
	{
		$res = $this->getAll("tour_id = '$tour_id' and start_date = '$start_date' and type='GROUP' and is_agent='$is_agent' limit 0,1");
		return intval($res[0]['allotment']) > 0 ? intval($res[0]['allotment']) : 0;
	}
	function getAllotmentTourGroup2($tour_id = 0, $start_date = 0, $is_agent = 0)
	{
		$res = $this->getAll("tour_id = '$tour_id' and start_date = '" . strtotime($start_date) . "' and type='GROUP' and is_agent='$is_agent' limit 0,1");
		return intval($res[0]['allotment']) > 0 ? intval($res[0]['allotment']) : 0;
	}
	function getSeatAvailable($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'seat_available');
		return $one['seat_available'];
	}


	function getSoldAvailable($tour_id = 0, $start_date = 0, $is_agent = 0)
	{
		$res = $this->getAll("tour_id = '$tour_id' and start_date = '" . strtotime($start_date) . "' and type='GROUP' and is_agent='$is_agent' limit 0,1");
		return intval($res[0]['sold']) > 0 ? intval($res[0]['sold']) : 0;
	}
	function getDepositDeparture($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'deposit');
		return $one['deposit'];
	}
	function getPromotion($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'promotion');
		return $one['promotion'];
	}
	function getPriceAds($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'price_ads');
		return $one['price_ads'];
	}
	function countTourStartDateByMonth($tour_id = 0, $start_date = 0, $end_date = 0)
	{
		global $clsISO;

		//return $start_date.'xxxx'.strtotime($end_date);
		$sql = "is_trash=0 and is_online=1 and tour_id ='$tour_id' and start_date >= '" . time() . "' and start_date >= '" . strtotime($start_date) . "' and start_date <= '" . strtotime($end_date) . "' order by start_date ASC";
		//return $sql;
		$lstTourStartDate = $this->getAll("is_trash=0 and is_online=1 and tour_id ='$tour_id' and start_date >= '" . time() . "' and start_date >= '" . strtotime($start_date) . "' and start_date <= '" . strtotime($end_date) . "' order by start_date ASC");

		return $lstTourStartDate[0]['tour_start_date_id'];

		return intval($lstTourStartDate[0]['tour_start_date_id']) > 0 ? 1 : 0;
	}

	function getOpenSellDate($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'open_sell_date');
		$open_date = $one['open_sell_date'] ? $one['open_sell_date'] : time();
		$open_sell_date = date('d/m/Y', $open_date);

		return $open_sell_date;
	}

	function getCloseSellDate($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'close_sell_date');
		$close_date = $one['close_sell_date'] ? $one['close_sell_date'] : time() + 24 * 60 * 60;
		$close_sell_date = date('d/m/Y', $close_date);

		return $close_sell_date;
	}

	function getCloseSellDateCountDown($pvalTable = 0, $type = '')
	{
		global $clsISO;
		$one = $this->getOne($pvalTable, 'close_sell_date');
		return $clsISO->formatDate($one['close_sell_date'], $type);
	}
	function getStrCloseSellDateCountDown($pvalTable = 0)
	{
		global $clsISO;
		$one = $this->getOne($pvalTable, 'close_sell_date');
		return $one['close_sell_date'];
	}
	function getTripPriceTour($tour_id = 0, $start_date = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$clsProperty = new Property();
		$clsTourPriceGroup = new TourPriceGroup();
		$clsTourStore = new TourStore();

		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date >='" . $start_date . "' and tour_visitor_type_id='$adult_type_id'";
		//return $SQL;

		$priceAdultAds = $dbconn->GetOne($SQL);
		if ($is_agent == 'AGENT') {
			if ($priceAdultAds > 0) {
				return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100));
			} else {
				return '';
				$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
				$priceAdultAds = $dbconn->GetOne($SQL);
				return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100));
			}
		} elseif ($is_agent == 'CTV') {
			if ($priceAdultAds > 0) {
				return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100));
			} else {
				return '';
				$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
				$priceAdultAds = $dbconn->GetOne($SQL);
				return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100));
			}
		} else {
			if ($priceAdultAds > 0) {
				return $clsISO->formatPrice($priceAdultAds);
			} else {
				return '';
				$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date >='" . $start_date . "' and tour_visitor_type_id='0'";
				$priceAdultAds = $dbconn->GetOne($SQL);
				return $clsISO->formatPrice($priceAdultAds);
			}
		}
	}
	function getTripPriceTourStartDate($tour_id = 0, $start_date = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$clsProperty = new Property();
		$clsTourPriceGroup = new TourPriceGroup();
		$clsTourStore = new TourStore();

		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='$adult_type_id'";

		$priceAdultAds = $dbconn->GetOne($SQL);
		if ($priceAdultAds > 0) {
			if ($is_agent == 'AGENT') {
				if ($priceAdultAds > 0) {
					return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100));
				} else {
					return '';
					$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
					$priceAdultAds = $dbconn->GetOne($SQL);
					return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100));
				}
			} elseif ($is_agent == 'CTV') {
				if ($priceAdultAds > 0) {
					return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100));
				} else {
					return '';
					$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
					$priceAdultAds = $dbconn->GetOne($SQL);
					return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100));
				}
			} else {
				if ($priceAdultAds > 0) {
					return $clsISO->formatPrice($priceAdultAds);
				} else {
					return '';
					$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
					$priceAdultAds = $dbconn->GetOne($SQL);
					return $clsISO->formatPrice($priceAdultAds);
				}
			}
		} else {
			return '';
		}
	}

	function getTripPriceSaveTourStartDate($tour_start_date_id = 0, $tour_id = 0, $start_date = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$price_ads = $this->getTripPriceAdsValue($tour_start_date_id, $is_agent);
		$price = $this->getTripPriceTourStartDateValue($tour_id, $start_date, $is_agent);

		$price_save = $price_ads ? $price_ads - $price : 0;
		$save = $price_save ? number_format($price_save / $price_ads * 100, 1, ",", ".") : 0;
		return $save;
	}
	function getTripPriceTourValue($tour_id = 0, $start_date = 0, $is_agent = 0)
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$clsProperty = new Property();
		$clsTourPriceGroup = new TourPriceGroup();
		$clsTourStore = new TourStore();

		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date >='" . $start_date . "' and tour_visitor_type_id='$adult_type_id'";

		$priceAdultAds = $dbconn->GetOne($SQL);
		if ($priceAdultAds > 0) {
			return $priceAdultAds;
		} else {
			return '';
			$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date >='" . $start_date . "' and tour_visitor_type_id='0'";
			$priceAdultAds = $dbconn->GetOne($SQL);
			return $priceAdultAds;
		}
	}
	function getTripPriceTourStartDateValue($tour_id = 0, $start_date = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$clsProperty = new Property();
		$clsTourPriceGroup = new TourPriceGroup();
		$clsTourStore = new TourStore();

		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='$adult_type_id'";

		$priceAdultAds = $dbconn->GetOne($SQL);

		if ($is_agent == 'AGENT') {
			if ($priceAdultAds > 0) {
				return $priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100);
			} else {
				return '';
				$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
				$priceAdultAds = $dbconn->GetOne($SQL);
				return $priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100);
			}
		} elseif ($is_agent == 'CTV') {
			if ($priceAdultAds > 0) {
				return $priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100);
			} else {
				return '';
				$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
				$priceAdultAds = $dbconn->GetOne($SQL);
				return $priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100);
			}
		} else {
			if ($priceAdultAds > 0) {
				return $priceAdultAds;
			} else {
				return '';
				$SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='" . $start_date . "' and tour_visitor_type_id='0'";
				$priceAdultAds = $dbconn->GetOne($SQL);
				return $priceAdultAds;
			}
		}
	}
	function getTripPricePromotion($pvalTable = 0, $tour_id = 0, $start_date = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$one = $this->getOne($pvalTable, 'promotion');
		$promotion = $one['promotion'];

		$priceAdultAds = $this->getTripPriceTourStartDateValue($tour_id, $start_date, $is_agent);
		$pricePromotion = $promotion * $priceAdultAds / 100;

		return $clsISO->formatPrice($priceAdultAds - $pricePromotion);
	}
	function getTripPriceAds($pvalTable = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$one = $this->getOne($pvalTable, 'price_ads');
		$priceAdultAds = $one['price_ads'];

		if ($priceAdultAds > 0) {
			if ($is_agent == 'AGENT') {
				$priceAdultAds = $priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100);
			} elseif ($is_agent == 'CTV') {
				$priceAdultAds = $priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100);
			} else {
				$priceAdultAds = $priceAdultAds;
			}
			return $clsISO->formatPrice($priceAdultAds) . '' . $clsISO->getShortRate();
		} else {
			return '';
		}
	}
	function getTripPriceAdsValue($pvalTable = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$one = $this->getOne($pvalTable, 'price_ads');
		$priceAdultAds = $one['price_ads'];

		if ($priceAdultAds > 0) {
			if ($is_agent == 'AGENT') {
				$priceAdultAds = $priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100);
			} elseif ($is_agent == 'CTV') {
				$priceAdultAds = $priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100);
			} else {
				$priceAdultAds = $priceAdultAds;
			}
			return $priceAdultAds;
		} else {
			return '0';
		}
	}


	function getTripPricePromotionStartDate($pvalTable = 0, $tour_id = 0, $start_date = '', $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$one = $this->getOne($pvalTable, 'promotion');
		$promotion = $one['promotion'];

		$priceAdultAds = $this->getTripPriceTourStartDateValue($tour_id, $start_date, $is_agent);
		$pricePromotion = $promotion * $priceAdultAds / 100;

		return $clsISO->formatPrice($priceAdultAds - $pricePromotion);
	}
	function getTripPriceOnePromotionStartDate($pvalTable = 0, $tour_id = 0, $start_date = 0, $is_agent = '')
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;

		$clsTour = new Tour();
		$assign_list["clsTour"] = $clsTour;
		$clsPromotion = new Promotion();
		$assign_list['clsPromotionr'] = $clsPromotion;
		$promotion_id = $clsTour->getMinStartDatePromotionProID($tour_id, $start_date);
		$promotion = $clsPromotion->getPromotion($promotion_id);
		$priceAdultAds = $this->getTripPriceTourStartDateValue($tour_id, $start_date, $is_agent);
		$pricePromotion = $promotion * $priceAdultAds / 100;
		if ($promotion_id != '') {
			return $clsISO->formatPrice($priceAdultAds - $pricePromotion);
		}
	}

	function getDateDeparture($timestamp = 0)
	{
		$day = date('d', $timestamp);
		return $day;
	}

	function getMonthDeparture($timestamp = 0)
	{
		global $core;
		$month = date('F', $timestamp);
		return $core->get_Lang($month);
	}
}
