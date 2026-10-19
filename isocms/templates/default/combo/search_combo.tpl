<div class="page_container bg_fff">
 
    <nav class="breadcrumb-main breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Hotels')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="ListComboPage">
        <div class="container">
        	<div class="TitleSearchContent">
        		<div class="titlebox">
        			<p class="title">Combo tiết kiệm từ Hà Nội đến Đà Nẵng</p>
        			<a href="javascript:void(0)" title="" class="ChangeSearch">Thay đổi tìm kiếm</a>
        		</div>
        		<div class="contentbox">
        			<span>Thứ 2, 10/10/2020</span> - <span>Thứ 5, 13/10/2020</span>
        		</div>
        	</div>
        	<div class="PlaneBox">
        		<div class="row">
        			<div class="col-md-6 ">
        			<div class="AboutTicketAir">
        				<p class="flightAway">Chuyến bay chiều đi</p>
        				<div class="Detail">
        					<div class="Startaway">
								<p class="code">HAN</p>
								<p class="AddressStart">Hanoi</p>
								<p class="TimeStart">10:10, Thứ 2, 10/10/2020</p>
        					</div>
        					<div class="Endaway">
        						<p class="code">DAD</p>
								<p class="AddressEnd">Da nang</p>
								<p class="TimeStart">11:35, Thứ 2, 10/10/2020</p>
        					</div>
        				</div>
        				<a href="javascript:void(0)" title="{$core->get_Lang('View more flight')}" class="MoreAirTicket">{$core->get_Lang('View more flight')}</a>
        			</div>
        			</div>
        			<div class="col-md-6 ">
        			<div class="AboutTicketAir">
        				<p class="flightReturn">Chuyến bay chiều về</p>
        				<div class="Detail">
        					<div class="Startaway">
        						<p class="code">DAD</p>
								<p class="AddressEnd">Da nang</p>
								<p class="TimeStart">20:30, Thứ 5, 13/10/2020</p>
        					</div>
        					<div class="Endaway">
								<p class="code">HAN</p>
								<p class="AddressStart">Hanoi</p>
								<p class="TimeStart">21:50, Thứ 5, 10/10/2020</p>
        					</div>
        				</div>
        				<a href="javascript:void(0)" title="{$core->get_Lang('View more flight')}" class="MoreAirTicket">{$core->get_Lang('View more flight')}</a>
        			</div>
        			</div>
        		</div>
        	</div>
        	<div class="ContentBox">
        		<div class="row">
        			<div class="col-md-3">
							<div class="modal-body">
							   <div class="totalTour mb20">
								   <p class="totalTourpage h3">{$core->get_Lang('Filter Search')}</p>
							   </div>
								{$core->getBlock('filter_left_combo')}
						   </div>
        			</div>
        			<div class="col-md-9">
        				<div class="ContentRight">
        					<div class="SortBox">
        						<p class="titleBoxLeft">{$core->get_Lang('Sort by')}</p>
        						<div class="OptionSort">
        							<span class="op1">Điểm đánh giá</span>
        							<span>Giá cao nhất</span>
        							<span>Giá thấp nhất</span>
        						</div>
        					</div>
        					<div class="listHotelCombo">
        						{section name=i loop=$list_hotel_id}
        						{assign var=hotel_id value=$list_hotel_id[i]}
        						{assign var=ListRoom value=$clsHotel->getRoomHotel($hotel_id)}
        						{assign var=linkHotel value=$clsHotel->getLink($list_hotel_id[i])}
        						{assign var=titleHotel value=$clsHotel->getTitle($list_hotel_id[i])}
        						{assign var=listFacility value=$clsHotel->getListHotelFacility($list_hotel_id[i])}
        							<div class="BodyItem">
        							<div class="Item">
        								<div class="left">
        									<a href="{$linkHotel}" title="{$titleHotel}" class="image">
        										<img src="{$clsHotel->getImage($list_hotel_id[i],300,200)}" alt="{$titleHotel}">
        									</a>
        									<div class="body">
        										<h3 class="title"><a href="{$linkHotel}" title="{$titleHotel}">{$titleHotel}</a></h3>
        										<p class="startReview rate-2019">{$clsReviews->getStarNew($list_hotel_id[i],hotel)}</p>
        										<p class="locationHotel"><i class="fa fa-map-marker" aria-hidden="true"></i> {$clsHotel->getLocation($list_hotel_id[i])}</p>
        										<p class="totalReview">{$core->get_Lang('Review')}: <span class="rate_avg">{$clsReviews->getRateAVG($list_hotel_id[i],hotel)}</span> <span class="text_review">({$clsReviews->getToTalReview($list_hotel_id[i],hotel)} {$core->get_Lang('review')})</span></p>
        										<p class="FacilityBox">
        											<span class="titleFacility">{$core->get_Lang('Convenient')}: </span>
        											{section name=k loop=$listFacility max=3}
        												<span>{$clsProperty->getTitle($listFacility[k])}</span>,
        											{/section}
        										</p>
        										<a href="javascript:void(0)" title="{$core->get_Lang('View Detail')}">{$core->get_Lang('View Detail')}</a>
        									</div>
        								</div>
        								<div class="right">
        									<p class="price">2,500,000đ</p>
        									<p class="textInto">Dành cho một người bao gồm vé máy bay + khách sạn, thuế và lệ phí</p>
        									<p class="TotalPriceText">{$core->get_Lang('Tổng giá tiền')}</p>
        									<p class="totalPrice">7,500,000đ</p>
        									<a href="javascript:void(0)" title="{$core->get_Lang('Select type room')}" class="selectRoom">{$core->get_Lang('Select type room')}</a>
        								</div>
        								
        							</div>
        								<div class="listRoom clearfix">
        								<p class="titleBoxRoom">Phòng 1</p>
        								<table class="TypeRoom">
        									<thead>
        									<tr>
        										<td>{$core->get_Lang('Type room')}</td>
        										<td>{$core->get_Lang('Info room')}</td>
        										<td></td>
        										<td>{$core->get_Lang('Price')}</td>
        										<td></td>
        									</tr>
        									</thead>
        									<tbody>
        									{section name=k loop=$ListRoom}
        										<tr>
        											<td class="RoomName">{$clsHotelRoom->getTitle($ListRoom[k].hotel_room_id)}</td>
        											<td>Bao gồm đồ ăn sáng</td>
        											<td class="necessaryNotice"><a href="javascript:void(0)" title="{$core->get_Lang('necessary information')}">{$core->get_Lang('necessary information')}</a></td>
        											<td class="RoomPrice">+ {$clsHotelRoom->getPrice($ListRoom[k].hotel_room_id)} </td>
        											<td><input class="TickSelect" type="radio" /></td>
        										</tr>
        									{/section}
											</tbody>
										</table>
       									<button type="submit" class="BookRoom">{$core->get_Lang('Book now')}</button>
        							</div>
        							</div>
        						{/section}
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>