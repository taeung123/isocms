{if $cartSessionCruise}
    {foreach from=$cartSessionCruise key=k item=item name=item}
        {assign var=title_cruise value=$clsCruiseItinerary->getTitleDay($k)}
        {assign var=link_cruise value=$clsCruise->getLink($item.cruise_id)}
        {assign var=image_cruise value=$clsCruise->getImage($item.cruise_id)}

        <div class="hnv_cart_item hnv_cart_item_cruise">
            <div class="hnv_cart_item_top">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="hnv_cart_item_image">
                            <div class="title_package" title="{$title_cruise}">
                                <img src="{$image_cruise}" width="auto" height="auto" alt="{$title_cruise}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="hnv_cart_item_info">
                            <div class="hnv_cart_item_info_title d-flex align-items-center justify-content-between">
                                <h3>
                                    {$title_cruise}
                                </h3>
                                <div class="iso_hnv_cart_edit">
                                    <i class="fa-sharp fa-solid fa-pen-to-square"></i>
                                </div>
                            </div>
                            <div class="hnv_cart_item_info_detail">
                                <div class="hnv_cart_item_info_detail_itinerary">
                                    <i class="fa-light fa-calendars"></i>
                                    {$core->get_Lang('Itinerary')}: {$clsCruiseItinerary->getTitleItinerary($item.cruise_itinerary_id)}
                                </div>
                                <div class="hnv_cart_item_info_detail_date">
                                    <i class="fa-light fa-calendar"></i>
                                    {$clsISO->convertTimeToText($item.departure_date)}
                                    <i class="fa-duotone fa-light fa-arrow-right-long"></i>
                                    {$clsISO->convertTimeToText($clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id))}
                                    {if $clsCruiseItinerary->getNumberNight($item.cruise_itinerary_id) > 0}
                                        <span>| {$clsCruiseItinerary->getNumberNight($item.cruise_itinerary_id)} {$core->get_Lang('nights')}</span>
                                    {/if}
                                </div>
                                {assign var="cabin_arr" value=$item.cabin}
                                {assign var="total_cabin" value=0}
                                {foreach from=$cabin_arr key=k1 item=i1}
                                    {assign var="total_cabin" value=$total_cabin + $i1.number_cabin}
                                {/foreach}
                                <div class="hnv_cart_item_info_detail_customer">
                                    <div class="hnv_cart_item_info_detail_customer_room">
                                        <i class="fa-light fa-person-to-door"></i> {$total_cabin} {$core->get_Lang('Cabins')}
                                        <a href="javascript:void(0);" title="{$core->get_Lang('View detail')}">
                                            <i class="fa-light fa-angle-down" data-cruise_id="{$item.cruise_id}"></i>
                                        </a>
                                    </div>
                                    <ul class="hnv_cart_item_info_detail_customer_room_list hnv_cart_item_info_detail_customer_room_list_{$item.cruise_id}" style="display: none;">
                                        {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                            <li class="hnv_cart_item_info_detail_customer_room_item">
                                                {$value.number_cabin} x {$clsCruiseCabin->getTitle($cruise_cabin_id)} {*(2 adults)*}
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                <div class="hnv_cart_item_info_detail_policy">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="hnv_cart_item_info_detail_policy_left">
                                                <ul class="hnv_cart_item_info_detail_policy_list">
                                                    <li class="hnv_cart_item_info_detail_policy_item hnv_cart_item_info_detail_policy_item_date">
                                                        <i class="fa-regular fa-credit-card"></i>
                                                        <span>{$core->get_Lang('No advance payment')}</span>
                                                    </li>
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
                {$clsISO->getBlock('iso_primary_traveler', ["type_block"=>"cruise", "_key"=>$k])}
                <div class="iso_information_tour_item">
                    <div class="title">
                        {$core->get_Lang('Special requirements')}
                    </div>
                    <div class="iso_special_requirements">
                        <div class="iso_item_body_tour iso_input_box">
                            <div class="row">
                                <div class="col-12">
                                    <div class="iso_input_box_item_area">
                                        <textarea name="cruise_special_{$k}" rows="3" placeholder="{$core->get_Lang('To type the request to us. E.g. dietary needs, accessibility')}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="iso_button d-flex flex-column">
                                <button class="iso_cart_button" id="btn_cruise_{$k}">
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
                        $('.hnv_cart_item_cruise .fa-angle-down').off('click').on('click', function () {
                            let cruise_id = $(this).data('cruise_id');
                            $(this).toggleClass('rotate180');
                            $('.hnv_cart_item_cruise .hnv_cart_item_info_detail_customer_room_list_' + cruise_id).slideToggle();
                        });
                    });
                })
            </script>
        {/literal}
    {/foreach}
{/if}