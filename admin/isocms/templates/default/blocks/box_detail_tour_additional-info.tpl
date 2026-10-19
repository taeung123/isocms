<div class="box_title_trip_code">
    <div class="row d-flex full-height">
        <div class="col-md-9">
            <div class="fill_data_box">
                <h3 class="title_box mb05">{$core->get_Lang('Additional Info')}
                </h3>
                <p class="intro_box mb40">{$core->get_Lang('introadditionalinfotour')}</p>
                <div class="form_option_tour">
                    <div class="inpt_tour p-b-30">
                        {if $oneItem.yield_id}
                            {$oneItem.additional_info|html_entity_decode}
                        {else}
                            <textarea style="width:100%" class="isoTextArea" id="{$clsISO->getUniqid()}" data-name="additional_info" cols="255" rows="2">{$oneItem.additional_info}</textarea>
                        {/if}
                    </div>
                </div>
                <div class="btn_save_titile_trip_code">
                    <a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if $child_cat_menu_j_index_prev eq ''}{if $list_cat_menu_prev eq ''}{$child_cat_menu_j}{/if}{if $list_cat_menu_prev ne ''}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
                    <a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
                </div>
            </div>
        </div>
    </div>
</div>