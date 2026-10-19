{if $cartSessionHotel}
<label class="TitleBookingFinal">{$core->get_Lang('Hotels')}</label>
{foreach from=$cartSessionHotel key=k item=item name=item}
{assign var=title_hotel value=$clsHotel->getTitle($k)}
{assign var=link_hotel value=$clsHotel->getLink($item.hotel_id)}
<div class="tour_item_book mb10">
	<div class="info_tour_item_book pd0">
		<div class="info_padding">
			<h3 class="title mb10">{$smarty.foreach.item.iteration}. {$title_hotel}</h3>
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<p class="departure_in4"><b>{$core->get_Lang('Check In')}  </b></p>
					<p class="departure">{$clsISO->converTimeToText5($item.check_in)}</p>
				</div>
				<div class="col-md-6 col-sm-6">
					 <p> <b>{$core->get_Lang('Check Out')} </b> </p>
					 <p class="departure">{$clsISO->converTimeToText5($item.check_out)}</span>
				</div>
			</div>
			<div class="line"></div>
		</div>
		{if $_LANG_ID eq 'vn'}
		<table class="table_booking_price">
			<tbody>
				{foreach from=$item.room key=hotel_room_id item=value name=room}
				<tr>
					<td class="td1">{$value.number_room} {$clsHotelRoom->getTitle($hotel_room_id)}</td>
					<td class="td2">{$clsISO->formatPrice($value.totalprice*$value.number_room)} {$clsISO->getShortRate()}</td>
				</tr>
				{/foreach}
				{if $item.promotion >0}
				<tr class="promotion">
					<td class="td1">{$core->get_Lang('Discount')}</td>
					<td class="td2">-{$clsISO->formatPrice($item.totalPricePromotionHotel)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Hotel Price')}</td>
					<td class="td2 td_total_price">{$clsISO->formatPrice($item.totalpriceRoom)} {$clsISO->getShortRate()}</td>
				</tr>
			</tbody>
		</table>
		{else}
		<table class="table_booking_price">
			<tbody>
				{foreach from=$item.room key=hotel_room_id item=value name=room}
				<tr>
					<td class="td1">{$value.number_room} {$clsHotelRoom->getTitle($hotel_room_id)}</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($value.totalprice*$value.number_room)}</td>
				</tr>
				{/foreach}
				{if $item.promotion >0}
				<tr class="promotion">
					<td class="td1">{$core->get_Lang('Discount')}</td>
					<td class="td2">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalPricePromotionHotel)} </td>
				</tr>
				{/if}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Hotel Price')}</td>
					<td class="td2 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceRoom)}</td>
				</tr>
			</tbody>
		</table>
		{/if}
	</div>
</div>
{/foreach}
{/if}