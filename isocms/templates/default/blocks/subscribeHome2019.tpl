<section class="box_home_2019 subscribeHome">
	<div class="container">
		<div class="title text_center mb30">
			<h2 class="h2_title mb10 color_fff">{$core->get_Lang('Newsletter Subcribe')}</h2>
			<p class="color_fff">{$core->get_Lang('Pick from our amazing adventures. How on earth will you choose?')}</p>
		</div>
		<div class="regiter-email">
			<form method="post" action="{$extLang}" class="subscribeform">
				<input type="text" id="email_subscribe" placeholder="{$core->get_Lang('Your email')}" class="isoTxt txt required" >    
				<input class="btnSubscribe btnEmailSubscribe btnEmailSubscribeHome" id="submitSubscribeHome" type="button" name="btnSubmit" value="submit"> 
				<input type="hidden" value="Sign me up" name="Submit"> 
			</form>
			<div id="subcribe_msg" class="subcribe_msg"></div>
		</div>
	</div> 
	<script>
		var path_ajax_script = '{$PCMS_URL}';    
		var msg_email_required = "{$core->get_Lang('Your email should not be empty ')}!";
		var msg_email_not_valid = "{$core->get_Lang('Your email is not valid')}!";
		var msg_success = "{$core->get_Lang('Sign up for email success')}!";
		var msg_exits = "{$core->get_Lang('Email address already exists')}!";
	</script>
	{literal}
	<script>
	$(function(){
		$("#submitSubscribeHome").click(function(){
			var $subscribe_email = $("#email_subscribe").val();
			
			if($("#email_subscribe").val()==''){
				 $('#subcribe_msg').html(msg_email_required).fadeIn().delay(3000).fadeOut();
				 $("#email_subscribe").focus();
				 return false;
			}
			if(checkValidEmail($subscribe_email)==false){
				 $('#subcribe_msg').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
				 $("#email_subscribe").focus();
				 return false;
			}
			
			var adata = {
				'email' : $subscribe_email
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=home&act=ajSubmitSubscribe&lang='+LANG_ID,
				data : adata,
				dataType:'html',
				success:function(html){
				if(html.indexOf("_SUCCESS") >= 0) {
						$('#subcribe_msg').html(msg_success).fadeIn().delay(3000).fadeOut();
					} else {
						$('#subcribe_msg').html(msg_exits).fadeIn().delay(3000).fadeOut();
					}
				}
			});
			return false;
		});
	});
	function checkValidEmail(e) {
		var a = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return a.test(e)
	}
	</script>
	{/literal}
</section>  