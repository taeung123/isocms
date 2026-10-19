<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('hotels pro')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('settinghotel')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('settinghotel')}</h2>
        <p>{$core->get_Lang('systemmanagementsettinghotel')}</p>
    </div>
	<div class="wrap mt10 mb20">
        <fieldset>
			<legend>{$core->get_Lang('selectsetting')}</legend>
			<ul class="rsl-list-link">
				{assign var=lstProperty value=$clsProperty->getListType()}
                {foreach from=$lstProperty key=k item=v}
				{if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default',$k)}
                <li>
                    <a title="{$v}" href="{$PCMS_URL}/index.php?mod=property&type={$k}" >
                        <span class="text"><i class="fa fa-cog"></i> {$v}</span>
                    </a>
                </li>
				{/if}
                {/foreach}
				{if $clsISO->getCheckActiveModulePackage($package_id,'hotel','price_range','default')}
				<li>
					<a title="{$core->get_Lang('Price Range')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=price_range" >
						<span class="text"><i class="fa fa-cog"></i> {$core->get_Lang('Price Range')}</span>
					</a>
				</li>
				{/if}
			</ul>
		</fieldset>
	</div>
	<div id="clienttabs">
		<ul>
			<li><a><i class="fa fa-cog"></i> {$core->get_Lang('intropage')}</a></li>
            <li><a><i class="fa fa-cog"></i> {$core->get_Lang('bannercover')}</a></li>
		</ul>
	</div>
	<div id="tab_content">
    	<form method="post" action="" enctype="multipart/form-data">
            <div class="tabbox">
                {assign var=site_hotel_intro value=site_hotel_intro_|cat:$_LANG_ID}
                <textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_hotel_intro}" style="width:100%">{$clsConfiguration->getValue($site_hotel_intro)}</textarea>
            </div>
            <div class="tabbox" style="display:none">
                <div class="photobox span98">
                    <img src="{$clsConfiguration->getValue('site_hotel_banner')}" id="isoman_show_site_hotel_banner" class="span100" height="156px" style="width:100%;" />
                    <input type="hidden" id="isoman_hidden_site_hotel_banner" name="isoman_url_site_hotel_banner" value="{$clsConfiguration->getValue('site_hotel_banner')}" />
                    <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="site_hotel_banner" isoman_val="{$clsConfiguration->getValue('site_hotel_banner')}" isoman_name="site_hotel_banner" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
                </div>
            </div>
            <div class="clearfix mt10"></div>
            <fieldset class="submit-buttons">
                {$saveBtn}
                <input value="UpdateConfiguration" name="submit" type="hidden">
            </fieldset>
   		</form>
	</div>
</div>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker();
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/hotelpro/jquery.hotelpro.js"></script>