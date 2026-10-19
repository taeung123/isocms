<form action="" method="post" id="frm_book_cruise">
	<input type="hidden" name="cruise_itinerary_id" value="{$cruise_itinerary_id}">
	<input type="hidden" name="cruise_id" value="{$cruise_id}">
	<input type="hidden" name="departure_date" value="{$departure_date}">
	<input type="hidden" name="discount_value" value="{$discount_value}">
	<input type="hidden" name="discount_type" value="{$discount_type}">
	<div class="info_cabin_box">
		<h3 class="cruise_name">{$clsCruiseItinerary->getTitleDay($cruise_itinerary_id)}</h3>
		<p class="departure_date mb20"><span class="text_left">{$core->get_Lang('Itinerary')}</span><span class="text_right">{$clsCruiseItinerary->getNumberDay($cruise_itinerary_id)}</span></p>
		<p class="departure_date"><span class="text_left">{$core->get_Lang('Departure')}</span><span class="text_right">{$clsISO->converTimeToText5($str_departure_date)}</span></p>

		<div class="list_cabin" id="list_cabin" style="display: none">
			<p class="title_box">{$core->get_Lang('Cabin Information')}</p>
			<div class="box_cabin_item" id="box_cabin_item">

			</div>
			<div class="cabin_choose_item promotion" style="display: none">
				<div class="col_name">
					<h4>Giảm giá</h4>
				</div>
				<input type="hidden" name="price_promotion" value="0">
				<div class="col_price">- <span class="price_promotion"></span> {$clsISO->getShortRate()}</div>
			</div>
		</div>
		<div class="total_price_cabin" style="display: none">
			<div class="col_label">{$core->get_Lang('Total')}:</div>
			<div class="col_price">
				<p class="price"><span class="totalprice_new"></span> {$clsISO->getShortRate()}</p>
				<p class="text">{$core->get_Lang('Giá trên đã bao gồm VAT')}</p>
			</div>
		</div>
	</div>
    {if $clsISO->getCheckActiveModulePackage($package_id,'booking','booking_cruise','default')}
	<div class="btn_book" style="display: none">
		<a class="btn_main" data-cruise_id="{$cruise_id}" data-cruise_itinerary_id="{$cruise_itinerary_id}" id="book_now_cabin" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
	</div>
    {else}
    <div class="btn_book" style="display: none">
		<a class="btn_main" data-cruise_id="{$cruise_id}" data-cruise_itinerary_id="{$cruise_itinerary_id}" id="book_now_cabin" title="{$core->get_Lang('Contact')}">{$core->get_Lang('Contact')}</a>
	</div>
    {/if}
</form>