$(function(){	
	$("img" ).each(function( index ) {
			url = $( this ).prop('src');
			$("<img>", {
				src: url,
				error: function() { $( this ).remove() },
				load: function() {}
			});			
	});
	$(document).on('click', '.morelink', function(){	
		ControllerCommon.clickReadmore($(this));
	});
	$(document).on('click', '.mail_reg_btn', function(event){	
		_this = $(this);
		event.preventDefault();
		var result = _this.parents('#btn_subscribe').valid();
		if( result ){
			var address_email = _this.parents('#btn_subscribe').find('.mail_reg').val();
			var adata={'email':address_email,'type':1}; 
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod=home&act=subscribe",
				data: adata,
				dataType: "html",
				success: function(html){
					data = $.parseJSON(html);
					alert( data.message );
					//_this.parents('#btn_subscribe').find('.mail_reg').val('');
				}
			});
			
			}else{
				alert( 'Your email incorrect!' );
			}
	});	
	ControllerCommon.readMoreData();
	
	$('input[name=security_code]').keyup(function(){
		var val=$(this).val();
		var adata={"security_code":val}
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod=home&act=checkCaptcha",
			data: adata,
			dataType: "html",
			success: function(html){
				if(html==1){
					$('.vietiso_error').hide();
					$(this).removeClass('error');
				}else{
					$('.vietiso_error').show();
					$(this).addClass('error');
					$('.vietiso_error').css({'display':'block'});
				}
			}
		});
	});
	
          
				
});
var ControllerCommon = {
	 ellipsestext : "",
     moretext : "Read more"+'&nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i>',
     lesstext : "Read less"+'&nbsp;<i class="fa fa-chevron-up" aria-hidden="true"></i> ',			
	 loadAttractionArticle: function( $city_id, $cat_id, $page,$parent_id,$obj ){
		_this = $obj;		
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+_MOD+"&act=loadListChildInCat",
			data : {'city_id':$city_id,'cat_id':$cat_id,'page':$page,'parent_id':$parent_id},
			
			beforeSend: function() { 
				_this.parents('.load_more_list_item').find('.load_more_no_record').remove(); 
			}, 
			success: function(html){		
				$('.load-ajax').css({'display':'none'});			
				_this.parents('.load_more_list_item').find('.ajax_loadmore_cat').append( html );
			}
		});			
	},
	signin:function($obj,event){
		_this = $obj;	
		var result = _this.parents('.AppForm').valid();	
		var urlPath = '';
		if( result ){
			event.preventDefault();
			urlPath = _this.parents('.AppForm').attr('action');
			$('.alert-warning-sign').slideUp();
		
			$.ajax({			
				type: "POST",
				url: urlPath,
				data : _this.parents('.AppForm').serialize(),				
				beforeSend: function() {
				}, 
				error: function(jqXHR, textStatus, errorThrown) {
				  console.log(textStatus, errorThrown);
				},	
				success: function( data ){		
					data = $.parseJSON(data);
					if( data.ok ){
						if( data.urlLoad !='' ){
							$('.alert-success-sign1').slideUp();
							window.location.href = data.urlLoad;
						}						
					}else{
						$('.alert-success-sign1').slideUp();
						$('.alert-warning-sign').slideDown();
						$('.load_error_sign').empty();
						$('.load_error_sign').append(data.error);
					}
				}
			});	
		}else{
			return false;
		}		
	},
	MemberRegister:function($obj,event){
		_this = $obj;	
		_this.parents('.AppForm').validate({
		  rules: {
			userpass: "required",
			confirmpass: {
			  equalTo: "#userpass"
			}
		  }
		});	
		var result = _this.parents('.AppForm').valid();		
		var urlPath = '';
		if( result ){
			event.preventDefault();
			urlPath = _this.parents('.AppForm').attr('action');
			$('.alert-warning-sign').slideUp();
			$.ajax({			
				type: "POST",
				url: urlPath,
				data : _this.parents('.AppForm').serialize(),				
				beforeSend: function() {
				}, 
				error: function(jqXHR, textStatus, errorThrown) {
				  console.log(textStatus, errorThrown);
				},
				success: function( data ){		
					data = $.parseJSON(data);
					console.log( data );
					if( data.ok ){
						    $('.alert-success-sign1').slideUp(800);
							$('.alert-success-sign').slideDown();
							window.location.href = path_ajax_script;					
					}else{
						 $('.alert-success-sign1').slideUp(800);
						$('.alert-warning-sign').slideDown();
						$('.load_error_sign').empty();
						$('.load_error_sign').append(data.error);
					}
				}
			});	
		}else{
			return false;
		}		
	},
	readMoreData:function(){
		$('.read_more').each(function() {
			_this = $(this);
			
			var content = $(this).height();
			if( content > 160 ){														
				var html = '';
				html = html + '<div class="read_more_content" style="height:50px">' + ControllerCommon.ellipsestext+ '&nbsp;';
				html = html +'<span class="morecontent"><span>' + '</span><p href="" class="morelink">' + ControllerCommon.moretext + '</p></span></div>';
				_this.parents('.article').append(html);
				_this.css({"height": "160px","overflow":"hidden"});
				_this.find('.white_read_more').css({"display":"block"});
			}else{
				_this.find('.white_read_more').css({"display":"none"});							
			}
		});
		$('.read_more_acommodation').each(function() {
			_this = $(this);
			
			var content = $(this).height();
			if( content > 160 ){														
				var html = '';
				html = html + '<div class="read_more_content" style="height:50px">' + ControllerCommon.ellipsestext+ '&nbsp;';
				html = html +'<span class="morecontent"><span>' + '</span><p href="" class="morelink">' + ControllerCommon.moretext + '</p></span></div>';
				_this.parents('.article').append(html);
				_this.css({"height": "300px","overflow":"hidden"});
				_this.find('.white_read_more').css({"display":"block"});
			}else{
				_this.find('.white_read_more').css({"display":"none"});							
			}
		});
	},
	
	clickReadmore:function($obj){				
		if( $obj.hasClass("less")) {
			$obj.removeClass("less");
			$obj.html( ControllerCommon.moretext );
			$obj.parents('.article').find('.read_more').css({"height": "160px","overflow":"hidden"});
			$obj.parents('.article').find('.read_more_acommodation').css({"height": "300px","overflow":"hidden"});
			$obj.parents('.article').find('.white_read_more').css({"display":"block"});
		} else {
			$obj.addClass("less");
			$obj.html( ControllerCommon.lesstext );
			$obj.parents('.article').find('.read_more').removeAttr("style");
			$obj.parents('.article').find('.read_more_acommodation').removeAttr("style");
			$obj.parents('.article').find('.white_read_more').css({"display":"none"});
		}
		$obj.parent().prev().toggle();
		$obj.prev().toggle();
		return false;      
	},
	
	clickPrint:function(){					
         window.print();
	},
	
	clickLocationAttractionDetail:function(obj){
		var url = obj.parents('.box-slide-content').find('.location_details').attr('href');
		if( typeof  url !== 'undefined' )
			window.location.assign(url);
	},
	
	toggleCatInDetai:function(obj){		 
		$('.box-detail').removeClass('is_active');
		 var selector = obj.parent('.box-detail').find('.block-right-content').toggle();
		 obj.parent('.box-detail').addClass('is_active');
		 $('.box-detail').each(function(){			
			 if( !$(this).hasClass('is_active') ){	
			 	 $(this).find('.block-right-content').hide();			
			 }
		 });
	}
}
