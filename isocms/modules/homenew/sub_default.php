<?php
/**
*  Defautl action
*  @author		: Technical Group (technical@aboutpro.com)
   @modifier    : Luong Tien Dung (info@vietiso.com)
*  @date		: 2009/10/01
   @date-modify : 2009/01/06
*  @version		: 3.0.0
*/

function webpConvert2($file, $compression_quality = 80)
{

    // check if file exists
    if (!file_exists($file)) {
           
        return false;
    }
    $file_type = exif_imagetype($file);
    //https://www.php.net/manual/en/function.exif-imagetype.php
    //exif_imagetype($file);
    #IMAGETYPE_GIF (1)
    #IMAGETYPE_JPEG (2)
    #IMAGETYPE_PNG (3)
    #IMAGETYPE_SWF (4)
    #IMAGETYPE_PSD (5)
    #IMAGETYPE_BMP (6)
    #IMAGETYPE_TIFF_II (7)
    #IMAGETYPE_TIFF_MM (8)
    #IMAGETYPE_JPC (9)
    #IMAGETYPE_JP2 (10)
    #IMAGETYPE_JPX (11)
    #IMAGETYPE_JB2 (12)
    #IMAGETYPE_SWC (13)
    #IMAGETYPE_IFF (14)
    #IMAGETYPE_WBMP (15)
    #IMAGETYPE_XBM (16)
    #IMAGETYPE_ICO (17)
    #IMAGETYPE_WEBP (18)
    $output_file =  $file . '.webp';
    if (file_exists($output_file)) {
        return $output_file;
    }
    if (function_exists('imagewebp')) {
            
        switch ($file_type) {
            case '1': //IMAGETYPE_GIF
                $image = imagecreatefromgif($file);
                break;
            case '2': //IMAGETYPE_JPEG
                $image = imagecreatefromjpeg($file);
                break;
            case '3': //IMAGETYPE_PNG
                    $image = imagecreatefrompng($file);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    break;
            case '6': // IMAGETYPE_BMP
                $image = imagecreatefrombmp($file);
                break;
            case '16': //IMAGETYPE_XBM
                $image = imagecreatefromxbm($file);
                break;
            default:
                return false;
        }
        // Save the image
        $result = imagewebp($image, $output_file, $compression_quality);
        if (false === $result) {
            return false;
        }
        // Free up memory
        imagedestroy($image);
        return $output_file;
    } elseif (class_exists('Imagick')) {
        $image = new Imagick();
        $image->readImage($file);
        if ($file_type === "3") {
            $image->setImageFormat('webp');
            $image->setImageCompressionQuality($compression_quality);
            $image->setOption('webp:lossless', 'true');
        }
        $image->writeImage($output_file);
        return $output_file;
    }
    return false;
}

function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO;
	#
    	ini_set('display_errors',1);
error_reporting(E_ERROR & ~E_STRICT);//E_ALL
    $file = ABSPATH.'/logo_share.png';
    $abc=webpConvert2($file);

print_r($abc);die();

    
}

function default_unknow(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang,$oneCommon;
	#
	header('Location:/');
	exit();
	
	$URI = $_SERVER['REQUEST_URI'];
	if(str_replace('//','/',$URI.'/')==$URI.'/'){
		header('location: '.$URI.'/');
	}
	/*=============Title & Description Page==================*/
	$title_page = '404 page - '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = '404';
	$assign_list["description_page"] = $description_page;
	$keyword_page = '404';
	$assign_list["keyword_page"] = $keyword_page;
}
function default_popup(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
	#
	$html='';
	$html.='<div class="header">
				<a class="closeEv clickToClose" href="javascript:void();" title="Đóng"></a>
				<h3 class="headPop">Send email to friend</h3>
			</div>';
	$html.='<div class="clearfix"></div>';
	$html.='<form id="SendToFriendForm" method="post" action="">';
	$html.='<div class="line-s">';
	$html.='<label class="tit">To (Name):</label>';
	$html.='<input class="txt" id="ToName" type="text" name="ToName">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">To (Email):</label>';
	$html.='<input class="txt" id="ToEmail" type="text" name="ToEmail">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">From (Name):</label>';
	$html.='<input class="txt" id="FromName" type="text" value="" name="FromName">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">From (Email):</label>';
	$html.='<input class="txt" id="FromEmail" type="text" value="" name="FromEmail">';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">From (Email):</label>';
	$html.='<textarea id="Note" rows="2" cols="20" value="" class="textarea"></textarea>';
	$html.='</div>';
	$html.='<div class="line-s">';
	$html.='<label class="tit">&nbsp;</label>';
	$html.='<input id="SendToFriend" class="button" type="submit" value="Send">
			<input id="Reset" class="button" type="reset" value="Reset">';
	$html.='</div>';
	$html.='</form>';
	echo $html; die();
}
function default_checkCaptcha(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$domain;
	#
	$security_code = isset($_POST["security_code"])? $_POST["security_code"] : '';
	$security_code = strtoupper($security_code);
	$security_code = trim($security_code);
	if($security_code===$_SESSION['skey']){
		echo 1;
	}else{
		echo 0;
	}
	//
	die();
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
function default_ajMakeSelectboxCategory(){
	global $core;
	
	$clsTour = new Tour();
	$clsCountry = new Country();
	$clsTourCategory = new TourCategory();
	#
	$country_id = $_POST['country_id'];
	$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
	
	$html = '<select class="selectbox" name="cat_id">';
	$html.= '<option value="0">-- Select vacation type --</option>';
	
	if(intval($country_id) > 0){
		$lstCategory = $clsTourCategory->getAll("is_trash=0 order by order_no asc");
		if(is_array($lstCategory) && count($lstCategory) > 0){
			foreach($lstCategory as $k=>$v){
				if($clsTour->countTourGolobal($country_id,0,0,$v[$clsTourCategory->pkey],0) > 0){
					$html.='<option value="'.$v[$clsTourCategory->pkey].'" '.($cat_id==$v[$clsTourCategory->pkey]?'selected="selected"':'').'>'.$clsTourCategory->getTitle($v[$clsTourCategory->pkey]).'</option>';
				}
			}
		}
		unset($lstCategory);
	}
	$html.='</select>';
	echo $html; die();
}
function default_ajMakeSelectboxDuration(){
	$clsTour = new Tour();
	$clsCountry = new Country();
	#
	$country_id = $_POST['country_id'];
	$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
	$duration_id = isset($_POST['duration_id'])?$_POST['duration_id']:'';
	#
	$html = '<select class="selectbox" name="duration_id">';
	$html.='<option value="0">-- Select duration--</option>';
	#
	$cond= "is_trash=0 and is_online=1";
	if(intval($country_id) > 0){
		$cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id')";
	}
	if(intval($cat_id) > 0){
		$cond .= " and (cat_id='$cat_id' or list_cat_id like '%|".$cat_id."|%')";
	}
	#
	if(intval($country_id) > 0 || intval($cat_id) > 0){
		$res = $clsTour->getAll($cond." order by number_day ASC limit 0,1000");
		$tmp='';
		if(!empty($res)){
			for ($i=0; $i < count($res); $i++) {
				$tmp .= $clsTour->getSelectTripDuration($res[$i]['tour_id']).'|';
			}
		}
		$tmp = array_unique(explode('|', $tmp));
		if(!empty($tmp)){
			foreach($tmp as $key=>$val){
				if($val!='' && $val!='n/a'){
					$selected = ($duration_id==$clsTour->convertDuration($val))?'selected="selected"':'';
					$html.='<option value="'.$clsTour->convertDuration($val).'" '.$selected.'>'.$val.'</option>';
				}
			}
		}
	}
	$html.='</select>';
	echo $html; die();
}
function default_ajMakeSelectboxCountry(){
	$clsCountry = new Country();
	#
	$res =$clsCountry->getAll("is_trash=0 order by order_no asc");
	$html = '<select class="selectbox" name="country_id">';
	$html.= '<option value="0">-- Select country --</option>';
	if(is_array($res) && count($res) > 0){
		foreach($res as $k => $v){
			$html.='<option value="'.$v[$clsCountry->pkey].'">-- '.$clsCountry->getTitle($v[$clsCountry->pkey]).' --</option>';
		}
	}
	$html .= '</select>';
	unset($res);
	echo $html; die();
}
function default_ajLoadPackageDeals() {
	global $core, $dbconn, $clsISO;
	#
	$clsTour = new Tour();
	$clsCountryEz = new Country();
	$country_id = isset($_POST['country_id'])?$_POST['country_id']:0;
	#
	$sql = "SELECT DISTINCT t1.tour_id FROM ".DB_PREFIX."tour t1 INNER JOIN ".DB_PREFIX."tour_destination t2 WHERE t1.tour_id = t2.tour_id AND t2.country_id='".$country_id."' and t1.is_trash=0 and t1.is_online=1 ORDER BY t1.order_no DESC limit 0,2";
	$lstTours = $dbconn->GetAll($sql);
	#
	$html = '';
	if(!empty($lstTours)) {
		for($i=0;$i<count($lstTours);$i++) {
			$tour_id = $lstTours[$i][$clsTour->pkey];
			$html.= '
			<div class="lst-ext-tours">
				<div class="row">
					<div class="col-md-3">
						<a class="photo" href="'.$clsTour->getLink($tour_id).'" title="'.$clsTour->getTitle($tour_id).'">
							<img src="'.$clsTour->getImageUrl($tour_id).'" width="100%" alt="" />
							<span class="priceTours hide_m">
								'.$core->get_Lang('Price').' <br/>
								<strong class="valPrice">'.$clsTour->getTripPrice($tour_id).'</strong>
							</span>
						</a>
					</div>
					<div class="col-md-7 r">
						<h3 class="title"><a href="'.$clsTour->getLink($tour_id).'" title="'.$clsTour->getTitle($tour_id).'">'.$clsTour->getTitle($tour_id).'</a></h3>
						<div class="div_sub_duration">
							'.$core->get_Lang('Durations').':  <b class="val">'.$clsTour->getTripDuration($tour_id).'</b>
						</div>
						<div class="div_sub_arround">
							'.$core->get_Lang('Destinations').':  '.$clsTour->getCityAround($tour_id).'
						</div>
						<div class="intro">'.$clsISO->truncateWord($clsTour->getStripIntro($tour_id),20).'</div>
					</div>
					<div class="col-md-2 boxPrice hide_s">
						<div class="priceVal">
							<div class="price_from">'.$core->get_Lang('Price').'</div>
							<div class="valPrice">'.$clsTour->getTripPrice($tour_id).'</div>
						</div>
						<a class="view" href="'.$clsTour->getLink($tour_id).'" title="'.$core->get_Lang('View detail').'">'.$core->get_Lang('View detail').'></a>
					</div>
				</div>
			</div>';
		}
	}
	echo($html.'|||'.$clsCountryEz->getLinkTour($country_id)); die();
}
function default_ajSubmitSubscribe() {
    global $core,$mod,$act, $clsConfiguration;
	$clsSubscribe =new Subscribe();
	#
	$email = isset($_POST['email'])?addslashes($_POST['email']):'';
	$name = isset($_POST['name'])?addslashes($_POST['name']):'';
	#
	if($clsSubscribe->checkValidEmail($email) == '0') {
		$max_id = $clsSubscribe->getMaxId();
		$fx = "subscribe_id,fullname,email,user_ip,reg_date,receive_newsletter";
		$vx = "'$max_id','$name','$email','".$_SERVER['REMOTE_ADDR']."','".time()."','1'";
		if($clsSubscribe->insertOne($fx,$vx)) {
				$clsSubscribe->sendMail($max_id);
			echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess')); die();
			}
		} else {
			echo '_EXIST|||'.$core->get_Lang('Email address already exists !'); die();
		}
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
require_once(DIR_INCLUDES.'/isoman/php/index.php');
?>
