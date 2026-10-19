<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod=tour" title="{$mod}">{$core->get_Lang('tours')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{$core->get_Lang('list')} {$clsTourStore->getTitle($type)}</a>  
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$core->get_Lang('add')} {$clsTourStore->getTitle($type)} <a style="vertical-align:top" title="{$core->get_Lang('addtours')}" href="{$PCMS_URL}/index.php?mod=tour&act=liststore&type={$core->encryptID($type)}" class="btn iso-corner-all btn-warning fileinput-button"> <i class="icon-chevron-left icon-white"></i> <span>{$clsTourStore->getTitle($type)}</span></a></h2>
        <p>{$core->get_Lang('systemmanagementtourstore')}</p>
    </div>
    <div id="isotabs">
		 <ul>
            <li class="tabchild"><a><i class="iso-option"></i> {$core->get_Lang('searchfilter')}</a></li>
        </ul>
	</div>
    <div id="isotabs_content">
		<div class="isotabbox">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="searchbox wrap" style="float:none">
					<table class="form" cellpadding="3" cellspacing="3">
						<tr>
							{if $clsConfiguration->getValue("SiteHasGroup_Tours")}
							<td class="fieldlabel">{$core->get_Lang('tourgroup')}</td>
							<td class="fieldarea">
								<select class="slb" onchange="_reload()" id="slb_TourGroup" tp="Url" name="tour_group_id" style="width:200px">
									{$clsTourGroup->makeSelectboxOption($tour_group_id)}
								</select>
							</td>
							{/if}
							{if $clsConfiguration->getValue('SiteHasDeparturePoint_Tours') eq '1'}
							<td class="fieldlabel">{$core->get_Lang('departurepoint')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="departure_point_id" class="slb" id="slb_Departure_Point" style="width:200px;">
									<option value="0">-- {$core->get_Lang('Departure point')} --</option>
								</select>
							</td>
							{/if}
						</tr>
						<tr>
                        	{if $clsConfiguration->getValue('SiteHasCat_Tours')}
							<td class="fieldlabel">{$core->get_Lang('tourcategory')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="cat_id" class="slb" id="slb_Category" style="width:200px;">
									{$clsTourCat->makeSelectboxOption($tour_group_id, $cat_id)}
								</select>
							</td>
							{/if}
							<td class="fieldlabel">{$core->get_Lang('numberday')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="number_day" class="slb" style="width:200px;">
									 <option value="0">-- {$core->get_Lang('Number days')} --</option>
									 {$clsISO->makeSelectNumber2(30,$number_day)}
								</select>
							</td>
						</tr>
						<tr>
							{if $clsConfiguration->getValue('SiteHasPriceRange_Tours') eq '1'}
							<td class="fieldlabel">{$core->get_Lang('pricerange')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="price_range_id" class="slb" style="width:200px;">
									 {$clsPriceRange->getSelectByPrice($tour_group_id,$price_range_id)}
								</select>
							</td>
							{/if}
							<td class="fieldlabel">{$core->get_Lang('Search')}</td>
							<td class="fieldarea">
								<input style="width:190px" type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
							</td>
						</tr>
					</table>
				</div>
				<div class="mt10"></div>
				<center>
					<div class="group_buttons">
						<a class="btn btn-success" href="javascript:void();" id="searchbtn" >
							<i class="icon-search icon-white"></i> <span>{$core->get_Lang('Search')}</span>
						</a>
						<input type="hidden" name="filter" value="filter" />
						<input type="hidden" name="tour_type_id" value="{$tour_type_id}" />
						<input id="list_selected_chkitem" style="display:none" value="0" />
					</div>
				</center>
            </form>
		</div>
	</div>
    <br class="clearfix" />
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
    <div class="hastable">
    	<table cellspacing="0" class="tbl-grid" width="100%">
            <tr>
                <td class="gridheader"><strong>{$core->get_Lang('id')}</strong></td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameoftrips')}</strong></td>
                <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('duration')}</strong></td>
                 <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('pricefrom')}</strong></td>
                <td class="gridheader" style="text-align:center; "><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            {if $allItem[0].tour_id ne ''}
            {section name=i loop=$allItem}
            <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                <td class="index">{$allItem[i].tour_id}</td>
                <td>
                    <strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].tour_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].tour_id)}</strong>
					{if $clsClassTable->getOneField('is_trash',$allItem[i].tour_id) eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                </td>
                <td class="text-right" style="white-space:nowrap">{$clsClassTable->getTripDuration($allItem[i].tour_id)}</td>
                <td style="text-align:right; white-space:nowrap">
                    <strong class="format_price">{$clsISO->getRateSign()}  {$clsISO->formatNumberToEasyRead($clsClassTable->getOneField('trip_price',$allItem[i].tour_id))}</strong>
                </td>
                <td style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;">
                    <a class="iso-button-action" title="{$core->get_Lang('add')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Add&tour_id={$allItem[i].tour_id}{$pUrl}"><i class="icon-plus-sign icon-white"></i> {$core->get_Lang('add')}</a>
                </td>
            </tr>
            {/section}
            {else}<tr><td colspan="6">{$core->get_Lang('nodata')}</td></tr>{/if}
        </table>
    </div>
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
</div>
<script type="text/javascript">
	var $boxID = "";
	var $tour_group_id = '{$tour_group_id}';
	var $tour_type_id = '{$tour_type_id}';
	var $cat_id = '{$cat_id}';
	var $city_id= '{$city_id}';
	var $departure_point_id= '{$departure_point_id}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js"></script>