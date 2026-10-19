<div class="page_container">
    <div class="container">
        <div class="col-md-8 col-md-offset-2 col-xs-12">
            <div class="holder-text">
                

                {if $vnp_ResponseCode eq '00'}
                <div style="border:1px solid #03460c; background:#077f0a; padding:10px; text-align:center; color:#fff"> 
                    <strong>{$core->get_Lang('Your order has been paid successfully')}!</strong>
                </div>
                {elseif $vnp_ResponseCode eq '24'}
                <div style="border:1px solid #C00000; background:#F90; padding:10px; text-align:center; color:#fff"> 
                    <strong>{$core->get_Lang('Transaction failed because: Customer cancel transaction')}!</strong> 
                </div>
                {else}
                <div style="border:1px solid #C00000; background:#F90; padding:10px; text-align:center; color:#fff"> 
                    <strong>{$core->get_Lang('Transaction failed')}!</strong>
                </div>
                {/if}
               
               
                <div class="billing__msg">
                    {$clsBilling->getHTMLPaymentVNPayCard($billing_id)}
                </div>
            </div>
        </div>
    </div>
</div>

{literal}
<style type="text/css">
	.billing__msg{
		padding:10px;
		margin:10px 0 0;
		border:1px solid #DDD;
		background:#FFF;
	}
	body{
		padding:76px 0 0 0;
	}
	.holder-text{
		margin:20px 0px;
		line-height:40px;
	}
</style>
{/literal}