<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('gallery')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Gallery')}{/if}</h2>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
                {if $pvalTable && $clsConfiguration->getValue('SiteHasDetail_Gallery')}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
					<div class="fl"  style="width:18%; margin-right:2%">
						<div class="photobox image">
							{if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="Hình ảnh" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
							<a href="javascript:void()" title="Thay đổi" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
								{if $oneItem.image}
								<a pvalTable="{$pvalTable}" clsTable="Gallery" href="javascript:void()" title="Xóa" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
								{/if}
							{else}
							<img src="{$oneItem.image}" alt="Chưa có hình ảnh" id="imgTestimonial_image" />
							<input type="hidden" name="image_src" value="" class="hidden_src" id="imgTestimonial_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTestimonial">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgTestimonial_file" g="imgTestimonial" class="editInlineImageFile" name="image" />
							{/if}
						</div>
					</div>
                    <div class="fl" style="width:80%">
                    	<div class="row-span">
                        	<div class="fieldlabel bold">{$core->get_Lang('title')}<span class="color_r">*</span></div>
                            <div class="fieldarea">
                            	<input class="text_32 full-width border_aaa required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
						<div class="row-span">
							<div class="fieldlabel bold">{$core->get_Lang('Type Gallery')}</div>
							<div class="fieldarea">
								<select name="iso-type" id="select_type" class="slb required" style="width:300px;padding:4px">
									<option value="PHOTO" {if $oneItem.type eq 'PHOTO'} selected="selected"{/if}>{$core->get_Lang('Picture')}</option>
									<option value="VIDEO" {if $oneItem.type eq 'VIDEO'} selected="selected"{/if}>{$core->get_Lang('Video')}</option>
								</select>
							</div>
						</div>
						<div class="row-span" id="youtube_link">
							<div class="fieldlabel bold">{$core->get_Lang('Youtube Link')}</div>
							<div class="fieldarea">
								<input class="text_32 full-width border_aaa" style="padding:5px" name="iso-youtube_link" value="{$oneItem.youtube_link}" maxlength="255" type="text">
							</div>
						</div>
                        {if $clsConfiguration->getValue('SiteHasCat_Gallery')}
                        <div class="row-span">
                        	<div class="fieldlabel bold">{$core->get_Lang('category')}<span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <select name="iso-gallerycat_id" class="slb required" style="width:300px;padding:4px">
                                	{$clsGalleryCategory->makeSelectboxOption($oneItem.gallerycat_id)}
                                </select>
                            </div>
                        </div>
                        {/if}
                        <div class="row-span">
                            <div class="fieldlabel bold">{$core->get_Lang('status')}</div>
                            <div class="fieldarea">
								<div class="checkbox-switch">
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
                        {if $pvalTable gt 0 and $clsConfiguration->getValue('SiteHasTags_Gallery') eq '1'}
						<div class="row-span">
							{$listAvailableTag}
							<div class="fieldlabel span15">{$core->get_Lang('Tags')}</div>
							<div class="fieldarea span85">
								<input type="text" id="txtTag" name="txtTag" class="text fl mr5" style="width:160px;height:26px;" />
								<a href="javascript:void();" class="btn btn-success fl" id="addTag">
									<i class="icon-plus-sign icon-white"></i>
								</a>
								<div class="clear clearfix"></div>
								<div id="listTag" class="tagchecklist" style="margin-bottom:5px; display:inline-block">
									{section name=i loop=$listTag}
									<span class="tagz"><a href="javascript:void();" class="closeTag" title="{$core->get_Lang('delete')}" id="t-{$listTag[i].tag_module_id}">x</a>{$clsTag->getTitle($listTag[i].tag_id)}</span>
									{/section}
								</div>
							</div>
						</div>
						{/if}
                        <div class="row-span">
                        	<span class="notice bold">{$core->get_Lang('content')}</span>
                        	{$clsForm->showInput('content')}
                        </div>
                    </div>
                </div>
        	</div>
            {if $pvalTable && $clsConfiguration->getValue('SiteHasDetail_Gallery')}
            <div class="tabbox" style="display:none">
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Title')}:</div>
                    <div class="coltrols">
                        <input class="text full" name="config_value_title" value="{$clsISO->getPageTitle($pvalTable,Gallery)}" maxlength="255" type="text">
                        <div class="clearfix mt5"></div>
                        <i>{$core->get_Lang('notetitlemeta')}</i>
                    </div>
                </div>
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Description')}:</div>
                    <div class="coltrols">
                        <textarea name="config_value_intro" class="text full" style="height:60px">{$clsISO->getPageDescription($pvalTable,Gallery)}</textarea>
                        <div class="clearfix mt5"></div>
                        <i>{$core->get_Lang('noteintrometa')}</i>
                    </div>
                </div>
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Keyword')}:</div>
                    <div class="coltrols">
                        <textarea name="config_value_keyword" class="text full" style="height:60px">{$clsISO->getPageKeyword($pvalTable,Gallery)}</textarea>
                        <div class="clearfix mt5"></div>
                        <i>{$core->get_Lang('notekeywordmeta')}</i>
                        <br style="clear:both" />
                        <br style="clear:both" />
                        <table>
                            <tr>
                                <td style="background:#CCC">{$core->get_Lang('Meta Robots Index')}</td>
                                <td>
                                    <select name="meta_index">
                                        <option value="0">{$core->get_Lang('Index')}</option>
                                        <option value="1" {if $oneMeta.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
                                    </select>
                                </td>
                                <td style="background:#CCC">{$core->get_Lang('Meta Robots Follow')}</td>
                                <td>
                                    <select name="meta_follow">
                                        <option value="0">{$core->get_Lang('Follow')}</option>
                                        <option value="1" {if $oneMeta.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            {/if}
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
var $type = '_Gallery';
var $SiteHasTags_Gallery = "{$clsConfiguration->getValue('SiteHasTags_Gallery')}";
</script>
{literal}
<script type="text/javascript">
loadInputFile();
$('#select_type').change(function(){
	var $_this = $(this);
	if($_this.val()=='VIDEO'){
		$('#youtube_link').show();
	}else{
		$('#youtube_link').hide();
	}
});		
function loadInputFile(){
	var downloadcat_id = $('#select_type').val();
	if(downloadcat_id=='VIDEO'){
		$('#youtube_link').show();
	}else{
		$('#youtube_link').hide();
	}
}
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/gallery/jquery.gallery.js?v={$upd_version}"></script>