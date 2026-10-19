<?php
if (!function_exists('_toArray')) {
	function _toArray($d)
	{
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		} else {
			// Return array
			return $d;
		}
	}
}
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser;
}
function default_home()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $smarty, $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser;
	//die('xx');
	$curl = new Curl\Curl();
	$listDocs = array();
	$DocURL = 'https://docs.vietiso.com';
	if (DOCS_CACHING) {
		$_cacheName = md5('_ListDocsISOCMS');
		$cache = new Cache(array("adapter" => "file", "cache_path" => DIR_CACHE_BLOCKS));
		//echo DIR_CACHE_BLOCKS;
		$listDocs = $cache->get($_cacheName);
		//$clsISO->pre($listDocs);die;
		if (!$listDocs) {
			$curl->setHeader('Content-Type', 'application/json');
			$curl->setHeader('Authorization', 'd0bf4c04fb0b5b5a6634b5cc94848f96');
			//$curl->get($DocURL.'/api/docs/lists/1/0');
			$curl->post($DocURL . '/api/docs/isocms');

			if (!$curl->error) {
				$response = _toArray($curl->response);
				if (isset($response['result']) && $response['result'] == 'success') {
					$listDocs = $response['data'];
				}
			}
			$cache->save($_cacheName, $listDocs, 3600);
		}
	} else {
		$curl->setHeader('Content-Type', 'application/json');
		$curl->setHeader('Authorization', 'd0bf4c04fb0b5b5a6634b5cc94848f96');
		//$curl->get($DocURL.'/api/docs/lists/1/0');
		$curl->post($DocURL . '/api/docs/isocms');
		//var_dump($curl->response);die;
		if (!$curl->error) {
			$response = _toArray($curl->response);
			if (isset($response['result']) && $response['result'] == 'success') {
				$listDocs = $response['data'];
			}
		}
	}
	$assign_list["listDocs"] = $listDocs;
	#
	$template_name = 'searchhelp.tpl';
	$cache_id = md5($_SERVER['REQUEST_URI'] . $template_name);
	$smarty->clearCache($template_name, $cache_id);
}
function default_searchhelp()
{
	global $oSmarty, $smarty, $assign_list, $core, $dbconn, $mod, $act, $clsISO, $_loged_id, $oneUser;
	$DocURL = 'https://docs.vietiso.com';
	$curl = new Curl\Curl();
	$listDocs = array();
	$keySearch = Input::post('keySearch');
	if (!empty($keySearch) || 1) {
		$curl->setHeader('Content-Type', 'application/json');
		$curl->setHeader('Authorization', 'd0bf4c04fb0b5b5a6634b5cc94848f96');
		$curl->post($DocURL . '/api/docs/isocms', array(
			'keySearch' => $keySearch
		));
		if (!$curl->error) {
			$response = _toArray($curl->response);
			//$clsISO->pre($response);die;
			if (isset($response['result']) && $response['result'] == 'success') {
				$listDocs = $response['data'];
			}
			if (!empty($listDocs)) {
				//$clsISO->pre($listDocs);die;
				//$smarty->assign("listDocs",$listDocs);
				$assign_list['listDocs'] = $listDocs;
				$html = $clsISO->build('searchhelp.tpl', $assign_list, 0);
				echo $html;
				die();
			} else {
				echo __('Not found search result');
				die();
			}
		} else {
			echo 'Error system';
			die();
		}
	} else {
		echo '';
		die();
	}
}
function default_my_ticket()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser;
	//die('xx');
	//ini_set( "display_errors", 1);

}
function default_ajSubmitMyTicket()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser, $clsUser;
	//ini_set( "display_errors", 1);
	$title_ticket = Input::post('title_ticket', '');
	$content_ticket = Input::post('content_ticket', '');
	$cat_ticket = Input::post('cat_ticket', '');
	$other_cat_ticket = Input::post('other_cat_ticket', '');
	$content_ticket = $clsISO->parseImageInContent($content_ticket);
	$oneUser = $clsUser->getOne($_loged_id, "email,full_name,first_name,last_name"); //avatar
	$full_name = !empty($oneUser['full_name']) ? $oneUser['full_name'] : $oneUser['first_name'] . ' ' . $oneUser['last_name'];
	$email = $oneUser['email'] ? $oneUser['email'] : $full_name;
	$domain_name = DOMAIN_NAME;
	$project_id = OKRS_PROJECT_ID;
	$ym = date("Ym");
	$ticket_id = $clsISO->getUniqid(1, $ym . '_');
	$code = substr($ticket_id, -6, 6);
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	//$clsISO->pre($isocms_ticket);die;
	if (@file_exists(DIR_INCLUDES . '/json_master/autoload.php')) {
		require_once(DIR_INCLUDES . '/json_master/autoload.php');
	}
	$oneTicket = array(
		"code"	=> $code,
		"title"	=> $title_ticket,
		"content"	=> $content_ticket,
		"cat"	=> $cat_ticket,
		"other_cat"	=> $other_cat_ticket,
		"status"	=> '1open',
		"parent_id"	=> 0,
		"user_id"	=> $_loged_id,
		"user_name"	=> $full_name,
		"user_email"	=> $email,
		"user_avatar"	=> '',
		"domain_name"	=> $domain_name,
		"project_id"	=> $project_id,
		"reg_date"	=> time(),
		"user_read"	=> array($_loged_id),
		"admin_read"	=> array(),
	);
	$isocms_ticket[$ticket_id] = $oneTicket;
	$file_cached = DIR_JSON_TICKET . 'isocms_ticket_' . $ym . '.json';
	$encoder = new Webmozart\Json\JsonEncoder();
	$encoder->encodeFile($isocms_ticket, $file_cached);
	$is_send_mail = $clsISO->sendEmailCreatTicket($ticket_id, $oneTicket);
	if ($clsISO->getVar('OKRS_PROJECT_ID')) {
		$clsVSOkrsSDK = new VSOkrsSDK();
		$params = array(
			"ym"	=> $ym,
			"project_id"	=> $project_id,
			"ticket_id"	=> $ticket_id,
			"oneTicket"	=> $oneTicket,
			"is_send_mail"	=> $is_send_mail,
		);
		$res = $clsVSOkrsSDK->post('/api/add_ticket_isocms', @json_encode($params, JSON_UNESCAPED_UNICODE));
		//$clsISO->pre($res);
	}

	echo $ticket_id, '||', $code;
	die;
}
function default_list_ticket()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser, $clsUser;
	//die('xx');
	//ini_set( "display_errors", 1);
}
function ticket_sort($ticket_a, $ticket_b)
{
	if (intval($ticket_a["status"]) == intval($ticket_b["status"])) {
		return $ticket_b["reg_date"] - $ticket_a["reg_date"];
	} else {
		return intval($ticket_a["status"]) - intval($ticket_b["status"]);
	}
}
function default_ajLoadListISOCMSTicketGlobe()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser, $clsUser;
	//die('xx');
	//ini_set( "display_errors", 1);
	$currentPage = Input::post('currentPage', 1);
	$number_per_page = Input::post('number_per_page', 20);
	$keyword = Input::post('keyword');
	//$year = Input::post('year');
	$start_date = Input::post('start_date');
	$to_date = Input::post('to_date');
	$cat = Input::post('cat');
	$status = Input::post('status');
	$user_id = Input::post('user_id');
	if (!empty($keyword)) {
		$slug_search = $clsISO->replaceSpace($keyword);
		$slugi_search = $clsISO->replaceSpacei($keyword);
	}
	if (!empty($start_date)) {
		$start_time = $clsISO->convertTextToTime($start_date);
		$start_date = str_replace("/", "-", $start_date);
	}
	if (!empty($end_date)) {
		$to_time = $clsISO->convertTextToTime($to_date) + (24 * 60 * 60 - 1);
		$to_date = str_replace("/", "-", $to_date);
	}
	$lstYm = $clsISO->getYmByRangeDate($start_date, $to_date);
	$isocms_ticket = $clsISO->getISOCMSTicket($lstYm);
	//$clsISO->pre($isocms_ticket);die;
	if (!empty($isocms_ticket)) {
		foreach ($isocms_ticket as $ticket_id => $oneTicket) {
			$valid = 1;
			if (!empty($oneTicket['parent_id'])) {
				$valid = 0;
				unset($isocms_ticket[$ticket_id]);
				continue;
			}
			if (!empty($keyword)) {
				if (
					stripos($oneTicket['code'], $keyword) !== false
					|| stripos($oneTicket['title'], $keyword) !== false
					|| stripos($clsISO->replaceSpacei($oneTicket['code']), $slugi_search) !== false
					|| stripos($clsISO->replaceSpacei($oneTicket['title']), $slugi_search) !== false
				) {
					$valid = 1;
				} else {
					$valid = 0;
					//continue;
				}
			}
			if (!empty($start_time)) {
				if ($oneTicket['reg_date'] < $start_time) {
					$valid = 0;
					//continue;
				}
			}
			if (!empty($end_time)) {
				if ($oneTicket['reg_date'] > $end_time) {
					$valid = 0;
					//continue;
				}
			}
			if (!empty($cat)) {
				if ($oneTicket['cat'] != $cat) {
					$valid = 0;
					//continue;
				}
			}
			if (!empty($status)) {
				if ($status == 'unread') {
					if (!in_array($_loged_id, $oneTicket['user_read'])) {
						$valid = 1;
					} else {
						$valid = 0;
					}
				} else {
					if ($oneTicket['status'] != $status) {
						$valid = 0;
						//continue;
					}
				}
			}
			if (!empty($user_id)) {
				if ($oneTicket['user_id'] != $user_id) {
					$valid = 0;
					//continue;
				}
			}
			if ($valid) {
				$isocms_ticket[$ticket_id] = $oneTicket;
			} else {
				unset($isocms_ticket[$ticket_id]);
			}
		}
	}
	//$isocms_ticket = array_reverse($isocms_ticket,1);
	uasort($isocms_ticket, "ticket_sort");
	$offset = ($currentPage - 1) * $number_per_page;
	$totalRecord = $isocms_ticket ? count($isocms_ticket) : 0;
	$totalPage = $number_per_page <= 0 ? 1  : ceil($totalRecord / $number_per_page);
	$isocms_ticket = array_slice($isocms_ticket, $offset, $number_per_page);
	//$clsISO->pre($isocms_ticket);die;
	#
	$html = '<table class="table table-hover table-striped table-reponsive" width="100%" id="TableListISOCMSTicketGlobe">
	<thead><tr>
		<th class="font-14" width="80">' . __('Code Ticket') . '</th>
		<th class="font-13 text-center" width="110">' . __('Status') . '</th>
		<th class="font-14">' . __('Ticket type') . '</th>
		<th class="font-14">' . __('Subject') . '/' . __('Content') . '</th>
		<th class="font-14" width="150">' . __('CreateBy') . '</th>
		<!--<th class="font-14" width="120">' . __('CreatedDate') . '</th>
		<th class="font-14" width="120">' . __('Update') . '</th>-->
		<th width="40"></th>
	</tr></thead>';
	if (!empty($isocms_ticket)) {
		foreach ($isocms_ticket as $ticket_id => $one) {
			$attr = $clsISO->set_attrs(array(
				"ticket_id"	=> $ticket_id
			));
			//$editAction = '<a class="ajEditTicket" title="'.__('Edit').'" '.$attr.'>'.makeIcon('pencil',__('Edit')).'</a>';
			$viewAction = '<a class="ajViewTicket" href="' . $clsISO->getLinkTicket('detail_ticket') . $ticket_id . '" title="' . __('View') . '" ' . $attr . '>' . makeIcon('eye', __('View')) . '</a>';
			$dropdown = '
			<div class="dropdown mega-dropdown dropdown-toolbar">
				<a class="btn btn-default dropdown-toggle no-border"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
				<ul class="dropdown-menu">
				<li>' . $viewAction . '</li>
			  </ul>
			</div>';
			//<li>'.$editAction.'</li>
			$user_read = in_array($_loged_id, $one['user_read']) ? 1 : 0;
			//<p>'.$clsISO->truncate($one['content']).'</p>
			$full_name = "VietISO Team";
			if (!empty($one['user_id'])) {
				$oneUser = $clsUser->getOne($one['user_id'], "full_name,first_name,last_name");
				$full_name = !empty($oneUser['full_name']) ? $oneUser['full_name'] : $oneUser['first_name'] . ' ' . $oneUser['last_name'];
			}
			$html .= '
			<tr>
				<td class="' . (!$user_read ? ' bold' : '') . '" data-label="' . __('Code') . '"><a class="color-royalblue" href="' . $clsISO->getLinkTicket('detail_ticket') . $ticket_id . '">#' . $one['code'] . '</a></td>
				<td data-label="' . __('Status') . '" class="text-right text-md-center' . (!$user_read ? ' bold' : '') . '">' . $clsISO->getLabelStatusTicket($one['status']) . '</td>
				<td ' . (!$user_read ? 'class="bold"' : '') . ' data-label="' . __('Ticket type') . '">' . $clsISO->getCatNameTicket($one['cat'], $one) . '</td>
				<td ajViewPopoverGlobal class="font-15 ' . (!$user_read ? ' bold' : '') . '" tbl="ticket_content" pval="' . $ticket_id . '">' . $one['title'] . '
					</td>
				<td ' . (!$user_read ? 'class="bold"' : '') . ' data-label="' . __('CreateBy') . '">' . $full_name . '
					<p class="mb-0 mt-1 font-11 color-666" title="' . __('CreatedDate') . '">' . makeIMO('add_alarm', date("d/m/Y H:i", $one['reg_date'])) . '</p>
					' . (!empty($one['upd_date']) ? '<p class="mb-0 font-11 color-666" title="' . __('Update') . '">' . makeIMO('update', date("d/m/Y H:i", $one['upd_date'])) . '</p>' : '') . '
				</td>	
				<!--<td ' . (!$user_read ? 'class="bold"' : '') . ' data-label="' . __('CreatedDate') . '">' . date("d/m/Y H:i", $one['reg_date']) . '</td>
				<td ' . (!$user_read ? 'class="bold"' : '') . ' data-label="' . __('Update') . '">' . (!empty($one['upd_date']) ? date("d/m/Y H:i", $one['upd_date']) : '') . '</td>-->
				<td class="text-center">' . $dropdown . '</td>
			</tr>';
		}
	}
	$html .= '</table>
	' . ($totalRecord > 0 ? '<div class="easyui-pagination px-1" id="PageISOCMSTicket" pageNumber="' . $currentPage . '" pageList="[20,30,50,100]"></div>' : '') . '	';
	#
	echo json_encode(array(
		'currentPage'	=> $currentPage,
		'number_per_page'	=> $number_per_page,
		'totalRecord'	=> $totalRecord,
		'totalPage'	=> $totalPage,
		'lstYm'	=> $lstYm,
		'html'	=> $html
	));
	die();
}
function default_detail_ticket()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser, $clsUser;
	//die('xx');
	//ini_set( "display_errors", 1);
	$ticket_id = Input::get('ticket_id', 0);
	$ym = explode("_", $ticket_id)[0];
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	// print_r($isocms_ticket);die();
	$oneTicket = $isocms_ticket[$ticket_id];
	$oneUser = $clsUser->getOne($_loged_id, "full_name,first_name,last_name,email");

	$full_name = !empty($oneUser['full_name']) ? $oneUser['full_name'] : $oneUser['first_name'] . ' ' . $oneUser['last_name'];
	//$clsISO->pre($full_name);die();
	$assign_list["full_name"] = $full_name;
	$assign_list["oneUser"] = $oneUser;
	$email = $oneUser['email'] ? $oneUser['email'] : $full_name;
	if (!in_array($_loged_id, $oneTicket['user_read'])) { //lưu user_read, khi có ansewerd hoặc thay đổi trạng thái thì clear user_read
		if (@file_exists(DIR_INCLUDES . '/json_master/autoload.php')) {
			require_once(DIR_INCLUDES . '/json_master/autoload.php');
		}
		$oneTicket['user_read'][] = $_loged_id;
		$isocms_ticket[$ticket_id] = $oneTicket;
		$file_cached = DIR_JSON_TICKET . 'isocms_ticket_' . $ym . '.json';
		$encoder = new Webmozart\Json\JsonEncoder();
		$encoder->encodeFile($isocms_ticket, $file_cached);
		#lưu thông tin user read cho các ansewer admin
		$project_id = OKRS_PROJECT_ID;
		if ($clsISO->getVar('OKRS_PROJECT_ID')) {
			$clsVSOkrsSDK = new VSOkrsSDK();

			$params = array(
				"ym"	=> $ym,
				"project_id"	=> $project_id,
				"ticket_id"	=> $ticket_id,
				"user_id"	=> $_loged_id,
				"user_email"	=> $email,
			);
			$res = $clsVSOkrsSDK->post('/api/read_ticket_isocms', @json_encode($params, JSON_UNESCAPED_UNICODE));
		}
		#notify read
		/*$clsNotification = new Notification();
		$lastNotify = $clsNotification->GetAll("is_trash=0 and tp='ticket' and ticket_id='".$ticket_id."' and list_user_id_slash like '%|$_loged_id|%' 
		and list_user_id_read not like '%|$_loged_id|%' order by reg_date DESC limit 0,1");
		$list_user_id_slash = $lastNotify[0]['list_user_id_slash'];
		$list_user_id_read = $lastNotify[0]['list_user_id_read'];
		$lst_user_id_slash = !empty($list_user_id_slash) ? $clsISO->getArrayByTextSlash($list_user_id_slash) : array();
		$lst_user_id_read = !empty($list_user_id_read) ? $clsISO->getArrayByTextSlash($list_user_id_read) : array();
		if(in_array($_loged_id,$lst_user_id_slash) && !in_array($_loged_id,$lst_user_id_read)){
			$clsNotification->updateOne($lastNotify[0][$clsNotification->pkey],array(
				'list_user_id_read'	=> $list_user_id_read."|{$_loged_id}|"
			));
		}*/
	}
	$lst_reply = array_filter($isocms_ticket, function ($v) use ($ticket_id) {
		return $v['parent_id'] == $ticket_id;
	});
	$lst_reply = array_reverse($lst_reply, 1);
	//$clsISO->pre($lst_reply);die;
	$assign_list["ticket_id"] = $ticket_id;
	$assign_list["oneTicket"] = $oneTicket;
	$assign_list["lst_reply"] = $lst_reply;
}
function default_detail_ticket2()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser, $clsUser;
	//die('xx');
	//ini_set( "display_errors", 1);
	$ticket_id = Input::get('ticket_id', 0);
	$ym = explode("_", $ticket_id)[0];
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	// print_r($isocms_ticket);die();
	$oneTicket = $isocms_ticket[$ticket_id];
	$oneUser = $clsUser->getOne($_loged_id, "full_name,first_name,last_name,email");

	$full_name = !empty($oneUser['full_name']) ? $oneUser['full_name'] : $oneUser['first_name'] . ' ' . $oneUser['last_name'];
	//$clsISO->pre($full_name);die();
	$assign_list["full_name"] = $full_name;
	$assign_list["oneUser"] = $oneUser;
	$email = $oneUser['email'] ? $oneUser['email'] : $full_name;
	if (!in_array($_loged_id, $oneTicket['user_read'])) { //lưu user_read, khi có ansewerd hoặc thay đổi trạng thái thì clear user_read
		if (@file_exists(DIR_INCLUDES . '/json_master/autoload.php')) {
			require_once(DIR_INCLUDES . '/json_master/autoload.php');
		}
		$oneTicket['user_read'][] = $_loged_id;
		$isocms_ticket[$ticket_id] = $oneTicket;
		$file_cached = DIR_JSON_TICKET . 'isocms_ticket_' . $ym . '.json';
		$encoder = new Webmozart\Json\JsonEncoder();
		$encoder->encodeFile($isocms_ticket, $file_cached);
		#lưu thông tin user read cho các ansewer admin
		$project_id = OKRS_PROJECT_ID;
		if ($clsISO->getVar('OKRS_PROJECT_ID')) {
			$clsVSOkrsSDK = new VSOkrsSDK();

			$params = array(
				"ym"	=> $ym,
				"project_id"	=> $project_id,
				"ticket_id"	=> $ticket_id,
				"user_id"	=> $_loged_id,
				"user_email"	=> $email,
			);
			$res = $clsVSOkrsSDK->post('/api/read_ticket_isocms', @json_encode($params, JSON_UNESCAPED_UNICODE));
		}
		#notify read
		/*$clsNotification = new Notification();
		$lastNotify = $clsNotification->GetAll("is_trash=0 and tp='ticket' and ticket_id='".$ticket_id."' and list_user_id_slash like '%|$_loged_id|%' 
		and list_user_id_read not like '%|$_loged_id|%' order by reg_date DESC limit 0,1");
		$list_user_id_slash = $lastNotify[0]['list_user_id_slash'];
		$list_user_id_read = $lastNotify[0]['list_user_id_read'];
		$lst_user_id_slash = !empty($list_user_id_slash) ? $clsISO->getArrayByTextSlash($list_user_id_slash) : array();
		$lst_user_id_read = !empty($list_user_id_read) ? $clsISO->getArrayByTextSlash($list_user_id_read) : array();
		if(in_array($_loged_id,$lst_user_id_slash) && !in_array($_loged_id,$lst_user_id_read)){
			$clsNotification->updateOne($lastNotify[0][$clsNotification->pkey],array(
				'list_user_id_read'	=> $list_user_id_read."|{$_loged_id}|"
			));
		}*/
	}
	$lst_reply = array_filter($isocms_ticket, function ($v) use ($ticket_id) {
		return $v['parent_id'] == $ticket_id;
	});
	$lst_reply = array_reverse($lst_reply, 1);
	//$clsISO->pre($lst_reply);die;
	$assign_list["ticket_id"] = $ticket_id;
	$assign_list["oneTicket"] = $oneTicket;
	$assign_list["lst_reply"] = $lst_reply;
}
function default_ajCloseTicket()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser;
	$ticket_id = Input::post('ticket_id', '');
	$ym = explode("_", $ticket_id)[0];
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	$oneTicket = $isocms_ticket[$ticket_id];
	if (@file_exists(DIR_INCLUDES . '/json_master/autoload.php')) {
		require_once(DIR_INCLUDES . '/json_master/autoload.php');
	}
	$oneTicket['status'] = '6closed';
	$oneTicket['upd_date'] = time();
	$isocms_ticket[$ticket_id] = $oneTicket;
	$file_cached = DIR_JSON_TICKET . 'isocms_ticket_' . $ym . '.json';
	$encoder = new Webmozart\Json\JsonEncoder();
	$encoder->encodeFile($isocms_ticket, $file_cached);
	$project_id = OKRS_PROJECT_ID;
	if ($clsISO->getVar('OKRS_PROJECT_ID')) {
		$clsVSOkrsSDK = new VSOkrsSDK();
		$params = array(
			"ym"	=> $ym,
			"project_id"	=> $project_id,
			"ticket_id"	=> $ticket_id,
			"oneTicket"	=> $oneTicket,
		);
		$res = $clsVSOkrsSDK->post('/api/close_ticket_isocms', @json_encode($params, JSON_UNESCAPED_UNICODE));
	}
	echo json_encode(array(
		"msg"	=> "ok",
		"ticket_id"	=> $ticket_id
	));
	die;
}
function default_ajSubmitReplyTicket()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $_loged_id, $oneUser, $clsUser;
	$ticket_id = Input::post('ticket_id', '');
	$content_reply = Input::post('content_reply', '');
	$content_reply = $clsISO->parseImageInContent($content_reply);
	$oneUser = $clsUser->getOne($_loged_id, "email,full_name,first_name,last_name"); //avatar
	$full_name = !empty($oneUser['full_name']) ? $oneUser['full_name'] : $oneUser['first_name'] . ' ' . $oneUser['last_name'];
	$email = $oneUser['email'] ? $oneUser['email'] : $full_name;
	$domain_name = DOMAIN_NAME;
	$project_id = OKRS_PROJECT_ID;
	$ym = explode("_", $ticket_id)[0];
	$isocms_ticket = $clsISO->getISOCMSTicket($ym);
	$reply_id = $clsISO->getUniqid(1, $ym . '_');
	$file_attach = '';
	$datastore_folder = '';
	if (is_uploaded_file($_FILES['file_attach']['tmp_name'])) {
		$clsUploadFile = new UploadFile();
		$file_attach = $clsUploadFile->uploadItem($_FILES["file_attach"], "/file_attach", EXTENSION_FILE_UPLOAD);
	}
	if (@file_exists(DIR_INCLUDES . '/json_master/autoload.php')) {
		require_once(DIR_INCLUDES . '/json_master/autoload.php');
	}
	$oneReply = array(
		//"code"	=> $code,
		//"title"	=> $title_ticket,
		"content"	=> $content_reply,
		"file_attach"	=> $clsISO->parseImageInContent($file_attach, 0),
		//"cat"	=> $cat_ticket,
		//"status"	=> '1open',
		"parent_id"	=> $ticket_id,
		"user_id"	=> $_loged_id,
		"user_name"	=> $full_name,
		"user_email"	=> $email,
		"user_avatar"	=> '',
		"domain_name"	=> $domain_name,
		"project_id"	=> $project_id,
		"reg_date"	=> time(),
		//"user_read"	=> array($_loged_id),
		//"admin_read"	=> array(),
	);
	$isocms_ticket[$reply_id] = $oneReply;
	#
	$oneTicket = $isocms_ticket[$ticket_id];
	$oneTicket['status'] = '3cus_rep';
	$oneTicket['user_read'] = array($_loged_id);
	$oneTicket['upd_date'] = time();
	$isocms_ticket[$ticket_id] = $oneTicket;
	#
	$file_cached = DIR_JSON_TICKET . 'isocms_ticket_' . $ym . '.json';
	$encoder = new Webmozart\Json\JsonEncoder();
	$encoder->encodeFile($isocms_ticket, $file_cached);
	if ($clsISO->getVar('OKRS_PROJECT_ID')) {
		$clsVSOkrsSDK = new VSOkrsSDK();
		$params = array(
			"ym"	=> $ym,
			"project_id"	=> $project_id,
			"ticket_id"	=> $ticket_id,
			"reply_id"	=> $reply_id,
			"oneReply"	=> $oneReply,
		);
		$res = $clsVSOkrsSDK->post('/api/reply_ticket_isocms', @json_encode($params, JSON_UNESCAPED_UNICODE));
	}
	echo json_encode(array(
		"msg"	=> "ok",
		"ticket_id"	=> $ticket_id,
		"reply_id"	=> $reply_id,
	));
	die;
}
function default_sendEmailReplyTicket()
{
	global $smarty, $dbconn, $clsISO, $_loged_id, $oneUser, $clsUser;
	$ticket_id = Input::post('ticket_id', 0);
	$reply_id = Input::post('reply_id', 0);
	$ym = explode("_", $ticket_id)[0];
	$tms_ticket = $clsISO->getISOCMSTicket($ym);
	$oneTicket = $tms_ticket[$ticket_id];
	$oneReply = $tms_ticket[$reply_id];
	$is_send_email = $clsISO->sendEmailReplyTicket($ticket_id, $oneTicket, $oneReply);
	echo json_encode(array(
		"msg"	=> "ok",
		"is_send_email"	=> $is_send_email
	));
	die;
}
function default_ajGetBadgeUnreadTicket()
{
	global $smarty, $dbconn, $clsISO, $_loged_id, $oneUser;
	$isocms_ticket = $clsISO->getISOCMSTicket();
	$lst_unread = array_filter($isocms_ticket, function ($v) use ($_loged_id) {
		return $v['parent_id'] == 0 && !in_array($_loged_id, $v['user_read']);
	});
	$total_unread = !empty($lst_unread) ? count($lst_unread) : 0;
	if ($total_unread > 5) {
		$total_unread = "5+";
	}
	echo json_encode(array(
		"msg"	=> "ok",
		"total_unread"	=> $total_unread
	));
	die;
}
