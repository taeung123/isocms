<div id="signup" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sign up</h4>
      </div>
      <div class="modal-body">
           <form class="AppForm" method="post" action="{$PCMS_URL}profile/register.html">
		   		  <div class="form-group row">
						<label for="contact_message" class="col-sm-3 form-control-label">
							Email address:<font color="#c00000">*</font>
						</label>
						<div class="col-sm-9">																	
							<input type="email" name="useremail" class="form-control" id="email" required>
						</div>
				  </div>   
				  
				  <div class="form-group row">
						<label for="contact_message" class="col-sm-3 form-control-label">
							Username:<font color="#c00000">*</font>
						</label>
						<div class="col-sm-9">																	
							<input type="text" name="username" class="form-control" id="username" required>
						</div>
				  </div>            
                 
                 <div class="form-group row">
						<label for="userpass" class="col-sm-3 form-control-label">
							Password:<font color="#c00000">*</font>
						</label>
						<div class="col-sm-9">																	
							<input type="password" name="userpass" class="form-control" id="userpass" required>
						</div>
				  </div> 
				  
				  <div class="form-group row">
						<label for="userpass" class="col-sm-3 form-control-label">
							Confirm password:<font color="#c00000">*</font>
						</label>
						<div class="col-sm-9">																	
							 <input type="password" name="confirmpass" class="form-control" id="confirmpass" required>
                    		 <input type="password" name="hid_reg" class="form-control" value="hid_reg" style="display:none;">
						</div>
				  </div> 
                                    
				  <div class="form-group row">
							<label for="contact_message" class="col-sm-3 form-control-label">Spam code:<font color="#c00000">*</font></label>
							
							<div class="col-sm-9">																	
									<img src="{$PCMS_URL}/captcha.php?sid={$sid}" onclick="this.src='{$PCMS_URL}/captcha.php?'+Math.random()+'&sid={$sid}'" width="80px" height="35px" />
									<input type="text" maxlength="5" min-length="5" name="security_code" id="security_code" style="float:left;width:200px" class="form-control required" />
								<span class="vietiso_error" style="display:none;color:#ff0000">Captcha enter incorrect!</span>
							</div>
				  </div>  
				  <div class="form-group row">
						<label class="col-sm-3 form-control-label"></label>
						<div class="col-sm-9">																	
							 <div class="checkbox">
								<label>
									<input type="checkbox" name="tccheck" value="1" checked="checked">
									I have read and agree to the Terms & Conditions và Privacy policy của Vietnamtourism Information.
								</label>
							</div>
						</div>
				  </div>               
                  
                   
				  <div class="form-group row">
						<label class="col-sm-3 form-control-label"></label>
						<div class="col-sm-9">																	
							 <div class="alert alert-warning alert-warning-sign" style="display:none;">
								  <strong>Warning!</strong> <span class="load_error_sign"></span>
							  </div> 
						</div>
				  </div>  
				  <div class="form-group row">
						<label class="col-sm-3 form-control-label"></label>
						<div class="col-sm-9">																	
							<button type="submit" class="btn btn-danger btn-cmd-submit-register">Register</button>
                  			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
				  </div>  
                 
            </form>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>

  </div>
</div>