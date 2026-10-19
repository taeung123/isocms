<div class="page_container page-tour_setting">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_cruise_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{if $type eq "GroupCruiseFacilities"}{$core->get_Lang('Group Cruise Facilities')}{else}{$clsClassTable->getTextByType($type)}{/if}</h2>
					<p>{$core->get_Lang('This function is intended to manage')} {if $type eq "GroupCruiseFacilities"}{$core->get_Lang('Group Cruise Facilities')}{else}{$clsClassTable->getTextByType($type)}{/if} {$core->get_Lang('in isoCMS system')}</p>
				</div>
				<div class="button_right">
					{if $type !== "HighLow"}<a class="btn btn-main btn-addnew clickToEditProperty" href="javascript:void(0);" data="0" title="{$core->get_Lang('Add')} {if $type eq "GroupCruiseFacilities"}{$core->get_Lang('Group Cruise Facilities')}{else}{$clsClassTable->getTextByType($type)}{/if}">{$core->get_Lang('Add')} {if $type eq "GroupCruiseFacilities"}{$core->get_Lang('Group Cruise Facilities')}{else}{$clsClassTable->getTextByType($type)}{/if}</a>{/if}
				</div>
			</div>
			{if $type eq 'HighLow'}
			<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
				{assign var = high_season_month value = $clsConfiguration->getValue('high_season_month')}
				<div class="service_left">
					<h4 style="margin:30px 0 0px">{$core->get_Lang('Check Rates')}</h4>
				</div>
				<div class="row-span">
					<label style="font-size:12px"><strong>Check:</strong> {$core->get_Lang('High season month')} <br /><strong>UnCheck:</strong> {$core->get_Lang('Low season month')}</label>
					<div class="wrap mt10">
						<style>
							.custom-checkbox-month { display: inline-block; width: calc(16.66% - 10px); margin-right: 10px; margin-bottom: 10px; cursor: pointer; }
							.custom-checkbox-month input { display: none; }
							.custom-checkbox-month .month-label { display: block; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; text-align: center; background: #f9f9f9; color: #333; transition: all 0.2s; font-size: 13px; }
							.custom-checkbox-month input:checked + .month-label { background: var(--main-bg-color, #f58321); color: var(--color-text-main-bg, #fff); border-color: var(--main-bg-color, #f58321); font-weight: bold; }
							.custom-checkbox-month:hover .month-label { border-color: var(--main-bg-color, #f58321); }
						</style>
						{section name=i loop=$lstMonth}
						<label class="custom-checkbox-month">
							<input type="checkbox" {if $clsISO->checkInArray($high_season_month,$lstMonth[i])}checked="checked"{/if} name="season_month[]" value="{$lstMonth[i]}" />
							<span class="month-label">{$core->get_Lang('month')} {$lstMonth[i]}</span>
						</label>
						{/section}
					</div>
					<div class="mt10" id="tblCruisePrice"></div>
				</div>
				<fieldset class="submit-buttons">
					 {$saveBtn}
					<input value="Update" name="submit" type="hidden">
				</fieldset>
			</form>
			{else}
			<div class="ui-action">
				<div class="wrap">
					<div class="filter_box">
						<form id="forums" method="post" action="" class="filterForm">
							<div class="form-group form-keyword">
								<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
							</div>
							<div class="form-group form-button">
								<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
								<input type="hidden" name="filter" value="filter" />
							</div>
							<div class="form-group form-button">
								<a class="btn btn-delete-all" id="btn_delete" clsTable="CruiseProperty" style="display:none">
									{$core->get_Lang('Delete')}
								</a>
							</div>
							{if $type eq 'UsefulInformation'}
							<div class="group_buttons fr"> <a href="{$PCMS_URL}/index.php?mod=cruise&act=property&type=GroupUsefulInformation" class="btn btn-success btnNew" title="{$core->get_Lang('Group UsefulInformation')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('Group UsefulInformation')}</span> </a></div>
							{elseif $type eq 'NearestEssentials'}
							<div class="group_buttons fr"> <a href="{$PCMS_URL}/index.php?mod=cruise&act=property&type=GroupNearestEssentials" class="btn btn-success btnNew" title="{$core->get_Lang('Group Nearest Essentials')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('Group Nearest Essentials')}</span> </a></div>
							{elseif $type eq 'Benefits'}
							<div class="group_buttons fr"> <a href="{$PCMS_URL}/index.php?mod=cruise&act=property&type=GroupBenefits" class="btn btn-success btnNew" title="{$core->get_Lang('Group Benefits')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('Group Benefits')}</span> </a></div>
							{/if}
						</form>
						<div class="record_per_page">
							<label>{$core->get_Lang('Record/page')}</label>
							{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$act,$type)}
						</div>
					</div>
				</div>
			</div>
			<div class="hastable">
				<form id="listItem" method="post" action="">
					<input type="hidden" value="delete" name="delete" />
					<table cellspacing="0" class="table table-striped tbl-grid table_responsive" width="100%">
						<thead>
							<tr>
								<th class="gridheader hiden767" style="width:40px"></th>
								<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" class="el-checkbox" style="cursor: pointer" /></th>
								<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>
								{if $type eq 'Conditions'}
								<th class="gridheader hiden_responsive" style="text-align:left; width:120px"><strong>{$core->get_Lang('Type Group')}</strong></th>
								{/if}
								<th class="gridheader hiden767" style="text-align:center; width:60px"><strong>{$core->get_Lang('status')}</strong></th>
								<th class="gridheader text-center hiden_responsive" width="74px"></th>
							</tr>
						</thead>
						{if $allItem[0].cruise_property_id}
						<tbody id="SortAble" class="sortByTd">
							{section name=i loop=$allItem}
							<tr id="order_{$allItem[i].cruise_property_id}">
								<td class="index hiden767 sortable">
									<i class="fa fa-arrows" aria-hidden="true"></i>
								</td>
								<td class="check_40 has-checkbox text-center">
									<input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$allItem[i].cruise_property_id}" style="cursor: pointer" />
								</td>
								<td class="text-left name_service">
									<a class="clickToEditProperty" href="javascript:void(0);" data="{$allItem[i].cruise_property_id}">
										<b><span class="title">{$allItem[i].cruise_property_id}</span> - {$clsClassTable->getTitle($allItem[i].cruise_property_id)}</b>
									</a>
									<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
								</td>
								{if $type eq 'Conditions'}
								<td class="block_responsive" data-title="{$core->get_Lang('Type Group')}">
									{$clsClassTable->getOneField('type_group',$allItem[i].cruise_property_id)}
								</td>
								{/if}
								<td class="block_responsive" data-title="{$core->get_Lang('status')}" style="text-align:center">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="CruiseProperty"
									   pkey="cruise_property_id" toField="is_online" sourse_id="{$allItem[i].cruise_property_id}"
									   rel="{if $allItem[i].is_online eq '1' || $clsClassTable->getOneField('is_online',$allItem[i].cruise_property_id) eq '1'}1{else}0{/if}"
									   title="{$core->get_Lang('Click to change status')}">
										{if $allItem[i].is_online eq '1' || $clsClassTable->getOneField('is_online',$allItem[i].cruise_property_id) eq '1'}
											<i class="fa-solid fa-circle-check green"></i>
										{else}
											<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								<td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											<li>
												<a class="dropdown-item clickToEditProperty" title="{$core->get_Lang('edit')}" href="javascript:void(0);" data="{$allItem[i].cruise_property_id}">
													<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
												</a>
											</li>
											<li>
												<a class="dropdown-item clickToDeleteProperty" title="{$core->get_Lang('delete')}" href="javascript:void(0);" data="{$allItem[i].cruise_property_id}">
													<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
												</a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							{/section}
						</tbody>
						{else}
						<tbody>
							<tr><td colspan="15" class="text-center">{$core->get_Lang('nodata')}</td></tr>
						</tbody>
						{/if}
					</table>
				</form>
			</div>
			<div class="clearfix"></div>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
			{/if}
		</div>
	</div>
</div>
<script type="text/javascript">
	var parent_id = `{$parent_id|default:0}`;
	var type = `{$type|default:''}`;
	var $SiteHasCruisesProperty = "{$clsConfiguration->getValue('SiteHasCruisesProperty')}";
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
	var $type = '{$type}';
	var exist_error = "{$core->get_Lang('Title already exists')}";
</script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		items: 'tr',
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListCruiseProperty", order, 
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/cruise/jquery.cruise.js?v={$upd_version}"></script>