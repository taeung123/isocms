<div class="page_container">
	<div id="contentPage" class="pageMember pageSignIn" style="background-image:URL('{$clsConfiguration->getValue('site_member_background')}')">
		<div class="boxAbsolute">		          
			<div class="container">
				<div class="boxRegister">
					<div class="cd_header mb10">
						<div class="title-logo">{$core->get_Lang('Sign in')}</div>
						<div class="svg-logo">
							<img src="{$clsConfiguration->getValue('HeaderLogo')}"/>
						</div>
					</div>
					<form class="AppForm" method="post" action="" enctype="multipart/form-data">							
						<div class="login_by">
							<div class="buttons marg-top-10">
								<div class="facebook-up">
									<div class="alert-success-sign-fb" style="display:none;">
										  <img src="{$URL_IMAGES}/ajax-loader-1c1b99d848dcd43f870790a0b01002a9.gif" style="width:32px" />
									</div> 
									<i class="fa fa-facebook-square" aria-hidden="true"></i>
									<span>{$core->get_Lang('Sign in using Facebook')}</span>
								</div>
								<div class="google-up">
									<div class="alert-success-sign-gg" style="display:none;">
										  <img src="{$URL_IMAGES}/ajax-loader-1c1b99d848dcd43f870790a0b01002a9.gif" style="width:32px" />
									</div> 
									<i class="fa fa-envelope " aria-hidden="true"></i>
									<span>{$core->get_Lang('Sign in using Gmail')}</span>
								</div>
							</div>
						</div>
						<div class="login_bg">
							<div class="form-group">
								<div class="inner-addon left-addon">
									<input type="text" name="USER" autocomplete="off" class="form-control" id="emaillogin" placeholder="{$core->get_Lang('Enter your Email or Username')}" required>
								</div>
							</div>
							<div class="form-group">
								<div class="inner-addon left-addon">
									<input type="password" name="PASSWORD"  autocomplete="off" class="form-control" id="pwd" placeholder="{$core->get_Lang('Enter password')}" required>
								</div>
							</div>
							<div class="b-lnk last"><a href="{$PCMS_URL}account/forgot-password.html">{$core->get_Lang('Forgot password')}</a></div>
							<div class="form-group">	
								<div class="alert-success-sign">
								  <strong style="color:#f00">{$msgSubmitForm}</strong>
								</div> 
							</div>  
							<input type="hidden" name="return_url" value="{$return_url}"/>
							<input type="hidden" name="submit" value="Login" />
							<button type="submit" class="btn-signIn btn-cmd-submit">{$core->get_Lang('Signin')}</button>
						</div>																				
					</form>	
            		<div class="b-lnk">{$core->get_Lang("Don&rsquo;t have an account yet")}? <a href="{$PCMS_URL}account/signup.html">{$core->get_Lang('Sign up here')}</a></div>
            	</div>	
        	</div>
		</div>
	</div>
</div>

				