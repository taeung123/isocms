{if $cartSessionVoucher}
<label class="TitleBookingFinal">{$core->get_Lang('Voucher')}</label>
{foreach from=$cartSessionVoucher item=item name=item}
	{assign var=voucher_id value=$item.voucher_id}
	{assign var=title_package value=$clsVoucher->getTitle($item.voucher_id)}
	{assign var=link_package value=$clsVoucher->getLink($item.voucher_id)}
	{assign var=price_package value=$clsVoucher->getPrice($item.voucher_id)}
	{assign var=priceO_package value=$clsVoucher->getPriceOrigin($item.voucher_id)}
	{if $voucher_id}
	{if $_LANG_ID eq 'vn'}
	<div class="tour_item_book mb10">
		<div class="info_tour_item_book pd0">
			<div class="info_padding">
				<h3 class="title mb10">{$smarty.foreach.item.iteration}. {$title_package}</h3>
				<div class="line"></div>
			</div>
			<table class="table_booking_price">
				<tbody>
					{assign var=numberVoucher value=$item.number_voucher}
					{assign var=voucher_price_z value=$item.voucher_price_z}
					{math assign="TotalPriceVoucher" equation="x * y" x=$voucher_price_z y=$numberVoucher}
					<tr>
						<td class="td1">{$numberVoucher} {$core->get_Lang('ticket')}</td>
						<td class="td2">{$clsISO->formatPrice($TotalPriceVoucher)} {$clsISO->getShortRate()}</td>
					</tr>
					{if $item.discount_type}
					<tr>
						<td class="td1">{$core->get_Lang('Discount')}</td>
						{if $item.discount_type eq '2'}
							{math assign="price_promotion" equation="x*y/100" x=$TotalPriceVoucher y=$item.discount_value}
							<td class="td2">-{$clsISO->formatPrice($price_promotion)} {$clsISO->getShortRate()}</td>
						{else}
							{math assign="price_promotion" equation="x*y" x=$numberVoucher y=$item.discount_value}
							<td class="td2">-{$clsISO->formatPrice($price_promotion)} {$clsISO->getShortRate()}</td>
						{/if}
						{math assign="TotalPriceVoucher" equation="x - y" x=$TotalPriceVoucher y=$price_promotion}
					</tr>
					{/if}
					<tr class="tr_total">
						<td class="td1">{$core->get_Lang('Total Price Voucher')}</td>
						<td class="td2 td_total_price">{$clsISO->formatPrice($TotalPriceVoucher)} {$clsISO->getShortRate()}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	{else}
	<div class="tour_item_book mb10">
		<div class="info_tour_item_book pd0">
			<div class="info_padding">
				<h3 class="title mb10">{$smarty.foreach.item.iteration}. {$title_package}</h3>
				<div class="line"></div>
			</div>
			<table class="table_booking_price">
				<tbody>
					{assign var=numberVoucher value=$item.number_voucher}
					{math assign="TotalPriceVoucher" equation="x * y" x=$priceO_package y=$numberVoucher}
					<tr>
						<td class="td1">{$numberVoucher} {$core->get_Lang('ticket')}</td>
						<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($TotalPriceVoucher)}</td>
					</tr>
					{if $item.promotion_z >0}
					<tr>
						<td class="td1">{$core->get_Lang('Discount')}</td>
						<td class="td2">-{$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_promotion)}</td>
					</tr>
					{/if}
					<tr class="tr_total">
						<td class="td1">{$core->get_Lang('Total Price Voucher')}</td>
						<td class="td2 td_total_price">{$clsISO->getShortRate()}{$clsISO->formatPrice($TotalPriceVoucher)}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	{/if}
	{/if}
{/foreach}
{/if}