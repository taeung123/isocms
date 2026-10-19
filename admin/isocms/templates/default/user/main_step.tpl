<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						<h3 class="title_box">{$core->get_Lang('Edit Admin Details')}</h3>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Administrator Role')}
							{assign var= administratorRole_user value='administratorRole_user'}
							{assign var= help_first value=$administratorRole_user}
							{if $CHECKHELP eq 1}
							<button data-key="{$administratorRole_user}" data-label="{$core->get_Lang('Administrator Role')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<div class="fieldarea">
								<select class="glSlBox border_aaa" name="user_group_id" style="width:250px" onClick="loadHelp(this)">
									{section name=i loop=$listUserGroup}
										<option value="{$listUserGroup[i].user_group_id}" {if $listUserGroup[i].user_group_id eq $oneItem.user_group_id}selected="selected"{/if}>
											{$clsUserGroup->getName($listUserGroup[i].user_group_id)}
										</option>
									{/section}
								</select>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($administratorRole_user)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Is Super')}
							{assign var= isSuper_user value='isSuper_user'}
							{if $CHECKHELP eq 1}
							<button data-key="{$isSuper_user}" data-label="{$core->get_Lang('Is Super')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<div class="fieldarea">
								<select class="glSlBox border_aaa" name="is_super" style="width:250px" onClick="loadHelp(this)">
									<option value="0" {if 0 eq $oneItem.is_super}selected="selected"{/if}>NO</option>
									<option value="1" {if 1 eq $oneItem.is_super}selected="selected"{/if}>YES</option>
								</select>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($isSuper_user)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('First Name')}
								{assign var= firstName_user value='firstName_user'}
								{if $CHECKHELP eq 1}
								<button data-key="{$firstName_user}" data-label="{$core->get_Lang('First Name')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label>
							<input class="text_32 full-width border_aaa bold title_capitalize" name="first_name" value="{$oneItem.first_name}" maxlength="255" type="text" onClick="loadHelp(this)" >
							<div class="text_help" hidden="">{$clsConfiguration->getValue($firstName_user)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<div onClick="loadHelp(this)">
								<label for="title">{$core->get_Lang('Last Name')}
									{assign var= lastName_user value='lastName_user'}
									{if $CHECKHELP eq 1}
									<button data-key="{$lastName_user}" data-label="{$core->get_Lang('Last Name')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="text_32 full-width border_aaa bold title_capitalize" name="last_name" value="{$oneItem.last_name}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($lastName_user)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<div onClick="loadHelp(this)">
								<label for="title">{$core->get_Lang('Username')}/{$core->get_Lang('Email')} <span class="required_red">*</span>
									{assign var= usernameEmail_user value='usernameEmail_user'}
									{if $CHECKHELP eq 1}
									<button data-key="{$usernameEmail_user}" data-label="{$core->get_Lang('Username')}/{$core->get_Lang('Email')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="d-flex" onClick="loadHelp(this)" >
									<input class="text_32 full-width border_aaa bold required" name="user_name" value="{$oneItem.user_name}" maxlength="255" type="text" ><span class="description" style="margin-left: 15px">({$core->get_Lang('Accept only email address')})</span>
								</div>
                    			<span class="errorTxt errorEmail"></span>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($usernameEmail_user)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<div onClick="loadHelp(this)">
								<label for="title">{$core->get_Lang('Password')}
									{assign var= password_user value='password_user'}
									{if $CHECKHELP eq 1}
									<button data-key="{$password_user}" data-label="{$core->get_Lang('Password')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="d-flex" onClick="loadHelp(this)" >
									<input class="text_32 full-width border_aaa bold" name="pass1" value="" maxlength="255" type="password" ><span class="description" style="margin-left: 15px">({$core->get_Lang('Enter only if you want to change the password')})</span>
								</div>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($password_user)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<div onClick="loadHelp(this)">
								<label for="title">{$core->get_Lang('Confirm Password')}
									{assign var=confirmPassword_user value='confirmPassword_user'}
									{if $CHECKHELP eq 1}
									<button data-key="{$confirmPassword_user}" data-label="{$core->get_Lang('Confirm Password')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="d-flex" onClick="loadHelp(this)" >
									<input class="text_32 full-width border_aaa bold" name="pass2" value="" maxlength="255" type="password" ><span class="description" style="margin-left: 15px">({$core->get_Lang('Enter only if you want to change the password')})</span>
								</div>								
								<br /><span class="errorTxt errorPass"></span>
								
								<div class="text_help" hidden="">{$clsConfiguration->getValue($confirmPassword_user)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<div onClick="loadHelp(this)">
								<label for="title">{$core->get_Lang('Disable')}
									{assign var=disable_user value='disable_user'}
									{if $CHECKHELP eq 1}
									<button data-key="{$disable_user}" data-label="{$core->get_Lang('Disable')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input value="0" {if $oneItem.is_active eq 0}checked="checked"{/if} type="checkbox" name="disabled" {if $_loged_id eq $oneItem.user_id}disabled="disabled"{/if}>({$core->get_Lang('Tick this box to deactivate this account and prevent login (you cannot disable your own account or the only admin)')})
								<div class="text_help" hidden="">{$clsConfiguration->getValue($disable_user)|html_entity_decode}</div>
							</div>
						</div>
						<p class="title_box">{$core->get_Lang('Please confirm your admin password to add or make changes to administrator account details.')}</p>
						<div class="inpt_tour">
							<div onClick="loadHelp(this)">
								<label for="title">{$core->get_Lang('Confirm Password')} {if $is_type != 'OKRS'}<span class="required_red">*</span>{/if}
									{assign var= confirmPasswordOld_user value='confirmPasswordOld_user'}
									{if $CHECKHELP eq 1}
									<button data-key="{$confirmPasswordOld_user}" data-label="{$core->get_Lang('Confirm Password')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="d-flex" onClick="loadHelp(this)" >
									<input class="text_32 full-width border_aaa bold" name="pass3" value="" maxlength="255" type="password" >
								</div>				
								<span class="errorTxt errorPassAccount"></span>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($confirmPasswordOld_user)|html_entity_decode}</div>
							</div>
						</div>
						<div class="btn_save_titile_table_code mt30">
							<a href="{$PCMS}/admin/?mod={$mod}" class="back_step">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save')}</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 col_instruction">
				<div class="instruction_fill_data_box">
					<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
					<div class="content_box">{$clsConfiguration->getValue($help_first)|html_entity_decode}</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	var blog_id = $blog_id = '{$oneItem.blog_id}';
	var error_user_name  = "{$core->get_Lang('Invalid User Name')}";
	var errorEmailExist  = `{$core->get_Lang('Exist User Name')}`;
	var errorPasswordNotMatch  = `{$core->get_Lang("Password doesn't match")}`;
	var error_pass3  = `{$core->get_Lang("Password doesn't match with your account!")}`;
	var error_pass3Valid  = `{$core->get_Lang("Password is required!")}`;
	var is_type  = `{$is_type}`;
	console.log(is_type)
</script>
{literal}
<style>
.errorTxt{color:#c00000; display:block;margin:5px 0 0}
</style>
<script>
if($('.textarea_intro_editor').length > 0){
	$('.textarea_intro_editor').each(function(){
		var $_this = $(this);
		var $editorID = $_this.attr('id');
		$('#'+$editorID).isoTextArea();
	});
}
	$('.toggle-row').click(function(){
		$(this).closest('tr').toggleClass('open_tr');
	});
</script>
{/literal}