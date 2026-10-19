<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
							{assign var= image_detail value='image_ads'}
							{$core->getBlock('box_detail_image')}
						{elseif $currentstep=='ads'}
							<h3 class="title_box">{$core->get_Lang('Ads')}</h3>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('nameofads')} <span class="required_red">*</span>
									{assign var= title_ads value='title_ads'}
									{assign var= help_first value=$title_ads}
									{if $CHECKHELP eq 1}
									<button data-key="{$title_ads}" data-label="{$core->get_Lang('nameofads')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="input_text_form input-title required" data-table_id="{$pvalTable}" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" onClick="loadHelp(this)" >
								<div class="text_help" hidden="">{$clsConfiguration->getValue($title_ads)|html_entity_decode}</div>
							</div>
							<div class="inpt_tour">
								<label for="title">{$core->get_Lang('link')}
									{assign var= link_ads value='link_ads'}
									{if $CHECKHELP eq 1}
									<button data-key="{$link_ads}" data-label="{$core->get_Lang('link')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
									{/if}
								</label>
								<input class="text full url" value="{$clsClassTable->getLink($pvalTable)}" name="iso-url" maxlength="255" type="text"  onClick="loadHelp(this)"  />
								<div class="text_help" hidden="">{$clsConfiguration->getValue($link_ads)|html_entity_decode}</div>
							</div>	
							<div class="inpt_tour">
								{if $clsConfiguration->getValue('SiteHasGroup_Ads') eq 1}
									<div class="clearfix"><br /></div>
									<fieldset style="background:#f9f9f9">
										<legend>{$core->get_Lang('Display ads on the page')}</legend>
										<p class="font12px">{$core->get_Lang('Tick selected in the page types like to display ads')}.</p>
										<ul style="list-style:none;">
											{section name=i loop=$lstAdsGroup}
											<li style="padding:3px 0px;"><label><input disabled="disabled" name="lstGroup[]" type="checkbox" value="{$lstAdsGroup[k].ads_group_id}" /> {$clsAdsGroup->getTitle($lstAdsGroup[i].ads_group_id)}</label></li>
											<!-- Start child -->
											{assign var = lstAdsGroup2 value = $clsAdsGroup->getChild($lstAdsGroup[i].ads_group_id)}
											{if $lstAdsGroup2[0].ads_group_id ne ''}
											{section name=k loop=$lstAdsGroup2}
											<li style="padding:3px 0px;">--------- <label><input {if $clsAdsGroup->checkAds($lstAdsGroup2[k].ads_group_id,$pvalTable)}checked="checked"{/if} name="lstGroup[]" type="checkbox" value="{$lstAdsGroup2[k].ads_group_id}" /> {$clsAdsGroup->getTitle($lstAdsGroup2[k].ads_group_id)}</label></li>
											{/section}
											{/if}
											{/section}
										</ul>
									</fieldset>
								{/if}
							</div>			
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
<script>
	var ads_id = $ads_id = '{$oneItem.ads_id}';
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