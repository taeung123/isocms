<?php
function default_default(){
	global $assign_list, $core, $dbconn , $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$clsISO,$clsConfiguration,$extLang;
	#
	$clsPagination = new Pagination();
	$clsVietISOSDK = new VietISOSDK();
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$page  = array(
		'page' => $currentPage
	);
	$response_event = $clsVietISOSDK->doInApp('post', 'event',json_encode($page));
	$response_event = json_decode($response_event,true);
	if ($response_event['result'] != 'success'){
		header('Location:/404/');
		exit();
	}
	$lstCat = $response_event['listEventCat'];
	$assign_list['lstCat']=$lstCat;
	$SiteIntroEvent = $response_event['SiteIntroEvent'];
	$SiteBannerEvent = $response_event['SiteBannerEvent'];
	$assign_list['SiteBannerEvent']=$SiteBannerEvent;
	$assign_list['SiteIntroEvent']=$SiteIntroEvent;
	$listEvent = $response_event['listEvent'];
	if (!empty($listEvent)){
		foreach ($listEvent as $k=>$v){
			$listEvent[$k]['more_information']= json_decode($v['more_information'],true);
			$listEvent[$k]['title']= htmlentities($v['title']);
		}
	}
	$assign_list['listEvent']=$listEvent;
	$totalRecord = $response_event['totalRecord'];
	$link_page =$clsISO->getLink('events');
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $response_event['record_per_page'],
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);

	$totalPage = $response_event['totalPage'];

	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Event').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$clsConfiguration->getValue('site_news_intro_'.$_LANG_ID);
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_cat(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang;
	global $clsISO,$clsConfiguration;
	#
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$eventcat_id = isset($_GET['eventcat_id']) ? intval($_GET['eventcat_id']) : 0;
	if (empty($eventcat_id)){
		header('Location:/404/');
		exit();
	}
	$assign_list['show']=$show;
	$clsPagination = new Pagination();
	#
	$slug_cat = $_GET['slug_cat'];
	$clsPagination = new Pagination();
	$clsVietISOSDK = new VietISOSDK();
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;

	$page  = array(
		'page' => $currentPage,
		'slug_cat' => $slug_cat,
		'eventcat_id' => $eventcat_id
	);
	$response_event = $clsVietISOSDK->doInApp('post', 'event',json_encode($page));
	$response_event = json_decode($response_event,true);
	if ($response_event['result'] != 'success'){
		header('Location:/404/');
		exit();
	}
	$lstCat = $response_event['listEventCat'];
	$assign_list['lstCat']=$lstCat;
	$oneEventCat = $response_event['oneEventCat'];
	$assign_list['oneEventCat']=$oneEventCat;
	$listEvent = $response_event['listEvent'];
	if (!empty($listEvent)){
		foreach ($listEvent as $k=>$v){
			$listEvent[$k]['more_information']= json_decode($v['more_information'],true);
			$listEvent[$k]['title']= htmlentities($v['title']);
		}
	}
	$assign_list['listEvent']=$listEvent;
	$assign_list['eventcat_id']=$eventcat_id;
	$totalRecord = $response_event['totalRecord'];
	$link_page = $clsISO->getLinkEventCat($slug_cat,$eventcat_id);
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $response_event['record_per_page'],
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);
	$totalPage = $response_event['totalPage'];
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Event').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$clsConfiguration->getValue('site_news_intro_'.$_LANG_ID);
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_detail(){
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$oneProfile,$loggedIn;
	global $extLang;
	#
	$clsVietISOSDK = new VietISOSDK();
	$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
	if($event_id==0){
		header('Location:/'.$extLang);
		exit();
	}
	$event_arr  = array(
		'event_id' => $event_id
	);

	$response_event = $clsVietISOSDK->doInApp('post', 'event/detail',json_encode($event_arr));
	$response_event = json_decode($response_event,true);
	if ($response_event['result'] != 'success'){
		header('Location:/'.$extLang);
		exit();
	}
	$oneEvent = $response_event['oneEvent'];
	$other_Event = $response_event['other_Event'];
	$listSponsor = $response_event['listSponsor'];
	$listSponsored = $response_event['listSponsored'];
	$total_ticket_remaining = $response_event['total_ticket_remaining'];
	if (!empty($oneEvent)){
		$sponsor_package= json_decode($oneEvent['sponsor_package'],true);
		$more_information= json_decode($oneEvent['more_information'],true);
		$schedule= json_decode($oneEvent['schedule'],true);
		$content_news= json_decode($oneEvent['content_news'],true);
	}
	$listYield = $response_event['listYield'];
	$assign_list["listYield"] = $listYield;
	$assign_list["album"] = $oneEvent['album'];
	$assign_list["sponsor_package"] = $sponsor_package;
	$assign_list["more_information"] = $more_information;
	$assign_list["content_news"] = $content_news;
	$assign_list["schedule"] = $schedule;
	$assign_list["currency_id"] = $response_event['currency_id'];
	$assign_list["listSponsor"] = $listSponsor;
	$assign_list["listSponsored"] = $listSponsored;
	$assign_list["total_ticket_remaining"] = $total_ticket_remaining;
	$assign_list["oneEvent"] = $oneEvent;
	$assign_list["other_Event"] = $other_Event;
	$assign_list["event_id"] = $event_id;
	/*=============Title & Description Page==================*/
	$title_page = $oneEvent['title'].' | '.$core->get_Lang('Events').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = html_entity_decode($response_event['oneEvent']['intro']);
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = html_entity_decode($oneEvent['image']);
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}
function default_news_event(){
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$clsConfiguration;
	global $extLang;
	#
	$clsVietISOSDK = new VietISOSDK();
	$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
	$news_id = isset($_GET['news_id']) ? $_GET['news_id'] : '';
	if(empty($event_id) || empty($news_id)){
		header('Location:/'.$extLang);
		exit();
	}
	$event_arr  = array(
		'event_id' => $event_id,
		'news_id' => $news_id
	);

	$response_event = $clsVietISOSDK->doInApp('post', 'event/news_event',json_encode($event_arr));
	$response_event = json_decode($response_event,true);
	if ($response_event['result'] != 'success'){
		header('Location:/'.$extLang);
		exit();
	}
	$oneNews = $response_event['oneNews'];
	$listRelated = $response_event['listRelated'];

	$assign_list["oneNews"] = $oneNews;
	$assign_list["listRelated"] = $listRelated;
	$assign_list["event_id"] = $event_id;
	$assign_list["news_id"] = $news_id;

	/*=============Title & Description Page==================*/
	$title_page = $oneNews['title'].' | '.$core->get_Lang('Events').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = html_entity_decode($response_event['oneEvent']['intro']);
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = html_entity_decode($oneNews['image']);
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}
function default_ticket(){
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$global_image_seo_page,$clsISO,$clsConfiguration;
	global $extLang;
	#
	$clsVietISOSDK = new VietISOSDK();
	$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
	$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

	if($event_id==0){
		header('Location:/'.$extLang);
		exit();
	}
	$event_arr  = array(
		'event_id' => $event_id,
		'order_id' => $order_id,
	);

	$response_event = $clsVietISOSDK->doInApp('post', 'event/ticket',json_encode($event_arr));
	$response_event = json_decode($response_event,true);
	if ($response_event['result'] != 'success'){
		header('Location:/'.$extLang);
		exit();
	}
	$oneEvent = $response_event['oneEvent'];
	$oneOrder = $response_event['oneOrder'];

	$assign_list["oneEvent"] = $oneEvent;
	$assign_list["oneOrder"] = $oneOrder;

	$assign_list["event_id"] = $event_id;
	$assign_list["order_id"] = $order_id;
	/*=============Title & Description Page==================*/
	$title_page = $oneEvent['title'].' | '.$core->get_Lang('Events').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = html_entity_decode($oneEvent['intro']);
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = html_entity_decode($oneEvent['image']);
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}
function default_search(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page,$extLang;
	global $clsISO,$clsConfiguration;
	#
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	$eventcat_id = isset($_GET['eventcat_id']) ? $_GET['eventcat_id'] : '';

	$clsPagination = new Pagination();
	#
	$clsPagination = new Pagination();
	$clsVietISOSDK = new VietISOSDK();
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;

	$page  = array(
		'page' => $currentPage,
		'keyword' => $keyword,
		'eventcat_id' => $eventcat_id
	);

	$response_event = $clsVietISOSDK->doInApp('post', 'event',json_encode($page));
	$response_event = json_decode($response_event,true);
	if ($response_event['result'] != 'success'){
		header('Location:/404/');
		exit();
	}
	$lstCat = $response_event['listEventCat'];
	$assign_list['lstCat']=$lstCat;
	$SiteIntroEvent = $response_event['SiteIntroEvent'];
	$SiteBannerEvent = $response_event['SiteBannerEvent'];
	$assign_list['SiteBannerEvent']=$SiteBannerEvent;
	$assign_list['SiteIntroEvent']=$SiteIntroEvent;
	$listEvent = $response_event['listEvent'];
	if (!empty($listEvent)){
		foreach ($listEvent as $k=>$v){
			$listEvent[$k]['more_information']= json_decode($v['more_information'],true);
			$listEvent[$k]['title']= htmlentities($v['title']);
		}
	}
	$assign_list['listEvent']=$listEvent;



	$totalRecord = $response_event['totalRecord'];
	$link_page = $clsISO->getLinkEventCat($slug_cat,$eventcat_id);
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $response_event['record_per_page'],
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html','/',$link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);

	$totalPage = $response_event['totalPage'];

	$assign_list['keyword'] = $keyword;
	$assign_list['eventcat_id'] = $eventcat_id;
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;

	/*=============Title & Description Page==================*/
	$title_page = $core->get_Lang('Event').' | '.PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page =$clsConfiguration->getValue('site_news_intro_'.$_LANG_ID);
	$assign_list["description_page"] = $description_page;
	$keyword_page =$title_page;
	$assign_list["keyword_page"] = $keyword_page;
}
function default_load_more_detail(){
	global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID,$title_page,$description_page,$keyword_page;
	$clsNewsCategory  = new NewsCategory ();
	$assign_list['clsNewsCategory'] = $clsNewsCategory;
	$clsNews = new News();
	$assign_list['clsNews'] = $clsNews;

	$html = '_empty';
	$order_no = $_POST['order_no'];
	$newscat_id = intval($_POST['newscat_id']);
	$assign_list['newscat_id'] = $newscat_id;
	$oneTableCat = $clsNewsCategory->getOne($newscat_id);
	$assign_list["oneTableCat"] = $oneTableCat;

	$sql = "is_trash=0 and is_online=1 and (cat_id='$newscat_id' or list_cat_id like '%|$newscat_id|%')";
	$lstAll = $clsNews->getAll($sql.=" and order_no >'$order_no' order by order_no ASC limit 0,1",$clsNews->pkey.",cat_id");

	if(!empty($lstAll)){
		$news_id = $lstAll[0][$clsNews->pkey];
		$url=$clsNews->getLink($news_id);
		$cat_id = $lstAll[0]['cat_id'];
		$oneTable = $clsNews->getOne($news_id);

		$assign_list['news_id'] = $news_id;
		$assign_list['url'] = $url;
		$assign_list['cat_id'] = $cat_id;
		$assign_list['oneTable'] = $oneTable;
		$assign_list["comment_config"] = array('news_id'=>$news_id);
		#- Related
		$sql = "is_trash=0 and is_online=1 and news_id<>'$news_id' and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
		$lstRelated = $clsNews->getAll($sql." order by reg_date DESC limit 0,4","news_id,permalink,title,intro,reg_date,upd_date,profile_id,type,number_comment,cat_id,end_date,link_target");
		$assign_list['lstRelated'] = $lstRelated;
		$html = $core->build('load_more_detail.tpl');
	}
	echo $html.'$$$'.$url;

	die();
}
function default_ajSubmitSubscribe() {
    global $core,$mod,$act, $clsConfiguration;
	$clsSubscribe =new Subscribe();
	#
	$email = isset($_POST['email'])?addslashes($_POST['email']):'';
	$current_date = date('m/d/Y');
	$current_time = strtotime($current_date);
	#
	if($clsSubscribe->checkValidEmail($email) == '0') {
		$fx = "fullname,email,user_ip,reg_date,departure_date,receive_newsletter";
		$vx = "'$name','$email','".$_SERVER['REMOTE_ADDR']."','".time()."','".$current_time."','1'";
		if($clsSubscribe->insertOne($fx,$vx)) {
				$clsSubscribe->sendMail($email);
			echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess')); die();
			}
		}else{
			echo '_EXIST|||'.$core->get_Lang('Email address already exists !'); die();
		}
}
function default_ajRegisterJoinStepOne(){
	global $clsISO;
	$title_page = PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	foreach($_POST as $key=>$val){
		$register_join[$key] = $val;
	}
	vnSessionSetVar('register_join',$register_join);
	/*$register_join = $_POST['register_join'];
	$_SESSION['register_join'] = $register_join;*/
}
function default_ajRegisterSponsorStepOne(){
	global $clsISO,$oneProfile,$loggedIn;
	$event_id = !empty($_POST['event_id'])? $_POST['event_id'] : 0;
	$potential_id = $oneProfile['potential']['potential_id'];
	$event_arr  = array(
		'event_id' => $event_id,
		'potential_id' => $potential_id,
	);

	$clsVietISOSDK = new VietISOSDK();
	$response_event = $clsVietISOSDK->doInApp('post', 'potential/checkSponsor',json_encode($event_arr));
	$response_event = json_decode($response_event,true);
	if ($response_event['result']=='exist'){
		echo json_encode(array(
			'msg'=>'exist'
		));die();
	}else{
		foreach($_POST as $key=>$val){
			$sponsor[$key] = $val;
		}
		vnSessionSetVar('sponsor',$sponsor);
		echo json_encode(array(
			'msg'=>'ok'
		));die();
	}


}
?>
