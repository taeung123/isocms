	
{literal}
	<style>
		@page {
			size: A4;
			margin: 20px;
		}
		@media print {
			page-break-inside:avoid;
			.bill {
				width: 100% !important;font-style: normal;line-height: normal;
				font-family: "Times New Roman";
			}
			body{
				-webkit-print-color-adjust:exact;
			}
			.info_bill td * {
				margin-top: 0 !important;
				margin-bottom: 0 !important;
			}
			.box_infoBooking{background:unset}
			
		}
		@media screen{
			.bill{
				font-family: Segoe UI;
			}
		}
		.bill {width: 100% !important;font-style: normal;line-height: normal;display: inline-table}
		.bg_comp{width: 380px;height: 310px;position: absolute;right: 0;top:0}
		.bg_comp:after {content: "";width: 0;height: 0;position: absolute;left: 0;top: 0;border-top: 310px solid #F7FDFD;border-bottom: 0px solid #F7FDFD;border-left: 380px solid #FFF}
		.info_bill .box_time td {padding: 0}
		.info_bill .box_time td:not(:last-child) {padding-right: 50px}
		.box_customer td {vertical-align: top;padding: 0}
		.box_head_bill{width: 100%;float: left}
		.info_bill{width: 55%;padding: 34px 0px 30px;float: left}
		.info_bill h1{color: #000;font-size: 36px;font-weight: 600;margin:0px;margin-bottom: 10px}
		.info_bill .title_bill{color: #000;font-size: 18px;font-style: normal;font-weight: 400;line-height: normal;text-transform: uppercase;margin:0px}
		.info_bill .box_time{margin-top: 37px;clear: both}
		.info_bill .box_time .time{margin-bottom: 10px}
		.info_bill .box_time .time:not(:last-child) {margin-right: 50px}
		.info_bill .box_time .time label{color: #666;font-size: 14px;font-weight: 400;line-height: normal;margin-bottom:4px}
		.info_bill .box_time .time p{color: #000;font-size: 18px;font-weight: 600;line-height: normal;margin: 0px}
		.info_bill .box_customer{margin-top: 30px;clear: both}
		.info_bill .box_customer label{color: #666;font-size: 14px;font-weight: 400;margin-right: 20px}
		.info_bill .box_customer .customer{width: 272px}
		.info_bill .box_customer .customer p{color: #000;font-size: 16px;font-weight: 400;padding-bottom: 5px;border-bottom: 1px dashed #00000033;margin:0px;margin-bottom: 8px;}
		.info_bill .box_customer .customer .ip_cus {width: 100%;border: 0px;padding: 0;padding-bottom: 5px;border-bottom: 1px dashed #00000033;color: #000;font-size: 16px}
		.info_bill .box_customer .customer .ip_cus:not(:first-child) {padding-top: 8px}
		.info_bill .box_customer .customer .name{font-weight:600}
		.box_company{width: 45%;height: 287px;padding: 40px 0px;text-align: right;position: relative;float: right}
		.box_company .box_info_company{width: 206px;float: right;color: #333;text-align: right;font-size: 12px;font-weight: 400}
		.box_company .box_info_company img{margin-bottom: 19px}
		.box_company .box_info_company p {margin: 0}
		.box_company .box_info_company p:not(:last-child){margin-bottom: 3px}
		.box_infoBooking{width: 100%;padding: 0px 30px;clear:both}
		.box_infoBooking .table_booking{width: 100%;clear: both}
		.box_infoBooking .table_booking>thead>tr>th{color: #000;font-size:12px;font-weight: 400;text-transform: uppercase;padding: 10px 0px}
		.box_infoBooking .table_booking>thead>tr>th:first-child{width: 50%;padding: 10px 20px;text-align: left}
		.box_infoBooking .table_booking>thead>tr>th:nth-child(2){width: 10%;padding: 10px 0px;text-align: center}
		.box_infoBooking .table_booking>thead>tr>th:nth-child(3){width: 20%;padding: 10px;text-align: right}
		.box_infoBooking .table_booking>thead>tr>th:last-child{width: 20%;padding: 10px 20px;text-align: right}
		.box_infoBooking .table_booking>tbody>tr>td:last-child{padding:0}
		.box_infoBooking .table_booking .table_booking_child{width: 100%;border-radius: 5px;border: 1px solid #D9D9D9;margin-bottom: 10px;border-collapse: collapse}
		.box_infoBooking .table_booking .table_booking_child>thead tr th{padding: 13px 20px;background: #F7F7F7;border-radius: 5px 5px 5px 0px;text-align: left}
		.box_infoBooking .table_booking .table_booking_child>thead tr th .title_product{color: #000;font-size: 14px;font-weight: 600;margin:0px;margin-bottom: 5px;line-height: normal}
		.box_infoBooking .table_booking .table_booking_child>thead tr th .duration_product{color: #000;font-size: 12px;font-weight: 400;line-height: 18px;margin: 0px}
		.box_infoBooking .table_booking .table_booking_child>tbody tr td{color: #1C1C1C;font-size: 14px!important;font-weight: 400;line-height: 21px;text-align: left}
		.box_infoBooking .table_booking .table_booking_child>tbody tr td:nth-child(1){width:50%;padding: 10px 20px;text-align: left}
		.box_infoBooking .table_booking .table_booking_child>tbody tr td:nth-child(2){width:10%;padding: 0px 10px;text-align:center}
		.box_infoBooking .table_booking .table_booking_child>tbody tr td:nth-child(3){width:20%;padding: 10px;text-align:right}
		.box_infoBooking .table_booking .table_booking_child>tbody tr td:last-child{width:20%;padding: 10px 20px 10px 10px;text-align:right}
		.box_infoBooking .table_booking .table_booking_child>tbody tr.tr_promotion td:first-child {width: 60%;text-align:left;padding: 10px 20px;}
		.box_infoBooking .table_booking .table_booking_child>tbody tr.tr_promotion td:nth-child(2),.box_infoBooking .table_booking .table_booking_child>tbody tr.tr_promotion td:nth-child(3){width:20%;text-align:right}
		.box_infoBooking .table_booking .table_booking_child .tr_promotion{background: #CFF4E0}
		.box_infoBooking .table_booking .table_booking_child .tr_promotion p {margin: 0px}
		.table_price_bill {width: 100%}
		.table_price_bill td {vertical-align: top}
		.table_price_bill .text_price_bill{color: #666;font-size: 14px!important;font-weight: 400;line-height: 21px;vertical-align: top;padding: 6px 0px}
		.table_price_bill .lbl_total_price{width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;font-weight: 400;line-height: 21px;padding: 6px 10px}
		.table_price_bill .price_bill{width: 20%;text-align: right;color: #1C1C1C;font-size: 14px !important;line-height: 21px;padding: 6px 10px;font-weight: 600}
		.table_price_bill .price_collect{font-size: 20px !important;}
		.table_price_bill .price_final_payment{color: #F00}
		.box_text_bottom{width: 100%;margin: 40px auto 25px;padding: 14px 20px;padding-left: 70px;border-radius: 3px;    background: #f583211a url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAJcSURBVHgBzZftbdswEIbvSDdAECdVN2AzgbuBs0G9QTNB7N+FGzpGB+gE9QZxJ4i7gTpBuEGExOkHUPJ6lGSXrhXZslTEL2CIoig+Ot7xjgZ4JmF48zhWb7nrkpsdaE6xBRqdDM20EHynlTqQeMvNhHgwNCQBoHg+5YDOjodmtuhvLRsIfX8lS2dtbRoDP4xVVwDeoANeTZgFH5SJTY/89aiFd9CgFlaiFC/DfgHPpFbZw7lWHZR4DdWUsD8HoT+LVGoxSYgIKOEWVPhFIndbmUotzr/6DfwH7aePvX7w/oYK+sk+fqVNsmlcKfieM5mDasF1wL/5lTpvfzAT2BX8wkLsWjiBipKWZuE9B2gsHH3bGnyojeHLOdRUe2jWAnQ/g4sLRyRFmmPX5SA50asVJ9T38ekFJxKdp2LDFWoQVqhSsJTQlYCfix9y8GnVK4I/jk8vKYNydOMUgTo8zzUXjGWFKgVby9VEUo+jozATHQfVJoRCBjXIle5Q35qiClUKzvfjFLbUAurbPnn+yvtRsOVudWxjwRVayr79xF3+YHHzoFUXXZYLSPw1ohHwv8vLfuwzfOThguH+ys9HYcWqDV73abr34beFCaTB5UWjo6HR4Xu1wE9B8/ObtzQqgtYCbwFVT0FrgXnS/q7QncHzj8qfuyPn6Msu0BUw5YEwJ3oNG+Scnxz80dSk7/DZrAo0ezXXIruAXz7IJlwDChq035v4/kq9k5imUsMfHOHyjLUd1GuZufwe48Lf4yXgoMFu4Wib/rWJrYOpkHSBgIphhlNTTM593VT890J/ALhFMI4WxL66AAAAAElFTkSuQmCC) no-repeat;background-position:20px}
		.box_text_bottom img{position: absolute;left: 20px;top: calc(50% - 15px)}
		.box_text_bottom .text{color: #333;font-size: 14px;font-weight: 400;line-height: normal;margin: 0px}
		.price_pay {font-weight: 600}
		.price_subsist {color: #F00}
	</style>
	{/literal}
	<div class="bill">
		<div class="box_infoBooking">			
			<div class="box_head_bill">
			<div class="bg_comp"></div>
				<div class="info_bill">
					<h1>#{$max_id}</h1>
					<p class="title_bill">{$core->get_Lang('Bill')}</p>
					<div class="box_time">
						<table>
							<tr>
								<td>
									<div class="time">
										<label for="">{$core->get_Lang('Release date')}</label>
										<p>{$smarty.now|date_format:"%d.%m.%Y"}</p>
									</div>
								</td>
								{if $payment_term gt 0 }
								<td>									
									<div class="time">
										<label for="">{$core->get_Lang('Payments term')}</label>
										<p>{$payment_term|date_format:"%d.%m.%Y"}</p>
									</div>
								</td>
								{/if}
								<td>	
									<div class="time">
										<label for="">{$core->get_Lang('Code')}</label>
										<p>{$bill_code}</p>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="box_customer">
						<table>
							<tr>
								<td><label for="">{$core->get_Lang('Recipient')}</label></td>
								<td>
									{if $checkEdit}
										<div class="customer" id="info_customer">
											<input type="text" class="ip_cus name" value="{$customer_name}" name="name_customer">
											<input type="email" class="ip_cus email" value="{$customer_email}" name="email_customer">
											<input type="text" class="ip_cus phone" value="{$customer_phone}" name="phone_customer">
										</div>
									{else}
										<div class="customer">
											<p class="name">{$customer_name}</p>
											<p>{$customer_email}</p>
											<p>{$customer_phone}</p>
										</div>
									{/if}
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="box_company">
					<div class="box_info_company">
						<img src="https://isocms.com/admin/isocms/templates/default/skin/images/logo_bill.png" alt="">
						{assign var=address value=CompanyAddress_|cat:$_LANG_ID}
						<p>{$clsConfiguration->getValue($address)}</p>
						<p>{$clsConfiguration->getValue('CompanyEmail')}</p>
						<p>{$clsConfiguration->getValue('CompanyPhone')}</p>
					</div>
				</div>
			</div>
			<table class="table_booking">
				<thead>
					<tr>
						<th>{$core->get_Lang("Service")}</th>
						<th>{$core->get_Lang('Quantily')}</th>
						<th>{$core->get_Lang('Unit price')}</th>
						<th>{$core->get_Lang('Total price')}</th>
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
						<tr>
							<td colspan="4">
							<table class="table_booking_child">
								<thead>
									<tr>
										<th colspan="4">
											<p class="title_product">{$tour_id}:[{$Depart_point}-{$address}] {$title}</p>
											<p class="duration_product">({$item.check_in_book_z|replace:"-":"/"} - {$clsISO->converTimeToText6($clsTour->getTextEndDate($item.check_in_book_z,$tour_id))})</p>
										</th>
									</tr>
								</thead>
								<tbody>
									{if $item.number_adults_z}
									<tr>
										<td style="text-align: left;width:50%;padding: 10px 20px">{$core->get_Lang("Adult")}</td>
										<td style="text-align: center;width:10%">{$item.number_adults_z}</td>
										<td style="text-align: right;width:20%">{$item.price_adults_z|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
										<td style="text-align: right;width:20%">{$item.total_price_adults|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
									</tr>
									{/if}
									{if $item.number_child_z}
									<tr>
										<td style="text-align: left;width:50%;padding: 10px 20px">{$core->get_Lang("Child")}</td>
										<td style="text-align: center;width:10%">{$item.number_child_z}</td>
										<td style="text-align: right;width:20%">{$item.price_child_z|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
										<td style="text-align: right;width:20%">{$item.total_price_child|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
									</tr>
									{/if}
									{if $item.number_infants_z}
									<tr>
										<td style="text-align: left;width:50%;padding: 10px 20px">{$core->get_Lang("Infants")}</td>
										<td style="text-align: center;width:10%">{$item.number_infants_z}</td>
										<td style="text-align: right;width:20%">{$item.price_infants_z|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
										<td style="text-align: right;width:20%">{$item.total_price_infants|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
									</tr>
									{/if}
									{if $item.number_addon}
									{foreach from=$item.number_addon item=item_addon key=k}
									{assign var=oneService value=$clsAddOnService->getOne($k,'addonservice_id,title,price')}
									{math assign="price_addon" equation="x * y" x=$item_addon y=$oneService.price}
									<tr>
										<td style="text-align: left;width:50%;padding: 10px 20px">{$oneService.title}</td>
										<td style="text-align: center;width:10%">{$item_addon}</td>
										<td style="text-align: right;width:20%">{$oneService.price|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
										<td style="text-align: right;width:20%">{$price_addon|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
									</tr>
									{/foreach}
									{/if}
									{if $item.promotion_z && $item.promotion_z > 0}
										{if $item.discount_type eq 2}
											<tr class="tr_promotion">
												<td colspan="2" style="text-align: left;width:60%;padding:10px 20px">
													<p><span>{$core->get_Lang('Promotion')}:</span> {$discount.title}</p>
												</td>
												<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.promotion_z}%</td>
												<td style="text-align: right;width:20%">{$item.price_promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
											</tr>
										{else if $item.discount_type eq 1}
											<tr class="tr_promotion">
												<td colspan="2" style="text-align: left;width:60%;padding:10px 20px">
													<p><span>{$core->get_Lang('Promotion')}:</span> {$discount.title}</p>
												</td>
												<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.price_promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
												<td style="text-align: right;width:20%">{$item.price_promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
											</tr>
										{/if}
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
						<tr>
							<td colspan="4" style="padding: 0">
								<table class="table_booking_child">
									<thead>
										<tr>
											<th colspan="4">
												<p class="title_product">{$hotel_id}:{$title}</p>
												<p class="duration_product">({$clsISO->converTimeToText6($item.check_in)} - {$clsISO->converTimeToText6($item.check_out)})</p>
											</th>
										</tr>
									</thead>
									<tbody>
										{foreach from=$item.room item=item_room name=k}
										{math assign="price" equation="x * y" x=$item_room.number_room y=$item_room.totalprice}
										<tr>
											<td style="text-align: left;width:50%;padding: 10px 20px">{$clsHotelRoom->getTitle($item_room.hotel_room_id)}</td>
											<td style="text-align: center;width:10%">{$item_room.number_room}</td>
											<td style="text-align: right;width:20%">{$item_room.totalprice|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
											<td style="text-align: right;width:20%">{$price|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
										</tr>
										{/foreach}

										{if $item.promotion && $item.promotion > 0}
											{if $item.discount_type eq 2}
												<tr class="tr_promotion" style="background: #CFF4E0">
													<td colspan="2" style="text-align: left;width:60%; padding:10px 20px">
														<p><span>{$core->get_Lang('Promotion')}:</span> {$item.title}</p>
													</td>
													<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.promotion}%</td>
													<td style="text-align: right;width:20%">{$item.totalPricePromotionHotel|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
												</tr>
											{else}
												<tr class="tr_promotion" style="background: #CFF4E0">
													<td colspan="2" style="text-align: left;width:60%; padding:10px 20px">
														<p><span>{$core->get_Lang('Promotion')}:</span> {$item.title}</p>
													</td>
													<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
													<td style="text-align: right;width:20%">{$item.promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
												</tr>
											{/if}
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
						<tr>
							<td colspan="4">
								<table class="table_booking_child">
									<thead>
										<tr>
											<th colspan="4">
												<p class="title_product">{$cruise_id}:{$title}</p>
												<p class="duration_product">({$clsISO->converTimeToText6($item.departure_date)} - {$clsISO->converTimeToText6($clsCruiseItinerary->getTextEndDate($item.departure_date,$item.cruise_itinerary_id))})</p>
											</th>
										</tr>
									</thead>
									<tbody>
										{foreach from=$item.cabin item=item_cabin name=k}
										<tr>
											<td style="text-align:left;width:50%;padding:10px 20px">{$clsCruiseCabin->getTitle($item_cabin.cruise_cabin_id)}</td>
											<td style="text-align: center;width:10%">{$item_cabin.number_cabin}</td>
											<td style="text-align: right;width:20%">{$item_cabin.totalprice|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
											<td style="text-align: right;width:20%">{$item_cabin.totalprice|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
										</tr>
										{/foreach}
										
										{if $item.promotion && $item.promotion > 0}										
											{if $item.discount_type eq 2}
												{math assign="pricePromotion" equation="x * y/100" x=$item.promotion y=$item.totalpriceCabin}
												<tr class="tr_promotion">
													<td colspan="2" style="text-align: left;width:60%; padding:10px 20px">
														<p><span>{$core->get_Lang('Promotion')}:</span> {$item.title}</p>
													</td>
													<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.promotion}%</td>
													<td style="text-align: right;width:20%">{$item.totalPricePromotionCruise|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
												</tr>
											{else}
												<tr class="tr_promotion">
													<td colspan="2" style="text-align: left;width:60%; padding:10px 20px">
														<p><span>{$core->get_Lang('Promotion')}:</span> {$item.title}</p>
													</td>
													<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
													<td style="text-align: right;width:20%">{$item.promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
												</tr>
											{/if}
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
						<tr>
							<td colspan="4">
								<table class="table_booking_child">
									<thead>
										<tr>
											<th colspan="4">
												<p class="title_product">{$voucher_id}:{$title}</p>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="text-align:left;width:50%;padding: 10px 20px">{$core->get_Lang("Voucher")}</td>
											<td style="text-align: center;width:10%">{$item.voucherGroup_id}</td>
											<td style="text-align: right;width:20%">{$price|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
											<td style="text-align: right;width:20%">{$price_total|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
										</tr>
										{if $item.discount_value && $item.discount_value > 0}
											{math assign="price_promotion" equation="x * y* z/100" x=$item.discount_value y=$item.voucherGroup_id z=$item.voucher_price_z}
											{if $item.discount_type eq 2}
												<tr class="tr_promotion">
													<td colspan="2" style="text-align: left;width:60%;padding:10px 20px">
														<p><span>{$core->get_Lang('Promotion')}:</span> {$item.title}</p>
													</td>
													<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.discount_value}%</td>
													<td style="text-align: right;width:20%">{$price_promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
												</tr>
											{else}
												<tr class="tr_promotion">
													<td colspan="2" style="text-align: left;width:60%;padding:10px 20px">
														<p><span>{$core->get_Lang('Promotion')}:</span> {$item.title}</p>
													</td>
													<td style="text-align: right;padding: 0px 10px;width:20%">-{$item.discount_value|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
													<td style="text-align: right;width:20%">{$price_promotion|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
												</tr>
											{/if}
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
								<tbody>
								<tr>
									<td class="text_price_bill" colspan="2" rowspan="5">{$note}</td>
								</tr>
								<tr>
									<td class="lbl_total_price">{$core->get_Lang('Total Price')}:</td>
									<td class="price_bill">{$totalgrand|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
								</tr>
								<tr>
									<td class="lbl_total_price">{$core->get_Lang('Deposit')}:</td>
									<td class="price_bill">{$deposit_bill|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
								</tr>
								<tr>
									<td class="lbl_total_price">{$core->get_Lang('Collect more')}:</td>
									<td class="price_bill price_collect" style="width: 20%;padding: 6px 10px;text-align: right;font-size: 20px !important;font-weight: 600;">{$money|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
								</tr>
								<tr>
									<td class="lbl_total_price">{$core->get_Lang('Final Payment')}:</td>
									<td class="price_bill price_final_payment">{$balance|number_format:0:".":" "} {$clsISO->getShortRateText()}</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
				</tbody>
			</table>							
			<div class="box_text_bottom">
				<p class="text">(TỔNG KẾT) Bạn phải trả <span class="price_pay">{$money|number_format:0:".":" "} {$clsISO->getShortRateText()}</span> bằng phương thức <span class="price_pay">{$payment_method}</span> cho nhà tổ chức du lịch trước ngày <span class="price_pay">{$payment_term|date_format:"%d.%m.%Y"}</span>. Số nợ còn lại sau khi hoàn thành thanh toán là <span class="price_subsist">{$balance|number_format:0:".":" "} {$clsISO->getShortRateText()}</span></p>
			</div>
		</div>
	</div>
