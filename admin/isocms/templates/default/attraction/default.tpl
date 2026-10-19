{if $clsConfiguration->getValue('SiteActiveCat_attraction') eq 1}
<div id="tabs" class="secondTab">
   <ul style="float:right;">
        <li class="activetab2"><a href="{$PCMS_URL}/?&mod=attraction&country_id={$country_id}"><span>{$core->get_Lang('')}</span></a></li>
        <li><a class="current" href="{$PCMS_URL}/?&mod=attraction&act=cat"><span>{$core->get_Lang('category')}</span></a></li>
    </ul>
</div>
{/if}
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
	<a>&raquo;</a>
	<a href="javascript:void(0)">{$core->get_Lang('Attraction')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Attraction')}<a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('System Management Attraction')}</p>
    </div>
	<div class="clearfix"><br /></div>
    <form id="forums" method="post" class="filterForm" action="">
        <div class="fiterbox">
            <div class="wrap">
                <div class="searchbox">
                	{if $clsConfiguration->getValue('SiteActive_city')}
                	<select name="city_id" onchange="_reload();" style="min-width:150px; font-size:14px; padding:3px" class="slb">
						{$clsCity->getSelectCity($country_id, 0, $city_id)}
                    </select>
                	{/if}
                    <input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                    <a class="btn btn-success" href="javascript:void();" id="searchbtn" style="padding:5px">
                        <i class="icon-search icon-white"></i>
                    </a>
                </div>
            </div>
		</div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <div class="clearfix"></div>
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
				<td width="50%" align="right">
					{$core->get_Lang('gotopage')}:
					<select name="page" class="gotopage">
						{section name=i loop=$listPageNumber}
						<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
						{/section}
					</select>
					<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Attraction" style="display:none">
						<i class="icon-remove icon-white"></i>
						<span>{$core->get_Lang('Delete Options')}</span>
					</a>
				</td>
			</tr>
		</table>
	</div>
	<div class="hastable">
		<table cellspacing="0" class="tbl-grid full-width table-striped table_responsive">
			<tr>
				<td class="gridheader"><input id="check_all" type="checkbox" /></td>
				<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
				<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                <td class="gridheader" style="width:6%;"><strong>{$core->get_Lang('status')}</strong></td>
				<td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
			</tr>
			{if $allItem[0].attraction_id ne ''}
			<tbody id="SortAble">
				{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].attraction_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].attraction_id}" /></td>
					<td class="index">{$smarty.section.i.index+1}</td>
					<td>
					<strong style="font-size:16px">{if $clsClassTable->getOneField('is_online',$allItem[i].attraction_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].attraction_id)}</strong>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
					</td>
					<td style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Attraction" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
						<i class="fa-solid fa-circle-check green"></i>
						{else}
						<i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="dropdown">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">
								{if $allItem[i].is_trash eq '0'}

								<li>
									<a class="dropdown-item"
									href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].attraction_id)}"
									target="_blank"
									title="{$core->get_Lang('view')}">
										<i class="icon-eye-open"></i> {$core->get_Lang('view')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('edit')}"
									href="{$PCMS_URL}/?mod={$mod}&act=edit&attraction_id={$core->encryptID($allItem[i].attraction_id)}{if $parent_id}&parent_id={$allItem[i].parent_id}{/if}{$pUrl}">
										<i class="icon-edit"></i> {$core->get_Lang('edit')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('trash')}"
									href="{$PCMS_URL}/?mod={$mod}&act=trash&attraction_id={$core->encryptID($allItem[i].attraction_id)}{$pUrl}">
										<i class="icon-trash"></i> {$core->get_Lang('trash')}
									</a>
								</li>

								{else}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('restore')}"
									href="{$PCMS_URL}/?mod={$mod}&act=restore&attraction_id={$core->encryptID($allItem[i].attraction_id)}{$pUrl}">
										<i class="icon-refresh"></i> {$core->get_Lang('restore')}
									</a>
								</li>

								<li>
									<a class="dropdown-item confirm_delete"
									title="{$core->get_Lang('delete')}"
									href="{$PCMS_URL}/?mod={$mod}&act=delete&attraction_id={$core->encryptID($allItem[i].attraction_id)}{$pUrl}">
										<i class="icon-remove"></i> {$core->get_Lang('delete')}
									</a>
								</li>

								{/if}
							</ul>
						</div>
					</td>
				</tr>
				{/section}
			</tbody>
			{else}<tr><td colspan="15" style="text-align:center">{$core->get_Lang('nodata')}</td></tr>{/if}
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
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
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
			$.post(path_ajax_script+"/index.php?mod=attraction&act=ajUpdPosSortAttraction", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}