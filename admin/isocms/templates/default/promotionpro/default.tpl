<link rel="stylesheet" type="text/css" media="screen" href="{$URL_JS}/datepicker/bootstrap-combined.min.css?v={$upd_version}">
<link rel="stylesheet" type="text/css" media="screen" href="{$URL_JS}/datepicker/bootstrap-datetimepicker.min.css?v={$upd_version}">
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('promotion')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2><span>{$core->get_Lang('List Promotion')}</span></h2>
        <p>{$core->get_Lang('systemmanagementpromotion')}</p>
		<button class="clickInsertPromotion">Insert promotion</button>
    </div>
	<div class="statistical mb5">
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">&nbsp;</td>
				<td width="50%" align="right">
					{$core->get_Lang('Record/page')}:
					{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
					<a class="btn btn-danger btn-delete-all" clsTable="Promotion" style="display:none">
                        <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
                    </a>
				</td>
			</tr>
		</table>
	</div>
    <div class="hastable">
    	<table cellspacing="0" class="tbl-grid" width="100%">
            <tr>
				<td class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></td>
                <td class="gridheader" style="width:60px"><strong>{$core->get_Lang('id')}</strong></td>
				<td class="gridheader" style="text-align:center; width:80px"><strong>{$core->get_Lang('Promotion code')}</strong></td>
				<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Flag text')}</strong></td>
				{*<td class="gridheader" style="text-align:left;"><strong>{$core->get_Lang('Name')}</strong></td>*}
				<td class="gridheader" style="text-align:center; width:120px"><strong>{$core->get_Lang('From date')}</strong></td>
				<td class="gridheader" style="text-align:center; width:120px"><strong>{$core->get_Lang('To date')}</strong></td>
				<td class="gridheader" style="text-align:center; width:120px"><strong>{$core->get_Lang('Travel From')}</strong></td>
				<td class="gridheader" style="text-align:center; width:120px"><strong>{$core->get_Lang('Travel To')}</strong></td>
				<td class="gridheader" style="text-align:center; width:120px"><strong>{$core->get_Lang('Ticket')}</strong></td>
				<td class="gridheader" style="text-align:center; width:100px"><strong>{$core->get_Lang('Promotion')}(%)</strong></td>
				{*{if _IS_AGENT eq 1}*}
				{*<td class="gridheader" style="text-align:center; width:100%"><strong>{$core->get_Lang('Agent - Promotion')}(%)</strong></td>*}
				{*{/if}*}

                <td class="gridheader" style="text-align:center; width:60px"><strong>{$core->get_Lang('Public')}</strong></td>
                <td class="gridheader" style="text-align:center; width:70px "><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            {if $allItem[0].promotion_id ne ''}
            {section name=i loop=$allItem}
            <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].promotion_id}" /></td>
                <td class="index">{$allItem[i].promotion_id}</td>
				<td class="text-center" style="white-space:nowrap">{$clsClassTable->getPromotionCode($allItem[i].promotion_id)}</td>
				<td class="text-left" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsClassTable->getFlagText($allItem[i].promotion_id)}</td>
				{*{if $allItem[i].clsTable eq 'Cruise'}*}
				{*<td class="text-left" style="white-space:nowrap">{$clsCruiseItinerary->getTitleDay($allItem[i].cruise_itinerary_id)}</td>*}
				{*{else}*}
				{*<td class="text-left" style="white-space:nowrap">{$clsClassTable->getTitle($allItem[i].target_id,$allItem[i].clsTable)}</td>*}
				{*{/if}*}
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->formatDateM($clsClassTable->getFromDate($allItem[i].promotion_id))}</td>
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->formatDateM($clsClassTable->getToDate($allItem[i].promotion_id))}</td>
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->formatDateM($clsClassTable->getTravelFromDate($allItem[i].promotion_id))}</td>
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->formatDateM($clsClassTable->getTravelTodate($allItem[i].promotion_id))}</td>
				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsClassTable->getDiscountValue($allItem[i].promotion_id,2)}</td>

				<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsClassTable->getPromotion($allItem[i].promotion_id)}</td>
				{*{if _IS_AGENT eq 1}*}
				{*<td class="text-center" style="white-space:nowrap;background-color: rgba(113, 214, 235, 0.47);">{$clsISO->getRateSign()} {$clsClassTable->getPriceAdsAgent($allItem[i].promotion_id)}</td>*}
				{*{/if}*}

				<td class="text-center" style="white-space:nowrap">
				<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Promotion" pkey="promotion_id" sourse_id="{$allItem[i].promotion_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].promotion_id)}" title="{$core->get_Lang('Click to change status')}">
					{if $clsClassTable->getOneField('is_online',$allItem[i].promotion_id) eq 1}
					<i class="fa-solid fa-circle-check green"></i>
					{else}
					<i class="fa-solid fa-circle-minus red"></i>
					{/if}
				</a>
				</td>
                <td style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;">
                    <div class="btn-group">
						<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> 
						<i class="icon-cog"></i> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" style="right:0px !important">
							{*<li><a href="javascript:void(0);" title="{$core->get_Lang('edit')}" clsTable="{$allItem[i].clsTable}"  promotion_id="{$allItem[i].promotion_id}" target_id="{$allItem[i].target_id}" class="clickEditPromotion"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>*}
							<li><a href="javascript:void(0);" title="{$core->get_Lang('editPro')}" promotion_id="{$allItem[i].promotion_id}" class="clickEditPromotionPro"><i class="icon-edit"></i> <span>{$core->get_Lang('edit Pro')}</span></a></li>
							<li><a href="javascript:void(0);" title="{$core->get_Lang('delete')}" clsTable="{$allItem[i].clsTable}" promotion_id="{$allItem[i].promotion_id}" target_id="{$allItem[i].target_id}" class="clickDeletePromotionAllPro"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
						</ul>
					</div>
                </td>
            </tr>
            {/section}
            {else}<tr><td colspan="6">{$core->get_Lang('nodata')}</td></tr>{/if}
        </table>
    </div>
    <div class="clearfix"></div>
	{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
</div>

<script type="text/javascript" src="{$URL_JS}/datepicker/bootstrap.min.js?v={$upd_version}"> </script>
<script type="text/javascript" src="{$URL_JS}/datepicker/bootstrap-datetimepicker.min.js?v={$upd_version}"> </script>