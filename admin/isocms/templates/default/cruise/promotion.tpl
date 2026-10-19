<link rel="stylesheet" type="text/css" media="screen" href="{$URL_JS}/datepicker/bootstrap-combined.min.css?v={$upd_version}">
<link rel="stylesheet" type="text/css" media="screen" href="{$URL_JS}/datepicker/bootstrap-datetimepicker.min.css?v={$upd_version}">
<div class="page_container page-tour_setting page-cruise_promotion">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_cruise_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('List Promotion')}</h2>
					<p>{$core->get_Lang('systemmanagementpromotion')}</p>
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew clickInsertPromotion" href="javascript:void(0);" title="Insert promotion">Insert promotion</a>
				</div>
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
				<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
					<thead>
						<tr>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
							<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('id')}</strong></th>
							<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Flag text')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:80px"><strong>{$core->get_Lang('Promotion code')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:120px"><strong>{$core->get_Lang('From date')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:120px"><strong>{$core->get_Lang('To date')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:120px"><strong>{$core->get_Lang('Travel From')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:120px"><strong>{$core->get_Lang('Travel To')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:120px"><strong>{$core->get_Lang('Ticket')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:100px"><strong>{$core->get_Lang('Promotion')}(%)</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:60px"><strong>{$core->get_Lang('Public')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:70px "><strong>{$core->get_Lang('func')}</strong></th>
						</tr>
					</thead>
					{if $allItem[0].promotion_id ne ''}
					{section name=i loop=$allItem}
					<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
						<th class="index" style="width:40px"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].promotion_id}" /></th>
						<td class="index hiden767">{$allItem[i].promotion_id}</td>
						<td class="text-left name_service">{$clsPromotion->getFlagText($allItem[i].promotion_id)}<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button></td>
						<td class="text-center block_responsive" style="white-space:nowrap" data-title="{$core->get_Lang('Promotion code')}">{$clsPromotion->getPromotionCode($allItem[i].promotion_id)}</td>
						<td class="text-center block_responsive" data-title="{$core->get_Lang('From date')}">{$clsISO->formatDateM($clsPromotion->getFromDate($allItem[i].promotion_id))}</td>
						<td class="text-center block_responsive" data-title="{$core->get_Lang('To date')}">{$clsISO->formatDateM($clsPromotion->getToDate($allItem[i].promotion_id))}</td>
						<td class="text-center block_responsive" data-title="{$core->get_Lang('Travel From')}">{$clsISO->formatDateM($clsPromotion->getTravelFromDate($allItem[i].promotion_id))}</td>
						<td class="text-center block_responsive" data-title="{$core->get_Lang('Travel To')}">{$clsISO->formatDateM($clsPromotion->getTravelTodate($allItem[i].promotion_id))}</td>
						<td class="text-center block_responsive" data-title="{$core->get_Lang('Ticket')}">{$clsPromotion->getDiscountValue($allItem[i].promotion_id,2)}</td>

						<td class="text-center block_responsive" data-title="{$core->get_Lang('Promotion')}(%)">{$clsPromotion->getPromotion($allItem[i].promotion_id)}</td>

						<td class="text-center block_responsive" style="white-space:nowrap" data-title="{$core->get_Lang('Public')}">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Promotion" pkey="promotion_id" sourse_id="{$allItem[i].promotion_id}" rel="{$clsPromotion->getOneField('is_online',$allItem[i].promotion_id)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsPromotion->getOneField('is_online',$allItem[i].promotion_id) eq 1}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
						</td>
						<td class="block_responsive" style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;" data-title="{$core->get_Lang('func')}">
							<div class="dropdown">
								<button class="btn btn_dropdown iso-button-standard dropdown-toggle"
										type="button"
										data-bs-toggle="dropdown"
										aria-expanded="false"
										onclick="parentDropdownToggle(this)">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>

								<ul class="dropdown-menu dropdown-menu-end">

									{* 
									<li>
										<a class="dropdown-item clickEditPromotion"
										href="javascript:void(0);"
										title="{$core->get_Lang('edit')}"
										clsTable="{$allItem[i].clsTable}"
										promotion_id="{$allItem[i].promotion_id}"
										target_id="{$allItem[i].target_id}">
											<i class="icon-edit"></i> {$core->get_Lang('edit')}
										</a>
									</li>
									*}

									<li>
										<a class="dropdown-item clickEditPromotionPro"
										href="javascript:void(0);"
										title="{$core->get_Lang('editPro')}"
										promotion_id="{$allItem[i].promotion_id}">
											<i class="icon-edit"></i> {$core->get_Lang('edit Pro')}
										</a>
									</li>

									<li>
										<a class="dropdown-item clickDeletePromotionAllPro"
										href="javascript:void(0);"
										title="{$core->get_Lang('delete')}"
										clsTable="{$allItem[i].clsTable}"
										promotion_id="{$allItem[i].promotion_id}"
										target_id="{$allItem[i].target_id}">
											<i class="icon-remove"></i> {$core->get_Lang('delete')}
										</a>
									</li>

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
	</div>
</div>

<script type="text/javascript" src="{$URL_JS}/datepicker/bootstrap.min.js?v={$upd_version}"> </script>
<script type="text/javascript" src="{$URL_JS}/datepicker/bootstrap-datetimepicker.min.js?v={$upd_version}"> </script>