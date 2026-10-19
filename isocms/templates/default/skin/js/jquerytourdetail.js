 $(function(){
	setwidthLeftTour();
	$('.it-head-iti').click(function(){
		$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
		$(this).next().slideToggle();
	});
	$('.widget-tit').click(function(){
		$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
		$(this).next().slideToggle();
	});
	//tourDetail
	$('.open-all0').on('click', function () {
		$('.tab-item.pdb45px .it-body').show();
		$('.tab-item.pdb45px .slideToggle').addClass('open');
	});
	$('.close-all0').on('click', function () {
		$('.tab-item.pdb45px .it-body').hide();
		$('.tab-item.pdb45px .slideToggle').removeClass('open');
	});
	$('.open-all').on('click', function () {
		$('.tabFullItinerary .it-body').show();
		$('.tabFullItinerary .fa-dropdown').addClass('fa-angle-up');
	});
	$('.close-all').on('click', function () {
		$('.tabFullItinerary .it-body').hide();
		$('.tabFullItinerary .fa-dropdown').removeClass('fa-angle-up');
	});
	$(document).ready(function(){ 
		$('.fc-today-button').trigger('click');
	});
	$('.slideToggle').click(function(){
		$(this).toggleClass('open');
		$(this).next().slideToggle();
	});
	var stickyOffset = $('#overview').offset().top;	
	$(window).scroll(function(){
	  var sticky = $('.travelers'),
		  scroll = $(window).scrollTop();
	
	  if (scroll >= stickyOffset){
		  sticky.addClass('fixed');
	  }
	  else{
		  sticky.removeClass('fixed');
	  }
	});
	
	var stickyOffsetNavBook = $('.container').offset().top;	
	var stickyOffsetNavBookOut = $('#stickyNavOut').offset().top;	
	$(window).scroll(function(){
	  var sticky = $('.navBookTour'),
		  scroll = $(window).scrollTop();
	
	  if (scroll >= stickyOffsetNavBook && scroll <= stickyOffsetNavBookOut){
		  sticky.addClass('fixed');
	  }
	  else{
		  sticky.removeClass('fixed');
	  }
	});
	
	
	
	var stickyOffsetNav = $('#navbar-detail').offset().top;	
	var stickyOffsetNavOut = $('#stickyNavOut').offset().top;	
	$(window).scroll(function(){
	  var sticky = $('#sticky-wrapper'),
		  scroll = $(window).scrollTop();
	
	  if (scroll >= stickyOffsetNav && scroll <= stickyOffsetNavOut){
		  sticky.addClass('fixed');
	  }
	  else{
		  sticky.removeClass('fixed');
	  }
	});
	$(window).scroll(function(){
	  var sticky = $('#sticky-wrapper620'),
		  scroll = $(window).scrollTop();
	
	  if (scroll >= stickyOffsetNav && scroll <= stickyOffsetNavOut){
		  sticky.addClass('fixed');
	  }
	  else{
		  sticky.removeClass('fixed');
	  }
	});
	$(document).ready(function(){
	  $('body').scrollspy({target: ".sticky-wrapper", offset: 50});   
	  $("#lst_tab_child_new a.scollspy").on('click', function(event) {
		if (this.hash !== "") {
		  event.preventDefault();
		  var hash = this.hash;
		  $('html, body').animate({
			scrollTop: $(hash).offset().top - 115
		  }, 800, function(){
			window.location.hash = hash;
		  });
		} 
	  });
	});
	$(document).ready(function(){
	  $('body').scrollspy({target: ".price-box", offset: 50});   
	  $(".viewmodalPriceTourCalendar").on('click', function(event) {
		if (this.hash !== "") {
		  event.preventDefault();
		  var hash = this.hash;
		  $('html, body').animate({
			scrollTop: $(hash).offset().top - 115
		  }, 800, function(){
			window.location.hash = hash;
		  });
		} 
	  });
	});
	$(document).ready(function(){
	  $('body').scrollspy({target: ".cd-main", offset: 50});   
	  $(".booking_information_except_variant_form").on('click', function(event) {
		if (this.hash !== "") {
		  event.preventDefault();
		  var hash = this.hash;
		  $('html, body').animate({
			scrollTop: $(hash).offset().top - 115
		  }, 900, function(){
			window.location.hash = hash;
		  });
		} 
	  });
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
	
	
	var $ww = $(window).width();
	if($ww>992){
		if($('#lst_tab_child_new').length>0){	
			$('#lst_tab_child_new li.tab').each(function(i){	
				$(this).attr('id','tab_child_'+i);	
			});	
			$('.tab_child.tab').each(function(i){	
				$(this).attr('id','content_tab_child_'+i);	
			});	
			$('#lst_tab_child_new li.tab').click(function(){	
				var $cu = $(this).attr('id');	
				$('#lst_tab_child_new li.active').removeClass('active');	
				$(this).addClass('active');	
				$('.tab_child:visible').hide();	
				$('#content_'+$cu).show();	
				$('#content_'+$cu).focus();	
				return false;	
			});	
		}
	}
	if($ww>992){
		if($('#lst_tab_departure').length>0){	
			$('#lst_tab_departure li.tab').each(function(i){	
				$(this).attr('id','tab_child_departure_'+i);	
			});	
			$('.tab_child_departure').each(function(i){	
				$(this).attr('id','content_tab_child_departure_'+i);	
			});	
			$('#lst_tab_departure li.tab').click(function(){	
				var $cu = $(this).attr('id');	
				$('#lst_tab_departure li.active').removeClass('active');	
				$(this).addClass('active');	
				$('.tab_child_departure:visible').hide();	
				$('#content_'+$cu).show();	
				$('#content_'+$cu).focus();	
				return false;	
			});	
		}
	}
		
	
	// Page Cruise - Mod: Cruise - Act: Book
	
});
function setwidthLeftTour() {
	var $ww = $(window).width();
	var $wc = $('.container').width();
	var $wc5 = $('#container_5').width();
	var $wleadin = $('.leadin').width();
	var $sliderWrapper = $('.sliderWrapper').width();
	var $wlfprice = ($sliderWrapper - $wleadin)/2;
	var $wlf = ($ww - $wc)/2;
	/*$('.leadin').css({'left':($wlfprice)});*/
	$('#container_5 #sticky-wrapper620').css({'width':($wc5)});
	if($ww<992){
	$('#container_5 #sticky-wrapper').css({'right':(15),'width':($wc5)});
	}else if($ww<750){
	$('#container_5 #sticky-wrapper').css({'right':(8),'width':($wc5)});
	
	}else{
		$('#container_5 #sticky-wrapper').css({'right':($wlf),'width':($wc5-50)});
	}
}