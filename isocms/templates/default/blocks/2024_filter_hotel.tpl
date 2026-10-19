{* ============================================================
   2024_filter_hotel.tpl
   Safe defaults for PHP 8.x + Smarty 3.1.x
   ============================================================ *}

{assign var=arr_hotel_types_safe value=array()}
{if isset($arr_hotel_types) && is_array($arr_hotel_types)}
    {assign var=arr_hotel_types_safe value=$arr_hotel_types}
{/if}

{assign var=arr_hotel_facilities_safe value=array()}
{if isset($arr_hotel_facilities) && is_array($arr_hotel_facilities)}
    {assign var=arr_hotel_facilities_safe value=$arr_hotel_facilities}
{/if}

{assign var=lstCity_safe value=array()}
{if isset($lstCity) && is_array($lstCity)}
    {assign var=lstCity_safe value=$lstCity}
{/if}

{assign var=hotel_type_safe value=array()}
{if isset($hotel_type) && is_array($hotel_type)}
    {assign var=hotel_type_safe value=$hotel_type}
{/if}

{assign var=hotel_star_safe value=array()}
{if isset($hotel_star) && is_array($hotel_star)}
    {assign var=hotel_star_safe value=$hotel_star}
{/if}

{assign var=hotel_city_safe value=array()}
{if isset($hotel_city) && is_array($hotel_city)}
    {assign var=hotel_city_safe value=$hotel_city}
{/if}

{assign var=hotel_facilities_safe value=array()}
{if isset($hotel_facilities) && is_array($hotel_facilities)}
    {assign var=hotel_facilities_safe value=$hotel_facilities}
{/if}

{assign var=deviceType_safe value='computer'}
{if isset($deviceType) && $deviceType}
    {assign var=deviceType_safe value=$deviceType}
{/if}

{assign var=hotel_min_price_value_safe value=0}
{if isset($hotel_min_price_value) && is_numeric($hotel_min_price_value)}
    {assign var=hotel_min_price_value_safe value=$hotel_min_price_value}
{/if}

{assign var=hotel_max_price_value_safe value=0}
{if isset($hotel_max_price_value) && is_numeric($hotel_max_price_value)}
    {assign var=hotel_max_price_value_safe value=$hotel_max_price_value}
{/if}

{assign var=hotel_min_price_search_safe value=$hotel_min_price_value_safe}
{if isset($hotel_min_price_search) && is_numeric($hotel_min_price_search)}
    {assign var=hotel_min_price_search_safe value=$hotel_min_price_search}
{/if}

{assign var=hotel_max_price_search_safe value=$hotel_max_price_value_safe}
{if isset($hotel_max_price_search) && is_numeric($hotel_max_price_search)}
    {assign var=hotel_max_price_search_safe value=$hotel_max_price_search}
{/if}

<div class="hnv_hotel_filter">
    <div class="hnv_hotel_filter_map"></div>

    <a class="hnv_hotel_filter_title"
       data-bs-toggle="offcanvas"
       {if $deviceType_safe ne 'computer'}
           href="#filterHotelOffcanvas"
           role="button"
       {/if}
       aria-controls="filterHotelOffcanvas">
        <i class="fa-solid fa-bars-filter"></i>
        <h3 class="h2_applled_filters">
            {$core->get_Lang('Applled filters')}
        </h3>
    </a>

    <div class="hnv_hotel_filter_content {if $deviceType_safe ne 'computer'}offcanvas offcanvas-start{/if}"
         tabindex="-1"
         id="filterHotelOffcanvas"
         aria-labelledby="filterHotelOffcanvasLabel">

        {if $deviceType_safe ne 'computer'}
            <div class="offcanvas-header">
                <div class="hnv_hotel_filter_title_offcanvas">
                    <i class="fa-solid fa-bars-filter"></i>
                    <h2 class="h2_applled_filters">
                        {$core->get_Lang('Applled filters')}
                    </h2>
                </div>

                <button type="button"
                        class="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close">
                </button>
            </div>
        {/if}

        <div class="offcanvas-body">

            {* Property Types *}
            {if $arr_hotel_types_safe|@count gt 0}
                <div class="hnv_hotel_filter_content_list">
                    <div class="hnv_hotel_filter_content_list_title">
                        <h3>{$core->get_Lang('Property Types')}</h3>
                    </div>

                    <div class="hnv_hotel_filter_content_list_content hnv_property_types">
                        {foreach from=$arr_hotel_types_safe item=item}
                            {assign var=hotel_property_id value=0}
                            {if isset($item.property_id)}
                                {assign var=hotel_property_id value=$item.property_id|intval}
                            {/if}

                            {if $hotel_property_id gt 0}
                                {assign var=check value=$clsISO->checkInArray($hotel_type_safe,$hotel_property_id)}
                                {assign var=hotel_count value=0}

                                {if isset($item.hotel_counts)
                                    && is_array($item.hotel_counts)
                                    && isset($item.hotel_counts[0])
                                    && isset($item.hotel_counts[0].count)}
                                    {assign var=hotel_count value=$item.hotel_counts[0].count|intval}
                                {/if}

                                <div class="hnv_hotel_filter_content_list_content_item hnv_item_checkbox">
                                    <label>
                                        <input type="checkbox"
                                               name="hotel_type[]"
                                               value="{$hotel_property_id}"
                                               class="hnv_hotel_filter_content_list_content_item_checkbox form-check-input"
                                               {if $check}checked="checked"{/if}>

                                        <div class="hnv_hotel_filter_content_list_content_item_text">
                                            <div>{$clsProperty->getTitle($hotel_property_id)}</div>
                                            <div>({$hotel_count})</div>
                                        </div>
                                    </label>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>

                <div class="hnv_trvs_main_filter_content_list_content_line"></div>
            {/if}

            {* Budget *}
            <div class="hnv_hotel_filter_content_list">
                <div class="hnv_hotel_filter_content_list_title">
                    <h3>{$core->get_Lang('Your budget (per night)')}</h3>
                </div>

                <div class="hnv_hotel_filter_content_list_content">
                    <div class="hnv_hotel_filter_content_list_content_range">
                        <div class="d-flex justify-content-between">
                            <div id="price_0"></div>
                            <div id="price_1"></div>
                        </div>

                        <div id="slider-price2" class="mb10"></div>
                    </div>

                    <input type="hidden"
                           name="min_price"
                           id="price1"
                           value="{$hotel_min_price_search_safe}">

                    <input type="hidden"
                           name="max_price"
                           id="price2"
                           value="{$hotel_max_price_search_safe}">
                </div>
            </div>

            <div class="hnv_trvs_main_filter_content_list_content_line"></div>

            {* Hotel stars *}
            <div class="hnv_hotel_filter_content_list">
                <div class="hnv_hotel_filter_content_list_title">
                    <h3>{$core->get_Lang('Hotel Star Level')}</h3>
                </div>

                <div class="hnv_hotel_filter_content_list_content hnv_star_level">
                    {assign var=stars value=$clsISO->listStar(5)}

                    {if isset($stars) && is_array($stars)}
                        {foreach from=$stars item=star}
                            {if isset($star.star_id)}
                                {assign var=star_id value=$star.star_id|intval}
                                {assign var=star_title value=''}
                                {if isset($star.title)}
                                    {assign var=star_title value=$star.title}
                                {/if}

                                {if $star_id gt 0}
                                    {assign var=check value=$clsISO->checkInArray($hotel_star_safe,$star_id)}

                                    <div class="hnv_hotel_filter_content_list_content_item hnv_item_checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="hotel_star[]"
                                                   value="{$star_id}"
                                                   class="hnv_hotel_filter_content_list_content_item_checkbox form-check-input"
                                                   {if $check}checked="checked"{/if}>

                                            <div class="hnv_hotel_filter_content_list_content_item_text">
                                                <span>{$star_title}</span>
                                            </div>
                                        </label>
                                    </div>
                                {/if}
                            {/if}
                        {/foreach}
                    {/if}
                </div>
            </div>

            {* Locations *}
            {if $lstCity_safe|@count gt 0}
                <div class="hnv_trvs_main_filter_content_list_content_line"></div>

                <div class="hnv_hotel_filter_content_list">
                    <div class="hnv_hotel_filter_content_list_title">
                        <h3>{$core->get_Lang('Location')}</h3>
                    </div>

                    <div class="hnv_hotel_filter_content_list_content hnv_location">
                        {foreach from=$lstCity_safe item=item}
                            {assign var=city_filter_id value=0}
                            {assign var=city_filter_title value=''}

                            {if isset($item.city_id)}
                                {assign var=city_filter_id value=$item.city_id|intval}
                            {/if}

                            {if isset($item.title)}
                                {assign var=city_filter_title value=$item.title}
                            {/if}

                            {if $city_filter_id gt 0}
                                {assign var=check value=$clsISO->checkInArray($hotel_city_safe,$city_filter_id)}

                                <div class="hnv_hotel_filter_content_list_content_item hnv_item_checkbox">
                                    <label>
                                        <input type="checkbox"
                                               name="hotel_city[]"
                                               value="{$city_filter_id}"
                                               class="hnv_hotel_filter_content_list_content_item_checkbox form-check-input"
                                               {if $check}checked="checked"{/if}>

                                        <div class="hnv_hotel_filter_content_list_content_item_text">
                                            <span>{$city_filter_title}</span>
                                        </div>
                                    </label>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            {/if}

            {* Facilities *}
            {if $arr_hotel_facilities_safe|@count gt 0}
                <div class="hnv_trvs_main_filter_content_list_content_line"></div>

                <div class="hnv_hotel_filter_content_list">
                    <div class="hnv_hotel_filter_content_list_title">
                        <h3>{$core->get_Lang('Property facilities')}</h3>
                    </div>

                    <div class="hnv_hotel_filter_content_list_content hnv_property_facilities">
                        {foreach from=$arr_hotel_facilities_safe item=item}
                            {assign var=hotel_property_id value=0}

                            {if isset($item.property_id)}
                                {assign var=hotel_property_id value=$item.property_id|intval}
                            {/if}

                            {if $hotel_property_id gt 0}
                                {assign var=check value=$clsISO->checkInArray($hotel_facilities_safe,$hotel_property_id)}

                                <div class="hnv_hotel_filter_content_list_content_item hnv_item_checkbox">
                                    <label>
                                        <input type="checkbox"
                                               name="hotel_facilities[]"
                                               value="{$hotel_property_id}"
                                               class="hnv_hotel_filter_content_list_content_item_checkbox form-check-input"
                                               {if $check}checked="checked"{/if}>

                                        <div class="hnv_hotel_filter_content_list_content_item_text">
                                            <div>{$clsProperty->getTitle($hotel_property_id)}</div>
                                        </div>
                                    </label>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            {/if}

            <div class="hnv_trvs_main_filter_content_list_content_line"></div>
        </div>
    </div>
</div>

<script>
    var curency = '{$clsISO->getShortRate()|escape:"javascript"}';
    var min_price_value = parseFloat('{$hotel_min_price_value_safe}') || 0;
    var max_price_value = parseFloat('{$hotel_max_price_value_safe}') || 0;
    var min_price_search = parseFloat('{$hotel_min_price_search_safe}') || 0;
    var max_price_search = parseFloat('{$hotel_max_price_search_safe}') || 0;
    var $_View_more = '{$core->get_Lang("View more")|escape:"javascript"}';
    var $_View_less = '{$core->get_Lang("View less")|escape:"javascript"}';
</script>

{literal}
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    if (typeof window.jQuery === 'undefined') {
        return;
    }

    var $ = window.jQuery;

    function normalizePrices() {
        min_price_value = Number(min_price_value) || 0;
        max_price_value = Number(max_price_value) || 0;
        min_price_search = Number(min_price_search) || min_price_value;
        max_price_search = Number(max_price_search) || max_price_value;

        if (max_price_value < min_price_value) {
            max_price_value = min_price_value;
        }

        if (min_price_search < min_price_value) {
            min_price_search = min_price_value;
        }

        if (max_price_search > max_price_value) {
            max_price_search = max_price_value;
        }

        if (max_price_search < min_price_search) {
            max_price_search = max_price_value;
        }
    }

    function formatPrice(number) {
        number = Number(number) || 0;

        var formatted = number
            .toString()
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

        if (typeof LANG_ID !== 'undefined' && LANG_ID === 'vn') {
            return formatted + curency;
        }

        return curency + formatted;
    }

    function submitHotelFilter(element) {
        var form = element ? $(element).closest('form') : $('#hnv_filter_form_hotel');

        if (!form.length) {
            form = $('#hnv_filter_form_hotel');
        }

        if (form.length) {
            form.trigger('submit');
        }
    }

    function toggleItems(parentSelectors, childSelector, visibleNumber) {
        childSelector = childSelector || '.hnv_item_checkbox';
        visibleNumber = visibleNumber || 4;

        $(parentSelectors).each(function () {
            var parent = $(this);
            var items = parent.find(childSelector);

            if (items.length <= visibleNumber) {
                return;
            }

            items.slice(visibleNumber).hide();

            var toggleButton = $('<a/>', {
                href: 'javascript:void(0);',
                class: 'hnv_hotel_filter_content_list_content_more'
            });

            toggleButton.html(
                $_View_more + ' <i class="fa-light fa-angle-down"></i>'
            );

            toggleButton.on('click', function () {
                var hiddenItems = items.filter(':hidden');

                if (hiddenItems.length > 0) {
                    items.slideDown();
                    toggleButton.html(
                        $_View_less + ' <i class="fa-light fa-angle-up"></i>'
                    );
                } else {
                    items.slice(visibleNumber).slideUp();
                    toggleButton.html(
                        $_View_more + ' <i class="fa-light fa-angle-down"></i>'
                    );
                }
            });

            parent.append(toggleButton);
        });
    }

    normalizePrices();

    toggleItems(
        '.hnv_property_types, .hnv_star_level, .hnv_location, .hnv_property_facilities',
        '.hnv_item_checkbox',
        4
    );

    $('#price_0').html(formatPrice(min_price_search));
    $('#price_1').html(formatPrice(max_price_search));

    if (
        $.fn.slider
        && $('#slider-price2').length
        && max_price_value >= min_price_value
    ) {
        var stepSlider =
            typeof LANG_ID !== 'undefined' && LANG_ID === 'vn'
                ? 50000
                : 50;

        if (max_price_value - min_price_value < stepSlider) {
            stepSlider = 1;
        }

        $('#slider-price2').slider({
            range: true,
            min: Math.floor(min_price_value),
            max: Math.ceil(max_price_value),
            values: [
                Math.floor(min_price_search),
                Math.ceil(max_price_search)
            ],
            step: stepSlider,

            slide: function (event, ui) {
                $('#price_0').html(formatPrice(ui.values[0]));
                $('#price_1').html(formatPrice(ui.values[1]));
                $('#price1').val(ui.values[0]);
                $('#price2').val(ui.values[1]);
            },

            stop: function () {
                submitHotelFilter(this);
            }
        });
    }

    $(document)
        .off('change.hnvHotelFilter', '.hnv_item_checkbox input')
        .on(
            'change.hnvHotelFilter',
            '.hnv_item_checkbox input',
            function () {
                submitHotelFilter(this);
            }
        );
});
</script>

<style>
.hnv_hotel_filter_title {
    color: var(--primary-1-d-2-d-53, #1D2D53);
    border-radius: var(--border-radius-card);
    background: var(--chroma-f-6-f-6-fa, #F6F6FA);
    padding: 11px 16px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.hnv_hotel_filter_title .fa-bars-filter {
    font-size: var(--font-size-article-icon);
}

.hnv_hotel_filter_content_list_title {
    margin-bottom: 16px;
}

.hnv_hotel_filter_content_list_content_item_checkbox {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
    margin-top: 0;
}

.hnv_hotel_filter_content_list_content_item label {
    display: flex;
    align-items: center;
    gap: 16px;
    cursor: pointer;
}

.hnv_hotel_filter_content_list_content_item_text {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    line-height: 150%;
}

.hnv_hotel_filter_content_list_content {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.hnv_trvs_main_filter_content_list_content_line {
    width: 100%;
    height: 1px;
    margin: 24px 0;
    background: #C8CBD0;
}

.hnv_hotel_filter_content_list_content_more {
    color: var(--primary-1-d-2-d-53, #1D2D53);
    font-size: var(--font-size-small);
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.ui-slider .ui-slider-handle {
    border: 0;
    filter: drop-shadow(0 2px 10px rgba(0, 0, 0, 0.10));
}

#slider-price2 .ui-slider-range {
    background: var(--primary-18-babd, #18babd);
}

.hnv_hotel_filter input[type="checkbox"]:checked,
.hnv_hotel_filter input[type="radio"]:checked {
    background-color: var(--secondary-00818-a, #00818a);
    border-color: var(--secondary-00818-a, #00818a);
    accent-color: var(--secondary-00818-a, #00818a);
}

.offcanvas-header {
    background: var(--chroma-f-6-f-6-fa, #F6F6FA);
}

.hnv_hotel_filter_title_offcanvas {
    color: var(--primary-1-d-2-d-53, #1D2D53);
    font-size: 20px;
    font-style: normal;
    font-weight: 700;
    line-height: 30px;
    border-radius: var(--border-radius-card);
    padding: 11px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.hnv_hotel_filter_title_offcanvas .fa-bars-filter {
    font-size: 24px;
}
</style>
{/literal}
