<section class="box_form_banner">
    <div class="container">
        <div class="wrap_form_banner">
            <form class="form_banner d-flex" action="" method="post">
                <div class="search_hotel">
                    <input type="text" name="key" value="{$keyword}" class="form-control"
                           placeholder="{$core->get_Lang('Search for accommodation')}">
                </div>
                <div class="check_in_date">
                    <label for="check_in_date_id">{$core->get_Lang('Check in')}</label>
                    <input type="text" id="check_in_date_id" name="check_in_date" class="form-control"
                           {if empty($check_in_date)}value="{$format_time_now}" {else} value="{$check_in_date}"{/if}>
                </div>
                <div class="box_departure_date">
                    <label for="departure_date_id">{$core->get_Lang('Check out')}</label>
                    <input type="text" id="departure_date_id" class="form-control" name="check_out_date"
                           {if empty($check_out_date)}value="{$format_time_tomorrow}" {else}
                           value="{$check_out_date}"{/if}>
                </div>
                <div class="number_travellers relative">
                    <label for="pick_travellers">{$core->get_Lang('Quantity')}</label>
                    <input type="text" readonly class="form-control pick_travellers" id="pick_travellers"
                           value="{$core->get_Lang('Adults')} x {$number_adults}, Children x {$number_child}">
                    <div id="check_number_travellers" class="check_number_travellers" style="display:none;">
                        <ul class="check_number_travellers--ul list_style_none">
                            <li class="inputTraveller" id="li_adult" data-tour_property_id="1">
                                <label>{$core->get_Lang('Adults')}</label>
                                <div class="right__inputTraveller">
                                    <a class="unNum text_main disabled" _type="number_adults" traveler_type_id="1"
                                       href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                    <input min-number="1" max-number="5" type="number" _type="number_adults"
                                           class="number_adults input_number find_select" tour_visitor_type_id="1"
                                           name="number_adults" id="national_visitor1" value="{$number_adults}"
                                           readonly/>
                                    <a class="upNum text_main" _type="number_adults" traveler_type_id="1"
                                       href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            </li>
                            <li class="inputTraveller">
                                <label>{$core->get_Lang('Children')}</label>
                                <div class="right__inputTraveller">
                                    <a class="unNum text_main disabled" _type="number_child" traveler_type_id="2 "
                                       href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                    <input min-number="0" max-number="5" type="number" _type="number_child"
                                           class="number_child input_number find_select" tour_visitor_type_id="2"
                                           name="number_child" id="national_visitor2" value="{$number_child}" readonly/>
                                    <a class="upNum text_main" _type="number_child" traveler_type_id="2"
                                       href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box_button_search">
                    <input type="hidden" value="searchHotel" name="hid"/>
                    <button class="btn_search btn_main" type="submit">{$core->get_Lang('Search')}</button>
                </div>

            </form>
        </div>
    </div>
</section>

<script type="text/javascript">
    var Input_data_is_invalid = '{$core->get_Lang("Input data is invalid")}';
    var Adults = '{$core->get_Lang("Adults")}';
    var Children = '{$core->get_Lang("Children")}';
    var Infants = '{$core->get_Lang("Infants")}';
    var Departure_date_invalid = '{$core->get_Lang("Departure date is invalid")}';
    var Please_choose_departure_date = '{$core->get_Lang("Please choose departure date")}';
    var Warning = '{$core->get_Lang("Warning")}';
</script>
{literal}
    <script>
        $(function () {
            $('input[readonly]').on('focus', function (ev) {
                $(this).trigger('blur');
            });
            $("#check_in_date_id").datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: new Date(),
                maxDate: "+1Y",
                prevText: "Trước",
                nextText: "Sau",
                currentText: "Hôm nay",
                firstDay: 1,
                monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            });
            $('#departure_date_id').datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: "+1d",
                maxDate: "+1Y",
                prevText: "Trước",
                nextText: "Sau",
                currentText: "Hôm nay",
                firstDay: 1,
                monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            });

            $('#pick_travellers').click(function () {
                var $_this = $(this);
                if ($_this.hasClass('open')) {
                    $('#check_number_travellers').hide();
                    $_this.closest('.number_travellers').removeClass('open');
                    $_this.removeClass('open');
                } else {
                    $('#check_number_travellers').show();
                    $_this.closest('.number_travellers').addClass('open');
                    $_this.addClass('open');
                }
            });
        });
        $(document).mouseup(function (e) {
            var container = $("#check_number_travellers");
            var jconfirm_box = $(".jconfirm-open");
            var pick_travellers = $("#pick_travellers");
            if (!container.is(e.target) && container.has(e.target).length === 0 && !jconfirm_box.is(e.target) && jconfirm_box.has(e.target).length === 0 && !pick_travellers.is(e.target) && pick_travellers.has(e.target).length === 0) {
                container.hide();
                $('.number_travellers').removeClass('open');
                $('.pick_travellers').removeClass('open');
            }
        });

        $(document).on('click', '.upNum', function () {
            var number_person = $(this).val();
            var departure_date = $("input[name=departure_date]").val();
            var traveler_type_id = $(this).attr('traveler_type_id');
            var val = parseInt($("#national_visitor" + traveler_type_id).val());
            var max_number = parseInt($("#national_visitor" + traveler_type_id).attr('max-number'));
            var _type = $(this).attr('_type');
            val = val + 1;
            /*if (val >= max_number) {
                $(this).addClass('disabled');
                val = max_number;
            }*/
            $(this).closest(".right__inputTraveller").find(".unNum").removeClass("disabled");
            $("#national_visitor" + traveler_type_id).val(val);
            $('#' + _type).val(val);
            if (_type == 'number_adults') {
                getNumberPerson();
            }
            if (_type == 'number_child') {
                getNumberPerson();
            }
            if (_type == 'number_room') {
                var value = $('input[name="number_room"]').val();
                $('input[name="number_room"]').val(parseInt(value) + 1);
            }
            getNumberPerson();
            return false;
        });
        $(document).on('click', '.unNum:not(.disabled)', function () {
            var number_person = $(this).val();
            var departure_date = $("input[name=departure_date]").val();
            var traveler_type_id = $(this).attr('traveler_type_id');
            var val = parseInt($("#national_visitor" + traveler_type_id).val());
            var min_number = parseInt($("#national_visitor" + traveler_type_id).attr('min-number'));
            var _type = $(this).attr('_type');
            val = val - 1;
            if (val <= min_number) {
                /*$.alert({
                    title: Warning,
                    type: 'red',
                    typeAnimated: true,
                    content: Input_data_is_invalid,
                });*/
                $(this).addClass('disabled');
                val = min_number;
            }
            $(this).closest(".right__inputTraveller").find(".upNum").removeClass("disabled");
            $("#national_visitor" + traveler_type_id).val(val);
            $('#' + _type).val(val);
            if (_type == 'number_adults') {
                getNumberPerson();
            }

            if (_type == 'number_child') {
                getNumberPerson();
            }

            if (_type == 'number_room') {
                var value = $('input[name="number_room"]').val();
                if (parseInt(value) > 0) {
                    $('input[name="number_room"]').val(parseInt(value) - 1);
                }
            }
            getNumberPerson();
            return false;
        });

        function getNumberPerson() {
            var $totalAdult = 0;
            $('.number_adults').each(function () {
                $totalAdult += parseInt($(this).val());
            });
            var $totalChild = 0;
            $('.number_child').each(function () {
                $totalChild += parseInt($(this).val());
            });
            var $totalInfants = 0;
            $('.number_infants').each(function () {
                $totalInfants += parseInt($(this).val());
            });
            if ($totalChild == 0 && $totalInfants == 0) {
                $('#pick_travellers').val(Adults + ' x ' + $totalAdult);
            } else if ($totalChild == 0 && $totalInfants != 0) {
                $('#pick_travellers').val(Adults + ' x ' + $totalAdult + ', ' + Infants + ' x ' + $totalInfants);
            } else if ($totalChild != 0 && $totalInfants == 0) {
                $('#pick_travellers').val(Adults + ' x ' + $totalAdult + ', ' + Children + ' x ' + $totalChild);
            } else {
                $('#pick_travellers').val(Adults + ' x ' + $totalAdult + ', ' + Children + ' x ' + $totalChild + ', ' + Infants + ' x ' + $totalInfants);
            }
        }

        $(document).on("change", ".input_number", function () {
            var number_person = $(this).val();
            var max_person = $(this).attr('max-number');
            var departure_date = $("input[name=departure_date]").val();
            var tour_visitor_type_id = $(this).attr('tour_visitor_type_id');
            var _type = $(this).attr('_type');
            if (!isNaN(parseInt(number_person))) {
                if (parseInt(number_person) > 0 && parseInt(number_person) <= max_person) {
                    $(this).val(parseInt(number_person));

                    if ($(this).hasClass('number_adults')) {
                        getNumberPerson();
                    }

                    $(this).closest(".right__inputTraveller").find(".unNum").removeClass("disabled");
                } else {
                    if (_type == 'number_adults') {
                        $(this).val(1);
                    } else {
                        $(this).val(0);
                    }

                    getNumberPerson();
                    $(this).closest(".right__inputTraveller").find(".unNum").addClass("disabled");
                }
            } else {
                $(this).val(1);
                $(this).closest(".right__inputTraveller").find(".unNum").addClass("disabled");
            }
            $('#' + _type).val(number_person);
            getNumberPerson();
        });
    </script>
{/literal}