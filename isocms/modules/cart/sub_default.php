<?php

use Webmozart\Assert\Assert;
if (!function_exists('isoGetTourAddonPricing')) {
    function isoGetTourAddonPricing(
        array $numberAddon,
        AddOnService $clsAddOnService,
        $clsISO
    ): array {
        $items = [];
        $total = 0;

        foreach ($numberAddon as $addonId => $quantity) {
            $addonId = (int)$addonId;
            $quantity = max(0, (int)$quantity);

            if ($addonId <= 0 || $quantity <= 0) {
                continue;
            }

            $addon = $clsAddOnService->getOne($addonId);

            if (
                !is_array($addon)
                || empty($addon[$clsAddOnService->pkey])
            ) {
                continue;
            }

            /*
             * Ưu tiên trường price trong database.
             * Nếu class có cấu trúc khác, fallback getStrPrice().
             */
            $unitPrice = isset($addon['price'])
                ? $addon['price']
                : $clsAddOnService->getStrPrice($addonId);

            if (is_string($unitPrice)) {
                $unitPrice = $clsISO->processSmartNumber2($unitPrice);
            }

            $unitPrice = max(0, (float)$unitPrice);
            $extra = isset($addon['extra']) ? (int)$addon['extra'] : 0;

            /*
             * extra = 1: giá theo nhóm/dịch vụ, chỉ cộng một lần.
             * extra != 1: giá nhân số lượng khách.
             */
            $lineTotal = $extra === 1
                ? $unitPrice
                : $unitPrice * $quantity;

            $items[$addonId] = [
                'addon_id'   => $addonId,
                'quantity'   => $quantity,
                'unit_price' => $unitPrice,
                'extra'      => $extra,
                'line_total' => $lineTotal
            ];

            $total += $lineTotal;
        }

        return [
            'items' => $items,
            'total' => $total
        ];
    }
}
function default_test_payment_method()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $about_us_id;
    global $clsConfiguration, $extLang, $_LANG_ID, $clsISO, $curl;

    require_once(DIR_INCLUDES . '/payment/9pay/lib/HMACSignature.php');
    require_once(DIR_INCLUDES . '/payment/9pay/lib/MessageBuilder.php');
    $MERCHANT_KEY = 'y1C0Nm'; // thông tin key của merchant wallet
    $MERCHANT_SECRET_KEY = '7mebyCRGt0lKM1vHuEhdveDX8wkiGkJ5D3W';  // thông tin secret key của merchant
    $END_POINT = 'https://sand-payment.9pay.vn';

    $invoiceNo = time() + rand(0, 999999);
    $assign_list["invoiceNo"] = $invoiceNo;
    $amount = rand(10000, 99999);
    $assign_list["amount"] = $amount;
    $description = "Mô tả giao dịch";
    $assign_list["description"] = $description;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
        $backUrl = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $returnUrl = str_replace('index.php', '', $backUrl);
        $time = time();
        $data = array(
            'merchantKey' => $MERCHANT_KEY,
            'time' => $time,
            'invoice_no' => $_POST['invoice_no'],
            'amount' => $_POST['amount'],
            'description' => $_POST['description'],

            'back_url' => $backUrl,
            'return_url' => DOMAIN_NAME . '/payment/9pay/success.html',
        );

        $message = MessageBuilder::instance()
            ->with($time, $END_POINT . '/payments/create', 'POST')
            ->withParams($data)
            ->build();


        $hmacs = new HMACSignature();
        $signature = $hmacs->sign($message, $MERCHANT_SECRET_KEY);

        $httpData = [
            'baseEncode' => base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE)),
            'signature' => $signature,
        ];
        $redirectUrl = $END_POINT . '/portal?' . http_build_query($httpData);
        echo '<pre>';
        print_r($data);
        echo '<br/>';
        echo '<hr/>';
        print_r($message);
        echo '<br/>';
        echo '<hr/>';
        var_dump($httpData);
        echo '<br/>';
        echo '<hr/>';
        print_r($redirectUrl);
        //exit();
        return header('Location: ' . $redirectUrl);
    }
}
function statusLabel($status)
{
    if ($status == 5) {
        return [
            'class' => 'success',
            'label' => 'Giao dịch thành công'
        ];
    }

    if ($status == 8) {
        return [
            'class' => 'danger',
            'label' => 'Giao dịch đã bị hủy'
        ];
    }

    if ($status == 6) {
        return [
            'class' => 'danger',
            'label' => 'Giao dịch thất bại'
        ];
    }

    if ($status == 4 || $status == 2) {
        return [
            'class' => 'warning',
            'label' => 'Giao dịch đang xử lý'
        ];
    }

    if ($status == 15) {
        return [
            'class' => 'danger',
            'label' => 'Giao dịch hết hạn'
        ];
    }

    return [
        'class' => 'warning',
        'label' => 'Giao dịch đang xử lý'
    ];
}
function default_9pay_success()
{
    ini_set('display_errors', 1);
    error_reporting(E_ERROR & ~E_STRICT); //E_ALL
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $about_us_id;
    global $clsConfiguration, $extLang, $_LANG_ID, $clsISO, $curl;

    $status = 0;
    $payment = [];

    if (isset($_GET['result'])) {
        $result = base64_decode($_GET['result']);
        $payment = json_decode($result);
        $assign_list["payment"] = $payment;
        //print_r($payment);die();

        $amount = $payment->amount;
        $assign_list["amount"] = $amount;
        $amount_foreign = $payment->amount_foreign;
        $assign_list["amount_foreign"] = $amount_foreign;
        $amount_original = $payment->amount_original;
        $assign_list["amount_original"] = $amount_original;
        $amount_request = $payment->amount_request;
        $assign_list["amount_request"] = $amount_request;
        $bank = $payment->bank;
        $assign_list["bank"] = $bank;
        $card_brand = $payment->card_info->card_brand;
        $assign_list["card_brand"] = $card_brand;
        $card_number = $payment->card_info->card_number;
        $assign_list["card_number"] = $card_number;
        $card_name = $payment->card_info->card_name;
        $assign_list["card_name"] = $card_name;
        $created_at = $payment->created_at;
        $assign_list["created_at"] = $created_at;
        $currency = $payment->currency;
        $assign_list["currency"] = $currency;
        $description = $payment->description;
        $assign_list["description"] = $description;
        $error_code = $payment->error_code;
        $assign_list["error_code"] = $error_code;
        $exc_rate = $payment->exc_rate;
        $assign_list["exc_rate"] = $exc_rate;
        $failure_reason = $payment->failure_reason;
        $assign_list["failure_reason"] = $failure_reason;
        $foreign_currency = $payment->foreign_currency;
        $assign_list["foreign_currency"] = $foreign_currency;
        $invoice_no = $payment->invoice_no;
        $assign_list["invoice_no"] = $invoice_no;
        $lang = $payment->lang;
        $assign_list["lang"] = $lang;
        $method = $payment->method;
        $assign_list["method"] = $method;
        $payment_no = $payment->payment_no;
        $assign_list["payment_no"] = $payment_no;
        $status = $payment->status;
        $assign_list["status"] = $status;
        $tenor = $payment->tenor;
        $assign_list["tenor"] = $tenor;
    }

    $title_page = $core->get_Lang('9Pay Payment Success') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
}
function default_default()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $about_us_id;
    global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsVoucher = new Voucher();
    $assign_list["clsVoucher"] = $clsVoucher;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsTourItinerary = new TourItinerary();
    $assign_list["clsTourItinerary"] = $clsTourItinerary;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsFAQ = new FAQ();
    $assign_list["clsFAQ"] = $clsFAQ;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $lstFAQ = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,4", $clsFAQ->pkey);
    $assign_list["lstFAQ"] = $lstFAQ;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    #
    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
    $cartSessionService = is_array($cartSessionService) && isset($cartSessionService[$_LANG_ID])
        ? $cartSessionService[$_LANG_ID]
        : [];

    $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
    $cartSessionVoucher = is_array($cartSessionVoucher) && isset($cartSessionVoucher[$_LANG_ID])
        ? $cartSessionVoucher[$_LANG_ID]
        : [];

    $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
    $cartSessionCruise = is_array($cartSessionCruise) && isset($cartSessionCruise[$_LANG_ID])
        ? $cartSessionCruise[$_LANG_ID]
        : [];

    $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
    $cartSessionHotel = is_array($cartSessionHotel) && isset($cartSessionHotel[$_LANG_ID])
        ? $cartSessionHotel[$_LANG_ID]
        : [];

    #
    $assign_list['time_now'] = time();
    $totalGrand = 0;
    $totalPriceDeposit = 0;
    $totalPricePromotion = 0;
    $price_remaining = 0;

    if (!empty($cartSessionService)) {
        foreach ($cartSessionService as $key => $value) {
            $totalGrand += $value['total_price_z'];
            $totalPriceDeposit += $value['price_deposit'] ?? 0;
            $totalPricePromotion += $value['price_promotion'] ?? 0;
            $tour_id = $value['tour_id_z'] ?? 0;
        }
    }
    if (!empty($cartSessionVoucher)) {
        foreach ($cartSessionVoucher as $key => $value) {
            $numberVoucher = $value['number_voucher'];
            $voucher_id = $value['voucher_id'];
            $priceO_package = $clsVoucher->getPrice($voucher_id, [], [], false);
            $TotalPriceVoucher = $numberVoucher * $priceO_package;
            $totalGrand += $TotalPriceVoucher;
        }
    }
    if (!empty($cartSessionCruise)) {
        foreach ($cartSessionCruise as $key => $value) {
            $totalpriceCabin = 0;
            $totalPricePromotionCruise = 0;
            foreach ($value['cabin'] as $key2 => $value2) {
                $totalpriceCabin += $value2['totalprice'];
            }
            if ($value['discount_type'] == 2) {
                $totalPricePromotionCruise = $value['promotion'] * $totalpriceCabin / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionCruise = $value['promotion'];
            }
            $totalpriceCabin = $totalPricePromotionCruise ? $totalpriceCabin - $totalPricePromotionCruise : $totalpriceCabin;
            $cartSessionCruise[$key]['totalPricePromotionCruise'] = $totalPricePromotionCruise;
            $cartSessionCruise[$key]['totalpriceCabin'] = $totalpriceCabin;
            $totalGrand += $totalpriceCabin;
        }
    }
    if (!empty($cartSessionHotel)) {
        foreach ($cartSessionHotel as $key => $value) {
            $totalpriceRoom = 0;
            $totalPricePromotionHotel = 0;
            foreach ($value['room'] as $key2 => $value2) {
                $totalpriceRoom += $value2['number_room'] * $value2['room_price'] * $value['number_night'];
            }
            if ($value['discount_type'] == 2) {
                $totalPricePromotionHotel = $value['promotion'] * $totalpriceRoom / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionHotel = $value['promotion'];
            }
            $totalpriceRoom = $totalPricePromotionHotel ? $totalpriceRoom - $totalPricePromotionHotel : $totalpriceRoom;
            $cartSessionHotel[$key]['totalPricePromotionHotel'] = $totalPricePromotionHotel;
            $cartSessionHotel[$key]['totalpriceRoom'] = $totalpriceRoom;
            $totalGrand += $totalpriceRoom;
        }
    }
    #
    $cartSessionPackage = array();
    $totalRemaining = $totalGrand - $totalPriceDeposit;
    #
    $assign_list["cartSessionService"] = $cartSessionService;
    $assign_list["cartSessionVoucher"] = $cartSessionVoucher;
    $assign_list["cartSessionCruise"] = $cartSessionCruise;
    $assign_list["cartSessionHotel"] = $cartSessionHotel;
    #
    $assign_list["totalRemaining"] = $totalRemaining;
    $assign_list["totalGrand"] = $totalGrand;
    $assign_list["price_remaining"] = $price_remaining;
    $assign_list["totalPriceDeposit"] = $totalPriceDeposit;
    $assign_list["totalPricePromotion"] = $totalPricePromotion;
    $assign_list["totalpriceCabin"] = $totalpriceCabin ?? 0;
    $assign_list["totalpriceRoom"] = $totalpriceRoom ?? 0;
    $assign_list["totalPricePromotionCruise"] = $totalPricePromotionCruise ?? 0;
    $assign_list["totalPricePromotionHotel"] = $totalPricePromotionHotel ?? 0;
    #
    if (isset($_POST['bookingCart']) && $_POST['bookingCart'] == 'bookingCart') {
        $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
        $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
        if (empty($cartSessionService)) {
            $cartSessionService = array();
        }
        $assign_list["cartSessionService"] = $cartSessionService;
        #
        $cartSessionService[$tour_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionService[$tour_id][$k] = $v;
        }
        vnSessionSetVar('cartSessionService_' . $_LANG_ID, $cartSessionService);
        #
        if (empty($cartSessionVoucher)) {
            $cartSessionVoucher = array();
        }
        $assign_list["cartSessionVoucher"] = $cartSessionVoucher;
        #
        $cartSessionVoucher[$voucher_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionVoucher[$voucher_id][$k] = $v;
        }
        vnSessionSetVar('cartSessionVoucher_' . $_LANG_ID, $cartSessionVoucher);
        #
        if (empty($cartSessionCruise)) {
            $cartSessionCruise = array();
        }
        $assign_list["cartSessionCruise"] = $cartSessionCruise;
        #
        $cartSessionCruise[] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionCruise[][$k] = $v;
        }
        vnSessionSetVar('cartSessionCruise_' . $_LANG_ID, $cartSessionCruise);
        #
        if (empty($cartSessionHotel)) {
            $cartSessionHotel = array();
        }
        $assign_list["cartSessionHotel"] = $cartSessionHotel;
        #
        $cartSessionHotel[] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionHotel[][$k] = $v;
        }
        #
        vnSessionSetVar('cartSessionHotel_' . $_LANG_ID, $cartSessionHotel);
        #
        header('Location:' . $extLang . '/shopping-cart/booking.html');
        exit();
    }
    #
    $number_of_guests = isset($_POST['number_of_guests']) ? trim(strip_tags($_POST['number_of_guests'])) : '';
    #
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Show Cart') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
    unset($clsPage);
}

function default_cart()
{
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL & ~E_STRICT);
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $about_us_id;
    global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;
    global $URL_CSS, $URL_JS, $URL_LIBRARY, $upd_version;
    #
    Asset::css(["{$URL_CSS}/{$mod}_{$act}.css?v={$upd_version}"]);
    #
    $clsWhy = new Why();
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsVoucher = new Voucher();
    $assign_list["clsVoucher"] = $clsVoucher;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsTourItinerary = new TourItinerary();
    $assign_list["clsTourItinerary"] = $clsTourItinerary;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsFAQ = new FAQ();
    $assign_list["clsFAQ"] = $clsFAQ;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    #
    $listWhy = $clsWhy->getAll("type='HOME'", "$clsWhy->pkey, title");
    $assign_list["listWhy"] = $listWhy;

    $lstFAQ = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,4", $clsFAQ->pkey);
    $assign_list["lstFAQ"] = $lstFAQ;
    #
    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
    $cartSessionService = is_array($cartSessionService) && isset($cartSessionService[$_LANG_ID])
        ? $cartSessionService[$_LANG_ID]
        : [];

    $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
    $cartSessionVoucher = is_array($cartSessionVoucher) && isset($cartSessionVoucher[$_LANG_ID])
        ? $cartSessionVoucher[$_LANG_ID]
        : [];

    $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
    $cartSessionCruise = is_array($cartSessionCruise) && isset($cartSessionCruise[$_LANG_ID])
        ? $cartSessionCruise[$_LANG_ID]
        : [];

    $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
    $cartSessionHotel = is_array($cartSessionHotel) && isset($cartSessionHotel[$_LANG_ID])
        ? $cartSessionHotel[$_LANG_ID]
        : [];

    #
    $assign_list['time_now'] = time();
    $totalGrand = 0;
    $totalPriceDeposit = 0;
    $totalPricePromotion = 0;
    $price_remaining = 0;

    if (!empty($cartSessionService)) {
    foreach ($cartSessionService as $key => $value) {
        $baseTotal = isset($value['base_total_price_z'])
            ? (float)$value['base_total_price_z']
            : (float)($value['total_price_z'] ?? 0);

        /*
         * Với session cũ chưa có base_total_price_z:
         * trừ addon cũ trước khi tính lại để tránh cộng hai lần.
         */
        if (
            !isset($value['base_total_price_z'])
            && isset($value['total_addon_price'])
        ) {
            $baseTotal -= (float)$value['total_addon_price'];
        }

        $addonPricing = isoGetTourAddonPricing(
            $value['number_addon'] ?? [],
            $clsAddOnService,
            $clsISO
        );

        $addonTotal = (float)$addonPricing['total'];
        $itemGrandTotal = max(0, $baseTotal + $addonTotal);

        $depositPercent = isset($value['deposit'])
            ? max(0, (float)$value['deposit'])
            : 100;

        $itemDeposit =
            $itemGrandTotal * $depositPercent / 100;

        $cartSessionService[$key]['base_total_price_z'] =
            $baseTotal;

        $cartSessionService[$key]['addon_items'] =
            $addonPricing['items'];

        $cartSessionService[$key]['total_addon_price'] =
            $addonTotal;

        $cartSessionService[$key]['total_price_z'] =
            $itemGrandTotal;

        $cartSessionService[$key]['price_deposit'] =
            $itemDeposit;

        $cartSessionService[$key]['price_remaining'] =
            max(0, $itemGrandTotal - $itemDeposit);

        $totalGrand += $itemGrandTotal;
        $totalPriceDeposit += $itemDeposit;
        $totalPricePromotion +=
            (float)($value['price_promotion'] ?? 0);

        $tour_id = (int)($value['tour_id_z'] ?? 0);
    }

    /*
     * Ghi lại session sau khi đã chuẩn hóa giá.
     */
    $fullTourSession = vnSessionGetVar(
        'BookingTour_' . $_LANG_ID
    );

    if (!is_array($fullTourSession)) {
        $fullTourSession = [];
    }

    $fullTourSession[$_LANG_ID] = $cartSessionService;

    vnSessionSetVar(
        'BookingTour_' . $_LANG_ID,
        $fullTourSession
    );
}
    if (!empty($cartSessionVoucher)) {
        foreach ($cartSessionVoucher as $key => $value) {
            $numberVoucher = $value['number_voucher'];
            $voucher_id = $value['voucher_id'];
            $priceO_package = $clsVoucher->getPrice($voucher_id, [], [], false);
            $TotalPriceVoucher = $numberVoucher * $priceO_package;
            $totalGrand += $TotalPriceVoucher;
        }
    }
    if (!empty($cartSessionCruise)) {
        foreach ($cartSessionCruise as $key => $value) {
            $totalpriceCabin = 0;
            $totalPricePromotionCruise = 0;
            foreach ($value['cabin'] as $key2 => $value2) {
                $totalpriceCabin += $value2['totalprice'];
            }
            if ($value['discount_type'] == 2) {
                $totalPricePromotionCruise = $value['promotion'] * $totalpriceCabin / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionCruise = $value['promotion'];
            }
            $totalpriceCabin = $totalPricePromotionCruise ? $totalpriceCabin - $totalPricePromotionCruise : $totalpriceCabin;
            $cartSessionCruise[$key]['totalPricePromotionCruise'] = $totalPricePromotionCruise;
            $cartSessionCruise[$key]['totalpriceCabin'] = $totalpriceCabin;
            $totalGrand += $totalpriceCabin;
        }
    }
    if (!empty($cartSessionHotel)) {
        foreach ($cartSessionHotel as $key => $value) {
            $totalpriceRoom = 0;
            $totalPricePromotionHotel = 0;
            foreach ($value['room'] as $key2 => $value2) {
                $totalpriceRoom += $value2['number_room'] * $value2['room_price'] * $value['number_night'];
            }
            if ($value['discount_type'] == 2) {
                $totalPricePromotionHotel = $value['promotion'] * $totalpriceRoom / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionHotel = $value['promotion'];
            }
            $totalpriceRoom = $totalPricePromotionHotel ? $totalpriceRoom - $totalPricePromotionHotel : $totalpriceRoom;
            $cartSessionHotel[$key]['totalPricePromotionHotel'] = $totalPricePromotionHotel;
            $cartSessionHotel[$key]['totalpriceRoom'] = $totalpriceRoom;
            $totalGrand += $totalpriceRoom;
        }
    }
    #
    $totalRemaining = $totalGrand - $totalPriceDeposit;
    #
    $assign_list["cartSessionService"] = $cartSessionService;
    $assign_list["cartSessionVoucher"] = $cartSessionVoucher;
    $assign_list["cartSessionCruise"] = $cartSessionCruise;
    $assign_list["cartSessionHotel"] = $cartSessionHotel;
    #
    $assign_list["totalRemaining"] = $totalRemaining;
    $assign_list["totalGrand"] = $totalGrand;
    $assign_list["price_remaining"] = $price_remaining;
    $assign_list["totalPriceDeposit"] = $totalPriceDeposit;
    $assign_list["totalPricePromotion"] = $totalPricePromotion;
    $assign_list["totalpriceCabin"] = $totalpriceCabin ?? 0;
    $assign_list["totalpriceRoom"] = $totalpriceRoom ?? 0;
    $assign_list["totalPricePromotionCruise"] = $totalPricePromotionCruise ?? 0;
    $assign_list["totalPricePromotionHotel"] = $totalPricePromotionHotel ?? 0;
    #
    if (isset($_POST['bookingCart']) && $_POST['bookingCart'] == 'bookingCart') {
        $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
        $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
        if (empty($cartSessionService)) {
            $cartSessionService = array();
        }
        $assign_list["cartSessionService"] = $cartSessionService;
        #
        $cartSessionService[$tour_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionService[$tour_id][$k] = $v;
        }
        vnSessionSetVar('cartSessionService_' . $_LANG_ID, $cartSessionService);
        #
        if (empty($cartSessionVoucher)) {
            $cartSessionVoucher = array();
        }
        $assign_list["cartSessionVoucher"] = $cartSessionVoucher;
        #
        $cartSessionVoucher[$voucher_id] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionVoucher[$voucher_id][$k] = $v;
        }
        vnSessionSetVar('cartSessionVoucher_' . $_LANG_ID, $cartSessionVoucher);
        #
        if (empty($cartSessionCruise)) {
            $cartSessionCruise = array();
        }
        $assign_list["cartSessionCruise"] = $cartSessionCruise;
        #
        $cartSessionCruise[] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionCruise[][$k] = $v;
        }
        vnSessionSetVar('cartSessionCruise_' . $_LANG_ID, $cartSessionCruise);
        #
        if (empty($cartSessionHotel)) {
            $cartSessionHotel = array();
        }
        $assign_list["cartSessionHotel"] = $cartSessionHotel;
        #
        $cartSessionHotel[] = array();
        foreach ($_POST as $k => $v) {
            $cartSessionHotel[][$k] = $v;
        }
        #
        vnSessionSetVar('cartSessionHotel_' . $_LANG_ID, $cartSessionHotel);
        #
        header('Location:' . $extLang . '/shopping-cart/booking.html');
        exit();
    }
    #
    $number_of_guests = isset($_POST['number_of_guests']) ? trim(strip_tags($_POST['number_of_guests'])) : '';
    #
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Show Cart') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
    unset($clsPage);
}

function default_book()
{
    vnSessionDelVar('rq_link');
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $adult, $child, $infant;
    global $clsISO, $clsConfiguration, $profile_id, $loggedIn, $agent_id, $adult_type_id, $child_type_id, $infant_type_id;
    #
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsVoucher = new Voucher();
    $assign_list['clsVoucher'] = $clsVoucher;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsAddOnService = new AddOnService();
    $assign_list['clsAddOnService'] = $clsAddOnService;
    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;
    $oneProfile = $clsProfile->getOne($profile_id);
    $birthday = !empty($oneProfile['birthday']) ? date('Y-m-d', $oneProfile['birthday']) : '1980-01-11';
    $assign_list['oneProfile'] = $oneProfile;
    $assign_list['birthday'] = $birthday;
    #
    if (_ISOCMS_CLIENT_LOGIN == '2') {
        if (!$loggedIn) {
            $link = $extLang . '/account/signin/r=' . $_SERVER['REQUEST_URI'];
            header('Location:' . $link);
            exit();
        }
    }
    $_EXCHANGE_RATE = $clsISO->getRateVCB('USD');
    $assign_list["_EXCHANGE_RATE"] = $_EXCHANGE_RATE;
    #
    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
    $cartSessionService = $cartSessionService[$_LANG_ID];
    $assign_list['cartSessionService'] = $cartSessionService;
    #
    $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
    $cartSessionVoucher = $cartSessionVoucher[$_LANG_ID];
    $assign_list['cartSessionVoucher'] = $cartSessionVoucher;
    #
    $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
    $cartSessionCruise = $cartSessionCruise[$_LANG_ID];
    #
    $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
    $cartSessionHotel = $cartSessionHotel[$_LANG_ID];
    #
    $cartSessionContact_Info = vnSessionGetVar('ContactInfoBooking');
    $assign_list['cartSessionContact_Info'] = $cartSessionContact_Info;
    #
    $cartStore = array();
    $totalGrand = 0;
    $totalPriceDeposit = 0;
    $totalPricePromotion = 0;
    $price_remaining = 0;
    $total_price = 0;
    $totalPriceTour = 0;
    if (!empty($cartSessionService)) {
    foreach ($cartSessionService as $key => $value) {
        $baseTotal = isset($value['base_total_price_z'])
            ? (float)$value['base_total_price_z']
            : (float)($value['total_price_z'] ?? 0);

        if (
            !isset($value['base_total_price_z'])
            && isset($value['total_addon_price'])
        ) {
            $baseTotal -= (float)$value['total_addon_price'];
        }

        $addonPricing = isoGetTourAddonPricing(
            $value['number_addon'] ?? [],
            $clsAddOnService,
            $clsISO
        );

        $addonTotal = (float)$addonPricing['total'];
        $itemTotal = max(0, $baseTotal + $addonTotal);

        $depositPercent = isset($value['deposit'])
            ? max(0, (float)$value['deposit'])
            : 100;

        $itemDeposit =
            $itemTotal * $depositPercent / 100;

        $cartSessionService[$key]['base_total_price_z'] =
            $baseTotal;

        $cartSessionService[$key]['addon_items'] =
            $addonPricing['items'];

        $cartSessionService[$key]['total_addon_price'] =
            $addonTotal;

        $cartSessionService[$key]['total_price_z'] =
            $itemTotal;

        $cartSessionService[$key]['price_deposit'] =
            $itemDeposit;

        $cartSessionService[$key]['price_remaining'] =
            max(0, $itemTotal - $itemDeposit);

        $totalGrand += $itemTotal;
        $totalPriceTour += $itemTotal;
        $totalPriceDeposit += $itemDeposit;
        $totalPricePromotion +=
            (float)($value['price_promotion'] ?? 0);

        $tour_id = (int)($value['tour_id_z'] ?? 0);
    }

    $cartStore['TOUR'] = $cartSessionService;
}
    $totalPriceVoucher = 0;
    if (!empty($cartSessionVoucher)) {
        foreach ($cartSessionVoucher as $key => $value) {
            $numberVoucher = $value['number_voucher'];
            $voucher_id = $value['voucher_id'];
            $priceO_package = $clsVoucher->getPriceOrigin($voucher_id);
            $TotalPriceVoucher = $numberVoucher * $priceO_package;
            if ($value['discount_type']) {
                if ($value['discount_type'] == 2) {
                    $price_promotion = $TotalPriceVoucher * $value['discount_value'] / 100;
                } else {
                    $price_promotion = $value['discount_value'] * $numberVoucher;
                }
                $TotalPriceVoucher -= $price_promotion;
            }
            $totalGrand += $TotalPriceVoucher;
            $totalPriceVoucher += $TotalPriceVoucher;
        }
        $cartStore['VOUCHER'] = $cartSessionVoucher;
    }
    #
    $totalPriceCruise = 0;
    if (!empty($cartSessionCruise)) {
        foreach ($cartSessionCruise as $key => $value) {
            $totalpriceCabin = 0;
            $totalPricePromotionCruise = 0;
            foreach ($value['cabin'] as $key2 => $value2) {
                $totalpriceCabin += $value2['totalprice'];
            }
            if ($value['discount_type'] == 2) {
                $totalPricePromotionCruise = $value['promotion'] * $totalpriceCabin / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionCruise = $value['promotion'];
            }
            $totalpriceCabin = $totalPricePromotionCruise ? $totalpriceCabin - $totalPricePromotionCruise : $totalpriceCabin;
            $cartSessionCruise[$key]['totalPricePromotionCruise'] = $totalPricePromotionCruise;
            $cartSessionCruise[$key]['totalpriceCabin'] = $totalpriceCabin;
            $totalGrand += $totalpriceCabin;
            $totalPriceCruise += $totalpriceCabin;
        }
        $cartStore['CRUISE'] = $cartSessionCruise;
    }
    $assign_list['cartSessionCruise'] = $cartSessionCruise;
    #
    $totalPriceHotel = 0;
    if (!empty($cartSessionHotel)) {
        foreach ($cartSessionHotel as $key => $value) {
            $totalpriceRoom = 0;
            $totalPricePromotionHotel = 0;
            foreach ($value['room'] as $key2 => $value2) {
                $totalpriceRoom += $value2['number_room'] * $value2['totalprice'];
            }
            if ($value['discount_type'] == 2) {
                $totalPricePromotionHotel = $value['promotion'] * $totalpriceRoom / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionHotel = $value['promotion'];
            }
            $totalpriceRoom = $totalPricePromotionHotel ? $totalpriceRoom - $totalPricePromotionHotel : $totalpriceRoom;
            $cartSessionHotel[$key]['totalPricePromotionHotel'] = $totalPricePromotionHotel;
            $cartSessionHotel[$key]['totalpriceRoom'] = $totalpriceRoom;
            $totalGrand += $totalpriceRoom;
            $totalPriceHotel += $totalpriceRoom;
        }
        $cartStore['HOTEL'] = $cartSessionHotel;
    }
    $assign_list['cartSessionHotel'] = $cartSessionHotel;
    #

    $cartSessionPackage = array();
    if ($totalPriceDeposit > 0) {
        $totalPricePaymentNow = $totalPriceDeposit;
        $totalRemaining = $totalGrand - $totalPriceDeposit;
    } else {
        $totalPricePaymentNow = 0;
        $totalRemaining = $totalGrand;
    }
    #
    $assign_list["number_tour_id"] = $number_tour_id;
    $assign_list["totalRemaining"] = $totalRemaining;
    $assign_list["totalGrand"] = $totalGrand;
    $assign_list["totalPriceTour"] = $totalPriceTour;
    $assign_list["totalPriceVoucher"] = $totalPriceVoucher;
    $assign_list["totalPriceCruise"] = $totalPriceCruise;
    $assign_list["totalPriceHotel"] = $totalPriceHotel;
    $assign_list["totalPricePaymentNow"] = $totalPricePaymentNow;
    $assign_list["departure_date"] = $departure_date;
    $assign_list["price_remaining"] = $price_remaining;
    $assign_list["totalPriceDeposit"] = $totalPriceDeposit;
    $assign_list["totalPricePromotion"] = $totalPricePromotion;
    $assign_list["totalPricePromotionCruise"] = $totalPricePromotionCruise;
    $assign_list["totalPricePromotionHotel"] = $totalPricePromotionHotel;
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
    #- Verify Captcha
    vnSessionDelVar('ContactInfoBooking');
    if (isset($_POST['booking']) && $_POST['booking'] == 'booking') {
        #
        $cartSessionContactInfo = array();
        $err_msg = "";
        foreach ($_POST as $k => $v) {
            $cartSessionContactInfo[$k] = $v;
            $assign_list[$k] = $v;
        }
        vnSessionSetVar('ContactInfoBooking', $cartSessionContactInfo);
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
        $err_msg .= $clsISO->checkSubsTotalSe();
        if ($err_msg == '') {
            $booking_id = $clsBooking->getMaxId();
            $booking_code = $clsBooking->generateBookingCode($booking_id, 'Tour');
            #
            $full_name = $first_name . ' ' . $last_name;
            $f = "booking_id,title,contact_name,full_name,country_id,phone,email";
            $f .= ",clsTable,booking_code,cart_store,booking_store,booking_type,reg_date,ip_booking,totalgrand,deposit,balance,price_promotion,note";
            $POST = array();
            foreach ($_POST as $k => $v) {
                $POST[$k] = $v;
            }
            $cart_store = serialize($cartStore);
            #
            $cartSessionContactInfo = vnSessionGetVar('ContactInfoBooking');
            $booking_store = serialize($cartSessionContactInfo);
            $title = Input::post('title', '');
            $fullname = Input::post('fullname', '');
            $country_id = Input::post('country_id', 0);
            $country_id = $country_id ? $country_id : 0;
            $telephone = Input::post('telephone', '');
            $email = Input::post('email', '');
            $totalFinal = Input::post('totalFinal', 0);
            $customer_note = Input::post('note', '');
            #
            $v = "'$booking_id'
			,'" . $title . "'
			,'" . $fullname . "'
			,'" . $fullname . "'
			,'" . $country_id . "'
			,'" . $telephone . "'
			,'" . $email . "'
			,'Tour'
			,'$booking_code'
			,'" . $cart_store . "'
			,'" . $booking_store . "'
			,'Tour','" . time() . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . $totalGrand . "'
			,'" . $totalPriceDeposit . "' 
			,'" . $totalRemaining . "'
			,'" . $totalPricePromotion . "'
			,'" . $customer_note . "'";
            #
            if (PAYMENT_GLOBAL) {
                $f .= ",payment_method";
                $v .= ",'" . intval($_POST['payment_method']) . "'";
            }
            if (_ISOCMS_CLIENT_LOGIN) {
                if (!empty($profile_id)) {
                    $f .= ",member_id";
                    $v .= ",'$profile_id'";
                }
            }
            if (_IS_TRAVEL_AGENT) {
                if (!empty($agent_id)) {
                    $f .= ",agent_id";
                    $v .= ",'$agent_id'";
                }
            }
            if ($clsBooking->insertOne($f, $v)) {
                foreach ($cartSessionService as $item) {
                    $number_adult = $item['number_adults_z'];
                    $number_child = $item['number_child_z'];
                    $total_number = $number_adult + $number_child;
                    $start_date = strtotime($item['check_in_book_z']);
                    $tour_start_date_id = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id='" . $item['tour_id_z'] . "' and start_date='" . $start_date . "'");
                    $tour_start_date_id = $tour_start_date_id[0]['tour_start_date_id'];
                    $available = $clsTourStartDate->getSeatAvailable($tour_start_date_id) - $total_number;
                    $clsTourStartDate->updateOne($tour_start_date_id, "seat_available='" . $available . "'");
                }
                $link_request = $_SERVER['REQUEST_URI'];
                vnSessionSetVar('rq_link', $link_request);
                if ($_POST['voucher_code']) {
                    $f1 = "first_name,last_name,promotion_code,email,ip,reg_date,is_trash";
                    $v1 = "'" . $first_name . "','" . $last_name . "','" . $_POST['voucher_code'] . "','" . $email . "','" . $_SERVER['REMOTE_ADDR'] . "'," . time() . ",0";
                    $clsVoucher->insertOne($f1, $v1);
                    $promotion_id = $clsPromotion->getByPromotionCode($_POST['voucher_code']);
                    $ticket = $clsPromotion->getDiscountValue($promotion_id, 2) - 1;
                    $discount_val_new = $clsPromotion->getUpdateDiscountValueTicket($promotion_id, $ticket);
                    $clsPromotion->updateOne($promotion_id, "discount_value='" . $discount_val_new . "'");
                }
                $send = $clsBooking->sendEmailBookingCart($booking_id);
                #

                if (PAYMENT_GLOBAL) {
                    $clsBilling = new Billing();
                    $clsBilling->initPay($booking_id);
                }
                $clsBooking->syncBookingTMS($booking_id);
                vnSessionDelVar('BookingTour_' . $_LANG_ID);
                vnSessionDelVar('BookingVoucher_' . $_LANG_ID);
                vnSessionDelVar('BookingCruise_' . $_LANG_ID);
                vnSessionDelVar('BookingHotel_' . $_LANG_ID);
                header('location:' . $extLang . '/booking/booking_id=' . $booking_id . '&successful');
            } else {
                header('location:' . $extLang . '/booking/error');
            }
        } else {
            $assign_list["err_msg"] = $err_msg;
            foreach ($_POST as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Shopping Cart') . ' | ' . $core->get_Lang('Booking') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_book2()
{
    vnSessionDelVar('rq_link');
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $adult, $child, $infant;
    global $clsISO, $clsConfiguration, $profile_id, $loggedIn, $agent_id, $adult_type_id, $child_type_id, $infant_type_id;

    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsVoucher = new Voucher();
    $assign_list['clsVoucher'] = $clsVoucher;

    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;

    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsAddOnService = new AddOnService();
    $assign_list['clsAddOnService'] = $clsAddOnService;
    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;
    $oneProfile = $clsProfile->getOne($profile_id);
    $birthday = !empty($oneProfile['birthday']) ? date('Y-m-d', $oneProfile['birthday']) : '1980-01-11';
    $assign_list['oneProfile'] = $oneProfile;
    $assign_list['birthday'] = $birthday;
    #
    if (_ISOCMS_CLIENT_LOGIN == '2') {
        if (!$loggedIn) {
            $link = $extLang . '/account/signin/r=' . $_SERVER['REQUEST_URI'];
            header('Location:' . $link);
            exit();
        }
    }
    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
    $cartSessionService = $cartSessionService[$_LANG_ID];
    $assign_list['cartSessionService'] = $cartSessionService;

    $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
    $cartSessionVoucher = $cartSessionVoucher[$_LANG_ID];
    $assign_list['cartSessionVoucher'] = $cartSessionVoucher;

    $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
    $cartSessionCruise = $cartSessionCruise[$_LANG_ID];
    $assign_list['cartSessionCruise'] = $cartSessionCruise;

    $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
    $cartSessionHotel = $cartSessionHotel[$_LANG_ID];
    $assign_list['cartSessionHotel'] = $cartSessionHotel;

    $cartSessionContact_Info = vnSessionGetVar('ContactInfoBooking');
    $assign_list['cartSessionContact_Info'] = $cartSessionContact_Info;

    $cartStore = array();

    $totalGrand = 0;


    $totalPriceDeposit = 0;
    $totalPricePromotion = 0;
    $price_remaining = 0;
    $total_price = 0;


    $totalPriceTour = 0;
    if (!empty($cartSessionService)) {
        foreach ($cartSessionService as $key => $value) {
            $totalGrand += $value['total_price_z'];
            $totalPriceTour += $value['total_price_z'];
            $totalPriceDeposit += $value['price_deposit'];
            $totalPricePromotion += $value['price_promotion'];
            $tour_id = $value['tour_id_z'];
        }
        $cartStore['TOUR'] = $cartSessionService;
    }

    $totalPriceVoucher = 0;
    if (!empty($cartSessionVoucher)) {
        foreach ($cartSessionVoucher as $key => $value) {
            $numberVoucher = $value['number_voucher'];
            $voucher_id = $value['voucher_id'];
            $priceO_package = $clsVoucher->getPriceOrigin($voucher_id);
            $TotalPriceVoucher = $numberVoucher * $priceO_package;
            $totalGrand += $TotalPriceVoucher;
            $totalPriceVoucher += $TotalPriceVoucher;
        }
        $cartStore['VOUCHER'] = $cartSessionVoucher;
    }


    $totalPriceCruise = 0;
    if (!empty($cartSessionCruise)) {
        foreach ($cartSessionCruise as $key => $value) {
            foreach ($value['cabin'] as $key2 => $value2) {
                $totalpriceCabin = $value2['totalprice'];
                $totalGrand += $totalpriceCabin;
                $totalPriceCruise += $totalpriceCabin;
            }
        }
        $cartStore['CRUISE'] = $totalPriceCruise;
    }

    $totalPriceHotel = 0;
    if (!empty($cartSessionHotel)) {
        foreach ($cartSessionHotel as $key => $value) {
            foreach ($value['room'] as $key2 => $value2) {
                $totalpriceRoom = $value2['number_room'] * $value2['totalprice'];
                $totalGrand += $totalpriceRoom;
                $totalPriceHotel += $totalpriceRoom;
            }
        }
        $cartStore['HOTEL'] = $cartSessionHotel;
    }

    $cartSessionPackage = array();
    if ($totalPriceDeposit > 0) {
        $totalPricePaymentNow = $totalPriceDeposit;
        $totalRemaining = $totalGrand - $totalPriceDeposit;
    } else {
        $totalPricePaymentNow = $totalGrand;
        $totalRemaining = $totalGrand;
    }

    $assign_list["number_tour_id"] = $number_tour_id;
    $assign_list["totalRemaining"] = $totalRemaining;
    $assign_list["totalGrand"] = $totalGrand;
    $assign_list["totalPriceTour"] = $totalPriceTour;
    $assign_list["totalPriceVoucher"] = $totalPriceVoucher;
    $assign_list["totalPriceCruise"] = $totalPriceCruise;
    $assign_list["totalPriceHotel"] = $totalPriceHotel;
    $assign_list["totalPricePaymentNow"] = $totalPricePaymentNow;
    $assign_list["departure_date"] = $departure_date;
    $assign_list["price_remaining"] = $price_remaining;
    $assign_list["totalPriceDeposit"] = $totalPriceDeposit;
    $assign_list["totalPricePromotion"] = $totalPricePromotion;

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


        if ($err_msg == '') {
            $cartSessionContactInfo = array();
            foreach ($_POST as $k => $v) {
                $cartSessionContactInfo[$k] = $v;
            }
            vnSessionSetVar('ContactInfoBooking', $cartSessionContactInfo);
            $booking_id = $clsBooking->getMaxId();
            $booking_code = $clsBooking->generateBookingCode($booking_id, 'Tour');
            #
            $full_name = $first_name . ' ' . $last_name;
            $f = "booking_id,title,contact_name,full_name,country_id,phone,email";
            $f .= ",clsTable,booking_code,cart_store,booking_store,booking_type,reg_date,ip_booking,totalgrand,deposit,balance";
            $POST = array();
            foreach ($_POST as $k => $v) {
                $POST[$k] = $v;
            }

            $cart_store = serialize($cartStore);

            $cartSessionContactInfo = vnSessionGetVar('ContactInfoBooking');
            $booking_store = serialize($cartSessionContactInfo);
            $title = Input::post('title', '');
            $fullname = Input::post('fullname', '');
            $country_id = Input::post('country_id', 0);
            $country_id = $country_id ? $country_id : 0;
            $telephone = Input::post('telephone', '');
            $email = Input::post('email', '');
            $totalFinal = Input::post('totalFinal', 0);

            $v = "'$booking_id'
			,'" . $title . "'
			,'" . $fullname . "'
			,'" . $fullname . "'
			,'" . $country_id . "'
			,'" . $telephone . "'
			,'" . $email . "'
			,'Tour'
			,'$booking_code'
			,'" . $cart_store . "'
			,'" . $booking_store . "'
			,'Tour','" . time() . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . $totalGrand . "'
			,'" . $totalPriceDeposit . "' 
			,'" . $totalRemaining . "'";


            if (PAYMENT_GLOBAL) {
                $f .= ",payment_method";
                $v .= ",'" . intval($_POST['payment_method']) . "'";
            }
            if (_ISOCMS_CLIENT_LOGIN) {
                if (!empty($profile_id)) {
                    $f .= ",member_id";
                    $v .= ",'$profile_id'";
                }
            }
            if (_IS_TRAVEL_AGENT) {
                if (!empty($agent_id)) {
                    $f .= ",agent_id";
                    $v .= ",'$agent_id'";
                }
            }
            //			$clsISO->print_pre($_POST['voucher_code'],true);die();
            //			print_r($f.'xxxx'.$v);die();
            if ($clsBooking->insertOne($f, $v)) {
                foreach ($cartSessionService as $item) {
                    $number_adult = $item['number_adults_z'];
                    $number_child = $item['number_child_z'];
                    $total_number = $number_adult + $number_child;
                    $start_date = strtotime($item['check_in_book_z']);
                    $tour_start_date_id = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id='" . $item['tour_id_z'] . "' and start_date='" . $start_date . "'");
                    $tour_start_date_id = $tour_start_date_id[0]['tour_start_date_id'];
                    $available = $clsTourStartDate->getSeatAvailable($tour_start_date_id) - $total_number;
                    //					print_r($available);die();
                    $clsTourStartDate->updateOne($tour_start_date_id, "seat_available='" . $available . "'");
                }
                $link_request = $_SERVER['REQUEST_URI'];
                vnSessionSetVar('rq_link', $link_request);
                if ($_POST['voucher_code']) {
                    $f1 = "first_name,last_name,promotion_code,email,ip,reg_date,is_trash";
                    $v1 = "'" . $first_name . "','" . $last_name . "','" . $_POST['voucher_code'] . "','" . $email . "','" . $_SERVER['REMOTE_ADDR'] . "'," . time() . ",0";
                    $clsVoucher->insertOne($f1, $v1);
                    $promotion_id = $clsPromotion->getByPromotionCode($_POST['voucher_code']);
                    $ticket = $clsPromotion->getDiscountValue($promotion_id, 2) - 1;
                    $discount_val_new = $clsPromotion->getUpdateDiscountValueTicket($promotion_id, $ticket);
                    $clsPromotion->updateOne($promotion_id, "discount_value='" . $discount_val_new . "'");
                }
                //$clsBooking->sendEmailBookingCart($booking_id);
                if (PAYMENT_GLOBAL) {
                    $clsBilling = new Billing();
                    $clsBilling->initPay($booking_id);
                }
                header('location:' . $extLang . '/booking/booking_id=' . $booking_id . '&successful');
            } else {
                header('location:' . $extLang . '/booking/error');
            }
        } else {
            $assign_list["err_msg"] = $err_msg;
            foreach ($_POST as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
    }
    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Shopping Cart') . ' | ' . $core->get_Lang('Booking') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}
function default_get_promotion()
{
    global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;

    $clsDiscount = new Discount();
    $assign_list["clsDiscount"] = $clsDiscount;
    $clsVoucher = new Voucher();
    $assign_list["clsVoucher"] = $clsVoucher;

    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
    $cartSessionService = array_merge($cartSessionService[$_LANG_ID]);

    $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
    $cartSessionVoucher = array_merge($cartSessionVoucher[$_LANG_ID]);

    $totalGrand = 0;
    $totalPriceDeposit = 0;
    $totalPricePromotion = 0;
    $price_remaining = 0;

    if (!empty($cartSessionService)) {
        for ($i = 0; $i < count($cartSessionService); $i++) {
            $totalGrand += $cartSessionService[$i]['total_price_z'];
        }
    }

    if (!empty($cartSessionVoucher)) {
        for ($i = 0; $i < count($cartSessionVoucher); $i++) {

            $voucher_id = $cartSessionVoucher[$i]['voucher_id'];
            $numberVoucher = $cartSessionVoucher[$i]['number_voucher'];
            $priceO_package = $clsVoucher->getPriceOrigin($voucher_id);
            $TotalPriceVoucher = $numberVoucher * $priceO_package;
            $totalGrand += $TotalPriceVoucher;
        }
    }
    //	print_r($TotalPriceVoucher);die();
    $totalPricePaymentNow = $totalGrand;

    $promotion_code = $_POST['promotion_code'];
    //	print_r($promotion_code);die();
    //	and list_voucher_id like '%$voucher_id%'
    $TotalDes = $clsDiscount->getAll("is_trash=0 and status=1  and code like '$promotion_code' and start_date < " . time() . "  order by discount_id asc limit 0,1", $clsDiscount->pkey . ',more_information');

    $id = $TotalDes[0];
    $discountId = $id['discount_id'];
    $moreInfor = $id['more_information'];
    $moreInfor = !empty($moreInfor) ? @json_decode($moreInfor, true) : array();
    $discounType = $moreInfor['discount_type'];
    $discounValue = $moreInfor['discount_value'];
    $type = $moreInfor['type'];


    if (!empty($TotalDes)) {
        if ($discounType == 'amount') {
            $html = '_success|||<span class="price tag">' . $clsISO->formatPrice($discounValue) . $clsISO->getShortRate() . '</span>|||' . $clsISO->formatPrice($totalPricePaymentNow - $discounValue) . $clsISO->getShortRate() . '|||' . ($totalPricePaymentNow - $discounValue);
            echo $html;
        } else {
            $TotalPer = ($totalPricePaymentNow * $discounValue) / 100;
            $html = '_success|||<span class="price tag">' . $discounValue . '&#37;</span>|||' . $clsISO->formatPrice($totalPricePaymentNow - $TotalPer) . $clsISO->getShortRate() . '|||' . ($totalPricePaymentNow - $TotalPer);
            echo $html;
        }

        die();
    } else {
        echo '_invalid|||Mã khuyến mãi không hợp lệ';
        die();
    }
}
function default_ajaxGetTotalServiceCart()
{
    global $core, $_LANG_ID;
    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
    $cartSessionService = $cartSessionService[$_LANG_ID];

    $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
    $cartSessionVoucher = $cartSessionVoucher[$_LANG_ID];

    $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
    $cartSessionCruise = $cartSessionCruise[$_LANG_ID];

    $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
    $cartSessionHotel = $cartSessionHotel[$_LANG_ID];

    $TotalService = 0;
    if (!empty($cartSessionService)) {
        $TotalService += count($cartSessionService);
    }
    if (!empty($cartSessionVoucher)) {
        $TotalService += count($cartSessionVoucher);
    }
    if (!empty($cartSessionCruise)) {
        $TotalService += count($cartSessionCruise);
    }
    if (!empty($cartSessionHotel)) {
        $TotalService += count($cartSessionHotel);
    }
    echo $TotalService;
    die();
}

function default_ajaxUpdateToCart()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $tour_id;

    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $table_id = isset($_POST['table_id']) ? $_POST['table_id'] : 0;
    if ($tp == 'DEL_PACKAGE') {
        $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
        if (empty($cartSessionService)) {
            $cartSessionService = array();
        }
        unset($cartSessionService[$_LANG_ID][$table_id]);

        vnSessionSetVar('BookingTour_' . $_LANG_ID, $cartSessionService);
        $exist = '_REMOVE';
        echo $exist;
        die();
    }
    if ($tp == 'DEL_CRUISE') {
        $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
        if (empty($cartSessionCruise)) {
            $cartSessionCruise = array();
        }
        unset($cartSessionCruise[$_LANG_ID][$table_id]);

        vnSessionSetVar('BookingCruise_' . $_LANG_ID, $cartSessionCruise);
        $exist = '_REMOVE';
        echo $exist;
        die();
    }

    if ($tp == 'DEL_HOTEL') {
        $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
        if (empty($cartSessionHotel)) {
            $cartSessionHotel = array();
        }
        unset($cartSessionHotel[$_LANG_ID][$table_id]);

        vnSessionSetVar('BookingHotel_' . $_LANG_ID, $cartSessionHotel);
        $exist = '_REMOVE';
        echo $exist;
        die();
    }

    if ($tp == 'DEL_VOUCHER') {
        $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
        if (empty($cartSessionVoucher)) {
            $cartSessionVoucher = array();
        }
        unset($cartSessionVoucher[$_LANG_ID][$table_id]);

        vnSessionSetVar('BookingVoucher_' . $_LANG_ID, $cartSessionVoucher);
        $exist = '_REMOVE';
        echo $exist;
        die();
    }
    echo $exist;
    die();
}

function default_checkout2()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $tour_id;

    if ($_POST['booking'] == 'booking') {
        vtcpay_link();
    }
}

function default_checkout()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $tour_id;

    if (isset($_POST['booking']) && $_POST['booking'] == 'booking') {


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
}

function default_vtcpay_link($params = '')
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $tour_id;
    global $_LANG_ID;

    # Invoice Variables
    $invoiceid = 103789606;
    $description = 'Test';
    $amount = 11010.0000; # Format: ##.##
    $currency = 'VND'; # Currency Code

    /**KHACH HANG SUA THONG TIN SAU**************************************************************/
    $index = 'https://isocms.com'; // dia chi website cua ban
    $business = '0963465816'; //tai khoan VTC Pay nhan tien dang ky tai pay.vtc.vn
    $merchant_id = '198584'; // Ma websiteid duoc gen tren pay.vtc.vn
    $secure_pass = 'axds12@7&vdAX756'; // ma bao mat duoc dien tren pay.vtc.vn
    $pay_url = 'http://alpha1.vtcpay.vn/portalgateway/checkout.html'; //url thanh toan
    $return_url = "https://isocms.com/checkout/"; // Đưa link VTCPay_Listener vào đây
    /*
        sanbox url: http://sandbox1.vtcebank.vn/pay.vtc.vn/gate/checkout.html
        Triển khai url: https://pay.vtc.vn/cong-thanh-toan/checkout.html
    */
    /**HET PHAN SUA******************************************************************************************/

    $order_id = 103789606;
    $total_amount = intval(10000000);
    $order_description = 'Test';
    $url_success = $index;
    $url_cancel = $index . '/clientarea.php';
    $url_detail = $index . '/viewinvoice.php?id=' . $order_id;

    $transaction_info = "thanhtoantaiwebsite";
    $customer_mobile = "";
    $param_extend = "";

    $url = createRequestUrl($return_url, $business, $transaction_info, $order_id, $total_amount, $customer_mobile, $merchant_id, $secure_pass, $pay_url, $param_extend);

    $code = '<a href="' . $url . '"><img src="https://lh3.googleusercontent.com/-gBkC9DqZC6o/YXjIFIt_1NI/AAAAAAAAOwE/cwH74tVpdr0OT7-tSd6Kud0p97DEEXyxgCLcBGAsYHQ/s0/VTC_Pay_logo.png" /></a>';


    $assign_list['code'] = $code;
    return $code;
}

function createRequestUrl($return_url, $receiver, $transaction_info, $order_code, $amount, $customer_mobile, $websiteid, $secret_key, $vtcpay_url, $param_extend)
{
    // M?ng các tham s? chuy?n t?i VTC Pay

    $arr_param = array(
        'return_url' => strtolower(urlencode($return_url)),
        'receiver' => strval($receiver),
        'transaction_info' => strval($transaction_info),
        'order_code' => strval($order_code),
        'amount' => strval($amount)
    );
    $currency = 'VND';


    $plaintext = $arr_param['amount'] . "|" . $currency . "|" . $param_extend . "|" . $arr_param['receiver'] . "|" . $arr_param['order_code'] . "|" . $return_url . "|" . $websiteid . "|" . $secret_key;

    $sign = strtoupper(hash('sha256', $plaintext));

    $data = "?website_id=" . $websiteid . "&currency=" . $currency . "&reference_number=" . $arr_param['order_code'] . "&amount=" . $arr_param['amount'] . "&receiver_account=" . $arr_param['receiver'] . "&url_return=" . urlencode($return_url) . "&signature=" . $sign . "&payment_type=" . $param_extend;


    $destinationUrl = $vtcpay_url . $data;
    $destinationUrl = str_replace("%3a", ":", $destinationUrl);
    $destinationUrl = str_replace("%2f", "/", $destinationUrl);
    return $destinationUrl;
}

function format_price_vtcpay($price)
{
    $price_vtcpay = str_replace(',', '', $price);
    $price_vtcpay = str_replace('.', '', $price_vtcpay);
    $price_vtcpay = strip_tags($price_vtcpay);
    $price_vtcpay = trim($price_vtcpay);
    return $price_vtcpay;
}

function default_billDetail()
{
    global $assign_list, $_CONFIG, $clsISO, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav;
    #
    $billing_string = Input::get('billing_id', '');
    $billing_id = $core->decryptID($billing_string);
    if ($billing_id > 0) {
        $clsBillingHistory = new BillingHistory();
        $oneItemBilling = $clsBillingHistory->getOne($billing_id, 'html_bill,bill_code');
        $assign_list['oneItemBilling'] = $oneItemBilling;
    } else {
        header("Location: /");
    }
}

function default_book_2024()
{
    vnSessionDelVar('rq_link');
    global $assign_list, $_CONFIG, $core, $extLang, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $adult, $child, $infant;
    global $clsISO, $clsConfiguration, $profile_id, $loggedIn, $agent_id, $adult_type_id, $child_type_id, $infant_type_id;
    #
    global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;

    #Danh sách file css sử dụng cho trang home
    Asset::css([
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.7.0/build/css/intlTelInput.min.css",
        "{$URL_JS}/intlTelInput/intlTelInput.min.css?ver={$upd_version}",
        "{$URL_JS}/select2/select2.min.css?ver={$upd_version}",
        "{$URL_CSS}/cart_book_2024.css?v={$upd_version}"
    ]);

    Asset::js([
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.7.0/build/js/intlTelInput.min.js",
        "{$URL_JS}/select2/select2.min.js?ver={$upd_version}",
        "{$URL_JS}/intlTelInput/intlTelInput.min.js?ver={$upd_version}",
        "{$URL_JS}/jquery.validate.js?v={$upd_version}",
        "{$URL_JS}/cart_book_2024.js?v={$upd_version}"
    ]);

    #
    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;
    $clsVoucher = new Voucher();
    $assign_list['clsVoucher'] = $clsVoucher;
    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $clsCruise = new Cruise();
    $assign_list["clsCruise"] = $clsCruise;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    $clsHotelRoom = new HotelRoom();
    $assign_list["clsHotelRoom"] = $clsHotelRoom;
    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;
    $clsAddOnService = new AddOnService();
    $assign_list['clsAddOnService'] = $clsAddOnService;

    //Lay thong tin dang nhap
    $clsProfile = new Profile();
    $assign_list['clsProfile'] = $clsProfile;
    $oneProfile = $clsProfile->getOne($profile_id);
    $profile_birthday = !empty($oneProfile['birthday']) ? date('d/m/Y', $oneProfile['birthday']) : '01/01/1970';
    $assign_list['oneProfile'] = $oneProfile;
    $assign_list['profile_birthday'] = $profile_birthday;
    $assign_list['profile_id'] = $profile_id;
    //
    #

    if (_ISOCMS_CLIENT_LOGIN == '2') {
        if (!$loggedIn) {
            $link = $extLang . '/account/signin/r=' . $_SERVER['REQUEST_URI'];
            header('Location:' . $link);
            exit();
        }
    }

    $_EXCHANGE_RATE = $clsISO->getRateVCB('USD');
    $assign_list["_EXCHANGE_RATE"] = $_EXCHANGE_RATE;
    #
    $cartSessionService = vnSessionGetVar('BookingTour_' . $_LANG_ID);
    $cartSessionService = $cartSessionService[$_LANG_ID] ?? [];
    $assign_list['cartSessionService'] = $cartSessionService;
    #
    $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
    $cartSessionVoucher = $cartSessionVoucher[$_LANG_ID] ?? [];
    $assign_list['cartSessionVoucher'] = $cartSessionVoucher;
    #
    $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);
    $cartSessionCruise = $cartSessionCruise[$_LANG_ID];
    #
    $cartSessionHotel = vnSessionGetVar('BookingHotel_' . $_LANG_ID);
    $cartSessionHotel = $cartSessionHotel[$_LANG_ID] ?? [];
    #
    $cartSessionContact_Info = vnSessionGetVar('ContactInfoBooking');
    $assign_list['cartSessionContact_Info'] = $cartSessionContact_Info ?? [];
    #

    if (empty($cartSessionService) && empty($cartSessionVoucher) && empty($cartSessionCruise) && empty($cartSessionHotel)) {
        header('Location:' . '/' . $extLang);
        exit();
    }

    $cartStore = array();
    $totalGrand = 0;
    $totalPriceDeposit = 0;
    $totalPricePromotion = 0;
    $price_remaining = 0;
    $totalPriceTour = 0;

    if (!empty($cartSessionService)) {
        foreach ($cartSessionService as $key => $value) {
            $totalGrand += $value['total_price_z'] ?? 0;
            $totalPriceTour += $value['total_price_z'] ?? 0;
            $totalPriceDeposit += $value['price_deposit'] ?? 0;
            $totalPricePromotion += $value['price_promotion'] ?? 0;
        }
        $cartStore['TOUR'] = $cartSessionService;
    }
    #

    # Voucher, Cruise, Hotel chưa có cấu hình đặt cọc

    $totalPriceVoucher = 0;
    if (!empty($cartSessionVoucher)) {
        foreach ($cartSessionVoucher as $key => $value) {
            $numberVoucher = $value['number_voucher'];
            $voucher_id = $value['voucher_id'];
            $priceO_package = $clsVoucher->getPriceOrigin($voucher_id);
            $TotalPriceVoucher = $numberVoucher * $priceO_package;
            if ($value['discount_type']) {
                if ($value['discount_type'] == 2) {
                    $price_promotion = $TotalPriceVoucher * $value['discount_value'] / 100;
                } else {
                    $price_promotion = $value['discount_value'] * $numberVoucher;
                }
                $TotalPriceVoucher -= $price_promotion;
            }
            $totalPriceDeposit += $TotalPriceVoucher;
            $totalGrand += $TotalPriceVoucher;
            $totalPriceVoucher += $TotalPriceVoucher;
        }
        $cartStore['VOUCHER'] = $cartSessionVoucher;
    }
    #
    $totalPriceCruise = 0;

    if (!empty($cartSessionCruise)) {

        foreach ($cartSessionCruise as $key => $value) {
            $totalpriceCabin = 0;
            $totalPricePromotionCruise = 0;
            $total_deposit = 0;
            foreach ($value['cabin'] as $key2 => $value2) {
                $totalpriceCabin += $value2['totalprice'];
                $total_deposit += (int) $value2['deposit_price'];
            }

            if ($value['discount_type'] == 2) {
                $totalPricePromotionCruise = $value['promotion'] * $totalpriceCabin / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionCruise = $value['promotion'];
            }
            $totalpriceCabin = $totalPricePromotionCruise ? $totalpriceCabin - $totalPricePromotionCruise : $totalpriceCabin;
            $cartSessionCruise[$key]['totalPricePromotionCruise'] = $totalPricePromotionCruise;
            $cartSessionCruise[$key]['totalpriceCabin'] = $totalpriceCabin;

            $totalPriceDeposit += $total_deposit;
            $totalGrand += $totalpriceCabin;
            $totalPriceCruise += $totalpriceCabin;
        }
        $cartStore['CRUISE'] = $cartSessionCruise;
    }
    $assign_list['cartSessionCruise'] = $cartSessionCruise;
    #
    $totalPriceHotel = 0;
    if (!empty($cartSessionHotel)) {
        foreach ($cartSessionHotel as $key => $value) {
            $totalpriceRoom = 0;
            $totalPricePromotionHotel = 0;
            foreach ($value['room'] as $key2 => $value2) {
                $totalpriceRoom += $value2['number_room'] * $value2['room_price'] * $value['number_night'];
            }
            if ($value['discount_type'] == 2) {
                $totalPricePromotionHotel = $value['promotion'] * $totalpriceRoom / 100;
            } elseif ($value['discount_type'] == 1) {
                $totalPricePromotionHotel = $value['promotion'];
            }
            $totalpriceRoom = $totalPricePromotionHotel ? $totalpriceRoom - $totalPricePromotionHotel : $totalpriceRoom;
            $cartSessionHotel[$key]['totalPricePromotionHotel'] = $totalPricePromotionHotel;
            $cartSessionHotel[$key]['totalpriceRoom'] = $totalpriceRoom;

            $totalGrand += $totalpriceRoom;
            $totalPriceHotel += $totalpriceRoom;
            //var_dump($cartSessionHotel);
            foreach ($value['room'] as $kr => $room) {
                $totalPriceDeposit += $room['payment_down_money'];
            }
        }
        $cartStore['HOTEL'] = $cartSessionHotel;
    }

    $assign_list['cartSessionHotel'] = $cartSessionHotel;
    #

    $cartSessionPackage = array();
    $totalRemaining = 0;
    if ($totalPriceDeposit > 0) {
        $totalPricePaymentNow = $totalPriceDeposit;
        $totalRemaining = $totalGrand - $totalPriceDeposit;
    } else {
        $totalPricePaymentNow = 0;
        $totalRemaining = $totalGrand;
    }
    #
    $assign_list["number_tour_id"] = $number_tour_id ?? 0;
    $assign_list["totalRemaining"] = $totalRemaining;
    $assign_list["totalGrand"] = $totalGrand;
    $assign_list["totalPriceTour"] = $totalPriceTour;
    $assign_list["totalPriceVoucher"] = $totalPriceVoucher;
    $assign_list["totalPriceCruise"] = $totalPriceCruise;
    $assign_list["totalPriceHotel"] = $totalPriceHotel;
    $assign_list["totalPricePaymentNow"] = $totalPricePaymentNow;
    $assign_list["departure_date"] = $departure_date ?? '';
    $assign_list["price_remaining"] = $price_remaining;
    $assign_list["totalPriceDeposit"] = $totalPriceDeposit;
    $assign_list["totalPricePromotion"] = $totalPricePromotion;
    $assign_list["totalPricePromotionCruise"] = $totalPricePromotionCruise;
    $assign_list["totalPricePromotionHotel"] = $totalPricePromotionHotel;
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
    #- Verify Captcha
    vnSessionDelVar('ContactInfoBooking');

    if (isset($_POST['booking']) && $_POST['booking'] == 'booking') {

        $cartSessionContactInfo = array();
        $err_msg = "";

        foreach ($_POST as $k => $v) {
            $tmp = explode('-', $k);
            if ($tmp[0] == 'tms') {
                $cartSessionContactInfo[$tmp[1]] = $v;
            }
            $assign_list[$k] = $v;
        }

        vnSessionSetVar('ContactInfoBooking', $cartSessionContactInfo);

        #- Verify Captcha
        $_csrf_token = vnSessionGetVar('csrf_token');
        $csrf_token = $_POST['csrf_token'];



        $timeCheck = 1 * 60 * 60;
        $time_now = time();
        $time_start = time() - $timeCheck;
        $checkBooking = $clsBooking->getAll("reg_date BETWEEN '$time_start' AND '$time_now'", $clsBooking->pkey . ', reg_date');
        $countCheckBooking = $checkBooking ? count($checkBooking) : 0;
        if (!$clsISO->verifyCsrfToken($csrf_token)) {
            $err_msg .= $core->get_Lang('You must not send spam') . '! <br />';
            // } else if ($countCheckBooking > 5) {
            //     $err_msg .= $core->get_Lang('You must not send spam') . '! <br />';
        } else if (!empty($_POST['iso_cms_booking'])) {
            $err_msg .= $core->get_Lang('You must not send spam') . '! <br />';
        }

        if ($err_msg == '') {
            $booking_id = $clsBooking->getMaxId();
            $booking_code = $clsBooking->generateBookingCode($booking_id, 'Cart');
            #
            $first_name = !empty($_POST['first_name']) ? $_POST['first_name'] : '';
            $last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : '';

            $fullname = $first_name . ' ' . $last_name;
            $f = "booking_id,title,contact_name,full_name,country_id,phone,email,gender,birthday";
            $f .= ",booking_code,cart_store,booking_store,booking_type,reg_date,ip_booking,totalgrand,deposit,balance,price_promotion,note,booking_array";

            $cart_store = serialize($cartStore);
            #
            $cartSessionContactInfo = vnSessionGetVar('ContactInfoBooking');
            $booking_store = serialize($cartSessionContactInfo);
            $title = Input::post('title', '');
            // $fullname = Input::post('fullname', '');
            $country_id = Input::post('country_id', 0);
            $telephone = Input::post('phone', '');
            $email = Input::post('email', '');
            $gender = Input::post('gender', '');
            $totalFinal = Input::post('totalFinal', 0);
            $customer_note = Input::post('note', '');
            $birthday = Input::post('birthday', '');
            #
            $v = "'$booking_id'
			,'" . $title . "'
			,'" . $fullname . "'
			,'" . $fullname . "'
			,'" . $country_id . "'
			,'" . $telephone . "'
			,'" . $email . "'
            ,'" . $gender . "'
            ,'" . $birthday . "'
			,'$booking_code'
			,'" . $cart_store . "'
			,'" . $booking_store . "'
			,'Cart','" . time() . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . $totalGrand . "'
			,'" . $totalPriceDeposit . "' 
			,'" . $totalRemaining . "'
			,'" . $totalPricePromotion . "'
            ,'" . $customer_note . "'
			,'" . serialize($_POST) . "'";
            #
            if (PAYMENT_GLOBAL) {
                $f .= ",payment_method";
                $v .= ",'" . intval($_POST['payment_method']) . "'";
            }

            if (_ISOCMS_CLIENT_LOGIN) {
                if (!empty($profile_id)) {
                    $f .= ",member_id";
                    $v .= ",'$profile_id'";
                }
            }

            if (_IS_TRAVEL_AGENT) {
                if (!empty($agent_id)) {
                    $f .= ",agent_id";
                    $v .= ",'$agent_id'";
                }
            }

            if ($clsBooking->insertOne($f, $v)) {
                foreach ($cartSessionService as $item) {
                    $number_adult = $item['number_adults_z'];
                    $number_child = $item['number_child_z'];
                    $total_number = $number_adult + $number_child;
                    $start_date = strtotime($item['check_in_book_z']);
                    $tour_start_date_id = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and tour_id='" . $item['tour_id_z'] . "' and start_date='" . $start_date . "'");
                    $tour_start_date_id = $tour_start_date_id[0]['tour_start_date_id'];
                    $available = $clsTourStartDate->getSeatAvailable($tour_start_date_id) - $total_number;
                    $clsTourStartDate->updateOne($tour_start_date_id, "seat_available='" . $available . "'");
                }
                $link_request = $_SERVER['REQUEST_URI'];
                vnSessionSetVar('rq_link', $link_request);
                if ($_POST['voucher_code']) {
                    $f1 = "first_name,last_name,promotion_code,email,ip,reg_date,is_trash";
                    $v1 = "'" . $first_name . "','" . $last_name . "','" . $_POST['voucher_code'] . "','" . $email . "','" . $_SERVER['REMOTE_ADDR'] . "'," . time() . ",0";
                    $clsVoucher->insertOne($f1, $v1);
                    $promotion_id = $clsPromotion->getByPromotionCode($_POST['voucher_code']);
                    $ticket = $clsPromotion->getDiscountValue($promotion_id, 2) - 1;
                    $discount_val_new = $clsPromotion->getUpdateDiscountValueTicket($promotion_id, $ticket);
                    $clsPromotion->updateOne($promotion_id, "discount_value='" . $discount_val_new . "'");
                }
                $clsISO->defer(function () use ($clsBooking, $booking_id) {
                    $clsBooking->sendEmailBookingCart($booking_id);
                });

                #
                $clsBooking->syncBookingTMS($booking_id);
                if (PAYMENT_GLOBAL) {
                    $clsBilling = new Billing();
                    $clsBilling->initPay($booking_id);
                } else {
                    vnSessionDelVar('BookingTour_' . $_LANG_ID);
                    vnSessionDelVar('BookingVoucher_' . $_LANG_ID);
                    vnSessionDelVar('BookingCruise_' . $_LANG_ID);
                    vnSessionDelVar('BookingHotel_' . $_LANG_ID);
                }

                header('location:' . $extLang . '/booking/booking_id=' . $booking_id . '&successful');
            } else {
                header('location:' . $extLang . '/booking/error');
            }
        } else {
            $assign_list["err_msg"] = $err_msg;
            foreach ($_POST as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
    }

    $clsCountryBK = new _Country();
    $assign_list["clsCountryBK"] = $clsCountryBK;
    $lstCountry = $clsCountryBK->getAll("is_trash=0 order by order_no asc", $clsCountryBK->pkey . ",title");

    $assign_list["lstCountry"] = $lstCountry;
    unset($lstCountry);

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Shopping Cart') . ' | ' . $core->get_Lang('Booking') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
    /*=============Content Page==================*/
}

function default_success()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsConfiguration;
    #
    $clsBooking = new Booking();
    $assign_list['clsBooking'] = $clsBooking;

    $clsFeedback = new Feedback();
    $assign_list['clsFeedback'] = $clsFeedback;

    $show = Input::get('show', '');
    $assign_list["show"] = $show;

    $booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : 0;
    $oneBooking = $clsBooking->getAll("booking_id='$booking_id' and clsTable='Tour'");

    if ($show == 'Feedback') {
        $feedback_id = Input::get('feedback_id', 0);
        $oneFeedback = $clsFeedback->getOne($feedback_id, 'email,fullname');
        $messageFeedbackSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_FeedbackSuccess_' . $_LANG_ID);
        $messageFeedbackSuccess = html_entity_decode($messageFeedbackSuccess);
        $messageFeedbackSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $oneFeedback['fullname'], $messageFeedbackSuccess);
        $messageFeedbackSuccess = str_replace('[%CUSTOMER_EMAIL%]', $oneFeedback['email'], $messageFeedbackSuccess);
        $assign_list['messageFeedbackSuccess'] = $messageFeedbackSuccess;
    } elseif ($show == 'bookCruise') {
        $messageSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_CruiseSuccess_' . $_LANG_ID);
        $messageSuccess = html_entity_decode($messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $clsBooking->getFullName($booking_id), $messageSuccess);
        $assign_list['SiteMsgCruiseSuccess'] = $messageSuccess;
    } elseif ($show == 'bookHotel') {
        $messageSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_HotelSuccess_' . $_LANG_ID);
        $messageSuccess = html_entity_decode($messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $clsBooking->getFullName($booking_id), $messageSuccess);
        $assign_list['SiteMsgHotelSuccess'] = $messageSuccess;
    } elseif ($show == 'bookTailor') {
        $messageSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_TailorSuccess_' . $_LANG_ID);
        $messageSuccess = html_entity_decode($messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $clsBooking->getFullName($booking_id), $messageSuccess);
        $messageSuccess = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $messageSuccess);
        $assign_list['SiteMsgTailorSuccess'] = $messageSuccess;
    } elseif ($show == 'Bookingservices') {
        $messageSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_ServicesSuccess_' . $_LANG_ID);
        $messageSuccess = html_entity_decode($messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $clsBooking->getFullName($booking_id), $messageSuccess);
        $assign_list['SiteMsgServiceSuccess'] = $messageSuccess;
    } else {
        $messageSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_TourSuccess_' . $_LANG_ID);
        $messageSuccess = html_entity_decode($messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_EMAIL%]', $clsBooking->getEmailSuccess($booking_id), $messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $clsBooking->getFullName($booking_id), $messageSuccess);
        $messageSuccess = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $messageSuccess);
        $assign_list['SiteMsgTourSuccess'] = $messageSuccess;
    }

    vnSessionDelVar('BookingTour_' . $_LANG_ID);
    vnSessionDelVar('BookingVoucher_' . $_LANG_ID);
    vnSessionDelVar('BookingCruise_' . $_LANG_ID);
    vnSessionDelVar('BookingHotel_' . $_LANG_ID);

    /*=============Title & Description Page==================*/
    $title_page = $core->get_Lang('Success') . ' | ' . PAGE_NAME;
    $assign_list["title_page"] = $title_page;
    $description_page = $title_page;
    $assign_list["description_page"] = $description_page;
    $keyword_page = $title_page;
    $assign_list["keyword_page"] = $keyword_page;
}
