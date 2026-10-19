{if $deviceType ne 'phone'}
<div class="avaiable__header">
	<h2 class="title_section color_fff">{$core->get_Lang('Price Table')}</h2>
	<form id="form__avaiable" class="form__avaiable d-flex" action="" method="post">
		<div class="number_travellers_box relative">
			<div class="number_travellers icon_user relative">
				<input type="text" readonly class="form-control pick_travellers" id="pick_travellers" value="{$core->get_Lang('Adults')} x 1">
			</div>
			<div id="check_number_travellers" class="check_number_travellers" style="display:none;">
				<ul class="check_number_travellers--ul list_style_none">
					{foreach from=$lstVisitorType item=visitorType}
						{if $visitorType.tour_property_id eq $adult_type_id}
							<li class="inputTraveller" id="li_adult" data-tour_property_id="{$visitorType.tour_property_id}">
								<label>{$core->get_Lang('Adults')}
									<span class="size14 d-block text_normal">({$core->get_Lang('12 years old and older')})</span>
								</label>
								<div class="right__inputTraveller">
									<a class="unNum text_main disabled" _type="number_adults" traveler_type_id="{$visitorType.tour_property_id}" href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a>
									<input type="hidden" id="tour_visitor_adult_id" name="tour_visitor_adult_id" value="{$visitorType.tour_property_id}"/>
									<input _type="number_adults" min-number="{$min_adult|default:1}" max-number="{$max_adult}" type="number" class="number_adults input_number find_select" tour_visitor_type_id="{$visitorType.tour_property_id}" name="national_visitor{$visitorType.tour_property_id}" id="national_visitor{$visitorType.tour_property_id}" value="{$min_adult|default:1}" readonly/>
									<input type="hidden" name="people_price{$visitorType.tour_property_id}" value="{$price_adult|default:0}" id="people_price{$visitorType.tour_property_id}" departure_in="{$departure_in|default:''}" departure_in_2="{$departure_in_2|default:''}">
									<a class="upNum text_main" _type="number_adults" traveler_type_id="{$visitorType.tour_property_id}" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a>
								</div>
							</li>

						{elseif $visitorType.tour_property_id eq $child_type_id}
							{if $max_child}
							<li class="inputTraveller">
								<label>{$core->get_Lang('Children')}
									{if $textSizeGroupChild}<span class="size14 d-block text_normal">({$textSizeGroupChild})</span>{/if}
								</label>
								<div class="right__inputTraveller">
									<a class="unNum text_main disabled" _type="number_child" traveler_type_id="{$visitorType.tour_property_id}" href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a>
									<input type="hidden" id="tour_visitor_child_id" name="tour_visitor_child_id" value="{$visitorType.tour_property_id}"/>
									<input _type="number_child" min-number="0" max-number="{$max_child}" type="number" class="number_child input_number find_select" tour_visitor_type_id="{$visitorType.tour_property_id}" name="national_visitor{$visitorType.tour_property_id}" id="national_visitor{$visitorType.tour_property_id}" value="0" readonly/>
									<a class="upNum text_main" _type="number_child" traveler_type_id="{$visitorType.tour_property_id}" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a>
								</div>
								<div class="box_group_child_infant" data-visitor_type="{$child_type_id}" data-type="{$child_visitor_type}" id="box_group_child"></div>
							</li>
							{/if}

						{else}
							{if $max_infant}
							<li class="inputTraveller">
								<label>{$core->get_Lang('Infants')}
									{if $textSizeGroupInfant}<span class="size14 d-block text_normal">({$textSizeGroupInfant})</span>{/if}
								</label>
								<div class="right__inputTraveller">
									<a class="unNum text_main disabled" _type="number_infants" traveler_type_id="{$visitorType.tour_property_id}" href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a>
									<input type="hidden" id="tour_visitor_infant_id" name="tour_visitor_infant_id" value="{$visitorType.tour_property_id}"/>
									<input _type="number_infants" min-number="0" max-number="{$max_infant}" type="number" class="number_infants input_number find_select" tour_visitor_type_id="{$visitorType.tour_property_id}" name="national_visitor{$visitorType.tour_property_id}" id="national_visitor{$visitorType.tour_property_id}" value="0" readonly/>
									<a class="upNum text_main" _type="number_infants" traveler_type_id="{$visitorType.tour_property_id}" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a>
								</div>
								<div class="box_group_child_infant" data-visitor_type="{$infant_type_id}" data-type="{$infant_visitor_type}" id="box_group_infant"></div>
							</li>
							{/if}
						{/if}
					{/foreach}
				</ul>
			</div>
		</div>
		<div class="date_picker_group relative">
			<input name="departure_date" readonly id="departure_date" now_next_departure="{$now_next_departure}" type="text" value="{$clsISO->converTimeToText5($str_first_start_date)}" class="form-control" placeholder="{$core->get_Lang('Check in')}" />
		</div>
		<div class="line line__check">
			<input type="hidden" name="tour_id" id="tour_id" value="{$tour_id}" />
			<input type="hidden" name="is_last_hour" id="is_last_hour" value="{$is_last_hour}" />
			<input type="hidden" name="tour_start_date" id="tour_start_date" value="{$tour_start_date}" />
			<input type="hidden" name="tour__class_check" id="tour__class_check" value="0" />
			<input type="hidden" name="number_adults" id="number_adults" value="{$min_adult|default:1}" />
			<input type="hidden" name="number_child" id="number_child" value="0" />
			<input type="hidden" name="number_infants" id="number_infants" value="0" />
			<input type="hidden" name="check_in_book" id="check_in_book" value="{$clsISO->converTimeToText6($str_first_start_date)}" />
			<input type="hidden" name="hidFind" value="hidAvaiable" />
			<input id="check_avaiable" name="check_avaiable" class="check_avaiable btn_yellow btn_main" type="button" value="{$core->get_Lang('Check')}"/>
		</div>
	</form>
</div>
{else}
<div class="avaiable__header avaiable_tour_detail mobile_tour_detail">
	<h2 class="title_section color_fff">{$core->get_Lang('Price Table')}</h2>
	<form id="form__avaiable" class="form__avaiable d-flex" action="" method="post">
		<div class="number_travellers_box relative">
			<div class="number_travellers icon_user relative">
				<input type="text" readonly class="form-control pick_travellers" id="pick_travellers" value="{$core->get_Lang('Adults')} x 1">
			</div>
			<div id="check_number_travellers" class="check_number_travellers" style="display:none;">
				<ul class="check_number_travellers--ul list_style_none">
					{foreach from=$lstVisitorType item=visitorType}
						{if $visitorType.tour_property_id eq $adult_type_id}
							<li class="inputTraveller" id="li_adult" data-tour_property_id="{$visitorType.tour_property_id}">
								<label>{$core->get_Lang('Adults')}
									<span class="size14 d-block text_normal">({$core->get_Lang('12 years old and older')})</span>
								</label>
								<div class="right__inputTraveller">
									<a class="unNum text_main disabled"
									_type="number_adults"
									traveler_type_id="{$visitorType.tour_property_id}"
									href="javascript:void(0);">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</a>
									<input type="hidden"
										id="tour_visitor_adult_id"
										name="tour_visitor_adult_id"
										value="{$visitorType.tour_property_id}"/>
									<input _type="number_adults"
										min-number="{$min_adult|default:1}"
										max-number="{$max_adult}"
										type="number"
										class="number_adults input_number find_select"
										tour_visitor_type_id="{$visitorType.tour_property_id}"
										name="national_visitor{$visitorType.tour_property_id}"
										id="national_visitor{$visitorType.tour_property_id}"
										value="{$min_adult|default:1}"
										readonly/>
									<input type="hidden"
										name="people_price{$visitorType.tour_property_id}"
										value="{$price_adult|default:0}"
										id="people_price{$visitorType.tour_property_id}"
										departure_in="{$departure_in|default:''}"
										departure_in_2="{$departure_in_2|default:''}">
									<a class="upNum text_main"
									_type="number_adults"
									traveler_type_id="{$visitorType.tour_property_id}"
									href="javascript:void(0);">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
								</div>
							</li>

						{elseif $visitorType.tour_property_id eq $child_type_id}
							{if $max_child}
								<li class="inputTraveller">
									<label>{$core->get_Lang('Children')}
										{if $textSizeGroupChild}
											<span class="size14 d-block text_normal">({$textSizeGroupChild})</span>
										{/if}
									</label>
									<div class="right__inputTraveller">
										<a class="unNum text_main disabled"
										_type="number_child"
										traveler_type_id="{$visitorType.tour_property_id}"
										href="javascript:void(0);">
											<i class="fa fa-minus" aria-hidden="true"></i>
										</a>
										<input type="hidden"
											id="tour_visitor_child_id"
											name="tour_visitor_child_id"
											value="{$visitorType.tour_property_id}"/>
										<input _type="number_child"
											min-number="0"
											max-number="{$max_child}"
											type="number"
											class="number_child input_number find_select"
											tour_visitor_type_id="{$visitorType.tour_property_id}"
											name="national_visitor{$visitorType.tour_property_id}"
											id="national_visitor{$visitorType.tour_property_id}"
											value="0"
											readonly/>
										<a class="upNum text_main"
										_type="number_child"
										traveler_type_id="{$visitorType.tour_property_id}"
										href="javascript:void(0);">
											<i class="fa fa-plus" aria-hidden="true"></i>
										</a>
									</div>
									<div class="box_group_child_infant"
										data-visitor_type="{$child_type_id}"
										data-type="{$child_visitor_type}"
										id="box_group_child">
									</div>
								</li>
							{/if}

						{else}
							{if $max_infant}
								<li class="inputTraveller">
									<label>{$core->get_Lang('Infants')}
										{if $textSizeGroupInfant}
											<span class="size14 d-block text_normal">({$textSizeGroupInfant})</span>
										{/if}
									</label>
									<div class="right__inputTraveller">
										<a class="unNum text_main disabled"
										_type="number_infants"
										traveler_type_id="{$visitorType.tour_property_id}"
										href="javascript:void(0);">
											<i class="fa fa-minus" aria-hidden="true"></i>
										</a>
										<input type="hidden"
											id="tour_visitor_infant_id"
											name="tour_visitor_infant_id"
											value="{$visitorType.tour_property_id}"/>
										<input _type="number_infants"
											min-number="0"
											max-number="{$max_infant}"
											type="number"
											class="number_infants input_number find_select"
											tour_visitor_type_id="{$visitorType.tour_property_id}"
											name="national_visitor{$visitorType.tour_property_id}"
											id="national_visitor{$visitorType.tour_property_id}"
											value="0"
											readonly/>
										<a class="upNum text_main"
										_type="number_infants"
										traveler_type_id="{$visitorType.tour_property_id}"
										href="javascript:void(0);">
											<i class="fa fa-plus" aria-hidden="true"></i>
										</a>
									</div>
									<div class="box_group_child_infant"
										data-visitor_type="{$infant_type_id}"
										data-type="{$infant_visitor_type}"
										id="box_group_infant">
									</div>
								</li>
							{/if}
						{/if}
					{/foreach}
				</ul>
			</div>
		</div>
		<div class="date_picker_group relative">
			<input name="departure_date" readonly id="departure_date" now_next_departure="{$now_next_departure}" type="text" value="{$clsISO->converTimeToText5($str_first_start_date)}" class="form-control" placeholder="{$core->get_Lang('Check in')}" />
		</div>
		<div class="line line__check">
			<input type="hidden" name="tour_id" id="tour_id" value="{$tour_id}" />
			<input type="hidden" name="is_last_hour" id="is_last_hour" value="{$is_last_hour}" />
			<input type="hidden" name="tour_start_date" id="tour_start_date" value="{$tour_start_date}" />
			<input type="hidden" name="tour__class_check" id="tour__class_check" value="0" />
			<input type="hidden" name="number_adults" id="number_adults" value="{$min_adult|default:1}" />
			<input type="hidden" name="number_child" id="number_child" value="0" />
			<input type="hidden" name="number_infants" id="number_infants" value="0" />
			<input type="hidden" name="check_in_book" id="check_in_book" value="{$clsISO->converTimeToText6($str_first_start_date)}" />
			<input type="hidden" name="hidFind" value="hidAvaiable" />
			<input id="check_avaiable" name="check_avaiable" class="check_avaiable btn_yellow btn_main" type="button" value="{$core->get_Lang('Check')}"/>
		</div>
	</form>
</div>
{/if}
<div id="TablePrice"></div>
<script>
	list_start_date = ['{$list_start_date}'];
</script>
