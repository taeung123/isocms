<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-12">
			<div class="fill_data_box">
				<div class="form-group inpt_tour">
					<label class="col-form-label" for="title">{$core->get_Lang('Banner Size')} <span class="required_red">*</span>
						{assign var= banner_city value='banner_city'}
						{assign var= help_first value=$banner_city}
						{if $CHECKHELP eq 1}
						<button data-key="{$banner_city}" data-label="{$core->get_Lang('Banner')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
					</label>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="drop_gallery" onClick="loadHelp(this)">
								<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_banner" data-options='{ldelim}"openFrom":"banner","clsTable":"City", "table_id":"{$pvalTable}","toId":"isoman_show_banner","toField":"banner" {rdelim}' ondragover="return false">
									<h3>{$core->get_Lang('Drop files to upload')}</h3>
									<p>Kích thước (WxH=1920x400px)<br />
									Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
									<button type="button" class="btn btn-upload">{if $oneItem.banner}Thay ảnh{else}Tải ảnh lên{/if}</button>
								</div>
								<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"banner","clsTable":"City", "table_id":"{$pvalTable}","toId":"isoman_show_banner","toField":"banner"{rdelim}' name="banner">

								<input type="hidden" value="{$oneItem.banner}" name="banner" id="banner" />
								<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"banner", "clsTable":"City", "pvalTable":"{$pvalTable}","toField":"banner","toId":"isoman_show_banner"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="banner" isoman_name="banner">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_city)|html_entity_decode}</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<img class="img-responsive radius-3" id="isoman_show_banner" src="{$clsClassTable->getBanner($pvalTable,400,100)}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('banner')}" style="width:100%; height:auto"  />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var clsTable = 'City';
	var table_id = '{$pvalTable}';
</script>