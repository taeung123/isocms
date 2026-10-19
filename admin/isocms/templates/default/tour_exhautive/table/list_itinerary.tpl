{if !empty($txt_warning)} 
<p style="font-size: 14px; color: #856404; background: #fff3cd; border: #ffeeba; padding: 5px; line-height: 150%;"><i class="fa-solid fa-triangle-exclamation"></i> {$core->get_Lang('The dates in the itinerary have not yet been entered')}: {$txt_warning}</p>
{/if}
<table class="full-width tbl-grid table-striped table_responsive" cellspacing="0">
    <thead>
    <tr>
        {if $tourItem.duration_type eq 0}
        <th class="gridheader" style="width:100px"><strong>{$core->get_Lang('day')}</strong></th>
        {/if}
        <th class="gridheader name_responsive name_responsive2" style="text-align:left"><strong>{$core->get_Lang('Title')}</strong></th>
        <th class="gridheader hiden_responsive" style="text-align:left; width: 190px;"><strong>{$core->get_Lang('Meals')}</strong></th>
        <th class="gridheader hiden_responsive" style="width: 50px"></th>
    </tr>
    </thead>
    <tbody >
        {if !empty($lstItem)} 
            {foreach from=$lstItem key=key item=item}
                <tr id="order_{$item.tour_itinerary_id}" day2="{$item.day2}" class="{if $key%2 == 0}row1{else}row2{/if}">
                    {if $tourItem.duration_type == 0}
                        {if $tourItem.number_day == 1 && $tourItem.number_night <= 1}
                            <th class="day"><span>{$core->get_Lang('Full day')}</span></th> 
                        {elseif $item.day==0} 
                            <th class="day index">{$core->get_Lang('Setting')}</th>
                        {else} 
                            <th class="day index"><span>{$key + 1}</span></th>
                        {/if}
                    {/if}
                    <td class="name_service">
                        <div class="d-flex">
                            {if $item.is_show_image == 1} 
                                <img src="{$clsISO->tripslashImage($item.image, 60, 40)}" style="margin-right:5px" />
                            {/if}
                            {if !empty({$item.txt})}{$item.txt} - {/if}{$item.title}
                        </div>
                        <div class="clearfix mt5"></div> 
                        {if $clsISO->getCheckActiveModulePackage($package_id, 'tour', 'hotel', 'customize') && $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default') && $clsTourItinerary->getItineraryHotel($tour_id, $item.tour_itinerary_id, 1)} 
                            <strong class="color_r">{$core->get_Lang('hotels')}</strong>: {$clsTourItinerary->getItineraryHotel($tour_id, $item.tour_itinerary_id)}
                        {/if}
                        <button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
                    </td>
                    <td data-title="{$core->get_Lang('Meals')}" class="text-left block_responsive border_top_responsive">{$clsTourItinerary->getMeal($item.tour_itinerary_id, 1)}</td>
                    <td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">
                        <div class="btn-group">
                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item clickEditItinerary" 
                                    title="{$core->get_Lang('edit')}" 
                                    href="#" 
                                    data="{$item.tour_itinerary_id}">
                                        <i class="icon-edit"></i> {$core->get_Lang('edit')}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item clickDeleteItinerary" 
                                    title="{$core->get_Lang('delete')}" 
                                    href="#" 
                                    data="{$item.tour_itinerary_id}">
                                        <i class="icon-remove"></i> {$core->get_Lang('delete')}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {/foreach}
        {else} 
            <tr>
                <td colspan="12">
                    <div class="message" style="text-align:center">
                        <span>{$core->get_Lang('no record found in here, please use')}</span>
                        <a style="text-decoration:underline" href="javascript:void(0);" id="clickToAddItinerary">{$core->get_Lang('Add New')}</a>
                    </div>
                </td>
            </tr>
        {/if}
    </tbody>
</table>
