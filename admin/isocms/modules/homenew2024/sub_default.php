<?php
require_once(DIR_MODULES . '/homenew2024/mod_setting.php');


function doLoginAgain($user_id)
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod;
    global $core, $clsModule, $clsButtonNav;
    $clsUser = new User();
    $user_name = $clsUser->getOneField('user_name', $user_id);
    $user_pass = $clsUser->getOneField('user_pass', $user_id);
    #
    vnSessionSetVar("LOGGEDIN", 1);
    vnSessionSetVar("NVC_USERNAME", $user_name);
    vnSessionSetVar("NVC_PASSWORD", $user_pass);
    return $user_pass;
}

function default_doLogin()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod;
    global $core, $clsModule, $clsButtonNav;
    $core->_SESS->doLoginAgain($core->_SESS->user_id);
}

function default_loginAgain()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod;
    global $core, $clsModule, $clsButtonNav;
    doLoginAgain($core->_SESS->user_id);
    #
    echo (1);
    die();
}

function default_default()
{
    global $assign_list, $lang_sql, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $clsISO;
    global $clsConfiguration;
    //	ini_set( "display_errors", 1);
    #----
    $clsFeedback = new Feedback();
    $assign_list["clsFeedback"] = $clsFeedback;
    $lstFeedback = $clsFeedback->getAll("1=1 order by reg_date DESC LIMIT 0,5");
    $assign_list["lstFeedback"] = $lstFeedback;
    unset($lstFeedback);

    $clsAdminbutton = new Adminbutton();
    $assign_list["clsAdminbutton"] = $clsAdminbutton;
    $listQuickAccessShow = $clsAdminbutton->getAll("parent_id=110 and _type='_HOME' 
	and list_user_id_slash like '%|" . $core->_USER['user_id'] . "|%' and is_trash=0 and is_active=1 order by order_no ASC");
    $assign_list["listQuickAccessShow"] = $listQuickAccessShow;

    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;
    //Show Booking Tour
    $lstBooking = $clsBooking->getAll("1=1 and booking_type='Tour' order by reg_date DESC LIMIT 0,10");
    //Show Booking 4 Type
    $lstBooking2 = $clsBooking->getAll("booking_type IN ('Tour', 'Cruise', 'Tailor', 'Service') ORDER BY reg_date DESC LIMIT 0,12");
    //Show Booking All
    $lstBooking3 = $clsBooking->getAll("1=1 order by reg_date DESC LIMIT 0,12");

    $assign_list["lstBooking"] = $lstBooking;
    unset($lstBooking);
    $assign_list["lstBooking2"] = $lstBooking2;
    unset($lstBooking2);

    $assign_list["lstBooking3"] = $lstBooking3;
    unset($lstBooking3);

    /*statistic booking*/
    $time1 = time() - 518400;
    $time2 = $time1 - 518400;
    $time_min = $clsBooking->getOne('1=1', "min(reg_date) as minDate");
    $dateMin = (int)date('Y', $time_min['minDate']);
    $dateMax = date('Y');
    $rangeDate = [];
    for ($i = $dateMin; $i <= $dateMax; $i++) {
        $rangeDate[] = $i;
    }
    $assign_list["rangeDate"] = $rangeDate;
    $sql = "SELECT COUNT(booking_id) as total_booking, SUM(totalgrand) as value_of_order, SUM(deposit) as total_paid, SUM(balance) as balance_owed, SUM(price_promotion) as total_discount FROM " . DB_PREFIX . "booking WHERE lang_id = '$lang_sql' and ";
    $cond1 = " reg_date >= '" . $time1 . "' ";
    $cond2 = " reg_date BETWEEN '" . $time2 . "' AND '" . $time1 . "'";
    //    var_dump($sql.$cond1);
    $nearest1 = $dbconn->getAll($sql . $cond1);
    $assign_list["nearest1"] = [
        'total_booking' => $nearest1[0]['total_booking'],
        'value_of_order' => number_format($nearest1[0]['value_of_order'], 0, ',', '.'),
        'total_paid' => number_format($nearest1[0]['total_paid'], 0, ',', '.'),
        'balance_owed' => number_format($nearest1[0]['balance_owed'], 0, ',', '.'),
        'total_discount' => number_format($nearest1[0]['total_discount'], 0, ',', '.'),
    ];
    $nearest2 = $dbconn->getAll($sql . $cond2);
    $assign_list["nearest2"] = [
        'total_booking' => [
            ((int)$nearest2[0]['total_booking'] < (int)$nearest1[0]['total_booking']) ? 'up' : (((int)$nearest2[0]['total_booking'] > (int)$nearest1[0]['total_booking']) ? 'down' : ''),
            number_format(abs($nearest2[0]['total_booking'] - $nearest1[0]['total_booking']), 0, ',', '.')
        ],
        'value_of_order' => [
            ((int)$nearest2[0]['value_of_order'] < (int)$nearest1[0]['value_of_order']) ? 'up' : (((int)$nearest2[0]['value_of_order'] > (int)$nearest1[0]['value_of_order']) ? 'down' : ''),
            number_format(abs($nearest2[0]['value_of_order'] - $nearest1[0]['value_of_order']), 0, ',', '.')
        ],
        'total_paid' => [
            ((int)$nearest2[0]['total_paid'] < (int)$nearest1[0]['total_paid']) ? 'up' : (((int)$nearest2[0]['total_paid'] > (int)$nearest1[0]['total_paid']) ? 'down' : ''),
            number_format(abs($nearest2[0]['total_paid'] - $nearest1[0]['total_paid']), 0, ',', '.')
        ],
        'balance_owed' => [
            ((int)$nearest2[0]['balance_owed'] < (int)$nearest1[0]['balance_owed']) ? 'up' : (((int)$nearest2[0]['balance_owed'] > (int)$nearest1[0]['balance_owed']) ? 'down' : ''),
            number_format(abs($nearest2[0]['balance_owed'] - $nearest1[0]['balance_owed']), 0, ',', '.')
        ],
        'total_discount' => [
            ((int)$nearest2[0]['total_discount'] < (int)$nearest1[0]['total_discount']) ? 'up' : (((int)$nearest2[0]['total_discount'] > (int)$nearest1[0]['total_discount']) ? 'down' : ''),
            number_format(abs($nearest2[0]['total_discount'] - $nearest1[0]['total_discount']), 0, ',', '.')
        ],
    ];
    unset($nearest1, $nearest2);
    /*end statistic booking*/

    //    ISO::pre($assign_list["nearest2"]);die("z");
}
function default_delete()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $clsISO;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Booking";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    #
    $string = isset($_GET['pkeyTable']) ? $_GET['pkeyTable'] : "";
    $pvalTable = intval($core->decryptID($string));
    if ($string != '' && $pvalTable == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
        exit();
    }
    $assign_list["pvalTable"] = $pvalTable;
    $clsTable = $clsClassTable->getOneField('clsTable', $pvalTable);
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    #
    $pUrl = '';
    if (!empty($action)) {
        $pUrl .= '&act=' . $action;
    } else {
        $pUrl .= '&clsTable=' . $core->encryptID($clsTable);
    }
    #
    if ($clsClassTable->deleteOne($pvalTable)) {
        if ($action != 'home') {
            header('location: ' . PCMS_URL . '/?admin&mod=' . $mod . $pUrl . '&message=DeleteSuccess');
        } else {
            header('location: ' . PCMS_URL . '/?admin&message=DeleteSuccess');
        }
    }
}

function default_load_quick_access()
{
    global $smarty, $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $clsISO, $clsISO, $clsConfiguration;
    $clsAdminbutton = new Adminbutton();
    $assign_list["clsAdminbutton"] = $clsAdminbutton;
    #
    $holderG = Input::post('holderG', '_list');
    $smarty->assign('holderG', $holderG);
    if ($holderG == '_modal' || $holderG == '_list') {
        if ($holderG == '_list') {
            $listQuickAccessShow = $clsAdminbutton->getAll("parent_id=110 AND _type='_HOME' 
			AND list_user_id_slash LIKE '%|" . $core->_USER['user_id'] . "|%' and is_trash=0 and is_active=1 ORDER BY order_no ASC");
            $assign_list["listQuickAccessShow"] = $listQuickAccessShow;
            #
            $listQuickAccess = $clsAdminbutton->getAll("parent_id=110 AND _type='_HOME' 
			AND (list_user_id_slash IS NULL OR list_user_id_slash NOT LIKE '%|" . $core->_USER['user_id'] . "|%')  and is_trash=0 and is_active=1 ORDER BY order_no ASC");
            $assign_list["listQuickAccess"] = $listQuickAccess;
        }
        // Return
        $html = $core->build('load_quick_access.tpl');
        echo $html;
        die();
    } else {
        $msg = '_success';
        $adminbutton_id = (int)Input::post('adminbutton_id', 0);
        $list_user_id_slash = $clsAdminbutton->getOneField('list_user_id_slash', $adminbutton_id);
        $list_user_id_slash = !empty($list_user_id_slash)
            ? $clsISO->getArrayByTextSlash($list_user_id_slash) : array();

        if ($holderG == 'add') {
            $list_user_id_slash[] = $core->_USER['user_id'];
            $clsAdminbutton->update($adminbutton_id, array(
                'list_user_id_slash' => $clsISO->makeSlashListFromArray($list_user_id_slash)
            ));
        } elseif ($holderG == 'remove') {
            if (in_array($core->_USER['user_id'], $list_user_id_slash)) {
                $list_user_id_slash = array_diff($list_user_id_slash, array($core->_USER['user_id']));
            }
            $clsAdminbutton->update($adminbutton_id, array(
                'list_user_id_slash' => $clsISO->makeSlashListFromArray($list_user_id_slash)
            ));
        }
        // Return
        echo $msg;
        die();
    }
}

function default_ajDeleteItemImage()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsTable = addslashes($_POST['clsTable']);
    $clsClassTable = new $clsTable();
    $pvalTable = addslashes($_POST['pvalTable']);
    $type = addslashes($_POST['type']);
    #
    if (!$type) {
        $clsClassTable->updateOne($pvalTable, "image=''");
    } else {
        $clsClassTable->updateOne($pvalTable, $type . "=''");
    }

    echo ($clsClassTable->getOneField('image', $pvalTable));
    die();
}

function default_ajUpdateMultiItemStatus()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $clsTable = $_POST['clsTable'];
    $listID = isset($_POST['listID']) ? $_POST['listID'] : '';
    $val = isset($_POST['val']) ? $_POST['val'] : '';
    //	print_r($clsTable);die();
    #
    $clsClassTable = new $clsTable();
    if ($listID != '' && $listID != '0' && $val != '') {
        $temp = explode('|', $listID);
        if (is_array($temp) && count($temp) > 0) {
            for ($i = 0; $i < count($temp); $i++) {
                //				print_r($clsTable);die();
                $clsClassTable->updateOne($temp[$i], "is_online='" . $val . "'");
            }
        }
    }
}

function default_ajDeleteMultiItem()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav, $clsISO;
    #
    $clsTable = $_POST['clsTable'];
    $listID = isset($_POST['listID']) ? $_POST['listID'] : '';
    //    $clsISO::pre($_POST);die;
    #
    $clsClassTable = new $clsTable();
    if ($listID != '' && $listID != '0') {
        $temp = explode('|', $listID);
        if (is_array($temp) && count($temp) > 0) {
            for ($i = 0; $i < count($temp); $i++) {
                //				print_r($clsTable);die();
                $clsClassTable->doDelete($temp[$i]);
            }
        }
    }
}

function default_ajDeleteMultiItemPromotionPro()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $clsTable = $_POST['clsTable'];
    $clsPromotionItem = new PromotionItem();
    $listID = isset($_POST['listID']) ? $_POST['listID'] : '';
    #
    $clsClassTable = new $clsTable();
    if ($listID != '' && $listID != '0') {
        $temp = explode('|', $listID);
        if (is_array($temp) && count($temp) > 0) {
            for ($i = 0; $i < count($temp); $i++) {
                $clsClassTable->doDelete($temp[$i]);
                $clsPromotionItem->doDeleteAllByProId($temp[$i]);
            }
        }
    }
}

function default_ajDeleteMultiItemBooking()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $clsTable = $_POST['clsTable'];
    $listID = isset($_POST['listID']) ? $_POST['listID'] : '';
    $bk_type = isset($_POST['type']) ? $_POST['type'] : '';
    //    var_dump($_POST);die();
    #
    $clsClassTable = new $clsTable();
    if ($listID != '' && $listID != '0') {
        $a = $clsClassTable->doDeleteAllByBooking($listID, $bk_type);
        echo $a;
        die();
    }
}

function default_ajDeleteMultiItemNew()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $clsTable = $_POST['clsTable'];
    $listID = isset($_POST['listID']) ? $_POST['listID'] : '';
    #
    $clsClassTable = new $clsTable();
    if ($listID != '' && $listID != '0') {
        $clsClassTable->doDelete($listID);
    }
}

function default_ajaxPopSiteHelp()
{
    global $core;
    $clsHelp = new Help();
    $mod_page = $_POST['mod_page'];
    $act_page = $_POST['act_page'];
    $area_page = $_POST['area_page'];

    $SiteHelpPage = 'Site_Help_' . $mod_page . '_' . $act_page;
    if ($area_page != '') {
        $SiteHelpPage .= '_' . $area_page;
    }
    #
    $html = '';
    $html .= '<div class="headPop"> 
		<a class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
		<h3>' . $core->get_Lang('infohelpmod') . ' ' . $core->get_Lang($mod_page) . '</h3>
	</div>';
    if (_DEV == '1') {
        $html .= '<form method="post" action="" id="formHelp" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="fl" style="width:100%">
					<div class="row-span">
						<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('content') . '</div>
						<div class="fieldarea">
							<textarea id="textarea_help_content_editor_' . time() . '" class="textarea_help_content_editor" name="' . $SiteHelpPage . '" style="width:100%">' . $clsHelp->getValue($SiteHelpPage) . '</textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer"> 
			<button class="btn btn-primary btnSaveSiteHelpPage" mod_page="' . $mod_page . '" act_page="' . $act_page . '" area_page="' . $area_page . '">
				<i class="icon-ok icon-white"></i> ' . $core->get_Lang('Save') . '
			</button> 
			<button type="reset" class="btn btn-warning close_pop">
				<i class="icon-retweet icon-white"></i> <span>Đóng lại</span>
			</button>
		</div>';
    } else {
        $html .= '<style>
			.formatTextStandard{width:99%;padding-right:1%;max-height:470px;overflow-y:scroll}
		</style>';
        $html .= '<div class="formatTextStandard">';
        if ($clsHelp->getValue($SiteHelpPage) != '') {
            $html .= $clsHelp->getValue($SiteHelpPage);
        } else {
            $html .= $core->get_Lang('Help content empty !');
        }
        $html .= '</div>';
    }
    echo $html;
    die();
}

function default_ajaxSaveSiteHelp()
{
    global $core;
    #
    $clsHelp = new Help();
    $mod_page = $_POST['mod_page'];
    $act_page = $_POST['act_page'];
    $area_page = $_POST['area_page'];

    $SiteHelpPage = 'Site_Help_' . $mod_page . '_' . $act_page;
    if ($area_page != '') {
        $SiteHelpPage .= '_' . $area_page;
    }
    $help_content = isset($_POST['help_content']) ? addslashes($_POST['help_content']) : '';
    $clsHelp->updateValue($SiteHelpPage, $help_content);
    echo (1);
    die();
}

function default_saveField()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $html = '';
    #
    $clsTable = $_POST['clsTable'];
    $pkey = $_POST['pkey'];
    $pvalTable = $_POST['pvalTable'];
    $toField = $_POST['toField'];
    $val = $_POST['val'];
    $allowDuplicate = $_POST['allowDuplicate'];
    #
    $clsClassTable = new $clsTable();
    if ($allowDuplicate == 1) {
        //allow duplicate
        $clsClassTable->updateOne($pvalTable, $toField . "='" . addslashes($val) . "'");
        if ($toField == 'allotment') {
            $clsClassTable->updateOne($pvalTable, "seat_available = '" . addslashes($val) . "'");
        }
        $html = $val;
    } else {
        $all = $clsClassTable->getAll($toField . "='$val'");
        if ($all[0][$pkey] != '' && $all[0][$pkey] != $pvalTable) {
            $html = 'IsDuplicated';
        } else {
            $clsClassTable->updateOne($pvalTable, $toField . "='" . addslashes($val) . "'");
            $html = $val;
        }
    }
    sleep(1);
    echo ($html);
    die();
}

function default_ajOpenFeedback()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $clsISO = new ISO();

    if ($tp == 'F') {
        $html = '
		<div class="headPop">
			<h3>Send Feedback To <a style="color:#333" href="http://www.vietiso.com">VIET<font color="#F93">ISO</font></a></h3>
			<a href="javscript:void(0);" class="close_pop closeEv"></a>
		</div>
		<div class="space-6"></div>
		<form method="post" action="" id="form-feedback">
			<div class="row">
				<div class="col-xs-6">
					<div class="btn btn-sm btn-danger btn-block btn-grey faded button_toggle" act="bug">
						<i class="fa fa-bug"></i> Report a Problem
					</div>
				</div>
				<div class="col-xs-6">
					<div class="btn btn-sm btn-primary btn-block button_toggle" act="feedback">
						<i class="fa fa-comment"></i> Send Feedback
					</div>
				</div>
			</div>
			<div class="space-6"></div>
			<input type="hidden" id="type" value="feedback">
			<div class="row">
				<div class="col-xs-12">
					<textarea id="message_feedback" placeholder="Enter your feedback." class="col-xs-12" style="height:270px;"></textarea>
					<div class="clearfix"></div>
					<div class="form-actions mt20 mb20">
						<a id="send_feedback" style="padding:10px" class="btn btn-primary">
							<i class="icon-ok icon-white bigger-110"></i> Send Message
						</a>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function(){
				$(\'#message_feedback\').focus();
				$(\'.button_toggle\').click(function(e) {
					var act = $(this).attr(\'act\');
					$(\'.button_toggle\').removeClass(\'btn-grey faded\').addClass(\'btn-grey faded\');
					$(this).removeClass(\'btn-grey faded\');
					$(\'#type\').val(act);
					var placeholder = (act == \'bug\') ? \'Describe the problem and any instructions required to replicate it.\' : \'Enter your feedback.\';
					$(\'#message_feedback\').attr(\'placeholder\',placeholder);
				});
			});
		</script>';
        echo $html;
        die();
    } else if ($tp == 'S') {
        $type = isset($_POST['type']) ? $_POST['type'] : 'feedback';
        $REQUEST_URI = $_POST['REQUEST_URI'];
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        if (trim($message) == '' && $message == '0') {
            echo '_EMPTY';
            die();
        }
        #
        $from = 'no-reply@vietiso.com';
        $to = 'support@vietiso.com';
        if ($type == 'feedback') {
            $suject = '✪✪✪ New feedback from ' . PAGE_NAME;
        } else {
            $suject = '✪✪ New bug from ' . PAGE_NAME;
            $message .= '
			<br />
			<u>Link bug</u>:' . $REQUEST_URI;
        }
        $owner = PAGE_NAME;
        $message = '
		Xin chào,
		<h2>Bạn nhận được một ' . ($type == 'feedback' ? 'phản hồi' : 'thông báo bug') . ' được gửi từ (' . $core->_USER['first_name'] . ' ' . $core->_USER['last_name'] . ') </h2>
		<strong> ' . PAGE_NAME . ' </strong> | ' . $clsISO->converTimeToText(time()) . ' <br />
		<div style="clear:both; margin-top:6px"></div>
		<div style="padding:10px; border:2px dashed #DDD; background:#FFC">' . $message . '</div>
		<br />
		Cảm ơn trước sự kiên nhẫn và hỗ trợ của bạn.
		<div> Thông báo này đã được gửi từ <a href="mailto:' . $core->_USER['user_name'] . '" target="_blank"> ' . $core->_USER['user_name'] . ' </a> . Vui lòng reply lại nếu bạn nhận được email thống báo này.</div>';
        #
        $is_send_mail = $clsISO->sendEmail($from, $to, $suject, $message, $owner);
        //$is_send_mail = $clsISO->sendEmail($from,$to,$suject,$message,$owner);
        if ($is_send_mail) {
            sleep(1);
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

function default_ajOpenNote()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    $user_id = $core->_USER['user_id'];
    #
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $clsUser = new User();

    $html = '
	<div class="headPop">
		<h3>' . $core->get_Lang('My Notes') . '</h3>
		<a href="javscript:void(0);" class="close_pop closeEv"></a>
	</div>
	<form method="post" action="" id="form-feedback">
		<div class="row-span">
			<textarea id="myNotes" placeholder="' . $core->get_Lang('Enter your notes') . '." class="textarea full" style="height:250px;">' . $clsUser->getOneField('notes', $user_id) . '</textarea>
			<div class="clearfix"></div>
			<div class="modal-footer">
				<a id="btnUpdateNotes" user_id="' . $user_id . '" style="padding:10px" class="btn btn-primary">
					<i class="icon-ok icon-white bigger-110"></i> ' . $core->get_Lang('Save') . '
				</a>
			</div>
		</div> 
	</div>
	<script type="text/javascript">
		$(function(){
			$(document).on(\'click\',\'#btnUpdateNotes\',function(ev){
				var $_this = $(this);
				var adata = {};
				adata[\'clsTable\'] = \'User\';
				adata[\'pkey\'] = \'user_id\';
				adata[\'pvalTable\'] = $_this.attr(\'user_id\');
				adata[\'toField\'] = \'notes\';
				adata[\'val\'] = $(\'#myNotes\').val();
				adata[\'allowDuplicate\'] = 1;
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script + \'/?mod=home&act=saveField\',
					data: adata,
					success: function(html) {
						vietiso_loading(0);
						alertify.success(\'Sucess !\');
					}
				});
				return false;
			});
		});
	</script>';
    echo $html;
    die();
}

function default_ajOpenSidebar()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    $user_id = $core->_USER['user_id'];

    $clsConfiguration = new Configuration();
    $val = isset($_POST['val']) ? $_POST['val'] : 0;
    $clsConfiguration->updateValue('SIDEBAR_TOGGLE_' . $user_id, $val);
    echo ($val);
    die();
}

function default_ajLoadChartBooking()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];

    $clsBooking = new Booking();
    $Current_Now = time();
    $Current_Year = date('Y', $Current_Now);

    $html = '<div id="placeholder" class="demo-placeholder"></div>';
    $html .= '
	<style>
	.demo-placeholder {
		width: 530px;
		height: 200px;
		font-size: 14px;
		line-height: 1.2em;
	}
	</style>
	<script type="text/javascript">
		$(function() {
			var hotel = [],
				tour = [],
				cruise = [],
				tailor = [];
			';
    for ($i = 1; $i <= 12; $i++) {
        if ($clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_hotel', 'default')) {
            $html .= '
					hotel.push([' . $i . ',' . $clsBooking->getTotalBooking($i, $Current_Year, 'Hotel') . ']);
					';
        }
        if ($clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_tour', 'default')) {
            $html .= '
					tour.push([' . $i . ',' . $clsBooking->getTotalBooking($i, $Current_Year, 'Tour') . ']);
					';
        }
        if ($clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_cruise', 'default')) {
            $html .= '
					cruise.push([' . $i . ',' . $clsBooking->getTotalBooking($i, $Current_Year, 'Cruise') . ']);
					';
        }
        if ($clsISO->getCheckActiveModulePackage($package_id, 'booking', 'booking_tailor', 'default')) {
            $html .= '
					tailor.push([' . $i . ',' . $clsBooking->getTotalBooking($i, $Current_Year, 'Tailor') . ']);
					';
        }
    }
    $html .= '
			var plot = $.plot("#placeholder",[
				{ data: hotel,label: "' . $core->get_Lang('bookinghotel') . '"},
				{ data: tour,label: "' . $core->get_Lang('bookingtour') . '"},
				{ data: cruise,label: "' . $core->get_Lang('bookingcruise') . '"},
				{ data: tailor,label: "' . $core->get_Lang('bookingtailor') . '"}],
				{
				series: {
					lines: {
						show: true
					},
					points: {
						show: true
					}
				},
				grid: {
					hoverable: true,
					clickable: true
				},
				xaxis: {
					min: 1,
					max: 12
				},
				yaxis: {
					min: 0,
					max: 50
				}
			});
			$("<div id=\'tooltip\'></div>").css({
				position: "absolute",
				display: "none",
				border: "2px solid #c00000",
				padding: "5px",
				"background-color": "#FFF",
				"border-radius" : "3px",
				"-moz-border-radius" : "3px",
				"-webkit-border-radius" : "3px",
				"-khtml-border-radius" : "3px",
				"-o-border-radius" : "3px",
				"font-size" : "11px"
			}).appendTo("body");
			$("#placeholder").bind("plothover",function (event,pos,item) {
				if (item) {
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(0);
					$("#tooltip").html(item.series.label + "<br />Total(s): "+y)
						.css({top: item.pageY+5,left: item.pageX+5})
						.fadeIn(200);
				} else {
					$("#tooltip").hide();
				}
			});
		});
	</script>';
    echo $html;
    die();
}

function default_ajLoadChartBooking2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    $user_id = $core->_USER['user_id'];

    $clsBooking = new Booking();
    $Current_Now = time();
    $Current_Year = date('Y', $Current_Now);

    $html = '<div id="placeholder" class="demo-placeholder"></div>';
    $html .= '
	<style>
	.demo-placeholder {
		width: 100%;
		height: 250px;
		font-size: 14px;
		line-height: 1.2em;
	}
	</style>
	<script type="text/javascript">
		$(function() {
			var hotel = [],
				tour = [],
				tailor = [];
			';
    for ($i = 1; $i <= 12; $i++) {
        $html .= '
				hotel.push([' . $i . ',' . $clsBooking->getTotalBooking($i, $Current_Year, 'Hotel') . ']);
				tour.push([' . $i . ',' . $clsBooking->getTotalBooking($i, $Current_Year, 'Tour') . ']);
				tailor.push([' . $i . ',' . $clsBooking->getTotalBooking($i, $Current_Year, 'Tailor') . ']);
				';
    }
    $html .= '
			var plot = $.plot("#placeholder",[
				{ data: hotel,label: "' . $core->get_Lang('bookinghotel') . '"},
				{ data: tour,label: "' . $core->get_Lang('bookingtour') . '"},
				{ data: tailor,label: "' . $core->get_Lang('bookingtailor') . '"}],
				{
				series: {
					lines: {
						show: true
					},
					points: {
						show: true
					}
				},
				grid: {
					hoverable: true,
					clickable: true
				},
				xaxis: {
					min: 1,
					max: 12
				},
				yaxis: {
					min: 0,
					max: 50
				}
			});
			$("<div id=\'tooltip\'></div>").css({
				position: "absolute",
				display: "none",
				border: "2px solid #c00000",
				padding: "5px",
				"background-color": "#FFF",
				"border-radius" : "3px",
				"-moz-border-radius" : "3px",
				"-webkit-border-radius" : "3px",
				"-khtml-border-radius" : "3px",
				"-o-border-radius" : "3px",
				"font-size" : "11px"
			}).appendTo("body");
			$("#placeholder").bind("plothover",function (event,pos,item) {
				if (item) {
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(0);
					$("#tooltip").html(item.series.label + "<br />Total(s): "+y)
						.css({top: item.pageY+5,left: item.pageX+5})
						.fadeIn(200);
				} else {
					$("#tooltip").hide();
				}
			});
		});
	</script>';
    echo $html;
    die();
}

function default_ajUploadForm()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    $user_id = $core->_USER['user_id'];
    #
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $clsTable = isset($_POST['clsTable']) ? $_POST['clsTable'] : '';
    $file_images = isset($_POST['file_images']) ? $_POST['file_images'] : '';
    #
    if ($file_images != '') {
        $file_images = rtrim($file_images, '|');
        $file_images = explode('|', $file_images);
        if ($file_images != '' && !empty($clsTable)) {
            $clsClassTable = new $clsTable();
            for ($i = 0; $i < count($file_images); $i++) {
                $path_parts = pathinfo($file_images[$i]);
                $title = trim(strip_tags($path_parts['filename']));
                #
                $fx = "$clsClassTable->pkey,table_id,type,title,slug,image,order_no,user_id,reg_date";
                $vx = "'" . $clsClassTable->getMaxID() . "'
				,'" . $table_id . "'
				,'" . $type . "'
				,'" . $title . "'
				,'" . $core->replaceSpace($title) . "'
				,'" . $file_images[$i] . "'
				,'" . $clsClassTable->getMinOrderNo($table_id, $type) . "'
				,'" . $user_id . "'
				,'" . time() . "'";
                #
                //print_r($fx.'xxxx'.$vx); die();
                $clsClassTable->insertOne($fx, $vx);
            }
        }
    }
}

function default_ajOpenElfinder()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    $user_id = $core->_USER['user_id'];
    #
    $html = '
	<style>
		#elfinder *,
		#elfinder *:before,
		#elfinder *:after{-webkit-box-sizing:content-box !important; -moz-box-sizing:content-box !important; box-sizing:content-box !important;}
		#elfinder{ position:relative;}
	</style>
	<link rel="stylesheet" type="text/css" href="' . PCMS_URL . '/editor/elfinder/css/elfinder.min.css">
	<link rel="stylesheet" type="text/css" href="' . PCMS_URL . '/editor/elfinder/css/theme.css">
	<script type="text/javascript" src="' . PCMS_URL . '/editor/elfinder/js/elfinder.min.js"></script>
	<div class="headPop"> 
		<a class="closeEv close_pop" data-dismiss="modal" aria-hidden="true">&nbsp;</a> 
		<h3>ISOCMS Manager</h3>
	</div>
	<div id="elfinder"></div>';
    echo $html;
    die();
}

function default_ajReloadSITEMAP()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    #
    $PCMS_URL = "https://" . $_SERVER['HTTP_HOST'];
    //	$data = file_get_contents($PCMS_URL.'/sitemap.php');
    sleep(2);
    echo '_SUCCESS';
    die();
}

function default_ajDeleteGalImg()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
    //    header('Content-Type: application/json');
    $clsTour = new Tour();

    $img_id = Input::post('img_id', 0);
    $clsTable = Input::post('clsTable');

    $clsClassTable = new $clsTable();

    $result = array('result' => 'error', 'mes' => $core->get_Lang('error_data_image'));


    if (empty($img_id)) {
        $result = array('result' => 'error', 'mes' => $core->get_Lang('error_data_image'));
    }
    if (!empty($img_id)) {
        if ($clsClassTable->deleteOne($img_id)) {
            $result = array('result' => 'success', 'mes' => $core->get_Lang('success_del_image'));
        } else {
            $result = array('result' => 'error', 'mes' => $core->get_Lang('error_del_image'));
        }
    }

    echo json_encode($result);
    die();
}

function default_upload_image_isoman()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page;
    global $core, $clsModule, $clsButtonNav;
    $user_id = $core->_USER['user_id'];
    #
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $clsTable = isset($_POST['type']) ? $_POST['type'] : '';
    $file_images = isset($_POST['file_images']) ? $_POST['file_images'] : '';
    #
    if ($file_images != '') {
        $file_images = rtrim($file_images, '|');
        $file_images = explode('|', $file_images);
        if ($file_images != '' && !empty($clsTable)) {
            $clsClassTable = new $clsTable();
            $clsClassTable->updateOne($table_id, array(
                'image' => $file_images[0]
            ));
        }
        echo $file_images[0];
    }
}

function default_upload_image()
{
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO;
    global $clsConfiguration, $clsISO, $oneProfile, $profile_id, $_frontIsLoggedin_user_id;
    #
    $msg = '_error';
    $table_id = (int)Input::post('table_id', 0, true);
    $filename = Input::post('filename');
    $clsTable = Input::post('clsTable');
    $imgdata = Input::post('imgdata');
    $img_gallery_title = Input::post('img_gallery_title');

    $clsClassTable = new $clsTable();

    if (!$filename) {
        $filename = md5(uniqid(rand(), true)) . '.jpg';
    }
    #
    $image = '';
    $msg = 'error';
    if (!class_exists('UploadFile')) {
        require_once(DIR_COMMON . '/class.upload.php');
    }
    if ($imgdata) {
        $clsUploadFile = new UploadFile();
        $image = $clsUploadFile->base642imagejpeg($imgdata, $filename, "/content");
    }
    $old_image = $clsClassTable->getOneField('image', $table_id);
    if (!empty($image) && file_exists(ABSPATH . $image)) {
        if ($clsClassTable->updateOne($table_id, array(
            'image' => $image
        ))) {
            if (is_file(ABSPATH . $old_image && $old_image != $image)) {
                unlink(ABSPATH . $old_image);
            }
            $msg = 'success';
            $image = $image;
            echo ($image);
            die();
        }
    }
    // Return
    echo ($msg);
    die();
}

function default_upload_gallery()
{
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO, $dbconn;
    global $clsConfiguration, $clsISO, $oneProfile, $profile_id, $_frontIsLoggedin_user_id;
    #
    $msg = 'error';
    $table_id = (int)Input::post('table_id', 0, true);
    $clsTableGallery = Input::post('clsTableGallery');
    $filename = Input::post('filename');
    $imgdata = Input::post('imgdata');
    $img_gallery_title = Input::post('img_gallery_title');
    if (!$filename) {
        $filename = md5(uniqid(rand(), true)) . '.jpg';
    }
    #
    $up = '';
    $msg = 'error';
    if (!class_exists('UploadFile')) {
        require_once(DIR_COMMON . '/class.upload.php');
    }
    if ($imgdata) {
        $clsUploadFile = new UploadFile();
        $up = $clsUploadFile->base642imagejpeg($imgdata, $filename, "/content");
    }
    $clsClassTable = new $clsTableGallery();

    if (!empty($up) && file_exists(ABSPATH . $up)) {
        if ($clsClassTable->insert(array(
            $clsClassTable->pkey => $clsClassTable->getMaxId(),
            'type' => 'TourImage',
            'table_id' => $table_id,
            'image' => $up,
            'title' => $img_gallery_title,
            'slug' => $core->replaceSpace($img_gallery_title),
            'order_no' => $clsClassTable->getMinOrderNo($table_id),
            'reg_date' => time()
        ))) {
            $msg = 'success';
        }
    }
    echo ($msg);
    die();
}

function default_load_open_cropper()
{
    //ini_set('display_errors',1);
    //error_reporting(E_ALL ^ E_NOTICE);
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO;

    $table_id = Input::post('table_id', 0);
    $imgdata = Input::post('imgdata');
    $smarty->assign('objectUrl', $imgdata);

    $openFrom = Input::post('openFrom', 'image');
    $smarty->assign('openFrom', $openFrom);

    // Return
    $html = $core->build('modal.cropper.tpl');
    echo $html;
    die();
}

function default_ajOpenGallery()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;
    #
    $clsPagination = new Pagination();

    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $clsTable = isset($_POST['clsTable']) ? $_POST['clsTable'] : '';
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';

    $clsClassTable = new $clsTable();
    // Load List
    if ($tp == 'L') {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $number_per_page = isset($_POST['number_per_page']) ? intval($_POST['number_per_page']) : 10;
        //echo $number_per_page; die();
        #
        $cond = "is_trash=0 and table_id='$table_id'";
        if (trim($keyword) != '' && $keyword != '0') {
            $slug = $core->replaceSpace($keyword);
            $cond .= " and (title like '%$keyword%' or slug like '%$slug%')";
        }
        #
        $html = '';
        $totalRecord = $clsClassTable->countItem($cond);
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";
        $lstItem = $clsClassTable->getAll($cond . $order_by);
        //        $clsISO->print_pre($cond . $order_by,true);die();
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $table_image_id = $lstItem[$i][$clsClassTable->pkey];
                $html .= '<div class="gallery-item bootstrap">';
                $html .= '<a><img class="img-responsive mr-3 mb-2 preview-img" src="' . $ftp_abs_path_image . $clsClassTable->getImage($table_image_id, 140, 100, $lstItem[$i]) . '" alt="' . $lstItem[$i]['title'] . '" ></a>';
                $html .= '  <div class="gallery-toolbar">
						<a class="text-white" onClick="delete_gallery(this)" table_id="' . $table_id . '" table_image_id="' . $lstItem[$i][$clsClassTable->pkey] . '">' . $clsISO->makeIcon('times') . '</a>
					</div>
				</div>';
            }
        }
        $html .= '';
        echo $html;
        die();
    } else {
        echo 'error';
        die();
    }
}

function default_ajDeleteGallery()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
    // header('Content-Type: application/json');
    $clsTable = Input::post('clsTable');
    $clsClassTable = new $clsTable();
    $table_id = (int)Input::post('table_id', 0);
    $image_id = (int)Input::post('image_id', 0);
    #
    $result = array('result' => 'error', 'mes' => $core->get_Lang('error_data_image'));
    if ($image_id == 0) {
        $result = array('result' => 'error', 'mes' => $core->get_Lang('error_data_image'));
    } else if ($image_id) {
        if ($clsClassTable->deleteOne($image_id)) {
            $result = array('result' => 'success', 'mes' => $core->get_Lang('success_del_image'));
        } else {
            $result = array('result' => 'error', 'mes' => $core->get_Lang('error_del_image'));
        }
    }
    // Return
    echo @json_encode($result);
    die();
}

function default_ajaxChartBooking()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
    $clsBooking = new Booking();
    $assign_list["clsBooking"] = $clsBooking;

    $year = isset($_POST['year']) ? $_POST['year'] : date('Y');
    $cat = $_POST['cat'];
    $timePeriod = isset($_POST['timePeriod']) ? $_POST['timePeriod'] : 'month';

    $itemSuccess = [];
    $itemFail = [];
    $categories = [];

    switch ($timePeriod) {
        case 'day':
            for ($i = 0; $i < 24; $i += 6) {
                $itemS = $clsBooking->getTotalBookingAdmin($i, $year, $cat != 'all' ? $cat : '', 1, 'hour');
                $itemF = $clsBooking->getTotalBookingAdmin($i, $year, $cat != 'all' ? $cat : '', 2, 'hour');
                $itemSuccess[] = (int)$itemS;
                $itemFail[] = (int)$itemF;
                $categories[] = "$i:00 - " . ($i + 5) . ":59";
            }
            break;

        case 'week': // Hiển thị theo thứ trong tuần
            $daysOfWeek = ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ Nhật"];
            for ($i = 1; $i <= 7; $i++) {
                $itemS = $clsBooking->getTotalBookingAdmin($i, $year, $cat != 'all' ? $cat : '', 1, 'dayOfWeek');
                $itemF = $clsBooking->getTotalBookingAdmin($i, $year, $cat != 'all' ? $cat : '', 2, 'dayOfWeek');
                $itemSuccess[] = (int)$itemS;
                $itemFail[] = (int)$itemF;
                $categories[] = $daysOfWeek[$i - 1];
            }
            break;

        case 'month':
            $daysInMonth = date("t", strtotime("$year-01-01"));
            $groupSize = ($daysInMonth == 31) ? 6 : 5;

            for ($i = 1; $i <= $daysInMonth; $i += $groupSize) {
                $totalSuccess = 0;
                $totalFail = 0;
                for ($j = $i; $j < $i + $groupSize && $j <= $daysInMonth; $j++) {
                    $totalSuccess += $clsBooking->getTotalBookingAdmin($j, $year, $cat != 'all' ? $cat : '', 1, 'day');
                    $totalFail += $clsBooking->getTotalBookingAdmin($j, $year, $cat != 'all' ? $cat : '', 2, 'day');
                }
                $itemSuccess[] = (int)$totalSuccess;
                $itemFail[] = (int)$totalFail;
                $categories[] = "Ngày $i - " . min($i + $groupSize - 1, $daysInMonth);
            }
            break;
    }

    $data = [
        'itemSuccess' => $itemSuccess,
        'itemFail' => $itemFail,
        'categories' => $categories
    ];

    echo json_encode($data);
    die();
}



function default_open_texthelp()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
    $title = isset($_POST['key']) ? $_POST['key'] : '';
    $label = isset($_POST['label']) ? $_POST['label'] : '';
    $desc = $clsConfiguration->getValue($title);
    $id_textarea = 'texthelp' . $title . time();
    $html = '';
    if ($title != '' && $label != '') {
        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void(0);" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('Text help') . '</h3>
		</div>
		<form method="post" action="" id="frmCrxCruise">
			<div class="modal-body"> 
				<div class="form-group"> 
					<label class="col-form-label">' . $label . '</label> 
				</div> 
				<div class="form-group"> 
					<label class="col-form-label">Text help</label> 
					<textarea id="' . $id_textarea . '" class="isoTextArea form-control" style="width:100%; height:100px;">' . $desc . '</textarea> 
				</div> 
			</div> 
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-save" onClick="pop_save_texthelp(this, event);" data-key="' . $title . '">' . $core->get_Lang('Save') . '</button>
				<input type="hidden" name="tp" value="S" />
			</div>
		</form>';
    }
    echo $html;
    die;
}

function default_pop_save_texthelp()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule;
    $title = isset($_POST['key']) ? $_POST['key'] : '';
    $value = isset($_POST['value']) ? $_POST['value'] : '';
    $update = $clsConfiguration->updateValue($title, $value);
}

function default_checkTitle()
{
    global $smarty, $core, $_LANG_ID, $clsISO;

    $result = ['result' => true];
    $title = Input::post('title', '');
    $clsClassTable = Input::post('clsClassTable', '');

    $clsClassTable = new $clsClassTable();
    if ($title != '') {
        $cond = "is_trash=0 and slug='" . $core->replaceSpace($title) . "'";
        $check_title = $clsClassTable->getAll($cond, $clsClassTable->pkey);
        if ($check_title > 0) {
            $result = ['result' => false, 'message' => 'Tiêu đề này đã tồn tại!'];
        }
    } else {
        $result = ['result' => false, 'message' => 'Tiêu đề không được bỏ trống!'];
    }
    echo json_encode($result);
    die();
}

function default_updateLinkPreview()
{
    $table = ucfirst($_POST["table"]);
    $clsTable = new $table;
    $id = $_POST["id"];
    if (!class_exists($table)) die;
    $link = $clsTable->getLink($id);
    echo !empty($link) ? $link : '';
}
