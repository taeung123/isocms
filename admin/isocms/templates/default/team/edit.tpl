<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('our team')}</a>
    <a>&raquo;</a>
    <a href="{$curl|default:''}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$oneTable.name}{else}{$core->get_Lang('Add New Team')}{/if}</h2>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
					<div class="fl col_Left">
						<div class="photobox image full_width_767">
							<img src="{$oneTable.image|default:''}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneTable.image|default:''}" />
							<a href="javascript:void()" title="{$core->get_Lang('edit')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneTable.image|default:''}" isoman_name="image"><i class="iso-edit"></i></a>
							{if $oneTable.image}
							<a pvalTable="{$pvalTable|default:0}" clsTable="Team" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
							{/if}
						</div>
                        <h3 class="mt10">Image (WxH=298x298px)</h3>
					</div>
                	 
                    <div class="fl col_Right full_width_767">
                    	<div class="row-span">
                        	<div class="fieldlabel bold">{$core->get_Lang('Name')} <span class="color_r">*</span></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="name" value="{$oneTable.name|default:''}" maxlength="255" type="text">
                            </div>
                        </div>
                        <div class="row-span">
                        	<div class="fieldlabel bold">{$core->get_Lang('Position')} <span class="color_r">*</span></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="iso-position" value="{$oneTable.position|default:''}" maxlength="255" type="text">
                            </div>
                        </div>
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
                        <div class="row-span">
                        	<div class="notice bold">{$core->get_Lang('content')}</div>
                        	{$clsForm->showInput('content')}
                        </div>
                    </div>
                </div>
        	</div>
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>