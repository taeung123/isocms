<?php
require_once(DIR_INCLUDES . '/isoman/php/index.php');
function default_default2()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $package_id;
	global $clsConfiguration, $lang_sql;

	//   List Slide
	$clsSlide = new Slide();
	$assign_list['clsSlide'] = $clsSlide;

	$listSlide = $clsSlide->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsSlide->pkey . ',title,text,image,link');
	$assign_list['listSlide'] = $listSlide;


	//   List Ads
	$clsAds = new Ads();
	$assign_list['clsAds'] = $clsAds;
	$listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
	$assign_list['listAdsHome'] = $listAdsHome;

	//    List Discount
	$clsDiscount = new Discount();
	$assign_list['clsDiscount'] = $clsDiscount;

	$lstDiscount = $clsDiscount->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsDiscount->pkey . "code, title, more_information");
	$assign_list['listDiscount'] = $lstDiscount;

	//    Why
	$clsWhy = new Why();
	$assign_list['clsWhy'] = $clsWhy;
	$listWhyHome = $clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC", $clsWhy->pkey);
	$assign_list['listWhyHome'] = $listWhyHome;
	unset($listWhyHome);

	//  List Top Blog
	if ($clsISO->getCheckActiveModulePackage($package_id, 'blog', 'default', 'default')) {
		$clsBlog = new Blog();
		$assign_list['clsBlog'] = $clsBlog;

		$cond = "is_trash=0 and is_approve=1 and is_online=1 ";
		$limit = " LIMIT 0,4";
		$orderby = "order by order_no ASC";

		$lstTopBlog = $clsBlog->getAll($cond . $orderby . $limit, $clsBlog->pkey . ',title,slug,image,intro,publish_date');
		$assign_list['lstTopBlog'] = $lstTopBlog;
		unset($lstTopBlog);
	}

	//    Top Travel Styles
	$clsTourCategory = new TourCategory();
	$assign_list['clsTourCategory'] = $clsTourCategory;
	$clsPagination = new Pagination();
	$assign_list['clsPagination'] = $clsPagination;

	$cond = "is_trash=0 and is_online=1 and parent_id=0";
	$orderby = " order by order_no ASC";
	$lstCatTour = $clsTourCategory->getAll($cond . $orderby, $clsTourCategory->pkey . ",title,slug,image");
	$assign_list["lstCatTour"] = $lstCatTour;

	// Top Destination
	$clsCountryEx = new Country();
	$assign_list['clsCountryEx'] = $clsCountryEx;

	$listCountryDestination = $clsCountryEx->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsCountryEx->pkey . ",title,slug,image,intro");
	$assign_list["listCountryDestination"] = $listCountryDestination;
	unset($listCountryDestination);

	$clsRegion = new Region();
	$assign_list["clsRegion"] = $clsRegion;
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;

	$lstRegion = $clsRegion->getAll("is_trash=0 and is_online=1 and country_id IN (1,4,14,18) order by order_no asc", $clsRegion->pkey . ",title,slug,country_id");
	$lstRegionTour = array();
	$k_new = 0;
	foreach ($lstRegion as $k => $v) {
		$listCityTourByRegion = $clsCity->getListCityTourByRegion($v['region_id'], '', $v['country_id']);
		if ($listCityTourByRegion) {
			$lstRegionTour[$k_new] = $v;
			$lstRegionTour[$k_new]['listCityTourByRegion'] = $listCityTourByRegion;
			$k_new++;
		}
	}
	$assign_list["lstRegionTour"] = $lstRegionTour;
	unset($lstRegionTour);
	$lstCityInbound = $clsCity->getAll("is_trash=0 and is_online=1 and country_id IN (1,4,14,18) order by order_no ASC", $clsCity->pkey . ",title,slug");
	$assign_list["lstCityInbound"] = $lstCityInbound;
	unset($lstCityInbound);

	// Offers destination
	$clsRegion = new Region();
	$assign_list["clsRegion"] = $clsRegion;
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;
	$clsCountryEx = new Country();
	$assign_list['clsCountryEx'] = $clsCountryEx;


	// List Top Hotel
	$clsHotel = new Hotel();
	$assign_list['clsHotel'] = $clsHotel;
	$order_by = " ORDER BY order_no ASC";
	$cond = "is_trash=0 and is_online=1";
	$limit = " LIMIT 0,10";
	$listHotel = $clsHotel->getAll($cond . $order_by . $limit, $clsHotel->pkey . ",title,intro,image,address,slug");
	$assign_list['listHotel'] = $listHotel;
	unset($listHotel);

	// List Top Voucher
	$clsVoucher = new Voucher();
	$assign_list['clsVoucher'] = $clsVoucher;
	$clsVoucherCat = new VoucherCat();
	$assign_list['clsVoucherCat'] = $clsVoucherCat;
	$order_by = " ORDER BY order_no ASC";
	$cond = "is_trash=0 and is_online=1";
	$limit = " LIMIT 0,10";
	$orderBy = " order by order_no asc";
	$lstVoucher = $clsVoucher->getAll($cond . $orderBy . $limit, $clsVoucher->pkey . ",title,intro,image,code,slug,cat_id");
	$assign_list['lstVoucher'] = $lstVoucher;
	unset($lstVoucher);

	//List Top Cruise
	$clsCruise = new Cruise();
	$assign_list['clsCruise'] = $clsCruise;
	$listCruise = $clsCruise->getAll($cond . $order_by . $limit, $clsCruise->pkey . ",title,about,image");
	$assign_list["listCruise"] = $listCruise;
	unset($listCruise);

	//List Top Destination
	$clsCityStore = new CityStore();
	$assign_list['clsCityStore'] = $clsCityStore;
	$cond_top = "is_trash=0 and type='TOP'";
	if (isset($_GET['slug_country']) && !empty($_GET['slug_country'])) {
		$slug_country = $_GET['slug_country'];
		$country_id = $clsCountryEx->getBySlug($slug_country);
		$cond .= " and country_id = '$country_id'";
	}

	$sql_top_city = "SELECT " . DB_PREFIX . "city.city_id," . DB_PREFIX . "city.title," . DB_PREFIX . "city.slug," . DB_PREFIX . "city.image," . DB_PREFIX . "city.country_id FROM " . DB_PREFIX . "city INNER JOIN " . DB_PREFIX . "citystore ON " . DB_PREFIX . "city.city_id = " . DB_PREFIX . "citystore.city_id AND " . DB_PREFIX . "citystore.type='TOP' AND " . DB_PREFIX . "citystore.lang_id='$lang_sql' ORDER BY
         " . DB_PREFIX . "city.title ASC";

	$listTopDestination = $dbconn->getAll($sql_top_city);
	$assign_list['listTopDestination'] = $listTopDestination;
	unset($listTopDestination);



	/*=============Title & Description Page==================*/
	$title_page = $clsConfiguration->getValue('SiteMetaTitle');
	$assign_list["title_page"] = $title_page;
	$description_page = $clsConfiguration->getValue('SiteMetaDescription');;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}
function default_default2_bak()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $clsConfiguration, $clsISO, $package_id;
	#
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$clsTourCategory = new TourCategory();
	$assign_list['clsTourCategory'] = $clsTourCategory;
	$clsTestimonial = new Testimonial();
	$assign_list['clsTestimonial'] = $clsTestimonial;
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;
	$clsCountry = new Country();
	$assign_list['clsCountry'] = $clsCountry;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;
	$clsAds = new Ads();
	$assign_list['clsAds'] = $clsAds;
	$clsSlide = new Slide();
	$assign_list['clsSlide'] = $clsSlide;
	$clsReviews = new Reviews();
	$assign_list['clsReviews'] = $clsReviews;
	$clsWhy = new Why();
	$assign_list['clsWhy'] = $clsWhy;
	#ads
	if ($clsISO->getCheckActiveModulePackage($package_id, 'ads', 'default', 'default')) {
		$listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
		$assign_list['listAdsHome'] = $listAdsHome;
		unset($listAdsHome);
	}

	#whywith_us
	if ($clsISO->getCheckActiveModulePackage($package_id, 'why', 'default', 'default')) {
		$listWhyHome = $clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC", $clsWhy->pkey . ',title,image,intro');
		$assign_list['listWhyHome'] = $listWhyHome;
		unset($listWhyHome);
	}

	/*=============Title & Description Page==================*/
	$title_page = $clsConfiguration->getValue('SiteMetaTitle');
	$assign_list["title_page"] = $title_page;
	$description_page = $clsConfiguration->getValue('SiteMetaDescription');;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}
function default_default()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $clsISO, $clsConfiguration;
	// ini_set('display_errors', 1);
	// error_reporting(E_ERROR & ~E_STRICT); //E_ALL
	#
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$clsTourCategory = new TourCategory();
	$assign_list['clsTourCategory'] = $clsTourCategory;
	$clsTestimonial = new Testimonial();
	$assign_list['clsTestimonial'] = $clsTestimonial;
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;
	$clsCountry = new Country();
	$assign_list['clsCountry'] = $clsCountry;
	$clsProperty = new Property();
	$assign_list["clsProperty"] = $clsProperty;
	$clsAds = new Ads();
	$assign_list['clsAds'] = $clsAds;
	$clsSlide = new Slide();
	$assign_list['clsSlide'] = $clsSlide;
	$clsReviews = new Reviews();
	$assign_list['clsReviews'] = $clsReviews;
	$clsWhy = new Why();
	$assign_list['clsWhy'] = $clsWhy;
	#

	#ads
	$listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
	$assign_list['listAdsHome'] = $listAdsHome;
	#whywith_us
	$listWhyHome = $clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC", $clsWhy->pkey);
	$assign_list['listWhyHome'] = $listWhyHome;
	unset($listWhyHome);

	/*=============Title & Description Page==================*/
	$title_page = $clsConfiguration->getValue('SiteMetaTitle');
	$assign_list["title_page"] = $title_page;
	$description_page = $clsConfiguration->getValue('SiteMetaDescription');;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
	unset($clsTour);
}
function default_tour_start_date()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $clsISO, $clsConfiguration;
	#
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$clsTourGroup = new TourGroup();
	$assign_list['clsTourGroup'] = $clsTourGroup;
	$clsTourStartDate = new TourStartDate();
	$assign_list['clsTourStartDate'] = $clsTourStartDate;

	$tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
	if (intval($tour_group_id) == 0) {
		header('location:' . PCMS_URL);
		exit();
	}
	$lstTourGroup = $clsTourGroup->getAll('is_trash=0 and is_online=1 order by order_no ASC', $clsTourGroup->pkey);
	$assign_list['lstTourGroup'] = $lstTourGroup;
	unset($lstTourGroup);

	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '" . time() . "' and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_store) and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc limit 0,20", $clsTourStartDate->pkey . ',tour_id');
	$assign_list['lstTourStartDate'] = $lstTourStartDate;


	/*=============Title & Description Page==================*/
	$title_page = PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsConfiguration->getValue('ImageShareSocial');
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
	/*=============Content Page==================*/
	unset($clsTour);
}
function default_ajload_list_tour_start_date()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
	#
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$clsTourGroup = new TourGroup();
	$assign_list['clsTourGroup'] = $clsTourGroup;
	$clsTourStartDate = new TourStartDate();
	$assign_list['clsTourStartDate'] = $clsTourStartDate;

	$tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '" . time() . "' and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_store) and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc limit 0,20", $clsTourStartDate->pkey . ',tour_id');
	$assign_list['lstTourStartDate'] = $lstTourStartDate;

	#
	$assign_list['tour_group_id'] = $tour_group_id;

	$html = $core->build('load_list_tour_strat_date.tpl');
	echo $html;
	die();
}
function default_ajload_list_tour_start_date_mobile()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
	#
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$clsTourGroup = new TourGroup();
	$assign_list['clsTourGroup'] = $clsTourGroup;
	$clsTourStartDate = new TourStartDate();
	$assign_list['clsTourStartDate'] = $clsTourStartDate;

	$tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '" . time() . "' and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_store) and tour_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc limit 0,20", $clsTourStartDate->pkey . ',tour_id');
	$assign_list['lstTourStartDate'] = $lstTourStartDate;

	#
	$assign_list['tour_group_id'] = $tour_group_id;

	$html = $core->build('load_list_tour_strat_date_mobile.tpl');
	echo $html;
	die();
}
function default_set_cookie()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
	$clsCustomer = new Customer();
	$customer_str = isset($_GET['customer_id']) ? ($_GET['customer_id']) : '';
	$customer_id = intval($core->decryptID($customer_str));

	//print_r($customer_id); die();

	$is_online = $clsCustomer->getOneField('is_online', $customer_id);
	$package_id = $clsCustomer->getOneField('package_id', $customer_id);

	$expired_date = $clsCustomer->getOneField('expired_date', $customer_id);
	$customer_demo = $_COOKIE["customer_demo_isocms"];


	if ($expired_date < time() || $is_online == 0) {
		if ($is_online == 0) {
			setcookie("customer_demo_isocms", "demo_isocms", time() - 100, "/");
			print_r("Bạn không được cấp quyền truy cập vào website này");
			die();
		} else {
			print_r("Bạn không được cấp quyền truy cập vào website này");
			die();
		}
	} else {
		if ($package_id == 1) {
			setcookie("customer_demo_isocms", "demo_isocms", $expired_date, "/");
			header('location:https://essentials.isocms.com');
			exit();
		} elseif ($package_id == 2) {

			setcookie("customer_demo_isocms", "demo_isocms", $expired_date, "/");
			header('location:https://professional.isocms.com');
			exit();
		} elseif ($package_id == 3) {
			setcookie("customer_demo_isocms", "demo_isocms", $expired_date, "/");
			header('location:https://premium.isocms.com');
			exit();
		} elseif ($package_id == 4) {
			setcookie("customer_demo_isocms", "demo_isocms", $expired_date, "/");
			header('location:https://isocms.com');
			exit();
		} else {
			header('location:http://isocms.net');
			exit();
		}


		setcookie("customer_demo_isocms", "demo_isocms", $expired_date, "/");
		header('Location: ' . DOMAIN_NAME);
		exit();
	}
}
function default_set_cookie2()
{

	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;

	$package_str = isset($_GET['sid']) ? ($_GET['sid']) : '';
	$package_id = intval($core->decryptID($package_str));
	if ($package_id == 5) {
		$package_id = 1;
	}
	if ($package_id == 6) {
		$package_id = 2;
	}
	if ($package_id == 7) {
		$package_id = 3;
	}
	if ($package_id == 8) {
		$package_id = 4;
	}

	$enip_str = isset($_GET['enip']) ? ($_GET['enip']) : '';
	$enip = $core->decryptID($enip_str);

	if ($enip == $_SERVER['REMOTE_ADDR']) {
		if ($package_id == 1) {
			setcookie("get_demo_1", "demo", time() + (86400 * 1), "/");
			header('location:http://essentials.isocms.com');
			exit();
		} elseif ($package_id == 2) {
			setcookie("get_demo_2", "demo", time() + (86400 * 1), "/");
			header('location:http://professional.isocms.com');
			exit();
		} elseif ($package_id == 3) {
			setcookie("get_demo_3", "demo", time() + (86400 * 1), "/");
			header('location:http://premium.isocms.com');
			exit();
		} elseif ($package_id == 4) {
			setcookie("get_demo_4", "demo", time() + (86400 * 1), "/");
			header('location:https://isocms.com');
			exit();
		} else {
			header('location:http://isocms.net');
			exit();
		}
	} else {
		header('location:http://isocms.net');
		exit();
	}
}
function default_test_html()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
	//print_r($list_city); die('xxxx');

}

function getChartDataCompareByCat($city_id, $PCI_Cat, $list_year)
{
	global $core;
	$clsISO = new ISO();
	$clsCity = new City();
	$clsData_PCI = new Data_PCI();

	$arr = array();
	$result = array();

	$lstYear = $this->getAll("is_trash=0 and is_online=1 and year<>2005 and year IN ($list_year) order by year ASC");
	$arr['name'] = $clsISO->getNameCPICategory($PCI_Cat);

	foreach ($lstYear as $key => $value) {
		$arr['data'][] = (float)$clsCity->getPCIDataItemValue($city_id, $PCI_Cat, $value['year']);
	}
	array_push($result, $arr);
	return json_encode($result);
}

function default_test_map_box()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;

	$clsCity = new City();
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$tour_id = 512;
	$assign_list['tour_id'] = $tour_id;


	$h = $clsTour->getLocationMapBox($tour_id);
	$u = $clsTour->getLocationMapBoxValue($tour_id);

	$assign_list['h_a'] = $h;
	$assign_list['u_a'] = $u;
}




function default_video()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
	#
}
function default_unknow()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $oneCommon;

	$URI = $_SERVER['REQUEST_URI'];
	if (str_replace('//', '/', $URI . '/') == $URI . '/') {
		header('location: ' . $URI . '/');
	}
	/*=============Title & Description Page==================*/
	$title_page = '404 page - ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '404';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '404';
	$assign_list["keyword_page"] = $keyword_page;
}
function default_popup()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
	#
	$html = '';
	$html .= '<div class="header">
				<a class="closeEv clickToClose" href="javascript:void();" title="Đóng"></a>
				<h3 class="headPop">Send email to friend</h3>
			</div>';
	$html .= '<div class="clearfix"></div>';
	$html .= '<form id="SendToFriendForm" method="post" action="">';
	$html .= '<div class="line-s">';
	$html .= '<label class="tit">To (Name):</label>';
	$html .= '<input class="txt" id="ToName" type="text" name="ToName">';
	$html .= '</div>';
	$html .= '<div class="line-s">';
	$html .= '<label class="tit">To (Email):</label>';
	$html .= '<input class="txt" id="ToEmail" type="text" name="ToEmail">';
	$html .= '</div>';
	$html .= '<div class="line-s">';
	$html .= '<label class="tit">From (Name):</label>';
	$html .= '<input class="txt" id="FromName" type="text" value="" name="FromName">';
	$html .= '</div>';
	$html .= '<div class="line-s">';
	$html .= '<label class="tit">From (Email):</label>';
	$html .= '<input class="txt" id="FromEmail" type="text" value="" name="FromEmail">';
	$html .= '</div>';
	$html .= '<div class="line-s">';
	$html .= '<label class="tit">From (Email):</label>';
	$html .= '<textarea id="Note" rows="2" cols="20" value="" class="textarea"></textarea>';
	$html .= '</div>';
	$html .= '<div class="line-s">';
	$html .= '<label class="tit">&nbsp;</label>';
	$html .= '<input id="SendToFriend" class="button" type="submit" value="Send">
			<input id="Reset" class="button" type="reset" value="Reset">';
	$html .= '</div>';
	$html .= '</form>';
	echo $html;
	die();
}
function default_checkCaptcha()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
	#
	$security_code = isset($_POST["security_code"]) ? $_POST["security_code"] : '';
	$security_code = strtoupper($security_code);
	$security_code = trim($security_code);
	if (!empty($security_code) && $security_code === vnSessionGetVar('skey')) {
		echo 1;
	} else {
		echo 0;
	}
	//
	die();
}
function default_sendMail()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $domain;
	#
	$from = $_POST['FromEmail'];
	$to   = $_POST['ToEmail'];
	$subject = 'Send mail friend';
	$message = "Một lá thư được gửi đến từ " . $_POST['FromName'] . " <br/>";
	$message .= "Nội dung : " . $_POST['Note'] . " <br/>";
	$message .= "Đường dẫn website : " . $_POST['current_link'] . "";
	$headers = 	"MIME-Version: 1.0\r\n" .
		"Content-type: text/html; charset=utf-8\r\n" .
		"From:  " . $_POST['FromName'] . "<" . $from . ">\r\n" .
		"Subject: " . $subject . "\r\n";
	$is_send_mail = @mail($to, $subject, $message, $headers);
	die();
}
function default_ajMakeSelectboxCategory()
{
	global $core;

	$clsTour = new Tour();
	$clsCountry = new Country();
	$clsTourCategory = new TourCategory();
	#
	$country_id = $_POST['country_id'];
	$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';

	$html = '<select class="selectbox" name="cat_id">';
	$html .= '<option value="0">-- Select vacation type --</option>';

	if (intval($country_id) > 0) {
		$lstCategory = $clsTourCategory->getAll("is_trash=0 order by order_no asc");
		if (is_array($lstCategory) && count($lstCategory) > 0) {
			foreach ($lstCategory as $k => $v) {
				if ($clsTour->countTourGolobal($country_id, 0, 0, $v[$clsTourCategory->pkey], 0) > 0) {
					$html .= '<option value="' . $v[$clsTourCategory->pkey] . '" ' . ($cat_id == $v[$clsTourCategory->pkey] ? 'selected="selected"' : '') . '>' . $clsTourCategory->getTitle($v[$clsTourCategory->pkey]) . '</option>';
				}
			}
		}
		unset($lstCategory);
	}
	$html .= '</select>';
	echo $html;
	die();
}
function default_ajMakeSelectboxDuration()
{
	$clsTour = new Tour();
	$clsCountry = new Country();
	#
	$country_id = $_POST['country_id'];
	$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
	$duration_id = isset($_POST['duration_id']) ? $_POST['duration_id'] : '';
	#
	$html = '<select class="selectbox" name="duration_id">';
	$html .= '<option value="0">-- Select duration--</option>';
	#
	$cond = "is_trash=0 and is_online=1";
	if (intval($country_id) > 0) {
		$cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id')";
	}
	if (intval($cat_id) > 0) {
		$cond .= " and (cat_id='$cat_id' or list_cat_id like '%|" . $cat_id . "|%')";
	}
	#
	if (intval($country_id) > 0 || intval($cat_id) > 0) {
		$res = $clsTour->getAll($cond . " order by number_day ASC limit 0,1000");
		$tmp = '';
		if (!empty($res)) {
			for ($i = 0; $i < count($res); $i++) {
				$tmp .= $clsTour->getSelectTripDuration($res[$i]['tour_id']) . '|';
			}
		}
		$tmp = array_unique(explode('|', $tmp));
		if (!empty($tmp)) {
			foreach ($tmp as $key => $val) {
				if ($val != '' && $val != 'n/a') {
					$selected = ($duration_id == $clsTour->convertDuration($val)) ? 'selected="selected"' : '';
					$html .= '<option value="' . $clsTour->convertDuration($val) . '" ' . $selected . '>' . $val . '</option>';
				}
			}
		}
	}
	$html .= '</select>';
	echo $html;
	die();
}
function default_ajMakeSelectboxCountry()
{
	$clsCountry = new Country();
	#
	$res = $clsCountry->getAll("is_trash=0 order by order_no asc");
	$html = '<select class="selectbox" name="country_id">';
	$html .= '<option value="0">-- Select country --</option>';
	if (is_array($res) && count($res) > 0) {
		foreach ($res as $k => $v) {
			$html .= '<option value="' . $v[$clsCountry->pkey] . '">-- ' . $clsCountry->getTitle($v[$clsCountry->pkey]) . ' --</option>';
		}
	}
	$html .= '</select>';
	unset($res);
	echo $html;
	die();
}
function default_ajLoadPackageDeals()
{
	global $core, $dbconn, $clsISO;
	#
	$clsTour = new Tour();
	$clsCountryEz = new Country();
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
	#
	$sql = "SELECT DISTINCT t1.tour_id FROM " . DB_PREFIX . "tour t1 INNER JOIN " . DB_PREFIX . "tour_destination t2 WHERE t1.tour_id = t2.tour_id AND t2.country_id='" . $country_id . "' and t1.is_trash=0 and t1.is_online=1 ORDER BY t1.order_no DESC limit 0,2";
	$lstTours = $dbconn->GetAll($sql);
	#
	$html = '';
	if (!empty($lstTours)) {
		for ($i = 0; $i < count($lstTours); $i++) {
			$tour_id = $lstTours[$i][$clsTour->pkey];
			$html .= '
			<div class="lst-ext-tours">
				<div class="row">
					<div class="col-md-3">
						<a class="photo" href="' . $clsTour->getLink($tour_id) . '" title="' . $clsTour->getTitle($tour_id) . '">
							<img src="' . $clsTour->getImageUrl($tour_id) . '" width="100%" alt="" />
							<span class="priceTours hide_m">
								' . $core->get_Lang('Price') . ' <br/>
								<strong class="valPrice">' . $clsTour->getTripPrice($tour_id) . '</strong>
							</span>
						</a>
					</div>
					<div class="col-md-7 r">
						<h3 class="title"><a href="' . $clsTour->getLink($tour_id) . '" title="' . $clsTour->getTitle($tour_id) . '">' . $clsTour->getTitle($tour_id) . '</a></h3>
						<div class="div_sub_duration">
							' . $core->get_Lang('Durations') . ':  <b class="val">' . $clsTour->getTripDuration($tour_id) . '</b>
						</div>
						<div class="div_sub_arround">
							' . $core->get_Lang('Destinations') . ':  ' . $clsTour->getCityAround($tour_id) . '
						</div>
						<div class="intro">' . $clsISO->truncateWord($clsTour->getStripIntro($tour_id), 20) . '</div>
					</div>
					<div class="col-md-2 boxPrice hide_s">
						<div class="priceVal">
							<div class="price_from">' . $core->get_Lang('Price') . '</div>
							<div class="valPrice">' . $clsTour->getTripPrice($tour_id) . '</div>
						</div>
						<a class="view" href="' . $clsTour->getLink($tour_id) . '" title="' . $core->get_Lang('View detail') . '">' . $core->get_Lang('View detail') . '></a>
					</div>
				</div>
			</div>';
		}
	}
	echo ($html . '|||' . $clsCountryEz->getLinkTour($country_id));
	die();
}

function default_ajaxLoadTotalWishlist()
{
	global $core, $dbconn, $profile_id;
	#

	$clsTable = isset($_POST['clsTable']) ? $_POST['clsTable'] : '';
	$clsClassTable = new $clsTable();
	$target_id = isset($_POST['target_id']) ? $_POST['target_id'] : 0;
	$user_id = $core->_USER['user_id'];
	#
	$totalWishlist = $clsClassTable->getOneField('wishlist_num', $target_id);

	echo $totalWishlist;
	die();
}

function default_ajaxSetCodeRate()
{
	global $core, $dbconn, $profile_id;
	#

	vnSessionDelVar('CurrencyCode');

	$CurrencyCode = isset($_POST['CODE']) ? $_POST['CODE'] : 'USD';
	vnSessionSetVar('CurrencyCode', $CurrencyCode);

	echo $CurrencyCode;
	die();
}


function default_ajUpdateWishlist()
{
	global $core, $dbconn, $profile_id;
	#
	$clsWishlist = new Wishlist();
	$clsTable = isset($_POST['clsTable']) ? $_POST['clsTable'] : '';
	$clsClassTable = new $clsTable;
	$target_id = isset($_POST['target_id']) ? $_POST['target_id'] : 0;
	$wishlist_num = $clsClassTable->getOneField('wishlist_num', $target_id);
	$user_id = $core->_USER['user_id'];
	#
	$lst = $clsWishlist->getAll("target_id='$target_id' and clsTable = '" . $clsTable . "' and member_id='" . $profile_id . "' limit 0,1");
	if (isset($lst[0][$clsWishlist->pkey])) {
		echo '_EXIST';
		die();
	} else {
		$fx = "wishlist_id,target_id,clsTable,member_id";
		$vx = "'" . $clsWishlist->getMaxID() . "','$target_id','$clsTable','$profile_id'";
		$clsWishlist->insertOne($fx, $vx);
	}
	$wishlist_num_update = $wishlist_num + 1;
	$set = "wishlist_num='" . $wishlist_num_update . "'";
	$clsClassTable->updateOne($target_id, $set);
	echo 1;
	die();
}
function default_ajDeleteWishlist()
{
	global $core, $dbconn, $profile_id;
	#
	$clsWishlist = new Wishlist();
	$clsTable = isset($_POST['clsTable']) ? $_POST['clsTable'] : '';
	$clsClassTable = new $clsTable;
	$target_id = isset($_POST['target_id']) ? $_POST['target_id'] : 0;
	$wishlist_num = $clsClassTable->getOneField('wishlist_num', $target_id);
	$user_id = $core->_USER['user_id'];
	#

	$lst = $clsWishlist->getAll("target_id='$target_id' and clsTable = '" . $clsTable . "' limit 0,1");
	if (isset($lst[0][$clsWishlist->pkey])) {
		$wishlist_id = $lst[0][$clsWishlist->pkey];
		$clsWishlist->deleteOne($wishlist_id);
	}
	echo '_SUSSESS';
	die();
}

function default_ajSubmitSubscribe()
{
	global $core, $mod, $act, $clsConfiguration, $clsISO;
	$clsSubscribe = new Subscribe();
	$clsFeedback=new Feedback(); 
	#
	$err_msg = "";
	$email = isset($_POST['email']) ? addslashes($_POST['email']) : '';
	$name = isset($_POST['name']) ? addslashes($_POST['name']) : '';
	$subscribe_check = isset($_POST['subscribe_check']) ? addslashes($_POST['subscribe_check']) : '';

	$current_date = date('m/d/Y');
	$current_time = strtotime($current_date);
	#
	$err_msg .= $clsISO->checkSubsTotalSe();

	if ($clsISO->isSpamContent($_POST)) {
		header('Content-Type: application/json');
		echo json_encode(["error" => $core->get_Lang('subscribe error 1')]);
		exit;
		//return false;
	}
	if (!$clsFeedback->checkRateLimit($_SERVER['REMOTE_ADDR'])) {
		header('Content-Type: application/json');
		echo json_encode(["error" => $core->get_Lang('subscribe error 2')]);
		exit;
		//return false;
	}
	$clsAntiSpam = new AntiSpam();
	if (
		!$clsAntiSpam->validateCSRF($_POST['via_spam_csrf']) ||
		!$clsAntiSpam->checkFormTime($_POST['via_from_time']) ||
		!$clsAntiSpam->checkHoneypot($_POST['via_key']) ||
		!$clsAntiSpam->validateJSToken($_POST['via_js_token']) ||
		!$clsAntiSpam->validateSignature($_POST['via_signature'],$_POST['via_from_time']) ||
		!$clsAntiSpam->rateLimit(5)
	) {

		header('Content-Type: application/json');
		echo json_encode(["error" => $core->get_Lang('subscribe error 3')]);
		exit;
	}
	if ($subscribe_check == '' && $err_msg == '') {
		if ($clsSubscribe->checkValidEmail($email) == '0') {
			$fx = "$clsSubscribe->pkey,fullname,email,user_ip,reg_date,departure_date,receive_newsletter";
			$vx = "'" . implode("', '", [$clsSubscribe->getMaxId(), $name, $email, $_SERVER['REMOTE_ADDR'], time(), $current_time, 1]) . "'";
			if ($clsSubscribe->insertOne($fx, $vx)) {
				$rec = ["success" => $core->get_Lang('Sign up for email success')];
				$clsISO->defer(function () use ($clsSubscribe, $email) {
					$clsSubscribe->sendMail($email);
				});
				//                echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess'));
			}
		} else {
			$rec = ["warning" => $core->get_Lang('Email address already exists !')];
			//            echo '_EXIST|||'.$core->get_Lang('Email address already exists !');
		}
	} else {
		$rec = ["error" => $core->get_Lang('subscribe error 4')];
		//        echo '_ERROR|||'.$core->get_Lang('subscribe error');
	}
	echo json_encode($rec);
}
function default_ajQuickBooking()
{
	global $core, $mod, $act, $clsConfiguration;
	$clsBooKingRoom = new BooKingRoom();
	#
	$name = isset($_POST['name']) ? addslashes($_POST['name']) : '';
	$email = isset($_POST['email']) ? addslashes($_POST['email']) : '';
	$phone = $_POST['phone'];
	$intro = $_POST['intro'];
	$type = $_POST['type'];
	#
	$max_id = $clsBooKingRoom->getMaxId();
	$fx = "booking_room_id,fullname,phone,email,type,intro_email,user_ip,reg_date";
	$vx = "'$max_id','$name',$phone,'$email','$type','$intro','" . $_SERVER['REMOTE_ADDR'] . "','" . time() . "'";
	if ($clsBooKingRoom->insertOne($fx, $vx)) {
		$clsBooKingRoom->sendMailQuickBooKing($max_id);
		echo '_SUCCESS|||' . html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess'));
		die();
	}
}
function default_ajSaveReviews_bak()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
	if (!class_exists('UploadFile')) {
		require_once(DIR_COMMON . '/class.upload.php');
	}
	$clsISO = new ISO();
	$clsReviews = new Reviews();
	$clsProfile = new Profile();
	$clsImage = new Image();
	#
	$_LANG_ID = isset($_POST['_LANG_ID']) ? addslashes($_POST['_LANG_ID']) : '';
	$type = $_POST['type'];
	if ($type == 'tour_new') {
		$type = 'tour';
	}
	$table_id = $_POST['table_id'];
	$rates = $_POST['rates'];
	$country_id = $_POST['country_id'];
	$message = nl2br(rawurldecode($_POST['message']));
	$datastore_folder = "/datastore/" . $clsProfile->getUsername($profile_id);
	$datastore_folder = str_replace('@', '', $datastore_folder);
	#
	$fullname = $clsProfile->getFullname($profile_id);
	$full_name_slug = $core->replaceSpace($fullname);
	$email = $clsProfile->getEmail($profile_id);

	$f = "reviews_id,reg_date,review_date,upd_date,table_id,type,rates,fullname,slug,email,content,order_no,is_trash,is_online,profile_id,country_id";
	$reviews_id = $clsReviews->getMaxId();
	$v = "'" . $reviews_id . "'
	,'" . time() . "'
	,'" . time() . "'
	,'" . time() . "'
	,'" . $table_id . "'
	,'" . $type . "'
	,'" . $rates . "'
	,'" . $fullname . "'
	,'" . $full_name_slug . "'
	,'" . $email . "'
	,'" . addslashes($message) . "'
	,'" . $clsReviews->getMaxOrderNo() . "'
	,'0','0'
	,'" . $profile_id . "'
    ,'" . $country_id . "'";

	//echo $f.'---'.$v;die('xxx');

	if ($clsReviews->insertOne($f, $v)) {
		if ($_FILES['media_images']['name'][0] != '') {
			$clsUploadFile = new UploadFile();
			for ($i = 0; $i < count($_FILES['media_images']['name']); $i++) {
				$file = array();
				$file["name"] = $_FILES['media_images']['name'][$i];
				$file["type"] = $_FILES['media_images']['type'][$i];
				$file["tmp_name"] = $_FILES['media_images']['tmp_name'][$i];
				$file["error"] = $_FILES['media_images']['error'][$i];
				$file["size"] = $_FILES['media_images']['size'][$i];

				$image = '';
				if (!is_uploaded_file($file['name'])) {
					$image = $clsUploadFile->uploadItem($file, $datastore_folder, "jpg,gif,png");
				}
				if ($image != '0' && $image != '') {
					$field = 'image_id,table_id,type,image,order_no,reg_date';
					$value = "'" . $clsImage->getMaxId() . "'
					,'$reviews_id'
					,'_REVIEW'
					,'" . addslashes($image) . "'
					,'" . $clsImage->getMaxOrderNo($reviews_id, '_REVIEW') . "'
					,'" . time() . "'";
					#
					$clsImage->insertOne($field, $value);
				}
			}
		}
		//$aaa = $clsReviews->sendMail($clsProfile->getEmail($profile_id),$message,$type);
		if ($aaa) {
			echo '_SUCCESS - ' . $aaa;
			die();
		} else {
			echo '_SUCCESS - error send mail';
			die();
		}
		//		echo '_SUCCESS'; die();
	} else {
		echo '_ERROR';
	}
}

function default_ajSaveReviews()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
	if (!class_exists('UploadFile')) {
		require_once(DIR_COMMON . '/class.upload.php');
	}
	$clsISO = new ISO();
	$clsReviews = new Reviews();
	$clsProfile = new Profile();
	$clsImage = new Image();
	#
	//    $_LANG_ID = isset($_POST['_LANG_ID']) ? addslashes($_POST['_LANG_ID']) : '';
	$type = $_POST['type'];
	if ($type == 'tour_new') {
		$type = 'tour';
	}
	$table_id = $_POST['table_id'];
	$rates = $_POST['rates'];
	$country_id = $_POST['country_id'];

	$fullname = $clsProfile->getFullname($profile_id);
	$full_name_slug = $core->replaceSpace($fullname);
	$email = $clsProfile->getEmail($profile_id);
	$phone = $_POST['phone_reviews'];

	$message = nl2br(rawurldecode($_POST['message']));

	$message_hidden = rawurldecode($_POST['message_hidden']);

	$ip_user = $_SERVER['REMOTE_ADDR'];
	$reviewCheck = $clsReviews->getAll("email = '" . $email . "' AND type = '$type' AND table_id = '$table_id' order by reg_date DESC limit 1", 'reg_date');
	$timeCheck = $reviewCheck && $reviewCheck[0] ? $reviewCheck[0]['reg_date'] : 0;
	$timeCurrent = time();
	$time1 = $timeCurrent - $timeCheck;

	if ($time1 < 86400 && $time1 > 0) { // 86400 giây = 24 giờ
		echo '_SPAM';
		die();
	}

	$datastore_folder = "/datastore/" . $clsProfile->getUsername($profile_id);
	$datastore_folder = str_replace('@', '', $datastore_folder);
	#

	$f = "reviews_id,reg_date,review_date,upd_date,table_id,type,rates,fullname,slug,email,content,order_no,is_trash,is_online,profile_id,country_id,phone,user_id";
	$reviews_id = $clsReviews->getMaxId();
	$v = "'" . $reviews_id . "'
	,'" . time() . "'
	,'" . time() . "'
	,'" . time() . "'
	,'" . $table_id . "'
	,'" . $type . "'
	,'" . $rates . "'
	,'" . $fullname . "'
	,'" . $full_name_slug . "'
	,'" . $email . "'
	,'" . addslashes($message_hidden) . "'
	,'" . $clsReviews->getMaxOrderNo() . "'
	,'0','0'
	,'" . $profile_id . "'
    ,'" . $country_id . "'
    ,'" . $phone . "'
    ,'" . $ip_user . "'";

	//echo $f.'---'.$v;die('xxx');

	if ($clsReviews->insertOne($f, $v)) {
		if ($_FILES['review_images']['name'][0] != '') {
			$clsUploadFile = new UploadFile();
			for ($i = 0; $i < count($_FILES['review_images']['name']); $i++) {
				$file = array();
				$file["name"] = $_FILES['review_images']['name'][$i];
				$file["type"] = $_FILES['review_images']['type'][$i];
				$file["tmp_name"] = $_FILES['review_images']['tmp_name'][$i];
				$file["error"] = $_FILES['review_images']['error'][$i];
				$file["size"] = $_FILES['review_images']['size'][$i];

				$image = '';
				if (!is_uploaded_file($file['name'])) {
					$image = $clsUploadFile->uploadItem($file, $datastore_folder, "jpg,gif,png");
				}
				if ($image != '0' && $image != '') {
					$field = 'image_id,table_id,type,image,order_no,reg_date';
					$value = "'" . $clsImage->getMaxId() . "'
					,'$reviews_id'
					,'_REVIEW'
					,'" . addslashes($image) . "'
					,'" . $clsImage->getMaxOrderNo($reviews_id, '_REVIEW') . "'
					,'" . time() . "'";
					#
					$clsImage->insertOne($field, $value);
				}
			}
		}
		$aaa = $clsReviews->sendMail($clsProfile->getEmail($profile_id), $reviews_id, $type, $message_hidden);
		if ($aaa) {
			echo '_SUCCESS - ' . $aaa;
			die();
		} else {
			echo '_SUCCESS - error send mail';
			die();
		}
		//		echo '_SUCCESS'; die();
	} else {
		echo '_ERROR';
	}
}
function default_ajSaveReviewsNoLogin_bak()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
	$clsISO = new ISO();
	$clsReviews = new Reviews();
	#
	$type = $_POST['type'];
	$table_id = $_POST['table_id'];
	$rates = $_POST['rates'];
	$fullname = $_POST['fullname'];
	$email = $_POST['email_reviews'];
	$country_id = $_POST['country_id'];
	$message = nl2br(rawurldecode($_POST['message']));

	#
	$f = "reviews_id,reg_date,review_date,upd_date,table_id,type,rates,fullname,email,country_id,content,order_no,is_trash,is_online";
	$reviews_id = $clsReviews->getMaxId();
	$v = "'" . $reviews_id . "'
	,'" . time() . "'
	,'" . time() . "'
	,'" . time() . "'
	,'" . $table_id . "'
	,'" . $type . "'
	,'" . $rates . "'
	,'" . $fullname . "'
	,'" . $email . "'
	,'" . $country_id . "'
	,'" . $message . "'
	,'" . $clsReviews->getMaxOrderNo() . "'
	,'0','0'";

	if ($clsReviews->insertOne($f, $v)) {
		$aaa = $clsReviews->sendMail($email, $message, $type);
		if ($aaa) {
			echo '_SUCCESS - ' . $aaa;
			die();
		} else {
			echo '_SUCCESS - error send mail';
			die();
		}
	} else {
		echo '_ERROR';
	}
}

function default_ajSaveReviewsNoLogin()
{
	global $clsISO, $profile_id;

	header('Content-Type: text/plain; charset=utf-8');

	if (
		!isset($_SERVER['REQUEST_METHOD'])
		|| $_SERVER['REQUEST_METHOD'] !== 'POST'
	) {
		echo '_ERROR - Invalid request method';
		exit;
	}

	$clsISO = new ISO();
	$clsImage = new Image();
	$clsReviews = new Reviews();
	$clsProfile = new Profile();

	/*
	 * Lấy và chuẩn hóa dữ liệu.
	 */
	$type = isset($_POST['type'])
		? strtolower(trim((string) $_POST['type']))
		: '';

	if ($type === 'tour_new') {
		$type = 'tour';
	}

	$allowedTypes = array(
		'tour',
		'voucher',
		'hotel',
		'cruise'
	);

	$table_id = isset($_POST['table_id'])
		? (int) $_POST['table_id']
		: 0;

	$rates = isset($_POST['rates'])
		? (int) $_POST['rates']
		: 0;

	$fullname = isset($_POST['fullname'])
		? trim((string) $_POST['fullname'])
		: '';

	$email = isset($_POST['email_reviews'])
		? trim((string) $_POST['email_reviews'])
		: '';

	$country_id = isset($_POST['country_id'])
		? (int) $_POST['country_id']
		: 0;

	$phone = isset($_POST['phone_reviews'])
		? trim((string) $_POST['phone_reviews'])
		: '';

	/*
	 * Form hiện tại gửi field message, không có message_hidden.
	 * Chỉ dùng message_hidden khi nó thực sự có nội dung.
	 */
	$message = isset($_POST['message'])
		? trim((string) $_POST['message'])
		: '';

	$messageHidden = isset($_POST['message_hidden'])
		? trim((string) $_POST['message_hidden'])
		: '';

	$messageRaw = $messageHidden !== ''
		? $messageHidden
		: $message;

	/*
	 * Validate dữ liệu.
	 */
	if (
		$table_id <= 0
		|| !in_array($type, $allowedTypes, true)
	) {
		echo '_ERROR - Invalid review target';
		exit;
	}

	if ($rates < 1 || $rates > 5) {
		echo '_ERROR - Invalid rating';
		exit;
	}

	if ($fullname === '') {
		echo '_ERROR - Full name is required';
		exit;
	}

	if (
		$email === ''
		|| !filter_var($email, FILTER_VALIDATE_EMAIL)
	) {
		echo '_ERROR - Invalid email';
		exit;
	}

	if ($messageRaw === '') {
		echo '_ERROR - Message is required';
		exit;
	}

	/*
	 * Chống stored XSS nhưng vẫn giữ xuống dòng.
	 */
	$messageContent = nl2br(
		htmlspecialchars(
			$messageRaw,
			ENT_QUOTES,
			'UTF-8'
		)
	);

	$ip_user = isset($_SERVER['REMOTE_ADDR'])
		? trim((string) $_SERVER['REMOTE_ADDR'])
		: '';

	/*
	 * Escape vì insertOne đang nhận chuỗi SQL thủ công.
	 */
	$typeSql = addslashes($type);
	$fullnameSql = addslashes($fullname);
	$emailSql = addslashes($email);
	$messageSql = addslashes($messageContent);
	$phoneSql = addslashes($phone);
	$ipSql = addslashes($ip_user);

	$reviews_id = (int) $clsReviews->getMaxId();
	$order_no = (int) $clsReviews->getMaxOrderNo();
	$currentTime = time();

	/*
	 * Bắt buộc có profile_id=0 và is_online=1
	 * để các function NoLogin lấy được review.
	 */
	$fields = "
		reviews_id,
		reg_date,
		review_date,
		upd_date,
		table_id,
		type,
		rates,
		fullname,
		email,
		country_id,
		content,
		order_no,
		profile_id,
		is_trash,
		is_online,
		user_id,
		phone
	";

	$values = "
		'{$reviews_id}',
		'{$currentTime}',
		'{$currentTime}',
		'{$currentTime}',
		'{$table_id}',
		'{$typeSql}',
		'{$rates}',
		'{$fullnameSql}',
		'{$emailSql}',
		'{$country_id}',
		'{$messageSql}',
		'{$order_no}',
		'0',
		'0',
		'1',
		'{$ipSql}',
		'{$phoneSql}'
	";

	if (!$clsReviews->insertOne($fields, $values)) {
		echo '_ERROR - Cannot insert review';
		exit;
	}

	/*
	 * Upload ảnh nếu form có gửi review_images[].
	 */
	if (
		isset($_FILES['review_images'])
		&& isset($_FILES['review_images']['name'])
		&& is_array($_FILES['review_images']['name'])
	) {
		$clsUploadFile = new UploadFile();

		$username = '';

		if (!empty($profile_id)) {
			$username = $clsProfile->getUsername(
				(int) $profile_id
			);
		}

		$username = str_replace(
			array('@', '/', '\\'),
			'',
			(string) $username
		);

		if ($username === '') {
			$username = 'guest_reviews';
		}

		$datastore_folder = '/datastore/' . $username;
		$totalFiles = count(
			$_FILES['review_images']['name']
		);

		for ($i = 0; $i < $totalFiles; $i++) {
			$fileName = isset(
				$_FILES['review_images']['name'][$i]
			)
				? $_FILES['review_images']['name'][$i]
				: '';

			$tmpName = isset(
				$_FILES['review_images']['tmp_name'][$i]
			)
				? $_FILES['review_images']['tmp_name'][$i]
				: '';

			$fileError = isset(
				$_FILES['review_images']['error'][$i]
			)
				? (int) $_FILES['review_images']['error'][$i]
				: UPLOAD_ERR_NO_FILE;

			if (
				$fileName === ''
				|| $fileError !== UPLOAD_ERR_OK
				|| !is_uploaded_file($tmpName)
			) {
				continue;
			}

			$file = array(
				'name' => $fileName,
				'type' => isset(
					$_FILES['review_images']['type'][$i]
				)
					? $_FILES['review_images']['type'][$i]
					: '',
				'tmp_name' => $tmpName,
				'error' => $fileError,
				'size' => isset(
					$_FILES['review_images']['size'][$i]
				)
					? (int) $_FILES['review_images']['size'][$i]
					: 0
			);

			$image = $clsUploadFile->uploadItem(
				$file,
				$datastore_folder,
				'jpg,jpeg,gif,png,bmp,tiff,webp'
			);

			if ($image === '0' || $image === '') {
				continue;
			}

			$imageSql = addslashes($image);
			$image_id = (int) $clsImage->getMaxId();
			$imageOrder = (int) $clsImage->getMaxOrderNo(
				$reviews_id,
				'_REVIEW'
			);

			$imageFields = "
				image_id,
				table_id,
				type,
				image,
				order_no,
				reg_date
			";

			$imageValues = "
				'{$image_id}',
				'{$reviews_id}',
				'_REVIEW',
				'{$imageSql}',
				'{$imageOrder}',
				'{$currentTime}'
			";

			$clsImage->insertOne(
				$imageFields,
				$imageValues
			);
		}
	}

	/*
	 * Gửi mail là tác vụ phụ.
	 * Không trả _ERROR khi review đã lưu thành công
	 * nhưng mail gửi thất bại.
	 */
	try {
		$clsReviews->sendMail(
			$email,
			$reviews_id,
			$type,
			$messageContent
		);
	} catch (Throwable $exception) {
		error_log(
			'Review mail error: '
			. $exception->getMessage()
		);
	}

	echo '_SUCCESS - ' . $reviews_id;
	exit;
}
function default_ajLoadMoreBlog()
{
	global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $cat_id, $profile_id, $lang_sql;;

	$clsBlog = new Blog();
	$smarty->assign('clsBlog', $clsBlog);
	$cond = "is_trash=0 and is_approve=1 and is_online=1 ";
	$orderby = " ORDER BY order_no ASC";
	$recordPerPage = 4;

	$currentPage = isset($_POST['pageBlog']) ? intval($_POST['pageBlog']) : 1;
	$assign_list["numberPage"] = $currentPage;
	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	$lstTopBlog = $clsBlog->getAll($cond . $orderby . $limit);

	$assign_list["lstTopBlog"] = $lstTopBlog;
	$html = $core->build('load_more_blog.tpl');
	echo $html;
	die;
}
function default_ajLoadMoreTopTourPromotion()
{
	global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $cat_id, $profile_id, $lang_sql, $deviceType;

	$clsTourCategory  = new TourCategory();
	$assign_list['clsTourCategory'] = $clsTourCategory;
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$clsPromotion = new Promotion();
	$assign_list['clsPromotion'] = $clsPromotion;
	$clsReviews = new Reviews();
	$assign_list['clsReviews'] = $clsReviews;
	$clsTourStore = new TourStore();
	$assign_list['clsTourStore'] = $clsTourStore;
	$clsPromotion = new Promotion();
	$smarty->assign('clsPromotion', $clsPromotion);
	$clsPromotionItem = new PromotionItem();
	$smarty->assign('clsPromotionItem', $clsPromotionItem);
	$clsProfile = new Profile();
	$cond = "is_online=1 and clsTable='Tour' and target_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 ) and " . time() . " between  start_date and end_date";
	if (_ISOCMS_CLIENT_LOGIN) {
		$cond1 = "SELECT pi.taget_id FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1 ";
		$loggedIn = $clsProfile->isLoggedIn();
		if ($loggedIn == 1) {
			$cond1 .= "";
		} else {
			$cond1 .= " and p.check_mem_set = 0";
		}
		$cond1 .= " and p.type = 'Tour' and pi.taget_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 and lang_id='$lang_sql') and " . time() . " between  p.start_date and p.end_date ";
	} else {
		$cond1 = "SELECT pi.taget_id FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and pi.is_online = 1  and p.type = 'Tour' and pi.taget_id in (SELECT default_tour.tour_id FROM default_tour WHERE is_trash = 0 and is_online = 1 and lang_id='$lang_sql') and " . time() . " between  p.start_date and p.end_date ";
	}

	$orderby = " ORDER BY p.end_date ASC";
	if ($deviceType == 'phone') {
		$recordPerPage = 2;
	} else {
		$recordPerPage = 8;
	}
	$currentPage = isset($_POST['page']) ? $_POST['page'] : 1;
	$assign_list["numberPage"] = $currentPage;
	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	$listTopTourPromotion = $dbconn->GetAll($cond1 . $orderby . $limit);
	$assign_list["listTopTourPromotion"] = $listTopTourPromotion;
	$html = $core->build('load_more_top_tour_promotion.tpl');
	echo $html;
	die;
}
function default_ajLoadMoreTopTourHomePage()
{
	global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $cat_id, $profile_id, $deviceType;

	$clsTourStore = new TourStore();
	$smarty->assign("clsTourStore", $clsTourStore);
	$clsTour = new Tour();
	$smarty->assign("clsTour", $clsTour);
	$clsPagination = new Pagination();
	$smarty->assign('clsPagination', $clsPagination);
	$clsReviews = new Reviews();
	$smarty->assign('clsReviews', $clsReviews);

	$width = isset($_POST['width']) ? intval($_POST['width']) : 0;

	$cond = "is_trash=0 and _type='TOPTOUR' and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1)";
	$orderby = " order by order_no ASC";
	if ($deviceType == 'phone') {
		$recordPerPage = 2;
	} else {
		if ($_LANG_ID == 'vn') {
			$recordPerPage = 12;
		} else {
			$recordPerPage = 6;
		}
	}

	$currentPage = isset($_POST['page']) ? intval($_POST['page']) : 1;

	$totalRecord = $clsTourStore->getAll($cond, $clsTourStore->pkey);
	$totalRecord = $totalRecord ? count($totalRecord) : 0;
	$smarty->assign('totalRecord', $totalRecord);
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);

	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";

	$listTopTour = $clsTourStore->getAll($cond . $orderby . $limit, $clsTour->pkey);
	$assign_list["listTopTour"] = $listTopTour;
	if ($_LANG_ID == 'vn') {
		$html = $core->build('load_more_top_tour.tpl');
	} else {
		$html = $core->build('load_more_top_tour_home_page.tpl');
	}
	echo $html;
	die;
}
function default_ajLoadMoreTourCategory()
{
	global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $cat_id, $profile_id, $deviceType;

	$clsTourCategory = new TourCategory();
	$smarty->assign("clsTourCategory", $clsTourCategory);
	$clsPagination = new Pagination();
	$smarty->assign('clsPagination', $clsPagination);


	$cond = "is_trash=0 and is_online=1 and parent_id=0";
	$orderby = " order by order_no ASC";
	$recordPerPage = 5;

	$currentPage = isset($_POST['page']) ? intval($_POST['page']) : 1;

	$totalRecord = $clsTourCategory->getAll($cond, $clsTourCategory->pkey);
	$totalRecord = $totalRecord ? count($totalRecord) : 0;
	$smarty->assign('totalRecord', $totalRecord);
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);

	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";

	$lstCatTour = $clsTourCategory->getAll($cond . $orderby . $limit, $clsTourCategory->pkey . ",title,slug,image");
	$assign_list["lstCatTour"] = $lstCatTour;

	$html = $core->build('load_more_tour_cat_home_page.tpl');
	echo $html;
	die;
}
function default_check_open_email()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
	$clsISO = new ISO();
	$clsFeedback = new Feedback();
	#
	$feedback_id = isset($_GET['feedback_id']) ? intval($_GET['feedback_id']) : 0;

	$clsFeedback->updateOne($feedback_id, "is_open_mail=1");
	exit;
}
function default_ajCheckPromotionPro()
{
	global $core, $dbconn, $profile_id, $_LANG_ID, $clsISO;
	#
	header('Content-type: application/json;');
	$clsPromotion = new Promotion();
	$clsPromotionItem = new PromotionItem();
	$voucher = isset($_POST['voucher']) ? $_POST['voucher'] : '';
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	$results = array('result' => 'error');
	$check_pro = $clsPromotion->getCheckPromotionCode($voucher, $type);
	if ($check_pro >= 1) {
		$getAll_by_code = $clsPromotion->getAll("is_online = 1 and promotion_code ='" . $voucher . "' and `type`='" . $type . "'", $clsPromotion->pkey . ",promot");
		$html = '';
		$html .= '<div class="line"><label>' . $core->get_Lang("Promotion") . ' (' . $getAll_by_code[0]['promot'] . '%)</label><input type="hidden" name="promotion" id="promotion" value="' . $getAll_by_code[0]['promot'] . '" /><input type="hidden" name="price_promotion" id="price_promotion_post" value="0" />';
		if ($_LANG_ID == "vn") {
			$html .= '<span class="right"><span id="price_promotion">1000</span>' . $clsISO->getShortRate() . '</span>';
		} else {
			$html .= '<span class="right">' . $clsISO->getShortRate() . '<span id="price_promotion">1000</span></span>';
		}
		$html .= '</div><script>var promotion_check="' . $getAll_by_code[0]['promot'] . '"</script>';
		$results = array('result' => 'success', 'verify' => $html);
	} else {
		$results = array('result' => 'error');
	}

	echo json_encode($results);
	exit();
}
function default_ajSendRegAdvisory()
{
	global $core, $dbconn, $profile_id, $_LANG_ID, $clsISO;
	#
	header('Content-type: application/json;');

	$clsFeedback = new Feedback();
	$assign_list['clsFeedback'] = $clsFeedback;

	$results = array('result' => 'error');

	if ($_POST) {
		$clsFeedback->newRegAdvisory($_POST);
		$results = array('result' => 'success');
	} else {
		$results = array('result' => 'error');
	}

	echo json_encode($results);
	die();
}
function default_test_php()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $clsISO;
	#
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list['show'] = $show;

	$url_test_1 = "http://bacgiangtourism.vn/vi/business";
	$xml_test_1 = file_get_contents($url_test_1);


	$data_test_1 = simplexml_load_string($xml_test_1);
	print_r($xml_test_1);
	die();
	$html = '';
	$i = 1;
	foreach ($data_test_1->channel->item as $tin_tuc) {
		$html .= '<article class="d-flex">
			<a class="thumbblock thumb275x155" href="' . $tin_tuc->link . '"><img src="' . $tin_tuc->image . '"></a>
		  	<div class="desc_list_news_home"> <a href="' . $tin_tuc->link . '" class="fs22 fbold">' . $tin_tuc->title . ' </a>
			<div class="mt5 mb5"><a href="https://baodautu.vn/thoi-su-d1/" class="cl_green">Thời sự</a></div>
			<div class="sapo_thumb_news">' . $tin_tuc->description . '</div>
		  </div>
		</article>';
	}
	$assign_list["html"] = $html;

	print_r($html);
	die();
	if (1 == 2) {
		echo $html;
		die();


		$url_test = "https://vnexpress.net/rss/tin-moi-nhat.rss";
		$xml_test = file_get_contents($url_test);
		$data_test = simplexml_load_string($xml_test);

		$html = '';
		$i = 1;
		foreach ($data_test->channel->item as $tin_tuc) {
			echo $tin_tuc->title . '</br>';
		}
	}
}
function default_demo_api()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	global $clsConfiguration;
	$clsSlide = new Slide();
	$assign_list['clsSlide'] = $clsSlide;
	$clsProduct = new Product();
	$assign_list["clsProduct"] = $clsProduct;
	$clsCategory = new Category();
	$assign_list['clsCategory'] = $clsCategory;



	$clsTHPSDK = new THPSDK();
	$assign_list['clsTHPSDK'] = $clsTHPSDK;
	#
	#donvitinh
	$donvitinh = $clsTHPSDK->get('http://pos.tssoftonline.com:88/testthienhongphat/openapi/v1/danhsach/donvitinh?user=admin&password=123321');



	$param = array(
		'columns' => array('GIABAN', 'NAME', 'DNHOMMATHANGID', 'GIABAN'),

		'quick_filter' => '',
		'user' => 'Admin',
		'password' => '123321',
		'page_size' => 10,
		'page_index' => 1,
		'sort_column' => 'NAME',
		'sort_direction' => 'DESC'
	);

	#mathang
	$mathang = $clsTHPSDK->get('http://pos.tssoftonline.com:88/testthienhongphat/openapi/v1/danhsach/mathang?user=admin&password=123321', $param);
	print_r($mathang);
	die();

	$clsVietISOSDK = new VietISOSDK(array('url' => 'http://pos.tssoftonline.com:88/testthienhongphat/openapi/v1/', 'version' => 'v1'));
	$response = $clsVietISOSDK->doInBackground('GET', '/laythongtinapi/mathang', $param);
	$response_availability = json_decode($response, true);

	print_r($response_availability);
	die();
	$onemathang = $clsTHPSDK->get('http://pos.tssoftonline.com:88/testthienhongphat/openapi/v1/laythongtinapi/mathang?user=admin&password=123321&id=be21abda-3fab-4e32-8f4c-2ecc2e44b09a');
	print_r($onemathang);
	die();

	$param = array(
		'columns' => array('NAME', 'CODE', 'DIACHI'),
		'quick_filter' => '',
		'page_size' => 10,
		'page_index' => 1,
		'sort_column' => 'NAME',
		'sort_direction' => 'DESC'
	);

	#khachhang
	$khachhang = $clsTHPSDK->get('http://pos.tssoftonline.com:88/testthienhongphat/openapi/v1/danhsach/khachhang?user=admin&password=123321', json_encode($param));
	print_r($khachhang);
	die('xxx');



	print_r($onemathang);
	die();


	/*=============Title & Description Page==================*/
	$title_page = $clsConfiguration->getValue('meta_title');
	$assign_list["title_page"] = $title_page;
	$description_page = $clsConfiguration->getValue('meta_description');
	$assign_list["description_page"] = $description_page;
	$keyword_page = $clsConfiguration->getValue('meta_keyword');
	$assign_list["keyword_page"] = $keyword_page;
}

function default_home_new()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $package_id;
	global $clsConfiguration;

	//   List Slide
	$clsSlide = new Slide();
	$assign_list['clsSlide'] = $clsSlide;
	$listSlide = $clsSlide->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsSlide->pkey . ',title,text,image,link');
	$assign_list['listSlide'] = $listSlide;

	//   List Ads
	$clsAds = new Ads();
	$assign_list['clsAds'] = $clsAds;
	$listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
	$assign_list['listAdsHome'] = $listAdsHome;

	//    List Discount
	$clsDiscount = new Discount();
	$assign_list['clsDiscount'] = $clsDiscount;
	$lstDiscount = $clsDiscount->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsDiscount->pkey . "code, title, more_information");
	$assign_list['listDiscount'] = $lstDiscount;

	//    Why
	$clsWhy = new Why();
	$assign_list['clsWhy'] = $clsWhy;
	$listWhyHome = $clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC", $clsWhy->pkey);
	$assign_list['listWhyHome'] = $listWhyHome;
	unset($listWhyHome);

	//    List Testimonial
	$clsTestimonial = new Testimonial();
	$assign_list['clsTestimonial'] = $clsTestimonial;
	$lstTestimonial = $clsTestimonial->getAll("is_trash=0 and is_online = 1 and image<>'' order by order_no ASC limit 0,9", $clsTestimonial->pkey . ",title,reg_date,slug,intro,name,rates");
	$assign_list['lstTestimonial'] = $lstTestimonial;
	unset($lstTestimonial);

	//    List TopTour
	$clsTourStore = new TourStore();
	$assign_list['clsTourStore'] = $clsTourStore;
	$clsTour = new Tour();
	$assign_list['clsTour'] = $clsTour;
	$clsReviews = new Reviews();
	$assign_list['clsReviews'] = $clsReviews;
	$cond = "is_trash=0 and _type='TOPTOUR' and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1)";
	$orderby = " order by order_no ASC LIMIT 6";
	$listTopTour = $clsTourStore->getAll($cond . $orderby, $clsTour->pkey);
	$assign_list['listTopTour'] = $listTopTour;
	unset($listTopTour);

	//  List Top Blog
	if ($clsISO->getCheckActiveModulePackage($package_id, 'blog', 'default', 'default')) {
		$clsBlog = new Blog();
		$assign_list['clsBlog'] = $clsBlog;
		$cond = "is_trash=0 and is_approve=1 and is_online=1 ";
		$limit = " LIMIT 0,4";
		$orderby = "order by order_no ASC";
		$lstTopBlog = $clsBlog->getAll($cond . $orderby . $limit, $clsBlog->pkey . ',title,slug,image,intro,publish_date');
		$assign_list['lstTopBlog'] = $lstTopBlog;
		unset($lstTopBlog);
	}
}

function default_ajGetSubs_totalSe()
{
	global $clsISO;
	$a_se_subs = rand(1, 9);
	$b_se_subs = rand(1, 9);
	$subs_totalSe = $a_se_subs + $b_se_subs;
	vnSessionSetVar("subs_totalSe", $subs_totalSe);
	$subs_uid = $clsISO->getUniqid();
	vnSessionSetVar("subs_uid", $subs_uid);
	echo json_encode(array(
		"a_se_subs"	=> $a_se_subs,
		"b_se_subs"	=> $b_se_subs,
		"subs_totalSe"	=> $subs_totalSe,
		"subs_uid"	=> $subs_uid,
	));
	die;
}

function default_ajGetSubs_totalSeNew()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
	#
	if (!$clsISO->checkGoogleReCAPTCHA()) {
		$data = array(
			"result" => false,
			"msg" => $core->get_Lang('Secure code not match'),
		);
	} else {
		$a_se_subs = rand(1, 9);
		$b_se_subs = rand(1, 9);
		$csrf_token = bin2hex(random_bytes(32));
		vnSessionSetVar("csrf_token", $csrf_token);
		vnSessionSetVar("iso_recaptcha", $_POST['g-recaptcha-response']);
		$data = array(
			"result" => true,
			"a_se_subs" => $a_se_subs,
			"b_se_subs" => $b_se_subs,
			"csrf_token" => $csrf_token,
		);
	}
	echo json_encode($data);
	die;
}

function default_ajLoadReviews()
{
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL & ~E_STRICT);
	global $clsISO, $core, $_LANG_ID;
	#
	$clsReviews = new Reviews();
	$clsImage = new Image();
	$clsCountry = new _Country();
	#
	$type = !empty($_POST['type']) ? $_POST['type'] : '';
	$table_id = !empty($_POST['table_id']) ? $_POST['table_id'] : 0;
	$txt_rates = !empty($_POST['txt_rates']) ? $_POST['txt_rates'] : '';
	$txt_rates = ltrim($txt_rates, ',');
	#
	$dataResponse = array(
		"result" => false,
	);
	#Danh sach reviews cua tour/cruise/hotel
	$page = !empty($_POST['page']) ? $_POST['page'] : 1;
	$record = 5;
	$start = ($page - 1) * $record;
	$cond = 'is_trash=0 AND is_online=1 AND type="' . $type . '" AND table_id="' . $table_id . '"';
	$limit = " LIMIT $start, $record ";
	$order_by = " ORDER BY order_no DESC ";
	if ($txt_rates != '') {
		$cond .= " AND rates IN ($txt_rates) ";
	}
	#
	$allReviews = $clsReviews->getAll($cond, $clsReviews->pkey);
	$totalReviews = $allReviews ? count($allReviews) : 0;
	$allPage = $totalReviews / $record;
	#
	$view_more = false;
	if ($allPage > $page) {
		$view_more = true;
	}
	#
	$lstReviews = $clsReviews->getAll($cond . $order_by . $limit, $clsReviews->pkey . ', country_id, rates, title, fullname, content, review_date');

	if ($lstReviews) {
		foreach ($lstReviews as $key => $item) {
			//Format Date 
			$review_date = $clsISO->formatDate($item['review_date']);
			$lstReviews[$key]['review_date'] = $review_date;
			//Add tren country
			$title_country = $clsCountry->getTitle($item['country_id']);
			$lstReviews[$key]['title_country'] = $title_country;
			//lay danh sach Image
			$condImages = " type='_REVIEW' AND table_id = '" . $item[$clsReviews->pkey] . "' ORDER BY order_no DESC";
			$lstImages = $clsImage->getAll($condImages, 'image');
			$lstReviews[$key]['lstImages'] = $lstImages;
			// Lay ma mau random show avatar
			$review_avatar_background = $clsISO->random_color();
			$lstReviews[$key]['review_avatar_background'] = $review_avatar_background;
		}
		$dataResponse = array(
			'result' => true,
			'lstReviews' => $lstReviews,
			'view_more' => $view_more,
		);
	}
	die(json_encode($dataResponse));
}

function default_ajStatisticalReviews()
{
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', '1');
	// error_reporting(E_ALL & ~E_STRICT);
	global $clsISO, $core;
	#
	$clsReviews = new Reviews();
	$type = !empty($_POST['type']) ? $_POST['type'] : '';
	$table_id = !empty($_POST['table_id']) ? $_POST['table_id'] : 0;
	$txt_rates = !empty($_POST['txt_rates']) ? $_POST['txt_rates'] : '';
	$txt_rates = ltrim($txt_rates, ',');

	#Danh sach reviews cua tour/cruise/hotel
	$cond = 'is_trash=0 AND is_online=1 AND type="' . $type . '" AND table_id="' . $table_id . '"';
	$Reviews = $clsReviews->getByCond($cond, 'COUNT(table_id) as count_table');
	$countReviews = !empty($Reviews['count_table']) ? $Reviews['count_table'] : 1;

	$cond = 'is_trash=0 AND is_online=1 AND type="' . $type . '" AND table_id="' . $table_id . '"';
	$Reviews = $clsReviews->getByCond($cond, 'COUNT(table_id) as count_table');
	$countReviews = !empty($Reviews['count_table']) ? $Reviews['count_table'] : 1;

	$count = $rates = array();
	for ($i = 1; $i <= 5; $i++) {
		$countReview = $clsReviews->getByCond($cond . "AND rates='$i'", 'COUNT(rates) as count_rates');
		$rateReview = $countReview['count_rates'] / $countReviews * 100;
		$rates['rates_' . $i] = $rateReview;
		$count['count_' . $i] = $countReview['count_rates'];
	}

	$data = array(
		'rates' => $rates,
		'count' => $count,
	);

	die(json_encode($data));
}

function default_ajai_test2025()
{
	global $clsISO, $core, $assign_list;
	$clsProfile = new Profile();
	if (isset($_SESSION['profile_id'])) {
		$agency = $_SESSION['profile_id'];
	}
	$agency = '';
	$assign_list["profile_id"] = $agency;
	$oneProfile = $clsProfile->getOne($agency);
	$assign_list["oneProfile"] = $oneProfile;

	// Hàm để phân tích robots.txt và lấy sitemap URL
	function parseRobotsTxt($robotsTxtUrl)
	{
		$robotsTxt = @file_get_contents($robotsTxtUrl);
		if ($robotsTxt === false) {
			return ["disallowed" => [], "sitemap" => null];
		}

		$disallowed = [];
		$sitemap = null;
		$lines = explode("\n", $robotsTxt);
		foreach ($lines as $line) {
			$line = trim($line);
			if (strpos($line, 'Disallow:') === 0) {
				$path = trim(substr($line, strlen('Disallow:')));
				$disallowed[] = $path;
			} elseif (strpos($line, 'Sitemap:') === 0) {
				$sitemap = trim(substr($line, strlen('Sitemap:')));
			}
		}
		return ["disallowed" => $disallowed, "sitemap" => $sitemap];
	}


	// Hàm kiểm tra xem URL có bị chặn bởi robots.txt hay không
	function isUrlAllowed($url, $disallowedPaths)
	{
		$path = parse_url($url, PHP_URL_PATH);
		foreach ($disallowedPaths as $disallowedPath) {
			if (strpos($path, $disallowedPath) === 0) {
				return false; // URL bị chặn
			}
		}
		return true; // URL được phép
	}

	// Hàm thu thập nội dung từ URL
	function getTextFromUrl($url, $disallowedPaths)
	{
		if (!isUrlAllowed($url, $disallowedPaths)) {
			return ""; // Bỏ qua nếu URL bị chặn
		}

		global $clsISO, $core, $assign_list, $lang_sql;

		$clsTour = new Tour();
		$assign_list['clsTour'] = $clsTour;
		$html = @file_get_contents($url);
		if ($html === false) {
			return "";
		}

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

		$finder = new DomXPath($dom);
		$classname = "$clsTour";
		$nodes = $finder->query("//*[contains(@class, '$classname')]");

		$content = "";
		foreach ($nodes as $node) {
			$content .= $node->nodeValue . "\n";
		}

		return trim($content);
	}

	// Hàm phân tích sitemap.xml và lấy danh sách URL
	function parseSitemap($sitemapUrl)
	{
		$xml = @simplexml_load_file($sitemapUrl);
		if ($xml === false) {
			return [];
		}

		$urls = [];
		foreach ($xml->url as $url) {
			$urls[] = (string) $url->loc;
		}
		return $urls;
	}

	// Hàm tìm kiếm trong sitemap
	function performInternalSearch($query, $sitemapUrls)
	{
		$results = [];
		foreach ($sitemapUrls as $url) {
			if (strpos($url, $query) !== false) {
				$results[] = ["title" => $url, "slug" => $url];
			}
		}
		return $results;
	}

	// Hàm trích xuất nội dung từ kết quả tìm kiếm (đã sửa đổi)
	function extractContentFromSearchResults($searchResults, $disallowedPaths)
	{
		$context = "";
		foreach ($searchResults as $result) {
			$context .= "Tiêu đề: " . $result["title"] . "\n";
			$context .= "URL: " . $result["slug"] . "\n";

			$content = getTextFromUrl($result["slug"], $disallowedPaths);
			if ($content) {
				$context .= "Nội dung: " . $content . "\n";
			}

			$context .= "\n";
		}
		return $context;
	}


	$apiKey = 'AIzaSyBSELu4QagSy7pKL-pSDcqf_X15-9NqvEI'; // Thay thế bằng API key của bạn
	$model = 'gemini-2.0-flash-thinking-exp'; // Chọn model gemini-2.0-flash
	$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$input = json_decode(file_get_contents('php://input'), true);
		$userMessage = $input['message'];

		// Phân tích robots.txt
		$robotsTxtUrl = "https://isocms.com/robots.txt";
		$robotsData = parseRobotsTxt($robotsTxtUrl);
		$disallowedPaths = $robotsData["disallowed"];
		$sitemapUrl = $robotsData["sitemap"];

		// Phân tích sitemap.xml
		$sitemapUrls = parseSitemap($sitemapUrl);

		// Tìm kiếm trong sitemap
		$searchResults = performInternalSearch($userMessage, $sitemapUrls);

		// Trích xuất nội dung
		$context = extractContentFromSearchResults($searchResults, $disallowedPaths);

		$prompt = "Dựa trên thông tin sau từ website isocms.com:\n\n" . $context . "\n\nTrả lời câu hỏi sau: " . $userMessage;


		$data = [
			'contents' => [
				[
					'parts' => [
						['text' => $prompt],
					],
				],
			],
		];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

		$response = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);


		if ($response === false) {
			$error = error_get_last();
			error_log("Gemini API Error: " . print_r($error, true));
			http_response_code(500);
			echo json_encode(['error' => 'Failed to connect to Gemini API', 'details' => $error]); //Thêm chi tiết lỗi.
		} else {
			error_log("Gemini API Response: " . $response);
			echo $response;
		}
	}
}
