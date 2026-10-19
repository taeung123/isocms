<main class="main_contact page_container">
    <section class="section_box section__top text-center">
        <div class="container">
            <h1 class="title">{$core->get_Lang('Contact')}</h1>
            <div class="intro_contact size20 mt10">
                {$core->get_Lang('Nếu bạn có thắc mắc và cần hỗ trợ, hãy để lại thông tin, chúng hãy để lại thông tin')}
            </div>
        </div>
    </section>
    <section class="live-zoom">
    	<div class="container">
    	<iframe src="https://zoom.us/wc/83548133857/join?prefer=0&pwd=qu7Zqc"
            style="border: 0; width: 100%; height:600px;"
            allow="microphone; camera; fullscreen"
            sandbox="allow-forms allow-scripts allow-same-origin">
     </iframe>
	</div>

    </section>
    <section class="section_box bg_fff">
        <div class="container">
            <div class="supplier__contact">
                <div class="row">
                    <div class="col-sm-4 mb30_mb">
                        <div class="item d-flex">
                            <div class="item_img">
                                <img src="{$URL_IMAGES}/contact_address.jpg"  alt="{$core->get_Lang('Address')}">
                            </div>
                            <div class="item_content">
                                <h3 class="title size18 text_bold mb15">{$core->get_Lang('Address')}</h3>
                                <div class="color_666 size14_mb">
									{assign var=CompanyAddress1 value=CompanyAddress1_|cat:$_LANG_ID}
                                    {assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
                                    <a target="_blank" class="color_666" href="https://www.google.com/maps/search/{$clsConfiguration->getValue($CompanyAddress1)}" title="{$clsConfiguration->getValue($CompanyAddress)}">{$clsConfiguration->getValue($CompanyAddress)}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb30_mb">
                        <div class="item d-flex pdl_20">
                            <div class="item_img">
                                <img src="{$URL_IMAGES}/contact_phone.jpg"  alt="{$core->get_Lang('Hotline')}">
                            </div>
                            <div class="item_content">
                                <h3 class="title size18 text_bold mb15">{$core->get_Lang('Hotline')}</h3>
                                <div class="color_666">
                                    <a class="color_666" title="{$clsConfiguration->getValue('CompanyHotline')}" href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="item d-flex">
                            <div class="item_img">
                                <img src="{$URL_IMAGES}/contact_mail.jpg"  alt="{$core->get_Lang('Email')}">
                            </div>
                            <div class="item_content">
                                <h3 class="title size18 text_bold mb15">{$core->get_Lang('Email')}</h3>
                                <div class="color_666">
                                    <a class="color_666" title="{$clsConfiguration->getValue('CompanyEmail')}" href="mailto:{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact_main">
        <form action="" method="post" id="EnquiryForm" class="enquiry_form">
            {if $cartSessionService}
                {foreach from=$cartSessionService item=item name=item}
                    {assign var=tour_id value=$item.tour_id_z}
                    {assign var=title_tour value=$clsTour->getTitle($tour_id)}
                    {assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z)}
                    {assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
                    {assign var=number_adult value=$item.number_adults_z}
                    {assign var=number_child value=$item.number_child_z}
                    {assign var=number_infant value=$item.number_infants_z}
                    {assign var=tour__class value=$item.tour__class}
                <div class="infor_tour bg_fff relative">
                    <h3 class="title text_bold mb15 size24 size20_mb"><a href="{$clsTour->getLink($tour_id)}" title="{$title_tour}">{$title_tour}</a></h3>
                    <div class="row d-flex">
                        <div class="col-md-5 col-sm-5">
                            <p class="mb05"><strong>{$core->get_Lang('Khởi hành')}  </strong></p>
                            <p class="departure mb0">{$clsTour->getListDeparturePoint($tour_id)}</p>
							<p class="departure_date mb0">{$clsISO->converTimeToText5($departure_date)}</p>
                        </div>
                        <div class="col-md-1 col-sm-1 icon_arrow">

                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p class="mb05"> <strong>{$core->get_Lang('Kết thúc')} </strong> </p>
                            <p class="departure mb0">{$clsTour->getEndCityAround($tour_id,1)}</p>
							 <p class="departure_date mb0">{$clsISO->converTimeToText5($end_date)}</p>
                        </div>
                    </div>
                    <div class="more_infor">
                        <p><strong>{$core->get_Lang('Traveler')}</strong>: {$number_adult} {$core->get_Lang('Adult(s)')} {if $number_child},{$number_child} {$core->get_Lang('Child')}{/if} {if $number_infant},{$number_infant} {$core->get_Lang('Infant')}{/if}</p>
                       {if $tour__class} <p><strong>{$core->get_Lang('Travel Style')}</strong>: {$clsTourOption->getTitle($tour__class)}</p>{/if}
                    </div>
                    <input type="hidden" name="tour_id" value="{$tour_id}" />
                    <input type="hidden" name="departure_date" value="{$departure_date}" />
                    <input type="hidden" name="end_date" value="{$end_date}" />
                    <input type="hidden" name="number_adult" value="{$number_adult}" />
                    <input type="hidden" name="number_child" value="{$number_child}" />
                    <input type="hidden" name="number_infant" value="{$number_infant}" />
                    <input type="hidden" name="tour__class" value="{$tour__class}" />
                </div>
                {/foreach}
            {/if}
            <p class="note size16 mb0">{$core->get_Lang('Vui lòng không bỏ qua những thông tin *')}</p>
            <div class="fill_form bg_fff">
                <h3 class="text_bold mb15 size24 size20_mb">{$core->get_Lang('Vui lòng nhập thông tin liên hệ')}</h3>
               <div class="group_1 box_col">
                   <div class="form-group">
                       <label for="title">{$core->get_Lang('Title')}:<span style="color:red"> *</span>
                       </label>
                       <select id="title" name="first_name" class="required form-booking_input find_select">
                           {$clsISO->makeSelectTitle($title)}
                       </select>
                   </div>
                   <div class="form-group">
                       <label for="fullname">{$core->get_Lang('Full name')}:<span style="color:red"> *</span>
                       </label>
                       <input id="fullname" name="last_name" type="text" class="form-booking_input required" value="">
                       <div class="clearfix"></div>
                       <div id="error_fullname" class="error text-left"></div>
                   </div>
               </div>
               <div class="group_2 box_col">

                   <div class="form-group">
                       <label for="city_id">{$core->get_Lang('City')}:<span style="color:red"> *</span>
                       </label>
                       <select name="subdomain" id="city_id" class="form-booking_input find_select required">
                           {$clsCity->makeSelectboxOption('',4)}
                       </select>
                       <div class="clearfix"></div>
                       <div id="error_city_id" class="error text-left"></div>
                   </div>
                   <div class="form-group">
                       <label for="email">{$core->get_Lang('Email')}:<span style="color:red"> *</span>
                       </label>
                       <input id="email" name="email" type="text" placeholder="{$clsConfiguration->getValue('CompanyEmail')}" value="" class="form-booking_input required">
                       <div class="clearfix"></div>
                       <div id="error_email" class="error text-left"></div>
                   </div>
                   <div class="form-group">
                       <label for="phone">{$core->get_Lang('Telephone')}:<span id="TelephoneAsterisk" style="color:red"> *</span>
                       </label>
                       <input id="phone" name="phone" type="text" value="" class="form-booking_input required">
                       <div class="clearfix"></div>
                       <div id="error_phone" class="error"></div>
                   </div>
               </div>
				<div class="group_2 box_col">
                   <div class="form-group">
                       <label for="email">{$core->get_Lang('pass')}:<span style="color:red"> *</span>
                       </label>
                       <input id="password" name="password" type="text" placeholder="{$clsConfiguration->getValue('CompanyEmail')}" value="" class="form-booking_input required">
                       <div class="clearfix"></div>
                       <div id="error_email" class="error text-left"></div>
                   </div>
					<div class="form-group">
                       <label for="phone">{$core->get_Lang('cpass')}:<span id="TelephoneAsterisk" style="color:red"> *</span>
                       </label>
                       <input id="cpassword" name="cpassword" type="text" value="" class="form-booking_input required">
                       <div class="clearfix"></div>
                       <div id="error_phone" class="error"></div>
                   </div>

               </div>
				<div class="group_2 box_col">
				<div class="form-group">
                       <label for="phone">{$core->get_Lang('company')}:<span id="TelephoneAsterisk" style="color:red"> *</span>
                       </label>
                       <input id="company" name="company" type="text" value="" class="form-booking_input required">
                       <div class="clearfix"></div>
                       <div id="error_phone" class="error"></div>
                   </div>
                   <div class="form-group">
                       <label for="email">{$core->get_Lang('respos')}:<span style="color:red"> *</span>
                       </label>
                       <input id="respos" name="respos" type="text" placeholder="{$clsConfiguration->getValue('CompanyEmail')}" value="" class="form-booking_input required">
                       <div class="clearfix"></div>
                       <div id="error_email" class="error text-left"></div>
                   </div>

               </div>
                <div class="form-group">
                    <label  for="Comments">
                        {$core->get_Lang('Messager')}
                    </label>
                    <textarea class="text_box form-control" id="Comments" name="Comments" rows="2" placeholder="{$core->get_Lang('Nhập điều bạn mong muốn, yêu cầu...')}"></textarea>
                </div>
            </div>
            <div class="row box_col">
				<div class="col-sm-6 col-xs-12">
					<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
					{if $errMsg ne ''}
					<div id="error_recaptcha" class="error text_left">{$errMsg}</div>
					{else}
					<div id="error_recaptcha" class="error text_left"></div>
					{/if}
				</div>
                <div class="col-sm-6 col-xs-12">
                    <input type="hidden" name="plantrip" value="plantrip" />
					<input type="hidden" name="hidden_field" value="" />
                    <button type="submit" class="form-control send_contact btn_main" id="SubmitEnquiry">
                        {$core->get_Lang('Send')}
                    </button>
                </div>
            </div>
        </form>
    </section>
    <section class="faqs bg_fff">
        <div class="faqs_panel">
            <h2 class="size24 text_bold text-center mb20">{$core->get_Lang('FAQs')}</h2>
			<div class="accordion" id="accordionFAQs">
				{section name=k loop=$lstFaqs}
				<div class="card">
					<div class="card-header" id="faqs_{$smarty.section.k.iteration}">
						<h3 class="title">
							<a class="collapsed" data-toggle="collapse" data-target="#collapsefaqs_{$smarty.section.k.iteration}" aria-expanded="false" aria-controls="collapsefaqs_{$smarty.section.k.iteration}">
							{$clsFAQ->getTitle($lstFaqs[k].faq_id)}
							<i class="fa fa-angle-up pull-right"></i>
							</a>
						</h3>
					</div>
					<div id="collapsefaqs_{$smarty.section.k.iteration}" class="collapse" aria-labelledby="faqs_{$smarty.section.k.iteration}" data-parent="#accordionFAQs">
						<div class="card-body">
							<div class="detail tinymce_Content">
								{$clsFAQ->getContent($lstFaqs[k].faq_id)}
							</div>
						</div>
					</div>
				</div>
				{/section}
			</div>
			 <a href="{$clsISO->getLink('faqs')}" class="more_faqs mt20 d-block text-center color_5f93e7" target="_blank">{$core->get_Lang('View more')}</a>
        </div>
    </section>
</main>


<script>
    var msg_fullname_required = "{$core->get_Lang('Your first name should not be empty')}!";
    var msg_phone_required = "{$core->get_Lang('Your telephone should not be empty')}!";
    var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
    var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
    var msg_city_id_not_valid = "{$core->get_Lang('Please select city')}!";
    var msg_confirmemail_not_valid = "{$core->get_Lang('Email addresses do not match')}!";
    var showInfo = "{$core->get_Lang('Show more information')}";
    var hideInfo = "{$core->get_Lang('information hidden')}";
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
	var st = '{$core->get_lang("st")}';
	var nd = '{$core->get_lang("nd")}';
	var rd = '{$core->get_lang("rd")}';
	var th = '{$core->get_lang("th")}';
    var loading = '{$core->get_lang("loading")}';
    var DateofBirth = '{$core->get_lang("Birthday")}';
	var msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";
</script>
<script defer src="{$URL_JS}/datepicker/jquery.date-dropdowns.js?v={$upd_version}"></script>
<script defer src="{$URL_JS}/jquery.validate.js?ver={$upd_version}"></script>