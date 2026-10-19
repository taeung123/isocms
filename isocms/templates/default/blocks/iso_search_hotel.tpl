<script defer type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link href="{$URL_JS}/daterangepicker/daterangepicker.min.css?ver={$upd_version}" rel="stylesheet">
<script defer src="{$URL_JS}/daterangepicker/daterangepicker.min.js?ver={$upd_version}"></script>
<div class="search-bar {if $mod != 'hotel'}hidden{/if}" id="iso_form_hotel">
    <form class="search_btntour iso_header_form d-flex" method="POST">
        {if $act!='detail' && $act!='detail2024'}
            <div class="row iso_header_form_row">
                <!-- Where do you want to go -->
                <div class="col-12 col-md-12 col-xl-4 iso_header_form_item">
                    <div class="iso_form_floating">
                        <label for="iso_search_key_hotel">{$core->get_Lang('Search for accommodation')}?</label>
                        <input type="text" id="iso_search_key_hotel" name="key"
                               placeholder="{$core->get_Lang('Find a hotel')}"
                               value="{$key_search|default:''}">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4 iso_header_form_item">
                    <div class="iso_form_floating date_picker_group relative">
                        <label for="search_hotel_dates">
                            {$core->get_Lang('Check-in')} & {$core->get_Lang('Check-out')}
                        </label>
                        <input name="search_hotel_dates" id="search_hotel_dates" type="text"
                               value="{$txt_search_hotel_dates|default:''}"
                               placeholder="{$core->get_Lang('Check-in')} & {$core->get_Lang('Check-out')}"/>
                        <div class="iso_icon_svg iso_icon_date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                 viewBox="0 0 18 20" fill="none">
                                <path d="M1 7V17C1 17.5304 1.21071 18.0391 1.58579 18.4142C1.96086 18.7893 2.46957 19 3 19H15C15.5304 19 16.0391 18.7893 16.4142 18.4142C16.7893 18.0391 17 17.5304 17 17V7M1 7V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H5M1 7H17M17 7V5C17 4.46957 16.7893 3.96086 16.4142 3.58579C16.0391 3.21071 15.5304 3 15 3H13M5 3H13M5 3V1M13 3V1"
                                      stroke="#26456E" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4 iso_header_form_item">
                    <div class="iso_form_floating relative">
                        <label for="destination">{$core->get_Lang('Guests')}
                            & {$core->get_Lang('Rooms')}</label>
                        <div class="box_guests_rooms">
                            <span class="txt_room">{$txt_search_hotel_number_rooms}</span> {$core->get_Lang('Room(s)')}
                            ,
                            <span class="txt_adult">{$txt_search_hotel_number_adults}</span> {$core->get_Lang('Adult(s)')}
                            ,
                            <span class="txt_child">{$txt_search_hotel_number_child}</span> {$core->get_Lang('Child')}
                        </div>
                        <div class="iso_icon_svg box_icon_guest_room">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none">
                                <path d="M23.8578 5.67394V19.5122C23.8575 20.0092 23.684 20.4906 23.367 20.8733C23.05 21.2561 22.6095 21.5164 22.1213 21.6093L16.0266 22.7624C15.8952 22.7873 15.7617 22.7998 15.6279 22.7999C15.0624 22.7993 14.5203 22.5742 14.1207 22.1741C13.7211 21.774 13.4967 21.2315 13.4969 20.666V4.53406C13.4968 4.2206 13.5657 3.91096 13.6989 3.62717C13.832 3.34339 14.026 3.09242 14.2672 2.89214C14.5083 2.69186 14.7906 2.54718 15.094 2.46839C15.3974 2.3896 15.7144 2.37864 16.0225 2.43629L22.1172 3.57617C22.6062 3.66842 23.0477 3.92846 23.3655 4.31143C23.6832 4.69441 23.8574 5.17629 23.8578 5.67394ZM22.4352 5.67394C22.435 5.50798 22.3769 5.3473 22.2709 5.21961C22.1649 5.09192 22.0176 5.00522 21.8545 4.97445L15.7613 3.83527C15.7164 3.8266 15.6708 3.82218 15.6251 3.82206C15.4376 3.82422 15.2584 3.90012 15.1263 4.03336C14.9942 4.16659 14.9199 4.34646 14.9194 4.53406V20.666C14.9195 20.7706 14.9426 20.8738 14.9871 20.9684C15.0316 21.063 15.0965 21.1467 15.177 21.2134C15.2575 21.2801 15.3517 21.3283 15.4529 21.3544C15.5542 21.3806 15.6599 21.3841 15.7627 21.3648L21.8573 20.2117C22.0199 20.1805 22.1666 20.0936 22.2721 19.9659C22.3775 19.8383 22.4352 19.6778 22.4352 19.5122V5.67394ZM17.0533 11.1976C16.9599 11.1975 16.8674 11.2159 16.781 11.2516C16.6947 11.2873 16.6163 11.3397 16.5502 11.4058C16.4842 11.4719 16.4318 11.5503 16.396 11.6366C16.3603 11.7229 16.3419 11.8155 16.342 11.9089V13.2912C16.342 13.4798 16.4169 13.6608 16.5503 13.7942C16.6837 13.9275 16.8646 14.0025 17.0533 14.0025C17.2419 14.0025 17.4229 13.9275 17.5563 13.7942C17.6897 13.6608 17.7646 13.4798 17.7646 13.2912V11.9089C17.7646 11.8155 17.7463 11.7229 17.7106 11.6366C17.6748 11.5503 17.6224 11.4719 17.5564 11.4058C17.4903 11.3397 17.4119 11.2873 17.3256 11.2516C17.2392 11.2159 17.1467 11.1975 17.0533 11.1976Z"
                                      fill="#26456E"/>
                                <path d="M1.20001 19.8805V18.2271C1.20001 17.3501 1.5484 16.509 2.16854 15.8889C2.78869 15.2687 3.62978 14.9203 4.50679 14.9203H7.81356C8.69058 14.9203 9.53167 15.2687 10.1518 15.8889C10.7719 16.509 11.1203 17.3501 11.1203 18.2271V19.8805M2.8534 8.30678C2.8534 9.18379 3.20179 10.0249 3.82193 10.645C4.44207 11.2652 5.28317 11.6136 6.16018 11.6136C7.03719 11.6136 7.87828 11.2652 8.49842 10.645C9.11856 10.0249 9.46695 9.18379 9.46695 8.30678C9.46695 7.42977 9.11856 6.58867 8.49842 5.96853C7.87828 5.34839 7.03719 5 6.16018 5C5.28317 5 4.44207 5.34839 3.82193 5.96853C3.20179 6.58867 2.8534 7.42977 2.8534 8.30678Z"
                                      stroke="#26456E" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="iso_box_input">
                            <div class="iso_input_item" data-class="txt_room">
                                <div class="txt">{$core->get_Lang('Room(s)')}</div>
                                <div class="box_events">
                                    <div class="iso_btn_minus opacity">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </div>
                                    <input type="text" name="number_rooms" min="1"
                                           value="{$txt_search_hotel_number_rooms}">
                                    <div class="iso_btn_plus">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="iso_input_item" data-class="txt_adult">
                                <div class="txt">{$core->get_Lang('Adult(s)')}</div>
                                <div class="box_events">
                                    <div class="iso_btn_minus opacity">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </div>
                                    <input type="text" name="number_adults" min="1"
                                           value="{$txt_search_hotel_number_adults}">
                                    <div class="iso_btn_plus">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="iso_input_item" data-class="txt_child">
                                <div class="txt">{$core->get_Lang('Children')}</div>
                                <div class="box_events">
                                    <div class="iso_btn_minus opacity">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </div>
                                    <input type="text" name="number_child" min="0"
                                           value="{$txt_search_hotel_number_child}">
                                    <div class="iso_btn_plus">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search button -->
            <div class="iso_search_btn">
                <button type="submit" class="iso_btn_search">
                    <i class="fa-solid fa-magnifying-glass"></i> {$core->get_Lang('Search')}
                </button>
            </div>

        {else}
            <div class="row iso_box_search_detail">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-12 col-lg-6 iso_header_form_item">
                            <div class="iso_form_floating date_picker_group relative">
                                <input name="search_hotel_dates" id="search_hotel_dates" type="text"
                                       value="{$txt_search_hotel_dates}"
                                       placeholder="{$core->get_Lang('Check-in')} & {$core->get_Lang('Check-out')}"/>
                                <div class="iso_icon_svg iso_icon_date">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                         viewBox="0 0 18 20" fill="none">
                                        <path d="M1 7V17C1 17.5304 1.21071 18.0391 1.58579 18.4142C1.96086 18.7893 2.46957 19 3 19H15C15.5304 19 16.0391 18.7893 16.4142 18.4142C16.7893 18.0391 17 17.5304 17 17V7M1 7V5C1 4.46957 1.21071 3.96086 1.58579 3.58579C1.96086 3.21071 2.46957 3 3 3H5M1 7H17M17 7V5C17 4.46957 16.7893 3.96086 16.4142 3.58579C16.0391 3.21071 15.5304 3 15 3H13M5 3H13M5 3V1M13 3V1"
                                              stroke="#26456E" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 iso_header_form_item">
                            <div class="iso_form_floating relative">
                                <div class="box_guests_rooms">
                                    <span class="txt_room">{$txt_search_hotel_number_rooms}</span> {$core->get_Lang('Room(s)')}
                                    ,
                                    <span class="txt_adult">{$txt_search_hotel_number_adults}</span> {$core->get_Lang('Adult(s)')}
                                    ,
                                    <span class="txt_child">{$txt_search_hotel_number_child}</span> {$core->get_Lang('Child')}
                                </div>
                                <div class="iso_icon_svg box_icon_guest_room">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <path d="M23.8578 5.67394V19.5122C23.8575 20.0092 23.684 20.4906 23.367 20.8733C23.05 21.2561 22.6095 21.5164 22.1213 21.6093L16.0266 22.7624C15.8952 22.7873 15.7617 22.7998 15.6279 22.7999C15.0624 22.7993 14.5203 22.5742 14.1207 22.1741C13.7211 21.774 13.4967 21.2315 13.4969 20.666V4.53406C13.4968 4.2206 13.5657 3.91096 13.6989 3.62717C13.832 3.34339 14.026 3.09242 14.2672 2.89214C14.5083 2.69186 14.7906 2.54718 15.094 2.46839C15.3974 2.3896 15.7144 2.37864 16.0225 2.43629L22.1172 3.57617C22.6062 3.66842 23.0477 3.92846 23.3655 4.31143C23.6832 4.69441 23.8574 5.17629 23.8578 5.67394ZM22.4352 5.67394C22.435 5.50798 22.3769 5.3473 22.2709 5.21961C22.1649 5.09192 22.0176 5.00522 21.8545 4.97445L15.7613 3.83527C15.7164 3.8266 15.6708 3.82218 15.6251 3.82206C15.4376 3.82422 15.2584 3.90012 15.1263 4.03336C14.9942 4.16659 14.9199 4.34646 14.9194 4.53406V20.666C14.9195 20.7706 14.9426 20.8738 14.9871 20.9684C15.0316 21.063 15.0965 21.1467 15.177 21.2134C15.2575 21.2801 15.3517 21.3283 15.4529 21.3544C15.5542 21.3806 15.6599 21.3841 15.7627 21.3648L21.8573 20.2117C22.0199 20.1805 22.1666 20.0936 22.2721 19.9659C22.3775 19.8383 22.4352 19.6778 22.4352 19.5122V5.67394ZM17.0533 11.1976C16.9599 11.1975 16.8674 11.2159 16.781 11.2516C16.6947 11.2873 16.6163 11.3397 16.5502 11.4058C16.4842 11.4719 16.4318 11.5503 16.396 11.6366C16.3603 11.7229 16.3419 11.8155 16.342 11.9089V13.2912C16.342 13.4798 16.4169 13.6608 16.5503 13.7942C16.6837 13.9275 16.8646 14.0025 17.0533 14.0025C17.2419 14.0025 17.4229 13.9275 17.5563 13.7942C17.6897 13.6608 17.7646 13.4798 17.7646 13.2912V11.9089C17.7646 11.8155 17.7463 11.7229 17.7106 11.6366C17.6748 11.5503 17.6224 11.4719 17.5564 11.4058C17.4903 11.3397 17.4119 11.2873 17.3256 11.2516C17.2392 11.2159 17.1467 11.1975 17.0533 11.1976Z"
                                              fill="#26456E"/>
                                        <path d="M1.20001 19.8805V18.2271C1.20001 17.3501 1.5484 16.509 2.16854 15.8889C2.78869 15.2687 3.62978 14.9203 4.50679 14.9203H7.81356C8.69058 14.9203 9.53167 15.2687 10.1518 15.8889C10.7719 16.509 11.1203 17.3501 11.1203 18.2271V19.8805M2.8534 8.30678C2.8534 9.18379 3.20179 10.0249 3.82193 10.645C4.44207 11.2652 5.28317 11.6136 6.16018 11.6136C7.03719 11.6136 7.87828 11.2652 8.49842 10.645C9.11856 10.0249 9.46695 9.18379 9.46695 8.30678C9.46695 7.42977 9.11856 6.58867 8.49842 5.96853C7.87828 5.34839 7.03719 5 6.16018 5C5.28317 5 4.44207 5.34839 3.82193 5.96853C3.20179 6.58867 2.8534 7.42977 2.8534 8.30678Z"
                                              stroke="#26456E" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="iso_box_input">
                                    <div class="iso_input_item" data-class="txt_room">
                                        <div class="txt">{$core->get_Lang('Room(s)')}</div>
                                        <div class="box_events">
                                            <div class="iso_btn_minus opacity">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <input type="text" name="number_rooms" min="1"
                                                   value="{$txt_search_hotel_number_rooms}">
                                            <div class="iso_btn_plus">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="iso_input_item" data-class="txt_adult">
                                        <div class="txt">{$core->get_Lang('Adult(s)')}</div>
                                        <div class="box_events">
                                            <div class="iso_btn_minus opacity">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <input type="text" name="number_adults" min="1"
                                                   value="{$txt_search_hotel_number_adults}">
                                            <div class="iso_btn_plus">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="iso_input_item" data-class="txt_child">
                                        <div class="txt">{$core->get_Lang('Children')}</div>
                                        <div class="box_events">
                                            <div class="iso_btn_minus opacity">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <input type="text" name="number_child" min="0"
                                                   value="{$txt_search_hotel_number_child}">
                                            <div class="iso_btn_plus">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Search button -->
                    </div>
                </div>
                <div class="col-12 col-lg-3 iso_search_btn_mobile">
                    <div class="iso_search_btn">
                        <button type="submit" class="iso_btn_search">
                            {$core->get_Lang('Check room availability')}
                        </button>
                    </div>
                </div>
            </div>
        {/if}
        <input type="hidden" name="search_hotel" value="search_hotel">
    </form>
</div>
<script>
    let txt_search_hotel_dates = "{$txt_search_hotel_dates}";

    let iso_rangedatepicker = {
        format: 'DD/MM/YYYY',
        separator: ' - ',
        applyLabel: "{$core->get_Lang('Áp dụng')}",
        cancelLabel: "{$core->get_Lang('Hủy')}",
        fromLabel: "{$core->get_Lang('Từ')}",
        toLabel: "{$core->get_Lang('Đến')}",
        customRangeLabel: "{$core->get_Lang('Tùy chọn')}",
        daysOfWeek: ["{$core->get_Lang('CN')}", "{$core->get_Lang('T2')}", "{$core->get_Lang('T3')}", "{$core->get_Lang('T4')}", "{$core->get_Lang('T5')}", "{$core->get_Lang('T6')}", "{$core->get_Lang('T7')}"],
        monthNames: ["{$core->get_Lang('Tháng 1')}", "{$core->get_Lang('Tháng 2')}", "{$core->get_Lang('Tháng 3')}", "{$core->get_Lang('Tháng 4')}", "{$core->get_Lang('Tháng 5')}", "{$core->get_Lang('Tháng 6')}", "{$core->get_Lang('Tháng 7')}", "{$core->get_Lang('Tháng 8')}", "{$core->get_Lang('Tháng 9')}", "{$core->get_Lang('Tháng 10')}", "{$core->get_Lang('Tháng 11')}", "{$core->get_Lang('Tháng 12')}"],
    };
</script>
{literal}
    <style>
        .hotel_hnv_detail2024_body #iso_form_hotel {
            padding: 0;
            justify-content: space-between;
            border-radius: 8px;
            background: #FFF;
            box-shadow: unset;
            min-height: auto;
        }

        .iso_box_search_detail {
            width: 100%;
        }

        .iso_box_search_detail .iso_search_btn {
            height: 100%;
        }

        .iso_box_search_detail .iso_form_floating {
            padding: 12px 16px 12px 3px !important;
        }

        .iso_box_search_detail .iso_btn_search {
            padding: 0 16px !important;
        }

        .iso_box_search_detail .iso_btn_search{
            background: var(--primary-18-babd, #18babd) !important;
            color: var(--chroma-ffffff, #FFFFFF) !important;
        }
        .iso_box_search_detail .iso_header_form_item{
            margin: 0 !important;
        }
        .hnv_hotel_detail_main_room_form .search-bar {
            padding: 0;
            box-shadow: unset;
            border-radius: unset;
        }
        @media screen and (max-width: 991px) {
            .iso_box_search_detail, .iso_box_search_detail .row {
                gap: 10px;
                margin: 0 !important;
            }
            .iso_search_btn_mobile {
                padding: 0 12px !important;
            }
            .iso_box_search_detail .iso_btn_search{
                padding: 5px 16px !important;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(function () {
                $(document)
                    .on('click', '.iso_btn_plus', function () {
                        let iso_input_item = $(this).parents('.iso_input_item');
                        let iso_input = iso_input_item.find('input');
                        let iso_btn_minus = iso_input_item.find('.iso_btn_minus');
                        let box_guests_rooms = $('.box_guests_rooms');
                        let txt = iso_input_item.attr('data-class');

                        let value = iso_input.val();
                        value = parseInt(value) + 1;
                        iso_input.val(value);
                        $(`.${txt}`).text(value);

                        let min_value = iso_input.attr('min');

                        if (value > parseInt(min_value)) {
                            iso_btn_minus.removeClass('opacity');
                        } else {
                            iso_btn_minus.addClass('opacity');
                        }
                    })
                    .on('click', '.iso_btn_minus', function () {
                        let iso_input_item = $(this).parents('.iso_input_item');
                        let iso_input = iso_input_item.find('input');
                        let box_guests_rooms = $('.box_guests_rooms');
                        let txt = iso_input_item.attr('data-class');

                        let value = iso_input.val();
                        value = parseInt(value) - 1;

                        let min_value = iso_input.attr('min');

                        if (value > parseInt(min_value)) {
                            $(this).removeClass('opacity');
                            iso_input.val(value);
                            $(`.${txt}`).text(value);
                        } else {
                            $(this).addClass('opacity');
                            iso_input.val(min_value);
                            $(`.${txt}`).text(min_value);
                        }
                    })
                    .on('click', '.box_guests_rooms, .box_icon_guest_room', function () {
                        $('.iso_box_input').slideToggle();
                    })
                    .on('click', function (e) {
                        var box_guests_rooms = $(".box_guests_rooms");
                        var box_icon_guest_room = $(".box_icon_guest_room");
                        var iso_box_input = $(".iso_box_input");
                        if (!box_guests_rooms.is(e.target) && box_guests_rooms.has(e.target).length === 0 && !box_icon_guest_room.is(e.target) && box_icon_guest_room.has(e.target).length === 0 && !iso_box_input.is(e.target) && iso_box_input.has(e.target).length === 0) {
                            $('.iso_box_input').slideUp();
                        }
                    })
                    .on('click', '.iso_icon_svg', function () {
                        $(this).parents('.iso_form_floating').find('input, select').show();
                    });

                if (LANG_ID == 'en') {
                    $('#search_hotel_dates').daterangepicker({
                        minDate: moment().add(1, 'days'),
                        endDate: moment().add(2, 'days'),
                        locale: {
                            format: 'DD/MM/YYYY'
                        }
                    });
                } else {
                    $('#search_hotel_dates').daterangepicker({
                        minDate: moment().add(1, 'days'),
                        endDate: moment().add(2, 'days'),
                        locale: iso_rangedatepicker
                    });
                }
                if (txt_search_hotel_dates) {
                    $('#search_hotel_dates').val(txt_search_hotel_dates);
                }
            });
        });
    </script>
{/literal}
