<?php

class Tour extends dbBasic
{
    function __construct()
    {
        $this->pkey = "tour_id";
        $this->tbl = DB_PREFIX . "tour";
    }
    function updateOne($pkey = "", $set = "", $debug = false)
    {
        if (is_array($set)) {
            $set['upd_date'] = time();
        } else {
            $set .= ", `upd_date`='" . time() . "'";
        }

        return parent::updateOne($pkey, $set, $debug);
    }
    function checkExitsId($tour_id = 0)
    {
        $res = $this->getAll("tour_id = '{$tour_id}' LIMIT 0,1");
        return !empty($res) ? 1 : 0;
    }

    function checkOnlineBySlug($pvalTable = 0, $slug = '')
    {
        $res = $this->getAll("is_trash=0 and is_online=1 and tour_id='$pvalTable' and slug='$slug'", $this->pkey);
        return !empty($res) ? 1 : 0;
    }

    function checkExitsYieldID($yield_id = 0)
    {
        global $dbconn, $_LANG_ID, $clsConfiguration;
        $cond = "yield_id='{$yield_id}'";
        if (MULTIPLE_LANG) {
            if ($this->checkColumnInTable('lang_id')) {
                $SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);
                if (!empty($_LANG_ID) && $_LANG_ID != $SiteDefaultLanguage) {
                    $cond .= " and lang_id='{$_LANG_ID}' ";
                } else {
                    $cond .= " and lang_id='' ";
                }
            }
        }
        return $this->countItem($cond);
    }

    function checkExitsTMSCode($tms_code = '')
    {
        global $dbconn, $_LANG_ID, $clsConfiguration;
        $cond = "tms_code='{$tms_code}'";
        if (MULTIPLE_LANG) {
            if ($this->checkColumnInTable('lang_id')) {
                $SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);
                if (!empty($_LANG_ID) && $_LANG_ID != $SiteDefaultLanguage) {
                    $cond .= " and lang_id='{$_LANG_ID}' ";
                } else {
                    $cond .= " and lang_id='' ";
                }
            }
        }
        return $this->countItem($cond);
    }

    function getDueDate($tour_id = 0, $start_date = '')
    {
        $number_day = $this->getOneField('number_day', $tour_id);
        return $start_date + 24 * 60 * 60 * ($number_day - 1);
    }

    function checkBookingConditional($tour_id = 0, $tour_start_date_id = 0)
    {
        $check = 0;
        $day = $this->getOneField('booking_front_date', $tour_id);
        $clsTourStartDate = new TourStartDate();
        $start_date = $clsTourStartDate->getOneField('start_date', $tour_start_date_id);
        if ($start_date > time() + ($day - 1) * 24 * 60 * 60) return 1;
        return $check;
    }

    function checkStatusDateClass($tour_id = 0, $tour_start_date_id = 0, $tour_class_id = 0)
    {
        $check = 0;
        $clsTourStartDatePrice = new TourStartDatePrice();
        $res = $clsTourStartDatePrice->getAll("tour_id='$tour_id' and tour_start_date_id='$tour_start_date_id' and tour_class_id='$tour_class_id'");
        if ($res[0][$clsTourStartDatePrice->pkey] != '') {
            $check = $res[0]['is_hide'];
        }
        return $check;
    }

    function getListCat_V2($tour_id = 0)
    {
        $clsTourDomainStore = new TourDomainStore();
        $list_cat_id = $clsTourDomainStore->getListCatID($tour_id, _DOMAIN_ID);
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
        global $clsISO;
        #
        $one = $this->getOne($pvalTable, 'star_id');
        $star_number = $one['star_id'];
        #
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

    function updateMinPriceTour($pvalTable = 0)
    {
        global $dbconn, $adult_type_id;
        $clsTourPriceGroup = new TourPriceGroup();
        $field_tour_option = $this->getOneField('tour_option', $pvalTable);
        $list_tour_class_id = $field_tour_option ? $field_tour_option : 0;

        $field_adult_group_size = $this->getOneField('adult_group_size', $pvalTable);
        $list_adult_group_size_id = $field_adult_group_size ? $field_adult_group_size : 0;

        $sql = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and tour_visitor_type_id =$adult_type_id and tour_class_id IN ($list_tour_class_id) and tour_number_group_id IN ($list_adult_group_size_id)";
        $min_price = $dbconn->GetOne($sql);
        if (!empty($min_price)) {
            $this->updateOne($pvalTable, "min_price='" . $min_price . "'");
        } else {
            $this->updateOne($pvalTable, "min_price='0'");
        }

        $sql1 = "tour_id='$pvalTable' and (tour_class_id NOT IN ($list_tour_class_id))";
        $clsTourPriceGroup->deleteByCond($sql1);
        $sql2 = "tour_id='$pvalTable' and tour_visitor_type_id='$adult_type_id' and tour_number_group_id NOT IN ($list_adult_group_size_id)";
        $clsTourPriceGroup->deleteByCond($sql2);
        return 1;
    }

    function getPriceDay($tour_id = 0, $tour_class_id = 0, $tour_start_date_id = 0)
    {
        global $clsISO;
        $season = 'low';
        $clsTourStartDatePrice = new TourStartDatePrice();
        $tmp = $clsTourStartDatePrice->getAll("tour_id='$tour_id' and tour_start_date_id='$tour_start_date_id' and tour_class_id='$tour_class_id' limit 0,1");
        $price = $tmp[0]['price'];
        if ($price == 0 || $price == '') {
            $price2 = $this->getPriceSeason($season, $tour_id, $tour_class_id);
            return $clsISO->formatNumberToEasyRead($price2);
        }
        $price += $price * (($this->getMarkUp($tour_id, $clsISO->getCustomerType())) / 100);
        return $clsISO->formatNumberToEasyRead($price);
    }

    function getPriceSeason($season = 0, $tour_id = 0, $tour_class_id = 0)
    {
        global $clsISO;
        $price = 0;
        $clsTourSeasonPrice = new TourSeasonPrice();
        $lst = $clsTourSeasonPrice->getAll("tour_id='$tour_id' and season='$season' and tour_class_id='$tour_class_id' and _type='client' limit 0,1");
        if ($lst[0][$clsTourSeasonPrice->pkey] != '') {
            $price = $lst[0]['price'];
        }
        if ($price == 0) $price = $this->getOneField('trip_price', $tour_id);
        $price += $price * (($this->getMarkUp($tour_id, $clsISO->getCustomerType())) / 100);
        return $price;
    }

    function getMarkUp($tour_id = 0, $_type = '')
    {
        global $_LANG_ID, $gid;
        $clsCommon = new Common();
        $common_id = 1;
        if ($_type != 'client') {
            $percent = $this->getOneField('config_markup_tour_agent', $tour_id);
            if ($percent == 0) {
                $percent = $clsCommon->getOneField('config_markup_tour_agent', $common_id);
            }
        } else {
            $percent = $this->getOneField('config_markup_tour', $tour_id);
            if ($percent == 0) {
                $percent = $clsCommon->getOneField('config_markup_tour', $common_id);
            }
        }
        return $percent;
    }

    function counTotalTourItinerary($pval = 0)
    {
        $clsTourItinerary = new TourItinerary();
        $res = $clsTourItinerary->getAll("is_trash=0 and tour_id = '$pval'");
        return !empty($res) ? count($res) : 0;
    }

    function getTourTypeRoot($tour_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($tour_id);
        $list_cat_id = $one['list_cat_id'];
        $list_cat_id = rtrim($list_cat_id, '|');
        $list_cat_id = ltrim($list_cat_id, '|');
        $list_cat_id = explode('|', $list_cat_id);
        if ($clsISO->checkInArray($list_cat_id, '19') == '0') {
            return 0;
        } else if ($clsISO->checkInArray($list_cat_id, '21') == '0') {
            return 1;
        }
    }

    function checkTourType($tour_id = 0, $tour_type_id = 0)
    {
        $list_tour_type_id = $this->getOneField('tour_type_id', $tour_id);
        if ($list_tour_type_id == '' || $tour_type_id == '') {
            return 0;
        }
        if (str_replace('|' . $tour_type_id . '|', '', $list_tour_type_id) == $list_tour_type_id)
            return 0;
        return 1;
    }

    function checkTourItineraryOld($tour_id = 0)
    {
        $clsTourItinerary = new TourItinerary();
        $one = $this->getOne($tour_id, "number_day,duration_type");
        if ($one['duration_type'] == 0 && $one['number_day'] == 1) {
            $total_itinerary = $clsTourItinerary->countItem("tour_id='{$tour_id}'");
            if ($total_itinerary > 0)
                return 1;
            return 0;
        }
    }

    function checkTourItinerary($tour_id = 0)
    {
        $clsTourItinerary = new TourItinerary();
        $one = $this->getOne($tour_id, "number_day,duration_type");
        if ($one['duration_type'] == 0 && $one['number_day'] >= 1) {
            $total_itinerary = $clsTourItinerary->countItem("tour_id='{$tour_id}'");
            if ($total_itinerary >= $one['number_day'])
                return 1;
            return 0;
        } elseif ($one['duration_type'] == 1) {
            return 0;
        }
        return 1;
    }

    function getTitle($tour_id = 0, $oDataTable = null)
    {
        if (!isset($oDataTable['title'])) {
            $oDataTable = $this->getOne($tour_id, 'title');
        }
        return $oDataTable['title'] ?? '';
    }

    function getMinPrice($tour_id = 0, $oDataTable = null)
    {
        if (!isset($oDataTable['min_price'])) {
            $oDataTable = $this->getOne($tour_id, 'min_price');
        }
        return $oDataTable['min_price'];
    }

    function getMinPriceByCountry(int $country_id = 0)
    {
        $clsTourDestination = new TourDestination();
        $all = $this->getAll("min_price > 0 and tour_id IN (select tour_id from $clsTourDestination->tbl where country_id = $country_id)", "MIN(min_price) as min_price");
        return $all[0]['min_price'];
    }

    function getMinPriceByCountryNew(int $country_id = 0)
    {
        $clsTourDestination = new TourDestination();
        $all = $this->getAll("min_price > 0 and tour_id IN (select tour_id from $clsTourDestination->tbl where country_id = $country_id)", "MIN(min_price) as min_price");

        // Kiểm tra nếu có giá trị và định dạng số tiền
        if (!empty($all) && isset($all[0]['min_price'])) {
            return number_format($all[0]['min_price'], 0, '.', '.'); // Định dạng số tiền với dấu . ngăn cách
        }

        return null; // Trả về null nếu không tìm thấy giá trị
    }


    function getDeposit($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'deposit');
        return $one['deposit'];
    }

    function getTitlePhoto($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'title_photo');
        return $one['title_photo'];
    }

    function getCatId($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'cat_id');
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

    function getLocation($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'location');
        return $one['location'];
    }

    function getShortTitle($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'title_short');
        return $one['title_short'];
    }

    function getSlug($tour_id = 0)
    {
        global $_LANG_ID, $core;
        $one = $this->getOne($tour_id, 'slug,title');
        return $one['slug'] == '' ? $core->replaceSpace($one['title']) : $one['slug'];
    }

    function getBySlug($slug = '')
    {
        $all = $this->getAll("is_trash=0 and slug = '$slug' limit 0,1", $this->pkey);
        return $all[0]['tour_id'];
    }

    function getUspPoints($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'usp_points');
        return html_entity_decode($one['usp_points']);
    }

    function getMetaDescription($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['overview'])) {
            $one = $this->getOne($pvalTable, 'overview');
        }
        return html_entity_decode($one['overview']);
    }

    function getKeyInfo($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'key_information');
        return html_entity_decode($one['key_information']);
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

    function getTripOverview($pvalTable = 0, $one = null)
    {
        if (!isset($one['overview'])) {
            $one = $this->getOne($pvalTable, 'overview');
        }
        return html_entity_decode($one['overview'] ?? '', ENT_QUOTES, 'UTF-8');
    }

    function getTripStay($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'stay');
        return html_entity_decode($one['stay'] ?? '', ENT_QUOTES, 'UTF-8');
    }

    function getTripMeal($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'meal');
        return html_entity_decode($one['meal'] ?? '', ENT_QUOTES, 'UTF-8');
    }

    function getTripactivity($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'activity');
        return html_entity_decode($one['activity'] ?? '', ENT_QUOTES, 'UTF-8');
    }

 function getThingToCarry($pvalTable = 0, $one = null)
{
    $pvalTable = (int)$pvalTable;

    if (
        !is_array($one)
        || !isset($one['thing_to_carry'])
    ) {
        $one = $this->getOne(
            $pvalTable,
            'thing_to_carry'
        );
    }

    if (
        !is_array($one)
        || !isset($one['thing_to_carry'])
        || $one['thing_to_carry'] === null
    ) {
        return '';
    }

    return html_entity_decode(
        (string)$one['thing_to_carry'],
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );
}

    function getAdvisory($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'advisory');
        return html_entity_decode($one['advisory']);
    }

    function getCancellationPolicy($pvalTable = 0, $one = null)
    {
        if (!isset($one['cancellation_policy'])) {
            $one = $this->getOne($pvalTable, 'cancellation_policy');
        }
        return html_entity_decode($one['cancellation_policy']);
    }

    function getRefundPolicy($pvalTable = 0, $one = null)
    {
            $pvalTable = (int)$pvalTable;

    if (
        !is_array($one)
        || !isset($one['refund_policy'])
    ) {
        $one = $this->getOne(
            $pvalTable,
            'refund_policy'
        );
    }

    if (
        !is_array($one)
        || !isset($one['refund_policy'])
        || $one['refund_policy'] === null
    ) {
        return '';
    }

    return html_entity_decode(
        (string)$one['refund_policy'],
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );

    }

    function getConfirmationPolicy($pvalTable = 0, $one = null)
    {
                    $pvalTable = (int)$pvalTable;

    if (
        !is_array($one)
        || !isset($one['confirmation_policy'])
    ) {
        $one = $this->getOne(
            $pvalTable,
            'confirmation_policy'
        );
    }

    if (
        !is_array($one)
        || !isset($one['confirmation_policy'])
        || $one['confirmation_policy'] === null
    ) {
        return '';
    }

    return html_entity_decode(
        (string)$one['confirmation_policy'],
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );

    }

    function getStripIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'intro,content');
        if (!empty($one['intro']))
            return strip_tags(html_entity_decode($one['intro'] ?? ''));
        return strip_tags(html_entity_decode($one['content'] ?? ''));
    }

    function getNote($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'note_price_table');
        return html_entity_decode($one['note_price_table']);
    }

    function getLink($pvalTable = 0, $oDataTable = null)
    {
        global $extLang, $_LANG_ID;
        if (!isset($oDataTable['slug'])) {
            $oDataTable = $this->getOne($pvalTable, 'slug');
        }
        return $extLang . '/t' . $pvalTable . '-' . $oDataTable['slug'] . '.html';
    }

    function getLinkEditAdmin($pvalTable = 0, $cat= null, $target = null)
    {
        global $extLang, $_LANG_ID;
        if ($cat === null || $target === null) {
            if (!isset($oDataTable['slug'])) {
                $oDataTable = $this->getOne($pvalTable, 'slug');
            }
            return '/admin/tour_iso/edit/' . $pvalTable . '/' . $oDataTable['slug'];
        }
        return '/admin/tour_iso/edit/' . $pvalTable . '/' . $cat . '/' . $target;
    }


    function getLinkLoad($tour_id = 0)
    {
        global $_LANG_ID, $extLang;
        return 'tour/' . $this->getSlug($tour_id) . '-ct' . $tour_id . '.html';
    }

    function getLinkPromotion($tour_id = 0)
    {
        global $_LANG_ID, $extLang;
        return $extLang . '/tour/' . $this->getSlug($tour_id) . '-pr' . $tour_id . '.html';
    }

    function getLinkBook($tour_id = 0)
    {
        global $_LANG_ID, $extLang;
        return $extLang . '/tour/' . $this->getSlug($tour_id) . '/booking.html';
    }

    function getLinkBookExtra($tour_id = 0)
    {
        global $_LANG_ID, $extLang;
        return $extLang . '/tour/' . $this->getSlug($tour_id) . '/bookingextra.html';
    }

    function getLinkCart($tour_id = 0)
    {
        global $clsISO;
        return $clsISO->getLink('cart');
    }

    function getLinkBookDeparture($tour_id = 0, $departure_date = 0)
    {
        global $_LANG_ID;
        if ($_LANG_ID != 'en') {
            $extLang = '/' . $_LANG_ID;
        } else {
            $extLang = '';
        }
        return $extLang . '/tour/' . $this->getSlug($tour_id) . '_' . $departure_date . '/booking.html';
    }

    function getLinkBookPromotion($tour_id = 0, $start_date = 0)
    {
        global $_LANG_ID, $extLang;
        vnSessionSetVar('start_date', $start_date);
        return $extLang . '/tours/' . $this->getSlug($tour_id) . '/bookingpromotion.html';
    }

    function getFileProgram($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'file_programme');
        return $one['file_programme'];
    }

    function getLinkConfirm($tour_id = 0)
    {
        return '/book-confirmation/' . $this->getSlug($tour_id) . '.html';
    }

    function getLinkCustomize($tour_id = 0)
    {
        global $extLang;
        return $extLang . '/tour/enquiry/' . $this->getSlug($tour_id) . '.html';
    }

    function getLinkDetailStartDate($tour_id = 0, $start_date = 0)
    {
        global $_LANG_ID, $extLang;
        return $extLang . '/tour/' . $this->getSlug($tour_id) . '_t' . $tour_id . 'd' . $start_date . '.html';
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

    function getStar($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'star_id');
        return $one['star_id'];
    }

    function getIsBestPrice($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'is_best_price');
        return $one['is_best_price'];
    }

    function getIsRecommended($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'is_recommended');
        return $one['is_recommended'];
    }

    function getHighlight($tour_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($tour_id, 'highlight');
        if ($one['highlight'] != '')
            return html_entity_decode($one['highlight']);
        return '';
    }

    function getInclusion($tour_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['inclusion'])) {
            $one = $this->getOne($tour_id, 'inclusion');
        }
        if ($one['inclusion'] != '')
            return html_entity_decode($one['inclusion']);
        return '';
    }

    function getExclusion($tour_id = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['exclusion'])) {
            $one = $this->getOne($tour_id, 'exclusion');
        }
        if ($one['exclusion'] != '')
            return html_entity_decode($one['exclusion']);
        return '';
    }

    function getAddInformation($tour_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($tour_id, 'information');
        if ($one['information'] != '')
            return html_entity_decode($one['information']);
        return '';
    }

    function getTripGroupSize($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'trip_groupsize');
        return $one['trip_groupsize'];
    }

    function getTripOldPrice($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'trip_old_price');
        $clsISO = new ISO();
        if (!empty($one['trip_old_price']))
            return $clsISO->formatPrice($one['trip_old_price']) . ' ' . $clsISO->getRate();
    }

    function getMinStartDateID($tour_id = 0, $start_date = 0)
    {
        $clsTourStartDate = new TourStartDate();
        $lst = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date='" . $start_date . "' and is_trash=0 order by start_date asc limit 0,1");
        return $lst[0]['tour_start_date_id'];
    }

    function getDepartureCityFrom($tour_id = 0)
    {
        $clsCity = new City();
        $clsCountry = new Country();
        $clsTourDestination = new TourDestination();
        $all = $clsTourDestination->getAll("is_trash=0 and tour_id = '$tour_id' order by order_no asc limit 0,1");
        return '<a class="color_333" href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . '</a>';
    }

    function getDepartureCity($tour_id = 0)
    {
        $clsCity = new City();
        $one = $this->getOne($tour_id, 'departure_point_id');
        return $clsCity->getTitle($one['departure_point_id']);
    }

    function getTextdepartureCityEnd($tour_id = 0, $fullText = '')
    {
        $clsCity = new City();
        $clsCountry = new Country();
        $clsTourDestination = new TourDestination();
        $all = $clsTourDestination->getAll("is_trash=0 and tour_id = '$tour_id' order by order_no desc limit 0,1");
        $name_country = $clsCountry->getTitle($all[0]['country_id']);
        return ($fullText == 'full') ? (($all[0]['city_id'] != 0) ? $clsCity->getTitle($all[0]['city_id']) . ', ' . $name_country : $name_country) : $clsCity->getTitle($all[0]['city_id']);
    }

    function getListDeparturePoint($tour_id = 0)
    {
        $clsCity = new City();
        $clsCountry = new Country();
        if ($this->checkIsPackage($tour_id)) $tour_id = $this->getParentId($tour_id);
        $one = $this->getOne($tour_id, 'list_departure_point_id');
        if (!empty($one['list_departure_point_id'])) {
            $list_deopart = trim($one['list_departure_point_id'], '|');
            $list_deopart = explode('|', $list_deopart);
            $depart_point = '';
            foreach ($list_deopart as $key => $item) {
                $name_city = $clsCity->getTitle($item);
                if ($key == 0) {
                    $depart_point .= $name_city;
                    $country_id = $clsCity->getOneField('country_id', $item);
                    $name_country = $clsCountry->getTitle($country_id);
                } else {
                    $depart_point .= ', ' . $name_city;
                }
            }
            if (count($list_deopart) == 1) {
                return $depart_point . ', ' . $name_country;
            } else {
                return $depart_point;
            }
        }
    }

    function getCityCountryFromDeparture($tour_id = 0)
    {
        $clsCity = new City();
        $clsCountry = new Country();
        $one = $this->getOne($tour_id, 'departure_point_id');
        $oneCity = $clsCity->getOne($one['departure_point_id'], "$clsCity->pkey, country_id, title");
        if (!empty($oneCity)) {
            return $oneCity["title"] . ", " . $clsCountry->getTitle($oneCity["country_id"]);
        }
        return "";
    }

    function getListDeparturePointLink($tour_id = 0, $oneTable = null)
    {
        $clsCity = new City();
        if ($this->checkIsPackage($tour_id)) $tour_id = $this->getParentId($tour_id);
        if (!isset($oneTable['list_departure_point_id'])) {
            $oneTable = $this->getOne($tour_id, 'list_departure_point_id');
        }

        $depart_point = '';
        if (!empty($oneTable['list_departure_point_id'])) {
            $list_deopart = trim($oneTable['list_departure_point_id'], '|');
            $list_deopart = explode('|', $list_deopart);
            foreach ($list_deopart as $key => $item) {
                $oneCity = $clsCity->getOne($item, 'title,slug,country_id');
                $name_city = $oneCity['title'];
                if ($key == 0) {
                    $depart_point .= '<a class="linkcity" target="_parent" href="' . $clsCity->getLinkTour($item, $oneCity) . '" title="' . $name_city . '">' . $name_city . '</a>';
                } else {
                    $depart_point .= ', <a class="linkcity" target="_parent" href="' . $clsCity->getLinkTour($item, $oneCity) . '" title="' . $name_city . '">' . $name_city . '</a>';
                }
            }
        }
        return $depart_point;
    }

    function getListActivities($tour_id = 0, $one = null)
    {
        if (!isset($one['list_activities_id'])) {
            $one = $this->getOne($tour_id, 'list_activities_id');
        }
        $list_activities_id = trim($one['list_activities_id'], '|');
        $list_activities_id = str_replace('|', ',', $list_activities_id);
        return $list_activities_id;
    }

    function getListService($tour_id = 0, $one = null)
    {
        if (!isset($one['list_service_id'])) {
            $one = $this->getOne($tour_id, 'list_service_id');
        }
        $list_service_id = trim(($one['list_service_id'] ?? ''), '|');
        $list_service_id = str_replace('|', ',', $list_service_id);
        return $list_service_id;
    }

    function getLinkDepartureCity($tour_id = 0)
    {
        $clsCity = new City();
        $one = $this->getOne($tour_id, 'departure_point_id');
        return $clsCity->getLink($one['departure_point_id'], 'tour');
    }

    function getIntroTripPrice($tour_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($tour_id, 'intro_trip_price');
        if ($one['intro_trip_price'] != '')
            return html_entity_decode($one['intro_trip_price']);
        return '';
    }

    function getTourStartDateID($tour_id = 0, $now_day = 0)
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;
        $clsProperty = new Property();
        $clsTourStartDate = new TourStartDate();
        $clsTourPriceGroup = new TourPriceGroup();
        $listTourDeparture = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id ='$tour_id' and start_date > '$now_day' order by start_date ASC", $clsTourStartDate->pkey . ",tour_id,start_date");
        $tour_start_date_id = $listTourDeparture[0][$clsTourStartDate->pkey];
        return $tour_start_date_id;
    }

    function getTripDepartureDate($tour_id = 0, $now_day = 0)
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;
        $clsProperty = new Property();
        $clsTourStartDate = new TourStartDate();
        $clsTourPriceGroup = new TourPriceGroup();
        $listTourDeparture = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id ='$tour_id' and start_date > '$now_day' order by start_date ASC", $clsTourStartDate->pkey . ",tour_id,start_date");
        $start_date = $listTourDeparture[0]['start_date'];
        return $start_date;
    }

    function getTripPrice($pvalTable = 0, $departure = '', $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $short_rate;
        #-- FCK CODE
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourStore = new TourStore();
        if (_IS_PROMOTION == 1) {
            $Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$pvalTable' and is_online=1 and " . $departure . " between  start_date and end_date order by start_date ASC limit 0,1";
            $promotion = $dbconn->GetOne($Sql_Promotion);
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            $pricePromotion = $priceAdultAds - ($promotion * $priceAdultAds / 100);
            #
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block color_main size18"><span class="size15 color_666 line_through">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block color_main size18">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block color_main size18"><span class="size15 color_666 line_through">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span> ' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block color_main size18">' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<div class="price">
									  <div class="discounted_price">
											<span class="color_main"><span class="size15 color_666 line_through">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>
									  </div>
									</div>';
                            } else {
                                return '<div class="price">
									  <div class="discounted_price">
											<span class="color_main">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>
									  </div>
									</div>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<div class="price">
									<div class="discounted_price">
										<span class="color_main"><span class="size15 color_666 line_through">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>
									</div>
								</div>';
                            } else {
                                return '<div class="price">
									  <div class="discounted_price">
											<span class="">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>
									  </div>
									</div>';
                            }
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                    } else {
                    }
                }
            }
        } else {
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            #
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return '<div class="price">
								  <div class="discounted_price">
										<span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>
								  </div>
								</div>';
                        } else {
                            return '<div class="price">
								  <div class="discounted_price">
										<span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>
								  </div>
								</div>';
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                    } else {
                    }
                }
            }
        }
    }

    function getTripPriceOneDeparture($tour_id = 0, $start_date = 0, $is_agent = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourStartDate = new TourStartDate();
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date ='$start_date'  and departure_date <> '' and tour_visitor_type_id='$adult_type_id'";
        //return $SQL;
        $priceAdultAds = $dbconn->GetOne($SQL);
        if ($priceAdultAds > 0) {
            if ($is_agent == 'AGENT') {
                if ($priceAdultAds > 0) {
                    return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100)) . $short_rate;
                } else {
                    return '';
                    $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='$start_date' and tour_visitor_type_id='0'";
                    $priceAdultAds = $dbconn->GetOne($SQL);
                    return $priceAdultAds ? $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100)) . $short_rate : '';
                }
            } elseif ($is_agent == 'CTV') {
                if ($priceAdultAds > 0) {
                    return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100)) . $short_rate;
                } else {
                    return '';
                    $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='$start_date' and tour_visitor_type_id='0'";
                    $priceAdultAds = $dbconn->GetOne($SQL);
                    return $priceAdultAds ? $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100)) . $short_rate : '';
                }
            } else {
                if ($priceAdultAds > 0) {
                    return $clsISO->formatPrice($priceAdultAds) . $short_rate;
                } else {
                    return '';
                    $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='$start_date' and tour_visitor_type_id='0'";
                    $priceAdultAds = $dbconn->GetOne($SQL);
                    return $clsISO->formatPrice($priceAdultAds) ? $clsISO->formatPrice($priceAdultAds) . $short_rate : '';
                }
            }
        } else {
            return '';
        }
    }

    function getTripPriceOneDepartureValue($tour_id = 0, $start_date = 0, $is_agent = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourStartDate = new TourStartDate();
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date ='$start_date'  and departure_date <> '' and tour_visitor_type_id='$adult_type_id'";
        //return $SQL;
        $priceAdultAds = $dbconn->GetOne($SQL);
        if ($priceAdultAds > 0) {
            return $priceAdultAds;
        } else {
            return '';
            $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='$start_date' and tour_visitor_type_id='0'";
            $priceAdultAds = $dbconn->GetOne($SQL);
            return $priceAdultAds;
        }
    }

    function getTripPriceNoDeparture($tour_id = 0, $is_agent = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $clsISO, $short_rate;
        $clsProperty = new Property();
        $clsTourStore = new TourStore();
        $clsTourPriceGroup = new TourPriceGroup();
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date ='0' and tour_visitor_type_id='$adult_type_id'";
        $priceAdultAds = $dbconn->GetOne($SQL);
        if ($is_agent == 'AGENT') {
            if ($priceAdultAds > 0) {
                return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100)) . $short_rate;
            } else {
                return '';
                $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='0' and tour_visitor_type_id='0'";
                $priceAdultAds = $dbconn->GetOne($SQL);
                return $priceAdultAds ? $clsISO->formatPrice($priceAdultAds - (DISCOUNT_AGENT * $priceAdultAds / 100)) . $short_rate : '';
            }
        } elseif ($is_agent == 'CTV') {
            if ($priceAdultAds > 0) {
                return $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100)) . $short_rate;
            } else {
                return '';
                $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='0' and tour_visitor_type_id='0'";
                $priceAdultAds = $dbconn->GetOne($SQL);
                return $priceAdultAds ? $clsISO->formatPrice($priceAdultAds - (DISCOUNT_CTV * $priceAdultAds / 100)) . $short_rate : '';
            }
        } else {
            if ($priceAdultAds > 0) {
                return $clsISO->formatPrice($priceAdultAds) . $short_rate;
            } else {
                return '';
                $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='0' and tour_visitor_type_id='0'";
                $priceAdultAds = $dbconn->GetOne($SQL);
                return $clsISO->formatPrice($priceAdultAds) ? $clsISO->formatPrice($priceAdultAds) . $short_rate : '';
            }
        }
    }

    function getTripPriceNoDepartureValue($tour_id = 0, $is_agent = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $clsISO;
        $clsProperty = new Property();
        $clsTourStore = new TourStore();
        $clsTourPriceGroup = new TourPriceGroup();
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price > 0 and departure_date ='0' and tour_visitor_type_id='$adult_type_id'";
        $priceAdultAds = $dbconn->GetOne($SQL);
        if ($priceAdultAds > 0) {
            return $priceAdultAds;
        } else {
            return '';
            $SQL = "SELECT MIN(price_single_supply) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$tour_id' and price_single_supply > 0 and departure_date ='0' and tour_visitor_type_id='0'";
            $priceAdultAds = $dbconn->GetOne($SQL);
            return $priceAdultAds;
        }
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
            return $clsISO->formatPrice($priceAdultAds) . '' . $clsISO->getRate();
        } else {
            return '';
        }
    }

    function getTripPrice2019($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourStore = new TourStore();
        if (_IS_PROMOTION == 1) {
            $Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$pvalTable' and is_online=1 and " . $departure . " between  start_date and end_date order by start_date ASC limit 0,1";
            $promotion = $dbconn->GetOne($Sql_Promotion);
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            $pricePromotion = $priceAdultAds - ($promotion * $priceAdultAds / 100);
            #
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block text_right size20">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20">' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block text_right size20">' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20">' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block text_right size20">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20">' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block text_right size20">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                    }
                }
            }
        } else {
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            #
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                    } else {
                    }
                }
            }
        }
    }

    function getLTripPriceDetail($pvalTable = 0, $type = '')
    {
        global $core, $extLang, $_lang, $clsConfiguration;
        $clsProperty = new Property();
        #
        $clsISO = new ISO();
        $one = $this->getOne($pvalTable);
        $tour_start_date_id = $this->getMinStartDateID($pvalTable);
        if ($tour_start_date_id != '') {
            $clsTourStartDate = new TourStartDate();
            return $clsISO->formatPrice($clsTourStartDate->getOneField("price", $tour_start_date_id)) . ' ' . $clsISO->getRate();
        }
        $trip_price = $one['trip_price'];
        if ($trip_price == '' || $trip_price == 0) {
            return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('Contact') . '</a>';
        } elseif ($type == 'header') {
            return '<span class="original_price"><span>' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($trip_price) . '<p class="per_person">' . $core->get_Lang('per adult') . '</p>
              </span></span>';
        }
        return '<span class="amount">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($trip_price) . '</span><span class="amount"><span class="per_person_new"> ' . $core->get_Lang('per adult') . '</span></span>';
    }

    function getTripPriceOrgin($tour_id = 0)
    {
        global $clsISO;
        $one = $this->getOne($tour_id, 'trip_price');
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

    function getTripPriceNewPro($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $hasAPI, $short_rate;
        if ($hasAPI) {
            $price = 0;
            $clsVietISOSDK = new VietISOSDK();
            $tour_id = $pvalTable;
            $currency_id = $clsISO->getDefaultCurrency();
            $currency = $clsISO->getRateSign($currency_id);
            $info_price = $clsVietISOSDK->getInfoPrice($tour_id);
            $tour_option_id = $this->getOneField('tour_option_id', $tour_id);
            $is_sic = $tour_option_id == 1 ? 1 : 0;
            //$clsISO->pre($info_price);die;
            $yieldOp = $info_price['yieldOp'];
            $yieldPax = $info_price['yieldPax'];
            $yield_op_id = 0;
            if (!empty($yieldOp)) {
                foreach ($yieldOp as $k_op => $one_op) {
                    if ($one_op['start_date'] <= time() && time() <= $one_op['due_date']) {
                        $yield_op_id = $one_op['yield_op_id'];
                        break;
                    } elseif (empty($yield_op_id) && $one_op['start_date'] <= time()) {
                        $yield_op_id = $one_op['yield_op_id'];
                    }
                }
            }
            if (!empty($yield_op_id)) {
                if ($is_sic) {
                    $yieldNett = $info_price['yieldNett'];
                } else {
                    $yieldEstimate = $info_price['yieldEstimate'];
                    if (!empty($yieldPax)) {
                        foreach ($yieldPax as $k_pax => $onePax) {
                            $oneEstimate = $clsVietISOSDK->getOneEstimate(array("yield_op_id" => $yield_op_id, "yield_pax_id" => $onePax['yield_pax_id'], "currency_id" => $currency_id, "yieldEstimate" => $yieldEstimate));
                            $op_price_markup = $clsISO->convertRateUpgrade($oneEstimate['currency_id'], $currency_id, $oneEstimate['op_price_markup']);
                            if (empty($price)) {
                                $price = $op_price_markup;
                            } elseif ($price > $op_price_markup) {
                                $price = $op_price_markup;
                            }
                        }
                    }
                }
            }
            if ($type == 'value') {
                return $clsISO->roundPrice($price, $currency_id, 1);
            } else {
                return $clsISO->formatPriceRead($price, $currency_id);
            }
        } else {
            $clsProperty = new Property();
            $clsTourPriceGroup = new TourPriceGroup();
            $clsPromotion = new Promotion();
            $clsPromotionItem = new PromotionItem();
            $clsTourStore = new TourStore();
            if (_IS_PROMOTION == 1) {
                // $Sql_Promotion = "SELECT promot FROM ".DB_PREFIX."promotion WHERE clsTable='Tour' and target_id='$pvalTable' and is_online=1 and ".$departure." between  start_date and end_date order by start_date ASC limit 0,1";
                $Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE pi.is_online = 1 and p.is_online = 1 and p.type = 'Tour' and pi.taget_id =$pvalTable and " . $departure . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";;
                $promotion = $dbconn->GetOne($Sql_Promotion);
                if (_IS_DEPARTURE == 1) {
                    if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                    } else {
                        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                    }
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
                //return $SQL;
                $priceAdultAds = $dbconn->GetOne($SQL);
                $pricePromotion = $priceAdultAds - ($promotion * $priceAdultAds / 100);
                if ($type == 'value') {
                    return $clsISO->formatPrice($priceAdultAds);
                } elseif ($type == 'nomem') {
                    if ($priceAdultAds > 0) {
                        if ($_LANG_ID == 'vn') {
                            return '<div class="price">
								<div class="discounted_price">
									<span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>
								</div>
							</div>';
                        } else {
                            return '<div class="price">
								<div class="discounted_price">
									<span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>
								</div>
							</div>';
                        }
                    }
                } elseif ($type == 'detailnomem') {
                    if ($priceAdultAds > 0) {
                        if ($_LANG_ID == 'vn') {
                            return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else {
                    if ($priceAdultAds > 0) {
                        if ($type == 'detail') {
                            if ($_LANG_ID == 'vn') {
                                if ($promotion > 0) {
                                    return '<span class="block color_main size18"><span class="size15 color_666 line_through">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                                } else {
                                    return '<span class="block color_main size18">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                                }
                            } else {
                                if ($promotion > 0) {
                                    return '<span class="block color_main size18"><span class="size15 color_666 line_through">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span> ' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                                } else {
                                    return '<span class="block color_main size18">' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                                }
                            }
                        } else {
                            if ($_LANG_ID == 'vn') {
                                if ($promotion > 0) {
                                    return '<div class="price">
										  <div class="discounted_price">
												<span class="color_main"><span class="size15 color_666 line_through">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>
										  </div>
										</div>';
                                } else {
                                    return '<div class="price">
										  <div class="discounted_price">
												<span class="color_main">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>
										  </div>
										</div>';
                                }
                            } else {
                                if ($promotion > 0) {
                                    return '<div class="price">
										<div class="discounted_price">
											<span class="color_main"><span class="size15 color_666 line_through">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>
										</div>
									</div>';
                                } else {
                                    return '<div class="price">
										  <div class="discounted_price">
												<span class="color_main">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>
										  </div>
										</div>';
                                }
                            }
                        }
                    } else {
                        if ($type == 'detail') {
                            return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                        } else {
                        }
                    }
                    //                return $pricePromotion;
                }
            } else {
                if (_IS_DEPARTURE == 1) {
                    if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                    } else {
                        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                    }
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
                $priceAdultAds = $dbconn->GetOne($SQL);
                #
                if ($type == 'value') {
                    return $clsISO->formatPrice($priceAdultAds);
                } else {
                    if ($priceAdultAds > 0) {
                        if ($type == 'detail') {
                            if ($_LANG_ID == 'vn') {
                                return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            } else {
                                return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        } else {
                            if ($_LANG_ID == 'vn') {
                                return '<div class="price">
									  <div class="discounted_price">
											<span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>
									  </div>
									</div>';
                            } else {
                                return '<div class="price">
									  <div class="discounted_price">
											<span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>
									  </div>
									</div>';
                            }
                        }
                    } else {
                        if ($type == 'detail') {
                            return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                        } else {
                        }
                    }
                }
            }
        }
    }

    function getTripPriceNewPro2019($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $clsTourStore = new TourStore();
        if (_IS_PROMOTION == 1) {
            //            $Sql_Promotion = "SELECT promot FROM ".DB_PREFIX."promotion WHERE clsTable='Tour' and target_id='$pvalTable' and is_online=1 and ".$departure." between  start_date and end_date order by start_date ASC limit 0,1";
            $Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE pi.is_online = 1 and p.is_online = 1 and p.type = 'Tour' and pi.taget_id =$pvalTable and " . $departure . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
            $promotion = $dbconn->GetOne($Sql_Promotion);
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            $pricePromotion = $priceAdultAds - ($promotion * $priceAdultAds / 100);
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } elseif ($type == 'nomem') {
                if ($priceAdultAds > 0) {
                    if ($_LANG_ID == 'vn') {
                        return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                    } else {
                        return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                    }
                }
            } elseif ($type == 'detailnomem') {
                if ($priceAdultAds > 0) {
                    if ($_LANG_ID == 'vn') {
                        return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                    } else {
                        return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                    }
                }
            } elseif ($type == 'box_home') {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block size20"><del style="font-size: 14px;font-weight: normal;color: #ffffff;">' . $clsISO->formatPrice($priceAdultAds) . '' . $short_rate . '</del>' . ' ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block  size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"><del style="font-size: 14px;font-weight: normal;color: #ffffff;">' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</del></br>' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                    } else {
                    }
                }
                //                return $pricePromotion;
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span><del style="font-size: 14px;font-weight: normal;color: #888888;">' . $clsISO->formatPrice($priceAdultAds) . '' . $short_rate . '</del>' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span><del style="font-size: 14px;font-weight: normal;color: #888888;">' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</del>' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                            }
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                    } else {
                    }
                }
                //                return $pricePromotion;
            }
        } else {
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            #
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<div class="price"><a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a></div>';
                    } else {
                    }
                }
            }
        }
    }

    function getTripPriceNewPro2020($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $deviceType, $package_id;
        # Check nếu tour đó có package thì lấy package có giá min
        if ($package = $this->getPackageMinPrice($pvalTable)) {
            $pvalTable = $package;
        }
        #
        if (_IS_PROMOTION == 1) {
            return $this->getTripPriceOnPromotion($pvalTable, $departure, $is_agent, $type);
        } else {
            return $this->getTripPriceNoPromotion($pvalTable, $departure, $is_agent, $type);
        }
    }

    function getTourStartDate($pvalTable = 0, $departure = 0, $field = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $deviceType, $now_day;
        $clsTourStartDate = new TourStartDate();
        $timer = $departure ? $departure : time();
        if ($field == 'close_sale_date') {
            $listTourStartDateClose = $clsTourStartDate->getAll("is_trash=0 and is_active=1 and tour_id='$pvalTable' and start_date > '$timer' and open_sale_date <= '$timer' and close_sale_date > '$timer' and is_last_hour=1 order by start_date ASC", $field);
            return $listTourStartDateClose ? $listTourStartDateClose[0][$field] : '';
        } else {
            $listTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_active=1 and tour_id='$pvalTable' and start_date > '$timer' order by start_date ASC limit 0,1", $clsTourStartDate->pkey . ',price_type,price');
        }
        if (!empty($field)) {
        }
        return $listTourStartDate ? $listTourStartDate : '';
    }

    function getTripPriceOnPromotion($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $deviceType, $now_day, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourStore = new TourStore();
        $clsTourStartDate = new TourStartDate();
        $timer = time();
        #
        $discount = $clsISO->getPromotion($pvalTable, 'Tour', $now_day, $now_day, 'info_promotion');
        //var_dump($discount);
        #
        if (_IS_DEPARTURE == 1) {
            if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                $listTourStartDate = $this->getTourStartDate($pvalTable, $departure);

                if (empty($listTourStartDate)) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
                    $priceAdultAds = $dbconn->GetOne($SQL);
                } else {
                    if ($listTourStartDate[0]['price_type'] == 1) {
                        $price = json_decode($listTourStartDate[0]['price'], true);
                        $price = $price[$adult_type_id];
                        foreach ($price as $key => $value) {
                            $min_price[$key] = min($value);
                        }

                        $min_price = min($min_price);
                        $priceAdultAds = str_replace('.', '', $min_price);
                    } else {
                        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
                        $priceAdultAds = $dbconn->GetOne($SQL);
                    }
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
                $priceAdultAds = $dbconn->GetOne($SQL);
            }
        } else {
            $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
            $priceAdultAds = $dbconn->GetOne($SQL);
        }
        #

        $promotion = 0;
        if (!empty($discount)) {
            $promotion = $discount['discount_value'];
            //var_dump($promotion);
            if ($discount['discount_type'] == 2) {
                $promotionPrice = $promotion * $priceAdultAds / 100;
                if (isset($discount['max_discount']) && (intval($discount['max_discount']) > 0)) {
                    $promotionPrice = min($promotionPrice, $discount['max_discount']);
                }   
                //var_dump($priceAdultAds, $promotion, $pricePromotion);
            } else {
                $promotionPrice = $discount['discount_value'];
            }
            $pricePromotion = $priceAdultAds - $promotionPrice;
        }
        #
        if ($type == 'value') {
            return $clsISO->formatPrice($priceAdultAds);
        } elseif ($type == 'nomem') {
            if ($priceAdultAds > 0) {
                if ($_LANG_ID == 'vn') {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                } else {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                }
            }
        } elseif ($type == 'detailnomem') {
            if ($priceAdultAds > 0) {
                if ($_LANG_ID == 'vn') {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                } else {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                }
            }
        } elseif ($type == 'box_home') {
            if ($priceAdultAds > 0) {
                if ($type == 'detail') {
                    if ($_LANG_ID == 'vn') {
                        if ($pricePromotion > 0) {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        }
                    } else {
                        if ($pricePromotion > 0) {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($pricePromotion > 0) {
                            return '<del>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del><span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            if ($deviceType == 'phone') {
                            } else {
                                return '<span class="size20 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span><del>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del>';
                            }
                        } else {
                            return '<span class="size20 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        }
                    } else {
                        if ($pricePromotion > 0) {
                            return '<span class="size20 color_c81e3a text_bold"><span class="size18">' . $short_rate . '</span>' . $clsISO->formatPrice($pricePromotion) . '</span><del>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del>' . ' ';
                        } else {
                            return '<span class="size20 color_c81e3a text_bold"></span>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                    return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
                } else {
                }
            }
        } else {
            if ($priceAdultAds > 0) {
                if ($type == 'detail') {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<del>' . $clsISO->formatPrice($priceAdultAds) . ' ' . $short_rate . '</del>' . ' <span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . ' <span class="size24">' . $short_rate . '</span></span> ';
                        } else {
                            return '<span class="size20 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<del>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del> <span class="size24 color_fb1111 color_c81e3a text_bold"><span class="size24">' . $short_rate . '</span>' . $clsISO->formatPrice($pricePromotion) . '</span> ';
                        } else {
                            return '<span class="size20 color_fb1111 color_c81e3a text_bold">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else if ($type == 'new2024') {
                    if ($promotion > 0) {
                        if ($_LANG_ID == 'vn') {
                            return '<del class="old_price">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</del> <span class="size20 color_c81e3a text_bold hnv_price_new">' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                        } else {
                            return '<del class="old_price">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del><span class="size20 color_c81e3a text_bold hnv_price_new"><span class="">
                            ' . $short_rate . '</span>' . $clsISO->formatPrice($pricePromotion) . '</span> ';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return "<div class='hnv_trvs_main_tour_item_content_price_number'><span>{$clsISO->formatPrice($priceAdultAds)}$short_rate</span></div>";
                        } else {
                            return "<div class='hnv_trvs_main_tour_item_content_price_number'>$short_rate<span>{$clsISO->formatPrice($priceAdultAds)}</span></div>";
                        }
                    }
                } else if ($type == 'hnv_new2024') {
                    if ($promotion > 0) {
                        if ($_LANG_ID == 'vn') {
                            return
                                $clsISO->formatPrice($priceAdultAds) . ' <del>' . $short_rate . '</del>
                                <span class="size24 color_fb1111 color_c81e3a text_bold">
                                    <span>' . $clsISO->formatPrice($pricePromotion) . '</span> ' . $short_rate . '
                                </span> ';
                        } else {
                            return '
                                <del>' . $short_rate . '</del>' . $clsISO->formatPrice($priceAdultAds) . ' 
                                <span class="size24 color_fb1111 color_c81e3a text_bold">
                                    ' . $short_rate . ' <span>' . $clsISO->formatPrice($pricePromotion) . '</span> 
                                </span> 
                            ';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return '<span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<p class="price_old mb0 color_1c1c1c color_717171">' . $core->get_Lang('from') . ' <del>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</del></p>
							<p class="mb0"><span class="size20 color_fb1111 color_c81e3a text_bold 1">' . $clsISO->formatPrice($pricePromotion) . '<span class="size18">' . $short_rate . '</span></span></p>';
                            if ($deviceType == 'phone') {
                            } else {
                                return '<span class="size20 color_c81e3a text_bold 2">' . $clsISO->formatPrice($pricePromotion) . '<span class="size18">' . $short_rate . '</span></span><del>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</del>';
                            }
                        } else {
                            return '<p class="price_old mb0 color_1c1c1c color_717171">' . $core->get_Lang('from') . '</p>
								<p class="mb0"><span class="size20 color_c81e3a text_bold 3">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span></p>';
                            if ($deviceType == 'phone') {
                            } else {
                                return '<span class="size24 color_fb1111 color_c81e3a text_bold 4">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<p class="price_old txt_from mb0"> ' . $core->get_Lang("From") . ' <del>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</del></p>
							<p class="mb0"><span class="size20 color_c81e3a text_bold">' . $short_rate . $clsISO->formatPrice($pricePromotion) . '</span></p>
                            <p class="text_person">/' . $core->get_Lang('person') . '</p>';
                        } else {
                            return '<p class="price_old txt_from mb0">' . $core->get_Lang("From") . '</p>
								<p class="mb0"><span class="size20 color_c81e3a text_bold">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span></p>
                                <p class="text_person">/' . $core->get_Lang('person') . '</p>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                } else {
                }
            }
        }
    }

    function getTripPriceNoPromotion($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $deviceType, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $clsTourStore = new TourStore();
        if (_IS_DEPARTURE == 1) {
            if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
            }
        } else {
            $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
        }
        $priceAdultAds = $dbconn->GetOne($SQL);
        #
        if ($type == 'value') {
            return $clsISO->formatPrice($priceAdultAds);
        } else {
            if ($priceAdultAds > 0) {
                if ($type == 'detail') {
                    if ($_LANG_ID == 'vn') {
                        return '<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span></p>';
                    } else {
                        return '<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span></p>';
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        return '<p class="price_old mb0 color_1c1c1c color_717171">Chỉ từ</p>
								<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span></p>
								<p class="text mb0 color_666">/Du khách</p>';
                    } else {
                        return '<span class="size24 color_fb1111 color_c81e3a text_bold"><span class="size18">' . $short_rate . '</span> ' . $clsISO->formatPrice($priceAdultAds) . '</span> ';
                    }
                }
            } else {
                if ($type == 'detail') {
                    return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
                } else {
                }
            }
        }
    }

    function getTripPriceNoPromotionDepartureDate($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $deviceType, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $clsTourStore = new TourStore();
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
        $priceAdultAds = $dbconn->GetOne($SQL);
        #
        if ($type == 'value') {
            return $clsISO->formatPrice($priceAdultAds);
        } else {
            if ($priceAdultAds > 0) {
                if ($type == 'detail') {
                    if ($_LANG_ID == 'vn') {
                        return '<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span></p>';
                    } else {
                        return '<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span></p>';
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        return '<p class="price_old mb0 color_1c1c1c color_717171">Chỉ từ</p>
								<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span></p>
								<p class="text mb0 color_666">/Du khách</p>';
                    } else {
                        return '<p class="price_old mb0 color_1c1c1c color_717171">' . $core->get_Lang('From') . '</p>
								<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold"><span class="size18">' . $short_rate . '</span> ' . $clsISO->formatPrice($priceAdultAds) . '</span></p>
								<p class="text mb0 color_666">/' . $core->get_Lang('Person') . '</p>';
                    }
                }
            } else {
                if ($type == 'detail') {
                    return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
                } else {
                }
            }
        }
    }

    function getTripPriceTourDeprture($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $deviceType, $now_day, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourStore = new TourStore();
        $clsTourStartDate = new TourStartDate();
        $timer = time();


        $listTourStartDate = $this->getTourStartDate($pvalTable, $departure);
        if (empty($listTourStartDate)) {
            $priceAdultAds = 0;
        } else {
            if ($listTourStartDate[0]['price_type'] == 1) {
                $price = json_decode($listTourStartDate[0]['price'], true);
                $price = $price[$adult_type_id];
                foreach ($price as $key => $value) {
                    $min_price[$key] = min($value);
                }
                $min_price = min($min_price);
                $priceAdultAds = str_replace('.', '', $min_price);
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id'";
                $priceAdultAds = $dbconn->GetOne($SQL);
            }
            $discount = $clsISO->getPromotion($pvalTable, 'Tour', $now_day, $now_day, 'info_promotion');
        }

        if (!empty($discount)) {
            if ($discount['discount_type'] == 2) {
                $promotion = $discount['discount_value'];
                $pricePromotion = $priceAdultAds - ($promotion * $priceAdultAds / 100);
            } else {
                $pricePromotion = $discount['discount_value'];
            }
        }

        //		print_r($SQL);die();

        if ($type == 'value') {
            return $clsISO->formatPrice($priceAdultAds);
        } elseif ($type == 'nomem') {
            if ($priceAdultAds > 0) {
                if ($_LANG_ID == 'vn') {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                } else {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                }
            }
        } elseif ($type == 'detailnomem') {
            if ($priceAdultAds > 0) {
                if ($_LANG_ID == 'vn') {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                } else {
                    return '<span class="size24 color_fb1111 color_c81e3a text_bold"> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                }
            }
        } elseif ($type == 'box_home') {
            if ($priceAdultAds > 0) {
                if ($type == 'detail') {
                    if ($_LANG_ID == 'vn') {
                        if ($pricePromotion > 0) {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        }
                    } else {
                        if ($pricePromotion > 0) {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span> ' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                        } else {
                            return '<span class="block text_right size20"><span class="block size13" style="font-size: 16px !important;">' . $core->get_Lang('From') . '</span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($pricePromotion > 0) {
                            return '<del>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del><span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            if ($deviceType == 'phone') {
                            } else {
                                return '<span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span><del>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del>';
                            }
                        } else {
                            return '<span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        }
                    } else {
                        if ($pricePromotion > 0) {
                            return '<span class="size24 color_fb1111 color_c81e3a text_bold"><span class="size18">' . $short_rate . '</span>' . $clsISO->formatPrice($pricePromotion) . '</span><del>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</del>' . ' ';
                        } else {
                            return '<span class="size24 color_fb1111 color_c81e3a text_bold"></span>' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                    return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
                } else {
                }
            }
        } else {
            if ($priceAdultAds > 0) {
                if ($type == 'detail') {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<del>' . $clsISO->formatPrice($priceAdultAds) . ' ' . $short_rate . '</del>' . ' <span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . ' <span class="size24">' . $short_rate . '</span></span> ';
                        } else {
                            return '<span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . ' ' . $short_rate . '</span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<del>' . $short_rate . '</del>' . $clsISO->formatPrice($priceAdultAds) . ' <span class="size24 color_fb1111 color_c81e3a text_bold"><span class="size24">' . $short_rate . '</span> ' . $clsISO->formatPrice($pricePromotion) . '</span> ';
                        } else {
                            return '<span class="size24 color_fb1111 color_c81e3a text_bold">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<p class="price_old mb0 color_1c1c1c color_717171">Giá từ <del>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</del></p>
							<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . '<span class="size18">' . $short_rate . '</span></span></p>';
                            if ($deviceType == 'phone') {
                            } else {
                                return '<span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($pricePromotion) . '<span class="size18">' . $short_rate . '</span></span><del>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</del>';
                            }
                        } else {
                            return '<p class="price_old mb0 color_1c1c1c color_717171">Giá từ</p>
								<p class="mb0"><span class="size22 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span></p>';
                            if ($deviceType == 'phone') {
                            } else {
                                return '<span class="size24 color_fb1111 color_c81e3a text_bold">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<span class="size24 color_fb1111 color_c81e3a text_bold"><span class="size18">' . $short_rate . '</span> ' . $clsISO->formatPrice($pricePromotion) . '</span> <del>' . $short_rate . '</del>' . ' ' . $clsISO->formatPrice($priceAdultAds) . ' ';
                        } else {
                            return '<span class="size24 color_fb1111 color_c81e3a text_bold">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                } else {
                }
            }
        }
    }

    function getTourPromotion($tour_id = 0)
    {
        global $clsISO;
        $cond = "is_trash=0 and is_online=1 and $tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_store WHERE is_trash=0 and _type='PROMOTION')";
        $lstAll = $this->getAll($cond);
        return $lstAll[0]['tour_id'];
    }

    function getTripCode($pvalTable = 0, $oDataTable = array())
    {
        if (!isset($oDataTable['trip_code'])) {
            $oDataTable = $this->getOne($pvalTable, 'trip_code');
        }
        return strtoupper($oDataTable['trip_code']);
    }

    function getTMSCode($pvalTable = 0, $oDataTable = array())
    {
        if (!isset($oDataTable['tms_code'])) {
            $oDataTable = $this->getOne($pvalTable, 'tms_code');
        }
        return strtoupper($oDataTable['tms_code']);
    }

    function getArrivalTime($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'arrival_time');
        return strtoupper($one['arrival_time']);
    }

    function getTablePriceTitle($pvalTable = 0)
    {
        global $core;
        $one = $this->getOne($pvalTable, 'table_price_title');
        return !empty($one['table_price_title']) ? $one['table_price_title'] : $core->get_Lang('Price Options');
    }

    function getTripDuration2020($tour_id = 0, $type = '', $oneTable = null)
    {
        // type=' ' <=> 3 days 2 nights || type='/ '<=> 3 days/ 2 nights || type=', '<=> 3 days, 2 nights
        global $_LANG_ID, $core, $_lang;
        if (!isset($oneTable)) {
            $oneTable = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
        }

        $duration_type = $oneTable['duration_type'];
        if ($duration_type == 1) {
            return $oneTable['duration_custom'];
        } else {
            $number_day = intval($oneTable['number_day']);
            $number_night = intval($oneTable['number_night']);
            if ($number_day == 1 && $number_night == 0) { {
                    return $core->get_Lang('1 day');
                }
            }
            #
            if ($number_night == 0) {
                $number_night = $number_day - 1;
            }
            #
            $str = '';
            $str .= $number_day . ' ' . $core->get_Lang('days');
            $str .= $type ? $type : ' ';
            $str .= $number_night . ' ' . $core->get_Lang('nights');
            return $str;
        }
    }

    function getTripDuration($tour_id = 0)
    {
        global $_LANG_ID, $core, $_lang;
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
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
        if ($number_night == 0 && $number_day > 0) {
            $number_night = $number_day - 1;
        }
        #
        $str = '';
        $str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
        $str .= ' / ' . $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
        return $str;
    }

    function getTripDuration2019($tour_id = 0, $type = '')
    {
        global $_LANG_ID, $core, $_lang;
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
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
        if ($type != '') {
            $str .= ' ' . $type . ' ';
        } else {
            $str .= ' ';
        }
        $str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
        return $str;
    }

    function getLTripDuration($tour_id = 0, $type = '')
    {
        global $_LANG_ID, $core, $_lang, $clsISO;
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night,dra_hours,dra_min');
        $duration_type = $one['duration_type'];
        $number_day = intval($one['number_day']);
        $number_night = intval($one['number_night']);
        $dra_hours = intval($one['dra_hours']);
        $dra_min = intval($one['dra_min']);

        if ($duration_type == 1) {
            if ($type == 'booking') {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return ' <span class="spanncontentt">' . $one['duration_custom'] . '</span>';
                }
            } else {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return ' <span class="text">' . $one['duration_custom'] . '</span>';
                }
            }
        }
        if ($number_day == 1 && $number_night == 0) { {
                if ($type == 'booking') {
                    return ' <span class="spanncontentt">' . $core->get_Lang('Full Day') . '</span>';
                }
                return ' <span class="text">' . $core->get_Lang('Full Day') . '</span>';
            }
        }
        #
        if ($number_day > 1 && $number_night == 0) {
            $number_night = $number_day - 1;
        }
        if ($number_day <= 0 && $number_night <= 0) {
            if ($type == 'booking') {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return '';
                }
            } else {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return '';
                }
            }
        }
        #
        if ($type == 'booking') {
            if ($dra_hours > 0 && $dra_min <= 0) {
                $str = '<span class="spanncontentt">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= '</span>';
            } elseif ($dra_hours <= 0 && $dra_min > 0) {
                $str = '<span class="spanncontentt">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } elseif ($dra_hours > 0 && $dra_min > 0) {
                $str = '<span class="spanncontentt">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= ' <span class="spanncontentt">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } else {
                $str = '<span class="spanncontentt">';
                $str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
                $str .= ' <span class="spanncontentt">';
                $str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
                $str .= '</span>';
            }
        } else {
            if ($dra_hours > 0 && $dra_min <= 0) {
                $str = '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= '</span>';
            } elseif ($dra_hours <= 0 && $dra_min > 0) {
                $str = '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } elseif ($dra_hours > 0 && $dra_min > 0) {
                $str = '<i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= ' <span class="text">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } else {
                $str = '<span class="text">';
                $str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
                $str .= ' <span class="text">';
                $str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
                $str .= '</span>';
            }
        }
        return $str;
    }

    function getLTripDuration1($tour_id = 0, $type = '')
    {
        global $_LANG_ID, $core, $_lang;
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night,dra_hours,dra_min');
        $duration_type = $one['duration_type'];
        $number_day = intval($one['number_day']);
        $number_night = intval($one['number_night']);
        $dra_hours = intval($one['dra_hours']);
        $dra_min = intval($one['dra_min']);
        if ($duration_type == 1) {
            if ($type == 'booking') {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<span class="spanncontentt">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return '<span class="spanncontentt">' . $one['duration_custom'] . '</span>';
                }
            } else {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<span class="spanncontentt">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return '<span class="text">' . $one['duration_custom'] . '</span>';
                }
            }
        }
        if ($number_day == 1 && $number_night == 0) { {
                if ($type == 'booking') {
                    return '<span class="spanncontentt">' . $core->get_Lang('Full Day') . '</span>';
                }
                return '<span class="text">' . $core->get_Lang('Full Day') . '</span>';
            }
        }
        #
        if ($number_day > 1 && $number_night == 0) {
            $number_night = $number_day - 1;
        }
        if ($number_day <= 0 && $number_night <= 0) {
            if ($type == 'booking') {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<span class="spanncontentt">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<<span class="spanncontentt">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return '';
                }
            } else {
                if ($dra_hours > 0 && $dra_min <= 0) {
                    return '<span class="text">' . $dra_hours . ' ' . $core->get_Lang('Hours') . '</span>';
                } elseif ($dra_hours <= 0 && $dra_min > 0) {
                    return '<span class="text">' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } elseif ($dra_hours > 0 && $dra_min > 0) {
                    return '<span class="text">' . $dra_hours . ' ' . $core->get_Lang('Hours') . ' ' . $dra_min . ' ' . $core->get_Lang('Min') . '</span>';
                } else {
                    return '';
                }
            }
        }
        #
        if ($type == 'booking') {
            if ($dra_hours > 0 && $dra_min <= 0) {
                $str = '<span class="spanncontentt">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= '</span>';
            } elseif ($dra_hours <= 0 && $dra_min > 0) {
                $str = '<span class="spanncontentt">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } elseif ($dra_hours > 0 && $dra_min > 0) {
                $str = '<span class="spanncontentt">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= '</span> <span class="spanncontentt">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } else {
                $str = '<span class="spanncontentt">';
                $str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('Days') : $core->get_Lang('Day'));
                $str .= '</span> <span class="spanncontentt">';
                $str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('Nights') : $core->get_Lang('Night'));
                $str .= '</span>';
            }
        } else {
            if ($dra_hours > 0 && $dra_min <= 0) {
                $str = '<span class="text">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= '</span>';
            } elseif ($dra_hours <= 0 && $dra_min > 0) {
                $str = '<span class="text">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } elseif ($dra_hours > 0 && $dra_min > 0) {
                $str = '<span class="text">';
                $str .= $dra_hours . ' ' . ($dra_hours > 1 ? $core->get_Lang('Hours') : $core->get_Lang('Hour'));
                $str .= '</span> <span class="text">';
                $str .= $dra_min . ' ' . ($dra_min > 1 ? $core->get_Lang('Mins') : $core->get_Lang('Min'));
                $str .= '</span>';
            } else {
                $str = '<span class="text">';
                $str .= $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('Days') : $core->get_Lang('Day'));
                $str .= '</span> <span class="text">';
                $str .= $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('Nights') : $core->get_Lang('Night'));
                $str .= '</span>';
            }
        }
        return $str;
    }

    function getNumberDayDuration($tour_id = 0)
    {
        global $core, $_LANG_ID;
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
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
        $day2019 = '<span>' . $core->get_Lang('days') . '</span>';
        $str .= $number_day . ' ' . ($number_day > 1 ? $day2019 : $day2019);
        return $str;
    }

    function getTripDuration00($tour_id = 0, $only_day = false)
    {
        global $_LANG_ID, $core;
        $one = $this->getOne($tour_id, "number_day,number_night");
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

    function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        #
        if (!isset($oneTable['image'])) {
            $oneTable = $this->getOne($pvalTable, 'image');
        }
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            if ($w != 0 && $h != 0) {
                return $clsISO->tripslashImage($image, $w, $h);
            } else {
                return $image;
            }
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

    function getTourPriceGroup($tour_id = 0, $departure_date = 0)
    {
        global $core, $mod, $act, $clsISO, $clsConfiguration, $_LANG_ID, $adult_type_id, $short_rate;
        $clsTour = new Tour();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourProperty = new TourProperty();
        $clsTourOption = new TourOption();
        $clsProperty = new Property();
        #
        $currency = $clsConfiguration->getValue('Currency');
        $lstTourVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by tour_property_id ASC");
        $VisitorTypeIdAdult = $lstTourVisitorType[0][$clsTourProperty->pkey];
        $lstTourOption = $clsTour->getOneField('tour_option', $tour_id);
        $lstOption = array();
        if ($lstTourOption != '' && $lstTourOption != '0') {
            $TMP = explode(',', $lstTourOption);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstOption)) {
                    $lstOption[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstOption'] = $lstOption;
        $lstAdultSizeGroup = $clsTour->getOneField('adult_group_size', $tour_id);
        $lstAdultSize = array();
        if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
            $TMP = explode(',', $lstAdultSizeGroup);
            for ($i = 0; $i < count($TMP); $i++) {
                if (!in_array($TMP[$i], $lstAdultSize)) {
                    $lstAdultSize[] = $TMP[$i];
                }
            }
        }
        $assign_list['lstAdultSize'] = $lstAdultSize;
        #
        if (!empty($lstOption)) {
            $html .= '
			<table class="table tbl-grid h-tbl-grid" style="border:1px solid #ccc; min-width:100%;">
				<thead style="background:#9b9fa0; color:#fff">
					<tr>
						<td class="gridheader" width="150" height="60" rowspan="2" style="padding:0; width:150px">
							<div class="h-boxdiagonal">
								<div class="h-diagonal"></div>
								<div class="boxdiagonal-class"><span class="table_price_title">' . $core->get_Lang('Tour Class') . '</span></div>
								<div class="boxdiagonal-group"><span class="table_price_title">' . $core->get_Lang('Group Number') . '</span></div>
							</div>
						</td>';
            foreach ($lstTourVisitorType as $a => $b) {
                if ($clsTourPriceGroup->CheckPriceByNumberGroupClass($tour_id, $b[$clsTourProperty->pkey]) && $b[$clsTourProperty->pkey] == $adult_type_id) {
                    $html .= '<td class="gridheader" height="40" align="center" colspan="' . count($lstAdultSize) . '">';
                    $html .= '<span>' . $clsTourProperty->getTitle($b[$clsTourProperty->pkey]) . '</span>
								</td>';
                }
            }
            $html .= '<td class="gridheader" rowspan="2" align="center">
								<span class="table_price_title">' . $core->get_Lang('Single supplement') . '</span>
									</td>';
            $html .= '</tr><tr>';
            foreach ($lstTourVisitorType as $a => $b) {
                if ($clsTourPriceGroup->CheckPriceByNumberGroupClass($tour_id, $b[$clsTourProperty->pkey])) {
                    foreach ($lstAdultSize as $k => $v) {
                        if ($b[$clsTourProperty->pkey] == $adult_type_id) {
                            $html .= '<td class="gridheader" style="text-align:center;">' . $clsTourOption->getTitle($v) . '</td>';
                        }
                    }
                }
            }
            $html .= '</tr>';
            $html .= '
				</thead>';
            foreach ($lstOption as $key => $val) {
                $html .= '
					<tr>
						<td style="text-align:left;">' . $clsTourOption->getTitle($val) . '</td>';
                foreach ($lstTourVisitorType as $a => $b) {
                    if ($clsTourPriceGroup->CheckPriceByNumberGroupClass($tour_id, $b[$clsTourProperty->pkey])) {
                        foreach ($lstAdultSize as $k => $v) {
                            if ($b[$clsTourProperty->pkey] == $adult_type_id) {
                                $html .= '<td class="text-center h-price-val" ' . $tour_id . '-' . $val . '-' . $v . '-' . $b[$clsTourProperty->pkey] . '-' . $departure_date . '>';
                                if ($clsTourPriceGroup->getPromotionValue($tour_id, $val, $v, $b[$clsTourProperty->pkey], $departure_date) > 0) {
                                    $html .= '<span class="color_666 line_through">' . $short_rate . $clsTourPriceGroup->getPriceTableTourGroup($tour_id, $val, $v, $b[$clsTourProperty->pkey], $departure_date) . '</span>';
                                }
                                $html .= '<span class="bold color_main size18">' . ($clsTourPriceGroup->getPriceTableTourGroupPromotion($tour_id, $val, $v, $b[$clsTourProperty->pkey], $departure_date) > 0 ? $short_rate . $clsTourPriceGroup->getPriceTableTourGroupPromotion($tour_id, $val, $v, $b[$clsTourProperty->pkey], $departure_date) : '-') . '</span>';
                                $html .= '</td>';
                            }
                        }
                    }
                }
                $html .= '
					<td class="text-center h-price-val" id="' . $departure_date . '">
						' . $clsTourPriceGroup->getPriceSingleSupply($tour_id, $val, $departure_date) . '
					</td>';
                $html .= '
					</tr>';
            }
            //}
            $html .= '
			</table>';
        }
        #
        return $html;
    }
    
    function getTripMinPriceTourGroup($pvalTable = 0, $start_date = 0, $type = 'Default', $is_offer = 0)
    {
        global $core, $extLang, $_lang, $clsConfiguration, $dbconn, $clsISO, $adult_type_id, $short_rate, $_LANG_ID;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $lstAdultSizeGroup = $this->getOneField('adult_group_size', $pvalTable);
        #
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date='" . $start_date . "' and tour_visitor_type_id='$adult_type_id' and tour_number_group_id IN ($lstAdultSizeGroup)";
        $price = $dbconn->GetOne($SQL);
        $Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$pvalTable' and " . time() . " between  start_date and end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        if ($_LANG_ID == 'vn') {
            if ($price > 0) {
                if ($type == 'List') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return '<del class="block">' . $price . ' ' . $clsISO->getRate() . '</del> 
					<span class="block color_ea4c42">' . $clsISO->formatPrice($pricePromotion, 1) . ' ' . $clsISO->getRate() . '</span>';
                    } else {
                        return '
					<span class="block color_ea4c42">' . $clsISO->formatPrice($price) . ' ' . $clsISO->getRate() . '</span>';
                    }
                } elseif ($type == 'Number') {
                    return $price;
                } elseif ($type == 'Detail') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return '<p class="mb0">' . $core->get_Lang('Prices stating from') . ':</p> 
						<p class="price_trip mb0"><del>' . $price . ' ' . $clsISO->getRate() . '</del> <span> ' . $clsISO->formatPrice($pricePromotion, 1) . ' ' . $clsISO->getRate() . '</span></p>
						<p>' . $core->get_Lang('Per person') . ':</p> 
						';
                    } else {
                        return '<p class="mb0">' . $core->get_Lang('Prices stating from') . ':</p> 
						<p class="price_trip mb0"><span>' . $clsISO->formatPrice($price) . '  ' . $clsISO->getRate() . ' </span></p>
						<p>' . $core->get_Lang('Per person') . ':</p>';
                    }
                } else {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  ' . $price . ' ' . $short_rate . '</span> <label> $' . $clsISO->formatPrice($pricePromotion, 1) . '</label></span>';
                    } else {
                        return '<span>' . $core->get_Lang('From') . '<label> ' . $clsISO->formatPrice($price) . ' ' . $short_rate . '</label></span>';
                    }
                }
            } else {
                return '<a class="linkContact" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
            }
        } else {
            if ($price > 0) {
                if ($type == 'List') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return '<del class="block">' . $clsISO->getRate() . ' ' . $price . '</del> 
					<span class="block color_ea4c42">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($pricePromotion, 1) . '</span>';
                    } else {
                        return '
					<span class="block color_ea4c42">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($price) . '</span>';
                    }
                } elseif ($type == 'Number') {
                    return $price;
                } elseif ($type == 'Detail') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return '<p class="mb0">' . $core->get_Lang('Prices stating from') . ':</p> 
						<p class="price_trip mb0"><del>' . $clsISO->getRate() . ' ' . $price . '</del> <span> ' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($pricePromotion, 1) . '</span></p>
						<p>' . $core->get_Lang('Per person') . ':</p> 
						';
                    } else {
                        return '<p class="mb0">' . $core->get_Lang('Prices stating from') . ':</p> 
						<p class="price_trip mb0"><span> ' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($price) . '</span></p>
						<p>' . $core->get_Lang('Per person') . ':</p>';
                    }
                } else {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return '<span>' . $core->get_Lang('From') . ' <span class="text-line-through">  $' . $price . '</span> <label> $' . $clsISO->formatPrice($pricePromotion, 1) . '</label></span>';
                    } else {
                        return '<span>' . $core->get_Lang('From') . '<label> $' . $clsISO->formatPrice($price) . '</label></span>';
                    }
                }
            } else {
                return '<a class="linkContact" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
            }
        }
    }
    function getTripMinPrice($pvalTable = 0, $start_date = 0, $type = 'Default', $is_offer = 0) {
        global $core, $extLang, $_lang, $clsConfiguration, $dbconn, $clsISO, $adult_type_id, $short_rate, $_LANG_ID;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $lstAdultSizeGroup = $this->getOneField('adult_group_size', $pvalTable);
        #
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date='" . $start_date . "' and tour_visitor_type_id='$adult_type_id' and tour_number_group_id IN ($lstAdultSizeGroup)";
        $price = $dbconn->GetOne($SQL);
        $Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$pvalTable' and " . time() . " between  start_date and end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        if ($_LANG_ID == 'vn') {
            if ($price > 0) {
                if ($type == 'List') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return $clsISO->formatPrice($pricePromotion, 1);
                    } else {
                        return $clsISO->formatPrice($price) . ' ' . $clsISO->getRate();
                    }
                } elseif ($type == 'Number') {
                    return $price;
                } elseif ($type == 'Detail') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return $clsISO->formatPrice($pricePromotion, 1) . ' ' . $clsISO->getRate();
                    } else {
                        return $clsISO->formatPrice($price) . '  ' . $clsISO->getRate();
                    }
                } else {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return $clsISO->formatPrice($pricePromotion, 1);
                    } else {
                        return $clsISO->formatPrice($price) . ' ' . $short_rate;
                    }
                }
            } else {
                return $core->get_Lang('Contact');
            }
        } else {
            if ($price > 0) {
                if ($type == 'List') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return $clsISO->getRate() . ' ' . $clsISO->formatPrice($pricePromotion, 1);
                    } else {
                        return $clsISO->getRate() . ' ' . $clsISO->formatPrice($price);
                    }
                } elseif ($type == 'Number') {
                    return $price;
                } elseif ($type == 'Detail') {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return $clsISO->getRate() . ' ' . $clsISO->formatPrice($pricePromotion, 1);
                    } else {
                        return $clsISO->getRate() . ' ' . $clsISO->formatPrice($price);
                    }
                } else {
                    if ($promotion > 0) {
                        $pricePromotion = $price - ($price * $promotion / 100);
                        return $clsISO->formatPrice($pricePromotion, 1);
                    } else {
                        return $clsISO->formatPrice($price);
                    }
                }
            } else {
                return $core->get_Lang('Contact');
            }
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
    function getTripDayText($tour_id = 0)
    {
        global $_LANG_ID, $core;
        $one = $this->getOne($tour_id, 'number_day');
        $number_day = intval($one['number_day']);
        if ($number_day == 0 || $number_day == '' || $number_day == 1)
            return '1 <i>' . $core->get_Lang('days') . '</i>';
        return $number_day . ' <i>' . $core->get_Lang('days') . '</i>';
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

    function getAllDuration($current = 0, $tour_category_id = 0, $city_id = 0)
    {
        global $_LANG_ID, $lang;
        $cond = "is_trash=0";
        $cond .= ($tour_category_id != '' && $tour_category_id != 0) ? " and list_cat_id like '%|" . $tour_category_id . "|%'" : "";
        $cond .= ($city_id != '' && $city_id != 0) ? " and list_city_id like '%|" . $city_id . "|%'" : "";
        $allTour = $this->getAll($cond);
        $temp = '';
        for ($i = 0; $i < count($allTour); $i++) {
            $temp .= $this->getTripDuration($allTour[$i]['tour_id']) . '|';
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
                $temp .= $value['tour_category_id'] . '|';
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

    function getDay($tour_id = 0)
    {
        global $core;
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
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

    function getNumberDay($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
        $duration_type = $one['duration_type'];
        if ($duration_type == 1) {
            return $one['duration_custom'];
        } else {
            return $one['number_day'];
        }
    }

    function getDurationCustom($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
        $duration_type = $one['duration_type'];
        if ($duration_type == 1) {
            return $one['duration_custom'];
        } else {
            return '';
        }
    }

    function getDuration($tour_id = 0)
    {
        global $core;
        $one = $this->getOne($tour_id, 'duration_type,duration_custom,number_day,number_night');
        $duration_type = $one['duration_type'];
        if ($duration_type == 1) {
            return $one['duration_custom'];
        } else {
            return $one['number_day'] . ' ' . $core->get_Lang('days') . '/' . $one['number_night'] . ' ' . $core->get_Lang('nights');
        }
    }
    function getEndDate($start_date = 0, $tour_id = 0)
    {
        global $core, $clsISO;
        $one = $this->getOne($tour_id, 'duration_type,number_day');
        $duration_type = $one['duration_type'];
        if ($duration_type == 1) {
            $num_day = 0;
            $end_date = strtotime('+' . $num_day . ' day', $start_date);
            return $end_date;
        } else {
            $num_day = $one['number_day'] - 1;
            $end_date = strtotime('+' . $num_day . ' day', $start_date);
            return $end_date;
        }
    }

    function getTextEndDate($start_date = 0, $tour_id = 0)
    {
        global $core, $clsISO;
        $one = $this->getOne($tour_id, 'duration_type,number_day');
        $duration_type = $one['duration_type'];
        $start_date = strtotime($start_date);
        if ($duration_type == 1) {
            $num_day = 0;
            $end_date = strtotime('+' . $num_day . ' day', $start_date);
            return $end_date;
        } else {
            $num_day = $one['number_day'];
            $end_date = strtotime('+' . $num_day . ' day', $start_date);
            return $end_date;
        }
    }

    function checkDurationCustom($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'duration_type');
        return $one['duration_type'];
    }

    function getCityAround($tour_id = 0, $is_image = false)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsTourDestination = new TourDestination;
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
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

    function getLCityAround($tour_id = 0, $type = '')
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
        if (is_array($rsllist) && count($rsllist) > 0) {
            for ($i = 0; $i < count($rsllist); $i++) {
                if ($rsllist[$i]['placetogo_id'] > 0) {
                    $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id']) . '" title="' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '">' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '</a>';
                } else {
                    $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                }
            }
            unset($rsllist);
        }
        return $html;
    }

    function getLCityAround3($tour_id = 0, $type = '')
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
        if (is_array($rsllist) && count($rsllist) > 0) {
            for ($i = 0; $i < count($rsllist); $i++) {
                if ($rsllist[$i]['placetogo_id'] > 0) {
                    $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id']) . '" title="' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '">' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '</a>';
                } else {
                    $html .= ($i == 0 ? '' : ' - ') . '<a class="linkcity" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                }
            }
            unset($rsllist);
        }
        return $html;
    }

    function getLCityAround2($tour_id = 0, $type = '')
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc", $clsTourDestination->pkey . ',placetogo_id,city_id');
        if (is_array($rsllist) && count($rsllist) > 0) {
            for ($i = 0; $i < count($rsllist); $i++) {
                if ($rsllist[$i]['placetogo_id'] > 0) {
                    $itemGuide = $clsGuide->getOne($rsllist[$i]['placetogo_id'], 'title,slug');
                    $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id'], $itemGuide) . '" title="' . $itemGuide['title'] . '">' . $itemGuide['title'] . '</a>';
                } else {
                    $itemCity = $clsCity->getOne($rsllist[$i]['city_id'], "title,slug,country_id");
                    $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id'], '', false, $itemCity) . '" title="' . $itemCity['title'] . '">' . $itemCity['title'] . '</a>';
                }
            }
            unset($rsllist);
        }
        return $html;
    }

    function getLCityAround4($tour_id = 0, $type = '')
    {
        global $_LANG_ID, $clsISO;
        #
        $clsCity = new City();
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination();
        #

        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc", $clsTourDestination->pkey . ',placetogo_id,city_id');
        #

        // Lọc các phần tử không có title và slug
        $rsllist = array_filter($rsllist, function ($item) use ($clsGuide, $clsCity) {
            if ($item['placetogo_id'] > 0) {
                $data = $clsGuide->getOne($item['placetogo_id'], 'title,slug');
            } else {
                $data = $clsCity->getOne($item['city_id'], "$clsCity->pkey,title,slug,country_id");
            }
            return !empty($data['title']) && !empty($data['slug']);
        });

        // Kiểm tra và xử lý nếu mảng không rỗng
        if (is_array($rsllist) && count($rsllist) > 0) {
            $arr = [];
            for ($i = 0; $i < count($rsllist); $i++) {
                if ($rsllist[$i]['placetogo_id'] > 0) {
                    $arr[] = $clsGuide->getOne($rsllist[$i]['placetogo_id'], 'title,slug');
                    $arr[$i]['link'] = $clsGuide->getLink($rsllist[$i]['placetogo_id']);
                    $arr[$i]['image'] = $clsGuide->getImage($rsllist[$i]['placetogo_id'], 268, 180);
                } else {
                    $arr[] = $clsCity->getOne($rsllist[$i]['city_id'], "$clsCity->pkey,title,slug,country_id");
                    $arr[$i]['link'] = $clsCity->getLink($rsllist[$i]['city_id']);
                    $arr[$i]['image'] = $clsCity->getImage($rsllist[$i]['city_id'], 268, 180);
                }
            }
            unset($rsllist);
        }

        return $arr;
    }

    function getLCityAround2024($tour_id = 0)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc", $clsTourDestination->pkey . ',placetogo_id,city_id');
        if (is_array($rsllist) && count($rsllist) > 0) {
            for ($i = 0; $i < count($rsllist); $i++) {
                if ($rsllist[$i]['placetogo_id'] > 0) {
                    $itemGuide = $clsGuide->getOne($rsllist[$i]['placetogo_id'], 'title,slug');
                    $html .= ($i == 0 ? '' : ', ') . $itemGuide['title'];
                } else {
                    $itemCity = $clsCity->getOne($rsllist[$i]['city_id'], 'title,slug,country_id');
                    $html .= ($i == 0 ? '' : ', ') . $itemCity['title'];
                }
            }
            unset($rsllist);
        }
        return $html;
    }

    function getLCityAround2019($tour_id = 0, $type = '')
    {
        global $_LANG_ID, $core;
        $clsCity = new City;
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
        if ($rsllist != '') {
            if (count($rsllist) <= 2) {
                return $this->getLCityAround2($tour_id);
            } else {
                for ($i = 0; $i < 2; $i++) {
                    if ($rsllist[$i]['placetogo_id'] > 0) {
                        $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id']) . '" title="' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '">' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '</a>';
                    } else {
                        $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                    }
                }
                $number_orther_place = count($rsllist) - 2;
                $more = $core->get_Lang('more');
                $html .= '<span class="numb_more color_47c0cd"> +' . $number_orther_place . '' . $more . '</span>';
            }
        }
        return $html;
    }

    function getLCountryAround($tour_id = 0, $type = '')
    {
        global $_LANG_ID, $dbconn;
        $clsCountry = new Country;
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $SQL01 = "SELECT country_id FROM " . DB_PREFIX . "tour_destination WHERE tour_id='$tour_id' group by country_id";
        $listCountry = $dbconn->GetAll($SQL01);
        if (is_array($listCountry) && count($listCountry) > 0) {
            for ($i = 0; $i < count($listCountry); $i++) {
                $html .= ($i == 0 ? '' : ', ') . '<a class="linkcountry" target="_parent" href="' . $clsCountry->getLink($listCountry[$i]['country_id']) . '" title="' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '">' . $clsCountry->getTitle($listCountry[$i]['country_id']) . '</a>';
            }
            unset($listCountry);
        }
        return $html;
    }

    function getLOtherCityAround($tour_id = 0, $type = '')
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
        if (is_array($rsllist) && count($rsllist) > 4) {
            for ($i = 1; $i < 3; $i++) {
                $html .= ($i == 1 ? '' : ', ') . '<a class="h-city-around" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
            }
            $html .= '...';
            unset($rsllist);
        } else if (is_array($rsllist) && count($rsllist) > 3) {
            for ($i = 1; $i < 3; $i++) {
                $html .= ($i == 1 ? '' : ', ') . '<a class="h-city-around" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
            }
            unset($rsllist);
        } else {
            for ($i = 1; $i < 2; $i++) {
                $html .= ($i == 1 ? '' : ', ') . '<a class="h-city-around" target="_parent" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
            }
            unset($rsllist);
        }
        return $html;
    }

    function getStartCityAround($tour_id = 0, $country = false)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsCountry = new Country;
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc Limit 0,1");
        if (!empty($rsllist)) {
            $html .= '<a class="h-city-around" href="' . $clsCity->getLink($rsllist[0]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[0]['city_id']) . '">' . $clsCity->getTitle($rsllist[0]['city_id']) . '</a>';
            if ($country == true) {
                $html .= ', <a class="h-country-around" href="' . $clsCountry->getLink($rsllist[0]['country_id']) . '" title="' . $clsCountry->getTitle($rsllist[0]['country_id']) . '">' . $clsCountry->getTitle($rsllist[0]['country_id']) . '</a>';
            }
            unset($rsllist);
        }
        return $html;
    }

    function getEndCityAround($tour_id = 0, $country = false)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsCountry = new Country;
        $clsTourDestination = new TourDestination;
        #
        $html = '';
        $rsllist = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no desc Limit 0,1");
        if (!empty($rsllist)) {
            $html .= '<a class="h-city-around" href="' . $clsCity->getLink($rsllist[0]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[0]['city_id']) . '">' . $clsCity->getTitle($rsllist[0]['city_id']) . '</a>';
            if ($country == true) {
                $html .= ', <a class="h-country-around" href="' . $clsCountry->getLink($rsllist[0]['country_id']) . '" title="' . $clsCountry->getTitle($rsllist[0]['country_id']) . '">' . $clsCountry->getTitle($rsllist[0]['country_id']) . '</a>';
            }
            unset($rsllist);
        }
        return $html;
    }

    function getNumberCityAround($tour_id = 0)
    {
        $clsISO = new ISO();
        $clsTourDestination = new TourDestination();
        $lst_city_id = array();
        $lstall_city_id = $clsTourDestination->getAll("is_trash=0 and tour_id=" . $tour_id);
        if (!empty($lstall_city_id))
            $lst_city_id = $clsISO->super_unique($lstall_city_id, 'city_id');
        return count($lst_city_id);
    }

    function getNumberOtherCityAround($tour_id = 0)
    {
        $clsISO = new ISO();
        $clsTourDestination = new TourDestination();
        $lst_city_id = array();
        $lstall_city_id = $clsTourDestination->getAll("is_trash=0 and tour_id=" . $tour_id);
        if (!empty($lstall_city_id))
            $lst_city_id = $clsISO->super_unique($lstall_city_id, 'city_id');
        return count($lst_city_id) - 2;
    }

    function getListTag($tour_id = 0)
    {
        global $_LANG_ID;
        #
        $clsTag = new Tag;
        #
        $list_tag_id = $this->getOneField('list_tag_id', $tour_id);
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

    function getCatTours($tour_id = 0)
    {
        global $_LANG_ID;
        #
        $clsCategory = new Category;
        #
        $list_type_id = $this->getOneField('list_type_id', $tour_id);
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

    function checkTourPromotion($tour_id = 0)
    {
        $res = $this->getAll("tour_id='$tour_id' and is_promotion=1 limit 0,1");
        return (!empty($res)) ? 1 : 0;
    }

    function checkTourLastHour($tour_id = 0, $now_day = 0)
    {
        $clsTourStartDate = new TourStartDate();
        $listTopTourLastHours = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id ='$tour_id' and is_last_hour = 1 and close_sell_date >= '$now_day' and open_sell_date <= '$now_day' and start_date > '$now_day' order by start_date ASC", $clsTourStartDate->pkey . ",tour_id,start_date");
        //		var_dump("is_trash=0 and is_online=1 and tour_id ='$tour_id' and is_last_hour = 1 and close_sell_date >= '$now_day' and open_sell_date <= '$now_day' and start_date > '$now_day' order by start_date ASC");'<br>';
        $tour_start_date_id = $listTopTourLastHours[0]['tour_start_date_id'];
        return $tour_start_date_id ? $tour_start_date_id : '';
    }

    function checkTourLastHour2($tour_id = 0, $now_day = 0)
    {
        $clsTourStartDate = new TourStartDate();
        $listTopTourLastHours = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id ='$tour_id' and is_last_hour = 1 and close_sell_date >= '$now_day' and start_date > '$now_day' order by start_date ASC", $clsTourStartDate->pkey . ",tour_id,start_date");
        //		var_dump("is_trash=0 and is_online=1 and tour_id ='$tour_id' and is_last_hour = 1 and close_sell_date >= '$now_day' and open_sell_date <= '$now_day' and start_date > '$now_day' order by start_date ASC");'<br>';
        $tour_start_date_id = $listTopTourLastHours[0]['tour_start_date_id'];
        return $tour_start_date_id ? $tour_start_date_id : '';
    }

    function checkTourStartDate($tour_id = 0, $now_day = 0)
    {
        $clsTourStartDate = new TourStartDate();
        $listTopTourLastHours = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id ='$tour_id' and close_sell_date >= '$now_day' and open_sell_date <= '$now_day' and start_date > '$now_day' order by start_date ASC", $clsTourStartDate->pkey . ",tour_id,start_date");
        $tour_start_date_id = $listTopTourLastHours[0]['tour_start_date_id'];
        return $tour_start_date_id ? $tour_start_date_id : '';
    }

    function checkTourDeparture($tour_id = 0, $now_day = 0)
    {
        $clsTourStore = new TourStore();
        $clsTourStartDate = new TourStartDate();
        $checkTourDeparture = $clsTourStore->getAll("is_trash=0 and tour_id ='$tour_id' and _type='DEPARTURE'");
        return $checkTourDeparture ? 1 : 0;
    }

    function checkTourTop($tour_id = 0)
    {
        $res = $this->getAll("tour_id='$tour_id' and is_top=1 limit 0,1");
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

    function getTableCruiseHeader($tour_id = 0)
    {
        global $_LANG_ID;
        $oneTable = $this->getOne($tour_id, "table_cruise_header_" . $_LANG_ID);
        if ($oneTable['table_cruise_header_' . $_LANG_ID] != '')
            return $oneTable['table_cruise_header_' . $_LANG_ID];
        return '[N/A]';
    }

    function getTablePriceHeader($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'table_price_header');
        if ($one['table_price_header'] == '') {
            return 'Net tour cost per person in us dollar valid from 1 may – 30 sep ' . date('Y', time());
        } else {
            return $one['table_price_header'];
        }
    }

    function getListOfferTours($limit = '')
    {
        global $core, $dbconn;
        $limit = !empty($limit) ? ' limit ' . $limit : '';
        $sql = "SELECT t1.tour_id FROM " . DB_PREFIX . "tour t1 INNER JOIN " . DB_PREFIX . "tour_store t2 WHERE t1.tour_id = t2.tour_id AND t2._type='PROMOTION' AND t1.is_online=1 AND t1.is_trash=0 ORDER BY t2.order_no DESC" . $limit;
        $res = $dbconn->GetAll($sql);
        return !empty($res) ? $res : '';
    }

    function getTripCodeByStartDate($tour_start_date_id = 0)
    {
        $clsTourStartDate = new TourStartDate();
        $start_date = $clsTourStartDate->getOneField('start_date', $tour_start_date_id);
        $date = date('d', $start_date) . date('m', $start_date) . date('y', $start_date);
        $clsTour = new Tour();
        return $this->getOneField('trip_code', $this->getOneField('tour_id', $tour_start_date_id)) . '-' . $date;
    }

    function checkDepartureOther($pvalTable = 0)
    {
        $clsTourStartDate = new TourStartDate();
        $res = $clsTourStartDate->getAll("is_trash=0 and start_date>= '" . time() . "' and tour_id = '" . $pvalTable . "' limit 0,1");
        return !empty($res) ? 1 : 0;
    }

    function getDateDepartureText($tour_id = 0)
    {
        $one = $this->getOne($tour_id);
        return date('d/m/Y', time());
    }

    function getLinkDeparture($tour_id = 0)
    {
        global $_LANG_ID, $extLang;
        return $extLang . '/tours/' . $this->getSlug($tour_id) . '_a' . $tour_id . '.html';
    }

    function getTourDestination($tour_id = 0)
    {
        $clsTourDestination = new TourDestination;
        $clsCity = new City;
        $html = '';
        $lstItem = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
        if ($lstItem != '') {
            for ($i = 0; $i < count($lstItem); $i++) {
                $html .= ($i == 0 ? '' : ',&nbsp;') . '<a href="' . $clsCity->getLink($lstItem[$i]['city_id']) . '" title="' . $clsCity->getTitle($lstItem[$i]['city_id']) . '">' . $clsCity->getTitle($lstItem[$i]['city_id']) . '</a>';
            }
            return $html;
        }
    }

    function getTourType($tour_id = 0)
    {
        $clsCategory = new Category;
        $html = '';
        #
        $one = $this->getOne($tour_id, 'tour_type_id');
        $tour_type_id = $one['tour_type_id'];
        if ($tour_type_id == '' || $tour_type_id == '0' || $tour_type_id == '|') {
            return '';
        }
        $tour_type_id = trim(str_replace('||', ',', $tour_type_id));
        $tour_type_id = trim(str_replace('|', '', $tour_type_id));
        #
        $tmp = explode(',', $tour_type_id);
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

    function getDepartureFrom($tour_id = 0)
    {
        $clsCity = new City();
        $clsCountry = new Country();
        $clsTourDestination = new TourDestination();
        $all = $clsTourDestination->getAll("is_trash=0 and tour_id = '$tour_id' order by order_no asc limit 0,1");
        $country_id = $clsCity->getOneField('country_id', $all[0]['city_id']);
        if ($country_id > 0)
            return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . ',</a> <a href="' . $clsCountry->getLink($country_id) . '" title="' . $clsCountry->getTitle($country_id) . '">' . $clsCountry->getTitle($country_id) . '</a>';
        return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . '</a>';
    }

    function getDepartureEnd($tour_id = 0)
    {
        $clsCity = new City();
        $clsCountry = new Country();
        $clsTourDestination = new TourDestination();
        $all = $clsTourDestination->getAll("is_trash=0 and tour_id = '$tour_id' order by order_no desc limit 0,1");
        $country_id = $clsCity->getOneField('country_id', $all[0]['city_id']);
        if ($country_id > 0)
            return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . ',</a> <a href="' . $clsCountry->getLink($country_id) . '" title="' . $clsCountry->getTitle($country_id) . '">' . $clsCountry->getTitle($country_id) . '</a>';
        return '<a href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . '</a>';
    }

    function getDepartureCityEnd($tour_id = 0)
    {
        $clsCity = new City();
        $clsCountry = new Country();
        $clsTourDestination = new TourDestination();
        $all = $clsTourDestination->getAll("is_trash=0 and tour_id = '$tour_id' order by order_no desc limit 0,1");
        return '<a class="color_333" href="' . $clsCity->getLink($all[0]['city_id']) . '" title="' . $clsCity->getTitle($all[0]['city_id']) . '">' . $clsCity->getTitle($all[0]['city_id']) . '</a>';
    }

    function getCatName($tour_id = 0)
    {
        $clsTourCat = new TourCategory();
        $oneTable = $this->getOne($tour_id, "cat_id");
        return $clsTourCat->getTitle($oneTable['cat_id']);
    }

    function getListCatName($tour_id = 0)
    {
        $clsTourCat = new TourCategory();
        $oneTable = $this->getOne($tour_id, "list_cat_id");
        $list_cat_id = trim($oneTable['list_cat_id'], "|");
        $arr_cat_id = explode('|', $list_cat_id);
        $arr_title = [];
        foreach ($arr_cat_id as $cat_id) {
            $arr_title[] = $clsTourCat->getTitle($cat_id);
        }
        return implode(' | ', $arr_title);
    }

    function getTypeName($tour_id = 0)
    {
        $clsCategory = new Category();
        $oneTable = $this->getOne($tour_id, "type_id");
        return $clsCategory->getTitle($oneTable['type_id']);
    }

    function getTourTypeCategory($tour_id = 0)
    {
        return $this->getOneField("tour_type_id", $tour_id);
        return 0;
        $clsISO = new ISO();
        $one = $this->getOne($tour_id, 'list_cat_id');
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

    function updateTourTransport($tour_id = 0)
    {
        $clsTourItinerary = new TourItinerary();
        $list_transport_id = '|';
        #
        $lstTourItinerary = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
        if (is_array($lstTourItinerary) && count($lstTourItinerary) > 0) {
            for ($i = 0; $i < count($lstTourItinerary); $i++) {
                if ($lstTourItinerary[$i]['transport_id'] != '' && $lstTourItinerary[$i]['transport_id'] != '0') {
                    $list_transport_id .= $lstTourItinerary[$i]['transport_id'] . '|';
                }
            }
            unset($lstTourItinerary);
            $this->updateOne($tour_id, "list_transport_id='$list_transport_id'");
            return '';
        }
        return '';
    }

    function updateTransport($tour_id = 0)
    {
        $clsTourItinerary = new TourItinerary();
        $list_transport_id = '|';
        #
        $lstTourItinerary = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
        if (is_array($lstTourItinerary) && count($lstTourItinerary) > 0) {
            for ($i = 0; $i < count($lstTourItinerary); $i++) {
                if ($lstTourItinerary[$i]['transport_id'] != '' && $lstTourItinerary[$i]['transport_id'] != '0') {
                    $list_transport_id .= $lstTourItinerary[$i]['transport_id'] . '|';
                }
            }
            unset($lstTourItinerary);
            $this->updateOne($tour_id, "list_transport_id='$list_transport_id'");
            return '';
        }
        return '';
    }

    function getPriceCat($tour_id = 0, $cat_id = 0, $tour_start_date_id = 0)
    {
        $clsTourPriceCat = new TourPriceCat();
        $all = $clsTourPriceCat->getAll("tour_id='$tour_id' and cat_id='$cat_id' and tour_start_date_id='$tour_start_date_id' limit 0,1");
        if ($all[0]['tour_id'] != '' && $all[0]['price'] != 0 && $all[0]['price'] != '') return $all[0]['price'];
        if ($cat_id == 246) {
            $clsCommon = new Common();
            $pricePT = $clsCommon->getOneField('config_tour_ptvtnvn', 1);
            $lst = $clsTourPriceCat->getAll("tour_start_date_id='$tour_start_date_id' and cat_id='$cat_id' and tour_id='$tour_id' limit 0,1");
            if ($lst[0][$clsTourPriceCat->pkey] == '') {
                $f = "tour_id,tour_start_date_id,cat_id,price,user_id,user_id_update,reg_date,upd_date,price";
                $v = "'$tour_id','$tour_start_date_id','$cat_id','0','" . $core->_USER['user_id'] . "','" . $core->_USER['user_id'] . "','" . time() . "','" . time() . "','$pricePT'";
                $clsTourPriceCat->insertOne($f, $v);
            } else {
                $clsTourPriceCat->updateOne($lst[0][$clsTourPriceCat->pkey], "price='$pricePT'");
            }
            return $pricePT;
        }
        return 0;
    }

    function getErrorMsg($tour_id = 0)
    {
        global $core;
        #
        $oneTour = $this->getOne($tour_id, 'image');
        $msg = '';
        if ($oneTour['image'] == '') {
            $msg .= $core->get_Lang('missimages');
        }
        if ($this->getTripCode($tour_id) == '') {
            $msg .= $core->get_Lang('misscodetour');
        }
        $clsTourItinerary = new TourItinerary();
        if ($clsTourItinerary->countItem("is_trash=0 and tour_id='$tour_id'") == 0) {
            $msg .= $core->get_Lang('missitinerary');
        }
        return $msg;
    }

    function getNumberSeat($tour_id = 0)
    {
        $one = $this->getOne($tour_id, 'number_seat');
        $tour_start_date_id = $this->getMinStartDateID($tour_id);
        if ($tour_start_date_id != '') {
            $clsTourStartDate = new TourStartDate();
            return $clsTourStartDate->getOneField("allotment", $tour_start_date_id);
        }
        $number_seat = $one['number_seat'];
        if ($number_seat != '' && intval($number_seat) > 0) {
            return $number_seat;
        }
        /* @ mt_rand() value */
        return mt_rand(5, 15);
    }

    function initCruiseTable($tour_id = 0)
    {
        global $core;
        #
        $clsTourCruisePriceRow = new TourCruisePriceRow();
        $clsTourCruisePriceCol = new TourCruisePriceCol();
        $clsTourCruisePriceVal = new TourCruisePriceVal();
        $_frontIsLoggedin_user_id = $core->_USER['user_id'];
        $res = $clsTourCruisePriceRow->getAll("tour_id = '$tour_id'");
        if (empty($res)) {
            for ($i = 0; $i < 4; $i++) {
                $f = "tour_id,user_id,title,order_no";
                if ($i % 2) {
                    $title = 'Double cabin';
                } else
                    $title = 'Single cabin';
                $v = "'" . $tour_id . "','$_frontIsLoggedin_user_id','" . $title . "','" . $clsTourCruisePriceCol->getMaxOrderNo() . "'";
                $clsTourCruisePriceCol->insertOne($f, $v);
            }
            for ($k = 0; $k < 2; $k++) {
                $f = "tour_cruise_price_row_id,tour_id,user_id,title,order_no";
                $tour_cruise_price_row_id = $clsTourCruisePriceRow->getMaxId();
                $title = 'Row ' . ($k + 1);
                $v = "'$tour_cruise_price_row_id','" . $tour_id . "','$_frontIsLoggedin_user_id','" . $title . "',
				'" . $clsTourCruisePriceRow->getMaxOrderNo() . "'";
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
                $res = $clsCountryEx->getAll("is_trash=0 and country_id IN (SELECT country_id FROM default_tour_destination WHERE tour_id = '" . $lstItem[$i]['tour_id'] . "')");
                $countCountry = count($res);
                $clsTour->updateOne($lstItem[$i]['tour_id'], "number_country = '" . $countCountry . "'");
            }
        }
    }

    function checkToursPromotion($pvalTable = 0)
    {
        $res = $this->getAll("is_trash=0 and tour_id = '" . $pvalTable . "' and is_selling = 1 and hot_deals > 0 limit 0,1");
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

    function getListTypeTour($tour_id = 0)
    {
        $list_type_id = $this->getOneField('list_type_id', $tour_id);
        $tmp = explode('|', $list_type_id);
        $lst = array();
        for ($i = 0; $i < count($tmp); $i++) {
            if ($tmp[$i] != '' && $tmp[$i] != '0')
                $lst[] = $tmp[$i];
        }
        if ($lst[0] != '') return ($lst);
        return '';
    }

    function getSelectTripDuration($tour_id = 0, $oneTable = null)
    {
        global $_LANG_ID, $core;
        if (!isset($oneTable)) {
            $oneTable = $this->getOne($tour_id, 'number_day,number_night');
        }
        $number_day = intval($oneTable['number_day']);
        $number_night = intval($oneTable['number_night']);
        if ($number_day == 0 && $number_night == 0)
            return '';
        if ($number_day == 1)
            return $core->get_Lang('Full day');
        $day = $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
        $night = $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
        return $day . ' / ' . $night;
    }

    function getTripDurationx($tour_id = 0, $oneTable = null)
    {
        global $_LANG_ID, $core;
        if (!isset($oneTable)) {
            $oneTable = $this->getOne($tour_id, 'number_day,number_night');
        }
        $number_day = intval($oneTable['number_day']);
        $number_night = intval($oneTable['number_night']);
        if ($number_day == 0 && $number_night == 0)
            return '';
        if ($number_day == 1)
            return $core->get_Lang('Full day');
        $day = $number_day . ' ' . ($number_day > 1 ? $core->get_Lang('days') : $core->get_Lang('day'));
        $night = $number_night . ' ' . ($number_night > 1 ? $core->get_Lang('nights') : $core->get_Lang('night'));
        return $day . ' ' . $night;
    }

    function getTripDayDuration($tour_id = 0)
    {
        global $_LANG_ID, $core;
        $one = $this->getOne($tour_id, 'number_day');
        $number_day = $one['number_day'];
        $dayText = $number_day > 1 ? $number_day . ' ' . $core->get_Lang('days') : $number_day . ' ' . $core->get_Lang('day');
        return $dayText;
    }

    function getLocationMapNew($tour_id = 0)
    {
        global $dbconn;
        $clsCity = new City();
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination();
        #
        $listCity = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
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
        return $ret;
    }

    function getLocationMap($tour_id = 0)
    {
        global $dbconn;
        $clsCountry = new Country();
        $clsRegion = new Region();
        $clsCity = new City();
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination();
        #
        $listCountry = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and country_id IN (SELECT country_id from " . DB_PREFIX . "country WHERE is_trash=0 and is_online=1) order by order_no asc");
        //print_r($listCountry); die();
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
        //print_r($jscode); die();
        $ret['map_la'] = $map_la;
        $ret['map_lo'] = $map_lo;
        $ret['jscode'] = $jscode;
        //print_r($ret); die();
        return $ret;
    }

    function getLocationMapBoxValue($tour_id = 0)
    {
        global $dbconn;
        $clsCountry = new Country();
        $clsRegion = new Region();
        $clsCity = new City();
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination();
        #
        $listCountry = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and country_id IN (SELECT country_id from " . DB_PREFIX . "country WHERE is_trash=0 and is_online=1) order by order_no asc");
        //print_r($listCountry); die();
        $map_la = '';
        $map_lo = '';
        $jscode = '';
        $location = '';
        if (!empty($listCountry)) {
            foreach ($listCountry as $k => $v) {
                if ($v['placetogo_id'] > 0) {
                    $location .= '[' . trim($clsGuide->getMapLa($v['placetogo_id'])) . ',' . trim($clsGuide->getMapLo($v['placetogo_id'])) . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                } elseif ($v['city_id'] > 0) {
                    $location .= '[' . trim($clsCity->getMapLa($v['city_id'])) . ',' . trim($clsCity->getMapLo($v['city_id'])) . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                } elseif ($v['region_id'] > 0) {
                    $location .= '[' . trim($clsRegion->getMapLa($v['region_id'])) . ',' . trim($clsRegion->getMapLo($v['region_id'])) . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                } else {
                    $location .= '[' . trim($clsCountry->getMapLa($v['country_id'])) . ',' . trim($clsCountry->getMapLo($v['country_id'])) . ']';
                    $location .= ($k == count($listCountry) - 1) ? '' : ',';
                }
            }
            unset($listCountry);
        }
        return '[' . $location . ']';
    }

    function getLocationMapBox($tour_id = 0)
    {
        global $dbconn;
        $clsCountry = new Country();
        $clsRegion = new Region();
        $clsCity = new City();
        $clsGuide = new Guide();
        $clsTourDestination = new TourDestination();
        #
        $listCountry = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' and country_id IN (SELECT country_id from " . DB_PREFIX . "country WHERE is_trash=0 and is_online=1) order by order_no asc");
        $data_place = array();
        if (!empty($listCountry)) {
            foreach ($listCountry as $k => $v) {
                if ($v['placetogo_id'] > 0) {
                    $onePlace = $clsGuide->getOne($v['placetogo_id']);
                    $arr_place = array(
                        'place_id' => $v['placetogo_id'],
                        'place_name' => $onePlace['title'],
                        'place_x' => $onePlace['map_la'],
                        'place_y' => $onePlace['map_lo'],
                        'place_zoom' => 10,
                        'place_country' => 'xxxx'
                    );
                } elseif ($v['city_id'] > 0) {
                    $onePlace = $clsCity->getOne($v['city_id']);
                    $arr_place = array(
                        'place_id' => $v['city_id'],
                        'place_name' => $onePlace['title'],
                        'place_x' => $onePlace['map_la'],
                        'place_y' => $onePlace['map_lo'],
                        'place_zoom' => 10,
                        'place_country' => 'xxxx'
                    );
                } elseif ($v['region_id'] > 0) {
                    $onePlace = $clsRegion->getOne($v['region_id']);
                    $arr_place = array(
                        'place_id' => $v['region_id'],
                        'place_name' => $onePlace['title'],
                        'place_x' => $onePlace['map_la'],
                        'place_y' => $onePlace['map_lo'],
                        'place_zoom' => 10,
                        'place_country' => 'xxxx'
                    );
                } else {
                    $onePlace = $clsCountry->getOne($v['country_id']);
                    $arr_place = array(
                        'place_id' => $v['country_id'],
                        'place_name' => $onePlace['title'],
                        'place_x' => $onePlace['map_la'],
                        'place_y' => $onePlace['map_lo'],
                        'place_zoom' => 10,
                        'place_country' => 'xxxx'
                    );
                }
                array_push($data_place, $arr_place);
            }
            unset($listCountry);
        }
        $data_place = json_encode($data_place);
        return $data_place;
    }

    function getLocationMap22($tour_id = 0)
    {
        $clsCity = new City();
        $clsTourDestination = new TourDestination();
        #
        $listTourDestination = $clsTourDestination->getAll("is_trash=0 and tour_id='$tour_id' order by order_no asc");
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

    function getTripPriceByStartDate($tour_start_date_id = 0)
    {
        global $clsISO;
        $clsTourStartDate = new TourStartDate();
        $all = $clsTourStartDate->getAll("tour_start_date_id='$tour_start_date_id'");
        $trip_price = $all[0]['price'];
        return ($trip_price);
    }

    function getSelectTour($tour_id = '')
    {
        global $core, $_lang;
        $lstItem = $this->getAll("is_trash=0 order by order_no asc");
        $html = '<option value="">-- ' . $core->get_Lang('select') . ' --</option>';
        #
        if (!empty($lstItem)) {
            foreach ($lstItem as $item) {
                $selected = ($tour_id == $item[$this->pkey]) ? 'selected="selected"' : '';
                $html .= '<option value="' . $item[$this->pkey] . '"' . $selected . '>' . $this->getTripCode($item[$this->pkey]) . '-|-' . $this->getTitle($item[$this->pkey]) . '</option>';
            }
        }
        return $html;
    }

    function getListMeal()
    {
        global $core;
        $clsTourProperty = new TourProperty();
        $lstMeal = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='MEAL' order by order_no desc", $clsTourProperty->pkey . ',title');
        return $lstMeal ?? [];
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
        $lstTransport = $clsTransport->getAll("is_trash=0 and is_online=1 order by order_no asc");
        return $lstTransport;
    }

    function countTourItinerary($tour_id = 0)
    {
        $clsTourItinerary = new TourItinerary();
        $all = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id'");
        return !empty($all) ? (count($all) > 9 ? count($all) : '0' . count($all)) : '00';
    }

    function countTourByRegion($country_id = 0, $region_id = 0)
    {
        $where = "is_trash=0 and is_online=1 and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id' and city_id IN (SELECT city_id FROM " . DB_PREFIX . "citystore WHERE country_id='$country_id' and region_id='$region_id'))";
        return $this->countItem($where);
    }

    function countTourByCity($country_id = 0, $city_id = 0)
    {
        $where = "is_trash=0 and is_online=1 and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id' and city_id='$city_id')";
        //		$this->setDeBug(1);
        $total_item = $this->getAll($where, $this->pkey);
        return ($total_item) ? count($total_item) : 0;
    }

    function countTourByCityInbound($country_id = 0, $city_id = 0)
    {
        $where = "is_trash=0 and is_online=1 and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id' and city_id='$city_id')";
        $all = $this->getAll($where);
        return $all ? count($all) : 0;
    }

    function countTourGolobal($country_id = 0, $city_id = 0, $cat_id = 0, $tour_type_id = 0)
    {
        $where = "is_trash=0 and is_online=1";
        if (intval($country_id) > 0) {
            $where .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id')";
        }
        if (intval($city_id) > 0) {
            $where .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE city_id='$city_id')";
        }
        if (intval($cat_id) > 0) {
            $where .= " and (cat_id = '" . $cat_id . "' or list_cat_id like '%|" . $cat_id . "|%')";
        }
        if (intval($tour_type_id) > 0) {
            $where .= " and tour_type_id ='$tour_type_id'";
        }
        return $this->countItem($where);
    }

    function countTourDeparturePoint($departure_point_id = 0, $city_id = 0, $cat_id = 0)
    {
        $where = "is_trash=0 and is_online=1";
        if (intval($departure_point_id) > 0) {
            $where .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
        }
        if (intval($city_id) > 0) {
            $where .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE city_id='$city_id')";
        }
        if (intval($cat_id) > 0) {
            $where .= " and (cat_id = '" . $cat_id . "' or list_cat_id like '%|" . $cat_id . "|%')";
        }
        return $this->getAll($where) ? count($this->getAll($where)) : 0;
    }

    function countTourDeparturePointStartDate($departure_point_id = 0, $city_id = 0, $cat_id = 0, $list_tour = '')
    {
        $where = "is_trash=0 and is_online=1";
        if (intval($departure_point_id) > 0) {
            $where .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
        }
        if (intval($city_id) > 0) {
            $where .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE tour_id IN ($list_tour) and city_id='$city_id')";
        }
        if (intval($cat_id) > 0) {
            $where .= " and (cat_id = '" . $cat_id . "' or list_cat_id like '%|" . $cat_id . "|%')";
        }
        return $this->getAll($where) ? count($this->getAll($where)) : 0;
    }

    function countTourHotel($tour_id = 0)
    {
        $clsTourHotel = new TourHotel();
        $res = $clsTourHotel->getAll("is_trash=0 and tour_id='$tour_id' order by order_no desc", "hotel_id");
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

    function getSeasonPrice($tour_id = 0, $season = '', $tour_class_id = 0, $_type = '')
    {
        $price = 0;
        $clsTourSeasonPrice = new TourSeasonPrice();
        $lst = $clsTourSeasonPrice->getAll("tour_id='$tour_id' and season='$season' and tour_class_id='$tour_class_id' 
		and _type='$_type' limit 0,1");
        if ($lst[0][$clsTourSeasonPrice->pkey] != '') {
            $price = $lst[0]['price'];
        }
        return $price;
    }

    function checkShowSeasonPrice($tour_id = 0, $season = '', $tour_class_id = 0, $_type = '')
    {
        $is_show = 1;
        $clsTourSeasonPrice = new TourSeasonPrice();
        $lst = $clsTourSeasonPrice->getAll("tour_id='{$tour_id}' and season='{$season}' 
		and tour_class_id='{$tour_class_id}' and _type='{$_type}' limit 0,1");
        if ($lst[0][$clsTourSeasonPrice->pkey] != '') {
            $is_show = $lst[0]['is_hide'] == 1 ? 0 : 1;
        }
        return $is_show;
    }

    function getMinStartDatePromotionID($tour_id = 0)
    {
        $clsPromotion = new Promotion();
        $lst = $clsPromotion->getAll("target_id = '$tour_id' and " . time() . " between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        return $lst[0]['promotion_id'];
    }

    function getMinStartDatePromotionProID($tour_id = 0, $booking_date = 0)
    {
        global $dbconn, $clsISO, $package_id;
        if ($clsISO->getCheckActiveModulePackage($package_id, 'promotionpro', 'default', 'default', 'tour')) {
            $clsPromotion = new Promotion();
            $clsPromotionItem = new PromotionItem();
            $Sql_Promotion = "SELECT p.promotion_id FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . $booking_date . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
            $promotion = $dbconn->GetOne($Sql_Promotion);
            return $promotion;
        };
    }

    function getMinStartDatePromotionPro($tour_id = 0)
    {
        global $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        return $promotion;
    }

    function getMinStartDatePromotionProChoseTime($tour_id = 0, $booking_date = '', $travel_date = '')
    {
        global $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $start_date = strtotime($start_date);
        $Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . $booking_date . " between  p.start_date and p.end_date and " . $travel_date . " between  p.travel_date_from and p.travel_date_to order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        return $promotion;
    }

    function getStartDatePro($tour_id = 0)
    {
        $clsISO = new ISO();
        $one = $this->getOne($tour_id, 'start_date');
        if (!empty($one['start_date'])) {
            return date('d/m/Y', $one['start_date']);
        }
    }

    function getCheckMemSet($tour_id = 0, $start_date = '0')
    {
        global $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $Sql_Promotion = $sql = "SELECT p.promotion_id,p.check_mem_set FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        $check_mem = $clsPromotion->getCheckMem($promotion);
        //		$lst = $clsPromotion->getAll("target_id = '$tour_id' and ".time()." between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        return $check_mem;
    }

    function getCheckVoucher($tour_id = 0)
    {
        global $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $Sql_Promotion = $sql = "SELECT p.promotion_id,p.check_mem_set FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        $check_voucher = $clsPromotion->getCheckCodeProduct($promotion);
        //		$lst = $clsPromotion->getAll("target_id = '$tour_id' and ".time()." between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        return $check_voucher;
    }

    function getDeparturePromotion($tour_id = 0)
    {
        global $core, $clsISO;
        $clsPromotion = new Promotion();
        #
        $tmp = $clsPromotion->getAll("target_id = '$tour_id' and " . time() . " between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        if (!empty($tmp)) {
            return date('m/d/Y', $tmp[0]['start_date']) . ' ? ' . date('m/d/Y', $tmp[0]['end_date']);
        } else {
            return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
        }
    }

    function getDeparturePromotionPro($tour_id = 0)
    {
        global $core, $clsISO, $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        #
        $Sql_Promotion = $sql = "SELECT p.promotion_id,p.start_date,p.end_date FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        //		$tmp=$clsPromotion->getAll("target_id = '$tour_id' and ".time()." between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        if (!empty($promotion)) {
            return $clsPromotion->getStartDatePro($promotion) . ' ? ' . $clsPromotion->getEndDatePro($promotion);
        } else {
            return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
        }
    }

    function getDepartureDayPromotionPro($tour_id = 0)
    {
        global $core, $clsISO, $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        #
        $Sql_Promotion = $sql = "SELECT p.promotion_id,p.start_date,p.end_date FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1  and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        //		$tmp=$clsPromotion->getAll("target_id = '$tour_id' and ".time()." between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        if (!empty($promotion)) {
            return $clsPromotion->getTravelStartDatePro($promotion) . ' - ' . $clsPromotion->getTravelEndDatePro($promotion);
        } else {
            return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
        }
    }

    function getDepartureDayPromotionPro2019($tour_id = 0)
    {
        global $core, $clsISO, $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        #
        $Sql_Promotion = $sql = "SELECT p.promotion_id,p.start_date,p.end_date FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1  and pi.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        //		$tmp=$clsPromotion->getAll("target_id = '$tour_id' and ".time()." between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        if (!empty($promotion)) {
            return $clsPromotion->getTravelStartDatePro($promotion);
        } else {
            return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
        }
    }

    function checkDeparturePromotionOther($tour_id = 0)
    {
        $clsPromotion = new Promotion();
        return $clsPromotion->getAll("is_online=1 and type='TOUR' and target_id='{$tour_id}' and start_date>='" . time() . "'");
    }

    function getPromotionIdPro($pvalTable = 0, $type = 'Tour')
    {
        global $dbconn;
        //        $sql = "SELECT MIN(price) FROM ".DB_PREFIX."tour_price_group WHERE tour_id='$pvalTable' and tour_visitor_type_id =$adult_type_id and tour_class_id IN ($list_tour_class_id) and tour_number_group_id IN ($list_adult_group_size_id)";
        $sql = "SELECT p.promotion_id FROM " . DB_PREFIX . "promotion_item pi LEFT JOIN " . DB_PREFIX . "promotion p ON(pi.promotion_id = p.promotion_id) WHERE pi.taget_id='$pvalTable' and p.type='$type' and " . time() . " between p.start_date and p.end_date and p.is_online=1 and pi.is_online = 1 order by p.start_date asc";
        $pro_id = $dbconn->GetOne($sql);
        //        $this->updateOne($pvalTable,"min_price='".$min_price."'");
        //
        //        $sql1="tour_id='$pvalTable' and (tour_class_id NOT IN ($list_tour_class_id))";
        //        $clsTourPriceGroup->deleteByCond($sql1);
        //        $sql2="tour_id='$pvalTable' and tour_visitor_type_id='$adult_type_id' and tour_number_group_id NOT IN ($list_adult_group_size_id)";
        //        $clsTourPriceGroup->deleteByCond($sql2);
        return $pro_id;
    }

    function getTripPriceNew($pvalTable = 0, $departure = 0, $is_agent = 0, $type = '')
    {
        global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO, $adult_type_id, $short_rate;
        $clsProperty = new Property();
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourStore = new TourStore();
        if (_IS_PROMOTION == 1) {
            $Sql_Promotion = "SELECT p.promot FROM " . DB_PREFIX . "promotion_item pi LEFT JOIN " . DB_PREFIX . "promotion p ON(pi.promotion_id = p.promotion_id) WHERE pi.taget_id='$pvalTable' and p.clsTable='Tour' and " . $departure . " between p.start_date and p.end_date and p.is_online=1 and pi.is_online = 1 order by p.start_date asc LIMIT 0,1";
            $promotion = $dbconn->GetOne($Sql_Promotion);
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            $pricePromotion = $priceAdultAds - ($promotion * $priceAdultAds / 100);
            #
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<span class="block color_main size18"><span class="size15 color_666 line_through">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span> ' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>';
                            } else {
                                return '<span class="block color_main size18">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<span class="block color_main size18"><span class="size15 color_666 line_through">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span> ' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>';
                            } else {
                                return '<span class="block color_main size18">' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                                //                                return $Sql_Promotion;
                            }
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            if ($promotion > 0) {
                                return '<div class="price">
									  <div class="discounted_price">
											<span class="color_main"><span class="size15 color_666 line_through">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>' . $clsISO->formatPrice($pricePromotion) . $short_rate . '</span>
									  </div>
									</div>';
                            } else {
                                return '<div class="price">
									  <div class="discounted_price">
											<span class="color_main">' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>
									  </div>
									</div>';
                            }
                        } else {
                            if ($promotion > 0) {
                                return '<div class="price">
									<div class="discounted_price">
										<span class="color_main"><span class="size15 color_666 line_through">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>' . $short_rate . '' . $clsISO->formatPrice($pricePromotion) . '</span>
									</div>
								</div>';
                            } else {
                                return '<div class="price">
									  <div class="discounted_price">
											<span class="color_main">' . $short_rate . $clsISO->formatPrice($priceAdultAds) . '</span>
									  </div>
									</div>';
                            }
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
                    } else {
                    }
                }
            }
        } else {
            if (_IS_DEPARTURE == 1) {
                if ($clsTourStore->checkExist($pvalTable, 'DEPARTURE') == 1) {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date >= '" . $departure . "' and departure_date<>'0' and tour_visitor_type_id='$adult_type_id' and tour_start_date_id IN (SELECT tour_start_date_id FROM " . DB_PREFIX . "tour_start_date WHERE tour_id='$pvalTable' and is_trash=0 and is_online=1)";
                } else {
                    $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
                }
            } else {
                $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "tour_price_group WHERE tour_id='$pvalTable' and price > 0 and departure_date = '0' and tour_visitor_type_id='$adult_type_id'";
            }
            $priceAdultAds = $dbconn->GetOne($SQL);
            #
            if ($type == 'value') {
                return $clsISO->formatPrice($priceAdultAds);
            } else {
                if ($priceAdultAds > 0) {
                    if ($type == 'detail') {
                        if ($_LANG_ID == 'vn') {
                            return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>';
                        } else {
                            return '<span class="block size18"><span class="size12 color_666">' . $clsISO->getRate() . '</span> ' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>';
                        }
                    } else {
                        if ($_LANG_ID == 'vn') {
                            return '<div class="price">
								  <div class="discounted_price">
										<span>' . $clsISO->formatPrice($priceAdultAds) . $short_rate . '</span>
								  </div>
								</div>';
                        } else {
                            return '<div class="price">
								  <div class="discounted_price">
										<span>' . $short_rate . '' . $clsISO->formatPrice($priceAdultAds) . '</span>
								  </div>
								</div>';
                        }
                    }
                } else {
                    if ($type == 'detail') {
                        return '<a class="contactLink" href="' . $clsISO->getLink('contact') . '">' . $core->get_Lang('contactus') . '</a>';
                    } else {
                    }
                }
            }
        }
    }

    function doDelete($tour_id = 0)
    {
        $clsISO = new ISO();
        // Delete Tour Promotion
        $clsDiscountItem = new DiscountItem();
        $clsDiscountItem->deleteByCond("item_id='$tour_id' and clsTable ='Tour'");
        // Delete Tour Image
        $clsTourImage = new TourImage();
        $clsTourImage->deleteByCond("table_id='$tour_id'");
        // Tour Extention Field
        $clsTourExtension = new TourExtension();
        $clsTourExtension->deleteByCond("tour_1_id='$tour_id' or tour_2_id='$tour_id'");
        // Delete TourPriceGroup
        $clsTourPriceGroup = new TourPriceGroup();
        $clsTourPriceGroup->deleteByCond("tour_id='$tour_id'");
        // Delete TourItinerary
        $clsTourItinerary = new TourItinerary();
        $clsTourItinerary->deleteByCond("tour_id='$tour_id'");
        // Delete TourDestination
        $clsTourDestination = new TourDestination();
        $clsTourDestination->deleteByCond("tour_id='$tour_id'");
        // Delete TourHotel
        $clsTourHotel = new TourHotel();
        $clsTourHotel->deleteByCond("tour_id='$tour_id'");
        // Delete TourStore
        $clsTourStore = new TourStore();
        $clsTourStore->deleteByCond("tour_id='$tour_id'");
        // Tour Start Date
        $clsTourStartDate = new TourStartDate();
        $clsTourStartDate->deleteByCond("tour_id='$tour_id'");
        // Tour Session Price
        $clsTourSeasonPrice = new TourSeasonPrice();
        $clsTourSeasonPrice->deleteByCond("tour_id='$tour_id'");
        // Tour Custom Field
        $clsTourCustomField = new TourCustomField();
        $clsTourCustomField->deleteByCond("tour_id='$tour_id'");
        // Tour Extention Field
        $clsTourExtension = new TourExtension();
        $clsTourExtension->deleteByCond("tour_1_id='$tour_id' or tour_2_id='$tour_id'");
        #
        $this->deleteOne($tour_id);
        return 1;
    }

    function getListDepartureType()
    {
        global $core, $_LANG_ID;
        $listType = array(
            1 => array(
                'title' => $core->get_Lang('Scheduled'),
                'subtitle' => $core->get_Lang('Available but not yet guaranteed')
            ),
            2 => array(
                'title' => $core->get_Lang('On Request'),
                'subtitle' => $core->get_Lang('Must check availability')
            ),
            3 => array(
                'title' => $core->get_Lang('Guaranteed'),
                'subtitle' => $core->get_Lang('Available and will 100% depart')
            ),
            4 => array(
                'title' => $core->get_Lang('Closed'),
                'subtitle' => $core->get_Lang('Not available or sold out')
            )
        );
        return $listType;
    }

    function getTitleDepartureType($duration_type = 0)
    {
        $listType = $this->getListDepartureType();
        return isset($listType[$duration_type]['title'])
            ? $listType[$duration_type]['title'] : "";
    }

    function getPriceTour($tour_id = 0, $departure_date = 0, $tour_class_id = 0, $number_adults = 0, $number_child = 0, $number_infants = 0)
    {
        global $core, $clsISO, $adult_type_id, $child_type_id, $package_id;
        $clsTour = new Tour();
        $clsTourOption = new TourOption();
        $clsProperty = new Property();
        $clsAddOnService = new AddOnService();
        $clsTourProperty = new TourProperty();
        $clsTourService = new TourService();
        $clsTourStore = new TourStore();
        $clsTourStartDate = new TourStartDate();
        $clsBooking = new Booking();
        $clsProfile = new Profile();
        $clsVoucher = new Voucher();
        $clsPromotion = new Promotion();
        $clsTourPriceGroup = new TourPriceGroup();
        $oneTour = $clsTour->getOne($tour_id);
        $number_pick_travellers = $number_adults + $number_child + $number_infants;
        //		var_dump($tour_id,$departure_date,$tour_class_id,$number_adults,$number_child,$number_infants);die;

        $str_check_in_book = strtotime(str_replace('/', '-', $departure_date));
        if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'store', 'default', 'REVQQVJUVVJFLVZpZXRJU08=')) {
            $checkExistTourStartDate = $clsTourStore->checkExist($tour_id, 'DEPARTURE');
            if (!empty($checkExistTourStartDate)) {
                $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and start_date >= '" . $str_check_in_book . "' and close_sale_date >= '" . time() . "' and tour_id ='$tour_id' and is_last_hour=1  order by start_date ASC", $clsTourStartDate->pkey);
                $is_last_hour = !empty($lstTourStartDate) ? 1 : 0;
                $date_coutdown = array();
                foreach ($lstTourStartDate as $k => $v) {
                    $getStrCloseSellDateCountDown = $clsTourStartDate->getStrCloseSellDateCountDown($v[$clsTourStartDate->pkey]);
                    $getCloseSellDateCountDown = $clsTourStartDate->getCloseSellDateCountDown($v[$clsTourStartDate->pkey], 'date_coutdown');
                    if ($getStrCloseSellDateCountDown > time()) {
                        $date_coutdown[] = $getCloseSellDateCountDown;
                    }
                }
                $date_coutdown = array_shift($date_coutdown);
                $lstTourStartDate1 = $clsTourStartDate->getAll("is_trash=0 and start_date >= '" . $str_check_in_book . "' and tour_id ='$tour_id' order by start_date ASC", $clsTourStartDate->pkey);
                $tour_start_date = !empty($lstTourStartDate1) ? 1 : 0;
                $list_start_date = array();
                foreach ($lstTourStartDate as $key => $value) {
                    $list_start_date[] = $clsTourStartDate->getStartDateTour($value[$clsTourStartDate->pkey]);
                }
            }
        }
        $first_start_date = reset($list_start_date);
        $str_first_start_date = $first_start_date;
        // var_dump($first_start_date);die();
        $first_start_date1 = $first_start_date ? $first_start_date : date('m/d/Y', time() + (24 * 60 * 60));
        $first_start_date = str_replace('-', '/', $first_start_date);

        $str_first_start_date = strtotime($str_first_start_date);
        // var_dump($first_start_date);die();
        $str_first_start_date = !empty($first_start_date) ? $str_first_start_date : time() + (24 * 60 * 60);
        #
        $promotion = 0;
        $now_day = strtotime(date('m/d/Y'));

        if (_IS_PROMOTION == 1) {

            $promotion = $clsISO->getPromotion($tour_id, 'Tour', $now_day, $str_check_in_book, $type_check = 'get_more_info');
            $promotion = $promotion['discount_value'];
            $promotion = !empty($promotion) ? $promotion : 0;
        }

        if (_IS_DEPARTURE == 1) {
            $checkExistTourStartDate = $clsTourStore->checkExist($tour_id, 'DEPARTURE');
            $str_check_in_book = !empty($checkExistTourStartDate) ? $str_check_in_book : 0;

            $listTourStartDateClose = $clsTourStartDate->getAll("is_trash=0 and tour_id='$tour_id' and start_date='$str_check_in_book' and open_sale_date <= '$now_day' and close_sale_date <'$now_day' and is_last_hour=1 order by start_date ASC");

            foreach ($listTourStartDateClose as $key => $value) {
                $list_tour_start_date_id[] = $value['tour_start_date_id'];
            }
            $list_tour_start_date_id = implode(',', $list_tour_start_date_id);

            $condd = "is_trash=0 ";
            if (!empty($list_tour_start_date_id)) {
                $condd .= " and tour_start_date_id NOT IN ($list_tour_start_date_id)";
            }
            $condd .= " and start_date='$str_check_in_book' and tour_id ='$tour_id' order by start_date ASC limit 0,1";


            if (!empty($checkExistTourStartDate) && !empty($tour_start_date)) {
                $lstTourStartDate = $clsTourStartDate->getAll($condd);
            }

            if (!empty($lstTourStartDate)) {
                $deposit = $deposit_start_date = $lstTourStartDate[0]['deposit'];
            } else {
                $deposit = $clsTour->getDeposit($tour_id);
            }
            if ($lstTourStartDate[0]['price_type'] == 1) {
                $seat_available = $lstTourStartDate[0]['allotment'];
                if ($number_pick_travellers > $seat_available) {
                    $exceeded_seat = 1;
                } else {
                    $exceeded_seat = 0;
                }
                if ($seat_available == 1) {
                    $seat = $core->get_Lang('seat');
                } else {
                    $seat = $core->get_Lang('seats');
                }
                if (!empty($seat_available)) {
                    $title_seat = $core->get_Lang('Empty') . ' ' . $seat_available . ' ' . $seat;
                } else {
                    $title_seat = $seat = $core->get_Lang('Full');
                }
            } else {
                $title_seat = '';
            }
        }
        $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc", $clsTourProperty->pkey);
        foreach ($lstVisitorType as $key => $value) {
            if ($value['tour_property_id'] != $adult_type_id && $value['tour_property_id'] != $child_type_id) {
                $tour_visitor_infant_id = $value['tour_property_id'];
            }
        }

        $tour_number_adults_id = $clsTourPriceGroup->getTourNumberGroup($adult_type_id, $number_adults, $tour_id);
        $tour_number_child_id = $clsTourPriceGroup->getTourNumberGroup($child_type_id, $number_child, $tour_id);
        $tour_number_infants_id = $clsTourPriceGroup->getTourNumberGroup($tour_visitor_infant_id, $number_infants, $tour_id);
        $price_adults_simple = $price_child_simple = $price_infants_simple = 0;
        if (!empty($checkExistTourStartDate)) {
            if (!empty($lstTourStartDate)) {
                if ($lstTourStartDate[0]['price_type'] == 1) {
                    $price = $lstTourStartDate[0]['price'];
                    $price = json_decode($price, 'true');

                    $price_adults = $price_adults_simple = $price[$adult_type_id][$tour_class_id][$tour_number_adults_id];
                    $price_child = $price_child_simple = $price_adults > 0 ? $price[$child_type_id][$tour_class_id][$tour_number_child_id] : 0;
                    $price_infants = $price_infants_simple = $price_adults > 0 ? $price[$tour_visitor_infant_id][$tour_class_id][$tour_number_infants_id] : 0;
                    $price_adults = $price_adults - $price_adults * $promotion / 100;
                    $price_child = $price_child - $price_child * $promotion / 100;
                    $price_infants = $price_infants - $price_infants * $promotion / 100;
                } elseif ($lstTourStartDate[0]['price_type'] == 0) {
                    $price_adults = $price_adults_simple = $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_adults_id, $adult_type_id, 0);
                    $price_child = $price_child_simple = $price_adults > 0 ? $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_child_id, $child_type_id, 0) : 0;
                    $price_infants = $price_infants_simple = $price_adults ? $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_infants_id, $tour_visitor_infant_id, 0) : 0;

                    $price_adults = $price_adults - $price_adults * $promotion / 100;
                    $price_child = $price_child - $price_child * $promotion / 100;
                    $price_infants = $price_infants - $price_infants * $promotion / 100;
                }
            } else {
                $price_adults = 0;
                $price_child = 0;
                $price_infants = 0;
            }
        } else {
            $price_adults = $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_adults_id, $adult_type_id, 0);
            $price_adults_simple = $price_adults;
            $price_child = $price_adults > 0 ? $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_child_id, $child_type_id, 0) : 0;
            $price_child_simple = $price_child;
            $price_infants = $price_adults > 0 ? $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_infants_id, $tour_visitor_infant_id, 0) : 0;
            $price_infants_simple = $price_infants;

            $price_adults = $price_adults - $price_adults * $promotion / 100;
            $price_child = $price_child - $price_child * $promotion / 100;
            $price_infants = $price_infants - $price_infants * $promotion / 100;
        }
        return [
            'price_adults' => round($price_adults),
            'price_child' => round($price_child),
            'price_infants' => round($price_infants),
            'price_adults_simple' => round($price_adults_simple),
            'price_child_simple' => round($price_child_simple),
            'deposit' => $deposit,
        ];
    }

    function getPriceSingleSupply($tour_id = 0)
    {
        global $_LANG_ID, $dbconn, $clsISO;
        $price = '';
        $one = $this->getOne($tour_id, 'price_single_supply');
        $priceAdultAds = $one['price_single_supply'];
        if ($priceAdultAds > 0) {
            return $clsISO->formatPrice($priceAdultAds);
        }
    }

    function getMeetingPoint($tour_id = 0, $oDataTable = null)
    {
        if (!isset($oDataTable['meeting_point'])) {
            $oDataTable = $this->getOne($tour_id, 'meeting_point');
        }
        return $oDataTable['meeting_point'];
    }

    function getEndPoint($tour_id = 0, $oDataTable = null)
    {
        if (!isset($oDataTable['end_point'])) {
            $oDataTable = $this->getOne($tour_id, 'end_point');
        }
        return $oDataTable['end_point'];
    }

    function checkisOnline($pvalTable = 0)
    {
        $res = $this->getOneField("is_online", $pvalTable);
        return !empty($res) ? 1 : 0;
    }

    function getAdditionalInfo($pvalTable = 0, $one = null)
    {
        if (!isset($one['additional_info'])) {
            $one = $this->getOne($pvalTable, 'additional_info');
        }
        return html_entity_decode($one['additional_info']);
    }
    function linkListTourPackage($tour_id = 0)
    {
        if ($tour_id) {
            return PCMS_URL . "/tour/edit/$tour_id/tourpackage/tour-package";
        }
    }
    function getParentId($pvalTable = 0, $one = null)
    {
        if (!isset($one['parent_id'])) {
            $one = $this->getOne($pvalTable, 'parent_id');
        }
        return $one['parent_id'];
    }
    function deleteAllPackage($pvalTable = 0)
    {
        if (empty($pvalTable)) return false;
        $list_tour_package = $this->getAll("parent_id=$pvalTable", $this->pkey);
        $clsTourStartDate = new TourStartDate();
        $clsTourStore = new TourStore();
        $clsTourPriceGroup = new TourPriceGroup();
        foreach ($list_tour_package as $value) {
            $tour_id = $value["tour_id"];
            if ($this->doDelete($tour_id)) {
                $clsTourStore->deleteByCond("tour_id='$tour_id'");
                $clsTourStartDate->deleteByCond("tour_id='$tour_id'");
                $clsTourPriceGroup->deleteByCond("tour_id='$tour_id'");
            }
        }
    }
    function checkIsPackage($pvalTable = 0)
    {
        return ($this->getOneField("parent_id", $pvalTable)) ? 1 : 0;
    }
    function getPackageMinPrice($pvalTable = 0, $one = null)
    {
        global $dbconn, $adult_type_id;
        if (!isset($one['has_package'])) {
            $one = $this->getOne($pvalTable, 'has_package');
        }
        $listPackage = $this->getAll("parent_id=$pvalTable and is_package_online=1", "tour_id, title");
        if (!empty($one['has_package']) && !empty($listPackage)) {
            $tour_ids = array_column($listPackage, 'tour_id');
            $str_tour_id = implode(",", $tour_ids);

            $SQL = "SELECT tour_id, price as min_price FROM " . DB_PREFIX . "tour_price_group WHERE tour_id IN ($str_tour_id) and price > 0 and departure_date = 0 and tour_visitor_type_id='$adult_type_id' ORDER BY price ASC LIMIT 1";
            $rec = $dbconn->getAll($SQL)[0];
            return $rec["tour_id"];
        }
        return 0;
    }
}
