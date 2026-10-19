<form class="form-inline" method="post" action="{$extLang}/">
	<div class="input_key_word">
		<input type="text" name="key" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang('Search your hotel')}"/>
	</div>
	<div class="select_find">
		<div class="form-group">
			<select class="form-control" name="country_id">
				{$clsCountry->getSelectByCountry($country_id)}
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="city_id">
				<option value="0">{$core->get_Lang('City')}</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="star_id">
				<option selected="selected"> {$core->get_Lang('Ranking')}</option>
				{$clsISO->makeSelectNumberStart(6,$star_id)}
			</select>
		</div>
		{if $clsConfiguration->getValue('SiteHasHotelPriceRange')}
		<div class="form-group">
		<select class="form-control bdr0" name="price_range">
			<option value="0">{$core->get_Lang('Price')}</option>
			{section name=i loop=$lstPriceRange}
			<option {if $price_range eq $lstPriceRange[i].hotel_price_range_id}selected="selected"{/if}
			value="{$lstPriceRange[i].hotel_price_range_id}">{$clsHotelPriceRange->getTitle($lstPriceRange[i].hotel_price_range_id)}</option>
			{/section}
		</select>
		</div>
		{/if} 
		<input type="hidden" value="searchHotel" name="hid"/>
		<button  class="btn btn-default bg_main" type="submit">{$core->get_Lang('Search')}</button>
	</div>
</form>

<link rel="stylesheet" href="{$URL_JS}/selectric/selectric.css?v={$upd_version}">
<script src="{$URL_JS}/selectric/jquery.selectric.js?v={$upd_version}"></script>
<script>
    var city_id = "{$city_id}";
    var Loading = "{$core->get_lang('Loading')}....";
</script>
{literal}
<script>
$(function () {
  loadCity();
  $('select[name=country_id]').change(function () {
	  loadCity();
  });
});

function loadCity() {
  $.ajax({
	  'type': 'POST',
	  'url': path_ajax_script + '/index.php?mod=hotel&act=loadCity&lang=' + LANG_ID,
	  'data': {"country_id": $('select[name=country_id]').val(), 'city_id': city_id},
	  'dataType': 'html',
	  'success': function (html) {
		  $('select[name=city_id]').html(html);
	  }
  });
}
</script>
{/literal}
