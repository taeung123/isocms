<?php
class TourPriceGroup extends dbBasic
{
	function __construct()
	{
		$this->pkey = "tour_price_group_id";
		$this->tbl = DB_PREFIX . "tour_price_group";
	}
	function getId($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0)
	{
		$res = $this->getAll("tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id' LIMIT 0,1");
		return $res[0][$this->pkey];
	}
	function getPrice($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $departure = 0, $tour_visitor_age_type_id = 0, $tour_visitor_height_type_id = 0)
	{
		global $_LANG_ID, $clsISO;
		$price = 0;
		$sql = "tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id' and tour_visitor_age_type_id='$tour_visitor_age_type_id' and tour_visitor_height_type_id='$tour_visitor_height_type_id'";
		$sql .= " and departure_date='$departure'";
		/*if($type!==''){
			$sql.=" and type='$type'";
		}*/
		$sql .= " limit 0,1";
		//return $sql;
		$lst = $this->getAll($sql);
		if (!empty($lst[0]['price'])) {
			$price = $lst[0]['price'];
		}
		return $clsISO->formatPrice($price);
	}
	function getPriceType($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $departure = 0, $tour_visitor_age_type_id = 0, $tour_visitor_height_type_id = 0)
	{
		global $_LANG_ID, $clsISO;
		$price = 0;
		$sql = "tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id' and tour_visitor_age_type_id='$tour_visitor_age_type_id' and tour_visitor_height_type_id='$tour_visitor_height_type_id'";
		$sql .= " and departure_date='$departure'";
		$sql .= " limit 0,1";
		//return $sql;
		$lst = $this->getAll($sql, 'price_type');
		if (!empty($lst[0]['price_type'])) {
			$price_type = $lst[0]['price_type'];
		}
		return $price_type ?? '';
	}
	function getPriceBooking($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $departure = 0)
	{
		global $_LANG_ID;
		$price = 0;
		$sql = "tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id'";
		$sql .= " and departure_date='$departure'";
		$sql .= " limit 0,1";
		// var_dump($sql);die();
		$lst = $this->getAll($sql);
		if (!empty($lst[0]['price'])) {
			$price = $lst[0]['price'];
		}
		return $price;
	}
	function getPriceBookingChildInfant($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $visitor_age_type = 0, $visitor_height_type = 0, $departure = 0)
	{
		global $_LANG_ID, $child_type_id;
		$clsTourOption = new TourOption();
		$price = 0;
		$sql = "tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id' and tour_visitor_age_type_id ='" . $visitor_age_type . "' and tour_visitor_height_type_id ='" . $visitor_height_type . "'";
		$sql .= " and departure_date='$departure'";
		$lst = $this->getAll($sql, "price_type,price");
		return $lst[0];
	}
	function getPriceTableTourGroup($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $departure = 0)
	{
		global $_LANG_ID;
		$price = 0;
		$sql = "tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id'";
		$sql .= " and departure_date='$departure'";

		$sql .= " limit 0,1";
		$lst = $this->getAll($sql);
		$price = $lst[0]['price'];
		return number_format($price, 0, ",", ".");
	}
	function getPriceTableTourGroupPromotion($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $departure = 0)
	{
		global $_LANG_ID, $dbconn;
		$price = 0;
		$sql = "tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id'";
		$sql .= " and departure_date='$departure'";


		$Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$tour_id' and is_online=1 and " . $departure . " between  start_date and end_date order by start_date ASC limit 0,1";
		$promotion = $dbconn->GetOne($Sql_Promotion);


		$sql .= " limit 0,1";
		$lst = $this->getAll($sql);
		$price = $lst[0]['price'];

		if ($promotion > 0) {
			$pricePromotion = $price * $promotion / 100;
			$priceNew = $price - $pricePromotion;
		} else {
			$priceNew = $price;
		}


		return number_format($priceNew, 0, ",", ".");
	}
	function getPromotionValue($tour_id = 0, $tour_class_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0, $departure = 0)
	{
		global $_LANG_ID, $dbconn;
		$price = 0;
		$sql = "tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id'";

		$sql .= " and departure_date='0'";

		$Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$tour_id' and is_online=1 and " . $departure . " between  start_date and end_date order by start_date ASC limit 0,1";
		$promotion = $dbconn->GetOne($Sql_Promotion);

		return $promotion;
	}
	function getTripMinPriceTourGroup($tour_id = 0, $tour_visitor_type_id = 0, $departure = 0, $type = '')
	{
		global $core, $clsISO, $dbconn;
		$clsTour = new Tour();
		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date = '" . strtotime($departure) . "' and tour_visitor_type_id='$tour_visitor_type_id'";
		$price = $dbconn->GetOne($SQL);
		$html = '';
		if ($type == 'default') {

			if ($price > 0) {
				$html .= '
				<div class="Price">
					<span class="text">' . $core->get_Lang('Price From') . '</span>
					<span class="price">$' . $price . '</span>
				</div>';
			} else {
				$html .= '<div class="Price">
					<a class="linkTailor" href="' . $clsTour->getLinkCustomize($tour_id) . '">' . $core->get_Lang('Tailor made') . '</a>
				</div>';
			}
			return $html;
		} else {
			if ($price > 0) {
				return $price;
			} else {
				if ($price2 > 0) {
					return $price2;
				} else {
				}
			}
		}
	}
	function getTripMinPriceTourGroupDate($tour_id = 0, $tour_visitor_type_id = 0, $departure = 0, $type = '')
	{
		global $core, $clsISO, $dbconn;

		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and tour_visitor_type_id='$tour_visitor_type_id'";

		$SQL .= " and departure_date = '$departure'";

		$price = $dbconn->GetOne($SQL);

		$Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$tour_id' and is_online=1 and " . $departure . " between  start_date and end_date order by start_date ASC limit 0,1";

		$promotion = $dbconn->GetOne($Sql_Promotion);
		$pricePromotion = $price - ($promotion * $price / 100);
		if ($price > 0) {
			if ($promotion > 0) {
				return '<span class="size24 color_main"><span class="line_through size16 color_666">' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</span>' . $clsISO->getShortRate() . number_format($pricePromotion, 0, ",", ".") . '</span>';
			} else {
				return '<span class="size24 color_main">' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</span>';
			}
		} else {
			return '';
		}
	}
	function getTripMinPrice($tour_id = 0, $tour_visitor_type_id = 0)
	{
		global $core, $clsISO, $dbconn;
		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date = '0' and tour_visitor_type_id='$tour_visitor_type_id'";
		$SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date = '0' and tour_visitor_type_id='0' and type='PRICEADS'";
		$price = $dbconn->GetOne($SQL);
		$price2 = $dbconn->GetOne($SQL2);
		$html = '';

		if ($price > 0) {
			return $price;
		} else {
			if ($price2 > 0) {
				return $price2;
			} else {
			}
		}
	}
	function getTripMinPriceCalendar($tour_id = 0, $tour_visitor_type_id = 0)
	{
		global $core, $clsISO, $dbconn;
		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date = '0' and tour_visitor_type_id='$tour_visitor_type_id'";

		$price = $dbconn->GetOne($SQL);
		if ($price > 0) {
			return $price;
		}
	}
	function getPriceSingleSupplyAdmin($tour_id = 0, $tour_class_id = 0, $departure_date = 0, $is_agent = 0)
	{
		global $_LANG_ID, $dbconn, $clsISO;
		$price = '';
		$lst = $this->getAll("tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='0' and tour_visitor_type_id='0' and departure_date='$departure_date' limit 0,1");
		if ($lst[0][$this->pkey] != '') {
			$priceAdultAds = $lst[0]['price_single_supply'];
		}
		if ($priceAdultAds > 0) {
			return $clsISO->formatPrice($priceAdultAds);
		}
	}
	function getPriceSingleSupply($tour_id = 0, $tour_class_id = 0, $departure_date = 0)
	{
		global $_LANG_ID, $dbconn, $clsISO;
		$price = '';
		$lst = $this->getAll("tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_number_group_id='0' and tour_visitor_type_id='0' and departure_date='$departure_date' limit 0,1");
		if ($lst[0][$this->pkey] != '') {
			$price = $lst[0]['price_single_supply'];
		}
		$Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$tour_id' and is_online=1 and " . $departure_date . " between  start_date and end_date order by start_date ASC limit 0,1";

		$promotion = $dbconn->GetOne($Sql_Promotion);
		if ($promotion > 0) {
			$pricePromotion = $price - ($promotion * $price / 100);
		}

		if ($price > 0) {
			if ($promotion > 0) {
				return '<span class="size18 color_main"><span class="line_through size16 color_666">' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</span>' . $clsISO->getShortRate() . number_format($pricePromotion, 0, ",", ".") . '</span>';
			} else {
				return '<span class="size18 color_main">' . $clsISO->getShortRate() . number_format($price, 0, ",", ".") . '</span>';
			}
		} else {
			return '-';
		}
	}
	function CheckPriceByAdultClass($tour_id = 0, $tour_class_id = 0, $tour_visitor_type_id = 0)
	{
		global $_LANG_ID;
		$flag = 0;
		$lst = $this->getAll("tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_visitor_type_id='$tour_visitor_type_id' limit 0,1");
		if (!empty($lst)) {
			foreach ($lst as $k => $v) {
				if ($v['price'] > 0) {
					$flag = 1;
					break;
				}
			}
		}
		return $flag;
	}
	function CheckPriceByAdultGroup($tour_id = 0, $tour_number_group_id = 0, $tour_visitor_type_id = 0)
	{
		global $_LANG_ID;
		$flag = 0;
		$lst = $this->getAll("tour_id='$tour_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id='$tour_visitor_type_id' limit 0,1");
		if (!empty($lst)) {
			foreach ($lst as $k => $v) {
				if ($v['price'] > 0) {
					$flag = 1;
					break;
				}
			}
		}
		return $flag;
	}
	function getTourNumberGroup($tour_property_id = 0, $number = '', $tour_id = 0)
	{
		global $_LANG_ID, $adult_type_id, $child_type_id, $infant_type_id, $clsISO;

		$clsTourProperty = new TourProperty();
		$clsTourOption = new TourOption();
		$clsTour = new Tour();
		if ($tour_property_id == $adult_type_id) {
			$SizeGroup = $clsTour->getOneField('adult_group_size', $tour_id);
		} elseif ($tour_property_id == $child_type_id) {
			$SizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
		} else {
			$SizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
		}

		$SizeGroup = str_replace("|", ",", trim($SizeGroup, "|"));
		if ($number != '') {
			$oneTourNumberGroup = $clsTourOption->getAll("is_trash=0 and type='SIZEGROUP' and tour_property_id='$tour_property_id' and number_from <= '$number' and number_to>='$number' and tour_option_id IN ($SizeGroup) Limit 0,1");
			// $clsISO->dump($oneTourNumberGroup);
		} else {
			$oneTourNumberGroup = $clsTourOption->getAll("is_trash=0 and type='SIZEGROUP' and tour_property_id='$tour_property_id' and tour_option_id IN ($SizeGroup) Limit 0,1");
		}

		return $oneTourNumberGroup[0][$clsTourOption->pkey] ?? 0;
	}
	function countNumberPriceDepartureDate($tour_id = 0, $departure = 0)
	{
		global $_LANG_ID;
		$NumberPrice = $this->getAll("is_trash=0 and tour_id='$tour_id' and departure_date='$departure' and (price > '0' or price_single_supply > 0) ");
		if ($NumberPrice != '')
			return count($NumberPrice);
		return 0;
	}
	function CheckPriceByNumberGroupClass($tour_id = 0, $tour_visitor_type_id = 0, $tour_class_id = '', $tour_number_group_id = '', $type = '')
	{
		global $_LANG_ID;
		$flag = 0;
		if ($type == 'VISITOR') {
			$lst = $this->getAll("tour_id='$tour_id' and tour_visitor_type_id='$tour_visitor_type_id' and tour_visitor_type_id >0 and price >0");
		} elseif ($type == 'GROUP') {
			$lst = $this->getAll("tour_id='$tour_id' and tour_visitor_type_id='$tour_visitor_type_id' and tour_number_group_id='$tour_number_group_id' and tour_visitor_type_id >0 and tour_visitor_type_id <>16 and tour_number_group_id > 0 and price >0");
		} elseif ($type == 'CLASS_GROUP') {
			$lst = $this->getAll("tour_id='$tour_id' and tour_class_id='$tour_class_id' and tour_class_id >0 and price >0");
		} else {
			$lst = $this->getAll("tour_id='$tour_id' and tour_visitor_type_id='$tour_visitor_type_id' and tour_visitor_type_id >0 and price >0");
		}

		if (!empty($lst)) {
			return 1;
		}
		return 0;
	}
	function getNumberGroup($tour_id = 0, $tour_visitor_type_id = 0)
	{
		global $_LANG_ID;
		$lst = $this->getAll("tour_id='$tour_id' and tour_visitor_type_id='$tour_visitor_type_id' and tour_visitor_type_id >0 and tour_number_group_id>0 and price >0 group by tour_number_group_id");

		if (!empty($lst)) {
			return count($lst);
		}
		return 0;
	}
}
