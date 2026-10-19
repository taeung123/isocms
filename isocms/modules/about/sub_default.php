<?php
function default_about()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $oneCommon;
	global $clsConfiguration, $extLang, $_LANG_ID, $about_us_id, $clsISO, $package_id;
	#
	global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;

	#Danh sách file css xử dụng cho trang home
	Asset::css([
		"{$URL_JS}/fancybox4/fancybox.css?v={$upd_version}",
		"{$URL_CSS}/compress/venobox.css",
		"{$URL_CSS}/compress/owl.carousel.min.css?v={$upd_version}",
	]);

	Asset::js([
		"{$URL_JS}/fancybox4/fancybox.umd.js?v={$upd_version}",
		"{$URL_JS}/venobox/venobox.min.js",
		"{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$upd_version}"
	]);

	#
	$clsPackage = new Package();
	$assign_list['clsPackage'] = $clsPackage;
	$clsPage = new Page();
	$assign_list['clsPage'] = $clsPage;
	$clsYearJourney = new YearJourney();
	$assign_list['clsYearJourney'] = $clsYearJourney;

	$cond = "1=1 and post_type='YEARJOURNEY'";
	$orderby = " order by order_no ASC";

	$recordPerPage = 3;
	$currentPage = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$totalRecord = $clsYearJourney->getAll($cond, $clsYearJourney->pkey);
	$totalRecord = $totalRecord ? count($totalRecord) : 0;

	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";

	if ($clsISO->getCheckActiveModulePackage($package_id, 'page', 'about', 'default')) {

		$listReasons = $clsYearJourney->getAll("1=1 and post_type='REASON' order by order_no ASC", $clsYearJourney->pkey . ',title,image,icon,intro');
		$assign_list["listReasons"] = $listReasons;
		unset($listReasons);

		$listYearJourney = $clsYearJourney->getAll($cond . $orderby, $clsYearJourney->pkey . ',image,title,intro,business_year');
		$assign_list['listYearJourney'] = $listYearJourney;
		unset($listYearJourney);
	} else {
		$page_id = $about_us_id;
		$assign_list['page_id'] = $page_id;
	}
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;

	$sql = 'is_trash=0 and is_online=1';
	if ($clsISO->getCheckActiveModulePackage($package_id, 'page', 'about', 'default')) {
		$sql .= " and page_id<>'$about_us_id'";
	}
	#
	$clsPage = new Page();
	$assign_list['clsPage'] = $clsPage;
	$listPage = $clsPage->getAll($sql . ' order by order_no asc', $clsPage->pkey . ',title,intro');
	$assign_list['listPage'] = $listPage;

	$clsTeam = new Team();
	$assign_list['clsTeam'] = $clsTeam;
	$listTeam = $clsTeam->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsTeam->pkey . ',name,image,content,position');
	$assign_list['listTeam'] = $listTeam;

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('About us') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*========================================================*/
	unset($clsFeedback);
	unset($clsISO);
}
function default_ajload_list_year_journey()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $deviceType;
	#
	$clsYearJourney = new YearJourney();
	$assign_list['clsYearJourney'] = $clsYearJourney;

	$recordPerPage = 3;

	$currentPage = isset($_POST["page"]) ? $_POST["page"] : 1;

	$cond = "1=1 and post_type='YEARJOURNEY'";
	$orderby = " order by order_no ASC";

	$totalRecord = $clsYearJourney->getAll($cond) ? count($clsYearJourney->getAll($cond)) : 0;


	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";

	$listYearJourney = $clsYearJourney->getAll($cond . $order . $limit, $clsYearJourney->pkey);

	$assign_list["listYearJourney"] = $listYearJourney;

	$assign_list['totalRecord'] = $totalRecord;

	$html = $core->build('load_item_year_journey.tpl');

	echo $html;
	die();
}
function default_default()
{
    global $assign_list, $_CONFIG, $core, $dbconn;
    global $mod, $act, $_LANG_ID;
    global $title_page, $description_page, $keyword_page;
    global $about_us_id, $curl, $clsISO;

    if (!$core->checkActiveModule('page')) {
        header('Location: /');
        exit();
    }

    $clsPage = new Page();
    $assign_list['clsPage'] = $clsPage;

    $clsTour = new Tour();
    $assign_list['clsTour'] = $clsTour;

    $show = isset($_GET['show'])
        ? trim($_GET['show'])
        : '';

    /*
     * Đường dẫn hiện tại.
     */
    $requestUri = isset($_SERVER['REQUEST_URI'])
        ? $_SERVER['REQUEST_URI']
        : '/';

    $requestPath = parse_url(
        $requestUri,
        PHP_URL_PATH
    );

    if (!is_string($requestPath)) {
        $requestPath = '/';
    }

    $requestPath = rawurldecode($requestPath);
    $requestPath = preg_replace('#/+#', '/', $requestPath);
    $requestPath = '/' . ltrim($requestPath, '/');

    /*
     * Lấy slug từ router hoặc URL.
     */
    $slug = isset($_GET['slug'])
        ? trim($_GET['slug'])
        : '';

    if ($slug === '') {
        $slug = basename(
            rtrim($requestPath, '/')
        );
    }

    $slug = rawurldecode($slug);
    $slug = trim($slug, '/');
    $slug = preg_replace('/\.html?$/i', '', $slug);

    $assign_list['show'] = $show;
    $assign_list['slug'] = $slug;

    /*
     * Chuẩn hóa tên bảng và khóa chính.
     */
    $tableName = isset($clsPage->tbl)
        ? $clsPage->tbl
        : DB_PREFIX . 'page';

    $pkeyTable = isset($clsPage->pkey)
        ? $clsPage->pkey
        : 'page_id';

    $tableName = preg_replace(
        '/[^a-zA-Z0-9_]/',
        '',
        $tableName
    );

    $pkeyTable = preg_replace(
        '/[^a-zA-Z0-9_]/',
        '',
        $pkeyTable
    );

    if ($pkeyTable === '') {
        $pkeyTable = 'page_id';
    }

    $page_id = 0;

    /*
     * Trang About chính.
     */
    $normalizedPath = rtrim(
        strtolower($requestPath),
        '/'
    );

    if (
        (
            $normalizedPath === '/about' ||
            $normalizedPath === '/about.html'
        ) &&
        (int) $about_us_id > 0
    ) {
        $page_id = (int) $about_us_id;
    }

    /*
     * Tìm trực tiếp bằng SQL theo slug.
     */
    if (
        $page_id <= 0 &&
        $slug !== ''
    ) {
        $slugSql = addslashes($slug);
        $slugHtmlSql = addslashes($slug . '.html');

        $sql = "
            SELECT `{$pkeyTable}`
            FROM `{$tableName}`
            WHERE `is_trash`='0'
                AND `is_online`='1'
                AND (
                    `slug`='{$slugSql}'
                    OR `slug`='{$slugHtmlSql}'
                )
            ORDER BY `{$pkeyTable}` DESC
            LIMIT 1
        ";

        $page_id = (int) $dbconn->GetOne($sql);
    }

    /*
     * Fallback tìm bằng link.
     */
    if ($page_id <= 0) {
        $requestPathSql = addslashes($requestPath);
        $pathWithoutSlashSql = addslashes(
            ltrim($requestPath, '/')
        );

        $sql = "
            SELECT `{$pkeyTable}`
            FROM `{$tableName}`
            WHERE `is_trash`='0'
                AND `is_online`='1'
                AND (
                    `link`='{$requestPathSql}'
                    OR `link`='{$pathWithoutSlashSql}'
                )
            ORDER BY `{$pkeyTable}` DESC
            LIMIT 1
        ";

        $page_id = (int) $dbconn->GetOne($sql);
    }

    /*
     * Fallback cuối: link kết thúc bằng slug.
     */
    if (
        $page_id <= 0 &&
        $slug !== ''
    ) {
        $slugSql = addslashes($slug);

        $sql = "
            SELECT `{$pkeyTable}`
            FROM `{$tableName}`
            WHERE `is_trash`='0'
                AND `is_online`='1'
                AND (
                    `link` LIKE '%/{$slugSql}.html'
                    OR `link` LIKE '%/{$slugSql}'
                )
            ORDER BY `{$pkeyTable}` DESC
            LIMIT 1
        ";

        $page_id = (int) $dbconn->GetOne($sql);
    }

    /*
     * Không tìm thấy Page.
     */
    if ($page_id <= 0) {
        error_log(
            'Page not found'
            . ' | table=' . $tableName
            . ' | pkey=' . $pkeyTable
            . ' | path=' . $requestPath
            . ' | slug=' . $slug
        );

        http_response_code(404);

        $assign_list['page_id'] = 0;
        $assign_list['oneItem'] = array();
        $assign_list['titlePage'] = '';
        $assign_list['introPage'] = '';
        $assign_list['curl'] = $requestPath;

        $title_page = 'Page not found | ' . PAGE_NAME;
        $description_page = '';
        $keyword_page = '';

        $assign_list['title_page'] = $title_page;
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';

        return;
    }

    /*
     * Lấy dữ liệu Page.
     */
    $oneItem = $clsPage->getOne($page_id);

    if (!is_array($oneItem)) {
        $oneItem = array();
    }

    $titlePage = $clsPage->getTitle(
        $page_id,
        $oneItem
    );

    $introPage = $clsPage->getIntro(
        $page_id,
        $oneItem
    );

    if (is_array($titlePage)) {
        $titlePage = '';
    }

    if (is_array($introPage)) {
        $introPage = '';
    }

    $titlePage = html_entity_decode(
        (string) $titlePage,
        ENT_QUOTES,
        'UTF-8'
    );

    $introPage = (string) $introPage;
    $curl = $requestPath;

    $assign_list['page_id'] = $page_id;
    $assign_list['oneItem'] = $oneItem;
    $assign_list['titlePage'] = $titlePage;
    $assign_list['introPage'] = $introPage;
    $assign_list['curl'] = $curl;

    /*
     * SEO.
     */
    $title_page = $titlePage !== ''
        ? $titlePage . ' | ' . PAGE_NAME
        : PAGE_NAME;

    $description_page = $clsISO->getMetaDescription(
        $page_id,
        'Page'
    );

    if (is_array($description_page)) {
        $description_page = '';
    }

    $keyword_page = $titlePage !== ''
        ? $titlePage . ' | ' . PAGE_NAME
        : PAGE_NAME;

    $assign_list['title_page'] = $title_page;
    $assign_list['description_page'] = $description_page;
    $assign_list['keyword_page'] = $keyword_page;
}
function default_contact()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page;
	global $clsISO, $_LANG_ID, $_lang, $extLang, $_frontIsLoggedin_user_id, $lstCountryEx;
	#

	$clsTailorProperty = new TailorProperty();
	$assign_list["clsTailorProperty"] = $clsTailorProperty;
	$clsTour = new Tour();
	$assign_list["clsTour"] = $clsTour;
	$clsCruise = new Cruise();
	$assign_list["clsCruise"] = $clsCruise;
	$clsCruiseItinerary = new CruiseItinerary();
	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCity = new City();
	$assign_list["clsCity"] = $clsCity;
	$clsCountry = new _Country();
	$assign_list["clsCountry"] = $clsCountry;
	$clsCountryEx = new Country();
	$assign_list["clsCountryEx"] = $clsCountryEx;
	$clsBooking = new Booking();
	$clsFeedback = new Feedback();
	$assign_list['clsFeedback'] = $clsFeedback;

	// ini_set('display_errors', 1);
	// error_reporting(E_ALL & ~E_STRICT); //E_ALL


	$clsZaloZNSAPI = new ZaloZNSAPI();


	if ($temp = 'otp') {
		$template_data = array(
			'otp' => '3712352'
		);
	} elseif ($temp = 'order_ticket') {
		$template_data = array(
			'order_code' => 'HP0001',
			'phone_number' => '0908998688',
			'price' => '1.500.000đ',
			'status' => 'Đã Thanh Toán',
			'date' => '23/08/2023',
		);
	} elseif ($temp = 'get_car_1') {
		$template_data = array(
			'Ten_khach_hang' => 'Nguyễn A',
			'order_code' => 'HP0001',
			'status' => 'Đã xác nhận',
			'date' => '23/08/2023',
		);
	} elseif ($temp = 'get_car_2') {
		$template_data = array(
			'Ten_khach_hang' => 'Nguyễn A',
			'order_code' => 'HP0001',
			'status' => 'Đã xác nhận',
			'date' => '23/08/2023',
		);
	} elseif ($temp = 'checkin') {
		$template_data = array(
			'Ten_khach_hang' => 'Nguyễn A',
			'order_code' => 'HP0001',
			'phone_number' => '0908998688',
			'status' => 'Đã checkin',
			'date' => '23/08/2023',
		);
	} elseif ($temp = 'buffalo_meat') {
		$template_data = array(
			'order_code' => 'HP0001',
			'phone_number' => '0908998688',
			'price' => '1.500.000đ',
			'date' => '23/08/2023',
			'status' => 'Đã giao',
			'date' => '23/08/2023',
		);
	} elseif ($temp = 'check_in_lunch') {
		$template_data = array(
			'Ten_khach_hang' => 'Nguyễn A',
			'order_code' => 'HP0001',
			'date' => '23/08/2023',
		);
	} else {
		$template_data = array(
			'customer_name' => 'Nguyen Van A',
			'order_code' => 'HP0001',
			'payment_status' => 'Đã Thanh Toán',
			'cost' => '1.490.000đ',
		);
	}
	$param = array(
		/*'mode' => 'development',*/
		'phone' => '84988905769',
		'template_id' => '2782381',
		'template_data' => $template_data,
		'tracking_id' => '84988905769',
	);


	$response = $clsZaloOpenAPI->SendZNS($param); //stay.php

	if (!empty($response)) {
		print_r(1);
	} else {
		print_r(0);
	}




	//$response = $clsZaloOpenAPI->getQuota();//stay.php
	//print_r($response);die();



	//$abc=$clsZaloOpenAPI->GetZaloTokenByOA($RefreshToken,'access_token');


	// print_r($abc);die();
	//$abc=$clsTestOpenAPI->sendMessage('text');
	// print_r($abc);die();
	//https://business.openapi.zalo.me/message/template


	#
	$assign_list["lstCountryRegion"] = $clsCountry->getAll("1=1 and is_trash=0 order by order_no ASC", $clsCountry->pkey . ",title");
	$assign_list['lst_country_id'] = $lstCountryEx[0][$clsCountryEx->pkey];

	$show = isset($_GET['show']) ? $_GET['show'] : '';

	if ($show == 'Tour') {
		if (isset($_GET['slug']) && !empty($_GET['slug'])) {
			$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
			$tour_id = $clsTour->getBySlug($slug);

			if (intval($tour_id) == 0) {
				header('location:' . PCMS_URL . $extLang);
				exit();
			}
		}
	} else {
		$tour_id = vnSessionGetVar('tour_contact_id');
	}
	$assign_list["tour_id"] = $tour_id;
	$target_id = $tour_id;

	$cruise_id = vnSessionGetVar('cruise_contact_id');
	$assign_list["cruise_id"] = $cruise_id;


	$cruise_itinerary_id = vnSessionGetVar('cruise_itinerary_contact_id');
	$assign_list["cruise_itinerary_id"] = $cruise_itinerary_id;
	if ($cruise_id == '') {
		$cruise_id = $clsCruiseItinerary->getOneField('cruise_id', $cruise_itinerary_id);
		$assign_list["cruise_id"] = $cruise_id;
		$target_id = $cruise_id;
	}

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

	$clsTourItinerary = new TourItinerary();
	$lstItineraryTour = $clsTourItinerary->getAll("is_trash=0 and tour_id='544' and title_contingency='' order by order_no asc", $clsTourItinerary->pkey . ',image,content,tour_itinerary_id,transport,is_show_image,day,day2,tour_id,title,meals');
	$assign_list['lstItineraryTour'] = $lstItineraryTour;


	if (isset($_POST["create_word_file"])) {
		if (empty($_POST["title"]) || empty($_POST["description_text"])) {
			echo '<script>alert("Both Fields Are Required")</script>';
			echo '<script>window.location = "index.php"</script>';
		} else {
			header("Content-type: application/vnd.ms-word; charset=utf-8");
			header("Content-Disposition: attachment;Filename=PHPADVICES-DEMO-" . rand() . ".doc");

			header("Pragma: no-cache");
			header("Expires: 0");
			$html = '<html>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<body>
';

			//invoice header
			$html .= '
<table width="800px">
<tbody>';
			foreach ($lstItineraryTour as $key => $val) {
				$html .= '<tr style="border-collapse:collapse">
	<td rowspan="3" width="50%">
	<p>Day 1</p>
	</td>
	<td width="50%">
        <p>' . $clsTourItinerary->getTitleItineraryNew($val['tour_itinerary_id']) . '</p>
        <p>' . html_entity_decode($val['content']) . '</p>
    </td>
</tr>';
			}


			$html .= '</tbody>
</table>
';

			$html .= '
</body>
</html>
';

			echo $html;
		}
	}


	if (isset($_POST['plantrip']) && $_POST['plantrip'] == 'plantrip') {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
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
			$err_msg .= $core->get_Lang('hidden field');
		}
		#
		if ($errMsg == '') {
			$feedback_id = $clsFeedback->getMaxId();
			$feedback_code = $clsFeedback->generateFeedBack($feedback_id);
			$current_date = date('m/d/Y');
			$current_time = strtotime($current_date);
			$target_id = $target_id ? $target_id : 0;
			#
			$fx = "feedback_id,target_id,feedback_code,title,first_name,last_name,email,phone,address,country_id,feedback_store,user_ip,reg_date,departure_date";
			$vx = "'$feedback_id'
			,'" . $target_id . "'
			,'$feedback_code'
			,'" . $_POST['title'] . "'
			,'$firstname'
			,'$lastname'
			,'$email'
			,'$phone'
			,'$address'
			,'" . $_POST['countryex_id'] . "'
			,'" . serialize($_POST) . "'
			,'" . $_SERVER['REMOTE_ADDR'] . "'
			,'" . time() . "'
			,'" . $current_time . "'
			";
			#

			if ($clsFeedback->insertOne($fx, $vx)) {
				$clsFeedback->newBooking($feedback_id);
				vnSessionDelVar('tour_contact_id');
				vnSessionDelVar('cruise_contact_id');
				vnSessionDelVar('cruise_itinerary_contact_id');
				vnSessionDelVar('hotel_contact_id');
				header('location:' . $extLang . '/contact-us/success.html');
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

function default_contact2()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act;
    global $title_page, $description_page, $keyword_page;
    global $clsISO, $_LANG_ID, $_lang, $extLang;
    global $_frontIsLoggedin_user_id, $lstCountryEx;

    /* =========================================================
     * Khởi tạo class
     * ========================================================= */
    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;

    $clsCruiseCabin = new CruiseCabin();
    $assign_list['clsCruiseCabin'] = $clsCruiseCabin;

    $clsCruiseItinerary = new CruiseItinerary();
    $assign_list['clsCruiseItinerary'] = $clsCruiseItinerary;

    $clsVoucher = new Voucher();
    $assign_list['clsVoucher'] = $clsVoucher;

    $clsCity = new City();
    $assign_list['clsCity'] = $clsCity;

    $clsHotel = new Hotel();
    $assign_list['clsHotel'] = $clsHotel;

    $clsHotelRoom = new HotelRoom();
    $assign_list['clsHotelRoom'] = $clsHotelRoom;

    $clsFeedback = new Feedback();
    $assign_list['clsFeedback'] = $clsFeedback;

    $clsCountry = new _Country();
    $assign_list['clsCountry'] = $clsCountry;

    $clsTourOption = new TourOption();
    $assign_list['clsTourOption'] = $clsTourOption;

    $clsFAQ = new FAQ();
    $assign_list['clsFAQ'] = $clsFAQ;

    /* =========================================================
     * Quốc gia và FAQ
     * ========================================================= */
    $lstCountryRegion = $clsCountry->getAll(
        'is_trash=0 ORDER BY order_no ASC',
        $clsCountry->pkey . ',title'
    );

    $assign_list['lstCountryRegion'] = is_array($lstCountryRegion)
        ? $lstCountryRegion
        : [];

    $lstFaqs = $clsFAQ->getAll(
        'is_trash=0 AND is_online=1 ORDER BY order_no ASC LIMIT 0,4',
        $clsFAQ->pkey . ',title,content'
    );

    $assign_list['lstFaqs'] = is_array($lstFaqs)
        ? $lstFaqs
        : [];

    /* =========================================================
     * Lấy session dịch vụ liên hệ
     * ========================================================= */
    $cartSessionService = vnSessionGetVar('ContactTour');
    $cartSessionCruise = vnSessionGetVar('ContactCruise');
    $cartSessionHotel = vnSessionGetVar('ContactHotel');
    $cartSessionVoucher = vnSessionGetVar('ContactVoucher');

    $assign_list['cartSessionService'] = $cartSessionService;
    $assign_list['cartSessionCruise'] = $cartSessionCruise;
    $assign_list['cartSessionHotel'] = $cartSessionHotel;
    $assign_list['cartSessionVoucher'] = $cartSessionVoucher;

    if (
        empty($cartSessionService)
        && empty($cartSessionCruise)
        && empty($cartSessionHotel)
        && empty($cartSessionVoucher)
    ) {
        header('Location: ' . $clsISO->getLink('contact'));
        exit();
    }

    /* =========================================================
     * Thông tin thành viên đăng nhập
     * ========================================================= */
    if (!empty($_frontIsLoggedin_user_id)) {
        $clsMember = new Member();
        $assign_list['clsMember'] = $clsMember;

        $memberId = (int)$_frontIsLoggedin_user_id;

        $fullname = $clsMember->getFullName($memberId);
        $email = $clsMember->getEmail($memberId);
        $phone = $clsMember->getPhone($memberId);
        $countryId = (int)$clsMember->getOneField(
            'country_id',
            $memberId
        );
        $memberTitle = $clsMember->getOneField(
            'title',
            $memberId
        );

        /*
         * Template đang dùng fullname, không dùng name.
         */
        $assign_list['fullname'] = $fullname;
        $assign_list['name'] = $fullname;
        $assign_list['email'] = $email;
        $assign_list['phone'] = $phone;
        $assign_list['country_id'] = $countryId;
        $assign_list['title'] = $memberTitle;
    }

    $errMsg = '';
    $assign_list['errMsg'] = '';

    /* =========================================================
     * Submit
     * ========================================================= */
    if (
        isset($_POST['plantrip'])
        && !is_array($_POST['plantrip'])
        && $_POST['plantrip'] === 'plantrip'
    ) {
        /*
         * Lấy dữ liệu an toàn.
         */
        $type = isset($_POST['type']) && !is_array($_POST['type'])
            ? trim((string)$_POST['type'])
            : '';

        $fullname = isset($_POST['fullname'])
            && !is_array($_POST['fullname'])
                ? trim(strip_tags((string)$_POST['fullname']))
                : '';

        $email = isset($_POST['email'])
            && !is_array($_POST['email'])
                ? strtolower(trim((string)$_POST['email']))
                : '';

        $phone = isset($_POST['phone'])
            && !is_array($_POST['phone'])
                ? trim(strip_tags((string)$_POST['phone']))
                : '';

        $address = isset($_POST['address'])
            && !is_array($_POST['address'])
                ? trim(strip_tags((string)$_POST['address']))
                : '';

        $comments = isset($_POST['Comments'])
            && !is_array($_POST['Comments'])
                ? trim((string)$_POST['Comments'])
                : '';

        $birthdayInput = isset($_POST['birthday'])
            && !is_array($_POST['birthday'])
                ? trim((string)$_POST['birthday'])
                : '';

        $countryId = isset($_POST['country_id'])
            && !is_array($_POST['country_id'])
                ? (int)$_POST['country_id']
                : 0;

        $cityId = isset($_POST['city_id'])
            && !is_array($_POST['city_id'])
                ? (int)$_POST['city_id']
                : 0;

        $contactTitle = isset($_POST['title'])
            && !is_array($_POST['title'])
                ? trim(strip_tags((string)$_POST['title']))
                : '';

        /*
         * Gán lại dữ liệu để form không bị mất khi có lỗi.
         */
        $assign_list['fullname'] = $fullname;
        $assign_list['email'] = $email;
        $assign_list['phone'] = $phone;
        $assign_list['address'] = $address;
        $assign_list['Comments'] = $comments;
        $assign_list['birthday'] = $birthdayInput;
        $assign_list['country_id'] = $countryId;
        $assign_list['city_id'] = $cityId;
        $assign_list['title'] = $contactTitle;

        /* =====================================================
         * Validate server
         * ===================================================== */
        if ($fullname === '') {
            $errMsg .= $core->get_Lang(
                'Your first name should not be empty'
            ) . '<br>';
        }

        if (
            $email === ''
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            $errMsg .= $core->get_Lang(
                'Please enter a valid email address'
            ) . '<br>';
        }

        if ($phone === '') {
            $errMsg .= $core->get_Lang(
                'Your telephone should not be empty'
            ) . '<br>';
        }

        if ($countryId <= 0) {
            $errMsg .= $core->get_Lang(
                'Please select country'
            ) . '<br>';
        }


        /* =====================================================
         * Xác định loại và target
         * ===================================================== */
        $allowedTypes = [
            'Tour',
            'Cruise',
            'Hotel',
            'Voucher'
        ];

        if (!in_array($type, $allowedTypes, true)) {
            /*
             * Trường hợp form có nhiều input type trùng nhau hoặc
             * không truyền type, tự xác định từ session.
             */
            if (!empty($cartSessionCruise)) {
                $type = 'Cruise';
            } elseif (!empty($cartSessionService)) {
                $type = 'Tour';
            } elseif (!empty($cartSessionHotel)) {
                $type = 'Hotel';
            } elseif (!empty($cartSessionVoucher)) {
                $type = 'Voucher';
            } else {
                $type = '';
            }
        }

        $targetId = 0;

        switch ($type) {
            case 'Cruise':
                $targetId = isset($_POST['cruise_id'])
                    && !is_array($_POST['cruise_id'])
                        ? (int)$_POST['cruise_id']
                        : 0;
                break;

            case 'Tour':
                $targetId = isset($_POST['tour_id'])
                    && !is_array($_POST['tour_id'])
                        ? (int)$_POST['tour_id']
                        : 0;
                break;

            case 'Hotel':
                $targetId = isset($_POST['hotel_id'])
                    && !is_array($_POST['hotel_id'])
                        ? (int)$_POST['hotel_id']
                        : 0;
                break;

            case 'Voucher':
                $targetId = isset($_POST['voucher_id'])
                    && !is_array($_POST['voucher_id'])
                        ? (int)$_POST['voucher_id']
                        : 0;
                break;
        }

        if ($type === '' || $targetId <= 0) {
            $errMsg .= $core->get_Lang(
                'Service information is invalid'
            ) . '<br>';
        }

        /*
         * Chuyển birthday thành timestamp an toàn.
         */
        $birthdayTimestamp = 0;

        if ($birthdayInput !== '') {
            $birthdayTimestamp = strtotime($birthdayInput);

            if ($birthdayTimestamp === false) {
                $birthdayTimestamp = 0;
                $errMsg .= $core->get_Lang(
                    'Date of birth is invalid'
                ) . '<br>';
            }
        }

        /* =====================================================
         * Insert feedback
         * ===================================================== */
        if ($errMsg === '') {
            $feedbackId = (int)$clsFeedback->getMaxId();
            $feedbackCode = $clsFeedback->generateFeedBack(
                $feedbackId
            );

            /*
             * departure_date cũ đang dùng ngày hiện tại.
             */
            $currentDate = date('Y-m-d');
            $currentTime = strtotime($currentDate);

            $remoteIp = isset($_SERVER['REMOTE_ADDR'])
                ? trim((string)$_SERVER['REMOTE_ADDR'])
                : '';

            /*
             * Không serialize trực tiếp dữ liệu không kiểm soát.
             * Vẫn giữ để tương thích code newBooking().
             */
            $feedbackStoreData = $_POST;

            /*
             * Loại bỏ giá trị nguy hiểm hoặc không cần thiết.
             */
            unset(
                $feedbackStoreData['g-recaptcha-response'],
                $feedbackStoreData['hidden_field']
            );

            $feedbackStore = serialize($feedbackStoreData);

            $fields = implode(',', [
                'feedback_id',
                'target_id',
                'feedback_code',
                'title',
                'fullname',
                'birthday',
                'email',
                'phone',
                'address',
                'country_id',
                'feedback_store',
                'user_ip',
                'reg_date',
                'departure_date',
                'type'
            ]);

            $values = "'{$feedbackId}'"
                . ",'{$targetId}'"
                . ",'" . addslashes($feedbackCode) . "'"
                . ",'" . addslashes($contactTitle) . "'"
                . ",'" . addslashes($fullname) . "'"
                . ",'" . (int)$birthdayTimestamp . "'"
                . ",'" . addslashes($email) . "'"
                . ",'" . addslashes($phone) . "'"
                . ",'" . addslashes($address) . "'"
                . ",'" . (int)$countryId . "'"
                . ",'" . addslashes($feedbackStore) . "'"
                . ",'" . addslashes($remoteIp) . "'"
                . ",'" . time() . "'"
                . ",'" . (int)$currentTime . "'"
                . ",'" . addslashes($type) . "'";

            try {
    $insertResult = $clsFeedback->insertOne(
        $fields,
        $values
    );
} catch (Throwable $exception) {
    $insertResult = false;

    error_log(
        'Contact2 insert exception: '
        . $exception->getMessage()
    );
}
if ($insertResult) {
    /*
     * Gửi mail, nhưng không để lỗi mail làm hỏng submit.
     */
    try {
        $clsFeedback->newBooking(
            $feedbackId,
            $type
        );
    } catch (Throwable $exception) {
        error_log(
            'Contact2 newBooking exception: '
            . $exception->getMessage()
        );
    }

    vnSessionDelVar('ContactCruise');
    vnSessionDelVar('ContactHotel');
    vnSessionDelVar('ContactTour');
    vnSessionDelVar('ContactVoucher');

    if ($_LANG_ID === 'vn') {
        $successUrl = $extLang
            . '/lien-he-thanh-cong/fb-'
            . $feedbackId
            . '.html';
    } else {
        $successUrl = $extLang
            . '/contact-us-success/fb-'
            . $feedbackId
            . '.html';
    }

    header('Location: ' . $successUrl);
    exit();
}
error_log(
    'Contact2 insert failed: '
    . json_encode([
        'feedback_id' => $feedbackId,
        'target_id' => $targetId,
        'type' => $type,
        'country_id' => $countryId,
        'birthday' => $birthdayTimestamp,
        'email' => $email
    ], JSON_UNESCAPED_UNICODE)
);

$errMsg .= $core->get_Lang(
    'Unable to save your enquiry. Please try again'
) . '<br>';
        }


    }

    /* =========================================================
     * SEO
     * ========================================================= */
    $title_page = $core->get_Lang('contactus')
        . ' | '
        . PAGE_NAME;

    $description_page = $title_page;
    $keyword_page = $title_page;

    $assign_list['title_page'] = $title_page;
    $assign_list['description_page'] = $description_page;
    $assign_list['keyword_page'] = $keyword_page;
}

function default_contact3()
{

	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page;
	global $clsISO, $_LANG_ID, $_lang, $extLang, $_frontIsLoggedin_user_id, $lstCountryEx;
	#

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
	if ($type != '') {
		vnSessionDelVar('Contact' . $type);
	}
	echo json_encode(array(
		'msg' => 'ok'
	));
	die();
}

function default_team()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $title_page, $description_page, $keyword_page, $oneCommon;
	global $clsConfiguration, $extLang, $_LANG_ID, $clsISO;
	if (!$core->checkActiveModule('team')) {
		header('Location:/');
		exit();
	}
	#
	$clsTeam = new Team();
	$assign_list['clsTeam'] = $clsTeam;
	#
	$listTeam = $clsTeam->getAll("is_trash=0 and is_online=1 and languages='$_LANG_ID' order by order_no asc", $clsTeam->pkey);
	$assign_list['listTeam'] = $listTeam;
	unset($listTeam);

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Our Team') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*========================================================*/
	unset($clsFeedback);
	unset($clsISO);
}

function default_sitemap()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	#-- Country
	$clsCountry = new Country();
	$assign_list['clsCountry'] = $clsCountry;
	$lstCountry = $clsCountry->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsCountry->pkey);
	$assign_list['lstCountry'] = $lstCountry;
	#-- City
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;
	#-- TourCategory
	$clsTourCategory = new TourCategory();
	$assign_list['clsTourCategory'] = $clsTourCategory;
	$listCatTours = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsTourCategory->pkey);
	$assign_list['listCatTours'] = $listCatTours;
	#-- Travel News
	$clsNewsCategory = new NewsCategory();
	$assign_list['clsNewsCategory'] = $clsNewsCategory;
	$lstNewsCategory = $clsNewsCategory->getAll('is_trash=0 and is_online=1 order by order_no asc', $clsNewsCategory->pkey);
	$assign_list['lstNewsCategory'] = $lstNewsCategory;
	unset($lstNewsCategory);
	#-- Information
	$clsPage = new Page();
	$assign_list['clsPage'] = $clsPage;
	$assign_list['lstPage'] = $clsPage->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsPage->pkey);
	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('sitemap') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
	/*=============Content Page==================*/
	unset($clsCategory);
	unset($clsCountry);
	unset($clsCity);
}
function default_FAQ()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	if (!$core->checkActiveModule('faqs')) {
		header('Location:/');
	}
	#
	$clsFAQ = new FAQ();
	$assign_list["clsFAQ"] = $clsFAQ;
	$clsFAQCategory = new FAQCategory();
	$assign_list["clsFAQCategory"] = $clsFAQCategory;
	#
	$lstFAQCat = $clsFAQCategory->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsFAQCategory->pkey);
	$assign_list["lstFAQCat"] = $lstFAQCat;
	unset($lstFAQCat);
	#
	$listFAQs = $clsFAQ->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsFAQ->pkey);
	$assign_list["listFAQs"] = $listFAQs;
	unset($listFAQs);

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('faqs') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_why()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	if (!$core->checkActiveModule('why')) {
		header('Location:/');
		exit();
	}
	#
	$clsWhy = new Why();
	$assign_list["clsWhy"] = $clsWhy;
	#
	$lstWhy = $clsWhy->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsWhy->pkey);
	$assign_list["lstWhy"] = $lstWhy;
	unset($lstWhy);
	#

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Why travel with us') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
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
		$assign_list['SiteMsgServiceSuccess'] = $messageSuccess;
	} elseif ($show == 'registerAgent') {
		$messageSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_AgentSuccess_' . $_LANG_ID);
		$messageSuccess = html_entity_decode($messageSuccess);
		$assign_list['SiteMsgAgentSuccess'] = $messageSuccess;
	} else {
		$messageSuccess = $clsConfiguration->getValueAutoInfo('SiteMsg_TourSuccess_' . $_LANG_ID);
		$messageSuccess = html_entity_decode($messageSuccess);
		$messageSuccess = str_replace('[%CUSTOMER_EMAIL%]', $clsBooking->getEmailSuccess($booking_id), $messageSuccess);
		$messageSuccess = str_replace('[%CUSTOMER_FULLNAME%]', $clsBooking->getFullName($booking_id), $messageSuccess);
		$messageSuccess = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $messageSuccess);

		$assign_list['SiteMsgTourSuccess'] = $messageSuccess;
	}





	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Success') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_brochure()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $_lang;
	if (!$core->checkActiveModule('download')) {
		header('Location:/');
		exit();
	}
	#
	$clsDownload = new Download();
	$assign_list["clsDownload"] = $clsDownload;

	$listDownload = $clsDownload->getAll("is_trash=0 and is_online=1 and attachment_file<>'' order by order_no asc", $clsDownload->pkey . ",attachment_file");
	$assign_list["listDownload"] = $listDownload;
	unset($listDownload);

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Trade Brochures') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$keyword_page = $title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
