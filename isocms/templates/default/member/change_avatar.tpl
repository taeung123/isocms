<div class="page_container">
	<div class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
			   <li><a href="{$PCMS_URL}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
			   <li itemprop="name">
						<a href="{$clsProfile->getLinkProfile($profile_id)}" title="{$core->get_Lang('Profile')}" rel="nofollow">{$core->get_Lang('Profile')}</a></li>
			   <li itemprop="name"><a href="{$curl}" title="{$core->get_Lang('Change avatar')}" itemprop="url">{$core->get_Lang('Change avatar')}</a></li>
			</ol>
		</div>
	</div>
	<div id="contentPage" class="pageMyProfile pd40_0">
		<div class="container">
			<div class="content-info"> {$core->getBlockModule('member/left_member')}
				<div class="clear"></div>
				<div class="col-md-9" style="padding-left:0; padding-right:0;box-shadow: -2px 0px 0px 0px #b3b3b3;">
					{if $msg ne ''}
						<div class="alert alert-warning">
						  <strong>Warning!</strong> {$msg}
						</div>
					{/if}
					{if $messages ne ''}
						<div class="alert alert-success">
						  <strong>Success!</strong> {$messages}
						</div>
					{/if}
					<form method="post" name="form" action="" enctype="multipart/form-data">
						<table class="tblavatar">
							<tr>
								<td style="vertical-align:top"><h3>Submit new avatar</h3>
									<p class="notice">Screen represent to have the format: jpg, gif, png. Size <2MB</p>
									<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-preview thumbnail"data-trigger="fileinput"style="width: 200px; height: 150px;">
									</div>
										<div> 
										<span class="btn btn-default btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
												<input type="file" name="avatar">
											</span>
										<a href="javascript:void(0);" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> </div>
									</div>
									<div class="acount-line" style="margin-top:10px;">
										<input type="hidden" name="Update" value="ChangeAvata" />
										<button type="submit" class="btn btn-danger cmd-update-profile">Update</button>
										<input type="hidden" value="ChangeAvata" name="Update" />
									</div>
								</td>
								<td width="220px"></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>