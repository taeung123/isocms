<div class="page_container">
	<div class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
			   <li><a href="{$PCMS_URL}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
			   <li itemprop="name"><a href="{$curl}" title="{$core->get_Lang('My Profile')}" itemprop="url">{$core->get_Lang('My Profile')}</a></li>
			</ol>
		</div>
	</div>
	<div id="contentPage" class="pageMyProfile pd40_0">
		<div class="container">
			<div class="content-info"> 
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
						<div class="tabs_content pl0" id="lstTabs" style="border:0 !important">
							<div class="contentTab" style="display:block">
								<div class="sub-nav tabs clearfix light-border-h light-border-b phm">
									<ul class="tab-control">
										<li class="mrs"><a href="{$clsProfile->getLink('my_profile')}"><span>{$core->get_Lang('Summary')}</span></a></li>
										<li class="mrs current"><a href="{$clsProfile->getLink('contact_info')}"><span>{$core->get_Lang('Edit Contact Information')}</span></a></li>
										<li class="mrs"><a href="{$clsProfile->getLink('change_pass')}"><span>{$core->get_Lang('Change Password')}</span></a></li>
									</ul>
								</div>
								<form class="appForm" action="" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-8 mb30">
											<div class="line">
											  <div class="unit size3of5">
												<h2 class="man">{$core->get_Lang('Contact Information')}</h2>
											  </div>
											  <div class="unit size2of5" style="display:none">
												<p class="man txtR"><a href="" class="xsmall inverse-link">{$core->get_Lang('Edit my contact details')}</a></p>
											  </div>
											</div>
											<div class="cms-content mt10">
											  <p>{$core->get_Lang('This information is never shared publicly. We will only use the information below to contact you about your account or about bookings made directly with')} {$PAGE_NAME}.</p>
											  <div id="contactInfo" class="mt10">
												<p class="mbs"><span class="strong">{$core->get_Lang('Full name')}:</span> {$clsProfile->getFullname($profile_id)}</p>
												<p class="mvs mhn"><span class="strong">{$core->get_Lang('Email address')}:</span> {$oneProfile.email}</p>
											  </div>
											</div>
											<h3 class="profileInfo mt10">{$core->get_Lang('Infomation')}</h3>
											<div class="form-group mt10">
												<label for="first_name" class="col-md-3 form-control-label">{$core->get_Lang('First name')}:</label>
												<div class="col-md-9">							
													<input name="iso-first_name" required id="first_name" value="{$oneProfile.first_name}" class="form-control w220" placeholder="{$core->get_Lang('Fist name')}" type="text">							 
												</div>
											</div>
											<div class="form-group">
												<label for="last_name" class="col-md-3 form-control-label">{$core->get_Lang('Last name')}:</label>
												<div class="col-md-9">
													<input name="iso-last_name" id="last_name" value="{$oneProfile.last_name}" class="form-control w220" placeholder="{$core->get_Lang('Last name')}" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="last_name" class="col-md-3 form-control-label">{$core->get_Lang('Email')}:</label>
												<div class="col-md-9">
													<input name="iso-email" id="email" value="{$oneProfile.email}" class="form-control w220" type="text" disabled="disabled">
												</div>
											</div>
											<div class="form-group">
												<label for="phone" class="col-md-3 form-control-label">{$core->get_Lang('Phone Number')}:</label>
												<div class="col-md-9">
													<input name="iso-phone" id="phone" required value="{$oneProfile.phone}" class="form-control fullwidth" placeholder="{$core->get_Lang('Phone')}" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="organisation" class="col-md-3 form-control-label">{$core->get_Lang('Organisation')}:</label>
												<div class="col-md-9">
													<input name="organisation" required id="organisation" value="{$oneProfile.organisation}" class="form-control fullwidth" placeholder="{$core->get_Lang('Organisation')}" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="address" class="col-md-3 form-control-label">{$core->get_Lang('Address')}:</label>
												<div class="col-md-9">
													<input name="iso-address" id="address" value="{$oneProfile.address}" class="form-control fullwidth" placeholder="{$core->get_Lang('Your Address')}" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="last_name" class="col-md-3 form-control-label">{$core->get_Lang('Country')}:</label>
												<div class="col-md-9">
													<select name="iso-country_id" class="slb slbfull form-control">
														<option value="0">-- {$core->get_Lang('Select country')} --</option>
															{section name=i loop=$lstCountry}									
														<option {if $oneProfile.country_id eq $lstCountry[i].country_id}selected="selected"{/if} value="{$lstCountry[i].country_id}">{$clsCountry->getTitle($lstCountry[i].country_id)}</option>								
															{/section}								
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="state" class="col-md-3 form-control-label">{$core->get_Lang('Postal code')}:</label>
												<div class="col-md-9">
													<input name="iso-zipcode" id="state" required value="{$oneProfile.zipcode}" class="form-control fullwidth" placeholder="{$core->get_Lang('Postal code')}" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="website" class="col-md-3 form-control-label"></label>
												<div class="col-md-9">
													 <input type="hidden" value="Profile" name="Update"/>
													 <button type="submit" class="btn btn-update fr">{$core->get_Lang('Update')}</button>
												</div>
											</div>
										</div>
										<div class="col-md-4 unitRight">
											{$core->getBlock(l_rightMember)}
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){	
			$('.fileinput-exists').click(function(){
				$('.btn-update').show();
			});
			$('.it-head-iti').click(function(){
				$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
				$(this).next().slideToggle();
			});
		}); 
	})	
</script>
{/literal}

