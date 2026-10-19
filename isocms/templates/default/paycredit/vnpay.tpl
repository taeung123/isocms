<div class="container">
	<div class="holder-text" align="center">
    	<h1>Redirecting to gateway....</h1>
    	<p>Please wailt...</p>
    </div>
</div>
<form id="frmBooking" action="{$DOMAIN_NAME}/inc/payment/vnpay/vnpay_create_payment.php" method="post"  style="display:none">
    <input type="hidden" name="amount" value="{$vpc_Amount}">
    <input type="hidden" name="bankCode" value="">
    <input type="hidden" name="language" value="en">
    <input type="hidden" name="billing_id" value="{$billing_id}">

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
