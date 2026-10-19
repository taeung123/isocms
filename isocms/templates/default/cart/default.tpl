<div class="" id="cart_default">
    <div class="container">
        <form action="" method="post" class="formBookingTour">
            <div id="content" class="cart_page">
                {if $cartSessionService or $cartSessionVoucher or $cartSessionCruise or $cartSessionHotel}
                    <div class="list_cart">
                        <div class="row">
                            <div class="col-lg-8 col-xs-12 box_left_step1">
                                <h2 class="text-bold size35 mb20">{$core->get_Lang('Cart')}</h2>
                                {if $cartSessionService or $cartSessionVoucher or $cartSessionCruise or $cartSessionHotel}
                                    <p class="note size16">{$core->get_Lang('Check the service information you have put in the cart.')}</p>
                                {/if}
                                <div class="package_book_box mb30">
                                    {$core->getBlock('cart_tour_box')}
                                    {if $cartSessionVoucher}
                                        {$core->getBlock('cart_voucher_box')}
                                    {/if}
                                    {if $cartSessionCruise}
                                        {$core->getBlock('cart_cruise_box')}
                                    {/if}
                                    {if $cartSessionHotel}
                                        {$core->getBlock('cart_hotel_box')}
                                    {/if}
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12 box_right_step1">
                                <div class="col_right_book" id="sidebar">
                                    <div class="billing_infomation">
                                        <div class="price_grand_total ">

                                            <label class="size18 pr20">{$core->get_Lang('Total')}:</label>
                                            <input type="hidden" value="{$clsISO->formatPrice($totalGrand)}"
                                                   name="grand_total_booking"/>
                                            {if $_LANG_ID eq 'vn'}
                                                <div class="span_price">
                                                    <span class="text_bold size22">{$clsISO->formatPrice($totalGrand)} <span
                                                                class="size16 text_normal text-underline">{$clsISO->getShortRate()}</span></span>
                                                    <p class="size16 color_1fb69a">{$core->get_Lang('There are no additional fees')}</p>
                                                </div>
                                            {else}
                                                <div class="span_price">
                                                    <span class="text_bold size22"><span
                                                                class="size16 text_normal text-underline">{$clsISO->getShortRate()}</span>{$clsISO->formatPrice($totalGrand)}</span>
                                                    <p class="size16 color_1fb69a">{$core->get_Lang('There are no additional fees')}</p>
                                                </div>
                                            {/if}
                                        </div>
                                        <button class="btn-booking-next-step btn_main size18" type="submit">
                                            {$core->get_Lang('Proceed to payment')}
                                        </button>
                                        <input type="hidden" name="bookingCart" value="bookingCart">
                                        <a class="view_tour btn-booking-next-step size18 text-center"
                                           href="{$DOMAIN_NAME}{$extLang}"
                                           title="{$core->get_Lang('See other services')}">{$core->get_Lang('See other services')}</a>
                                    </div>
                                    {$core->getBlock('Lfaqscolbox')}
                                </div>
                            </div>
                        </div>
                    </div>
                {else}
                    <div class="image_cart">
                        <img src="{$URL_IMAGES}/cart.png" class="img100">
                    </div>
                    <div class="text">
                        <h2 class="text-bold size35 mb30">{$core->get_Lang('Your cart is empty')}</h2>
                        <p>{$core->get_Lang("Looks like you haven't added anything to your cart yet")}.</p>
                        <a class="btn_main" href="{$DOMAIN_NAME}{$extLang}"
                           title="{$core->get_Lang('start selection')}">{$core->get_Lang('start selection')}</a>
                    </div>
                {/if}
            </div>
        </form>
    </div>
</div>
<script>
    var msg_fullname_required = "{$core->get_Lang('Your full name should not be empty')}!";
    var msg_lastname_required = "{$core->get_Lang('Your last name should not be empty')}!";
    var msg_phone_required = "{$core->get_Lang('Your phone should not be empty')}!";
    var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
    var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
    var msg_confirmemail_not_valid = "{$core->get_Lang('Email addresses do not match')}!";
    var msg_email_repeat_not_valid = "{$core->get_Lang('Email repeat addresses do not match')}!";
    var promotion_check = '{$promotion}';
    var ONEPAY_Visa_Surcharge = '{$clsConfiguration->getValue("ONEPAY_Visa_Surcharge")}';
    var ONEPAY_American_Express_Surcharge = '{$clsConfiguration->getValue("ONEPAY_American_Express_Surcharge")}';
    var Paypal_Surcharge = '{$clsConfiguration->getValue("Paypal_Surcharge")}';
    var travel_date = '{$travel_date}';
    var booking_date = '{$booking_date}';
</script>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var $ww = $(window).width();
            $(document).ready(function () {
                if ($ww > 992) {
                    $.lockfixed("#sidebar", {offset: {top: 0, bottom: 84}});
                }
                $(".change_date").on('click', function (event) {
                    window.location.reload($('html, body').animate({
                        scrollTop: $('#append_html_day_trip').offset().top - 115
                    }));
                });
            });
            $(document).on('click', '.ajvCart', function () {
                var $_this = $(this);
                var $table_id = $_this.data('table_id');
                var $tp = $_this.data('tp');
                var $_adata = {
                    'table_id': $table_id,
                    'tp': $tp,
                };
                $.ajax({
                    type: 'post',
                    url: path_ajax_script + '/index.php?mod=cart&act=ajaxUpdateToCart&lang=' + LANG_ID,
                    data: $_adata,
                    dataType: 'html',
                    success: function (html) {
                        window.location.reload();
                    }
                });
                return false;
            });
            $(document).on('click', '.ajvCartVoucher', function () {
                var $_this = $(this);
                var $voucher_id = $_this.attr('voucher_id');
                var $tp = $_this.attr('tp');
                var $from = $_this.attr('from');
                var $_adata = {
                    'voucher_id': $voucher_id,
                    'tp': $tp,
                };
                $.ajax({
                    type: 'post',
                    url: path_ajax_script + '/index.php?mod=voucher&act=ajaxAddVoucherToCart&lang=' + LANG_ID,
                    data: $_adata,
                    dataType: 'html',
                    success: function (html) {
                        window.location.reload();
                    }
                });
                return false;
            });

            function getTotalGrandService() {
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/index.php?mod=cart&act=getTotalGrandService",
                    dataType: "html",
                    success: function (html) {
                        var $htm = formatPrice(html);
                        $('#totalGrandService').html($htm);
                        $('#totalGrandVoucher').html($htm);
                        $('input[name=totalGrandService]').val($htm);
                        $('input[name=totalGrandVoucher]').val($htm);
                    }
                });
            }
        })
    </script>
{/literal}