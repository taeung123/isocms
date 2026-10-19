{assign var=title_tour value=$clsTour->getTitle($tour_id)}
{assign var=oneItemCatTour value=$clsTourCategory->getOne($tourcat_id,'title,slug')}
{assign var=titleCatTour value=$oneItemCatTour.title}
{assign var=linkCatTour value=$clsTourCategory->getLink($tourcat_id,$oneItemCatTour)}
{assign var=getTripDuration value=$clsTour->getTripDuration2019($tour_id)}
{assign var=Depart_point value=$clsTour->getListDeparturePointLink($tour_id)}
{assign var=Address value=$clsTour->getLCityAround2($tour_id)}
{assign var=listCityAround value=$clsTour->getLCityAround4($tour_id)}

{assign var = _Inclusion value = $clsTour->getInclusion($tour_id,$oneItem)}
{assign var = _Exclusion value = $clsTour->getExclusion($tour_id,$oneItem)}
{assign var = _ThingToCarry value = $clsTour->getThingToCarry($tour_id,$oneItem)}
{assign var = _CancellationPolicy value = $clsTour->getCancellationPolicy($tour_id,$oneItem)}
{assign var = _RefundPolicy value = $clsTour->getRefundPolicy($tour_id,$oneItem)}
{assign var = _ConfirmationPolicy value = $clsTour->getConfirmationPolicy($tour_id,$oneItem)}

{assign var=textRateAvg value=$clsReviews->getTextRateAvg($tour_id,'tour')}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var="getToTalReview" value=$clsReviews->getToTalReview($tour_id,'tour')}
    {assign var="getStarNewIcon" value=$clsReviews->getStarNewIcon($tour_id,'tour')}
    {assign var="getRateAvg" value=$clsReviews->getRateAvg($tour_id,'tour')}
    {assign var="getStarNew" value=$clsReviews->getStarNew($tour_id,'tour')}
{else}
    {assign var="getToTalReview" value=$clsReviews->getToTalReviewNoLogin($tour_id,'tour')}
    {assign var="getStarNewIcon" value=$clsReviews->getStarNewIconNoLogin($tour_id,'tour')}
    {assign var="getRateAvg" value=$clsReviews->getRateAvgNologin($tour_id,'tour')}
    {assign var="getStarNew" value=$clsReviews->getStarNewNoLogin($tour_id,'tour')}
{/if}

{assign var=getFlagText value=$clsPromotion->getFlagText($promotion_id)}
{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
{assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,'detail')}
{assign var=getPriceTourPromotionnomem value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,'nomem')}

<section class="detail_tour_mobile d-md-block d-lg-none">
    <div class="img_tour_detail">
        {if $lstImage}
            <div class="owl-carousel owl-theme owl_img_tour">
                {foreach from=$lstImage key=key item=item}
                    <div class="img_tour_section">
                        <img data-src="{$clsTourImage->getImage($item.tour_image_id,324,272)}"
                             alt="{$item.title}" width="324" height="272" class="tour_img_detail owl-lazy">
                    </div>
                {/foreach}
            </div>
        {/if}
        <div class="tour_detail_mobile">
            <div class="container">
                <div class="title_intro_reviews_detail">
                    <div class="hnv_tour_detail_intro_title">
                        <h1>{$title_tour}</h1>
                    </div>
                    <div class="hnv_tour_detail_intro_review">
                        <div class="reviews_tour_detail">
                            <div class="hnv_tour_detail_intro_review_star">
                                {$getStarNewIcon}
                            </div>
                            <div class="hnv_tour_detail_intro_review_text">
                                {$getRateAvg} <span>({$getToTalReview} {$core->get_Lang('reviews')})</span>
                            </div>
                        </div>

                        <div class="hnv_tour_detail_intro_reviews">
                            {if $getTripDuration}
                                <div class="hnv_tour_detail_intro_review_duration">
                                    <i class="fa-light fa-clock"></i>
                                    <span>{$core->get_Lang('Duration')}:</span> {$getTripDuration}
                                </div>
                            {/if}
                            {if $Depart_point}
                                <div class="hnv_tour_detail_intro_review_start">
                                    <i class="fa-light fa-location-dot" aria-hidden="true"></i>
                                    <span>{$core->get_Lang('Start')}:</span> {$Depart_point}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
                {if $oneItem.is_best_price && $oneItem.is_recommended}
                    <div class="hnv_tour_detail_intro_suggest">
                        <ul class="hnv_tour_detail_intro_suggest_list">
                            {if $oneItem.is_best_price}
                                <li class="hnv_tour_detail_intro_suggest_item">
                                    <i class="fa-light fa-star"></i> {$core->get_Lang('Best Price')}
                                </li>
                            {/if}
                            {if $oneItem.is_recommended}
                                <li class="hnv_tour_detail_intro_suggest_item">
                                    <i class="fa-light fa-heart"></i> {$core->get_Lang('Recommended')}
                                </li>
                            {/if}
                        </ul>
                    </div>
                {/if}

                <div id="fixedDiv" class="fixed-div">
                    <div class="container">
                        <div class="price_button_fixed">
                            {if $getPriceTourPromotion}
                                <div class="price">
                                    <p>{$core->get_Lang('From')}</p>
                                    {$getPriceTourPromotion} <span
                                            class="color_666 size16">{$core->get_Lang('per person')}</span>
                                </div>
                            {else}
                                <div class="price">
                                        <span class="size24 color_fb1111 color_c81e3a text_bold">
                                            {$core->get_Lang('Contact')}
                                        </span>
                                </div>
                            {/if}
                            <button class="hnv_btn_scroll btn_yellow btn_main">{$core->get_Lang('Check Availability')}</button>
                        </div>
                    </div>
                </div>

                <div class="hnv_tour_detail_gallery_right">
                    <div class="hnv_tour_detail_gallery_right_top">

                        {if $date_coutdown}
                            {if $getFlagText}
                                <div class="sale_off">{$getFlagText}</div>{/if}
                            <div>
                                <div class="price" style="margin-bottom: 24px;">
                                    {if $getPriceTourPromotion}
                                        <p>{$core->get_Lang('From')}</p>
                                        {$getPriceTourPromotion}
                                        <span class="color_666 size16">{$core->get_Lang('per person')}</span>
                                    {/if}
                                </div>
                                <button class="hnv_btn_scroll btn_yellow btn_main">{$core->get_Lang('Check Availability')}</button>
                            </div>
                            <div class="offerDate">
                                <div class="d-flex offerDate__box">
                                    <div class="text_bold color_24b89c">{$core->get_Lang('Last minute deal')}</div>
                                    <div class="sale_clock">
                                        <ul class="clock lastHour" data-date="{$date_coutdown}"
                                            data-promotion_id="{$promotion_id}" style="float:left !important">
                                            <li><span class="days fw600 fs30">00</span>
                                                <p class="days_text ">{$core->get_Lang('Days')}</p></li>
                                            <li><span class="hours fw600 fs30">00</span>
                                                <p class="hours_text ">{$core->get_Lang('Hours')}</p></li>
                                            <li><span class="minutes fw600 fs30">00</span>
                                                <p class="minutes_text ">{$core->get_Lang('Mins')}</p></li>
                                            <li><span class="seconds fw600 fs30">00</span>
                                                <p class="seconds_text ">{$core->get_Lang('Secs')}</p></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="mt10">{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
                            </div>
                        {else}
                            {if $getPriceTourPromotion}
                                {if $getFlagText}
                                    <div class="sale_off">{$getFlagText}</div>{/if}
                                <div>
                                    <div class="price" style="margin-bottom: 24px;">
                                        <p>{$core->get_Lang('From')}</p>
                                        {$getPriceTourPromotion} <span
                                                class="color_666 size16">{$core->get_Lang('per person')}</span>
                                    </div>
                                    <button class="hnv_btn_scroll btn_yellow btn_main">{$core->get_Lang('Check Availability')}</button>
                                </div>
                                {if $first_start_date}
                                    <div class="offerDate">
                                        <p>{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
                                    </div>
                                {/if}
                            {else}
                                <div>
                                    <div class="price" style="margin-bottom: 24px;">
                                        <span class="size24 color_fb1111 color_c81e3a text_bold">
                                            {$core->get_Lang('Contact')}
                                        </span>
                                    </div>
                                    <button class="hnv_btn_scroll btn_yellow btn_main margin_0_auto">{$core->get_Lang('Check Availability')}</button>
                                </div>
                                {if $first_start_date}
                                    <div class="offerDate">
                                        <p>{$core->get_Lang('Latest departure date')}: {$first_start_date}</p>
                                    </div>
                                {/if}
                            {/if}
                        {/if}
                        <ul class="hnv_tour_detail_gallery_right_top_policy">
                            <li class="hnv_tour_detail_gallery_right_top_policy_item">
                                <i class="fa-duotone fa-light fa-circle-check"></i>
                                <label>
                                    <span>{$core->get_Lang("Free cancellation")}</span> {$core->get_Lang("up to 24 hours before the experience starts (local time)")}
                                </label>
                            </li>
                            <li class="hnv_tour_detail_gallery_right_top_policy_item">
                                <i class="fa-duotone fa-light fa-circle-check"></i>
                                <label>
                                    <span>{$core->get_Lang("Reserve Now and Pay Later")}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="hnv_tour_detail_gallery_right_bottom">
                        <div class="hnv_tour_detail_gallery_right_bottom_title">
                            <h2>{$core->get_Lang("Plan your adventure")}</h2>
                        </div>
                        <div class="hnv_tour_detail_gallery_right_bottom_content">
                            <ul class="hnv_tour_detail_gallery_right_bottom_content_list">
                                {if $oneItem['file_programme']}
                                    <li class="hnv_tour_detail_gallery_right_bottom_content_item">
                                        <a href="{$oneItem['file_programme']}" download="{$oneItem['file_programme']}"
                                           title="{$core->get_Lang("Download PDF Brochure")}">
                                            <i class="fa-light fa-arrow-down-to-bracket"></i> {$core->get_Lang("Download tour program PDF")}
                                        </a>
                                    </li>
                                {/if}
                                <li class="hnv_tour_detail_gallery_right_bottom_content_item">
                                    <a href="{$clsISO->getLink('faqs')}" target="_blank"
                                       title="{$core->get_Lang("Ask a Question")}">
                                        <i class="fa-light fa-circle-question"></i> {$core->get_Lang("Ask a Question")}
                                    </a>
                                </li>
                                <li class="hnv_tour_detail_gallery_right_bottom_content_item">
                                    <a href="{$clsISO->getLink('tailor')}" target="_blank"
                                       title="{$core->get_Lang("Tailor made tour")}">
                                        <i class="fa-light fa-grid-2-plus"></i> {$core->get_Lang("Tailor made tour")}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('.owl_img_tour').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                nav: false,
                lazyLoad: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                }
            })

            $(document).ready(function() {
                $(window).scroll(function() {
                    var fixedDiv = $('#fixedDiv');
                    var galleryDiv = $('.hnv_tour_detail_gallery_right_top');
                    var availabilityDiv = $('#hnv_tour_detail_main_date_availability');
                    var footer = $('footer');

                    var galleryOffset = galleryDiv.offset().top + galleryDiv.outerHeight();
                    var availabilityOffset = availabilityDiv.offset().top;
                    var footerOffset = footer.offset().top;

                    var scrollTop = $(this).scrollTop();
                    var windowHeight = $(window).height();

                    // Khi cuộn đến galleryDiv
                    if (scrollTop + windowHeight > galleryDiv.offset().top && scrollTop < galleryOffset) {
                        fixedDiv.removeClass('show');
                    } else {
                        fixedDiv.addClass('show');
                    }

                    // Khi cuộn đến availabilityDiv
                    if (scrollTop + windowHeight > availabilityOffset && scrollTop < availabilityOffset + availabilityDiv.outerHeight()) {
                        fixedDiv.removeClass('show');
                    }

                    // Khi cuộn đến footer
                    if (scrollTop + windowHeight > footerOffset) {
                        fixedDiv.removeClass('show');
                    }
                });
            });
        })
    </script>
    <style>
        @media (max-width: 991px) {
            .img_tour_detail {
                margin-bottom: 24px
            }

            .hnv_tour_detail_intro_reviews .reviews_star_reviews {
                display: flex;
                gap: 6px;
            }

            .hnv_tour_detail_intro_reviews {
                display: flex;
                flex-direction: column;
                gap: 7px;
            }

            .hnv_tour_detail_intro_reviews .hnv_tour_detail_intro_review_duration, .hnv_tour_detail_intro_reviews .hnv_tour_detail_intro_review_start {
                display: flex;
                gap: 6px;
                align-items: center;
            }

            .img_detail_tour_mb {
                width: 100%;
                height: revert-layer;
            }

            .detail_mobile_detail .hnv_tour_detail_intro_suggest {
                margin-top: 16px;
            }

            .detail_mobile_detail .hnv_tour_detail_gallery_right {
                margin-bottom: 20px;
            }

            .detail_tour_mobile .hnv_tour_detail_intro_review {
                display: flex;
                flex-direction: column;
                gap: 7px;
            }

            .reviews_tour_detail {
                display: flex;
                gap: 6px;
            }

            .tour_detail_mobile .container, .hnv_tour_detail_gallery .container {
                padding-right: 15px;
                padding-left: 15px;
            }

            .tour_detail_mobile .hnv_tour_detail_intro_title {
                margin-top: 24px;
                margin-bottom: 16px;
            }

            .hnv_tour_detail_intro_review {
                margin-bottom: 16px;
            }

            .fixed-div {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: white;
                padding: 10px;
                z-index: 1000;
                box-shadow: 0 0 12px rgba(48, 117, 157, .2);
                transform: translateY(100%); /* Ẩn xuống dưới ban đầu */
                transition: transform 0.3s ease-in-out; /* Hiệu ứng trượt trong 0.3 giây */
            }

            /* Trạng thái khi hiển thị */
            .fixed-div.show {
                transform: translateY(0); /* Trượt lên vị trí ban đầu */
            }


            .fixed-div .price_button_fixed {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .tour_new_detaildeparture2024_body  #backTop {
                bottom: 73px !important;
            }

            .tour_new_detaildeparture2024_body .cookie-banner {
                bottom: 64px !important;
                transition: margin-top 0.3s; /* Thêm hiệu ứng chuyển động */

            }
        }
    </style>
{/literal}