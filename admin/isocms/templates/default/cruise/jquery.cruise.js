$().ready(function(){
	// Page Cruise - Mod: Cruise - Act: Edit
	if(mod == 'cruise' && act== 'edit_itinerary') {
		if($SiteHasDestinationCruises == '1'){loadListDestination($cruise_itinerary_id);}
		// Cruise Destination
		if($SiteHasDestinationCruises == '1') {
			setSelectBoxDestination();
			
			if($SiteModActive_continent == 0 && $SiteModActive_country == 1){
				loadCountry();
			}
			if($SiteModActive_continent == 0 && $SiteModActive_country == 0 && $SiteModActive_country == 0){
				loadCity();
			}
			
			$(document).on('change', '#slb_Chauluc', function(ev){
				var $_this=$(this);
				if(parseInt($_this.val()) > 0){
					loadCountry($_this.val());
				}else{
					$('select[name=country_id]').html('<option value="0"><< '+country+' >></option>').hide();	
					$('select[name=region_id]').html('<option value="0"><< '+regions+' >></option>').hide();
					$('select[name=city_id]').html('<option value="0"><< '+cities+' >></option>').hide();
				}
			});
			$(document).on('change', '#slb_Country', function(ev){
				var $_this = $(this);
                if (parseInt($_this.val()) > 0) {
                    if ($SiteActive_region == '1') {
                        loadRegion($_this.val());
                        $('#slb_CityID').hide();
						$('#slb_placetogoID').hide();
                    }else{
						loadCity($_this.val());
						$('#slb_placetogoID').hide();
					}
                } else {
                    $('#slb_RegionID').hide();
                    $('#slb_CityID').hide();
					$('#slb_placetogoID').hide();
					
                }
			});
			$(document).on('change', '#slb_RegionID', function(ev){
				var $_this=$(this);
				var $country_id = $('#slb_Country').val();
				if($country_id==undefined){
					$country_id = $('#Hid_Country').val();
				}
				loadCity($country_id, $_this.val());
			});
			$(document).on('change', '#slb_CityID', function(ev) {
                var $_this = $(this);
                if ($SiteModActive_country == '1') {
                    var $country_id = $('#slb_Country').val();
                    if ($country_id == undefined) {
                        $country_id = $('#Hid_Country').val();
                    }
                    loadPlaceTogo($country_id, $_this.val());
                } else {
                    loadPlaceTogo(0, $_this.val());
                }
            });
			// Destination
			$(document).on('click', '.ajQuickAddDestination', function(ev){
				var $_this = $(this);
				
				if($SiteModActive_continent == '1') {
					var $chauluc_id = $('#slb_Chauluc').val();
					if($chauluc_id==undefined){
						$chauluc_id = 0;
					}
				}
				if($SiteActive_region == '1') {
					var $area_id = $('#slb_AreaID').val();
					if($area_id==undefined){
						$area_id = 0;
					}
				}
				if($SiteModActive_country == '1') {
					var $country_id = $('#slb_Country').val();
					if($country_id==undefined || $country_id==0){
						var $countryID = $('#slb_Country');
						setSelectOpen($countryID);
					}
					if($country_id==0 || $city_id==0){
						alertify.error('Error !');
						return false;
					}
				}
				if($SiteActive_region == '1') {
					var $region_id = $('#slb_RegionID').val();
					if($region_id==undefined){
						$region_id = 0;
					}
				}
				if($SiteActive_city == '1') {
					var $city_id = $('#slb_CityID').val();
					if($city_id==undefined){
						$city_id = 0;
					}
				}
				if($SiteActive_destination == '1') {
					var $destination_id = $('#slb_Destination').val();
					if($destination_id==undefined){
						$destination_id = 0;
					}
				}
				var $placetogo_id = $('#slb_placetogoID').val();
	
				/**/
				var adata = {};
				if($SiteModActive_continent == '1') {adata['chauluc_id'] = $chauluc_id;}
				if($SiteActive_region == '1') {adata['area_id'] = $area_id;}
				if($SiteModActive_country == '1') {adata['country_id'] = $country_id;}
				if($SiteActive_region == '1') {adata['region_id'] = $region_id;}
				if($SiteActive_city == '1') {adata['city_id'] = $city_id;}
				if($SiteActive_destination == '1') {adata['destination_id'] = $destination_id;}
				adata['cruise_id'] = $cruise_id;
				adata['cruise_itinerary_id'] = $cruise_itinerary_id;
				adata['placetogo_id'] = $placetogo_id;
				
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajaxAddMoreCruiseDestination',
					data: adata,
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						if(html.indexOf('_SUCCESS')>=0){
							loadListDestination($cruise_itinerary_id);
							if($SiteModActive_continent == '1') {
								loadChauLuc();
							}else{
                                loadCountry();
                            }
							if($SiteActive_region == '1') {
								$('#slb_AreaID').val('');
								$('#slb_AreaID').hide(); 
							}
							if($SiteModActive_country == '1') {
								$('#slb_Country').val('');
								$('#slb_Country').hide(); 
							}
							if($SiteActive_region == '1') {
								$('#slb_RegionID').val('');
								$('#slb_RegionID').hide(); 
							}
							if($SiteActive_city == '1') {
								$('#slb_CityID').val('');
								$('#slb_CityID').hide(); 
							}
						}
						if(html.indexOf('_EXIST')>=0){
							alertify.error(exist_error);
						}
					}
				});
				return 0;
			});
			$(document).on('click', '.removeDestination', function(ev){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteCruiseDestination',
						data:{"cruise_destination_id" : $_this.attr('data')},
						dataType: "html",
						success: function(html){
							vietiso_loading(0);
							var $country_id = $('#slb_Country').val();
							if($country_id==undefined){
								$country_id = $('#Hid_Country').val();
							}
							if($('#slb_CityID').is(':visible')){
								loadCity($country_id, $('#slb_RegionID').val());
							}
							loadListDestination($cruise_itinerary_id);
						}
					});
					return false;
				}
			});
			$(document).on('click', '.ajRemoveAllDestinationInCruise', function(ev){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteAllCruiseDestination',
						data:{"cruise_id" : $cruise_id},
						dataType: "html",
						success: function(html){
							vietiso_loading(0);
							var $country_id = $('#slb_Country').val();
							if($country_id==undefined){
								$country_id = $('#Hid_Country').val();
							}
							if($('#slb_CityID').is(':visible')){
								loadCity($country_id, $('#slb_RegionID').val());
							}
							loadListDestination($cruise_itinerary_id);
						}
					});
					return false;
				}
			});
			$(document).on('click', '.ajClickAddCity', function(ev){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				var $chauluc_id = $_form.find('select[name=chauluc_id]');
				var $area_id = $_form.find('select[name=area_id]');
				
				var $country_id = $_form.find('select[name=country_id]');
				if($country_id.val()=='' || $country_id.val()=='0'){
					$country_id.focus();
					alertify.error(field_is_required);
					return false;
				}
				
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadFormAddQuickCity',
					dataType: "html",
					data: {
						'country_id': $country_id.val(),
						'chauluc_id': $chauluc_id.val(),
						'area_id'	: $area_id.val(),
						'forid'		: $_this.attr('forid')
					},
					success: function(html){
						makepopup('400px', '', html, 'cmsbox_BoxAddCity');
						vietiso_loading(0);
					}
				});
			});
			$(document).on('click', '.ajSubmitQuickCity', function(ev){
				var $_this = $(this);
				var $forid = $_this.attr('forid');
				var $country_id = $_this.attr('country_id');
				if($('#cmsbox_BoxAddCity input[name=title]').val()==''){
					$('#cmsbox_BoxAddCity input[name=title]').focus();
					alertify.error(field_is_required);
					return false;
				}
				
				var $chauluc_id = $_this.attr('chauluc_id');
				var $area_id = $_this.attr('area_id');
				
				vietiso_loading(1);
				var adata = {
					'city_id' : $_this.attr('data'),
					'title'	: $('#cmsbox_BoxAddCity input[name=title]').val(),
					'country_id': $country_id,
					'chauluc_id': $chauluc_id,
					'area_id'	: $area_id
				};
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSubmitQuickCity',
					data: adata,
					dataType: "html",
					success: function(html){
						if(html.indexOf('_SUCCESS')>=0){
							alertify.success(insert_success);
							$('#cmsbox_BoxAddCity .close_pop').trigger('click');
							loadCity($country_id);
						}
						if(html.indexOf('_ERROR')>=0){
							alertify.success(insert_error);
						}
						if(html.indexOf('_EXIST')>=0){
							alertify.success(exist_error);
						}
						vietiso_loading(0);
					}
				});
			});
		}
	}
	if(mod == 'cruise' && act== 'edit') {
		var hash_check=window.location.hash;
		
		/*if($SiteHasDestinationCruises == '1' && hash_check=='#isotab3'){loadListDestination($cruise_id);}*/
		if($SiteHasGalleryImagesCruises == '1' && hash_check=='#isotab4'){initSysGalleryCruise();}
		if($SiteHasCruisesCabin == '1' && hash_check=='#isotab1'){loadListCruiseCabin($cruise_id);}
		loadListCruiseFacilities('CruiseFacilities',$cruise_id);
		loadListCruiseFaActivities('CruiseFaActivities',$cruise_id);
		
		$(".chosen-select").chosen({max_selected_options: 10,width:'100%'});
		
		$('.changeToStore').live('change',function(){
			var $_this = $(this);
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod='+mod+'&act=ajUpdateCruiseStore',
				data:{'_type' : $_this.attr('_type'),'cruise_id': $_this.attr('data'),'val' : $_this.is(':checked')?1:0},
				dataType:'html',
				success: function(html){
		
				}
			});
		});
		
		/* CRUISE_CUSTOM_FIELD */
		if($SiteHasCustomField_Cruise == '1'){
			loadCustomField($cruise_id);
			$(document).on('click', '.ClickCustomField', function(ev){
				var $_this=$(this);
				vietiso_loading(1);	
				$.ajax({	
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=SiteCruiseCustomField',	
					data: {"cruise_id" : $cruise_id, 'tp' : 'C'},	
					dataType: "html",	
					success: function(html){
						vietiso_loading(0);
						location.href = REQUEST_URI;
					}	
				});		
				return false;	
			});
			$(document).on('click', '.btndelete_customfield', function(ev){
				if(confirm(confirm_delete)){
					var $_this = $(this);
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteCruiseCustomField",
						data: {'cruise_customfield_id' : $_this.attr('data'), 'tp' : 'D'},
						dataType: "html",
						success: function(html){
							vietiso_loading(0);
							location.href = REQUEST_URI;
						}
					});
				}
				return false;	
			});
			$(document).on('click', '.btnedit_customfield', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteCruiseCustomField",
					data: {'tp': 'F', 'cruise_customfield_id' : $_this.attr('data'), 'cruise_id' : $_this.attr('cruise_id')},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						makepopup(300,'auto',html,'pop_UpdateFieldName');
					}
				});
				return false;
			});
			$(document).on('click', '.SiteClickUpdateFieldName', function(ev){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				var $fieldname = $_form.find('input[name=fieldname]');
				if($fieldname.val()==''){
					$fieldname.focus();
					alertiy.error(field_is_required);
					return false;
				}
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteCruiseCustomField",
					data: {
						'tp': 'S',
						'cruise_customfield_id' : $_this.attr('cruise_customfield_id'),
						'cruise_id' : $_this.attr('cruise_id'),
						'fieldname' : $fieldname.val()
					},
					dataType: "html",
					success: function(html){
						if(html.indexOf('_EXIST') >= 0){
							alertify.error('Error !');
						}else{
							loadCustomField($_this.attr('cruise_id'));
							$_form.find('.close_pop').trigger('click');
						}
						vietiso_loading(0);
						location.href = REQUEST_URI;
					}
				});
				return false;
			});
			$(document).on('click', '.btnmove_customfield', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteCruiseCustomField",
					data: {
						'tp' : 'M',
						'cruise_id' : $_this.attr('cruise_id'),
						'direct' : $_this.attr('direct'),
						'cruise_customfield_id' : $_this.attr('data')
					},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						
						location.href = REQUEST_URI;
					}
				});	
				return false;
			});
		}
		/* END_TOUR_CUSTOM_FIELD */
		
		// Cruise Cabin
		if($SiteHasCruisesCabin == '1') {
			$(document).on('click', '.clickToAddCruiseCabin', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseCabin',
					data: {'cruise_id' : $cruise_id,'tp' : 'F'},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						makepopupnotresize('80%','auto',html,'pop_FrmCruiseCabin');
						$('#pop_FrmCruiseCabin').css('top',30+'px');
						var editor_id = $('.textarea_content_editor').attr('id');
						$('#'+editor_id).isoTextAreaFix();
						$("#priceInput").priceFormat({
							thousandsSeparator: '.',
							centsLimit: 0
						});
					}
				});
			});
			$(document).on('click','.clickToEditCruiseCabin',function(ev){
				var _this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseCabin',
					data: {'cruise_cabin_id' : _this.attr('data'),'cruise_id': _this.attr('cruise_id'),'tp' : 'F'},
					dataType:'html',
					success: function(html){
						vietiso_loading(0);
						makepopupnotresize('90%','auto',html,'pop_FrmHotelRoom');
						$('#pop_FrmHotelRoom').css('top',30+'px');
						var editor_id = $('.textarea_content_editor').attr('id');
						$('#'+editor_id).isoTextAreaFix();
						$("#priceInput").priceFormat({
							thousandsSeparator: '.',
							centsLimit: 0
						});
					}
				});
			});
			$(document).on('click', '.clickToSubmitCruiseCabin', function(ev){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				
				if(!$_this.hasClass('disabled')){
					var $title = $_form.find('input[name=title]');
					var $image = $_form.find('#isoman_hidden_image_room');
					var $list_cabin_facilities = getCheckBoxValueByClass('cabin_fa');
					
					if($.trim($title.val())=='') {
						$title.addClass('error').focus();
						alertify.error(field_is_required);
						return false;
					}
					var adata = {
						'cruise_cabin_id' 		: $_this.attr('cruise_cabin_id'),
						'cruise_id'				: $_this.attr('cruise_id'),
						'list_cabin_facilities'	: $_this.attr('list_cabin_facilities'),
						'image'	  				: $image.val(),
						'title'	  				: $title.val(),
						'tp'	  				: 'S'
					};
					vietiso_loading(1);
					$_this.addClass('disabled');
					$('#frmCruiseCabin').ajaxSubmit({
						type: "POST",
						url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseCabin',
						data: adata,
						dataType: "html",
						success: function(html){
							console.log(html); 
							vietiso_loading(0);
							$_this.removeClass('disabled');
							if(html.indexOf('_IN_SUCCESS')>=0){
								loadListCruiseCabin($cruise_id);
								alertify.success(insert_success);
								$_form.find('.close_pop').trigger('click');
							}
							if(html.indexOf('_UPDATE_SUCCESS')>=0){
								loadListCruiseCabin($cruise_id);
								alertify.success(update_success);
								$_form.find('.close_pop').trigger('click');
							}
							if(html.indexOf('_ERROR')>=0){ alertify.error(insert_error);}
							if(html.indexOf('_EXIST')>=0){ alertify.error(exist_error);}
						}
					});
				}
				return false;
			});
			$(document).on('click', '.clickToDeleteCruiseCabin', function(ev){
				var _this = $(this);
				if(confirm(confirm_delete)){
					$.ajax({
						type: 'POST',
						url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseCabin',
						data: {'cruise_cabin_id':_this.attr('data'),'tp':'D'},
						dataType:'html',
						success: function(html){
							loadListCruiseCabin($cruise_id);
							alertify.success(delete_success);
						}
					});
				}
				return false;
			});	
			$(document).on('click', '.moveCruiseCabin', function(ev){
				var _this = $(this);
				var adata = {
					'cruise_cabin_id'   	: 	_this.attr('data'),
					'cruise_id' 			: 	$cruise_id,
					'direct'				: 	_this.attr('direct'),
					'tp'				: 	'M'
				};
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseCabin',
					data: adata,	
					dataType:'html',	
					success:function(html){
						loadListCruiseCabin($cruise_id);
						vietiso_loading(0);
					}
				});
			});
		}
		
		// Cruise Price Setup
		if($SiteHasPriceSetup_Cruise == '1') {
			$("#setup_PriceInput").priceFormat({thousandsSeparator: '.',centsLimit: 0});
			loadCruisePriceTable($cruise_id);
			/**/
			$(document).on('click', '#clickPriceSetup', function(ev){
				var $_this = $(this);
				$cruise_itinerary_elem = $('#slb_CruiseItinerary');
				$cruiseCabin_elem = $('#slb_CruiseCabin');
				$typeOfRoom_elem = $('#slb_TypeOfRoom');
				$priceInput_elem = $('#setup_PriceInput');
				$season = $('input[name=season]:checked').val();
				
				if($cruise_itinerary_elem.val()=='0'){
					setSelectOpen($cruise_itinerary_elem);
					alertify.error(field_is_required);
					return false;
				}
				if($cruiseCabin_elem.val()=='0'){
					setSelectOpen($cruiseCabin_elem);
					alertify.error(field_is_required);
					return false;
				}
				if($SiteHasCruisesProperty == '1') {
					if($typeOfRoom_elem.val()==''){
						setSelectOpen($typeOfRoom_elem);
						alertify.error(field_is_required);
						return false;
					}
				}
				if($priceInput_elem.val()=='' || $priceInput_elem.val()=='0'){
					$priceInput_elem.focus();
					alertify.error(field_is_required);
					return false;
				}
				
				var adata = {};
				adata['cruise_id'] = $cruise_id;
				adata['cruise_itinerary_id'] = $cruise_itinerary_elem.val();
				adata['cruise_price_table_id'] = $('#Hid_cruise_price_table_id').val();
				adata['cruise_cabin_id'] = $cruiseCabin_elem.val();
				if($cruiseCabin_elem.val()=='0'){adata['cruise_property_id'] = $typeOfRoom_elem.val();}
				adata['price'] = $priceInput_elem.val();
				adata['season'] = $season;
				adata['tp'] = 'S';
				
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajCruisePriceSetup',
					data: adata,
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						if(html.indexOf('_EXIST') >= 0){
							alertify.error('Error duplicated !');
						}else{
							clearInput();
							loadCruisePriceTable($cruise_id);
							$('#Hid_cruise_price_table_id').val(0);
						}
					}
				});
				return false;
			});
			$(document).on('click', '.btndelete_price_table', function(ev){
				var $_this = $(this);
				if(confirm(confirm_delete)){
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url:path_ajax_script+'/index.php?mod='+mod+'&act=ajCruisePriceSetup',
						data: {'cruise_price_table_id' : $_this.attr('data'),'tp':'D'},
						dataType: "html",
						success: function(html){
							vietiso_loading(0);
							loadCruisePriceTable($cruise_id);
						}
					});
				}
				return false;
			});
			$(document).on('click', '.btnedit_price_table', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajCruisePriceSetup',
					data: {'cruise_id':$cruise_id, 'cruise_price_table_id' : $_this.attr('data'),'tp':'G'},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						var $htm = html.split('$$');
						$("#slb_CruiseItinerary").html($htm[0]);
						$('#slb_CruiseCabin').val($htm[1]);
						$('#slb_TypeOfRoom').val($htm[2]);
						$('#setup_PriceInput').val($htm[3]);
						$("#setup_PriceInput").priceFormat({thousandsSeparator: '.',centsLimit: 0});
						$('#Hid_cruise_price_table_id').val($htm[4]);
						if($htm[5]==2) {
							$('input[name=season][value=2]').attr('checked',true);
						} else {
							$('input[name=season][value=1]').attr('checked',true);
						}
					}
				});
				return false;
			});
			$(document).on('click', '.btnmove_price_table', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajCruisePriceSetup',
					data: {
						'cruise_id':$cruise_id,
						'cruise_price_table_id' : $_this.attr('data'),
						'direct' : $_this.attr('direct'),
						'tp':'M'
					},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						loadCruisePriceTable($cruise_id);
					}
				});
				return false;
			});
		}
		
		
		// Cruise Property
		if($SiteHasCruisesProperty == '1') {
			$(document).on('click', '.ajaxManagerCruiseProperty', function(ev){
				var $_this = $(this);
				
				var adata = {};
				adata['type'] =$_this.attr('_type');
				adata['fromid'] = $_this.attr('fromid');
				adata['forid'] = $_this.attr('forid');
				adata['clsTable'] = $_this.attr('clsTable');
				adata['tp'] = 'L';
				
				$is_choose = (!$_this.attr('_choose') || $_this.attr('_choose')==undefined)?0:1;
				adata['is_choose'] = $is_choose;
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/index.php?mod='+mod+'&act=ajGetBoxManagerCruiseProperty',
					data: adata,
					dataType: "html",
					success: function(html) {
						console.log(html);
						vietiso_loading(0);
						makepopupnotresize('30%', 'auto', html, 'box_CruiseProperty');
						$('#box_CruiseProperty').css('top', 40 + 'px');
					}
				});
				return false;
			});
			$(document).on('click', '#all_property', function(ev) {
            	var checkall = document.getElementById('all_property');
            	var item = document.getElementsByName('fa_item[]');                                                                   
				if(checkall.checked==true){                    
					for(i=0;i<item.length;i++){
						item[i].checked=true;
					}
				} else{
                	for(i=0;i<item.length;i++){
                   		item[i].checked=false;
                	}
            	}
			});
			$(document).on('click', '.savePropertyToBox', function(ev) {
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				
				var $type = $_this.attr('_type');
				var $list_id = getCheckBoxValueByClass('chkitem_property');
				vietiso_loading(1);
				$.ajax({
					type:'POST',	
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajaxSavePropertyToBox',	
					data: {'type' : $type,'list_id' : $list_id},
					dataType:'html',	
					success:function(html){
						vietiso_loading(0);
						console.log(html);
						if(html.indexOf('_EMPTY')>=0){
							alertify.error('You must choose property !');
						} else {
							if($type == 'CabinFacilities') {
								$('#slb_CaFa').html(html);
								$(".selectbox").chosen({max_selected_options: 100,width: '100%'});
							}
							$_form.find('.close_pop').trigger('click');
						}
					}
				});
				return false;
			});
			$(document).on('click', '.createNewCruiseProperty', function(ev) {
				var $_this = $(this);
				var adata = {
					'type': $_this.attr('type'),
					'fromid': $_this.attr('fromid'),
					'forid': $_this.attr('forid'),
					'tp' : 'F'
				};
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/index.php?mod='+mod+'&act=ajGetBoxManagerCruiseProperty',
					data: adata,
					dataType: "html",
					success: function(html) {
						vietiso_loading(0);
						makepopupnotresize('20%', 'auto', html, 'box_AddFrmProperty');
						$('#box_AddFrmProperty').css('top', 100 + 'px');
					}
				});
			});
			$(document).on('click', '.editCruiseProperty', function(ev) {
				var $_this = $(this);
				if (!$_this.hasClass('disabled')) {
					var adata = {
						'cruise_property_id': $_this.attr('data'),
						'fromid': $_this.attr('fromid'),
						'forid': $_this.attr('forid'),
						'tp' : 'F'
					};
					$_this.addClass('disabled');
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script+'/index.php?mod='+mod+'&act=ajGetBoxManagerCruiseProperty',
						data: adata,
						dataType: "html",
						success: function(html) {
							vietiso_loading(0);
							$_this.removeClass('disabled');
							makepopupnotresize('20%', 'auto', html, 'box_EditFrmProperty');
							$('#box_EditFrmProperty').css('top', 100 + 'px');
						}
					});
				}
				return false;
			});
			$(document).on('click', '.saveCruiseProperty', function(ev) {
				var $_this = $(this);
				if (!$_this.hasClass('disabled')) {
					var $_form = $_this.closest('.frmPop');
					
					var $title = $_form.find('input[name=title]');
					var $fromid = $_this.attr('fromid');
					var $forid = $_this.attr('forid');
		
					if ($title.val() == '') {
						$title.addClass('error').focus();
						return false;
					}
					var adata = {
						'cruise_property_id': $_this.attr('cruise_property_id'),
						'type': $_this.attr('_type'),
						'title': $title.val(),
						'tp' : 'S'
					};
					vietiso_loading(1);
					$_this.addClass('disabled');
					$.ajax({
						type: "POST",
						url: path_ajax_script+'/index.php?mod='+mod+'&act=ajGetBoxManagerCruiseProperty',
						data: adata,
						dataType: "html",
						success: function(html) {
							$_this.removeClass('disabled');
							vietiso_loading(0);
							if (html.indexOf('_SUCCESS') >= 0) {
								loadTableCruiseProperty($_this.attr('_type'), $fromid, $forid);
								$_form.find('.close_pop').trigger('click');
								alertify.success(update_success);
								if($fromid == 'CruiseBudget') {
									loadSelectBoxCruiseBudget($_this.attr('_type'), $forid);
								}
								if($fromid == 'CruiseFacilities') {
									loadListCruiseFacilities($_this.attr('_type'), $forid);
								}
								if($fromid == 'CruiseFaActivities') {
									loadListCruiseFaActivities($_this.attr('_type'), $forid);
								}
							}
							if (html.indexOf('_ERROR') >= 0) {
								alertify.error(error);
							}
							if (html.indexOf('_EXIST') >= 0) {
								alertify.error(exist_error);
							}
						}
					});
				}
				return false;
			});
			$(document).on('click', '.deleteCruiseProperty', function(ev) {
				var $_this = $(this);
				if (!$_this.hasClass('disabled')) {
					var $fromid = $_this.attr('fromid');
					var $forid = $_this.attr('forid');
					/**/
					if (confirm(confirm_delete)) {
						var adata = {'cruise_property_id': $_this.attr('data'),'tp' : 'D'};
						vietiso_loading(1);
						$_this.addClass('disabled');
						$.ajax({
							type: "POST",
							url: path_ajax_script+'/index.php?mod='+mod+'&act=ajGetBoxManagerCruiseProperty',
							data: adata,
							dataType: "html",
							success: function(html) {
								$_this.removeClass('disabled');
								vietiso_loading(0);
								loadTableCruiseProperty($_this.attr('_type'), $_this.attr('fromid'), $_this.attr('forid'));
								if($fromid == 'CruiseBudget') {
									loadSelectBoxCruiseBudget($_this.attr('_type'), $forid);
								}
								if($fromid == 'CruiseFacilities') {
									loadListCruiseFacilities($_this.attr('_type'), $forid);
								}
								if($fromid == 'CruiseFaActivities') {
									loadListCruiseFaActivities($_this.attr('_type'), $forid);
								}
							}
						});
					}
				}
				return false;
			});
		}
	}
	// Page Cruise - Mod: Cruise - Act: Property
	if(mod == 'cruise' && act== 'property') {
		$('#slb_Type').change(function(){
			var $_this = $(this);
			window.location.href = '/admin/index.php?mod='+mod+'&act='+act+'&type='+$_this.val();
		});
		$(document).on('click', '.clickToAddPropertyss', function(ev){
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajSiteCruiseProperty',
				data: {'parent_id' : parent_id,'type' : type,'tp' : 'F'},
				dataType: "html",
				success: function(html){
					makepopupnotresize('90%','auto',html,'frmAddProperty');
					$('#frmAddProperty').css('top','50px');
					$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFix();
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.clickToEditProperty', function(ev){
			var _this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajSiteCruiseProperty',
				data: {'cruise_property_id' : _this.attr('data'),'type' : type,'tp' : 'F'},
				dataType: "html",
				success: function(html){
					makepopupnotresize('90%','auto',html,'frmEditProperty');
					$('#frmEditProperty').css('top','50px');
					$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFix();
					vietiso_loading(0);
				}
			});
			return false;
		});
		$(document).on('click', '.clickToDeleteProperty', function(ev){
			var _this = $(this);
			if(confirm(confirm_delete)){
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajSiteCruiseProperty',
					data: {'cruise_property_id' : _this.attr('data'),'tp' : 'D'},
					dataType: "html",
					success: function(html){
						window.location.reload();
						vietiso_loading(0);
					}
				});
			}
			return false;
		});
		$(document).on('click', '.clickSubmitProperty', function(ev){
			var $_this = $(this);
			var $cruise_property_id = $_this.attr('cruise_property_id');
			var $_form = $_this.closest('.frmPop');
			var $title = $_form.find('input[name=title]');
			var $class_icon = $_form.find('input[name=class_icon]');
			var $symbol = $_form.find('input[name=symbol]');
			var $type = $_this.attr('type');
			if($type!="GroupSize" && $type!="Conditions" && $type!="GroupCabinFacilities" && $type!="GroupCruiseFacilities" && $type!="CabinFacilities"  && $type!="CruiseFacilities" && $type!="ThingLove" && $type!="GroupNearestEssentials" && $type!="NearestEssentials" && $type!="GroupUsefulInformation" && $type!="UsefulInformation" && $type!="GroupBenefits" && $type!="CruiseMaterial" && $type!="MEAL"){
			var $intro = tinyMCE.get($('.textarea_intro_editor').attr('id')).getContent();

			}
			var $group = $_form.find('select[name=group]');
			var $group_id = $_form.find('select[name=group_id]');
            var $is_private = $('input[name=is_private]:checked').val();
            var $is_extra_bed = $('input[name=is_extra_bed]:checked').val();
			var $number_adult = $_form.find('input[name=number_adult]');	
			var $number_child = $_form.find('input[name=number_child]');	
			var $image = $_form.find('input[name=image]');


			if($title.val()==''){
				$title.focus();
				alertify.error(field_is_required);
				return false;
			}
            
            if($type=="GroupSize"){
               if($number_adult.val()<1){
                   $number_adult.focus();
                    alertify.error(field_is_required);
                    return false;
               }
            }
			var adata = {
				'title'					: 	$title.val(),
				'intro'					: 	$intro,
				'type'					: 	$type,
				'class_icon'			: 	$class_icon.val(),
				'symbol'				: 	$symbol.val(),
				'image'	  				: 	$image.val(),
				'group_id'	  			: 	$group_id.val(),
				'group'	  				: 	$group.val(),
				'cruise_property_id'	: 	$cruise_property_id,
				'is_private'			: 	$is_private,
				'is_extra_bed'			: 	$is_extra_bed,
				'number_adult'			: 	$number_adult.val(),
				'number_child'			: 	$number_child.val(),
				'tp'					: 	'S'
			};
			vietiso_loading(1);
			$.ajax({
				type : "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajSiteCruiseProperty',
				data: adata,
				dataType: 'html',
				success : function(html){
					vietiso_loading(0);
					if (html.indexOf('_SUCCESS') >= 0) {
						window.location.reload();
					}
					if (html.indexOf('_ERROR') >= 0) {
						alertify.error(error);
					}
					if (html.indexOf('_EXIST') >= 0) {
						alertify.error(exist_error);
					}
				}
			});
		});
	}
	// Page Cruise - Mod: Cruise - Act: Service
	if(mod == 'cruise' && act== 'service') {
		$(document).on('click', '.btnCreateCruiseService', function(ev){
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseService',
				data : {'tp':'F'},
				dataType:'html',
				success:function(html){
					vietiso_loading(0);
					makepopupnotresize('52%', 'auto', html, 'box_CreateCruiseService');
					$('#box_CreateCruiseService').css('top','50px');
					$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFix();
					$(".formatprice").priceFormat({thousandsSeparator: '.',centsLimit: 0});
				}
			});
			return false;
		});
		$(document).on('click', '.clickEditCruiseService', function(ev){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseService',
				data : {'cruise_service_id':$_this.attr('data'),'tp':'F'},
				dataType:'html',
				success:function(html){
					vietiso_loading(0);
					makepopupnotresize('52%','auto',html,'box_EditCruiseService');
					$('#box_EditCruiseService').css('top','50px');
					$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFix();
					$(".formatprice").priceFormat({thousandsSeparator: '.',centsLimit: 0});
				}
			});
			return false;
		});
		$(document).on('click', '.submitCruiseService', function(ev){
			var $_this = $(this);
			var $_form = $_this.closest('.frmPop');
			var $title = $_form.find('input[name=title]');
			var $price = $_form.find('input[name=price]');
			var $extra = $_form.find('select[name=extra]');
			var $intro = tinyMCE.get($('.textarea_intro_editor').attr('id')).getContent();
			var $image = $_form.find('#isoman_url_image');

			if($.trim($title.val())==''){
				$title.focus().addClass('error');
				alertify.error(field_is_required);
				return false;
			}
			if($.trim($price.val())==''){
				$price.focus().addClass('error');
				alertify.error(field_is_required);
				return false;
			}
			/**/
			var adata = {
				'title' 			: 	$title.val(),
				'price' 			: 	$price.val(),
				'extra' 			: 	$extra.val(),
				'intro'	  			: 	$intro,
				'image'	  			: 	$image.val(),
				'cruise_service_id' : 	$_this.attr('cruise_service_id'),
				'tp' 				: 	'S'
			};
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseService',
				data:adata,
				dataType:'html',
				success:function(html){
					vietiso_loading(0);
					if(html.indexOf('_INSERT_SUCCESS') >= 0) {
						alertify.success(insert_success);
						$_this.closest('.frmPop').find('.close_pop').trigger('click');
						window.location.reload();
					}
					if(html.indexOf('_UPDATE_SUCCESS') >= 0) {
						alertify.success(update_success);
						$_this.closest('.frmPop').find('.close_pop').trigger('click');
						window.location.reload();
					}
					if(html.indexOf('_ERROR') >= 0) {
						alertify.error(error);
					}
					if(html.indexOf('_EXIST') >= 0) {
						alertify.error(exist_error);
					}
				}
			});
		});
	}
	// Page Cruise - Mod: Cruise - Act: Cat
	if(mod == 'cruise' && act== 'cat') {
		if($SiteHasCruisesCategory == '1') {
			loadListSysCategory('','');
			$('#keyword').bind('keyup keydown change',function(){
				var $_this=$(this);
				var $total_rows = $('#tblHolderCruiseCategory tr').size();
				if($total_rows > 1 && $_this.val() != ''){
					var $s = $_this.val();
					$("#tblHolderCruiseCategory tr").each(function(){
						$(this).text().search(new RegExp($s,"i"))<0? $(this).hide():$(this).show();
					});
				}else{
					$('#tblHolderCruiseCategory tr').each(function(){
						$(this).show();
					});
				}
			});
			$(document).on('click', '.btnCreateCruiseCategory', function(ev){
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSysCruiseCategory',
					data : {'tp':'F'},
					dataType:'html',
					success:function(html){
						makepopupnotresize('90%', 'auto', html, 'box_CreateCruiseCategory');
						$('#box_CreateCruiseCategory').css('top','50px');
						$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFix();
						vietiso_loading(0);
					}
				});
				return false;
			});
			$(document).on('click', '.btnEditCruiseCategory', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSysCruiseCategory',
					data : {'cruise_cat_id':$_this.attr('data'),'tp':'F'},
					dataType:'html',
					success:function(html){
						makepopupnotresize('52%','auto',html,'box_EditCruiseCategory');
						$('#box_EditCruiseCategory').css('top','50px');
						$('#'+$('.textarea_intro_editor').attr('id')).isoTextAreaFix();
						vietiso_loading(0);
					}
				});
				return false;
			});
			$(document).on('click', '.submitCruiseCategory', function(ev){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				
				var $title = $_form.find('input[name=title]');
				var $parent_id = $_form.find('select[name=parent_id]');
				var $intro = tinyMCE.get($('.textarea_intro_editor').attr('id')).getContent();
				var $image = $_form.find('#isoman_url_image');
				var $image_banner = $_form.find('#isoman_url_image_banner');
				if($.trim($title.val())=='') {
					$title.addClass('error').focus();
					alertify.error(field_required);
					return false;
				}
				var adata = {
					'title' 		: 	$title.val(),
					'parent_id' 	: 	$parent_id.val(),
					'intro'	  		: 	$intro,
					'image'	  		: 	$image.val(),
					'image_banner'	  		: 	$image_banner.val(),
					'cruise_cat_id' : 	$_this.attr('cruise_cat_id'),
					'tp'			:	'S'
				};
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSysCruiseCategory',
					data:adata,
					dataType:'html',
					success:function(html){
						vietiso_loading(0);
						if(html.indexOf('_SUCCESS') >= 0) {
							alertify.success(insert_success);
							location.href = REQUEST_URI;
						}
						if(html.indexOf('_UPDATESUCCESS') >= 0) {
							alertify.success(update_success);
							location.href = REQUEST_URI;
						}
						if(html.indexOf('_ERROR') >= 0) {
							alertify.error(insert_error);
						}
						if(html.indexOf('_EXIST') >= 0) {
							alertify.error(exist_error);
						}
					}
				});
			});
		}
	}
	// Page Cruise - Mod: Cruise - Act: Edit itinerary
	if(mod == 'cruise' && act== 'edit_itinerary') {
		$(document).on('change', '.cruise_season_price', function(ev){
			var $_this = $(this);
			$trip_price = parseInt($('input[name=trip_price]').val());
			if($_this.val() > $trip_price && $trip_price >0){
				alert("Input data is invalid");
			}else{
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod="+mod+"&act=ajOpenManageCabinPriceCruise",
					data:{
						'cruise_id':$_this.attr("cruise_id"),
						'cruise_itinerary_id':$_this.attr("cruise_itinerary_id"),
						"cruise_cabin_id":$_this.attr("cruise_cabin_id"),
						"cabin_type_id":$_this.attr("cabin_type_id"),
						"group_size_id":$_this.attr("group_size_id"),
						"season":$_this.attr("sesson"),
						"number_adult":$_this.attr("number_adult"),
						"price":$_this.val(),
						'tp' : 'S'
					},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						var htm = html.split('|||');
						$_this.val(htm[1]);
						loadCabinPriceCruise($cruise_itinerary_id,$cruise_id);
					}
				}); 
			}
		});
        $(document).on('change', '.cruise_season_price_extra_bed', function(ev){
            alert(1111);
			var $_this = $(this);
			$trip_price = parseInt($('input[name=trip_price]').val());
			if($_this.val() > $trip_price && $trip_price >0){
				alert("Input data is invalid");
			}else{
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/?mod="+mod+"&act=ajOpenManageCabinPriceCruise",
					data:{
						'cruise_id':$_this.attr("cruise_id"),
						'cruise_itinerary_id':$_this.attr("cruise_itinerary_id"),
						"cruise_cabin_id":$_this.attr("cruise_cabin_id"),
						"cabin_type_id":$_this.attr("cabin_type_id"),
						"group_size_id":$_this.attr("group_size_id"),
						"season":$_this.attr("sesson"),
						"price":$_this.val(),
						'tp' : 'S_EXB'
					},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						var htm = html.split('|||');
						$_this.val(htm[1]);
						loadCabinPriceCruise($cruise_itinerary_id,$cruise_id);
					}
				}); 
			}
		});
		$(document).on('change', '.changeToHide', function(ev){
			var $_this = $(this);
			var adata = {};
			adata['clsTable'] = 'CruiseItinerary';
			adata['pkey'] = 'cruise_itinerary_id';
			adata['pvalTable'] = $_this.attr('cruise_itinerary_id');
			adata['toField'] = $_this.attr('sesson')+'_TypeRoom';
			adata['val'] = getCheckBoxValueByClass('changeToHide_'+$_this.attr('sesson')).join('|');
			adata['allowDuplicate'] = 1;
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/?mod=home&act=saveField",
				data: adata,
				dataType: "html",
				success: function(html){
					console.log('Saved !');
				}
			}); 
		});
		if($cruise_itinerary_id) {
			loadCabinPriceCruise($cruise_itinerary_id,$cruise_id);
			loadCruiseItineraryDay($cruise_itinerary_id);
		
			/* CRUISE_ITINERARY_DAY */
			$(document).on('keyup','input[name="day"]',function(){
				var max = $(this).attr('max');
				var value = $(this).val();
				if(value > max){
					$(this).val(max);
				}
			});
			$(document).on('click', '.clickToAddItineraryDay', function(ev){
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteCruiseItineraryDay',
					data: {'cruise_itinerary_id' : $cruise_itinerary_id,'tp' : 'F'},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						makepopupnotresize('90%','auto',html,'SiteFrmCruiseItineraryDay');
						$('#SiteFrmCruiseItineraryDay').css('top','20px');
						var $editorID = $('.textarea_itinerary_content_editor').attr('id');
						$('#'+$editorID).isoTextAreaFix();
					}
				});
				return false;
			});
			$(document).on('click', '.clickEditItineraryDay', function(ev){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteCruiseItineraryDay',
					data: {'cruise_itinerary_day_id' : $_this.attr('data'),'cruise_itinerary_id' : $cruise_itinerary_id,'tp' : 'F'},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						makepopupnotresize('90%','auto',html,'SiteFrmCruiseItineraryDay');
						$('#SiteFrmCruiseItineraryDay').css('top','20px');
						var $editorID = $('.textarea_itinerary_content_editor').attr('id');
						$('#'+$editorID).isoTextAreaFix();
					}
				});
				return false;
			});
			$(document).on('click', '.btnSaveCruiseItineraryDay', function(ev){
				var $_this = $(this);
				var $_form = $_this.closest('.frmPop');
				var $title = $_form.find('input[name=title]');
				var $day = $_form.find('input[name=day]');
				var $transport = getCheckBoxValueByClass('chk_Transport');
				var $editorID = $('.textarea_itinerary_content_editor').attr('id');
				var $content = tinyMCE.get($editorID).getContent();
				var $cruise_itinerary_day_id = $_this.attr('cruise_itinerary_day_id');
				var $image = $_form.find('input[name=isoman_url_image]');
                var $is_show_image = $('input[name=is_show_image]:checked').val();
				
				if($.trim($title.val())=='') {
					$title.focus().addClass('error');
					alertify.error(field_is_required);
					return false;
				}
				if ($.trim($day.val())=='') {
					$day.focus().addClass('error');
					alertify.error(field_is_required);
					return false;
				}
				console.log(1);return false;
				/**/
				var adata = {};
				adata['title'] = $.trim($title.val());
				adata['day'] = $.trim($day.val());
				adata['content'] = $content;
				adata['transport'] = $transport;
				adata['image'] = $image.val();
				adata['cruise_itinerary_day_id'] = $cruise_itinerary_day_id;
				adata['cruise_itinerary_id'] = $cruise_itinerary_id;
				adata['tp'] = 'S';
				
				vietiso_loading(1);
				$('#frmItinerary').ajaxSubmit({
					type: "POST",
					url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteCruiseItineraryDay',
					data: adata,
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						if(html.indexOf('_INSERT_SUCCESS')>=0){
							alertify.success(insert_success);
							loadCruiseItineraryDay($cruise_itinerary_id);
							$_form.find('.close_pop').trigger('click');
						}
						if(html.indexOf('_UPDATE_SUCCESS')>=0){
							alertify.success(update_success);
							loadCruiseItineraryDay($cruise_itinerary_id);
							$_form.find('.close_pop').trigger('click');
						}
						if(html.indexOf('_ERROR')>=0){
							alertify.error(insert_error);
						}
						if(html.indexOf('_EXIST')>=0){
							alertify.error(exist_error);
						}
					}
				});
				return false;
			});
			$(document).on('click', '.moveCruiseItineraryDay', function(ev){
				var _this = $(this);
				var adata = {
					'cruise_itinerary_day_id'   	: 	_this.attr('data'),
					'cruise_itinerary_id' 			: 	$cruise_itinerary_id,
					'direct'						: 	_this.attr('direct'),
					'tp'							: 	'M'
				};
				vietiso_loading(1);
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteCruiseItineraryDay',
					data: adata,	
					dataType:'html',	
					success:function(html){
						loadCruiseItineraryDay($cruise_itinerary_id);
						vietiso_loading(0);
					}
				});
			});
			$(document).on('click', '.clickDeleteItinerary', function(ev){
				var _this = $(this);
				if(confirm(confirm_delete)){
					var adata = {
						'cruise_itinerary_id'		: 	$cruise_itinerary_id,
						'cruise_itinerary_day_id'	:	_this.attr('data'),
						'tp'	:	'D'
					};
					vietiso_loading(1);
					$.ajax({
						type:'POST',
						url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteCruiseItineraryDay',
						data: adata,	
						dataType:'html',	
						success:function(html){
							loadCruiseItineraryDay($cruise_itinerary_id);
							alertify.success(delete_success);
							vietiso_loading(0);
						}
					});
				}
				return false;
			});
		}
	}

	// Duplicate Module Cruise
	$(document).on('click', '.ajDuplicateCruise', function(ev) {
		var $_this = $(this);
		if (confirm(confirm_cloning)) {
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/?mod=' + mod + '&act=ajDuplicateCruise',
				data: {
					"cruise_id": $_this.attr('cruise_id')
				},
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					location.href = html;
				}
			});
		}
		return false;
	});
});
/* END READY FUNCTION */

// Load List Destination
function setSelectBoxDestination(){
	if($check_mod_continent == 1 && $SiteModActive_continent == 1){
		$('#slb_AreaID').hide();
		$('#slb_Country').hide();
		$('#slb_RegionID').hide();
		$('#slb_CityID').hide();	
		$('#slb_placetogoID').hide();
	} else {
		$('#slb_AreaID').hide();
		$('#slb_Country').show();
		$('#slb_RegionID').hide();
		$('#slb_CityID').show();
		$('#slb_placetogoID').hide();
	}
}
function loadListDestination($cruise_itinerary_id){
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadListDestination",
		data:{"cruise_itinerary_id" : $cruise_itinerary_id},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			$('#lstDestination').html(html);
		}
	});
}
function loadChauLuc(){
	$('select[name=country_id]').html('<option value="0"><< '+country+' >></option>').hide();
	$('select[name=khuvuc_id]').html('<option value="0"><< '+area+' >></option>').hide();		
	$('select[name=area_id]').html('<option value="0"><< '+regions+' >></option>').hide();
	$('select[name=city_id]').html('<option value="0"><< '+cities+' >></option>').hide();
	$('select[name=destination_id]').html('<option value="0"><< '+attractions+' >></option>').hide();
	
	$('select[name=chauluc_id]').html('<option value="0">-- '+continents+' --</option>');
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadChauLuc",
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			$('select[name=chauluc_id]').append(html).show();
		}
	});
}
function loadCountry($chauluc_id, $khuvuc_id, $country_id){
	$('#slb_Country').html('<option value="0">'+loading+'</option>')
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadCountry",
		data:{
			"chauluc_id" : $chauluc_id,
			"khuvuc_id" :  $khuvuc_id,
			"country_id" :  $country_id
		},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			$('#slb_Country').show().html(html);
		}
	});
	$('#slb_RegionID').html('<option value="0"><< '+regions+' >></option>').hide();
	$('#slb_CityID').html('<option value="0"><< '+cities+' >></option>').hide();
}

function loadAreaList($chauluc_id, $area_id){
	$('#slb_AreaID').html('<option value="0">'+loading+'</option>')
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajLoadAreaList",
		data:{"chauluc_id" : $chauluc_id, 'area_id': $area_id},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			var htm = html.replace(' ',''); 
			if(htm!='' && htm!=0){
				$('#slb_AreaID').html(html).show();
			} else{	
				$('#slb_AreaID').html('<option value="0"><< '+regions+' >></option>').hide();
			}
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
                $('#slb_region_Id_Container').addClass('hidden');
                loadCity($country_id);
            } else {
				$('#slb_region_Id_Container').removeClass('hidden');
                $('#slb_RegionID').html(html).show();
            }
        }
    });
}
function loadCity($country_id, $region_id, $city_id, $cruise_id){
	$('#slb_CityID').html('<option value="0">'+loading+'</option>');
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajmakeSelectCityGlobal",
		data:{
			"country_id" : $country_id,
			"region_id" : $region_id,
			'city_id': $city_id,
			'cruise_id': $cruise_id
		},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			$('#slb_CityID').show().html(html);
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

// Cruises Photos Gallery
function initSysGalleryCruise(){
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajInitSysCruiseGallery',
		data: {'table_id':$cruise_id},
		dataType: "html",
		success: function(html){
			$('#CruiseGalleryHolder').html(html);
			loadTableGallery($cruise_id,'',1,10);
		}
	});
}
function loadTableGallery(table_id, keyword, $page, $number_per_page){
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSysPhotosGallery',
		data: {'table_id':table_id,'keyword': keyword,'page': $page,'number_per_page': $number_per_page,'tp':'L'},
		dataType: "html",
		success: function(html){
			var $htm = html.split('$$$');
			$('#preview').html(html);
			$('#gallery_paginate').html($htm[1]);
		}
	});
}

// Cruises Map Photos Gallery
/*function initSysGalleryCruiseMap(){
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajInitSysCruiseGalleryMap',
		data: {'table_id':$cruise_id},
		dataType: "html",
		success: function(html){
			$('#CruiseGalleryMapHolder').html(html);
			loadTableGalleryMap($cruise_id,'',1,10);
		}
	});
}*/
/*function loadTableGalleryMap(table_id, keyword, $page, $number_per_page){
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSysPhotosGalleryMap',
		data: {'table_id':table_id,'keyword': keyword,'page': $page,'number_per_page': $number_per_page,'tp':'L'},
		dataType: "html",
		success: function(html){
			var $htm = html.split('$$$');
			$('#previewmap').html(html);
			$('#gallery_paginate_map').html($htm[1]);
		}
	});
}
*/
// Load Cruise Start Date
function loadPriceUnitStartDate(){
	vietiso_loading(1);
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadPriceUnitStartDate',
		data:{'cruise_id':$cruise_id},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			$("#StartDateHolder").html(html);
		}
	}); 
}

// Load Cruise Cabin
function loadListCruiseCabin($cruise_id){
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteCruiseCabin',
		data: {'cruise_id':$cruise_id,'tp':'L'},
		dataType:'html',
		success: function(html){
			$('#hotelCabinTable').html(html);
		}
	});
}

// Load Cruise CustomField
function loadCustomField($cruise_id){
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod=cruise&act=SiteCruiseCustomField",
		data: {'cruise_id': $cruise_id, 'tp' : 'L'},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			if(html != ''){
				$('.SiteCustomFieldContaciner').html(html);
				$('.Site_Custom_Field_Editor').each(function(){
					var $editorID = $(this).attr('id');
					$('#'+$editorID).isoTextArea();
				});
			}
		}
	});
}

// Cruise Price Setup
function clearInput(){
	$('#setup_PriceInput').val('0');
}
function loadCruisePriceTable($cruise_id, $cruise_itinerary_id, $cruise_cabin_id, $cruise_property_id){
	var adata = {};
	adata['cruise_id'] = $cruise_id;
	adata['cruise_itinerary_id'] = $cruise_itinerary_id;
	adata['cruise_cabin_id'] = $cruise_cabin_id;
	adata['cruise_property_id'] = $cruise_property_id;
	adata['tp'] = 'L';
	
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url:path_ajax_script+'/index.php?mod='+mod+'&act=ajCruisePriceSetup',
		data: adata,
		dataType:'html',
		success: function(html){
			vietiso_loading(0);
			$('#tblCruisePrice').html(html);
		}
	});
}

// Cruise Property
function loadTableCruiseProperty($type, $fromid, $forid) {
    $.ajax({
        type: "POST",
        url: path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadTableCruiseProperty',
        data: {'type': $type,'fromid': $fromid,'forid': $forid},
        dataType: "html",
        success: function(html) {
            $('#tblHolderPropertyPop').html(html);
        }
    });
}
function loadSelectBoxCruiseBudget($type, $forid) {
    $.ajax({
        type: "POST",
        url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSelectBoxCruiseBudget',
        data: adata = {'type':$type,'forid':$forid },
        dataType: "html",
        success: function(html) {
            $('#slb_CruiseBudget').html(html);
        }
    });
}
function loadListCruiseFacilities($type, $forid) {
	$.ajax({
        type: "POST",
        url: path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadCruiseTypeList',
        data: adata = {'type':$type,'forid':$forid},
        dataType: "html",
        success: function(html) {
            $('#tblHolderCruiseFacilities').html(html);
        }
    });
}
function loadListCruiseFaActivities($type, $forid) {
	$.ajax({
        type: "POST",
        url: path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadCruiseTypeList',
        data: adata = {'type':$type,'forid':$forid},
        dataType: "html",
        success: function(html) {
            $('#tblHolderCruiseFaActivities').html(html);
        }
    });
}

// Load Cruise Service
function LoadListCruiseService($keyword){
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/?mod='+mod+'&act=ajSiteCruiseService',
		data: adata = {'keyword': $keyword,'tp': 'L'},
		dataType: "html",
		success: function(html){
			$('#tblHolderCruiseService').html(html);
			vietiso_loading(0);
		}
	});
}

// Load Cruise Cat
function loadListSysCategory($parent_id,$keyword){
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/?mod='+mod+'&act=ajSysCruiseCategory',
		data: {'parent_id' : $parent_id,'keyword': $keyword,'tp': 'L'},
		dataType: "html",
		success: function(html){
			$('#tblHolderCruiseCategory').html(html);
			vietiso_loading(0);
		}
	});
}
function loadCabinPriceCruise($cruise_itinerary_id, $cruise_id){
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url:path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenManageCabinPriceCruise',
		data: {
			'cruise_itinerary_id':$cruise_itinerary_id,
			'cruise_id': $cruise_id,
			'tp' : 'L'
		},
		dataType:'html',
		success: function(html){
			vietiso_loading(2);
			$('#tblCruisePrice').html(html);
		}
	});
}
function loadCruiseItineraryDay($cruise_itinerary_id){
	$.ajax({
		type: "POST",
		url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteCruiseItineraryDay',	
		data: {'cruise_itinerary_id' : $cruise_itinerary_id,'tp' : 'L'},
		dataType: "html",
		success: function(html){
			$('#tblCruiseItineraryDay').html(html);
			var number_day = $('#tblCruiseItineraryDay').data('number_day');
			console.log($('#tblCruiseItineraryDay').find('tr').length);
			if($('#tblCruiseItineraryDay').find('tr').length == number_day){
				console.log(1);
				$('.clickToAddItineraryDay').hide();
			}else{
				$('.clickToAddItineraryDay').show();
			}
		}
	});
}
function isoman_callback($image_val,$clsTable){
	var $table_id = $('input[name=table_id]').val();
	var $page = $('#Hid_CurrentPage').val();
	var $file_images = isoman_selected_files();
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/index.php?mod=home&act=ajUploadForm",
		data: {'table_id':$table_id,'clsTable':'CruiseImage','file_images':$file_images},
		dataType: "html",
		success: function(html){
			if($clsTable == 'CruiseMapImage') {
			} else {
				loadTableGallery($table_id, '', $page, 10);
				checkSysPosition();
			}
		}
	});
}






$(document).on('click', '.btnCreateNewReview', function(ev) {
    vietiso_loading(1);
    var review_id = $(this).attr('review_id');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviewsCruise',
        data: {
            'cruise_id':$cruise_id,
            'review_id': review_id,
            'tp': 'Edit'
        }, 
        dataType: "html",
        success: function(html) {
            makepopupnotresize('50%', 'auto', html, 'SiteFrmTourRewreviw');
            $('#SiteFrmTourRewreviw').css('top', '20px');
            var $editorID = $('.textarea_review_content_editor').attr('id');
            $('#' + $editorID).isoTextAreaFix();
            vietiso_loading(0);
        }
    });
    return false;
});

$(document).on('click', '.btnSaveTourReview', function(ev) {
		var $editorID = $('.textarea_review_content_editor').attr('id');
		var $content = tinyMCE.get($editorID).getContent();
		$("textarea[name=iso-content]").val($content);
});
	
$(document).on('click', '.btnSaveTourReview', function(ev) {
	  var $_this = $(this);
	var $data = $("#reviewData").serializeArray(); 
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviewsCruise',
        data: $data,
        dataType: "html",
        success: function(html) {
            if (html.indexOf('_INSERT_SUCCESS') >= 0) {
                loadToursReview();
                vietiso_loading(1);
                $_this.closest('.frmPop').find('.close_pop').trigger('click');
                alertify.success(insert_success);
                vietiso_loading(0);
            }
            if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
                loadToursReview();
                vietiso_loading(1);
                $_this.closest('.frmPop').find('.close_pop').trigger('click');
                alertify.success(update_success);
                vietiso_loading(0);
            }
            if (html.indexOf('_ERROR') >= 0) {
                alertify.error(insert_error);
            }
            if (html.indexOf('_EXIST') >= 0) {
                alertify.error(exist_error);
            }
        }
    });
    return false;
});


$(document).on('click', '.clickDeleteReviews', function(ev) {
    var $_this = $(this);
    if (confirm(confirm_delete)) {
        $.ajax({
            type: 'POST',
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviewsCruise',
            data: {
                'review_id': $_this.attr('data'),
                'tp': 'delete',
                'cruise_id': $cruise_id,
            },
            dataType: 'html',
            success: function(html) {
                vietiso_loading(0);
                alertify.success(delete_success);
                loadToursReview();
            }
        });
    }
    return false;
});
$(document).on('click', '.clickStatusReviews', function(ev) {
    var $_this = $(this);
 
        $.ajax({
            type: 'POST',
            url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxLoadReviewsCruise',
            data: {
                'review_id': $_this.attr('data'),
                'tp': 'status',
                'cruise_id': $cruise_id,
				'is_online':$_this.attr('is_online')
            },
            dataType: 'html',
            success: function(html) {
                vietiso_loading(0);
                alertify.success(update_success);
                loadToursReview();
            }
        });
  
    return false;
});

function loadToursReview() {
    var adata = {
        'cruise_id': $cruise_id,
        'tp': 'Loading'
    };
    $.ajax({
        type: 'POST',
        url: path_ajax_script + "/index.php?mod=" + mod + "&act=ajaxLoadReviewsCruise",
        data: adata,
        dataType: 'html',
        success: function(html) {
            $('#ReviewsTableCruise').html(html);
        }
    });
}