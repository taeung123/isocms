<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Feature Package')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Feature Package')}{/if}</h2>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<input class="text_32 full-width border_aaa bold required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Module')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							{assign var=lstModule value=$core->getListAdminModule()}
							<select class="medium" id="mod_page" name="iso-mod_page">
								<option value="">-</option>
								{section name=i loop=$lstModule}
								<option {if $oneItem.mod_page eq $lstModule[i].name}selected="selected"{/if} value="{$lstModule[i].name}">[{$lstModule[i].name}] {$lstModule[i].intro}</option>
								{/section}
							</select>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Action Page')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<input class="text_32 span30 border_aaa required" name="iso-act_page" value="{$clsClassTable->getAction($pvalTable)}" maxlength="255" type="text" style="width: 300px;">
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Type Page')}</strong></div>
						<div class="fieldarea">
							<input class="text_32 span30 border_aaa" name="iso-type_page" value="{$clsClassTable->getTypePage($pvalTable)}" maxlength="255" type="text" style="width: 300px;">
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Type function')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							<select class="medium" name="iso-type" style="width: 150px;">
								<option {if $oneItem.type eq 'default'}selected="selected"{/if} value="default">Default</option>
								<option {if $oneItem.type eq 'ajax'}selected="selected"{/if} value="ajax">Ajax</option>
								<option {if $oneItem.type eq 'customize'}selected="selected"{/if} value="customize">Customize</option>
							</select>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
						<div class="vietiso_status_button"></div>
						<script type="text/javascript">
							var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
						</script>
						{literal}
						<script type="text/javascript">
							$(document).ready(function(){
								$('.vietiso_status_button').isoswitchvalue({
									_value:is_online,
									_selector:'iso-is_online'
								});
							});
						</script>
						{/literal}
						<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
						<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Content')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							{$clsForm->showInput('content')}
						</div>
					</div>
                </div>
        	</div>
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
var $type = '_FAQS';
var $SiteHasTags_Faqs = "{$clsConfiguration->getValue('SiteHasTags_Faqs')}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/faqs/jquery.faqs.js?v={$upd_version}"></script>