<div class="container">
	<form class="find__trip--form" method="post" action="{$extLang}/">
		<div class="input_key_word">
			<input class="form-control" name="key" value="" autocomplete="off" placeholder="{$core->get_Lang('Search tour')}....">
		</div>
		<div class="form_select form_select_destination">
			<select class="form-control slb" name="departure_point_id" id="departure_point_ID" aria-label="{$core->get_Lang('Departure point')}">
				<option value="0">{$core->get_Lang('Departure point')}</option>
				{section name=i loop=$lstDeparturePoint}
				<option value="{$lstDeparturePoint[i].city_id}" title="{$clsCity->getTitle($lstDeparturePoint[i].city_id)}">{$clsCity->getTitle($lstDeparturePoint[i].city_id)}</option>
				{/section}
			</select>
		</div>
		<div class="form_select form_select_duration">
			<select class="form-control" name="duration_id" id="duration_ID" aria-label="{$core->get_Lang('Duration')}">
				{$DURATION_HTML}
			</select>
		</div>
		<button type="submit" class="btn btn_find_trip btn_main" id="findtBtn">{$core->get_Lang('Search')}</button>
		<input type="hidden" name="Hid_Search" value="Hid_Search" />
	</form>
</div>
<script>
	var cat_id= '{$cat_id}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
	var Loading = '{$core->get_Lang("Loading")}';
</script>
{literal}
<script>
	$(function(){
		$('select[name=departure_point_ID]').change(function(){
			var $_this = $(this);
			var $departure_point_ID = $_this.val();
			makeSelectDestination($_this.val());
			makeSelectboxDuration($departure_point_ID,0,0,0);
		});
		$(document).on('change', 'select[name=destination_id]', function(ev){
			var $_this = $(this);
			var $destination_ID = $_this.val();
			makeSelectboxDuration(0,$destination_ID,0,0);
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
		$('select[name=destination_ID]').html('<option value="">'+Loading+'...</option>');
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
		$('select[name=cat_ID]').html('<option value="0">'+Loading+'...</option>');
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
		$('select[name=duration_id]').html('<option value="0">'+Loading+'...</option>');
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
				$('select[name=duration_id]').html(html);
			}
		});
	}
</script>
{/literal}