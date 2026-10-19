<div class="billingInfo bg_fff pd20_991 mb20">
    <div class="booking_tab">
        <div class="payment-choice">
        	{if $clsConfiguration->getValue('SitePay_CashStatus_Mode')}
            {assign var = SitePay_CashName value = SitePay_CashName_|cat:$_LANG_ID}
            {assign var = SitePay_CashDesc value = SitePay_CashDesc_|cat:$_LANG_ID}
            <label style="cursor:pointer;" class="mb10"><input type="radio" class="chkPayment" name="payment_method" {if $payment_method eq $PAYMENT_CASH_ID || !isset($payment_method)}checked="checked"{/if} value="{$PAYMENT_CASH_ID}"> {$clsConfiguration->getValue($SitePay_CashName)}</label><br>
               {if $clsConfiguration->getValue($SitePay_CashDesc)}
                <div class="SitePay_CashDesc" style="border:1px solid #ddd; padding:10px; margin:5px 0px;margin-bottom: 15px; display:block;">
                    {$clsConfiguration->getValue($SitePay_CashDesc)|html_entity_decode}
                </div>
               {/if}
            {/if}
            {if $clsConfiguration->getValue('SitePay_Bank_Mode')}
            {assign var = SitePay_BankName value = SitePay_BankName_|cat:$_LANG_ID}
            {assign var = SitePay_BankDesc value = SitePay_BankDesc_|cat:$_LANG_ID}
            <label style="cursor:pointer;" class="mb10">
                <input type="radio" class="chkPayment" name="payment_method" {if $payment_method eq $PAYMENT_TRANSFER_ID}checked="checked"{/if} value="{$PAYMENT_TRANSFER_ID}">
                {$clsConfiguration->getValue($SitePay_BankName)}
            </label><br> 
            <div class="SitePay_BankDesc" style="border:1px solid #ddd; padding:10px; margin:5px 0px;margin-bottom: 15px; display:none">
            	{$clsConfiguration->getValue($SitePay_BankDesc)|html_entity_decode}
            </div>
            {/if}
            {if $clsISO->getVar('PAYMENT_ONLINE_GLOBAL')}         
            	<!-- Onepay ATM -->                           
                {if $clsConfiguration->getValue('ONEPAY_Status_Mode')}
                {assign var = ONEPAY_Name value = ONEPAY_Name_|cat:$_LANG_ID}
                <div id="divATM" >
                  <label style="cursor:pointer;" class="mb10"><input type="radio" class="chkPayment ATMDefault" name="payment_method" {if $payment_method eq $PAYMENT_ONEPAY_ATM}checked="checked"{/if} value="{$PAYMENT_ONEPAY_ATM}"><img src="{$URL_IMAGES}/icon/one-pay.png" alt=""></label><br>
                </div>
                {/if}
                <!-- Onepay Visa -->
                {if $clsConfiguration->getValue('ONEPAY_Visa_Status_Mode')}
                {assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
                <div id="divATM" >
                  <label style="cursor:pointer;" class="mb10"><input type="radio" class="chkPayment ATMDefault" name="payment_method" {if $payment_method eq $PAYMENT_ONEPAY_VISA}checked="checked"{/if} value="{$PAYMENT_ONEPAY_VISA}"><img src="{$URL_IMAGES}/icon/visa-master.png" alt=""></label><br>
                </div>
                {/if}
				{if $clsConfiguration->getValue('ONEPAY_Visa_Status_Mode')}
                {assign var = ONEPAY_Visa_Name value = ONEPAY_Visa_Name_|cat:$_LANG_ID}
                <div id="divATM" >
                  <label style="cursor:pointer;" class="mb10"><input type="radio" class="chkPayment ATMDefault" name="payment_method" {if $payment_method eq 6}checked="checked"{/if} value="6"><img src="{$URL_IMAGES}/icon/american.svg" style="height:32px" alt=""></label><br>
                </div>
                {/if}
                <!-- Paypal -->
                {if $clsConfiguration->getValue('Paypal_Status_Mode')}
                {assign var = Paypal_Name value = Paypal_Name_|cat:$_LANG_ID}
                <div id="divATM" >
                  <label style="cursor:pointer;" class="mb10"><input type="radio" class="chkPayment ATMDefault" name="payment_method" {if $payment_method eq $PAYMENT_PAYPAL_GATEWAY}checked="checked"{/if} value="{$PAYMENT_PAYPAL_GATEWAY}"><img src="{$URL_IMAGES}/icon/paypal.png" alt=""></label><br>
                </div>
                {/if}
				<!-- VTCPay -->
                {if $clsConfiguration->getValue('VTCPay_Status_Mode')}
                {assign var = VTCPay_Name value = VTCPay_Name_|cat:$_LANG_ID}
                <div id="divATM" >
                  <label style="cursor:pointer;" class="mb10"><input type="radio" class="chkPayment ATMDefault" name="payment_method" {if $payment_method eq $PAYMENT_VTCPAY_GATEWAY}checked="checked"{/if} value="{$PAYMENT_VTCPAY_GATEWAY}"><img src="{$URL_IMAGES}/icon/vtcpay.png" alt=""></label><br>
                </div>
                {/if}
            {/if}
			<div class="SitePay_OnePay" style="display:none">
				{if $clsConfiguration->getValue('ONEPAY_Surcharge') gt 0}
				<span class="surharge-ins">Surcharge of {$clsConfiguration->getValue('ONEPAY_Surcharge')}% on ONEPAY ATM.</span>
				{/if}
			</div>
			<div class="SitePay_Visa" style="display:none">
				{if $clsConfiguration->getValue('ONEPAY_Visa_Surcharge') gt 0}
				<span class="surharge-ins">Surcharge of {$clsConfiguration->getValue('ONEPAY_Visa_Surcharge')}% on Visa & MasterCard is applicable.</span>
				{/if}
			</div>
			<div class="SitePay_PayPal" style="display:none">
				{if $clsConfiguration->getValue('Paypal_Surcharge') gt 0}
				<span class="surharge-ins">Paypal surcharge of {$clsConfiguration->getValue('Paypal_Surcharge')}% is applicable.</span>
				{/if}
			</div>
			<div class="SitePay_AE" style="display:none">
				{if $clsConfiguration->getValue('ONEPAY_American_Express_Surcharge') gt 0}
				<span class="surharge-ins">Surcharge of {$clsConfiguration->getValue('ONEPAY_American_Express_Surcharge')}% on American Express is applicable.</span>
				{/if}
			</div>
			<div class="SitePay_VTCPay" style="display:none">
				{if $clsConfiguration->getValue('Paypal_Surcharge') gt 0}
				<span class="surharge-ins">Paypal surcharge of {$clsConfiguration->getValue('Paypal_Surcharge')}% is applicable.</span>
				{/if}
			</div>
        </div>
        <label class="size16"><input type="checkbox" name="proviso" id="proviso" checked value="1"> {$core->get_Lang('I agree')} <a class="" title="{$core->get_Lang('Terms &amp; Conditions')}" href="{$clsISO->getLink('term_condition')}">{$core->get_Lang('Terms &amp; Conditions')}</a> {$core->get_Lang('and')} <a class="" href="{$clsISO->getLink('payment_method')}" title="{$core->get_Lang('Policy')}">{$core->get_Lang('Policy')}</a> {$core->get_Lang('of')} {$PAGE_NAME}. </label>
    </div>
</div>
{*<div class="termPayment bg_fff pd30 pd20_991">
	<h3 class="size18 mb05">{if $mod eq 'tour'}<span class="number">7</span>{/if}{$core->get_Lang('Terms of payment')}</h3>
	<div class="clearfix mt25"></div>
    <div style="height: 200px; overflow: auto;border:1px solid #ccc;padding:10px;">
		{assign var = SiteMsg_TermsOfPayment value = SiteMsg_TermsOfPayment_|cat:$_LANG_ID}
		{$clsConfiguration->getValue($SiteMsg_TermsOfPayment)|html_entity_decode}
    </div>
</div>*}
{literal}
<script>
	$(function(){
		$('input[name=payment_method]').change(function(){
			var _val = $(this).val();
			if(_val==2){
				$('.SitePay_BankDesc').show();
			}else{
				$('.SitePay_BankDesc').hide();
			}
			if(_val==1){
				$('.SitePay_CashDesc').show();
			}else{
				$('.SitePay_CashDesc').hide();
			}
			if(_val==3){
				$('.SitePay_OnePay').show();
			}else{
				$('.SitePay_OnePay').hide();
			}
			if(_val==4){
				$('.SitePay_Visa').show();
			}else{
				$('.SitePay_Visa').hide();
			}
			if(_val==5){
				$('.SitePay_PayPal').show();
			}else{
				$('.SitePay_PayPal').hide();
			}
			if(_val==6){
				$('.SitePay_AE').show();
			}else{
				$('.SitePay_AE').hide();
			}
			if(_val==7){
				$('.SitePay_VTCPay').show();
			}else{
				$('.SitePay_VTCPay').hide();
			}
		});
	});
</script>
{/literal}