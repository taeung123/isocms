<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_guideCat'}
						{$core->getBlock('box_detail_image')}
						{elseif $currentstep=='basic'}
							<h3 class="title_box">{$core->get_Lang('generalinformation')}</h3>
							{if $clsConfiguration->getValue('SiteActiveCat_guide') eq 1}
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Category')} <span class="required_red">*</span>
									{assign var= category_guide2 value='category_guide2'}
									{assign var= help_first value=$category_guide2}
									{if $CHECKHELP eq 1}
									<button data-key="{$category_guide2}" data-label="{$core->get_Lang('Category')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="fieldarea">
									<select class="glSlBox border_aaa required" name="iso-cat_id" style="width:250px" onClick="loadHelp(this)">
										{$clsGuideCat->makeSelectboxOption(0,$oneItem.cat_id)}
									</select>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($category_guide2)|html_entity_decode}</div>
								</div>
							</div>
							{/if}
							{if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}	
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Destination')} <span class="required_red">*</span>
									{assign var= destination_guide2 value='destination_guide2'}
									{if $CHECKHELP eq 1}
									<button data-key="{$destination_guide2}" data-label="{$core->get_Lang('Destination')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<div class="fieldarea" onClick="loadHelp(this)">
									<select class="glSlBox border_aaa required" name="iso-country_id" id="slb_Country" style="width:200px">
										{$clsCountry->makeSelectboxOption($oneItem.country_id)}
									</select>
									{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
									<select class="glSlBox border_aaa required" name="iso-region_id" id="slb_Region" style="width:200px">
										{$clsRegion->makeSelectboxOption($country_id,$oneItem.region_id)}
									</select>
									{/if}
									<select class="glSlBox border_aaa required" name="iso-city_id" id="slb_City" style="width:200px">
										{$clsCity->makeSelectboxOption($oneItem.city_id,$oneItem.country_id)}
									</select>
								</div>
								<div class="text_help" hidden="">{$clsConfiguration->getValue($destination_guide2)|html_entity_decode}</div>
							</div>
							{/if}
						{elseif $currentstep=='shortText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Short text')}
								{assign var= shortText_guide2 value='shortText_guide2'}
								{assign var= help_first value=$shortText_guide2}
								{if $CHECKHELP eq 1}
								<button data-key="{$shortText_guide2}" data-label="{$core->get_Lang('Short text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
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
								{assign var= longText_guide2 value='longText_guide2'}
								{assign var= help_first value=$longText_guide2}
								{if $CHECKHELP eq 1}
								<button data-key="{$longText_guide2}" data-label="{$core->get_Lang('Long text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
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
							{$core->getBlock('box_detail_guide2_banner')}		
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