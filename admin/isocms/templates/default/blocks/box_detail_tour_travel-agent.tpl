{*
<div class="box_title_trip_code">
    <div class="row d-flex full-height">
        <div class="col-md-9">
            <div class="fill_data_box">
                <div class="row-span">
                    <div class="form-group inpt_tour">
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <div class="drop_gallery" onClick="loadHelp(this)">
                                    <div class="filedrop full" onClick="file_explorer(this,event);"
                                         ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image_agent"
                                         data-options='{ldelim}"openFrom":"image_agent","clsTable":"Tour", "table_id":"{$pvalTable}","toId":"isoman_show_image_agent" {rdelim}'
                                         ondragover="return false">
                                        <h3>{$core->get_Lang('Drop files to upload')}</h3>
                                        <p>Kích thước (WxH=840x480)<br/>
                                            Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
                                        <button type="button"
                                                class="btn btn-upload">{if $oneItem.image_agent}Thay ảnh{else}Tải ảnh lên{/if}</button>
                                    </div>
                                    <input class="hidden" id="selectFile" type="file"
                                           data-options='{ldelim}"openFrom":"image_agent","clsTable":"Tour", "table_id":"{$pvalTable}","toId":"isoman_show_image_agent"{rdelim}'
                                           name="image_agent">

                                    <input type="hidden" value="{$oneItem.image_agent}" name="image_agent" id="image_agent"/>
                                    <a table_id="{$pvalTable}" isoman_multiple="0"
                                       isoman_callback='isoman_callback({ldelim}"openFrom":"image_agent", "clsTable":"Tour", "pvalTable":"{$pvalTable}","toField":"image_agent","toId":"isoman_show_image_agent"{rdelim})'
                                       class="btn-upload-2 ajOpenDialog" isoman_for_id="image_agent"
                                       isoman_name="image_agent">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-5">
                                <img class="img-responsive radius-3" id="isoman_show_image_agent" src="{$oneItem.image_agent}"
                                     onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('images')}"
                                     style="width:450px; height:285px"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel bold"><strong>{$core->get_Lang('Trip code')}</strong> <span class="color_r">* </span></div>
                    <div class="fieldarea">
                        <input class="text_32 full-width border_aaa bold required fontLarge" style="padding:5px" name="trip_code_agent" value="{$oneItem.trip_code_agent}" maxlength="255" type="text">
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel bold"><strong>{$core->get_Lang('Country')}</strong> </div>
                    <div class="fieldarea">
                        <select id="country_id" class="slb_Country_Id glSlBox border_aaa" id="country_id" name="country_id" style="width:250px" onClick="loadHelp(this)">
                            {$clsCountryEx->makeSelectboxOption($oneItem.country_id)}
                        </select>
                    </div>
                </div>
                <div class="row-span" id="box_market">
                    <div class="fieldlabel bold"><strong>{$core->get_Lang('Market')}</strong> </div>
                    <div class="fieldarea">
                        <select id="slb_marketID" class="slb_Country_Id glSlBox border_aaa" name="market_id" style="width:250px" onClick="loadHelp(this)">
                            <option value="0">-- {$core->get_Lang('Choose market')} --</option>
                        </select>
                    </div>
                </div>
                <div class="row-span" id="box_type_market">
                    <div class="fieldlabel bold"><strong>{$core->get_Lang('Type market')}</strong> </div>
                    <div class="fieldarea">
                        <select id="slb_marketTypeID" class="slb_Country_Id glSlBox border_aaa" name="market_type_id" style="width:250px" onClick="loadHelp(this)">
                            <option value="0">-- {$core->get_Lang('Choose market type')} --</option>
                        </select>
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel bold"><strong>{$core->get_Lang('Price')}</strong> </div>
                    <div class="fieldarea">
                        <input class="text_32 border_aaa bold required fontLarge" style="padding:5px" name="trip_price" value="{$oneItem.trip_price}" maxlength="255" type="text">
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel bold"><strong>{$core->get_Lang('Price old')}</strong> </div>
                    <div class="fieldarea">
                        <input class="text_32 border_aaa bold required fontLarge" style="padding:5px" name="trip_price_old" value="{$oneItem.trip_price_old}" maxlength="255" type="text">
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel bold"><strong>{$core->get_Lang('Attachment file')}</strong></div>
                    <div class="fieldarea">
                        <input class="text_32 border_aaa fl span60" type="text" id="isoman_url_image_Fx" name="attachment_file" value="{$oneItem.attachment_file}"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_Fx" isoman_val="{$oneItem.attachment_file}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                    </div>
                </div>
                <div class="row-span">
                    <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> </div>
                    <div class="fieldarea">
                        <div class="checkbox-switch switch_public">
                            {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
                                <input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
                            {else}
                                <input type="checkbox" value="1" name="is_online_agent" class="input-checkbox" id="toolbar-active">
                            {/if}
                            <div class="checkbox-animate">
                                <span class="checkbox-off">PRIVATE</span>
                                <span class="checkbox-on">PUBLIC</span>
                            </div>
                        </div>
                        <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online_agent",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
                        <span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online_agent",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
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
                <div class="content_box">{$clsConfiguration->getValue($title_tour)|html_entity_decode}</div>
            </div>
        </div>
    </div>
</div>
<script>
    var $country_id = "{$oneItem.country_id}";
    var $market_id = "{$oneItem.market_id}";
    var $market_type_id = "{$oneItem.market_type_id}";
</script>
{literal}
    <script>
        $(document).ready(function(){
            loadMarket($country_id,$market_id);
            loadTypeMarket($market_id,$market_type_id);
            $("#country_id").change(function(){
                var $country_id = $(this).val();
                loadMarket($country_id);
            });
            $("#slb_marketID").change(function(){
                var $market_id = $(this).val();
                loadTypeMarket($market_id);
            });
        });
        function loadMarket($country_id,$market_id=0) {
            $('#slb_marketID').html('<option value="0">' + loading + '</option>');
            $('#slb_marketTypeID').html('<option value="0">' + loading + '</option>');
            vietiso_loading(1);

            if($country_id > 0){
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=download&act=ajmakeSelectMarket",
                    data: {
                        "country_id": $country_id,
                        "market_id": $market_id,
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        if (html.indexOf('EMPTY') >= 0) {
                            $('#box_market,#box_type_market').hide();
                        } else {
                            $('#box_market').show();
                            $('#slb_marketID').html(html);
                        }
                    }
                });
            }else{
                $('#box_market,#box_type_market').hide();
                vietiso_loading(0);
            }

        }
        function loadTypeMarket($market_id,$market_type_id=0) {
            $('#slb_marketTypeID').html('<option value="0">' + loading + '</option>');
            vietiso_loading(1);
            if($market_id > 0){
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=download&act=ajmakeSelectTypeMarket",
                    data: {
                        "market_id": $market_id,
                        "market_type_id": $market_type_id,
                    },
                    dataType: "html",
                    success: function(html) {
                        vietiso_loading(0);
                        if (html.indexOf('EMPTY') >= 0) {
                            $('#box_type_market').hide();
                        } else {
                            $('#box_type_market').show();
                            $('#slb_marketTypeID').html(html);
                        }
                    }
                });
            }else{
                $('#box_type_market').hide();
                vietiso_loading(0);
            }
        }
    </script>
{/literal}*}
