<div class="page_container">
    <div class="container">
        <div class="col-md-8 col-xs-12" style="margin: 0 auto;">
            <div class="holder-text">
                {if $transStatus eq '0'}
                <div style="border:1px solid #C00000; background:#F90; padding:10px; text-align:center; color:#fff"> 
                    <strong>{$core->get_Lang('Your order has been paid failed')}!</strong> 
                </div>
                {/if}
                {if $transStatus eq '1'}
                <div style="border:1px solid #03460c; background:#077f0a; padding:10px; text-align:center; color:#fff"> 
                    <strong>{$core->get_Lang('Your order has been paid successfully')}!</strong>
                </div>
                {/if}
                {if $transStatus eq '2'}
                <div style="border:1px solid #C00000; background:#F90; padding:10px; text-align:center; color:#fff"> 
                    <strong>{$core->get_Lang('Your order has been paid pending')}!</strong>
                </div>
                {/if}
                {if $transStatus eq '4'}
                <div style="border:1px solid #C00000; background:#F90; padding:10px; text-align:center; color:#fff"> 
                    <strong>{$core->get_Lang('Your order has been paid cancel')}!</strong>
                </div>
                {/if}
                <div class="billing__msg">
                    {$clsBilling->getHTMLPaymentCard($billing_id)}
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