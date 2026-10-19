<div class="iso_cart_step_2">
    <div class="container">
        <div class="row justify-content-between">
            <form method="POST" id="iso_cart_2024" class="col-12 col-lg-8 iso_form_submit">
                <input type="hidden" name="csrf_token" id="iso_csrf_token" value="{$clsISO->generateCsrfToken()}">
                <input type="text" name="iso_cms_booking" style="display: none;">
                <input type="hidden" name="booking" value="booking">
                <div class="iso_item_cart">
                    {if !empty($err_msg)}
                    <div class="iso_txt_note">
                        {$err_msg}
                    </div>
                    {/if}
                    <div class="iso_item_top">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="iso_box_right">
                                <span class="number">1</span>
                                <span class="text">{$core->get_Lang('Contact details')}</span>
                            </div>
                            <div class="iso_box_left">
                                <div class="iso_box_left_txt d-flex align-items-center">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    <span>{$core->get_Lang("Edit")}</span>
                                </div>
                            </div>
                        </div>
                        <div class="iso_item_description">
                            {$core->get_Lang("We'll use this information to send you confirmation and updates about your booking")}
                        </div>
                    </div>
                    <div class="iso_item_body">
                        <div class="iso_item_body_item iso_input_box">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="iso_input_box_item">
                                        <label for="first_name">{$core->get_Lang('First name')} <span>*</span></label>
                                        <input id="first_name" name="first_name" type="text" class="form-booking_input" value="{if !empty($profile_id)}{$oneProfile.first_name}{else}{$first_name|default:''}{/if}"/>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="iso_input_box_item">
                                        <label for="last_name">{$core->get_Lang('Full Name')} <span>*</span></label>
                                        <input id="last_name" name="last_name" placeholder="" type="text" class="form-booking_input" value="{if !empty($oneProfile)}{$oneProfile.last_name}{else}{$last_name|default:''}{/if}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="iso_input_box_item">
                                        <label>{$core->get_Lang('Date of birth')} <span>*</span></label>
                                        <input name="birthday" class="iso_book_birthday" type="text" value="{if !empty($profile_birthday)}{$profile_birthday}{else}{$birthday|default:''}{/if}">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="iso_input_box_item">
                                        <label>{$core->get_Lang('Gender')} <span>*</span></label>
                                        <select name="gender" class="iso_select2">
                                            <option value="" {if empty($gender)}selected{/if}  disabled>---- {$core->get_Lang('Gender')}----
                                            </option>
                                            <option {if !empty($gender) && $gender=='Male'}selected{/if} value="Male">{$core->get_Lang('Male')}</option>
                                            <option {if !empty($gender) && $gender=='Female'}selected{/if} value="Female">{$core->get_Lang('Female')}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="iso_input_box_item">
                                        <label>{$core->get_Lang('Email')} <span>*</span></label>
                                        <input id="email" name="email" placeholder="" type="email" class="form-booking_input" value="{if $profile_id}{$oneProfile.email}{/if}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="iso_input_box_item">
                                        <label>{$core->get_Lang('Country')} <span>*</span></label>
                                        <select name="country_id" id="country_id"
                                                class="form-booking_input iso_select2">
                                            <option value="" disabled selected>---- {$core->get_Lang('Country')}----
                                            </option>
                                            {section name=i loop=$lstCountry}
                                                <option value="{$lstCountry[i].country_id}" {if $profile_id && $lstCountry[i].country_id == $oneProfile.country_id}selected{/if}>{$lstCountry[i].title}</option>
                                            {/section}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="iso_input_box_item">
                                        <label>{$core->get_Lang('Phone number')} <span>*</span></label>
                                        <input name="phone" type="tel" id="phone" class="phonenumber" value="{if $profile_id}{$oneProfile.phone}{/if}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="iso_button d-flex flex-column">
                                    <span class="iso_txt_note">{$core->get_Lang('Please do not skip information')} (*)</span>
                                    <button class="iso_cart_button" id="btn_contact_details">
                                        {$core->get_Lang('Next')}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="iso_item_body_item iso_show_information">
                            <div class="information_name"></div>
                            <div class="information_text">{$core->get_Lang('Email')}: <span class="txt_mail"></span>
                            </div>
                            <div class="information_text">{$core->get_Lang('Phone')}: <span class="txt_phone"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_item_cart">
                    <div class="iso_item_top">
                        <div class="d-flex align-items-center justify-content-start">
                            <div class="iso_box_right">
                                <span class="number">2</span>
                                <span class="text">{$core->get_Lang('Activity details')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="iso_lst_cart">
                        {$core->getBlock('iso_tour_booking')}
                        {$core->getBlock('iso_cruise_booking')}
                        {$core->getBlock('iso_hotel_booking')}
                        {$core->getBlock('iso_voucher_booking')}
                    </div>
                </div>
                <div class="iso_item_cart">
                    <div class="iso_item_top">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="iso_box_right">
                                <span class="number">3</span>
                                <span class="text">{$core->get_Lang('Payment details')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="iso_item_body payment_box_card">
                        <div class="iso_item_description">
                            <div class="txt_paymentdetail">
                                <i class="fa-sharp fa-regular fa-shield-check"></i>
                                {$core->get_Lang("This is a secure and SSL encrypted payment. Your credit card details are safe")}.
                            </div>
                        </div>
                        <div class="billingInfo bg_fff pd20_991 mb20">
                            {if $mod eq 'tour'}
                                <h3 class="size18"><span class="number">3</span>{$core->get_Lang('Billing Information')}
                                </h3>
                            {/if}
                            <div class="booking_tab">
                                <div class="payment-choice">
                                    <!-- Cash Payment -->
                                    {if $clsConfiguration->getValue('SitePay_CashStatus_Mode')}
                                        <div class="box_payment_mode">
                                            <div class="desc_txt_payment">
                                                {assign var = SitePay_CashName value = SitePay_CashName_|cat:$_LANG_ID}
                                                {assign var = SitePay_CashDesc value = SitePay_CashDesc_|cat:$_LANG_ID}
                                                <label class="payment_custom_radio mb10">
                                                    <input type="radio"
                                                           class="chkPayment"
                                                           name="payment_method"
                                                           {if (isset($payment_method) && $payment_method eq $PAYMENT_CASH_ID) || !isset($payment_method)}checked="checked"{/if}
                                                           value="{$PAYMENT_CASH_ID}"> {$clsConfiguration->getValue($SitePay_CashName)}
                                                    <span class="checkmark"></span>
                                                </label>
                                                <i class="fa-duotone fa-light fa-money-bills"
                                                   style="--fa-primary-color: #26456e; --fa-secondary-color: #26456e;"></i>

                                            </div>
                                            {if $clsConfiguration->getValue($SitePay_CashDesc)}
                                                <div class="SitePay_CashDesc" style="display:block;">
                                                    {$clsConfiguration->getValue($SitePay_CashDesc)|html_entity_decode}
                                                </div>
                                            {/if}
                                        </div>
                                    {/if}

                                    <!-- Payment Bank -->
                                    {if $clsConfiguration->getValue('SitePay_Bank_Mode')}
                                        <div class="box_payment_mode">
                                            <div class="desc_txt_payment">
                                                {assign var = SitePay_BankName value = SitePay_BankName_|cat:$_LANG_ID}
                                                {assign var = SitePay_BankDesc value = SitePay_BankDesc_|cat:$_LANG_ID}
                                                <label class="payment_custom_radio mb10">
                                                    <input type="radio" class="chkPayment" name="payment_method"
                                                           {if isset($payment_method) && $payment_method eq $PAYMENT_TRANSFER_ID}checked="checked"{/if}
                                                           value="{$PAYMENT_TRANSFER_ID}">
                                                    {$clsConfiguration->getValue($SitePay_BankName)}
                                                    <span class="checkmark"></span>
                                                </label>
                                                <i class="fa-regular fa-building-columns"></i>

                                            </div>
                                            <div class="SitePay_BankDesc"
                                                 style="display:none">
                                                {$clsConfiguration->getValue($SitePay_BankDesc)|html_entity_decode}
                                            </div>
                                        </div>
                                    {/if}

                                    {if $clsISO->getVar('PAYMENT_ONLINE_GLOBAL')}
                                        <!-- Onepay ATM -->
                                        {if $clsConfiguration->getValue('ONEPAY_Status_Mode')}
                                            <div class="box_payment_mode">
                                                <div class="desc_txt_payment">
                                                    {assign var = ONEPAY_Name value = ONEPAY_Name_|cat:$_LANG_ID}
                                                    <label class="payment_custom_radio mb10">
                                                        <input type="radio"
                                                               class="chkPayment ATMDefault"
                                                               name="payment_method"
                                                               {if isset($payment_method) && $payment_method eq $PAYMENT_ONEPAY_ATM}checked="checked"{/if}
                                                               value="{$PAYMENT_ONEPAY_ATM}">
                                                        {$core->get_Lang('OnePay')}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="border_imgpayment">
                                                        <img src="{$URL_IMAGES}/icon/one-pay.png" alt="">
                                                    </div>

                                                </div>
                                                <div class="SitePay_OnePay" style="display:none">
                                                    {if $clsConfiguration->getValue('ONEPAY_Surcharge') gt 0}
                                                        <span class="surharge-ins">Surcharge of {$clsConfiguration->getValue('ONEPAY_Surcharge')}% on ONEPAY ATM.</span>
                                                    {/if}
                                                </div>
                                            </div>
                                        {/if}

                                        <!-- Onepay Visa -->
                                        {if $clsConfiguration->getValue('ONEPAY_Visa_Status_Mode')}
                                            <div class="box_payment_mode">
                                                <div class="desc_txt_payment">
                                                    {assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
                                                    <label class="payment_custom_radio mb10">
                                                        <input type="radio"
                                                               class="chkPayment ATMDefault"
                                                               name="payment_method"
                                                               {if isset($payment_method) && $payment_method eq $PAYMENT_ONEPAY_VISA}checked="checked"{/if}
                                                               value="{$PAYMENT_ONEPAY_VISA}">
                                                        {$core->get_Lang('Debit/Credit Card')}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="border_imgpayment">
                                                        <img src="{$URL_IMAGES}/icon/visa-master.png" alt="">
                                                    </div>
                                                </div>
                                                {*<div class="SitePay_Visa" style="display:none">
                                                    <div class="ico_txt_checkbox">
                                                        <p class="txt_checkboxvisa">
                                                            <i class="fa-solid fa-check" style="color: #007850;"></i>
                                                            {$core->get_Lang('All your payment information is secure')}
                                                        </p>
                                                        <p class="txt_checkboxvisa">
                                                            <i class="fa-solid fa-check" style="color: #007850;"></i>
                                                            {$core->get_Lang('Get instant confirmation via Email and SMS')}.
                                                        </p>
                                                    </div>
                                                    <div class="txt_inputvisa">
                                                        <div class="input_namevisa">
                                                            <h4 class="txt_visacard">
                                                                {$core->get_Lang('Cardholder name')}
                                                            </h4>
                                                            <input name="visa_card_name" type="text"
                                                                   class="input_textcard iso_credit_card ">
                                                        </div>

                                                        <div class="input_namevisa">
                                                            <h4 class="txt_visacard">
                                                                {$core->get_Lang('Credit Card Number')}
                                                            </h4>
                                                            <input name="visa_card_number" type="text"
                                                                   class="input_textcard iso_credit_card ">
                                                        </div>

                                                        <div class="input_date_code">
                                                            <div class="input_date_visa">
                                                                <h4 class="txt_visacard">
                                                                    {$core->get_Lang('Expiration Date')}
                                                                </h4>
                                                                <div class="date_select">
                                                                    <input name="visa_card_month" id="month" class="visa_datemonth input_month iso_credit_card " placeholder="MM" type="number"></input>
                                                                    <h4 class="txt_visacard txt_colm">/</h4>
                                                                    <input name="visa_card_year" id="year" class="visa_dateyear input_year iso_credit_card " placeholder="YY" type="number"></input>
                                                                </div>
                                                            </div>
                                                            <div class="input_security_code">
                                                                <div class="txt_andicon">
                                                                    <h4 class="txt_visacard">
                                                                        {$core->get_Lang('Security Code')}
                                                                    </h4>
                                                                    <i id="info-icon" class="fa-regular fa-circle-info" style="color: #a5a5a5;"></i>                                                               
                                                                </div>
                                                                <div class="tooltip_txt" id="tooltip">
                                                                    3 or 4 digit code usually found near the signature
                                                                    strip
                                                                </div>
                                                                <div class="security_code_wrapper">
                                                                    <input type="text" id="security-code" name="visa_card_code_security "
                                                                           class="visa_card_code_security input_securitycode iso_credit_card " placeholder="CVC">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="country_zipcode">
                                                            <div class="txt_optioncountry">
                                                                <h4 class="txt_visacard">
                                                                    {$core->get_Lang('Country')}
                                                                </h4>
                                                                <select name="visa_card_country_id"
                                                                        class="form-booking_input select_country iso_credit_card ">
                                                                    {section name=i loop=$lstCountry}
                                                                        <option value="{$lstCountry[i].country_id}">{$lstCountry[i].title}</option>
                                                                    {/section}
                                                                </select>
                                                            </div>
                                                            <div class="txtinput_zipcode">
                                                                <h4 class="txt_visacard">
                                                                    {$core->get_Lang('Zip Code')}
                                                                </h4>
                                                                <input type="text" id="security-code" name="visa_card_zip_code"
                                                                       class="input_securitycode iso_credit_card " placeholder="{$core->get_Lang('Zip Code')}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>*}
                                            </div>
                                        {/if}

                                        <!-- Paypal -->
                                        {if $clsConfiguration->getValue('Paypal_Status_Mode')}
                                            <div class="box_payment_mode">
                                                <div class="desc_txt_payment">
                                                    {assign var = Paypal_Name value = Paypal_Name_|cat:$_LANG_ID}
                                                    <label class="payment_custom_radio mb10">
                                                        <input type="radio"
                                                               class="chkPayment ATMDefault"
                                                               name="payment_method"
                                                               {if isset($payment_method) && $payment_method eq $PAYMENT_PAYPAL_GATEWAY}checked="checked"{/if}
                                                               value="{$PAYMENT_PAYPAL_GATEWAY}">
                                                        {$core->get_Lang('PayPal')}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="border_imgpayment">
                                                        <img src="{$URL_IMAGES}/icon/paypal.png" alt="">
                                                    </div>

                                                </div>
                                                <div class="SitePay_PayPal" style="display:none">
                                                    <span class="surharge-ins">You will be redirected to PayPal to complete your purchase securely.</span>
                                                </div>
                                            </div>
                                        {/if}

                                        <!-- VnPay -->
                                        {if $clsConfiguration->getValue('VNPay_Status_Mode')}
                                            <div class="box_payment_mode">
                                                <div class="desc_txt_payment">
                                                    <label class="payment_custom_radio mb10">
                                                        <input type="radio"
                                                               class="chkPayment ATMDefault"
                                                               name="payment_method"
                                                               {if isset($payment_method) && $payment_method eq $PAYMENT_VNPAY_GATEWAY}checked="checked"{/if}
                                                               value="{$PAYMENT_VNPAY_GATEWAY}">
                                                        {$core->get_Lang('VnPay')}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="border_imgpayment">
                                                        <img src="{$URL_IMAGES}/icon/vnpay.png" alt="">
                                                    </div>

                                                </div>
                                                <div class="SitePay_VNPay" style="display:none">
                                                    {*                                                {if $clsConfiguration->getValue('ONEPAY_American_Express_Surcharge') gt 0}*}
                                                    <span class="surharge-ins">You will be redirected to VnPay to complete your purchase securely.</span>
                                                    {*                                                {/if}*}
                                                </div>
                                            </div>
                                        {/if}

                                        <!-- VTC Pay -->
                                        {if $clsConfiguration->getValue('VTCPay_Status_Mode')}
                                            <div class="box_payment_mode">
                                                <div class="desc_txt_payment">
                                                    <label class="payment_custom_radio mb10">
                                                        <input type="radio"
                                                               class="chkPayment ATMDefault"
                                                               name="payment_method"
                                                               {if isset($payment_method) && $payment_method eq $PAYMENT_VTCPAY_GATEWAY}checked="checked"{/if}
                                                               value="{$PAYMENT_VTCPAY_GATEWAY}">
                                                        {$core->get_Lang('VTC Pay')}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="border_imgpayment">
                                                        <img src="{$URL_IMAGES}/icon/vtcpay.png" alt="">
                                                    </div>

                                                </div>
                                                <div class="SitePay_VTCPay" style="display:none">
                                                    {*                                                {if $clsConfiguration->getValue('ONEPAY_American_Express_Surcharge') gt 0}*}
                                                    <span class="surharge-ins">You will be redirected to VTCPay to complete your purchase securely.</span>
                                                    {*                                                {/if}*}
                                                </div>
                                            </div>
                                        {/if}
                                    {/if}
                                </div>
                            </div>
                        </div>
                        <div class="term_andbutton">
                            <div class="txt_termcheckbox">
                                <label class="size16 checktermbox">
                                    <input type="checkbox" name="proviso" id="proviso" checked disabled value="1"> 
                                    {$core->get_Lang('I agree')}
                                    <span class="checkmark checkbox_mark"></span>
                                    <a class=""
                                       title="{$core->get_Lang('Terms &amp; Conditions')}"
                                       href="{$clsISO->getLink('term_condition')}">{$core->get_Lang('Terms &amp; Conditions')}
                                    </a> {$core->get_Lang('and')}
                                    <a class="" href="{$clsISO->getLink('payment_method')}"
                                       title="{$core->get_Lang('Policy')}">{$core->get_Lang('Policy')}
                                    </a>
                                </label>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                            </div>
                            <button id ="confirm_payment" class="btn_payment">{$core->get_Lang('Payment Confirmation')}</button>
                        </div>
                    </div>
                    
                </div>
                <input type="hidden" name="totalFinal" id="iso_totalFinal" value="{$totalGrand}">
            </form>
            <div class="col-12 col-lg-4">
                {$core->getBlock('cart_booking_right_2024')}
            </div>
        </div>
    </div>
</div>
<div class="iso_box_waiting">
    <div class="box_loading">
        <i class="fa-solid fa-spinner fa-spin-pulse"></i>
    </div>
</div>
<script>
    let txt_first_name = `{$core->get_Lang('First name')}`;
    let txt_last_name = `{$core->get_Lang('Last Name')}`;
    let txt_Traveler = `{$core->get_Lang('Traveler')}`;
    let txt_adult= `{$core->get_Lang('adult')}`;
    let txt_child= `{$core->get_Lang('child')}`;
    let txt_infant= `{$core->get_Lang('infant')}`;
    var btn_close = "{$core->get_Lang('Close')}";
	var btn_send = "{$core->get_Lang('Book now')}";
	var validate_input = "{$core->get_Lang('You must enter the result')}!";
	var placeholder_input = "{$core->get_Lang('Enter results here')}";
	var Wrong_result = "{$core->get_Lang('Wrong result')}";
</script>

{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(function () {
                $('.iso_select2').select2();
                $('.iso_book_birthday').datepicker({
                    dateFormat: 'dd/mm/yy',
                    maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 18)),
                    // changeMonth: true, // Cho phép chọn tháng
                    changeYear: true,  // Cho phép chọn năm
                    yearRange: "-100:-18" // Giới hạn khoảng năm, ví dụ: 100 năm trước đến 18 năm trước
                });
                $('input[name=payment_method]').change(function () {
                    var _val = $(this).val();
                    if (_val == 2) {
                        $('.SitePay_BankDesc').show();
                    } else {
                        $('.SitePay_BankDesc').hide();
                    }
                    if (_val == 1) {
                        $('.SitePay_CashDesc').show();
                    } else {
                        $('.SitePay_CashDesc').hide();
                    }
                    if (_val == 3) {
                        $('.SitePay_OnePay').show();
                    } else {
                        $('.SitePay_OnePay').hide();
                    }
                    if (_val == 4) {
                        $('.SitePay_Visa').show();
                    } else {
                        $('.SitePay_Visa').hide();
                    }
                    if (_val == 5) {
                        $('.SitePay_PayPal').show();
                    } else {
                        $('.SitePay_PayPal').hide();
                    }
                    if (_val == 8) {
                        $('.SitePay_VNPay').show();
                    } else {
                        $('.SitePay_VNPay').hide();
                    }
                    if (_val == 9) {
                        $('.SitePay_VTCPay').show();
                    } else {
                        $('.SitePay_VTCPay').hide();
                    }
                });
            });

            // Xóa CSS cart của lõi
            $('link[href*="cart.css"]').remove();


            $('.chkPayment').on('change', function () {
                // Xóa class 'active' khỏi tất cả các box
                $('.box_payment_mode').removeClass('active');

                // Thêm class 'active' vào box tương ứng
                if ($(this).is(':checked')) {
                    $(this).closest('.box_payment_mode').addClass('active');
                }
            });

            $(document).ready(function () {
                // Bắt sự kiện khi click vào icon
                $('#info-icon').on('click', function (e) {
                    e.stopPropagation(); // Ngăn sự kiện lan ra ngoài
                    $('#tooltip').toggle(); // Hiển/ẩn tooltip
                });

                // Ẩn tooltip khi nhấp ra ngoài
                $(document).on('click', function () {
                    $('#tooltip').hide();
                });
            });
        })
        
    </script>
{/literal}
