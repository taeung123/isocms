{if $show == ''}
    {assign var=bgr_image_hotel value=$clsConfiguration->getImage('site_hotel_banner',1920,400)}
{else}
    {assign var=bgr_image_hotel value=$clsCountryEx->getImageBannerHotel($country_id,1920,400)}
{/if}
<section class="hnv_hotel_banner" style="background-image: url('{$bgr_image_hotel}');">
    <div class="hnv_hotel_banner_title">
        {if $_LANG_ID ne 'vn'}
            <h1>{$clsCountryEx->getTitle($country_id)} {$core->get_Lang('Hotels')}</h1>
        {else}
            <h1>{$core->get_Lang('Hotels')} {$clsCountryEx->getTitle($country_id)}</h1>
        {/if}
    </div>
    {if $show ne 'Country'}
        <div class="hnv_hotel_banner_intro container">
            {assign var=site_hotel_intro value=site_hotel_intro_|cat:$_LANG_ID}
            {$clsConfiguration->getValue($site_hotel_intro)|html_entity_decode}
        </div>
    {/if}
</section>
<section class="hnv_hotel">
    <div class="hnv_hotel_search">
        <div class="container">
            {$core->getBlock('iso_search_hotel')}
        </div>
    </div>
    <form action="{$smarty.server.REQUEST_URI|regex_replace:'/\\?.*$/':''}" id="hnv_filter_form_hotel" method="get">
        {$core->getBlock('2024_breadcrumb')}
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    {$core->getBlock('2024_filter_hotel')}
                </div>
                <div class="col-sm-12 col-lg-9">
                    <div class="hnv_hotel_main">
                        {if $intro_hotel}
                            <div class="hnv_hotel_main_intro short_content" data-height="150">
                                {$intro_hotel}
                            </div>
                        {/if}
                        <div class="hnv_hotel_main_sort">
                            <div class="hnv_hotel_main_sort_result">
                                {$totalRecord} {$core->get_Lang('results')}
                            </div>
                            <div class="hnv_hotel_main_sort_option">
                                <label>{$core->get_Lang('Sort by:')}</label>
                                {assign var="select" value=$clsISO->generateHotelSelectOptions()}
                                <select class="hnv_item_checkbox" name="hotel_sort">
                                    {section name=i loop=$select}
                                        {assign var="index" value=$smarty.section.i.index}
                                        <option value="{$index}"
                                                {if $hotel_sort == $index}selected{/if}>{$select[i]}</option>
                                    {/section}
                                </select>
                            </div>
                        </div>
                        <div class="hnv_hotel_main_list">
                            {if $listHotelPlace}
                                {foreach from=$listHotelPlace key=key item=item}
                                    {assign var="hotel_id" value=$item.hotel_id}
                                    {assign var="hotel_title" value=$clsHotel->getTitle($hotel_id)}
                                    {assign var="hotel_link" value=$clsHotel->getLink($hotel_id)}
                                    {assign var="hotel_star" value=$clsHotel->getStar($hotel_id)}
                                    {assign var="hotel_location" value=$clsHotel->getLocationNew($hotel_id)}
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
                                    <div class="hnv_hotel_main_item">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-5 col-lg-4">
                                                <a href="{$hotel_link}" class="hnv_hotel_main_item_image">
                                                    <img src="{$clsHotel->getImage($hotel_id,292,194)}" width="292"
                                                         height="194" class="scale_img_hover" loading="lazy"
                                                         alt="{$hotel_title}">
                                                </a>
                                            </div>
                                            <div class="col-sm-12 col-md-7 col-lg-8">
                                                <div class="hnv_hotel_main_item_content">
                                                    <div class="hnv_hotel_main_item_content_title">
                                                        <h3>
                                                            <a href="{$hotel_link}" title="{$hotel_title}">
                                                                {$hotel_title}
                                                            </a>
                                                            {if $hotel_star}
                                                                <label class="hnv_hotel_main_item_content_title_star">
                                                                    {section name=i loop=$hotel_star}
                                                                        <i class="fa-solid fa-star"></i>
{*                                                                        <i class="fa-duotone fa-light fa-star"*}
{*                                                                           aria-hidden="true"></i>*}
                                                                    {/section}
                                                                </label>
                                                            {/if}
                                                        </h3>
                                                    </div>
                                                    <div class="hnv_hotel_main_item_content_rate">
                                                        {if $ratingValue eq '0'}
                                                            <div class="hnv_hotel_main_item_content_rate_number bg_none_reviews">
                                                                {$ratingValue|number_format:1}
                                                            </div>
                                                            <div class="hnv_hotel_main_item_content_rate_text txt_none_reviews">
                                                                {$textRateAvg}
                                                            </div>
                                                        {else}
                                                            <div class="hnv_hotel_main_item_content_rate_number">
                                                                {$ratingValue|number_format:1}
                                                            </div>
                                                            <div class="hnv_hotel_main_item_content_rate_text">
                                                                {$textRateAvg}
                                                            </div>
                                                            <div class="hnv_hotel_main_item_content_rate_quantity">
                                                                | {$ratingCount} {$core->get_Lang('reviews')}
                                                            </div>
                                                        {/if}
                                                    </div>
                                                    {if $hotel_location}
                                                        <div class="hnv_hotel_main_item_content_place">
                                                            <i class="fa-light fa-location-dot" aria-hidden="true"></i>
                                                            {$clsHotel->getLocationNew($hotel_id)}
                                                            <a href="javascript:void(0);"
                                                               title="{$core->get_Lang('View map')}"
                                                               class="hnv_hotel_main_item_content_place_map"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#mapModal{$hotel_id}">
                                                                {$core->get_Lang('View map')}
                                                            </a>
                                                        </div>
                                                        <div class="modal fade" id="mapModal{$hotel_id}" tabindex="-1"
                                                             aria-labelledby="mapModalLabel{$hotel_id}"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <iframe src="https://maps.google.it/maps?q={$clsHotel->getAddressMapView($hotel_id)}&output=embed"
                                                                                width="600" height="450"
                                                                                style="border:0;" allowfullscreen=""
                                                                                loading="lazy"
                                                                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {/if}
                                                    <div class="hnv_hotel_main_item_content_suggest">
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-6">
                                            <!--  -->
                                                            </div>
                                                            <div class="col-md-12 col-lg-6">
                                                                <div class="hnv_hotel_main_item_content_suggest_right">
                                                                    <div class="hnv_hotel_main_item_content_suggest_right_price">
                                                                        {$clsHotel->getPriceOnPromotion($hotel_id)}
                                                                    </div>
                                                                    <div class="hnv_hotel_main_item_content_suggest_right_include">
                                                                        {$core->get_Lang('per night includes taxes & fees')}
                                                                    </div>
                                                                    <a href="{$hotel_link}" title="{$hotel_title}"
                                                                       class="hnv_hotel_main_item_content_suggest_right_detail">
                                                                        {$core->get_Lang('View more')}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            {else}
                                <div class="hnv_hotel_main_item_empty">
                                    <div class="hnv_hotel_main_item_empty_image">
                                        <img src="{$clsISO->tripslashImage("{$URL_IMAGES}/empty_data2024.png", 403, 272)}"
                                             width="403" height="272" alt="Empty Hotel">
                                    </div>
                                    <div class="hnv_hotel_main_item_empty_title">
                                        <h4>{$core->get_Lang("No matches found")}</h4>
                                    </div>
                                    <div class="hnv_hotel_main_item_empty_note">
                                        {$core->get_Lang("We did not find the results you were looking for. Please search again or")}
                                        <a href="{$clsISO->getLink('contact')}" target="_blank"
                                           title="{$core->get_Lang("Contact us")}">
                                            {$core->get_Lang("contact us")}
                                        </a>
                                    </div>
                                    <a href="{$reset_filter}" class="hnv_hotel_main_item_empty_clear">
                                        {$core->get_Lang("Clear all filters")}
                                    </a>
                                </div>
                            {/if}
                            {if $totalPage gt '1'}
                                <div class="hnv_hotel_main_list_paginate">
                                    <div class="pagination pager">
                                        {$page_view}
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
                {if $arr_recent_hotel}
                    <div class="hnv_hotel_recent">
                        <div class="hnv_hotel_recent_title">
                            <h2>{$core->get_Lang('Recently Viewed')}</h2>
                        </div>
                        <div class="hnv_hotel_recent_content">
                            <div class="hnv_hotel_recent_content_carousel owl-carousel owl-theme">
                                {foreach from=$arr_recent_hotel key=key item=item}
                                    {assign var="recent_hotel_id" value=$item}
                                    {assign var="recent_hotel_title" value=$clsHotel->getTitle($recent_hotel_id)}
                                    {assign var="recent_hotel_link" value=$clsHotel->getLink2($recent_hotel_id)}
                                    {assign var="recent_hotel_star" value=$clsHotel->getStar($recent_hotel_id)}
                                    {assign var="recent_hotel_city" value=$clsHotel->getCityHotel($recent_hotel_id)}
                                    {if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
                                        {assign var= ratingValue value= $clsReviews->getRateAvg($recent_hotel_id,'hotel','10')}
                                        {assign var= bestRating value= $clsReviews->getBestRate($recent_hotel_id,'hotel')}
                                        {assign var= ratingCount value= $clsReviews->getToTalReview($recent_hotel_id,'hotel')}
                                    {else}
                                        {assign var= ratingValue value= $clsReviews->getRateAvgNoLogin($recent_hotel_id,'hotel','10')}
                                        {assign var= bestRating value= $clsReviews->getBestRate($recent_hotel_id,'hotel')}
                                        {assign var= ratingCount value= $clsReviews->getToTalReviewNoLogin($recent_hotel_id,'hotel')}
                                    {/if}
                                    {assign var=textRateAvg value=$clsReviews->getTextRateAvg($recent_hotel_id,'hotel')}
                                    <div class="hnv_hotel_recent_content_carousel_item" data-merge="1">
                                        <a href="{$recent_hotel_link}"
                                           class="hnv_hotel_recent_content_carousel_item_image"
                                           title="{$recent_hotel_title}">
                                            <img data-src="{$clsHotel->getImage($recent_hotel_id,298,276)}"
                                                 width="298" height="276" class="scale_img_hover owl-lazy"
                                                 alt="{$recent_hotel_title}">
                                            {if $recent_hotel_city}
                                                <label class="hnv_hotel_recent_content_carousel_item_image_tag">
                                                    {$recent_hotel_city}
                                                </label>
                                            {/if}
                                        </a>
                                        <div class="hnv_hotel_recent_content_carousel_item_content">
                                            <div class="hnv_hotel_recent_content_carousel_item_content_title">
                                                <h3>
                                                    <a href="{$recent_hotel_link}" title="{$recent_hotel_title}">
                                                        {$recent_hotel_title}
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="hnv_hotel_recent_content_carousel_item_content_star">


                                                <div class="hnv_hotel_detail_recent_content_item_content_review">
                                                    {if $ratingValue eq '0'}
                                                        <div class="hnv_hotel_detail_recent_content_item_content_review_score bg_none_reviews">
                                                            {$ratingValue|number_format:1}
                                                        </div>
                                                        <div class="hnv_hotel_detail_recent_content_item_content_review_text txt_none_reviews">
                                                            {$textRateAvg}
                                                        </div>
                                                    {else}
                                                        <div class="hnv_hotel_detail_recent_content_item_content_review_score">
                                                            {$ratingValue|number_format:1}
                                                        </div>
                                                        <div class="hnv_hotel_detail_recent_content_item_content_review_text">
                                                            {$textRateAvg}
                                                        </div>
                                                        <div class="hnv_hotel_detail_recent_content_item_content_review_total">
                                                            | {$ratingCount} {$core->get_Lang('reviews')}
                                                        </div>
                                                    {/if}
                                                </div>
                                            </div>
                                            <div class="hnv_hotel_recent_content_carousel_item_content_price">
                                                {$core->get_Lang('from')}
                                                <span>{$clsHotel->getPriceOnPromotion($recent_hotel_id)}</span>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                {/if}
            </div>
        </div >
    </form>
    {$core->getBlock('2024_review_customer')}
    {$core->getBlock('dev_helpcenter_topdest')}
</section>

{literal}
<style>
    .hnv_hotel_main_intro  p{
        padding-left: 0 !important;
    }
</style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(function () {
                var form = document.getElementById('hnv_filter_form_hotel');
                if (!form) return;

                form.addEventListener('submit', function () {
                    var action = form.getAttribute('action') || window.location.pathname;
                    action = action.replace('/2024-khach-san-', '/khach-san/');
                    form.setAttribute('action', action);
                    form.setAttribute('method', 'get');
                });
                if ($('.hnv_hotel_recent_content_carousel').length > 0) {
                    $('.hnv_hotel_recent_content_carousel').owlCarousel({
                        lazyLoad: true,
                        loop: false,
                        margin: 26,
                        nav: true,
                        dots: false,
                        smartSpeed: 800,
                        navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
                        merge: true,
                        responsive: {
                            0: {
                                items: 1.2,
                                nav: false
                            },
                            576: {
                                items: 2
                            },
                            992: {
                                items: 3
                            },
                            1200: {
                                items: 4
                            }

                        }
                    });
                }

                if ($('.short_content').length) {
                    $('.short_content').each((_i, _elem) => {
                        var _max_height = $(_elem).data('height'),
                            _origin_height = $(_elem).outerHeight(false);
                        if (parseInt(_max_height) < _origin_height) {
                            $(_elem)
                                .height(_max_height)
                                .addClass('shorted')
                                .append('<a class="more func_toggleShorted" max_height="' + _max_height + '">' + $_View_more + '</a>');
                        }
                    });
                }

                $(document).on('click', '.func_toggleShorted', function(e){
                    toggleShorted($(this), e);
                });

                function toggleShorted(_this, e) {
                    e.preventDefault();
                    if (!$(_this).hasClass('clicked')) {
                        $(_this).parent('.short_content')
                            .css('height', 'auto')
                            .removeClass('shorted')
                            .addClass('lessmore');
                        $(_this).addClass('clicked').text($_View_less);
                    } else {
                        var max_height = $(_this).attr('max_height');
                        $(_this).parent('.short_content')
                            .css('height', max_height)
                            .addClass('shorted')
                            .removeClass('lessmore');
                        $(_this).removeClass('clicked').text($_View_more);
                    }
                    return false;
                }
            });
        })
        
    </script>
{/literal}