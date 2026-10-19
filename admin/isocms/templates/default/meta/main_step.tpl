<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code" {$currentstep}>
						<h3 class="title_box">{$core->get_Lang('Edit Meta Tags')}</h3>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Link')} <span class="required_red">*</span>
									{assign var= config_link_meta value='config_link_meta'}
									{assign var= help_first value=$config_link_meta}
									{if $CHECKHELP eq 1}
									<button data-key="{$config_link_meta}" data-label="{$core->get_Lang('Link')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="d-flex" onClick="loadHelp(this)" style="align-items:center">
									{$DOMAIN_NAME}<input class="text_32 full-width border_aaa bold required" name="config_link" value="{$clsClassTable->getConfigLink($pvalTable)}" type="text" style="margin-left: 15px">
								</div>
								
								<div class="text_help" hidden="">{$clsConfiguration->getValue($config_link_meta)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Meta Title')} <span class="required_red">*</span>
									{assign var= config_title_meta value='config_title_meta'}
									{if $CHECKHELP eq 1}
									<button data-key="{$config_title_meta}" data-label="{$core->get_Lang('Meta Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="text_32 full-width border_aaa bold required" name="config_value_title" value="{$clsClassTable->getMetaTitle($pvalTable)}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($config_title_meta)|html_entity_decode}</div>
							</div>
							
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Meta Description')} <span class="required_red">*</span>
									{assign var= config_value_intro_meta value='config_value_intro_meta'}
									{if $CHECKHELP eq 1}
									<button data-key="{$config_value_intro_meta}" data-label="{$core->get_Lang('Meta Description')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<textarea style="width:100%" table_id="{$pvalTable}" name="iso-config_value_intro" class="textarea_intro_editor" data-column="iso-config_value_intro" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2" onClick="loadHelp(this)">{$oneItem.config_value_intro}</textarea>
								 <div class="text_help" hidden="">{$clsConfiguration->getValue($config_value_intro_meta)|html_entity_decode}</div>
							</div>
							
							<div class="inpt_tour">
								<label class="col-form-label" for="title">{$core->get_Lang('Image Share Social')} <span class="required_red">*</span>
									{assign var= image_share_social_meta value='image_share_social_meta'}
									{if $CHECKHELP eq 1}
									<button data-key="{$image_share_social_meta}" data-label="{$core->get_Lang('Image Share Social')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="row">
									<div class="col-xs-12 col-md-4">
										<div class="drop_gallery" onClick="loadHelp(this)">
											<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image" data-options='{ldelim}"openFrom":"image","clsTable":"Meta", "table_id":"{$pvalTable}","toId":"isoman_show_image" {rdelim}' ondragover="return false">
												<h3>{$core->get_Lang('Drop files to upload')}</h3>
												<p>Kích thước (WxH=500x261)<br />
												Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
												<button type="button" class="btn btn-upload">{if $oneItem.image}Thay ảnh{else}Tải ảnh lên{/if}</button>
											</div>
											<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"image","clsTable":"Meta", "table_id":"{$pvalTable}","toId":"isoman_show_image"{rdelim}' name="image">

											<input type="hidden" value="{$oneItem.image}" name="image" id="image" />
											<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"Meta", "pvalTable":"{$pvalTable}","toField":"image","toId":"isoman_show_image"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="image" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
											<div class="text_help" hidden="">{$clsConfiguration->getValue($image_share_social_meta)|html_entity_decode}</div>
										</div>
									</div>
									<div class="col-xs-12 col-md-8">
										<img class="img-responsive radius-3" id="isoman_show_image" src="{$oneItem.image}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('image')}" style="width:100%; height:250px;object-fit: contain"  />
									</div>
								</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Meta Index')} <span class="required_red">*</span>
								{assign var= meta_index_meta value='meta_index_meta'}
								{if $CHECKHELP eq 1}
								<button data-key="{$meta_index_meta}" data-label="{$core->get_Lang('Cruise Class')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								</label>
								<div class="fieldarea" onClick="loadHelp(this)">
									<table>
										<tr>
											<td >{$core->get_Lang('Meta Robots Index')}</td>
											<td>
												<select name="iso-meta_index">
													<option value="0">{$core->get_Lang('Index')}</option>
													<option value="1" {if $oneItem.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
												</select>
											</td>
											<td>{$core->get_Lang('Meta Robots Follow')}</td>
											<td>
												<select name="iso-meta_follow">
													<option value="0">{$core->get_Lang('Follow')}</option>
													<option value="1" {if $oneItem.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
												</select>
											</td>
										</tr>
									</table>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($meta_index_meta)|html_entity_decode}</div>
								</div>
						</div>
						<div class="btn_save_titile_table_code mt30">
							<a href="{$PCMS}/admin/?mod={$mod}" class="back_step">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save')}</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 col_instruction">
				<div class="instruction_fill_data_box">
					<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
					<div class="content_box">{$clsConfiguration->getValue($help_first)|html_entity_decode}</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	var blog_id = $blog_id = '{$oneItem.blog_id}';
</script>
{literal}
<script>
if($('.textarea_intro_editor').length > 0){
	$('.textarea_intro_editor').each(function(){
		var $_this = $(this);
		var $editorID = $_this.attr('id');
		$('#'+$editorID).isoTextArea();
	});
}
	$('.toggle-row').click(function(){
		$(this).closest('tr').toggleClass('open_tr');
	});
	$('.js_save_continue').click(function (e) {
    e.preventDefault();

    var form = $(this).closest('form');

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: form.serialize() + '&submit=Update&button=_EDIT',
        dataType: 'html',
        success: function (res) {

            if (
                res.indexOf('UpdateSuccess') > -1 ||
                res.indexOf('InsertSuccess') > -1
            ) {

                alert('Save successfully!');

                location.reload();
            } else {
                alert('Save successfully!');
                location.reload();
            }
        },
        error: function () {
            alert('Save failed!');
        }
    });
});
</script>
{/literal}