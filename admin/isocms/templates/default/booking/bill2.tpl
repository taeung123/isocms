<div class="bill" style="width: 800px;font-family: Segoe UI;font-style: normal;line-height: normal;display: flex;flex-wrap:wrap">
	<div class="bg_comp" style="width: 400px;height: 319px;position: absolute;clip-path: polygon(0 0, 100% 0, 100% 100%);background: #F7FDFD;right: 0;top: 0;"></div>
	<div class="info_bill" style="width: 440px;padding: 34px 0px 30px 30px">
		<h1 style="color: #000;font-size: 36px;font-weight: 600;margin-bottom: 10px">#{$max_id}</h1>
		<h2 style="color: #000;font-family: Segoe UI;font-size: 18px;font-style: normal;font-weight: 400;line-height: normal;text-transform: uppercase">{$core->get_Lang('Bill')}</h2>
		<div class="box_time" style="margin-top: 37px;display: flex;gap: 50px;flex-wrap: wrap">
			<div class="time" style="margin-bottom: 10px">
				<label for="" style="color: #666;font-size: 14px;font-weight: 400;margin-bottom:4px">{$core->get_Lang('Release date')}</label>
				<p style="color: #000;font-size: 18px;font-weight: 600;margin-bottom: 0px">{$smarty.now|date_format:"%d.%m.%Y"}</p>
			</div>
			<div class="time" style="margin-bottom: 10px">
				<label for="" style="color: #666;font-size: 14px;font-weight: 400;margin-bottom:4px">{$core->get_Lang('Payments term')}</label>
				<p style="color: #000;font-size: 18px;font-weight: 600;margin-bottom: 0px">{$payment_term|date_format:"%d.%m.%Y"}</p>
			</div>
			<div class="time" style="margin-bottom: 10px;">
				<label for="" style="color: #666;font-size: 14px;font-weight: 400;margin-bottom:4px">{$core->get_Lang('Code')}</label>
				<p style="color: #000;font-size: 18px;font-weight: 600;margin-bottom: 0px">3434235676</p>
			</div>
		</div>
		<div class="box_customer" style="margin-top: 30px;display: flex;flex-wrap: wrap">
			<label for="" style="color: #666;font-size: 14px;font-weight: 400;margin-right: 20px">{$core->get_Lang('Recipient')}</label>
			<div class="customer" style="width: 272px">
				<p class="name" style="color: #000;font-size: 16px;font-weight: 600;padding-bottom: 5px;border-bottom: 1px dashed #00000033;margin-bottom: 8px;">{$oneBooking.full_name}</p>
				<p style="color: #000;font-size: 16px;font-weight: 400;margin-bottom: 0px;padding-bottom: 5px;border-bottom: 1px dashed #00000033;margin-bottom: 8px;">{$oneBooking.email}</p>
				<p style="color: #000;font-size: 16px;font-weight: 400;margin-bottom: 0px;padding-bottom: 5px;border-bottom: 1px dashed #00000033">{$oneBooking.phone}</p>
			</div>
		</div>
	</div>
	<div class="box_company" style="width: 358px;height: 287px;padding: 40px 22px;/* clip-path: polygon(0 0, 100% 0, 100% 100%); *//* background: #F7FDFD; */text-align: right;position: relative;">
		<div class="box_info_company" style="width: 206px;float: right;color: #333;text-align: right;font-size: 12px;font-weight: 400">
			<img src="https://isocms.com/admin/isocms/templates/default/skin/images/logo_bill.png" alt="" style="margin-bottom: 19px">
			{assign var=address value=CompanyAddress_|cat:$_LANG_ID}
			<p style="margin-bottom: 3px">{$clsConfiguration->getValue($address)}</p>
			<p style="margin-bottom: 3px">{$clsConfiguration->getValue('CompanyEmail')}</p>
			<p style="margin-bottom: 0">{$clsConfiguration->getValue('CompanyPhone')}</p>
		</div>
	</div>
	<div class="box_infoBooking" style="width: 100%;padding: 0px 30px">
		<table class="table_booking" style="width: 100%">
			<thead>
				<tr>
					<th style="width: 50%;padding: 10px 20px;text-align: left;color: #000;font-ize:12px;font-weight: 400;text-transform: uppercase">{$core->get_Lang("Service")}</th>
					<th style="width: 10%;padding: 10px 0px;text-align: center;color: #000;font-size: 12px;font-weight: 400;text-transform: uppercase">{$core->get_Lang('Quantily')}</th>
					<th style="width: 20%;padding: 10px;text-align: right;color: #000;font-size:12px;font-weight: 400;text-transform: uppercase">{$core->get_Lang('Unit price')}</th>
					<th style="width: 20%;padding: 10px 20px;text-align: right;color: #000;font-size: 12px;font-weight: 400;text-transform: uppercase">{$core->get_Lang('Total price')}</th>
				</tr>
			</thead>
			<tbody>
				{if $tour_cart_store}
				{foreach from=$tour_cart_store item=item name=i}
					{assign var=tour_id 		value=$item.tour_id_z}
					{assign var=title 			value=$clsTour->getTitle($tour_id)}
					{assign var=Depart_point 	value=$clsTour->getDepartureCity($tour_id)}
					{assign var=fullTextAddress value=$clsTour->getTextdepartureCityEnd($tour_id,'full')}
					{if $clsTour->getTextdepartureCityEnd($tour_id) != ''}
						{assign var=address 		value=$clsTour->getTextdepartureCityEnd($tour_id)}
					{else}
						{assign var=address 		value=$fullTextAddress}
					{/if}
					{assign var=tour_option  	value=$clsTourOption->getTitle($item.tour__class)}
					{assign var=lstService  	value=$clsTour->getListService($tour_id)}
					{assign var=promotion_date value=$item.check_in_book_z|strtotime}
					{assign var=discount value=$clsISO->getPromotion($tour_id,'Tour',$oneBooking.reg_date,$promotion_date,'get_more_info')}
						
					<tr>
						<td colspan="4" style="padding: 0">
						<table class="table_booking_child" style="width: 100%;border-radius: 5px;border: 1px solid #D9D9D9;margin-bottom: 10px;">
							<thead>
								<tr>
									<th colspan="4" style="padding: 13px 20px;background: #F7F7F7;border-radius: 5px 5px 5px 0px">
										<p class="title_product" style="color: #000;font-size: 14px;font-weight: 600;margin-bottom: 5px;">{$tour_id}:[{$Depart_point}-{$address}] {$title}</p>
										<p class="duration_product" style="color: #000;font-size: 12px;font-weight: 400;line-height: 18px;margin-bottom: 0px">({$item.check_in_book_z|replace:"-":"/"} - {$clsISO->converTimeToText6($clsTour->getTextEndDate($item.check_in_book_z,$tour_id))})</p>
									</th>
								</tr>
							</thead>
							<tbody>
								{if $item.number_adults_z}
								<tr>
									<td style="width: 50%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$core->get_Lang("Adult")}</td>
									<td style="width: 10%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 0px;text-align: center">{$item.number_adults_z}</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px">{$item.price_adults_z|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$item.total_price_adults|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
								</tr>
								{/if}
								{if $item.number_child_z}
								<tr>
									<td style="width: 50%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$core->get_Lang("Child")}</td>
									<td style="width: 10%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 0px;text-align: center">{$item.number_child_z}</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px">{$item.price_child_z|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$item.total_price_child|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
								</tr>
								{/if}
								{if $item.number_infants_z}
								<tr>
									<td style="width: 50%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$core->get_Lang("Infants")}</td>
									<td style="width: 10%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 0px;text-align: center">{$item.number_infants_z}</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px">{$item.price_infants_z|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$item.total_price_infants|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
								</tr>
								{/if}
								{if $item.price_promotion > 0}
								<tr class="tr_promotion" style="background: #CFF4E0">
									<td colspan="2" style="width: 50%;text-align: left;color:#1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">
										<p style="margin: 0"><span>{$core->get_Lang('Promotion')}:</span> {$discount.title}</p>
									</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;">-{$item.promotion_z}%</td>
									<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;padding-right: 20px;">{$item.price_promotion|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
								</tr>
								{/if}
							</tbody>
						</table>
					</td>
				</tr>
				{/foreach}
				{/if}
				{if $hotel_cart_store}
				{foreach from=$hotel_cart_store item=item name=i}
					{assign var=hotel_id 		value=$item.hotel_id}
					{assign var=oneItemHotel 		value=$clsHotel->getOne($hotel_id,'title,address')}
					{assign var=title 			value=$clsHotel->getTitle($hotel_id,$oneItemHotel)}
					{assign var=promotion_date value=$item.check_in|strtotime}
					{assign var=discount value=$clsISO->getPromotion($hotel_id,'Hotel',$oneBooking.reg_date,$promotion_date,'info_promotion')}
						
					<tr>
						<td colspan="4" style="padding: 0">
							<table class="table_booking_child" style="width: 100%;border-radius: 5px;border: 1px solid #D9D9D9;margin-bottom: 10px;">
								<thead>
									<tr>
										<th colspan="4" style="padding: 13px 20px;background: #F7F7F7;border-radius: 5px 5px 5px 0px">
											<p style="color: #000;font-size: 14px;font-weight: 600;margin-bottom: 5px;">{$hotel_id}:{$title}</p>
											<p style="color: #000;font-size: 12px;font-weight: 400;line-height: 18px;margin-bottom: 0px">({$clsISO->converTimeToText5($item.check_in)} - {$clsISO->converTimeToText5($item.check_out)})</p>
										</th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$item.room item=item_room name=k}
									{math assign="price" equation="x * y" x=$item_room.number_room y=$item_room.totalprice}
									<tr>
										<td style="width: 50%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$clsHotelRoom->getTitle($item_room.hotel_room_id)}</td>
										<td style="width: 10%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 0px;text-align: center">{$item_room.number_room}</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px">{$item_room.totalprice|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$price|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									</tr>
									{/foreach}
									
									{if $item.totalPricePromotionHotel > 0}
									<tr class="tr_promotion" style="background: #CFF4E0">
										<td colspan="2" style="width: 50%;text-align: left;color:#1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">
											<p style="margin: 0"><span>{$core->get_Lang('Promotion')}:</span> {$discount.title}</p>
										</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;">-{$discount.discount_value}%</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;padding-right: 20px;">{$item.totalPricePromotionHotel|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									</tr>
									{/if}
								</tbody>
							</table>
						</td>						
					</tr>
				{/foreach}
				{/if}
				{if $cruise_cart_store}
				{foreach from=$cruise_cart_store item=item name=i}
					{assign var=cruise_id 		value=$item.cruise_id}
					{assign var=oneItemCruise 		value=$clsCruise->getOne($cruise_id,'title')}
					{assign var=title 			value=$clsCruise->getTitle($cruise_id,$oneItemCruise)}
					{assign var=promotion_date value=$item.departure_date}
					{assign var=discount value=$clsISO->getPromotion($cruise_id,'Cruise',$oneBooking.reg_date,$promotion_date,'info_promotion')}
					<tr>
						<td colspan="4" style="padding: 0">
							<table class="table_booking_child" style="width: 100%;border-radius: 5px;border: 1px solid #D9D9D9;margin-bottom: 10px;">
								<thead>
									<tr>
										<th colspan="4" style="padding: 13px 20px;background: #F7F7F7;border-radius: 5px 5px 5px 0px">
											<p style="color: #000;font-size: 14px;font-weight: 600;margin-bottom: 5px;">{$cruise_id}:{$title}</p>
											<p style="color: #000;font-size: 12px;font-weight: 400;line-height: 18px;margin-bottom: 0px">({$clsISO->converTimeToText5($item.departure_date)} - {$clsISO->converTimeToText6($clsCruiseItinerary->getTextEndDate($item.departure_date,$item.cruise_itinerary_id))})</p>
										</th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$item.cabin item=item_cabin name=k}
									<tr>
										<td style="width: 50%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$clsCruiseCabin->getTitle($item_cabin.cruise_cabin_id)}</td>
										<td style="width: 10%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 0px;text-align: center">{$item_cabin.number_cabin}</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px">{$item_cabin.totalprice|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$item_cabin.totalprice|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									</tr>
									{/foreach}
									
									{if $item.totalPricePromotionCruise > 0}
									<tr class="tr_promotion" style="background: #CFF4E0">
										<td colspan="2" style="width: 50%;text-align: left;color:#1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">
											<p style="margin: 0"><span>{$core->get_Lang('Promotion')}:</span> {$discount.title}</p>
										</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;">-{$discount.discount_value}%</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;padding-right: 20px;">{$item.totalPricePromotionCruise|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									</tr>
									{/if}
								</tbody>
							</table>
						</td>
					</tr>
				{/foreach}
				{/if}
				{if $voucher_cart_store}
				{foreach from=$voucher_cart_store item=item name=i}
					{assign var=voucher_id 		value=$item.voucher_id_z}
					{assign var=oneVoucher 			value=$clsVoucher->getOne($voucher_id,'title,price')}
					{assign var=title 			value=$oneVoucher.title}		
					{assign var=price 			value = $clsISO->parsePriceDecimal($oneVoucher.price)}	
					{math assign="price_total" equation="x * y" x=$item.voucherGroup_id y=$price}

					{assign var=discount value=$clsISO->getPromotion($voucher_id,'Voucher',$oneBooking.reg_date,$oneBooking.reg_date,'info_promotion')}
					<tr>
						<td colspan="4" style="padding: 0">
							<table class="table_booking_child" style="width: 100%;border-radius: 5px;border: 1px solid #D9D9D9;margin-bottom: 10px;">
								<thead>
									<tr>
										<th colspan="4" style="padding: 13px 20px;background: #F7F7F7;border-radius: 5px 5px 5px 0px">
											<p style="color: #000;font-size: 14px;font-weight: 600;margin-bottom: 5px;">{$voucher_id}:{$title}</p>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width: 50%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$core->get_Lang("Voucher")}</td>
										<td style="width: 10%;color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;padding: 10px 0px;text-align: center">{$item.voucherGroup_id}</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px">{$price|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">{$price_total|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									</tr>
									{if $price_promotion}
									{math assign="price_promotion" equation="x * y/100" x=$discount.discount_value y=$price_total}
									<tr class="tr_promotion" style="background: #CFF4E0">
										<td colspan="2" style="width: 50%;text-align: left;color:#1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px 20px;">
											<p style="margin: 0"><span>{$core->get_Lang('Promotion')}:</span> {$discount.title}</p>
										</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;">-{$discount.discount_value}%</td>
										<td style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 10px;padding-right: 20px;">{$price_promotion|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
									</tr>
									{/if}
								</tbody>
							</table>
						</td>
					</tr>
				{/foreach}
				{/if}
					
				<tr>
					<td colspan="4">
						<table class="table_price_bill">
							<tbody><tr>
								<td class="text_price_bill" colspan="2" rowspan="5" style="color: #666;font-size: 14px!important;font-weight: 400;line-height: 21px;vertical-align: top;padding: 6px 0px">Đây là phần ghi chú khi tạo 1 invoice It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</td>
							</tr>
							<tr>
								<td class="lbl_total_price" style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 6px 10px">{$core->get_Lang('Total Price')}:</td>
								<td class="price_bill" style="width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;line-height: 21px;padding: 6px 10px;font-weight: 600">{$oneBooking.totalgrand|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
							</tr>
							<tr>
								<td class="lbl_total_price" style="width: 20%;padding: 6px 10px;text-align: right;font-size: 14px !important;">{$core->get_Lang('Deposit')}:</td>
								<td class="price_bill" style="width: 20%;padding: 6px 10px;font-size: 14px !important;text-align: right;font-weight: 600">{$deposit_bill|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
							</tr>
							<tr>
								<td class="lbl_total_price" style="width: 20%;padding: 6px 10px;text-align: right;font-size: 14px !important;">{$core->get_Lang('Collect more')}:</td>
								<td class="price_bill price_collect" style="width: 20%;padding: 6px 10px;text-align: right;font-size: 20px !important;font-weight: 600;">{$money|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
							</tr>
							<tr>
								<td class="lbl_total_price" style="width: 20%;padding: 6px 10px;text-align: right;font-size: 14px !important;">{$core->get_Lang('Final Payment')}:</td>
								<td class="price_bill price_final_payment" style="width: 20%;padding: 6px 10px;text-align: right;color: #F00;font-weight: 600;font-size: 14px !important">{$balance|number_format:0:".":" "} {$clsISO->getShortRate()}</td>
							</tr>
						</tbody></table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>								
<div class="box_text_bottom">
	<img src="{$URL_IMAGES}/icon/write.png" width="30" height="30" alt="text">
	<p class="text">(TỔNG KẾT) Bạn phải trả <span class="price_pay">{$money|number_format:0:".":" "} {$clsISO->getShortRate()}</span> bằng phương thức chuyển khoản cho nhà tổ chức du lịch trước ngày {$payment_term|date_format:"%d.%m.%Y"}. Số nợ còn lại sau khi hoàn thành thanh toán là <span class="price_subsist">{$balance|number_format:0:".":" "} {$clsISO->getShortRate()}</span></p>
</div>
{literal}
<style>
	@page {
		size: A4;
  		margin: 20px;
	}
	@page:right{ 
		@bottom-left {
			border-top: .25pt solid #666;
			content: "Our Cats";
			font-size: 9pt;
			color: #333;
		}

		@bottom-right { 
			border-top: .25pt solid #666;
			content: counter(page);
			font-size: 9pt;
		}

		@top-right {
			content:  string(doctitle);
			font-size: 9pt;
			color: #333;
		}
	}
	@page:left {
		@bottom-right {
			border-top: .25pt solid #666;
			content: "Our Cats";
			font-size: 9pt;
			color: #333;
		}

		@bottom-left { 
			border-top: .25pt solid #666;
			content: counter(page);
			font-size: 9pt;
		}
	}
@media print {
	page-break-inside:avoid;
	body{
		-webkit-print-color-adjust:exact
	}
	 .bill {
		-webkit-print-color-adjust:exact;width: 100% !important;font-style: normal;line-height: normal;display: flex;flex-wrap:wrap;
		font-family: "Times New Roman";position: relative
	}
	.bg_comp{
		width: 400px;height: 319px;position: absolute;clip-path: polygon(0 0, 100% 0, 100% 100%);background: #F7FDFD;right: 0;top:0
	}
	/*.info_bill{width: 50%;padding: 34px 0px 30px 30px}
	.info_bill h1{color: #000;font-size: 36px;font-weight: 600;margin-bottom: 10px}
	.info_bill h2{color: #000;font-family: Segoe UI;font-size: 18px;font-style: normal;font-weight: 400;line-height: normal;text-transform: uppercase}
	.info_bill .box_time{
		margin-top: 37px;display: flex;gap: 50px;flex-wrap: wrap
	}
	.info_bill .box_time .time{margin-bottom: 10px}
	.info_bill .box_time .time label{color: #666;font-size: 14px;font-weight: 400;margin-bottom:4px}
	.info_bill .box_time .time p{color: #000;font-size: 18px;font-weight: 600;margin-bottom: 0px}
	.info_bill .box_customer{margin-top: 30px;display: flex;flex-wrap: wrap}
	.info_bill .box_customer label{color: #666;font-size: 14px;font-weight: 400;margin-right: 20px}
	.info_bill .box_customer .customer{width: 272px}
	.info_bill .box_customer .customer p{color: #000;font-size: 16px;font-weight: 400;padding-bottom: 5px;border-bottom: 1px dashed #00000033;margin-bottom: 8px;}
	.info_bill .box_customer .customer .name{font-weight:600}
	.box_company{width: 50%;height: 287px;padding: 40px 22px;text-align: right;position: relative;}
	.box_company .box_info_company{width: 206px;float: right;color: #333;text-align: right;font-size: 12px;font-weight: 400}
	.box_company .box_info_company img{margin-bottom: 19px}
	.box_company .box_info_company p:not(:last-child){margin-bottom: 3px}
	.box_infoBooking{width: 100%;padding: 0px 30px}
	.box_infoBooking .table_booking{width: 100%}
	.box_infoBooking .table_booking>thead>tr>th{color: #000;font-ize:12px;font-weight: 400;text-transform: uppercase;padding: 10px 0px}
	.box_infoBooking .table_booking>thead>tr>th:first-child{width: 50%;padding: 10px 20px;text-align: left}
	.box_infoBooking .table_booking>thead>tr>th:nth-child(2){width: 10%;padding: 10px 20px;text-align: center}
	.box_infoBooking .table_booking>thead>tr>th:nth-child(3){width: 20%;padding: 10px;text-align: right}
	.box_infoBooking .table_booking>thead>tr>th:last-child{width: 20%;padding: 10px 20px;text-align: right}
	.box_infoBooking .table_booking>tbody>tr>td:last-child{padding:0}
	.box_infoBooking .table_booking .table_booking_child{width: 100%;border-radius: 5px;border: 1px solid #D9D9D9;margin-bottom: 10px}
	.box_infoBooking .table_booking .table_booking_child>thead th{padding: 13px 20px;background: #F7F7F7;border-radius: 5px 5px 5px 0px}
	.box_infoBooking .table_booking .table_booking_child>thead th .title_product{color: #000;font-size: 14px;font-weight: 600;margin-bottom: 5px}
	.box_infoBooking .table_booking .table_booking_child>thead th .duration_product{color: #000;font-size: 12px;font-weight: 400;line-height: 18px;margin-bottom: 0px}
	.box_infoBooking .table_booking .table_booking_child>tbody td{color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px}
	.box_infoBooking .table_booking .table_booking_child>tbody td:first-child{width:50%;padding: 10px 20px}
	.box_infoBooking .table_booking .table_booking_child>tbody td:nth-child(2){width:10%;padding: 0px 10px}
	.box_infoBooking .table_booking .table_booking_child>tbody td:nth-child(3){width:20%;padding: 10px}
	.box_infoBooking .table_booking .table_booking_child>tbody td:last-child{width:20%;padding: 10px 20px}
	.box_infoBooking .table_booking .table_booking_child .tr_promotion{background: #CFF4E0}
	.table_price_bill .text_price_bill{color: #666;font-size: 14px!important;font-weight: 400;line-height: 21px;vertical-align: top;padding: 6px 0px}
	.table_price_bill .lbl_total_price{width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 6px 10px}
	.table_price_bill .price_bill{width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;line-height: 21px;padding: 6px 10px;font-weight: 600}
	.table_price_bill .price_collect{font-size: 20px !important;}
	.table_price_bill .price_final_payment{color: #F00}
	.box_text_bottom{width: calc(100% - 60px);margin: 40px auto 25px;padding: 14px 20px;padding-left: 70px;border-radius: 3px;background: #f583211a;position: relative}
	.box_text_bottom img{position: absolute;left: 20px;top: 14px}
	.box_text_bottom .text{color: #333;font-size: 14px;font-weight: 400;line-height: normal;margin-bottom: 0px}*/
  }
</style>
{/literal}