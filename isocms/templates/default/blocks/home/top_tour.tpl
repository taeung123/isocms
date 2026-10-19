{if $listTopTour}
<section class="favorite_choice">
    <div class="container">
            <div class="viewmore_btnn">
                <h2 class="txt_coupon">{$core->get_Lang("Travelers’ favorite choice")}</h2>
                <a href="{$clsISO->getLink('search_tour')}" class="btn btn_viewmore">
                    {$core->get_Lang('View all tours')}
                </a>
            </div>
       
        <div class="row">
            {foreach from=$listTopTour key=key item=tour} 
                {assign var=tour_id value=$tour.tour_id}
                {assign var=getLTripDuration value=$clsTour->getLTripDuration($tour_id)}
                {assign var=getLink value=$clsTour->getLink($tour_id, $tour)}
                {assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id, 'tour')}
                {assign var=getRateStar value=$clsReviews->getRateStar($tour_id, 'tour')}

                {assign var=getPriceTour value=$clsTour->getTripPrice($tour_id, $now_day, $is_agent)}
                {assign var=percent_promotion value=$clsISO->getPromotion($tour_id, 'Tour', $now_day, $now_day, 'info_promotion')}
                {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id, $now_day, $is_agent)}

                <div class="col-md-4" style="margin-bottom: 32px; position: relative">
                    <div class="fav_item deal-card">
                        <a class="img_travels" href="{$getLink}" title="{$tour.title}">
                            <img class="img100 img_favtravel"
                                src="{$clsISO->tripslashImage($tour.image,407,272)}"
                                alt="{$tour.title}"
                                width="407" height="272" loading="lazy">
                            {if isset($percent_promotion.discount_value)}
                                <div class="discount-tag">
                                    {if $percent_promotion.discount_type eq 1}
                                        {if $_LANG_ID eq 'vn'}
                                            -{$percent_promotion.discount_value}{$clsISO->getShortRateText()}
                                        {else}
                                            -{$clsISO->getShortRateText()}{$percent_promotion.discount_value}
                                        {/if}
                                    {else}
                                        -{$percent_promotion.discount_value}%
                                    {/if}
                                </div>
                            {/if}
                        </a>
                        <div class="card-body body_favtravel">
                            {if $clsTour->getListDeparturePoint($tour_id, $tour) ne ''}
                                <p class="txt_locationstart">
                                    <i class="fa-light fa-location-dot"></i>
                                    {$core->get_Lang('Start')}:
                                    {$clsTour->getListDeparturePoint($tour_id, $tour)}
                                </p>
                            {/if}
                            <a href="{$getLink}" title="{$tour.title}">
                                <h3 class="card-title title_card text_linelimit2">{$tour.title}</h3>
                            </a>
                            <div class="deal_rate box_col">
                                <div class="box_date_tour">
                                    <p>{$clsTour->getTripDayText($tour_id)}</p>
                                    <p class="txt_dot_date">|</p>
                                </div>
                                <div class="box_col_rate">
                                    <span class="iso_hnv_rating_star_list">
                                        <i class="fa-thin fa-star"></i>
                                        <i class="fa-thin fa-star"></i>
                                        <i class="fa-thin fa-star"></i>
                                        <i class="fa-thin fa-star"></i>
                                        <i class="fa-thin fa-star"></i>
                                    </span>
                                    <span class="iso_hnv_rating_star_list iso_hnv_rating_star_list_absolute" style="width: {$tour.rate_star}%">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                </div>
                                <p class="review_text"> {$tour.avg_rates} ({$tour.total_reviews})</p>
                            </div>
                            <div class="txt_price">
                                <div class="numb_price">
                                    {if $getPriceTourPromotion}
                                        {$getPriceTourPromotion}
                                    {else}
                                        <p class="txt_numb_red">{$core->get_Lang('Contact')}</p>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}

        </div>
    </div>
</section>

{/if}
