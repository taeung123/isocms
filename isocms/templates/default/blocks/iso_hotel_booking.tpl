{if $cartSessionHotel}
    {foreach from=$cartSessionHotel key=k item=item name=item}
        {assign var=title_hotel value=$clsHotel->getTitle($k)}
        {assign var=link_hotel value=$clsHotel->getLink($item.hotel_id)}
        {assign var=image_hotel value=$clsHotel->getImage($item.hotel_id)}
        {assign var=star_hotel value=$clsHotel->getStar($item.hotel_id)}

        <div class="hnv_cart_item hnv_cart_item_hotel">
            <div class="hnv_cart_item_top">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="hnv_cart_item_image">
                            <div class="title_package" title="{$title_hotel}">
                                <img src="{$image_hotel}" width="auto" height="auto" alt="{$title_hotel}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="hnv_cart_item_info">
                            <div class="hnv_cart_item_info_title d-flex align-items-center justify-content-between">
                                <h3>
                                    {$title_hotel}
                                </h3>
                                <div class="iso_hnv_cart_edit">
                                    <i class="fa-sharp fa-solid fa-pen-to-square"></i>
                                </div>
                            </div>
                            <div class="hnv_cart_item_info_detail">
                                <div class="hnv_cart_item_info_detail_date">
                                    <i class="fa-light fa-calendar"></i>
                                    {$clsISO->converTimeToText5($item.check_in)}
                                    <i class="fa-duotone fa-light fa-arrow-right-long"></i>
                                    {$clsISO->converTimeToText5($item.check_out)}
                                    <span>
                                        {if $item.number_night}
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
                                            {assign var=txt_number_people value=$clsHotelRoom->getTxtNumberPeople($i.hotel_room_id)}
                                            <li class="hnv_cart_item_info_detail_customer_room_item">
                                                {$i.number_room} x {$clsHotelRoom->getTitle($i.hotel_room_id)} ({$txt_number_people})
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                <div class="hnv_cart_item_info_detail_policy">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="hnv_cart_item_info_detail_policy_left">
                                                <ul class="hnv_cart_item_info_detail_policy_list">
                                                    {assign var=payment_down_money value=0}
                                                    {foreach from=$room_arr key=k item=i}
                                                        {$payment_down_money = $payment_down_money+$i.payment_down_money}
                                                    {/foreach}
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
                    </div>
                </div>
            </div>
            <div class="iso_information_booking">
                {$clsISO->getBlock('iso_primary_traveler', ["type_block"=>"hotel", "_key"=>$k])}
                <div class="iso_information_tour_item">
                    <div class="title">
                        {$core->get_Lang('Special requirements')}
                    </div>
                    <div class="iso_box_special_item">
                        <div class="special_item">
                            <div class="title">{$core->get_Lang('Which type of room would you prefer')}?</div>
                            <div class="box_radio">
                                <label for="type_room_1" class="payment_custom_radio">
                                    <input type="radio" name="hotel_type_room_{$k}" checked id="type_room_1" value="1">
                                    <span>{$core->get_Lang('Non-smoking')}</span>
                                    <span class="checkmark"></span>
                                </label>
                                <label for="type_room_2" class="payment_custom_radio">
                                    <input type="radio" name="hotel_type_room_{$k}" id="type_room_2" value="2">
                                    <span>{$core->get_Lang('Smoking')}</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="special_item">
                            <div class="title">{$core->get_Lang('Which bed setup would you prefer')}?</div>
                            <div class="box_radio">
                                <label for="bed_setup_1" class="payment_custom_radio">
                                    <input type="radio" name="hotel_bed_setup_{$k}" checked id="bed_setup_1" value="1">
                                    <span>{$core->get_Lang('I’d like a large bed')}</span>
                                    <span class="checkmark"></span>
                                </label>
                                <label for="bed_setup_2" class="payment_custom_radio">
                                    <input type="radio" name="hotel_bed_setup_{$k}" id="bed_setup_2" value="2">
                                    <span>{$core->get_Lang('I’d like twin beds')}</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="iso_special_requirements">
                        <div class="iso_item_body_tour iso_input_box">
                            <div class="row">
                                <div class="col-12">
                                    <div class="iso_input_box_item_area">
                                        <textarea name="hotel_special_{$k}" rows="3" placeholder="{$core->get_Lang('We would like a room with a sea view. The special meal with fried eggs would be nice.')}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="iso_button d-flex flex-column">
                                <button class="iso_cart_button" id="btn_hotel_{$k}">
                                    {$core->get_Lang('Next')}
                                </button>
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

