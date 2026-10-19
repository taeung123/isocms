<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('newscategory')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('newscategory')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('systemmanagementnewscategory')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew btnCreateNewsCat" title="{$core->get_Lang('Add')} {$core->get_Lang('newscategory')}">{$core->get_Lang('Add')} {$core->get_Lang('newscategory')}</a>
					
		</div>
    </div>
	<div class="container-fluid">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="form-group form-keyword">
					<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
				<div class="form-group form-button">
					<a class="btn btn-delete-all" id="btn_delete" clsTable="NewsCategory" style="display:none">
						{$core->get_Lang('Delete')}
					</a>
				</div>
				<div class="fr group_buttons">
					<a href="{$PCMS_URL}/index.php?mod=news" class="btn btn-warning btnNew">
						<i class="icon-list icon-white"></i> <span>{$core->get_Lang('listnews')}</span>
					</a>
				</div>
			</form>	
		</div>
		
		<input id="list_selected_chkitem" style="display:none" value="0" />
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;</td>
					<td width="50%" align="right">
						{$core->get_Lang('Record/page')}:
						{$clsISO->getRecordPerPage($recordPerPage|default:0,$totalRecord|default:0,$mod,$act)}
					</td>
				</tr>
			</table>
		</div>
		<div class="hastable">
			<table cellspacing="0" class="tbl-grid table_responsive" width="100%">
				<thead>
					<tr>
						<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
						<th class="gridheader hiden767"><strong>{$core->get_Lang('index')}</strong></th>
						<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>
						<th class="gridheader hiden_responsive" {if $clsConfiguration->getValue('SiteHasChild_slide')}colspan="2"{/if} style="text-align:left">
							<strong>{$core->get_Lang('stastic')}</strong>
						</th>
						<th class="gridheader hiden_responsive" style="text-align:right"><strong>{$core->get_Lang('update')}</strong></th>
						<th class="gridheader hiden_responsive" style="width:6%"><strong>{$core->get_Lang('status')}</strong></th>
						<th class="gridheader hiden_responsive" style="text-align:center; width:40px;"><strong>{$core->get_Lang('func')}</strong></th>
					</tr>
				</thead>
				{if $allItem[0].newscat_id ne ''}
				<tbody id="SortAble">
					{section name=i loop=$allItem}
					<tr style="cursor:move" id="order_{$allItem[i].newscat_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
						<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].newscat_id}" /></th>
						<th class="index hiden767"> {$smarty.section.i.index+1}</th>
						<td class="name_service">
							<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].newscat_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} <span style="font-size:14px">{$clsClassTable->getTitle($allItem[i].newscat_id)}</span></strong>
							{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
							<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
						</td>
						<td data-title="{$core->get_Lang('stastic')}" class="block_responsive border_top_responsive">
							<a style="margin-right:15px" href="{$PCMS_URL}/index.php?admin&mod=news&newscat_id={$allItem[i].newscat_id}">
								<i class="fa fa-folder-open"></i> {$core->get_Lang('listofnews')} <strong style="color:#c00000;">({$clsClassTable->countItemInCat($allItem[i].newscat_id)})</strong>
							</a>
						</td>
						<td data-title="{$core->get_Lang('update')}" class="block_responsive" style="text-align:right">{$clsClassTable->getOneField('upd_date',$allItem[i].newscat_id)|date_format:"%m-%d-%Y %H:%M"}</td>
						<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
							<a href="javascript:void(0);" class="SiteClickPublic" clsTable="NewsCategory" pkey="newscat_id" sourse_id="{$allItem[i].newscat_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].newscat_id)}" title="{$core->get_Lang('Click to change status')}">
								{if $clsClassTable->getOneField('is_online',$allItem[i].newscat_id) eq '1'}
								<i class="fa-solid fa-circle-check green"></i>
								{else}
								<i class="fa-solid fa-circle-minus red"></i>
								{/if}
							</a>
						</td>
						<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="icon-cog"></i> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									{if $allItem[i].is_trash eq '0'}
										<li>
											<a href="javascript:void(0);" class="dropdown-item btnEditNewsCat" data="{$allItem[i].newscat_id}" title="{$core->get_Lang('Edit')}">
												<i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span>
											</a>
										</li>
										<li>
											<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&newscat_id={$core->encryptID($allItem[i].newscat_id)}" class="dropdown-item" title="{$core->get_Lang('Trash')}">
												<i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span>
											</a>
										</li>
									{else}
										<li>
											<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&newscat_id={$core->encryptID($allItem[i].newscat_id)}" class="dropdown-item" title="{$core->get_Lang('restore')}">
												<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
											</a>
										</li>
										<li>
											<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&newscat_id={$core->encryptID($allItem[i].newscat_id)}" class="dropdown-item confirm_delete" title="{$core->get_Lang('Delete')}">
												<i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span>
											</a>
										</li>
									{/if}
								</ul>
							</div>
						</td>
					</tr>
					{/section}
				</tbody>
				{/if}
			</table>  
			<div class="statistical mt5">
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord|default:0}</strong> {$core->get_Lang('records')}/<strong>{$totalPage|default:0}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
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
</div>
<script type="text/javascript">
var $SiteHasCat_News = "{$clsConfiguration->getValue('SiteHasCat_News')}";
</script>

<script type="text/javascript">
	var $recordPerPage = `{$recordPerPage|default:0}`;
	var $currentPage = `{$currentPage|default:0}`;
</script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var recordPerPage = $recordPerPage;
			var currentPage = $currentPage;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListNewsCat", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/news/jquery.news.js?v={$upd_version}"></script>