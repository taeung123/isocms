<?php
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod , $_LANG_ID, $act, $menu_current, $current_page,$oneSetting;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$assign_list["clsModule"] = $clsModule;
	$user_id = $core->_USER['user_id'];
	/*Get type of list news*/
	$type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
	$assign_list["type_list"] = $type_list;
	/**/
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;
	$assign_list["clsClassTable"] = $clsClassTable;
	#
	if(isset($_POST['filter'])&&$_POST['filter']=='filter'){
		$link = '';
		if($_POST['keyword']!=''&&$_POST['keyword']!='nhập link, title hoặc keyword'){
			$link .= '&keyword='.$_POST['keyword'];
		}
		header('location: '.PCMS_URL.'/index.php?mod='.$mod.$link);
	}
	#
	$allResult = $clsClassTable->getAll("config_link like 'http:%'");
	for($i=0;$i<count($allResult);$i++){
		$config_link = str_replace('http://trippy.vietiso.vn/','/',$allResult[$i]['config_link']);
		$config_link = str_replace('http://beta.trippy.vn/','/',$config_link);
		$config_link = str_replace(DOMAIN_NAME,'',$config_link);
		$clsClassTable->updateOne($allResult[$i]['meta_id'],"config_link='$config_link'"); 
	}

	#
	
	/*List all item*/
	$cond = "1=1";
	$orderBy = " meta_id desc";
	#Filter By Keyword
	if(isset($_GET['keyword'])){
		$short_keyword  = str_replace(DOMAIN_NAME,'',$_GET['keyword']);
		if(strpos($short_keyword,'|')!==false){
			$short_keyword = ltrim($short_keyword,'|');
			$short_keyword = rtrim($short_keyword,'|');
			$cond .= " and (config_value_title='$short_keyword' or config_link='$short_keyword')";
		}else{
			$cond .= " and (config_value_title like '%".$_GET['keyword']."%' or config_value_intro like '%".$_GET['keyword']."%' or config_value_keyword like '%".$_GET['keyword']."%' or config_link like '%".$_GET['keyword']."%')";
		}
		$assign_list["keyword"] = $_GET['keyword'];
	}
	#-------Page Divide---------------------------------------------------------------
	$recordPerPage 	= 40;
	$currentPage = isset($_GET["page"])? $_GET["page"] : 1;
	$start_limit = ($currentPage-1)*$recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$lstAllItem = $clsClassTable->getAll($cond);
	$totalRecord = (is_array($lstAllItem)&&count($lstAllItem)>0)?count($lstAllItem):0;
	$totalPage = ceil($totalRecord / $recordPerPage);
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['currentPage'] = $currentPage;
	$listPageNumber =  array();
	for ($i=1; $i<=$totalPage; $i++){
		$listPageNumber[] = $i;
	}
	$assign_list['listPageNumber'] = $listPageNumber;
	$query_string = $_SERVER['QUERY_STRING'];
	$lst_query_string = explode('&',$query_string);
	$link_page_current = '';
	for($i=0;$i<count($lst_query_string);$i++){
		$tmp = explode('=',$lst_query_string[$i]);
		if($tmp[0]!='page')
			$link_page_current .= ($i==0)?'?'.$lst_query_string[$i]:'&'.$lst_query_string[$i];
	}
	$assign_list['link_page_current'] = $link_page_current;
	

	#-------End Page Divide-----------------------------------------------------------
	$allItem = $clsClassTable->getAll($cond." order by ".$orderBy.$limit);
	$assign_list["allItem"] = $allItem;
}
function default_edit()
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL & ~E_STRICT);
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act;
    global $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO;

    $assign_list['clsModule'] = $clsModule;

    $user_id = isset($core->_USER['user_id'])
        ? (int)$core->_USER['user_id']
        : 0;

    /*----------------------------------
     * Khởi tạo class
     *----------------------------------*/
    $classTable = 'Meta';
    $clsClassTable = new $classTable();

    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $assign_list['clsClassTable'] = $clsClassTable;

    /*----------------------------------
     * Lấy ID bản ghi
     *----------------------------------*/
    $string = isset($_GET[$pkeyTable])
        ? trim($_GET[$pkeyTable])
        : '';

    $pvalTable = 0;

    if ($string !== '') {
        $pvalTable = (int)$core->decryptID($string);
    }

    $assign_list['pvalTable'] = $pvalTable;

    /*----------------------------------
     * Lấy dữ liệu hiện tại
     *----------------------------------*/
    $oneItem = array();

    if ($pvalTable > 0) {
        $oneItem = $clsClassTable->getOne($pvalTable);

        if (!is_array($oneItem)) {
            $oneItem = array();
        }
    }

    $assign_list['oneItem'] = $oneItem;

    /*----------------------------------
     * Đếm ký tự meta
     *----------------------------------*/
    $metaTitle = $pvalTable > 0
        ? $clsClassTable->getMetaTitle($pvalTable)
        : '';

    $metaDescription = $pvalTable > 0
        ? $clsClassTable->getMetaDescription($pvalTable)
        : '';

    $assign_list['number_word_title'] =
        $clsISO->getCountMetaWord($metaTitle);

    $assign_list['number_word_description'] =
        $clsISO->getCountMetaWord($metaDescription);

    /*----------------------------------
     * Khởi tạo form
     *----------------------------------*/
    require_once DIR_COMMON . '/clsForm.php';

    $clsForm = new Form();
    $clsForm->setDbTable(
        $tableName,
        $pkeyTable,
        $pvalTable
    );

    $assign_list['clsForm'] = $clsForm;

    /*----------------------------------
     * Chưa submit
     *----------------------------------*/
    if (
        !isset($_POST['submit'])
        || $_POST['submit'] !== 'Update'
    ) {
        return;
    }

    /*----------------------------------
     * Hàm redirect nội bộ
     *----------------------------------*/
    $redirectMeta = function ($params = array()) use ($mod) {
        $url = PCMS_URL . '/?mod=' . urlencode($mod);

        foreach ($params as $key => $value) {
            $url .= '&' . urlencode($key)
                . '=' . urlencode($value);
        }

        header('Location: ' . $url);
        exit();
    };

    /*----------------------------------
     * Lấy và chuẩn hóa dữ liệu POST
     *----------------------------------*/
    $config_link = isset($_POST['config_link'])
        ? trim($_POST['config_link'])
        : '';

    $config_value_title = isset($_POST['config_value_title'])
        ? trim($_POST['config_value_title'])
        : '';

    /*
     * Loại bỏ domain khỏi config_link.
     */
    if (defined('DOMAIN_NAME') && DOMAIN_NAME !== '') {
        $config_link = str_replace(
            DOMAIN_NAME,
            '',
            $config_link
        );
    }

    /*
     * Loại bỏ domain hiện tại nếu người dùng nhập URL đầy đủ.
     */
    if (
        defined('DOMAIN_URL')
        && DOMAIN_URL !== ''
    ) {
        $config_link = str_replace(
            DOMAIN_URL,
            '',
            $config_link
        );
    }

    /*
     * Chuẩn hóa slash đầu.
     */
    if ($config_link !== '') {
        $config_link = '/' . ltrim($config_link, '/');
    }

    /*
     * Tránh link dạng //slug.
     */
    $config_link = preg_replace(
        '#/+#',
        '/',
        $config_link
    );

    /*----------------------------------
     * Validate bắt buộc
     *----------------------------------*/
    if ($config_link === '') {
        $redirectMeta(array(
            'act'     => 'edit',
            'message' => 'LinkRequired'
        ));
    }

    if ($config_value_title === '') {
        $redirectMeta(array(
            'act'     => 'edit',
            'message' => 'TitleRequired'
        ));
    }

    /*----------------------------------
     * Kiểm tra trùng config_link
     *----------------------------------*/
    $safeConfigLink = addslashes($config_link);

    $condDuplicateLink =
        "config_link='" . $safeConfigLink . "'";

    if ($pvalTable > 0) {
        $condDuplicateLink .=
            " AND " . $pkeyTable
            . "<>'" . (int)$pvalTable . "'";
    }

    $duplicateLink = $clsClassTable->getAll(
        $condDuplicateLink,
        $pkeyTable
    );

    if (
        is_array($duplicateLink)
        && count($duplicateLink) > 0
    ) {
        $params = array(
            'act'     => 'edit',
            'message' => 'LinkExists'
        );

        if ($pvalTable > 0) {
            $params[$pkeyTable] =
                $core->encryptID($pvalTable);
        }

        $redirectMeta($params);
    }

    /*----------------------------------
     * Lấy ảnh
     *----------------------------------*/
    $image = '';

    if (
        defined('_isoman_use')
        && _isoman_use
    ) {
        $image = isset($_POST['isoman_url_image'])
            ? trim($_POST['isoman_url_image'])
            : '';
    } else {
        $image = isset($_POST['image_src'])
            ? trim($_POST['image_src'])
            : '';
    }

    /*
     * Fallback cho template mới dùng name="image".
     */
    if (
        $image === ''
        && isset($_POST['image'])
        && !is_array($_POST['image'])
    ) {
        $image = trim($_POST['image']);
    }

    /*----------------------------------
     * Nút lưu
     *----------------------------------*/
    $button = isset($_POST['button'])
        ? $_POST['button']
        : '_EDIT';

    /*==================================================
     * INSERT
     *==================================================*/
    if ($pvalTable === 0) {
        $fields = array();
        $values = array();

        /*
         * Lấy các field dạng iso-column_name.
         */
        foreach ($_POST as $key => $val) {
            if (strpos($key, 'iso-') !== 0) {
                continue;
            }

            $fieldName = substr($key, 4);

            if (
                $fieldName === ''
                || !preg_match(
                    '/^[a-zA-Z0-9_]+$/',
                    $fieldName
                )
            ) {
                continue;
            }

            if (is_array($val)) {
                $val = implode(',', $val);
            }

            $fields[] = $fieldName;
            $values[] = "'" . addslashes($val) . "'";
        }

        /*
         * Field riêng không có prefix iso-.
         */
        $fields[] = 'config_link';
        $values[] = "'" . addslashes($config_link) . "'";

        $fields[] = 'config_value_title';
        $values[] =
            "'" . addslashes($config_value_title) . "'";

        $fields[] = 'user_id';
        $values[] = "'" . $user_id . "'";

        $fields[] = 'reg_date';
        $values[] = "'" . time() . "'";

        $fields[] = 'upd_date';
        $values[] = "'" . time() . "'";

        if ($image !== '' && $image !== '0') {
            $fields[] = 'image';
            $values[] = "'" . addslashes($image) . "'";
        }

        /*
         * Hệ thống isoCMS cũ thường không dùng AUTO_INCREMENT,
         * nên vẫn lấy getMaxId().
         */
        $meta_id = (int)$clsClassTable->getMaxId();

        if ($meta_id <= 0) {
            $meta_id = 1;
        }

        $fields[] = $pkeyTable;
        $values[] = "'" . $meta_id . "'";

        $schema = $clsClassTable->getSchemaMarkupFromPost();
        if (!$schema['success']) {

            $redirectMeta(array(
                'message' => 'insertFailed'
            ));
        }

			$fields[] = ',schema_markup';
			$values[] = ",'" . addslashes($schema['data']) . "'";

        /*
         * Loại bỏ field trùng nếu có.
         */
        $finalFields = array();
        $finalValues = array();

        foreach ($fields as $index => $fieldName) {
            if (isset($finalFields[$fieldName])) {
                continue;
            }

            $finalFields[$fieldName] =
                $fieldName;

            $finalValues[$fieldName] =
                $values[$index];
        }

        

        $fieldString = implode(
            ',',
            array_values($finalFields)
        );

        $valueString = implode(
            ',',
            array_values($finalValues)
        );

        $insertSuccess = $clsClassTable->insertOne(
            $fieldString,
            $valueString
        );

        if ($insertSuccess) {
            if ($button === '_LIST') {
                $redirectMeta(array(
                    'message' => 'InsertSuccess'
                ));
            }

            $redirectMeta(array(
                'act'       => 'edit',
                $pkeyTable  =>
                    $core->encryptID($meta_id),
                'message'   => 'InsertSuccess'
            ));
        }

        /*
         * Ghi log để xem chính xác câu insert khi lỗi.
         */
        error_log(
            '[META INSERT FAILED] Fields: '
            . $fieldString
            . ' | Values: '
            . $valueString
        );

        $redirectMeta(array(
            'message' => 'insertFailed'
        ));
    }

    /*==================================================
     * UPDATE
     *==================================================*/
    $updateValues = array();

    /*
     * Các field dạng iso-column_name.
     */
    foreach ($_POST as $key => $val) {
        if (strpos($key, 'iso-') !== 0) {
            continue;
        }

        $fieldName = substr($key, 4);

        if (
            $fieldName === ''
            || !preg_match(
                '/^[a-zA-Z0-9_]+$/',
                $fieldName
            )
        ) {
            continue;
        }

        if (is_array($val)) {
            $val = implode(',', $val);
        }

        $updateValues[$fieldName] =
            $fieldName
            . "='"
            . addslashes($val)
            . "'";
    }

    $updateValues['config_link'] =
        "config_link='"
        . addslashes($config_link)
        . "'";

    $updateValues['config_value_title'] =
        "config_value_title='"
        . addslashes($config_value_title)
        . "'";

    $updateValues['upd_date'] =
        "upd_date='" . time() . "'";

    $updateValues['user_update_id'] =
        "user_update_id='" . $user_id . "'";

    /*
     * Có ảnh thì cập nhật.
     */
    if ($image !== '' && $image !== '0') {
        $updateValues['image'] =
            "image='" . addslashes($image) . "'";
    } elseif (
        isset($_POST['isoman_url_image'])
        && trim($_POST['isoman_url_image']) === ''
    ) {
        /*
         * Cho phép xóa ảnh.
         */
        $updateValues['image'] = "image=''";
    }

    $schema = $clsClassTable->getSchemaMarkupFromPost();

    if (!$schema['success']) {

        $redirectMeta(array(
            'message' => 'updateFailed'
        ));
    }

    $updateValues['schema_markup'] =
            "schema_markup='" . addslashes($schema['data']) . "'";

    $valueString = implode(
        ',',
        array_values($updateValues)
    );

    $updateSuccess = $clsClassTable->updateOne(
        $pvalTable,
        $valueString
    );

    if ($updateSuccess) {
        if ($button === '_LIST') {
            $redirectMeta(array(
                'message' => 'UpdateSuccess'
            ));
        }

        $redirectMeta(array(
            'act'      => 'edit',
            $pkeyTable =>
                $core->encryptID($pvalTable),
            'message'  => 'UpdateSuccess'
        ));
    }

    error_log(
        '[META UPDATE FAILED] ID: '
        . $pvalTable
        . ' | Values: '
        . $valueString
    );

    $redirectMeta(array(
        'message' => 'updateFailed'
    ));
}
function default_trash(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	
	$param_url = '';
	

	if($clsClassTable->updateOne($pvalTable,"is_trash='1'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=TrashSuccess');
	}
}
function default_restore(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
	
	$param_url = '';
	

	if($clsClassTable->updateOne($pvalTable,"is_trash='0'")){
		header('location: '.PCMS_URL.'/?mod='.$mod.$param_url.'&message=RestoreSuccess');
	}
}
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav,$oneSetting, $clsISO;
	$user_id = $core->_USER['user_id'];
	#
	$classTable = "Meta";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey ;

	$string = isset($_GET[$pkeyTable])? ($_GET[$pkeyTable]) : '';
	$pvalTable = intval($core->decryptID($string)); 
	#

	#
	if($clsClassTable->deleteOne($pvalTable)){
		header('location: '.PCMS_URL.'/?mod='.$mod.'&message=DeleteSuccess');
	}
}
function default_setting(){
	global $assign_list, $core,$clsConfiguration,$dbconn,$mod,$act;
	#
	if(isset($_POST['submit']) && $_POST['submit']='UpdateConfiguration'){
		foreach($_POST as $key=>$val){
			$tmp = explode('-',$key);
			if($tmp[0]=='iso'){
				$clsConfiguration->updateValue($tmp[1],$val);
			}
		}
		header('location:'.PCMS_URL.'?mod='.$mod.'&act='.$act.'&message=updateSuccess');
	}
}
require_once(DIR_MODULES . '/meta/mod_default.php');
?>