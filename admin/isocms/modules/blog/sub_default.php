<?php
function default_default()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_user_group_id;
    global $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsBlogCategory = new BlogCategory();
    $assign_list["clsBlogCategory"] = $clsBlogCategory;

    /* Get type of list blog */
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;

    $blogcat_id = isset($_GET['blogcat_id']) ? intval($_GET['blogcat_id']) : 0;
    $assign_list["blogcat_id"] = $blogcat_id;
    /**/
    $classTable = "Blog";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if (isset($_POST['blogcat_id']) && $_POST['blogcat_id'] != '') {
            $link .= '&blogcat_id=' . $_POST['blogcat_id'];
        }
        if (isset($_POST['user_ctv_id']) && $_POST['user_ctv_id'] != '' && intval($_POST['user_ctv_id']) != 0) {
            $link .= '&user_ctv_id=' . $_POST['user_ctv_id'];
        }
        if (isset($_POST['is_approve_id']) && $_POST['is_approve_id'] != '' && $_POST['is_approve_id'] != 0) {
            $link .= '&is_approve_id=' . $_POST['is_approve_id'];
        }
        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {
            $link .= '&from_date=' . $_POST['from_date'];
        }
        if (isset($_POST['to_date']) && $_POST['to_date'] != '') {
            $link .= '&to_date=' . $_POST['to_date'];
        }
        if (isset($_POST['keyword']) && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        if (isset($_POST['type_list']) && in_array($_POST['type_list'], array('Publish', 'Draft', 'Trash'))) {
            $link .= '&type_list=' . $_POST['type_list'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    $cond = "1=1";
    //Check By CTV
    if ($_user_group_id == 5) {
        $cond .= " and user_id='$user_id'";
    } else {
        if ($user_id == 1) {
        } else {
            $cond .= " and is_approve=1";
        }
    }
    $pUrl = '';
    if ($blogcat_id > 0) {
        $cond .= " and cat_id = '" . $blogcat_id . "'";
        $pUrl .= '&blogcat_id=' . $blogcat_id;
    }

    if (isset($_GET['user_ctv_id']) && intval($_GET['user_ctv_id']) > 0) {
        $cond .= " and user_id =  '" . $_GET['user_ctv_id'] . "'";
        $assign_list["user_ctv_id"] = $_GET['user_ctv_id'];
        $pUrl .= '&user_ctv_id=' . $_GET['user_ctv_id'];
    }
    if (isset($_GET['is_approve_id']) && intval($_GET['is_approve_id']) > 0) {
        if ($_GET['is_approve_id'] == 2) {
            $cond .= " and is_approve =  '0'";
        } else {
            $cond .= " and is_approve =  '" . $_GET['is_approve_id'] . "'";
        }
        $assign_list["is_approve_id"] = $_GET['is_approve_id'];
        $pUrl .= '&is_approve_id=' . $_GET['is_approve_id'];
    }

    if (!empty($_GET['from_date'])) {
        //$from_date = str_replace('/', '-', $_GET['from_date']);
        $from_date = $_GET['from_date'];
        $from_date = strtotime(str_replace('/', '-', $from_date));
        $cond .= " and reg_date >=  '" . $from_date . "'";
        $assign_list["from_date"] = $from_date;
        $assign_list["from_date_value"] = date('d/m/Y', $from_date);
        $pUrl .= '&from_date=' . $_GET['from_date'];
    }

    if (!empty($_GET['to_date'])) {
        //$to_date = str_replace('/', '-', $_GET['to_date']);
        $to_date = $_GET['to_date'];
        $to_date = strtotime(str_replace('/', '-', $to_date) . ' 23:59:59');
        $cond .= " and reg_date <=  '" . $to_date . "'";
        $assign_list["to_date"] = $to_date;
        $assign_list["to_date_value"] = date('d/m/Y', $to_date);
        $pUrl .= '&to_date=' . $_GET['to_date'];
    }

    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and (slug like '%" . $keyword . "%' or title like '%" . addslashes($_GET['keyword']) . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $assign_list["pUrl"] = $pUrl;
    $cond2 = $cond;
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    } elseif ($type_list == 'Publish') {
        $cond .= " and is_trash=0 and is_online=1";
    } elseif ($type_list == 'Draft') {
        $cond .= " and is_trash=0 and is_online=0";
    } else {
        $cond .= " and is_trash=0";
    }

    $orderBy = "order_no DESC";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPageOptions = array(20, 50, 100, 200);
    $recordPerPageSessionKey = 'admin_blog_recordperpage';
    $recordPerPage = isset($_GET["recordperpage"]) ? intval($_GET["recordperpage"]) : intval(vnSessionGetVar($recordPerPageSessionKey));
    if (!in_array($recordPerPage, $recordPerPageOptions, true)) {
        $recordPerPage = 20;
    }
    if (isset($_GET["recordperpage"])) {
        vnSessionSetVar($recordPerPageSessionKey, $recordPerPage);
    }
    $currentPage = isset($_GET["page"]) ? max(1, intval($_GET["page"])) : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $lstAllItem = $clsClassTable->getAll($cond);
    $totalRecord = (is_array($lstAllItem) && count($lstAllItem) > 0) ? count($lstAllItem) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
    $assign_list['previousPage'] = max(1, $currentPage - 1);
    $assign_list['nextPage'] = min(max(1, $totalPage), $currentPage + 1);
    $assign_list['showingStart'] = $totalRecord > 0 ? $start_limit + 1 : 0;
    $assign_list['showingEnd'] = min($start_limit + $recordPerPage, $totalRecord);

    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;


    $listPageNumber = array();
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
    //print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    unset($allItem);
    #
    $allTrash = $clsClassTable->getAll($cond2 . " and is_trash=1", $clsClassTable->pkey);
    $assign_list["number_trash"] = is_array($allTrash) ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_item"] = is_array($allUnTrash) ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll($cond2 . " and is_trash=0", $clsClassTable->pkey);
    $assign_list["number_all"] = is_array($allAll) ? count($allAll) : 0;
    $allPublish = $clsClassTable->getAll($cond2 . " and is_trash=0 and is_online=1", $clsClassTable->pkey);
    $assign_list["number_publish"] = is_array($allPublish) ? count($allPublish) : 0;
    $allDraft = $clsClassTable->getAll($cond2 . " and is_trash=0 and is_online=0", $clsClassTable->pkey);
    $assign_list["number_draft"] = is_array($allDraft) ? count($allDraft) : 0;
    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateBlogIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess');
        }
    }
}

function default_ajUpdPosSortBlog()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    #
    $order = $_POST['order'] ?? [];
    $clsISO->sortByData('Blog', $order);
}

function default_edit()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $pvalTable, $clsClassTable, $_user_group_id;
    global $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;
    $clsContinent = new Continent();
    $assign_list["clsContinent"] = $clsContinent;
    $classTable = "Blog";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $clsBlogCategory = new BlogCategory();
    $assign_list["clsBlogCategory"] = $clsBlogCategory;
    $blogcat_id = isset($_GET['blogcat_id']) ? intval($_GET['blogcat_id']) : 0;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    if ($pvalTable > 0) {
        $blogcat_id = $oneItem['cat_id'];
    }
    $assign_list["blogcat_id"] = $blogcat_id;
    $assign_list["classTable"] = $classTable;

    #-------------Update Config Meta
    $clsMeta = new Meta();
    $assign_list["clsMeta"] = $clsMeta;
    $linkMeta = $clsClassTable->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    $assign_list["meta_id"] = $meta_id;
    $assign_list["oneMeta"] = $clsMeta->getOne($meta_id);

    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    $clsForm->addInputTextArea("static", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 22, 1, "style='width:100%'");
    #
    /*if ($string != '' && $pvalTable == 0) {
    header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
}*/
    #

    if (intval($pvalTable) > 0 && $clsISO->getCheckActiveModulePackage($package_id, $mod, 'tag', 'customize')) {
        #---Edit Tags of post
        $clsTag = new Tag();
        $assign_list["clsTag"] = $clsTag;
        $listAllTag = $clsTag->getAll("1=1 and title<>'' order by title asc limit 0,5000");
        #
        $listAvailableTag = '<script type="text/javascript">var availableTags = [';
        for ($i = 0; $i < count($listAllTag); $i++) {
            $listAvailableTag .= '{ name: "' . $listAllTag[$i]['title'] . '", val: "' . $listAllTag[$i]['title'] . '" },';
        }
        $listAvailableTag .= '];</script>';
        $assign_list["listAvailableTag"] = $listAvailableTag;
        #
        $clsTagModule = new TagModule();
        $assign_list["clsTagModule"] = $clsTagModule;
        $listTag = $clsTagModule->getAll("1=1 and for_id='$pvalTable' and type = 'BLOG' order by reg_date asc limit 0,20");
        $assign_list["listTag"] = $listTag;
        unset($listAllTag);
        unset($listTag);
    }
    #=========================================#
    if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
        if ($pvalTable > 0) {

            $set = "";
            $firstAdd = 0;
            foreach ($_POST as $key => $val) {
                if ($key == 'iso-content') {
                    $content = Input::post('iso-content');
                    $content = html_entity_decode($content);
                    $content = preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")nodata...image/([a-z]+);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
                    $content = preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")data:image/(gif|png|jpeg);base64,([\w=+/]++)("[^>]*>)#', "data_upload_image_word_textarea", $content);
                } else {
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
            }
            #
            $set .= ",user_id_update='" . addslashes($core->_SESS->user_id) . "'";
            $set .= ",upd_date='" . time() . "'";
            $set .= ",title='" . ucwords($_POST['title']) . "'";
            $set .= ",slug='" . $clsISO->replaceSpace2($_POST['title']) . "'";
            $set .= ",content='" . $content . "'";
            if (isset($_POST['publish_date'])) {
                $_POST['publish_date'] = str_replace('/', '-', $_POST['publish_date']);
                $_POST['publish_date'] = strtotime($_POST['publish_date']);
                $set .= ",publish_date='" . $_POST['publish_date'] . "'";
            }


            //		echo str_replace('$', '', $clsISO->replaceSpace($slug_title)); die();
            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            $imagehome = isset($_POST['imagehome_src']) ? $_POST['imagehome_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
                $imagehome = isset($_POST['isoman_url_imagehome']) ? $_POST['isoman_url_imagehome'] : '';
            }
            if ($image != '' && $image != '0' || $imagehome != '' && $imagehome != '0') {
                $set .= ",image='" . addslashes($image) . "'";
                $set .= ",imagehome='" . addslashes($imagehome) . "'";
            }
            $pUrl = '';
            if ($clsConfiguration->getValue('SiteHasCat_Blogs')) {
                $cat_id = $_POST['iso-cat_id'];
                $list_cat_id = $clsBlogCategory->getListParent($cat_id);
                $set .= ",list_cat_id='" . addslashes($list_cat_id) . "'";
                $pUrl .= '&blogcat_id=' . $cat_id;
            }

            $tagPost = $_POST['list_tag_id'];
            if (!empty($tagPost) && $tagPost != '0') {
                $tags_array = explode(',', $tagPost);
                foreach ($tags_array as $tag) {
                    $lstcheck = $clsTag->getAll("slug='" . $core->replaceSpace($tag) . "' limit 0,1");
                    if (!empty($lstcheck)) {
                        $tags_list[] = $lstcheck[0][$clsTag->pkey];
                    } else {
                        $id = $clsTag->getMaxId();
                        $ft = "tag_id,title,slug";
                        $vt = "'$id','" . $tag . "','" . $clsISO->replaceSpace2($tag) . "'";
                        $clsTag->insertOne($ft, $vt);
                        $tags_list[] = $id;
                    }
                }
                $set .= ",list_tag_id='" . $clsISO->makeSlashListFromArray2($tags_list) . "'";
            } else {
                $set .= ",list_tag_id=''";
            }
            $is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
            $set .= ",is_online='" . $is_online . "'";

            //print_r($pvalTable.'xxx'. $set); die();

            if ($clsClassTable->updateOne($pvalTable, $set)) {
                $titleMeta = $_POST['config_value_title'] ? addslashes($_POST['config_value_title']) : addslashes($_POST['title']);
                $introMeta = strip_tags(html_entity_decode(addslashes($_POST['iso-intro'])));
                $descriptionMeta = $_POST['config_value_intro'] ? addslashes($_POST['config_value_intro']) : substr($introMeta, 0, 160);
                $image_seo = isset($_POST['image_seo_src']) ? $_POST['image_seo_src'] : '';
                if (_isoman_use) {
                    $image_seo = $_POST['isoman_url_image_seo'];
                }
                $image_seo = $image_seo ? $image_seo : $image;
                if ($meta_id == '') {
                    $clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,meta_index,meta_follow", "'" . $linkMeta . "','" . $titleMeta . "','" . $descriptionMeta . "','" . $image_seo . "','" . time() . "','" . time() . "','" . $clsMeta->getMaxId() . "','" . $_POST['meta_index'] . "','" . $_POST['meta_follow'] . "'");
                    $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
                } else {
                    $clsMeta->updateOne($meta_id, "config_value_intro='" . $descriptionMeta . "',config_value_title='" . $titleMeta . "',image='" . $image_seo . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
                }
                if ($_POST['button'] == '_EDIT') {
                    header('location:' . PCMS_URL . '/?mod=' . $mod . '&act=edit&blog_id=' . $core->encryptID($pvalTable) . '&message=updateSuccess');
                } else {
                    header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
                }
            } else {
                header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
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
            $blog_id = $clsClassTable->getMaxId();
            $field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,blog_id,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . ucwords($_POST['title']) . "','" . $clsISO->replaceSpace2($_POST['title']) . "','" . $blog_id . "','1'";

            if (isset($_POST['publish_date'])) {
                $_POST['publish_date'] = str_replace('/', '-', $_POST['publish_date']);
                $_POST['publish_date'] = strtotime($_POST['publish_date']);
                $field .= ",publish_date";
                $value .= ",'" . $_POST['publish_date'] . "'";
            }

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            $imagehome = isset($_POST['imagehome_src']) ? $_POST['imagehome_src'] : '';
            if (_isoman_use) {
                $image = $_POST['isoman_url_image'];
                $imagehome = isset($_POST['isoman_url_imagehome']) ? $_POST['isoman_url_imagehome'] : '';
            }
            if ($image != '' && $image != '0' || $imagehome != '' && $imagehome != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
                $field .= ',imagehome';
                $value .= ",'" . addslashes($imagehome) . "'";
            }
            $pUrl = '';
            if ($clsConfiguration->getValue('SiteHasCat_Blogs')) {
                $cat_id = $_POST['iso-cat_id'];
                $list_cat_id = $clsBlogCategory->getListParent($cat_id);
                $field .= ',list_cat_id';
                $value .= ",'" . addslashes($list_cat_id) . "'";
                $pUrl .= '&blogcat_id=' . $cat_id;
            }
            $tagPost = $_POST['list_tag_id'];
            if (!empty($tagPost) && $tagPost != '0') {
                $tags_array = explode(',', $tagPost);
                foreach ($tags_array as $tag) {
                    $lstcheck = $clsTag->getAll("slug='" . $core->replaceSpace($tag) . "' limit 0,1");
                    if (!empty($lstcheck)) {
                        $tags_list[] = $lstcheck[0][$clsTag->pkey];
                    } else {
                        $id = $clsTag->getMaxId();
                        $ft = "tag_id,title,slug";
                        $vt = "'$id','" . $tag . "','" . $clsISO->replaceSpace2($tag) . "'";
                        $clsTag->insertOne($ft, $vt);
                        $tags_list[] = $id;
                    }
                }
                $field .= ',list_tag_id';
                $value .= ",'" . $clsISO->makeSlashListFromArray2($tags_list) . "'";
            } else {
                $field .= ',list_tag_id';
                $value .= ",''";
            }
            if ($CTV_POST) {
                if ($_user_group_id == 5) {
                    $field .= ',is_approve';
                    $value .= ",'0'";
                }
            } else {
                $field .= ',is_approve';
                $value .= ",'1'";
            }
            $is_online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
            $field .= ',is_online';
            $value .= ",'" . $is_online . "'";

            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location:' . PCMS_URL . "/blog/insert/" . $blog_id . "/overview/generalinformation");
                } else {
                    header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
                }
            } else {
                header('location:' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertFailed');
            }
        }
    }
}

function default_trash()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Blog";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $blogcat_id = isset($_GET['blogcat_id']) ? intval($_GET['blogcat_id']) : 0;

    $pUrl = '';
    if ($blogcat_id > 0) {
        $pUrl .= '&blogcat_id=' . $blogcat_id;
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=TrashSuccess');
    }
}

function default_restore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Blog";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $blogcat_id = isset($_GET['blogcat_id']) ? intval($_GET['blogcat_id']) : 0;

    $pUrl = '';
    if ($blogcat_id > 0) {
        $pUrl .= '&blogcat_id=' . $blogcat_id;
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=RestoreSuccess');
    }
}

function default_delete()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Blog";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $blogcat_id = isset($_GET['blogcat_id']) ? intval($_GET['blogcat_id']) : 0;

    $pUrl = '';
    if ($blogcat_id > 0) {
        $pUrl .= '&blogcat_id=' . $blogcat_id;
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->doDelete($pvalTable)) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=DeleteSuccess');
    }
}

function default_move()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Blog";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $blogcat_id = isset($_GET['blogcat_id']) ? intval($_GET['blogcat_id']) : 0;
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    if (($string != '' && $pvalTable == 0) || $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod);
    }

    $where = '1=1 and is_trash=0 ';
    $pUrl = '';
    if ($blogcat_id > 0) {
        $where .= " and (cat_id='$blogcat_id' or list_cat_id like '%|$blogcat_id|%')";
        $pUrl .= '&blogcat_id=' . $blogcat_id;
    }
    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
        //        var_dump($where . " and order_no < $order_no order by order_no desc limit 0,1");die();
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] + 1) . "'");
        }
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $lstItem = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no asc");
        for ($i = 0; $i < count($lstItem); $i++) {
            $clsClassTable->updateOne($lstItem[$i][$clsClassTable->pkey], "order_no='" . ($lstItem[$i]['order_no'] - 1) . "'");
        }
    }
    header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . $pUrl . '&message=PositionSuccess');
}

function default_setting()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO;

    $clsMeta = new Meta();
    $assign_list['clsMeta'] = $clsMeta;
    $user_id = $core->_USER['user_id'];

    $linkMeta = $clsISO->getLink($mod);

    $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
    $meta_id = $allMeta[0]['meta_id'];
    #

    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
            if ($tmp[0] == 'date') {
                $clsConfiguration->updateValue($tmp[1], strtotime($val));
            }
        }
        if ($_POST['config_value_title'] != '' || $_POST['config_value_intro'] != '') {
            if ($meta_id == '') {
                $clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxID() . "'");
                $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
                $meta_id = $allMeta[0]['meta_id'];
            }
            $clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "',image='" . addslashes($_POST['isoman_url_image_seo']) . "'");
        }
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=UpdateSuccess' . ($extUrl ?? ''));
    }
}

/* ======== SITE BLOG CATEGORY ========== */
function default_category()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO;
    global $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #- Check enable Module

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #- End Check
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "BlogCategory";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    $assign_list["clsBlog"] = new Blog();
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location:' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    $cond = "1=1";
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    $orderBy = " order by order_no asc";
    #
    $allItem = $clsClassTable->getAll($cond . $orderBy);
    $assign_list["allItem"] = $allItem;
    unset($allItem);
    $assign_list["number_all"] = $clsClassTable->getAll($cond2) ? count($clsClassTable->getAll($cond2)) : 0;
    $assign_list["number_trash"] = $clsClassTable->getAll($cond2 . " and is_trash=1") ? count($clsClassTable->getAll($cond2 . " and is_trash=1")) : 0;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['blogcat_id']) ? ($_GET['blogcat_id']) : '';
        $blogcat_id = intval($core->decryptID($string));
        if ($string == '' && $blogcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($blogcat_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['blogcat_id']) ? ($_GET['blogcat_id']) : '';
        $blogcat_id = intval($core->decryptID($string));
        if ($string == '' && $blogcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($blogcat_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['blogcat_id']) ? ($_GET['blogcat_id']) : '';
        $blogcat_id = intval($core->decryptID($string));
        if ($string == '' && $blogcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->doDelete($blogcat_id)) {
            header('location: ' . PCMS_URL . '/index.php?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
            die;
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['blogcat_id']) ? ($_GET['blogcat_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        #
        if ($string == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $parent_id = isset($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];

        $pUrl = '&act=' . $act;
        $where = "is_trash=0";
        if ($parent_id > 0) {
            $where .= '&parent_id=' . $parent_id;
            $pUrl .= '&parent_id=' . $parent_id;
        }
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no DESC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no ASC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=PositionSuccess');
    }
}

function default_ajUpdPosSortBlogCategory()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT,
           $mod, $_LANG_ID, $act, $menu_current, $current_page,
           $core, $clsModule;

    global $clsConfiguration;

    $clsBlogCategory = new BlogCategory();

    /* =========================================
     * GET POST
     * ========================================= */
    $order = isset($_POST['order']) && is_array($_POST['order'])
        ? array_values($_POST['order'])
        : [];

    if (empty($order)) {
        return;
    }

    $currentPage = isset($_POST['currentPage'])
        ? max(1, (int) $_POST['currentPage'])
        : 1;

    $recordPerPage = isset($_POST['recordPerPage'])
        ? max(1, (int) $_POST['recordPerPage'])
        : count($order);

    /* =========================================
     * LỌC ID
     * ========================================= */
    $validOrder = [];

    foreach ($order as $val) {

        $val = (int) $val;

        if ($val > 0) {
            $validOrder[] = $val;
        }
    }

    if (empty($validOrder)) {
        return;
    }

    /* =========================================
     * VỊ TRÍ BẮT ĐẦU CỦA PAGE
     *
     * Page 1:
     * 0
     *
     * Page 2:
     * 20
     *
     * Page 3:
     * 40
     * ========================================= */
    $startOrder =
        (($currentPage - 1) * $recordPerPage) + 1;

    /* =========================================
     * BƯỚC 1
     *
     * TEMP ORDER
     * ========================================= */
    foreach ($validOrder as $key => $blogcatId) {

        $tempOrder = -1000000 - $key;

        $clsBlogCategory->updateOne(
            $blogcatId,
            "order_no='" . $tempOrder . "'"
        );
    }

    /* =========================================
     * BƯỚC 2
     *
     * ASSIGN ORDER
     * ========================================= */
    foreach ($validOrder as $key => $blogcatId) {

        $newOrder = $startOrder + $key;

        $clsBlogCategory->updateOne(
            $blogcatId,
            "order_no='" . $newOrder . "'"
        );
    }
}

/*========== SITE BLOGS CATEGORY =========== */
function default_SiteBlogCategory()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    #
    $clsBlog = new Blog();
    $clsClassTable = new BlogCategory();
    #
    $user_id = $core->_USER['user_id'];
    $blogcat_id = isset($_POST['blogcat_id']) ? intval($_POST['blogcat_id']) : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    #
    if ($tp == 'F') {
        $html = '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . ($blogcat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('blogcategory') . '</h3>
		</div>';
        $html .= '
		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
			<div class="wrap">
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('title') . ' <font color="red">*</font></div>
					<div class="fieldarea">
						<input class="text full required" name="title" value="' . $clsClassTable->getOneField('title', $blogcat_id) . '" type="text" autocomplete="off" />
					</div>
				</div>
				<!-- 
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('intro') . '</div>
					<div class="fieldarea">
						<textarea  id="textarea_blog_intro_editor_' . time() . '" class="textarea_blog_intro_editor" name="intro" style="width:100%">' . $clsClassTable->getOneField('intro', $blogcat_id) . '</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>' . $core->get_Lang('Content banner') . '</strong></div>
					<div class="fieldarea">
						<input class="text full" name="content" value="' . $clsClassTable->getOneField('content', $blogcat_id) . '" type="text" autocomplete="off" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>' . $core->get_Lang('Banner') . ' <span class="small">(WxH=1920x480)</span></strong></div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $clsClassTable->getOneField('image', $blogcat_id) . '" />
						<input type="hidden" id="isoman_hidden_image_banner" value="' . $clsClassTable->getOneField('image', $blogcat_id) . '">
						<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $clsClassTable->getOneField('image', $blogcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $clsClassTable->getOneField('image', $blogcat_id) . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				-->
				<div class="row-span">
					<div class="fieldlabel text_left_767" style="text-align:right"><strong>' . $core->get_Lang('Icon') . ' <span class="small">(WxH=30x30)</span></strong></div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_icon_banner" src="' . $clsClassTable->getOneField('icon', $blogcat_id) . '" />
						<input type="hidden" id="isoman_hidden_icon_banner" value="' . $clsClassTable->getOneField('icon', $blogcat_id) . '">
						<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_icon_banner" name="icon_banner" value="' . $clsClassTable->getOneField('icon', $blogcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="icon_banner" isoman_val="' . $clsClassTable->getOneField('icon', $blogcat_id) . '" isoman_name="icon_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<button type="button" blogcat_id="' . $blogcat_id . '" class="btn btn-primary btnClickToSubmitCategory">
				<i class="icon-ok icon-white"></i><span>' . $core->get_Lang('update') . '</span>
			</button>
			<button type="reset" class="btn btn-warning close_pop"><i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span> </button>		
		</div>';
        echo ($html);
        die();
    } elseif ($tp == 'S') {
        $titlePost = isset($_POST['title']) ? trim(strip_tags($_POST['title'])) : '';
        $slugPost = $clsISO->replaceSpace2($titlePost);
        /*
        $introPost = isset($_POST['intro']) ? addslashes($_POST['intro']) : '';
        $contentPost = isset($_POST['content']) ? addslashes($_POST['content']) : '';
        $image_banner = isset($_POST['image_banner']) ? addslashes($_POST['image_banner']) : '';
        */
        $icon_banner = isset($_POST['icon_banner']) ? addslashes($_POST['icon_banner']) : '';
        #
        if (intval($blogcat_id) == 0) {
            if (!empty($clsClassTable->getAll("slug='$slugPost'"))) {
                echo '_EXIST';
                die();
            } else {
                $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
                for ($i = 0; $i <= count($listTable); $i++) {
                    $order_no = $listTable[$i]['order_no'] + 1;
                    $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
                }

                $fx = "$clsClassTable->pkey,user_id,user_id_update,title,slug,order_no,reg_date,upd_date, icon";
                $vx = "'" . $clsClassTable->getMaxID() . "','$user_id','$user_id','$titlePost','$slugPost'";
                $vx .= ",'1','" . time() . "','" . time() . "', '" . addslashes($icon_banner) . "'";

                //$fx = "$clsClassTable->pkey,user_id,user_id_update,title,slug,intro,content,image,order_no,reg_date,upd_date, icon";
                //$vx = "'" . $clsClassTable->getMaxID() . "','$user_id','$user_id','$titlePost','$slugPost','" . addslashes($introPost) . "','" . addslashes($contentPost) . "','" . addslashes($image_banner) . "'";
                //$vx .= ",'1','" . time() . "','" . time() . "', '" . addslashes($icon_banner) . "'";
                #

                if ($clsClassTable->insertOne($fx, $vx)) {
                    echo '_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        } else {
            if ($clsClassTable->getAll("slug='$slugPost' and blogcat_id <> '$blogcat_id'") != '') {
                echo '_EXIST';
                die();
            } else {
                $set = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',upd_date='" . time() . "',user_id_update='" . $user_id . "', icon= '" . addslashes($icon_banner) . "'";

                //$set = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='" . addslashes($introPost) . "',content='" . addslashes($contentPost) . "',image='" . addslashes($image_banner) . "',upd_date='" . time() . "',user_id_update='" . $user_id . "', icon= '" . addslashes($icon_banner) . "'";

                if ($clsClassTable->updateOne($blogcat_id, $set)) {
                    echo '_SUCCESS';
                    die();
                } else {
                    echo '_ERROR';
                    die();
                }
            }
        }
    }
}

/*========== SITE BLOG TAGS =============*/
function default_ajSiteBlogTags()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsTag = new Tag();
    $clsTagModule = new TagModule();
    $for_id = isset($_POST['for_id']) ? intval($_POST['for_id']) : 0;
    $tag_module_id = isset($_POST['tag_module_id']) ? intval($_POST['tag_module_id']) : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $user_id = $core->_USER['user_id'];
    #
    if ($tp == 'S') {
        $html = '';
        $val = isset($_POST['val']) ? trim(addslashes($_POST['val'])) : '';
        $slugPost = $core->replaceSpace($val);
        $tag_id = $clsTag->getBySlug($slugPost);
        #
        if ($tag_id == '' || $tag_id == 0) {
            $clsTag->insertOne("title,slug", "'" . addslashes($val) . "','$slugPost'");
            $tag_id = $clsTag->getBySlug($slugPost);
        }
        $tag_module_id = $clsTagModule->getId($tag_id, $for_id, $type);
        if ($tag_module_id == '' || $tag_module_id == 0) {
            $fx = "$clsTagModule->pkey,tag_id,for_id,type,user_id,reg_date,val";
            $vx = "'" . $clsTagModule->getMaxID() . "','$tag_id','$for_id','" . $type . "','" . $user_id . "','" . time() . "','1'";
            $clsTagModule->insertOne($fx, $vx);
            #
            $tag_module_id = $clsTagModule->getId($tag_id, $for_id, $type);
            $html .= '<span class="tagz"><a href="javascript:void(0);" class="closeTag" title="' . $core->get_Lang('delete') . '" id="t-' . $tag_module_id . '">x</a>' . $val . '</span></div>';
            echo ($html);
            die();
        } else {
            echo '_EXIST';
            die();
        }
    } elseif ($tp == 'D') {
        $clsTagModule->deleteOne($tag_module_id);
        echo 1;
        die();
    }
}

/*========== SITE DUPLICATE BLOG =============*/
function default_ajDuplicateBlog()
{
    global $core, $mod, $clsISO;
    #
    $user_id = $core->_USER['user_id'];
    $blog_id_duplicate = $_POST['blog_id'];

    $html = '';

    #=== Duplicate Blog Table--------------------------
    $clsBlog = new Blog();
    $oneBlog = $clsBlog->getOne($blog_id_duplicate);
    $blog_id = $clsBlog->getMaxID();
    $max_blog_order = $clsBlog->getMaxOrderNo();
    $fx = "blog_id,order_no";
    $vx = "'$blog_id','$max_blog_order'";
    foreach ($oneBlog as $key => $value) {
        if (intval($key) == 0 && $key != $clsBlog->pkey && $key != 'order_no') {
            $fx .= "," . $key;
            if ($key == 'user_id')
                $vx .= ",'$user_id'";
            elseif ($key == 'is_online')
                $vx .= ",0";
            elseif ($key == 'title')
                $vx .= ",'" . addslashes($value) . "-DUP'";
            elseif ($key == 'slug')
                $vx .= ",'" . addslashes($value) . $core->replaceSpace('-DUP') . "'";
            else
                $vx .= ",'" . addslashes($value) . "'";
        }
    }
    $clsBlog->insertOne($fx, $vx);
    #End Duplicate Blog Table--------------------------
    #Duplicate Blog Tag Table------------------------------
    $clsTagBlog = new TagBlog();
    $lstTagBlog = $clsTagBlog->getAll("blog_id='$blog_id_duplicate'");
    if ($lstTagBlog[0][$clsTagBlog->pkey] != '') {
        for ($i = 0; $i < count($lstTagBlog); $i++) {
            $oneItem = $lstTagBlog[$i];
            $fx = "$clsTagBlog->pkey";
            $vx = "'" . $clsTagBlog->getMaxID() . "'";
            foreach ($oneItem as $key => $value) {
                if (intval($key) == 0 && $key != $clsTagBlog->pkey) {
                    $fx .= "," . $key;
                    if ($key == 'blog_id')
                        $vx .= ",'$blog_id'";
                    else
                        $vx .= ",'" . addslashes($value) . "'";
                }
            }
            $clsTagBlog->insertOne($fx, $vx);
        }
    }
    unset($clsTagBlog);
    #End Duplicate Blog Tag table------------------------------

    $html = PCMS_URL . '/index.php?mod=' . $mod . '&act=edit&' . $clsBlog->pkey . '=' . $core->encryptID($blog_id);
    echo ($html);
    die();
}

function default_ajLoadCountry()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCountry = new Country();
    $chauluc_id = isset($_POST['chauluc_id']) ? intval($_POST['chauluc_id']) : 0;
    $khuvuc_id = isset($_POST['khuvuc_id']) ? intval($_POST['khuvuc_id']) : 0;
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    #
    $cond = "is_trash=0";
    if ($chauluc_id > 0) {
        $cond .= " and continent_id='$chauluc_id'";
    }
    if ($khuvuc_id > 0) {
        $cond .= " and khuvuc_id='$khuvuc_id'";
    }
    #
    if ($clsCountry->getAll($cond) != '') {
        $html = "<option value='0'> -- " . $core->get_Lang('selectcountry') . " -- </option>";
        $rslist = $clsCountry->getAll($cond . " order by order_no asc", $clsCountry->pkey);
        if (is_array($rslist) && count($rslist) > 0) {
            foreach ($rslist as $k => $v) {
                $html .= '<option value="' . $v[$clsCountry->pkey] . '" ' . ($country_id == $v[$clsCountry->pkey] ? 'selected="selected"' : '') . '> -- ' . $clsCountry->getTitle($v[$clsCountry->pkey]) . ' -- </option>';
            }
            unset($rslist);
        }
    } else {
        $html = 'EMPTY';
    }
    echo $html;
    die();
}

function default_ajLoadRegion()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsRegion = new Region();
    #
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    $region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
    #
    $cond = "is_trash=0";
    if ($country_id > 0) {
        $cond .= " and country_id = '$country_id'";
    }
    if ($clsRegion->getAll($cond) != '') {
        $html = $clsRegion->makeSelectboxOption($country_id, $region_id);
    } else {
        $html = 'EMPTY';
    }
    echo $html;
    die();
}

function default_ajmakeSelectCityGlobal()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsCity = new City();
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    $region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
    $city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
    #
    $cond = "is_trash=0";
    if ($country_id > 0) {
        $cond .= " and country_id='$country_id'";
    }
    if ($region_id > 0) {
        $cond .= " and region_id='$region_id'";
    }
    #
    $html = '<option value="0"> -- ' . $core->get_Lang('selectcity') . ' --</option>';
    if ($clsCity->getAll($cond) != '') {
        $lstCity = $clsCity->getAll($cond . " order by slug asc", $clsCity->pkey);
        if (!empty($lstCity)) {
            foreach ($lstCity as $k => $v) {
                $html .= '<option value="' . $v[$clsCity->pkey] . '" ' . ($city_id == $v[$clsCity->pkey] ? 'selected="selected"' : '') . '> -- ' . $clsCity->getTitle($v[$clsCity->pkey]) . ' -- </option>';
            }
            unset($lstCity);
        }
    } else {
        $html = 'EMPTY';
    }
    echo $html;
    die();
}

/*========= START TOUR LIST DESTINATION MOD ===========*/
function default_ajaxLoadBlogDestination()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsBlogDestination = new BlogDestination();
    $clsContinent = new Continent();
    $clsCountry = new Country();
    $clsRegion = new Region();
    $clsCity = new City();
    $clsTour = new Tour();
    $blog_id = $_POST['blog_id'];
    $html = '';
    #
    $lstDestination = $clsBlogDestination->getAll("is_trash=0 and blog_id='$blog_id' order by order_no asc");
    if (is_array($lstDestination) && count($lstDestination) > 0) {
        foreach ($lstDestination as $k => $v) {
            $title = '';
            if (intval($v['chauluc_id']) > 0) {
                $title .= ' &raquo; ' . $clsContinent->getTitle($v['chauluc_id']);
            }
            if (intval($v['country_id']) > 0) {
                $title .= ' &raquo; ' . $clsCountry->getTitle($v['country_id']);
            }
            if (intval($v['region_id']) > 0) {
                $title .= ' &raquo; ' . $clsRegion->getTitle($v['region_id']);
            }
            if (intval($v['city_id']) > 0) {
                $title .= ' &raquo; ' . $clsCity->getTitle($v['city_id']);
            }
            $html .= '<li style="cursor:move" id="order_' . $v[$clsBlogDestination->pkey] . '"><strong><a href="javascript:void(0);" title="' . $core->get_Lang('Drag & drop change position') . '">' . $title . '</a></strong><span class="remove removeDestination" data="' . $v[$clsBlogDestination->pkey] . '">x</span></li>';
        }
        $html .= '
		<li style="cursor:pointer; width:90px; margin-top:10px;border-radius:4px" class="ajRemoveAllDestinationInTour iso-button-primary"><i class="fa fa-times-circle-o"></i> ' . $core->get_Lang('Remove all') . '</li>';
        $html .= '
		<script type="text/javascript">
			$("#lstDestination").sortable({
				opacity: 0.8,
				cursor: \'move\',
				start: function(){
					vietiso_loading(1);
				},
				stop: function(){
					vietiso_loading(0);
				},
				update: function(){
					var order = $(this).sortable("serialize")+\'&update=update\';
					$.post(path_ajax_script+"/index.php?mod=blog&act=ajUpdPosBlogDestination", order, function(html){
						vietiso_loading(0);
					});
				}
			});
		</script>';
        unset($lstDestination);
    }
    echo $html;
    die();
}

function default_ajUpdPosBlogDestination()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    #
    $clsBlogDestination = new BlogDestination();
    $order = $_POST['order'] ?? [];
    $clsISO->sortByData('BlogDestination', $order);
}

function default_ajaxAddMoreBlogDestination()
{
    //				ini_set('display_errors', '1');
    //ini_set('display_startup_errors', '1');
    //error_reporting(E_ALL);
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    #
    $clsBlog = new Blog();
    $clsBlogDestination = new BlogDestination();
    #
    $chauluc_id = isset($_POST['chauluc_id']) ? intval($_POST['chauluc_id']) : 0;
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    $region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;
    $city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;
    $blog_id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;
    #
    $cond = "is_trash=0";
    if ($chauluc_id > 0) {
        $cond .= " and chauluc_id='$chauluc_id'";
    }
    if ($country_id > 0) {
        $cond .= " and country_id='$country_id'";
    }
    if ($region_id > 0) {
        $cond .= " and region_id='$region_id'";
    }
    if ($city_id > 0) {
        $cond .= " and city_id='$city_id'";
    }
    if ($blog_id > 0) {
        $cond .= " and blog_id='$blog_id'";
    }

    if (!empty($clsBlogDestination->getAll($cond))) {
        echo '_EXIST';
        die();
    } else {
        $f = "$clsBlogDestination->pkey,blog_id,country_id,region_id,city_id,order_no,val,chauluc_id";
        $v = "'" . $clsBlogDestination->getMaxID() . "','$blog_id','$country_id','$region_id','$city_id','" . $clsBlogDestination->getMaxOrderNoByTable($blog_id) . "','1','$chauluc_id'";
        if ($clsBlogDestination->insertOne($f, $v)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

function default_ajaxDeleteBlogDestination()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsBlogDestination = new BlogDestination();
    $blog_destination_id = $_POST['blog_destination_id'];
    #
    $clsBlogDestination->deleteOne($blog_destination_id);
    echo (1);
    die();
}

function default_ajaxDeleteAllBlogDestination()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $user_id = $core->_USER['user_id'];
    #
    $clsBlogDestination = new BlogDestination();
    $blog_id = $_POST['blog_id'];
    #
    $clsBlogDestination->deleteByCond("blog_id='$blog_id'");
    echo (1);
    die();
}

/*------ Load Tour Extension -------*/
function default_ajLoadTourExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    #
    $clsBlog = new Blog();
    $clsTour = new Tour();
    $clsBlogExtension = new BlogExtension();
    $clsProperty = new Property();
    #
    $blog_id = $_POST['blog_id'];
    $html = '';
    $lstItem = $clsBlogExtension->getAll("is_trash=0 and blog_id='$blog_id' and table_name='tour' order by order_no desc");
    if (!empty($lstItem)) {
        $i = 0;
        foreach ($lstItem as $item) {
            $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html .= '<td class="index">' . ($i + 1) . '</td>';
            $html .= '<td><strong>' . $clsTour->getTitle($item['tour_id']) . '</strong></td>';
            $html .= '<td><strong>' . $clsTour->getTripDuration($item['tour_id']) . '</strong></td>';
            if ($clsConfiguration->getValue('SiteHasCat_Tours')) {
                $html .= '<td><strong>' . $clsTour->getCatName($item['tour_id']) . '</strong></td>';
            }
            $html .= '<td style="text-align:right; white-space:nowrap">
						<strong class="format_price">
							' . $clsProperty->getOneField('property_code', $clsConfiguration->getValue('Currency')) . ' ' . $clsISO->formatNumberToEasyRead($clsTour->getOneField('min_price', $item['tour_id'])) . '
						</strong>
					</td>';
            $html .= '<td style="vertical-align: middle;text-align:center">
					' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveTourExtension" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveTourExtension(this)"><i class="icon-circle-arrow-up"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveTourExtension" direct="movebottom" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveTourExtension(this)"><i class="icon-circle-arrow-down"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="moveTourExtension" direct="moveup" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveTourExtension(this)"><i class="icon-arrow-up"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="moveTourExtension" direct="movedown" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveTourExtension(this)"><i class="icon-arrow-down"></i></a>') . '
                </td>';
            $html .= '<td style="text-align:center">
						<a title="' . $core->get_Lang('delete') . '" class="btn clickDeleteBlogExtension btn-danger fileinput-button" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" tp="tour" onclick="deleteBlogExtension(this)">
							<i class="icon-remove icon-white"></i>
						</a>
					</td>';
            $html .= '</tr>';
            ++$i;
        }
    }
    echo $html;
    die();
}

function default_ajAddTourExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsBlogExtension = new BlogExtension();
    $blog_id = $_POST['blog_id'];
    $tour_id = $_POST['tour_id'];

    if (!$clsBlogExtension->checkExist($blog_id, $tour_id, 'tour')) {
        $max_id = $clsBlogExtension->getMaxId();
        $f = $clsBlogExtension->pkey . ",blog_id,tour_id,order_no,table_name";
        $res = $clsBlogExtension->getAll("is_trash=0 and blog_id='$blog_id' and table_name='tour' order by order_no desc limit 0,1");
        $order_no = intval($res[0]['order_no']) + 1;
        $v = "'$max_id','$blog_id','$tour_id','" . $order_no . "','tour'";
        if ($clsBlogExtension->insertOne($f, $v, 1)) {
            echo ('_SUCCESS');
            die();
        } else {
            echo ('_ERROR');
            die();
        }
    } else {
        echo ('_EXIST');
        die();
    }
}

function default_ajmoveTourExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsClassTable = new BlogExtension();

    $pvalTable = $_POST['blog_extension_id'];
    $direct = $_POST['direct'];
    $one = $clsClassTable->getOne($pvalTable);
    $blog_id = $one['blog_id'];
    $order_no = $one['order_no'];

    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='tour' and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='tour' and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='tour' and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='tour' and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    echo (1);
    die();
}

/*------ Load Cruise Extension -------*/
function default_ajLoadCruiseExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    #
    $clsBlog = new Blog();
    $clsCruise = new Cruise();
    $clsBlogExtension = new BlogExtension();
    $clsProperty = new Property();
    #
    $blog_id = $_POST['blog_id'];
    $html = '';
    $lstItem = $clsBlogExtension->getAll("is_trash=0 and blog_id='$blog_id' and table_name='cruise' order by order_no desc");
    if (!empty($lstItem)) {
        $i = 0;
        foreach ($lstItem as $item) {
            $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html .= '<td class="index">' . ($i + 1) . '</td>';
            $html .= '<td><strong>' . $clsCruise->getTitle($item['cruise_id']) . '</strong></td>';
            if ($clsConfiguration->getValue('SiteHasCruisesCategory')) {
                $html .= '<td><strong>' . $clsCruise->getCatName($item['cruise_id']) . '</strong></td>';
            }
            $html .= '<td style="vertical-align: middle;text-align:center">
					' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveCruiseExtension" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveCruiseExtension(this)"><i class="icon-circle-arrow-up"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveCruiseExtension" direct="movebottom" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveCruiseExtension(this)"><i class="icon-circle-arrow-down"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="moveCruiseExtension" direct="moveup" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveCruiseExtension(this)"><i class="icon-arrow-up"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="moveCruiseExtension" direct="movedown" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveCruiseExtension(this)"><i class="icon-arrow-down"></i></a>') . '
                </td>';
            $html .= '<td style="text-align:center">
						<a title="' . $core->get_Lang('delete') . '" class="btn clickDeleteBlogExtension btn-danger fileinput-button" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" tp="cruise" onClick="deleteBlogExtension(this)">
							<i class="icon-remove icon-white"></i>
						</a>
					</td>';
            $html .= '</tr>';
            ++$i;
        }
    }
    echo $html;
    die();
}

function default_ajLoadHotelExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO;
    #
    $clsBlog = new Blog();
    $clsHotel = new Hotel();
    $clsBlogExtension = new BlogExtension();
    $clsProperty = new Property();
    #
    $blog_id = $_POST['blog_id'];
    $html = '';
    $lstItem = $clsBlogExtension->getAll("is_trash=0 and blog_id='$blog_id' and table_name='hotel' order by order_no desc");
    if (!empty($lstItem)) {
        $i = 0;
        foreach ($lstItem as $item) {
            $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
            $html .= '<td class="index">' . ($i + 1) . '</td>';
            $html .= '<td><strong>' . $clsHotel->getTitle($item['hotel_id']) . '</strong></td>';
            $html .= '<td style="vertical-align: middle;text-align:center">
					' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('movetop') . '"  direct="movetop" class="moveHotelExtension" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveHotelExtension(this)"><i class="icon-circle-arrow-up"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movebottom') . '" class="moveHotelExtension" direct="movebottom" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveHotelExtension(this)"><i class="icon-circle-arrow-down"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == 0 ? '' : '<a title="' . $core->get_Lang('moveup') . '" class="moveHotelExtension" direct="moveup" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveHotelExtension(this)"><i class="icon-arrow-up"></i></a>') . '
                </td>
                <td style="vertical-align: middle;text-align:center">
                    ' . ($i == count($lstItem) - 1 ? '' : '<a title="' . $core->get_Lang('movedown') . '" class="moveHotelExtension" direct="movedown" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" onClick="moveHotelExtension(this)"><i class="icon-arrow-down"></i></a>') . '
                </td>';
            $html .= '<td style="text-align:center">
						<a title="' . $core->get_Lang('delete') . '" class="btn clickDeleteBlogExtension btn-danger fileinput-button" data="' . $item[$clsBlogExtension->pkey] . '" href="javascript:void();" tp="hotel" onClick="deleteBlogExtension(this)">
							<i class="icon-remove icon-white"></i>
						</a>
					</td>';
            $html .= '</tr>';
            ++$i;
        }
    }
    echo $html;
    die();
}

function default_ajAddCruiseExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsBlogExtension = new BlogExtension();
    $blog_id = $_POST['blog_id'];
    $cruise_id = $_POST['cruise_id'];

    if (!$clsBlogExtension->checkExist($blog_id, $cruise_id, 'cruise')) {
        $max_id = $clsBlogExtension->getMaxId();
        $f = $clsBlogExtension->pkey . ",blog_id,cruise_id,order_no,table_name";
        $res = $clsBlogExtension->getAll("is_trash=0 and blog_id='$blog_id' and table_name='cruise' order by order_no desc limit 0,1");
        $order_no = intval($res[0]['order_no']) + 1;
        $v = "'$max_id','$blog_id','$cruise_id','" . $order_no . "','cruise'";
        if ($clsBlogExtension->insertOne($f, $v)) {
            echo ('_SUCCESS');
            die();
        }
    } else {
        echo ('_EXIST');
        die();
    }
}

function default_ajmoveCruiseExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsClassTable = new BlogExtension();

    $pvalTable = $_POST['blog_extension_id'];
    $direct = $_POST['direct'];
    $one = $clsClassTable->getOne($pvalTable);
    $blog_id = $one['blog_id'];
    $order_no = $one['order_no'];
    $clsClassTable->setDeBug(1);
    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='cruise' and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='cruise' and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='cruise' and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='cruise' and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    echo (1);
    die();
}

function default_ajDeleteBlogExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsClassTable = new BlogExtension();
    $blog_extension_id = $_POST['blog_extension_id'];

    $clsClassTable->deleteOne($blog_extension_id);
    echo (1);
    die();
}

function default_ajAddHotelExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsBlogExtension = new BlogExtension();
    $blog_id = $_POST['blog_id'];
    $hotel_id = $_POST['hotel_id'];

    if (!$clsBlogExtension->checkExist($blog_id, $hotel_id, 'hotel')) {
        $max_id = $clsBlogExtension->getMaxId();
        $f = $clsBlogExtension->pkey . ",blog_id,hotel_id,order_no,table_name";
        $res = $clsBlogExtension->getAll("is_trash=0 and blog_id='$blog_id' and table_name='hotel' order by order_no desc limit 0,1");
        $order_no = intval($res[0]['order_no']) + 1;
        $v = "'$max_id','$blog_id','$hotel_id','" . $order_no . "','hotel'";
        if ($clsBlogExtension->insertOne($f, $v)) {
            echo ('_SUCCESS');
            die();
        }
    } else {
        echo ('_EXIST');
        die();
    }
}

function default_ajmoveHotelExtension()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsClassTable = new BlogExtension();

    $pvalTable = $_POST['blog_extension_id'];
    $direct = $_POST['direct'];
    $one = $clsClassTable->getOne($pvalTable);
    $blog_id = $one['blog_id'];
    $order_no = $one['order_no'];

    if ($direct == 'moveup') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='hotel' and order_no > $order_no order by order_no asc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movedown') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='hotel' and order_no < $order_no order by order_no desc limit 0,1");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
        $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movetop') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='hotel' and order_no > $order_no order by order_no asc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    if ($direct == 'movebottom') {
        $lst = $clsClassTable->getAll("blog_id='$blog_id' and table_name='hotel' and order_no < $order_no order by order_no desc");
        $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
        $clsClassTable->updateOne($lst[count($lst) - 1][$clsClassTable->pkey], "order_no='" . $order_no . "'");
    }
    echo (1);
    die();
}

function default_ajGetSearch()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    #
    $clsTour = new Tour();
    $clsCruise = new Cruise();
    $clsHotel = new Hotel();
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $blog_id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $html = '';
    #
    $where = "is_trash=0 and is_online=1";
    if (trim($keyword) != '' && $keyword != '0') {
        $slug = $core->replaceSpace($keyword);
        $where .= " and (title like '%$keyword%' or slug like '%$slug%')";
    }
    if ($tp == '_PROMOTION') {
    }
    if ($tp == '_TOP') {
    }
    $limit = " limit 0,1000";
    #
    if ($type == 'Tour') {
        $lstItem = $clsTour->getAll($where . " and tour_id NOT IN(select tour_id from default_blog_extension where blog_id='" . $blog_id . "')" . $limit, $clsTour->pkey);
        if (is_array($lstItem) && count($lstItem) > 0) {
            foreach ($lstItem as $k => $v) {
                $html .= '
				<li class="clickChooiseTour" tp="' . $tp . '" data="' . $v[$clsTour->pkey] . '" type="add" onclick="addRelateTour(this)">
					<a href="javascript:void(0);" title="Click chooise this tour">' . $clsTour->getTitle($v[$clsTour->pkey]) . '</a>	
				</li>';
            }
        } else {
            $html .= '_EMPTY';
        }
    }
    if ($type == 'Hotel') {
        $lstItem = $clsHotel->getAll($where . " and hotel_id NOT IN(select hotel_id from default_blog_extension where blog_id='" . $blog_id . "')" . $limit, $clsHotel->pkey);
        if (is_array($lstItem) && count($lstItem) > 0) {
            foreach ($lstItem as $k => $v) {
                $html .= '
				<li class="clickChooiseHotel" tp="' . $tp . '" data="' . $v[$clsHotel->pkey] . '" type="add" onClick="addRelateHotel(this)">
					<a href="javascript:void(0);" title="Click chooise this tour">' . $clsHotel->getTitle($v[$clsHotel->pkey]) . '</a>	
				</li>';
            }
        } else {
            $html .= '_EMPTY';
        }
    }
    if ($type == 'Cruise') {
        $lstItem = $clsCruise->getAll($where . " and cruise_id NOT IN(select cruise_id from default_blog_extension where blog_id='" . $blog_id . "')" . $limit, $clsCruise->pkey);
        if (is_array($lstItem) && count($lstItem) > 0) {
            foreach ($lstItem as $k => $v) {
                $html .= '
				<li class="clickChooiseCruise" tp="' . $tp . '" data="' . $v[$clsCruise->pkey] . '" type="add" onClick="addRelateCruise(this)">
					<a href="javascript:void(0);" title="Click chooise this cruise">' . $clsCruise->getTitle($v[$clsCruise->pkey]) . '</a>	
				</li>';
            }
        } else {
            $html .= '_EMPTY';
        }
    }
    echo $html;
    die();
}

require_once(DIR_MODULES . '/blog/mod_default.php');
