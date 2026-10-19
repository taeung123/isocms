<form action="" class="simple_form search" id="filters_form2" method="post">
	<input type="hidden" name="search_des" value="search_des" />
	<input type="hidden" name="min_duration" id="duration1" value="{$min_duration_search}">
    <input type="hidden" name="max_duration" id="duration2" value="{$max_duration_search}">
    <input type="hidden" name="min_price" id="price1" value="{$min_price_search}">
    <input type="hidden" name="max_price" id="price2" value="{$max_price_search}">
    <input type="hidden" name="country_id" id="country_id2" value="{$country_id}">
	<div class="findBox mt0 pdbt30">
		<p class="title">{$core->get_Lang('Hành trình')}</p>
		<div id="duration_0" class="inline-block  text-left"></div><span> -</span>
		<div id="duration_1" class="inline-block  text-right"></div>
		<div id="slider-range2"></div>
	</div>
	<div class="findBox">
		<p class="title">{$core->get_Lang('Mức giá')}</p>
		<div id="price_0" class="inline-block  text-left"></div><span> -</span>
		<div id="price_1" class="inline-block  text-right"></div>
		<div id="slider-price2"></div>
	</div>
	{if $lstCountry}
	<div class="findBox">
		<p class="title">{$core->get_Lang('Chọn quốc gia')}</p>
		<ul class="filter tour_types common_wrapper_details checkBlock">
			{section name=i loop=$lstCountry}
			<li>
				<input id="a{$lstCountry[i].country_id}" class="typeSearch" name="country_id[]" value="{$lstCountry[i].country_id}" type="checkbox" {if $clsISO->checkInArray($country_id,$lstCountry[i].country_id)}checked="checked"{/if} />
				
				<label class="twoFilter" for="a{$lstCountry[i].country_id}">{$clsCountry->getTitle($lstCountry[i].country_id)}</label>
			</li>
			{/section}
		</ul>
				<a class="seemore seeclick text_center " href="javascript:void(0);" title="{$core->get_Lang('Xem thêm')}">{$core->get_Lang('Xem thêm')}</a>
				<a class="seeless seeclick text_center" href="javascript:void(0);" title="{$core->get_Lang('Thu gọn')}" style="display: none">{$core->get_Lang('Thu gọn')}</a>
					
	</div>
	{/if}
	{if $lstCity}
	<div class="findBox">
		<p class="title">{$core->get_Lang('Chọn điểm khởi hành')}</p>
		<ul class="filter tour_types common_wrapper_details checkBlock">
			{section name=i loop=$lstCity}
			<li>
				<input id="a{$lstCity[i].city_id}" class="typeSearch" name="city_id[]" value="{$lstCity[i].city_id}" type="checkbox" {if $clsISO->checkInArray($city_id,$lstCity[i].city_id)}checked="checked"{/if} />
				<label class="twoFilter" for="a{$lstCity[i].city_id}">{$clsCity->getTitle($lstCity[i].city_id)}</label>
			</li>
			{/section}
		</ul>
				<a class="seemore seeclick text_center " href="javascript:void(0);" title="{$core->get_Lang('Xem thêm')}">{$core->get_Lang('Xem thêm')}</a>
				<a class="seeless seeclick text_center" href="javascript:void(0);" title="{$core->get_Lang('Thu gọn')}" style="display: none">{$core->get_Lang('Thu gọn')}</a>
					
	</div>
	{/if}
	{if $lstTourCat}
	<div class="findBox">
		<p class="title">{$core->get_Lang('Chọn loại hình du lịch')}</p>
		<ul class="filter tour_types common_wrapper_details checkBlock">
			{section name=i loop=$lstTourCat}
			<li>
				<input id="a{$lstTourCat[i].tourcat_id}" class="typeSearch" name="tourcat_id[]" value="{$lstTourCat[i].tourcat_id}" type="checkbox" {if $clsISO->checkInArray($cat_id,$lstTourCat[i].tourcat_id)}checked="checked"{/if} />
				<label class="twoFilter" for="a{$lstTourCat[i].tourcat_id}">{$lstTourCat[i].title}</label>
			</li>
			{/section}
		</ul>
		<a class="seemore seeclick text_center " href="javascript:void(0);" title="{$core->get_Lang('Xem thêm')}">{$core->get_Lang('Xem thêm')}</a>
		<a class="seeless seeclick text_center" href="javascript:void(0);" title="{$core->get_Lang('Thu gọn')}" style="display: none">{$core->get_Lang('Thu gọn')}</a>
		
		{literal}
					<script>
							var height = $('.findBox ul').height();
							if(height < 199){
								$('.seemore').hide();
							}
					</script>
					{/literal}
	</div>
	{/if}
</form>
<script >
	var day='{$core->get_Lang("ngày")}';
	var đ='{$core->get_Lang("đ")}';
	var tourcat_id='{$tourcat_id}';
	var city_id= '{$city_id}';
	var country_id= '{$country_id}';
	var min_duration_value = '{$min_duration}';
	var max_duration_value = '{$max_duration}';
	var min_duration_search = '{$min_duration_search}';
	var max_duration_search = '{$max_duration_search}';
	var max_price_value = '{$max_price}';
	var min_price_value = '{$min_price}';
	var min_price_search = '{$min_price_search}';
	var max_price_search = '{$max_price_search}';
</script>
{literal}
<script >
$(function() {
    $( "#slider-range2" ).slider({
      range: true,
      min: parseInt(min_duration_value),
      max: parseInt(max_duration_value),
      values: [min_duration_search, max_duration_search],
      slide: function( event, ui ) {
        $( "#duration_0" ).html(ui.values[0] +' '+ day);
		$( "#duration_1" ).html(ui.values[1] +' '+ day);
		$( "#duration1" ).val(ui.values[0]);
		$( "#duration2" ).val(ui.values[1]);
		$('#filters_form2').submit();
      }
    });
    $("#duration_0").html($("#slider-range2").slider("values", 0) +' '+ day);
	$("#duration_1").html($("#slider-range2").slider("values", 1) +' '+ day);
	
});
$(function(){
	$( "#slider-price2" ).slider({
      range: true,
      min: parseInt(min_price_value),
      max: parseInt(max_price_value),
      values: [min_price_search, max_price_search],
      slide: function( event, ui ) {
        $( "#price_0" ).html(ui.values[0] +' '+ đ);
		$( "#price_1" ).html(ui.values[1] +' '+ đ);
		$( "#price1" ).val(ui.values[0]);
		$( "#price2" ).val(ui.values[1]);
		$('#filters_form2').submit();
      }
    });
//    $("#price_0").html($("#slider-price2").slider("values", 0) +' '+ đ);
//	$("#price_1").html($("#slider-price2").slider("values", 1) +' '+ đ);
	document.getElementById("price_0").innerHTML = format_price(min_price_search);
	document.getElementById("price_1").innerHTML = format_price(max_price_search);

})
function format_price(n) {
	 
	return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + 'đ'
	}
</script>
{/literal}
{literal}
<style>
.readMoreClass{position:relative}
.readMoreClass .section_expander{position:absolute; width:50px; bottom:0; right:0; color:#f16f30}
.common_wrapper_details{overflow:hidden}
</style>
{/literal}
{literal}

<script>
	$('#filters_form2 .typeSearch').change(function(){
	$(this).closest('form').submit();
});
$('.seemore').on('click',function () {
	$(this).closest('.findBox').find('ul').css('height','100%');
	$(this).closest('.findBox').find('.seeless').show();
	$(this).hide();
});
$('.seeless').on('click',function () {
	$(this).closest('.findBox').find('ul').removeAttr('style');
	$(this).closest('.findBox').find('.seemore').show();
	$(this).hide();
});
</script>
{/literal}
