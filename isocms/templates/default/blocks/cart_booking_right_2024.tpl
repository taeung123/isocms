{if $cartSessionService or $cartSessionVoucher or $cartSessionCruise or $cartSessionHotel}
    <div class="border_item_list_all">
        <!-- Box Item Tour -->
        {if $cartSessionService}
            {foreach from=$cartSessionService item=item name=item}
                {assign var=tour_id value=$item.tour_id_z}
                {if $tour_id}
                    {assign var=departure_date value=$clsISO->getStrToTime($item.check_in_book_z)}
                    {assign var=end_date value=$clsTour->getEndDate($departure_date,$tour_id)}
                    {assign var=title_package value=$clsTour->getTitle($item.tour_id_z)}
                    {*    {assign var=link_package value=$clsTour->getLink($item.tour_id_z)}*}
                    {assign var=image_package value=$clsTour->getImage($item.tour_id_z,72,72)}

                    {assign var=adult_visitor value="national_visitor"|cat:$adult_type_id}
                    {assign var=child_visitor value="national_visitor"|cat:$child_type_id}
                    {assign var=infant_visitor value="national_visitor"|cat:$infant_type_id}
                    {assign var=adult_price value="people_price"|cat:$adult_type_id}
                    {assign var=child_price value="people_price"|cat:$child_type_id}
                    {assign var=infant_price value="people_price"|cat:$infant_type_id}

                    {assign var=number_adult value=$item.number_adults_z|default:0}
                    {assign var=number_child value=$item.number_child_z|default:0}
                    {assign var=number_infant value=$item.number_infants_z|default:0}

                    {assign var=price_adult value=$item.total_price_adults|default:0}
                    {assign var=price_child value=$item.total_price_child|default:0}
                    {assign var=price_infant value=$item.total_price_infants|default:0}
                    {assign var=number_of_guests value=$number_adult+$number_child|default:0}

                    {assign var=parent_id value=$item.parent_id|default:0}
                    {if $parent_id}
                        {assign var="arr_tour_parent" value=$item.arr_tour_parent}
                        {assign var=title_tour value=$arr_tour_parent.title}
                        {assign var=link_tour value=$clsTour->getLink($parent_id, $arr_tour_parent.slug)}
                    {/if}
                    <div class="border_item_list hnv_cart_item_tour">
                        <div class="img_txt_item">
                            <div class="iso_cart_right_img">
                                <img class="item_payment" src="{$image_package}" alt="{$title_package}" title="{$title_package}" width="72" height="72">
                            </div>
                            {if $parent_id}
                                <p class="txt_itempayment">{$title_tour}<span class="d-block fw-light">{$title_package}</span></p>
                            {else}
                            <p class="txt_itempayment">{$title_package}</p>
                            {/if}
                        </div>
                        <div class="box_text_item_detail">
                            <div class="cart_info_date_item">
                                <i class="fa-light fa-calendar"></i>
                                <label>{$clsISO->converTimeToText5($departure_date)}</label>
                                <i class="fa-solid fa-circle-small"></i>
                                {$clsTour->getLTripDuration($tour_id)}
                            </div>
                            <div class="cart_info_total_customer">
                                <i class="fa-light fa-user"></i>
                                {$number_adult} {$core->get_Lang('Adults')}{if $number_child}, {$number_child} {$core->get_Lang('Children')}{/if}{if $number_infant}, {$number_infant} {$core->get_Lang('Infants')}{/if}
                            </div>
                        </div>
                        <div class="box_item_price_detail">
                            <div class="txt_price_number mt-2">
                                <p class="txt_pricebold">{$core->get_Lang('Price')}</p>
                                <p class="txt_numberprice">
                                    <span class="txt_number_boldprice">
                                        {if $_LANG_ID == 'vn'}
                                            {$clsISO->formatPrice($item.total_price_z)}{$clsISO->getShortRate()}
                                        {else}
                                            {$clsISO->getShortRate()} {$clsISO->formatPrice($item.total_price_z)}
                                        {/if}
                                    </span>
                                </p>
                            </div>
                            <div class="txt_redposit">
                                <p class="txt_depositbold">{$core->get_Lang('Deposit')} {if !empty($item.deposit)}{$item.deposit}{else}0{/if}% </p>
                                <span class="txt_paynow">
                                {if $_LANG_ID == 'vn'}
                                    ({$clsISO->formatPrice($item.price_deposit|default:0)}{$clsISO->getShortRate()})
                                {else}
                                    ({$clsISO->getShortRate()}{$clsISO->formatPrice($item.price_deposit|default:0)})
                                {/if}
                                </span>
                            </div>
                        </div>
                    </div>
                {/if}
            {/foreach}
        {/if}

        <!-- Box Item Hotel -->

        {if $cartSessionHotel}
            {foreach from=$cartSessionHotel key=k item=item name=item}
                {assign var=title_hotel value=$clsHotel->getTitle($k)}
                {*    {assign var=link_hotel value=$clsHotel->getLink($item.hotel_id)}*}
                {assign var=image_hotel value=$clsHotel->getImage($item.hotel_id,72,72)}
                {assign var=star_hotel value=$clsHotel->getStar($item.hotel_id)}
                {assign var=payment_down_money value=0}
                <div class="border_item_list hnv_cart_item_hotel">
                    <div class="img_txt_item">
                        <div class="iso_cart_right_img">
                            <img class="item_payment" src="{$image_hotel}" alt="{$title_hotel}" title="{$title_hotel}" width="72" height="72">
                        </div>
                        <div class="txt_star">
                            <p class="txt_itempayment">{$title_hotel}</p>
                            <div class="ico_star d-flex">
                                {section name=i loop=$star_hotel}
                                    <i class="fa-sharp fa-solid fa-star" style="color: #fed141;"></i>
                                {/section}
                            </div>
                        </div>

                    </div>
                    <div class="box_text_item_detail">
                        <div class="cart_info_date_item item_datehotel">
                            <i class="fa-light fa-calendar"></i>
                            <label>{$clsISO->converTimeToText5($item.check_in)}</label>
                            <i class="fa-duotone fa-light fa-arrow-right-long"></i>
                            {$clsISO->converTimeToText5($item.check_out)}
                            |
                            <span>
                                {if $item.number_night}
                                    {$item.number_night} {$core->get_Lang('nights')}
                                {else} 
                                    1 {$core->get_Lang('night')}
                                {/if}
                            </span>
                        </div>
                        {assign var="room_arr" value=$item.room}
                        {assign var="total_room" value=0}
                        {foreach from=$room_arr key=k1 item=i1}
                            {assign var="total_room" value=$total_room + $i1.number_room}
                        {/foreach}

                        <div class="hnv_cart_item_info_detail_customer">
                            <div class="hnv_cart_item_info_detail_customer_room info_item_room">
                                <i class="fa-light fa-person-to-door"></i> {$total_room} {$core->get_Lang('Rooms')}
                                <a href="javascript:void(0);" title="{$core->get_Lang('View detail')}">
                                    <i class="fa-light fa-angle-down" data-hotel_id="right_{$item.hotel_id}"></i>
                                </a>
                            </div>
                            <ul class="hnv_cart_item_info_detail_customer_room_list hnv_cart_item_info_detail_customer_room_list_right_{$item.hotel_id}"
                                style="display: none;">
                                {foreach from=$room_arr key=k item=i}
                                    {$payment_down_money = $payment_down_money+$i.payment_down_money}
                                    {assign var=payment_down value=$clsHotelRoom->getPaymentDown($i.hotel_room_id)}
                                    {assign var=txt_number_people value=$clsHotelRoom->getTxtNumberPeople($i.hotel_room_id)}
                                    <li class="hnv_cart_item_info_detail_customer_room_item">
                                        {$i.number_room} x {$clsHotelRoom->getTitle($i.hotel_room_id)} {if $payment_down > 0}- {$core->get_Lang('Deposit')}: {$payment_down}% {/if}
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>

                    {*<div class="cart_txt_border_item_list">
                        <div class="item_border">
                            <p class="txt_item_white">
                                <i class="fa-light fa-circle-xmark"></i>
                                <span>{$core->get_Lang('Non-refundable')}</span>
                            </p>
                        </div>
                        <div class="item_border">
                            <p class="txt_item_green">
                                <i class="fa-light fa-calendar-check"></i>
                                <span>{$core->get_Lang('Date changed')}</span>
                            </p>
                        </div>
                    </div>*}

                    <div class="box_item_price_detail">
                        <div class="txt_price_number">
                            <p class="txt_pricebold">{$core->get_Lang('Price')}</p>
                            <p class="txt_numberprice">
                                <span class="txt_number_boldprice">
                                    {if $_LANG_ID == 'vn'}
                                        {$clsISO->formatPrice($item.totalpriceRoom)}{$clsISO->getShortRate()}
                                    {else}
                                        {$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceRoom)}
                                    {/if}
                                </span>
                            </p>
                        </div>
                        <div class="txt_redposit">
                            <p class="txt_depositbold">{$core->get_Lang('Deposit')}</p>
                            <span class="txt_paynow">
                                {if $_LANG_ID == 'vn'}
                                    {$clsISO->formatPrice($payment_down_money)}{$clsISO->getShortRate()}
                                {else}
                                    {$clsISO->getShortRate()}{$clsISO->formatPrice($payment_down_money)}
                                {/if}
                            </span>
                        </div>
                    </div>
                </div>
            {/foreach}
        {/if}

        <!-- Box Item Cruise -->

        {if $cartSessionCruise}
            {foreach from=$cartSessionCruise key=k item=item name=item}
                {assign var=title_cruise value=$clsCruiseItinerary->getTitleDay($k)}
                {assign var=link_cruise value=$clsCruise->getLink($item.cruise_id)}
                {assign var=image_cruise value=$clsCruise->getImage($item.cruise_id,72,72)}
                <div class="border_item_list border_item_list_cruise">
                    <div class="img_txt_item">
                        <div class="iso_cart_right_img">
                            <img class="item_payment" src="{$image_cruise}" alt="{$title_cruise}" title="{$title_cruise}" width="72" height="72">
                        </div>
                        <p class="txt_itempayment">{$title_cruise}</p>
                    </div>
                    <div class="box_text_item_detail">
                        <div class="cart_info_date_item">
                            <i class="fa-light fa-calendars"></i>
                            <label>{$core->get_Lang('Itinerary')}
                                : {$clsCruiseItinerary->getTitleItinerary($item.cruise_itinerary_id)}</label>
                        </div>

                        <div class="cart_info_date_item">
                            <i class="fa-light fa-calendar"></i>
                            <label>{$clsISO->convertTimeToText($item.departure_date)}</label>
                            <i class="fa-duotone fa-light fa-arrow-right-long"></i>
                            {$clsISO->convertTimeToText($clsCruiseItinerary->getTextEndDate($item.departure_date, $item.cruise_itinerary_id))}
                            {if $clsCruiseItinerary->getNumberNight($item.cruise_itinerary_id) > 0}
                                <span>| {$clsCruiseItinerary->getNumberNight($item.cruise_itinerary_id)} {$core->get_Lang('nights')}</span>
                            {/if}
                        </div>

                        {assign var="cabin_arr" value=$item.cabin}
                        {assign var="total_cabin" value=0}
                        {assign var="total_deposit_price" value=0}
                        {foreach from=$cabin_arr key=k1 item=i1}
                            {assign var="total_cabin" value=$total_cabin + $i1.number_cabin}
                            {$total_deposit_price = $total_deposit_price + $i1.deposit_price}
                        {/foreach}

                        <div class="cart_info_total_customer">
                            <i class="fa-light fa-person-to-door"></i> {$total_cabin} {$core->get_Lang('Cabins')}
                            {if $total_cabin > 1}
                            <a href="javascript:void(0);" title="{$core->get_Lang('View detail')}"></a>
                            <i class="fa-light fa-angle-down" data-cruise_id="{$k}_{$item.cruise_id}"></i>
                            {else} 
                            {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                <span>: {$clsCruiseCabin->getTitle($cruise_cabin_id)}</span>
                            {/foreach}
                            {/if}
                            {if $total_cabin > 1}
                            <ul class="hnv_cart_item_info_detail_customer_room_list hnv_cart_item_info_detail_customer_room_list_{$k}_{$item.cruise_id}" style="display: none;">
                                {foreach from=$item.cabin key=cruise_cabin_id item=value name=cabin}
                                    <li class="hnv_cart_item_info_detail_customer_room_item">
                                        {$value.number_cabin} x {$clsCruiseCabin->getTitle($cruise_cabin_id)} {*(2 adults)*}
                                    </li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div>

                        {*<div class="cart_txt_border_item_list">
                            <div class="item_border">
                                <p class="txt_item_white">
                                    <i class="fa-light fa-circle-xmark"></i>
                                    <span>{$core->get_Lang('Non-refundable')}</span>
                                </p>
                            </div>
                            <div class="item_border">
                                <p class="txt_item_green">
                                    <i class="fa-light fa-calendar-check"></i>
                                    <span>{$core->get_Lang('Date changed')}</span>
                                </p>
                            </div>
                        </div>*}

                    </div>
                    <div class="box_item_price_detail">
                        <div class="txt_price_number">
                            <p class="txt_pricebold">{$core->get_Lang('Price')}</p>
                            <p class="txt_numberprice">
                                <span class="txt_number_boldprice">
                                        {if $_LANG_ID == 'vn'}
                                            {$clsISO->formatPrice($item.totalpriceCabin)}{$clsISO->getShortRate()}
                                        {else}
                                            {$clsISO->getShortRate()}{$clsISO->formatPrice($item.totalpriceCabin)}
                                        {/if}
                                </span>
                            </p>
                        </div>
                            <div class="txt_redposit">
                                <p class="txt_depositbold">{$core->get_Lang('Deposit')} {$item.deposit|default:0}%</p>
                                <span class="txt_paynow"> 
                                    {if $_LANG_ID == 'vn'} 
                                    {$clsISO->formatPrice($total_deposit_price)}{$clsISO->getShortRate()})
                                    {else} 
                                    ({$clsISO->getShortRate()}{$clsISO->formatPrice($total_deposit_price)})
                                    {/if}
                                </span>
                            </div>
                    </div>

                </div>
            {/foreach}
        {/if}

        <!-- Box Item Voucher -->
        {if $cartSessionVoucher}
            {foreach from=$cartSessionVoucher item=item name=item}

                {assign var=voucher_id value=$item.voucher_id}
                {if $voucher_id}
                    {assign var=title_package value=$clsVoucher->getTitle($item.voucher_id)}
                    {assign var=link_package value=$clsVoucher->getLink($item.voucher_id)}
                    {assign var=price_package value=$clsVoucher->getPrice($item.voucher_id)}
                    {assign var=price_voucher value=$clsVoucher->getPricePromotion2($item.voucher_id)}
                    {assign var=priceO_voucher value=$clsVoucher->getPricePromotionO($item.voucher_id)}
                    {assign var=priceO_package value=$clsVoucher->getPriceOrigin($item.voucher_id)}
                    {assign var=img_voucher value=$clsVoucher->getImage($item.voucher_id,72,72)}
                    {assign var=link_voucher value=$clsVoucher->getLink($item.voucher_id)}
                    {assign var=priceOld value=$clsVoucher->getPricePromotionO($voucher_id)}
                    {assign var=numberVoucher value=$item.number_voucher}
                    {math assign="PriceVoucher" equation="x * y" x=$priceOld y=$numberVoucher}

                    {assign var=getPromotion value=$clsISO->getPromotion($voucher_id,'voucher',$time_now,$time_now,'get_infomation')}
                    {if $item.discount_value}
                        {if $item.discount_type eq '1'}
                            {math assign='pricePromotion' equation="x - y" x=$priceOld y=$item.discount_value}
                            {assign var=priceDiscount value=$item.discount_value}
                        {else}
                            {math assign='pricePromotion' equation="x*(100 - y)/100" x=$priceOld y=$item.discount_value}
                            {math assign='priceDiscount' equation="x*y/100" x=$priceOld y=$item.discount_value}
                        {/if}
                        {math assign="TotalPriceVoucher" equation="x * y" x=$pricePromotion y=$numberVoucher}
                    {else}
                        {assign var=TotalPriceVoucher value=$PriceVoucher}
                    {/if}
                    <div class="border_item_list hnv_cart_item_voucher">
                        <div class="img_txt_item">
                            <div class="iso_cart_right_img">
                                <img class="item_payment" src="{$img_voucher}" alt="{$title_package}" title="{$title_package}" width="72" height="72">
                            </div>
                            <p class="txt_itempayment">{$title_cruise}</p>
                        </div>
                        <div class="box_text_item_detail">
                            <div class="cart_info_date_item">
                                <i class="fa-light fa-calendar"></i>
                                <label>Wed, Dec 4, 2024</label>
                            </div>

                            <div class="cart_info_date_item">
                                <i class="fa-light fa-calendars"></i>
                                <label>2 Combo 2N1D Villa 2PN NovaWorld Phan Thiet + Play in 5 parks (1 day) + Breakfast +
                                    Shuttle bus from Ho Chi Minh City</label>
                            </div>

                            {*<div class="cart_txt_border_item_list">
                                <div class="item_border">
                                    <p class="txt_item_white">
                                        <i class="fa-light fa-circle-xmark"></i>
                                        <span>{$core->get_Lang('Non-refundable')}</span>
                                    </p>
                                </div>
                                <div class="item_border">
                                    <p class="txt_item_green">
                                        <i class="fa-light fa-calendar-check"></i>
                                        <span>{$core->get_Lang('Date changed')}</span>
                                    </p>
                                </div>
                            </div>*}

                        </div>
                        <div class="box_item_price_detail">
                            <div class="txt_price_number">
                                <p class="txt_pricebold">{$core->get_Lang('Price')}</p>
                                <p class="txt_numberprice">
                                        <span class="txt_number_boldprice">
                                             {if $_LANG_ID == 'vn'}
                                                 {$clsISO->formatPrice($TotalPriceVoucher)}{$clsISO->getShortRate()}
                                             {else}
                                                 {$clsISO->getShortRate()}{$clsISO->formatPrice($TotalPriceVoucher)}
                                             {/if}
                                        </span>
                                </p>
                            </div>
                        </div>

                    </div>
                {/if}
            {/foreach}
        {/if}
    </div>

    <div class="total_price_item">
        <div class="txt_toalbook">
            <h2 class="txt_sumprice">{$core->get_Lang('Your price summary')}</h2>
            <div class="list_totalnumb">
                <div class="txt_numbtxttotal">
                    <h3 class="txttotal">{$core->get_Lang('Total price')}</h3>
                    <h4 class="txt_numbtotal" id="totalPrice">
                        {if $_LANG_ID == 'vn'}
                            {$clsISO->formatPrice($totalGrand)}{$clsISO->getShortRate()}
                        {else}
                            {$clsISO->getShortRate()}{$clsISO->formatPrice($totalGrand)}
                        {/if}

                    </h4>
                </div>

                <div class="txt_numbtxttotal" id="priceAfterPromoContainer">
                    <h3 class="txttotal">{$core->get_Lang('Price after promotion')}</h3>
                    <h4 class="txt_numbtotal" id="priceAfterPromo">
                        {if $_LANG_ID == 'vn'}
                            {$clsISO->formatPrice($totalPricePromotion)}{$clsISO->getShortRate()}
                        {else}
                            {$clsISO->getShortRate()}{$clsISO->formatPrice($totalPricePromotion)}
                        {/if}
                    </h4>
                </div>

                <div class="txt_numbtxttotal">
                    <h3 class="txttotal">{$core->get_Lang('Booking fees')}</h3>
                    <h4 class="txt_numbtotal" id="pricebookfee">
                        {if $_LANG_ID == 'vn'}
                            {$clsISO->formatPrice($totalPriceDeposit)}{$clsISO->getShortRate()}
                        {else}
                            {$clsISO->getShortRate()}{$clsISO->formatPrice($totalPriceDeposit)}
                        {/if}
                    </h4>
                </div>
            </div>
        </div>
        <div class="box_paynow">
            <div class="txtnumb_paynowpadding">
                <div class="numb_txtpaynow">
                    <h3 class="txtpaynow">{$core->get_Lang('Pay Now')}</h3>
                    {if $_LANG_ID == 'vn'}
                        <h4 class="bold_numbpaynow">{$clsISO->formatPrice($totalPriceDeposit)}
                            <span class="numb_paynow">{$clsISO->getShortRate()}</span>
                        </h4>
                    {else}
                        <h4 class="numb_paynow">{$clsISO->getShortRate()}
                            <span class="bold_numbpaynow">{$clsISO->formatPrice($totalPriceDeposit)}</span>
                        </h4>
                    {/if}
                </div>
                <h5 class="text-right txt_taxesall">{$core->get_Lang('All taxes and fees included')}</h5>
                <h6 class="text-right txt_paymentcomplete">{$core->get_Lang("Complete payment of")}
                    {if $_LANG_ID == 'vn'}
                        {$clsISO->formatPrice($totalPriceDeposit)}{$clsISO->getShortRate()}
                    {else}
                        {$clsISO->getShortRate()}{$clsISO->formatPrice($totalPriceDeposit)}
                    {/if}
                    {$core->get_Lang('subject to the Payment Terms of each service')}</h6>
            </div>
        </div>
    </div>
    <div class="items_rebook">
        <div class="txt_itemsbook">
            <img src="https://api.iconify.design/hugeicons:time-quarter.svg?color=%23C81E3A" title="time-quarter"
                    alt="time-quarter">
            <h2 class="txt_items_bookre">{$core->get_Lang("Items aren't reserved until you book")}</h2>
        </div>
    </div>

{/if}


{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let promoCodeValid = "DISCOUNT10"; // Mã giảm giá hợp lệ
            let discountAmount = 1; // Giảm giá $1, có thể thay đổi tùy vào giá trị mã giảm giá thực tế

            function showInput() {
                document.querySelector(".enter_promocode").style.display = 'none';
                document.querySelector(".enter_promocode input").style.display = 'block';
                document.querySelector(".enter_promocode button").style.display = 'inline-block';
            }

            function applyPromoCode() {
                const promoCode = document.getElementById("promoCodeInput").value;
                const promoCodeDiv = document.querySelector(".enter_promocode");
                const messageDiv = document.getElementById("message");
                const promoCodeInput = document.getElementById("promoCodeInput");
                const checkIcon = document.getElementById("checkIcon");
                const priceAfterPromoContainer = document.getElementById("priceAfterPromoContainer");

                // Clear previous success or error states
                messageDiv.classList.remove('success', 'error');
                promoCodeInput.classList.remove('success_text', 'error_text');
                checkIcon.style.display = 'none'; // Ẩn biểu tượng check mỗi lần nhập

                if (promoCode === promoCodeValid) {
                    // Thành công
                    promoCodeDiv.classList.add('success');
                    promoCodeDiv.classList.remove('error');
                    promoCodeInput.classList.add('success_text'); // Thêm viền xanh
                    checkIcon.style.display = 'block'; // Hiển thị biểu tượng check
                    document.getElementById("applyButton").style.display = 'none';
                    messageDiv.innerHTML = 'You get <span class="txt_numbpricebold">US $1</span> off on the total order! <span class="remove" onclick="removePromoCode()">x Remove</span>';
                    messageDiv.classList.add('success');
                    messageDiv.style.display = 'flex'; // Hiển thị thông báo thành công

                    // Hiển thị "Price after promotion"
                    priceAfterPromoContainer.style.display = 'flex';

                    // Cập nhật giá trị "Price after promotion" và màu sắc
                    updatePriceAfterPromo();
                } else {
                    // Thất bại
                    promoCodeDiv.classList.add('error');
                    promoCodeDiv.classList.remove('success');
                    promoCodeInput.classList.add('error_text'); // Thêm viền đỏ
                    document.getElementById("applyButton").style.display = 'inline-block';
                    messageDiv.innerHTML = 'The code is incorrect or does not exist, please enter another code';
                    messageDiv.classList.add('error');
                    messageDiv.style.display = 'block'; // Hiển thị thông báo lỗi

                    // Sau 5 giây, ẩn thông báo với hiệu ứng mờ dần
                    setTimeout(() => {
                        messageDiv.style.opacity = 0;
                        setTimeout(() => {
                            messageDiv.style.display = 'none'; // Ẩn thông báo sau khi mờ
                            promoCodeDiv.classList.remove('error'); // Xóa class lỗi
                            promoCodeInput.classList.remove('error_text'); // Xóa class lỗi
                            messageDiv.style.opacity = 1; // Reset lại opacity
                        }, 1000); // Chờ 1 giây sau khi mờ dần
                    }, 3000);
                }
            }

            function removePromoCode() {
                const promoCodeInput = document.getElementById("promoCodeInput");
                const priceAfterPromoContainer = document.getElementById("priceAfterPromoContainer");

                document.querySelector(".enter_promocode").style.display = 'flex';
                document.querySelector(".enter_promocode input").style.display = 'none';
                document.querySelector(".enter_promocode button").style.display = 'none';
                document.querySelector(".enter_promocode").classList.remove('success', 'error');
                document.getElementById("promoCodeInput").value = ''; // Xóa giá trị trong input
                document.getElementById("message").style.display = 'none';
                document.getElementById("checkIcon").style.display = 'none'; // Ẩn biểu tượng check

                // Khi xóa, bỏ tất cả các class của input (chỉ làm sau khi xóa)
                promoCodeInput.classList.remove('success_text', 'error_text');

                // Ẩn lại "Price after promotion"
                priceAfterPromoContainer.style.display = 'none';

                // Cập nhật lại giá trị Price after promotion về giá trị ban đầu
                resetPriceAfterPromo();
            }

            // Hàm cập nhật giá trị "Price after promotion"
            function updatePriceAfterPromo() {
                const totalPrice = parseFloat(document.getElementById("totalPrice").textContent.replace("US $", ""));
                const priceAfterPromo = totalPrice - discountAmount;

                // Cập nhật giá trị "Price after promotion"
                document.getElementById("priceAfterPromo").textContent = `US $${priceAfterPromo.toFixed(2)}`;

                // Cập nhật màu sắc sau khi áp dụng mã giảm giá
                document.getElementById("priceAfterPromo").style.color = "var(--secondary-007850, #007850)"; // Màu sắc thay đổi
            }

            function removePromoCode() {
                const promoCodeInput = document.getElementById("promoCodeInput");
                document.querySelector(".enter_promocode").style.display = 'flex';
                document.querySelector(".enter_promocode input").style.display = 'none';
                document.querySelector(".enter_promocode button").style.display = 'none';
                document.querySelector(".enter_promocode").classList.remove('success', 'error');
                document.getElementById("promoCodeInput").value = ''; // Xóa giá trị trong input
                document.getElementById("message").style.display = 'none';
                document.getElementById("checkIcon").style.display = 'none'; // Ẩn biểu tượng check

                // Khi xóa, bỏ tất cả các class của input (chỉ làm sau khi xóa)
                promoCodeInput.classList.remove('success_text', 'error_text');

                // Cập nhật lại giá trị Price after promotion về giá trị ban đầu
                resetPriceAfterPromo();
            }

            // Hàm reset giá trị Price after promotion khi xóa mã
            function resetPriceAfterPromo() {
                const totalPrice = parseFloat(document.getElementById("totalPrice").textContent.replace("US $", ""));
                document.getElementById("priceAfterPromo").textContent = `US $${totalPrice.toFixed(2)}`; // Trả về giá trị ban đầu
                document.getElementById("priceAfterPromo").style.color = "#1D2D53"; // Đặt lại màu sắc về mặc định
            }

            $(document).ready(function () {
                $('.hnv_cart_item_hotel .fa-angle-down').off('click').on('click', function () {
                    let hotel_id = $(this).data('hotel_id');
                    $(this).toggleClass('rotate180');
                    $('.hnv_cart_item_hotel .hnv_cart_item_info_detail_customer_room_list_' + hotel_id).slideToggle();
                });
            });

            $(document).ready(function () {
                $('.border_item_list_cruise .fa-angle-down').off('click').on('click', function () {
                    let cruise_id = $(this).data('cruise_id');
                    $(this).toggleClass('rotate180');
                    $('.border_item_list_cruise .hnv_cart_item_info_detail_customer_room_list_' + cruise_id).slideToggle();
                });
            });
        })
    </script>

    <style>
        .cart_info_date_item.item_datehotel span {
            color: var(--chroma-717171, #717171);
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 21px;
        }

        .info_item_room {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 21px;
        }


    </style>
{/literal}