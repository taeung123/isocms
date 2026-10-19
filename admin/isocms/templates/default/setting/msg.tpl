<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
    <a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('System Settings')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">Quay lại</a>
</div>
<div class="container-fluid">
    <div class="page-title">
       <h2>{$core->get_Lang('Introduction Page')} {if $_DEV eq '1'} <a href="javascript:void(0);" class="btnCreateNewMessage" prefix="SiteInfo_" title="{$core->get_Lang('create')}"><img src="{$URL_IMAGES}/v2/add.png" /></a>{/if}</h2>
		<p>{$core->get_Lang('System setting')}</p>
    </div>
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
		</div>
		<fieldset class="submit-buttons">
			{$saveBtn}
			<input value="UpdateConfiguration" name="submit" type="hidden">
		</fieldset>
	</form> 
</div>
<script type="text/javascript" src="{$URL_THEMES}/setting/jquery.setting.js"></script>