<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}">{$core->get_Lang('Booking Service')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>
        	{if isset($is_process) && !empty($is_process)}
            	{if $is_process eq 0}{$core->get_Lang('Service Reminding List')}{/if}
                {if $is_process eq 1}{$core->get_Lang('Service Offered List')}{/if}
                {if $is_process eq 2}{$core->get_Lang('Service Reviewed List')}{/if}
          	{else}
            	{$core->get_Lang('Booking Service List')}
            {/if}
        </h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
    </div>
    <div class="clearfix"><br /></div>
	<form method="post" id="forums" class="filterForm">
		<div class="wrap fiterbox">
			<div class="group_buttons fr">
				<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-success">
					<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('total')} ({$totalItem})</span>
				</a>
				<a href="{$PCMS_URL}/?mod={$mod}&is_process=1" class="btn btn-success" style="background:#06C;border-color:#06C">
                    <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('Offered')} ({$number_process})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&is_process=2" class="btn btn-success" style="background:#c00000;border-color:#c00000">
                    <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reviewed')} ({$number_reviewed})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&is_process=0" class="btn btn-success" style="background:#FC0;border-color:#FC0">
                    <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reminding')} ({$number_unprocess})</span>
                </a>
                {if 1 eq 2}
                <a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-danger" title="{$core->get_Lang('settingcontact')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('settingcontact')}</span> </a>
                {/if}
				<a class="btn btn-danger btn-delete-all" clsTable="Booking" type="Service" style="display:none">
					<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete')}</span>
				</a>
				<a href="javascript:void(0)" class="btn btn-success btn-export">
					<img src="{$URL_IMAGES}/v2/excel.png" style="vertical-align:middle"> {$core->get_Lang('Export')}
				</a>
			</div>  
		</div>
		<input type="hidden" name="filter" value="filter" />
	</form>
	<div class="dateExport dateExport2" style="display:none">
		<form class="form-export" method="post" action="">
			<div class="form-group inline-block">
				<div class="span50 fl">
					<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="from_date">
						{$core->get_Lang('From')} <span class="color_r">*</span>
					</label>
					<div class="col-md-9 col-sm-8 col-xs-8">
						<input name="from_date" autocomplete="off" maxlength="10" id="from_date" value="{$clsISO->formatTimeDate($now_day)}" size="15" class="full-width text_32 border_aaa" placeholder="dd/mm/yy">
					</div>
				</div>
				<div class="span50 fr">
					<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="to_date">
						{$core->get_Lang('To')} <span class="color_r">*</span>
					</label>
					<div class="col-md-9 col-sm-8 col-xs-8">
						<input name="to_date" autocomplete="off" maxlength="10" id="to_date" value="{$clsISO->formatTimeDate($now_next)}" size="15" class="full-width text_32 border_aaa" placeholder="dd/mm/yy">
					</div>
				</div>
			</div>
			<button type="submit" class="buttonExport" id="button_export">{$core->get_Lang('Export')}</button>
			<input type="hidden" name="Export" value="Export" />
		</form>
	</div>
    <div class="clearfix"></div>
    <div class="hastable">
    	<div class="table_list_booking">
            <table width="100%" cellspacing="0" class="tbl-grid">
                <tr>
					<td class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></td>
                    <td class="gridheader" style="width:40px"><strong>{$core->get_Lang('id')}</strong></td>
                    <td class="gridheader text-left"><strong>{$core->get_Lang('Fullname')}</strong></td>
                    <td class="gridheader text-left"><strong>{$core->get_Lang('phone')}</strong></td>
                    <td class="gridheader text-left"><strong>{$core->get_Lang('address')}</strong></td>
                    <td class="gridheader text-left"><strong>{$core->get_Lang('Special Requests')}</strong></td>
                    <td class="gridheader text-left"><strong>{$core->get_Lang('email')}</strong></td>
                    <td class="gridheader" style="width:10%"><strong>{$core->get_Lang('status')}</strong></td>
                    <td class="gridheader" style="width:6%"><strong>{$core->get_Lang('action')}</strong></td>
                </tr>

                {if $listItem[0].booking_id ne ''}
                {section name=i loop=$listItem}
                {assign var=BOOKINGEVENTSVALUE value = $clsISO->getArrayFromString($listItem[i].booking_store)}
                <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$listItem[i].booking_id}" /></td>
                    <td class="index">{$listItem[i].booking_id}</td>
                    <td>{$listItem[i].contact_name}</td>
                    <td>{$listItem[i].phone}</td>
                    <td>{$listItem[i].address}</td>
                    <td>{$BOOKINGEVENTSVALUE.message}</td>       
                    <td>{$listItem[i].email}</td>
                    <td align="center" style="text-align:center;" >
                        {if isset($listItem[i].is_process) && $listItem[i].is_process eq '0'}
                        <span class="status_pending">{$core->get_Lang('Reminding')}</span>
                        {elseif isset($listItem[i].is_process) && $listItem[i].is_process eq '2'}
                        <span class="status_lock">{$core->get_Lang('Reviewed')}</span>
                        {else}
                        <span class="status_approved">{$core->get_Lang('Offered')}</span>
                        {/if}
                    </td>
                    <td style="vertical-align: middle; width:40px; text-align: center; white-space: nowrap;">
                        <div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="icon-cog"></i>
							</button>
							<ul class="dropdown-menu dropdown-menu-end">
								<li>
									<a title="{$core->get_Lang('view')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&booking_id={$core->encryptID($listItem[i].booking_id)}" class="dropdown-item">
										<i class="icon-edit"></i> {$core->get_Lang('view')}
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('delete')}" class="confirm_delete dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=delete&booking_id={$core->encryptID($listItem[i].booking_id)}">
										<i class="icon-remove"></i> {$core->get_Lang('delete')}
									</a>
								</li>
							</ul>
						</div>
                    </td>
                </tr>	
                {/section}
                {else}
                <tr>
                    <td colspan="20" style="text-align:center">{$core->get_Lang('nodata')}</td>
                </tr>
                {/if}
            </table>
        </div>
        <div class="clearfix" style="height:5px"></div>
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
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
$('#from_date').datepicker({
	dateFormat: "dd/mm/yy", 
 
	maxDate: "+1Y",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true,
	onSelect: function(dateStr) { 
		var date = $(this).datepicker('getDate'); 
		if(date){ 
			date.setDate(date.getDate() + 30); 
		} 
		$('#to_date').datepicker('option').datepicker('setDate', date); 
	},
	onClose: function(dateText, inst) {
		$('#to_date').focus();
	}
});
$("#to_date").datepicker( { 
	dateFormat: "dd/mm/yy", 
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true
});	
});
</script>
{/literal}
<link rel="stylesheet" type="text/css"  href="{$URL_JS}/datepicker/jquery-ui.css?ver={$upd_version}"/>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js?v={$upd_version}"></script>