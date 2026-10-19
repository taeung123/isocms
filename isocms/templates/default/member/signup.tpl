<div class="page_container">
	<div id="contentPage" class="pageMember pageSignUp" style="background-image:URL('{$clsConfiguration->getValue('site_member_background')}')">
		<div class="boxAbsolute register">		          
			<div class="container">
				<div class="boxRegister">
					<div class="cd_header mb10">
						<div class="title-logo">{$core->get_Lang('Sign up')}</div>
						<div class="svg-logo">
							<img src="{$clsConfiguration->getValue('HeaderLogo')}" alt=""/>
						</div>
					</div>
					<form class="AppForm"  method="post" action="/" id="frmRegister">
						{if _IS_AGENT eq 1}
						<div class="form-group agentCheck">
							<div class="inline-block" style="margin-right:10px">
								<input id="traveller" type="radio" name="agent" checked="" value="1">
								<label for="traveller">{$core->get_Lang("I&#39;m a traveller")}</label>
							</div>
							<div class="inline-block">
								<input id="agent" type="radio" name="agent" value="2">
								<label for="agent">{$core->get_Lang("I&#39;m a travel agent")}</label>
							</div>
						</div>
						{/if}
						<div class="signup_by">
							<div class="buttons marg-top-10">
								<div class="facebook-up">
									<i class="fa fa-facebook-square" aria-hidden="true"></i>
									<span>{$core->get_Lang('Sign up using Facebook')}</span>
								</div>
								<div class="google-up">
									<i class="fa fa-envelope " aria-hidden="true"></i>
									<span>{$core->get_Lang('Sign in using Gmail')}</span>
								</div>
								<div class="yahoo-up" style="display:none">
									<i class="fa fa-yahoo" aria-hidden="true"></i>
								</div>
								<div class="twiter-up" style="display:none">
									<i class="fa fa-twitter-square" aria-hidden="true"></i>
								</div>
							</div>
							<div class="or-content">
								<div class="or-line"></div>
								<div class="or">{$core->get_Lang('оr')}</div>
								<div class="or-line"></div>
							</div>
						</div>
						<div class="form-group">		
							<input type="text" name="username" class="form-control" id="username" placeholder="{$core->get_Lang('Full name')}" required>													
						</div>						  
						<div class="form-group">																
							<input type="email" name="useremail" class="form-control" id="email" placeholder="{$core->get_Lang('Enter your email')}" required>
						</div>						 
						<div class="form-group">															
							<input type="password" name="userpass" class="form-control" id="userpass" placeholder="{$core->get_Lang('Enter password')}" required>
						</div> 						  
						<div class="form-group">															
							<input type="password" name="confirmpass" class="form-control" id="confirmpass" placeholder="{$core->get_Lang('Repeat password')}" required>
							<input type="password" name="hid_reg" class="form-control" value="hid_reg" style="display:none;">
						</div>											
						<div class="form-group">
							<img src="{$PCMS_URL}/captcha.php?sid={$sid}" onclick="this.src='{$PCMS_URL}/captcha.php?'+Math.random()+'&sid={$sid}'" width="80" height="35" alt="" />
							<input type="text" maxlength="5" minlength="5" name="security_code" id="security_code" style="float:left;width:210px; margin-right:5px" class="form-control required" />
						<span class="vietiso_error" style="display:none;color:#ff0000">{$core->get_Lang('Captcha enter incorrect')}!</span>
						</div>  
						<div class="form-group">																
							<div class="checkbox subscribe">
								<label><input type="checkbox" name="tccheck" value="1" checked="checked">{$core->get_Lang('Send me special deals to my inbox')}</label>
							</div>
						</div>               						  						   
						<div class="form-group">	
							<div class="alert-success-sign">
							  <strong>{$msgSubmitForm}</strong>
							</div> 
						</div>  
						<div class="form-group">																
							<button type="submit" class="btn-cmd-submit-register">{$core->get_Lang('Register')}</button>
							<input type="hidden" name="hid_reg" value="hid_reg">
						</div>                 
					</form>
					<div class="b-lnk">{$core->get_Lang('Already have an account')}?  <a href="{$extLang}/account/signin.html">{$core->get_Lang('Sign in')}</a></div>  
				</div>	
			</div>
		</div>
	</div>
</div>

{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){
			$('#frmRegister').validate({
				rules: {
					userpass: "required",
					confirmpass: {
					equalTo: "#userpass"
					}
				}
			});	
		});
	})
</script>
{/literal}