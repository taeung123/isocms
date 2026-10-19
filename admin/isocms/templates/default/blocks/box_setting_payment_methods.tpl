<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css">
<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

<div class="page_container">
    <div class="page-title d-flex">
        <div class="title">
            <h2>{$core->get_Lang('Payment Methods')}</h2>
            <p>{$core->get_Lang('System management payment config')}</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            {*  Box and Modal Of Cash Payment*}
            <div class="col-lg-4 col-md-6">
                <form action="#" id="form-atm" method="post" class="validate-form">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img class="slideToggle"
                                         src="{$clsISO->getVar('PAYMENT_METHOD_MUNUAL')}" width="48" height="48">
                                    <p class="txt_infopayment">{$core->get_Lang('Cash payment')}</p>
                                </div>
                                <div class="col-md-4">
                                    <!-- Công tắc on/off -->
                                    <div class="form-group toggle_switch">
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-payment-mode"
                                                   name="SitePay_CashStatus_Mode"
                                                   {if $clsConfiguration->getValue('SitePay_CashStatus_Mode') eq '1'}checked{/if}
                                                   value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <!-- Nút kích hoạt Modal -->
                                    <a href="#cashPaymentModal" class="btn btn_toggle_modal" data-bs-toggle="modal"
                                       data-bs-target="#cashPaymentModal">
                                        {$core->get_Lang('Setting')}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal" id="cashPaymentModal" tabindex="-1" aria-labelledby="cashPaymentModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal_header_atm">
                                <h4 class="modal-title"
                                    id="cashPaymentModalLabel">{$core->get_Lang('Configure Cash Payment')}</h4>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-method-setting">
                                <div class="setting_modal">
                                    <div class="panel panel-default" style="margin-bottom: 0;">
                                        <div class="panel-body paymentType">
                                            {assign var = SitePay_CashName value = SitePay_CashName_|cat:$_LANG_ID}
                                            {assign var = SitePay_CashDesc value = SitePay_CashDesc_|cat:$_LANG_ID}
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Name Method')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           name="iso-{$SitePay_CashName}" type="text"
                                                           value="{$clsConfiguration->getValue($SitePay_CashName)}"
                                                           placeholder="{$core->get_Lang('Name Method')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Description')}</label>
                                                <div class="controls">
                                                    <textarea id="textarea_{$SitePay_CashDesc}_{$now}"
                                                              class="textarea_intro_editor_simple"
                                                              name="iso-{$SitePay_CashDesc}" style="width:100%">
                                                        {$clsConfiguration->getValue($SitePay_CashDesc)}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button_footer">
                                <p class="txt_footer">
                                    {$core->get_Lang('I allow isoCMS to save this payment method and automatically charge this payment method whenever a subscription is used with this method.')}
                                </p>
                                <div class="btn_savecancelpay">
                                    <button type="button" class="btn btn-secondary btn_cancel"
                                            data-bs-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                                    <button type="submit" class="btn btn_save">
                                        {$core->get_Lang('Save')}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {*Box and Modal Of Bank Transfer*}

            <div class="col-lg-4 col-md-6">
                <form action="#" id="form-atm" method="post" class="validate-form">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img class="slideToggle"
                                         src="{$clsISO->getVar('GATEWAY_BANK_TRANFER')}" width="100" height="48">
                                    <p class="txt_infopayment">{$core->get_Lang('Payment Tranfer')}</p>
                                </div>
                                <div class="col-md-4">
                                    <!-- Công tắc on/off -->
                                    <div class="form-group toggle_switch">
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-payment-mode" name="SitePay_Bank_Mode"
                                                   {if $clsConfiguration->getValue('SitePay_Bank_Mode') eq '1'}checked{/if}
                                                   value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <!-- Nút kích hoạt Modal -->
                                    <a href="#bankPaymentModal" class="btn btn_toggle_modal" data-bs-toggle="modal"
                                       data-bs-target="#bankPaymentModal">
                                        {$core->get_Lang('Setting')}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal" id="bankPaymentModal" tabindex="-1" aria-labelledby="bankPaymentModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal_header_atm">
                                <h4 class="modal-title"
                                    id="bankPaymentModalLabel">{$core->get_Lang('Configure Bank Payment')}</h4>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="payment-method-setting">
                                <div class="setting_modal">
                                    <div class="panel panel-default" style="margin-bottom: 0;">
                                        <div class="panel-body paymentType">
                                            {assign var = SitePay_BankName value = SitePay_BankName_|cat:$_LANG_ID}
                                            {assign var = SitePay_BankDesc value = SitePay_BankDesc_|cat:$_LANG_ID}
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Name Method')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           name="iso-{$SitePay_BankName}" type="text"
                                                           value="{$clsConfiguration->getValue($SitePay_BankName)}"
                                                           placeholder="{$core->get_Lang('Name Method')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Description')}</label>
                                                <div class="controls">
                                        <textarea id="textarea_{$SitePay_BankDesc}_{$now}"
                                                  class="textarea_intro_editor_simple"
                                                  name="iso-{$SitePay_BankDesc}" style="width:100%">
                                            {$clsConfiguration->getValue($SitePay_BankDesc)}
                                        </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button_footer">
                                <p class="txt_footer">
                                    {$core->get_Lang('I allow isoCMS to save this payment method and automatically charge this payment method whenever a subscription is used with this method.')}
                                </p>
                                <div class="btn_savecancelpay">
                                    <button type="button" class="btn btn-secondary btn_cancel"
                                            data-bs-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                                    <button type="submit" class="btn btn_save">
                                        {$core->get_Lang('Save')}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {* Box Paypal*}
            <div class="col-lg-4 col-md-6">
                <form action="#" id="form-atm" method="post" class="validate-form">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img class="slideToggle"
                                         src="{$clsISO->getVar('IMG_PAYPAL_GATEWAY')}" width="100" height="48">
                                    <p class="txt_infopayment">{$core->get_Lang('Payment Paypal')}</p>
                                </div>
                                <div class="col-md-4">
                                    <!-- Công tắc on/off -->
                                    <div class="form-group toggle_switch">
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-payment-mode" name="Paypal_Status_Mode"
                                                   {if $clsConfiguration->getValue('Paypal_Status_Mode') eq '1'}checked{/if}
                                                   value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <!-- Nút kích hoạt Modal -->
                                    <a href="#PaymentpaypalModal" class="btn btn_toggle_modal" data-bs-toggle="modal"
                                       data-bs-target="#PaymentpaypalModal">
                                        {$core->get_Lang('Setting')}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal" id="PaymentpaypalModal" tabindex="-1" aria-labelledby="PaymentpaypalModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal_header_atm">
                                <h4 class="modal-title"
                                    id="PaymentpaypalModalLabel">{$core->get_Lang('Configure Paypal Payment')}</h4>
                                <p class="txt_modalintro">{$core->get_Lang('Get payment configuration account information')}
                                    <a href="https://www.paypal.com/us/cshelp/article/how-do-i-request-an-api-signature-ts1455"
                                       target="_blank">{$core->get_Lang('here')}
                                    </a>
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-method-setting">
                                <div class="setting_modal">
                                    <div class="panel panel-default" style="margin-bottom: 0;">
                                        <div class="panel-body paymentType">
                                            {assign var = Paypal_Name value = Paypal_Name_|cat:$_LANG_ID}
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Name Method')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           name="iso-{$Paypal_Name}" type="text"
                                                           value="{$clsConfiguration->getValue($Paypal_Name)}"
                                                           placeholder="{$core->get_Lang('Name Method')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('API Username')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           id="Paypal_APIUsername" name="iso-Paypal_APIUsername"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('Paypal_APIUsername')}"
                                                           placeholder="thtech_api1.vietiso.com"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('API Password')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           id="Paypal_APIPassword" name="iso-Paypal_APIPassword"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('Paypal_APIPassword')}"
                                                           placeholder="42JVX7RNPANV88EU@@"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('API Signature')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           id="Paypal_APISignature" name="iso-Paypal_APISignature"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('Paypal_APISignature')}"
                                                           placeholder="AFcWxV21C7fd0v3bYYYRCpSSRl31ACHo4DNRxD39TTdo1q2jCmq4qyVH"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Email received')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           id="Paypal_EmailReceived" name="iso-Paypal_EmailReceived"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('Paypal_EmailReceived')}"
                                                           placeholder="thtech@vietiso.com"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Surcharge')}</label>
                                                <div class="controls">
                                                    <input class="form-control" placeholder="1.5"
                                                           name="iso-Paypal_Surcharge" id="Paypal_Surcharge" type="text"
                                                           value="{$clsConfiguration->getValue('Paypal_Surcharge')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="Paypal_Test_Mode"
                                                               {if $clsConfiguration->getValue('Paypal_Test_Mode') eq '1'}checked{/if}value="1"/> {$core->get_Lang('Test Mode')}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button_footer">
                                <p class="txt_footer">
                                    {$core->get_Lang('I allow isoCMS to save this payment method and automatically charge this payment method whenever a subscription is used with this method.')}
                                </p>
                                <div class="btn_savecancelpay">
                                    <button type="button" class="btn btn-secondary btn_cancel"
                                            data-bs-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                                    <button type="submit" class="btn btn_save">
                                        {$core->get_Lang('Save')}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {* Box OnePay*}

            <div class="col-lg-4 col-md-6">
                <form action="#" id="form-atm" method="post" class="validate-form">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img class="slideToggle"
                                         src="{$clsISO->getVar('GATEWAY_ONEPAY_ATM')}" width="105" height="48">
                                    <p class="txt_infopayment">{$core->get_Lang('Payment OnePay ATM')}</p>
                                </div>
                                <div class="col-md-4">
                                    <!-- Công tắc on/off -->
                                    <div class="form-group toggle_switch">
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-payment-mode" name="ONEPAY_Status_Mode"
                                                   {if $clsConfiguration->getValue('ONEPAY_Status_Mode') eq '1'}checked{/if}
                                                   value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <!-- Nút kích hoạt Modal -->
                                    <a href="#PaymentonepayatmModal" class="btn btn_toggle_modal" data-bs-toggle="modal"
                                       data-bs-target="#PaymentonepayatmModal">
                                        {$core->get_Lang('Setting')} <i class="fa-solid fa-crown icon_gradient"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal" id="PaymentonepayatmModal" tabindex="-1" aria-labelledby="PaymentonepayatmModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal_header_atm">
                                <h4 class="modal-title"
                                    id="PaymentonepayatmModalLabel">{$core->get_Lang('Configure OnePay Payment')}</h4>
                                <p class="txt_modalintro">{$core->get_Lang('Get payment configuration account information')}
                                    <a href="http://onepay.com.vn/" target="_blank">{$core->get_Lang('here')}</a>
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-method-setting">
                                <div class="setting_modal">
                                    <div class="panel panel-default" style="margin-bottom: 0;">
                                        <div class="panel-body paymentType">
                                            {assign var = ONEPAY_Name value = ONEPAY_Name_|cat:$_LANG_ID}
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Name Method')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           name="iso-{$ONEPAY_Name}" type="text"
                                                           value="{$clsConfiguration->getValue($ONEPAY_Name)}"
                                                           placeholder="{$core->get_Lang('Name Method')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('URL Payment')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required" data-val="true"
                                                           data-val-length="Tên hiển thị tối đa 250 ký tự"
                                                           data-val-length-max="250"
                                                           data-val-required="Tên hiển thị không được để trống"
                                                           id="Name" name="iso-ONEPAY_URL_PAYMENT" type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_URL_PAYMENT')}"
                                                           plcaeholder="Thanh toán online qua thẻ nội địa (ATM)">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Merchant ID')}</label>
                                                <div class="controls">
                                                    <input class="form-control required" data-val="true"
                                                           placeholder="MerchantId không vượt quá 500 ký tự"
                                                           id="Setting_MerchantId" name="iso-ONEPAY_Merchant_ID"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Merchant_ID')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Hashcode')}</label>
                                                <div class="controls">
                                                    <input class="form-control required" data-val="true"
                                                           data-val-length-max="500"
                                                           placeholder="Hashcode không được để trống"
                                                           id="Setting_Hashcode" name="iso-ONEPAY_Secure_Hash"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Secure_Hash')}">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('AccessCode')}</label>
                                                <div class="controls">
                                                    <input class="form-control requrired"
                                                           placeholder="AccessCode không được để trống"
                                                           id="Setting_AccessCode" name="iso-ONEPAY_Access_Code"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Access_Code')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Surcharge')}</label>
                                                <div class="controls">
                                                    <input class="form-control" placeholder="1.5"
                                                           name="iso-ONEPAY_Surcharge" id="ONEPAY_Surcharge" type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Surcharge')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="checkbox-inline"><input type="checkbox"
                                                                                          name="ONEPAY_Test_Mode"
                                                                                          {if $clsConfiguration->getValue('ONEPAY_Test_Mode') eq '1'}checked{/if}
                                                                                          value="1"/> {$core->get_Lang('Test Mode')}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button_footer">
                                <p class="txt_footer">
                                    {$core->get_Lang('I allow isoCMS to save this payment method and automatically charge this payment method whenever a subscription is used with this method.')}
                                </p>
                                <div class="btn_savecancelpay">
                                    <button type="button" class="btn btn-secondary btn_cancel"
                                            data-bs-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                                    <button type="submit" class="btn btn_save">
                                        {$core->get_Lang('Save')}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {*Box OnePay Visa*}
            <div class="col-lg-4 col-md-6">
                <form action="#" id="form-atm" method="post" class="validate-form">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img class="slideToggle"
                                         src="{$clsISO->getVar('GATEWAY_ONEPAY_VISA')}" width="105" height="48">
                                    <p class="txt_infopayment">{$core->get_Lang('Payment OnePay Visa')}</p>
                                </div>
                                <div class="col-md-4">
                                    <!-- Công tắc on/off -->
                                    <div class="form-group toggle_switch">
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-payment-mode"
                                                   name="ONEPAY_Visa_Status_Mode"
                                                   {if $clsConfiguration->getValue('ONEPAY_Visa_Status_Mode') eq '1'}checked{/if}
                                                   value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <!-- Nút kích hoạt Modal -->
                                    <a href="#PaymentonepayvisaModal" class="btn btn_toggle_modal"
                                       data-bs-toggle="modal"
                                       data-bs-target="#PaymentonepayvisaModal">
                                        {$core->get_Lang('Setting')} <i class="fa-solid fa-crown icon_gradient"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal" id="PaymentonepayvisaModal" tabindex="-1" aria-labelledby="PaymentonepayvisaModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal_header_atm">
                                <h4 class="modal-title"
                                    id="PaymentonepayvisaModalLabel">{$core->get_Lang('Configure OnePay Visa Payment')}</h4>
                                <p class="txt_modalintro">{$core->get_Lang('Get payment configuration account information')}
                                    <a href="http://onepay.com.vn/" target="_blank">{$core->get_Lang('here')}</a>
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-method-setting">
                                <div class="setting_modal">
                                    <div class="panel panel-default" style="margin-bottom: 0;">
                                        <div class="panel-body paymentType">
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Name Method')}</label>
                                                <div class="controls">
                                                    {assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
                                                    <input bind="name" class="form-control required"
                                                           name="iso-{$ONEPAY_Visa_Name}" type="text"
                                                           value="{$clsConfiguration->getValue($ONEPAY_Visa_Name)}"
                                                           plcaeholder="{$core->get_Lang('Name Method')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">URL Payment</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required"
                                                           id="ONEPAY_Visa_URL_PAYMENT"
                                                           name="iso-ONEPAY_Visa_URL_PAYMENT" type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Visa_URL_PAYMENT')}"
                                                           plcaeholder="Thanh toán online qua thẻ nội địa (ATM)">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">Merchant ID</label>
                                                <div class="controls">
                                                    <input class="form-control required"
                                                           placeholder="MerchantId không vượt quá 500 ký tự"
                                                           id="ONEPAY_Visa_Merchant_ID"
                                                           name="iso-ONEPAY_Visa_Merchant_ID" type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Visa_Merchant_ID')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Hashcode')}</label>
                                                <div class="controls">
                                                    <input class="form-control required"
                                                           placeholder="Hashcode không được để trống"
                                                           id="ONEPAY_Visa_Secure_Hash"
                                                           name="iso-ONEPAY_Visa_Secure_Hash" type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Visa_Secure_Hash')}">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('AccessCode')}</label>
                                                <div class="controls">
                                                    <input class="form-control required" data-val="true"
                                                           placeholder="AccessCode không được để trống"
                                                           name="iso-ONEPAY_Visa_Access_Code"
                                                           id="ONEPAY_Visa_Access_Code" type="text"
                                                           value="{$clsConfiguration->getValue('ONEPAY_Visa_Access_Code')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Surcharge')}</label>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <div class="controls">
                                                            <label style="margin-bottom:10px; display:inline-block"><img
                                                                        src="{$URL_IMAGES}/visa_icon.png" width="auto"
                                                                        height="40"/></label>
                                                            <input class="form-control" placeholder="1.5"
                                                                   name="iso-ONEPAY_Visa_Surcharge"
                                                                   id="ONEPAY_Visa_Surcharge" type="text"
                                                                   value="{$clsConfiguration->getValue('ONEPAY_Visa_Surcharge')}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <div class="controls">
                                                            <label style="margin-bottom:10px; display:inline-block"><img
                                                                        src="{$URL_IMAGES}/american_e_icon.png"
                                                                        width="auto" height="40"/></label>
                                                            <input class="form-control" placeholder="1.5"
                                                                   name="iso-ONEPAY_American_Express_Surcharge"
                                                                   id="ONEPAY_American_Express_Surcharge" type="text"
                                                                   value="{$clsConfiguration->getValue('ONEPAY_American_Express_Surcharge')}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox"
                                                               name="ONEPAY_Visa_Test_Mode"
                                                               id="ONEPAY_Visa_Test_Mode"
                                                               {if $clsConfiguration->getValue('ONEPAY_Visa_Test_Mode') eq '1'}checked{/if}
                                                               value="1"/> {$core->get_Lang('Test Mode')}
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button_footer">
                                <p class="txt_footer">
                                    {$core->get_Lang('I allow isoCMS to save this payment method and automatically charge this payment method whenever a subscription is used with this method.')}
                                </p>
                                <div class="btn_savecancelpay">
                                    <button type="button" class="btn btn-secondary btn_cancel"
                                            data-bs-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                                    <button type="submit" class="btn btn_save">
                                        {$core->get_Lang('Save')}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {* Box VNPay*}

            <div class="col-lg-4 col-md-6">
                <form action="#" id="form-atm" method="post" class="validate-form">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img class="slideToggle"
                                         src="{$clsISO->getVar('IMG_VNPAY_GATEWAY')}" width="151" height="48">
                                    <p class="txt_infopayment">{$core->get_Lang('Payment VNPAY')}</p>
                                </div>
                                <div class="col-md-4">
                                    <!-- Công tắc on/off -->
                                    <div class="form-group toggle_switch">
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-payment-mode" name="VNPay_Status_Mode"
                                                   {if $clsConfiguration->getValue('VNPay_Status_Mode') eq '1'}checked{/if}
                                                   value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <!-- Nút kích hoạt Modal -->
                                    <a href="#PaymentvnpayModal" class="btn btn_toggle_modal" data-bs-toggle="modal"
                                       data-bs-target="#PaymentvnpayModal">
                                        {$core->get_Lang('Setting')} <i class="fa-solid fa-crown icon_gradient"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal" id="PaymentvnpayModal" tabindex="-1" aria-labelledby="PaymentvnpayModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal_header_atm">
                                <h4 class="modal-title"
                                    id="PaymentvnpayModalLabel">{$core->get_Lang('Configure VnPay Payment')}</h4>
                                <p class="txt_modalintro">{$core->get_Lang('Get payment configuration account information')}
                                    <a href="https://sandbox.vnpayment.vn/apis/docs/gioi-thieu/"
                                       target="_blank">{$core->get_Lang('here')}</a>
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-method-setting">
                                <div class="setting_modal">
                                    <div class="panel panel-default" style="margin-bottom: 0;">
                                        <div class="panel-body paymentType">
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Name Method')}</label>
                                                <div class="controls">
                                                    {assign var = VNPay_Name value = VNPay_Name_|cat:$_LANG_ID}
                                                    <input bind="name" class="form-control required"
                                                           name="iso-{$VNPay_Name}" type="text"
                                                           value="{$clsConfiguration->getValue($VNPay_Name)}"
                                                           plcaeholder="{$core->get_Lang('Name Method')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">URL Payment (vnp_Url)</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required"
                                                           id="VNPAY_URL_PAYMENT" name="iso-VNPAY_URL_PAYMENT"
                                                           type="text"
                                                           value="{$clsConfiguration->getValue('VNPAY_URL_PAYMENT')}"
                                                           plcaeholder="Url thanh toán">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">Terminal ID/ Mã Website
                                                    (vnp_TmnCode)</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required"
                                                           name="iso-VNPay_ID_Website" type="text"
                                                           value="{$clsConfiguration->getValue('VNPay_ID_Website')}"
                                                           plcaeholder="Terminal ID/ Mã Website">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('SecretKey')}
                                                    (vnp_HashSecret)</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required"
                                                           name="iso-VNPay_SecretKey" type="text"
                                                           value="{$clsConfiguration->getValue('VNPay_SecretKey')}"
                                                           plcaeholder="{$core->get_Lang('SecretKey')}">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Surcharge')}</label>
                                                <div class="controls">
                                                    <input class="form-control" placeholder="1.5"
                                                           name="iso-VNPay_Surcharge" id="VNPay_Surcharge" type="text"
                                                           value="{$clsConfiguration->getValue('VNPay_Surcharge')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox"
                                                               name="VNPay_Test_Mode"
                                                               {if $clsConfiguration->getValue('VNPay_Test_Mode') eq '1'}checked{/if}
                                                               value="1"/> {$core->get_Lang('Test Mode')}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button_footer">
                                <p class="txt_footer">
                                    {$core->get_Lang('I allow isoCMS to save this payment method and automatically charge this payment method whenever a subscription is used with this method.')}
                                </p>
                                <div class="btn_savecancelpay">
                                    <button type="button" class="btn btn-secondary btn_cancel"
                                            data-bs-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                                    <button type="submit" class="btn btn_save">
                                        {$core->get_Lang('Save')}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {*  Box VTC Pay*}
            <div class="col-lg-4 col-md-6">
                <form action="#" id="form-atm" method="post" class="validate-form">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <img class="slideToggle" height="50"
                                         src="{$clsISO->getVar('IMG_VTCPAY_GATEWAY')}" width="163" height="48">
                                    <p class="txt_infopayment">{$core->get_Lang('Payment VTCPay')}</p>
                                </div>
                                <div class="col-md-4">
                                    <!-- Công tắc on/off -->
                                    <div class="form-group toggle_switch">
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-payment-mode" name="VTCPay_Status_Mode"
                                                   {if $clsConfiguration->getValue('VTCPay_Status_Mode') eq '1'}checked{/if}
                                                   value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <!-- Nút kích hoạt Modal -->
                                    <a href="#PaymentVTCpayModal" class="btn btn_toggle_modal" data-bs-toggle="modal"
                                       data-bs-target="#PaymentVTCpayModal">
                                        {$core->get_Lang('Setting')} <i class="fa-solid fa-crown icon_gradient"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal" id="PaymentVTCpayModal" tabindex="-1" aria-labelledby="PaymentVTCpayModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="max-width: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal_header_atm">
                                <h4 class="modal-title"
                                    id="PaymentVTCpayModalLabel">{$core->get_Lang('Configure OnePay Payment')}</h4>
                                <p class="txt_modalintro">{$core->get_Lang('Get payment configuration account information')}
                                    <a href="https://vtcpay.vn/tai-lieu-tich-hop-website"
                                       target="_blank">{$core->get_Lang('here')}</a>
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-method-setting">
                                <div class="setting_modal">
                                    <div class="panel panel-default" style="margin-bottom: 0;">
                                        <div class="panel-body paymentType">
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Name Method')}</label>
                                                <div class="controls">
                                                    {assign var = VTCPay_Name value = VTCPay_Name_|cat:$_LANG_ID}
                                                    <input bind="name" class="form-control required"
                                                           name="iso-{$VTCPay_Name}" type="text"
                                                           value="{$clsConfiguration->getValue($VTCPay_Name)}"
                                                           plcaeholder="{$core->get_Lang('Name Method')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Mã website tích hợp')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required"
                                                           name="iso-VTCPay_ID_Website" type="text"
                                                           value="{$clsConfiguration->getValue('VTCPay_ID_Website')}"
                                                           plcaeholder="{$core->get_Lang('Mã website tích hợp')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Số tài khoản VTC Pay')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required"
                                                           name="iso-VTCPay_BUSINESS" type="text"
                                                           value="{$clsConfiguration->getValue('VTCPay_BUSINESS')}"
                                                           plcaeholder="{$core->get_Lang('Số tài khoản VTC Pay')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('SecretKey')}</label>
                                                <div class="controls">
                                                    <input bind="name" class="form-control required"
                                                           name="iso-VTCPay_SecretKey" type="text"
                                                           value="{$clsConfiguration->getValue('VTCPay_SecretKey')}"
                                                           plcaeholder="{$core->get_Lang('SecretKey')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Hướng dẫn thanh toán')}
                                                    <span>- Hiển thị ở trang thông báo mua hàng thành công và trang thanh toán</span></label>
                                                <div class="controls">
                                                    {assign var = VTCPay_Description value = VTCPay_Description_|cat:$_LANG_ID}
                                                    <textarea bind="name" class="form-control required"
                                                              name="iso-{$VTCPay_Description}" type="text"
                                                              plcaeholder="{$core->get_Lang('Hướng dẫn thanh toán')}">{$clsConfiguration->getValue($VTCPay_Description)}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label strong">{$core->get_Lang('Surcharge')}</label>
                                                <div class="controls">
                                                    <input class="form-control" placeholder="1.5"
                                                           name="iso-Paypal_Surcharge" id="Paypal_Surcharge" type="text"
                                                           value="{$clsConfiguration->getValue('Paypal_Surcharge')}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="checkbox-inline"><input type="checkbox"
                                                                                          name="VTCPay_Test_Mode"
                                                                                          {if $clsConfiguration->getValue('VTCPay_Test_Mode') eq '1'}checked{/if}
                                                                                          value="1"/> {$core->get_Lang('Test Mode')}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button_footer">
                                <p class="txt_footer">
                                    {$core->get_Lang('I allow isoCMS to save this payment method and automatically charge this payment method whenever a subscription is used with this method.')}
                                </p>
                                <div class="btn_savecancelpay">
                                    <button type="button" class="btn btn-secondary btn_cancel"
                                            data-bs-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                                    <button type="submit" class="btn btn_save">
                                        {$core->get_Lang('Save')}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>


</div>
{literal}
    <script type="text/javascript">
        $(function () {
            $('.pay_setting').click(function () {
                var $_this = $(this);
                var $_body = $_this.closest('form').find('.payment-method-setting');
                if ($('.payment-method-setting:visible').length) {
                    $('.payment-method-setting:visible').closest('form').find('.cancel_setting').trigger('click');
                }
                $_body.stop(false, true).removeClass('slidedown-hidden').addClass('slidedown-visible');
                $_this.hide();
                $_this.closest('form').find('.cancel_setting,.save_setting').show();
                return false;
            });
        });
        $('.cancel_setting').click(function () {
            var $_this = $(this);
            var $_body = $_this.closest('form').find('.payment-method-setting');
            $_body.stop(false, true).removeClass('slidedown-visible').addClass('slidedown-hidden');
            $_this.hide();
            $_this.closest('form').find('.save_setting').hide();
            $_this.closest('form').find('.pay_setting').show();
            return false;
        });
        $(document).ready(function () {
            // Xử lý thay đổi công tắc thanh toán
            $('.toggle-payment-mode').on('change', function () {
                let isChecked = $(this).is(':checked') ? 1 : 0;  // Trạng thái công tắc
                let settingName = $(this).attr('name');  // Lấy tên của field (ví dụ: SitePay_CashStatus_Mode)

                // Nếu tắt công tắc (isChecked == 0), yêu cầu xác nhận
                if (isChecked === 0) {
                    let confirmMessage = "Bạn có chắc chắn muốn tắt không?";
                    if (!confirm(confirmMessage)) {
                        // Nếu người dùng chọn Cancel, khôi phục trạng thái công tắc về 'checked'
                        $(this).prop('checked', true);
                        return;  // Dừng lại, không thực hiện tiếp
                    }
                }

                // Gửi dữ liệu qua AJAX để cập nhật trạng thái công tắc
                $.ajax({
                    url: path_ajax_script + "/?mod=homenew2024&act=ajaxpayment",
                    method: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        ajax: 'toggle',
                        setting: settingName,
                        value: isChecked
                    }),
                    success: function (data) {
                        // Kiểm tra dữ liệu trả về
                        if (data.success) {
                            if (data.reload) {
                                // Tải lại trang khi nhận được phản hồi yêu cầu reload
                                location.reload();
                            }
                        } else {
                            alert('Cập nhật thất bại: ' + (data.message || 'Không có thông báo.'));
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi:', error);  // Log lỗi nếu có
                        alert('Đã xảy ra lỗi khi cập nhật.');
                    }
                });
            });

            // Xử lý form submit khi nhấn Cập nhật trong modal
            $('#form-atm').on('submit', function (e) {
                e.preventDefault();  // Ngừng hành động submit mặc định của form

                // Lấy tất cả dữ liệu trong form dưới dạng mảng
                var formData = $(this).serializeArray();

                // Tạo đối tượng dữ liệu để gửi qua AJAX
                var paymentData = {};

                // Chuyển đổi mảng thành đối tượng có cấu trúc dễ sử dụng
                $.each(formData, function (index, field) {
                    var fieldName = field.name;
                    var fieldValue = field.value;
                    paymentData[fieldName] = fieldValue;
                });

                // Gửi dữ liệu qua AJAX để cập nhật thông tin thanh toán
                $.ajax({
                    url: path_ajax_script + "/?mod=homenew2024&act=ajaxpayment",
                    method: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        ajax: 'update_multiple',  // Gửi yêu cầu update cho nhiều phương thức
                        paymentData: paymentData  // Dữ liệu phương thức thanh toán
                    }),
                    success: function (data) {
                        if (data.success) {
                            alert('Cập nhật thông tin thành công!');
                            $('#paymentModal').modal('hide');  // Đóng modal
                            location.reload();  // Tải lại trang sau khi cập nhật
                        } else {
                            alert('Cập nhật thất bại: ' + (data.message || 'Không có thông báo.'));
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi:', error);
                        alert('Đã xảy ra lỗi khi cập nhật thông tin.');
                    }
                });
            });
        });


    </script>
    <style>
        .page_container .page-title {
            padding: 0;
        }

        .page_container .container-fluid {
            padding: 33px 0;
        }

        .panel__container {
            width: 100%;
            clear: both;
        }

        .panel__container:after,
        .panel__container:before {
            display: table;
            clear: both;
            content: "";
        }

        .panel {
            background: none;
            border-radius: 4px;
        }

        .panel-left {
            float: left;
            width: 24%;
        }

        .panel-light {
            vertical-align: top;
            float: right;
            width: 75%;;
            margin: 0;
            padding: 0;
        }

        .clearfix::after,
        .clearfix::before {
            content: " ";
            display: table;
        }

        .payment-setting {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding-bottom: 0px;
            padding-left: 0;
            padding-right: 0;
        }

        .payment-setting .payment-header {
            position: relative;
            padding: 10px 0px 10px 50px;
        }

        .slidedown-hidden.slidedown-visible {
            -webkit-transition: max-height 1s;
            -moz-transition: max-height 1s;
            transition: max-height 1s;
            max-height: 1500px;
            position: relative;
            visibility: visible;
            overflow: hidden;
        }

        .slidedown-hidden {
            position: absolute;
            visibility: hidden;
            max-height: 0;
            background: #f5f6f7;
            padding: 10px 20px 20px;
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel > .panel-body:last-child {
            border-bottom-right-radius: inherit;
            border-bottom-left-radius: inherit;
        }

        .panel-body:after, .panel-body:before,
        .form-group:after,
        .form-group:before {
            content: " ";
            display: table;
            clear: both;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            height: 32px;
            box-shadow: none;
            padding: 6px 8px;
            background-image: none;
        }

        .btn-default {
            border-color: #d0d0d0;
        }

        .btn {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid #DDD;
            white-space: nowrap;
            font-size: 13px;
            border-radius: 4px;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            color: #479ccf;
        }

        .form-control, output {
            font-size: 13px;
            line-height: 1.428571429;
            color: #555;
            display: block;
        }

        .form-control {
            width: 100%;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 3px;
            -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        .payment-setting .logo {
            border-right: dotted 1px #eaeaea;
            position: absolute;
            width: 60px;
            height: 100%;
            top: 0;
            left: 0;
        }

        .top21 {
            padding: 10px 0px;
            border-top: 1px solid #ebeef0;
            text-align: right;
            margin-right: 20px;
        }

        label.strong {
            font-weight: 700;
            margin-bottom: 5px;
            display: block
        }

        .panel .panel-body, .panel-lg .panel-body, .panel-lg .panel-footer, .panel-lg .panel-heading {
            background: #fff;
        }

        .payment-setting .payment-header, .payment-setting .payment-content, .payment-setting .payment-method-setting {
            padding: 20px;
            overflow: hidden;
        }

        .slideToggle, .slideToggle1 {
            cursor: pointer;
        }

        .fancybox__container {
            overflow: visible !important;
        }

        .button_footer {
            margin-top: 14px;
        }

        .button_footer .txt_footer {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */

        }

        .fancybox__carousel.is-draggable .fancybox__slide .fancybox__content {
            cursor: auto;
        }

        /* Kiểu dáng công tắc */
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input {
            display: none; /* Ẩn checkbox mặc định */
        }

        .toggle_switch {
            justify-items: center;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider::before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-18-babd, #18BABD);
        }

        input:checked + .slider::before {
            transform: translateX(14px);
        }

        .modal-body {
            overflow-x: scroll;
        }

        .modal_header_atm h4 {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: "Roboto";
            font-size: 18px;
            font-style: normal;
            font-weight: 700;
            line-height: 26px; /* 144.444% */
        }

        .modal_header_atm p {
            color: var(--chroma-717171, #717171);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        .modal_header_atm p a {
            color: var(--primary-18-babd, #18BABD);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
        }

        .modal_header_atm p a:hover {
            text-decoration: underline;
        }

        .modal-body {
            background: #F6F6FA;
            padding: 18px;
        }

        .modal-header {
            padding: 18px;
        }

        .btn_savecancelpay {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;

        }

        .btn_cancel, .btn_save {
            color: #FFF;
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 24px */
            padding: 12px 16px;
        }

        .btn_save {
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
        }

        .btn_save:hover {
            background: var(--secondary-177-fa-4, #177FA4);
            color: #FFF;
        }

        .txt_infopayment {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 24px */
        }

        .modal-body {
            color: var(--chroma-717171, #717171);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
        }
        .btn_toggle_modal {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 4px;
            border: 1px solid var(--chroma-c-8-cbd-0, #C8CBD0);
            font-size: 16px;
            gap: 10px;
        }
        .btn_toggle_modal:hover {
            border: 1px solid var(--chroma-c-8-cbd-0, #C8CBD0);
        }

        .icon_gradient {
            background: linear-gradient(45deg, #FF6100, #FDB82E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            font-size: 20px;
        }
    </style>
{/literal}