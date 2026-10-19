<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_service'}
						{$core->getBlock('box_detail_image')}
						{elseif $currentstep=='basic'}
						<h3 class="title_box">{$core->get_Lang('Basic')}</h3>
						
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Title')} <span class="required_red">*</span>
							{assign var= title_service value='title_service'}
							{assign var= help_first value=$title_service}
							{if $CHECKHELP eq 1}
							<button data-key="{$title_service}" data-label="{$core->get_Lang('Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<input class="input_text_form input-title required" data-table_id="{$pvalTable}" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($title_service)|html_entity_decode}</div>
						</div>
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('category')} <span class="required_red">*</span>
								{assign var= category_service value='category_service'}
								{if $CHECKHELP eq 1}
								<button data-key="{$category_service}" data-label="{$core->get_Lang('category')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								</label>
								<div class="fieldarea">
									<select class="glSlBox border_aaa required" name="iso-cat_id" style="width:250px" onClick="loadHelp(this)">
										{$clsServiceCategory->makeSelectboxOption($oneItem.cat_id)}
									</select>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($category_service)|html_entity_decode}</div>
								</div>
							</div>
						{/if}
						{elseif $currentstep=='shortText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Short text')} 
								{assign var= shortText_service value='shortText_service'}
								{assign var= help_first value=$shortText_service}
								{if $CHECKHELP eq 1}
								<button data-key="{$shortText_service}" data-label="{$core->get_Lang('Short text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</h3>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro" class="textarea_intro_editor" data-column="iso-intro" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.intro}</textarea>
							{literal}
							<script>
							$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
							</script>
							{/literal}
						</div>
						{elseif $currentstep=='longText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Long text')} 
								{assign var= longText_service value='longText_service'}
								{assign var= help_first value=$longText_service}
								{if $CHECKHELP eq 1}
								<button data-key="{$longText_service}" data-label="{$core->get_Lang('Long text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</h3>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor" data-column="iso-content" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.content}</textarea>
							{literal}
							<script>
							$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
							</script>
							{/literal}
						</div>							
						
						{elseif $currentstep=='seo'}
						{$core->getBlock('box_detail_seotool_meta-index')}	
						{/if}
						<div class="btn_save_titile_table_code mt30">
							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$arrStep[$step].key}" data-prevstep="{$prevstep}" class="back_step js_save_back">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save &amp; Continue')}</a>
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
<script type="text/javascript">
	var list_check_target = {$list_check_target};
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
	$.each( list_check_target, function( i, val ) {
		if(val.status == 1){
			$('#step_'+val.key).closest('li').removeAttr('class').addClass("check_success");
		}else{
			$('#step_'+val.key).closest('li').removeAttr('class').addClass("check_caution");
		}
	});
</script>
{/literal}