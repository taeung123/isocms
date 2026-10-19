<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_news'}
						{$core->getBlock('box_detail_image_logo_news')}
						{elseif $currentstep=='generalinformation'}
						<h3 class="title_box">{$core->get_Lang('generalinformation')}</h3>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('title')} <span class="required_red">*</span>
							{assign var= title_news value='title_news'}
							{assign var= help_first value=$title_news}
							{if $CHECKHELP eq 1}
							<button data-key="{$title_news}" data-label="{$core->get_Lang('title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<input class="input_text_form input-title required" data-table_id="{$pvalTable}" name="title" value="{$oneItem.title}" maxlength="255" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($title_news)|html_entity_decode}</div>
						</div>
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}						
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('category')} <span class="required_red">*</span>
							{assign var= category_news value='category_news'}
							{if $CHECKHELP eq 1}
							<button data-key="{$category_news}" data-label="{$core->get_Lang('category')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<div class="fieldarea">
								<select class="glSlBox border_aaa required" name="iso-newscat_id" style="width:250px" onClick="loadHelp(this)">
									{$clsNewsCategory->makeSelectboxOption($oneItem.newscat_id)}
								</select>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($category_news)|html_entity_decode}</div>
							</div>
						</div>
						{/if}
						{if $pvalTable gt 0 and $clsISO->getCheckActiveModulePackage($package_id,$mod,'tag','customize')}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Tags')}
							{assign var= tags_news value='tags_news'}
							{if $CHECKHELP eq 1}
							<button data-key="{$tags_news}" data-label="{$core->get_Lang('Tags')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							{$clsTable}
							<input class="text_32 full-width bold border_aaa " id="tags-input" name="list_tag_id" value="{$clsTag->getTagsListText($clsTable,$pvalTable)}" type="text" onClick="loadHelp(this)" placeholder="{$core->get_Lang('Add new tag')}" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($tags_news)|html_entity_decode}</div>
							{literal}
								<script type="text/javascript">
									$('#tags-input').tagsinput({
										allowDuplicates: true,
										confirmKeys: [13, 188]
									});
									$('#tags-input').keypress(function(e){
										var keyCode = e.which || e.keyCode;
										if (keyCode == '13') {
										  e.preventDefault();
										}
									});
								</script>
								<style>
									.bootstrap-tagsinput{width: 100%}
									.bootstrap-tagsinput span{font-size: 14px}
									.bootstrap-tagsinput input{border: 0}
								</style>
							{/literal}
						</div>
						{/if}
						<label for="title">{$core->get_Lang('Publish date')}
							{assign var= publish_date_news value='publish_date_news'}
							{if $CHECKHELP eq 1}
							<button data-key="{$publish_date_news}" data-label="{$core->get_Lang('Publish date')}"
								type="button" title="{$core->get_Lang('Add description')}" onclick="open_texthelp(this, event)"
								class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
						</label>
						</br>
						<input value="{$clsISO->formatTimeMonth($oneItem.publish_date)}" class="ext full showdate "
							name="publish_date" type="text" autocomplete="off" style="width:220px"
							onClick="loadHelp(this),showDatepicker(this)" />
						<div class="text_help" hidden="">
							{$clsConfiguration->getValue($publish_date_blog)|html_entity_decode}</div>
						{literal}
						<script>
							$(".showdate").datepicker({ dateFormat: "dd/mm/yy" });
						</script>
						{/literal}
						{elseif $currentstep=='shortText'}						
							<div class="inpt_tour">
								<div onClick="loadHelp(this)">
									<label for="title">{$core->get_Lang('Short text')} <span class="required_red">*</span>
									{assign var= intro_news value='intro_news'}
									{if $CHECKHELP eq 1}
									<button data-key="{$intro_news}" data-label="{$core->get_Lang('Short text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
									</label>
									<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro" class="textarea_intro_editor" data-column="iso-intro" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.intro}</textarea>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($intro_news)|html_entity_decode}</div>
								</div>
							</div>
						{elseif $currentstep=='longText'}						
							<div class="inpt_tour">
								<div onClick="loadHelp(this)">
									<label for="title">{$core->get_Lang('Long text')} <span class="required_red">*</span>
									{assign var= content_news value='content_news'}
									{if $CHECKHELP eq 1}
									<button data-key="{$content_news}" data-label="{$core->get_Lang('Long text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
									</label>
									<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor" data-column="iso-content" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.content}</textarea>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($content_news)|html_entity_decode}</div>
								</div>
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
					<div class="content_box">{$clsConfiguration->getValue($help_first|default:'')|html_entity_decode}</div>
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