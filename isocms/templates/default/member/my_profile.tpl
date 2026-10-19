<link rel="stylesheet" href="{$DOMAIN_NAME}/inc/isoman/css/skin.css?v={$upd_version}" type="text/css" media="all">
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
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('My Profile')}" >
					<span itemprop="name" class="reb">{$core->get_Lang('My Profile')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<section id="contentPage" class="pageMyProfile">
		<div class="container">
			<div class="content-info"> 
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
						<div class="box_agent_profile">
							<div class="box_email_agent">
								<h4 class="size18">Email</h4>
								<div class="info_email">
									<span class="email">
										{$clsProfile->getEmail($profile_id)}
									</span>
									{if $oneProfile.is_active eq '1'}
									<span class="confirm">
										{$core->get_Lang('Confirmed')}
									</span>
									{else}
									<span class="confirm">
										{$core->get_Lang('Unconfimred')}
									</span>
									{/if}
								</div>
							</div>
							<form class="appForm" action="" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="photobox"> 
										<img src="{$clsProfile->getImageAvatar($profile_id,125,125)}" onerror="this.src='{$URL_IMAGES}/member.jpg'" alt="Image" id="isoman_show_image">
										<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{if $clsProfile->getImageAvatar($profile_id,125,125) ne ''}{$clsProfile->getImageAvatar($profile_id,125,125)}{else}{$URL_IMAGES}/member.jpg{/if}">
										<a href="javascript:void(0);" title="change" class="photobox_edit ajOpenDialog" profile_id="{$profile_id}" isoman_for_id="image" isoman_val="{if $clsProfile->getAvatar($profile_id,125,125) ne ''}{$clsProfile->getImageAvatar($profile_id,125,125)}{else}{$URL_IMAGES}/member.jpg{/if}" isoman_name="image">{$core->get_Lang('Change my photo')}</a> 
										<a pvaltable="231" clstable="Profile" href="javascript:void()" title="Delete" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none; display:none">X</a>
									</div>
									</div>
									<div class="col-md-9">
										{if $msg_success}
										<div class="msg_success text-success">{$msg_success}</div>
										{/if}
										{if $msg_error}
										<div class="msg_error text-danger">{$msg_error}</div>
										{/if}
										<div class="row">
											<div class="form-group mt10">
												<label for="full_name" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Full name')}<span class="color_r">*</span>:</label>
												<div class="col-md-9 col-sm-8">							
													<input name="iso-full_name" required id="full_name" value="{$oneProfile.full_name}" class="form-control w220" placeholder="{$core->get_Lang('Full name')}" type="text">							 
												</div>
											</div>
											<div class="form-group">
												<label for="last_name" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Email')}<span class="color_r">*</span>:</label>
												<div class="col-md-9 col-sm-8">
													<input name="iso-email" id="email" value="{$oneProfile.email}" class="form-control w220" type="text" disabled="disabled">
												</div>
											</div>
											<div class="form-group">
												<label for="phone" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Phone Number')}<span class="color_r">*</span>:</label>
												<div class="col-md-9 col-sm-8">
													<input name="iso-phone" id="phone" required value="{$oneProfile.phone}" class="form-control fullwidth" placeholder="{$core->get_Lang('Phone')}" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="organisation" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Organisation')}<span class="color_r">*</span>:</label>
												<div class="col-md-9 col-sm-8">
													<input name="organisation" required id="organisation" value="{$oneProfile.organisation}" class="form-control fullwidth" placeholder="{$core->get_Lang('Organisation')}" type="text">
												</div>
											</div>
											<div class="form-group">
												<label for="address" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Address')}<span class="color_r">*</span>:</label>
												<div class="col-md-9 col-sm-8">
													<input name="iso-address" id="address" value="{$oneProfile.address}" class="form-control fullwidth" placeholder="{$core->get_Lang('Your Address')}" type="text">
												</div>
											</div> 
											<div class="form-group">
												<label for="last_name" class="col-md-3 col-sm-4 form-control-label">{$core->get_Lang('Country')}:</label>
												<div class="col-md-9 col-sm-8">
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
												<div class="col-md-9 col-sm-8">
													<input name="iso-zipcode" id="state" value="{$oneProfile.zipcode}" class="form-control fullwidth" placeholder="{$core->get_Lang('Postal code')}" type="text">
												</div>
											</div> 
											<div class="form-group">
												<label for="website" class="col-md-3 col-sm-4 form-control-label"></label>
												<div class="col-md-9 col-sm-8">
													<input type="hidden" value="Profile" name="Update"/>
													<button type="submit" class="btn btn-update btn_main fr">{$core->get_Lang('Update')}</button>
												</div>
											</div>
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
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			$('.fileinput-exists').click(function(){
				$('.btn-update').show();
			});
			$('.it-head-iti').click(function(){
				$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
				$(this).next().slideToggle();
			});
			$(document).on('click', '.ajOpenDialog', function(ev){
				var $_this = $(this);
				var profile_id = $_this.attr('profile_id');
				$.post(path_ajax_script+'/index.php?mod=member&act=ajOpenChangeAvatar',{'tp':'F','profile_id':profile_id}, function(html){
					makepopup('600px','auto', html, 'OpenDialog_'+profile_id);
				});
				return false;
			});
			$(document).on('click', 'button[name=submit]', function(ev){
				var $_this = $(this);
				$_this.closest('form').ajaxSubmit({
					type : 'POST',
					url: path_ajax_script+'/index.php?mod=member&act=ajOpenChangeAvatar',
					data : {'tp':'S'},
					dataType:'html',
					success: function(html){
						var htm = html.split('|||');
						$('input[name^=isoman_url_image]').val(htm[1]);
						$('img[id^=isoman_show_image]').attr('src',htm[1]);
						$('.close_pop').trigger('click');
					}
				});
				return false;
			});
		});
	})
</script>
{/literal}