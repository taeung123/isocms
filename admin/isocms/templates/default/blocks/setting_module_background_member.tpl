<div class="form-group inpt_tour">
	<h3 class="title_box">{$core->get_Lang('background color')}</h3>
	<div class="row">
		{assign var=site_mod_background value='site_member_background'}
		<div class="col-xs-12 col-md-4">
			<div class="drop_gallery">
				<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_background" data-options='{ldelim}"openFrom":"background","clsTable":"Configuration", "table_id":"{$pvalTable|default:0}","toId":"isoman_show_background" {rdelim}' ondragover="return false">
					<h3>{$core->get_Lang('Drop files to upload')}</h3>
					<p>Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
					<button type="button" class="btn btn-upload">{if !empty($oneItem.background)}Thay ảnh{else}Tải ảnh lên{/if}</button>
				</div>
				<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"background","clsTable":"Configuration", "table_id":"{$pvalTable|default:0}","toId":"isoman_show_background"{rdelim}' name="iso-{$site_mod_background}">

				<input type="hidden" value="{$clsConfiguration->getValue($site_mod_background)}" name="iso-{$site_mod_background}" id="background" />
				<a table_id="{$pvalTable|default:0}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"background", "clsTable":"Configuration", "pvalTable":"{$pvalTable|default:0}","toField":"background","toId":"isoman_show_background"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="background" isoman_name="background">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
			</div>
		</div>
		<div class="col-xs-12 col-md-8">
			<img class="img-responsive radius-3" id="isoman_show_background" src="{$clsConfiguration->getValue($site_mod_background)}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('background')}" style="width:100%; height:250px;object-fit: contain"  />
		</div>
	</div>
</div>