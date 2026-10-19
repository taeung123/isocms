<div class="box_title_trip_code">
    <div class="row d-flex full-height">
        <div class="col-md-9">
            <div class="fill_data_box">
                <h3 class="title_box">{$core->get_Lang('Image, file tour')}</h3>
                {assign var = SiteHasProgramFile_Tours value = $clsConfiguration->getValue('SiteHasProgramFile_Tours')}
                <div class="form-group inpt_tour">
                    <label class="col-form-label" for="title">{$core->get_Lang('Image represent tour')} <span
                                class="required_red">*</span>
                        {assign var= image_tour value='image_tour'}
                        {if $CHECKHELP|default:'' eq 1}
                            <button data-key="{$image_tour}" data-label="{$core->get_Lang('Image represent tour')}"
                                    type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                    class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                        {/if}
                    </label>
                    <div class="row">
                        <div class="col-xs-12 col-md-5">
                            <div class="drop_gallery" onClick="loadHelp(this)">
                                <div class="filedrop full" onClick="file_explorer(this,event);"
                                     ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image"
                                     data-options='{ldelim}"openFrom":"image","clsTable":"Tour", "table_id":"{$pvalTable}","toId":"isoman_show_image" {rdelim}'
                                     ondragover="return false">
                                    <h3>{$core->get_Lang('Drop files to upload')}</h3>
                                    <p>{$core->get_Lang('Kích thước (WxH=840x480)')}<br/>
                                        {$core->get_Lang('Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg')}</p>
                                    <button type="button"
                                            class="btn btn-upload">{if $oneItem.image}{$core->get_Lang('Thay ảnh')}{else}{$core->get_Lang('Tải ảnh lên')}{/if}</button>
                                </div>
                                <input class="hidden" 
                                        id="selectFile" 
                                        type="file"
                                        data-options='{ldelim}"openFrom":"image","clsTable":"Tour", "table_id":"{$pvalTable}","toId":"isoman_show_image"{rdelim}'
                                        name="image"
                                        accept="image/png, image/jpeg, image/jpg"
                                        >

                                <input type="hidden" value="{$oneItem.image}" name="image" id="image"/>
                                <a table_id="{$pvalTable}" isoman_multiple="0"
                                   isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"Tour", "pvalTable":"{$pvalTable}","toField":"image","toId":"isoman_show_image"{rdelim})'
                                   class="btn-upload-2 ajOpenDialog" isoman_for_id="image"
                                   isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
                                <div class="text_help"
                                     hidden="">{$clsConfiguration->getValue($image_tour)|html_entity_decode}</div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-5">
                            <img class="img-responsive radius-3" id="isoman_show_image" src="{$oneItem.image}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('images')}"/>
                        </div>
                    </div>
                </div>
                {if $clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','tour_program_file','customize')}
                    <hr class="clearfix"/>
                    <div class="form-group">
                        <label class="col-form-label" for="title">{$core->get_Lang('File download program tour')} <span
                                    class="required_red">*</span>
                            {assign var= file_tour value='file_tour'}
                            {if $CHECKHELP|default:'' eq 1}
                                <button data-key="{$file_tour}" data-label="{$core->get_Lang('Image represent tour')}"
                                        type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                        class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                            {/if}
                        </label>
                        <p class="help-block">{$core->get_Lang('Chosse File in the warehouse data')}</p>
                        <img class="isoman_img_pop" id="isoman_show_file_programmes" src="{$URL_IMAGES}/icon_pdf.png"
                             width="30px" height="30px"/>
                        <input type="hidden" id="isoman_hidden_file_programme" name="isoman_url_file_programme"
                               value="{$oneItem.file_programme}">
                        <input class="text_32 border_aaa bold" type="text" id="isoman_url_file_programme"
                               name="file_programme" value="{$oneItem.file_programme}"
                               style="width:100%; max-width:300px; float:left" onClick="loadHelp(this)"><a
                                style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog"
                                isoman_for_id="file_programme" isoman_val="{$oneItem.file_programme}"
                                isoman_name="file_programme"><img src="{$URL_IMAGES}/general/folder-32.png" border="0"
                                                                  title="Open" alt="Open"/></a>
                        <em style="padding-left:10px; padding-top:3px; display:inline-block">File chương trình tour</em>
                        <div class="text_help"
                             hidden="">{$clsConfiguration->getValue($file_tour)|html_entity_decode}</div>
                    </div>
                {/if}
            </div>
            <div class="btn_save_titile_trip_code">
                <a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
                <a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="instruction_fill_data_box">
                <p class="title_box"><i class="fa fa-question-circle text-red "
                                        aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
                <div class="content_box">{$clsConfiguration->getValue($image_tour)|html_entity_decode}</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var clsTable = 'Tour';
    var table_id = '{$pvalTable}';
</script>