<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Administrators')}">{$core->get_Lang('Administrators')}</a>
    <a href="javascript:history.back();" class="back fr" style="width:50px;">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable gt 0}{$core->get_Lang('Edit Admin Details')}{else}{$core->get_Lang('Add New Admin Account')}{/if}</h2>
    </div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form" style="">
    	<fieldset>
            <dl>
                <dt><label for="{$name}">{$core->get_Lang('Administrator Role')}</label></dt>
                <dd>
                    <select name="user_group_id">
                        {section name=i loop=$listUserGroup}
                        <option value="{$listUserGroup[i].user_group_id}" {if $listUserGroup[i].user_group_id eq $oneItem.user_group_id}selected="selected"{/if}>
                            {$clsUserGroup->getName($listUserGroup[i].user_group_id)}
                        </option>
                        {/section}
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><label for="is_super">{$core->get_Lang('Is Super')}</label></dt>
                <dd>
                    <select name="is_super">
                        <option value="0" {if 0 eq $oneItem.is_super}selected="selected"{/if}>
                            NO
                        </option>
                        <option value="1" {if 1 eq $oneItem.is_super}selected="selected"{/if}>
                            YES
                        </option>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt><label for="first_name">{$core->get_Lang('First Name')}</label></dt>
                <dd>
                    <input type="text" value="{$oneItem.first_name}" id="first_name" name="first_name"  aria-required="true" class="medium text">
                </dd>
            </dl>
            <dl>
                <dt><label for="last_name">{$core->get_Lang('Last Name')}</label></dt>
                <dd>
                    <input type="text" value="{$oneItem.last_name}" id="last_name" name="last_name"  aria-required="true" class="medium text">
                </dd>
            </dl>
            <dl>
                <dt><label for="user_name">{$core->get_Lang('Username')}/{$core->get_Lang('Email')}</label></dt>
                <dd>
                    <input type="email" value="{$oneItem.user_name}" id="user_name" name="user_name"  aria-required="true" class="medium text"><span class="description">({$core->get_Lang('Accept only email address')})</span>
                    {if $err_user_name eq 'invalid'}
                    <br />
                    <span class="errorTxt">{$core->get_Lang('Invalid User Name')}</span>
                    {/if}
					{if $err_user_name eq 'exist'}
                    <br />
                    <span class="errorTxt">{$core->get_Lang('Exist User Name')}</span>
                    {/if}
                </dd>
            </dl>
            <dl>
                <dt><label for="password">{$core->get_Lang('Password')}</label></dt>
                <dd>
                    <input type="password" autocomplete="off" value="" size="16" id="pass1" name="pass1"  aria-required="true" class="medium text">({$core->get_Lang('Enter only if you want to change the password')})
                </dd>
            </dl>
            <dl>
                <dt><label for="pass2">{$core->get_Lang('Confirm Password')}</label></dt>
                <dd>
                    <input type="password" autocomplete="off" value="" size="16" id="pass2" name="pass2"  aria-required="true" class="medium text">
                    {if $err_password eq 'invalid'}	<br />					
                    <span class="errorTxt">{$core->get_Lang("Password doesn't match")}</span>
                    {/if}
                </dd>
            </dl>
            <dl>
                <dt><label for="disabled">{$core->get_Lang('Disable')}</label></dt>
                <dd>
                    <input value="1" {if $oneItem.is_active eq 0}checked="checked"{/if} type="checkbox" name="disabled" {if $_loged_id eq $oneItem.user_id}disabled="disabled"{/if}>({$core->get_Lang('Tick this box to deactivate this account and prevent login (you cannot disable your own account or the only admin)')})
                </dd>
            </dl>
        </fieldset>
        <p>{$core->get_Lang('Please confirm your admin password to add or make changes to administrator account details.')}</p>
        <fieldset>
            <dl>
                <dt><label for="pass3">{$core->get_Lang('Confirm Password')}</label></dt>
                <dd>
                    <input type="password" autocomplete="off" value="" size="16" id="pass3" name="pass3"  aria-required="true" class="medium text">
                    {if $err_password eq 'invalidadmin'}<br />					
                    <span class="errorTxt">{$core->get_Lang("Password doesn't match with your account!")}</span>
                    {/if}
                </dd>
            </dl>
        </fieldset>
        <br class="clearfix" />
        <fieldset class="submit-buttons">
            {$saveBtn} {$resetBtn}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
{literal}
<style>
.searchmap{ background:#E9EFF3; padding:10px;}
.errorTxt{color:#c00000; display:block;margin:5px 0 0}
</style>
<script type="text/javascript">
	$().ready(function(){
		$('.check_all').change(function(){
			var _this = $(this);
			if(_this.attr('checked') || _this.attr('checked')=='checked'){
				_this.closest('tr').find('input[type="checkbox"]')
								   .attr('checked',true)
								   .parent('label')
								   .addClass('lblchecked');
				_this.addClass('lblchecked');
			}else{
				_this.closest('tr').find('input[type="checkbox"]')
								   .removeAttr('checked')
								   .parent('label')
								   .removeClass('lblchecked');
				_this.removeClass('lblchecked');
			}	
		});
		$('#search_key').bind('keyup keydown change',function(){
			var _this=$(this);
			var rows = $('#tblHolderPermission tr').size();
			if(rows > 1 && _this.val() != ''){
				s=_this.val();
				$("#tblHolderPermission tr").each(function(){
					$(this).find('td:eq(1)').text().search(new RegExp(s,"i"))<0? $(this).hide():$(this).show();
				});
			}else{
				$('#tblHolderPermission tr').each(function(){
					$(this).show();
				});
			}
		});
		$('input[type="checkbox"]').each(function(){
			var _this = $(this);
			if(_this.attr('checked') || _this.attr('checked')=='checked'){
				_this.parent('label').addClass('lblchecked');			   
			}
		});
	});
</script>
{/literal}