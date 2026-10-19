<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
	<a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('guide')}">{$core->get_Lang('Guide')}</a>
	<a>&raquo;</a>
	<a href="{$curl}" title="{$mod}">{$core->get_Lang('blogcategory')}</a>
	<!-- // -->
	<a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Travel Guide Category list')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Travel Guide Category list')}: {$core->get_Lang('Content list')} trong hệ thống isoCMS">i</div>
			</h2>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew btnCreateCategoryGuide" type="cat" title="{$core->get_Lang('Add Guide Category')}">{$core->get_Lang('Add Guide Category')}</a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="GuideCat" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
                    <div class="group_buttons fr mt10_767">
						<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-danger btnNew" title="{$core->get_Lang('travelguide')}"><i class="fa fa-reply"></i> <span>{$core->get_Lang('travelguide')}</span> </a>
					</div>
				</form>	
			</div>			
			<div class="clearfix"></div>
			<div class="tabbox">
				<div class="hastable">
					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
						<thead>
							<tr>
								<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox"  class="el-checkbox" /></th>
								<th class="gridheader hiden767" style="width:60px">{$core->get_Lang('ID')}</th>
								<th class="gridheader name_responsive" style="text-align:left">{$core->get_Lang('Name')}</th>
								<th class="gridheader hiden_responsive" style="width:60px; text-align:center">{$core->get_Lang('Status')}</th>
								<th class="gridheader hiden_responsive" style="width:70px">{$core->get_Lang('func')}</th>
							</tr>
						</thead>
						
						{if $allItem[0].guidecat_id ne ''}
						<tbody id="SortAble">
							{section name=i loop=$allItem}
							{assign var = guidecat_id value = $allItem[i].guidecat_id}
							<tr style="cursor:move" id="order_{$guidecat_id}" class="{cycle values="row1,row2"}" >
								<td class="check_40 has-checkbox text-center">
									{if $clsISO->checkInArray('3,5,15,20',$allItem[i].guidecat_id)}
									<span style="display:inline-block; width:20px;">&nbsp;</span>
									{else}
									<input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$allItem[i].guidecat_id}" />{/if}</td>
								<td class="hiden767 text_center">{$allItem[i].guidecat_id}</td>
								<td  class="name_service">
								<span class="title" title="{if $clsClassTable->getOneField('is_online',$allItem[i].guidecat_id) eq 0}{$core->get_Lang('Guide Category PRIVATE')}{/if}">{$clsClassTable->getTitle($allItem[i].guidecat_id)}</span>
								{if $clsClassTable->getOneField('is_online',$allItem[i].guidecat_id) eq 0}<span style="color:red;" title="{$core->get_Lang('Guide Category PRIVATE')}">[P]</span>{/if}
								{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
								<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
								</td>
								<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="GuideCat" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
										{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											{if $allItem[i].is_trash eq '0'}
												<li>
													<a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/guide/category/insert/{$allItem[i].guidecat_id}/overview" class="dropdown-item btnEditGuideCat" data="{$allItem[i].guidecat_id}">
														<i class="icon-edit"></i> {$core->get_Lang('edit')}
													</a>
												</li>
												{if !$clsISO->checkInArray('3,5,15,20',$allItem[i].guidecat_id)}
													<li>
														<a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=cat&action=Trash&guidecat_id={$core->encryptID($allItem[i].guidecat_id)}" class="dropdown-item">
															<i class="icon-trash"></i> {$core->get_Lang('trash')}
														</a>
													</li>
												{/if}
											{else}
												<li>
													<a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=cat&action=Restore&guidecat_id={$core->encryptID($allItem[i].guidecat_id)}" class="dropdown-item">
														<i class="icon-refresh"></i> {$core->get_Lang('restore')}
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('delete')}" class="confirm_delete dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=cat&action=Delete&guidecat_id={$core->encryptID($allItem[i].guidecat_id)}">
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
						{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
		</div>
	</div>
</div>
<script type="text/javascript">
	var $boxID = "";
	var $cat_id = `{$cat_id|default:0}`;
	var $guidecat_id= `{$guidecat_id|default:0}`;
	var $departure_point_id= `{$departure_point_id|default:''}`;
	var $is_set= `{$is_set|default:''}`;
	var $recordPerPage = `{$recordPerPage|default:0}`;
	var $currentPage = `{$currentPage|default:0}`;
</script>
<script type="text/javascript" src="{$URL_THEMES}/guide/jquery.guide.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		opaguide: 0.8,
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
			$.post(path_ajax_script+"/index.php?mod=guide&act=ajUpdPosSortGuideCat", order,

			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}