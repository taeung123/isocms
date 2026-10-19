<div class="page_container">
 
    <nav class="breadcrumb-main breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Hotels')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="hotelPlacePage pdt40">
        <div class="container">
        	<div class="row">
				<div class="col-md-9 floatRight992">
                    <article class="contentDestination">
                        <h1 class="size32 mt0 mb20">{$core->get_Lang('Hotels')}</h1>
                        <div class="contentTabRL">
                            <div class="hotelBox" id="listHolderView">
                                <div class="row">
                                    {foreach from=$response_hotel item=item name=item}
									{foreach from=$item.hotels item=item_hotel name=item_hotel}
									{assign var = hotel_id value = $item_hotel.id}
                                    {assign var = title value = $item_hotel.name}
									{assign var = image value = $item_hotel.image}
									{assign var = star value = $item_hotel.star}
									{assign var = lat value = $item_hotel.lat}
									{assign var = lng value = $item_hotel.lng}
									{assign var = city value = $item_hotel.city}
									{assign var = country value = $item_hotel.country}
									{assign var = district value = $item_hotel.district}
									{assign var = area value = $item_hotel.area}
									{assign var = address value = $item_hotel.address}
									{assign var = type value = $item_hotel.type}
									{assign var = roomAvail value = $item_hotel.roomAvail}
									{assign var = priceFrom value = $item_hotel.priceFrom}
									{assign var = airportDistance value = $item_hotel.airportDistance}
									{assign var = centerDistance value = $item_hotel.centerDistance}
									{assign var = currency value = $item_hotel.currency}
									{assign var = taxIncluded value = $item_hotel.taxIncluded}
									{assign var = serviceTaxPercent value = $item_hotel.serviceTaxPercent}
									{assign var = valueAddedTaxPercent value = $item_hotel.valueAddedTaxPercent}
									{assign var = hotelChain value = $item_hotel.hotelChain}
									{assign var = numberOfRooms value = $item_hotel.numberOfRooms}
									{assign var = topAmenities value = $item_hotel.topAmenities}
                                    <div class="hotel_item">
										<a class="photo">
											{if $image}
											<img src="{$image}" alt="{$title}" class="img">
											{else}
											<img src="{$URL_IMAGES}/noimage.png" alt="{$title}" class="img">
											{/if}
											{if $smarty.foreach.item_hotel.first}
											<figure><p class="tag-best-price"><i class="icon-star icon-best-price-star"></i> Khách sạn giá tốt</p></figure>
											{/if}
										</a>
										<div class="body_hotel">
											<div class="body_info">
												<h3 style="margin: 0px;">
													<a href="" title="{$title}" class="btn btn-link text_bold">{$title}</a> 
													{if $star}
													<img class="star" height="13" src="{$clsHotel->getImageStar($star)}" alt="star" />
													{/if}
												</h3>
												<p class="ml-3"><span class="secondary">{$type}</span> <i class="icon-Location ml-3" style="color: rgb(23, 61, 143); font-size: 18px; position: relative; top: 3px;"></i> <span title="" data-original-title="{$address}" style="color: rgb(23, 61, 143); font-size: 14px; text-decoration: underline; cursor: pointer;">{$address}</span></p>
												<div class="ml-3 mt-2"><span style="color: rgb(128, 128, 128); font-size: 12px;"><i class="icon-center" style="color: rgb(204, 204, 204); font-size: 18px; position: relative; top: 2px;"></i> {$centerDistance} km</span> <span class="ml-4" style="color: rgb(128, 128, 128); font-size: 12px;"><i class="icon-airport" style="color: rgb(204, 204, 204); font-size: 18px; position: relative; top: 1px;"></i> {$airportDistance} km</span></div>
												{if $topAmenities}
												<div class="ml-3 mt-2">
													<div class="row" style="color: black; font-size: 12px;">
														<div class="col">
															<ul>
																{foreach from=$topAmenities item=item_amenniti name=item_amenniti}
																<li style="display: inline-block; margin-right: 20px;"><i class="{$item_amenniti.icon}" style="color: rgb(23, 61, 143); font-size: 18px; position: relative; top: 3px;"></i> <span style="color: rgb(128, 128, 128);">{$item_amenniti.name}</span></li>
																{/foreach}
															</ul>
														</div>
													</div>
												</div>
												{/if}
											</div>
											<div class="body_price">
												<div class="pb-3 pt-2"><p class="text-secondary" style="font-size: 12px; margin: 0px;">Giá cho <b>1 đêm</b></p> <span><!----><!----><b class="my-2" style="color: rgb(23, 61, 143); font-size: 16px;">{$currency} {$clsISO->formatPrice($priceFrom)}</b><!----><!----><!----><!----><!----><!----><!----><!----><!----><!----><!----><!----><!----></span> <!----> <p><a href="/hotel/detail?hid=2297&amp;adult=2&amp;child=0&amp;CI=2020-10-10&amp;CO=2020-10-11&amp;counterChilds=&amp;noRoom=1" class="btn btn-radius mt-2 btn-detail" style="background: rgb(23, 61, 143);">
					Xem chi tiết <i class="icon-Arrow-Right" style="color: rgb(255, 255, 255); font-size: 18px; position: relative; top: 3px;"></i></a></p> <p class="mt-2 fs-13" style="color: black;"><!----> <!----> <span>{$roomAvail}/{$numberOfRooms} phòng trống</span></p></div>
											</div>
										</div>
									</div>

									 {/foreach}
                                    {/foreach}
                                </div>
								
                            </div>

                       </div>
                    </article>
                </div>
                <aside class="col-md-3 mb30 leftTour">
                </aside>
            </div>
        </div>
    </div>
</div>