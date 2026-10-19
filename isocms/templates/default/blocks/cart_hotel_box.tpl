{if $cartSessionHotel}
    <label class="titleBoxContent">{$core->get_Lang('Hotels')}</label>
    {foreach from=$cartSessionHotel key=k item=item name=item}
        {assign var=title_hotel value=$clsHotel->getTitle($k)}
        {assign var=link_hotel value=$clsHotel->getLink($item.hotel_id)}
        {assign var=image_hotel value=$clsHotel->getImage($item.hotel_id)}
        {assign var=star_hotel value=$clsHotel->getStar($item.hotel_id)}
        {assign var=payment_down_money value=0}
        <div class="hnv_cart_item hnv_cart_item_hotel">
            <div class="hnv_cart_item_top">
                <div class="row">
                    <div class="col-sm-3 col-xxl-2 col-3">
                        <div class="hnv_cart_item_image">
                            <a href="{$link_hotel}" title="{$title_hotel}">
                                <img src="{$image_hotel}" width="auto" height="auto" alt="{$title_hotel}">
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
                                    <a href="{$link_hotel}" title="{$title_hotel}">
                                        {$title_hotel}
                                    </a>
                                    <div class="hnv_cart_item_info_star d-none d-md-block">
                                        {section name=i loop=$star_hotel} <i class="fa-duotone fa-light fa-star"></i> {/section}
                                    </div>
                                </h3>
                            </div>
                            <div class="hnv_cart_item_info_star d-sm-block d-md-none">
                                {section name=i loop=$star_hotel} <i class="fa-duotone fa-light fa-star"></i> {/section}
                            </div>
                            <div class="hnv_cart_item_info_detail d-none d-md-flex">
                                <div class="hnv_cart_item_info_detail_date">
                                    <i class="fa-light fa-calendar"></i>
                                    {$clsISO->converTimeToText5($item.check_in)}
                                    <i class="fa-duotone fa-light fa-arrow-right-long"></i>
                                    {$clsISO->converTimeToText5($item.check_out)}
                                    <span>
                                        {if $item.number_night > 1}
                                            | {$item.number_night} {$core->get_Lang('nights')}
                                        {else}
                                            | 1 {$core->get_Lang('night')}
                                        {/if}
                                    </span>
                                </div>

                                {assign var="room_arr" value=$item.room}
                                {assign var="total_room" value=0}
                                {foreach from=$room_arr key=k1 item=i1}
                                    {assign var="total_room" value=$total_room + $i1.number_room}
                                {/foreach}
                                <div class="hnv_cart_item_info_detail_customer">
                                    <div class="hnv_cart_item_info_detail_customer_room">
                                        <i class="fa-light fa-person-to-door"></i> {$total_room} {$core->get_Lang('Rooms')}
                                        <a href="javascript:void(0);" title="{$core->get_Lang('View detail')}">
                                            <i class="fa-light fa-angle-down" data-hotel_id="{$item.hotel_id}"></i>
                                        </a>
                                    </div>
                                    <ul class="hnv_cart_item_info_detail_customer_room_list hnv_cart_item_info_detail_customer_room_list_{$item.hotel_id}" style="display: none;">
                                        {foreach from=$room_arr key=k item=i}
                                            {$payment_down_money = $payment_down_money+$i.payment_down_money}
                                            {assign var=payment_down value=$clsHotelRoom->getPaymentDown($i.hotel_room_id)}
                                            {assign var=txt_number_people value=$clsHotelRoom->getTxtNumberPeople($i.hotel_room_id)}
                                            <li class="hnv_cart_item_info_detail_customer_room_item">
                                                {$i.number_room} x {$clsHotelRoom->getTitle($i.hotel_room_id)} ({$txt_number_people})  {$core->get_Lang('Deposit')}: {$payment_down}% 
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                <div class="hnv_cart_item_info_detail_policy">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8">
                                            <div class="hnv_cart_item_info_detail_policy_left">
                                                <ul class="hnv_cart_item_info_detail_policy_list">
                                                    {if $payment_down_money == 0}
                                                    <li class="hnv_cart_item_info_detail_policy_item">
                                                        <i class="fa-light fa-circle-xmark"></i> 
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
                                                {if $_LANG_ID == 'vn'} 
                                                <div class="hnv_cart_item_info_detail_policy_price">
                                                    <span>{$clsISO->formatPrice($item.totalpriceRoom)} {$clsISO->getShortRate()}</span>
                                                </div>
                                                <a href="javascript:void(0);" class="hnv_cart_item_info_detail_policy_adult">
                                                    {$core->get_Lang('Price details')}
                                                    <div class="hnv_cart_item_info_detail_policy_price_tooltip">
                                                        <ul class="hnv_cart_item_info_detail_policy_price_tooltip_list">
                                                            {foreach from=$room_arr key=k item=i}
                                                                <li class="hnv_cart_item_info_detail_policy_price_tooltip_item">
                                                                    {$i.number_room} {$clsHotelRoom->getTitle($i.hotel_room_id)} x {$clsISO->formatPrice($i.room_price)} {$clsISO->getShortRate()}     
                                                                </li>
                                                            {/foreach}
                                                        </ul>
                                                    </div>
                                                </a>
                                                {else} 
                                                <div class="hnv_cart_item_info_detail_policy_price">
                                                    <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceRoom)} </span>
                                                </div>
                                                <a href="javascript:void(0);" class="hnv_cart_item_info_detail_policy_adult">
                                                    {$core->get_Lang('Price details')}
                                                    <div class="hnv_cart_item_info_detail_policy_price_tooltip">
                                                        <ul class="hnv_cart_item_info_detail_policy_price_tooltip_list">
                                                            {foreach from=$room_arr key=k item=i}
                                                                <li class="hnv_cart_item_info_detail_policy_price_tooltip_item">
                                                                    {$i.number_room} {$clsHotelRoom->getTitle($i.hotel_room_id)} x  {$clsISO->getShortRate()}{$i.room_price}
                                                                </li>
                                                            {/foreach}
                                                        </ul>
                                                    </div>
                                                </a>
                                                {/if}
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hnv_cart_item_info_detail d-sm-flex d-md-none mt-3">
                    <div class="hnv_cart_item_info_detail_date">
                        <i class="fa-light fa-calendar"></i>
                        {$clsISO->converTimeToText5($item.check_in)}
                        <i class="fa-duotone fa-light fa-arrow-right-long"></i>
                        {$clsISO->converTimeToText5($item.check_out)}
                        <span>
                                        {if $item.number_night > 1}
                                            | {$item.number_night} {$core->get_Lang('nights')}
                                        {else}
                                            | 1 {$core->get_Lang('night')}
                                        {/if}
                                    </span>
                    </div>

                    {assign var="room_arr" value=$item.room}
                    {assign var="total_room" value=0}
                    {foreach from=$room_arr key=k1 item=i1}
                        {assign var="total_room" value=$total_room + $i1.number_room}
                    {/foreach}
                    <div class="hnv_cart_item_info_detail_customer">
                        <div class="hnv_cart_item_info_detail_customer_room">
                            <i class="fa-light fa-person-to-door"></i> {$total_room} {$core->get_Lang('Rooms')}
                            <a href="javascript:void(0);" title="{$core->get_Lang('View detail')}">
                                <i class="fa-light fa-angle-down" data-hotel_id="{$item.hotel_id}"></i>
                            </a>
                        </div>
                        <ul class="hnv_cart_item_info_detail_customer_room_list hnv_cart_item_info_detail_customer_room_list_{$item.hotel_id}" style="display: none;">
                            {foreach from=$room_arr key=k item=i}
                                {$payment_down_money = $payment_down_money+$i.payment_down_money}
                                {assign var=payment_down value=$clsHotelRoom->getPaymentDown($i.hotel_room_id)}
                                {assign var=txt_number_people value=$clsHotelRoom->getTxtNumberPeople($i.hotel_room_id)}
                                <li class="hnv_cart_item_info_detail_customer_room_item">
                                    {$i.number_room} x {$clsHotelRoom->getTitle($i.hotel_room_id)} ({$txt_number_people})  {$core->get_Lang('Deposit')}: {$payment_down}%
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                    <div class="hnv_cart_item_info_detail_policy">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="hnv_cart_item_info_detail_policy_left">
                                    <ul class="hnv_cart_item_info_detail_policy_list">
                                        {if $payment_down_money == 0}
                                            <li class="hnv_cart_item_info_detail_policy_item">
                                                <i class="fa-light fa-circle-xmark"></i>
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
                                    <a class="edit" href="{$clsHotel->getLink($item.hotel_id)}"
                                        title="{$core->get_Lang('Edit')}">
                                        <i class="fa-light fa-pen-to-square"></i>
                                        {$core->get_Lang('Edit')}
                                    </a>
                                </li>
                                <li class="hnv_cart_item_action_item">
                                    <a class="remove ajvCart" data-tp="DEL_HOTEL" data-table_id="{$k}" href="javascript:void(0);"
                                        title="{$core->get_Lang('Delete')}">
                                        <i class="fa-light fa-trash-can"></i>
                                    </a>
                                </li>
                                <li class="hnv_cart_item_action_item d-none d-sm-none d-md-block">
                                    <label>
                                        {$core->get_Lang('Deposit')}:
                                        {if $_LANG_ID == 'vn'}
                                        {$clsISO->formatPrice($payment_down_money)}{$clsISO->getShortRate()}
                                        {else}
                                        {$clsISO->getShortRate()}{$clsISO->formatPrice($payment_down_money)}
                                        {/if}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="hnv_cart_item_total_price d-sm-block d-md-none">
                            {if $_LANG_ID == 'vn'}
                                <span>{$clsISO->formatPrice($item.totalpriceRoom)}{$clsISO->getShortRate()}</span>
                            {else}
                                <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceRoom)}</span>
                            {/if}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="hnv_cart_item_total">
                            <div class="hnv_cart_item_total_price d-none d-sm-none d-md-block">
                                {if $_LANG_ID == 'vn'}
                                <span>{$clsISO->formatPrice($item.totalpriceRoom)}{$clsISO->getShortRate()}</span>
                                {else}
                                <span>{$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceRoom)}</span> 
                                {/if}
                            </div>
                            <div class="hnv_cart_item_total_include">
                                {$core->get_Lang('All taxes and fees included')}
                            </div>
                            <div class="hnv_cart_item_action_item d-sm-block d-md-none">
                                <label>
                                    {$core->get_Lang('Deposit')}:
                                    {if $_LANG_ID == 'vn'}
                                        {$clsISO->formatPrice($payment_down_money)}{$clsISO->getShortRate()}
                                    {else}
                                        {$clsISO->getShortRate()}{$clsISO->formatPrice($payment_down_money)}
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
                document.addEventListener("DOMContentLoaded", function () {
                    $(document).ready(function () {
                        $('.hnv_cart_item_hotel .fa-angle-down').off('click').on('click', function () {
                            let hotel_id = $(this).data('hotel_id');
                            $(this).toggleClass('rotate180');
                            $('.hnv_cart_item_hotel .hnv_cart_item_info_detail_customer_room_list_' + hotel_id).slideToggle();
                        });
                    });
                })
            </script>
        {/literal}
    {/foreach}
{/if}

