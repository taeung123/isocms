<div class="page-tour_setting page_container">
	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_tour_exhautive_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('Type of activity')} </h2>
					<p>{$core->get_Lang("This function is intended to manage %s in isoCMS system")|vsprintf:'Type of activity'}</p>
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew" href="{$PCMS_URL}/?mod={$mod}&act=edit_activities" title="{$core->get_Lang('Add new')}">{$core->get_Lang('Add new')}</a>
				</div>
			</div>
			<div class="wrap">
				<div class="filter_box">
					<form id="forums" method="post" class="filterForm" action="">
						<div class="form-group form-keyword">
							<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
						</div>
						<div class="form-group form-button">
							<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
							<input type="hidden" name="filter" value="filter" />
						</div>
						<div class="form-group form-button">
							<a class="btn btn-delete-all" id="btn_delete" clsTable="Activities" style="display:none">
								{$core->get_Lang('Delete')}
							</a>
						</div>
					</form>	
					<div class="record_per_page">
						<label>{$core->get_Lang('Record/page')}</label>
						{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
					</div>
				</div>
				<div class="hastable">
					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
						<thead>
							<tr>
								<th class="gridheader" style="width:40px"></th>
								<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
								<th class="gridheader" style="width:70px"><strong>{$core->get_Lang('Image')}</strong></th>
								<th class="gridheader name_responsive name_responsive3" style="text-align:left;padding-left:15px!important"><strong>{$core->get_Lang('Name')}</strong></th>
								<th class="gridheader hiden_responsive" style="width:80px"><strong>{$core->get_Lang('status')}</strong></th>
								<th class="gridheader hiden_responsive" style="text-align:center; width:60px"></th>
							</tr>
						</thead>
						{if !empty($allItem) && $allItem[0].activities_id ne ''}
						<tbody id="SortAble" class="sortByTd">
							{section name=i loop=$allItem}
							<tr id="order_{$allItem[i].activities_id}"   class="{cycle values="row1,row2"}">
								<th class="index sortable"><i class="fa fa-arrows" aria-hidden="true"></i></th>
								<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].activities_id}" /></th>
								<th class="index" style="width:70px">									
									<img src="{if $clsClassTable->getImageUrl($allItem[i].activities_id)}{$clsClassTable->getImage($allItem[i].activities_id,60,40)}{/if}" width="60" onerror="this.src='{$URL_IMAGES}/none_image.png'" />
								</th>
								<td class="name_service">
									<b>
										<span class="title">{$allItem[i].activities_id}</span>
										- {$clsClassTable->getTitle($allItem[i].activities_id)}
									</b>
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
								<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 60px; white-space: nowrap;">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu" style="right:0px !important">
											{if $allItem[i].is_trash eq '0'}
											<li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/property/activities/insert/{$allItem[i].activities_id}/overview/generalinformation"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
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
	</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		items: 'tr',
		handle: 'th.sortable',
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