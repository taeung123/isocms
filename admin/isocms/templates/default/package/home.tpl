<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('pricing')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('settingpackage')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Setting Package')} <a class="btn btn-success" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit" title="{$core->get_Lang('Add new')}"> <i class="icon-plus icon-white"></i> <span></span></a></h2>
        <p>Chức năng cài đặt các Package trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function setting Package in isoCMS system')}</p>
    </div>
	<div class="clearfix mb30"></div>
	<div class="content_package">
		<form id="frmSettingPackage" method="post" action="" enctype="multipart/form-data" class="validate-form">
			<fieldset class="box">
				<legend class="label">{$core->get_Lang('box1')}</legend>
				{assign var=title_package_page_1 value=title_package_page_1_|cat:$_LANG_ID}
				{assign var=intro_package_page_1 value=intro_package_page_1_|cat:$_LANG_ID}		
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong></div>
					<div class="fieldarea">
						<input class="text_32 full-width border_aaa bold" name="iso-{$title_package_page_1}" value="{$clsConfiguration->getValue($title_package_page_1)}" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('intro')}</strong></div>
					<div class="fieldarea">
						 <textarea id="textarea_intro_editor_1{$now}" class="textarea_intro_editor" name="iso-{$intro_package_page_1}" style="width:100%">{$clsConfiguration->getValue($intro_package_page_1)}</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('image')}</strong></div>
					<div class="fieldarea">
						<div class="photo relative span50">
							<img src="{$clsConfiguration->getValue('image_package_page_1')}" id="isoman_show_image_package_page_1" class="span100" height="156px" style="width:100%;" />
                                <input type="hidden" id="isoman_hidden_image_package_page_1" name="isoman_url_image_package_page_1" value="{$clsConfiguration->getValue('image_package_page_1')}" />
                                <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image_package_page_1" isoman_val="{$clsConfiguration->getValue('image_package_page_1')}" isoman_name="image_package_page_1" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
						</div>
					</div>
				</div>	
			</fieldset>
			<fieldset class="box">
				<legend class="label">{$core->get_Lang('box2')}</legend>
				{assign var=title_package_page_2 value=title_package_page_2_|cat:$_LANG_ID}
				{assign var=intro_package_page_2 value=intro_package_page_2_|cat:$_LANG_ID}		
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong></div>
					<div class="fieldarea">
						<input class="text_32 full-width border_aaa bold" name="iso-{$title_package_page_2}" value="{$clsConfiguration->getValue($title_package_page_2)}" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('intro')}</strong></div>
					<div class="fieldarea">
						 <textarea id="textarea_intro_editor_2{$now}" class="textarea_intro_editor" name="iso-{$intro_package_page_2}" style="width:100%">{$clsConfiguration->getValue($intro_package_page_2)}</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('image')}</strong></div>
					<div class="fieldarea">
						<div class="photo relative span50">
							<img src="{$clsConfiguration->getValue('image_package_page_2')}" id="isoman_show_image_package_page_2" class="span100" height="156px" style="width:100%;" />
                                <input type="hidden" id="isoman_hidden_image_package_page_2" name="isoman_url_image_package_page_2" value="{$clsConfiguration->getValue('image_package_page_2')}" />
                                <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image_package_page_2" isoman_val="{$clsConfiguration->getValue('image_package_page_2')}" isoman_name="image_package_page_2" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
						</div>
					</div>
				</div>	
			</fieldset>
			<fieldset class="box">
				<legend class="label">{$core->get_Lang('box3')}</legend>
				{assign var=title_package_page_3 value=title_package_page_3_|cat:$_LANG_ID}
				{assign var=intro_package_page_3 value=intro_package_page_3_|cat:$_LANG_ID}		
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong></div>
					<div class="fieldarea">
						<input class="text_32 full-width border_aaa bold" name="iso-{$title_package_page_3}" value="{$clsConfiguration->getValue($title_package_page_3)}" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('intro')}</strong></div>
					<div class="fieldarea">
						 <textarea id="textarea_intro_editor_3{$now}" class="textarea_intro_editor" name="iso-{$intro_package_page_3}" style="width:100%">{$clsConfiguration->getValue($intro_package_page_3)}</textarea>
					</div>
				</div>
				{if 1 eq 2}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('image')}</strong></div>
					<div class="fieldarea">
						<div class="photo relative span50">
							<img src="{$clsConfiguration->getValue('image_package_page_3')}" id="isoman_show_image_package_page_3" class="span100" height="156px" style="width:100%;" />
                                <input type="hidden" id="isoman_hidden_image_package_page_3" name="isoman_url_image_package_page_3" value="{$clsConfiguration->getValue('image_package_page_3')}" />
                                <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image_package_page_3" isoman_val="{$clsConfiguration->getValue('image_package_page_3')}" isoman_name="image_package_page_3" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
						</div>
					</div>
				</div>	
				{/if}
			</fieldset>
			<fieldset class="box">
				<legend class="label">{$core->get_Lang('box4')}</legend>
				{assign var=title_package_page_4 value=title_package_page_4_|cat:$_LANG_ID}
				{assign var=intro_package_page_4 value=intro_package_page_4_|cat:$_LANG_ID}		
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong></div>
					<div class="fieldarea">
						<input class="text_32 full-width border_aaa bold" name="iso-{$title_package_page_4}" value="{$clsConfiguration->getValue($title_package_page_4)}" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('intro')}</strong></div>
					<div class="fieldarea">
						 <textarea id="textarea_intro_editor_4{$now}" class="textarea_intro_editor" name="iso-{$intro_package_page_4}" style="width:100%">{$clsConfiguration->getValue($intro_package_page_4)}</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('image')}</strong></div>
					<div class="fieldarea">
						<div class="photo relative span50">
							<img src="{$clsConfiguration->getValue('image_package_page_4')}" id="isoman_show_image_package_page_4" class="span100" height="156px" style="width:100%;" />
                                <input type="hidden" id="isoman_hidden_image_package_page_4" name="isoman_url_image_package_page_4" value="{$clsConfiguration->getValue('image_package_page_4')}" />
                                <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image_package_page_4" isoman_val="{$clsConfiguration->getValue('image_package_page_4')}" isoman_name="image_package_page_4" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
						</div>
					</div>
				</div>	
			</fieldset>
			<fieldset class="box">
				<legend class="label">{$core->get_Lang('box5')}</legend>
				{assign var=title_package_page_5 value=title_package_page_5_|cat:$_LANG_ID}
				{assign var=intro_package_page_5 value=intro_package_page_5_|cat:$_LANG_ID}		
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong></div>
					<div class="fieldarea">
						<input class="text_32 full-width border_aaa bold" name="iso-{$title_package_page_5}" value="{$clsConfiguration->getValue($title_package_page_5)}" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('intro')}</strong></div>
					<div class="fieldarea">
						 <textarea id="textarea_intro_editor_5{$now}" class="textarea_intro_editor" name="iso-{$intro_package_page_5}" style="width:100%">{$clsConfiguration->getValue($intro_package_page_5)}</textarea>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('image')}</strong></div>
					<div class="fieldarea">
						<div class="photo relative span50">
							<img src="{$clsConfiguration->getValue('image_package_page_5')}" id="isoman_show_image_package_page_5" class="span100" height="156px" style="width:100%;" />
                                <input type="hidden" id="isoman_hidden_image_package_page_5" name="isoman_url_image_package_page_5" value="{$clsConfiguration->getValue('image_package_page_5')}" />
                                <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image_package_page_5" isoman_val="{$clsConfiguration->getValue('image_package_page_5')}" isoman_name="image_package_page_5" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
						</div>
					</div>
				</div>	
			</fieldset>
			<div class="clearfix mt10"></div>
			<fieldset class="submit-buttons">
				{$saveBtn}
				<input value="UpdateConfiguration" name="submit" type="hidden">
			</fieldset>
		</form>
	</div>	
</div>