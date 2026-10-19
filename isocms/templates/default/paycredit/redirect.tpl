<div class="container">
	<div class="holder-text" align="center">
    	<h1>Redirecting to gateway....</h1>
    	<p>Please wailt...</p>
    </div>
</div>
{literal}
<style type="text/css">
	body{
		padding:100px 0 0 0;
	}
	.holder-text{
		margin:100px 0px;
		line-height:40px;
	}
	.holder-text > p{
		color:#999;
	}
</style>
{/literal}
{if $billing_method eq $clsISO->getVar('PAYMENT_ONEPAY_VISA') || $billing_method eq $clsISO->getVar('PAYMENT_ONEPAY_AE') || $billing_method eq $clsISO->getVar('PAYMENT_ONEPAY_ATM')}
<form style="display:none;" name="frmBooking" id="frmBooking0" method="post" action="{$PCMS_URL}/inc/onepaycredit/{$onepaycredit}/do.php">
    <input type="hidden" name="virtualPaymentClientURL" value="{$VPC_URLPAYMENT}" />
    <input type="hidden" name="Title" value="VPC 3-Party" />
    <input type="hidden" name="vpc_Merchant" value="{$VPC_MERCHANT}" />  
    <input type="hidden" name="vpc_AccessCode" value="{$VPC_ACCESSCODE}" />
    <input type="hidden" name="vpc_MerchTxnRef" id="vpc_MerchTxnRef" value="{$vpc_MerchTxnRef}" />
    <input type="hidden" name="vpc_OrderInfo" id="vpc_OrderInfo" value="{$vpc_OrderInfo}" />
    <input type="hidden" name="vpc_Amount" id="vpc_Amount" value="{$vpc_Amount}" />
    {if $billing_method eq $clsISO->getVar('PAYMENT_ONEPAY_ATM')}
    <input type="hidden" name="vpc_Currency" id="vpc_Currency" value="VND" />
    {/if}
    <input type="hidden" name="vpc_ReturnURL" value="{$PCMS_URL}/inc/onepaycredit/{$onepaycredit}/dr.php" />
    <input type="hidden" name="vpc_Version" value="2" />
    <input type="hidden" name="vpc_Command" value="pay" />
    <input type="hidden" name="vpc_Locale" value="en" />
    {if $billing_method eq $clsISO->getVar('PAYMENT_ONEPAY_ATM')}
    <input type="hidden" name="vpc_Type" value="2" />
    {else}
    <input type="hidden" name="vpc_Type" value="1" />
    {/if}
    <input type="hidden" name="vpc_TicketNo" id="vpc_TicketNo" value="{$vpc_TicketNo}" />
    <input type="hidden" name="vpc_SHIP_Street01" value="39A Ngo Quyen" />
    <input type="hidden" name="vpc_SHIP_Provice" value="Hoan Kiem" />
    <input type="hidden" name="vpc_SHIP_City" value="Ha Noi" />
    <input type="hidden" name="vpc_SHIP_Country" value="Viet Nam" />
    <input type="hidden" name="vpc_Customer_Phone" value="840904280949" />
    <input type="hidden" name="vpc_Customer_Email" value="support@onepay.vn" />
    <input type="hidden" name="vpc_Customer_Id" value="thanhvt" />   
    {literal} 
	<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(function(){
                $('#frmBooking0').submit();
            });
        })
    </script>
    {/literal}                                  
</form>
{elseif $billing_method eq $clsISO->getVar('PAYMENT_PAYPAL_GATEWAY')}
<form action="https://www{if $clsConfiguration->getValue('Paypal_Test_Mode')}.sandbox{/if}.paypal.com/cgi-bin/webscr" method="post" id="frmBooking" style="display:none">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="{$clsConfiguration->getValue('Paypal_EmailReceived')}">
    <input type="hidden" name="image_url" value="{$clsConfiguration->getValue('HeaderLogo')}">
    <input type="hidden" name="item_name" value="{$PAGE_NAME} - Booking Payment {$billing_code}">
    <input type="hidden" name="amount" value="{$totalRate}">
    <input type="hidden" name="tax" value="0.00">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="address_override" value="0">
    <input type="hidden" name="first_name" value="{$first_name}">
    <input type="hidden" name="last_name" value="{$last_name}">
    <input type="hidden" name="address1" value="{$address}">
    <input type="hidden" name="city" value="">
    <input type="hidden" name="state" value="">
    <input type="hidden" name="zip" value="">
    <input type="hidden" name="country" value="{$country}">
    <input type="hidden" name="night_phone_a" value="">
    <input type="hidden" name="night_phone_b" value="{$phone}">
    <input type="hidden" name="charset" value="utf-8">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="custom" value="{$billing_id}">
    <input type="hidden" name="return" value="{$PCMS_URL}/payment/paypal/{$billing_id}/success.html">
    <input type="hidden" name="cancel_return" value="{$PCMS_URL}/payment/paypal/{$billing_id}/cancel.html">
    <input type="hidden" name="notify_url" value="{$PCMS_URL}/payment/paypal/{$billing_id}/notify.html">
    <input type="hidden" name="bn" value="VIETISO_ST">
    <input type="hidden" name="rm" value="2">
    <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but03.gif" border="0" name="submit" alt="Make a one time payment with PayPal">
    {literal}
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(function(){
                $('#frmBooking').submit();
            });
        })
    </script>
    {/literal}
</form>
{elseif $billing_method eq 9}
<form id="frmBooking" action="https://sand-payment.9pay.vn/payments/create" method="post"  style="display:none">
    <input type="hidden" name="merchantKey" value="{$MERCHANT_KEY}" />
    <input type="hidden" name="time" value="{$time}" />
    <input type="hidden" name="invoice_no" value="{$invoiceNo}">
    <input type="hidden" name="amount" value="{$amount}">
    <input type="hidden" name="description" value="{$description}">
    <input type="hidden" name="back_url" value="{$back_url}">
    <input type="hidden" name="return_url" value="{$return_url}">
    </div>
    {literal}
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(function(){
                $('#frmBooking').submit();
            });
        })
    </script>
    {/literal}
</form>
{/if}