<div class="page-tour_setting">
	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_tour_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang($type)}</h2>
					<p>Chức năng quản lý danh sách các {$core->get_Lang($type)} trong hệ thống isoCMS</p>
					<p>This function is intended to manage {$core->get_Lang($type)} in isoCMS system</p>
				</div>
				{if $type eq 'TOUROPTION'}
				<div class="button_right">
					<a class="btn btn-main btn-addnew" id="clickToAddTourOption" title="{$core->get_Lang('Add new')}">{$core->get_Lang('Add new')}</a>
				</div>
				{/if}
				{if $type eq 'MEAL'}
				<div class="button_right">
					<a class="btn btn-main btn-addnew btnCreateTourProperty" data="0" type="MEAL" tp="F" href="javascript:void(0);">
						{$core->get_Lang('Add new')}
					</a>
				</div>
				{/if}
			</div>
			<div class="wrap">
				{if $type eq 'TOUROPTION'}
				<div class="tabbox touroption">
					<div class="contentTab">
						<div id="LstTourOption" style="display:inline-block ;width:600px"></div>
					</div>
				</div>
				{elseif $type eq 'SIZEGROUP'}
				<div class="tabbox configGroup">
					{literal}
					<script type="text/javascript">
						$().ready(function() {
							makeGlobalTab('config_group');
							$('#config_group_ul ul li.first').trigger("click");
						});
					</script>
					{/literal}
					<div class="globaltabs" id="config_group_ul">
						<ul>
							{section name=i loop=$listVISITORTYPE}
							 <li {if $smarty.section.i.first}class="first"{else}{/if} tour_property_id="{$listVISITORTYPE[i].tour_property_id}"><a href="javascript:void(0);">{$clsClassTable->getTitle($listVISITORTYPE[i].tour_property_id)}</a></li>
							{/section}
							<li><a href="javascript:void(0);">{$core->get_Lang('Setting Child Policy')}</a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
					<div class="tab_contentglobal">
						{section name=i loop=$listVISITORTYPE}
						<div class="tabboxchild_config_group" {if $smarty.section.i.first}style="display:block"{else}style="display:none"{/if}>
							<div class="wrap mb10">
								<div class="button_right">
									<a href="javascript:void();" class="btn-main btn-addnew btnCreateSizeGroup" tour_property_id="{$listVISITORTYPE[i].tour_property_id}">
										Thêm mới
									</a>
								</div>
							</div>
							<table class="tbl-grid">
								<thead>
									<tr>
										<th class="gridheader" style=" width:8%"><strong>{$core->get_Lang('index')}</strong></th>
										<th class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>
										<th class="gridheader" style="text-align:right"><strong>{$core->get_Lang('min people')}</strong></th>
										<th class="gridheader" style="text-align:right"><strong>{$core->get_Lang('max people')}</strong></th>
										<th class="gridheader" style="text-align:center;"></th>
									</tr>
								</thead>
								
								<tbody id="tblHolderSizeGroup{$listVISITORTYPE[i].tour_property_id}">
								</tbody>
							</table>
						</div>
						{/section}
						<div class="tabboxchild_config_group" style="display:none">
							<table class="tbl-grid">
								<thead>
									<th class="gridheader" style=" width:120px; text-align:center"><strong>{$core->get_Lang('Group Size')}</strong></th>
									<th class="gridheader" style="width:120px; text-align:center"><strong>{$core->get_Lang('Adult')}</strong></th>
									<th class="gridheader" style="width:120px; text-align:center"><strong>{$core->get_Lang('Max Child')}</strong></th>
									<th class="gridheader" style="width:120px; text-align:center"><strong>{$core->get_Lang('Max Infant')}</strong></th>
								</thead>
								<tbody>
								{section name=i loop=$lstAdultGroupSize}
								{assign var=numberAdult value=$lstAdultGroupSize[i].number_to-$lstAdultGroupSize[i].number_from+1}
								{section name=j loop=$numberAdult}
								{assign var=numberAdultPrice value=$smarty.section.j.iteration+$lstAdultGroupSize[i].number_from-1}
								<tr>
								{if $smarty.section.j.first}
								<td rowspan="{$numberAdult}">{$clsTourOption->getTitle($lstAdultGroupSize[i].tour_option_id)}</td>
								{/if}
								<td style="text-align:center"><strong style="text-align:center">{$numberAdultPrice}</strong></td>
								<td><input class="full adult_number_setting" style="width:100px" group_size_id="{$lstAdultGroupSize[i].tour_option_id}" number_adult="{$numberAdultPrice}" type="text" value="{$clsSettingChildPolicy->getNumberChild($lstAdultGroupSize[i].tour_option_id,$numberAdultPrice)}" traveler_type="child"/></td>
								<td><input class="full adult_number_setting" style="width:100px" group_size_id="{$lstAdultGroupSize[i].tour_option_id}" type="text" number_adult="{$smarty.section.j.iteration+$lstAdultGroupSize[i].number_from-1}" value="{$clsSettingChildPolicy->getNumberInfant($lstAdultGroupSize[i].tour_option_id,$numberAdultPrice)}" traveler_type="infant"/></td>
								</tr>
								{/section}
								{/section}
								</tbody>
							</table>
						</div>
					</div>
				</div>
				{else}
				{if $type ne 'VISITORTYPE' && $type ne 'MEAL'}
				<form method="post" id="forums">
					<div class="filterbox">
						<div class="wrap">
							<div class="searchbox">
								<input name="keyword" value="{$keyword}" type="text" class="text" />
								<a class="btn btn-success" href="javascript:void(0);" style="padding:6px" id="searchbtn">
									<i class="icon-search icon-white"></i>
								</a>
								
								<a class="btn btn-success btnCreateTourProperty" data="0" type="{$type}" tp="F" href="javascript:void(0);">
									<i class="icon-plus icon-white"></i>
								</a>
							</div>
						</div>
					</div>
					<input type="hidden" name="filter" value="filter" />
				</form>
				{/if}
				<div class="hastable">
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
									<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Hotel" style="display:none">
										<i class="icon-remove icon-white"></i>
										<span>{$core->get_Lang('Delete Options')}</span>
									</a>
								</td>
							</tr>
						</table>
					</div>
					<table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th class="gridheader"><strong>ID</strong></th>
								<th class="gridheader text-left"><strong>{$_ADMINLANG.title}</strong></th>
								<th class="gridheader" style="width:10%"><strong>{$_ADMINLANG.status}</strong></th>
								<th class="gridheader" style="width:5%"><strong>{$_ADMINLANG.action}</strong></th>
							</tr>
						</thead>
						
						<tbody {if $type ne 'VISITORTYPE'} id="SortAble"{/if}>
						{section name=i loop=$allItem}
						<tr style="cursor:move" id="order_{$allItem[i].tour_property_id}" class="{cycle values="row1,row2"}">
							<td class="index">{$allItem[i].tour_property_id}</td>
							<td class="title">{$clsClassTable->getTitle($allItem[i].tour_property_id)}</td>

							<td style="text-align:center">
								<a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourProperty" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
									{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
									<i class="fa-solid fa-circle-check green"></i>
									{else}
									<i class="fa-solid fa-circle-minus red"></i>
									{/if}
								</a>
							</td>
							<td style=" white-space:nowrap; text-align:right">
								<div class="btn-group">
									<button class="btn btn_dropdown dropdown-toggle"
											type="button"
											data-bs-toggle="dropdown"
											aria-expanded="false">
										<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
									</button>

									<ul class="dropdown-menu dropdown-menu-end">
										<li>
											<a class="dropdown-item btndelete_tourProperty"
											href="javascript:void(0)"
											tp="F"
											data-type="{$type}"
											data-id="{$allItem[i].tour_property_id}"
											title="{$core->get_Lang('edit')}">
												<i class="icon-edit"></i>
												{$core->get_Lang('edit')}
											</a>
										</li>

										<li>
											<a class="dropdown-item confirm_delete"
											title="{$core->get_Lang('delete')}"
											href="{$PCMS_URL}/?mod={$mod}&act=delete&profile_id={$core->encryptID($listItem[i].profile_id)}">
												<i class="icon-remove"></i>
												{$core->get_Lang('delete')}
											</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						{/section}
						</tbody>
					</table>
					<div class="statistical mt5">
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
									<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Hotel" style="display:none">
										<i class="icon-remove icon-white"></i>
										<span>{$core->get_Lang('Delete Options')}</span>
									</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
				{/if}
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js?v={$upd_version}"></script>

<script type="text/javascript">
	var $type = '{$type}';
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
<style type="text/css">
.tbl-grid tr td{font-size:15px !important;}
</style>
<script type="text/javascript">
	
	$(document).on('change', '.adult_number_setting', function(ev){
		var $_this = $(this);
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/?mod="+mod+"&act=ajSetMaxChildPolicy",
			data:{
				'group_size_id':$_this.attr("group_size_id"),
				'number_adult':$_this.attr("number_adult"),
				'traveler_type':$_this.attr("traveler_type"),
				"number_people":$_this.val(),
				'tp' : 'S'
			},
			dataType: "html",
			success: function(html){
				var htm = html.split('|||');
				$_this.val(htm[1]);
				$("#tabs_config_group_3").trigger("click");
			}
		}); 
	});
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
			var type = $type;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage+'&type='+type;
			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTourProperty", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}