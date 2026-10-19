<div class="form_option_tour">
	<h3 class="title_box mb05">{$core->get_Lang('Destination')}</h3>
	<p class="intro_box mb40">{$core->get_Lang('introdestination')}</p>
	<div class="inpt_tour">
		<div class="select_destination">
			<select id="slb_CountryID" class="form-control form-control-50" name="country_id" data-width="100%">
			<option value="0">{$core->get_Lang('Select country')}</option>
			</select> 
			<select id="slb_RegionID" class="form-control form-control-50" name="region_id" data-width="100%">
				<option value="0">{$core->get_Lang('selectregion')}</option>
			</select>
			<select id="slb_CityID" class="form-control form-control-50" name="city_id" data-width="100%">
				<option value="0">{$core->get_Lang('selectcity')}</option>
			</select> 
			<div class="form-group">
				<button class="btn btn-submit ajQuickAddDestination" type="button">
					{$core->get_Lang('Choose')}
				</button>
			</div>
		</div>
		<hr class="clearfix" />
		<div class="mt-half">
			<ul class="list-group" id="lstDestination">
				<li>{$core->get_Lang('Loading')}...</li>
			</ul>
		</div>
	</div>
	<h3 class="title_box mb05">{$core->get_Lang('Khách sạn áp dụng')}</h3>
	<p class="note">Lựa chọn khách sạn tại <span id="lstDestination2"></span> để áp dụng cho combo (có thẻ chọn nhiều)</p>
	<div class="inpt_tour">
		<div class="hastable">
			<table class="full-width tbl-grid table_responsive" cellspacing="0">
				<thead>
				<tr>
					<th class="gridheader hiden_responsive" style="width: 50px; text-align: left">ID</th>
					<th class="gridheader name_responsive name_responsive2" style="text-align:left"><strong>{$core->get_Lang('Hotel name')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left; width: 120px;"><strong>{$core->get_Lang('Ngày áp dụng')}</strong></th>
					<th class="gridheader hiden_responsive" style="width: 50px"></th>
				</tr>
				</thead>
				<tbody id="tblComboHotel"></tbody>
			</table>
		</div>
		<a href="javascript:void(0);" id="clickToAddHotel" class="btn_addhotel" title="{$core->get_Lang('addhotel')}">+ {$core->get_Lang('addhotel')}</a>
	</div>
</div>
{literal}
<script>
loadListDestination(table_id);
loadListHotelCombo(table_id);
setSelectBoxDestinationCombo();
$(document).on('change', '#slb_CountryID', function(ev) {
	var $_this = $(this);
	if (parseInt($_this.val()) > 0) {
		if ($SiteActive_region == '1') {
			loadRegionCombo($_this.val());
			$('#slb_CityID').hide();
			$('#slb_placetogoID').hide();
		} else {
			loadCityCombo($_this.val());
		}
	} else {
		$('#slb_RegionID').hide();
		$('#slb_CityID').hide();
		$('#slb_placetogoID').hide();

	}
});
$(document).on('change', '#slb_RegionID', function(ev) {
	var $_this = $(this);
	if ($SiteModActive_country == '1') {
		var $country_id = $('#slb_CountryID').val();
		if ($country_id == undefined) {
			$country_id = $('#Hid_Country').val();
		}
		loadCityCombo($country_id, $_this.val());
	} else {
		loadCityCombo(0, $_this.val());
	}
});
// Destination
$(document).on('click', '.ajQuickAddDestination', function(ev) {
	var $_this = $(this);
	var $country_id = $('#slb_CountryID').val();
	var $region_id = $('#slb_RegionID').val();
	var $city_id = $('#slb_CityID').val();

	var adata = {};
	adata['country_id'] = $country_id;
	adata['region_id'] = $region_id;
	adata['city_id'] = $city_id;
	adata['table_id'] = table_id;

	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=' + mod + '&act=ajaxAddMoreComboDestination',
		data: adata,
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_SUCCESS') >= 0) {
				loadListDestination(table_id);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
		}
	});
	return 0;
});
$(document).on('click', '.removeDestination', function(ev) {
	var $_this = $(this);
	if (confirm(confirm_delete)) {
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=' + mod + '&act=ajaxDeleteComboDestination',
			data: {
				"combo_destination_id": $_this.attr('data')
			},
			dataType: "html",
			success: function(html) {
				vietiso_loading(0);
				var $country_id = $('#slb_CountryID').val();
				if ($country_id == undefined) {
					$country_id = $('#Hid_Country').val();
				}
				if ($('#slb_CityID').is(':visible')) {
					loadCityCombo($country_id, $('#slb_RegionID').val());
				}
				loadListDestination(table_id);
			}
		});
		return false;
	}
});
$(document).on('click', '.ajRemoveAllDestinationInTour', function(ev) {
	var $_this = $(this);
	if (confirm(confirm_delete)) {
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=' + mod + '&act=ajaxDeleteAllTourDestination',
			data: {
				"combo_id": table_id
			},
			dataType: "html",
			success: function(html) {
				vietiso_loading(0);
				var $country_id = $('#slb_CountryID').val();
				if ($country_id == undefined) {
					$country_id = $('#Hid_Country').val();
				}
				if ($('#slb_CityID').is(':visible')) {
					loadCityCombo($country_id, $('#slb_RegionID').val());
				}
				loadListDestination(table_id);
			}
		});
		return false;
	}
});
$(document).on('click', '#clickToAddHotel', function(ev) {
	var $_this = $(this);
	var adata = {};
	adata['table_id'] = table_id;
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxGetBoxHotelCombo',
		dataType: "html",
		data: adata,
		success: function(html){
			makepopup('700px', 'auto', html, 'pop_HotelCombo');
			$('#pop_HotelCombo').css('top', '30px');
			vietiso_loading(0);
		}
	});
	return false;
});
$(document).on('click', '.clickDeleteHotelCombo', function(ev){
	var _this = $(this),
		combo_id =  _this.data('combo_id'),
		hotel_id =  _this.data('hotel_id');
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSaveHotelCombo",
		data: {"combo_id":combo_id,"hotel_id":hotel_id,"tp":'DEL'},
		dataType: "html",
		success: function(html){
			loadListHotelCombo(combo_id);
		}
	});
});
$(document).on('click', '.clickEditHotelCombo', function(ev) {
	var _this = $(this),
		combo_id =  _this.data('combo_id'),
		hotel_id =  _this.data('hotel_id');
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxGetBoxHotelCombo',
		dataType: "html",
		data: {"table_id":combo_id,"hotel_id":hotel_id,"tp":'EDIT'},
		success: function(html) {
			makepopup('700px', 'auto', html, 'pop_HotelCombo');
			$('#pop_HotelCombo').css('top', '30px');
			vietiso_loading(0);
		}
	});
	return false;
});
$(document).on('click', '#add_hotel_combo', function(ev){
	var _this = $(this);
	var adata = $("#form_add_hotel_combo").serialize();
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSaveHotelCombo",
		data: adata,
		dataType: "html",
		success: function(html){
			if (html.indexOf('ERROR_DAY') >= 0) {
				alertify.error('Vui lòng chọn ngày Áp dụng');
			}else if(html.indexOf('ERROR_HOTEL') >= 0) {
				alertify.error('Vui lòng chọn khách sạn Áp dụng');
			}else{
				vietiso_loading(0);
				loadListHotelCombo(table_id);
				_this.closest('.frmPop').find('.close_pop').trigger('click');
				return false;
			}

		}
	});
});
</script>
{/literal}