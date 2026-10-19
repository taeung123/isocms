{assign var="listCabin" value=$clsISO->makeCheckboxDuration("cabins")}
{assign var="listItineraries" value=$clsISO->makeCheckboxDuration()}
<form action="" method="post">
<input type="hidden" name="search">
<section class="hnv_trvs_tour">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="hnv_trvs_main_filter">
                    <div class="hnv_trvs_main_filter_title">
                        <i class="fa-solid fa-bars-filter"></i>
                        <h3 class="h2_applled_filters" onclick="openNav()">{$core->get_Lang('Applled filters')}</h3>
                        <div class="applled_filters ps-2">
                            {if $title_cat}
                                <p class="txt_filter" data-name="cat_id" data-id="{$title_cat}">{$title_cat}
                                    <a style="color: inherit" href="{$clsISO->getLink("cruise")}"><i class="fa-light fa-circle-xmark"></i></a></p>
                            {/if}
                            {foreach from=$lstCruiseCatSearch item=cruiseCat}
                                {assign var="cruise_cat_id" value=$cruiseCat.cruise_cat_id}
                                {if $clsISO->checkInArray($list_cat_id, $cruise_cat_id)}
                                    <p class="txt_filter" data-name="cruise_cat_id[]" data-id="{$cruise_cat_id}">
                                        {$cruiseCat.title} <i class="fa-light fa-circle-xmark"></i>
                                    </p>
                                {/if}
                            {/foreach}

                            {foreach from=$listCruiseRangePrice item=priceRange}
                                {assign var="price_range_id" value=$priceRange.cruise_price_range_id}
                                {if $clsISO->checkInArray($price_id, $price_range_id)}
                                    <p class="txt_filter" data-name="price_id[]" data-id="{$price_range_id}">
                                        {$priceRange.title} <i class="fa-light fa-circle-xmark"></i>
                                    </p>
                                {/if}
                            {/foreach}

                            {foreach from=$listItineraries key=idx item=itinerary}
                                {assign var="index" value=$idx+1}
                                {if $clsISO->checkInArray($itineraries, $index)}
                                    <p class="txt_filter" data-name="itineraries[]" data-id="{$index}">
                                        {$core->get_Lang("Itineraries")} {$itinerary} 
                                        {if $index == 1}{$core->get_Lang("day")}{else}{$core->get_Lang("days")}{/if} 
                                        <i class="fa-light fa-circle-xmark"></i>
                                    </p>
                                {/if}
                            {/foreach}

                            {if $rank_cruise}
                                <p class="txt_filter" data-name="rank_cruise" data-id="{$rank_cruise}">
                                    {if $rank_cruise == 2}
                                        {$core->get_Lang("Un rated")}
                                    {else}
                                        {$rank_cruise} {$core->get_Lang("stars")}
                                    {/if}
                                    <i class="fa-light fa-circle-xmark"></i>
                                </p>
                            {/if}

                            {foreach from=$listCabin key=idx item=cabin}
                                {assign var="index" value=$idx+1}
                                {if $clsISO->checkInArray($cabins, $index)}
                                    <p class="txt_filter" data-name="cabins[]" data-id="{$index}">
                                        {$core->get_Lang("Cabins")} {$cabin.min} - {$cabin.max} 
                                        <i class="fa-light fa-circle-xmark"></i>
                                    </p>
                                {/if}
                            {/foreach}

                            {if $departure_date}
                                <p class="txt_filter" data-name="departure_date" data-id="{$departure_date}">{$core->get_Lang("When")} {$departure_date} <i class="fa-light fa-circle-xmark"></i></p>
                            {/if}
                        </div>
                    </div>
                    <div class="hnv_trvs_main_filter_content" id="filterSidenav">
                        <div onclick="closeNav()" class="sort-filter-mobile d-lg-none d-flex">
                            <i class="fa-solid fa-angle-left"></i>
                            <div class="tour_sort_filter"><p>{$core->get_Lang("Applled filters")}</p></div>
                        </div>
                        <div class="hnv_trvs_main_filter_content_list">
                            <div class="hnv_trvs_main_filter_content_list_title">
                                <h3>{$core->get_Lang('Itineraries')}</h3>
                            </div>
                            <div class="hnv_trvs_main_filter_content_list_content">
                                {section name=i loop=$listItineraries}
                                    {assign var="index" value=$smarty.section.i.index+1}
                                    <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                                        <label>
                                            <input type="checkbox" name="itineraries[]" value="{$index}"
                                                   {if $clsISO->checkInArray($itineraries, $index)}checked{/if}
                                                   class="hnv_trvs_main_filter_content_list_content_item_checkbox form-check-input">
                                            <span class="hnv_trvs_main_filter_content_list_content_item_text">{$listItineraries[i]} {if $index == 1}{$core->get_Lang("day")}{else}{$core->get_Lang("days")}{/if}</span>
                                        </label>
                                    </div>
                                {/section}
                                <a href="javascript:void(0);" class="hnv_trvs_main_filter_content_list_content_more">
                                    {$core->get_Lang('View more')} <i class="fa-light fa-angle-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="hnv_trvs_main_filter_content_list_content_line"></div>
                        <div class="hnv_trvs_main_filter_content_list">
                            <div class="hnv_trvs_main_filter_content_list_title">
                                <h3>{$core->get_Lang('Price Per Person')}</h3>
                            </div>
                            <div class="hnv_trvs_main_filter_content_list_content">
                                {section name=i loop=$listCruiseRangePrice}
                                    {assign var="price_range_id" value=$listCruiseRangePrice[i].cruise_price_range_id}
                                    <div class='hnv_trvs_main_filter_content_list_content_item typeSearch'>
                                        <label>
                                            <input type="checkbox" name="price_id[]" value="{$price_range_id}"
                                                   {if $clsISO->checkInArray($price_id,$price_range_id)}checked{/if}
                                                   class='hnv_trvs_main_filter_content_list_content_item_radio form-check-input'>
                                            <span class='hnv_trvs_main_filter_content_list_content_item_text'>{$listCruiseRangePrice[i].title}</span>
                                        </label>
                                    </div>
                                {/section}
                                <a href="javascript:void(0);" class="hnv_trvs_main_filter_content_list_content_more">
                                    {$core->get_Lang('View more')} <i class="fa-light fa-angle-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="hnv_trvs_main_filter_content_list_content_line"></div>
                        <div class="hnv_trvs_main_filter_content_list">
                            <div class="hnv_trvs_main_filter_content_list_title">
                                <h3>{$core->get_Lang('Property rating')}</h3>
                            </div>
                            <div class="hnv_trvs_main_filter_content_list_content">
                                {section name=i loop=6 step=-1}
                                    {assign var="index" value=$smarty.section.i.index}
                                    {if $index > 1}
                                        <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                                            <label>
                                                <input type="radio" name="rank_cruise" value="{$index}"
                                                       {if $clsISO->checkInArray($rank_cruise, $index)}checked{/if}
                                                       class="hnv_trvs_main_filter_content_list_content_item_radio form-check-input">
                                                <span class="hnv_trvs_main_filter_content_list_content_item_text">{if $index == 2}{$core->get_Lang("Un rated")}{else}{$index} {$core->get_Lang("stars")}{/if}</span>
                                            </label>
                                        </div>
                                    {/if}
                                {/section}
                                <a href="javascript:void(0);" class="hnv_trvs_main_filter_content_list_content_more">
                                    {$core->get_Lang('View more')} <i class="fa-light fa-angle-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="hnv_trvs_main_filter_content_list_content_line"></div>
                        {if $lstCruiseCatSearch}
                            <div class="hnv_trvs_main_filter_content_list">
                                <div class="hnv_trvs_main_filter_content_list_title">
                                    <h3>{$core->get_Lang('Cruises categories')}</h3>
                                </div>
                                <div class="hnv_trvs_main_filter_content_list_content">
                                    {section name=i loop=$lstCruiseCatSearch}
                                        {assign var="cruise_cat_id" value=$lstCruiseCatSearch[i].cruise_cat_id}
                                        <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                                            <label>
                                                <input type="checkbox" name="cruise_cat_id[]" value="{$cruise_cat_id}"
                                                       {if $clsISO->checkInArray($list_cat_id, $cruise_cat_id)}checked{/if}
                                                       {if $cat_ID == $cruise_cat_id}checked{/if}
                                                       class="hnv_trvs_main_filter_content_list_content_item_radio form-check-input">
                                                <span class="hnv_trvs_main_filter_content_list_content_item_text">{$lstCruiseCatSearch[i].title}</span>
                                            </label>
                                        </div>
                                    {/section}
                                    <a href="javascript:void(0);" class="hnv_trvs_main_filter_content_list_content_more">
                                        {$core->get_Lang('View more')} <i class="fa-light fa-angle-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="hnv_trvs_main_filter_content_list_content_line"></div>
                        {/if}
                        <div class="hnv_trvs_main_filter_content_list">
                            <div class="hnv_trvs_main_filter_content_list_title">
                                <h3>{$core->get_Lang('Number of cabins')}</h3>
                            </div>
                            <div class="hnv_trvs_main_filter_content_list_content">
                                {section name=i loop=$listCabin}
                                    {assign var="index" value=$smarty.section.i.index+1}
                                    <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                                        <label>
                                            <input type="checkbox" name="cabins[]" value="{$index}"
                                                   {if $clsISO->checkInArray($cabins, $index)}checked{/if}
                                                   class="hnv_trvs_main_filter_content_list_content_item_radio form-check-input">
                                            <span class="hnv_trvs_main_filter_content_list_content_item_text">{$listCabin[i].min} - {$listCabin[i].max} {$core->get_Lang("cabins")}</span>
                                        </label>
                                    </div>
                                {/section}
                                <a href="javascript:void(0);" class="hnv_trvs_main_filter_content_list_content_more">
                                    {$core->get_Lang('View more')} <i class="fa-light fa-angle-down"></i>
                                </a>
                            </div>
                        </div>
                        <div class="hnv_trvs_main_filter_content_list_content_line"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="hnv_trvs_main">
                    <div class="hnv_trvs_main_action">
                        <div class="hnv_trvs_main_result">
                            {$totalRecord} {$core->get_Lang('results')}
                        </div>
                        <div class="hnv_trvs_main_sort">
                            {$core->get_Lang('Sort by')}:
                            {assign var="select" value=$clsISO->makeCheckboxDuration("sort_cruise")}
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
                            {if !empty($listCruise)}
                                {foreach from=$listCruise key=key item=item}
                                    {assign var=cruise_id value=$item.cruise_id}
                                    {assign var=cruise_title value=$item.title}
                                    {assign var=cruise_link value=$clsCruise->getLink($cruise_id)}
                                    {assign var=cabins value=$clsCruise->getTotalCabin($cruise_id)}
                                    {assign var=cruisePrice value=$clsCruise->getLTripPrice1($cruise_id,$now_month,'price_2024')}
                                    {assign var=review_score value=$clsCruise->getStarNew($cruise_id)}
                                    <div class="hnv_trvs_main_tour_item">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <div class="hnv_trvs_main_tour_item_image">
                                                    <a href="{$cruise_link}" title="{$cruise_title}">
                                                        <img class="scale_img_hover" src="{$clsISO->tripslashImage($item.image,292,194)}" alt="{$cruise_title}">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <div class="hnv_trvs_main_tour_item_content">
                                                    <div class="hnv_trvs_main_tour_item_content_title d-flex">
                                                        <h3>
                                                            <a class="hover_txt_green_dark" href="{$cruise_link}" title="{$cruise_title}">
                                                                {$cruise_title}
                                                            </a>
                                                        </h3>
                                                        <div class="hnv_trvs_main_tour_item_content_rate">
                                                            {$clsCruise->getStarNew($cruise_id)}
                                                        </div>
                                                    </div>
                                                    <div class="cruise_review">
                                                        <p class="review_score">{$clsReviews->getReviews($cruise_id, "avg_point", "cruise")}</p>
                                                        <p class="review_txt">{$clsReviews->getReviews($cruise_id, "txt_review", "cruise")}</p>
                                                        <p class="vertical_bar">|</p>
                                                        <p class="quantity_review">{$clsReviews->getReviews($cruise_id, "", "cruise")}</p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="hnv_trvs_main_tour_item_content_info">
                                                                <div class="hnv_trvs_main_tour_item_content_info_place">
                                                                    <div class="hnv_trvs_main_tour_item_content_info_place_icon">
                                                                        <i class="fa-duotone fa-regular fa-anchor"></i>
                                                                    </div>
                                                                    <label class="d-inline"><span>{$core->get_Lang('Departure port')}:</span>
                                                                        {$item.departure_port}
                                                                    </label>
                                                                </div>
                                                                <div class="hnv_trvs_main_tour_item_content_info_start">
                                                                    <div class="hnv_trvs_main_tour_item_content_info_start_icon">
                                                                        <i class="fa-light fa-location-dot"></i>
                                                                    </div>
                                                                    <label class="d-inline place_to_go"><span>{$core->get_Lang('Place to go')}:</span>
                                                                        {$clsCruise->getCityAroundBlog($cruise_id)}
                                                                    </label>
                                                                </div>
                                                                <div class="hnv_trvs_main_tour_item_content_info_duration">
                                                                    <div class="hnv_trvs_main_tour_item_content_info_duration_icon">
                                                                        <i class="fa-light fa-cabin"></i>
                                                                    </div>
                                                                    <label class="d-inline"><span>{$core->get_Lang('Cabins')}:</span>
                                                                        {$cabins}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between mt-3 cruise_highlight">
                                                        <div class="cruise_highlight_left">
                                                            <p class="txt_cruise_highlight">{$core->get_Lang("Highlight")} <i class="fa-regular fa-angle-down"></i></p>
                                                            <div class="mt-2 txt_highlight">{$item.highlight|html_entity_decode}</div>
                                                        </div>
                                                        <div class="cruise_highlight_right">
                                                            <div class="hnv_trvs_main_tour_item_content_price">
                                                                {if $cruisePrice}
                                                                    <div>
                                                                        {$cruisePrice}
                                                                    </div>
                                                                {else}
                                                                    <div class="hnv_trvs_main_tour_item_content_price_number mb-2">
                                                                        <span>{$core->get_Lang("Contact")}</span>
                                                                    </div>
                                                                {/if}
                                                                <a href="{$cruise_link}" class="hnv_trvs_main_tour_item_content_price_link hover_btn_green_dark" title="{$cruise_title}">
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
                        {if $totalPage|default:0 gt '1'}
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
</form>
{literal}
    <style>
        .hnv_trvs_main_filter_content_list_content_line {
            width: 100%;
            height: 1px;
            margin: 24px 0;
            background: #C8CBD0;
        }
        .hnv_trvs_main_filter_title {
            margin-bottom: 24px;
            border-radius: var(--border-radius-card);
            background: var(--chroma-f-6-f-6-fa, #F6F6FA);
            padding: 11px 16px;
        }
        .hnv_trvs_main_filter_title i {
            font-size: var(--font-size-article-icon);
            color: var(--primary-color);
            vertical-align: middle;
        }
        .hnv_trvs_main_filter_title .h2_applled_filters {
            display: inline-block;
            margin-left: 12px;
        }
        .txt_filter {
            color: var(--chroma-717171, #717171);
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .txt_filter .fa-circle-xmark {
            cursor: pointer;
        }
        .hnv_trvs_main_filter_content_list_title {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 18px;
            font-style: normal;
            font-weight: 700;
            line-height: 26px; /* 144.444% */
            margin-bottom: 16px;
        }
        .hnv_trvs_main_filter_content_list_content {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .hnv_trvs_main_filter_content_list_content_item label{
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .hnv_trvs_main_filter_content_list_content_item_checkbox {
            width: 20px;
            height: 20px;
        }

        .hnv_trvs_main_filter_content_list_content_more {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .hnv_trvs_main_filter_content_list_content_item_radio {
            width: 20px;
            height: 20px;
        }
        .hnv_trvs_main_filter_content_list_content_item_star {
            font-size: 20px;
            color: var(--review-star-color);
        }
        .ui-slider .ui-slider-handle {
            border: unset;
            filter: drop-shadow(0px 2px 10px rgba(0, 0, 0, 0.10));
        }
        #slider-price2 .ui-slider-range {
            background: var(--primary-18-babd, #18babd);
        }
        #hnv_filter_form_tour input[type="checkbox"]:checked {
            background-color: var(--secondary-00818-a, #00818a);
            border-color: var(--secondary-00818-a, #00818a);
            accent-color: var(--secondary-00818-a, #00818a);
        }
        #hnv_filter_form_tour input[type="radio"]:checked {
            background-color: var(--secondary-00818-a, #00818a);
            border-color: var(--secondary-00818-a, #00818a);
            accent-color: var(--secondary-00818-a, #00818a);
        }
        @media only screen and (max-width: 575px) {
            .hnv_trvs_main_filter_content {
                height: 100%;
                width: 0;
                position: fixed;
                top: 0;
                left: 0;
                background-color: #fff;
                overflow-x: hidden;
                transition: 0.5s;
                text-align: center;
                z-index: 4;
            }
            .hnv_trvs_main_filter_content_list {
                padding: 0 15px
            }
            .sort-filter-mobile {
                padding: 20px 0;
                margin-bottom: 15px;
                align-items: center;
                background: #fff;
                box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.1);
            }
            .sort-filter-mobile i.fa-angle-left {
                padding-left: 24px;
                font-size: 24px;
            }
            .sort-filter-mobile .tour_sort_filter {
                width: 100%;
                text-align: center;
                margin-left: -24px;
            }
            .sort-filter-mobile .tour_sort_filter p {
                margin-bottom: 0;
                color: #16181d;
                text-align: center;
                font-size: 18px;
                font-weight: 600;
                line-height: 150%;
            }
            .btn_fixed_bot {
                position: fixed;
                bottom: 12px;
                left: 12px;
                right: 12px;
                z-index: 4;
                margin: unset !important;
                width: unset !important;
                background: var(--chroma-f-6-f-6-fa, #F6F6FA);
                text-align: center;
                padding: 12px 0
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toggleContent(".hnv_trvs_main_filter_content_list_content",".hnv_trvs_main_filter_content_list_content_item", ".hnv_trvs_main_filter_content_list_content_more", 3);

            $(".txt_highlight").hide();
            $(".txt_cruise_highlight").click(function() {
                $(this).closest(".cruise_highlight_left").find(".txt_highlight").toggle();
                $(this).find(".fa-regular").toggleClass("fa-angle-up fa-angle-down");
            });

            $('.typeSearch').change(function() {
                $(this).closest('form').submit();
            });
            $(".fa-circle-xmark").click(function() {
                const $this = $(this);
                const filter = $this.closest(".txt_filter").data("name");
                const id = $this.closest(".txt_filter").data("id");

                $("input[name='" + filter + "']").each(function() {
                    if ($(this).is(":checkbox") || $(this).is(":radio")) {
                        if ($(this).val() == id) {
                            $(this).prop("checked", false);
                        }
                    } else if ($(this).is(":hidden")) {
                        if ($(this).val() == id) {
                            $(this).val("");
                        }
                    }
                });
                $this.closest("form").submit();
            });
            function openNav() {
                $("#filterSidenav").css("width", "100%");
                $("#isocms_header").css("z-index", "2");
            }
            function closeNav() {
                $("#filterSidenav").css("width", "0");
                $("#isocms_header").css("z-index", "4");
            }
            stickyBtnBottom('.h2_applled_filters');
        })
        
    </script>
{/literal}