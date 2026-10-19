<div id="form-search">
	<div class="frame-search">
		<div class="o-dl seachTour">
			<img src="{$URL_IMAGES}/home/ic_search_tour.png" alt="{$core->get_Lang('SEARCH TOUR')}" class="mg-b">
			<p class="text1">{$core->get_Lang('SEARCH TOUR')}</p>
		</div>
		<div class="o-dl seachCruise">
			<img src="{$URL_IMAGES}/home/ic_search_cruise.png" alt="{$core->get_Lang('SEARCH CRUISE')}" class="mg-b">
			<p class="text1">{$core->get_Lang('SEARCH CRUISE')}</p>
		</div>
		<div class="o-dl seachHotel">
			<img src="{$URL_IMAGES}/home/ic_search_hotel.png" alt="{$core->get_Lang('SEARCH HOTEL')}" class="mg-b">
			<p class="text1">{$core->get_Lang('SEARCH HOTEL')}</p>
		</div>
	</div>
	<div id="tours" class="tab-pane bg-seachTour" style="display:none">
		<div class="triangle-up"></div>
		<form class="" method="post" action="{$extLang}/">
				<div class="departure_point">
					<p>{$core->get_Lang('Search your ideas')}</p>
					<input type="text" name="key" value="" class="form-control search_texthome_2019" placeholder="Type Tour name or tour code">
				</div>
				<div class="select_find">
					<div class="form-group slb">
					<p>{$core->get_Lang('Departure point')}</p>
					<select class="form-control" name="departure_point_id" id="departure_point_ID">
		
						<option value="0">{$core->get_Lang('Select all')}</option>
						{section name=i loop=$lstDeparturePoint}
							<option value="{$lstDeparturePoint[i].city_id}" title="{$clsCity->getTitle($lstDeparturePoint[i].city_id)}">{$clsCity->getTitle($lstDeparturePoint[i].city_id)}</option>
						{/section}
					</select>
					</div>
					<div class="form-group slb">
						<p>{$core->get_Lang('Destination')}</p>
					<select class="form-control slb" name="destination_id" id="destination_ID">
						<option value="0">{$core->get_Lang('Select all')}</option>
						{section name=i loop=$listTopCity}
							<option value="{$listTopCity[i].city_id}">{$clsCity->getTitle($listTopCity[i].city_id)}</option>
						{/section}
					</select>
					</div>
				<div class="form-group slb">
					<p>{$core->get_Lang('Our Tours')}</p>
					<select class="form-control" name="cat_id" id="cat_ID">
						<option value="0">{$core->get_Lang('Select all')}</option>
						{section name=i loop=$lstCatTour}
							<option value="{$lstCatTour[i].tourcat_id}">{$clsTourCategory->getTitle($lstCatTour[i].tourcat_id)}</option>
						{/section}
					</select>
					</div>
					<div class="form-group slb">
						<p>{$core->get_Lang('Tour length')}</p>
					<select class="form-control" name="duration_id" id="duration_ID">
						{$DURATION_HTML}
					</select>
					</div>
				<button type="submit" class="btn btn-default" id="findtBtn">{$core->get_Lang('Search')}</button>
				<input type="hidden" name="Hid_Search" value="Hid_Search" />
				</div>
				<div class="address_find hidden-xs hidden-sm"><i class="fa fa-map-marker" aria-hidden="true"></i> {$core->get_Lang('Suggested destinations  >  Mekong Delta Tours  >  Vietnam Tour Packages  >  Day Trips In Ho Chi Minh City  > Cambodia Tours')}</div>
		</form>
	</div>
	<div id="cruise" class="tab-pane bg-seachCruise" style="display:none">
		<div class="triangle-up"></div>
		{$core->getBlock('find_cruise_home')}
	</div>
	<div id="hotel" class="tab-pane bg-seachHotel" style="display:none">
		<div class="triangle-up"></div>
		{$core->getBlock('find_hotel_home')}
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
	$("#che").click(function() {
		$("." + $("#che").attr('searchId')).click();
	})
	$(".seachTour").click(function() {
		$(".bg-seachTour").toggle(1, function() {
			if ($(this).is(':hidden')) {
				$(".a").removeClass('bg-black');
				$("#che").attr("searchId", "");
				$("#form-search").css("z-index", "initial");
				$("#form-search").css("position", "initial");
				$("#form-search").css("background", "#f1f1f1");
				//$("#form-search").css("margin-top", 0);
			}
			else {
				$(".a").addClass('bg-black ');
				$("#che").attr("searchId", "seachTour");
				$("#form-search").css("z-index", "99999999");
				$("#form-search").css("position", "relative");
				$("#form-search").css("background", "initial");
				//$("#form-search").css("margin-top", -160);
			}
		});
		if ($(".bg-seachCruise").css("display", "none")){}
		else {
			$(".bg-seachCruise").css("display", "none");
		}
		if ($(".bg-seachHotel").css("display", "none")){}
		else {
			$(".bg-seachHotel").css("display", "none");
		}
		event.stopPropagation();
	});
	$(".seachCruise").click(function() {
		$(".bg-seachCruise").toggle(1, function() {
			if ($(this).is(':hidden')) {
				$(".a").removeClass('bg-black');
				$("#che").attr("searchId", "");
				$("#form-search").css("z-index", "initial");
				$("#form-search").css("position", "initial");
				$("#form-search").css("background", "#f1f1f1");
				//$("#form-search").css("margin-top", 0);
			}
			else {
				$(".a").addClass('bg-black ');
				$("#che").attr("searchId", "seachCruise");
				$("#form-search").css("z-index", "99999999");
				$("#form-search").css("position", "relative");
				$("#form-search").css("background", "initial");
				//$("#form-search").css("margin-top", -160);
			}
		});
		if ($(".bg-seachTour").css("display", "none")) {}
		else {
			$(".bg-seachTour").css("display", "none");
		}
		if ($(".bg-seachHotel").css("display", "none")) {}
		else {
			$(".bg-seachHotel").css("display", "none");
		}
	});
	$(".seachHotel").click(function() {
		$(".bg-seachHotel").toggle(1, function() {
			if ($(this).is(':hidden')) {
				$(".a").removeClass('bg-black');
				$("#che").attr("searchId", "");
				$("#form-search").css("z-index", "initial");
				$("#form-search").css("position", "initial");
				$("#form-search").css("background", "#f1f1f1");
				//$("#form-search").css("margin-top", 0);
			}
			else {
				$(".a").addClass('bg-black ');
				$("#che").attr("searchId", "seachHotel");
				$("#form-search").css("z-index", "99999999");
				$("#form-search").css("position", "relative");
				$("#form-search").css("background", "initial");
				//$("#form-search").css("margin-top", -160);
			}
		});
		if ($(".bg-seachCruise").css("display", "none")) {}
		else {
			$(".bg-seachCruise").css("display", "none");
		}
		if ($(".bg-seachTour").css("display", "none")) {}
		else {
			$(".bg-seachTour").css("display", "none");
		}
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
<style type="text/css">
.boxWhyWithUs {
    padding: 50px 0 50px 0 !important;
}
.bg-black {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0px;
    left: 0px;
    background: rgba(0,0,0,0.8);
    z-index: 99;
}
#form-search {
	background: #f1f1f1;
    height: auto;
    padding-top: 10px;
    padding-bottom: 10px;
}
#form-search .frame-search {
    margin: 0px auto;
    display: table;
    margin-top: 0px;
    width: 100%;
}
#form-search .tab-pane{background:#fff; padding:15px 10px; margin-top:15px; position:relative;}
#form-search .o-dl {
    background: #fff;
    padding: 15px;
    height: 110px;
    margin: 0px auto;
    display: inline-table;
    text-align: center;
    border: 1px solid #ececec;
    cursor: pointer;
    float: left;
	width: calc((100% - 30px)/3);
    margin-right: 5px;
    margin-left: 5px;
    padding: 8px;
}
#form-search .frame-search img {
    height: 35px;
}
#form-search .frame-search .mg-b {
    margin-bottom: 10px;
}
#form-search .text1 {
    text-transform: uppercase;
    border-bottom: 1px dashed #4e4b4a;
    padding-bottom: 10px;
    color: #000;
    margin-bottom: 10px;
}
#form-search .bg-seachTour .triangle-up {
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 10px solid #fff;
    position: absolute;
    top: -10px;
    left: calc((100% - 20px)/6) !important;
}
#form-search .bg-seachCruise .triangle-up {
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 10px solid #fff;
    position: absolute;
    top: -10px;
    left: calc(50% - 10px) !important;
}
#form-search .bg-seachHotel .triangle-up {
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 10px solid #fff;
    position: absolute;
    top: -10px;
	right: calc((100% - 40px)/6) !important;
}
#form-search .btn-default{background:#f16f30; color:#fff; border:0;}
#form-search .form-control {
    display: block;
    width: 100%;
    height: 38px;
    padding: 8px 12px;
    font-size: 15px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc !important;
    border-radius: 0px  !important;
}
#form-search .departure_point{margin:0 !important; margin-bottom:10px !important;}
#form-search .departure_point p{display:none !important}
@media (max-width: 767px) {
	#form-search .tab-pane{
		display: inline-block;
		width: 100%;
	}
	.departure_point{
		width: 100% !important;
	}
	#form-search .form-control{
		border: none !important;
		box-shadow: none;
		border-bottom: 1px dashed #333 !important;
		width: 100% !important;
		padding-left: 0;
	}
}
</style>
{/literal}