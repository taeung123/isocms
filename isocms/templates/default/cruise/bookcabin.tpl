<script defer type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_CSS}/bookingcruise.css?v={$upd_version}">
{assign var=title_cruise_booking value=$clsCruise->getTitle($cruise_id)}
<div class="page_container">
	<div class="breadcrumb-main bg_fff">
		<div class="container">
			<ol class="breadcrumb bg_fff mt0" itemscope itemtype="https://schema.org/BreadcrumbList"> 
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}{$extLang}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Cruise')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Cruise')}</span> </a>
					<meta itemprop="position" content="2" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Booking')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Booking')}</span></a>
					<meta itemprop="position" content="3" />
				</li>
			</ol>
		</div>
	</div>
	<div class="container">
		<form class="bk-form-info" id="frmRateCruise" method="post" action="" novalidate>
			<div class="row">
				<div class="col-md-9 mb992_30">
					<div class="bk-media media">
						<div class="photo">
							<img src="{$clsCruise->getImage($cruise_id,275,205)}" alt="{$title_cruise_booking}" width="100%" height="auto"/>
						</div>
						<div class="infobooking">
							{assign var= ratingCount value= $clsReviews->getToTalReview($cruise_id,'Cruise')}
							<h1 class="inline-block">{$title_cruise_booking}</h1>
							<div class="box-review inline-block mgl10">
							<label class="rate-1">
							{$clsReviews->getStarNew($cruise_id,'Cruise')} 
							</label>
							</div>
							<span class="address block mb05"><i class="icon_cd icon_map"></i><span>{$core->get_Lang('Address')}:</span> {$clsCruise->getAllCityAround($cruise_id)}</span>
							<span class="block mb05"><i class="fa fa-calendar" aria-hidden="true"></i><span class="inline-block w40">{$core->get_Lang('Departure date')}:</span> <span class="color_666">{$departure_date}</span></span>
							<span class="block mb05"><i class="fa fa-clock-o" aria-hidden="true"></i><span class="inline-block w40">{$core->get_Lang('Duration')}:</span> <span class="color_666">{$clsCruiseItinerary->getTitleDay($cruise_itinerary_id)}</span></span>
							<span class="block mb05"><i class="fa fa-user-plus" aria-hidden="true"></i><span class="inline-block w40">{$core->get_Lang('Passengers')}:</span> <span class="color_666">{$number_adult}</span></span>
							{*<span class="block mb05"><i class="fa fa-check" aria-hidden="true"></i><span class="inline-block w40">{$core->get_Lang('Conditions')}:</span> </span>
							<div class="caption color_main">
                                <p class="c2d">{$core->get_Lang('We allow great flexibility when you have to cancel your trip and charge a minimal fee')}. <br>
                                {$core->get_Lang('View booking conditions')}. 
								<a id="Conditions_{$cruise_id}" class="tipcabin"><i class="fa fa-question-circle"></i></a>
								{literal}
								<script type="text/javascript">
									document.addEventListener("DOMContentLoaded", function () {
										$(document).ready(function(){
											$('#Conditions_{/literal}{$cruise_id}{literal}').tipsy({
												fallback: '{/literal}{$clsCruiseItinerary->getCancellation($cruise_itinerary_id)}{literal}',
												gravity: 'n',
												width: '400px'
											});
										});
									})
								</script>
								{/literal}
                                </p>
                            </div>*} 
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="bk-page-title">
						<h3 class="text_upper">{$core->get_Lang('BOOKING INFORMATION')}</h3>
						<p>{$core->get_Lang('It takes less than a minute to complete our booking form. You are now just one step away from confirming your booking')}.</p>
					</div>
					<div class="clearfix"></div>
					<div class="bk-info bk-room-info">
						<h4 class="text_upper">{$core->get_Lang('Cabin detailed')}</h4>
						<div class="bk-info-body">
						{$clsCruiseCabin->getListCabinBooking($number_cabin,$max_adult,$cruise_cabin_id,$arraycheckrateCabin)}
						</div>
					</div>
					{if $clsConfiguration->getValue('SiteHasCruisesService')}
						{if $clsCruiseItinerary->getOneField('listService',$cruise_itinerary_id) ne ''}
						<div class="clearfix"></div>
						<div class="bk-info bk-transfer bk-bus">
							<h4 class="text_upper">{$core->get_Lang('Transfer Services')}</h4>
							<table border="0" cellpadding="0" cellspacing="0" class="table-service table-data">
								<tr>
									<th>{$core->get_Lang('Service Name')}</th>
									<th class="text-center">{$core->get_Lang('Quantity')}</th>
									<th class="text-center">{$core->get_Lang('Price')}</th>
								</tr>
								{section name=i loop=$listService}
								{if $clsISO->checkContainer($oneItinerary.listService,$listService[i].cruise_service_id)}
								<tr class="trRowSv" cruise_service_id="{$listService[i].cruise_service_id}">
									<td>
										{if $listService[i].extra eq '0'}
										{assign var=price value=0}
										{assign var=value_price value=0}
										{else}
										{assign var=value_price value=$clsCruiseService->getOneField('price',$listService[i].cruise_service_id)}
										{assign var=price value=$clsCruiseService->getPrice($listService[i].cruise_service_id)}
										{/if}
										<input type="hidden" id="cruisePriceSv{$listService[i].cruise_service_id}" value="{$value_price}" />
										
										<label><input {if $clsISO->checkItemInArray($listService[i].cruise_service_id,$addOnService)}checked="checked"{/if} type="checkbox" name="addOnService[]" class="chk_addOnService" value="{$listService[i].cruise_service_id}" price="{$value_price}" /> {$clsCruiseService->getTitle($listService[i].cruise_service_id)}</label>
										<a id="addOnService_{$listService[i].cruise_service_id}" class="tipcabin"><img src="{$URL_IMAGES}/help.png" align="absmiddle" /></a>
										{literal}
										<script type="text/javascript">
											document.addEventListener("DOMContentLoaded", function () {
												$(document).ready(function(){
												$('#addOnService_{/literal}{$listService[i].cruise_service_id}{literal}').tipsy({
												fallback: '{/literal}{$clsCruiseService->getIntro($listService[i].cruise_service_id)}{literal}',
												gravity: 'n',
												width: '400px'
												});
												});
											})
										</script>
										{/literal}
									</td>
									<td class="text-center">
										<select onchange="changeToRateServices({$listService[i].cruise_service_id},$(this));" extra="{$listService[i].extra}" disabled="disabled" class="select-lg" name="adultService[{$listService[i].cruise_service_id}]">
										{$clsISO->getSelect(1,10)}
										</select>
									</td>
									<td colspan="2" class="text-center">
										{if $listService[i].extra eq '0'}
										{$core->get_Lang('Included')}
										{else}
										{if $_LANG_ID eq 'vn'}
											<span id="svRate{$listService[i].cruise_service_id}">{$clsCruiseService->getPrice($listService[i].cruise_service_id)}</span> {$clsISO->getRate()}
											{else}
											{$clsISO->getRate()} <span id="svRate{$listService[i].cruise_service_id}">{$clsCruiseService->getPrice($listService[i].cruise_service_id)}</span>
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
				<div class="col-md-3">
					<div class="bk-price">
						<div class="bk-price-info">
							<div class="no-card text-center">
							{$core->get_Lang('No credit card fees')}!
							</div>
							<p class="mb015 size18">{$core->get_Lang('Your booking includes')}:</p>
							<div class="list-dot mb20">
								{assign var=site_cruise_include value=site_cruise_include_|cat:$_LANG_ID}
								{$clsConfiguration->getValue($site_cruise_include)|html_entity_decode}
							</div>
							<hr>
							<table>
								<tbody>
									<tr>
										<td>{$number_cabin} {$core->get_Lang('Cabin')}</td>
										{if $_LANG_ID eq 'vn'}
										<td align="right">{$totalPrice_format} {$clsISO->getRate()}</td>
										{else}
										<td align="right">{$clsISO->getRate()} {$totalPrice_format}</td>
										{/if}
										<input type="hidden" name="totalRateCabin" class="totalRateCabin" value="{$totalPrice}">
									</tr>
									<tr {if $clsConfiguration->getValue('SiteHasCruisesService')}{else}style="display:none"{/if}>
										<td>{$core->get_Lang('Extra Services')}</td>
										<td align="right">
											{if $_LANG_ID eq 'vn'}
											<span id="totalRateService">0</span> {$clsISO->getRate()}
											{else}
											{$clsISO->getRate()} <span id="totalRateService">0</span>
											{/if}
											<input type="hidden" name="price_service" id="price_service" value="0">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="bk-price-total">
							<table>
								<tbody>
									<tr>
										<td style="font-size:11px; color:#666">
										<span class="block size20 mb05 color_333">{$core->get_Lang('Price')}</span> ({$core->get_Lang('for')} {$number_adult} {$core->get_Lang('Adults')}{if $number_child gt 0}, {$number_child} {$core->get_Lang('Child')}{/if})
										</td>
										<td align="right" class="size20">
										{if $_LANG_ID eq 'vn'}
										<span id="totalRate">{$totalPrice}</span> {$clsISO->getRate()}
										{else}
										{$clsISO->getRate()} <span id="totalRate">{$totalPrice}</span>
										{/if}
										<input type="hidden" id="totalGrand" name="totalGrand" value="{$totalPrice}" />
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<p class="color_666">{$core->get_Lang('Rates are quoted in')} <span class="color_333">{$clsISO->getRate()}.</span></p>
					</div>
				</div>
				<div class="col-md-9">
					<div class="clearfix"></div>
					<div class="bk-info bk-contact-info">
						<h4 class="text_upper">{$core->get_Lang('Personal details')}</h4>
						<div class="bk-info-body">
							{if $errMsg ne ''}
							<div class="alert alert-info">
							  <strong>{$core->get_Lang('Warning')}!</strong>
								{$errMsg}
							</div>
							{/if} 
							<div class="row">
								<div class="col-md-2 col-sm-2">
									<div class="form-group appearance_none">
										<select class="form-control" name="title" id="title">
											<option {if $title eq '.Mr'}selected="selected"{/if} value=".Mr">{$core->get_Lang('.Mr')} </option>
											<option {if $title eq '.Mrs'}selected="selected"{/if} value=".Mrs">{$core->get_Lang('.Mrs')} </option>
											<option {if $title eq '.Ms'}selected="selected"{/if} value=".Ms">{$core->get_Lang('.Ms')} </option>
										</select>
									</div>
								</div>
								<div class="col-md-10 col-sm-10">
									<div class="row">
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<input type="text" class="form-control required"  name="first_name" value="{$first_name}" id="first_name" placeholder="{$core->get_Lang('First name')}">
											</div>
											<div class="form-group">
												<input type="email" class="form-control required"  name="email" value="{$email}" placeholder="{$core->get_Lang('Email')}" id="email">
											</div>
											<div class="form-group appearance_none">
												<select type="country" class="form-control required"  name="country" value="{$country}" placeholder="" id="country">
												{$clsCountry->getSelectByCountry($country_id)}
												</select>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<input type="text" class="form-control required"  name="last_name" value="{$last_name}" id="last_name" placeholder="{$core->get_Lang('Last name')}">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="{$core->get_Lang('Phone')}" id="phone"  name="phone" value="{$phone}">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" value="" placeholder="{$core->get_Lang('Address for pick up in Hanoi')}" name="address" id="address">
											</div>
										</div>
									</div>
									<div class="form-group">
										<textarea class="form-control" rows="5" name="content" id="content" style="height:150px" placeholder="{$core->get_Lang('If you have any special requests (special dietary requirements, child car seat, kid meal), please let us know')}."></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="bk-info bk-billing-info">
						<h4 class="text_upper">{$core->get_Lang('Billing information')}</h4>
						{if $clsISO->getVar('PAYMENT_GLOBAL') eq '1'}
							{$core->getBlock('pay_gateway')}
						{/if}
					</div>
					<div class="bk-btn text-right">
						<div class="row">
							<div class="col-md-10">
                            	{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" maxlength="5" id="security_code" name="security_code" style="float:left; width:100%; margin-right:5px; height:43px" class="form-control required" />
									<div id="error_security" class="error_security"></div>
									<!--<span class="vietiso_error" style="display:none;color:#ff0000">Captcha enter incorrect!</span>  --> 
								</div>
								<div class="col-md-3 col-sm-3 col-xs-6 text-center">
									<img class="capcha_code" src="{$PCMS_URL}/captcha.php?sid={$sid}"  onclick="this.src='{$PCMS_URL}captcha.php?'+Math.random()+'&sid={$sid}';" width="80px" height="43px"  style="line-height:43px"/>
								</div>
                                {else}
                                <div class="col-md-7 col-xs-7">
                                	<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                                </div>
                                {/if}
								<div class="col-md-5 col-xs-5">
									<button type="submit" class="btnBookCabin btn_main">{$core->get_Lang('Next step')} <i class="fa fa-angle-right"></i></button>
									<input type="hidden" name="HidBookNow" value="HidBookNow" />
									<input type="hidden" name="number_room" value="{$number_cabin}" />
									<input type="hidden" name="cruise_cabin_id" value="{$cruise_cabin_id}" />
									<input type="hidden" name="cruise_itinerary_id" value="{$cruise_itinerary_id}" />
									<input type="hidden" name="departure_date" value="{$departure_date}" />
									<input type="hidden" name="number_adult" value="{$number_adult}" />
									<input type="hidden" name="number_child" value="{$number_child}" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>
		</form>
	</div>
</div>
<div class="clearfix"></div>
<div id="stickyOffsetOut"></div>
<script type="text/javascript">
var $cruise_id = "{$cruise_id}";
</script>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		$('.bk-info-body .number_room').each(function(idx){
			var $_this = $(this);
			var id=idx+1;
			$_this.val(idx+1);
			$_this.attr("name", "number_room_"+id);
		});
		$('.bk-info-body .number_adult').each(function(idx){
			var $_this = $(this);
			var id=idx+1;
			$_this.attr("name", "number_adult_"+id);
		});
		$('.bk-info-body .number_child').each(function(idx){
			var $_this = $(this);
			var id=idx+1;
			$_this.attr("name", "number_child_"+id);
		});
		$('#frmRateCruise').validate();
		var stickyOffsetSB = $('#frmRateCruise').offset().top;
		var stickyOffsetOut =$('#frmRateCruise').outerHeight()-300;
		var $ww = $(window).width();
		var $col_left_width = $('.bk-price').width();
		if($ww >1024){
			$(window).scroll(function(){
				var sticky = $('.bk-price'),
				scroll = $(window).scrollTop();
				console.log(scroll);
				console.log(stickyOffsetSB);
				console.log(stickyOffsetOut);
				if (scroll >= stickyOffsetSB && scroll <= stickyOffsetOut){
				sticky.addClass('fixed');
				$('.bk-price').width($col_left_width);
				}
				else{
				sticky.removeClass('fixed');
				}
			});
			
		}
	})
</script>
{/literal}
<script defer type="text/javascript" src="{$URL_JS}/jquerycruise.js?v={$upd_version}"></script>
<script defer type="text/javascript" src="{$URL_JS}/tipsy/tipsy.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/tipsy/tipsy.css?v={$upd_version}">