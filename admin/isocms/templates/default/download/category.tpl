<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('news')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{$core->get_Lang('downloadcategory')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
{if $msg eq 'DeleteFailed'}
<div style="padding:15px; padding-top:0;">
	<div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; ">
		<img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
		<strong>{$core->get_Lang('warning')}:</strong> {$core->get_Lang('exitsposts')}
	</div>
</div>
<div class="clearfix"></div>
{/if}
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('downloadcategory')} <a class="btn btn-success btnCreateNewsCat" title="{$core->get_Lang('add')}"><i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('systemmanagementdownloadcategory')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="forums" method="post" class="filterForm" action="">
        <div class="ui-action">
            <div class="wrap">
                <div class="fl fiterbox">
                    <div class="wrap">
                        <div class="searchbox" style="float:left !important; width:100%">
                            <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
                            <a class="btn btn-success" href="javascript:void();" id="searchbtn" style=" padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                            <a href="{$PCMS_URL}/index.php?mod=download" class="btn btn-warning">
                            	<i class="icon-list icon-white"></i> <span>{$core->get_Lang('listdownload')}</span>
                            </a>
                             <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="NewsCategory" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <input id="list_selected_chkitem" style="display:none" value="0" />
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
				<td width="50%" align="right">
					{$core->get_Lang('gotopage')}:
					<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
						{section name=i loop=$listPageNumber}
						<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
						{/section}
					</select>
				</td>
			</tr>
		</table>
	</div>
	<div class="hastable">
		<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<tr>
				<td class="gridheader"><input id="check_all" type="checkbox" /></td>
				<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
				<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
				<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('stastic')}</strong></td>
				<td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('update')}</strong></td>
				<td class="gridheader" style="width:6%"><strong>{$core->get_Lang('status')}</strong></td>
				<td class="gridheader" style="width:3%" colspan="4"><strong>{$core->get_Lang('move')}</strong></td>
				<td class="gridheader" style="text-align:center; width:40px;"><strong>{$core->get_Lang('func')}</strong></td>
			</tr>
			{if $allItem[0].downloadcat_id ne ''}
			{section name=i loop=$allItem}
			<tr class="{cycle values="row1,row2"}">
				<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].downloadcat_id}" /></td>
				<td class="index"> {$smarty.section.i.index+1}</td>
				<td>
					<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].downloadcat_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} <span style="font-size:14px">{$clsClassTable->getTitle($allItem[i].downloadcat_id)}</span></strong>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
				</td>
				<td>
                	<a style="margin-right:15px" href="{$PCMS_URL}/index.php?admin&mod=download&downloadcat_id={$allItem[i].downloadcat_id}">
						<i class="fa fa-folder-open"></i> {$core->get_Lang('listofdownload')} <strong style="color:#c00000;">({$clsClassTable->countItemInCat($allItem[i].downloadcat_id)})</strong>
                    </a>
                </td>
				<td style="text-align:right">{$clsClassTable->getOneField('upd_date',$allItem[i].downloadcat_id)|date_format:"%m-%d-%Y %H:%M"}</td>
				<td style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="DownloadCat" pkey="downloadcat_id" sourse_id="{$allItem[i].downloadcat_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].downloadcat_id)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_online',$allItem[i].downloadcat_id) eq '1'}
						<i class="fa-solid fa-circle-check green"></i>
						{else}
						<i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
				<td style="vertical-align: middle;text-align:center">
					{if !$smarty.section.i.first}
					<a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movetop&downloadcat_id={$core->encryptID($allItem[i].downloadcat_id)}"><i class="icon-circle-arrow-up"></i></a>
					{/if}
				</td>
				<td style="vertical-align: middle;text-align:center">
					{if !$smarty.section.i.last}
					<a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movebottom&downloadcat_id={$core->encryptID($allItem[i].downloadcat_id)}"><i class="icon-circle-arrow-down"></i></a>
					{/if}
				</td>
				<td style="vertical-align: middle;text-align:center">
					{if !$smarty.section.i.first}
					<a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=moveup&downloadcat_id={$core->encryptID($allItem[i].downloadcat_id)}"><i class="icon-arrow-up"></i></a>
					{/if}
				</td>
				<td style="vertical-align: middle;text-align:center">
					{if !$smarty.section.i.last}
					<a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&action=move&direct=movedown&downloadcat_id={$core->encryptID($allItem[i].downloadcat_id)}"><i class="icon-arrow-down"></i></a>
					{/if}
				</td>
				<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu" style="right:0px !important">
							{if $allItem[i].is_trash eq '0'}
								<li>
									<a class="btnEditNewsCat" title="{$core->get_Lang('Edit')}" href="javascript:void();" data="{$allItem[i].downloadcat_id}">
										<i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span>
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('Trash')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&downloadcat_id={$core->encryptID($allItem[i].downloadcat_id)}">
										<i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span>
									</a>
								</li>
							{else}
								<li>
									<a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&downloadcat_id={$core->encryptID($allItem[i].downloadcat_id)}">
										<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('Delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&downloadcat_id={$core->encryptID($allItem[i].downloadcat_id)}">
										<i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span>
									</a>
								</li>
							{/if}
						</ul>
					</div>
				</td>
			</tr>
			{/section}
			{/if}
		</table>  
		<div class="statistical mt5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
					<td width="50%" align="right">
						{$core->get_Lang('gotopage')}:
						<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
							{section name=i loop=$listPageNumber}
							<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
							{/section}
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$URL_THEMES}/download/jquery.download.js?v={$upd_version}"></script>