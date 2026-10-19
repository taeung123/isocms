<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('country')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('settingcountry')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('settingcountry')}</h2>
        <p>{$core->get_Lang('systemmanagementsettingcountry')}</p>
    </div>
	<div id="clienttabs">
		<ul>
			<li><a><i class="fa fa-cog"></i> {$core->get_Lang('general')}</a></li>
            <li class="tabchild"><a href="#"><i class="iso-media"></i> {$core->get_Lang('seosdvanced')}</a></li>
		</ul>
	</div>
	<div id="tab_content">
		<div class="tabbox">
			<form method="post" action="" enctype="multipart/form-data">
				<table class="form" cellpadding="3" cellspacing="3">
                	{if $_DEV && $clsConfiguration->getValue('SiteConfigModLink')}
					<tr>
						<td class="fieldlabel span20">{$core->get_Lang('link')}</td>
						<td class="fieldarea">
                        	{assign var=site_country_link value=site_country_link_|cat:$_LANG_ID}
							<input class="text full required" name="iso-{$site_country_link}" value="{$clsConfiguration->getValue($site_country_link)}" maxlength="255" type="text" />
						</td>
					</tr>
                    {/if}
					<tr>
						<td class="fieldlabel">{$core->get_Lang('intropage')}</td>
						<td class="fieldarea">
                        	{assign var=site_country_intro value=site_country_intro_|cat:$_LANG_ID}
                            <textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_country_intro}" style="width:100%">{$clsConfiguration->getValue($site_country_intro)}</textarea>
						</td>
					</tr>
                    <tr>
                    <td class="fieldlabel">{$core->get_Lang('intropage')}</td>
                    <td class="fieldarea">
                      <fieldset>
                        <div class="row-span">
                            <span class="notice bold" style="font-size:16px; padding-left:0;"><span class="requiredMask">*</span> {$core->get_Lang('ImageDestinations')} (W x H =731 x 410)</span>
                            <div class="clearfix" style="height:5px"></div>
                            <div class="photobox destination span100">
                                <img src="{$clsConfiguration->getValue('ImageDestination')}" alt="{$core->get_Lang('images')}"  id="isoman_show_image_Image" class="span100"  style="width:100%;height:410px"/>
                                    <input type="hidden" id="isoman_hidden_image_Image" name="iso-ImageDestination" value="{$clsConfiguration->getValue('ImageDestination')}" />
                                    <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image_Image" isoman_val="{$clsConfiguration->getValue('ImageDestination')}" isoman_name="image" title="{$core->get_Lang('edit')}">
                                        <i class="iso-edit"></i>
                                    </a>
                            </div>
                        </div>
                    </fieldset>
                    </td>
                    </tr>
                    <tr style="display:none !important">
                      <fieldset style="display:none">
                        <div class="row-span">
                            <span class="notice bold" style="font-size:16px; padding-left:0;"><span class="requiredMask">*</span> {$core->get_Lang('bannercover')}</span>
                            <div class="clearfix" style="height:5px"></div>
                            <div class="photobox span100">
                                <img src="{$clsConfiguration->getValue('BannerDestination')}" alt="{$core->get_Lang('images')}"  id="isoman_show_image_Slide" class="span100"  style="width:100%;height:495px"/>
                                    <input type="hidden" id="isoman_hidden_image_Slide" name="iso-BannerDestination" value="{$clsConfiguration->getValue('BannerDestination')}" />
                                    <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image_Slide" isoman_val="{$clsConfiguration->getValue('BannerDestination')}" isoman_name="image" title="{$core->get_Lang('edit')}">
                                        <i class="iso-edit"></i>
                                    </a>
                            </div>
                        </div>
                    </fieldset>
                    </tr>
				</table>
				<div class="clearfix mt10"></div>
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
        <div class="tabbox" style="display:none">
            {$core->getBlock('meta_box')}
        </div>
	</div>
</div>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker();
	});
</script>
{/literal}