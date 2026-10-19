<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a title="{$core->get_Lang('Setting')}">{$core->get_Lang('Setting')}</a>
	<a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$core->get_Lang('Activities')}"> {$core->get_Lang('Activities')}</a>
	<a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Activities')}{/if}</h2>
        <p>{$core->get_Lang('Please enter all required fields')}</p>
    </div>
    <div class="clearfix"><br /></div>
    <div id="clienttabs">
        <ul>
            <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
        </ul>
    </div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="tab_content">
            <div class="tabbox" style="display:block">
            	<div class="fl col_Left full_width_767">
                    <div class="photobox image">
                        {if $_isoman_use eq '1'}
                        <img src="{$clsClassTable->getImage($pvalTable,300,200)}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
                        <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
                        <a href="javascript:void()" title="{$core->get_Lang('edit')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
                        {if $oneItem.image}
                        <a pvalTable="{$pvalTable}" clsTable="Activities" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
                        {/if}
                        {else}
                        <img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
                        <input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
                        <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
                            <i class="iso-edit"></i>
                        </a> 
                        <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
                        {/if}
                    </div>
					<div class="cleafix"></div>
					<h3 class="mt10 text-left small">{$core->get_Lang('Image Size')} (WxH=300x200)</h3>
                </div>
                <div class="fl col_Right full_width_767">
                    <div class="span100">
                        <div class="row-span">
							 <div class="fieldlabel"><strong>{$core->get_Lang('Title')}</strong> <span class="requiredMask">*</span> </strong></div>
							 <div class="fieldarea">
							 	<input class="text_32 full-width border_aaa bold required fontLarge title_capitalize" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
							 </div>
                        </div>
                    </div>
					<div class="row-span">
                        <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong></div>
                        <div class="fieldarea">
                        	<div class="vietiso_status_button"></div>
							<script type="text/javascript">
								var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
							</script>
							{literal}
							<script type="text/javascript">
								$(document).ready(function(){
									$('.vietiso_status_button').isoswitchvalue({
										_value:is_online,
										_selector:'iso-is_online'
									});
								});
							</script>
							{/literal}
							<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
							<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
                        </div>
                    </div>
                </div>
                <div class="wrap mt30">
					{if $clsISO->getBrowser() eq 'computer'}
					<div id="v-nav">
						<ul>
							<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Short text')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Long text')}</strong></a> <span class="color_r">*</span></li>
						</ul>
						<div class="tab-content" style="display: block;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('content')}
							</div>
						</div>
					</div>
					{else}
					<div id="v-nav">
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Short text')}</strong></div>
							<div class="fieldarea">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Long text')}</strong></div>
							<div class="fieldarea">
								 {$clsForm->showInput('content')}
							</div>
						</div>
					</div>
					{/if}
            	</div>
			</div>
            <div class="clearfix"></div>
    	</div>
        <br class="clearfix" />
        <fieldset class="submit-buttons">
            {$saveBtn} {$saveList}
            <input value="Update" name="submit" type="hidden" />
        </fieldset>
	</form>
</div>