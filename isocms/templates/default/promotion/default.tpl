<link href="{$URL_CSS}/promotion.css" rel="stylesheet" type="text/css">
<link href="{$URL_CSS}/fonts/flaticon/flaticon.css" rel="stylesheet" type="text/css">
<script defer type="text/javascript" src="{$URL_JS}/counter-up/waypoints.min.js?v={$upd_version}"></script>
<script defer type="text/javascript" src="{$URL_JS}/counter-up/jquery.counterup.min.js?v={$upd_version}"></script>
<div class="page_container mt40 mb50 bg_fff">
    <div class="breadcrumb-main breadcrumb-{$mod} mb30 bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs bg_fff mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active" itemprop="name">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('General Promotion')}" itemprop="url">
						<span itemprop="name" class="reb">{$core->get_Lang('General Promotion')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
            </ol>
        </div>
    </div>
    <div class="content_main">

        <div class="container">
            <div class="row">
                <div class="box_intro_promotion_page">
                    <h2 class="title_promotion_page">{$core->get_Lang('General Promotion')}</h2>
                </div>
                <div class="col-sm-3">
                    <div class="box_counter_all"></div>
                    <div class="box_find_option_all_type"></div>
                </div>
                <div class="col-sm-9">
                    <div class="box_check_all_promotion">
                        <div class="box_check_promotion">
                            <div class="toggle">
                                <input type="radio" name="check_pro" value="tour" id="tour_check_pro" checked="checked"/>
                                <label for="tour_check_pro">{$core->get_Lang('Tour')}</label>
                                <input type="radio" name="check_pro" value="cruise" id="cruise_check_pro" />
                                <label for="cruise_check_pro">{$core->get_Lang('Cruise')}</label>
                              {*  <input type="radio" name="check_pro" value="hotel" id="hotel_check_pro" />
                                <label for="hotel_check_pro">{$core->get_Lang('Hotel')}</label>*}
                            </div>
                        </div>
                        <div class="box_check_sort">
                            <div class="toggle_sort">
                                <input type="radio" name="sort_pro" value="p_min" id="sort_min_pro" checked="checked" />
                                <label for="sort_min_pro">{$core->get_Lang('Lowest')}</label>
                                <input type="radio" name="sort_pro" value="p_max" id="sort_max_pro" />
                                <label for="sort_max_pro">{$core->get_Lang('Highest')}</label>
                            </div>
                        </div>
                        <div class="check_show_list hidden">
                            <div class="toggle">
                                <input type="radio" name="show_lst" value="1" id="show_grid_check_pro" checked="checked" />
                                <label for="show_grid_check_pro"><i class="fa fa-th"></i></label>
                                <input type="radio" name="show_lst" value="0" id="show_list_check_pro" />
                                <label for="show_list_check_pro"><i class="fa fa-align-justify"></i></label>
                            </div>
                        </div>
                    </div>
                    <div class="content_promotion_load"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var day='{$core->get_Lang("day")}';
    var days='{$core->get_Lang("days")}';
    var min_duration_value = '{$min_duration_value}';
    var max_duration_value = '{$max_duration_value}';
    var min_duration_search = '{$min_duration_search}';
    var max_duration_search = '{$max_duration_search}';
    var $_LANG_ID = '{$_LANG_ID}';
    // ajLoadItemPromotion
</script>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var check_pro = $(".box_check_all_promotion .box_check_promotion input[name=check_pro]:checked").val();
            $(".box_check_all_promotion .box_check_promotion input[name=check_pro]").on('change',function () {
                var _this = $(this);
                if(_this.val() == 'tour'){
                    // alert("load option Tour");

                    loadOption(_this.val());
                }else if(_this.val() == 'cruise'){
                    // alert("load option Cruise");
                    // loadTotal(_this.val());
                    loadOption(_this.val());
                }else if(_this.val() == 'hotel'){
                    // alert("load option hotel");
                    // loadTotal(_this.val());
                    loadOption(_this.val());
                }
            });
            $(function() {
                if(check_pro !=''){
                    // loadTotal(check_pro);
                    loadOption(check_pro);
                }
            });

            function getCheckTextCountry() {
                var result =
                    $(".box_country_find_box > .findBox > ul > li > .cntr > label > input:checkbox:checked").get();
                var columns = $.map(result, function(element) {
                    return $(element).attr("value");
                });

                return columns.join(",");
            }
            function getCheckTextTravelStyle() {
                var result =
                    $(".box_country_travel_style > .findBox > ul > li > .cntr > label > input:checkbox:checked").get();
                var columns = $.map(result, function(element) {
                    return $(element).attr("value");
                });

                return columns.join(",");
            }
            function getCheckTextTravelActi() {
                var result =
                    $(".box_country_travel_acti > .findBox > ul > li > .cntr > label > input:checkbox:checked").get();
                var columns = $.map(result, function(element) {
                    return $(element).attr("value");
                });

                return columns.join(",");
            }
            function getCheckTextCruiseCat() {
                var result =
                    $(".box_country_find_cruise_cat  input:checkbox:checked").get();
                var columns = $.map(result, function(element) {
                    return $(element).attr("value");
                });

                return columns.join(",");
            }
            function loadPromotion() {
                var check_protype = $(".box_check_all_promotion .box_check_promotion input[name=check_pro]:checked").val();
                var sort = $(".box_check_all_promotion .box_check_sort input[name=sort_pro]:checked").val();
                var data={'clsTable' : check_protype,
                    'sort': sort,
                    '_LANG_ID': $_LANG_ID};
                var min_duration_val = $(".box_option_find_box .box_duration_find_box input[name=min_duration]").val();
                if(min_duration_val>=0){
                    data['min_duration'] = min_duration_val;
                }
                var max_duration_val = $(".box_option_find_box .box_duration_find_box input[name=max_duration]").val();
                if(max_duration_val>=0){
                    data['max_duration'] = max_duration_val;
                }
                var country_check = getCheckTextCountry();
                if(country_check != ''){
                    data['country_check'] = country_check;
                }
                var travel_style_check = getCheckTextTravelStyle();
                if(travel_style_check != ''){
                    data['travel_style_check'] = travel_style_check;
                }
                var travel_acti_check = getCheckTextTravelActi();
                if(travel_acti_check != ''){
                    data['travel_acti_check'] = travel_acti_check;
                }
                var cruise_cat_check = getCheckTextCruiseCat();
                if(cruise_cat_check != ''){
                    data['cruise_cat_check'] = cruise_cat_check;
                }
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script+'/index.php?mod=promotion&act=ajLoadItemPromotion',
                    data: data,
                    dataType:'html',
                    success: function(html){
                        $('.content_promotion_load').html(html);
                        loadTotal(data);
                    }
                });
            }
            function loadOption(type_op) {
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script+'/index.php?mod=promotion&act=ajLoadOptionPromotion',
                    data: {'type_op':type_op},
                    dataType:'html',
                    success: function(html){
                        $('.box_find_option_all_type').html(html);
                    }
                });
            }
            function loadTotal(type_op) {
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script+'/index.php?mod=promotion&act=ajLoadTotalPromotion',
                    data: type_op,
                    dataType:'html',
                    success: function(html){
                        $('.box_counter_all').html(html);
                    }
                });
            }
        })
    </script>
{/literal}
