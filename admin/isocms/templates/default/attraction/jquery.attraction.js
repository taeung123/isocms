$().ready(function() {
	var $ok = true;
	$(document).on('click', '.clickShowMap', function(){
		if($ok){
			$('#HotelMap_Area').show();
			initialize();
			$ok = false;
		}else{
			$('#HotelMap_Area').hide();
			$ok = true;
		}
		return false;
	});
	
	if($Hotel_Region=='1'){loadRegion(country_id, region_id);}
		
		/* HOTEL_CUSTOM_FIELD */
	loadCity(country_id, region_id, city_id);
	loadAreaCity(city_id, area_city_id);
	/* FUNC */
	$(document).on('change', 'select[name=iso-continent_id]', function(ev){
		var $_this = $(this);
		var title = $_this.find('option:selected').attr('title');
		$('#slb_Country').html('<option value="0">'+loading+'</option>');
		$('#slb_Area').html('<option value="0">-- '+regions+' --</option>');
		$('#slb_City').html('<option value="0">-- '+cities+' --</option>');
		$('#slb_AreaCity').html('<option value="0">-- '+areacity+' --</option>');
		loadCountry($_this.val(),0);
	});
	$(document).on('change', 'select[name=iso-area_id]', function(ev){
		var $_this = $(this);
		var $country_id = $('select[name=iso-country_id]').val();
		if($country_id=='undefined' || $country_id == undefined){
			$country_id = 0;
		}
		loadCity($country_id, $_this.val(),0);
	});
	$(document).on('change', 'select[name=iso-country_id]', function(ev){
		var $_this = $(this);
		if($Hotel_Region=='1'){
			loadRegion($_this.val(),0);
		}
		
		loadCity($_this.val(),0,0);
	});
	$(document).on('change', 'select[name=iso-region_id]', function(ev){
		var $_this = $(this);
		var $country_id = $('select[name=iso-country_id]').val();
		if($country_id==undefined){
			$country_id = 0;
		}
		loadCity($country_id, $_this.val(),0);
	});
	$(document).on('change', 'select[name=iso-city_id]', function(ev){
		var $_this = $(this);
		loadAreaCity($_this.val(),0);
		loadHotelAttraction($_this.val(),0);
	});
});

function getLocationZ() {
    var country = $('select[name=iso-country_id]').find('option:selected').attr('title');
    var city = $('select[name=iso-city_id]').val();
}
function loadArea($continent_id, $area_id) {
    $('#slb_Area').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=attraction&act=loadArea',
        data: {
			"continent_id": $continent_id,
			'area_id': $area_id
		},
        dataType: "html",
        success: function(html) {
            $('#slb_Area').html(html);
        }
    });
}
function loadCountry($continent_id, $country_id) {
    $('#slb_Country').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=attraction&act=loadCountry',
        data: {
			"country_id": $country_id,
			'continent_id': $continent_id
		},
        dataType: "html",
        success: function(html) {
            $('#slb_Country').html(html);
        }
    });
}
function loadRegion($country_id, $region_id) {
    $('#slb_Region').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=attraction&act=loadRegion',
        data: {"country_id": $country_id,'region_id': $region_id},
        dataType: "html",
        success: function(html) {
            $('#slb_Region').html(html);
        }
    });
}
function loadCity($country_id, $region_id, $city_id) {
	$('#slb_City').html('<option value="0">'+loading+'</option>');
	if(parseInt($Hotel_Region)>0) {var $region_id = $region_id;} else {var $region_id = 0;}
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=attraction&act=loadCity',
        data: {
			"country_id": $country_id,
			"region_id": $region_id,
			'city_id': $city_id
		},
        dataType: "html",
        success: function(html) {
			$('#slb_City').html(html);
        }
    });
}
function loadAreaCity($city_id, $area_city_id) {
	$('#slb_AreaCity').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=attraction&act=loadAreaCity',
        data: {
			'city_id': $city_id,
			'area_city_id': $area_city_id
		},
        dataType: "html",
        success: function(html) {
			$('#slb_AreaCity').html(html);
        }
    });
}

