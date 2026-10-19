<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_testimonial'}
						{$core->getBlock('box_detail_image')}
						{elseif $currentstep=='generalinformation'}
						<h3 class="title_box">{$core->get_Lang('generalinformation')}</h3>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('title')} <span class="required_red">*</span>
							{assign var= title_testimonial value='title_testimonial'}
							{assign var= help_first value=$title_testimonial}
							{if $CHECKHELP eq 1}
							<button data-key="{$title_testimonial}" data-label="{$core->get_Lang('title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<input class="input_text_form input-title required" data-table_id="{$pvalTable}" name="title" value="{$oneItem.title}" maxlength="255" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($title_testimonial)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('fullname')} <span class="required_red">*</span>
							{assign var= fullname_testimonial value='fullname_testimonial'}
							{if $CHECKHELP eq 1}
							<button data-key="{$fullname_testimonial}" data-label="{$core->get_Lang('fullname')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<input class="text_32 full-width bold border_aaa required title_capitalize" name="iso-name" value="{$oneItem.name}" maxlength="255" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($fullname_testimonial)|html_entity_decode}</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Rate')} <span class="required_red">*</span>
							{assign var= rate_testimonial value='rate_testimonial'}
							{if $CHECKHELP eq 1}
							<button data-key="{$rate_testimonial}" data-label="{$core->get_Lang('Rate')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<div class="fieldarea">
								<select class="glSlBox border_aaa required" name="iso-rates" style="width:250px" onClick="loadHelp(this)">
									{if $_LANG_ID eq 'vn'}
									{$clsISO->makeSelectNumberStart(5,$oneItem.rates,'sao,sao')}
									{else}
									{$clsISO->makeSelectNumberStart(5,$oneItem.rates,'star,stars')}
									{/if}
								</select>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($rate_testimonial)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('international')} <span class="required_red">*</span>
							{assign var= international_testimonial value='international_testimonial'}
							{if $CHECKHELP eq 1}
							<button data-key="{$international_testimonial}" data-label="{$core->get_Lang('international')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<div class="fieldarea">
								<select class="glSlBox border_aaa required" name="iso-country_id" style="width:250px" onClick="loadHelp(this)">
									{section name=i loop=$listCountry}
                                    <option {if $oneItem.country_id eq $listCountry[i].country_id}selected="selected"{/if} value="{$listCountry[i].country_id}">{$clsCountry->getTitle($listCountry[i].country_id)}</option>
                                    {/section}
								</select>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($international_testimonial)|html_entity_decode}</div>
							</div>
						</div>
						<div class="inpt_tour">
							<div onClick="loadHelp(this)">
								<label for="title">{$core->get_Lang('content')}
								{assign var= content_testimonial value='content_testimonial'}
								{if $CHECKHELP eq 1}
								<button data-key="{$content_testimonial}" data-label="{$core->get_Lang('content')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								</label>
								<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro" class="textarea_intro_editor" data-column="iso-intro" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.intro}</textarea>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($content_testimonial)|html_entity_decode}</div>
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