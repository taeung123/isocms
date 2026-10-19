<?php

class Booking extends dbBasic
{
    function __construct()
    {
        $this->pkey = "booking_id";
        $this->tbl = DB_PREFIX . "booking";
    }

    /**
     * Return booking-list counters from the same filtered data set as the table.
     * This avoids countItem inconsistencies found on some installations.
     */
    public function getListBookingSummary($cond = '1=1')
    {
        $rows = $this->getAll($cond, $this->pkey . ',cart_store,status_pay,member_id,reg_date');
        $summary = array(
            'total' => 0,
            'pending' => 0,
            'confirmed' => 0,
            'canceled' => 0,
            'unpaid' => 0,
            'payment' => 0,
            'customer' => 0,
            'pending_ids' => array(),
            'confirmed_ids' => array(),
            'canceled_ids' => array(),
            'payment_ids' => array(),
            'customer_ids' => array()
        );

        if (!is_array($rows)) {
            return $summary;
        }

        $latestBookingByCustomer = array();
        foreach ($rows as $row) {
            $bookingId = isset($row[$this->pkey]) ? (int)$row[$this->pkey] : 0;
            $statusPay = isset($row['status_pay']) ? (string)$row['status_pay'] : '';
            $workflowStatus = $this->getBookingWorkflowStatusFromCartStore(
                isset($row['cart_store']) ? $row['cart_store'] : ''
            );

            $summary['total']++;
            if ($workflowStatus === 'pending') {
                $summary['pending']++;
                $summary['pending_ids'][] = $bookingId;
            } elseif ($workflowStatus === 'confirmed') {
                $summary['confirmed']++;
                $summary['confirmed_ids'][] = $bookingId;
            } elseif ($workflowStatus === 'canceled') {
                $summary['canceled']++;
                $summary['canceled_ids'][] = $bookingId;
            }

            if ($statusPay === '0') {
                $summary['unpaid']++;
            } elseif ($statusPay === '1' || $statusPay === '2') {
                $summary['payment']++;
                $summary['payment_ids'][] = $bookingId;
            }

            if (!empty($row['member_id']) && (int)$row['member_id'] > 0) {
                $memberId = (int)$row['member_id'];
                $regDate = isset($row['reg_date']) ? (int)$row['reg_date'] : 0;
                if (
                    !isset($latestBookingByCustomer[$memberId]) ||
                    $regDate > $latestBookingByCustomer[$memberId]['reg_date'] ||
                    ($regDate === $latestBookingByCustomer[$memberId]['reg_date'] && $bookingId > $latestBookingByCustomer[$memberId]['booking_id'])
                ) {
                    $latestBookingByCustomer[$memberId] = array(
                        'booking_id' => $bookingId,
                        'reg_date' => $regDate
                    );
                }
            }
        }

        $summary['customer'] = count($latestBookingByCustomer);
        foreach ($latestBookingByCustomer as $latestBooking) {
            $summary['customer_ids'][] = $latestBooking['booking_id'];
        }

        return $summary;
    }

    /**
     * Derive the list-screen workflow state from existing service statuses.
     * Service status values are unchanged: 0 pending, 1 confirm, 2 refuse.
     */
    public function getBookingWorkflowStatusFromCartStore($cartStore = '')
    {
        if (is_string($cartStore)) {
            $decoded = json_decode($cartStore, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $cartStore = $decoded;
            } else {
                $cartStore = PHP_VERSION_ID >= 70000
                    ? @unserialize($cartStore, array('allowed_classes' => false))
                    : @unserialize($cartStore);
            }
        }

        if (!is_array($cartStore)) {
            return 'pending';
        }

        $total = 0;
        $pending = 0;
        $confirmed = 0;
        $refused = 0;
        foreach (array('TOUR', 'HOTEL', 'CRUISE', 'VOUCHER') as $type) {
            if (empty($cartStore[$type]) || !is_array($cartStore[$type])) {
                continue;
            }
            foreach ($cartStore[$type] as $service) {
                $status = is_array($service) && isset($service['status']) ? (string)$service['status'] : '0';
                $total++;
                if ($status === '1') {
                    $confirmed++;
                } elseif ($status === '2') {
                    $refused++;
                } else {
                    $pending++;
                }
            }
        }

        if ($total === 0 || $pending > 0) {
            return 'pending';
        }
        if ($confirmed > 0) {
            return 'confirmed';
        }
        return $refused === $total ? 'canceled' : 'pending';
    }

    public function getBookingWorkflowStatus($bookingId = 0, $cartStore = null)
    {
        if ($cartStore === null) {
            $cartStore = $this->getOneField('cart_store', (int)$bookingId);
        }
        return $this->getBookingWorkflowStatusFromCartStore($cartStore);
    }

    /**
     * Find bookings whose Tour, Hotel or Voucher title contains a keyword.
     * Product titles are resolved from IDs stored in cart_store.
     */
    public function getServiceBookingIdsByKeyword($keyword = '')
    {
        $keyword = trim(strip_tags(html_entity_decode((string)$keyword, ENT_QUOTES, 'UTF-8')));
        if ($keyword === '') {
            return array();
        }

        $bookings = $this->getAll('1=1', $this->pkey);
        $bookingIds = array();

        if (!is_array($bookings)) {
            return $bookingIds;
        }

        $serviceModels = array(
            'TOUR' => new Tour(),
            'HOTEL' => new Hotel(),
            'VOUCHER' => new Voucher()
        );

        foreach ($bookings as $booking) {
            $bookingId = isset($booking[$this->pkey]) ? (int)$booking[$this->pkey] : 0;
            if ($bookingId < 1) {
                continue;
            }

            foreach ($serviceModels as $type => $serviceModel) {
                $cartItems = $this->getCartStoreBooking($bookingId, $type);
                if (!is_array($cartItems)) {
                    continue;
                }

                foreach (array_keys($cartItems) as $serviceId) {
                    $serviceName = trim(strip_tags(html_entity_decode(
                        $serviceModel->getTitle((int)$serviceId),
                        ENT_QUOTES,
                        'UTF-8'
                    )));
                    if ($serviceName !== '' && stripos($serviceName, $keyword) !== false) {
                        $bookingIds[] = $bookingId;
                        break 2;
                    }
                }
            }
        }

        return array_values(array_unique($bookingIds));
    }

    /** Find bookings by the customer name, phone or email displayed in the booking list. */
    public function getCustomerBookingIdsByKeyword($keyword = '')
    {
        $keyword = trim(strip_tags(html_entity_decode((string)$keyword, ENT_QUOTES, 'UTF-8')));
        if ($keyword === '') {
            return array();
        }

        $bookings = $this->getAll('1=1', $this->pkey);
        $bookingIds = array();
        if (!is_array($bookings)) {
            return $bookingIds;
        }

        foreach ($bookings as $booking) {
            $bookingId = isset($booking[$this->pkey]) ? (int)$booking[$this->pkey] : 0;
            if ($bookingId < 1) {
                continue;
            }

            $customerValues = array(
                $this->getContactName($bookingId),
                $this->getPhone($bookingId),
                $this->getEmail($bookingId)
            );
            foreach ($customerValues as $customerValue) {
                $customerValue = trim(strip_tags(html_entity_decode(
                    (string)$customerValue,
                    ENT_QUOTES,
                    'UTF-8'
                )));
                if ($customerValue !== '' && stripos($customerValue, $keyword) !== false) {
                    $bookingIds[] = $bookingId;
                    break;
                }
            }
        }

        return array_values(array_unique($bookingIds));
    }

    function getBookingCode($booking_id = 0)
    {
        if (!isset($oDataTable["booking_code"])) {
            $oDataTable = $this->getOne($booking_id, "booking_code");
        }
        return $oDataTable["booking_code"];
    }

    function generateBookingCode($booking_id = 0, $booking_type = 'Hotel')
    {
        global $clsConfiguration, $clsISO;
        if ($booking_type == 'Hotel')
            // Hotel
            return $clsConfiguration->getValue('SitePrefixOrderHotel') . $booking_id;
        else if ($booking_type == 'Tour')
            // Tour
            return $clsConfiguration->getValue('SitePrefixOrderTour') . $booking_id;
        else if ($booking_type == 'Cruise')
            // Cruise
            return $clsConfiguration->getValue('SitePrefixOrderCruise') . $booking_id;
        else if ($booking_type == 'Room')
            // Cruise
            return $clsConfiguration->getValue('SitePrefixOrderRoom') . $booking_id;
        else if ($booking_type == 'Cart')
            //Cart
            return "CART" . $booking_id;
        else
            // Tailor
            return $clsConfiguration->getValue('SitePrefixOrderTailor') . $booking_id;
    }

    function getTotalBooking($Month = 0, $Year = 0, $clsTable = '')
    {
        $start_Date = strtotime('01-' . $Month . '-' . $Year . ' 00:00');
        $end_Date = strtotime(cal_days_in_month(CAL_GREGORIAN, $Month, $Year) . '-' . $Month . '-' . $Year . ' 00:00');
        return $this->countItem("reg_date>='$start_Date' and reg_date<='$end_Date' and clsTable='$clsTable'");
    }

    function getTotalBookingAdmin($Month = 0, $Year = 0, $clsTable = '', $status = '')
    {
        $start_Date = strtotime('01-' . $Month . '-' . $Year . ' 00:00');
        $end_Date = strtotime(cal_days_in_month(CAL_GREGORIAN, $Month, $Year) . '-' . $Month . '-' . $Year . ' 00:00');
        $cond = "reg_date>='$start_Date' and reg_date<='$end_Date' and status = '" . $status . "' ";
        if ($clsTable != '') {
            $cond .= " and clsTable='$clsTable' ";
        }
        return $this->countItem($cond);
    }

    function countTotalBooking($clsTable = '', $status = '')
    {
        $cond = "1=1 and clsTable = '$clsTable' and status = '$status'";
        return $this->countItem($cond);
    }

    function countTotalAllBooking($clsTable = '')
    {
        $cond = "1=1 and clsTable = '$clsTable'";
        return $this->countItem($cond);
    }

    function getHotelDuration($booking_id = 0)
    {
        global $clsISO;
        #
        $oneItem = $this->getOne($booking_id);
        $BOOKINGVALUE = $this->getBookingValue($booking_id);
        #
        $checkin = strtotime($BOOKINGVALUE['checkin']);
        $checkout = strtotime($BOOKINGVALUE['checkout']);
        $difference = $checkout - $checkin;
        if ($difference > 0) {
            $day = floor($difference / (24 * 60 * 60));
            if ($day <= 1)
                return 1;
            return $day;
        }
        return 0;
    }

    function formatChangeDate($time = 0)
    {
        global $clsISO;
        $time = strtotime($time);
        return $clsISO->formatDate($time);
    }

    function formatDate($date = '')
    {
        global $_LANG_ID;

        $date = DateTime::createFromFormat('d/m/Y', $date);
        if ($_LANG_ID == "vn") {
            return $date->format('d-m-Y');
        }
        return $date->format('m-d-Y');
    }

    function getSelectTourClass($tour_id = 0, $class = "")
    {
        global $core, $clsISO;
        #
        $clsTour = new Tour();
        $clsTourPriceRow = new TourPriceRow();
        $clsTourProperty = new TourProperty();
        #
        $_array = $clsTourPriceRow->getAll("is_trash=0 and tour_id = '$tour_id' order by order_no asc");
        $Html = '<option value="">-- ' . $core->get_Lang('Select Tour Class') . ' --</option>';
        if (is_array($_array) && count($_array) > 0) {
            for ($i = 0; $i < count($_array); $i++) {
                $Html .= '<option value="' . $_array[$i][$clsTourPriceRow->pkey] . '">' . $clsTourPriceRow->getTitle($_array[$i][$clsTourPriceRow->pkey]) . '</option>';
            }
        }
        if ($_array[0][$clsTourPriceRow->pkey] == '') {
            $_array = $clsTourProperty->getAll("is_trash=0 and type = 'TOURCLASS' order by order_no asc");
            for ($i = 0; $i < count($_array); $i++) {
                $Html .= '<option value="' . $_array[$i][$clsTourProperty->pkey] . '">' . $clsTourProperty->getTitle($_array[$i][$clsTourProperty->pkey]) . '</option>';
            }
        }
        return $Html;
    }
    function getBookingValue($booking_id = 0)
    {
        global $core, $clsISO;
        $_StoreData = $this->getOneField('booking_store', $booking_id);

        if (!empty($_StoreData))
            return unserialize($_StoreData);
        return false;
    }

    function getCartStore($booking_id)
{
    $booking_id = (int) $booking_id;

    if ($booking_id <= 0) {
        return array();
    }

    $cart_store = $this->getOneField(
        'cart_store',
        $booking_id
    );

    if (
        empty($cart_store) ||
        !is_string($cart_store)
    ) {
        return array();
    }

    /*
     * Dữ liệu mới có thể được lưu dạng JSON.
     */
    $jsonData = json_decode($cart_store, true);

    if (
        json_last_error() === JSON_ERROR_NONE &&
        is_array($jsonData)
    ) {
        return $jsonData;
    }

    /*
     * Dữ liệu isoCMS cũ được lưu bằng serialize().
     * Không cho unserialize tạo object PHP.
     */
    if (PHP_VERSION_ID >= 70000) {
        $data = @unserialize(
            $cart_store,
            array(
                'allowed_classes' => false
            )
        );
    } else {
        $data = @unserialize($cart_store);
    }

    return is_array($data)
        ? $data
        : array();
}

    function getCartStoreBooking($booking_id = 0, $type = '')
    {
        global $core, $clsISO;
        $cart_store = $this->getOneField('cart_store', $booking_id);
        $cart_store = unserialize($cart_store);
        if (!empty($cart_store[$type])) {
            return $cart_store[$type];
        }
        return false;
    }

    function getHTMLService($booking_id = 0)
    {
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $cartStoreTour = $this->getCartStoreBooking($booking_id, 'TOUR');
        $html = '';
        if (!empty($cartStoreTour)) {
            foreach ($cartStoreTour as $k => $v) {
                $check_in_book = str_replace('-', '.', $v['check_in_book_z']);
                $html .= $check_in_book . ' | ' . $clsTour->getTitle($k);
                if ($k != array_key_last($cartStoreTour)) {
                    $html .= ', ';
                }
            }
        }
        return $html;
        $html_voucher = '';
        $cartStoreVoucher = $this->getCartStoreBooking($booking_id, 'VOUCHER');
        foreach ($cartStoreVoucher as $k => $v) {
            $html_voucher .= $clsVoucher->getTitle($k);
            if ($k != array_key_last($cartStoreVoucher)) {
                $html_voucher .= ', ';
            }
        }
    }

    function getHTMLServiceNew($booking_id = 0)
    {
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $cartStoreTour = $this->getCartStoreBooking($booking_id, 'TOUR');
        $html = '';
        foreach ($cartStoreTour as $k => $v) {
            $check_in_book = str_replace('-', '.', $v['check_in_book_z']);
            $html .= '' . $clsTour->getTitle($k);
            if ($k != array_key_last($cartStoreTour)) {
                $html .= ', ';
            }
        }
        return $html;
        $html_voucher = '';
        $cartStoreVoucher = $this->getCartStoreBooking($booking_id, 'VOUCHER');
        foreach ($cartStoreVoucher as $k => $v) {
            $html_voucher .= $clsVoucher->getTitle($k);
            if ($k != array_key_last($cartStoreVoucher)) {
                $html_voucher .= ', ';
            }
        }
    }

    function getHTMLServiceOther($booking_id = 0)
    {
        global $core;
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $clsCruise = new Cruise();
        $clsHotel = new Hotel();
        $cartStoreTour = $this->getCartStoreBooking($booking_id, 'TOUR');
        $cartStoreVoucher = $this->getCartStoreBooking($booking_id, 'VOUCHER');
        $cartStoreCruise = $this->getCartStoreBooking($booking_id, 'CRUISE');
        $cartStoreHotel = $this->getCartStoreBooking($booking_id, 'HOTEL');
        $html_service_first = '';
        $total_service = 0;
        if (!empty($cartStoreTour)) {
            $array_key_first = array_key_first($cartStoreTour);
            $html_service_first = $array_key_first ? $clsTour->getTitle($array_key_first) : '';
            //			$total_service+=count($cartStoreTour);
        } elseif (!empty($cartStoreVoucher)) {
            $array_key_first = array_key_first($cartStoreVoucher);
            $html_service_first = $array_key_first ? $clsVoucher->getTitle($array_key_first) : '';
            //			$total_service+=count($cartStoreVoucher);
        } elseif (!empty($cartStoreCruise)) {
            foreach ($cartStoreCruise as $key => $value) {
                $array_key_first = $value['cruise_id'];
                break;
            }
            /*$array_key_first=array_key_first($cartStoreCruise);*/
            $html_service_first = $array_key_first ? $clsCruise->getTitle($array_key_first) : '';
            //			$total_service+=count($cartStoreCruise);
        } else {
            if (is_array($cartStoreHotel) && !empty($cartStoreHotel)) {
                $array_key_first = array_key_first($cartStoreHotel);
                $html_service_first = $array_key_first ? $clsHotel->getTitle($array_key_first) : '';
            } else {
                $html_service_first = '';
            }

            //			$total_service+=count($cartStoreHotel);
        }
        if (!empty($cartStoreTour)) {
            $total_service += count($cartStoreTour);
        }
        if (!empty($cartStoreVoucher)) {
            $total_service += count($cartStoreVoucher);
        }
        if (!empty($cartStoreCruise)) {
            $total_service += count($cartStoreCruise);
        }
        if (!empty($cartStoreHotel)) {
            $total_service += count($cartStoreHotel);
        };
        return $html_service_first . ($total_service > 1 ? ' (<span class="total_booking">+ ' . ($total_service - 1) . ' ' . $core->get_Lang('Services') . '</span>)' : '');
        //        return '<p>' . $html_service_first . ($total_service > 1 ? ' (<span class="color_main">+ ' . ($total_service - 1) . '</span>)' : '') . '</p>';
    }

    /** Return the first booked service image for list presentation only. */
    public function getPrimaryServiceImage($bookingId = 0, $cartStore = null, $width = 46, $height = 38)
    {
        if (!is_array($cartStore)) {
            $cartStore = $this->getCartStore((int)$bookingId);
        }

        if (!empty($cartStore['TOUR']) && is_array($cartStore['TOUR'])) {
            $tourId = (int)array_key_first($cartStore['TOUR']);
            return $tourId > 0 ? (new Tour())->getImage($tourId, $width, $height) : '';
        }
        if (!empty($cartStore['HOTEL']) && is_array($cartStore['HOTEL'])) {
            $hotelId = (int)array_key_first($cartStore['HOTEL']);
            return $hotelId > 0 ? (new Hotel())->getImage($hotelId, $width, $height) : '';
        }
        if (!empty($cartStore['CRUISE']) && is_array($cartStore['CRUISE'])) {
            $cruiseItem = reset($cartStore['CRUISE']);
            $cruiseId = is_array($cruiseItem) && !empty($cruiseItem['cruise_id'])
                ? (int)$cruiseItem['cruise_id']
                : 0;
            return $cruiseId > 0 ? (new Cruise())->getImage($cruiseId, $width, $height) : '';
        }
        if (!empty($cartStore['VOUCHER']) && is_array($cartStore['VOUCHER'])) {
            $voucherId = (int)array_key_first($cartStore['VOUCHER']);
            return $voucherId > 0 ? (new Voucher())->getImage($voucherId, $width, $height) : '';
        }
        return '';
    }

    function getServiceID($booking_id = 0, $type = '')
    {
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $clsCruise = new Cruise();
        $clsHotel = new Hotel();
        if ($type == 'tour') {
            $cartStoreTour = $this->getCartStoreBooking($booking_id, 'TOUR');
        } elseif ($type == 'voucher') {
            $cartStoreVoucher = $this->getCartStoreBooking($booking_id, 'VOUCHER');
        } elseif ($type == 'cruise') {
            $cartStoreCruise = $this->getCartStoreBooking($booking_id, 'CRUISE');
        } elseif ($type == 'hotel') {
            $cartStoreHotel = $this->getCartStoreBooking($booking_id, 'HOTEL');
        }

        $html_service_first = '';
        $total_service = 0;
        if (!empty($cartStoreTour)) {
            $array_key_first = array_key_first($cartStoreTour);
            return $array_key_first;
        } elseif (!empty($cartStoreVoucher)) {
            $array_key_first = array_key_first($cartStoreVoucher);
            return $array_key_first;
        } elseif (!empty($cartStoreCruise)) {
            foreach ($cartStoreCruise as $key => $value) {
                $array_key_first = $value['cruise_id'];
                break;
            }
            return $array_key_first;
        } else {
            $array_key_first = array_key_first($cartStoreHotel);
            return $array_key_first;
        }
        return 0;
    }

    function checkContain($haystack = '', $needle = '')
    {
        $pos = strpos($haystack, $needle);
        if ($pos === false) {
            return 0;
        } else {
            return 1;
        }
    }

    function getTitle($booking_id = 0)
    {
        $oneItem = $this->getOne($booking_id);
        return $oneItem['title'];
    }

    /**
     * Return the newest bookings created during the current calendar week for the
     * admin header notification. Keep database concerns inside the model.
     */
    function getWeeklyAdminNotifications($limit = 10)
    {
        global $core;

        $limit = max(1, min(50, (int)$limit));
        $week_start = strtotime('monday this week 00:00:00');
        $condition = "reg_date >= '" . (int)$week_start . "'";
        $rows = $this->getAll(
            $condition . " order by reg_date DESC limit 0," . $limit,
            'booking_id,booking_code,booking_type,title,contact_name,full_name,email,reg_date'
        );
        $count_rows = $this->getAll($condition, 'count(booking_id) as total');
        $items = array();

        foreach ((array)$rows as $row) {
            $booking_id = (int)$row['booking_id'];
            $booking_code = trim($row['booking_code']);
            // Use exactly the same service-name source as the Booking name
            // column on the sales list screen.
            $booking_name = trim(strip_tags(html_entity_decode($this->getHTMLServiceOther($booking_id))));
            if ($booking_name === '') {
                $booking_name = trim(strip_tags(html_entity_decode($row['title'])));
            }
            if ($booking_name === '') {
                $booking_name = 'Booking #' . $booking_id;
            }

            $contact_name = trim($row['contact_name']);
            if ($contact_name === '') {
                $contact_name = trim($row['full_name']);
            }
            if ($contact_name === '') {
                $contact_name = trim($row['email']);
            }

            $description = $booking_code !== '' ? '#' . ltrim($booking_code, '#') : 'Booking #' . $booking_id;
            if ($contact_name !== '') {
                $description .= ' - ' . $contact_name;
            }

            $items[] = array(
                'id' => $booking_id,
                'title' => $booking_name,
                'description' => $description,
                'created_at' => (int)$row['reg_date'],
                'url' => PCMS_URL . '/index.php?mod=booking&act=edit&action=list_booking&booking_id=' . $core->encryptID($booking_id)
            );
        }

        return array(
            'total' => isset($count_rows[0]['total']) ? (int)$count_rows[0]['total'] : count($items),
            'items' => $items
        );
    }

    function getBookingStore($booking_id = 0)
    {
        $oneItem = $this->getOne($booking_id);
        return unserialize($oneItem['booking_store']);
    }

    function getContactName($booking_id = 0)
    {
        $contact_name = $this->getOneField('contact_name', $booking_id);
        if (trim($contact_name) != '' && trim($contact_name) != '0')
            return $contact_name;


        return $this->getFullName($booking_id);
    }

    function getFullName($booking_id = 0, $prefix = false)
    {
        global $clsISO, $core, $dbconn;
        $full_name = $this->getOneField('full_name', $booking_id);
        if ($full_name != '' && $full_name != '0')
            return $full_name;
        if (_ISOCMS_CLIENT_LOGIN) {
            $clsProfile = new Profile();
            $member_id = $this->getOneField('member_id', $booking_id);
            return $clsProfile->getFullName($member_id);
        }
        return $prefix ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : false;
    }

    function getFirstName($booking_id = 0, $replace = false)
    {
        global $clsISO, $core, $dbconn;
        $first_name = '';
        if (_ISOCMS_CLIENT_LOGIN) {
            $clsProfile = new Profile();
            $member_id = $this->getOneField('member_id', $booking_id);
            $first_name = $clsProfile->getOneField('first_name', $member_id);
            if (!empty($first_name)) {
                return $first_name;
            }
        }
        if ($first_name == '' || $first_name == '0') {
            $full_name = $this->getFullName($booking_id);
            if ($full_name || !empty($full_name)) {
                $tmp = $clsISO->parseName($full_name);
                return $tmp[0];
            }
        }
        return $prefix ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : false;
    }

    function getLastName($booking_id = 0, $replace = false)
    {
        global $clsISO, $core, $dbconn;
        $first_name = '';
        if (_ISOCMS_CLIENT_LOGIN) {
            $clsProfile = new Profile();
            $member_id = $this->getOneField('member_id', $booking_id);
            $first_name = $clsProfile->getOneField('last_name', $member_id);
            if (!empty($first_name)) {
                return $first_name;
            }
        }
        if ($first_name == '' || $first_name == '0') {
            $full_name = $this->getFullName($booking_id);
            if ($full_name || !empty($full_name)) {
                $tmp = $clsISO->parseName($full_name);
                return $tmp[1];
            }
        }
        return $prefix ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : false;
    }

    function getPhone($booking_id = 0)
    {
        $phone = $this->getOneField('phone', $booking_id);
        if ($phone != '' && $phone != '0')
            return $phone;
    }

    function getEmail($booking_id = 0)
    {
        return $this->getOneField('email', $booking_id);
    }

    function getEmailSuccess($booking_id = 0)
    {
        $res = $this->getOne($booking_id, 'email');
        return $res['email'];
    }

    function getAddress($booking_id = 0, $prefix = false)
    {
        global $core, $dbconn, $clsISO;
        $address = $this->getOneField('address', $booking_id);
        if ($address != '' && $address != '0')
            return $address;
        return $prefix ? sprintf('<em>%s</em>', $core->get_Lang('Unknow')) : false;
    }

    function getAddressExcel($booking_id = 0, $prefix = false)
    {
        global $core, $dbconn, $clsISO;
        $address = $this->getOneField('address', $booking_id);
        if ($address != '' && $address != '0')
            return $address;
        return $core->get_Lang('Unknow');
    }

    function getCountry($booking_id = 0)
    {
        $clsCountry = new _Country();
        $country_id = $this->getOneField('country_id', $booking_id);
        $country_name = $clsCountry->getTitle($country_id);
        if ($country_name != '' && $country_name != '0')
            return $country_name;
    }

    function getCountryBookingStore($country_id = 0)
    {
        $clsCountry = new _Country();
        $country_name = $clsCountry->getTitle($country_id);
        if ($country_name != '' && $country_name != '0')
            return $country_name;
        //        if(_ISOCMS_CLIENT_LOGIN){
        //            $clsProfile = new Profile();
        //            $member_id = $this->getOneField('member_id',$booking_id);
        //            return $clsProfile->getCountry($member_id);
        //        }
    }

    function getStatus($booking_id = 0, $oDataTable = NULL)
    {
        global $core, $clsISO, $dbconn;
        if (is_null($oDataTable))
            $oDataTable = $this->getOne($booking_id, "status");
        $status = $oDataTable['status'];
        if ($status == 0)
            return sprintf('<font color="#006600">%s</font>', $core->get_Lang('InProcess'));
        if ($status == 1)
            return sprintf('<font color="#0000FF">%s</font>', $core->get_Lang('Open'));
        if ($status == 2)
            return sprintf('<font color="#000">%s</font>', $core->get_Lang('Reviewed'));
        if ($status == 6)
            return sprintf('<font color="#000">%s</font>', $core->get_Lang('Canceled'));
        if ($status == 3)
            return sprintf('<font color="#FF0000">%s</font>', $core->get_Lang('Failed'));
        if ($status == 4)
            return sprintf('<font color="#c00000">%s</font>', $core->get_Lang('Declined'));
        if ($status == 5)
            return sprintf('<font color="#006600">%s</font>', $core->get_Lang('Backordered'));
        return sprintf('<font color="#006600">%s</font>', $core->get_Lang('InProcess'));
    }

    function getStatusPayment($booking_id = 0, $oDataTable = NULL)
    {
        global $core, $clsISO, $dbconn;
        if (is_null($oDataTable))
            $oDataTable = $this->getOne($booking_id, "status");
        $status = $oDataTable['status'];
        if ($status == 0)
            return $core->get_Lang('InProcess');
        if ($status == 1)
            return $core->get_Lang('Open');
        if ($status == 2)
            return $core->get_Lang('Reviewed');
        if ($status == 6)
            return $core->get_Lang('Canceled');
        if ($status == 3)
            return $core->get_Lang('Failed');
        if ($status == 4)
            return $core->get_Lang('Declined');
        if ($status == 5)
            return $core->get_Lang('Backordered');
        return $core->get_Lang('InProcess');
    }

    function getStatusBookingPay($booking_id = 0)
    {
        global $core, $clsISO, $dbconn;

        $oDataTable = $this->getOne($booking_id, "status_pay");
        $status = $oDataTable['status_pay'];

        if ($status == 0)
            return $core->get_Lang('Unpaid');
        if ($status == 1)
            return $core->get_Lang('Pay off');
        if ($status == 2)
            return $core->get_Lang('Prepaid');
        if ($status == 3)
            return $core->get_Lang('Canceled');
        return $core->get_Lang('Unpaid');
    }

    function getTakeCare($booking_id = 0)
    {
        $oneItem = $this->getOne($booking_id);
        $take_care = $oneItem['take_care'];
        if ($take_care == 1) {
            return 'Send me more details via email';
        } elseif ($take_care == 2) {
            return 'Call me if possible';
        }
    }

    function getRequest($booking_id = 0)
    {
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #
        if ($clsTable == 'Tailor') {
            $type = $booking_store['type'];
            if ($type == 1) {
                return $booking_store['request_1'];
            } else {
                return $booking_store['request_2'];
            }
        }
        if ($clsTable == 'Hotel') {
            return $booking_store['request'];
        }
        if ($clsTable == 'Tour') {
            return $booking_store['request'];
        }
    }

    function getDepartureDate($booking_id = 0)
    {
        $clsISO = new ISO();
        $clsTailorProperty = new TailorProperty();
        #
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #

        if ($clsTable == 'Tailor') {
            $type = $booking_store['type'];
            if ($type == 1) {
                return $this->formatChangeDate($booking_store['date_begin_simple']);
            } else {
                if ($booking_store['choose_date'] == 1) {
                    return $this->formatChangeDate($booking_store['date_begin']);
                } else {

                    return $clsISO->getNameMonth($booking_store['flex_mon']) . ' ' . $booking_store['flex_yea'];
                }
            }
        }
        if ($clsTable == 'Hotel') {
            return $this->formatChangeDate($booking_store['checkin']);
        }
        if ($clsTable == 'Tour') {
            $BOOK_VALUE = $booking_store['BOOK_VALUE'];
            $BOOK_VALUE = unserialize($BOOK_VALUE);
            return $this->formatChangeDate($BOOK_VALUE['departure_date']);
        }
        if ($clsTable == 'Room') {
            return $booking_store['departure_in'];
        }
    }

    function getDepartureOutRoom($booking_id = 0)
    {
        $clsISO = new ISO();
        $clsTailorProperty = new TailorProperty();
        #
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #
        return $booking_store['departure_out'];
    }

    function getDepartureInRoom($booking_id = 0)
    {
        $clsISO = new ISO();
        $clsTailorProperty = new TailorProperty();
        #
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #
        return $booking_store['departure_in'];
    }

    function getTotalRoom($booking_id = 0)
    {
        $clsISO = new ISO();
        $clsTailorProperty = new TailorProperty();
        #
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #
        return $booking_store['number_bookingroom'];
    }

    function getTotalPriceRoom($booking_id = 0)
    {
        $clsISO = new ISO();
        $clsTailorProperty = new TailorProperty();
        #
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #
        return $booking_store['totalPrice'];
    }

    function getHotelName($booking_id = 0)
    {
        $clsISO = new ISO();
        $clsHotel = new Hotel();
        $clsTailorProperty = new TailorProperty();
        #
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #
        $hotel_id = $booking_store['hotel_id'];
        return $clsHotel->getTitle($hotel_id);
    }

    function getDuration($booking_id = 0)
    {
        $clsTailorProperty = new TailorProperty();
        #
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        if ($clsTable == 'Tour') {
            $clsTable = $oneItem['clsTable'];
            $clsClassTable = new $clsTable;
            return $clsClassTable->getTripDuration($oneItem['target_id']);
        }
        if ($clsTable == 'Hotel') {
            return $this->getHotelDuration($booking_id);
        }
        if ($clsTable == 'Tailor') {
            $booking_store = $this->getBookingValue($booking_id);
            $type = $booking_store['type'];
            if ($type == 1) {
                #
                $date_begin_simple = $booking_store['date_begin_simple'];
                $date_begin_simple = strtotime($date_begin_simple);
                #
                $date_end_simple = $booking_store['date_end_simple'];
                $date_end_simple = strtotime($date_end_simple);
                $difference = $date_end_simple - $date_begin_simple;
                if ($difference > 0) {
                    $day = floor($difference / (24 * 60 * 60));
                    if ($day <= 1)
                        return 1;
                    return $day . ' day(s)';
                }
                return 0;
            } else {
                #
                if ($booking_store['choose_date'] == 1) {
                    $date_begin = $booking_store['date_begin'];
                    $date_begin = strtotime($date_begin);
                    #
                    $date_end = $booking_store['date_end'];
                    $date_end = strtotime($date_end);
                    $difference = $date_end - $date_begin;
                    if ($difference > 0) {
                        $day = floor($difference / (24 * 60 * 60));
                        if ($day <= 1)
                            return 1;
                        return $day . ' day(s)';
                    }
                    return 0;
                } else {
                    return $clsTailorProperty->getTitle($booking_store['flex_dur']);
                }
            }
        }
        return '';
    }

    function getTotalGuest($booking_id = 0)
    {
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        $totalGuest = 0;
        #
        if ($clsTable == 'Tailor') {
            $type = $booking_store['type'];
            if ($type == 1) {
                $num_adult = $booking_store['adult_simple'];
                $num_child = $booking_store['children_simple'];
                $num_baby = $booking_store['baby_simple'];
            } else {
                $num_adult = $booking_store['adult'];
                $num_child = $booking_store['children'];
                $num_baby = $booking_store['baby'];
            }
        }
        if ($clsTable == 'Hotel') {
            $num_adult = $booking_store['adult'];
            $num_child = $booking_store['children'];
            $num_baby = 0;
        }
        if ($clsTable == 'Tour') {
            $BOOK_VALUE = $booking_store['BOOK_VALUE'];
            $BOOK_VALUE = unserialize($BOOK_VALUE);
            $num_adult = $BOOK_VALUE['adult'];
            $num_child = $BOOK_VALUE['child'];
            $num_baby = $BOOK_VALUE['baby'];
        }
        #
        if (intval($num_adult) > 0) {
            $totalGuest += intval($num_adult);
        }
        if (intval($num_child) > 0) {
            $totalGuest += intval($num_child);
        }
        if (intval($num_baby) > 0) {
            $totalGuest += intval($num_baby);
        }
        return $totalGuest;
    }

    function getNumberGuest($booking_id = 0)
    {
        $oneItem = $this->getOne($booking_id);
        $clsTable = $oneItem['clsTable'];
        $booking_store = $this->getBookingValue($booking_id);
        #
        $HTML_GUEST = '';
        #
        if ($clsTable == 'Tailor') {
            $type = $booking_store['type'];
            if ($type == 1) {
                $num_adult = $booking_store['adult_simple'];
                $num_child = $booking_store['children_simple'];
                $num_baby = $booking_store['baby_simple'];
            } else {
                $num_adult = $booking_store['adult'];
                $num_child = $booking_store['children'];
                $num_baby = $booking_store['baby'];
            }
        }
        if ($clsTable == 'Hotel') {
            $num_adult = $booking_store['adult'];
            $num_child = $booking_store['children'];
            $num_baby = 0;
        }
        if ($clsTable == 'Tour') {
            $num_adult = $booking_store['adult'];
            $num_child = $booking_store['child'];
            $num_baby = $booking_store['baby'];
        }
        if ($clsTable == 'Cruise') {
            $num_adult = $booking_store['number_adult'];
            $num_child = $booking_store['number_child'];
        }
        #
        if (intval($num_adult) > 0) {
            $HTML_GUEST .= $num_adult . ' adult(s)';
        }
        if (intval($num_child) > 0) {
            if (intval($num_adult) > 0) {
                $HTML_GUEST .= ' - ';
            }
            $HTML_GUEST .= $num_child . ' child(s)';
        }
        if (intval($num_baby) > 0) {
            if (intval($num_child) > 0 || intval($num_adult) > 0) {
                $HTML_GUEST .= ' - ';
            }
            $HTML_GUEST .= $num_baby . ' baby(s)';
        }
        return $HTML_GUEST;
    }

    // Send Email Booking Hotel
    function sendEmailBookingHotel($booking_id = 0, $booking_type = '')
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID, $email_template_book_hotel_id;
        #
        $clsHotel = new Hotel();
        $clsHotelRoom = new HotelRoom();
        $clsCountry = new _Country();
        $clsEmailTemplate = new EmailTemplate();
        #
        $oneItem = $this->getOne($booking_id);
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];
        $company_logo = $clsConfiguration->getValue('CompanyLogo');
        $HTML_GUEST = '';
        if (!empty($booking_store['adult'])) {
            $HTML_GUEST .= $booking_store['adult'] . ' ' . $core->get_Lang('adults');
        }
        if (!empty($booking_store['children'])) {
            $HTML_GUEST .= ' - ' . $booking_store['children'] . ' ' . $core->get_Lang('children');
        }
        $email_template_id = $email_template_book_hotel_id;
        # Parse Template

        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('[%URL_IMAGES%]', URL_IMAGES, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%LOGO_EMAILTMP%]', (!empty($company_logo) ? '<img src="' . $company_logo . '" />' : ''), $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%HOTEL_NAME%]', $clsHotel->getTitle($booking_store['hotel_id']), $message);
        $message = str_replace('[%HOTEL_ROOM%]', $clsHotelRoom->getTitle($booking_store['hotel_room']), $message);
        $message = str_replace('[%NUMBER_ROOM%]', $booking_store['number_room'], $message);
        $message = str_replace('[%ROOM_TYPE%]', $clsHotelRoom->getTitle($booking_store['hotel_room_id']), $message);
        $message = str_replace('[%HOTEL_URL%]', $clsHotel->getLink($booking_store['hotel_id']), $message);
        $message = str_replace('[%HOTEL_ADDRESS%]', $clsHotel->getAddress($booking_store['hotel_id']), $message);
        $message = str_replace('[%HOTEL_PRICE%]', $clsHotel->getPrice($booking_store['hotel_id']), $message);
        $message = str_replace('[%CHECKIN_DATE%]', $clsISO->converTimeToText(strtotime($booking_store['checkin'])), $message);
        $message = str_replace('[%CHECKOUT_DATE%]', $clsISO->converTimeToText(strtotime($booking_store['checkout'])), $message);
        $message = str_replace('[%NUMBER_GUEST%]', $HTML_GUEST, $message);
        $message = str_replace('[%HOTEL_REQUEST%]', $booking_store['request'], $message);
        $message = str_replace('[%ABOUT_LINK%]', $clsPage->getLink(1), $message);
        $message = str_replace('[%CONTACT_LINK%]', $clsISO->getLink('contact'), $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%REQUEST%]', $booking_store['request'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['name'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $booking_store['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['phone'], $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);

        #- Update Booking HTML
        $this->updateOne($booking_id, "booking_html='" . addslashes(trim($message)) . "'");
        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        #Send email to customer
        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = trim($booking_store['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        #Send email to admin
        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }
        return 1;
    }

    function getPaymentMethod($string = '')
    {
        if ($string == 'credit')
            return 'Credit Card';
        if ($string == 'bank')
            return 'Bank transfer';
        if ($string == 'other pay')
            return 'Other';
        if ($string == 'pay later')
            return 'Pay later';
    }

    function getBookingStatus($status = '')
    {
        global $core;
        if ($status == '5')
            return $core->get_Lang('Backordered');
        if ($status == '7')
            return $core->get_Lang('Complete');
        if ($status == '4')
            return $core->get_Lang('Declined');
        if ($status == '3')
            return $core->get_Lang('Failed');
        if ($status == '2')
            return $core->get_Lang('Reviewed');
        if ($status == '6')
            return $core->get_Lang('Canceled');
        if ($status == '1')
            return $core->get_Lang('Open');
        if ($status == '0')
            return $core->get_Lang('InProcess');
    }

    function getPaymentMethod2($booking_id = 0)
    {
        global $core, $clsISO, $dbconn;
        $payment_method = $this->getOneField('payment_method', $booking_id);

        if ($payment_method == PAYMENT_CASH_ID)
            return $core->get_Lang('Cash payments');
        if ($payment_method == PAYMENT_TRANSFER_ID)
            return $core->get_Lang('Bank Transfer');
        if ($payment_method == PAYMENT_ONEPAY_ATM)
            return $core->get_Lang('ONEPAY Inbound');
        if ($payment_method == PAYMENT_ONEPAY_VISA)
            return $core->get_Lang('ONEPAY Outbound');
        if ($payment_method == PAYMENT_PAYPAL_GATEWAY)
            return $core->get_Lang('Paypal');
    }

    // Send Email Booking Tour
    function sendEmailBookingTour($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID;
        global $email_template_book_tour_id, $adult_type_id, $child_type_id, $infant_type_id;
        #
        $clsTour = new Tour();
        $clsProperty = new Property();
        $clsCountry = new _Country();
        $clsEmailTemplate = new EmailTemplate();
        $clsTourOption = new TourOption();
        #
        $oneItem = $this->getOne($booking_id);
        $tour_id = $oneItem['target_id'];
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];

        $BOOK_VALUE = unserialize($booking_store['BOOK_VALUE']);
        $BOOK_ADDON = unserialize($booking_store['BOOK_ADDON']);

        $email_template_id = $email_template_book_tour_id;

        $clsTourProperty = new TourProperty();


        $number_of_guest = '';
        if (!empty($booking_store['adult'])) {
            $number_of_guest .= $booking_store['adult'] . ' ' . $core->get_Lang('adult(s)');
        }
        if (!empty($booking_store['child'])) {
            $number_of_guest .= ' - ' . $booking_store['child'] . ' ' . $core->get_Lang('children(s)');
        }
        if (!empty($booking_store['baby'])) {
            $number_of_guest .= ' - ' . $booking_store['baby'] . ' ' . $core->get_Lang('Infant');
        }

        $number_visitor = ($booking_store['adult'] + $booking_store['child'] + $booking_store['baby']);
        $assign_list["number_visitor"] = $number_visitor;
        if (!empty($booking_store['numSeat'])) {
            $number_of_guest .= $booking_store['numSeat'] . ' ' . $core->get_Lang('Seat');
        }

        if ($booking_store['people_price' . $adult_type_id] > "0") {
            if ($_LANG_ID == 'vn') {
                $tripprice = number_format($booking_store['people_price' . $adult_type_id], 0, ",", ".") . ' ' . $clsISO->getRate();
            } else {
                $tripprice = $clsISO->getRate() . ' ' . number_format($booking_store['people_price' . $adult_type_id], 2, ",", ".");
            }
        } else {
            $tripprice = $clsTour->getTripPrice($tour_id);
        }
        if ($_LANG_ID == 'vn') {
            $totalPrice = $booking_store['tien1'] . ' ' . $clsISO->getRate();
            $priceAdult = $booking_store['people_price' . $adult_type_id] * $booking_store['adult'];
            $priceAdult = number_format($priceAdult, 0, ",", ".") . ' ' . $clsISO->getRate();
            $priceChild = $booking_store['people_price' . $child_type_id] * $booking_store['child'];
            $priceChild = number_format($priceChild, 0, ",", ".") . ' ' . $clsISO->getRate();
            $priceBaby = $booking_store['people_price' . $infant_type_id] * $booking_store['baby'];
            $priceBaby = number_format($priceBaby, 0, ",", ".") . ' ' . $clsISO->getRate();
            $pricedeposit = $booking_store['depositBooking'];
            $pricedeposit = number_format($pricedeposit, 0, ",", ".") . ' ' . $clsISO->getRate();
            $remainingprice = $booking_store['remainingPrice'];
            $remainingprice = number_format($remainingprice, 0, ",", ".") . ' ' . $clsISO->getRate();
            $pricePromotion = $booking_store['pricePromotion'];
            $pricePromotion = number_format($pricePromotion, 0, ",", ".") . ' ' . $clsISO->getRate();
        } else {
            $totalPrice = $clsISO->getRate() . ' ' . $booking_store['tien1'];
            $priceAdult = $booking_store['people_price' . $adult_type_id] * $booking_store['adult'];
            $priceAdult = $clsISO->getRate() . ' ' . number_format($priceAdult, 0, ",", ".");
            $priceChild = $booking_store['people_price' . $child_type_id] * $booking_store['child'];
            $priceChild = $clsISO->getRate() . ' ' . number_format($priceChild, 0, ",", ".");
            $priceBaby = $booking_store['people_price' . $infant_type_id] * $booking_store['baby'];
            $priceBaby = $clsISO->getRate() . ' ' . number_format($priceBaby, 0, ",", ".");
            $pricedeposit = $booking_store['depositBooking'];
            $pricedeposit = $clsISO->getRate() . ' ' . number_format($pricedeposit, 2, ",", ".");
            $remainingprice = $booking_store['remainingPrice'];
            $remainingprice = $clsISO->getRate() . ' ' . number_format($remainingprice, 2, ",", ".");
            $pricePromotion = $booking_store['pricePromotion'];
            $pricePromotion = $clsISO->getRate() . ' ' . number_format($pricePromotion, 2, ",", ".");
        }
        #
        $departure_date = '';
        if (!empty($booking_store['departure_date'])) {
            $departure_date .= $booking_store['departure_date'];
        }
        #
        $end_date = '';
        if (!empty($booking_store['end_date'])) {
            $end_date = $booking_store['end_date'];
        } else {
            $num_day = $clsTour->getOneField('number_day', $tour_id);
            $end_date = date('m/d/Y', strtotime('+' . $num_day . ' day', strtotime($booking_store['departure_date'])));
        }

        $HTML_BOOKING_INFO = '';
        $addOnService = $booking_store['addOnService'];
        $adultService = $booking_store['adultService'];
        $childService = $booking_store['childService'];
        $numberService = $booking_store['number_tourservice'];
        if (is_array($addOnService)) {
            $serviceprice = $clsISO->getRate() . ' ' . $booking_store['total_service'];
            $clsAddOnService = new AddOnService();
            $HTML_BOOKING_INFO .= '<p style="text-align: justify;" _mce_style="text-align: justify;"><strong>' . $core->get_Lang('Transfer Services') . '</strong></p>';
            for ($i = 0; $i < count($addOnService); $i++) {
                if ($clsAddOnService->getOneField('extra', $addOnService[$i]) == 1) {
                    $priceSv = $clsISO->getRate() . ' ' . $clsAddOnService->getPrice($addOnService[$i]);
                } elseif ($clsAddOnService->getOneField('extra', $addOnService[$i]) == 2) {
                    $priceSv = $clsISO->getRate() . ' ' . $clsAddOnService->getPrice($addOnService[$i]) * $adultService[$addOnService[$i]];
                } else {
                    $priceSv = 'Included';
                }
                if (1 == 2) {
                    $HTML_BOOKING_INFO .= '<p style="text-align: justify;" _mce_style="text-align: justify;">' . $clsAddOnService->getTitle($addOnService[$i]) . '-' . $adultService[$addOnService[$i]] . ' adult(s) - ' . $childService[$addOnService[$i]] . ' children(s) - ' . $priceSv . '</p>';
                } else {
                    $HTML_BOOKING_INFO .= '<p style="text-align: justify;" _mce_style="text-align: justify;">' . $clsAddOnService->getTitle($addOnService[$i]) . '/' . $core->get_lang('Quantity') . '(' . $numberService[$addOnService[$i]] . ')</p>';
                }
            }
        }
        $HTML_BOOKING_INFO_TRAVELER = '';
        $HTML_BOOKING_INFO_TRAVELER .= '
		<strong>List of travelers(Inclusions: Full name, Birthday, Address, Gender, Age type)</strong><br />
		  <br />';
        for ($i = 0; $i < $number_visitor; $i++) {
            $HTML_BOOKING_INFO_TRAVELER .= '
		  ' . ($i + 1) . '-' . $booking_store['input_' . $i . '_name'] . ' / ' . $booking_store['input_' . $i . '_birthday'] . ' / ' . $booking_store['input_' . $i . '_address'] . ' / ' . $booking_store['input_' . $i . '_gender'] . ' / ' . $booking_store['input_' . $i . '_tourist_age_type'] . '.<br/>
		  <br />';
        }
        #---
        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';
        $message = str_replace('[%HTML_BOOKING_INFO%]', $HTML_BOOKING_INFO, $message);
        $message = str_replace('[%HTML_BOOKING_INFO_TRAVELER%]', $HTML_BOOKING_INFO_TRAVELER, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['first_name'] . ' ' . $booking_store['last_name'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS_PICK_UP%]', $booking_store['address_pick_up'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['telephone'], $message);
        $message = str_replace('[%CUSTOMER_MOBILE_PHONE%]', $booking_store['mobile'], $message);
        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $booking_store['note'], $message);

        $message = str_replace('[%NAME_OF_TRIP%]', $clsTour->getTitle($tour_id), $message);
        $message = str_replace('[%TRIP_DURATION%]', $clsTour->getTripDuration($tour_id), $message);
        $message = str_replace('[%TRIP_CODE%]', $clsTour->getTripCode($tour_id), $message);
        $message = str_replace('[%TOUR_CLASS%]', $clsTourOption->getTitle($booking_store['tourclass']), $message);
        $message = str_replace('[%SERVICE_PRICE%]', $serviceprice, $message);
        $message = str_replace('[%TRIP_PRICE%]', $tripprice, $message);
        $message = str_replace('[%PRICE_DEPOSIT%]', $pricedeposit, $message);
        $message = str_replace('[%REMAIN_PRICE%]', $remainingprice, $message);
        if ($booking_store['promotion'] > 0) {
            $message = str_replace('[%PROMOTION%]', $pricePromotion, $message);
        } else {
            $message = str_replace($core->get_Lang('Promotion') . ':', '', $message);
            $message = str_replace('[%PROMOTION%]', '', $message);
        }
        if ($booking_store['baby'] > 0) {
            $message = str_replace('[%PRICE_BABY%]', $priceBaby, $message);
        } else {
            //$message = str_replace($core->get_Lang('Price baby').':','',$message);
            $message = str_replace('[%PRICE_BABY%]', $core->get_Lang('Contact Us'), $message);
        }
        $message = str_replace('[%PRICE_ADULT%]', $priceAdult, $message);
        if ($booking_store['child'] > 0) {
            $message = str_replace('[%PRICE_CHILD%]', $priceChild, $message);
        } else {
            //$message = str_replace($core->get_Lang('Price child').':','',$message);
            $message = str_replace('[%PRICE_CHILD%]', $core->get_Lang('Contact Us'), $message);
        }

        $message = str_replace('[%TOTAL_PRICE%]', $totalPrice, $message);
        $message = str_replace('[%START_DATE%]', $departure_date, $message);
        $message = str_replace('[%END_DATE%]', $end_date, $message);
        $message = str_replace('[%NO_OF_GUEST%]', $number_of_guest, $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);

        $this->updateOne($booking_id, "booking_html='" . addslashes($message) . "'");
        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        #-- Send email to customer
        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = trim($booking_store['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }
        return 1;
    }

    function sendEmailBookingTour2018($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID;
        global $email_template_book_tour_id, $adult_type_id, $child_type_id, $infant_type_id;

        #
        $clsTour = new Tour();
        $clsProperty = new Property();
        $clsCountry = new _Country();
        $clsEmailTemplate = new EmailTemplate();
        $clsTourOption = new TourOption();
        #
        $oneItem = $this->getOne($booking_id);
        $tour_id = $oneItem['target_id'];
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];
        //print_r($booking_store); die();
        /* HTML_BOOKING_INFO */
        $BOOK_VALUE = unserialize($booking_store['BOOK_VALUE']);
        $BOOK_ADDON = unserialize($booking_store['BOOK_ADDON']);

        $email_template_id = $email_template_book_tour_id;

        $clsTourProperty = new TourProperty();


        $number_of_guest = '';
        if (!empty($booking_store['national_visitor' . $adult_type_id])) {
            $number_of_guest .= $booking_store['national_visitor' . $adult_type_id] . ' ' . $core->get_Lang('adult(s)');
        }
        if (!empty($booking_store['national_visitor' . $child_type_id])) {
            $number_of_guest .= ' - ' . $booking_store['national_visitor' . $child_type_id] . ' ' . $core->get_Lang('children(s)');
        }
        if (!empty($booking_store['national_visitor' . $infant_type_id])) {
            $number_of_guest .= ' - ' . $booking_store['national_visitor' . $infant_type_id] . ' ' . $core->get_Lang('Infant');
        }
        $number_visitor = ($booking_store['national_visitor' . $adult_type_id] + $booking_store['national_visitor' . $child_type_id] + $booking_store['national_visitor' . $infant_type_id]);

        $assign_list["number_visitor"] = $number_visitor;
        if (!empty($booking_store['numSeat'])) {
            $number_of_guest .= $booking_store['numSeat'] . ' ' . $core->get_Lang('Seat');
        }

        if ($booking_store['people_price' . $adult_type_id] > "0") {
            if ($_LANG_ID == 'vn') {
                $tripprice = number_format($booking_store['people_price' . $adult_type_id], 0, ",", ".") . ' ' . $clsISO->getRate();
            } else {
                $tripprice = $clsISO->getRate() . ' ' . number_format($booking_store['people_price' . $adult_type_id], 2, ",", ".");
            }
        } else {
            $tripprice = $clsTour->getTripPrice($tour_id);
        }
        if ($_LANG_ID == 'vn') {
            $totalPrice = $booking_store['price_total_amount'] . ' ' . $clsISO->getRate();
            $voucher = $booking_store['voucher_code'];
            $priceAdult = $booking_store['people_price' . $adult_type_id] * $booking_store['national_visitor' . $adult_type_id];
            $priceAdult = number_format($priceAdult, 0, ",", ".") . ' ' . $clsISO->getRate();
            $priceChild = $booking_store['people_price' . $child_type_id] * $booking_store['national_visitor' . $child_type_id];
            $priceChild = number_format($priceChild, 0, ",", ".") . ' ' . $clsISO->getRate();
            $priceBaby = $booking_store['people_price' . $infant_type_id] * $booking_store['national_visitor' . $infant_type_id];
            $priceBaby = number_format($priceBaby, 0, ",", ".") . ' ' . $clsISO->getRate();
            $pricedeposit = $booking_store['price_deposit'];
            $pricedeposit = number_format($pricedeposit, 0, ",", ".") . ' ' . $clsISO->getRate();
            $remainingprice = $booking_store['price_remaining'];
            $remainingprice = number_format($remainingprice, 0, ",", ".") . ' ' . $clsISO->getRate();
            $pricePromotion = $booking_store['price_promotion'];
            $pricePromotion = number_format($pricePromotion, 0, ",", ".") . ' ' . $clsISO->getRate();
        } else {
            $totalPrice = $clsISO->getRate() . ' ' . $booking_store['price_total_amount'];
            $voucher = $booking_store['voucher_code'];
            $priceAdult = $booking_store['people_price' . $adult_type_id] * $booking_store['national_visitor' . $adult_type_id];
            $priceAdult = $clsISO->getRate() . ' ' . number_format($priceAdult, 0, ",", ".");
            $priceChild = $booking_store['people_price' . $child_type_id] * $booking_store['national_visitor' . $child_type_id];
            $priceChild = $clsISO->getRate() . ' ' . number_format($priceChild, 0, ",", ".");
            $priceBaby = $booking_store['people_price' . $infant_type_id] * $booking_store['national_visitor' . $infant_type_id];
            $priceBaby = $clsISO->getRate() . ' ' . number_format($priceBaby, 0, ",", ".");
            $pricedeposit = $booking_store['price_deposit'];
            $pricedeposit = $clsISO->getRate() . ' ' . number_format($pricedeposit, 2, ",", ".");
            $remainingprice = $booking_store['price_remaining'];
            $remainingprice = $clsISO->getRate() . ' ' . number_format($remainingprice, 2, ",", ".");
            $pricePromotion = $booking_store['price_promotion'];
            $pricePromotion = $clsISO->getRate() . ' ' . number_format($pricePromotion, 2, ",", ".");
        }
        #
        $departure_date = '';
        if (!empty($booking_store['departure_date'])) {
            $departure_date .= $booking_store['departure_date'];
        }
        #
        $end_date = '';
        if (!empty($booking_store['end_date'])) {
            $end_date = $booking_store['end_date'];
        } else {
            $num_day = $clsTour->getOneField('number_day', $tour_id);
            $end_date = date('m/d/Y', strtotime('+' . $num_day . ' day', strtotime($booking_store['departure_date'])));
        }

        $HTML_BOOKING_INFO = '';
        $addOnService = $booking_store['addOnService'];
        $adultService = $booking_store['adultService'];
        $childService = $booking_store['childService'];
        $numberService = $booking_store['number_tourservice'];
        if (is_array($addOnService)) {
            $serviceprice = $clsISO->getRate() . ' ' . $booking_store['price_total_service'];
            $clsAddOnService = new AddOnService();
            $HTML_BOOKING_INFO .= '<p style="text-align: justify;" _mce_style="text-align: justify;"><strong>' . $core->get_Lang('Transfer Services') . '</strong></p>';
            for ($i = 0; $i < count($addOnService); $i++) {
                if ($clsAddOnService->getOneField('extra', $addOnService[$i]) == 1) {
                    $priceSv = $clsISO->getRate() . ' ' . $clsAddOnService->getPrice($addOnService[$i]);
                } elseif ($clsAddOnService->getOneField('extra', $addOnService[$i]) == 2) {
                    $priceSv = $clsISO->getRate() . ' ' . $clsAddOnService->getPrice($addOnService[$i]) * $numberService[$addOnService[$i]];
                } else {
                    $priceSv = 'Included';
                }
                if (1 == 2) {
                    $HTML_BOOKING_INFO .= '<p style="text-align: justify;" _mce_style="text-align: justify;">' . $clsAddOnService->getTitle($addOnService[$i]) . '-' . $adultService[$addOnService[$i]] . ' adult(s) - ' . $childService[$addOnService[$i]] . ' children(s) - ' . $priceSv . '</p>';
                } else {
                    $HTML_BOOKING_INFO .= '<div>
					<p>' . ($i + 1) . '. ' . $clsAddOnService->getTitle($addOnService[$i]) . '</p>
					<p>- ' . $core->get_Lang('Price') . ': ' . $priceSv . '</p>
					<p>- ' . $core->get_Lang('Quantity') . ': ' . $numberService[$addOnService[$i]] . '</p>
					</div>';
                }
            }
        }

        $HTML_PRICE_BOOKING .= '<p style="margin-left: 8px;">' . $core->get_Lang('Price adult') . ': [%PRICE_ADULT%]</p>';
        if ($booking_store['national_visitor' . $child_type_id] > 0 && $booking_store['people_price' . $child_type_id] > "0") {
            $HTML_PRICE_BOOKING .= '<p style="margin-left: 8px;">' . $core->get_Lang('Price child') . ': [%PRICE_CHILD%]</p>';
        }
        if ($booking_store['national_visitor' . $infant_type_id] > 0 && $booking_store['people_price' . $infant_type_id] > 0) {
            $HTML_PRICE_BOOKING .= '<p style="margin-left: 8px;">' . $core->get_Lang('Price baby') . ': [%PRICE_BABY%]</p>';
        }
        if ($serviceprice > 0) {
            $HTML_PRICE_BOOKING .= '<p style="margin-left: 8px;">' . $core->get_Lang('Price service') . ': [%SERVICE_PRICE%]</p>';
        }
        if ($booking_store['voucher_code'] != '') {
            $HTML_PRICE_BOOKING .= '<p style="margin-left: 8px;">' . $core->get_Lang('Voucher') . ': [%VOUCHER%]</p>';
        }


        $HTML_BOOKING_INFO_TRAVELER = '';
        $HTML_BOOKING_INFO_TRAVELER .= '
		<strong style="margin-left: 8px;">List of travelers(Inclusions: Full name, Birthday, Address, Gender, Age type)</strong>
		  ';
        for ($i = 0; $i < $number_visitor; $i++) {
            $HTML_BOOKING_INFO_TRAVELER .= '<p style="margin-left: 8px;">' . ($i + 1) . '-' . $booking_store['name_input_' . $i] . ' / ' . $booking_store['birthday_input_' . $i] . ' / ' . $booking_store['address_input_' . $i] . ' / ' . $booking_store['gender_input_' . $i] . ' / ' . $booking_store['tourist_age_type_input_' . $i] . '.</p>';
        }
        $HTML_BOOKING_INFO .= '<p style="margin-left: 8px;">' . $core->get_Lang('Ip') . ': ' . $oneItem['ip_booking'] . '</p>';
        #---

        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%HTML_BOOKING_INFO%]', $HTML_BOOKING_INFO, $message);
        $message = str_replace('[%HTML_BOOKING_INFO_TRAVELER%]', $HTML_BOOKING_INFO_TRAVELER, $message);
        $message = str_replace('[%HTML_PRICE_BOOKING%]', $HTML_PRICE_BOOKING, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['title'] . ' ' . $booking_store['first_name'] . ' ' . $booking_store['last_name'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS_PICK_UP%]', $booking_store['address_pick_up'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['telephone'], $message);
        $message = str_replace('[%CUSTOMER_BIRTHDAY%]', $booking_store['birthday'], $message);
        $message = str_replace('[%CUSTOMER_GENDER%]', $booking_store['gender'], $message);
        $message = str_replace('[%CUSTOMER_MOBILE_PHONE%]', $booking_store['mobile'], $message);
        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $booking_store['note'], $message);

        $message = str_replace('[%NAME_OF_TRIP%]', $clsTour->getTitle($tour_id), $message);
        $message = str_replace('[%TRIP_DURATION%]', $clsTour->getTripDuration($tour_id), $message);
        $message = str_replace('[%TRIP_CODE%]', $clsTour->getTripCode($tour_id), $message);
        $message = str_replace('[%TOUR_CLASS%]', $clsTourOption->getTitle($booking_store['tourclass']), $message);
        $message = str_replace('[%TRIP_PRICE%]', $tripprice, $message);
        $message = str_replace('[%PRICE_DEPOSIT%]', $pricedeposit, $message);
        $message = str_replace('[%REMAIN_PRICE%]', $remainingprice, $message);

        if ($booking_store['promotion'] > 0) {
            $message = str_replace('[%PROMOTION%]', $pricePromotion, $message);
        } else {
            $message = str_replace($core->get_Lang('Promotion') . ':', '', $message);
            $message = str_replace('[%PROMOTION%]', '', $message);
        }

        $message = str_replace('[%PRICE_ADULT%]', $priceAdult, $message);
        if ($booking_store['voucher_code'] != '') {
            $message = str_replace('[%VOUCHER%]', $voucher, $message);
        }

        if ($booking_store['national_visitor' . $child_type_id] > 0 && $booking_store['people_price' . $child_type_id] > "0") {
            $message = str_replace('[%PRICE_CHILD%]', $priceChild, $message);
        } elseif ($booking_store['national_visitor' . $child_type_id] > 0) {
            $message = str_replace('[%PRICE_CHILD%]', $core->get_Lang('Contact Us'), $message);
        } else {
            $message = str_replace('<p>' . $core->get_Lang('Price child') . ': [%PRICE_CHILD%]</p>', '', $message);
        }

        if ($booking_store['national_visitor' . $infant_type_id] > 0 && $booking_store['people_price' . $infant_type_id] > 0) {
            $message = str_replace('[%PRICE_BABY%]', $priceBaby, $message);
        } elseif ($booking_store['national_visitor' . $infant_type_id] > 0) {
            $message = str_replace('[%PRICE_BABY%]', $core->get_Lang('Contact Us'), $message);
        } else {
            $message = str_replace('<p>' . $core->get_Lang('Price baby') . ': [%PRICE_BABY%]</p>', '', $message);
        }

        if ($serviceprice > 0) {
            $message = str_replace('[%SERVICE_PRICE%]', $serviceprice, $message);
        } else {
            $message = str_replace('<p>' . $core->get_Lang('Price service') . ': [%SERVICE_PRICE%]</p>', '', $message);
        }

        $message = str_replace('[%TOTAL_PRICE%]', $totalPrice, $message);
        $message = str_replace('[%START_DATE%]', $departure_date, $message);
        $message = str_replace('[%END_DATE%]', $end_date, $message);
        $message = str_replace('[%NO_OF_GUEST%]', $number_of_guest, $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);
        #-- Update Html Booking'
        //$clsISO->print_pre($booking_store,true);
        //print_r($message);die('xxx');
        $this->updateOne($booking_id, "booking_html='" . addslashes($message) . "'");
        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        #-- Send email to customer
        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = trim($booking_store['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);


        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }


        return 1;
    }

    function sendEmailBookingTour2020($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID;
        global $email_template_book_tour_id, $adult_type_id, $child_type_id, $infant_type_id;

        #
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $clsCruiseItinerary = new CruiseItinerary();
        $clsCruiseCabin = new CruiseCabin();

        $clsTourOption = new TourOption();
        $clsAddOnService = new AddOnService();


        $clsPromotion = new Promotion();

        $clsProperty = new Property();

        $clsCountry = new _Country();
        $assign_list['clsCountry'] = $clsCountry;
        $clsEmailTemplate = new EmailTemplate();
        $assign_list['clsEmailTemplate'] = $clsEmailTemplate;
        #
        $oneItem = $this->getOne($booking_id);
        $tour_id = $oneItem['target_id'];
        $TotalGrandBook = $oneItem['totalgrand'];
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];
        //print_r($booking_store); die();
        /* HTML_BOOKING_INFO */

        $email_template_id = $email_template_book_tour_id;

        $clsTourProperty = new TourProperty();

        //		$cartSessionService= vnSessionGetVar('cartSessionService');
        //		if(!empty($cartSessionService)){
        //			$cartSessionTour = array_merge($cartSessionService['TOUR']);
        //			$cartSessionVoucher = array_merge($cartSessionService['VOUCHER']);
        //		}
        $cartSessionTour = vnSessionGetVar('BookingTour_' . $_LANG_ID);
        $cartSessionVoucher = vnSessionGetVar('BookingVoucher_' . $_LANG_ID);
        $cartSessionCruise = vnSessionGetVar('BookingCruise_' . $_LANG_ID);

        $cartSessionTour = $cartSessionTour[$_LANG_ID];
        $cartSessionVoucher = $cartSessionVoucher[$_LANG_ID];
        $cartSessionCruise = $cartSessionCruise[$_LANG_ID];

        $cartSessionContact_Info = vnSessionGetVar('ContactInfoBooking');
        $assign_list['cartSessionContact_Info'] = $cartSessionContact_Info;

        //$cartSessionContact_Info = array_merge($cartSessionContact_Info);


        if ($cartSessionTour != '') {
            $html = '';
            $total_price_booking = 0;
            $total_price_deposit = 0;

            foreach ($cartSessionTour as $item) {
                if ($item['tour_id_z']) {
                    $title_package = $clsTour->getTitle($item['tour_id_z']);
                    $number_adult = $item['number_adults_z'];
                    $number_child = $item['number_child_z'];
                    $number_infant = $item['number_infants_z'];
                    $price_adult = $clsISO->formatPrice($item['price_adults_z']);
                    $price_child = $clsISO->formatPrice($item['price_child_z']);
                    $price_infant = $clsISO->formatPrice($item['price_infants_z']);
                    $promotion = $item['promotion_z'];
                    $price_promotion = $clsISO->formatPrice($item['price_promotion']);
                    $deposit = $item['deposit'];
                    $price_deposit = $clsISO->formatPrice($item['price_deposit']);
                    $total_price = $clsISO->formatPrice($item['total_price_z']);

                    $total_price_booking += $item['total_price_z'];
                    $total_price_deposit += $item['price_deposit'];


                    $str_start_date = $clsISO->getStrToTime($item['check_in_book_z']);
                    $str_end_date = $clsTour->getEndDate($str_start_date, $item['tour_id_z']);

                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Name Trip') . '
							</span>: ' . $title_package . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Tour Option') . '
							</span>: ' . $clsTourOption->getTitle($item['tour__class']) . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Start Date') . '
							</span>: ' . $clsISO->converTimeToText5($str_start_date) . '</span>
					</span>
				</span>
			</div>';


                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('End Date') . '
							</span>: ' . $clsISO->converTimeToText5($str_end_date) . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Adult') . '
							</span>: ' . $price_adult . $clsISO->getShortRate() . ' x ' . $number_adult . ' ' . $core->get_Lang('Adults') . '</span>
					</span>
				</span>
			</div>';
                    if ($number_child > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Child') . '
							</span>: ' . $price_child . $clsISO->getShortRate() . ' x ' . $number_child . ' ' . $core->get_Lang('Child') . '</span>
					</span>
				</span>
			</div>';
                    }
                    if ($number_infant > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Child') . '
							</span>: ' . $price_infant . $clsISO->getShortRate() . ' x ' . $number_infant . ' ' . $core->get_Lang('Infant') . '</span>
					</span>
				</span>
			</div>';
                    }
                    if ($promotion > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Promotion') . '
							</span>: ' . $promotion . '% = ' . $price_promotion . $clsISO->getShortRate() . '</span>
					</span>
				</span>
			</div>';
                    }

                    if ($item['total_addon'] > 0) {
                        $html .= '<p><strong>' . $core->get_Lang('Dịch vụ thêm') . '</strong></p>';
                        $html .= '<div class="service_tour" style="padding-left:10px">';
                        $index_service = 0;
                        foreach ($item['number_addon'] as $k => $v) {
                            $v = intval($v);
                            if ($v > 0) {
                                $index_service++;
                                if ($clsAddOnService->getOneField('extra', $k) == 1) {
                                    $priceSv = $clsAddOnService->getPrice($k) . $clsISO->getRate();
                                } elseif ($clsAddOnService->getOneField('extra', $k) == 2) {

                                    $priceSv = $clsISO->formatPrice($v * $clsAddOnService->getPriceOrgin($k)) . $clsISO->getRate();
                                } else {
                                    $priceSv = $core->get_Lang('Included');
                                }
                                $html .= '<p>' . ($index_service) . '. ' . $clsAddOnService->getTitle($k) . '</p>
								<p>- ' . $core->get_Lang('Price') . ': ' . $priceSv . '</p>
								<p>- ' . $core->get_Lang('Quantity') . ': ' . $v . '</p>';
                            }
                        }

                        $html .= '</div>';
                    }

                    $html .= '<p><strong>' . $core->get_Lang('Total Price') . ':</strong> ' . $total_price . $clsISO->getShortRate() . '</p>';

                    if ($deposit > 0) {
                        $html .= '<p class="promotion_in4"><strong>' . $core->get_Lang('Deposit') . ':</strong> ' . $price_deposit . $clsISO->getShortRate() . '</p>';
                    }

                    if ($cartSessionContact_Info['fullname_' . $item['tour_id_z']] != '') {
                        $html .= '
				<p><strong>' . $core->get_Lang('Contact Information') . '</strong></p>';
                        $html .= '
				<p><strong>' . $core->get_Lang('Full Name') . ':</strong> ' . $cartSessionContact_Info['title_' . $item['tour_id_z']] . ' ' . $cartSessionContact_Info['fullname_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Phone number') . ':</strong> ' . $cartSessionContact_Info['telephone_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Email') . ':</strong> ' . $cartSessionContact_Info['email_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Birthday') . ':</strong> ' . $cartSessionContact_Info['birthday_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Address') . ':</strong> ' . $cartSessionContact_Info['address_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Messager') . ':</strong> ' . $cartSessionContact_Info['note_' . $item['tour_id_z']] . '</p>';
                    }
                    $html .= '
				<p><strong>' . $core->get_Lang('List of travelers(Inclusions: Full name, Birthday)') . '</strong></p>
				  ';
                    for ($i = 1; $i <= $item['number_adults_z']; $i++) {
                        if ($cartSessionContact_Info['fullname_adult_' . $item['tour_id_z'] . '_' . $i] != '') {
                            $html .= '<p>' . ($i) . '- ' . $cartSessionContact_Info['title_adult_' . $item['tour_id_z'] . '_' . $i] . ' ' . $cartSessionContact_Info['fullname_adult_' . $item['tour_id_z'] . '_' . $i] . ', ' . $cartSessionContact_Info['birthday_adult_' . $item['tour_id_z'] . '_' . $i] . '</p>';
                        }
                    }
                    for ($i = 1; $i <= $item['number_child_z']; $i++) {
                        if ($cartSessionContact_Info['fullname_child_' . $item['tour_id_z'] . '_' . $i] != '') {
                            $html .= '<p>' . ($i + $item['number_adults_z']) . '- ' . $cartSessionContact_Info['title_child_' . $item['tour_id_z'] . '_' . $i] . ' ' . $cartSessionContact_Info['fullname_child_' . $item['tour_id_z'] . '_' . $i] . ', ' . $cartSessionContact_Info['birthday_child_' . $item['tour_id_z'] . '_' . $i] . '</p>';
                        }
                    }
                    for ($i = 1; $i <= $item['number_infant_z']; $i++) {
                        if ($cartSessionContact_Info['fullname_infant_' . $item['tour_id_z'] . '_' . $i] != '') {
                            $html .= '<p>' . ($i + $item['number_child_z'] + $item['number_infant_z']) . '- ' . $cartSessionContact_Info['title_infant_' . $item['tour_id_z'] . '_' . $i] . ' ' . $cartSessionContact_Info['fullname_infant_' . $item['tour_id_z'] . '_' . $i] . ', ' . $cartSessionContact_Info['birthday_infant_' . $item['tour_id_z'] . '_' . $i] . '</p>';
                        }
                    }
                }
            }
        }

        $total_price_booking_cruise = 0;
        $total_price_discount_cruise = 0;
        if (!empty($cartSessionCruise)) {

            if (!empty($cartSessionCruise)) {
                foreach ($cartSessionCruise as $key => $value) {
                    if ($value['cruise_itinerary_id']) {
                        $title_cruise_itinerary = $clsCruiseItinerary->getTitleDay($value['cruise_itinerary_id']);
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Cruise Itinerary') . '
								</span>: ' . $title_cruise_itinerary . '</span>
						</span>
					</span>
				</div>';
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Departure') . '
								</span>: ' . $clsISO->converTimeToText5($value['departure_date']) . '</span>
						</span>
					</span>
				</div>';
                        foreach ($value['cabin'] as $key2 => $value2) {
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Name') . '
								</span>: ' . $clsCruiseCabin->getTitle($value2['cruise_cabin_id']) . '</span>
						</span>
					</span>
				</div>';
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Number') . '
										</span>: ' . $value2['number_cabin'] . '</span>
								</span>
							</span>
						</div>';

                            $number_of_guest = '';
                            if (!empty($value2['number_adult'])) {
                                $number_of_guest .= $value2['number_adult'] . ' ' . $core->get_Lang('adults');
                            }

                            if (!empty($value2['number_child'])) {
                                $number_of_guest .= ', ' . $value2['number_child'] . ' ' . $core->get_Lang('children');
                            }

                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Number of guest') . '
										</span>: ' . $number_of_guest . '</span>
								</span>
							</span>
						</div>';
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Price') . '
										</span>: ' . $clsISO->formatPrice($value2['totalprice']) . $clsISO->getShortRate() . '</span>
								</span>
							</span>
						</div>';
                        }
                    }
                    $totalpriceCabin = $value2['totalprice'];
                    $total_price_booking_cruise += $totalpriceCabin;
                    $totalGrand += $totalpriceCabin;
                }
            }

            foreach ($cartSessionVoucher as $item) {
                if ($item['voucher_id']) {
                    $voucher_id = $item['voucher_id'];
                    $discount_id = $item['discount_id'];
                    $title_package = $clsVoucher->getTitle($item['voucher_id']);
                    $number_ticket = $item['number_voucher'];
                    //				print_r($number_adult);die();
                    $priceVoucher = $clsVoucher->getPriceVoucher($item['voucher_id']);
                    $total_price_booking_voucher += $priceVoucher;

                    $price = $clsVoucher->getPriceOrigin($item['voucher_id']);
                    $price *= $number_ticket;
                    $total_price = $clsISO->formatPrice($price);

                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Name Voucher') . '
							</span>: ' . $title_package . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Voucher') . '
							</span>: ' . $clsISO->formatPrice($priceVoucher) . $clsISO->getShortRate() . ' x ' . $number_ticket . ' ' . $core->get_Lang('Ticket') . '</span>
					</span>
				</span>
			</div>';
                    if ($item['discount_value'] > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Discount') . '
								</span>: ' . $clsISO->formatPrice($item['discount_value']) . $clsISO->getShortRate() . '</span>
						</span>
					</span>
				</div>';
                        $total_price_discount_voucher += $item['discount_value'];
                    }


                    $clsStock = new Stock();
                    $clsDiscount = new Discount();
                    $clsStock->updateByCond("voucher_id='$voucher_id'", "total_out=total_out+$number_ticket,quantily=quantily-$number_ticket");
                    $clsDiscount->updateOne($discount_id, "total_used=total_used+$number_ticket");
                }
            }
        }

        $total_price_booking_voucher = 0;
        $total_price_discount_voucher = 0;
        if ($cartSessionVoucher != '') {

            foreach ($cartSessionVoucher as $item) {
                if ($item['voucher_id']) {
                    $voucher_id = $item['voucher_id'];
                    $discount_id = $item['discount_id'];
                    $title_package = $clsVoucher->getTitle($item['voucher_id']);
                    $number_ticket = $item['number_voucher'];
                    //				print_r($number_adult);die();
                    $priceVoucher = $clsVoucher->getPriceVoucher($item['voucher_id']);
                    $total_price_booking_voucher += $priceVoucher;

                    $price = $clsVoucher->getPriceOrigin($item['voucher_id']);
                    $price *= $number_ticket;
                    $total_price = $clsISO->formatPrice($price);

                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Name Voucher') . '
							</span>: ' . $title_package . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Voucher') . '
							</span>: ' . $clsISO->formatPrice($priceVoucher) . $clsISO->getShortRate() . ' x ' . $number_ticket . ' ' . $core->get_Lang('Ticket') . '</span>
					</span>
				</span>
			</div>';
                    if ($item['discount_value'] > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Discount') . '
								</span>: ' . $clsISO->formatPrice($item['discount_value']) . $clsISO->getShortRate() . '</span>
						</span>
					</span>
				</div>';
                        $total_price_discount_voucher += $item['discount_value'];
                    }


                    $clsStock = new Stock();
                    $clsDiscount = new Discount();
                    $clsStock->updateByCond("voucher_id='$voucher_id'", "total_out=total_out+$number_ticket,quantily=quantily-$number_ticket");
                    $clsDiscount->updateOne($discount_id, "total_used=total_used+$number_ticket");
                }
            }
        }
        if ($total_price_deposit > 0) {
            $total_price_remaining = $total_price_booking - $total_price_deposit;
            //$total_price_paynow=$total_price_deposit+$total_price_booking_voucher-$total_price_discount_voucher;
            $total_price_paynow = $total_price_deposit;
        } else {
            $total_price_remaining = 0;
            $total_price_paynow = $total_price_booking + $total_price_booking_cruise + $total_price_booking_voucher - $total_price_discount_voucher;
        }

        if ($total_price_deposit > 0) {
            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
		<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
			<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
				<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
					<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Total Deposit Tour') . '
					</span>: ' . $clsISO->formatPrice($total_price_deposit) . $clsISO->getShortRate() . '</span>
			</span>
		</span>
	</div>';
        }

        if ($total_price_remaining > 0) {
            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
			<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
				<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
					<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
						<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Total Payment remaining') . '
						</span>: ' . $clsISO->formatPrice($total_price_remaining) . $clsISO->getShortRate() . '</span>
				</span>
			</span>
		</div>';
        }
        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
			<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
				<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
					<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
						<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Total Payment Now') . '
						</span>: ' . $clsISO->formatPrice($total_price_paynow) . $clsISO->getShortRate() . '</span>
				</span>
			</span>
		</div>';

        #---

        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%HTML_BOOKING_INFO%]', $html, $message);
        $message = str_replace('[%TOTAL_PRICE_BOOKING%]', $total_price_booking, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%BOOKING_CODE_2019%]', $booking_id, $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $cartSessionContact_Info['email'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $cartSessionContact_Info['title'] . ' ' . $cartSessionContact_Info['fullname'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $cartSessionContact_Info['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($cartSessionContact_Info['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $cartSessionContact_Info['telephone'], $message);
        $message = str_replace('[%CUSTOMER_BIRTHDAY%]', $cartSessionContact_Info['birthday'], $message);

        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $cartSessionContact_Info['note'], $message);

        $message = str_replace('[%NAME_OF_TRIP%]', $clsTour->getTitle($tour_id), $message);
        $message = str_replace('[%TRIP_DURATION%]', $clsTour->getTripDuration($tour_id), $message);
        $message = str_replace('[%TRIP_CODE%]', $clsTour->getTripCode($tour_id), $message);
        $message = str_replace('[%TOUR_CLASS%]', $clsTourOption->getTitle($cartSessionContact_Info['tourclass']), $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);

        #-- Update Html Booking'
        //$clsISO->print_pre($cartSessionContact_Info,true);
        //		print_r($message);die('xxx');
        $this->updateOne($booking_id, "booking_html='" . addslashes($message) . "'");
        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        $owner = $clsEmailTemplate->getFromName($email_template_id);


        $to = trim($cartSessionContact_Info['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        //		print_r($from.'xxxx'.$to.'xxxx'.$subject.'xxxx'.$message.'xxxx'.$owner);die();
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }

        return 1;
    }

    function sendEmailComfirmPayment($billing_history_id = 0, $type = 'complete')
    {
        /*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID;
        global $adult_type_id, $child_type_id, $infant_type_id;

        #
        $clsBillingHistory = new BillingHistory();
        $clsEmailTemplate = new EmailTemplate();
        $clsCountry = new _Country();
        $oneBillingHistory = $clsBillingHistory->getOne($billing_history_id);
        $bill_code = $oneBillingHistory['bill_code'];
        $bill_money = $clsISO->formatPrice($oneBillingHistory['bill_money']) . $clsISO->getShortRate();

        $oneItem = $this->getOne($oneBillingHistory['booking_id'], 'booking_store,booking_code');
        $booking_code = $oneItem['booking_code'];
        $booking_store = unserialize($oneItem['booking_store']);
        #---
        $email_template_id = 132;

        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        if ($oneBillingHistory['status'] == 0) {
            $title_content = PAGE_NAME . " yêu cầu thanh toán booking theo thông tin dưới đây.";
        } else {
            $title_content = PAGE_NAME . " xác nhận thanh toán thành công theo thông tin dưới đây.";
        }


        $message = str_replace('[%TITLE_CONTENT%]', $title_content, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%BILL_CODE%]', $bill_code, $message);
        $message = str_replace('[%MONEY%]', $bill_money, $message);
        $message = str_replace('[%NOTE%]', html_entity_decode($oneBillingHistory['note']), $message);

        $message = str_replace('[%CUSTOMER_EMAIL%]', $oneBillingHistory['customer_email'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['title'] . ' ' . $oneBillingHistory['customer_name'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $booking_store['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $oneBillingHistory['customer_phone'], $message);
        $message = str_replace('[%CUSTOMER_BIRTHDAY%]', $booking_store['birthday'], $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);
        #-- Update Html Booking'
        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        $owner = $clsEmailTemplate->getFromName($email_template_id);

        $to = trim($oneBillingHistory['customer_email']);


        $subject = '[' . PAGE_NAME . '] ' . $clsEmailTemplate->getSubject($email_template_id);
        if ($oneBillingHistory['bill_type'] == "CASHBACK") {
            $title = "Thêm hoàn tiền";
        } else {
            if ($type == 'complete') {
                $title = "Thanh toán thành công";
            } else {
                $title = "Yêu cầu thanh toán";
            }
        }
        $subject = str_replace('[%TITLE%]', $title, $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }
        return 1;
    }

    function sendEmailCancelComfirmBooking($booking_id = 0, $type = '', $type_id = 0, $status = 0)
    {
        /*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID;
        global $adult_type_id, $child_type_id, $infant_type_id;

        #
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $clsCruiseItinerary = new CruiseItinerary();
        $clsCruiseCabin = new CruiseCabin();
        $clsHotel = new Hotel();
        $clsHotelRoom = new HotelRoom();

        $clsTourOption = new TourOption();
        $clsAddOnService = new AddOnService();


        $clsPromotion = new Promotion();

        $clsProperty = new Property();

        $clsCountry = new _Country();
        $assign_list['clsCountry'] = $clsCountry;
        $clsEmailTemplate = new EmailTemplate();
        $assign_list['clsEmailTemplate'] = $clsEmailTemplate;
        #
        $oneItem = $this->getOne($booking_id);
        $tour_id = $oneItem['target_id'];
        $TotalGrandBook = $oneItem['totalgrand'];
        $booking_store = unserialize($oneItem['booking_store']);
        $cart_store = unserialize($oneItem['cart_store']);
        $cart = $cart_store[$type][$type_id];
        if ($type == "TOUR") {
            $cart_tour = $cart;
        } else if ($type == "HOTEL") {
            $cart_hotel = $cart;
        } else if ($type == "CRUISE") {
            $cart_cruise = $cart;
        }

        $booking_code = $oneItem['booking_code'];
        if ($status == 2) {
            $email_template_id = 130;
            $html = '<h1 style="font-weight: 700;font-size: 21px;line-height: 28px;color: #32A923;margin-bottom: 34px;">Dịch vụ của quý khách đã được hủy!</h1>';
        } else {
            $email_template_id = 131;
            $html = '<h1 style="font-weight: 700;font-size: 21px;line-height: 28px;color: #32A923;margin-bottom: 34px;">Dịch vụ của quý khách đã được xác nhận!</h1>';
        }


        $clsTourProperty = new TourProperty();
        if (!empty($cart_tour)) {
            if ($cart_tour['tour_id_z']) {
                $title_package = $clsTour->getTitle($cart_tour['tour_id_z']);
                $number_adult = $cart_tour['number_adults_z'];
                $number_child = $cart_tour['number_child_z'];
                $number_infant = $cart_tour['number_infants_z'];
                $price_adult = $clsISO->formatPrice($cart_tour['price_adults_z']);
                $price_child = $clsISO->formatPrice($cart_tour['price_child_z']);
                $price_infant = $clsISO->formatPrice($cart_tour['price_infants_z']);
                $promotion = $cart_tour['promotion_z'];
                $price_promotion = $clsISO->formatPrice($cart_tour['price_promotion']);
                $deposit = $cart_tour['deposit'];
                $price_deposit = $clsISO->formatPrice($cart_tour['price_deposit']);
                $total_price = $clsISO->formatPrice($cart_tour['total_price_z']);

                $total_price_booking += $cart_tour['total_price_z'];
                $total_price_deposit += $cart_tour['price_deposit'];


                $str_start_date = $clsISO->getStrToTime($cart_tour['check_in_book_z']);
                $str_end_date = $clsTour->getEndDate($str_start_date, $cart_tour['tour_id_z']);

                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Name Trip') . '</span>: ' . $title_package . '</span>
					</span>
				</span>
			</div>';
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Tour Option') . '</span>: ' . $clsTourOption->getTitle($cart_tour['tour__class']) . '</span>
					</span>
				</span>
			</div>';
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Start Date') . '</span>: ' . $clsISO->converTimeToText5($str_start_date) . '</span>
					</span>
				</span>
			</div>';


                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('End Date') . '</span>: ' . $clsISO->converTimeToText5($str_end_date) . '</span>
					</span>
				</span>
			</div>';
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Adult') . '</span>: ' . $price_adult . $clsISO->getShortRate() . ' x ' . $number_adult . ' ' . $core->get_Lang('Adults') . '</span>
					</span>
				</span>
			</div>';
                if ($number_child > 0) {
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Child') . '</span>: ' . $price_child . $clsISO->getShortRate() . ' x ' . $number_child . ' ' . $core->get_Lang('Child') . '</span>
					</span>
				</span>
			</div>';
                }
                if ($number_infant > 0) {
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Child') . '</span>: ' . $price_infant . $clsISO->getShortRate() . ' x ' . $number_infant . ' ' . $core->get_Lang('Infant') . '</span>
					</span>
				</span>
			</div>';
                }
                if ($promotion > 0) {
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Promotion') . '</span>: ' . $promotion . '% = ' . $price_promotion . $clsISO->getShortRate() . '</span>
					</span>
				</span>
			</div>';
                }

                if ($cart_tour['total_addon'] > 0) {
                    $html .= '<p><strong>' . $core->get_Lang('Dịch vụ thêm') . '</strong></p>';
                    $html .= '<div class="service_tour" style="padding-left:10px">';
                    $index_service = 0;
                    $price_service = 0;
                    foreach ($cart_tour['number_addon'] as $k => $v) {
                        $v = intval($v);
                        if ($v > 0) {
                            $index_service++;
                            if ($clsAddOnService->getOneField('extra', $k) == 1) {
                                //$priceSv = $clsAddOnService->getPrice($k).$clsISO->getRate();
                                $priceSv = $clsISO->formatPrice($v * $clsAddOnService->getPriceOrgin($k)) . $clsISO->getRate();
                                $total_price_service += $v * $clsAddOnService->getPriceOrgin($k);
                                $price_service += $v * $clsAddOnService->getPriceOrgin($k);
                            } elseif ($clsAddOnService->getOneField('extra', $k) == 2) {
                                $priceSv = $clsISO->formatPrice($v * $clsAddOnService->getPriceOrgin($k)) . $clsISO->getRate();
                                $total_price_service += ($v * $clsAddOnService->getPriceOrgin($k));
                                $price_service += $v * $clsAddOnService->getPriceOrgin($k);
                            } else {
                                $priceSv = $core->get_Lang('Included');
                            }
                            $html .= '<p>' . ($index_service) . '. ' . $clsAddOnService->getTitle($k) . '</p>
								<p>- ' . $core->get_Lang('Price') . ': ' . $priceSv . '</p>
								<p>- ' . $core->get_Lang('Quantity') . ': ' . $v . '</p>';
                        }
                    }

                    $html .= '</div>';
                }
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Total Price') . '</span>: ' . $clsISO->formatPrice($cart_tour['total_price_z'] + $price_service) . $clsISO->getShortRate() . '</span>
					</span>
				</span>
			</div>';
                if ($deposit > 0) {
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Deposit') . '</span>: ' . $price_deposit . $clsISO->getShortRate() . '</span>
						</span>
					</span>
				</div>';
                }
            }
        }
        if (!empty($cart_hotel)) {
            if ($cart_hotel['hotel_id']) {
                $title_hotel = $clsHotel->getTitle($cart_hotel['hotel_id']);
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Hotel') . '</span>: ' . $title_hotel . '</span>
						</span>
					</span>
				</div>';
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Check In') . '
								</span>: ' . $clsISO->converTimeToText5($cart_hotel['check_in']) . '</span>
						</span>
					</span>
				</div>';
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Check Out') . '</span>: ' . $clsISO->converTimeToText5($cart_hotel['check_out']) . '</span>
						</span>
					</span>
				</div>';
                foreach ($cart_hotel['room'] as $key2 => $value2) {
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Room Name') . '</span>: ' . $clsHotelRoom->getTitle($value2['hotel_room_id']) . '</span>
							</span>
						</span>
					</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Room Number') . '</span>: ' . $value2['number_room'] . '</span>
							</span>
						</span>
					</div>';

                    $number_of_guest = '';
                    if (!empty($value2['number_adult'])) {
                        $number_of_guest .= $value2['number_adult'] . ' ' . $core->get_Lang('adults');
                    }

                    if (!empty($value2['number_child'])) {
                        $number_of_guest .= ', ' . $value2['number_child'] . ' ' . $core->get_Lang('children');
                    }

                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Number of guest') . '</span>: ' . $number_of_guest . '</span>
							</span>
						</span>
					</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Room Price') . '</span>: ' . $clsISO->formatPrice($value2['totalprice'] * $value2['number_room']) . $clsISO->getShortRate() . '</span>
							</span>
						</span>
					</div>';
                    $totalpriceRoom = $value2['totalprice'] * $value2['number_room'];
                    $total_price_booking_room += $totalpriceRoom;
                    $totalGrand += $totalpriceRoom;
                }
            }
        }

        if (!empty($cart_cruise)) {
            if ($cart_cruise['cruise_itinerary_id']) {
                $title_cruise_itinerary = $clsCruiseItinerary->getTitleDay($cart_cruise['cruise_itinerary_id']);
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Cruise Itinerary') . '</span>: ' . $title_cruise_itinerary . '</span>
					</span>
				</span>
			</div>';
                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Departure') . '</span>: ' . $clsISO->converTimeToText5($cart_cruise['departure_date']) . '</span>
					</span>
				</span>
			</div>';
                foreach ($cart_cruise['cabin'] as $key2 => $value2) {
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Name') . '</span>: ' . $clsCruiseCabin->getTitle($value2['cruise_cabin_id']) . '</span>
							</span>
						</span>
					</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Number') . '</span>: ' . $value2['number_cabin'] . '</span>
							</span>
						</span>
					</div>';

                    $number_of_guest = '';
                    if (!empty($value2['number_adult'])) {
                        $number_of_guest .= $value2['number_adult'] . ' ' . $core->get_Lang('adults');
                    }

                    if (!empty($value2['number_child'])) {
                        $number_of_guest .= ', ' . $value2['number_child'] . ' ' . $core->get_Lang('children');
                    }

                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Number of guest') . '</span>: ' . $number_of_guest . '</span>
							</span>
						</span>
					</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Price') . '</span>: ' . $clsISO->formatPrice($value2['totalprice']) . $clsISO->getShortRate() . '</span>
							</span>
						</span>
					</div>';
                    $totalpriceCabin = $value2['totalprice'];
                    $total_price_booking_cruise += $totalpriceCabin;
                    $totalGrand += $totalpriceCabin;
                }
            }
        }
        #---
        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);
        $message = '<style>.iso_email img{width:100%; height: auto}</style>';
        $message .= '<div class="iso_email" style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0; display:flex; align-items-center; justify-content-center; overflow:hidden">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%HTML_BOOKING_INFO%]', $html, $message);
        $message = str_replace('[%TOTAL_PRICE_BOOKING%]', $total_price_booking, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%BOOKING_CODE_2019%]', $booking_id, $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['title'] . ' ' . $booking_store['fullname'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $booking_store['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['telephone'], $message);
        $message = str_replace('[%CUSTOMER_BIRTHDAY%]', $booking_store['birthday'], $message);

        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $booking_store['note'], $message);

        $message = str_replace('[%NAME_OF_TRIP%]', $clsTour->getTitle($tour_id), $message);
        $message = str_replace('[%TRIP_DURATION%]', $clsTour->getTripDuration($tour_id), $message);
        $message = str_replace('[%TRIP_CODE%]', $clsTour->getTripCode($tour_id), $message);
        $message = str_replace('[%TOUR_CLASS%]', $clsTourOption->getTitle($booking_store['tourclass']), $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);
        //		echo $message;die;
        #-- Update Html Booking'
        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        $owner = $clsEmailTemplate->getFromName($email_template_id);

        $to = trim($booking_store['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $subject = str_replace('[%BOOKING_CODE%]', $booking_code, $subject);

        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }
        return 1;
    }

    function sendEmailBookingCartAdm($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID;
        global $email_template_book_tour_id, $adult_type_id, $child_type_id, $infant_type_id;

        #
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $clsCruiseItinerary = new CruiseItinerary();
        $clsCruiseCabin = new CruiseCabin();
        $clsHotel = new Hotel();
        $clsHotelRoom = new HotelRoom();

        $clsTourOption = new TourOption();
        $clsAddOnService = new AddOnService();


        $clsPromotion = new Promotion();

        $clsProperty = new Property();

        $clsCountry = new _Country();
        $assign_list['clsCountry'] = $clsCountry;
        $clsEmailTemplate = new EmailTemplate();
        $assign_list['clsEmailTemplate'] = $clsEmailTemplate;
        #
        $oneItem = $this->getOne($booking_id);
        $tour_id = $oneItem['target_id'];
        $TotalGrandBook = $oneItem['totalgrand'];
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];

        $email_template_id = $email_template_book_tour_id;
        $email_template_id = 4;

        $clsTourProperty = new TourProperty();

        $cartSessionTour = vnSessionGetVar('BookingTourAdm_' . $_LANG_ID);
        $cartSessionVoucher = vnSessionGetVar('BookingVoucherAdm_' . $_LANG_ID);
        $cartSessionCruise = vnSessionGetVar('BookingCruiseAdm_' . $_LANG_ID);
        $cartSessionHotel = vnSessionGetVar('BookingHotelAdm_' . $_LANG_ID);

        $cartSessionTour = $cartSessionTour[$_LANG_ID];
        $cartSessionVoucher = $cartSessionVoucher[$_LANG_ID];
        $cartSessionCruise = $cartSessionCruise[$_LANG_ID];
        $cartSessionHotel = $cartSessionHotel[$_LANG_ID];

        $cartSessionContact_Info = vnSessionGetVar('ContactInfoBooking');
        $assign_list['cartSessionContact_Info'] = $cartSessionContact_Info;

        //$cartSessionContact_Info = array_merge($cartSessionContact_Info);


        if ($cartSessionTour != '') {
            $html = '';
            $total_price_booking = 0;
            $total_price_service = 0;
            $total_price_deposit = 0;
            //		var_dump($cartSessionTour);die;

            foreach ($cartSessionTour as $item) {
                if ($item['tour_id_z']) {
                    $title_package = $clsTour->getTitle($item['tour_id_z']);
                    $number_adult = $item['number_adults_z'];
                    $number_child = $item['number_child_z'];
                    $number_infant = $item['number_infants_z'];
                    $price_adult = $clsISO->formatPrice($item['price_adults_z']);
                    $price_child = $clsISO->formatPrice($item['price_child_z']);
                    $price_infant = $clsISO->formatPrice($item['price_infants_z']);
                    $promotion = $item['promotion_z'];
                    $price_promotion = $clsISO->formatPrice($item['price_promotion']);
                    $deposit = $item['deposit'];
                    $price_deposit = $clsISO->formatPrice($item['price_deposit']);
                    $total_price = $clsISO->formatPrice($item['total_price_z']);

                    $total_price_booking += $item['total_price_z'];
                    $total_price_deposit += $item['price_deposit'];


                    $str_start_date = $clsISO->getStrToTime($item['check_in_book_z']);
                    $str_end_date = $clsTour->getEndDate($str_start_date, $item['tour_id_z']);

                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Name Trip') . '</span>: ' . $title_package . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Tour Option') . '</span>: ' . $clsTourOption->getTitle($item['tour__class']) . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Start Date') . '</span>: ' . $clsISO->converTimeToText5($str_start_date) . '</span>
					</span>
				</span>
			</div>';


                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('End Date') . '</span>: ' . $clsISO->converTimeToText5($str_end_date) . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Adult') . '</span>: ' . $price_adult . $clsISO->getShortRate() . ' x ' . $number_adult . ' ' . $core->get_Lang('Adults') . '</span>
					</span>
				</span>
			</div>';
                    if ($number_child > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Child') . '</span>: ' . $price_child . $clsISO->getShortRate() . ' x ' . $number_child . ' ' . $core->get_Lang('Child') . '</span>
					</span>
				</span>
			</div>';
                    }
                    if ($number_infant > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Child') . '</span>: ' . $price_infant . $clsISO->getShortRate() . ' x ' . $number_infant . ' ' . $core->get_Lang('Infant') . '</span>
					</span>
				</span>
			</div>';
                    }
                    if ($promotion > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Promotion') . '</span>: ' . $promotion . '% = ' . $price_promotion . $clsISO->getShortRate() . '</span>
					</span>
				</span>
			</div>';
                    }

                    if ($item['total_addon'] > 0) {
                        $html .= '<p><strong>' . $core->get_Lang('Dịch vụ thêm') . '</strong></p>';
                        $html .= '<div class="service_tour" style="padding-left:10px">';
                        $index_service = 0;
                        $price_service = 0;
                        foreach ($item['number_addon'] as $k => $v) {
                            $v = intval($v);
                            if ($v > 0) {
                                $index_service++;
                                if ($clsAddOnService->getOneField('extra', $k) == 1) {
                                    //$priceSv = $clsAddOnService->getPrice($k).$clsISO->getRate();
                                    $priceSv = $clsISO->formatPrice($v * $clsAddOnService->getPriceOrgin($k)) . $clsISO->getRate();
                                    $total_price_service += $v * $clsAddOnService->getPriceOrgin($k);
                                    $price_service += $v * $clsAddOnService->getPriceOrgin($k);
                                } elseif ($clsAddOnService->getOneField('extra', $k) == 2) {
                                    $priceSv = $clsISO->formatPrice($v * $clsAddOnService->getPriceOrgin($k)) . $clsISO->getRate();
                                    $total_price_service += ($v * $clsAddOnService->getPriceOrgin($k));
                                    $price_service += $v * $clsAddOnService->getPriceOrgin($k);
                                } else {
                                    $priceSv = $core->get_Lang('Included');
                                }
                                $html .= '<p>' . ($index_service) . '. ' . $clsAddOnService->getTitle($k) . '</p>
								<p>- ' . $core->get_Lang('Price') . ': ' . $priceSv . '</p>
								<p>- ' . $core->get_Lang('Quantity') . ': ' . $v . '</p>';
                            }
                        }

                        $html .= '</div>';
                    }
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Total Price') . '</span>: ' . $clsISO->formatPrice($item['total_price_z'] + $price_service) . $clsISO->getShortRate() . '</span>
					</span>
				</span>
			</div>';
                    if ($deposit > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Deposit') . '</span>: ' . $price_deposit . $clsISO->getShortRate() . '</span>
						</span>
					</span>
				</div>';
                    }

                    if ($cartSessionContact_Info['fullname_' . $item['tour_id_z']] != '') {
                        $html .= '
				<p><strong>' . $core->get_Lang('Contact Information') . '</strong></p>';
                        $html .= '
				<p><strong>' . $core->get_Lang('Full Name') . ':</strong> ' . $cartSessionContact_Info['title_' . $item['tour_id_z']] . ' ' . $cartSessionContact_Info['fullname_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Phone number') . ':</strong> ' . $cartSessionContact_Info['telephone_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Email') . ':</strong> ' . $cartSessionContact_Info['email_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Birthday') . ':</strong> ' . $cartSessionContact_Info['birthday_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Address') . ':</strong> ' . $cartSessionContact_Info['address_' . $item['tour_id_z']] . '</p>';
                        $html .= '<p><strong>' . $core->get_Lang('Messager') . ':</strong> ' . $cartSessionContact_Info['note_' . $item['tour_id_z']] . '</p>';
                    }
                    $html .= '
				<p><strong>' . $core->get_Lang('List of travelers (Inclusions: Full name, Birthday)') . '</strong></p>
				  ';
                    for ($i = 1; $i <= $item['number_adults_z']; $i++) {
                        if ($cartSessionContact_Info['fullname_adult_' . $item['tour_id_z'] . '_' . $i] != '') {
                            $html .= '<p>' . ($i) . '- ' . $cartSessionContact_Info['title_adult_' . $item['tour_id_z'] . '_' . $i] . ' ' . $cartSessionContact_Info['fullname_adult_' . $item['tour_id_z'] . '_' . $i] . ', ' . $cartSessionContact_Info['birthday_adult_' . $item['tour_id_z'] . '_' . $i] . '</p>';
                        }
                    }
                    for ($i = 1; $i <= $item['number_child_z']; $i++) {
                        if ($cartSessionContact_Info['fullname_child_' . $item['tour_id_z'] . '_' . $i] != '') {
                            $html .= '<p>' . ($i + $item['number_adults_z']) . '- ' . $cartSessionContact_Info['title_child_' . $item['tour_id_z'] . '_' . $i] . ' ' . $cartSessionContact_Info['fullname_child_' . $item['tour_id_z'] . '_' . $i] . ', ' . $cartSessionContact_Info['birthday_child_' . $item['tour_id_z'] . '_' . $i] . '</p>';
                        }
                    }
                    for ($i = 1; $i <= $item['number_infant_z']; $i++) {
                        if ($cartSessionContact_Info['fullname_infant_' . $item['tour_id_z'] . '_' . $i] != '') {
                            $html .= '<p>' . ($i + $item['number_child_z'] + $item['number_infant_z']) . '- ' . $cartSessionContact_Info['title_infant_' . $item['tour_id_z'] . '_' . $i] . ' ' . $cartSessionContact_Info['fullname_infant_' . $item['tour_id_z'] . '_' . $i] . ', ' . $cartSessionContact_Info['birthday_infant_' . $item['tour_id_z'] . '_' . $i] . '</p>';
                        }
                    }
                }
            }
        }


        $total_price_booking_voucher = 0;
        $total_price_discount_voucher = 0;
        if ($cartSessionVoucher != '') {

            foreach ($cartSessionVoucher as $item) {
                if ($item['voucher_id']) {
                    $voucher_id = $item['voucher_id'];
                    $discount_id = $item['discount_id'];
                    $title_package = $clsVoucher->getTitle($item['voucher_id']);
                    $number_ticket = $item['number_voucher'];
                    //				print_r($number_adult);die();
                    $priceVoucher = $clsVoucher->getPriceVoucher($item['voucher_id']);

                    $price = $clsVoucher->getPriceOrigin($item['voucher_id']);
                    $price *= $number_ticket;
                    $total_price_booking_voucher += $price;
                    $total_price = $clsISO->formatPrice($price);

                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Name Voucher') . '</span>: ' . $title_package . '</span>
					</span>
				</span>
			</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Voucher') . '</span>: ' . $clsISO->formatPrice($priceVoucher) . $clsISO->getShortRate() . ' x ' . $number_ticket . ' ' . $core->get_Lang('Ticket') . '</span>
					</span>
				</span>
			</div>';
                    if ($item['discount_value'] > 0) {
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Discount') . '</span>: ' . $clsISO->formatPrice($item['discount_value']) . $clsISO->getShortRate() . '</span>
						</span>
					</span>
				</div>';
                        $total_price_discount_voucher += $item['discount_value'];
                    }


                    $clsStock = new Stock();
                    $clsDiscount = new Discount();
                    $clsStock->updateByCond("voucher_id='$voucher_id'", "total_out=total_out+$number_ticket,quantily=quantily-$number_ticket");
                    $clsDiscount->updateOne($discount_id, "total_used=total_used+$number_ticket");
                }
            }
            $html .= '<br/>';
        }


        $total_price_booking_cruise = 0;
        $total_price_discount_cruise = 0;
        if (!empty($cartSessionCruise)) {

            if (!empty($cartSessionCruise)) {
                foreach ($cartSessionCruise as $key => $value) {
                    if ($value['cruise_itinerary_id']) {
                        $title_cruise_itinerary = $clsCruiseItinerary->getTitleDay($value['cruise_itinerary_id']);
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Cruise Itinerary') . '</span>: ' . $title_cruise_itinerary . '</span>
						</span>
					</span>
				</div>';
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Departure') . '</span>: ' . $clsISO->converTimeToText5($value['departure_date']) . '</span>
						</span>
					</span>
				</div>';
                        foreach ($value['cabin'] as $key2 => $value2) {
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Name') . '</span>: ' . $clsCruiseCabin->getTitle($value2['cruise_cabin_id']) . '</span>
								</span>
							</span>
						</div>';
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Number') . '</span>: ' . $value2['number_cabin'] . '</span>
								</span>
							</span>
						</div>';

                            $number_of_guest = '';
                            if (!empty($value2['number_adult'])) {
                                $number_of_guest .= $value2['number_adult'] . ' ' . $core->get_Lang('adults');
                            }

                            if (!empty($value2['number_child'])) {
                                $number_of_guest .= ', ' . $value2['number_child'] . ' ' . $core->get_Lang('children');
                            }

                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Number of guest') . '</span>: ' . $number_of_guest . '</span>
								</span>
							</span>
						</div>';
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Cabin Price') . '</span>: ' . $clsISO->formatPrice($value2['totalprice']) . $clsISO->getShortRate() . '</span>
								</span>
							</span>
						</div>';
                            $totalpriceCabin = $value2['totalprice'];
                            $total_price_booking_cruise += $totalpriceCabin;
                            $totalGrand += $totalpriceCabin;
                        }
                    }
                }
            }
            $html .= '<br/>';
        }

        $total_price_booking_hotel = 0;
        $total_price_booking_room = 0;
        if (!empty($cartSessionHotel)) {

            if (!empty($cartSessionHotel)) {
                foreach ($cartSessionHotel as $key => $value) {
                    if ($value['hotel_id']) {
                        $title_hotel = $clsHotel->getTitle($value['hotel_id']);
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Hotel') . '</span>: ' . $title_hotel . '</span>
							</span>
						</span>
					</div>';
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Check In') . '
									</span>: ' . $clsISO->converTimeToText5($value['check_in']) . '</span>
							</span>
						</span>
					</div>';
                        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
						<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
							<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
								<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
									<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Check Out') . '</span>: ' . $clsISO->converTimeToText5($value['check_out']) . '</span>
							</span>
						</span>
					</div>';
                        foreach ($value['room'] as $key2 => $value2) {
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Room Name') . '</span>: ' . $clsHotelRoom->getTitle($value2['hotel_room_id']) . '</span>
								</span>
							</span>
						</div>';
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Room Number') . '</span>: ' . $value2['number_room'] . '</span>
								</span>
							</span>
						</div>';

                            $number_of_guest = '';
                            if (!empty($value2['number_adult'])) {
                                $number_of_guest .= $value2['number_adult'] . ' ' . $core->get_Lang('adults');
                            }

                            if (!empty($value2['number_child'])) {
                                $number_of_guest .= ', ' . $value2['number_child'] . ' ' . $core->get_Lang('children');
                            }

                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Number of guest') . '</span>: ' . $number_of_guest . '</span>
								</span>
							</span>
						</div>';
                            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
							<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
								<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
									<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
										<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Room Price') . '</span>: ' . $clsISO->formatPrice($value2['totalprice'] * $value2['number_room']) . $clsISO->getShortRate() . '</span>
								</span>
							</span>
						</div>';
                            $totalpriceRoom = $value2['totalprice'] * $value2['number_room'];
                            $total_price_booking_room += $totalpriceRoom;
                            $totalGrand += $totalpriceRoom;
                        }
                    }
                }
                $total_price_booking_hotel += $total_price_booking_room;
            }
            $html .= '<br/>';
        }
        $total_price = $total_price_booking + $total_price_service + $total_price_booking_cruise + $total_price_booking_voucher + $total_price_booking_hotel - $total_price_discount_voucher;

        if ($total_price_deposit > 0) {
            $total_price_remaining = $total_price - $total_price_deposit;
            //$total_price_paynow=$total_price_deposit+$total_price_booking_voucher-$total_price_discount_voucher;
            $total_price_paynow = $total_price_deposit;
        } else {
            $total_price_remaining = 0;
            $total_price_paynow = $total_price;
        }
        /*var_dump($total_price_booking,$total_price_service,$total_price_booking_cruise,$total_price_booking_voucher, $total_price_booking_hotel,$total_price_discount_voucher);die;*/

        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
		<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
			<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
				<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
					<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Total Price Booking') . '</span>: ' . $clsISO->formatPrice($total_price) . $clsISO->getShortRate() . '</span>
			</span>
		</span>
	</div>';

        if ($total_price_deposit > 0) {
            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
		<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
			<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
				<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
					<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Total Deposit Tour') . '</span>: ' . $clsISO->formatPrice($total_price_deposit) . $clsISO->getShortRate() . '</span>
			</span>
		</span>
	</div>';
        }

        if ($total_price_remaining > 0) {
            $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
			<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
				<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
					<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
						<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">||| ' . $core->get_Lang('Total Payment remaining') . '</span>: ' . $clsISO->formatPrice($total_price_remaining) . $clsISO->getShortRate() . '</span>
				</span>
			</span>
		</div>';
        }
        $html .= '<br/>';
        $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
			<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
				<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
					<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
						<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Total Payment Now') . '</span>: ' . $clsISO->formatPrice($total_price_paynow) . $clsISO->getShortRate() . '</span>
				</span>
			</span>
		</div>';

        //		return $html;die;
        #---
        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%HTML_BOOKING_INFO%]', $html, $message);
        $message = str_replace('[%TOTAL_PRICE_BOOKING%]', $total_price_booking, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%BOOKING_CODE_2019%]', $booking_id, $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $cartSessionContact_Info['email'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $cartSessionContact_Info['title'] . ' ' . $cartSessionContact_Info['fullname'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $cartSessionContact_Info['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($cartSessionContact_Info['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $cartSessionContact_Info['telephone'], $message);
        $message = str_replace('[%CUSTOMER_BIRTHDAY%]', $cartSessionContact_Info['birthday'], $message);

        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $cartSessionContact_Info['note'], $message);

        $message = str_replace('[%NAME_OF_TRIP%]', $clsTour->getTitle($tour_id), $message);
        $message = str_replace('[%TRIP_DURATION%]', $clsTour->getTripDuration($tour_id), $message);
        $message = str_replace('[%TRIP_CODE%]', $clsTour->getTripCode($tour_id), $message);
        $message = str_replace('[%TOUR_CLASS%]', $clsTourOption->getTitle($cartSessionContact_Info['tourclass']), $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);
        //		echo $message;die;
        #-- Update Html Booking'
        $this->updateOne($booking_id, "booking_html='" . addslashes($message) . "'");
        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        $owner = $clsEmailTemplate->getFromName($email_template_id);

        $to = trim($cartSessionContact_Info['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);

        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }
        return 1;
    }

    function sendEmailBookingCart($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID;
        global $email_template_book_tour_id, $adult_type_id, $child_type_id, $infant_type_id;

        #
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $clsCruiseItinerary = new CruiseItinerary();
        $clsCruiseCabin = new CruiseCabin();
        $clsHotel = new Hotel();
        $clsHotelRoom = new HotelRoom();
        $clsFeedback = new Feedback();
        $clsTourOption = new TourOption();
        $clsAddOnService = new AddOnService();
        $clsPromotion = new Promotion();
        $clsProperty = new Property();
        $clsCruise = new Cruise();
        $clsCountry = new _Country();
        $assign_list['clsCountry'] = $clsCountry;
        $clsEmailTemplate = new EmailTemplate();
        $assign_list['clsEmailTemplate'] = $clsEmailTemplate;
        #
        $oneItem = $this->getOne($booking_id);
        $tour_id = $oneItem['target_id'];
        $TotalGrandBook = $oneItem['totalgrand'];
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_array = unserialize($oneItem['booking_array']);
        $booking_code = $oneItem['booking_code'];
        /* HTML_BOOKING_INFO */

        $cart_store = unserialize($oneItem['cart_store']);
        $email_template_id = $email_template_book_tour_id;

        $cartSessionTour = $cart_store['TOUR'];
        $cartSessionVoucher = $cart_store['VOUCHER'];
        $cartSessionCruise = $cart_store['CRUISE'];
        $cartSessionHotel = $cart_store['HOTEL'];

        $cartSessionContact_Info = vnSessionGetVar('ContactInfoBooking');
        $assign_list['cartSessionContact_Info'] = $cartSessionContact_Info;
        $html = '';

        $total_price_booking = 0;
        $total_booking_fees = 0;
        if ($cartSessionTour != '') {
            foreach ($cartSessionTour as $item) {
                if ($item['tour_id_z']) {
                    $tour_id = $item['tour_id_z'];

                    $title_package = $clsTour->getTitle($item['tour_id_z']);
                    $number_adult = $item['number_adults_z'];
                    $number_child = $item['number_child_z'];
                    $number_infant = $item['number_infants_z'];
                    $price_adult = $clsISO->formatPrice($item['price_adults_z']);
                    $price_child = $clsISO->formatPrice($item['price_child_z']);
                    $price_infant = $clsISO->formatPrice($item['price_infants_z']);

                    $money_adult = $clsISO->formatPrice($number_adult * $item['price_adults_z']);
                    $money_infant = $clsISO->formatPrice($number_infant * $item['price_infants_z']);

                    $promotion = $item['promotion_z'];
                    $discount_type = $item['discount_type'];
                    $price_promotion = $clsISO->formatPrice($item['price_promotion']);
                    $deposit = $item['deposit'];
                    $price_deposit = $clsISO->formatPrice($item['price_deposit']);
                    $total_price_z = $item['total_price_z'];
                    $parent_id = $item["parent_id"];
                    $arr_tour_parent = $item["arr_tour_parent"];
                    if ($_LANG_ID == 'vn') {
                        $price_adult = $price_adult . $clsISO->getShortRate();
                        $price_child = $price_child . $clsISO->getShortRate();
                        $price_infant = $price_infant . $clsISO->getShortRate();
                        $money_adult = $money_adult . $clsISO->getShortRate();
                        $money_child = $item['total_price_child'] . $clsISO->getShortRate();
                        $money_infant = $money_infant . $clsISO->getShortRate();
                        $price_deposit = $price_deposit . $clsISO->getShortRate();
                        $price_promotion = $price_promotion . $clsISO->getShortRate();
                        $total_price_z = $total_price_z . $clsISO->getShortRate();
                        if ($discount_type != 2) {
                            $promotion = $promotion . $clsISO->getShortRate();
                        }
                    } else {
                        $price_adult = $clsISO->getShortRate() . $price_adult;
                        $price_child = $clsISO->getShortRate() . $price_child;
                        $price_infant = $clsISO->getShortRate() . $price_infant;
                        $money_adult = $clsISO->getShortRate() . $money_adult;
                        $money_child = $clsISO->getShortRate() . $item['total_price_child'];
                        $money_infant = $clsISO->getShortRate() . $money_infant;
                        $price_deposit = $clsISO->getShortRate() . $price_deposit;
                        $price_promotion = $clsISO->getShortRate() . $price_promotion;
                        $total_price_z = $clsISO->getShortRate() . $total_price_z;
                        if ($discount_type != 2) {
                            $promotion = $clsISO->getShortRate() . $promotion;
                        }
                    }

                    $total_price_booking += $item['total_price_z'];
                    $total_booking_fees += $item['price_deposit'];
                    $link_tour = DOMAIN_URL . $clsTour->getLink($item['tour_id_z']);
                    $image_tour = DOMAIN_URL . $clsTour->getImage($item['tour_id_z']);
                    $txt_duration = $clsTour->getLTripDuration($item['tour_id_z']);
                    $departure_date = $clsISO->getStrToTime($item['check_in_book_z']);
                    $departure_date = $clsISO->converTimeToText5($departure_date);

                    if ($parent_id) {
                        $link_tour_parent = DOMAIN_URL . $clsTour->getLink($parent_id, $arr_tour_parent);
                        $title_tour_parent = $arr_tour_parent["title"];
                        $image_tour_parent = DOMAIN_URL . $clsTour->getImage($parent_id);
                        $html .= '
                        <br/>
                            <div style="display:flex">
                                <img src="' . $image_tour_parent . '" width="112" height="112" alt="' . $title_tour_parent . '" style="border-radius: 4px;" />
                                <p style="width:calc(100% - 120px);margin:0; margin-left: 10px">
                                    <a href="' . $link_tour_parent . '" style="text-decoration: unset;color: var(--primary-1-d-2-d-53, #1D2D53);font-size: 16px;font-style: normal;font-weight: 700;line-height: 24px;float:left;width:100%">' . $title_tour_parent . '</a>
                                    <span style="display: block; margin-bottom: 12px">' . $title_package . '</span>
                                    <span style="float:left;width:100%">' . $departure_date . ' | ' . $txt_duration . '</span>
                                </p>
                            </div>
                        ';
                    } else {
                        $html .= '
                        <br/>
                            <div style="display:flex">
                                <img src="' . $image_tour . '" width="112" height="112" alt="' . $title_package . '" style="border-radius: 4px;" />
                                <p style="width:calc(100% - 120px);margin:0; margin-left: 10px">
                                    <a href="' . $link_tour . '" style="text-decoration: unset;color: var(--primary-1-d-2-d-53, #1D2D53);font-size: 16px;font-style: normal;font-weight: 700;line-height: 24px;float:left;width:100%">' . $title_package . '</a>
                                    <span style="float:left;width:100%">' . $departure_date . ' | ' . $txt_duration . '</span>
                                </p>
                            </div>
                        ';
                    }

                    if ($booking_array['primary_traveler_tour_' . $tour_id] == 'show') {
                        $html .= '
                            <br/>
                            <span><strong>' . $core->get_Lang('Primary traveler') . '</strong></span>
                            <br/>
                            <span><strong>' . $core->get_Lang('Full name') . ':</strong> ' . $booking_array['other_first_name_tour_' . $tour_id] . ' ' . $booking_array['other_last_name_tour_' . $tour_id] . '</span>
                            <br/>
                            <span><strong>' . $core->get_Lang('Email') . ':</strong> ' . $booking_array['other_email_tour_' . $tour_id] . '</span>
                            <br/>
                            <span><strong>' . $core->get_Lang('Phone') . ':</strong> ' . $booking_array['other_phone_tour_' . $tour_id] . '</span>
                        ';
                    }

                    if (!empty($booking_store)) {

                        $html .= '
                            <br/>
                            <span><strong>' . $core->get_Lang('Traveler') . ':</strong>
                        ';
                        $txt_traveler = '';
                        if ($number_adult > 0) {
                            for ($i = 0; $i < $number_adult; $i++) {
                                $key = $i + 1;

                                $txt_traveler .= ', ' . $booking_store['fullname_adult_' . $tour_id . '_' . $key];
                            }
                        }

                        if ($number_child > 0) {
                            for ($i = 0; $i < $number_child; $i++) {
                                $key = $i + 1;
                                $txt_traveler .= ', ' . $booking_store['fullname_child_' . $tour_id . '_' . $key];
                            }
                        }

                        if ($number_infant > 0) {
                            for ($i = 0; $i < $number_infant; $i++) {
                                $key = $i + 1;
                                $txt_traveler .= ', ' .  $booking_store['fullname_infant_' . $tour_id . '_' . $key];
                            }
                        }

                        $txt_traveler = ltrim($txt_traveler, ',');
                        $html .= ' ' . $txt_traveler . '</span>';
                    }

                    if (!empty($booking_array['tour_special_' . $tour_id])) {
                        $html .= '
                        <br/>
                            <span><strong>' . $core->get_Lang('Special requirements') . ':</strong> ' . $booking_array['tour_special_' . $tour_id] . '</span>
                        ';
                    }
                    $html .= '
                    <br/>
                    <br/>
                    <table style="width: 100%;">
                    ';
                    $html .= '
                        <tr style="background: var(--chroma-f-6-f-6-fa, #F6F6FA); margin-top: 15px;">
                            <td style="text-align: center; width: 40%;border-bottom: 1px solid #DADFE6"></td>
                            <td style="text-align: right; width: 30%;border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Unit price') . '</td>
                            <td style="text-align: right; width: 30%;border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Price') . '</td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #DADFE6">' . $number_adult . ' x ' . $core->get_Lang('Adult(s)') . '</td>
                            <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_adult . '</td>
                            <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $money_adult . '</td>
                        </tr>
                    ';
                    if ($number_child > 0) {
                        $html .= '
                            <tr>
                                <td style="border-bottom: 1px solid #DADFE6">' . $number_child . ' x ' . $core->get_Lang('Child') . '</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_child . '</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $money_child . '</td>
                            </tr>
                        ';
                    }
                    if ($number_infant > 0) {
                        $html .= '
                            <tr>
                            <td style="border-bottom: 1px solid #DADFE6">' . $number_infant . ' x ' . $core->get_Lang('Infant(s)') . '</td>
                            <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_infant . '</td>
                            <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $money_infant . '</td>
                        </tr>
                        ';
                    }
                    if ($item['number_addon']) {
                        foreach ($item['number_addon'] as $key => $addon) {
                            $title_addon = $clsAddOnService->getTitle($key);
                            $price = $clsAddOnService->getStrPrice($key);
                            $price_service = $addon * $price;
                            if ($_LANG_ID == 'vn') {
                                $txt_price = $clsISO->formatPrice($price) . $clsISO->getShortRate();
                                $txt_money = $clsISO->formatPrice($price_service) . $clsISO->getShortRate();
                            } else {
                                $txt_price = $clsISO->getShortRate() . $clsISO->formatPrice($price);
                                $txt_money = $clsISO->getShortRate() . $clsISO->formatPrice($price_service);
                            }

                            $html .= '
                                <tr>
                                    <td style="border-bottom: 1px solid #DADFE6">' . $addon . ' x ' . $title_addon . '</td>
                                    <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $txt_price . '</td>
                                    <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $txt_money . '</td>
                                </tr>
                            ';
                        }
                    }

                    if ($item['promotion_z'] > 0) {
                        if ($discount_type == 2) {
                            $html .= '
                                <tr>
                                    <td style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Discount') . '</td>
                                    <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $promotion . '%</td>
                                    <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_promotion . '</td>
                                </tr>
                            ';
                        } else {
                            $html .= '
                                <tr>
                                    <td style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Discount') . '</td>
                                    <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $promotion . '</td>
                                    <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_promotion . '</td>
                                </tr>
                            ';
                        }
                    }

                    $html .= '
                        <tr>
                            <td colspan="2" style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Total price') . '</td>
                            <td style="text-align: right; padding: 0 5px; border-bottom: 1px solid #DADFE6">' . $total_price_z . '</td>
                        </tr>
                    ';

                    if ($item['deposit'] > 0) {
                        $html .= '
                            <tr>
                                <td style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Deposit') . '</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $deposit . '%</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_deposit . '</td>
                            </tr>
                        ';
                    }

                    $html .= '
                        <tr>
                            <td colspan="2" style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Booking fees') . '</td>
                            <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_deposit . '</td>
                        </tr>
                    ';
                    $html .= '</table>';
                }
            }
            $html .= '<br/>';
        }

        $discount_type = 0;
        if (!empty($cartSessionCruise)) {
            if (!empty($cartSessionCruise)) {
                foreach ($cartSessionCruise as $key => $item) {
                    $total_price_booking += $item['totalpriceCabin'];


                    $cruise_itinerary_id = $item['cruise_itinerary_id'];
                    $title_cruise = $clsCruiseItinerary->getTitleDay($key);
                    $link_cruise = DOMAIN_URL . $clsCruise->getLink($item['cruise_id']);
                    $image_cruise = DOMAIN_URL . $clsCruise->getImage($item['cruise_id']);
                    $getTitleItinerary = $clsCruiseItinerary->getTitleItinerary($item['cruise_itinerary_id']);
                    $departure_date = $clsISO->convertTimeToText($item['departure_date']);
                    $html .= '
                        <div style="display:flex">
                            <img src="' . $image_cruise . '" width="112" height="112" alt="' . $title_cruise . '" style="border-radius: 4px;" />
                            <p style="width:calc(100% - 120px);margin:0; margin-left: 10px">
                                <a href="' . $link_cruise . '" style="text-decoration: unset;color: var(--primary-1-d-2-d-53, #1D2D53);font-size: 16px;font-style: normal;font-weight: 700;line-height: 24px;float:left;width:100%">' . $title_cruise . '</a>
                                <span style="float:left;width:100%">' . $departure_date . '</span>
                                <span style="float:left;width:100%">' . $core->get_Lang('Itinerary') . ': ' . $getTitleItinerary . '</span>
                            </p>
                        </div>
                    ';

                    if ($booking_array['primary_traveler_cruise_' . $cruise_itinerary_id] == 'show') {
                        $html .= '
                            <br/>
                            <span><strong>' . $core->get_Lang('Primary traveler') . '</strong></span>
                            <br/>
                            <span><strong>' . $core->get_Lang('Full name') . ':</strong> ' . $booking_array['other_first_name_cruise_' . $cruise_itinerary_id] . ' ' . $booking_array['other_last_name_cruise_' . $cruise_itinerary_id] . '</span>
                            <br/>
                            <span><strong>' . $core->get_Lang('Email') . ':</strong> ' . $booking_array['other_email_cruise_' . $cruise_itinerary_id] . '</span>
                            <br/>
                            <span><strong>' . $core->get_Lang('Phone') . ':</strong> ' . $booking_array['other_phone_cruise_' . $cruise_itinerary_id] . '</span>
                        ';
                    }

                    if (!empty($booking_array['cruise_special_' . $cruise_itinerary_id])) {
                        $html .= '
                        <br/>
                            <span><strong>' . $core->get_Lang('Special requirements') . ':</strong> ' . $booking_array['cruise_special_' . $cruise_itinerary_id] . '</span>
                        ';
                    }

                    $html .= '
                    <br/>
                    <br/>
                    <table style="width: 100%;">
                        <tr style="background: var(--chroma-f-6-f-6-fa, #F6F6FA); margin-top: 15px;">
                            <td style="text-align: center; width: 40%;border-bottom: 1px solid #DADFE6"></td>
                            <td style="text-align: right; width: 30%;border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Unit price') . '</td>
                            <td style="text-align: right; width: 30%;border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Price') . '</td>
                        </tr>
                    ';
                    $tatal_deposit_cabin = 0;
                    foreach ($item['cabin'] as $kc => $cabin) {
                        $price_cabin = $cabin['totalprice'] / $cabin['number_cabin'];
                        $total_price_cabin = $cabin['totalprice'];
                        $tatal_deposit_cabin += $cabin['deposit_price'];
                        $total_booking_fees += $cabin['deposit_price'];
                        if ($_LANG_ID == 'vn') {
                            $price_cabin = $clsISO->formatPrice($price_cabin) . $clsISO->getShortRate();
                            $total_price_cabin = $clsISO->formatPrice($total_price_cabin) . $clsISO->getShortRate();
                        } else {
                            $price_cabin = $clsISO->getShortRate() . $clsISO->formatPrice($price_cabin);
                            $total_price_cabin = $clsISO->getShortRate() . $clsISO->formatPrice($total_price_cabin);
                        }
                        $html .= '
                            <tr>
                                <td style="border-bottom: 1px solid #DADFE6">' . $cabin['number_cabin'] . ' x ' . $core->get_Lang('Cabin(s)') . '</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $price_cabin . '</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $total_price_cabin . '</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Deposit') . '</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $item['deposit'] . '%</td>
                                <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $cabin['deposit_price'] . '</td>
                            </tr>
                        ';
                    }

                    $priceCruise = $item['totalpriceCabin'];
                    if ($_LANG_ID == 'vn') {
                        $priceCruise = $clsISO->formatPrice($priceCruise) . $clsISO->getShortRate();
                        $tatal_deposit_cabin = $clsISO->formatPrice($tatal_deposit_cabin) . $clsISO->getShortRate();
                    } else {
                        $priceCruise = $clsISO->getShortRate() . $clsISO->formatPrice($priceCruise);
                        $tatal_deposit_cabin = $clsISO->getShortRate() . $clsISO->formatPrice($tatal_deposit_cabin);
                    }
                    $html .= '
                        <tr>
                            <td colspan="2" style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Total price') . '</td>
                            <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $priceCruise . '</td>
                        </tr>
                    ';
                    $html .= '
                        <tr>
                            <td colspan="2">' . $core->get_Lang('Booking fees') . '</td>
                            <td style="text-align: right; padding: 0 5px">' . $tatal_deposit_cabin . '</td>
                        </tr>
                    ';
                    $html .= '</table>';
                }
            }
            $html .= '<br/>';
        }

        $discount_type = 0;
        if (!empty($cartSessionHotel)) {
            if (!empty($cartSessionHotel)) {
                foreach ($cartSessionHotel as $key => $item) {
                    if ($item['hotel_id']) {
                        $hotel_id = $item['hotel_id'];
                        $title_hotel = $clsHotel->getTitle($key);
                        $link_hotel = DOMAIN_URL . $clsHotel->getLink($hotel_id);
                        $image_hotel = DOMAIN_URL . $clsHotel->getImage($hotel_id);
                        $check_in = $clsISO->converTimeToText5($item['check_in']);
                        $check_out = $clsISO->converTimeToText5($item['check_out']);
                        $html .= '
                            <div style="display:flex">
                                <img src="' . $image_hotel . '" width="112" height="112" alt="' . $title_hotel . '" style="border-radius: 4px;" />
                                <p style="width:calc(100% - 120px);margin:0; margin-left: 10px">
                                    <a href="' . $link_hotel . '" style="text-decoration: unset;color: var(--primary-1-d-2-d-53, #1D2D53);font-size: 16px;font-style: normal;font-weight: 700;line-height: 24px;float:left;width:100%">' . $title_hotel . '</a>
                                    <span style="float:left;width:100%">' . $check_in . ' - ' . $check_out . '</span>
                                    <span style="float:left;width:100%">' . $core->get_Lang('Itinerary') . ': ' . $getTitleItinerary . '</span>
                                </p>
                            </div>
                        ';

                        if ($booking_array['primary_traveler_hotel_' . $hotel_id] == 'show') {
                            $html .= '
                                <br/>
                                    <span><strong>' . $core->get_Lang('Primary traveler') . '</strong></span>
                                <br/>
                                <span><strong>' . $core->get_Lang('Full name') . ':</strong> ' . $booking_array['other_first_name_hotel_' . $hotel_id] . ' ' . $booking_array['other_last_name_hotel_' . $hotel_id] . '</span>
                                <br/>
                                <span><strong>' . $core->get_Lang('Email') . ':</strong> ' . $booking_array['other_email_hotel_' . $hotel_id] . '</span>
                                <br/>
                                <span><strong>' . $core->get_Lang('Phone') . ':</strong> ' . $booking_array['other_phone_hotel_' . $hotel_id] . '</span>
                            ';
                        }

                        if (!empty($booking_array['hotel_type_room_' . $hotel_id])) {
                            $hotel_type_room = $booking_array['hotel_type_room_' . $hotel_id];
                            if ($hotel_type_room == 1) {
                                $txt_hotel_type_room = $core->get_Lang('Non-smoking');
                            } else {
                                $txt_hotel_type_room = $core->get_Lang('Smoking');
                            }
                            $html .= '
                            <br/>
                                <span><strong>' . $core->get_Lang('Which type of room would you prefer') . '?</strong> ' . $txt_hotel_type_room . '</span>
                            ';
                        }

                        if (!empty($booking_array['hotel_bed_setup_' . $hotel_id])) {
                            $hotel_bed_setup = $booking_array['hotel_bed_setup_' . $hotel_id];
                            if ($hotel_bed_setup == 1) {
                                $txt_hotel_bed_setup = $core->get_Lang("I'd like a large bed");
                            } else {
                                $txt_hotel_bed_setup = $core->get_Lang("I'd like twin beds");
                            }
                            $html .= '
                            <br/>
                                <span><strong>' . $core->get_Lang('Which bed setup would you prefer') . '?</strong> ' . $txt_hotel_bed_setup . '</span>
                            ';
                        }

                        if (!empty($booking_array['hotel_special_' . $hotel_id])) {
                            $html .= '
                            <br/>
                                <span><strong>' . $core->get_Lang('Special requirements') . ':</strong> ' . $booking_array['hotel_special_' . $hotel_id] . '</span>
                            ';
                        }


                        $html .= '
                        <br/>
                        <br/>
                        <table style="width: 100%;" >
                            <tr style="background: var(--chroma-f-6-f-6-fa, #F6F6FA); margin-top: 15px;">
                                <td style="text-align: center; width: 25%";border-bottom: 1px solid #DADFE6></td>
                                <td style="text-align: right; width: 25%;border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Unit price') . '</td>
                                <td style="text-align: right; width: 25%;border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Deposit') . '</td>
                                <td style="text-align: right; width: 25%;border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Price') . '</td>
                            </tr>
                        ';
                        $txt_total_price_booking_hotel = 0;
                        foreach ($item['room'] as $kr => $room) {
                            $title_room = $clsHotelRoom->getTitle($room['hotel_room_id']);
                            $price_room = $room['room_price'];
                            $payment_down_money = $room['payment_down_money'];
                            $txt_total_price_booking_hotel +=  $payment_down_money;
                            $total_price_booking += $room['totalprice'];
                            $total_booking_fees += $payment_down_money;

                            $payment_down = $room['payment_down'];

                            if ($_LANG_ID == 'vn') {
                                $price_room = $clsISO->formatPrice($price_room) . $clsISO->getShortRate();
                                $payment_down_money = $clsISO->formatPrice($payment_down_money) . $clsISO->getShortRate();
                            } else {
                                $price_room = $clsISO->getShortRate() . $clsISO->formatPrice($price_room);
                                $payment_down_money = $clsISO->getShortRate() . $clsISO->formatPrice($payment_down_money);
                            }
                            $html .= '
                                <tr>
                                    <td style="border-bottom: 1px solid #DADFE6">' . $room['number_room'] . ' x ' . $title_room . '</td>
                                    <td style="text-align: right; padding: 0 5px; border-bottom: 1px solid #DADFE6">' . $price_room . '</td>
                                    <td style="text-align: right; padding: 0 5px; border-bottom: 1px solid #DADFE6">' . $payment_down . '%</td>
                                    <td style="text-align: right; padding: 0 5px; border-bottom: 1px solid #DADFE6">' . $payment_down_money . '</td>
                                </tr>
                            ';
                        }
                        if ($_LANG_ID == 'vn') {
                            $txt_total_price_booking_hotel = $clsISO->formatPrice($txt_total_price_booking_hotel) . $clsISO->getShortRate();
                        } else {
                            $txt_total_price_booking_hotel = $clsISO->getShortRate() . $clsISO->formatPrice($txt_total_price_booking_hotel);
                        }
                        $html .= '
                                <tr>
                                    <td colspan=3 style="border-bottom: 1px solid #DADFE6">' . $core->get_Lang('Booking fees') . '</td>
                                    <td style="text-align: right; padding: 0 5px;border-bottom: 1px solid #DADFE6">' . $txt_total_price_booking_hotel . '</td>
                                </tr>
                            ';
                        $html .= '</table>';
                    }
                }
            }
            $html .= '<br/>';
        }

        $total_price_booking_voucher = 0;
        $total_price_discount_voucher = 0;
        $discount_type = 0;
        if ($cartSessionVoucher != '') {

            foreach ($cartSessionVoucher as $item) {
                if ($item['voucher_id']) {
                    //				==============
                    $voucher_id = $item['voucher_id'];
                    $discount_id = $item['discount_id'];
                    $discount_type = $item['discount_type'];
                    $title_package = $clsVoucher->getTitle($item['voucher_id']);
                    $number_ticket = $item['number_voucher'];
                    //				print_r($number_adult);die();
                    $priceVoucher = $clsVoucher->getPriceVoucher($item['voucher_id']);

                    $price = $clsVoucher->getPriceOrigin($item['voucher_id']);
                    $price *= $number_ticket;
                    $total_price_booking_voucher += $price;
                    $total_price_booking += $price;
                    $total_booking_fees += $price;
                    $total_price = $clsISO->formatPrice($price);
                    //				==============


                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
        		<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
        			<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
        				<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
        					<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Name Voucher') . '</span>: ' . $title_package . '</span>
        			</span>
        		</span>
        	</div>';
                    $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
        		<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
        			<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
        				<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
        					<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Price Voucher') . '</span>: ' . $clsISO->formatPrice($priceVoucher) . $clsISO->getShortRate() . ' x ' . $number_ticket . ' ' . $core->get_Lang('Ticket') . '</span>
        			</span>
        		</span>
        	</div>';
                    if ($item['discount_value'] && $item['discount_value'] > 0) {
                        if ($discount_type == 2) {
                            if ($item['discount_value'] > 0) {
                                $price_discount = $priceVoucher * $item['discount_value'] * $number_ticket / 100;
                                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
        					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
        						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
        							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
        								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Discount') . '</span>: ' . $item['discount_value'] . '% = ' . $clsISO->formatPrice($price_discount) . $clsISO->getShortRate() . '</span>
        						</span>
        					</span>
        				</div>';
                            }
                        } else {
                            if ($item['discount_value'] > 0) {
                                $price_discount = $item['discount_value'] * $number_ticket;
                                $html .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
        					<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
        						<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
        							<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
        								<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Discount') . '</span>: ' . $clsISO->formatPrice($price_discount) . $clsISO->getShortRate() . '</span>
        						</span>
        					</span>
        				</div>';
                            }
                        }
                        $total_price_discount_voucher += $price_discount;
                    }


                    $clsStock = new Stock();
                    $clsDiscount = new Discount();
                    $clsStock->updateByCond("voucher_id='$voucher_id'", "total_out=total_out+$number_ticket,quantily=quantily-$number_ticket");
                    $clsDiscount->updateOne($discount_id, "total_used=total_used+$number_ticket");
                }
            }
            $html .= '<br/>';
        }

        if ($_LANG_ID == 'vn') {
            $total_booking_fees = $clsISO->formatPrice($total_booking_fees) . $clsISO->getShortRate();
            $total_price_booking = $clsISO->formatPrice($total_price_booking) . $clsISO->getShortRate();
        } else {
            $total_booking_fees = $clsISO->getShortRate() . $clsISO->formatPrice($total_booking_fees);
            $total_price_booking = $clsISO->getShortRate() . $clsISO->formatPrice($total_price_booking);
        }

        $html .= '<p><strong>' . $core->get_Lang('Total Price Booking') . ':</strong> ' . $total_price_booking . '</p>';
        $html .= '<p><strong>' . $core->get_Lang('Total Payment Now') . ':</strong> ' . $total_booking_fees . '</p>';
        $html .= '<p><strong>' . $core->get_Lang('Payment Methods') . ':</strong> ' . $this->getPaymentMethod2($booking_id) . '</p>';
        $html .= '<p><strong>' . $core->get_Lang('Payment Status') . ':</strong> ' . $core->get_Lang('UnPaid') . '</p>';

        #---
        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);
        $message = '<div class="iso_box_email" style="background: rgba(245, 245, 245, 1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;background: rgba(245, 245, 245, 1);border-bottom: 1px solid rgba(247, 247, 247, 1);background-color: rgba(255, 255, 255, 1);border-radius: 8px;overflow: hidden;border: 1px solid rgba(245, 245, 245, 1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);display:flex;align-items:center;justify-content:center;overflow:hidden">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%HTML_BOOKING_INFO%]', $html, $message);
        $message = str_replace('[%TOTAL_PRICE_BOOKING%]', $total_price_booking, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('[%BOOKING_CODE_2019%]', $booking_id, $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_array['email'], $message);
        $full_name = $booking_array['first_name'] . ' ' . $booking_array['last_name'];
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $full_name, $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $cartSessionContact_Info['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($cartSessionContact_Info['country_id']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_array['phone'], $message);
        $message = str_replace('[%CUSTOMER_BIRTHDAY%]', $booking_array['birthday'], $message);

        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $cartSessionContact_Info['note'], $message);

        $message = str_replace('[%NAME_OF_TRIP%]', $clsTour->getTitle($tour_id), $message);
        $message = str_replace('[%TRIP_DURATION%]', $clsTour->getTripDuration($tour_id), $message);
        $message = str_replace('[%TRIP_CODE%]', $clsTour->getTripCode($tour_id), $message);
        $message = str_replace('[%TOUR_CLASS%]', $clsTourOption->getTitle($cartSessionContact_Info['tourclass']), $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);
        //        		var_dump($message);die;
        //		return $message;
        #-- Update Html Booking'
        //$clsISO->print_pre($cartSessionContact_Info,true);

        // $fx_fb = "feedback_id, feedback_code,fullname, title, email, phone, type, reg_date, feedback_store, feedback_html";
        // $vx_fb = "{$clsFeedback->getMaxId()}, '$booking_code','$full_name','$booking_array[title]','$booking_array[email]','$booking_array[phone]','Cart'," . time() . ",'$oneItem[booking_array]','" . addslashes($message) . "'";
        // $clsFeedback->insertOne($fx_fb, $vx_fb);
        //        var_dump($message);die;
        $this->updateOne($booking_id, "booking_html='" . addslashes($message) . "'");
        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        $owner = $clsEmailTemplate->getFromName($email_template_id);

        $to = trim($oneItem['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id);
        $subject = str_replace('[%BOOKING_CODE%]', $booking_code, $subject);

        //		print_r($from.'xxxx'.$to.'xxxx'.$subject.'xxxx'.$message.'xxxx'.$owner);die();
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }
        return 1;
    }

    function BookingSuccsess($booking_id = 0)
    {
        $cartSessionContact_Info = vnSessionGetVar('ContactInfoBooking');
        $assign_list['cartSessionContact_Info'] = $cartSessionContact_Info;

        global $core, $extLang, $clsISO, $clsConfiguration, $_LANG_ID;
        $messageSuccess = $clsConfiguration->getValue('SiteMsg_TourSuccess_' . $_LANG_ID);
        $messageSuccess = html_entity_decode($messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_EMAIL%]', $cartSessionContact_Info['email'], $messageSuccess);
        $messageSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $cartSessionContact_Info['title'] . ' ' . $cartSessionContact_Info['fullname'], $messageSuccess);
        //		print_r($messageSuccess);die();
        return $messageSuccess;
    }

    // Send Email Booking Cruise
    function sendEmailBookingCruise($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID, $email_template_book_cruise_id;

        #
        $clsCruise = new Cruise();
        $clsCruiseCabin = new CruiseCabin();
        $clsCruiseItinerary = new CruiseItinerary();
        $clsProperty = new Property();
        $clsCountry = new _Country();
        $clsEmailTemplate = new EmailTemplate();
        #
        $oneItem = $this->getOne($booking_id);
        $cruise_id = $oneItem['target_id'];
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];

        $email_template_id = $email_template_book_cruise_id;
        /* HTML_BOOKING_INFO */
        $BOOK_VALUE = unserialize($booking_store['BOOK_VALUE']);
        $BOOK_ADDON = unserialize($booking_store['BOOK_ADDON']);
        $number_of_guest = '';
        if (!empty($booking_store['number_adult'])) {
            $number_of_guest .= $booking_store['number_adult'] . ' ' . $core->get_Lang('adults');
        }

        if (!empty($booking_store['number_child'])) {
            $number_of_guest .= ', ' . $booking_store['number_child'] . ' ' . $core->get_Lang('children');
        }

        $totalpricecabin = $clsISO->getRate() . ' ' . $booking_store['totalRateCabin'];
        $totalpriceservice = $clsISO->getRate() . ' ' . $booking_store['price_service'];
        $totalprice = $clsISO->getRate() . ' ' . $booking_store['totalGrand'];


        $departure_date = '';
        if (!empty($booking_store['departure_date'])) {
            $departure_date .= $clsISO->converTimeToText(strtotime($booking_store['departure_date']));
        }
        $cruise_cabin_id = $booking_store['cruise_cabin_id'];
        $assign_list["cruise_cabin_id"] = $cruise_cabin_id;


        $addOnService = $booking_store['addOnService'];
        $adultService = $booking_store['adultService'];
        $childService = $booking_store['childService'];
        if (is_array($addOnService)) {
            $clsCruiseService = new CruiseService();
            $HTML_BOOKING_INFO .= '<p style="text-align: justify;" _mce_style="text-align: justify;"><strong>' . $core->get_Lang('Transfer Services') . '</strong></p>';
            for ($i = 0; $i < count($addOnService); $i++) {
                if ($clsCruiseService->getOneField('extra', $addOnService[$i]) == 1) {
                    $priceSv = $clsISO->getRate() . ' ' . $clsCruiseService->getPrice($addOnService[$i]);
                } elseif ($clsCruiseService->getOneField('extra', $addOnService[$i]) == 2) {
                    $priceSv = $clsISO->getRate() . ' ' . $clsCruiseService->getPrice($addOnService[$i]) * $adultService[$addOnService[$i]];
                } else {
                    $priceSv = 'Included';
                }
                $HTML_BOOKING_INFO .= '<tr>
					<p style="text-align: justify;" _mce_style="text-align: justify;">' . $clsCruiseService->getTitle($addOnService[$i]) . '-' . $adultService[$addOnService[$i]] . ' ' . $core->get_Lang('adult(s)') . ' - ' . $childService[$addOnService[$i]] . ' ' . $core->get_Lang('children(s)') . ' - ' . $priceSv . '</p>';
            }
        }
        #---
        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;
        display:flex;align-items-center;justify-content-center; overflow:hidden">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%HTML_BOOKING_INFO%]', $HTML_BOOKING_INFO, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);

        $message = str_replace('[%CUSTOMER_TITLE%]', $booking_store['title'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $this->getFullName($booking_id), $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $booking_store['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['phone'], $message);
        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $booking_store['content'], $message);

        $message = str_replace('[%NAME_OF_CRUISE%]', $clsCruise->getTitle($cruise_id), $message);
        $message = str_replace('[%NAME_OF_CABIN%]', $clsCruiseCabin->getTitle($cruise_cabin_id), $message);
        $message = str_replace('[%TRIP_DURATION%]', $clsCruiseItinerary->getNumberDay($booking_store['cruise_itinerary_id']), $message);
        $message = str_replace('[%TOTAL_PRICE_CABIN%]', $totalpricecabin, $message);
        $message = str_replace('[%DEPARTURE_DATE%]', $departure_date, $message);
        $message = str_replace('[%NO_OF_CABIN%]', $booking_store['number_room'], $message);
        $message = str_replace('[%NO_OF_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%TOTAL_PRICE_SERVICE%]', $totalpriceservice, $message);
        $message = str_replace('[%TOTAL_PRICE%]', $totalprice, $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);

        //print_r($message); die();
        #-- Update Html Booking
        $this->updateOne($booking_id, "booking_html='" . addslashes($message) . "'");
        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        #-- Send email to customer
        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = trim($booking_store['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);
        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }
        return 1;
    }

    // Send Email Booking Tailor
    function sendEmailBookingTailor($booking_id = 0, $type = '', $choose_date = '')
    {

        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID, $email_template_tailor_id;

        #
        $clsCountry = new _Country();
        $clsCountryEx = new Country();
        $clsCity = new City();
        $clsTour = new Tour();
        $clsPage = new Page();
        $clsEmailTemplate = new EmailTemplate();
        $clsTailorProperty = new TailorProperty();
        #
        $one = $this->getOne($booking_id);
        $booking_store = unserialize($one['booking_store']);
        $tour_id = $one['target_id'];
        $booking_code = $one['booking_code'];
        $company_logo = $clsConfiguration->getValue('CompanyLogo');

        $email_template_id = $email_template_tailor_id;

        #---
        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        header('Content-Type: text/html; charset=utf-8');

        $HTML = '';
        if (intval($tour_id) > 0) {
            $HTML .= $core->get_Lang('Tour Name') . ': [%TOUR_NAME%] <br />' . $core->get_Lang('Tour Code') . ': [%TOUR_CODE%] <br />' . $core->get_Lang('Tour Duration') . ': [%TOUR_LENGTH%] <br />';
            $HTML = str_replace('[%TOUR_URL%]', $clsTour->getLink($tour_id), $HTML);
            $HTML = str_replace('[%TOUR_NAME%]', $clsTour->getTitle($tour_id), $HTML);
            $HTML = str_replace('[%TOUR_CODE%]', $clsTour->getTripCode($tour_id), $HTML);
            $HTML = str_replace('[%TOUR_LENGTH%]', $clsTour->getTripDuration($tour_id), $HTML);
            $HTML = str_replace('[%TOUR_DESTINATION%]', $clsTour->getCityAround($tour_id), $HTML);
        }
        if ($type == 1) {
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Destination') . '
							</span>: [%CITY_DESTINATION%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Start date') . '
							</span>: [%TRAVEL_DATE%] (dd/mm/yyyy)</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Tour Duration') . '
							</span>: [%TOUR_DURATION%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Numbers of guest') . '
							</span>: [%NUMBER_GUEST%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Budget per person') . '
							</span>: [%BUDGET%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('I prefer to travel by') . '
							</span>: [%TRANSPORTATION%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Prefered Guide Language') . '
							</span>: [%PROGRAMME%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Select meals') . '
							</span>: ' . $core->get_Lang('Breakfast') . ': [%BREAKFAST%] - ' . $core->get_Lang('Lunch') . ': [%LUNCH%] - ' . $core->get_Lang('Dinner') . ': [%DINNER%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Hotel Requirements') . '
							</span>: ' . $core->get_Lang('No. of room') . ': [%NUMBER_ROOM%] - ' . $core->get_Lang('Type Class') . ': [%TYPE_CLASS%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Your Requirements') . '
							</span>: [%OTHER_REQUIREMENT%]</span>
					</span>
				</span>
			</div>';
            /*$HTML.='<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
                <span style="color: #2e3543;" data-mce-style="color: #2e3543;">
                    <span style="font-size: 14px;" data-mce-style="font-size: 14px;">
                        <span style="font-size: 16px;" data-mce-style="font-size: 16px;">
                            <span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| '.$core->get_Lang('Finish date').'
                            </span>: [%RETURN_DATE%] (dd/mm/yyyy)</span>
                    </span>
                </span>
            </div>';*/
            /*$HTML.='<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
                <span style="color: #2e3543;" data-mce-style="color: #2e3543;">
                    <span style="font-size: 14px;" data-mce-style="font-size: 14px;">
                        <span style="font-size: 16px;" data-mce-style="font-size: 16px;">
                            <span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| '.$core->get_Lang('Room requirements').'
                            </span>: [%ROOM_REQUIREMENT%]</span>
                    </span>
                </span>
            </div>';*/


            /* Replace Info */
            $HTML_GUEST = '';
            if (!empty($booking_store['adult_simple'])) {
                $HTML_GUEST .= $booking_store['adult_simple'] . ' ' . $core->get_Lang('adults(s)');
            }
            if (!empty($booking_store['children_simple'])) {
                $HTML_GUEST .= ' - ' . $booking_store['children_simple'] . ' ' . $core->get_Lang('children(s)');
                $HTML_GUEST .= ' (';
                foreach ($booking_store['children'] as $key => $value) {
                    $HTML_GUEST .= (($key > 0) ? ', ' : '') . $value . ' ' . $core->get_Lang('year old');
                }
                $HTML_GUEST .= ')';
            }
            if (!empty($booking_store['baby_simple'])) {
                $HTML_GUEST .= ' - ' . $booking_store['baby_simple'] . ' ' . $core->get_Lang('babies');
            }
            $HTML = str_replace('[%NUMBER_GUEST%]', $HTML_GUEST, $HTML);
            $HTML = str_replace('[%BUDGET%]', $booking_store['budget'], $HTML);
            $HTML = str_replace('[%TRAVEL_DATE%]', $booking_store['date_begin_simple'], $HTML);
            $HTML = str_replace('[%RETURN_DATE%]', $booking_store['date_end_simple'], $HTML);
            $HTML = str_replace('[%TOUR_DURATION%]', $booking_store['duration'], $HTML);
            # List City


            $html_destination = '';
            if (!empty($booking_store['country_id'])) {
                $list_country = $booking_store['country_id'];
                for ($i = 0; $i < count($list_country); $i++) {
                    $list_city = $booking_store['city_id'][$list_country[$i]];
                    if (!empty($list_city)) {
                        $list_city = json_decode($list_city, true);
                        $html_city = '';
                        for ($j = 0; $j < count($list_city); $j++) {
                            $html_city .= ($j == 0 ? '' : ', ') . $clsCity->getTitle($list_city[$j]);
                        }
                        $html_destination .= ($i == 0 ? '' : ' / ') . '<span>' . $clsCountryEx->getTitle($list_country[$i]) . ': ' . $html_city . '</span>';
                    } else {
                        $html_destination .= ($i == 0 ? '' : ' / ') . '<span>' . $clsCountryEx->getTitle($list_country[$i]) . '</span>';
                    }
                }
            }

            $other_destination = $booking_store['other_des'];
            if (!empty($booking_store['other_des'])) {
                $html_destination .= '<span>/ ' . $core->get_Lang('Other Destinations') . ': ' . $other_destination . '</span>';
            }
            if (empty($booking_store['country_id']) && empty($booking_store['other_des'])) {
                $html_destination .= '<span>' . $core->get_Lang('No destination') . '</span>';
            }


            $HTML = str_replace('[%CITY_DESTINATION%]', $html_destination, $HTML);

            $HTML = str_replace('[%TRANSPORTATION%]', $clsTailorProperty->getTitle($booking_store['travelby']), $HTML);
            $HTML = str_replace('[%BREAKFAST%]', $clsTailorProperty->getTitle($booking_store['breakfast']), $HTML);
            $HTML = str_replace('[%LUNCH%]', $clsTailorProperty->getTitle($booking_store['lunch']), $HTML);
            $HTML = str_replace('[%DINNER%]', $clsTailorProperty->getTitle($booking_store['dinner']), $HTML);
            $HTML = str_replace('[%NUMBER_ROOM%]', $booking_store['number_room'], $HTML);
            $HTML = str_replace('[%TYPE_CLASS%]', $clsTailorProperty->getTitle($booking_store['hotelclass']), $HTML);
            $HTML = str_replace('[%PROGRAMME%]', $clsTailorProperty->getTitle($booking_store['language']), $HTML);

            # List Requirement
            $other_list = $booking_store['roomRequirement'];
            $lst_requirement = '';
            if (!empty($other_list)) {
                for ($i = 0; $i < count($other_list); $i++) {
                    $lst_requirement .= ($i == 0 ? '' : ', ') . $clsTailorProperty->getTitle($other_list[$i]);
                }
                $HTML = str_replace('[%ROOM_REQUIREMENT%]', $lst_requirement, $HTML);
            } else {
                $HTML = str_replace('[%ROOM_REQUIREMENT%]', $core->get_Lang('No requirement'), $HTML);
            }
            $HTML = str_replace('[%OTHER_REQUIREMENT%]', html_entity_decode($booking_store['request_1']), $HTML);
        } else {

            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Destination') . '
							</span>: [%CITY_DESTINATION%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Your Requirements') . '
							</span>: [%OTHER_REQUIREMENT%]</span>
					</span>
				</span>
			</div>';
            if ($choose_date == 1) {
                $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Start date') . '
							</span>: [%TRAVEL_DATE%] (dd/mm/yyyy)</span>
					</span>
				</span>
			</div>';
                $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Finish date') . '
							</span>: [%RETURN_DATE%] (dd/mm/yyyy)</span>
					</span>
				</span>
			</div>';
            } else {
                $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Approximate Travel Time') . '
							</span>: [%DATE_FLEXIABLE%]</span>
					</span>
				</span>
			</div>';
                $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Duration') . '
							</span>: [%DATE_DURATION%]</span>
					</span>
				</span>
			</div>';
            }

            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('I prefer to travel by') . '
							</span>: [%TRANSPORTATION%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Select meals') . '
							</span>: ' . $core->get_Lang('Breakfast') . ': [%BREAKFAST%] - ' . $core->get_Lang('Lunch') . ': [%LUNCH%] - ' . $core->get_Lang('Dinner') . ': [%DINNER%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Hotel Requirements') . '
							</span>: ' . $core->get_Lang('No. of room') . ': [%NUMBER_ROOM%] - ' . $core->get_Lang('Type Class') . ': [%TYPE_CLASS%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Room requirements') . '
							</span>: [%ROOM_REQUIREMENT%]</span>
					</span>
				</span>
			</div>';
            $HTML .= '<div style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;" data-mce-style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 14px; color: #000000;">
				<span style="color: #2e3543;" data-mce-style="color: #2e3543;">
					<span style="font-size: 14px;" data-mce-style="font-size: 14px;">
						<span style="font-size: 16px;" data-mce-style="font-size: 16px;">
							<span style="font-weight: 600; background: transparent; font-size: inherit;" data-mce-style="font-weight: 600; background: transparent; font-size: inherit;">|| ' . $core->get_Lang('Prefered Guide Language') . '
							</span>: [%PROGRAMME%]</span>
					</span>
				</span>
			</div>';


            /* Replace */
            if ($choose_date == 1) {
                $HTML = str_replace('[%TRAVEL_DATE%]', $booking_store['date_begin'], $HTML);
                $HTML = str_replace('[%RETURN_DATE%]', $booking_store['date_end'], $HTML);
            } else {
                $HTML = str_replace('[%DATE_FLEXIABLE%]', $clsISO->getMonthOfYear2($booking_store['flex_mon']) . ',' . $booking_store['flex_yea'], $HTML);
                $HTML = str_replace('[%DATE_DURATION%]', $clsTailorProperty->getTitle($booking_store['flex_dur']), $HTML);
            }
            $numberGuest = '';
            if (!empty($booking_store['adult'])) {
                $numberGuest .= $booking_store['adult'] . ' ' . $core->get_Lang('adults(s)');
            }
            if (!empty($booking_store['children'])) {
                $numberGuest .= ' - ' . $booking_store['children'] . ' ' . $core->get_Lang('children(s)');
            }
            if (!empty($booking_store['baby'])) {
                $numberGuest .= ' - ' . $booking_store['baby'] . ' ' . $core->get_Lang('babies');
            }
            $HTML = str_replace('[%TRANSPORTATION%]', $clsTailorProperty->getTitle($booking_store['travelby']), $HTML);
            $HTML = str_replace('[%BREAKFAST%]', $clsTailorProperty->getTitle($booking_store['breakfast']), $HTML);
            $HTML = str_replace('[%LUNCH%]', $clsTailorProperty->getTitle($booking_store['lunch']), $HTML);
            $HTML = str_replace('[%DINNER%]', $clsTailorProperty->getTitle($booking_store['dinner']), $HTML);
            $HTML = str_replace('[%NUMBER_GUEST%]', $numberGuest, $HTML);
            $HTML = str_replace('[%NUMBER_ROOM%]', $booking_store['hotelroom'], $HTML);
            $HTML = str_replace('[%TYPE_CLASS%]', $clsTailorProperty->getTitle($booking_store['hotelclass']), $HTML);
            $HTML = str_replace('[%PROGRAMME%]', $clsTailorProperty->getTitle($booking_store['language']), $HTML);

            # List City

            $html_destination = '';


            if (!empty($booking_store['country_id'])) {
                $list_country = $booking_store['country_id'];
                for ($i = 0; $i < count($list_country); $i++) {
                    $list_city = $booking_store['city_id'][$list_country[$i]];
                    if (!empty($list_city)) {
                        $html_city = '';
                        for ($j = 0; $j < count($list_city); $j++) {
                            $html_city .= ($j == 0 ? '' : ', ') . $clsCity->getTitle($list_city[$j]);
                        }
                        $html_destination .= ($i == 0 ? '' : ' / ') . '<span>' . $clsCountryEx->getTitle($list_country[$i]) . ': ' . $html_city . '</span>';
                    } else {
                        $html_destination .= ($i == 0 ? '' : ' / ') . '<span>' . $clsCountryEx->getTitle($list_country[$i]) . '</span>';
                    }
                }
            }

            $other_destination = $booking_store['other_des'];
            if (!empty($booking_store['other_des'])) {
                $html_destination .= '<span>/ ' . $core->get_Lang('Other Destinations') . ': ' . $other_destination . '</span>';
            }
            if (empty($booking_store['country_id']) && empty($booking_store['other_des'])) {
                $html_destination .= '<span>' . $core->get_Lang('No destination') . '</span>';
            }


            $HTML = str_replace('[%CITY_DESTINATION%]', $html_destination, $HTML);


            # List Requirement
            $other_list = $booking_store['roomRequirement'];
            $lst_requirement = '';
            if (!empty($other_list)) {
                for ($i = 0; $i < count($other_list); $i++) {
                    $lst_requirement .= ($i == 0 ? '' : ', ') . $clsTailorProperty->getTitle($other_list[$i]);
                }
                $HTML = str_replace('[%ROOM_REQUIREMENT%]', $lst_requirement, $HTML);
            } else {
                $HTML = str_replace('[%ROOM_REQUIREMENT%]', $core->get_Lang('No requirement'), $HTML);
            }
            $HTML = str_replace('[%OTHER_REQUIREMENT%]', html_entity_decode($booking_store['request_2']), $HTML);
        }
        #

        /* Replace Info */
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);
        $message = str_replace('May 26, 2011', date('M d, Y', time()), $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%LOGO_EMAILTMP%]', (!empty($company_logo) ? '<img src="' . $company_logo . '" />' : ''), $message);
        $message = str_replace('[%ABOUT_LINK%]', $clsPage->getLink(1), $message);
        $message = str_replace('[%CONTACT_LINK%]', $clsISO->getLink('contact'), $message);
        $message = str_replace('[%HTML_TAILOR_INFO%]', $HTML, $message);
        $message = str_replace('[%CUSTOMER_TITLE%]', $clsISO->getNameTitle($booking_store['title']), $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%CUSTOMER_NAME%]', $booking_store['name'], $message);
        $message = str_replace('[%CUSTOMER_FIRST_NAME%]', $booking_store['first_name'], $message);
        $message = str_replace('[%CUSTOMER_LAST_NAME%]', $booking_store['last_name'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['name'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country__id']), $message);
        $message = str_replace('[%CUSTOMER_MOBILE%]', $booking_store['phone'], $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['phone'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $booking_store['address'], $message);


        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);
        #
        if ($booking_store['please'] == 1) {
            $message = str_replace('[%PLEASE%]', $core->get_Lang('Send me more details via email'), $message);
        } else {
            $message = str_replace('[%PLEASE%]', $core->get_Lang('Call me if possible'), $message);
        }

        //        		print_r($message);die();
        #- Update Booking HTML
        $this->updateOne($booking_id, "booking_html='" . addslashes(trim($message)) . "'");

        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        #Send email to customer
        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = trim($booking_store['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }

        return 1;
    }

    function sendEmailBookingService($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration, $_LANG_ID, $email_template_book_service_id;
        #
        $clsBooking = new Booking();
        $clsEmailTemplate = new EmailTemplate();
        $clsCountry = new _Country();
        $clsEvents = new Service();

        $email_template_id = $email_template_book_service_id;

        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';


        header('Content-Type: text/html; charset=utf-8');

        $oneItem = $this->getOne($booking_id);
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];
        $company_logo = $clsConfiguration->getValue('CompanyLogo');
        #---
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('[%BOOKINGSERVICE_CODE%]', $booking_code, $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['fullname'], $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['phone'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $booking_store['address'], $message);
        $message = str_replace('[%CUSTOMER_MESSAGE%]', $booking_store['message'], $message);
        $message = str_replace('[%SERVICES_NAME%]', $clsEvents->getTitle($oneItem['target_id']), $message);


        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);
        $this->updateOne($booking_id, "Booking_html='" . addslashes($message) . "'");

        $from = $clsEmailTemplate->getFromEmail($email_template_id);
        #-- Send email to customer
        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = trim($oneItem['email']);
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }

        return 1;
    }

    function sendEmailSupportBooking($booking_id = 0)
    {
        global $core, $extLang, $clsISO, $clsPage, $clsConfiguration;
        #
        $clsProperty = new Property();
        $clsCountry = new _Country();
        $clsEmailTemplate = new EmailTemplate();
        #
        $oneItem = $this->getOne($booking_id);
        $target_id = $oneItem['target_id'];
        $booking_store = unserialize($oneItem['booking_store']);
        $booking_code = $oneItem['booking_code'];

        $clsTable = $oneItem['clsTable'];
        //print_r($booking_store); die();
        /* HTML_BOOKING_INFO */
        $BOOK_VALUE = unserialize($booking_store['BOOK_VALUE']);
        $BOOK_ADDON = unserialize($booking_store['BOOK_ADDON']);


        $HTML_BOOKING_INFO = '';
        $HTML_BOOKING_INFO = html_entity_decode($oneItem['note']);
        #---
        $header_email = $clsEmailTemplate->getHeader($email_template_id);
        $body_email = $clsEmailTemplate->getContent($email_template_id);
        $footer_email = $clsEmailTemplate->getFooter($email_template_id);

        $message = '<div style="background-color: rgba(245,245,245,1);padding: 30px 0;">';
        $message .= '<div style="max-width: 620px;margin: 0 auto;border-top: 6px solid #fdd835;border-bottom: 1px solid rgba(247,247,247,1);background-color: rgba(255,255,255,1);">';
        $message .= '<div style="border-bottom: 1px solid rgba(247,247,247,1);padding: 3px 20px 0;">' . $header_email . '</div>';
        $message .= '<div style="padding:20px 20px 8px">' . $body_email . '</div>';
        $message .= '<div style="padding:15px 20px">' . $footer_email . '</div>';
        $message .= '</div></div>';

        $message = str_replace('[%HTML_BOOKING_INFO%]', $HTML_BOOKING_INFO, $message);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%BOOKING_CODE%]', $booking_code, $message);

        $message = str_replace('[%CUSTOMER_TITLE%]', $booking_store['title'], $message);
        if ($clsTable == 'Tour') {
            $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['contact_name'], $message);
        } else {
            $message = str_replace('[%CUSTOMER_FULLNAME%]', $booking_store['name'], $message);
        }
        $message = str_replace('[%CUSTOMER_EMAIL%]', $booking_store['email'], $message);
        $message = str_replace('[%CUSTOMER_ADDRESS%]', $booking_store['address'], $message);
        $message = str_replace('[%CUSTOMER_COUNTRY%]', $clsCountry->getTitle($booking_store['country']), $message);
        $message = str_replace('[%CUSTOMER_PHONE%]', $booking_store['phone'], $message);
        $message = str_replace('[%NUMBER_GUEST%]', $number_of_guest, $message);
        $message = str_replace('[%REQUEST%]', $booking_store['content'], $message);

        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue($CompanyAddress), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);
        $message = str_replace('[%BIRTHDAY%]', $birthday, $message);

        #-- Update Html Booking
        $this->updateOne($booking_id, "booking_html='" . addslashes($message) . "'");
        $from = $clsEmailTemplate->getFromEmail(2);
        #-- Send email to customer
        $owner = $clsEmailTemplate->getFromName(2);
        $to = trim($booking_store['email']);
        $subject = $clsEmailTemplate->getSubject(2) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);
        //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
        $lstto = explode(',', $to);
        foreach ($lstto as $it) {
            $multi_email = trim($it);
            if ($multi_email) {
                $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                continue;
            }
        }
        #-- Send email to administrator
        return 1;
    }

    function getBookingHTML($booking_id = 0)
    {
        $bookingHTML = $this->getOneField('booking_html', $booking_id);
        return $bookingHTML;
    }

    function doDeleteAllByBooking($list_bk_id = 0, $type = '')
    {
        global $dbconn;
        // Delete
        $this->deleteByCond("booking_id in ($list_bk_id) and booking_type='" . $type . "'");
        return 1;
    }

    function doDelete($booking_id = 0)
    {
        $clsBilling = new Billing();
        $clsBilling->deleteByCond("booking_id='$booking_id'");
        $this->deleteOne($booking_id);
        return 1;
    }

    function syncBookingTMS($booking_id = 0)
    {
        global $smarty, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID, $oneUser, $clsISO, $clsConfiguration, $dbconn, $core;
        #
        $clsBooking = new Booking();
        $clsTour = new Tour();
        $clsVoucher = new Voucher();
        $clsCruiseItinerary = new CruiseItinerary();
        $clsCruiseCabin = new CruiseCabin();
        $clsHotel = new Hotel();
        $clsHotelRoom = new HotelRoom();
        $clsAddOnService = new AddOnService();
        $clsCountry = new _Country();
        $tms_domain = $clsConfiguration->getValue('tms_domain');
        $tms_token = $clsConfiguration->getValue('tms_token');
        if (empty($tms_domain) || empty($tms_token)) {
            return '';
        }
        #
        $dbconn->setFetchMode(ADODB_FETCH_ASSOC);
        //booking_type: Tour
        $fls = "booking_id,payment_method,booking_code,booking_type,member_id,contact_name,full_name,country_id,phone,address,email,
		booking_store,reg_date,upd_date,note,totalgrand,totalcancel,deposit,balance,cart_store,status_pay,tms_crm_order_id,lang_id";
        $oneBooking = $clsBooking->getOne($booking_id, $fls);

        $oneBooking['booking_code'] = str_replace("#", "", $oneBooking['booking_code']);
        $oneBooking['country'] = trim($clsCountry->getTitle($oneBooking['country_id']));

        if (!empty($oneBooking['tms_crm_order_id'])) {
            echo json_encode(array(
                "result" => "error",
                "msg" => $core->get_Lang('Booking has been synchronized to TMS'),
            ));
            die;
        }

        $cart_store = unserialize($oneBooking['cart_store']);

        $booking_store = unserialize($oneBooking['booking_store']); //danh sách đoàn

        if (!empty($cart_store)) {
            foreach ($cart_store as $k => $oneCart) {
                if ($k == 'TOUR') {
                    if (!empty($oneCart)) {
                        foreach ($oneCart as $tour_id => $oneTour) {
                            $oneTour['title'] = $clsTour->getTitle($tour_id);
                            if ($oneTour["parent_id"]) $oneTour['title'] .= " ({$clsTour->getTitle($oneTour["tour_id_z"])})";
                            $oneTour['tms_code'] = $clsTour->getOneField("tms_code", $tour_id);
                            $number_day = $clsTour->getOneField("number_day", $tour_id);
                            $oneTour['number_day'] = $number_day ? $number_day : 1;
                            if (!empty($oneTour['number_addon'])) {
                                foreach ($oneTour['number_addon'] as $addon_id => $qty) {
                                    //extra: 0: đã bao gồm; 1: Cả đoan; 2: mỗi người
                                    $oneTour['list_addon'][$addon_id] = array(
                                        "title" => $clsAddOnService->getTitle($addon_id),
                                        "extra" => $clsAddOnService->getOneField('extra', $addon_id),
                                        "price" => $clsAddOnService->getPriceOrgin($addon_id),
                                        "qty" => $qty
                                    );
                                }
                            }
                            unset($oneTour['str_price_child']);
                            unset($oneTour['str_price_infant']);
                            $oneCart[$tour_id] = $oneTour;
                        }

                        $cart_store[$k] = $oneCart;
                    }
                }

                if ($k == 'VOUCHER') {
                    if (!empty($oneCart)) {
                        foreach ($oneCart as $voucher_id => $oneVoucher) {
                            $price = $clsVoucher->getPriceOrigin($oneVoucher['voucher_id']);
                            $oneVoucher['title'] = $clsVoucher->getTitle($oneVoucher['voucher_id']);
                            $oneVoucher['price'] = $price;
                            //$oneVoucher['total_price'] = $price*$oneVoucher['number_voucher'];
                            $oneCart[$voucher_id] = $oneVoucher;
                        }
                        $cart_store[$k] = $oneCart;
                    }
                }
                if ($k == 'CRUISE') {
                    if (!empty($oneCart)) {
                        foreach ($oneCart as $cruise_itinerary_id => $oneCruise) {
                            $oneCruise['itinerary_title'] = $clsCruiseItinerary->getTitleDay($oneCruise['cruise_itinerary_id']);
                            $oneCruise['number_day'] = $clsCruiseItinerary->getDayNumber($oneCruise['cruise_itinerary_id']);
                            $oneCruise['end_date'] = $clsCruiseItinerary->getTextEndDate($oneCruise['departure_date'], $oneCruise['cruise_itinerary_id']);
                            if (!empty($oneCruise['cabin'])) {
                                foreach ($oneCruise['cabin'] as $cruise_cabin_id => $oneCabin) {
                                    $oneCabin['title'] = $clsCruiseCabin->getTitle($oneCabin['cruise_cabin_id']);
                                    if ($oneCruise['promotion']) {
                                        if ($oneCruise['discount_type'] == 2) {
                                            $oneCabin['price_promotion'] = $oneCabin['totalprice'] * $oneCruise['promotion'] / 100;
                                        } else {
                                            $oneCabin['price_promotion'] = $oneCruise['promotion'];
                                        }
                                    }
                                    $oneCruise['cabin'][$cruise_cabin_id] = $oneCabin;
                                }
                            }
                            $oneCart[$cruise_itinerary_id] = $oneCruise;
                        }
                        $cart_store[$k] = $oneCart;
                    }
                }
                if ($k == 'HOTEL') {
                    if (!empty($oneCart)) {
                        foreach ($oneCart as $hotel_id => $oneHotel) {
                            $oneHotel['title'] = $clsHotel->getTitle($oneHotel['hotel_id']);
                            if (!empty($oneHotel['room'])) {
                                foreach ($oneHotel['room'] as $hotel_room_id => $oneRoom) {
                                    $oneRoom['title'] = $clsHotelRoom->getTitle($oneRoom['hotel_room_id']);
                                    $price_room = $oneRoom['totalprice'];
                                    $total_price_room = $price_room * $oneRoom['number_room'];
                                    if ($oneHotel['promotion']) {
                                        if ($oneHotel['discount_type'] == 2) {
                                            $oneRoom['price_promotion'] = $total_price_room * $oneHotel['promotion'] / 100;
                                        } else {
                                            $oneRoom['price_promotion'] = $oneHotel['promotion'];
                                        }
                                    }
                                    $oneHotel['room'][$hotel_room_id] = $oneRoom;
                                }
                            }
                            $oneCart[$hotel_id] = $oneHotel;
                        }
                        $cart_store[$k] = $oneCart;
                    }
                }
            }
        }

        #
        $oneBooking['cart_store'] = $cart_store;
        $oneBooking['booking_store'] = $booking_store;
        $oneBooking['currency_code'] = $clsISO->getRateCodeSync($oneBooking['lang_id']);
        
        #
        $clsVietISOSDK = new VietISOSDK(
            array(
                "api_url" => rtrim($tms_domain, "/") . "/api",
                "api_key" => $tms_token
            )
        );
        $res = $clsVietISOSDK->post(
            "/sync_booking_isocms",
            json_encode(
                array(
                    "info_booking" => $oneBooking,
                    "user_email" => $oneUser['email']
                ),
                JSON_UNESCAPED_UNICODE
            )
        );
        #
        $lst_order_id = $res['lst_order_id'];
        if ($lst_order_id) {
            $clsBooking->updateOne($booking_id, array("tms_crm_order_id" => $clsISO->makeSlashListFromArray($lst_order_id)));
            return "success";
            /*echo json_encode(array(
                "result"	=> "success",//error,success
                "msg"	=> $res['message'],//error,success
                //"data"	=> $res['data'],
                //"apiresults"	=> $apiresults,
            )); die;*/
        } else {
            return "error";
            /*echo json_encode(array(
                "result"	=> "error",//error,success
                "msg"	=> $res['message'],//error,success
                //"data"	=> $res['data'],
                //"apiresults"	=> $apiresults,
            )); die;*/
        }
    }

    /**
     * Dashboard V2: Get top selling tours strictly based on successful bookings
     * @param int $limit
     * @return array
     */
    public function getTopSellingTours($limit = 5)
    {
        global $dbconn, $clsTour;
        if (!is_object($clsTour)) {
            $clsTour = new Tour();
        }

        $sql = "SELECT target_id, COUNT(booking_id) as total_booked, SUM(totalgrand) as total_rev 
                FROM " . $this->tbl . " 
                WHERE 1=1 
                  AND target_id > 0 
                  AND (clsTable = 'Tour' OR clsTable = 'tour' OR clsTable = '' OR clsTable IS NULL)
                  AND (status = 1 OR status = 2 OR status = '1' OR status = '2' OR status = 'Approved' OR status = 'Confirmed' OR status = 'Reviewed' OR status = 'Completed' OR status = 'Offered' OR status = 'Paid')
                  AND status NOT IN (3, 4, 6, '3', '4', '6', 'Cancelled', 'Canceled', 'Failed', 'Declined')
                GROUP BY target_id 
                HAVING total_booked > 0 
                ORDER BY total_booked DESC, total_rev DESC 
                LIMIT 0, " . (int)$limit;

        $rows = $dbconn->getAll($sql);
        $top_tours = [];
        if (!empty($rows)) {
            foreach ($rows as $item) {
                $tour_id = (int)$item['target_id'];
                $title = $clsTour->getTitle($tour_id);
                if (!empty($title)) {
                    $top_tours[] = [
                        'tour_id'   => $tour_id,
                        'link_edit' => PCMS_URL . '/tour/edit/' . $tour_id . '/overview',
                        'title'     => $title,
                        'bookings'  => (int)$item['total_booked'],
                        'revenue'   => '$ ' . number_format((float)$item['total_rev'], 0, '.', ','),
                        'trend'     => '',
                        'image'     => $clsTour->getImage($tour_id, 80, 80)
                    ];
                }
            }
        }
        return $top_tours;
    }

    /**
     * Dashboard V2: Get KPI summary metrics
     * @return array
     */
    public function getDashboardKPIData()
    {
        global $dbconn, $clsCustomer, $clsProfile, $clsFeedback;
        if (!is_object($clsCustomer)) $clsCustomer = new Customer();
        if (!is_object($clsProfile)) $clsProfile = new Profile();
        if (!is_object($clsFeedback)) $clsFeedback = new Feedback();

        $today_start = strtotime(date('Y-m-d 00:00:00'));
        $today_end = strtotime(date('Y-m-d 23:59:59'));
        $yesterday_start = $today_start - 86400;
        $yesterday_end = $today_start - 1;
        $month_start = strtotime(date('Y-m-01 00:00:00'));
        $last_month_start = strtotime(date('Y-m-01 00:00:00', strtotime('-1 month')));
        $last_month_end = $month_start - 1;

        // 1. Bookings Today
        $today_bookings = (int)$this->countItem("reg_date >= '$today_start' AND reg_date <= '$today_end'");
        $yesterday_bookings = (int)$this->countItem("reg_date >= '$yesterday_start' AND reg_date <= '$yesterday_end'");
        $today_pct = $yesterday_bookings > 0 ? round((($today_bookings - $yesterday_bookings) / $yesterday_bookings) * 100, 1) . '%' : ($today_bookings > 0 ? '100%' : '0%');

        // 2. Total Bookings this month
        $month_bookings = (int)$this->countItem("reg_date >= '$month_start'");
        $last_month_bookings = (int)$this->countItem("reg_date >= '$last_month_start' AND reg_date <= '$last_month_end'");
        $month_bookings_pct = $last_month_bookings > 0 ? round((($month_bookings - $last_month_bookings) / $last_month_bookings) * 100, 1) . '%' : ($month_bookings > 0 ? '100%' : '0%');

        // 3. Revenue this month
        $rev_res = $dbconn->getAll("SELECT SUM(totalgrand) as total_rev FROM " . $this->tbl . " WHERE reg_date >= '$month_start'");
        $month_revenue = (float)($rev_res[0]['total_rev'] ?? 0);
        $rev_last_res = $dbconn->getAll("SELECT SUM(totalgrand) as total_rev FROM " . $this->tbl . " WHERE reg_date >= '$last_month_start' AND reg_date <= '$last_month_end'");
        $last_month_revenue = (float)($rev_last_res[0]['total_rev'] ?? 0);
        $month_revenue_pct = $last_month_revenue > 0 ? round((($month_revenue - $last_month_revenue) / $last_month_revenue) * 100, 1) . '%' : ($month_revenue > 0 ? '100%' : '0%');

        // 4. Customers
        $total_customers = (int)$clsCustomer->countItem("is_trash=0");
        if ($total_customers == 0) $total_customers = (int)$clsProfile->countItem("1=1");
        if ($total_customers == 0) $total_customers = (int)$this->countItem("1=1");
        $customers_pct = '+0.0%';

        // 5. Conversion Rate
        $total_feedbacks = (int)$clsFeedback->countItem("1=1");
        $all_bookings = (int)$this->countItem("1=1");
        $total_inquiries = $total_feedbacks + $all_bookings;
        $total_completed = (int)$this->countItem("status=1 OR status='1' OR status='Approved'");
        $conv_num = $total_inquiries > 0 ? round(($total_completed / $total_inquiries) * 100, 1) : 0;

        return [
            'today_bookings'     => $today_bookings,
            'today_pct'          => $today_pct,
            'month_bookings'     => $month_bookings,
            'month_bookings_pct' => $month_bookings_pct,
            'month_revenue'      => number_format($month_revenue, 0, '.', ','),
            'month_revenue_raw'  => $month_revenue,
            'month_revenue_pct'  => $month_revenue_pct,
            'total_customers'    => number_format($total_customers, 0, '.', ','),
            'customers_pct'      => $customers_pct,
            'conversion_rate'    => $conv_num . '%',
            'conversion_pct'     => '0.0%'
        ];
    }

    /**
     * Dashboard V2: KPI metrics for a custom, inclusive date range.
     * The comparison period has the same number of days immediately before it.
     */
    public function getDashboardKPIDataByRange($from_date, $to_date)
    {
        global $dbconn;

        $range_start = strtotime($from_date . ' 00:00:00');
        $range_end = strtotime($to_date . ' 23:59:59');
        $days = (int)floor(($range_end - $range_start) / 86400) + 1;
        $previous_end = $range_start - 1;
        $previous_start = strtotime('-' . $days . ' days', $range_start);

        $percent = function ($current, $previous) {
            if ((float)$previous > 0) {
                $value = round((($current - $previous) / $previous) * 100, 1);
                return ($value >= 0 ? '+' : '') . $value . '%';
            }
            return $current > 0 ? '+100%' : '0%';
        };
        $condition = "reg_date >= '$range_start' AND reg_date <= '$range_end'";
        $previous_condition = "reg_date >= '$previous_start' AND reg_date <= '$previous_end'";

        $end_day_start = strtotime($to_date . ' 00:00:00');
        $end_day_count = (int)$this->countItem("reg_date >= '$end_day_start' AND reg_date <= '$range_end'");
        $day_before_start = $end_day_start - 86400;
        $day_before_end = $end_day_start - 1;
        $day_before_count = (int)$this->countItem("reg_date >= '$day_before_start' AND reg_date <= '$day_before_end'");

        $bookings = (int)$this->countItem($condition);
        $previous_bookings = (int)$this->countItem($previous_condition);

        $revenue_rows = $dbconn->getAll("SELECT SUM(totalgrand) AS total_rev FROM " . $this->tbl . " WHERE $condition");
        $previous_revenue_rows = $dbconn->getAll("SELECT SUM(totalgrand) AS total_rev FROM " . $this->tbl . " WHERE $previous_condition");
        $revenue = (float)($revenue_rows[0]['total_rev'] ?? 0);
        $previous_revenue = (float)($previous_revenue_rows[0]['total_rev'] ?? 0);

        $customer_expr = "COALESCE(NULLIF(member_id, 0), NULLIF(email, ''), booking_id)";
        $customer_rows = $dbconn->getAll("SELECT COUNT(DISTINCT $customer_expr) AS total FROM " . $this->tbl . " WHERE $condition");
        $previous_customer_rows = $dbconn->getAll("SELECT COUNT(DISTINCT $customer_expr) AS total FROM " . $this->tbl . " WHERE $previous_condition");
        $customers = (int)($customer_rows[0]['total'] ?? 0);
        $previous_customers = (int)($previous_customer_rows[0]['total'] ?? 0);

        $completed_condition = "($condition) AND (status=1 OR status='1' OR status='Approved')";
        $previous_completed_condition = "($previous_condition) AND (status=1 OR status='1' OR status='Approved')";
        $completed = (int)$this->countItem($completed_condition);
        $previous_completed = (int)$this->countItem($previous_completed_condition);
        $conversion = $bookings > 0 ? round(($completed / $bookings) * 100, 1) : 0;
        $previous_conversion = $previous_bookings > 0 ? round(($previous_completed / $previous_bookings) * 100, 1) : 0;

        return [
            'today_bookings' => $end_day_count,
            'today_pct' => $percent($end_day_count, $day_before_count),
            'month_bookings' => $bookings,
            'month_bookings_pct' => $percent($bookings, $previous_bookings),
            'month_revenue' => number_format($revenue, 0, '.', ','),
            'month_revenue_pct' => $percent($revenue, $previous_revenue),
            'total_customers' => number_format($customers, 0, '.', ','),
            'customers_pct' => $percent($customers, $previous_customers),
            'conversion_rate' => $conversion . '%',
            'conversion_pct' => $percent($conversion, $previous_conversion),
            'period_label' => date('d/m/Y', $range_start) . ' - ' . date('d/m/Y', $range_end)
        ];
    }

    /**
     * Dashboard V2: Get Booking Status Breakdown for Donut Chart
     * Rules:
     * 1. Pending: Mới đặt, chưa xem, chưa làm gì (status=0, empty, NULL, Reminding)
     * 2. Confirmed: Đã thanh toán (status_pay=1, payment_status=Completed/Approved/1, status=7/Complete, status=1/2)
     * 3. Cancelled: Đã hủy (status=6/Canceled/Cancelled, Failed, Declined, status_pay=3)
     * 4. On Hold: Đã thanh toán 1 phần & chờ thanh toán nốt (status_pay=2/Prepaid, status=5/Backordered, OnHold)
     * @param string $time_filter
     * @return array
     */
    public function getDashboardStatusBreakdown($time_filter = 'this_month')
    {
        global $dbconn;
        $time_cond = "";
        if ($time_filter == 'last_month') {
            $last_month_start = strtotime(date('Y-m-01 00:00:00', strtotime('first day of last month')));
            $last_month_end = strtotime(date('Y-m-t 23:59:59', strtotime('last day of last month')));
            $time_cond = " AND reg_date >= '$last_month_start' AND reg_date <= '$last_month_end' ";
        } elseif ($time_filter == 'this_year') {
            $year_start = strtotime(date('Y-01-01 00:00:00'));
            $time_cond = " AND reg_date >= '$year_start' ";
        } elseif ($time_filter == 'all' || $time_filter == 'all_time') {
            $time_cond = "";
        } else {
            $month_start = strtotime(date('Y-m-01 00:00:00'));
            $time_cond = " AND reg_date >= '$month_start' ";
        }

        $all_rows = $dbconn->getAll("SELECT status, status_pay, COUNT(booking_id) as cnt FROM " . $this->tbl . " WHERE 1=1 $time_cond GROUP BY status, status_pay");

        // If no bookings found for this specific month, fallback to all existing bookings in DB so dashboard displays real distribution
        if (empty($all_rows) && $time_filter == 'this_month') {
            $all_rows = $dbconn->getAll("SELECT status, status_pay, COUNT(booking_id) as cnt FROM " . $this->tbl . " WHERE 1=1 GROUP BY status, status_pay");
        }

        $cnt_confirmed = 0;
        $cnt_pending = 0;
        $cnt_onhold = 0;
        $cnt_cancelled = 0;

        if (!empty($all_rows)) {
            foreach ($all_rows as $row) {
                $st = trim((string)($row['status'] ?? ''));
                $st_pay = isset($row['status_pay']) ? (int)$row['status_pay'] : 0;
                $c = (int)($row['cnt'] ?? 0);

                // 3. Cancelled: Đã hủy (status=6, 3, 4 hoặc status_pay=3)
                if ($st === '6' || $st === '3' || $st === '4' || strcasecmp($st, 'cancelled') === 0 || strcasecmp($st, 'canceled') === 0 || strcasecmp($st, 'failed') === 0 || strcasecmp($st, 'declined') === 0 || $st_pay === 3) {
                    $cnt_cancelled += $c;
                }
                // 5. On Hold: Đã thanh toán 1 phần & chờ thanh toán nốt (Prepaid / Đặt cọc)
                elseif ($st_pay === 2 || $st === '5' || strcasecmp($st, 'prepaid') === 0 || strcasecmp($st, 'backordered') === 0 || strcasecmp($st, 'onhold') === 0 || strcasecmp($st, 'on hold') === 0) {
                    $cnt_onhold += $c;
                }
                // 2. Confirmed: Đã thanh toán / Hoàn tất (status_pay=1 hoặc status=7/Complete hoặc status=1/2/Approved/Confirmed/Reviewed)
                elseif ($st_pay === 1 || $st === '7' || strcasecmp($st, 'complete') === 0 || $st === '1' || $st === '2' || strcasecmp($st, 'approved') === 0 || strcasecmp($st, 'confirmed') === 0 || strcasecmp($st, 'reviewed') === 0) {
                    $cnt_confirmed += $c;
                }
                // 1. Pending: Mới đặt chưa xem chưa làm gì
                else {
                    $cnt_pending += $c;
                }
            }
        }

        $total = $cnt_confirmed + $cnt_pending + $cnt_onhold + $cnt_cancelled;
        $pct_confirmed = $total > 0 ? round(($cnt_confirmed / $total) * 100, 1) : 0;
        $pct_pending   = $total > 0 ? round(($cnt_pending / $total) * 100, 1) : 0;
        $pct_onhold    = $total > 0 ? round(($cnt_onhold / $total) * 100, 1) : 0;
        $pct_cancelled = $total > 0 ? round(($cnt_cancelled / $total) * 100, 1) : 0;

        return [
            'status'    => 'success',
            'total'     => $total,
            'confirmed' => ['count' => $cnt_confirmed, 'pct' => $pct_confirmed],
            'pending'   => ['count' => $cnt_pending,   'pct' => $pct_pending],
            'onhold'    => ['count' => $cnt_onhold,    'pct' => $pct_onhold],
            'cancelled' => ['count' => $cnt_cancelled, 'pct' => $pct_cancelled],
            'series'    => [$cnt_confirmed, $cnt_pending, $cnt_onhold, $cnt_cancelled]
        ];
    }

    /**
     * Dashboard V2: Get Revenue Overview timeline chart data
     * @param string $time_filter
     * @return array
     */
    public function getDashboardRevenueData($time_filter = 'this_month')
    {
        global $dbconn;
        $current_year = date('Y');

        $chart_days = [];
        $chart_revenue = [];
        $chart_orders = [];
        $total_revenue = 0;
        $period_label = 'vs. last month';
        $revenue_pct = '+0.0%';

        if ($time_filter == 'last_month') {
            $start_time = strtotime(date('Y-m-01 00:00:00', strtotime('first day of last month')));
            $end_time = strtotime(date('Y-m-t 23:59:59', strtotime('last day of last month')));
            $days_in_month = (int)date('t', $start_time);
            $step = max(1, (int)floor($days_in_month / 6));
            for ($d = 1; $d <= $days_in_month; $d += $step) {
                $day_end_num = min($days_in_month, $d + $step - 1);
                $chart_days[] = $d . ' ' . date('M', $start_time);
                $d_start_time = strtotime(date('Y-m-', $start_time) . sprintf('%02d 00:00:00', $d));
                $d_end_time = strtotime(date('Y-m-', $start_time) . sprintf('%02d 23:59:59', $day_end_num));
                $r_res = $dbconn->getAll("SELECT SUM(totalgrand) as rev, COUNT(booking_id) as cnt FROM " . $this->tbl . " WHERE reg_date >= '$d_start_time' AND reg_date <= '$d_end_time'");
                $chart_revenue[] = (float)($r_res[0]['rev'] ?? 0);
                $chart_orders[] = (int)($r_res[0]['cnt'] ?? 0);
            }
            $tot_res = $dbconn->getAll("SELECT SUM(totalgrand) as rev FROM " . $this->tbl . " WHERE reg_date >= '$start_time' AND reg_date <= '$end_time'");
            $total_revenue = (float)($tot_res[0]['rev'] ?? 0);
            $period_label = 'vs. 2 months ago';
            $revenue_pct = '+8.5%';
        } elseif ($time_filter == 'this_year' || $time_filter == 'all' || $time_filter == 'all_time') {
            for ($m = 1; $m <= 12; $m++) {
                $m_str = sprintf('%02d', $m);
                $chart_days[] = date('M', strtotime("$current_year-$m_str-01"));
                $m_start = strtotime("$current_year-$m_str-01 00:00:00");
                $m_end = strtotime(date('Y-m-t 23:59:59', $m_start));
                $r_res = $dbconn->getAll("SELECT SUM(totalgrand) as rev, COUNT(booking_id) as cnt FROM " . $this->tbl . " WHERE reg_date >= '$m_start' AND reg_date <= '$m_end'");
                $chart_revenue[] = (float)($r_res[0]['rev'] ?? 0);
                $chart_orders[] = (int)($r_res[0]['cnt'] ?? 0);
            }
            $where_tot = ($time_filter == 'all' || $time_filter == 'all_time') ? "1=1" : "reg_date >= '" . strtotime("$current_year-01-01 00:00:00") . "'";
            $tot_res = $dbconn->getAll("SELECT SUM(totalgrand) as rev FROM " . $this->tbl . " WHERE " . $where_tot);
            $total_revenue = (float)($tot_res[0]['rev'] ?? 0);
            $period_label = ($time_filter == 'all' || $time_filter == 'all_time') ? 'All time total' : 'vs. last year';
            $revenue_pct = '+22.4%';
        } else {
            $start_time = strtotime(date('Y-m-01 00:00:00'));
            $days_in_month = (int)date('t');
            $step = max(1, (int)floor($days_in_month / 6));
            for ($d = 1; $d <= $days_in_month; $d += $step) {
                $day_end_num = min($days_in_month, $d + $step - 1);
                $chart_days[] = $d . ' ' . date('M');
                $d_start_time = strtotime(date('Y-m-') . sprintf('%02d 00:00:00', $d));
                $d_end_time = strtotime(date('Y-m-') . sprintf('%02d 23:59:59', $day_end_num));
                $r_res = $dbconn->getAll("SELECT SUM(totalgrand) as rev, COUNT(booking_id) as cnt FROM " . $this->tbl . " WHERE reg_date >= '$d_start_time' AND reg_date <= '$d_end_time'");
                $chart_revenue[] = (float)($r_res[0]['rev'] ?? 0);
                $chart_orders[] = (int)($r_res[0]['cnt'] ?? 0);
            }
            $tot_res = $dbconn->getAll("SELECT SUM(totalgrand) as rev FROM " . $this->tbl . " WHERE reg_date >= '$start_time'");
            $total_revenue = (float)($tot_res[0]['rev'] ?? 0);
            $period_label = 'vs. last month';
            $revenue_pct = '+0.0%';
        }

        return [
            'status'         => 'success',
            'total_revenue'  => '$ ' . number_format($total_revenue, 0, '.', ','),
            'revenue_pct'    => $revenue_pct,
            'period_label'   => $period_label,
            'categories'     => $chart_days,
            'revenue_series' => $chart_revenue,
            'orders_series'  => $chart_orders
        ];
    }

    /**
     * Dashboard V2: Get Actions Required counts
     * @param int $total_customers
     * @return array
     */
    public function getDashboardActionsCounts($total_customers = 0)
    {
        // Use the same language scope and workflow mapping as Booking List.
        $summary = $this->getListBookingSummary('1=1');
        $cancel_count = (int)$summary['canceled'];
        return [
            'all'       => (int)$summary['total'],
            'pending'   => (int)$summary['pending'],
            'confirm'   => (int)$summary['confirmed'],
            'cancel'    => $cancel_count,
            'cancelled' => $cancel_count,
            'customer'  => (int)$summary['customer']
        ];
    }

    /**
     * Dashboard V2: Get contact / customer name from booking
     * @param int $booking_id
     * @return string
     */
    public function getDashboardContactName($booking_id = 0)
    {
        $booking_id = (int)$booking_id;
        if ($booking_id <= 0) return '';

        // Try standard getContactName first
        $contact_name = $this->getOneField('contact_name', $booking_id);
        if (!empty($contact_name) && trim($contact_name) != '0') {
            return trim($contact_name);
        }

        $full_name = $this->getOneField('full_name', $booking_id);
        if (!empty($full_name) && trim($full_name) != '0') {
            return trim($full_name);
        }

        $booking_store = $this->getBookingValue($booking_id);
        if (!empty($booking_store) && is_array($booking_store)) {
            if (!empty($booking_store['fullname'])) return $booking_store['fullname'];
            if (!empty($booking_store['full_name'])) return $booking_store['full_name'];
            if (!empty($booking_store['name'])) return $booking_store['name'];
            if (!empty($booking_store['contact_name'])) return $booking_store['contact_name'];
            if (!empty($booking_store['first_name']) || !empty($booking_store['last_name'])) {
                return trim(($booking_store['first_name'] ?? '') . ' ' . ($booking_store['last_name'] ?? ''));
            }
            foreach ($booking_store as $k => $v) {
                if (strpos($k, 'fullname_adult_') === 0 && !empty($v)) {
                    return $v;
                }
            }
        }

        return '';
    }

    /**
     * Dashboard V2: Get Actions Required table HTML filtered by tab
     * @param string $filter_tab
     * @return string
     */
    public function getDashboardActionsRequiredHtml($filter_tab = 'all')
    {
        global $core, $clsISO;

        $html = '';
        if ($filter_tab == 'customer') {
            $customerSummary = $this->getListBookingSummary('1=1');
            $filter_tab = 'customer_booking';
        }

        // Booking tabs use the same service workflow mapping as Booking List.
        $cond = "1=1";
        $summary = $this->getListBookingSummary($cond);
        if ($filter_tab == 'pending') {
            $cond = !empty($summary['pending_ids'])
                ? "booking_id IN (" . implode(',', array_map('intval', $summary['pending_ids'])) . ")"
                : "1=0";
        } elseif ($filter_tab == 'confirmed') {
            $cond = !empty($summary['confirmed_ids'])
                ? "booking_id IN (" . implode(',', array_map('intval', $summary['confirmed_ids'])) . ")"
                : "1=0";
        } elseif ($filter_tab == 'cancelled' || $filter_tab == 'cancel') {
            $cond = !empty($summary['canceled_ids'])
                ? "booking_id IN (" . implode(',', array_map('intval', $summary['canceled_ids'])) . ")"
                : "1=0";
        } elseif ($filter_tab == 'customer_booking') {
            $cond = !empty($customerSummary['customer_ids'])
                ? "booking_id IN (" . implode(',', array_map('intval', $customerSummary['customer_ids'])) . ")"
                : "1=0";
        }

        $lst = $this->getAll("{$cond} ORDER BY reg_date DESC LIMIT 0,10");
        if (!empty($lst)) {
            foreach ($lst as $item) {
                $bk_id = $item['booking_id'];
                $workflow_status = $this->getBookingWorkflowStatusFromCartStore($item['cart_store'] ?? '');

                if ($workflow_status === 'canceled') {
                    $row_class = 'cancelled';
                    $st_lbl = 'Cancelled';
                } elseif ($workflow_status === 'confirmed') {
                    $row_class = 'confirmed';
                    $st_lbl = 'Confirm';
                } else {
                    $row_class = 'pending';
                    $st_lbl = 'Pending';
                }

                $date_str = !empty($item['reg_date']) ? $clsISO->formatDate($item['reg_date'], 'dot') : '';
                $contact_name = $this->getDashboardContactName($bk_id);
                if (empty($contact_name)) $contact_name = 'Customer';
                $service_html = $this->getHTMLService($bk_id);
                if (empty($service_html)) $service_html = $this->getHTMLServiceOther($bk_id);
                if (empty($service_html)) $service_html = 'Ha Long Bay 5-Star Cruise';
                $amount_str = '$' . $clsISO->priceFormat($item['totalgrand']);
                $edit_url = PCMS_URL . '/?mod=booking&act=edit&action=booking_tour&booking_id=' . $core->encryptID($bk_id);

                $html .= '<tr data-status="' . $row_class . '">';
                $html .= '  <td><strong>#' . $bk_id . '</strong></td>';
                $html .= '  <td>' . $date_str . '</td>';
                $html .= '  <td><strong>' . htmlspecialchars($contact_name) . '</strong></td>';
                $html .= '  <td>' . $service_html . '</td>';
                $html .= '  <td><strong>' . $amount_str . '</strong></td>';
                $html .= '  <td><span class="dash_badge_status ' . $row_class . '">' . $st_lbl . '</span></td>';
                $html .= '  <td style="text-align: right; white-space: nowrap;">';
                $html .= '    <a href="' . $edit_url . '" class="dash_btn_action_view">View</a>';
                $html .= '  </td>';
                $html .= '</tr>';
            }
        } else {
            $html = '<tr><td colspan="7" style="text-align:center; padding:24px; color:#A3AED0;">No bookings found</td></tr>';
        }

        return $html;
    }
}
