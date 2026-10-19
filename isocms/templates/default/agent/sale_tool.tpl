<div class="page_container page_salestool">
    <div class="breadcrumb-main breadcrumb_new">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="{$PCMS_URL}" itemprop="item" title="{$core->get_Lang('Home')}"><span class="reb" itemprop="name">{$core->get_Lang('Home')}</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="{$clsISO->getLink('sale_tool')}" itemprop="item" title="{$core->get_Lang('Production Price')}"><span class="reb" itemprop="name">{$core->get_Lang('Production Price')}</span></a>
                    <meta itemprop="position" content="2" />
                </li>
                {if $country_id >0}
                    {assign var=title_country value=$clsCountryEx->getTitle($country_id)}
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{$curl}" itemprop="item" title="{$title_country}"><span class="reb" itemprop="name">{$title_country}</span></a>
                        <meta itemprop="position" content="3" />
                    </li>
                {/if}
            </ol>
        </div>
    </div>
    <div id="contentPage" class="pageAgent pdt0">
        <div class="container">
            <h1 class="title">{$core->get_Lang('Production Price')}</h1>
            <div class="list_destination_sales_tool">
                <h2 class="title_top_tour">{$core->get_Lang('Top tours for your customers')}</h2>
                <div class="box_destination">
                    <div class="item_button {if !$country_id}active{/if}"><a href="{$clsISO->getLink('sale_tool')}" title="{$core->get_Lang('All')}">{$core->get_Lang('All')}</a></div>
                    {foreach from=$lstCountryEx key=k item=item}
                        {assign var=title_country value=$item.title}
                        <div class="item_button {if $country_id eq $item.country_id}active{/if}"><a href="{$clsCountryEx->getLink($item.country_id,"sale_tool", $item)}" title="{$title_country}">{$title_country}</a></div>
                    {/foreach}
                </div>
                {if $lstMarket}
                    <div class="box_market">
                        {section name=i loop=$lstMarket}
                            {assign var=title_market value=$clsProperty->getTitle($lstMarket[i].property_id,$lstMarket[i])}
                            <button class="btn_market {if $smarty.section.i.index eq 0}active{/if}" data-market_id="{$lstMarket[i].property_id}" data-country_id="{$country_id}">{$title_market}</button>
                        {/section}
                    </div>
                    <div class="box_market_type">
                        {if $listMarketTypeFirst}
                            {section name=i loop=$listMarketTypeFirst}
                                <label class="item_market_type" data-market_id="{$lstMarket[0].property_id}" data-market_type_id="{$listMarketTypeFirst[i].property_id}" data-country_id="{$country_id}">
                                    {$clsProperty->getTitle($listMarketTypeFirst[i].property_id,$listMarketTypeFirst[i])}
                                    <input type="radio" name="market_type_id" value="{$listMarketTypeFirst[i].property_id}" {if $smarty.section.i.index eq 0}checked{/if}>
                                    <span class="checkmark"></span>
                                </label>
                            {/section}
                        {/if}
                    </div>
                {/if}
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="list-salestools">
                        {section name=i loop=$listDownload}
                            {$clsISO->getBlock("box_tour_agent", ["value" => $listDownload[i]])}
                        {/section}
                    </div>
                    {if $page_view}
                        <div class="hnv_trvs_main_tour_paginate">
                            <div class="pagination pager">
                                {$page_view}
                            </div>
                        </div>
                    {/if}
                </div>
                <div class="col-lg-3">
                    <div class="box_info_company">
                        <h2 class="title_box_company">{$core->get_Lang('Company name')}</h2>
                        {assign var=CompanyAddress value="CompanyAddress_$_LANG_ID"}
                        <div class="item_info_company item_address"><i class="fa-regular fa-location-dot"></i> {$core->get_Lang('Adress')}: {$clsConfiguration->getValue($CompanyAddress)}</div>
                        <div class="item_info_company item_email"><i class="fa-regular fa-envelope"></i> {$core->get_Lang('Email')}: {$clsConfiguration->getValue('CompanyEmail')}</div>
                        <div class="item_info_company item_phone"><i class="fa-regular fa-phone"></i> {$core->get_Lang('Phone')}: {$clsConfiguration->getValue("CompanyPhone")}</div>
                        <div class="item_info_company item_phone"><i class="fa-regular fa-phone"></i> {$core->get_Lang('Hotline')}: {$clsConfiguration->getValue("CompanyHotline")}</div>
                    </div>
                    {*{if !empty($listSaleKit)}
                    <div class="list_sale_kit mt-3">
                        {foreach from=$listSaleKit key=k item=v}
                            <div class="sale_kit_item">
                                <img class="w-100" src="{$v.image}" alt="{$v.title}">
                                <div class="sale_kit_title">{$v.title}</div>
                                <a href="{$v.attachment_file}" download class="sale_kit_btn">
                                    <i class="fa-regular fa-download"></i> {$core->get_Lang("Download")}
                                </a>
                            </div>
                        {/foreach}
                    </div>
                    {/if}*}
                </div>
            </div>
        </div>
    </div>
</div>
<!--modal-->
<div class="modal modal_require" id="modalRequest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="box_header_modal">
                    <i class="fa-regular fa-flag"></i>
                    <h2 class="title_modal">{$core->get_Lang('Require')}</h2>
                    <p class="title_tour">{$title_item}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form_require" onsubmit="return false;">
                    <input type="hidden" name="target_id" value="">
                    <div class="box_setting_tour">
                        <div class="box_number_person">
                            <label for="" class="lbl_input">{$core->get_Lang('Number of visitors')}<span class="red_star">*</span></label>
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="item_number">
                                        <span class="text">{$core->get_Lang('Adult')}</span>
                                        <div class="box_input_number">
                                            <button class="btn_minus btn_number opacity" type="button">-</button>
                                            <input class="inp_number" type="number" name="number_adult" onkeyup="format_number(this)" value="0" min="0">
                                            <button class="btn_plus btn_number" type="button">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="item_number">
                                        <span class="text">{$core->get_Lang('Children')}</span>
                                        <div class="box_input_number">
                                            <button class="btn_minus btn_number opacity" type="button">-</button>
                                            <input class="inp_number" type="number" name="number_children" onkeyup="format_number(this)" value="0" min="0">
                                            <button class="btn_plus btn_number" type="button">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="item_number">
                                        <span class="text">{$core->get_Lang('Baby')}</span>
                                        <div class="box_input_number">
                                            <button class="btn_minus btn_number opacity" type="button">-</button>
                                            <input class="inp_number" type="number" name="number_infant" onkeyup="format_number(this)" value="0" min="0">
                                            <button class="btn_plus btn_number" type="button">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label for="" id="error_number_visitors" class="error" style="display: none"></label>
                        </div>
                        <div class="box_tour_length">
                            <div class="box_input">
                                <label for="" class="lbl_input">{$core->get_Lang('Tour length')}<span class="red_star">*</span></label>
                                <div class="box_select_modal">
                                    <select name="travelduration" id="" class="select_modal">
                                        {section name=i start=1 loop=10 step=1}
                                            <option value="{$smarty.section.i.index}">{$smarty.section.i.index} {$core->get_Lang('days')}</option>
                                        {/section}
                                    </select>
                                    <i class="fa-light fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="box_input box_departure">
                                <label for="" class="lbl_input">{$core->get_Lang('Departure time')}<span class="red_star">*</span></label>
                                <div class="box_departure_date">
                                    <i class="fa-regular fa-calendar"></i>
                                    <input type="text" class="departure_date" name="departure" value="{$now|date_format:"%m/%d/%Y"}" placeholder="{$core->get_Lang('Selecet date')}" autocomplete="off">
                                </div>
                                <label for="" id="error_departure" class="error" style="display: none"></label>
                            </div>
                        </div>
                        <div class="box_input">
                            <label for="" class="lbl_input">{$core->get_Lang('Where would you like to go?')}<span class="red_star">*</span></label>
                            <div class="box_select_modal">
                                <select name="country_id[]" id="" class="select_modal chosen-select" multiple>
                                    {foreach from=$lstCountryEx key=k item=item}
                                        <option value="{$item.country_id}">{$item.title}</option>
                                    {/foreach}
                                </select>
                                <label for="" id="error_destination" class="error" style="display: none"></label>
                            </div>

                        </div>
                        <div class="box_input">
                            <label for="" class="lbl_input">{$core->get_Lang('Travel style')}<span class="red_star">*</span></label>
                            <div class="box_select_modal">
                                <select name="tourcat_id" id="" class="select_modal chosen-select">
                                    <option value="">{$core->get_Lang('Select travel style')}</option>
                                    {section name=i loop=$lstCatTour}
                                        {assign var=title_cat value=$clsTourCategory->getTitle($lstCatTour[i].tourcat_id)}
                                        <option value="{$lstCatTour[i].tourcat_id}">{$title_cat}</option>
                                    {/section}
                                </select>
                                <label for="" id="error_travel_style" class="error" style="display: none"></label>
                            </div>
                        </div>
                        <div class="box_input">
                            <label for="" class="lbl_input">{$core->get_Lang('Hotel')}</label>
                            <div class="list_checkbox">
                                <p class="item_radio"><label class="input_checkmark"><input type="radio" name="hotelclass" value="5"><span class="checkmark"></span></label> {$core->get_Lang('5 star')}</p>
                                <p class="item_radio"><label class="input_checkmark"><input type="radio" name="hotelclass" value="4"><span class="checkmark"></span></label> {$core->get_Lang('4 star')}</p>
                                <p class="item_radio"><label class="input_checkmark"><input type="radio" name="hotelclass" value="3"><span class="checkmark"></span></label> {$core->get_Lang('3 star')}</p>
                                <p class="item_radio"><label class="input_checkmark"><input type="radio" name="hotelclass" value="0"><span class="checkmark"></span></label> {$core->get_Lang('No rating')}</p>
                            </div>
                        </div>
                        <div class="box_input">
                            <label for="" class="lbl_input">{$core->get_Lang('Cruise')}</label>
                            <div class="list_checkbox">
                                {section name=i loop=$lstCruiseCat}
                                    {assign var=title_cat_cruise value=$clsCruiseCat->getTitle($lstCruiseCat[i].cruise_cat_id)}
                                    <p class="item_radio"><label class="input_checkmark"><input type="radio" name="cruise_cat_id" value="{$lstCruiseCat[i].cruise_cat_id}"><span class="checkmark"></span></label> {$title_cat_cruise}</p>
                                {/section}
                            </div>
                        </div>
                        <div class="box_input">
                            <label for="" class="lbl_input">{$core->get_Lang('How would you like us to contact you?')}</label>
                            <div class="list_checkbox">
                                <p class="item_radio"><label class="input_checkmark"><input type="radio" name="please" value="1"><span class="checkmark"></span></label> {$core->get_Lang('Email')}</p>
                                <p class="item_radio"><label class="input_checkmark"><input type="radio" name="please" value="2"><span class="checkmark"></span></label> {$core->get_Lang('Call')}</p>
                                <p class="item_radio"><label class="input_checkmark"><input type="radio" name="please" value="3"><span class="checkmark"></span></label> {$core->get_Lang("Don't Mind")}</p>
                            </div>
                        </div>
                        <div class="box_input">
                            <label for="" class="lbl_input">{$core->get_Lang('Note - Special request')}</label>
                            <textarea name="Comments" id="" cols="30" rows="10" class="txt_note"></textarea>
                        </div>
                        {if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
                            <label class="col-sm-12 title" for="secure_code">
                                <abbr class="required" title="required">*</abbr> {$core->get_Lang('securecode')}
                            </label>
                            <div class="col-sm-12 mb15">
                                <input autocomplete="off" type="text" class="form-control security_code required" name="secure_code" value="" maxlength="5" />
                                <img src="{$PCMS_URL}/captcha.php?sid={$sid}" width="80" height="36" alt="Secure" />
                            </div>
                            <label for="" id="error_captcha" class="error" style="display: none"></label>
                        {else}
                            <div class="box_input">
                                <div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
                                <label for="" id="error_captcha" class="error" style="display: none"></label>
                            </div>
                        {/if}
                        <button id="submit_request" class="btn_submit">{$core->get_Lang('Send')}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end modal-->
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}">
<script defer src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script>
    var msg_number_visitors = "{$core->get_Lang('Number of visitors is required!')}";
    var msg_departure = "{$core->get_Lang('Departure time is required!')}";
    var msg_destination = "{$core->get_Lang('Destination is required!')}";
    var msg_travel_style = "{$core->get_Lang('Travel style is required!')}";
</script>
{literal}
    <script type="text/javascript" defer>
        $(document).ready(function(){
            $('input[name=departure]').datepicker({
                dateFormat: 'M dd, yy',
                minDate: new Date(),
                onSelect: function () {
                    var date = $(this).datepicker('getDate');
                    if (date) {
                        date.setDate(date.getDate() + 1);
                    }
                }
            });
            $('.btn_minus').click(function(){
                if(!$(this).hasClass('opacity')){
                    var inp_number = $(this).closest('.box_input_number').find('.inp_number');
                    var number = inp_number.val();
                    number = (number != '' && parseInt(number) > 0)?parseInt(number):0;
                    --number;
                    inp_number.val(number);
                    if(number == 0){
                        $(this).addClass('opacity');
                    }
                }

            });

            $('.btn_plus').click(function(){
                var inp_number = $(this).closest('.box_input_number').find('.inp_number');
                var btn_minus = $(this).closest('.box_input_number').find('.btn_minus');
                var number = inp_number.val();
                number = (number != '' && parseInt(number) > 0)?parseInt(number):0;
                ++number;
                btn_minus.removeClass('opacity');
                inp_number.val(number);
            });
            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy'
            });
            $(".chosen-select").chosen({
                disable_search_threshold: 10,
                placeholder_text_multiple:"Select options",
                placeholder_text_single:"Select option",
                no_results_text:"No results match"
            });
            $('.btn_request').click(function(){
                let target_id = $(this).data('target_id');
                $('#modalRequest').find("input[name='target_id']").val(target_id);
                $('.title_tour').html($(this).data('title'));

            });
            $("#submit_request").click(function(){
                var number_adult = $('input[name="number_adult"]').val();
                var number_child = $('input[name="number_children"]').val();
                var number_infant = $('input[name="number_infant"]').val();
                var departure = $('input[name="departure"]').val();
                var country_id = $('select[name="country_id[]"]').val();
                var cat_id = $('select[name="cat_id"]').val();
                if(number_adult == 0 && number_child == 0 && number_infant == 0){
                    $('input[name="number_adult"]').focus();
                    $('#error_number_visitors').html(msg_number_visitors).fadeIn().delay(3000).fadeOut();
                    return false;
                }
                if(departure == ''){
                    $('#error_departure').html(msg_departure).fadeIn().delay(3000).fadeOut();
                    $('input[name="departure"]').focus();
                    return false;
                }
                if(country_id == null){
                    $('#error_destination').html(msg_destination).fadeIn().delay(3000).fadeOut();
                    $('select[name="country_id[]"]').focus();
                    return false;
                }
                if(cat_id == ''){
                    $('#error_travel_style').html(msg_travel_style).fadeIn().delay(3000).fadeOut();
                    $('select[name="cat_id"]').focus();
                    return false;
                }
                var formdata = new FormData(document.getElementById("form_require"));
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data:formdata,
                    processData: false,
                    contentType: false,
                    url:path_ajax_script+'/index.php?mod='+mod+'&act=addRequireSalesTools',
                    success:function(json){
                        if(json.result == false){
                            if(json.data.type == 'login'){
                                if(confirm(json.data.message)){
                                    window.open(json.data.url, '_blank');
                                }
                            }else if(json.data.type == 'captcha'){
                                $('#error_captcha').html(json.data.message).fadeIn().delay(3000).fadeOut();
                                return false;
                            }else if(json.data.type == 'spam'){
                                alert(json.data.message);
                                location.reload();
                            }
                        }else{
                            location.href=json.data.url;
                        }
                    }
                });
            });

            $('.btn_market').click(function(){
                $('.btn_market').removeClass('active');
                $(this).addClass('active');
                var $market_id = $(this).data('market_id');
                var $country_id = $(this).data('country_id');
                load_product($market_id,$country_id);
            });

            $(document).on('change','.item_market_type',function(){
                console.log('sss');
                var $market_id = $(this).data('market_id');
                var $country_id = $(this).data('country_id');
                var $market_type_id = $(this).data('market_type_id');
                load_product($market_id,$country_id,$market_type_id);
            });
        });
        function load_product($market_id,$country_id,$market_type_id=0){
            $.ajax({
                type: "POST",
                dataType: "json",
                data:{
                    market_id : $market_id,
                    country_id : $country_id,
                    market_type_id	:	$market_type_id
                },
                url:path_ajax_script+'/index.php?mod='+mod+'&act=loadProduct',
                success:function(json){
                    if(json.result == true){
                        if(json.htmlMarketType != ''){
                            $(".box_market_type").html(json.htmlMarketType);
                        }
                        $('.list-salestools').html(json.htmlDownload);
                    }
                }
            });
        }
        function format_number(elm){
            var number = $(elm).val();
            if(number == '' || number < 0){
                $(elm).val(0);
                $(elm).closest('.item_number').find('.btn_minus').addClass('opacity');
            }else if(number > 0){
                $(elm).val(parseInt(number));
                $(elm).closest('.item_number').find('.btn_minus').removeClass('opacity');
            }
        }
    </script>
{/literal}