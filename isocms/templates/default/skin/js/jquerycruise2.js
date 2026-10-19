$(function(){
	Number.prototype.format = function(n, x) {
		var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
		return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
	};
	$(document).on('click','.item-iti-header',function(e){	
		var $_this = $(this);
		$_this.find('.fa-arow-down').toggleClass('fa-angle-up');
		$_this.next().slideToggle();
	});
	$('.slideToggle').click(function(){
		$(this).toggleClass('open');
		$(this).next().slideToggle();
	});
	if($('.owl_slide_cruise_best').length > 0){
		var $owl = $('.owl_slide_cruise_best');
		$owl.owlCarousel({
			items:3,
			loop:false,
			margin:30,
			autoplay:true,
			nav:false,
			dots:false,
			navText: '',
			lazyLoad:true,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				992:{
					items:3
				}
			}
		});
	}
	if($('.owl_slide_cruise_related').length > 0){
		var $owl = $('.owl_slide_cruise_related');
		$owl.owlCarousel({
			items:3,
			loop:false,
			margin:30,
			autoplay:true,
			nav:false,
			dots:false,
			navText: ["<span class='fa-box'><i class='fa fa-angle-left'></i></span>","<span class='fa-box'><i class='fa fa-angle-right'></i></span>"],
			lazyLoad:true,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				992:{
					items:3
				}
			}
		});
	}
	if($('.owl_slide_cruise_viewed').length > 0){
		var $owl = $('.owl_slide_cruise_viewed');
		$owl.owlCarousel({
			items:3,
			loop:false,
			margin:30,
			autoplay:true,
			nav:false,
			dots:false,
			navText: ["<span class='fa-box'><i class='fa fa-angle-left'></i></span>","<span class='fa-box'><i class='fa fa-angle-right'></i></span>"],
			lazyLoad:true,
			responsive:{
				0:{
					items:1
				},
				768:{
					items:2
				},
				992:{
					items:3
				}
			}
		});
	}
	
	//loadmore crusie promo
	$(document).on('click', '.load_more_cruise_promo, .load_more_cruise_other', function(ev){ 
		$('.pre_loader').show();
		var $_this = $(this);
		var $currentPage = parseInt($_this.data('page'));
		var $totalPage = $_this.data('totalpage');
		var $_type =  $_this.data('cruise_store');
		var $cruise_cat_id = $_this.data('cruise_cat_id') != undefined ? $_this.data('cruise_cat_id') : 0;
		var $_adata = {
			page : $currentPage,
			_type : $_type,
			cruise_cat_id : $cruise_cat_id,
		};
		$.ajax({
			type: "POST",
			cache: true,
			url: path_ajax_script+"/index.php?mod="+mod+"&act=load_more_cruise_halong&lang="+LANG_ID,
			data: $_adata,
			dataType: "html",
			success: function(html){
				$('.pre_loader').hide();
				var $_parent = $_this.closest('.box_recommend_cruises');
				if(($currentPage+1) > $totalPage){
					$_parent.find('.entry_cruise_recomend').append(html);
					$($_this).closest('.box_btn_click_more').remove();
				}else{
					$_this.data('page',($currentPage+1));
					$_parent.find('.entry_cruise_recomend').append(html);
				}
			}
		});
	});
	//loadmore crusie review
	$(document).on('click', '.load_more_cruise_reviews', function(ev){ 
		$('.pre_loader').show();
		var $_this = $(this);
		var $currentPage = parseInt($_this.attr('page'));
		var $totalPage = $_this.attr('totalPage');
		var $_type =  $_this.attr('type_review');
		var $table_id = $_this.attr('table_id') != undefined ? $_this.attr('table_id') : 0;
		var $_adata = {
			page : $currentPage,
			_type : $_type,
			table_id : $table_id,
		};
		$.ajax({
			type: "POST",
			cache: true,
			url: path_ajax_script+"/index.php?mod="+mod+"&act=load_more_cruise_reviews",
			data: $_adata,
			dataType: "html",
			success: function(html){
				$('.pre_loader').hide();
				var $_parent = $_this.closest('.list_cd_reviews');
				if(($currentPage+1) > $totalPage){
					$_parent.find('.box_load_reviews').append(html);
					$($_this).closest('.load_more_cruise_reviews').remove();
				}else{
					$_this.attr('page',($currentPage+1));
					$_parent.find('.box_load_reviews').append(html);
				}
			}
		});
	});
	//loadmore tour review
	$(document).on('click', '.load_more_tour_reviews', function(ev){ 
		$('.pre_loader').show();
		var $_this = $(this);
		var $currentPage = parseInt($_this.attr('page'));
		var $totalPage = $_this.attr('totalPage');
		var $_type =  $_this.attr('type_review');
		var $table_id = $_this.attr('table_id') != undefined ? $_this.attr('table_id') : 0;
		var $_adata = {
			page : $currentPage,
			_type : $_type,
			table_id : $table_id,
		};
		$.ajax({
			type: "POST",
			cache: true,
			url: path_ajax_script+"/index.php?mod="+mod+"&act=load_more_tour_reviews",
			data: $_adata,
			dataType: "html",
			success: function(html){
				$('.pre_loader').hide();
				var $_parent = $_this.closest('.list_cd_reviews');
				if(($currentPage+1) > $totalPage){
					$_parent.find('.box_load_reviews').append(html);
					$($_this).closest('.load_more_tour_reviews').remove();
				}else{
					$_this.attr('page',($currentPage+1));
					$_parent.find('.box_load_reviews').append(html);
				}
			}
		});
	});	
	if(mod == 'cruise2' && act== 'detail') {
		setwidthLeftCruise();
		loadItinerary();
		$('#cruiseItineraryID').change(function(){
			loadItinerary();
		});
		$(".headhowtobook").click(function(){
			 $(this).toggleClass('show-arc').next(".detailhowtobook").slideToggle(300);
		});
		
		$('.openCheckDate').on('click', function () {
		$('.chose-room-xs').slideToggle(300);
		});
		$(document).on('click','.quickcontact',function(e){	
			var _this=$(this);	
			var uri = _this.attr('href');	
			$.popup.show(uri,{wwidth: 740,wheight: 740});	
			return false;
		});
		$('.it-head-iti').click(function(){
			$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
			$(this).next().slideToggle();
		});
		$('.widget-tit').click(function(){
			$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
			$(this).next().slideToggle();
		});
		$(document).on('click', '.elem-accordion_Items', function(ev){
			ev.preventDefault();
			$(this).toggleClass('show-icr').next("dd").slideToggle(300);
		});
		$(document).on('click', '.elem-mr-head', function(ev){
			ev.preventDefault();
			var $_this = $(this);
			var $tp = $_this.attr('tp');
			$(this).toggleClass('show-icr').next(".elem-mr-body").slideToggle(300);
			if($tp == 'RECOMMENDED') {loadCruiseRecommend();}
			
		});
		$(document).on('click', '.cabin_selected', function(ev){

			ev.preventDefault();
			var number_cabin = $(this).data('number_cabin');
			var choose_index = $(this).data('choose_index');
			if($("#box_cabin_item").find('#'+choose_index).length > 0){
				var number_cabin = $('#'+choose_index).find('select[name="number_cabin"]').val();
				number_cabin = parseInt(number_cabin)+1;
				$('#'+choose_index).find('select[name="number_cabin"]').val(number_cabin);
				$('#'+choose_index).find('input[name="numberCabin"]').val(number_cabin);	
				loadPrice();
				return false;
			}
			var _this = $(this);
			var adata = {
				'cruise_id'   				:_this.data('cruise_id'),
				'cruise_itinerary_id'   	:_this.data('cruise_itinerary_id'),
				'cruise_cabin_id'   		:_this.data('cruise_cabin_id'),
				'number_adult'   			:_this.data('number_adult'),
				'number_child'   			:_this.data('number_child'),
				'number_cabin'   			:number_cabin,
				'totalprice'   				:_this.data('totalprice'),
				'max_adult'   				:_this.data('max_adult'),
				'departure_date'   			:_this.data('departure_date'),
				'promotion_price'   		:_this.data('promotion_price_value'),
				'choose_index'   			:choose_index,
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadCabinCruise',
				data: adata,	
				dataType:'json',	
				success:function(json){
					$('#list_cabin').show();
					$('#box_cabin_item').append(json.html_cabin);
					if(json.promotion_price > 0){
						$("#list_cabin").find(".cabin_choose_item.promotion").show();
						$("#list_cabin").find(".cabin_choose_item.promotion .price_promotion").text(json.promotion_price);
					}
					loadPrice();
				}
			});
		});
		$(document).on('change', '.number_cabin', function(ev){
			let number_cabin = $(this).val();
			$(this).closest('.cabin_choose_item').find('input[name="numberCabin"]').val(number_cabin);
			loadPrice();
		});
		$(document).on('click', '.delete_cabin', function(ev){
			ev.preventDefault();
			$(this).closest('.cabin_choose_item').remove();
			loadPrice();
		});
		$(document).on('click', '#book_now_cabin', function(ev){
			ev.preventDefault();
			var _this = $(this);
			var parent = $("#frm_book_cruise");
			var dataCruise = [];
			var cruise_id = parent.find('input[name="cruise_id"]').val();
			var cruise_itinerary_id = parent.find('input[name="cruise_itinerary_id"]').val();
			var discount_value = parent.find('input[name="discount_value"]').val();
			var discount_type = parent.find('input[name="discount_type"]').val();
			parent.find(".cabin_choose_item:not('.promotion')").each(function(index,element){
				let cruise_cabin_id = $(element).data('cruise_cabin_id');
				let priceCabin 		= parseInt($(element).find('input[name="priceCabin"]').val());
				let numberCabin 	= parseInt($(element).find('input[name="numberCabin"]').val());
				let number_adult 	= parseInt($(element).find('input[name="number_adult"]').val());
				let number_child 	= parseInt($(element).find('input[name="number_child"]').val());
				let max_adult 		= parseInt($(element).find('input[name="max_adult"]').val());
				dataCruise[index] = {
					"cruise_id"				:	cruise_id,
					"cruise_cabin_id"		:	cruise_cabin_id,
					"cruise_itinerary_id"	:	cruise_itinerary_id,
					"number_adult"			:	number_adult,
					"number_child"			:	number_child,
					"number_cabin"			:	numberCabin,
					"totalprice"			:	priceCabin,
					'max_adult'   			:	max_adult,
				};
			});
			var adata = {
				'cruise_id'   				:	cruise_id,
				'cruise_itinerary_id'   	:	cruise_itinerary_id,
				'departure_date'   			:	parent.find('input[name="departure_date"]').val(),
				'discount_value'   			:	discount_value,
				'discount_type'   			:	discount_type,
				'dataCruise'   				:	dataCruise,
				'type'   					:	'BOOKNOW',
				
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajChooseCabinCruise',
				data: adata,	
				dataType:'html',	
				success: function(html){
					location.href = html;
			}
			});
		});
		$(document).on('click', '.viewDetailCruiseCabin', function(ev){
			ev.preventDefault();
			var _this = $(this);
			var adata = {
				'cruise_cabin_id'   	: 	_this.attr('data'),
				'cruise_id' 			: 	$cruise_id,
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajViewDetailCruiseCabin',
				data: adata,	
				dataType:'html',	
				success:function(html){
				}
			});
		});
		var stickyOffsetNavBook = $('.cabin_box').offset().top;	
		//var stickyOffsetNavBookOut = $('#stickyNavOut').offset().top;	
		$(window).scroll(function(){
		  var sticky = $('.sticky_nav_tour_detail'),
			  scroll = $(window).scrollTop();
		
		  if (scroll >= stickyOffsetNavBook){
			  sticky.addClass('fixed');
		  }
		  else{
			  sticky.removeClass('fixed');
		  }
		});
		$(document).on('click', '.go-to', function(ev){ 
			event.preventDefault();
			var offset_start = $($.attr(this, 'data-artt_id')).offset().top - 60;
			$('html, body').animate({
				scrollTop: offset_start
			}, 500);
		});
		
		if($('#global_tabs').length > 0){
			$('#global_tabs > ul > li').each(function(idx){
				$(this).attr('id','globaltabbox'+idx);
			});
			$('.globaltabbox').each(function(idx){
				$(this).attr('id','globaltabbox'+idx+'content');
			});
			$('#global_tabs > ul > li:first').addClass('tabselected');
			$('.tabDetair .globaltabbox:not(:first)').hide();
			$('#global_tabs > ul > li').click(function(){
				var $cu = $(this).attr('id');
				$('.tabselected').removeClass('tabselected');
				$(this).addClass('tabselected');
				$('.globaltabbox:visible').stop(false,true).fadeOut().hide();
				$('#'+$cu+'content').stop(false,true).fadeIn();
				if($(this).hasClass('map')){
					initialize();
				}
				if($(this).hasClass('photo')){
					$('.tabDetair').find('.nano').nanoScroller({scroll:'top'});
				}
				if($(this).hasClass('review')){
					processbar();
				}else{
					if($('.per_bar').length > 0){
						$('.per_bar').css('width','0%');
					}
				}
				return false;
			});
			$('.tabDetair .tab1').find('img').parent('a').addClass('fancy');
		}
		if($('#lst_tab_child').length>0){	
			$('#lst_tab_child li').each(function(i){	
				$(this).attr('id','tab_child_'+i);	
			});	
			$('.tab_child').each(function(i){	
				$(this).attr('id','content_tab_child_'+i);	
			});	
			$('#lst_tab_child li').click(function(){	
				var $cu = $(this).attr('id');	
				$('#lst_tab_child li.current').removeClass('current');	
				$(this).addClass('current');	
				$('.tab_child:visible').hide();	
				$('#content_'+$cu).show();	
				return false;	
			});	
		}
		var $ww = $(window).width();
		if($ww>992){
			if($('#lst_tab_child_new').length>0){	
				$('#lst_tab_child_new li.tab').each(function(i){	
					$(this).attr('id','tab_child_'+i);	
				});	
				$('.tab_child').each(function(i){	
					$(this).attr('id','content_tab_child_'+i);	
				});	
				$('#lst_tab_child_new li.tab').click(function(){	
					var $cu = $(this).attr('id');	
					$('#lst_tab_child_new li.active').removeClass('active');	
					$(this).addClass('active');	
					$('.tab_child:visible').hide();	
					$('#content_'+$cu).show();	
					return false;	
				});	
			}
		}
			
		/* Itinerary */
		$('.toggle-Link').click(function(){
			var $_this = $(this);
			var $cu = $_this.attr('rel');
			if(!$('#cabin'+$cu).is(':visible')){
				$('.cabin_detail:visible').hide();
				$('.toggle-Link').removeClass('open');
				/**/
				$('#cabin'+$cu).stop(false,true).show();
				$_this.addClass('open');
			}else{
				$('#cabin'+$cu).stop(false,true).hide();
				$('.toggle-Link').removeClass('open');
			}
			return false;
		});
	}
	// Page Cruise - Mod: Cruise - Act: Book
	if(mod == 'cruise2' && act== 'rate') {
		getTotalRate();
		$(document).on('change','#boxItineraryCruise',function(e){	
			loadEndDate();
		});
		$(document).on('change', '.slbCabinType', function(ev){
			var $_this = $(this);
			var $_row = $_this.closest('.trRow');
			var $cruise_cabin_id = $_row.attr('data-cabin_id');
			$.ajax({
				type: "POST",
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajChangePriceRate',
				data: {
					'cruise_id' : $cruise_id,
					'season' : $season,
					'cruise_cabin_id' : $cruise_cabin_id,
					'cruise_itinerary_id' : $cruise_itinerary_id,
					'cabin_type_id' : $_this.attr('cabin_type_id'),
					'listCabinSelected' : loadCruiseRate($cruise_cabin_id),
				},
				dataType: "html",
				success: function(html){
					var htm = html.split("$$");
					if(html.indexOf('NOSELECTED') >= 0){
						$('#totalRate_'+$cruise_cabin_id).html(htm[0]);
						$('#totalRateCanin_'+$cruise_cabin_id).val(0);
					}else{
						$('#totalRate_'+$cruise_cabin_id).html(htm[0]);
						$('#totalRateCanin_'+$cruise_cabin_id).val(htm[1]);
					}
					getTotalRate();
					getTotalCabinCheck();
				}
			});
			return false;
		});
		$(document).on('change', '.chk_activebook', function(ev){
			var $_this = $(this);
			var $cruise_cabin_id = $_this.attr('cruise_cabin_id');
			var $totalCabin = 0;
			$('.changeToRate_'+$cruise_cabin_id).each(function(){
				var $_cabin = $(this);
				$totalCabin += parseInt($_cabin.val());
			});
			if($totalCabin==0){
				alert('Please select cabin type !');
				$_this.prop('checked',false);
				return false;
			}else{
				if($_this.is(':checked')){
					$('#superX'+$cruise_cabin_id).addClass('trRowSl');
					$('#totalRate_'+$cruise_cabin_id).addClass('red strong');
				} else {
					$('#superX'+$cruise_cabin_id).removeClass('trRowSl');
					$('#totalRate_'+$cruise_cabin_id).removeClass('red strong');
				}
				getTotalRate();
				getTotalCabinCheck();
			}
		});
	}
	if(mod=='cruise2' && act=='bookcabin'){

		getTotalRateService();
		$('.chk_addOnService').each(function(){
			var $_this = $(this);
			if($_this.is(':checked')){
				$_this.closest('tr').find('select[class=select-lg]').removeAttr('disabled');
			}else{
				$_this.closest('tr').find('select[class=select-lg]').attr('disabled','disabled');
			}
		});
		$('.chk_addOnService').change(function(){
			var $_this = $(this);
			if($_this.is(':checked')){
				$_this.closest('tr').addClass('choosesv');
				$_this.closest('tr').find('select[class=select-lg]').removeAttr('disabled');
			}else{
				$_this.parents('tr').removeClass('choosesv');
				$_this.closest('tr').find('select[class=select-lg]').attr('disabled','disabled');
			}
			getTotalRateService();
		});
		$('.widget-tit').click(function(){
			$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
			$(this).next().slideToggle();
		});
	}
});
/* END READY FUNCTION */
function loadPrice(){
	var totalprice = 0;
	var discount_value = $("#frm_book_cruise").find('input[name="discount_value"]').val();
	discount_value = (discount_value != undefined)?discount_value:0;
	var discount_type = $("#frm_book_cruise").find('input[name="discount_type"]').val();
	$("#box_cabin_item").find('.cabin_choose_item').each(function(index,element){
		let priceCabin = $(element).find('input[name="priceCabin"]').val();
		priceCabin = (priceCabin !== undefined)?parseInt(priceCabin):0;
		let numberCabin = $(element).find('input[name="numberCabin"]').val();
		numberCabin = (numberCabin !== undefined)?parseInt(numberCabin):0;
		totalprice += priceCabin * numberCabin;
	});
	var totalPromotion = 0;
	if(discount_type == 2){
		totalPromotion = totalprice * discount_value/100;
	}else if(discount_type == 1){
		totalPromotion = parseInt(discount_value);
	}
	if(totalPromotion > 0){
		$("#list_cabin").find('.cabin_choose_item.promotion').show();
		$("#list_cabin").find('input[name="price_promotion"]').val(totalPromotion);
		$("#list_cabin").find('.cabin_choose_item.promotion .price_promotion').text(format1(totalPromotion));
	}else{
		$("#list_cabin").find('.cabin_choose_item.promotion').hide();
		$("#list_cabin").find('input[name="price_promotion"]').val(0);
	}
	totalprice -= totalPromotion;
	if(totalprice > 0){
		$(document).find('#frm_book_cruise .total_price_cabin').show();
		$(document).find('#frm_book_cruise .btn_book').show();
		$(document).find('#frm_book_cruise .total_price_cabin .totalprice_new').text(format1(totalprice));
	}else{
		$(document).find('#frm_book_cruise .total_price_cabin').hide();
		$(document).find('#frm_book_cruise .btn_book').hide();
		$(document).find('#frm_book_cruise .total_price_cabin .totalprice_new').text(0);
	}
	
}
function format1(n) {
    return n.toFixed(0).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}
function loadItinerary(){
	var $cruiseItineraryID = $('#cruiseItineraryID').val();
	$('.loading').show();
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadCruiseItinerary&lang='+LANG_ID, {'cruise_id' : $cruise_id, 'cruise_itinerary_id' : $cruiseItineraryID}, function(html){
		$('.loading').hide();
		$('#cruise_Itinerary_Container').html(html);
	});
}
function loadCruiseRate($cruise_cabin_id){
	var $string = '';
	$('.changeToRate_'+$cruise_cabin_id).each(function(idx){
		var $_this = $(this);
		var $price = parseInt($_this.attr('price'));
		var $number = $_this.val();
		$string += (idx==0?'':'|') + $price+'-'+$number;
	});
	return $string;
}
function getTotalRate() {
	var $totalRate = 0;
	$('.trRowSl').each(function(){
		var $_this = $(this);
		var $cabin_id = $_this.data('cabin_id');
		var $price = parseInt($_this.find('#totalRateCanin_'+$cabin_id).val());
		$totalRate += $price;
	});
	$('input[name=totalGrand]').val($totalRate);
	if($totalRate > 0 && $('.chk_activebook:checked').length > 0){
		$('#booking-summary .total-price').html('US$ '+formatPrice($totalRate));
		$('#booking-summary').show();
		$('#btn-continue').removeAttr("disabled").removeClass('bgr_a2a2a2').addClass('bgr_1e74a5');
	}else{
		$('#booking-summary').hide();
		$('#btn-continue').attr('disabled', 'disabled').removeClass('bgr_1e74a5').addClass('bgr_a2a2a2');
	}
	getTotalCabinCheck();
}
function getTotalCabinCheck() {
	var $totalCabin = 0;
	$('.slbCabinType').each(function(){$totalCabin += parseInt($(this).val());});
	/**/
	var $contentCabin = '';
	$contentCabin += '<span style="font-size:14px;font-weight:bold">'+$totalCabin+' cabin(s)'+'</span>';
	/**/
	var $totalSingle = 0;
	$('.slbCabinType22').each(function(){$totalSingle += parseInt($(this).val());});
	/**/
	var $totalDouble = 0;
	$('.slbCabinType23').each(function(){$totalDouble += parseInt($(this).val());});
	/**/
	var $totalTwin = 0;
	$('.slbCabinType20').each(function(){$totalTwin += parseInt($(this).val());});
	/**/
	var $totalTriple = 0;
	$('.slbCabinType21').each(function(){$totalTriple += parseInt($(this).val());});
	/**/
	var $totalQuad = 0;
	$('.slbCabinType102').each(function(){$totalQuad += parseInt($(this).val());});
	/**/
	if(parseInt($totalSingle) > 0) {
		$contentCabin += ' <br/> - '+$totalSingle+' single(s)';
	}
	if(parseInt($totalDouble) > 0) {
		$contentCabin += '<br/> - '+$totalDouble+' double(s)';
	}
	if(parseInt($totalTwin) > 0) {
		$contentCabin += '<br/> - '+$totalTwin+' twin(s)';
	}
	if(parseInt($totalTriple) > 0) {
		$contentCabin += '<br/> - '+$totalTriple+' triple(s)';
	}
	if(parseInt($totalQuad) > 0) {
		$contentCabin += '<br/> - '+$totalQuad+' quad(s)';
	}
	$('#cabinscount').html($contentCabin);
}
function getTotalRateAddOnService(){
	var $listAddOnServiceID = getCheckBoxValueByClass('chk_addOnService');
	$.ajax({
		type: "POST",
		url:path_ajax_script+'/index.php?mod='+mod+'&act=getTotalRateAddOnService&lang='+LANG_ID,
		data: {'listAddOnServiceID' : $listAddOnServiceID.join('|')},
		dataType: "html",
		success: function(html){
			var $htm = html.split('$$$');
			$('#totalRate').html($htm[0]);
			$('#totalGrand').val($htm[1]);
		}
	});
}
function IsEmpty(variable){
	if (variable === undefined)
		return true;
		
	if (typeof (variable) == 'function' || typeof (variable) == 'number' 
	|| typeof (variable) == 'boolean' || Object.prototype.toString.call(variable) === '[object Date]')
		return false;

	if (variable == null || variable.length === 0) // null or 0 length array
		return true;

	if (typeof (variable) == "object") {
		// empty object
		var r = true;
		for (var f in variable)
			r = false;
		return r;
	}
	return false;
}
function parseToNumber(dg){
	if(typeof(dg)!=='undefined' && !IsEmpty(dg)){
		var ret = dg.toString();
		ret = ret.replace(/₫+/,'');
		ret = ret.replace(/\$+/, "");		
		ret = ret.replace(/[\s]+/ig,'');
		ret = ret.replace(/,+/ig,'.');
		return Number(ret);
	}
	return 0;
}
function getTotalRateService() {
	var $totalRate = 0;
	var $totalRateService = 0;
	var $totalRateCabin = parseToNumber($('.totalRateCabin').val());
	$totalRate += $totalRateCabin;
	$('.trRowSv.choosesv').each(function(){
		var $_this = $(this);
		var $cruise_service_id = $_this.attr('cruise_service_id');
		var $price = parseToNumber($_this.find('#cruisePriceSv'+$cruise_service_id).val());
		$totalRate += $price;
		$totalRateService=$totalRate-$totalRateCabin;
		$totalRateService=format1($totalRateService);
	});
	$('#totalRate').html(format1($totalRate));
	$('#totalGrand').val($totalRate.toFixed(2));
	$('#totalRateService').html($totalRateService);
	$('#price_service').val($totalRateService);
}
function processbar(){
	if($('.per_bar').length > 0){
		$('.per_bar').each(function(){
			var $w = $(this).attr('data');
			$(this).css('width',$w+'%');
		});
	}
}
function changeToRateServices($cruise_service_id, $_this) {
	var $number = $_this.val();
	var $extra = $_this.attr('extra');
	if(parseInt($extra) != 0) {
		$.ajax({
			type: "POST",
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajchangeToRateServices&lang='+LANG_ID,
			data: {'cruise_service_id' : $cruise_service_id,'number' : $number,'extra' : $extra},

			dataType: "html",
			success: function(html){
				var $htm = html.split('$$$');
				$('#svRate'+$cruise_service_id).html($htm[0]);
				$('#cruisePriceSv'+$cruise_service_id).val($htm[1]);
				getTotalRateService();
			}
		});
		return false;
	}
}
function loadEndDate() {
	var $cruise_itinerary_id = $('#boxItineraryCruise').val();
	var $departure_date = $('#departure_date').val();
	/**/
	$.ajax({
		type: "POST",
		url:path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadEndDate',
		data: {'cruise_itinerary_id' : $cruise_itinerary_id,'departure_date' : $departure_date},
		dataType: "html",
		success: function(html){
			$('#loadEndDate').html(html);
		}
	});
	return false;
}
function getCheckBoxValueByClass(classname){
	var names = [];
	$('.'+classname+':checked').each(function() { 
		names.push(this.value);
	});
	return names;
}
function setwidthLeftCruise() {
	var $ww = $(window).width();
	var $wh = $(window).height();
	var $wc = $('.container').width();
	var $wc5 = $('#container_5').width();
	var $wleadin = $('.leadin').width();
	var $whotelsdetailimges = $('.hotelsDetail-imges').width();
	var $wlfprice = ($whotelsdetailimges - $wleadin)/2;
	var $wlf = ($ww - $wc)/2;
	$('.leadin').css({'left':($wlfprice)});
	$('#container_5 #sticky-wrapper620').css({'width':($wc5)});
	if($ww<992){
	$('#container_5 #sticky-wrapper').css({'right':(15),'width':($wc5)});
	}else if($ww<750){
	$('#container_5 #sticky-wrapper').css({'right':(8),'width':($wc5)});
	
	}else{
		$('#container_5 #sticky-wrapper').css({'right':($wlf),'width':($wc5)});
	}
}


