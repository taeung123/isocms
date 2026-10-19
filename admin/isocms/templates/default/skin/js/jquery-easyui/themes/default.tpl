<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2 class="title-page">{$core->get_Lang('Discount')}</h2>
			{assign var = SiteIntroModule value= 'SiteIntroModule_discount_'|cat:$_LANG_ID}
			<div class="text-multed">{$clsConfiguration->getValue($SiteIntroModule)|html_entity_decode}</div>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew" onClick="open_add_discount(this)" title="{$core->get_Lang('addtours')}">{$clsISO->makeIcon('plus', $core->get_Lang('Add Discount'))}</a></a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<table class="tbl-grid table-iloocal" width="100%" cellpadding="0" cellspacing="0">
				<thead><tr>
					<th class="text-center"><input id="check_all" type="checkbox" class="el-checkbox" /></th>
					<th align="left">{$core->get_Lang('Code')}</th>
					<th align="left">{$core->get_Lang('Name')}</th>
					<th style="width: 116px; text-align: center">{$core->get_Lang('Status')}</th>
					<th class="text-center" style="width: 100px">{$core->get_Lang('Used')}</th>
					<th class="text-right" style="width: 140px">{$core->get_Lang('StartDtae')}</th>
					<th class="text-right" style="width: 140px">{$core->get_Lang('DueDate')}</th>
					<th st  yle="width: 106px; text-align: center">{$core->get_Lang('Function')}</th>
				</tr></thead>
				<tbody id="SortAble">
					{section name=i loop=$allItem}
					<tr style="cursor:move" id="order_{$allItem[i].discount_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
						<td class="index">
							<input name="p_key[]" class="el-checkbox chkitem" type="checkbox" value="{$allItem[i].discount_id}" />
						</td>
						<td></td>
						<td>{if $allItem[i].discount_rule eq 'code'}
								CUPON:{$clsClassTable->getCode($allItem[i].discount_id)}
							{else}
								CTKM: {$allItem[i].title}
							{/if}
							{if $allItem[i].is_trash eq '1'}
							<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>
							{/if}
						</td>
						<td class="text-center">{$clsClassTable->getStatus($allItem[i].discount_id)}</td>
						<td class="text-center">{$allItem[i].total_used}</td>
						<td class="text-center">{$allItem[i].start_date|date_format:"%d/%m/%Y %H:%M"}</td>
						<td class="text-center">{if $allItem[i].is_due_date eq '1'} {$allItem[i].due_date|date_format:"%d/%m/%Y %H:%M"}{else}-{/if}</td>
						<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown">
									<i class="icon-cog"></i> 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" style="right:0px !important">
									{if $allItem[i].is_trash eq '0'}
										<li><a title="{$core->get_Lang('Edit')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&discount_id={$allItem[i].discount_id}"><i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span></a></li>
										<li><a class="confirm_delete" title="{$core->get_Lang('Trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&discount_id={$allItem[i].discount_id}{$pUrl}&page={$currentPage}"><i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span></a>
									</li>
									{*<li><a title="Edit" class="btn btn-xs btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit&discount_id={$allItem[i].discount_id}"><i class="icon-edit icon-white"></i></a></li>
									<li><a title="Move Trash" class="btn btn-xs btn-warning confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=trash&discount_id={$allItem[i].discount_id}"><i class="icon-trash icon-white"></i></a></li>*}
									{else}
									<li><a title="{$core->get_Lang('Refresh')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&discount_id={$allItem[i].discount_id}{$pUrl}&page={$currentPage}"><i class="icon-refresh"></i> <span>{$core->get_Lang('Refresh')}</span></a></li>
									<li><a title="{$core->get_Lang('Delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&discount_id={$allItem[i].discount_id}{$pUrl}&page={$currentPage}"><i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span></a></li>
									{/if}
								</ul>
							</div>
						</td>
					</tr>
					{/section}
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript" src="{$URL_IMAGES}/jquery-easyui/"