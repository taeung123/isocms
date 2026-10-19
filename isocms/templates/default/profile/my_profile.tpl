<div class="container" style="margin-top:100px;">				
	<div class="content-info"> 
		<div class="col-md-3 col-sx-12 col-sm-12">
			<ul class="list-group">
			  <li class="list-group-item"><a href="{$PCMS_URL}">Trang chủ</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/my-profile.html">Thông tin của bạn</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/list_tour.html">Tour</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_order.html">Your order</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_invoice.html">Your Invoices</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_ticket.html">Your ticket</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/report.html">Report</a></li>
			  <li class="list-group-item"><a href="">Action log</a></li>
			</ul>
		</div>
		<div class="col-md-9 col-sx-12 col-sm-12" style="padding-left:0;box-shadow: -2px 0px 0px 0px #b3b3b3;">		
				{if !empty($message)}
					 <div class="alert alert-success">
					 <strong>Success!</strong>									
						  {$message}											
					</div>
				{/if}			
				   <form class="appForm" action="" method="post" enctype="multipart/form-data">
				   <h1>Profile of member</h1>				   				   
				   <div class="row">
                        	<div class="col-md-6">

                            </div>
                            <!--<a class="image" href="#"><img style="max-width:155px;" src="{$clsProfile->getAvatar($profile_id,66,66)}" width="66" height="66" alt="{$oneProfile.username}"></a><input type="file" name="avatar">-->
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new" data-provides="fileinput" style="display:inline-block; text-align:center">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 66px; height:66px;">
                                    <img style="max-width:66px;" src="{$clsProfile->getAvatar($profile_id,66,66)}" width="66" height="66" alt="{$oneProfile.username}">
                                </div>
                                    <div> 
                                    <span class="btn btn-default btn-file" style="display:none">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                            <input type="file" name="avatar">
                                        </span>
                                    <a href="javascript:void(0);" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> </div>
                                </div>
                            </div>
                        </div>
				   
				   
				<div class="form-group row" style="margin-top:20px;">
					<label for="contact_email" class="col-sm-3 form-control-label">Email:</label>
					<div class="col-sm-9"> {$oneProfile.email} </div>
				</div>
			
				
				<div class="form-group row">
					<label for="first_name" class="col-sm-3 form-control-label">Password:</label>
					<div class="col-sm-9">
						
						<a href="{$PCMS_URL}profile/change-password.html" style="text-decoration:underline">Change password</a>
						
					</div>
				</div>
				<h3 class="profileInfo">Infomation</h3>
					<div class="form-group">
						<label for="first_name" class="col-md-3 form-control-label">{$core->get_Lang('user_name')}:</label>
						<div class="col-md-9">
						    <input name="profile_id" required id="profile_id" value="{$oneProfile.profile_id}" class="form-control w220" placeholder="" type="hidden">							
							<input name="first_name" required id="first_name" value="{$oneProfile.username}" class="form-control w220" placeholder="User name" type="text">							
						</div>
					</div>
					<div class="form-group">
						<label for="first_name" class="col-md-3 form-control-label">{$core->get_Lang('fullname')}:</label>
						<div class="col-md-9">

							<input name="full_name" required id="full_name" value="{$oneProfile.full_name}" class="form-control w220" placeholder="Full name" type="text">							
						</div>
					</div>
					<div class="form-group">
						<label for="last_name" class="col-md-3 form-control-label">{$core->get_Lang('company')}:</label>
						<div class="col-md-9">
							<input name="company" id="company" value="{$oneProfile.company}" class="form-control w220" placeholder="Company name" type="text">
						</div>
					</div> 
					<div class="form-group">
						<label for="last_name" class="col-md-3 form-control-label">Website:</label>
						<div class="col-md-9">
							<input name="website" id="website" value="{$oneProfile.website}" class="form-control w220" placeholder="Website" type="text">
						</div>
					</div>      
					<div class="form-group">
						<label for="address" class="col-md-3 form-control-label">Address:</label>
						<div class="col-md-9">
							<input name="address" id="address" value="{$oneProfile.address}" class="form-control fullwidth" placeholder="Your Address" type="text">
						</div>
					</div> 
					  <div class="form-group">
						<label for="phone" class="col-md-3 form-control-label">Your job:</label>
						<div class="col-md-9">
							<input name="job" id="job" required value="{$oneProfile.job}" class="form-control fullwidth" placeholder="Job" type="text">
						</div>
					</div>           
                    <div class="form-group">
						<label for="phone" class="col-md-3 form-control-label">Phone Number:</label>
						<div class="col-md-9">
							<input name="phone" id="phone" required value="{$oneProfile.phone}" class="form-control fullwidth" placeholder="Phone" type="text">
						</div>
					</div>
					 <div class="form-group">
						<label for="phone" class="col-md-3 form-control-label">Fax:</label>
						<div class="col-md-9">
							<input name="fax" id="fax" required value="{$oneProfile.fax}" class="form-control fullwidth" placeholder="fax" type="text">
						</div>
					</div>
                    <div class="form-group">
						<label for="organisation" class="col-md-3 form-control-label">Organisation:</label>
						<div class="col-md-9">
							<input name="organisation" required id="organisation" value="{$oneProfile.last_name}" class="form-control fullwidth" placeholder="Organisation" type="text">
						</div>
					</div>
                    
                    <div class="form-group">
						<label for="last_name" class="col-md-3 form-control-label">Country:</label>
						<div class="col-md-9">
							<select name="country_id" class="slb slbfull form-control" disabled="disabled">
								<option value="">-- Select country --</option>								
									{section name=i loop=$lstCountry}									
								<option {if $oneProfile.country_id eq $lstCountry[i].country_id}selected="selected"{/if} value="{$lstCountry[i].country_id}">{$clsCountry->getTitle($lstCountry[i].country_id)}</option>								
									{/section}								
							</select>
						</div>
					</div>
					 <div class="form-group">
						<label for="last_name" class="col-md-3 form-control-label">City:</label>
						<div class="col-md-9">
							<select name="city_id" class="slb slbfull form-control">
								<option value="">-- Select city --</option>								
									{section name=i loop=$lstCity}									
								<option {if $oneProfile.city_id eq $lstCity[i].city_id}selected="selected"{/if} value="{$lstCity[i].city_id}">{$clsCity->getTitle($lstCity[i].city_id)}</option>								
									{/section}								
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label for="state" class="col-md-3 form-control-label">Postal state:</label>
						<div class="col-md-9">
							<input name="state" id="state" required value="{$oneProfile.state}" class="form-control fullwidth" placeholder="State" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="state" class="col-md-3 form-control-label">Postal code:</label>
						<div class="col-md-9">
							<input name="zipcode" id="zipcode" required value="{$oneProfile.zipcode}" class="form-control fullwidth" placeholder="Postal code" type="text">
						</div>
					</div>  
					<div class="form-group">
						<label for="state" class="col-md-3 form-control-label">Intro:</label>
						<div class="col-md-9">
							<textarea name="intro" id="intro" required class="form-control fullwidth" placeholder="Intro">{$oneProfile.intro}</textarea>
						</div>
					</div>                   
					<div class="form-group">
						<label for="website" class="col-md-3 form-control-label"></label>
						<div class="col-md-9">
                        	 <input type="hidden" value="Profile" name="Update" />
							 <button type="submit" class="btn btn-danger fr">Update</button>
						</div>
					</div>						
				</form>
			 
		</div>
		<div class="col-md-2 col-sx-12 col-sm-12"></div>
	</div>	
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){	$('.appForm').validate();	}); 
	})
</script>
{/literal}