{if $cartSessionCruise}
{assign var=title value=$clsCruise->getTitle($cartSessionCruise.cruise_id)}
{assign var=link value=$clsCruise->getLink($cartSessionCruise.cruise_id)}
{assign var=end_date value=$clsCruiseItinerary->getTextEndDate($cartSessionCruise.departure_date,$cartSessionCruise.cruise_itinerary_id)}
{assign var=list_cabin_check value = $cartSessionCruise.compare_price}
{assign var=total_number_service value = $cartSessionCruise.total_number_service}
{assign var=list_service value = $cartSessionCruise.cruise_service}

<div class="infor_tour bg_fff relative">
    <a href="javascript:void(0);" data-type="Cruise" class="delete_service" key="{$key}" title="{$core->get_Lang('Delete serivce')}"><i class="fa fa-times"></i></a>
    <h3 class="title text_bold mb15 size24 size20_mb"><a href="{$link}" title="{$title}">{$title}</a></h3>
    <p id="{$cartSessionCruise.cruise_itinerary_id}">{$core->get_Lang('Itinerary')}: <span class="text_bold">{$clsCruiseItinerary->getDuration($cartSessionCruise.cruise_itinerary_id)}</span></p>
    <div class="row d-flex">
		<div class="col-md-5 col-sm-5">
			<p class="mb05"><strong>{$core->get_Lang('Departing')}  </strong></p>
			<p class="departure_date mb0">{$clsISO->converTimeToText5($cartSessionCruise.departure_date)}</p>
		</div>
		<div class="col-md-1 col-sm-1 icon_arrow">

		</div>
		<div class="col-md-6 col-sm-6">
			<p class="mb05"><strong>{$core->get_Lang('End')} </strong></p>
			<p class="departure_date mb0">{$clsISO->converTimeToText5($end_date)}</p>
		</div>
	</div>
   	<div class="more_infor">
        
        

        {foreach from=$array_bed item=item name=item key=key}
        <div class="box_item_room_cabin">
            <div class="row item_room_cabin d-flex">
                <div class="col-md-6 col-sm-6">
                    <div class="d-flex">
                        <div class="box_left">
                            <label for="" class="lbl_cabin">{$core->get_Lang('Cabin')} {$smarty.foreach.item.iteration}:</label>
                        </div>
                        <div class="box_right">
                            <span>{$item.bed_type} </span>
                        </div>
                    </div>												
                </div>	
            </div>
            <div class="row item_room_cabin d-flex">
                <div class="col-md-6 col-sm-6">
                    <div class="d-flex">
                        <div class="box_left"></div>
                        <div class="box_right">
                            <span>{$item.number_adult} {$core->get_Lang('Adult')}</span>
                        </div>						
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <span>{$item.txt_price_adult}</span>
                </div>
            </div>
            {if $cartSessionCruise.number_child gt 0}
            {foreach from=$list_cabin_check[i]->lst_child item=lst_child key=key}
            <div class="row item_room_cabin d-flex">
                <div class="col-md-6 col-sm-1">
                    <div class="d-flex">
                        <div class="box_left"></div>
                        <div class="box_right">
                            <span>{$lst_child->number_child} {$core->get_Lang('Children')} ({$lst_child->str_age} {$core->get_Lang('age')})</span>
                        </div>						
                    </div>						
                </div>
                <div class="col-md-6 col-sm-6">
                    <span>{$lst_child->txt_price_child}</span>
                </div>
            </div>
            {/foreach}
            {/if}
            {if $item.is_extra_bed==1}
            <div class="row item_room_cabin d-flex">
                <div class="col-md-6 col-sm-6">
                    <div class="d-flex">
                        <div class="box_left"></div>
                        <div class="box_right">
                            <span>{$core->get_Lang('Extra Bed')} </span>
                        </div>						
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <span>{$item.txt_price_extra_bed}</span>
                </div>
            </div>
            {/if}
 
        </div>
		{/foreach}
        {if $total_number_service}
        <div class="box_service">
            <p class="mb05"><strong>{$core->get_Lang('Addon services')}  </strong></p>
            {foreach from=$list_service item=item key=key}
            <div class="item_service d-flex justify-content-between">
                <div class="title_service">
                        {$item.number} x {$clsCruiseService->getTitle($item.cruise_service_id)}
                </div>	
                <div class="price_service">
                    {if $_LANG_ID eq 'vn'}
                        {$clsISO->formatPriceText($item.price)} {$clsISO->getRate()}
                    {else}
                        {$clsISO->getRate()} {$clsISO->formatPriceText($item.price)}
                    {/if} 
                </div>
            </div>
            {/foreach}
        </div>
        {/if}
	</div>
</div>
{/if}