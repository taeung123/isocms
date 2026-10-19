<div class="page_container">
	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('My Profile')}">
						<span itemprop="name" class="reb">{$core->get_Lang('My Profile')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<section id="contentPage" class="pageMyBooking pd40_0">
		<div class="container">
			<div class="content-info">
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
						<div class="right-category">
							<ul class="nav nav-tabs custom-tabs">
								<li class="nav-link active" id="forthcoming-tab" data-bs-toggle="tab" data-bs-target="#forthcoming" type="button" role="tab" aria-controls="forthcoming" aria-selected="true"><a>{$core->get_Lang('Sắp tới')}</a></li>
								<li class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed-tab" aria-selected="false"><a>{$core->get_Lang('Hoàn tất')}</a></li>
								<li class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled-tab" aria-selected="false"><a>{$core->get_Lang('Đã hủy')}</a></li>
							</ul>
						  	<div class="tab-content">
								<div id="forthcoming" class="tab-pane fade show active" role="tabpanel" aria-labelledby="forthcoming-tab">
									{if $lstBooking}
									{section name=bk loop=$lstBooking}
									<div class="item_booking">
										<div class="infor_booking">
											<p class="text_bold size18">{$core->get_Lang('Bookingg')} {$smarty.section.bk.iteration}</p>
											<p>{$core->get_Lang('Booking ID')} : {$lstBooking[bk].booking_code}</p>
											<p>{$core->get_Lang('Booking date')} : {$clsISO->converTimeToText5($lstBooking[bk].reg_date)} </p>
										</div>

											{$core->getBlock('cart_tour_box_my_booking')}
											{$core->getBlock('cart_voucher_box_my_booking')}
											{$core->getBlock('cart_cruise_box_my_booking')}
											{$core->getBlock('cart_hotel_box_my_booking')}
									</div>
									{/section}
									{else}
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="img-landmark">
												<img src="{$URL_IMAGES}/landmark.png">
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="title-forthcoming">
												<h2>{$core->get_Lang('Chưa có gì ở đây - hãy đặt tour đầu tiên của bạn ngày hôm nay')}!</h2>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="description-forthcoming">
												<h3>{$core->get_Lang('Chọn từ hơn 100.000 Tour du lịch (đó là hơn 100.000 cách để kiếm tiền hoa hồng!) - từ các chuyến tham quan VIP,đến các vé tham quan phải xem,đến các trải nghiệm tuyệt vời')}.</h3>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="btn-forthcoming">
												<a href="{$clsISO->getLink('search_tour')}" class="btn btn-custom btn_main" title="{$core->get_Lang('Bắt đầu Booking')}">{$core->get_Lang('Bắt đầu Booking')} </a>
											</div>
										</div>
									</div>
									{/if}
								</div>
								<div id="completed" class="tab-pane fade" role="tabpanel" aria-labelledby="completed-tab">
									{if $lstBookingTour}
										{section name=i loop=$lstBookingTour}
											{assign var=CartStore value=$clsBooking->getCartStore($lstBookingTour[i].booking_id)}
											<div class="item_booking">
											<div class="infor_booking">
												<p class="text_bold size18">{$core->get_Lang('Bookingg')} {$smarty.section.i.iteration}</p>
												<p>{$core->get_Lang('Booking ID')} : {$lstBookingTour[i].booking_code}</p>
												<p>{$core->get_Lang('Booking date')} : {$clsISO->converTimeToText5($lstBookingTour[i].reg_date)} </p>
											</div>
											{foreach from=$CartStore key=key name=item item=item}
												<div class="package_book_box mb30">
													{assign var=tour_id_z value=$item.tour_id_z}
													{assign var=title_package value=$clsTour->getTitle($tour_id_z)}
													{assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z,$tour_id_z)}
													{assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id_z)}
													{assign var=number_adult value=$item.number_adults_z}
													{assign var=number_child value=$item.number_child_z}
													{assign var=number_infant value=$item.number_infants_z}
													{assign var=price_adult value=$item.total_price_adults}
													{assign var=price_child value=$item.total_price_child}
													{assign var=price_infant value=$item.total_price_infants}
													<div class="tour_item mb30">
														<div class="info_tour border_bottom_959595">
															<div class="body_hotel {$deviceType}">
																<div class="body_left">
																	<span class="number_iteration">{$smarty.foreach.item.iteration}</span>
																</div>
																<div class="body_right">
																	<h3 class="title mb10"><a href="{$clsTour->getLink($tour_id_z)}" title="{$title_package}">{$title_package}</a></h3>
																	<p class="duration">{$clsTour->getLTripDuration($tour_id_z)}</p>
																	<div class="departure_in4">
																		<p><b>{$core->get_Lang('Depart at')} {$clsTour->getListDeparturePoint($tour_id_z)} </b> - <span class="start_date">{$clsISO->converTimeToText5($departure_date)}</span> <span class="icon_cart"></span></p> <p><b>{$core->get_Lang('Kết thúc tại')} {$clsTour->getEndCityAround($tour_id_z,1)} </b> - <span class="end_date">{$clsISO->converTimeToText5($end_date)}</span></p></div>
																</div>
															</div>
														</div>
														<div class="info_price">
															<div class="price_customers">
																<div class="item_left_price">
																	<p class="customers mb40 text-bold">{$core->get_Lang('Traveler')}</p>
																</div>
																<div class="item_center_price">
																	<div class="amount_of_people">
																		<p>{$number_adult} {$core->get_Lang('Adults')}</p>
																		<p>{if $number_child gt 0}{$number_child} {$core->get_Lang('Child')}{/if}</p>
																		<p>{if $number_infant gt 0}{$number_infant} {$core->get_Lang('Infant')}{/if}</p>
																		{if $item.promotion_z >0}
																			<p class="color_1fb69a">{$core->get_Lang('Discount')}</p>
																		{/if}
																	</div>
																	<div class="unit_price">
																		<p>{$clsISO->formatPrice($item.price_adults_z)} <span class="size14 text-underline">{$clsISO->getShortRate()}</span></p>
																		<p>{if $number_child gt 0}x {$clsISO->formatPrice($item.price_child_z)} <span class="size14 text-underline">{$clsISO->getShortRate()}</span>{/if}</p>
																		<p>{if $number_infant gt 0}x {$clsISO->formatPrice($item.price_infants_z)} <span class="size14 text-underline">{$clsISO->getShortRate()}</span>{/if}</p>
																		{if $item.promotion_z >0}
																			<p class="color_1fb69a">-{$clsISO->formatPrice($item.promotion_z)}%</p>
																		{/if}
																	</div>
																	<input type="hidden" name="number_of_guests" id="number_of_guests" value="">
																</div>
																<div class="item_right_price price_box">
																	<p>{if $price_adult gt 0}{$clsISO->formatPrice($price_adult)} <span class="size14 text-underline">{$clsISO->getShortRate()}</span></p>{/if}</p>
																	<p>{if $price_child gt 0}{$clsISO->formatPrice($price_child)} <span class="size14 text-underline">{$clsISO->getShortRate()}</span></p>{/if}</p>
																	{*<p>{if $price_child gt 0}{$clsISO->formatPrice($price_child)} <span class="size14 text-underline">{$clsISO->getShortRate()}</span></p>{/if}</p>*}
																	{if $item.promotion_z >0}
																		<p class="color_1fb69a price_promotion">-{$clsISO->formatPrice($item.price_promotion)} <span class="size14 text-underline">{$clsISO->getShortRate()}</span></p></p>
																	{/if}
																</div>
															</div>
															{if $clsISO->checkEmptyArr($item.number_addon)}
																<div class="price_service" sss="{$item.number_addon}">
																	<div class="item_left_price_service">
																		<p class="customers text-bold">{$core->get_Lang('Extra service')}</p>
																	</div>
																	<div class="item_center_price_service">

																		{foreach from=$item.number_addon key=k item=v}
																			{if $v gt 0}
																				<div class="room_service_item">
																					<p>{$v} {$clsAddOnService->getTitle($k)}</p>
																				</div>
																			{/if}
																		{/foreach}

																	</div>
																	<div class="item_right_price_service price_box">

																		{foreach from=$item.number_addon key=k item=v}
																			{assign var=price_service value=$v*$clsAddOnService->getStrPrice($k)}
																			{if $v gt 0}
																				{if $clsAddOnService->getExtra($k) eq '0'}
																					<p class="price">{$core->get_Lang('Free')}</p>
																					{*<p class="price">0 <span class="size14 text-underline">{$clsISO->getShortRate()}<span class="siz12"></span></span></p>*}
																				{else}
																					<p class="price">{$clsISO->formatPrice($price_service)} <span class="size14 text-underline">{$clsISO->getShortRate()}<span class="siz12"></span></span></p>
																				{/if}
																			{/if}
																		{/foreach}

																	</div>
																</div>
															{/if}
														</div>
														<div class="last_price_total">
															<div class="total_price">
																<p>{$core->get_Lang('Total')}</p>
																<div class="total_price_right size22"><b>{$clsISO->formatPrice($item.total_price_z)}</b> <span class="text-underline size16">{$clsISO->getShortRate()}</span></div>
															</div>

														</div>
														{if $deviceType eq 'phone'}
															{if $item.deposit gt 0}
																<div class="price_deposite">
																	<p> {$item.deposit} % {$core->get_Lang('Deposit')}</p>
																	<div class="deposits">
																		{$clsISO->formatPrice($item.price_deposit)} <span class="text-underline size16"> {$clsISO->getShortRate()}</span>
																	</div>
																</div>
															{/if}
															<div class="info_function phone">
																<div class="info_function_left">
																</div>
															</div>
														{else}
															<div class="info_function">
																<div class="info_function_left">
																</div>
																{if $item.deposit}
																	<div class="info_function_right">
																		<p> {$item.deposit} % {$core->get_Lang('Deposit')}</p>
																		<div class="deposits">
																			{$clsISO->formatPrice($item.price_deposit)} <span class="text-underline size16"> {$clsISO->getShortRate()}</span>
																		</div>
																	</div>
																{/if}
															</div>
														{/if}
													</div>
												</div>
											{/foreach}
										</div>
										{/section}
									{else}
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="img-landmark">
												<img src="{$URL_IMAGES}/landmark.png">
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="title-forthcoming">
												<h2>{$core->get_Lang('Chưa có gì ở đây - hãy đặt tour đầu tiên của bạn ngày hôm nay')}!</h2>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="description-forthcoming">
												<h3>{$core->get_Lang('Chọn từ hơn 100.000 Tour du lịch (đó là hơn 100.000 cách để kiếm tiền hoa hồng!) - từ các chuyến tham quan VIP,đến các vé tham quan phải xem,đến các trải nghiệm tuyệt vời')}.</h3>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="btn-forthcoming">
												<a href="{$clsISO->getLink('search_tour')}" class="btn btn-custom btn_main" title="{$core->get_Lang('Bắt đầu Booking')}">{$core->get_Lang('Bắt đầu Booking')} </a>
											</div>
										</div>
									</div>
									{/if}
								</div>
								<div id="cancelled" class="tab-pane fade" role="tabpanel" aria-labelledby="cancelled-tab">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="img-landmark">
												<img src="{$URL_IMAGES}/landmark.png">
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="title-forthcoming">
												<h2>{$core->get_Lang('Chưa có gì ở đây - hãy đặt tour đầu tiên của bạn ngày hôm nay')}!</h2>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="description-forthcoming">
												<h3>{$core->get_Lang('Chọn từ hơn 100.000 Tour du lịch (đó là hơn 100.000 cách để kiếm tiền hoa hồng!) - từ các chuyến tham quan VIP,đến các vé tham quan phải xem,đến các trải nghiệm tuyệt vời')}.</h3>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="btn-forthcoming">
												<a href="{$clsISO->getLink('search_tour')}" class="btn btn-custom btn_main" title="{$core->get_Lang('Bắt đầu Booking')}">{$core->get_Lang('Bắt đầu Booking')} </a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	</section>
</div>
{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			$(document).ready(function(){
				$('.fileinput-exists').click(function(){
					$('.btn-update').show();
				});
				$('.it-head-iti').click(function(){
					$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
					$(this).next().slideToggle();
				});
			});
		})
	</script>
{/literal}
