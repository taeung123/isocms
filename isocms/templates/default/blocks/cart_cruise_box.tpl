{*{if $profile_id == 1672}
{$clsISO->dump($cartSessionCruise)}
{/if}*}

{if $cartSessionCruise}
    <label class="titleBoxContent">{$core->get_Lang('Cruise')}</label>
    {foreach from=$cartSessionCruise key=k item=item name=item}
        {assign var=title_cruise value=$clsCruiseItinerary->getTitleDay($k)}
        {assign var=link_cruise value=$clsCruise->getLink($item.cruise_id)}
        {assign var=image_cruise value=$clsCruise->getImage($item.cruise_id)}

        <div class="hnv_cart_item hnv_cart_item_cruise">
            <div class="hnv_cart_item_top">
                <div class="row">
                    <div class="col-sm-3 col-xxl-2 col-3">
                        <div class="hnv_cart_item_image">
                            <a href="{$link_cruise}" title="{$title_cruise}">
                                <img src="{$image_cruise}" width="auto" height="auto" alt="{$title_cruise}">
                            </a>
                            {if $item.promotion}
                            <div class="iso_cart_promotion">
                                {if $item.discount_type == 2} 
                                    <span class="promotion">-{$item.promotion}%</span>
                                {else} 
                                    {if $_LANG_ID == 'vn'}
                                        <span class="promotion">-{$item.promotion}{$clsISO->getShortRate()}</span>
                                    {else}
                                        <span class="promotion">-{$clsISO->getShortRate()}{$item.promotion}</span>
                                    {/if}
                                {/if}
                            </div>
                            {/if}
                        </div>
                    </div>
                    <div class="col-sm-9 col-xxl-10 col-9">
                        <div class="hnv_cart_item_info">
                            <div class="hnv_cart_item_info_title">
                                <h3>
                                    <a href="{$link_cruise}" title="{$title_cruise}">
                                        {$title_cruise}
                                    </a>
                                </h3>
                            </div>
                            <div class="hnv_cart_item_info_detail d-none d-md-flex">
                                <div class="hnv_cart_item_info_detail_itinerary">
                                    <i class="fa-light fa-calendars"></i>
                                    {$core->get_Lang('Itinerary')}: {$clsCruiseItinerary->getTitleItinerary($item.cruise_itinerary_id)}
                                </div>
                                <div class="hnv_cart_item_info_detail_date">
                                    <i class="fa-light fa-calendar"></i>
{*                                        {if $item.departure_date}*}
{*                                            {$clsISO->convertTimeToText5($item.departure_date)}*}
{*                                        {/if}*}
                                    {$clsISO->convertTimeToText($item.departure_date)}
                                    <i class="fa-duotone fa-light fa-arrow-right-long"></i>
{*                                        {if $clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id)}*}
{*                                            {$clsISO->convertTimeToText5($clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id))}*}
{*                                        {/if}*}
                                    {$clsISO->convertTimeToText($clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id))}
                                </div>
                                {assign var="cabin_arr" value=$item.cabin}
                                {assign var="total_cabin" value=0}
                                {foreach from=$cabin_arr key=k1 item=i1}
                                    {assign var="total_cabin" value=$total_cabin + $i1.number_cabin}
                                {/foreach}
                                <div class="hnv_cart_item_info_detail_customer">
                                    <div class="hnv_cart_item_info_detail_customer_room">
                                        <i class="fa-light fa-person-to-door"></i> {$total_cabin} {$core->get_Lang('Cabins')}
                                        {if $total_cabin > 1}
                                        <a href="javascript:void(0);" title="{$core->get_Lang('View detail')}">
                                            <i class="fa-light fa-angle-down" data-cruise_id="{$k}_{$item.cruise_id}"></i>
                                        </a>
                                        {else}
                                            {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                                : {$clsCruiseCabin->getTitle($cruise_cabin_id)}
                                            {/foreach}
                                        {/if}
                                    </div>
                                    {if $total_cabin > 1}
                                    <ul class="hnv_cart_item_info_detail_customer_room_list hnv_cart_item_info_detail_customer_room_list_{$k}_{$item.cruise_id}" style="display: none;">
                                        {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                            <li class="hnv_cart_item_info_detail_customer_room_item">
                                                {$value.number_cabin} x {$clsCruiseCabin->getTitle($cruise_cabin_id)}
                                            </li>
                                        {/foreach}
                                    </ul>
                                    {/if}
                                </div>
                                <div class="hnv_cart_item_info_detail_policy">
                                    <div class="row justify-content-end">
                                        <div class="col-sm-12 col-md-8">
                                            <div class="hnv_cart_item_info_detail_policy_left">
                                                <ul class="hnv_cart_item_info_detail_policy_list">
                                                    {if $item.deposit > 0}
                                                    <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                        <i class="fa-regular fa-credit-card"></i>
                                                        <span>{$core->get_Lang('Refundable')}</span>
                                                    </li>
                                                    {else}
                                                    <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                        <i class="fa-regular fa-credit-card"></i>
                                                        <span>{$core->get_Lang('No advance payment')}</span>
                                                    </li>
                                                    {/if}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="hnv_cart_item_info_detail_policy_right">
                                                <div class="hnv_cart_item_info_detail_policy_price">
                                                    <span>
                                                        {if $_LANG_ID == 'vn'}
                                                            {$clsISO->formatPrice($item.totalpriceCabin)}{$clsISO->getShortRate()}
                                                        {else}
                                                            {$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceCabin)}
                                                        {/if}
                                                    </span>
                                                </div>
                                                <a href="javascript:void(0);" class="hnv_cart_item_info_detail_policy_adult">
                                                    {$core->get_Lang('Price details')}
                                                    {assign var="total_deposit_price" value=0}
                                                    <div class="hnv_cart_item_info_detail_policy_price_tooltip">
                                                        <ul class="hnv_cart_item_info_detail_policy_price_tooltip_list">
                                                            {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                                                {math assign="price_cabin" equation="x/y" x=$value.totalprice y=$value.number_cabin}
                                                                {$total_deposit_price = $total_deposit_price + $value.deposit_price}
                                                                <li class="hnv_cart_item_info_detail_policy_price_tooltip_item">
                                                                    {$value.number_cabin} {$clsCruiseCabin->getTitle($cruise_cabin_id)}
                                                                    x
                                                                    {if $_LANG_ID == 'vn'}
                                                                        {$clsISO->formatPrice($price_cabin)}{$clsISO->getShortRate()}
                                                                    {else}
                                                                        {$clsISO->getShortRate()}{$clsISO->formatPrice($price_cabin)}
                                                                    {/if}
                                                                </li>
                                                            {/foreach}
                                                        </ul>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {*                            <div class="hnv_cart_line"></div>*}
                            {*                            <div class="hnv_cart_item_info_addon">*}
                            {*                                <ul class="hnv_cart_item_info_addon_list">*}
                            {*                                    <li class="hnv_cart_item_info_addon_item">*}
                            {*                                        <div class="hnv_cart_item_info_addon_item_left">*}
                            {*                                            <span>3</span> x Romantic Cruise Dining*}
                            {*                                        </div>*}
                            {*                                        <div class="hnv_cart_item_info_addon_item_right">*}
                            {*                                            US <span>$21.00</span>*}
                            {*                                            *}{*										<i class="fa-light fa-circle-info" data-bs-toggle="tooltip" title="3 Romantic Cruise x US $ 7.00"></i>*}
                            {*                                        </div>*}
                            {*                                    </li>*}
                            {*                                    <li class="hnv_cart_item_info_addon_item">*}
                            {*                                        <div class="hnv_cart_item_info_addon_item_left">*}
                            {*                                            <span>6</span> x Breakfast/Dinner of your choice*}
                            {*                                        </div>*}
                            {*                                        <div class="hnv_cart_item_info_addon_item_right">*}
                            {*                                            US <span>$30.00</span>*}
                            {*                                            *}{*										<i class="fa-light fa-circle-info" data-bs-toggle="tooltip" title="3 Romantic Cruise x US $ 7.00"></i>*}
                            {*                                        </div>*}
                            {*                                    </li>*}
                            {*                                </ul>*}
                            {*                            </div>*}
                        </div>
                    </div>
                </div>
                <div class="hnv_cart_item_info_detail d-sm-flex d-md-none mt-3">
                    <div class="hnv_cart_item_info_detail_itinerary">
                        <i class="fa-light fa-calendars"></i>
                        {$core->get_Lang('Itinerary')}: {$clsCruiseItinerary->getTitleItinerary($item.cruise_itinerary_id)}
                    </div>
                    <div class="hnv_cart_item_info_detail_date">
                        <i class="fa-light fa-calendar"></i>
                        {*                                        {if $item.departure_date}*}
                        {*                                            {$clsISO->convertTimeToText5($item.departure_date)}*}
                        {*                                        {/if}*}
                        {$clsISO->convertTimeToText($item.departure_date)}
                        <i class="fa-duotone fa-light fa-arrow-right-long"></i>
                        {*                                        {if $clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id)}*}
                        {*                                            {$clsISO->convertTimeToText5($clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id))}*}
                        {*                                        {/if}*}
                        {$clsISO->convertTimeToText($clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id))}
                    </div>
                    {assign var="cabin_arr" value=$item.cabin}
                    {assign var="total_cabin" value=0}
                    {foreach from=$cabin_arr key=k1 item=i1}
                        {assign var="total_cabin" value=$total_cabin + $i1.number_cabin}
                    {/foreach}
                    <div class="hnv_cart_item_info_detail_customer">
                        <div class="hnv_cart_item_info_detail_customer_room">
                            <i class="fa-light fa-person-to-door"></i> {$total_cabin} {$core->get_Lang('Cabins')}
                            {if $total_cabin > 1}
                                <a href="javascript:void(0);" title="{$core->get_Lang('View detail')}">
                                    <i class="fa-light fa-angle-down" data-cruise_id="{$k}_{$item.cruise_id}"></i>
                                </a>
                            {else}
                                {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                    : {$clsCruiseCabin->getTitle($cruise_cabin_id)}
                                {/foreach}
                            {/if}
                        </div>
                        {if $total_cabin > 1}
                            <ul class="hnv_cart_item_info_detail_customer_room_list hnv_cart_item_info_detail_customer_room_list_{$k}_{$item.cruise_id}" style="display: none;">
                                {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                    <li class="hnv_cart_item_info_detail_customer_room_item">
                                        {$value.number_cabin} x {$clsCruiseCabin->getTitle($cruise_cabin_id)}
                                    </li>
                                {/foreach}
                            </ul>
                        {/if}
                    </div>
                    <div class="hnv_cart_item_info_detail_policy">
                        <div class="row justify-content-end">
                            <div class="col-sm-12 col-md-8">
                                <div class="hnv_cart_item_info_detail_policy_left">
                                    <ul class="hnv_cart_item_info_detail_policy_list">
                                        {if $item.deposit > 0}
                                            <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                <i class="fa-regular fa-credit-card"></i>
                                                <span>{$core->get_Lang('Refundable')}</span>
                                            </li>
                                        {else}
                                            <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                <i class="fa-regular fa-credit-card"></i>
                                                <span>{$core->get_Lang('No advance payment')}</span>
                                            </li>
                                        {/if}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hnv_cart_item_bottom">
                <div class="row">
                    <div class="col-sm-12 col-md-6 d-flex align-items-center mobile_cart_item">
                        <div class="hnv_cart_item_action">
                            <ul class="hnv_cart_item_action_list">
                                <li class="hnv_cart_item_action_item">
                                    <a class="edit" href="{$clsCruise->getLink($item.cruise_id)}"
                                        title="{$core->get_Lang('Edit')}">
                                        <i class="fa-light fa-pen-to-square"></i>
                                        {$core->get_Lang('Edit')}
                                    </a>
                                </li>
                                <li class="hnv_cart_item_action_item">
                                    <a class="remove ajvCart" data-tp="DEL_CRUISE" data-table_id="{$k}" href="javascript:void(0);"
                                        title="{$core->get_Lang('Delete')}">
                                        <i class="fa-light fa-trash-can"></i>
                                    </a>
                                </li>
                                <li class="hnv_cart_item_action_item d-none d-sm-none d-md-block">
                                    <label>
                                        {$core->get_Lang('Deposit')} {$item.deposit}%
                                            {if $_LANG_ID == 'vn'} 
                                            ({$clsISO->formatPrice($total_deposit_price)}{$clsISO->getShortRate()})
                                            {else} 
                                            ({$clsISO->getShortRate()}{$clsISO->formatPrice($total_deposit_price)})
                                            {/if}
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div class="hnv_cart_item_total_price d-sm-block d-md-none">
                            {if $_LANG_ID == 'vn'}
                                <span>{$clsISO->formatPrice($item.totalpriceCabin)}{$clsISO->getShortRate()}</span>
                            {else}
                                <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceCabin)}</span>
                            {/if}
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="hnv_cart_item_total">
                            <div class="hnv_cart_item_total_price d-none d-sm-none d-md-block">
                                {if $_LANG_ID == 'vn'}
                                    <span>{$clsISO->formatPrice($item.totalpriceCabin)}{$clsISO->getShortRate()}</span>
                                {else}
                                    <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceCabin)}</span>
                                {/if}
                            </div>
                            <div class="hnv_cart_item_total_include">
                                {$core->get_Lang('All taxes and fees included')}
                            </div>

                            <div class="hnv_cart_item_action_item d-sm-block d-md-none">
                                <label>
                                    {$core->get_Lang('Deposit')} {$item.deposit}%
                                    {if $_LANG_ID == 'vn'}
                                        ({$clsISO->formatPrice($total_deposit_price)}{$clsISO->getShortRate()})
                                    {else}
                                        ({$clsISO->getShortRate()}{$clsISO->formatPrice($total_deposit_price)})
                                    {/if}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {literal}
            <script>
                $(document).ready(function () {
                    $('.hnv_cart_item_cruise .fa-angle-down').off('click').on('click', function () {
                        let cruise_id = $(this).data('cruise_id');
                        $(this).toggleClass('rotate180');
                        $('.hnv_cart_item_cruise .hnv_cart_item_info_detail_customer_room_list_' + cruise_id).slideToggle();
                    });
                });
            </script>
        {/literal}

    {/foreach}
{/if}
