<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}?mod=email_template">{$core->get_Lang('emailtemplate')}</a>
	<!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <form method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="page-title">	
            <h2>{$core->get_Lang('emailtemplate')}
            	{*<select name="iso-cat_id" class="required">
                	<option value="">{$core->get_Lang('Category')}</option>
                    {section name=i loop=$lstEmailTemplateCat}
                    <option {if $oneItem.cat_id eq $lstEmailTemplateCat[i].email_template_cat_id}selected="selected"{/if} value="{$lstEmailTemplateCat[i].email_template_cat_id}">{$clsEmailTemplateCat->getTitle($lstEmailTemplateCat[i].email_template_cat_id)}</option>
                    {/section}
                </select>*}
            </h2>
            {assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
            {if $clsConfiguration->getValue($setting) ne ''}<p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p> {/if}
        </div>
        <div class="clearfix"><br /></div>
    	<div class="wrap">
            <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
            	 <tr>
                    <td class="fieldlabel span20 block767 full_width_767 text_left_767">{$core->get_Lang('templatename')} <font color="red">*</font></td>
                    <td class="fieldarea  block767 full_width_767">
                        <input class="text full required" name="iso-title" style="padding:5px" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                    </td>
                </tr>
                <tr>
                    <td class="fieldlabel span20 block767 full_width_767 text_left_767">{$core->get_Lang('Group')} <font color="red">*</font></td>
                    <td class="fieldarea  block767 full_width_767">
                        <select name="iso-cat_id" class="required">
                            <option value="0">{$core->get_Lang('Category')}</option>
                            {section name=i loop=$lstEmailTemplateCat}
                            <option {if $oneItem.cat_id eq $lstEmailTemplateCat[i].email_template_cat_id}selected="selected"{/if} value="{$lstEmailTemplateCat[i].email_template_cat_id}">{$clsEmailTemplateCat->getTitle($lstEmailTemplateCat[i].email_template_cat_id)}</option>
                            {/section}
                        </select>
                    </td>
                </tr>
            	<tr>
                    <td class="fieldlabel span20  block767 full_width_767 text_left_767">{$core->get_Lang('From')} <font color="red">*</font></td>
                    <td class="fieldarea  block767 full_width_767">
                        <input type="text" class="text full" name="iso-fromname" size="25" value="{$clsClassTable->getFromName($pvalTable)}" placeholder="Join Carter,..." data-enter-submit="true" style="width:40%" />
                        <input type="text" class="text full" name="iso-fromemail" size="40" value="{$clsClassTable->getFromEmail($pvalTable)}" data-enter-submit="true" placeholder="example@email.com" style="width:40%"> 
                    </td>
                </tr>
                <tr>
                    <td class="fieldlabel span20  block767 full_width_767 text_left_767"> {$core->get_Lang('Copy To')} </td>
                    <td class="fieldarea  block767 full_width_767">
                        <input type="text" name="iso-copyto" size="50" style="padding:5px" value="{$clsClassTable->getCopyTo($pvalTable)}" data-enter-submit="true" placeholder="example@email.com,..." />
                        {$core->get_Lang('Enter email addresses separated by a comma')}
                    </td>
                </tr>
                <tr>
                    <td class="fieldlabel span20  block767 full_width_767 text_left_767">{$core->get_Lang('subject')} <font color="red">*</font></td>
                    <td class="fieldarea  block767 full_width_767">
                        <input class="text full required" name="iso-subject" style="padding:5px" value="{$clsClassTable->getSubject($pvalTable)}" maxlength="255" type="text"  placeholder="Subject E-Mail" />
                    </td>
                </tr>
                <tr>
                    <td class="fieldlabel span20  block767 full_width_767 text_left_767">{$core->get_Lang('HeaderEmail')} <font color="red">*</font></td>
                    <td class="fieldarea  block767 full_width_767">
						<textarea id="textarea_intro_editor_header{$now}" class="textarea_intro_email_editor_simple" name="iso-header" style="width:100%">{$clsClassTable->getHeader($pvalTable)}</textarea>
                        
                    </td>
                </tr>
                <tr>
                    <td class="fieldlabel span20  block767 full_width_767 text_left_767">{$core->get_Lang('BodyEmail')} <font color="red">*</font></td>
                    <td class="fieldarea  block767 full_width_767">
						<textarea id="textarea_intro_editor{$now}" class="textarea_intro_email_editor" name="iso-content" style="width:100%">{$clsClassTable->getContent($pvalTable)}</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="fieldlabel span20  block767 full_width_767 text_left_767">{$core->get_Lang('FooterEmail')} <font color="red">*</font></td>
                    <td class="fieldarea  block767 full_width_767">
						<textarea id="textarea_intro_editor_footer{$now}" class="textarea_intro_email_editor_simple" name="iso-footer" style="width:100%">{$clsClassTable->getFooter($pvalTable)}</textarea>
                    </td>
                </tr>
                {literal}
                <script type="text/javascript">
                    $(function(){
                        if($('.textarea_intro_email_editor').length > 0){
                            $('.textarea_intro_email_editor').each(function(){
                                var $_this = $(this);
                                var $editorID = $_this.attr('id');
                                $('#'+$editorID).isoTextAreaEmail();
                            });
                        }
                        if($('.textarea_intro_email_editor_simple').length > 0){
                            $('.textarea_intro_email_editor_simple').each(function(){
                                var $_this = $(this);
                                var $editorID = $_this.attr('id');
                                $('#'+$editorID).isoTextAreaSimpleEmail();
                            });
                        }
                        var $ok = true;
                        var $editorID = 'textarea_content';
                        $("a.toggle").click(function(){
                            if($ok){
                                 tinyMCE.execCommand('mceRemoveControl', false, $editorID);
                                 $ok = false;
                            }else{
                                tinyMCE.execCommand('mceAddControl', false, $editorID);
                                $ok = true;
                            }
                            return false;
                        });
                        $(window).load(function(){
                            $('#textarea_content_ifr').height(240);
                        });
                        $('.command').click(function(){
                            var $_this = $(this);
                            tinymce.activeEditor.execCommand('mceInsertContent', false, $_this.attr('data'));
                            return false;
                        });
                    });
                </script>
                {/literal}
            </table>
        </div>
        <fieldset class="submit-buttons">
            {$saveBtn} {$resetBtn}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
    
    <div class="wrap mt30">
        <div class="page-title">	
            <h2>{$core->get_Lang('Available Merge Fields')}</h2>
        </div>
        <div class="row">
			<div class="col-sm-6 col-md-4">
				<div class="row-field full_width">
					<div class="row-heading">{$core->get_Lang('company')}</div>
					<div class="content coltrols" style="padding:0px">
						<ul class="wicket">
							<li>
								<a class="command" href="javascript:void();" data="[%PAGE_NAME%]">{$core->get_Lang('Page Name')}</a>
								<span>[%PAGE_NAME%]</span>
							</li>
                            <li>
								<a class="command" href="javascript:void();" data="[%PAGE_NAME%]">{$core->get_Lang('Companyname')}</a>
								<span>[%COMPANY_NAME%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%COMPANY_ADDRESS%]">{$core->get_Lang('address')}</a>
								<span>[%COMPANY_ADDRESS%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%COMPANY_PHONE%]">{$core->get_Lang('phone')}</a>
								<span>[%COMPANY_PHONE%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%COMPANY_EMAIL%]">Email</a>
								<span>[%COMPANY_EMAIL%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%COMPANY_FAX%]">Fax</a>
								<span>[%COMPANY_FAX%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%COMPANY_WEBSITE%]">{$core->get_Lang('webiste')}</a>
								<span>[%COMPANY_WEBSITE%]</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
            <div class="col-sm-6 col-lg-4 col-md-4">
				<div class="row-field full_width">
					<div class="row-heading">{$core->get_Lang('customer')}</div>
					<div class="content coltrols" style="padding:0px">
						<ul class="wicket">
							<li>
								<a class="command" href="javascript:void();" data="[%CUSTOMER_FULLNAME%]">{$core->get_Lang('fullname')}</a>
								<span>[%CUSTOMER_FULLNAME%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%CUSTOMER_EMAIL%]">Email</a>
								<span>[%CUSTOMER_EMAIL%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%CUSTOMER_ADDRESS%]">{$core->get_Lang('address')}</a>
								<span>[%CUSTOMER_ADDRESS%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%CUSTOMER_PHONE%]">{$core->get_Lang('phone')}</a>
								<span>[%CUSTOMER_PHONE%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%CUSTOMER_COUNTRY%]">{$core->get_Lang('country')}</a>
								<span>[%CUSTOMER_COUNTRY%]</span>
							</li>
							<li>
								<a class="command" href="javascript:void();" data="[%DATETIME%]">{$core->get_Lang('datetime')}</a>
								<span>[%DATETIME%]</span>
							</li>
							<li class="lastBorder">
								<a class="command" href="javascript:void();" data="[%UNSUBSCRIBE%]">Unsubscribe email</a>
								<span>[%UNSUBSCRIBE%]</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

