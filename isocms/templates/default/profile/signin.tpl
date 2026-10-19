<div class="page_container mb60">
    <div class="container">
		<div class="row">
			<div class="mb20 col-md-12 col-sx-12 col-sm-12">
				<ul class="menu-body-detail"  itemscope itemtype="http://schema.org/BreadcrumbList">
					<li itemprop="name"><a href="{$PCMS_URL}" title="" itemprop="url">Home</a></li>                        					
					<li itemprop="name">
						<a class="current" href="{$PCMS_URL}/account/sign-in.html" title="Sign in">
							<span>&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;</span><b>Sign in</b>
						</a>
					</li>
				</ul>
			</div>
		</div>
    	<div class="row" style="margin:5% 0;"> 			          
            <div class="col-md-2"></div>
			<div class="col-md-8 col-sx-12 col-sm-12" style="border:none !importaint;">
					{if $device_mobile eq ''} <!--Case desktop-->
						<form class="AppForm" method="post" action="{$PCMS_URL}profile/sign-in.html">
							<div class="row">								
								<div class="col-md-5 col-sx-12 col-sm-12 login_by">
									<ul class="loginby_URL">
										<li><a class="facebook-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_FACEBOOK}" /></a></li>
										<li><a  class="google-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_GOOGLE}" /></a></li>
										<li><a class="yahoo-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_YAHOO}" /></a></li>
										<li><a class="twitter-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_TWITTER}" /></a></li>
									</ul>
									<p class="mt10 permission">We will post anything without permission</p>
								</div>
								<div class="or col-md-2 col-sx-12 col-sm-12" style="width: 50px;font-size: 14px;">OR</div>
								<div class="col-md-6 col-sx-12 col-sm-12 login_bg">
									<div class="form-group">
										<label for="email">Email address:</label>
										<div class="inner-addon left-addon">
											<i class="glyphicon glyphicon-envelope"></i>
											<input type="text" name="USER" class="form-control" id="email" required>
										</div>
									</div>
									<div class="form-group">
										<label for="pwd">Password:</label>
										<div class="inner-addon left-addon">
											<i class="glyphicon glyphicon-lock"></i>
											<input type="password" name="PASSWORD" class="form-control" id="pwd" required>
										</div>
									</div>
									<input type="hidden" name="hidsignin" value="hidsignin" />
									<div class="checkbox">
										<label><input type="checkbox"> Remember me</label>
									</div>
									<div class="alert alert-warning alert-warning-sign" style="display:none;"> 
									<strong>Warning!</strong> <span class="load_error_sign"></span> </div>
									<button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-log-in"></i> Signin</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								</div>																				
							</div>
						</form>	
					{else}
					<form class="AppForm" method="post" action="{$PCMS_URL}/account/sign-in.html">
							<div class="row">						
								<div class="col-md-6 col-sx-12 col-sm-12 login_bg">
									<div class="form-group">
										<label for="email">Email address:</label>
										<div class="inner-addon left-addon">
											<i class="glyphicon glyphicon-envelope"></i>
											<input type="text" name="USER" class="form-control" id="email" required>
										</div>
									</div>
									<div class="form-group">
										<label for="pwd">Password:</label>
										<div class="inner-addon left-addon">
											<i class="glyphicon glyphicon-lock"></i>
											<input type="password" name="PASSWORD" class="form-control" id="pwd" required>
										</div>
									</div>
									<div class="checkbox">
										<label><input type="checkbox"> Remember me</label>
									</div>
									<div class="alert alert-warning alert-warning-sign" style="display:none;"> 
										<strong>Warning!</strong> <span class="load_error_sign"></span> 
									</div>
									<button type="submit" class="btn btn-danger" style="width:100%">
									<i class="glyphicon glyphicon-log-in"></i> Sign in
									</button>
									<div class="form-group" style="margin-top:20px;">
										<a href="#" class="text-left forgot_password">Forgot password?</a>
										<a href="{$PCMS_URL}/account/register.html" class="text-right new_here">New here? Sign up</a>
									</div>
								</div>								
								<div class="col-md-5 col-sx-12 col-sm-12 login_by login_by_mobile">
									<ul class="loginby_URL">
										<li><a class="facebook-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_FACEBOOK}" /></a></li>
										<li><a  class="google-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_GOOGLE}" /></a></li>
										<li><a class="yahoo-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_YAHOO}" /></a></li>
										<li><a class="twitter-login button" href="javascript:void(0);"><img src="{$IMG_LOGIN_TWITTER}" /></a></li>
									</ul>
									<p class="mt10 permission">We will post anything without permission</p>
								</div>												
							</div>
						</form>	
				{/if}
						
			</div>
			<div class="col-md-2"></div>
        </div>
	</div>
</div>


				