{* SAFE DEFAULTS FOR PHP 8 / SMARTY *}
{if !isset($mod)}{assign var=mod value=''}{/if}
{if !isset($tour_id)}{assign var=tour_id value=0}{/if}
{if !isset($country_id)}{assign var=country_id value=''}{/if}
{if !isset($other_des)}{assign var=other_des value=''}{/if}
{if !isset($date_begin_simple)}{assign var=date_begin_simple value=''}{/if}
{if !isset($now)}{assign var=now value=0}{/if}
{if !isset($duration)}{assign var=duration value=''}{/if}
{if !isset($number_travellers)}{assign var=number_travellers value=''}{/if}
{if !isset($max_adult)}{assign var=max_adult value=99}{/if}
{if !isset($number_adult)}{assign var=number_adult value=1}{/if}
{if !isset($price_adult)}{assign var=price_adult value=0}{/if}
{if !isset($departure_in)}{assign var=departure_in value=''}{/if}
{if !isset($departure_in_2)}{assign var=departure_in_2 value=''}{/if}
{if !isset($max_child)}{assign var=max_child value=99}{/if}
{if !isset($number_child)}{assign var=number_child value=0}{/if}
{if !isset($children)}{assign var=children value=''}{/if}
{if !isset($max_infant)}{assign var=max_infant value=99}{/if}
{if !isset($baby_simple)}{assign var=baby_simple value=0}{/if}
{if !isset($number_room)}{assign var=number_room value=0}{/if}
{if !isset($budget)}{assign var=budget value=''}{/if}
{if !isset($travelby)}{assign var=travelby value=''}{/if}
{if !isset($language)}{assign var=language value=''}{/if}
{if !isset($breakfast)}{assign var=breakfast value=''}{/if}
{if !isset($lunch)}{assign var=lunch value=''}{/if}
{if !isset($dinner)}{assign var=dinner value=''}{/if}
{if !isset($lstTourGuide)}{assign var=lstTourGuide value=''}{/if}
{if !isset($tour_guide_id)}{assign var=tour_guide_id value=''}{/if}
{if !isset($hotelclass)}{assign var=hotelclass value=''}{/if}
{if !isset($request_1)}{assign var=request_1 value=''}{/if}
{if !isset($title)}{assign var=title value=''}{/if}
{if !isset($errMsgTitle)}{assign var=errMsgTitle value=''}{/if}
{if !isset($name)}{assign var=name value=''}{/if}
{if !isset($errMsgFullname)}{assign var=errMsgFullname value=''}{/if}
{if !isset($country__id)}{assign var=country__id value=''}{/if}
{if !isset($errMsgCountry)}{assign var=errMsgCountry value=''}{/if}
{if !isset($email)}{assign var=email value=''}{/if}
{if !isset($errMsgEmail)}{assign var=errMsgEmail value=''}{/if}
{if !isset($phone)}{assign var=phone value=''}{/if}
{if !isset($errMsgPhone)}{assign var=errMsgPhone value=''}{/if}
{if !isset($please)}{assign var=please value=''}{/if}
{if !isset($errMsgContact)}{assign var=errMsgContact value=''}{/if}
{if !isset($errMsgCaptcha)}{assign var=errMsgCaptcha value=''}{/if}
{if !isset($type)}{assign var=type value=1}{/if}
{if !isset($lst_country_id)}{assign var=lst_country_id value=''}{/if}
{if !isset($lst_city_id)}{assign var=lst_city_id value=''}{/if}
{if !isset($city_list)}{assign var=city_list value=''}{/if}
{if !isset($list_start_date)}{assign var=list_start_date value=''}{/if}
{if !isset($check_tour_promotion)}{assign var=check_tour_promotion value=''}{/if}
{if !isset($check_tour_start_date)}{assign var=check_tour_start_date value=''}{/if}
{if !isset($adult_type_id)}{assign var=adult_type_id value=0}{/if}
{if !isset($child_type_id)}{assign var=child_type_id value=0}{/if}
{if !isset($lstVisitorType)}{assign var=lstVisitorType value=''}{/if}
{if !isset($lstCountryEx)}{assign var=lstCountryEx value=''}{/if}
{if !isset($lstCountryRegion)}{assign var=lstCountryRegion value=''}{/if}
{if !isset($deviceType)}{assign var=deviceType value='computer'}{/if}
{if !isset($curl)}{assign var=curl value=''}{/if}
{if !isset($PCMS_URL)}{assign var=PCMS_URL value=''}{/if}
{if !isset($LANG_ID)}{assign var=LANG_ID value=''}{/if}
{if !isset($dateFormat)}{assign var=dateFormat value='dd/mm/yy'}{/if}
{if !isset($list_hotel_class)}{assign var=list_hotel_class value=''}{/if}
{if !isset($intro_tailor)}{assign var=intro_tailor value=''}{/if}
{if !isset($site_tailor_intro)}{assign var=site_tailor_intro value=''}{/if}
{if !isset($site_tailor_idea)}{assign var=site_tailor_idea value=''}{/if}
{* END SAFE DEFAULTS *}
<div class="page_container">
	<div class="breadcrumb-main breadcrumb-{$mod}">
		<div class="container">
			<ol class="breadcrumb mt0 mb0" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Tailor made tour')}" itemprop="url">
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
    <div id="contentPage" class="pageTailor">
        <div class="container">
          	<form method="post" action="" name="form_customize" id="form_customize" class="frmCrxBook form-horizontal">
				<div class="row">
					<div class="box_form_cutomize mx-auto">
						<h1 class="title_page">{$core->get_Lang('Plan your special trips')}</h1>
                        {assign var=site_tailor_intro value=site_tailor_intro_|cat:$_LANG_ID}
                        {assign var=intro_tailor value=$clsConfiguration->getValue($site_tailor_intro)}
						<div class="intro_page">
                            {$clsConfiguration->getValue($site_tailor_intro)|html_entity_decode}
                        </div>

						<div class="box_form box_form_destination">
							<h2 class="title_box_form">{$core->get_Lang('Select destination')}</h2>
							<div class="swiper dest_grid destination_choice_slider">
								<div class="swiper-wrapper">
									{foreach from=$lstCountryEx key=index item=country}
										<label for="id_lst_{$country.country_id}" class="swiper-slide box_list_country w-100">
											<div class="box_header d-flex flex-wrap justify-content-between align-items-center">
												<h2 class="title_country {if $index == 0}check{/if}">
													{$clsCountryEx->getTitle($country.country_id, $country)}
												</h2>
												<input class="chkitem" id="id_lst_{$country.country_id}"
													{if (is_array($country_id) && in_array($country.country_id, $country_id)) || ($index == 0 && empty($country_id))}checked="checked"{/if}
													value="{$country.country_id}"
													type="checkbox"
													name="country_id[]"
													data-id="destination_{$country.country_id}">
											</div>
										</label>
									{/foreach}
								</div>
							</div>
							<div class="dest_cities_wrap">
								{foreach from=$lstCountryEx item=country}
									<div class="box_list_city" id="destination_{$country.country_id}"></div>
								{/foreach}
							</div>
							<div class="form-input form-group">
								<div class="box_label">
									<label for="" class="lbl_box_input">{$core->get_Lang('Other Destinations')} </label>
								</div>
								<div class="box_input box_text_area">
									<textarea class="textarea form-control" rows="5" style="height:85px" name="other_des" placeholder="Vietnam,ThaiLand,...">{$other_des}</textarea>
								</div>
							</div>
						</div>
						<div class="box_form box_form_travel">
							<h2 class="title_box_form">{$core->get_Lang('Tour Information')}</h2>
							<div class="box_form_body">
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Start Date')} </label>
									</div>
									<div class="box_input box_input_departure_date">
										{if $_LANG_ID eq 'vn'}
											<div class="clearfix"></div>
											<input class="dateTxt2 required form-control" name="date_begin_simple" type="text" value="{if $date_begin_simple ne ''}{$date_begin_simple}{else}{$now|date_format:"%d/%m/%Y"}{/if}" placeholder="dd/mm/yyyy" />
										{else}
											<div class="clearfix"></div>
											<input class="dateTxt2 required form-control" name="date_begin_simple" type="text" value="{if $date_begin_simple ne ''}{$date_begin_simple}{else}{$now|date_format:"%m/%d/%Y"}{/if}" placeholder="mm/dd/yyyy" />
										{/if}
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Tour Duration')}</label>
									</div>
									<div class="box_input">
										<input type="text" name="duration" id="duration" class="duration" value="{$duration}" autocomplete="off" placeholder="{$core->get_Lang('Example: 7 Days')}">
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Number')}:</label>
									</div>
									<div class="box_input box_input_number_traveller">
										<input type="text" name="number_travellers" class="number_travellers" id="pick_travellers" placeholder="{$core->get_Lang('Adults')}" value="{$number_travellers}" readonly>
										<i class="fa fa-angle-down" aria-hidden="true"></i>
										<div id="check_number_travellers" class="check_number_travellers">
											<ul class="check_number_travellers--ul list_style_none">
												{section name=i loop=$lstVisitorType}
													{if $lstVisitorType[i].tour_property_id eq $adult_type_id}
														<li class="inputTraveller" id="li_adult" data-tour_property_id="{$lstVisitorType[i].tour_property_id}">
															<div class="right__inputTraveller">
																<label>{$core->get_Lang('Adults')}</label>
																<span class="ui-spinner ui-corner-all ui-widget ui-widget-content">
																	<button class="ui-spinner-button ui-spinner-down unNum" type="button" _type="number_adults" traveler_type_id="{$lstVisitorType[i].tour_property_id}">-</button>
																	<input type="hidden" id="tour_visitor_adult_id" name="tour_visitor_adult_id" value="{$lstVisitorType[i].tour_property_id}"/>
																	<input min-number="1" max-number="{$max_adult}" type="number" class="ui-spinner-input number_adults input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="adult_simple" id="national_visitor{$lstVisitorType[i].tour_property_id}" value="{$number_adult}" readonly/>
																	<input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{$price_adult}" id="people_price{$lstVisitorType[i].tour_property_id}" departure_in="{$departure_in}" departure_in_2="{$departure_in_2}">
																	<button class="ui-spinner-button ui-spinner-up upNum" type="button" _type="number_adults" traveler_type_id="{$lstVisitorType[i].tour_property_id}">+</button>
																</span>
															</div>
														</li>
													{elseif $lstVisitorType[i].tour_property_id eq $child_type_id}
														<li class="inputTraveller">
															<div class="right__inputTraveller">
																<label>{$core->get_Lang('Children')}</label>
																<span class="ui-spinner ui-corner-all ui-widget ui-widget-content">
																	<button class="ui-spinner-button ui-spinner-down unNum" type="button" _type="number_child" traveler_type_id="{$lstVisitorType[i].tour_property_id} ">-</button>
																	<input type="hidden" id="tour_visitor_child_id" name="tour_visitor_child_id" value="{$lstVisitorType[i].tour_property_id}"/>
																	<input min-number="0" max-number="{$max_child}" type="number" class="ui-spinner-input number_child input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="children_simple" id="national_visitor{$lstVisitorType[i].tour_property_id}" value="{$number_child}" readonly/>
																	<button class="ui-spinner-button ui-spinner-up upNum" type="button" _type="number_child" traveler_type_id="{$lstVisitorType[i].tour_property_id} " >+</button>
																</span>
															</div>
															<div class="box_age_child" id="box_age_child">
																{if $children}
																	{section name=j loop=$children}
																		<div class="item_age_child">{$clsISO->getSelectAgeChildTailor($children[j])}</div>
																	{/section}
																{/if}
															</div>
															<div class="txt_children">{$core->get_Lang("To find a property that suits your whole group at the exact same price, we need to know the children's ages at check-out")}</div>
														</li>
													{else}
														<li class="inputTraveller">
															<div class="right__inputTraveller">
																<label>{$core->get_Lang('Infants')}</label>
																<span class="ui-spinner ui-corner-all ui-widget ui-widget-content">
																	<button class="ui-spinner-button ui-spinner-down unNum" type="button" _type="number_infants" traveler_type_id="{$lstVisitorType[i].tour_property_id} ">-</button>
																	<input type="hidden" id="tour_visitor_infant_id" name="tour_visitor_infant_id" value="{$lstVisitorType[i].tour_property_id}"/>
																	<input min-number="0" max-number="{$max_infant}" type="number" class="ui-spinner-input number_infants input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="baby_simple" id="national_visitor{$lstVisitorType[i].tour_property_id}" value="{if $baby_simple}{$baby_simple}{else}0{/if}" readonly/>
																	<button class="ui-spinner-button ui-spinner-up upNum" type="button" _type="number_infants" traveler_type_id="{$lstVisitorType[i].tour_property_id} " >+</button>
																</span>
															</div>
														</li>
													{/if}
												{/section}
												<li class="inputTraveller" id="li_room" data-tour_property_id="6">
													<div class="right__inputTraveller">
														<label>{$core->get_Lang('Room')}</label>
														<span class="ui-spinner ui-corner-all ui-widget ui-widget-content">
															<button class="ui-spinner-button ui-spinner-down unNum" _type="number_room" type="button">-</button>
															<input type="number" class="spinnerExample ui-spinner-input number_room" name="number_room" value="{if $number_room}{$number_room}{else}0{/if}" min="0" aria-valuemin="1" aria-valuenow="1" autocomplete="off" role="spinbutton" readonly>
															<button class="ui-spinner-button ui-spinner-up upNum" _type="number_room" type="button">+</button>
														</span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Budget per person')} </label>
									</div>
									<div class="box_input">
										<input type="text" name="budget" id="budget" class="budget" value="{$budget}" autocomplete="off" placeholder="{$core->get_Lang('Example: 2.000$')}">
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Transport')}:</label>
									</div>
									<div class="box_input">
										<select class="form-control travelby" name="travelby">
											{$clsTailorProperty->getSelectByProperty('_TRANSPORT',$travelby,'Transport')}
										</select>
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Prefered Guide Language')}:</label>
									</div>
									<div class="box_input">
										<select class="form-control language" name="language">
											{$clsTailorProperty->getSelectByProperty('_LANGUAGE',$language,'Language')}
										</select>
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-start">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Select Meals')}:</label>
									</div>
									<div class="box_meal">
										<div class="box_input">
											<select class="form-control" name="breakfast">
												{$clsTailorProperty->getSelectByProperty('_BREAKFAST',$breakfast,'Breakfast')}
											</select>
											<i class="fa fa-angle-down" aria-hidden="true"></i>
										</div>
										<div class="box_input">
											<select class="form-control" name="lunch">
												{$clsTailorProperty->getSelectByProperty('_LUNCH',$lunch,'Lunch')}
											</select>
											<i class="fa fa-angle-down" aria-hidden="true"></i>
										</div>
										<div class="box_input">
											<select class="form-control" name="dinner">
												{$clsTailorProperty->getSelectByProperty('_DINNER',$dinner,'Dinner')}
											</select>
											<i class="fa fa-angle-down" aria-hidden="true"></i>
										</div>
									</div>
								</div>
								{if $lstTourGuide}
									<div class="form-input form-group d-flex flex-wrap align-items-center">
										<div class="box_label text-right">
											<label for="" class="lbl_box_input">{$core->get_Lang('Tour Guide')}:</label>
										</div>
										<div class="box_input box_input_tour_guide">
											<select type="text" class="form-control" name="tour_guide_id">
												<option value="" disabled {if !$tour_guide_id }selected{/if} hidden>-- {$core->get_Lang('Please select')} --</option>
												{if $lstTourGuide}
													{section name=i loop=$lstTourGuide}
														<option value="{$lstTourGuide[i].tour_property_id}" {if $tour_guide_id eq $lstTourGuide[i].tour_property_id}selected{/if}>{$lstTourGuide[i].title}</option>
													{/section}
												{/if}
											</select>
											<i class="fa fa-angle-down" aria-hidden="true"></i>
										</div>
									</div>
								{/if}
								<div class="form-input form-group form_accommodations d-flex flex-wrap align-items-start">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input lbl_box_input_accommodations">{$core->get_Lang('Hotel Requirements')}:</label>
									</div>
									{assign var=list_hotel_class value=$clsTailorProperty->getListByProperty('_HOTEL_CLASS')}
									<div class="box_checkbox box_hotel box_input">
										{section name=i loop=$list_hotel_class}
											<div class="boxCheckbox">
												<input type="radio" class="check_box_itinerary" name="hotelclass" value="{$list_hotel_class[i].tailor_property_id}" {if $hotelclass eq $list_hotel_class[i].tailor_property_id}checked{/if}>
												<p class="checkmark">{$list_hotel_class[i].title}</p>
											</div>
										{/section}
									</div>
								</div>
							</div>
						</div>
						<div class="box_form box_form_special">
							<h2 class="title_box_form">{$core->get_Lang('Your Special Requirements')}</h2>
							<div class="box_form_body">
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_textarea">
										<textarea class="" cols="255" rows="5" placeholder="{$core->get_Lang('At any time, you should be looking at your bucket list, desired accommodations, special food requirements, accommodations, etc')}..." name="request_1">{$request_1}</textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="box_form body_information">
							<h2 class="title_box_form">{$core->get_Lang('Your Travel Information’s')}</h2>
							<div class="box_form_body">
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Title')}*:</label>
									</div>
									<div class="box_input">
										<select class="form-control required" name="title">
											<option value="">-- {$core->get_Lang('Please Select')} --</option>
											{$clsISO->makeSelectTitle($title)}
										</select>
										{if $errMsgTitle}<label for="title" generated="true" class="error">{$errMsgTitle}!</label>{/if}
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Full name')}*:</label>
									</div>
									<div class="box_input">
										<input type="text" class="form-control required" value="{$name}" name="name" placeholder="{$core->get_Lang('Enter your name')}"/>
										{if $errMsgFullname}<label for="name" generated="true" class="error">{$errMsgFullname}!</label>{/if}
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="country_id" class="lbl_box_input">{$core->get_Lang('Country')}*:</label>
									</div>
									<div class="box_input">
										
<select name="country__id" id="country_id" class="form-control required">
    <option value="">-- {$core->get_Lang('Select')} --</option>

    {section name=i loop=$lstCountryRegion}
        {assign var=countryName value=$lstCountryRegion[i].title|trim}
        <option
            value="{$lstCountryRegion[i].country_id}"
            data-country-name="{$countryName|escape:'html'}"
            {if $country__id eq $lstCountryRegion[i].country_id}selected="selected"{/if}>
            {$lstCountryRegion[i].title}
        </option>
    {/section}
</select>
										{if $errMsgCountry}<label for="country_id" generated="true" class="error">{$errMsgCountry}!</label>{/if}
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Email')}*:</label>
									</div>
									<div class="box_input">
										<input class="form-control" id="email" name="email" placeholder="{$core->get_Lang('Enter your confirm email')}" type="text" value="{$email}" />
										{if $errMsgEmail}<label for="email" generated="true" class="error">{$errMsgEmail}!</label>{/if}
									</div>
								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
										<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Phone')}*:</label>
									</div>
<div class="phone_input_group">

    <div class="phone_country_code">
        <input
            type="text"
            id="country_code"
            name="country_code"
            class="form-control country_code"
            value=""
            placeholder="+"
            readonly
            autocomplete="off">
    </div>

    <div class="phone_number_input">
        <input
            class="form-control"
            id="phone"
            name="phone"
            placeholder="{$core->get_Lang('Enter your phone number')}"
            type="text"
            value="{$phone}"
            autocomplete="tel">
    </div>
</div>

{if $errMsgPhone}
    <label for="phone" class="error">{$errMsgPhone}!</label>
{/if}

								</div>
								<div class="form-input form-group d-flex flex-wrap align-items-center">
									<div class="box_label text-right">
										<label for="" class="lbl_box_input">{$core->get_Lang('Contact')}*:</label>
									</div>
									<div class="box_input">
										<select name="please" id="please" class="form-control required">
											<option value="">{$core->get_Lang('Select')}</option>
											<option {if $please eq 1}selected="selected"{/if} value="1">{$core->get_Lang('Send me more details via email')}</option>
											<option {if $please eq 2}selected="selected"{/if} value="2">{$core->get_Lang('Call me if possible')}</option>
										</select>
										{if $errMsgContact}<label for="please" generated="true" class="error">{$errMsgContact}!</label>{/if}
									</div>
								</div>
							</div>
						</div>
						<div class="center">
							<div class="text_note text-center text-muted mb20">
                                {assign var=site_tailor_idea value=site_tailor_idea_|cat:$_LANG_ID}
                                {$clsConfiguration->getValue($site_tailor_idea)|html_entity_decode}
                            </div>
							<div class="form-group mb24_mb text-center relative">
								<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
								<div id="error_recaptcha" class="error">
									{if $errMsgCaptcha}
									<label for="" class="error">{$errMsgCaptcha}</label>
									{/if}
								</div>
							</div>
							<div class="d-flex justify-content-center">
								<input type="hidden" name="plantrip" value="plantrip" />
								<input type="hidden" name="type" id="tabtype" value="{if $type eq ''}1{else}{$type}{/if}" />
								<input type="hidden" name="tour_id" value="{$tour_id}" />
								<input type="hidden" id="lst_country_id" name="lst_country_id" value="{if $lst_country_id ne ''}{$lst_country_id}{else}{$lstCountryEx[0].country_id}{/if}" />
								<input type="hidden" id="lst_city_id" name="lst_city_id" value="{$lst_city_id}" />
								<button class="btn-book" name="submit" type="submit">{$core->get_Lang('Request a quote')}</button>
							</div>
						</div>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var city_list = '{$city_list}';
    var $Loading = '{$core->get_Lang("Loading")}';
    var selectmonth='{$core->get_Lang("select month")}';
    var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
    var $_LANG_ID = '{$_LANG_ID}';
    var Adults='{$core->get_Lang("Adults")}';
    var Children='{$core->get_Lang("Children")}';
    var Infants='{$core->get_Lang("Infants")}';
    var Room='{$core->get_Lang("Room")}';
    var Departure_date_invalid='{$core->get_Lang("Departure date is invalid")}';
	var Please_choose_departure_date='{$core->get_Lang("Please choose departure date")}';
	var Warning='{$core->get_Lang("Warning")}';
    var list_start_date=['{$list_start_date}'];
    var $check_tour_promotion='{$check_tour_promotion}';
	var $check_tour_start_date='{$check_tour_start_date}';
	var getSelectAgeChild = `{$clsISO->getSelectAgeChildTailor()}`;
	var error_gender = `{$core->get_Lang('Title is required')}`;
	var error_full_name = `{$core->get_Lang('Full name is required')}`;
	var error_email_required = `{$core->get_Lang('Email is required')}`;
	var error_email_valid = `{$core->get_Lang('Email is valid')}`;
	var error_secondary_email_required = `{$core->get_Lang('Secondary email is required')}`;
	var error_secondary_email_valid = `{$core->get_Lang('Secondary email is valid')}`;
	var error_phone = `{$core->get_Lang('Phone number is required')}`;
	var error_country = `{$core->get_Lang('Nationality is required')}`;
	var error_please = `{$core->get_Lang('Contact is required')}`;
</script>

{literal}
<style type="text/css">
    .pageTailor{
        --iso-primary:#18babd;
        --iso-page:#F6F8FA;
        --iso-text:#263746;
        --iso-muted:#6C7782;
        --iso-soft:#FAFCFE;
        background:var(--iso-page);
        color:var(--iso-text);
        padding:0 0 76px;
    }

    .breadcrumb-main{
        position:relative;
        min-height:235px;
        padding:16px 0 118px;
        margin:0;
        color:#fff;
        background:
            linear-gradient(90deg, rgba(24,80,96,.72) 0%, rgba(24,186,189,.36) 54%, rgba(24,186,189,.08) 100%),
            url('https://images.unsplash.com/photo-1528181304800-259b08848526?q=80&w=1600&auto=format&fit=crop') center/cover no-repeat;
    }
    .breadcrumb-main .breadcrumb{
        background:transparent;
        padding:0;
        margin:0;
        color:#fff;
    }
    .breadcrumb-main .breadcrumb li{
        display:inline-flex;
        align-items:center;
        gap:6px;
    }
    .breadcrumb-main .breadcrumb li:not(:last-child)::after{
        content:"/";
        margin-left:6px;
        opacity:.7;
    }
    .breadcrumb-main .breadcrumb a,
    .breadcrumb-main .breadcrumb span{
        color:#fff;
        opacity:.92;
    }

    #form_customize,
    #form_customize *{
        box-sizing:border-box;
    }
    #form_customize .row{
        margin-left:0;
        margin-right:0;
    }
    #form_customize .box_form_cutomize{
        position:relative;
        width:100%;
        margin:-78px auto 0;
        padding:36px 44px 44px;
        background:#fff;
        box-shadow:0 18px 42px rgba(36,54,70,.10);
        counter-reset:jt-step;
    }
    #form_customize .title_page{
        color:var(--iso-primary);
        line-height:1.18;
        font-weight:700;
        margin:0 0 12px;
        letter-spacing:0;
    }
    #form_customize .intro_page{
        margin:0 0 34px;
        color:#53616E;
        line-height:1.7;
    }
    #form_customize .intro_page p{
        margin:0 0 8px;
    }

    #form_customize .box_form{
        padding:30px 0;
        box-shadow:inset 0 1px 0 #E6EDF2;
    }
    #form_customize .box_form:first-of-type{
        box-shadow:none;
        padding-top:0;
    }
    #form_customize .title_box_form{
        display:flex;
        align-items:center;
        gap:8px;
        margin:0 0 22px;
        color:var(--iso-primary);
        line-height:1.3;
        font-weight:700;
        letter-spacing:0;
    }
    #form_customize .box_form .title_box_form::before{
        counter-increment:jt-step;
        content:counter(jt-step) ".";
        color:var(--iso-primary);
        font-weight:700;
    }

.phone_input_group {
    display: flex;
    align-items: stretch;
    gap: 8px;
    width: 100%;
}

.phone_country_code {
    flex: 0 0 85px;
    width: 85px;
}

.phone_number_input {
    flex: 1;
    min-width: 0;
}

.phone_country_code .country_code {
    width: 100%;
    text-align: center;
    font-weight: 700;
    background: #f8f8f8;
    cursor: default;
}

@media (max-width: 768px) {
    .phone_country_code {
        flex-basis: 75px;
        width: 75px;
    }

    .phone_input_group {
        gap: 6px;
    }
}

    #form_customize .box_form_destination{
        display:block;
    }
    #form_customize .dest_grid{
        width:100%;
        overflow:hidden;
    }
    #form_customize .dest_grid .swiper-wrapper{
        display:flex;
        align-items:stretch;
    }
    #form_customize .dest_grid:not(.swiper-initialized) .swiper-wrapper{
        gap:24px;
        overflow-x:auto;
        scroll-snap-type:x proximity;
        scrollbar-width:none;
        cursor:grab;
    }
    #form_customize .dest_grid:not(.swiper-initialized) .swiper-wrapper::-webkit-scrollbar{
        display:none;
    }
    #form_customize .dest_grid:not(.swiper-initialized) .swiper-slide{
        flex:0 0 calc((100% - 72px)/4);
        width:calc((100% - 72px)/4) !important;
        scroll-snap-align:start;
    }
    #form_customize .box_list_country{
        position:relative;
        display:block;
        width:auto !important;
        min-width:0;
        margin:0;
        padding:0;
        overflow:hidden;
        cursor:pointer;
        color:#fff;
        background:transparent;
        box-shadow:none;
        transition:box-shadow .22s ease, transform .22s ease;
    }
    #form_customize .box_list_country:hover{
        transform:translateY(-2px);
    }
    #form_customize .box_list_country:hover .box_header{
        box-shadow:0 10px 24px rgba(36,54,70,.16);
    }
    #form_customize .box_header{
        position:relative;
        display:block !important;
        min-height:195px;
        padding:0;
        overflow:hidden;
        box-shadow:0 5px 14px rgba(36,54,70,.10);
        background:
            linear-gradient(180deg, rgba(24,186,189,.06) 0%, rgba(22,60,72,.72) 100%),
            url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=900&auto=format&fit=crop') center/cover no-repeat;
    }
    #form_customize .box_list_country:nth-of-type(2) .box_header{
        background-image:linear-gradient(180deg, rgba(24,186,189,.06) 0%, rgba(22,60,72,.72) 100%),url('https://images.unsplash.com/photo-1528181304800-259b08848526?q=80&w=900&auto=format&fit=crop');
    }
    #form_customize .box_list_country:nth-of-type(3) .box_header{
        background-image:linear-gradient(180deg, rgba(24,186,189,.06) 0%, rgba(22,60,72,.72) 100%),url('https://images.unsplash.com/photo-1528127269322-539801943592?q=80&w=900&auto=format&fit=crop');
    }
    #form_customize .box_list_country:nth-of-type(4) .box_header{
        background-image:linear-gradient(180deg, rgba(24,186,189,.06) 0%, rgba(22,60,72,.72) 100%),url('https://images.unsplash.com/photo-1464817739973-0128fe77aaa1?q=80&w=900&auto=format&fit=crop');
    }
    #form_customize .box_list_country:nth-of-type(5) .box_header{
        background-image:linear-gradient(180deg, rgba(24,186,189,.06) 0%, rgba(22,60,72,.72) 100%),url('https://images.unsplash.com/photo-1526481280693-3bfa7568e0f3?q=80&w=900&auto=format&fit=crop');
    }
    #form_customize .box_list_country:nth-of-type(6) .box_header{
        background-image:linear-gradient(180deg, rgba(24,186,189,.06) 0%, rgba(22,60,72,.72) 100%),url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=900&auto=format&fit=crop');
    }
    #form_customize .title_country{
        position:absolute;
        left:16px;
        right:48px;
        bottom:14px;
        margin:0;
        color:#fff;
        line-height:1.25;
        font-weight:700;
        text-shadow:0 2px 10px rgba(0,0,0,.3);
    }
    #form_customize .title_country.check::after{
        content:"";
        display:inline-block;
        width:8px;
        height:8px;
        margin-left:8px;
        background:var(--iso-primary);
        box-shadow:0 0 0 3px rgba(47,128,194,.22);
        vertical-align:middle;
    }
    #form_customize input.chkitem{
        position:absolute;
        top:12px;
        left:5px;
        z-index:2;
        width:22px;
        height:22px;
        margin:0;
        background:#fff;
        box-shadow:0 2px 10px rgba(0,0,0,.22);
        cursor:pointer;
        accent-color:var(--iso-primary);
    }
    #form_customize input.chkitem:checked{
        background:var(--iso-primary);
    }
    #form_customize .dest_cities_wrap {
			margin-top: 15px;
			margin-bottom: 15px;
	}
    #form_customize .dest_cities_wrap .box_list_city{
        display:none;
        color:#3F4C57;
        background:#fff;
        padding:18px 24px 12px;
        box-shadow:inset 0 0 0 1px #E6EDF2;
        line-height:1.5;
    }
    #form_customize .dest_cities_wrap .box_list_city.active{
        display:block;
    }
    #form_customize .box_list_city label,
    #form_customize .box_list_city .checkbox{
        display:inline-flex;
        align-items:center;
        gap: 10px;
    		width: 180px;
        min-height:24px !important;
        margin:0 0 5px;
        color:#4E5D69;
        font-weight:400;
        vertical-align:top;
    }
    #form_customize .box_list_city input[type="checkbox"]{
        width:15px;
        height:15px;
        margin:0;
        accent-color:var(--iso-primary);
    }
    #form_customize .box_form_destination > .form-input{
        margin-top:18px;
    }

    #form_customize .box_form_travel .box_form_body,
    #form_customize .body_information .box_form_body{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:17px 24px;
    }
    #form_customize .form-input.form-group{
        width:100%;
        margin:0;
    }
    #form_customize .box_form_travel .form-input.form-group,
    #form_customize .body_information .form-input.form-group{
        display:block !important;
    }
    #form_customize .box_form_travel .form-input.align-items-start:not(.form_accommodations),
    #form_customize .form_accommodations{
        grid-column:1/-1;
    }
    #form_customize .box_label{
        width:100% !important;
        margin:0 0 7px;
        padding:0;
        text-align:left !important;
    }
    #form_customize .lbl_box_input{
        display:block;
        color:#344756;
        line-height:1.45;
        font-weight:600;
    }
    #form_customize .text_lbl{
        color:var(--iso-muted);
        font-weight:400;
    }
    #form_customize .box_input{
        position:relative;
        width:100% !important;
        max-width:none !important;
    }
    #form_customize input[type="text"],
    #form_customize input[type="number"],
    #form_customize select.form-control,
    #form_customize textarea,
    #form_customize .form-control{
        width:100%;
        min-height:44px;
        padding:10px 15px;
        color:#263746;
        background:#fff;
        box-shadow:inset 0 0 0 1px #DCE4EC !important;
        line-height:1.45;
        transition:box-shadow .2s ease, background-color .2s ease;
    }

    #form_customize input[type="text"]:focus,
    #form_customize input[type="number"]:focus,
    #form_customize select.form-control:focus,
    #form_customize textarea:focus,
    #form_customize .form-control:focus{
        outline:none;
        box-shadow:inset 0 0 0 1px var(--iso-primary), 0 0 0 3px rgba(24,186,189,.12) !important;
    }
    #form_customize .box_input .fa-angle-down{
        position:absolute;
        right:15px;
        top:50%;
        transform:translateY(-50%);
        color:var(--iso-primary);
        pointer-events:none;
    }
    #form_customize label.error,
    #form_customize .error{
        display:block;
        margin:6px 0 0;
        color:#D33B32;
        font-weight:500;
        text-align:left;
    }

    #form_customize .box_meal{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        width:100%;
    }
    #form_customize .check_number_travellers{
        position:absolute;
        left:0;
        right:0;
        top:calc(100% + 8px);
        z-index:30;
        display:none;
        padding:14px;
        background:#fff;
        box-shadow:0 18px 34px rgba(36,54,70,.14);
    }
    #form_customize .check_number_travellers--ul{
        padding:0;
        margin:0;
        list-style:none;
    }
    #form_customize .inputTraveller{
        padding:10px 0;
    }
    #form_customize .inputTraveller + .inputTraveller{
        box-shadow:inset 0 1px 0 #E6EDF2;
    }
    #form_customize .right__inputTraveller{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:14px;
    }
    #form_customize .right__inputTraveller label{
        margin:0;
        color:#344756;
        font-weight:600;
    }
    #form_customize .ui-spinner{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:0;
        border:0;
        background:transparent;
    }
    #form_customize .ui-spinner-button{
        width:31px;
        height:31px;
        padding:0;
        background:#fff;
        color:var(--iso-primary);
        line-height:1;
        cursor:pointer;
        transition:background-color .2s ease, color .2s ease;
    }
    #form_customize .ui-spinner-button:hover{
        background:var(--iso-primary);
        color:#fff;
    }
    #form_customize .ui-spinner-input{
        width:42px !important;
        min-height:31px !important;
        padding:0 !important;
        border:0 !important;
        text-align:center;
        font-weight:700;
        background:transparent !important;
        box-shadow:none !important;
    }
    #form_customize .txt_children{
        margin-top:8px;
        color:var(--iso-muted);
        line-height:1.45;
    }
    #form_customize .box_age_child{
        display:flex;
        flex-wrap:wrap;
        gap:8px;
        margin-top:10px;
    }
    #form_customize .box_age_child .item_age_child{
        flex:1 1 150px;
    }
		.dateTxt2,.number_travellers{
			padding-left: 50px !important;
		}
    #form_customize .box_checkbox.box_hotel{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
    }
    #form_customize .boxCheckbox{
        position:relative;
        margin:0;
    }
    #form_customize .boxCheckbox input[type="radio"]{
        position:absolute;
        inset:0;
        opacity:0;
        cursor:pointer;
    }
    #form_customize .boxCheckbox .checkmark{
        min-height:39px;
        margin:0;
        padding:10px 15px;
        color:#344756;
        background:#fff;
        line-height:1.25;
        cursor:pointer;
        box-shadow:inset 0 0 0 1px #DCE4EC;
        transition:background-color .2s ease, color .2s ease, box-shadow .2s ease;
    }
    #form_customize .boxCheckbox input[type="radio"]:checked + .checkmark,
    #form_customize .boxCheckbox:hover .checkmark{
        background:var(--iso-primary);
        color:#fff;
        box-shadow:inset 0 0 0 1px var(--iso-primary);
    }

    #form_customize .box_form_special .form-input,
    #form_customize .box_textarea{
        width:100%;
    }
    #form_customize .box_textarea textarea{
        display:block;
        width:100%;
        min-height:140px;
        resize:vertical;
    }
    #form_customize .center{
        padding-top:20px;
        box-shadow:inset 0 1px 0 #E6EDF2;
    }
    #form_customize .text_note{
        max-width:820px;
        margin:0 auto 20px;
        color:#6f7f74;
        line-height:1.65;
    }
    #form_customize .g-recaptcha{
        display:inline-block;
        margin-bottom:12px;
    }
    #form_customize .btn-book{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:168px;
        min-height:46px;
        padding:12px 30px;
        color:#fff;
        background:var(--iso-primary);
        box-shadow:0 10px 22px rgba(24,186,189,.20);
        line-height:1.2;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:0;
        cursor:pointer;
        transition:opacity .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    #form_customize .btn-book:hover{
        color:#fff;
        opacity:.94;
        transform:translateY(-1px);
        box-shadow:0 14px 28px rgba(24,186,189,.25);
    }
#form_customize .box_list_city {
    display: none;
}

#form_customize .box_list_city.active {
    display: flex;
    flex-wrap: wrap;
}
    .form-horizontal .checkbox{
        min-height:22px !important;
    }

    @media (max-width:1199px){
        #form_customize .dest_grid:not(.swiper-initialized) .swiper-slide{
            flex-basis:calc((100% - 48px)/3);
            width:calc((100% - 48px)/3) !important;
        }
    }
    @media (max-width:991px){
        .breadcrumb-main{
            min-height:205px;
            padding-bottom:94px;
        }
        #form_customize .box_form_cutomize{
            margin-top:-58px;
            padding:30px 26px 36px;
        }
        #form_customize .dest_grid:not(.swiper-initialized) .swiper-wrapper{
            gap:18px;
        }
        #form_customize .dest_grid:not(.swiper-initialized) .swiper-slide{
            flex-basis:calc((100% - 18px)/2);
            width:calc((100% - 18px)/2) !important;
        }

        #form_customize .box_form_travel .box_form_body,
        #form_customize .body_information .box_form_body{
            grid-template-columns:1fr;
        }
    }
    @media (max-width:575px){
        .breadcrumb-main{
            min-height:178px;
            padding:12px 0 76px;
        }
        #contentPage.pageTailor{
            padding-bottom:44px;
        }
        #form_customize .box_form_cutomize{
            margin-top:-42px;
            padding:24px 16px 30px;
        }
        #form_customize .intro_page{
            margin-bottom:24px;
        }
        #form_customize .box_form{
            padding:24px 0;
        }
        #form_customize .box_header{
            min-height:168px;
        }
        #form_customize .dest_grid:not(.swiper-initialized) .swiper-slide{
            flex-basis:86%;
            width:86% !important;
        }

        #form_customize .box_meal{
            grid-template-columns:1fr;
        }
        #form_customize .box_list_city label,
        #form_customize .box_list_city .checkbox{
            width:100%;
            margin-right:0;
        }
        #form_customize .btn-book{
            width:100%;
        }
    }
</style>
<script type="text/javascript">
	(function () {

    var countryPhoneCodes = {
        "afghanistan": "+93",
        "albania": "+355",
        "algeria": "+213",
        "american samoa": "+1-684",
        "andorra": "+376",
        "angola": "+244",
        "anguilla": "+1-264",
        "antarctica": "+672",
        "antigua and barbuda": "+1-268",
        "argentina": "+54",
        "armenia": "+374",
        "aruba": "+297",
        "australia": "+61",
        "austria": "+43",
        "azerbaijan": "+994",

        "bahamas": "+1-242",
        "bahrain": "+973",
        "bangladesh": "+880",
        "barbados": "+1-246",
        "belarus": "+375",
        "belgium": "+32",
        "belize": "+501",
        "benin": "+229",
        "bermuda": "+1-441",
        "bhutan": "+975",
        "bolivia": "+591",
        "bosnia and herzegovina": "+387",
        "botswana": "+267",
        "brazil": "+55",
        "british indian ocean territory": "+246",
        "brunei": "+673",
        "bulgaria": "+359",
        "burkina faso": "+226",
        "burundi": "+257",

        "cambodia": "+855",
        "cameroon": "+237",
        "canada": "+1",
        "cape verde": "+238",
        "cayman islands": "+1-345",
        "central african republic": "+236",
        "chad": "+235",
        "chile": "+56",
        "china": "+86",
        "christmas island": "+61",
        "cocos (keeling) islands": "+61",
        "colombia": "+57",
        "comoros": "+269",
        "congo": "+242",
        "cook islands": "+682",
        "costa rica": "+506",
        "cote d'ivoire": "+225",
        "croatia": "+385",
        "cuba": "+53",
        "cyprus": "+357",
        "czech republic": "+420",

        "denmark": "+45",
        "djibouti": "+253",
        "dominica": "+1-767",
        "dominican republic": "+1-809",

        "east timor": "+670",
        "ecuador": "+593",
        "egypt": "+20",
        "el salvador": "+503",
        "equatorial guinea": "+240",
        "eritrea": "+291",
        "estonia": "+372",
        "ethiopia": "+251",

        "falkland islands": "+500",
        "faroe islands": "+298",
        "fiji": "+679",
        "finland": "+358",
        "france": "+33",
        "france, metropolitan": "+33",
        "french guiana": "+594",
        "french polynesia": "+689",
        "french southern territories": "+262",

        "gabon": "+241",
        "gambia": "+220",
        "georgia": "+995",
        "germany": "+49",
        "ghana": "+233",
        "gibraltar": "+350",
        "greece": "+30",
        "greenland": "+299",
        "grenada": "+1-473",
        "guam": "+1-671",
        "guatemala": "+502",
        "guinea": "+224",
        "guinea-bissau": "+245",
        "guyana": "+592",

        "haiti": "+509",
        "honduras": "+504",
        "hong kong": "+852",
        "hungary": "+36",

        "iceland": "+354",
        "india": "+91",
        "indonesia": "+62",
        "iran": "+98",
        "iraq": "+964",
        "ireland": "+353",
        "israel": "+972",
        "italy": "+39",

        "jamaica": "+1-876",
        "japan": "+81",
        "jordan": "+962",

        "kazakhstan": "+7",
        "kenya": "+254",
        "kiribati": "+686",
        "north korea (people's republic of korea)": "+850",
        "south korea (republic of korea)": "+82",
        "kuwait": "+965",
        "kyrgyzstan": "+996",

        "laos": "+856",
        "latvia": "+371",
        "lebanon": "+961",
        "lesotho": "+266",
        "liberia": "+231",
        "libyan arab": "+218",
        "liechtenstein": "+423",
        "luxembourg": "+352",

        "macau": "+853",
        "macedonia": "+389",
        "madagascar": "+261",
        "malawi": "+265",
        "malaysia": "+60",
        "maldives": "+960",
        "mali": "+223",
        "malta": "+356",
        "marshall islands": "+692",
        "martinique": "+596",
        "mauritania": "+222",
        "mauritius": "+230",
        "mayotte": "+262",
        "mexico": "+52",
        "micronesia": "+691",
        "moldova": "+373",
        "monaco": "+377",
        "mongolia": "+976",
        "montserrat": "+1-664",
        "morocco": "+212",
        "mozambique": "+258",
        "myanmar": "+95",

        "namibia": "+264",
        "nauru": "+674",
        "nepal": "+977",
        "netherlands": "+31",
        "netherlands antilles": "+599",
        "new caledonia": "+687",
        "new zealand": "+64",
        "nicaragua": "+505",
        "niger": "+227",
        "nigeria": "+234",
        "niue": "+683",
        "norfolk island": "+672",
        "northern mariana islands": "+1-670",
        "norway": "+47",

        "oman": "+968",

        "pakistan": "+92",
        "palau": "+680",
        "panama": "+507",
        "papua new guinea": "+675",
        "paraguay": "+595",
        "peru": "+51",
        "philippines": "+63",
        "pitcairn": "+64",
        "poland": "+48",
        "portugal": "+351",
        "puerto rico": "+1-787",

        "qatar": "+974",

        "reunion": "+262",
        "romania": "+40",
        "russian federation": "+7",
        "russia": "+7",
        "rwanda": "+250",

        "saint lucia": "+1-758",
        "saint vincent and the grenadines": "+1-784",
        "samoa": "+685",
        "san marino": "+378",
        "sao tome and principe": "+239",
        "saudi arabia": "+966",
        "senegal": "+221",
        "seychelles": "+248",
        "sierra leone": "+232",
        "singapore": "+65",
        "slovakia": "+421",
        "slovenia": "+386",
        "solomon islands": "+677",
        "somalia": "+252",
        "south africa": "+27",
        "south georgia/south sandwich islands": "+500",
        "spain": "+34",
        "sri lanka": "+94",
        "st helena": "+290",
        "st pierre and miquelon": "+508",
        "sudan": "+249",
        "suriname": "+597",
        "svalbard and jan mayen islands": "+47",
        "swaziland": "+268",
        "sweden": "+46",
        "switzerland": "+41",
        "syrian arab republic": "+963",

        "taiwan": "+886",
        "tajikistan": "+992",
        "tanzania": "+255",
        "thailand": "+66",
        "togo": "+228",
        "tokelau": "+690",
        "tonga": "+676",
        "trinidad and tobago": "+1-868",
        "tunisia": "+216",
        "turkey": "+90",
        "turkmenistan": "+993",
        "turks and caicos islands": "+1-649",
        "tuvalu": "+688",

        "uganda": "+256",
        "ukraine": "+380",
        "united arab emirates": "+971",
        "united kingdom": "+44",
        "united states": "+1",
        "united states minor outlying islands": "+1",
        "uruguay": "+598",
        "uzbekistan": "+998",

        "vanuatu": "+678",
        "vatican city": "+39",
        "venezuela": "+58",
        "virgin islands": "+1-284",
        "virgin islands (u.s.)": "+1-340",
        "wallis and futuna islands": "+681",
        "western sahara": "+212",
        "yemen": "+967",
        "zambia": "+260",
        "zimbabwe": "+263",

        "vietnam": "+84",
        "viet nam": "+84"
    };


    function normalizeCountryName(name) {
        return String(name || "")
            .replace(/&amp;/g, "&")
            .replace(/&#39;/g, "'")
            .replace(/&#039;/g, "'")
            .replace(/\s+/g, " ")
            .trim()
            .toLowerCase();
    }


    function updateCountryCode() {

        var country = document.getElementById("country_id");
        var code = document.getElementById("country_code");

        if (!country || !code) {
            return;
        }

        var option = country.options[country.selectedIndex];

        if (!option || !option.value) {
            code.value = "";
            return;
        }

        var countryName = option.getAttribute("data-country-name");

        if (!countryName) {
            countryName = option.textContent || option.innerText || "";
        }

        countryName = normalizeCountryName(countryName);

        var phoneCode = countryPhoneCodes[countryName] || "";

        code.value = phoneCode;
    }


    function initCountryPhoneCode() {

        var country = document.getElementById("country_id");

        if (!country) {
            return;
        }

        country.addEventListener("change", function () {
            updateCountryCode();
        });

        updateCountryCode();
    }


    if (document.readyState === "loading") {

        document.addEventListener(
            "DOMContentLoaded",
            initCountryPhoneCode
        );

    } else {

        initCountryPhoneCode();

    }

})();
	document.addEventListener("DOMContentLoaded", function () {
		function getCheckBoxValueByClass(classname) {
			var names = [];
			$('.' + classname + ':checked').each(function () {
				names.push(this.value);
			});
			return names;
		}

$(document).off('change.isoDestination', 'input.chkitem')
    .on('change.isoDestination', 'input.chkitem', function () {
        var $checkbox = $(this);
        var boxId = $checkbox.data('id');

        $checkbox.closest('.box_header')
            .find('.title_country')
            .toggleClass('check', $checkbox.is(':checked'));

        if ($checkbox.is(':checked')) {
            loadDestination(this);
        } else {
            $('#' + boxId).removeClass('active').empty();
            syncSelectedCities();
        }
    });

$(document).off('change.isoCity', 'input.chkid_city')
    .on('change.isoCity', 'input.chkid_city', function () {
        syncSelectedCities();
    });

// Khởi tạo trạng thái ban đầu, kể cả khi form được tải lại sau khi submit.
$('input.chkitem').each(function () {
    var $checkbox = $(this);
    var boxId = $checkbox.data('id');

    if ($checkbox.is(':checked')) {
        $('#' + boxId).addClass('active');
        loadDestination(this);
    } else {
        $('#' + boxId).removeClass('active');
    }
});

syncSelectedCities();

function loadDestination(el) {
    var countryId = $(el).val();
    var boxCity = $(el).data('id');
    var $cityBox = $('#' + boxCity);

    if (!$cityBox.length) {
        return;
    }

    // Chỉ hiển thị City khi Country được chọn.
    if (!$(el).is(':checked')) {
        $cityBox.removeClass('active').empty();
        syncSelectedCities();
        return;
    }

    $cityBox.addClass('active');

    // Không tải AJAX lặp lại nếu danh sách City đã có.
    if ($.trim($cityBox.html()) !== '') {
        syncSelectedCities();
        return;
    }

    $.ajax({
        type: 'POST',
        url: path_ajax_script +
            '/index.php?mod=tailor&act=getCityDestination&lang=' + LANG_ID,
        data: {
            country_id: countryId,
            list_city_id: $('#lst_city_id').val()
        },
        dataType: 'html',
        success: function (html) {
            // Nếu người dùng đã bỏ chọn trong lúc AJAX đang chạy,
            // không hiển thị lại City.
            if (!$(el).is(':checked')) {
                $cityBox.removeClass('active').empty();
                syncSelectedCities();
                return;
            }

            $cityBox.html(html).addClass('active');
            syncSelectedCities();
        }
    });
}

function syncSelectedCities() {
    var countryIds = [];
    var cityIds = [];

    $('.dest_grid input.chkitem:checked').each(function () {
        countryIds.push(this.value);
    });

    // Chỉ thu thập City đang thuộc Country được chọn.
    $('.dest_grid input.chkitem:checked').each(function () {
        var boxId = $(this).data('id');

        $('#' + boxId + ' input.chkid_city:checked').each(function () {
            cityIds.push(this.value);
        });
    });

    $('#lst_country_id').val(countryIds.join(','));
    $('#lst_city_id').val(cityIds.join(','));
}

function getNumberPerson(){
	var $totalAdult = 0;
	$('.number_adults').each(function() {
		$totalAdult += parseInt($(this).val());
	});
	var $totalChild = 0;
	$('.number_child').each(function() {
		$totalChild += parseInt($(this).val());
	});
	var $totalInfants = 0;
	$('.number_infants').each(function() {
		$totalInfants += parseInt($(this).val());
	});
	var $totalRoom = 0;
	$('.number_room').each(function() {
		$totalRoom += parseInt($(this).val());
	});
	var value = $totalAdult + ' ' +Adults;
	if($totalChild > 0){
		value += ', ' +$totalChild+' '+Children;
	}
	if($totalInfants > 0){
		value += ', ' +$totalInfants+' '+Infants;
	}
	if($totalRoom > 0){
		value += ', ' +$totalRoom+' '+Room;
	}
	$('#pick_travellers').val(value);
}
		$(document).click(function (e){
			var container1 = $("#check_number_travellers");
			var container2 = $("#check_tour_guide");
			if (!container1.is(e.target) && container1.has(e.target).length === 0 && !$('#pick_travellers').is(e.target) ){
				container1.hide();
			}
			if (!container2.is(e.target) && container2.has(e.target).length === 0 && !$('.tour_guide').is(e.target) ){
				container2.hide();
			}
		});

		$().ready(function () {
			$("#form_customize").validate({
				rules:	{
					'name':{
						required: true
					},
					'email':{
						required: true,
						email: true
					},
					'phone':{
						required: true,
					},
					'country__id':{
						required: true,
					},
					'please':{
						required: true,
					}
				},
				messages:{
					'name':{
						required: error_full_name
					},
					'email':{
						required: error_email_required,
						email: error_email_valid
					},
					'phone':{
						required: error_phone,
					},
					'country__id':{
						required: error_country,
					},
					'please':{
						required: error_please,
					}
				},
				submitHandler: function (form) {
					var securityUrl =
							path_ajax_script +
							"/index.php?mod=home&act=ajGetSubs_totalSe&lang=" +
							LANG_ID;

					$.post(securityUrl, function (res) {
							var aSeSubs = parseInt(res.a_se_subs, 10) || 0;
							var bSeSubs = parseInt(res.b_se_subs, 10) || 0;
							var subsTotal = parseInt(res.subs_totalSe, 10) || 0;
							var subsUid = res.subs_uid || "";

							var questionText =
									typeof window.text_question !== "undefined"
											? window.text_question
											: "Vui lòng trả lời";

							var wrongAnswerText =
									typeof window.wrong_answer !== "undefined"
											? window.wrong_answer
											: "Câu trả lời không đúng";

							var tryAgainText =
									typeof window.try_again !== "undefined"
											? window.try_again
											: "Có lỗi xảy ra, vui lòng thử lại";

							Swal.fire({
									icon: "question",
									text: questionText + ": " + aSeSubs + " + " + bSeSubs,
									input: "text",
									inputAttributes: {
											inputmode: "numeric",
											autocomplete: "off"
									},
									showCancelButton: true,
									confirmButtonText: "OK",
									preConfirm: function (inputValue) {
											var answer = parseInt(inputValue, 10);

											if (isNaN(answer) || answer !== subsTotal) {
													Swal.showValidationMessage(wrongAnswerText);
													return false;
											}

											return answer;
									}
							}).then(function (result) {
									if (!result.isConfirmed) {
											return;
									}

									if (typeof window.isLoadingSwal === "function") {
											window.isLoadingSwal();
									} else {
											Swal.fire({
													title: "Đang xử lý...",
													allowOutsideClick: false,
													allowEscapeKey: false,
													didOpen: function () {
															Swal.showLoading();
													}
											});
									}

									var formData = $("#form_customize").serializeArray();

									formData.push({
											name: "is_ajax",
											value: 1
									});

									formData.push({
											name: "plantrip",
											value: "plantrip"
									});

									formData.push({
											name: "subs_totalSe",
											value: result.value
									});

									formData.push({
											name: "subs_uid",
											value: subsUid
									});

									var submitUrl =
											path_ajax_script +
											"/index.php?mod=" +
											mod +
											"&act=customize&lang=" +
											LANG_ID;

									$.ajax({
											type: "POST",
											url: submitUrl,
											data: formData,
											dataType: "json"
									})
									.done(function (res) {
											if (res && res.success) {
													window.location.href = res.success;
													return;
											}

											if (res && res.error) {
													Swal.fire({
															title: res.error,
															icon: "error"
													});
													return;
											}

											Swal.fire({
													title: tryAgainText,
													icon: "error"
											});
									})
									.fail(function (xhr) {
											console.error(
													"Customize AJAX error:",
													xhr.responseText
											);

											Swal.fire({
													title: tryAgainText,
													icon: "error"
											});
									});
							});
					}, "json")
					.fail(function (xhr) {
							console.error(
									"Security question AJAX error:",
									xhr.responseText
							);

							Swal.fire({
									title: "Không thể tải mã xác thực",
									icon: "error"
							});
					});

					return false;
			}
			});

			/* Init Func */
			$('input.chkitem').each(function(index,elm){
				if($(elm).is(":checked")){
					loadDestination($(elm));
				}
			});


			$('input[class=chkitem]').on('change', function () {
				if($(this).is(':checked')){
					$(this).closest('.box_header').find('.title_country').addClass('check');
					var $lst_country_id = getCheckBoxValueByClass('chkitem');
					$('#lst_country_id').val($lst_country_id.join());
					loadDestination($(this));
					var $lst_city_id = getCheckBoxValueByClass('chkid_city');
					$('#lst_city_id').val($lst_city_id.join());
				}else{
					$(this).closest('.box_header').find('.title_country').removeClass('check');
					var box_city = $(this).data('id');
					$("#"+box_city).html('');
					var $lst_city_id = getCheckBoxValueByClass('chkid_city');
					$('#lst_city_id').val($lst_city_id.join());
				}
				return false;
			});

			$(document).on('change','input[class=chkid_city]',function () {
				var $lst_city_id = getCheckBoxValueByClass('chkid_city');
				$('#lst_city_id').val($lst_city_id.join());
				return false;
			});

			$('input[name="number_travellers"]').click(function(){
				$("#check_number_travellers").toggle();
				$("#check_tour_guide").hide();
			});
			$('input[name="tour_guide"]').click(function(){
				$("#check_tour_guide").toggle();
				$("#check_number_travellers").hide();
			});

			$('input[name="tour_guide_id"]').click(function(){
				var title = $(this).data('title');
				$('input[name="tour_guide"]').val(title);
			});
			$('.number_adults').on('focusout',function(){
				var value = $(this).val();
				if(parseInt(value) < 1 || value == ''){
					$(this).val(1);
				}
				getNumberPerson();
			});
			$('.number_child').on('focusout',function(){
				var value = $(this).val();
				if(parseInt(value) < 0 || value == ''){
					value = 0;
					$(this).val(0);
				}
				$('#box_age_child').html('');
				for(var i=0; i<value; i++){
					$('#box_age_child').append(`<div class="item_age_child">`+getSelectAgeChild+`</div>`);
				}
				getNumberPerson();
			});

			$('.number_infants,.number_room').on('focusout',function(){
				var value = $(this).val();
				if(parseInt(value) < 0 || value == ''){
					$(this).val(0);
				}
				getNumberPerson();
			});

			$('.upNum').click(function() {
				var number_person = $(this).val();
				var departure_date = $("input[name=departure_date]").val();
				var traveler_type_id = $(this).attr('traveler_type_id');
				var val = parseInt($("#national_visitor"+traveler_type_id).val());
				var max_number = parseInt($("#national_visitor"+traveler_type_id).attr('max-number'));
				var _type=$(this).attr('_type');
				val = val + 1;
				$("#national_visitor"+traveler_type_id).val(val);
				$('#'+_type).val(val);
				if(_type == 'number_child'){
					$('#box_age_child').html('');
					for(var i=0; i<val; i++){
						$('#box_age_child').append(`<div class="item_age_child">`+getSelectAgeChild+`</div>`);
					}
				}
				if(_type == 'number_room'){
					var value = $('input[name="number_room"]').val();
					$('input[name="number_room"]').val(parseInt(value) + 1);
				}
				getNumberPerson();
				return false;
			});
			$('.unNum').click(function() {
				var number_person = $(this).val();
				var departure_date = $("input[name=departure_date]").val();
				var traveler_type_id = $(this).attr('traveler_type_id');
				var val = parseInt($("#national_visitor"+traveler_type_id).val());
				var min_number = parseInt($("#national_visitor"+traveler_type_id).attr('min-number'));
				var _type=$(this).attr('_type');
				val = val - 1;
				if (val < min_number) {
					$.alert({
						title: Warning,
						type: 'red',
						typeAnimated: true,
						content: Input_data_is_invalid,
					});
					val = min_number;
				}
				$("#national_visitor"+traveler_type_id).val(val);
				$('#'+_type).val(val);

				if(_type == 'number_child'){
					$('#box_age_child').html('');
					for(var i=0; i<val; i++){
						$('#box_age_child').append(`<div class="item_age_child">`+getSelectAgeChild+`</div>`);
					}
				}

				if(_type == 'number_room'){
					var value = $('input[name="number_room"]').val();
					if(parseInt(value) > 0){
						$('input[name="number_room"]').val(parseInt(value) - 1);
					}
				}
				getNumberPerson();
				return false;
			});
			var numberMonth = 2;
			if ($( document ).width() <= 767){
				numberMonth = 1;
			}
			$('#departure_date').datepicker({
				dateFormat: 'M dd, yy',
				minDate: "+1d",
				maxDate: "+1Y",
				numberOfMonths: numberMonth,
				firstDay:1,
			});


			/*===========*/
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
		});
	})
    
</script>
{/literal}
