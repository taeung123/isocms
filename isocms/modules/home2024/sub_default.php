<?php
require_once(DIR_INCLUDES.'/isoman/php/index.php');

function default_home_new() {
    global $assign_list,$_CONFIG,$core,$dbconn,$mod,$act,$_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO,$package_id;
    global $clsConfiguration, $lang_sql;

//   List Slide
    $clsSlide= new Slide();
    $assign_list['clsSlide'] = $clsSlide;

    $listSlide = $clsSlide->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsSlide->pkey.',title,text,image,link');
    $assign_list['listSlide'] = $listSlide;


//   List Ads
    $clsAds = new Ads();$assign_list['clsAds']=$clsAds;
    $listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
    $assign_list['listAdsHome']=$listAdsHome;

//    List Discount
    $clsDiscount = new Discount();
    $assign_list['clsDiscount']=$clsDiscount;

    $lstDiscount = $clsDiscount->getAll("is_trash=0 and is_online=1 order by order_no ASC", $clsDiscount->pkey."code, title, more_information");
    $assign_list['listDiscount']=$lstDiscount;

//    Why
    $clsWhy=new Why(); $assign_list['clsWhy'] = $clsWhy;
    $listWhyHome=$clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC",$clsWhy->pkey);
    $assign_list['listWhyHome'] = $listWhyHome;
    unset($listWhyHome);


    
//  List Top Blog
    if($clsISO->getCheckActiveModulePackage($package_id,'blog','default','default')){
        $clsBlog= new Blog();
        $assign_list['clsBlog'] = $clsBlog;

        $cond="is_trash=0 and is_approve=1 and is_online=1 ";
        $limit = " LIMIT 0,4";
        $orderby="order by order_no ASC";

        $lstTopBlog = $clsBlog->getAll($cond.$orderby.$limit,$clsBlog->pkey.',title,slug,image,intro,publish_date');
        $assign_list['lstTopBlog'] = $lstTopBlog;
        unset($lstTopBlog);
    }

//    Top Travel Styles
    $clsTourCategory = new TourCategory();
    $assign_list['clsTourCategory'] = $clsTourCategory;
    $clsPagination=new Pagination();
    $assign_list['clsPagination'] = $clsPagination;

    $cond="is_trash=0 and is_online=1 and parent_id=0";
    $orderby=" order by order_no ASC";
    $lstCatTour = $clsTourCategory->getAll($cond.$orderby, $clsTourCategory->pkey.",title,slug,image");
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
    $listHotel = $clsHotel->getAll($cond.$order_by.$limit,$clsHotel->pkey.",title,intro,image,address,slug");
    $assign_list['listHotel'] = $listHotel;
    unset($listHotel);

    //List Top Cruise
    $clsCruise = new Cruise();
    $assign_list['clsCruise'] = $clsCruise;
    $listCruise = $clsCruise->getAll($cond.$order_by.$limit,$clsCruise->pkey.",title,about,image");
    $assign_list["listCruise"] = $listCruise;
    unset($listCruise);

    //List Top Destination
    $clsCityStore = new CityStore();
    $assign_list['clsCityStore'] = $clsCityStore;
    $cond_top = "is_trash=0 and type='TOP'";
    if(isset($_GET['slug_country']) && !empty($_GET['slug_country'])) {
        $slug_country = $_GET['slug_country'];
        $country_id = $clsCountryEx->getBySlug($slug_country);
        $cond.= " and country_id = '$country_id'";
    }

    $sql_top_city="SELECT ".DB_PREFIX."city.city_id,".DB_PREFIX."city.title,".DB_PREFIX."city.slug,".DB_PREFIX."city.image,".DB_PREFIX."city.country_id FROM ".DB_PREFIX."city INNER JOIN ".DB_PREFIX."citystore ON ".DB_PREFIX."city.city_id = ".DB_PREFIX."citystore.city_id AND ".DB_PREFIX."citystore.type='TOP' AND ".DB_PREFIX."citystore.lang_id='$lang_sql' ORDER BY
         ".DB_PREFIX."city.title ASC";

    $listTopDestination=$dbconn->getAll($sql_top_city);
    $assign_list['listTopDestination'] = $listTopDestination;
    unset($listTopDestination);



    /*=============Title & Description Page==================*/
    $title_page = $clsConfiguration->getValue('SiteMetaTitle');
    $assign_list["title_page"] = $title_page;
    $description_page =$clsConfiguration->getValue('SiteMetaDescription');;
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page =$clsConfiguration->getValue('ImageShareSocial');
    $assign_list["global_image_seo_page"] = $global_image_seo_page;


}
function default_default(){
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$clsConfiguration;
    ini_set('display_errors',1);
    error_reporting(E_ERROR & ~E_STRICT);//E_ALL
    #
    $clsTour=new Tour(); $assign_list['clsTour']=$clsTour;
    $clsTourCategory = new TourCategory(); $assign_list['clsTourCategory']=$clsTourCategory;
    $clsTestimonial=new Testimonial(); $assign_list['clsTestimonial']=$clsTestimonial;
    $clsCity=new City(); $assign_list['clsCity']=$clsCity;
    $clsCountry=new Country(); $assign_list['clsCountry']=$clsCountry;
    $clsProperty = new Property();$assign_list["clsProperty"] = $clsProperty;
    $clsAds = new Ads();$assign_list['clsAds']=$clsAds;
    $clsSlide = new Slide();$assign_list['clsSlide']=$clsSlide;
    $clsReviews=new Reviews(); $assign_list['clsReviews']=$clsReviews;
    $clsWhy=new Why(); $assign_list['clsWhy'] = $clsWhy;
    #

    #ads
    $listAdsHome = $clsAds->getAll("is_trash=0 and is_online=1 order by order_no ASC limit 0,5", $clsAds->pkey);
    $assign_list['listAdsHome']=$listAdsHome;
    #whywith_us
    $listWhyHome=$clsWhy->getAll("is_trash=0 and is_online=1 and type='HOME' order by order_no ASC",$clsWhy->pkey);
    $assign_list['listWhyHome'] = $listWhyHome;
    unset($listWhyHome);

    /*=============Title & Description Page==================*/
    $title_page = $clsConfiguration->getValue('SiteMetaTitle');
    $assign_list["title_page"] = $title_page;
    $description_page =$clsConfiguration->getValue('SiteMetaDescription');;
    $assign_list["description_page"] = $description_page;
    $global_image_seo_page =$clsConfiguration->getValue('ImageShareSocial');
    $assign_list["global_image_seo_page"] = $global_image_seo_page;
    /*=============Content Page==================*/
    unset($clsTour);

}

function default_set_cookie(){
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
    $clsCustomer = new Customer();
    $customer_str= isset($_GET['customer_id']) ? ($_GET['customer_id']) : '';
    $customer_id= intval($core->decryptID($customer_str));

    //print_r($customer_id); die();

    $is_online=$clsCustomer->getOneField('is_online',$customer_id);
    $package_id=$clsCustomer->getOneField('package_id',$customer_id);

    $expired_date=$clsCustomer->getOneField('expired_date',$customer_id);
    $customer_demo =$_COOKIE["customer_demo_isocms"];


    if($expired_date < time() || $is_online==0){
        if($is_online==0){
            setcookie("customer_demo_isocms","demo_isocms",time() - 100,"/");
            print_r("Bạn không được cấp quyền truy cập vào website này");die();
        }else{
            print_r("Bạn không được cấp quyền truy cập vào website này");die();
        }
    }else{
        if($package_id==1){
            setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/");
            header('location:https://essentials.isocms.com');
            exit();
        }elseif($package_id==2){

            setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/");
            header('location:https://professional.isocms.com');
            exit();
        }elseif($package_id==3){
            setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/");
            header('location:https://premium.isocms.com');
            exit();
        }elseif($package_id==4){
            setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/");
            header('location:https://isocms.com');
            exit();
        }else{
            header('location:http://isocms.net');
            exit();
        }


        setcookie("customer_demo_isocms","demo_isocms", $expired_date,"/");
        header('Location: '.DOMAIN_NAME);
        exit();
    }
}
function default_set_cookie2(){

    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;

    $package_str= isset($_GET['sid']) ? ($_GET['sid']) : '';
    $package_id= intval($core->decryptID($package_str));
    if($package_id==5){
        $package_id=1;
    }
    if($package_id==6){
        $package_id=2;
    }
    if($package_id==7){
        $package_id=3;
    }
    if($package_id==8){
        $package_id=4;
    }

    $enip_str= isset($_GET['enip']) ? ($_GET['enip']) : '';
    $enip=$core->decryptID($enip_str);

    if($enip==$_SERVER['REMOTE_ADDR']){
        if($package_id==1){
            setcookie("get_demo_1","demo", time() + (86400 * 1),"/");
            header('location:http://essentials.isocms.com');
            exit();
        }elseif($package_id==2){
            setcookie("get_demo_2","demo", time() + (86400 * 1),"/");
            header('location:http://professional.isocms.com');
            exit();
        }elseif($package_id==3){
            setcookie("get_demo_3","demo", time() + (86400 * 1),"/");
            header('location:http://premium.isocms.com');
            exit();
        }elseif($package_id==4){
            setcookie("get_demo_4","demo", time() + (86400 * 1),"/");
            header('location:https://isocms.com');
            exit();
        }else{
            header('location:http://isocms.net');
            exit();
        }
    }else{
        header('location:http://isocms.net');
        exit();
    }
}
function default_sendMail(){
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
    #
    $from = $_POST['FromEmail'];
    $to   = $_POST['ToEmail'];
    $subject = 'Send mail friend';
    $message = "Một lá thư được gửi đến từ ".$_POST['FromName']." <br/>";
    $message.= "Nội dung : ".$_POST['Note']." <br/>";
    $message.= "Đường dẫn website : ".$_POST['current_link']."";
    $headers = 	"MIME-Version: 1.0\r\n".
        "Content-type: text/html; charset=utf-8\r\n".
        "From:  ".$_POST['FromName']."<".$from.">\r\n".
        "Subject: ".$subject."\r\n";
    $is_send_mail = @mail($to,$subject,$message,$headers);
    die();
}
function default_ajSubmitSubscribe() {
    global $core,$mod,$act, $clsConfiguration, $clsISO;
    $clsSubscribe =new Subscribe();
    #
    $err_msg = "";
    $email = isset($_POST['email'])?addslashes($_POST['email']):'';
    $name = isset($_POST['name'])?addslashes($_POST['name']):'';
    $subscribe_check = isset($_POST['subscribe_check'])?addslashes($_POST['subscribe_check']):'';

    $current_date = date('m/d/Y');
    $current_time = strtotime($current_date);
    #
    $err_msg .= $clsISO->checkSubsTotalSe();

    if ($subscribe_check == '' && $err_msg == '') {
        if ($clsSubscribe->checkValidEmail($email) == '0') {
            $fx = "$clsSubscribe->pkey,fullname,email,user_ip,reg_date,departure_date,receive_newsletter";
            $vx = "'" . $clsSubscribe->getMaxId() . "','$name','$email','" . $_SERVER['REMOTE_ADDR'] . "','" . time() . "','" . $current_time . "','1'";
            if ($clsSubscribe->insertOne($fx, $vx)) {
                $clsSubscribe->sendMail($email);
                echo $core->get_Lang('Sign up for email success');
            }
        } else {
            echo $core->get_Lang('Email address already exists !');
        }
    } else {
        echo $core->get_Lang('subscribe error');
    }
    die();
}
function default_ajQuickBooking() {
    global $core,$mod,$act, $clsConfiguration;
    $clsBooKingRoom =new BooKingRoom();
    #
    $name = isset($_POST['name'])?addslashes($_POST['name']):'';
    $email = isset($_POST['email'])?addslashes($_POST['email']):'';
    $phone = $_POST['phone'];
    $intro = $_POST['intro'];
    $type = $_POST['type'];
    #
    $max_id = $clsBooKingRoom->getMaxId();
    $fx = "booking_room_id,fullname,phone,email,type,intro_email,user_ip,reg_date";
    $vx = "'$max_id','$name',$phone,'$email','$type','$intro','".$_SERVER['REMOTE_ADDR']."','".time()."'";
    if($clsBooKingRoom->insertOne($fx,$vx)) {
        $clsBooKingRoom->sendMailQuickBooKing($max_id);
        echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess')); die();
    }
}
function default_check_open_email(){
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$profile_id;
    $clsISO = new ISO();
    $clsFeedback = new Feedback();
    #
    $feedback_id = isset($_GET['feedback_id'])?intval($_GET['feedback_id']):0;

    $clsFeedback->updateOne($feedback_id,"is_open_mail=1");
    exit;
}
function default_ajGetSubs_totalSe(){
    global $clsISO;
    $a_se_subs= rand(1,9);
    $b_se_subs= rand(1,9);
    $subs_totalSe = $a_se_subs+$b_se_subs;
    vnSessionSetVar("subs_totalSe",$subs_totalSe);
    $subs_uid = $clsISO->getUniqid();
    vnSessionSetVar("subs_uid",$subs_uid);
    echo json_encode(array(
        "msg"	=> "ok",
        "a_se_subs"	=> $a_se_subs,
        "b_se_subs"	=> $b_se_subs,
        "subs_totalSe"	=> $subs_totalSe,
        "subs_uid"	=> $subs_uid,
    )); die;
}

function default_login() {
        global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $profile_id;
        $clsProfile = new Profile();
        #
        if ($clsProfile->isLoggedIn()) {
            header("location:" . $clsProfile->getLink('my_profile'));
            exit();
        }
        #
        $return_url = isset($_GET['return_url']) ? $_GET['return_url'] : '';
        $msgSubmitForm = '';
        if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
            $USER = $_POST['USER'];
            $PASSWORD = $_POST['PASSWORD'];
            if ($clsProfile->userLoggedIn($USER, $PASSWORD)) {
                header("location:" . DOMAIN_NAME . $return_url);
                exit();
            } else {
                $msgSubmitForm .= $core->get_Lang('Login failed!') . '<br>';
            }
            foreach ($_POST as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        $assign_list["msgSubmitForm"] = $msgSubmitForm;
        /*=============Content Page==================*/
        $title_page = $core->get_Lang('Login') . ' | ' . PAGE_NAME;
        $assign_list["title_page"] = $title_page;
        $description_page = $title_page;
        $assign_list["description_page"] = $description_page;
        $keyword_page = $title_page;
        $assign_list["keyword_page"] = $keyword_page;
}

?>