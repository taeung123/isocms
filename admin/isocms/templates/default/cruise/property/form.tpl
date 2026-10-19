<div class="headPop">
    <a class="closeEv close_pop" href="javascript:void();" title="{$core->get_Lang('close')}"></a>
    <h3>{if $cruise_property_id == 0} {$core->get_Lang('Add New')}   {else} {$core->get_Lang('Edit')} {/if} {$type}</h3>
</div>
<form method="post" id="frmForm" class="frmform formborder" enctype="multipart/form-data">
    <ul class="nav nav-tabs" style="margin-left: 0; margin-bottom: 15px;">
        {foreach from=$listLang key=key item=item}
            <li class="{if $key == 0}active{/if}"><a data-toggle="tab" href="#lang_{$item}">{$clsISO->getFullLanguage($item)}</span></a></li>
        {/foreach}
    </ul>
    <div class="tab-content">
        {foreach from=$listLang key=key item=item}
        <div id="lang_{$item}" class="tab-pane fade {if $key == 0}in active{/if}">
            <div class="wrap">
                <div class="row-span">
                    <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('title')}</strong> <font class="color_r">*</font></div>
                    <div class="fieldarea">
                        <input class="text_32 border_aaa full-width bold required" name="title" placeholder="{$core->get_Lang('entertitle')}" value="{$clsCruiseProperty->getTitle($cruise_property_id)}" type="text" autocomplete="off" />
                    </div>
                </div>
            </div>
            {if $type == 'GroupSize'} 
            <div class="row-span">
                <div class="fieldlabel text-left bold"></div>
                <div class="fieldarea bold">
                    <input name="is_private" {if $is_private == 1}checked{/if} value="1" type="checkbox" style="width:20px; margin-right:5px!important;cursor: pointer;"/> {$core->get_Lang('CruisePrivate')}
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel text-left bold"></div>
                <div class="fieldarea bold">
                    <input name="is_extra_bed" {if $is_extra_bed == 1}checked{/if} value="1" type="checkbox" style="width:20px; margin-right:5px!important;cursor: pointer;"/>{$core->get_Lang('Extra bed')}
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Max adults')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold price-In" required name="number_adult" min="1" value="{$number_adult}" type="number" style="width:120px"/>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Max children')}</strong></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold price-In" name="number_child" value="{$number_child}" type="number" style="width:120px" min="0"/>
                </div>
            </div>
            {else if $type == 'GroupBenefits'}
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Class Icon')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold required full-width" name="class_icon" value="{$clsCruiseProperty->getClassIcon($cruise_property_id)}" type="text"/>
                </div>
            </div>
            {else if $type == 'GroupCruiseFacilities'}
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Class Icon')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold required full-width" name="class_icon" value="{$clsCruiseProperty->getClassIcon($cruise_property_id)}" type="text"/>
                </div>
            </div>
            {else if $type == 'GroupNearestEssentials'}
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Class Icon')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold required full-width" name="class_icon" value="{$clsCruiseProperty->getClassIcon($cruise_property_id)}" type="text"/>
                </div>
                </div>
            {else if $type == 'NearestEssentials'}
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Group')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <select name="group_id" style="width:300px">
                        {$clsCruiseProperty->getSelectByProperty('GroupNearestEssentials', $clsCruiseProperty->getOneField('group_id', $cruise_property_id))}
                    </select>
                </div>
            </div>
            {else if $type == 'UsefulInformation'} 
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Class Icon')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold required full-width" name="class_icon" value="{$clsCruiseProperty->getClassIcon($cruise_property_id)}" type="text"/>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Group')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <select name="group_id" style="width:300px">
                        {$clsCruiseProperty->getSelectByProperty('GroupUsefulInformation', $clsCruiseProperty->getOneField('group_id', $cruise_property_id))}
                    </select>
                </div>
            </div>
            {else if $type == 'Benefits'}
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Class Icon')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold required full-width" name="class_icon" value="{$clsCruiseProperty->getClassIcon($cruise_property_id)}" type="text"/>
                </div>
                <div class="row-span">
                    <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Group')}</strong> <font class="color_r">*</font></div>
                    <div class="fieldarea">
                        <select name="group_id" style="width:300px">
                            {$clsCruiseProperty->getSelectByProperty('GroupBenefits', $clsCruiseProperty->getOneField('group_id', $cruise_property_id))}
                        </select>
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel  text-left"><strong>{$core->get_Lang('Short text')}</strong></div>
                    <div class="fieldarea">
                        <textarea id="textarea_intro_editor" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">{$clsCruiseProperty->getIntro($cruise_property_id)}</textarea>
                    </div>
                </div>
            </div>
            {else if $type == 'CabinFacilities'} 
            <div class="row-span">
                <div class="fieldlabel" style="text-align:left"><strong>{$core->get_Lang('Icon')}</strong></div>
                <div class="fieldarea">
                    <img class="isoman_img_pop" id="isoman_show_image" src="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}" style="width:32px; height:32px"/>
                    <input type="hidden" id="isoman_hidden_image" value="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}">
                    <input class="fl ml10 text_32 border_aaa" style="width:70% !important;display:inline-block" type="text" id="isoman_url_image" name="image" value="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}" isoman_name="image"><img src="{URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                </div>
            </div>
            {else if $type == 'CruiseFacilities' || $type == 'CruiseFaActivities'}
            <div class="row-span">
                <div class="fieldlabel" style="text-align:left"><strong>{$core->get_Lang('Icon')}</strong></div>
                <div class="fieldarea">
                    <img class="isoman_img_pop" id="isoman_show_image" src="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}" style="width:32px; height:32px"/>
                    <input type="hidden" id="isoman_hidden_image" value="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}">
                    <input class="fl ml10 text_32 border_aaa" style="width:70% !important;display:inline-block" type="text" id="isoman_url_image" name="image" value="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}" isoman_name="image"><img src="{URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                </div>
            </div>
            {else if $type == 'ThingLove'}
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Class Icon')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold required full-width" name="class_icon" value="{$clsCruiseProperty->getClassIcon($cruise_property_id)}" type="text"/>
                </div>
            </div>
            {else if $type == 'Conditions'}
            <div class="row-span">
                <div class="fieldlabel text-left bold"><strong>{$core->get_Lang('Group')}</strong> <font class="color_r">*</font></div>
                <div class="fieldarea">
                    <select name="group" style="width:100px">
                        <option value="Default" {if $clsCruiseProperty->getOneField('type_group', $cruise_property_id) == 'Default'}selected {/if}>{$core->get_Lang('Default')}</option>
                        <option value="Free" {if $clsCruiseProperty->getOneField('type_group', $cruise_property_id) == 'Free'}selected{/if}>{$core->get_Lang('Free')}</option>
                    </select>
                </div>
            </div>
            {else if $type == 'MEAL'} 
            <div class="row-span">
                <div class="fieldlabel" style="text-align:left"><strong>{$core->get_Lang('Symbol')}</strong> <span class="color_r">*</span></div>
                <div class="fieldarea">
                <input type="text" name="symbol" class="text full" value="{$clsCruiseProperty->getSymbol($cruise_property_id)}">
                </div>
            </div>
            {else}
                {if $type != 'CruiseMaterial'}
                <div class="row-span">
                    <div class="fieldlabel" style="text-align:left"><strong>{$core->get_Lang('Image')}</strong></div>
                    <div class="fieldarea">
                        <img class="isoman_img_pop" id="isoman_show_image" src="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}" style="width:32px; height:32px"/>
                        <input type="hidden" id="isoman_hidden_image" value="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}">
                        <input class="fl ml10 text_32 border_aaa" style="width:70% !important;display:inline-block" type="text" id="isoman_url_image" name="image" value="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="{$clsCruiseProperty->getOneField('image', $cruise_property_id)}" isoman_name="image"><img src="{URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel  text-left"><strong>{$core->get_Lang('Short text')}</strong></div>
                    <div class="fieldarea">
                        <textarea id="textarea_intro_editor" class="textarea_intro_editor" name="intro" rows="5" style="width:100%">{$clsCruiseProperty->getIntro($cruise_property_id)}</textarea>
                    </div>
                </div>
                {/if}
            {/if}
        </div>
        {/foreach}
    </div>
   
</form>
<div class="modal-footer"> 
    <button class="btn btn-primary clickSubmitProperty" cruise_property_id="{$cruise_property_id}" type="{$type}">
        <i class="icon-ok icon-white"></i> <span>{$core->get_Lang('save')}</span>
    </button> 
    <button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true">
        <i class="icon-retweet icon-white"></i> <span>{$core->get_Lang('close')}</span>
    </button> 
</div>
{literal}
<style>
    a{
        color: #105289 !important;
    }
</style>
{/literal}