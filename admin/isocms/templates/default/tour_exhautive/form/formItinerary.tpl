<div class="headPop">
    <a class="closeEv close_pop" href="javascript:void();" title="{$core->get_Lang('close')}"></a>
    <h3>
        {if $tour_itinerary_id == 0}{$core->get_Lang('Add Tour Itinerary')}{else}{$core->get_Lang('Edit Tour Itinerary')} - [ID #{$tour_id}]{/if}
    </h3>
</div>
<form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
    <div class="wrap">
        <div class="fr full_width_991">
            <div class="photobox image center_991">
                <img src="{$oneItem.image|default:''}" id="isoman_show_image_itinerary" />
                <input type="hidden" id="isoman_hidden_image_itinerary" name="isoman_url_image" value="{$oneItem.image|default:''}" />
                <a href="javascript:void(0);" title="{$core->get_Lang('Change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_itinerary" isoman_val="{$oneItem.image|default:''}" isoman_name="image">
                    <i class="iso-edit"></i>
                </a>
                {if !empty($oneItem.image)} 
                    <a pvalTable="{$tour_itinerary_id}" clsTable="TourItinerary" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
                {/if}
            </div>
            <div class="wrap mt10 boxShowImages">
                <p class="text-center"><strong>{$core->get_Lang('Image Size')} (WxH=204x134)</strong></p>
                <p class="text-center">
                    <label>
                        <input type="radio" class="margin_0" name="is_show_image" value="0" checked="checked" /> OFF
                    </label>
                    <label>
                        <input type="radio" class="margin_0" name="is_show_image" value="1" {if isset($oneItem['is_show_image']) && $oneItem['is_show_image'] == 1}checked{/if} /> ON
                    </label>
                </p>
            </div>
        </div>
        <div class="fl full_width_991" style="width:80%">
            <div class="row-span">
                {if $tourItem.duration_type == 1} 
                    <div class="fieldlabel bold text-right text_left_767">
                        <strong>{$core->get_Lang('Itinerary name')}</strong> <span class="color_r">*</span>
                    </div>
                {else} 
                    <div class="fieldlabel bold text-right text_left_767"><strong>{$core->get_Lang('day')}</strong> <span class="color_r">*</span></div>
                {/if}
                <div class="fieldarea">
                    {if $tourItem.duration_type ==1} 
                        <input type="text" name="title" class="text_32 border_aaa fontLarge full-width title_capitalize" id="title" value="{$oneItem.title}"  />
                    {else} 
                        <input class="text_32 border_aaa required iso_itinerary_day" style="width:60px;float:left" value="{$itinerary_day}" name="day" min="{$itinerary_day}" max="{$max_day}" type="number">
                        <span style="width:20px; display:inline-block; text-align:center; float:left; line-height:32px"> -> </span>
                        <input class="text_32 border_aaa required iso_itinerary_day2" style="width:60px;float:left" value="{$itinerary_day2}" name="day2" type="number">
                        <input type="text" name="title" class="text_32 border_aaa fontLarge titleDay title_capitalize full_width_767 mt10_767" id="title" min="{$itinerary_day2}" max="{$max_day}" value="{$oneItem.title|default:''}"  />
                    {/if}
                </div>
            </div>
            <div class="row-span" style="display:none">
                <div class="fieldlabel bold text-right text_left_767"><span class="color_r">*{$core->get_Lang('daytrip')}</span></div>
                <div class="fieldarea">
                    <input type="text" name="date_title" class="text full fontLarge " id="date_title" value="{$oneItem.date_title}" />
                </div>
            </div>
            {if !empty($clsConfiguration->getValue('SiteTourAPI'))} 
                <div class="row-span">
                    <div class="fieldlabel bold text-right text_left_767" style="text-align:right">
                        <strong>{$core->get_Lang('meal')}</strong> <span class="color_r">*</span>
                    </div>
                    <div class="fieldarea">
                        {$clsTourItinerary->getMeal($tour_itinerary_id, 1)}
                    </div>
                </div>
            {else} 
                {if !empty($lstMeal)} 
                    <div class="row-span">
                        <div class="fieldlabel bold text-right text_left_767" style="text-align:right">
                            <strong>{$core->get_Lang('meal')}</strong> <span class="color_r">*</span> 
                            <input type="checkbox" class="checkall_checkbox" group="meal" title="{$core->get_Lang('selectall')}" style="cursor:pointer;" />
                        </div>
                        <div class="fieldarea">
                            <div style="border:1px solid #d7d7d7;width:100%;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;">
                                {foreach from=$lstMeal key=key item=item} 
                                    <label class="mr20">
                                        <input type="checkbox" {if $clsTourItinerary->checkMealExist($item[$clsTourProperty->pkey], $tour_itinerary_id)}checked{/if} name="meal[]" class="chk_Meal checkitem_checkbox" group="meal" value="{$item.tour_property_id}"> {$item.title}
                                    </label>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                {/if}
            {/if}
            {if $clsISO->getCheckActiveModulePackage($package_id, 'property', 'transport', 'default')} 
                {if !empty($lstTransport)} 
                    <div class="row-span">
                        <div class="fieldlabel bold text-right text_left_767" style="text-align:right">
                            <strong>{$core->get_Lang('transport')}</strong> <span class="color_r">*</span> 
                            <input type="checkbox" class="checkall_checkbox" group="transport" title="{$core->get_Lang('selectall')}" style="cursor:pointer;" />
                        </div>
                        <div class="fieldarea">
                            <div style="border:1px solid #d7d7d7;padding:3px 10px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px; max-height:56px; overflow:auto">
                            {foreach from=$lstTransport key=key item=item} 
                                <label class="mr20">
                                    <input type="checkbox" name="transport[]" {if $tour_itinerary_id > 0 && $clsTourItinerary->checkTransportExist($item.transport_id, $tour_itinerary_id)}checked{/if} class="checkitem_checkbox chk_Transport" group="transport" value="{$item.transport_id}">
                                    {$item.title}
                                </label>
                            {/foreach}
                            </div>
                        </div>
                    </div>
                {/if}
            {/if}
            <div class="row-span">
                <div class="fieldlabel" style="text-align:right;font-weight:700">{$core->get_Lang('Short text')}</div>
                <div class="fieldarea">
                    <textarea rows="5" cols="255" id="textarea_itinerary_content_editor_{$now}" class="textarea_itinerary_content_editor" style="width:100%">{$oneItem.content}</textarea>
                </div>
            </div>
            {if $tour_itinerary_id > 0 && $clsISO->getCheckActiveModulePackage($package_id, 'tour', 'hotel', 'customize') && $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default')}
            <div class="row-span" style="border:1px dashed #c00000; padding:1%; width:100%;">
                <div class="fieldlabel" style="font-weight:700">
                    {$core->get_Lang('Accommodation')} 
                    <button type="button" tour_id="{$tour_id}" tour_itinerary_id="{$tour_itinerary_id}" tour_hotel_id="0" class="iso-button-small ajaxOpenChoiceHotel">...</button></div>
                <div class="fieldarea">
                    <div id="lstHotel"></div>
                </div>
            </div>
            {/if}
        </div>
    </div>
</form>
<div class="modal-footer">
    <button type="submit" tour_itinerary_id="{$tour_itinerary_id}" class="btn btn-primary btnSaveTourItinerary">
        <i class="icon-ok icon-white"></i> <span>{$core->get_Lang('save')}</span>
    </button>
    <button type="reset" class="btn btn-warning close_pop">
        <i class="icon-retweet icon-white"></i> <span>{$core->get_Lang('close')}</span>
    </button>
</div>
