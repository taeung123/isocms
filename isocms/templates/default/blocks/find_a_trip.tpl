<section class="boxColFindTrip bg_fff">
    <h2 class="head mb10">{$core->get_Lang('Find your destination')}<i class="icon_search"></i></h2>
	<p class="mb20">{$core->get_Lang('Discover the world')}</p>
    <div class="findtrip">		
        <form class="form-inline" method="post" action="{$clsISO->getLink('search_tour')}">
            <div class="find-a-box input">
                <input class="w100 searchText" type="text" name="key" value="{$keyword}" placeholder="{$core->get_Lang('Search Tours')}" />
            </div>
            <div class="find-a-box select">
                <select class="form-group" name="destination_ID" id="destination_ID">
                	{$html_CountryEx}
                </select>
            </div>
            <div>
                <button type="submit" class="btn_search">{$core->get_Lang('SEARCH')}</button>
                <input type="hidden" name="hid_s" value="hid_s" />
            </div>
        </form>
    </div>
</section>
<script >
	var country_id= '{$country_id}';
	var cat_id= '{$cat_id}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
</script>
{literal}
<script >
$(function(){
	makeSelectboxDuration(0,0,0);
	$(document).on('change', 'select[name=country_id]', function(ev){
		var $_this = $(this);
		var $country_id = $_this.val();
	});
	$(document).on('change', 'select[name=destination_ID]', function(ev){
		var $_this = $(this);
		var $destination_ID = $_this.val();
		makeSelectboxDuration($destination_ID,0,0);
		makeSelectCategory($destination_ID,0);
		
	});
	
	$(document).on('change', 'select[name=cat_ID]', function(ev){
		var $_this = $(this);
		var $destination_ID = $('select[name=destination_ID]').val();
		var $cat_ID = $_this.val();
		makeSelectboxDuration($destination_ID,$cat_ID,0);
	});
	
});
function makeSelectDestination($country_id,$city_id){
	$('select[name=destination_ID]').html('<option value="">'+$Loading+'...</option>');
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
function makeSelectCategory($destination_ID, $cat_id){
	$('select[name=cat_ID]').html('<option value="0">'+$Loading+'...</option>');
	var $_adata = {
		'destination_ID': $destination_ID,
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
function makeSelectboxDuration($destination_ID,$cat_ID,$duration_ID){
	$('select[name=duration_ID]').html('<option value="0">'+$Loading+'...</option>');
	var $_adata = {
		'destination_ID': $destination_ID,
		'cat_id'    : $cat_ID,
		'duration_id'    : $duration_ID
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDuration',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=duration_ID]').html(html);
		}
	});
}
</script>
{/literal}