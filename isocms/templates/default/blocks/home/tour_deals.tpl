{if !empty($listSelected)}
    <section class="minute_deals">
        <div class="container">
            <div class="deal_tours">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="txtlastdeal">{$core->get_Lang('Last minute deals')}</h2>
                    <a href="{$_LANG_ID}/tours" class="btn btn_viewmore">{$core->get_Lang('View more')}</a>
                </div>
                <div class="swiper owl-dealcard">
                    <div class="swiper-wrapper">
                        {foreach from=$listSelected item=item}
                            {assign var=dealtour_id value=$item.tour_id}
                            {assign var=allotment value=$item.allotment}
                            {assign var=start_date value=$item.start_date}
                            {assign var=open_sale_date value=$item.open_sale_date}
                            {assign var=close_sale_date value=$item.close_sale_date}
                            {assign var=ratingValue value=$clsReviews->getRateAvg($dealtour_id,'tour','5')}
                            {assign var=bestRating value=$clsReviews->getBestRate($dealtour_id,'tour')}
                            {assign var=ratingCount value=$clsReviews->getToTalReview($dealtour_id,'tour')}
                            {assign var=getStarNew value=$clsReviews->getStarNew($dealtour_id,'tour')}
                            {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($dealtour_id,$now_day,$is_agent)}
                            <div class="swiper-slide card deal-card" data-merge="1">

                                <a href="{$clsTour->getLink($dealtour_id)}"
                                title="{$clsTour->getTitle($dealtour_id)}">

                                    <img src="{$clsTour->getImage($dealtour_id,487,272)}"
                                        class="card-img-top deal-img relative img100"
                                        alt="{$clsTour->getTitle($dealtour_id)}">

                                    <span class="badge deal-badge">
                                        {$core->get_Lang('Likely to Sell Out')}
                                    </span>

                                    <div class="card-body card_deals">
                                        <h3 class="card-title title_card text_linelimit2">
                                            {$clsTour->getTitle($dealtour_id)}
                                        </h3>
                                        <div class="deal_rate box_col">
                                            <label class="rate-2019">{$getStarNew}</label>
                                            <span class="review_text">
                                                {$ratingValue|number_format:1} ({$ratingCount})
                                            </span>
                                        </div>

                                        <div class="location_time">
                                            <span class="txt_locationstart">
                                                <i class="fa-light fa-location-dot"></i>
                                                {$core->get_Lang('Start')}: {$clsTour->getListDeparturePoint($dealtour_id)}
                                            </span>
                                            <span class="txt_locationstart">
                                                <i class="fa-light fa-clock-three"></i>
                                                {$clsISO->converTimeToText5($start_date)}
                                            </span>
                                        </div>

                                        <div class="txt_pricedeal">
                                            {if $getPriceTourPromotion}
                                                <span class="mb-0 txt_dealfrom">
                                                    {$core->get_Lang('from')}
                                                </span>
                                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:12px">
                                                    {$getPriceTourPromotion}
                                                    {if $allotment}
                                                        <span class="txt_dealseats">
                                                            {$allotment} {$core->get_Lang('seats left')}
                                                        </span>
                                                    {/if}
                                                </div>
                                            {else}
                                                <div class="d-flex justify-content-between align-items-center" style="margin:32px 0">
                                                    <h3 class="txt_contactprice">
                                                        {$core->get_Lang('Contact')}
                                                    </h3>
                                                    {if $allotment}
                                                        <span class="txt_dealseats">
                                                            {$allotment} {$core->get_Lang('seats left')}
                                                        </span>
                                                    {/if}
                                                </div>
                                            {/if}
                                        </div>

                                        <div class="border_timeleft"
                                            open_sale_date="{$open_sale_date}"
                                            close_sale_date="{$close_sale_date}">
                                            <p class="time_lefttxt"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        {/foreach}

                    </div>

                    {* Navigation giữ icon cũ *}
                    <div class="swiper-button-prev">
                        <i class="fa-solid fa-angle-left"></i>
                    </div>
                    <div class="swiper-button-next">
                        <i class="fa-solid fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
