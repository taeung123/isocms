<thead>
	<th style="text-align:left;">{$core->get_Lang('Traveler Types')}</th>
	<th style="text-align:right;">{$core->get_Lang('Price')} ({$clsISO->getRate()})</th> 
	<th style="text-align:right;">{$core->get_Lang('Number of people')}</th>
</thead>
<tbody>
	{section name=i loop=$lstVisitorType}
		<tr>
			<td class="text_capitalize">{$lstVisitorType[i].title}</td>
			{if $lstVisitorType[i].tour_property_id eq $adult_type_id} 
				<td class="text-right"><span id="people_price_text{$adult_type_id}">0</span></td>
				<td class="text-right">
				<div class="tour select_arow">
					<select max_adult="{$max_adult}" type="number" class="input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="national_visitor{$lstVisitorType[i].tour_property_id}" id="national_visitor{$lstVisitorType[i].tour_property_id}">
						{section name=j loop=$max_adult}
						<option {if $adult eq $smarty.section.j.iteration}selected="selected"{/if} value="{$smarty.section.j.iteration}">
							{$smarty.section.j.iteration}
						</option>
						{/section}
					</select>
				</div>
				<input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{$price_adult}" id="people_price{$lstVisitorType[i].tour_property_id}" departure_in="{$departure_in}" departure_in_2="{$departure_in_2}"></td>
			{elseif $lstVisitorType[i].tour_property_id eq $child_type_id}
				<td class="text-right"><span id="people_price_text{$child_type_id}">0</span></td>
				<td class="text-right">
				<div class="tour select_arow">
					<select type="number" class="input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="national_visitor{$lstVisitorType[i].tour_property_id}" id="national_visitor{$lstVisitorType[i].tour_property_id}">
						<option value="0">0</option>
						{section name=j loop=$max_child}
						<option {if $child eq $smarty.section.j.iteration}selected="selected"{/if} value="{$smarty.section.j.iteration}">{$smarty.section.j.iteration}</option>
						{/section}
					</select>
				</div>
				<input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{$price_child}" id="people_price{$lstVisitorType[i].tour_property_id}" departure_in="{$departure_in}" departure_in_2="{$departure_in_2}"></td>
			{else}
			<td class="text-right"><span id="people_price_text{$infant_type_id}">0</span></td>
			<td class="text-right">
			<div class="tour select_arow">
				<select type="number" class="input_number find_select" tour_visitor_type_id="{$lstVisitorType[i].tour_property_id}" name="national_visitor{$lstVisitorType[i].tour_property_id}" id="national_visitor{$lstVisitorType[i].tour_property_id}">
					<option value="0">0</option>
					{section name=j loop=$max_infant}
					<option {if $infant eq $smarty.section.j.iteration}selected="selected"{/if} value="{$smarty.section.j.iteration}">{$smarty.section.j.iteration}</option>
					{/section}
				</select>
			</div>

			<input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{$price_infant}" id="people_price{$lstVisitorType[i].tour_property_id}" departure_in="{$departure_in}" departure_in_2="{$departure_in_2}"></td>
			{/if}
		</tr>
	{/section}
	{if $oneItem.list_service_id ne ''}
	{if $_LANG_ID eq 'vn'}
	<tr>
		<td colspan="2" class="text_right">{$core->get_Lang('Total traveler')}</td>
		<td style="text-align:right"><span id="traveler_total">0</span> {$clsISO->getRate()}<input type="hidden" value="" id="total_traveler"/></td>
	</tr>
	<tr>
		<td colspan="2" class="text_right">{$core->get_Lang('Total service')}</td>
		<td style="text-align:right"><span id="service_total">0</span> {$clsISO->getRate()}<input type="hidden" value="" id="total_service" name="total_service"/></td>
	</tr>
	{else}
	<tr>
		<td colspan="2" class="text_right">{$core->get_Lang('Total traveler')}</td>
		<td style="text-align:right">{$clsISO->getRate()} <span id="traveler_total">0</span><input type="hidden" value="" id="total_traveler"/></td>
	</tr>
	<tr>
		<td colspan="2" class="text_right">{$core->get_Lang('Total service')}</td>
		<td style="text-align:right">{$clsISO->getRate()} <span id="service_total">0</span><input type="hidden" value="" id="total_service" name="total_service"/></td>
	</tr>
	{/if} 
	{else}
		<tr style="display:none !important">
			<td colspan="2">{$core->get_Lang('Total traveler')}</td>
			<td style="text-align:right">{$clsISO->getRate()} <span id="traveler_total">0</span><input type="hidden" value="" id="total_traveler"/></td>
		</tr>
		<tr style="display:none !important">
			<td colspan="2">{$core->get_Lang('Total service')}</td>
			<td style="text-align:right">{$clsISO->getRate()} <span id="service_total">0</span><input type="hidden" value="" id="total_service" name="total_service"/></td>
		</tr>
	{/if}
	<tr>
		<td colspan="2" style="text-align:right">{$core->get_Lang('Total amount')}</td>
		{if $_LANG_ID eq 'vn'}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;"><span id="national_total">{$total_amount}</span> {$clsISO->getRate()}</td>
		{else}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;">{$clsISO->getRate()} <span id="national_total">{$total_amount}</span></td>
		{/if}
	</tr>
	{if $promotion gt 0}
	<tr>
		<td colspan="2" style="text-align:right">{$core->get_Lang('Promotion')} ({$promotion}%)</td>
		{if $_LANG_ID eq 'vn'}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;"><span id="national_promotion">{$pricePromotion}</span> {$clsISO->getRate()}</td>
		{else}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;">{$clsISO->getRate()} <span id="national_promotion">{$pricePromotion}</span></td>
		{/if}
	</tr>
	{/if}
	<tr>
		<td class="text-right" colspan="2">
			<div class="special_select">
				<div class="tour select_arow">
					<select class="pay_deposit find_select" name="pay_deposit">
					{if $depositItem gt 0 }
						<option value="{$deposit}">{$core->get_Lang('Deposit')}({$depositItem}%)</option>
						<option value="100">{$core->get_Lang('Pay Full')}</option>
					{else}
						<option value="100">{$core->get_Lang('Pay Full')}</option>
					{/if}	
					</select>
				</div>
			</div>
		</td>
		{if $_LANG_ID eq 'vn'}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;"><span id="deposit">{$price_deposit}</span> {$clsISO->getRate()}</td>
		{else}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;">{$clsISO->getRate()} <span id="deposit">{$price_deposit}</span></td>
		{/if}
	</tr>
	<tr>
		<td colspan="2" style="text-align:right">{$core->get_Lang('Remaining amount')}</td>
		{if $_LANG_ID eq 'vn'}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;"> <span id="total_remaining">{$remaining_amount}</span> {$clsISO->getRate()}</td>
		{else}
		<td style="text-align: right;color: #333; font-size: 21px;font-weight: normal;">{$clsISO->getRate()} <span id="total_remaining">{$remaining_amount}</span></td>
		{/if}
		
	</tr>
</tbody>
<input type="hidden" id="pricePromotion" name="pricePromotion" value="{$pricePromotion}"/>
<input type="hidden" id="promotion" name="promotion" value="{$promotion}"/>
<input type="hidden" id="tien1" name="tien1" value="{$total_amount}"/>
<input type="hidden" id="depositBooking" name="depositBooking" value="{$price_deposit}"/>
<input type="hidden" name="remainingPrice" value="{$remaining_amount}" id="remainingPrice"/>
<input type="hidden" name="adult" value="{$adult}" id="adult"/>
<input type="hidden" name="child" value="{$child}" id="child"/>
<input type="hidden" name="baby" value="{$infant}" id="baby"/>
<script type="text/javascript">
var promotion_check='{$promotion}';
</script>

{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		var service_total = document.getElementById("service_total");
		var total_traveler = document.getElementById("total_traveler");
		var traveler_total = document.getElementById("traveler_total");
		getTotalRateService();
		function getTotalRateService() {
			var $totalRate = 0;
			$('.trRowSv.choosesv').each(function(){
				var $_this = $(this);
				var $addonservice_id = $_this.attr('addonservice_id');
				var $extra = $_this.attr('extra');
				var $price=0;
				if($extra==1){
					$price += parseInt($_this.find('#tourPriceSv'+$addonservice_id).val());
				}else if($extra==2){
					$price += parseInt($_this.find('#tourPriceSv'+$addonservice_id).val());
				}else{
					$price +=$price;
				}
				$totalRate += $price;
			});
			$('#total_service').val($totalRate);
			service_total.innerHTML = $totalRate.format();
		}
		function getTotalRateServiceItem() {
			var $totalRate = 0;
			$('.trRowSv.choosesv').each(function(){
				var $_this = $(this);
				var $addonservice_id = $_this.attr('addonservice_id');
				var $extra = $_this.attr('extra');
				var $price=0;
				if($extra==1){
					$price +=parseInt($_this.find('#PriceServiceItem'+$addonservice_id).val());
				}else if($extra==2){
					$price += parseInt($_this.find('#PriceServiceItem'+$addonservice_id).val()) * parseInt($_this.find('#numberService_'+$addonservice_id).val());
				}else{
					$price +=$price;
				}
				$totalRate += $price;
				$('#tourPriceSv'+$addonservice_id).val($totalRate);
			});
			$('#total_service').val($totalRate);
			service_total.innerHTML = $totalRate.format();
			
		}
	});
</script>
{/literal}