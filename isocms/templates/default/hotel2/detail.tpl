{assign var=title_hotel value=$clsHotel->getTitle($hotel_id)}
{assign var=hotel__id value=$hotel_id}
{assign var=intro_hotel value=$clsHotel->getIntro($hotel_id)}
{assign var=content_hotel value=$clsHotel->getContent($hotel_id)}
<div class="page_container bg_fff">
    <nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$clsCountryEx->getLink($country_id,'Hotel')}" title="{$core->get_Lang('Hotels')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active">
                  <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$curl}" title="{$title_hotel}">
					  <span itemprop="name" class="reb">{$title_hotel}</span></a>
				   <meta itemprop="position" content="3" />
               </li>
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="content hotelPageDetail pd40_0">
        <div class="hotelDetail">
            <div class="container">
				<div class="col-md-9">
					<div class="hotel_detail_left_box">
						<div class="head_title_box hotel_detail_box">
							<div class="row d-flex">
								<div class="col-sm-9">
									<h1>{$title_hotel} <img src="{$clsHotel->getImageStar($oneItem.star_id)}" alt="{$title_hotel}"/></h1>
									<div class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($hotel_id)}</div>
								</div>
								<div class="col-sm-3">
									<div class="col_price">
										<div class="price_hotel">
											<p class="price_number">{$clsISO->priceFormat($min_price)} {$clsISO->getShortRate()}</p>
											<p class="price_text">1 {$core->get_Lang('night')}/{$number_adult} {$core->get_Lang('adults')}</p>
										</div>
										<a href="javascript:void(0);" class="btn_book_hotel btn_main btn_scroll_book_hotel" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
									</div>
								</div>
							</div>
						</div>
						<div class="hotel_gallery_box hotel_detail_box">
						
						</div>
						<div class="hotel_combo_box hotel_detail_box">
						
						</div>
						<div class="hotel_check_rate_box hotel_detail_box">
						
						</div>
						<div class="hotel_room_box hotel_detail_box">
						
						</div>
						<div class="hotel_overview_box hotel_detail_box">
						
						</div>
						<div class="hotel_info_box hotel_detail_box">
						
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="hotel_detail_right_box">
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
				
<div class="page_container bg_fff">
    <nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$clsCountryEx->getLink($country_id,'Hotel')}" title="{$core->get_Lang('Hotels')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active">
                  <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$curl}" title="{$title_hotel}">
					  <span itemprop="name" class="reb">{$title_hotel}</span></a>
				   <meta itemprop="position" content="3" />
               </li>
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="content hotelPageDetail pd40_0">
        <div class="hotelDetail">
            <div class="container">
				<section class="detail_head">
					<h1>{$title_hotel} <img src="{$clsHotel->getImageStar($oneItem.star_id)}" alt="{$title_hotel}"/></h1>
					<div class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($hotel_id)}</div>
					<div class="col_price">
						<div class="price_hotel">
							<p class="price_number">{$clsISO->priceFormat($min_price)} {$clsISO->getShortRate()}</p>
							<p class="price_text">1 {$core->get_Lang('night')}/{$number_adult} {$core->get_Lang('adults')}</p>
						</div>
						<a href="javascript:void(0);" class="btn_book_hotel btn_main btn_scroll_book_hotel" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
					</div>
				</section>
				<section class="detail_photo box_gallery mt30 mb30">
					<div class="owl-carousel photo-slider">
						{if $deviceType eq 'phone'}
						<div class="img_item">
							<img class="img100" alt="{$title_hotel}" src="{$clsHotel->getImage($hotel_id,360,240)}"/>
						</div>
						{section name=i loop=$listImage}
						<div class="img_item">
							<img class="img100" alt="{$clsHotelImage->getTitle($listImage[i].hotel_image_id)}" src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,360,240)}"/>
						</div>
						{/section}
						{elseif $deviceType eq 'tablet'}
						<div class="img_item">
							<img class="img100" alt="{$title_hotel}" src="{$clsHotel->getImage($hotel_id,950,403)}"/>
						</div>
						{section name=i loop=$listImage}
						<div class="img_item">
							<img class="img100" alt="{$clsHotelImage->getTitle($listImage[i].hotel_image_id)}" src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,950,403)}"/>
						</div>
						{/section}
						{else}
						<div class="img_item">
							<img class="img100" alt="{$title_hotel}" src="{$clsHotel->getImage($hotel_id,1280,543)}"/>
						</div>
						{section name=i loop=$listImage}
						<div class="img_item">
							<img class="img100" alt="{$clsHotelImage->getTitle($listImage[i].hotel_image_id)}" src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,1280,543)}"/>
						</div>
						{/section}
						{/if}
					</div>
				</section>
				{$core->getBlock('check_rate_hotel')}
				{if $intro_hotel}
				<section class="detail_intro hotel_detail_box mb60 phone_mb30">
					<h2 class="title_hotel_box_detail">Giới thiệu {$title_hotel}</h2>
					 {$intro_hotel}
				</section>
				{/if}
				
				<section class="cruise_detail_box room_box special_packages_room" id="blockCheckRate">
				</section>
				{if $lstHotelFacility}
				<section class="detail_facility hotel_detail_box mb60 phone_mb30">
					<h2 class="title_hotel_box_detail mb40">{$core->get_Lang('Facilities')}</h2>
					 <ul class="facility_UL">
						{section name=i loop=$lstHotelFacility}
						<li class="col-xs-6 col-sm-6 col-md-4 col-lg-3 _full_width_480 visible">
							{if $clsProperty->getImage($lstHotelFacility[i])}
							<span class="icon"><img class="img100" src="{$clsProperty->getImage($lstHotelFacility[i])}" alt="{$clsProperty->getTitle($lstHotelFacility[i])}"/></span>
							{/if}{$clsProperty->getTitle($lstHotelFacility[i])}</li>
						{/section}                                   
					</ul>
				</section>
				{/if}
				<section class="detail_info hotel_detail_box mb100 phone_mb30">
					<h2 class="title_hotel_box_detail mb40 phone_mb20">{$core->get_Lang('Informations')}</h2>
					{if $deviceType eq 'phone'}
					<div class="content_hotel_phone">
						<div class="content_hotel_2">
							<h3 class="title_hotel_box_detail mb20">{$core->get_Lang('Overview')}</h3>
							<div class="tinymce_Content">
								{$content_hotel}
							</div>
						</div>
						{assign var=bookingPlicy_hotel value=$clsHotel->getHotelBookingPolicy($hotel_id)}
						{if $bookingPlicy_hotel ne ''}
						<div class="content_hotel_2">
							<h3 class="title_hotel_box_detail mb20">{$core->get_Lang('Hotel booking policy')}</h3>
							<div class="tinymce_Content">
								{$bookingPlicy_hotel}
							</div>
						</div>
						{/if}
						{if $listCustomField}
						{section name=i loop=$listCustomField}
						{if $listCustomField[i].fieldvalue ne ''}
						<div class="content_hotel_2">
							<h3 class="title_hotel_box_detail mb20">{$listCustomField[i].fieldname}</h3>
							<div class="tinymce_Content">
								{$listCustomField[i].fieldvalue|html_entity_decode}
							</div>
						</div>
						{/if}
						{/section}
						{/if}
					</div>
					{else}
					<div class="content_hotel">
						<ul id="tabsk" class="clienttabs mtm">
							<li class="first"><a href="javascript:void(0);" class="current">{$core->get_Lang('Overview')}</a></li> 
							<li><a href="javascript:void(0);">{$core->get_Lang('Hotel booking policy')}</a></li>
							{if $listCustomField}
							{section name=i loop=$listCustomField}
							{if $listCustomField[i].fieldvalue ne ''}
							<li><a href="javascript:void(0);">{$listCustomField[i].fieldname}</a></li>
							{/if}
							{/section}
							{/if}
						</ul>
						<ul class="tabs_content pl0" id="lstTabs" style="border:0 !important">
							<li class="contentTab">
								<div class="tinymce_Content">
									{$content_hotel}
								</div>
							</li>
							{assign var=bookingPlicy_hotel value=$clsHotel->getHotelBookingPolicy($hotel_id)}
							{if $bookingPlicy_hotel ne ''}
							<li class="contentTab" style="display: none">

								<div class="tinymce_Content">
									{$bookingPlicy_hotel}
								</div>
							</li>
							{/if}
							{if $listCustomField}
							{section name=i loop=$listCustomField}
							{if $listCustomField[i].fieldvalue ne ''}
							<li class="contentTab" style="display: none">
								<div class="tinymce_Content">
									{$listCustomField[i].fieldvalue|html_entity_decode}
								</div>
							</li>
							{/if}
							{/section}
							{/if}
						 </ul>
					</div>
					{/if}
				</section>
				{if $lstHotelRelated}
				<section id="relatedBox" class="hotelBox mb60 phone_mb0">
					<div class="headBox">
						<h2 class="pane-title text-left mt0 mb20">{$core->get_Lang('Related hotels')}</h2>
					</div>
					<div class="jcarousel-box owl-carousel" id="jcarousel-related-slides">
						{section name=i loop=$lstHotelRelated}
						{assign var=hotel_id value = $lstHotelRelated[i].hotel_id}
						{$clsISO->getBlock('hotelbox',["hotel_id"=>$hotel_id])}
						{/section}
					</div>
				</section>
				{/if}
            </div>
        </div>
    </div>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(".btn_scroll_book_hotel").click(function() {
			$('html, body').animate({
				scrollTop: $(".entry_body_search").offset().top - 50
			}, 600);
		});
	})
</script>
{/literal}