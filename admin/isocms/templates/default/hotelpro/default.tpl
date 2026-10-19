<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('hotels pro')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('hotels')} <a class="btn btn-success createNewHotelPro" href="javascript:void();" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
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
							<select class="slb full" name="country_id" style="font-size:14px; width:160px"> 
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
                        <td class="fieldlabel">{$core->get_Lang('City/Town')}</td>
						<td class="fieldarea">
							<select class="slb full" name="city_id" id="slb_City" style="font-size:14px; width:150px">
								{$clsCity->getSelectCity($country_id, $region_id, $city_id)}
							</select>
						</td>
					</tr>
					<tr>
						<td class="fieldlabel">{$core->get_Lang('Khu vực')}</td>
						<td class="fieldarea">
							 <select class="slb required full" name="area_city_id" id="slb_AreaCity" style="font-size:14px;width:150px"> 
                                {$clsAreaCity->makeSelectboxOption($area_city_id,$city_id)}
                            </select>
						</td>
						<td class="fieldlabel">{$core->get_Lang('rating')}</td>
						<td class="fieldarea">
							<select class="slb slb-full" name="star" style="font-size:14px; width:150px">
								<option selected="selected"> -- {$core->get_Lang('rating')} --</option>
                                {$clsISO->makeSelectNumber2(6,$star,'sao,sao')}
								
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
     <div style="padding:6px; border:1px dashed #F00; margin:10px 0 0; display:none">
    	<img src="{$URL_IMAGES}/warning-20.png" align="absmiddle" /> <strong>Warning:</strong> Những khách sạn được chọn là <strong>Top Hotels</strong> sẽ hiển thị ở trang <strong>Hotel & Resort</strong>. Quản lý <a class="btn iso-button-small" style="color:#FFF !important" href="{$PCMS_URL}?admin&mod=hotelpro&act=hoteltop&fromid=COUNTRY&target_id=1" title="Top Hotels">Top Hotels</a>
    </div>
    <div class="hastable">
		{if $allItem[0].hotel_id}
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;</td>
					<td width="50%" align="right">
						{$core->get_Lang('Record/page')}:
						{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
						<a class="btn btn-danger btn-delete-all" clsTable="Hotel" style="display:none">
							<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
						</a>
					</td>
				</tr>
			</table>
		</div>
		<table cellspacing="0" class="tbl-grid table-striped table_responsive">
			<tr>
				<td class="gridheader"><input id="check_all" type="checkbox" /></td>
				<td style="text-align:left;" class="gridheader"><strong>{$core->get_Lang('nameofhotels')}</strong></td>
                <td class="gridheader" style="width:8%"><strong>{$core->get_Lang('rating')}</strong></td>
                <td class="gridheader" style="width:6%;" align="right"><strong>{$core->get_Lang('Status')}</strong></td>
				<td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('pricefrom')}</strong></td>
				<td class="gridheader" style="text-align:center; width:6%" colspan="2"><b>{$core->get_Lang('move')}</b></td>
				<td class="gridheader" style="text-align:center; width:40px;"><strong>{$core->get_Lang('func')}</strong></td>
			</tr>
			{section name=i loop=$allItem}
            <tr class="{cycle values="row1,row2"}">
                <td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].hotel_id}" /></td>
                <td>
                    <strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].hotel_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} <span style="font-size:15px">{$clsClassTable->getTitle($allItem[i].hotel_id)}</span></strong>
                    <div class="clear" style="height:5px;"></div>
                    <font color="#c00000">{$core->get_Lang('address')}</font> : {$clsClassTable->getAddress($allItem[i].hotel_id)}
                    {if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                </td>
                <td style="text-align:center"><img src="{$clsClassTable->getImageStar($clsClassTable->getStar($allItem[i].hotel_id))}" /></td>
                <td style="text-align:center">
                    <a href="javascript:void(0);" class="SiteClickPublic" clsTable="Hotel" pkey="hotel_id" sourse_id="{$allItem[i].hotel_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].hotel_id)}" title="{$core->get_Lang('Click to change status')}">
                        {if $clsClassTable->getOneField('is_online',$allItem[i].hotel_id) eq '1'}
                        <i class="fa-solid fa-circle-check green"></i>
                        {else}
                       	<i class="fa-solid fa-circle-minus red"></i>
                        {/if}
                    </a>
                </td>
                <td style="text-align:right; white-space:nowrap">
                    <b class="format_price" style="font-size:13px">{$clsClassTable->getPriceAvgAdmin($allItem[i].hotel_id)} </b>
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                        <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=moveup&hotel_id={$allItem[i].hotel_id}{if $country_id}&country_id={$country_id}{/if}{if $city_id}&city_id={$city_id}{/if}"><i class="icon-arrow-up"></i></a>
                        {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                        <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movedown&hotel_id={$allItem[i].hotel_id}{if $country_id}&country_id={$country_id}{/if}{if $city_id}&city_id={$city_id}{/if}"><i class="icon-arrow-down"></i></a>
                        {/if}
                </td>
                <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                    <div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle"
								type="button"
								data-bs-toggle="dropdown"
								aria-expanded="false">
							<i class="fa fa-ellipsis-v"></i>
						</button>

						<ul class="dropdown-menu dropdown-menu-end">

							{if $allItem[i].is_trash eq '0'}

							<li>
								<a class="dropdown-item"
								href="{$DOMAIN_NAME}{$clsClassTable->getLinkPro($allItem[i].hotel_id)}"
								target="_blank"
								title="{$core->get_Lang('view')}">
									<i class="icon-eye-open"></i>
									<span>{$core->get_Lang('view')}</span>
								</a>
							</li>

							<li>
								<a class="dropdown-item"
								title="{$core->get_Lang('edit')}"
								href="{$PCMS_URL}/?mod={$mod}&act=edit&hotel_id={$core->encryptID($allItem[i].hotel_id)}">
									<i class="icon-edit"></i>
									<span>{$core->get_Lang('edit')}</span>
								</a>
							</li>

							<li>
								<a class="dropdown-item"
								title="{$core->get_Lang('trash')}"
								href="{$PCMS_URL}/?mod={$mod}&act=trash&hotel_id={$core->encryptID($allItem[i].hotel_id)}{$pUrl}">
									<i class="icon-trash"></i>
									<span>{$core->get_Lang('trash')}</span>
								</a>
							</li>

							{else}

							<li>
								<a class="dropdown-item"
								title="{$core->get_Lang('restore')}"
								href="{$PCMS_URL}/?mod={$mod}&act=restore&hotel_id={$core->encryptID($allItem[i].hotel_id)}{$pUrl}">
									<i class="icon-refresh"></i>
									<span>{$core->get_Lang('restore')}</span>
								</a>
							</li>

							<li>
								<a class="dropdown-item confirm_delete"
								title="{$core->get_Lang('delete')}"
								href="{$PCMS_URL}/?mod={$mod}&act=delete&hotel_id={$core->encryptID($allItem[i].hotel_id)}{$pUrl}">
									<i class="icon-remove"></i>
									<span>{$core->get_Lang('delete')}</span>
								</a>
							</li>

							{/if}

							{if $clsConfiguration->getValue('SiteHasDuplicate_Hotels')}
							<li>
								<a class="dropdown-item ajDuplicateHotel"
								title="{$core->get_Lang('duplicate')}"
								hotel_id="{$allItem[i].hotel_id}">
									<i class="icon-share"></i>
									<span>{$core->get_Lang('Duplicate')}</span>
								</a>
							</li>
							{/if}

						</ul>
					</div>
                </td>
            </tr>
			{/section}
		</table>
		<div class="cleafix"></div>
		{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
		
		{else}{$core->get_Lang('nodata')}{/if}
	</div>
</div>
<script type="text/javascript">
    var country_id = "1";
    var area_id = "{$area_id}";
    var city_id = "{$city_id}";
	var area_city_id = "{$area_city_id}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/hotelpro/jquery.hotelpro.js?v={$upd_version}"></script>