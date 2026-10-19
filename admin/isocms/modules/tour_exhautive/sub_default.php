<?php
// Extension mod Tours
require_once(DIR_MODULES . '/tour_exhautive/mod_default.php');
require_once(DIR_MODULES . '/tour_exhautive/sub_departure_date.php');
require_once(DIR_MODULES . '/tour_exhautive/mod_main_step.php');
require_once(DIR_MODULES . '/tour_exhautive/sub_tour_package.php');
function default_ajOpenSyncTourAPI()
{
    global $core, $clsConfiguration, $assign_list, $clsISO, $_LANG_ID, $oneUser;
    $html = $core->build('ajOpenSyncTourAPI.tpl');
    echo $html;
    die();
}

function default_ajOpenSyncTourtoTMS()
{
    global $core, $clsConfiguration, $assign_list, $clsISO, $_LANG_ID, $oneUser;
    $html = $core->build('ajOpenSyncTourtoTMS.tpl');
    echo $html;
    die();
}

function default_ajload_tourToTMS()
{
    global $core, $clsISO, $profile_id, $oneProfile, $_frontIsLoggedin_user_id, $dbconn;
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $dbconn->setFetchMode(ADODB_FETCH_ASSOC);
    $lst_tour = $clsClassTable->getAll("parent_id = 0 and is_trash=0 and (yield_id=0 or yield_id is null) and (tms_code='' or tms_code is null)", "tour_id,title,slug,trip_code,duration_type,number_day,number_night,is_online,overview,inclusion,exclusion,thing_to_carry,cancellation_policy,refund_policy,confirmation_policy,tour_option_id,tms_code");
    $html = '<table border="0" class="table table-bordered table-iloocal m-0" cellpadding="0" cellspacing="0" width="100%">
				<thead><tr>
					<th class="text-center">
						<div class="pretty p-default p-curve p-fill">
							<input type="checkbox" class="ckb_all_tour_to_tms"/>
							<div class="state p-primary">
								<label>' . $core->get_Lang('All') . '</label>
							</div>
						</div>
					</th>
					<th width="150px" class="text-left">' . $core->get_Lang('Tour Code') . '</th>
					<th class="text-left">' . $core->get_Lang('Title') . '</th>
					<th class="text-center" width="120px">' . $core->get_Lang('Duration') . '</th>
				</tr></thead><tbody>';
    if (!empty($lst_tour)) {
        foreach ($lst_tour as $k => $oneTour) {
            $html .= '
			<tr class="trTourToTMS">
				<td class="text-center">
					<div class="pretty p-default p-curve p-fill">
						<input type="checkbox" class="ckb_tour_to_tms" value="' . $oneTour['tour_id'] . '"/>
						<div class="state p-primary">
							<label style="text-indent:12px;">' . $clsISO->makeIMO('sync', '', $oneTour['tms_code'] ? 'color-green font-14' : 'color-999 font-14', 'title="' . ($oneTour['tms_code'] ? 'Đã đồng bộ' : 'Chưa đồng bộ') . '"') . '</label>
						</div>
					</div>
				</td>
				<td class="text-left iso_search_item">' . $oneTour['trip_code'] . '</td>
				<td class="text-left iso_search_item" slug="' . $clsISO->replaceSpace($oneTour['title']) . '">' . $oneTour['title'] . '</td>
				<td class="text-center" width="120px">' . $oneTour['number_day'] . ' ' . $core->get_Lang('day') . '</td>
			</tr>';
        }
    }
    $html .= '</tbody></table>';
    echo $html;
    die;
}

function default_ajload_tourTMS()
{
    global $core, $clsConfiguration, $assign_list, $clsISO, $_LANG_ID, $oneUser;
    $clsVietISOSDK = new VietISOSDK();
    $clsTourItinerary = new TourItinerary();
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $tms_domain = $clsConfiguration->getValue('tms_domain');
    $tms_token = $clsConfiguration->getValue('tms_token');
    $clsVietISOSDK = new VietISOSDK(array("api_url" => rtrim($tms_domain, "/") . "/api", "api_key" => $tms_token)); //,"debug"=>1
    $response = $clsVietISOSDK->get("/get_yield_isocms", json_encode(array("has_itinerary" => 0)));
    $html = '<table border="0" class="table table-bordered m-0" cellpadding="0" cellspacing="0" width="100%">
				<thead><tr>
					<th class="text-center">
						<div class="pretty p-default p-curve p-fill">
							<input type="checkbox" class="ckb_all_tour_tms"/>
							<div class="state p-primary">
								<label>' . $core->get_Lang('All') . '</label>
							</div>
						</div>
					</th>
					<th width="150px" class="text-left">' . $core->get_Lang('Tour Code') . '</th>
					<th class="text-left">' . $core->get_Lang('Title') . '</th>
					<th class="text-center" width="120px">' . $core->get_Lang('Duration') . '</th>
				</tr></thead><tbody>';
    if ($response['meta']['ok']) {
        $lstYield = $response['data']['yield'];
        if (!empty($lstYield)) {
            foreach ($lstYield as $k => $oneTour) {
                $is_sync = $clsClassTable->getByCond("tms_code='{$oneTour['pcode']}'", "tour_id");
                $html .= '
				<tr class="trTourTMS">
					<td class="text-center">
						<div class="pretty p-default p-curve p-fill">
							<input type="checkbox" class="ckb_tour_tms" value="' . $oneTour['yield_id'] . '"/>
							<div class="state p-primary">
								<label style="text-indent:12px;">' . $clsISO->makeIMO('sync', '', !empty($is_sync) ? 'color-green font-14' : 'color-999 font-14', 'title="' . (!empty($is_sync) ? 'Đã đồng bộ' : 'Chưa đồng bộ') . '"') . '</label>
							</div>
						</div>
					</td>
					<td class="text-left iso_search_item">' . $oneTour['pcode'] . '</td>
					<td class="text-left iso_search_item" slug="' . $clsISO->replaceSpace($oneTour['title']) . '">' . $oneTour['title'] . '</td>
					<td class="text-center" width="120px">' . $oneTour['number_day'] . ' ' . $core->get_Lang('day') . '</td>
				</tr>';
            }
        }
    }
    $html .= '</tbody></table>';
    echo $html;
    die;
}

function default_syncTourAPI()
{
    global $core, $clsConfiguration, $assign_list, $clsISO, $_LANG_ID, $oneUser;
    $clsVietISOSDK = new VietISOSDK();
    $clsTourItinerary = new TourItinerary();
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    //ini_set('display_errors',1);
    //$clsISO->pre($oneUser);die();
    /*if($oneUser['user_id']!=103){
		echo 'updating...';die;
	}*/
    /*$lang_id = $clsISO->getLangTMS($_LANG_ID);
	$response = $clsVietISOSDK->doInApp('GET','/api/get_yield?lang_id='.$lang_id);
	$response = json_decode($response, true);*/
    $lst_tour_id = Input::post('lst_tour_id');
    $tms_domain = $clsConfiguration->getValue('tms_domain');
    $tms_token = $clsConfiguration->getValue('tms_token');
    $clsVietISOSDK = new VietISOSDK(array("api_url" => rtrim($tms_domain, "/") . "/api", "api_key" => $tms_token)); //,"debug"=>1
    $response = $clsVietISOSDK->get("/get_yield_isocms", json_encode(array("has_itinerary" => 1, "lst_tour_id" => $lst_tour_id)));
    //echo $response; die;

    //$clsISO->pre($response);die;
    $lst_sync = array(); // đồng bộ tour_id về tms (yield_id=>tour_id) => lưu vào list_webservice_id [isocms_$tour_id]
    if ($response['meta']['ok']) {
        $lstYield = $response['data']['yield'];
        if (!empty($lstYield)) {
            foreach ($lstYield as $k => $v) {
                $slug = $v['slug'] ? $v['slug'] : $core->replaceSpace($v['title']);
                $yield_id = $v['yield_id'];
                $tms_code = $v['pcode'];
                $yieldItinerary = $v['yieldItinerary'];
                if ($clsClassTable->checkExitsTMSCode($tms_code)) {
                    $oneTour = $clsClassTable->getByCond("tms_code='$tms_code'", "tour_id,image");
                    if (!empty($oneTour)) {
                        $tour_id = $oneTour['tour_id'];
                        $value = "
							title  			= '" . addslashes($v['title']) . "',
							slug  			= '" . addslashes($slug) . "',
							trip_code  		= '" . addslashes($v['pcode']) . "',
							tms_code  		= '" . addslashes($tms_code) . "',
							yield_id	= {$yield_id},
							duration_type	= '0',
							tour_option_id	= '" . $v['tour_option_id'] . "',
							number_day		= '" . $v['number_day'] . "',
							number_night	= '" . $v['number_night'] . "',
							is_online  		= '" . ($v['status_id'] == 1 ? 0 : 1) . "',  
							overview		= '" . addslashes($v['intro']) . "',
							inclusion		= '" . addslashes($v['includes']) . "',
							exclusion		= '" . addslashes($v['excludes']) . "',
							thing_to_carry	= '" . addslashes($v['thing_to_carry']) . "',
							upd_date  		= '" . time() . "',
							cancellation_policy		= '" . addslashes($v['cancellation_policy']) . "',
							refund_policy			= '" . addslashes($v['refund_policy']) . "',
							confirmation_policy		= '" . addslashes($v['confirmation_policy']) . "'
						";
                        //confirmation_policy: chính sách bán hàng
                        //refund_policy: chính sách bồi hoàn
                        //cancellation_policy: Chính sách hoàn huỷ
                        //thing_to_carry : Mang theo
                        //overview: Điểm nổi bật
                        /*info_price				= '".addslashes($v['info_price'])."',
							info_promot				= '".addslashes($v['info_promot'])."',
							deposit					= '".$v['deposit']."'*/
                        if ($v['image']) {
                            $imgpath = DOMAIN_NAME . $oneTour['image'];
                            if (is_file($imgpath))
                                @unlink($imgpath);
                            $image = $clsVietISOSDK->downloadImageFromUrl($v['image']);
                            $value .= ",image='" . addslashes($image) . "'";
                        }
                        if ($clsClassTable->updateOne($tour_id, $value)) {
                            $lst_sync[$yield_id] = $tour_id;
                            //update link promot
                            //$link = DOMAIN_NAME.$clsClassTable->getLink($tour_id);
                            //$response = $clsVietISOSDK->doInApp('POST','/api/yield/update_link_promot',json_encode(array("link"=>$link,"yield_id"=>$yield_id)));

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
                    }
                } else {
                    $tour_id = $clsClassTable->getMaxId();
                    $f_Tour = "tour_id";
                    $v_Tour = "'" . $tour_id . "'";
                    $f_Tour .= ",yield_id";
                    $v_Tour .= ",'" . $yield_id . "'";
                    $f_Tour .= ",title";
                    $v_Tour .= ",'" . addslashes($v['title']) . "'";
                    $f_Tour .= ",slug";
                    $v_Tour .= ",'" . addslashes($slug) . "'";
                    $f_Tour .= ",trip_code";
                    $v_Tour .= ",'" . addslashes($v['pcode']) . "'";
                    $f_Tour .= ",tms_code";
                    $v_Tour .= ",'" . addslashes($v['pcode']) . "'";
                    $f_Tour .= ",duration_type";
                    $v_Tour .= ",'0'";
                    $f_Tour .= ",tour_option_id";
                    $v_Tour .= ",'" . $v['tour_option_id'] . "'";
                    $f_Tour .= ",number_day";
                    $v_Tour .= ",'" . $v['number_day'] . "'";
                    $f_Tour .= ",number_night";
                    $v_Tour .= ",'" . $v['number_night'] . "'";
                    $f_Tour .= ",is_online";
                    $v_Tour .= ",'" . ($v['status_id'] == 1 ? 0 : 1) . "'";
                    $f_Tour .= ",overview";
                    $v_Tour .= ",'" . addslashes($v['intro']) . "'";
                    $f_Tour .= ",inclusion";
                    $v_Tour .= ",'" . addslashes($v['includes']) . "'";
                    $f_Tour .= ",exclusion";
                    $v_Tour .= ",'" . addslashes($v['excludes']) . "'";
                    $f_Tour .= ",thing_to_carry";
                    $v_Tour .= ",'" . addslashes($v['thing_to_carry']) . "'";
                    $f_Tour .= ",cancellation_policy";
                    $v_Tour .= ",'" . addslashes($v['cancellation_policy']) . "'";
                    $f_Tour .= ",refund_policy";
                    $v_Tour .= ",'" . addslashes($v['refund_policy']) . "'";
                    $f_Tour .= ",confirmation_policy";
                    $v_Tour .= ",'" . addslashes($v['confirmation_policy']) . "'";
                    $f_Tour .= ",upd_date";
                    $v_Tour .= ",'" . time() . "'";
                    /*$f_Tour .= ",info_promot"; 			$v_Tour .= ",'".addslashes($v['info_promot'])."'";
					$f_Tour .= ",deposit"; 				$v_Tour .= ",'".$v['deposit']."'";
					$f_Tour .= ",info_price"; 			$v_Tour .= ",'".addslashes($v['info_price'])."'";*/
                    if ($v['image']) {
                        $image = $clsVietISOSDK->downloadImageFromUrl($v['image']);
                        $f_Tour .= ",image";
                        $v_Tour .= ",'" . addslashes($image) . "'";
                    }
                    if ($clsClassTable->insertOne($f_Tour, $v_Tour)) {
                        $lst_sync[$yield_id] = $tour_id;
                        //$link = DOMAIN_NAME.$clsClassTable->getLink($tour_id);
                        //$response = $clsVietISOSDK->doInApp('POST','/api/yield/update_link_promot',json_encode(array("link"=>$link,"yield_id"=>$yield_id)));
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
                /*if(!empty($v['info_price']) && !empty($tour_id)){
					if(file_exists(DIR_INCLUDES.'/json_master/autoload.php')){
						require_once(DIR_INCLUDES.'/json_master/autoload.php');
					}
					$file_cache_name = 'info_price'.$tour_id.'.json';
					$encoder = new Webmozart\Json\JsonEncoder();
					$encoder->encodeFile($v['info_price'], DIR_JSON_TOUR.DS.$file_cache_name);
				}*/
                //break;
            }
        }
        //header('location: '.PCMS_URL.'/?mod=tour_exhautive&message=SynchronousSuccess');
        $response = $clsVietISOSDK->post("/upd_yield_isocms_tour_id", json_encode(array("lst_sync" => $lst_sync)));
        echo json_encode(array(
            "result" => "success", //error,success
            "msg" => "success", //error,success
            "response" => $response
        ));
        die;
    } else {
        //header('location: '.PCMS_URL.'/?mod=tour_exhautive&message=SynchronousFailed');
        echo json_encode(array(
            "result" => "error", //error,success
            "msg" => "error", //error,success
        ));
        die;
    }
}

function default_syncOneTourAPI()
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
    $str_yield_id = isset($_GET['yield_id']) ? $_GET['yield_id'] : "";
    $yield_id = intval($core->decryptID($str_yield_id));
    $str_tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : "";
    $tour_id = intval($core->decryptID($str_tour_id));
    $tms_code = $clsClassTable->getOneField('tms_code', $tour_id);
    //$clsISO->pre(array("yield_id"=>$yield_id,"tms_code"=>$tms_code));die();
    /*$lang_id = $clsISO->getLangTMS($_LANG_ID);
	$response = $clsVietISOSDK->doInApp('GET','/api/get_yield/'.$yield_id.'?lang_id='.$lang_id);
	$response = json_decode($response, true);*/
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
                /*info_price				= '".addslashes($oneYield['info_price'])."',
					info_promot				= '".addslashes($oneYield['info_promot'])."',
					deposit				= '".addslashes($oneYield['deposit'])."'*/
                if ($oneYield['image']) {
                    $imgpath = DOMAIN_NAME . $oneTour['image'];
                    if (is_file($imgpath))
                        @unlink($imgpath);
                    $image = $clsVietISOSDK->downloadImageFromUrl($oneYield['image']);
                    $value .= ",image='" . addslashes($image) . "'";
                }
                if ($clsClassTable->updateOne($tour_id, $value)) {
                    $lst_sync[$yield_id] = $tour_id;
                    //$link = DOMAIN_NAME.$clsClassTable->getLink($tour_id);
                    //$response = $clsVietISOSDK->doInApp('POST','/api/yield/update_link_promot',json_encode(array("link"=>$link,"yield_id"=>$yield_id)));
                    //echo $response; die;
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
                /*$f_Tour .= ",info_price"; 			$v_Tour .= ",'".addslashes($oneYield['info_price'])."'";
				$f_Tour .= ",info_promot"; 			$v_Tour .= ",'".addslashes($oneYield['info_promot'])."'";
				$f_Tour .= ",deposit"; 				$v_Tour .= ",'".$oneYield['deposit']."'";*/
                if ($oneYield['image']) {
                    $image = $clsVietISOSDK->downloadImageFromUrl($oneYield['image']);
                    $f_Tour .= ",image";
                    $v_Tour .= ",'" . addslashes($image) . "'";
                }
                if ($clsClassTable->insertOne($f_Tour, $v_Tour)) {
                    $lst_sync[$yield_id] = $tour_id;
                    //$link = DOMAIN_NAME.$clsClassTable->getLink($tour_id);
                    //$response = $clsVietISOSDK->doInApp('POST','/api/yield/update_link_promot',json_encode(array("link"=>$link,"yield_id"=>$yield_id)));
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
            /*if(!empty($oneYield['info_price'])){
				if(file_exists(DIR_INCLUDES.'/json_master/autoload.php')){
					require_once(DIR_INCLUDES.'/json_master/autoload.php');
				}
				$file_cache_name = 'info_price'.$tour_id.'.json';
				$encoder = new Webmozart\Json\JsonEncoder();
				$encoder->encodeFile($oneYield['info_price'], DIR_JSON_TOUR.DS.$file_cache_name);
			}*/
            $response = $clsVietISOSDK->post("/upd_yield_isocms_tour_id", json_encode(array("lst_sync" => $lst_sync)));
        }
        header('location: ' . PCMS_URL . '/?mod=tour_exhautive&message=SynchronousSuccess');
    } else {
        header('location: ' . PCMS_URL . '/?mod=tour_exhautive&message=SynchronousFailed');
    }
}

//function default_syncTourAPItoTMS(){
function default_syncTourToTMS()
{
    global $core, $clsConfiguration, $assign_list, $clsISO, $dbconn, $_LANG_ID, $oneUser;
    $clsVietISOSDK = new VietISOSDK();
    $clsTourItinerary = new TourItinerary();
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    /* if($oneUser['user_id']!=103){
		echo 'updating...';die;
	} */
    $lst_tour_id = Input::post('lst_tour_id');
    $dbconn->setFetchMode(ADODB_FETCH_ASSOC);
    $cond = "is_trash=0 and (yield_id=0 or yield_id is null) and (tms_code='' or tms_code is null)";
    if (!empty($lst_tour_id)) {
        $cond .= " and tour_id IN(" . implode(",", $lst_tour_id) . ")";
    }
    $lstTour = $clsClassTable->getAll($cond, "tour_id,title,slug,trip_code,duration_type,number_day,number_night,is_online,overview,inclusion,exclusion,thing_to_carry,cancellation_policy,refund_policy,confirmation_policy,tour_option_id");

    //$clsISO->pre($lstTour);die();
    if (!empty($lstTour)) {
        foreach ($lstTour as $k => $oneTour) {
            $tour_id = $oneTour["tour_id"];
            $lstItinerary = $clsTourItinerary->getAll("tour_id=$tour_id order by day asc", "day,title,content,image");
            if (!empty($lstItinerary)) {
                foreach ($lstItinerary as $a => $oneItinerary) {
                    if (!empty($oneItinerary['image']))
                        $lstItinerary[$a]['image'] = DOMAIN_URL . $oneItinerary['image'];
                }
            }
            $lstTour[$k]['lstItinerary'] = $lstItinerary;

            # đồng bộ tour package
            if ($clsClassTable->getOneField("has_package", $tour_id)) {
                $listPackage = $clsClassTable->getAll("parent_id=$tour_id", "$clsClassTable->pkey,title, inclusion, exclusion");
                if (!empty($listPackage)) {
                    $lstTour[$k]['lstPackage'] = $listPackage;
                }
            }
        }
    }

    /*$response = $clsVietISOSDK->doInApp('POST','/api/isocms_sync_yield',json_encode($lstTour)); 
	$response = json_decode($response,true);*/
    $tms_domain = $clsConfiguration->getValue('tms_domain');
    $tms_token = $clsConfiguration->getValue('tms_token');
    $clsVietISOSDK = new VietISOSDK(array("api_url" => rtrim($tms_domain, "/") . "/api", "api_key" => $tms_token)); //,"debug"=>1
    //    echo '<pre>';print_r($lstTour);echo '</pre>';die;
    $response = $clsVietISOSDK->post("/sync_yield_isocms", json_encode(array("lstTour" => $lstTour)));
    if ($response['meta']['ok']) {
        $lstRes = $response['data']['lstRes'];
        if (!empty($lstRes)) {
            foreach ($lstRes as $tour_id => $one) {
                $clsClassTable->updateOne($tour_id, "yield_id = '" . $one['yield_id'] . "',tms_code = '" . $one['pcode'] . "'");
            }
            //header('location: '.PCMS_URL.'/?mod=tour_exhautive&message=SynchronousSuccess');
            echo json_encode(array(
                "result" => "success", //error,success
                "msg" => "success", //error,success
            ));
            die;
        } else {
            //header('location: '.PCMS_URL.'/?mod=tour_exhautive&message=SynchronousFailed');
            echo json_encode(array(
                "result" => "success", //error,success
                "msg" => "success", //error,success
            ));
            die;
        }
    } else {
        //header('location: '.PCMS_URL.'/?mod=tour_exhautive&message=SynchronousFailed');
        echo json_encode(array(
            "result" => "success", //error,success
            "msg" => "success", //error,success
        ));
        die;
    }
    //$clsISO->pre($response);die;
    //echo $response; die;
}

function default_ajLoadYieldRate()
{
    global $core, $clsISO, $dbconn;
    $tour_id = Input::post('tour_id', 0);
    $currency_id = Input::post('currency_id', 0);
    $rate_exchange = $clsISO->formatRateRead($currency_id);
    echo json_encode(array(
        "msg" => "ok",
        "rate_exchange" => $rate_exchange
    ));
    die;
}

function default_ajFilterYieldEstimate()
{
    global $core, $clsISO, $dbconn;
    $clsTour = new Tour();
    $clsVietISOSDK = new VietISOSDK();
    $tour_id = Input::post('tour_id', 0);
    $yield_op_id = Input::post('yield_op_id', 0);
    $currency_id = Input::post('currency_id', 0);
    $exchange_rate = Input::post('exchange_rate', 0);

    $info_price = $clsVietISOSDK->getInfoPrice($tour_id);
    $tour_option_id = $clsTour->getOneField('tour_option_id', $tour_id);
    $is_sic = $tour_option_id == 1 ? 1 : 0;
    //$clsISO->pre($info_price);die;
    $yieldOp = $info_price['yieldOp'];
    $yieldPax = $info_price['yieldPax'];
    $info_percent_child = $info_price['info_percent_child'];
    $currency = $clsISO->getRateSign($currency_id);
    //ini_set('display_errors',1);
    if ($is_sic) {
        $yieldNett = $info_price['yieldNett'];
    } else {
        $yieldEstimate = $info_price['yieldEstimate'];
        $sumary = '<tr>
		<td align="right" class="grayTD"><strong>' . $clsISO->getLang('NumberOfPax') . '</strong></td>';
        if (!empty($yieldPax)) {
            foreach ($yieldPax as $k_pax => $onePax) {
                $sumary .= '<td class="text-right grayTD">' . $clsISO->parseNumber($onePax['from_number']) . '(' . $clsISO->getLang('pax') . ')</td>';
            }
        }
        $sumary .= '</tr><tr>';
        $default_currency = $clsISO->getDefaultCurrency();
        $sumary .= '<tr><td align="right"><strong>' . $clsISO->getLang('TotalSold') . '(' . $clsISO->getRateCode($currency_id) . ')</strong></td>';
        if (!empty($yieldPax)) {
            foreach ($yieldPax as $k_pax => $onePax) {
                $oneEstimate = $clsVietISOSDK->getOneEstimate(array("yield_op_id" => $yield_op_id, "yield_pax_id" => $onePax['yield_pax_id'], "currency_id" => $currency_id, "yieldEstimate" => $yieldEstimate));
                //$clsISO->pre($oneEstimate);
                $sumary .= '<td class="text-right bg-warning bold">' . $clsISO->formatPriceRead($clsISO->convertRateUpgrade($oneEstimate['currency_id'], $currency_id, $oneEstimate['op_price_markup']), $currency_id) . '</td>';
                $yieldPax[$k_pax]['currency_id'] = $oneEstimate['currency_id'];
                $yieldPax[$k_pax]['op_price_markup'] = $oneEstimate['op_price_markup'];
            }
        }
        $sumary .= '</tr>';
        if ($currency_id != $default_currency) {
            $sumary .= '<tr><td align="right"><strong>' . $clsISO->getLang('TotalSold') . '(' . $clsISO->getRateCode($default_currency) . ')</strong></td>';
            if (!empty($yieldPax)) {
                foreach ($yieldPax as $k_pax => $onePax) {
                    $sumary .= '<td class="text-right bg-warning bold">' . $clsISO->formatPriceRead($clsISO->convertRateUpgrade($onePax['currency_id'], $default_currency, $onePax['op_price_markup']), $default_currency) . '</td>';
                }
            }
            $sumary .= '</tr>';
        }
    }
    $html = '<table border="0" class="table table-fixed mb-5" width="100%" cellspacing="2" cellpadding="2">' . $sumary . '</table>';
    echo json_encode(array(
        "msg" => "ok",
        "html" => $html
    ));
    die;
}

function default_refreshYieldEstimate()
{
    global $core, $clsISO, $dbconn;
    $clsTour = new Tour();
    $clsVietISOSDK = new VietISOSDK();
    $tour_id = Input::post('tour_id', 0);
    $clsVietISOSDK->getInfoPrice($tour_id, '', 1);
    echo json_encode(array(
        "msg" => "ok",
    ));
    die;
}

function default_default()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $extLang, $clsISO, $package_id, $dbconn;
    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    $hasAPI = $clsConfiguration->getValue('SiteTourAPI');
    $assign_list["hasAPI"] = $hasAPI;
    #
    if (isset($_GET['is_set']) && $_GET['is_set'] == 'free') {
        if (!$clsConfiguration->getValue('SiteHasFreeEasy_Tours')) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
            exit();
        }
    }
    if (!empty($_POST["export_tour"]) && $_POST["export_tour"] == "export_tour") {
        header('location:' . PCMS_URL . '/?mod=export&type=export_tour');
        exit();
    }

    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #
    $lstCountry = $clsCountry->getAll("is_trash=0 and is_online=1 and country_id IN (SELECT country_id FROM " . DB_PREFIX . "tour_destination) order by order_no asc", $clsCountry->pkey);
    $assign_list["lstCountry"] = $lstCountry;

    $SiteHasCategoryGroup_Tours = $clsConfiguration->getValue('SiteHasCategoryGroup_Tours');
    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');
    $tour_group_id = 0;
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    }
    $assign_list["tour_group_id"] = $tour_group_id;
    #
    $cat_id = 0;
    $SiteHasCat_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'category ', 'default');

    if ($SiteHasCat_Tours) {
        $clsTourCat = new TourCategory();
        $assign_list["clsTourCat"] = $clsTourCat;
        $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    }
    $assign_list["cat_id"] = $cat_id;
    #
    $price_range_id = 0;
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'price_range', 'default')) {
        $clsPriceRange = new PriceRange();
        $assign_list["clsPriceRange"] = $clsPriceRange;
        $price_range_id = isset($_GET['price_range_id']) ? intval($_GET['price_range_id']) : 0;
    }
    $assign_list["price_range_id"] = $price_range_id;
    #
    $country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
    $assign_list["country_id"] = $country_id;
    $tour_type_id = isset($_GET['tour_type_id']) ? intval($_GET['tour_type_id']) : 0;
    $assign_list["tour_type_id"] = $tour_type_id;
    $check = isset($_GET['check']) ? intval($_GET['check']) : 0;
    $assign_list["check"] = $check;
    $departure_point_id = isset($_GET['departure_point_id']) ? intval($_GET['departure_point_id']) : 0;
    $assign_list["departure_point_id"] = $departure_point_id;
    $number_day = isset($_GET['number_day']) ? intval($_GET['number_day']) : 0;
    $assign_list["number_day"] = $number_day;
    /**/
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours) {
            if (isset($_POST['tour_group_id']) && intval($_POST['tour_group_id']) != 0) {
                $link .= '&tour_group_id=' . intval($_POST['tour_group_id']);
            }
        }

        if (isset($_POST['country_id']) && intval($_POST['country_id']) != 0) {
            $link .= '&country_id=' . intval($_POST['country_id']);
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) != 0) {
            $link .= '&cat_id=' . $_POST['cat_id'];
        }
        if (isset($_POST['tour_type_id']) && intval($_POST['tour_type_id']) != 0) {
            $link .= '&tour_type_id=' . $_POST['tour_type_id'];
        }
        if (isset($_POST['departure_point_id']) && intval($_POST['departure_point_id']) != 0) {
            $link .= '&departure_point_id=' . $_POST['departure_point_id'];
        }
        if (isset($_POST['number_day']) && intval($_POST['number_day']) != 0) {
            $link .= '&number_day=' . $_POST['number_day'];
        }
        if (isset($_POST['price_range_id']) && intval($_POST['price_range_id']) != 0) {
            $link .= '&price_range_id=' . $_POST['price_range_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $pUrl = '';
    $cond = "1=1";
    //$cond .= " and tour_id NOT IN (SELECT tour_id FROM " . DB_PREFIX . "tour_store WHERE is_trash=0 and (_type='GROUP' or _type='DEPARTURE'))";
    /*if ($is_day_trip > 0) {
        $cond .= " and is_day_trip=" . $is_day_trip;
        $pUrl .= '&is_day_trip=' . $is_day_trip;
    }else{
		$cond .= " and is_day_trip=0";
	}*/
    if ($tour_group_id > 0) {
        $cond .= " and tour_group_id=" . $tour_group_id;
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    if (intval($tour_type_id) > 0) {
        $cond .= " and tour_type_id=" . $tour_type_id;
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (intval($country_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE country_id='$country_id')";
        $pUrl .= '&country_id=' . $country_id;
    }
     if (intval($country_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour_faq WHERE country_id='$country_id')";
        $pUrl .= '&country_id=' . $country_id;
    }
    if (intval($cat_id) > 0) {
        $cond .= " and (cat_id = '$cat_id' or list_cat_id like '%|$cat_id|%')";
        $pUrl .= '&cat_id=' . $cat_id;
    }
    if (intval($departure_point_id) > 0) {
        $cond .= " and departure_point_id = '" . $departure_point_id . "'";
        $pUrl .= '&departure_point_id=' . $departure_point_id;
    }


    if (isset($number_day) && intval($number_day) != 0) {
        $cond .= " and number_day = '" . $number_day . "'";
        $pUrl .= '&number_day=' . $number_day;
    }

    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and ( trip_code like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' or title like '%" . $_GET['keyword'] . "%')";

        $assign_list["keyword"] = $_GET['keyword'];
    }
    if (isset($_GET['tour_id']) && $_GET['tour_id'] != '') {
        $cond .= " and tour_id ='" . $_GET['tour_id'] . "' ";
        $assign_list["tour_id"] = $_GET['tour_id'];
    }
    if ($user_group_id == 2) {
        $cond .= " and user_id='$user_id'";
    }
    if ($clsClassTable->checkColumnInTable('parent_id')) {
        $cond .= " and parent_id=0";
    }
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }

    if ($type_list == 'Approved') {
        $cond .= " and is_approve=1";
    }
    if ($type_list == 'Unapproved') {
        $cond .= " and is_approve=0";
    }
    
    //echo $cond; //die('xx');

    $orderBy = " upd_date DESC,";
    $orderBy .= " order_no DESC";
    #-------Page Divide---------------------------------------------------------------

    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : ADMIN_PAGINATION;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->getAll($cond, $clsClassTable->pkey);
    $totalRecord = $totalRecord ? count($totalRecord) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    $field = $clsClassTable->pkey . ",is_trash,is_online,user_id,user_id_update,reg_date,upd_date,is_for_agent";
    //if($hasAPI)	$field .= ",yield_id";
    if ($clsISO->checkConnTMS()) $field .= ",yield_id,tms_code";
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $field);
    // print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    #
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_trash"] = count($allTrash) ?? 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2, $clsClassTable->pkey);
    $assign_list["number_item"] = count($allUnTrash) ?? 0;
    #
    $allAll = $clsClassTable->getAll($cond2, $clsClassTable->pkey);
    $assign_list["number_all"] = count($allAll) ?? 0;
    $assign_list['pUrl'] = $pUrl;

    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateToursIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
        }
    }
}

function default_list_promotion()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $extLang, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "HotPromotion";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;

    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #
    $pUrl = '';
    $cond = "1=1";

    $cond2 = $cond;

    $orderBy = " '$pkeyTable' asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = ADMIN_PAGINATION;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";

    $totalRecord = $clsClassTable->countItem($cond);
    $totalPage = ceil($totalRecord / $recordPerPage);

    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    #
    $allTop = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and is_top=1");
    $assign_list['num_top'] = (is_array($allTop) && count($allTop) > 0) ? count($allTop) : 0;
    #
    $allTop = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and is_promotion=1");
    $assign_list['num_promtion'] = (is_array($allTop) && count($allTop) > 0) ? count($allTop) : 0;
    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and tour_type_id = '$tour_type_id' and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id' and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll("is_trash=0 and tour_type_id = '$tour_type_id'");
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;
    $assign_list['pUrl'] = $pUrl;
    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateToursIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=UpdateSuccess');
        }
    }
}

function default_ajUpdPosSortTour()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    #
    $clsTour = new Tour();
    $order = $_POST['order'];

    $clsISO->sortByData('Tour', $order);
}

function default_tourhotel()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsHotel = new Hotel();
    $assign_list["clsHotel"] = $clsHotel;
    #
    $string = isset($_GET['tour_id']) ? ($_GET['tour_id']) : '';
    $tour_id = intval($core->decryptID($string));
    $assign_list["tour_id"] = $tour_id;
    if ($string != '' && $tour_id == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = "&act={$act}&tour_id=" . $core->encryptID($tour_id);
        if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    $classTable = "TourHotel";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    /* List all item */
    $cond = "1='1'";
    $cond .= " and is_trash=0 and tour_id='$tour_id'";
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and hotel_id IN (SELECT hotel_id FROM " . DB_PREFIX . "hotel WHERE slug like '%" . $keyword . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $orderBy = " order by reg_date desc";
    $res = $clsClassTable->getAll($cond . $orderBy, "hotel_id");
    if (!empty($res)) {
        $tmp = array();
        for ($i = 0; $i < count($res); $i++) {
            if ($res[$i]['hotel_id'] != '' && $res[$i]['hotel_id'] != '0' && !in_array($res[$i]['hotel_id'], $tmp))
                $tmp[] = $res[$i]['hotel_id'];
        }
        $assign_list["allItem"] = $tmp;
    }
    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Delete') {
        $hotel_id = isset($_GET['hotel_id']) ? ($_GET['hotel_id']) : '';
        $string = isset($_GET['tour_id']) ? ($_GET['tour_id']) : '';
        $tour_id = intval($core->decryptID($string));
        if ($tour_id == '' && $tour_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteByCond("tour_id='$tour_id' and hotel_id = '$hotel_id'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&tour_id=' . $core->encryptID($tour_id) . '&message=DeleteSuccess');
        }
    }
}

function default_ajActionNewTour()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core,
        $clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $tp = Input::post('tp');
    $is_day_trip = Input::post('is_day_trip', 0);

    $tour_id = $clsTour->getMaxId();
    $title_tour_new = $core->get_Lang('New Tour') . ' ' . $tour_id;
    $results = array('result' => 'error');
    if ($tp = 'S') {
        $field = "tour_id,title,user_id,user_id_update,is_online,order_no,number_day,reg_date,upd_date";
        $value = "'" . $tour_id . "','" . $title_tour_new . "','" . $user_id . "','" . $user_id . "',0,{$clsTour->getMaxOrderNo()},1,'" . time() . "','" . time() . "'";
        $clsTour->insertOne($field, $value);

        $results = array('result' => 'success', 'link' => 'tour/edit/' . $tour_id);
    }
    // Return
    echo @json_encode($results);
    die();
}

function default_edit()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $core, $pvalTable,
        $clsModule, $clsButtonNav, $dbconn, $clsISO, $clsConfiguration, $adult_type_id, $child_type_id, $infant_type_id, $age_type_id, $show, $package_id, $smarty;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $clsTourFaq = new TourFaq();
    $assign_list["clsTourFaq"] = $clsTourFaq;
    $clsTag = new Tag();
    $assign_list["clsTag"] = $clsTag;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTourItinerary = new TourItinerary();
    $assign_list["clsTourItinerary"] = $clsTourItinerary;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsPromoValue = new PromoValue();
    $assign_list["clsPromoValue"] = $clsPromoValue;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsActivities = new Activities();
    $assign_list["clsActivities"] = $clsActivities;
    $clsTourPriceGroup = new TourPriceGroup();
    $assign_list["clsTourPriceGroup"] = $clsTourPriceGroup;
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsTourDestination = new TourDestination();
    $assign_list["clsTourDestination"] = $clsTourDestination;
    $clsTourImage = new TourImage();
    $assign_list["clsTourImage"] = $clsTourImage;
    $clsTourExtension = new TourExtension();
    $assign_list["clsTourExtension"] = $clsTourExtension;
    $clsTourGroup = new TourGroup();
    $assign_list["clsTourGroup"] = $clsTourGroup;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsContinent = new Continent();
    $assign_list["clsContinent"] = $clsContinent;
    $clsPromotionItem = new PromotionItem();
    $assign_list["clsPromotionItem"] = $clsPromotionItem;
    $clsPromotion = new Promotion();
    $assign_list["clsPromotion"] = $clsPromotion;
    $clsTourStartDate = new TourStartDate();
    $assign_list["clsTourStartDate"] = $clsTourStartDate;
    $clsCountry = new _Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCountryEx = new Country();
    $assign_list["clsCountryEx"] = $clsCountryEx;
    $clsRegion = new Region();
    $assign_list["clsRegion"] = $clsRegion;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsProfile = new Profile();
    $assign_list["clsProfile"] = $clsProfile;
    $clsAddOnService = new AddOnService();
    $assign_list["clsAddOnService"] = $clsAddOnService;
    #

    $show = Input::get('show');
    $message = Input::get('message', "");
    $run_ajax = Input::get('run_ajax', "");
    $cat_run = Input::get('cat_run', "");
    $tour_id = $pvalTable = (int)Input::get('tour_id', 0);
    $assign_list["show"] = $show;
    $assign_list["message"] = $message;
    $assign_list["run_ajax"] = $run_ajax;
    $assign_list["cat_run"] = $cat_run;
    $assign_list["tour_id"] = $tour_id;
    $assign_list["pvalTable"] = $pvalTable;
    //ini_set('display_errors',1); 

    /* =========================
 * BASIC
 * ========================= */
    $list_basic_ar = [
        'cat_menu' => 'basic',
        'icon'     => '<i class="fa-solid fa-house"></i>',
        'child'    => [
            'title-tripcode',
            'option-tour',
            'duration-tour',
            'image-file-tour',
            'overview-tour',
            'inclusion-tour',
            'exclusion-tour',
            'whatcarry-tour',
            'cancellation_policy-tour',
            'refund-tour',
            'confirmation-policy-tour',
            'additional-info',
            'meeting-point',
            'end-point'
        ]
    ];

    /* =========================
 * ITINERARY
 * ========================= */
    $list_itinerary_ar = [
        'cat_menu' => 'itinerary',
        'icon'     => '<i class="fa-solid fa-clipboard-list"></i>',
        'child'    => ['itinerary']
    ];

    /* =========================
 * DESTINATION
 * ========================= */
    $list_destination_ar = [
        'cat_menu' => 'destination',
        'icon'     => '<i class="fa-solid fa-location-dot"></i>',
        'child'    => [
            'destination',
        ]
    ];
    $list_faq_ar = array('cat_menu' => 'Faq', 'icon' => '', 'child' => array('faq'));
    /* =========================
 * CONFIGURATION (DYNAMIC)
 * ========================= */
    $configurationChild = [];

    if ($clsISO->getCheckActiveModulePackage($package_id, 'property', 'service', 'default')) {
        $configurationChild[] = 'add-on-services';
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'tour_related', 'customize')) {
        $configurationChild[] = 'related_tours';
    }

    if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'tour_gallery', 'customize')) {
        $configurationChild[] = 'image-gallery';
    }

    $list_configuration_ar = [
        'cat_menu' => 'configuration',
        'icon'     => '<i class="fa-solid fa-gears"></i>',
        'child'    => $configurationChild
    ];

    /* =========================
 * PRICE / PACKAGE / AGENT
 * ========================= */
    $list_price_table_ar = [
        'cat_menu' => 'pricetable',
        'icon'     => '<i class="fa-solid fa-suitcase"></i>',
        'child'    => ['price-config', 'price-table']
    ];

    $list_tour_package_ar = [
        'cat_menu' => 'tourpackage',
        'icon'     => '<i class="fa-solid fa-suitcase"></i>',
        'child'    => ['tour-package']
    ];

    $list_travel_agent_ar = [
        'cat_menu' => 'travel_agent',
        'icon'     => '<i class="fa-solid fa-suitcase"></i>',
        'child'    => ['travel-agent']
    ];

    /* =========================
 * PRICE NEW (AGE GROUP)
 * ========================= */
    $listVitorageTypeChildren = $clsTourOption->getAll(
        "is_trash=0 
     AND type='SIZEGROUP' 
     AND tour_property_id='" . (int)$age_type_id . "' 
     AND tour_property_age='" . (int)$child_type_id . "' 
     ORDER BY order_no ASC",
        $clsTourOption->pkey . ',title'
    );
    $assign_list['listVitorageTypeChildren'] = $listVitorageTypeChildren;

    $listVitorageTypeInfant = $clsTourOption->getAll(
        "is_trash=0 
     AND type='SIZEGROUP' 
     AND tour_property_id='" . (int)$age_type_id . "' 
     AND tour_property_age='" . (int)$infant_type_id . "' 
     ORDER BY order_no ASC",
        $clsTourOption->pkey . ',title'
    );
    $assign_list['listVitorageTypeInfant'] = $listVitorageTypeInfant;

    /* =========================
 * PROMOTION / DEPARTURE / SEO
 * ========================= */
    $list_promotion_ar = [
        'cat_menu' => 'promotion',
        'icon'     => '<i class="fa-solid fa-money-bill"></i>',
        'child'    => ['promotion']
    ];

    $list_departure_ar = [
        'cat_menu' => 'departure_date',
        'icon'     => '<i class="fa-solid fa-money-bill"></i>',
        'child'    => ['departure_date']
    ];

    $list_seo_ar = [
        'cat_menu' => 'seotool',
        'icon'     => '<i class="fa-solid fa-s"></i>',
        'child'    => ['seotool']
    ];

    /* =========================
 * SYNC LIST
 * ========================= */
    $list_sync = [
        'title-tripcode',
        'option-tour',
        'duration-tour',
        'image-file-tour',
        'overview-tour',
        'inclusion-tour',
        'exclusion-tour',
        'whatcarry-tour',
        'cancellation_policy-tour',
        'refund-tour',
        'confirmation-policy-tour',
        'additional-info',
        'meeting-point',
        'end-point',
        'itinerary',
        'price-table'
    ];

    $assign_list["list_sync"] = $list_sync;
    #
    $assign_list["PROMO_PERCENT"] = PROMO_PERCENT;
    $assign_list["PROMO_VALUE"] = PROMO_VALUE;
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["pkeyTable"] = $pkeyTable;
    $assign_list["clsClassTable"] = $clsClassTable;
    //$assign_list["get"] = $_GET;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    $parent_id = $oneItem['parent_id'] ?? 0;
    $has_parent_id = !empty($parent_id) ? 1 : 0;
    $assign_list["has_parent_id"] = $has_parent_id;
    $assign_list["parent_id"] = $parent_id;
    #

    if ($run_ajax == 'seotool') {
        $clsMeta = new Meta();
        $assign_list["clsMeta"] = $clsMeta;
        $linkMeta = $clsClassTable->getLink($pvalTable);
        $allMeta = $clsMeta->getAll("config_link='$linkMeta'");
        $meta_id = $allMeta[0]['meta_id'] ?? 0;

        $schema = $clsMeta->getSchemaMarkupFromPost();

        if (!$schema['success']) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($pvalTable) . '&message=updateFailed');
            die();
        }

        $update_schema = ",schema_markup='" . addslashes($schema['data']) . "'";

        if (empty($meta_id)) {
            $introMeta = strip_tags(html_entity_decode(addslashes($oneItem['overview'])));
            $introMeta = explode('$trun$', wordwrap($introMeta, 280, '$trun$', false), 2);
            $introMeta = $introMeta[0] . (isset($introMeta[1]) ? '...' : '');
            $meta_id = $clsMeta->getMaxId();
            $clsMeta->insertOne("config_link,config_value_title,config_value_intro,image,reg_date,upd_date,meta_id,schema_markup", "'" . $linkMeta . "','" . $oneItem['title'] . "','" . $introMeta . "','" . $oneItem['image'] . "','" . time() . "','" . time() . "','" . $meta_id . "','" . addslashes($schema['data']) ."'");
        }
        $assign_list["meta_id"] = $meta_id;
    }

    $start_date = strtotime(date('d-m-Y') . ' 00:00:00');
    $listPromoValue = $clsPromoValue->getAll("is_trash=0 and due_date>='$start_date'");
    $assign_list["listPromoValue"] = $listPromoValue;
    $tour_group_id = $oneItem['tour_group_id'];
    $assign_list["tour_group_id"] = $tour_group_id;
    #
    if ($oneItem['is_day_trip'] == 1) {
        $list_menu_tour = array($list_basic_ar, $list_itinerary_ar, $list_destination_ar, $list_configuration_ar, $list_seo_ar);
    } else {
        $list_menu_tour[] = $list_basic_ar;
        $list_menu_tour[] = $list_itinerary_ar;
        $list_menu_tour[] = $list_destination_ar;
        $list_menu_tour[] = $list_configuration_ar;
        $list_menu_tour[] = $list_price_table_ar;
        $list_menu_tour[] = $list_tour_package_ar;

        if ($clsISO->getCheckActiveModulePackage($package_id, 'tour', 'store', 'default', 'REVQQVJUVVJFLVZpZXRJU08=')) {
            if ($checkExistTourStartDate = $clsTourStore->checkExist($tour_id, 'DEPARTURE')) {
                $list_menu_tour[] = $list_departure_ar;
            }
        }
        //        $list_menu_tour[] = $list_travel_agent_ar;
        $list_menu_tour[] = $list_seo_ar;
        $list_menu_tour[] = $list_faq_ar;

        //var_dump($list_menu_tour);
        //die();
    }

    # new menu cho tour cha (menu thông tin chung) và tour package (menu thông tin riêng)
    $all_menu = $list_menu_tour;

    // Menu cho tour package
    foreach ($all_menu as $key => &$item) {
        $cat = $item['cat_menu'];

        if ($cat === 'basic') {
            $item['child'] = array_values(array_filter($item['child'], function ($c) {
                // chọn các menu con ở cat basic
                return in_array($c, ['title-tripcode', 'inclusion-tour', 'exclusion-tour']);
            }));

            if (empty($item['child'])) {
                unset($all_menu[$key]);
            }
        } elseif (!in_array($cat, ['pricetable', 'departure_date'])) {
            unset($all_menu[$key]); // loại bỏ các cat_menu khác
        }
    }
    unset($item); // bỏ tham chiếu
    $list_menu_tour_package = array_values($all_menu);

    # nếu tour cha active tour package thì ẩn menu departure_date, price table
    # nếu tour cha off tour package thì ẩn menu tourpackage

    $remove_cat_menu = $oneItem["has_package"] ? ['pricetable', 'departure_date'] : ['tourpackage'];
    foreach ($list_menu_tour as $key => &$item) {
        if (in_array($item['cat_menu'], $remove_cat_menu)) {
            unset($list_menu_tour[$key]); // loại bỏ các cat_menu khác
        }
    }
    unset($item); // bỏ tham chiếu
    $list_menu_tour = array_values($list_menu_tour);

    # End new menu
    $assign_list["list_menu_tour"] = $has_parent_id ? $list_menu_tour_package : $list_menu_tour;
    //var_dump($list_menu_tour);
    //die();
    #
    $lstCity = $clsCity->getAll("is_trash=0 and country_id='1'");
    $assign_list["lstCity"] = $lstCity;
    #
    $lstActivities = $clsActivities->getAll("is_trash=0 and is_online=1 order by order_no asc");
    $assign_list["lstActivities"] = $lstActivities;
    unset($lstActivities);
    # Tour Services
    $lstAddOnService = $clsAddOnService->getAll("is_trash=0 and is_online=1 order by order_no asc");
    $assign_list["lstAddOnService"] = $lstAddOnService;
    unset($lstAddOnService);
    #
    $title_tripcode = $has_parent_id ? 'Title' : 'Title and trip code';

    if (isset($_GET['_']) && (isset($cat_run) || isset($run_ajax))) {
        $list_check_target = [];
        addCheckTarget(
            $list_check_target,
            ($oneItem['title'] !== '' && $oneItem['trip_code']) ? 'check_success' : 'check_caution',
            'basic',
            'title-tripcode',
            $core->get_Lang($title_tripcode),
            (bool)$oneItem['yield_id'],
        );
        addCheckTarget(
            $list_check_target,
            (isValidPipeValue($oneItem['list_cat_id']) && isValidPipeValue($oneItem['list_departure_point_id']))
                ? 'check_success' : 'check_caution',
            'basic',
            'option-tour',
            $core->get_Lang('Option Tour')
        );
        $durationOK = false;

        if ((int)$oneItem['duration_type'] === 1) {
            $durationOK = $oneItem['duration_custom'] !== '';
        } else {
            $durationOK = (
                (int)$oneItem['number_day'] > 0 ||
                (int)$oneItem['dra_hours'] > 0 ||
                (int)$oneItem['dra_min'] > 0
            );
        }

        addCheckTarget(
            $list_check_target,
            $durationOK ? 'check_success' : 'check_caution',
            'basic',
            'duration-tour',
            $core->get_Lang('Duration Tour'),
            (bool)$oneItem['yield_id'],
        );
        $basicFields = [
            'image'               => ['image-file-tour', 'Image, file Tour'],
            'overview'            => ['overview-tour', 'Overview Tour'],
            'inclusion'           => ['inclusion-tour', 'Inclusion Tour'],
            'exclusion'           => ['exclusion-tour', 'Exclusion Tour'],
            'thing_to_carry'      => ['whatcarry-tour', 'Thing To Carry'],
            'cancellation_policy' => ['cancellation_policy-tour', 'Cancellation Policy'],
            'refund_policy'       => ['refund-tour', 'Refund Policy'],
            'confirmation_policy' => ['confirmation-policy-tour', 'Confirmation Policy'],
            'additional_info'     => ['additional-info', 'Additional Info'],
            'meeting_point'       => ['meeting-point', 'Meeting Point'],
            'end_point'           => ['end-point', 'End Point']
        ];

        foreach ($basicFields as $field => $config) {
            [$target, $label] = $config;

            addCheckTarget(
                $list_check_target,
                !empty($oneItem[$field]) ? 'check_success' : 'check_caution',
                'basic',
                $target,
                $core->get_Lang($label),
                (bool)$oneItem['yield_id'],
            );
        }
        $lstItemIti = $clsTourItinerary->getAll(
            "is_trash=0 and tour_id='$tour_id' and title_contingency='' order by order_no asc",
            $clsTourItinerary->pkey . ',day,day2,reg_date'
        );

        $assign_list['lstItemIti'] = $lstItemIti;

        addCheckTarget(
            $list_check_target,
            !empty($lstItemIti) ? 'check_success' : 'check_caution',
            'itinerary',
            'itinerary',
            $core->get_Lang('Itinerary'),
            (bool)$oneItem['yield_id'],
        );
        $lstDestinationex = $clsTourDestination->getAll(
            "is_trash=0 and tour_id='$tour_id' order by order_no asc"
        );

        addCheckTarget(
            $list_check_target,
            !empty($lstDestinationex) ? 'check_success' : 'check_caution',
            'destination',
            'destination',
            $core->get_Lang('Destination')
        );

        if ($clsISO->getCheckActiveModulePackage($package_id, 'property', 'service', 'default')) {
            addCheckTarget(
                $list_check_target,
                isValidPipeValue($oneItem['list_service_id']) ? 'check_success' : 'check_caution',
                'configuration',
                'add-on-services',
                $core->get_Lang('Add On Services')
            );
        }
        $lstItemRelateTourn = $clsTourExtension->getAll(
            "is_trash=0 and tour_1_id='$tour_id' order by order_no asc"
        );

        addCheckTarget(
            $list_check_target,
            !empty($lstItemRelateTourn) ? 'check_success' : 'check_caution',
            'configuration',
            'related_tours',
            $core->get_Lang('Related tours')
        );
        $lstItemGalleryn = $clsTourImage->getAll(
            "is_trash=0 and table_id='$tour_id' order by order_no asc"
        );

        $assign_list['lstItemGalleryn'] = $lstItemGalleryn;

        addCheckTarget(
            $list_check_target,
            !empty($lstItemGalleryn) ? 'check_success' : 'check_caution',
            'configuration',
            'image-gallery',
            $core->get_Lang('Gallery')
        );
        $now_day = strtotime(date('m/d/Y'));
        $assign_list['now_day'] = $now_day;

        $tour_price = $clsTour->getTripPriceNewPro2020($tour_id, $now_day, '', 'value');

        addCheckTarget(
            $list_check_target,
            ($tour_price > 0) ? 'check_success' : 'check_caution',
            'pricetable',
            'price-table',
            $core->get_Lang('Price table'),
            (bool)$oneItem['yield_id'],
        );

        addCheckTarget(
            $list_check_target,
            (!empty($oneItem['tour_option']) &&
                (empty($oneItem['adult_group_size']) ||
                    !empty($oneItem['child_group_size']) ||
                    !empty($oneItem['infant_group_size'])))
                ? 'check_success' : 'check_caution',
            'pricetable',
            'price-config',
            $core->get_Lang('Price Config')
        );
        $check_title_seotool = $clsISO->getPageTitle($pvalTable, 'Tour');
        $check_des_seotool   = $clsISO->getPageDescription($pvalTable, 'Tour');

        addCheckTarget(
            $list_check_target,
            ($check_title_seotool || $check_des_seotool) ? 'check_success' : 'check_caution',
            'seotool',
            'seotool',
            $core->get_Lang('Seo tool')
        );
        $assign_list['list_check_target'] = json_encode($list_check_target);
        $assign_list['_isoman_use'] = _isoman_use;

        unset($list_check_target);
        /* ------------------ End Check ------------*/
        if ($run_ajax == 'overview') {
            if ($oneItem['list_cat_id'] != '' && $oneItem['list_cat_id'] != '||' && $oneItem['list_cat_id'] != '|0|') {
                $lst_travel_style_overview = $oneItem['list_cat_id'];
                $lst_travel_style_overview = rtrim($lst_travel_style_overview, '|');
                $lst_travel_style_overview = ltrim($lst_travel_style_overview, '|0|');
                $lst_travel_style_overview = explode('|', $lst_travel_style_overview);
                $assign_list["lst_travel_style_overview"] = $lst_travel_style_overview;
            } else {
                $assign_list["lst_travel_style_overview"] = '';
            }
            if ($oneItem['list_tag_id'] != '||' && $oneItem['list_tag_id'] != '|0|' && $oneItem['list_tag_id'] != '' && $oneItem['list_tag_id'] != '|0||') {
                $lst_tag_overview = $oneItem['list_tag_id'];
                $lst_tag_overview = rtrim($lst_tag_overview, '|');
                $lst_tag_overview = ltrim($lst_tag_overview, '|0|');
                $lst_tag_overview = explode('|', $lst_tag_overview);
                $assign_list["lst_tag_overview"] = $lst_tag_overview;
            } else {
                $assign_list["lst_tag_overview"] = $lst_tag_overview = '';
            }
            //        $clsISO->print_pre($assign_list["lst_tag_overview"],true);die();
            if ($oneItem['list_departure_point_id'] != '||' && $oneItem['list_departure_point_id'] != '|0|' && $oneItem['list_departure_point_id'] != '') {
                $lst_departure_point_overview = $oneItem['list_departure_point_id'];
                $lst_departure_point_overview = rtrim($lst_departure_point_overview, '|');
                $lst_departure_point_overview = ltrim($lst_departure_point_overview, '|0|');
                $lst_departure_point_overview = explode('|', $lst_departure_point_overview);
                $assign_list["lst_departure_point_overview"] = $lst_departure_point_overview;
            } else {
                $assign_list["lst_departure_point_overview"] = $lst_departure_point_overview = '';
            }

            if ($oneItem['list_activities_id'] != '||' && $oneItem['list_activities_id'] != '|0|' && $oneItem['list_activities_id'] != '' && $clsISO->getCheckActiveModulePackage($package_id, 'property', 'activities', 'default')) {
                $lst_activities_overview = $oneItem['list_activities_id'];
                $lst_activities_overview = rtrim($lst_activities_overview, '|');
                $lst_activities_overview = ltrim($lst_activities_overview, '|0|');
                $lst_activities_overview = explode('|', $lst_activities_overview);
                $assign_list["lst_activities_overview"] = $lst_activities_overview;
            } else {
                $assign_list["lst_activities_overview"] = $lst_activities_overview = '';
            }

            if ($oneItem['list_service_id'] != '||' && $oneItem['list_service_id'] != '|0|' && $oneItem['list_service_id'] != '') {
                $lst_service_overview = $oneItem['list_service_id'];
                $lst_service_overview = rtrim($lst_service_overview, '|');
                $lst_service_overview = ltrim($lst_service_overview, '|0|');
                $lst_service_overview = explode('|', $lst_service_overview);
                $assign_list["lst_service_overview"] = $lst_service_overview;
            } else {
                $assign_list["lst_service_overview"] = $lst_activities_overview = '';
            }

            $current_date = date('m/d/Y');
            $current_time = strtotime($current_date);
            $assign_list['now_day'] = $current_time;
            $departure_date = isset($_POST['departure']) ? $_POST['departure'] : '';
            $is_agent = isset($_POST['is_agent']) ? $_POST['is_agent'] : '0';
            $assign_list['is_agent'] = $is_agent;

            $tmp_departure_date = explode('/', $departure_date);

            $monthFilter = $tmp_departure_date[0];
            $YearFilter = $tmp_departure_date[1];

            $startdate = $monthFilter . '/01/' . $YearFilter;
            $enddate = $monthFilter . '/31/' . $YearFilter;

            if ($is_agent != '') {
                if ($departure_date != '') {
                    $lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date >= '" . time() . "' and start_date >= '" . strtotime($startdate) . "' and start_date <= '" . strtotime($enddate) . "' and is_agent='$is_agent' order by start_date asc");
                } else {
                    $lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and is_agent='$is_agent' order by start_date asc");
                }
            } else {
                if ($departure_date != '') {
                    $lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and start_date >= '" . time() . "' and start_date >= '" . strtotime($startdate) . "' and start_date <= '" . strtotime($enddate) . "' and is_agent<>1 order by start_date asc");
                } else {
                    $lstTourStartDate = $clsTourStartDate->getAll("tour_id='$tour_id' and is_agent<>1 order by start_date asc");
                }
            }

            $sql = "SELECT * FROM " . $clsPromotion->tbl . " p LEFT JOIN " . $clsPromotionItem->tbl . " pi ON(p." . $clsPromotion->pkey . " = pi." . $clsPromotion->pkey . ") WHERE p.is_online = 1 and p.type = 'Tour' and pi.taget_id =$tour_id ORDER BY p.promotion_id desc";
            $lstPromotion = $dbconn->GetAll($sql);

            $assign_list["lstPromotion"] = $lstPromotion;
            $assign_list["lstTourStartDate"] = $lstTourStartDate;

            $assign_list["count_relate"] = count($lstItemRelateTourn);

            $tour_class_price = explode(',', $oneItem['tour_option']);
            $assign_list["tour_class_price"] = $oneItem['tour_option'] ? $tour_class_price : '';

            $tour_adult_group_size = explode(',', $oneItem['adult_group_size']);
            $assign_list["tour_adult_group_size"] = $oneItem['adult_group_size'] ? $tour_adult_group_size : '';

            $tour_child_group_size = explode(',', $oneItem['child_group_size']);
            $assign_list["tour_child_group_size"] = $oneItem['child_group_size'] ? $tour_child_group_size : '';

            $tour_infant_group_size = explode(',', $oneItem['infant_group_size']);
            $assign_list["tour_infant_group_size"] = $oneItem['infant_group_size'] ? $tour_infant_group_size : '';
        }

        // Return
        //ini_set( "display_errors", 1);
        $html = $core->build('load_step_form_tour.tpl');
        echo $html;
        die();
    }
    #
}

function addCheckTarget(
    array &$list,
    string $result,
    string $cat,
    string $target,
    string $name,
    bool $yield_id = false,
) {
    global $clsISO;
    if ($yield_id && $result === 'check_success' && $clsISO) {
        $name .= $clsISO->makeIcon('compress', '', 'ml-2');
    }
    $list[] = [
        'result' => $result,
        'cat'    => $cat,
        'target' => $target,
        'name'   => $name
    ];
}

function isValidPipeValue($value): bool
{
    return $value !== '' && $value !== '||' && $value !== '|0|' && $value !== '|0||';
}

function default_updateTourStore()
{
    global $core, $dbconn, $clsISO;
    #
    $clsTourStore = new TourStore();
    #
    $type = $_POST['type'] ?? '';
    $tour_id = $_POST['tour_id'] ?? '';
    $val = $_POST['val'] ?? 0;
    #
    $response = [
        'res' => false,
        'msg' => $core->get_Lang("Error"),
    ];
    $clsTourStore->deleteByCond("tour_id={$tour_id} AND _type='{$type}'");

    if (!empty($val)) {
        $data = [
            'tour_store_id' => $clsTourStore->getMaxId(),
            'tour_id' => $tour_id,
            '_type' => $type,
            'order_no' => $clsTourStore->getMaxOrderNo(),
            'is_trash' => 0,
        ];
        if ($clsTourStore->insert($data)) {
            $response = [
                'res' => true,
                'msg' => $core->get_Lang("Insert success"),
            ];
        } else {
            $response = [
                'res' => false,
                'msg' => $core->get_Lang("Insert error"),
            ];
        }
    } else {
        $response = [
            'res' => true,
        ];
    }

    die(json_encode($response));
}

// Hàm tách nội dung văn bản khỏi các thẻ HTML
function extractText($html)
{
    $html = @mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'); // Tắt cảnh báo
    $dom = new DOMDocument;
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    $textNodes = $xpath->query('//text()');
    $texts = [];
    foreach ($textNodes as $node) {
        $texts[] = $node->nodeValue;
    }
    return $texts;
}

// Hàm ghép nội dung đã dịch với các thẻ HTML gốc
function replaceText($html, $translatedTexts)
{
    $dom = new DOMDocument;
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    $textNodes = $xpath->query('//text()');
    foreach ($textNodes as $key => $node) {
        if (!trim($node->nodeValue)) continue;
        $node->nodeValue = htmlentities($translatedTexts[$key]) ?? $node->nodeValue;
    }
    return $dom->saveHTML();
}

// Hàm sử dụng multi cURL để thực hiện nhiều yêu cầu đồng thời
function multiTranslate($texts, $source, $target)
{
    $multiCurl = curl_multi_init();
    $curlHandles = [];
    $results = [];
    foreach ($texts as $i => $text) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://translate.googleapis.com/translate_a/single?client=gtx&sl={$source}&tl={$target}&dt=t&q=" . urlencode($text));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_multi_add_handle($multiCurl, $ch);
        $curlHandles[$i] = $ch;
    }
    $running = null;
    do {
        curl_multi_exec($multiCurl, $running);
        curl_multi_select($multiCurl);
    } while ($running > 0);
    foreach ($curlHandles as $i => $ch) {
        $response = curl_multi_getcontent($ch);
        $json = json_decode($response, true);
        $results[$i] = $json[0][0][0] ?? '';
        curl_multi_remove_handle($multiCurl, $ch);
        curl_close($ch);
    }
    curl_multi_close($multiCurl);
    return $results;
}


function default_ajSaveDataTour()
{
    //ini_set('display_errors',1);
    //error_reporting(E_ALL);//E_ALL
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id, $age_type_id, $height_type_id, $child_type_id, $infant_type_id;
    // header('Content-Type: application/json');
    $clsTour = new Tour();
    $clsTourStore = new TourStore();
    $clsTourOption  = new TourOption();
    $clsTourStartDate = new TourStartDate();
    $clsTourPriceGroup = new TourPriceGroup();
    $assign_list["clsTourPriceGroup"] = $clsTourPriceGroup;
    #
    $pvalTable = (int) Input::post('tour_id', 0);
    $oneItem = $clsTour->getOne($pvalTable);
    #
    $clsMeta = new Meta();
    $linkMeta = $clsTour->getLink($pvalTable);
    $allMeta = $clsMeta->getAll("config_link='{$linkMeta}'", $clsMeta->pkey);
    $meta_id = !empty($allMeta) ? $allMeta[0]['meta_id'] : 0;

    $result = array('result' => 'error');
    $value = '';
    if (!empty($_POST['skip'])) {
        $result = array(
            'result' => 'success',
            'caution' => 'next'
        );
        die(json_encode($result));
    }
    if ($_POST) {
        $firstAdd = 0;
        $arr_key = array_keys($_POST);
        $cat_run = Input::post('cat_run');
        $type_post = Input::post('type_post');
        $present_step = Input::post('present_step');
        if ($type_post == 'activities-tour') {
            $list_activities_id = Input::post('list_activities_id', array());
            $list_activities_id = !empty($list_activities_id) ? $clsISO->makeSlashListFromArray($list_activities_id) : "";
            if ($firstAdd == 0) {
                $value .= "list_activities_id='" . $list_activities_id . "'";
                $firstAdd = 1;
            } else {
                $value .= ",list_activities_id='" . $list_activities_id . "'";
            }
        } else if ($type_post == 'add-on-services') {
            $list_service_id = Input::post('list_service_id');
            //$clsISO->print_pre($list_service_id); die();
            $list_service_id = !empty($list_service_id) ? $clsISO->makeSlashListFromArray($list_service_id) : "";
            if ($firstAdd == 0) {
                $value .= "list_service_id='" . $list_service_id . "'";
                $firstAdd = 1;
            } else {
                $value .= ",list_service_id='" . $list_service_id . "'";
            }
        } else if ($type_post == 'option-tour') {
            $tour_group_id = Input::post('tour_group_id', 0);
            if ($firstAdd == 0) {
                $value .= "tour_group_id='" . $tour_group_id . "'";
                $firstAdd = 1;
            } else {
                $value .= ",tour_group_id='" . $tour_group_id . "'";
            }
            $cat_ids = Input::post('cat_id', array());
            if (!empty($cat_ids) && is_array($cat_ids)) {
                $list_cat_id = '|';
                foreach ($cat_ids as $c_id) {
                    $list_cat_id .= $c_id . '|';
                }
                if ($firstAdd == 0) {
                    $value .= "cat_id='" . $cat_ids[0] . "'
					,list_cat_id='" . addslashes($list_cat_id) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= ",cat_id='" . $cat_ids[0] . "'
					,list_cat_id='" . addslashes($list_cat_id) . "'";
                }
            } else {
                $cat_id = $cat_ids;
                $list_cat_id = '|' . $cat_id . '|';
                if ($firstAdd == 0) {
                    $value .= "cat_id='" . $cat_id . "',list_cat_id='{$list_cat_id}'";
                    $firstAdd = 1;
                } else {
                    $value .= ",cat_id='" . $cat_id . "',list_cat_id='{$list_cat_id}'";
                }
            }
            #
            $tag_ids = Input::post('tag_id', array());
            if (!empty($tag_ids)) {
                $list_tag_id = '|';
                foreach ($tag_ids as $key => $t_id) {
                    $list_tag_id .= $t_id . '|';
                }
                if ($firstAdd == 0) {
                    $value .= ",list_tag_id='" . addslashes($list_tag_id) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= ",list_tag_id='" . addslashes($list_tag_id) . "'";
                }
            }

            $departure_point_ids = Input::post('departure_point_id', array());
            if (!empty($departure_point_ids) && is_array($departure_point_ids)) {
                $list_departure_point_id = '|';
                foreach ($departure_point_ids as $c_id) {
                    $list_departure_point_id .= $c_id . '|';
                }
                if ($firstAdd == 0) {
                    $value .= "departure_point_id='" . $departure_point_ids[0] . "'
					,list_departure_point_id='" . addslashes($list_departure_point_id) . "'";
                    $firstAdd = 1;
                } else {
                    $value .= ",departure_point_id='" . $departure_point_ids[0] . "'
					,list_departure_point_id='" . addslashes($list_departure_point_id) . "'";
                }
            } else {
                $departure_point_id = $departure_point_ids;
                $list_departure_point_id = '|' . $departure_point_id . '|';
                if ($firstAdd == 0) {
                    $value .= "departure_point_id='" . $departure_point_id . "',list_departure_point_id='{$list_departure_point_id}'";
                    $firstAdd = 1;
                } else {
                    $value .= ",departure_point_id='" . $departure_point_id . "',list_departure_point_id='{$list_departure_point_id}'";
                }
            }
            $is_best_price = Input::post('is_best_price');
            $is_recommended = Input::post('is_recommended');
            if($is_best_price != '') $value .= ",is_best_price='" . $is_best_price . "'";
            if($is_recommended != '') $value .= ",is_recommended='" . $is_recommended . "'";

        } else if ($type_post == 'seotool') {
            $config_value_title = Input::post('config_value_title');
            $config_value_intro = Input::post('config_value_intro');
            $config_value_keyword = Input::post('config_value_keyword');
            $isoman_url_image_seo = Input::post('isoman_url_image_seo');
            //$clsISO->print_pre($config_value_intro); die();

            $schema = $clsMeta->getSchemaMarkupFromPost();

            if (!$schema['success']) {
                $result = array(
                    'result' => 'error_seo',
                    'caution' => 'seo_schema_markup'
                );
                echo json_encode($result);
                die();
            }

            $update_schema = ",schema_markup='" . addslashes($schema['data']) . "'";
            if (!empty($config_value_title)) {
                if ($meta_id == 0) {
                    $clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
                    $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "' limit 0,1", $clsMeta->pkey);
                    $meta_id = $allMeta[0]['meta_id'];
                }
                $clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($config_value_intro) . "',config_value_keyword='" . addslashes($config_value_keyword) . "',config_value_title='" . addslashes($config_value_title) . "',image='" . addslashes($isoman_url_image_seo) . "',upd_date='" . time() . "'" . $update_schema);
                $result = array('result' => 'success', 'caution' => 'next');
            }
        } else if ($type_post == 'price-config') {
            $tour_option = Input::post('tour_option', array());
            $adult_size_group = Input::post('adult_size_group', array());
            $child_size_group = Input::post('child_size_group', array());
            $baby_size_group = Input::post('infant_size_group', array());

            $type_visitor_child = Input::post('type_visitor_child', $age_type_id);
            $visitorage_child = Input::post('visitorage_child', array());
            $visitorheight_child = Input::post('visitorheight_child', array());

            $type_visitor_infant = Input::post('type_visitor_infant', $age_type_id);
            $visitorage_infant = Input::post('visitorage_infant', array());
            $visitorheight_infant = Input::post('visitorheight_infant', array());

            if (!empty($adult_size_group)) {
                for ($i = 0; $i < count($adult_size_group); $i++) {
                    if (
                        $clsTourOption->getMin($adult_size_group[$i + 1]) <= $clsTourOption->getMax($adult_size_group[$i])
                        && !empty($clsTourOption->getMin($adult_size_group[$i + 1]))  && !empty($clsTourOption->getMax($adult_size_group[$i]))
                    ) {
                        $result = array(
                            'result' => 'error_adult',
                            'caution' => 'adult_size_group'
                        );
                        echo json_encode($result);
                        die();
                    }
                }
            }

            #children
            if ($type_visitor_child == $age_type_id) {
                $cond_age_height_child = " and tour_property_age='" . $child_type_id . "' and tour_property_id='" . $age_type_id . "'";
            } else {
                $cond_age_height_child = " and tour_property_height='" . $child_type_id . "' and tour_property_id='" . $height_type_id . "'";
            }
            $listVitorageTypeChildren = $clsTourOption->getAll("is_trash=0 and type='SIZEGROUP' " . $cond_age_height_child . " order by order_no asc", $clsTourOption->pkey . ',title');
            $child_size_groupPost = [];
            foreach ($listVitorageTypeChildren as $key => $val) {
                $child_size_group = Input::post('child_size_group_' . $val['tour_option_id'], array());
                #
                if (!empty($child_size_group)) {
                    for ($i = 0; $i < count($child_size_group); $i++) {
                        if (
                            $clsTourOption->getMin($child_size_group[$i + 1]) <= $clsTourOption->getMax($child_size_group[$i])
                            && !empty($clsTourOption->getMin($child_size_group[$i + 1])) && !empty($clsTourOption->getMax($child_size_group[$i]))
                        ) {
                            $result = array(
                                'result' => 'error_child',
                                'caution' => 'child_size_group'
                            );
                            echo json_encode($result);
                            die();
                        }
                    }
                }
                $child_size_group = !empty($child_size_group) ? $clsISO->makeSlashListFromArrayComma($child_size_group) : "";
                $child_size_groupPost[] = $child_size_group;

                //xóa nhóm giá
                if ($type_visitor_child == $age_type_id) {
                    if (!empty($child_size_group)) {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND ((tour_number_group_id NOT IN (" . $child_size_group . ") AND tour_visitor_age_type_id ='" . $val['tour_option_id'] . "') OR (tour_number_group_id IN (" . $child_size_group . ") AND tour_visitor_age_type_id ='0')) AND tour_visitor_type_id='" . $child_type_id . "'");
                    } else {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND ( tour_visitor_age_type_id ='" . $val['tour_option_id'] . "' OR  tour_visitor_age_type_id ='0') AND tour_visitor_type_id='" . $child_type_id . "'");
                    }
                } elseif ($type_visitor_child == $height_type_id) {
                    if (!empty($child_size_group)) {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND ((tour_number_group_id NOT IN (" . $child_size_group . ") AND tour_visitor_height_type_id ='" . $val['tour_option_id'] . "') OR (tour_number_group_id IN (" . $child_size_group . ") AND tour_visitor_height_type_id ='0')) AND tour_visitor_type_id='" . $child_type_id . "'");
                    } else {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND ( tour_visitor_height_type_id ='" . $val['tour_option_id'] . "' OR  tour_visitor_height_type_id ='0') AND tour_visitor_type_id='" . $child_type_id . "'");
                    }
                }
                unset($child_size_group);
            }


            #infant
            if ($type_visitor_infant == $age_type_id) {
                $cond_age_height_infant = " and tour_property_age='" . $infant_type_id . "' and tour_property_id='" . $age_type_id . "'";
            } else {
                $cond_age_height_infant = " and tour_property_height='" . $infant_type_id . "' and tour_property_id='" . $height_type_id . "'";
            }
            $listVitorageTypeInfant = $clsTourOption->getAll("is_trash=0 and type='SIZEGROUP' " . $cond_age_height_infant . " order by order_no asc", $clsTourOption->pkey . ',title');

            $baby_size_groupPost = [];
            foreach ($listVitorageTypeInfant as $key => $val) {
                $infant_size_group = Input::post('infant_size_group_' . $val['tour_option_id'], array());
                #
                if (!empty($infant_size_group)) {
                    for ($i = 0; $i < count($infant_size_group); $i++) {
                        if (
                            $clsTourOption->getMin($infant_size_group[$i + 1]) <= $clsTourOption->getMax($infant_size_group[$i])
                            && !empty($clsTourOption->getMin($infant_size_group[$i + 1])) && !empty($clsTourOption->getMax($infant_size_group[$i]))
                        ) {
                            $result = array(
                                'result' => 'error_infant',
                                'caution' => 'infant_group_size'
                            );
                            echo json_encode($result);
                            die();
                        }
                    }
                }
                $infant_size_group = !empty($infant_size_group) ? $clsISO->makeSlashListFromArrayComma($infant_size_group) : "";
                $baby_size_groupPost[] = $infant_size_group;
                //xóa nhóm giá
                if ($type_visitor_infant == $age_type_id) {
                    if (!empty($infant_size_group)) {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND ((tour_number_group_id NOT IN (" . $infant_size_group . ") AND tour_visitor_age_type_id ='" . $val['tour_option_id'] . "') OR (tour_number_group_id IN (" . $infant_size_group . ") AND tour_visitor_age_type_id ='0')) AND tour_visitor_type_id='" . $infant_type_id . "'");
                    } else {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND (tour_visitor_age_type_id ='" . $val['tour_option_id'] . "' OR  tour_visitor_age_type_id ='0') AND tour_visitor_type_id='" . $infant_type_id . "'");
                    }
                } elseif ($type_visitor_infant == $height_type_id) {
                    if (!empty($infant_size_group)) {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND ((tour_number_group_id NOT IN (" . $infant_size_group . ") AND tour_visitor_height_type_id ='" . $val['tour_option_id'] . "') OR (tour_number_group_id IN (" . $infant_size_group . ") AND tour_visitor_height_type_id ='0')) AND tour_visitor_type_id='" . $infant_type_id . "'");
                    } else {
                        $clsTourPriceGroup->deleteByCond("tour_id='" . $pvalTable . "' AND (tour_visitor_height_type_id ='" . $val['tour_option_id'] . "' OR  tour_visitor_height_type_id ='0') AND tour_visitor_type_id='" . $infant_type_id . "'");
                    }
                }
                unset($infant_size_group);
            }

            $tour_optionPost         = !empty($tour_option) ? $clsISO->makeSlashListFromArrayComma($tour_option) : "";
            $adult_size_groupPost     = !empty($adult_size_group) ? $clsISO->makeSlashListFromArrayComma($adult_size_group) : "";
            $child_size_groupPost     = !empty($child_size_groupPost) ? $clsISO->makeSlashListFromArray($child_size_groupPost, "|") : "";
            $baby_size_groupPost     = !empty($baby_size_groupPost) ? $clsISO->makeSlashListFromArray($baby_size_groupPost, "|") : "";
            $visitorage_child         = !empty($visitorage_child) ? $clsISO->makeSlashListFromArray($visitorage_child, "|") : "";
            $visitorheight_child     = !empty($visitorheight_child) ? $clsISO->makeSlashListFromArray($visitorheight_child, "|") : "";
            $visitorage_infant         = !empty($visitorage_infant) ? $clsISO->makeSlashListFromArray($visitorage_infant, "|") : "";
            $visitorheight_infant     = !empty($visitorheight_infant) ? $clsISO->makeSlashListFromArray($visitorheight_infant, "|") : "";

            if ($firstAdd == 0) {
                $value .= "tour_option='" . $tour_optionPost . "'";
                $value .= ",adult_group_size='" . $adult_size_groupPost . "'";
                $value .= ",child_group_size='" . $child_size_groupPost . "'";
                $value .= ",infant_group_size='" . $baby_size_groupPost . "'";
                $value .= ",type_visitor_child='" . $type_visitor_child . "'";
                $value .= ",type_visitor_infant='" . $type_visitor_infant . "'";
                $value .= ",visitorage_child='" . $visitorage_child . "'";
                $value .= ",visitorage_infant='" . $visitorage_infant . "'";
                $value .= ",visitorheight_child='" . $visitorheight_child . "'";
                $value .= ",visitorheight_infant='" . $visitorheight_infant . "'";
                $firstAdd = 1;
            } else {
                $value .= ",tour_option='" . $tour_optionPost . "'";
                $value .= ",adult_group_size='" . $adult_size_groupPost . "'";
                $value .= ",child_group_size='" . $child_size_groupPost . "'";
                $value .= ",infant_group_size='" . $baby_size_groupPost . "'";
                $value .= ",type_visitor_child='" . $type_visitor_child . "'";
                $value .= ",type_visitor_infant='" . $type_visitor_infant . "'";
                $value .= ",visitorage_child='" . $visitorage_child . "'";
                $value .= ",visitorage_infant='" . $visitorage_infant . "'";
                $value .= ",visitorheight_child='" . $visitorheight_child . "'";
                $value .= ",visitorheight_infant='" . $visitorheight_infant . "'";
            }
            //			echo $value;die;
        } else if ($type_post == 'duration-tour') {
            $duration_type = Input::post('duration_type');
            $duration_custom = Input::post('duration_custom');
            $number_day = Input::post('number_day') ? Input::post('number_day') : 0;
            $number_night = Input::post('number_night') ? Input::post('number_night') : 0;

            if ($number_night > $number_day) {
                $number_night = $number_day + 1;
            } elseif ($number_night < $number_day) {
                $number_night = $number_day - 1;
            } else {
                $number_night = $number_night;
            }


            if ($firstAdd == 0) {
                $value .= "number_day='" . $number_day . "'";
                $value .= ",number_night='" . $number_night . "'";
                $value .= ",duration_type='" . $duration_type . "'";
                $value .= ",duration_custom='" . $duration_custom . "'";
                $firstAdd = 1;
            } else {
                $value .= ",number_day='" . $number_day . "'";
                $value .= ",number_night='" . $number_night . "'";
                $value .= ",duration_type='" . $duration_type . "'";
                $value .= ",duration_custom='" . $duration_custom . "'";
            }
        } else {
     /*
     * Các field chỉ dùng để điều khiển request,
     * tuyệt đối không ghi trực tiếp vào bảng tour.
     */
    $ignoreFields = array(
        'tour_id',
        'cat_id',
        'tag_id',
        'cat_run',
        'present_step',
        'departure_point_id',
        'isoman_url_file_programme',
        'list_activities_id',
        'list_service_id',
        'type_post',
        'price_type',

        // URL control fields
        'slug',
        'change_url',
        'original_slug'
    );

    foreach ($_POST as $key => $ak) {

        if (in_array($key, $ignoreFields, true)) {
            continue;
        }

        /*
         * Không đưa array/object vào chuỗi SQL.
         */
        if (is_array($ak) || is_object($ak)) {
            continue;
        }

        if ($key === 'price_single_supply') {
            if ((string)$ak === '') {
                continue;
            }

            $fieldValue = str_replace(
                '.',
                '',
                addslashes((string)$ak)
            );
        } else {
            $fieldValue = addslashes((string)$ak);
        }

        if ($firstAdd == 0) {
            $value .= "`" . $key . "`='" . $fieldValue . "'";
            $firstAdd = 1;
        } else {
            $value .= ",`" . $key . "`='" . $fieldValue . "'";
        }
    }

    /*
     * TITLE + URL
     *
     * - Tour mới/chưa có slug: tự sinh URL từ Title.
     * - Tour đã có slug: giữ nguyên URL.
     * - Chỉ cập nhật URL khi người dùng tích Change URL.
     */
    if ($type_post === 'title-tripcode') {

        $title = trim((string)Input::post('title', ''));
        $postedSlug = trim((string)Input::post('slug', ''));
        $changeUrl = (int)Input::post('change_url', 0);

        $currentSlug = trim(
            (string)($oneItem['slug'] ?? '')
        );

        $slugToSave = '';

        /*
         * Trường hợp bản ghi mới hoặc URL hiện tại đang rỗng:
         * tự sinh slug.
         */
        if ($currentSlug === '') {
            $slugToSave = $postedSlug !== ''
                ? $postedSlug
                : $title;
        }

        /*
         * Trường hợp edit và người dùng chủ động tích Change URL.
         */
        if ($currentSlug !== '' && $changeUrl === 1) {
            $slugToSave = $postedSlug !== ''
                ? $postedSlug
                : $title;
        }

        /*
         * Chỉ nối slug vào SQL khi thật sự cần cập nhật.
         * Edit không tích Change URL sẽ không có field slug.
         */
        if ($slugToSave !== '') {

            $slugToSave = $clsISO->replaceSpace2(
                $slugToSave
            );

            $slugToSave = trim(
                (string)$slugToSave,
                '-'
            );

            if ($slugToSave !== '') {
                if ($firstAdd == 0) {
                    $value .= "`slug`='" .
                        addslashes($slugToSave) .
                        "'";
                    $firstAdd = 1;
                } else {
                    $value .= ",`slug`='" .
                        addslashes($slugToSave) .
                        "'";
                }
            }
        }
    }

    if ($type_post === 'price-table') {
        $payments_term_deposit = (int)Input::post(
            'payments_term_deposit',
            0
        );

        if ($firstAdd == 0) {
            $value .= "`payments_term_deposit`='" .
                $payments_term_deposit .
                "'";
            $firstAdd = 1;
        } else {
            $value .= ",`payments_term_deposit`='" .
                $payments_term_deposit .
                "'";
        }
    }
        }
        //		var_dump($_POST);die;
        if (empty($_POST['skip'])) {
            if (empty($value)) {
                $result = array(
                    'result' => 'success',
                    'caution' => 'skip'
                );
            } else {
                //var_dump($pvalTable, $value);
                if ($clsTour->updateOne($pvalTable, $value)) {
                    $clsISO->updateMetaConfigLink($meta_id, $pvalTable, "Tour");
                    $result = array(
                        'result' => 'success',
                        'caution' => 'next'
                    );
                } else {
                    $result = array(
                        'result' => 'error'
                    );
                }
            }
        }
    }
    //	var_dump($result);die;
    // Return
    echo json_encode($result);
    die();
}

function default_ajCheckPublicTour()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id;
    //    header('Content-Type: application/json');
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $pvalTable = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;
    $online = isset($_POST['is_online']) ? $_POST['is_online'] : 0;
    $oneItem = $clsTour->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

    $result = array('result' => '_ERR');
    $value = '';

    //    if($online){
    $value .= 'is_online=' . $online;
    //    }

    if ($clsTour->updateOne($pvalTable, $value)) {
        $result = array('result' => '_SUCCESS');
    } else {
        $result = array('result' => '_ERR');
    }
    echo json_encode($result);
    die();
}
function default_ajCheckPublicCategoryCountry()
{
    global $core;

    $clsCategoryCountry = new Category_Country();

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $is_online = isset($_POST['is_online'])
        ? intval($_POST['is_online'])
        : 0;

    if ($id <= 0 || !in_array($is_online, array(0, 1), true)) {
        echo json_encode(array('result' => '_ERR'));
        die();
    }

    $oneItem = $clsCategoryCountry->getOne($id);

    if (empty($oneItem)) {
        echo json_encode(array('result' => '_ERR'));
        die();
    }

    $result = $clsCategoryCountry->updateOne(
        $id,
        "is_online='" . $is_online . "'"
    );

    echo json_encode(array(
        'result' => $result ? '_SUCCESS' : '_ERR',
        'is_online' => $is_online
    ));
    die();
}
function default_ajCheckTrashTour()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id;
    //    header('Content-Type: application/json');
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $pvalTable = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;
    $type = isset($_POST['type_btn']) ? $_POST['type_btn'] : 0;
    $oneItem = $clsTour->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

    $result = array('result' => '_ERR');
    $value = '';

    if ($type == 'trash') {
        $value .= 'is_trash=1';
    }

    //    $value .= 'is_trash='.$trash;

    if ($type == 'restore') {
        $value .= 'is_trash=0';
    }
    if ($type == 'delete') {
        $clsTour->doDelete($pvalTable);
        $result = array('result' => '_SUCCESS', 'type' => $type, 'link' => PCMS_URL . '/?mod=tour_exhautive');
    } else if ($type == 'delete_package') {
        $clsTour->doDelete($pvalTable);
        $result = array('result' => '_SUCCESS', 'type' => $type, 'link' => $clsTour->linkListTourPackage($oneItem["parent_id"]));
    } else {
        if ($clsTour->updateOne($pvalTable, $value)) {
            $result = array('result' => '_SUCCESS', 'type' => $type, 'link' => '');
        } else {
            $result = array('result' => '_ERR');
        }
    }

    echo json_encode($result);
    die();
}

function default_ajAddMutiGallery()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $_LANG_ID, $clsISO, $package_id;
    //    header('Content-Type: application/json');
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $clsTourImage = new TourImage();
    $path = isset($_POST['path']) ? $_POST['path'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : 0;

    $user_id = $core->_USER['user_id'];
    /*  $oneItem = $clsTour->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;*/

    $result = array('result' => '_ERR');
    $value = '';

    /* if($type == 'trash'){
    $value .= 'is_trash=1';
    }

//    $value .= 'is_trash='.$trash;

    if($type == 'restore'){
    $value .= 'is_trash=0';
    }
    if($type == 'delete'){
        $clsTour->doDelete($pvalTable);
        $result = array('result' => '_SUCCESS','type'=>$type,'link'=>PCMS_URL.'/?mod=tour_exhautive');
    }else{
        if($clsTour->updateOne($pvalTable, $value)){
            $result = array('result' => '_SUCCESS','type'=>$type,'link'=>'');
        }else{
            $result = array('result' => '_ERR');
        }
    }*/

    if ($tour_id > 0) {
        $max_order = $clsTourImage->getMaxOrderNo($tour_id);
        $f = 'table_id,title,slug,image,order_no,user_id,reg_date,is_trash,is_online';
        $name = str_replace('.png', '', $name);
        $name = str_replace('.jpg', '', $name);
        $v = $tour_id . ",'" . $name . "','" . $core->replaceSpace($name) . "','/" . addslashes($path) . "','" . $max_order . "','" . $user_id . "'," . time() . ",0,0";
        if ($clsTourImage->insertOne($f, $v)) {
            $max_id = $clsTourImage->getMaxId($tour_id);
            $image = $clsTourImage->getImage($max_id, 600, 400);
            $result = array('result' => 'success', 'max_id' => $max_id, 'title' => $name, 'path' => '/' . $path, 'image_rz' => $image);
        } else {
            $result = array('result' => 'error', 'f' => $f, 'v' => $v);
        }
    }
    //    $clsISO->print_pre($result,true);die();
    echo json_encode($result);
    die();
}

function default_ajEditImageTour()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id;
    //    header('Content-Type: application/json');
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $clsTourImage = new TourImage();
    $target = isset($_POST['target']) ? $_POST['target'] : '';
    $user_id = $core->_USER['user_id'];

    $result = array('result' => '_ERR');
    $value = '';
    $html = '';
    if ($target != '') {
        $modal = trim($target, '#');
        $id_image = str_replace('edit_tour_image_', '', $modal);
        $html .= '<div class="modal fade" id="' . $modal . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">' . $clsTourImage->getTitle($id_image) . '</h4>
                          </div>
                          <div class="modal-body">';
        $html .= '        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>';
        $result = array('result' => 'success', 'modal' => $modal, 'image' => $id_image, 'html' => $html);
    }

    /* if($tour_id>0){
        $max_order = $clsTourImage->getMaxOrderNo($tour_id);
        $f = 'table_id,title,slug,image,order_no,user_id,reg_date,is_trash,is_online,lang_id';
        $v = $tour_id.",'".trim($name,'.png')."','".$core->replaceSpace(trim($name,'.png'))."','/".$path."','".$max_order."','".$user_id."',".time().",0,0,''";
        if($clsTourImage->insertOne($f,$v)){
            $max_id = $clsTourImage->getMaxId($tour_id);
            $result = array('result' => 'success','max_id'=>$max_id);
        }else{
            $result = array('result' => 'error');
        }
   }*/
    //    $clsISO->print_pre($result,true);die();
    echo json_encode($result);
    die();
}

function default_ajSetZoomMap()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id;
    //    header('Content-Type: application/json');
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $pvalTable = isset($_POST['tour_id']) ? $_POST['tour_id'] : 0;
    $zoom = isset($_POST['zoom']) ? $_POST['zoom'] : 0;
    $oneItem = $clsTour->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

    $result = array('result' => '_ERR');
    $value = '';

    if ($zoom > 0) {
        $value .= 'map_zoom=' . $zoom;

        if ($clsTour->updateOne($pvalTable, $value)) {
            $result = array('result' => '_SUCCESS', 'zoom' => $zoom);
        } else {
            $result = array('result' => '_ERR');
        }
    }

    echo json_encode($result);
    die();
}

function default_move()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];

    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    $tour_type_id = isset($_GET['tour_type_id']) ? $_GET['tour_type_id'] : 0;
    $depart_point_id = isset($_GET['depart_point_id']) ? $_GET['depart_point_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
    $number_day = isset($_GET['number_day']) ? $_GET['number_day'] : '';
    $price_range_id = isset($_GET['price_range_id']) ? $_GET['price_range_id'] : '';

    $where = '1=1 and is_trash=0 ';
    $pUrl = "";
    #--
    if (isset($tour_type_id) && intval($tour_type_id) != 0) {
        $where .= " and tour_type_id=" . $tour_type_id;
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (isset($depart_point_id) && intval($depart_point_id) != 0) {
        $where .= " and depart_point_id=" . $depart_point_id;
        $pUrl .= '&depart_point_id=' . $depart_point_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $where .= " and (cat_id = '" . $cat_id . "' or list_cat_id like '%|" . $cat_id . "|%')";
        $pUrl .= '&cat_id=' . $cat_id;
    }
    if (intval($number_day) != 0) {
        $where .= " and number_day=" . $number_day;
        $pUrl .= '&number_day=' . $number_day;
    }
    if (intval($price_range_id) != 0) {
        $clsPriceRange = new PriceRange();
        $oneTmp = $clsPriceRange->getOne($price_range_id);
        $min_rate = intval($oneTmp['min_rate']);
        $max_rate = intval($oneTmp['max_rate']);

        if ($min_rate == 0 && $max_rate > 0) {
            $where .= " and trip_price < '$max_rate'";
        } elseif ($min_rate > 0 && $max_rate == 0) {
            $where .= " and trip_price > '$min_rate'";
        } else {
            $where .= " and trip_price > '$min_rate' and trip_price < '$max_rate'";
        }
        $pUrl .= '&price_range_id=' . $price_range_id;
    }

    if ($pvalTable == "" || $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link_back);
    }
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

function default_move2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];

    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : 'country';
    $one = $clsClassTable->getOne($pvalTable);
    $order_no = $one['order_no'];

    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : 0;
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : 0;
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
    #
    $where = "1=1 and is_trash=0";
    $param_url = '&act=category_country';
    if (isset($cat_id) && intval($cat_id) != '') {
        $where .= " and cat_id=" . $cat_id;
        $param_url .= '&cat_id=' . $cat_id;
    }
    /* if(isset($country_id) && intval($country_id) != 0){
      $where.=" and country_id=".$country_id;
      $param_url.='&country_id='.$country_id;
      } */
    if (isset($city_id) && intval($city_id) != 0) {
        $where .= " and (city_id='$city_id' or list_city_id like '%|" . $city_id . "|%')";
        $param_url .= '&city_id=' . $city_id;
    }
    #
    if ($pvalTable == '' && $direct == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod);
    }
    #
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
    header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=PositionSuccess');
}

function default_trash()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    #
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=TrashSuccess');
    }
}

function default_trash2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $one = $clsClassTable->getOne($pvalTable);
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;

    if ($string = '' && $pvalTable == 0) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&cat_id=' . $cat_id . '&message=notPermission');
    }
    #
    $param_url = '&act=category_country';
    if (isset($city_id) && intval($city_id) != 0) {
        $param_url .= '&city_id=' . $city_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $param_url .= '&cat_id=' . $cat_id;
    }
    #
    if ($clsClassTable->updateOne($pvalTable, "is_trash='1'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=TrashSuccess');
    }
}

function default_restore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];

    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=RestoreSuccess');
    }
}

function default_restore2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $one = $clsClassTable->getOne($pvalTable);
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
    #
    if ($string = '' && $pvalTable == 0) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&country_id=' . $country_id . '&cat_id=' . $cat_id . '&message=notPermission');
    }
    $param_url = '&act=category_country';
    if (isset($city_id) && intval($city_id) != 0) {
        $param_url .= '&city_id=' . $city_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $param_url .= '&cat_id=' . $cat_id;
    }
    #
    if ($clsClassTable->updateOne($pvalTable, "is_trash='0'")) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=RestoreSuccess');
    }
}

function default_delete()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    $clsTourFaq = new TourFaq();
    $clsTourDestination = new TourDestination();
    $clsTourPriceGroup = new TourPriceGroup();
    $clsTourExtension = new TourExtension();
    $clsTourStartDate = new TourStartDate();
    $clsTourStore = new TourStore();
    $clsTourImage = new TourImage();
    $clsTourItinerary = new TourItinerary();
    $clsReviews = new Reviews();
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $string = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : "";
    $pvalTable = intval($core->decryptID($string));
    $parent_id = $clsClassTable->getOneField("parent_id", $pvalTable);

    $query_string = $_SERVER['QUERY_STRING'];
    $lst_query_string = explode('&', $query_string);
    $pUrl = '';
    for ($i = 0; $i < count($lst_query_string); $i++) {
        $tmp = explode('=', $lst_query_string[$i]);
        if ($tmp[0] != $pkeyTable && $tmp[0] != 'act')
            $pUrl .= ($i == 0) ? '?' . $lst_query_string[$i] : '&' . $lst_query_string[$i];
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=notPermission');
    }
    if ($clsClassTable->doDelete($pvalTable)) {
        $clsTourFaq->deleteByCond("tour_id='$pvalTable'");
        $clsTourDestination->deleteByCond("tour_id='$pvalTable'");
        $clsTourPriceGroup->deleteByCond("tour_id='$pvalTable'");
        $clsTourImage->deleteByCond("tour_id='$pvalTable'");
        $clsTourItinerary->deleteByCond("tour_id='$pvalTable'");
        $clsTourStartDate->deleteByCond("tour_id='$pvalTable'");
        $clsTourStore->deleteByCond("tour_id='$pvalTable'");
        $clsTourItinerary->deleteByCond("tour_id='$pvalTable'");
        $clsTourExtension->deleteByCond("tour_1_id='$pvalTable' or tour_2_id='$pvalTable'");
        $clsReviews->deleteByCond("table_id='$pvalTable' and type='tour'");
        $clsClassTable->deleteAllPackage($pvalTable);
        if ($parent_id) {
            header('location: ' . $clsClassTable->linkListTourPackage($parent_id) . '&message=DeleteSuccess');
            die;
        }
        header('location: ' . PCMS_URL . '/index.php' . $pUrl . '&message=DeleteSuccess');
    }
}

function default_delete2()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;

    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;

    $param_url = '&act=category_country';
    if (isset($city_id) && intval($city_id) != 0) {
        $param_url .= '&city_id=' . $city_id;
    }
    if (isset($cat_id) && intval($cat_id) != 0) {
        $param_url .= '&cat_id=' . $cat_id;
    }
    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=notPermission');
    }
    #
    if ($clsClassTable->doDelete($pvalTable)) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $param_url . '&message=DeleteSuccess');
    }
}

function default_deleteTourProperty()
{
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "TourProperty";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $pvalTable = isset($_GET[$pkeyTable]) ? intval($core->decryptID($_GET[$pkeyTable])) : "";
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $urlType = '';
    if ($type != '') {
        $urlType = "&type=" . $type;
    }

    if ($pvalTable == "") {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . "&act=property" . $urlType . '&message=notPermission');
    }
    #
    if ($clsClassTable->doDelete($pvalTable)) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . "&act=property" . $urlType . '&message=DeleteSuccess');
    }
}

function default_store()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id, $dbconn;
    $user_id = $core->_USER['user_id'];
    $pUrl = '';
    #
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    //$abc=$core->encryptID('DEPARTURE');
    //die($abc);
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;
    $assign_list["type_encrypt"] = $_GET['type'];

    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $assign_list["keyword"] = $keyword;

    if (empty($type)) {
        header('location: ' . PCMS_URL . '/?mod=tour_exhautive&message=notPermission');
    }

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        $link .= '&type=' . $core->encryptID($type);

        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Tìm kiếm...') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $cond = "is_trash=0 and is_online=1";

    if (!empty($type)) {
        $cond .= " and tour_id NOT IN (SELECT tour_id FROM " . DB_PREFIX . "tour_store WHERE is_trash=0 and _type='$type')";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if (!empty($keyword)) {
        $slug = $core->replaceSpace($keyword);
        $cond .= " and slug like '%" . $slug . "%'";
    }
    $orderBy = " order_no asc";


    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = ADMIN_PAGINATION;
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
    $listPageNumber = array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;

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
    //	print_r($cond." order by ".$orderBy.$limit);die();
    $listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit, $clsClassTable->pkey);
    $assign_list["listItem"] = $listItem;

    #
    $listSelected = $clsTourStore->getAll("is_trash=0 and _type = '$type' and tour_id IN (SELECT tour_id FROM default_tour WHERE parent_id = 0) order by order_no DESC");
    $assign_list["listSelected"] = $listSelected;

    //Action
    $action = Input::get('action', '');
    if ($action == 'Add') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : 0;

        if (empty($pvalTable)) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if (!$clsTourStore->checkExist($pvalTable, $type)) {
            $tour_store_id = $clsTourStore->getMaxId();
            $f = "tour_store_id,tour_id,_type,order_no";
            $v = "'$tour_store_id','$pvalTable','$type','{$clsTourStore->getMaxOrderNo()}'";
            //print_r($f.'</br>'.$v);die();
            if ($clsTourStore->insertOne($f, $v)) {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=insertSuccess');
            }
        }
    }
    //print_r(xxxx); die();
}

function default_store_trips()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    $pUrl = '';
    #
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $assign_list["keyword"] = $keyword;

    if ($type == '') {
        header('location: ' . PCMS_URL . '/?mod=tour&message=notPermission');
    }
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        $link .= '&type=' . $core->encryptID($type);

        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Tìm kiếm...') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    #
    $cond = "is_trash=0 and is_online=1";
    /*if($type!='DEPARTURE' && $type!='TOPDEALSTRIP' && $type!='TOPTRIPS'){
		$cond .= " and is_day_trip=0";
	}
	if($type=='TOPDEALSTRIP' || $type=='TOPTRIPS'){
		$cond .= " and is_day_trip=1";
	}*/

    if ($type != '') {
        $cond .= " and tour_id NOT IN (SELECT tour_id FROM " . DB_PREFIX . "tour_store WHERE is_trash=0 and _type='$type')";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if ($keyword != '') {
        $slug = $core->replaceSpace($keyword);
        $cond .= " and slug like '%" . $slug . "%'";
    }
    $orderBy = " order_no asc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = ADMIN_PAGINATION;
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
    $listPageNumber = array();
    for ($i = 1; $i <= $totalPage; $i++) {
        $listPageNumber[] = $i;
    }
    $stt = ($currentPage - 1) * $recordPerPage;
    $assign_list['stt'] = $stt;

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

    $listItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit);
    //	print_r($listItem);die();
    $assign_list["listItem"] = $listItem;


    #
    $listSelected = $clsTourStore->getAll("is_trash=0 and _type = '$type' order by order_no asc");
    //	print_r($listSelected);die();
    $assign_list["listSelected"] = $listSelected;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Add') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if (!$clsTourStore->checkExist($pvalTable, $type)) {
            $listTable = $clsTourStore->getAll("1=1 and _type='$type'", $clsTourStore->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsTourStore->updateOne($listTable[$i][$clsTourStore->pkey], "order_no='" . $order_no . "'");
            }
            $max_order_no = $clsTourStore->getMaxOrder();
            $f = "tour_id,_type,order_no";
            $v = "'$pvalTable','$type','1'";
            if ($clsTourStore->insertOne($f, $v)) {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=insertSuccess');
            }
        }
    }
    //print_r(xxxx); die();
}

function default_ajSaveStoreForTour()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $_LANG_ID;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourStore = new TourStore();
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $list_tour_id = isset($_POST['list_tour_id']) ? $_POST['list_tour_id'] : '';
    $list_tour_id = rtrim($list_tour_id, '|');

    if ($list_tour_id != '') {
        $tmp = explode('|', $list_tour_id);
        if (!empty($tmp)) {
            foreach ($tmp as $i) {
                if (!$clsTourStore->checkExist($i, $type)) {
                    #
                    $max_id = $clsTourStore->getMaxID();
                    $max_order = $clsTourStore->getMaxOrder();
                    $f = "$clsTourStore->pkey,tour_id,_type,order_no";
                    $v = "'$max_id','$i','$type','$max_order'";
                    $clsTourStore->insertOne($f, $v);
                }
            }
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    } else {
        echo '_ERROR';
        die();
    }
}

function default_ajDeleteTourStore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsClassTable = new TourStore();
    $clsTour = new Tour();
    $pvalTable = isset($_POST['tour_store_id']) ? $_POST['tour_store_id'] : 0;
    $one = $clsClassTable->getOne($pvalTable, "_type, tour_id");
    $type = $one["_type"];
    $clsClassTable->deleteOne($pvalTable);
    if ($type == "DEPARTURE") {
        $listTour = $clsTour->getAll("parent_id = {$one["tour_id"]}", $clsTour->pkey);
        if (!empty($listTour)) {
            $tour_ids = array_column($listTour, 'tour_id');
            $clsClassTable->deleteByCond("_type='$type' and tour_id IN (" . implode(',', $tour_ids) . ")");
        }
    }
    echo (1);
    die();
}

function default_ajDeleteTourProperty()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    #
    $clsClassTable = new TourProperty();
    $pvalTable = isset($_POST['tour_property_id']) ? $_POST['tour_property_id'] : 0;
    $clsClassTable->deleteOne($pvalTable);
    echo (1);
    die();
}

function default_ajUpdPosSortTourStore()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO, $package_id;
    global $clsConfiguration;
    #
    $clsTourStore = new TourStore();
    $type = $_POST['type'];
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourStore->updateByCond("tour_id='$val' and _type='$type'", "order_no='" . $key . "'");
    }
}

function default_liststore()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    $clsUser = new User();
    $pUrl = '';
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsTourCat = new TourCategory();
    $assign_list["clsTourCat"] = $clsTourCat;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsPriceRange = new PriceRange();
    $assign_list["clsPriceRange"] = $clsPriceRange;
    #
    $SiteHasCategoryGroup_Tours = $clsConfiguration->getValue('SiteHasCategoryGroup_Tours');
    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');
    $tour_group_id = 0;
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    }
    $assign_list["tour_group_id"] = $tour_group_id;
    #
    $cat_id = 0;
    $SiteHasCat_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'category ', 'default');
    if ($SiteHasCat_Tours) {
        $clsTourCat = new TourCategory();
        $assign_list["clsTourCat"] = $clsTourCat;
        $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    }
    $assign_list["cat_id"] = $cat_id;
    #
    $price_range_id = 0;
    if ($clsISO->getCheckActiveModulePackage($package_id, $mod, 'price_range', 'default')) {
        $clsPriceRange = new PriceRange();
        $assign_list["clsPriceRange"] = $clsPriceRange;
        $price_range_id = isset($_GET['price_range_id']) ? intval($_GET['price_range_id']) : 0;
    }
    $assign_list["price_range_id"] = $price_range_id;
    #
    $type = isset($_GET['type']) ? $core->decryptID($_GET['type']) : '';
    $assign_list["type"] = $type;
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
    $assign_list["cat_id"] = $cat_id;
    $depart_point_id = isset($_GET['depart_point_id']) ? $_GET['depart_point_id'] : '';
    $assign_list["depart_point_id"] = $depart_point_id;
    $tour_type_id = isset($_GET['tour_type_id']) ? intval($_GET['tour_type_id']) : 0;
    $assign_list["tour_type_id"] = $tour_type_id;
    $number_day = isset($_GET['number_day']) ? $_GET['number_day'] : '';
    $assign_list["number_day"] = $number_day;
    $price_range_id = isset($_GET['price_range_id']) ? $_GET['price_range_id'] : '';
    $assign_list["price_range_id"] = $price_range_id;

    if ($type == '') {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
    }
    #
    /**/
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours) {
            if (isset($_POST['tour_group_id']) && intval($_POST['tour_group_id']) != 0) {
                $link .= '&tour_group_id=' . intval($_POST['tour_group_id']);
            }
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) != 0) {
            $link .= '&cat_id=' . $_POST['cat_id'];
        }
        if (isset($_POST['tour_type_id']) && intval($_POST['tour_type_id']) != 0) {
            $link .= '&tour_type_id=' . $_POST['tour_type_id'];
        }
        if (isset($_POST['departure_point_id']) && intval($_POST['departure_point_id']) != 0) {
            $link .= '&departure_point_id=' . $_POST['departure_point_id'];
        }
        if (isset($_POST['number_day']) && intval($_POST['number_day']) != 0) {
            $link .= '&number_day=' . $_POST['number_day'];
        }
        if (isset($_POST['price_range_id']) && intval($_POST['price_range_id']) != 0) {
            $link .= '&price_range_id=' . $_POST['price_range_id'];
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'Type trip code or tour name') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&type=' . $core->encryptID($type) . $link);
    }
    #
    $classTable = "TourStore";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $pUrl = '';
    $cond = "1=1 and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE is_trash=0 and is_online=1)";
    if (isset($type) && !empty($type)) {
        $cond .= " and _type = '$type'";
        $pUrl .= '&type=' . $core->encryptID($type);
    }
    if ($tour_group_id > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE tour_group_id='$tour_group_id')";
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    if (intval($tour_type_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE tour_type_id='$tour_type_id')";
        $pUrl .= '&tour_type_id=' . $tour_type_id;
    }
    if (intval($cat_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE cat_id = '$cat_id' or list_cat_id like '%|$cat_id|%'')";
        $pUrl .= '&cat_id=' . $cat_id;
    }
    if (intval($departure_point_id) > 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE departure_point_id='$departure_point_id')";
        $pUrl .= '&departure_point_id=' . $departure_point_id;
    }
    if (isset($number_day) && intval($number_day) != 0) {
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE number_day='$number_day')";
        $pUrl .= '&number_day=' . $number_day;
    }
    if ($price_range_id != '' && $price_range_id != '0' && $price_range_id != 'All') {
        $onePriceRange = $clsPriceRange->getOne($price_range_id);
        $min_rate = $onePriceRange['min_rate'];
        $max_rate = $onePriceRange['max_rate'];
        #
        if ($min_rate == 0 && $max_rate > 0) {
            $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_price < '$max_rate')";
        } elseif ($min_rate > 0 && $max_rate > 0) {
            $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_price > '$min_rate' and trip_price < '$max_rate')";
        } else {
            $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_price > '$min_rate')";
        }
        $pUrl .= '&price_range_id=' . $price_range_id;
    }
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and tour_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour WHERE trip_code like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' or title like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }

    $orderBy = " order by order_no asc";
    $allItem = $clsClassTable->getAll($cond . $orderBy);
    $assign_list["allItem"] = $allItem;
    $assign_list["pUrl"] = $pUrl;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Delete') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=PositionSuccess');
    }
    #----
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'UpdateTourTypeIntro') {
            foreach ($_POST as $key => $val) {
                $tmp = explode('-', $key);
                if ($tmp[0] == 'iso') {
                    $clsConfiguration->updateValue($tmp[1], $val);
                }
            }
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=UpdateSuccess');
        }
    }
}

function default_ajUpdPosSortHotTour()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO, $package_id;
    global $clsConfiguration;
    #
    $clsTourStore = new TourStore();
    $order = $_POST['order'];
    $type = $_POST['type'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        /*$key = (($currentPage-1)*$recordPerPage + $key + 1);*/
        $key = $key + 1;
        $clsTourStore->updateByCond("tour_id='$val' and _type='$type'", "order_no='" . $key . "'");
    }
}

/* ========= TOUR CATEGORY MOD MANAGE ============= */

function default_category()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    $assign_list["msg"] = isset($_GET['message']) ? $_GET['message'] : '';
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #
    $type_list = Input::get('type_list', '');
    $assign_list["type_list"] = $type_list;
    $clsCategoryCountry = new Category_Country;
    $classTable = "TourCategory";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    $assign_list["clsTour"] = new Tour();
    $clsUser = new User();
    $assign_list['clsUser'] = $clsUser;
    $assign_list["clsCategoryCountry"] = $clsCategoryCountry;
    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');
    $assign_list["SiteHasGroup_Tours"] = $SiteHasGroup_Tours;

    $SiteHasSubCat_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'sub_cat', 'customize');
    $assign_list["SiteHasSubCat_Tours"] = $SiteHasSubCat_Tours;
    #
    if ($SiteHasGroup_Tours) {
        $clsTourGroup = new TourGroup();
        $assign_list["clsTourGroup"] = $clsTourGroup;
        $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
        $assign_list["tour_group_id"] = $tour_group_id;
    }
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($SiteHasGroup_Tours && $_POST['tour_group_id'] != '') {
            $link .= '&tour_group_id=' . $_POST['tour_group_id'];
        }
        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
    }
    #
    $cond = "1=1 and parent_id=0";
    $pUrl = '';
    if ($SiteHasGroup_Tours) {
        if ($tour_group_id > 0) {
            $cond .= " and tour_group_id='$tour_group_id'";
        }
        $pUrl .= '&tour_group_id=' . $tour_group_id;
    }
    #Filter By Keyword
    $keyword = Input::get('keyword', '');
    if (!empty($keyword)) {
        $cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    $orderBy = " order by order_no asc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = Input::get('recordperpage', ADMIN_PAGINATION);
    $currentPage = Input::get('page', 1);
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $totalRecord = $clsClassTable->getAll($cond, $clsClassTable->pkey);
    $totalRecord = $totalRecord ? count($totalRecord) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    #
    $LISTALL = $clsClassTable->getAll($cond . $orderBy . $limit);

    if (is_array($LISTALL) && count($LISTALL) > 0) {
        $allItem = []; // khởi tạo mảng

        foreach ($LISTALL as $i => $item) {
         
            $allItem[] = [
                'idx' => ($i + 1),
                'parent_id' => $item['parent_id'],
                'tour_group_id' => $item['tour_group_id'],
                'tourcat_id' => $item[$clsClassTable->pkey],
                'title' => $clsClassTable->getTitle($item[$clsClassTable->pkey]),
                'is_trash' => $item['is_trash'] ?? 0,
                'is_online' => $item['is_online'] ?? 0, // sửa từ $LISTALL[$k] thành $item
                'user_id' => $item['user_id'] ?? 0,
                'image' => $item['image'] ?? 0,
            ];

            if ($SiteHasSubCat_Tours) {
                $LISTCHILD = $clsClassTable->getChild($item[$clsClassTable->pkey], 0, false);

                if (is_array($LISTCHILD) && count($LISTCHILD) > 0) {
                    foreach ($LISTCHILD as $k => $child) {
                        $allItem[] = [
                            'idx' => ($i + 1) . '.' . ($k + 1),
                            'parent_id' => $child['parent_id'],
                            'tour_group_id' => $child['tour_group_id'],
                            'tourcat_id' => $child[$clsClassTable->pkey],
                            'title' => '__' . $clsClassTable->getTitle($child[$clsClassTable->pkey]),
                            'is_trash' => $child['is_trash'] ?? 0,
                            'is_online' => $child['is_online'] ?? 0,
                            'user_id' => $child['user_id'] ?? 0,
                        ];
                    }
                    unset($LISTCHILD);
                }
            }
        }
        unset($LISTALL);
    }

    $assign_list["allItem"] = $allItem;
    unset($allItem);
    $assign_list["pUrl"] = $pUrl;
    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['tourcat_id']) ? ($_GET['tourcat_id']) : '';
        $tourcat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($SiteHasGroup_Tours) {
            $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
            $pUrl .= '&tour_group_id=' . $tour_group_id;
        }
        if ($string == '' && $tourcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourcat_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['tourcat_id']) ? ($_GET['tourcat_id']) : '';
        $tourcat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($SiteHasGroup_Tours) {
            $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
            $pUrl .= '&tour_group_id=' . $tour_group_id;
        }
        if ($string == '' && $tourcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourcat_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['tourcat_id']) ? ($_GET['tourcat_id']) : '';
        $tourcat_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($SiteHasGroup_Tours) {
            $tour_group_id = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
            $pUrl .= '&tour_group_id=' . $tour_group_id;
        }
        if ($string == '' && $tourcat_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($tourcat_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
            if ($tmp[0] == 'date') {
                $clsConfiguration->updateValue($tmp[1], strtotime($val));
            }
        }
        $extUrl = '';
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=' . $act . '&message=updateSuccess' . $extUrl);
    }
}

function default_ajUpdPosSortTourCategory()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO, $package_id;
    global $clsConfiguration;
    #
    $clsTourCategory = new TourCategory();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourCategory->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_category_country()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];

    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }

    $pUrl = '';
    #-- Get Type List
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;

    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;


    $country_id = isset($_GET['country_id']) ? intval($_GET['country_id']) : 0;
    $assign_list["country_id"] = $country_id;
    $city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;
    $assign_list["city_id"] = $city_id;
    $cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
    $assign_list["cat_id"] = $cat_id;

    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;

    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $assign_list["pkeyTable"] = $pkeyTable;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=category_country';
        if (isset($_POST['country_id']) && intval($_POST['country_id']) > 0) {
            $link .= '&country_id=' . $_POST['country_id'];
        }
        if (isset($_POST['city_id']) && intval($_POST['city_id']) > 0) {
            $link .= '&city_id=' . $_POST['city_id'];
        }
        if (isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0) {
            $link .= '&cat_id=' . $_POST['cat_id'];
        }

        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    /* List all item */
    $cond = "1=1";
    if (intval($country_id) > 0) {
        $cond .= " and country_id='$country_id'";
        $pUrl .= '&country_id=' . $country_id;
    }

    if (intval($cat_id) > 0) {
        $cond .= " and (cat_id='$cat_id' or list_cat_id like '%" . $cat_id . "%')";
        $pUrl .= '&cat_id=' . $cat_id;
    }

    if (intval($city_id) > 0) {
        $cond .= " and (city_id='$city_id')";
        $pUrl .= '&city_id=' . $city_id;
    }

    #Filter By Keyword
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = $core->replaceSpace($_GET['keyword']);
        $cond .= " and slug like '%" . $keyword . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $assign_list["pUrl"] = $pUrl;
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no DESC";


    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : ADMIN_PAGINATION;
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
    $assign_list["allItem"] = $allItem;

    $lstCityGuide = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by title asc", $clsCity->pkey);
    $tmp = array();
    if (!empty($lstCityGuide)) {
        foreach ($lstCityGuide as $item) {
            if ($clsClassTable->countGuideGlobal(0, $item[$clsCity->pkey], $country_id) > 0) {
                $tmp[] = $item[$clsCity->pkey];
            }
        }
    }
    $assign_list["lstCityGuide"] = $tmp;
}

function default_edit_itinerary()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $package_id;
    $clsProperty = new Property();
    $assign_list["clsProperty"] = $clsProperty;
    $check_in = date('m/d/Y', strtotime("+ 1 days"));
    $assign_list['check_in'] = $check_in;
    $check_in_math = strtotime($check_in);
    $assign_list['check_in_math'] = $check_in_math;

    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $Current_Now = time();
    $lstMonth = array();
    for ($i = 1; $i <= 12; $i++) {
        $lstMonth[] = ($i < 10) ? '0' . $i : $i;
    }
    $assign_list["lstMonth"] = $lstMonth;
    #
    $clsCruiseService = new CruiseService();
    $assign_list["clsCruiseService"] = $clsCruiseService;
    $clsCruiseCabin = new CruiseCabin();
    $assign_list["clsCruiseCabin"] = $clsCruiseCabin;
    $lstService = $clsCruiseService->getAll("is_trash=0 and is_online=1 order by order_no desc");
    $assign_list["lstService"] = $lstService;
    unset($lstService);
    #
    $clsTour = new Tour();
    $assign_list["clsTour"] = $clsTour;
    $clsTransport = new Transport();
    $assign_list["clsTransport"] = $clsTransport;
    $tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;

    $oneTour = $clsTour->getOne($tour_id);
    $assign_list["tour_id"] = $tour_id;
    $assign_list["oneTour"] = $oneTour;
    $return = isset($_GET['return']) ? $_GET['return'] : '';

    if ($tour_id == 0) {
        header('location: ' . PCMS_URL);
        exit();
    }
    $pUrl = '';
    $pUrl .= '&tour_id=' . $tour_id;
    #
    $classTable = "TourItinerary";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    if ($string != '' && $pvalTable == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
    }
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    #

    $listCabin = $clsCruiseCabin->getAll("is_trash=0 and is_online=1 and tour_id='$tour_id' order by order_no asc");
    $assign_list['listCabin'] = $listCabin;
    unset($listCabin);


    $lstItinerary = $clsClassTable->getAll("tour_id='$tour_id'");
    $assign_list["lstItinerary"] = $lstItinerary;
    unset($lstItinerary);
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $tour_itinerary_id = $_POST['tour_itinerary_id'];
        if (intval($tour_itinerary_id) > 0) {
            header('Location:/admin/?mod=' . $mod . '&act=' . $act . '&tour_itinerary_id=' . $core->encryptID($tour_itinerary_id) . $pUrl);
            exit();
        } else {
            header('Location:/admin/?mod=' . $mod . '&act=' . $act . $pUrl);
            exit();
        }
    }
    #
    require_once DIR_COMMON . "/clsForm.php";
    $clsForm = new Form();
    $clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
    $assign_list["clsForm"] = $clsForm;
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 5, 1, "style='width:100%'");
    #
    #- Init Price
    /*if(intval($pvalTable) > 0){
		$clsClassTable->initCruiseTable($pvalTable);
	}*/
    #- End Init Price
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
            #
            $title = $_POST['title'];
            $title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
            $set .= ",title='" . $title . "'";
            $set .= ",slug='" . $core->replaceSpace($_POST['title']) . "'";
            $set .= ",user_id_update='$user_id',upd_date='" . time() . "'";
            $set .= ",meals='" . $clsISO->makeSlashListFromArrayComma($_POST['meal']) . "'";
            $set .= ",transport='" . $clsISO->makeSlashListFromArrayComma($_POST['transport']) . "'";
            $set .= ",is_show_image='" . $_POST['is_show_image'] . "'";


            #--Special Field: image
            $image = '';
            if (_isoman_use && $image == '') {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            } else {
                $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            }
            if ($image != '' && $image != '0') {
                $set .= ",image='" . addslashes($image) . "'";
            }
            //print_r($pvalTable.'xxxxx'.$set); die();
            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_itinerary&tour_itinerary_id=' . $core->encryptID($pvalTable) . '&tour_id=' . $tour_id . $pUrl . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/tour/insert/' . $tour_id . '/itinerary/itinerary&message=updateSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_itinerary&tour_itinerary_id=' . $core->encryptID($pvalTable) . '&tour_id=' . $tour_id . $pUrl . '&message=updateFailed#isotab2');
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

            #
            $max_ID = $clsClassTable->getMaxID();
            $field .= ",slug,user_id,user_id_update,reg_date,upd_date,tour_id,$clsClassTable->pkey,order_no";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','$user_id','$user_id','" . time() . "','" . time() . "','$tour_id','$max_ID','1'";
            $field .= ",trip_price,is_show_price,high_season_month";
            $value .= ",'" . $clsISO->processSmartNumber($_POST['trip_price']) . "','" . $_POST['is_show_price'] . "','" . $clsISO->makeSlashListFromArray($_POST['season_month']) . "'";

            #--Special Field: image
            $image = '';
            if (_isoman_use && $image == '') {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            } else {
                $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            }
            if ($image != '' && $image != '0') {
                $field .= ",image";
                $value .= ",'" . addslashes($image) . "'";
            }

            $listTable = $clsClassTable->getAll("1=1 and tour_id='$tour_id'", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_itinerary&tour_itinerary_id=' . $core->encryptID($max_ID) . '&tour_id=' . $tour_id . '&message=InsertSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($tour_id) . '&message=insertSuccess#isotab2');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&tour_id=' . $core->encryptID($tour_id) . 'message=insertFailed#isotab2');
            }
        }
    }
}

function default_edit_categorycountry()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration, $clsISO, $package_id;
    global $core, $clsModule, $clsButtonNav, $oneSetting;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Category_Country";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    #

    $clsRegion = new Region();
    $assign_list['clsRegion'] = $clsRegion;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    $clsCity = new City();
    $assign_list["clsCity"] = $clsCity;
    $clsTourCategory = new TourCategory();
    $assign_list["clsTourCategory"] = $clsTourCategory;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $assign_list['pkeyTable'] = $pkeyTable;

    $oneTable = $clsClassTable->getOne($pvalTable);
    $assign_list["oneTable"] = $oneTable;

    $country_id = $oneTable['county_id'];

    $cat_id = $oneTable['cat_id'];
    /*
      if($clsConfiguration->getValue('SiteModActive_country')) {
      if(isset($country_id) && intval($country_id)==0){
      header('location: '.PCMS_URL.'/?mod=country&message=notPermission');
      exit();
      }
      } */

    if ($clsISO->getCheckActiveModulePackage($package_id, 'city', 'default', 'default')) {
        $lstCity = $clsCity->getAll("is_trash=0 and is_online=1 and country_id = '$country_id' order by order_no desc");
        $assign_list["lstCity"] = $lstCity;
        unset($lstCity);
    }
    #
    if (isset($pvalTable) && $pvalTable > 0) {
        $country_id = $oneTable['country_id'];
        $city_id = $oneTable['city_id'];
        $cat_id = $oneTable['cat_id'];
    }
    $assign_list["country_id"] = $country_id;
    $assign_list["cat_id"] = $cat_id;
    $assign_list["city_id"] = $city_id;
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
    $clsForm->addInputTextArea("full", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 20, 1, "style='width:100%'");
    $clsForm->addInputTextArea("simple150", 'intro_banner', "", 'intro_banner', 255, 25, 20, 1, "style='width:100%'");

    if ($string != '' && $pvalTable == 0) {
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=notPermission');
    }
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
            #
            $set .= ",slug='" . $core->replaceSpace($_POST["iso-title"]) . "'";
            $set .= ",upd_date='" . time() . "',user_id_update='" . addslashes($core->_SESS->user_id) . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            }
            if ($image != '' && $image != '0') {
                $set .= ",image='" . addslashes($image) . "'";
            }
            $image_banner = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
            if (_isoman_use) {
                $image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
            }
            if ($image_banner != '' && $image_banner != '0') {
                $set .= ",image_banner='" . addslashes($image_banner) . "'";
            }

            #
            $pUrl .= '&act=category_country';
            if (isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0) {
                $set .= ",cat_id = '" . $_POST['cat_id'] . "'";
                $pUrl .= "&cat_id=" . $cat_id;
            }
            //print_r($pvalTable.'<br/>'.$set); die();
            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['config_value_title'] != '') {
                    if ($meta_id == '') {
                        $clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
                        $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
                        $meta_id = $allMeta[0]['meta_id'];
                    }
                    $clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
                }
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_categorycountry&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=UpdateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=category_country' . '&message=UpdateSuccess');
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
            #
            $listTable = $clsClassTable->getAll("1=1", $clsClassTable->pkey . ",order_no");
            for ($i = 0; $i <= count($listTable); $i++) {
                $order_no = $listTable[$i]['order_no'] + 1;
                $clsClassTable->updateOne($listTable[$i][$clsClassTable->pkey], "order_no='" . $order_no . "'");
            }
            $max_id = $clsClassTable->getMaxID();
            $field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $max_id . "','1'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = isset($_POST['isoman_url_image']) ? $_POST['isoman_url_image'] : '';
            }
            if ($image != '' && $image != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
            }

            $image_banner = isset($_POST['image_banner_src']) ? $_POST['image_banner_src'] : '';
            if (_isoman_use) {
                $image_banner = isset($_POST['isoman_url_image_banner']) ? $_POST['isoman_url_image_banner'] : '';
            }
            if ($image_banner != '' && $image_banner != '0') {
                $field .= ',image_banner';
                $value .= ",'" . addslashes($image_banner) . "'";
            }

            #
            $pUrl .= '&act=category_country';
            if (isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0) {
                $field .= ",cat_id";
                $value .= ",'" . $_POST['cat_id'] . "'";
                $pUrl .= "&cat_id=" . $_POST['cat_id'];
            }
            //print_r($field.'<br />'.$value); die();
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit_categorycountry&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=insertSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=category_country' . '&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
            }
        }
    }
}

function default_ajUpdPosSortTravelStylebyCountry()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    #
    $clsCategoryCountry = new Category_Country();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsCategoryCountry->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_edit_category()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "TourCategory";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $assign_list["tour_group_id"] = isset($_GET['tour_group_id']) ? intval($_GET['tour_group_id']) : 0;
    #
    $string = isset($_GET[$pkeyTable]) ? ($_GET[$pkeyTable]) : '';
    $pvalTable = intval($core->decryptID($string));
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

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
    $clsForm->addInputTextArea("", 'intro', "", 'intro', 255, 25, 5, 1, "style='width:100%'");
    $clsForm->addInputTextArea("full", 'content', "", 'content', 255, 25, 20, 1, "style='width:100%'");
    #
    if ($string != '' && $pvalTable == 0) {
        header('location:' . PCMS_URL . '/index.php?&mod=' . $mod . '&message=notPermission');
    }
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
            $set .= ",slug='" . $core->replaceSpace($_POST['iso-title']) . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = $_POST['isoman_url_image'];
            }
            if ($image != '' && $image != '0') {
                $set .= ",image='" . addslashes($image) . "'";
            }
            #
            $pUrl = '';
            if ($clsISO->getCheckActiveModulePackage($package_id, 'news', 'category', 'default')) {
                $newscat_id = $_POST['iso-newscat_id'];
                $list_cat_id = $clsNewsCategory->getListParent($newscat_id);
                $set .= ",list_cat_id='" . addslashes($list_cat_id) . "'";
                $pUrl .= '&newscat_id=' . $newscat_id;
            }
            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['config_value_title'] != '') {
                    if ($meta_id == '') {
                        $clsMeta->insertOne("config_link,reg_date,meta_id", "'" . $linkMeta . "','" . time() . "','" . $clsMeta->getMaxId() . "'");
                        $allMeta = $clsMeta->getAll("config_link='" . $linkMeta . "'");
                        $meta_id = $allMeta[0]['meta_id'];
                    }
                    $clsMeta->updateOne($meta_id, "config_value_intro='" . addslashes($_POST['config_value_intro']) . "',config_value_keyword='" . addslashes($_POST['config_value_keyword']) . "',config_value_title='" . addslashes($_POST['config_value_title']) . "',upd_date='" . time() . "',meta_index='" . addslashes($_POST['meta_index']) . "',meta_follow='" . addslashes($_POST['meta_follow']) . "'");
                }
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
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
            #
            $news_id = $clsClassTable->getMaxId();
            $field .= ",user_id,user_id_update,reg_date,upd_date,slug,$clsClassTable->pkey,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . $core->replaceSpace($_POST['iso-title']) . "','" . $news_id . "','" . $clsClassTable->getMaxOrderNo() . "'";

            #--Special Field: image
            $image = isset($_POST['image_src']) ? $_POST['image_src'] : '';
            if (_isoman_use) {
                $image = $_POST['isoman_url_image'];
            }
            if ($image != '' && $image != '0') {
                $field .= ',image';
                $value .= ",'" . addslashes($image) . "'";
            }
            #
            $pUrl = '';
            if ($clsISO->getCheckActiveModulePackage($package_id, 'news', 'category', 'default')) {
                $newscat_id = $_POST['iso-newscat_id'];
                $list_cat_id = $clsNewsCategory->getListParent($newscat_id);
                $field .= ',list_cat_id';
                $value .= ",'" . addslashes($list_cat_id) . "'";
                $pUrl .= '&newscat_id=' . $newscat_id;
            }
            #
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&news_id=' . $core->encryptID($max_id) . '&message=insertSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
            }
        }
    }
}

function default_SiteTourCategory()

{

    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;

    global $clsConfiguration, $user_id, $clsISO, $package_id;



    $user_id = $core->_USER['user_id'];

    #

    $SiteHasCat_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'category', 'default');



    if (!$SiteHasCat_Tours) {

        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');

        exit();

    }

    #

	    $SiteHasGroup_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'group', 'default');

	    $assign_list["SiteHasGroup_Tours"] = $SiteHasGroup_Tours;

	    $tour_group_id = isset($_POST['tour_group_id'])
	        ? intval($_POST['tour_group_id'])
	        : 0;



    if ($SiteHasGroup_Tours) {

        $clsTourGroup = new TourGroup();

	    }



    $SiteHasSubCat_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'sub_cat', 'customize');

    $assign_list["SiteHasSubCat_Tours"] = $SiteHasSubCat_Tours;



    $clsTourCategory = new TourCategory();

    /*
     * Một số site dùng schema TourCategory cũ và không có các cột mở rộng
     * như icon, video_teaser, intro_banner... Chỉ ghi những cột thật sự tồn
     * tại để tránh toàn bộ INSERT/UPDATE thất bại với response _ERROR.
     */
    $tableColumnMap = array();
    $columnRows = $dbconn->GetAll(
        'SHOW COLUMNS FROM `' . $clsTourCategory->tbl . '`'
    );

    if (is_array($columnRows)) {
        foreach ($columnRows as $columnRow) {
            $columnName = '';

            if (isset($columnRow['Field'])) {
                $columnName = $columnRow['Field'];
            } elseif (isset($columnRow['field'])) {
                $columnName = $columnRow['field'];
            } elseif (is_array($columnRow) && !empty($columnRow)) {
                $columnName = reset($columnRow);
            }

            if ($columnName !== '') {
                $tableColumnMap[strtolower($columnName)] = true;
            }
        }
    }

    $hasTableColumn = function ($columnName) use ($tableColumnMap) {
        /* Nếu không đọc được schema thì giữ cách xử lý cũ. */
        return empty($tableColumnMap)
            || isset($tableColumnMap[strtolower($columnName)]);
    };

    $tourcat_id = isset($_POST['tourcat_id'])
        ? (int) $_POST['tourcat_id']
        : 0;

    if ($tourcat_id > 0) {

        $tour_group_id = $clsTourCategory->getOneField('tour_group_id', $tourcat_id);

    }

    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';

    #

	    if ($tp == 'F') {

	        $getOptionalField = function ($fieldName) use (
	            $hasTableColumn,
	            $clsTourCategory,
	            $tourcat_id
	        ) {
	            if (!$hasTableColumn($fieldName)) {
	                return '';
	            }

	            $fieldValue = $clsTourCategory->getOneField(
	                $fieldName,
	                $tourcat_id
	            );

	            return is_scalar($fieldValue)
	                ? (string) $fieldValue
	                : '';
	        };

	        $iconValue = $getOptionalField('icon');
	        $videoTeaserValue = $getOptionalField('video_teaser');
	        $imageBannerValue = $getOptionalField('image_banner');
	        $linkBannerValue = $getOptionalField('link_banner');
	        $introBannerValue = $getOptionalField('intro_banner');

	        $iconHtml = htmlspecialchars(
	            $iconValue,
	            ENT_QUOTES,
	            'UTF-8'
	        );

	        $html = '

		<div class="headPop">

			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>

			<h3>' . ($tourcat_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('tourcategory') . '</h3>

		</div>';

        $html .= '

		<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">

			<input type="hidden" name="tour_group_id" value="' . (int) $tour_group_id . '">

			<div class="wrap">

				<div class="fl" style="width:100%">

					<div class="row-span">

						<div class="fieldlabel" style="text-align:center"><strong>' . $core->get_Lang('Title') . '</strong> <span class="color_r">*</span></div>

						<div class="fieldarea">

							<input style="border:2px solid #ccc; padding:6px 10px;" autocomplete="off" class="text_32 full-width border_aaa bold required fontLarge" name="title" value="' . $clsTourCategory->getTitle($tourcat_id) . '" type="text" />

						</div>

					</div>';

        if ($SiteHasSubCat_Tours) {

            $html .= '<div class="row-span">

						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('selectcategory') . '</strong> <span class="color_r">*</span></div>

						<div class="fieldarea">

							<select class="slb" name="parent_id" id="slb_TourCategory" style="width:200px;">

								' . $clsTourCategory->makeSelectboxOption($tour_group_id, $clsTourCategory->getOneField('parent_id', $tourcat_id), 0, 0, 1, $tourcat_id) . '

							</select>

						</div>

					</div>';

        }




        $html .= '<div class="row-span">

						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Short text') . '</strong></div>

						<div class="fieldarea">

							<textarea  id="textarea_tour_intro_editor_' . time() . '" class="textarea_tour_intro_editor" name="intro" style="width:100%">' . $clsTourCategory->getIntro($tourcat_id) . '</textarea>

						</div>

					</div>

					<div class="row-span">

						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Image') . '</strong></div>

						<div class="fieldarea">

							<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTourCategory->getOneField('image', $tourcat_id) . '" />

							<input type="hidden" id="isoman_hidden_image" value="' . $clsTourCategory->getOneField('image', $tourcat_id) . '">

							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTourCategory->getOneField('image', $tourcat_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTourCategory->getOneField('image', $tourcat_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>

							</div>

						</div>';

	        $html .= '<div class="row-span">

							<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Icon') . '</strong></div>

							<div class="fieldarea">

								<img class="isoman_img_pop" id="isoman_show_icon" src="' . $iconHtml . '" />

								<input type="hidden" id="isoman_hidden_icon" value="' . $iconHtml . '">

								<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_icon" name="icon" value="' . $iconHtml . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="icon" isoman_val="' . $iconHtml . '" isoman_name="icon"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>

							</div>

						</div>';

	        if ($clsConfiguration->getValue('Video_Teaser_TourCategory')) {

            $html .= '<div class="row-span">

							<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Video Teaser') . '</strong></div>

							<div class="fieldarea">

								<img class="isoman_img_pop" id="isoman_show_video_teaser" src="' . $videoTeaserValue . '" />

								<input type="hidden" id="isoman_hidden_video_teaser" value="' . $videoTeaserValue . '">

								<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_video_teaser" name="video_teaser" value="' . $videoTeaserValue . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="video_teaser" isoman_val="' . $videoTeaserValue . '" isoman_name="video_teaser"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>

							</div>

						</div>';

        }

        $html .= '<div class="row-span" style="display:none">

						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner') . ' <span class="small">(WxH=1920x480)</span></strong></div>

						<div class="fieldarea">

							<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $imageBannerValue . '" />

							<input type="hidden" id="isoman_hidden_image_banner" value="' . $imageBannerValue . '">

							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $imageBannerValue . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $imageBannerValue . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>

						</div>

					</div>';



        $html .= '<div class="row-span" style="display:none">

						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner Link') . '</strong></div>

						<div class="fieldarea">

							<input class="text_32 full-width border_aaa fontLarge" name="iso-link_banner" value="' . $linkBannerValue . '" type="text" />

						</div>

					</div>

					<!--<div class="row-span">

						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner Content') . '<strong></div>

						<div class="fieldarea">

							<textarea  id="textarea_tour_intro_banner_editor_' . time() . '" class="textarea_tour_intro_banner_editor" name="intro_banner" style="width:100%">' . $introBannerValue . '</textarea>

						</div>

					</div>-->';

        $html .= '</div>

			</div>

		</form>

		<div class="modal-footer">

			<button type="button" tourcat_id="' . $tourcat_id . '" class="btn btn-primary btnClickToSubmitCategory">

				<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span> 

			</button>

			<button type="reset" class="btn btn-warning close_pop">

				<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>

			</button>		

		</div>';

        echo ($html);

        die();

    } else if ($tp == 'S') {

        #

        $titlePost = trim(strip_tags(
            (string) ($_POST['title'] ?? '')
        ));

        $slugPost = $core->replaceSpace($titlePost);

        $titlePost = ucfirst($titlePost);

        $parent_id = isset($_POST['parent_id'])
            ? (int) $_POST['parent_id']
            : 0;

        $introPost = trim((string) ($_POST['intro'] ?? ''));

	        $imagePost = isset($_POST['image']) ? $_POST['image'] : '';

	        $iconPost = isset($_POST['icon'])
	            ? trim((string) $_POST['icon'])
	            : '';

	        $introBannerPost = trim((string) ($_POST['intro_banner'] ?? ''));

	        $linkBannerPost = (string) ($_POST['link_banner'] ?? '');

        $imageBannerPost = isset($_POST['image_banner']) ? $_POST['image_banner'] : '';

        $videoTeaserPost = isset($_POST['video_teaser']) ? $_POST['video_teaser'] : '';

  
        if ($titlePost === '') {
            echo '_ERROR';
            die();
        }

        if ($tourcat_id == 0) {

            $duplicateWhere = $hasTableColumn('is_trash')
                ? 'is_trash=0 and '
                : '';

            $all = $clsTourCategory->getAll(
                $duplicateWhere
                . 'slug=' . $dbconn->qstr($slugPost)
                . ' limit 0,1'
            );

            if (!empty($all)) {

                echo '_EXIST';

                die();

            } else {

                $listTable = $clsTourCategory->getAll(
                    '1=1',
                    $clsTourCategory->pkey . ',order_no'
                );

	            if (!is_array($listTable)) {
	                    $listTable = array();
	                }

	                for ($i = 0; $i < count($listTable); $i++) {

                    $order_no = $listTable[$i]['order_no'] + 1;

                    $clsTourCategory->updateOne($listTable[$i][$clsTourCategory->pkey], "order_no='" . $order_no . "'");

                }

	                $currentTime = time();

	                $nextId = (int) $dbconn->GetOne(
	                    'SELECT COALESCE(MAX(`'
	                    . $clsTourCategory->pkey
	                    . '`),0)+1 FROM `'
	                    . $clsTourCategory->tbl
	                    . '`'
	                );

	                if ($nextId <= 0) {
	                    $nextId = (int) $clsTourCategory->getMaxId();
	                }

	                $insertData = array(
	                    $clsTourCategory->pkey => $nextId,
	                    'user_id' => (int) $user_id,
	                    'user_id_update' => (int) $user_id,
	                    'parent_id' => (int) $parent_id,
	                    'title' => $titlePost,
	                    'slug' => $slugPost,
	                    'intro' => $introPost,
	                    'intro_banner' => $introBannerPost,
	                    'order_no' => 1,
	                    'reg_date' => $currentTime,
	                    'upd_date' => $currentTime,
	                    'image' => $imagePost,
	                    'icon' => $iconPost,
	                    'image_banner' => $imageBannerPost,
	                    'link_banner' => $linkBannerPost,
	                    'video_teaser' => $videoTeaserPost,
	                    'is_online' => 1,
	                    'is_trash' => 0,
	                    'lang_id' => 'en',

	                );

	                if ($SiteHasGroup_Tours) {
	                    $insertData['tour_group_id'] = isset(
	                        $_POST['tour_group_id']
	                    )
	                        ? (int) $_POST['tour_group_id']
	                        : 0;
	                }

	                $numericFields = array(
	                    $clsTourCategory->pkey,
	                    'user_id',
	                    'user_id_update',
	                    'parent_id',
	                    'tour_group_id',
	                    'order_no',
	                    'reg_date',
	                    'upd_date',
	                    'is_online',
	                    'is_trash',
	                );

	                $insertFields = array();
	                $insertValues = array();

	                foreach ($insertData as $fieldName => $fieldValue) {
	                    if (!$hasTableColumn($fieldName)) {
	                        continue;
	                    }

	                    $insertFields[] = '`' . $fieldName . '`';
	                    $insertValues[] = in_array(
	                        $fieldName,
	                        $numericFields,
	                        true
	                    )
	                        ? (string) ((int) $fieldValue)
	                        : $dbconn->qstr((string) $fieldValue);
	                }

	                $insertSql = 'INSERT INTO `'
	                    . $clsTourCategory->tbl
	                    . '` (' . implode(',', $insertFields) . ') VALUES ('
	                    . implode(',', $insertValues) . ')';

	                $insertResult = $dbconn->Execute($insertSql);

                if ($insertResult !== false) {

                    echo '_SUCCESS';

                    die();

                } else {

                    error_log(
                        'TourCategory insert failed: '
                        . $dbconn->ErrorMsg()
                        . '; SQL=' . $insertSql
                    );

                    echo '_ERROR';

                    die();

                }

            }

        } else {
            /* Không cho phép UPDATE một ID không tồn tại. */
            $currentCategory = $clsTourCategory->getOne(
                $tourcat_id,
                $clsTourCategory->pkey
            );

            if (empty($currentCategory)) {
                echo '_ERROR';
                die();
            }

            /*
             * Dùng qstr cho toàn bộ dữ liệu text/TinyMCE để không hỏng SQL
             * khi nội dung có dấu nháy, HTML hoặc ký tự đặc biệt.
             */
            $updateData = array(
                'title' => $titlePost,
                'slug' => $slugPost,
                'intro' => $introPost,
                'intro_banner' => $introBannerPost,
                'parent_id' => (int) $parent_id,
                'upd_date' => time(),
                'user_id_update' => (int) $user_id,
                'image' => $imagePost,
                'icon' => $iconPost,
                'image_banner' => $imageBannerPost,
                'link_banner' => $linkBannerPost,
                'video_teaser' => $videoTeaserPost,
            );

            if ($SiteHasGroup_Tours) {
                $updateData['tour_group_id'] = isset(
                    $_POST['tour_group_id']
                )
                    ? (int) $_POST['tour_group_id']
                    : (int) $tour_group_id;
            }

            $numericUpdateFields = array(
                'parent_id',
                'upd_date',
                'user_id_update',
                'tour_group_id',
            );
            $updateFields = array();

            foreach ($updateData as $fieldName => $fieldValue) {
                if (!$hasTableColumn($fieldName)) {
                    continue;
                }

                $updateFields[] = '`' . $fieldName . '`=' . (
                    in_array($fieldName, $numericUpdateFields, true)
                        ? (string) ((int) $fieldValue)
                        : $dbconn->qstr((string) $fieldValue)
                );
            }

            $updateSql = 'UPDATE ' . $clsTourCategory->tbl
                . ' SET ' . implode(',', $updateFields)
                . ' WHERE `' . $clsTourCategory->pkey . '`'
                . '=' . (int) $tourcat_id
                . ' LIMIT 1';

            /*
             * Execute trả kết quả hợp lệ kể cả khi dữ liệu không thay đổi.
             * Điều này tránh báo insert_error khi người dùng bấm Save lần nữa.
             */
            $updateResult = $dbconn->Execute($updateSql);

            if ($updateResult !== false) {
                echo '_SUCCESS';
                die();
            }

            error_log(
                'TourCategory update failed. ID=' . (int) $tourcat_id
                . '; Error=' . $dbconn->ErrorMsg()
            );

            echo '_ERROR';
            die();
        }

    }

}

function default_ajaxSiteTourCategory()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $SiteHasCat_Tours = $clsISO->getCheckActiveModulePackage($package_id, $mod, 'category ', 'default');
    if (!$SiteHasCat_Tours) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $clsTourCategory = new TourCategory();
    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
    $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;
    $chosen = isset($_POST['chosen']) ? intval($_POST['chosen']) : 0;
    if (!$chosen) {
        echo $clsTourCategory->makeSelectboxOption($tour_group_id, $cat_id);
        die();
    } else {
        echo '<select name="cat_id[]" id="cat_id" class="slb required chosen-select" multiple style="width:250px">' . $clsTourCategory->makeSelectboxOption($tour_group_id, $cat_id, true) . '</select>';
        die();
    }
}

/* ========= SITE DEPARTURE POINT TOUR ============= */

function default_ajaxSiteDeparturePoint()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $dbconn, $clsISO, $package_id;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $clsCity = new City();
    #
    $country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : 0;
    //var_dump($country_id);die();
    $cat_id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
    $tour_type_id = isset($_POST['tour_type_id']) ? intval($_POST['tour_type_id']) : 0;
    $departure_point_id = isset($_POST['departure_point_id']) ? intval($_POST['departure_point_id']) : 0;
    //$is_day_trip = isset($_POST['is_day_trip'])?$_POST['is_day_trip']:'';

    #
    $html = '<option value="0">-- ' . $core->get_Lang('selectdeparturepoint') . ' --</option>';
    $sql = "SELECT t1.city_id FROM " . DB_PREFIX . "city t1 INNER JOIN " . DB_PREFIX . "citystore t2 WHERE t1.city_id = t2.city_id and t2.type='DEPARTUREPOINT' and t2.country_id='$country_id' order by t2.order_no DESC";

    $lstItem = $dbconn->GetAll($sql);
    if (is_array($lstItem) && count($lstItem) > 0) {
        foreach ($lstItem as $k => $v) {
            $Query = "1=1 and departure_point_id='" . $v[$clsCity->pkey] . "'";
            if ($cat_id > 0) {
                $Query .= " and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
            }
            /*if($is_day_trip==1){
				 $Query .= " and is_day_trip=1";
			}else{
				 $Query .= " and is_day_trip=0";
			}*/
            $html .= '<option value="' . $v[$clsCity->pkey] . '" ' . ($v[$clsCity->pkey] == $departure_point_id ? 'selected="selected"' : '') . '>-- ' . $clsCity->getTitle($v[$clsCity->pkey]) . ' (' . $clsTour->countItem($Query) . ') --</option>';
            unset($Query);
        }
        unset($lstItem);
    }
    echo $html;
    die();
}

/* END SELECT_DIEM_KHOI_HANH */

/* ========= TOUR GROUP MOD MANAGE ============ */
function default_group()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act, $dbconn;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $_LANG_ID, $clsISO, $clsConfiguration, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, $mod, $act, 'default')) {
        header('Location:/admin/index.php?lang=' . LANG_DEFAULT);
        exit();
    }
    #
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    $classTable = "TourGroup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    $assign_list["clsTour"] = new Tour();
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
        if ($_POST['keyword'] != '' && $_POST['keyword'] != '') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $link);
    }
    #
    $cond = "1=1";
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $cond .= " and slug like '%" . $core->replaceSpace($_GET['keyword']) . "%'";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order by order_no desc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = ADMIN_PAGINATION;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $start_limit = ($currentPage - 1) * $recordPerPage;
    $limit = " limit $start_limit,$recordPerPage";
    $totalRecord = $clsClassTable->getAll($cond) ? count($clsClassTable->getAll($cond)) : 0;
    $totalPage = ceil($totalRecord / $recordPerPage);
    $assign_list['totalRecord'] = $totalRecord;
    $assign_list['recordPerPage'] = $recordPerPage;
    $assign_list['totalPage'] = $totalPage;
    $assign_list['currentPage'] = $currentPage;
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
    #
    //    $dbconn->setFetchMode(ADODB_FETCH_ASSOC);
    $allItem = $clsClassTable->getAll($cond . $orderBy . $limit);
    $assign_list["allItem"] = $allItem;
    unset($allItem);
    $assign_list["number_all"] = $clsClassTable->getAll($cond2) ? count($clsClassTable->getAll($cond2)) : 0;
    $assign_list["number_trash"] = $clsClassTable->getAll($cond2 . " and is_trash=1") ? count($clsClassTable->getAll($cond2 . " and is_trash=1")) : 0;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $tour_group_id = intval($core->decryptID($string));
        if ($string == '' && $tour_group_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tour_group_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $tour_group_id = intval($core->decryptID($string));
        if ($string == '' && $tour_group_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tour_group_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $tour_group_id = intval($core->decryptID($string));
        if ($string == '' && $tour_group_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($tour_group_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['tour_group_id']) ? ($_GET['tour_group_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        if ($string == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        $where = "is_trash=0";
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no ASC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no DESC limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($where . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&message=PositionSuccess');
    }
}


function default_ajaxFrmTourGroup()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourGroup = new TourGroup();
    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;

    $html = '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
		<h3>' . ($tour_group_id == 0 ? $core->get_Lang('add') : $core->get_Lang('edit')) . ' ' . $core->get_Lang('tourgroup') . '</h3>
	</div>';
    $html .= '
	<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="fl" style="width:100%">
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('Title') . ' <font color="red">*</font></div>
					<div class="fieldarea">
						<input class="text full required" name="title" value="' . $clsTourGroup->getTitle($tour_group_id) . '" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('intro') . '</div>
					<div class="fieldarea">
						<textarea  id="textarea_tour_intro_editor_' . time() . '" class="textarea_tour_intro_editor" name="intro" style="width:100%">' . $clsTourGroup->getIntro($tour_group_id) . '</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('Image') . '</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTourGroup->getOneField('image', $tour_group_id) . '" />
						<input type="hidden" id="isoman_hidden_image" value="' . $clsTourGroup->getOneField('image', $tour_group_id) . '">
						<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTourGroup->getOneField('image', $tour_group_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTourGroup->getOneField('image', $tour_group_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				<div class="row-span">
						<div class="fieldlabel" style="text-align:right"><strong>' . $core->get_Lang('Banner') . ' <span class="small">(WxH=1600x460)</span></strong></div>
						<div class="fieldarea">
							<img class="isoman_img_pop" id="isoman_show_image_banner" src="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '" />
							<input type="hidden" id="isoman_hidden_image_banner" value="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '">
							<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image_banner" name="image_banner" value="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_banner" isoman_val="' . $clsTourGroup->getOneField('image_banner', $tour_group_id) . '" isoman_name="image_banner"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
						</div>
					</div>
			</div>
		</div>
	</form>
	<div class="clearfix"></div>
	<div class="modal-footer">
		<button type="button" tour_group_id="' . $tour_group_id . '" class="btn btn-primary ClickSubmitGroup">
			<i class="icon-ok icon-white"></i> <span>Cập nhật</span> 
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>Đóng lại</span>
		</button>		
	</div>
	';
    echo ($html);
    die();
}

function default_ajSubmitTourGroup()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "TourGroup";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;
    #
    $tour_group_id = isset($_POST['tour_group_id']) ? intval($_POST['tour_group_id']) : 0;
    $titlePost = trim(strip_tags($_POST['title']));
    $slugPost = $core->replaceSpace($titlePost);
    $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
    $introPost = trim($_POST['intro']);
    $imagePost = isset($_POST['image']) ? $_POST['image'] : '';
    $bannerPost = isset($_POST['banner']) ? $_POST['banner'] : '';
    #
    if ($tour_group_id == 0) {
        $all = $clsClassTable->getAll("is_trash=0 and slug='$slugPost' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';

            die();
        } else {
            $fx = "$clsClassTable->pkey,user_id,user_id_update,parent_id,title,slug,intro,order_no,reg_date,upd_date,image,image_banner";
            $vx = "'" . $clsClassTable->getMaxId() . "','$user_id','$user_id','$parent_id','$titlePost','$slugPost','" . addslashes($introPost) . "'";
            $vx .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "','" . addslashes($imagePost) . "','" . addslashes($bannerPost) . "'";
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
        $vx = "title='$titlePost',slug='$slugPost',intro='" . addslashes($introPost) . "',parent_id='$parent_id'";
        $vx .= ",upd_date='" . time() . "',user_id_update='$user_id',image='" . addslashes($imagePost) . "',image_banner='" . addslashes($bannerPost) . "'";
        if ($clsClassTable->updateOne($tour_group_id, $vx)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

function default_setting()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourProperty = new TourProperty();
    $assign_list["clsTourProperty"] = $clsTourProperty;
    $clsTourStore = new TourStore();
    $assign_list["clsTourStore"] = $clsTourStore;
    $clsAdminbutton = new AdminButton();

    $lstMenu = $clsAdminbutton->menuSettingTours();

    if (!empty($lstMenu)) {
        header('location:' . $lstMenu[0]['link']);
        exit();
    }
    #
    if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateConfiguration') {
        foreach ($_POST as $key => $val) {
            $tmp = explode('-', $key);
            if ($tmp[0] == 'iso') {
                $clsConfiguration->updateValue($tmp[1], $val);
            }
        }
        $site_tour_banner = $_POST['isoman_url_site_tour_banner'];
        if ($site_tour_banner != '' && $site_tour_banner != '0') {
            $clsConfiguration->updateValue('site_tour_banner', $site_tour_banner);
        }
        header('location:' . PCMS_URL . '?mod=' . $mod . '&act=setting&message=updateSuccess');
    }
}

function default_property()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act;
    global $core, $clsModule, $clsConfiguration, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    $assign_list["type"] = $type;

    $classTable = "TourProperty";
    if($type == 'TOUROPTION') {
        $classTable = "TourOption";
    }
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;

    $listVISITORTYPE = $clsClassTable->getAll("is_trash=0 and type='VISITORTYPE' and is_online=1 order by order_no asc");
    $assign_list["listVISITORTYPE"] = $listVISITORTYPE;

    $listVISITORAGETYPE = $clsClassTable->getAll("is_trash=0 and type='VISITORAGETYPE' and is_online=1 order by order_no asc");
    $assign_list["listVISITORAGETYPE"] = $listVISITORAGETYPE;

    $listVISITORHEIGHTTYPE = $clsClassTable->getAll("is_trash=0 and type='VISITORHEIGHTTYPE' and is_online=1 order by order_no asc");
    $assign_list["listVISITORHEIGHTTYPE"] = $listVISITORHEIGHTTYPE;

    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '&act=' . $act;
        if ($type != '') {
            $link .= '&type=' . $type;
        }
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }
    /* Get type of list news */
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;

    $cond = "1='1' and type<>'TRANSPORT'";
    if ($type != '') {
        $cond .= " and type='$type'";
        $pUrl = '&type=' . $type;
    }
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
    $orderBy = " order_no asc";
    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = ADMIN_PAGINATION;
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
    $allItem = $clsClassTable->getAll($cond . " order by " . $orderBy . $limit); //print_r($cond." order by ".$orderBy.$limit);die();
    $assign_list["allItem"] = $allItem;
    $assign_list["pUrl"] = $pUrl;
    
    #
    $assign_list["number_trash"] = $clsClassTable->countItem("is_trash=1 and " . $cond2);
    $assign_list["number_item"] = $clsClassTable->countItem("is_trash=0 and " . $cond2);
    $assign_list["number_all"] = $clsClassTable->countItem($cond2);
    // Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Delete') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($pvalTable)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $pvalTable = isset($_GET[$pkeyTable]) ? $_GET[$pkeyTable] : '';
        if ($pvalTable == '' && $pvalTable == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }
        #
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';
        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        #
        if ($direct == 'moveup') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no asc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no desc limit 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $clsClassTable->updateOne($lst[0][$clsClassTable->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsClassTable->getAll($cond . " and order_no > $order_no order by order_no desc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsClassTable->getAll($cond . " and order_no < $order_no order by order_no asc LIMIT 0,1");
            $clsClassTable->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
            $lst = $clsClassTable->getAll($cond . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
            for ($i = 0; $i < count($lst); $i++) {
                $clsClassTable->updateOne($lst[$i][$clsClassTable->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
            }
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=PositionSuccess');
    }

    $clsTourProperty = new TourProperty();
    $clsTourOption = new TourOption();
    $assign_list["clsTourOption"] = $clsTourOption;
    $clsSettingChildPolicy = new SettingChildPolicy();
    $assign_list["clsSettingChildPolicy"] = $clsSettingChildPolicy;

    $adult_type_id = $clsTourProperty->getAll("is_trash=0 and is_online=1 and type='VISITORTYPE' order by order_no ASC limit 0,1");
    $adult_type_id = $adult_type_id[0]['tour_property_id'];

    $cond_setting = "is_trash=0 and tour_property_id='$adult_type_id' and type='SIZEGROUP'";
    $cond_setting .= " ORDER BY number_to ASC";
    $lstAdultGroupSize = $clsTourOption->getAll($cond_setting, $clsTourOption->pkey . ",number_to,number_from");
    $assign_list["lstAdultGroupSize"] = $lstAdultGroupSize;
}

function default_ajUpdPosSortTourProperty()
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

function default_ajUpdPosSortTourOption()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration, $clsISO, $package_id;
    #
    $clsTourOption = new TourOption();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourOption->updateOne($val, "order_no='" . $key . "'");
    }
}

/* ============== TOUR TRANSPORT MANAGEMENT ================ */

function default_transporttours()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    if (!$clsISO->getCheckActiveModulePackage($package_id, ’property’, 'transport', 'default')) {
        header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&message=NotPermission');
        exit();
    }
    #
    $classTable = "TourTransport";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;

    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    #
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if ($_POST['keyword'] != '' && $_POST['keyword'] != 'testimonial title, intro') {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        header('location: ' . PCMS_URL . '/?mod=' . $mod . $link);
    }

    $cond = "1=1";
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $slug = $core->replaceSpace($_GET['keyword']);
        $cond .= " and ( trip_code like '%" . $_GET['keyword'] . "%' or slug like '%" . $slug . "%' or title like '%" . $slug . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;

    $orderBy = " order_no desc";
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    } elseif ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no desc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = 30;
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
    $assign_list["allItem"] = $allItem;

    //Action
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'Trash') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $tourtransport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourtransport_id, "is_trash='1'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=TrashSuccess');
        }
    }
    if ($action == 'Restore') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $tourtransport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourservice_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->updateOne($tourtransport_id, "is_trash='0'")) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=RestoreSuccess');
        }
    }
    if ($action == 'Delete') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $tourtransport_id = intval($core->decryptID($string));
        $pUrl = '';
        if ($string == '' && $tourtransport_id == 0) {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . $pUrl . '&message=NotPermission');
            exit();
        }
        if ($clsClassTable->deleteOne($tourtransport_id)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . $pUrl . '&message=DeleteSuccess');
        }
    }
    if ($action == 'move') {
        $string = isset($_GET['tourtransport_id']) ? ($_GET['tourtransport_id']) : '';
        $pvalTable = intval($core->decryptID($string));
        $direct = isset($_GET['direct']) ? $_GET['direct'] : '';

        $one = $clsClassTable->getOne($pvalTable);
        $order_no = $one['order_no'];
        if (($string != '' && $pvalTable == 0) || $direct == '') {
            header('location:' . PCMS_URL . '/index.php?admin&mod=' . $mod . '&act=' . $act . '&message=NotPermission');
            exit();
        }

        $where = "1='1' and is_trash=0";
        $pUrl = '&act=transporttours';
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

function default_ajaxFrmTransportour()
{
    global $assign_list, $_CONFIG, $core, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $clsTourTransport = new TourTransport();
    $tourtransport_id = isset($_POST['tourtransport_id']) ? intval($_POST['tourtransport_id']) : 0;
    #
    $html = '
	<div class="headPop">
		<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
		<h3>' . ($tourtransport_id == 0 ? $core->get_Lang('Add New Transport') : $core->get_Lang('Edit Detail Transport')) . '</h3>
	</div>';
    $html .= '
	<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
		<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel text-right bold"><strong class="color_r">' . $core->get_Lang('Title') . '</strong> <font color="red">*</font></div>
				<div class="fieldarea">
					<input class="text full required" name="title" value="' . $clsTourTransport->getTitle($tourtransport_id) . '" type="text" autocomplete="off" />
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel" style="text-align:right">' . $core->get_Lang('Image') . '</div>
				<div class="fieldarea">
					<img class="isoman_img_pop" id="isoman_show_image" src="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '" />
					<input type="hidden" id="isoman_hidden_image" value="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '">
					<input style="width:70% !important;float:left;margin-left:4px;" type="text" id="isoman_url_image" name="image" value="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="' . $clsTourTransport->getOneField('image', $tourtransport_id) . '" isoman_name="image"><img src="' . URL_IMAGES . '/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel  text-right">' . $core->get_Lang('intro') . '</div>
				<div class="fieldarea">
					<textarea id="textarea_intro_editor' . time() . '" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">' . $clsTourTransport->getIntro($tourtransport_id) . '</textarea>
				</div>
			</div>
			
		</div>
	</form>
	<div class="modal-footer">
		<button type="button" tourtransport_id="' . $tourtransport_id . '" class="btn btn-primary btnSaveTransport">
			<i class="icon-ok icon-white"></i> <span>' . $core->get_Lang('save') . '</span>
		</button>
		<button type="reset" class="btn btn-warning close_pop">
			<i class="icon-retweet icon-white"></i> <span>' . $core->get_Lang('close') . '</span>
		</button>
	</div>';
    echo ($html);
    die();
}

function default_ajaxSaveTransportour()
{
    global $assign_list, $_CONFIG, $_LANG_ID, $_SITE_ROOT, $mod, $act, $clsISO, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "TourTransport";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    #
    $tourtransport_id = isset($_POST['tourtransport_id']) ? $_POST['tourtransport_id'] : 0;
    $titlePost = trim($_POST['title']);
    $slugPost = $core->replaceSpace($titlePost);
    $introPost = addslashes($_POST['intro']);
    $imagePost = addslashes($_POST['image']);
    #
    if (intval($tourtransport_id) == 0) {
        $all = $clsClassTable->getAll("is_trash=0 and slug like '%" . $slugPost . "' limit 0,1");
        if (!empty($all)) {
            echo '_EXIST';
            die();
        } else {
            $f = "user_id,user_id_update,title,slug,intro,order_no,reg_date,upd_date";
            $v = "'$user_id','$user_id','" . addslashes($titlePost) . "','" . addslashes($slugPost) . "','" . addslashes($introPost) . "'";
            $v .= ",'" . $clsClassTable->getMaxOrderNo() . "','" . time() . "','" . time() . "'";
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
        $vx = "title='" . addslashes($titlePost) . "',slug='" . addslashes($slugPost) . "',intro='$introPost',upd_date='" . time() . "',user_id_update='$user_id'";
        if ($imagePost != '' && $imagePost != '0') {
            $vx .= ",image='" . $imagePost . "'";
        }
        if ($clsClassTable->updateOne($tourtransport_id, $vx)) {
            echo '_SUCCESS';
            die();
        } else {
            echo '_ERROR';
            die();
        }
    }
}

/* ------ START_SLOTAVAILABLE ------- */

/* ------ Load Tour Gallery ------- */

function default_ajInitTSysTourGallery()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO, $package_id;
    #
    $clsTourImage = new TourImage();
    $table_id = $_POST['table_id'];
    #
    $html = '';
    $html .= '
	<div class="wrap">
		<div class="group_button fl">
			<form method="post" action="" accept="application/pdf" id="aj-upload-form" enctype="multipart/form-data">
				<input style="display:none" type="file" multiple="" name="image[]" id="ajAttachFile" />
				<a style="display:none" id="ajSysPhotosGallery" table_id="' . $table_id . '" class="iso-button-primary fl mr10">
					<i class="icon-random"></i>&nbsp; ' . $core->get_Lang('synchronizeposition') . '
				</a>
				<a table_id="' . $table_id . '" isoman_multiple="1" class="iso-button-standard ajOpenDialog fl mr10" isoman_for_id="image_val" isoman_name="image"><i class="icon-plus-sign"></i>&nbsp; ' . $core->get_Lang('addimages') . '</a>
				<input type="hidden" value="' . $table_id . '" name="table_id" id="Hid_TableID"/>
				<input type="hidden" value="' . $type . '" name="type" id="Hid_TypeID"/>
			</form>
		</div>
	</div>';
    $html .= '
	<div class="clearfix"><br /></div>
	<div class="hastable">
		<table class="full-width tbl-grid" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td class="gridheader" style="width:40px"><strong>' . $core->get_Lang('index') . '</strong></td>
					<td class="gridheader"><strong>' . $core->get_Lang('images') . '</strong></td>
					<td class="gridheader text-left"><strong>' . $core->get_Lang('alttext') . '</strong></td>
					<td class="gridheader hiden767" style="width:12%"><strong>' . $core->get_Lang('update') . '</strong></td>
					<td class="gridheader" style="width:6%;"><strong>' . $core->get_Lang('func') . '</strong></td>
				</tr>
			</thead>
			<tbody id="preview"></tbody>
		</table>
		<div class="clearfix" style="height:5px"></div>
		<div class="pagination_box">
			<div class="wrap" id="gallery_paginate">
			<!-- Ajax Loading pagination -->
			</div>
		</div>
	</div>';
    // End code here !!
    $html .= '
	<script type="text/javascript">
		$(function(){
			checkSysPosition();
			$(document).on(\'click\', \'.ajdeletePhotosGallery\', function(ev){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					$.ajax({
						type: "POST",
						url: path_ajax_script+"/index.php?mod=tour_exhautive&act=ajOpenTourGallery",
						data: {\'tp\':\'D\', \'tour_image_id\': $_this.attr(\'data\')},
						dataType: "html",
						success: function(html){
							var $table_id = $(\'#Hid_TableID\').val();
							loadTableGallery($table_id,\'\',1,10);
							checkSysPosition();
						}
					});
				}
			});
			$(document).on(\'click\', \'.ajeditPhotosGallery\', function(ev){
				var $_this = $(this);
				var $tour_image_id = $_this.attr(\'data\');
				var $table_id = $_this.attr(\'table_id\');
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod=tour_exhautive&act=ajOpenTourGallery",
					data: {\'tp\':\'C\',\'tour_image_id\' : $tour_image_id,\'table_id\' : $table_id},
					dataType: "html",
					success: function(html){
						makepopup(\'240px\',\'auto\',html,\'box_EditPhotosGallery\');
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.ajmovePhotosGallery\', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=tour_exhautive&act=ajOpenTourGallery",
					data: {
						\'tour_image_id\' : $_this.attr(\'data\'),
						\'direct\' : $_this.attr(\'direct\'),
						\'tp\' : \'M\'
					},
					success: function(html){
						vietiso_loading(0);
						var $table_id = $_this.attr(\'table_id\');
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGallery($table_id,\'\',$page,10);
					}
				});
				return false;
			});
			$(document).on(\'click\', \'.paginate_button\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $keywrord = \'\';
				loadTableGallery($table_id,$keywrord,$_this.attr(\'page\'),10);
				return false;
			});
			$(\'#keysearch_pop\').bind(\'keyup change\',function(){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				var $page = $(\'#Hid_CurrentPage\').val();
				loadTableGallery($table_id,$_this.val(),$page,3);
			});
			$(document).on(\'click\', \'#ajSysPhotosGallery\', function(ev){
				var $_this = $(this);
				var $table_id = $(\'#Hid_TableID\').val();
				vietiso_loading(1);
				$.ajax({
					type:\'POST\',
					url: path_ajax_script+"/index.php?mod=tour_exhautive&act=ajOpenTourGallery",
					data:{"table_id" : $table_id,\'tp\':\'SYS\'},
					success: function(html){
						vietiso_loading(0);
						var $page = $(\'#Hid_CurrentPage\').val();
						loadTableGallery($table_id,\'\',$page,10);
					}
				});	
				return false;
			});
		});
		function isoman_callback(){
			var $table_id = $(\'#Hid_TableID\').val();
			var $page = $(\'#Hid_CurrentPage\').val();
			var $clsTable = \'TourImage\';
			var $type= \'TourImage\';
			var $file_images = isoman_selected_files();
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=home&act=ajUploadForm",
				data: {
					\'table_id\':$table_id,
					\'type\':$type,
					\'clsTable\':$clsTable,
					\'file_images\':$file_images
				},
				dataType: "html",
				success: function(html){
					loadTableGallery($table_id,\'\', $page, 10);
					checkSysPosition();
				}
			});
		}
		function checkSysPosition(){
			var $table_id = $(\'#Hid_TableID\').val();
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=tour_exhautive&act=ajOpenTourGallery",
				data: {\'table_id\':$table_id,\'tp\':\'TOTAL\'},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					var htm = parseInt(html);
					if(htm==0){
						$(\'#ajSysPhotosGallery\').hide();
					}else{
						$(\'#ajSysPhotosGallery\').show();
					}
				}
			});
		}
	</script>';
    $html .= '</div>';
    echo $html;
    die();
}

function default_ajOpenTourGallery()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $package_id;
    #
    $clsPagination = new Pagination();
    $clsTourImage = new TourImage();
    $pkeyTable = $clsTourImage->pkey;

    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
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
        $totalRecord = $clsTourImage->countItem($cond);
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTourImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTourImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_' . $tour_image_id . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index2">' . ($offset + $i + 1) . '</td>';
                $html .= '<td width="85px"><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="75" height="50" /></a></td>';
                $html .= '<td>
				
				<input class="editTitleImage full-width" style="max-width:200px" data="' . $tour_image_id . '" table_id="' . $table_id . '" value="' . $clsTourImage->getTitle($tour_image_id) . '" style="line-height:28px; font-size:12px; padding:0 10px" />
				<a style="display:none" href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTourImage->getTitle($tour_image_id) . '</strong></a>
				
				</td>';
                $html .= '<td class="hiden767" style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
                $html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu">
							<li><a href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $tour_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
            $html .= '
			<script type="text/javascript">
				$("#preview").sortable({
					opacity: 0.8,
					cursor: \'move\',
					start: function(){
						vietiso_loading(1);
					},
					stop: function(){
						vietiso_loading(0);
					},
					update: function(){
						var page = "' . $page . '";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage=' . $number_per_page . '\'+\'&currentPage=' . $page . '\';
						$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(tour_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
				
				$(".editTitleImage").live("change", function() {
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: path_ajax_script + "/?mod=" + mod + "&act=ajOpenTourGallery",
					data: {
						"table_id": $_this.attr("table_id"),
						"tour_image_id": $_this.attr("data"),
						"title": $_this.val(),
						"tp": "S"
					},
					dataType: "html",
					success: function(html) {
					alertify.success("Success");
					vietiso_loading(1);
					vietiso_loading(0);
		
					}
				});
			});
				
			</script>';
        } else {
            $html = '
			<tr style="background:#ffda0b;">
				<td colspan="9" style="text-align:center;text-decoration:blink">' . $core->get_Lang('nodata') . '</td>
		   </tr>';
        }
        echo $html . '$$$' . $pageview . '$$$' . $page;
        die();
    } // Delete
    else if ($tp == 'D') {
        $clsTourImage->deleteOne($tour_image_id);
        echo (1);
        die();
    } // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTourImage->getMaxOrderNo($table_id) . "','" . time() . "'";
        $clsTourImage->insertOne($fx, $vx);
        echo (1);
        die();
    } // Edit Upload Form
    else if ($tp == 'C') {
        $HTML .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('Add/Edit File') . '</h3>
		</div>';
        $HTML .= '
		<form method="post" action="" method="post" id="aj-update-form" enctype="multipart/form-data">
		<table cellpadding="2" cellspacing="2" width="100%" class="form">
			<tr>
				<td class="fieldarea">
					<input type="text" name="title" class="text full required" style="width:100%" value="' . $clsTourImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTourImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTourImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTourImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
        if ($clsTourImage->getOneField('image', $tour_image_id) != '') {
            $HTML .= '<a pvalTable="' . $tour_image_id . '" clsTable="TourImage" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
        }
        $HTML .= '</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr btnClickUpdate" tour_image_id="' . $tour_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.btnClickUpdate\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($title.val()==\'\'){
						$title.focus();
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
						data : {\'tp\':\'S\',\'tour_image_id\': $_this.attr(\'tour_image_id\')},
						success: function(html){
							var htm = parseInt(html);
							if(htm==1){
								$(\'#aj-upload-form\').resetForm();
								var $table_id = $_this.attr(\'table_id\');
								var $page = $(\'#Hid_CurrentPage\').val();
								loadTableGallery($table_id, \'\',$page,10);
								$_form.find(\'.close_pop\').trigger(\'click\');
							}
						}
					});
					return false;
				});
			})
		</script>';
        echo $HTML;
        die();
    } // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if ($_POST['isoman_url_image'] != '' && $_POST['isoman_url_image'] != '0') {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsTourImage->updateOne($tour_image_id, $set)) {
                echo (1);
                die();
            } else {
                echo (0);
                die();
            }
        } else {
            echo (0);
            die();
        }
    } else if ($tp == 'M') {
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        $one = $clsTourImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTourImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTourImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTourImage->countItem("is_trash=0 and table_id='$table_id'");
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTourImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTourImage->updateOne($LISTALL[$i][$clsTourImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}

function default_ajOpenTourGalleryTourNew()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $package_id;
    #
    $clsPagination = new Pagination();
    $clsTourImage = new TourImage();
    $pkeyTable = $clsTourImage->pkey;
    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
    $table_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
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
        $totalRecord = $clsTourImage->countItem($cond);
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";
        $lstItem = $clsTourImage->getAll($cond . $order_by);
        //        $clsISO->print_pre($cond . $order_by,true);die();
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTourImage->pkey];
                $html .= '<div class="gallery-item bootstrap">';
                $html .= '<a><img class="img-responsive mr-3 mb-2 preview-img" src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" alt="' . $lstItem[$i]['title'] . '" ></a>';
                $html .= '  <div class="gallery-toolbar">
						<a class="text-white del_gal_img" onClick="delete_gallery(this)" tour_id="' . $table_id . '" tour_image_id="' . $lstItem[$i]['tour_image_id'] . '">' . $clsISO->makeIcon('times') . '</a>
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

function default_ajChangeEditImg()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id;
    //    header('Content-Type: application/json');
    $clsTour = new Tour();
    $clsTourOption = new TourOption();
    $clsTourImage = new TourImage();
    $url_img = isset($_POST['url_img']) ? $_POST['url_img'] : '';
    $title_img = isset($_POST['title_img']) ? $_POST['title_img'] : '';
    $id_it = isset($_POST['id']) ? $_POST['id'] : '';
    $user_id = $core->_USER['user_id'];
    $result = array('result' => 'error', 'mes' => $core->get_Lang('error_data_image'));


    if ($title_img == '') {
        $result = array('result' => 'error', 'mes' => $core->get_Lang('error_title_image'));
    }
    if ($url_img == '') {
        $result = array('result' => 'error', 'mes' => $core->get_Lang('error_url_image'));
    }
    if ($title_img != '' && $url_img != '') {
        $set = "image='" . $url_img . "',title='" . addslashes($title_img) . "',slug='" . $core->replaceSpace($title_img) . "'";
        if ($clsTourImage->updateOne($id_it, $set)) {
            $result = array('result' => 'success', 'mes' => $core->get_Lang('success_save_image'));
        } else {
            $result = array('result' => 'error', 'mes' => $core->get_Lang('error_save_image'));
        }
    }

    echo json_encode($result);
    die();
}


function default_ajOpenTourGalleryNew()
{
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsISO, $package_id;
    #
    $clsPagination = new Pagination();
    $clsTourImage = new TourImage();
    $pkeyTable = $clsTourImage->pkey;

    $tour_image_id = isset($_POST['tour_image_id']) ? intval($_POST['tour_image_id']) : 0;
    $table_id = isset($_POST['table_id']) ? intval($_POST['table_id']) : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
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
        $totalRecord = $clsTourImage->countItem($cond);
        $pageview = $clsPagination->pagination_ajax($totalRecord, $number_per_page, $page, '', '', false);
        #
        $offset = ($page - 1) * $number_per_page;
        $order_by = " ORDER BY order_no asc";
        $limit = " LIMIT $offset,$number_per_page";

        $lstItem = $clsTourImage->getAll($cond . $order_by . $limit);
        if (!empty($lstItem)) {
            for ($i = 0; $i < count($lstItem); $i++) {
                $tour_image_id = $lstItem[$i][$clsTourImage->pkey];
                #
                $html .= '<tr style="cursor:move" id="order_' . $tour_image_id . '" class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                $html .= '<td class="index">' . ($offset + $i + 1) . '</td>';
                $html .= '<td width="60px"><img src="' . $ftp_abs_path_image . $lstItem[$i]['image'] . '" width="60" height="40" /></td>';
                $html .= '<td><a href="javascript:void();" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><strong>' . $clsTourImage->getTitle($tour_image_id) . '</strong></a></td>';
                $html .= '<td style="text-align:right;color:#c00000">' . date('d-m-Y h:i', $lstItem[$i]['reg_date']) . '</td>';
                if (1 == 2) {
                    $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movetop" title="' . $core->get_Lang('movetop') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-up"></i></a>') . '</td>';
                    $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="movebottom" title="' . $core->get_Lang('movebottom') . '" table_id="' . $table_id . '"><i class="icon-circle-arrow-down"></i></a>') . '</td>';
                    $html .= '<td style="text-align:center">' . ($i == 0 ? '' : '<a href="javascript:void();" data="' . $tour_image_id . '" class="ajmovePhotosGallery" direct="moveup" title="' . $core->get_Lang('moveup') . '" table_id="' . $table_id . '"><i class="icon-arrow-up"></i></a>') . '</td>';
                    $html .= '<td style="text-align:center">' . ($i == count($lstItem) - 1 ? '' : '<a href="javascript:void();" class="ajmovePhotosGallery" direct="movedown" title="' . $core->get_Lang('movedown') . '" data="' . $tour_image_id . '" table_id="' . $table_id . '"><i class="icon-arrow-down"></i></a>') . '</td>';
                }
                $html .= '
				<td style="vertical-align:middle; width:6%;">
					<div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button> 
						<ul class="dropdown-menu" style="right:0px !important">
							<li><a href="javascript:void(0);" data="' . $tour_image_id . '" table_id="' . $table_id . '" title="' . $core->get_Lang('edit') . '" class="ajeditPhotosGallery"><i class="icon-edit"></i> ' . $core->get_Lang('edit') . '</a></li>
							<li><a href="javascript:void(0);" table_id="' . $table_id . '" data="' . $tour_image_id . '" title="' . $core->get_Lang('delete') . '" class="ajdeletePhotosGallery"><i class="icon-remove"></i> ' . $core->get_Lang('delete') . '</a></li>
						</ul>
					</div>
				</td>';
                $html .= '</tr>';
            }
            $html .= '
			<script type="text/javascript">
				$("#preview").sortable({
					opacity: 0.8,
					cursor: \'move\',
					start: function(){
						vietiso_loading(1);
					},
					stop: function(){
						vietiso_loading(0);
					},
					update: function(){
						var page = "' . $page . '";
						var order = $(this).sortable("serialize")+\'&update=update\'+\'&recordPerPage=' . $number_per_page . '\'+\'&currentPage=' . $page . '\';
						$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosTourGallery", order, function(html){
							loadTableGallery(tour_id, \'\', page, 10);
							vietiso_loading(0);
						});
					}
				});
			</script>';
        } else {
            $html = '
			<tr style="background:#ffda0b;">
				<td colspan="9" style="text-align:center;text-decoration:blink">' . $core->get_Lang('nodata') . '</td>
		   </tr>';
        }
        echo $html . '$$$' . $pageview . '$$$' . $page;
        die();
    } // Delete
    else if ($tp == 'D') {
        $clsTourImage->deleteOne($tour_image_id);
        echo (1);
        die();
    } // Quick Create
    else if ($tp == 'Q') {
        $fx = "table_id,order_no,reg_date";
        $vx = "'$table_id','" . $clsTourImage->getMaxOrderNo($table_id) . "','" . time() . "'";
        $clsTourImage->insertOne($fx, $vx);
        echo (1);
        die();
    } // Edit Upload Form
    else if ($tp == 'C') {
        $HTML .= '
		<div class="headPop">
			<a class="closeEv close_pop" href="javascript:void();" title="' . $core->get_Lang('close') . '"></a>
			<h3>' . $core->get_Lang('Add/Edit File') . '</h3>
		</div>';
        $HTML .= '
		<form method="post" action="" method="post" id="aj-update-form" enctype="multipart/form-data">
		<table cellpadding="2" cellspacing="2" width="100%" class="form">
			<tr>
				<td class="fieldarea">
					<input type="text" name="title" class="text full required" style="width:96%" value="' . $clsTourImage->getTitle($tour_image_id) . '">
				</td>
			</tr>
			<tr>
				<td class="fieldarea">
					<div class="photobox image">
						<img src="' . $clsTourImage->getOneField('image', $tour_image_id) . '" id="isoman_show_image_val" />
						<input type="hidden" id="isoman_hidden_image_val" name="isoman_url_image" value="' . $clsTourImage->getOneField('image', $tour_image_id) . '" />
						<a href="javascript:void(0);" title="' . $core->get_Lang('change') . '" class="photobox_edit ajOpenDialog" isoman_for_id="image_val" isoman_val="' . $clsTourImage->getOneField('image', $tour_image_id) . '" isoman_name="image">
							<i class="iso-edit"></i>
						</a>';
        if ($clsTourImage->getOneField('image', $tour_image_id) != '') {
            $HTML .= '<a pvalTable="' . $tour_image_id . '" clsTable="TourImage" href="javascript:void()" title="' . $core->get_Lang('delete') . '" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> ';
        }
        $HTML .= '</div>
				</td>
			</tr>
		</table>
		<div class="clear"><br /></div>';
        $HTML .= '<div class="modal-footer wrap">
					<a href="javascript:void(0);" class="iso-button-standard submitClick fr btnClickUpdate" tour_image_id="' . $tour_image_id . '" table_id="' . $table_id . '" ><img align="absmiddle" src="' . URL_IMAGES . '/v2/check.png"> ' . $core->get_Lang('save') . '</a>
			   </div>';
        $HTML .= '</form>';
        $HTML .= '
		<script type="text/javascript">
			$(function(){
				$(document).on(\'click\', \'.btnClickUpdate\', function(){
					var $_this = $(this);
					var $_form = $_this.closest(\'.frmPop\');
					var $title = $_form.find(\'input[name=title]\');
					if($title.val()==\'\'){
						$title.focus();
						alertify.error(field_is_required);
						return false;
					};
					$(\'#aj-update-form\').ajaxSubmit({
						type:\'POST\',
						url: path_ajax_script+"/index.php?mod=tour&act=ajOpenTourGallery",
						data : {\'tp\':\'S\',\'tour_image_id\': $_this.attr(\'tour_image_id\')},
						success: function(html){
							var htm = parseInt(html);
							if(htm==1){
								$(\'#aj-upload-form\').resetForm();
								var $table_id = $_this.attr(\'table_id\');
								var $page = $(\'#Hid_CurrentPage\').val();
								loadTableGallery($table_id, \'\',$page,10);
								$_form.find(\'.close_pop\').trigger(\'click\');
							}
						}
					});
					return false;
				});
			})
		</script>';
        echo $HTML;
        die();
    } // Save
    else if ($tp == 'S') {
        $titlePost = addslashes($_POST['title']);
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $set = "title='" . $titlePost . "',slug='" . $core->replaceSpace($titlePost) . "',reg_date='" . time() . "'";
            if ($_POST['isoman_url_image'] != '' && $_POST['isoman_url_image'] != '0') {
                $set .= ",image='" . addslashes($_POST['isoman_url_image']) . "'";
            }
            if ($clsTourImage->updateOne($tour_image_id, $set)) {
                echo (1);
                die();
            } else {
                echo (0);
                die();
            }
        } else {
            echo (0);
            die();
        }
    } else if ($tp == 'M') {
        $direct = isset($_POST['direct']) ? $_POST['direct'] : '';
        $one = $clsTourImage->getOne($tour_image_id);
        $table_id = $one['table_id'];
        $order_no = $one['order_no'];
        #
        $where = "table_id='$table_id'";
        if ($direct == 'moveup') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movedown') {
            $lst = $clsTourImage->getAll($where . " and order_no<$order_no order by order_no desc limit 0,1");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[0]['order_no'] . "'");
            $clsTourImage->updateOne($lst[0][$clsTourImage->pkey], "order_no='" . $order_no . "'");
        }
        if ($direct == 'movetop') {
            $lst = $clsTourImage->getAll($where . " and order_no>$order_no order by order_no asc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no>$order_no order by order_no asc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
                }
                unset($lst);
            }
        }
        if ($direct == 'movebottom') {
            $lst = $clsTourImage->getAll($where . " and type='$type' and order_no<$order_no order by order_no desc");
            $clsTourImage->updateOne($tour_image_id, "order_no='" . $lst[count($lst) - 1]['order_no'] . "'");
            $lst = $clsTourImage->getAll($where . "$pkeyTable <> '$tour_image_id' and order_no<$order_no order by order_no desc");
            if (!empty($lst)) {
                for ($i = 0; $i < count($lst); $i++) {
                    $clsTourImage->updateOne($lst[$i][$clsTourImage->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
                }
                unset($lst);
            }
        }
        echo (1);
        die();
    } else if ($tp == 'TOTAL') {
        echo $clsTourImage->countItem("is_trash=0 and table_id='$table_id'");
        die();
    } else if ($tp == 'SYS') {
        $LISTALL = $clsTourImage->getAll("is_trash=0 and table_id='$table_id' order by tour_image_id asc");
        if (!empty($LISTALL)) {
            for ($i = 0; $i < count($LISTALL); $i++) {
                $clsTourImage->updateOne($LISTALL[$i][$clsTourImage->pkey], "order_no='" . ($i + 1) . "'");
            }
            unset($LISTALL);
        }
        echo (1);
        die();
    }
    echo (1);
    die();
}

function default_ajUpdPosTourGallery()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO, $package_id;
    global $clsConfiguration;
    #
    $clsTourImage = new TourImage();
    $order = $_POST['order'];
    $currentPage = $_POST['currentPage'];
    $recordPerPage = $_POST['recordPerPage'];
    //var_dump($currentPage.'xxxxxx'.$recordPerPage);die();
    foreach ($order as $key => $val) {
        $key = (($currentPage - 1) * $recordPerPage + $key + 1);
        $clsTourImage->updateOne($val, "order_no='" . $key . "'");
    }
}

function default_ajOpenSotAvailable()
{
    global $dbconn, $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule, $clsISO, $package_id;
    global $clsISO;
    $user_id = $core->_USER['user_id'];
    #
    $clsTour = new Tour();
    $clsTourStartDate = new TourStartDate();
    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
    $tp = isset($_POST['tp']) ? $_POST['tp'] : '';
    $is_type_table = isset($_POST['is_type_table']) ? $_POST['is_type_table'] : 'grid';
    #
    if ($tp == 'L') {
        $pp_month = isset($_POST['pp_month']) ? intval($_POST['pp_month']) : date('n');
        $pp_year = isset($_POST['pp_year']) ? intval($_POST['pp_year']) : date('Y');
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $pp_month, $pp_year);
        #
        $_daterange = array();
        for ($i = 1; $i <= $totalDays; $i++) {
            $_daterange[] = strtotime($i . '-' . $pp_month . '-' . $pp_year);
        }
        #
        $html = '';
        $html = '
		<div class="hd">
			<div class="span">
				<label>' . $core->get_Lang('month') . '</label>
				<select id="chgSellByMonth">' . $clsISO->makeSelectMonth($pp_month) . '</select>
				<label>' . $core->get_Lang('year') . '</label>
				<select id="chgSellByYear">' . $clsISO->makeSelectYear($pp_year) . '</select>
			</div>
		</div>
		<h2 class="text-center font16px"><strong>' . $core->get_Lang('List open day sell month') . ' ' . $pp_month . '/' . $pp_year . '</strong></h2>
		<div class="clearfix"><br /></div>
		<div id="pTSell">';
        if ($is_type_table == 'grid') {
            $html .= '
				<style type="text/css">
					#pTSell{ overflow:auto;}
					#pTSell > .form{ width:225%;}
					#pTSell > .form td.fieldarea{ padding:4px !important; width:100px; height:28px; light-height:28px;}
					#pTSell > .form input.full{ width:52px; height:28px; light-height:28px;}
					#pTSell > .form input.medium{ width:32px; height:28px; light-height:28px;}
				</style>
				<table class="form" cellpadding="2" cellspacing="2" style="table-layout:auto;">
					<tbody>
						<tr>
							<td class="fieldarea" style="width:5%;">' . $core->get_Lang('day') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<strong>' . date('D', $_daterange[$i]) . '</strong>
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('date') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center"><strong>' . date('d', $_daterange[$i]) . '</strong></td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('numberofseats') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="allotment" class="text medium text-center autosavefield saleSlot" start_date="' . $_daterange[$i] . '" type="text" id="input_' . $_daterange[$i] . '_' . $tour_id . '" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'allotment') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('hadsold') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="seat_sale" class="text medium text-center autosavefield" id="input_sale_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'seat_sale') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('empty') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="seat_available" class="text medium text-center autosavefield" id="input_avai_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '"  type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'seat_available') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('price') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="price" class="text full text-center autosavefield price-In" id="input_price_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'price') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('priceold') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="' . (date('D', $_daterange[$i]) == 'Sun' ? '' : 'fieldarea') . ' text-center">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" toField="price_old" class="text full text-center autosavefield price-In" id="input_price_old_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" type="text" value="' . $clsTourStartDate->getValue($_daterange[$i], $tour_id, 'price_old') . '" style="font-size:11px;">
								</td>';
            }
            $html .= '
						</tr>
						<tr>
							<td class="fieldarea">' . $core->get_Lang('active') . '</td>';
            for ($i = 0; $i < count($_daterange); $i++) {
                $html .= '<td class="fieldarea text-center" style="background:#D4D3E7 !important">
									<input data="' . $clsTourStartDate->getId($_daterange[$i], $tour_id) . '" ' . ($clsTourStartDate->checkIsActive($_daterange[$i], $tour_id) ? 'checked="checked"' : '') . ' id="chk_' . $_daterange[$i] . '_' . $tour_id . '" start_date="' . $_daterange[$i] . '" tour_id="' . $tour_id . '" value="1" type="checkbox" class="chkSell">
								</td>';
            }
            $html .= '
						</tr>
					</tbody>
				</table>
				';
        } else {
            $cond = "is_trash=0 and tour_id = '$tour_id'";
            if (!empty($pp_month) && !empty($pp_year)) {
                $start_date = $pp_month . '/01/' . $pp_year;
                $end_date = $pp_month . '/31/' . $pp_year;
                $cond .= " and start_date >= '" . strtotime($start_date) . "' and start_date <= '" . strtotime($end_date) . "'";
            }
            $cond .= " order by start_date asc";
            #
            $lstDepart = $clsTourStartDate->getAll($cond);
            $html .= '
				<table class="tbl-grid" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="gridheader"><strong>' . $core->get_Lang('Code') . '</strong></td>
						<td class="gridheader" style="text-align:left"><strong>' . $core->get_Lang('departuredate') . '</strong></td>
						<td class="gridheader" style="text-align:left"><strong>' . $core->get_Lang('enddate') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('allotment') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('soldout') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('seatavailable') . '</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('price') . ' (' . $clsISO->getRate() . ')</strong></td>
						<td class="gridheader"><strong>' . $core->get_Lang('oldprice') . ' (' . $clsISO->getRate() . ')</strong></td>
						<td class="gridheader" style="width:3%;text-align:center"><strong>' . $core->get_Lang('status') . '</strong></td>
					</tr>';
            if (!empty($lstDepart)) {
                for ($i = 0; $i < count($lstDepart); $i++) {
                    $html .= '<tr class="' . ($i % 2 == 0 ? 'row1' : 'row2') . '">';
                    $html .= '<td><a target="_blank" href="' . $clsTour->getLinkDetailStartDate($tour_id, $lstDepart[$i]['start_date']) . '">' . $clsTourStartDate->getTripCode($lstDepart[$i][$clsTourStartDate->pkey]) . '</a></td>';
                    $html .= '<td>' . $clsISO->formatDate($lstDepart[$i]['start_date']) . '</td>';
                    $html .= '<td>' . $clsISO->formatDate($clsTourStartDate->getEndDateDefault($lstDepart[$i][$clsTourStartDate->pkey])) . '</td>';
                    $html .= '<td>' . $lstDepart[$i]['allotment'] . '</td>';
                    $html .= '<td>' . $lstDepart[$i]['seat_sale'] . '</td>';
                    $html .= '<td>' . $lstDepart[$i]['seat_available'] . '</td>';
                    $html .= '<td>' . $clsISO->formatNumberToEasyRead($lstDepart[$i]['price']) . ' ' . $clsISO->getRate() . '</td>';
                    $html .= '<td>' . $clsISO->formatNumberToEasyRead($lstDepart[$i]['price_old']) . ' ' . $clsISO->getRate() . '</td>';
                    if ($clsTourStartDate->checkTourStartDate($tour_id, $lstDepart[$i]['start_date'])) {
                        $html .= '<td><span class="status_approved">' . $core->get_Lang('Sell') . '</span></td>';
                    } else {
                        $html .= '<td><span class="status_remove">' . $core->get_Lang('Sold out') . '</span></td>';
                    }
                    $html .= '</tr>';
                }
            }
            $html .= '</table>';
        }
        $html .= '</div>';
        echo $html;
        die();
    } else if ($tp == 'S') {
        $start_date = isset($_POST['start_date']) ? intval($_POST['start_date']) : 0;
        $is_active = isset($_POST['is_active']) ? intval($_POST['is_active']) : 0;
        #
        if ($is_active) {
            #
            $res = $clsTourStartDate->getAll("start_date = '$start_date' and tour_id = '$tour_id' limit 0,1");
            if ($res[0][$clsTourStartDate->pkey] == '') {
                $number_day = $clsTour->getOneField('number_day', $tour_id);
                $end_date = $start_date + ($number_day - 1) * 24 * 60 * 60;
                #
                $fx = "tour_start_date_id,user_id,user_id_update,tour_id,title,start_date,end_date,is_active,reg_date,upd_date";
                $vx = "'" . $clsTourStartDate->getMaxId() . "'
					,'$user_id'
					,'$user_id'
					,'$tour_id'
					,'$start_date'
					,'$start_date'
					,'$end_date'
					,'1'
					,'" . time() . "'
					,'" . time() . "'
					";
                #
                $clsTourStartDate->insertOne($fx, $vx);
            } else {
                $tour_start_date_id = $clsTourStartDate->getId($start_date, $tour_id);
                $clsTourStartDate->updateOne($tour_start_date_id, "is_active=1");
            }
        } else {
            $tour_start_date_id = $clsTourStartDate->getId($start_date, $tour_id);
            $clsTourStartDate->updateOne($tour_start_date_id, "is_active=0");
        }
        #
        echo (1);
        die();
    }
}

function default_openTag()
{
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO, $package_id;
    #
    $tour_id = Input::post('tour_id', 0);
    $smarty->assign('tour_id', $tour_id);
    // Return
    $smarty->assign('core', $core);
    $html = $core->build('_ajax.tag.tpl');
    echo $html;
    die();
}

function default_ajSaveTag()
{
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO, $package_id, $oneProfile;
    $clsTag = new Tag();
    $tour_id = (int)Input::post('tour_id', 0);
    $tag_id = (int)Input::post('tag_id', 0);
    $title = Input::post('title', '');
    $msg = '_error';
    if ($tag_id > 0) {
        if ($clsTag->countItem("slug='" . $core->replaceSpace($title) . "' and tag_id<>'{$tag_id}'") == 0) {
            $msg = '_ok';
            $clsTag->update($tag_id, array(
                'title' => $title,
                'slug' => $core->replaceSpace($title)
            ));
        } else {
            $msg = '_exist';
        }
    } else {
        if ($clsTag->countItem("slug='" . $core->replaceSpace($title) . "'") == 0) {
            $msg = '_ok';
            $clsTag->insert(array(
                'title' => $title,
                'slug' => $core->replaceSpace($title)
            ));
        } else {
            $msg = '_exist';
        }
    }
    // Return
    echo $msg;
    die();
}

function default_openTourCategory()
{
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL ^ E_NOTICE);
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO, $package_id;
    $clsTourCategory = new TourCategory();
    #
    $cat_id = Input::post('cat_id', 0);
    $tour_id = Input::post('tour_id', 0);
    $smarty->assign('cat_id', $cat_id);
    $smarty->assign('tour_id', $tour_id);
    #
    $oneCat = array();
    if (!empty($cat_id)) {
        $oneCat = $clsTourCategory->getOne($cat_id);
    }
    $smarty->assign('oneCat', $oneCat);
    // Return
    $smarty->assign('core', $core);
    $smarty->assign('template', '_form');
    $html = $core->build('_ajax.category.tpl');
    echo $html;
    die();
}

function default_ajSaveTourCategory()
{
    global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO, $package_id, $oneProfile;
    $clsTour = new Tour();
    $clsTourCategory = new TourCategory();
    $cat_id = (int)Input::post('cat_id', 0);
    $tour_id = (int)Input::post('tour_id', 0);
    $title = Input::post('title', '');
    #
    $msg = '_error';
    if (!empty($cat_id)) {
        if ($clsTourCategory->countItem("is_trash=0 and slug='" . $core->replaceSpace($title) . "' and tourcat_id<>{$cat_id}") == 0) {
            $msg = '_ok';
            $clsTourCategory->update($cat_id, array(
                "title" => $title,
                "slug" => $core->replaceSpace($title)
            ));
        } else {
            $msg = '_exist';
        }
    } else {
        //$clsTourCategory->setDebug(true);
        if ($clsTourCategory->countItem("is_trash=0 and slug='" . $core->replaceSpace($title) . "'") == 0) {
            $msg = '_ok';
            $tourcat_id = $clsTourCategory->getMaxId();
            $clsTourCategory->insert(array(
                "tourcat_id" => $tourcat_id,
                "title" => $title,
                "slug" => $core->replaceSpace($title),
                'order_no' => $clsTourCategory->getMaxOrderNo(),
                "reg_date" => time(),
                "upd_date" => time(),
                "is_online" => 1
            ));
        } else {
            $msg = '_exist';
        }
    }
    // Return
    echo $msg;
    die();
}

function default_ajChangeHasPackage()
{
    global $core, $clsISO, $clsConfiguration, $assign_list, $clsModule, $clsISO, $package_id;

    $clsTour = new Tour();

    $pvalTable = $_POST['tour_id'] ?? 0;
    $has_package = $_POST['has_package'] ?? 0;
    $oneItem = $clsTour->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;

    $result = array('result' => '_ERR');
    $value = 'has_package=' . $has_package;

    if ($clsTour->updateOne($pvalTable, $value)) {
        $result = array('result' => '_SUCCESS');
    }

    echo json_encode($result);
    die();
}

function default_list_tour_agent()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $clsISO;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    /*Get type of list news*/
    $type_list = isset($_GET['type_list']) ? $_GET['type_list'] : '';
    $assign_list["type_list"] = $type_list;
    /**/
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
            $link .= '&keyword=' . $_POST['keyword'];
        }
        if (isset($link)) {
            header('location: ' . PCMS_URL . '/?mod=' . $mod . "&act=$act" . $link);
        }
    }
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $assign_list["pkeyTable"] = $pkeyTable;

    /*List all item*/
    $cond = "is_for_agent = 1";
    #Filter By Keyword
    if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
        $cond .= " and (slug like '%" . $core->replaceSpace($_GET['keyword']) . "%' or title like '%" . $_GET['keyword'] . "%')";
        $assign_list["keyword"] = $_GET['keyword'];
    }
    $cond2 = $cond;
    if ($type_list == 'Active') {
        $cond .= " and is_trash=0";
    }
    if ($type_list == 'Trash') {
        $cond .= " and is_trash=1";
    }
    $orderBy = " order_no asc";

    #-------Page Divide---------------------------------------------------------------
    $recordPerPage = isset($_GET["recordperpage"]) ? $_GET["recordperpage"] : ADMIN_PAGINATION;
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

    #
    $allTrash = $clsClassTable->getAll("is_trash=1 and " . $cond2);
    $assign_list["number_trash"] = $allTrash[0][$pkeyTable] != '' ? count($allTrash) : 0;
    #
    $allUnTrash = $clsClassTable->getAll("is_trash=0 and " . $cond2);
    $assign_list["number_item"] = $allUnTrash[0][$pkeyTable] != '' ? count($allUnTrash) : 0;
    #
    $allAll = $clsClassTable->getAll($cond);
    $assign_list["number_all"] = $allAll[0][$pkeyTable] != '' ? count($allAll) : 0;;

    unset($allItem);
}

function default_tour_agent()
{
    global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration, $pvalTable, $clsClassTable;
    $assign_list["clsModule"] = $clsModule;
    $user_id = $core->_USER['user_id'];
    #
    $classTable = "Tour";
    $clsClassTable = new $classTable;
    $tableName = $clsClassTable->tbl;
    $pkeyTable = $clsClassTable->pkey;
    $assign_list["clsClassTable"] = $clsClassTable;
    $clsCountry = new Country();
    $assign_list["clsCountry"] = $clsCountry;
    #

    $pvalTable = !empty($_GET['tour_id']) ? $_GET['tour_id'] : 0;
    $assign_list['pvalTable'] = $pvalTable;
    $oneItem = $clsClassTable->getOne($pvalTable);
    $assign_list["oneItem"] = $oneItem;
    #
    if (empty($pvalTable)) {
        header('location:' . PCMS_URL . '/index.php?mod=' . $mod . '&message=notPermission');
    }

    $pUrl = '&act=list_tour_agent';
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
            #

            if ($clsClassTable->updateOne($pvalTable, $set)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=' . $act . '&' . $clsClassTable->pkey . '=' . $_GET[$clsClassTable->pkey] . '&message=updateSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=updateFailed');
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
            #
            $title = $_POST['title'];
            $title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");
            $field .= ",user_id,user_id_update,reg_date,upd_date,title,slug,$clsClassTable->pkey,order_no";
            $value .= ",'" . addslashes($core->_SESS->user_id) . "','" . addslashes($core->_SESS->user_id) . "','" . time() . "','" . time() . "'";
            $value .= ",'" . $title . "','" . $core->replaceSpace($_POST['title']) . "','" . $max_id . "','1'";
            $is_online = $_POST['is_online'] ?? 0;
            $field .= ',is_online';
            $value .= ",'" . $is_online . "'";
            #
            if ($clsClassTable->insertOne($field, $value)) {
                if ($_POST['button'] == '_EDIT') {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . '&act=edit&' . $clsClassTable->pkey . '=' . $core->encryptID($max_id) . '&message=insertSuccess');
                } else {
                    header('location: ' . PCMS_URL . '/?mod=' . $mod . $pUrl . '&message=insertSuccess');
                }
            } else {
                header('location: ' . PCMS_URL . '/?mod=' . $mod . '&message=insertFailed');
            }
        }
    }
}
function default_ajmakeSelectMarket()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;
    $clsProperty = new Property();
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : 0;
    $market_id     = isset($_POST['market_id']) ? $_POST['market_id'] : 0;
    $html = '';
    if ($country_id > 0) {
        $lstMarket = $clsProperty->getAll("is_trash=0 and country_id='$country_id' and type='Market' and parent_id='0'", $clsProperty->pkey . ',title');
        $html .= '<option value="0">' . $core->get_Lang('Choose market') . '</option>';
        foreach ($lstMarket as $key => $value) {
            $html .= '<option  value="' . $value['property_id'] . '" ' . (($value['property_id'] == $market_id) ? "selected" : "") . '>' . $value['title'] . '</option>';
        }
        echo $html;
    } else {
        echo "EMPTY";
        die;
    }
}
function default_ajmakeSelectTypeMarket()
{
    global $dbconn, $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $core, $clsModule;
    global $clsConfiguration;

    $clsProperty = new Property();
    $market_type_id = isset($_POST['market_type_id']) ? $_POST['market_type_id'] : 0;
    $market_id     = isset($_POST['market_id']) ? $_POST['market_id'] : 0;
    $html = '';
    if ($market_id > 0) {
        $lstMarketType = $clsProperty->getAll("is_trash=0 and type='Market' and parent_id='$market_id'", $clsProperty->pkey . ',title');
        $html .= '<option value="">' . $core->get_Lang('Choose market type') . '</option>';
        foreach ($lstMarketType as $key => $value) {
            $html .= '<option  value="' . $value['property_id'] . '" ' . (($value['property_id'] == $market_type_id) ? "selected" : "") . '>' . $value['title'] . '</option>';
        }
        echo $html;
    } else {
        echo "EMPTY";
        die;
    }
}
