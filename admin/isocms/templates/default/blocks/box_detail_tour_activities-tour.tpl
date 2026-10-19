<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h3 class="title_box mb05">{$core->get_Lang('Activities tour')}
						{assign var= activities_tour value='activities_tour'}
						{if $CHECKHELP eq 1}
						<button data-key="{$activities_tour}" data-label="{$core->get_Lang('Activities tour')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
						</h3>				
						<p class="not_text_tour mb40">{$core->get_Lang('fill overview')}</p>
					</div>
					<div class="admin-toolbar-action">
						<a href="{$PCMS}/admin/?mod=property&act=activities" target="_blank" style="text-decoration: underline">{$core->get_Lang('Change')}</a>
						{*<button class="btn btn-default mr-2 btnCreateTourActivities" tour_id="{$pvalTable}" type="button" title="Thêm">{$clsISO->makeIcon('plus', $core->get_Lang('Add'))}</button>*}
					</div>
				</div>
				<div class="form_option_tour">
					<div class="inpt_tour">
						<div class="accordion_in acc_active">
							<div class="acc_content">
								<table width="100%" class="tbl-grid table-striped" cellpadding="0" cellspacing="0">
									<thead><tr>
										<th class="gridheader"><strong>{$core->get_Lang('ID')}</strong></th>
										<th class="gridheader" style="width:80px"><strong>{$core->get_Lang('Image')}</strong></th>
										<th class="gridheader text-left"><strong>{$core->get_Lang('Name')}</strong></th>
										<th class="gridheader" style="width:70px"><strong>{$core->get_Lang('Tool')}</strong></th>
									</tr></thead>
									{section name=i loop=$lstActivities}
									<tr class="{cycle values="row1,row2"}">
										<td class="index">{$lstActivities[i].activities_id}</td>
										<td class="index"><img src="{if $lstActivities[i].image ne ''}{$clsActivities->getImage($lstActivities[i].activities_id,60,40)}{/if}" width="60" onerror="this.src='{$URL_IMAGES}/none_image.png'" /></td>
										<td>{$clsActivities->getTitle($lstActivities[i].activities_id)}</td>
										<td class="text-center"><input type="checkbox" class="el-checkbox" name="list_activities_id[]"{$lstActivities[i].check} value="{$lstActivities[i].activities_id}" {if $clsISO->checkContainer($oneItem.list_activities_id,$lstActivities[i].activities_id)}checked="checked"{/if} /></td>
									</tr>
									{/section}
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="btn_save_titile_trip_code">
					<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if $child_cat_menu_j_index_prev eq ''}{if $list_cat_menu_prev eq ''}{$child_cat_menu_j}{/if}{if $list_cat_menu_prev ne ''}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if $child_cat_menu_j_index_next eq ''}{if $list_menu_tour_i_index_next.cat_menu eq ''}SaveAll{/if}{if $list_menu_tour_i_index_next.cat_menu ne ''}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">
					<p class="mb0">{$clsConfiguration->getValue($activities_tour)|html_entity_decode}</p>
				</div>
			</div>
		</div>
	</div>
</div>