<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{$core->get_Lang('quickbookingmanagement')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>
        	{if $status ne ''}
            	{if $status eq 0}{$core->get_Lang('Quick Booking Reminding List')}{/if}
                {if $status eq 1}{$core->get_Lang('Quick Booking Offered List')}{/if}
                {if $status eq 2}{$core->get_Lang('Quick Booking Reviewed List')}{/if}
          	{else}
            	{$core->get_Lang('Quick Booking List')}
            {/if}
        </h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
    </div>
	<div class="clearfix"></div>
	<form id="forums" method="post" action="" name="filter" class="filterForm">
		<div class="filterbox">
			<div class="wrap">
				<div class="searchbox">
					<input type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
					<a class="btn btn-success" href="javascript:void();" id="searchbtn" style="padding:6px">
						<i class="icon-search icon-white"></i>
					</a>
				</div>
				<div class="group_buttons fr">
					<a href="{$PCMS_URL}/?mod={$mod}&act=quick_booking" class="btn btn-warning">
						<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$totalItem})</span>
					</a>
					<a href="{$PCMS_URL}/?mod={$mod}&act=quick_booking&status=1" class="btn btn-success" style="background:#06C;border-color:#06C">
						<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('Offered')} ({$number_process})</span>
					</a>
                    <a href="{$PCMS_URL}/?mod={$mod}&act=quick_booking&status=2" class="btn btn-success" style="background:#c00000;border-color:#c00000">
						<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reviewed')} ({$number_reviewed})</span>
					</a>
					<a href="{$PCMS_URL}/?mod={$mod}&act=quick_booking&status=0" class="btn btn-success" style="background:#FC0;border-color:#FC0">
						<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Reminding')} ({$number_unprocess})</span>
					</a>
				</div>
			</div>
		</div>
	</form>
    <br />
    <div class="hastable">
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
        <div style="width:100%; ">
            <table cellspacing="0" class="tbl-grid" width="100%">
                <tr>
                    <td class="gridheader" style="width:40px"><strong>{$core->get_Lang('id')}</strong></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Type')}</strong></td>
                    <td class="gridheader" style="width:8%;white-space:nowrap"><strong>{$core->get_Lang('Departure In')}</strong></td>
                    <td class="gridheader" style="width:8%;white-space:nowrap"><strong>{$core->get_Lang('Departure Out')}</strong></td>
                    <td class="gridheader" style="white-space:nowrap"><strong>{$core->get_Lang('Name of Hotel')}</strong></td>   
                    <td class="gridheader" style="white-space:nowrap"><strong>{$core->get_Lang('Name of Room')}</strong></td>   
                    <td class="gridheader" style="white-space:nowrap"><strong>{$core->get_Lang('Quanlity Room')}</strong></td>
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Full Name')}</strong></td>
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('phone')}</strong></td>
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Special Requests')}</strong></td>
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('email')}</strong></td>
                    <td class="gridheader" style="width:10%"><strong>{$core->get_Lang('status')}</strong></td>
                    <td class="gridheader" style="width:6%"><strong>{$core->get_Lang('action')}</strong></td>
                </tr>
                <tbody>
                    {section name=i loop=$listItem}
                    
                    <tr {if $smarty.section.i.index%2 eq '0'}class="row1"{else}class="row2"{/if}>
                        <td class="index" style="white-space:nowrap">{$listItem[i].booking_room_id}</td>
                        <td style="white-space:nowrap">{$clsClassTable->getType($listItem[i].booking_room_id)}</td>
                        <td class="text-right">{$clsClassTable->getDepartureIn($listItem[i].booking_room_id)}</td>
                        <td style="white-space:nowrap" class="text-right">{$clsClassTable->getDepartureOut($listItem[i].booking_room_id)}</td>
                        <td style="white-space:nowrap">{$clsClassTable->getHotelName($listItem[i].booking_room_id)}</td>
                        <td style="white-space:nowrap">{$clsClassTable->getHotelRoomName($listItem[i].booking_room_id)}</td>
                        <td style="white-space:nowrap; text-align:right">{$clsClassTable->getNumberRoom($listItem[i].booking_room_id)}</td>
                        <td style="white-space:nowrap">{$clsClassTable->getFullName($listItem[i].booking_room_id)}</td>
                        <td style="white-space:nowrap">{$clsClassTable->getPhone($listItem[i].booking_room_id)}</td>
                        <td style="width:300px">{$clsClassTable->getIntro($listItem[i].booking_room_id)}</td>
                        <td><a href="mailto:{$clsClassTable->getEmail($listItem[i].booking_room_id)}" title="{$core->get_Lang('clicksendemail')}">{$clsClassTable->getEmail($listItem[i].booking_room_id)}</a></td>
                        <td>
                            {if $listItem[i].status eq '0'}
                            <span class="status_pending">{$core->get_Lang('Reminding')}</span>
                            {elseif $listItem[i].status eq '2'}
                            <span class="status_lock">{$core->get_Lang('Reviewed')}</span>
                            {else}
                            <span class="status_approved">{$core->get_Lang('Offered')}</span>
                            {/if}
                        </td>
                        <td style="vertical-align: top; text-align: right; white-space: nowrap; width:5%"> 
                            <div class="btn-group">
                                <button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="icon-cog"></i> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" style="right:0px !important">
                                   <li><a href="{$PCMS_URL}/?mod={$mod}&action=quick_booking&type={$type}&act=edit&booking_room_id={$core->encryptID($listItem[i].booking_room_id)}" title="{$core->get_Lang('viewbooking')}"><i class="icon-edit"></i> {$core->get_Lang('viewbooking')}</a></li>
                                    <li><a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_room_id={$core->encryptID($listItem[i].booking_room_id)}" title="{$core->get_Lang('delete')}"><i class="icon-print"></i> {$core->get_Lang('print')}</a></li>
                                    <li><a class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=delete&booking_id={$core->encryptID($listItem[i].booking_id)}" title="{$core->get_Lang('delete')}"><i class="icon-remove"></i> {$core->get_Lang('delete')}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    {/section}
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
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
    </div>
</div>