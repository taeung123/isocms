<h3 class="title_box">{$core->get_Lang('Image')}
{*
{assign var= help_first value=$image_detail}
{if $CHECKHELP eq 1}
<button data-key="{$image_detail}" data-label="{$core->get_Lang('Image')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
{/if}
*}
</h3>
<div class="form_option_tour">
	<div class="inpt_tour">
		<div class="row">
			{*<div class="col-md-5 col-sm-12">
				<div class="drop_gallery" onClick="loadHelp(this)" >
					<div class="text_help" hidden="">{$clsConfiguration->getValue($image_detail)|html_entity_decode}</div>
					<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_avatar" data-options='{ldelim}"openFrom":"avatar","clsTable":"{$clsTable}", "table_id":"{$pvalTable}","toId":"isoman_show_avatar" {rdelim}' ondragover="return false">
						<h3>{$core->get_Lang('Drop files to upload')}</h3>
						<p>Kích thước (WxH=750x500)<br />
						Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
						<button type="button" class="btn btn-upload">{if $oneItem.avatar}Thay ảnh{else}Tải ảnh lên{/if}</button>
					</div>
					<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"avatar","clsTable":"{$clsTable}", "table_id":"{$pvalTable}","toId":"isoman_show_avatar"{rdelim}' name="avatar">

					<input style="display:none" type="file" multiple name="avatar" id="ajAttachFile" />
					<input type="hidden" value="{$oneItem.avatar}" name="avatar" id="avatar" />
					<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"avatar", "clsTable":"{$clsTable}", "pvalTable":"{$pvalTable}", "table_id":"{$pvalTable}","toField":"avatar","toId":"isoman_show_avatar"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="avatar" isoman_name="avatar">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
				</div>
			</div>*}
			<div class="col-xs-12 col-md-4">
				<div class="aspect-ratio aspect-ratio--square aspect-ratio--square--full aspect-ratio--interactive">
					<img class="aspect-ratio__content radius-3" id="isoman_show_avatar" src="{$oneItem.avatar}" width="250px" height="170px" />
				</div>
			</div>
		</div><!-- /file list -->
	</div>
</div>