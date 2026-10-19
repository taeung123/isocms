{assign var="title" value="Contact"}
{if $type == "TourInquiry"}
	{assign var="title" value="Tour Inquiry"}
	{assign var="query_string" value="&type=TourInquiry"}
{/if}
<div class="page_container">
	<div class="page-title  d-flex">
        <div class="title">
			<h2>
				{if $is_process ne ''}
					{if $is_process eq 0}{$core->get_Lang("$title Reminding List")}{/if}
					{if $is_process eq 1}{$core->get_Lang("$title Offered List")}{/if}
					{if $is_process eq 2}{$core->get_Lang("$title Reviewed List")}{/if}
				{else}
					{$core->get_Lang("$title List")}
				{/if}
			</h2>
			{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
			<div>
			{if $type == "TourInquiry"}
                <p>{$core->get_Lang("Tour Inquiry Module by VietISO")}</p>
			{elseif $clsConfiguration->getValue($setting) ne ''}
				{$clsConfiguration->getValue($setting)|html_entity_decode}
			{/if}
			</div>
		</div>
    </div>
	<div class="container-fluid">
	<form method="post" id="forums" class="filterForm">
		<div class="wrap fiterbox">
			<div class="group_buttons fl">
				<a href="{$PCMS_URL}/?mod={$mod}{$query_string|default:''}" class="btn btn-success btnNew">
					<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('total')} ({$allItem})</span>
				</a>
				<a href="{$PCMS_URL}/?mod={$mod}&is_process=1{$query_string|default:''}" class="btn btn-success btnNew" style="background:#06C;border-color:#06C">
                    <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('Offered')} ({$number_process})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&is_process=2{$query_string|default:''}" class="btn btn-success btnNew" style="background:#c00000;border-color:#c00000">
                    <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reviewed')} ({$number_reviewed})</span>
                </a>
                <a href="{$PCMS_URL}/?mod={$mod}&is_process=0{$query_string|default:''}" class="btn btn-success btnNew" style="background:#FC0;border-color:#FC0">
                    <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reminding')} ({$number_unprocess})</span>
                </a>
                {if 1 eq 2}
                <a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-danger" title="{$core->get_Lang('settingcontact')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('settingcontact')}</span> </a>
                {/if}
			</div>

			<div id="isotabs" class="export_excel fr">
				 <ul>
					<li class="tabchild"><a><img src="{$URL_IMAGES}/v2/excel.png" style="vertical-align:middle"> {$core->get_Lang('Export')}</a></li>
				</ul>
			</div>
			<a class="btn btn-danger btn-delete-all-new btnNew" clsTable="Feedback" style="display:none;float: right;">
				<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
			</a>
			<div class="clearfix"></div>
			<div id="isotabs_content">
				<div class="isotabbox border_top_1 dateExport" style="display:none">
					<div class="form-group inline-block">
						<div class="span50 fl">
							<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="from_date">
								{$core->get_Lang('From')} <span class="color_r">*</span>
							</label>
							<div class="col-md-9 col-sm-8 col-xs-8">
								<input name="from_date" autocomplete="off" maxlength="10" id="from_date" value="{$clsISO->formatTimeDate($now_day)}" size="15" class="full-width text_32 border_aaa" placeholder="dd/mm/yyyy">
							</div>
						</div>
						<div class="span50 fr">
							<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="to_date">
								{$core->get_Lang('To')} <span class="color_r">*</span>
							</label>
							<div class="col-md-9 col-sm-8 col-xs-8">
								<input name="to_date" autocomplete="off" maxlength="10" id="to_date" value="{$clsISO->formatTimeDate($now_next)}" size="15" class="full-width text_32 border_aaa" placeholder="dd/mm/yyyy">
							</div>
						</div>
					</div>
					<button type="submit" class="buttonExport" id="button_export">{$core->get_Lang('Export')}</button>
					<input type="hidden" name="Export" value="Export" />
				</div> 
			</div> 
		</div>
	</form>
    <div class="clearfix"></div>
    <div class="hastable">
    	<div style="width:100%;">
            <table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive table-layout-fixed">
                <thead>
                	<tr>
						<th class="gridheader" style="width:70px"><input id="check_all" type="checkbox" /></th>
						<th class="gridheader" style="width:80px"><strong>{$core->get_Lang('id')}</strong></th>
						<th class="gridheader text-left" style="width:260px"><strong>{$core->get_Lang("Customer's Contact")}</strong></th>
						<th class="gridheader text-left" style="min-width:150px"><strong>{$core->get_Lang('Special Requests')}</strong></th>
						<th class="gridheader" style="width:150px"><strong>{$core->get_Lang('Reg date')}</strong></th>
						<th class="gridheader" style="width:150px"><strong>{$core->get_Lang('status')}</strong></th>
						<th class="gridheader" style="width:90px"><strong>{$core->get_Lang('action')}</strong></th>
					</tr>
                </thead>                
                {if $listItem[0].feedback_id ne ''}
                {section name=i loop=$listItem}
                {assign var=FEEDBACKVALUE value = $clsISO->getArrayFromString($listItem[i].feedback_store)}
					{assign var="note" value = $FEEDBACKVALUE.Comments|strip_tags|truncate:300}

					<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$listItem[i].feedback_id}" /></td>
					<td class="index">{$listItem[i].feedback_id}</td>
                   	<td class="td_overflow" style="white-space:nowrap">
						<strong>{$listItem[i].title}. {$clsClassTable->getFullName($listItem[i].feedback_id)} </strong>
						<br />
						<i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:{$listItem[i].email}" title="{$listItem[i].email}">{$listItem[i].email}</a>
						<br/>
						<i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+{$listItem[i].phone}" title="{$listItem[i].phone}">{$listItem[i].phone}</a>
						<br />
						{if !empty($FEEDBACKVALUE.countryex_id)}
						<i class="fa fa-globe" aria-hidden="true"></i> <span>{$clsCountry->getTitle($FEEDBACKVALUE.countryex_id)}</span>
						{/if}
					</td>
                    <td class="td_message">{$clsClassTable->getNote($listItem[i].feedback_id)}</td>
					<td class="td_overflow" style="white-space:nowrap; text-align:center">{$clsISO->formatDate($listItem[i].reg_date)}</td>
                    <td align="center" style="text-align:center;white-space:nowrap" >
                        {if $listItem[i].is_process eq '0'}
                        <span class="status_pending">{$core->get_Lang('Reminding')}</span>
                        {elseif $listItem[i].is_process eq '2'}
                        <span class="status_lock">{$core->get_Lang('Reviewed')}</span>
                        {else}
                        <span class="status_approved">{$core->get_Lang('Offered')}</span>
                        {/if}
                    </td>
                    <td style="vertical-align: middle; width:40px; text-align: center; white-space: nowrap;">
                        <div class="btn-group">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li>
									<a title="{$core->get_Lang('view')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&feedback_id={$core->encryptID($listItem[i].feedback_id)}">
										<i class="icon-edit"></i> {$core->get_Lang('view')}
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&feedback_id={$core->encryptID($listItem[i].feedback_id)}">
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
					<a class="btn btn-danger btn-delete-all" clsTable="Feedback" style="display:none">
						<i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
					</a>
				</td>
			</tr>
		</table>
        </div>
    </div>
</div>
<script>
	var urlExport = `{$PCMS_URL}/?mod=export&type=excel_feedback&act={$type}`;
</script>
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
$('.export_excel').click(function() {
	window.open(urlExport);
});
</script>
{/literal}
<link rel="stylesheet" type="text/css"  href="{$URL_JS}/datepicker/jquery-ui.css?ver={$upd_version}"/>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js?v={$upd_version}"></script>