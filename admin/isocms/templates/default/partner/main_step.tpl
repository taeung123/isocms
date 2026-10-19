<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code" {$currentstep}>
						<h3 class="title_box">{$core->get_Lang('Partner')} &raquo; <span class="color_r">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</h3>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Title')} <span class="required_red">*</span>
									{assign var= title_partner value='title_partner'}
									{assign var= help_first value=$title_partner}
									{if $CHECKHELP eq 1}
									<button data-key="{$title_partner}" data-label="{$core->get_Lang('Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="input_text_form input-title required" data-table_id="{$pvalTable}" name="title" value="{$oneItem.title}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($title_partner)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<label class="col-form-label" for="title">{$core->get_Lang('Image')} <span class="required_red">*</span>
									{assign var= image_partner value='image_partner'}
									{if $CHECKHELP eq 1}
									<button data-key="{$image_partner}" data-label="{$core->get_Lang('Image')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="row">
									<div class="col-xs-12 col-md-5">
										<div class="drop_gallery" onClick="loadHelp(this)">
											<div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image" data-options='{ldelim}"openFrom":"image","clsTable":"Partner", "table_id":"{$pvalTable}","toId":"isoman_show_image","type":"{$type}" {rdelim}' ondragover="return false">
												<h3>{$core->get_Lang('Drop files to upload')}</h3>
                                                {if $type=='BC'}
                                                <p>{$core->get_Lang('Image size')} (WxH=111x65px)<br />
                                                {else}
                                                <p>{$core->get_Lang('Image size')} (WxH=115x92px)<br />
                                                {/if}
												<p>Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
												<button type="button" class="btn btn-upload">{if $oneItem.image}Thay ảnh{else}Tải ảnh lên{/if}</button>
											</div>
											<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"image","clsTable":"Partner", "table_id":"{$pvalTable}","toId":"isoman_show_image","type":"{$type}"{rdelim}' name="isoman_url_image">

											<input type="hidden" value="{$oneItem.image}" name="isoman_url_image" id="image" />
											<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"Partner", "pvalTable":"{$pvalTable}","toField":"image","toId":"isoman_show_image","type":"{$type}"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="image" isoman_name="isoman_url_image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
											<div class="text_help" hidden="">{$clsConfiguration->getValue($image_partner)|html_entity_decode}</div>
										</div>
									</div>
									<div class="col-xs-12 col-md-5">
										<img class="img-responsive radius-3" id="isoman_show_image" src="{$oneItem.image}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('image')}" style="width:100%; height:250px;object-fit: contain"  />
									</div>
								</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Path Url')} 
									{assign var= path_url_partner value='path_url_partner'}
									{if $CHECKHELP eq 1}
									<button data-key="{$path_url_partner}" data-label="{$core->get_Lang('Path Url')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="input_text_form input-title " name="iso-url" value="{$oneItem.url}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($path_url_partner)|html_entity_decode}</div>
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