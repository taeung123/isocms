<div class="page_container">
	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsProfile->getLink('my_profile')}" title="{$core->get_Lang('My Profile')}" rel="nofollow">
							<span itemprop="name" class="reb">{$core->get_Lang('My Profile')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('Edit Information')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Edit Information')}</span></a>
					<meta itemprop="position" content="3" />
				</li>
			</ol>
		</div>
	</nav>
	<section id="contentPage" class="pageChangePass pd40_0">
		<div class="container">
			<div class="content-info"> 
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
						<div class="contentTab" style="display:block">
							<div class="sub-nav tabs clearfix light-border-h light-border-b phm">
								<ul class="tab-control">
									<li class="mrs"><a href="{$clsProfile->getLink('my_profile')}"><span>{$core->get_Lang('Summary')}</span></a></li>
									<li class="mrs current"><a href="{$clsProfile->getLink('contact_info')}"><span>{$core->get_Lang('Edit Contact Information')}</span></a></li>
									{assign var=_provider value = $clsProfile->getOauthProvider($profile_id)} 
									{if $_provider eq '_REGSITER'}
									<li class="mrs"><a href="{$clsProfile->getLink('change_pass')}"><span>{$core->get_Lang('Change Password')}</span></a></li>
									{/if}   
								</ul>
							</div>
							<form class="appForm" action="" method="post" enctype="multipart/form-data">
								<div class="line">
									<div class="unit">
										<h2 class="man size23">{$core->get_Lang('Contact Information')}</h2>
									</div>
								</div>
								<div class="cms-content mt10">
									<p>{$core->get_Lang('This information is never shared publicly. We will only use the information below to contact you about your account or about bookings made directly with')} {$PAGE_NAME}.</p>
									<div id="contactInfo" class="mt10">
										<p class="mbs"><span class="strong">{$core->get_Lang('Full name')}:</span> {$clsProfile->getFullname($profile_id)}</p>
										<p class="mvs mhn"><span class="strong">{$core->get_Lang('Email address')}:</span> {$oneProfile.email}</p>
									</div>
								</div>
								{if $msg_success}
								<div class="msg_success text-success">{$msg_success}</div>
								{/if}
								{if $msg_error}
								<div class="msg_error text-danger">{$msg_error}</div>
								{/if}
								<div class="row">
									<div class="form-group mt10">
										<label for="first_name" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('First name')}:</label>
										<div class="col-md-6 col-sm-8">							
											<input name="iso-first_name" required id="first_name" value="{$oneProfile.first_name}" class="form-control w220" placeholder="{$core->get_Lang('First name')}" type="text">							 
										</div>
									</div>
									<div class="form-group">
										<label for="last_name" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Last name')}:</label>
										<div class="col-md-6 col-sm-8">
											<input name="iso-last_name" id="last_name" value="{$oneProfile.last_name}" class="form-control w220" placeholder="{$core->get_Lang('Last name')}" type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="last_name" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Email')}:</label>
										<div class="col-md-6 col-sm-8">
											<input name="iso-email" id="email" value="{$oneProfile.email}" class="form-control w220" type="text" disabled="disabled">
										</div>
									</div>
									<div class="form-group">
										<label for="phone" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Phone Number')}:</label>
										<div class="col-md-6 col-sm-8">
											<input name="iso-phone" id="phone" required value="{$oneProfile.phone}" class="form-control fullwidth" placeholder="{$core->get_Lang('Phone')}" type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="organisation" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Organisation')}:</label>
										<div class="col-md-6 col-sm-8">
											<input name="organisation" required id="organisation" value="{$oneProfile.organisation}" class="form-control fullwidth" placeholder="{$core->get_Lang('Organisation')}" type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="address" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Address')}:</label>
										<div class="col-md-6 col-sm-8">
											<input name="iso-address" id="address" value="{$oneProfile.address}" class="form-control fullwidth" placeholder="{$core->get_Lang('Your Address')}" type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="last_name" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Country')}:</label>
										<div class="col-md-6 col-sm-8">
											<select name="iso-country_id" class="slb slbfull form-control">
												<option value="">-- {$core->get_Lang('Select country')} --</option>								
												{section name=i loop=$lstCountry}									
												<option {if $oneProfile.country_id eq $lstCountry[i].country_id}selected="selected"{/if} value="{$lstCountry[i].country_id}">{$clsCountry->getTitle($lstCountry[i].country_id)}</option>								
												{/section}								
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="state" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Postal code')}:</label>
										<div class="col-md-6 col-sm-8">
											<input name="iso-zipcode" id="state" required value="{$oneProfile.zipcode}" class="form-control fullwidth" placeholder="{$core->get_Lang('Postal code')}" type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="website" class="col-md-3 col-sm-4 form-control-label"></label>
										<div class="col-md-6 col-sm-8">
											<input type="hidden" value="Profile" name="Update"/>
											<button type="submit" class="btn btn-update fr">{$core->get_Lang('Update')}</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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

