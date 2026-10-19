<div class="iso_box_sticky d-flex align-items-center justify-content-between">
    <div class="box_history d-flex align-items-center">
        <a href="javascript:window.history.back();" class="">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </a>
        <h2>{$core->get_Lang('emailtemplate')}</h2>
    </div>
    <div class="iso_btn_sticky">
        <button type="submit" class="iso_setting_sticky iso_setting_btn">
            <i class="icon-ok icon-white"></i>
            <span>{$core->get_Lang('Save')}</span>
        </button>
    </div>
</div>
<div class="container-fluid">
    <div class="row iso_container_body">
        <div class="col-md-3">
            <div class="iso_page_title">	
                {$core->get_Lang('Available Merge Fields')}
            </div>
            <div class="row">
                <div class="col-12">
                    <div class=" full_width iso_box_left">
                        <div class="iso_row_heading d-flex align-items-center justify-content-between active">
                            {$core->get_Lang('company')}
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>
                        <div class="content iso_coltrols active">
                            <ul class="iso_wicket">
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
                <div class="col-12">
                    <div class=" full_width iso_box_left">
                        <div class="iso_row_heading d-flex align-items-center justify-content-between">
                            {$core->get_Lang('customer')}
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>
                        <div class="content iso_coltrols">
                            <ul class="iso_wicket">
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
        <div class="col-md-9">
            <form method="post" action="" enctype="multipart/form-data" class="validate-form" id="formEmailTemplate">
                <div class="row form_item">
                    <div class="col-sm-10">
                        <label><span class="red">*</span> {$core->get_Lang('templatename')}</label>
                        <input class="text full required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                    </div>
                </div>
                <div class="row form_item">
                    <div class="col-sm-5">
                        <label><span class="red">*</span> {$core->get_Lang('Group')}</label>
                        <select name="iso-cat_id" class="required">
                            <option value="0">{$core->get_Lang('Category')}</option>
                            {section name=i loop=$lstEmailTemplateCat}
                            <option {if $oneItem.cat_id eq $lstEmailTemplateCat[i].email_template_cat_id}selected="selected"{/if} value="{$lstEmailTemplateCat[i].email_template_cat_id}">{$clsEmailTemplateCat->getTitle($lstEmailTemplateCat[i].email_template_cat_id)}</option>
                            {/section}
                        </select>
                    </div>
                </div>
                <div class="row form_item">
                    <div class="col-sm-10">
                        <label><span class="red">*</span> {$core->get_Lang('From')} </label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="text" name="iso-fromname" size="25" value="{$clsClassTable->getFromName($pvalTable)}" placeholder="Join Carter,..." data-enter-submit="true"/>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="text" name="iso-fromemail" size="40" value="{$clsClassTable->getFromEmail($pvalTable)}" data-enter-submit="true" placeholder="example@email.com"> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form_item">
                    <div class="col-sm-10">
                        <label><span class="red">*</span> {$core->get_Lang('Copy To')} </label>
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-6">
                                <input type="text" name="iso-copyto" size="50" value="{$clsClassTable->getCopyTo($pvalTable)}" data-enter-submit="true" placeholder="example@email.com,..." />
                            </div>
                            <div class="col-sm-6">{$core->get_Lang('Enter email addresses separated by a comma')}</div>
                        </div>
                    </div>
                </div>
                <div class="row form_item">
                    <div class="col-sm-10">
                        <label><span class="red">*</span> {$core->get_Lang('subject')} </label>
                        <input class="text full required" name="iso-subject" value="{$clsClassTable->getSubject($pvalTable)}" maxlength="255" type="text"  placeholder="Subject E-Mail" />
                    </div>
                </div>
                <div class="row form_item">
                    <div class="col-sm-12">
                        <label><span class="red">*</span> {$core->get_Lang('HeaderEmail')} </label>
                        <textarea id="textarea_intro_editor_header{$now}" class="textarea_intro_email_editor_simple" name="iso-header">{$clsClassTable->getHeader($pvalTable)}</textarea>
                    </div>
                </div>
                <div class="row form_item">
                    <div class="col-sm-12">
                        <label><span class="red">*</span> {$core->get_Lang('BodyEmail')} </label>
                        <textarea id="textarea_intro_editor{$now}" class="textarea_intro_email_editor" name="iso-content">{$clsClassTable->getContent($pvalTable)}</textarea>
                    </div>
                </div>
                <div class="row form_item">
                    <div class="col-sm-12">
                        <label><span class="red">*</span>{$core->get_Lang('FooterEmail')} </label>
                        <textarea id="textarea_intro_editor_footer{$now}" class="textarea_intro_email_editor_simple" name="iso-footer" >{$clsClassTable->getFooter($pvalTable)}</textarea>
                    </div>
                </div>
                <input type="hidden" name="submit" value="Update">
                <input type="submit" class="hidden iso_hidden_submit">
            </form>
        </div>
    </div>
</div>

{literal}
<script>
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

        $(document)
        .on('click', '.iso_setting_btn', function(){
            $('.iso_hidden_submit').click();
        })
        .on('click', '.iso_row_heading', function(){
            $('.iso_row_heading').removeClass('active');
            $('.iso_coltrols').removeClass('active');
            let iso_box_left = $(this).parents('.iso_box_left');
            $(this).addClass('active');
            iso_box_left.find('.iso_coltrols').addClass('active');
        })
    });
</script> 
{/literal}