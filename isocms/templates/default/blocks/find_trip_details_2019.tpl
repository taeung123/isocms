<div class="col_clnews-regiter boxCatTours" style="margin-top:0">
    <div class="Find-EMAIL">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#tours"  class="tab_tour"><i class="fa fa-map-marker" aria-hidden="true"></i> {$core->get_Lang('TOURS')}</a></li>
			<li class="tab_cruise"><a data-toggle="tab" href="#cruise" class="tab_cruise"><i class="fa fa-ship" aria-hidden="true"></i> {$core->get_Lang('CRUISES')}</a></li>
			<li class="tab_hotel"><a data-toggle="tab" href="#hotel" class="tab_hotel"><i class="fa fa-hospital-o" aria-hidden="true"></i> {$core->get_Lang('HOTELS')}</a></li>
		</ul>
		<div class="tab-content">
			<div id="tours" class="tab-pane fade in active">
				<form class="" method="post" action="{$extLang}/">
					<div class="input_key_word">
						<input type="text" name="key" value="" placeholder="{$core->get_Lang('Search your Tours')}....">
					</div>
					<div class="select_find">
					<div class="form-group slb">
						<select class="form-control" name="departure_point_id" id="departure_point_ID">

							<option value="0">{$core->get_Lang('Departure point')}</option>
                            {section name=i loop=$lstDeparturePoint}
								<option value="{$lstDeparturePoint[i].city_id}" title="{$clsCity->getTitle($lstDeparturePoint[i].city_id)}">{$clsCity->getTitle($lstDeparturePoint[i].city_id)}</option>
                            {/section}
						</select>
					</div>
					<div class="form-group slb">
						<select class="form-control slb" name="destination_id" id="destination_ID">
							<option value="0">{$core->get_Lang('Destinations')}</option>
                            {section name=i loop=$listTopCity}
								<option value="{$listTopCity[i].city_id}">{$clsCity->getTitle($listTopCity[i].city_id)}</option>
                            {/section}
						</select>
					</div>
					<div class="form-group slb">
						<select class="form-control" name="cat_id" id="cat_ID">
							<option value="0">{$core->get_Lang('Travel Styles')}</option>
                            {section name=i loop=$lstCatTour}
								<option value="{$lstCatTour[i].tourcat_id}">{$clsTourCategory->getTitle($lstCatTour[i].tourcat_id)}</option>
                            {/section}
						</select>
						</div>
					<div class="form-group slb">
						<select class="form-control" name="duration_id" id="duration_ID">
                            {$DURATION_HTML}
						</select>
					</div>
					<button type="submit" class="btn btn-default bg_main" id="findtBtn">{$core->get_Lang('Search')}</button>
					<input type="hidden" name="Hid_Search" value="Hid_Search" />
					</div>
				</form>
			</div>
			<div id="cruise" class="tab-pane fade">
                {$core->getBlock('find_cruise_home_2019')}
			</div>
			<div id="hotel" class="tab-pane fade">
                {$core->getBlock('find_hotel_home_2019')}
			</div>

		</div>

    </div>
</div>
<script>
	var cat_id= '{$cat_id}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
</script>
{literal}
<script>
$(function(){
	$('select[name=departure_point_ID]').change(function(){
		var $_this = $(this);
		var $departure_point_ID = $_this.val();
		makeSelectDestination($_this.val());
		makeSelectCategory($departure_point_ID,0,0);
		makeSelectboxDuration($departure_point_ID,0,0,0);
	});
	$(document).on('change', 'select[name=destination_ID]', function(ev){
		var $_this = $(this);
		var $departure_point_ID = $('select[name=departure_point_ID]').val();
		var $destination_ID = $_this.val();
		makeSelectCategory($departure_point_ID,$destination_ID,0);
		makeSelectboxDuration($departure_point_ID,$destination_ID,0,0);
	});
	$(document).on('change', 'select[name=cat_ID]', function(ev){
		var $_this = $(this);
		var $departure_point_ID = $('select[name=departure_point_ID]').val();
		var $destination_ID = $('select[name=destination_ID]').val();
		var $cat_ID = $_this.val();
		makeSelectboxDuration($departure_point_ID,$destination_ID,$cat_ID,0);
	});
	if($('.findBox').length > 0){
		var _hh = $(window).height();
		var _hc = $('#sliderHomePage').outerHeight(false);
		var _hd = _hc-_hh;
		$('.findBox').css('bottom',_hd+10);
	}
});
function makeSelectDestination($departure_point_ID, $city_id){
	$('select[name=destination_ID]').html('<option value="">Loading...</option>');
	var $_adata = {
		'departure_point_ID' : $departure_point_ID,
		'city_id' : $city_id
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDestination&lang='+LANG_ID,
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=destination_ID]').html(html);
		}
	});
}
function makeSelectCategory($departure_point_ID, $city_id, $cat_id){
	$('select[name=cat_ID]').html('<option value="0">Loading...</option>');
	var $_adata = {
		'departure_point_ID': $departure_point_ID,
		'city_id': $city_id,
		'cat_id': $cat_id
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectCategory&lang='+LANG_ID,
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=cat_ID]').html(html);
		} 
	});
}
function makeSelectboxDuration($departure_point_ID,$city_ID,$cat_ID,$duration_ID){
	$('select[name=duration_ID]').html('<option value="0">Loading...</option>');
	var adata = {
		'departure_point_id'    : $departure_point_ID,
		'city_id'    : $city_ID,
		'cat_id'    : $cat_ID,
		'duration_id'    : $duration_ID
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDuration&lang='+LANG_ID,
		data :adata,
		dataType:'html',
		success: function(html){
			$('select[name=duration_ID]').html(html);
		}
	});
}
</script>
{/literal}