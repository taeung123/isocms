<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_member'}
						{$core->getBlock('box_detail_image_avatar')}
						{elseif $currentstep=='profile'}
						<h3 class="title_box">{$core->get_Lang('Profile')}</h3>
						
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('First name')}
							{* <span class="required_red">*</span>
							{assign var= first_name_member value='first_name_member'}
							{assign var= help_first value=$first_name_member}
							{if $CHECKHELP eq 1}
							<button data-key="{$first_name_member}" data-label="{$core->get_Lang('First name')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}*}
							</label>
							<input class="text_32 full-width bold border_aaa title_capitalize" name="iso-first_name" value="{$oneItem.first_name}" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($first_name_member)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Last name')}
							{* <span class="required_red">*</span>
							{assign var= last_name_member value='last_name_member'}
							{if $CHECKHELP eq 1}
							<button data-key="{$last_name_member}" data-label="{$core->get_Lang('Last name')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							*}
							</label>
							<input class="text_32 full-width bold border_aaa title_capitalize" name="iso-last_name" value="{$oneItem.last_name}" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($last_name_member)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Email')}
							{* <span class="required_red">*</span>
							{assign var= email_member value='email_member'}
							{if $CHECKHELP eq 1}
							<button data-key="{$email_member}" data-label="{$core->get_Lang('Email')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							*}
							</label>
							<input class="text_32 full-width bold border_aaa" name="iso-email" value="{$oneItem.email}" type="email" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($email_member)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Phone Number')}
							{* <span class="required_red">*</span>
							{assign var= phone_member value='phone_member'}
							{if $CHECKHELP eq 1}
							<button data-key="{$phone_member}" data-label="{$core->get_Lang('Phone Number')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							*}
							</label>
							<input class="text_32 full-width bold border_aaa" name="iso-phone" value="{$oneItem.phone}" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($phone_member)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Organisation')}
							{* <span class="required_red">*</span>
							{assign var= organisation_member value='organisation_member'}
							{if $CHECKHELP eq 1}
							<button data-key="{$organisation_member}" data-label="{$core->get_Lang('Organisation')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							*}
							</label>
							<input class="text_32 full-width bold border_aaa" name="organisation" value="{$oneItem.organisation}" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($organisation_member)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Address')}
							{* <span class="required_red">*</span>
							{assign var= address_member value='address_member'}
							{if $CHECKHELP eq 1}
							<button data-key="{$address_member}" data-label="{$core->get_Lang('Address')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							*}
							</label>
							<input class="text_32 full-width bold border_aaa" name="iso-address" value="{$oneItem.address}" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($address_member)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Country')}
							{* <span class="required_red">*</span>
							{assign var= country_member value='country_member'}
							{if $CHECKHELP eq 1}
							<button data-key="{$country_member}" data-label="{$core->get_Lang('Country')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							*}
							</label>
							<input class="text_32 full-width bold border_aaa" name="" value="" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($country_member)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Postal code')}
							{* <span class="required_red">*</span>
							{assign var= postalCode_member value='postalCode_member'}
							{if $CHECKHELP eq 1}
							<button data-key="{$postalCode_member}" data-label="{$core->get_Lang('Postal code')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							*}
							</label>
							<input class="text_32 full-width bold border_aaa" name="iso-state" value="{$oneItem.state}" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($postalCode_member)|html_entity_decode}</div>
						</div>
						
						{elseif $currentstep=='booking'}
							<div class="inpt_tour">
								<h3 class="title_box">{$core->get_Lang('Bookings')}</h3>
								{if $totalBooking gt '0'}
									{if $lstBookingHotel}
										<h3>{$core->get_Lang('List Hotel Booking')}</h3>
										{section name=i loop=$lstBookingHotel}
											{assign var=hotel_id value=$clsBooking->getServiceID($lstBookingHotel[i].booking_id,'hotel')}
											<div class="bookingItem">
												<div class="bookingTop">
													<div class="row">
														<div class="col-sm-3">
															<div class="pic_hotel hotel" {$hotel_id}>
																<img src="{$clsHotel->getImage($hotel_id,193,129)}" class="static" width="90" height="60" alt="{$clsHotel->getTitle($hotel_id)}" style="height: 60px; width: 90px;">
															</div>
														</div>
														<div class="col-sm-9">
															<div class="detail_hotel_booking">
																<p class="content_blue">
																	<b>
																		<a class="hotelLinks" href="{$clsHotel->getLink($hotel_id)}" title="{$clsHotel->getTitle($hotel_id)}">{$clsHotel->getTitle($hotel_id)}</a>
																	</b>
																</p>
																{if $clsHotel->getAddress($hotel_id) ne ''}
																	<p class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($hotel_id)}</p>
																{/if}
																<div class="clear">&nbsp;</div>
															</div>
														</div>
													</div>
												</div>
												<div class="clear"></div>
												<div class="allbox">
													{assign var=Store_Hotel value=$clsBooking->getBookingValue($lstBookingHotel[i].booking_id)}
													<div class="date_hotel_booking mb10">
														<p>
															<span class="date_hotel_on">{$core->get_Lang('Booked on')}</span>
															<span class="date_hotel">{$clsISO->converTimeToText($clsBooking->getOneField('reg_date',$lstBookingHotel[i].booking_id))}</span>
														</p>
													</div>
													<div class="row">
														<div class="allbox_left col-sm-8">
															<p class="booking_left">
																{$core->get_Lang('Booking ID')}
															</p>
															<p class="booking_right">
																{$clsBooking->getOneField('booking_code',$lstBookingHotel[i].booking_id)}
															</p>
															<div class="clear"></div>
															<p class="booking_left">
																{$core->get_Lang('Check-in')}:
															</p>
															<p class="booking_right">

																<span>{$Store_Hotel.checkin}</span>
															</p>
															<div class="clear"></div>
															<p class="booking_left">
																{$core->get_Lang('Check-out')}:
															</p>
															<p class="booking_right">
																<span>{$Store_Hotel.checkout}</span>
															</p>
															<div class="clear"></div>
														</div>
														<div class="allbox_right col-sm-4">
															<p>
																<span class="money_hotel">{$clsHotel->getPrice($hotel_id)}</span>
															</p>
															<div>
																<p class="text_conditions">
																	<span title="Any cancellation received within 1 day prior to arrival date will incur the first night charge. Failure to arrive at your hotel will be treated as a No-Show and will incur the first night charge (Hotel policy).">{$core->get_Lang('Booking Conditions')} <i class="ficon ficon-10 ficon-hover-details"></i></span>
																</p>
															</div>
															<a class="fr mt10" href="{$PCMS_URL}/?mod={$mod}&act=viewbooking&booking_id={$core->encryptID($lstBookingHotel[i].booking_id)}" title="{$core->get_Lang('View Booking')}">{$core->get_Lang('View Booking')}</a>
														</div>
													</div>
												</div>
											</div>
										{/section}
									{/if}
									{if $lstBookingTour}
										<div class="cleafix mb30"></div>

										<h3>{$core->get_Lang('List Tour Booking')}</h3>
										{section name=i loop=$lstBookingTour}											
											{assign var=cart_store_Tour value=$clsBooking->getCartStoreBooking($lstBookingTour[i].booking_id,"TOUR")}
											{foreach name=j from=$cart_store_Tour item=item}
												{assign var=tour_id value=$item.tour_id_z}
												{if $tour_id gt 0}
												{assign var=cityAround value=$clsTour->getLCityAround($tour_id)}
													<div class="bookingItem" {$lstBookingTour[i].booking_id}>
														<div class="bookingTop">
															<div class="row">
																<div class="col-sm-3">
																	<div class="pic_hotel tour" {$tour_id}>
																		<img src="{$clsTour->getImage($tour_id,193,129)}" class="static" width="90" height="60" alt="{$clsTour->getTitle($tour_id)}" onerror="this.src='{$URL_IMAGES}/none_image.png';" style="height: 60px; width: 90px;">
																	</div>
																</div>
																<div class="col-sm-9">
																	<div class="detail_hotel_booking">
																		<p class="content_blue">
																			<b>
																				<a class="hotelLinks" href="{$clsTour->getLink($tour_id)}" title="{$clsTour->getTitle($tour_id)}">{$clsTour->getTitle($tour_id)}</a>
																			</b>
																		</p>
																		{if $cityAround ne ''}
																			<p class="address"><i class="fa fa-map-marker"></i> {$cityAround}</p>
																		{/if}
																		<div class="clear">&nbsp;</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="clear"></div>
														<div class="allbox">
															{assign var=Store_Tour value=$clsBooking->getBookingValue($lstBookingTour[i].booking_id)}
															<div class="date_hotel_booking mb10">
																<p>
																	<span class="date_hotel_on">{$core->get_Lang('Booked on')}</span>
																	<span class="date_hotel">{$clsISO->converTimeToText($clsBooking->getOneField('reg_date',$lstBookingTour[i].booking_id))}</span>
																</p>
															</div>
															<div class="row">
																<div class="allbox_left col-sm-8">
																	<p class="booking_left">
																		{$core->get_Lang('Booking ID')}
																	</p>
																	<p class="booking_right">
																		{$clsBooking->getOneField('booking_code',$lstBookingTour[i].booking_id)}
																	</p>
																	<div class="clear"></div>
																	<p class="booking_left">
																		{$core->get_Lang('Check-in')}:
																	</p>
																	<p class="booking_right">
																		<span>{$clsISO->converTimeToText7($item.check_in_book_z,$tour_id)}</span>
																	</p>
																	<div class="clear"></div>
																	<p class="booking_left">
																		{$core->get_Lang('Check-out')}:
																	</p>
																	<p class="booking_right">
																		<span>{$clsISO->converTimeToText5($clsTour->getTextEndDate($item.check_in_book_z,$tour_id))}</span>
																	</p>
																	<div class="clear"></div>
																</div>
																<div class="allbox_right col-sm-4">
																	<p>	
																		{if $_LANG_ID eq 'vn'}
																		<span class="money_hotel">{$clsISO->priceFormat($item.total_price_z)} {$clsISO->getRate()}</span>
																		{else}
																			<span class="money_hotel">{$clsISO->getRate()}{$clsISO->priceFormat($item.total_price_z)}</span>
																		{/if}
																	</p>
																	<div>
																		<p class="text_conditions">
																			<span title="Any cancellation received within 1 day prior to arrival date will incur the first night charge. Failure to arrive at your hotel will be treated as a No-Show and will incur the first night charge (Hotel policy).">{$core->get_Lang('Booking Conditions')} <i class="ficon ficon-10 ficon-hover-details"></i></span>
																		</p>
																	</div>
																	<a class="fr mt10" href="{$PCMS_URL}/?mod=booking&act=edit&booking_id={$core->encryptID($lstBookingTour[i].booking_id)}" title="{$core->get_Lang('View Booking')}">{$core->get_Lang('View Booking')}</a>
																</div>
															</div>
														</div>
													</div>
												{/if}
											{/foreach}
										{/section}
									{/if}
									{if $lstBookingCruise}
										<div class="cleafix mb30"></div>
										<h3>{$core->get_Lang('List Cruise Booking')}</h3>
										{section name=i loop=$lstBookingCruise}
											{assign var=cruise_id value=$clsBooking->getServiceID($lstBookingCruise[i].booking_id,'cruise')}
											<div class="bookingItem">
												<div class="bookingTop">
													<div class="row">
														<div class="col-sm-3">
															<div class="pic_hotel cruise" {$cruise_id}>
																<img src="{$clsCruise->getImage($cruise_id,193,129)}" class="static" width="90" height="60" alt="{$clsCruise->getTitle($cruise_id)}" style="height: 60px; width: 90px;">
															</div>
														</div>
														<div class="col-sm-9">
															<div class="detail_hotel_booking">
																<p class="content_blue">
																	<b>
																		<a class="hotelLinks" href="{$clsCruise->getLink($cruise_id)}" title="{$clsCruise->getTitle($cruise_id)}">{$clsCruise->getTitle($cruise_id)}</a>
																	</b>
																</p>
																{if $clsCruise->getCityAround($cruise_id) ne ''}
																	<p class="address"><i class="fa fa-map-marker"></i> {$clsCruise->getCityAround($cruise_id)}</p>
																{/if}
																<div class="clear">&nbsp;</div>
															</div>
														</div>
													</div>
												</div>
												<div class="clear"></div>
												<div class="allbox">
													{assign var=Store_Cruise value=$clsBooking->getBookingValue($lstBookingCruise[i].booking_id)}
													<div class="date_hotel_booking mb10">
														<p>
															<span class="date_hotel_on">{$core->get_Lang('Booked on')}</span>
															<span class="date_hotel">{$clsISO->converTimeToText($clsBooking->getOneField('reg_date',$lstBookingCruise[i].booking_id))}</span>
														</p>
													</div>
													<div class="row">
														<div class="allbox_left col-sm-8">
															<p class="booking_left">
																{$core->get_Lang('Booking ID')}
															</p>
															<p class="booking_right">
																{$clsBooking->getOneField('booking_code',$lstBookingCruise[i].booking_id)}
															</p>
															<div class="clear"></div>
															<p class="booking_left">
																{$core->get_Lang('Check-in')}:
															</p>
															<p class="booking_right">
																<span>{$Store_Cruise.departure_date}</span>
															</p>
															<div class="clear"></div>
															<p class="booking_left">
																{$core->get_Lang('Check-out')}:
															</p>
															<p class="booking_right">
																<span>{$clsBooking->getOneField('check_out',$lstBookingCruise[i].booking_id)}</span>
															</p>
															<div class="clear"></div>
															<p class="booking_left">
																{$core->get_Lang('Cabin of name')}:
															</p>
															<p class="booking_right">
																{$clsCruiseCabin->getTitle($Store_Cruise.cruise_cabin_id)}
															</p>
															<div class="clear"></div>
															<p class="booking_left">
																{$core->get_Lang('Number of Cabin')}
															</p>
															<p class="booking_right">
																{$Store_Cruise.number_room}
															</p>
															<div class="clear"></div>
														</div>
														<div class="allbox_right col-sm-4">
															<p>
																<span class="money_hotel">{$clsISO->getRate()} {$Store_Cruise.totalGrand}</span>
															</p>
															<div>
																<p class="text_conditions">
																	<span title="Any cancellation received within 1 day prior to arrival date will incur the first night charge. Failure to arrive at your hotel will be treated as a No-Show and will incur the first night charge (Hotel policy).">{$core->get_Lang('Booking Conditions')} <i class="ficon ficon-10 ficon-hover-details"></i></span>
																</p>
															</div>
															<a class="fr mt10" href="{$PCMS_URL}/?mod={$mod}&act=viewbooking&booking_id={$core->encryptID($lstBookingCruise[i].booking_id)}" title="{$core->get_Lang('View Booking')}">{$core->get_Lang('View Booking')}</a>
														</div>
													</div>
												</div>
											</div>

										{/section}
									{/if}
								{else}
									{$core->get_Lang('No Data!')}
								{/if}
							</div>
						{elseif $currentstep=='reviewsPhoto'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Tour Reviews &amp; Photos')}</h3>						
							{if $totalReviews gt '0'}
								{section name=i loop=$lstReviewsTour}
									<div class="bookingItem">
										<div class="bookingTop">
											<div class="row">
												<div class="col-sm-3">
													<div class="pic_hotel">
														<img src="{$clsTour->getImage($lstReviewsTour[i].table_id,193,129)}" class="static" alt="{$clsTour->getTitle($lstReviewsTour[i].table_id)}"  width="100" height="66" style="height: 66px; width: 100px;">
													</div>
												</div>
												<div class="col-sm-7">
													<div class="detail_hotel_booking">
														<h3 class="content_blue">
															<a class="hotelLinks" href="{$clsTour->getLink($lstReviewsTour[i].table_id)}#Reviews{$lstReviewsTour[i].reviews_id}" title="{$clsTour->getTitle($lstReviewsTour[i].table_id)}" target="blank">{$clsTour->getTitle($lstReviewsTour[i].table_id)}</a>
															<label class="rate-1">{$clsReviews->getRatesStar($lstReviewsTour[i].reviews_id)}</label>
															<span  class="rates">({$core->get_Lang('Rating')}: {$clsReviews->getRates($lstReviewsTour[i].reviews_id)})</span>
														</h3>
														<div class="intro">{$clsReviews->getContent($lstReviewsTour[i].reviews_id)|html_entity_decode}</div>
													</div>
												</div>
												<div class="col-sm-2">
													{if $clsReviews->getOneField('is_online',$lstReviewsTour[i].reviews_id) eq 0}
														<p class="text-center color_f00000">{$core->get_Lang('Private')}</p>
													{else}
														<p class="text-center color_66ff00">{$core->get_Lang('Public')}</p>
													{/if}
												</div>
											</div>
										</div>
									</div>
								{/section}
								{section name=i loop=$lstReviewsHotel}
									<div class="bookingItem">
										<div class="bookingTop">
											<div class="row">
												<div class="col-sm-2">
													<div class="pic_hotel">
														<img src="{$clsHotel->getImage($lstReviewsHotel[i].table_id,193,129)}" class="static" alt="{$clsHotel->getTitle($lstReviewsHotel[i].table_id)}" width="100" height="66" style="height: 66px; width: 100px;">
													</div>
												</div>
												<div class="col-sm-8">
													<div class="detail_hotel_booking">
														<h3 class="content_blue">
															<a class="hotelLinks" href="{$clsHotel->getLink($lstReviewsHotel[i].table_id)}#Reviews{$lstReviewsHotel[i].reviews_id}" title="{$clsHotel->getTitle($lstReviewsHotel[i].table_id)}">{$clsHotel->getTitle($lstReviewsHotel[i].table_id)}</a>
															<label class="rate-1">{$clsReviews->getRatesStar($lstReviewsHotel[i].reviews_id)}</label> <span  class="rates">({$core->get_Lang('Rating')}: {$clsReviews->getRates($lstReviewsHotel[i].reviews_id)})</span>
														</h3>
														<div class="intro">{$clsReviews->getContent($lstReviewsHotel[i].reviews_id)|html_entity_decode}</div>
													</div>
												</div>
												<div class="col-sm-2">
													{if $clsReviews->getOneField('is_online',$lstReviewsHotel[i].reviews_id) eq 0}
														<p class="text-center color_f00000">{$core->get_Lang('Private')}</p>
													{else}
														<p class="text-center color_66ff00">{$core->get_Lang('Public')}</p>
													{/if}
												</div>
											</div>
										</div>
									</div>
								{/section}
								{section name=i loop=$lstReviewsCruise}
									<div class="bookingItem">
										<div class="bookingTop">
											<div class="row">
												<div class="col-sm-2">
													<div class="pic_hotel">
														<img src="{$clsCruise->getImage($lstReviewsCruise[i].table_id,193,129)}" class="static" alt="{$clsCruise->getTitle($lstReviewsCruise[i].table_id)}" width="100" height="66" style="height: 66px; width: 100px;">
													</div>
												</div>
												<div class="col-sm-8">
													<div class="detail_hotel_booking">
														<h3 class="content_blue">
															<a class="hotelLinks" href="{$clsCruise->getLink($lstReviewsCruise[i].table_id)}#Reviews{$lstReviewsCruise[i].reviews_id}" title="{$clsCruise->getTitle($lstReviewsCruise[i].table_id)}">{$clsCruise->getTitle($lstReviewsCruise[i].table_id)}</a>
															<label class="rate-1">{$clsReviews->getRatesStar($lstReviewsCruise[i].reviews_id)}</label> <span class="rates">({$core->get_Lang('Rating')}: {$clsReviews->getRates($lstReviewsCruise[i].reviews_id)})</span>
														</h3>
														<div class="intro">{$clsReviews->getContent($lstReviewsCruise[i].reviews_id)|html_entity_decode}</div>
													</div>
												</div>
												<div class="col-sm-2">
													{if $clsReviews->getOneField('is_online',$lstReviewsCruise[i].reviews_id) eq 0}
														<p class="text-center color_f00000">{$core->get_Lang('Private')}</p>
													{else}
														<p class="text-center color_66ff00">{$core->get_Lang('Public')}</p>
													{/if}
												</div>
											</div>
										</div>
									</div>
								{/section}
							{else}
								{$core->get_Lang('No Data!')}
							{/if}
						</div>							
								
						{/if}
						{*<div class="btn_save_titile_table_code mt30">
							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$arrStep[$step].key}" data-prevstep="{$prevstep}" class="back_step js_save_back">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save &amp; Continue')}</a>
						</div>*}
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 col_instruction">
				<div class="instruction_fill_data_box">
					<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
					<div class="content_box">{$clsConfiguration->getValue($help_first|default:'')|html_entity_decode}</div>
				</div>
			</div>
		</div>
	</div>
</form>
{literal}
	<style type="text/css">
		.form-group{margin-bottom:10px;}
		.form-group label{width:150px; text-align:right; display: inline-block; line-height:32px}
		.form-group .col-right{width:300px;display: inline-block}
		.form-group input{width:100%; padding:0 10px; line-height:32px}
		.bookingItem {
			width: 100%;
			margin-top: 20px;
			position: relative;
			display: inline-block;
		}
		.detail_hotel_booking .content_blue {font-size: 15px}
		.detail_hotel_booking .content_blue .rates {display: block;margin: 4px 0}
		.bookingItem .col-sm-3{width:25%;float:left}
		.bookingItem .col-sm-9{width:75%;float:left}
		#tab_content .col-sm-9{width:75%;float:left}
		.bookingItem .col-sm-2{width:16.6%; display:inline-block; float:left}
		.bookingItem .col-sm-4{width:33.3%; display:inline-block; float:left}
		#tab_content .col-sm-6{width:50%;float:left}
		.bookingItem .col-sm-8{width:66.6%; display:inline-block; float:left}
		.col-sm-8{width:66.6%; display:inline-block; float:left}
		.allbox_right {
			text-align: right;
			position: relative;
		}
		.money_hotel {
			font-size: 16px;
			color: #000;
			font-weight: 700;
		}
		.date_hotel_booking{text-align:right}
		.allbox {
			width: 100%;
			padding: 12px 12px 16px;
			margin-top: 10px;
			background-color: #fcfcfc;
			border: 1px solid #ebebeb;
			height: auto;
		}
		.allbox p, .detail_hotel_booking p {
			margin-bottom: 0;
			margin-top: 0;
		}
		.address {
			font-size: 13px;
			color: #666;
		}
		.booking_left {
			text-align: right;
			width: 40%;
			margin-top: 5px;
			font-weight: 700;
			color: #000;
		}
		.booking_right {
			text-align: left;
			width: 55%;
			margin-left: 4%;
			color: #666;
		}
		.booking_left,
		.booking_right {
			position: relative;
			float: left;
			font-size: 13px;
			white-space: normal;
		}
		.text_conditions, .text_conditions span {
			font-size: 11px;
			color: #36B66F;
		}
		.allbox .manage_booking, .buttonconnect, .css3button, .css3button1 {
			border: 1px solid #2ca4fb;
			background-color: #2ca4fb;
		}
		.allbox .manage_booking, .button_loginemail, .buttonconnect, .css3button, .css3button1, .css3buttoncancel, .submit_reviews {
			color: #fff;
			cursor: pointer;
			text-align: center;
		}
		.allbox .manage_booking, .allbox .submit_reviews, .button_loginemail, .buttonconnect, .css3button, .css3button1, .css3buttoncancel {
			border-radius: 7px;
			-webkit-border-radius: 7px;
			-moz-border-radius: 7px;
		}
		.allbox .manage_booking {
			padding: 5px 15px;
		}
		.rate-1{padding:0}
		.rate-1, .rate-1 span {
			display: inline-block;
			width: 77px;
			height: 13px;
			background: url(/isocms/templates/default/skin/images/rate-1.png) repeat-x 0 -13px;
		}
		.rate-1 span {
			display: inline-block;
			background-position: 0 0;
		}
	</style>
{/literal}
{literal}
<script>
if($('.textarea_intro_editor').length > 0){
	$('.textarea_intro_editor').each(function(){
		var $_this = $(this);
		var $editorID = $_this.attr('id');
		$('#'+$editorID).isoTextArea();
	});
}
	$('.toggle-row').click(function(){
		$(this).closest('tr').toggleClass('open_tr');
	});
</script>
{/literal}