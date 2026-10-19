<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Meta Tags')}">{$core->get_Lang('Meta Tags')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Meta Tags')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Meta Tags')} trong hệ thống isoCMS">i</div>
			</h2>
			{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
			{if $clsConfiguration->getValue($setting) ne ''}
			<p>{$clsConfiguration->getValue($setting)}</p>
			{/if}
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_meta" title="{$core->get_Lang('Add Meta Tags')}">{$core->get_Lang('Add Meta Tags')}</a>
			<div class="btn btn-setting"><a href="{$PCMS_URL}/?mod={$mod}&act=setting" title="{$core->get_Lang('Setting')}"><i class="fa fa-cog" aria-hidden="true"></i></a></div>
		</div>
    </div>
	<div class="container-fluid">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="form-group form-keyword">
					<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
			</form>	
		</div>			
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
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
		<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<th class="gridheader hiden767"><strong>{$core->get_Lang('index')}</strong></th>
					<th class="gridheader name_responsive full-w767" style="text-align:left;"><strong>{$core->get_Lang('link')}</strong></th>
					<th class="gridheader hidden767" style="width:250px;"><strong>{$core->get_Lang('length')}</strong></th>
					<th class="gridheader hidden767" style="text-align:center; width:40px;"><strong>{$core->get_Lang('func')}</strong></th>
				</tr>
			</thead>
			{if $allItem[0].meta_id eq ''}
			<tr>
				<td colspan="5" style="text-align:center">{$core->get_Lang('No Data')} !</td>
			</tr>
			{else}
			{section name=i loop=$allItem}
			<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<td class="index hiden767">{$smarty.section.i.index+1}</td>
				<td class="name_service title_td1">							
					<a title="Edit" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&meta_id={$core->encryptID($allItem[i].meta_id)}{$pUrl}">
					   <strong>{$clsClassTable->getOneField('config_link',$allItem[i].meta_id)}</strong>
					</a>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">[In Trash]</span>{/if}
					<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
				</td>
				<td class="block_responsive" data-title="{$core->get_Lang('length')}" style="text-align:right">
					{$core->get_Lang('Title')}: {$clsClassTable->getStatus('title',$allItem[i].meta_id)}&nbsp;|&nbsp;{$core->get_Lang('Description')}: {$clsClassTable->getStatus('description',$allItem[i].meta_id)}&nbsp;|&nbsp;{$core->get_Lang('Keyword')}: {$clsClassTable->getStatus('keyword',$allItem[i].meta_id)}
				</td>
				<td class="block_responsive" data-title="{$core->get_Lang('func')}" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							{if $allItem[i].is_trash eq '0'}
								<li>
									<a href="{$DOMAIN_NAME}{$clsClassTable->getConfigLink($allItem[i].meta_id)}{$pUrl}" target="_blank" class="dropdown-item" title="{$core->get_Lang('View')}">
										<i class="icon-eye-open"></i> {$core->get_Lang('view')}
									</a>
								</li>
								<li>
									<a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&meta_id={$core->encryptID($allItem[i].meta_id)}{$pUrl}" class="dropdown-item" title="{$core->get_Lang('Edit')}">
										<i class="icon-edit"></i> {$core->get_Lang('edit')}
									</a>
								</li>
								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=trash&meta_id={$core->encryptID($allItem[i].meta_id)}{$pUrl}&page={$currentPage}" class="dropdown-item" title="{$core->get_Lang('Trash')}">
										<i class="icon-trash"></i> {$core->get_Lang('trash')}
									</a>
								</li>
							{else}
								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=restore&meta_id={$core->encryptID($allItem[i].meta_id)}{$pUrl}&page={$currentPage}" class="dropdown-item" title="{$core->get_Lang('Restore')}">
										<i class="icon-refresh"></i> {$core->get_Lang('restore')}
									</a>
								</li>
								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=delete&meta_id={$core->encryptID($allItem[i].meta_id)}{$pUrl}&page={$currentPage}" class="dropdown-item confirm_delete" title="{$core->get_Lang('Delete')}">
										<i class="icon-remove"></i> {$core->get_Lang('delete')}
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
<script type="text/javascript" src="{$URL_THEMES}/meta/jquery.meta.new.js?v={$upd_version}"></script>