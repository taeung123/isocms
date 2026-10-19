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
<form id="frmBooking" action="" method="post"  style="display:none">
    <input type="hidden" name="merchantKey" value="{$MERCHANT_KEY}" />
    <input type="hidden" name="time" value="{$time}" />
    <input type="hidden" name="invoice_no" value="{$invoiceNo}">
    <input type="hidden" name="amount" value="{$amount}">
    <input type="hidden" name="description" value="{$description}">
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