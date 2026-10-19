<main id="signin_main" style="background-image:URL('{$clsConfiguration->getValue('site_member_background')}')">
	<div class="signin_wrap">
		<div class="signform_box">
			<div class="signformM_wrap">
				<h2>{$core->get_Lang('Sign in')}</h2>
				<section class="signformM_section">
					<form id="signformM_form" method="post" action="" enctype="multipart/form-data" class="AppForm signformM_form">
						<div class="form-group">
							<div class="inner-addon left-addon">
								<input type="text" name="USER" autocomplete="off" class="form-control" id="emaillogin" placeholder="{$core->get_Lang('Enter your Email or Username')}" required>
							</div>
							<div class="error_tip" id="error_email" style="display: none;"></div>
						</div>
						<div class="form-group">
							<div class="inner-addon leftaddon">
								<input type="password" name="PASSWORD"  autocomplete="off" class="form-control" id="pwd" placeholder="{$core->get_Lang('Enter password')}" required>
							</div>
							<div class="error_tip" id="error_password" style="display: none;"></div>
						</div>
						<div class="remember-forgot">
							<span class="hidden">
								<input name="rememberEmail" type="checkbox">{$core->get_Lang('Remember me')}
							</span>  
							<a id="ForgotPassLink" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal" class="fr f_h_main">{$core->get_Lang('Forgot password')}?</a>
<!--							<a href="{$clsProfile->getLink('forgot_pass')}" class="fr f_h_main">{$core->get_Lang('Forgot password')}?</a>-->
						</div>
						<button type="button" class="btn-signIn btn-cmd-submit mb0">
							<div class="loading-inline-rotate" style="display: none;">
								<svg aria-hidden="true" class="klk_c_symbol klook-symbol">
									<use xlink:href="#icon-loading">
									<svg id="icon-loading" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 20.556A8.556 8.556 0 1 0 3.444 12 1.222 1.222 0 1 1 1 12C1 5.925 5.925 1 12 1s11 4.925 11 11-4.925 11-11 11a1.222 1.222 0 1 1 0-2.444z"></path></svg>
									</use>
								</svg>
							</div>
							<span>{$core->get_Lang('Signin')}</span>
						</button>
						<input type="hidden" id="return_url" name="return_url" value="{$return_url}"/>
						<input type="hidden" name="submit" value="Login" />
						<!---->
						<div id="error_tip" class="error_tip"></div>
					</form>
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					 <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span class="fa fa-times"></span>
							</button>
						  <div class="modal-body">
						  	<div class="body page-bg round-bottom pal">
									<h2 class="mt0 mb20">{$core->get_Lang('Password reset')}</h2>
									<div class="note size16">{$core->get_Lang('We will send instruction for creating a new password to the email address associated with your account')}.</div>
									<form novalidate class="ng-pristine ng-valid">
										<div class="mtm mbm">
											<input type="email" class="isoTxt required txt350" placeholder="{$core->get_Lang('Your Email')}" name="user_email" value="" />
											<div id="message_box" class="mb10 mt05" style="display:none"></div>
										</div>
										<div class="line mt10">
												<button type="button" id="forgotBtn" class=" submitClick">{$core->get_Lang('Reset')} &raquo;</button>
												<input type="hidden" name="forgotVal" value="forgotVal" />
										</div>
									</form>
								</div>
						  </div>
						</div>
					  </div>
					</div>
				</section>
				<section class="signM_social_section"><!---->
					<h3 class="signM_social_head"><span>{$core->get_Lang('or sign in with')}</span></h3>
					<div class="social-channels">
						<a href="javascript:void(0);"  class="facebook-signin social-channel signM_social-facebook">
						<svg aria-hidden="true" class="klk_c_symbol klook-symbol">
						<use xlink:href="#icon-facebook-logo">
						<svg id="icon-facebook-logo" viewBox="0 0 32 32"><g fill="none" fill-rule="evenodd"><rect width="32" height="32" fill="#3C5A99" rx="4"></rect><path fill="#FEFEFE" d="M21.988 31.987v-12.34h4.143l.62-4.81h-4.763v-3.07c0-1.393.387-2.342 2.384-2.342l2.547-.001V5.122c-.441-.058-1.953-.19-3.712-.19-3.672 0-6.185 2.242-6.185 6.358v3.547h-4.153v4.81h4.153v12.34h4.966z"></path></g></svg>
						</use>
						</svg>
						<h4>Facebook</h4>
						</a> 
						<a href="javascript:void(0);" class="google-signin social-channel social-channel-google">
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
			<span>{$core->get_Lang('No account yet? Sign up now&#33;')}</span><a href="{$clsProfile->getLink('signup')}">{$core->get_Lang('Sign up')}</a>
			</p>
			</div>
		</div>
	</div>
</main>
<link rel="stylesheet" href="{$URL_CSS}/member2.css?v={$upd_version}"/>
<script>
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_signin_error = "{$core->get_Lang('Account or password was incorrect')}!";
	var msg_signin_success = "{$core->get_Lang('Signin success')}!";
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			$(".btn-signIn").click(function(){
				var $password = $("#pwd").val();
				var $email = $("#emaillogin").val();
				var $return_url=$("#return_url").val();
				var $submit=$("input[name='submit']").val();
				
				if($email==''){
					$('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
					$("#emaillogin").focus();
					return false;
				}
				if(checkValidEmail($email)==false){
					$('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
					$("#emaillogin").focus();
					return false;
				}
				if($password==''){
					$('#error_password').html(msg_password_required).fadeIn().delay(3000).fadeOut();
					$("#pwd").focus();
					return false;
				}
				var adata={
					'USER':$email,
					'PASSWORD':$password,
					'return_url':$return_url,
					'submit':$submit
					
				}
				if($email!=''&&$password!=''){
					$(".btn-signIn span").hide();
					$(".btn-signIn .loading-inline-rotate").show();
				}
				$.ajax({
					type:'POST',
					url:path_ajax_script+'/index.php?mod=member&act=ajSignin',
					data:adata,
					dataType:'html',
					success:function(html){
						if(html.indexOf("_LOGIN_SUCCESS") >= 0) {
								$('#error_tip').html(msg_signin_success).fadeIn().delay(2000).fadeOut();
								$(".btn-signIn .loading-inline-rotate").hide();
								$(".btn-signIn span").show();
								if($.trim($return_url) != '')
									location.href = $return_url;
								else
									location.href = DOMAIN_NAME+extLang;
							
						} else {
							$('#error_tip').html(msg_signin_error).fadeIn().delay(2000).fadeOut();
							$(".btn-signIn .loading-inline-rotate").hide();
							$(".btn-signIn span").show();
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
	})
</script>
{/literal}	
<script type="text/javascript">
var require_email = "{$core->get_Lang('Error &#33; Please enter your email')}.";
var require_invalid_email = "{$core->get_Lang('Error &#33; Please enter your email valid')}.";
var reset_success = "{$core->get_Lang('Reset success &#33; Please check your email and active your account')}.";
</script>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		$(document).on('click','#forgotBtn',function(e){
			var $_this = $(this);
			var $user_email = $('input[name=user_email]');
			var $forgotVal = $('input[name=forgotVal]');
			/* Valid */
			if($user_email.val()== '' || !checkVaidEmail($user_email.val())){
				$('#message_box').html(require_invalid_email);
				$('#message_box').addClass('text-danger').show();
				$user_email.focus();
				return false;
			}
			/**/
			var adata = {
				'user_email': $user_email.val(),
				'forgotVal': $forgotVal.val(),
			};
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/index.php?mod=member&act=ajAjaxForgotGlobal',
				data: adata,
				dataType: "html",
				success: function(html){
					if(html.indexOf('email_empty_error')>=0){
						$('#message_box').html(require_email);
						$('#message_box').removeClass('text-success').addClass('text-danger').show();
						$user_email.focus();
						return false;
					}
					if(html.indexOf('email_not_correct')>=0){
						$user_email.focus();
						$('#message_box').html(require_invalid_email);
						$('#message_box').removeClass('text-success').addClass('text-danger').show();
						return false;
					}
					if(html.indexOf('reset_success')>=0){
						$('#message_box').html(reset_success);
						$('#message_box').removeClass('text-danger').addClass('text-success').show();
						$('input[class=isoTxt]').val('');
						setTimeout(function(){location.reload()}, 3000);
					}
				}
			});
			return false;
		});
	})
</script>
{/literal}

<script defer src="{$URL_JS}/jquery.social.login.js?v={$upd_version}"></script>