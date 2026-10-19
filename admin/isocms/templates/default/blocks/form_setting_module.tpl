<form method="post" action="" enctype="multipart/form-data">
	<div id="clienttabs">
		<ul>
			<li><a><i class="fa fa-cog"></i> {$core->get_Lang('general')}</a></li>
			<li class="tabchild"><a href="#"><i class="iso-media"></i> {$core->get_Lang('seosdvanced')}</a></li>
		</ul>
	</div>
	<div id="tab_content">
		<div class="tabbox">
			<table class="form" cellpadding="3" cellspacing="3">
				<tr class="row-span" style="display:none">
					<td class="fieldlabel span20">{$core->get_Lang('link')}</td>
					<td class="fieldarea">
						{assign var=site_mod_link value='site_'|cat:$mod|cat:'_link_'|cat:$_LANG_ID}
						
						<input class="text full required" name="iso-{$site_mod_link}" value="{$clsConfiguration->getValue($site_mod_link)}" maxlength="255" type="text" />
					</td>
				</tr>
				{if $clsISO->checkInArray('continent,country,city,blog,news,faqs',$mod)}
				<tr class="row-span">
					<td class="fieldlabel">{$core->get_Lang('intropage')}</td>
					<td class="fieldarea">
						{assign var=site_mod_intro value='site_'|cat:$mod|cat:'_intro_'|cat:$_LANG_ID}
						<textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_mod_intro}" style="width:100%">{$clsConfiguration->getValue($site_mod_intro)}</textarea>
					</td>
				</tr>
				{/if}
				<tr class="row-span">
					<td class="fieldlabel">{$core->get_Lang('bannercover')}</td>
					<td class="fieldarea">
						{assign var=site_mod_banner value='site_'|cat:$mod|cat:'_banner'}
						<div class="photobox span98">
							<img src="{$clsConfiguration->getValue($site_mod_banner)}" id="isoman_show_{$site_mod_banner}" class="span100" height="156px" style="width:100%;" />
							<input type="hidden" id="isoman_hidden_{$site_mod_banner}" name="iso-{$site_mod_banner}" value="{$clsConfiguration->getValue($site_mod_banner)}" />
							<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="{$site_mod_banner}" isoman_val="{$clsConfiguration->getValue($site_mod_banner)}" isoman_name="{$site_mod_banner}" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
						</div>
					</td>
				</tr>
				<tr class="row-span" style="display:none">
					<td class="fieldlabel span20">{$core->get_Lang('introBanner')}</td>
					<td class="fieldarea">
						{assign var=site_intro_mod_banner value='site_intro_'|cat:$mod|cat:'_banner_'|cat:$_LANG_ID}
						<input class="text full required" name="iso-{$site_intro_mod_banner}" value="{$clsConfiguration->getValue($site_intro_mod_banner)}" maxlength="1000" type="text" />
					</td>
				</tr>
			</table>
			<div class="clearfix mt10"></div>
			<fieldset class="submit-buttons">
				{$saveBtn}
				<input value="UpdateConfiguration" name="submit" type="hidden">
			</fieldset>
		</div>
		<div class="tabbox" style="display:none">
			{$core->getBlock('meta_box_module')}
		</div>
	</div>
</form>