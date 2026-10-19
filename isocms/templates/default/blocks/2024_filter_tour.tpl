<div class="hnv_trvs_main_filter">
    <div class="hnv_trvs_main_filter_title">
        <i class="fa-solid fa-bars-filter"></i>
        <h3 class="h2_applled_filters" onclick="openNav()">{$core->get_Lang('Applled filters')}</h3>
        <div class="applled_filters ps-2">
            {section name=i loop=$listDuration}
                {assign var="title_duration" value=$clsTour->getSelectTripDuration($listDuration[i].tour_id)}
                {assign var="value_duration" value=$clsTour->convertDuration($title_duration)}
                {if $clsISO->checkInArray($duration_id, $value_duration)}
                    <p class="txt_filter" data-name="duration_id[]" data-id="{$value_duration}">{$core->get_Lang("Duration")} {$title_duration} <i class="fa-light fa-circle-xmark"></i></p>
                {/if}
            {/section}
            {if $country_id}
                <p class="txt_filter" data-name="country_id" data-id="{$country_id}">{$clsCountry->getTitle($country_id)} <i class="fa-light fa-circle-xmark"></i></p>
                {section name=i loop=$listCity}
                    {if $clsISO->checkInArray($city_filter_id, $listCity[i].city_id)}
                    <p class="txt_filter" data-name="city_filter_id[]" data-id="{$listCity[i].city_id}">{$clsCountry->getTitle($country_id)} | {$listCity[i].title} <i class="fa-light fa-circle-xmark"></i></p>
                    {/if}
                {/section}
            {/if}
            {section name=i loop=$lstDeparturePoint}
                {if $clsISO->checkInArray($departure_point_id, $lstDeparturePoint[i].city_id)}
                <p class="txt_filter" data-name="departure_point_id[]" data-id="{$lstDeparturePoint[i].city_id}">{$core->get_Lang("Start")} {$lstDeparturePoint[i].title} <i class="fa-light fa-circle-xmark"></i></p>
                {/if}
            {/section}
{*            {if $min_price}<p class="txt_filter"><span>{$core->get_Lang("Price")} {$clsISO->getShortRate()}{$min_price_search} {$core->get_Lang("to")} {$clsISO->getShortRate()}{$max_price_search}</span> <i class="fa-light fa-circle-xmark"></i></p>{/if}*}
            {if $rating}
            <p class="txt_filter" data-name="rating" data-id="{$rating}">
                <span class="hnv_trvs_main_filter_content_list_content_item_star">
                    {section name=j loop=$rating} <i class="fa-duotone fa-light fa-star"></i> {/section}
                    {section name=j loop=(5-$rating)} <i class="fa-light fa-star"></i> {/section}
                </span>
                <i class="fa-light fa-circle-xmark"></i>
            </p>
            {/if}
            {if $departure_date}
                <p class="txt_filter" data-name="departure_date" data-id="{$departure_date}">{$core->get_Lang("When")} {$departure_date} <i class="fa-light fa-circle-xmark"></i></p>
            {/if}
        </div>
    </div>
    <div class="hnv_trvs_main_filter_content" id="filterSidenav">
        <input type="hidden" name="min_price" id="price1" value="{$min_price_search}">
        <input type="hidden" name="max_price" id="price2" value="{$max_price_search}">
        <div onclick="closeNav()" class="sort-filter-mobile d-lg-none d-flex">
            <i class="fa-solid fa-angle-left"></i>
            <div class="tour_sort_filter"><p>{$core->get_Lang("Applled filters")}</p></div>
        </div>
        <div class="hnv_trvs_main_filter_content_list">
            <div class="hnv_trvs_main_filter_content_list_title">
                <h3>{$core->get_Lang('Duration')}</h3>
            </div>
            <div class="hnv_trvs_main_filter_content_list_content">
                {section name=i loop=$listDuration}
                    {assign var="title_duration" value=$clsTour->getSelectTripDuration($listDuration[i].tour_id)}
                    {assign var="value_duration" value=$clsTour->convertDuration($title_duration)}
                    <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                        <label>
                            <input type="checkbox" name="duration_id[]" value="{$value_duration}"
                                   {if $clsISO->checkInArray($duration_id, $value_duration)}checked{/if}
                                   class="hnv_trvs_main_filter_content_list_content_item_checkbox form-check-input">
                            <span class="hnv_trvs_main_filter_content_list_content_item_text">{$title_duration}</span>
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
                <h3>{$core->get_Lang('Price / pax')}</h3>
            </div>
            <div class="hnv_trvs_main_filter_content_list_content">
                <div class="hnv_trvs_main_filter_content_list_content_range">
                    <div class="d-flex justify-content-between">
                        <div id="price_0"></div>
                        <div id="price_1"></div>
                    </div>
                    <div id="slider-price2" class="mb10"></div>
                </div>
            </div>
        </div>
        <div class="hnv_trvs_main_filter_content_list_content_line"></div>
        <!-- <div class="hnv_trvs_main_filter_content_list">
            <div class="hnv_trvs_main_filter_content_list_title">
                <h3>{$core->get_Lang('Nation')}</h3>
            </div>
            <div class="hnv_trvs_main_filter_content_list_content">
                {section name=i loop=$listCountry}
                    <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                        <label>
                            <input type="radio" name="country_id" value="{$listCountry[i].country_id}"
                                   {if $listCountry[i].country_id == $country_id}checked{/if}
                                   class="hnv_trvs_main_filter_content_list_content_item_radio">
                            <span class="hnv_trvs_main_filter_content_list_content_item_text">{$listCountry[i].title}</span>
                        </label>
                    </div>
                {/section}
                <a href="javascript:void(0);" class="hnv_trvs_main_filter_content_list_content_more">
                    {$core->get_Lang('View more')} <i class="fa-light fa-angle-down"></i>
                </a>
            </div>
        </div>
        <div class="hnv_trvs_main_filter_content_list_content_line"></div> -->
        {if !empty($listCity)}
            <div class="hnv_trvs_main_filter_content_list">
                <div class="hnv_trvs_main_filter_content_list_title">
                    <h3>{$core->get_Lang('City')}</h3>
                </div>
                <div class="hnv_trvs_main_filter_content_list_content">
                    {section name=i loop=$listCity}
                        {assign var="cityID" value=$listCity[i].city_id}
                        <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                            <label>
                                <input type="checkbox" name="city_filter_id[]" value="{$cityID}"
                                       {if $act=="place_inbound2024"}
                                           {if $city_id == $cityID}checked{/if}
                                        {else}
                                            {if $clsISO->checkInArray($city_filter_id, $cityID)}checked{/if}
                                        {/if}
                                       class="hnv_trvs_main_filter_content_list_content_item_radio form-check-input">
                                <span class="hnv_trvs_main_filter_content_list_content_item_text">{$listCity[i].title}</span>
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
        <!-- <div class="hnv_trvs_main_filter_content_list">
            <div class="hnv_trvs_main_filter_content_list_title">
                <h3>{$core->get_Lang('Departure point')}</h3>
            </div>
            <div class="hnv_trvs_main_filter_content_list_content">
                {section name=i loop=$lstDeparturePoint}
                    {assign var="city_id_departure" value=$lstDeparturePoint[i].city_id}
                    <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                        <label>
                            <input type="checkbox" name="departure_point_id[]" value="{$city_id_departure}"
                                   {if $clsISO->checkInArray($departure_point_id, $city_id_departure)}checked{/if}
                                   class="hnv_trvs_main_filter_content_list_content_item_checkbox form-check-input">
                            <span class="hnv_trvs_main_filter_content_list_content_item_text">{$lstDeparturePoint[i].title}</span>
                        </label>
                    </div>
                {/section}
                <a href="javascript:void(0);" class="hnv_trvs_main_filter_content_list_content_more">
                    {$core->get_Lang('View more')} <i class="fa-light fa-angle-down"></i>
                </a>
            </div>
        </div>
        <div class="hnv_trvs_main_filter_content_list_content_line"></div> -->

        <div class="hnv_trvs_main_filter_content_list">
            <div class="hnv_trvs_main_filter_content_list_title">
                <h3>{$core->get_Lang('Rating')}</h3>
            </div>
            <div class="hnv_trvs_main_filter_content_list_content">
                {section name=i loop=6 start=5 step=-1}
                    {assign var="index" value=$smarty.section.i.index}
                    {if $index > 1}
                        <div class="hnv_trvs_main_filter_content_list_content_item typeSearch">
                            <label>
                                <input type="radio" name="rating" value="{$index}" {if $index == $rating}checked{/if}
                                       class="hnv_trvs_main_filter_content_list_content_item_checkbox">
                                <span class="hnv_trvs_main_filter_content_list_content_item_star">
                                    {section name=j loop=$index}<i class="fa-duotone fa-light fa-star"></i>{/section}{section name=j loop=(5-$index)}<i class="fa-light fa-star"></i>{/section}
                                    </span>
                                {if $index < 5}<span>
                                    {if $index === 2}{$core->get_Lang("down")}{else}{$core->get_Lang("up")}{/if}</span>{/if}
                            </label>
                        </div>
                    {/if}
                {/section}
            </div>
        </div>
        <div class="hnv_trvs_main_filter_content_list_content_line"></div>
    </div>
</div>
<input type="hidden" name="search2024">
<input type="hidden" name="departure_date" value="{$departure_date}">
<script>
    const curency = '{$clsISO->getShortRate()}';
    const max_price_value = '{$max_price_value}';
    const min_price_value = '{$min_price_value}';
    const min_price_search = '{$min_price_search}';
    const max_price_search = '{$max_price_search}';
</script>
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
        .hnv_trvs_main_filter_title h3 {
            display: inline-block;
            margin-left: 12px;
        }
        .txt_filter {
            color: var(--secondary-color);
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .txt_filter .fa-circle-xmark {
            cursor: pointer;
        }
        .hnv_trvs_main_filter_title .fa-bars-filter {
            font-size: var(--font-size-article-icon);
            color: var(--primary-color);
            vertical-align: middle;
        }
        .hnv_trvs_main_filter_content_list_title {
            color: var(--primary-1-d-2-d-53);
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
            border-radius: 4px;
        }
        .hnv_trvs_main_filter_content_list_content_more {
            color: var(--primary-1-d-2-d-53);
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
            color: #FED141;
        }
        .ui-slider .ui-slider-handle {
            border: unset;
            filter: drop-shadow(0px 2px 10px rgba(0, 0, 0, 0.10));
        }
        #slider-price2 .ui-slider-range {
            background: var(--primary-18-babd);
        }
        #hnv_filter_form_tour input[type="checkbox"]:checked {
            background-color: var(--secondary-00818-a);
            border-color: var(--secondary-00818-a);
            accent-color: var(--secondary-00818-a);
        }
        #hnv_filter_form_tour input[type="radio"]:checked {
            background-color: var(--secondary-00818-a);
            border-color: var(--secondary-00818-a);
            accent-color: var(--secondary-00818-a);
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
            toggleContent(".hnv_trvs_main_filter_content_list_content",".hnv_trvs_main_filter_content_list_content_item", ".hnv_trvs_main_filter_content_list_content_more");
            $(function () {
                var step_slider = (LANG_ID == 'vn') ? 50000 : 5;               
                $("#slider-price2").slider({
                    range: true,
                    min: parseInt(min_price_value),
                    max: parseInt(max_price_value),
                    values: [min_price_search, max_price_search],
                    step: step_slider,
                    slide: function (event, ui) {
                        $("#price_0").html(`${curency}${ui.values[0]}`);
                        $("#price_1").html(`${curency}${ui.values[1]}`);
                        $("#price1").val(ui.values[0]);
                        $("#price2").val(ui.values[1]);
                        $('#hnv_filter_form_tour').submit();
                    }
                });
                $("#price_0").html(format_price(min_price_search));
                $("#price_1").html(format_price(max_price_search));
            });

            function openNav() {
                $("#filterSidenav").css("width", "100%");
            }
            function closeNav() {
                $("#filterSidenav").css("width", "0");
            }

            function format_price(n) {
                return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + curency
            }

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
            stickyBtnBottom('.h2_applled_filters');
        })
        
    </script>
{/literal}