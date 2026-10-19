<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-12">
			<div class="fill_data_box">
				<div class="form-group inpt_tour">
					<label class="col-form-label" for="title">{$core->get_Lang('Banner Size')} <span class="required_red">*</span>
						{assign var= banner_region value='banner_region'}
						{assign var= help_first value=$banner_region}
						{if $CHECKHELP eq 1}
						<button data-key="{$banner_region}" data-label="{$core->get_Lang('Banner')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
					</label>
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="drop_gallery" onClick="loadHelp(this)">
								<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_banner" data-options='{ldelim}"openFrom":"banner","clsTable":"Region", "table_id":"{$pvalTable}","toId":"isoman_show_banner","toField":"banner" {rdelim}' ondragover="return false">
									<h3>{$core->get_Lang('Drop files to upload')}</h3>
									<p>Kích thước (WxH=1920x400px)<br />
									Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
									<button type="button" class="btn btn-upload">{if $oneItem.banner}Thay ảnh{else}Tải ảnh lên{/if}</button>
								</div>
								<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"banner","clsTable":"Region", "table_id":"{$pvalTable}","toId":"isoman_show_banner","toField":"banner"{rdelim}' name="banner">

								<input type="hidden" value="{$oneItem.banner}" name="banner" id="banner" />
								<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"banner", "clsTable":"Region", "pvalTable":"{$pvalTable}","toField":"banner","toId":"isoman_show_banner"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="banner" isoman_name="banner">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_region)|html_entity_decode}</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<img class="img-responsive radius-3" id="isoman_show_banner" src="{$clsClassTable->getBanner($pvalTable,1920,400)}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('banner')}" style="width:100%; height:auto"  />
						</div>
					</div>
				</div>
				<hr class="clearfix" />
                {if 1==2}
				<div class="inpt_tour">
					<label for="title">{$core->get_Lang('Banner Link')} <span class="required_red">*</span>
					{assign var= banner_link_region value='banner_link_region'}
					{assign var= help_first value=$banner_link_region}
					{if $CHECKHELP eq 1}
					<button data-key="{$banner_link_region}" data-label="{$core->get_Lang('Banner Link')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
					{/if}
					</label>
					<input class="text_32 full-width bold border_aaa required title_capitalize" name="iso-link_banner" value="{$oneItem.link_banner}"  type="text" onClick="loadHelp(this)" placeholder="{$DOMAIN_NAME}" />
					<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_link_region)|html_entity_decode}</div>
				</div>
				<div class="inpt_tour">
					<label for="title">{$core->get_Lang('Banner Content')} <span class="required_red">*</span>
						{assign var= banner_content_region value='banner_content_region'}
						{assign var= help_first value=$banner_content_region}
						{if $CHECKHELP eq 1}
						<button data-key="{$banner_content_region}" data-label="{$core->get_Lang('Banner Content')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
					</label>
					<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro_banner" class="textarea_intro_editor" data-column="iso-intro_banner" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.intro_banner}</textarea>
					<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_content_region)|html_entity_decode}</div>
					{literal}
					<script>
					$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
					</script>
					{/literal}
				</div>
                {/if}
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var clsTable = 'Region';
	var table_id = '{$pvalTable}';
</script>