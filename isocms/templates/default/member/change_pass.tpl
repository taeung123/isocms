{$core->getBlock('forgotPass_box')}
<div class="page_container">
	<div class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li><a href="{$PCMS_URL}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
				<li itemprop="name">
				<a href="{$clsProfile->getLink('my_profile')}" title="{$core->get_Lang('My Profile')}" rel="nofollow">{$core->get_Lang('My Profile')}</a>
				</li>
				<li itemprop="name"><a href="{$curl}" title="{$core->get_Lang('Change password')}" itemprop="url">{$core->get_Lang('Change password')}</a>
				</li>
			</ol>
		</div>
	</div>
	<div id="contentPage" class="pageChangePass pd40_0">
		<div class="container">
			<div class="content-info">
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
						<div class="contentTab" style="display:block">
							<form class="appForm" action="" method="post" enctype="multipart/form-data">
								<h2 class="mtn mhn mbs mb10">{$core->get_Lang('Change Password')}</h2>
								<div class="cms-content">
									<p>{$core->get_Lang('Passwords must be at least 6 characters long')}. {$core->get_Lang('Forgot your old password')}? <a href="{$clsProfile->getLink('forgot_pass')}" title="{$core->get_Lang('Click here')}">{$core->get_Lang('Click here')}</a> {$core->get_Lang('and we will resend it to your confirmed email address')}.</p>
								</div>
								{if $msg ne ''}
								<div class="alert alert-warning">
								  <strong>{$core->get_Lang('Warning')}!</strong>{$msg}
								</div>
								{/if}
								<div class="form-group mt10">
									<label for="old_pass" class="col-md-3 col-sm-4 form-control-label"> {$core->get_Lang('Current Password')} <font class="required color_f00">*</font>: </label>
									<div class="col-md-6 col-sm-8">
										<input class="form-control" required type="password" name="old_pass" autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label for="pass2" class="col-md-3 col-sm-4 form-control-label"> {$core->get_Lang('Password')} <font class="required color_f00">*</font>: </label>
									<div class="col-md-6 col-sm-8">
										<input class="form-control" id="pass2" required type="password" name="pass2" autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label for="pass3" class="col-md-3 col-sm-4  form-control-label"> {$core->get_Lang('Retype Password')} <font class="required color_f00">*</font>: </label>
									<div class="col-md-6 col-sm-8">
										<input class="form-control" id="pass3" required type="password" name="pass3" autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label for="website" class="col-md-3 col-sm-4 form-control-label"></label>
									<div class="col-md-6 col-sm-8">
										<input type="hidden" name="Update" value="ChangePass" />
										<button type="submit" class="btn btn-update btn_main">{$core->get_Lang('Update')}</button>
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
<script type="text/javascript">
var $user_email='{$clsProfile->getEmail($profile_id)}';
</script>
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
		$(document).on('click','#forgotPassword',function(e){
			if($('#member_forget_box').is(':visible')){
				$('#member_forget_box').hide();
			} else {
				var $html = $('#forget_box').html();
				makepopup(520,'auto',$html,'member_forgot_box');
				$('#member_signin_box').closest('.frmPop_box').find('.close_pop').click();
				$('#member_signup_box').closest('.frmPop_box').find('.close_pop').click();
				return false;
			}
		});
	})
</script>
{/literal}
