<div class="page_container page_review">
    <div class="page-title" style="background: inherit">
        <h2 class="mb0">{$core->get_Lang('reviews')} {if $type ne ''}{$core->get_Lang($type)}{/if}</h2>
    </div>
	<div class="container-fluid">
	<div class="row d-flex flex-wrap">
		<div class="col-lg-4 col-md-6 box-col">
			<div class="box_chart box_white">
				<div class="head_box_chart">
					<h3 class="title_box_chart">{$core->get_Lang("Reviews by month")}</h3>
				</div>
				<div class="box_body_chart d-flex flex-wrap align-items-center">
					<div class="box_chart_month" id="box_chart_month"></div>
				</div>
			</div>
		</div>
		{if $type eq 'tour'}
		<div class="col-lg-4 col-md-6 box-col">
			<div class="box_chart box_white">
				<div class="head_box_chart">
					<h3 class="title_box_chart">{$core->get_Lang("Reviews")}</h3>
				</div>
				<div class="d-flex flex-wrap justify-content-between align-items-center">
					<div class="box_star">
						<p class="score_star">{$totalReviewAvg}</p>
						<p class="txt_review">{$totalReview} {if $totalReview gt 1}{$core->get_Lang('reviews')}{else}{$core->get_Lang('review')}{/if}</p>
						{math equation="x*100/5" x=$totalReviewAvg assign="star_rate"}
						<label class="rate_star block"><span style="width: {$star_rate}%;"></span></label>
					</div>
					<div class="box_chart_tour" id="box_chart_tour"></div>
				</div>

			</div>
		</div>
		{/if}
		{if $type eq 'cruise'}
		<div class="col-lg-4 col-md-6 box-col">
			<div class="box_chart box_white">
				<div class="head_box_chart">
					<h3 class="title_box_chart">{$core->get_Lang("Reviews")}</h3>
				</div>
				<div class="d-flex flex-wrap justify-content-between align-items-center">
					<div class="box_star box_rate">
						<p class="score_star">{$totalReviewAvg}</p>
						<p class="txt_review">{$totalReview} {if $totalReview gt 1}{$core->get_Lang('reviews')}{else}{$core->get_Lang('review')}{/if}</p>
						{math equation="x*100/5" x=$totalReviewAvg assign="star_rate"}
						<label class="rate_star block"><span style="width: {$star_rate}%;"></span></label>
					</div>
					<div class="box_chart_cruise" id="box_chart_cruise"></div>
				</div>

			</div>
		</div>
		{/if}
		{if $type eq 'hotel'}
		<div class="col-lg-4 col-md-6 box-col">
			<div class="box_chart box_white">
				<div class="head_box_chart">
					<h3 class="title_box_chart">{$core->get_Lang("Reviews")}</h3>
				</div>
				<div class="d-flex flex-wrap justify-content-between align-items-center">
					<div class="box_star box_rate">
						<p class="score_star">{$totalReviewAvg}</p>
						<p class="txt_review">{$totalReview} {if $totalReview gt 1}{$core->get_Lang('reviews')}{else}{$core->get_Lang('review')}{/if}</p>
						{math equation="x*100/5" x=$totalReviewAvg assign="star_rate"}
						<label class="rate_star block"><span style="width: {$star_rate}%;"></span></label>
					</div>
					<div class="box_chart_hotel" id="box_chart_hotel"></div>
				</div>
			</div>
		</div>
		{/if}
		{if $type eq 'voucher'}
		<div class="col-lg-4 col-md-6 box-col">
			<div class="box_chart box_white">
				<div class="head_box_chart">
					<h3 class="title_box_chart">{$core->get_Lang("Reviews")}</h3>
				</div>
				<div class="d-flex flex-wrap justify-content-between align-items-center">
					<div class="box_star">
						<p class="score_star">{$totalReviewAvg}</p>
						<p class="txt_review">{$totalReview} {if $totalReview gt 1}{$core->get_Lang('reviews')}{else}{$core->get_Lang('review')}{/if}</p>
						{math equation="x*100/5" x=$totalReviewAvg assign="star_rate"}
						<label class="rate_star block"><span style="width: {$star_rate}%;"></span></label>
					</div>
					<div class="box_chart_voucher" id="box_chart_voucher"></div>
				</div>
			</div>
		</div>
		{/if}		
		<div class="col-lg-4 col-md-6 box-col">
			<div class="box_chart box_white">
				<div class="head_box_chart">
					<h3 class="title_box_chart">{$core->get_Lang("Status")}</h3>
				</div>
				<div class="box_body_chart d-flex flex-wrap align-items-center">
					<div class="box_text_chart">
						<div class="item_chart d-flex justify-content-between">
							<label for="" class="lbl_item_chart public">{$core->get_Lang('Public')}</label>
							<span class="number_item_review">{$totalReviewPublic}</span>
						</div>
						<div class="item_chart d-flex justify-content-between">
							<label for="" class="lbl_item_chart private">{$core->get_Lang('Private')}</label>
							<span class="number_item_review">{$totalReviewPrivate}</span>
						</div>
					</div>
					<div class="relative box_right_chart_all">
						<div class="box_chart_all" id="box_chart_all"></div>
						<div class="box_text_total">
							<p class="number_total">{$totalReview}</p>
							<span class="txt_total">{$core->get_Lang('Reviews')}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
   <div class="wrap">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('Search name, email')}" />
					</div>
					<div class="form-group form-country">
						<select name="rates" class="form-control" data-width="100%">
							<option value="">{$core->get_Lang('Ranking')}</option>
                        	{$clsClassTable->getSelectRankByType($rates,$type)}
						</select>
					</div>
					<div class="form-group form-country">
						<select name="status" class="form-control" data-width="100%">
							<option value="">{$core->get_Lang('Status')}</option>
							<option value="public" {if $status eq 'public'}selected{/if}>{$core->get_Lang('Public')}</option>
							<option value="private" {if $status eq 'private'}selected{/if}>{$core->get_Lang('Private')}</option>
						</select>
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="fr group_buttons">
						<div class="d-flex flex-wrap justify-content-end align-items-center" style="gap:10px">
							<span class="txt_select" id="txt_select">{$core->get_Lang("Choosing")} <span class="number_select" id="number_select">0</span></span>
							<a class="btn_status_review btn btn_new btn_green" data-value="1" clsTable="Reviews" style="display:none;color:#fff"><span>{$core->get_Lang('Public')}</span> </a>
							<a class="btn_status_review btn btn_new btn_orange" data-value="0" clsTable="Reviews" style="display:none;color:#fff"><span>{$core->get_Lang('Private')}</span> </a>
							<a class="btn btn_new btn-delete-all btn_red" id="btn_delete" clsTable="Reviews" style="display:none">
								{$core->get_Lang('Delete')}
							</a>
						</div>
					</div>  
				</form>
			</div>
			<div class="clearfix"></div>
			<input id="list_selected_chkitem" style="display:none" value="0" />
			<div class="statistical mb5">
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="50%" align="left">&nbsp;</td>
						<td width="50%" align="right">
							{$core->get_Lang('Record/page')}:
							{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod,'',$type)}
						</td>
					</tr>
				</table>
			</div>
		</div>
    <div class="box_table_review box_white">
        <table cellspacing="0" class="table tbl-grid table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<th class="gridheader" style="width:40px"><input id="check_all" class="el-checkbox" type="checkbox" /></th>
					<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Name service')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('country')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:center"><strong>{$core->get_Lang('Ranking')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:6%"><strong>{$core->get_Lang('status')}</strong></th>
					<th class="gridheader hiden_responsive"></th>
				</tr>
			</thead>
            <tbody id="SortAble">
				{section name=i loop=$allItem}
				{math equation="x*100/5" x=$allItem[i].rates assign="percent_rate"}
				{assign var=nameServices value=$clsClassTable->getNameService($allItem[i].reviews_id)}
				<tr id="order_{$allItem[i].reviews_id}" class="{cycle values="row1,row2"}">
					<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$allItem[i].reviews_id}" /></td>
					<td class="text-left name_service">
						<div class="box_name_services">
							<p class="txt_name_services"><a href="{$PCMS_URL}/?mod={$mod}&act=edit&type={$type}&reviews_id={$core->encryptID($allItem[i].reviews_id)}" title="{$clsClassTable->getFullname($allItem[i].reviews_id)}">#{$allItem[i].reviews_id}</a> {if $nameServices}- {$nameServices}{/if}</p>
							<p class="txt_info"><span>{$clsClassTable->getFullname($allItem[i].reviews_id)}</span> | <span>{$clsClassTable->getEmail($allItem[i].reviews_id)}</span></p>
							<p class="txt_info">{$core->get_Lang('Update')}: {$clsISO->formatDateTime($allItem[i].upd_date,"d/m/Y H:i",0)}</p>
						</div>
						<button type="button" class="toggle-row inline_block767" style="display:none"> <i class="fa fa-caret fa-caret-down"></i> </button>
					</td>
					<td data-title="{$core->get_Lang('country')}" class="block_responsive">{$clsClassTable->getCountry($allItem[i].reviews_id)}</td>
					<td data-title="{$core->get_Lang('Ranking')}" class="block_responsive" style="text-align:center"><label class="rate_star block"><span style="width: {$percent_rate}%;"></span></label></td>
					<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
						{if $clsClassTable->getOneField('is_online',$allItem[i].reviews_id) eq '1'}
						<span class="status_review public">{$core->get_Lang('Public')}</span>
						{else}
						<span class="status_review private">{$core->get_Lang('Private')}</span>
						{/if}
					</td>
					<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 80px; white-space: nowrap;">
						<div>
							<a href="{$PCMS_URL}/?mod={$mod}&act=edit&type={$type}&reviews_id={$core->encryptID($allItem[i].reviews_id)}" title="{$core->get_Lang('edit')}" class="icon_action edit_review"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
							<path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" fill="#1756C8"/>
							<path d="M19.3375 9.7875C18.6024 7.88603 17.3262 6.24164 15.6668 5.05755C14.0073 3.87347 12.0372 3.20161 10 3.125C7.96283 3.20161 5.99275 3.87347 4.33326 5.05755C2.67377 6.24164 1.39761 7.88603 0.662509 9.7875C0.612863 9.92482 0.612863 10.0752 0.662509 10.2125C1.39761 12.114 2.67377 13.7584 4.33326 14.9424C5.99275 16.1265 7.96283 16.7984 10 16.875C12.0372 16.7984 14.0073 16.1265 15.6668 14.9424C17.3262 13.7584 18.6024 12.114 19.3375 10.2125C19.3872 10.0752 19.3872 9.92482 19.3375 9.7875ZM10 14.0625C9.19652 14.0625 8.41108 13.8242 7.743 13.3778C7.07493 12.9315 6.55423 12.297 6.24675 11.5547C5.93927 10.8123 5.85882 9.99549 6.01557 9.20745C6.17232 8.4194 6.55924 7.69553 7.12739 7.12738C7.69554 6.55923 8.41941 6.17231 9.20745 6.01556C9.9955 5.85881 10.8123 5.93926 11.5547 6.24674C12.297 6.55422 12.9315 7.07492 13.3779 7.743C13.8242 8.41107 14.0625 9.19651 14.0625 10C14.0609 11.0769 13.6323 12.1093 12.8708 12.8708C12.1093 13.6323 11.0769 14.0608 10 14.0625Z" fill="#1756C8"/>
							</svg></a>
							<a href="{$PCMS_URL}/?mod={$mod}&act=delete&reviews_id={$core->encryptID($allItem[i].reviews_id)}{$pUrl}" title="{$core->get_Lang('delete')}" class="icon_action delete_review confirm_delete"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
							<path d="M16.975 7.425L16.1417 8.86667L6.03333 3.03333L6.86667 1.59167L9.4 3.05L10.5333 2.74167L14.1417 4.825L14.45 5.96667L16.975 7.425ZM5 15.8333V5.83333H9.225L15 9.16667V15.8333C15 16.2754 14.8244 16.6993 14.5118 17.0118C14.1993 17.3244 13.7754 17.5 13.3333 17.5H6.66667C6.22464 17.5 5.80072 17.3244 5.48816 17.0118C5.17559 16.6993 5 16.2754 5 15.8333Z" fill="#FF0000"/>
							</svg></a>
						</div>
					</td>
				</tr>
				{/section}
        	</tbody>
		</table>
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
					{if $totalPage gt '1'}
					<td width="50%" align="right">
						{$core->get_Lang('gotopage')}:
						<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
							{section name=i loop=$listPageNumber}
							<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
							{/section}
						</select> 
					</td>
					{/if}
				</tr>
			</table>
		</div>
	</div>
</div>
</div>
<link rel="stylesheet" href="{$URL_CSS}/reviews.css?v={$upd_version}">
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
	var $type = '{$type}';
	var $title_chart_column = '{$core->get_Lang("innings")}';
	var	dataStatus = {$dataStatus};
	var dataMonth = {$dataMonth};
	{if $type eq 'tour'}
		var dataTour = {$dataTour};
	{/if}
	{if $type eq 'voucher'}
		var dataVoucher = {$dataVoucher};
	{/if}
	{if $type eq 'cruise'}
		var dataCruise = {$dataCruise};
	 	/*var dataCruise = [{
				name: 'Du thuyền',
				y: 7.5,
			},
			{
				name: 'Ăn uống',
				y: 8,
			},
			{
				name: 'Cabin',
				y: 7.6,
			},
			{
				name: 'Phục vụ',
				y: 8,
			},
			{
				name: 'Giải trí',
				y: 9,
			},
			{
				name: 'Đáng giá',
				y: 9.8,
			}
		];*/
	{/if}
	{if $type eq 'hotel'}
		var dataHotel = {$dataHotel};
	 	/*var dataHotel = [{
				name: 'Staff',
				y: 7.5,
			},
			{
				name: 'Amenities',
				y: 8,
			},
			{
				name: 'Clean',
				y: 7.6,
			},
			{
				name: 'Place',
				y: 8,
			},
			{
				name: 'Food&Drink',
				y: 9,
			},
			{
				name: 'Worthy',
				y: 9.8,
			}
		];*/
	{/if}
	
</script>
<script src="{$URL_JS}/highchart/highcharts.js?v={$upd_version}"></script>
<script src="{$URL_JS}/reviews.js?v={$upd_version}"></script>
{literal}
<script>
$(document).ready(function(){
	loadChartReviewAll(dataStatus);
	loadChartByColumn({data:dataMonth,color:"#6C7EFA",title:""},'month',false);
	if($type == 'tour'){
		loadChartByColumn(dataTour,'tour');
		loadChartByColumn({data:dataTour,color:"#FFC43D",title:$title_chart_column},'tour');
	}
	if($type == 'voucher'){		
		loadChartByColumn({data:dataVoucher,color:"#FFC43D",title:$title_chart_column},'voucher');
	}
	if($type == 'cruise'){
		loadChartByColumn({data:dataCruise,color:"#FFC43D",title:$title_chart_column},'cruise');
		/*loadChartByLine(dataCruise,'cruise');*/
	}
	if($type == 'hotel'){
		loadChartByColumn({data:dataHotel,color:"#FFC43D",title:$title_chart_column},'hotel');
		/*loadChartByLine(dataHotel,'hotel');*/
	}	
});
</script>
{/literal}