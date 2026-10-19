<form action="" class="simple_form search" id="filters_form2" method="post">
	<input type="hidden" name="search_des" value="search_des" />
	<input type="hidden" name="min_price" id="price1" value="{$min_price_search}">
	<input type="hidden" name="max_price" id="price2" value="{$max_price_search}">
	<input type="hidden" name="country_id" id="country_id2" value="{$country_id|default:0}">
	<div class="findBox">
		<h3 class="title">{$core->get_Lang('Price level')}</h3>
		<div id="price_0" class="inline-block text-left"></div><span> -</span>
		<div id="price_1" class="inline-block text-right"></div>
		<div id="slider-price2" class="mb10"></div>
	</div>
	{if $lstVoucherCat}
    <div class="findBox">
        <h3 class="title">{$core->get_Lang('Category')}</h3>
        <ul class="filter tour_types common_wrapper_details checkBlock">
            {foreach from=$lstVoucherCat item=voucherCat}
                <li>
                    <input 
                        id="a{$voucherCat.voucher_cat_id}" 
                        class="typeSearch" 
                        name="voucher_cat_id[]" 
                        value="{$voucherCat.voucher_cat_id}" 
                        type="checkbox" 
                        {if $clsISO->checkInArray($voucher_cat_id, $voucherCat.voucher_cat_id)}checked="checked"{/if} 
                    />
                    <label class="twoFilter" for="a{$voucherCat.voucher_cat_id}">
                        {$clsVoucherCategory->getTitle($voucherCat.voucher_cat_id, $voucherCat)}
                    </label>
                </li>
            {/foreach}
        </ul>
        <span class="readmore">{$core->get_Lang('More')}</span>
    </div>
	{/if}
	{if $lstCity}
    <div class="findBox">
        <h3 class="title">{$core->get_Lang('Lọc theo điểm đến')}</h3>
        <ul class="filter tour_types common_wrapper_details checkBlock">
            {foreach from=$lstCity item=city}
                <li>
                    <input 
                        id="a{$city.city_id}" 
                        class="typeSearch" 
                        name="city_id[]" 
                        value="{$city.city_id}" 
                        type="checkbox" 
                        {if $clsISO->checkInArray($city_id|default:0, $city.city_id)}checked="checked"{/if} 
                    />
                    <label class="twoFilter" for="a{$city.city_id}">
                        {$clsCity->getTitle($city.city_id, $city)}
                    </label>
                </li>
            {/foreach}
        </ul>
        <span class="readmore">{$core->get_Lang('More')}</span>
    </div>
	{/if}
</form>
<script >
	var curency='{$clsISO->getShortRate()}';
	var day='{$core->get_Lang("ngày")}';
	var đ='{$core->get_Lang("đ")}';
	var voucher_cat_id='{$voucher_cat_id}';
	var city_id= '{$city_id}';
	var max_price_value = '{$max_price_value}';
	var min_price_value = '{$min_price_value}';
	var min_price_search = '{$min_price_search}';
	var max_price_search = '{$max_price_search}';
</script>

{literal}
<style>
    .readMoreClass{position:relative}
    .readMoreClass .section_expander{position:absolute; width:50px; bottom:0; right:0; color:#f16f30}
    .common_wrapper_details{overflow:hidden}
</style>
{/literal}

{literal}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $(function(){
            $( "#slider-price2" ).slider({
                range: true,
                min: parseInt(min_price_value),
                max: parseInt(max_price_value),
                values: [min_price_search, max_price_search],
                slide: function( event, ui ) {
                    $( "#price_0" ).html(ui.values[0] +' '+ curency);
                    $( "#price_1" ).html(ui.values[1] +' '+ curency);
                    $( "#price1" ).val(ui.values[0]);
                    $( "#price2" ).val(ui.values[1]);
                    $('#filters_form2').submit();
                }
            });
            document.getElementById("price_0").innerHTML = format_price(min_price_search);
            document.getElementById("price_1").innerHTML = format_price(max_price_search);

        })
        function format_price(n) {
            return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + curency
        }
        $('#filters_form2 .typeSearch').change(function(){
            $(this).closest('form').submit();
        });
        $(function(){
            $('.common_wrapper_details').each(function(){
                var $_this = $(this);
                if($_this.height()>205){
                    $_this.css("height","205px");
                    $_this.closest(".findBox").find(".readmore").show();
                }else{
                    $_this.closest(".findBox").find(".readmore").hide();
                }
            });
            $(document).on("click",".findBox .readmore",function(){
                var $_this = $(this);
                if(!$_this.hasClass("less")){
                    $_this.addClass("less");
                    $_this.closest(".findBox").find(".common_wrapper_details").css("height","auto");
                    $_this.html('{/literal}{$core->get_Lang("Less")}{literal}');
                }
                else{
                    $_this.removeClass("less");
                    $_this.closest(".findBox").find(".common_wrapper_details").css("height","205px");
                    $_this.html('{/literal}{$core->get_Lang("More")}{literal}');
                }
            });
        });
    })
    
</script>
{/literal}



