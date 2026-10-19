<div class="page_container bg_fff">
	<div class="nav_agent">
		<div class="container">
			<ul class="nav_ul_agent">
				<li><a class="current" href="{$curl}" title="{$core->get_Lang('My Profile')}">{$core->get_Lang('My Profile')}</a></li>
				<li><a href="/travel-agent/booking.html" title="{$core->get_Lang('Tour booking')}">{$core->get_Lang('Tour booking')}</a></li>
				<li><a href="/travel-agent/reviews-and-photo.html" title="{$core->get_Lang('Reviews &amp; Photos')}">{$core->get_Lang('Reviews &amp; Photos')}</a></li>
			</ul>
		</div>
	</div>
    <div id="contentPage" class="pageAgent pageAgentLogin pdt0">
		<div class="container">
			<div class="box_change_pass">
				<div class="col_Left">
					<ul class="ul_nav_agent2">
						<li><a href="/travel-agent/my-profile.html" title="{$core->get_Lang('Edit Information')}">{$core->get_Lang('Edit Information')}</a></li>
						<li><a class="current" href="{$curl}" title="{$core->get_Lang('Password reset')}">{$core->get_Lang('Password reset')}</a></li>
					</ul>
				</div>
				<div class="col_Right">
					<div class="box_agent_register">
						<h1 class="size25 text_left mb10">{$core->get_Lang('Password reset')}</h1>
						<div class="note mb30">{$core->get_Lang('We will send instruction for creating a new password to the email address associated with your account')}.</div>
						<form id="agent_register_form" method="post" action="" enctype="multipart/form-data">
							<div class="form-group">
								<span class="icon email"><input class="form-control" type="text" name="email" id="email" placeholder="{$core->get_Lang('Enter Email')}"/></span>
								<div class="error" id="error_email"></div>
							</div>
							<div class="form-group mb20">
								<input class="form-control btn_register" id="btn_forgot_pass" type="button" value="{$core->get_Lang('Send Email')}">
								<input type="hidden" name="SEND_EMAIL" value="SEND_EMAIL">
								<div class="success" id="send_success_email"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_email_not_exits_valid = "{$core->get_Lang('Email address not exist in the system')}!";
	
	var msg_send_success_email = "{$core->get_Lang('Send email success')}!";
</script>
{literal}
<script type="text/javascript">
	$(function(){
		$("#btn_forgot_pass").click(function(){
			var $email = $("#email").val();

			if($("#email").val()==''){
				$('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			if(checkValidEmail($email)==false){
				$('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			var adata = {
				'email': $("#email").val(),
			};
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/index.php?mod=agent&act=ajAjaxForgotPass&lang='+LANG_ID,
				data: adata,
				dataType: "html",
				success: function(html){
					if(html.indexOf('email_not_correct')>=0){
						$('#error_email').html(msg_email_not_exits_valid).fadeIn().delay(3000).fadeOut();
						$("#email").focus();
						return false;
					}
					if(html.indexOf('reset_success')>=0){
						$('#send_success_email').html(msg_send_success_email).fadeIn().delay(3000).fadeOut();
						return false;
					}
				}
			});
			return false;
		});
	});
	function checkValidEmail(email){
		var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
</script>
{/literal}