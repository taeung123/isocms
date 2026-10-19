<?php
class CruiseCabin extends dbBasic
{
	function __construct()
	{
		$this->pkey = "cruise_cabin_id";
		$this->tbl = DB_PREFIX . "cruise_cabin";
	}
	function getTitle($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'title');
		return $one['title'];
	}
	function getMaxAdult($pvalTable = 0)
	{
		$clsCruiseProperty = new CruiseProperty();
		$lstAdultSizeGroup = $this->getOneField('list_group_size', $pvalTable);

		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);

		return $max_adult;
	}
	function getMaxChild($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'max_child');
		return $one['max_child'];
	}
	function getBedOption($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'bed_size');
		return $one['bed_size'];
	}
	function getCabinSize($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'cabin_size');
		return $one['cabin_size'];
	}
	function getFloor($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'floor');
		return $one['floor'];
	}
	function getCabinView($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'cabin_view');
		return $one['cabin_view'];
	}
	function getTotalCabin($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'number_cabin');
		return $one['number_cabin'];
	}
	function getTaxesFees($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'taxes_fees');
		return $one['taxes_fees'];
	}
	function checkExist($cruise_id = 0, $slug = '')
	{
		$res = $this->getAll("cruise_id='$cruise_id' and slug='$slug' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function getExtraBed($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable);
		if ($one['extra_bed'] == 1)
			return 'YES';
		return 'NO';
	}
	function getPrice($cruise_cabin_id = 0, $cruise_itinerary_id = 0, $cabin_type_id = 0, $season = 'low', $type = '')
	{
		global $core, $clsISO;
		#
		$clsCruiseSeasonPrice = new CruiseSeasonPrice();
		$cond = "is_hide=0 and season = '" . $season . "'";
		if (intval($cruise_cabin_id) > 0) {
			$cond .= " and cruise_cabin_id = '$cruise_cabin_id'";
		}
		if (intval($cruise_itinerary_id) > 0) {
			$cond .= " and cruise_itinerary_id = '$cruise_itinerary_id'";
		}
		if (intval($cabin_type_id) > 0) {
			$cond .= " and cabin_type_id = '$cabin_type_id'";
		}
		#
		$res = $clsCruiseSeasonPrice->getAll($cond);
		if (!empty($res) && intval($res[0]['price']) > 0) {
			$price = $res[0]['price'];
			if (intval($price) > 0) {
				switch ($type) {
					case '1':
						return '<strong>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($price) . '</strong>/' . $core->get_Lang('person');
						break;
					case '2':
						return $clsISO->getRate() . ' ' . $clsISO->formatPrice($price);
						break;
					default:
						return $price;
						break;
				}
			}
		}
		return '0.00';
	}
	function getPriceCruiseCabin($cruise_cabin_id = 0, $cruise_itinerary_id = 0, $cabin_type_id = 0, $season = '', $num_adult = '')
	{
		global $core, $clsISO, $clsConfiguration;
		$clsProperty = new Property();
		$assign_list['clsProperty'] = $clsProperty;
		#
		$clsCruiseSeasonPrice = new CruiseSeasonPrice();
		$cond = "is_hide=0 and season = '" . $season . "'";
		if (intval($cruise_cabin_id) > 0) {
			$cond .= " and cruise_cabin_id = '$cruise_cabin_id'";
		}
		if (intval($cruise_itinerary_id) > 0) {
			$cond .= " and cruise_itinerary_id = '$cruise_itinerary_id'";
		}
		if (intval($cabin_type_id) > 0) {
			$cond .= " and cabin_type_id = '$cabin_type_id'";
		}
		#
		$res = $clsCruiseSeasonPrice->getAll($cond);
		if (!empty($res) && intval($res[0]['price']) > 0) {
			$price = $res[0]['price'];
			$price = $price * $num_adult;
			if (intval($price) > 0) {
				return $clsISO->getRate() . ' ' . $clsISO->formatPrice($price);
			}
		}
		return '0.00';
	}
	function getValuePriceCruiseCabin($cruise_cabin_id = 0, $cruise_itinerary_id = 0, $cabin_type_id = 0, $season = '', $num_adult = '')
	{
		global $core, $clsISO, $clsConfiguration;
		$clsProperty = new Property();
		$assign_list['clsProperty'] = $clsProperty;
		#
		$clsCruiseSeasonPrice = new CruiseSeasonPrice();
		$cond = "is_hide=0 and season = '" . $season . "'";
		if (intval($cruise_cabin_id) > 0) {
			$cond .= " and cruise_cabin_id = '$cruise_cabin_id'";
		}
		if (intval($cruise_itinerary_id) > 0) {
			$cond .= " and cruise_itinerary_id = '$cruise_itinerary_id'";
		}
		if (intval($cabin_type_id) > 0) {
			$cond .= " and cabin_type_id = '$cabin_type_id'";
		}
		#
		$res = $clsCruiseSeasonPrice->getAll($cond);
		if (!empty($res) && intval($res[0]['price']) > 0) {
			$price = $res[0]['price'];
			$price = $price * $num_adult;
			if (intval($price) > 0) {
				return $clsISO->formatPrice($price);
			}
		}
		return '0.00';
	}
	function getPriceValue($cruise_cabin_id = 0)
	{

		global $core, $clsISO;
		#
		$one = $this->getOne($cruise_cabin_id, 'price');
		$price = $one['price'];
		#
		if (intval($price) > 0) {
			switch ($type) {
				case '1':
					return '<strong>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($price) . '</strong>/' . $core->get_Lang('person');
					break;
				case '2':
					return $clsISO->getRate() . ' ' . $clsISO->formatPrice($price);
					break;
				default:
					return $price;
					break;
			}
		}
		return '0.00';
	}
	function getPriceDefault($cruise_cabin_id = 0)
	{

		global $core, $clsISO, $clsConfiguration;
		$clsProperty = new Property();
		$assign_list['clsProperty'] = $clsProperty;
		#
		$one = $this->getOne($cruise_cabin_id, 'price');
		$price = $one['price'];
		#
		if (intval($price) > 0) {
			switch ($type) {
				case '1':
					return '<strong>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($price) . '</strong>/' . $core->get_Lang('person');
					break;
				case '2':
					return $clsISO->getRate() . ' ' . $clsISO->formatPrice($price);
					break;
				default:
					return $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $price;
					break;
			}
		}
		return '0.00';
	}

	function getLTripPriceCabin($pvalTable = 0, $cruise_itinerary_id = 0, $now_month = '', $number_adult = 0, $type = "Default")
	{
		global $core, $dbconn, $clsISO, $clsConfiguration, $departure_date;
		//return $num_day;
		$clsPromotion = new Promotion();
		$clsCruiseProperty = new CruiseProperty();
		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}

		$lstAdultSizeGroup = $this->getOneField('list_group_size', $pvalTable);

		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);
		$number_cabin = ceil($number_adult / $max_adult);
		if ($number_adult > $max_adult) {
			$group_size_id_1 = $lastAdultSize;
			$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
			$price = $dbconn->GetOne($SQL);
			$number_adult2 = fmod($number_adult, $max_adult);
			$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult2' order by order_no ASC limit 0,1");
			$group_size_id_2 = $one_cruise_property_id[0]['cruise_property_id'];
			$priceAdult1 = $price * ($number_adult - $number_adult2);

			$SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_2'";
			$price2 = $dbconn->GetOne($SQL2);
			$priceAdult2 = $price2 * ($number_adult2);
		} else {

			$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
			$group_size_id_2 = $one_cruise_property_id[0]['cruise_property_id'];

			$SQL3 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_2'";
			$price3 = $dbconn->GetOne($SQL3);
			$priceAdult1 = $price3 * $number_adult;
		}
		$Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Cruise' and cruise_itinerary_id='$cruise_itinerary_id'";
		$promotion = $dbconn->GetOne($Sql_Promotion);

		if ($priceAdult2 > 0) {
			$totalPrice = $priceAdult1 + $priceAdult2;
		} else {
			$totalPrice = $priceAdult1;
		}
		$pricePromotion = $totalPrice - ($totalPrice * $promotion / 100);
		if ($type == 'DetailBest') {
			$html = '<div class="priceCheckrate text-right">
				<p class="reco">' . $core->get_Lang('Recommended for you') . '</p>
				<p class="price_trip"><del>  $' . $totalPrice . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>
				<div class="has-feedback color_144aa8">' . $core->get_Lang('Includes Taxes &amp; Fees') . '</div>
				<div class="cond-sup" style="display:none">
					<p>' . $this->getTaxesFees($pvalTable) . '</p>
				</div>
				<p class="thumbs-o-up color_2db300 bold"><i class="fa fa-thumbs-o-up"></i>' . $core->get_Lang('Best Value!') . '</p>
				<p class="fontSize12">*Price for ' . $number_cabin . ' cabin ' . $number_adult . ' Adults</p>
			</div>
			<form method="post" action="" class="form-inline">
				<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
				<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
				<input type="hidden" name="number_adult" value="' . $number_adult . '">
				<input type="hidden" name="number_cabin" value="' . $number_cabin . '">
				<input type="hidden" name="totalPrice" value="' . $pricePromotion . '">
				<input type="hidden" name="departure_date" value="' . $departure_date . '">
				<button type="submit" style="width:120px" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Booking') . '</button>
				<input type="hidden" name="BookingCabin" value="BookingCabin">
			</form>
			';
		} elseif ($type == 'Detail') {
			$html = '<div class="priceCheckrate text-right">
				<p class="price_trip"><del>  $' . $totalPrice . '</del> <span> $' . $clsISO->formatPrice($pricePromotion, 2) . '</span></p>
				<div class="has-feedback color_144aa8">' . $core->get_Lang('Includes Taxes &amp; Fees') . '</div>
				<div class="cond-sup" style="display:none">
					<p>' . $this->getTaxesFees($pvalTable) . '</p>
				</div>
				<p class="fontSize12">*Price for ' . $number_cabin . ' cabin ' . $number_adult . ' Adults</p>
			</div>
			<form method="post" action="" class="form-inline">
				<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
				<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
				<input type="hidden" name="number_adult" value="' . $number_adult . '">
				<input type="hidden" name="number_cabin" value="' . $number_cabin . '">
				<input type="hidden" name="totalPrice" value="' . $pricePromotion . '">
				<button type="submit" style="width:120px" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Booking') . '</button>
				<input type="hidden" name="BookingCabin" value="BookingCabin">
			</form>';
		} else {
			$html = '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  $' . $totalPrice . '</span> <label> $' . $clsISO->formatPrice($pricePromotion, 2) . '</label></span>';
		}
		return $html;
	}
	function getLCheckRatePriceCabinold($pvalTable = 0, $arraycheckrateCabin = [], $type = "Default", $promotion_date = 0)
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration, $departure_date;
		$clsPromotion = new Promotion();
		$clsCruiseProperty = new CruiseProperty();
		$now_month = date('m', $promotion_date);
		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}
		$infantFares = $clsConfiguration->getValue('InfantFaresPolicy');
		$childFares = $clsConfiguration->getValue('ChildFaresPolicy');
		$maxInfant = $clsConfiguration->getValue('InfantMaxAgePolicy');
		$maxChild = $clsConfiguration->getValue('ChildMaxAgePolicy');

		$lstAdultSizeGroup = $this->getOneField('list_group_size', $pvalTable);
		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);

		vnSessionSetVar('arraycheckrateCabin', $arraycheckrateCabin);
		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];
		$totalChild = $arraycheckrateCabin['number_child'];
		$totalAdult = $arraycheckrateCabin['number_adult'];
		$totalCabin = $arraycheckrateCabin['number_cabin'];
		$totalCabin2 = 0;


		$number_infant_price = 0;
		$number_child_price = 0;
		$priceChild = 0;
		$priceInfant = 0;
		for ($i = 1; $i <= $arraycheckrateCabin['number_cabin']; $i++) {
			$number_adult = $arraycheckrateCabin['number_adult_' . $i];
			if ($number_adult <= $max_adult) {
				$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
				$group_size_id = $one_cruise_property_id[0]['cruise_property_id'];
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id'";
				$priceOneAdult = $dbconn->getOne($SQL);
				$priceAdult += $priceOneAdult * $number_adult;

				$priceOneChild = ($childFares / 100) * $priceOneAdult;

				if ($arraycheckrateCabin['number_child'] > 0 && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}

				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}

				$totalCabin2 = $totalCabin2 + 1;
			} else {
				$number_cabin += ceil($number_adult / $max_adult);
				$group_size_id_1 = $lastAdultSize;
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
				$price = $dbconn->GetOne($SQL);

				$number_adult2 = fmod($number_adult, $max_adult);

				$one_cruise_property_id2 = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult2' order by order_no ASC limit 0,1");
				$group_size_id_2 = $one_cruise_property_id2[0]['cruise_property_id'];
				$priceAdult1 += $price * ($number_adult - $number_adult2);

				$priceOneChild = ($childFares / 100) * $price;

				if ($arraycheckrateCabin['number_child'] > 0) {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}
				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}


				$SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_2'";
				$price2 = $dbconn->GetOne($SQL2);

				$priceAdult2 += $price2 * ($number_adult2);
			}
		}


		$totalCabin = $totalCabin2 + $number_cabin;
		//$totalPriceCabin=$number_child_price.$priceChild;
		$totalPriceCabin = $priceAdult + $priceAdult1 + $priceAdult2 + $priceChild + $priceInfant;
		if ($type == 'value') {
			return $totalPriceCabin;
			die();
		}
		$Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Cruise' and cruise_itinerary_id='$cruise_itinerary_id' and " . $promotion_date . " between start_date and end_date order by start_date ASC limit 0,1";
		$promotion = $dbconn->GetOne($Sql_Promotion);
		if ($totalPriceCabin > 0) {
			if ($type == 'DetailBest') {
				if ($promotion > 0) {
					$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);
					$html = '<div class="priceCheckrate text-right">
						<p class="reco" lang_id="' . $_LANG_ID . '">' . $core->get_Lang('Recommended for you') . '</p>';
					if ($_LANG_ID == 'vn') {
						$html .= '<p class="price_trip"><del>' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</del> <span> ' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '<p class="price_trip"><del>' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>';
					}


					$html .= '<p class="thumbs-o-up color_2db300 bold"><i class="fa fa-thumbs-o-up"></i>' . $core->get_Lang('Best Value') . '!</p>
						<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $pricePromotion . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				} else {
					$html = '<div class="priceCheckrate text-right">
						<p class="reco">' . $core->get_Lang('Recommended for you') . '</p>';
					if ($_LANG_ID == 'vn') {
						$html .= '
						<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '
						<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
					}

					$html .= '<p class="thumbs-o-up color_2db300 bold"><i class="fa fa-thumbs-o-up"></i>' . $core->get_Lang('Best Value') . '!</p>
						<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				}
			} elseif ($type == 'Detail') {
				if ($promotion > 0) {
					$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);
					$html = '<div class="priceCheckrate text-right">';
					if ($_LANG_ID == 'vn') {
						$html .= '
						<p class="price_trip"><del>  ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</del> <span> ' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '
						<p class="price_trip"><del>  ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>';
					}
					$html .= '<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $pricePromotion . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				} else {
					$html = '<div class="priceCheckrate text-right">';
					if ($_LANG_ID == 'vn') {
						$html .= '<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
					}
					$html .= '<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				}
			} elseif ($type == 'DetailBestnomal') {
				$html = '<div class="priceCheckrate text-right">
						<p class="reco">' . $core->get_Lang('Recommended for you') . '</p>';
				if ($_LANG_ID == 'vn') {
					$html .= '
						<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '
						<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
				}

				$html .= '<p class="thumbs-o-up color_2db300 bold"><i class="fa fa-thumbs-o-up"></i>' . $core->get_Lang('Best Value') . '!</p>
						<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
			} elseif ($type == 'Detailnomal') {
				$html = '<div class="priceCheckrate text-right">';
				if ($_LANG_ID == 'vn') {
					$html .= '<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
				}
				$html .= '<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
			} else {
				if ($_LANG_ID == 'vn') {
					$html = '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span> <label> ' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</label></span>';
				} else {
					$html = '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 2, ",", ".") . '</span> <label> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</label></span>';
				}
			}
		} else {
			return '<div class="priceCheckrate text-right"><a class="contact entry_btn_check_book btn_main" href="' . $clsISO->getLink('contacts') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a></div>';
		}
		return $html;
	}
	function getLCheckRatePriceCabin($pvalTable = 0, $arraycheckrateCabin = [], $type = "Default", $promotion_date = 0, $cruise_id = 0)
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration, $departure_date;
		$clsPromotion = new Promotion();
		$clsPromotionItem = new PromotionItem();
		$clsCruiseProperty = new CruiseProperty();

		$promotion_timestamp = is_numeric($promotion_date)
			? (int)$promotion_date
			: strtotime($promotion_date);

		$now_month = date('m', $promotion_timestamp);

		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}
		$infantFares = $clsConfiguration->getValue('InfantFaresPolicy');
		$childFares = $clsConfiguration->getValue('ChildFaresPolicy');
		$maxInfant = $clsConfiguration->getValue('InfantMaxAgePolicy');
		$maxChild = $clsConfiguration->getValue('ChildMaxAgePolicy');

		$lstAdultSizeGroup = $this->getOneField('list_group_size', $pvalTable);
		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);

		vnSessionSetVar('arraycheckrateCabin', $arraycheckrateCabin);
		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];
		$totalChild = $arraycheckrateCabin['number_child'];
		$totalAdult = $arraycheckrateCabin['number_adult'];
		$totalCabin = $arraycheckrateCabin['number_cabin'];
		$totalCabin2 = 0;


		$number_infant_price = 0;
		$number_child_price = 0;
		$priceAdult = 0;
		$priceAdult1 = 0;
		$priceAdult2 = 0;
		$priceChild = 0;
		$number_cabin = 0;

		$priceInfant = 0;
		for ($i = 1; $i <= $arraycheckrateCabin['number_cabin']; $i++) {
			$number_adult = $arraycheckrateCabin['number_adult_' . $i];

			if ($number_adult <= $max_adult) {
				$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
				$group_size_id = $one_cruise_property_id[0]['cruise_property_id'];
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id'";
				$priceOneAdult = $dbconn->getOne($SQL);
				$priceAdult += $priceOneAdult * $number_adult;

				$priceOneChild = ($childFares / 100) * $priceOneAdult;

				if ($arraycheckrateCabin['number_child'] > 0 && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}

				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}

				$totalCabin2 = $totalCabin2 + 1;
			} else {
				$number_cabin += ceil($number_adult / $max_adult);
				$group_size_id_1 = $lastAdultSize;
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
				$price = $dbconn->GetOne($SQL);

				$number_adult2 = fmod($number_adult, $max_adult);

				$one_cruise_property_id2 = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult2' order by order_no ASC limit 0,1");
				$group_size_id_2 = $one_cruise_property_id2[0]['cruise_property_id'];
				$priceAdult1 += $price * ($number_adult - $number_adult2);

				$priceOneChild = ($childFares / 100) * $price;

				if ($arraycheckrateCabin['number_child'] > 0) {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}
				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}


				$SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_2'";
				$price2 = $dbconn->GetOne($SQL2);

				$priceAdult2 += $price2 * ($number_adult2);
			}
		}


		$totalCabin = $totalCabin2 + $number_cabin;
		//$totalPriceCabin=$number_child_price.$priceChild;
		$totalPriceCabin = $priceAdult + $priceAdult1 + $priceAdult2 + $priceChild + $priceInfant;
		if ($type == 'value') {
			return $totalPriceCabin;
			die();
		}
		//		$Sql_Promotion = "SELECT promot FROM ".DB_PREFIX."promotion WHERE clsTable='Cruise' and cruise_itinerary_id='$cruise_itinerary_id' and ".$promotion_date." between start_date and end_date order by start_date ASC limit 0,1";
		//		$promotion= $dbconn->GetOne($Sql_Promotion);
		$Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE pi.is_online = 1 and p.is_online = 1 and p.type = 'Cruise' and pi.taget_id =$cruise_id and pi.cruise_intinerary=$cruise_itinerary_id and " . $promotion_date . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";;
		$promotion = $dbconn->GetOne($Sql_Promotion);
		//        return $Sql_Promotion;
		if ($totalPriceCabin > 0) {
			if ($type == 'DetailBest') {
				if ($promotion > 0) {
					$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);
					$html = '<div class="priceCheckrate text-right">
						<p class="reco" lang_id="' . $_LANG_ID . '">' . $core->get_Lang('Recommended for you') . '</p>';
					if ($_LANG_ID == 'vn') {
						$html .= '<p class="price_trip"><del>' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</del> <span> ' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '<p class="price_trip"><del>' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>';
					}


					$html .= '<p class="thumbs-o-up color_2db300 bold"><i class="fa fa-thumbs-o-up"></i>' . $core->get_Lang('Best Value') . '!</p>
						<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $pricePromotion . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				} else {
					$html = '<div class="priceCheckrate text-right">
						<p class="reco">' . $core->get_Lang('Recommended for you') . '</p>';
					if ($_LANG_ID == 'vn') {
						$html .= '
						<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '
						<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
					}

					$html .= '<p class="thumbs-o-up color_2db300 bold"><i class="fa fa-thumbs-o-up"></i>' . $core->get_Lang('Best Value') . '!</p>
						<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				}
			} elseif ($type == 'Detail') {
				if ($promotion > 0) {
					$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);
					$html = '<div class="priceCheckrate text-right">';
					if ($_LANG_ID == 'vn') {
						$html .= '
						<p class="price_trip"><del>  ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</del> <span> ' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '
						<p class="price_trip"><del>  ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>';
					}
					$html .= '<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $pricePromotion . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				} else {
					$html = '<div class="priceCheckrate text-right">';
					if ($_LANG_ID == 'vn') {
						$html .= '<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
					} else {
						$html .= '<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
					}
					$html .= '<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
				}
			} elseif ($type == 'DetailBestnomal') {
				$html = '<div class="priceCheckrate text-right">
						<p class="reco">' . $core->get_Lang('Recommended for you') . '</p>';
				if ($_LANG_ID == 'vn') {
					$html .= '
						<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '
						<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
				}

				$html .= '<p class="thumbs-o-up color_2db300 bold"><i class="fa fa-thumbs-o-up"></i>' . $core->get_Lang('Best Value') . '!</p>
						<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
			} elseif ($type == 'Detailnomal') {
				$html = '<div class="priceCheckrate text-right">';
				if ($_LANG_ID == 'vn') {
					$html .= '<p class="price_trip"><span> ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
				}
				$html .= '<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
					</div>
					<form method="post" action="" class="form-inline">
						<input type="hidden" name="arraycheckrateCabin" value="' . $arraycheckrateCabin . '">
						<input type="hidden" name="cruise_itinerary_id" value="' . $cruise_itinerary_id . '">
						<input type="hidden" name="cruise_cabin_id" value="' . $pvalTable . '">
						<input type="hidden" name="number_child" value="' . $totalChild . '">
						<input type="hidden" name="number_adult" value="' . $totalAdult . '">
						<input type="hidden" name="number_cabin" value="' . $totalCabin . '">
						<input type="hidden" name="totalPrice" value="' . $totalPriceCabin . '">
						<input type="hidden" name="departure_date" value="' . $departure_date . '">
						<input type="hidden" name="max_adult" value="' . $max_adult . '">
						<button type="submit" class="entry_btn_check_book btn_main pull-right" id="bookingCabin' . $pvalTable . '">' . $core->get_Lang('Check availablity &amp; book') . '</button>
						<input type="hidden" name="BookingCabin" value="BookingCabin">
					</form>
					';
			} else {
				if ($_LANG_ID == 'vn') {
					$html = '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  ' . number_format($totalPriceCabin, 0, ",", ".") . $clsISO->getShortRate() . '</span> <label> ' . number_format($pricePromotion, 0, ",", ".") . $clsISO->getShortRate() . '</label></span>';
				} else {
					$html = '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 2, ",", ".") . '</span> <label> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</label></span>';
				}
			}
		} else {
			return '<div class="priceCheckrate text-right"><a class="contact entry_btn_check_book btn_main" href="' . $clsISO->getLink('contacts') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a></div>';
		}
		return $html;
	}
	function getCheckRatePriceCabinCruise($pvalTable = 0, $arraycheckrateCabin = [], $promotion_date = 0, $cruise_id = 0, $index = 1, $type = 'no_promotion')
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration, $departure_date, $now_day;
		$clsPromotion = new Promotion();
		$clsPromotionItem = new PromotionItem();
		$clsCruiseProperty = new CruiseProperty();

		$now_month = date('m', $promotion_date);

		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}
		$infantFares = $clsConfiguration->getValue('InfantFaresPolicy');
		$childFares = $clsConfiguration->getValue('ChildFaresPolicy');
		$maxInfant = $clsConfiguration->getValue('InfantMaxAgePolicy');
		$maxChild = $clsConfiguration->getValue('ChildMaxAgePolicy');

		$lstAdultSizeGroup = $this->getOneField('list_group_size', $pvalTable);
		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);

		vnSessionSetVar('arraycheckrateCabin', $arraycheckrateCabin);
		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];
		$totalChild = $arraycheckrateCabin['number_child_' . $index];
		$totalAdult = $arraycheckrateCabin['number_adult_' . $index];
		$totalCabin = $arraycheckrateCabin['number_cabin'];


		$number_infant_price = 0;
		$number_child_price = 0;
		$priceAdult = 0;
		$priceAdult1 = 0;
		$priceAdult2 = 0;
		$priceChild = 0;
		$number_cabin = 0;

		$priceInfant = 0;
		$number_adult = $arraycheckrateCabin['number_adult_' . $index];
		$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
		$group_size_id = $one_cruise_property_id[0]['cruise_property_id'];
		$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id'";
		$priceOneAdult = $dbconn->getOne($SQL);
		$priceAdult += $priceOneAdult * $number_adult;

		$priceOneChild = ($childFares / 100) * $priceOneAdult;


		if ($arraycheckrateCabin['number_child'] > 0 && $arraycheckrateCabin['infant' . $index . 's_1'] != '') {
			if ($arraycheckrateCabin['infant' . $index . 's_1'] > $maxInfant && $arraycheckrateCabin['infant' . $index . 's_1'] <= $maxChild) {
				$number_child_price = $number_child_price + 1;
			}
			if ($arraycheckrateCabin['infant' . $index . 's_2'] > $maxInfant && $arraycheckrateCabin['infant' . $index . 's_1'] <= $maxChild && $arraycheckrateCabin['infant' . $index . 's_2'] != '') {
				$number_child_price = $number_child_price + 1;
			}
			if ($infantFares > 0) {
				if ($arraycheckrateCabin['infant' . $index . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $index . 's_1'] != '') {
					$number_infant_price = $number_infant_price + 1;
				}
				if ($arraycheckrateCabin['infant' . $index . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $index . 's_2'] != '') {
					$number_infant_price = $number_infant_price + 1;
				}
				$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
			}
		}

		if ($number_child_price > 0) {
			$priceChild = $priceOneChild * $number_child_price;
		}

		if ($number_infant_price > 0) {
			$priceInfant = $priceOneInfant * $number_infant_price;
		}

		//$totalPriceCabin=$number_child_price.$priceChild;
		//		var_dump($priceAdult,$priceAdult1,$priceAdult2,$priceChild,$priceInfant);die;
		$totalPriceCabin = $priceAdult + $priceAdult1 + $priceAdult2 + $priceChild + $priceInfant;
		if ($type == 'value') {
			return $totalPriceCabin;
		}

		$discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $promotion_date, 'info_promotion');
		$promotion = $discount['discount_value'];
		$promotion = str_replace('.', '', $promotion);
		$discount_type = $discount['discount_type'];


		if ($totalPriceCabin > 0) {
			if ($promotion > 0 && $type != 'no_promotion') {
				if ($discount_type == 2) {
					$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);
					$promotion_price_value = $totalPriceCabin * $discount_value / 100;
				} else {
					$pricePromotion = $totalPriceCabin - $promotion;
					$promotion_price_value = $promotion;
				}

				$html = '<div class="priceCheckrate">
				<div class="col_price">';
				if ($_LANG_ID == 'vn') {
					$html .= '<p class="price_trip"><del>' . number_format($totalPriceCabin, 0, ",", ".") . ' ' . $clsISO->getShortRateText() . '</del> <span> ' . number_format($pricePromotion, 0, ",", ".") . ' ' . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '<p class="price_trip"><del>' . $clsISO->getShortRateText() . number_format($totalPriceCabin, 0, ",", ".") . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>';
				}
				$html .= '
					<p class="size12">*' . $core->get_Lang('Price for') . ' 1 ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
				</div>
				<div class="col_btn">
					<a data-cruise_id="' . $cruise_id . '" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" data-cruise_cabin_id="' . $pvalTable . '"  data-number_adult="' . $totalAdult . '" data-number_child="' . $totalChild . '" data-number_cabin="1" data-totalPrice="' . $totalPriceCabin . '" data-departure_date="' . $departure_date . '" data-max_adult="' . $max_adult . '" data-promotion_price_value="' . $promotion_price_value . '" data-choose_index="itemCabin_' . $pvalTable . '_' . $index . '" class="cabin_selected btn_main">
					' . $core->get_Lang('Choose') . '
					</a>
				</div>
				</div>
				';
			} else {
				$html = '<div class="priceCheckrate">
				<div class="col_price">';

				if ($_LANG_ID == 'vn') {
					$html .= '
					<p class="price_trip"><span>' . number_format($totalPriceCabin, 0, ",", ".") . ' ' . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '
					<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
				}

				$html .= '
					<p class="size12">*' . $core->get_Lang('Price for') . ' 1 ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
				</div>
				<div class="col_btn">
					<a data-cruise_id="' . $cruise_id . '" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" data-cruise_cabin_id="' . $pvalTable . '"  data-number_adult="' . $totalAdult . '" data-number_child="' . $totalChild . '" data-number_cabin="1" data-totalPrice="' . $totalPriceCabin . '" data-departure_date="' . $departure_date . '" data-max_adult="' . $max_adult . '" data-promotion_price_value="0" data-choose_index="itemCabin_' . $pvalTable . '_' . $index . '" class="cabin_selected btn_main">
					' . $core->get_Lang('Choose') . '
					</a>
				</div>
				</div>
				';
			}
		} else {
			return '<p class="size12 mt10 mb0">*' . $core->get_Lang('Price for') . ' 1 ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p><div class="priceCheckrate text-right"><button class="contact entry_btn_check_book btn_main" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </button></div>';
		}
		return $html;
	}
	function getLCheckRatePriceCabinCruise($pvalTable = 0, $arraycheckrateCabin = [], $promotion_date = 0, $cruise_id = 0)
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration, $departure_date, $now_day;
		$clsPromotion = new Promotion();
		$clsPromotionItem = new PromotionItem();
		$clsCruiseProperty = new CruiseProperty();

		$now_month = date('m', $promotion_date);

		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}
		$infantFares = $clsConfiguration->getValue('InfantFaresPolicy');
		$childFares = $clsConfiguration->getValue('ChildFaresPolicy');
		$maxInfant = $clsConfiguration->getValue('InfantMaxAgePolicy');
		$maxChild = $clsConfiguration->getValue('ChildMaxAgePolicy');

		$lstAdultSizeGroup = $this->getOneField('list_group_size', $pvalTable);
		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);

		vnSessionSetVar('arraycheckrateCabin', $arraycheckrateCabin);
		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];
		$totalChild = $arraycheckrateCabin['number_child'];
		$totalAdult = $arraycheckrateCabin['number_adult'];
		$totalCabin = $arraycheckrateCabin['number_cabin'];
		$totalCabin2 = 0;


		$number_infant_price = 0;
		$number_child_price = 0;
		$priceAdult = 0;
		$priceAdult1 = 0;
		$priceAdult2 = 0;
		$priceChild = 0;
		$number_cabin = 0;

		$priceInfant = 0;
		for ($i = 1; $i <= $arraycheckrateCabin['number_cabin']; $i++) {
			$number_adult = $arraycheckrateCabin['number_adult_' . $i];
			if ($number_adult <= $max_adult) {
				$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
				$group_size_id = $one_cruise_property_id[0]['cruise_property_id'];
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id'";
				$priceOneAdult = $dbconn->getOne($SQL);
				$priceAdult += $priceOneAdult * $number_adult;

				$priceOneChild = ($childFares / 100) * $priceOneAdult;

				if ($arraycheckrateCabin['number_child'] > 0 && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}

				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}

				$totalCabin2 = $totalCabin2 + 1;
			} else {
				$number_cabin += ceil($number_adult / $max_adult);
				$group_size_id_1 = $lastAdultSize;
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
				$price = $dbconn->GetOne($SQL);

				$number_adult2 = fmod($number_adult, $max_adult);

				$one_cruise_property_id2 = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult2' order by order_no ASC limit 0,1");
				$group_size_id_2 = $one_cruise_property_id2[0]['cruise_property_id'];
				$priceAdult1 += $price * ($number_adult - $number_adult2);

				$priceOneChild = ($childFares / 100) * $price;

				if ($arraycheckrateCabin['number_child'] > 0) {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}
				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}


				$SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_2'";
				$price2 = $dbconn->GetOne($SQL2);
				if (empty($price2)) {
					$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
					$price2 = $dbconn->GetOne($SQL);
				}

				$priceAdult2 += $price2 * ($number_adult2);
			}
		}


		$totalCabin = $totalCabin2 + $number_cabin;
		//$totalPriceCabin=$number_child_price.$priceChild;
		//		var_dump($priceAdult,$priceAdult1,$priceAdult2,$priceChild,$priceInfant);die;
		$totalPriceCabin = $priceAdult + $priceAdult1 + $priceAdult2 + $priceChild + $priceInfant;
		if ($type == 'value') {
			return $totalPriceCabin;
		}

		$discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $promotion_date, 'info_promotion');
		$promotion = $discount['discount_value'];


		if ($totalPriceCabin > 0) {
			if ($promotion > 0) {
				$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);
				$html = '<div class="priceCheckrate">
				<div class="col_price">';
				if ($_LANG_ID == 'vn') {
					$html .= '<p class="price_trip"><del>' . number_format($totalPriceCabin, 0, ",", ".") . ' ' . $clsISO->getShortRateText() . '</del> <span> ' . number_format($pricePromotion, 0, ",", ".") . ' ' . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '<p class="price_trip"><del>' . $clsISO->getShortRateText() . number_format($totalPriceCabin, 0, ",", ".") . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>';
				}
				$html .= '
					<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
				</div>
				<div class="col_btn">
					<a data-cruise_id="' . $cruise_id . '" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" data-cruise_cabin_id="' . $pvalTable . '"  data-number_adult="' . $totalAdult . '" data-number_child="' . $totalChild . '" data-number_cabin="' . $totalCabin . '" data-totalPrice="' . $totalPriceCabin . '" data-departure_date="' . $departure_date . '" data-max_adult="' . $max_adult . '" class="cabin_selected btn_main">
					' . $core->get_Lang('Choose') . '
					</a>
				</div>
				</div>
				';
			} else {
				$html = '<div class="priceCheckrate">
				<div class="col_price">';

				if ($_LANG_ID == 'vn') {
					$html .= '
					<p class="price_trip"><span>' . number_format($totalPriceCabin, 0, ",", ".") . ' ' . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '
					<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
				}

				$html .= '
					<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
				</div>
				<div class="col_btn">
					<a data-cruise_id="' . $cruise_id . '" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" data-cruise_cabin_id="' . $pvalTable . '"  data-number_adult="' . $totalAdult . '" data-number_child="' . $totalChild . '" data-number_cabin="' . $totalCabin . '" data-totalPrice="' . $totalPriceCabin . '" data-departure_date="' . $departure_date . '" data-max_adult="' . $max_adult . '" class="cabin_selected btn_main">
					' . $core->get_Lang('Choose') . '
					</a>
				</div>
				</div>
				';
			}
		} else {
			/*return '<div class="priceCheckrate text-right"><a class="contact entry_btn_check_book btn_main" href="'.$clsISO->getLink('contacts').'" title="'.$core->get_Lang('Contact').'">'.$core->get_Lang('Contact').' </a></div>';*/

			return '<div class="priceCheckrate text-right"><button class="contact entry_btn_check_book btn_main" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </button></div>';
		}
		return $html;
	}

	function getArrayPriceCabinCruise($pvalTable = 0, $arraycheckrateCabin = [], $promotion_date = 0, $cruise_id = 0)
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration, $departure_date, $now_day;
		$clsPromotion = new Promotion();
		$clsPromotionItem = new PromotionItem();
		$clsCruiseProperty = new CruiseProperty();

		$now_month = date('m', $promotion_date);

		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}

		vnSessionSetVar('arraycheckrateCabin', $arraycheckrateCabin);
		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];

		$discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $promotion_date, 'info_promotion');
		$promotion = $discount['discount_value'];

		$check_contact = 0;

		//price adult
		$number_adult = $arraycheckrateCabin['number_adult'];
		if ($number_adult > 0) {
			$one_cruise_property_id_adult = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
			if ($one_cruise_property_id_adult) {
				$group_size_id_adult = $one_cruise_property_id_adult[0]['cruise_property_id'];
				$SQL_adult = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_adult'";
				$priceOneAdult = $dbconn->getOne($SQL_adult);
				$totalPriceCabin_adult = $priceOneAdult;
				if ($totalPriceCabin_adult > 0) {
					if ($promotion > 0) {
						if ($discount['discount_type'] == 2) {
							$pricePromotion_adult = $totalPriceCabin_adult - ($totalPriceCabin_adult * $promotion / 100);
						} else {
							$pricePromotion_adult = $totalPriceCabin_adult - $promotion;
						}
						$priceAdult = ($pricePromotion_adult > 0) ? $pricePromotion_adult : $totalPriceCabin_adult;
					} else {
						$priceAdult = $totalPriceCabin_adult;
					}
				} else {
					$priceAdult = "";
					$check_contact = 1;
				}
			}
		}


		//price child
		$number_child = $arraycheckrateCabin['number_child'];
		if ($number_child > 0) {
			$one_cruise_property_id_child = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSizeChild' and number_child='$number_child' order by order_no ASC limit 0,1");

			if ($one_cruise_property_id_child) {
				$group_size_id_child = $one_cruise_property_id_child[0]['cruise_property_id'];
				$SQL_child = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_child'";
				$priceOneChild = $dbconn->getOne($SQL_child);
				$totalPriceCabin_child = $priceOneChild;

				if ($totalPriceCabin_child > 0) {
					if ($promotion > 0) {
						if ($discount['discount_type'] == 2) {
							$pricePromotion_child = $totalPriceCabin_child - ($totalPriceCabin_child * $promotion / 100);
						} else {
							$pricePromotion_child = $totalPriceCabin_child - $promotion;
						}
						$priceChild = ($pricePromotion_child > 0) ? $pricePromotion_child : $totalPriceCabin_child;
					} else {
						$priceChild = $totalPriceCabin_child;
					}
				} else {
					$check_contact = 1;
				}
			}
		}

		if ($check_contact == 1) {
			$total_price = "";
		} else {
			$total_price = 0;
			if (isset($priceAdult)) {
				$total_price += (int)$priceAdult * $number_adult;
			}
			if (isset($priceChild)) {
				$total_price += (int)$priceChild * $number_child;
			}
		}

		return [
			"priceAdult"	=>	$priceAdult,
			"priceChild"	=>	$priceChild,
			"total_price"	=>	$total_price,
		];
	}
	function getLCheckRatePriceCabinCruise3($pvalTable = 0, $arraycheckrateCabin = [], $promotion_date = 0, $cruise_id = 0, $type = "")
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration, $departure_date, $now_day;
		$clsPromotion = new Promotion();
		$clsPromotionItem = new PromotionItem();
		$clsCruiseProperty = new CruiseProperty();

		$now_month = date('m', $promotion_date);

		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}
		$infantFares = $clsConfiguration->getValue('InfantFaresPolicy');
		$childFares = $clsConfiguration->getValue('ChildFaresPolicy');
		$maxInfant = $clsConfiguration->getValue('InfantMaxAgePolicy');
		$maxChild = $clsConfiguration->getValue('ChildMaxAgePolicy');

		$lstAdultSizeGroup = $this->getOneField('list_group_size', $pvalTable);
		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);

		vnSessionSetVar('arraycheckrateCabin', $arraycheckrateCabin);
		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];
		$totalChild = $arraycheckrateCabin['number_child'];
		$totalAdult = $arraycheckrateCabin['number_adult'];
		$totalCabin = $arraycheckrateCabin['number_cabin'];
		$totalCabin2 = 0;


		$number_infant_price = 0;
		$number_child_price = 0;
		$priceAdult = 0;
		$priceAdult1 = 0;
		$priceAdult2 = 0;
		$priceChild = 0;
		$number_cabin = 0;

		$priceInfant = 0;
		for ($i = 1; $i <= $arraycheckrateCabin['number_cabin']; $i++) {
			$number_adult = $arraycheckrateCabin['number_adult_' . $i];
			if ($number_adult <= $max_adult) {
				$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
				$group_size_id = $one_cruise_property_id[0]['cruise_property_id'];
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id'";
				$priceOneAdult = $dbconn->getOne($SQL);
				$priceAdult += $priceOneAdult * $number_adult;

				$priceOneChild = ($childFares / 100) * $priceOneAdult;

				if ($arraycheckrateCabin['number_child'] > 0 && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] <= $maxChild && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}

				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}

				$totalCabin2 = $totalCabin2 + 1;
			} else {
				$number_cabin += ceil($number_adult / $max_adult);
				$group_size_id_1 = $lastAdultSize;
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
				$price = $dbconn->GetOne($SQL);

				$number_adult2 = fmod($number_adult, $max_adult);

				$one_cruise_property_id2 = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult2' order by order_no ASC limit 0,1");
				$group_size_id_2 = $one_cruise_property_id2[0]['cruise_property_id'];
				$priceAdult1 += $price * ($number_adult - $number_adult2);

				$priceOneChild = ($childFares / 100) * $price;

				if ($arraycheckrateCabin['number_child'] > 0) {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant) {
						$number_child_price = $number_child_price + 1;
					}
					if ($infantFares > 0) {
						if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
							$number_infant_price = $number_infant_price + 1;
						}
						$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
					}
				}
				if ($number_child_price > 0) {
					$priceChild = $priceOneChild * $number_child_price;
				}

				if ($number_infant_price > 0) {
					$priceInfant = $priceOneInfant * $number_infant_price;
				}


				$SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_2'";
				$price2 = $dbconn->GetOne($SQL2);
				if (empty($price2)) {
					$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
					$price2 = $dbconn->GetOne($SQL);
				}

				$priceAdult2 += $price2 * ($number_adult2);
			}
		}


		$totalCabin = $totalCabin2 + $number_cabin;
		//$totalPriceCabin=$number_child_price.$priceChild;
		//		var_dump($priceAdult,$priceAdult1,$priceAdult2,$priceChild,$priceInfant);die;
		$totalPriceCabin = $priceAdult + $priceAdult1 + $priceAdult2 + $priceChild + $priceInfant;

		$discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $promotion_date, 'info_promotion');
		$promotion = $discount['discount_value'];


		if ($totalPriceCabin > 0) {
			if ($promotion > 0) {
				$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);
				if ($type == "value") {
					return $pricePromotion;
				}
				$html = '<div class="priceCheckrate">
				<div class="col_price">';
				if ($_LANG_ID == 'vn') {
					$html .= '<p class="price_trip"><del>' . number_format($totalPriceCabin, 0, ",", ".") . ' ' . $clsISO->getShortRateText() . '</del> <span> ' . number_format($pricePromotion, 0, ",", ".") . ' ' . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '<p class="price_trip"><del>' . $clsISO->getShortRateText() . number_format($totalPriceCabin, 0, ",", ".") . '</del> <span> ' . $clsISO->getShortRate() . number_format($pricePromotion, 2, ",", ".") . '</span></p>';
				}
				$html .= '
					<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
				</div>
				<div class="col_btn">
					<a data-cruise_id="' . $cruise_id . '" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" data-cruise_cabin_id="' . $pvalTable . '"  data-number_adult="' . $totalAdult . '" data-number_child="' . $totalChild . '" data-number_cabin="' . $totalCabin . '" data-totalPrice="' . $totalPriceCabin . '" data-departure_date="' . $departure_date . '" data-max_adult="' . $max_adult . '" class="cabin_selected btn_main">
					' . $core->get_Lang('Choose') . '
					</a>
				</div>
				</div>
				';
			} else {
				if ($type == "value") {
					return $totalPriceCabin;
				}
				$html = '<div class="priceCheckrate">
				<div class="col_price">';

				if ($_LANG_ID == 'vn') {
					$html .= '
					<p class="price_trip"><span>' . number_format($totalPriceCabin, 0, ",", ".") . ' ' . $clsISO->getShortRate() . '</span></p>';
				} else {
					$html .= '
					<p class="price_trip"><span> ' . $clsISO->getShortRate() . number_format($totalPriceCabin, 0, ",", ".") . '</span></p>';
				}

				$html .= '
					<p class="size12">*' . $core->get_Lang('Price for') . ' ' . $totalCabin . ' ' . $core->get_Lang('cabin') . ' ' . $totalAdult . ' ' . $core->get_Lang('Adults') . ' ' . $totalChild . ' ' . $core->get_Lang('Child') . '</p>
				</div>
				<div class="col_btn">
					<a data-cruise_id="' . $cruise_id . '" data-cruise_itinerary_id="' . $cruise_itinerary_id . '" data-cruise_cabin_id="' . $pvalTable . '"  data-number_adult="' . $totalAdult . '" data-number_child="' . $totalChild . '" data-number_cabin="' . $totalCabin . '" data-totalPrice="' . $totalPriceCabin . '" data-departure_date="' . $departure_date . '" data-max_adult="' . $max_adult . '" class="cabin_selected btn_main">
					' . $core->get_Lang('Choose') . '
					</a>
				</div>
				</div>
				';
			}
		} else {
			if ($type == "value") {
				return 0;
			}
			return '<div class="priceCheckrate text-right"><a class="contact entry_btn_check_book btn_main" href="' . $clsISO->getLink('contacts') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a></div>';
		}
		return $html;
	}
	function getLCheckRatePriceCabinCruise2($pvalTable = 0, $arraycheckrateCabin = [], $promotion_date = 0, $cruise_id = 0, $type = "")
	{
		global $core, $dbconn, $_LANG_ID, $clsISO, $clsConfiguration, $departure_date, $now_day;
		$clsPromotion = new Promotion();
		$clsPromotionItem = new PromotionItem();
		$clsCruiseProperty = new CruiseProperty();

		$now_month = date('m', $promotion_date);

		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}
		$infantFares = $clsConfiguration->getValue('InfantFaresPolicy');
		$childFares = $clsConfiguration->getValue('ChildFaresPolicy');
		$maxInfant = $clsConfiguration->getValue('InfantMaxAgePolicy');
		$maxChild = $clsConfiguration->getValue('ChildMaxAgePolicy');

		$oneCruiseCabin = $this->getOne($pvalTable, 'list_group_size,title');
		$lstAdultSizeGroup = $oneCruiseCabin['list_group_size'];
		$lstAdultSize = array();
		if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
			$lstAdultSizeGroup = str_replace('||', '|', $lstAdultSizeGroup);
			$lstAdultSizeGroup = ltrim($lstAdultSizeGroup, '|');
			$lstAdultSizeGroup = rtrim($lstAdultSizeGroup, '|');
			$TMP = explode('|', $lstAdultSizeGroup);
			for ($i = 0; $i < count($TMP); $i++) {
				if (!in_array($TMP[$i], $lstAdultSize)) {
					$lstAdultSize[] = $TMP[$i];
				}
			}
		}
		$lastAdultSize = end($lstAdultSize);
		$max_adult = $clsCruiseProperty->getOneField('number_adult', $lastAdultSize);

		vnSessionSetVar('arraycheckrateCabin', $arraycheckrateCabin);
		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];
		$totalChild = $arraycheckrateCabin['number_child'];
		$totalAdult = $arraycheckrateCabin['number_adult'];
		$totalCabin = $arraycheckrateCabin['number_cabin'];
		$totalCabin2 = 0;


		$number_infant_price = 0;
		$number_child_price = 0;
		$priceAdult = 0;
		$priceAdult1 = 0;
		$priceAdult2 = 0;
		$priceChild = 0;
		$number_cabin = 0;

		$priceInfant = 0;
		$number_adult = $arraycheckrateCabin['number_adult'];
		if ($number_adult <= $max_adult) {
			$one_cruise_property_id = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult' order by order_no ASC limit 0,1");
			$group_size_id = $one_cruise_property_id[0]['cruise_property_id'];
			$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id'";
			$priceOneAdult = $dbconn->getOne($SQL);

			$priceAdult += $priceOneAdult * $number_adult;

			$priceOneChild = ($childFares / 100) * $priceOneAdult;

			if ($arraycheckrateCabin['number_child'] > 0) {
				if ($arraycheckrateCabin['infant' . $i . 's_1'] > $maxInfant) {
					$number_child_price = $number_child_price + 1;
				}
				if ($arraycheckrateCabin['infant' . $i . 's_2'] > $maxInfant) {
					$number_child_price = $number_child_price + 1;
				}
				if ($infantFares > 0) {
					if ($arraycheckrateCabin['infant' . $i . 's_1'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_1'] != '') {
						$number_infant_price = $number_infant_price + 1;
					}
					if ($arraycheckrateCabin['infant' . $i . 's_2'] <= $maxInfant && $arraycheckrateCabin['infant' . $i . 's_2'] != '') {
						$number_infant_price = $number_infant_price + 1;
					}
					$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
				}
			}

			if ($number_child_price > 0) {
				$priceChild = $priceOneChild * $number_child_price;
			}
			return $number_infant_price;
			if ($number_infant_price > 0) {
				$priceInfant = $priceOneInfant * $number_infant_price;
			}

			$totalCabin2 = $totalCabin2 + 1;
		} else {
			$number_cabin += ceil($number_adult / $max_adult);
			$group_size_id_1 = $lastAdultSize;
			$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
			$price = $dbconn->GetOne($SQL);

			$number_adult2 = fmod($number_adult, $max_adult);

			$one_cruise_property_id2 = $clsCruiseProperty->getAll("is_trash=0 and type='GroupSize' and number_adult='$number_adult2' order by order_no ASC limit 0,1");
			$group_size_id_2 = $one_cruise_property_id2[0]['cruise_property_id'];
			$priceAdult1 += $price * ($number_adult - $number_adult2);

			$priceOneChild = ($childFares / 100) * $price;

			if ($arraycheckrateCabin['number_child'] > 0) {
				if ($arraycheckrateCabin['infant'][0] > $maxInfant) {
					$number_child_price = $number_child_price + 1;
				}
				if ($arraycheckrateCabin['infant'][1] > $maxInfant) {
					$number_child_price = $number_child_price + 1;
				}
				if ($infantFares > 0) {
					if ($arraycheckrateCabin['infant'][0] <= $maxInfant && $arraycheckrateCabin['infant'][0] != '') {
						$number_infant_price = $number_infant_price + 1;
					}
					if ($arraycheckrateCabin['infant'][1] <= $maxInfant && $arraycheckrateCabin['infant'][1] != '') {
						$number_infant_price = $number_infant_price + 1;
					}
					$priceOneInfant = ($infantFares / 100) * $priceOneAdult;
				}
			}
			if ($number_child_price > 0) {
				$priceChild = $priceOneChild * $number_child_price;
			}

			if ($number_infant_price > 0) {
				$priceInfant = $priceOneInfant * $number_infant_price;
			}


			$SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_2'";
			$price2 = $dbconn->GetOne($SQL2);
			if (empty($price2)) {
				$SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_cabin_id='$pvalTable' and cruise_itinerary_id='$cruise_itinerary_id' and season ='$season' and group_size_id='$group_size_id_1'";
				$price2 = $dbconn->GetOne($SQL);
			}

			$priceAdult2 += $price2 * ($number_adult2);
		}


		$totalCabin = $totalCabin2 + $number_cabin;
		//$totalPriceCabin=$number_child_price.$priceChild;
		var_dump($priceAdult, $priceAdult1, $priceAdult2, $priceChild, $priceInfant);
		die;
		$totalPriceCabin = $priceAdult + $priceAdult1 + $priceAdult2 + $priceChild + $priceInfant;

		$discount = $clsISO->getPromotion($cruise_id, 'Cruise', $now_day, $promotion_date, 'info_promotion');
		$promotion = $discount['discount_value'];

		$price_simple = $totalPriceCabin;
		if ($totalPriceCabin > 0) {
			if ($promotion > 0) {
				$pricePromotion = $totalPriceCabin - ($totalPriceCabin * $promotion / 100);

				if ($type == 'value') {
					return $pricePromotion;
				}
				$html = '<div class="form-item">
					<input class="text full inp_price cruise_cabin cabin_' . $pvalTable . '" name="number_cabin[' . $pvalTable . ']" value="' . $totalCabin . '" data-cruise_cabin_id="' . $pvalTable . '" data-price_simple="' . $price_simple . '" data-max_adult="' . $max_adult . '" data-price="' . $pricePromotion . '" type="number" placeholder="" min="1" disabled />
					<label for="">' . $oneCruiseCabin['title'] . ' (' . number_format($pricePromotion, 0, '.', ' ') . ' ' . $clsISO->getShortRate() . ')</label>	
					<button class="btn_delete_bonus" onclick="del_bonus(this)" type="button">x</button>		
				</div>';
			} else {
				if ($type == 'value') {
					return $totalPriceCabin;
				}
				$html = '<div class="form-item">
					<input class="text full inp_price cruise_cabin cabin_' . $pvalTable . '" name="number_cabin[' . $pvalTable . ']" value="' . $totalCabin . '" data-cruise_cabin_id="' . $pvalTable . '" data-price_simple="' . $price_simple . '" data-max_adult="' . $max_adult . '" data-price="' . $totalPriceCabin . '" type="number" placeholder="" min="1" disabled />
					<label for="">' . $oneCruiseCabin['title'] . ' (' . number_format($totalPriceCabin, 0, '.', ' ') . ' ' . $clsISO->getShortRate() . ')</label>	
					<button class="btn_delete_bonus" onclick="del_bonus(this)" type="button">x</button>		
				</div>';
			}
		} else {
			$html = '<div class="form-item">
					<input class="text full inp_price cruise_cabin cabin_' . $pvalTable . '" name="number_cabin[' . $pvalTable . ']" value="' . $totalCabin . '" data-cruise_cabin_id="' . $pvalTable . '" data-max_adult="' . $max_adult . '" data-price="0" type="number" placeholder="" min="1" disabled />
					<label for="">' . $oneCruiseCabin['title'] . ' (' . $core->get_Lang('contact') . ')</label>	
					<button class="btn_delete_bonus" onclick="del_bonus(this)" type="button">x</button>		
				</div>';
		}
		return $html;
	}
	function getListCabinBooking($number_cabin = 0, $max_adult = 0, $cruise_cabin_id = 0, $arraycheckrateCabin = [])
	{
		global $core, $dbconn, $clsISO, $clsConfiguration, $departure_date;
		//return $num_day;
		$clsPromotion = new Promotion();
		$clsCruiseProperty = new CruiseProperty();
		$lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%|" . $now_month . "|%' limit 0,1");
		if (!empty($lstSeason)) {
			$season = 'high';
		} else {
			$season = 'low';
		}

		$cruise_itinerary_id = $arraycheckrateCabin['cruise_itinerary_id'];
		$totalChild = $arraycheckrateCabin['number_child'];
		$totalAdult = $arraycheckrateCabin['number_adult'];
		$totalCabin = $arraycheckrateCabin['number_cabin'];
		$totalCabin2 = 0;
		$easy_cancel = $this->getEasyCancel($cruise_cabin_id);
		$html = '';


		for ($i = 1; $i <= $number_cabin; $i++) {
			$number_adult_list = $arraycheckrateCabin['number_adult_' . $i];
			$number_child_list = $arraycheckrateCabin['number_child_' . $i];

			if ($number_adult_list <= $max_adult) {
				if ($number_adult_list > 0) {
					$html .= '
					<div class="item">
						<a class="photo">
						<img src="' . $this->getImage($cruise_cabin_id, 200, 150) . '" alt="' . $this->getTitle($cruise_cabin_id) . '" width="100%" height="auto"/>
						</a>
						<div class="body">
							<h5>' . $core->get_Lang('Room') . '<input class="number_room" value="0" />: ' . $this->getTitle($cruise_cabin_id) . '</h5>
							<p><input class="number_adult" value="' . $number_adult_list . '" /> ' . $core->get_Lang('Adults') . ' <input class="number_child" value="' . $number_child_list . '" /> ' . $core->get_Lang('Child') . '</p>
							' . (!empty($easy_cancel) ? '<p class="c2d color_ea4c42"><i class="fa fa-check"></i> <strong>' . $core->get_Lang('Easy cancellation') . '</strong> <br>' . $easy_cancel . '' : "") . ' 
							<!--<a id="cruiseCabinConditions_' . $i . '" class="tipcabin"><img src="' . $URL_IMAGES . '/help.png" align="absmiddle" /></a>-->
							</p>
							<p class="pull-left"><strong>' . $core->get_Lang('Max') . ':</strong> ' . $max_adult . ' ' . $core->get_Lang('Adults') . '</p>
						</div>
					</div>';
				}
			} else {
				$number_adult_2 += $number_adult_list;
				$number_adult2 = fmod($number_adult_list, $max_adult);
				$number_cabin2 = ceil($number_adult_list / $max_adult);
				$number_adult3 = $number_adult_list - $number_adult2;
				for ($j = 1; $j <= $number_cabin2; $j++) {
					$id_room = $id_room + $j;
					if ($j < $number_cabin2) {
						$html .= '<div class="item">
						<a class="photo">
						<img src="' . $this->getImage($cruise_cabin_id, 200, 150) . '" alt="' . $this->getTitle($cruise_cabin_id) . '" width="100%" height="auto"/>
						</a>
						<div class="body">
							<h5>' . $core->get_Lang('Room') . '<input class="number_room" value="0" />: ' . $this->getTitle($cruise_cabin_id) . '</h5>
							<p><input class="number_adult" value="' . $number_adult3 . '" /> ' . $core->get_Lang('Adults') . ' <input class="number_child" value="' . $number_child_list . '" /> ' . $core->get_Lang('Child') . '</p>
							<p class="c2d color_ea4c42"><i class="fa fa-check"></i> <strong>' . $core->get_Lang('Easy cancellation') . '</strong> <br>
							' . $core->get_Lang(' We allow great flexibility when you have to cancel your trip and charge a minimal fee') . '. <br>
							' . $core->get_Lang('View booking conditions') . '. 
							<a id="cruiseCabinConditions_' . $i . '" class="tipcabin"><img src="' . $URL_IMAGES . '/help.png" align="absmiddle" /></a>
							</p>
							<p class="pull-left"><strong>' . $core->get_Lang('Max') . ':</strong> ' . $max_adult . ' ' . $core->get_Lang('Adults') . '</p>
						</div>
					</div>';
					} else {
						$html .= '<div class="item">
						<a class="photo">
						<img src="' . $this->getImage($cruise_cabin_id, 200, 150) . '" alt="' . $this->getTitle($cruise_cabin_id) . '" width="100%" height="auto"/>
						</a>
						<div class="body">
							<h5>' . $core->get_Lang('Room') . '<input class="number_room" value="0" />: ' . $this->getTitle($cruise_cabin_id) . '</h5>
							<p><input class="number_adult" value="' . $number_adult2 . '" /> ' . $core->get_Lang('Adults') . ' <input class="number_child" value="0" /> ' . $core->get_Lang('Child') . '</p>
							<p class="c2d color_ea4c42"><i class="fa fa-check"></i> <strong>' . $core->get_Lang('Easy cancellation') . '</strong> <br>
							' . $core->get_Lang(' We allow great flexibility when you have to cancel your trip and charge a minimal fee') . '. <br>
							' . $core->get_Lang('View booking conditions') . '. 
							<a id="cruiseCabinConditions_' . $i . '" class="tipcabin"><img src="' . $URL_IMAGES . '/help.png" align="absmiddle" /></a>
							</p>
							<p class="pull-left"><strong>' . $core->get_Lang('Max') . ':</strong> ' . $max_adult . ' ' . $core->get_Lang('Adults') . '</p>
						</div>
					</div>';
					}
				}
			}
		}
		return $html;
	}
	function getSlug($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'slug');
		return $one['slug'];
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getEasyCancel($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'easy_cancel');
		return html_entity_decode($one['easy_cancel']);
	}
	function getContentRate($pvalTable = 0)
	{
		global $core, $clsISO;
		#
		$one = $this->getOne($pvalTable);
		$list_cabin_facilities = $this->getOneField('list_cabin_facilities', $pvalTable);
		$html = '<table border="0" style="borde:none;width:100%;">
					<tbody>
						<tr>
							<td style="border:#000000 0px solid" valign="top"><strong class="font13px fl mbm">' . $this->getTitle($pvalTable) . '</strong><br>
							<img src="' . $this->getImage($pvalTable, 200, 151) . '" border="0px" width="200" height="151" alt=""></td>
							<td style="border:#000000 0px solid; padding-left:10px">';
		$clsCruiseProperty = new CruiseProperty();
		$list_CabinFacilities = $clsCruiseProperty->getAll("is_trash=0 and type='CabinFacilities' order by order_no ASC");
		if (is_array($list_CabinFacilities) && !empty($list_CabinFacilities)) {
			for ($i = 0; $i < count($list_CabinFacilities); $i++) {
				if ($clsISO->checkContainer($list_cabin_facilities, $list_CabinFacilities[$i][$clsCruiseProperty->pkey])) {
					$html .= '<img src="' . URL_IMAGES . '/check.png" alt=""> ' . $clsCruiseProperty->getTitle($list_CabinFacilities[$i][$clsCruiseProperty->pkey]) . '<br>';
				}
			}
		}
		$html .= '			</td>
						</tr>
					</tbody>
				</table>';
		return $html;
	}
	function getNumberCabin($cruise_property_id = 0, $pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'single_bed,double_bed,triple_bed,twin_bed,quad_bed');
		if ($cruise_property_id == 22) {
			return $one['single_bed'];
		} elseif ($cruise_property_id == 23) {
			return $one['double_bed'];
		} elseif ($cruise_property_id == 21) {
			return $one['triple_bed'];
		} elseif ($cruise_property_id == 20) {
			return $one['twin_bed'];
		} elseif ($cruise_property_id == 102) {
			return $one['quad_bed'];
		}
	}
	function checkCabinFacility($cruise_property_id = 0, $cabin_facility = '')
	{
		if ($cruise_property_id == '' || $cabin_facility == '') {
			return 0;
		}
		$cabin_facility = ltrim($cabin_facility, '|');
		if ($cabin_facility == '') {
			return 0;
		}
		$tmp = explode('|', $cabin_facility);
		if (!empty($tmp)) {
			if (!in_array($cruise_property_id, $tmp))
				return 0;
			return 1;
		} else {
			return 0;
		}
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
	function getImageUrl($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getCabinFa($pvalTable = 0)
	{
		global $clsISO;
		$clsCruiseProperty = new CruiseProperty();
		$list_cabin_facilities = $this->getOneField('list_cabin_facilities', $pvalTable);
		#
		$list_CabinFacilities = $clsCruiseProperty->getAll("is_trash=0 and type='CabinFacilities' order by order_no ASC");
		if (is_array($list_CabinFacilities) && !empty($list_CabinFacilities)) {
			$html = '<ul class="lstCabinFa">';
			for ($i = 0; $i < count($list_CabinFacilities); $i++) {
				$title_cabin_facilities = $clsCruiseProperty->getTitle($list_CabinFacilities[$i][$clsCruiseProperty->pkey]);
				$html .= '<li class="' . ($clsISO->checkContainer($list_cabin_facilities, $list_CabinFacilities[$i][$clsCruiseProperty->pkey]) ? 'available' : 'inavailable') . '">';
				if ($list_CabinFacilities[$i]['image'] != '') {
					$html .= '<img src="' . $clsCruiseProperty->getImage($list_CabinFacilities[$i]["cruise_property_id"], 20, 20) . '" 	onerror="this.src=\'/isocms/templates/default/skin/images/none_image.png\'" width="20" height="20" alt="' . $title_cabin_facilities . '" class="img_cabin_facilities mr-2">';
				}

				$html .= '' . $title_cabin_facilities;
				$html .= '</li>';
			}
			$html .= '</ul>';
		}
		return $html;
	}

	function getCabinFaci($pvalTable = 0, $one = null)
	{
		global $clsISO;
		$clsCruiseProperty = new CruiseProperty();
		if (!isset($one['list_cabin_facilities'])) {
			$one = $this->getOne($pvalTable, 'list_cabin_facilities');
		}
		$list_cabin_facilities = $one['list_cabin_facilities'];
		$list_cabin_facilities = str_replace('|', ',', trim($list_cabin_facilities, '|'));
		#
		$list_CabinFacilities = $clsCruiseProperty->getAll("is_trash=0 and type='CabinFacilities' and " . $clsCruiseProperty->pkey . " IN (" . $list_cabin_facilities . ") order by order_no ASC", 'title');
		$total_cabin_faci = (!empty($list_CabinFacilities)) ? count($list_CabinFacilities) : 0;
		$txt = "";
		foreach ($list_CabinFacilities as $key => $val) {
			$txt .= (($key > 0) ? " - " : "") . $val['title'];
			if ($key == 1) {
				break;
			}
		}
		if ($total_cabin_faci > 2) {
			$txt .= " (+" . ($total_cabin_faci - 2) . ")";
		}
		return $txt;
	}

	function getCheckMemSet($cruise_id = 0, $cruise_iti = 0, $start_date = '')
	{
		global $dbconn;
		$clsPromotion = new Promotion();
		$clsPromotionItem = new PromotionItem();
		$Sql_Promotion = $sql = "SELECT p.promotion_id FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and p.is_online = 1 and p.type = 'Cruise' and pi.taget_id =$cruise_id and pi.cruise_intinerary=$cruise_iti and " . $start_date . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
		$promotion = $dbconn->GetOne($Sql_Promotion);
		$check_mem = $clsPromotion->getCheckMem($promotion);
		//		$lst = $clsPromotion->getAll("target_id = '$tour_id' and ".time()." between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
		return $check_mem;
	}
	function doDelete($pvalTable = 0)
	{
		#
		$clsCruiseSeasonPrice = new CruiseSeasonPrice();
		$clsCruiseSeasonPrice->deleteByCond("cruise_cabin_id='$pvalTable'");

		$this->deleteOne($pvalTable);
		return 1;
	}
}
