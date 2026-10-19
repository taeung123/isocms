<main id="signin_main" style="background-image:URL('{$clsConfiguration->getValue('site_member_background')}')">
	<div class="signin_wrap">
		<div class="signform_box">
			<div class="signformM_wrap">
				<h2>{$core->get_Lang('Sign up')}</h2>
				<section class="signformM_section">
					<form id="frmRegister" method="post" action="" enctype="multipart/form-data" class="AppForm signformM_form">
						<div class="form-group">
							<div class="inner-addon left-addon">
								<input type="text" name="username" autocomplete="off" class="form-control" id="username" placeholder="{$core->get_Lang('Enter your Email or Username')}" required>
							</div>
							<div class="error_tip" id="error_username" style="display: none;"></div>
						</div>
						<div class="form-group">
							<div class="inner-addon left-addon">
								<input type="text" name="useremail" autocomplete="off" class="form-control" id="useremail" placeholder="{$core->get_Lang('Enter your email')}" required>
							</div>
							<div class="error_tip" id="error_email" style="display: none;"></div>
						</div>
						<div class="form-group">
							<div class="inner-addon leftaddon">
								<input type="password" name="userpass"  autocomplete="off" class="form-control" id="userpass" placeholder="{$core->get_Lang('Enter password')}" required>
							</div>
							<div class="error_tip" id="error_password" style="display: none;"></div>
						</div>
						<div class="form-group">
							<div class="inner-addon leftaddon">
								<input type="password" name="confirmpass"  autocomplete="off" class="form-control" id="confirmpass" placeholder="{$core->get_Lang('Repeat password')}" required>
							</div>
							<div class="error_tip" id="error_re_password" style="display: none;"></div>
						</div>
						<div class="form-group">
							{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
								<label class=" title" for="secure_code">
									<abbr class="required" title="required">*</abbr> {$core->get_Lang('securecode')}
								</label>
								<div>
									<input autocomplete="off" type="text" class="form-control security_code required" name="secure_code" value="" maxlength="5" />
									<img src="{$PCMS_URL}/captcha.php?sid={$sid}" width="80" height="36" alt="Secure" />
								</div>
							{else}
								<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
								{if $msgSubmitForm ne ''}
								<div class="error text_left">{$msgSubmitForm}</div>
								{/if}
							{/if}
						</div> 
						<button type="button" class="btn-signIn btn-cmd-submit mb0">
							<div class="loading-inline-rotate" style="display: none;">
								<svg aria-hidden="true" class="klk_c_symbol klook-symbol">
									<use xlink:href="#icon-loading">
									<svg id="icon-loading" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 20.556A8.556 8.556 0 1 0 3.444 12 1.222 1.222 0 1 1 1 12C1 5.925 5.925 1 12 1s11 4.925 11 11-4.925 11-11 11a1.222 1.222 0 1 1 0-2.444z"></path></svg>
									</use>
								</svg>
							</div>
							<span>{$core->get_Lang('Signup')}</span>
						</button>
						<input type="hidden" name="submit" value="SignUp">
						<div id="error_tip" class="error_tip"></div>
					</form>
				</section>
				<section class="signM_social_section">
					<h3 class="signM_social_head"><span>{$core->get_Lang('or sign in with')}</span></h3>
					<div class="social-channels">
						<a href="javascript:void(0);"  class="facebook-up social-channel signM_social-facebook">
						<svg aria-hidden="true" class="klk_c_symbol klook-symbol">
						<use xlink:href="#icon-facebook-logo">
						<svg id="icon-facebook-logo" viewBox="0 0 32 32"><g fill="none" fill-rule="evenodd"><rect width="32" height="32" fill="#3C5A99" rx="4"></rect><path fill="#FEFEFE" d="M21.988 31.987v-12.34h4.143l.62-4.81h-4.763v-3.07c0-1.393.387-2.342 2.384-2.342l2.547-.001V5.122c-.441-.058-1.953-.19-3.712-.19-3.672 0-6.185 2.242-6.185 6.358v3.547h-4.153v4.81h4.153v12.34h4.966z"></path></g></svg>
						</use>
						</svg>
						<h4>Facebook</h4>
						</a> 
						<a href="javascript:void(0);" class="google-up social-channel social-channel-google">
						<svg aria-hidden="true" class="klk_c_symbol klook-symbol">
						<use xlink:href="#icon-g-logo">
						<svg id="icon-g-logo" viewBox="0 0 512 512"><path fill="#fbbb00" d="M113.47 309.408L95.648 375.94l-65.139 1.378C11.042 341.211 0 299.9 0 256c0-42.451 10.324-82.483 28.624-117.732h.014L86.63 148.9l25.404 57.644c-5.317 15.501-8.215 32.141-8.215 49.456.002 18.792 3.406 36.797 9.651 53.408z"></path><path fill="#518ef8" d="M507.527 208.176C510.467 223.662 512 239.655 512 256c0 18.328-1.927 36.206-5.598 53.451-12.462 58.683-45.025 109.925-90.134 146.187l-.014-.014-73.044-3.727-10.338-64.535c29.932-17.554 53.324-45.025 65.646-77.911h-136.89V208.176h245.899z"></path><path fill="#28b446" d="M416.253 455.624l.014.014C372.396 490.901 316.666 512 256 512c-97.491 0-182.252-54.491-225.491-134.681l82.961-67.91c21.619 57.698 77.278 98.771 142.53 98.771 28.047 0 54.323-7.582 76.87-20.818l83.383 68.262z"></path><path fill="#f14336" d="M419.404 58.936l-82.933 67.896C313.136 112.246 285.552 103.82 256 103.82c-66.729 0-123.429 42.957-143.965 102.724l-83.397-68.276h-.014C71.23 56.123 157.06 0 256 0c62.115 0 119.068 22.126 163.404 58.936z"></path></svg>
						</use>
						</svg>
						<h4>Google</h4>
						</a>
					</div>
				</section>
				<p class="signM_bottom_bar clearfix">
			<span>{$core->get_Lang('Already have a account')}?</span><a href="{$clsProfile->getLink('signin')}" title="{$core->get_Lang('Sign in')}">{$core->get_Lang('Sign in')}</a>
			</p>
			</div>
		</div>
	</div>
</main>
<link rel="stylesheet" href="{$URL_CSS}/member2.css?v={$upd_version}"/>
<script>
	var msg_username_required = "{$core->get_Lang('Your username should not be empty')}!";
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_email_exits = "{$core->get_Lang('Email Exits')}!";
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_re_password_required = "{$core->get_Lang('Your comfirm password should not be empty')}!";
	var msg_match_password_required = "{$core->get_Lang('Confirm password do not match')}!";
	var msg_signup_error = "{$core->get_Lang('Account or password was incorrect')}!";
	var msg_signup_success = "{$core->get_Lang('Signup success')}!";
	var msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			$(".btn-signIn").click(function(){
				var $username = $("#username").val();
				var $email = $("#useremail").val();
				var $password = $("#userpass").val();
				var $confirmpass=$("#confirmpass").val();
				var $submit=$("input[name='submit']").val();
				var $g_recaptcha_response=$("textarea[name='g-recaptcha-response']").val();
				
				if(username==''){
					$('#error_username').html(msg_email_required).fadeIn().delay(3000).fadeOut();
					$("#username").focus();
					return false;
				}
				if($email==''){
					$('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
					$("#useremail").focus();
					return false;
				}
				if(checkValidEmail($email)==false){
					$('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
					$("#useremail").focus();
					return false;
				}
				if($password==''){
					$('#error_password').html(msg_password_required).fadeIn().delay(3000).fadeOut();
					$("#userpass").focus();
					return false;
				}
				if($confirmpass==''){
					$('#error_re_password').html(msg_re_password_required).fadeIn().delay(3000).fadeOut();
					$("#confirmpass").focus();
					return false;
				}
				if($confirmpass!=$password){
					$('#error_re_password').html(msg_match_password_required).fadeIn().delay(3000).fadeOut();
					$("#confirmpass").focus();
					return false;
				}
				var adata={
					'fullname':$username,
					'useremail':$email,
					'userpass':$password,
					'g-recaptcha-response':$g_recaptcha_response,
					'submit':$submit
					
				}
				if($username!=''&&$email!=''&&$password!=''&&$confirmpass!=''){
					$(".btn-signIn span").hide();
					$(".btn-signIn .loading-inline-rotate").show();
				}
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod=member&act=ajSignup',
					data:adata,
					dataType:'html',
					success:function(html){
						if(html.indexOf("_SIGNUP_SUCCESS") >= 0) {
								$('#error_tip').html(msg_signup_success).fadeIn().delay(2000).fadeOut();
								$(".btn-signIn .loading-inline-rotate").hide();
								$(".btn-signIn span").show();
								location.href = DOMAIN_NAME+extLang;
							
						}else{
							if(html.indexOf("_CAPTCHA_NOT_CHECK") >= 0){
								$('#error_tip').html(msg_recapcha).fadeIn().delay(2000).fadeOut();
							}else if(html.indexOf("_EMAIL_EXITS")>=0){
								$('#error_tip').html(msg_email_exits).fadeIn().delay(2000).fadeOut();
							}else {
								$('#error_tip').html(msg_signup_error).fadeIn().delay(2000).fadeOut();

							}
							$(".btn-signIn .loading-inline-rotate").hide();
							$(".btn-signIn span").show();
						} 
					}
				});
				//return false;
			});
		});
		function checkValidEmail(email){
			var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
	})
</script>
{/literal}
