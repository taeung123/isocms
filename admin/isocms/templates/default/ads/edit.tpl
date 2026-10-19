<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('advert')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}">{$core->get_Lang('edit')} #{$pvalTable}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Ads Management')} &raquo; <font class="color_r">{$core->get_Lang('edit')} #{$pvalTable}</font></h2>
        <p>{$core->get_Lang('Please enter all required fields')}</p>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
         <fieldset>
            <legend>{$core->get_Lang('Setting advert')}</legend>
            <div class="wrap">
				<div class="fl col_Left full_width_767">
					<div class="photobox image">
						{if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="Chưa có hình ảnh"  id="isoman_show_image" class="span100" height="156px"  />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
							<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image" title="Chọn ảnh bài viết">
								<i class="iso-edit"></i>
							</a>
							{if $oneItem.image}
							<a pvalTable="{$pvalTable}" clsTable="Ads" href="javascript:void()" title="Xóa" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
							{/if}
						{else}
							<img src="{$oneItem.image}" alt="Chưa có hình ảnh" id="imgTestimonial_image" />
							<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTestimonial_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTestimonial">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgTestimonial_file" g="imgTestimonial" class="editInlineImageFile" name="image" />
						{/if}
					</div>
				</div>
                <div class="fl col_Right full_width_767">
                    <div class="row-span">
                        <div class="fieldlabel bold">{$core->get_Lang('nameofads')}<font color="red">*</font></div>
                        <div class="fieldarea">
                            <input class="text full fontLarge required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                        </div>
                    </div>
                    <div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
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
                    {*<div class="row-span">
                        <div class="fieldlabel">{$core->get_Lang('type')} <font color="red">*</font></div>
                        <div class="fieldarea">
                            <select class="slb" name="iso-type" style="width:122px">
                                <option {if $oneItem.type eq 'IMAGE'} selected="selected"{/if} value="IMAGE">{$core->get_Lang('Images')}</option>
                                <option {if $oneItem.type eq 'FLASH'} selected="selected"{/if} value="FLA">{$core->get_Lang('Flash')}</option>
                            </select>
                        </div>
                    </div>*}
                    <div class="row-span">
                        <div class="fieldlabel bold">{$core->get_Lang('link')}</div>
                        <div class="fieldarea">
                            <input class="text full url" value="{$clsClassTable->getLink($pvalTable)}" name="iso-url" maxlength="255" type="text" />
                        </div>
                    </div>
                    {if $clsConfiguration->getValue('SiteHasGroup_Ads') eq 1}
                	<div class="clearfix"><br /></div>
                    <fieldset style="background:#f9f9f9">
                        <legend>{$core->get_Lang('Display ads on the page')}</legend>
                        <p class="font12px">{$core->get_Lang('Tick selected in the page types like to display ads')}.</p>
                        <ul style="list-style:none;">
                            {section name=i loop=$lstAdsGroup}
                            <li style="padding:3px 0px;"><label><input disabled="disabled" name="lstGroup[]" type="checkbox" value="{$lstAdsGroup[k].ads_group_id}" /> {$clsAdsGroup->getTitle($lstAdsGroup[i].ads_group_id)}</label></li>
                            <!-- Start child -->
                            {assign var = lstAdsGroup2 value = $clsAdsGroup->getChild($lstAdsGroup[i].ads_group_id)}
                            {if $lstAdsGroup2[0].ads_group_id ne ''}
                            {section name=k loop=$lstAdsGroup2}
                            <li style="padding:3px 0px;">--------- <label><input {if $clsAdsGroup->checkAds($lstAdsGroup2[k].ads_group_id,$pvalTable)}checked="checked"{/if} name="lstGroup[]" type="checkbox" value="{$lstAdsGroup2[k].ads_group_id}" /> {$clsAdsGroup->getTitle($lstAdsGroup2[k].ads_group_id)}</label></li>
                            {/section}
                            {/if}
                            {/section}
                        </ul>
                    </fieldset>
                    {/if}
                </div>
         	</div>
         </fieldset>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden" />
        </fieldset>
    </form>
</div>