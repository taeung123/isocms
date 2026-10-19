<div class="box_title_trip_code">
	<div class="row d-flex full-height">
			<div class="fill_data_box">
				<h3 class="title_box mb0">{$core->get_Lang('Faq')}</h3>
				<div class="form_option_tour">
					{if $clsConfiguration->getValue('SiteHasItineraryTours')}
					<div class="inpt_tour">
						<div class="hastable">
							<!-- <div class="contingency_table" style="display: none;">
								<p class="title_contingency_table">{$core->get_Lang('Contingency table')}</p> <a style="vertical-align:middle" href="javascript:void(0);" id="clickToAddItinerary_contingency" class="iso-button-primary fl"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Add Contingency')}</a>
								<table class="full-width tbl-grid" cellspacing="0">
									<thead>
										<tr>
											<th class="gridheader" style="width:60px"><strong>ID</strong></th>
											<th class="gridheader name_responsive name_responsive2" style="text-align:left"><strong>{$core->get_Lang('Question')}</strong></th>
											<th class="gridheader hiden_responsive" style="width: 50px"></th>
										</tr>
									</thead>
									<tbody id="tblTourFaq"></tbody>
								</table>
							</div> -->
							<table class="full-width tbl-grid table-striped table_responsive" cellspacing="0">
								<thead>
									<tr>
											<th class="gridheader" style="width:60px"><strong>ID</strong></th>
											<th class="gridheader name_responsive name_responsive2" style="width:100%"><strong>{$core->get_Lang('Title')}</strong></th>
										</tr>
								</thead>
								<tbody id="tblTourFaq"></tbody>
							</table>
						</div>
						<a href="javascript:void(0);" id="clickToAddFaq" class="btn_additinerary" title="{$core->get_Lang('addFaq')}">+ {$core->get_Lang('addFaq')}</a>
					</div>
					{/if}
					<div class="btn_save_titile_trip_code">
						<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if $child_cat_menu[j.index_prev] eq ''}{if $list_menu_tour[i.index_prev].cat_menu eq ''}{$child_cat_menu[j]}{/if}{if $list_menu_tour[i.index_prev].cat_menu ne ''}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu[j.index_prev]}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
						<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="skip" present_step="{$child_cat_menu[j]}" next_step="{if $child_cat_menu[j.index_next] eq ''}{if $list_menu_tour[i.index_next].cat_menu eq ''}SaveAll{/if}{if $list_menu_tour[i.index_next].cat_menu ne ''}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu[j.index_next]}{/if}"  class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
					</div>
				</div>
			</div>
		</div>

</div>

{literal}
<style>
	.frmPop .row-span .fieldarea .titleDay{width: 100%!important;}
</style>
<script>
	loadTourFaq($tour_id);
</script>
{/literal}