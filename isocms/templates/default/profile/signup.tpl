<div class="page_container mb60">
    <div class="container">
    	<div class="row mb20" style="margin-top:50px;">
			<div class="col-md-2"></div>			      
			<div class="col-md-8 col-sx-12 col-sm-9 block_signup" style="margin:15px auto; padding-left:0">				                               						
				 <form class="AppForm" method="post" action="{$PCMS_URL}profile/registerCustomer">
					  <div class="form-group row">
							<label for="contact_message" class="col-sm-3 form-control-label">
								{$core->get_Lang('Email address')}:<font color="#c00000">*</font>
							</label>
							<div class="col-sm-9">																	
								<input type="email" name="useremail" class="form-control" id="email" required>
							</div>
					  </div>   
					  
					  <div class="form-group row">
							<label for="contact_message" class="col-sm-3 form-control-label">
								{$core->get_Lang('Username')}:<font color="#c00000">*</font>
							</label>
							<div class="col-sm-9">																	
								<input type="text" name="username" class="form-control" id="username" required>
							</div>
					  </div>            
					 
					 <div class="form-group row">
							<label for="userpass" class="col-sm-3 form-control-label">
								{$core->get_Lang('Password')}:<font color="#c00000">*</font>
							</label>
							<div class="col-sm-9">																	
								<input type="password" name="userpass" class="form-control" id="userpass" required>
							</div>
					  </div> 
					  
					  <div class="form-group row">
							<label for="userpass" class="col-sm-3 form-control-label">
								{$core->get_Lang('Confirm password')}:<font color="#c00000">*</font>
							</label>
							<div class="col-sm-9">																	
								 <input type="password" name="confirmpass" class="form-control" id="confirmpass" required>
								 <input type="password" name="hid_reg" class="form-control" value="hid_reg" style="display:none;">
							</div>
					  </div> 
										
					  <div class="form-group row">
								<label for="contact_message" class="col-sm-3 form-control-label">{$core->get_Lang('Spam code')}:<font color="#c00000">*</font></label>
								
								<div class="col-sm-9">																	
										<img src="{$PCMS_URL}/captcha.php?sid={$sid}" onclick="this.src='{$PCMS_URL}/captcha.php?'+Math.random()+'&sid={$sid}'" width="80px" height="35px" />
										<input type="text" maxlength="5" min-length="5" name="security_code" id="security_code" style="float:left;width:200px" class="form-control required" />
									<span class="vietiso_error" style="display:none;color:#ff0000">{$core->get_Lang('Captcha enter incorrect')}!</span>
								</div>
					  </div>  
					  <div class="form-group row">
							<label class="col-sm-3 form-control-label"></label>
							<div class="col-sm-9">																	
								 <div class="checkbox">
									<label>
										<input type="checkbox" name="tccheck" value="1" checked="checked">
										{$core->get_Lang('I have read and agree to the Terms &amp; Conditions và Privacy policy của we Information')}.
									</label>
								</div>
							</div>
					  </div>               
					  
					   
					  <div class="form-group row">
							<label class="col-sm-3 form-control-label"></label>
							<div class="col-sm-9">																	
								 <div class="alert alert-warning alert-warning-sign" style="display:none;">
									  <strong>{$core->get_Lang('Warning')}!</strong> <span class="load_error_sign"></span>
								  </div> 
							</div>
					  </div>  
					  <div class="form-group row">
							<label class="col-sm-3 form-control-label"></label>
							<div class="col-sm-9">																	
								<button type="submit" class="btn btn-danger btn-cmd-submit-register" disabled>{$core->get_Lang('Register')}</button>
								<button type="button" class="btn btn-default">{$core->get_Lang('Cancel')}</button>
							</div>
					  </div> 						 
				</form>             
			</div>
			<div class="col-md-2" style="padding-right:0;">				
            </div>
        </div>
	</div>
</div>