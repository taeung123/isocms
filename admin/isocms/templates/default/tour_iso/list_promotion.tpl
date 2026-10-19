<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod=tour" title="{$mod}">{$core->get_Lang('tours')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{$core->get_Lang('List of promotion tour')} {$clsTourStore->getTitle($type)}</a>  
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2><i class="icon-chevron-left icon-white"></i> <span>{$core->get_Lang('List of promotion tour')}</span></a></h2>
        <p>{$core->get_Lang('systemmanagementtourstore')}</p>
    </div>
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
				<td class="gridheader"><input id="check_all" type="checkbox" /></td>
                <td class="gridheader"><strong>{$core->get_Lang('id')}</strong></td>
				<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Promotion code')}</strong></td>
				<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('From date')}</strong></td>
				<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('To date')}</strong></td>
                <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Name of trips')}</strong></td>
                <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Duration')}</strong></td>
                <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Travel style')}</strong></td>
				<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Ads price')}</strong></td>
				{if _IS_AGENT eq 1}
				<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Agent - Ads price')}</strong></td>
				{/if}
                <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Flag text')}</strong></td>
                <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Public')}</strong></td>
                <td class="gridheader" style="text-align:center; "><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            {if $allItem[0].hot_promotion_id ne ''}
            {section name=i loop=$allItem}
			{if $clsTourStore->checkExist($allItem[i].target_id,PROMOTION)}
            <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].hot_promotion_id}" /></td>
                <td class="index">{$allItem[i].hot_promotion_id}</td>
				<td class="text-center" style="white-space:nowrap">{$clsClassTable->getPromotionCode($allItem[i].hot_promotion_id)}</td>
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->formatTimeDateEn($clsClassTable->getFromDate($allItem[i].hot_promotion_id))}</td>
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->formatTimeDateEn($clsClassTable->getToDate($allItem[i].hot_promotion_id))}</td>
                <td>
                   {$clsTour->getTitle($allItem[i].target_id)}
                </td>
				<td class="text-center" style="white-space:nowrap">{$clsTour->getTripDuration($allItem[i].target_id)}</td>
				{assign var=cattour_id value=$clsTour->getOneField('cat_id',$allItem[i].target_id)}
                <td class="text-center" style="white-space:nowrap">{$clsTourCategory->getTitle($cattour_id)}</td>
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->getRateSign()} {$clsClassTable->getPriceAds($allItem[i].hot_promotion_id)}</td>
				{if _IS_AGENT eq 1}
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->getRateSign()} {$clsClassTable->getPriceAdsAgent($allItem[i].hot_promotion_id)}</td>
				{/if}
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsClassTable->getFlagText($allItem[i].hot_promotion_id)}</td>
				<td class="text-center" style="white-space:nowrap">
				<a href="javascript:void(0);" class="SiteClickPublic" clsTable="HotPromotion" pkey="hot_promotion_id" sourse_id="{$allItem[i].hot_promotion_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].hot_promotion_id)}" title="{$core->get_Lang('Click to change status')}">
					{if $clsClassTable->getOneField('is_online',$allItem[i].hot_promotion_id) eq 1}
					<i class="fa-solid fa-circle-check green"></i>
					{else}
					<i class="fa-solid fa-circle-minus red"></i>
					{/if}
				</a>
				</td>
                <td style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;">
                    <div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle"
							type="button"
							data-bs-toggle="dropdown"
							aria-expanded="false">
							<i class="icon-cog"></i>
						</button>

						<ul class="dropdown-menu dropdown-menu-end">
							<li>
								<a class="dropdown-item"
								href="{$DOMAIN_NAME}{$clsTour->getLink($allItem[i].target_id)}"
								target="_blank"
								title="{$core->get_Lang('view')}">
									<i class="icon-eye-open"></i> {$core->get_Lang('view')}
								</a>
							</li>

							<li>
								<a class="dropdown-item clickEditHotPromotion"
								href="javascript:void(0)"
								title="{$core->get_Lang('edit')}"
								hot_promotion_id="{$allItem[i].hot_promotion_id}"
								target_id="{$allItem[i].target_id}">
									<i class="icon-edit"></i> {$core->get_Lang('edit')}
								</a>
							</li>

							<li>
								<a class="dropdown-item clickDeleteHotPromotion"
								href="javascript:void(0)"
								title="{$core->get_Lang('delete')}"
								hot_promotion_id="{$allItem[i].hot_promotion_id}"
								target_id="{$allItem[i].target_id}">
									<i class="icon-remove"></i> {$core->get_Lang('delete')}
								</a>
							</li>
						</ul>
					</div>
                </td>
            </tr>
			{/if}
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