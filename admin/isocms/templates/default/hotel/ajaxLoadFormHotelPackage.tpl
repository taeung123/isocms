<div class="headPop">
    <a class="closeEv close_pop" href="javascript:void();" title="{$core->get_Lang('close')}"></a>
    <h3>
        {if $hotel_package_id > 0} 
            {$core->get_Lang('Edit hotel package')} 
        {else} 
            {$core->get_Lang('Add hotel package')} 
        {/if}
    </h3>
</div>
<form method="post" class="frmform" enctype="multipart/form-data">
    <input type="hidden" name="hotel_package_id" value="{$hotel_package_id}">
    <div class="wrap">
        <div class="row-span">
            <div class="fieldlabel text-right bold"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">*</span></div>
            <div class="fieldarea">
                <input class="text_32 border_aaa full-width bold required" name="title" placeholder="Enter title" value="{if $oneItem && $oneItem.title}{$oneItem.title}{/if}" type="text" autocomplete="off">
            </div>
        </div>
        {*<div class="row-span">
            <div class="fieldlabel text-right bold"><strong>{$core->get_Lang('Intro')}</strong> <span class="color_r">*</span></div>
            <div class="fieldarea">
                <textarea class="textarea_intro_editor" id="textarea_package_intro{$now}" cols="255" rows="2"></textarea>
            </div>
        </div>*}
        <div class="row-span">
            <div class="fieldlabel text-right bold"><strong>{$core->get_Lang('Service')}</strong> <span class="color_r">*</span></div>
            <div class="fieldarea">
                <div class="box_service_button">
                    <div class="btn btn-primary btn_load_service">{$core->get_Lang('Choose services')}</div>
                    <a class="btn btn-main btn-addnew iso_event_hotel_services" data-key="{$clsClassTable->pkey}" data-type="F" title="{$core->get_Lang('Add service')}">
                        {$core->get_Lang('Add service')}
                    </a>
                </div>
               
                <div class="iso_box_service hidden">
                    <h4>{$core->get_Lang('Services')}</h4>
                    <div class="iso_lst_services">
                        <div class="row" id="iso_lst_services">
                            
                        </div>
                    </div>
                    <div class="iso_btn_service">
                        <div class="btn_apply btn btn-primary">
                            {$core->get_Lang('Apply')}
                        </div>
                        <div class="btn_close btn btn-warning">
                            {$core->get_Lang('Close')}
                        </div>
                    </div>
                </div>
                <div class="iso_package_services">
                    <div class="accordion smk_accordion acc_with_icon">
                        {if $lstPackageServices}
                            {foreach from=$lstPackageServices key=key item=item} 
                                <div class="accordion_in {if $key == 0}acc_active{/if}">
                                    <input type="hidden" class="lst_hotel_service_id" value="{$item.hotel_service_id}">
                                    <div class="acc_head">
                                        <div class="acc_icon_expand"></div>
                                        <div class="iso_accordion">
                                            <div class="acc_head_txt">{$item.service_title}</div>
                                            <div class="acc_head_delete">
                                                <i class="icon-trash"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="acc_content" >
                                        <textarea id="textarea_intro_{$now}_{$item.hotel_service_id}" class="textarea_intro_editor">{$item.intro}</textarea>
                                    </div>
                                </div>
                            {/foreach}
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="text-align:center"> 
        <button type="submit" class="btn btn-primary iso_submitFormPackage">
            <i class="icon-ok icon-white"></i> 
            <span>{$core->get_Lang('save')}</span>
        </button> 
        <button type="reset" class="btn btn-warning close_pop"> 
            <i class="icon-retweet icon-white"></i> 
            <span>{$core->get_Lang('close')}</span> 
        </button> 
    </div>
</form>
{literal}
<style>
    .frmPop{
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
    }

    .frmPop .frmform{
        max-height: calc(100vh - 150px);
        overflow-y: scroll;
    }

    .iso_box_service {
        padding: 0 10px 10px 10px;
        border: 1px solid #CCC;
        margin-top: 15px;
        border-radius: 4px;
    }

    .iso_lst_services{
        padding: 10px;
        border: 1px solid #CCC;
        margin-top: 15px;
        border-radius: 4px;
        max-height: 300px;
        overflow: auto;
    }

    .iso_btn_service{
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
        gap: 15px;
    }

    .iso_package_services {
        margin-top: 15px;
    }

    .iso_accordion {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .acc_head_delete {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
</style> 
{/literal}