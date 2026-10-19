<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('pricing')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('settingpackage')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Setting Package')} <a class="btn btn-success" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit" title="{$core->get_Lang('Add new')}"> <i class="icon-plus icon-white"></i> <span></span></a></h2>
        <p>Chức năng cài đặt các Package trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function setting Package in isoCMS system')}</p>
    </div>
	<div class="clearfix mb30"></div>
	<div class="content_package">
		<form id="frmSettingPackage" method="post" action="" enctype="multipart/form-data" class="validate-form">
			<div class="row">
				{section name=i loop=$listPackage}
				<div class="col-xs-4">
					<h3 class="title_package text-center mb10">{$clsPackage->getTitle($listPackage[i].package_id)}</h3>
					<table class="feature_package_table full-width">
						<tr>
							<th class="text-left" width="80%">{$core->get_Lang('Feature')}</th>
<!--							<th>{$core->get_Lang('limited')}</th>-->
							<th width="20%">{$core->get_Lang('Show')}</th>
							{*<th style="display:none">{$core->get_Lang('Show Home')}</th>*}
						</tr>
						{section name=j loop=$listFeaturePackage}
						<tr class="featureItem">
							<td class="text-left">{$clsFeaturePackage->getTitle($listFeaturePackage[j].feature_package_id)}</td>
							{*<td>
							<select>
							{$clsISO->makeSelectNumberLimitFeature(300)}
							</select>
							</td>*}
							<td class="text-center"><input type="checkbox" {if $clsISO->checkInArray($listPackage[i].list_feature_package_id,$listFeaturePackage[j].feature_package_id)}checked="checked"{/if} name="list_feature_package_id_{$listPackage[i].package_id}[]" value="{$listFeaturePackage[j].feature_package_id}" /></td>
							{*<td class="text-center" style="display:none"><input type="checkbox" {if $clsISO->checkInArray($listPackage[i].list_feature_package_home_id,$listFeaturePackage[j].feature_package_id)}checked="checked"{/if} name="list_feature_package_home_id_{$listPackage[i].package_id}[]" value="{$listFeaturePackage[j].feature_package_id}"/></td>*}
						</tr>
						{/section}
					</table>
				</div>
				{/section}
			</div>
			<div class="clearfix mb30"></div>
			<div class="button text-center">
				<button type="submit" class="btn-update" name="submit" value="Update">
				<i class="iso-update"></i> {$core->get_Lang('Save')}
				</button>
				<input type="hidden" name="UpdateSettingFeaturePackage" value="UpdateSettingFeaturePackage" />
			</div>
		</form>
		<div class="clearfix mb40"></div>
		<form id="frmSettingPricingQuestion" method="post" action="" enctype="multipart/form-data" class="validate-form">
			<fieldset>
				<legend>{$core->get_Lang('Frequently asked questions')}</legend>
				<fieldset style="border: none; margin: 0; padding:0; background:none !important">
					{section name=i loop=$listSitePricing}
					<div style="border:1px dashed #F90; padding:10px; background:#FFC; margin-bottom:10px;">
						<div style="background:#DDD; padding:6px;">{$core->get_Lang('questions')} {$smarty.section.i.iteration}</div>
						<dl>
							<dt><label for="title">{$core->get_Lang('Title')}</label></dt>
							<dd>
								<input type="text" value="{$listSitePricing[i].title}" name="title_{$listSitePricing[i].faq_id}" class="full text required">
							</dd>
						</dl>
						<dl>
							<dt><label for="title">{$core->get_Lang('Short description')}</label></dt>
							<dd>
								<textarea id="textarea_intro_editor{$listSitePricing[i].faq_id}" class="textarea_intro_editor_simple" cols="255" rows="3" name="content_{$listSitePricing[i].faq_id}">{$listSitePricing[i].content}</textarea>
							</dd>
						</dl>
						<div class="wrap mt5">
							<a class="color_r font11px confirm_delete" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=delete&faq_id={$listSitePricing[i].faq_id}"><img align="absmiddle" src="{$URL_IMAGES}/v2/icon_delete.gif" />{$core->get_Lang('Delete questions')}</a>
						</div>
					</div>
					{/section}
					<div class="clearfix"></div>
					<a href="{$PCMS_URL}/index.php?mod={$mod}&act=setting&action=addnew" class="btn btn-danger"><i class="icon-white icon-plus-sign"></i> {$core->get_Lang('Add new questions')}</a>
				</fieldset>
			</fieldset>
			<div class="button text-center">
				<button type="submit" class="btn-update" name="submit" value="Update">
				<i class="iso-update"></i> {$core->get_Lang('Save')}
				</button>
				<input type="hidden" name="UpdateSettingPricingQuestion" value="UpdateSettingPricingQuestion" />
			</div>
		</form>
	</div>	
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
<script type="text/javascript">
$("#SortAble").sortable({
	opacity: 0.8,
	cursor: 'move',
	start: function(){
		vietiso_loading(1);
	},
	stop: function(){
		vietiso_loading(0);
	},
	update: function(){
		var recordPerPage = $recordPerPage;
		var currentPage = $currentPage;
		var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
		$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListPackage", order, 
		function(html){
			vietiso_loading(0);
			location.href = REQUEST_URI;
		});
	}
});
</script>
{/literal}