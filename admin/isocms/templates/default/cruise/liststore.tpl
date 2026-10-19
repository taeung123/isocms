<div class="page_container page-tour_setting">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_cruise_setting')}
		<div class="content_setting_box">
			<div class="wrap">
				<div class="page_detail-title d-flex">
					<div class="title">
						<h2>{$clsClassTable->getTitle($type)} </h2>
						<p>{$core->get_Lang('systemmanagement')} {$clsClassTable->getTitle($type)}</p>
					</div>
					<div class="button_right">
						<a class="btn btn-main btn-addnew btnOpenCruiseStoreModal" href="javascript:void(0);" data-_type="{$type}" title="{$core->get_Lang('add')} {$clsClassTable->getTitle($type)}">{$core->get_Lang('add')} {$clsClassTable->getTitle($type)}</a>
					</div>
				</div>
				<div class="statistical mb5">
					<div class="filter_box">
						<form id="forums" method="post" class="filterForm" action="">
							<div class="form-group form-keyword">
								<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
							</div>

							<div class="form-group form-country">
								<select name="cruise_cat_id" class="form-control" data-width="100%" id="slb_country">
									{$clsCruiseCat->makeSelectboxOption($cruise_cat_id,0)}
								</select>
							</div>
							<div class="form-group form-button">
								<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
								<input type="hidden" name="filter" value="filter" />
							</div>
							<div class="form-group form-button hidden">
								<button type="button" class="btn btn-export" id="btn_export">Export</button>
							</div>
							<div class="form-group form-button">
								<a class="btn btn-delete-all" id="btn_delete" clsTable="CruiseStore" style="display:none">
									{$core->get_Lang('Delete')}
								</a>
							</div>
						</form>	
						<div class="record_per_page">
							<label>{$core->get_Lang('Record/page')}</label>
							{$clsISO->getRecordPerPage2($recordPerPage|default:0,$totalRecord|default:0,$mod,$pUrl|default:'')}
						</div>
					</div>
				</div>
			</div>
			
			<div class="clearfix"></div>
			<br class="clearfix" />
			<table cellspacing="0" class="table table-striped tbl-grid table_responsive" width="100%">
				<thead>
					<tr>
						<th class="gridheader hiden767" style="width:40px"></th>
						<th class="gridheader" style="width:40px">
							<input id="check_all" type="checkbox" class="el-checkbox" style="cursor: pointer" />
						</th>
						<th class="gridheader name_responsive full-w767" style="text-align:left"><strong>{$core->get_Lang('nameofcruises')}</strong></th>
						{if $clsConfiguration->getValue('SiteHasCruisesCategory')}
						<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('cruisescategory')}</strong></th>
						{/if}
						{if $clsConfiguration->getValue('SiteHasCruisesItinerary')}
						<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('itinerary')}</strong></th>
						{/if}
						<th class="gridheader hiden_responsive" style="text-align:right"><strong>{$core->get_Lang('pricefrom')}</strong></th>
						<th class="gridheader text-center hiden_responsive" style="width:40px"><strong>{$core->get_Lang('func')}</strong></th>
					</tr>
				</thead>
				{if !empty($allItem) && $allItem[0].cruise_id ne ''}
				<tbody id="SortAble" class="sortByTd">
					{section name=i loop=$allItem}
					<tr id="order_{$allItem[i].cruise_id}">
						<td class="index hiden767 sortable">
							<i class="fa fa-arrows" aria-hidden="true"></i>
						</td>
						<td class="check_40 has-checkbox text-center">
							<input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$allItem[i].cruise_store_id}" style="cursor: pointer" />
						</td>
						<td class="name_service title_td1">
							<a class="title" href="{$PCMS_URL}/cruise/insert/{$allItem[i].cruise_id}/overview" title="{$clsCruise->getTitle($allItem[i].cruise_id)}">
								<b>{$clsCruise->getTitle($allItem[i].cruise_id)}</b>
							</a>
							{if $clsCruise->getOneField('is_online',$allItem[i].cruise_id) eq 0}
								<span style="color:red;" title="Cruise đang ở chế độ Private">[P]</span>
							{/if}
							<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
						</td>
						{if $clsConfiguration->getValue('SiteHasCruisesCategory')}
						<td class="block_responsive" data-title="{$core->get_Lang('cruisescategory')}">
							<a title="{$core->get_Lang('category')}" href="javascript:void(0);">
							   <img src="{$URL_IMAGES}/v2/zoom_last.png" /> {$clsCruise->getCatName($allItem[i].cruise_id)}
							</a>
						</td>
						{/if}
						{if $clsConfiguration->getValue('SiteHasCruisesItinerary')}
						<td class="block_responsive" data-title="{$core->get_Lang('itinerary')}">
							<a title="{$core->get_Lang('allitineraries')}" href="{$PCMS_URL}/cruise/insert/{$allItem[i].cruise_id}/itinerary/itinerary">
							   <img src="{$URL_IMAGES}/v2/zoom_last.png" /> {$core->get_Lang('allitineraries')}
							</a>
						</td>
						{/if}
						<td class="block_responsive" data-title="{$core->get_Lang('pricefrom')}" style="text-align:right; white-space:nowrap">
							<strong class="format_price" style="font-size:13px">
								{$clsCruise->getPriceCruiseList($allItem[i].cruise_id,$now_month|default:'','Valuedetail')}
							</strong>
						</td>
						<td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">
							<div class="btn-group">
								<div class="dropdown">
									<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end">
										<li>
											<a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/cruise/insert/{$allItem[i].cruise_id}/overview">
												<i class="icon-edit"></i> {$core->get_Lang('edit')}
											</a>
										</li>
										<li>
											<a class="confirm_delete dropdown-item" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&cruise_store_id={$allItem[i].cruise_store_id}{$pUrl}">
												<i class="icon-trash"></i> {$core->get_Lang('delete')}
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
					{/section}
				{else}
					<tr><td colspan="15">{$core->get_Lang('nodata')}</td></tr>
				</tbody>
				{/if}
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
	var $type = '{$type}';
</script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		handle: 'td.sortable',
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
			var type = $type;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage+'&type='+type;
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListCruiseStore", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});

	window.storeModalChanged = false;

	$(document).on('click', '.btnOpenCruiseStoreModal', function(e) {
		e.preventDefault();
		var $_this = $(this);
		var _type = $_this.data('_type') || $type;
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadCruiseStoreModal',
			data: {'tp': 'F', '_type': _type},
			dataType: 'json',
			success: function(res) {
				vietiso_loading(0);
				if (res.result) {
					$("#box_AddCruiseStore").remove();
					$("#isoblanketpop_box_AddCruiseStore").remove();
					makepopupnotresize("70%", "auto", res.html, "box_AddCruiseStore");
					$("#box_AddCruiseStore").css("top", "50px");
					window.storeModalChanged = false;
				}
			},
			error: function() {
				vietiso_loading(0);
			}
		});
	});

	$(document).on('click', '#btn_search_cruise_store_modal', function(e) {
		e.preventDefault();
		var _type = $(this).data('_type') || $type;
		var keyword = $("#search_cruise_store_keyword").val();
		var cruise_cat_id = $("#search_cruise_store_cat_id").val();
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajLoadCruiseStoreModal',
			data: {'tp': 'L', '_type': _type, 'keyword': keyword, 'cruise_cat_id': cruise_cat_id},
			dataType: 'json',
			success: function(res) {
				vietiso_loading(0);
				if (res.result) {
					$("#ListCruiseStoreModal").html(res.html);
				}
			},
			error: function() {
				vietiso_loading(0);
			}
		});
	});

	$(document).on('keyup', '#search_cruise_store_keyword', function(e) {
		if (e.keyCode === 13) {
			$("#btn_search_cruise_store_modal").trigger('click');
		}
	});

	$(document).on('click', '.btnClickStoreCruise', function(e) {
		e.preventDefault();
		var $_this = $(this);
		if ($_this.hasClass('disabled')) return false;

		var cruise_id = $_this.data('cruise_id');
		var _type = $_this.data('_type');
		var val = $_this.data('val');

		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajUpdateCruiseStore',
			data: {'cruise_id': cruise_id, '_type': _type, 'val': val},
			dataType: 'html',
			success: function(res) {
				vietiso_loading(0);
				window.storeModalChanged = true;
				$_this.replaceWith('<button type="button" class="btn btn-sm btn-success disabled text-white" style="opacity:1 !important; background-color:#28a745 !important; border-color:#28a745 !important; color:#ffffff !important; font-weight:500; cursor:default;"><i class="fa fa-check"></i> Added</button>');
				if (typeof alertify !== 'undefined') {
					alertify.success('Added successfully!');
				}
			},
			error: function() {
				vietiso_loading(0);
			}
		});
	});

	$(document).on('click', '#box_AddCruiseStore .close_pop', function() {
		if (window.storeModalChanged) {
			location.reload();
		}
	});
</script>
{/literal}