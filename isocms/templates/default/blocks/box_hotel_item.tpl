{assign var = link value = $clsHotel->getLink2($hotel_id,$arrHotel)}
{assign var = title value = $clsHotel->getTitle($hotel_id,$arrHotel)}
{assign var = getImageStar value = $clsHotel->getHotelStar($hotel_id,$arrHotel)}
{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var= ratingValue value= $clsReviews->getRateAvg($hotel_id,'hotel','10')}
    {assign var= bestRating value= $clsReviews->getBestRate($hotel_id,'hotel')}
    {assign var= ratingCount value= $clsReviews->getToTalReview($hotel_id,'hotel')}
{else}
    {assign var= ratingValue value= $clsReviews->getRateAvgNoLogin($hotel_id,'hotel','10')}
    {assign var= bestRating value= $clsReviews->getBestRate($hotel_id,'hotel')}
    {assign var= ratingCount value= $clsReviews->getToTalReviewNoLogin($hotel_id,'hotel')}
{/if}
{assign var=textRateAvg value=$clsReviews->getTextRateAvg($hotel_id,'hotel')}
<div class="box_hotel_item {$package_id}">
    <div class="img_hotel">
        <a class="photo" href="{$link}" title="{$title}">
            <img class="img-responsive img100" src="{$clsHotel->getImage($hotel_id,277,181,$arrHotel)}" alt="{$title}"/>
        </a>
    </div>
    <div class="box_item_body">
        <div class="box_left_body">
            <h3 class="box_body_title">
                <a href="{$link}" title="{$title}">{$title}</a>
                {$clsHotel->getStarNew($hotel_id,$arrHotel)}
                {*{if $getImageStar != null}<img class="star" height="19" src="{$getImageStar}" alt="star" style="width: auto" />{/if}*}
            </h3>
            <div class="address">
                <i class="fa fa-map-marker"></i>
                {$clsHotel->getAddress($hotel_id,$arrHotel)}
                <a role="link" title="map" data-bs-toggle="modal"
                   data-bs-target="#mapModal{$hotel_id}">{$core->get_Lang('Show map')}</a>
            </div>
        </div>
        <div class="box_right_body">
            <div class="review">
                <p>{$textRateAvg} <span>{$ratingCount} {$core->get_Lang('reviews')}</span></p>
                <div class="rate">{$ratingValue|number_format:1}</div>
            </div>
            <div class="box_price">
                <div class="price_from_text">{$core->get_Lang('Only from')}</div>
                <div class="div_price">{$clsHotel->getPriceOnPromotion($hotel_id)}</div>
                <div class="btn_view_detail no_phone"><a class="bg_main" href="{$link}"
                                                         title="{$core->get_Lang('View Detail')}">{$core->get_Lang('View Detail')}
                        <i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
            </div>

        </div>
        <div class="btn_view_detail phone"><a class="bg_main" href="{$link}"
                                              title="{$core->get_Lang('View Detail')}">{$core->get_Lang('View Detail')}
                <i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
    </div>

    <div class="modal fade mapModal" id="mapModal{$hotel_id}" tabindex="-1" aria-labelledby="mapModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="https://maps.google.it/maps?q={$clsHotel->getAddressMapView($hotel_id,$arrHotel)}&output=embed"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

</div>