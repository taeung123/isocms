<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('area city')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('area city')}  <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit{$pUrl}" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        {assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
    </div>
    <div class="clearfix"></div>
	{literal}
	<script type="text/javascript">
		$().ready(function() {
			$('.filterForm select[name=iso-city_id],.filterForm select[name=iso-star]').change(function() {
				$('#searchbtn').click();
			});
		});
	</script>
	{/literal}
	<div id="isotabs">
		<ul>
			<li class="tabchild"><a><i class="iso-option"></i> {$core->get_Lang('searchfilter')}</a></li>
		</ul>
	</div>
	<div id="isotabs_content">
		<div class="isotabbox">
			<form id="forums" method="post" action="" name="filter" class="filterForm">
				<table class="form mb10" cellpadding="3" cellspacing="3" width="100%">
					<tr>
						{if $clsConfiguration->getValue('SiteModActive_continent') eq 1}
						<td class="fieldlabel">{$core->get_Lang('continent')}</td>
						<td class="fieldarea">
							<select class="slb" style="font-size:14px; width:150px" name="iso-continent_id">
								{$clsContinent->makeSelectboxOption($continent_id)}
							</select>
						</td>
						<td class="fieldlabel">{$core->get_Lang('country')}</td>
						<td class="fieldarea">
							<select class="slb full" name="country_id" style="font-size:14px; width:150px"> 
								{$clsContinent->getOptCountryByContinent($continent_id,$country_id)}
							</select>
						</td>
						{else}
						<td class="fieldlabel">{$core->get_Lang('country')}</td>
						<td class="fieldarea">
							<select class="full" name="country_id" style="font-size:14px;width:160px">
								{$clsCountry->makeSelectboxOption($country_id, $continent_id)}
							</select>
						</td>
						{/if}
						{if $clsRegion->checkAvailble($country_id) eq '1' and $clsConfiguration->getValue('SiteActive_region')}
						<td class="fieldlabel">{$core->get_Lang('Region')}</td>
						<td class="fieldarea">
							<select class="slb full" name="region_id" style="font-size:14px;width:160px"> 
								{$clsRegion->makeSelectboxOption($country_id,$region_id)}
							</select>
						</td>
						{/if}
					</tr>
					<tr>
						<td class="fieldlabel">{$core->get_Lang('City/Town')}</td>
						<td class="fieldarea">
							<select class="slb full" name="city_id" style="font-size:14px; width:150px">
								{$clsCity->getSelectCity($country_id, $region_id, $city_id)}
							</select>
						</td>
					</tr>
					<tr>
						<td class="fieldlabel">{$core->get_Lang('keyword')}</td>
						<td class="fieldarea" colspan="5">
							<input type="text" class="text full" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
						</td>
					</tr>
				</table>
				<fieldset class="submit-buttons">
					<a class="btn btn-success" href="javascript:void();" id="searchbtn">
						<i class="icon-search icon-white"></i> <span>{$core->get_Lang('search')}</span>
					</a>
					<input type="hidden" name="filter" value="filter" />
				</fieldset>
			</form>
		</div>
	</div>
	<div class="clearfix"><br /></div>
    <div class="hastable">
		{if $allItem[0].area_city_id}
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
						<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="AreaCity" style="display:none">
							<i class="icon-remove icon-white"></i>
							<span>{$core->get_Lang('Delete Options')}</span>
						</a>
					</td>
				</tr>
			</table>
		</div>
		<table cellspacing="0" class="tbl-grid full-width table-striped table_responsive">
			<tr>
				<td class="gridheader"><input id="check_all" type="checkbox" /></td>
				<td style="text-align:left;" class="gridheader"><strong>{$core->get_Lang('nameofareacity')}</strong></td>
                <td class="gridheader" style="width:6%;" align="right"><strong>{$core->get_Lang('Public')}</strong></td>
				<td class="gridheader" style="text-align:center; width:40px;"><strong>{$core->get_Lang('func')}</strong></td>
			</tr>
			<tbody id="SortAble">
				{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].area_city_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].area_city_id}" /></td>
					<td>
						<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].area_city_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} <span style="font-size:15px">{$clsClassTable->getTitle($allItem[i].area_city_id)}</span></strong>
						<div class="clear" style="height:5px;"></div>
						{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
					</td>
					<td style="text-align:center">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="AreaCity" pkey="area_city_id" sourse_id="{$allItem[i].area_city_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].area_city_id)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_online',$allItem[i].area_city_id) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="dropdown">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v"></i>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">
								{if $allItem[i].is_trash eq '0'}

								<li>
									<a class="dropdown-item" 
									href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].area_city_id)}" 
									target="_blank" 
									title="{$core->get_Lang('view')}">
										<i class="icon-eye-open"></i> {$core->get_Lang('view')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('edit')}" 
									href="{$PCMS_URL}/?mod={$mod}&act=edit&area_city_id={$core->encryptID($allItem[i].area_city_id)}">
										<i class="icon-edit"></i> {$core->get_Lang('edit')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('trash')}" 
									href="{$PCMS_URL}/?mod={$mod}&act=trash&area_city_id={$core->encryptID($allItem[i].area_city_id)}{$pUrl}">
										<i class="icon-trash"></i> {$core->get_Lang('trash')}
									</a>
								</li>

								{else}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('restore')}" 
									href="{$PCMS_URL}/?mod={$mod}&act=restore&area_city_id={$core->encryptID($allItem[i].area_city_id)}{$pUrl}">
										<i class="icon-refresh"></i> {$core->get_Lang('restore')}
									</a>
								</li>

								<li>
									<a class="dropdown-item confirm_delete"
									title="{$core->get_Lang('delete')}" 
									href="{$PCMS_URL}/?mod={$mod}&act=delete&area_city_id={$core->encryptID($allItem[i].area_city_id)}{$pUrl}">
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
		{else}{$core->get_Lang('nodata')}{/if}
	</div>
</div>
<script type="text/javascript">
    var country_id = "{$country_id}";
    var area_id = "{$area_id}";
    var city_id = "{$city_id}";
</script>
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
			$.post(path_ajax_script+"/index.php?mod=area_city&act=ajUpdPosSortAreaCity", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/area_city/jquery.hotel.js?v={$upd_version}"></script>