<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$mod|capitalize}</a>
    <a>&raquo;</a>
	 <a href="{$curl}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Package')} &raquo; <span class="color_r">{$core->get_Lang('Edit')}</span></h2>
       <p>{$core->get_Lang('Package Management')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">*</span></div>
				<div class="fieldarea">
					<input class="text_32 full-width border_aaa bold title_capitalize required" name="title" value="{$oneTable.title|default:''}" maxlength="255" type="text">
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('Status')}</strong></div>
				<div class="fieldarea">
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
			<div class="clearfix mb50"></div>
			<div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('Permissions')}</strong> <span class="color_r">*</span></div>
				<div class="fieldarea">
					<div align="right"><a href="javascript:void(0);" onclick="zCheckAll('edititem');return false">Check All</a> | <a href="javascript:void(0);" onclick="zUncheckAll('edititem');return false">Uncheck All</a></div>
					<div class="list_feature_box">
						{assign var=lstModule value=$core->getListAdminModule()}
						{foreach from=$lstModule item=module}
							{assign var=listFeaturePackageByModule value=$clsClassTable->getListFeaturePackageByModule($module.name)}
							{if $listFeaturePackageByModule}
								<div class="module_item mb30">
									<h4 class="mb10">Module {$module.name}</h4>
									<div class="row">
										{assign var=listFeaturePackageCheckId value=$list_feature_package_check_id|default:[]}
										{if !is_array($listFeaturePackageCheckId)}{assign var=listFeaturePackageCheckId value=[ $listFeaturePackageCheckId ]}{/if}

										{foreach from=$listFeaturePackageByModule item=feature}
											<div class="col-sm-4">
												<div class="item" mod="{$feature.mod_page}" act="{$feature.act_page}" type="{$feature.type}" type_page="{$feature.type_page}">
													<label>
														<input type="checkbox" 
															name="list_feature_package_id[]" 
															value="{$feature.feature_package_id}" 
															{if $feature.feature_package_id|@in_array:$listFeaturePackageCheckId}checked{/if} />
														{$clsFeaturePackage->getTitle($feature.feature_package_id)}
													</label>
												</div>
											</div>
										{/foreach}
									</div>
								</div>
							{/if}
						{/foreach}
					</div>
					
				</div>
			</div>
			<fieldset class="submit-buttons" style="position: fixed;left: 50%;transform: translateX(-50%) ;right: 0; bottom: 10px; z-index: 3; width: fit-content;">
				{$saveBtn}{$saveList}
				<input value="Update" name="submit" type="hidden" />
			</fieldset>
		</div>
    </form>
</div>
{literal}
<style type="text/css">
.fieldarea .line{display:inline-block; width:100%; margin-bottom:10px}
.fieldarea .line label{font-size:12px; font-weight:bold !important; margin-bottom:5px; display:block}
	.list_feature_box .item{display: inline-block; width: 100%; margin-bottom: 10px; font-size: 16px;}
	.list_feature_box .item input{margin: 0 5px 0;}
	.list_feature_box .item label{padding: 0; margin: 0;}
</style>
{/literal}