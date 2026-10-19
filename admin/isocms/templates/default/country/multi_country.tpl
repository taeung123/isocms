
<div class="breadcrumb">
	<a href="{$PCMS_URL}" title="Trang chủ">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Country')}">{$core->get_Lang('Country')}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('Come back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Multi-Country Config')}</h2>
        <p>{$core->get_Lang('Enter full fields in the required fields')}</p>
    </div>
	<div class="clearfix"></div>
	<form id="forums" method="post" class="filterForm" action="">
		<fieldset>
			<legend>{$core->get_Lang("Multi-Country")}</legend>
			<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Title')}</div>
				{assign var = site_title_multi_country value = "site_title_multi_country_"|cat:$_LANG_ID}
				<div class="fieldarea">
					<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($site_title_multi_country)}" name="iso-{$site_title_multi_country}"/>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
				<div class="fieldarea">
					{assign var = site_intro_multi_country value ="site_intro_multi_country_"|cat:$_LANG_ID}
					<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$site_intro_multi_country}" id="site_intro_multi_country" cols="255" rows="2">{$clsConfiguration->getValue($site_intro_multi_country)}</textarea>
				</div>
			</div>
			{*<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Short description bottom')}</div>
				<div class="fieldarea">
					{assign var = site_intro_multi_country_bottom value ="site_intro_multi_country_bottom_"|cat:$_LANG_ID}
					<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$site_intro_multi_country_bottom}" id="site_intro_multi_country_bottom" cols="255" rows="2">{$clsConfiguration->getValue($site_intro_multi_country_bottom)}</textarea>
				</div>
			</div>*}
            <div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Banner Multi-Country')} (1920x400)</div>
				<div class="fieldarea">
					<div class="photobox" style="width:100%; height: 153px">
						<img src="{$clsConfiguration->getValue('site_multi_country_banner')}" id="isoman_show_site_multi_country_banner" width="100%" height="153"/>
						<input type="hidden" id="isoman_hidden_site_multi_country_banner" name="iso-site_multi_country_banner" value="{$clsConfiguration->getValue('site_multi_country_banner')}" />
						<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="site_multi_country_banner" isoman_val="{$clsConfiguration->getValue('site_multi_country_banner')}" isoman_name="site_multi_country_banner" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
					</div>
				</div>
			</div>
            {*<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Image Menu Multi-Country')}</div>
				<div class="fieldarea">
					<div class="photobox" style="width: 362px; height: 153px">
						<img src="{$clsConfiguration->getValue('site_multi_country_image_menu')}" id="isoman_show_site_multi_country_image_menu" width="362" height="153"/>
						<input type="hidden" id="isoman_hidden_site_multi_country_image_menu" name="iso-site_multi_country_image_menu" value="{$clsConfiguration->getValue('site_multi_country_image_menu')}" />
						<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="site_multi_country_image_menu" isoman_val="{$clsConfiguration->getValue('site_multi_country_image_menu')}" isoman_name="site_multi_country_image_menu" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
					</div>
				</div>
			</div>*}
            {*<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Image Multi-Country')} (307x290)</div>
				<div class="fieldarea">
					<div class="photobox" style="width: 307px; height: 290px">
						<img src="{$clsConfiguration->getValue('site_multi_country_image')}" id="isoman_show_site_multi_country_image" width="307" height="290"/>
						<input type="hidden" id="isoman_hidden_site_multi_country_image" name="iso-site_multi_country_image" value="{$clsConfiguration->getValue('site_multi_country_image')}" />
						<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="site_multi_country_image" isoman_val="{$clsConfiguration->getValue('site_multi_country_image')}" isoman_name="site_multi_country_image" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
					</div>
				</div>
			</div>*}
		</fieldset>

		<fieldset class="submit-buttons">
			{$saveBtn}
			<input value="UpdateConfiguration" name="submit" type="hidden">
		</fieldset>
	</form>
</div>
<script type="text/javascript">
	var $type = 'WhyUsHomePage';
	var $target_id = '0';
</script>