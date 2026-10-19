<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Recruitment')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Recruit')}{/if}</h2>
        {if $pvalTable}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</a></strong>
            </div>
        </div>
        {/if}
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
                {if $pvalTable}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
                	 <div class="photobox fl mr20 image">
                        <img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
                        <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
                        <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
                        {if $oneItem.image}
                        <a pvalTable="{$pvalTable}" clsTable="Recruit" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
                        {/if}
                    </div>
                    <div class="fl span75">
                    	<div class="row-span">
                        	<div class="fieldlabel bold"><u class="color_r">* {$core->get_Lang('title')}</u></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel bold"><u class="color_r">* {$core->get_Lang('status')}</u></div>
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
                        {if $pvalTable gt 0 and $clsConfiguration->getValue('SiteHasTags_Recruit') eq '1'}
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
                        	<div class="notice">{$core->get_Lang('intro')}</div>
                        	{$clsForm->showInput('intro')}
                        </div>
                    </div>
                </div>
        	</div>
            {if $pvalTable}
            <div class="tabbox" style="display:none">
               {$core->getBlock('meta_box_detail')}
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
var $type = '_RECRUIT';
var $SiteHasTags_Recruit = "{$clsConfiguration->getValue('SiteHasTags_Recruit')}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/recruit/jquery.recruit.js?v={$upd_version}"></script>