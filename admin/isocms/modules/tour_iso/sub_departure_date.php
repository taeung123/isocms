<?php
function default_loadCalendarSlot()
{
	global $smarty, $_frontIsLoggedin_user_id, $core, $clsISO, $package_id, $oneProfile;
	$clsTour = new Tour();
	$clsTourStartDate = new TourStartDate();
	#
	$timer = time();
	$tour_id = (int) Input::post('tour_id', 0);
	$start = Input::post('start');
	$end = Input::post('end');
	$start_time = strtotime($start);
	$end_time = strtotime($end);
	//$clsISO->print_pre($start_time); die();
	$results = array();
	for ($i = $start_time; $i < $end_time; $i = strtotime('+1 day', $i)) {
		$year = date("Y", $i);
		$month = date('m', $i);
		$day = date('d', $i);
		$Day = date('D', $i);

		$flag = 0;
		$listItem = $clsTourStartDate->getAll("is_single='1' and tour_id='{$tour_id}' and start_date='{$i}'");
		if (empty($listItem)) {
			$listItem = $clsTourStartDate->getAll("is_single='0' and weekdays like '%" . $Day . "%' and tour_id='{$tour_id}' and start_date<='{$i}' and end_date>='{$i}'");

			$weekdays = $listItem[0]['weekdays'];
			$weekdays_arr = !empty($weekdays) ? @json_decode($weekdays, true) : array();
			if (in_array(date('D', $i), $weekdays_arr)) {
				$flag = 1;
			}
		} else {
			$flag = 1;
		}
		$allotment = $listItem[0]['allotment'];
		if ($allotment == null) {
			$txt_allotment = 'Không giới hạn chỗ';
		} else {
			$txt_allotment = 'Còn 0/' . $allotment . ' chỗ';
		}
		if ($flag == 1) {
			$html = '<div class="iso_departure_date_delete"> <input name="delete_id[]" class="iso_checkbox_departure" type="checkbox" value="' . $listItem[0][$clsTourStartDate->pkey] . '" /> </div><p class="mb-half">' . $core->get_Lang('Departure') . '</p>
					<h3 class="fs-18 mb-half">' . $clsTour->getTitleDepartureType($listItem[0]['departure_type']) . '</h3>
					<p class="text-muted">' . $txt_allotment . '</p>
					<p><a class="btn-edit" data-date_id="' . $i . '" data-tour_id="' . $tour_id . '" data-openFrom="calendar"  data-tour_start_date_id="' . $listItem[0][$clsTourStartDate->pkey] . '" onClick="edit_departure_date(this)">Sửa khởi hành</a></p>
					<p><a class="btn-delete color_f00" data-tour_start_date_id="' . $listItem[0][$clsTourStartDate->pkey] . '" onClick="delete_departure(this)">Xóa khởi hành</a></p>
				';
			$results[] = array(
				'number' => 1,
				'date_id' => $i,
				'title' => PAGE_NAME,
				'tour_id' => $tour_id,
				'is_active' => $listItem[0]['is_active'],
				'start' => date('Y-m-d', $i) . " 00:00:00",
				'end' => date('Y-m-d', $i) . " 23:59:59",
				'tour_start_date_id' => $listItem[0][$clsTourStartDate->pkey],
				'html' => $html,
			);
		} else {
			$results[] = array(
				'number' => 0,
				'date_id' => $i,
				'title' => PAGE_NAME,
				'tour_id' => $tour_id,
				'start' => date('Y-m-d', $i) . " 00:00:00",
				'end' => date('Y-m-d', $i) . " 23:59:59",
				'html' => ($i > $timer ? '<a class="btn btn-default btn-sm" onClick="open_departure_date(this)" openFrom="calendar" date_id="' . $i . '" tour_id="' . $tour_id . '">+ ' . $core->get_Lang('Add Departure') . '</a>' : '')
			);
		}
	}
	// Output
	echo @json_encode($results);
	die();
}
function default_open_departure_date()
{
	global $smarty, $core, $dbconn, $_LANG_ID, $clsConfiguration, $clsISO, $package_id;
	global $adult_type_id, $child_type_id, $infant_type_id;
	$clsTour = new Tour();
	$clsTourOption = new TourOption();
	$clsTourProperty = new TourProperty();
	$clsTourStartDate = new TourStartDate();
	#
	$tour_id = (int) Input::post('tour_id', 0);
	$date_id = (int) Input::post('date_id', 0);
	$openFrom  = Input::post('openFrom', "general");
	$tour_start_date_id = (int) Input::post('tour_start_date_id', 0);

	$hs = 0;
	if ($tour_start_date_id > 0) {
		$titlePage = $core->get_Lang('Edit Departure');
		$oneItem = $clsTourStartDate->getOne($tour_start_date_id);
		$weekdays_arr = !empty($oneItem['weekdays'])
			? @json_decode($oneItem['weekdays'], true) : array();
		if ((int) $oneItem['ruler_type'] == 1) {
			$oneItem['date_id'] = $date_id;
		} else {
			$hs = 1;
			$openFrom = 'calendar';
			$oneItem['date_id'] = $oneItem['start_date'];
		}

		//print_r($oneItem);die();

	} else {
		$weekdays_arr = array();
		$titlePage = $core->get_Lang('Add Departure');
		$oneItem = array('ruler_type' => 1, 'price_type' => 0, 'date_id' => $date_id, 'price' => "", 'price_single_supply' => 0);
	}
	$smarty->assign('hs', $hs);
	$smarty->assign('tour_id', $tour_id);
	$smarty->assign('date_id', $date_id);
	$smarty->assign('oneItem', $oneItem);
	$smarty->assign('titlePage', $titlePage);

	$smarty->assign('tour_start_date_id', $tour_start_date_id);
	$smarty->assign('weekdays_arr', $weekdays_arr);
	$smarty->assign('openFrom', $openFrom);
	#
	$list_months = array();
	for ($i = 1; $i <= 12; $i++) {
		$list_months[] = $i;
	}
	$smarty->assign('list_months', $list_months);
	#
	$lstDay = $weekdays_arr = array(
		'Mon' => 'Mo',
		'Tue' => 'Tu',
		'Wed' => 'We',
		'Thu' => 'Th',
		'Fri' => 'Fr',
		'Sat' => 'Sa',
		'Sun' => 'Su'
	);
	$smarty->assign('lstDay', $lstDay);
	#
	$listType = $clsTour->getListDepartureType();
	$smarty->assign('listType', $listType);
	#
	$listPaymentDue = array(
		1 => array(
			'title' => $core->get_Lang('Scheduled'),
			'subtitle' => $core->get_Lang('Before using the service')
		),
		2 => array(
			'title' => $core->get_Lang('On Request'),
			'subtitle' => $core->get_Lang('First day of travel')
		),
		3 => array(
			'title' => $core->get_Lang('Guaranteed'),
			'subtitle' => $core->get_Lang('Before the end of the tour')
		),
		4 => array(
			'title' => $core->get_Lang('Closed'),
			'subtitle' => $core->get_Lang('At the end of the tour')
		),
		5 => array(
			'title' => $core->get_Lang('Closed'),
			'subtitle' => $core->get_Lang('After going on the tour')
		)
	);
	$smarty->assign('listPaymentDue', $listPaymentDue);
	#
	$lstTourVisitorType  = $clsTourProperty->getAll("is_trash=0 and type='VISITORTYPE' order by tour_property_id ASC", $clsTourProperty->pkey);

	$oneTour = $clsTour->getOne($tour_id, "tour_option,adult_group_size,child_group_size,infant_group_size,visitorage_child,visitorage_infant,visitorheight_child,visitorheight_infant");
	$lstOption = !empty($oneTour['tour_option'])
		? $clsISO->getArrayByTextSlash($oneTour['tour_option']) : array();
	$lstAdultSize = !empty($oneTour['adult_group_size'])
		? $clsISO->getArrayByTextSlash($oneTour['adult_group_size']) : array();
	/*$lstChildSize = !empty($oneTour['child_group_size']) 
		? $clsISO->getArrayByTextSlash($oneTour['child_group_size']) : array();
	$lstInfantSize = !empty($oneTour['infant_group_size']) 
		? $clsISO->getArrayByTextSlash($oneTour['infant_group_size']) : array();*/
	$lstChildSize = !empty($oneTour['child_group_size'])
		? explode("|", trim($oneTour['child_group_size'], "|")) : array();
	$lstInfantSize = !empty($oneTour['infant_group_size'])
		? explode("|", trim($oneTour['infant_group_size'], "|")) : array();

	$total_adult_group_size = !empty($lstAdultSize) ? count($lstAdultSize) : 0;
	$total_child_group_size = !empty($lstChildSize) ? count($lstChildSize) : 0;
	$total_infant_group_size = !empty($lstInfantSize) ? count($lstInfantSize) : 0;

	$visitorage_child = !empty($oneTour['visitorage_child']) ? $clsISO->getArrayByTextSlash($oneTour['visitorage_child']) : array();
	$visitorage_infant = !empty($oneTour['visitorage_infant']) ? $clsISO->getArrayByTextSlash($oneTour['visitorage_infant']) : array();
	$total_visitorage_child = !empty($visitorage_child) ? count($visitorage_child) : 0;
	$total_visitorage_infant = !empty($visitorage_infant) ? count($visitorage_child) : 0;

	$visitorheight_child = !empty($oneTour['visitorheight_child']) ? $clsISO->getArrayByTextSlash($oneTour['visitorheight_child']) : array();
	$visitorheight_infant = !empty($oneTour['visitorheight_infant']) ? $clsISO->getArrayByTextSlash($oneTour['visitorheight_infant']) : array();
	$total_visitorheight_child = !empty($visitorheight_child) ? count($visitorheight_child) : 0;
	$total_visitorheight_infant = !empty($visitorheight_infant) ? count($visitorheight_infant) : 0;

	$htmlPriceTable = '';
	if (!empty($lstOption)) {
		$price = $oneItem['price'];
		$price_arr = !empty($price) ? @json_decode($price, true) : array();
		$price_type_rate = $oneItem['price_type_rate'];
		$price_type_rate_arr = !empty($price_type_rate) ? @json_decode($price_type_rate, true) : array();
		foreach ($lstOption as $key => $val) {
			$htmlPriceTable .= '<div class="table-wrapper mb-3 w-100 radius-3">
				<table class="table table-bordered mb-0 overflow-hidden radius-3">
				<tr class="bg-gray">
					<td colspan="4" width="30%">' . $clsTourOption->getTitle($val) . '</td>
				</tr>';
			foreach ($lstTourVisitorType as $a => $b) {
				if ($b[$clsTourProperty->pkey] == $adult_type_id && $total_adult_group_size > 0) {
					$htmlPriceTable .= '<tr>
						<td rowspan="' . ($total_adult_group_size + 1) . '" width="25%">
							' . $clsTourProperty->getTitle($b[$clsTourProperty->pkey]) . '
						</td>
					</tr>';
					foreach ($lstAdultSize as $k1 => $v1) {
						$price_adult = isset($price_arr[$adult_type_id][$val][$v1]) ? $price_arr[$adult_type_id][$val][$v1] : "";
						$htmlPriceTable .= '<tr>
							<td width="25%" colspan="2">' . $clsTourOption->getTitle($v1) . '</td>
							<td>
								<div class="input-group">
									<input type="text" class="form-control price-In numberonly" name="adult[' . $val . '][' . $v1 . ']" value="' . $price_adult . '" placeholder="0" />
									<span class="input-group-addon">' . $clsISO->getRate() . '</span>
								</div>
							</td>
						</tr>';
						unset($price_adult);
					}
				} else if ($b[$clsTourProperty->pkey] == $child_type_id && $total_child_group_size > 0) {
					$child_group_size = !empty($oneTour['child_group_size']) ? $clsISO->getArrayByTextSlash($oneTour['child_group_size']) : array();
					$total_child_group_size = !empty($child_group_size) ? count($child_group_size) : 0;
					$htmlPriceTable .= '<tr>
						<td rowspan="' . ($total_child_group_size + 1) . '" width="25%">
							' . $clsTourProperty->getTitle($b[$clsTourProperty->pkey]) . '
						</td>
					</tr>';

					foreach ($lstChildSize as $k2 => $v2) {
						if (count($visitorage_child) > 0) {
							$oneAge = $clsTourOption->getOne($visitorage_child[$k2], 'title');
							if ($oneAge) {
								$title_age = $oneAge['title'];
								$listChildSizeAge = explode(",", $v2);
								for ($i = 0; $i < count($listChildSizeAge); $i++) {
									$htmlPriceTable .= '<tr>';
									if ($i == 0) {
										$htmlPriceTable .= '<td class="text-left age" rowspan="' . count($listChildSizeAge) . '">' . $title_age . '</td>';
									}
									$price_child = isset($price_arr[$child_type_id][$val][$visitorage_child[$k2]][$listChildSizeAge[$i]]) ? $price_arr[$child_type_id][$val][$visitorage_child[$k2]][$listChildSizeAge[$i]] : "";
									$htmlPriceTable .= '
										<td class="text-left">' . $clsTourOption->getTitle($listChildSizeAge[$i]) . '</td>
										<td class="text-left">
											<div class="input-group">
											<input type="text" class="form-control price_child price-In numberonly" name="child[' . $val . '][' . $listChildSizeAge[$i] . ']" placeholder="0" value="' . $price_child . '" tour_visitor_age_type_id="' . $visitorage_child[$k2] . '" tour_visitor_height_type_id="0" tour_class_id="' . $val . '" tour_number_group_id="' . $listChildSizeAge[$i] . '" />';

									$price_type_rate = isset($price_type_rate_arr[$val][$visitorage_child[$k2]][$listChildSizeAge[$i]]) ? $price_type_rate_arr[$val][$visitorage_child[$k2]][$listChildSizeAge[$i]] : 0;
									$htmlPriceTable .= '<span class="input-group-addon select_group_addon">
												<select class="price_type_departure price_type_departure_child" name="price_type_rate[' . $val . '][' . $listChildSizeAge[$i] . ']" tour_visitor_age_type_id="' . $visitorage_child[$k2] . '" tour_visitor_height_type_id="0" ' . $price_type_rate . ' style="height:100%">
													<option value="0" ' . (($price_type_rate == 0) ? "selected" : "") . ' >' . $clsISO->getRate() . '</option>
													<option value="1" ' . (($price_type_rate == 1) ? "selected" : "") . ' >%</option>
												</select>
											</span>';
									unset($price_type_rate, $price_child);

									$htmlPriceTable .= '
										</div>	
									</td></tr>';
								}
							}
							unset($oneAge);
						} elseif (count($visitorheight_child) > 0) {
							$oneHeight = $clsTourOption->getOne($visitorheight_child[$k2], 'title');
							if ($oneHeight) {
								$title_height = $oneHeight['title'];
								$listChildSizeHeight = explode(",", $v2);
								for ($i = 0; $i < count($listChildSizeHeight); $i++) {
									$htmlPriceTable .= '<tr>';
									if ($i == 0) {
										$htmlPriceTable .= '<td class="text-left height" rowspan="' . count($listChildSizeHeight) . '">' . $title_height . '</td>';
									}
									$price_child = isset($price_arr[$child_type_id][$val][$visitorheight_child[$k2]][$listChildSizeHeight[$i]]) ? $price_arr[$child_type_id][$val][$visitorheight_child[$k2]][$listChildSizeHeight[$i]] : "";
									$htmlPriceTable .= '
										<td class="text-left">' . $clsTourOption->getTitle($listChildSizeHeight[$i]) . '</td>
										<td class="text-left">
											<div class="input-group">
											<input type="text" class="form-control price_child price-In numberonly" name="child[' . $val . '][' . $listChildSizeHeight[$i] . ']" placeholder="0" value="' . $price_child . '" tour_visitor_height_type_id="' . $visitorheight_child[$k2] . '" tour_visitor_age_type_id="0" tour_class_id="' . $val . '" tour_number_group_id="' . $listChildSizeHeight[$i] . '" />';

									$price_type_rate = isset($price_type_rate_arr[$val][$visitorheight_child[$k2]][$listChildSizeHeight[$i]]) ? $price_type_rate_arr[$val][$visitorheight_child[$k2]][$listChildSizeHeight[$i]] : 0;
									$htmlPriceTable .= '<span class="input-group-addon select_group_addon">
												<select class="price_type_departure price_type_departure_child" name="price_type_rate[' . $val . '][' . $listChildSizeHeight[$i] . ']" tour_visitor_height_type_id="' . $visitorheight_child[$k2] . '" tour_visitor_age_type_id="0" ' . $price_type_rate . ' style="height:100%">
													<option value="0" ' . (($price_type_rate == 0) ? "selected" : "") . ' >' . $clsISO->getRate() . '</option>
													<option value="1" ' . (($price_type_rate == 1) ? "selected" : "") . ' >%</option>
												</select>
											</span>';
									unset($price_type_rate, $price_child);

									$htmlPriceTable .= '
										</div>	
									</td></tr>';
								}
							}
							unset($oneHeight);
						}

						/*$price = isset($price_arr[$adult_type_id][$val][$v1]) ? $price_arr[$child_type_id][$val][$v2] : "";
						$htmlPriceTable .= '<tr>
							<td width="25%">'.$clsTourOption->getTitle($v2).'</td>
							<td>
								<div class="input-group">
									<input type="text" class="form-control price-In numberonly" name="child['.$val.']['.$v2.']" placeholder="0.00" value="'.$price.'" />
									<span class="input-group-addon">'.$clsISO->getRate().'</span>
								</div>
							</td>
						</tr>';*/
					}
				} else if ($b[$clsTourProperty->pkey] == $infant_type_id  && $total_infant_group_size > 0) {
					$infant_group_size = !empty($oneTour['infant_group_size']) ? $clsISO->getArrayByTextSlash($oneTour['infant_group_size']) : array();
					$total_infant_group_size = !empty($infant_group_size) ? count($infant_group_size) : 0;
					$htmlPriceTable .= '<tr>
						<td rowspan="' . ($total_infant_group_size + 1) . '" width="25%">
							' . $clsTourProperty->getTitle($b[$clsTourProperty->pkey]) . '
						</td>
					</tr>';
					foreach ($lstInfantSize as $k3 => $v3) {
						if (count($visitorage_infant) > 0) {
							$oneAge = $clsTourOption->getOne($visitorage_infant[$k3], 'title');
							if ($oneAge) {
								$title_age = $oneAge['title'];
								$listInfantSizeAge = explode(",", $v3);
								//							var_dump($listInfantSizeAge);
								for ($i = 0; $i < count($listInfantSizeAge); $i++) {
									$price_infant = isset($price_arr[$infant_type_id][$val][$visitorage_infant[$k3]][$listInfantSizeAge[$i]]) ? $price_arr[$infant_type_id][$val][$visitorage_infant[$k3]][$listInfantSizeAge[$i]] : "";
									$htmlPriceTable .= '<tr>';
									if ($i == 0) {
										$htmlPriceTable .= '<td class="text-left age" rowspan="' . count($listInfantSizeAge) . '">' . $title_age . '</td>';
									}

									$htmlPriceTable .= '
										<td class="text-left">' . $clsTourOption->getTitle($listInfantSizeAge[$i]) . '</td>
										<td class="text-left">
											<div class="input-group">
												<input type="text" class="form-control price-In price_infant numberonly" name="infant[' . $val . '][' . $listInfantSizeAge[$i] . ']" placeholder="0" value="' . $price_infant . '" tour_visitor_age_type_id="' . $visitorage_infant[$k3] . '" tour_visitor_height_type_id="0" tour_class_id="' . $val . '" tour_number_group_id="' . $listInfantSizeAge[$i] . '" />';

									$price_type_rate = isset($price_type_rate_arr[$val][$visitorage_infant[$k3]][$listInfantSizeAge[$i]]) ? $price_type_rate_arr[$val][$visitorage_infant[$k3]][$listInfantSizeAge[$i]] : 0;
									$htmlPriceTable .= '<span class="input-group-addon select_group_addon">
												<select class="price_type_departure price_type_departure_infant" name="price_type_rate[' . $val . '][' . $listInfantSizeAge[$i] . ']" tour_visitor_age_type_id="' . $visitorage_infant[$k3] . '" tour_visitor_height_type_id="0" ' . $price_type_rate . ' style="height:100%">
													<option value="0" ' . (($price_type_rate == 0) ? "selected" : "") . ' >' . $clsISO->getRate() . '</option>
													<option value="1" ' . (($price_type_rate == 1) ? "selected" : "") . ' >%</option>
												</select>
											</span>';
									unset($price_type_rate, $price_infant);
									$htmlPriceTable .= '</div>
										</td>
									</tr>';
								}
							}
							unset($oneAge, $age_infant);
						} elseif (count($visitorheight_infant) > 0) {
							$oneHeight = $clsTourOption->getOne($visitorheight_infant[$k3], 'title');
							if ($oneHeight) {
								$title_height = $oneHeight['title'];
								$listInfantSizeAge = explode(",", $v3);
								//							var_dump($listInfantSizeAge);
								for ($i = 0; $i < count($listInfantSizeAge); $i++) {
									$price_infant = isset($price_arr[$infant_type_id][$val][$visitorheight_infant[$k3]][$listInfantSizeAge[$i]]) ? $price_arr[$infant_type_id][$val][$visitorheight_infant[$k3]][$listInfantSizeAge[$i]] : "";
									$htmlPriceTable .= '<tr>';
									if ($i == 0) {
										$htmlPriceTable .= '<td class="text-left height" rowspan="' . count($listInfantSizeAge) . '">' . $title_height . '</td>';
									}

									$htmlPriceTable .= '
										<td class="text-left">' . $clsTourOption->getTitle($listInfantSizeAge[$i]) . '</td>
										<td class="text-left">
											<div class="input-group">
												<input type="text" class="form-control price-In price_infant numberonly" name="infant[' . $val . '][' . $listInfantSizeAge[$i] . ']" placeholder="0" value="' . $price_infant . '" tour_visitor_height_type_id="' . $visitorheight_infant[$k3] . '" tour_visitor_age_type_id="0" tour_class_id="' . $val . '" tour_number_group_id="' . $listInfantSizeAge[$i] . '" />';

									$price_type_rate = isset($price_type_rate_arr[$val][$visitorheight_infant[$k3]][$listInfantSizeAge[$i]]) ? $price_type_rate_arr[$val][$visitorheight_infant[$k3]][$listInfantSizeAge[$i]] : 0;
									$htmlPriceTable .= '<span class="input-group-addon select_group_addon">
												<select class="price_type_departure price_type_departure_infant" name="price_type_rate[' . $val . '][' . $listInfantSizeAge[$i] . ']" tour_visitor_height_type_id="' . $visitorheight_infant[$k3] . '" tour_visitor_age_type_id="0" ' . $price_type_rate . ' style="height:100%">
													<option value="0" ' . (($price_type_rate == 0) ? "selected" : "") . ' >' . $clsISO->getRate() . '</option>
													<option value="1" ' . (($price_type_rate == 1) ? "selected" : "") . ' >%</option>
												</select>
											</span>';
									unset($price_type_rate, $price_infant);
									$htmlPriceTable .= '</div>
										</td>
									</tr>';
								}
							}
							unset($oneHeight);
						}
						/*$price = isset($price_arr[$adult_type_id][$val][$v1]) ? $price_arr[$infant_type_id][$val][$v3] : "";
						$htmlPriceTable .= '<tr>
							<td width="25%">'.$clsTourOption->getTitle($v3).'</td>
							<td>
								<div class="input-group">
									<input type="text" class="form-control price-In numberonly" name="infant['.$val.']['.$v3.']" placeholder="0.00" value="'.$price.'" />
									<span class="input-group-addon">'.$clsISO->getRate().'</span>
								</div>
							</td>
						</tr>';*/
					}
				}
			}
			$htmlPriceTable .= '</table></div>';
		}
		$htmlPriceTable .= '<div class="price_single_supply w-100">
			<div class="row">
				<label class="col-form-label col-md-6 text-left">' . $core->get_Lang('Single-Room Addition') . '</label>
				<div class="col-md-6">
					<div class="input-group">
						<input type="text" class="form-control price-In numberonly price_single_supply" name="price_single_supply" value="' . $clsISO->formatPrice($oneItem['price_single_supply']) . '" placeholder="0">
						<span class="input-group-addon">' . $clsISO->getRate() . '</span>
					</div>
				</div>
			</div>
		</div>';
	}
	$smarty->assign('htmlPriceTable', $htmlPriceTable);

	// Returtn
	$smarty->assign('core', $core);
	$html = $clsISO->build('_ajax.departure_date.tpl');

	$callback = "";
	echo @json_encode(array(
		'html' => $html,
		'callback' => $callback
	));
	die();
}
function default_delete_departure()
{
	global $smarty, $core, $dbconn, $_LANG_ID, $clsConfiguration, $clsISO, $package_id;
	global $adult_type_id, $child_type_id, $infant_type_id;

	$clsTourStartDate = new TourStartDate();
	$openFrom  = Input::post('openFrom', "general");
	$tour_start_date_id = (int) Input::post('tour_start_date_id', 0);

	if ($clsTourStartDate->deleteOne($tour_start_date_id)) {
		$msg = '_success';
	} else {
		$msg = '_error';
	}
	echo @json_encode(array(
		'msg' => $msg
	));
	die();
}

function default_pop_save_departure_date()
{
	global $smarty, $core, $dbconn, $_LANG_ID, $clsConfiguration, $clsISO, $package_id;
	global $adult_type_id, $child_type_id, $infant_type_id;
	$clsTour = new Tour();
	$clsTourOption = new TourOption();
	$clsTourProperty = new TourProperty();
	$clsTourStartDate = new TourStartDate();
	#
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL & ~E_STRICT);
	$tour_id = (int) Input::post('tour_id', 0);
	$openFrom  = Input::post('openFrom', "general");
	$tour_start_date_id = Input::post('tour_start_date_id', 0);

	$ruler_type = (int) Input::post('ruler_type', 0);
	$departure_type = (int) Input::post('departure_type', 0);
	$time_for_payment = (int) Input::post('time_for_payment', 0);
	$price_type = (int) Input::post('price_type', 0);
	$allotment = Input::post('allotment', '');
	$deposit = Input::post('deposit', 0);
	$is_last_hour = Input::post('is_last_hour', 0);
	$is_active = Input::post('is_active', 1);

	if ($ruler_type == 1) {
		$weekdays_post = Input::post('weekdays');
	}

	$lst_date_id = array();

	if ($tour_start_date_id == 0) {
		//Lấy dữ liệu khi thêm mới
		if ($ruler_type == 1) {
			//Trường hợp là khởi hành vào khoảng thời gian được chọn
			//Lấy dữ liệu khoảng thời gian và các ngày khởi hành trong tuần
			$start_date = Input::post('start_date');
			$due_date = Input::post('due_date');
			$start_time = $clsISO->convertTextToTime2($start_date);
			$due_time = $clsISO->convertTextToTime2($due_date, "23:59:59");

			//Kiểm tra ngày bắt đầu và ngày kết thúc của khoảng thời gian
			if ($start_time > $due_time) {
				echo '_invalid|' . $core->get_Lang('Invalid period');
				die();
			}

			$list_date = $clsISO->getDateRange($start_date, $due_date);
		} else {
			//Trường hợp khởi hành vào ngày nhất định
			$date_id = Input::post('date_id', '');
			$list_date = explode(', ', $date_id);
		}

		foreach ($list_date as $val) {
			$weekdays = array();
			$start_time = $clsISO->convertTextToTime2($val, "00:00:00");
			$due_time = $clsISO->convertTextToTime2($val, "23:59:59");
			$weekdays[] = date("D", $start_time);
			$lst_date_id[] = array(
				'start_time' => $start_time,
				'due_time' => $due_time,
				'weekdays' => $weekdays,
			);
		}
	}

	//check validate time
	$price = array();
	if ($price_type == 1) {
		$data_price_child = Input::post('data_price_child', array());
		$data_price_child = json_decode(html_entity_decode($data_price_child));
		$data_price_infant = Input::post('data_price_infant', array());
		$data_price_infant = json_decode(html_entity_decode($data_price_infant));
		$adult = Input::post('adult', array());

		$child = Input::post('child', array());
		$infant = Input::post('infant', array());
		$price[$adult_type_id] = $adult;

		$child = $price_type_rate = $infant = [];
		foreach ($data_price_child as $key => $value) {
			if ($value->tour_visitor_age_type_id > 0) {
				$child[$value->tour_class_id][$value->tour_visitor_age_type_id][$value->tour_number_group_id] = $value->price;
				$price_type_rate[$value->tour_class_id][$value->tour_visitor_age_type_id][$value->tour_number_group_id] = $value->price_type;
			}
			if ($value->tour_visitor_height_type_id > 0) {
				$child[$value->tour_class_id][$value->tour_visitor_height_type_id][$value->tour_number_group_id] = $value->price;
				$price_type_rate[$value->tour_class_id][$value->tour_visitor_height_type_id][$value->tour_number_group_id] = $value->price_type;
			}
		}
		foreach ($data_price_infant as $key => $value) {
			if ($value->tour_visitor_age_type_id > 0) {
				$infant[$value->tour_class_id][$value->tour_visitor_age_type_id][$value->tour_number_group_id] = $value->price;
				$price_type_rate[$value->tour_class_id][$value->tour_visitor_age_type_id][$value->tour_number_group_id] = $value->price_type;
			}
			if ($value->tour_visitor_height_type_id > 0) {
				$infant[$value->tour_class_id][$value->tour_visitor_height_type_id][$value->tour_number_group_id] = $value->price;
				$price_type_rate[$value->tour_class_id][$value->tour_visitor_height_type_id][$value->tour_number_group_id] = $value->price_type;
			}
		}
		$price[$child_type_id] = $child;
		$price[$infant_type_id] = $infant;
	}
	$price_single_supply = Input::post('price_single_supply', 0);
	#
	$options = array('is_active' => $is_active);
	if ($ruler_type == 1) {
		$options['is_single'] = 0;
	} else if ($ruler_type == 2) {
		$options['is_single'] = 1;
	}
	if ($is_last_hour == 1) {
		$open_sale_date = Input::post('open_sale_date', 0);
		$close_sale_date = Input::post('close_sale_date', 0);
		$options['is_last_hour'] = $is_last_hour;
		$options['open_sale_date'] = $clsISO->convertTextToTime2($open_sale_date, "00:00:00");
		$options['close_sale_date'] = $clsISO->convertTextToTime2($close_sale_date, "23:59:59");
	} else {
		$options['is_last_hour'] = $is_last_hour;
		$options['open_sale_date'] = 0;
		$options['close_sale_date'] = 0;
	}

	if ($allotment != '') {
		$options['allotment'] = str_replace('.', '', $allotment);
	} else {
		$options['allotment'] = null;
	}

	$msg = '_error';
	$price = $price ? str_replace('.', '', json_encode($price)) : '';
	if ($tour_start_date_id == 0) {
		if (!empty($lst_date_id)) {
			foreach ($lst_date_id as $key => $item) {
				$cond = "tour_id=" . $tour_id . " AND start_date=" . $item['start_time'] . " AND end_date = " . $item['due_time'];
				$limit = " LIMIT 0,1 ";
				$start_date_item = $clsTourStartDate->getByCond($cond . $limit, '*');
				$weekday = $item['weekdays'] ? $item['weekdays'][0] : '';

				if ($ruler_type == 2 || ($ruler_type == 1 && in_array($weekday, $weekdays_post))) {
					if (!empty($start_date_item) && $start_date_item['tour_start_date_id']) {
						$tour_start_date_id = $start_date_item['tour_start_date_id'];
						$dataUpdate = array_merge(array(
							'start_date' => $item['start_time'],
							'end_date' => $item['due_time'],
							'tour_id' => $tour_id,
							'user_id' => $core->_USER['user_id'],
							'user_id_update' => $core->_USER['user_id'],
							'ruler_type' => $ruler_type,
							'departure_type' => $departure_type,
							'price_type' => $price_type,
							'price' => $price,
							'price_type_rate' => $price_type_rate ? json_encode($price_type_rate) : '',
							'weekdays' => $weekdays_post ? json_encode($weekdays_post) : '',
							'time_for_payment' => intval($time_for_payment),
							'price_single_supply' => str_replace('.', '', $price_single_supply),
							'deposit' => str_replace('.', '', $deposit),
							'reg_date' => time(),
							'upd_date' => time(),
						), $options);

						if ($clsTourStartDate->update($tour_start_date_id, $dataUpdate)) {
							$msg = '_success';
						} else {
							echo '_error';
							die;
						}
					} else {
						$tour_start_date_id = $clsTourStartDate->getMaxId();
						$dataInsert = array_merge(array(
							'tour_start_date_id' => $tour_start_date_id,
							'start_date' => $item['start_time'],
							'end_date' => $item['due_time'],
							'tour_id' => $tour_id,
							'user_id' => $core->_USER['user_id'],
							'user_id_update' => $core->_USER['user_id'],
							'ruler_type' => $ruler_type,
							'departure_type' => $departure_type,
							'price_type' => $price_type,
							'price' => $price,
							'price_type_rate' => $price_type_rate ? json_encode($price_type_rate) : '',
							'weekdays' => $weekdays_post ? json_encode($weekdays_post) : '',
							'time_for_payment' => intval($time_for_payment),
							'price_single_supply' => str_replace('.', '', $price_single_supply),
							'deposit' => str_replace('.', '', $deposit),
							'reg_date' => time(),
							'upd_date' => time(),
						), $options);
						if ($clsTourStartDate->insert($dataInsert)) {
							$msg = '_success';
						} else {
							echo '_error';
							die;
						}
					}
				} else {
					if (!empty($start_date_item) && $start_date_item['tour_start_date_id']) {
						$clsTourStartDate->deleteOne($start_date_item['tour_start_date_id']);
					}
				}
			}
		}
	} else {
		$dataUpdate = array_merge(array(
			'tour_id' => $tour_id,
			'user_id' => $core->_USER['user_id'],
			'user_id_update' => $core->_USER['user_id'],
			'ruler_type' => $ruler_type,
			'departure_type' => $departure_type,
			'price_type' => $price_type,
			'price' => $price,
			'price_type_rate' => $price_type_rate ? json_encode($price_type_rate) : '',
			'weekdays' => $weekdays_post ? json_encode($weekdays_post) : '',
			'time_for_payment' => intval($time_for_payment),
			'price_single_supply' => str_replace('.', '', $price_single_supply),
			'deposit' => str_replace('.', '', $deposit),
			'reg_date' => time(),
			'upd_date' => time(),
		), $options);

		if ($clsTourStartDate->update($tour_start_date_id, $dataUpdate)) {
			$msg = '_success';
		} else {
			echo '_error_update';
			die;
		}
	}

	// Return
	echo $msg;
	die();
}

function default_ajaxDepartureDateEvents()
{
	global $clsISO;
	#
	$clsTourStartDate = new TourStartDate();
	#
	$lst_id = $_POST['lst_id'];
	$type = $_POST['type'];

	$lstTrue = array();
	$lstFalse = array();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL & ~E_STRICT);
	if (!empty($lst_id) && !empty($type)) {
		foreach ($lst_id as $item) {
			if ($type == 'active') {
				if ($clsTourStartDate->updateOne($item, 'is_active=1')) {
					$lstTrue[] = $item;
				} else {
					$lstFalse[] = $item;
				}
			} else if ($type == 'delete') {
				if ($clsTourStartDate->deleteOne($item)) {
					$lstTrue[] = $item;
				} else {
					$lstFalse[] = $item;
				}
			}
		}
	}
	$resJson = array(
		'lstTrue' => json_encode($lstTrue),
		'lstFalse' => json_encode($lstFalse),
	);
	echo json_encode($resJson);
	die;
}
