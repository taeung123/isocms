<?php
class Cruise extends dbBasic
{
    function __construct()
    {
        $this->pkey = "cruise_id";
        $this->tbl = DB_PREFIX . "cruise";
    }
    function checkOnlineBySlug($cruise_id = 0, $slug = '')
    {
        $item = $this->getAll("is_trash=0 and is_online=1 and cruise_id='$cruise_id' and slug='$slug'", $this->pkey);
        if (empty($item))
            return 0;
        return 1;
    }
    function getTitle($pvalTable = 0, $one = null)
    {
        if (!isset($one['title'])) {
            $one = $this->getOne($pvalTable, 'title');
        }
        return $one['title'] ?? '';
    }
    function getHighlight($pvalTable = 0, $one = null)
    {
        if (!isset($one['highlight'])) {
            $one = $this->getOne($pvalTable, 'highlight');
        }
        return $one['highlight'];
    }
    function getTravelAs($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'listTravelAs');
        return $one['listTravelAs'];
    }
    function getSlug($pvalTable = 0, $one = null)
    {
        if (!isset($one['slug'])) {
            $one = $this->getOne($pvalTable, 'slug');
        }
        return $one['slug'] ?? '';
    }
    function getLinkBookServices($pvalTable = 0)
    {
        global $_LANG_ID, $core, $extLang;
        $ContactCruise = vnSessionGetVar('ContactCruise');
        if (!empty($ContactCruise) && $ContactCruise['cruise_id'] == $pvalTable) {
            if ($_LANG_ID == "vn") {
                return "du-thuyen/" . $core->encryptID($pvalTable) . "/dich-vu-them.html";
            }
            return $extLang . "/cruise/" . $core->encryptID($pvalTable) . "/services-book.html";
        }
        return "";
    }
    function getBySlug($slug = '')
    {
        $all = $this->getAll("is_trash=0 and slug='$slug' order by " . $this->pkey . " limit 0,1", $this->pkey);
        return $all[0][$this->pkey];
    }
    function getCruiseCode($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'cruise_code');
        return strtoupper($one['cruise_code']);
    }
    function getMetaDescription($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        if (!isset($one['about'])) {
            $one = $this->getOne($pvalTable, 'about');
        }
        return html_entity_decode($one['about']);
    }
    function getIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'intro');
        return html_entity_decode($one['intro']);
    }
    function getEasyCancellation($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'easy_cancellation');
        if ($one == '')
            return '';
        return html_entity_decode($one['easy_cancellation']);
    }
    function getBookingCondition($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'booking_condition');
        if ($one == '')
            return '';
        return html_entity_decode($one['booking_condition']);
    }
    function getStripIntro($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'about,content');
        if (!empty($one['about']))
            return strip_tags(html_entity_decode($one['about']));
        return strip_tags(html_entity_decode($one['content']));
    }
    function getContent($pvalTable = 0, $field = '*')
    {
        $one = $this->getOne($pvalTable, $field);
        switch ($field) {
            case 'what_include':
                return html_entity_decode($one['what_include']);
                break;
            case 'what_include_old':
                return html_entity_decode($one['what_include_old']);
                break;
            case 'retaurant':
                return html_entity_decode($one['retaurant']);
                break;
            case 'policies':
                return html_entity_decode($one['policies']);
                break;
            case 'deck_plan':
                return html_entity_decode($one['deck_plan']);
                break;
            default:
                return html_entity_decode($one['content']);
        }
    }
    function getCityAroundBlog($cruise_id = 0, $is_image = false)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsCruiseDestination = new CruiseDestination;
        $html = '';
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id='$cruise_id' order by order_no asc");
        if (is_array($rsllist) && count($rsllist) > 0) {
            if ($is_image) {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $html .= ($i == 0 ? '' : ' <img class="arrow" src="' . URL_IMAGES . '/arrow.png" /> ') . '<a target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                }
                unset($rsllist);
            } else {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $html .= ($i == 0 ? '' : ' , ') . '<a target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                }
                unset($rsllist);
            }
        }
        return $html;
    }
    function getTotalCabin($pvalTable = 0)
    {
        global $core;
        $one = $this->getOne($pvalTable, 'total_cabin');
        $number_cabin = $one['total_cabin'];
        if (intval($number_cabin) > 0) {
            return $number_cabin . ' ' . ($number_cabin > 1 ? $core->get_Lang('cabins') : $core->get_Lang('cabin'));
        }
        return 0;
    }
    function getCruiseMap($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'cruise_map');
        $cruise_map = html_entity_decode($one['cruise_map']);
        return $cruise_map;
    }
    function getDeparturePort($pvalTable = 0, $one = null)
    {
        if (!isset($one['departure_port'])) {
            $one = $this->getOne($pvalTable, 'departure_port');
        }
        $departure_port = html_entity_decode($one['departure_port']);
        return $departure_port;
    }
    function getAbout($pvalTable = 0, $one = null)
    {
        if (!isset($one['about'])) {
            $one = $this->getOne($pvalTable, 'about');
        }
        $about = html_entity_decode($one['about']);
        return $about;
    }
    function getMostAbout($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'most_about');
        $most_about = html_entity_decode($one['most_about']);
        return $most_about;
    }
    function getImprotantNote($pvalTable = 0, $one = null)
    {
        if (!isset($one['important_notes'])) {
            $one = $this->getOne($pvalTable, 'important_notes');
        }
        $important_notes = html_entity_decode($one['important_notes']);
        return $important_notes;
    }
    function getInclusion($pvalTable = 0, $one = null)
    {
        if (!isset($one['inclusion'])) {
            $one = $this->getOne($pvalTable, 'inclusion');
        }
        return html_entity_decode($one['inclusion']);
    }
    function getExclusion($pvalTable = 0, $one = null)
    {
        if (!isset($one['exclusion'])) {
            $one = $this->getOne($pvalTable, 'exclusion');
        }
        $exclusion = html_entity_decode($one['exclusion']);
        return $exclusion;
    }
    function getCruisePolicy($pvalTable = 0, $one = null)
    {
        if (!isset($one['cruise_policy'])) {
            $one = $this->getOne($pvalTable, 'cruise_policy');
        }
        $cruise_policy = html_entity_decode($one['cruise_policy']);
        return $cruise_policy;
    }
    function getCruiseBookingPolicy($pvalTable = 0, $one = null)
    {
        if (!isset($one['booking_policy'])) {
            $one = $this->getOne($pvalTable, 'booking_policy');
        }
        $cruise_booking_policy = html_entity_decode($one['booking_policy'] ?? '');
        return $cruise_booking_policy;
    }
    function getDeposit($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'deposit');
        return $one['deposit'];
    }
    function getCruiseChildPolicy($pvalTable = 0, $one = null)
    {
        if (!isset($one['child_policy'])) {
            $one = $this->getOne($pvalTable, 'child_policy');
        }
        $cruise_booking_policy = html_entity_decode($one['child_policy']);
        return $cruise_booking_policy;
    }
    function getChildPolicy($pvalTable = 0)
    {
        global $core, $clsConfiguration, $clsISO;
        if ($clsConfiguration->getValue('InfantFaresPolicy') > 0) {
            $InfantFaresPolicy = $clsConfiguration->getValue('InfantFaresPolicy') . $core->get_Lang('% Adult fares');
        } else {
            $InfantFaresPolicy = $core->get_Lang('Free');
        }
        $html = '<table class="table">
				<caption class="z_16 text-bold mt10">
					<label>' . $core->get_Lang('Child Policies') . '</label>
					<span class="fa fa-times cp-detail-close c6 fr"></span>
				</caption>
				<tbody>
					<tr>
						<th>' . $core->get_Lang('Child Age') . '</th>
						<th>' . $core->get_Lang('Cruise Fares') . '</th>
					</tr>
					<tr>
						<td>' . $clsConfiguration->getValue('InfantTitlePolicy') . $core->get_Lang('years old') . '</td>
						<td>' . $InfantFaresPolicy . '</td>
					</tr>
					<tr>
						<td>' . $clsConfiguration->getValue('ChildTitlePolicy') . $core->get_Lang('years old') . '</td>
						<td>' . $clsConfiguration->getValue('ChildFaresPolicy') . $core->get_Lang('% Adult fares') . '</td>
					</tr>
					<tr>
						<td>' . $core->get_Lang('Over') . ' ' . $clsConfiguration->getValue('AdultTitlePolicy') . ' ' . $core->get_Lang('years old') . '</td>
						<td>' . $core->get_Lang('Full Adult fares') . '</td>
					</tr>
				 </tbody>
			 </table>';
        return $html;
    }
    function getCruiseStar($pvalTable = 0, $is_fix = '')
    {
        $one = $this->getOne($pvalTable, 'star_number');
        $star_number = $one['star_number'];
        switch ($is_fix) {
            case '1':
                return '<i class="bl-star-small star' . $star_number . '"></i>';
                break;
            default:
                return '<i class="bl-star star' . $star_number . '"></i>';
        }
    }
    function getStarNew($pvalTable = 0, $one = null)
    {
        if (!isset($one['star_number'])) {
            $one = $this->getOne($pvalTable, 'star_number');
        }
        $star_number = $one['star_number'];
        $width_star = 77 * ($star_number / 5);
        return '<label class="rate-1 mb0" style="width:' . $width_star . 'px">
      		<span style="width: 100%;"></span> 
      	</label>';
    }
    function getMaxAdult($pvalTable = 0)
{
    global $core, $_LANG_ID;

    $pvalTable = (int)$pvalTable;

    if ($pvalTable <= 0) {
        return 0;
    }

    $clsCruiseCabin = new CruiseCabin();

    $lstCruiseCabin = $clsCruiseCabin->getAll(
        "is_trash=0
         AND is_online=1
         AND cruise_id='" . $pvalTable . "'
         ORDER BY max_adult DESC",
        'max_adult'
    );

    if (
        !is_array($lstCruiseCabin)
        || empty($lstCruiseCabin)
        || !isset($lstCruiseCabin[0])
        || !isset($lstCruiseCabin[0]['max_adult'])
    ) {
        return 0;
    }

    return (int)$lstCruiseCabin[0]['max_adult'];
}


function getMaxChild($pvalTable = 0)
{
    global $core, $_LANG_ID;

    $pvalTable = (int)$pvalTable;

    if ($pvalTable <= 0) {
        return 0;
    }

    $clsCruiseCabin = new CruiseCabin();

    $lstCruiseCabin = $clsCruiseCabin->getAll(
        "is_trash=0
         AND is_online=1
         AND cruise_id='" . $pvalTable . "'
         ORDER BY max_child DESC",
        'max_child'
    );

    if (
        !is_array($lstCruiseCabin)
        || empty($lstCruiseCabin)
        || !isset($lstCruiseCabin[0])
        || !isset($lstCruiseCabin[0]['max_child'])
    ) {
        return 0;
    }

    return (int)$lstCruiseCabin[0]['max_child'];
}
    function getListTransport()
    {
        global $core;
        $clsTransport = new Transport();
        $assign_list["clsTransport"] = $clsTransport;
        $lstTransport = $clsTransport->getAll("is_trash=0 order by order_no desc");
        return $lstTransport;
    }
    function checkCruiseStore($cruise_id = 0, $_type = '')
    {
        $clsCruiseStore = new CruiseStore();
        $res = $clsCruiseStore->getAll("cruise_id='$cruise_id' and _type = '$_type' limit 0,1");
        return (!empty($res)) ? 1 : 0;
    }
    function getLinkOld($cruise_id = 0)
    {
        global $_LANG_ID, $extLang;
        return $extLang . '/cruises/' . $this->getSlug($cruise_id) . '-' . $cruise_id . '.html';
    }
    function getLink($pvalTable = 0, $type = '', $one = null)
    {
        global $_LANG_ID, $extLang;
        switch ($type) {
            case 'RATE':
                return $extLang . '/halongbaycruises/' . $this->getSlug($pvalTable, $one) . '/check-rate.html';
                break;
            case 'BOOK':
                return $extLang . '/halongbaycruises/' . $this->getSlug($pvalTable, $one) . '/booking.html';
                break;
            default:
                return $extLang . '/c' . $pvalTable . '-' . $this->getSlug($pvalTable, $one) . '.html';
        }
    }
    function getLink2($pvalTable = 0, $type = '', $one = null)
    {
        global $_LANG_ID, $extLang;
        switch ($type) {
            case 'RATE':
                return $extLang . '/old-halongbaycruises/' . $this->getSlug($pvalTable, $one) . '/check-rate.html';
                break;
            case 'BOOK':
                return $extLang . '/old-halongbaycruises/' . $this->getSlug($pvalTable, $one) . '/booking.html';
                break;
            default:
                return $extLang . '/old-c' . $pvalTable . '-' . $this->getSlug($pvalTable, $one) . '.html';
        }
    }
    function getLinkPromotion($pvalTable = 0)
    {
        global $_LANG_ID, $extLang;
        if ($_LANG_ID == 'vn')
            return $extLang . '/du-thuyen/' . $this->getSlug($pvalTable) . '.html';
        return $extLang . '/cruise/' . $this->getSlug($pvalTable) . '.html';
    }
    function getLinkVideo($cruise_id = 0)
    {
        global $_LANG_ID, $extLang;
        if ($_LANG_ID == 'vn')
            return $extLang . '/du-thuyen/' . $this->getSlug($cruise_id) . '-' . $cruise_id . '-video' . '.html';
        return $extLang . '/cruises/' . $this->getSlug($cruise_id) . '-' . $cruise_id . '-video' . '.html';
    }
    function getLinkVideoIframe($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return str_replace("https://www.youtube.com/watch?v=", "", $one['link']);
    }
    function getLinkBook($cruise_id = 0, $one = null)
    {
        global $_LANG_ID, $extLang;
        if ($_LANG_ID == 'vn')
            return $extLang . '/du-thuyen/' . $this->getSlug($cruise_id, $one) . '-c' . $cruise_id . '/bookingcabin.html';
        return $extLang . '/cruise/' . $this->getSlug($cruise_id, $one) . '-c' . $cruise_id . '/bookingcabin.html';
    }
    function getLinkContact()
    {
        global $_LANG_ID, $extLang;
        return $extLang . '/cruise/enquiry.html';
    }
    function getBuild($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'build');
        if ($one['build'] != '') {
            return $one['build'];
        } else {
            return date('Y', time());
        }
    }
    function getMaterial($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'material');
        if ($one['material'] != '') {
            return $one['material'];
        }
    }
    function getDiscountText($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'discount_text_rate');
        return $one['discount_text_rate'];
    }
    function checkShowPrice($pvalTable = 0)
    {
        global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID, $now_day;
        $clsCruiseCabin = new CruiseCabin();
        $clsCruiseItinerary = new CruiseItinerary();
        $listCruiseCabin = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and cruise_id='$pvalTable'", $clsCruiseCabin->pkey);
        if (empty($listCruiseCabin)) {
            return 0;
        }
        $listCruiseItinerary = $clsCruiseItinerary->getAll("is_trash=0 and is_online=1 and cruise_id='$pvalTable'", $clsCruiseItinerary->pkey);
        if (empty($listCruiseItinerary)) {
            return 0;
        }
        return 1;
    }
    function getPrice($pvalTable = 0, $is_fix = '')
    {
        global $core, $clsISO;
        #
        $one = $this->getOne($pvalTable, 'price');
        $price = (intval($one['price']) > 0) ? $one['price'] : 0;
        switch ($is_fix) {
            case '1':
                return '<strong class="priceText">$' . $clsISO->formatPrice($price) . '</strong>';
                break;
            case '2':
                return '$' . $clsISO->formatPrice($price);
                break;
            case '3':
                $html = '<sub style="font-size: 12px; font-weight:bold;vertical-align: text-top; line-height:10px">US</sub>';
                $html .= '<span style="font-size:13px;font-weight:bold"> $' . $clsISO->formatPrice($price) . '</span> /person';
                return $html;
                break;
            case '4':
                return '<span style="color: red;"><sup>us</sup> <span style="font-size:18px;font-weight:bold">$' . $clsISO->formatPrice($price) . '</span> /person</span>';
                break;
            default:
                return '<strong class="priceText">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($price) . '</strong>/' . $core->get_Lang('person');
        }
    }
    function getPriceOld($pvalTable = 0, $is_fix = '')
    {
        global $core, $clsISO;
        #
        $one = $this->getOne($pvalTable, 'price_old');
        $price = (intval($one['price_old']) > 0) ? $one['price_old'] : 0;
        switch ($is_fix) {
            case '1':
                $html = '<sub style="font-size: 12px; font-weight:bold;vertical-align: text-top; line-height:10px">US</sub>';
                $html .= '<span style="font-size:13px;font-weight:bold"> $' . $clsISO->formatPrice($price) . '</span> /person';
                return $html;
                break;
            case '2':
                return '<span style="color: red;"><sup>us</sup> <span style="font-size:18px;font-weight:bold">$' . $clsISO->formatPrice($price) . '</span> /person</span>';
                break;
            default:
                return '$' . $clsISO->formatPrice($price);
        }
    }
    function getTripPrice($pvalTable = 0, $one = null)
    {
        global $core, $clsISO;
        #
        if (!isset($one['price'])) {
            $one = $this->getOne($pvalTable, 'price');
        }
        $price = (intval($one['price']) > 0) ? $one['price'] : 0;
        return $clsISO->formatPrice($price);
    }
    function getTripPriceDay($pvalTable = 0, $now_month = '', $num_day = 0, $one = null)
    {
        global $core, $clsISO;
        #
        if ($num_day == 3) {
            if (!isset($one['price_3day'])) {
                $one = $this->getOne($pvalTable, 'price_3day');
            }
            $price = (intval($one['price_3day']) > 0) ? $one['price_3day'] : 0;
        } else {
            if (!isset($one['price'])) {
                $one = $this->getOne($pvalTable, 'price');
            }
            $price = (intval($one['price']) > 0) ? $one['price'] : 0;
        }
        return $clsISO->formatPrice($price);
    }
    function getLTripPriceold($pvalTable = 0, $now_month = '', $type = 'detail')
    {
        global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID;
        $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
        if (!empty($lstSeason)) {
            $season = 'high';
        } else {
            $season = 'low';
        }
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_id='$pvalTable' and season ='$season'";
        #
        $price = $dbconn->GetOne($SQL);
        if ($type == 'Value') {
            return $price;
        } else {
            if ($price > 0) {
                if ($type == 'list') {
                    if ($_LANG_ID == 'vn') {
                        return '<span>' . $core->get_Lang('From') . '</span><span><label>' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</label></span>';
                    } else {
                        return '<span>' . $core->get_Lang('From') . '</span><span><label>' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</label></span>';
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        return $clsISO->formatPrice($price) . $clsISO->getShortRate();
                    } else {
                        return $clsISO->getShortRate() . $clsISO->formatPrice($price);
                    }
                }
            } else {
                if ($type == 'detail') {
                    vnSessionDelVar('cruise_itinerary_contact_id');
                    vnSessionDelVar('hotel_contact_id');
                    vnSessionDelVar('tour_contact_id');
                    vnSessionSetVar('cruise_contact_id', $pvalTable);
                    return '<a class="linkContact" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
                } else {
                }
            }
        }
    }
    function getLTripPrice($pvalTable = 0, $now_month = '', $type = 'detail')
    {
        global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID;
        $clsPromotion = new Promotion();
        $clsCruiseSeasonPrice = new CruiseSeasonPrice();
        $clsCruiseProperty = new CruiseProperty();
        $clsPromotionItem = new PromotionItem();
        $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
        if (!empty($lstSeason)) {
            $season = 'high';
        } else {
            $season = 'low';
        }
        $Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE pi.is_online = 1 and p.is_online = 1 and p.type = 'Cruise' and pi.taget_id =$pvalTable and pi.cruise_intinerary=0 and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";;
        $promotion = $dbconn->GetOne($Sql_Promotion);
        $sql2 = "cruise_id='$pvalTable' and cruise_cabin_id NOT IN (SELECT cruise_cabin_id FROM default_cruise_cabin WHERE is_trash= 0 and is_online=1 and cruise_id='$pvalTable')";
        //return $sql2;
        $clsCruiseSeasonPrice->deleteByCond($sql2);
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_id='$pvalTable' and season ='$season'";
        #
        $price = $dbconn->GetOne($SQL);
        $sql_cabin = "SELECT cruise_cabin_id,group_size_id FROM " . DB_PREFIX . "cruise_season_price WHERE price = '$price' and cruise_id='$pvalTable' and season ='$season'";
        $cabin = $dbconn->GetAll($sql_cabin);
        $cruise_cabin_id = $cabin[0]['cruise_cabin_id'] ?? 0;
        $group_size_id = $cabin[0]['group_size_id'] ?? 0;
        $number_adult = $clsCruiseProperty->getNumberAdult($group_size_id);
        $pricePromotion = $price - ($promotion * $price / 100);
        //        return $Sql_Promotion;
        if ($type == 'Value') {
            return $price;
        } elseif ($type == 'Valuelist') {
            if ($_LANG_ID == 'vn') {
                return '<span>' . $core->get_Lang('From') . '</span> <span><label>' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</label></span>';
            } else {
                return '<span>' . $core->get_Lang('From') . '</span> <span><label>' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</label></span>';
            }
        } elseif ($type == 'Valuedetail') {
            if ($_LANG_ID == 'vn') {
                return '<span><label class="color_fb1111">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</label></span>';
            } else {
                return '<span><label class="color_fb1111">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</label></span>';
            }
        } else {
            if ($price > 0) {
                if ($type == 'list') {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span> <span><label class="color_fb1111">' . $clsISO->formatPrice($pricePromotion) . $clsISO->getShortRate() . '</label></span>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="color_fb1111">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</label></span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span> <span><label class="color_fb1111">' . $clsISO->getShortRate() . $clsISO->formatPrice($pricePromotion) . '</label></span>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="color_fb1111">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</label></span>';
                        }
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span> <span><label class="color_fb1111">' . $clsISO->formatPrice($pricePromotion) . $clsISO->getShortRate() . '</label></span>';
                        } else {
                            return '<span><label class="color_fb1111">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</label></span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<span class="size15 color_666 line_through">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span> <span><label class="color_fb1111">' . $clsISO->getShortRate() . $clsISO->formatPrice($pricePromotion) . '</label></span>';
                        } else {
                            return '<span><label class="color_fb1111">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</label></span>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                    vnSessionDelVar('cruise_itinerary_contact_id');
                    vnSessionDelVar('hotel_contact_id');
                    vnSessionDelVar('tour_contact_id');
                    vnSessionSetVar('cruise_contact_id', $pvalTable);
                    return '<a class="linkContact" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
                } else {
                }
            }
        }
    }
    function getLTripPrice1($pvalTable = 0, $now_month = '', $type = 'detail')
    {
        global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID, $now_day;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $clsCruiseItinerary = new CruiseItinerary();
        $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
        if (!empty($lstSeason)) {
            $season = 'high';
        } else {
            $season = 'low';
        }
        $Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE pi.is_online = 1 and p.is_online = 1 and p.type = 'Cruise' and pi.taget_id =$pvalTable and pi.cruise_intinerary=0 and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";;
        $promotion = $dbconn->GetOne($Sql_Promotion);
        $cruise = $this->getOne($pvalTable);
        $config_price_overnight = !empty($cruise['config_price_overnight'])
            ? json_decode($cruise['config_price_overnight'], true) : [];
        $groupPrices = $config_price_overnight['prices'] ?? [];
        $price = 0;
        $lowestPrices = [];
        if ($cruise['cruise_type'] == 2) {
            foreach ($groupPrices as $key => $itinerary) {
                if (!empty($itinerary)) {
                    foreach ($itinerary as $capacityId => $capacity) {
                        if (!empty($capacity[$season]) && isset($itinerary['price_by'])) {
                            if ($itinerary['price_by'] === 1) { // Nếu price_by = 1, lấy giá của carbin
                                if (!empty($capacity[$season]['carbin'])) {
                                    if ($capacity[$season]['carbin'] < $price || $price == 0) {
                                        $price = $capacity[$season]['carbin'];
                                    }
                                }
                            } elseif ($itinerary['price_by'] === 0) { // Nếu price_by = 0, lấy giá thấp nhất của person/đầu người
                                if (!empty($capacity[$season]['person'])) {
                                    foreach ($capacity[$season]['person'] as $num_person => $unitPrice) {
                                        // Bỏ qua giá trị 0 và tính giá mỗi người
                                        if ($unitPrice == 0) {
                                            continue;
                                        }
                                        $unitPricePerPerson = $unitPrice / $num_person; // Tính giá mỗi người
                                        if ($unitPricePerPerson < $price || $price == 0) {
                                            $price = $unitPricePerPerson;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $lowestPrices[$key] = $price;
            }
            $price = !empty($lowestPrices) ? min($lowestPrices): 0;
        } elseif ($cruise['cruise_type'] == 1) {
            $listCruiseItinerary = $clsCruiseItinerary->getAll("cruise_id = $pvalTable", "$clsCruiseItinerary->pkey, duration_type, price_by_low, price_by_high");
            foreach ($listCruiseItinerary as $key => $itinerary) {
                $cruise_itinerary_id = $itinerary["cruise_itinerary_id"];
                if ($itinerary["duration_type"] == 1) {
                    if (isset($groupPrices[$itinerary[$clsCruiseItinerary->pkey]])) {
                        $cruise_itinerary = $groupPrices[$itinerary[$clsCruiseItinerary->pkey]];
                        if (isset($cruise_itinerary[key($cruise_itinerary)])) {
                            $capacity = $cruise_itinerary[key($cruise_itinerary)];
                            $ca_price_by = $cruise_itinerary["price_by"] ?? '';
                            if (!empty($capacity[$season])) {
                                if ($ca_price_by == 1) { // Nếu price_by = 1, lấy giá của carbin
                                    if (!empty($capacity[$season]['carbin']) && ($capacity[$season]['carbin'] < $price || $price == 0)) {
                                        $price = $capacity[$season]['carbin'];
                                    }
                                } elseif ($ca_price_by == 0) { // Nếu price_by = 0, lấy giá thấp nhất của person/đầu người
                                    if (!empty($capacity[$season]['person'])) {
                                        foreach ($capacity[$season]['person'] as $num_person => $unitPrice) {
                                            if ($unitPrice == 0) {
                                                continue;
                                            }
                                            $unitPricePerPerson = $unitPrice / $num_person; // Tính giá mỗi người
                                            if ($unitPricePerPerson < $price || $price == 0) {
                                                $price = $unitPricePerPerson;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } elseif ($itinerary["duration_type"] == 0) {
                    $price_by_season = $itinerary["price_by_$season"];
                    $price1 = $price2 = 0;
                    if ($price_by_season == 0) {
                        $SQL1 = "SELECT MIN(price/number_adult) FROM " . DB_PREFIX . "cruise_season_price WHERE number_adult > 0 and price > 0 and cruise_id='$pvalTable' and season ='$season' and cruise_itinerary_id = '$cruise_itinerary_id'";
                        $price1 = $dbconn->GetOne($SQL1);
                    } elseif ($price_by_season == 1) {
                        $SQL2 = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE number_adult = 0 and price > 0 and cruise_id='$pvalTable' and season ='$season' and cruise_itinerary_id = '$cruise_itinerary_id'";
                        $price2 = $dbconn->GetOne($SQL2);
                    }
                    $price1 = ($price1 == 0) ? null : (int)$price1;
                    $price2 = ($price2 == 0) ? null : (int)$price2;
                    if ($price1 === null) {
                        $price = $price2;
                    } elseif ($price2 === null) {
                        $price = $price1;
                    } else {
                        $price = min($price1, $price2);
                    }
                }
                $lowestPrices[$key] = $price;
            }
            $price = min($lowestPrices);
        }
        #
        $discount = $clsISO->getPromotion($pvalTable, 'Cruise', $now_day, $now_day, 'info_promotion');
        if ($discount) {
            $promotion = $discount['discount_value'];
            if ($discount['discount_type'] == 2) {
                $promotionPrice = $promotion * $price / 100;
                if (isset($discount['max_discount']) && (intval($discount['max_discount']) > 0)) {
                    $promotionPrice = min($promotionPrice, $discount['max_discount']);
                }   
                //var_dump($priceAdultAds, $promotion, $pricePromotion);
            } else {
                $promotionPrice = $discount['discount_value'];
            }
            $pricePromotion = $price - $promotionPrice;
            
            if ($type == "update_min_price") return $pricePromotion;
        }
        if ($type == "update_min_price") return $price;
        if ($type == 'Value') {
            return $price;
        } elseif ($type == 'Valuelist') {
            if ($_LANG_ID == 'vn') {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span>';
            } else {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span>';
            }
        } elseif ($type == 'Valuedetail') {
            if ($_LANG_ID == 'vn') {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span>';
            } else {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span>';
            }
        } else {
            if ($price > 0) {
                if ($type == 'list') {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span>' . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($pricePromotion) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($price) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label>/' . $core->get_Lang("person") . '</span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price) . '<span class="unit_price">' . '</span>' . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($pricePromotion) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="price_cruise">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price) . '<span class="unit_price">' . '</span></label></span>';
                        }
                    }
                } elseif ($type == 'price_2024') {
                    $title = "<span>{$core->get_Lang("From")}</span><div class='hnv_trvs_main_tour_item_content_price_number'>";
                    if ($_LANG_ID == 'vn') {
                        return "$title<span>{$clsISO->formatPrice($price)}{$clsISO->getShortRate()}</span></div>";
                    } else {
                        return "{$title}US <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($price)}</span></div>";
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr1">
											<span class="lbl_price">' . $core->get_Lang('Only from') . '</span>
											<span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span>
										</div>
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->formatPrice($pricePromotion) . $clsISO->getShortRateText() . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span> <span><label>' . $clsISO->formatPrice($pricePromotion) . $clsISO->getShortRate() . '</label></span>';
                        } else {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr1">
											<span class="lbl_price">' . $core->get_Lang('Only from') . '</span>
										</div>
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->formatPrice($price) . $clsISO->getShortRateText() . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span><label>' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</label></span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr1">
											<span class="lbl_price">' . $core->get_Lang('Only from') . '</span>
											<span class="size15 color_666 line_through">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span>
										</div>
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->getShortRateText() . $clsISO->formatPrice($pricePromotion) . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span class="size15 color_666 line_through">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span> <span><label>' . $clsISO->getShortRate() . $clsISO->formatPrice($pricePromotion) . '</label></span>';
                        } else {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr1">
											<span class="lbl_price">' . $core->get_Lang('Only from') . '</span>
										</div>
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price) . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span><label>' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</label></span>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                    vnSessionDelVar('cruise_itinerary_contact_id');
                    vnSessionDelVar('hotel_contact_id');
                    vnSessionDelVar('tour_contact_id');
                    vnSessionSetVar('cruise_contact_id', $pvalTable);
                    return '<a class="linkContact" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
                } else if ($type == 'list') {
                    return '<a class="linkContact price_cruise" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
                }
            }
        }
    }
    function getLTripPriceNew($pvalTable = 0, $now_month = '', $type = 'detail')
    {
        global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID, $now_day;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1");
        if (!empty($lstSeason)) {
            $season = 'high';
        } else {
            $season = 'low';
        }
        $Sql_Promotion = $sql = "SELECT p.promot FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE pi.is_online = 1 and p.is_online = 1 and p.type = 'Cruise' and pi.taget_id =$pvalTable and pi.cruise_intinerary=0 and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";;
        $promotion = $dbconn->GetOne($Sql_Promotion);
        $cruise = $this->getOne($pvalTable);
        if ($cruise['cruise_type'] == 2) {
            $config_price_overnight = !empty($cruise['config_price_overnight'])
                ? json_decode($cruise['config_price_overnight'], true) : [];
            $groupPrices = $config_price_overnight['prices'];
            $price = 0;
            foreach ($groupPrices as $itinerary) {
                if (!empty($itinerary)) {
                    foreach ($itinerary as $capacityId => $capacity) {
                        if (!empty($capacity[$season]['carbin'])) {
                            if ($capacity[$season]['carbin'] < $price || $price == 0) {
                                $price = $capacity[$season]['carbin'];
                            }
                        }
                        if (!empty($capacity[$season]['person'])) {
                            foreach ($capacity[$season]['person'] as $num_person => $unitPrice) {
                                $unitPrice = $unitPrice / $num_person;
                                if ($unitPrice < $price || $price == 0) {
                                    $price = $unitPrice;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_id='$pvalTable' and season ='$season'";
            $price = $dbconn->GetOne($SQL);
        }
        #
        $discount = $clsISO->getPromotion($pvalTable, 'Cruise', $now_day, $now_day, 'info_promotion');
        if ($discount) {
            $promotion = $discount['discount_value'];
            if ($discount['discount_type'] == 2) {
                $pricePromotion = $price - ($promotion * $price / 100);
            } else {
                $pricePromotion = $price - $discount['discount_value'];
            }
        }
        if ($type == 'Value') {
            return $price;
        } elseif ($type == 'Valuelist') {
            if ($_LANG_ID == 'vn') {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span>';
            } else {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span>';
            }
        } elseif ($type == 'Valuedetail') {
            if ($_LANG_ID == 'vn') {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span>';
            } else {
                return '<span class="block text_right size20"><span class="block size13">' . $core->get_Lang('From') . '</span> ' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span>';
            }
        } else {
            if ($price > 0) {
                if ($type == 'list') {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span>' . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($pricePromotion) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($price) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label>/' . $core->get_Lang("person") . '</span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price) . '<span class="unit_price">' . '</span>' . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($pricePromotion) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="price_cruise">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price) . '<span class="unit_price">' . '</span></label></span>';
                        }
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr1">
											<span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span>
										</div>
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->formatPrice($pricePromotion) . $clsISO->getShortRateText() . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span class="size15 color_666 line_through">' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</span> <span><label>' . $clsISO->formatPrice($pricePromotion) . $clsISO->getShortRate() . '</label></span>';
                        } else {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->formatPrice($price) . $clsISO->getShortRateText() . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span><label>' . $clsISO->formatPrice($price) . $clsISO->getShortRate() . '</label></span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr1">
											<span class="size15 color_666 line_through">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span>
										</div>
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->getShortRateText() . $clsISO->formatPrice($pricePromotion) . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span class="size15 color_666 line_through">' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</span> <span><label>' . $clsISO->getShortRate() . $clsISO->formatPrice($pricePromotion) . '</label></span>';
                        } else {
                            return '<div class="box_price_cruise">
										<div class="box_price_cruise_gr2">
											<span class="unit_price">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price) . '</span>
											<p class="txt_person hidden mb0"> ' . $core->get_Lang('Per traveler') . '</p>
										</div>
									</div>';
                            return '<span><label>' . $clsISO->getShortRate() . $clsISO->formatPrice($price) . '</label></span>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                    vnSessionDelVar('cruise_itinerary_contact_id');
                    vnSessionDelVar('hotel_contact_id');
                    vnSessionDelVar('tour_contact_id');
                    vnSessionSetVar('cruise_contact_id', $pvalTable);
                    //                    return '<p class="txt_numb_red" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </p>';
                } else if ($type == 'list') {
                    return '<a class="linkContact price_cruise" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
                }
            }
        }
    }
    function getPriceCruiseList($pvalTable = 0, $now_month = '', $type = 'detail')
    {
        global $core, $dbconn, $clsISO, $clsConfiguration, $_LANG_ID, $now_day;
        $clsPromotion = new Promotion();
        $clsCruiseSeasonPrice = new CruiseSeasonPrice();
        $clsCruiseProperty = new CruiseProperty();
        $clsPromotionItem = new PromotionItem();
        $lstSeason = $clsConfiguration->getAll("setting='high_season_month' and value like '%" . $now_month . "%' limit 0,1", $clsConfiguration->pkey);
        if (!empty($lstSeason)) {
            $season = 'high';
        } else {
            $season = 'low';
        }
        $discount = $clsISO->getPromotion($pvalTable, 'Cruise', $now_day, $now_day, 'info_promotion');
        $sql2 = "cruise_id='$pvalTable' and cruise_cabin_id NOT IN (SELECT cruise_cabin_id FROM default_cruise_cabin WHERE is_trash= 0 and is_online=1 and cruise_id='$pvalTable')";
        //return $sql2;
        $clsCruiseSeasonPrice->deleteByCond($sql2);
        $SQL = "SELECT MIN(price) FROM " . DB_PREFIX . "cruise_season_price WHERE price > 0 and cruise_id='$pvalTable' and season ='$season'";
        #
        $price = $dbconn->GetOne($SQL);
        $sql_cabin = "SELECT cruise_cabin_id,group_size_id FROM " . DB_PREFIX . "cruise_season_price WHERE price = '$price' and cruise_id='$pvalTable' and season ='$season'";
        $cabin = $dbconn->GetAll($sql_cabin);
        $cruise_cabin_id = $cabin[0]['cruise_cabin_id'] ?? 0;
        $group_size_id = $cabin[0]['group_size_id'] ?? 0;
        $number_adult = $clsCruiseProperty->getNumberAdult($group_size_id);
        $price_cabin = $price * $number_adult;
        $promotion = $discount['discount_value'] ?? 0;
        if (isset($discount['discount_type']) && $discount['discount_type'] == 2) {
            $pricePromotion = $price - ($promotion * $price / 100);
            $price_cabin_promotion = $price_cabin - ($promotion * $price_cabin / 100);
        } else {
            $pricePromotion = $price - $promotion;
            $price_cabin_promotion = $price_cabin - $promotion;
        }
        //        return $Sql_Promotion;
        if ($type == 'Value') {
            return $price_cabin;
        } elseif ($type == 'Valuelist') {
            if ($_LANG_ID == 'vn') {
                return '<span>' . $core->get_Lang('From') . '</span> <span><label>' . $clsISO->formatPrice($price_cabin) . $clsISO->getShortRate() . '</label></span>';
            } else {
                return '<span>' . $core->get_Lang('From') . '</span> <span><label>' . $clsISO->getShortRate() . $clsISO->formatPrice($price_cabin) . '</label></span>';
            }
        } elseif ($type == 'Valuedetail') {
            if ($_LANG_ID == 'vn') {
                return '<span><label class="color_fb1111">' . $clsISO->formatPrice($price_cabin) . $clsISO->getShortRate() . '</label></span>';
            } else {
                return '<span><label class="color_fb1111">' . $clsISO->getShortRate() . $clsISO->formatPrice($price_cabin) . '</label></span>';
            }
        } else {
            if ($price > 0) {
                if ($type == 'list') {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . $clsISO->formatPrice($price_cabin) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span>' . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($price_cabin_promotion) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($price_cabin) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label></span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span class="size15 color_666 line_through">' . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span>' . $clsISO->formatPrice($price_cabin) . '</span> <span><label class="price_cruise">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price_cabin_promotion) . '</label>';
                        } else {
                            return '<span>' . $core->get_Lang('Only from') . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($price_cabin) . '<span class="unit_price">' . $clsISO->getShortRateText() . '</span></label></span>';
                        }
                    }
                } else {
                    if ($_LANG_ID == 'vn') {
                        if ($promotion > 0) {
                            return '<span class="size15 color_666 line_through">' . $clsISO->formatPrice($price_cabin) . $clsISO->getShortRateText() . '</span> <span><label class="price_cruise">' . $clsISO->formatPrice($price_cabin_promotion) . $clsISO->getShortRate() . '</label></span>';
                        } else {
                            return '<span><label class="price_cruise">' . $clsISO->formatPrice($price_cabin) . $clsISO->getShortRate() . '</label></span>';
                        }
                    } else {
                        if ($promotion > 0) {
                            return '<span class="size15 color_666 line_through">' . $clsISO->getShortRateText() . $clsISO->formatPrice($price_cabin) . '</span> <span><label class="price_cruise">' . $clsISO->getShortRate() . $clsISO->formatPrice($price_cabin_promotion) . '</label></span>';
                        } else {
                            return '<span><label class="price_cruise">' . $clsISO->getShortRate() . $clsISO->formatPrice($price_cabin) . '</label></span>';
                        }
                    }
                }
            } else {
                if ($type == 'detail') {
                    vnSessionDelVar('cruise_itinerary_contact_id');
                    vnSessionDelVar('hotel_contact_id');
                    vnSessionDelVar('tour_contact_id');
                    vnSessionSetVar('cruise_contact_id', $pvalTable);
                    return '<a class="linkContact" href="' . $clsISO->getLink('contact') . '" title="' . $core->get_Lang('Contact') . '">' . $core->get_Lang('Contact') . ' </a>';
                } else {
                }
            }
        }
    }
    function getMinStartDatePromotionProID($cruise_id = 0)
    {
        global $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $Sql_Promotion = $sql = "SELECT p.promotion_id FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and p.is_online = 1 and p.type = 'Cruise' and pi.taget_id =$cruise_id and pi.cruise_intinerary=0 and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        return $promotion;
    }
    function getCheckMemSet($cruise_id = 0)
    {
        global $dbconn;
        $clsPromotion = new Promotion();
        $clsPromotionItem = new PromotionItem();
        $Sql_Promotion = $sql = "SELECT p.promotion_id FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and p.is_online = 1 and p.type = 'Cruise' and pi.taget_id =$cruise_id and pi.cruise_intinerary=0 and " . time() . " between  p.start_date and p.end_date order by start_date ASC limit 0,1";
        $promotion = $dbconn->GetOne($Sql_Promotion);
        $check_mem = $clsPromotion->getCheckMem($promotion);
        //		$lst = $clsPromotion->getAll("target_id = '$tour_id' and ".time()." between  start_date and end_date and is_online=1 and type='TOUR' order by start_date asc limit 0,1");
        return $check_mem;
    }
    function getListTag($cruise_id = 0)
    {
        global $_LANG_ID;
        #
        $clsTag = new Tag;
        #
        $list_tag_id = $this->getOneField('list_tag_id', $cruise_id);
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
    function getCatName($pvalTable = 0)
    {
        $clsCruiseCat = new CruiseCat();
        $oneTable = $this->getOne($pvalTable, "cruise_cat_id");
        return $clsCruiseCat->getTitle($oneTable['cruise_cat_id']);
    }
    function getStatistic($pvalTable = 0, $is_fix = '')
    {
        switch ($is_fix) {
            case '1':
                return 'Super - <span style="color:#1e74a5">9.5</span> of <span style="color:#1e74a5">83</span> reviews';
                break;
            case '2':
                return 'Review Score: <span style="color:#1e74a5">9.3</span> of <span style="color:#1e74a5">171</span> reviews - Super';
                break;
            default:
                return 'Super <span style="color:#1e74a5">9,5</span> - Score from <span style="color:#1e74a5">90</span> Traveller reviews';
        }
    }
    function getLCityAround2($cruise_id = 0, $is_image = false, $has_link = true, $char = " → ")
    {
        global $core, $dbconn, $_LANG_ID;
        $clsCity = new City;
        $clsCruiseDestination = new CruiseDestination;
        #
        $html = '';
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id='$cruise_id' order by order_no asc");
        if (is_array($rsllist) && count($rsllist) > 0) {
            if ($is_image) {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $city_title = $clsCity->getTitle($rsllist[$i]['city_id']);
                    if ($city_title != '') {
                        $html .= ($i == 0 ? '' : ' <img class="arrow" src="' . URL_IMAGES . '/arrow.png" /> ') . ($has_link ? '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $city_title . '">' . $city_title . '</a>' : $city_title);
                    }
                }
                unset($rsllist);
            } else {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $city_title = $clsCity->getTitle($rsllist[$i]['city_id']);
                    if ($city_title != '') {
                        $html .= ($i == 0 ? '' : $char) . ($has_link ? '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $city_title . '">' . $city_title . '</a>' : $city_title);
                    }
                }
                unset($rsllist);
            }
        }
        return $html;
    }
    function getLCityAround($cruise_id = 0, $is_image = false)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsCruiseDestination = new CruiseDestination;
        $html = '';
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id='$cruise_id' order by order_no asc");
        if (is_array($rsllist) && count($rsllist) > 0) {
            if ($is_image) {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $html .= ($i == 0 ? '' : ' <img class="arrow" src="' . URL_IMAGES . '/arrow.png" /> ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                }
                unset($rsllist);
            } else {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $html .= ($i == 0 ? '' : ' → ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                }
                unset($rsllist);
            }
        }
        return $html;
    }
    function getCityAround($cruise_id = 0, $is_image = false)
    {
        global $_LANG_ID, $dbconn;
        $clsCity = new City;
        $clsCruiseDestination = new CruiseDestination;
        $html = '';
        $rsllist = $dbconn->GetAll("SELECT t1.city_id FROM " . $clsCruiseDestination->tbl . " t1 
		WHERE t1.is_trash=0 and t1.city_id>0 and t1.cruise_id='$cruise_id' and EXISTS (SELECT NULL FROM " . DB_PREFIX . "city t2 WHERE t1.city_id=t2.city_id) order by t1.order_no asc");
        if (is_array($rsllist) && count($rsllist) > 0) {
            if ($is_image) {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $_title = trim($clsCity->getTitle($rsllist[$i]['city_id']));
                    $html .= ($i == 0 ? '' : ' <img class="arrow" src="' . URL_IMAGES . '/arrow.png" /> ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $_title . '">' . $_title . '</a>';
                }
            } else {
                for ($i = 0; $i < count($rsllist); $i++) {
                    $_title = trim($clsCity->getTitle($rsllist[$i]['city_id']));
                    $html .= ($i == 0 ? '' : ', ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $_title . '">' . $_title . '</a>';
                }
            }
            unset($rsllist);
        }
        return $html;
    }
    function getStartCityAround($cruise_id = 0, $has_country = false, $has_link = true)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsCruiseDestination = new CruiseDestination;
        #
        $html = '';
        $field = "{$clsCruiseDestination->pkey},country_id,city_id";
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id='{$cruise_id}' order by order_no asc Limit 0,1", $field);
        if (!empty($rsllist)) {
            $city_name = $clsCity->getTitle($rsllist[0]['city_id']);
            $html .= ($has_link ? sprintf('<a class="h-city-around" href="%s" title="%s">%s</a>', $clsCity->getLink($rsllist[0]['city_id']), $city_name, $city_name) : $city_name);
            if ($has_country == true) {
                $clsCountry = new Country;
                $country_name = $clsCountry->getTitle($rsllist[0]['country_id']);
                $html .= ', ' . ($has_link ? sprintf('<a class="h-country-around" href="%s" title="%s">%s</a>', $clsCountry->getLink($rsllist[0]['country_id']), $country_name, $country_name) : $country_name);
            }
            unset($rsllist);
        }
        return $html;
    }
    function getEndCityAround($cruise_id = 0, $has_country = false, $has_link = true)
    {
        global $core, $dbconn, $_LANG_ID;
        $clsCity = new City;
        $clsCruiseDestination = new CruiseDestination;
        #
        $html = '';
        $field = "{$clsCruiseDestination->pkey},country_id,city_id";
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id='{$cruise_id}' order by order_no desc Limit 0,1");
        if (!empty($rsllist)) {
            $city_name = $clsCity->getTitle($rsllist[0]['city_id']);
            $html .= ($has_link ? sprintf('<a class="h-city-around" href="%s" title="%s">%s</a>', $clsCity->getLink($rsllist[0]['city_id']), $city_name, $city_name) : $city_name);
            if ($has_country == true) {
                $clsCountry = new Country;
                $country_name = $clsCountry->getTitle($rsllist[0]['country_id']);
                $html .= ', ' . ($has_link ? sprintf('<a class="h-country-around" href="%s" title="%s">%s</a>', $clsCountry->getLink($rsllist[0]['country_id']), $country_name, $country_name) : $country_name);
            }
            unset($rsllist);
        }
        return $html;
    }
    function getAllCityAround($cruise_id = 0, $is_image = false)
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsGuide = new Guide();
        $clsCruiseDestination = new CruiseDestination;
        $html = '';
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id='$cruise_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc", 'placetogo_id,city_id');
        if (is_array($rsllist) && count($rsllist) > 0) {
            if ($is_image) {
                for ($i = 0; $i < count($rsllist); $i++) {
                    if ($rsllist[$i]['placetogo_id'] > 0) {
                        $titleGuide = $clsGuide->getTitle($rsllist[$i]['placetogo_id']);
                        $html .= ($i == 0 ? '' : ', ') . '<a class="linkcity" target="_parent" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id']) . '" title="' . $titleGuide . '">' . $titleGuide . '</a>';
                    } else {
                        $titleCity = $clsCity->getTitle($rsllist[$i]['city_id']);
                        $html .= ($i == 0 ? '' : ' → ') . '<a class="link" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $titleCity . '">' . $titleCity . '</a>';
                    }
                }
                unset($rsllist);
            } else {
                for ($i = 0; $i < count($rsllist); $i++) {
                    if ($rsllist[$i]['placetogo_id'] > 0) {
                        $html .= ($i == 0 ? '' : ' - ') . $clsGuide->getTitle($rsllist[$i]['placetogo_id']);
                    } else {
                        $html .= ($i == 0 ? '' : ' - ') . $clsCity->getTitle($rsllist[$i]['city_id']);
                    }
                }
                unset($rsllist);
            }
        }
        return $html;
    }
    function getPCityAround($cruise_id = 0, $type = '')
    {
        global $_LANG_ID;
        $clsCity = new City;
        $clsGuide = new Guide();
        $clsCruiseDestination = new CruiseDestination;
        #
        $html = '';
        $rsllist = $clsCruiseDestination->getAll("is_trash=0 and cruise_id='$cruise_id' and city_id IN (SELECT city_id from " . DB_PREFIX . "city WHERE is_trash=0 and is_online=1) order by order_no asc");
        if (is_array($rsllist) && count($rsllist) > 0) {
            $html .= '<span class="item-route margin-top-5" data-toggle="tooltip" title="' . $this->getAllCityAround($cruise_id) . '">';
            for ($i = 0; $i < count($rsllist); $i++) {
                if ($rsllist[$i]['placetogo_id'] > 0) {
                    if ($i < 3) {
                        $html .= ($i == 0 ? '' : ' - ') . '<a class="link color_333" target="_blank" href="' . $clsGuide->getLink($rsllist[$i]['placetogo_id']) . '" title="' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '">' . $clsGuide->getTitle($rsllist[$i]['placetogo_id']) . '</a>';
                    }
                } else {
                    if ($i < 3) {
                        $html .= ($i == 0 ? '' : ' - ') . '<a class="link color_333" target="_blank" href="' . $clsCity->getLink($rsllist[$i]['city_id']) . '" title="' . $clsCity->getTitle($rsllist[$i]['city_id']) . '">' . $clsCity->getTitle($rsllist[$i]['city_id']) . '</a>';
                    }
                }
            }
            $html .= '...';
            $html .= '</span>';
            unset($rsllist);
        }
        return $html;
    }
    function getImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO;
        if (!isset($oneTable['image'])) {
            $oneTable = $this->getOne($pvalTable, "image");
        }
        $image = URL_IMAGES . '/noimage.png';
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            if ($w != 0 && $h != 0) {
                return $clsISO->tripslashImage($image, $w, $h);
            }
        }
        return $image;
    }
    function getUrlImage($pvalTable = 0)
    {
        global $clsISO;
        $oneTable = $this->getOne($pvalTable, "image");
        $url_image = $oneTable['image'];
        return $clsISO->tripslashUrl($url_image);
    }
    function getListCruiseStore($cruise_budget = 0, $type = '')
    {
        $res = $this->getAll("is_trash=0 and is_online=1 and listCruiseBudget like '%|" . $cruise_budget . "|%' and cruise_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise_store WHERE _type = '$type')");
        return !empty($res) ? $res : '';
    }
    function getListCruiseBudget($cruise_budget = 0)
    {
        $res = $this->getAll("is_trash=0 and is_online=1 and listCruiseBudget like '%|" . $cruise_budget . "|%'");
        return !empty($res) ? $res : '';
    }
    function getListCabin($cruise_id = 0, $limit = 0)
    {
        $clsCruiseCabin = new CruiseCabin();
        $SQL = "is_trash=0 and cruise_id = '$cruise_id' order by order_no desc";
        if ($limit != '' && $limit != '0') {
            $SQL .= " LIMIT 0,$limit";
        }
        $res = $clsCruiseCabin->getAll($SQL);
        return !empty($res) ? $res : '';
    }
    function getListCruiseCat($cruise_cat_id = 0, $limit = '')
    {
        $limit = (!empty($limit)) ? ' limit 0,' . $limit : '';
        $res = $this->getAll("is_trash=0 and is_online=1 and (cruise_cat_id = '$cruise_cat_id' or (list_cat_id like '%|" . $cruise_cat_id . "|%')) order by order_no desc" . $limit);
        return !empty($res) ? $res : '';
    }
    function getListCruiseCatMenu($cruise_cat_id = 0)
    {
        $res = $this->getAll("is_trash=0 and is_online=1 and (cruise_cat_id = '$cruise_cat_id' or (list_cat_id like '%|" . $cruise_cat_id . "|%')) order by order_no desc");
        return $res;
    }
    function getCruiseFa($pvalTable = 0, $type = '', $one = null)
    {
        global $clsISO;
        $clsCruiseProperty = new CruiseProperty();
        #
        $list_facilities = '';
        if ($type == 'RestFacilities') {
            if (!isset($one['listRestFa'])) {
                $list_facilities = $this->getOneField('listRestFa', $pvalTable);
            } else {
                $list_facilities = $one['listRestFa'];
            }
        } elseif ($type == 'CruiseFacilities') {
            if (!isset($one['listCruiseFacilities'])) {
                $list_facilities = $this->getOneField('listCruiseFacilities', $pvalTable);
            } else {
                $list_facilities = $one['listCruiseFacilities'];
            }
        } elseif ($type == 'CruiseFaActivities') {
            if (!isset($one['listCruiseFaActivities'])) {
                $list_facilities = $this->getOneField('listCruiseFaActivities', $pvalTable);
            } else {
                $list_facilities = $one['listCruiseFaActivities'];
            }
        } elseif ($type == 'CruiseServices') {
            if (!isset($one['listCruiseServices'])) {
                $list_facilities = $this->getOneField('listCruiseServices', $pvalTable);
            } else {
                $list_facilities = $one['listCruiseServices'];
            }
        }
        #
        //echo $list_facilities;die('xxxx');
        $list_Facilities = $clsCruiseProperty->getAll("is_trash=0 and type='$type' and cruise_property_id IN ($list_facilities) order by order_no asc", $clsCruiseProperty->pkey . ',image,title');
        return $list_Facilities;
        if (!empty($list_Facilities)) {
            $html .= '<ul>';
            for ($i = 0; $i < count($list_Facilities); $i++) {
                if ($list_Facilities[$i] != '') {
                    $html .= '<li>';
                    $html .= '' . $clsCruiseProperty->getTitle($list_Facilities[$i][$clsCruiseProperty->pkey]);
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }
    function checkExist($cruise_id = 0)
    {
        $res = $this->getAll("cruise_id='$cruise_id' limit 0,1", $this->pkey);
        return (!empty($res)) ? 1 : 0;
    }
    function getNotePrice($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return html_entity_decode($one['note_price']);
    }
    function updateCruiseJustBook($cruise_id = 0)
    {
        #
        $clsCruiseStore = new CruiseStore();
        if ($clsCruiseStore->countItem("cruise_id = '$cruise_id' and _type = 'BEST'") == 0) {
            $fx = "$clsCruiseStore->pkey,cruise_id,_type,order_no";
            $vx = "'" . $clsCruiseStore->getMaxID() . "','" . $cruise_id . "','BEST','" . $clsCruiseStore->getMaxOrder('BEST') . "'";
            $clsCruiseStore->insertOne($fx, $vx);
        } else {
            $res = $clsCruiseStore->getAll("cruise_id = '$cruise_id' and _type = 'BEST' limit 0,1");
            $set = "order_no = '" . $clsCruiseStore->getMaxOrder('BEST') . "'";
            $clsCruiseStore->updateOne($res[0][$clsCruiseStore->pkey], $set);
        }
    }
    function doDelete($cruise_id = 0)
    {
        $clsDiscountItem = new DiscountItem();
        $clsDiscountItem->deleteByCond("item_id='$cruise_id' and clsTable ='Cruise'");
        // Delete Cruise Store
        $clsCruiseStore = new CruiseStore();
        $clsCruiseStore->deleteByCond("cruise_id='$cruise_id'");
        // Delete Cruise Cabin
        $clsCruiseCabin = new CruiseCabin();
        $clsCruiseCabin->deleteByCond("cruise_id='$cruise_id'");
        // Delete Cruise Image
        $clsCruiseImage = new CruiseImage();
        $clsCruiseImage->deleteByCond("table_id='$cruise_id'");
        // Delete Cruise Video
        $clsCruiseVideo = new CruiseVideo();
        $clsCruiseVideo->deleteByCond("table_id='$cruise_id'");
        // Delete Cruise Destination
        $clsCruiseDestination = new CruiseDestination();
        $clsCruiseDestination->deleteByCond("cruise_id='$cruise_id'");
        $clsCruiseSeasonPrice = new CruiseSeasonPrice();
        $clsCruiseSeasonPrice->deleteByCond("cruise_id='$cruise_id'");
        // Delete Cruise Itinerary
        $clsCruiseItinerary = new CruiseItinerary();
        $lstItinerary = $clsCruiseItinerary->getAll("cruise_id='$cruise_id'");
        if (is_array($lstItinerary) && count($lstItinerary) > 0) {
            for ($i = 0; $i < count($lstItinerary); $i++) {
                $clsCruiseItinerary->doDelete($lstItinerary[$i][$clsCruiseItinerary->pkey]);
            }
        }
        #
        $this->deleteOne($cruise_id);
        return 1;
    }
    function lstUtilities($cruise_id = 0)
    {
        global $clsISO;
        #
        $list = array();
        $clsCruiseProperty = new CruiseProperty();
        $cruise = $this->getOne($cruise_id, 'listCruiseFacilities, listCruiseFaActivities, listCruiseServices');
        $listCruiseFacilities = $clsISO->getArrayByTextSlash($cruise['listCruiseFacilities']);
        foreach ($listCruiseFacilities as $key => $item) {
            $utilities = $clsCruiseProperty->getOne($item, 'title, image');
            $list[] = $utilities;
        }
        // $listCruiseFaActivities = $clsISO->getArrayByTextSlash($cruise['listCruiseFaActivities']);
        // foreach ($listCruiseFaActivities as $key => $item) {
        // 	$utilities = $clsCruiseProperty->getOne($item, 'title, image');
        // 	$list[] = $utilities;
        // }
        // $listCruiseServices = $clsISO->getArrayByTextSlash($cruise['listCruiseServices']);
        // foreach ($listCruiseServices as $key => $item) {
        // 	$utilities = $clsCruiseProperty->getOne($item, 'title, image');
        // 	$list[] = $utilities;
        // }
        $return = array(
            'list' => $list,
            'count' => count($list),
        );
        return $return;
    }
    function generateDatePickerLanguage($type = "")
    {
        global $core, $clsISO;
        $rec = "";
        $data = [];
        switch ($type) {
            case "dayNamesMin":
                $data = [
                    $core->get_Lang("Sun"),
                    $core->get_Lang("Mon"),
                    $core->get_Lang("Tue"),
                    $core->get_Lang("Wed"),
                    $core->get_Lang("Thu"),
                    $core->get_Lang("Fri"),
                    $core->get_Lang("Sat"),
                ];
                break;
            case "monthNames":
                $data = $clsISO->getListMonth();
                break;
            case "dayNames":
                $selects = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                $data = array_map([$core, "get_Lang"], $selects);
                break;
        }
        foreach ($data as $v) {
            $rec .= "'$v', ";
        }
        return rtrim($rec, ', ');
    }
}
