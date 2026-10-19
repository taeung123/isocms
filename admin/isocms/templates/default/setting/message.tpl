<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
    <a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('System Settings')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">Quay lại</a>
</div>
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2><i class="fa fa-wrench"></i> {$core->get_Lang('Settings')} &raquo; {$core->get_Lang('settingmessage')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('settingmessage')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('System setting')}</p>
		</div>
		{if $_DEV eq '1'}
		<div class="button_right">
			<a class="btn btn-main btn-addnew btnCreateNewMessage" title="{$core->get_Lang('Add Meta Tags')}">{$core->get_Lang('Add Meta Tags')}</a>
		</div>
  	 	{/if}
    </div>
<div class="container-fluid">
    <div class="mt20"></div>
    <form method="post" action="" enctype="multipart/form-data" class="validate-form">
		<div class="accordion smk_accordion acc_with_icon"> 
			{section name=i loop=$listMessage}
			<div class="accordion_in {if $smarty.section.i.first}acc_active{/if}">
				<div class="acc_head"><div class="acc_icon_expand"></div>{$core->get_Lang($listMessage[i].setting)}</div>
				<div class="acc_content">
					<textarea id="textarea_{$listMessage[i].setting}_editor{$now}" class="textarea_intro_editor" name="iso-{$listMessage[i].setting}" style="width:100%">{$clsConfiguration->getValue($listMessage[i].setting)|html_entity_decode}</textarea>
				</div>
			</div>
			{/section}
            {if 1 eq 2}
            <div class="accordion_in">
				<div class="acc_head"><div class="acc_icon_expand"></div>{$core->get_Lang('sitetailorintro')}</div>
				<div class="acc_content">
					{assign var=site_tailor_intro value=site_tailor_intro_|cat:$_LANG_ID}
             <textarea id="textarea_{$site_tailor_intro}{$now}" class="textarea_intro_editor" name="iso-{$site_tailor_intro}" style="width:100%">{$clsConfiguration->getValue($site_tailor_intro)}</textarea>
				</div>
			</div>
            <div class="accordion_in">
				<div class="acc_head"><div class="acc_icon_expand"></div>{$core->get_Lang('sitetailoridea')}</div>
				<div class="acc_content">
					{assign var=site_tailor_idea value=site_tailor_idea_|cat:$_LANG_ID}
                    <textarea id="textarea_{$site_tailor_idea}{$now}" class="textarea_intro_editor" name="iso-{$site_tailor_idea}" style="width:100%">{$clsConfiguration->getValue($site_tailor_idea)}</textarea>
				</div>
			</div>
            <div class="accordion_in">
				<div class="acc_head"><div class="acc_icon_expand"></div>{$core->get_Lang('sitetailorrecommended')}</div>
				<div class="acc_content">
                	{assign var=site_tailor_recommended value=site_tailor_recommended_|cat:$_LANG_ID}
					<textarea id="textarea_{$site_tailor_recommended}{$now}" class="textarea_intro_editor" name="iso-{$site_tailor_recommended}" style="width:100%">{$clsConfiguration->getValue($site_tailor_recommended)}</textarea>
				</div>
			</div>
            <div class="accordion_in">
				<div class="acc_head"><div class="acc_icon_expand"></div>{$core->get_Lang('siteTravelAgent')}</div>
				<div class="acc_content">
                	{assign var=site_travel_recommended value=site_travel_recommended_|cat:$_LANG_ID}
					<textarea id="textarea_{$site_travel_recommended}{$now}" class="textarea_intro_editor" name="iso-{$site_travel_recommended}" style="width:100%">{$clsConfiguration->getValue($site_travel_recommended)}</textarea>
				</div>
			</div>
            {/if}
		</div>
		<fieldset class="submit-buttons">
			{$saveBtn}
			<input value="UpdateConfiguration" name="submit" type="hidden">
		</fieldset>
	</form> 
</div>
<script type="text/javascript" src="{$URL_THEMES}/setting/jquery.setting.js"></script>