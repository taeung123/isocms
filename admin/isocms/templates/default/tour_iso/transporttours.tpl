<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('transport')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
		<h2>{$core->get_Lang('transport')} <a class="btn btn-success btnCreateService" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
		<p>{$core->get_Lang('System management transport tours')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="forums" method="post" class="filterForm" action="">
		<div class="filterbox">
			<div class="wrap">
				<div class="searchbox" style="float:left !important; width:100%">
					<input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
					<a class="btn btn-success" href="javascript:void();" id="searchbtn" style="padding:5px">
						<i class="icon-search icon-white"></i>
					</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="TourService" style="display:none"> <i class="icon-remove icon-white"></i><span>{$core->get_Lang('Delete Options')}</span> </a>
				</div>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
    </form>
	<div class="clearfix"><br /></div>
    <input id="list_selected_chkitem" style="display:none" value="0" />
    <div class="wrap">
    	<div class="hastable">
        	<table cellspacing="0" class="tbl-grid" width="100%">
                <tr>
                	<td class="gridheader"><input id="check_all" type="checkbox" /></td>
                    <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                    <td class="gridheader"></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameoftransport')}</strong></td>
                    <td class="gridheader" style="width:6%"><strong>{$core->get_Lang('status')}</strong></td>
                    <td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>
                    <td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></td>
                </tr>
                {if $allItem[1].tourtransport_id ne ''}
                {section name=i loop=$allItem}
                 <tr class="{cycle values="row1,row2"}">
                	<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].tourtransport_id}" /></td>
                    <td class="index"> {$smarty.section.i.index+1}</td>
                    <td class="index">
                    	{if $clsClassTable->getImageUrl($allItem[i].tourtransport_id)}
                    	<img src="{$clsClassTable->getImageUrl($allItem[i].tourtransport_id)}" width="40" />
                        {/if}
                    </td>
                    <td>
                    	{$clsClassTable->getTitle($allItem[i].tourtransport_id)}
                    	{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                    </td>
                  
                    <td style="text-align:center">
                        <a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourTransport" pkey="tourtransport_id" sourse_id="{$allItem[i].tourtransport_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].tourtransport_id)}" title="{$core->get_Lang('Click to change status')}">
                            {if $clsClassTable->getOneField('is_online',$allItem[i].tourtransport_id) eq '1'}
                            <i class="fa-solid fa-circle-check green"></i>
                            {else}
                            <i class="fa-solid fa-circle-minus red"></i>
                            {/if}
                        </a>
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movetop&tourtransport_id={$core->encryptID($allItem[i].tourtransport_id)}"><i class="icon-circle-arrow-up"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movebottom&tourtransport_id={$core->encryptID($allItem[i].tourtransport_id)}"><i class="icon-circle-arrow-down"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=moveup&tourtransport_id={$core->encryptID($allItem[i].tourtransport_id)}"><i class="icon-arrow-up"></i></a>
                        {/if}
                    </td>
                    <td style="vertical-align: middle;text-align:center">
                        {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movedown&tourtransport_id={$core->encryptID($allItem[i].tourtransport_id)}"><i class="icon-arrow-down"></i></a>
                        {/if}
                    </td>
                    <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0px !important">
								{if $allItem[i].is_trash eq '0'}
								<li><a class="btn_edit_service" title="{$core->get_Lang('edit')}" href="javascript:void();" data="{$allItem[i].tourtransport_id}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
								<li><a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&tourtransport_id={$core->encryptID($allItem[i].tourtransport_id)}"><i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a></li>
								{else}
								<li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&tourtransport_id={$core->encryptID($allItem[i].tourtransport_id)}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
								<li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&tourtransport_id={$core->encryptID($allItem[i].tourtransport_id)}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
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
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.transport.js"></script>