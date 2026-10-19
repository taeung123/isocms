<?php
function default_default()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;

    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];

    $classTable = "Property";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $listType = $clsClassTable->getListType();
    $assign_list["listType"] = $listType;
    #
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $assign_list["type"] = $type;
    ini_set('display_errors', 1);
    error_reporting(E_ERROR & ~E_STRICT); //E_ALL

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default', $type)) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($_POST['type'] != '') {
            $link .= '&type=' . $_POST['type'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Transport title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        if ($_POST['parent_id'] != '') {
            $link .= '&parent_id=' . $_POST['parent_id'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    $cond = "1='1'";
    $cond .= " and type='$type' and parent_id=0";
    #Filter By Keyword
    if ($_GET['keyword'] != '') {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and (title like '%" . $keyword . "%' or slug like '%" . $keyword . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }

    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    //	echo $cond;die;
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
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


    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['property_id']) ? ($_GET['property_id']) : '';
        $property_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $property_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&type=' . $type . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($property_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=' . $type . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['property_id']) ? ($_GET['property_id']) : '';
        $property_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $property_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&type=' . $type . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($property_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=' . $type . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['property_id']) ? ($_GET['property_id']) : '';
        $property_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $property_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&type=' . $type . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($property_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&type=' . $type . $pUrl . '&message=DeleteSuccess');
        }
    }
    #-------End Page Divide-----------------------------------------------------------
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    #
    $allTrash =  $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash =  $clsClassTable->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll =  $clsClassTable->getAll($cond2);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
}
function default_ajUpdPosSortProperty()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    #
    $clsTourProperty = new TourProperty();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourProperty->updateOne($val, "order_no='" . $key . "'");
    }
}
function default_delete()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Why";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";

    if ($pvalTable == "")
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
    if ($_POST['agree'] == 'agree') {
        if ($clsClassTable->deleteOne($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=DeleteSuccess');
        }
    }
}
function default_ajMoveProperty()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];

    $classTable = "Property";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_POST[$pkeyTable]) ? $_POST[$pkeyTable] : "";
    $direct = isset($_POST['direct']) ? $_POST['direct'] : '';

    $one = $clsClassTable->getOne($pvalTable);
    $parent_id = $one['parent_id'];
    $order_no = $one['order_no'];

    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }

    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }

    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll("parent_id='$parent_id' and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    echo (1);
    die();
}
function default_ajLoadFormAddProperty()
{
    global $core, $_LANG_ID, $clsISO;
    #
    $clsProperty = new Property();
    $clsHotelProperty = new HotelProperty();
    $clsCountryEx = new Country();
    $parent_id = $_POST['parent_id'];
    $type = $_POST['type'];
    $style = '';
    #
    if ($type != "HotelFacilities") $style = 'style="display:none"';
    if ($type == "HotelCategory") {
        $html = '
		<div class="headPop headPop2">
			<a href="javascript:void();" title="Đóng" class="closeEv close_pop">&nbsp;</a>
			<h3>' . $core->get_Lang('Add New Hotel Cateogry') . '</h3> 
		</div>
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea span20" style="text-align:right"><strong>' . $core->get_Lang('Title') . '</strong></td>
				<td class="fieldarea">
					<input placeholder="' . $core->get_Lang('Enter name of') . ' ' . $core->get_Lang($type) . '" type="text" name="title" id="title" class="required fontLarge form-control full text"/>
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-primary submitClick" id="clickSubmitHotelProperty" property_id="0">' . $core->get_Lang('Submit') . '</button> 
			<button class="btn btn-warning clickToClose close_pop" data-dismiss="modal" aria-hidden="true">' . $core->get_Lang('Close') . '</button> 
		</div>';
    } else {
        $html = '
		<div class="headPop headPop2">
			<a href="javascript:void();" title="Đóng" class="closeEv close_pop">&nbsp;</a>
			<h3>' . $core->get_Lang('Add New') . ' ' . $clsProperty->getTextByType($type) . '</h3> 
		</div>
		<table class="form" cellpadding="3" cellspacing="3">
			<tr>
				<td class="fieldarea span20" style="text-align:right"><strong>' . $core->get_Lang('Title') . '</strong></td>
				<td class="fieldarea">
					<input placeholder="' . $core->get_Lang('Enter name of') . ' ' . $core->get_Lang($type) . '" type="text" name="title" id="title" class="required fontLarge form-control full text"/>
				</td>
			</tr>';
        if ($type == 'StatusPayment') {
            $html .= '
                <tr>
                <td class="fieldarea span15" style="text-align:right"><strong>' . $core->get_Lang('Deposit') . '</strong></td>
                <td class="fieldarea">
                    <input type="number" min=0 id="deposit" name="deposit" class="fontLarge form-control full text" value="100">
                </td>
            </tr>
            ';
        }
        if ($type == 'Market') {
            $lstMarket = $clsProperty->getAll('is_trash=0 AND parent_id=0 AND type="Market"', $clsProperty->pkey . ',title');
            if ($lstMarket) {
                $html .= '<tr>
								<td class="fieldarea span15">' . $core->get_Lang('Market parent') . '</td>
								<td class="fieldarea">
									<select name="parent_id" id="parent_id" class="form-control">
									<option value="0">' . $core->get_Lang('Choose market') . '</option>';
                foreach ($lstMarket as $key => $value) {
                    $html .= '<option  value="' . $value['property_id'] . '">' . $value['title'] . '</option>';
                }
                $html .= '</select></td></tr>';
            }

            $lstCountryEx = $clsCountryEx->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsCountryEx->pkey . ',title');
            if ($lstCountryEx) {
                $html .= '<tr id="CountryID">
								<td class="fieldarea span15">' . $core->get_Lang('Country') . '</td>
								<td class="fieldarea">
									<select name="country_id" id="country_id" class="form-control required">
									<option value="">' . $core->get_Lang('Choose country') . '</option>';
                foreach ($lstCountryEx as $key => $value) {
                    $html .= '<option  value="' . $value['country_id'] . '">' . $value['title'] . '</option>';
                }
                $html .= '</select></td></tr>';
            }
        }
        $html .= '<tr style="display:none">
				<td class="fieldarea">
					<select class="slb" id="type">
						' . $clsProperty->getSelectByType($type) . '
					</select>
				</td>
			</tr>
            <tr ' . $style . '>
                <td class="fieldarea span15" style="text-align:right"><strong>' . $core->get_Lang('Category') . '</strong></td>
                <td class="fieldarea">
                    <select class="slb" id="cat_id" name="cat_id">
                        ' . $clsHotelProperty->getSelectByHotelCat() . '
                    </select>
                </td>
            </tr>
			<tr ' . $style . '>
				<td class="fieldarea" style="text-align:right"><strong>' . $core->get_Lang('Image icon') . '</strong></td>
				<td class="fieldarea">
					<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsProperty->getOneField('image', $property_id ?? 0) . '" width="40" height="40" />
					<input type="hidden" id="isoman_hidden_image" value="' . $clsProperty->getOneField('image', $property_id ?? 0) . '">
					<input style="width:70% !important;float:left;margin-left:4px;" class="form-control" type="text" id="isoman_url_image" name="image" value="' . $clsProperty->getOneField('image', $property_id ?? 0) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsProperty->getOneField('image', $property_id ?? 0) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</td>
			</tr>

			<tr style="display:none">
				<td class="fieldarea" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong></td>
				<td class="fieldarea">
					<textarea class="textarea full" rows="5" name="intro">' . $clsProperty->getIntro($property_id ?? 0) . '</textarea>
				</td>
			</tr>
		</table>
		<div class="modal-footer"> 
			<button class="btn btn-primary submitClick" id="clickSubmitProperty" property_id="0">' . $core->get_Lang('Submit') . '</button> 
			<button class="btn btn-warning clickToClose close_pop" data-dismiss="modal" aria-hidden="true">' . $core->get_Lang('Close') . '</button> 
		</div>';
    }
    echo ($html);
    die();
}
function default_ajLoadFormEditProperty()
{
    global $core, $_LANG_ID, $clsISO;
    #
    $clsProperty = new Property();
    $clsHotelProperty = new HotelProperty();
    $clsCountryEx = new Country();
    $property_id = $_POST['property_id'];
    $type = $_POST['type'];
    $oneItem = $clsProperty->getOne($property_id);

    #
    if ($type == "HotelCategory") {
        $html = '
        <div class="headPop headPop2">
            <a href="javascript:void();" title="Đóng" class="closeEv close_pop">&nbsp;</a>
            <h3 id="myModalLabel">' . $core->get_Lang('Edit Hotel Category') . '</h3> 
        </div>
        <table class="form" cellpadding="3" cellspacing="3">
            <tr>
                <td class="fieldarea span15" style="text-align:right"><strong>' . $core->get_Lang('Title') . '</strong></td>
                <td class="fieldarea">
                    <input type="text" id="title" name="title" value="' . $clsHotelProperty->getTitle($property_id) . '" class="fontLarge form-control full text">
                </td>
            </tr>';

        $html .= '</table>
        <div class="modal-footer"> 
            <button class="btn btn-primary submitClick" id="clickSubmitHotelProperty" property_id="' . $property_id . '">
                ' . $core->get_Lang('Submit') . '
            </button> 
            <button class="btn btn-warning clickToClose" data-dismiss="modal" aria-hidden="true">' . $core->get_Lang('Close') . '</button> 
        </div>';
    } elseif ($type == "HotelFacilities") {
        $html = '
	<div class="headPop headPop2">
		<a href="javascript:void();" title="Đóng" class="closeEv close_pop">&nbsp;</a>
		<h3 id="myModalLabel">' . $core->get_Lang('Edit') . ' ' . $clsProperty->getTextByType($type) . '</h3> 
	</div>
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea span15" style="text-align:right"><strong>' . $core->get_Lang('Title') . '</strong></td>
			<td class="fieldarea">
				<input type="text" id="title" name="title" value="' . $clsProperty->getTitle($property_id) . '" class="fontLarge form-control full text">
			</td>
		</tr>
		<tr style="display:none">
			<td class="fieldarea">
				<select class="slb" id="type">
					' . $clsProperty->getSelectByType($clsProperty->getOneField('type', $property_id)) . '
				</select>
			</td>
		</tr>
		<tr>
			<td class="fieldarea span15" style="text-align:right"><strong>' . $core->get_Lang('Category') . '</strong></td>
			<td class="fieldarea">
				<select class="slb" id="cat_id" name="cat_id">
					' . $clsHotelProperty->getSelectByHotelCat($oneItem["cat_id"]) . '
				</select>
			</td>
		</tr>
		<tr>
			<td class="fieldarea" style="text-align:right"><strong>' . $core->get_Lang('Image icon') . '</strong></td>
			<td class="fieldarea">
				<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsProperty->getOneField('image', $property_id) . '" />
				<input type="hidden" id="isoman_hidden_image" value="' . $clsProperty->getOneField('image', $property_id) . '">
				<input class="form-control" style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsProperty->getOneField('image', $property_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsProperty->getOneField('image', $property_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
			</td>
		</tr>
		<tr style="display:none">
			<td class="fieldarea" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong></td>
			<td class="fieldarea">
				<textarea class="textarea full" rows="5" name="intro">' . $clsProperty->getIntro($property_id) . '</textarea>
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" id="clickSubmitProperty" property_id="' . $property_id . '">
			' . $core->get_Lang('Submit') . '
		</button> 
		<button class="btn btn-warning clickToClose" data-dismiss="modal" aria-hidden="true">' . $core->get_Lang('Close') . '</button> 
	</div>';
    } else {

        $html = '
	<div class="headPop headPop2">
		<a href="javascript:void();" title="Đóng" class="closeEv close_pop">&nbsp;</a>
		<h3 id="myModalLabel">' . $core->get_Lang('Edit') . ' ' . $clsProperty->getTextByType($type) . '</h3> 
	</div>
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea span15" style="text-align:right"><strong>' . $core->get_Lang('Title') . '</strong></td>
			<td class="fieldarea">
				<input type="text" id="title" name="title" value="' . $clsProperty->getTitle($property_id) . '" class="fontLarge form-control full text">
			</td>
		</tr>';
        if ($type == 'StatusPayment') {

            $html .= '
                <tr>
                <td class="fieldarea span15" style="text-align:right"><strong>' . $core->get_Lang('Deposit') . '</strong></td>
                <td class="fieldarea">
                    <input type="number" min=0 id="deposit" name="deposit" class="fontLarge form-control full text" value="' . $oneItem['deposit'] . '">
                </td>
            </tr>
            ';
        }
        if ($type == 'Market') {
            $lstMarketParent = $clsProperty->getAll('is_trash=0 AND parent_id=0 AND type="Market" AND property_id != "' . $property_id . '"', $clsProperty->pkey . ',title');
            if ($lstMarketParent) {
                $html .= '<tr>
								<td class="fieldarea span15">' . $core->get_Lang('Market parent') . '</td>
								<td class="fieldarea">
									<select name="parent_id" id="parent_id" class="form-control">
									<option value="0">' . $core->get_Lang('Choose market') . '</option>';
                foreach ($lstMarketParent as $key => $value) {
                    $html .= '<option  value="' . $value['property_id'] . '" ' . (($oneItem['parent_id'] == $value['property_id']) ? "selected" : "") . '>' . $value['title'] . '</option>';
                }
                $html .= '</select></td></tr>';
            }

            $lstCountryEx = $clsCountryEx->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsCountryEx->pkey . ',title');
            if ($lstCountryEx) {
                $html .= '<tr id="CountryID" ' . (($oneItem['parent_id'] > 0) ? "style='display:none'" : "") . '>
								<td class="fieldarea span15">' . $core->get_Lang('Country') . '</td>
								<td class="fieldarea">
									<select name="country_id" id="country_id" class="form-control required">
									<option value="">' . $core->get_Lang('Choose country') . '</option>';
                foreach ($lstCountryEx as $key => $value) {
                    $html .= '<option  value="' . $value['country_id'] . '"' . (($oneItem['country_id'] == $value['country_id']) ? "selected" : "") . '>' . $value['title'] . '</option>';
                }
                $html .= '</select></td></tr>';
            }
        }
        $html .= '<tr style="display:none">
			<td class="fieldarea">
				<select class="slb" id="type">
					' . $clsProperty->getSelectByType($clsProperty->getOneField('type', $property_id)) . '
				</select>
			</td>
		</tr>
		<tr style="display:none">
			<td class="fieldarea" style="text-align:right"><strong>' . $core->get_Lang('Image icon') . '</strong></td>
			<td class="fieldarea">
				<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsProperty->getOneField('image', $property_id) . '" />
				<input type="hidden" id="isoman_hidden_image" value="' . $clsProperty->getOneField('image', $property_id) . '">
				<input class="form-control" style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsProperty->getOneField('image', $property_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsProperty->getOneField('image', $property_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
			</td>
		</tr>
		<tr style="display:none">
			<td class="fieldarea" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong></td>
			<td class="fieldarea">
				<textarea class="textarea full" rows="5" name="intro">' . $clsProperty->getIntro($property_id) . '</textarea>
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button class="btn btn-primary submitClick" id="clickSubmitProperty" property_id="' . $property_id . '">
			' . $core->get_Lang('Submit') . '
		</button> 
		<button class="btn btn-warning clickToClose" data-dismiss="modal" aria-hidden="true">' . $core->get_Lang('Close') . '</button> 
	</div>';
    }
    echo ($html);
    die();
}
function default_ajDeleteProperty()
{
    global $core, $_LANG_ID;
    $user_id = $core->_USER['user_id'];
    #

    $clsProperty = new Property();
    $clsHotelProperty = new HotelProperty();
    $property_id = $_POST['property_id'];
    $type = $_POST['type'];

    if ($type == "HotelCategory") {
        $clsHotelProperty->deleteOne($property_id);
        return;
    }

    $clsProperty->deleteOne($property_id);
    echo (1);
    die();
}
function default_ajSubmitProperty_bak()
{
    global $core, $_LANG_ID, $clsISO;
    $user_id = $core->_USER['user_id'];
    #

    $clsProperty = new Property();
    $property_id = isset($_POST['property_id']) ? $_POST['property_id'] : 0;
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $titlePost = addslashes($_POST['title']);
    $introPost = addslashes($_POST['intro']);
    $slugPost = $core->replaceSpace($titlePost);
    $type = $_POST['type'];
    #
    $clsISO->checkExistTitle("Property", $property_id, $titlePost, "type='$type'");
    if (intval($property_id) == 0) {
        $res = $clsProperty->getAll("slug='$slugPost' and type='$type' limit 0,1");
        if (!empty($res)) {
            echo ('EXIST');
            die();
        } else {
            $listTable = $clsProperty->getAll("1=1 and type='$type'", $clsProperty->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsProperty->updateOne($listTable[$i][$clsProperty->pkey], "order_no='" . $order_no . "'");
            }
            $max_id = $clsProperty->getMaxId();
            $f = "property_id,title,slug,image,intro,order_no,type";
            $v = "'$max_id','$titlePost','$slugPost','$image','$introPost','1','$type'";
            if ($clsProperty->insertOne($f, $v)) {
                echo ('IN_SUCCESS');
                die();
            } else {
                echo ('ERROR');
                die();
            }
        }
    } else {
        $set = "title='$titlePost',slug='$slugPost',image='$image'";
        if ($clsProperty->updateOne($property_id, $set)) {
            echo ('UP_SUCCESS');
        } else {
            echo ('ERROR');
        }
        die();
    }
}

function default_ajSubmitProperty()
{
    global $core, $_LANG_ID, $clsISO;
    $user_id = $core->_USER['user_id'];
    #
    $clsProperty = new Property();
    $property_id = !empty($_POST['property_id']) ? $_POST['property_id'] : 0;
    $country_id = !empty($_POST['country_id']) ? $_POST['country_id'] : 0;
    $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : 0;
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $titlePost = addslashes($_POST['title']);
    $introPost = addslashes($_POST['intro']);
    $slugPost = $core->replaceSpace($titlePost);
    $cat_id = !empty($_POST['cat_id']) ? $_POST["cat_id"] : 0;
    $type = $_POST['type'];
    $deposit = !empty($_POST['deposit']) ? $_POST['deposit'] : 0;
    #

    if (intval($property_id) == 0) {
        $res = $clsProperty->getAll("slug='$slugPost' and type='$type' limit 0,1");
        if (!empty($res)) {
            echo ('EXIST');
            die();
        } else {
            $order_no = $clsProperty->getMaxOrderNo();

            $max_id = $clsProperty->getMaxId();
            $f = "property_id,title,slug,image,intro,order_no,type, cat_id, deposit, country_id, parent_id";
            $v = "'$max_id','$titlePost','$slugPost','$image','$introPost','$order_no','$type', '$cat_id', '$deposit', '$country_id', '$parent_id'";
            if ($clsProperty->insertOne($f, $v)) {
                echo ('IN_SUCCESS');
                die();
            } else {
                echo ('ERROR');
                die();
            }
        }
    } else {
        $set = "title='$titlePost',slug='$slugPost',image='$image', cat_id=$cat_id, deposit=$deposit, country_id=$country_id, parent_id=$parent_id";

        if ($clsProperty->updateOne($property_id, $set)) {
            echo ('UP_SUCCESS');
            die();
        } else {
            echo ('ERROR');
            die();
        }
    }
}
function default_ajSubmitHotelProperty()
{
    global $core, $_LANG_ID;
    #
    $clsHotelProperty = new HotelProperty();
    $property_id = $_POST['property_id'] ?? 0;
    $title = addslashes($_POST['title']);
    $type = $_POST['type'] ?? "";
    #

    if (intval($property_id) == 0) {
        $max_id = $clsHotelProperty->getMaxId();
        $f = "hotel_property_id,title,type,is_online";
        $v = "'$max_id','$title','$type', '1'";
        if ($clsHotelProperty->insertOne($f, $v)) {
            echo ('IN_SUCCESS');
            die();
        } else {
            echo ('ERROR');
            die();
        }
    } else {
        $set = "title='$title'";
        if ($clsHotelProperty->updateOne($property_id, $set)) {
            echo ('UP_SUCCESS');
            die();
        } else {
            echo ('ERROR');
            die();
        }
    }
}
function default_ajUpdatePropertyFavorite()
{
    global $core, $dbconn;
    $user_id = $core->_USER['user_id'];
    #

    $clsClassTable = new Property();
    $property_id = Input::post('property_id', 0);
    $is_favorite = Input::post('is_favorite', 0);
    $clsClassTable->updateOne($property_id, "is_favorite='$is_favorite'");

    echo 1;
    die();
}

/* Popup */
function default_ajGetBoxManagerProperty()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsProperty = new Property();
    $type = $_POST['type'];
    $fromid = $_POST['fromid'];
    $forid = $_POST['forid'];

    $html = '';
    $html .= '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="Đóng"></a>
		<h3>Quản lý - ' . $type . '</h3>
	</div>';

    $html .= '<div class="contentPop" style="height:355px">';
    $html .= '<table class="tbl-grid">';
    $html .= '<thead>
				<tr>
					<td class="gridheader"><strong>No.</strong></td>
					<td class="gridheader"><strong>Tiêu đề</strong></td>
					<td width="3%" class="gridheader"><i class="icon-pencil"></i></td>
					<td width="3%" class="gridheader"><i class="icon-remove"></i></td>
				</tr>
			</thead>';
    $html .= '<tbody id="tblHolderPropertyPop">';

    $lstItem = $clsProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsProperty->pkey);
    if (!empty($lstItem)) {
        $i = 0;
        foreach ($lstItem as $item) {
            $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html .= '<td class="index">' . ($i + 1) . '</td>';

            $html .= '<td><a class="edit_pop_property" _type="' . $type . '" title="Sửa" data="' . $item[$clsProperty->pkey] . '" fromid="' . $fromid . '" forid="' . $forid . '" href="javascript:;"><strong style="font-size:14px">' . $clsProperty->getTitle($item[$clsProperty->pkey]) . '</strong></a></td>';

            $html .= '<td style="text-align:center"><a href="javascript:void();" class="edit_pop_property" _type="' . $type . '" fromid="' . $fromid . '"  forid="' . $forid . '" title="Sửa" data="' . $item[$clsProperty->pkey] . '"><i class="icon-pencil"></i></a></td>';

            $html .= '<td style="text-align:center"><a href="javascript:void();" class="delete_pop_property" _type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" title="Xóa" data="' . $item[$clsProperty->pkey] . '"><i class="icon-remove"></i></a></td>';

            $html .= '</tr>';
            ++$i;
        }
    }
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';
    $html .= '
	<div class="bottom" unselectable="on" style="-moz-user-select: none;">
		<a parent_id="59" type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" id="btnCreateNewProperty" class="iso-button-primary fr">
			<i class="icon-plus-sign"></i> Thêm nhanh
		</a>
	</div>';
    echo $html;
    die();
}
function default_ajaxLoadTableProperty()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsProperty = new Property();
    $type = $_POST['type'];
    $fromid = $_POST['fromid'];
    $forid = $_POST['forid'];

    $lstItem = $clsProperty->getAll("is_trash=0 and type='$type' order by order_no DESC", $clsProperty->pkey);
    $Html = '';

    if (is_array($lstItem) && count($lstItem) > 0) {
        for ($i = 0; $i < count($lstItem); $i++) {

            $Html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $Html .= '<td class="index">' . ($i + 1) . '</td>';

            $Html .= '<td><a class="edit_pop_property" _type="' . $type . '" title="Sửa" data="' . $lstItem[$i][$clsProperty->pkey] . '" fromid="' . $fromid . '" forid="' . $forid . '" href="javascript:;"><strong style="font-size:14px">' . $clsProperty->getTitle($lstItem[$i][$clsProperty->pkey]) . '</strong></a></td>';

            $Html .= '<td style="text-align:center"><a href="javascript:void();" class="edit_pop_property" _type="' . $type . '" fromid="' . $fromid . '"  forid="' . $forid . '" title="Sửa" data="' . $lstItem[$i][$clsProperty->pkey] . '"><i class="icon-pencil"></i></a></td>';

            $Html .= '<td style="text-align:center"><a href="javascript:void();" class="delete_pop_property" _type="' . $type . '" fromid="' . $fromid . '" forid="' . $forid . '" title="Xóa" data="' . $lstItem[$i][$clsProperty->pkey] . '"><i class="icon-remove"></i></a></td>';

            $Html .= '</tr>';
        }
    }
    echo $Html;
    die();
}
function default_ajaxFrmProperty()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $oneCommon;
    $user_id = $core->_USER['user_id'];
    #
    $clsProperty = new Property();
    $property_id = isset($_POST['property_id']) ? $_POST['property_id'] : 0;
    $fromid = $_POST['fromid'];
    $forid = $_POST['forid'];
    #
    if (intval($property_id) == 0) {
        $type = $_POST['type'];
    } else {
        $oneTable = $clsProperty->getOne($property_id);
        $type = $oneTable['type'];
    }
    #
    $html = '';
    $html .= '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="Đóng"></a>
		<h3>' . (intval($property_id) == 0 ? 'Thêm mới - ' . $type : 'Cập nhật - ' . $clsProperty->getTitle($property_id)) . '</h3>
	</div>';
    $html .= '
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldarea">
				<input type="text" placeholder="Nhập tiêu đề" name="title" class="text full required fontLarge" value="' . $clsProperty->getTitle($property_id) . '" style="width:95%">
			</td>
		</tr>
	</table>
	<div class="modal-footer"> 
		<button type="button" class="btn btn-primary submitClick" _type="' . $type . '" property_id="' . $property_id . '" fromid="' . $fromid . '" forid="' . $forid . '" id="ajaxSaveProperty">Lưu lại</button>
	</div>';
    echo $html;
    die();
}
function default_ajaxSelectBoxHotelRating()
{
    $clsHotel = new Hotel();
    $clsProperty = new Property();
    #
    $type = $_POST['type'];
    $forid = $_POST['forid'];
    $hotel_rating = $clsHotel->getOneField('hotel_rating', $forid);
    $Html = $clsProperty->getSelectByProperty($type, $hotel_rating);
    echo $Html;
    die();
}
/*============== ADDON SERVICE MANAGEMENT ================*/
function default_service()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
    
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];
    $assign_list['clsUser'] = $clsUser;
    $classTable = "AddOnService";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    $assign_list["user_id"] = $user_id;
    #
    $link = '';
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
    }

    $cond = "1=1";
    
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and (slug like '%" . $slug . "%' or title like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;


    $orderBy = " order_no asc";
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
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
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
    $assign_list["allItem"] = $allItem;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['addonservice_id']) ? ($_GET['addonservice_id']) : '';
        $addonservice_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $addonservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($addonservice_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['addonservice_id']) ? ($_GET['addonservice_id']) : '';
        $addonservice_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $addonservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($addonservice_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['addonservice_id']) ? ($_GET['addonservice_id']) : '';
        $addonservice_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $addonservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($addonservice_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['addonservice_id']) ? ($_GET['addonservice_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        if (($string != '' && $pvalTable == 0) || $direct == '') {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }

        $where = "1='1' and is_trash=0";
        $pUrl = '&act=service';
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no desc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
    }
}
function default_ajUpdPosSortServiceTour()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsAddOnService = new AddOnService();
    $order = $_POST['order'];
    $currentPage     = $_POST['currentPage'];
    $recordPerPage     = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsAddOnService->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_activities()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #
    $classTable = "Activities";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #

    $link = '';
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
    }

    $cond = "1=1";
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and ( title like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' )";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;

    $orderBy = " order_no asc";
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
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
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);

    //print_r($cond); die();
    $assign_list["allItem"] = $allItem;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['activities_id']) ? ($_GET['activities_id']) : '';
        $activities_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $activities_id == 0) {

            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($activities_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['activities_id']) ? ($_GET['activities_id']) : '';
        $activities_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $activities_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($activities_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['activities_id']) ? ($_GET['activities_id']) : '';
        $activities_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $activities_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($activities_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['activities_id']) ? ($_GET['activities_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        if (($string != '' && $pvalTable == 0) || $direct == '') {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }

        $where = "1='1' and is_trash=0";
        $pUrl = '&act=service';
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no desc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
    }
}

/*============== ADDON SERVICE MANAGEMENT ================*/
function default_edit_activities()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    $classTable = "Activities";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    if ($string != '' && $pvalTable == 0) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=notPermission');
    }
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

    //print_r($country_id); die();
    #
    $pUrl = '';
    $assign_list["pUrl"] = $pUrl;


    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    #
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 2, 1,  "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 2, 1,  "style='width:100%'");

    #
    #=========================================#
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if ($pvalTable > 0) {
            $set = "";
            $firstAdd = 0;
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    if ($firstAdd == 0) {
                        $set .= $tmp[1] . "='" . addslashes($val) . "'";
                        $firstAdd = 1;
                    } else {
                        $set .= "," . $tmp[1] . "='" . addslashes($val) . "'";
                    }
                }
            }
            $set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
            $set .= ",upd_date='" . time() . "'";
            $set .= ",title='" . ucwords($_POST['title']) . "'";
            $set .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            }
            if ($image != '' && $image != '0') {
                $set .= ",image='" . addslashes($image) . "'";
            }
            #
            $pUrl = '';
            #
            //print_r($pvalTable.'<br/>'.$set); die();
            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_activities&activities_id=' . $core->encryptID($pvalTable) . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=activities&message=updateSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&activities_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
            }
        } else {
            $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
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
            #
            $max_id = $clsClassTable->getMaxId();
            $field .= ",user_id,user_id_update,reg_date,upd_date,slug,title,activities_id,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . $core->replaceSpace($_POST['title']) . "','" . ucwords($_POST['title']) . "','" . $max_id . "','1'";
            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            }
            if ($image != '' && $image != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
            }
            #
            $pUrl = '';

            //print_r($field.'<br />'.$value);die();
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&activities_id=' . $core->encryptID($max_id) . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=activities&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
            }
        }
    }
}

function default_ajUpdPosSortActivities()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsActivities = new Activities();
    $order = $_POST['order'];
    $currentPage     = $_POST['currentPage'];
    $recordPerPage     = $_POST['recordPerPage'];

    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsActivities->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_ajSiteAddOnService()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $clsConfiguration;
    $user_id = $core->_USER['user_id'];
    #
    $clsClassTable = new AddOnService;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $addonservice_id = isset($_POST['addonservice_id']) ? intval($_POST['addonservice_id']) : 0;
    #
    if ($tp == 'L') {
        $lstItem = $clsClassTable->getAll("is_trash=0 order by order_no desc");
        $html = "";
        if (is_array($lstItem) && count($lstItem)) {
            $i = 0;
            foreach ($lstItem as $item) {
                $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="' . $item[$clsClassTable->pkey] . '" /></td>';
                $html .= '<td class="index">' . ($i + 1) . '</td>';
                $html .= '<td><strong style="font-size:15px;">' . $clsClassTable->getTitle($item[$clsClassTable->pkey]) . '</strong></td>';
                $html .= '<td style="text-align:right;"><strong class="format_price" style="font-size:15px">' . $clsClassTable->getPrice($item[$clsClassTable->pkey]) . ' ' . $clsISO->getRate() . '</strong></td>';
                $html .= '<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveCruiseService" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseService" direct="movebottom" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="moveCruiseService" direct="moveup" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-arrow-up"></i></a>') . '
					</td>
					<td style="vertical-align: middle;text-align:center">
						' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseService" direct="movedown" data="' . $item[$clsClassTable->pkey] . '" href="javascript:void();"><i class="icon-arrow-down"></i></a>') . '
					</td>';
                $html .= '<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
								<ul class="dropdown-menu" style="right:0px !important">
									<li><a class="clickEditCruiseService" title="' . $core->get_Lang('edit') . '" href="javascript:void();" data="' . $item[$clsClassTable->pkey] . '"><i class="icon-edit"></i> <span>' . $core->get_Lang('edit') . '</span></a></li>
									<li><a class="clickDeleteCruiseService" title="' . $core->get_Lang('delete') . '" href="javascript:void();" data="' . $item[$clsClassTable->pkey] . '"><i class="icon-remove"></i> <span>' . $core->get_Lang('delete') . '</span></a></li>
								</ul>
							</div>
						</td>';
                $html .= '</tr>';
                ++$i;
            }
        } else {
            $html .= '<tr><td colspan="7"><div class="message">' . $core->get_Lang('nodata') . '</div></td></tr>';
        }
        echo $html;
        die();
    } elseif ($tp == 'F') {
        #
        $html = '';
        $html .= '<div class="headPop"> 
					<a class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
					<h3>' . ($addonservice_id > 0 ? $core->get_Lang('edit') : $core->get_Lang('add')) . ' ' . $core->get_Lang('AddOn Service') . '</h3> 
				</div>';
        $html .= '
		<form method="post" action="" id="form-post" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div>
					<div class="row-span">
						<div class="fieldlabel text_left_767" style="text-align:right"><strong>' . $core->get_Lang('Title') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea"><input type="text" name="title" class="text_32 full-width border_aaa bold" value="' . $clsClassTable->getTitle($addonservice_id) . '" style=" width:95%"/></div>
					</div>
					<div class="row-span hidden">
						<div class="fieldlabel text_left_767" style="text-align:right"><strong>' . $core->get_Lang('Image') . '</strong><span class="color_r">*</span></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsClassTable->getOneField('image', $addonservice_id) . '" style="width:32px;height:32px"/>
							<input type="hidden" id="isoman_hidden_image" value="' . $clsClassTable->getOneField('image', $addonservice_id) . '">
							<input class="text_32 border_aaa fl ml10" style="width:calc(100% - 80px) !important;" type="text" id="isoman_url_image" name="image" value="' . $clsClassTable->getOneField('image', $addonservice_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsClassTable->getOneField('image', $addonservice_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel text_left_767" style="text-align:right">
							<strong>' . $core->get_Lang('Extra') . ' <span class="color_r">*</span></strong>
						</div>
						<div class="fieldarea">
							<select class="glSlBox" id="extra" name="extra" style="width:200px">
                                ' . $clsClassTable->renderOptionExtra($clsClassTable->getOneField('extra', $addonservice_id)) . '
							</select>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel text_left_767" style="text-align:right"><strong>' . $core->get_Lang('price') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea" style="display:flex">
							<input type="text" class="text full price-In h_tour_price_group fontLarge" style=" width:200px" value="' . $clsClassTable->getPrice($addonservice_id) . '" name="price" />
							' . $clsISO->getRate() . '
						</div>
					</div>';
        if (intval($addonservice_id) != 0) {
            $html .= '	<div class="row-span">
						<div class="fieldlabel text_left_767" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" style="width:100%">' . $clsClassTable->getIntro($addonservice_id) . '</textarea>
						</div>
					</div>';
        }

        $html .= '	</div>
			</div>
		</form>
		<div class="modal-footer"> 
			<button class="btn btn-primary submitAddOnService" addonservice_id="' . $addonservice_id . '">
				<i class="icon-ok icon-white"></i> ' . $core->get_Lang('save') . '
			</button>
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
			</button>
		</div>';
        echo $html;
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
        $slugPost = $core->replaceSpace($titlePost);

        $introPost = addslashes($_POST['intro']);
        $price = isset($_POST['price']) ? str_replace('.', '', $_POST['price']) : 0;
        $imagePost = isset($_POST['image']) ? addslashes($_POST['image']) : '';
        $extra = isset($_POST['extra']) ? intval($_POST['extra']) : 0;
        $is_online = isset($_POST['is_online']) ? intval($_POST['is_online']) : 0;
        #
        if (intval($addonservice_id) == 0) {
            if (!empty($clsClassTable->getAll("slug='$slugPost'"))) {
                echo '_EXIST';
                die();
            } else {
                $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
                for ($i = 0; $i <= count($listTable); $i++) {
                    $order_no = $listTable[$i]['order_no'] + 1;
                    $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
                }
                $max_id = $clsClassTable->getMaxID();
                $max_order = $clsClassTable->getMaxOrderNo();
                $f = "user_id,user_id_update,title,slug,intro,price,order_no,addonservice_id,reg_date,upd_date,image,extra,is_online";
                $v = "'$user_id','$user_id','" . addslashes($titlePost) . "','" . addslashes($slugPost) . "','" . addslashes($introPost) . "','" . $price . "'";
                $v .= ",'1','$max_id','" . time() . "','" . time() . "','$imagePost','" . $extra . "','" . $is_online . "'";
                if ($clsClassTable->insertOne($f, $v)) {
                    echo '_INSERT_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        } else {
            $addonservice_id = intval($addonservice_id);

    // Kiểm tra bản ghi cần sửa có tồn tại không
    $item = $clsClassTable->getOne($addonservice_id);

    if (empty($item)) {
        echo '_ERROR';
        die();
    }

    // Kiểm tra slug trùng với bản ghi khác
    $checkSlug = $clsClassTable->getAll(
        "slug='" . addslashes($slugPost) . "'
        AND addonservice_id <> '" . $addonservice_id . "'"
    );

    if (!empty($checkSlug)) {
        echo '_EXIST';
        die();
    }

    // Chuẩn bị dữ liệu cập nhật
    $v = "title='" . addslashes($titlePost) . "'";
    $v .= ",slug='" . addslashes($slugPost) . "'";
    $v .= ",intro='" . addslashes(isset($_POST['intro']) ? $_POST['intro'] : '') . "'";
    $v .= ",price='" . addslashes($price) . "'";
    $v .= ",image='" . addslashes($imagePost) . "'";
    $v .= ",upd_date='" . time() . "'";
    $v .= ",user_id_update='" . intval($user_id) . "'";
    $v .= ",extra='" . intval($extra) . "'";

    if ($clsClassTable->updateOne($addonservice_id, $v)) {
        echo '_UPDATE_SUCCESS';
    } else {
        echo '_ERROR';
    }

    die();
        }
    } else if ($tp == 'DEL') {
        $clsCombo = new Combo();
        $combo_id = Input::post('combo_id', 0);
        $clsClassTable->deleteOne($addonservice_id);
        $list_service = $clsCombo->getOneField('list_service', $combo_id);
        $list_service = !empty($list_service) ? json_decode($list_service, true) : array();

        $del = array_search($addonservice_id, $list_service);
        array_splice($list_service, $del, 1);


        if ($clsCombo->updateOne($combo_id, array(
            'list_service' => json_encode($list_service)
        ))) {
            echo '_DELETE_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}
function default_ajaxFrmService()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsAddOnService = new AddOnService();
    $addonservice_id = isset($_POST['addonservice_id']) ? intval($_POST['addonservice_id']) : 0;
    #
    $html = '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
		<h3>' . ($addonservice_id == 0 ? $core->get_Lang('Add New Addon Service') : $core->get_Lang('Edit')) . ': ' . $clsAddOnService->getTitle($addonservice_id) . '</h3>
	</div>';
    $html .= '
	<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel text-right bold"><strong>' . $core->get_Lang('Title') . '</strong> <font class="color_r">*</font></div>
				<div class="fieldarea">
					<input class="text full required" name="title" value="' . $clsAddOnService->getTitle($addonservice_id) . '" type="text" autocomplete="off" />
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Image') . '</strong> <span class="color_r">*</span></div>
				<div class="fieldarea">
					<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsAddOnService->getOneField('image', $addonservice_id) . '" />
					<input type="hidden" id="isoman_hidden_image" value="' . $clsAddOnService->getOneField('image', $addonservice_id) . '">
					<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsAddOnService->getOneField('image', $addonservice_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsAddOnService->getOneField('image', $addonservice_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel text-right"><strong>' . $core->get_Lang('price') . '</strong> <span class="color_r">*</span></div>
				<div class="fieldarea">
					<input class="text full fontLarge required formatprice" style="width:30%" name="price" value="' . $clsAddOnService->getPrice($addonservice_id) . '" type="text" autocomplete="off" />
					' . $clsISO->getRate() . '/1Pax
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel  text-right"><strong>' . $core->get_Lang('Short text') . '</strong></div>
				<div class="fieldarea">
					<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">' . $clsAddOnService->getIntro($addonservice_id) . '</textarea>
				</div>
			</div>
			
		</div>
	</form>
	<div class="modal-footer">
		<button type="button" addonservice_id="' . $addonservice_id . '" class="btn btn-primary btnSaveService">
			<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
		</button>
	</div>';
    echo ($html);
    die();
}
function default_ajaxSaveService()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "AddOnService";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $addonservice_id = isset($_POST['addonservice_id']) ? $_POST['addonservice_id'] : 0;
    $titlePost = trim($_POST['title']);
    $slugPost = $core->replaceSpace($titlePost);
    $pricePost = isset($_POST['price']) ? $_POST['price'] : 0;
    $pricePost = $clsISO->processSmartNumber($pricePost);
    $introPost = addslashes($_POST['intro']);
    $imagePost = addslashes($_POST['image']);
    #
    if (intval($addonservice_id) == 0) {
        $all = $clsClassTable->getAll("is_trash=0 and slug like '%" . $slugPost . "' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';
            die();
        } else {

            $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
            $f = "user_id,user_id_update,title,slug,price,intro,order_no,reg_date,upd_date";
            $v = "'$user_id','$user_id','" . addslashes($titlePost) . "','" . addslashes($slugPost) . "','$pricePost','" . addslashes($introPost) . "'";
            $v .= ",'1','" . time() . "','" . time() . "'";
            if ($imagePost != '' && $imagePost != '0') {
                $f .= ",image";
                $v .= ",'" . $imagePost . "'";
            }
            #
            if ($clsClassTable->insertOne($f, $v)) {
                echo '_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    } else {
        $vx = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',price='$pricePost',intro='$introPost',upd_date='" . time() . "',user_id_update='$user_id'";
        if ($imagePost != '' && $imagePost != '0') {
            $vx .= ",image='" . $imagePost . "'";
        }
        if ($clsClassTable->updateOne($addonservice_id, $vx)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}
/*============== TRANSPORT MANAGEMENT ================*/
function default_transport()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #
    $classTable = "Transport";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $link = '';
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
    }

    $cond = "1=1";
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and (slug like '%" . $slug . "%' or title like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;

    $orderBy = " order_no asc";
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : 20;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    //print_r($cond); die();
    $lstAllItem = $clsClassTable->getAll($cond, $clsClassTable->pkey);
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
    $allItem = $clsClassTable->getAll(
    $cond . " order by " . $orderBy . $limit
);

if (!is_array($allItem)) {
    $allItem = array();
}

$clsUser = new User();
$assign_list['clsUser'] = $clsUser;

foreach ($allItem as $key => $item) {
    // ID người tạo
    $allItem[$key]['user_id'] = isset($item['user_id'])
        ? (int)$item['user_id']
        : 0;

    // Thời gian tạo và cập nhật
    $allItem[$key]['reg_date'] = isset($item['reg_date'])
        ? (int)$item['reg_date']
        : 0;

    $allItem[$key]['upd_date'] = isset($item['upd_date'])
        ? (int)$item['upd_date']
        : 0;
}

$assign_list['allItem'] = $allItem;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['transport_id']) ? ($_GET['transport_id']) : '';
        $transport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($transport_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['transport_id']) ? ($_GET['transport_id']) : '';
        $transport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($transport_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['transport_id']) ? ($_GET['transport_id']) : '';
        $transport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $transport_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($transport_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['transport_id']) ? ($_GET['transport_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        if (($string != '' && $pvalTable == 0) || $direct == '') {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        $clsUser = new User();
    $assign_list['clsUser'] = $clsUser;
        $where = "1='1' and is_trash=0";
        $pUrl = '&act=transport';
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no desc");
            for ($i = 0; $i < count($lstItem); $i++) {
                $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
    }
}
function default_ajUpdPosSortTransport()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsTransport = new Transport();
    $order = $_POST['order'];
    $currentPage     = $_POST['currentPage'];
    $recordPerPage     = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTransport->updateOne($val, "order_no='" . $key . "'");
    }
    //var_dump($order);die;
}
function default_ajaxFrmTransport()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsTransport = new Transport();
    $transport_id = isset($_POST['transport_id']) ? intval($_POST['transport_id']) : 0;
    #
    $html = '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
		<h3>' . ($transport_id == 0 ? $core->get_Lang('Add New Transport') : $core->get_Lang('Edit Transport')) . '</h3>
	</div>';
    $html .= '
	<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel text-right bold">' . $core->get_Lang('Title') . '<span color="color_r">*</span></div>
				<div class="fieldarea">
					<input class="text full required" name="title" value="' . $clsTransport->getTitle($transport_id) . '" type="text" autocomplete="off" />
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Image') . '</strong></div>
				<div class="fieldarea">
					<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTransport->getOneField('image', $transport_id) . '" />
					<input type="hidden" id="isoman_hidden_image" value="' . $clsTransport->getOneField('image', $transport_id) . '">
					<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTransport->getOneField('image', $transport_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTransport->getOneField('image', $transport_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</div>
			</div>';
    if (1 == 2) {
        $html .= '<div class="row-span">
				<div class="fieldlabel  text-right">' . $core->get_Lang('intro') . '</div>
				<div class="fieldarea">
					<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">' . $clsTransport->getIntro($transport_id) . '</textarea>
				</div>
			</div>';
    }
    $html .= '
		</div>
	</form>
	<div class="modal-footer">
		<button type="button" transport_id="' . $transport_id . '" class="btn btn-primary btnSaveTransport">
			<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
		</button>
	</div>';
    echo ($html);
    die();
}
function default_ajaxSaveTransport()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Transport";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $transport_id = isset($_POST['transport_id']) ? $_POST['transport_id'] : 0;
    $titlePost = trim($_POST['title']);
    $slugPost = $core->replaceSpace($titlePost);
    $introPost = addslashes($_POST['intro']);
    $imagePost = addslashes($_POST['image']);
    #
    if (intval($transport_id) == 0) {
        $all = $clsClassTable->getAll("is_trash=0 and slug = '" . $slugPost . "' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';
            die();
        } else {
            $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
            $f = "$clsClassTable->pkey,user_id,user_id_update,title,slug,intro,order_no,reg_date,upd_date";
            $v = "'" . $clsClassTable->getMaxId() . "','$user_id','$user_id','" . addslashes($titlePost) . "','" . addslashes($slugPost) . "','" . addslashes($introPost) . "'";
            $v .= ",'1','" . time() . "','" . time() . "'";
            if ($imagePost != '' && $imagePost != '0') {
                $f .= ",image";
                $v .= ",'" . $imagePost . "'";
            }
            #

            if ($clsClassTable->insertOne($f, $v)) {
                echo '_SUCCESS';
                die();
            } else {
                echo '_ERROR';
                die();
            }
        }
    } else {
        $all = $clsClassTable->getAll("is_trash=0 and slug = '" . $slugPost . "' and transport_id<>'$transport_id' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';
            die();
        }
        $vx = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='$introPost',upd_date='" . time() . "',user_id_update='$user_id'";
        if ($imagePost != '' && $imagePost != '0') {
            $vx .= ",image='" . $imagePost . "'";
        }
        if ($clsClassTable->updateOne($transport_id, $vx)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}
require_once(DIR_MODULES . '/property/mod_default.php');
