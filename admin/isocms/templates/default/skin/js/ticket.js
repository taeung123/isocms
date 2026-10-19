$(function(){
	// getBadgeUnreadTicket();
	if(act == 'list_ticket'){
		loadListISOCMSTicketGlobe({});
	}
	$(document).on('click','.ticket-now',function(){
		var $_this = $(this),
			un_read = $(".in-ticket-now",$_this).data('total');
		if(parseInt(un_read)>0&& mod !='ticket'){
			window.open(path_ajax_script+'/list_ticket/', "_blank");
		}else{
			$_this.addClass('ticketed');
			$('.pop-ticket-now').addClass('ticketed');
		}
		return false;
	});
	$(document).on('click','.close-pop-ticket-now',function(){
		var $_this = $(this);
		$('.pop-ticket-now').removeClass('ticketed');
		$('.ticket-now').removeClass('ticketed');
		return false;
	});
	/**/
	$(document).on('keyup','.txtSearchISOCMSTicket',function(_ev){
		var _code = _ev.keyCode || _ev.which,
			_val = $(this).val();
		if(_code===13){
			loadListISOCMSTicketGlobe({});
		}
	});
	$(document).on('change','.filterTicket',function(){
		loadListISOCMSTicketGlobe({});
	});
	$(document).on('click','.filterISOCMSTicket',function(){
		loadListISOCMSTicketGlobe({});
	});
	$(document).on('click','.reply-ticket',function(){
		var $_this = $(this),
			ticket_id = $_this.attr('ticket_id');
		$('.form-reply[ticket_id='+ticket_id+']').removeClass('hide');
		return false;
	});
	/*hticket js*/
	$('.h_information_bar').on('click',function(e){
		var $this = $(this),
			sub = $this.data('submenu');
		e.preventDefault();
        $this.toggleClass('is-hactive');
		$this.closest('.div_information_bar').find('.'+sub).toggleClass('open');//sub-menu-information
	});
	$_document.off('click.help').on('click.help',".openHelp", function(){
		var $_this = $(this);
		if(!$Core.util.isEmpty($_this.attr('href')))
			window.open($_this.attr('href'),"CrmHelp", "width="+($(window).width())/2+", height="+$(window).height());
		return false;
	});
	$_document.on('keyup',".input-search-help", $Core.util.delay(function(){
		var $_this = $(this),
			keySearch = $_this.val();
		if(!$Core.util.isEmpty(keySearch)||1){
			$.post(path_ajax_script+'/index.php?mod=ticket&sub=default&act=searchhelp', {
				'keySearch':keySearch
			}, function(html){
				$('.holder-content-help').html(html);
			});
		}
	},500));
	$(document).on('click',".dropdown.mega-dropdown a", function(){
		$(this).parent().toggleClass('open');
		var w_w = $(window).width();
		if(w_w < 768){
			var offset_left = $(this).offset().left,
				closest = $(this).closest('.dropdown'),
				dropdown_menu = $(".dropdown-menu",closest),
				dropdown_menu_w = dropdown_menu.innerWidth(),
				translateX = offset_left-((w_w-dropdown_menu_w)/2);
			dropdown_menu.css({"transform":"translateX(-"+translateX+"px)"});
		}
		
	});
	$(document).on('click','.box-ticket_content img',function(){
		var $_this = $(this);
		$_this.addClass('img-full');
		fullScreen(document.querySelector(".box-ticket_content .img-full"));
		return false;
	});
	document.addEventListener('fullscreenchange', (event) => {
		/*let elem = event.target;
		let isFullscreen = document.fullscreenElement === elem;
		adjustMyControls(isFullscreen);*/
	  if (document.fullscreenElement) {

	  } else {
		  $('img.img-full').removeClass('img-full');
	  }
	});
	$(document).on('change','[name=cat_ticket]',function(){
		var $_this = $(this),
			cat_ticket = $_this.val();
		if(cat_ticket=='other'){
			$('[name=other_cat_ticket]').addClass('required');
		}else{
			$('[name=other_cat_ticket]').removeClass('required');
		}
		return false;
	});
	$_document.on('click', '.submitMyTicket', function(ev) {
		var $_this = $(this),
			_validated = 0,
			_closest = $_this.closest('form');
			//_thispop = $_this.closest('.frmPop');
		if ($('input.required,select.required', _closest).length) {
			$('input.required,select.required', _closest).each(function() {
				if ($Core.util.isEmpty($(this).val())) {
					_validated++;
					if($(this).hasClass('iso-selectbox')){
						$(this).select2('open');
					}else{
						$(this).focus();
					}
					return false;
				}
			});
		}
		var $content_ticket = $Core.util.getTextAreaContent("content_ticket");
		if($Core.util.isEmpty(_validated)){
			if($Core.util.isEmpty($content_ticket)){
				_validated++;
				$Core.alert.error(__['Please enter your content']);
			}
		}
		
		if (_validated == 0) {
			//toggleIndicatior(1);
			vietiso_loading(1);
			_closest.ajaxSubmit({
				type: 'POST',
				url: path_ajax_script + '/index.php?mod=ticket&sub=default&act=ajSubmitMyTicket',
				dataType: 'html',
				data:{content_ticket:$content_ticket},
				success: function(html) {
					//toggleIndicatior(0);
					vietiso_loading(0);
					/*if (html.indexOf('email') >= 0) {
						$('#NewUser_email').addClass('errorRequired').focus();
						alertError(__['This email already exists or is incorrect format']);
					} else if (html.indexOf('user') >= 0) {
						$('#NewUser_user_name').addClass('errorRequired').focus();
						alertError(__['User name already exists']);
					} else if (html.indexOf('invalidpassword') >= 0) {
						$('#NewUser_cpassword').addClass('errorRequired').focus();
						alertError(__['Password does not match']);
					} else if (html.indexOf('passwordstrong') >= 0) {
						$('#NewUser_cpassword').addClass('errorRequired').focus();
						alertError(__['Password is too short (at least 6 characters)']);
					} else {
						loadListCrmUserGlobe(html);
						//VCORE.popup.close(_thispop);
					}*/
					/*alertify.alert()
					  .setting({
						'title':__['Request sent successfully'],
						'label':'Ok',
						'message': __['alert request sent successfully'],
						'onok': function(){
							window.location.href = path_ajax_script+"/list_ticket/";
						}
					  }).show();*/
					alertify.success(__['Request sent successfully']+'. '+__['alert request sent successfully']);
					/*setTimeout(()=>{
						window.location.href = path_ajax_script+"/list_ticket/";
					},3000);*/
				}
			});
		}
		return false;
	}); 
	$(document).on('click','.close-ticket',function(){
		var $_this = $(this),
			ticket_id = $_this.attr('ticket_id');
		$.post(path_ajax_script+'/index.php?mod=ticket&act=ajCloseTicket', {
			'ticket_id':ticket_id
		}, function(res){
			window.location.reload();
		},'json');
		return false;
	});
	$(document).on('click','.submitReplyTicket',function(){
		var $_this = $(this),
			ticket_id = $_this.attr('ticket_id'),
			_validated = 0,
			_closest = $_this.closest('form');
		var $content_reply = $Core.util.getTextAreaContent("content_reply");
		if($Core.util.isEmpty(_validated)){
			if($Core.util.isEmpty($content_reply)){
				_validated++;
				$Core.alert.error(__['Please enter your content']);
			}
		}
		
		if (_validated == 0) {
			//toggleIndicatior(1);
			vietiso_loading(1);
			_closest.ajaxSubmit({
				type: 'POST',
				url: path_ajax_script + '/index.php?mod=ticket&sub=default&act=ajSubmitReplyTicket',
				dataType: 'json',
				data:{content_reply:$content_reply,ticket_id:ticket_id},
				success: function(res) {
					//toggleIndicatior(0);
					vietiso_loading(0);
					//fix slow send mail
					$.post(path_ajax_script+'/index.php?mod=ticket&act=sendEmailReplyTicket', {
						'ticket_id':res.ticket_id,
						'reply_id':res.reply_id,
					}, function(res){

					},'json');
					window.location.href = path_ajax_script+"/list_ticket/";
				}
			});
		}
		return false;
	});
});
function hrefUrl(url){
	window.location.href = url;
}
// function getBadgeUnreadTicket(){
// 	$.post(path_ajax_script+'/index.php?mod=ticket&act=ajGetBadgeUnreadTicket', {}, function(res){
// 		if($Core.util.isEmpty(res.total_unread)){
// 			//$('.badge-unread-ticket').empty().hide();
// 			$('.badge-unread-ticket').remove();
// 		}else{
// 			//$('.badge-unread-ticket').html(res.total_unread).show();
// 			if($('.badge-unread-ticket',$('.a_list_ticket')).length){
// 				$('.badge-unread-ticket',$('.a_list_ticket')).html(res.total_unread);
// 			}else{
// 				$('.a_list_ticket').append('<span class="badge-unread-ticket">'+res.total_unread+'</span>');
// 			}
// 			//console.log($Core.util);
// 			$Core.util.animated($('.badge-unread-ticket'),'bounceIn');
// 		}
// 	},'json');
// }
function loadListISOCMSTicketGlobe(options){
	var opts = options || {},
		adata = {};
	if($('.filterTicket').length){
		$('.filterTicket').each(function(){
			var column = $(this).data('column');
			if(typeof(column)!=='undefined'){
				adata[column] = $(this).val();
			}
		});
	}
	//toggleIndicatior(1);
	$("#holderISOCMSTicketGlobe").html('<img class="img-center-ripple" src="'+URL_IMAGES+'/ticket/ripple-loading.svg" />');
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=ticket&act=ajLoadListISOCMSTicketGlobe', 
		data: $.extend(opts,adata),
		dataType:'json',
		success: function(response){
			//toggleIndicatior(0);
			$("#holderISOCMSTicketGlobe").html(response.html);
			if(parseInt(response.totalPage)){
				$('#PageISOCMSTicket').pagination({
					total:response.totalRecord,
					pageSize:response.number_per_page,
					onRefresh : function(pageNumber,pageSize){
						loadListISOCMSTicketGlobe({'currentPage':pageNumber,'number_per_page':pageSize});
					},
					onSelectPage : function(pageNumber,pageSize){
						loadListISOCMSTicketGlobe({'currentPage':pageNumber,'number_per_page':pageSize});
					}
				});
			}
		}
	});
}