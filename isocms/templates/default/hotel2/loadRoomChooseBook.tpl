<div class="info_room_box">
	<h3 class="cruise_name">{$clsHotel->getTitle($hotel_id)}</h3>
	<p class="departure_date"><span class="text_left">{$core->get_Lang('Check In')}</span><span class="text_right">{$clsISO->converTimeToText5($str_check_in)}</span></p>
	<p class="departure_date"><span class="text_left">{$core->get_Lang('Check Out')}</span><span class="text_right">{$clsISO->converTimeToText5($str_check_out)}</span></p>
	<p class="departure_date"><span class="text_left">{$core->get_Lang('Traveler')}</span><span class="text_right">{$number_adult} {$core->get_Lang('Adults')}{if $number_child},{$number_child} {$core->get_Lang('Child')} {/if}</span></p>
	{if $listRoom}
	<div class="list_room">
		<p class="title_box">{$core->get_Lang('Room Information')}</p>
		{foreach from=$listRoom item=item name=item}
		{assign var=hotel_room_id value=$item.hotel_room_id}
		<div class="room_choose_item">
			<div class="col_name">
				<h4><a class="delete_room" data-check_in="{$check_in}" data-check_out="{$check_out}" data-hotel_id="{$hotel_id}" data-number_adult="{$number_adult}" data-number_child="{$number_child}" data-hotel_room_id="{$hotel_room_id}"><i class="icon_info_room icon_del"></i></a> <select data-hotel_id="{$hotel_id}" id="hotel_room_{$hotel_room_id}" data-hotel_room_id="{$hotel_room_id}" data-check_in="{$check_in}" data-check_out="{$check_out}" data-number_adult="{$number_adult}" data-number_child="{$number_child}" name="number_room" data-totalprice="{$item.totalprice}" class="number_room">
					{section name=i loop=$max_room}
						<option value="{$smarty.section.i.iteration}" {if $smarty.section.i.iteration eq $item.number_room}selected{/if}>{$smarty.section.i.iteration}</option>
					{/section}
				</select>  {$clsHotelRoom->getTitle($hotel_room_id)}</h4>
				<p class="size12 mb0">{$core->get_Lang('Giá cho')} {$number_night} {$core->get_Lang('night')}</p>
			</div>
			<div class="col_price">{$clsISO->priceFormat($item.totalprice)} {$clsISO->getShortRate()}</div>
		</div>
		{/foreach}
		{if $promotion}
		<div class="room_choose_item promotion">
			<div class="col_name">
				<h4>Giảm giá</h4>
			</div>
			<div class="col_price">-{$clsISO->priceFormat($totalprice_promotion)} {$clsISO->getShortRate()}</div>
		</div>
		{/if}
	</div>
	<div class="total_price_room">
		<div class="col_label">{$core->get_Lang('Total')}:</div>
		<div class="col_price">
			<p class="price">{$clsISO->priceFormat($totalprice_new)} {$clsISO->getShortRate()}</p>
			<p class="text">{$core->get_Lang('Giá trên đã bao gồm VAT')}</p>
		</div>
	</div>
	{/if}
</div>
{if $listRoom}
{if $clsISO->getCheckActiveModulePackage($package_id,'booking','booking_hotel','default')}
<div class="btn_book">
	<a class="btn_main" data-hotel_id="{$hotel_id}" id="book_now_room" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
</div>
{else}
<div class="btn_book">
	<a class="btn_main" data-hotel_id="{$hotel_id}" id="book_now_room" title="{$core->get_Lang('Contact')}">{$core->get_Lang('Contact')}</a>
</div>
{/if}
{/if}