<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

use Curl\Curl;


/**
 * Tính giá dịch vụ addon hoàn toàn ở server.
 * extra = 1: giá theo nhóm, chỉ cộng một lần khi số lượng > 0.
 * extra != 1: giá theo số lượng khách/dịch vụ.
 */
if (!function_exists('isoCalculateTourAddonPrice')) {
    function isoCalculateTourAddonPrice($tour_id, $number_addon)
    {
        $clsTour = new Tour();
        $clsAddOnService = new AddOnService();

        $tour_id = (int)$tour_id;
        $result = array(
            'items' => array(),
            'total_quantity' => 0,
            'total_price' => 0
        );

        if ($tour_id <= 0 || !is_array($number_addon)) {
            return $result;
        }

        $list_service = (string)$clsTour->getListService($tour_id);
        $allowed_ids = array();

        foreach (preg_split('/[,|\\/]+/', $list_service, -1, PREG_SPLIT_NO_EMPTY) as $service_id) {
            $service_id = (int)$service_id;
            if ($service_id > 0) {
                $allowed_ids[$service_id] = true;
            }
        }

        foreach ($number_addon as $addonservice_id => $quantity) {
            $addonservice_id = (int)$addonservice_id;
            $quantity = max(0, (int)$quantity);

            if (
                $addonservice_id <= 0
                || $quantity <= 0
                || !isset($allowed_ids[$addonservice_id])
            ) {
                continue;
            }

            $addon = $clsAddOnService->getOne(
                $addonservice_id,
                $clsAddOnService->pkey . ',title,price,extra,is_trash,is_online'
            );

            if (
                !is_array($addon)
                || empty($addon[$clsAddOnService->pkey])
                || (int)($addon['is_trash'] ?? 1) !== 0
                || (int)($addon['is_online'] ?? 0) !== 1
            ) {
                continue;
            }

            $unit_price = (float)$clsAddOnService->getStrPrice($addonservice_id);
            $extra = (int)($addon['extra'] ?? 0);
            $line_total = ($extra === 1)
                ? $unit_price
                : $unit_price * $quantity;

            $result['items'][$addonservice_id] = array(
                'addonservice_id' => $addonservice_id,
                'title' => (string)($addon['title'] ?? ''),
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'extra' => $extra,
                'line_total' => $line_total
            );

            $result['total_quantity'] += $quantity;
            $result['total_price'] += $line_total;
        }

        return $result;
    }
}

function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y')
{
    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
    while ($current <= $last) {
        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }
    return $dates;
}
function default_detaildeparture2024()
{
    if ($_SERVER['REMOTE_ADDR'] == '124.158.4.43') {
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', '1');
        // error_reporting(E_ALL & ~E_STRICT);
    }
    global $assign_list, $clsISO, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $tour_id, $adult_type_id, $child_type_id, $infant_type_id, $age_type_id, $height_type_id, $clsISO, $package_id, $extLang, $now_day, $is_agent;
    global $oneItem;
    #
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;
    #Danh sách file css xử dụng cho trang home
    Asset::css([
        "{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.css?v={$v_cache}",
        "{$URL_JS}/fotorama-4.6.4/fotorama.css?v={$v_cache}",
        "{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.css?v={$upd_version}",
        "{$URL_CSS}/2024_tour_detail.css?v={$upd_version}"
    ]);
    Asset::js([
        "{$URL_JS}/fancybox-3.5.7/jquery.fancybox.min.js?v={$v_cache}",
        "{$URL_JS}/fotorama-4.6.4/fotorama.js?v={$v_cache}",
        "{$URL_LIBRARY}/swiper-11.1.15/swiper-bundle.min.js?v={$v_cache}",
        "{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}",
        "{$URL_JS}/jquery.sharer.js?v={$upd_version}",
        "{$URL_JS}/jquery.form.js?ver={$upd_version}",
        "{$URL_JS}/reviewstar/starwarsjs.js?v={$upd_version}",
        "{$URL_JS}/review/review.js?v={$upd_version}",
        "{$URL_JS}/jquery.countdown.min.js?v={$upd_version}",
        "{$URL_JS}/jquery-confirm.min.js?v={$upd_version}",
        "{$URL_JS}/jquery.tourdetail.js?v={$upd_version}"
    ]);
    #
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsPromotionItem = new PromotionItem();
    $assign_list["clsPromotionItem"] = $clsPromotionItem;
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsTourItinerary = new TourItinerary();
    $assign_list['clsTourItinerary'] = $clsTourItinerary;
    $clsTourImage = new TourImage();
    $assign_list["clsTourImage"] = $clsTourImage;
    $clsTourDestination = new TourDestination();
    $assign_list["clsTourDestination"] = $clsTourDestination;
    $clsTourStartDate = new TourStartDate();
    $assign_list['clsTourStartDate'] = $clsTourStartDate;
    $clsTourImage = new TourImage();
    $assign_list["clsTourImage"] = $clsTourImage;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsTourExtension = new TourExtension();
    $assign_list["clsTourExtension"] = $clsTourExtension;
    $clsTransport = new Transport();
    $assign_list["clsTransport"] = $clsTransport;
    $clsWhy = new Why();
    $assign_list["clsWhy"] = $clsWhy;
    $clsActivities = new Activities();
    $assign_list["clsActivities"] = $clsActivities;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsTable = 'Tour';
    $assign_list["clsTable"] = $clsTable;
    $clsTourStartDate = new TourStartDate();
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    #
    $clsTourDestination = new TourDestination();
    $assign_list['clsTourDestination'] = $clsTourDestination;
    $clsContinent = new Continent();
    $assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    #
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    #
    $tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : 0;
    $tour_start_date_id = isset($_GET['tour_start_date_id']) ? $_GET['tour_start_date_id'] : 0;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    $clsTourFaq = new TourFaq();
    $lstFaq = $clsTourFaq->getAll("tour_id=" . $tour_id . " ORDER BY order_no ASC LIMIT 3");
    $htmlFaq = '';
    if (!empty($lstFaq)) {
        $i = 0;
        foreach ($lstFaq as $item) {
            $i++;
            $title = html_entity_decode($item['title']);
            $content   = html_entity_decode($item['content']);
            $htmlFaq .= '
					<div class="faq-item">
							<div class="faq-item1">	<i class="fa-regular fa-circle-question" ></i>	</div>
							<div class="faq-item2">
								<h3 class="accordion-header">' . $title . '</h3>
									<p>' . $content . '</p></div>
							</div>';
        }
    }
    $assign_list['_FaqHtml'] = $htmlFaq;
    $totalFaq = $clsTourFaq->countItem("tour_id='$tour_id'");
    $assign_list['totalFaq'] = $totalFaq;
    $allFaq = $clsTourFaq->getAll("tour_id='$tour_id' ORDER BY order_no ASC");
    $assign_list['allFaq'] = $allFaq;
    $oneItem = $clsTour->getOne($tour_id);
    if (empty($oneItem) || $oneItem['is_online'] == 0) {
        header('location:' . DOMAIN_NAME . $extLang);
        exit();
    } elseif ($slug != $oneItem['slug']) { //Xử lý 301 khi sai slug tour
        $link = $clsTour->getLink($tour_id, $oneItem);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $link");
        exit;
    }
    $table_id = $tour_id;
    $tourcat_id = $oneItem['cat_id'];
    #
    $assign_list["tour_id"] = $tour_id;
    $assign_list["table_id"] = $table_id;
    $assign_list["oneItem"] = $oneItem;
    $assign_list["tourcat_id"] = $tourcat_id;
    //Xử lý danh sách tour đã xem
    $post_id = intval($tour_id);
    if (isset($_COOKIE['recent_view_tour'])) {
        $recent_view_tour = json_decode($_COOKIE['recent_view_tour'], true);
    } else {
        $recent_view_tour = array();
    }
    if (!in_array($post_id, $recent_view_tour)) {
        $recent_view_tour[] = $post_id;
    }
    setcookie('recent_view_tour', json_encode($recent_view_tour), time() + (86400), "/");
    //End Xử lý danh sách tour đã xem
    $getKeyInfo = $oneItem['key_information'];
    $assign_list["getKeyInfo"] = $getKeyInfo;
    $departure_point_id = $oneItem['departure_point_id'];
    $assign_list["departure_point_id"] = $departure_point_id;
    $lstImage = array();

    $sql = "
	SELECT tour_image_id, image, title
	FROM default_tour_image
	WHERE is_trash=0
	AND table_id='" . (int)$tour_id . "'
	AND image<>''
	ORDER BY order_no ASC
";

    $lstImage = $dbconn->GetAll($sql);



    $assign_list['lstImage'] = $lstImage;
    $lstActivities = [];
    if ($clsISO->getCheckActiveModulePackage($package_id, 'property', 'activities', 'default')) {
        $lstActivitiesID = $clsTour->getListActivities($tour_id, $oneItem);
        $lstActivities = $clsActivities->getAll("is_trash=0 and is_online=1 and activities_id IN($lstActivitiesID) order by order_no asc", $clsActivities->pkey);
    }
    $assign_list["lstActivities"] = $lstActivities;
    unset($lstActivities);
    #- Custom Field
    $clsTourCustomField = new TourCustomField();
    $assign_list["clsTourCustomField"] = $clsTourCustomField;
    $listCustomField = $clsTourCustomField->getAll("tour_id='$tour_id' and fieldtype='CUSTOM' order by order_no ASC", 'fieldvalue,fieldname');
    $assign_list["listCustomField"] = $listCustomField;
    unset($listCustomField);
    #
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsTourHotel = new TourHotel();
    $assign_list['clsTourHotel'] = $clsTourHotel;
    #
    $lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc", $clsTourProperty->pkey);
    $assign_list["lstNationality"] = $lstNationality;
    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc", $clsTourProperty->pkey);
    $assign_list["lstVisitorType"] = $lstVisitorType;
    #
    $lstAdultSizeGroup = $oneItem['adult_group_size'];
    $lstAdultSize = array();
    if ($lstAdultSizeGroup != '' && $lstAdultSizeGroup != '0') {
        $TMP = explode(',', $lstAdultSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstAdultSize)) {
                $lstAdultSize[] = $TMP[$i];
            }
        }
    }
    $lastAdultSize = end($lstAdultSize);
    #
    $max_adult = $clsTourOption->getOneField('number_to', $lastAdultSize);
    $max_adult ? $max_adult : 1;
    $assign_list["max_adult"] = $max_adult;
    #
    $lstChildSizeGroup = $oneItem['child_group_size'];
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = $clsISO->getArrayByTextSlash($lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    #
    $max_child = $clsTourOption->getAll('tour_option_id IN (' . implode(',', $lstChildSize) . ')', "max(number_to) as max");
    $max_child = (isset($max_child[0])) ? $max_child[0]['max'] : 0;
    $assign_list["max_child"] = $max_child;
    // var_dump($max_child);
    #
    $lstInfantSizeGroup = $oneItem['infant_group_size'];
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        //        $TMP = explode(',',$lstInfantSizeGroup);
        $TMP = $clsISO->getArrayByTextSlash($lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    #
    $max_infant = $clsTourOption->getAll('tour_option_id IN (' . implode(',', $lstInfantSize) . ')', "max(number_to) as max");
    $max_infant = (isset($max_infant[0])) ? $max_infant[0]['max'] : 0;
    $assign_list["max_infant"] = $max_infant;
    #
    $is_last_hour = $tour_start_date = 0;
    $lstTourStartDate = $list_start_date = [];
    $date_coutdown = '';
    if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'store', 'default', 'REVQQVJUVVJFLVZpZXRJU08=')) {
        $checkExistTourStartDate = $clsTourStore->checkExist($tour_id, 'DEPARTURE');
        if (!empty($checkExistTourStartDate)) {
            $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_active=1 and start_date >= '" . time() . "' and close_sell_date >= '" . time() . "' and tour_id ='$tour_id' and is_last_hour=1  order by start_date ASC", $clsTourStartDate->pkey);
            $is_last_hour = !empty($lstTourStartDate) ? 1 : 0;
            #
            $date_coutdown = array();
            if (!empty($lstTourStartDate)) {
                foreach ($lstTourStartDate as $k => $v) {
                    $getStrCloseSellDateCountDown = $clsTourStartDate->getStrCloseSellDateCountDown($v[$clsTourStartDate->pkey]);
                    $getCloseSellDateCountDown = $clsTourStartDate->getCloseSellDateCountDown($v[$clsTourStartDate->pkey], 'date_coutdown');
                    if ($getStrCloseSellDateCountDown > time()) {
                        $date_coutdown[] = $getCloseSellDateCountDown;
                    }
                }
            }
            $date_coutdown = array_shift($date_coutdown);
            $list_start_date = $clsTourStartDate->getListStartDateTour($tour_id);
            $tour_start_date = (count($list_start_date) > 0) ? 1 : 0;
        }
    }
    $assign_list["is_last_hour"] = $is_last_hour;
    $assign_list["lstTourStartDate"] = $lstTourStartDate;
    $assign_list["date_coutdown"] = $date_coutdown;
    $assign_list["tour_start_date"] = $tour_start_date;
    #
    $first_start_date = reset($list_start_date);
    $str_first_start_date = $first_start_date;
    $first_start_date1 = $first_start_date ? $first_start_date : date('m/d/Y', time() + (24 * 60 * 60));
    $first_start_date = str_replace('-', '/', $first_start_date);
    #
    $str_first_start_date = strtotime($str_first_start_date);
    $str_first_start_date = !empty($first_start_date) ? $str_first_start_date : time() + (24 * 60 * 60);
    $list_start_date = implode("','", $list_start_date);
    $list_start_date = str_replace('-', '/', $list_start_date);
    $check_tour_start_date = $list_start_date ? 1 : 0;
    #
    if ($tour_start_date_id > 0) {
        $str_first_start_date = $clsTourStartDate->getStartDate($tour_start_date_id);
    }
    $assign_list["str_first_start_date"] = $str_first_start_date;
    $assign_list["first_start_date"] = $first_start_date;
    $assign_list["list_start_date"] = $list_start_date;
    $assign_list["check_tour_start_date"] = $check_tour_start_date;
    if (!empty($first_start_date)) {
        $now_next_departure = 0;
    } else {
        $now_next_departure = time() + (24 * 60 * 60);
        $now_next_departure = $clsISO->converTimeToText5($now_next_departure);
    }
    $assign_list["now_next_departure"] = $now_next_departure;
    #Itinerary Destination
    list($start_tour, $end_tour) = $clsTourDestination->getStartEndTourDestination($tour_id);
    $assign_list["start_destination"] = $start_tour;
    $assign_list["end_destination"] = $end_tour;
    #
    if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'itinerary', 'customize')) {
        #- Itinerary
        $limit = "";
        if ($oneItem['duration_type'] != 1) {
            $number_day = $oneItem['number_day'];
            $number_night = $oneItem['number_night'];
            if ($number_day > $number_night) {
                $limit = " limit 0," . $number_day;
            } elseif ($number_day == $number_night) {
                $limit = " limit 0," . ($number_day + 1);
            } else {
                $limit = " limit 0," . $number_night;
            }
        }
        $lstItineraryTour = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' and title_contingency='' order by order_no asc " . $limit, $clsTourItinerary->pkey . ',image,content,tour_itinerary_id,transport,is_show_image,day,day2,tour_id,title,meals');
        $assign_list['lstItineraryTour'] = $lstItineraryTour;
        $list_itinerary = [];
        foreach ($lstItineraryTour as $k => $v) {
            $list_itinerary[$v[$clsTourItinerary->pkey]] = strtotime($first_start_date1 . ' + ' . $k . ' day');
        }
        $assign_list["list_itinerary"] = $list_itinerary;
        unset($lstItineraryTour);
    }
    #
    #-- Recent tour
    $clsISO->setRecentView('tour', $tour_id);
    $arr_tour_recent = $clsISO->getRecentView('tour');
    $assign_list['arr_tour_recent'] = $arr_tour_recent;
    #-- Related tour
    $arr_tour_related = [];
    $lstTourExtension = $clsTourExtension->getAll("is_trash=0 and tour_1_id='$tour_id' and tour_2_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1) order by order_no asc", "tour_2_id");
    if (!empty($lstTourExtension)) {
        foreach ($lstTourExtension as $item) {
            $oneTmp = $clsTour->getOne($item['tour_2_id'], $clsTour->pkey);
            if ($tour_id != $item['tour_2_id'])
                $arr_tour_related[] = $oneTmp;
        }
    }
    $assign_list['arr_tour_related'] = $arr_tour_related;
    #
    if (isset($_POST['BookingTour']) && $_POST['BookingTour'] == 'BookingTour') {
        $tour_id_post = isset($_POST['tour_id_z'])
            ? (int)$_POST['tour_id_z']
            : (int)$tour_id;

        if ($tour_id_post <= 0) {
            die('_INVALID_TOUR');
        }

        /*
         * Giá tour gốc được tạo bởi default_loadTablePrice().
         * Addon tuyệt đối không lấy giá từ HTML/JavaScript mà đọc lại database.
         */
        $base_total = isset($_POST['total_price_z'])
            ? max(0, (float)$_POST['total_price_z'])
            : 0;

        $deposit_percent = isset($_POST['deposit'])
            ? max(0, min(100, (float)$_POST['deposit']))
            : 0;

        $number_addon = isset($_POST['number_addon']) && is_array($_POST['number_addon'])
            ? $_POST['number_addon']
            : array();

        $addon_price = isoCalculateTourAddonPrice(
            $tour_id_post,
            $number_addon
        );

        $total_addon_price = (float)$addon_price['total_price'];
        $grand_total = $base_total + $total_addon_price;
        $price_deposit = $grand_total * $deposit_percent / 100;

        $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
        if (!is_array($cartSessionService)) {
            $cartSessionService = array();
        }
        if (!isset($cartSessionService[$_LANG_ID]) || !is_array($cartSessionService[$_LANG_ID])) {
            $cartSessionService[$_LANG_ID] = array();
        }

        $booking_item = array();

        /*
         * Giữ các trường cũ để tương thích Cart/Checkout hiện tại,
         * nhưng ghi đè toàn bộ giá addon, grand total và deposit bằng kết quả server.
         */
        foreach ($_POST as $k => $v) {
            if ($k === 'number_addon') {
                continue;
            }

            if ($k === 'str_price_child') {
                $decoded = html_entity_decode((string)$v, ENT_QUOTES, 'UTF-8');
                $value = @unserialize($decoded, array('allowed_classes' => false));
                $booking_item['arr_price_child'] = is_array($value) ? $value : array();
                continue;
            }

            if ($k === 'str_price_infant') {
                $decoded = html_entity_decode((string)$v, ENT_QUOTES, 'UTF-8');
                $value = @unserialize($decoded, array('allowed_classes' => false));
                $booking_item['arr_price_infant'] = is_array($value) ? $value : array();
                continue;
            }

            if ($k === 'parent_id') {
                $parent_id_post = (int)$v;
                $booking_item['parent_id'] = $parent_id_post;
                if ($parent_id_post > 0) {
                    $booking_item['arr_tour_parent'] = $clsTour->getOne(
                        $parent_id_post,
                        "$clsTour->pkey,slug,title,image"
                    );
                }
                continue;
            }

            if (!is_array($v)) {
                $booking_item[$k] = $v;
            }
        }

        $clean_number_addon = array();
        foreach ($addon_price['items'] as $addonservice_id => $addon_item) {
            $clean_number_addon[(int)$addonservice_id] = (int)$addon_item['quantity'];
        }

        $booking_item['tour_id_z'] = $tour_id_post;
        $booking_item['base_total_price_z'] = $base_total;
        $booking_item['number_addon'] = $clean_number_addon;
        $booking_item['addon_items'] = $addon_price['items'];
        $booking_item['total_addon'] = (int)$addon_price['total_quantity'];
        $booking_item['total_addon_price'] = $total_addon_price;
        $booking_item['total_price_z'] = $grand_total;
        $booking_item['deposit'] = $deposit_percent;
        $booking_item['price_deposit'] = $price_deposit;
        $booking_item['price_remaining'] = max(0, $grand_total - $price_deposit);

        $cartSessionService[$_LANG_ID][$tour_id_post] = $booking_item;
        vnSessionSetVar('BookingTour_' . $_LANG_ID, $cartSessionService);

        header('location:' . $clsISO->getLink('cart'));
        exit();
    }

    if (isset($_POST['ContactTour']) && $_POST['ContactTour'] == 'ContactTour') {
        vnSessionDelVar('ContactTour');
        vnSessionDelVar('ContactCruise');
        vnSessionDelVar('ContactHotel');
        vnSessionDelVar('ContactVoucher');
        #
        foreach ($_POST as $k => $v) {
            $cartSessionService = $v;
        }
        #
        $str_price_child = $_POST['str_price_child'];
        $str_price_child = html_entity_decode($str_price_child);
        $str_price_child = unserialize($str_price_child);
        $_POST['arr_price_child'] = $str_price_child;
        #
        $str_price_infant = $_POST['str_price_infant'];
        $str_price_infant = html_entity_decode($str_price_infant);
        $str_price_infant = unserialize($str_price_infant);
        $_POST['arr_price_infant'] = $str_price_infant;
        unset($_POST['str_price_child'], $_POST['str_price_infant']);
        #
        vnSessionSetVar('ContactTour', $_POST);
        #
        $link = $clsISO->getLink('contact');
        header('location:' . $link);
        exit();
    }
    # Package
    $listPackage = $clsTour->getAll("parent_id=$tour_id and is_package_online=1 order by order_no", "tour_id, title");
    $assign_list['listPackage'] = $listPackage;
    // lấy package có giá nhỏ nhất
    $tour_package = $clsTour->getPackageMinPrice($tour_id);
    $assign_list["tour_package"] = $tour_package;
    #
    /*=============Title & Description Page==================*/
    $title_page = $oneItem['title'] . ' | ' . $core->get_Lang('tours') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $clsISO->getMetaDescription($tour_id, 'Tour', $oneItem);
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page = $clsISO->getPageImageShare($tour_id, 'Tour', $oneItem);
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    $clsTour->updateMinPriceTour($tour_id);
}
function default_ajGetMaxChildInfant()
{
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $adult, $child, $infant;
    global $clsISO, $clsConfiguration, $profile_id, $loggedIn, $agent_id, $adult_type_id, $child_type_id, $infant_type_id, $is_agent, $package_id, $now_day;
    $clsTourOption = new TourOption();
    $clsTour = new Tour();
    $clsSettingChildPolicy = new SettingChildPolicy();
    $tour_id = (int)Input::post('tour_id', 0);
    $number_adults = (int)Input::post('number_adults', 0);
    $tour_property_id = (int)Input::post('tour_property_id', 0);
    $oneItem = $clsTour->getOne($tour_id, 'adult_group_size');
    $assign_list["oneItem"] = $oneItem;
    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = $clsISO->getArrayByTextSlash($lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child_1 = $clsTourOption->getOneField('number_to', $lastChildSize);
    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = $clsISO->getArrayByTextSlash($lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant_1 = $clsTourOption->getOneField('number_to', $lastInfantSize);
    $tour_option = $clsTourOption->getAll("is_trash=0 AND tour_property_id = '" . $tour_property_id . "' AND type='SIZEGROUP' AND tour_option_id IN (" . $oneItem['adult_group_size'] . ") AND " . $number_adults . " BETWEEN number_from AND number_to LIMIT 0,1", $clsTourOption->pkey);
    $max_child = $max_infant = 0;
    if ($tour_option) {
        $max_child = $clsSettingChildPolicy->getNumberChild($tour_option[0][$clsTourOption->pkey], $number_adults);
        $max_infant = $clsSettingChildPolicy->getNumberInfant($tour_option[0][$clsTourOption->pkey], $number_adults);
    }
    $max_child = $max_child > $max_child_1 ? $max_child_1 : $max_child;
    $max_infant = $max_infant > $max_infant_1 ? $max_infant_1 : $max_infant;
    $data = [
        'max_child' => $max_child,
        'max_infant' => $max_infant,
    ];
    echo json_encode($data);
    die;
}
function default_loadTablePrice()
{
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act;
    global $_LANG_ID, $title_page, $description_page, $keyword_page;
    global $clsISO, $clsConfiguration, $profile_id, $loggedIn, $agent_id;
    global $adult_type_id, $child_type_id, $infant_type_id, $is_agent;
    global $package_id, $now_day;
    global $adult, $child, $infant;

    /* =========================================================
     * INIT CLASS
     * ========================================================= */

    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;

    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;

    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;

    $clsTourService = new TourService();
    $assign_list["clsTourService"] = $clsTourService;

    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;

    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;

    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;

    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;

    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;

    $clsVoucher = new Voucher();
    $assign_list['clsVoucher'] = $clsVoucher;

    $clsPromotion = new Promotion();
    $assign_list['clsPromotionr'] = $clsPromotion;

    $clsTourPriceGroup = new TourPriceGroup();
    $assign_list['clsTourPriceGroup'] = $clsTourPriceGroup;

    $clsTourOption = new TourOption();
    $assign_list['clsTourOption'] = $clsTourOption;


    /* =========================================================
     * POST DATA
     * ========================================================= */

    $tour_id = isset($_POST['tour_id'])
        ? (int)$_POST['tour_id']
        : 0;

    $is_last_hour = isset($_POST['is_last_hour'])
        ? (int)$_POST['is_last_hour']
        : 0;

    $tour_start_date = isset($_POST['tour_start_date'])
        && !is_array($_POST['tour_start_date'])
        ? trim((string)$_POST['tour_start_date'])
        : '';

    $number_adults = isset($_POST['number_adults'])
        ? max(1, (int)$_POST['number_adults'])
        : 1;

    $number_child = isset($_POST['number_child'])
        ? max(0, (int)$_POST['number_child'])
        : 0;

    $number_infants = isset($_POST['number_infants'])
        ? max(0, (int)$_POST['number_infants'])
        : 0;

    $number_pick_travellers =
        $number_adults +
        $number_child +
        $number_infants;

    $check_in_book = isset($_POST['check_in_book'])
        && !is_array($_POST['check_in_book'])
        ? trim((string)$_POST['check_in_book'])
        : '';

    $tour_visitor_adult_id = isset($_POST['tour_visitor_adult_id'])
        ? (int)$_POST['tour_visitor_adult_id']
        : 0;

    $tour_visitor_child_id = isset($_POST['tour_visitor_child_id'])
        ? (int)$_POST['tour_visitor_child_id']
        : 0;

    $tour_visitor_infant_id = isset($_POST['tour_visitor_infant_id'])
        ? (int)$_POST['tour_visitor_infant_id']
        : 0;

    $check_in_book = str_replace('/', '-', $check_in_book);

    $str_check_in_book = 0;
    $promotion = 0;
    $discount_type = 0;

    $price_adults = 0;
    $price_child = 0;
    $price_infants = 0;

    $total_price_child = 0;
    $total_price_infants = 0;

    $arr_price_child = [];
    $arr_price_infant = [];

    $check_contact = 0;
    $check_contact_child = 0;
    $check_contact_infant = 0;

    $title_seat = '';
    $exceeded_seat = 0;

    $lstTourStartDate = [];


    /* =========================================================
     * TOUR PARENT
     * ========================================================= */

    $parent_id = $clsTour->getOneField(
        "parent_id",
        $tour_id
    );

    $has_parent_id = $parent_id ? 1 : 0;


    /* =========================================================
     * DEPARTURE DATE
     * ========================================================= */

    $str_check_in_book = strtotime($check_in_book);

    /*
     * Trường hợp có biến $first_start_date từ code cũ.
     * Nếu biến này chưa được khai báo ở scope hiện tại thì
     * tránh notice bằng cách kiểm tra isset().
     */
    if (!empty($first_start_date)) {
        $now_next_departure = 0;
    } else {
        $now_next_departure = isset($_POST['departure_date'])
            && !is_array($_POST['departure_date'])
            ? trim((string)$_POST['departure_date'])
            : '';
    }


    $day_of_week = '';
    $date_formatted = '';
    $end_day_of_week = '';
    $end_date_formatted = '';

    if ($now_next_departure !== 0 && !empty($now_next_departure)) {

        $date_parts = explode(', ', $now_next_departure);

        $day_of_week = isset($date_parts[0])
            ? trim($date_parts[0])
            : '';

        $date_part = isset($date_parts[1])
            ? trim($date_parts[1])
            : '';

        $date_obj = !empty($date_part)
            ? DateTime::createFromFormat('d/m/Y', $date_part)
            : false;

        if ($date_obj instanceof DateTime) {

            if ($_LANG_ID == 'vn') {

                $day = $date_obj->format('d');
                $month = $date_obj->format('m');
                $year = $date_obj->format('Y');

                $date_formatted =
                    "$day th$month, $year";
            } else {

                $date_formatted =
                    $date_obj->format('d M, Y');
            }


            /* =============================================
             * RETURN DATE
             * ============================================= */

            $getDayTour = $clsTour->getDay($tour_id);

            $assign_list["getDayTour"] = $getDayTour;

            if (!empty($getDayTour)) {

                preg_match(
                    '/(\d+)/',
                    $getDayTour,
                    $matches
                );

                $number_of_days =
                    isset($matches[1])
                    ? (int)$matches[1]
                    : 0;

                if ($number_of_days > 0) {

                    $return_date_obj = clone $date_obj;

                    $return_date_obj->modify(
                        "+$number_of_days days"
                    );

                    $end_day_of_week =
                        $clsISO->converTimeToText5(
                            $return_date_obj->getTimestamp()
                        );

                    $end_day_of_week =
                        explode(', ', $end_day_of_week)[0];

                    if ($_LANG_ID == 'vn') {

                        $end_day =
                            $return_date_obj->format('d');

                        $end_month =
                            $return_date_obj->format('m');

                        $end_year =
                            $return_date_obj->format('Y');

                        $end_date_formatted =
                            "$end_day th$end_month, $end_year";
                    } else {

                        $end_date_formatted =
                            $return_date_obj->format('d M, Y');
                    }
                }
            }
        }
    }


    $assign_list["now_next_departure_day"] =
        $day_of_week;

    $assign_list["now_next_departure_date"] =
        $date_formatted;

    $assign_list["now_next_end_day"] =
        $end_day_of_week;

    $assign_list["now_next_end_date"] =
        $end_date_formatted;


    /* =========================================================
     * PROMOTION
     * ========================================================= */

    if (_IS_PROMOTION == 1) {

        $discount = $clsISO->getPromotion(
            $tour_id,
            'Tour',
            $now_day,
            $str_check_in_book,
            $type_check = 'get_more_info'
        );

        $promotion =
            isset($discount['discount_value'])
            ? $discount['discount_value']
            : 0;

        $discount_type =
            isset($discount['discount_type'])
            ? $discount['discount_type']
            : 0;

        $promotion =
            !empty($promotion)
            ? $promotion
            : 0;

        $promotion =
            str_replace(
                '.',
                '',
                (string)$promotion
            );
    }


    /* =========================================================
     * DEPOSIT / DEPARTURE
     * ========================================================= */

    $deposit = 0;
    $checkExistTourStartDate = 0;

    if (_IS_DEPARTURE == 1) {

        $str_check_in_book =
            strtotime($check_in_book);

        $checkExistTourStartDate =
            $clsTourStore->checkExist(
                $tour_id,
                'DEPARTURE'
            );

        $str_check_in_book =
            !empty($checkExistTourStartDate)
            ? $str_check_in_book
            : 0;


        /* =============================================
         * LAST HOUR
         * ============================================= */

        $listTourStartDateClose =
            $clsTourStartDate->getAll(
                "is_trash=0
                and is_active=1
                and tour_id='$tour_id'
                and start_date='$str_check_in_book'
                and open_sale_date <= '$now_day'
                and close_sale_date < '$now_day'
                and is_last_hour=1
                order by start_date ASC"
            );

        $list_tour_start_date_id = [];

        if (!empty($listTourStartDateClose)) {

            foreach (
                $listTourStartDateClose
                as $value
            ) {

                $list_tour_start_date_id[] =
                    $value['tour_start_date_id'];
            }

            $list_tour_start_date_id =
                implode(
                    ',',
                    $list_tour_start_date_id
                );
        }


        $condd =
            "is_trash=0 AND is_active=1";

        if (!empty($list_tour_start_date_id)) {

            $condd .=
                " and tour_start_date_id NOT IN
                ($list_tour_start_date_id)";
        }

        $condd .=
            " and '$str_check_in_book'
            BETWEEN start_date AND end_date
            and tour_id='$tour_id'
            order by start_date ASC
            limit 0,1";


        if (!empty($checkExistTourStartDate)) {

            if (
                !empty($checkExistTourStartDate)
                && !empty($tour_start_date)
            ) {

                $lstTourStartDate =
                    $clsTourStartDate->getAll(
                        $condd
                    );
            }

            $checkExistTourStartDate =
                !empty($lstTourStartDate)
                ? 1
                : 0;


            if (!empty($lstTourStartDate)) {

                $seat_available =
                    $lstTourStartDate[0]['allotment'];

                $deposit =
                    $lstTourStartDate[0]['deposit'];


                if (
                    $seat_available != ''
                    && $number_pick_travellers >
                    $seat_available
                ) {

                    $exceeded_seat = 1;
                } else {

                    $exceeded_seat = 0;
                }


                if ($seat_available == 1) {

                    $seat =
                        $core->get_Lang('seat');
                } else {

                    $seat =
                        $core->get_Lang('seats');
                }


                if (
                    $seat_available == ''
                    || !empty($seat_available)
                ) {

                    if ($seat_available == '') {

                        $title_seat =
                            $core->get_Lang(
                                'Still enough spaces left for you'
                            );
                    } else {

                        $title_seat =
                            $core->get_Lang('Empty')
                            . ' '
                            . $seat_available
                            . ' '
                            . $seat;
                    }
                } else {

                    $title_seat =
                        $seat =
                        $core->get_Lang('Full');
                }
            } else {

                $title_seat = '';
            }
        } else {

            $deposit =
                $clsTour->getDeposit($tour_id);
        }
    } else {

        $deposit =
            $clsTour->getDeposit($tour_id);
    }


    $assign_list["title_seat"] =
        $title_seat;

    $assign_list["exceeded_seat"] =
        $exceeded_seat;


    /* =========================================================
     * SERVICES
     * ========================================================= */

    if (
        $clsISO->getCheckActiveModulePackage(
            $package_id,
            'property',
            'service',
            'default'
        )
    ) {

        $lstServiceID =
            $clsTour->getListService($tour_id);

        $lstService =
            $clsAddOnService->getAll(
                "is_trash=0
                and is_online=1
                and addonservice_id IN($lstServiceID)
                order by order_no asc",
                $clsAddOnService->pkey
            );

        $assign_list["lstService"] =
            $lstService;
    }


    /* =========================================================
     * TOUR OPTION
     * ========================================================= */

    $lstTourOption =
        $clsTour->getOneField(
            'tour_option',
            $tour_id
        );

    $lstOption = [];

    if (
        $lstTourOption != ''
        && $lstTourOption != '0'
    ) {

        $TMP =
            explode(',', $lstTourOption);

        for (
            $i = 0;
            $i < count($TMP);
            $i++
        ) {

            $option_status =
                $clsTourOption->getStatus(
                    $TMP[$i]
                );

            if (
                $option_status == 1
                && !in_array(
                    $TMP[$i],
                    $lstOption
                )
            ) {

                $lstOption[] =
                    $TMP[$i];
            }
        }
    }


    $tour_class_id =
        isset($_POST['tour__class_check'])
        ? (int)$_POST['tour__class_check']
        : 0;

    if (
        !$tour_class_id
        && !empty($lstOption)
    ) {

        $tour_class_id =
            $lstOption[0];
    }


    /* =========================================================
     * NUMBER GROUP
     * ========================================================= */

    $tour_number_adults_id =
        $clsTourPriceGroup->getTourNumberGroup(
            $tour_visitor_adult_id,
            $number_adults,
            $tour_id
        );

    $tour_number_child_id =
        $clsTourPriceGroup->getTourNumberGroup(
            $tour_visitor_child_id,
            $number_child,
            $tour_id
        );

    $tour_number_infants_id =
        $clsTourPriceGroup->getTourNumberGroup(
            $tour_visitor_infant_id,
            $number_infants,
            $tour_id
        );


    /* =========================================================
     * VISITOR CONFIG
     *
     * Từ đây adult / child / infant được đưa về
     * cùng một cấu trúc dữ liệu.
     * ========================================================= */

    $oneTour =
        $clsTour->getOne(
            $tour_id,
            'visitorage_child,
             visitorheight_child,
             visitorage_infant,
             visitorheight_infant'
        );


    $visitorConfig = [

        'adult' => [
            'visitor_id' =>
            $tour_visitor_adult_id,

            'number' =>
            $number_adults,

            'number_group_id' =>
            $tour_number_adults_id,

            'type' => '',

            'items' => [],

            'price' => 0,

            'total_price' => 0,

            'arr_price' => [],

            'check_contact' => 0
        ],

        'child' => [
            'visitor_id' =>
            $tour_visitor_child_id,

            'number' =>
            $number_child,

            'number_group_id' =>
            $tour_number_child_id,

            'type' => '',

            'items' => [],

            'price' => 0,

            'total_price' => 0,

            'arr_price' => [],

            'check_contact' => 0
        ],

        'infant' => [
            'visitor_id' =>
            $tour_visitor_infant_id,

            'number' =>
            $number_infants,

            'number_group_id' =>
            $tour_number_infants_id,

            'type' => '',

            'items' => [],

            'price' => 0,

            'total_price' => 0,

            'arr_price' => [],

            'check_contact' => 0
        ]
    ];


    /* =========================================================
     * CHILD AGE / HEIGHT
     * ========================================================= */

    if (
        !empty($oneTour['visitorage_child'])
    ) {

        $visitorConfig['child']['type'] =
            'AGE';

        $visitorConfig['child']['items'] =
            Input::post(
                "visitorAge_child",
                []
            );
    } elseif (
        !empty($oneTour['visitorheight_child'])
    ) {

        $visitorConfig['child']['type'] =
            'HEIGHT';

        $visitorConfig['child']['items'] =
            Input::post(
                "visitorHeight_child",
                []
            );
    }


    /* =========================================================
     * INFANT AGE / HEIGHT
     * ========================================================= */

    if (
        !empty($oneTour['visitorage_infant'])
    ) {

        $visitorConfig['infant']['type'] =
            'AGE';

        $visitorConfig['infant']['items'] =
            Input::post(
                "visitorAge_infant",
                []
            );
    } elseif (
        !empty($oneTour['visitorheight_infant'])
    ) {

        $visitorConfig['infant']['type'] =
            'HEIGHT';

        $visitorConfig['infant']['items'] =
            Input::post(
                "visitorHeight_infant",
                []
            );
    }


    /* =========================================================
     * PRICE DATA
     * ========================================================= */

    $price = [];
    $price_type_rate = [];

    $departure_price_type = null;


    if (
        !empty($checkExistTourStartDate)
        && !empty($lstTourStartDate)
    ) {

        $departure_price_type =
            (int)$lstTourStartDate[0]['price_type'];
    }


    /* =========================================================
     * GET ADULT BASE PRICE
     *
     * Adult luôn là giá gốc để tính % cho child/infant.
     * ========================================================= */

    if (
        !empty($checkExistTourStartDate)
        && !empty($lstTourStartDate)
        && $departure_price_type == 1
    ) {

        /*
         * Giá được set trực tiếp trong Departure Date
         */

        $price =
            json_decode(
                $lstTourStartDate[0]['price'],
                true
            );

        $price_type_rate =
            json_decode(
                $lstTourStartDate[0]['price_type_rate'],
                true
            );


        $price_adults = 0;

        if (
            isset(
                $price[$tour_visitor_adult_id][$tour_class_id][$tour_number_adults_id]
            )
        ) {

            $price_adults =
                (float)$price[$tour_visitor_adult_id][$tour_class_id][$tour_number_adults_id];
        }
    } else {

        /*
         * Không set giá trong Departure Date
         * => lấy từ bảng giá
         */

        $price_adults =
            $clsTourPriceGroup->getPriceBooking(
                $tour_id,
                $tour_class_id,
                $tour_number_adults_id,
                $tour_visitor_adult_id,
                0
            );

        $price_adults =
            (float)$price_adults;
    }


    /* =========================================================
     * COMMON PRICE CALCULATOR
     *
     * Child / Infant dùng chung logic với nhau.
     *
     * Adult là BASE PRICE.
     *
     * price_type = 0
     *     => giá tiền cố định
     *
     * price_type = 1
     *     => % của adult
     * ========================================================= */

    $calculatePrice = function (
        $visitor_type,
        $visitor_id,
        $number_group_id,
        $visitor_age_type,
        $visitor_height_type
    ) use (
        $tour_id,
        $tour_class_id,
        $price_adults,
        $price,
        $price_type_rate,
        $departure_price_type,
        $clsTourPriceGroup
    ) {

        /* =============================================
         * ADULT
         * ============================================= */

        if ($visitor_type == 'adult') {

            return [
                'price_value' =>
                $price_adults,

                'price_type' => 0,

                'price' =>
                max(0, $price_adults)
            ];
        }


        /* =============================================
         * CHILD / INFANT
         * ============================================= */

        $price_value = 0;
        $price_type = 0;


        /*
         * CASE 1:
         * Departure Date có giá riêng
         */

        if ($departure_price_type == 1) {

            if ($price_adults <= 0) {

                return [
                    'price_value' => 0,
                    'price_type' => 0,
                    'price' => 0
                ];
            }


            if (
                isset(
                    $price[$visitor_id][$tour_class_id][$visitor_age_type][$number_group_id]
                )
                && $visitor_age_type > 0
            ) {

                $price_value =
                    (float)$price[$visitor_id][$tour_class_id][$visitor_age_type][$number_group_id];

                $price_type =
                    isset(
                        $price_type_rate[$tour_class_id][$visitor_age_type][$number_group_id]
                    )
                    ? (int)$price_type_rate[$tour_class_id][$visitor_age_type][$number_group_id]
                    : 0;
            } elseif (
                isset(
                    $price[$visitor_id][$tour_class_id][$visitor_height_type][$number_group_id]
                )
                && $visitor_height_type > 0
            ) {

                $price_value =
                    (float)$price[$visitor_id][$tour_class_id][$visitor_height_type][$number_group_id];

                $price_type =
                    isset(
                        $price_type_rate[$tour_class_id][$visitor_height_type][$number_group_id]
                    )
                    ? (int)$price_type_rate[$tour_class_id][$visitor_height_type][$number_group_id]
                    : 0;
            }


            /*
         * CASE 2:
         * Không có giá riêng trong Departure Date
         */
        } else {

            if ($price_adults <= 0) {

                return [
                    'price_value' => 0,
                    'price_type' => 0,
                    'price' => 0
                ];
            }


            $list_price =
                $clsTourPriceGroup->getPriceBookingChildInfant(
                    $tour_id,
                    $tour_class_id,
                    $number_group_id,
                    $visitor_id,
                    $visitor_age_type,
                    $visitor_height_type,
                    0
                );


            if (
                is_array($list_price)
                && !empty($list_price)
            ) {

                $price_value =
                    isset($list_price['price'])
                    ? (float)$list_price['price']
                    : 0;

                $price_type =
                    isset($list_price['price_type'])
                    ? (int)$list_price['price_type']
                    : 0;
            }
        }


        /* =============================================
         * CALCULATE FINAL PRICE
         * ============================================= */

        if ($price_type == 0) {

            $final_price =
                $price_value;
        } else {

            $final_price =
                round(
                    $price_value *
                        $price_adults /
                        100
                );
        }


        $final_price =
            $final_price > 0
            ? $final_price
            : 0;


        return [
            'price_value' =>
            $price_value,

            'price_type' =>
            $price_type,

            'price' =>
            $final_price
        ];
    };


    /* =========================================================
     * PROCESS ALL VISITOR TYPES
     *
     * Đây là phần quan trọng:
     *
     * adult
     * child
     * infant
     *
     * đều chạy cùng một flow.
     * ========================================================= */

    foreach (
        ['adult', 'child', 'infant']
        as $visitor_type
    ) {

        $visitor_id =
            $visitorConfig[$visitor_type]['visitor_id'];

        $items =
            $visitorConfig[$visitor_type]['items'];

        /*
         * Adult không có age/height.
         * Chỉ xử lý một lần.
         */

        if ($visitor_type == 'adult') {

            $priceData =
                $calculatePrice(
                    'adult',
                    $visitor_id,
                    $visitorConfig['adult']['number_group_id'],
                    0,
                    0
                );


            $price_adults =
                $priceData['price'];

            $visitorConfig['adult']['price'] =
                $price_adults;

            $visitorConfig['adult']['total_price'] =
                $price_adults *
                $number_adults;

            continue;
        }


        /*
         * Child / Infant
         */

        if (empty($items)) {
            continue;
        }


        $items =
            array_count_values($items);


        foreach (
            $items as $key => $value
        ) {

            /*
             * Mỗi nhóm số lượng có thể có number_group
             * khác nhau.
             */

            $number_group_id =
                $clsTourPriceGroup->getTourNumberGroup(
                    $visitor_id,
                    $value,
                    $tour_id
                );


            /*
             * AGE / HEIGHT
             */

            if (
                $visitorConfig[$visitor_type]['type']
                == 'AGE'
            ) {

                $visitor_age_type =
                    (int)$key;

                $visitor_height_type =
                    0;
            } else {

                $visitor_age_type =
                    0;

                $visitor_height_type =
                    (int)$key;
            }


            /*
             * CALCULATE PRICE
             */

            $priceData =
                $calculatePrice(
                    $visitor_type,
                    $visitor_id,
                    $number_group_id,
                    $visitor_age_type,
                    $visitor_height_type
                );


            $unit_price =
                $priceData['price'];

            $total_price =
                $unit_price * $value;


            /*
             * TOTAL
             */

            $visitorConfig[$visitor_type]['total_price'] +=
                $total_price;


            /*
             * DETAIL
             */

            $visitorConfig[$visitor_type]['arr_price'][] = [

                'text' =>
                $clsTourOption->getTitle($key),

                'number' =>
                $value,

                'price' =>
                $unit_price,

                'total_price' =>
                $total_price
            ];


            /*
             * CONTACT PRICE
             */

            if ($unit_price <= 0) {

                $visitorConfig[$visitor_type]['check_contact'] =
                    1;

                $check_contact =
                    1;

                if ($visitor_type == 'child') {

                    $check_contact_child =
                        1;
                } elseif ($visitor_type == 'infant') {

                    $check_contact_infant =
                        1;
                }
            }
        }
    }


    /* =========================================================
     * ASSIGN PRICE VARIABLES
     * ========================================================= */

    $arr_price_child =
        $visitorConfig['child']['arr_price'];

    $arr_price_infant =
        $visitorConfig['infant']['arr_price'];

    $total_price_child =
        $visitorConfig['child']['total_price'];

    $total_price_infants =
        $visitorConfig['infant']['total_price'];


    /*
     * Nếu không có giá child/infant
     * vẫn giữ biến cũ cho template.
     */

    $price_child =
        !empty($arr_price_child)
        ? $arr_price_child[0]['price']
        : 0;

    $price_infants =
        !empty($arr_price_infant)
        ? $arr_price_infant[0]['price']
        : 0;


    /* =========================================================
     * DEPARTURE TYPE
     * ========================================================= */

    if (
        !empty($checkExistTourStartDate)
        && !empty($lstTourStartDate)
    ) {

        $departure_type =
            $lstTourStartDate[0]['departure_type'];


        if (
            !empty($departure_type)
            && (
                $departure_type == 1
                || $departure_type == 2
            )
        ) {

            $check_contact = 1;
        } elseif (
            !empty($departure_type)
            && $departure_type == 4
        ) {

            $listType =
                $clsTour->getListDepartureType();

            $departure_type_text =
                $listType[$departure_type];

            echo
            '<p class="iso_text_closed">'
                . $departure_type_text['title']
                . " - "
                . $departure_type_text['subtitle']
                . '</p>';

            die;
        }
    }


    /* =========================================================
     * TOTAL PRICE
     * ========================================================= */

    $total_price_adults =
        $price_adults *
        $number_adults;


    $total_price =
        $total_price_adults
        + $total_price_child
        + $total_price_infants;


    /* =========================================================
     * PROMOTION
     * ========================================================= */

    if ($discount_type == 2) {

        $price_promotion =
            $total_price /
            100 *
            $promotion;
    } else {

        $price_promotion =
            $promotion;
    }


    $total_price_promotion =
        $total_price -
        $price_promotion;


    /* =========================================================
     * DEPOSIT
     * ========================================================= */

    $price_deposit =
        $total_price_promotion /
        100 *
        $deposit;


    /* =========================================================
     * ASSIGN LIST
     * ========================================================= */

    $assign_list["lstOption"] =
        $lstOption;

    $assign_list["str_check_in_book"] =
        $str_check_in_book;

    $assign_list["check_contact"] =
        $check_contact;

    $assign_list["check_contact_child"] =
        $check_contact_child;

    $assign_list["check_contact_infant"] =
        $check_contact_infant;

    $assign_list["check_in_book"] =
        $check_in_book;

    $assign_list["is_last_hour"] =
        $is_last_hour;

    $assign_list["tour_id"] =
        $tour_id;

    $assign_list["tour_class_id"] =
        $tour_class_id;

    $assign_list["number_adults"] =
        $number_adults;

    $assign_list["number_child"] =
        $number_child;

    $assign_list["number_infants"] =
        $number_infants;

    $assign_list["price_adults"] =
        $price_adults;

    $assign_list["price_child"] =
        $price_child;

    $assign_list["arr_price_child"] =
        $arr_price_child;

    $assign_list["arr_price_infant"] =
        $arr_price_infant;

    $assign_list["str_price_child"] =
        serialize($arr_price_child);

    $assign_list["str_price_infant"] =
        serialize($arr_price_infant);

    $assign_list["price_infaints"] =
        $price_infants;

    /*
     * Giữ lại đúng key cũ của code bạn.
     */
    $assign_list["price_infantes"] =
        $price_infants;

    $assign_list["price_infants"] =
        $price_infants;

    $assign_list["total_price_adults"] =
        $total_price_adults;

    $assign_list["total_price_child"] =
        $total_price_child;

    $assign_list["total_price_infants"] =
        $total_price_infants;

    $assign_list["total_price"] =
        $total_price;

    $assign_list["promotion"] =
        $promotion;

    $assign_list["discount_type"] =
        $discount_type;

    $assign_list["price_promotion"] =
        $price_promotion;

    $assign_list["deposit"] =
        $deposit;

    $assign_list["price_deposit"] =
        $price_deposit;

    $assign_list["total_price_promotion"] =
        $total_price_promotion;

    $assign_list["has_parent_id"] =
        $has_parent_id;

    $assign_list["parent_id"] =
        $parent_id;


    /* =========================================================
     * BUILD TEMPLATE
     * ========================================================= */

    if (
        $clsISO->getCheckActiveModulePackage(
            $package_id,
            'booking',
            'booking_tour',
            'default'
        )
    ) {

        $html =
            $core->build(
                'loadTablePrice.tpl'
            );
    } else {

        $html =
            $core->build(
                'loadTableContactPrice.tpl'
            );
    }


    echo $html;

    die();
}
function default_ajCheckNumberGroup()
{
    global $assign_list, $clsISO, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $now_day, $child_type_id, $infant_type_id, $age_type_id, $height_type_id;
    $clsTourPriceGroup = new TourPriceGroup();
    $clsTourOption = new TourOption();
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $tour_property_id = Input::post('visitor_type', 0);
    $type_id = Input::post('type', 0);
    $number_group = Input::post('number_group', 0);
    $tour_id = Input::post('tour_id', 0);
    $visitor_group = Input::post('visitor_group', 0);
    $data = ['result' => false];
    if ($tour_property_id > 0 && $type_id > 0 && $number_group > 0 && $tour_id > 0 && $visitor_group > 0) {
        $cond_visitor_type = $cond_property_type = "";
        if ($type_id == $age_type_id) {
            $cond_visitor_type = " and tour_visitor_age_type_id='" . $visitor_group . "'";
        } elseif ($type_id == $height_type_id) {
            $cond_visitor_type = " and tour_visitor_height_type_id='" . $visitor_group . "'";
        }
        $lstOption = lstVisitorOption($tour_id);
        $txtOption = $lstOption[$visitor_group];
        $group_size = $clsTourOption->getAll("is_trash=0 and type='SIZEGROUP' and tour_property_id='" . $tour_property_id . "' and tour_property_age='0' AND tour_property_height='0' AND $clsTourOption->pkey IN ($txtOption) AND " . $number_group . " BETWEEN number_from AND number_to LIMIT 0,1", $clsTourOption->pkey . ',title');
        $group_size = ($group_size[0]) ? $group_size[0]['tour_option_id'] : 0;
        $check_price = $clsTourPriceGroup->getAll("tour_id='" . $tour_id . "' and tour_number_group_id='$group_size' and tour_visitor_type_id='" . $tour_property_id . "'" . $cond_visitor_type);
        if ($check_price) {
            $data = ['result' => true];
        }
    }
    echo json_encode($data);
}
function lstVisitorOption($tour_id)
{
    global $clsISO;
    $clsTour = new Tour();
    $oneTour = $clsTour->getOne($tour_id, 'visitorage_child, visitorage_infant, child_group_size, infant_group_size');
    $lst_visitorage_child = $clsISO->getArrayByTextSlashNew($oneTour['visitorage_child']);
    $lst_visitorage_infant = $clsISO->getArrayByTextSlashNew($oneTour['visitorage_infant']);
    $lst_child_group_size = $clsISO->getArrayByTextSlashNew($oneTour['child_group_size']);
    $lst_infant_group_size = $clsISO->getArrayByTextSlashNew($oneTour['infant_group_size']);
    $lstOption1 = renderVisitorOption($lst_visitorage_child, $lst_child_group_size);
    $lstOption2 = renderVisitorOption($lst_visitorage_infant, $lst_infant_group_size);
    $lstOption = $lstOption1 + $lstOption2;
    return $lstOption;
}
function renderVisitorOption($lstVisitor, $lstOption)
{
    $visitor_option = array();
    foreach ($lstVisitor as $key => $item) {
        $visitor_option[$item] = $lstOption[$key];
    }
    return $visitor_option;
}
function default_loadSelectAddon()
{
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(410);

    echo json_encode(array(
        'success' => false,
        'message' => 'Addon price is calculated when Book now is submitted.'
    ));
    die();
}


function default_loadTextDay()
{
    global $core, $mod, $act, $clsISO, $_LANG_ID, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id;
    $date = isset($_POST['date']) && !empty($_POST['date']) ? $_POST['date'] : '';
    $date = str_replace('/', '-', $date);
    $date = strtotime($date);
    $text_day = $clsISO->getDayOfWeek($date);
    echo $text_day . ', ' . date("d/m/Y", $date);
    die();
}
function default_loadTextDayItinerary()
{
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
    global $core, $mod, $act, $clsISO, $_LANG_ID;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourItinerary = new TourItinerary();
    $assign_list['clsTourItinerary'] = $clsTourItinerary;
    $date = isset($_POST['date']) && !empty($_POST['date']) ? $_POST['date'] : '';
    $tour_id = $_POST['tour_id'];
    $date = str_replace('/', '-', $date);
    //$date=strtotime($date);
    $text_day = $clsISO->getDayOfWeek($date);
    #- Itinerary
    $lstItineraryTour = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' and title_contingency='' order by order_no asc", $clsTourItinerary->pkey . ',image,content,tour_itinerary_id,transport,is_show_image,day,day2');
    $assign_list['lstItineraryTour'] = $lstItineraryTour;
    $list_itinerary = [];
    //var_dump($first_start_date1);die();
    foreach ($lstItineraryTour as $k => $v) {
        $list_itinerary[$v[$clsTourItinerary->pkey]] = $clsISO->converTimeToText5(strtotime($date . ' + ' . $k . ' day'));
    }
    echo json_encode(array(
        "list_itinerary" => $list_itinerary,
    ));
    die();
}
function default_contact()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page;
    global $clsISO, $_LANG_ID, $_lang, $extLang, $_frontIsLoggedin_user_id, $lstCountryEx;
    #
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;
    #Danh sách file css xử dụng cho trang home
    Asset::js([
        "{$URL_JS}/datepicker/jquery.date-dropdowns.js?v={$upd_version}",
        "{$URL_JS}/jquery.validate.js?ver={$upd_version}",
        "{$URL_JS}/jquery-confirm.min.js?ver={$upd_version}",
    ]);
    //print_r(base64_decode('bmNjb3JwQCMkdmlldGlzbzEyNw=='));die();
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsVoucher = new Voucher();
    $assign_list["clsVoucher"] = $clsVoucher;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsCruiseService = new CruiseService();
    $assign_list["clsCruiseService"] = $clsCruiseService;
    $clsFeedback = new Feedback();
    $assign_list['clsFeedback'] = $clsFeedback;
    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;
    #
    $assign_list["lstCountryRegion"] = $clsCountry->getAll("1=1 and is_trash=0 order by order_no ASC", $clsCountry->pkey . ",title");
    $clsTourOption = new TourOption();
    $assign_list['clsTourOption'] = $clsTourOption;
    $clsFAQ = new FAQ();
    $assign_list['clsFAQ'] = $clsFAQ;
    #
    $lstFaqs = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,4", $clsFAQ->pkey . ',title,content');
    $assign_list["lstFaqs"] = $lstFaqs;
    $cartSessionHotel = vnSessionGetVar('ContactHotel');
    $assign_list["cartSessionHotel"] = $cartSessionHotel;
    $cartSessionTour = vnSessionGetVar('ContactTour');
    $assign_list["cartSessionTour"] = $cartSessionTour;
    $cartSessionCruise = vnSessionGetVar('ContactCruise');
    $assign_list["cartSessionCruise"] = $cartSessionCruise;

    $cartSessionVoucher = vnSessionGetVar('ContactVoucher');
    $assign_list["cartSessionVoucher"] = $cartSessionVoucher;
    //	print_r($cartSessionVoucher);die();
    $array_bed = $cartSessionCruise['compare_price'] ?? [];
    $assign_list['array_bed'] = $array_bed;
    #
    if (!empty($_frontIsLoggedin_user_id)) {
        $clsMember = new Member();
        $assign_list['clsMember'] = $clsMember;
        $name = $clsMember->getFullName($_frontIsLoggedin_user_id);
        $assign_list['name'] = $name;
        $email = $clsMember->getEmail($_frontIsLoggedin_user_id);
        $assign_list['email'] = $email;
        $phone = $clsMember->getPhone($_frontIsLoggedin_user_id);
        $assign_list['phone'] = $phone;
        $country_id = $clsMember->getOneField('country_id', $_frontIsLoggedin_user_id);
        $assign_list['country_id'] = $country_id;
        $title = $clsMember->getOneField('title', $_frontIsLoggedin_user_id);
        $assign_list['title'] = $title;
    }
    #
    $errMsg = '';
    if (isset($_POST['plantrip']) && $_POST['plantrip'] == 'plantrip') {
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $city_id = $_POST['city_id'] ?? 0;
        $tour_id = $_POST['tour_id'] ?? 0;
        $cruise_id = $_POST['cruise_id'] ?? 0;
        $birthday = $_POST['birthday_contact'] ?? '';
        $birthday = str_replace('/', '-', $birthday) ?? '';
        $birthday = strtotime($birthday);
        // Kiểm tra spam content
        if ($clsISO->isSpamContent($_POST)) {
            //$errMsg = $core->get_Lang("Spam mail!");
            return false;
        }
        if (!$clsFeedback->checkRateLimit($_SERVER['REMOTE_ADDR'])) {
            //$errMsg = $core->get_Lang("Spam mail!");
            return false;
        }
        $clsAntiSpam = new AntiSpam();
        if (
            !$clsAntiSpam->validateCSRF($_POST['via_spam_csrf']) ||
            !$clsAntiSpam->checkFormTime($_POST['via_from_time']) ||
            !$clsAntiSpam->checkHoneypot($_POST['via_key']) ||
            !$clsAntiSpam->validateJSToken($_POST['via_js_token']) ||
            !$clsAntiSpam->validateSignature($_POST['via_signature'], $_POST['via_from_time']) ||
            !$clsAntiSpam->rateLimit(5)
        ) {
            $errMsg = $core->get_Lang("Spam mail!");
        }
        if (!empty($_POST['v_contact_k'])) {
            $errMsg .= $core->get_Lang('Spam') . ' <br />';
        } elseif (!$clsISO->verifyCsrfToken($_POST['v_contact_c'])) {
            $errMsg .= $core->get_Lang('Spam') . ' <br />';
        }
        #- Verify Captcha
        if (_ISOCMS_CAPTCHA == 'IMG') {
            $security_code = isset($_POST["security_code"]) ? trim($_POST["security_code"]) : '';
            $security_code = strtoupper($security_code);
            if ($security_code == '') {
                $errMsg .= '&bull; ' . $core->get_Lang('Please enter security code') . ' <br />';
            }
            if (!empty($security_code) && $security_code != $_SESSION['skey']) {
                $errMsg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        } else if (_ISOCMS_CAPTCHA == 'reCAPTCHA') {
            if (!$clsISO->checkGoogleReCAPTCHA()) {
                $errMsg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        }
        $hidden_field = isset($_POST['hidden_field']) ? $_POST['hidden_field'] : '';
        if ($hidden_field != '') {
            $errMsg .= $core->get_Lang('hidden field');
        }
        #
        if ($errMsg == '') {
            $feedback_id = $clsFeedback->getMaxId();
            $feedback_code = $clsFeedback->generateFeedBack($feedback_id);
            $current_date = date('m/d/Y');
            $current_time = strtotime($current_date);
            $target_id = !empty($tour_id) ? $tour_id : 0;
            if (!empty($cartSessionTour)) {
                $array_booking = array_merge($cartSessionTour, $_POST);
                $type = 'Tour';
            } elseif (!empty($cartSessionHotel)) {
                $array_booking = array_merge($cartSessionHotel, $_POST);
                $type = 'Hotel';
            } elseif (!empty($cartSessionCruise)) {
                $array_booking = array_merge($cartSessionCruise, $_POST);
                $type = 'Cruise';
            } elseif (!empty($cartSessionVoucher)) {
                $array_booking = array_merge($cartSessionVoucher, $_POST);
                $type = 'Voucher';
            } else {
                $array_booking = $_POST;
            }
            $address = !empty($_POST['address']) ? $_POST['address'] : '';
            #
            $fx = "feedback_id,target_id,feedback_code,title,fullname,birthday,email,phone,address,country_id,feedback_store,user_ip,reg_date,departure_date";
            $vx = "'$feedback_id'
			,'" . $target_id . "'
			,'$feedback_code'
			,'" . $_POST['title'] . "'
			,'$fullname'
			,'$birthday'
			,'$email'
			,'$phone'
			,'$address'
			,'" . $_POST['country_id'] . "'
			,'" . serialize($array_booking) . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . time() . "'
			,'" . $current_time . "'
			";
            if (!empty($type)) {
                $fx .= ",type";
                $vx .= ",'$type'";
            }
            #
            //print_r($fx.'<br>'.$vx);die();
            if ($clsFeedback->insertOne($fx, $vx)) {
                $clsFeedback->newBooking($feedback_id);
                vnSessionDelVar('ContactTour');
                vnSessionDelVar('ContactCruise');
                vnSessionDelVar('ContactHotel');
                if ($_LANG_ID == 'vn') {
                    header('location:' . $extLang . '/lien-he-thanh-cong/fb-' . $feedback_id . '.html');
                } else {
                    header('location:' . $extLang . '/contact-us-success/fb-' . $feedback_id . '.html');
                }
                exit();
            }
        } else {
            foreach ($_POST as $k => $v) {
                $assign_list[$k] = $v;
            }
            $assign_list["errMsg"] = $errMsg;
        }
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('contactus') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_deleteService()
{
    global $core, $mod, $act;
    $type = Input::post('type', '');
    if ($type == 'Hotel') {
        vnSessionDelVar('ContactHotel');
    } elseif ($type == 'Cruise') {
        vnSessionDelVar('ContactCruise');
    } else {
        vnSessionDelVar('ContactTour');
    }
    echo json_encode(array(
        'msg' => 'ok'
    ));
    die();
}
function default_contact2()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page;
    global $clsISO, $_LANG_ID, $_lang, $extLang, $_frontIsLoggedin_user_id, $lstCountryEx;
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsFeedback = new Feedback();
    $assign_list['clsFeedback'] = $clsFeedback;
    $clsTourOption = new TourOption();
    $assign_list['clsTourOption'] = $clsTourOption;
    $clsFAQ = new FAQ();
    $assign_list['clsFAQ'] = $clsFAQ;
    #
    $lstFaqs = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no asc limit 0,4", $clsFAQ->pkey);
    $assign_list["lstFaqs"] = $lstFaqs;
    $cartSessionService = vnSessionGetVar('ContactTour');
    $assign_list["cartSessionService"] = $cartSessionService;
    #
    $errMsg = '';
    if (isset($_POST['plantrip']) && $_POST['plantrip'] == 'plantrip') {
        $Comments = Input::post('Comments');
        print_r(nl2br($Comments));
        die();
        $valid = false;
        $postfields = array();
        $list_fields = array('package_id', 'first_name', 'last_name', 'phone', 'email', 'company_name', 'messager');
        foreach ($list_fields as $field) {
            ${$field} = $_POST[$field];
            $postfields[$field] = trim($_POST[$field]);
            if (isset($_POST[$field]) && !empty($_POST[$field])) {
                $valid = true;
            }
        }
        $msg = '_error';
        $return_url = '_nolink';
        // Submit
        if ($valid == true) {
            $msg = '_error';
            $curl = new Curl();
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
            $curl->post('https://okrs.vietiso.com/api/potentials/try-isocms', $postfields);
            //print_r($curl); die();
            if (!$curl->error) {
                $response = toArray($curl->response);
                if (isset($response['result']) && $response['result'] == 'success') {
                    $msg = '_success';
                    $return_url = DOMAIN_URL . '/thankyou/' . $response['code'] . '.html';
                } else {
                    $msg = '_invalid';
                }
            }
        }
        // Return
        echo json_encode(array(
            'msg' => $msg,
            'return_url' => $return_url
        ));
        die();
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('contactus') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_loadReview()
{
    global $assign_list, $_CONFIG, $core, $mod, $act, $title_page, $description_page, $keyword_page, $clsISO, $_lang, $extLang, $_LANG_ID, $clsISO;
    #
    $page = isset($_POST['page_Review']) ? $_POST['page_Review'] : 0;
    $tour_id = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;
    if ($page > 0 and $tour_id > 0) {
        $pageview = $page + 1;
        $limit_start = $page * 5;
        $limit_end = $pageview * 5 + 1;
        $cond = "is_trash=0 and is_online=1 and table_id = '$tour_id' order by order_no DESC limit $limit_start , $limit_end ";
        $clsTour_Review = new TourReview();
        $arraylstReview = $clsTour_Review->getAll($cond, $clsTour_Review->pkey . ' , review_date');
        if ($clsTour_Review->countItem($cond) < 5) {
            $pageview = 'NoNo';
        }
        $Html = '';
        if (!empty($arraylstReview)) {
            $stt = 0;
            foreach ($arraylstReview as $lstReview) {
                if ($stt++ < 6) {
                    $Html .= '<li class="item">
		  <div class="block-rate-num text-center">
			  <label class="rate-number text-normal">
			  ' . $clsTour_Review->getRates($lstReview[$clsTour_Review->pkey]) . '</label>
			  <p class="cus-rate">
				  <strong class="block z_12">
				  ' . $clsTour_Review->getFullName($lstReview[$clsTour_Review->pkey]) . '
				  ,</strong>
				  <span class="z_10 block c6">
				  ' . $clsTour_Review->getCountry($lstReview[$clsTour_Review->pkey]) . '
				 ,</span>
				  <span class="z_10 block c6">
				  ' . $clsISO->converTimeToText($lstReview['review_date']) . '
				  </span>
			  </p>
		  </div>
		  <div class="cus-desc">
			  <h5 class="z_14 text-bold text-uppercase c2a">
			  ' . $clsTour_Review->getTitle($lstReview[$clsTour_Review->pkey]) . '</h5>
			  <div class="review-content">				
				  ' . html_entity_decode($clsTour_Review->getContent($lstReview[$clsTour_Review->pkey])) . '
			  </div>			                     
		  </div>
		  </li>';
                }
            }
        }
        echo $Html . '$$$' . $pageview;
        die();
    }
}
function default_bookgroup_2020()
{
    vnSessionDelVar('rq_link');
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $adult, $child, $infant;
    global $clsISO, $clsConfiguration, $profile_id, $loggedIn, $agent_id, $adult_type_id, $child_type_id, $infant_type_id;
    #
    if (_ISOCMS_CLIENT_LOGIN == '2') {
        if (!$loggedIn) {
            $link = $extLang . '/account/signin/r=' . $_SERVER['REQUEST_URI'];
            header('Location:' . $link);
            exit();
        }
    }
    #
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourService = new TourService();
    $assign_list["clsTourService"] = $clsTourService;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsCountryBK = new _Country();
    $assign_list["clsCountryBK"] = $clsCountryBK;
    $lstCountry = $clsCountryBK->getAll("is_trash=0 order by order_no asc", $clsCountryBK->pkey);
    $assign_list["lstCountry"] = $lstCountry;
    unset($lstCountry);
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;
    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;
    $clsVoucher = new Voucher();
    $assign_list['clsVoucher'] = $clsVoucher;
    $clsPromotion = new Promotion();
    $assign_list['clsPromotionr'] = $clsPromotion;
    #
    $lstNationality = $clsTourProperty->getAll("is_trash=0 and type='NATIONALITY' order by order_no asc");
    $assign_list["lstNationality"] = $lstNationality;
    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc");
    $assign_list["lstVisitorType"] = $lstVisitorType;
    $listService = $clsTourService->getAll('is_trash=0 and is_online=1 order by order_no ASC');
    $assign_list["listService"] = $listService;
    //print_r(count($listService)); die();
    unset($listService);
    if ($_LANG_ID == 'vn') {
        $_EXCHANGE_RATE = 1;
    } else {
        $_EXCHANGE_RATE = $clsISO->getRateVCB('USD');
    }
    $assign_list["_EXCHANGE_RATE"] = $_EXCHANGE_RATE;
    #
    $show = isset($_GET['show']) ? $_GET['show'] : '';
    $assign_list['show'] = $show;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    $tour_id = $clsTour->getBySlug($slug);
    if (intval($tour_id) == 0) {
        redirect(PCMS_URL . $extLang);
    }
    $assign_list["tour_id"] = $tour_id;
    $oneItem = $clsTour->getOne($tour_id);
    $assign_list['oneItem'] = $oneItem;
    //print_r($oneItem); die();
    #list all Room and hotel Facilities
    $list_Service = $oneItem['list_service_id'];
    $lstTourService = array();
    if ($list_Service != '' && $list_Service != '0') {
        $list_Service = str_replace('||', '|', $list_Service);
        $list_Service = ltrim($list_Service, '|');
        $list_Service = rtrim($list_Service, '|');
        $TMP = explode('|', $list_Service);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstTourService)) {
                $lstTourService[] = $TMP[$i];
            }
        }
    }
    $assign_list['lstTourService'] = $lstTourService;
    unset($lstTourService);
    if ($show == 'Departure') {
        $departure_date = isset($_GET['departure_date']) ? $_GET['departure_date'] : '';
        $assign_list['departure_date'] = $departure_date;
    }
    $promotion = $clsTour->getMinStartDatePromotionPro($tour_id);
    $assign_list['promotion'] = $promotion;
    //	var_dump($promotion);die();
    if ($clsTourStore->checkExist($tour_id, 'DEPARTURE')) {
        $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date='$departure_date' and tour_id='$tour_id' limit 0,1");
        $depositItem = $lstTourStartDate[0]['deposit'];
    } else {
        $lstTourDeposit = $clsTour->getAll("is_trash=0 and is_online=1 and tour_id='$tour_id'");
        $depositItem = $lstTourDeposit[0]['deposit'];
    }
    if ($depositItem > 0) {
        $deposit = $depositItem;
    } else {
        $deposit = 100;
    }
    $assign_list["deposit"] = $deposit;
    $assign_list["depositItem"] = $depositItem;
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
    $assign_list["lstOption"] = $lstOption;
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
    $lastAdultSize = end($lstAdultSize);
    $max_adult = $clsTourOption->getOneField('number_to', $lastAdultSize);
    $max_adult ? $max_adult : 1;
    $assign_list["max_adult"] = $max_adult;
    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = explode(',', $lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child = $clsTourOption->getOneField('number_to', $lastChildSize);
    $assign_list["max_child"] = $max_child;
    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = explode(',', $lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant = $clsTourOption->getOneField('number_to', $lastInfantSize);
    $assign_list["max_infant"] = $max_infant;
    #
    if (!empty($profile_id)) {
        $clsProfile = new Profile();
        $assign_list['clsProfile'] = $clsProfile;
        $name = $clsProfile->getFullname($profile_id);
        $assign_list['name'] = $name;
        $firstname = $clsProfile->getFirstName($profile_id);
        $assign_list['firstname'] = $firstname;
        $lastname = $clsProfile->getLastName($profile_id);
        $assign_list['lastname'] = $lastname;
        $email = $clsProfile->getEmail($profile_id);
        $assign_list['email'] = $email;
        $phone = $clsProfile->getPhone($profile_id);
        $assign_list['phone'] = $phone;
        $address = $clsProfile->getAddress($profile_id);
        $assign_list['address'] = $address;
        $country_id = $clsProfile->getOneField('country_id', $profile_id);
        $assign_list['country_id'] = $country_id;
    }
    $err_msg = '';
    #- Verify Captcha
    if (isset($_POST['booking']) && $_POST['booking'] == 'booking') {
        if (_ISOCMS_CAPTCHA == 'IMG') {
            $security_code = isset($_POST["security_code"]) ? trim($_POST["security_code"]) : '';
            $security_code = strtoupper($security_code);
            if ($security_code == '') {
                $err_msg .= '&bull; ' . $core->get_Lang('Please enter security code') . ' <br />';
            }
            if (!empty($security_code) && $security_code != $_SESSION['skey']) {
                $err_msg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        } else {
            if (!$clsISO->checkGoogleReCAPTCHA()) {
                $err_msg .= $core->get_Lang('Secure code not match') . ' <br />';
            }
        }
        $departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
        $num_day = $clsTour->getOneField('number_day', $tour_id);
        $end_date = date('m/d/Y', strtotime('+' . $num_day . ' day', strtotime($departure_date)));
        $first_name = $_POST['first_name'];
        if ($first_name == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your first name') . ' <br />';
        }
        $last_name = $_POST['last_name'];
        if ($last_name == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your last name') . ' <br />';
        }
        $email = $_POST['email'];
        if ($email == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your email') . ' <br />';
        }
        if ($email != '' && !$clsISO->is_valid_email($email)) {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your email valid') . ' <br />';
        }
        $telephone = $_POST['telephone'];
        if ($telephone == '') {
            $err_msg .= '&bull; ' . $core->get_Lang('Please enter your telephone') . ' <br />';
        }
        #
        if ($err_msg == '') {
            if (_ISOCMS_CLIENT_LOGIN == '2') {
                if (empty($profile_id)) {
                    $res = $clsProfile->getAll("email = '$email' limit 0,1", $clsProfile->pkey);
                    if (!empty($res)) {
                        $profile_id = $res[0]['profile_id'];
                        header('location: ' . DOMAIN_NAME . $extLang . '/account/signin.html');
                        exit();
                    } else {
                        $profile_id = $clsProfile->getMaxID();
                        $password = substr(strtoupper($clsProfile->encrypt('VietISO-' . time())), 0, 8);
                        $userpass = $clsProfile->encrypt($password);
                        #
                        $full_name = $first_name . ' ' . $last_name;
                        $fx = "$clsProfile->pkey,email,username,userpass,full_name,full_name_slug,ip_register,reg_date";
                        $vx = "'" . $profile_id . "','" . $email . "','" . $email . "','" . $userpass . "','" . $full_name . "','" . $core->replaceSpace($full_name) . "','" . $_SERVER['REMOTE_ADDR'] . "','" . time() . "'";
                        if ($clsProfile->insertOne($fx, $vx)) {
                            $clsProfile->sendEmailRegisterMember($profile_id, $password);
                        }
                    }
                }
            }
            $booking_id = $clsBooking->getMaxId();
            $booking_code = $clsBooking->generateBookingCode($booking_id, 'Tour');
            #
            $full_name = $first_name . ' ' . $last_name;
            $f = "booking_id,target_id,title,contact_name,full_name,country_id,phone,email,take_care";
            $f .= ",clsTable,booking_code,booking_store,booking_type,reg_date,ip_booking,check_in,check_out,departure_date,totalgrand,deposit,balance";
            $POST = array();
            foreach ($_POST as $k => $v) {
                $POST[$k] = $v;
            }
            $POST['BOOK_VALUE'] = serialize($BOOK_VALUE);
            $POST['BOOK_ADDON'] = serialize($BOOK_ADDON);
            #
            $v = "'$booking_id'
			,'" . $tour_id . "'
			,'" . $_POST['title'] . "'
			,'" . $full_name . "'
			,'" . $full_name . "'
			,'" . $_POST['country_id'] . "'
			,'" . $_POST['telephone'] . "'
			,'" . $email . "'
			,'" . $_POST['please'] . "'
			,'Tour'
			,'$booking_code'
			,'" . serialize($POST) . "'
			,'Tour','" . time() . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . $departure_date . "'
			,'" . $end_date . "'
			,'" . strtotime($departure_date) . "'
			,'" . $clsISO->processFloatNumber(str_replace('.00', '', $_POST['price_total_amount'])) . "'
			,'" . $_POST['price_deposit'] . "' 
			,'" . $clsISO->processFloatNumber(str_replace('.00', '', $_POST['price_remaining'])) . "'";
            #
            if (PAYMENT_GLOBAL) {
                $f .= ",payment_method";
                $v .= ",'" . intval($_POST['payment_method']) . "'";
            }
            if (_ISOCMS_CLIENT_LOGIN) {
                $f .= ",member_id";
                $v .= ",'$profile_id'";
            }
            if (_IS_TRAVEL_AGENT) {
                $f .= ",agent_id";
                $v .= ",'$agent_id'";
            }
            //			$clsISO->print_pre($_POST['voucher_code'],true);die();
            if ($clsBooking->insertOne($f, $v)) {
                $link_request = $_SERVER['REQUEST_URI'];
                vnSessionSetVar('rq_link', $link_request);
                if ($_POST['voucher_code']) {
                    $f1 = "first_name,last_name,promotion_code,`email`,`ip`,reg_date,is_trash";
                    $v1 = "'" . $first_name . "','" . $last_name . "','" . $_POST['voucher_code'] . "','" . $email . "','" . $_SERVER['REMOTE_ADDR'] . "'," . time() . ",0";
                    $clsVoucher->insertOne($f1, $v1);
                    $promotion_id = $clsPromotion->getByPromotionCode($_POST['voucher_code']);
                    $ticket = $clsPromotion->getDiscountValue($promotion_id, 2) - 1;
                    $discount_val_new = $clsPromotion->getUpdateDiscountValueTicket($promotion_id, $ticket);
                    $clsPromotion->updateOne($promotion_id, "discount_value='" . $discount_val_new . "'");
                }
                $clsBooking->sendEmailBookingTour2018($booking_id);
                if (PAYMENT_GLOBAL) {
                    $clsBilling = new Billing();
                    $clsBilling->initPay($booking_id);
                }
                header('location:' . $extLang . '/booking/tours/successful');
            } else {
                header('location:' . $extLang . '/booking/tours/error');
            }
        } else {
            $assign_list["err_msg"] = $err_msg;
            foreach ($_POST as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Booking Tour') . ' | ' . $oneItem['title'] . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_customize()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang;
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $slug = $_GET['slug'];
    $tour_id = $clsTour->getBySlug($slug);
    if ($tour_id == '') {
        header('location:' . PCMS_URL . $extLang);
    }
    vnSessionSetVar('CUSTOMIZE_TOUR_ID', $tour_id);
    header('location:' . PCMS_URL . $extLang . '/tours/customize-tour/form.html');
}
function default_search()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $country_id, $city_id, $price_range_ID, $duration_ID, $cat_id;
    #
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list['clsTourStore'] = $clsTourStore;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsTransport = new Transport();
    $assign_list['clsTransport'] = $clsTransport;
    $clsReviews = new Reviews();
    $assign_list['clsReviews'] = $clsReviews;
    $clsPromotion = new Promotion();
    $assign_list['clsPromotion'] = $clsPromotion;
    $clsPriceRange = new PriceRange();
    $assign_list['clsPriceRange'] = $clsPriceRange;
    $clsPagination = new Pagination();
    #
    $destination_ID = isset($_GET['destination_ID']) ? $_GET['destination_ID'] : '';
    if (!empty($destination_ID)) {
        if (substr($destination_ID, 0, 1) == '0') {
            $country_id = (int)str_replace('0', '', $destination_ID);
        } else {
            $city_id = (int)$destination_ID;
        }
    }
    if ($destination_ID == '') {
        $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
        $city_id = isset($_GET['city__id']) ? $_GET['city__id'] : '';
    }
    //print_r($city_id); die();
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
    $min_duration = isset($_GET['min_duration']) ? $_GET['min_duration'] : '';
    $max_duration = isset($_GET['max_duration']) ? $_GET['max_duration'] : '';
    $activities_id = isset($_GET['activities_id']) ? $_GET['activities_id'] : '';
    $price_range_id = isset($_GET['price_range_id']) ? $_GET['price_range_id'] : '';
    $destination_id = isset($_GET['destination_id']) ? $_GET['destination_id'] : '';
    $duration_id = isset($_GET['duration_id']) ? $_GET['duration_id'] : '';
    $departure_point_id = isset($_GET['departure_point_id']) ? $_GET['departure_point_id'] : '';
    $keyword = (isset($_GET['key']) && !empty($_GET['key'])) ? $_GET['key'] : '';
    $recordPerPage = 6;
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    #
    $cond = "is_trash=0 and is_online=1";
    $order_by = " order by order_no asc";
    #pagevieew
    if (intval($departure_point_id) > 0) {
        $cond .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
        $assign_list["departure_point_id"] = $departure_point_id;
    }
    if ($country_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
        $assign_list["country_id"] = $country_id;
    }
    if ($destination_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id = '$destination_id')";
        $assign_list["destination_id"] = $destination_id;
    }
    if ($city_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id IN ($city_id))";
        $assign_list["city_id"] = $city_id;
    }
    if (!empty($cat_id)) {
        $cat_ID = explode(',', $cat_id);
        $cond .= " and (";
        for ($i = 0; $i < count($cat_ID); $i++) {
            if ($i == 0 && count($cat_ID) == 1) {
                $cond .= " (cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            } elseif (count($cat_ID) > 1 && $i < (count($cat_ID) - 1)) {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%') or ";
            } else {
                $cond .= "(cat_id='" . $cat_ID[$i] . "' or list_cat_id like '%|" . $cat_ID[$i] . "|%')";
            }
        }
        $cond .= ")";
    }
    $assign_list["cat_id"] = $cat_id;
    if (!empty($activities_id)) {
        $activities_ID = explode(',', $activities_id);
        $cond .= " and (";
        for ($i = 0; $i < count($activities_ID); $i++) {
            if ($i == 0 && count($activities_ID) == 1) {
                $cond .= " list_activities_id like '%" . $activities_ID[$i] . "%'";
            } elseif (count($activities_ID) > 1 && $i < (count($activities_ID) - 1)) {
                $cond .= " list_activities_id like '%|" . $activities_ID[$i] . "|%' or ";
            } else {
                $cond .= " list_activities_id like '%|" . $activities_ID[$i] . "|%'";
            }
        }
        $cond .= ")";
    }
    //print_r($cond);die();
    $assign_list["activities_id"] = $activities_id;
    if ($min_duration > 0 && $max_duration > 0) {
        $cond .= " and number_day >= '$min_duration' and number_day <= '$max_duration'";
    } elseif ($min_duration == 0 && $max_duration > 0) {
        $cond .= " and number_day <= '$max_duration'";
    } elseif ($min_duration > 0 && $max_duration == 0) {
        $cond .= " and number_day >= '$min_duration'";
    } else {
    }
    $assign_list['min_duration'] = $min_duration;
    $assign_list['max_duration'] = $max_duration;
    if (!empty($duration_id)) {
        $cond .= " and number_day='$duration_id'";
        $assign_list["duration_id"] = $duration_id;
    }
    //print_r($cond); die();
    if ($keyword != '') {
        $cond .= " and (title like '$keyword' or slug like '%" . $core->replaceSpace($keyword) . "%')";
        $assign_list["keyword"] = $keyword;
    }
    $totalRecord = $clsTour->getAll($cond);
    $totalRecord = $totalRecord ? count($totalRecord) : '0';
    //print_r($totalRecord);die();
    $assign_list['totalRecord'] = $totalRecord;
    $config = array(
        'total' => $totalRecord,
        'number_per_page' => $recordPerPage,
        'current_page' => $currentPage,
    );
    $clsPagination->initianize($config);
    $page_view = $clsPagination->create_links(false);
    $offset = ($currentPage - 1) * $recordPerPage;
    $limit = " LIMIT $offset,$recordPerPage";
    $listTour = $clsTour->getAll($cond . $order_by . $limit, $clsTour->pkey);
    $assign_list['listTour'] = $listTour;
    unset($listTour);
    $assign_list['page_view'] = $page_view;
    unset($page_view);
    $totalPage = $clsPagination->getTotalPage();
    $assign_list['totalPage'] = $totalPage;
    unset($clsPriceRange);
    unset($clsCity);
    unset($clsTour);
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Results search') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}
function default_ajLoadBookingSummary()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
    global $clsISO;
    #
    $clsTour = new Tour();
    $clsTourService = new TourService();
    $tour_id = intval($_POST['tour_id']);
    $BOOK_VALUE = vnSessionGetVar('BOOK_VALUE');
    $tourRate = $clsTour->getTripPriceOrgin($tour_id);
    $totalRate = 0;
    $totalRate += $tourRate * intval($BOOK_VALUE['adult']);
    $totalRate += $tourRate * intval($BOOK_VALUE['child']);
    $totalRate += $tourRate * intval($BOOK_VALUE['baby']);
    #
    $Html = '
	<div class="box">
		<div class="top"> <h2>Booking Details</h2> </div>
		<div class="mid">
			<ul>
				<li><strong>' . $clsTour->getTitle($tour_id) . ' | ' . $clsTour->getTripDuration($tour_id) . '</strong></li>
				<li><label class="col1">Depart time :</label>
					<span class="subli col2">' . $BOOK_VALUE['departure_date'] . '</span></li>
				<li><label class="col1">Adult(s) :</label>
					<span class="subli col2">x ' . $BOOK_VALUE['adult'] . '</span> <span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($tourRate) . '</span> </li>
				<li><label class="col1">Children(s) :</label>
					<span class="subli col2">x ' . $BOOK_VALUE['child'] . '</span> <span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($tourRate) . '</span></li>
				<li><label class="col1">Bady(s) :</label>
					<span class="subli col2">x ' . $BOOK_VALUE['baby'] . '</span> <span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($tourRate) . '</span></li>
			</ul>
		</div>
	</div>';
    $BOOK_ADDON = vnSessionGetVar('BOOK_ADDON');
    if (is_array($BOOK_ADDON) && count($BOOK_ADDON) > 0) {
        $Html .= '
		<div class="box">
			<div class="top"> <h2>Booking AddOns Services</h2> </div>
			<div class="mid">
				<ul>';
        foreach ($BOOK_ADDON as $k => $v) {
            $Html .= '
					<li>
						<span class="col1">' . $clsTourService->getTitle($k) . '</span> 
						<span class="subli col2">x ' . $v . '</span>
						<span class="col3">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($clsTourService->getPriceOrgin($k) * $v) . '</span>
					</li>';
            #
            $totalRate += $clsTourService->getPriceOrgin($k) * $v;
        }
        $Html .= '</ul>
			</div>
		</div>';
    }
    $Html .= '
	<div class="box">
		<div class="top"> <h2>Price total</h2> </div>
		<div class="mid">
			<ul class="costing">
				<li class="full">Full Payment<span class="detail">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($totalRate) . '</span></li>
				<li class="discount">Discount<span class="detail">' . $clsISO->getRate() . '0</span></li>
				<li class="total">Total Price<span class="detail">' . $clsISO->getRate() . ' ' . $clsISO->formatPrice($totalRate) . '</span></li>
			</ul>
	   </div>
	</div>
	<input type="hidden" name="totalRate" value="' . $clsISO->processSmartNumber($totalRate) . '" />';
    #
    echo ($Html);
    die();
}
function default_loadPriceTableDepartureGroup()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $adult, $child, $infant, $adult_type_id, $child_type_id, $infant_type_id;
    global $clsISO;
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $clsTourPriceGroup = new TourPriceGroup();
    $assign_list["clsTourPriceGroup"] = $clsTourPriceGroup;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $tour_id = intval($_POST['tour_id']);
    $assign_list["tour_id"] = $tour_id;
    $oneItem = $clsTour->getOne($tour_id);
    $assign_list['oneItem'] = $oneItem;
    $departure_in = isset($_POST['departure_date']) && !empty($_POST['departure_date']) ? $_POST['departure_date'] : '';
    $assign_list["departure_in"] = $departure_in;
    $departure_date = strtotime($departure_in);
    $assign_list['departure_date'] = $departure_date;
    $adult = isset($_POST['adult']) ? intval($_POST['adult']) : 1;
    $assign_list['adult'] = $adult;
    $child = isset($_POST['child']) ? intval($_POST['child']) : 0;
    $assign_list['child'] = $child;
    $infant = isset($_POST['infant']) ? intval($_POST['infant']) : 0;
    $assign_list['infant'] = $infant;
    $Available = $clsTourStartDate->getAllotmentTourGroup2($tour_id, $departure_date, $is_agent);
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
    $lastAdultSize = end($lstAdultSize);
    $max_adult = $clsTourOption->getOneField('number_to', $lastAdultSize);
    $max_adult ? $max_adult : 1;
    $assign_list["max_adult"] = $max_adult;
    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = explode(',', $lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child = $clsTourOption->getOneField('number_to', $lastChildSize);
    $assign_list["max_child"] = $max_child;
    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = explode(',', $lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant = $clsTourOption->getOneField('number_to', $lastInfantSize);
    $assign_list["max_infant"] = $max_infant;
    $total_amount = ($price_adult * $adult) + ($price_child * $child) + ($price_infant * $infant);
    $Sql_Promotion = "SELECT promot FROM " . DB_PREFIX . "promotion WHERE clsTable='Tour' and target_id='$tour_id' and " . $departure_date . " between  start_date and end_date and is_online='1' order by start_date ASC limit 0,1";
    $promotion = $dbconn->GetOne($Sql_Promotion);
    $pricePromotion = ($total_amount * $promotion / 100);
    if ($clsTourStore->checkExist($tour_id, 'DEPARTURE')) {
        $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date='$departure_date' and tour_id='$tour_id' limit 0,1");
        $depositItem = $lstTourStartDate[0]['deposit'];
    } else {
        $lstTourDeposit = $clsTour->getAll("is_trash=0 and is_online=1 and tour_id='$tour_id'");
        $depositItem = $lstTourDeposit[0]['deposit'];
    }
    if ($depositItem > 0) {
        $deposit = $depositItem;
    } else {
        $deposit = 100;
    }
    $assign_list["promotion"] = $promotion;
    $assign_list["pricePromotion"] = $pricePromotion;
    $assign_list["deposit"] = $deposit;
    $assign_list["depositItem"] = $depositItem;
    $price_deposit = ($deposit / 100) * $total_amount;
    $price_deposit = number_format($price_deposit, 2, '.', '');
    $remaining_amount = $total_amount - $price_deposit - $pricePromotion;
    $remaining_amount = number_format($remaining_amount, 2, '.', '');
    $lstNationality = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='NATIONALITY' order by order_no asc");
    $assign_list["lstNationality"] = $lstNationality;
    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no asc");
    $assign_list["lstVisitorType"] = $lstVisitorType;
    $html = $core->build('load_Price_Table_Departure_Group.tpl');
    echo ($html);
    die();
}
function default_getTourPriceByNumberGroup()
{
    global $core, $mod, $act, $clsISO, $_LANG_ID, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id;
    $clsTour = new Tour();
    $clsTourPriceGroup = new TourPriceGroup();
    $clsTourStartDate = new TourStartDate();
    $clsTourProperty = new TourProperty();
    $clsTourOption = new TourOption();
    $clsProperty = new Property();
    $tour_id = $_POST['tour_id'];
    $type = $_POST['type'];
    $number_person = $_POST['number_person'];
    $tour_class_id = $_POST['tour_class_id'];
    $tour_visitor_type_id = $_POST['tour_visitor_type_id'];
    if ($type == 'NoDeparture') {
        $departure_in = 0;
        $departure_date = $departure_in;
    } else {
        $departure_in = $_POST['departure_date'];
        //$departure_date = str_replace('/', '-', $departure_in);
        $departure_date = strtotime($departure_in);
    }
    $assign_list['departure_date'] = $departure_date;
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
    $tour_number_group_id = $clsTourPriceGroup->getTourNumberGroup($tour_visitor_type_id, $number_person, $tour_id);
    $price = $clsTourPriceGroup->getPriceBooking($tour_id, $tour_class_id, $tour_number_group_id, $tour_visitor_type_id, $departure_date);
    $Available = $clsTourStartDate->getAllotmentTourGroup2($tour_id, $departure_date, $is_agent_id);
    $getTripPrice = $clsTour->getTripMinPriceTourGroup($tour_id);
    if ($getTripPrice > 0) {
        $getTripPrice = '$' . '' . $getTripPrice;
    } else {
        $getTripPrice = '<a class="linkContact">' . $core->get_Lang('Contact us') . '</a>';
    }
    $sql = "tour_id='$tour_id' and price > 0 and tour_visitor_type_id='$adult_type_id' order by price asc limit 0,1";
    $listTourPriceGroup = $clsTourPriceGroup->getAll("tour_id='$tour_id' and price > 0 and tour_visitor_type_id='$adult_type_id' order by price asc limit 0,1");
    $tour_class_id_selected = $listTourPriceGroup[0]['tour_class_id'];
    echo '0|||' . $price . '|||' . $tour_number_group_id . '|||' . $Available . '|||' . $getTripPrice . '|||' . $tour_class_id;
    die();
}
function default_loadStartEndDate()
{
    global $core, $mod, $act, $clsISO, $_LANG_ID, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id;
    $clsTour = new Tour();
    $departure_date = isset($_POST['departure_date']) && !empty($_POST['departure_date']) ? $_POST['departure_date'] : '';
    $departure_date = strtotime($departure_date);
    //print_r($departure_date);die();
    $tour_id = isset($_POST['tour_id']) && !empty($_POST['tour_id']) ? $_POST['tour_id'] : '';
    $start_date_html = $clsISO->getDayOfWeek($departure_date) . ', ' . $clsISO->converTimeToTextNoComma($departure_date);
    $end_date = $clsTour->getEndDate($departure_date, $tour_id);
    $start_date_html = $clsISO->getDayOfWeek($departure_date) . ', ' . $clsISO->converTimeToTextNoComma($departure_date);
    $end_date_html = $clsISO->getDayOfWeek($end_date) . ', ' . $clsISO->converTimeToTextNoComma($end_date);
    $departure_check_promotion = $_POST['departure_date'];
    //$departure_check_promotion = str_replace('/', '-', $departure_check_promotion);
    $departure_check_promotion = strtotime($departure_check_promotion);
    $travel_date = $departure_check_promotion;
    $booking_date = date('m/d/Y');
    $booking_date = strtotime($booking_date);
    $promotion = $clsTour->getMinStartDatePromotionProChoseTime($tour_id, $booking_date, $travel_date);
    echo '0|||' . $start_date_html . '|||' . $end_date_html . '|||' . $promotion;
    die();
}
function default_loadPriceTableDeparture()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain, $adult, $child, $infant;
}
function default_ajLoadSelectMaxPeople()
{
    global $core, $mod, $act;
    #
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $clsSettingChildPolicy = new SettingChildPolicy();
    #
    $group_size_id = isset($_POST['group_size_id']) ? $_POST['group_size_id'] : 0;
    $number_adult = isset($_POST['number_adult']) ? $_POST['number_adult'] : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $tour_id = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;
    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = explode(',', $lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child = $clsTourOption->getOneField('number_to', $lastChildSize);
    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = explode(',', $lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant = $clsTourOption->getOneField('number_to', $lastInfantSize);
    $maxChild = $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) : 0;
    $maxInfant = $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) : 0;
    #
    $html = '<option value="">' . $core->get_Lang('Select') . '</option>';
    if ($type == 'Child') {
        for ($i = 0; $i <= intval($maxChild); $i++) {
            $html .= '<option value="' . $i . '">' . $i . '</option>';
        }
    } else {
        for ($i = 0; $i <= intval($maxInfant); $i++) {
            $html .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    #
    echo $html;
    die();
}
function default_ajLoadMaxPeople()
{
    global $core, $mod, $act;
    #
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $clsSettingChildPolicy = new SettingChildPolicy();
    #
    $group_size_id = isset($_POST['group_size_id']) ? $_POST['group_size_id'] : 0;
    $number_adult = isset($_POST['number_adult']) ? $_POST['number_adult'] : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $tour_id = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;
    $lstChildSizeGroup = $clsTour->getOneField('child_group_size', $tour_id);
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        $TMP = explode(',', $lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    $lastChildSize = end($lstChildSize);
    $max_child = $clsTourOption->getOneField('number_to', $lastChildSize);
    $lstInfantSizeGroup = $clsTour->getOneField('infant_group_size', $tour_id);
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        $TMP = explode(',', $lstInfantSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    $lastInfantSize = end($lstInfantSize);
    $max_infant = $clsTourOption->getOneField('number_to', $lastInfantSize);
    $maxChild = $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberChild($group_size_id, $number_adult) : 0;
    $maxInfant = $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) ? $clsSettingChildPolicy->getNumberInfant($group_size_id, $number_adult) : 0;
    echo '0|||' . $maxChild . '|||' . $maxInfant;
    die();
}
function default_selectTourPackage()
{
    global $assign_list, $clsISO, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $tour_id, $adult_type_id, $child_type_id, $infant_type_id, $age_type_id, $height_type_id, $clsISO, $package_id, $extLang, $smarty;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsPromotionItem = new PromotionItem();
    $assign_list["clsPromotionItem"] = $clsPromotionItem;
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsTourItinerary = new TourItinerary();
    $assign_list['clsTourItinerary'] = $clsTourItinerary;
    $clsTourImage = new TourImage();
    $assign_list["clsTourImage"] = $clsTourImage;
    $clsTourDestination = new TourDestination();
    $assign_list["clsTourDestination"] = $clsTourDestination;
    $clsTourStartDate = new TourStartDate();
    $assign_list['clsTourStartDate'] = $clsTourStartDate;
    $clsTourImage = new TourImage();
    $assign_list["clsTourImage"] = $clsTourImage;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsTourExtension = new TourExtension();
    $assign_list["clsTourExtension"] = $clsTourExtension;
    $clsTransport = new Transport();
    $assign_list["clsTransport"] = $clsTransport;
    $clsWhy = new Why();
    $assign_list["clsWhy"] = $clsWhy;
    $clsActivities = new Activities();
    $assign_list["clsActivities"] = $clsActivities;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsTable = 'Tour';
    $assign_list["clsTable"] = $clsTable;
    $clsTourStartDate = new TourStartDate();
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    #
    $clsTourDestination = new TourDestination();
    $assign_list['clsTourDestination'] = $clsTourDestination;
    $clsContinent = new Continent();
    $assign_list['clsContinent'] = $clsContinent;
    $clsCountry = new Country();
    $assign_list['clsCountry'] = $clsCountry;
    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    $tour_id = $_POST["tour_id"] ?? 0;
    $assign_list["tour_id"] = $tour_id;
    $oneItemPackage = $clsTour->getOne($tour_id);
    $first_start_date1 = date('m/d/Y', time() + (24 * 60 * 60));
    if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'itinerary', 'customize')) {
        #- Itinerary
        $limit = "";
        if ($oneItemPackage['duration_type'] != 1) {
            $number_day = $oneItemPackage['number_day'];
            $number_night = $oneItemPackage['number_night'];
            if ($number_day > $number_night) {
                $limit = " limit 0," . $number_day;
            } elseif ($number_day == $number_night) {
                $limit = " limit 0," . ($number_day + 1);
            } else {
                $limit = " limit 0," . $number_night;
            }
        }
        $lstItineraryTour = $clsTourItinerary->getAll("is_trash=0 and tour_id='$tour_id' and title_contingency='' order by order_no asc " . $limit, $clsTourItinerary->pkey . ',image,content,tour_itinerary_id,transport,is_show_image,day,day2,tour_id,title,meals');
        $list_itinerary = [];
        foreach ($lstItineraryTour as $k => $v) {
            $list_itinerary[$v[$clsTourItinerary->pkey]] = strtotime($first_start_date1 . ' + ' . $k . ' day');
        }
    }
    $getSelectChild = $getSelectInfant = "";
    $child_visitor_type = $infant_visitor_type = "";
    if ($oneItemPackage['visitorage_child'] != '') {
        $getSelectChild = $clsTourOption->getSelectBySizeGroup($child_type_id, "VISITORAGETYPE");
        $child_visitor_type = $age_type_id;
    } elseif ($oneItemPackage['visitorheight_child'] != '') {
        $getSelectChild = $clsTourOption->getSelectBySizeGroup($child_type_id, "VISITORHEIGHTTYPE");
        $child_visitor_type = $height_type_id;
    }
    if ($oneItemPackage['visitorage_infant'] != '') {
        $getSelectInfant = $clsTourOption->getSelectBySizeGroup($infant_type_id, "VISITORAGETYPE");
        $infant_visitor_type = $age_type_id;
    } elseif ($oneItemPackage['visitorheight_infant'] != '') {
        $getSelectInfant = $clsTourOption->getSelectBySizeGroup($infant_type_id, "VISITORHEIGHTTYPE");
        $infant_visitor_type = $height_type_id;
    }
    $assign_list['child_visitor_type'] = $child_visitor_type;
    $assign_list['infant_visitor_type'] = $infant_visitor_type;
    $assign_list['getSelectChild'] = $getSelectChild;
    $assign_list['getSelectInfant'] = $getSelectInfant;
    $lstVisitorType = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by order_no asc", $clsTourProperty->pkey);
    $assign_list["lstVisitorType"] = $lstVisitorType;
    $lstAdultSizeGroup = $oneItemPackage['adult_group_size'];
    $getMinMaxAdult = $clsTourOption->getAll("tour_option_id in ($lstAdultSizeGroup)", "number_from, number_to");
    #
    $assign_list["max_adult"] = max(array_column($getMinMaxAdult, 'number_to'));
    $assign_list["min_adult"] = min(array_column($getMinMaxAdult, 'number_from'));
    #
    $lstChildSizeGroup = $oneItemPackage['child_group_size'];
    $lstChildSize = array();
    if ($lstChildSizeGroup != '' && $lstChildSizeGroup != '0') {
        //        $TMP = explode(',',$lstChildSizeGroup);
        $TMP = $clsISO->getArrayByTextSlash($lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstChildSize)) {
                $lstChildSize[] = $TMP[$i];
            }
        }
    }
    #
    $max_child = $clsTourOption->getAll('tour_option_id IN (' . implode(',', $lstChildSize) . ')', "max(number_to) as max");
    $max_child = (isset($max_child[0])) ? $max_child[0]['max'] : 0;
    $assign_list["max_child"] = $max_child;
    #
    $lstInfantSizeGroup = $oneItemPackage['infant_group_size'];
    $lstInfantSize = array();
    if ($lstInfantSizeGroup != '' && $lstInfantSizeGroup != '0') {
        //        $TMP = explode(',',$lstInfantSizeGroup);
        $TMP = $clsISO->getArrayByTextSlash($lstChildSizeGroup);
        for ($i = 0; $i < count($TMP); $i++) {
            if (!in_array($TMP[$i], $lstInfantSize)) {
                $lstInfantSize[] = $TMP[$i];
            }
        }
    }
    #
    $max_infant = $clsTourOption->getAll('tour_option_id IN (' . implode(',', $lstInfantSize) . ')', "max(number_to) as max");
    $max_infant = (isset($max_infant[0])) ? $max_infant[0]['max'] : 0;
    $assign_list["max_infant"] = $max_infant;
    if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'store', 'default', 'REVQQVJUVVJFLVZpZXRJU08=')) {
        $checkExistTourStartDate = $clsTourStore->checkExist($tour_id, 'DEPARTURE');
        if (!empty($checkExistTourStartDate)) {
            $lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_active=1 and start_date >= '" . time() . "' and close_sell_date >= '" . time() . "' and tour_id ='$tour_id' and is_last_hour=1  order by start_date ASC", $clsTourStartDate->pkey);
            $is_last_hour = !empty($lstTourStartDate) ? 1 : 0;
            #
            $date_coutdown = array();
            foreach ($lstTourStartDate as $k => $v) {
                $getStrCloseSellDateCountDown = $clsTourStartDate->getStrCloseSellDateCountDown($v[$clsTourStartDate->pkey]);
                $getCloseSellDateCountDown = $clsTourStartDate->getCloseSellDateCountDown($v[$clsTourStartDate->pkey], 'date_coutdown');
                if ($getStrCloseSellDateCountDown > time()) {
                    $date_coutdown[] = $getCloseSellDateCountDown;
                }
            }
            $date_coutdown = array_shift($date_coutdown);
            $list_start_date = $clsTourStartDate->getListStartDateTour($tour_id);
            $tour_start_date = (count($list_start_date) > 0) ? 1 : 0;
        }
    }
    $assign_list["is_last_hour"] = $is_last_hour;
    $assign_list["lstTourStartDate"] = $lstTourStartDate;
    $assign_list["date_coutdown"] = $date_coutdown;
    $assign_list["tour_start_date"] = $tour_start_date;
    #
    $first_start_date = reset($list_start_date);
    $str_first_start_date = $first_start_date;
    $first_start_date1 = $first_start_date ? $first_start_date : date('m/d/Y', time() + (24 * 60 * 60));
    $first_start_date = str_replace('-', '/', $first_start_date);
    #
    $str_first_start_date = strtotime($str_first_start_date);
    $str_first_start_date = !empty($first_start_date) ? $str_first_start_date : time() + (24 * 60 * 60);
    $list_start_date = implode("','", $list_start_date);
    $list_start_date = str_replace('-', '/', $list_start_date);
    $check_tour_start_date = $list_start_date ? 1 : 0;
    #
    $assign_list["str_first_start_date"] = $str_first_start_date;
    $assign_list["first_start_date"] = $first_start_date;
    $assign_list["list_start_date"] = $list_start_date;
    $assign_list["check_tour_start_date"] = $check_tour_start_date;
    if (!empty($first_start_date)) {
        $now_next_departure = 0;
    } else {
        $now_next_departure = time() + (24 * 60 * 60);
        $now_next_departure = $clsISO->converTimeToText5($now_next_departure);
    }
    $assign_list["now_next_departure"] = $now_next_departure;
    foreach ($assign_list as $k => $v) {
        $smarty->assign($k, $v);
    }
    /*if (!empty($lstItineraryTour)) {
        foreach ($lstItineraryTour as $key => $item) {
            $htmlItineraryTour .= $clsISO->getBlock('itineraryTour', ["key" => $key, "item" => $item]);
        }
    }*/
    echo json_encode(array(
        "htmlInclusion" => html_entity_decode($oneItemPackage['inclusion']),
        "htmlExclusion" => html_entity_decode($oneItemPackage['exclusion']),
        "htmlBoxFindTour" => $clsISO->getBlock("box_find_tour"),
        "getSelectChild" => $getSelectChild,
        "getSelectInfant" => $getSelectInfant
    ));
    die();
}
