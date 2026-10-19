<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('service')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('addservice')}{/if}</h2>
        {if $pvalTable}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</a></strong>
            </div>
        </div>
        {/if}
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
                {if $pvalTable}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
					<div class="col_Left fl">
						 <div class="photobox image">
							<img src="{$oneItem.image}" alt="Hình ảnh" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
							<a href="javascript:void()" title="Thay đổi" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
							{if $oneItem.image}
							<a pvalTable="{$pvalTable}" clsTable="Service" href="javascript:void()" title="Xóa" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
							{/if}
						</div>
						<h3 class="mt10">{$core->get_Lang('Image Size')} (WxH=280x255px)</h3>
                    </div>
					<div class="col_Right fl">
                    	<div class="row-span">
                        	<div class="fieldlabel bold"><strong>{$core->get_Lang('title')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                            	<input class="text_32 full-width border_aaa bold title_capitalize required" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
                        <div class="row-span">
                            <div class="fieldlabel bold"><strong>{$core->get_Lang('category')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <select class="glSlBox required" name="iso-cat_id" style="width: 300px;">
                                    {$clsServiceCategory->makeSelectboxOption($servicecat_id)}
                                </select>
                            </div>
                        </div>
						{/if}
                        <div class="row-span">
                            <div class="fieldlabel bold"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea d-flex align-items-center">
							<div class="checkbox-switch">
								{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
								<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
								{else}
								<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
								{/if}
								<div class="checkbox-animate">
									<span class="checkbox-off">PRIVATE</span>
									<span class="checkbox-on">PUBLIC</span>
								</div>
							</div>	
							<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
							<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
						</div>
                        </div>
                    </div>
				</div>
				<div class="wrap mt30">
					<div id="v-nav">
						<ul>
							<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Short text')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Long text')}</strong></a> <span class="color_r">*</span></li>
						</ul>
						<div class="tab-content" style="display: block;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('content')}
							</div>
						</div>
					</div>
            	</div>
        	</div>
            {if $pvalTable}
            <div class="tabbox" style="display:none">
                {$core->getBlock('meta_box_detail')}
            </div>
            {/if}
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
var $type = '_SERVICE';
var $SiteHasTags_Service = "{$clsConfiguration->getValue('SiteHasTags_Service')}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/service/jquery.service.js?v={$upd_version}"></script>