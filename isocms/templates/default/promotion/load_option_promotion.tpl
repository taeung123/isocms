{if $type_op eq 'tour'}
    <div class="box_option_find_box">
        <div class="box_duration_find_box">
            <div class="findBox mt0 pdbt30">
                <h3>{$core->get_Lang('DURATION')}</h3>
                <div id="duration_0" class="inline-block w50 text-left">{$core->get_Lang('0 day')}</div>
                <div id="duration_1" class="inline-block w50 text-right"></div>
                <input type="hidden" name="min_duration" id="duration1" value="{$min_duration_value}">
                <input type="hidden" name="max_duration" id="duration2" value="{$max_duration_value}">
                <div id="slider-range"></div>
            </div>
        </div>
        <div class="box_country_find_box">
            <div class="findBox">
                <h3>{$core->get_Lang('CHOOSE COUNTRY')}</h3>
                <ul class="filter tour_types common_wrapper_details checkBlock">
                    {section name=i loop=$lstCountryEx}
                        {if $clsTour->countTourGolobal($lstCountryEx[i].country_id, 0, 0) gt 0}
                            <li>
                                <div class="cntr">
                                    <label for="c{$lstCountryEx[i].country_id}" class="label-cbx">
                                        <input  class="invisible" id="c{$lstCountryEx[i].country_id}" type="checkbox"  class="typeSearch" name="country_id[]" value="{$lstCountryEx[i].country_id}"  {if $clsISO->checkInArray($country_id,$lstCountryEx[i].country_id)}checked="checked"{/if}>
                                        <div class="checkbox">
                                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                <polyline points="4 11 8 15 16 6"></polyline>
                                            </svg>
                                        </div>
                                        <span>{$lstCountryEx[i].title}</span>
                                    </label>
                                </div>

                            </li>
                        {/if}
                    {/section}
                </ul>
            </div>
        </div>
        <div class="box_country_travel_style">
            <div class="findBox">
                <h3>{$core->get_Lang('TRAVEL STYLE')}</h3>
                <ul class="filter common_wrapper_details tour_types checkBlock" >
                    {if $show eq 'Category' or $show eq 'CatCountry'}
                        {assign var=cat__ID value=$cat_id}
                    {else}
                        {assign var=cat__ID value=$cat_ID}
                    {/if}

                    {section name=i loop=$lstCatTour}

                        <li>
                            <div class="cntr">
                                <label for="t{$lstCatTour[i].tourcat_id}" class="label-cbx">
                                    <input  class="invisible" id="t{$lstCatTour[i].tourcat_id}" type="checkbox"  class="typeSearch" name="cat_ID[]" value="{$lstCatTour[i].tourcat_id}" {if $clsISO->checkInArray($cat__ID,$lstCatTour[i].tourcat_id)}checked="checked"{/if}>
                                    <div class="checkbox">
                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                            <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                            <polyline points="4 11 8 15 16 6"></polyline>
                                        </svg>
                                    </div>
                                    <span>{$lstCatTour[i].title}</span>
                                </label>
                            </div>
                        </li>
                    {/section}
                </ul>
            </div>
        </div>
        <div class="box_country_travel_acti">
            <div class="findBox border_0">
                <h3>{$core->get_Lang('TRAVEL ACTIVITIES')}</h3>
                <ul class="filter common_wrapper_details tour_types checkBlock" >
                    {section name=i loop=$lstActivities}
                        <li>
                            <div class="cntr">
                                <label for="a{$lstActivities[i].activities_id}" class="label-cbx">
                                    <input  class="invisible" id="a{$lstActivities[i].activities_id}" type="checkbox"  class="typeSearch" name="cat_ID[]" value="{$lstActivities[i].activities_id}" {if $clsISO->checkInArray($activities_id,$lstActivities[i].activities_id)}checked="checked"{/if}>
                                    <div class="checkbox">
                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                            <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                            <polyline points="4 11 8 15 16 6"></polyline>
                                        </svg>
                                    </div>
                                    <span>{$lstActivities[i].title}</span>
                                </label>
                            </div>
                        </li>
                    {/section}
                </ul>
            </div>
        </div>
        {literal}
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    $(function() {
                        loadPromotion();
                        $( "#slider-range" ).slider({
                            range: "min",
                            value: parseInt(max_duration_value),
                            min: parseInt(min_duration_value),
                            max: parseInt(max_duration_value),
                            // values: [min_duration_search, max_duration_search],
                            slide: function( event, ui ) {
                                $( "#duration_0" ).html('0 '+ day);
                                $( "#duration_1" ).html(ui.value +' '+ days);
                                $( "#duration1" ).val(0);
                                $( "#duration2" ).val(ui.value);
                                // $('#filters_form').submit();
                                loadPromotion();
                            }
                        });
                        // $("#duration_0").html($("#slider-range").slider('0 '+ days);
                        $("#duration_1").html($("#slider-range").slider("values", 1) +' '+ days);
                        var sort_change = ".box_check_all_promotion .box_check_sort input[name=sort_pro]";
                        var country_check_change = ".box_country_find_box input:checkbox";
                        var travel_style_change = ".box_country_travel_style input:checkbox";
                        var travel_acti_change = ".box_country_travel_acti input:checkbox";
                        $(sort_change+","+country_check_change+","+travel_style_change+","+travel_acti_change).on('change',function () {
                            loadPromotion();
                        })

                    });
                })
            </script>
        {/literal}
    </div>
{elseif $type_op eq 'cruise'}
    <div class="box_option_find_box">
        <div class="box_country_find_cruise_cat">
            <div class="findBox">
                <h3>{$core->get_Lang('Cruise cat')}</h3>
                <ul class="filter tour_types common_wrapper_details checkBlock">
                    {section name=i loop=$lstCat}
                            <li>
                                <div class="cntr">
                                    <label for="c{$lstCat[i].cruise_cat_id}" class="label-cbx">
                                        <input  class="invisible" id="c{$lstCat[i].cruise_cat_id}" type="checkbox"  class="typeSearch" name="country_id[]" value="{$lstCat[i].cruise_cat_id}"   {if $clsISO->checkInArray($cruise_cat_id,$lstCat[i].cruise_cat_id)}checked="checked"{/if}>
                                        <div class="checkbox">
                                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                <polyline points="4 11 8 15 16 6"></polyline>
                                            </svg>
                                        </div>
                                        <span>{$lstCat[i].title}</span>
                                    </label>
                                </div>
                                {if $lstCat[i].catchild}
                                    {assign var=cat_child value =$lstCat[i].catchild }
                                    {section name=j loop=$cat_child}
                                        <ul class="filter tour_types common_wrapper_details checkBlock child_cat">
                                            <li>
                                                <div class="cntr">
                                                    <label for="c{$cat_child[j].cruise_cat_id}" class="label-cbx">
                                                        <input  class="invisible" id="c{$cat_child[j].cruise_cat_id}" type="checkbox"  class="typeSearch" name="country_id[]" value="{$cat_child[j].cruise_cat_id}"  {if $clsISO->checkInArray($cruise_cat_id,$cat_child[j].cruise_cat_id)}checked="checked"{/if}>
                                                        <div class="checkbox">
                                                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                                <polyline points="4 11 8 15 16 6"></polyline>
                                                            </svg>
                                                        </div>
                                                        <span>{$cat_child[j].title}</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    {/section}
                                {/if}
                            </li>
                    {/section}
                </ul>
            </div>
        </div>
    </div>
    {literal}
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $(function() {
                    loadPromotion();
                    var sort_change = ".box_check_all_promotion .box_check_sort input[name=sort_pro]";
                    var cruise_cat_change = ".box_country_find_cruise_cat input:checkbox";
                    $(sort_change+","+cruise_cat_change).on('change',function () {
                        loadPromotion();
                    })
                });
            })
        </script>
    {/literal}
{elseif $type_op eq 'hotel'}
    <div class="box_option_find_box">
        <h2>ok {$type_op}</h2>
    </div>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
             $(function() {
                loadPromotion();
            });
        })
    </script>
{/literal}
{/if}