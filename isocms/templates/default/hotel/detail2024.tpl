{assign var=title_hotel value=$clsHotel->getTitle($hotel_id,$oneItem)}
{assign var=hotel__id value=$hotel_id}
{assign var=intro_hotel value=$oneItem.intro}
{assign var=overview_hotel value=$oneItem.overview}
{assign var=bookingPolicy_hotel value=$clsHotel->getHotelBookingPolicy($hotel_id,oneItem)}
{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var= ratingValue value= $clsReviews->getRateAvg($hotel__id,'hotel','10')}
    {assign var= bestRating value= $clsReviews->getBestRate($hotel__id,'hotel')}
    {assign var= ratingCount value= $clsReviews->getToTalReview($hotel__id,'hotel')}
{else}
    {assign var= ratingValue value= $clsReviews->getRateAvgNoLogin($hotel__id,'hotel','10')}
    {assign var= bestRating value= $clsReviews->getBestRate($hotel__id,'hotel')}
    {assign var= ratingCount value= $clsReviews->getToTalReviewNoLogin($hotel__id,'hotel')}
{/if}
{assign var=textRateAvg value=$clsReviews->getTextRateAvg($hotel__id,'hotel')}

{$core->getBlock('2024_breadcrumb')}
<section class="hnv_hotel_detail_intro">
    <div class="container">
        <div class="hnv_hotel_detail_intro_type">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="hnv_hotel_detail_intro_type_left">
                        <div class="hnv_hotel_detail_intro_type_left_star">
                            {section name=i loop={$oneItem['star_id']}}
                                {*                                <i class="fa-duotone fa-light fa-star" aria-hidden="true"></i>*}
                                <i class="fa-solid fa-star"></i>
                            {/section}
                        </div>
                        <div class="hnv_hotel_detail_intro_type_left_list">
                            <ul>
                                {if $clsProperty->getTitle($oneItem['list_TypeHotel'])}
                                    <li class="hnv_hotel_detail_intro_type_left_item">
                                        {$clsProperty->getTitle($oneItem['list_TypeHotel'])}
                                    </li>
                                {/if}
                                {if $arr_hotel_tags_id}
                                    {foreach from=$arr_hotel_tags_id key=key item=item}
                                        <li class="hnv_hotel_detail_intro_type_left_item hnv_hotel_detail_intro_type_left_item_top">
                                            {$clsProperty->getTitle($item)}
                                        </li>
                                    {/foreach}
                                {/if}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="hnv_hotel_detail_intro_type_right">
                        <div class="hnv_hotel_detail_intro_type_right_share">
                            <button class="icon_share">
                                <i class="fa-light fa-light fa-share-nodes" style="color: #1d2d53;"></i>
                            </button>
                            <div class="share_box">
                                {assign var=link_share value=$curl}
                                {assign var=title_share value="{$title_hotel}"}
                                {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hnv_hotel_detail_intro_title">
            <h1>{$title_hotel}</h1>
        </div>
        <div class="hnv_hotel_detail_intro_place">
            <div class="row">
                <div class="col-12 col-lg-8 d-flex align-items-end">
                    <div class="hnv_hotel_detail_intro_place_left">
                        <i class="fa-light fa-location-dot" aria-hidden="true"></i>
                        {$oneItem['address']}
                        <a href="javascript:void(0);" title="View map" class="hnv_hotel_detail_intro_place_map"
                           data-bs-toggle="modal" data-bs-target="#mapModal{$hotel_id}">
                            {$core->get_Lang('View map')}
                        </a>
                        <div class="modal fade" id="mapModal{$hotel_id}" tabindex="-1"
                             aria-labelledby="mapModal{$hotel_id}Label"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <iframe src="https://maps.google.it/maps?q={$clsHotel->getAddressMapView($hotel_id, $oneItem)}&output=embed"
                                                width="600" height="450" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="hnv_hotel_detail_intro_place_right">
                        <div class="hnv_hotel_detail_intro_place_right_price">
                            <label class="price_place_hotel">{$clsHotel->getPriceOnPromotionNew($hotel_id, 'detail')}</label>
                            <p>{$core->get_Lang('per night includes taxes & fees')}</p>
                        </div>
                        <a href="javascript:void(0);" title="{$core->get_Lang('Select Room')}"
                           class="hnv_hotel_detail_intro_place_right_book">
                            {$core->get_Lang('Select Room')}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hnv_hotel_detail_gallery">
    <div class="container">
        <div class="grid-container">
            <div class="grid-item hnv_h1">
                <img loading="lazy" src="{$clsHotel->getImage($hotel_id,636,363,$oneItem)}" width="636" height="363"
                     alt="{$title_hotel}">
                <a data-fancybox="hotel_gallery" class="hnv_hotel_detail_gallery_more"
                   title="{$core->get_Lang('See all photos')}"
                   href="{$oneItem['image']}">
                    <i class="fa-duotone fa-light fa-images"></i> {$core->get_Lang('See all photos')}
                </a>
            </div>
            {if $listImage}
                {foreach from=$listImage key=key item=item name=loop}
                    {assign var="hot_image_id" value=$item.hotel_image_id}
                    {assign var="hot_image" value=$clsHotelImage->getImage($hot_image_id,313,178)}
                    {assign var="hot_title" value=$clsHotelImage->getTitle($hot_image_id)}
                    {assign var="hnv_class" value="hnv_h`$smarty.foreach.loop.index+2`"}
                    <div class="grid-item {$hnv_class}" {if $key gt 3} hidden {/if}>
                        <a data-fancybox="hotel_gallery" href="{$item.image}"></a>
                        <img loading="lazy" src="{$hot_image}" width="313" height="178" alt="{$hot_title}">
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
</section>
<section class="hnv_hotel_detail_main">
    <div id="hnv_navbar_fixed">
        <div class="container">
            <ul class="hnv_hotel_detail_main_nav_list">
                <li class="hnv_hotel_detail_main_nav_item">
                    <a class="nav-link" href="javascript:void(0);"
                       data-target="hnv_hotel_detail_main_intro">{$core->get_Lang('Overview')}</a>
                </li>
                {if $lstHotelRoom}
                    <li class="hnv_hotel_detail_main_nav_item">
                        <a class="nav-link" href="javascript:void(0);"
                           data-target="hnv_hotel_detail_main_room">{$core->get_Lang('Rooms')}</a>
                    </li>
                {/if}
                {if $arr_tour_by_city}
                    <li class="hnv_hotel_detail_main_nav_item">
                        <a class="nav-link" href="javascript:void(0);"
                           data-target="hnv_hotel_detail_main_tour">{$core->get_Lang('Trip recommendations')}</a>
                    </li>
                {/if}
                <li class="hnv_hotel_detail_main_nav_item">
                    <a class="nav-link" href="javascript:void(0);"
                       data-target="hnv_hotel_detail_main_review">{$core->get_Lang('Reviews')}</a>
                </li>
                {if $arr_hotel_category}
                    <li class="hnv_hotel_detail_main_nav_item">
                        <a class="nav-link" href="javascript:void(0);"
                           data-target="hnv_hotel_detail_main_facilities">{$core->get_Lang('Facilities')}</a>
                    </li>
                {/if}
                <li class="hnv_hotel_detail_main_nav_item">
                    <a class="nav-link" href="javascript:void(0);"
                       data-target="hnv_hotel_detail_main_policies">{$core->get_Lang('Policies')}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="hnv_scrollspy">
        <div class="container">
            <div id="hnv_hotel_detail_main_intro" class="hnv_scrollspy_item hnv_hotel_detail_main_intro">
                <div class="row">
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="hnv_hotel_detail_main_intro_left">
                            <div class="hnv_hotel_detail_main_intro_left_text short_content" data-height="150">
                                {$overview_hotel|html_entity_decode}
                            </div>
                            {if $listHotelFacilitiesFavorite}
                                <div class="hnv_hotel_detail_main_intro_left_popular_facilities">
                                    <div class="hnv_hotel_detail_main_intro_left_popular_facilities_title">
                                        <h3>{$core->get_Lang('Most popular facilities')}</h3>
                                    </div>
                                    <div class="hnv_hotel_detail_main_intro_left_popular_facilities_content">
                                        <ul class="hnv_hotel_detail_main_intro_left_popular_facilities_list">
                                            {foreach from=$listHotelFacilitiesFavorite key=key item=item}
                                                <li class="hnv_hotel_detail_main_intro_left_popular_facilities_item">
                                                    <img src="{$clsProperty->getImage($item.property_id)}" width="20"
                                                         height="20"
                                                         alt="{$clsProperty->getTitle($item.property_id)}">
                                                    {$clsProperty->getTitle($item.property_id)}
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        {if $lstReview}
                            <div class="hnv_hotel_detail_main_intro_right">
                                <div class="hnv_hotel_detail_main_intro_right_top">
                                    <div class="hnv_hotel_detail_main_intro_right_top_number">{$ratingValue}</div>
                                    <div class="hnv_hotel_detail_main_intro_right_top_detail">
                                        <div class="hnv_hotel_detail_main_intro_right_top_detail_text">{$textRateAvg}</div>
                                        <div class="hnv_hotel_detail_main_intro_right_top_detail_total">
                                            {$ratingCount} {$core->get_Lang('reviews')}</div>
                                    </div>
                                </div>
                                <div class="hnv_hotel_detail_main_intro_right_middle">
                                    {*Location*}
                                    {if $lstReviewHotel.staff}
                                        {math equation='x/10' x=$lstReviewHotel.staff assign=staff}
                                    {else}
                                        {assign var=staff value=0}
                                    {/if}
                                    {*Facilities*}
                                    {if $lstReviewHotel.amenities}
                                        {math equation='x/10' x=$lstReviewHotel.amenities assign=amenities}
                                    {else}
                                        {assign var=amenities value=0}
                                    {/if}
                                    {*Value for money*}
                                    {if $lstReviewHotel.clean}
                                        {math equation='x/10' x=$lstReviewHotel.clean assign=clean}
                                    {else}
                                        {assign var=clean value=0}
                                    {/if}
                                    {*Service*}
                                    {if $lstReviewHotel.place}
                                        {math equation='x/10' x=$lstReviewHotel.place assign=place}
                                    {else}
                                        {assign var=place value=0}
                                    {/if}
                                    {*Cleanliness*}
                                    {if $lstReviewHotel.food_drink}
                                        {math equation='x/10' x=$lstReviewHotel.food_drink assign=food_drink}
                                    {else}
                                        {assign var=food_drink value=0}
                                    {/if}
                                    {*Comfort*}
                                    {if $lstReviewHotel.worthy}
                                        {math equation='x/10' x=$lstReviewHotel.worthy assign=worthy}
                                    {else}
                                        {assign var=worthy value=0}
                                    {/if}
                                    <ul class="hnv_hotel_detail_main_intro_right_middle_list">
                                        <li class="hnv_hotel_detail_main_intro_right_middle_item">
                                            {$core->get_Lang('Location')} {$staff}
                                        </li>
                                        <li class="hnv_hotel_detail_main_intro_right_middle_item">
                                            {$core->get_Lang('Facilities')} {$amenities}
                                        </li>
                                        <li class="hnv_hotel_detail_main_intro_right_middle_item">
                                            {$core->get_Lang('Value for money')} {$clean}
                                        </li>
                                        <li class="hnv_hotel_detail_main_intro_right_middle_item">
                                            {$core->get_Lang('Service')} {$place}
                                        </li>
                                        <li class="position-relative">
                                            <i class="fa-duotone fa-light fa-circle-info"></i>
                                            <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip"
                                                 style="display: none;">
                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_title">
                                                    {$core->get_Lang('Based on')} {$ratingCount} {$core->get_Lang('reviews')}
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 col-md-6">
                                                        <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_left">
                                                            <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_item">
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_label">
                                                                    <label>{$core->get_Lang('Location')}</label>
                                                                    <label>{$staff}</label>
                                                                </div>
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_progress">
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                             style="width: {$lstReviewHotel.staff}%"
                                                                             aria-valuenow="{$lstReviewHotel.staff}"
                                                                             aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_item">
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_label">
                                                                    <label>{$core->get_Lang('Facilities')}</label>
                                                                    <label>{$amenities}</label>
                                                                </div>
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_progress">
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                             style="width: {$lstReviewHotel.amenities}%"
                                                                             aria-valuenow="{$lstReviewHotel.amenities}"
                                                                             aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_item">
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_label">
                                                                    <label>{$core->get_Lang('Value for money')}</label>
                                                                    <label>{$clean}</label>
                                                                </div>
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_progress">
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                             style="width: {$lstReviewHotel.clean}%"
                                                                             aria-valuenow="{$lstReviewHotel.clean}"
                                                                             aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_right">
                                                            <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_item">
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_label">
                                                                    <label>{$core->get_Lang('Service')}</label>
                                                                    <label>{$place}</label>
                                                                </div>
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_progress">
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                             style="width: {$lstReviewHotel.place}%"
                                                                             aria-valuenow="{$lstReviewHotel.place}"
                                                                             aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_item">
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_label">
                                                                    <label>{$core->get_Lang('Cleanliness')}</label>
                                                                    <label>{$food_drink}</label>
                                                                </div>
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_progress">
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                             style="width: {$lstReviewHotel.food_drink}%"
                                                                             aria-valuenow="{$lstReviewHotel.food_drink}"
                                                                             aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_item">
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_label">
                                                                    <label>{$core->get_Lang('Comfort')}</label>
                                                                    <label>{$worthy}</label>
                                                                </div>
                                                                <div class="hnv_hotel_detail_main_intro_right_middle_item_tooltip_progress">
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                             style="width: {$lstReviewHotel.worthy}%"
                                                                             aria-valuenow="{$lstReviewHotel.worthy}"
                                                                             aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="hnv_hotel_detail_main_intro_right_bottom">
                                    <div class="hnv_hotel_detail_main_intro_right_bottom_list owl-carousel owl-theme">
                                        {foreach from=$lstReview key=key item=item}
                                            <div class="hnv_hotel_detail_main_intro_right_bottom_item" data-merge="1">
                                                <div class="hnv_hotel_detail_main_intro_right_bottom_item_content">
                                                    “{$clsISO->truncateWord($item.content,30,"...")|html_entity_decode}”
                                                </div>
                                                <div class="hnv_hotel_detail_main_intro_right_bottom_item_name">
                                                    - {$item.fullname} | {$clsCountry->getTitle($item.country_id)}
                                                </div>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        {else}
                            <div class="hnv_hotel_detail_main_intro_right">
                                <div class="hnv_hotel_detail_main_intro_right_top">
                                    <div class="hnv_hotel_detail_main_intro_right_top_number_none">0.0</div>
                                    <div class="hnv_hotel_detail_main_intro_right_top_detail">
                                        <div class="hnv_hotel_detail_main_intro_right_top_detail_total">{$core->get_Lang('No reviews')}</div>
                                    </div>
                                </div>
                                <div class="hnv_hotel_detail_main_intro_right_bottom">
                                    <div class="hnv_hotel_detail_main_intro_right_bottom_item_content_none">
                                        {$core->get_Lang('Be the first to experience and review our accommodation!')}
                                    </div>
                                </div>
                            </div>
                        {/if}
                        <div class="hnv_hotel_detail_main_intro_right_map">
                            <img src="https://fiorecommunications.com/wp-content/uploads/2019/02/image-maps.jpg"
                                 loading="lazy" width="296" height="150" alt="Map Image">
                            <a href="https://maps.google.it/maps?q={$clsHotel->getAddressMapView($hotel_id, $oneItem)}"
                               class="hnv_hotel_detail_main_intro_right_map_link"
                               title="{$core->get_Lang('Show on map')}" target="_blank">
                                <i class="fa-duotone fa-light fa-location-dot"></i>
                                <span>{$core->get_Lang('Show on map')}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {if $lstHotelRoom}
                <div id="hnv_hotel_detail_main_room" class="hnv_scrollspy_item hnv_hotel_detail_main_room">
                    <div class="hnv_hotel_detail_main_room_title">
                        <h2>{$core->get_Lang('Availability')}</h2>
                    </div>
                    <div class="hnv_hotel_detail_main_room_form">
                        {$core->getBlock('iso_search_hotel')}
                    </div>
                    <div class="hnv_hotel_detail_main_room_note">
                        <div class="hnv_hotel_detail_main_room_note_image">
                            <img src="https://i.ibb.co/swRyYpP/schedule-1.png" alt="schedule-1" border="0">
                        </div>
                        <div class="hnv_hotel_detail_main_room_note_text">
                            {$core->get_Lang('Get free cancellation on all rooms and every deal at this property')}!
                            <p>{$core->get_Lang('Choose any room here, with any offer, and rest assured that you can cancel later and pay nothing if your plans change')}
                                .</p>
                        </div>
                    </div>
                    <div class="hnv_hotel_detail_main_room_list"></div>
                </div>
            {/if}
            {if $arr_tour_by_city}
                <div id="hnv_hotel_detail_main_tour" class="hnv_scrollspy_item hnv_hotel_detail_main_tour">
                    <div class="hnv_hotel_detail_main_tour_title">
                        <h2>{$core->get_Lang('Top things to do in')} {$hotel_city}</h2>
                    </div>
                    <div class="hnv_hotel_detail_main_tour_content">
                        <div class="hnv_hotel_detail_main_tour_content_list owl-carousel">
                            {foreach from=$arr_tour_by_city key=key item=item}
                                {if $item.city_id != 0}
                                    {assign var=tour_id value=$item.tour_id}
                                    {assign var=getLink value=$clsTour->getLink($tour_id)}
                                    {assign var=getTitle value=$clsTour->getTitle($tour_id)}
                                    {assign var=getimage value=$clsTour->getImage($tour_id,298,276)}
                                    {assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id,'tour')}
                                    {assign var=getRateAvg value=$clsReviews->getRateAvg($tour_id,'tour')}
                                    {*                                {assign var=getStarNew value=$clsReviews->getStarNew($tour_id,'tour')}*}
                                    {assign var=getStarNewIcon value=$clsReviews->getStarNewIcon($tour_id,'tour')}
                                    {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,"hnv_new2024")}
                                    {assign var=getLTripDuration value=$clsTour->getLTripDuration($tour_id)}
                                    {assign var=getLCountryAround value=$clsTour->getLCountryAround($tour_id)}
                                    {assign var=getPriceTour value=$clsTour->getTripPrice($tour_id,$now_day,$is_agent)}
                                    {assign var=percent_promotion value=$clsISO->getPromotion($tour_id,'Tour',$now_day,$now_day,'info_promotion')}
                                    <div class="hnv_hotel_detail_main_tour_content_item" data-merge="1">
                                        <a href="{$getLink}" class="hnv_hotel_detail_main_tour_content_item_image"
                                           title="{$getTitle}">
                                            <img data-src="{$getimage}"
                                                 class="owl-lazy" width="298" height="276" alt="{$getTitle}">
                                            <div class="hnv_hotel_detail_main_tour_content_item_image_tag">
                                                {$clsCity->getTitle($item.city_id)}
                                            </div>
                                        </a>
                                        <div class="hnv_hotel_detail_main_tour_content_item_info">
                                            <div class="hnv_hotel_detail_main_tour_content_item_info_title">
                                                <h3>
                                                    <a href="{$getLink}" title="{$getTitle}">
                                                        {$getTitle}
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="hnv_hotel_detail_main_tour_content_item_info_review">
                                                <div class="hnv_hotel_detail_main_tour_content_item_info_review_star">
                                                    {$getStarNewIcon}
                                                </div>
                                                <div class="hnv_hotel_detail_main_tour_content_item_info_review_text">
                                                    {$getRateAvg} ({$getToTalReview})
                                                </div>
                                            </div>
                                            <div class="hnv_hotel_detail_main_tour_content_item_info_price">
                                                {if $getPriceTourPromotion}
                                                    {$core->get_Lang('from')} {$getPriceTourPromotion}
                                                {else}
                                                    {$core->get_Lang('Contact')}
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                    </div>
                </div>
            {/if}
            <div id="hnv_hotel_detail_main_review" class="hnv_scrollspy_item hnv_hotel_detail_main_review">
                <div class="hnv_hotel_detail_main_review_title">
                    <h2>{$core->get_Lang('Guest reviews')}</h2>
                    {*                    <a href="javascript:void(0);" class="view_all_review btn_write_review btn_write_review_login"*}
                    {*                       title="{$core->get_Lang('Reviews')}">*}
                    {*                        {$core->get_Lang('Reviews')}*}
                    {*                    </a>*}
                    {$core->getBlock('2024_box_review')}
                </div>
                {*                <div class="hnv_hotel_detail_main_review_write box_write_review">*}
                {*                    <div class="clearfix mb20"></div>*}
                {*                    {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}*}
                {*                        {$core->getBlock('review_Star')}*}
                {*                    {else}*}
                {*                        {$core->getBlock('review_Star_No_Login')}*}
                {*                    {/if}*}
                {*                </div>*}
                <div class="hnv_hotel_detail_main_review_main customer_reviews_main">
                    <div class="reviews_box_top">
                        <div class="row align-items-center">
                            <div class="col-lg-3">
                                <div class="box_score_review">
                                    <div class="score_number_review">
                                        <p class="txt_bold_scorenumb">{$ratingValue}</p>
                                        <p class="txt_small_scorenumb">/10</p>
                                    </div>
                                    <div class="score_text_review">
                                        <p class="txt_score_review">{$textRateAvg}</p>
                                        <p class="number_score_review">
                                            {$core->get_Lang('From')} {$ratingCount} {$core->get_Lang('Reviews')}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box_rate_score">
                                    {if $lstReviewHotel.staff}
                                        {math equation='x/10' x=$lstReviewHotel.staff assign=staff}
                                    {else}
                                        {assign var=staff value=0}
                                    {/if}
                                    <label class="lbl_rate_score d-flex justify-content-between align-items-center">
                                        {$core->get_Lang('Location')}
                                        <span>{$staff}</span>
                                    </label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{$staff}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {$lstReviewHotel.staff}%"></div>
                                    </div>
                                </div>
                                <div class="box_rate_score">
                                    {if $lstReviewHotel.place}
                                        {math equation='x/10' x=$lstReviewHotel.place assign=place}
                                    {else}
                                        {assign var=place value=0}
                                    {/if}
                                    <label class="lbl_rate_score d-flex justify-content-between align-items-center">
                                        {$core->get_Lang('Service')}
                                        <span>{$place}</span>
                                    </label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{$place}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {$lstReviewHotel.place}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box_rate_score">
                                    {if $lstReviewHotel.amenities}
                                        {math equation='x/10' x=$lstReviewHotel.amenities assign=amenities}
                                    {else}
                                        {assign var=amenities value=0}
                                    {/if}
                                    <label class="lbl_rate_score d-flex justify-content-between align-items-center">
                                        {$core->get_Lang('Facilities')}
                                        <span>{$amenities}</span>
                                    </label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{$amenities}" aria-valuemin="0" aria-valuemax="100"
                                             style="width: {$lstReviewHotel.amenities}%"></div>
                                    </div>
                                </div>
                                <div class="box_rate_score">
                                    {if $lstReviewHotel.food_drink}
                                        {math equation='x/10' x=$lstReviewHotel.food_drink assign=food_drink}
                                    {else}
                                        {assign var=food_drink value=0}
                                    {/if}
                                    <label class="lbl_rate_score d-flex justify-content-between align-items-center">
                                        {$core->get_Lang('Cleanliness')}
                                        <span>{$food_drink}</span>
                                    </label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{$food_drink}" aria-valuemin="0" aria-valuemax="100"
                                             style="width: {$lstReviewHotel.food_drink}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box_rate_score">
                                    {if $lstReviewHotel.clean}
                                        {math equation='x/10' x=$lstReviewHotel.clean assign=clean}
                                    {else}
                                        {assign var=clean value=0}
                                    {/if}
                                    <label class="lbl_rate_score d-flex justify-content-between align-items-center">
                                        {$core->get_Lang('Value for money')}
                                        <span>{$clean}</span>
                                    </label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{$clean}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {$lstReviewHotel.clean}%"></div>
                                    </div>
                                </div>
                                <div class="box_rate_score">
                                    {if $lstReviewHotel.worthy}
                                        {math equation='x/10' x=$lstReviewHotel.worthy assign=worthy}
                                    {else}
                                        {assign var=worthy value=0}
                                    {/if}
                                    <label class="lbl_rate_score d-flex justify-content-between align-items-center">
                                        {$core->get_Lang('Comfort')}
                                        <span>{$worthy}</span>
                                    </label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{$worthy}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {$lstReviewHotel.worthy}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hnv_hotel_detail_main_review_detail">
                    <div class="hnv_hotel_detail_main_review_detail_title">
                        <h2>{$core->get_Lang('Guests who stayed here loved')}</h2>
                        {*<a href="#" class="hnv_hotel_detail_main_review_detail_button"
                           title="{$core->get_Lang('Read all review')}">{$core->get_Lang('Read all review')}</a>*}
                    </div>
                    <div class="hnv_hotel_detail_main_review_detail_content">
                        <div class="hnv_hotel_detail_main_review_detail_content_list owl-carousel">
                            {section name=i loop=$lstReview}
                                {assign var=reviews_content value=$clsReviews->getContent($lstReview[i].reviews_id,400,true,$lstReview[i])}
                                <div class="hnv_hotel_detail_main_review_detail_content_item review_item">
                                    <div class="hnv_hotel_detail_main_review_detail_content_item_guest_info">
                                        <div class="hnv_hotel_detail_main_review_detail_content_item_guest_info_avatar avatar">
                                            {$lstReview[i].fullname|truncate:1:"":true}
                                        </div>
                                        <div class="hnv_hotel_detail_main_review_detail_content_item_guest_info_detail">
                                            <div class="hnv_hotel_detail_main_review_detail_content_item_guest_info_detail_name">
                                                {$lstReview[i].fullname}
                                            </div>
                                            <div class="hnv_hotel_detail_main_review_detail_content_item_guest_info_detail_country">
                                                <img src="https://flagcdn.com/48x36/{$clsCountry->getClassFlag($lstReview[i].country_id)}.png"
                                                     width="16" height="12"
                                                     alt="{$clsCountry->getTitle($lstReview[i].country_id)}">
                                                {$clsCountry->getTitle($lstReview[i].country_id)}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hnv_hotel_detail_main_review_detail_content_item_guest_review_short content_review_short">
                                        {$clsISO->truncateWord($lstReview[i].content,30,"... $btn_view_more")|html_entity_decode}
                                    </div>

                                    <div class="content_review content_review_full" style="display:none">
                                        {$lstReview[i].content|html_entity_decode}
                                    </div>
                                </div>
                            {/section}
                        </div>
                    </div>
                </div>
            </div>
            {if $arr_hotel_category}
                <div id="hnv_hotel_detail_main_facilities" class="hnv_scrollspy_item hnv_hotel_detail_main_facilities">
                    <div class="hnv_hotel_detail_main_facilities_title">
                        <h2>{$core->get_Lang('Facilities of')} {$title_hotel}</h2>
                    </div>
                    <div class="hnv_hotel_detail_main_facilities_content"
                         {if $deviceType ne 'phone'}style="column-count: 4;" {else} style="column-count: 2;"{/if}>
                        {foreach from=$arr_hotel_category key=key item=item}
                            {assign var="HotelPropertyID" value=$item.hotel_property_id}
                            {assign var="HotelPropertyTitle" value=$item.title}
                            {assign var="HotelProperties" value=$clsProperty->getTitleByCatId($HotelPropertyID, $hotel_id, 'FE_2024')}
                            {if $HotelProperties ne ''}
                                <div class="hnv_hotel_detail_main_facilities_content_item" style="break-inside: avoid;">
                                    <div class="hnv_hotel_detail_main_facilities_content_item_title">
                                        <h4>{$HotelPropertyTitle}</h4>
                                    </div>
                                    <ul class="hnv_hotel_detail_main_facilities_content_item_list">
                                        {$HotelProperties}
                                    </ul>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            {/if}
            <div id="hnv_hotel_detail_main_policies" class="hnv_scrollspy_item hnv_hotel_detail_main_policies">
                <div class="hnv_hotel_detail_main_policies_title">
                    <h2>{$core->get_Lang('Property policies')}</h2>
                </div>
                <div class="hnv_hotel_detail_main_policies_content">
                    <div class="hnv_hotel_detail_main_policies_content_list">
                        {if $clsHotel->getTimeCheckInOut($hotel_id, 'hour_in')}
                            <div class="hnv_hotel_detail_main_policies_content_item">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="hnv_hotel_detail_main_policies_content_item_left">
                                            <i class="fa-light fa-timer"></i>
                                            {$core->get_Lang('Check-in')}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <div class="hnv_hotel_detail_main_policies_content_item_right">
                                            {$core->get_Lang('From')} {$clsHotel->getTimeCheckInOut($hotel_id, 'hour_in')}
                                            :{$clsHotel->getTimeCheckInOut($hotel_id, 'minute_in')}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        {if $clsHotel->getTimeCheckInOut($hotel_id, 'hour_out')}
                            <div class="hnv_hotel_detail_main_policies_content_item">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="hnv_hotel_detail_main_policies_content_item_left">
                                            <i class="fa-light fa-timer"></i>
                                            {$core->get_Lang('Check-out')}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <div class="hnv_hotel_detail_main_policies_content_item_right">
                                            {$core->get_Lang('Until')} {$clsHotel->getTimeCheckInOut($hotel_id, 'hour_out')}
                                            :{$clsHotel->getTimeCheckInOut($hotel_id, 'minute_out')}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        {if $oneItem['booking_policy']}
                            <div class="hnv_hotel_detail_main_policies_content_item">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="hnv_hotel_detail_main_policies_content_item_left">
                                            <i class="fa-light fa-square-info"></i>
                                            {$core->get_Lang('Booking Policy')}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <div class="hnv_hotel_detail_main_policies_content_item_right">
                                            {$oneItem['booking_policy']|html_entity_decode}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        {if $oneItem['child_policy']}
                            <div class="hnv_hotel_detail_main_policies_content_item">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="hnv_hotel_detail_main_policies_content_item_left">
                                            <i class="fa-light fa-square-info"></i>
                                            {$core->get_Lang('Children and bed policy')}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <div class="hnv_hotel_detail_main_policies_content_item_right">
                                            {$oneItem['child_policy']|html_entity_decode}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        {if $oneItem['cancellation_policy']}
                            <div class="hnv_hotel_detail_main_policies_content_item">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="hnv_hotel_detail_main_policies_content_item_left">
                                            <i class="fa-light fa-square-info"></i>
                                            {$core->get_Lang('Cancellation Policy')}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <div class="hnv_hotel_detail_main_policies_content_item_right">
                                            {$oneItem['cancellation_policy']|html_entity_decode}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        {if $oneItem['other_policy']}
                            <div class="hnv_hotel_detail_main_policies_content_item">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="hnv_hotel_detail_main_policies_content_item_left">
                                            <i class="fa-light fa-square-info"></i>
                                            {$core->get_Lang('Other rules')}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <div class="hnv_hotel_detail_main_policies_content_item_right">
                                            {$oneItem['other_policy']|html_entity_decode}
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
</section>
<section class="hnv_hotel_detail_other">
    <div class="container">
        <div class="hnv_hotel_detail_other_content">
            <h3>{$core->get_Lang('The Best of')} {$hotel_city}</h3>
            <a href="{$link_by_city}" title="{$core->get_Lang('More hotels')}">
                {$core->get_Lang('Click here to see more hotels and other accommodations in')} {$hotel_city}
            </a>
        </div>
    </div>
</section>
{if $arr_recent_hotel}
    <section class="hnv_hotel_detail_recent">
        <div class="container">
            <div class="hnv_hotel_detail_recent_title">
                <h2>{$core->get_Lang('Recently Viewed')}</h2>
            </div>
            <div class="hnv_hotel_detail_recent_content">
                <div class="hnv_hotel_detail_recent_content_list owl-carousel">
                    {foreach from=$arr_recent_hotel key=key item=item}
                        {assign var=recent_hotel_id value=$item}
                        {assign var=recent_hotel_title value=$clsHotel->getTitle($recent_hotel_id)}
                        {assign var=recent_hotel_link value=$clsHotel->getLink($recent_hotel_id)}
                        {assign var=recent_hotel_image value=$clsHotel->getImage($recent_hotel_id,298,276)}
                        {assign var=recent_hotel_city value=$clsHotel->getCityHotel($recent_hotel_id)}
                        {assign var=recent_hotel_price value=$clsHotelRoom->getByCond("hotel_id = "|cat:$recent_hotel_id, "price")}
                        {assign var=recent_textRateAvg value=$clsReviews->getTextRateAvg($recent_hotel_id,'hotel')}
                        {assign var=is_online value=$clsHotel->checkisOnline($recent_hotel_id)}

                        {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
                            {assign var=recent_ratingValue value= $clsReviews->getRateAvg($recent_hotel_id,'hotel','10')}
                            {assign var=recent_bestRating value= $clsReviews->getBestRate($recent_hotel_id,'hotel')}
                            {assign var=recent_ratingCount value= $clsReviews->getToTalReview($recent_hotel_id,'hotel')}
                        {else}
                            {assign var=recent_ratingValue value= $clsReviews->getRateAvgNoLogin($recent_hotel_id,'hotel','10')}
                            {assign var=recent_bestRating value= $clsReviews->getBestRate($recent_hotel_id,'hotel')}
                            {assign var=recent_ratingCount value= $clsReviews->getToTalReviewNoLogin($recent_hotel_id,'hotel')}
                        {/if}

                        {if $is_online}
                            <div class="hnv_hotel_detail_recent_content_item" data-merge="1">
                                <a href="{$recent_hotel_link}" title="{$recent_hotel_title}"
                                   class="hnv_hotel_detail_recent_content_item_image">
                                    <img data-src="{$recent_hotel_image}"
                                         width="298" height="276" class="scale_img_hover owl-lazy"
                                         alt="{$recent_hotel_title}">
                                    {if $recent_hotel_city}
                                        <label class="hnv_hotel_recent_content_carousel_item_image_tag">
                                            {$recent_hotel_city}
                                        </label>
                                    {/if}
                                </a>
                                <div class="hnv_hotel_detail_recent_content_item_content">
                                    <h3 class="hnv_hotel_detail_recent_content_item_content_title">
                                        <a href="{$recent_hotel_link}"
                                           title="{$recent_hotel_title}">{$recent_hotel_title}</a>
                                    </h3>
                                    <div class="hnv_hotel_detail_recent_content_item_content_review">
                                        {if $recent_ratingValue eq '0'}
                                            <div class="hnv_hotel_detail_recent_content_item_content_review_score bg_none_reviews">
                                                {$recent_ratingValue}
                                            </div>
                                            <div class="hnv_hotel_detail_recent_content_item_content_review_text txt_none_reviews">
                                                {$recent_textRateAvg}
                                            </div>
                                        {else}
                                            <div class="hnv_hotel_detail_recent_content_item_content_review_score">
                                                {$recent_ratingValue}
                                            </div>
                                            <div class="hnv_hotel_detail_recent_content_item_content_review_text">
                                                {$recent_textRateAvg}
                                            </div>
                                            <div class="hnv_hotel_detail_recent_content_item_content_review_total">
                                                | {$recent_ratingCount} {$core->get_Lang('reviews')}
                                            </div>
                                        {/if}
                                    </div>
                                    <div class="hnv_hotel_detail_recent_content_item_content_price">
                                        {if isset($recent_hotel_price['price']) && $recent_hotel_price['price'] > 0}
                                            {$core->get_Lang('from')}
                                        {/if}
                                        <span>
                                            {$clsHotel->getPriceOnPromotionNew($recent_hotel_id, 'detail')}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        {/if}
                    {/foreach}
                </div>
            </div>
        </div>
    </section>
{/if}

<div class="modal fade" id="mdReview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="box_content content_reviews"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var hotel_id = '{$hotel_id}';
    var iso_number_adults = '{$iso_number_adults}';
    var iso_number_child = '{$iso_number_child}';
    var iso_number_rooms = '{$iso_number_rooms}';
    var iso_check_in = '{$iso_check_in}';
    var iso_check_out = '{$iso_check_out}';
    $_View_more = "{$core->get_Lang('View more')}";
    $_View_less = "{$core->get_Lang('View less')}";
</script>
