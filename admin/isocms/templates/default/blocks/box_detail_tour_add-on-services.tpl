{if $clsConfiguration->getValue('SiteHasService_Tours')}
<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h3 class="title_box mb05">{$core->get_Lang('Add On Services')}
						{assign var= add_on_services_tour value='add_on_services_tour'}
						{if $CHECKHELP|default:'' eq 1}
						<button data-key="{$add_on_services_tour}" data-label="{$core->get_Lang('Add On Services')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
						</h3>
						<p class="intro_box mb40">{$core->get_Lang('introaddonservice')}</p>
					</div>
					<div class="admin-toolbar-action">
						<a href="{$PCMS_URL}/?mod=property&act=service" target="_blank" style="text-decoration: underline">{$core->get_Lang('Change')}</a>
					</div>
				</div>
				
				<div class="form_option_tour">
					<div class="inpt_tour">
						<table width="100%" class="tbl-grid table-striped" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th class="gridheader" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
									<th class="gridheader text-left"><strong>{$core->get_Lang('nameofservice')}</strong></th>
									<th class="gridheader text-right" style="width:120px"><strong>{$core->get_Lang('Price')}</strong></th>
									<th class="gridheader" style="width:80px"><strong>{$core->get_Lang('Choose')}</strong></th>
								</tr>
							</thead>
							<tbody>
								{section name=i loop=$lstAddOnService}
								<tr class="{cycle values="row1,row2"}">
									<td class="index">{$lstAddOnService[i].addonservice_id}</td>
									<td class="text-left">{$clsAddOnService->getTitle($lstAddOnService[i].addonservice_id)}</td>
									<td class="text-right">
										<strong class="format_price">
											{$clsAddOnService->getPrice($lstAddOnService[i].addonservice_id)} {$clsISO->getRate()}
										</strong>
									</td>
									<td class="text-center">
										<input type="checkbox" class="el-checkbox" name="list_service_id[]" {$lstAddOnService[i].check|default:''} value="{$lstAddOnService[i].addonservice_id}" {if $clsISO->checkContainer($oneItem.list_service_id,$lstAddOnService[i].addonservice_id)}checked="checked"{/if} />
									</td>
								</tr>
								{/section}
							</tbody>
						</table>
					</div>
				</div>
				<div class="btn_save_titile_trip_code">
					<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">
					<p class="mb0">{$clsConfiguration->getValue($add_on_services_tour)|html_entity_decode}</p>
				</div>
			</div>
		</div>
	</div>
</div>
{/if}