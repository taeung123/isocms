<?php
class Transfer extends dbBasic
{
	function __construct()
	{
		$this->pkey = "transfer_id";
		$this->tbl = DB_PREFIX . "transfer";
	}
	function checkExitsId($transfer_id = 0)
	{
		$res = $this->getAll("transfer_id = '$transfer_id' LIMIT 0,1");
		return !empty($res) ? 1 : 0;
	}
	function getDueDate($transfer_id = 0, $start_date = 0)
	{
		$number_day = $this->getOneField('number_day', $transfer_id);
		return $start_date + 24 * 60 * 60 * ($number_day - 1);
	}
	function checkBookingConditional($transfer_id = 0, $transfer_start_date_id = 0)
	{
		$check = 0;
		$day = $this->getOneField('booking_front_date', $transfer_id);
		$clsTourStartDate = new TourStartDate();
		$start_date = $clsTourStartDate->getOneField('start_date', $transfer_start_date_id);
		if ($start_date > time() + ($day - 1) * 24 * 60 * 60) return 1;
		return $check;
	}
	function checkStatusDateClass($transfer_id = 0, $transfer_start_date_id = 0, $transfer_class_id = 0)
	{
		$check = 0;
		$clsTourStartDatePrice = new TourStartDatePrice();
		$res = $clsTourStartDatePrice->getAll("transfer_id='$transfer_id' and transfer_start_date_id='$transfer_start_date_id' and transfer_class_id='$transfer_class_id'");
		if ($res[0][$clsTourStartDatePrice->pkey] != '') {
			$check = $res[0]['is_hide'];
		} else {
		}
		return $check;
	}
	function getListCat_V2($transfer_id = 0)
	{
		$clsTourDomainStore = new TourDomainStore();
		$list_cat_id = $clsTourDomainStore->getListCatID($transfer_id, _DOMAIN_ID);
		if (!empty($list_cat_id)) {
			$tmp = explode('|', $list_cat_id);
			$lst = array();
			for ($i = 0; $i < count($tmp); $i++) {
				if ($tmp[$i] != '' && $tmp[$i] != '0')
					$lst[] = $tmp[$i];
			}
			if ($lst[0] != '') return ($lst);
		}
		return '';
	}

	function getStarNew($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'star_id');
		$star_number = $one['star_id'];
		if ($star_number == 1) {
			return '<span style="width: 100%;"></span>';
		} elseif ($star_number == 2) {
			return '<span style="width: 40%;"></span>';
		} elseif ($star_number == 3) {
			return '<span style="width: 60%;"></span>';
		} elseif ($star_number == 4) {
			return '<span style="width: 80%;"></span>';
		} elseif ($star_number == 5) {
			return '<span style="width: 100%;"></span>';
		} else {
			return '<span style="width: 20%;"></span>';
		}
	}
	function getRattingStar($pvalTable = 0)
	{
		$clsReviewsTour = new ReviewsTour();
		$rateScore = $clsReviewsTour->getRateScore($pvalTable) * 10;
		return '<span style="width: ' . $rateScore . '%;"></span>';
	}

	function getPriceDay($transfer_id = 0, $transfer_class_id = 0, $transfer_start_date_id = 0)
	{
		global $clsISO;
		$season = 'low';
		$clsTourStartDatePrice = new TourStartDatePrice();
		$tmp = $clsTourStartDatePrice->getAll("transfer_id='$transfer_id' and transfer_start_date_id='$transfer_start_date_id' and transfer_class_id='$transfer_class_id' limit 0,1");
		$price = $tmp[0]['price'];
		if ($price == 0 || $price == '') {
			$price2 = $this->getPriceSeason($season, $transfer_id, $transfer_class_id);
			return $clsISO->formatNumberToEasyRead($price2);
		}
		$price += $price * (($this->getMarkUp($transfer_id, $clsISO->getCustomerType())) / 100);
		return $clsISO->formatNumberToEasyRead($price);
	}
	function getPriceSeason($season, $transfer_id = 0, $transfer_class_id = 0)
	{
		global $clsISO;
		$price = 0;
		$clsTourSeasonPrice = new TourSeasonPrice();
		$lst = $clsTourSeasonPrice->getAll("transfer_id='$transfer_id' and season='$season' and transfer_class_id='$transfer_class_id' and _type='client' limit 0,1");
		if ($lst[0][$clsTourSeasonPrice->pkey] != '') {
			$price = $lst[0]['price'];
		}
		if ($price == 0) $price = $this->getOneField('trip_price', $transfer_id);
		$price += $price * (($this->getMarkUp($transfer_id, $clsISO->getCustomerType())) / 100);
		return $price;
	}
	function getMarkUp($transfer_id = 0, $_type = '')
	{
		global $_LANG_ID, $gid;
		$clsCommon = new Common();
		$common_id = 1;
		if ($_type != 'client') {
			$percent = $this->getOneField('config_markup_transfer_agent', $transfer_id);
			if ($percent == 0) {
				$percent = $clsCommon->getOneField('config_markup_transfer_agent', $common_id);
			}
		} else {
			$percent = $this->getOneField('config_markup_transfer', $transfer_id);
			if ($percent == 0) {
				$percent = $clsCommon->getOneField('config_markup_transfer', $common_id);
			}
		}
		return $percent;
	}
	function counTotalTourItinerary($pval = 0)
	{
		$clsTourItinerary = new TourItinerary();
		$res = $clsTourItinerary->getAll("is_trash=0 and transfer_id = '$pval'");
		return !empty($res) ? count($res) : 0;
	}
	function getTourTypeRoot($transfer_id = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($transfer_id);
		$list_cat_id = $one['list_cat_id'];
		$list_cat_id = rtrim($list_cat_id, '|');
		$list_cat_id = ltrim($list_cat_id, '|');
		$list_cat_id = explode('|', $list_cat_id);
		if ($clsISO->checkInArray($list_cat_id, '19') == '0') {
			return 0;
		}
		if ($clsISO->checkInArray($list_cat_id, '21') == '0') {
			return 1;
		}
	}
	function makeThumb($transfer_id = 0)
	{
		$clsISO = new ISO();
		$clsConfigImages = new ConfigImages();
		$_TOUR_HOME = $clsConfigImages->getDimension("_TOUR_HOME");
		$image_thumb =  $clsISO->cropImage($this->getOneField('image', $transfer_id), $_TOUR_HOME['width'], $_TOUR_HOME['height']);
		$this->updateOne($transfer_id, "image_thumb='" . addslashes($image_thumb) . "'");
		#		
		$_TOUR_RELATED = $clsConfigImages->getDimension("_TOUR_RELATED");
		$image_thumb =  $clsISO->cropImage($this->getOneField('image', $transfer_id), $_TOUR_RELATED['width'], $_TOUR_RELATED['height']);
		$this->updateOne($transfer_id, "image_related='" . addslashes($image_thumb) . "'");
		#
		return 1;
	}
	function checkTourType($transfer_id = 0, $transfer_type_id = 0)
	{
		$one = $this->getOne($transfer_id);
		$list_transfer_type_id = $one['transfer_type_id'];
		if ($list_transfer_type_id == '' || $transfer_type_id == '') {
			return 0;
		}
		if (str_replace('|' . $transfer_type_id . '|', '', $list_transfer_type_id) == $list_transfer_type_id)
			return 0;
		return 1;
	}
	function getTitle($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'title');
		return $one['title'];
	}
	function getDistanceTrip($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'distance');
		return $one['distance'];
	}
	function getTimeTrip($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'time');
		return $one['time'];
	}
	function getPickUp($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'pick_up');
		return $one['pick_up'];
	}
	function getDropOff($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'drop_off');
		return $one['drop_off'];
	}
	function getNoteMap($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'note_map');
		return html_entity_decode($one['note_map']);
	}
	function getTourTypeSimple($transfer_id = 0)
	{
		global $core;
		$one = $this->getOne($transfer_id, 'transfer_type_id');
		$transfer_type_id = $one['transfer_type_id'];
		if ($transfer_type_id == '1') {
			return $core->get_Lang('Private');
		} else {
			return $core->get_Lang('Group transfer');
		}
	}
	function getPhysicalGradeTour($transfer_id = 0)
	{
		global $core;
		$one = $this->getOne($transfer_id, 'physical_grade_id');
		$physical_grade_id = $one['physical_grade_id'];
		if ($physical_grade_id == '1') {
			return $core->get_Lang('Active');
		} elseif ($physical_grade_id == '2') {
			return $core->get_Lang('Easy transfering');
		} else {
			return $core->get_Lang('Moderate');
		}
	}
	function getAgeLimit($transfer_id = 0)
	{
		global $core;
		$one = $this->getOne($transfer_id, 'age_limit');
		if ($one['age_limit'] != '') {
			return $one['age_limit'];
		} else {
			return $core->get_Lang('No Limit');
		}
	}
	function getTitlePhoto($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'title_photo');
		return $one['title_photo'];
	}
	function getCatId($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'cat_id');
		return $one['cat_id'];
	}
	function CheckContainer($haystack = '', $needle = '')
	{
		$tmp = explode('|', $haystack);
		if (is_array($tmp) && count($tmp) > 0) {
			if (in_array($needle, $tmp))
				return 1;
			return 0;
		} else {
			return 0;
		}
	}
	function getLocation($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'location');
		return $one['location'];
	}
	function getShortTitle($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'title_short');
		return $one['title_short'];
	}
	function getSlug($transfer_id = 0)
	{
		global $_LANG_ID, $core;
		$one = $this->getOne($transfer_id, 'slug,title');
		return $one['slug'] == '' ? $core->replaceSpace($one['title']) : $one['slug'];
	}
	function getBySlug($slug = '')
	{
		$all = $this->getAll("is_trash=0 and slug like '%" . $slug . "%' limit 0,1");
		return $all[0]['transfer_id'];
	}
	function getUspPoints($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'usp_points');
		return html_entity_decode($one['usp_points']);
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getContent($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'content');
		return html_entity_decode($one['content']);
	}
	function getMaps($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'embed_map');
		return $one['embed_map'];
	}
	function getTripOverview($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'overview');
		return html_entity_decode($one['overview']);
	}
	function getTripHighLight($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'highlight');
		return html_entity_decode($one['highlight']);
	}
	function getTripStay($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'stay');
		return html_entity_decode($one['stay']);
	}
	function getTourTransport($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'transfer_transport');
		return html_entity_decode($one['transfer_transport']);
	}
	function getTourMeal($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'transfer_meal');
		return html_entity_decode($one['transfer_meal']);
	}
	function getTourActivities($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'transfer_activities');
		return html_entity_decode($one['transfer_activities']);
	}
	function getTourAccommodation($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'transfer_accommodation');
		return html_entity_decode($one['transfer_accommodation']);
	}
	function getTourDocument($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'transfer_document');
		return html_entity_decode($one['transfer_document']);
	}
	function getTourGuider($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'transfer_guider');
		return html_entity_decode($one['transfer_guider']);
	}
	function getRefundPolicy($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'refund_policy');
		return html_entity_decode($one['refund_policy']);
	}
	function getConfirmationPolicy($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'confirmation_policy');
		return html_entity_decode($one['confirmation_policy']);
	}
	function getStripIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'overview');
		return strip_tags(html_entity_decode($one['overview']));
	}
	function getNote($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'note_price_table');
		return html_entity_decode($one['note_price_table']);
	}
	function getLink($transfer_id = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfer/' . $this->getSlug($transfer_id) . '-tf' . $transfer_id . '.html';
	}
	function getLinkPromotion($transfer_id = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfer/' . $this->getSlug($transfer_id) . '-pr' . $transfer_id . '.html';
	}
	function getLinkOld($transfer_id = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfer/' . $this->getSlug($transfer_id) . '-' . $transfer_id . '.html';
	}
	function getLinkBookExtra($transfer_id = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfer/' . $this->getSlug($transfer_id) . '/bookingextra.html';
	}
	function getLinkBook($transfer_id = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfer/' . $this->getSlug($transfer_id) . '/booking.html';
	}
	function getLinkBookEn($transfer_id = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfer/' . $this->getSlug($transfer_id) . '/booking.html';
	}
	function getLinkBookPromotion($transfer_id = 0, $start_date = 0)
	{
		global $_LANG_ID, $extLang;
		vnSessionSetVar('start_date', $start_date);
		return $extLang . '/transfers/' . $this->getSlug($transfer_id) . '/bookingpromotion.html';
	}

	function getLinkConfirm($transfer_id = 0)
	{
		return '/book-confirmation/' . $this->getSlug($transfer_id) . '.html';
	}
	function getLinkCustomize($transfer_id = 0)
	{
		global $extLang;
		return $extLang . '/transfer/enquiry/' . $this->getSlug($transfer_id) . '.html';
	}
	function getLinkDetailStartDate($transfer_id = 0, $start_date = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfer/' . $this->getSlug($transfer_id) . '_t' . $transfer_id . 'd' . $start_date . '.html';
	}
	function getTripDepart($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'depart_from');
		return $one['depart_from'];
	}
	function getTripReturn($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'return_from');
		return $one['return_from'];
	}
	function getStar($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'star_id');
		return $one['star_id'];
	}
	function getMapZoom($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'map_zoom');
		return $one['map_zoom'];
	}
	function getHighlight($transfer_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($transfer_id, 'highlight');
		if ($one['highlight'] != '')
			return html_entity_decode($one['highlight']);
		return '';
	}
	function getInclusion($transfer_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($transfer_id, 'inclusion');
		if ($one['inclusion'] != '')
			return html_entity_decode($one['inclusion']);
		return '';
	}
	function getExclusion($transfer_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($transfer_id, 'exclusion');
		if ($one['exclusion'] != '')
			return html_entity_decode($one['exclusion']);
		return '';
	}
	function getAddInformation($transfer_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($transfer_id, 'information');
		if ($one['information'] != '')
			return html_entity_decode($one['information']);
		return '';
	}
	function getServiceInformation($transfer_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($transfer_id, 'service_information');
		if ($one['service_information'] != '')
			return html_entity_decode($one['service_information']);
		return '';
	}
	function getTripGroupSize($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'trip_groupsize');
		return $one['trip_groupsize'];
	}
	function getTripOldPrice($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'trip_old_price');
		$clsISO = new ISO();
		if (!empty($one['trip_old_price']))
			return $clsISO->formatPrice($one['trip_old_price']) . ' ' . $clsISO->getRate();
	}
	function getMinStartDateID($transfer_id = 0, $start_date = 0)
	{
		$clsTourStartDate = new TourStartDate();
		$lst = $clsTourStartDate->getAll("transfer_id='$transfer_id' and start_date='" . $start_date . "' and is_trash=0 order by start_date asc limit 0,1");
		return $lst[0]['transfer_start_date_id'];
	}
	function getDeparturePoint($transfer_id = 0)
	{
		$clsCountry = new Country();
		$clsCity = new City();
		$one = $this->getOne($transfer_id, 'country_departure_id,city_departure_id');
		return '<a class="color_333 text_bold" href="" title="' . $clsCity->getTitle($one['city_departure_id']) . '">' . $clsCity->getTitle($one['city_departure_id']) . '</a><br /><a class="color_333 text_bold" href="" title="' . $clsCountry->getTitle($one['country_departure_id']) . '">' . $clsCountry->getTitle($one['country_departure_id']) . '</a>';
	}
	function getDepartureCity($transfer_id = 0)
	{
		$clsCity = new City();
		$one = $this->getOne($transfer_id, 'departure_point_id');
		return $clsCity->getTitle($one['departure_point_id']);
	}
	function getLinkDepartureCity($transfer_id = 0)
	{
		$clsCity = new City();
		$one = $this->getOne($transfer_id, 'departure_point_id');
		return $clsCity->getLink($one['departure_point_id'], 'transfer');
	}
	function getIntroTripPrice($transfer_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($transfer_id, 'intro_trip_price');
		if ($one['intro_trip_price'] != '')
			return html_entity_decode($one['intro_trip_price']);
		return '';
	}
	function getTripPrice($pvalTable = 0, $is_agent = 0)
	{
		global $core, $extLang, $_lang, $clsConfiguration, $clsISO;
		$clsProperty = new Property();
		$clsTourPriceVal = new TourPriceVal();
		#
		if ($is_agent == 1) {
			$sqlPrice = $clsTourPriceVal->getAll("transfer_id='$pvalTable' and transfer_price_row_id=16 and departure_date=0 and price > 0 and is_agent=1 limit 0,1");
		} else {
			$sqlPrice = $clsTourPriceVal->getAll("transfer_id='$pvalTable' and transfer_price_row_id=16 and departure_date=0 and price > 0 and is_agent=0 limit 0,1");
		}
		$priceAdultAds = $sqlPrice[0]['price'];
		if ($priceAdultAds > 0) {
			return '<div class="price">
					  <div class="discounted_price">
							<span>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($priceAdultAds) . '</span>
					  </div>
		  			</div>';
		} else {
			return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
		}
	}
	function getTripMinPrice($pvalTable = 0, $start_date = '', $is_offer = 0)
	{
		global $core, $extLang, $_lang, $clsConfiguration;
		$clsProperty = new Property();
		$clsTourPriceVal = new TourPriceVal();
		#
		$clsISO = new ISO();

		$trip_price = $clsTourPriceVal->getTripMinPriceOptionBooking(16, 0, $start_date, $pvalTable);
		return $trip_price;
		$clsISO->formatPrice($trip_price);
	}
	function getLTripPriceDetail($pvalTable = 0, $type = '')
	{
		global $core, $extLang, $_lang, $clsConfiguration;
		$clsProperty = new Property();
		#
		$clsISO = new ISO();
		$one = $this->getOne($pvalTable);
		$transfer_start_date_id = $this->getMinStartDateID($pvalTable);
		if ($transfer_start_date_id != '') {
			$clsTourStartDate = new TourStartDate();

			return $clsISO->formatPrice($clsTourStartDate->getOneField("price", $transfer_start_date_id)) . ' ' . $clsISO->getRate();
		}
		$trip_price = $one['trip_price'];
		if ($trip_price == '' || $trip_price == 0) {
			return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('Contact') . '</a>';
		} elseif ($type == 'header') {
			return '<span class="original_price"><span>' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatPrice($trip_price) . '<p class="per_person">per adult</p>
              </span></span>';
		}
		return '<span class="amount">' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatPrice($trip_price) . '</span><span class="amount"><span class="per_person_new"> per adult</span></span>';
	}
	function getTripPriceOrgin($transfer_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($transfer_id, 'trip_price');
		$trip_price = $one['trip_price'];
		if ($trip_price == 0)
			return 0;
		return $clsISO->processSmartNumber($trip_price);
	}
	function getTripPriceOld($pvalTable = 0)
	{
		$clsISO = new ISO();
		$one = $this->getOne($pvalTable, 'trip_old_price');
		if (!empty($one['trip_old_price'])) {
			return $clsISO->formatPrice($one['trip_old_price']) . ' ' . $clsISO->getRate();
		}
	}
	function getLTripPriceOld($pvalTable = 0)
	{
		global $core, $extLang, $_lang, $clsConfiguration;
		$clsProperty = new Property();

		$clsISO = new ISO();
		$one = $this->getOne($pvalTable, 'trip_price');
		if (!empty($one['trip_price'])) {
			return $clsISO->formatPrice($one['trip_price']);
		}
	}

	function getTourPromotion($transfer_id = 0)
	{
		global $clsISO;
		$cond = "is_trash=0 and is_online=1 and $transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "transfer_store WHERE is_trash=0 and _type='PROMOTION')";
		$lstAll = $this->getAll($cond);
		return $lstAll[0]['transfer_id'];
	}


	function getTripCode($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'trip_code');
		return strtoupper($one['trip_code']);
	}
	function getTablePriceTitle($pvalTable = 0)
	{
		global $core;
		$one = $this->getOne($pvalTable, 'table_price_title');
		return !empty($one['table_price_title']) ? $one['table_price_title'] : $core->get_Lang('Price Options');
	}
	function getTripDuration($transfer_id = 0)
	{
		global $_LANG_ID, $core, $_lang;
		$one = $this->getOne($transfer_id, 'duration_type,duration_custom,number_day,number_night');
		$duration_type = $one['duration_type'];
		if ($duration_type == 1) {
			return $one['duration_custom'];
		}
		$number_day = intval($one['number_day']);
		$number_night = intval($one['number_night']);
		if ($number_day == 1 && $number_night == 0) { {
				return $core->get_Lang('Full day');
			}
		}
		#
		if ($number_night == 0) {
			$number_night = $number_day - 1;
		}

		#
		$str = '';
		$str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));

		$str .= ' & ' . $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
		return $str;
	}
	function getLTripDuration($transfer_id = 0, $type = '')
	{
		global $_LANG_ID, $core, $_lang;
		$one = $this->getOne($transfer_id, 'duration_type,duration_custom,number_day,number_night');
		$duration_type = $one['duration_type'];
		if ($duration_type == 1) {
			if ($type == 'booking') {
				return '<span class="icon">h</span><span class="spanncontentt">' . $one['duration_custom'] . '</span>';
			}
			return '<span class="icon">h</span><span class="text">' . $one['duration_custom'] . '</span>';
		}
		$number_day = intval($one['number_day']);
		$number_night = intval($one['number_night']);
		if ($number_day == 1 && $number_night == 0) { {
				if ($type == 'booking') {
					return '<span class="icon">d</span><span class="spanncontentt">' . $core->get_Lang('Full Day') . '</span>';
				}
				return '<span class="icon">d</span><span class="text">' . $core->get_Lang('Full Day') . '</span>';
			}
		}
		#
		if ($number_day > 1 && $number_night == 0) {
			$number_night = $number_day - 1;
		}
		#
		if ($type == 'booking') {
			$str = '<span class="icon">d</span><span class="spanncontentt">';
			$str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('Days') : $core->get_Lang('Day'));
			$str .= '</span><span class="icon">n</span><span class="spanncontentt">';
			$str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('Nights') : $core->get_Lang('Night'));
			$str .= '</span>';
		} else {
			$str = '<span class="icon">d</span><span class="text">';
			$str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('Days') : $core->get_Lang('Day'));
			$str .= '</span><span class="icon">n</span><span class="text">';
			$str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('Nights') : $core->get_Lang('Night'));
			$str .= '</span>';
		}
		return $str;
	}
	function getNumberDayDuration($transfer_id = 0)
	{
		global $_LANG_ID, $core, $_lang;
		$one = $this->getOne($transfer_id, 'duration_type,duration_custom,number_day,number_night');
		$duration_type = $one['duration_type'];
		if ($duration_type == 1) {
			return $one['duration_custom'];
		}
		$number_day = intval($one['number_day']);
		$number_night = intval($one['number_night']);
		if ($number_day == 1 && $number_night == 0) { {
				return $core->get_Lang('Full Day');
			}
		}
		#
		$str = '';
		$str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
		return $str;
	}
	function getTripDuration00($transfer_id = 0, $only_day = false)
	{
		global $_LANG_ID, $core;
		$one = $this->getOne($transfer_id, "number_day,number_night");
		$number_day = $one['number_day'];
		$number_night = $one['number_night'];
		if (intval($number_day) == 1 && intval($number_night) == 0) {
			return $core->get_Lang('Full day');
		}
		if (intval($number_day) == 0 && intval($number_night) == 0) {
			return '';
		}

		$day = $number_day . (intval($number_day) > 1 ? $core->get_Lang('Days') : $core->get_Lang('Day'));
		if ($only_day) {
			return $day;
		}
		$night = $number_night . (intval($number_night) > 1 ? $core->get_Lang('Nights') : $core->get_Lang('Night'));
		return $day . '/' . $night;
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
	function getBanner($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image_banner");
		if ($oneTable['image_banner'] != '') {
			$image_banner = $oneTable['image_banner'];
			return $clsISO->tripslashImage($image_banner, $w, $h);
		}
		$noimage_banner = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage_banner)}";
	}
	#- Start_Price_Cruise_Table
	function getTableCruiseTitle($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable);
		if ($one['table_cruise_title_' . $_LANG_ID] == '') {
			return 'Cabin type';
		} else {
			return $one['table_cruise_title_' . $_LANG_ID];
		}
	}
	function getPriceCruiseDateFrom($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'table_cruise_date_from');
		if ($one['table_cruise_date_from'] == '') {
			return '1st May - 30th Sep';
		} else {
			return $one['table_cruise_date_from'];
		}
	}
	function getPriceCruiseDateTo($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'table_cruise_date_to');
		if ($one['table_cruise_date_to'] == '') {
			return 'From 1st Oct - 30th Apr';
		} else {
			return $one['table_cruise_date_to'];
		}
	}
	#- End_Price_Cruise_Table
	function getTripDayText($transfer_id = 0)
	{
		global $_LANG_ID, $core;

		$one = $this->getOne($transfer_id, 'number_day');
		$number_day = intval($one['number_day']);
		if ($number_day == 0 || $number_day == '' || $number_day == 1)
			return '1 <i>day</i>';
		return $number_day . ' <i>days</i>';
	}
	function checkCityAround($pvalTable = 0, $city_id = 0)
	{
		$oneItem = $this->getOne($pvalTable, 'list_city_id');
		$str = $oneItem['list_city_id'];
		$str_array = explode('|', $str);
		for ($i = 0; $i < count($str_array); $i++) {
			if ($str_array[$i] == $city_id) {
				return 1;
			}
		}
		return 0;
	}
	function convertDuration($duration = '')
	{
		if ($duration == 'Full day') {
			return '1-0';
		}
		$temp = str_replace(' ', '', $duration);
		$temp = explode('/', $temp);
		$day = intval($temp[0]);
		$night = intval($temp[1]);
		return $day . '-' . $night;
	}
	function convertDurationDay($duration = '')
	{
		if ($duration == 'Full day') {
			return '1-0';
		}
		$temp = str_replace(' ', '', $duration);
		$temp = explode('/', $temp);
		$day = intval($temp[0]);
		$night = intval($temp[1]);
		return $day;
	}
	function convertDurationDaySort($duration = '')
	{
		if ($duration == 'Full day') {
			return '1';
		}
		$temp = str_replace(' ', '', $duration);
		$temp = explode('/', $temp);
		$day = intval($temp[0]);
		$night = intval($temp[1]);
		return $day;
	}
	function getAllDuration($current = 0, $transfer_category_id = 0, $city_id = 0)
	{
		global $_LANG_ID, $lang;
		$cond = "is_trash=0";
		$cond .= ($transfer_category_id != '' && $transfer_category_id != 0) ? " and list_cat_id like '%|" . $transfer_category_id . "|%'" : "";
		$cond .= ($city_id != '' && $city_id != 0) ? " and list_city_id like '%|" . $city_id . "|%'" : "";

		$allTour = $this->getAll($cond);
		$temp = '';
		for ($i = 0; $i < count($allTour); $i++) {
			$temp .= $this->getTripDuration($allTour[$i]['transfer_id']) . '|';
		}
		$str = array_unique(explode('|', $temp));
		$html = '<option value="">-- ' . $lang->get_Lang('Select') . ' --</option>';
		foreach ($str as $key => $value) {
			$selected = ($current == $this->convertDuration($value)) ? ' selected="selected"' : '';
			if ($value != '' && $value != 'n/a') {
				$html .= '<option value="' . $this->convertDuration($value) . '"' . $selected . '>' . $value . '</option>';
			}
		}
		return $html;
	}
	function getAllCat($curent = '', $destination_id = '')
	{
		$clsTourCategory = new TourCategory();
		$cond = '';
		$cond .= ($destination_id != 0 && $destination_id != "") ? " and list_destination like '%|$destination_id|%'" : "";
		$all = $this->getAll("is_trash=0" . $cond);
		if (is_array($all)) {
			foreach ($all as $key => $value) {
				$temp .= $value['transfer_category_id'] . '|';
			}
		}
		$str = array_unique(explode('|', $temp));
		$html = '<option value="0">-- ' . $core->get_Lang('Select') . ' --</option>';
		if (is_array($str)) {
			foreach ($str as $k => $v) {
				if ($v != 0) {
					$selected = ($curent == $v) ? ' selected="selected"' : '';
					$html .= '<option value="' . $v . '"' . $selected . '>' . $clsTourCategory->getTitle($v) . '</option>';
				}
			}
		}
		return $html;
	}
	function getDay($transfer_id = 0)
	{
		global $core;
		$one = $this->getOne($transfer_id, 'duration_type,duration_custom,number_day,number_night');
		if ($one['duration_type'] == 0) {
			$number_day = $one['number_day'];
			$number_night = $one['number_night'];
			if ($number_day == 1) {
				return $number_day . ' ' . $core->get_Lang('day');
			}
			if ($one['number_day'] == 0 && $one['number_day'] == 0) {
				return '';
			}
			return $one['number_day'] . ' ' . $core->get_Lang('days');
		} elseif ($one['duration_type'] == 1) {
			return $one['duration_custom'];
		}
	}
	function getNumberDay($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'duration_type,duration_custom,number_day,number_night');
		$duration_type = $one['duration_type'];
		if ($duration_type == 1) {
			return $one['duration_custom'];
		} else {
			return $one['number_day'];
		}
	}

	function getDateDepartureStart($transfer_id = 0)
	{
		global $core, $clsISO;
		$one = $this->getOne($transfer_id, 'departure_date');
		if (!empty($one['departure_date'])) {
			return date('d/m/Y', $one['departure_date']);
		}
	}

	function getDateDepartureEnd($transfer_id = 0)
	{
		global $core, $clsISO;

		$one = $this->getOne($transfer_id, 'duration_type,departure_date,number_day,departure_date');
		$duration_type = $one['duration_type'];
		if ($duration_type == 1) {
			return date('m/d/Y', $one['departure_date']);
		} else {
			$num_day = $one['number_day'];
			$start_date = $one['departure_date'];
			$end_date =  date('m/d/Y', strtotime('+' . $num_day . ' day', $start_date));
			return $end_date;
		}
	}
	function checkDurationCustom($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'duration_type');
		return $one['duration_type'];
	}
	function getCityAround($transfer_id = 0, $is_image = false)
	{
		global $_LANG_ID;

		$clsCity = new City;
		$clsTourDestination = new TourDestination;
		$html = '';
		$rsllist = $clsTourDestination->getAll("is_trash=0 and transfer_id='$transfer_id' order by order_no asc");
		if (is_array($rsllist) && count($rsllist) > 0) {
			if ($is_image) {
				for ($i = 0; $i < count($rsllist); $i++) {
					$html .= ($i == 0 ? '' : ' <img class="arrow" src="' . URL_IMAGES . '/arrow.png" /> ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
				}
				unset($rsllist);
			} else {
				for ($i = 0; $i < count($rsllist); $i++) {
					$html .= ($i == 0 ? '' : ' , ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
				}
				unset($rsllist);
			}
		}
		return $html;
	}
	function getLCityAround($transfer_id = 0, $type = '')
	{
		global $_LANG_ID;
		$clsCity = new City;
		$clsGuide = new Guide();
		$clsTourDestination = new TourDestination;
		#
		$html = '';
		$rsllist = $clsTourDestination->getAll("is_trash=0 and transfer_id='$transfer_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
		if (is_array($rsllist) && count($rsllist) > 0) {
			for ($i = 0; $i < count($rsllist); $i++) {
				if ($rsllist[$i]['placetogo_id'] > 0) {

					$html .= ($i == 0 ? '' : ' ,') . '<a class="linkcity" target="_parent" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id']) . '" title="' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '">' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '</a>';
				} else {

					$html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
				}
			}
			unset($rsllist);
		}
		return $html;
	}
	function getLCountryAround($transfer_id = 0, $type = '')
	{
		global $_LANG_ID, $dbconn;
		$clsCountry = new Country;
		$clsTourDestination = new TourDestination;
		#
		$html = '';

		$SQL01 = "SELECT country_id FROM " . DB_PREFIX . "transfer_destination WHERE transfer_id='$transfer_id' group by country_id";

		$listCountry = $dbconn->GetAll($SQL01);
		if ($type == 'NOCOMMA') {
			if (is_array($listCountry) && count($listCountry) > 0) {
				for ($i = 0; $i < count($listCountry); $i++) {
					$html .= ($i == 0 ? '' : '') . '<a class="linkcountry" target="_parent" href="' . $clsCountry->getLink($listCountry[$i]['country_id']) . '" title="' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '">' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '</a>';
				}
				unset($listCountry);
			}
		} else {
			if (is_array($listCountry) && count($listCountry) > 0) {
				for ($i = 0; $i < count($listCountry); $i++) {
					$html .= ($i == 0 ? '' : ', ') . '<a class="linkcountry" target="_parent" href="' . $clsCountry->getLink($listCountry[$i]['country_id']) . '" title="' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '">' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '</a>';
				}
				unset($listCountry);
			}
		}
		return $html;
	}
	function getListTag($transfer_id = 0)
	{
		global $_LANG_ID;
		#
		$clsTag = new Tag;
		#
		$list_tag_id = $this->getOneField('list_tag_id', $transfer_id);
		$list_tag_id = ltrim($list_tag_id, '|');
		$list_tag_id = rtrim($list_tag_id, '|');
		$list_tag_id = explode('|', $list_tag_id);
		#
		$html = '';
		if ($list_tag_id != '') {
			for ($i = 0; $i < count($list_tag_id); $i++) {
				if (!empty($list_tag_id[$i])) {
					$html .= ($i == 1 ? '' : '  ') . '<a class="link-tag" target="_parent" title="' . $clsTag->getTitle($list_tag_id[$i]) . '">' . $clsTag->getTitle($list_tag_id[$i]) . '</a>';
				}
			}
			return $html;
		}
	}
	function getCatTours($transfer_id = 0)
	{
		global $_LANG_ID;
		#
		$clsCategory = new Category;
		#
		$list_type_id = $this->getOneField('list_type_id', $transfer_id);
		$list_type_id = ltrim($list_type_id, '|');
		$list_type_id = rtrim($list_type_id, '|');
		$list_type_id = explode('|', $list_type_id);
		#
		$html = '';
		if ($list_type_id != '') {
			for ($i = 0; $i < count($list_type_id); $i++) {
				if (!empty($list_type_id[$i])) {
					$html .= ($i == 1 ? '' : ' , ') . '<a class="link" target="_parent" href="' . $clsCategory->getLink($list_type_id[$i]) . '" title="' . $clsCategory->getTitle($list_type_id[$i]) . '">' . $clsCategory->getTitle($list_type_id[$i]) . '</a>';
				}
			}
			return $html;
		}
	}
	function checkTourPromotion($transfer_id = 0)
	{
		$res = $this->getAll("transfer_id='$transfer_id' and is_promotion=1 limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function checkTourTop($transfer_id)
	{
		$res = $this->getAll("transfer_id='$transfer_id' and is_top=1 limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function countTourTop($type = "", $country_id = "")
	{
		if ($type == "all") {
			$res = $this->getAll("is_trash=0 and is_top=1");
			return !empty($res) ? count($res) : 0;
		}
		$res = $this->getAll("is_trash=0 and is_top=1 and list_country_id like '%|" . $country_id . "|%'");
		return !empty($res) ? count($res) : 0;
	}
	function countTourPromotion($type = "", $country_id = "")
	{
		if ($type == "all") {
			$res = $this->getAll("is_trash=0 and is_promotion=1");
			return !empty($res) ? count($res) : 0;
		}
		$res = $this->getAll("is_trash=0 and is_promotion=1 and list_country_id like '%|" . $country_id . "|%'");
		return !empty($res) ? count($res) : 0;
	}
	function getTableCruiseHeader($transfer_id = 0)
	{
		global $_LANG_ID;
		$oneTable = $this->getOne($transfer_id, "table_cruise_header_" . $_LANG_ID);
		if ($oneTable['table_cruise_header_' . $_LANG_ID] != '')
			return $oneTable['table_cruise_header_' . $_LANG_ID];
		return '[N/A]';
	}
	function getTablePriceHeader($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'table_price_header');
		if ($one['table_price_header'] == '') {
			return 'Net transfer cost per person in us dollar valid from 1 may – 30 sep ' . date('Y', time());
		} else {
			return $one['table_price_header'];
		}
	}
	function getListOfferTours($limit = '')
	{
		global $core, $dbconn;
		$limit = !empty($limit) ? ' limit ' . $limit : '';
		$sql = "SELECT t1.transfer_id FROM " . DB_PREFIX . "transfer t1 INNER JOIN " . DB_PREFIX . "transfer_store t2 WHERE t1.transfer_id = t2.transfer_id AND t2._type='PROMOTION' AND t1.is_online=1 AND t1.is_trash=0 ORDER BY t2.order_no DESC" . $limit;
		$res = $dbconn->GetAll($sql);
		return !empty($res) ? $res : '';
	}
	function doDelete($transfer_id = 0)
	{
		$clsISO = new ISO();

		// Delete Tour Image
		$clsTransferImage = new TransferImage();
		$clsTransferImage->deleteByCond("table_id='$transfer_id'");

		$clsTransferPrice = new TransferPrice();
		$clsTransferPrice->deleteByCond("transfer_id='$transfer_id'");

		#
		$this->deleteOne($transfer_id);
		return 1;
	}
	function getTripCodeByStartDate($transfer_start_date_id = 0)
	{
		$clsTourStartDate = new TourStartDate();
		$start_date = $clsTourStartDate->getOneField('start_date', $transfer_start_date_id);
		$date =  date('d', $start_date) . date('m', $start_date) . date('y', $start_date);
		$clsTour = new Tour();
		return $this->getOneField('trip_code', $this->getOneField('transfer_id', $transfer_start_date_id)) . '-' . $date;
	}
	function getDateDeparture($transfer_id = 0)
	{
		global $core, $clsISO;
		$one = $this->getOne($transfer_id, 'departure_date');
		if (!empty($one['departure_date'])) {
			return date('d/m/Y', $one['departure_date']);
		}
	}

	function checkDepartureOther($pvalTable = 0)
	{
		$clsTourStartDate = new TourStartDate();
		$res = $clsTourStartDate->getAll("is_trash=0 and start_date>= '" . time() . "' and transfer_id = '" . $pvalTable . "' limit 0,1");
		return !empty($res) ? 1 : 0;
	}
	function getDateDepartureText($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id);
		return date('d/m/Y', time());
	}
	function getLinkDeparture($transfer_id = 0)
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/transfers/' . $this->getSlug($transfer_id) . '_a' . $transfer_id . '.html';
	}
	function getTourDestination($transfer_id = 0)
	{
		$clsTourDestination = new TourDestination;
		$clsCity = new City;
		$html = '';
		$lstItem = $clsTourDestination->getAll("is_trash=0 and transfer_id='$transfer_id' order by order_no asc");
		if ($lstItem != '') {
			for ($i = 0; $i < count($lstItem); $i++) {
				$html .= ($i == 0 ? '' : ',&nbsp;') . '<a href="' . $clsCity->getLink($lstItem[$i]['city_id']) . '" title="' . $clsCity->getTitle($lstItem[$i]['city_id']) . '">' . $clsCity->getTitle($lstItem[$i]['city_id']) . '</a>';
			}
			return $html;
		}
	}
	function getTourType($transfer_id = 0)
	{
		$clsCategory = new Category;
		$html = '';
		#
		$one = $this->getOne($transfer_id, 'transfer_type_id');
		$transfer_type_id = $one['transfer_type_id'];
		if ($transfer_type_id == '' || $transfer_type_id == '0' || $transfer_type_id == '|') {
			return '';
		}
		$transfer_type_id = trim(str_replace('||', ',', $transfer_type_id));
		$transfer_type_id = trim(str_replace('|', '', $transfer_type_id));
		#
		$tmp = explode(',', $transfer_type_id);
		if (is_array($tmp) && count($tmp) == 1) {
			$html = '<a href="#" title="">' . $clsCategory->getTitle($tmp[0]) . '</a>';
		} else {
			for ($i = 0; $i < count($tmp); $i++) {
				if ($tmp[$i] != '' && $tmp[$i] != 0)
					$html .= ($i == 0 ? '' : ',&nbsp;') . '<a href="' . $clsCategory->getLink($tmp[$i]) . '" title="' . $clsCategory->getTitle($tmp[$i]) . '">' . $clsCategory->getTitle($tmp[$i]) . '</a>';
			}
		}
		return $html;
	}
	function getDepartureFrom($transfer_id = 0)
	{
		$clsCity = new City();
		$clsCountry = new Country();
		$clsTourDestination = new TourDestination();
		$all = $clsTourDestination->getAll("is_trash=0 and transfer_id = '$transfer_id' order by order_no asc limit 0,1");
		$country_id = $clsCity->getOneField('country_id', $all[0]['city_id']);
		if ($country_id > 0)
			return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . ',</a> <a href="' . $clsCountry->getLink($country_id) . '" title="' . $clsCountry->getTitle($country_id) . '">' . $clsCountry->getTitle($country_id) . '</a>';
		return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . '</a>';
	}
	function getDepartureEnd($transfer_id = 0)
	{
		$clsCity = new City();
		$clsCountry = new Country();
		$clsTourDestination = new TourDestination();
		$all = $clsTourDestination->getAll("is_trash=0 and transfer_id = '$transfer_id' order by order_no desc limit 0,1");
		$country_id = $clsCity->getOneField('country_id', $all[0]['city_id']);
		if ($country_id > 0)
			return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . ',</a> <a href="' . $clsCountry->getLink($country_id) . '" title="' . $clsCountry->getTitle($country_id) . '">' . $clsCountry->getTitle($country_id) . '</a>';
		return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . '</a>';
	}
	function getCatName($transfer_id = '')
	{
		$clsTourCat = new TourCategory();
		$oneTable = $this->getOne($transfer_id, "cat_id");
		return $clsTourCat->getTitle($oneTable['cat_id']);
	}
	function getTypeName($transfer_id = '')
	{
		$clsCategory = new Category();
		$oneTable = $this->getOne($transfer_id, "type_id");
		return $clsCategory->getTitle($oneTable['type_id']);
	}
	function getTourTypeCategory($transfer_id = 0)
	{
		return $this->getOneField("transfer_type_id", $transfer_id);
		return 0;
		$clsISO = new ISO();
		$one = $this->getOne($transfer_id, 'list_cat_id');
		$list_cat_id = $one['list_cat_id'];
		$list_cat_id = rtrim($list_cat_id, '|');
		$list_cat_id = ltrim($list_cat_id, '|');
		$list_cat_id = explode('|', $list_cat_id);
		if ($clsISO->checkInArray($list_cat_id, '19') == '0') {
			return 0;
		}
		if ($clsISO->checkInArray($list_cat_id, '21') == '0') {
			return 1;
		}
	}
	function updateTourTransport($transfer_id = 0)
	{
		$clsTourItinerary = new TourItinerary();
		$list_transport_id = '|';
		#
		$lstTourItinerary = $clsTourItinerary->getAll("is_trash=0 and transfer_id='$transfer_id' order by order_no asc");
		if (is_array($lstTourItinerary) && count($lstTourItinerary) > 0) {
			for ($i = 0; $i < count($lstTourItinerary); $i++) {
				if ($lstTourItinerary[$i]['transport_id'] != '' && $lstTourItinerary[$i]['transport_id'] != '0') {
					$list_transport_id .= $lstTourItinerary[$i]['transport_id'] . '|';
				}
			}
			unset($lstTourItinerary);
			$this->updateOne($transfer_id, "list_transport_id='$list_transport_id'");
			return '';
		}
		return '';
	}
	function updateTransport($transfer_id = 0)
	{
		$clsTourItinerary = new TourItinerary();
		$list_transport_id = '|';
		#
		$lstTourItinerary = $clsTourItinerary->getAll("is_trash=0 and transfer_id='$transfer_id' order by order_no asc");
		if (is_array($lstTourItinerary) && count($lstTourItinerary) > 0) {
			for ($i = 0; $i < count($lstTourItinerary); $i++) {
				if ($lstTourItinerary[$i]['transport_id'] != '' && $lstTourItinerary[$i]['transport_id'] != '0') {
					$list_transport_id .= $lstTourItinerary[$i]['transport_id'] . '|';
				}
			}
			unset($lstTourItinerary);
			$this->updateOne($transfer_id, "list_transport_id='$list_transport_id'");
			return '';
		}
		return '';
	}
	function getPriceCat($transfer_id = 0, $cat_id = 0, $transfer_start_date_id = 0)
	{
		$clsTourPriceCat = new TourPriceCat();
		$all = $clsTourPriceCat->getAll("transfer_id='$transfer_id' and cat_id='$cat_id' and transfer_start_date_id='$transfer_start_date_id' limit 0,1");
		if ($all[0]['transfer_id'] != '' && $all[0]['price'] != 0 && $all[0]['price'] != '') return $all[0]['price'];
		if ($cat_id == 246) {
			$clsCommon = new Common();
			$pricePT = $clsCommon->getOneField('config_transfer_ptvtnvn', 1);
			$lst = $clsTourPriceCat->getAll("transfer_start_date_id='$transfer_start_date_id' and cat_id='$cat_id' and transfer_id='$transfer_id' limit 0,1");
			if ($lst[0][$clsTourPriceCat->pkey] == '') {
				$f = "transfer_id,transfer_start_date_id,cat_id,price,user_id,user_id_update,reg_date,upd_date,price";
				$v = "'$transfer_id','$transfer_start_date_id','$cat_id','0','" . $core->_USER['user_id'] . "','" . $core->_USER['user_id'] . "','" . time() . "','" . time() . "','$pricePT'";
				$clsTourPriceCat->insertOne($f, $v);
			} else {
				$clsTourPriceCat->updateOne($lst[0][$clsTourPriceCat->pkey], "price='$pricePT'");
			}
			return $pricePT;
		}
		return 0;
	}
	function getErrorMsg($transfer_id = 0)
	{
		global $core;
		#
		$oneTour = $this->getOne($transfer_id, 'image');
		$msg = '';
		if ($oneTour['image'] == '') {
			$msg .= $core->get_Lang('missimages');
		}
		if ($this->getTripCode($transfer_id) == '') {
			$msg .= $core->get_Lang('misscodetransfer');
		}

		$clsTourItinerary = new TourItinerary();
		if ($clsTourItinerary->countItem("is_trash=0 and transfer_id='$transfer_id'") == 0) {
			$msg .= $core->get_Lang('missitinerary');
		}
		return $msg;
	}
	function getNumberSeat($transfer_id = 0)
	{
		$one = $this->getOne($transfer_id, 'number_seat');
		$transfer_start_date_id = $this->getMinStartDateID($transfer_id);
		if ($transfer_start_date_id != '') {
			$clsTourStartDate = new TourStartDate();
			return $clsTourStartDate->getOneField("allotment", $transfer_start_date_id);
		}
		$number_seat = $one['number_seat'];
		if ($number_seat != '' && intval($number_seat) > 0) {
			return $number_seat;
		}
		/* @ mt_rand() value */
		return mt_rand(5, 15);
	}
	function initCruiseTable($transfer_id = 0)
	{
		global $core;
		#
		$clsTourCruisePriceRow = new TourCruisePriceRow();
		$clsTourCruisePriceCol = new TourCruisePriceCol();
		$clsTourCruisePriceVal = new TourCruisePriceVal();

		$_frontIsLoggedin_user_id = $core->_USER['user_id'];

		$res = $clsTourCruisePriceRow->getAll("transfer_id = '$transfer_id'");
		if (empty($res)) {
			for ($i = 0; $i < 4; $i++) {
				$f = "transfer_id,user_id,title,order_no";
				if ($i % 2) {
					$title = 'Double cabin';
				} else
					$title = 'Single cabin';
				$v = "
				'" . $transfer_id . "',
				'$_frontIsLoggedin_user_id',
				'" . $title . "',
				'" . $clsTourCruisePriceCol->getMaxOrderNo() . "'
				";
				$clsTourCruisePriceCol->insertOne($f, $v);
			}
			for ($k = 0; $k < 2; $k++) {
				$f = "transfer_cruise_price_row_id,transfer_id,user_id,title,order_no";
				$transfer_cruise_price_row_id = $clsTourCruisePriceRow->getMaxId();
				$title = 'Row ' . ($k + 1);
				$v = "
				'$transfer_cruise_price_row_id',
				'" . $transfer_id . "',
				'$_frontIsLoggedin_user_id',
				'" . $title . "',
				'" . $clsTourCruisePriceRow->getMaxOrderNo() . "'
				";
				$clsTourCruisePriceRow->insertOne($f, $v);
			}
		} else return 1;
	}
	function updateNumberCountry()
	{
		#
		$clsTour = new Tour();
		$clsTourDestination = new TourDestination();
		$clsCountryEx = new Country();
		#
		$lstItem = $clsTour->getAll("");
		if (!empty($lstItem)) {
			for ($i = 0; $i < count($lstItem); $i++) {
				$res = $clsCountryEx->getAll("is_trash=0 and country_id IN (SELECT country_id FROM default_transfer_destination WHERE transfer_id = '" . $lstItem[$i]['transfer_id'] . "')");
				$countCountry = count($res);
				$clsTour->updateOne($lstItem[$i]['transfer_id'], "number_country = '" . $countCountry . "'");
			}
		}
	}
	function checkToursPromotion($pvalTable = 0)
	{
		$res = $this->getAll("is_trash=0 and transfer_id = '" . $pvalTable . "' and is_selling = 1 and hot_deals > 0 limit 0,1");
		return !empty($res) ? 1 : 0;
	}
	function getTripHotDeals($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'hot_deals');
		$hot_deals = $one['hot_deals'];
		if (!empty($hot_deals) && intval($hot_deals) > 0) {
			return '-' . $hot_deals . '%';
		}
	}
	function getLTripHotDeals($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'hot_deals');
		$hot_deals = $one['hot_deals'];
		if (!empty($hot_deals) && intval($hot_deals) > 0) {
			return $hot_deals . '%';
		}
	}
	function getListTypeTour($transfer_id = 0)
	{
		$list_type_id = $this->getOneField('list_type_id', $transfer_id);
		$tmp = explode('|', $list_type_id);
		$lst = array();
		for ($i = 0; $i < count($tmp); $i++) {
			if ($tmp[$i] != '' && $tmp[$i] != '0')
				$lst[] = $tmp[$i];
		}
		if ($lst[0] != '') return ($lst);
		return '';
	}
	function getSelectTripDuration($transfer_id = 0)
	{
		global $_LANG_ID, $core;

		$number_day = intval($this->getOneField('number_day', $transfer_id));
		$number_night = intval($this->getOneField('number_night', $transfer_id));
		if ($number_day == 0 && $number_night == 0)
			return '';
		if ($number_day == 1)
			return $core->get_Lang('Full day');

		$day = $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
		$night = $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
		return $day . ' / ' . $night;
	}
	function getTripDayDuration($transfer_id = 0)
	{
		global $_LANG_ID, $core;
		$one = $this->getOne($transfer_id, 'number_day');
		$number_day = $one['number_day'];
		$dayText = $number_day > 1 ? $number_day . ' ' . $core->get_Lang('days') : $number_day . ' ' . $core->get_Lang('day');
		return $dayText;
	}
	function getLocationMap($transfer_id = 0)
	{
		global $dbconn;
		$clsCity = new City();
		$clsGuide = new Guide();
		$clsTourDestination = new TourDestination();
		#
		$sql = "SELECT t1.city_id,t1.map_la,t1.map_lo,t1.map_zoom,t1.title FROM " . $clsCity->tbl . " t1 
		INNER JOIN " . $clsTourDestination->tbl . " t2 ON t1.city_id=t2.city_id 
		WHERE t1.is_trash=0 and t1.is_online=1 and t1.map_lo<>'' and t1.map_la<>'' and t2.transfer_id='$transfer_id' order by t2.order_no ASC";
		$listCity0 = $dbconn->GetAll("SELECT t1.city_id,t1.map_la,t1.map_lo,t1.title FROM " . $clsCity->tbl . " t1 
		INNER JOIN " . $clsTourDestination->tbl . " t2 ON t1.city_id=t2.city_id 
		WHERE t1.is_trash=0 and t1.is_online=1 and t1.map_lo<>'' and t1.map_la<>'' and t2.transfer_id='$transfer_id' order by t2.order_no ASC");

		$listCity = $clsTourDestination->getAll("is_trash=0 and transfer_id='$transfer_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");


		//print_r($listCity); die();
		$map_la = '';
		$map_lo = '';
		$map_zoom = $this->getMapZoom($transfer_id);
		$jscode = '';
		$location = '';
		if (!empty($listCity)) {
			foreach ($listCity as $k => $v) {
				if ($v['placetogo_id'] > 0) {
					$location .= '["' . trim($clsGuide->getTitle($v['placetogo_id'])) . '",' . trim($clsGuide->getMapLa($v['placetogo_id'])) . ',' . trim($clsGuide->getMapLo($v['placetogo_id'])) . ',' . $v['placetogo_id'] . ']';
					$location .= ($k == count($listCity) - 1) ? '' : ',';
					if ($map_la == '' || $map_lo == '') {
						$map_la = trim($clsGuide->getMapLa($v['placetogo_id']));
						$map_lo = trim($clsGuide->getMapLo($v['placetogo_id']));
					}
				} else {
					$location .= '["' . trim($clsCity->getTitle($v['city_id'])) . '",' . trim($clsCity->getMapLa($v['city_id'])) . ',' . trim($clsCity->getMapLo($v['city_id'])) . ',' . $v['city_id'] . ']';
					$location .= ($k == count($listCity) - 1) ? '' : ',';
					if ($map_la == '' || $map_lo == '') {
						$map_la = trim($clsCity->getMapLa($v['city_id']));
						$map_lo = trim($clsCity->getMapLo($v['city_id']));
					}
				}
			}
			unset($listCity);
		}
		$jscode = '<script type="text/javascript">
				var locations=[' . $location . '];
			</script>';
		//print_r($jscode); die();
		$ret['map_la'] = $map_la;
		$ret['map_lo'] = $map_lo;
		$ret['map_zoom'] = $map_zoom;
		$ret['jscode'] = $jscode;

		//print_r($ret); die();
		return $ret;
	}
	function getLocationMapList($transfer_id = 0)
	{
		global $dbconn;
		$clsCity = new City();
		$clsGuide = new Guide();
		$clsTourDestination = new TourDestination();
		#
		$sql = "SELECT t1.city_id,t1.map_la,t1.map_lo,t1.title FROM " . $clsCity->tbl . " t1 
		INNER JOIN " . $clsTourDestination->tbl . " t2 ON t1.city_id=t2.city_id 
		WHERE t1.is_trash=0 and t1.is_online=1 and t1.map_lo<>'' and t1.map_la<>'' and t2.transfer_id='$transfer_id' order by t2.order_no ASC";
		$listCity0 = $dbconn->GetAll("SELECT t1.city_id,t1.map_la,t1.map_lo,t1.title FROM " . $clsCity->tbl . " t1 
		INNER JOIN " . $clsTourDestination->tbl . " t2 ON t1.city_id=t2.city_id 
		WHERE t1.is_trash=0 and t1.is_online=1 and t1.map_lo<>'' and t1.map_la<>'' and t2.transfer_id='$transfer_id' order by t2.order_no ASC");

		$listCity = $clsTourDestination->getAll("is_trash=0 and transfer_id='$transfer_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");


		//print_r($listCity); die();
		$map_la = '';
		$map_lo = '';
		$jscode = '';
		$location = '';
		if (!empty($listCity)) {
			foreach ($listCity as $k => $v) {
				if ($v['placetogo_id'] > 0) {
					$location .= '["' . trim($clsGuide->getTitle($v['placetogo_id'])) . '",' . trim($clsGuide->getMapLa($v['placetogo_id'])) . ',' . trim($clsGuide->getMapLo($v['placetogo_id'])) . ',' . $v['placetogo_id'] . ']';
					$location .= ($k == count($listCity) - 1) ? '' : ',';
					if ($map_la == '' || $map_lo == '') {
						$map_la = trim($clsGuide->getMapLa($v['placetogo_id']));
						$map_lo = trim($clsGuide->getMapLo($v['placetogo_id']));
					}
				} else {
					$location .= '["' . trim($clsCity->getTitle($v['city_id'])) . '",' . trim($clsCity->getMapLa($v['city_id'])) . ',' . trim($clsCity->getMapLo($v['city_id'])) . ',' . $v['city_id'] . ']';
					$location .= ($k == count($listCity) - 1) ? '' : ',';
					if ($map_la == '' || $map_lo == '') {
						$map_la = trim($clsCity->getMapLa($v['city_id']));
						$map_lo = trim($clsCity->getMapLo($v['city_id']));
					}
				}
			}
			unset($listCity);
		}
		$jscode = '<script type="text/javascript">
				var locations=[' . $location . '];
			</script>';
		//print_r($jscode); die();
		$ret['map_la'] = $map_la;
		$ret['map_lo'] = $map_lo;
		$ret['jscode'] = $jscode;

		//print_r($ret); die();
		return $ret['jscode'];
	}

	function getLocationMap22($transfer_id = 0)
	{
		$clsCity = new City();
		$clsTourDestination = new TourDestination();
		#
		$listTourDestination = $clsTourDestination->getAll("is_trash=0 and transfer_id='$transfer_id' order by order_no asc");
		$location = '';
		$script_js = '';
		if (!empty($listTourDestination)) {
			for ($i = 0; $i < count($listTourDestination); $i++) {
				$location .= '["' . $clsCity->getMapHTML($listTourDestination[$i]['destination_id']) . '",' . $clsCity->getMapLa($listTourDestination[$i]['destination_id']) . ',' . $clsCity->getMapLo($listTourDestination[$i]['destination_id']) . ',' . $listTourDestination[$i]['destination_id'] . ']';
				$location .= ($i == count($listTourDestination) - 1) ? '' : ',';
			}
			$script_js .= '<script type="text/javascript">
				var locations=[' . $location . '];
			</script>';
		}
		return $script_js;
	}


	function getTripPriceByStartDate($transfer_start_date_id = 0)
	{
		global $clsISO;
		$clsTourStartDate = new TourStartDate();
		$all = $clsTourStartDate->getAll("transfer_start_date_id='$transfer_start_date_id'");
		$trip_price = $all[0]['price'];
		return ($trip_price);
	}
	function getSelectTour($transfer_id = '')
	{
		global $core, $_lang;
		$lstItem = $this->getAll("is_trash=0 order by order_no asc");
		$html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';
		#
		if (!empty($lstItem)) {
			foreach ($lstItem as $item) {
				$selected = ($transfer_id == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '"' . $selected . '>' . $this->getTripCode($item[$this->pkey]) . '-|-' . $this->getTitle($item[$this->pkey]) . '</option>';
			}
		}
		return $html;
	}
	function getListMeal()
	{
		global $core;
		$_array = array();
		$_array['B'] = $core->get_Lang('Breakfast');
		$_array['L'] = $core->get_Lang('Lunch');
		$_array['D'] = $core->get_Lang('Dinner');
		return $_array;
	}
	function getNameTypeMeal($type = '')
	{
		$lstType = $this->getListMeal();
		return $lstType[$type];
	}
	function getListTransport()
	{
		global $core;
		$clsTransport = new Transport();
		$assign_list["clsTransport"] = $clsTransport;
		$lstTransport = $clsTransport->getAll("is_trash=0 order by order_no desc");
		return $lstTransport;
	}
	function countTourItinerary($transfer_id = 0)
	{
		$clsTourItinerary = new TourItinerary();
		$all = $clsTourItinerary->getAll("is_trash=0 and transfer_id='$transfer_id'");
		return !empty($all) ? (count($all) > 9 ? count($all) : '0' . count($all)) : '00';
	}
	function countTourByRegion($country_id, $region_id = 0)
	{
		$where = "is_trash=0 and is_online=1 and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "transfer_destination WHERE country_id='$country_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE country_id='$country_id' and region_id='$region_id'))";
		return $this->countItem($where);
	}
	function countTourGolobal($country_id = 0, $city_id = 0, $cat_id = 0, $transfer_type_id = 0)
	{
		$where = "is_trash=0 and is_online=1";
		if (intval($country_id) > 0) {
			$where .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "transfer_destination WHERE country_id='$country_id')";
		}
		if (intval($city_id) > 0) {
			$where .= " and transfer_id IN (SELECT transfer_id FROM " . DB_PREFIX . "transfer_destination WHERE city_id='$city_id')";
		}
		if (intval($cat_id) > 0) {
			$where .= " and (cat_id = '" . $cat_id . "' or list_cat_id like '%|" . $cat_id . "|%')";
		}
		if (intval($transfer_type_id) > 0) {
			$where .= " and transfer_type_id ='$transfer_type_id'";
		}
		return $this->countItem($where);
	}

	function countTourHotel($transfer_id = 0)
	{
		$clsTourHotel = new TourHotel();
		$res = $clsTourHotel->getAll("is_trash=0 and transfer_id='$transfer_id' order by order_no desc", "hotel_id");
		if (!empty($res)) {
			$tmp = array();
			for ($i = 0; $i < count($res); $i++) {
				if ($res[$i]['hotel_id'] != '' && $res[$i]['hotel_id'] != '0' && !in_array($res[$i]['hotel_id'], $tmp))
					$tmp[] = $res[$i]['hotel_id'];
			}
			return count($tmp);
		}
		return 0;
	}
	function countByCat($cat_id = 0)
	{
		return $this->countItem("is_trash=0 and is_online=1 and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')");
	}
	function getSeasonPrice($transfer_id = 0, $season = '', $transfer_class_id = 0, $_type = '')
	{
		$price = 0;
		$clsTourSeasonPrice = new TourSeasonPrice();
		$lst = $clsTourSeasonPrice->getAll("transfer_id='$transfer_id' and season='$season' and transfer_class_id='$transfer_class_id' and _type='$_type' limit 0,1");
		if ($lst[0][$clsTourSeasonPrice->pkey] != '') {
			$price = $lst[0]['price'];
		}
		return $price;
	}
	function checkShowSeasonPrice($transfer_id = 0, $season = '', $transfer_class_id = 0, $_type = '')
	{
		$is_show = 1;
		$clsTourSeasonPrice = new TourSeasonPrice();
		$lst = $clsTourSeasonPrice->getAll("transfer_id='$transfer_id' and season='$season' and transfer_class_id='$transfer_class_id' and _type='$_type' limit 0,1");
		if ($lst[0][$clsTourSeasonPrice->pkey] != '') {
			$is_show = $lst[0]['is_hide'] == 1 ? 0 : 1;
		}
		return $is_show;
	}
	/////////*transferpromotion*/////////

	function getMinStartDatePromotionID($transfer_id = 0, $start_date = 0)
	{
		$clsHotPromotion = new HotPromotion();
		$lst = $clsHotPromotion->getAll("target_id='$transfer_id' and start_date >= '" . time() . "' and is_online=1 order by start_date asc limit 0,1");
		return $lst[0]['hot_promotion_id'];
	}

	function getDeparturePromotion($transfer_id = 0)
	{
		global $core, $clsISO;
		#
		$clsHotPromotion = new HotPromotion();
		#
		$tmp = $clsHotPromotion->getAll("target_id = '$transfer_id' and start_date >= '" . time() . "' and is_online=1 and type='TOUR' order by start_date asc limit 0,1");

		if (!empty($tmp)) {
			return date('d/m/Y', $tmp[0]['start_date']);
		} else {
			return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
		}
	}
	function checkDeparturePromotionOther($transfer_id = 0)
	{
		$clsHotPromotion = new HotPromotion();
		$res = $clsHotPromotion->getAll("target_id = '" . $transfer_id . "' and start_date>= '" . time() . "' and is_online=1 and type='TOUR' limit 0,1");
		return $res;
		return !empty($res) ? 1 : 0;
	}

	function getPriceTourPromotion($pvalTable = 0, $is_agent = 0)
	{
		global $core, $extLang, $_lang, $clsISO;
		#
		$clsHotPromotion = new HotPromotion();

		$clsTourPriceVal = new TourPriceVal();

		$one = $this->getOne($pvalTable);
		#
		$hot_promotion_id = $this->getMinStartDatePromotionID($pvalTable);

		if (intval($hot_promotion_id) > 0) {
			$price_last_hour = $clsHotPromotion->getOneField("price_last_hour", $hot_promotion_id);
			$price_adult = $clsHotPromotion->getOneField("price", $hot_promotion_id);
			$price_agent = $clsHotPromotion->getOneField("price_agent", $hot_promotion_id);
		}

		if ($is_agent == 1) {
			$priceBooking = $price_agent;
			$sqlPrice = $clsTourPriceVal->getAll("transfer_id='$pvalTable' and transfer_price_row_id=16 and departure_date=0 and price > 0 and is_agent=1 limit 0,1");
		} else {
			$priceBooking = $price_adult;
			$sqlPrice = $clsTourPriceVal->getAll("transfer_id='$pvalTable' and transfer_price_row_id=16 and departure_date=0 and price > 0 and is_agent=0 limit 0,1");
		}

		$priceAdultAds = $sqlPrice[0]['price'];


		$html = '<div class="price">
			  <div>
				  <div class="price_left">
					<span class="original_price">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($priceAdultAds) . '</span></span>
				  </div>
				  <div class="discounted_price">
						<span>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($priceBooking) . '</span>
				  </div>
			  </div>
		  </div>';
		$html2 = '<div class="price">
			  <div>
				  <div class="discounted_price">
						<span>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($priceAdultAds) . '</span>
				  </div>
			  </div>
		  </div>';
		$html3 = '<div class="price">
			  <div>
				  <div class="discounted_price">
						<span>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($priceBooking) . '</span>
				  </div>
			  </div>
		  </div>';

		#	
		if ($priceAdultAds > 0 && $priceBooking > 0) {
			return $html;
		} elseif ($priceBooking > 0) {
			return $html3;
		} elseif ($priceAdultAds > 0) {
			return $html2;
		} else {
			return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
		}
	}
}
