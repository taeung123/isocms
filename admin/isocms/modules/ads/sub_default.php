<?php
function default_default()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];

	if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
		header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
		exit();
	}
	#
	if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
		$link = '';
		if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
			$link .= '&keyword=' . $_POST['keyword'];
		}
		header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
	}
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Ads";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	$assign_list["pkeyTable"] = $pkeyTable;

	/*List all item*/
	$cond = "1=1";
	#Filter By Keyword
	if (isset($_GET['keyword'])) {
		if ($_GET['keyword'] != '') {
			$keyword = $core->replaceSpace($_GET['keyword']);
			$cond .= " and slug like '%" . $keyword . "%'";
			$assign_list["keyword"] = $_GET['keyword'];
		}
	}
	$cond2 = $cond;
	if ($type_list == 'Active') {
		$cond .= " and is_trash=0";
	}
	if ($type_list == 'Trash') {
		$cond .= " and is_trash=1";
	}
	$orderBy = " order_no desc";

	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 10;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
	$start_limit = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i = 1; $i <= $totalPage; $i++) {
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&', $query_string);
	$link_page_current = '';
	for ($i = 0; $i < count($lst_query_string); $i++) {
		$tmp = explode('=', $lst_query_string[$i]);
		if ($tmp[0] != 'page')
			$link_page_current .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	#
	$link_page_current_2 = '';
	for ($i = 0; $i < count($lst_query_string); $i++) {
		$tmp = explode('=', $lst_query_string[$i]);
		if ($tmp[0] != 'page' && $tmp[0] != 'type_list')
			$link_page_current_2 .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
	}
	$assign_list['link_page_current_2'] = $link_page_current_2;
	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
	$assign_list["allItem"] = $allItem;
	#
	$allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
	$assign_list["number_trash"] = count($allTrash) ?? 0;
	#
	$allUnTrash =  $clsClassTable->getAll("is_trash=0 and " . $cond2);
	$assign_list["number_item"] = count($allUnTrash) ?? 0;
	#
	$allAll =  $clsClassTable->getAll($cond2);
	$assign_list["number_all"] = count($allAll) ?? 0;
}
function default_edit()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
	global $core, $clsModule, $clsButtonNav, $dbconn;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	#
	$clsAdsGroup = new AdsGroup();
	$assign_list["clsAdsGroup"] = $clsAdsGroup;
	$lstAdsGroup = $clsAdsGroup->getAll("is_trash=0 and parent_id='0' order by order_no asc");
	$assign_list["lstAdsGroup"] = $lstAdsGroup;
	#
	$classTable = "Ads";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	$string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string));
	$assign_list['pvalTable'] = $pvalTable;
	$assign_list['pkeyTable'] = $pkeyTable;

	#
	$oneItem = $clsClassTable->getOne($pvalTable);
	$assign_list["oneItem"] = $oneItem;

	#------------------------
	if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
		if ($pvalTable > 0) {
			$value = "";
			$firstAdd = 0;
			foreach ($_POST as $key => $val) {
				$tmp = explode('-', $key);
				if ($tmp[0] == 'iso') {
					if ($firstAdd == 0) {
						$value .= $tmp[1] . "='" . addslashes($val) . "'";
						$firstAdd = 1;
					} else {
						$value .= "," . $tmp[1] . "='" . addslashes($val) . "'";
					}
				}
			}
			#--Special Field: slug
			$value .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";
			$value .= ",upd_date='" . time() . "',user_id='" . $user_id . "'";
			#
			$lstGroup = $_POST['lstGroup'];
			if (!empty($lstGroup)) {
				$list_id = '|';
				for ($i = 0; $i < count($lstGroup); $i++) {
					$list_id .= $lstGroup[$i] . '|';
				}
				$value .= ",list_id='" . addslashes($list_id) . "'";
			} else {
				$value .= ",list_id=''";
			}

			#--Special Field: image
			$image_src = $_POST['image_src'];
			if (_isoman_use) {
				$image_src = $_POST['isoman_url_image'];
			}
			if ($image_src != '' && $image_src != '0') {
				$value .= ",image='" . addslashes($image_src) . "'";
			}

			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$value .= ",is_online='" . $is_online . "'";

			if ($clsClassTable->updateOne($pvalTable, $value)) {
				if ($_POST['button'] == '_NEW') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=new&message=UpdateSuccess');
				} else if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=UpdateSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=updateFailed');
			}
		} else {
			$value = "";
			$firstAdd = 0;
			$field = "";
			foreach ($_POST as $key => $val) {
				$tmp = explode('-', $key);
				if ($tmp[0] == 'iso') {
					if ($firstAdd == 0) {
						$field .= $tmp[1];
						$value .= "'" . addslashes($val) . "'";
						$firstAdd = 1;
					} else {
						$field .= ',' . $tmp[1];
						$value .= ",'" . addslashes($val) . "'";
					}
				}
			}
			#--Special Field: slug
			$field .= ',slug';
			$value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "'";
			#
			$lstGroup = $_POST['lstGroup'];
			if (!empty($lstGroup)) {
				$list_id = '|';
				for ($i = 0; $i < count($lstGroup); $i++) {
					$list_id .= $lstGroup[$i] . '|';
				}
				$field .= ',list_id';
				$value .= ",'" . addslashes($list_id) . "'";
			}
			#--Special Field: order_no
			$max_order_no = $clsClassTable->getMaxOrderNo();
			$max_id = $clsClassTable->getMaxId();
			$field .= ',order_no,ads_id';
			$value .= ",'" . $max_order_no . "','" . $max_id . "'";
			$field .= ',reg_date,upd_date,user_id';
			$value .= ",'" . time() . "','" . time() . "','" . $user_id . "'";

			#--Special Field: image
			$image_src = $_POST['image_src'];
			if (_isoman_use) {
				$image_src = $_POST['isoman_url_image'];
			}
			if ($image_src != '' && $image_src != '0') {
				$field .= ',image';
				$value .= ",'" . addslashes($image_src) . "'";
			}
			$is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
			$field .= ',is_online';
			$value .= ",'" . $is_online . "'";

			if ($clsClassTable->insertOne($field, $value)) {
				if ($_POST['button'] == '_NEW') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=new&message=InsertSuccess');
				} else if ($_POST['button'] == '_EDIT') {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=InsertSuccess');
				} else {
					header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=InsertSuccess');
				}
			} else {
				header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
			}
		}
	}
}
function default_trash()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Ads";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=TrashSuccess');
	}
}
function default_restore()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Ads";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=RestoreSuccess');
	}
}
function default_delete()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Ads";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";

	if ($pvalTable == "")
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');

	if ($clsClassTable->doDelete($pvalTable)) {
		header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
	}
}

function default_move()
{
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Ads";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;

	$pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
	$direct = isset($_GET['direct']) ? $_GET['direct'] : '';

	$one = $clsClassTable->getOne($pvalTable);
	$parent_id = $one['parent_id'];
	$country_id = $one['country_id'];
	$order_no = $one['order_no'];

	if ($pvalTable == "" || $direct == '') {
		header('location: ' . PCMS_URL . '/?mod=' . $mod);
	}

	$where = '1=1 and is_trash=0 ';
	if ($direct == 'movedown') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'moveup') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
		$clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
	}
	if ($direct == 'movebottom') {
		$lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
		}
	}
	if ($direct == 'movetop') {
		$lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
		$clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
		$lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
		for ($i = 0; $i < count($lstItem); $i++) {
			$clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
		}
	}
	header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=PositionSuccess');
}
/*
	@ Ads Group
*/
/* ======== SITE ADS GROUP ========== */
function default_ajSiteAdsGroup()
{
	global $core, $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsModule, $clsISO, $_LANG_ID;
	$user_id = $core->_USER['user_id'];
	#
	$clsPagination = new Pagination();
	$clsAdsGroup = new AdsGroup();
	#
	$tp = isset($_POST['tp']) ? $_POST['tp'] : '';
	$ads_group_id = isset($_POST['ads_group_id']) ? intval($_POST['ads_group_id']) : 0;
	$parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
	#
	if ($tp == 'L') {
		$number_per_page = isset($_POST['number_per_page']) ? $_POST['number_per_page'] : 10;
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
		#
		$where = "is_trash=0 and parent_id=0";
		$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
		if (isset($keyword) && $keyword != '') {
			$slug = $core->replaceSpace($keyword);
			$where .= " and (slug like '%$slug%' or title like '%$keyword%')";
		}
		$totalRecord = $clsAdsGroup->countItem($where);
		$pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page);
		$offset = ($page - 1) * $number_per_page;
		$where .= " ORDER BY order_no desc";
		$where .= " LIMIT $offset,$number_per_page";
		#
		$lstItem = $clsAdsGroup->getAll($where);
		if (is_array($lstItem) && count($lstItem) > 0) {
			$i = 0;
			foreach ($lstItem as $item) {
				$html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
				$html .= '<td class="index">' . ($i + 1) . '</td>';
				$html .= '<td>' . $item[$clsAdsGroup->pkey] . '</td>';
				$html .= '<td><strong>' . $clsAdsGroup->getTitle($item[$clsAdsGroup->pkey]) . '</strong></td>';
				$html .= '<td><strong>' . $clsAdsGroup->getIntro($item[$clsAdsGroup->pkey]) . '</strong></td>';
				$html .= '<td style="text-align:center"><strong>' . $clsAdsGroup->getSize($item[$clsAdsGroup->pkey]) . '</strong></td>';
				$html .= '<td style="text-align:center"><a href="javascript:void(0);" class="SiteClickPublic" clsTable="AdsGroup" pkey="ads_group_id" sourse_id="' . $item[$clsAdsGroup->pkey] . '" rel="' . $clsAdsGroup->getOneField('is_online', $item[$clsAdsGroup->pkey]) . '" title="' . $core->get_Lang('Click to change status') . '">' . ($clsAdsGroup->getOneField('is_online', $item[$clsAdsGroup->pkey]) == 1 ? '<i class="fa fa-check-circle green"></i>' : '<i class="fa fa-minus-circle red"></i>') . '</a></td>';
				$html .= '<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '" class="ajMoveAdsGroup" direct="movetop" parent_id="' . $item['parent_id'] . '" data="' . $item[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="ajMoveAdsGroup" direct="movebottom" parent_id="' . $item['parent_id'] . '" data="' . $item[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="ajMoveAdsGroup" direct="moveup" parent_id="' . $item['parent_id'] . '" data="' . $item[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="ajMoveAdsGroup" direct="movedown" parent_id="' . $item['parent_id'] . '" data="' . $item[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '</td>';
				$html .= '
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a class="ajEditAdsGroup" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $item[$clsAdsGroup->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
								<li><a class="ajDeleteAdsGroup" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $item[$clsAdsGroup->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
							</ul>
						</div>
					</td>';
				$html .= '</tr>';
				$lstChild = $clsAdsGroup->getAll("is_trash=0 and parent_id='" . $item[$clsAdsGroup->pkey] . "' order by order_no desc");
				if (!empty($lstChild)) {
					$j = 0;
					foreach ($lstChild as $item_child) {
						$html .= '<tr>';
						$html .= '<td class="index"></td>';
						$html .= '<td>' . $item_child[$clsAdsGroup->pkey] . '</td>';
						$html .= '<td><strong>---- ' . $clsAdsGroup->getTitle($item_child[$clsAdsGroup->pkey]) . '</strong></td>';
						$html .= '<td><strong>' . $clsAdsGroup->getIntro($item_child[$clsAdsGroup->pkey]) . '</strong></td>';
						$html .= '<td style="text-align:center"><strong>' . $clsAdsGroup->getSize($item_child[$clsAdsGroup->pkey]) . '</strong></td>';
						$html .= '<td style="text-align:center"><a href="javascript:void(0);" class="SiteClickPublic" clsTable="AdsGroup" pkey="ads_group_id" sourse_id="' . $item_child[$clsAdsGroup->pkey] . '" rel="' . $clsAdsGroup->getOneField('is_online', $item_child[$clsAdsGroup->pkey]) . '" title="' . $core->get_Lang('Click to change status') . '">' . ($clsAdsGroup->getOneField('is_online', $item_child[$clsAdsGroup->pkey]) == 1 ? '<i class="fa fa-check-circle green"></i>' : '<i class="fa fa-minus-circle red"></i>') . '</a></td>';
						$html .= '<td style="vertical-align: middle;text-align:center">
								' . ($j == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '" class="ajMoveAdsGroup" direct="movetop" parent_id="' . $clsAdsGroup->getOneField('parent_id', $item_child[$clsAdsGroup->pkey]) . '" data="' . $item_child[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
							</td>
							<td style="vertical-align: middle;text-align:center">' . ($j == count($lstChild) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="ajMoveAdsGroup" direct="movebottom" parent_id="' . $clsAdsGroup->getOneField('parent_id', $item_child[$clsAdsGroup->pkey]) . '" data="' . $item_child[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
							</td>
							<td style="vertical-align: middle;text-align:center">' . ($j == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="ajMoveAdsGroup" direct="moveup" parent_id="' . $clsAdsGroup->getOneField('parent_id', $item_child[$clsAdsGroup->pkey]) . '" data="' . $item_child[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
							</td>
							<td style="vertical-align: middle;text-align:center">' . ($j == count($lstChild) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="ajMoveAdsGroup" direct="movedown" parent_id="' . $clsAdsGroup->getOneField('parent_id', $item_child[$clsAdsGroup->pkey]) . '" data="' . $item_child[$clsAdsGroup->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '</td>';
						$html .= '
							<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
								<div class="btn-group">
									<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
									<ul class="dropdown-menu" style="right:0px !important">
										<li><a class="ajEditAdsGroup" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $item_child[$clsAdsGroup->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
										<li><a class="ajDeleteAdsGroup" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $item_child[$clsAdsGroup->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
									</ul>
								</div>
							</td>';
						$html .= '</tr>';
						++$j;
					}
				}
				++$i;
			}
		} else {
			$html = '<tr><td style="text-align:center" colspan="15">' . $core->get_Lang('nodata') . '</td></tr>';
		}
		echo $html . '$$' . $pageview;
		die();
	} else if ($tp == 'F') {
		$oneItem = $clsAdsGroup->getOne($ads_group_id);
		$html = '<div class="headPop">
				<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
				<h3>' . (intval($ads_group_id) > 0 ? $core->get_Lang('edit') : $core->get_Lang('add')) . ' ' . $core->get_Lang('adsgroup') . '</h3>
			</div>';
		$html .= '
		<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel"><b class="color_r">* ' . $core->get_Lang('category') . '</b></div>
					<div class="fieldarea">
						<select name="parent_id" class="slb" style="padding:3px;">
							' . $clsAdsGroup->makeSelectOption($oneItem['parent_id']) . '
						</select>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><b class="color_r">* ' . $core->get_Lang('title') . '</b></div>
					<div class="fieldarea"><input class="text full required" value="' . $oneItem['title'] . '" name="title" type="text"></div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><b class="color_r">* ' . $core->get_Lang('code') . '</b></div>
					<div class="fieldarea"><input class="text full required" value="' . $oneItem['_code'] . '" name="code" type="text"></div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><b class="color_r">* ' . $core->get_Lang('size') . '</b></div>
					<div class="fieldarea">
						<input class="text full required" value="' . $oneItem['_width'] . '" name="width" type="text" style="width:15%">&nbsp;x&nbsp;
						<input class="text full required" value="' . $oneItem['_height'] . '" name="height" type="text" style="width:15%">
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">' . $core->get_Lang('intro') . '</div>
					<div class="fieldarea">
						<textarea class="textarea full" name="intro" rows="3">' . $oneItem['intro'] . '</textarea>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" ads_group_id="' . $ads_group_id . '" class="btn btn-primary ajSubmitAdsGroup">
				<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
			</button>
		</div>';
		echo ($html);
		die();
	} else if ($tp == 'S') {
		$title = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
		$slug = $core->replaceSpace($title);
		$code = isset($_POST['code']) ? trim(strip_tags($_POST['code'])) : '';
		$width = isset($_POST['width']) ? trim(strip_tags($_POST['width'])) : '';
		$height = isset($_POST['height']) ? trim(strip_tags($_POST['height'])) : '';
		$intro = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
		#
		if (intval($ads_group_id) == '0') {
			if (!empty($clsAdsGroup->countItem("slug='$slug' and parent_id='$parent_id'"))) {
				echo '_EXIST';
				die();
			} else {
				$f = "user_id,user_id_update,parent_id,_code,title,slug,_width,_height,intro,order_no,reg_date,upd_date";
				$v = "'$user_id','$user_id','$parent_id','$code','$title','$slug','$width','$height','$intro','" . $clsAdsGroup->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
				if ($clsAdsGroup->insertOne($f, $v)) {
					echo '_INSERT_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		} else {
			if (!empty($clsAdsGroup->countItem("slug='$slug' and parent_id='$parent_id' and ads_group_id <> '$ads_group_id'"))) {
				echo '_EXIST';
				die();
			} else {
				$v = "parent_id='$parent_id',_code='$code',title='$title',slug='$slug',_width='$width',_height='$height',intro='$intro',upd_date='" . time() . "',user_id_update='$user_id'";
				if ($clsAdsGroup->updateOne($ads_group_id, $v)) {
					echo '_UPDATE_SUCCESS';
					die();
				} else {
					echo '_ERROR';
					die();
				}
			}
		}
	} else if ($tp == 'D') {
		$clsAdsGroup->deleteOne($ads_group_id);
		echo (1);
		die();
	} else if ($tp == 'M') {
		$one = $clsAdsGroup->getOne($ads_group_id);
		$order_no = $one['order_no'];
		$direct = isset($_POST['direct']) ? $_POST['direct'] : '';
		#
		$cond = 'is_trash=0 and parent_id=' . $parent_id;
		#
		if ($direct == 'moveup') {
			$lst = $clsAdsGroup->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
			$clsAdsGroup->updateOne($ads_group_id, "order_no='" . $lst[0]['order_no'] . "'");
			$clsAdsGroup->updateOne($lst[0][$clsAdsGroup->pkey], "order_no='" . $order_no . "'");
		}
		if ($direct == 'movedown') {
			$lst = $clsAdsGroup->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
			$clsAdsGroup->updateOne($ads_group_id, "order_no='" . $lst[0]['order_no'] . "'");
			$clsAdsGroup->updateOne($lst[0][$clsAdsGroup->pkey], "order_no='" . $order_no . "'");
		}
		if ($direct == 'movetop') {
			$lst = $clsAdsGroup->getAll($cond . " and order_no > $order_no order by order_no asc");
			$clsAdsGroup->updateOne($ads_group_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
			$lstItem = $clsAdsGroup->getAll($cond . " and ads_group_id <> '$ads_group_id' and order_no > $order_no order by order_no asc");
			for ($i = 0; $i < count($lstItem); $i++) {
				$clsAdsGroup->updateOne($lstItem[$i][$clsAdsGroup->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
			}
		}
		if ($direct == 'movebottom') {
			$lst = $clsAdsGroup->getAll($cond . " and order_no < $order_no order by order_no desc");
			$clsAdsGroup->updateOne($ads_group_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
			$lstItem = $clsAdsGroup->getAll($cond . " and ads_group_id <> '$ads_group_id' and order_no < $order_no order by order_no asc");
			for ($i = 0; $i < count($lstItem); $i++) {
				$clsAdsGroup->updateOne($lstItem[$i][$clsAdsGroup->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
			}
		}
		echo (1);
		die();
	}
}
require_once(DIR_MODULES . '/ads/mod_default.php');
