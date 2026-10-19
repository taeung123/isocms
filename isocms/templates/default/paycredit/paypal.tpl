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