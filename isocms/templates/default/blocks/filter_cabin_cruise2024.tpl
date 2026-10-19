{assign var=max_adult value=$clsCruise->getMaxAdult($cruise_id)}
{assign var=max_child value=$clsCruise->getMaxChild($cruise_id)}
<section id="price" class="price_box section__box">
    <div class="box_filter_cabin">
        <h2 class="title_cruise_box_detail">
            {$core->get_Lang('Choose your itinerary')}
        </h2>
        <div class="filter_price">
            <form id="form__avaiable" class="form__avaiable" action="" method="post">
                <div class="form_filter">
                    <div class="box_input box_input_tour_guide">
                        <input type="text" name="duration_cruise" class="duration_cruise"
                               placeholder="{$core->get_Lang('Duration cruise')}" readonly>
                        <i class="fa-light fa-calendar-clock"></i>
                        {if $listDuration}
                            <div id="check_duration" class="check_duration">
                                <ul class="check_tour_guide--ul list_style_none">
                                    {$listDuration}
                                </ul>
                            </div>
                        {/if}
                    </div>
                    <div class="box_input box_input_departure">
                        <input type="text" name="departure_date" id="departure_date" class="departure_date"
                               value="{$format_time_now}" autocomplete="off" readonly>
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="box_input box_input_number_traveller">
                        <input type="text" name="number_travellers" class="number_travellers" id="pick_travellers"
                               placeholder="1 {$core->get_Lang('Adults')}, 1 {$core->get_Lang('Cabin')}" readonly>
                        <i class="fa-regular fa-users"></i>
                        <div id="check_cabin" class="check_cabin" style="display: none">
                            <div class="box_check_number_cabin" {if $oneTable.cruise_type eq '0'} style="display: none"{/if}>
                                <label>{$core->get_Lang('Cabin')}</label>
                                <select name="number_cabin" id="">
                                    {section name=i loop=10 step=1 start=0}
                                        <option value="{$smarty.section.i.iteration}">{$smarty.section.i.iteration}</option>
                                    {/section}
                                </select>
                            </div>
                            <div id="box_list_check_cabin" class="box_list_check_cabin">

                            </div>
                            <div class="box_set_check d-flex flex-wrap justify-content-end">
                                <button class="btn_setting btn_cancel_setting"
                                        type="button">{$core->get_Lang('Cancel')}</button>
                                <button class="btn_setting btn_confirm_setting"
                                        type="button">{$core->get_Lang('Confirm')}</button>
                            </div>
                        </div>
                    </div>
                    <div class="box_input box_input_book">
                        {if $clsCruise->checkShowPrice($cruise_id)}
                            <input type="hidden" name="cruise_id" id="cruise_id" value="{$cruise_id}"/>
                            <input type="hidden" id="number_adult" value="1"/>
                            <input type="hidden" id="number_cabin" value="1"/>
                            <input type="hidden" id="number_child" value="0"/>
                            <input type="hidden" id="str_number_adult" value="[&quot;1&quot;]"/>
                            <input type="hidden" id="str_number_child" value=""/>
                            <input type="hidden" id="str_bed_type"
                                   value="[&quot;{$lstGroupSize[0].cruise_property_id}&quot;]"/>
                            <input type="hidden" id="str_is_extra_bed" value=""/>
                            <input type="hidden" id="str_children" value=""/>
                            <input type="hidden" name="hidFind" value="hidCruises"/>
                            <input type="hidden" name="_LANG_ID" id="_LANG_ID" value="{$_LANG_ID}"/>
                            <button id="btn_check_cabin" class="btn_book_tour"
                                    type="button">{$core->get_Lang('Check')}</button>
                        {else}
                            <input type="hidden" name="number_adult" value="0">
                            <input type="hidden" name="cruise_id" value="{$cruise_id}">
                            <input type="hidden" name="ContactCruise" value="ContactCruise">
                            <button id="btn_check_cabin" class="btn_book_tour"
                                    type="submit">{$core->get_Lang('Contact')}</button>
                        {/if}

                    </div>
                </div>
            </form>

        </div>
    </div>
    <div id="TablePrice"></div>
</section>
<script>
    var $cruise_id = '{$cruise_id}';
    var Adults = '{$core->get_Lang("Adults")}';
    var Adult = '{$core->get_Lang("Adult")}';
    var Children = '{$core->get_Lang("Children")}';
    var Infants = '{$core->get_Lang("Infants")}';
    var Cabin = '{$core->get_Lang("Cabin")}';
    var getSelectAgeChild = `{$clsISO->getSelectAgeChild('',$min_age,$max_age)}`;
    var Warning = '{$core->get_Lang("Warning")}';
    var Input_data_is_invalid = '{$core->get_Lang("Input data is invalid")}';
    var Input_maximum_invalid = '{$core->get_Lang("The number of people exceeds the maximum capacity for a cabin, please select an additional")}';
    const img_loading = `<div class="text-center"><img src="{$URL_IMAGES}/icon/lazy_load_100.svg"></div>`;
</script>
<script src="{$URL_JS}/jquery.countdown.min.js?v={$upd_version}"></script>
<script src="{$URL_JS}/jquery-confirm.min.js?v={$upd_version}"></script>
{literal}
    <script>
        $(document).find("#page").click(function (e) {
            var container1 = $("#check_cabin");
            var container2 = $("#check_duration");
            if (!container1.is(e.target) && container1.has(e.target).length === 0 && !$('#pick_travellers').is(e.target)) {
                container1.hide();
            }
            if (!container2.is(e.target) && container2.has(e.target).length === 0 && !$('.duration_cruise').is(e.target)) {
                container2.hide();
            }
        });
        $(document).ready(function () {
            loadCabinCheck($cruise_id, 1);
            var box_item_check_cabin = $(".box_item_check_cabin").clone();
            var txt_cabin = $(".box_item_check_cabin").find(".txt_cabin").clone();

            $(document).on("change", "select[name='number_cabin']", function () {
                var number_cabin = parseInt($(this).val());
                var number_item_check_cabin = $("#box_list_check_cabin").find(".box_item_check_cabin").length;
                if (number_cabin > number_item_check_cabin) {
                    for (var i = parseInt(number_item_check_cabin); i < number_cabin; i++) {
                        console.log(i + 1);
                        loadCabinCheck($cruise_id, i + 1);
                    }
                } else if (number_cabin < number_item_check_cabin) {
                    $("#box_list_check_cabin").find(".box_item_check_cabin").each(function (index, elem) {
                        if (index >= number_cabin) {
                            $(elem).remove();
                        }
                    });
                }
            });
            $(document).on("change", ".check_box_itinerary", function () {
                var group_size = $(this).val();
                var max_adult = parseInt($(this).data('max_adult'));
                var max_child = parseInt($(this).data('max_child'));
                var is_extra_bed = parseInt($(this).data('is_extra_bed'));
                var box_item_check_cabin = $(this).closest(".box_item_check_cabin");
                var number_adult = parseInt(box_item_check_cabin.find("input[name='number_adult']").val());
                var number_child = parseInt(box_item_check_cabin.find("input[name='number_child']").val());
                if (number_adult >= max_adult) {
                    number_adult = max_adult;
                } else {
                    box_item_check_cabin.find("input[name='number_adult']").next().removeClass("disabled");
                }
                if (max_child == 0) {
                    box_item_check_cabin.find(".item_check_cabin_children").addClass('hidden');

                } else {
                    box_item_check_cabin.find(".item_check_cabin_children").removeClass('hidden');
                }

                if (is_extra_bed == 0) {
                    box_item_check_cabin.find(".item_check_extra_bed").addClass('hidden');
                    box_item_check_cabin.find(".item_check_extra_bed .is_extra_bed").prop('checked', false); // Unchecks it
                } else {
                    box_item_check_cabin.find(".item_check_extra_bed").removeClass('hidden');
                }
                if (number_child >= max_child) {
                    if (number_child > max_child) {
                        box_item_check_cabin.find('.box_group_child .item_group_size').each(function (index, element) {
                            if (index >= max_child) {
                                $(element).remove();
                            }
                        });
                    }
                    number_child = max_child;
                } else {
                    box_item_check_cabin.find("input[name='number_child']").next().removeClass("disabled");
                }
                box_item_check_cabin.find("input[name='number_adult']").attr('max-number', max_adult).val(number_adult);
                box_item_check_cabin.find("input[name='number_child']").attr('max-number', max_child).val(number_child);
            });

            $(document).on("click", ".btn_confirm_setting", function () {
                var check = 1;
                $("#check_cabin").find("select.slt_item_age_child").each(function (index, elm) {
                    if ($(elm).val() == '') {
                        $(elm).addClass("error");
                        check = 0;
                    } else {
                        $(elm).removeClass("error");
                    }
                });

                if (!check) {
                    return false;
                }
                getNumberPerson();
                $("#check_cabin").hide();
                loadPriceCabin();
            });
            $(document).on("click", ".btn_cancel_setting", function () {
                $("#box_list_check_cabin").html("");
                loadCabinCheck($cruise_id, 1);
                $("#check_cabin").hide();
                $("#check_cabin").find("select[name='number_cabin']").val(1);
            });

            $("input[name='duration_cruise']").val($("input[name='cruise_itinerary_id']:checked").data('title'));
            $('input[name="number_travellers"]').click(function () {
                $("#check_cabin").toggle();
                $("#check_duration").hide();
            });
            if ($("input[name='cruise_itinerary_id']").length > 1) {
                $('input[name="duration_cruise"]').click(function () {
                    $("#check_duration").toggle();
                    $("#check_cabin").hide();
                });
            }

            $('input[name="cruise_itinerary_id"]').click(function () {
                var title = $(this).data('title');
                $('input[name="duration_cruise"]').val(title);
            });

            $('.number_adults').on('focusout', function () {
                var value = $(this).val();
                if (parseInt(value) < 1 || value == '') {
                    $(this).val(1);
                }
                getNumberPerson();
            });
            $('.number_child').on('focusout', function () {
                var value = $(this).val();
                if (parseInt(value) < 0 || value == '') {
                    value = 0;
                    $(this).val(0);
                }
                getNumberPerson();
            });
            $(document).on('click', '.upNum.disabled', function () {
                $.alert({
                    title: Warning,
                    type: 'red',
                    content: Input_maximum_invalid,
                });
            });
            $(document).on('click', '.upNum:not(.disabled)', function () {
                var inputTraveller = $(this).closest(".right__inputTraveller").find("input.input_number");
                var number_person = parseInt(inputTraveller.val());
                var max_number = parseInt(inputTraveller.attr('max-number'));
                var _type = $(this).attr('_type');
                number_person = number_person + 1;
                if (number_person >= max_number) {
                    $(this).addClass('disabled');
                    number_person = max_number;
                }
                $(this).closest(".right__inputTraveller").find(".unNum").removeClass("disabled");
                inputTraveller.val(number_person);
                if (_type == 'number_child') {
                    var $number_child = $(this).closest(".item_check_cabin").find('.box_group_child .item_group_size').length;
                    for (var i = $number_child; i < number_person; i++) {
                        $(this).closest(".item_check_cabin").find('.box_group_child').append(`<div class="item_group_size">` + getSelectAgeChild + `</div>`);
                    }
                }
                return false;
            });
            $(document).on('click', '.unNum:not(.disabled)', function () {
                var inputTraveller = $(this).closest(".right__inputTraveller").find("input.input_number");
                var number_person = parseInt(inputTraveller.val());
                var min_number = parseInt(inputTraveller.attr('min-number'));
                var _type = $(this).attr('_type');
                number_person = number_person - 1;
                if (number_person <= min_number) {
                    $(this).addClass('disabled');
                    number_person = min_number;
                }
                $(this).closest(".right__inputTraveller").find(".upNum").removeClass("disabled");
                inputTraveller.val(number_person);
                if (_type == 'number_child') {
                    $(this).closest(".item_check_cabin").find('.box_group_child .item_group_size').each(function (index, element) {
                        if (index >= number_person) {
                            $(element).remove();
                        }
                    });
                }
                return false;
            });

            $('#departure_date').datepicker({
                dateFormat: 'DD, dd/mm/yy',
                minDate: "+1d",
                maxDate: "+1Y",
                prevText: "Trước",
                nextText: "Sau",
                currentText: "Hôm nay",
                firstDay: 1,
                monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"]
            });
            var departure_date = $('input[name=departure_date]').val();
            var cruise_itinerary_id = $('input[name=cruise_itinerary_id]:checked').val();
            var number_adult = $('#number_adult').val();
            var cruise_property_id = $('select[name=cruise_property_id]').val();
            loadPriceCabin();
            $('#btn_check_cabin').click(function () {
                loadPriceCabin();
            });

            $(document).on('click', '.btn_book_cabin,.btn_contact_cabin', function (ev) {
                ev.preventDefault();
                var _this = $(this);
                var parent = $(this).closest(".box_book_cabin");
                var cruise_id = parent.find('input[name="cruise_id"]').val();
                var departure_date = parent.find('input[name="departure_date"]').val();
                var cruise_itinerary_id = parent.find('input[name="cruise_itinerary_id"]').val();
                var cruise_cabin_id = parent.find('input[name="cruise_cabin_id"]').val();
                var number_adult = parent.find('input[name="number_adult"]').val();
                var number_child = parent.find('input[name="number_child"]').val();
                var number_cabin = parent.find('input[name="number_cabin"]').val();
                var is_extra_bed = parent.find('.is_extra_bed').val();


                var bed_type = parent.find('input[name="bed_type"]').val();
                var children = parent.find('input[name="children"]').val();
                var str_total_price = parent.find('input[name="str_total_price"]').val();
                var str_compare_price = parent.find('input[name="str_compare_price"]').val();
                var discount_type = parent.find('input[name="discount_type"]').val();
                var discount_value = parent.find('input[name="discount_value"]').val();
                var check_contact_total = parent.find('input[name="check_contact_total"]').val();
                var adata = {
                    'cruise_id': cruise_id,
                    'departure_date': departure_date,
                    'cruise_itinerary_id': cruise_itinerary_id,
                    'cruise_cabin_id': cruise_cabin_id,
                    'number_adult': number_adult,
                    'number_child': number_child,
                    'number_cabin': number_cabin,
                    'is_extra_bed': is_extra_bed,
                    'bed_type': bed_type,
                    'children': children,
                    'str_total_price': str_total_price,
                    'str_compare_price': str_compare_price,
                    'str_compare_price': str_compare_price,
                    'discount_type': discount_type,
                    'discount_value': discount_value,
                    'check_contact_total': check_contact_total,
                    'type': 'BOOKSERVICES',

                };
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajChooseCabinCruise&lang=' + LANG_ID,
                    data: adata,
                    dataType: 'html',
                    success: function (link) {
                        if (link != '') {
                            location.href = link;
                        }
                    }
                });
            });

        });

        function loadPriceCabin() {
            $('#TablePrice').html(img_loading);
            var $departure_date = $('input[name=departure_date]').val();
            var $number_adult = $('#number_adult').val();
            var $number_child = $('#number_child').val();
            var $number_cabin = $('#number_cabin').val();
            var $str_number_adult = $('#str_number_adult').val();
            var $str_number_child = $('#str_number_child').val();
            var $str_bed_type = $('#str_bed_type').val();
            var $str_is_extra_bed = $('#str_is_extra_bed').val();
            var $str_children = $('#str_children').val();
            var $cruise_itinerary_id = $('input[name=cruise_itinerary_id]:checked').val();
            var $_adata = {
                'cruise_id': $cruise_id,
                'departure_date': $departure_date,
                'number_adult': $number_adult,
                'number_child': $number_child,
                'number_cabin': $number_cabin,
                'str_number_adult': $str_number_adult,
                'str_number_child': $str_number_child,
                'str_bed_type': $str_bed_type,
                'str_is_extra_bed': $str_is_extra_bed,
                'str_children': $str_children,
                'cruise_itinerary_id': $cruise_itinerary_id
            };
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=cruise&act=loadPriceCabin&act2=&lang=' + LANG_ID,
                data: $_adata,
                dataType: 'html',
                success: function (html) {
                    $('#hiddenCheckRate').remove();
                    $('#TablePrice').html(html);
                }
            });
        }

        function loadCabinCheck($cruise_id, $index_cabin) {
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=cruise&act=ajaxLoadCabinCheck&lang=' + LANG_ID,
                data: {'cruise_id': $cruise_id, 'index_cabin': $index_cabin},
                dataType: 'html',
                async: false,
                success: function (html) {
                    $("#box_list_check_cabin").append(html);
                }
            });
        }

        function getNumberPerson() {
            var $totalAdult = 0, $totalChild = 0;
            var number_adult = new Array(),
                number_child = new Array(),
                bed_type = new Array(),
                children = new Array(),
                is_extra_bed = new Array();

            $("#box_list_check_cabin").find(".box_item_check_cabin").each(function (index, elm) {
                $totalAdult += parseInt($(elm).find(".number_adults").val());
                $totalChild += parseInt($(elm).find(".number_child").val());

                bed_type.push($(elm).find(".check_box_itinerary:checked").val());
                is_extra_bed.push($(elm).find(".is_extra_bed:checked").val());
                number_adult.push($(elm).find(".number_adults").val());
                number_child.push($(elm).find(".number_child").val());
                var arr_chidren = [];
                $(elm).find(".slt_item_age_child").each(function (i, e) {
                    arr_chidren.push($(e).val());
                });
                children.push(arr_chidren.toString());
            });

            var $totalCabin = $("#check_cabin").find("select[name='number_cabin']").val();
            $totalCabin = parseInt($totalCabin);
            $("#number_adult").val($totalAdult);
            $("#number_child").val($totalChild);
            $("#number_cabin").val($totalCabin);

            $("#str_number_adult").val(JSON.stringify(number_adult));
            if ($totalChild > 0) {
                $("#str_number_child").val(JSON.stringify(number_child));
                $("#str_children").val(JSON.stringify(children));
            } else {
                $("#str_number_child,#str_children").val("");
            }
            $("#str_bed_type").val(JSON.stringify(bed_type));
            $("#str_is_extra_bed").val(JSON.stringify(is_extra_bed));

            if ($totalAdult > 1) {
                var value = $totalAdult + ' ' + Adults;
            } else {
                var value = $totalAdult + ' ' + Adult;
            }

            if ($totalChild > 0) {
                value += ', ' + $totalChild + ' ' + Children;
            }
            if ($totalCabin > 0) {
                value += ', ' + $totalCabin + ' ' + Cabin;
            }
            $('#pick_travellers').val(value);
        }
    </script>
{/literal}
