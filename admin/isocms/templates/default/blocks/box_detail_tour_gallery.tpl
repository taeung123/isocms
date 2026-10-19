{if $clsConfiguration->getValue('SiteHasGalleryImagesTours')}
    <div class="box_title_trip_code">
        <h2 class="title_box p-b-30">{$core->get_Lang('Gallery')}</h2>
        <div class="form_option_tour">

            <div class="inpt_tour p-b-30">
                {*<label for="title">{$core->get_Lang('Image represent tour')} <span class="required_red">*</span></label>*}
                {*<p class="not_text_tour">{$core->get_Lang('infotourextension')}</p>*}
                <div id="TourGalleryHolder"></div>

                {literal}
                    <script type="text/javascript">
                        $().ready(function() {
                            initSysGalleryTour();
                        });
                    </script>
                {/literal}

            </div>
            <div class="btn_save_titile_trip_code">
                <a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if $child_cat_menu_j_index_prev eq ''}{if $list_cat_menu_prev eq ''}{$child_cat_menu_j}{/if}{if $list_cat_menu_prev ne ''}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
				<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if $child_cat_menu_j_index_next eq ''}{if $list_menu_tour_i_index_next.cat_menu eq ''}SaveAll{/if}{if $list_menu_tour_i_index_next.cat_menu ne ''}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
            </div>
        </div>
    </div>
{/if}