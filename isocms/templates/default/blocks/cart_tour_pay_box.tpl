{if $cartSessionService}
<label class="TitleBookingFinal">{$core->get_Lang('Tour')}</label>
{foreach from=$cartSessionService item=item name=item}
	{assign var=tour_id value=$item.tour_id_z}
	{assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z)}
	{assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
	{assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
	{assign var=link_package value=$clsTour->getLink($item.tour_id_z)}
	{if $tour_id}
	<div class="tour_item_book mb10">
		<div class="info_tour_item_book pd0">
			<div class="info_padding">
				<h3 class="title mb10">{$smarty.foreach.item.iteration}. {$title_package}({$clsTour->getLTripDuration($tour_id)})</h3>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<p class="departure_in4"><b>{$core->get_Lang('Depart at')}  </b></p>
						<p class="departure">{$clsTour->getListDeparturePoint($tour_id)}</p>
						<p class="start_date">{$clsISO->converTimeToText5($departure_date)}</p>
					</div>
					<div class="col-md-6 col-sm-6">
						 <p> <b>{$core->get_Lang('Ends at')} </b> </p>
						 <p class="departure">{$clsTour->getEndCityAround($tour_id,1)}</p>
						 <span class="end_date">{$clsISO->converTimeToText5($end_date)}</span>
					</div>
				</div>
				<div class="line"></div>
			</div>
			{assign var=adult_visitor value="national_visitor"|cat:$adult_type_id}
			{assign var=child_visitor value="national_visitor"|cat:$child_type_id}
			{assign var=infant_visitor value="national_visitor"|cat:$infant_type_id}
			{assign var=adult_price value="people_price"|cat:$adult_type_id}
			{assign var=child_price value="people_price"|cat:$child_type_id}
			{assign var=infant_price value="people_price"|cat:$infant_type_id}

			{assign var=number_adult value=$item.number_adults_z}
			{assign var=number_child value=$item.number_child_z}
			{assign var=number_infant value=$item.number_infants_z}

			{assign var=price_adult value=$item.total_price_adults}
			{assign var=price_child value=$item.total_price_child}
			{assign var=price_infant value=$item.total_price_infants}
			{assign var=total_price_of_guests value=$price_adult+$price_child+$price_infant}
			{assign var=number_of_guests value=$number_adult+$number_child}
			{assign var=tour_class_id value=$item.tour__class}
			{if $_LANG_ID eq 'vn'}
			
			<table class="table_booking_price">
				<tbody>
					<tr>
						<td class="td1">{$core->get_Lang('Type of tour')}</td>
						<td class="td2">{$clsTourOption->getTitle($tour_class_id)}</td>
					</tr>
					
					<tr>
						<td class="td1">{$number_adult} {$core->get_Lang('Adults')}{if $number_child gt 0}, {$number_child} {$core->get_Lang('Child')}{/if}{if $number_infant gt 0}, {$number_infant} {$core->get_Lang('Infant')}{/if}</td>
						<td class="td2">{$clsISO->formatPrice($total_price_of_guests)} {$clsISO->getShortRate()}</td>
					</tr>
					{if $item.promotion_z >0}
					<tr class="promotion">
						<td class="td1">{$core->get_Lang('Discount')}</td>
						<td class="td2">-{$clsISO->formatPrice($item.price_promotion)} {$clsISO->getShortRate()}</td>
					</tr>
					{/if}
					{if $item.number_addon}
					{foreach from=$item.number_addon key=k item=v}
					{if $v gt 0}
					<tr class="tr_addon">
						<td class="td1">{$v} {$clsAddOnService->getTitle($k)}</td>
						<td class="td2">
							{assign var=price_service value=$v*$clsAddOnService->getStrPrice($k)}
							{if $clsAddOnService->getExtra($k) eq '0'}
							0 
							{elseif $clsAddOnService->getExtra($k) eq '1'}
							{$clsISO->formatPrice($price_service)} 
							{else}
							{$clsISO->formatPrice($price_service)} 
							{/if}
							{$clsISO->getShortRate()}
						</td>
					</tr>
					{/if}
					{/foreach}
					{/if}
					<tr class="tr_total">
						<td class="td1">{$core->get_Lang('Total Price')}</td>
						<td class="td2 td_total_price">{$clsISO->formatPrice($item.total_price_z)} {$clsISO->getShortRate()}</td>
					</tr>
					{if $item.price_deposit}
					<tr class="tr_deposit">
						<td class="td1">{$core->get_Lang('Deposit')} {$item.deposit} (%)</td>
						<td class="td2 td_total_price">{$clsISO->formatPrice($item.price_deposit)} {$clsISO->getShortRate()}</td>
					</tr>
					{/if}
				</tbody>
			</table>
			{else}
			<table class="table_booking_price">
				<tbody>
					<tr>
						<td class="td1">{$core->get_Lang('Type of tour')}</td>
						<td class="td2">{$clsTourOption->getTitle($tour_class_id)}</td>
					</tr>
					
					<tr>
						<td class="td1">{$number_adult} {$core->get_Lang('Adults')}{if $number_child gt 0}, {$number_child} {$core->get_Lang('Child')}{/if}{if $number_infant gt 0}, {$number_infant} {$core->get_Lang('Infant')}{/if}</td>
						<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($total_price_of_guests)}</td>
					</tr>
					{if $item.promotion_z >0}
					<tr class="promotion">
						<td class="td1">{$core->get_Lang('Discount')}</td>
						<td class="td2">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_promotion)}</td>
					</tr>
					{/if}
					{if $item.number_addon}
					{foreach from=$item.number_addon key=k item=v}
					{if $v gt 0}
					<tr class="tr_addon">
						<td class="td1">{$v} {$clsAddOnService->getTitle($k)}</td>
						<td class="td2">
							{assign var=price_service value=$v*$clsAddOnService->getStrPrice($k)}
							{$clsISO->getShortRate()}
							{if $clsAddOnService->getExtra($k) eq '0'}
							0 
							{elseif $clsAddOnService->getExtra($k) eq '1'}
							{$clsISO->formatPrice($price_service)} 
							{else}
							{$clsISO->formatPrice($price_service)} 
							{/if}
						</td>
					</tr>
					{/if}
					{/foreach}
					{/if}
					<tr class="tr_total">
						<td class="td1">{$core->get_Lang('Total Price')}</td>
						<td class="td2 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($item.total_price_z)}</td>
					</tr>
					{if $item.price_deposit}
					<tr class="tr_deposit">
						<td class="td1">{$core->get_Lang('Deposit')} {$item.deposit} (%)</td>
						<td class="td2 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_deposit)}</td>
					</tr>
					{/if}
				</tbody>
			</table>
			{/if}
		</div>
	</div>
	{/if}
{/foreach}
{/if}