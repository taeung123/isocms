<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Sale Kits')}</a>
	<a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable|default:''}{else}{$core->get_Lang('add')}{/if}</a>
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
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Image')}</strong></div>
                <div class="fieldarea">
                    <div class="form_option_tour">
                        <div class="inpt_tour">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="drop_gallery" onClick="loadHelp(this)" >
                                        <div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_image" data-options='{ldelim}"openFrom":"image","clsTable":"{$clsTable|default:''}", "table_id":"{$pvalTable|default:''}","toId":"isoman_show_image" {rdelim}' ondragover="return false">
                                            <h3>{$core->get_Lang('Drop files to upload')}</h3>
                                            <p>{$core->get_Lang('Image size')} (WxH=220x300)<br />
                                                Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
                                            <button type="button" class="btn btn-upload">{if $oneItem.image|default:''}{$core->get_Lang('Change Image')}{else}{$core->get_Lang('Upload Image')}{/if}</button>
                                        </div>
                                        <input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"image","clsTable":"{$clsTable|default:''}", "table_id":"{$pvalTable|default:''}","toId":"isoman_show_image"{rdelim}' name="image">

                                        <input style="display:none" type="file" multiple name="image" id="ajAttachFile" />
                                        <input type="hidden" value="{$oneItem.image|default:''}" name="iso-image" id="image" />
                                        <a table_id="{$pvalTable|default:''}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"{$clsTable|default:''}", "pvalTable":"{$pvalTable|default:''}", "table_id":"{$pvalTable|default:''}","toField":"image","toId":"isoman_show_image"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="image" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="aspect-ratio aspect-ratio--square aspect-ratio--square--full aspect-ratio--interactive">
                                        <img alt="{$oneItem.title|default:''}" class="aspect-ratio__content radius-3" width="220" id="isoman_show_image" src="{$clsISO->tripslashImage($oneItem.image|default:'',220,300)}" style="height:200px" />
                                    </div>
                                </div>
                            </div><!-- /file list -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea">
                    <input class="text_32 full-width border_aaa bold required fontLarge" style="padding:5px" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Attachment File')}</strong> <span class="color_r">*</span></div>
                <div class="fieldarea">
                    <img class="isoman_img_pop" id="isoman_show_image_Fx" src="{$oneItem.attachment_file|default:''}" style="width:32px;height:32px" />
                    <input type="hidden" id="isoman_hidden_image_Fx" value="{$oneItem.attachment_file|default:''}">
                    <input class="text_32 border_aaa fl span60 ml10" type="text" id="isoman_url_image_Fx" name="iso-attachment_file" value="{$oneItem.attachment_file|default:''}"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image_Fx" isoman_val="{$oneItem.attachment_file|default:''}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                </div>
            </div>
            <div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
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
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Short Text')}</strong> <span class="color_r">*</span></div>
                <div class="fieldarea">
                   <div class="coltrols">{$clsForm->showInput(intro)}</div>
                </div>
            </div>
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden" />
        </fieldset>
    </form>
</div>