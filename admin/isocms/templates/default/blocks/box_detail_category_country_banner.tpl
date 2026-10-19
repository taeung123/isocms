<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-12">
			<div class="fill_data_box">
				<div class="form-group inpt_tour">
					<label class="col-form-label" for="title">{$core->get_Lang('Banner Size')}
						{assign var= banner_guideCat value='banner_guideCat'}
						{assign var= help_first value=$banner_guideCat}
						{if $CHECKHELP|default:0 eq 1}
						<button data-key="{$banner_guideCat}" data-label="{$core->get_Lang('Banner')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
					</label>
					<div class="row">
							<div class="drop_gallery " onClick="loadHelp(this)">
								<div class="filedrop full" style="    cursor: auto;">
									<div style="cursor: pointer;" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_banner" data-options='{ldelim}"openFrom":"banner","clsTable":"Category_Country", "table_id":"{$pvalTable}","toId":"isoman_show_banner" {rdelim}' ondragover="return false">
											<h3>{$core->get_Lang('Drop files to upload')}</h3>
									<p>Kích thước (WxH=1920x480)<br />
									Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
									</div>

									<div class="d-flex">
										<div  onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_banner" data-options='{ldelim}"openFrom":"banner","clsTable":"Category_Country", "table_id":"{$pvalTable}","toId":"isoman_show_banner" {rdelim}' ondragover="return false">
											<button type="button" class="btn btn-upload">{if $oneItem.image_banner}Change Image{else}Upload Image{/if}</button>
										</div>
										
										<a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"banner", "clsTable":"Category_Country", "pvalTable":"{$pvalTable}","toField":"banner","toId":"isoman_show_banner"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="banner" isoman_name="banner">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
									</div>
								</div>
								<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"banner","clsTable":"Category_Country", "table_id":"{$pvalTable}","toId":"isoman_show_banner"{rdelim}' name="image_banner">
								<input type="hidden" value="{$oneItem.image_banner}" name="image_banner" id="banner" />
								<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_guideCat)|html_entity_decode}</div>
							</div>

				
						<div class="col-xs-12 col-md-12" style="margin-top: 12px;">
							<img class="img-responsive radius-3" id="isoman_show_banner" src="{$oneItem.image_banner}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('banner')}" style="width:100%; height:334px"  />
						</div>
					</div>
				</div>
				<hr class="clearfix" />
				<div class="inpt_tour">
					<label for="title">{$core->get_Lang('Banner Link')}
					{assign var= banner_link_guideCat value='banner_link_guideCat'}
					{assign var= help_first value=$banner_link_guideCat}
					{if $CHECKHELP|default:0 eq 1}
					<button data-key="{$banner_link_guideCat}" data-label="{$core->get_Lang('Banner Link')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
					{/if}
					</label>
					<input class="text_32 full-width bold border_aaa" name="iso-link_banner" value="{$oneItem.link_banner}"  type="text" onClick="loadHelp(this)" placeholder="{$DOMAIN_NAME}" />
					<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_link_guideCat)|html_entity_decode}</div>
				</div>
				<div class="inpt_tour">
					<label for="title">{$core->get_Lang('Banner Content')}
						{assign var= banner_content_guideCat value='banner_content_guideCat'}
						{assign var= help_first value=$banner_content_guideCat}
						{if $CHECKHELP|default:0 eq 1}
						<button data-key="{$banner_content_guideCat}" data-label="{$core->get_Lang('Banner Content')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
						{/if}
					</label>
					<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro_banner" class="textarea_intro_editor" data-column="iso-intro_banner" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.intro_banner}</textarea>
					<div class="text_help" hidden="">{$clsConfiguration->getValue($banner_content_guideCat)|html_entity_decode}</div>
					{literal}
					<script>
					$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
					</script>
					{/literal}
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var clsTable = 'Guide2';
	var table_id = '{$pvalTable}';
</script>
{literal}
<style>
	
.drop_gallery{
	
    border: unset;
}
.inpt_tour .drop_gallery {
    width: 100%;
    overflow: hidden;
}
.drop_gallery .btn-upload-2{
    background: #174a8b !important;
}
/* Hàng chứa upload và preview */
.inpt_tour .drop_gallery > .filedrop.full {
    box-sizing: border-box;
    width: 100%;
    min-height: 250px;
    padding: 22px 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: #f6f9fd;
    border: 2px dashed #b7c9e4;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
}

/* Tiêu đề Drop files to upload */
.inpt_tour .drop_gallery .filedrop h3 {
    margin: 0 0 2px;
    color: #26364b;
    font-weight: 600;
}

/* Mô tả kích thước và định dạng */
.inpt_tour .drop_gallery .filedrop p {
    margin: 0;
    color: #64748b;
    line-height: 1.6;
}

/* Nút Tải ảnh lên */
.inpt_tour .drop_gallery .filedrop .btn-upload {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    margin-top: 10px;
    padding: 8px 15px;
    border: 1px solid #174a8b;
    border-radius: 10px;
    background: #fff;
    color: #174a8b;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s ease, color .2s ease;
}

.inpt_tour .drop_gallery .filedrop .btn-upload:hover {
    background: #edf4fc;
    color: #174a8b;
}

.drop_gallery .btn-upload-2 {
		 border-radius: 10px;
    margin: 10px 7px 0px;
}

/* Nút From library */
.inpt_tour .drop_gallery > .btn-upload-2 {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    margin-top: 10px;
    padding: 8px 15px;
    border: 1px solid #ff7900;
    border-radius: 10px;
    background: #ff7900;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background .2s ease;
}

.inpt_tour .drop_gallery > .btn-upload-2:hover {
    background: #ed6d00;
    color: #fff;
}

/* Hai nút nằm cùng hàng, căn giữa */
.inpt_tour .drop_gallery > .filedrop.full {
    margin-bottom: 0;
}

.inpt_tour .drop_gallery > .btn-upload-2 {
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    margin-bottom: 15px;
}

/* Ảnh banner preview */
.inpt_tour #isoman_show_banner {
    display: block;
    width: 100% !important;
    margin-top: 0;
    object-fit: cover;
    object-position: center;
    border-radius: 12px;
    background: #f6f9fd;
}

/* Responsive */
@media (max-width: 767px) {
    .inpt_tour .drop_gallery > .filedrop.full {
        min-height: 160px;
        padding: 18px 12px;
    }

    .inpt_tour #isoman_show_banner {
        height: auto !important;
        min-height: 150px;
        max-height: 260px;
        object-fit: contain;
    }
}

</style>

{/literal}