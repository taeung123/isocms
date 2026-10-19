<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_category_country'}
						{$clsISO->getBlock('box_detail_image',["image_detail"=>"image_category_country"])}
						{elseif $currentstep=='generalinformation'}
							<h3 class="title_box">{$core->get_Lang('generalinformation')}</h3>
							{if $clsConfiguration->getValue('SiteHasCat_Tours') eq 1}
								<div class="inpt_tour">
									<label for="title">{$core->get_Lang('Travel Styles')} <span class="required_red">*</span>
									{assign var= travel_styles_category_country value='travel_styles_category_country'}
									{assign var= help_first value=$travel_styles_category_country}
									{if $CHECKHELP|default:0 eq 1}
									<button data-key="{$travel_styles_category_country}" data-label="{$core->get_Lang('Travel Styles')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
									</label>
									<div class="fieldarea">
										<select name="cat_id" class="glSlBox required">
											 {$clsTourCategory->makeSelectboxOptionCountry($country_id,$oneItem.cat_id)}
										</select>
										<div class="text_help" hidden="">{$clsConfiguration->getValue($travel_styles_category_country)|html_entity_decode}</div>
									</div>
								</div>
							{/if}
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Destination')} <span class="required_red">*</span>
								{assign var= destination_category_country value='destination_category_country'}
								{assign var= help_first value=$destination_category_country}
								{if $CHECKHELP|default:0 eq 1}
								<button data-key="{$destination_category_country}" data-label="{$core->get_Lang('Travel Styles')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								</label>
								<div class="fieldarea">
									<select class="slb full glSlBox required" name="iso-country_id" id="slb_Country">
										{$clsCountry->makeSelectboxOption($oneItem.country_id)}
									</select>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($destination_category_country)|html_entity_decode}</div>
								</div>
							</div>
						{elseif $currentstep=='longText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Long text')}
								{assign var= longText_category_country value='longText_category_country'}
								{assign var= help_first value=$longText_category_country}
								{if $CHECKHELP|default:0 eq 1}
								<button data-key="{$longText_category_country}" data-label="{$core->get_Lang('Long text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</h3>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor" data-column="iso-content" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.content}</textarea>
							{literal}
							<script>
							$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
							</script>
							{/literal}
						</div>
						{elseif $currentstep=='banner'}
							{$core->getBlock('box_detail_category_country_banner')}
						{/if}
						<div class="btn_save_titile_table_code mt30">
							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$arrStep[$step].key}" data-prevstep="{$prevstep}" class="back_step js_save_back_main_step">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue_main_step">{$core->get_Lang('Save &amp; Continue')}</a>
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