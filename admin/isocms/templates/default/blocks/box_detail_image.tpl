<h3 class="title_box">{$core->get_Lang('Main Image')}
{assign var= help_first value=$image_detail|default:''}
{if $CHECKHELP|default:0 eq 1}
<button data-key="{$image_detail|default:''}" data-label="{$core->get_Lang('Image')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
{/if}
</h3>


<div class="form_option_tour">
    <div class="inpt_tour" {$mod} {$image_detail|default:''}>
        <div class="text_help" hidden="">
            {$clsConfiguration->getValue($image_detail|default:'')|html_entity_decode}
            
        </div>

        <div class="main-image-upload">
            <!-- Preview ảnh bên trái -->
            <div class="main-image-preview">
                <div class="main-image-preview-inner">
                    {if $clsTable == "Guide2"}
                        {assign var="clsClassTable" value=$clsGuide2}
                    {/if}

                    <img
                        alt="{$oneItem.title}"
                        class="main-image-preview-img radius-3"
                        id="isoman_show_image"
                        src="{$clsClassTable->getImage($pvalTable)}"
                        onerror="this.src='{$URL_IMAGES}/none_image.png'"
                    />

                    {if $oneItem.image}
                    <button
                        type="button"
                        class="main-image-remove"
                        title="Remove image"
                        onclick="document.getElementById('image').value='';document.getElementById('isoman_show_image').src='{$URL_IMAGES}/none_image.png';"
                    >
                        <i class="fa fa-times"></i>
                    </button>
                    {/if}
                </div>
            </div>

            <!-- Khu vực upload bên phải -->
            <div class="main-image-upload-panel">
                <div  class="main-image-dropzone filedrop full">
									<div        onclick="file_explorer(this,event);"
                    ondrop="file_drop(this,event)"
                    toid="selectFile"
                    toel="isoman_show_image"
                    data-options='{ldelim}"openFrom":"image","clsTable":"{$clsTable}","table_id":"{$pvalTable}","toId":"isoman_show_image"{rdelim}'
                    ondragover="return false">
										                    <div class="main-image-upload-icon">
                        <i class="fa fa-cloud-upload"></i>
                    </div>

                    <h3>
                        {if $oneItem.image}
                            {$core->get_Lang('Change Image')}
                        {else}
                            {$core->get_Lang('Upload Image')}
                        {/if}
                    </h3>


                    <p class="main-image-upload-size">
											{$core->get_Lang('Drop files to upload')}
											<br>
                        {if $mod=='blog'}
                            {$core->get_Lang('Image size')} (WxH=828x552px)
                        {elseif $mod=='ads'}
                            {$core->get_Lang('Image size')} (WxH=624x335)
                        {elseif $mod=='testimonial'}
                            {$core->get_Lang('Image size')} (WxH=260x200px)
                        {elseif $mod=='news'}
                            {$core->get_Lang('Image size')} (WxH=850x547px)
                        {elseif $mod=='country'}
                            {$core->get_Lang('Image size')} (WxH=261x376px)
                        {elseif $mod=='hotel'}
                            {$core->get_Lang('Image size')} (WxH=850x391px)
                        {elseif $mod=='cruise'}
                            {$core->get_Lang('Image size')} (WxH=733x486px)
                        {elseif $mod=='service'}
                            {$core->get_Lang('Image size')} (WxH=280x255px)
                        {elseif $mod=='city'}
                            {$core->get_Lang('Image size')} (WxH=297x297px)
                        {elseif $mod=='voucher'}
                            {$core->get_Lang('Image size')} (WxH=297x194px)
                        {elseif $mod=='tour_exhautive' && isset($image_detail|default:'') && $image_detail|default:'' eq 'image_category_country'}
                            {$core->get_Lang('Image size')} (WxH=532x355px)
                        {else}
                            {$core->get_Lang('Image size')} (WxH=750x500px)
                        {/if}
												<br>
												{$core->get_Lang('Supported formats')}: .png, .jpg, .jpeg
                    </p>
										                    <!-- <button type="button" class="main-image-choose-btn">
                        <i class="fa fa-picture-o"></i>
                        {$core->get_Lang('Choose image')}
                        <i class="fa fa-angle-down"></i>
                    </button> -->
										                <!-- Input upload giữ nguyên ID và data-options -->


                <!-- Giữ nguyên chức năng mở thư viện ảnh ISOCMS -->
									</div>
                <input
                    class="hidden"
                    id="selectFile"
                    type="file"
                    data-options='{ldelim}"openFrom":"image","clsTable":"{$clsTable}","table_id":"{$pvalTable}","toId":"isoman_show_image"{rdelim}'
                    name="image"
                />

                <input
                    style="display:none"
                    type="file"
                    multiple
                    name="image"
                    id="ajAttachFile"
                />

                <input
                    type="hidden"
                    value="{$oneItem.image}"
                    name="image"
                    id="image"
                />

           


                <a
                    table_id="{$pvalTable}"
                    isoman_multiple="0"
                    isoman_callback='isoman_callback({ldelim}"openFrom":"image","clsTable":"{$clsTable}","pvalTable":"{$pvalTable}","table_id":"{$pvalTable}","toField":"image","toId":"isoman_show_image"{rdelim})'
                    class="main-image-library-btn ajOpenDialog"
                    isoman_for_id="image"
                    isoman_name="image"
                >
                    <i class="fa-regular fa-image"></i>
                    {$core->get_Lang('Choose from library')}
                </a>
								         <p class="main-image-upload-formats"> JPG, PNG, WebP (Max 5MB)</p>
                </div>

            </div>
        </div>
    </div>
</div>

{literal}
<style>
	.main-image-dropzone h3{
		    font-size: 14px;
    font-weight: 700;
    color: #1b4581;
}
/* ==========================================
   MAIN IMAGE UPLOAD - ISOCMS
   ========================================== */

.main-image-upload,
.main-image-upload * {
    box-sizing: border-box;
}
.main-image-upload-formats{
	    font-size: 12px;
    color: #8a97a8;
}
.main-image-upload {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    align-items: stretch;
    gap: 18px;
    width: 100%;
}

/* Preview bên trái */
.main-image-preview {
    min-width: 0;
    min-height: 220px;
}

.main-image-preview-inner {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 220px;
    overflow: hidden;
    border-radius: 12px;
    background: #dceaf8;
}

.main-image-preview-img {
    display: block;
    width: 100% !important;
    height: 100% !important;
    min-height: 220px;
    max-height: 340px;
    object-fit: cover;
    object-position: center;
    border-radius: 12px;
}

/* Nút xoá ảnh preview */
.main-image-remove {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0;
    color: #fff;
    background: #64748b;
    border: 0;
    border-radius: 50%;
    cursor: pointer;
    z-index: 2;
}

.main-image-remove:hover {
    background: #334155;
}

/* Cột upload bên phải */
.main-image-upload-panel {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    justify-content: center;
    min-width: 0;
    min-height: 220px;
}

/* Khung dropzone */
.main-image-upload-panel .main-image-dropzone.filedrop.full {
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 220px;
    margin: 0;
    padding: 18px;
    background: #f7f9fc;
    border: 2px dashed #b7c9e4;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: background .2s ease, border-color .2s ease;
}

.main-image-upload-panel .main-image-dropzone:hover {
    background: #f0f5fc;
    border-color: #8eacd7;
}

/* Icon upload */
.main-image-upload-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    color: #174a8b;
}

.main-image-upload-icon i {
    font-size: 27px;
}

/* Tiêu đề */
.main-image-upload-panel .main-image-dropzone h3 {
    margin: 0 0 8px;
    color: #174a8b;
    font-weight: 600;
}

/* Mô tả */
.main-image-upload-panel .main-image-dropzone p {
    margin: 3px 0;
    color: #64748b;
    line-height: 1.5;
}

.main-image-upload-panel .main-image-upload-description {
    color: #475569;
}

.main-image-upload-panel .main-image-upload-formats {
    margin-top: 8px !important;
}

/* Nút Choose image */
.main-image-choose-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 38px;
    margin-top: 12px;
    padding: 8px 14px;
    color: #174a8b;
    background: #fff;
    border: 1px solid #d4dfed;
    border-radius: 9px;
    font-weight: 600;
    cursor: pointer;
}

.main-image-choose-btn:hover {
    background: #edf4fc;
    border-color: #b7c9e4;
}

/* Nút thư viện ảnh */
.main-image-upload-panel .main-image-library-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    align-self: center;
    gap: 8px;
    min-height: 38px;
    margin-top: 10px;
    padding: 8px 14px;
    color: #174a8b;
    background: #fff;
    border: 1px solid #174a8b;
    border-radius: 9px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background .2s ease;
}

.main-image-upload-panel .main-image-library-btn:hover {
    color: #123c72;
    background: #edf4fc;
}

/* Không hiện text trợ giúp trong khung */
.main-image-upload .text_help {
    display: none !important;
}

/* Tablet và mobile */
@media (max-width: 767px) {
    .main-image-upload {
        grid-template-columns: minmax(0, 1fr);
        gap: 12px;
    }

    .main-image-preview,
    .main-image-preview-inner {
        min-height: 180px;
    }

    .main-image-preview-img {
        height: auto !important;
        min-height: 180px;
        max-height: 280px;
    }

    .main-image-upload-panel,
    .main-image-upload-panel .main-image-dropzone.filedrop.full {
        min-height: 210px;
    }
}

</style>
{/literal}