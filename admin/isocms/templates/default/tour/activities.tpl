<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Activities')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
		<h2>{$core->get_Lang('Activities')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit_activities" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
		<p>{$core->get_Lang('Chức năng quản lý danh sách các Activities trong hệ thống isoCMS')}</p>
		<p>{$core->get_Lang('This function is intended to manage Activities in isoCMS system')}</p>
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
				</div>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
    </form>
	<div class="clearfix"><br /></div>
    <input id="list_selected_chkitem" style="display:none" value="0" />
    <div class="wrap">
		<div class="clearfix"></div>
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;</td>
					<td width="50%" align="right">
						{$core->get_Lang('Record/page')}:
						<select name="recordperpage" onchange="window.location = this.options[this.selectedIndex].value">
							<option {if $recordPerPage eq '20'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=20">20</option>
							{if $totalRecord gt '20'}
							<option {if $recordPerPage eq '50'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=50">50</option>
							{if $totalRecord gt '50'}
							<option {if $recordPerPage eq '100'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=100">100</option>
							{if $totalRecord gt '100'}
							<option {if $recordPerPage eq '200'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage=200">200</option>
							{if $totalRecord gt '200'}
							<option {if $recordPerPage eq '{$totalRecord}'}selected="selected"{/if} value="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage={$totalRecord}">{$core->get_Lang('All')}</option>
							{/if}
							{/if}
							{/if}
							{/if}
						</select>
						<a class="btn btn-danger btn-delete-all" clsTable="Activities" style="display:none">
							<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
						</a>
					</td>
				</tr>
			</table>
		</div>
    	<div class="hastable">
        	<table cellspacing="0" class="tbl-grid table_responsive" width="100%">
				<thead>
					<tr>
						<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
						<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
						<th class="gridheader" style="width:70px"><strong>{$core->get_Lang('Image')}</strong></th>
						<th class="gridheader name_responsive name_responsive3" style="text-align:left"><strong>{$core->get_Lang('Name')}</strong></th>
						<th class="gridheader hiden_responsive" style="width:70px"><strong>{$core->get_Lang('status')}</strong></th>
						<th class="gridheader hiden_responsive" style="text-align:center; width:70px"><strong>{$core->get_Lang('func')}</strong></th>
					</tr>
				</thead>
                {if $allItem[0].activities_id ne ''}
				<tbody id="SortAble">
					{section name=i loop=$allItem}
					<tr style="cursor:move" id="order_{$allItem[i].activities_id}"   class="{cycle values="row1,row2"}">
						<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].activities_id}" /></th>
						<th class="index hiden767"> {$allItem[i].activities_id}</th>
						<th class="index" style="width:70px">
							{if $clsClassTable->getImageUrl($allItem[i].activities_id)}
							<img src="{$clsClassTable->getImage($allItem[i].activities_id,60,40)}" width="60" />
							{else}
							<span style="width:60px"></span>
							{/if}
						</th>
						<td class="name_service">
							<strong>{$clsClassTable->getTitle($allItem[i].activities_id)}</strong>
							{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
							<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
						</td>
						<td data-title="{$core->get_Lang('status')}" class="block_responsive border_top_responsive" style="text-align:center">
							<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Activities" pkey="activities_id" sourse_id="{$allItem[i].activities_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].activities_id)}" title="{$core->get_Lang('Click to change status')}">
								{if $clsClassTable->getOneField('is_online',$allItem[i].activities_id) eq '1'}
								<i class="fa-solid fa-circle-check green"></i>
								{else}
								<i class="fa-solid fa-circle-minus red"></i>
								{/if}
							</a>
						</td>
						<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
								<ul class="dropdown-menu" style="right:0px !important">
									{if $allItem[i].is_trash eq '0'}
									<li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit_activities&activities_id={$core->encryptID($allItem[i].activities_id)}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
									<li><a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&activities_id={$core->encryptID($allItem[i].activities_id)}"><i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a></li>
									{else}
									<li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&activities_id={$core->encryptID($allItem[i].activities_id)}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
									<li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&activities_id={$core->encryptID($allItem[i].activities_id)}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
									{/if}
								</ul>
							</div>
						</td>
					</tr>
					{/section}
                </tbody>
				{/if}
            </table>   
        </div>
		<div class="clearfix"></div>
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
			$.post(path_ajax_script+"/index.php?mod=property&act=ajUpdPosSortActivities", order, 
			
			function(html){
				vietiso_loading(0);
				location.href=REQUEST_URI;
			});
		}
	});
</script>
{/literal}