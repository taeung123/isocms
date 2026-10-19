<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('faqs')}">{$core->get_Lang('feature package')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$core->get_Lang('faqscategory')}">{$core->get_Lang('featurecategory')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
{if $msg eq 'DeleteFailed'}
<div style="padding:15px; padding-top:0;">
	<div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; ">
    	<img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
		<strong>{$core->get_Lang('Warning')}.</span>:</strong> {$core->get_Lang('identicalposts')}!
	</div>
</div>
<div class="clearfix"></div>
{/if}
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('featurecategory')} <a class="btn btn-success btnCreateFeaturePackageCat" href="javascript:void(0);" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('systemmanagementFeatureCat')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="forums" method="post" class="filterForm" action="">
        <div class="ui-action">
            <div class="wrap">
                <div class="fl fiterbox">
                    <div class="wrap">
                        <div class="searchbox" style="float:left !important; width:100%">
                            <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
                            <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                            <a href="{$PCMS_URL}/index.php?mod=featurepackage" class="btn btn-warning">
                            	<i class="icon-list icon-white"></i> <span>{$core->get_Lang('listFeature')}</span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="FeaturePackageCat" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <input id="list_selected_chkitem" style="display:none" value="0" />
    <div class="wrap">
    	<div class="hastable">
        	<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
                <tr>
                	<td class="gridheader"><input id="check_all" type="checkbox" /></td>
                    <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('listFeature')}</strong></td>
					<td class="gridheader"><strong>{$core->get_Lang('update')}</strong></td>
                    <td class="gridheader" style="width:6%"><strong>{$core->get_Lang('status')}</strong></td>
                    <td class="gridheader" colspan="4" style="width:12%"><strong>{$core->get_Lang('move')}</strong></td>
                    <td class="gridheader" style="text-align:center; width:40px;"><strong>{$core->get_Lang('func')}</strong></td>
                </tr>
                {if $allItem[0].feature_package_cat_id ne ''}
                {section name=i loop=$allItem}
                <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                	<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].feature_package_cat_id}" /></td>
                    <td class="index"> {$smarty.section.i.index+1}</td>
                    <td>
                    	<strong style="font-size:14px;">{$clsClassTable->getTitle($allItem[i].feature_package_cat_id)}</strong>
                    	{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                    </td>
                    <td>
                        <a href="{$PCMS_URL}/index.php?admin&mod=faqs&feature_package_cat_id={$allItem[i].feature_package_cat_id}">
                        	<i class="fa fa-folder-open"></i> {$core->get_Lang('listFeature')} <strong style="color:#c00000;"> ({$clsClassTable->countItemInCat($allItem[i].feature_package_cat_id)})</strong>
                        </a>
                    </td>
					<td style="text-align:right">{$clsClassTable->getOneField('upd_date',$allItem[i].feature_package_cat_id)|date_format:"%m-%d-%Y %H:%M"}</td>
                    <td style="text-align:center">
                        <a href="javascript:void(0);" class="SiteClickPublic" clsTable="FAQCategory" pkey="feature_package_cat_id" sourse_id="{$allItem[i].feature_package_cat_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].feature_package_cat_id)}" title="{$core->get_Lang('Click to change status')}">
                            {if $clsClassTable->getOneField('is_online',$allItem[i].feature_package_cat_id) eq '1'}
                            <i class="fa-solid fa-circle-check green"></i>
                            {else}
                            <i class="fa-solid fa-circle-minus red"></i>
                            {/if}
                        </a>
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movetop&feature_package_cat_id={$core->encryptID($allItem[i].feature_package_cat_id)}"><i class="icon-circle-arrow-up"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movebottom&feature_package_cat_id={$core->encryptID($allItem[i].feature_package_cat_id)}"><i class="icon-circle-arrow-down"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=moveup&feature_package_cat_id={$core->encryptID($allItem[i].feature_package_cat_id)}"><i class="icon-arrow-up"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movedown&feature_package_cat_id={$core->encryptID($allItem[i].feature_package_cat_id)}"><i class="icon-arrow-down"></i></a>
                        {/if}
                    </td>
                    <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                        <div class="btn-group">
                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>
                            <ul class="dropdown-menu" style="right:0px !important">
                                {if $allItem[i].is_trash eq '0'}
                                <li><a class="btnEditFeaturePackageCat" title="{$core->get_Lang('edit')}" href="javascript:void();" data="{$allItem[i].feature_package_cat_id}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
                                <li><a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=cat&action=Trash&feature_package_cat_id={$core->encryptID($allItem[i].feature_package_cat_id)}"><i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a></li>
                                {else}
                                <li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=cat&action=Restore&feature_package_cat_id={$core->encryptID($allItem[i].feature_package_cat_id)}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
                                <li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=cat&action=Delete&feature_package_cat_id={$core->encryptID($allItem[i].feature_package_cat_id)}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
                                {/if}
                            </ul>
                        </div>
                    </td>
                </tr>
                {/section}
                {/if}
            </table>  
			<div class="clearfix" style="height:5px"></div>
			<div class="pagination_box">
				<div class="wrap holderEvent_tbl" id="dataTable_paginate"> 
					<!-- Ajax Loading pagination --> 
				</div>
			</div> 
        </div>
    </div>
</div>
<script type="text/javascript">
var $SiteHasCat_FAQ = "{$clsConfiguration->getValue('SiteHasCat_FAQ')}";
</script>
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$URL_THEMES}/featurepackage/jquery.featurepackage.js?v={$upd_version}"></script>