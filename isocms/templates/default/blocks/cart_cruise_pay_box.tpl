{if $cartSessionCruise}
<label class="TitleBookingFinal">{$core->get_Lang('Cruise')}</label>
{foreach from=$cartSessionCruise key=k item=item name=item}
{assign var=title_cruise value=$clsCruiseItinerary->getTitleDay($k)}
{assign var=link_cruise value=$clsCruise->getLink($item.cruise_id)}
<div class="tour_item_book mb10">
	<div class="info_tour_item_book pd0">
		<div class="info_padding">
			<h3 class="title mb10">{$smarty.foreach.item.iteration}. {$title_cruise}</h3>
			<p class="departure_in4"><b>{$core->get_Lang('Depart')}</b> {$clsISO->converTimeToText5($item.departure_date)}</p>
			<div class="line"></div>
		</div>
		{if $_LANG_ID eq 'vn'}
		<table class="table_booking_price">
			<tbody>
				{foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
				<tr>
					<td class="td1">{$clsCruiseCabin->getTitle($cruise_cabin_id)}({$value.number_cabin})</td>
					<td class="td2">{$clsISO->formatPrice($value.totalprice)} {$clsISO->getShortRate()}</td>
				</tr>
				{/foreach}
				{if $item.promotion >0}
				<tr class="promotion">
					<td class="td1">{$core->get_Lang('Discount')}</td>
					<td class="td2">-{$clsISO->formatPrice($item.totalPricePromotionCruise)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Cruise Price')}</td>
					<td class="td2 td_total_price">{$clsISO->formatPrice($item.totalpriceCabin)} {$clsISO->getShortRate()}</td>
				</tr>
			</tbody>
		</table>
		{else}
		<table class="table_booking_price">
			<tbody>
				{foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
				<tr>
					<td class="td1">{$clsCruiseCabin->getTitle($cruise_cabin_id)}({$value.number_cabin})</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($value.totalprice)}</td>
				</tr>
				{/foreach}
				{if $item.promotion >0}
				<tr class="promotion">
					<td class="td1">{$core->get_Lang('Discount')}</td>
					<td class="td2">-{$clsISO->formatPrice($item.totalPricePromotionCruise)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Cruise Price')}</td>
					<td class="td2 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceCabin)}</td>
				</tr>
			</tbody>
		</table>
		{/if}
	</div>
</div>
{/foreach}
{/if}