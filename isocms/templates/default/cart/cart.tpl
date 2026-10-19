<div class="" id="cart_default">
    <div class="container">
        <form action="" method="post" class="formBookingTour">
            <div id="content" class="cart_page">
                {if $cartSessionService or $cartSessionVoucher or $cartSessionCruise or $cartSessionHotel}
                    <div class="list_cart">
                        <div class="row">
                            <div class="col-lg-8 col-xs-12 box_left_step1">
                                <h1 class="text-bold mb20">{$core->get_Lang('Cart')}</h1>
                                {if $cartSessionService or $cartSessionVoucher or $cartSessionCruise or $cartSessionHotel}
                                    <p class="alert_noti">
                                        <i class="fa-regular fa-clock me-2"></i>
                                        <span>{$core->get_Lang("Items aren't reserved until you book")}</span>
                                    </p>
                                {/if}
                                <div class="package_book_box mb30">
                                    {$core->getBlock('cart_tour_box')}
                                    {$core->getBlock('cart_hotel_box')}
                                    {$core->getBlock('cart_cruise_box')}
                                    {$core->getBlock('cart_voucher_box')}
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12 box_right_step1">
                                <div class="col_right_book" id="iso_box_left_cart">
                                    <div class="billing_infomation">
                                        <div class="price_grand_total">
                                            <label class="size18 pr20">{$core->get_Lang('Subtotal')}</label>
                                            <input type="hidden" value="{$clsISO->formatPrice($totalGrand)}"
                                                   name="grand_total_booking"/>
                                            {if $_LANG_ID eq 'vn'}
                                                <div class="span_price">
                                                    <span class="text_bold size22">{$clsISO->formatPrice($totalGrand)} <span
                                                                class="size16 text_normal">{$clsISO->getShortRate()}</span></span>
                                                    <p class="color_1fb69a">{$core->get_Lang('There are no additional fees')}</p>
                                                </div>
                                            {else}
                                                <div class="span_price">
                                                    <span class="text_bold size22"><span
                                                                class="size16 text_normal">{$clsISO->getShortRate()}</span>{$clsISO->formatPrice($totalGrand)}</span>
                                                    <p class="color_1fb69a">{$core->get_Lang('All taxes and fees included')}</p>
                                                </div>
                                            {/if}
                                        </div>
                                        <button class="btn-booking-next-step" type="submit">
                                            {$core->get_Lang('Go to checkout')}
                                        </button>
                                        <ul class="list__item list_style_none mt-4">
                                            <li class="item_check d-flex">
                                                <div class="">
                                                    <p class="txt_item_check mb-0">{$core->get_Lang("Guaranteed Reservation")}</p>
                                                    <p class="txt_deposit">{$core->get_Lang("Even with 0% deposit")}</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="list__item list_style_none">
                                            <li class="item_check d-flex">
                                                <div class="">
                                                    <p class="txt_item_check mb-0">{$core->get_Lang("Multiple Payment Methods Accepted")}</p>
                                                    <div class="div_img_payment d-flex">
                                                        <img class="img_payment" src="{$URL_IMAGES}/icon/vnpay.png"
                                                             alt="vnpay">
                                                        <img class="img_payment"
                                                             src="{$URL_IMAGES}/icon/visa-master.png" alt="visa-master">
                                                        <img class="img_payment" src="{$URL_IMAGES}/icon/one-pay.png"
                                                             alt="one-pay">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <input type="hidden" name="bookingCart" value="bookingCart">
                                    </div>
                                    {if $listWhy}
                                        <div class="box__Faqs">
                                            <h2 class="box__Faqs--title title_section text_bold">
                                                <a href="{$clsISO->getLink('faqs')}" class="txt_why" title="{$core->get_Lang('Why book with us?')}">
                                                    <span>{$core->get_Lang('Why book with us?')}</span>
                                                </a>
                                            </h2>
                                            <ul class="list__item list_style_none">
                                                {foreach from=$listWhy key=key item=item} 
                                                    <li class="item_check d-flex align-items-center">
                                                        <p class="txt_item_check">
                                                            {$item.title}
                                                        </p>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        </div>
                                    {/if}
                                    <div class="call_helpmore">
                                        <h2>{$core->get_Lang('Need more help')}?</h2>
                                        <p class="txt_call_chat">
                                            {$core->get_Lang('Call')}
                                            <a href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                                               title="{$clsConfiguration->getValue('CompanyHotline')}"
                                               alt="{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                {else}
                    <div class="image_cart">
                        <img src="{$URL_IMAGES}/emty_cart_2024.png" class="img100">
                    </div>
                    <div class="text">
                        <h2 class="text-bold size35 mb30">{$core->get_Lang('Your cart is empty')}</h2>
                        <p>{$core->get_Lang("Find amazing experiences and start your next adventure")}.</p>
                        <a class="iso_things_to_do" href="{$DOMAIN_NAME}{$extLang}"
                           title="{$core->get_Lang('start selection')}">{$core->get_Lang('Find things to do')}</a>
                    </div>
                    <div class="help_call">
                        <p>{$core->get_Lang('Need more help')}?
                            {$core->get_Lang('Call')}
                            <a href="tel:{$clsConfiguration->getValue('CompanyHotline')}"
                               title="{$clsConfiguration->getValue('CompanyHotline')}"
                               alt="{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}
                            </a>
                        </p>
                    </div>
                {/if}
            </div>
        </form>

    </div>
</div>
<script>
    var msg_lastname_required = "{$core->get_Lang('Your last name should not be empty')}!";
    var msg_email_repeat_not_valid = "{$core->get_Lang('Email repeat addresses do not match')}!";
    var promotion_check = '{$promotion}';
    var ONEPAY_Visa_Surcharge = '{$clsConfiguration->getValue("ONEPAY_Visa_Surcharge")}';
    var ONEPAY_American_Express_Surcharge = '{$clsConfiguration->getValue("ONEPAY_American_Express_Surcharge")}';
    var Paypal_Surcharge = '{$clsConfiguration->getValue("Paypal_Surcharge")}';
    var travel_date = '{$travel_date}';
    var booking_date = '{$booking_date}';
    var txt_delete_cart = "{$core->get_Lang('Are you sure you want to delete')}?";
</script>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var $ww = $(window).width();
            $(document).ready(function () {
                $("#isocms_header").css("position", "relative")
                $(".change_date").on('click', function (event) {
                    window.location.reload($('html, body').animate({
                        scrollTop: $('#append_html_day_trip').offset().top - 115
                    }));
                });
            });
            $(document).on('click', '.ajvCart', function () {
                if (confirm(txt_delete_cart)) {
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
                }
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