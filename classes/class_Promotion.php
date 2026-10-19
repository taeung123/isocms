<?php
class Promotion extends dbBasic
{
	function __construct()
	{
		$this->pkey = "promotion_id";
		$this->tbl = DB_PREFIX . "promotion";
	}
	function getSlash($level = 0)
	{
		return str_repeat("------", $level + 1);
	}
	function getTitle($target_id = 0, $clsTable = '')
	{
		$clsClassTable = new $clsTable;
		if ($clsTable == 'Cruise') {
			return $clsClassTable->getTitle($target_id);
		} else {
			return $clsClassTable->getTitle($target_id);
		}
	}
	function getSlug($promotion_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($promotion_id, 'slug');
		return $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$all = $this->getAll("is_trash=0 and (slug_en='$slug' or slug_vn='$slug') order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
	function getByPromotionCode($promotion_code = 0)
	{
		$all = $this->getAll("is_online=1 and promotion_code='$promotion_code' order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
	function getByPermalink($permalink = '')
	{
		$all = $this->getAll("is_trash=0 and (permalink_en='$permalink' or permalink_vn='$permalink') order by " . $this->pkey . " limit 0,1");
		return $all[0][$this->pkey];
	}
	function getLink($promotion_id = 0, $clsTable = '')
	{
		$clsClassTable = new $clsTable;
		return $clsClassTable->getLinkPromotion($promotion_id);
	}
	function getPermalink($promotion_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($promotion_id, 'permalink');
		if ($one['permalink'] == '')
			return $one['slug'];
		return $one['permalink'];
	}
	function getImage($ppvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$image = $this->getOneField("image", $ppvalTable);
		if (trim($image) != '') {
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
			return $clsISO->parseImageURL($image);
		}
		return URL_IMAGES . '/noimage.png';
	}
	function getIntro($promotion_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($promotion_id, 'intro');
		return $one['intro'];
	}
	function getContent($promotion_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($promotion_id, 'content');
		return html_entity_decode($one['content']);
	}
	function getTermCondition($promotion_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($promotion_id, 'term');
		return html_entity_decode($one['term']);
	}
	function getBookByDate($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'book_date');
		return $clsISO->converTextToText($one['book_date']);
	}
	function getPromotionDate($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'date_begin,date_end');
		$html = '';
		if (!empty($one['date_begin']) && !empty($one['date_end'])) {
			$html .= 'Stay Between ' . $clsISO->converTextToText($one['date_begin']) . ' and ' . $clsISO->converTextToText($one['date_end']) . '';
		} elseif (!empty($one['date_begin']) && $one['date_end'] == '0') {
			$html .= 'Stay Starting ' . $clsISO->converTextToText($one['date_begin']) . '';
		}
		return $html;
	}
	function getStartDate($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'date_begin');
		if (!empty($one['date_begin'])) {
			return date('d/m/Y', $one['date_begin']);
		}
	}
	function getEndDate($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'date_end');
		if (!empty($one['date_end'])) {
			return date('d/m/Y', $one['date_end']);
		}
	}
	function getStartDatePro($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'start_date');
		if (!empty($one['start_date'])) {
			return date('d/m/Y', $one['start_date']);
		}
	}
	function getEndDatePro($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'end_date');
		if (!empty($one['end_date'])) {
			return date('d/m/Y', $one['end_date']);
		}
	}
	function getEndDatePro1($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'end_date');
		if (!empty($one['end_date'])) {
			return date('m/d/Y', $one['end_date']);
		}
	}
	function getTravelEndDateProCountDown($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'end_date');
		if (!empty($one['end_date'])) {
			$time_end_date = array(
				'year' => date('Y', $one['end_date']),
				'month' => date('m', $one['end_date']),
				'day' => date('d', $one['end_date']),
				'hour' => date('h', $one['end_date']),
				'minute' => date('i', $one['end_date']),
			);
			return $time_end_date;
		}
	}
	function getTravelStartDatePro($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'travel_date_from');
		if (!empty($one['travel_date_from'])) {
			return date('d/m/Y', $one['travel_date_from']);
		}
	}
	function getTravelEndDatePro($promotion_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($promotion_id, 'travel_date_to');
		if (!empty($one['travel_date_to'])) {
			return date('d/m/Y', $one['travel_date_to']);
		}
	}
	function checkHide($promotion_id = 0)
	{
		$one = $this->getOne($promotion_id, 'date_end,date_begin');
		$date_begin = $one['date_begin'];
		$date_end = $one['date_end'];
		#
		if ($date_end < strtotime(date('m/d/Y', time()) . ' 23:59'))
			return 1;
		return 0;
	}
	function getStripIntro($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro,content');
		if (!empty($one['intro']))
			return strip_tags(html_entity_decode($one['intro']));
		return strip_tags(html_entity_decode($one['content']));
	}
	function getPriceAds($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'price');
		return $one['price'];
	}
	function getPriceAdsAgent($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'price_agent');
		return $one['price_agent'];
	}
	function getDeposit($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'deposit');
		return $one['deposit'];
	}
	function getFlagText($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'price_text');
		return $one['price_text'] ?? '';
	}
	function getPromotionCode($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'promotion_code');
		return $one['promotion_code'];
	}
	function getCheckPromotionCode($promotion_code = 0, $type = '')
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty, $dbconn;
		//		$one = $this->getOne($promotion_id,'promotion_code');
		$sql = "SELECT COUNT(*) as total FROM " . $this->tbl . " WHERE is_online = 1 and `type`='" . $type . "' and check_code_product=1 and promotion_code='" . $promotion_code . "'";
		$result = $dbconn->GetAll($sql);
		return $result[0]['total'];
	}
	function getPromotion($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'promot');
		return $one['promot'];
	}
	function getCheckMem($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'check_mem_set');
		return $one['check_mem_set'] ?? '';
	}
	function getCheckCodeProduct($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'check_code_product');
		return $one['check_code_product'];
	}
	function getFromDate($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'start_date');
		return $one['start_date'];
	}
	function getTodate($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'end_date');
		return $one['end_date'];
	}
	function getTravelFromDate($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'travel_date_from');
		return $one['travel_date_from'];
	}
	function getTravelTodate($promotion_id = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'travel_date_to');
		return $one['travel_date_to'];
	}
	function getDiscountValue($promotion_id = 0, $key = 0)
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'discount_value');
		$discount_value = explode(',', $one['discount_value']);

		return $discount_value[$key];
	}
	function getUpdateDiscountValueTicket($promotion_id = 0, $val = '')
	{
		global $core, $clsISO, $clsConfiguration, $clsProperty;
		$one = $this->getOne($promotion_id, 'discount_value');
		$discount_value = explode(',', $one['discount_value']);
		$mod_discount_value = $discount_value[0] . ',' . $discount_value[1] . ',' . $val . ',' . $discount_value[3] . ',' . $discount_value[4] . ',' . $discount_value[5] . ',' . $discount_value[6];

		return $mod_discount_value;
	}
	function getTripCode($promotion_id = 0)
	{
		$start_date = $this->getOneField('start_date', $promotion_id);
		$date =  date('d', $start_date) . date('m', $start_date) . date('y', $start_date);
		$clsTour = new Tour();
		return $clsTour->getTripCode($this->getOneField('tour_id', $promotion_id)) . '-' . $date;
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
	function getPriceBooking2($tour_price_row_id = 0, $tour_price_col_id = 0, $start_date = 0, $tour_id = 0)
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
	function doDelete($pvalTable = 0)
	{
		// Delete
		$clsPromotionItem = new PromotionItem();
		$clsPromotionItem->deleteByCond("promotion_id='$pvalTable'");
		$this->deleteOne($pvalTable);
		return 1;
	}
}
