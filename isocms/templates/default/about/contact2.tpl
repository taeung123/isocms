<main class="main_contact page_container page_contact2">
    <section class="section_box section__top text-center">
        <div class="container">
            <h1 class="title">{$core->get_Lang('Contact')}</h1>
            <p class="intro_contact mt10">
                {$core->get_Lang('If you have any questions and need support, leave your information and we will get back to you')}
            </p>
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
                                <h3 class="title">{$core->get_Lang('Address')}</h3>
                                <p>
                                    {assign var=CompanyAddress1 value=CompanyAddress1_|cat:$_LANG_ID}
                                    {assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
                                    <a target="_blank" href="https://maps.google.it/maps?q={$clsConfiguration->getValue($CompanyAddress1)}" title="{$clsConfiguration->getValue($CompanyAddress)}">{$clsConfiguration->getValue($CompanyAddress)}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb30_mb">
                        <div class="item d-flex pdl_20">
                            <div class="item_img">
                                <img src="{$URL_IMAGES}/contact_phone.jpg"  alt="{$core->get_Lang('Hotline')}">
                            </div>
                            <div class="item_content">
                                <h3 class="title">{$core->get_Lang('Hotline')}</h3>
                                <p>
                                    <a title="{$clsConfiguration->getValue('CompanyHotline')}" href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="item d-flex">
                            <div class="item_img">
                                <img src="{$URL_IMAGES}/contact_mail.jpg"  alt="{$core->get_Lang('Email')}">
                            </div>
                            <div class="item_content">
                                <h3 class="title">{$core->get_Lang('Email')}</h3>
                                <p>
                                    <a title="{$clsConfiguration->getValue('CompanyEmail')}" href="mailto:{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact_main">
        <div class="container">
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
						<input type="hidden"
                            name="services[Tour][{$tour_id}][target_id]"
                            value="{$tour_id}">
					</div>
					{/foreach}
				{/if}
                {if $cartSessionCruise}
                    {foreach from=$cartSessionCruise item=item_cruise key=key_service}
                        {assign var=cartSessionItemCruise value=$item_cruise}
                        {if $cartSessionItemCruise}
                            {foreach from=$cartSessionItemCruise item=item key=key}
                                {assign var=cruise_id value=$item.cruise_id}
                                {assign var=title_cruise value=$clsCruise->getTitle($cruise_id)}
                                {assign var=cruise_cabin_id value=$item.cruise_cabin_id}
                                {assign var=cruise_itinerary_id value=$item.cruise_itinerary_id}
                                {assign var=title_cruise_cabin value=$clsCruiseCabin->getTitle($cruise_cabin_id)}
                                {assign var=departure_date value=$clsISO->getStrToTime($item.departure_date)}
                                {assign var=number_adult value=$item.number_adult}
                                {assign var=number_child value=$item.number_child}
                                <div class="infor_tour bg_fff relative">
                                    <a href="javascript:void(0);" class="delete_service" data-type="Cruise" key="{$key}" title="{$core->get_Lang('Delete serivce')}"><i class="fa fa-times"></i></a>
                                    <h3 class="title text_bold mb15 size24 size20_mb"><a
                                                href="{$clsCruise->getLink($cruise_id)}" title="{$title_cruise}">{$title_cruise}</a>
                                    </h3>
                                   {if $title_cruise_cabin} 
								   <div class="row d-flex">
                                        <div class="col-md-5 col-sm-5">
                                            <p class="mb05"><strong>{$core->get_Lang('Cabin')}  </strong></p>
                                            <p class="departure_date mb0">{$title_cruise_cabin}</p>
                                        </div>
                                    </div>
                                    {/if}
                                    {if $departure_date}
                                    <div class="row d-flex">
                                        <div class="col-md-5 col-sm-5">
                                            <p class="mb05"><strong>{$core->get_Lang('Khởi hành')}  </strong></p>
                                            <p class="departure_date mb0">{$clsISO->converTimeToText5($departure_date)}</p>
                                        </div>
                                        <div class="col-md-1 col-sm-1 icon_arrow"></div>
                                        <div class="col-md-6 col-sm-6">
                                            <p class="mb05"><strong>{$core->get_Lang('Kết thúc')} </strong></p>
                                            <p class="departure_date mb0">{$clsISO->converTimeToText5($clsCruiseItinerary->getTextEndDate($departure_date,$cruise_itinerary_id))}</p>
                                        </div>
                                    </div>
                                    {/if}
                                    <div class="more_infor">                                       	
                                    	{if $number_adult || $number_child}
                                        <p>
                                            <strong>{$core->get_Lang('Traveler')}</strong>: {if $number_adult}{$number_adult} {$core->get_Lang('Adult(s)')} {/if}{if $number_child},{$number_child} {$core->get_Lang('Child')}{/if}
                                        </p>
									   	{/if}
									   	{if $cruise_itinerary_id}
                                            <p>
											<strong>{$core->get_Lang('Itinerary')}</strong>
										: {$clsCruiseItinerary->getTitleDay($cruise_itinerary_id)}</p>
										{/if}
                                    </div>
                                    <input type="hidden" name="cruise_id" value="{$cruise_id}"/>
                                    <input type="hidden" name="cruise_itinerary_id" value="{$cruise_itinerary_id}"/>
                                    <input type="hidden" name="cruise_cabin_id" value="{$cruise_cabin_id}"/>
                                    <input type="hidden" name="departure_date" value="{$departure_date}"/>
                                    <input type="hidden" name="end_date" value="{$end_date}"/>
                                    <input type="hidden" name="number_adult" value="{$number_adult}"/>
                                    <input type="hidden" name="number_child" value="{$number_child}"/>
                                    <input type="hidden"
                                        name="services[Cruise][{$cruise_id}][target_id]"
                                        value="{$cruise_id}">
                                </div>
                            {/foreach}
                        {/if}

                    {/foreach}
                {/if}
                {if $cartSessionHotel}
                    {foreach from=$cartSessionHotel item=item_hotel key=key_service}
                        {assign var=cartSessionItemHotel value=$item_hotel}
                        {if $cartSessionItemHotel}
                            {foreach from=$cartSessionItemHotel item=item key=key}
                                {assign var=hotel_id value=$item.hotel_id}
                                {assign var=title_hotel value=$clsHotel->getTitle($hotel_id)}
                                
                                {assign var=hotel_room_id value=$item.hotel_room_id}
                                {assign var=title_hotel_room value=$clsHotelRoom->getTitle($hotel_room_id)}
                                
                                {assign var=check_in value=$item.check_in_date}
                                {assign var=check_out value=$item.check_out_date}
                                	
                                {assign var=number_adult value=$item.number_adults}
                                {assign var=number_child value=$item.number_child}
                                <div class="infor_tour bg_fff relative">
                                    <a href="javascript:void(0);" class="delete_service" data-type="Hotel" key="{$key}" title="{$core->get_Lang('Delete serivce')}"><i class="fa fa-times"></i></a>
                                    <h3 class="title text_bold mb15 size24 size20_mb"><a
                                                href="{$clsHotel->getLink($hotel_id)}" title="{$title_hotel}">{$title_hotel}</a>
                                    </h3>
                                    {if $hotel_room_id}
										<div class="row d-flex">
											<div class="col-md-5 col-sm-5">
												<p class="mb05"><strong>{$core->get_Lang('Hotel Room')}  </strong></p>
												<p class="departure_date mb0">{$title_hotel_room}</p>
											</div>
										</div>
                                    {/if}
                                    {if $check_in || $check_out}
										<div class="row d-flex">
											{if $check_in}
												<div class="col-md-5 col-sm-5">
													<p class="mb05"><strong>{$core->get_Lang('Check In')}  </strong></p>
													<p class="departure_date mb0">{$clsISO->converTimeToText5($check_in)}</p>
												</div>
											{/if}
											{if $check_out}
												<div class="col-md-1 col-sm-1 icon_arrow"></div>
												<div class="col-md-6 col-sm-6">
													<p class="mb05"><strong>{$core->get_Lang('Check Out')} </strong></p>
													<p class="departure_date mb0">{$clsISO->converTimeToText5($check_out)}</p>
												</div>
											{/if}
										</div>
                                    {/if}
                                    <div class="more_infor">                                       	
                                    	{if $number_adult || $number_child}
                                        <p>
                                            <strong>{$core->get_Lang('Traveler')}</strong>: {if $number_adult}{$number_adult} {$core->get_Lang('Adult(s)')} {/if}{if $number_child}, {$number_child} {$core->get_Lang('Child')}{/if}
                                        </p>
									   	{/if}

                                    </div>
                                    <input type="hidden" name="hotel_id" value="{$hotel_id}"/>
                                    <input type="hidden" name="hotel_room_id" value="{$hotel_room_id}"/>
                                    <input type="hidden" name="check_in" value="{$check_in}"/>
                                    <input type="hidden" name="check_out" value="{$check_out}"/>
                                    <input type="hidden" name="number_adult" value="{$number_adult}"/>
                                    <input type="hidden" name="number_child" value="{$number_child}"/>
                                    <input type="hidden"
                                    name="services[Hotel][{$hotel_id}][target_id]"
                                    value="{$hotel_id}">
                                </div>
                            {/foreach}
                        {/if}

                    {/foreach}
                {/if}
                {if $cartSessionVoucher}
                    {foreach from=$cartSessionVoucher item=item name=item key=key}
                        {assign var=voucher_id value=$item.voucher_id}
                        {assign var=title_voucher value=$clsVoucher->getTitle($voucher_id)}
                        <div class="infor_tour bg_fff relative">
                           	<a href="javascript:void(0);" class="delete_service" data-type="Voucher" key="{$key}" title="{$core->get_Lang('Delete serivce')}"><i class="fa fa-times"></i></a>
                            <h3 class="title text_bold mb15 size24 size20_mb"><a href="{$clsVoucher->getLink($voucher_id)}" title="{$title_voucher}">{$title_voucher}</a></h3>
                            <input type="hidden" name="voucher_id" value="{$voucher_id}" />
                            <input type="hidden"
                                name="services[Voucher][{$voucher_id}][target_id]"
                                value="{$voucher_id}">
                        </div>
                    {/foreach}
                {/if}
                <p class="note size16 mb0">{$core->get_Lang('Please do not ignore the information')}*</p>
                <div class="fill_form bg_fff">
                    <h3 class="text_bold mb15 size24 size20_mb">{$core->get_Lang('Please enter contact information')}</h3>
                    <div class="group_1 box_col">
                        <div class="form-group">
                            <label for="title">{$core->get_Lang('Title')}:<span style="color:red"> *</span>
                            </label>
                            <select id="title" name="title" class="required form-booking_input find_select">
                                {$clsISO->makeSelectTitle($title)}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fullname">{$core->get_Lang('Full name')}:<span style="color:red"> *</span>
                            </label>
                            <input id="fullname" name="fullname" type="text" class="form-booking_input required" value="{$fullname}">
                            <div class="clearfix"></div>
                            <div id="error_fullname" class="error text-left"></div>
                        </div>
                    </div>
                    <div class="group_2 box_col">
                        <div class="form-group">
                            <label for="birthday_contact">{$core->get_Lang('Date of Birth')}:<span style="color:red"> *</span>
                            </label>
                            <input type="hidden" name="birthday_contact" id="birthday_contact" class="form-booking_input required" value="{$birthday}">
                            <div class="clearfix"></div>
                            <div id="error_birthday_contact" class="error text-left"></div>
                            {literal}
                                <script>
                                    $(function(){
                                        $("#birthday_contact").dateDropdowns({
                                            submitFieldName: 'birthday',
                                            minAge: 18,
                                            defaultDate: '{/literal}{if $birthday}{$birthday}{else}1980-01-01{/if}{literal}'
                                        });
                                    });
                                </script>
                            {/literal}
                        </div>
                        <div class="form-group">
                            <label for="country_id">{$core->get_Lang('Country')}:<span style="color:red"> *</span>
                            </label>
                            <select name="country_id" id="country_id" class="form-booking_input find_select required">
                                <option value="0">{$core->get_Lang('Selected')}</option>
								{section name=i loop=$lstCountryRegion}
								<option value="{$lstCountryRegion[i].country_id}" {if $country_id eq $lstCountryRegion[i].country_id}selected{/if}>{$lstCountryRegion[i].title}</option>
								{/section}
                            </select>
                            <div class="clearfix"></div>
                            <div id="error_country_id" class="error text-left"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">{$core->get_Lang('Email')}:<span style="color:red"> *</span>
                            </label>
                            <input id="email" name="email" type="text" placeholder="{$clsConfiguration->getValue('CompanyEmail')}" value="{$email}" class="form-booking_input required">
                            <div class="clearfix"></div>
                            <div id="error_email" class="error text-left"></div>
                        </div>
                        <div class="form-group">
                            <label for="phone">{$core->get_Lang('Telephone')}:<span id="TelephoneAsterisk" style="color:red"> *</span>
                            </label>
                            <input id="phone" name="phone" type="text" value="{$phone}" class="form-booking_input required">
                            <div class="clearfix"></div>
                            <div id="error_phone" class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  for="Comments">
                            {$core->get_Lang('Messager')}
                        </label>
                        <textarea class="text_box form-control" id="Comments" name="Comments" rows="2" placeholder="{$core->get_Lang('Enter what you want, ask for')}....">{$Comments}</textarea>
                    </div>
                </div>
                <div class="row box_col">
                    <div class="col-sm-6 col-xs-12">
                        <div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                        <div id="error_recaptcha" class="error text_left"></div>
                        {if !empty($errMsg)}
                            <div class="alert alert-danger mb20"
                                id="form_error_message">
                                {$errMsg}
                            </div>
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
        </div>
    </section>
    <section class="faqs bg_fff">
        <div class="container">
            <div class="faqs_panel">
                <h2 class="text-center mb20">{$core->get_Lang('FAQs')}</h2>
                <div class="accordion" id="accordionFAQs">
                    {section name=k loop=$lstFaqs}
					<div class="card">
						<div class="card-header" id="faqs_{$smarty.section.k.iteration}">
							<h3 class="title">
								<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapsefaqs_{$smarty.section.k.iteration}" aria-expanded="false" aria-controls="collapsefaqs_{$smarty.section.k.iteration}">
								{$clsFAQ->getTitle($lstFaqs[k].faq_id,$lstFaqs[k])}
								<i class="fa fa-angle-up pull-right"></i>
								</a>
							</h3>
						</div>
						<div id="collapsefaqs_{$smarty.section.k.iteration}" class="collapse" aria-labelledby="faqs_{$smarty.section.k.iteration}" data-bs-parent="#accordionFAQs">
							<div class="card-body">
								<div class="detail tinymce_Content">
									{$clsFAQ->getContent($lstFaqs[k].faq_id,$lstFaqs[k])}
								</div>
							</div>
						</div>
					</div>
                    {/section}
                </div>
                <a href="{$clsISO->getLink('faqs')}" class="more_faqs mt20 d-block text-center" target="_blank">{$core->get_Lang('View more')}</a>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">
window.isoEnquiryMessages = window.isoEnquiryMessages || {};

window.isoEnquiryMessages.fullnameRequired =
    "{$core->get_Lang('Your first name should not be empty')|escape:'javascript'}!";

window.isoEnquiryMessages.phoneRequired =
    "{$core->get_Lang('Your telephone should not be empty')|escape:'javascript'}!";

window.isoEnquiryMessages.emailRequired =
    "{$core->get_Lang('Your email should not be empty')|escape:'javascript'}!";

window.isoEnquiryMessages.emailInvalid =
    "{$core->get_Lang('Please enter a valid email address')|escape:'javascript'}!";

window.isoEnquiryMessages.countryRequired =
    "{$core->get_Lang('Please select country')|escape:'javascript'}!";

window.isoEnquiryMessages.recaptchaRequired =
    "{$core->get_Lang('You must check Recaptcha')|escape:'javascript'}";

window.isoEnquiryMessages.confirm =
    "{$core->get_Lang('Confirm')|escape:'javascript'}";

window.isoEnquiryMessages.cancel =
    "{$core->get_Lang('Cancel')|escape:'javascript'}";

window.isoEnquiryMessages.remove =
    "{$core->get_Lang('Are you sure you want to remove?')|escape:'javascript'}";
</script>

<script src="{$URL_JS}/datepicker/jquery.date-dropdowns.js?v={$upd_version}"></script>
<script src="{$URL_JS}/jquery.validate.js?ver={$upd_version}"></script>
<script src="{$URL_JS}/jquery-confirm.min.js?ver={$upd_version}"></script>

{literal}
<script type="text/javascript">
(function ($, window, document) {
    'use strict';

    function isValidEmail(email) {
        email = $.trim(email || '');

        return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email);
    }

    function showFieldError(selector, message) {
        $(selector)
            .stop(true, true)
            .html(message)
            .fadeIn()
            .delay(3000)
            .fadeOut();
    }

    function getRecaptchaResponse() {
        if (
            typeof window.grecaptcha === 'undefined'
            || typeof window.grecaptcha.getResponse !== 'function'
        ) {
            return '';
        }

        return window.grecaptcha.getResponse();
    }

    function submitEnquiry(event) {
        event.preventDefault();

        var messages = window.isoEnquiryMessages || {};
        var $button = $('#SubmitEnquiry');

        var fullname = $.trim($('#fullname').val());
        var countryId = parseInt($('#country_id').val(), 10) || 0;
        var email = $.trim($('#email').val());
        var phone = $.trim($('#phone').val());

        $('.error').stop(true, true).hide().html('');

        if (fullname === '') {
            showFieldError(
                '#error_fullname',
                messages.fullnameRequired || 'Full name is required'
            );

            $('#fullname').focus();
            return false;
        }

        if (countryId <= 0) {
            showFieldError(
                '#error_country_id',
                messages.countryRequired || 'Please select country'
            );

            $('#country_id').focus();
            return false;
        }

        if (email === '') {
            showFieldError(
                '#error_email',
                messages.emailRequired || 'Email is required'
            );

            $('#email').focus();
            return false;
        }

        if (!isValidEmail(email)) {
            showFieldError(
                '#error_email',
                messages.emailInvalid || 'Email is invalid'
            );

            $('#email').focus();
            return false;
        }

        if (phone === '') {
            showFieldError(
                '#error_phone',
                messages.phoneRequired || 'Telephone is required'
            );

            $('#phone').focus();
            return false;
        }

        $button.prop('disabled', true);
        var form = document.getElementById('EnquiryForm');

        if (!form) {
            $button.prop('disabled', false);
            return false;
        }

        form.submit();

return false;
    }

    $(function () {
        var $birthday = $('#birthday_contact');

        if (
            $birthday.length
            && typeof $.fn.dateDropdowns === 'function'
            && !$birthday.data('date-dropdowns-ready')
        ) {
            $birthday
                .data('date-dropdowns-ready', true)
                .dateDropdowns({
                    submitFieldName: 'birthday',
                    minAge: 18,
                    defaultDate:
                        $birthday.val() || '1980-01-01'
                });
        }

        var $form = $('#EnquiryForm');

        if (
            $form.length
            && typeof $.fn.validate === 'function'
        ) {
            $form.validate();
        }

        $(document)
            .off('click.isoEnquiry', '#SubmitEnquiry')
            .on(
                'click.isoEnquiry',
                '#SubmitEnquiry',
                submitEnquiry
            );

        $form
            .off('submit.isoEnquiry')
            .on('submit.isoEnquiry', submitEnquiry);

        $(document)
            .off('click.isoDeleteService', '.delete_service')
            .on(
                'click.isoDeleteService',
                '.delete_service',
                function (event) {
                    event.preventDefault();

                    var messages =
                        window.isoEnquiryMessages || {};

                    var type = $(this).data('type') || '';
                    var key = $(this).attr('key') || '';

                    if (!type) {
                        return false;
                    }

                    if (typeof $.confirm !== 'function') {
                        if (
                            !window.confirm(
                                messages.remove
                                || 'Are you sure you want to remove?'
                            )
                        ) {
                            return false;
                        }

                        deleteService(type, key);
                        return false;
                    }

                    $.confirm({
                        title:
                            messages.confirm || 'Confirm',

                        content:
                            messages.remove
                            || 'Are you sure you want to remove?',

                        minHeight: 100,
                        maxHeight: 200,

                        buttons: {
                            confirmAction: {
                                text:
                                    messages.confirm
                                    || 'Confirm',

                                action: function () {
                                    deleteService(type, key);
                                }
                            },

                            cancelAction: {
                                text:
                                    messages.cancel
                                    || 'Cancel'
                            }
                        }
                    });

                    return false;
                }
            );
    });

    function deleteService(type, key) {
        $.ajax({
            type: 'POST',

            url:
                path_ajax_script
                + '/index.php?mod='
                + encodeURIComponent(mod)
                + '&act=deleteService'
                + '&lang='
                + encodeURIComponent(LANG_ID),

            data: {
                type: type,
                key: key
            },

            dataType: 'json',
            cache: false,

            success: function (response) {
                if (
                    response
                    && response.msg === 'ok'
                ) {
                    window.location.reload();
                }
            },

            error: function (xhr) {
                console.error(
                    'deleteService error:',
                    xhr.status,
                    xhr.responseText
                );
            }
        });
    }

})(window.jQuery, window, document);
</script>
{/literal}