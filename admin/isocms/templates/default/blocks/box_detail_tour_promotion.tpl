{if _IS_PROMOTION eq 1}
    <div class="box_title_trip_code">
        <h2 class="title_box p-b-30">{$core->get_Lang('Promotion')}</h2>
        <div class="form_option_tour">

            <div class="inpt_tour p-b-30">
                {*<label for="title">{$core->get_Lang('Image represent tour')} <span class="required_red">*</span></label>*}
                {*<p class="not_text_tour">{$core->get_Lang('infotourextension')}</p>*}
                <div class="wrap" style="margin-bottom:30px">
                    <div class="fl span100">
                        <div class="tabs_content" id="lstTabs">
                            <div class="contentTab">
                                {*<a style="vertical-align:middle" href="javascript:void(0);" id="clickAddPromotion" clsTable="Tour" type="Tour" target_id="{$pvalTable}" class="iso-button-primary fl mb10"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Add New')}</a>*}
                                <a style="vertical-align:middle" href="javascript:void(0);" id="clickInsertPromotionGroup" clsTable="Tour" type="Tour" target_id="{$pvalTable}" class="iso-button-primary fl mb10 clickInsertPromotionGroup"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Join in Promotion Pro')}</a>
                                <a style="vertical-align:middle;background-color: #91ccff !important;padding: 0 10px;" href="javascript:void(0);" id="clickInsertPromotion" clsTable="Tour" type="Tour" target_id="{$pvalTable}" class="iso-button-primary fl mb10 clickInsertPromotion"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Add New Promotion Pro')}</a>
                                {*<div id="ListPromotion" style="border:2px dashed red; padding:15px 10px; float:left; width:100%"></div>*}
                                <div id="ListPromotionPro" style="border:2px dashed red; padding:15px 10px; float:left; width:100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {literal}
                    <script type="text/javascript">
                        $(document).ready(function(){
                            // loadPromotion($tour_id,'Tour');
                            loadPromotionPro($tour_id,'Tour');
                        });
                    </script>
                {/literal}
            </div>
            <div class="btn_save_titile_trip_code">
                <a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
                <a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
            </div>
        </div>
    </div>
{/if}