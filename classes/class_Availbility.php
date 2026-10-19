<?php
class Availbility extends dbBasic
{
	function __construct()
	{
		$this->pkey = "availbility_id";
		$this->tbl = DB_PREFIX . "availbility";
	}
	function getAvailbilityId($hotel_room_id = 0, $departure_in = 0, $departure_out = 0)
	{
		global $core, $dbconn;
		$SQL = "SELECT availbility_id FROM " . DB_PREFIX . "availbility WHERE target_id='$hotel_room_id' and check_in >='$departure_in' and check_out <='$departure_out' and type='_ROOM' order by price limit 0,1";
		return $dbconn->GetOne($SQL);
	}
	function checkRequestPrice($hotel_room_id = 0, $departure_in = 0, $departure_out = 0)
	{
		global $core, $dbconn;
		$SQL = "SELECT * FROM " . DB_PREFIX . "availbility WHERE target_id='$hotel_room_id' and check_in >='$departure_in' and check_out <='$departure_out' and type='_ROOM' order by check_in ASC";
		$allAvailbility = $dbconn->getAll($SQL);
		$flag = 0;
		if (!empty($allAvailbility)) {
			foreach ($allAvailbility as $k => $v) {
				if ($v['request_price'] == 1)
					$flag = 1;
			}
		}
		return $flag;
	}
	function getRoomPrice($pvalTable = 0)
	{
		global $core, $clsISO;
		#
		$one = $this->getOne($pvalTable);
		$price = $one['price'];
		if (intval($price) > 0) {
			return $clsISO->formatPrice($price, 3);
		}
		return '<a class="contactLink" href="' . $clsISO->getLink('feedback') . '">' . $core->get_Lang('Click lấy giá') . '</a>';
	}
	function getRoomPriceDate($pvalTable = 0, $departure_in = 0)
	{
		global $core, $clsISO;
		$clsHotelRoom = new HotelRoom();
		global $dbconn;
		$SQL = "SELECT price FROM " . DB_PREFIX . "availbility WHERE target_id='$pvalTable' and check_in ='$departure_in' and type='_ROOM' order by price limit 0,1";
		#
		$price = $dbconn->GetOne($SQL);
		if (intval($price) > 0) {
			return $clsISO->formatPrice($price, 3);
		}
		return $clsHotelRoom->getPriceDate($pvalTable);
	}
	function getRoomPriceDatePlace($pvalTable = 0, $departure_in = 0)
	{
		global $core, $clsISO, $clsConfiguration;
		$clsProperty = new Property();
		$assign_list['clsProperty'] = $clsProperty;
		$clsHotelRoom = new HotelRoom();
		global $dbconn;
		$SQL = "SELECT price FROM " . DB_PREFIX . "availbility WHERE target_id='$pvalTable' and check_in ='$departure_in' and type='_ROOM' order by price limit 0,1";
		#
		$price = $dbconn->GetOne($SQL);
		if (intval($price) > 0) {
			return $clsISO->formatPrice($price, 3) . '<p>' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' / ' . $core->get_Lang('nights') . '</p>';
		}
	}
	function getRoomPriceNoDate($pvalTable = 0, $departure_in = 0)
	{
		global $core, $clsISO;
		$clsHotelRoom = new HotelRoom();
		global $dbconn;
		$SQL = "SELECT price FROM " . DB_PREFIX . "availbility WHERE target_id='$pvalTable' and check_in ='$departure_in' and type='_ROOM' order by price limit 0,1";
		#
		$price = $dbconn->GetOne($SQL);
		if (intval($price) > 0) {
			return $clsISO->formatPrice($price, 3);
		}
	}
	function getRoomPriceMath($pvalTable = 0, $departure_in = 0)
	{
		global $core, $clsISO;
		global $dbconn;
		$SQL = "SELECT price FROM " . DB_PREFIX . "availbility WHERE target_id='$pvalTable' and check_in ='$departure_in' and type='_ROOM' order by price limit 0,1";
		#
		$price = $dbconn->GetOne($SQL);

		return intval($price);
	}
}
