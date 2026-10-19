<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('bookingmanagement')} #{$pvalTable}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
	<div class="admin-content-wrap">
    <form action="" method="post" class="form-horizontal form-edit form-table cm-processed-form cm-check-changes">
        <input type="hidden" name="booking_id" value="{$pvalTable}">
		<input type="hidden" name="update_booking" value="UPDATE">
        <script type="text/javascript">
            var number_travelers = '{$BookingStore.adult+$BookingStore.child+$BookingStore.baby}';
            var menu_content = '';
        </script>
		<div class="booking_detail">
			<div class="info_box">
				<div class="info_customer">
					<h3>{$core->get_Lang('Customer')}</h3>
					<p>{$core->get_Lang('FullName')}: {$booking_store.title} {$booking_store.fullname}</p>
					<p>{$core->get_Lang('Address')}: {$booking_store.address}</p>
					<p>{$core->get_Lang('Phone')}: {$booking_store.telephone}</p>
					<p>Email: {$booking_store.email}</p>
				</div>
				<div class="booking_info">
					<h3>{$core->get_Lang('Information')}</h3>
					<p><label>{$core->get_Lang('Booking')}:</label> {$clsClassTable->getOneField('booking_code',$pvalTable)}</p>
					<p><label>{$core->get_Lang('Booking date')}:</label> {$clsISO->formatTimeMonth($clsClassTable->getOneField('reg_date',$pvalTable))}</p>
					<p><label>{$core->get_Lang('Payment method')}:</label> {$clsClassTable->getPaymentMethod2($pvalTable)}</p>
					<p><label>{$core->get_Lang('Currency')}:</label> {$clsISO->getRate()}</p>
				</div>
			</div>
			
			<div class="info_booking_box">
				<h3>{$core->get_Lang('Detail Infomation')}</h3>

				{if $cart_store_tour}
				<table>
					<thead>
						<th class="text-left">{$core->get_Lang('Trip')}</th>
						<th class="text-right" width="20%">{$core->get_Lang('Quantily')}</th>
						<th class="text-right" width="20%">{$core->get_Lang('Discount')}</th>
						<th class="text-right" width="20%">{$core->get_Lang('Total Price')}</th>
					</thead>
					<tbody>
						{foreach from=$cart_store_tour item=item name=item}
						{assign var=tour_id value=$item.tour_id_z}
						
		
						{assign var=number_adult value=$item.number_adults_z}
						{assign var=number_child value=$item.number_child_z}
						{assign var=number_infant value=$item.number_infants_z}
						
						{assign var=price_adult value=$item.price_adults_z}
						{assign var=price_child value=$item.price_child_z}
						{assign var=price_infant value=$item.price_infants_z}
						<tr>
							<td class="text-left">
								<p>{$clsTour->getTitle($tour_id)}</p>
							</td>
							<td class="text-right">{$number_adult} {$core->get_Lang('Adults')}{if $number_child gt 0} + {$number_child} {$core->get_Lang('Child')}{/if}{if $number_infant gt 0} + {$number_infant} {$core->get_Lang('Infant')}{/if}</td>
							<td class="text-right">
							{if $item.promotion_z >0}
							<p class="promotion_in4">{$item.price_promotion}</p>
							{/if}
							</td>
							<td class="text-right">
							<p>{$clsISO->formatPrice($item.total_price_z)}{$clsISO->getShortRate()}</p>
							</td>
						</tr>
						{if $item.total_addon}
						<tr><td colspan="4"  class="text-left">{$core->get_Lang('AddOn Service')}</td></tr>
						{foreach from=$item.number_addon key=k item=v}
						{if $v gt 0}
						<tr>
						<td class="text-left">{$clsAddOnService->getTitle($k)}</td>
						<td class="text-right">{$v}</td>
						<td class="text-right"></td>
						<td class="text-right">
						{if $clsAddOnService->getExtra($k) eq 0}
						<span>{$core->get_Lang('Include')}</span>
						{else}
						<span>{$clsAddOnService->getPrice($k)}{$clsISO->getShortRate()}</span>
						{/if}
						</td>
						</tr>
						{/if}
						{/foreach}
						{/if}
						{/foreach}
					</tbody>
				</table>
				{/if}
						
				{if $cart_store_voucher}
				<table>
					<thead>
						<th class="text-left">{$core->get_Lang('Voucher')}</th>
						<th class="text-right" width="20%">{$core->get_Lang('Quantily')}</th>
						<th class="text-right" width="20%">{$core->get_Lang('Discount')}</th>
						<th class="text-right" width="20%">{$core->get_Lang('Total Price')}</th>
					</thead>
					<tbody>
						{foreach from=$cart_store_voucher item=item name=item}
						{assign var=voucher_id value=$item.voucher_id_z}
						{assign var=number_voucher value=$item.voucherGroup_id}
						
						{assign var=price_one_voucher value=$clsVoucher->getPricePromotionO($voucher_id)}
						
						{assign var=price_origin value=$clsVoucher->getPriceOrigin($voucher_id)}
						
						{math assign="PriceVoucher" equation="x * y" x=$price_one_voucher y=$number_voucher}
						
						{math assign="PriceDiscount" equation="(x - y) * z" x=$price_one_voucher y=$price_origin z=$number_voucher}
						
						<tr>
							<td class="text-left">
								<p>{$clsVoucher->getTitle($voucher_id)}</p>
							</td>
							<td class="text-right">{$item.voucherGroup_id} {$core->get_Lang('Voucher')}</td>
							<td class="text-right">
							{if $PriceDiscount >0}
							<p class="promotion_in4">{$clsISO->formatPrice($PriceDiscount)}{$clsISO->getShortRate()}</p>
							{/if}
							</td>
							<td class="text-right">
							<p>{$clsISO->formatPrice($PriceVoucher)}{$clsISO->getShortRate()}</p>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
				{/if}
				<div class="total_price">
				{assign var=totalgrand value=$oneItem.totalgrand}
				{assign var=deposit value=$oneItem.deposit}
				{assign var=balance value=$oneItem.balance}
				{math assign="price_payment_now" equation="x - y" x=$totalgrand y=$balance}	
				<p><label class="text_bold">{$core->get_Lang('Tổng tiền')}(+VAT 10%):</label>................................<span class="text_bold">{$clsISO->formatPrice($totalgrand)}{$clsISO->getShortRate()}</span></p>
				<p><label>{$core->get_Lang('Đặt cọc Tour')}:</label>................................<span>{$clsISO->formatPrice($oneItem.deposit)}{$clsISO->getShortRate()}</span></p>	
				<p><label>{$core->get_Lang('Thanh toán ngay')}:</label>................................<span>{$clsISO->formatPrice($price_payment_now)}{$clsISO->getShortRate()}</span></p>
				<p><label>{$core->get_Lang('Số tiền còn lại')}:</label>................................<span>{$clsISO->formatPrice($balance)}{$clsISO->getShortRate()}</span></p>
				</div>
			</div>
		</div>
    </form>
    <script type="text/javascript">
        var ajax_callback_data = menu_content;
    </script>
</div>
</div>
{literal}
<style type="text/css">
.text_bold{font-weight:bold !important}
.info_booking_box h3{font-size:18px; font-weight:bold; color:#1c1c1c; margin-bottom:15px;}
.booking_detail .info_box{display:inline-block; width:100%;}
.booking_detail .info_customer{display:inline-block; width:50%; float:left}
.booking_detail .info_customer p{color:#555}
.booking_detail .booking_info{display:inline-block; width:250px; float:right;}
.booking_detail .booking_info p label{display:inline-block; width:140px; font-size:16px; color:#555; font-weight:normal}
.booking_detail .booking_info p{font-size:16px; color:#555;}
.booking_detail .info_customer h3,.booking_detail .booking_info h3{font-size:18px; color:#1c1c1c; margin-bottom:15px;}
.booking_detail .info_customer p,.booking_detail .booking_info p{font-size:16px;}
.booking_detail table{width:100%; font-size:16px; border-collapse:collapse; border-spacing:0; margin-bottom:20px;}
.booking_detail table th{font-size:18px;}
.booking_detail table td,.booking_detail table td p{font-size:16px;}
.booking_detail table th,.booking_detail table td{line-height:36px;border: 1px solid #000;text-align: left;padding:5px 8px; color:#1c1c1c}
.total_price{display:inline-block; font-size:16px; width:100%; text-align:right; color:#1c1c1c;}
.total_price p{font-size:16px;}
</style>
{/literal}