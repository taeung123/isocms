<div class="page_container">
	<div class="page-title  d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Subscribe management')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách {$core->get_Lang('Subscribe management')} trong hệ thống isoCMS">i</div></h2>
			{if $clsConfiguration->getValue($setting|default:'') ne ''}
			<p>{$clsConfiguration->getValue($setting|default:'')|html_entity_decode}</p>
			{/if}		
		</div>
    </div>
	<div class="container-fluid">
		<div class="filter_box">
			<form id="forums" method="post" action="" name="filter" class="filterForm">				
				<div class="form-group form-keyword">
					<input type="text" class="text form-control" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
					<input type="hidden" name="filter" value="filter">
				</div>	
			</form>
			<div class="fr group_buttons">
				<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning btnNew">
					<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span>
				</a>
				<a href="javascript:void(0)" class="btn btn-success btn-export btnNew">
					<img src="{$URL_IMAGES}/v2/excel.png" style="vertical-align:middle"> {$core->get_Lang('Export')}
				</a>
			</div>
		</div>
		
		<div class="dateExport dateExport2" style="display:none">
			<form class="form-export" method="post" action="">
				<div class="form-group inline-block">
					<div class="span50 fl">
						<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="from_date">
							{$core->get_Lang('From')} <span class="color_r">*</span>
						</label>
						<div class="col-md-9 col-sm-8 col-xs-8">
							<input name="from_date" autocomplete="off" maxlength="10" id="from_date" value="{$clsISO->formatTimeDate($now_day)}" size="15" class="full-width text_32 border_aaa" placeholder="mm/dd/yyyy">
						</div>
					</div>
					<div class="span50 fr">
						<label class="col-md-3 col-sm-4 col-xs-4 control-label title" for="to_date">
							{$core->get_Lang('To')} <span class="color_r">*</span>
						</label>
						<div class="col-md-9 col-sm-8 col-xs-8">
							<input name="to_date" autocomplete="off" maxlength="10" id="to_date" value="{$clsISO->formatTimeDate($now_next)}" size="15" class="full-width text_32 border_aaa" placeholder="mm/dd/yyyy">
						</div>
					</div>
				</div>
				<button type="submit" class="buttonExport" id="button_export">{$core->get_Lang('Export')}</button>
				<input type="hidden" name="Export" value="Export" />
			</form>
		</div>
		<br class="clear" />
		{if $allItem[0].subscribe_id ne ''}
		<table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive table-layout-fixed">
			<thead>
				<tr>
					<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('No.')}</strong></th>
					<th class="gridheader text-left name_responsive full-w767" style="min-width: 150px"><strong>{$core->get_Lang('E-Mail')}</strong></th>
					<th class="gridheader text-right hiden767" style="width:150px"><strong>{$core->get_Lang('Datetime')}</strong></th>
					<th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('Tool')}</strong></th>
				</tr>
			</thead>
			<tbody>
				{section name=i loop=$allItem}
				<tr class="{cycle values="row1,row2"}">
					<td class="index hiden767"> {$smarty.section.i.index+1}</td>
					<td class="name_service title_td1 td_overflow" style="white-space: nowrap"><a href="mailto:{$clsClassTable->getOneField('email',$allItem[i].subscribe_id)}">{$clsClassTable->getOneField('email',$allItem[i].subscribe_id)}</a><button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button></td>
					<td class="block_responsive" data-title="{$core->get_Lang('Datetime')}" style="text-align:center">
						{$clsISO->formatDateTime($allItem[i].reg_date)}
					</td>
					<td class="text-center block_responsive" data-title="{$core->get_Lang('Tool')}" style="white-space: nowrap;">
						<div class="btn-group">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>
							<ul class="dropdown-menu dropdown-menu-end">
								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=delete&subscribe_id={$core->encryptID($allItem[i].subscribe_id)}"
									class="dropdown-item btn-danger confirm_delete"
									title="Xóa hẳn">
										<i class="icon-remove icon-white"></i> <span>Xóa</span>
									</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				{/section}
			</tbody>			
		</table>
		{/if}
		<div class="adminPaging">
			<div class="report">
				{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong>
			</div>
			<ul class="lstAdminPaging">
			{section name=i loop=$listPageNumber}
				<li><a href="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}" {if $listPageNumber[i] eq $currentPage}class="active"{/if}>{$listPageNumber[i]}</a></li>
			{/section}
			</ul>
		</div>
		<a class="iso-button-full" onclick="$('#hide-DIV').slideToggle();">{$core->get_Lang('Click here to view list email')}</a>
		<div id="hide-DIV" class="mt5" style="display:none">
			<textarea style="width:100%; height:60px">{$htmlEmail}</textarea>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
$('#from_date').datepicker({
	dateFormat: "mm/dd/yy", 
 
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
	dateFormat: "mm/dd/yy",
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