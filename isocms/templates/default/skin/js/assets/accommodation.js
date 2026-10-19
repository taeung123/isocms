$(function(){			
	$(document).on('click', '.submit_hotel_best', function(event){	
		ControllerNews.receiviHotel($(this),event);		
	});
	
	$(document).on('click','.signup-hotel-reset',function(event){
		$('.hotel_name').val('');
		var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
		propertyChoice = propertyChoice.join(",");
		var placeChoice = getCheckBoxValueByClass( 'place_check' );	
		placeChoice = placeChoice.join(",");
		var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
		starChoice = starChoice.join(",");	
		var key_hotel = $('.key_hotel').val();
		var hotel_name = $('.hotel_name').val();
		var city_id = $('.iso_city_id').val();
		var iso_district_id = $('.iso_district_id').val();
		var iso_star_hotel = $('.iso_star_hotel').val();
		var iso_price_hotel = $('.iso_price_hotel').val();		
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
			data :{'key_hotel':'','hotel_name':hotel_name,'district_id':iso_district_id,
						'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
						'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
						'star':starChoice,'property':propertyChoice,'places':placeChoice,'screen_search':'search'},
						
			async: false,
			beforeSend: function() {		
			},
			success: function(html){
				$('.load-more-ajax').empty();
				$('.load-more-ajax').append( html );
				$('.load-more-ajax').offset()
				$('html, body').animate({
					scrollTop: $(".load-more-ajax").offset().top
				}, 500);
			}
		});
	});
	$(document).on('click', '.signup-hotel', function(event) {
		var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
		propertyChoice = propertyChoice.join(",");
		var placeChoice = getCheckBoxValueByClass( 'place_check' );	
		placeChoice = placeChoice.join(",");
		var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
		starChoice = starChoice.join(",");	
		var key_hotel = $('.key_hotel').val();
		var hotel_name = $('.hotel_name').val();
		var city_id = $('.iso_city_id').val();
		var iso_district_id = $('.iso_district_id').val();
		var iso_star_hotel = $('.iso_star_hotel').val();
		var iso_price_hotel = $('.iso_price_hotel').val();	
		if( hotel_name == '' ){
			$('.hotel_name').focus();
			return false;
		}
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
			data :{'key_hotel':'','hotel_name':hotel_name,'district_id':iso_district_id,
						'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
						'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
						'star':starChoice,'property':propertyChoice,'places':placeChoice,'screen_search':'search'},
			async: false,
			beforeSend: function() {		
			},
			success: function(html){
				$('.load-more-ajax').empty();
				$('.load-more-ajax').append( html );
				$('.load-more-ajax').offset()
				$('html, body').animate({
					scrollTop: $(".load-more-ajax").offset().top
				}, 500);
			}
		});
	});
	$(document).on('ifChecked ifUnchecked', '.load_more_record_place input', function(event) {
		var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
		propertyChoice = propertyChoice.join(",");
		var placeChoice = getCheckBoxValueByClass( 'place_check' );	
		placeChoice = placeChoice.join(",");
		var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
		starChoice = starChoice.join(",");	
		var key_hotel = $('.key_hotel').val();
		var hotel_name = $('.hotel_name').val();
		var city_id = $('.iso_city_id').val();
		var iso_district_id = $('.iso_district_id').val();
		var iso_star_hotel = $('.iso_star_hotel').val();
		var iso_price_hotel = $('.iso_price_hotel').val();	
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
			data :{'key_hotel':'','hotel_name':hotel_name,'district_id':iso_district_id,
						'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
						'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
						'star':starChoice,'property':propertyChoice,'places':placeChoice},
			async: false,
			beforeSend: function() {		
			},
			success: function(html){
				$('.load-more-ajax').empty();
				$('.load-more-ajax').append( html );
				$('.load-more-ajax').offset()
				$('html, body').animate({
					scrollTop: $(".load-more-ajax").offset().top
				}, 500);
			}
		});
	});
	
		
	$(document).on('click', '.place_more', function(){
			$currentPagePlace++;
			_this = $(this);
			ControllerNews.loadMorePlace($currentPagePlace,$pagePlace,$city_id,_this);
			$('.load_more_record_place input').on('ifChecked ifUnchecked', function(event){				
			}).iCheck({
		    checkboxClass: 'icheckbox_square-blue',
		    radioClass: 'iradio_square-blue',
		    increaseArea: '20%'
		});
	});		
		
	if(_ACT=='default'){
		$(document).on('click', '.btn-seemore', function(){
			$('.icon-load-ajax').show();
			var _this = $(this);
			$currentPage++;						
			ControllerNews.loadMoreNew( $currentPage, $limitPage, $city_id , $(this) );
		});							
	}	
	
	if(_ACT=='cat'){
		$(document).on('click', '.btn-seemore', function(){
			$('.icon-load-ajax').show();
			var _this = $(this);
			$currentPage++;						
			ControllerNews.loadMoreNew( $currentPage, $limitPageCity, $city_id , $(this) );
		});	
		
		
		
		$(document).on('click', '.paginate_button', function(){
			_this = $(this);
			$currentPage = _this.attr('page');		
			if( $currentPage == '1' ){
				$('.paginate_button_disabled').hide();
			}
			var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
			propertyChoice = propertyChoice.join(",");
			var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
			starChoice = starChoice.join(",");	
			var placeChoice = getCheckBoxValueByClass( 'place_check' );	
			placeChoice = placeChoice.join(",");
			var key_hotel = $('.key_hotel').val();
			var name_hotel = $('.name_hotel').val();
			var city_id = $('.iso_city_id').val();
			var iso_district_id = $('.iso_district_id').val();
			var iso_star_hotel = $('.iso_star_hotel').val();
			var iso_price_hotel = $('.iso_price_hotel').val();	
			$.ajax({			
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
				data :{'name_hotel':name_hotel,'district_id':iso_district_id,
							'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
							'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
							'star':starChoice,'property':propertyChoice,'places':placeChoice},
				async: false,
				beforeSend: function() {		
				}, 
				success: function(html){
					$('.load-more-ajax').empty();
					$('.load-more-ajax').append( html );
					$('.load-more-ajax').offset()
					$('html, body').animate({
						scrollTop: $(".load-more-ajax").offset().top
					}, 500);
				}
			});	
		});
		$('#btn-confirm').click(function(event){

			if( $city_id == $('.iso_city_id').val()){
				_this = $(this);
			event.preventDefault();
			var placeChoice = getCheckBoxValueByClass( 'place_check' );	
			placeChoice = placeChoice.join(",");
			var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
			propertyChoice = propertyChoice.join(",");
			var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
			starChoice = starChoice.join(",");	
			var key_hotel = $('.key_hotel').val();
			var name_hotel = $('.name_hotel').val();
			var city_id = $('.iso_city_id').val();
			var iso_district_id = $('.iso_district_id').val();
			var iso_star_hotel = $('.iso_star_hotel').val();
			var iso_price_hotel = $('.iso_price_hotel').val();						
				$.ajax({			
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
					data : {'name_hotel':name_hotel,'key_hotel':'','district_id':iso_district_id,
								'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
								'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
								'star':starChoice,'property':propertyChoice,'places':placeChoice},
					async: false,
					beforeSend: function() {		
					}, 
					success: function(html){
						$('.load-more-ajax').empty();
						$('.load-more-ajax').append( html );
						$('.load-more-ajax').offset()
						$('html, body').animate({
							scrollTop: $(".load-more-ajax").offset().top
						}, 500);
					}
				});	
			}			
		});
		$('.demo-list input').on('ifChecked ifUnchecked', function(event){		
			var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
			propertyChoice = propertyChoice.join(",");
			var placeChoice = getCheckBoxValueByClass( 'place_check' );	
			placeChoice = placeChoice.join(",");
			var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
			starChoice = starChoice.join(",");	
			var key_hotel = $('.key_hotel').val();
			var name_hotel = $('.hotel_name').val();
			var city_id = $('.iso_city_id').val();
			var iso_district_id = $('.iso_district_id').val();
			var iso_star_hotel = $('.iso_star_hotel').val();
			var iso_price_hotel = $('.iso_price_hotel').val();	
			$.ajax({			
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
				data :{'key_hotel':'','name_hotel':name_hotel,'district_id':iso_district_id,
							'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
							'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
							'star':starChoice,'property':propertyChoice,'places':placeChoice},
				async: false,
				beforeSend: function() {		
				}, 
				success: function(html){
					$('.load-more-ajax').empty();
					$('.load-more-ajax').append( html );
					$('.load-more-ajax').offset()
					$('html, body').animate({
						scrollTop: $(".load-more-ajax").offset().top
					}, 500);
				}
			});							
		}).iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%'
		});						
	}	
	
	if(_ACT=='search'){
		$(document).on('click', '.paginate_button', function(){
			_this = $(this);
			$currentPage = _this.attr('page');
			var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
			propertyChoice = propertyChoice.join(",");
			var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
			starChoice = starChoice.join(",");	
			var placeChoice = getCheckBoxValueByClass( 'place_check' );	
			placeChoice = placeChoice.join(",");
			var key_hotel = $('.key_hotel').val();
			var name_hotel = $('.name_hotel').val();
			var city_id = $('.iso_city_id').val();
			var iso_district_id = $('.iso_district_id').val();
			var iso_star_hotel = $('.iso_star_hotel').val();
			var iso_price_hotel = $('.iso_price_hotel').val();	
			$.ajax({			
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
				data :{'name_hotel':name_hotel,'district_id':iso_district_id,
							'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
							'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
							'star':starChoice,'property':propertyChoice,'places':placeChoice,'screen_search':'search'},
				async: false,
				beforeSend: function() {		
				}, 
				success: function(html){
					$('.load-more-ajax').empty();
					$('.load-more-ajax').append( html );
					$('.load-more-ajax').offset()
					$('html, body').animate({
						scrollTop: $(".load-more-ajax").offset().top
					}, 500);
				}
			});	
		});
		$('.demo-list input').on('ifChecked ifUnchecked', function(event){		
			var propertyChoice = getCheckBoxValueByClass( 'property_check' );	
			propertyChoice = propertyChoice.join(",");
			var starChoice = getCheckBoxValueByClass( 'star-ajax' );	
			starChoice = starChoice.join(",");
			var hotel_name = $('.hotel_name').val();
			var city_id = $('.iso_city_id').val();
			var iso_district_id = $('.iso_district_id').val();
			var iso_star_hotel = $('.iso_star_hotel').val();
			var iso_price_hotel = $('.iso_price_hotel').val();	
			$.ajax({			
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
				data :{'key_hotel':"",'hotel_name':hotel_name,'district_id':iso_district_id,
							'star_hotel':iso_star_hotel,'price_hotel':iso_price_hotel,
							'city_id':$city_id,'page':$currentPage,'limit':$limitPage,
							'star':starChoice,'property':propertyChoice,'screen_search':'search'},
				async: false,
				beforeSend: function() {		
				}, 
				success: function(html){
					$('.load-more-ajax').empty();
					$('.load-more-ajax').append( html );
					$('.load-more-ajax').offset()
					$('html, body').animate({
						scrollTop: $(".load-more-ajax").offset().top
					}, 500);
				}
			});							
		}).iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%'
		});						
	}
	
	if(_ACT=='detail'){		
		$(document).on('click', '.btn-seemore', function(){
			$('.icon-load-ajax').show();
			var _this = $(this);
			$currentPage++;						
			ControllerNews.loadMoreDetail( $currentPage, $limitPage, $city_id , $(this) );
		});							
	}	
		         
});
var ControllerNews = {
	 ellipsestext : "",
     moretext : "Read more"+'&nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i>',
     lesstext : "Read less"+'&nbsp;<i class="fa fa-chevron-up" aria-hidden="true"></i> ',			
	 loadMoreNew: function( $currentPage, $limitPage, $city_id,$obj ){
		_this = $obj;		
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+_MOD+"&act=loadMore",
			data : {'city_id':$city_id,'page':$currentPage,'limit':$limitPage,'screen_search':'detail'},
			async: false,
			beforeSend: function() { 
				$('.load_more_no_record').remove(); 
				/*$('.tab-content').find(idBox).find('.load_more_list_item').empty();*/
			}, 
			success: function(html){		
				$('.icon-load-ajax').css({'display':'none'});			
				$('.load_more_record').append( html );
			}
		});			
	},	
	 loadMoreDetail: function( $currentPage, $limitPage, $city_id,$obj ){
		_this = $obj;		
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+_MOD+"&act=findSearchHotel",
			data : {'city_id':$city_id,'page':$currentPage,'limit':$limitPage,'screen_search':'detail'},
			async: false,
			beforeSend: function() { 
				$('.load_more_no_record').remove(); 
				/*$('.tab-content').find(idBox).find('.load_more_list_item').empty();*/
			}, 
			success: function(html){		
				$('.icon-load-ajax').css({'display':'none'});			
				$('.load_more_record').append( html );
			}
		});			
	},	
	
	
	 loadMorePlace: function( $currentPagePlace, $pagePlace, $city_id,$obj ){
		_this = $obj;		
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod=city&act=districtmoreintocity",
			data : {'city_id':$city_id,'page':$currentPagePlace,'limit':$pagePlace,'district_id':$district_id},
			async: false,
			beforeSend: function() { 
				$('.load_more_no_record_place').remove(); 
				/*$('.tab-content').find(idBox).find('.load_more_list_item').empty();*/
			}, 
			success: function(html){		
				$('.icon-load-ajax').css({'display':'none'});			
				$('.load_more_record_place').append( html );
			}
		});			
	},	
	
	receiviHotel:function($obj,event){
		_this = $obj;		
		var result = _this.parents('.form_receivi_news').valid();	
		var urlPath = '';		
		if( result ){
			event.preventDefault();	
			var address_email = _this.parents('.form_receivi_news').find('#email_receivi').val();
			var adata={'email':address_email,'type':2}; 					
			$.ajax({			
				type: "POST",
				url: path_ajax_script+"/index.php?mod=home&act=subscribe",
				data : adata,
				async: false,
				beforeSend: function() {					
					/*$('.tab-content').find(idBox).find('.load_more_list_item').empty();*/
				}, 
				success: function(html){	
					data = $.parseJSON(html);
					alert( data.message );
					_this.parents('.form_receivi_news').find('#email_receivi').val('');			 						
				}
			});	
		}
	},	
	
}
