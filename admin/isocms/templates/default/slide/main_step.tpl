<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code" {$currentstep}>
						<h3 class="title_box">{$core->get_Lang('slide HomePage')}</h3>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Slide Title')}
									{assign var= title_slide value='title_slide'}
									{assign var= help_first value=$title_slide}
									{if $CHECKHELP eq 1}
									<button data-key="{$title_slide}" data-label="{$core->get_Lang('Slide Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="input_text_form input-title" data-table_id="{$pvalTable}" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($title_slide)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Slide Link')}
									{assign var= link_slide value='link_slide'}
									{if $CHECKHELP eq 1}
									<button data-key="{$link_slide}" data-label="{$core->get_Lang('Slide Link')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="text_32 full-width border_aaa bold required" name="iso-link" value="{$clsClassTable->getLink($pvalTable)}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($link_slide)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<label class="col-form-label" for="title">{$core->get_Lang('Banner')} <span class="required_red">*</span>
									{assign var= banner_slide value='banner_slide'}
									{if $CHECKHELP eq 1}
									<button data-key="{$banner_slide}" data-label="{$core->get_Lang('Banner')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="row">
									<div class="col-xs-12 col-md-4">
										<div class="drop_gallery" onClick="loadHelp(this)">
											<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image" data-options='{ldelim}"openFrom":"image","clsTable":"Slide", "table_id":"{$pvalTable}","toId":"isoman_show_image" {rdelim}' ondragover="return false">
												<h3>{$core->get_Lang('Drop files to upload')}</h3>
												<p>Kích thước (WxH=1920x640)<br />
												Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
												<button type="button" class="btn btn-upload">{if $oneItem.image}Thay ảnh{else}Tải ảnh lên{/if}</button>
											</div>
											<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"image","clsTable":"Slide", "table_id":"{$pvalTable}","toId":"isoman_show_image"{rdelim}' name="image">

											<input type="hidden" value="{$oneItem.image}" name="image" id="image" />
											<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"Slide", "pvalTable":"{$pvalTable}","toField":"image","toId":"isoman_show_image"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="image" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
											<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_slide)|html_entity_decode}</div>
										</div>
									</div>
									<div class="col-xs-12 col-md-8">
										<img class="img-responsive radius-3" id="isoman_show_image" src="{$oneItem.image}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('image')}" style="width:100%; height:250px;object-fit: contain"  />
									</div>
								</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Banner Content')} <span class="required_red">*</span>
									{assign var= bannerContent_slide value='bannerContent_slide'}
									{if $CHECKHELP eq 1}
									<button data-key="{$bannerContent_slide}" data-label="{$core->get_Lang('Slide Link')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								 <textarea name="iso-text" id="" cols="30" rows="10" style="width:100%"  onClick="loadHelp(this)">{$oneItem.text}</textarea>
								 <div class="text_help" hidden="">{$clsConfiguration->getValue($bannerContent_slide)|html_entity_decode}</div>
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