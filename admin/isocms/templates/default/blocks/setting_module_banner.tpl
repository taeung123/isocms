<div class="form-group inpt_tour">
	<h3 class="title_box">{$core->get_Lang('Banner')}</h3>
	<div class="row">
		{assign var=site_mod_banner value='site_'|cat:$mod|cat:'_banner'}
		<div class="col-xs-12 col-md-4">
			<div class="drop_gallery">
				<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_banner" data-options='{ldelim}"openFrom":"banner","clsTable":"Configuration", "table_id":"{$pvalTable|default:0}","toId":"isoman_show_banner" {rdelim}' ondragover="return false">
					<h3>{$core->get_Lang('Drop files to upload')}</h3>
					<p>
						Image size (WxH=1920x400px)<br>
						Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
					<button type="button" class="btn btn-upload">{if isset($oneItem.banner)}Thay ảnh{else}{$core->get_Lang('From computer')}{/if}</button>
				</div>
				<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"banner","clsTable":"Configuration", "table_id":"{$pvalTable|default:0}","toId":"isoman_show_banner"{rdelim}' name="iso-{$site_mod_banner|default:''}">

				<input type="hidden" value="{$clsConfiguration->getValue($site_mod_banner)}" name="iso-{$site_mod_banner}" id="banner" />
				<a table_id="{$pvalTable|default:0}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"banner", "clsTable":"Configuration", "pvalTable":"{$pvalTable|default:0}","toField":"banner","toId":"isoman_show_banner"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="banner" isoman_name="banner">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
			</div>
		</div>
		<div class="col-xs-12 col-md-8">
			<img class="img-responsive radius-3" id="isoman_show_banner" src="{$clsConfiguration->getValue($site_mod_banner)}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('banner')}" style="width:100%; height:250px;object-fit: contain"  />
		</div>
	</div>
</div>