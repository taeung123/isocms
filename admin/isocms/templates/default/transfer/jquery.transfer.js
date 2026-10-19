var aj_search = '';
$().ready(function() {
	$("#clienttabs .maps").live('click',function(){
			loadMaps(transfer_id);
	});
    if($('#tabsk a.current').length==0){
		$('#tabsk a:first').addClass('current');
	}
	$('#tabsk a').each(function(index){
		$(this).attr('data',index);});
		$('#lstTabs .contentTab').each(function(index){
			$(this).attr('id','tab-'+index);}
		);
		$('#lstTabs .contentTab:not(:first)').hide();
		$('#tabsk a').click(function(){
			var _this=$(this);
			$('#tabsk a.current').removeClass('current');
			_this.addClass('current');
			var cu_id=_this.attr('data');
			$('#lstTabs .contentTab:visible').hide();
			$('#tab-'+cu_id).show();
			return false;
	});
    $('.tour_available').live('change', function() {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajAddStartDate",
            data: {
                "transfer_id": $_this.attr("transfer_id"),
				"tour_start_date_id": $_this.attr("tour_start_date_id"),
                "allotment": $_this.val(),
				"is_agent": $_this.attr("is_agent"),
                "departure": $_this.attr("departure"),
                "tp": 'SaveAvailable'
            },
            dataType: "html",
            success: function(html) {
                loadTourPriceNewVersion($transfer_id);
            }
        });
    });
   
   
	$(document).on('change', '#countryitinerary', function(ev) {
		var $_this = $(this);
		if (parseInt($_this.val()) > 0) {
			if ($SiteActive_region == '1') {
				loadRegionItinerary($_this.val());
				$('#cityitinerary').hide();
			} else {
				loadCityItinerary($_this.val());
			}
		} else {
			$('#regionitinerary').hide();
			$('#cityitinerary').hide();
			
		}
	});
	$(document).on('change', '#regionitinerary', function(ev) {
		var $_this = $(this);
		if ($SiteModActive_country == '1') {
			var $country_id = $('#countryitinerary').val();
			if ($country_id == undefined) {
				$country_id = 1;
			}
			loadCityItinerary($country_id, $_this.val());
		} else {
			loadCityItinerary(0, $_this.val());
		}
	});
   
});
if (mod == 'transfer' && act == 'edit') {
    function loadCityHotelList() {
        $('select[name=cityhotel_id]').html('<option value="0">-- ' + cities + '--</option>');
        var $country_id = $('select[name=countryhotel_id]').val();
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectCityHotelGlobal",
            data: {
                "country_id": $country_id
            },
            dataType: "html",
            success: function(html) {
                vietiso_loading(0);
                if (html.replace(' ', '') != '') {
                    $('select[name=cityhotel_id]').html(html).show();
                } else {
                    $('select[name=cityhotel_id]').html('<option value="0">-- ' + cities + ' --</option>').hide();
                }
            }
        });
    }
	$(document).on('change', '.transfer_car_price', function(ev){
		var $_this = $(this);
		
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/?mod="+mod+"&act=ajOpenManageTransferCarPrice",
			data:{
				'transfer_id':$_this.attr("transfer_id"),
				'car_id':$_this.attr("car_id"),
				"type_of_trip_id":$_this.attr("type_of_trip_id"),
				"price":$_this.val(),
				'tp' : 'S'
			},
			dataType: "html",
			success: function(html){
				vietiso_loading(1);
				var htm = html.split('|||');
				$_this.val(htm[1]);
				vietiso_loading(5);
			}
		}); 
	});
	$(document).on('change', '#slb_Country_Departurepoint', function(ev) {
		var $_this = $(this);
		loadRegionDeparturepoint($_this.val(),0);
		loadCityDeparturepoint($_this.val(),0,0);
	});
	$(document).on('change', '#slb_Region_Departurepoint', function(ev) {
		var $_this = $(this);
		var $country_id = $('#slb_Country_Departurepoint').val();
		loadCityDeparturepoint($country_id, $_this.val());
	});
	$(document).on('change', '#slb_Country_Endpoint', function(ev) {
		var $_this = $(this);
		loadRegionEndpoint($_this.val(),0);
		loadCityEndpoint($_this.val(),0,0);
	});
	$(document).on('change', '#slb_Region_Endpoint', function(ev) {
		var $_this = $(this);
		var $country_id = $('#slb_Country_Endpoint').val();
		loadCityEndpoint($country_id, $_this.val());
	});
    function loadListHotelItinerary($transfer_id, $tour_itinerary_id, $keyword) {
        var adata = {
            'transfer_id': $transfer_id,
            'tour_itinerary_id': $tour_itinerary_id,
            'keyword': $keyword
        };
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadHotelItinerary',
            data: adata,
            dataType: "html",
            success: function(html) {
                $('#lstHotel').html(html);
                vietiso_loading(0);
            }
        });
    }

    function initSysGalleryTransfer() {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajInitTSysTransferGallery',
            data: {
                'table_id': transfer_id
            },
            dataType: "html",
            success: function(html) {
                $('#TransferGalleryHolder').html(html);
                loadTableGallery(transfer_id, '', 1, 10);
            }
        });
    }

    function loadTableGallery(table_id, keyword, $page, $number_per_page) {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajOpenTransferGallery',
            data: {
                'table_id': table_id,
                'keyword': keyword,
                'page': $page,
                'number_per_page': $number_per_page,
                'tp': 'L'
            },
            dataType: "html",
            success: function(html) {
                //console.log(html);
                var $htm = html.split('$$$');
                $('#preview').html($htm[0]);
                $('#gallery_paginate').html($htm[1]);
            }
        });
    }

}
/* END READY FUNCTION */
function checkSellActive() {
    $('.chkSell').each(function() {
        var $_this = $(this);
        var $id = $_this.attr('id');
        var $s = $id.split('_');
        var $cu = $s[1] + '_' + $s[2];
        if ($_this.is(':checked') == false) {
            $('#input_' + $cu).attr('disabled', 'disabled');
            $('#input_sale_' + $cu).attr('disabled', 'disabled');
            $('#input_avai_' + $cu).attr('disabled', 'disabled');
            $('#input_price_' + $cu).attr('disabled', 'disabled');
            $('#input_price_old_' + $cu).attr('disabled', 'disabled');
        } else {
            $('#input_' + $cu).removeAttr('disabled');
            $('#input_sale_' + $cu).attr('disabled', 'disabled');
            $('#input_avai_' + $cu).attr('disabled', 'disabled');
            $('#input_price_' + $cu).removeAttr('disabled');
            $('#input_price_old_' + $cu).removeAttr('disabled');
        }
    });
}

function loadSlotAvailable($transfer_id, $pp_month, $pp_year, $is_type_table) {
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajOpenSotAvailable',
        data: {
            'tp': 'L',
            "transfer_id": $transfer_id,
            "pp_month": $pp_month,
            "pp_year": $pp_year,
            "is_type_table": $is_type_table
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#slotAvailableContainer').html(html);
            checkSellActive();
        }
    });
}


function loadCountry($chauluc_id, $khuvuc_id, $country_id) {
    $('#slb_Country').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadCountry",
        data: {
            "chauluc_id": $chauluc_id,
            "khuvuc_id": $khuvuc_id,
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_Country').hide();
            } else {
                $('#slb_Country').html(html).show();
            }
            /**/
            $('#slb_RegionID').hide();
            $('#slb_CityID').hide();
			$('#slb_placetogoID').hide();
        }
    });
}

function loadRegion($country_id, $region_id) {
    $('#slb_RegionID').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadRegion",
        data: {
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_RegionID').hide();
            } else {
                $('#slb_RegionID').html(html).show();
            }
        }
    });
}
function loadRegionDeparturepoint($country_id, $region_id) {
    $('#slb_Region_Departurepoint').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadRegion",
        data: {
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_Region_Departurepoint').hide();
            } else {
                $('#slb_Region_Departurepoint').html(html).show();
            }
        }
    });
}
function loadCityDeparturepoint($country_id, $region_id, $city_id, $transfer_id) {
    $('#slb_CityID').html('<option value="0">' + loading + '</option>');
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectCityGlobal",
        data: {
            "country_id": $country_id,
            "region_id": $region_id,
            'city_id': $city_id,
            'transfer_id': $transfer_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_City_Departurepoint').hide();
            } else {
                $('#slb_City_Departurepoint').html(html).show();
            }
        }
    });
}
function loadRegionEndpoint($country_id, $region_id) {
    $('#slb_Region_Endpoint').html('<option value="0">' + loading + '</option>')
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajLoadRegion",
        data: {
            "country_id": $country_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_Region_Endpoint').hide();
            } else {
                $('#slb_Region_Endpoint').html(html).show();
            }
        }
    });
}
function loadCityEndpoint($country_id, $region_id, $city_id, $transfer_id) {
    $('#slb_CityID').html('<option value="0">' + loading + '</option>');
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectCityGlobal",
        data: {
            "country_id": $country_id,
            "region_id": $region_id,
            'city_id': $city_id,
            'transfer_id': $transfer_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_City_Endpoint').hide();
            } else {
                $('#slb_City_Endpoint').html(html).show();
            }
        }
    });
}
function loadPlaceTogo($country_id, $city_id) {
    $('#slb_placetogoID').html('<option value="0">' + loading + '</option>');
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectPlaceToGoGlobal",
        data: {
            "country_id": $country_id,
            'city_id': $city_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            if (html.indexOf('EMPTY') >= 0) {
                $('#slb_placetogoID').hide();
            } else {
                $('#slb_placetogoID').html(html).show();	
            }
        }
    });
}


function loadListDestination($transfer_id) {
    vietiso_loading(1);
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=' + mod + '&act=ajaxLoadTourDestination',
        data: {
            "transfer_id": $transfer_id
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $('#lstDestination').html(html);
			loadMaps($transfer_id);
        }
    });
}




function isoman_callback() {
    $xx = isoman_selected_files();
}
