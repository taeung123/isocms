<section class="findBox mobile" style="display:none">
    <h2 class="head head_show">Find vacation<i class="icon_search"></i></h2>
    <div class="find-a-trip"  style="display:none">		
        <form class="form-inline" method="post" action="{$extLang}">
            <div class="slb" style="display:none">
                <select class="form-control" name="country_id">
                    <option selected="selected">-- {$core->get_Lang('Any country')} --</option>
                    {$clsCountryEx->getSelectByCountry($country_id,false)}
                </select>
            </div>
            <div class="slb">
                <select class="form-control" name="destination_ID" id="destination_ID">
                	<option value="0">{$core->get_Lang('Destinations')}</option> 
                    {section name=i loop=$listTopCity}
                    <option value="{$listTopCity[i].city_id}">{$clsCity->getTitle($listTopCity[i].city_id)}</option>
                    {/section}
                </select>
            </div>
            <div class="slb">
                <select class="form-control" name="cat_ID" id="cat_ID"> 
                    <option value="0">{$core->get_Lang('Travel styles')}</option> 
                    {section name=i loop=$lstCatTour}
                    <option value="{$lstCatTour[i].tourcat_id}">{$clsTourCategory->getTitle($lstCatTour[i].tourcat_id)}</option>
                    {/section}                       
                </select>
            </div>
            <div class="slb">
                <select class="form-control bdr0" name="duration_ID" id="duration_ID"> 
                	<option value="0">{$core->get_Lang('Durations')}</option> 
                    {$DURATION_HTML}
                </select>
            </div>
            <div class="slb">
                <button type="submit" class="btn-search-tours form-button">{$core->get_Lang('Find Now')}</button>
                <input type="hidden" name="hid_s" value="hid_s" />
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
	var country_id= '{$country_id}';
	var cat_id= '{$cat_id}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
</script>
{literal}
<script type="text/javascript">
$(function(){
	$(document).on('change', 'select[name=destination_ID]', function(ev){
		var $_this = $(this);
		var $destination_ID = $_this.val();
		makeSelectCategory(country_id,$destination_ID,0);
		makeSelectboxDuration(country_id,$destination_ID,0,0);
	});
	$(document).on('change', 'select[name=cat_ID]', function(ev){
		var $_this = $(this);
		var $destination_ID = $('select[name=destination_ID]').val();
		var $cat_ID = $_this.val();
		makeSelectboxDuration(country_id,$destination_ID,$cat_ID,0);
	});
	
});
function makeSelectDestination($country_id,$city_id){
	$('select[name=destination_ID]').html('<option value="">Loading...</option>');
	var $_adata = {
		'country_id': $country_id,
		'city_id' : $city_id
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDestination',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=destination_ID]').html(html);
		}
	});
}
function makeSelectCategory($country_id, $city_id, $cat_id){
	$('select[name=cat_ID]').html('<option value="0">Loading...</option>');
	var $_adata = {
		'country_id': $country_id,
		'city_id': $city_id,
		'cat_id': $cat_id
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectCategory',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=cat_ID]').html(html);
		} 
	});
}
function makeSelectboxDuration($country_ID,$city_ID,$cat_ID,$duration_ID){
	$('select[name=duration_ID]').html('<option value="0">Loading...</option>');
	var adata = {
		'country_id': $country_ID,
		'city_id'    : $city_ID,
		'cat_id'    : $cat_ID,
		'duration_id'    : $duration_ID
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDuration',
		data :adata,
		dataType:'html',
		success: function(html){
			$('select[name=duration_ID]').html(html);
		}
	});
}
</script>
{/literal}