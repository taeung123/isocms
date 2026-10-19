<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')} : </strong>
	<a href="{$PCMS_URL}" title="Trang chủ">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Why with us')}?</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$act}">{if $pvalTable}{$core->get_Lang('Edit')}{else}{$core->get_Lang('Add new')}{/if}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('addnew')} {$core->get_Lang('Why with us')}?{/if}</h2>
    </div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="wrap">
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea">
                    <input class="text_32 full-width border_aaa bold required fontLarge" style="padding:5px" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                </div>
            </div>
            {*<div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Type')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea">
                   <select class="text full" name="iso-type" maxlength="255" style="width:200px" >
                       <option value="" {if $clsClassTable->getOneField('type',$pvalTable) eq ''}selected="selected"{/if}>Default</option>
                       <option value="HOME"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'HOME'}selected="selected"{/if}>Home</option>
                       <option value="TOUR"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'TOUR'}selected="selected"{/if}>Tour</option>
                       <option value="DESTINATION"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'DESTINATION'}selected="selected"{/if}>Destination</option>
                       <option value="CRUISE"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'CRUISE'}selected="selected"{/if}>Cruise</option>
                       <option value="HOTEL"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'HOTEL'}selected="selected"{/if}>Hotel</option>
                       <option value="VOUCHER"  {if $clsClassTable->getOneField('type',$pvalTable) eq 'HOTEL'}selected="selected"{/if}>Voucher</option>
				   </select>
                </div>
            </div>*}
            <input type="hidden" name="iso-type" value="HOME">
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Icon')}</strong> <span class="color_r">*</span></div>
                <div class="fieldarea">
                    <img class="isoman_img_pop" id="isoman_show_image" src="{$clsClassTable->getOneField('image',$pvalTable)}" style="width:32px" height="32px" />
					<input type="hidden" id="isoman_hidden_image" value="{$clsClassTable->getOneField('image',$pvalTable)}">
					<input type="text" id="isoman_url_image" name="image" value="{$clsClassTable->getOneField('image',$pvalTable)}" class="text_32 border_aaa ml10" style="width:calc(100% - 80px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="{$clsClassTable->getOneField('image',$pvalTable)}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('status')}</strong></div>
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
                   <div class="coltrols">{$clsForm->showInput($intro)}</div>
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

{literal}
<script type="text/javascript">
$('.changeToStore').live('change',function(){
	var $_this = $(this);
	var type= $_this.attr('_type');
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajUpdateWhyType',
		data:{'_type' : $_this.attr('_type'),'why_id': $_this.attr('data'),'val' : $_this.is(':checked')?1:0},
		dataType:'html',
		success: function(html){
		}
	});
});
</script>
{/literal}