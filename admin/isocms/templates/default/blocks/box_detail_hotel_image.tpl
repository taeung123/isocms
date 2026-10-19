<h3 class="title_box">{$core->get_Lang('Image')}</h3>
	<div class="form_option_tour">
		<div class="inpt_tour">
			<div class="row">
				<div class="col-md-5 col-sm-12">
					<div class="drop_gallery">
						<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image" data-options='{ldelim}"openFrom":"image","clsTable":"Hotel", "table_id":"{$pvalTable}","toId":"isoman_show_image" {rdelim}' ondragover="return false">
							<h3>{$core->get_Lang('Drop files to upload')}</h3>
							<p>Kích thước (WxH=750x500)<br />
							Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
							<button type="button" class="btn btn-upload">{if $oneItem.image}Thay ảnh{else}Tải ảnh lên{/if}</button>
						</div>
						<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"image","clsTable":"Hotel", "table_id":"{$pvalTable}","toId":"isoman_show_image"{rdelim}' name="image">

						
						<input type="hidden" value="{$oneItem.image}"  name="image" id="image" />
						<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"Hotel", "pvalTable":"{$pvalTable}","toField":"image","toId":"isoman_show_image"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="image" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
					</div>
				</div>
				<div class="col-xs-12 col-md-4">
					<div class="aspect-ratio aspect-ratio--square aspect-ratio--square--full aspect-ratio--interactive">
						<img class="aspect-ratio__content radius-3" id="isoman_show_image" src="{$oneItem.image}" width="250px" height="170px" />
					</div>
				</div>
			</div><!-- /file list -->
		</div>
	</div>
<script>
var table_id = '{$pvalTable}';
var clsTable = 'Tour';
</script>