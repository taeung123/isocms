{assign var=cart_store_tour value=$clsBooking->getCartStoreBooking($lstBooking[bk].booking_id,'TOUR')}
{if $cart_store_tour}
<label class="titleBoxContent">{$core->get_Lang('Tour')}</label>
{foreach from=$cart_store_tour item=item name=item}
	{assign var=tour_id value=$item.tour_id_z}
	{if $tour_id}
	{assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z)}
	{assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
	{assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
	{assign var=link_package value=$clsTour->getLink($item.tour_id_z)}
	<div class="tour_item mb30">
		<div class="info_tour border_bottom_959595">
			<div class="body_hotel {$deviceType}">
				<div class="body_left">
					<span class="number_iteration">{$smarty.foreach.item.iteration}</span>
				</div>
				<div class="body_right">
					<h3 class="title mb10"><a href="{$link_package}" title="{$title_package}">{$title_package}</a></h3>
					<p class="duration">{$clsTour->getLTripDuration($tour_id)}</p>
					<div class="departure_in4">
						<div class="depart_at">
							<p class="mb0"><b>{$core->get_Lang('Depart at')} {$clsTour->getListDeparturePoint($tour_id)} </b>
							</p> 
							<p>
							<span class="start_date">{$clsISO->converTimeToText5($departure_date)}</span></p> 
							 <span class="icon_cart"></span>
						</div>
						<div class="ends_at">
							<p class="mb0"><b>{$core->get_Lang('Ends at')} {$clsTour->getEndCityAround($tour_id,1)} </b> 
							</p>
							<p><span class="end_date">{$clsISO->converTimeToText5($end_date)}</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		{*{assign var=adult_visitor value=national_visitor$adult_type_id}
		{assign var=child_visitor value=national_visitor$child_type_id}
		{assign var=infant_visitor value=national_visitor$infant_type_id}
		{assign var=adult_price value=people_price$adult_type_id}
		{assign var=child_price value=people_price$child_type_id}
		{assign var=infant_price value=people_price$infant_type_id}*}

		{assign var=number_adult value=$item.number_adults_z}
		{assign var=number_child value=$item.number_child_z}
		{assign var=number_infant value=$item.number_infants_z}

		{assign var=price_adult value=$item.total_price_adults}
		{assign var=price_child value=$item.total_price_child}
		{assign var=price_infant value=$item.total_price_infants}
		{assign var=number_of_guests value=$number_adult+$number_child}
		
		{assign var=row_traveler value=2}
		{if $number_child gt 0}
		{assign var=row_traveler value=$row_traveler+1}
		{/if}
		{if $number_infant gt 0}
		{assign var=row_traveler value=$row_traveler+1}
		{/if}
		{if $item.promotion_z gt 0}
		{assign var=row_traveler value=$row_traveler+1}
		{/if}
		<div class="info_price">
			{if $_LANG_ID eq 'vn'}
			<table class="table_price">
				<tbody>
					<tr class="tr_label"><td class="td1" rowspan="{$row_traveler}">{$core->get_Lang('Traveler')}</td></tr>
					
					<tr>

						<td class="td2">{$number_adult} {$core->get_Lang('Adults')}</td>
						<td class="td3 hidden_phone">x {$clsISO->formatPrice($item.price_adults_z)} {$clsISO->getShortRate()}</td>
						<td class="td4">{if $price_adult gt 0}{$clsISO->formatPrice($price_adult)}{/if} {$clsISO->getShortRate()}</td>
					</tr>
					{if $number_child gt 0}
					<tr>

						<td class="td2">{$number_child} {$core->get_Lang('Child')}</td>
						<td class="td3 hidden_phone">x {$clsISO->formatPrice($item.price_child_z)} {$clsISO->getShortRate()}</td>
						<td class="td4">{$clsISO->formatPrice($price_child)} {$clsISO->getShortRate()}</td>
					</tr>
					{/if}
					{if $number_infant gt 0}
					<tr>

						<td class="td2">{$number_infant} {$core->get_Lang('Infant')}</td>
						<td class="td3 hidden_phone">x {$clsISO->formatPrice($item.price_infants_z)} {$clsISO->getShortRate()}</td>
						<td class="td4">{$clsISO->formatPrice($price_infant)} {$clsISO->getShortRate()}</td>
					</tr>
					{/if}
					{if $item.promotion_z >0}
					<tr>

						<td class="td2">{$core->get_Lang('Discount')}</td>
						<td class="td3 hidden_phone"><p class="color_1fb69a">-{$clsISO->formatPrice($item.promotion_z)}%</p></td>
						<td class="td4">-{$clsISO->formatPrice($item.price_promotion)} {$clsISO->getShortRate()}</td>
					</tr>
					{/if}
					{if $item.number_addon gt 0}
					{assign var=rows_addon value=$item.number_addon|@count}
					<tr class="tr_addon1 tr_label"><td class="td1" rowspan="{$rows_addon+1}">{$core->get_Lang('Extra service')}</td></tr>
					{foreach from=$item.number_addon key=k item=v name=addon}
					{if $v}
					<tr class="tr_addon">

						<td class="td2">{$v} {$clsAddOnService->getTitle($k)}</td>
						<td class="td3 hidden_phone">
							{if $clsAddOnService->getExtra($k) eq '0'}
							<p class="price">0 {$clsISO->getShortRate()}</p> 
							{else}
							<p class="price">x {$clsAddOnService->getStrPrice($k)} {$clsISO->getShortRate()}</p>
							{/if}
						</td>
						<td class="td4">
							{assign var=price_service value=$v*$clsAddOnService->getStrPrice($k)}
							{if $clsAddOnService->getExtra($k) eq '0'}
							<p class="price">0 {$clsISO->getShortRate()}</p> 
							{else}
							<p class="price">{$clsISO->formatPrice($price_service)} {$clsISO->getShortRate()}</p>
							{/if}
						</td>
					</tr>
					{/if}
					{/foreach}
					{/if}

					<tr class="tr_total">
						<td class="td1">{$core->get_Lang('Total')}</td>
						<td class="td2 hidden_phone"></td>
						<td class="td3 hidden_phone"></td>
						<td class="td4 td_total_price">{$clsISO->formatPrice($item.total_price_z)} {$clsISO->getShortRate()}</td>
					</tr>
				</tbody>
			</table>
			{else}
			<table class="table_price">
				<tbody>
					<tr class="tr_label"><td class="td1" rowspan="{$row_traveler}">{$core->get_Lang('Traveler')}</td></tr>
					
					<tr>

						<td class="td2">{$number_adult} {$core->get_Lang('Adults')}</td>
						<td class="td3 hidden_phone">x {$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_adults_z)}</td>
						<td class="td4">{if $price_adult gt 0}{$clsISO->getShortRate()}{$clsISO->formatPrice($price_adult)}{/if}</td>
					</tr>
					{if $number_child gt 0}
					<tr>

						<td class="td2">{$number_child} {$core->get_Lang('Child')}</td>
						<td class="td3 hidden_phone">x {$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_child_z)}</td>
						<td class="td4">{$clsISO->getShortRate()}{$clsISO->formatPrice($price_child)}</td>
					</tr>
					{/if}
					{if $number_infant gt 0}
					<tr>

						<td class="td2">{$number_infant} {$core->get_Lang('Infant')}</td>
						<td class="td3 hidden_phone">x {$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_infants_z)}</td>
						<td class="td4">{$clsISO->getShortRate()}{$clsISO->formatPrice($price_infant)}</td>
					</tr>
					{/if}
					{if $item.promotion_z >0}
					<tr>

						<td class="td2">{$core->get_Lang('Discount')}</td>
						<td class="td3 hidden_phone"><p class="color_1fb69a">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.promotion_z)}%</p></td>
						<td class="td4">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_promotion)}</td>
					</tr>
					{/if}
					{if $item.number_addon gt 0}
					{assign var=rows_addon value=$item.number_addon|@count}
					<tr class="tr_addon1 tr_label"><td class="td1" rowspan="{$rows_addon+1}">{$core->get_Lang('Extra service')}</td></tr>
					{foreach from=$item.number_addon key=k item=v name=addon}
					<tr class="tr_addon">

						<td class="td2">{$v} {$clsAddOnService->getTitle($k)}</td>
						<td class="td3 hidden_phone">
							{$clsISO->getShortRate()}
							{if $clsAddOnService->getExtra($k) eq '0'}
							<p class="price">0</p> 
							{else}
							<p class="price">x {$clsAddOnService->getStrPrice($k)}</p>
							{/if}
						</td>
						<td class="td4">
							{assign var=price_service value=$v*$clsAddOnService->getStrPrice($k)}
							{$clsISO->getShortRate()}
							{if $clsAddOnService->getExtra($k) eq '0'}
							<p class="price">0</p> 
							{else}
							<p class="price">{$clsISO->formatPrice($price_service)}</p>
							{/if}
						</td>
					</tr>
					{/foreach}
					{/if}

					<tr class="tr_total">
						<td class="td1">{$core->get_Lang('Total')}</td>
						<td class="td2 hidden_phone"></td>
						<td class="td3 hidden_phone"></td>
						<td class="td4 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($item.total_price_z)}</td>
					</tr>
				</tbody>
			</table>
			{/if}
		</div>
		<div class="info_function">
			{*<div class="info_function_left">
				<a  class="edit" href="{$clsTour->getLink($item.tour_id_z)}" title="{$core->get_Lang('Edit')}">{$core->get_Lang('Edit')}</a>
				<a class="remove ajvCart" data-tp="DEL_PACKAGE" data-table_id="{$item.tour_id_z}" href="javascript:void(0);" title="{$core->get_Lang('Delete')}">{$core->get_Lang('Delete')}</a>
			</div>*}
			{if $item.deposit}
			<div class="info_function_right">
				<p> {$item.deposit} % {$core->get_Lang('Deposit')}</p>
				{if $_LANG_ID eq 'vn'}
				<div class="deposits">
					{$clsISO->formatPrice($item.price_deposit)} <span class="text-underline size16"> {$clsISO->getShortRate()}</span>
				</div>
				{else}
				<div class="deposits">
					<span class="text-underline size16">{$clsISO->getShortRate()}</span>{$clsISO->formatPrice($item.price_deposit)}
				</div>
				{/if}
			</div>
			{/if}
		</div>
	</div>
	{/if}
{/foreach}
{assign var=row_traveler value=0}
{/if}