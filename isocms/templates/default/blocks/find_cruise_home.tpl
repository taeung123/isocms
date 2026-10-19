<form class="form-inline" method="post" action="{$extLang}/" role="form">
  <div class="departure_point">
    <p>{$core->get_Lang('Search your ideas')}</p>
    <input type="text" name="key" class="form-control" value="{$keyword}"
           placeholder="{$core->get_Lang('text_key_seach_cruise')}"/>
  </div>
  <div class="select_find select_find_cruise">
    <div class="form-group">
      <p>{$core->get_Lang('Cruise Class')}</p>
      <select class="form-control" name="cruise_cat_id">
         {$clsCruiseCat->makeSelectboxOption($cruise_cat_id,0)}
      </select>
    </div>
    <div class="form-group">
      <p>{$core->get_Lang('Cruise Itinerary')}</p>
      <select class="form-control" name="duration">
        <option value="0">{$core->get_Lang('Select all')}</option>
      </select>
    </div>
	<div class="form-group"> <p>{$core->get_Lang('Price')}</p>
	  <select class="form-control find_select" name="price_range_ID" id="price_range_ID"> 
			{$clsCruisePriceRange->getSelectPriceRange($budget)}
		</select>
	</div>
	<input type="hidden" value="hidCruises" name="hidFind"/>
    <button  class="btn btn-default" type="submit">{$core->get_Lang('Search')}</button>
  </div>
  <div class="address_find hidden-xs hidden-sm"> <i class="fa fa-bed" aria-hidden="true"></i> {$core->get_Lang('text_sugges_des_cruise')}</div>
</form>
<script type="text/javascript">
    var city_id = "{$city_id}";
    var Loading = "{$core->get_lang('Loading')}....";
</script>
{literal}
<script type="text/javascript">
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