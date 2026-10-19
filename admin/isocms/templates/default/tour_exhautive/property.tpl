{assign var=txtType value=''}
{if $type eq 'TOUROPTION'}
{assign var=txtType value='price class'}
{elseif $type eq 'MEAL'}
{assign var=txtType value='meals'}
{elseif $type eq 'VISITORTYPE'}
{assign var=txtType value='visitor type'}
{elseif $type eq 'SIZEGROUP'}
{assign var=txtType value='price for groups'}
{elseif $type eq 'TOURGUIDE'}
{assign var=txtType value='tour guides'}
{/if}
<link rel="stylesheet" href="{$URL_CSS}/style_tour_setting.css?v={$upd_version}" type="text/css" media="all" />
<div class="page-tour_setting iso-module-list">
{$core->getBlock('breadcrumb_tour_settings')}


	{$core->getBlock('header_title_tour_setting')}

	<div class="container-fluid container-fluid-2">

		{$core->getBlock('menu_tour_exhautive_setting')}

		<div class="content_setting_box">

			<div class="page_detail-title d-flex">

				<div class="title">

					<h2 style="text-transform: capitalize;">{$core->get_Lang($txtType)}</h2>

					<p>{$core->get_Lang("This function is intended to manage %s in isoCMS system")} {$txtType}</p>

				</div>
				{if $type eq 'TOUROPTION' || $type eq 'VISITORTYPE' || $type eq 'TOURGUIDE' || $type eq 'MEAL'}
		<a 
						class="btn btn-main btn-addnew btnCreate {if $type eq 'MEAL' || $type eq 'VISITORTYPE' || $type eq 'TOURGUIDE'}btnCreateTourProperty{/if}{if $type eq 'SIZEGROUP'}btnCreateSizeGroup{/if}" data="0" 
							
						type="{if $type eq 'MEAL' || $type eq 'VISITORTYPE' || $type eq 'TOURGUIDE'}{$type}{/if}" 
						tp="F" 
						href="javascript:void(0);" 
						{if $type eq 'TOUROPTION'}id="clickToAddTourOption" {/if}
					>
						{$core->get_Lang('Add new')}
				</a>
{/if}

			</div>

			<div class="wrap">
				<!-- <div class="statistical mb5">
					<div class="filter_box">
						<form method="post" id="forums" class="filterForm">
							<div class="searchbox d-flex">
								<input name="keyword" value="{$keyword|default:''}" type="text" class="text" placeholder="{$core->get_Lang('Search')}..."/>
								<div class="form-group form-button">
									<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
									<input type="hidden" name="filter" value="filter" />
								</div>
							</div>
								
							<input type="hidden" name="filter" value="filter " />
						</form>
						<div class="record_per_page">
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
							<a class="btn btn-danger btn-delete-all" clsTable="AddOnService" style="display:none">
								<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
							</a>
						</div>		
					</div>	
				</div> -->
				{if $type eq 'TOUROPTION'}

				<div class="tabbox touroption">

					<div class="contentTab">

						<div id="LstTourOption"></div>

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

							{foreach $listVISITORTYPE as $index => $visitorType}

								<li {if $index == 0}class="first"{/if} tour_property_id="{$visitorType.tour_property_id}">

									<a href="javascript:void(0);">{$clsClassTable->getTitle($visitorType.tour_property_id)}</a>

								</li>

							{/foreach}



							{foreach $listVISITORAGETYPE as $visitorAgeType}

								<li tour_property_id="{$visitorAgeType.tour_property_id}">

									<a href="javascript:void(0);">{$core->get_Lang('Setting')} {$clsClassTable->getTitle($visitorAgeType.tour_property_id)}</a>

								</li>

							{/foreach}



							{foreach $listVISITORHEIGHTTYPE as $visitorHeightType}

								<li tour_property_id="{$visitorHeightType.tour_property_id}">

									<a href="javascript:void(0);">{$core->get_Lang('Setting')} {$clsClassTable->getTitle($visitorHeightType.tour_property_id)}</a>

								</li>

							{/foreach}

							<li><a href="javascript:void(0);">{$core->get_Lang('Setting Child Policy')}</a></li>

						</ul>

					</div>

					<div class="clearfix"></div>
<div class="list-table-v2-card booking-table-card v2-table-card">
  <div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">
<div class="tab_contentglobal">

						{foreach $listVISITORTYPE as $index => $visitorType}
		
							<div class="tabboxchild_config_group" {if $index == 0}style="display:block"{else}style="display:none"{/if}>
									<a href="javascript:void();" class="btn-main btn-addnew btnCreateSizeGroup btnCreate" tour_property_id="{$visitorType.tour_property_id}">
											{$core->get_Lang('Add new')}
										</a>
								<!-- <div class="wrap mb10">
									<div class="button_right">
										<a href="javascript:void();" class="btn-main btn-addnew btnCreateSizeGroup btnCreate" tour_property_id="{$visitorType.tour_property_id}">
											{$core->get_Lang('Add new')}
										</a>
									</div>
								</div> -->
								<div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">
								<table class="tbl-grid full-width table-striped">

									<thead>

										<tr>

											<th class="gridheader gridheader-sort" style=" width:8%"><strong>#</strong></th>

											<th class="gridheader gridheader-name" style="text-align:left"><strong>{$core->get_Lang('Name')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('min people')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('max people')}</strong></th>

											<th class="gridheader" style="text-align:center; width: 100px;">{$core->get_Lang('Action')}</th>

										</tr>

									</thead>

									<tbody id="tblHolderSizeGroup{$visitorType.tour_property_id}">

									</tbody>

								</table>
								</div>
							</div>

						{/foreach}



						{foreach $listVISITORAGETYPE as $visitorAgeType}

							<div class="tabboxchild_config_group" style="display:none">
			<a href="javascript:void();" class="btn-main btn-addnew btnCreateSizeGroup btnCreate" tour_property_id="{$visitorType.tour_property_id}">
											{$core->get_Lang('Add new')}
										</a>
								<!-- <div class="wrap mb10">

									<div class="button_right">

									<a href="javascript:void();" class="btn-main btn-addnew btnCreateSizeGroup btnCreate" tour_property_id="{$visitorType.tour_property_id}">
											{$core->get_Lang('Add new')}
										</a>

									</div>

								</div> -->
								<div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">
								<table class="tbl-grid">

									<thead>

										<tr>

											<th class="gridheader gridheader-sort" style=" width:8%"><strong>#</strong></th>

											<th class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Name')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Type')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Min age')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Max age')}</strong></th>

											<th class="gridheader" style="text-align:center;">{$core->get_Lang('Action')}</th>

										</tr>

									</thead>

									<tbody id="tblHolderSizeGroup{$visitorAgeType.tour_property_id}">

									</tbody>

								</table>
									</div>
							</div>
						{/foreach}

						{foreach $listVISITORHEIGHTTYPE as $visitorHeightType}
							<div class="tabboxchild_config_group" style="display:none">
									<a href="javascript:void();" class="btn-main btn-addnew btnCreateSizeGroup btnCreate" tour_property_id="{$visitorHeightType.tour_property_id}">

											{$core->get_Lang('Add new')}

										</a>
								<!-- <div class="wrap mb10">

									<div class="button_right">

												<a href="javascript:void();" class="btn-main btn-addnew btnCreateSizeGroup btnCreate" tour_property_id="{$visitorType.tour_property_id}">
											{$core->get_Lang('Add new')}
										</a>

									</div>

								</div> -->
<div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">
			<table class="tbl-grid">

									<thead>

										<tr>

											<th class="gridheader gridheader-sort" style=" width:8%"><strong>#</strong></th>

											<th class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Name')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Type')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Min height')}</strong></th>

											<th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Max height')}</strong></th>

											<th class="gridheader" style="text-align:center;">{$core->get_Lang('Action')}</th>

										</tr>

									</thead>

									<tbody id="tblHolderSizeGroup{$visitorHeightType.tour_property_id}">

									</tbody>

								</table>
</div>
						

							</div>
						{/foreach}



						<div class="tabboxchild_config_group hastable list-table-v2-scroll booking-table-scroll v2-table-scroll" style="display:none">

							<table class="tbl-grid">

								<thead>

									<tr>

										<th class="gridheader" style=" width:120px; text-align:center"><strong>{$core->get_Lang('Group Size')}</strong></th>

										<th class="gridheader" style="width:120px; text-align:center"><strong>{$core->get_Lang('Adult')}</strong></th>

										<th class="gridheader" style="width:120px; text-align:center"><strong>{$core->get_Lang('Max Child')}</strong></th>

										<th class="gridheader" style="width:120px; text-align:center"><strong>{$core->get_Lang('Max Infant')}</strong></th>

									</tr>

								</thead>

								<tbody>

									{foreach $lstAdultGroupSize as $adultGroup}

										{assign var=numberAdult value=$adultGroup.number_to - $adultGroup.number_from + 1}

										{foreach range(0,$numberAdult-1) as $j}

											{assign var=numberAdultPrice value=$j + $adultGroup.number_from}

											<tr>

												{if $j == 0}

													<td rowspan="{$numberAdult}">{$clsTourOption->getTitle($adultGroup.tour_option_id)}</td>

												{/if}

												<td style="text-align:center"><strong>{$numberAdultPrice}</strong></td>

												<td style="text-align:center">

													<input class="full adult_number_setting" style="width:100px" group_size_id="{$adultGroup.tour_option_id}" number_adult="{$numberAdultPrice}" type="text" value="{$clsSettingChildPolicy->getNumberChild($adultGroup.tour_option_id,$numberAdultPrice)}" traveler_type="child"/>

												</td>

												<td style="text-align:center">

													<input class="full adult_number_setting" style="width:100px" group_size_id="{$adultGroup.tour_option_id}" number_adult="{$numberAdultPrice}" type="text" value="{$clsSettingChildPolicy->getNumberInfant($adultGroup.tour_option_id,$numberAdultPrice)}" traveler_type="infant"/>

												</td>

											</tr>

										{/foreach}

									{/foreach}

								</tbody>

							</table>

						</div>
					</div>
  </div>
</div>
					

				</div>

				{else}


				<div class="hastable list-table-v2-scroll booking-table-scroll v2-table-scroll">



					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">

						<thead>

							<tr>

								<th class="gridheader hiden767">#</th>

								<th class="gridheader name_responsive" style="text-align:left;width:-webkit-fill-available;"><strong>{$core->get_Lang('Name')}</strong> <i class="sort-ico fa-solid fa-sort"></i></th>

								<th class="gridheader status_responsive" style="text-align:center"><strong>{$_ADMINLANG.status|default:''}</strong> <i class="sort-ico fa-solid fa-sort"></i></th>

								<th class="gridheader action_responsive" style="text-align:center; width:100px"><strong>{$core->get_Lang('Action')}</strong></th>

							</tr>

						</thead>

						<tbody {if $type ne 'VISITORTYPE'} id="SortAble" class="sortByTd"{/if}>

							{section name=i loop=$allItem}

							<tr id="order_{$allItem[i].tour_property_id}" class="{cycle values="row1,row2"}">

								<td class="index sortable"><i class="fa fa-arrows" aria-hidden="true"></i></td>

								<td class="name_service title_td1">

									<b>

									  {$clsClassTable->getTitle($allItem[i].tour_property_id)}

									</b>

								</td>

								<td data-title="{$core->get_Lang('')}" class="status_responsive border_top_responsive" style="text-align:center">

									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourProperty" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">

										{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}

										<i class="fa-solid fa-circle-check green"></i>

										{else}

										<i class="fa-solid fa-circle-minus red"></i>

										{/if}

									</a>

								</td>

								<td data-title="{$core->get_Lang('')}" class="action_responsive" align="center" style="vertical-align: middle; text-align:center; width: 60px; white-space: nowrap;">

									<div class="btn-group">

										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

										</button>

										<ul class="dropdown-menu dropdown-menu-end">

											<li>

												<a class="dropdown-item btndelete_tourProperty" tp="F" type="{$type}" 

												title="{$core->get_Lang('edit')}" href="javascript:void(0);" 

												data="{$allItem[i].tour_property_id}">

													<i class="icon-edit"></i> {$core->get_Lang('edit')}

												</a>

											</li>



											{if $type !== "VISITORTYPE"}

											<li>

												<a class="dropdown-item confirm_delete" 

												title="{$core->get_Lang('delete')}" 

												href="{$PCMS_URL}/?mod={$mod}&act=deleteTourProperty&type=MEAL&tour_property_id={$core->encryptID($allItem[i].$pkeyTable)}">

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



					</table>

					<!-- <div class="statistical mt5">

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

					</div> -->

				</div>

				{/if}

			</div>

		</div>

	</div>

</div>



<script type="text/javascript">

	var $type = '{$type}';

	var $recordPerPage = '{$recordPerPage}';

	var $currentPage = '{$currentPage}';

</script>

{literal}

<style type="text/css">
	.content_setting_box .list-table-v2-card{
        border: none;
}
body.iso-admin-shell-v2 #page-content .table_responsive , .table-striped{
        border-collapse: collapse;
    min-width: 760px;
    width: 100%;
    border: 1px solid var(--border-soft);
}
.tabboxchild_config_group .btnCreate{
    position: absolute;
    top: -85px;
    right: 0;
    font-size: 16px;
    font-weight: 700;
}
.tbl-grid tr td{font-size:15px !important;}
.dropdown-menu-end li{
  padding: 7px 5px;
}
@media (max-width: 900px) {
	.tabboxchild_config_group .btnCreate {
			position: unset;
			margin-bottom: 3%;
	}
	body.iso-admin-shell-v2 #page-content .table_responsive, .table-striped{
		    min-width: 600px;
	}
	.touroption_table {
		  min-width: 377px !important;
	}
	  .table_responsive>tbody>tr td.title_td1 {
        display: table-cell !important;
				width: 220px !important;
    }
	.table_responsive>thead>tr th.name_responsive{
		    width: 200px !important;
	}
	.gridheader-name{
		    width: 200px;
	}
    .table_responsive>tbody>tr td:not(.has-checkbox) {
        width: auto;
    }
		body.iso-admin-shell-v2 #page-content .table_responsive {
			min-width: unset;
	}
	.action_responsive{
		padding-left: 70px !important;
	}
	.btn-group .dropdown-menu.show {
    left: -105px !important;
	}
}
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

				$("#tabs_config_group_5").trigger("click");

			}

		}); 

	});

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

			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTourProperty", order, 

			

			function(html){

				vietiso_loading(0);

				location.href = REQUEST_URI;

			});

		}

	});

</script>

{/literal}