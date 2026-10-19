<div class="page_container">
   <div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Travel Guide Category by Cities')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Travel Guide Category by Cities')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('Chức năng quản lý miêu tả cho nhóm dữ liệu thuộc thành phố, điểm đến thuộc TravelGuide trong hệ thống isoCMS')}</p>
			<p>{$core->get_Lang('This function is intended to manage Travel guide category introduction')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_guide" type="guide2" title="{$core->get_Lang('Add Guide Category by Cities')}">{$core->get_Lang('Add Guide Category by Cities')}</a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				{if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
					<div class="form-group form-country">
						<select name="country_id" class="form-control" data-width="100%" id="slb_country">
							 {$clsCountry->makeSelectboxOption($country_id)}
						</select>
					</div>
				{/if}
				{if $clsCountry->countNumberRegion($country_id) gt '0'}
					{if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
						<div class="form-group form-country">
							<select name="region_id" class="form-control" data-width="100%" id="slb_country">
								 {$clsRegion->makeSelectboxOption($country_id,$region_id)}
							</select>
						</div>
					{/if}
				{/if}
				{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
					<div class="form-group form-country">
						<select name="city_id" class="form-control" data-width="100%" id="slb_country">
							 {$clsCity->makeSelectboxOption($city_id,$country_id)}
						</select>
					</div>
				{/if}
				{if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
					<div class="form-group form-country">
						<select name="cat_id" class="form-control" data-width="100%" id="slb_country">
							 {$clsGuideCat->makeSelectboxOption(0,$cat_id)}
						</select>
					</div>
				{/if}
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
				<div class="form-group form-button hidden">
					<button type="button" class="btn btn-export" id="btn_export">Export</button>
				</div>
				<div class="form-group form-button">
					<a class="btn btn-delete-all" id="btn_delete" clsTable="Guide2" style="display:none">
						{$core->get_Lang('Delete')}
					</a>
				</div>
			</form>	
			<div class="group_buttons fr mt10_767">
				 {if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
				 <a href="{$PCMS_URL}/?mod={$mod}&act=cat" class="btn btn-success btnNew" title="{$core->get_Lang('Guide Category')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('Guide Category')}</span> </a>
				{/if}
			</div>
		</div>	
    <div class="clearfix"></div>
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">&nbsp;</td>
				<td width="50%" align="right">
					{$core->get_Lang('Record/page')}:
					{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl,$act)}
				</td>
			</tr>
		</table>
	</div>
	<div class="hastable">
		<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" class="el-checkbox"/></th>
					<th class="gridheader hiden767" style="width:60px">{$core->get_Lang('ID')}</th>
					{if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
					<th class="gridheader name_responsive" style="text-align:left">{$core->get_Lang('Name')}</th>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'country','cat','default')}
					<th class="gridheader hiden_responsive" style="text-align:left; width:120px">{$core->get_Lang('Country')}</th>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
					<th class="gridheader hiden_responsive" style="text-align:left; width:120px">{$core->get_Lang('Region')}</th>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
					<th class="gridheader hiden_responsive" style="text-align:left; width:120px">{$core->get_Lang('City')}</th>
					{/if}
					<th class="gridheader hiden_responsive" style="width:60px">{$core->get_Lang('status')}</th>
					<th class="gridheader hiden_responsive" style="width:60px">{$core->get_Lang('func')}</th>
				</tr>
			</thead>
			{if $allItem[0].guide2_id ne ''}
			<tbody id="SortAble">
			   {section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].guide2_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$allItem[i].guide2_id}"  /></td>
					<td class="index hiden767">{$allItem[i].guide2_id}</td>
					<td class="name_service">
					<span class="title" title="{if $clsClassTable->getOneField('is_online',$allItem[i].guide2_id) eq 0}{$core->get_Lang('PRIVATE')}{/if}">{$clsGuideCat->getTitle($allItem[i].cat_id)}</span>
					{if $clsClassTable->getOneField('is_online',$allItem[i].guide2_id) eq 0}<span style="color:red;" title="{$core->get_Lang('PRIVATE')}">[P]</span>{/if}
						{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
						<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
					</td>
					{if $clsISO->getCheckActiveModulePackage($package_id,'country','cat','default')}
					<td data-title="{$core->get_Lang('Country')}" class="block_responsive border_top_responsive">{$clsCountry->getTitle($allItem[i].country_id)}</td>
					{/if}
						{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
					<td data-title="{$core->get_Lang('Region')}" class="block_responsive">{$clsRegion->getTitle($allItem[i].region_id)}</td>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
					<td data-title="{$core->get_Lang('City')}" class="block_responsive">{$clsCity->getTitle($allItem[i].city_id)}</td>
					{/if}
					<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center;">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Guide2" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center;white-space: nowrap;">
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle"
									type="button"
									data-bs-toggle="dropdown"
									aria-expanded="false">
								<i class="icon-cog"></i> <span class="caret"></span>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">

								{if $allItem[i].is_trash eq '0'}

									{assign var=country_id_1 value=$clsClassTable->getOneField('country_id',$allItem[i].$pkeyTable)}
									{assign var=city_id value=$clsClassTable->getOneField('city_id',$allItem[i].$pkeyTable)}
									{assign var=cat__id value=$clsClassTable->getOneField('cat_id',$allItem[i].$pkeyTable)}

									<li>
										<a class="dropdown-item"
										href="{$DOMAIN_NAME}{$clsClassTable->getLinkGuide($allItem[i].$pkeyTable,$country_id_1,$city_id,$cat__id)}"
										target="_blank"
										title="{$core->get_Lang('view')}">
											<i class="bi bi-eye"></i>
											{$core->get_Lang('view')}
										</a>
									</li>

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('edit')}"
										href="{$PCMS_URL}/guide/compose/insert/{$allItem[i].$pkeyTable}/overview">
											<i class="bi bi-pencil"></i>
											{$core->get_Lang('edit')}
										</a>
									</li>

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('trash')}"
										href="{$PCMS_URL}/?mod={$mod}&act=trash2&guide2_id={$core->encryptID($allItem[i].guide2_id)}">
											<i class="bi bi-trash"></i>
											{$core->get_Lang('trash')}
										</a>
									</li>

								{else}

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('restore')}"
										href="{$PCMS_URL}/?mod={$mod}&act=restore2&guide2_id={$core->encryptID($allItem[i].guide2_id)}{$pUrl}">
											<i class="bi bi-arrow-clockwise"></i>
											{$core->get_Lang('restore')}
										</a>
									</li>

									<li>
										<a class="dropdown-item confirm_delete"
										title="{$core->get_Lang('delete')}"
										href="{$PCMS_URL}/?mod={$mod}&act=delete2&guide2_id={$core->encryptID($allItem[i].guide2_id)}{$pUrl}">
											<i class="bi bi-x-circle"></i>
											{$core->get_Lang('delete')}
										</a>
									</li>

								{/if}

							</ul>
						</div>
					</td>
				</tr>
			{/section}{else}<tr><td colspan="15" style="text-align:center">{$core->get_Lang('nodata')}</td></tr>
		</tbody>	
		{/if}
		</table>
		{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
	</div>
</div>
</div>
<script type="text/javascript">
	var country_id="{$country_id}";
	var cat_id="{$cat_id}";
</script>
{literal}
<script type="text/javascript">
$().ready(function(){
	makeSelectCategory(country_id,$('select[name=city_id]').val(),cat_id);
	$('select[name=country_id]').change(function() {
		var $_this = $(this);
		makeSelectCategory($_this.val(),0,cat_id);
		$('select[name=city_id]').html('<option value="">'+loading+'</option>');
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/index.php?mod=guide&act=loadCity',
			data: {"country_id": $_this.val()},
			dataType: "html",
			success: function(html) {
				$('select[name=city_id]').html(html);
			}
		});
	});
});
function makeSelectCategory($country_id, $city_id, $cat_id){
	$('select[name=cat_id]').html('<option value="0">'+loading+'</option>');
	var $_adata = {
		'country_id': $country_id,
		'city_id': $city_id,
		'cat_id': $cat_id
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=guide&act=ajLoadSelectCategory',
		data :$_adata,
		dataType:'html',
		success: function(html){
			$('select[name=cat_id]').html(html);
		} 
	});
}

</script>
{/literal}

<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/guide/jquery.guide.js?v={$upd_version}"></script>
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
			$.post(path_ajax_script+"/index.php?mod=guide&act=ajUpdPosSortGuideNotitle", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}