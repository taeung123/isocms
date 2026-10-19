<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<h3 class="title_box mb05">{$core->get_Lang('Price Config')}
				{assign var= price_config_tour value='price_config_tour'}
				{if $CHECKHELP eq 1}
				<button data-key="{$price_config_tour}" data-label="{$core->get_Lang('Price Config')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
				{/if}
				</h3>
				<p class="intro_box mb40">{$core->get_Lang('Price_Config_Notes')}</p>
				<div class="form_option_tour mb40">
					<div class="form-group mb40">
						<label class="col-form-label text-bold">{$core->get_Lang('Class')} <span class="text-red">*</span></label>
						<div class="admin-toolbar-action mt-0">
							<a class="text-link" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=TOUROPTION"> {$core->get_Lang('Manage')}</a>
						</div>
						<div id="slb_ContainerTourOption">
							<select name="tour_option[]" id="tour_option" class="required chosen-select required" multiple="multiple">
								{assign var = selected value = $oneItem.tour_option}
								{$clsTourOption->makeSelectboxOption2($selected,'TOUROPTION',0)}
								{$selected}
							</select>
						</div>
					</div>
					<hr />
					<label class="col-form-label fs-20"><strong>{$core->get_Lang('Group size')}</strong></label>
					<div class="form-group ">
						<label class="col-form-label"><strong>{$core->get_Lang('Adult')}</strong></label>
						<div class="admin-toolbar-action mt-0">
							<a class="text-link" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP"> {$core->get_Lang('Manage')}</a>
						</div>
						<div id="slb_ContainerAdultSizeGroup">
							<select name="adult_size_group[]" id="adult_size_group" class="chosen-select" multiple="multiple">
								{assign var = selected value = $oneItem.adult_group_size}
								{$clsTourOption->makeSelectboxOption2($selected,'SIZEGROUP',$adult_type_id)}
								{$selected}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-form-label"><strong>{$core->get_Lang('Children')}</strong> ({$core->get_Lang('by age')})</label>
						<div class="admin-toolbar-action mt-0">
							<a class="text-link" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP"> {$core->get_Lang('Manage')}</a>
						</div>
						<div id="slb_ContainerChildSizeGroup">
							<select name="child_size_group[]" id="child_size_group" class="chosen-select" multiple="multiple">
								{assign var = selected value = $oneItem.child_group_size}
								{$clsTourOption->makeSelectboxOption2($selected,'SIZEGROUP',$child_type_id)}
								{$selected}
							</select>
						</div>
					</div>
					<div class="form-group ">
						<label class="col-form-label"><strong>{$core->get_Lang('Infant')}</strong> ({$core->get_Lang('by age')})</label>
						<div class="admin-toolbar-action mt-0">
							<a class="text-link" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP"> {$core->get_Lang('Manage')}</a>
						</div>
						<div id="slb_ContainerChildSizeGroup">
							<select name="infant_size_group[]" id="infant_size_group" class="chosen-select" multiple="multiple">
								{assign var = selected value = $oneItem.infant_group_size}
								{$clsTourOption->makeSelectboxOption2($selected,'SIZEGROUP',$infant_type_id)}
								{$selected}
							</select>
						</div>
					</div>
				</div>
				<div class="btn_save_titile_trip_code">
					<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if $child_cat_menu[j.index_prev] eq ''}{if $list_menu_tour[i.index_prev].cat_menu eq ''}{$child_cat_menu[j]}{/if}{if $list_menu_tour[i.index_prev].cat_menu ne ''}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu[j.index_prev]}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu[j]}" next_step="{if $child_cat_menu[j.index_next] eq ''}{if $list_menu_tour[i.index_next].cat_menu eq ''}SaveAll{/if}{if $list_menu_tour[i.index_next].cat_menu ne ''}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu[j.index_next]}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">
					<p class="mb0">{$clsConfiguration->getValue($price_config_tour)|html_entity_decode}</p>
				</div>
			</div>
		</div>
	</div>
</div>