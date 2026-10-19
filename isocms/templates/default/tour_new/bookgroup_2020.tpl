{assign var=title_tour value=$clsTour->getTitle($tour_id)}
{assign var=promotion_id value=$clsTour->getMinStartDatePromotionProID($tour_id,$now_day)}
{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
{assign var=checkvoucher value=$clsTour->getCheckVoucher($tour_id)}
<div class="page_container" id="tour_page_container">
	<div class="breadcrumb-main bg_fff">
		<div class="container">
			<ol class="breadcrumb bg_fff hidden-xs mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$clsCountryEx->getLink($country_id,'Tour')}" title="{$clsCountryEx->getTitle($country_id)}">
						<span itemprop="name" class="reb">{$clsCountryEx->getTitle($country_id)} {$core->get_Lang('Tours')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
				<li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$clsTour->getLink($tour_id)}" title="{$clsTour->getTitle($tour_id)}">
						<span itemprop="name" class="reb">{$clsTour->getTitle($tour_id)}</span></a>
					<meta itemprop="position" content="3" />
				</li>
				<li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<span itemprop="name" class="reb">{$core->get_Lang('Booking Tours')}</span>
					<meta itemprop="position" content="4" />
				</li>
			</ol>
		</div>
	</div>
    <section id="booking" class="pd40_0 bg_f5f5f5">
		<div class="container">
			<form action="" method="post" class="formBookingTour">
				<h1 class="mb30 size30">{$title_tour}</h1>
				<div class="row">
					<div class="col-md-8">
						{if $err_msg}
						<div class="box-message_book">
							{$err_msg}
						</div>
						{/if}
						<div class="boxSelectDate bg_fff pd30 pd20_991 mb20">
							<h3 class="size18 mb05"><span class="number">1</span> {$core->get_Lang('Select your departure date')}</h3>
							<div class="boxChangeDate">
								{if $show eq 'Departure'}
								<p class="size15" id="departure_html">{$clsISO->getDayOfWeek($departure_date)}, {$clsISO->converTimeToTextNoComma($departure_date)}</p>
								{else}
								<p class="size15" id="departure_html">{$clsISO->getDayOfWeek($now_next)}, {$clsISO->converTimeToTextNoComma($now_next)}</p>
								{/if}
								<p class="color_main">{$core->get_Lang('Change date')}</p>
								<div class="row">
									<div class="col-md-5 col-sm-6 mb767_15">
										{if $show eq 'Departure'}
										<input type="text" name="departure_date" value="{$departure_date|date_format:"%m/%d/%Y"}" placeholder="mm/dd/yyyy" class="dateTxt2 required datepicker inputDate form-booking_input isoTxt tbdate hasDatePicker" data="Departure" />
										{else}
										<input type="text" name="departure_date" value="{$now_next|date_format:"%m/%d/%Y"}" placeholder="mm/dd/yyyy" class="dateTxt2 required datepicker inputDate form-booking_input isoTxt tbdate hasDatePicker" data="NoDeparture" />
										{/if}
									</div>
									<div class="col-md-4 col-sm-6">
										<div class="tour select_arow">
											<select class="selectbox form-booking_input find_select" name="tourclass" id="tourclass">
												{section name=i loop=$lstOption}
												<option value="{$lstOption[i]}" {if $tourclass eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
												{/section}
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="boxTraveler bg_fff pd30 pd20_991">
							<h3 class="size18 mb05"><span class="number">2</span> {$core->get_Lang('Tour Travellers')}</h3>
							<div class="boxChangeTraveler mt25">
								<p class="size16 mb30">{$core->get_Lang('Number of travellers')}</p>
								<div class="pd0_30 pd0_1199 pd0_767">
									<div class="row">
										{section name=i loop=$lstVisitorType}
											{if $lstVisitorType[i].tour_property_id eq $adult_type_id}
											<div class="col-sm-4 col-xs-12 inputTraveller">
												<a class="unNum" traveler_type_id={$lstVisitorType[i].tour_property_id}>-</a>
												<label>{*{$lstVisitorType[i].title}*}{$core->get_Lang('Adults')}</label>
												<input type="hidden" id="people_price_text{$adult_type_id}" value="0"/>
												<input min-number="0" max-number="{$max_adult}" type="text" class="input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="national_visitor{$lstVisitorType[i].tour_property_id}" id="national_visitor{$lstVisitorType[i].tour_property_id}" value="1"/>
												<input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{$price_adult}" id="people_price{$lstVisitorType[i].tour_property_id}" departure_in="{$departure_in}" departure_in_2="{$departure_in_2}">
												<a class="upNum" traveler_type_id={$lstVisitorType[i].tour_property_id}>+</a>
											</div>
											{elseif $lstVisitorType[i].tour_property_id eq $child_type_id}
											<div class="col-sm-4 col-xs-12 inputTraveller">
												<a class="unNum" traveler_type_id={$lstVisitorType[i].tour_property_id}>-</a>
												<label>{*{$lstVisitorType[i].title}*}{$core->get_Lang('Children')}</label>
												<input type="hidden" id="people_price_text{$child_type_id}" value="0"/>
												<input min-number="0" max-number="{$max_child}" type="text" class="input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="national_visitor{$lstVisitorType[i].tour_property_id}" id="national_visitor{$lstVisitorType[i].tour_property_id}" value="0"/>
												<input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{$price_child}" id="people_price{$lstVisitorType[i].tour_property_id}" departure_in="{$departure_in}" departure_in_2="{$departure_in_2}">
												<a class="upNum" traveler_type_id={$lstVisitorType[i].tour_property_id}>+</a>
											</div>
											{else}
											<div class="col-sm-4 col-xs-12 inputTraveller">
												<a class="unNum" traveler_type_id={$lstVisitorType[i].tour_property_id}>-</a>
												<label>{*{$lstVisitorType[i].title}*}{$core->get_Lang('Infants')}</label>
												<input type="hidden" id="people_price_text{$infant_type_id}" value="0"/>
												<input min-number="0" max-number="{$max_infant}" type="text" class="input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="national_visitor{$lstVisitorType[i].tour_property_id}" id="national_visitor{$lstVisitorType[i].tour_property_id}" value="0"/>
												<input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{$price_infant}" id="people_price{$lstVisitorType[i].tour_property_id}" departure_in="{$departure_in}" departure_in_2="{$departure_in_2}">
												<a class="upNum" traveler_type_id={$lstVisitorType[i].tour_property_id}>+</a>
											</div>
											{/if}
									{/section}
									</div>
								</div>
							</div>
							<div class="listCustome2018 mt30">
								<div id="customer_list">
									{section name=i loop=$total_people}
									<div>
										<span class="mb20"><input type="text" class="form-control form-booking_input" value="{$smarty.section.i.iteration}"></span>
										<span><input type="text" class="form-control form-booking_input" name="input_{$smarty.section.i.index}.name" id="input_{$smarty.section.i.index}.name"></span>
										<span class="mb20"><input type="text" class="form-control form-booking_input datepicker inputDate" name="input_{$smarty.section.i.index}.birthday" id="input_{$smarty.section.i.index}.birthday"></span>

										<span class="mb20"><input type="text" class="form-control form-booking_input" name="input_{$smarty.section.i.index}.address" id="input_{$smarty.section.i.index}.address"></span>
										<span class="mb20">
											<select class="form-control form-booking_input" name="input_{$smarty.section.i.index}.gender" id="input_{$smarty.section.i.index}.gender">
												<option value="{$core->get_Lang('Female')}">{$core->get_Lang('Female')}</option>
												<option value="{$core->get_Lang('Male')}">{$core->get_Lang('Male')}</option>
											</select>
										</span>
										<span class="mb20">
											<select class="form-control form-booking_input appearance_none" name="input_{$smarty.section.i.index}.tourist_age_type" id="input_{$smarty.section.i.index}.tourist_age_type">
												<option value="{$core->get_Lang('Adult')}">{$core->get_Lang('Adult')}</option>
												<option value="{$core->get_Lang('Children')}">{$core->get_Lang('Children')}</option>
												<option value="{$core->get_Lang('Infant')}">{$core->get_Lang('Infant')}</option>
											</select>
										</span>
									</div>
									{/section}
								</div>
							</div>
						</div>
						{if $clsConfiguration->getValue('SiteHasService_Tours')}
						{if $oneItem.list_service_id ne ''}
						<div class="clearfix mt20"></div>
						<div class="bk-transfer2018 bg_fff pd30 pd20_991">
							<h3 class="size18 mb05"><span class="number">3</span> {$core->get_Lang('Transfer Services')}</h3>
							<table border="0" cellpadding="0" cellspacing="0" class="table-cabin table-data mt25">
								{section name=i loop=$lstTourService|@count}
								{if $clsISO->checkContainer($oneItem.list_service_id,$lstTourService[i])}
								<tr class="trRowSv" addonservice_id="{$lstTourService[i]}" extra="{$clsAddOnService->getExtra($lstTourService[i])}">
									<td class="title">
										<input type="hidden" id="tourPriceSv{$lstTourService[i]}" value="{$clsAddOnService->getOneField('price',$lstTourService[i])}" />
										<input type="hidden" id="PriceServiceItem{$lstTourService[i]}" value="{$clsAddOnService->getOneField('price',$lstTourService[i])}" />
										<input id="s{$lstTourService[i]}" {if $clsISO->checkItemInArray($lstTourService[i],$addOnService)}checked="checked"{/if} type="checkbox" name="addOnService[]" class="chk_addOnService" value="{$lstTourService[i]}" price="{$clsAddOnService->getPrice($lstTourService[i])}" />
										<label for="s{$lstTourService[i]}"> {$clsAddOnService->getTitle($lstTourService[i])}</label>
										<a id="addOnService_{$lstTourService[i]}" class="tipcabin"><img src="{$URL_IMAGES}/help.png" align="absmiddle" /></a>
										{literal}
										<script >
											document.addEventListener("DOMContentLoaded", function () {
												$(document).ready(function(){
													$('#addOnService_{/literal}{$lstTourService[i]}{literal}').tipsy({
														fallback: '{/literal}{$clsAddOnService->getIntro($lstTourService[i])}{literal}',
														gravity: 'n',
														width: '400px'
													});
												});
											})
										</script>
										{/literal}
									</td>
									<td class="text-center number" >
										<div class="changeNumberTourService">
											<a class="unNumSev" tour_service_id={$lstTourService[i]} disabled="disabled">-</a>
											<input type="text" id="numberService_{$lstTourService[i]}" name="number_tourservice[{$lstTourService[i]}]" class="input_service" min="1" disabled="disabled" value="1" extra="{$clsAddOnService->getExtra($lstTourService[i])}" style="width: 100%; text-align:center">
											<a class="upNumSev" tour_service_id={$lstTourService[i]} disabled="disabled">+</a>
										</div>
										{literal}
										<script >
											document.addEventListener("DOMContentLoaded", function () {
												$(document).ready(function(){
													$("#numberService_{/literal}{$lstTourService[i]}{literal}").change(function(){
													if(!isNaN(parseInt($(this).val()))){
														if(parseInt($(this).val()) >= 0){
															getTotalRateServiceItem();
															tinhtoan();
														}else{
															alert(Input_data_is_invalid);
															$(this).val(1);
															getTotalRateServiceItem();
															tinhtoan();
														}
													}else{
														alert(Input_data_is_invalid);
														$(this).val(1);
														getTotalRateServiceItem();
														tinhtoan();
														}
													});
												});
											})
										</script>
										{/literal}
									</td>
									<td class="text-center price">
										{if $clsAddOnService->getExtra($lstTourService[i]) eq '0'}
											{$core->get_Lang('Included')}
										{else}
											{if $_LANG_ID eq 'vn'}
											<span id="svRate{$lstTourService[i]}">{$clsAddOnService->getPrice($lstTourService[i])}</span>{$clsISO->getShortRate()}
											{else}
											{$clsISO->getShortRate()}<span id="svRate{$lstTourService[i]}">{$clsAddOnService->getPrice($lstTourService[i])}</span>
											{/if}
										{/if}
									</td>
								</tr>
								{/if}
								{/section}
							</table>
						</div>
						{/if}
						{/if}
					</div>
					<div class="col-md-4">
						<div class="col_right_fixed" id="sidebar">
							<div class="info_tour pd30 pd20_991 bg_fff">
								<div class="boxItem">
									<h2 class="size24 mb15">{$core->get_Lang('My trip')}</h2>
									<h3 class="title size15 text_bold mb05">{$title_tour}</h3>
									<div class="dration_box mb10">
										<span class="fa fa-clock-o" aria-hidden="true"></span>
										<span class="color_333">{$core->get_Lang('Duration')}: </span>
										<span class="color_333">{$clsTour->getLTripDuration($tour_id)}</span>
									</div>
									<p class="text_bold mb05">
										{$core->get_Lang('Start in')} {$clsTour->getStartCityAround($tour_id,1)}
									</p>
									{if $show eq 'Departure'}
									{assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
									<p class="color_666 mb05" id="start_date_html">{$clsISO->getDayOfWeek($departure_date)}, {$clsISO->converTimeToTextNoComma($departure_date)}</p>
									{else}
									<p class="color_666 mb05" id="start_date_html">{$clsISO->getDayOfWeek($now_next)}, {$clsISO->converTimeToTextNoComma($now_next)}</p>
									{assign var=end_date value=$clsTour->getEndDate($now_next,$tour_id)}
									{/if}
									<p class="text_bold mb05">
										{$core->get_Lang('End in')} {$clsTour->getEndCityAround($tour_id,1)}
									</p>
									<p class="color_666" id="end_date_html">{$clsISO->getDayOfWeek($end_date)}, {$clsISO->converTimeToTextNoComma($end_date)}</p>
								</div>
								<hr />
								<div class="boxItem">
									<h3 class="title size15 text_bold mt10 mb20 color_main">{$core->get_Lang('Price per traveller')}</h3>
									<div class="line">
										<label>{$core->get_Lang('Price per Adult')}</label>
										<input type="hidden" name="price_adult" id="price_adult_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="price_adult">1000</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="price_adult">1000</span></span>
										{/if}
									</div>
									<div class="line">
										<label>{$core->get_Lang('Price per Child')}</label>
										<input type="hidden" name="price_child" id="price_child_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="price_child">0</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="price_child">0</span></span>
										{/if}
									</div>
									<div class="line">
										<label>{$core->get_Lang('Price per Infant')}</label>
										<input type="hidden" name="price_infant" id="price_infant_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="price_infant">0</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="price_infant">0</span></span>
										{/if}
									</div>
									<hr />
									<div class="line">
										<label>(<span id="for_number_traveller">{$core->get_Lang('For 1 adult')}</span>)</label>
										<input type="hidden" name="price_total_traveller" id="price_total_traveller_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right text_bold"><span id="price_total_traveller">1000</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right text_bold">{$clsISO->getShortRate()}<span id="price_total_traveller">1000</span></span>
										{/if}
									</div>
								</div>
								<div class="boxItem" id="boxService" style="display:none">
									<h3 class="title size15 text_bold mt10 mb05 color_main">{$core->get_Lang('Addon Service')}</h3>
									{section name=i loop=$lstTourService|@count}
									{if $clsISO->checkContainer($oneItem.list_service_id,$lstTourService[i])}
									<div class="line" id="tour_service_{$lstTourService[i]}" style="display:none">
										<label>{$clsAddOnService->getTitle($lstTourService[i])}</label>
										<span class="right">
											{if $clsAddOnService->getExtra($lstTourService[i]) eq '0'}
												{$core->get_Lang('Included')}
											{else}
												{if $_LANG_ID eq 'vn'}
												<span id="rate_one_tour_service_{$lstTourService[i]}">{$clsAddOnService->getPrice($lstTourService[i])}</span>{$clsISO->getShortRate()}
												{else}
												{$clsISO->getShortRate()}<span id="rate_one_tour_service_{$lstTourService[i]}">{$clsAddOnService->getPrice($lstTourService[i])}</span>
												{/if}
											{/if}
										</span>
									</div>
									{/if}
									{/section}
									<hr />
									<div class="line">
										<label>({$core->get_Lang('For')} <span id="number_service">1</span> {$core->get_Lang('service')})</label>
										<input type="hidden" name="price_total_service" id="price_total_service_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right text_bold"><span id="price_total_service">1000</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right text_bold">{$clsISO->getShortRate()}<span id="price_total_service">1000</span></span>
										{/if}
									</div>
								</div>
							</div>
							<div class="total_price mt20">
								<div class="amount_due">
									<label>{$core->get_Lang('Amount due')}</label>
									<input type="hidden" name="price_total_amount" id="price_total_amount_post" value="0" />
									{if $_LANG_ID eq 'vn'}
									<span class="right"><span id="price_total_amount">1000</span>{$clsISO->getShortRate()}</span>
									{else}
									<span class="right">{$clsISO->getShortRate()}<span id="price_total_amount">1000</span></span>
									{/if}
								</div>
								<div class="remaining_price">
									<p class="color_666">{$core->get_Lang('TO BE PAID NOW')}</p>
									<div class="line extracharges" style="display:none">
										<label>{$core->get_Lang('Transaction Surcharge')}</label>
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="surcharge_value_html">1</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="surcharge_value_html">1</span></span>
										{/if}
										<input type="hidden" id="surcharge_value_post" name="surcharge_value_post" value="">
										<input type="hidden" id="surcharge" name="surcharge" value="">
									</div>
									{if $promotion gt 0}
									<div class="line" id="promotion_box">
										<label>{$core->get_Lang('Promotion')} ({$promotion}%)</label>
										<input type="hidden" name="promotion" id="promotion" value="{$promotion}" />
										<input type="hidden" name="price_promotion" id="price_promotion_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="price_promotion">1000</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="price_promotion">1000</span></span>
										{/if}
									</div>
									{else}
										<div class="promoion_voucher"></div>
									{/if}
									<input type="hidden" name="exchange_rate" id="exchange_rate" value="{$_EXCHANGE_RATE}" />
									{if $depositItem gt 0 }
									<div class="line">
										<label>{$core->get_Lang('Deposit')} ({$depositItem}%)</label>
										<input type="hidden" name="deposit" id="deposit" value="{$deposit}" />
										<input type="hidden" name="price_deposit" id="price_deposit_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="price_deposit">1000</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="price_deposit">1000</span></span>
										{/if}
									</div>
									{else}
									<div class="line" style="display:none">
										<label>{$core->get_Lang('Deposit')} ({$depositItem}%)</label>
										<input type="hidden" name="deposit" id="deposit" value="0" />
										<input type="hidden" name="price_deposit" id="price_deposit_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="price_deposit">0</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="price_deposit">0</span></span>
										{/if}
									</div>
									{/if}
									<div class="line">
										<label>{$core->get_Lang('Final Payment')}</label>
										<input type="hidden" name="price_remaining" id="price_remaining_post" value="0" />
										{if $_LANG_ID eq 'vn'}
										<span class="right"><span id="price_remaining">1000</span>{$clsISO->getShortRate()}</span>
										{else}
										<span class="right">{$clsISO->getShortRate()}<span id="price_remaining">1000</span></span>
										{/if}
									</div>
									<div class="line">
										<div class="amount_due">
											<label>{$core->get_Lang('Paynow')}</label>
											<input type="hidden" name="price_paynow" id="price_paynow_post" value="0" />
											{if $_LANG_ID eq 'vn'}

											<span class="right"><span id="price_paynow">1000</span>{$clsISO->getShortRate()}</span>
											{else}
											<span class="right">{$clsISO->getShortRate()}<span id="price_paynow">1000</span></span>
											{/if}
										</div>
									</div>
									{if $_LANG_ID eq 'vn'}
									<div class="line hidden mb10">
									<input type="hidden" name="price_deposit_vn" id="price_deposit_vn_post" value="0" />
									<p class="text_right text_bold"><span style="font-family:Arial, Helvetica, sans-serif">~</span><span id="price_deposit_vn">{$clsISO->formatPrice($_EXCHANGE_RATE)}</span>VND</p>

									</div>
									{else}
									<div class="line mb10">
									<input type="hidden" name="price_deposit_vn" id="price_deposit_vn_post" value="0" />
									<p class="text_right text_bold"><span style="font-family:Arial, Helvetica, sans-serif">~</span><span id="price_deposit_vn">{$clsISO->formatPrice($_EXCHANGE_RATE)}</span>VND</p>

									</div>
									{/if}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="infoCustome_2018 mt20 bg_fff pd30 pd20_991">
							<h3 class="size18 mb05"><span class="number">5</span> {$core->get_Lang('Contact Detail')}</h3>
							<div class="clearfix mt25"></div>
							<div class="form-group">
								<label>{$core->get_Lang('Title (optional)')}</label>
								<select id="title" name="title" class="form-booking_input find_select">
									{$clsISO->makeSelectTitle($title)}
								</select>
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('First Name')} *</label>
								<input id="first_name" name="first_name" placeholder="{$core->get_Lang('VietISO')}" type="text" class="form-booking_input" value="{$firstname}"/>
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Last Name')} *</label>
								<input id="last_name" name="last_name" placeholder="{$core->get_Lang('Team')}" type="text" class="form-booking_input" value="{$lastname}"/>
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Email')} *</label>
								<input id="email" name="email" placeholder="{$clsConfiguration->getValue('CompanyEmail')}" type="email" class="form-booking_input" value="{$email}"/>
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Phone Number')} *</label>
								<input id="telephone" name="telephone" placeholder="{$clsConfiguration->getValue('CompanyPhone')}" type="text" class="form-booking_input" value="{$phone}">
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Date of Birth')}</label>
								<input type="hidden" id="birthday">
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Gender')}</label>
								<input type="radio" class="radio" value="Male" name="gender" id="gender" checked>{$core->get_Lang('Male')}
								<input type="radio" class="radio mgl50" value="Female" name="gender" id="gender">{$core->get_Lang('Female')}
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Nationality')}</label>
								<select name="country_id"  class="form-booking_input find_select">
									{$clsCountryBK->getSelectByCountry($country_id)}
								</select>
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Pick-up address')}</label>
								<input name="address_pick_up" placeholder="{$core->get_Lang('Address pick up in Hanoi')}" type="text" class="required form-booking_input">
							</div>
							<div class="form-group">
								<label style="vertical-align:top">{$core->get_Lang('Messenger')}</label>
								<textarea rows="5" class="form-control" cols="50" name="note" placeholder="{$core->get_Lang('If you have any special requests (special dietary requirements. child car seat. kid meal), please let us know')}."></textarea>
							</div>
						</div>
						<div class="billing_infomation mt20">
							{if $clsISO->getVar('PAYMENT_GLOBAL') eq '1'}
								{$core->getBlock('pay_gateway_new')}
							{/if}
							<div class="form-group clearfix mt30">
								<div class="row">
									<div class="col-md-6 col-sm-6 mb767_20">
										{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
										<div class="col-md-3 col-sm-3 col-xs-4">
											<input type="text" maxlength="5" id="security_code" name="security_code" style="float:left; width:100%; margin-right:5px; height:43px" class="form-control required" placeholder="{$core->get_Lang('Security code')}" />
											<div id="error_security" class="error_security"></div>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-4 text-left">
											<img class="capcha_code" src="{$PCMS_URL}/captcha.php?sid={$sid}"  onclick="this.src='{$PCMS_URL}captcha.php?'+Math.random()+'&sid={$sid}';" width="80px" height="43px"  style="line-height:43px"/>
										</div>
										{else}
										<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
										{/if}
									</div>
									<div class="col-md-6 col-sm-6">
										<button class="btn-bookinggroup" type="submit">
											{$core->get_Lang('Next Step')}
											<span class="fa fa-angle-right"></span>
										</button>
									</div>
								</div>
							</div>
							<input type="hidden" name="booking" value="booking">
							<input type="hidden" id="name_tour" name="name_tour" value="{$title_tour}">
							<input type="hidden" id="code_tour" name="code_tour" value="{$clsTour->getTripCode($tour_id)}">
							<input type="hidden" id="id" name="id" value="{$tour_id}">
						</div>
					</div>
					<div class="col-md-4">

					</div>
				</div>
			</form>
		</div>
	</section>
</div>
<script >
	var _LANG_ID = '{$_LANG_ID}';
	var adult_type_id = '{$adult_type_id}';
	var child_type_id = '{$child_type_id}';
	var infant_type_id = '{$infant_type_id}';
	var rate = '{$clsTour->getTripPriceOrgin($tour_id)}';
	var tour_id = '{$tour_id}';
	var price_adult = '';
	var price_child = '';
	var price_infant = '';
	var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
	var Select = '{$core->get_lang("Select")}';
	var Traveller = '{$core->get_lang("Traveller")}';
	var Title_optional = '{$core->get_lang("Title (optinal)")}';
	var optional = '{$core->get_lang("optional")}';
	var FullName = '{$core->get_lang("Full Name")}';
	var DateofBirth = '{$core->get_lang("Birthday")}';
	var Address = '{$core->get_lang("Address")}';
	var Female = '{$core->get_lang("Female")}';
	var Male = '{$core->get_lang("Male")}';
	var Gender = '{$core->get_lang("Gender")}';
	var Traveller_Type = '{$core->get_lang("Traveller Types")}'
	var adults = '{$core->get_lang("adults")}';
	var adult = '{$core->get_lang("adult")}';
	var Adult = '{$core->get_lang("Adult")}';
	var child = '{$core->get_lang("child")}';
	var Children = '{$core->get_lang("Children")}';
	var infant = '{$core->get_lang("infant")}';
	var Infant = '{$core->get_lang("Infant")}';
	var Mr = '{$core->get_lang("Mr")}';
	var Mrs = '{$core->get_lang("Mrs")}';
	var Ms = '{$core->get_lang("Ms")}';
	var Mss = '{$core->get_lang("Mss")}';
	var Dr = '{$core->get_lang("Dr")}';
	var Day = '{$core->get_lang("Day")}';
	var Month = '{$core->get_lang("Month")}';
	var Year = '{$core->get_lang("Year")}';
	var January = '{$core->get_lang("January")}'
	var February = '{$core->get_lang("February")}';
	var March = '{$core->get_lang("March")}';
	var April = '{$core->get_lang("April")}';
	var May = '{$core->get_lang("May")}';
	var June = '{$core->get_lang("June")}';
	var July = '{$core->get_lang("July")}';
	var August = '{$core->get_lang("August")}';
	var September = '{$core->get_lang("September")}';
	var October = '{$core->get_lang("October")}';
	var November = '{$core->get_lang("November")}';
	var December = '{$core->get_lang("December")}';
	var Jan = '{$core->get_lang("Jan")}'
	var Feb = '{$core->get_lang("Feb")}';
	var Mar = '{$core->get_lang("Mar")}';
	var Apr = '{$core->get_lang("Apr")}';
	var May = '{$core->get_lang("May")}';
	var Jun = '{$core->get_lang("Jun")}';
	var Jul = '{$core->get_lang("Jul")}';
	var Aug = '{$core->get_lang("Aug")}';
	var Sep = '{$core->get_lang("Sep")}';
	var Oct = '{$core->get_lang("Oct")}';
	var Nov = '{$core->get_lang("Nov")}';
	var Dec = '{$core->get_lang("Dec")}';
	var For = '{$core->get_lang("For")}';
	var loading = '{$core->get_lang("loading")}';
	var promotion_check = '{$promotion}';
	var ONEPAY_Surcharge = '{$clsConfiguration->getValue("ONEPAY_Surcharge")}';
	var ONEPAY_Visa_Surcharge = '{$clsConfiguration->getValue("ONEPAY_Visa_Surcharge")}';
	var ONEPAY_American_Express_Surcharge = '{$clsConfiguration->getValue("ONEPAY_American_Express_Surcharge")}';
	var Paypal_Surcharge = '{$clsConfiguration->getValue("Paypal_Surcharge")}';

</script>
<script defer src="{$URL_JS}/datepicker/jquery.date-dropdowns.js?v={$upd_version}"></script>
<script defer src="{$URL_JS}/bookinggroup2020.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_CSS}/bookinggroup2020.css?v={$upd_version}">
{literal}
<script >
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){
			var $heightFooter = $('.footer_2019').outerHeight();
			$.lockfixed("#sidebar", {offset: {top: -170, bottom:  $heightFooter}});
			$(".btn-bookinggroup").click(function(){
				var $form_firstName = $("#first_name").val();
				var $form_lastName = $("#last_name").val();
				var $form_email = $("#email").val();
				var $form_phone = $("#telephone").val();
				if($("#first_name").val()==''){
					$("#first_name").focus();
					return false;
				}
				if($("#last_name").val()==''){
					$("#last_name").focus();
					return false;
				}
				if($("#email").val()==''){
					$("#email").focus();
					return false;
				}
				if(checkValidEmail($form_email)==false){
					$("#email").focus();
					return false;
				}
				if($("#telephone").val()==''){
					$("#telephone").focus();
					return false;
				}
				if(checkValidPhoneNumber($form_phone)==false){
					$("#telephone").focus();
					return false;
				}
				return true;
			});
		});


		function checkValidEmail(email){
			var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
		function checkValidPhoneNumber(phone)
		{
			var phoneno = /^\d{10,11}$/;
			if(phone.match(phoneno))
			return true;
			else
			return false;
		}
		var number_service=document.getElementById("number_service");
		var tourclass = $('select[name=tourclass]').val();
		var type = $('input[name=departure_date]').attr('data');
		loadPriceTableDepartureGroup(type,tour_id,$("input[name=departure_date]").val(),$("#tourclass").val(),1,0,0);
		loadStartEndDate($("input[name=departure_date]").val(),tour_id);
		var $ww = $(window).width();
		if($ww>768){
			$( ".fright768" ).remove();
		}
		if($ww<=768){
			$( ".768left" ).remove();
		}
		$('input[name=departure_date]').datepicker({
			dateFormat: "mm/dd/yy",
			minDate: new Date()
		});
		$(function(){
			$("#birthday").dateDropdowns({
				submitFieldName: 'birthday',
				minAge: 18
			});
			$('.upNum').click(function() {
				var number_person = $(this).val();
				var departure_date = $("input[name=departure_date]").val();
				var traveler_type_id = $(this).attr('traveler_type_id');
				var val = parseInt($("#national_visitor"+traveler_type_id).val());
				var max_number = parseInt($("#national_visitor"+traveler_type_id).attr('max-number'));
				val = val + 1;
				if (val > max_number) {
					alert(Input_data_is_invalid);
					val = max_number;
				}
				$("#national_visitor"+traveler_type_id).val(val);
				GetTourPriceByNumberGroup(type,tour_id,val,$("#tourclass").val(),departure_date,traveler_type_id);
				return false;
			});
			$('.unNum').click(function() {
				var number_person = $(this).val();
				var departure_date = $("input[name=departure_date]").val();
				var traveler_type_id = $(this).attr('traveler_type_id');
				var val = parseInt($("#national_visitor"+traveler_type_id).val());
				var min_number = parseInt($("#national_visitor"+traveler_type_id).attr('min-number'));
				val = val - 1;
				if (val < min_number) {
					alert(Input_data_is_invalid);
					val = min_number;
				}
				$("#national_visitor"+traveler_type_id).val(val);
				GetTourPriceByNumberGroup(type,tour_id,val,$("#tourclass").val(),departure_date,traveler_type_id);
				return false;
			});
			$('.upNumSev').click(function() {
				var number = $(this).val();
				var tour_service_id = $(this).attr('tour_service_id');
				var val = parseInt($("#numberService_"+tour_service_id).val());
				if($(this).attr('disabled')=='disabled'){
					val =val;
				}else{
					val = val+1;
				}
				$("#numberService_"+tour_service_id).val(val);
				getTotalRateServiceItem();
				tinhtoan();
				return false;
			});
			$('.unNumSev').click(function() {
				var number = $(this).val();
				var tour_service_id = $(this).attr('tour_service_id');
				var val = parseInt($("#numberService_"+tour_service_id).val());
				var min_number = parseInt($("#numberService_"+tour_service_id).attr('min'));
				if($(this).attr('disabled')=='disabled'){
					val =val;
				}else{
					val = val-1;
				}
				if (val < min_number) {
					val = min_number;
				}
				$("#numberService_"+tour_service_id).val(val);
				getTotalRateServiceItem();
				tinhtoan();
				return false;
			});
			$(document).on("change",".input_number",function(){
				var number_person = $(this).val();
				var max_person =$(this).attr('max-number');
				var departure_date = $("input[name=departure_date]").val();
				var tour_visitor_type_id = $(this).attr('tour_visitor_type_id');
				if(!isNaN(parseInt(number_person))){
					if(parseInt(number_person) >= 0 && parseInt(number_person) <= max_person){
						GetTourPriceByNumberGroup(type,tour_id,number_person,$("#tourclass").val(),departure_date,tour_visitor_type_id);
						}else{
						alert(Input_data_is_invalid);
						$(this).val(1);
						GetTourPriceByNumberGroup(type,tour_id,1,$("#tourclass").val(),departure_date,tour_visitor_type_id);
					}
					}else{
					alert(Input_data_is_invalid);
					$(this).val(1);
					GetTourPriceByNumberGroup(type,tour_id,1,$("#tourclass").val(),departure_date,tour_visitor_type_id);
				}
			});
			$(document).on('change','#tourclass',function(){
				var tourclass = $(this).val();
				var tour_visitor_type_id = $(this).attr('tour_visitor_type_id');
				var departure_date = $("input[name=departure_date]").val();
				if(!isNaN(parseInt(tourclass))){
					if(parseInt(tourclass) >= 0){
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+adult_type_id).val(),tourclass,departure_date,adult_type_id);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+child_type_id).val(),tourclass,departure_date,child_type_id);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+infant_type_id).val(),tourclass,departure_date,infant_type_id);
						}else{
						alert(Input_data_is_invalid);
						$(this).val(1);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+adult_type_id).val(),tourclass,departure_date,adult_type_id);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+child_type_id).val(),tourclass,departure_date,child_type_id);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+infant_type_id).val(),tourclass,departure_date,infant_type_id);
					}
					}else{
					alert(Input_data_is_invalid);
					$(this).val(1);
					GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+adult_type_id).val(),tourclass,departure_date,adult_type_id);
					GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+child_type_id).val(),tourclass,departure_date,child_type_id);
					GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+infant_type_id).val(),tourclass,departure_date,infant_type_id);
				}
			});
		});

		$('.chk_addOnService').each(function(){
			var $_this = $(this);
			if($_this.is(':checked')){
				$_this.closest('tr').find('input[class=input_service]').removeAttr('disabled');
				$_this.closest('tr').find('.unNumSev').removeAttr('disabled');
				$_this.closest('tr').find('.upNumSev').removeAttr('disabled');
			}else{
				$_this.closest('tr').find('input[class=input_service]').attr('disabled','disabled');
				$_this.closest('tr').find('.unNumSev').attr('disabled','disabled');
				$_this.closest('tr').find('.upNumSev').attr('disabled','disabled');
			}
		});
		$('.chk_addOnService').change(function(){
			var $_this = $(this);
			var addonservice_id =$_this.val();
			if($_this.is(':checked')){
				$_this.closest('tr').addClass('choosesv');
				$('#tour_service_'+addonservice_id).show();
				$_this.closest('tr').find('input[class=input_service]').removeAttr('disabled');
				$_this.closest('tr').find('.unNumSev').removeAttr('disabled');
				$_this.closest('tr').find('.upNumSev').removeAttr('disabled');
			}else{
				$_this.parents('tr').removeClass('choosesv');
				$('#tour_service_'+addonservice_id).hide();
				$_this.closest('tr').find('input[class=input_service]').attr('disabled','disabled');
				$_this.closest('tr').find('.unNumSev').attr('disabled','disabled');
				$_this.closest('tr').find('.upNumSev').attr('disabled','disabled');
			}
			getTotalRateService();
			tinhtoan();
		});
		$('input[name=payment_method]').change(function(){
			var _val = $(this).val();
			if(_val==3){
				var Surcharge = ONEPAY_Surcharge;
			}else if(_val==4){
				var Surcharge = ONEPAY_Visa_Surcharge;
			}else if(_val==5){
				var Surcharge = Paypal_Surcharge;
			}else if(_val==6){
				var Surcharge = ONEPAY_American_Express_Surcharge;
			}else{
				var Surcharge = 0;
			}
			if(Surcharge >0){
				$(".extracharges").show();
				$("#surcharge").val(Surcharge);
			}else{
				$(".extracharges").hide();
				$("#surcharge").val(Surcharge);
			}
			tinhtoan();
		});
		$("#voucher_code").keyup(function () {
			var minlength = 6;
			var _this = $(this);
			$(".error_row_voucher_code").html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw c-gray"></i>');
			setTimeout(function(){
			if (_this.val().length >= minlength) {

					$.ajax({
						'type': 'POST',
						'url' : path_ajax_script+'/index.php?mod=home&act=ajCheckPromotionPro',
						'data' : {"voucher":_this.val(),"type":"Tour"},
						'dataType': 'json',
						'success':function(html){
							if(html.result == 'success'){
								$(".error_row_voucher_code").html('<i class="fa fa-check-circle c-green"></i>');
								$(".promoion_voucher").html(html.verify);
								tinhtoan();
							}
							if(html.result == 'error'){
								var promotion_check=0;
								$(".error_row_voucher_code").html('<i class="fa fa-times-circle c-red"></i>');
								$("#promotion").val('');
								$("#price_promotion_post").val('');
								tinhtoan();
								$(".promoion_voucher").html('');
							}
						}
					});


			}else if (_this.val().length == '') {
					var promotion_check=0;
					$(".error_row_voucher_code").html('');
					$("#promotion").val('');
					$("#price_promotion_post").val('');
					tinhtoan();
					$(".promoion_voucher").html('');
			}else{
					var promotion_check=0;
					$(".error_row_voucher_code").html('<i class="fa fa-times-circle c-red"></i>');
					$("#promotion").val('');
					$("#price_promotion_post").val('');
					tinhtoan();
					$(".promoion_voucher").html('');
			}
			}, 2000);
		});

		getTotalRateService();

		function getTotalRateService() {
			var $totalService = 0;
			var $totalRate = 0;
			$('.trRowSv.choosesv').each(function(){
				var $_this = $(this);
				var $addonservice_id = $_this.attr('addonservice_id');
				var $extra = $_this.attr('extra');
				var $price=0;
				if($extra==1){
					$price += parseInt($_this.find('#tourPriceSv'+$addonservice_id).val());
				}else if($extra==2){
					$price += parseInt($_this.find('#tourPriceSv'+$addonservice_id).val());
				}else{
					$price +=$price;
				}
				$totalRate += $price;

				$totalService = $totalService + 1;
				if($totalService>0){
					$('#boxService').show();
					number_service.innerHTML=$totalService;
				}else{
					$('#boxService').hide();
				}
			});
			if($totalService>0){
				$('#boxService').show();
			}else{
				$('#boxService').hide();
				number_service.innerHTML=0;
			}
			price_total_service.innerHTML = $totalRate.format();
			price_total_service_post.value = $totalRate;
		}
		function getTotalRateServiceItem() {
			var $totalRate = 0;
			$('.trRowSv.choosesv').each(function(){
				var $_this = $(this);
				var $addonservice_id = $_this.attr('addonservice_id');
				var $extra = $_this.attr('extra');
				var $price=0;
				if($extra==1){
					$price +=parseInt($_this.find('#PriceServiceItem'+$addonservice_id).val());
				}else if($extra==2){
					$price += parseInt($_this.find('#PriceServiceItem'+$addonservice_id).val()) * parseInt($_this.find('#numberService_'+$addonservice_id).val());
				}else{
					$price +=$price;
				}
				$totalRate += $price;
				$('#tourPriceSv'+$addonservice_id).val($price);
				$('#rate_one_tour_service_'+$addonservice_id).html($price);
			});
			price_total_service.innerHTML = $totalRate.format();
			price_total_service_post.value = $totalRate;

		}
	})
</script>
{/literal}

<script defer src="{$URL_JS}/tipsy/tipsy.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/tipsy/tipsy.css?v={$upd_version}">