{assign var=cartSessionVoucher value=$clsBooking->getCartStoreBooking($lstBooking[bk].booking_id,'VOUCHER')}
{if $cartSessionVoucher}
<label class="titleBoxContent">{$core->get_Lang('Voucher')}</label>
{foreach from=$cartSessionVoucher item=item name=item}

{assign var=voucher_id value=$item.voucher_id}
{if $voucher_id}
{assign var=title_package value=$clsVoucher->getTitle($item.voucher_id)}
{assign var=link_package value=$clsVoucher->getLink($item.voucher_id)}
{assign var=price_package value=$clsVoucher->getPrice($item.voucher_id)}
{assign var=price_voucher value=$clsVoucher->getPricePromotion2($item.voucher_id)}
{assign var=priceO_voucher value=$clsVoucher->getPricePromotionO($item.voucher_id)}
{assign var=priceO_package value=$clsVoucher->getPriceOrigin($item.voucher_id)}
<div class="tour_item mb30">
	<div class="info_tour border_bottom_959595">
		<div class="body_hotel {$deviceType}">
			<div class="body_left">
				<span class="number_iteration">{$smarty.foreach.item.iteration}</span>
			</div>
			<div class="body_right">
				<h3 class="title mb10"><a href="{$link_package}" title="{$title_package}">{$title_package}</a></h3>
			</div>
		</div>
	</div>
	<div class="info_price">
		{if $_LANG_ID eq 'vn'}
		<table class="table_price">
			<tbody>
				{assign var=row_voucher value=2}
				{if $item.discount_value || $item.discount_type}
				{assign var=row_voucher value=$row_voucher+1}
				{/if}
				<tr class="tr_label">
					<td class="td1" rowspan="{$row_voucher}">{$core->get_Lang('Voucher')}</td>
				</tr>
				<tr>
					<td class="td2">{$item.number_voucher} {$core->get_Lang('ticket')}</td>
					<td class="td3 hidden_phone">x {$price_voucher} {$clsISO->getShortRate()}</td>
					<td class="td4">
						{assign var=numberVoucher value=$item.number_voucher}

						{math assign="TotalPriceVoucher" equation="x * y" x=$priceO_package y=$numberVoucher}
						{math assign="PriceVoucher" equation="x * y" x=$priceO_voucher y=$numberVoucher}
						{math assign="TotalDiscount" equation="(x - y) * z" x=$priceO_voucher y=$priceO_package z=$numberVoucher}
						
						{$clsISO->formatPrice($PriceVoucher)} {$clsISO->getShortRate()}
					</td>
				</tr>
				{if $item.discount_value || $item.discount_type}
				<tr>
					<td class="td2">{$core->get_Lang('Discount')}</td>
					<td class="td3 hidden_phone">
					
					{if $item.discount_type == 'percentage'}
					<p class="color_1fb69a">-{$clsISO->formatPrice($item.discount_value)}%</p>

					{elseif $item.discount_type == 'amount'}
					{if $_LANG_ID eq 'vn'}
					<p class="color_1fb69a">-{$clsISO->formatPrice($item.discount_value)} {$clsISO->getShortRate()}</p>
					{else}
					<p class="color_1fb69a">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.discount_value)} </p>
					{/if}
					{/if}
					
					</td>
					<td class="td4">
						-{$clsISO->formatPrice($TotalDiscount)} {$clsISO->getShortRate()}
					</td>
				</tr>
				{/if}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Total')}</td>
					<td class="td2 hidden_phone"></td>
					<td class="td3 hidden_phone"></td>
					<td class="td4 td_total_price">{$clsISO->formatPrice($TotalPriceVoucher)} {$clsISO->getShortRate()}</td>
				</tr>
			</tbody>
		</table>
		{else}
		<table class="table_price">
			<tbody>
				{assign var=row_voucher value=2}
				{if $item.discount_value || $item.discount_type}
				{assign var=row_voucher value=$row_voucher+1}
				{/if}
				<tr class="tr_label">
					<td class="td1" rowspan="{$row_voucher}">{$core->get_Lang('Voucher')}</td>
				</tr>
				<tr>
					<td class="td2">{$item.number_voucher} {$core->get_Lang('ticket')}</td>
					<td class="td3 hidden_phone">x {$clsISO->getShortRate()}{$price_voucher}</td>
					<td class="td4">
						{assign var=numberVoucher value=$item.number_voucher}

						{math assign="TotalPriceVoucher" equation="x * y" x=$priceO_package y=$numberVoucher}
						{math assign="PriceVoucher" equation="x * y" x=$priceO_voucher y=$numberVoucher}
						{math assign="TotalDiscount" equation="(x - y) * z" x=$priceO_voucher y=$priceO_package z=$numberVoucher}
						
						{$clsISO->getShortRate()}{$clsISO->formatPrice($PriceVoucher)}
					</td>
				</tr>
				{if $item.discount_value || $item.discount_type}
				<tr>
					<td class="td2">{$core->get_Lang('Discount')}</td>
					<td class="td3 hidden_phone">
					
					{if $item.discount_type == 'percentage'}
					<p class="color_1fb69a">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.discount_value)}%</p>

					{elseif $item.discount_type == 'amount'}
					{if $_LANG_ID eq 'vn'}
					<p class="color_1fb69a">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.discount_value)}</p>
					{else}
					<p class="color_1fb69a">-{$clsISO->getShortRate()}{$clsISO->getShortRate()}{$clsISO->formatPrice($item.discount_value)} </p>
					{/if}
					{/if}
					
					</td>
					<td class="td4">
						-{$clsISO->getShortRate()}{$clsISO->formatPrice($TotalDiscount)}
					</td>
				</tr>
				{/if}
				<tr class="tr_total">
					<td class="td1">{$core->get_Lang('Total')}</td>
					<td class="td2 hidden_phone"></td>
					<td class="td3 hidden_phone"></td>
					<td class="td4 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($TotalPriceVoucher)}</td>
				</tr>
			</tbody>
		</table>
		{/if}
	</div>
	{*<div class="info_function">
		<div class="info_function_left">
			<a  class="edit" href="{$clsVoucher->getLink($item.voucher_id)}" title="{$core->get_Lang('Edit')}">{$core->get_Lang('Edit')}</a>
			<a class="remove ajvCart" data-tp="DEL_VOUCHER" data-table_id="{$item.voucher_id}" href="javascript:void(0);" title="{$core->get_Lang('Delete')}">{$core->get_Lang('Delete')}</a>
		</div>
	</div>*}
</div>
{/if}
{/foreach}
{/if}