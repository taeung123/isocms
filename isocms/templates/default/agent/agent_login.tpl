<div class="page_container">
	<div class="breadcrumb-main bg_f5f5f5">
        <div class="container">
            <ol class="breadcrumb bg_f5f5f5 hidden-xs mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="name"><a itemprop="url" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
				<li itemprop="name"><a itemprop="url" href="{$curl}" title="{$core->get_Lang('Travel Agent')}">{$core->get_Lang('Travel Agent')}</a></li>
				<li itemprop="name"><a itemprop="url" href="{$curl}" title="{$core->get_Lang('Login')}">{$core->get_Lang('Login')}</a></li>
            </ol>
        </div>
    </div>
    <div id="contentPage" class="pageAgent pageAgentLogin">
		<div class="container">
			<section>
			<h1 class="size35 text_left">{$core->get_Lang('Signin')}</h1>
			<div class="box_agent_register">
				<form id="agent_register_form" method="post" action="" enctype="multipart/form-data">
					{if $msgSubmitForm ne ''}
					<div class="alert alert-warning">
					  <strong>{$core->get_Lang('Warning')}!</strong> {$msgSubmitForm}
					</div>
					{/if}
					<div class="form-group">
						<label>{$core->get_Lang('Email')}</label>
						<span class="icon email"><input class="form-control" type="text" name="email" id="email" placeholder="{$core->get_Lang('Enter your Email')}"/></span>
						<div class="error" id="error_email"></div>
					</div>
					<div class="form-group">
						<label>{$core->get_Lang('Password')}</label>
						<span class="icon password"><input class="form-control" type="password" name="password" id="password" placeholder="{$core->get_Lang('Enter Password')}"/></span>
						<div class="error" id="error_password"></div>
					</div>
					<p class="text_right"><a href="" title="{$core->get_Lang('Forgot password')}?">{$core->get_Lang('Forgot password')}?</a></p>
					<div class="form-group mb20">
						<input class="form-control btn_register btn_login" id="btn_login" type="submit" value="{$core->get_Lang('Signin')}">
						<input type="hidden" name="LOGIN" value="LOGIN">
					</div>
					<div class="bottom-form">
						<p class="text-right">{$core->get_Lang('Already have an account')}? <a href="" title="{$core->get_Lang('Signin')}">{$core->get_Lang('Signin')}</a></p>
					</div>
				</form>
			</div>
			</section>
		</div>
	</div>
</div>
<script type="text/javascript">
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";

	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
</script>
{literal}
<script type="text/javascript">
	$(function(){
		$("#btn_login").click(function(){
			var $email = $("#email").val();
			var $password = $("#password").val();

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
			
			if($("#password").val()==''){
				$('#error_password').html(msg_password_required).fadeIn().delay(3000).fadeOut();
				$("#password").focus();
				return false;
			}
		});
	});
	function checkValidEmail(email){
		var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
</script>
{/literal}