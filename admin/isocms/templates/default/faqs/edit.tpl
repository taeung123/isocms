<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('faqs')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Faqs')}{/if}</h2>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
            	{if $pvalTable && $clsConfiguration->getValue('SiteHasDetail_FAQ')}
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
                <li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>
                {/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('question')}?</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<input class="text_32 full-width border_aaa bold required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
						</div>
					</div>
					{if $clsConfiguration->getValue('SiteHasCat_FAQ') and 1 eq 2}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('category')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							<select name="iso-faqcat_id" class="slb required" style="width:300px;padding:4px">
								{$clsFAQCategory->makeSelectboxOption($oneItem.faqcat_id)}
							</select>
						</div>
					</div>
					{/if}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span  class="color_r">*</span></div>
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
						<div class="fieldlabel"><strong>{$core->get_Lang('Answers')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							{$clsForm->showInput('content')}
						</div>
					</div>
                </div>
        	</div>
            {if $pvalTable && $clsConfiguration->getValue('SiteHasDetail_FAQ')}
            <div class="tabbox" style="display:none">
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Title')}:</div>
                    <div class="coltrols">
                        <input class="text full" name="config_value_title" value="{$clsISO->getPageTitle($pvalTable,FAQ)}" maxlength="255" type="text">
                        <div class="clearfix mt5"></div>
                        <i>{$core->get_Lang('notetitlemeta')}</i>
                    </div>
                </div>
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Description')}:</div>
                    <div class="coltrols">
                        <textarea name="config_value_intro" class="text full" style="height:60px">{$clsISO->getPageDescription($pvalTable,FAQ)}</textarea>
                        <div class="clearfix mt5"></div>
                        <i>{$core->get_Lang('noteintrometa')}</i>
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
var $type = '_FAQS';
var $SiteHasTags_Faqs = "{$clsConfiguration->getValue('SiteHasTags_Faqs')}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/faqs/jquery.faqs.js?v={$upd_version}"></script>