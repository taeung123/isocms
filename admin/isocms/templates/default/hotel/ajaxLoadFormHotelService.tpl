<div class="headPop">
    <a class="closeEv close_pop" href="javascript:void();" title="{$core->get_Lang('close')}"></a>
    <h3>
        {if $hotel_service_id > 0} 
            {$core->get_Lang('Edit hotel service')} 
        {else} 
            {$core->get_Lang('Add hotel service')} 
        {/if}
    </h3>
</div>
<form method="post" class="frmform" enctype="multipart/form-data">
    <input type="hidden" name="hotel_service_id" value="{$hotel_service_id}">
    <div class="wrap">
        <div class="row-span">
            <div class="fieldlabel text-right bold"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">*</span></div>
            <div class="fieldarea">
                <input class="text_32 border_aaa full-width bold required" name="title" placeholder="Enter title" value="{if $oneItem && $oneItem.title}{$oneItem.title}{/if}" type="text" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="modal-footer" style="text-align:center"> 
        <button type="submit" class="btn btn-primary iso_submitFormClick">
            <i class="icon-ok icon-white"></i> 
            <span>{$core->get_Lang('save')}</span>
        </button> 
        <button type="reset" class="btn btn-warning close_pop"> 
            <i class="icon-retweet icon-white"></i> 
            <span>{$core->get_Lang('close')}</span> 
        </button> 
    </div>
</form>