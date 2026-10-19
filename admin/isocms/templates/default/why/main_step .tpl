<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code" {$currentstep}>
						<h3 class="title_box">{$core->get_Lang('Why')} &raquo; <span class="color_r">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</h3>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Title')} <span class="required_red">*</span>
									{assign var= title_why value='title_why'}
									{assign var= help_first value=$title_why}
									{if $CHECKHELP eq 1}
									<button data-key="{$title_why}" data-label="{$core->get_Lang('Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="input_text_form input-title required" data-table_id="{$pvalTable}" name="title" value="{$oneItem.title}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($title_why)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Type')} <span class="required_red">*</span>
									{assign var= type_why value='type_why'}
									{assign var= help_first value=$type_why}
									{if $CHECKHELP eq 1}
									<button data-key="{$type_why}" data-label="{$core->get_Lang('Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<select class="text full required" name="iso-type" maxlength="255" data-table_id="{$pvalTable}" style="width:200px" onClick="loadHelp(this)">
								   <option value="" {if $clsClassTable->getOneField('type',$pvalTable) eq ''}selected="selected"{/if}>Default</option>
								   <option value="HOME"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'HOME'}selected="selected"{/if}>Home</option>
								   <option value="TOUR"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'TOUR'}selected="selected"{/if}>Tour</option>
								   <option value="DESTINATION"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'DESTINATION'}selected="selected"{/if}>Destination</option>
								   <option value="CRUISE"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'CRUISE'}selected="selected"{/if}>Cruise</option>
								   <option value="HOTEL"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'HOTEL'}selected="selected"{/if}>Hotel</option>
							   </select>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($type_why)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<label class="col-form-label" for="title">{$core->get_Lang('Image')} <span class="required_red">*</span>
									{assign var= image_why value='image_why'}
									{if $CHECKHELP eq 1}
									<button data-key="{$image_why}" data-label="{$core->get_Lang('Image')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="row">
									<div class="col-xs-12 col-md-5">
										<div class="drop_gallery" onClick="loadHelp(this)">
											<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image" data-options='{ldelim}"openFrom":"image","clsTable":"Slide", "table_id":"{$pvalTable}","toId":"isoman_show_image" {rdelim}' ondragover="return false">
												<h3>{$core->get_Lang('Drop files to upload')}</h3>
												<p>Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
												<button type="button" class="btn btn-upload">{if $oneItem.image}Thay ảnh{else}Tải ảnh lên{/if}</button>
											</div>
											<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"image","clsTable":"Slide", "table_id":"{$pvalTable}","toId":"isoman_show_image"{rdelim}' name="isoman_url_image">

											<input type="hidden" value="{$oneItem.image}" name="isoman_url_image" id="image" />
											<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"Slide", "pvalTable":"{$pvalTable}","toField":"image","toId":"isoman_show_image"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="image" isoman_name="isoman_url_image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
											<div class="text_help" hidden="">{$clsConfiguration->getValue($image_why)|html_entity_decode}</div>
										</div>
									</div>
									<div class="col-xs-12 col-md-5">
										<img class="img-responsive radius-3" id="isoman_show_image" src="{$oneItem.image}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('image')}" style="width:100%; height:250px;object-fit: contain"  />
									</div>
								</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Path Url')} <span class="required_red">*</span>
									{assign var= path_url_why value='path_url_why'}
									{if $CHECKHELP eq 1}
									<button data-key="{$path_url_why}" data-label="{$core->get_Lang('Path Url')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="input_text_form input-title required" name="iso-url" value="{$oneItem.url}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($path_url_why)|html_entity_decode}</div>
							</div>
						<div class="btn_save_titile_table_code mt30">
							<a href="{$PCMS}/admin/?mod={$mod}{if $type}&type={$type}{/if}" class="back_step">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save')}</a>
							{if $type eq "BC"}<input type="hidden" name="iso-type" value="{$type}">{/if}
							{if $cat_id > 0}<input type="hidden" name="iso-cat_id" value="{$cat_id}">{/if}
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
</script>
{/literal}