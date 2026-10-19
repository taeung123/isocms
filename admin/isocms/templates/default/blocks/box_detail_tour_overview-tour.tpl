<div class="box_title_trip_code">
    <div class="row d-flex full-height">
        <div class="col-md-9">
            <div class="fill_data_box">
                <h3 class="title_box mb05">{$core->get_Lang('Overview tour')}
                    {assign var= overview_tour value='overview_tour'}
                    {if $CHECKHELP|default:'' eq 1}
                        <button data-key="{$overview_tour}" data-label="{$core->get_Lang('Overview tour')}"
                                type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                    {/if}
                </h3>
                <p class="intro_box mb40">{$core->get_Lang('introoverviewtour')}</p>
                <div class="form_option_tour">
                    <div class="inpt_tour">
                        {if $oneItem.yield_id}
                            {$oneItem.overview|html_entity_decode}
                        {else}
                            <textarea style="width:100%" class="isoTextArea" id="tour_{$pvalTable}_{time()}"
                                      data-name="overview" cols="255" rows="2">{$oneItem.overview}</textarea>
                            <br>
                            {*<h3>{$core->get_Lang('Translate test')}</h3>
                            <form action="" method="post">
                                <input type="hidden" value="hnv_translate" name="hnv_translate">
                                <label for="target">Chọn ngôn ngữ đích:</label>
                                <select name="target" id="target">
                                    {foreach $languages as $code => $name}
                                        {if $code neq 'auto'}
                                            <option value="{$code}">{$name}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                                <button type="submit">{$core->get_Lang('Translate button')}</button>
                                <textarea style="width:100%" class="isoTextArea" id="ttour_{$pvalTable}_{time()}" name="overview" data-name="overview" cols="255" rows="2">{$finalHtml}</textarea>
                            </form>*}
                        {/if}
                    </div>
                    <div class="btn_save_titile_trip_code">
                        <a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					    <a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="instruction_fill_data_box">
                <p class="title_box"><i class="fa fa-question-circle text-red "
                                        aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
                <div class="content_box">
                    <p class="mb0">{$clsConfiguration->getValue($overview_tour)|html_entity_decode}</p>
                </div>
            </div>
        </div>
    </div>
</div>