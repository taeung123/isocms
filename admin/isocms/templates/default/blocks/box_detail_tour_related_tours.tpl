<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<h3 class="title_box mb05">{$core->get_Lang('Related Tours')}
				{assign var= related_tour value='related_tour'}
				{if $CHECKHELP eq 1}
				<button data-key="{$related_tour}" data-label="{$core->get_Lang('Related Tours')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
				{/if}
				</h3>
				<p class="intro_box mb40">{$core->get_Lang('infotourextension')}</p>
				<div class="form_option_tour">
					<div class="inpt_tour">
						<div class="filterbox border_0">
							<div class="wrap">
								<div class="searchbox searchbox_new">
									<input id="searchkey" placeholder="{$core->get_Lang('searchtour')}" type="text" class="text" style="width:300px" />
									<div class="autosugget" id="autosugget">
										<ul class="HTML_sugget"></ul>
										<div class="clearfix"></div>
										<a class="close_Div">{$core->get_Lang('close')}</a>
									</div>
								</div>
							</div>
						</div>
						<div class="hastable" style="margin-bottom:10px">
							<table class="tbl-grid full-width table-striped table_responsive" cellspacing="0">
								<thead><tr>
									<th class="gridheader boder_top_none" width="50px"><strong>{$core->get_Lang('index')}</strong></th>
									<th class="gridheader name_responsive text-left boder_top_none"><strong>{$core->get_Lang('nameoftrips')}</strong></th>
									<th class="gridheader text-left hiden_responsive boder_top_none"><strong>{$core->get_Lang('duration')}</strong></th>
									{if $clsConfiguration->getValue('SiteHasCat_Tours')}
									<th class="gridheader text-left hiden_responsive boder_top_none" width="200px">
										<strong>{$core->get_Lang('travelstyles')}</strong></th>
									{/if}
									<th class="gridheader hiden_responsive boder_top_none" width="50px"></th>
								</tr></thead>
								<tbody id="tblTourExtension"></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="btn_save_titile_trip_code">
					<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="1" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">
					<p class="mb0">{$clsConfiguration->getValue($related_tour)|html_entity_decode}</p>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
	$(function(){
		$("#searchkey").on('keyup', function(e) {
			e.preventDefault();
			var $_this = $(this),
				$_val = $_this.val();
			if ($.trim($_val)){
				clearTimeout(aj_search);
				search_tour();
			} else {
				$("#autosugget").stop(false, true).slideUp();
			}
		});
		loadTourExtension(tour_id);
	});
</script>
{/literal}