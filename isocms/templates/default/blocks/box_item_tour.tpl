<section class="hnv_trvs_tour">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-3">
                {$core->getBlock('2024_filter_tour')}
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="hnv_trvs_main">
                    <div class="hnv_trvs_main_action">
                        <div class="hnv_trvs_main_result">
                            {$totalTour} {$core->get_Lang('results')}
                        </div>
                        <div class="hnv_trvs_main_sort">
                            {$core->get_Lang('Sort by')}:
                            {assign var="select" value=$clsISO->generateTourSelectOptions()}
                            <select class="typeSearch" name="sort">
                                {section name=i loop=$select}
                                    {assign var="index" value=$smarty.section.i.index}
                                    <option value="{$index}" {if $sort == $index}selected{/if}>{$select[i]}</option>
                                {/section}
                            </select>
                        </div>
                    </div>
                    <div class="hnv_trvs_main_tour">
                        <div class="hnv_trvs_main_tour_list">
                            {if $listTour}
                                {foreach from=$listTour key=key item=item}
                                    {assign var=tour_id value=$item.tour_id}
                                    {assign var=tour_title value=$item.title}
                                    {assign var=tour_link value=$clsTour->getLink($tour_id, $item)}
                                    {assign var=list_departure_point value=$clsTour->getListDeparturePoint($tour_id)}
                                    {assign var=Depart_point value=$clsTour->getCityCountryFromDeparture($tour_id)}
                                    {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,"new2024")}
                                    {assign var=getTripDuration value=$clsTour->getTripDuration($tour_id)}
                                    {assign var=getToTalReview value=$clsReviews->getToTalReview($tour_id,'tour')}
                                    {assign var=getRateAvg value=$clsReviews->fetchAvgRating($tour_id,'tour')}
                                    {assign var=getStarNew value=$clsReviews->getStarNew($tour_id,'tour')}
{*                                    {assign var=getStarNew value=$clsReviews->getStarNewNoLogin($tour_id,'tour')}*}
                                    <div class="hnv_trvs_main_tour_item">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <div class="hnv_trvs_main_tour_item_image">
                                                    <a href="{$tour_link}" title="{$tour_title}">
                                                        <img class="scale_img_hover" src="{$clsTour->getImage($tour_id,292,194)}" width="292" height="194" alt="{$tour_title}">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <div class="hnv_trvs_main_tour_item_content">
                                                    {if $package_id == 3 || $package_id == 4}
                                                    <div class="hnv_trvs_main_tour_item_content_suggest">
                                                        <ul class="hnv_trvs_main_tour_item_content_suggest_list p-0 mb-0 mt-3 mt-md-0">
                                                            {if $clsTour->getIsBestPrice($tour_id)}
                                                                <li class="hnv_trvs_main_tour_item_content_suggest_item">
                                                                    <i class="fa-light fa-star"></i> {$core->get_Lang('Best Price')}
                                                                </li>
                                                            {/if}
                                                            {if $clsTour->getIsRecommended($tour_id)}
                                                                <li class="hnv_trvs_main_tour_item_content_suggest_item">
                                                                    <i class="fa-light fa-heart"></i> {$core->get_Lang('Recommended2')}
                                                                </li>
                                                            {/if}
                                                        </ul>
                                                    </div>
                                                    {/if}
                                                    <div class="hnv_trvs_main_tour_item_content_title">
                                                        <h3>
                                                            <a class="hover_txt_green_dark" href="{$tour_link}" title="{$tour_title}">
                                                                {$tour_title}
                                                            </a>
                                                        </h3>
                                                    </div>
                                                    <div class="hnv_trvs_main_tour_item_content_rate">
                                                        <label class="rate-1"> {$getStarNew} </label>
                                                        {$getRateAvg} ({$getToTalReview})
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-8">
                                                            <div class="hnv_trvs_main_tour_item_content_info">
                                                                <div class="hnv_trvs_main_tour_item_content_info_place">
                                                                    <div class="hnv_trvs_main_tour_item_content_info_place_icon">
                                                                        <i class="fa-light fa-paper-plane"></i>
                                                                    </div>
                                                                    <label><span>{$core->get_Lang('Places to visit')}:</span>
                                                                        {$list_departure_point}
                                                                    </label>
                                                                    {*                                    <a>+ 2 more</a>*}
                                                                </div>
                                                                <div class="hnv_trvs_main_tour_item_content_info_start">
                                                                    <div class="hnv_trvs_main_tour_item_content_info_start_icon">
                                                                        <i class="fa-light fa-location-dot"></i>
                                                                    </div>
                                                                    <label><span>{$core->get_Lang('Start')}:</span>
                                                                        {$Depart_point}
                                                                    </label>
                                                                </div>
                                                                <div class="hnv_trvs_main_tour_item_content_info_duration">
                                                                    <div class="hnv_trvs_main_tour_item_content_info_duration_icon">
                                                                        <i class="fa-light fa-clock"></i>
                                                                    </div>
                                                                    <label><span>{$core->get_Lang('Duration')}:</span>
                                                                        {$getTripDuration}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="hnv_trvs_main_tour_item_content_price">
                                                                {if $getPriceTourPromotion}
                                                                    <div class="hnv_trvs_main_tour_item_content_price_from">
                                                                        {$core->get_Lang('from')}
                                                                    </div>
                                                                    {$getPriceTourPromotion}
                                                                    <div class="hnv_trvs_main_tour_item_content_price_note">
                                                                        {$core->get_Lang('includes taxes & fees')}
                                                                    </div>
                                                                {else}
                                                                    <div class="hnv_trvs_main_tour_item_content_price_number mb-2">
                                                                        <span>{$core->get_Lang("Contact")}</span>
                                                                    </div>
                                                                {/if}
                                                                <a href="{$tour_link}" class="hnv_trvs_main_tour_item_content_price_link hover_btn_green_dark" title="{$tour_title}">
                                                                    {$core->get_Lang('View more')}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            {else}
                                <div class="empty_data text-center mt-3">
                                    <img class="empy_data_img" src="{$clsISO->tripslashImage("{$URL_IMAGES}/empty_data2024.png", 403, 272)}" alt="">
                                    <div class="empty_data_title">{$core->get_Lang("No matches found")}</div>
                                    <div class="empty_data_note">{$core->get_Lang("We did not find the results you were looking for. Please search again or contact us.")}</div>
                                    <div class="btn_empty_data"><a class="btn_a_tag" href="{$reset_filter}">{$core->get_Lang("Clear all filters")}</a></div>
                                </div>
                            {/if}
                        </div>
                        {if $totalPage gt '1'}
                            <div class="hnv_trvs_main_tour_paginate">
                                <div class="pagination pager">
                                    {$page_view}
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>