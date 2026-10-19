<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<h3 class="title_box mb05">{$core->get_Lang('What carry tour')}
				{assign var= carry_tour value='carry_tour'}
				{if $CHECKHELP|default:'' eq 1}
				<button data-key="{$carry_tour}" data-label="{$core->get_Lang('What carry tour')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
				{/if}
				</h3>
				<p class="intro_box mb40">{$core->get_Lang('introwhatcarrytour')}</p>
				<div class="form_option_tour">
					<div class="inpt_tour">
						{*<label for="title">{$core->get_Lang('Image represent tour')} <span class="required_red">*</span></label>*}
						<p class="not_text_tour">{$core->get_Lang('fill What carry')}</p>
						{if $oneItem.yield_id}
							{$oneItem.thing_to_carry|html_entity_decode}
						{else}
							<textarea style="width:100%" class="isoTextArea" id="{$clsISO->getUniqid()}" data-name="thing_to_carry" cols="255" rows="3">{$oneItem.thing_to_carry}</textarea>
						{/if}
					</div>
				</div>
				<div class="btn_save_titile_trip_code">
					<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">
					<p class="mb0">{$clsConfiguration->getValue($carry_tour)|html_entity_decode}</p>
				</div>
			</div>
		</div>
	</div>
</div>