<div class="page_container">
	<nav class="breadcrumb-main breadcrumb-more bg_fff">
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
	<div id="contentPage" class="pageMyProfile pd40_0">
		<div class="container">
			<div class="content-info"> 
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 flex-body tabs_content pl0" id="lstTabs" style="border:0 !important">
						<div class="contentTab" style="display:block">
							<div class="flex-box">
								<h1>{$core->get_Lang('My Booking Details')}</h1>
								<input type="hidden" id="isBnpl" value="False">
								<div class="mmb-status">
									<div class="left"><strong>{$core->get_Lang('Booking ID')}:</strong> <span>{$clsBooking->getOneField('booking_code',$booking_id)}</span>
									</div>
									<div class="right">
										<strong>{$core->get_Lang('Status')}:</strong>
										{if $type eq 'Tour'}
										{assign var=Store_Tour value=$clsBooking->getBookingValue($booking_id)}
										 <span style="color: #e80e0e;">{$core->get_Lang('Departed on')} {$clsISO->converTimeToText2($clsBooking->getOneField('check_out',$booking_id))}</span>
										{elseif $type eq 'Hotel'}
										{assign var=Store_Hotel value=$clsBooking->getBookingValue($booking_id)}
										<span style="color: #e80e0e;">{$core->get_Lang('Departed on')} {$clsISO->converTimeToText2($Store_Hotel.checkout)}</span>
										{else}
										{assign var=Store_Cruise value=$clsBooking->getBookingValue($booking_id)}
										 <span style="color: #e80e0e;">{$core->get_Lang('Departed on')} {$clsISO->converTimeToText2($clsBooking->getOneField('check_out',$booking_id))}</span>
										{/if}
									</div>
								</div>
								<div class="mmb-promo-panel" id="book-again">
									<div class="mmb-promo">
										<figure class="media media-cover cover" style="background-image: url('{$clsTable->getImage($target_id,726,484)}'); background-size: cover; background-position:50% 50%">
										</figure>
										<div class="media-panel">
											<div class="date-labels">
												<span>{$core->get_Lang('Check in')}</span>
												<span>{$core->get_Lang('Check out')}</span>
											</div>
											 {if $type eq 'Tour'}
											<div class="date-entries date-inverted date date-departed">
												<div class="date"><span class="checkinmonth">{$clsISO->converTimeToText3($Store_Tour.departure_date,'YEAR')}</span><strong class="checkinday">{$clsISO->converTimeToText3($Store_Tour.departure_date,'DAY')}</strong><em class="checkindayofweek">{$clsISO->converTimeToText3($Store_Tour.departure_date)}</em>
												</div>
												<div class="date"><span class="checkoutmonth">{$clsISO->converTimeToText3($clsBooking->getOneField('check_out',$booking_id),'YEAR')}</span><strong class="checkoutday">{$clsISO->converTimeToText3($clsBooking->getOneField('check_out',$booking_id),'DAY')}</strong><em class="checkoutdayofweek">{$clsISO->converTimeToText3($clsBooking->getOneField('check_out',$booking_id))}</em>
												</div>
											</div>
											{elseif $type eq 'Hotel'}
											<div class="date-entries date-inverted date date-departed">
												<div class="date"><span class="checkinmonth">{$clsISO->converTimeToText3($Store_Hotel.checkin,'YEAR')}</span><strong class="checkinday">{$clsISO->converTimeToText3($Store_Hotel.checkin,'DAY')}</strong><em class="checkindayofweek">{$clsISO->converTimeToText3($Store_Hotel.checkin)}</em>
												</div>
												<div class="date"><span class="checkoutmonth">{$clsISO->converTimeToText3($Store_Hotel.checkout,'YEAR')}</span><strong class="checkoutday">{$clsISO->converTimeToText3($Store_Hotel.checkout,'DAY')}</strong><em class="checkoutdayofweek">{$clsISO->converTimeToText3($Store_Hotel.checkout)}</em>
												</div>
											</div>
											{else}
											<div class="date-entries date-inverted date date-departed">
												<div class="date"><span class="checkinmonth">{$clsISO->converTimeToText3($Store_Cruise.departure_date,'YEAR')}</span><strong class="checkinday">{$clsISO->converTimeToText3($Store_Cruise.departure_date,'DAY')}</strong><em class="checkindayofweek">{$clsISO->converTimeToText3($Store_Cruise.departure_date)}</em>
												</div>
												<div class="date"><span class="checkoutmonth">{$clsISO->converTimeToText3($clsBooking->getOneField('check_out',$booking_id),'YEAR')}</span><strong class="checkoutday">{$clsISO->converTimeToText3($clsBooking->getOneField('check_out',$booking_id),'DAY')}</strong><em class="checkoutdayofweek">{$clsISO->converTimeToText3($clsBooking->getOneField('check_out',$booking_id))}</em>
												</div>
											</div>
											{/if}
											{if $type eq 'Cruise'}
											<a href="{$clsTable->getLink($target_id)}#chooseDate" id="BookAgainButton" class="button submit-orange button-flat decoration-for-yellow-submit" title="Book Again">{$core->get_Lang('Book Again')}</a>
											{else}                            					
											<a href="{$clsTable->getLinkBook($target_id)}" id="BookAgainButton" class="button submit-orange button-flat decoration-for-yellow-submit" title="Book Again">{$core->get_Lang('Book Again')}</a>
											{/if}
										</div>
									</div>
									<h3>
										<a href="{$clsTable->getLink($target_id)}" class="plain" title="">{$clsTable->getTitle($target_id)}</a>&nbsp;
										<i class="ficon ficon-16 ficon-star-1 orange-yellow ficon-star-style" data-selenium="hotel-header-star" data-toggle="tooltip" data-placement="top" title="" data-original-title="Gold star ratings are provided by the property to reflect the comfort, facilities, and amenities you can expect.">
										</i>
									</h3>
									<address><i class="fa fa-map-marker"></i>&nbsp;
									{if $type eq 'Hotel'}
									{$clsTable->getAddress($target_id)}
									{else}
									{$clsTable->getCityAround($target_id)}
									{/if}
									</address>
								</div>
								<ul class="list-table mmb-list-table">
									<li>
										<span>{$core->get_Lang('Lead Guest')}:</span>
										<span class="leadGuestName">{$clsProfile->getFullname($profile_id)}</span>
									</li>
									<li>
										<span>{$core->get_Lang('Reservation')}:</span>
										{if $type eq 'Tour'}
										<span>{$clsTable->getTripDuration($target_id)}</span>
										{elseif $type eq 'Hotel'}
										<span>1 Room, 1 Night</span>
										{else}
										 <span>{$Store_Cruise.duration}</span>
										{/if}
									</li>
									<li>
										<span>{$core->get_Lang('Number of guests')}:</span>
										<span id="bookingInformationTotalOccupancy">{$number_of_guest}</span>
									</li>
								</ul>
							</div>
							{if $type eq 'Cruise'}
							<div class="flex-box">
								<div class="mmb-details mmb-room-details">
									<h4>{$clsCruiseCabin->getTitle($Store_Cruise.cruise_cabin_id)}</h4>
									<div class="entry">
										<div class="row">
											<div class="col-sm-4 col-md-4">
												<div class="card">
												   <img src="{$clsCruiseCabin->getImage($Store_Cruise.cruise_cabin_id,696,464)}" alt="{$clsCruiseCabin->getTitle($Store_Cruise.cruise_cabin_id)}" width="100%" height="auto"  />
												</div>
											</div>
											<div class="col-sm-8 col-md-8">
												<div class="info">
													<ul class="list-table">
														<li>
															<span>{$core->get_Lang('Number cabin')}:</span>
															<span id="extraBeds">{$Store_Cruise.number_room}</span>
														</li>
														<li>
															<span>{$core->get_Lang('Maximum Occupancy')}</span>
															<span id="roomMaximumOccupancy">{$clsCruiseCabin->getMaxAdult($Store_Cruise.cruise_cabin_id)} {$core->get_Lang('Adults')}{if $clsCruiseCabin->getMaxChild($Store_Cruise.cruise_cabin_id) gt 0}, {$clsCruiseCabin->getMaxChild($Store_Cruise.cruise_cabin_id)} {$core->get_Lang('Child')}{/if}</span>
														</li>
														<li>
															<span>{$core->get_Lang('Extra beds')}:</span>
															<span id="extraBeds">{$clsCruiseCabin->getExtraBed($Store_Cruise.cruise_cabin_id)}</span>
														</li>
														<li>
															<span>{$core->get_Lang('Total amount')}:</span>
															<span style="white-space: nowrap">{$clsISO->getRate()}&nbsp;{$Store_Cruise.totalGrand}</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							{/if}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
