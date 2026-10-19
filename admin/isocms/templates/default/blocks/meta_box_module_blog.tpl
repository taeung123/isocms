<div class="box_title_trip_code" meta_id="{$meta_id}">
    <div class="row d-flex full-height">
        <div class="col-md-12">
            <div class="fill_data_box">
                <h3 class="title_box">{$core->get_Lang('seosdvanced')}</h3>
                <div class="form_option_tour">
                    <div class="form-group">
                        <label class="col-form-label" for="config_value_title">{$core->get_Lang('Meta Title')} <span
                                    class="required_red">*</span></label>
                        <input class="form-control required" name="config_value_title" id="config_value_title"
                               onkeyup="countCharTitle(this)" value="{$clsMeta->getMetaTitle($meta_id)}" maxlength="255"
                               type="text">
                        <span class="help-block">{$core->get_Lang('The meta title of your page has a length of')} <strong
                                    id="charTitleNum">{$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta titles to 70 characters')}.</span>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="config_value_intro">{$core->get_Lang('Meta Description')}
                            <span class="required_red">*</span></label>
                        <textarea name="config_value_intro" id="config_value_intro" class="form-control required"
                                  onkeyup="countCharDes(this)">{$clsMeta->getMetaDescription($meta_id)}</textarea>
                        <span class="help-block">{$core->get_Lang('The meta description of your page has a length of')} <strong
                                    id="charDesNum">{$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta descriptions to 160 characters')}.</span>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="config_value_intro">{$core->get_Lang('Meta Index')} <span
                                    class="required_red">*</span></label>
                        <table>
                            <tr>
                                <td>{$core->get_Lang('Meta Robots Index')}:</td>
                                <td>
                                    <select name="meta_index">
                                        <option value="0">{$core->get_Lang('Index')}</option>
                                        <option value="1"
                                                {if $oneMeta.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
                                    </select>
                                </td>
                                <td>{$core->get_Lang('Meta Robots Follow')}:</td>
                                <td>
                                    <select name="meta_follow">
                                        <option value="0">{$core->get_Lang('Follow')}</option>
                                        <option value="1"
                                                {if $oneMeta.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group inpt_tour">
                        <label class="col-form-label">{$core->get_Lang('Image Share Social')} <span
                                    class="required_red">*</span></label>
                        <div class="row">
                            <div class="col-md-5 col-sm-12">
                                <div class="filedrop-picker">
                                    <div class="filedrop" onclick="file_explorer(this,event);"
                                         ondrop="file_drop(this,event)" toId="selectFileMeta"
                                         hiddenId="isoman_hidden_image_seo"
                                         data-options='{ldelim}"openFrom":"seo","clsTable":"Meta", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}'
                                         ondragover="return false">
                                        <h3>Kéo ảnh vào đây để tải lên</h3>
                                        <p>Kích thước (WxH=500x261)<br>
                                            Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
                                        <button type="button"
                                                class="btn btn-upload">{$core->get_Lang('From computer')}</button>
                                    </div>
                                    <input type="hidden" name="meta_id" value="{$meta_id}">
                                    <input class="hidden" id="selectFileMeta" type="file"
                                           data-options='{ldelim}"openFrom":"seo","seo":"image","clsTable":"Meta", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}'>
                                    <div class="clearfix mt-half"></div>
                                    <a table_id="{$meta_id}" isoman_multiple="0"
                                       isoman_callback='isoman_callback({ldelim}"openFrom":"seo", "clsTable":"Meta", "table_id":"{$meta_id}","toField":"image","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim})'
                                       class="btn btn-upload-choice ajOpenDialog" isoman_for_id="image_seo"
                                       isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="aspect-ratio aspect-ratio--square aspect-ratio--square--full aspect-ratio--interactive">
                                    <input type="hidden" id="isoman_hidden_image_seo" name="isoman_url_image_seo"
                                           value="{$clsMeta->getOneField('image',$meta_id)}"/>
                                    <img class="aspect-ratio__content radius-3" id="isoman_show_image_seo"
                                         src="{$oneMeta.image}" width="250px" height="170px"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        function countCharTitle(val) {
            var len = val.value.length;
            $('#charTitleNum').text(len);
        };

        function countCharDes(val) {
            var len = val.value.length;
            $('#charDesNum').text(len);
        };
    </script>
{/literal}