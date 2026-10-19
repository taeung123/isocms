<form action="" class="simple_form search" id="filters_form2" method="post">
    <input type="hidden" name="search_des" value="search_des"/>
    <input type="hidden" name="min_duration" id="duration1" value="{$min_duration_search}">
    <input type="hidden" name="max_duration" id="duration2" value="{$max_duration_search}">
    <input type="hidden" name="min_price" id="price1" value="{$min_price_search}">
    <input type="hidden" name="max_price" id="price2" value="{$max_price_search}">
    <input type="hidden" name="country_id" id="country_id2" value="{$country_id}">
    <div class="findBox mt0 pdbt30">
        <h3 class="title">{$core->get_Lang('Tour length')}</h3>
        <div id="duration_0" class="inline-block text-left"></div>
        <span> -</span>
        <div id="duration_1" class="inline-block text-right"></div>
        <div id="slider-range2" class="mb10"></div>
    </div>
    <div class="findBox">
        <h3 class="title">{$core->get_Lang('Price')}</h3>
        <div id="price_0" class="inline-block text-left"></div>
        <span> -</span>
        <div id="price_1" class="inline-block text-right"></div>
        <div id="slider-price2" class="mb10"></div>
    </div>
    {if $lstCountryTourOutbound && $act ne 'place_inbound'}
        <div class="findBox">
            <h3 class="title">{$core->get_Lang('Choose country')}</h3>
            <ul class="filter tour_types common_wrapper_details checkBlock">
                {section name=i loop=$lstCountryTourOutbound}
                    {assign var=country__id value=$lstCountryTourOutbound[i].country_id}
                    {if $country__id ne 4}
                        <li>
                            <input id="c{$country__id}" class="typeSearch" name="country_filter_id[]"
                                   value="{$country__id}" type="checkbox"
                                   {if $clsISO->checkInArray($country_filter_id,$country__id) || $clsISO->checkInArray($country_id,$country__id)}checked{/if}/>
                            <label class="twoFilter"
                                   for="c{$country__id}">{$clsCountryEx->getTitle($lstCountryTourOutbound[i].country_id,$lstCountryTourOutbound[i])}</label>
                        </li>
                    {/if}
                {/section}
            </ul>
            <span class="readmore">{$core->get_Lang('More')}</span></div>
    {/if}
    {if $lstRegionTourByCountry}
        <div class="findBoxCity">
            <h3 class="title">{$core->get_Lang('City')}</h3>
            {section name=i loop=$lstRegionTourByCountry}
                <div class="findBox">
                    {assign var=TitleRegion value=$clsRegion->getTitle($lstRegionTourByCountry[i].region_id,$lstRegionTourByCountry[i])}
                    {assign var=listCityTourByRegion value=$lstRegionTourByCountry[i].listCityTourByRegion}
                    {if $listCityTourByRegion}
                        <h4 class="title2">{$TitleRegion}</h4>
                        <ul class="filter tour_types common_wrapper_details checkBlock">
                            {section name=j loop=$listCityTourByRegion}
                                <li>
                                    <input id="a{$listCityTourByRegion[j].city_id}" class="typeSearch"
                                           name="city_filter_id[]" value="{$listCityTourByRegion[j].city_id}"
                                           type="checkbox"
                                           {if $clsISO->checkInArray($city_filter_id,$listCityTourByRegion[j].city_id) || $clsISO->checkInArray($city_id,$listCityTourByRegion[j].city_id)}checked{/if}/>
                                    <label class="twoFilter"
                                           for="a{$listCityTourByRegion[i].city_id}">{$clsCity->getTitle($listCityTourByRegion[j].city_id,$listCityTourByRegion[j])}</label>
                                </li>
                            {/section}
                        </ul>
                        <span class="readmore">{$core->get_Lang('More')}</span>
                    {/if}
                </div>
            {/section}
        </div>
    {elseif $lstCityTour}
        <div class="findBox">
            <h3 class="title">{$core->get_Lang('City')}</h3>
            <ul class="filter tour_types common_wrapper_details checkBlock">
                {section name=j loop=$lstCityTour}
                    <li>
                        <input id="a{$lstCityTour[j].city_id}" class="typeSearch" name="city_filter_id[]"
                               value="{$lstCityTour[j].city_id}" type="checkbox"
                               {if $clsISO->checkInArray($city_filter_id,$lstCityTour[j].city_id)}checked{/if}/>
                        <label class="twoFilter"
                               for="a{$lstCityTour[i].city_id}">{$clsCity->getTitle($lstCityTour[j].city_id,$lstCityTour[j])}</label>
                    </li>
                {/section}
            </ul>
            <span class="readmore">{$core->get_Lang('More')}</span>
        </div>
    {/if}
    {if $lstDeparturePoint}
        <div class="findBox border_0">
            <h3 class="title">{$core->get_Lang('Departure')}</h3>
            <ul class="filter tour_types common_wrapper_details checkBlock">
                {section name=i loop=$lstDeparturePoint}
                    <li>
                        <input id="d{$lstDeparturePoint[i].city_id}" class="typeSearch" name="departure_point_id[]"
                               value="{$lstDeparturePoint[i].city_id}" type="checkbox"
                               {if $clsISO->checkInArray($departure_point_id,$lstDeparturePoint[i].city_id)}checked{/if} />
                        <label class="twoFilter"
                               for="d{$lstDeparturePoint[i].city_id}">{$clsCity->getTitle($lstDeparturePoint[i].city_id,$lstDeparturePoint[i])}</label>
                    </li>
                {/section}
            </ul>
            <span class="readmore">{$core->get_Lang('More')}</span>
        </div>
    {/if}
    {if $lstCatTour && $act=='searchtour'}
        <div class="findBox border_0">
            <h3 class="title">{$core->get_Lang('Travel styles')}</h3>
            <ul class="filter tour_types common_wrapper_details checkBlock">
                {section name=i loop=$lstCatTour}
                    {if $clsTour->countByCat($lstCatTour[i].tourcat_id)}
                        <li>
                            <input id="t{$lstCatTour[i].tourcat_id}" class="typeSearch" name="tourcat_id[]"
                                   value="{$lstCatTour[i].tourcat_id}" type="checkbox"
                                   {if $clsISO->checkInArray($cat_id,$lstCatTour[i].tourcat_id)}checked{/if} />
                            <label class="twoFilter" for="t{$lstCatTour[i].tourcat_id}">{$lstCatTour[i].title}</label>
                        </li>
                    {/if}
                {/section}
            </ul>
            <span class="readmore">{$core->get_Lang('More')}</span>
        </div>
    {/if}
    {literal}
    <script>
        $(function () {
            /*$('.common_wrapper_details').each(function(){
                var $_this = $(this);
                if($_this.height()>210){
                    $_this.css("height","210px");
                    $_this.closest(".findBox").find(".readmore").show();
                }else{
                    $_this.closest(".findBox").find(".readmore").hide();
                }
            });*/
            $('.common_wrapper_details').each(function (index, elm) {
                var $_this = $(this);
                var number_li = $(elm).find("li").length;
                if (number_li > 5) {
                    $(elm).addClass("short");
                    $(elm).closest(".findBox").find(".readmore").show();
                } else {
                    $(elm).closest(".findBox").find(".readmore").hide();
                }
            });
            $(document).on("click", ".findBox .readmore", function () {
                var $_this = $(this);
                if (!$_this.hasClass("less")) {
                    $_this.addClass("less");
                    $_this.closest(".findBox").find(".common_wrapper_details").removeClass("short");
                    $_this.html('{/literal}{$core->get_Lang("Less")}{literal}');
                } else {
                    $_this.removeClass("less");
                    $_this.closest(".findBox").find(".common_wrapper_details").addClass("short");
                    $_this.html('{/literal}{$core->get_Lang("More")}{literal}');
                }
            });
            /*$(document).on("click",".findBox .readmore",function(){
                var $_this = $(this);
                if(!$_this.hasClass("less")){
                    $_this.addClass("less");
                    $_this.closest(".findBox").find(".common_wrapper_details").css("height","auto");
                    $_this.html('{/literal}{$core->get_Lang("Less")}{literal}');
            }
            else{
                $_this.removeClass("less");
                $_this.closest(".findBox").find(".common_wrapper_details").css("height","210px");	
                $_this.html('{/literal}{$core->get_Lang("More")}{literal}');	
            }
        });*/
        });
    </script>
    {/literal}
</form>
<script>
    var curency = '{$clsISO->getShortRate()}';
    var đ = '{$core->get_Lang("đ")}';
    var tourcat_id = '{$tourcat_id}';
    var city_id = '{$city_id}';
    var country_id = '{$country_id}';
    var min_duration_value = '{$min_duration_value}';
    var max_duration_value = '{$max_duration_value}';
    var min_duration_search = '{$min_duration_search}';
    var max_duration_search = '{$max_duration_search}';
    var max_price_value = '{$max_price_value}';
    var min_price_value = '{$min_price_value}';
    var min_price_search = '{$min_price_search}';
    var max_price_search = '{$max_price_search}';
    var txtday = '{$core->get_Lang("day")}';
    var txtdays = '{$core->get_Lang("days")}';
</script>
{literal}
    <script>
        $(function () {
            $("#slider-range2").slider({
                range: true,
                min: parseInt(min_duration_value),
                max: parseInt(max_duration_value),
                values: [min_duration_search, max_duration_search],
                slide: function (event, ui) {

                    if (ui.values[0] > 1) {
                        $("#duration_0").html(ui.values[0] + ' ' + txtdays);
                    } else {
                        $("#duration_0").html(ui.values[0] + ' ' + txtday);
                    }
                    if (ui.values[1] > 1) {
                        $("#duration_1").html(ui.values[1] + ' ' + txtdays);
                    } else {
                        $("#duration_1").html(ui.values[1] + ' ' + txtday);
                    }
                    $("#duration1").val(ui.values[0]);
                    $("#duration2").val(ui.values[1]);
                    $('#filters_form2').submit();
                }
            });
            var arr_value = $("#slider-range2").slider("values");
            if (arr_value[0] > 1) {
                $("#duration_0").html(arr_value[0] + ' ' + txtdays);
            } else {
                $("#duration_0").html(arr_value[0] + ' ' + txtday);
            }
            if (arr_value[1] > 1) {
                $("#duration_1").html(arr_value[1] + ' ' + txtdays);
            } else {
                $("#duration_1").html(arr_value[1] + ' ' + txtday);
            }

        });
        $(function () {
            $("#slider-price2").slider({
                range: true,
                min: parseInt(min_price_value),
                max: parseInt(max_price_value),
                values: [min_price_search, max_price_search],
                slide: function (event, ui) {
                    $("#price_0").html(ui.values[0] + ' ' + curency);
                    $("#price_1").html(ui.values[1] + ' ' + curency);
                    $("#price1").val(ui.values[0]);
                    $("#price2").val(ui.values[1]);
                    $('#filters_form2').submit();
                }
            });
            document.getElementById("price_0").innerHTML = format_price(min_price_search);
            document.getElementById("price_1").innerHTML = format_price(max_price_search);
        })

        function format_price(n) {
            return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + curency
        }
    </script>
{/literal}
{literal}
    <style>
        .readMoreClass {
            position: relative
        }

        .readMoreClass .section_expander {
            position: absolute;
            width: 50px;
            bottom: 0;
            right: 0;
            color: #f16f30
        }

        .common_wrapper_details {
            overflow: hidden
        }

        @media (max-width: 991px) {
            .modal_quick_center {
                top: 0;
                width: 100%;
                text-align: left
            }

            .findTripDestination.display_des {
                max-height: 100%;
                overflow-y: hidden
            }

            #filter_search.modal, #modalQuickSearch.modal {
                padding-right: 0
            }

            .findTripDestination ul li a {
                font-size: 22px;
                color: #1c1c1c;
                font-weight: 500;
                margin-bottom: 20px;
                display: block;
            }

            .findTripDestination ul li {
                list-style: none;
                margin-bottom: 30px;
            }

            ul#radio li label {
                font-weight: 400
            }

            .modal-content {
                border-radius: 0;
                border: 0
            }
        }
    </style>
{/literal}
{literal}
    <script>
        $('#filters_form2 .typeSearch').change(function () {
            $(this).closest('form').submit();
        });
    </script>
{/literal} 