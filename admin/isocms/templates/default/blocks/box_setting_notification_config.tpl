<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('settingmessage')} </h2>
    </div>
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
		<div class="iso_box_submit">
            <button type="submit" name="button" class="iso_setting_submit">
                <i class="icon-ok icon-white"></i>
                <span>{$core->get_Lang('Save')}</span>
            </button>
        </div>
        <input value="{$action}" name="submit" type="hidden">
	</form> 
</div>
<script type="text/javascript" src="{$URL_THEMES}/setting/jquery.setting.js"></script>