{if $_LANG_ID eq 'vn'}
<div class="last_price_total_book">
	<div class="total_price_book">
		<table class="table_total_price">
			<tbody>
				{if $cartSessionService}
				<tr>
					<td class="td1">{$core->get_Lang('Tour Price')}</td>
					<td  class="td2">{$clsISO->formatPrice($totalPriceTour)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				{if $cartSessionVoucher}
				<tr>
					<td  class="td1">{$core->get_Lang('Voucher Price')}</td>
					<td  class="td2">{$clsISO->formatPrice($totalPriceVoucher)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				{if $cartSessionCruise}
				<tr>
					<td class="td1">{$core->get_Lang('Cruise Price')}</td>
					<td class="td2">{$clsISO->formatPrice($totalPriceCruise)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				{if $cartSessionHotel}
				<tr>
					<td class="td1">{$core->get_Lang('Hotel Price')}</td>
					<td class="td2">{$clsISO->formatPrice($totalPriceHotel)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				{if $totalPriceDeposit}
				<tr>
					<td class="td1">{$core->get_Lang('Deposit')}</td>
					<td class="td2">{$clsISO->formatPrice($totalPriceDeposit)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
				<tr>
					<td class="td1">{$core->get_Lang('Payment remaining')}</td>
					<td class="td2">{$clsISO->formatPrice($totalRemaining)} {$clsISO->getShortRate()}</td>
				</tr>
				{if $totalPriceDeposit}
				<tr class="pay_now_text">
					<td class="td1">{$core->get_Lang('First payment')}</td>
					<td class="td2">{$clsISO->formatPrice($totalPricePaymentNow)} {$clsISO->getShortRate()}</td>
				</tr>
				{else}
				<tr class="pay_now_text">
					<td class="td1">{$core->get_Lang('Total Payment')}</td>
					<td class="td2">{$clsISO->formatPrice($totalPricePaymentNow)} {$clsISO->getShortRate()}</td>
				</tr>
				{/if}
			</tbody>
		</table>
	</div>
</div>
{else}
<div class="last_price_total_book">
	<div class="total_price_book">
		<table class="table_total_price">
			<tbody>
				{if $cartSessionService}
				<tr>
					<td class="td1">{$core->get_Lang('Tour Price')}</td>
					<td  class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalPriceTour)}</td>
				</tr>
				{/if}
				{if $cartSessionVoucher}
				<tr>
					<td  class="td1">{$core->get_Lang('Voucher Price')}</td>
					<td  class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalPriceVoucher)}</td>
				</tr>
				{/if}
				{if $cartSessionCruise}
				<tr>
					<td class="td1">{$core->get_Lang('Cruise Price')}</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalPriceCruise)}</td>
				</tr>
				{/if}
				{if $cartSessionHotel}
				<tr>
					<td class="td1">{$core->get_Lang('Hotel Price')}</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalPriceHotel)}</td>
				</tr>
				{/if}
				{if $totalPriceDeposit}
				<tr>
					<td class="td1">{$core->get_Lang('Deposit')}</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalPriceDeposit)} </td>
				</tr>
				{/if}
				<tr>
					<td class="td1">{$core->get_Lang('Payment remaining')}</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalRemaining)} </td>
				</tr>
				{if $totalPriceDeposit}
				<tr class="pay_now_text">
					<td class="td1">{$core->get_Lang('First payment')}</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalPricePaymentNow)}</td>
				</tr>
				{else}
				<tr class="pay_now_text">
					<td class="td1">{$core->get_Lang('Total Payment')}</td>
					<td class="td2">{$clsISO->getShortRate()}{$clsISO->formatPrice($totalPricePaymentNow)}</td>
				</tr>
				{/if}
			</tbody>
		</table>
	</div>
</div>
{/if}

<div class="form-group BoxPromotion" style="display: none">
	<div class="input-group">
		<input type="text" name="promotion_code" id="promotion_code" class="form-control" placeholder="Nhập mã giảm giá">
		<div class="input-group-btn"><button type="button" onClick="apply_promotion_code(this)" class="btn btn-primary buttonDiscount">Áp dụng</button></div>
	</div>
	<span id="discount__code-message" class="help-block text-red hidden"></span>
</div>
<div style="display: none">
	<p><span class="lable">{$core->get_Lang('Giảm giá ')}</span>
	<span id="discount__apply-result" class=" hidden">
	<span class="price tag"></span></span></p>
</div>