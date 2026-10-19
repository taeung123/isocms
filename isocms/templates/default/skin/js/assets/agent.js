$(function(){
	$(document).on('click', '.menu-tab', function(){			
			var _this = $(this);								
			var type = _this.attr('rel');			
			switch(type){
				case 'tab_menu2':
					var url = _this.attr('link_redirect');
					window.location.href = url;					
				break;
				case 'tab_menu3':					
					var url = _this.attr('link_redirect');
					window.location.href = url;
				break;
				case 'tab_menu4':					
					var url = _this.attr('link_redirect');
					window.location.href = url;
				break;
				case 'tab_menu5':					
					var url = _this.attr('link_redirect');
					window.location.href = url;
				break;
				case 'tab_menu6':					
					 var url = _this.attr('link_redirect');
					 window.location.href = url;
				break;				
			}
	});	
	if($city_id!=''){
		$(document).on('click', '.btn-seemore', function(){
			$('.icon-load-ajax').show();
			var _this = $(this);
			$currentPage++;						
			ControllerAgents.loadMoreAgent( $currentPage, $limitPage, $city_id , $(this) );
		});							
	}			
});
var ControllerAgents = {
	 ellipsestext : "",
     moretext : "Read more"+'&nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i>',
     lesstext : "Read less"+'&nbsp;<i class="fa fa-chevron-up" aria-hidden="true"></i> ',			
	 loadMoreAgent: function( $currentPage, $limitPage, $city_id,$obj ){
		_this = $obj;		
		$.ajax({			
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+_MOD+"&act=loadMore",
			data : {'city_id':$city_id,'page':$currentPage,'limit':$limitPage},
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
}
