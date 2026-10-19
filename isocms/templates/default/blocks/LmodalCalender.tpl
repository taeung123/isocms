<div class="modal fade in" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<button type="button" class="close z_16 text-normal text-uppercase hidden-xs hidden-sm" data-dismiss="modal" aria-label="Close">Close <span aria-hidden="true" class="fa fa-times z_18"></span></button>
				<span class="inline-block m-for z_24 c2d">Price Calendar For </span>
				<h4 class="modal-title inline-block z_24 f_hn c2a text-bold" id="calendarModalLabel">{$clsCruise->getTitle($cruise_id)}</h4>
				<label class="rate-1">{$clsCruise->getStarNew($cruise_id)}</label>
				<address><i class="fa fa-map-marker c2a"></i> <strong>Address:</strong> {$clsCruise->getCityAround($cruise_id)}</address>
				<div class="price">
					<span class="block c2a">Starting at <b class="c5a">US$155</b> per person</span> including taxes and fees
				</div>
			</div>
			<div class="modal-body">
				<div class="nav-pull-right">
					<div class="nav-option btn btn-style-1d btn-block z_14 text-bold">Select your option</div>
					<div class="nav-feedback">
						<div class="nav-tabs-modal-xs form-control-angle-down hidden-lg hidden-md">
							<i class="fa fa-caret-right c2d"></i>
							<div class="ca-rooms-option"><strong>Deluxe Cabin</strong> From USD $460</div>
						</div>
						<ul class="nav nav-tabs nav-tabs-option" role="tablist">
                        	{section name=i loop=$lstCruiseCabin}
							<li role="presentation" class="choose-room {if $smarty.section.i.first}active{/if}" alt="{$smarty.section.i.iteration}"><a href="#" aria-controls="interior" role="tab" data-toggle="tab"><strong>{$clsCruiseCabin->getTitle($lstCruiseCabin[i].cruise_cabin_id)}</strong> From USD $460</a></li>
                            {/section}
						</ul>
					</div>
				</div>
					
				<!-- Tab panes -->
				<div class="tab-content bg-default">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div class="tab-ca-caption">
							<h3 class="hidden-sm hidden-xs">Deluxe Cabin</h3>
							<p class="hidden-sm hidden-xs">From USD <b>$460</b></p>
							<p>Price is based on twin/double occupancy and may/may not include transfer from Hanoi.</p>
							<br>
							<p>
								<strong>Oct 2016</strong> <br>
								Click on a date below for pricing and booking details
							</p>
							<div class="ca-select-month">
								<span class="inline-block">Select a month</span>
								<div class="has-feedback inline-block">
                                    <select class="form-control form-control-angle-down" id="choose-month">
                                      <option m="10" y="2016">Oct 2016</option>
                                      <option m="11" y="2016">Nov 2016</option>
                                      <option m="12" y="2016">Dec 2016</option>
                                      <option m="1" y="2017">Jan 2017</option>
                                      <option m="2" y="2017">Feb 2017</option>
                                      <option m="3" y="2017">Mar 2017</option>
                                      <option m="4" y="2017">Apr 2017</option>
                                      <option m="5" y="2017">May 2017</option>
                                      <option m="6" y="2017">Jun 2017</option>
                                      <option m="7" y="2017">Jul 2017</option>
                                      <option m="8" y="2017">Aug 2017</option>
                                      <option m="9" y="2017">Sep 2017</option>
                                      <option m="10" y="2017">Oct 2017</option>
                                      <option m="11" y="2017">Nov 2017</option>
                                      <option m="12" y="2017">Dec 2017</option>
                                    </select>
								</div>
									<a class="inline-block next-month" m="11" y="2016">Next month »</a>
							</div>
						</div>
						<table class="table table-bordered ca-table-tab">
                          <tbody>
                            <tr>
                              <th>Sun<span class="hidden-xs hidden-sm">day</span></th>
                              <th>Mon<span class="hidden-xs hidden-sm">day</span></th>
                              <th>Tue<span class="hidden-xs hidden-sm">sday</span></th>
                              <th>Wed<span class="hidden-xs hidden-sm">nesday</span></th>
                              <th>Thu<span class="hidden-xs hidden-sm">rsday</span></th>
                              <th>Fri<span class="hidden-xs hidden-sm">day</span></th>
                              <th>Sat<span class="hidden-xs hidden-sm">urday</span></th>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><strong class="date-num">1</strong> <span class="empty">NOT AVAILABLE</span></td>
                            </tr>
                            <tr>
                              <td><strong class="date-num">2</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">3</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">4</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">5</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">6</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">7</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">8</strong> <span class="empty">NOT AVAILABLE</span></td>
                            </tr>
                            <tr>
                              <td><strong class="date-num">9</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">10</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">11</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">12</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">13</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">14</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">15</strong> <span class="empty">NOT AVAILABLE</span></td>
                            </tr>
                            <tr>
                              <td><strong class="date-num">16</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">17</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">18</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">19</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">20</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">21</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">22</strong> <span class="empty">NOT AVAILABLE</span></td>
                            </tr>
                            <tr>
                              <td><strong class="date-num">23</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">24</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">25</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">26</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">27</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td><strong class="date-num">28</strong> <span class="empty">NOT AVAILABLE</span></td>
                              <td class="data "  alt="2016-10-29"><strong class="date-num">29</strong>
                                <div class="price"> <span class="hidden-xs hidden-sm">Prices from</span> <strong><span class="hidden-xs hidden-sm">US</span>$460</strong> <a>Select this date</a> </div></td>
                            </tr>
                            <tr>
                              <td class="data " alt="2016-10-30"><strong class="date-num">30</strong>
                                <div class="price"> <span class="hidden-xs hidden-sm">Prices from</span> <strong><span class="hidden-xs hidden-sm">US</span>$460</strong> <a>Select this date</a> </div></td>
                              <td class="data "alt="2016-10-31"><strong class="date-num">31</strong>
                                <div class="price"> <span class="hidden-xs hidden-sm">Prices from</span> <strong><span class="hidden-xs hidden-sm">US</span>$460</strong> <a>Select this date</a> </div></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
					</div>
				</div>
			</div>
			<input type="hidden" id="cruise_id" value="69">
			<input type="hidden" id="room_id" value="3">
			<input type="hidden" id="duration_id" value="1">
			<input type="hidden" id="month" value="10">
			<input type="hidden" id="year" value="2016">
			<input type="hidden" id="adult" value="1">
			<input type="hidden" id="number-room" value="1">
			<div class="modal-footer box-hidden">
				<div class="pull-left hidden-sm hidden-xs">
					<img src="/skins/v3/images/logo-white.png" alt="">
				</div>
				<div class="pull-right hidden-sm hidden-xs">
					For enquiry or reservations, <span class="inline-block">please conntact us at <a href="javascript:void(0)">+84 946 505 505</a></span>
					or email <a href="mailto:info@halongbaytours.com">info@halongbaytours.com</a>
				</div>
				<button type="button" class="close z_16 text-normal text-uppercase hidden-md hidden-lg" data-dismiss="modal" aria-label="Close">Close <span aria-hidden="true" class="fa fa-times z_18"></span></button>
			</div>
        </div>
    </div>
</div>