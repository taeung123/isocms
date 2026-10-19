<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$mod|capitalize}</a>
    <a>&raquo;</a>
	 <a href="{$curl}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Partner')} &raquo; <span class="color_r">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</span></h2>
       <p>{$core->get_Lang('Partner Management')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">* </span></div>
				<div class="fieldarea">
					<input class="text fontLarge full required" name="iso-title" value="{$oneTable.title}" maxlength="255" type="text">
					<span class="notice-full">
                    {$core->get_Lang('Each partner is the only one and can not be duplicated')}
                   </span>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('Image')}</strong> <span class="color_r">* </span></div>
				<div class="fieldarea">
					<img class="isoman_img_pop" id="isoman_show_image" src="{$clsClassTable->getOneField('image',$pvalTable)}" />
					<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$clsClassTable->getOneField('image',$pvalTable)}">
					<input style="width:calc(100% - 80px) !important; float:left; margin-left:4px; height:32px; line-height:32px; padding:0" type="text" id="isoman_url_image" name="image" value="{$clsClassTable->getOneField('image',$pvalTable)}" ><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="{$clsClassTable->getOneField('image',$pvalTable)}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</div>
			</div>
			
			<div class="row-span">
				<div class="fieldlabel"> <strong>{$core->get_Lang('Status')}</strong></div>
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
			<div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang("Path Url")}</strong> <span class="color_r">* </span></div>
				<div class="fieldarea">
					<input class="text full required" name="iso-url" value="{$oneTable.url}" maxlength="255" type="text">
				</div>
			</div>
			<div class="clearfix"><br /></div>
			<fieldset class="submit-buttons">
				{$button_update}{$saveList}{$resetBtn}
				<input value="Update" name="submit" type="hidden">
			</fieldset>
		</div>
    </form>
</div>