<?php

/**
 *  Created by   :
 *  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (tag@vietiso.com)	
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class HotPromotion extends dbBasic
{
	function __construct()
	{
		$this->pkey = "hot_promotion_id";
		$this->tbl = DB_PREFIX . "hot_promotion";
	}
	function getPriceAds($hot_promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($hot_promotion_id, 'price');
		return $one['price'];
	}
	function getPriceAdsAgent($hot_promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($hot_promotion_id, 'price_agent');
		return $one['price_agent'];
	}
	function getDeposit($hot_promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($hot_promotion_id, 'deposit');
		return $one['deposit'];
	}
	function getFlagText($hot_promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($hot_promotion_id, 'price_text');
		return $one['price_text'];
	}
	function getPromotionCode($hot_promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($hot_promotion_id, 'promotion_code');
		return $one['promotion_code'];
	}
	function getFromDate($hot_promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($hot_promotion_id, 'start_date');
		return $one['start_date'];
	}
	function getTodate($hot_promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($hot_promotion_id, 'end_date');
		return $one['end_date'];
	}
	function getTripCode($hot_promotion_id = 0)
	{
		$start_date = $this->getOneField('start_date', $hot_promotion_id);
		$date =  date('d', $start_date) . date('m', $start_date) . date('y', $start_date);
		$clsTour = new Tour();
		return $clsTour->getTripCode($this->getOneField('tour_id', $hot_promotion_id)) . '-' . $date;
	}
	function getPriceBooking($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = 0, $tour_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$clsProperty = new Property();
		$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id'");
		$one2 = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='0' and tour_id='$tour_id'");
		$price = $one[0]['price'];
		if ($price > 0) {
			return $one[0]['price'] == ''
				? $core->get_Lang('null')
				: $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatPrice($one[0]['price']);
		} else {
			return $one2[0]['price'] == ''
				? $core->get_Lang('null')
				: $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatPrice($one2[0]['price']);
		}
	}
	function getPriceBooking2($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date, $tour_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$clsProperty = new Property();
		$clsTour = new Tour();
		$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id'");
		$one2 = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='0' and tour_id='$tour_id'");
		$price = $one[0]['price'];
		if ($price > 0) {
			return $one[0]['price'] == ''
				? $core->get_Lang('null')
				: $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatPrice($one[0]['price']);
		} elseif ($one2[0]['price'] > 0) {
			return $one2[0]['price'] == ''
				? $core->get_Lang('null')
				: $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatPrice($one2[0]['price']);
		} else {
			$trip_price = $clsTour->getOneField('trip_price', $tour_id);
			return $trip_price == '' ? $core->get_Lang('null') : $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatPrice($trip_price);
		}
	}
	function getPriceSave($start_date = 0, $tour_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$clsProperty = new Property();
		$one = $this->getAll("tour_price_row_id='16' and tour_price_col_id='0' and departure_date='$start_date' and tour_id='$tour_id'");
		$one2 = $this->getAll("tour_price_row_id='0' and tour_price_col_id='0' and departure_date='$start_date' and tour_id='$tour_id'");

		$priceBooking = $one[0]['price'];
		$priceOld = $one2[0]['price'];
		$priceSave = $priceOld - $priceBooking;

		return $priceSave == '' ? $core->get_Lang('null') : $clsISO->getRate() . ' ' . $clsISO->formatPrice($priceSave);
	}
	function getTripPrice($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = 0, $tour_id = 0, $is_agent = 0)
	{
		global $core, $clsISO;
		$sql = "tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id' and is_agent='$is_agent'";
		$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id' and is_agent='$is_agent'");
		return $one[0]['price'] == '' ? 0 : $clsISO->formatPrice($one[0]['price']);
	}
	function getTripPriceOption($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = '', $tour_id = 0, $is_agent = 0)
	{
		global $core, $clsISO;
		if ($start_date > 0) {
			$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id' and is_agent='$is_agent'");
		} else {
			$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='0' and tour_id='$tour_id' and is_agent='$is_agent'");
		}
		return $one[0]['price'];
	}

	function getTripPriceOptionBooking($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = '', $tour_id = 0, $is_agent = 0)
	{
		global $core, $clsISO;
		$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id' and is_agent='$is_agent'");
		$one2 = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='0' and tour_id='$tour_id' and is_agent='$is_agent'");
		$price = $one[0]['price'];
		if ($price > 0) {
			return $price;
		} else {
			return $one2[0]['price'];
		}
	}
	function getTripPriceOptionBooking2($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = '', $tour_id = 0, $is_agent = '')
	{
		global $core, $clsISO;
		$clsTour = new Tour();
		$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id' and is_agent='$is_agent'");
		$one2 = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='0' and tour_id='$tour_id' and is_agent='$is_agent'");
		$price = $one[0]['price'];
		if ($price > 0) {
			return $price;
		} elseif ($one2[0]['price'] > 0) {
			return $one2[0]['price'];
		} else {
			$trip_price = $clsTour->getOneField('trip_price', $tour_id);
			return $trip_price;
		}
	}
	function getTripMinPriceOptionBooking($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = '', $tour_id = 0, $is_agent = '')
	{
		global $core, $clsISO, $dbconn;
		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_val WHERE tour_id='$tour_id' and price > 0 and (departure_date >= '" . time() . "' or departure_date = '0') and tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and is_agent='$is_agent'";
		return $dbconn->GetOne($SQL);
	}
	function getId($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = 0, $tour_id = 0, $is_agent = '')
	{
		$one = $this->getAll("tour_price_row_id='$tour_price_row_id' and tour_price_col_id='$tour_price_col_id' and departure_date='$start_date' and tour_id='$tour_id' and is_agent='$is_agent'");
		return $one[0]['tour_price_val_id'];
	}
}
