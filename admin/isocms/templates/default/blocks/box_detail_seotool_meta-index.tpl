<div class="box_title_trip_code" meta_id="{$meta_id}">
	<div class="row d-flex full-height">
		<div class="col-md-12">
			<div class="fill_data_box">
				<h3 class="title_box">{$core->get_Lang('Seo Tool')}</h3>
				<div class="form_option_tour">
					<div class="form-group">
						<label class="col-form-label" for="config_value_title">{$core->get_Lang('Meta Title')} <span class="required_red">*</span>						
						{assign var= meta_title_mod value='meta_title_'|cat:$mod}
						{assign var= help_first value=$meta_title_mod}
						{if $CHECKHELP eq 1}
						<button data-key="{$meta_title_mod}" data-label="{$core->get_Lang('Meta Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
						</label>
						<input class="form-control required" name="config_value_title" id="config_value_title" onkeyup="countCharTitle(this)" value="{$clsMeta->getMetaTitle($meta_id)}" maxlength="255" type="text" onClick="loadHelp(this)">
						<span class="help-block">{$core->get_Lang('The meta title of your page has a length of')} <strong id="charTitleNum">{$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta titles to 70 characters')}.</span>
						<div class="text_help" hidden="">{$clsConfiguration->getValue($meta_title_mod)|html_entity_decode}</div>
					</div>
					<div class="form-group">
						<label class="col-form-label" for="config_value_intro">{$core->get_Lang('Meta Description')} <span class="required_red">*</span>
						{assign var= meta_description_mod value='meta_description_'|cat:$mod}
						{if $CHECKHELP eq 1}
						<button data-key="{$meta_description_mod}" data-label="{$core->get_Lang('Meta Description')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
						</label>
						<textarea name="config_value_intro" id="config_value_intro" class="form-control required" onkeyup="countCharDes(this)" onClick="loadHelp(this)">{$clsMeta->getMetaDescription($meta_id)}</textarea>
						<span class="help-block">{$core->get_Lang('The meta description of your page has a length of')} <strong id="charDesNum">{$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta descriptions to 160 characters')}.</span>
						<div class="text_help" hidden="">{$clsConfiguration->getValue($meta_description_mod)|html_entity_decode}</div>
					</div>
					<div class="form-group">
						<label class="col-form-label" for="config_value_intro">{$core->get_Lang('Meta Index')} <span class="required_red">*</span></label>
						<table>
							<tr>
								<td>{$core->get_Lang('Meta Robots Index')}: </td>
								<td>
									<select name="meta_index">
										<option value="0">{$core->get_Lang('Index')}</option>
										<option value="1" {if $oneMeta.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
									</select>
								</td>
								<td>{$core->get_Lang('Meta Robots Follow')}: </td>
								<td>
									<select name="meta_follow">
										<option value="0">{$core->get_Lang('Follow')}</option>
										<option value="1" {if $oneMeta.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div class="form-group inpt_tour">
						<label class="col-form-label">{$core->get_Lang('Image Share Social')} <span class="required_red">*</span>
						{assign var= image_share_social_hotel value='image_share_social_hotel'}
						{if $CHECKHELP eq 1}
						<button data-key="{$image_share_social_hotel}" data-label="{$core->get_Lang('Image Share Social')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
						</label>
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class="filedrop-picker" onClick="loadHelp(this)">
									<div class="filedrop" onclick="file_explorer(this,event);" ondrop="file_drop(this,event)" toId="selectFile" hiddenId="isoman_hidden_image_seo" data-options='{ldelim}"openFrom":"seo","clsTable":"Meta", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}' ondragover="return false">
										<h3>Kéo ảnh vào đây để tải lên</h3>
										<p>Kích thước (WxH=500x261)<br>
										Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
										<button type="button" class="btn btn-upload">{$core->get_Lang('From computer')}</button>
									</div>
									<input type="hidden" name="meta_id" value="{$meta_id}">
									<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"seo":"image","clsTable":"Meta", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}'>
									<div class="clearfix mt-half"></div>
									<a table_id="{$meta_id}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"seo", "clsTable":"Meta", "table_id":"{$meta_id}","toField":"image","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim})' class="btn btn-upload-choice ajOpenDialog" isoman_for_id="image_seo" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($image_share_social_hotel)|html_entity_decode}</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="aspect-ratio aspect-ratio--square aspect-ratio--square--full aspect-ratio--interactive">
									<input type="hidden" id="isoman_hidden_image_seo" name="isoman_url_image_seo" value="{$clsMeta->getOneField('image',$meta_id)}" />
									<img class="aspect-ratio__content radius-3" id="isoman_show_image_seo" src="{$clsMeta->getOneField('image',$meta_id)}" width="250px" height="170px" />
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
	function countCharTitle(val) {
		var len = val.value.length;
		$('#charTitleNum').text(len);
	};
	function countCharDes(val) {
		var len = val.value.length;
		$('#charDesNum').text(len);
	};
</script>
{/literal}