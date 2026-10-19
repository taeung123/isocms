<?php

function default_ajTourPackage(){
    global $clsISO, $core, $assign_list;

    /* start */
    // khai báo chung
    $user_id = $core->_USER['user_id'];
    $data = ["status" => 0, "result" => false, "message" => $core->get_Lang("something went wrong")];
    $now = time();

    // data $_POST
    $tp = $_POST["tp"] ?? "";
    $tour_id = $_POST["tour_id"] ?? 0;
    $tour_package_id = $_POST["tour_package_id"] ?? 0;

    // Khởi báo object
    $clsTourPackage = new TourPackage();
    $clsTourOption = new TourOption();
    $clsPriceCfg = new TourPackagePriceConfig();
    $clsTourProperty = new TourProperty();

    // smarty assign
    $assign_list['clsTourPackage'] = $clsTourPackage;
    $assign_list['clsTourOption'] = $clsTourOption;
    $assign_list['pvalTable'] = $assign_list['tour_id'] = $tour_id;
    /* end */
    #
    if ($tour_id) {
        if ($tp === "F") {
            if ($tour_package_id) {
                $oneTourPackage = $clsTourPackage->getOne($tour_package_id);
                $listPriceCfg = $clsPriceCfg->getAll("tour_package_id=$tour_package_id order by tour_property_id asc");
                $listTourGuide = $clsTourProperty->getAll("type = 'TOURGUIDE'");
                $listGroupPeople = [];

                foreach ($listPriceCfg as $item) {
                    $tour_property_id = $item['tour_property_id'];
                    $group_range = $item['group_range'];
                    $group_pax   = $item['group_pax'];

                    if (!isset($listGroupPeople[$tour_property_id][$group_range])) {
                        $listGroupPeople[$tour_property_id][$group_range] = [];
                    }

                    $listGroupPeople[$tour_property_id][$group_range][] = $group_pax;
                }

                // get string adult_group_size
                $tour_option_ids = array_map(function($row) {
                    return $row['group_pax'];
                }, $listPriceCfg);

                $tour_option_id_str = implode(', ', $tour_option_ids);

                $assign_list['oneTourPackage'] = $oneTourPackage;
                $assign_list['tour_option_id_str'] = $tour_option_id_str;
                $assign_list['listGroupPeople'] = $listGroupPeople;
                $assign_list['listTourGuide'] = $listTourGuide;

                $html = $clsISO->build('ajTourPackageDetail.tpl');
                $data = ['result' => true, 'act' => 'edit', 'message' => '', 'html' => $html];
            } else {
                $tour_package_id = $clsTourPackage->getMaxId();
                $title = $core->get_Lang("New Tour Package ") . $tour_package_id;
                $order_no = $clsTourPackage->getMaxOrderNo();
                $field = "tour_package_id,tour_id,title,slug,reg_date,upd_date,user_id, order_no";
                $value = "$tour_package_id, $tour_id, '$title','{$clsISO->replaceSpace2($title)}', $now, $now, $user_id, $order_no";
                if ($clsTourPackage->insertOne($field, $value)) {
                    $data = ['result' => true, 'act' => 'add', 'message' => $core->get_Lang('insertSuccess')];
                } else {
                    $data = ['result' => false, 'message' => $core->get_Lang('insertFailed')];
                }
            }
        } elseif ($tp === "Del") {
            // Xóa tất cả dữ liệu liên quan đến tour package đó
            if ($tour_package_id && $clsTourPackage->deleteOne($tour_package_id) && $clsPriceCfg->deleteByCond("tour_package_id=$tour_package_id")) {
                $data = ['result' => true, 'act' => 'del', 'message' => $core->get_Lang('delete success')];
            }
        }
    }

    echo json_encode($data);die;
}

function default_loadTourPackage() {
    global $clsISO, $assign_list;
    $clsTourpackage = new TourPackage();
    $tour_id = $_POST["tour_id"] ?? 0;
    if ($tour_id) {
        $listTourpackage = $clsTourpackage->getAll("tour_id = $tour_id");
        $assign_list["clsTourpackage"] = $clsTourpackage;
        $assign_list["listTourpackage"] = $listTourpackage;
        $assign_list["tour_id"] = $tour_id;
        $html = $clsISO->build('listTourPackage.tpl');

        echo json_encode(["html" => $html]);die;
    }
}

function default_ajSaveTourPackage() {

    global $core, $clsISO;

    $user_id = $core->_USER['user_id'];
    $tour_id = $_POST["tour_id"] ?? 0;
    $tour_package_id = $_POST["tour_package_id"] ?? 0;
    $now = time();
    $clsTourPackage = new TourPackage();
    $clsTourPackageGuide = new TourPackageGuide();

    if ($tour_id && $tour_package_id) {
        $title = $_POST["title"] ?? "";
        $overview = $_POST["overview"] ?? "";
        $guide_ids  = $_POST["tour_guide"] ?? [];
        $oneItem = $clsTourPackage->getOne($tour_package_id, $clsTourPackage->pkey);
        if (!empty($oneItem)) {
            $arr_update = [
                "title" => $title,
                "slug" => $clsISO->replaceSpace2($title),
                "overview" => addslashes($overview),
                "upd_date" => $now,
                "user_id" => $user_id
            ];
            #Thêm hướng dan vien du lich
            $clsTourPackageGuide->deleteByCond("tour_package_id=$tour_package_id");

            foreach ($guide_ids as $guide_id) {
                $clsTourPackageGuide->insertOne("tour_package_id, tour_property_id", "$tour_package_id, $guide_id");
            }
            #
            if ($clsTourPackage->update($tour_package_id, $arr_update)) {
                $data = ['result' => true, 'message' => $core->get_Lang('updateSuccess')];
            } else {
                $data = ['result' => false, 'message' => $core->get_Lang('UpdateFailed')];
            }
        } else {
            $data = ['result' => false, 'message' => $core->get_Lang('Tour Package Not Exist')];
        }
    } else {
        $data = ['result' => false, 'message' => $core->get_Lang('Tour Package Not Exist')];
    }
    echo json_encode($data);die;
}

function default_ajTourPackagePriceCfg() {
    global $core, $dbconn, $adult_type_id, $child_type_id, $infant_type_id, $age_type_id, $height_type_id;

    $error = 0;
    $tour_id = $_POST["tour_id"] ?? 0;
    $tour_package_id = $_POST["tour_package_id"] ?? 0;
    $now = time();
    $clsPriceCfg = new TourPackagePriceConfig();
    $clsTourPackage = new TourPackage();
    $clsTourOption = new TourOption();

    $oneTourPackage = $clsTourPackage->getOne($tour_package_id);

    if ($tour_id && $tour_package_id) {
        $listPriceCfg = $clsPriceCfg->getAll("tour_package_id = $tour_package_id");
        $lisSizeGroup =  $clsTourOption->getAll("type='SIZEGROUP'", "$clsTourOption->pkey, tour_property_id");

        # group pax tổng
        $group_all = [];

        // Duyệt qua dữ liệu và nhóm lại
        foreach ($lisSizeGroup as $item) {
            $tour_property_id = $item['tour_property_id'];
            $tour_option_id = $item['tour_option_id'];

            // Nếu tour_property_id chưa có trong mảng $grouped, khởi tạo một mảng trống
            if (!isset($group_all[$tour_property_id])) {
                $group_all[$tour_property_id] = [];
            }

            // Thêm tour_option_id vào mảng của tour_property_id tương ứng
            $group_all[$tour_property_id][] = $tour_option_id;
        }

        # group pax đã có trong db
        $group_existed = [];

        foreach ($listPriceCfg as $item) {
            $tour_property_id = $item['tour_property_id'];
            $group_range = $item['group_range'];
            $group_pax = $item['group_pax'];

            if (!isset($group_existed[$tour_property_id])) {
                $group_existed[$tour_property_id] = [];
            }
            if (!isset($group_existed[$tour_property_id][$group_range])) {
                $group_existed[$tour_property_id][$group_range] = [];
            }

            $group_existed[$tour_property_id][$group_range][] = $group_pax;
        }

        $maxId = $clsPriceCfg->getMaxId();
        $values = [];

        $adult_size_group = $_POST["adult_size_group"] ?? [];
        $type_visitor_child = $_POST["type_visitor_child"] ?? 0;
        $type_visitor_infant = $_POST["type_visitor_infant"] ?? 0;

        if ($type_visitor_child === $height_type_id) {
            $visitor_type_child = $_POST["visitorheight_child"];
        } else {
            $visitor_type_child = $_POST["visitorage_child"];
        }
        if ($type_visitor_infant === $height_type_id) {
            $visitor_type_infant = $_POST["visitorheight_infant"];
        } else {
            $visitor_type_infant = $_POST["visitorage_infant"];
        }

        # update type_visitor cho package
        $arr_update = [
            "type_visitor_child" => $type_visitor_child,
            "type_visitor_infant" => $type_visitor_infant
        ];

        $clsTourPackage->update($tour_package_id, $arr_update);

        if ($oneTourPackage["type_visitor_child"] !== $type_visitor_child) {
            $listTourOption = $clsTourOption->getAll("type='SIZEGROUP' and tour_property_id = {$oneTourPackage["type_visitor_child"]}", "$clsTourOption->pkey");
            $str_ids = implode(',', array_column($listTourOption, 'tour_option_id'));
            $clsPriceCfg->deleteByCond("tour_property_id = $child_type_id and group_range IN ($str_ids)");
        }

        if ($oneTourPackage["type_visitor_infant"] !== $type_visitor_infant) {
            $listTourOption = $clsTourOption->getAll("type='SIZEGROUP' and tour_property_id = {$oneTourPackage["type_visitor_infant"]}", "$clsTourOption->pkey");
            $str_ids = implode(',', array_column($listTourOption, 'tour_option_id'));
            $clsPriceCfg->deleteByCond("tour_property_id = $infant_type_id and group_range IN ($str_ids)");
        }

        # cập nhật dữ liệu cho nhóm người lớn
        $paxAdult = $group_existed[$adult_type_id][0];
        if (empty($paxAdult)) {
            // Nếu không có gì tồn tại, insert hết
            $toInsert = $adult_size_group;
        } else if (empty($adult_size_group)) {
            // Nếu không chọn gì, delete hết những cái đang tồn tại
            $toDelete = $paxAdult;
        } else {
            // Nếu đã có rồi, tính toán insert và delete
            $toInsert = array_diff($adult_size_group, $paxAdult);
            $toDelete = array_diff($paxAdult, $adult_size_group);
        }
        if (!empty($toInsert)) {
            foreach ($toInsert as $option_id) {
                $tp_price_cfg_id = $maxId++; // tự động tăng id
                $values[] = "($tp_price_cfg_id, $tour_package_id, $adult_type_id, 0, $option_id, $now, $now)";
            }
        }

        if (!empty($toDelete)) {
            $ids = implode(',', $toDelete);
            $cond_del = "tour_property_id = $adult_type_id AND group_range = 0 AND group_pax IN ($ids)";
            if (!$clsPriceCfg->deleteByCond($cond_del)) {
                $data = ['result' => false ,'message' => $core->get_Lang('Failed to update group pax for adults!')];
                echo json_encode($data);die;
            }
        }

        # cập nhật dữ liệu cho nhóm tre em
        if (!empty($visitor_type_child)) {
            foreach ($visitor_type_child as $visitor) {
                $child_size_group = $_POST["child_size_group$visitor"] ?? [];
                $toInsert = []; // reset mỗi lượt lặp
                $toDelete = []; //
                $paxChild = $group_existed[$child_type_id][$visitor];
                if (empty($paxChild)) {
                    // Nếu chưa có dữ liệu tồn tại cho group_range này, insert hết selected
                    $toInsert = $child_size_group;
                } elseif (empty($child_size_group)) {
                    // Nếu selected rỗng, thì xóa hết những gì đã có
                    $toDelete = $paxChild;
                } else {
                    // Ngược lại, so sánh chọn/bỏ
                    $toInsert = array_diff($child_size_group, $paxChild);
                    $toDelete = array_diff($paxChild, $child_size_group);
                }

                if (!empty($toInsert)) {
                    foreach ($toInsert as $option_id) {
                        $tp_price_cfg_id = $maxId++;
                        $values[] = "($tp_price_cfg_id, $tour_package_id, $child_type_id, $visitor, $option_id, $now, $now)";
                    }
                }

                if (!empty($toDelete)) {
                    $ids = implode(',', $toDelete);
                    $cond_del = "tour_property_id = $child_type_id AND group_range = $visitor AND group_pax IN ($ids)";
                    if (!$clsPriceCfg->deleteByCond($cond_del)) {
                        $data = ['result' => false ,'message' => $core->get_Lang('Failed to update group pax for children!')];
                        echo json_encode($data);die;
                    }
                }
            }
        }

        # cập nhật dữ liệu cho nhóm sơ sinh
        if (!empty($visitor_type_infant)) {
            foreach ($visitor_type_infant as $visitor) {
                $infant_size_group = $_POST["infant_size_group$visitor"] ?? [];
                $toInsert = []; // reset mỗi lượt lặp
                $toDelete = []; //
                $paxInfant = $group_existed[$infant_type_id][$visitor];
                if (empty($paxInfant)) {
                    // Nếu chưa có dữ liệu tồn tại cho group_range này, insert hết selected
                    $toInsert = $infant_size_group;
                } elseif (empty($infant_size_group)) {
                    // Nếu selected rỗng, thì xóa hết những gì đã có
                    $toDelete = $paxInfant;
                } else {
                    // Ngược lại, so sánh chọn/bỏ
                    $toInsert = array_diff($infant_size_group, $paxInfant);
                    $toDelete = array_diff($paxInfant, $infant_size_group);
                }

                if (!empty($toInsert)) {
                    foreach ($toInsert as $option_id) {
                        $tp_price_cfg_id = $maxId++;
                        $values[] = "($tp_price_cfg_id, $tour_package_id, $infant_type_id, $visitor, $option_id, $now, $now)";
                    }
                }

                if (!empty($toDelete)) {
                    $ids = implode(',', $toDelete);
                    $cond_del = "tour_property_id = $infant_type_id AND group_range = $visitor AND group_pax IN ($ids)";
                    if (!$clsPriceCfg->deleteByCond($cond_del)) {
                        $data = ['result' => false ,'message' => $core->get_Lang('Failed to update group pax for infant!')];
                        echo json_encode($data);die;
                    }
                }
            }
        }

        $field = "tp_price_cfg_id, tour_package_id, tour_property_id, group_range, group_pax, reg_date, upd_date";

        if (!empty($values)) {
            $valuesSql = implode(",\n", $values);
            $sql = "INSERT INTO $clsPriceCfg->tbl ($field) VALUES \n{$valuesSql}";

            if (!$dbconn->Execute($sql)) {
                $error = 1;
            }
        }
    }
    if ($error) {
        $data = ['result' => false, 'message' => $core->get_Lang('Fail')];
    } else {
        $data = ['result' => true, 'message' => $core->get_Lang('Success')];
    }
    echo json_encode($data);die;
}

function default_ajOptionPriceTourPackage()
{
    global $core, $age_type_id, $height_type_id, $child_type_id, $infant_type_id;
    #
    $clsTourOption = new TourOption();
    $clsPriceCfg = new TourPackagePriceConfig();
    $tour_id = $_POST['tour_id'] ?? 0;
    $tour_package_id = $_POST["tour_package_id"] ?? 0;
    $type_visitor = Input::post('type_visitor', $age_type_id);
    $type = $_POST["type"] ?? '';
    $listPriceCfg = $clsPriceCfg->getAll("tour_package_id=$tour_package_id");

    // lấy mảng nhóm tuổi/chiều cao
    $group_existed = [];

    foreach ($listPriceCfg as $item) {
        $group_range = $item['group_range'];
        $group_pax = $item['group_pax'];

        if (!isset($group_existed[$group_range])) {
            $group_existed[$group_range] = [];
        }

        $group_existed[$group_range][] = $group_pax;
    }
    
    $html = "";
    if ($tour_id > 0 && $type_visitor > 0 && $type != '') {
        $cond = "is_trash=0 and type='SIZEGROUP' and tour_property_id='" . $type_visitor . "'";
        $order_by = " order by order_no asc";
        if ($type == 'children') {
            if ($type_visitor == $age_type_id) {
                $cond .= " and tour_property_age='" . $child_type_id . "'";
            }
            if ($type_visitor == $height_type_id) {
                $cond .= " and tour_property_height='" . $child_type_id . "'";
            }
        } elseif ($type == 'infant') {
            if ($type_visitor == $age_type_id) {
                $cond .= " and tour_property_age='" . $infant_type_id . "'";
            }
            if ($type_visitor == $height_type_id) {
                $cond .= " and tour_property_height='" . $infant_type_id . "'";
            }
        }

        $listVitorTypeChildren = $clsTourOption->getAll($cond . $order_by, $clsTourOption->pkey . ',title');

        foreach ($listVitorTypeChildren as $value) {
            $html .= '<div class="d-flex justify-content-between mb10">
						<label for="" class="lbl_select">' . $value["title"] . '</label>';

            if ($type == 'children') {
                $tour_option_id_str = implode(",", $group_existed[$value["tour_option_id"]]);
                if ($type_visitor == $age_type_id) {
                    $html .= '<input type="hidden" name="visitorage_child[]" class="visitorage" value="' . $value["tour_option_id"] . '">';
                }
                if ($type_visitor == $height_type_id) {
                    $html .= '<input type="hidden" name="visitorheight_child[]" class="visitorheight" value="' . $value["tour_option_id"] . '">';
                }
                $html .= '<div class="box_select">
							<select name="child_size_group' . $value['tour_option_id'] . '[]" id="child_size_group" class="chosen-select" multiple="multiple">';

                $html .= $clsTourOption->makeSelectboxOption2($tour_option_id_str, 'SIZEGROUP', $child_type_id);
            } else if ($type == 'infant') {
                $tour_option_id_str = implode(",", $group_existed[$value["tour_option_id"]]);

                if ($type_visitor == $age_type_id) {
                    $html .= '<input type="hidden" name="visitorage_infant[]" class="visitorage" value="' . $value["tour_option_id"] . '">';
                }
                if ($type_visitor == $height_type_id) {
                    $html .= '<input type="hidden" name="visitorheight_infant[]" class="visitorheight" value="' . $value["tour_option_id"] . '">';
                }
                $html .= '<div class="box_select">
							<select name="infant_size_group' . $value['tour_option_id'] . '[]" id="infant_size_group" class="chosen-select" multiple="multiple">';

                $html .= $clsTourOption->makeSelectboxOption2($tour_option_id_str, 'SIZEGROUP', $infant_type_id);
            }
            $html .= '</select>
						</div>
					</div>';
        }
    }

    echo ($html);
    die();
}

function default_ajLoadTPPriceTable(){
    global $clsISO, $core, $assign_list;

    $tour_id = $_POST["tour_id"] ?? 0;
    $tour_package_id = $_POST["tour_package_id"] ?? 0;
    $tp = $_POST["tp"] ?? "";

    $clsPriceCfg = new TourPackagePriceConfig();$assign_list['clsPriceCfg'] = $clsPriceCfg;
    $clsTourProperty = new TourProperty();$assign_list['clsTourProperty'] = $clsTourProperty;
    $clsTourOption = new TourOption();$assign_list['clsTourOption'] = $clsTourOption;

    $data = ["result" => false, "message" => $core->get_Lang("something went wrong")];
    if ($tour_id && $tour_package_id) {
        if ($tp == "L") {
            $listPriceCfg = $clsPriceCfg->getAll("tour_package_id=$tour_package_id order by tour_property_id asc");

            $listGroupPeople = [];

            foreach ($listPriceCfg as $item) {
                $tour_property_id = $item['tour_property_id'];
                $group_range = $item['group_range'];
                $group_pax = $item['group_pax'];

                if (!isset($listGroupPeople[$tour_property_id][$group_range])) {
                    $listGroupPeople[$tour_property_id][$group_range] = [];
                }

                // Lưu trữ giá trị cho từng group_pax kèm theo id
                $listGroupPeople[$tour_property_id][$group_range][$group_pax] = [
                    'price' => $item["price"],
                    'tp_price_cfg_id' => $item["tp_price_cfg_id"],  // Thêm ID vào
                ];
            }

            $assign_list['listGroupPeople'] = $listGroupPeople;

            $html = $clsISO->build('ajTourPackagePriceTable.tpl');
            $data = ['result' => true, 'message' => '', 'html' => $html];
        } else if ($tp == "S") {
            foreach ($_POST['price'] as $id => $price) {
                if (!$clsPriceCfg->updateOne($id, "price = $price")) {
                    json_encode(['result' => false, 'message' => $core->get_Lang('Fail')]);die;
                }
            }
            $data = ['result' => true, 'message' => $core->get_Lang('Success')];
        }
    }
    echo json_encode($data);die;
}

function default_ajAddTourPackage()
{
    global $clsISO, $core, $_LANG_ID;
    #
    $user_id = $core->_USER['user_id'];
    $parent_id = $_POST['tour_id'];
    $html = '';
    #Duplicate Tour table--------------------------
    $clsTour = new Tour();
    $oneTour = $clsTour->getOne($parent_id);
    $clsISO->UpdateOrderNo('Tour');
    $tour_id = $clsTour->getMaxID();
    $title = $oneTour['title'] . "-Package-$tour_id";
    $slug = $core->replaceSpace($title);
    $image = $oneTour['image'];
    $trip_code = $oneTour['trip_code'] . "-$tour_id";
    $tour_option = 80;
    if ($_LANG_ID == "vn") {
        $tour_option = 130;
    }
    $fx = "tour_id,parent_id,order_no,user_id,user_id_update,image,trip_code,tour_option";
    $vx = "'$tour_id','$parent_id','1','$user_id','$user_id','$image','$trip_code',$tour_option";

    $clsTour->insertOne($fx, $vx);

    $html = PCMS_URL . '/tour/edit/' . $tour_id . '/basic/title-tripcode';
    echo ($html);
    die();
}
function default_ajUpdSortTourPackage() {
    $clsTour = new Tour();
    $order = $_POST['order'];
    foreach ($order as $key => $val) {
        $key = $key + 1;
        $clsTour->updateOne($val, "order_no='" . $key . "'");
    }
}
function default_syncOneTourPackageAPI()
{
    global $core, $clsConfiguration, $assign_list, $_LANG_ID, $clsISO, $oneUser;
    $clsVietISOSDK = new VietISOSDK();
    $clsTourItinerary = new TourItinerary();
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    /*if($oneUser['user_id']!=103){
		echo 'updating...';die;
	}*/
    #
    $str_yield_id = $_POST['yield_id'] ?? "";
    $yield_id = intval($core->decryptID($str_yield_id));
    $str_tour_id = $_POST['tour_id'] ?? "";
    $tour_id = intval($core->decryptID($str_tour_id));
    $tms_code = $clsClassTable->getOneField('tms_code', $tour_id);

    $tms_domain = $clsConfiguration->getValue('tms_domain');
    $tms_token = $clsConfiguration->getValue('tms_token');
    $clsVietISOSDK = new VietISOSDK(array("api_url" => rtrim($tms_domain, "/") . "/api", "api_key" => $tms_token));
    $response = $clsVietISOSDK->get("/one_yield_isocms", json_encode(array("yield_id" => $yield_id, "tms_code" => $tms_code)));
    //echo $response; die;

    //$clsISO->pre($response,true);die;
    $lst_sync = array(); // đồng bộ tour_id về tms (yield_id=>tour_id) => lưu vào list_webservice_id [isocms_$tour_id]
    if ($response['meta']['ok']) {
        $oneYield = $response['data']['yield'];
        if (!empty($oneYield)) {
            $slug = $oneYield['slug'] ? $oneYield['slug'] : $core->replaceSpace($oneYield['title']);
            $yield_id = $oneYield['yield_id'];
            $tms_code = $oneYield['pcode'];
            $yieldItinerary = $oneYield['yieldItinerary'];
            if ($clsClassTable->checkExitsTMSCode($tms_code)) {
                $oneTour = $clsClassTable->getByCond("tms_code='$tms_code'", "tour_id,image");
                $tour_id = $oneTour['tour_id'];
                $value = "
					title  			= '" . addslashes($oneYield['title']) . "',
					slug  			= '" . addslashes($slug) . "',
					trip_code  		= '" . addslashes($oneYield['pcode']) . "',
					tms_code  		= '" . addslashes($tms_code) . "',
					yield_id	= {$yield_id},
					duration_type	= '0',
					tour_option_id	= '" . $oneYield['tour_option_id'] . "',
					number_day		= '" . $oneYield['number_day'] . "',
					number_night	= '" . $oneYield['number_night'] . "',
					is_online  		= '" . ($oneYield['status_id'] == 1 ? 0 : 1) . "',  
					overview		= '" . addslashes($oneYield['intro']) . "',
					inclusion		= '" . addslashes($oneYield['includes']) . "',
					exclusion		= '" . addslashes($oneYield['excludes']) . "',
					thing_to_carry	= '" . addslashes($oneYield['thing_to_carry']) . "',
					upd_date  		= '" . time() . "',
					cancellation_policy		= '" . addslashes($oneYield['cancellation_policy']) . "',
					refund_policy			= '" . addslashes($oneYield['refund_policy']) . "',
					confirmation_policy		= '" . addslashes($oneYield['confirmation_policy']) . "'
				";
                if ($oneYield['image']) {
                    $imgpath = DOMAIN_NAME . $oneTour['image'];
                    if (is_file($imgpath))
                        @unlink($imgpath);
                    $image = $clsVietISOSDK->downloadImageFromUrl($oneYield['image']);
                    $value .= ",image='" . addslashes($image) . "'";
                }
                if ($clsClassTable->updateOne($tour_id, $value)) {
                    if (!empty($yieldItinerary)) {
                        foreach ($yieldItinerary as $a => $b) {
                            $day = $b['day'];
                            $oneItinerary = $clsTourItinerary->getByCond("day='$day' and tour_id='$tour_id'", "tour_itinerary_id,image");
                            if (!empty($oneItinerary)) {
                                $tour_itinerary_id = $oneItinerary['tour_itinerary_id'];
                                $valueItinerary = "
									title		= '" . addslashes($b['title']) . "',
									slug		= '" . addslashes($core->replaceSpace($b['title'])) . "',
									content		= '" . addslashes($b['intro']) . "',
									meals		= '" . addslashes($b['list_meal_id']) . "',
									upd_date  	= '" . time() . "'
								";
                                if ($b['image']) {
                                    $imgpath = DOMAIN_NAME . $oneItinerary['image'];
                                    if (is_file($imgpath))
                                        @unlink($imgpath);
                                    $image = $clsVietISOSDK->downloadImageFromUrl($b['image']);
                                    $valueItinerary .= ",image='" . addslashes($image) . "'";
                                }
                                $clsTourItinerary->updateOne($tour_itinerary_id, $valueItinerary);
                            } else {
                                $tour_itinerary_id = $clsTourItinerary->getMaxId();
                                $f_Itinerary = "tour_itinerary_id";
                                $v_Itinerary = "'" . $tour_itinerary_id . "'";
                                $f_Itinerary .= ",tour_id";
                                $v_Itinerary .= ",'" . $tour_id . "'";
                                $f_Itinerary .= ",day";
                                $v_Itinerary .= ",'" . $day . "'";
                                $f_Itinerary .= ",title";
                                $v_Itinerary .= ",'" . addslashes($b['title']) . "'";
                                $f_Itinerary .= ",slug";
                                $v_Itinerary .= ",'" . addslashes($core->replaceSpace($b['title'])) . "'";
                                $f_Itinerary .= ",content";
                                $v_Itinerary .= ",'" . addslashes($b['intro']) . "'";
                                $f_Itinerary .= ",meals";
                                $v_Itinerary .= ",'" . addslashes($b['list_meal_id']) . "'";
                                $f_Itinerary .= ",reg_date";
                                $v_Itinerary .= ",'" . time() . "'";
                                $f_Itinerary .= ",upd_date";
                                $v_Itinerary .= ",'" . time() . "'";
                                if ($b['image']) {
                                    $image = $clsVietISOSDK->downloadImageFromUrl($b['image']);
                                    $f_Itinerary .= ",image";
                                    $v_Itinerary .= ",'" . addslashes($image) . "'";
                                }
                                $clsTourItinerary->insertOne($f_Itinerary, $v_Itinerary);
                            }
                        }
                    }
                }
            } else {
                $tour_id = $clsClassTable->getMaxId();
                $f_Tour = "tour_id";
                $v_Tour = "'" . $tour_id . "'";
                $f_Tour .= ",yield_id";
                $v_Tour .= ",'" . $yield_id . "'";
                $f_Tour .= ",title";
                $v_Tour .= ",'" . addslashes($oneYield['title']) . "'";
                $f_Tour .= ",slug";
                $v_Tour .= ",'" . addslashes($slug) . "'";
                $f_Tour .= ",trip_code";
                $v_Tour .= ",'" . addslashes($oneYield['pcode']) . "'";
                $f_Tour .= ",tms_code";
                $v_Tour .= ",'" . addslashes($oneYield['pcode']) . "'";
                $f_Tour .= ",duration_type";
                $v_Tour .= ",'0'";
                $f_Tour .= ",tour_option_id";
                $v_Tour .= ",'" . $oneYield['tour_option_id'] . "'";
                $f_Tour .= ",number_day";
                $v_Tour .= ",'" . $oneYield['number_day'] . "'";
                $f_Tour .= ",number_night";
                $v_Tour .= ",'" . $oneYield['number_night'] . "'";
                $f_Tour .= ",is_online";
                $v_Tour .= ",'" . ($oneYield['status_id'] == 1 ? 0 : 1) . "'";
                $f_Tour .= ",overview";
                $v_Tour .= ",'" . addslashes($oneYield['intro']) . "'";
                $f_Tour .= ",inclusion";
                $v_Tour .= ",'" . addslashes($oneYield['includes']) . "'";
                $f_Tour .= ",exclusion";
                $v_Tour .= ",'" . addslashes($oneYield['excludes']) . "'";
                $f_Tour .= ",thing_to_carry";
                $v_Tour .= ",'" . addslashes($oneYield['thing_to_carry']) . "'";
                $f_Tour .= ",cancellation_policy";
                $v_Tour .= ",'" . addslashes($oneYield['cancellation_policy']) . "'";
                $f_Tour .= ",refund_policy";
                $v_Tour .= ",'" . addslashes($oneYield['refund_policy']) . "'";
                $f_Tour .= ",confirmation_policy";
                $v_Tour .= ",'" . addslashes($oneYield['confirmation_policy']) . "'";
                $f_Tour .= ",upd_date";
                $v_Tour .= ",'" . time() . "'";
                if ($oneYield['image']) {
                    $image = $clsVietISOSDK->downloadImageFromUrl($oneYield['image']);
                    $f_Tour .= ",image";
                    $v_Tour .= ",'" . addslashes($image) . "'";
                }
                if ($clsClassTable->insertOne($f_Tour, $v_Tour)) {
                    if (!empty($yieldItinerary)) {
                        foreach ($yieldItinerary as $a => $b) {
                            $day = $b['day'];
                            $oneItinerary = $clsTourItinerary->getByCond("day='$day' and tour_id='$tour_id'", "tour_itinerary_id");
                            if (!empty($oneItinerary)) {
                                $tour_itinerary_id = $oneItinerary['tour_itinerary_id'];
                                $valueItinerary = "
									title		= '" . addslashes($b['title']) . "',
									slug		= '" . addslashes($core->replaceSpace($b['title'])) . "',
									content		= '" . addslashes($b['intro']) . "',
									meals		= '" . addslashes($b['list_meal_id']) . "',
									upd_date  	= '" . time() . "'
								";
                                if ($b['image']) {
                                    $imgpath = DOMAIN_NAME . $oneItinerary['image'];
                                    if (is_file($imgpath))
                                        @unlink($imgpath);
                                    $image = $clsVietISOSDK->downloadImageFromUrl($b['image']);
                                    $valueItinerary .= ",image='" . addslashes($image) . "'";
                                }
                                $clsTourItinerary->updateOne($tour_itinerary_id, $valueItinerary);
                            } else {
                                $tour_itinerary_id = $clsTourItinerary->getMaxId();
                                $f_Itinerary = "tour_itinerary_id";
                                $v_Itinerary = "'" . $tour_itinerary_id . "'";
                                $f_Itinerary .= ",tour_id";
                                $v_Itinerary .= ",'" . $tour_id . "'";
                                $f_Itinerary .= ",day";
                                $v_Itinerary .= ",'" . $day . "'";
                                $f_Itinerary .= ",title";
                                $v_Itinerary .= ",'" . addslashes($b['title']) . "'";
                                $f_Itinerary .= ",slug";
                                $v_Itinerary .= ",'" . addslashes($core->replaceSpace($b['title'])) . "'";
                                $f_Itinerary .= ",content";
                                $v_Itinerary .= ",'" . addslashes($b['intro']) . "'";
                                $f_Itinerary .= ",meals";
                                $v_Itinerary .= ",'" . addslashes($b['list_meal_id']) . "'";
                                $f_Itinerary .= ",reg_date";
                                $v_Itinerary .= ",'" . time() . "'";
                                $f_Itinerary .= ",upd_date";
                                $v_Itinerary .= ",'" . time() . "'";
                                if ($b['image']) {
                                    $image = $clsVietISOSDK->downloadImageFromUrl($b['image']);
                                    $f_Itinerary .= ",image";
                                    $v_Itinerary .= ",'" . addslashes($image) . "'";
                                }
                                $clsTourItinerary->insertOne($f_Itinerary, $v_Itinerary);
                            }
                        }
                    }
                }
            }
        }
        echo json_encode(array(
            "result" => "success", //error,success
            "msg" => "success", //error,success
            "response" => $response
        ));
        die;
    } else {
        echo json_encode(array(
            "result" => "error", //error,success
            "msg" => "error", //error,success
        ));
        die;
    }
}