<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('download')}</a>
	<a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('addnew')} {$core->get_Lang('download')}{/if}</h2>
    </div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="wrap">
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea" style="position: relative">
                    <input id="searchkey_store"  class="text_32 full-width border_aaa bold required fontLarge" style="padding:5px" name="title" value="{$oneItem.title|default:''}" maxlength="255" type="text">
                    <div class="autosugget" id="autosugget">
                        <ul class="HTML_sugget"></ul>
                        <div class="clearfix"></div>
                        <a class="close_Div">{$core->get_Lang('close')}</a>
                    </div>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Trip code')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea">
                    <input class="text_32 full-width border_aaa bold required fontLarge" style="padding:5px" name="iso-trip_code" id="trip_code" value="{$oneItem.trip_code|default:''}" maxlength="255" type="text">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Country')}</strong> </div>
                <div class="fieldarea">
                    <select id="country_id" class="slb_Country_Id glSlBox border_aaa required" id="country_id" name="iso-country_id" style="width:250px" onClick="loadHelp(this)">
                        {$clsCountry->makeSelectboxOption($oneItem.country_id)}
                    </select>
                </div>
            </div>
            <div class="row-span" id="box_market">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Market')}</strong> </div>
                <div class="fieldarea">
                    <select id="slb_marketID" class="slb_Country_Id glSlBox border_aaa required" name="iso-market_id" style="width:250px" onClick="loadHelp(this)">
                        <option value="">-- {$core->get_Lang('Choose market')} --</option>
                    </select>
                </div>
            </div>
            <div class="row-span" id="box_type_market">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Type market')}</strong> </div>
                <div class="fieldarea">
                    <select id="slb_marketTypeID" class="slb_Country_Id glSlBox border_aaa required" name="iso-market_type_id" style="width:250px" onClick="loadHelp(this)">
                        <option value="">-- {$core->get_Lang('Choose market type')} --</option>
                    </select>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Price')}</strong> </div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold fontLarge" style="padding:5px" name="iso-trip_price" value="{$oneItem.trip_price|default:''}" maxlength="255" type="text">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Price old')}</strong> </div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa bold fontLarge" style="padding:5px" name="iso-trip_price_old" value="{$oneItem.trip_price_old|default:''}" maxlength="255" type="text">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Attachment file')}</strong></div>
                <div class="fieldarea">
                    <input id="attachment_file" class="text_32 border_aaa fl span60" type="text" id="isoman_url_image_Fx" name="iso-attachment_file" value="{$oneItem.attachment_file|default:''}"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_Fx" isoman_val="{$oneItem.attachment_file|default:''}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('File download')}</strong></div>
                <div class="fieldarea">
                    <input class="text_32 border_aaa fl span60" type="text" id="isoman_url_image_Fx_doc" name="iso-attachment_file_doc" value="{$oneItem.attachment_file_doc|default:''}"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_Fx" isoman_val="{$oneItem.attachment_file_doc|default:''}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                </div>
            </div>
            <div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> </div>
				<div class="fieldarea">
					<div class="checkbox-switch switch_public">
						{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
						<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
						{else}
						<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
						{/if}
						<div class="checkbox-animate">
							<span class="checkbox-off">PRIVATE</span>
							<span class="checkbox-on">PUBLIC</span>
						</div>
					</div>
					<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
					<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
				</div>
			</div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Image')}</strong></div>
                <div class="fieldarea">
                    <div class="form_option_tour">
                        <div class="inpt_tour">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="drop_gallery" onClick="loadHelp(this)" >
                                        <div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image" data-options='{ldelim}"openFrom":"image","clsTable":"{$clsTable|default:''}", "table_id":"{$pvalTable|default:0}","toId":"isoman_show_image" {rdelim}' ondragover="return false">
                                            <h3>{$core->get_Lang('Drop files to upload')}</h3>
                                            <p>{$core->get_Lang('Image size')} (WxH=750x500px)<br />
                                                Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
                                            <button type="button" class="btn btn-upload">{if $oneItem.image|default:''}{$core->get_Lang('Change Image')}{else}{$core->get_Lang('Upload Image')}{/if}</button>
                                        </div>
                                        <input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"image","clsTable":"{$clsTable|default:''}", "table_id":"{$pvalTable|default:0}","toId":"isoman_show_image"{rdelim}' name="image">

                                        <input style="display:none" type="file" multiple name="image" id="ajAttachFile" />
                                        <input type="hidden" value="{$oneItem.image|default:''}" name="iso-image" id="image" />
                                        <a table_id="{$pvalTable|default:0}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"{$clsTable|default:''}", "pvalTable":"{$pvalTable|default:0}", "table_id":"{$pvalTable|default:0}","toField":"image","toId":"isoman_show_image"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="image" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="aspect-ratio aspect-ratio--square aspect-ratio--square--full aspect-ratio--interactive">
                                        <img alt="{$oneItem.title|default:''}" class="aspect-ratio__content radius-3" id="isoman_show_image" src="{$clsISO->tripslashImage($oneItem.image|default:'',250,170)}" style="width:50%; height:200px" />
                                    </div>
                                </div>
                            </div><!-- /file list -->
                        </div>
                    </div>
                </div>
            </div>
			<div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Short Text')}</strong> </div>
                <div class="fieldarea">
                   <div class="coltrols">{$clsForm->showInput(intro)}</div>
                </div>
            </div>
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden" />
            <input type="hidden" name="iso-tour_id" value="{$oneItem.tour_id|default:0}" id="tour_id">
        </fieldset>
    </form>
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

            var aj_search = '';
            $("#searchkey_store").bind('keyup change', function() {
                var $_this = $(this);
                if ($_this.val() != '') {
                    clearTimeout(aj_search);
                    search_tour_store();
                } else {
                    $("#autosugget").stop(false, true).slideUp();
                }
            });
            $(document).on('click', '.clickChooseTourStore', function(ev) {
                var $_this = $(this);
                var title=$_this.data('title');
                var tour_id=$_this.data('tour_id');
                $('#searchkey_store').val(title);
                search_tour_store('Hidden');
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod='+ mod +'&act=ajGetTour',
                    data: {
                        "tour_id": tour_id,
                    },
                    success: function(res) {
                        if (res) {
                            let escapedHtml = res.overview;
                            let unescapedHtml = $('<div>').html(escapedHtml).text();

                            $('#trip_code').val(res.trip_code);
                            $('#attachment_file').val(res.attachment_file);
                            $('#isoman_show_image').attr('src', res.image);
                            $('#image').val(res.image);
                            tinymce.get('textarea_intro').setContent(unescapedHtml);
                            $('#tour_id').val(tour_id);
                        }
                    }
                });
                return false;
            });
        });
        function loadMarket($country_id,$market_id=0) {
            $('#slb_marketID').html('<option value="0">' + loading + '</option>');
            $('#slb_marketTypeID').html('<option value="0">' + loading + '</option>');
            vietiso_loading(1);

            if($country_id > 0){
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectMarket",
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
                    url: path_ajax_script + "/?mod=" + mod + "&act=ajmakeSelectTypeMarket",
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
        function search_tour_store(check) {
            aj_search = setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=tour_exhautive&act=ajGetSearchStore',
                    data: {
                        "keyword": $("#searchkey_store").val(),
                        "type": type,
                        "check": check,
                    },
                    dataType: 'html',
                    success: function(html) {
                        if (html.indexOf('_EMPTY') >= 0) {
                            $('#autosugget').hide();
                        } else {
                            $('#autosugget').stop(false, true).slideDown();
                            $('#autosugget').find('.HTML_sugget').html(html);
                        }
                    }
                });
            }, 500);
        }
    </script>
{/literal}