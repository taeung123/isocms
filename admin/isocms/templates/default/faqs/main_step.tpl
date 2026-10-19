<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code" {$currentstep}>
						<h3 class="title_box">{$core->get_Lang('FAQs')}</h3>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('question')} <span class="required_red">*</span>
									{assign var= title_faq value='title_faq'}
									{assign var= help_first value=$title_faq}
									{if $CHECKHELP eq 1}
									<button data-key="{$title_faq}" data-label="{$core->get_Lang('question')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="text_32 full-width border_aaa bold required" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($title_faq)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<div onClick="loadHelp(this)">
									<label for="title">{$core->get_Lang('Answers')} <span class="required_red">*</span>
										{assign var= answers_faq value='answers_faq'}
										{if $CHECKHELP eq 1}
										<button data-key="{$answers_faq}" data-label="{$core->get_Lang('Answers')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
										{/if}
									</label>
									<textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor" data-column="iso-content" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.content}</textarea>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($answers_faq)|html_entity_decode}</div>
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