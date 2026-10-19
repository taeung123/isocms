<form class="form-inline" method="post" action="{$extLang}/">
  <div class="input_key_word">
    <input type="text" name="key" class="form-control" value="{$keyword}"
           placeholder="{$core->get_Lang('Search your cruise')}"/>
  </div>
  <div class="select_find select_find_cruise">
    <div class="form-group">
      <select class="form-control" name="cruise_cat_id">
         {$clsCruiseCat->makeSelectboxOption($cruise_cat_id,0)}
      </select>
    </div>
    <div class="form-group">
      <select class="form-control" name="duration">
        <option value="0">{$core->get_Lang('Cruise Itinerary')}</option>
      </select>
    </div>
	<div class="form-group">
	  <select class="form-control find_select" name="price_range_ID" id="price_range_ID"> 
			{$clsCruisePriceRange->getSelectPriceRange($budget)}
		</select>
	</div>
	<input type="hidden" value="hidCruises" name="hidFind"/>
    <button  class="btn btn-default bg_main" type="submit">{$core->get_Lang('Search')}</button>
  </div>
</form>
<script>
    var city_id = "{$city_id}";
    var Loading = "{$core->get_lang('Loading')}....";
</script>
{literal}
<script>
$(function(){
	$('select[name=cruise_cat_id]').change(function(){
		var $_this = $(this);
		var $cruise_cat_id = $_this.val();
		makeSelectDurationCruise($cruise_cat_id);
	});
});
function makeSelectDurationCruise($cruise_cat_id){
	$('select[name=duration]').html('<option value="">'+Loading+'</option>');
	var $_adata = {
		'cruise_cat_id' : $cruise_cat_id,
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDurationCruise',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=duration]').html(html);
		}
	});
}
</script>
{/literal}