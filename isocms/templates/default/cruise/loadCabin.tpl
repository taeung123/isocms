<div class="cabin_choose_item" id="{$choose_index}" data-cruise_cabin_id="{$cruise_cabin_id}">
	<input type="hidden" name="priceCabin" value="{$price_cabin}">
	<input type="hidden" name="numberCabin" value="{$number_cabin}">
	<input type="hidden" name="promotionPriceCabin" value="{$promotion_price}">
	<input type="hidden" name="number_adult" value="{$number_adult}">
	<input type="hidden" name="number_child" value="{$number_child}">
	<input type="hidden" name="max_adult" value="{$max_adult}">
	<div class="col_name">
		<h4><a title="{$core->get_Lang('Delete')}" href="javascript:void(0);" class="delete_cabin" data-cruise_id="{$cruise_id}" data-cruise_itinerary_id="{$cruise_itinerary_id}" data-departure_date="{$departure_date}" data-cruise_cabin_id="{$cruise_cabin_id}"><i class="icon_info_cabin icon_del"></i></a>
		<select data-cruise_id="{$cruise_id}" data-cruise_itinerary_id="{$cruise_itinerary_id}" data-cruise_cabin_id="{$cruise_cabin_id}" data-number_adult="{$number_adult}" data-number_child="{$number_child}" data-totalprice="{$price_cabin}" data-departure_date="{$departure_date}" data-max_adult="{$max_adult}" data-number_cabin="1" name="number_cabin" class="number_cabin select_number">
			{section name=i loop=$max_cabin}
				<option value="{$smarty.section.i.iteration}" {if $number_cabin eq $smarty.section.i.iteration}selected{/if}>{$smarty.section.i.iteration}</option>
			{/section}
		</select>
		{$clsCruiseCabin->getTitle($cruise_cabin_id)}</h4>
		<p class="size12 mb0">{$number_cabin} {$core->get_Lang('cabin')} {$number_adult} {$core->get_Lang('Adults')} {$number_child} {$core->get_Lang('Child')}</p>
	</div>
	<div class="col_price">{$clsISO->priceFormat($price_cabin)} {$clsISO->getShortRate()}</div>
</div>