<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Popup')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')}#{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit Popup')}{else}{$core->get_Lang('Add New Popup')}{/if}</h2>
    </div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="wrap">
            <div class="row-field">
				<div class="row-heading">{$core->get_Lang('Image')} (w=1265 x h=600)</div>
				<div class="controls">
					<div class="photobox span98" style="height:195px !important">
						<img src="{$oneTable.image}" alt="{$core->get_Lang('No image')}"  id="isoman_show_image" class="span100"  style="width:100%; height:194px !important" />
						<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneTable.image}" />
						<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneTable.image}" isoman_name="image" title="Chọn ảnh bài viết"><i class="iso-edit"></i></a>
						{if $oneTable.image}
						<a pvalTable="{$pvalTable}" clsTable="Popup" href="javascript:void()" title="Xóa" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
						{/if}
					</div>
				</div>
			</div>
            <fieldset style="min-height:254px">
				<legend>{$core->get_Lang('Popup information')}</legend>
				<div class="row-span">
					<div class="fieldlabel bold">{$core->get_Lang('Title')}<span class="color_r">*</span></div>
					<div class="fieldarea">
						<input class="text full input_32_aaa fontLarge" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
					</div>
				</div>
				<div class="row-span"> 
				<div class="fieldlabel bold">{$core->get_Lang('Select Type')}</div> 
					<div class="fieldarea"> 
						<select name="iso-type_link" id="type_link" style="width:200px; padding:4px;"> 
							<option {if $oneTable.type_link eq 'INTERNAL'} selected="selected" {/if} value="INTERNAL">-- {$core->get_Lang('Link to internal page')} --</option> 
							<option {if $oneTable.type_link eq 'LINK'} selected="selected" {/if} value="LINK">-- {$core->get_Lang('Link to another page')} --</option> 
						</select> 
					</div> 
				</div>
				<div class="row-span" id="INTERNAL">
					<div class="fieldlabel bold">{$core->get_Lang('Link')}<span class="color_r">*</span></div>
					 <div class="fieldarea ">
							 <label style="display:inline-block; width:225px; line-height:32px;">{$DOMAIN_NAME}/</label><input  class="text full input_32_aaa" name="iso-link_internal" style="width:calc(100% - 225px);float:right" value="{$oneTable.link_internal}" maxlength="255" type="text">
					</div>
				</div>
				<div class="row-span" id="LINK">
					<div class="fieldlabel bold">{$core->get_Lang('Link')}<span class="color_r">*</span></div>
					 <div class="fieldarea ">
							 <input  class="text full input_32_aaa" name="iso-link_another" value="{$oneTable.link_another}" maxlength="255" type="text">
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel bold">{$core->get_Lang('Name button')}<span class="color_r">*</span></div>
					<div class="fieldarea">
						<input class="text full input_32_aaa" name="iso-name_button" value="{$clsClassTable->getNameButton($pvalTable)}" maxlength="255" type="text">
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel bold">{$core->get_Lang('Status')}</div>
					<div class="fieldarea">
						<div class="vietiso_status_button"></div>
						<span class="notice-short mt5" style="display:none" id="prv_status">PRIVATE: {$core->get_Lang('This Popup can only be seen via the link in the admin page')}.</span>
						<span class="notice-short mt5" id="pub_status">PUBLIC: {$core->get_Lang('This Popup is available online show normal status')}</span>
					</div>
					<script type="text/javascript">
						var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
					</script>
					{literal}
					<script type="text/javascript">
						$(document).ready(function () {
							$('.vietiso_status_button').isoswitchvalue({
								_value: is_online,
								_selector: 'iso-is_online'
							});
						});
					</script>
					{/literal}       
				</div>
				<div class="row-span">
					<div class="fieldlabel bold">{$core->get_Lang('Intro popup')}</div>
					<div class="fieldarea">
						<div class="tab-content">
						{$clsForm->showInput('intro')}
						</div>
					</div>
				</div>
			</fieldset>
            {if $pvalTable ne ''}
            <div style="width:100%;float:left;margin-top:10px; display:none">
            		<fieldset>
					<legend>{$core->get_Lang('Style popup')}</legend>
                    <textarea class="full" rows="5" name="iso-style">{$oneTable.style}</textarea>
                    </fieldset>
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
{literal}
<script type="text/javascript">
	$(document).ready(function () {
		loadTypeLink();
		$(document).on('change', '#type_link', function(ev) {
			loadTypeLink();
		});
	});
	function loadTypeLink() {
		var type_link = $('#type_link').val();
		if (type_link == 'LINK') {
			$('#LINK').show();
			$('#INTERNAL').hide();
		} else{
			$('#LINK').hide();
			$('#INTERNAL').show();
		}
	}
</script>
{/literal}    