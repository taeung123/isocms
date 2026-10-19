{assign var=adultTxt value=$core->get_Lang('adult')}
{assign var=adultsTxt value=$core->get_Lang('adults')}
{assign var=childTxt value=$core->get_Lang('child')}
{assign var=childrenTxt value=$core->get_Lang('children')}
{assign var=babyTxt value=$core->get_Lang('baby')}
{assign var=babiesTxt value=$core->get_Lang('babies')}
{assign var=roomTxt value=$core->get_Lang('room')}
{assign var=roomsTxt value=$core->get_Lang('rooms')}
{assign var=breakfast value=$core->get_Lang('breakfast')}
{assign var=lunch value=$core->get_Lang('lunch')}
{assign var=dinner value=$core->get_Lang('dinner')}
{assign var=travelby value=$core->get_Lang('travelby')}
{assign var=language value=$core->get_Lang('language')}
<div class="page_container">
	<div class="breadcrumb-main breadcrumb-{$mod} bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Travel Styles')}" itemprop="url">
						<span itemprop="name" class="reb">{$core->get_Lang('Tailor made tour')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
				{if $tour_id}
				{assign var=itemTour value=$clsTour->getOne($tour_id,'title,slug,trip_code')}
				{assign var=titleTour value=$clsTour->getTitle($tour_id,$itemTour)}
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$clsTour->getLink($tour_id,$itemTour)}" title="{$titleTour}">
						<span itemprop="name" class="reb">{$titleTour}</span></a>
					<meta itemprop="position" content="3" />
				</li>
				{/if}   
			</ol>
		</div>
	</div>
    <div id="contentPage" class="pageTailor pd40_0">
        <div class="container">
            <div id="booking" class="rowbox primary mb120">
				<h1 class="headMod size32 color_333 mb10">{$core->get_Lang('Tailor Made Your Itinerary')}</h1>
				<i class="note font13px">
					{$core->get_Lang('The fields with')} <em class="requied">*</em> {$core->get_Lang('are compulsory')}
				</i>
				{assign var=site_tailor_intro value=site_tailor_intro_|cat:$_LANG_ID}
				{if $clsConfiguration->getValue($site_tailor_intro)}
				<div class="formatTextStandard">{$clsConfiguration->getValue($site_tailor_intro)|html_entity_decode}</div>
				{/if}
				<div class="form-book wrap mt20">
					
					{if $errMsg ne ''}<div class="message_box corner-3px mb20 color_f00">{$errMsg}</div>{/if}
					<form method="post" action="" name="form_customize" id="form_customize" class="frmCrxBook form-horizontal">
						<div class="wrap mtls" style="display: none">
							<ul id="clienttabs">
								<li><a {if $type ne '2'}class="current"{/if}>{$core->get_Lang('Simple Form')}</a></li>
								<li><a {if $type eq '2'}class="current"{/if}>{$core->get_Lang('Advanced Form')}</a></li>
							</ul>
						</div>
						<div class="clearfix"></div>
						{if $tour_id ne ''}
						<h2 class="headbox size24 mb10">{$core->get_Lang("You&#39;re are interested in this tour")}</h2>
						<div class="tourbox-info">
							<p class="mb05">{$core->get_Lang('Name of tours')} : <strong>{$clsTour->getTitle($tour_id,$itemTour)}</strong></p>
							{if $clsTour->getTripCode($tour_id) ne ''}
							<p class="mb05">{$core->get_Lang('Trip code')} : <strong>{$clsTour->getTripCode($tour_id,$itemTour)}</strong></p>
							{/if}
							<p class="mb05">{$core->get_Lang('Trip duration')} : <strong>{$clsTour->getTripDuration($tour_id)}</strong></p>
						</div>
						{/if}
						<div class="main_tour_cus">
							<div class="wrap" id="tabs_content">
								<div class="customize_tabbox" style="{if $type ne '2'}display:block{else}display:none{/if}">
									<div class="form-group CalenderBook">
									<h2 class="tit wrap mobi-title size20">{$core->get_Lang('Tour information')}</h2>
										<div class="row">
											<div class="col-md-3 col-sm-6 col-xs-6">
												<div class="form-group">
													{if $_LANG_ID eq 'vn'}
													<label class="title full-width">{$core->get_Lang('Start date')} (dd/mm/yyyy)</label>
													<div class="clearfix"></div>
													<input class="dateTxt2 required form-control" name="date_begin_simple" type="text" value="{if $date_begin_simple ne ''}{$date_begin_simple}{else}{$now|date_format:"%d/%m/%Y"}{/if}" placeholder="dd/mm/yyyy" />
													{else}
													<label class="title full-width">{$core->get_Lang('Start date')} (mm/dd/yyyy)</label>
													<div class="clearfix"></div>
													<input class="dateTxt2 required form-control" name="date_begin_simple" type="text" value="{if $date_begin_simple ne ''}{$date_begin_simple}{else}{$now|date_format:"%m/%d/%Y"}{/if}" placeholder="mm/dd/yyyy" />
													{/if}
												</div>
											</div>
											<div class="col-md-3 col-sm-6 col-xs-6">
												<div class="form-group">
													{if $_LANG_ID eq 'vn'}
													<label class="title full-width">{$core->get_Lang('Finish date')} (dd/mm/yyyy)</label>
													<div class="clearfix"></div>
													<input class="dateTxt2 required form-control" name="date_end_simple" type="text" value="{if $date_end_simple ne ''}{$date_end_simple}{else}{$now_next|date_format:"%d/%m/%Y"}{/if}" placeholder="dd/mm/yyyy" />
													{else}
													<label class="title full-width">{$core->get_Lang('Finish date')} (mm/dd/yyyy)</label>
													<div class="clearfix"></div>
													<input class="dateTxt2 required form-control" name="date_end_simple" type="text" value="{if $date_end_simple ne ''}{$date_end_simple}{else}{$now_next|date_format:"%m/%d/%Y"}{/if}" placeholder="mm/dd/yyyy" />
													{/if}
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<label class="title full-width">{$core->get_Lang('No of guest')}</label>
													<div class="clearfix"></div>
													<div class="row">
														<div class="col-sm-4 mb767_10">
															<select class="form-control" name="adult_simple">
																{$clsISO->makeSelectNumber2(10,$adult_simple,"$adultTxt,$adultsTxt")}                       
															</select>
														</div>
														<div class="col-sm-4 col-xs-6">
															<select class="form-control" name="children_simple">
																{$clsISO->makeSelectNumber(10,$children_simple,"$childTxt,$childrenTxt")}
															</select>
														</div>
														<div class="col-sm-4 col-xs-6">
															<select class="form-control" name="baby_simple">
																{$clsISO->makeSelectNumber(10,$baby_simple,"$babyTxt,$babiesTxt")}
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="listDes">
										<div class="row">
											<div class="col-md-8">
												<div class="form-group listCountry">
													<h2 class="tit wrap mobi-title size20">{$core->get_Lang('Choose your destinations')}</h2>
													<div class="group_box">
														<div class="row">
															{section name=i loop=$lstCountryEx}
															<span class="checkbox col-lg-3 col-md-4 col-sm-6 col-xs-6"><label><input class="chkitem" {if $clsISO->checkInArray($lst_country_id,$lstCountryEx[i].country_id)}checked="checked"{/if} value="{$lstCountryEx[i].country_id}" type="checkbox" name="country_id[]"> {$clsCountryEx->getTitle($lstCountryEx[i].country_id,$lstCountryEx[i])}</label></span>
															{/section}
														</div>
													</div>
													<input type="hidden" id="lst_country_id" name="lst_country_id" value="{if $lst_country_id ne ''}{$lst_country_id}{else}{$lstCountryEx[0].country_id}{/if}" />
													<input type="hidden" id="lst_city_id" name="lst_city_id" value="{$lst_city_id}" />
												</div>
												<div class="customize_line">
													<div id="distination_box">
														
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group"> 
													<label class=" control-label title mobi-title">
														<strong>{$core->get_Lang('Other Destinations')}</strong>
														<em style="font-style:normal;">({$core->get_Lang('Separate by commas')})</em>
													</label> 
														<textarea class="textarea form-control" rows="5" style="height:85px" name="other_des" placeholder="Vietnam,ThaiLand,...">{$other_des}</textarea>
												</div>
												
											</div>
										</div>
									</div>
									<div class="InfoTourRequest">
									<h2 class="headbox size20 tit">{$core->get_Lang('Your idea about this tour')}</h2>
									<div class="contentbox">
									<div class="row">
										<div class="col-md-3 col-sm-6">
											<label class="control-label title2">
												{$core->get_Lang('I prefer to travel by')}:
											</label>
											<select class="form-control travelby" name="travelby">
												{$clsTailorProperty->getSelectByProperty('_TRANSPORT',$travelby,'Transport')}
											</select>
										</div>
										<div class="col-md-3 col-sm-6">
											<label class=" control-label title2">
												{$core->get_Lang('Prefered Guide Language')}:
											</label>
											<select class="form-control language" name="language">
												{$clsTailorProperty->getSelectByProperty('_LANGUAGE',$language,'Language')}
											</select>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
											<label class="control-label title2">
												{$core->get_Lang('Select Meals')}:
											</label>
											<div class="row">
												<div class="col-sm-4">
													<select class="form-control" name="breakfast">
														{$clsTailorProperty->getSelectByProperty('_BREAKFAST',$breakfast,'Breakfast')}
													</select>
												</div>
												<div class="col-sm-4">
													<select class="form-control" name="lunch">
														{$clsTailorProperty->getSelectByProperty('_LUNCH',$lunch,'Lunch')}
													</select>
												</div>
												<div class="col-sm-4">
													<select class="form-control" name="dinner">
														{$clsTailorProperty->getSelectByProperty('_DINNER',$dinner,'Dinner')}
													</select>
												</div>
											</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label title2">
											{$core->get_Lang('Hotel Requirements')}:
										</label>
										<div class="row">
											<div class="col-md-3">
												
												<select class="form-control hotelclass" name="hotelclass">
													{$clsTailorProperty->getSelectByProperty('_HOTEL_CLASS',$hotelclass,'Hotel Class')}
												</select>
											</div>
											<div class="col-md-3">
												<select class="form-control" name="hotelroom">
													{$clsISO->makeSelectNumber2(10,$hotelroom,"$roomTxt,$roomsTxt")}
												</select>
											</div>
											{assign var=lstRoomClass value=$clsTailorProperty->getListByProperty('_ROOM_CLASS')}
											{if $lstRoomClass}
											<div class="col-md-6">
												<div class="row">
												{section name=i loop=$lstRoomClass}
													<div class="col-sm-4">
														<span class="checkbox"><label><input type="checkbox" {if $clsISO->checkInArray($roomRequirement,$lstRoomClass[i].tailor_property_id)}checked="checked"{/if} value="{$lstRoomClass[i].tailor_property_id}" name="roomRequirement[]"> {$clsTailorProperty->getTitle($lstRoomClass[i].tailor_property_id,$lstRoomClass[i])}</label></span>
													</div>
													{/section}
												</div>
											</div>
											{/if}
										</div>
									</div>
										{assign var=site_tailor_idea value=site_tailor_idea_|cat:$_LANG_ID}
										{if $clsConfiguration->getValue($site_tailor_idea)}
										<div class="formatTextStandard">{$clsConfiguration->getValue($site_tailor_idea)|html_entity_decode}</div>
										{/if}
										<div class="customize_line mtmm">
											<div class="form-item">
												<div class="form-group">
													<label class="title Requirements">{$core->get_Lang('Your Requirements')} </label>
														<textarea class="form-control" rows="8"  name="request_1" style="height:200px" placeholder="{$core->get_Lang('Enter your request. For example, the hotel has an elevator')},...">{$request_1}</textarea>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>
								<!-- End Tab 1 -->

								<!-- End Tab 2 -->
							</div>
							<div class="clearfix"></div>
							<div class="LastBox">
								<div class="top_fill_bo">
								<h2 class="headbox size20 tit">{$core->get_Lang('Your contact information')}</h2>
							</div>
							<div class="row">
								<div class="col-md-6 form-item">
									<div class="form-group">
										<label class="control-label title">
											{$core->get_Lang('Full Name')} <span class="required" title="required" style="color: red">*</span>
										</label>
										<div class="inputBox">
											<div class="mrs slbTitle">
												<select class="form-control required" name="title">
													{$clsISO->makeSelectTitle($title)}
												</select>
											</div>
											<input class="required form-control f-line" placeholder="{$core->get_Lang('Enter text here')}" type="text" name="name" value="{$name}" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label title">
											{$core->get_Lang('Email Address')} <span class="required" title="required" style="color: red">*</span>
										</label>
										<div class="inputBox">
											<input class="required email form-control" id="email" name="email" placeholder="{$core->get_Lang('Enter text here')}" type="email" value="{$email}" />
											<p class="help-block"><em class="requied">*</em> {$core->get_Lang('If you dont receive our answer after 1 working day, please check your spam email. It may go to your spam mailbox')}. </p>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label title">{$core->get_Lang('Number phone')}</label>
										<div class="inputBox">
											<input class="form-control" id="phone" name="phone" placeholder="{$core->get_Lang('Enter text here')}..." type="text" value="{$phone}" />
										</div>
									</div>
								</div>
								<div class="col-md-6 form-item">
									<div class="form-group">
										<label class="control-label title">
											{$core->get_Lang('Nationality')} <span class="required" title="required" style="color: red">*</span>
										</label>
										<div class="inputBox">
											<select name="country__id" id="country_id" class="form-control required">
												<option value="">-- {$core->get_Lang('Select')} -- </option>
												{section name=i loop=$lstCountryRegion}
												<option {if $country_id eq $lstCountryRegion[i].country_id}selected="selected"{/if} value="{$lstCountryRegion[i].country_id}">{$lstCountryRegion[i].title}</option>
												{/section}
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label title">
											{$core->get_Lang('Contact')} <span class="required" title="required" style="color: red">*</span>
										</label>
										<div class="inputBox">
											<span class="radio mb10"><label><input {if $please ne '2'}checked="checked"{/if} name="please" type="radio" value="1">{$core->get_Lang('Send me more details via email')}</label></span>
											<span class="radio"><label><input {if $please eq '2'}checked="checked"{/if} name="please" type="radio" value="2">{$core->get_Lang('Call me if possible')}</label></span>
										</div>
									</div>
									<div class="form-group">
										{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
										<label class="control-label title" for="secure_code">
											<span class="required" title="required">*</span> {$core->get_Lang('securecode')}
										</label>
										<div class="inputBox">
											<div class="form-item secure_code">
												<input autocomplete="off" type="text" class=" form-control required" name="secure_code" value="" maxlength="5" />										</div>
											<div class="form-item img_capcha">
												<img class="captcha" src="{$PCMS_URL}/captcha.php?sid={$sid}" width="80" height="36" alt="Secure" />
											</div>
										</div>
										{else}
										<label class="control-label title">&nbsp;</label>
										<div class="inputBox">
											<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
										</div>
										{/if}
									</div>
									<div class="form-group mtl">
										<div class="btn_comfirm mt10">
											<input type="hidden" name="plantrip" value="plantrip" />
											<input type="hidden" name="type" id="tabtype" value="{if $type eq ''}1{else}{$type}{/if}" />
											<input type="hidden" name="tour_id" value="{$tour_id}" />
											<button type="button" onclick="submit_cusomize(); return false;" class="submitBtn btn_main">
												{$core->get_Lang('Confirm &amp; Submit')}
											</button>
										</div>
									</div>
								</div>
							</div>
							</div>
							
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var city_list = '{$city_list}';
</script>
{literal}
<style type="text/css">
    .form-horizontal .checkbox{min-height: 22px !important}
</style>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		function submit_cusomize() {
			$('#form_customize').submit();
		}
		function getCheckBoxValueByClass(classname) {
			var names = [];
			$('.' + classname + ':checked').each(function () {
				names.push(this.value);
			});
			return names;
		}
		function show_date_cusomize(id) {
			if (id == 1) {
				$('#date_flexible').hide();
				$('#date_fixed').show();
			} else {
				$('#date_fixed').hide();
				$('#date_flexible').show();
			}
		}
		function loadDestination() {
			var adata = {
				'list_country_id': $('#lst_country_id').val(),
				'list_city_id': $('#lst_city_id').val()
			};
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/index.php?mod=tailor&act=ajaxGetCityDestination&lang='+LANG_ID,
				data: adata,
				dataType: "html",
				success: function (html) {
					var htm = html.split("$$$$");
					$('#distination_box').html(htm[0]);
					$('#lst_city_id').val(htm[1]);
				}
			});
		}
		$().ready(function () {
			/* Init Func */
			loadDestination();
			if ($('#clienttabs li').length > 0) {
				$('#clienttabs li').each(function (index) {
					$(this).attr('id', 'customize_tabbox_' + (index + 1));
				});
				$('.customize_tabbox').each(function (index) {
					$(this).attr('id', 'customize_tabbox_' + (index + 1) + '_content');
				});
				$('#clienttabs li').live('click', function () {
					var $_this = $(this);
					var $cu = $_this.attr('id');
					var $s = $cu.split('_');
					$('.customize_tabbox:visible').hide();
					$('#' + $cu + '_content').show();
					$('#tabtype').val($s[2]);
					$('#clienttabs li a.current').removeClass('current');
					$_this.find('a').addClass('current');
					return false;
				});
			}
			$('#form_customize').validate();
			/* Replace Text */
			if ($('textarea[name=request_1]').length > 0) {
				var request_1 = $('textarea[name=request_1]').val();
				if (request_1 != '') {
					request_1 = request_1.replace(/<br\s?\/?>/g, "\n");
					$('textarea[name=request_1]').val(request_1);
				}
			}
			if ($('textarea[name=request_2]').length > 0) {
				var request_2 = $('textarea[name=request_2]').val();
				if (request_2 != '') {
					request_2 = request_2.replace(/<br\s?\/?>/g, "\n");
					$('textarea[name=request_2]').val(request_2);
				}
			}
			if ($('textarea[name=other_des]').length > 0) {
				var other_des = $('textarea[name=other_des]').val();
				if (other_des != '') {
					other_des = other_des.replace(/<br\s?\/?>/g, "\n");
					$('textarea[name=other_des]').val(other_des);
				}
			}
			/* End Replace Text */
			$('input[name=date_begin]').datepicker({
				
				dateFormat: dateFormat,
				minDate: new Date(),
				onSelect: function (dateStr) {
					var date = $(this).datepicker('getDate');
					if (date) {
						date.setDate(date.getDate() + 1);
					}
					$('input[name=date_end]').datepicker('option', {minDate: date}).datepicker('setDate', date);
				}
			});
			$('input[name=date_end]').datepicker({
				dateFormat: dateFormat,
				minDate: new Date()
			});
			$('input[name=date_begin_simple]').datepicker({
				
				dateFormat: dateFormat,
				minDate: new Date(),
				onSelect: function (dateStr) {
					var date = $(this).datepicker('getDate');
					if (date) {
						date.setDate(date.getDate() + 1);
					}
					$('input[name=date_end_simple]').datepicker('option', {minDate: date}).datepicker('setDate', date);
				}
			});
			$('input[name=date_end_simple]').datepicker({
				dateFormat: dateFormat,
				minDate: new Date()
			});
			$('input[class=chkitem]').live('change', function () {
				var $lst_country_id = getCheckBoxValueByClass('chkitem');
				$('#lst_country_id').val($lst_country_id.join());
				loadDestination();
				return false;
			});
			$('input[class=chkid_city]').live('change', function () {
				var $lst_city_id = getCheckBoxValueByClass('chkid_city');
				$('#lst_city_id').val($lst_city_id.join());
				return false;
			});
		});
	})
</script>
{/literal}
<script defer type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>