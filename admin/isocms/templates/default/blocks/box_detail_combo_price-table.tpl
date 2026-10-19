<div class="form_option_tour">
	<h3 class="title_box mb05">{$core->get_Lang('Price Tabel')}</h3>
	<p class="intro_box mb40">{$core->get_Lang('introcombopricetable')}</p>
	<div id="combo_price_table">
	
	</div>
	
</div>
{literal}
<script>
$(document).ready(function() {
loadComboPriceTable(table_id);

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
			url: path_ajax_script + '/?mod=' + mod + '&act=ajaxDeleteTourDestination',
			data: {
				"tour_destination_id": $_this.attr('data')
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
				loadListDestination($table_id);
			}
		});
		return false;
	}
});

})
</script>
{/literal}