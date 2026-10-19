<form action="" class="simple_form search" id="filters_form2" method="post">
	<input type="hidden" name="search_des" value="search_des" />
    <input type="hidden" name="min_price" id="price1" value="{$min_price_search}">
    <input type="hidden" name="max_price" id="price2" value="{$max_price_search}">
    <input type="hidden" name="country_id" id="country_id2" value="{$country_id}">
<!--
	<div class="findBox hidden">
		<p class="title">{$core->get_Lang('Price level')}</p>
		<div id="price_0" class="inline-block text-left"></div><span> -</span>
		<div id="price_1" class="inline-block text-right"></div>
		<div id="slider-price2" class="mb10"></div>
	</div>
-->
	<div class="listRageStar findBox">
		<p class="title">{$core->get_Lang('Hạng sao')}</p>
		<ul class="filter tour_types common_wrapper_details checkBlock">
			<li>
				<input class="typeSearch" name="star_id[]" value="5" type="checkbox" {if $clsISO->checkInArray($star_id,5)}checked="checked"{/if} />
				<label class="twoFilter startReview rate-2019" for="a5" ><span style="width: 100%"></span></label>
			</li>
			<li>
				<input class="typeSearch" name="star_id[]" value="4" type="checkbox" {if $clsISO->checkInArray($star_id,4)}checked="checked"{/if} />
				<label class="twoFilter startReview rate-2019" for="a4" ><span style="width: 80%"></span></label>
			</li>
			<li>
				<input class="typeSearch" name="star_id[]" value="3" type="checkbox" {if $clsISO->checkInArray($star_id,3)}checked="checked"{/if} />
				<label class="twoFilter startReview rate-2019" for="a3" ><span style="width: 60%"></span></label>
			</li>
			<li>
				<input class="typeSearch" name="star_id[]" value="2" type="checkbox" {if $clsISO->checkInArray($star_id,2)}checked="checked"{/if} />
				<label class="twoFilter startReview rate-2019" for="a2" ><span style="width: 40%"></span></label>
			</li>
			<li>
				<input class="typeSearch" name="star_id[]" value="1" type="checkbox" {if $clsISO->checkInArray($star_id,1)}checked="checked"{/if} />
				<label class="twoFilter startReview rate-2019" for="a1" ><span style="width: 20%"></span></label>
			</li>
		</ul>
	</div>
	{if $lstAllFacility}
	<div class="findBox">
		<p class="title">{$core->get_Lang('Convenient')}</p>
		<ul class="filter tour_types common_wrapper_details checkBlock">
			{section name=i loop=$lstAllFacility}
			<li>
				<input id="a{$lstAllFacility[i].property_id}" class="typeSearch" name="property_id[]" value="{$lstAllFacility[i].property_id}" type="checkbox" {if $clsISO->checkInArray($property_id,$lstAllFacility[i].property_id)}checked="checked"{/if} />
				<label class="twoFilter" for="a{$lstAllFacility[i].property_id}">{$clsProperty->getTitle($lstAllFacility[i].property_id)}</label>
			</li>
			{/section}
		</ul>
		<span class="readmore">{$core->get_Lang('More')}</span>	
					
	</div>
	{/if}
</form>
<script >
	var day='{$core->get_Lang("ngày")}';
	var đ='{$core->get_Lang("đ")}';
	var voucher_cat_id='{$voucher_cat_id}';
	var city_id= '{$city_id}';
	var max_price_value = '{$max_price}';
	var min_price_value = '{$min_price}';
	var min_price_search = '{$min_price_search}';
	var max_price_search = '{$max_price_search}';
</script>
{literal}
<script >

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
</script>
{/literal}
