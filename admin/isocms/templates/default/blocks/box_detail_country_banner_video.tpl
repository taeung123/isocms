<div class="box_title_trip_code">
	<div class="full-height">
        <div class="form-group inpt_tour">
            <label class="col-form-label" for="title">{$core->get_Lang('Banner')} <span class="required_red">*</span>
                {assign var= banner_Country value='banner_Country'}
                {assign var= help_first value=$banner_Country}
                {if CHECKHELP eq 1}
                <button data-key="{$banner_Country}" data-label="{$core->get_Lang('Banner')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                {/if}
            </label>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="drop_gallery" onClick="loadHelp(this)">
                        <div class="filedrop full" onClick="file_explorer(this,event);" ondrop="file_drop(this,event)" toid="selectFile" toel="isoman_show_banner" data-options='{ldelim}"openFrom":"banner","clsTable":"Country", "table_id":"{$pvalTable}","toId":"isoman_show_banner" {rdelim}' ondragover="return false">
                            <h3>{$core->get_Lang('Drop files to upload')}</h3>
                            <p>{$core->get_Lang('Size')} (WxH=1920x400)<br />
                            {$core->get_Lang('Supported file types are')}: .png,.jpg,.jpeg</p>
                            <button type="button" class="btn btn-upload">{if $oneItem.banner}{$core->get_Lang('Replace image')}{else}{$core->get_Lang('Upload image')}{/if}</button>
                        </div>
                        <input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"banner","clsTable":"Country", "table_id":"{$pvalTable}","toField":"banner","toId":"isoman_show_banner","aspectRatio":"(1920/600)"{rdelim}' name="banner">

                        <input type="hidden" value="{$oneItem.banner}" name="banner" id="banner" />
                        <a table_id="{$pvalTable}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"banner", "clsTable":"Country", "pvalTable":"{$pvalTable}","toField":"banner","toId":"isoman_show_banner"{rdelim})' class="btn-upload-2 ajOpenDialog" isoman_for_id="banner" isoman_name="banner">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
                        <div class="text_help" hidden="">{$clsConfiguration->getValue($banner_Country)|html_entity_decode}</div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <img class="img-responsive radius-3" id="isoman_show_banner" src="{$oneItem.banner}" onerror="this.src='{$URL_IMAGES}/none_image.png'" alt="{$core->get_Lang('banner')}" style="width:100%; height:auto"  />
                </div>
            </div>
        </div>
        <hr class="clearfix" />
        {*<div class="form-group">
            <label class="col-form-label bold" for="title">{$core->get_Lang('Video Teaser')} <span class="required_red">*</span>
            {assign var= Video_Teaser_Country value='Video_Teaser_Country'}
                    {if CHECKHELP eq 1}
                    <button data-key="{$Video_Teaser_Country}" data-label="{$core->get_Lang('Video Teaser')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                    {/if}
            </label>
            <div class="fieldarea" onClick="loadHelp(this)">
                <input type="hidden" id="isoman_hidden_video" value="{$oneItem.video_teaser}">
                <input type="text" id="isoman_url_video" name="iso-video_teaser" value="{$oneItem.video_teaser}" class="text_32 border_aaa" style="width:calc(100% - 45px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="video" isoman_val="{$oneItem.video_teaser}" isoman_name="video"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                <div class="clearfix"></div>
                <span style="display:block; margin-top:5px; font-size:12px">
                ({$core->get_Lang('ex: file.mp4, file.ogg, file.m4v..., frame width:&gt;=1600px, frame height:&lt;=500px')})
                </span>
                <div class="text_help" hidden="">{$clsConfiguration->getValue($Video_Teaser_Country)|html_entity_decode}</div>
            </div>
		</div>*}
	</div>
</div>
<script type="text/javascript">
	var clsTable = 'Country';
	var table_id = '{$pvalTable}';
</script>