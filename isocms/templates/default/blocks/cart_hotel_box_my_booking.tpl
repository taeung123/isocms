{assign var=cartSessionHotel value=$clsBooking->getCartStoreBooking($lstBooking[bk].booking_id,'HOTEL')}
{if $cartSessionHotel}
<label class="titleBoxContent">{$core->get_Lang('Hotels')}</label>
{foreach from=$cartSessionHotel key=k item=item name=item}
{assign var=title_hotel value=$clsHotel->getTitle($k)}
{assign var=link_cruise value=$clsHotel->getLink($item.hotel_id)}
<div class="tour_item hotel_item item_cart mb30">
	<div class="info_tour border_bottom_959595">
		<div class="body_hotel {$deviceType}">
			<div class="body_left">
				<span class="number_iteration">{$smarty.foreach.item.iteration}</span>
			</div>
			<div class="body_right">
				<h3 class="title mb0"><a href="{$link_cruise}" title="{$title_hotel}">{$title_hotel} <img class="star" height="13" src="{$clsHotel->getHotelStar($item.hotel_id)}" alt="star" style="width: auto" /></a></h3>
				<div class="address_hotel mb10"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($item.hotel_id)}</div>
				<div class="departure_in4">
					<div class="depart_at">
						<p class="mb0"><b>{$core->get_Lang('Check In')}</b>
						</p> 
						<p class="mb10">
						<span class="start_date">{$clsISO->converTimeToText5($item.check_in)}</span></p> 
						 <span class="icon_cart"></span>
					</div>
					<div class="ends_at">
						<p class="mb0"><b>{$core->get_Lang('Check Out')}</b> 
						</p>
						<p class="mb10"><span class="end_date">{$clsISO->converTimeToText5($item.check_out)}</span></p>
					</div>
				</div>
				{assign var=str_number_night value=$item.check_out-$item.check_in}
				<div class="number_night">
					{if $deviceType ne 'phone'}
					<p class="text_bold mb0">{$core->get_Lang('Number Night')}</p>
					{if $str_number_night}
					<p>{$str_number_night/86400}</p>
					{else}
					<p>1</p>
					{/if}
					{else}
					<p class="text_bold mb0">{$core->get_Lang('Number Night')} {if $str_number_night}
					<span>{$str_number_night/86400}</span>
					{else}
					<span>1</span>
					{/if}
					</p>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class="info_price">
		{assign var=rowspan value=$item.room|@count}
		{if $_LANG_ID eq 'vn'}
		<table class="table_price">
			<tbody>
				<tr class="tr_label"><td class="td1" rowspan="{$rowspan+1}">{$core->get_Lang('Room')}</td></tr>
				{foreach from=$item.room key=hotel_room_id item=value name=cabin}
				<tr>
					
					<td class="td2">{$value.number_room} {$clsHotelRoom->getTitle($hotel_room_id)}</td>
					<td class="td3 hidden_phone">x {$clsISO->formatPrice($value.totalprice)} {$clsISO->getShortRate()}</td>
					<td class="td4">{$clsISO->formatPrice($value.totalprice*$value.number_room)} {$clsISO->getShortRate()}</td>
				</tr>
				{assign var=totalpriceroom value=$totalpriceroom+$value.totalprice*$value.number_room}
				{/foreach}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Total')}</td>
					<td class="td2 hidden_phone"></td>
					<td class="td3 hidden_phone"></td>
					<td class="td4 td_total_price">{$clsISO->formatPrice($totalpriceroom)} {$clsISO->getShortRate()}</td>
					{assign var=totalpriceroom value=0}
				</tr>
			</tbody>
		</table>
		{else}
		<table class="table_price">
			<tbody>
				<tr class="tr_label"><td class="td1" rowspan="{$rowspan+1}">{$core->get_Lang('Room')}</td></tr>
				{foreach from=$item.room key=hotel_room_id item=value name=cabin}
				<tr>
					
					<td class="td2">{$value.number_room} {$clsHotelRoom->getTitle($hotel_room_id)}</td>
					<td class="td3">{$clsISO->getShortRate()}{$clsISO->formatPrice($value.totalprice*$value.number_room)}</td>
				</tr>
				{assign var=totalpriceroom value=$totalpriceroom+$value.totalprice*$value.number_room}
				{/foreach}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Total')}</td>
					<td class="td2 hidden_phone"></td>
					<td class="td3 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalpriceroom)}</td>
					{assign var=totalpriceroom value=0}
				</tr>
			</tbody>
		</table>
		{/if}
		{*<div class="info_function">
			<div class="info_function_left">
				<a  class="edit" href="{$clsHotel->getLink($item.hotel_id)}" title="{$core->get_Lang('Edit')}">{$core->get_Lang('Edit')}</a>
				<a class="remove ajvCart" data-tp="DEL_HOTEL" data-table_id="{$k}" href="javascript:void(0);" title="{$core->get_Lang('Delete')}">{$core->get_Lang('Delete')}</a>
			</div>
		</div>*}
	</div>
</div>
{/foreach}
{/if}
