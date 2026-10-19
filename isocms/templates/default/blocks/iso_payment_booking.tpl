<div class="iso_item_description">
    <div class="txt_paymentdetail">
        <i class="fa-sharp fa-regular fa-shield-check"></i>
        {$core->get_Lang("This is a secure and SSL encrypted payment. Your credit card details are safe")}
        .
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
                        <label class="custom-radio mb10">
                            <input type="radio"
                                   class="chkPayment"
                                   name="payment_method"
                                   {if $payment_method eq $PAYMENT_CASH_ID || !isset($payment_method)}checked="checked"{/if}
                                   value="{$PAYMENT_CASH_ID}"> {$clsConfiguration->getValue($SitePay_CashName)}
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
                        <label class="custom-radio mb10">
                            <input type="radio" class="chkPayment" name="payment_method"
                                   {if $payment_method eq $PAYMENT_TRANSFER_ID}checked="checked"{/if}
                                   value="{$PAYMENT_TRANSFER_ID}">
                            {$clsConfiguration->getValue($SitePay_BankName)}
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
                            <label class="custom-radio mb10">
                                <input type="radio"
                                       class="chkPayment ATMDefault"
                                       name="payment_method"
                                       {if $payment_method eq $PAYMENT_ONEPAY_ATM}checked="checked"{/if}
                                       value="{$PAYMENT_ONEPAY_ATM}">
                                {$core->get_Lang('OnePay')}
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
                            <label class="custom-radio mb10">
                                <input type="radio"
                                       class="chkPayment ATMDefault"
                                       name="payment_method"
                                       {if $payment_method eq $PAYMENT_ONEPAY_VISA}checked="checked"{/if}
                                       value="{$PAYMENT_ONEPAY_VISA}">
                                {$core->get_Lang('Debit/Credit Card')}
                            </label>
                            <div class="border_imgpayment">
                                <img src="{$URL_IMAGES}/icon/visa-master.png" alt="">
                            </div>
                        </div>
                        <div class="SitePay_Visa" style="display:none">
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
                                    <input name="cardholder_name" type="name"
                                           class="input_textcard">
                                </div>

                                <div class="input_namevisa">
                                    <h4 class="txt_visacard">
                                        {$core->get_Lang('Credit Card Number')}
                                    </h4>
                                    <input name="cardcredit_number" type="text"
                                           class="input_textcard">
                                </div>

                                <div class="input_date_code">
                                    <div class="input_date_visa">
                                        <h4 class="txt_visacard">
                                            {$core->get_Lang('Expiration Date')}
                                        </h4>
                                        <div class="date_select">
                                            <input name="month" id="month" class="input_month" placeholder="MM" type="number"></input>
                                            <h4 class="txt_visacard txt_colm">/</h4>
                                            <input name="year" id="year" class="input_year" placeholder="YY" type="number"></input>
                                        </div>
                                    </div>
                                    <div class="input_security_code">
                                        <div class="txt_andicon">
                                            <h4 class="txt_visacard">
                                                {$core->get_Lang('Security Code')}
                                            </h4>
                                            <i id="info-icon" class="fa-regular fa-circle-info" style="color: #a5a5a5;"></i>                                                                </div>
                                        <div class="tooltip_txt" id="tooltip">
                                            3 or 4 digit code usually found near the signature
                                            strip
                                        </div>
                                        <div class="security_code_wrapper">
                                            <input type="text" id="security-code"
                                                   class="input_securitycode" placeholder="CVC">
                                        </div>
                                    </div>
                                </div>

                                <div class="country_zipcode">
                                    <div class="txt_optioncountry">
                                        <h4 class="txt_visacard">
                                            {$core->get_Lang('Country')}
                                        </h4>
                                        <select name="country_id" id="country_id"
                                                class="form-booking_input select_country required">
                                            {section name=i loop=$lstCountry}
                                                <option value="{$lstCountry[i].country_id}">{$lstCountry[i].title}</option>
                                            {/section}
                                        </select>
                                    </div>
                                    <div class="txtinput_zipcode">
                                        <h4 class="txt_visacard">
                                            {$core->get_Lang('Zip Code')}
                                        </h4>
                                        <input type="text" id="security-code"
                                               class="input_securitycode" placeholder="{$core->get_Lang('Zip Code')}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}

                <!-- Paypal -->
                {if $clsConfiguration->getValue('Paypal_Status_Mode')}
                    <div class="box_payment_mode">
                        <div class="desc_txt_payment">
                            {assign var = Paypal_Name value = Paypal_Name_|cat:$_LANG_ID}
                            <label class="custom-radio mb10">
                                <input type="radio"
                                       class="chkPayment ATMDefault"
                                       name="payment_method"
                                       {if $payment_method eq $PAYMENT_PAYPAL_GATEWAY}checked="checked"{/if}
                                       value="{$PAYMENT_PAYPAL_GATEWAY}">
                                {$core->get_Lang('PayPal')}
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
                            <label class="custom-radio mb10">
                                <input type="radio"
                                       class="chkPayment ATMDefault"
                                       name="payment_method"
                                       {if $payment_method eq $PAYMENT_VNPAY_GATEWAY}checked="checked"{/if}
                                       value="{$PAYMENT_VNPAY_GATEWAY}">
                                {$core->get_Lang('VnPay')}
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
                            <label class="custom-radio mb10">
                                <input type="radio"
                                       class="chkPayment ATMDefault"
                                       name="payment_method"
                                       {if $payment_method eq $PAYMENT_VTCPAY_GATEWAY}checked="checked"{/if}
                                       value="{$PAYMENT_VTCPAY_GATEWAY}">
                                {$core->get_Lang('VTC Pay')}
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
        <label class="size16">
            <input type="checkbox" name="proviso" id="proviso" checked
                   value="1"> {$core->get_Lang('I agree')}
            <a class=""
               title="{$core->get_Lang('Terms &amp; Conditions')}"
               href="{$clsISO->getLink('term_condition')}">{$core->get_Lang('Terms &amp; Conditions')}
            </a> {$core->get_Lang('and')}
            <a class="" href="{$clsISO->getLink('payment_method')}"
               title="{$core->get_Lang('Policy')}">{$core->get_Lang('Policy')}
            </a> {$core->get_Lang('of')} {$PAGE_NAME}.
        </label>
    </div>
    <button id ="confirm_payment" class="btn_payment">{$core->get_Lang('Payment Confirmation')}</button>

</div>

{literal}
    <script>
        $(function () {
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
    </script>
    {/literal}