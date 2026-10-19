<?php
function default_default()
{
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO, $clsConfiguration, $extLang, $clsISO, $package_id;
	#
	$clsNewsCategory  = new NewsCategory();
	$assign_list["clsNewsCategory"] = $clsNewsCategory;
	$clsNews = new News();
	$assign_list["clsNews"] = $clsNews;
	$clsPagination = new Pagination();
	$assign_list["clsPagination"] = $clsPagination;

	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list["show"] = $show;

	$newscat_id = 0;
	$arrayCat = [];
	if ($show == 'cat') {
		$slug = $_GET['slug'];
		$res = $clsNewsCategory->getAll("is_trash=0 and is_online=1 and slug='$slug' LIMIT 0,1", $clsNewsCategory->pkey . ',title,intro,slug');
		$newscat_id = $res[0][$clsNewsCategory->pkey];
		$arrayCat = $res[0];
	}
	$assign_list["newscat_id"] = $newscat_id;
	$assign_list["arrayCat"] = $arrayCat;


	$recordPerPage = 9;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

	$page_Seo = isset($_GET['page']) ? intval($_GET['page']) : '';
	$assign_list['page_Seo'] = $page_Seo;

	$cond = "is_trash=0 and is_online=1";
	if (intval($newscat_id) > 0) {
		$cond .= " and (newscat_id='$newscat_id' or list_cat_id like '%|$newscat_id|%')";
	}

	$lstNewsTopView = $clsNews->getAll($cond . " order by view_num desc LIMIT 0,3", $clsNews->pkey . ',reg_date,newscat_id,title,slug,intro,image,publish_date');

	$arr_news_top_id = array();
	foreach ($lstNewsTopView as $item) {
		$arr_news_top_id[] = $item['news_id'];
	}
	$list_news_top_id = implode(',', $arr_news_top_id);


	$assign_list['lstNewsTopView'] = $lstNewsTopView;

	if (!empty($list_news_top_id)) {
		$cond .= " and news_id NOT IN  ($list_news_top_id)";
	}

	$allItem = $clsNews->getAll($cond, $clsNews->pkey);

	$totalRecord 	= $allItem ? count($allItem) : 0;
	#

	if ($newscat_id > 0) {
		$link_page = $slug;
	} else {
		$link_page = $clsISO->getLink('news');
	}
	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> str_replace('.html', '/', $link_page),
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	//	$page_view = $clsPagination->create_links_news(false);
	$page_view = $clsPagination->create_links(false);
	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";

	#

	$order_by = " order by order_no asc";
	//	print_r($cond.$order_by.$limit);die();
	//	$lstNews = $clsNews->getAll($cond . $order_by . $limit, $clsNews->pkey . ',reg_date,newscat_id,title,slug,intro,image,publish_date');
	$lstNews = $clsNews->getAll("is_trash = 0 AND is_online = 1 ORDER BY order_no ASC " . $limit, $clsNews->pkey . ',reg_date,newscat_id,title,slug,intro,image,publish_date');
	if (!$lstNews && $currentPage > 1) {
		header("Location: " . $link_page);
		exit();
	}
	$assign_list['lstNews'] = $lstNews;


	$totalPage = $clsPagination->getTotalPage();
	#
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['page_view'] = $page_view;

	/*=============Title & Description Page==================*/
	if ($show == 'cat') {
		$title_page = $clsNewsCategory->getTitle($newscat_id, $arrayCat) . ' | ' . $core->get_Lang('travelnews') . ' | ' . PAGE_NAME;
	} else {
		$title_page = $core->get_Lang('travelnews') . ' | ' . PAGE_NAME;
	}
	$title_page = $title_page;
	$assign_list["title_page"] = $title_page;
	if ($show == 'cat') {
		$description_page = $clsISO->getMetaDescription($newscat_id, 'NewsCategory', $arrayCat);
	} else {
		$description_page = $clsConfiguration->getValue('site_news_intro_' . $_LANG_ID);
	}

	$assign_list["description_page"] = $description_page;
}
function default_detail()
{
	//	ini_set('display_errors', '1');
	//	ini_set('display_startup_errors', '1');
	//	error_reporting(E_ALL);
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $global_image_seo_page, $clsISO, $clsConfiguration;
	global $extLang, $clsISO, $package_id;

	#
	$clsNewsCategory  = new NewsCategory();
	$assign_list["clsNewsCategory"] = $clsNewsCategory;
	$clsNews = new News();
	$assign_list["clsNews"] = $clsNews;

	#
	$news_id = isset($_GET['news_id']) ? $_GET['news_id'] : 0;
	$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

	if (empty($clsNews->checkOnlineBySlug($news_id, $slug))) {
		header('location:' . $clsISO->getLink('news'));
		exit();
	}
	$assign_list["news_id"] = $news_id;

	$sessionKey = 'news_' . $news_id;
	$sessionView = $_SESSION[$sessionKey] ?? "";
	if (!$sessionView) { // nếu chưa có session
		$_SESSION[$sessionKey] = 1; //set giá trị cho session
		$clsNews->updateOne($news_id, 'view_num=view_num+1');
	}

	#
	$newsItem = $clsNews->getOne($news_id, 'title,newscat_id,reg_date,last_update,author,intro,content,slug,image,publish_date');

	$assign_list["newsItem"] = $newsItem;
	$assign_list["newscat_id"] = $newsItem['newscat_id'];
	$lstRelated = $clsNews->getAll("is_trash=0 and is_online=1 and news_id<>'$news_id' order by rand() LIMIT 0,5", $clsNews->pkey . ",reg_date,title,slug,image");
	$assign_list["lstRelated"] = $lstRelated;
	/*=============Title & Description Page==================*/
	$title_page = $clsNews->getTitle($news_id, $newsItem) . ' | ' . $core->get_Lang('travelnews') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsISO->getMetaDescription($news_id, 'News', $newsItem);
	$assign_list["description_page"] = $description_page;
	$global_image_seo_page = $clsISO->getPageImageShare($news_id, 'News', $newsItem);
	$assign_list["global_image_seo_page"] = $global_image_seo_page;
}

function default_load_more_detail()
{
	global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	$clsNewsCategory  = new NewsCategory();
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
	$lstAll = $clsNews->getAll($sql .= " and order_no >'$order_no' order by order_no ASC limit 0,1", $clsNews->pkey . ",cat_id");

	if (!empty($lstAll)) {
		$news_id = $lstAll[0][$clsNews->pkey];
		$url = $clsNews->getLink($news_id);
		$cat_id = $lstAll[0]['cat_id'];
		$oneTable = $clsNews->getOne($news_id);

		$assign_list['news_id'] = $news_id;
		$assign_list['url'] = $url;
		$assign_list['cat_id'] = $cat_id;
		$assign_list['oneTable'] = $oneTable;
		$assign_list["comment_config"] = array('news_id' => $news_id);
		#- Related
		$sql = "is_trash=0 and is_online=1 and news_id<>'$news_id' and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
		$lstRelated = $clsNews->getAll($sql . " order by reg_date DESC limit 0,4", "news_id,permalink,title,intro,reg_date,upd_date,profile_id,type,number_comment,cat_id,end_date,link_target");
		$assign_list['lstRelated'] = $lstRelated;
		$html = $core->build('load_more_detail.tpl');
	}
	echo $html . '$$$' . $url;

	die();
}
