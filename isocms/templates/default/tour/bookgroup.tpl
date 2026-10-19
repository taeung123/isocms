{assign var=title_tour value=$clsTour->getTitle($tour_id)}
<div class="page_container" id="tour_page_container">
	<div class="breadcrumb-main bg_fff">
		<div class="container">
			<div class="row">
				<ol class="breadcrumb bg_fff hidden-xs mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('Home')}">
							<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
						<meta itemprop="position" content="1" />
					</li>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsCountryEx->getLink($country_id,'Tour')}" title="{$clsCountryEx->getTitle($country_id)}">
							<span itemprop="name" class="reb">{$clsCountryEx->getTitle($country_id)} {$core->get_Lang('Tours')}</span></a>
						<meta itemprop="position" content="2" />
					</li>
					<li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsTour->getLink($tour_id)}" title="{$clsTour->getTitle($tour_id)}">
							<span itemprop="name" class="reb">{$clsTour->getTitle($tour_id)}</span></a>
						<meta itemprop="position" content="3" />
					</li>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<span itemprop="name" class="reb">{$core->get_Lang('Booking Tours')}</span>
						<meta itemprop="position" content="4" />
					</li>
				</ol>
			</div>	
		</div>
	</div>
    <section id="booking" class="variantdatabg pd40_0">
		<form action="" method="post" class="formBookingTour">
			<input type="hidden" id="name_tour" name="name_tour" value="{$title_tour}">
			<input type="hidden" id="code_tour" name="code_tour" value="{$clsTour->getTripCode($tour_id)}">
			<input type="hidden" id="id" name="id" value="{$tour_id}">
			<div class="info_tour_option">
				<div class="container">
					<div id="page-maincontent">
						<div class="header_booking_page mb30 clearfix">
							<div class="photo_thumb">
								<img class="img-responsive" src="{$clsTour->getImage($tour_id,450,300)}" width="100%" alt="{$title_tour}"/>
							</div>
							<div class="entry_info_content">
								<h1 class="pagemaintitle">{$title_tour}</h1>
								<div class="rate_box">
									<label class="rate-1">
										{$clsReviews->getStarNew($tour_id,'tour')} 
									</label>
									{$clsReviews->getToTalReview($tour_id,'tour')} {$core->get_Lang('reviews')} 
								</div>	
								<div class="dration_box">
									<span class="fa fa-clock-o" aria-hidden="true"></span>
									<span class="color_333">{$core->get_Lang('Duration')}: </span>
									<span class="color_333">{$clsTour->getLTripDuration($tour_id)}</span>
								</div>
								<div class="destination_box">
									{assign var=address_des value=$clsTour->getCityAround($tour_id)}
									{if $address_des}
										<span class="fa fa-map-marker" aria-hidden="true"></span>
										{$address_des}
									{/if}
								</div>
							</div>
						</div><!--end header_booking_page-->
						<div class="infoBooking">
							<div class="infoTour">
								<h3>{$core->get_Lang('Booking Information')}</h3>
								<div class="has-feedback form-group">
									<div class="row">
										<div class="col-md-4 col-sm-6 mb767_15">
											<p>{$core->get_Lang('Choose your date')}</p>
											{if $show eq 'Departure'}
											<input type="text" name="departure_date" value="{$departure_date|date_format:"%m/%d/%Y"}" placeholder="mm/dd/yyyy" class="dateTxt2 required datepicker inputDate form-booking_input isoTxt tbdate hasDatePicker" data="Departure" />
											{else}
											<input type="text" name="departure_date" value="{$now_next|date_format:"%m/%d/%Y"}" placeholder="mm/dd/yyyy" class="dateTxt2 required datepicker inputDate form-booking_input isoTxt tbdate hasDatePicker" data="NoDeparture" />
											{/if}
										</div>
										<div class="col-md-3 col-sm-6">
											<p>{$core->get_Lang('Choose tour class')}</p>
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
								<div class="mt30 mb15"> 
									<span class="head-book">{$core->get_Lang('Tour price')}</span> 
								</div>
								<table class="table table-striped" width="100%" id="priceTableDeparture"></table>
							</div>
							<div class="listCustome mt40">
								<h3>{$core->get_Lang('Enter a list of travelers')}</h3>
								<div class="table table-border travelers_info">
									<div class="mb10 hidden768 title">
										<span>{$core->get_Lang('No.')}</span>
										<span>{$core->get_Lang('Full name')}</span>
										<span>{$core->get_Lang('Birthday')}</span>
										<span>{$core->get_Lang('Address')}</span>
										<span>{$core->get_Lang('Gender')}</span>
										<span>{$core->get_Lang('Traveler Types')}</span>
									</div>
									<div id="customer_list">
										{section name=i loop=$total_people}
										<div>
											<span class="mb10"><input type="text" class="form-control form-booking_input" value="{$smarty.section.i.iteration}"></span>
											<span><input type="text" class="form-control form-booking_input" name="input_{$smarty.section.i.index}.name" id="input_{$smarty.section.i.index}.name"></span>
											<span class="mb10"><input type="text" class="form-control form-booking_input datepicker inputDate" name="input_{$smarty.section.i.index}.birthday" id="input_{$smarty.section.i.index}.birthday"></span>
											
											<span class="mb10"><input type="text" class="form-control form-booking_input" name="input_{$smarty.section.i.index}.address" id="input_{$smarty.section.i.index}.address"></span>
											<span class="mb10">
												<select class="form-control form-booking_input" name="input_{$smarty.section.i.index}.gender" id="input_{$smarty.section.i.index}.gender">
													<option value="{$core->get_Lang('Female')}">{$core->get_Lang('Female')}</option>
													<option value="{$core->get_Lang('Male')}">{$core->get_Lang('Male')}</option>
												</select>
											</span>
											<span class="mb10">
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
							</div><!--end listCustome-->  
							<div class="infoCustome mt40">
								<h3>{$core->get_Lang('Contact Detail')}</h3>
								<div class="row">
									<div class="col-md-3 form-group">
										<div class="tour select_arow">
											<select id="title" name="title" class="form-booking_input find_select"> 
												{$clsISO->makeSelectTitle($title)}
											</select>
										</div>	
									</div>
									<div class="clearfix"></div>
									<div class="col-md-6 form-group">
										<input name="first_name" placeholder="{$core->get_Lang('First name')}*" type="text" class="form-booking_input" value="{$firstname}"/>
									</div>
									<div class="col-md-6 form-group">
										<input name="last_name" placeholder="{$core->get_Lang('Last name')}*" type="text" class="form-booking_input" value="{$lastname}"/>
									</div>
									<div class="col-md-6 form-group">
										<input name="email" placeholder="{$core->get_Lang('Email Address')}*" type="email" class="form-booking_input" value="{$email}"/></td>
									</div>
									<div class="col-md-6 form-group">
										<input name="telephone" placeholder="{$core->get_Lang('TelePhone')}" type="text" class="form-booking_input" value="{$phone}">
									</div>
									<div class="col-md-6 form-group">
										<div class="tour select_arow"> 
											<select name="country_id"  class="form-booking_input find_select">
												{$clsCountryBK->getSelectByCountry($country_id)}
											</select>
										</div>	
									</div>
									<div class="col-md-6 form-group">
										<input name="address_pick_up" placeholder="{$core->get_Lang('Address pick up in Hanoi')}" type="text" class="required form-booking_input">
									</div>
									<div class="col-md-12 form-group mb0">
										<textarea rows="5" class="form-control" cols="50" name="note" placeholder="{$core->get_Lang('If you have any special requests (special dietary requirements. child car seat. kid meal), please let us know')}."></textarea>
									</div>
								</div>
							</div><!--end infoCustome-->
							{if $clsConfiguration->getValue('SiteHasService_Tours')}
								{if $oneItem.list_service_id ne ''}
								<div class="clearfix mt30"></div>
								<div class="bk-transfer bg_fff">
									<h3>{$core->get_Lang('Transfer Services')} <span class="size16">({$core->get_Lang('optional')})</span></h3>
									<table border="0" cellpadding="0" cellspacing="0" class="table-cabin table-data">
										<tr>
											<th align="left">{$core->get_Lang('Name of service')}</th>
											<th align="center" class="text-center">{$core->get_Lang('Quantity')}</th>
											<th align="center" class="text-center">{$core->get_Lang('Price')}</th>
										</tr>
										{section name=i loop=$lstTourService|@count}
										{if $clsISO->checkContainer($oneItem.list_service_id,$lstTourService[i])}
										<tr class="trRowSv" addonservice_id="{$lstTourService[i]}" extra="{$clsAddOnService->getExtra($lstTourService[i])}">
											<td>
												<input type="hidden" id="tourPriceSv{$lstTourService[i]}" value="{$clsAddOnService->getOneField('price',$lstTourService[i])}" />
												<input type="hidden" id="PriceServiceItem{$lstTourService[i]}" value="{$clsAddOnService->getOneField('price',$lstTourService[i])}" />
												<label><input {if $clsISO->checkItemInArray($lstTourService[i],$addOnService)}checked="checked"{/if} type="checkbox" name="addOnService[]" class="chk_addOnService" value="{$lstTourService[i]}" price="{$clsAddOnService->getPrice($lstTourService[i])}" /> {$clsAddOnService->getTitle($lstTourService[i])}</label>
												<a id="addOnService_{$lstTourService[i]}" class="tipcabin"><img src="{$URL_IMAGES}/help.png" align="absmiddle" /></a>
												{literal}
												<script type="text/javascript">
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
											<td class="text-center" >
												<input type="number" id="numberService_{$lstTourService[i]}" name="number_tourservice[{$lstTourService[i]}]" class="input_service" min="1" disabled="disabled" value="1" extra="{$clsAddOnService->getExtra($lstTourService[i])}" style="width: 50px; text-align:center">
												{literal}
												<script type="text/javascript">
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
											<td class="text-center" style="display:none">
												<select onchange="changeToRateServices({$lstTourService[i]},$(this));" extra="{$clsAddOnService->getExtra($lstTourService[i])}" disabled="disabled" class="select-lg" name="adultService[{$lstTourService[i]}]">
													{$clsISO->getSelect(1,10)}
												</select>
												<label>{$core->get_Lang('Adult')}(s)</label>
												<select disabled="disabled" class="select-lg" name="childService[{$lstTourService[i]}]">
													{$clsISO->getSelect(0,10)} 
												</select>
												<label>{$core->get_Lang('Child')}(s)</label>
											</td>
											<td colspan="2" class="text-center">
												{if $clsAddOnService->getExtra($lstTourService[i]) eq '0'}
													{$core->get_Lang('Included')}
												{else}
													{$clsISO->getRate()} <span id="svRate{$lstTourService[i]}">{$clsAddOnService->getPrice($lstTourService[i])}</span>
												{/if}
											</td>
										</tr>
										{/if}
										{/section}
									</table>
								</div>
							{/if}
							{/if}
							<div class="billing_infomation mt40">
								{if $clsISO->getVar('PAYMENT_GLOBAL') eq '1'}
									{$core->getBlock('pay_gateway')}
								{/if}
								{*<input type="checkbox" class="mb10"  name="agree" value="1" checked="">
								{$core->get_Lang('I have read and agree to the terms of use and the privacy policy')} <br>*} 
								<div class="col-md-3 col-md-offset-2 mt40">
									<button class="btn-bookinggroup" type="submit">
										{$core->get_Lang('Next Step')}
									</button>
								</div>
								<input type="hidden" name="booking" value="booking">
							</div>
						</div><!--end infoBooking-->
						
					</div><!--end page-maincontent-->
				</div><!--end container-->	
			</div><!-- end info_tour_option-->
		</form>	
	</section>
</div>
<script type="text/javascript">
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
	var Traveller = '{$core->get_lang("Traveller")}';
	var FullName = '{$core->get_lang("FullName")}';
	var DateofBirth = '{$core->get_lang("Date of Birth")}';
	var Address = '{$core->get_lang("Address")}';
	var Female = '{$core->get_lang("Female")}';
	var Male = '{$core->get_lang("Male")}';
	var Gender = '{$core->get_lang("Gender")}';
	var Adult = '{$core->get_lang("Adult")}';
	var Children = '{$core->get_lang("Children")}';
	var Infant = '{$core->get_lang("Infant")}';
	var loading = '{$core->get_lang("loading")}';
</script> 
<script defer type="text/javascript" src="{$URL_JS}/bookinggroup.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		var tourclass = $('select[name=tourclass]').val();
		var type = $('input[name=departure_date]').attr('data');
		loadPriceTableDepartureGroup(type,tour_id,$("input[name=departure_date]").val(),$("#tourclass").val(),1,0,0);
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
			$(document).on("change",".input_number",function(){
				var number_person = $(this).val();
				var departure_date = $("input[name=departure_date]").val();
				var tour_visitor_type_id = $(this).attr('tour_visitor_type_id');
				if(!isNaN(parseInt(number_person))){
					if(parseInt(number_person) >= 0){
						GetTourPriceByNumberGroup(type,tour_id,number_person,$("#tourclass").val(),departure_date,tour_visitor_type_id);
						}else{
						alert("Input data is invalid");
						$(this).val(1);
						GetTourPriceByNumberGroup(type,tour_id,1,$("#tourclass").val(),departure_date,tour_visitor_type_id);
					}
					}else{
					alert("Input data is invalid");
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
						alert("Input data is invalid");
						$(this).val(1);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+adult_type_id).val(),tourclass,departure_date,adult_type_id);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+child_type_id).val(),tourclass,departure_date,child_type_id);
						GetTourPriceByNumberGroup(type,tour_id,$("#national_visitor"+infant_type_id).val(),tourclass,departure_date,infant_type_id);
					}
					}else{
					alert("Input data is invalid");
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
			}else{
				$_this.closest('tr').find('input[class=input_service]').attr('disabled','disabled');
			}
		});
		$('.chk_addOnService').change(function(){
			var $_this = $(this);
			if($_this.is(':checked')){
				$_this.closest('tr').addClass('choosesv');
				$_this.closest('tr').find('input[class=input_service]').removeAttr('disabled');
			}else{
				$_this.parents('tr').removeClass('choosesv');
				$_this.closest('tr').find('input[class=input_service]').attr('disabled','disabled');
			}
			getTotalRateService();
			tinhtoan();
		});	
	})
</script> 
{/literal}
<script defer type="text/javascript" src="{$URL_JS}/tipsy/tipsy.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/tipsy/tipsy.css?v={$upd_version}">